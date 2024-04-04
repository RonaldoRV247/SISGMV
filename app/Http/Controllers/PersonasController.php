<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Personas;
use App\Models\Vehiculos;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Datatables;

class PersonasController extends Controller
{
    public function index()
    {
        if(request()->ajax()) {
            $personas = DB::table('personas')
                ->select('personas.*', DB::raw('(SELECT GROUP_CONCAT(placa SEPARATOR ", ") FROM vehiculos WHERE vehiculos.personas_id = personas.id) AS vehiculos'))
                ->get();
    
            return datatables()->of($personas)
                ->addColumn('action', 'personas-action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('personas');
    }
    

    public function store(Request $request)
    {  

        $personasId = $request->id;

        $personas   =   Personas::updateOrCreate(
                    [
                    'id' => $personasId
                    ],
                    [
                    'nombre' => $request->nombre,
                    'apellidos' => $request->apellidos,
                    'celular' => $request->celular
                    ]);    

        return Response()->json($personas);
    }

    public function edit(Request $request)
    {   
        $where = array('id' => $request->id);
        $personas  = Personas::where($where)->first();

        return Response()->json($personas);
    }

    public function destroy(Request $request)
    {
        $personas = Personas::where('id',$request->id)->delete();

        return Response()->json($personas);
    }
    public function print()
{
    $personas = Personas::with('vehiculos')->get();

    foreach ($personas as $persona) {
        $placas = $persona->vehiculos->pluck('placa')->toArray();
        $persona->placas_vehiculos = implode(', ', $placas);
    }
    $pdf = PDF::loadView('reports.personas_report', compact('personas'))->setPaper('a4');
    $pdfPath = public_path('personas_report.pdf');
    $pdf->save($pdfPath);

    // Devuelve la URL del PDF
    return response()->json(['url' => url('personas_report.pdf')]);
}


}