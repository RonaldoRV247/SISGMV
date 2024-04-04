<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Reparaciones;
use Barryvdh\DomPDF\Facade\Pdf;
use Datatables;

class ReparacionesController extends Controller
{
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(Reparaciones::select('*'))
            ->addColumn('action', 'reparaciones-action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('reparaciones');
    }

    public function store(Request $request)
    { 
        $validator = Validator::make($request->all(), [
            'elemento' => 'required|unique:reparaciones,elemento,' . $request->id,
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Ya está registrado este elemento. Por favor, ingresa uno diferente.'
            ], 422);
        };

        $reparacionesId = $request->id;

        $reparaciones   =   Reparaciones::updateOrCreate(
                    [
                    'id' => $reparacionesId
                    ],
                    [
                    'elemento' => $request->elemento
                    ]);    

        return Response()->json($reparaciones);
    }

    public function edit(Request $request)
    {   
        $where = array('id' => $request->id);
        $reparaciones  = Reparaciones::where($where)->first();

        return Response()->json($reparaciones);
    }

    public function destroy(Request $request)
    {
        $reparaciones = Reparaciones::where('id',$request->id)->delete();

        return Response()->json($reparaciones);
    }
    public function print(){
        $reparaciones = Reparaciones::all();
        $pdf = PDF::loadView('reports.reparaciones_report', compact('reparaciones'))->setPaper('a4');
        $pdfPath = public_path('reparaciones_report.pdf');
        $pdf->save($pdfPath);

        return response()->json(['url' => url('reparaciones_report.pdf')]);
    }
}