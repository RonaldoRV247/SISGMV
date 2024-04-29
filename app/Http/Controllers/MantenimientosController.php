<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Mantenimientos;
use App\Models\Vehiculos;
use App\Models\Proveedores;
use App\Models\Reparaciones;
use App\Models\Detalles_Mantenimiento;
use App\Models\Categorias;
use Datatables;
use Barryvdh\DomPDF\Facade\Pdf;

class MantenimientosController extends Controller
{
    public function index()
    {
        $proveedores = Proveedores::all();
        $reparaciones = Reparaciones::all();
        $categorias = Categorias::with('reparaciones')->get();
        
        $vehiculos = Vehiculos::all();
        if(request()->ajax()) {
            return datatables()->of(DB::table('mantenimientos')
            ->join('proveedores', 'mantenimientos.proveedores_id', '=', 'proveedores.id')
            ->join('vehiculos', 'mantenimientos.vehiculos_id', '=', 'vehiculos.id')
            ->select('mantenimientos.id', 'mantenimientos.tipo', 'mantenimientos.expediente', 'mantenimientos.fecha_requerimiento', 'mantenimientos.fecha_conformidad_servicio', 'mantenimientos.fecha_ingreso_taller', 'mantenimientos.fecha_salida_taller','mantenimientos.km_mantenimiento', 
            DB::raw('CONCAT(COALESCE(vehiculos.unidad, ""), " ", COALESCE(vehiculos.marca, ""), " ", COALESCE(vehiculos.modelo, ""), " - PLACA: ", COALESCE(vehiculos.placa, "")) as vehiculox'), 
            DB::raw('CONCAT("RUC: ", COALESCE(proveedores.ruc, ""), " ", COALESCE(proveedores.nombre, "")) as proveedorx'))
        ->get())
            ->addColumn('action', 'mantenimientos-action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('mantenimientos',compact('proveedores','vehiculos','reparaciones','categorias'));
    }
    public function store(Request $request)
    {  
        $validator = Validator::make($request->all(), [
            'expediente' => 'required|unique:mantenimientos,expediente,' . $request->id,
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Ya existe un mantenimiento registrado con ese expediente. Por favor, ingresa uno diferente.'
            ], 422);
        };
            // Obtener el vehículo relacionado
        $vehiculo = Vehiculos::find($request->vehiculos_id); 
    
    // Obtener el mantenimiento existente si existe
    $mantenimientos = Mantenimientos::find($request->id);
    $kmMantenimientoActual = $mantenimientos ? $mantenimientos->km_mantenimiento : null;
        // Verificar si hay mantenimientos previos para el vehículo dado
        $mantenimientosPasados = Mantenimientos::where('vehiculos_id', $request->vehiculos_id)
        ->where('id', '!=', $request->id) // Excluir el mantenimiento actual
        ->where('fecha_requerimiento', '<', now())
        ->exists();

        // Verificar reparaciones realizadas solo si hay mantenimientos pasados
        // Inicializar las variables fuera del bloque condicional
        $reparacionesRealizadas = [];
        $infoMantenimientosPasados = [];

        if ($mantenimientosPasados) {
            $reparacionesIds = array_keys($request->precios);
            // Obtener los datos solo si hay mantenimientos pasados
            $datos = $this->obtenerInfoReparacionesYMantenimientosPasados($request->vehiculos_id, $reparacionesIds, $request->id);
            $reparacionesRealizadas = $datos['reparacionesRealizadas'];
            $infoMantenimientosPasados = $datos['infoMantenimientosPasados'];
        }

    // Validar si el km_mantenimiento en el request es diferente al actual
    if ($request->has('km_mantenimiento') && $request->km_mantenimiento != $kmMantenimientoActual) {
        // Verificar si el km_mantenimiento es menor que el km actual del vehículo
        if ($request->km_mantenimiento < $vehiculo->km) {
            // Si el km_mantenimiento es menor que el km actual del vehículo, devolver un error
            return response()->json([
                'message' => 'El kilometraje del nuevo mantenimiento no puede ser menor que el km actual del vehículo.'
            ], 422);
        }
    }
        $mantenimientosId = $request->id;
        $mantenimientos = Mantenimientos::updateOrCreate(
            [
                'id' => $mantenimientosId
            ],
            [
                'tipo' => $request->tipo,
                'expediente' => $request->expediente,
                'fecha_requerimiento' => $request->fecha_requerimiento,
                'fecha_conformidad_servicio' => $request->fecha_conformidad_servicio,
                'fecha_ingreso_taller' => $request->fecha_ingreso_taller,
                'fecha_salida_taller' => $request->fecha_salida_taller,
                'km_mantenimiento' => $request->km_mantenimiento,
                'vehiculos_id' => $request->vehiculos_id,
                'proveedores_id' => $request->proveedores_id,
            ]
        );
            // Actualizar la columna km de vehículos
    // Actualizar la columna km con el valor de km_mantenimiento
        $vehiculo->km = $request->km_mantenimiento;
        // Guardar los cambios
        $vehiculo->save();
        // Obtener los detalles de mantenimiento actuales
        $existingDetalles = $mantenimientos->detallesMantenimiento()->pluck('reparaciones_id')->toArray();
        $selectedReparaciones = array_keys($request->precios);
        // Identificar detalles de mantenimiento a eliminar
        $detallesToDelete = array_diff($existingDetalles, $selectedReparaciones);
        
        // Eliminar los detalles de mantenimiento que coincidan
        if (!empty($detallesToDelete)) {
            Detalles_Mantenimiento::where('mantenimientos_id', $mantenimientos->id)
                ->whereIn('reparaciones_id', $detallesToDelete)
                ->delete();
        }
        // Identificar detalles de mantenimiento a crear o actualizar
        foreach ($request->precios as $reparacion_id => $costo) {
            $descripcion = $request->descripcion[$reparacion_id] ?? ''; // Obtén la descripción o cadena vacía si no se proporciona
            Detalles_Mantenimiento::updateOrCreate(
                ['reparaciones_id' => $reparacion_id, 'mantenimientos_id' => $mantenimientos->id],
                ['costo' => $costo, 'descripcion' => $descripcion]
            );
        }
        // Enviar solo los datos si existen
        return response()->json([
            'mantenimientos' => $mantenimientos,
            // Enviar reparaciones realizadas y nombres de reparaciones solo si hay mantenimientos pasados
            'reparacionesRealizadas' => $mantenimientosPasados ? $reparacionesRealizadas : [],
            'nombresReparaciones' => $mantenimientosPasados ? Reparaciones::whereIn('id', $reparacionesRealizadas)->pluck('elemento')->toArray() : [],
            'infoMantenimientosPasados' => $mantenimientosPasados ? $infoMantenimientosPasados : [],
        ]);

    }
    private function obtenerInfoReparacionesYMantenimientosPasados($vehiculoId, $reparacionesIds, $mantenimientoId)
    {
        // Obtener los IDs de los mantenimientos pasados para el vehículo dado, excluyendo el mantenimiento actual
        $mantenimientosPasadosIds = Mantenimientos::where('vehiculos_id', $vehiculoId)
            ->where('id', '!=', $mantenimientoId) // Excluir el mantenimiento actual
            ->where('fecha_requerimiento', '<', now())
            ->pluck('id');
        
        // Obtener las reparaciones realizadas previamente en los mantenimientos pasados
        $reparacionesRealizadas = Detalles_Mantenimiento::whereIn('mantenimientos_id', $mantenimientosPasadosIds)
            ->whereIn('reparaciones_id', $reparacionesIds)
            ->pluck('reparaciones_id')
            ->unique()
            ->toArray();
    
        // Obtener la información relevante de los mantenimientos pasados
        $infoMantenimientosPasados = Mantenimientos::whereIn('id', $mantenimientosPasadosIds)
            ->with('detallesMantenimiento.reparacion')
            ->get()
            ->flatMap(function ($mantenimiento) use ($reparacionesIds) {
                return $mantenimiento->detallesMantenimiento
                    ->filter(function ($detalle) use ($reparacionesIds) {
                        return in_array($detalle->reparacion->id, $reparacionesIds);
                    })
                    ->map(function ($detalle) use ($mantenimiento) {
                        return [
                            'fecha_requerimiento' => $mantenimiento->fecha_requerimiento,
                            'tipo' => $mantenimiento->tipo,
                            'expediente' => $mantenimiento->expediente,
                            'reparacion' => $detalle->reparacion->elemento,
                        ];
                    });
            });
    
        return [
            'reparacionesRealizadas' => $reparacionesRealizadas,
            'infoMantenimientosPasados' => $infoMantenimientosPasados,
        ];
    }
    
    public function edit(Request $request)
    {   
        $mantenimientos  = Mantenimientos::with('detallesMantenimiento')->find($request->id);
        return Response()->json($mantenimientos);
    }
    public function destroy(Request $request)
{
    $mantenimiento = Mantenimientos::find($request->id);
    // Eliminar los detalles de mantenimiento asociados
    $mantenimiento->detallesMantenimiento()->delete();
    // Eliminar el mantenimiento
    $mantenimiento->delete();
    return response()->json(['success' => true]);
}

public function print(Request $request)
{
    $mantenimiento = Mantenimientos::findOrFail($request->id);
    $pdf = PDF::loadView('reports.mantenimientos_report', compact('mantenimiento'))->setPaper('a4');
    // Guarda el PDF temporalmente
    $pdfPath = public_path('mantenimientos_report.pdf');
    $pdf->save($pdfPath);
    // Devuelve la URL del PDF
    return response()->json(['url' => url('mantenimientos_report.pdf')]);
}
public function printgen() {
    $mantenimientos = Mantenimientos::all();
    $pdf = PDF::loadView('reports.mantenimientos_report_gen', compact('mantenimientos'))->setPaper('a4','landscape');
    // Guarda el PDF temporalmente
    $pdfPath = public_path('mantenimientos_report_gen.pdf');
    $pdf->save($pdfPath);
    // Devuelve la URL del PDF
    return response()->json(['url' => url('mantenimientos_report_gen.pdf')]);
}
}