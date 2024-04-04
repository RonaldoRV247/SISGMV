<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Vehiculos;
use App\Models\Mantenimientos;
use App\Models\Detalles_Mantenimiento;
use App\Models\Proveedores;
use App\Models\Personas;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Datatables;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $vehiculosCount = Vehiculos::count();
        $operariosCount = Personas::count();
        $mantenimientosCount = Mantenimientos::count();
        $proveedoresCount = Proveedores::count();
        return view('home', compact('vehiculosCount','operariosCount','mantenimientosCount','proveedoresCount'));
    }
// En tu controlador
public function vehiculosDatatable(): JsonResponse
{
    if (request()->ajax()) {
        $vehiculos = Vehiculos::with('mantenimientos')->get();

        $data = $vehiculos->map(function ($vehiculo) {
            $estado = $this->calcularEstado($vehiculo->mantenimientos->last());
            return [
                'id' => $vehiculo->id,
                'placa' => $vehiculo->placa,
                'unidad' => $vehiculo->unidad,
                'marca' => $vehiculo->marca,
                'modelo' => $vehiculo->modelo,
                'anio' => $vehiculo->anio,
                'estado' => $estado,
                'vehiculox' => $vehiculo->placa . ' ' . $vehiculo->unidad . ' ' . $vehiculo->marca . ' ' . $vehiculo->modelo . ' ' . $vehiculo->anio,
            ];
        });

        return datatables()->of($data)
            ->addColumn('action', 'home-action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
    }

    // Si la solicitud no es AJAX, retorna un error
    return response()->json(['error' => 'Acción no permitida.'], 403);
}

private function calcularEstado($ultimoMantenimiento)
{
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
public function print(Request $request)
{
    // Obtener vehículo
    $vehiculo = Vehiculos::findOrFail($request->id);
    
    // Obtener fechas del formulario
    $fecha_inicio_vehi = $request->fecha_inicio_vehi;
    $fecha_fin_vehi = $request->fecha_fin_vehi;

    // Obtener mantenimientos dentro del rango de fechas si las fechas no están vacías
    if (!empty($fecha_inicio_vehi) && !empty($fecha_fin_vehi)) {
        $mantenimientos = $vehiculo->mantenimientos()
                            ->whereBetween('fecha_requerimiento', [$fecha_inicio_vehi, $fecha_fin_vehi])
                            ->get();
    } else {
        // Si las fechas están vacías, obtener todos los mantenimientos del vehículo
        $mantenimientos = $vehiculo->mantenimientos;
    }

    // Procesar mantenimientos y generar PDF
    foreach ($mantenimientos as $mantenimiento) {
        if (!is_null($mantenimiento->fecha_conformidad_servicio)) {
            $mantenimiento->estado = 'Completado';
            $mantenimiento->estado_class = 'badge-primary';
        } elseif (!is_null($mantenimiento->fecha_ingreso_taller) || !is_null($mantenimiento->fecha_salida_taller)) {
            $mantenimiento->estado = 'En curso';
            $mantenimiento->estado_class = 'badge-warning';
        } else {
            $mantenimiento->estado = 'Desconocido';
            $mantenimiento->estado_class = 'badge-secondary';
        }
    }

    $pdf = PDF::loadView('reports.vehiculos_home_report', compact('vehiculo', 'mantenimientos'))->setPaper('a4','landscape');

    // Guarda el PDF temporalmente
    $pdfPath = public_path('vehiculos_home_report.pdf');
    $pdf->save($pdfPath);

    // Devuelve la URL del PDF
    return response()->json(['url' => url('vehiculos_home_report.pdf')]);
}

public function obtenerDatosGrafico(Request $request)
{
    $fechaInicio = $request->input('fecha_inicio');
    $fechaFin = $request->input('fecha_fin');

    // Si las fechas no están definidas, obtener los últimos 2 meses
    if (!$fechaInicio || !$fechaFin) {
        $fechaInicio = Carbon::now()->subMonths(1)->toDateString();
        $fechaFin = Carbon::now()->toDateString();
    }

    // Convertir las fechas de inicio y fin a objetos DateTime para facilitar el cálculo
    $fechaInicio = new \DateTime($fechaInicio);
    $fechaFin = new \DateTime($fechaFin);

    // Obtener los datos de mantenimientos por día dentro del rango de fechas especificado
    $fechaActual = clone $fechaInicio;
    $dias = [];
    $solicitados = [];
    $terminados = [];

    // Recorrer cada día dentro del rango de fechas
    while ($fechaActual <= $fechaFin) {
        $dias[] = $fechaActual->format('Y-m-d');

        // Contar los mantenimientos solicitados en el día
        $mantenimientosSolicitados = Mantenimientos::whereNotNull('fecha_requerimiento')
            ->whereDate('fecha_requerimiento', $fechaActual->format('Y-m-d'))
            ->count();
        $solicitados[] = $mantenimientosSolicitados;

        // Contar los mantenimientos terminados en el día
        $mantenimientosTerminados = Mantenimientos::whereNotNull('fecha_conformidad_servicio')
            ->whereDate('fecha_conformidad_servicio', $fechaActual->format('Y-m-d'))
            ->count();
        $terminados[] = $mantenimientosTerminados;

        // Avanzar al siguiente día
        $fechaActual->modify('+1 day');
    }

    return response()->json([
        'dias' => $dias,
        'solicitados' => $solicitados,
        'terminados' => $terminados,
    ]);
}
}
