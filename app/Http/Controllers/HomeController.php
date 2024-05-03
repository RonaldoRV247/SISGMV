<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Vehiculos;
use App\Models\Mantenimientos;
use App\Models\Detalles_Mantenimiento;
use App\Models\Proveedores;
use App\Models\Personas;
use App\Models\Reparaciones;
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
    $vehiculo = Vehiculos::findOrFail($request->id);
    $vehiculo->load('mantenimientos');

    foreach ($vehiculo->mantenimientos as $mantenimiento) {
        if (!is_null($mantenimiento->fecha_conformidad_servicio)) {
            $mantenimiento->estado = 'Completado';
            $mantenimiento->estado_class = 'badge-primary';
        } elseif (!is_null($mantenimiento->fecha_ingreso_taller) || !is_null($mantenimiento->fecha_salida_taller)) {
            $mantenimiento->estado = '  En curso  ';
            $mantenimiento->estado_class = 'badge-warning';
        } else {
            $mantenimiento->estado = 'Desconocido';
            $mantenimiento->estado_class = 'badge-secondary';
        }
    }

    $pdf = PDF::loadView('reports.vehiculos_home_report', compact('vehiculo'))->setPaper('a4','landscape');

    
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
        'fecha_inicio1' =>$fechaInicio->format('Y-m-d'),
        'fecha_fin1' => $fechaFin->format('Y-m-d')
    ]);
}

public function obtenerDatosGrafico2(Request $request)
{
    $fechaInicio2 = $request->input('fecha_inicio2');
    $fechaFin2 = $request->input('fecha_fin2');
// Si las fechas no están definidas, obtener los mantenimientos totales de los últimos 12 meses
if (!$fechaInicio2 || !$fechaFin2) {
    $fechaInicio2 = Carbon::now()->subMonths(11)->startOfMonth()->toDateString();
    $fechaFin2 = Carbon::now()->endOfMonth()->toDateString();
}

    // Convertir las fechas de inicio y fin a objetos DateTime para facilitar el cálculo
    $fechaInicio2 = new \DateTime($fechaInicio2);
    $fechaFin2 = new \DateTime($fechaFin2);

    // Obtener los datos de mantenimientos por mes dentro del rango de fechas especificado
    $fechaActual2 = clone $fechaInicio2;
    $meses = [];
    $correctivos = [];
    $preventivos = [];
    $preventivoscorrectivos = [];

    // Recorrer cada mes dentro del rango de fechas
    while ($fechaActual2 <= $fechaFin2) {
        $meses[] = $fechaActual2->format('Y-m');

        // Contar los mantenimientos por tipo en el mes
        $mantenimientosCorrectivos = Mantenimientos::where('tipo', 'CORRECTIVO')
            ->whereYear('fecha_requerimiento', $fechaActual2->format('Y'))
            ->whereMonth('fecha_requerimiento', $fechaActual2->format('m'))
            ->count();
        $correctivos[] = $mantenimientosCorrectivos;

        $mantenimientosPreventivos = Mantenimientos::where('tipo', 'PREVENTIVO')
            ->whereYear('fecha_requerimiento', $fechaActual2->format('Y'))
            ->whereMonth('fecha_requerimiento', $fechaActual2->format('m'))
            ->count();
        $preventivos[] = $mantenimientosPreventivos;

        $mantenimientosPreventivosCorrectivos = Mantenimientos::where('tipo', 'PREVENTIVO / CORRECTIVO')
            ->whereYear('fecha_requerimiento', $fechaActual2->format('Y'))
            ->whereMonth('fecha_requerimiento', $fechaActual2->format('m'))
            ->count();
        $preventivoscorrectivos[] = $mantenimientosPreventivosCorrectivos;

        // Avanzar al siguiente mes
        $fechaActual2->modify('+1 month');
    }

    return response()->json([
        'meses' => $meses,
        'correctivos' => $correctivos,
        'preventivos' => $preventivos,
        'preventivoscorrectivos' => $preventivoscorrectivos,
        'fecha_inicio2' => $fechaInicio2->format('Y-m-d'),
        'fecha_fin2' => $fechaFin2->format('Y-m-d')
    ]);
}
public function obtenerVehiculosReincidentes(Request $request)
{
    // Obtener los vehículos que tienen más de un mantenimiento
    $vehiculosReincidentes = Mantenimientos::select('vehiculos_id', DB::raw('COUNT(*) as num_mantenimientos'))
        ->groupBy('vehiculos_id')
        ->having('num_mantenimientos', '>', 0)
        ->get();

    // Inicializar arrays para almacenar placas de vehículos, número de mantenimientos y datos completos de vehículos
    $vehiculos = [];
    $numMantenimientos = [];
    $vehiculosDatosCompletos = [];

    // Iterar sobre cada resultado
    foreach ($vehiculosReincidentes as $vehiculo) {
        // Obtener el vehículo relacionado utilizando la relación 'vehiculo' en Mantenimientos
        $vehiculoInfo = Vehiculos::find($vehiculo->vehiculos_id);

        // Verificar que se encontró el vehículo relacionado
        if ($vehiculoInfo) {
            // Agregar la placa del vehículo a los datos
            $vehiculos[] = $vehiculoInfo->placa;

            // Agregar el número de mantenimientos a los datos
            $numMantenimientos[] = $vehiculo->num_mantenimientos;

            // Concatenar datos del vehículo (placa, unidad, marca, modelo, año) para la tabla
            $datosCompletos = "{$vehiculoInfo->placa} {$vehiculoInfo->unidad} {$vehiculoInfo->marca} {$vehiculoInfo->modelo} {$vehiculoInfo->anio}";
            $vehiculosDatosCompletos[] = $datosCompletos;
        }
    }

    // Retornar los datos en formato JSON
    return response()->json([
        'vehiculos' => $vehiculos,
        'num_mantenimientos' => $numMantenimientos,
        'vehiculosDatosCompletos' => $vehiculosDatosCompletos, // Nueva variable para datos completos de vehículos
    ]);
}
public function obtenerReparacionesFrecuentes(Request $request)
{
    // Consulta que cuenta la frecuencia de cada reparación en la tabla detalles_mantenimiento
    $reparacionesFrecuentes = DB::table('detalles_mantenimiento')
        ->select('reparaciones_id', DB::raw('COUNT(*) as frecuencia'))
        ->groupBy('reparaciones_id')
        ->orderBy('frecuencia', 'desc')
        ->get();

    // Ahora, necesitamos obtener los nombres de las reparaciones a partir de sus IDs
    $reparaciones = [];
    $frecuencias = [];

    foreach ($reparacionesFrecuentes as $reparacionFrecuente) {
        // Obtener la reparación correspondiente a la ID
        $reparacion = Reparaciones::find($reparacionFrecuente->reparaciones_id);

        if ($reparacion) {
            // Añadir el nombre de la reparación a la lista de reparaciones
            $reparaciones[] = $reparacion->elemento;
            
            // Añadir la frecuencia a la lista de frecuencias
            $frecuencias[] = $reparacionFrecuente->frecuencia;
        }
    }

    // Retornar los datos en formato JSON
    return response()->json([
        'reparaciones' => $reparaciones,
        'frecuencias' => $frecuencias,
    ]);
}
public function obtenerPromedioPreciosReparaciones() {
    // Realizar una consulta para obtener el promedio de costo por reparación
    $promedios = DB::table('detalles_mantenimiento')
        ->join('reparaciones', 'detalles_mantenimiento.reparaciones_id', '=', 'reparaciones.id')
        ->select('reparaciones.id', 'reparaciones.elemento', DB::raw('AVG(detalles_mantenimiento.costo) as promedio_costo'))
        ->groupBy('reparaciones.id', 'reparaciones.elemento') // Agregar 'reparaciones.elemento' a la cláusula GROUP BY
        ->orderBy('reparaciones.id', 'asc') // Ordenar por ID de forma ascendente
        ->get();

    // Retornar los datos como JSON
    return response()->json($promedios);
}


}
