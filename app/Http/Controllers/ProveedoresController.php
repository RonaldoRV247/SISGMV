<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Proveedores;
use Barryvdh\DomPDF\Facade\Pdf;
use Datatables;

class ProveedoresController extends Controller
{
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(Proveedores::select('*'))
            ->addColumn('action', 'proveedores-action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('proveedores');
    }

    public function store(Request $request)
    {  
        $validator = Validator::make($request->all(), [
            'ruc' => 'required|unique:proveedores,ruc,' . $request->id,
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Ya existe un proveedor con ese RUC. Por favor, ingresa un RUC diferente.'
            ], 422);
        };

        $proveedoresId = $request->id;

        $proveedores   =   Proveedores::updateOrCreate(
                    [
                    'id' => $proveedoresId
                    ],
                    [
                    'ruc' => $request->ruc, 
                    'nombre' => $request->nombre
                    ]);    

        return Response()->json($proveedores);
    }

    public function edit(Request $request)
    {   
        $where = array('id' => $request->id);
        $proveedores  = Proveedores::where($where)->first();

        return Response()->json($proveedores);
    }

    public function destroy(Request $request)
    {
        $proveedores = Proveedores::where('id',$request->id)->delete();

        return Response()->json($proveedores);
    }
    public function print(){
        $proveedores = Proveedores::all();
        $pdf = PDF::loadView('reports.proveedores_report', compact('proveedores'))->setPaper('a4');
        $pdfPath = public_path('proveedores_report.pdf');
        $pdf->save($pdfPath);

        return response()->json(['url' => url('proveedores_report.pdf')]);
    }
}