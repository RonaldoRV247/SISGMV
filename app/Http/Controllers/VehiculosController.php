<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Vehiculos;
use App\Models\Personas;
use App\Models\Mantenimientos;
use Barryvdh\DomPDF\Facade\Pdf;
use Datatables;

class VehiculosController extends Controller
{

    public function index()
    {
        $personas = Personas::all();
        
        if(request()->ajax()) {
            return datatables()->of(DB::table('vehiculos')
                ->leftjoin('personas', 'vehiculos.personas_id', '=', 'personas.id')
                ->select('vehiculos.id', 'vehiculos.placa', 'vehiculos.unidad', 'vehiculos.marca', 'vehiculos.modelo','vehiculos.motor', 'vehiculos.anio', 'vehiculos.km', 'vehiculos.carga_util_kg', DB::raw('CONCAT(personas.nombre, " ", personas.apellidos) as encargado'))
                ->get())
                ->addColumn('estado', function ($vehiculo) {
                    return $this->calcularEstado($vehiculo->id);
                })
                ->addColumn('action', 'vehiculos-action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('vehiculos', compact('personas'));
    }
    private function calcularEstado($vehiculoId)
    {
        $vehiculo = Vehiculos::with('mantenimientos')->find($vehiculoId);
        $ultimoMantenimiento = $vehiculo->mantenimientos->last();
        if (!$ultimoMantenimiento) {
            return 'Sin Mantenimiento - Disponible';
        }
    
        if ($ultimoMantenimiento->fecha_conformidad_servicio) {
            return 'Mantenimiento completo - Disponible';
        }
    
        if ($ultimoMantenimiento->fecha_ingreso_taller || $ultimoMantenimiento->fecha_salida_taller) {
            return 'En mantenimiento - Ocupado';
        }
    
        return 'Sin mantenimiento - Disponible';
    }
    public function store(Request $request)
    {  
        $validator = Validator::make($request->all(), [
            'placa' => 'required|unique:vehiculos,placa,' . $request->id,
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Ya existe un vehiculo con esa placa. Por favor, ingresa una placa diferente.'
            ], 422);
        };
        $vehiculosId = $request->id;

        $vehiculos   =   Vehiculos::updateOrCreate(
                    [
                    'id' => $vehiculosId
                    ],
                    [
                    'placa' => $request->placa,
                    'unidad' => $request->unidad,
                    'marca' => $request->marca,
                    'modelo' => $request->modelo,
                    'motor' => $request->motor,
                    'anio' => $request->anio,
                    'km' => $request->km,
                    'carga_util_kg' => $request->carga_util_kg,
                    'personas_id' => $request->personas_id,
                    ]);    

        return Response()->json($vehiculos);
        
    }

    public function edit(Request $request)
    {   
        $where = array('id' => $request->id);
        $vehiculos  = Vehiculos::where($where)->first();

        return Response()->json($vehiculos);
    }

    public function destroy(Request $request)
    {
        $vehiculos = Vehiculos::where('id',$request->id)->delete();

        return Response()->json($vehiculos);
    }
    public function print()
    {
        $vehiculos = Vehiculos::with('personas')->get();

        foreach ($vehiculos as $vehiculo) {
            $vehiculo->estado = $this->calcularEstado($vehiculo->id);
        }

        $pdf = PDF::loadView('reports.vehiculos_report', compact('vehiculos'))->setPaper('a4', 'landscape');
        $pdfPath = public_path('vehiculos_report.pdf');
        $pdf->save($pdfPath);

        // Devuelve la URL del PDF
        return response()->json(['url' => url('vehiculos_report.pdf')]);
    }
}