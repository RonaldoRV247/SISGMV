<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <title>Reporte histórico de mantenimientos de un vehículo</title>
    <style>
        .logo {
            max-width: 95px; /* Ajusta el tamaño máximo de la imagen */
            margin-right: 20px; /* Espacio entre la imagen y el título */
        }
        body{
            font-size: 14px;
        }
        .header,
        .footer {
            position: fixed; /* Fija el encabezado y el pie de página */
            left: 0;
            right: 0;
            height: 100px; /* Altura del encabezado */
            padding: 10px; /* Espaciado interno */
            border-bottom: 1px solid #ccc; /* Línea divisoria en la parte inferior */
        }

        .header {
            top: 0; /* Coloca el encabezado en la parte superior */
        }

        .footer {
            bottom: 0; /* Coloca el pie de página en la parte inferior */
        }

        .content {
            margin-top: 120px; /* Ajusta el margen superior para dejar espacio para el encabezado */
        }
        @media print {
        .page-break {
            page-break-after: always;
        }
        
    }
    </style>
</head>
<body>
<div class="container-fluid">
        <header class="header">
            <div class="">
                <div class="col-sm-2 float-left">
                    <img src="{{ public_path('images/logo.jpg') }}" alt="Logo" class="img-fluid mb-4 logo">
                </div>
                <div class="col-sm-8 float-right"><br>
                    <h5 class="text-center text-uppercase" style="font-family: Arial, sans-serif; font-weight: bold; color: #2874A6;">Sistema de Gestión de Mantenimiento de Vehículos</h5>
                </div>
            </div>
        </header>
</div><br>
<div class="content">
    <h4 class="text-center" style="font-family: Arial, sans-serif; font-weight: bold;">Reporte Histórico de Mantenimientos del Vehículo de Placa {{ $vehiculo->placa }}</h4><br>
    <table class="table table-sm table-striped table-bordered">
        <thead class="thead-dark text-center">
            <tr>
                <th colspan="8">Datos del Vehículo</th>
            </tr>
        </thead>
        <tbody>
            <tr class="text-center">
                <th style="font-weight: bold;">ID</th>
                <th style="font-weight: bold;">Placa</th>
                <th style="font-weight: bold;">Unidad</th>
                <th style="font-weight: bold;">Marca</th>
                <th style="font-weight: bold;">Modelo</th>
                <th style="font-weight: bold;">Motor</th>
                <th style="font-weight: bold;">Año</th>
                <th style="font-weight: bold;">Operario</th>
            </tr>
            <tr>
                <td>{{ $vehiculo->id ?? '' }}</td>
                <td>{{ $vehiculo->placa ?? '' }}</td>
                <td>{{ $vehiculo->unidad ?? '' }}</td>
                <td>{{ $vehiculo->marca ?? '' }}</td>
                <td>{{ $vehiculo->modelo ?? '' }}</td>
                <td>{{ $vehiculo->motor ?? '' }}</td>
                <td>{{ $vehiculo->anio ?? '' }}</td>
                <td>
                    {{ $vehiculo->personas->nombre ?? '' }} {{ $vehiculo->personas->apellidos ?? '' }}
                </td>
            </tr>
        </tbody>
    </table><br>
    <h5 class="text-center" style="font-family: Arial, sans-serif; font-weight: bold;">Historial de Mantenimientos</h5><br>
            <table class="table table-sm table-striped table-bordered">
                <thead class="thead-dark text-center">
                    <tr>
                        <th colspan="9">Datos generales de los Mantenimientos</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-center thead-dark">
                        <th style="font-weight: bold;">ID</th>
                        <th style="font-weight: bold;">Tipo</th>
                        <th style="font-weight: bold;">Expediente</th>
                        <th style="font-weight: bold;">Fecha de Requerimiento</th>
                        <th style="font-weight: bold;">Fecha de Conformidad de Servicio</th>
                        <th style="font-weight: bold;">Ingreso al Taller</th>
                        <th style="font-weight: bold;">Salida del Taller</th>
                        <th style="font-weight: bold;">Proveedor</th>
                        <th style="font-weight: bold;">Estado</th>
                    </tr>
                    @foreach ($vehiculo->mantenimientos as $mantenimiento)
                    <tr>
                        <td>{{ $mantenimiento->id }}</td>
                        <td>{{ $mantenimiento->tipo }}</td>
                        <td>{{ $mantenimiento->expediente }}</td>
                        <td>{{ $mantenimiento->fecha_requerimiento }}</td>
                        <td>{{ $mantenimiento->fecha_conformidad_servicio }}</td>
                        <td>{{ $mantenimiento->fecha_ingreso_taller }}</td>
                        <td>{{ $mantenimiento->fecha_salida_taller }}</td>
                        <td>RUC: {{ $mantenimiento->proveedor->ruc }} - {{ $mantenimiento->proveedor->nombre }}</td>
                        <td class="text-center"><span class="badge {{ $mantenimiento->estado_class }}">{{ $mantenimiento->estado }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <br>
            <h5 class="text-center" style="font-family: Arial, sans-serif; font-weight: bold;">Detalle de los Mantenimientos</h5><br>
            <table class="table table-sm table-bordered">
                <thead class="thead-dark text-center">
                    <tr>
                        <th colspan="10">Datos específicos de los mantenimientos</th>
                    </tr>
                    <tr>
                        <th rowspan="2" style="font-weight: bold;">ID</th>
                        <th rowspan="2" style="font-weight: bold;">Tipo</th>
                        <th rowspan="2" style="font-weight: bold;">Expediente</th>
                        <th rowspan="2" style="font-weight: bold;width:20%;">Proveedor</th>
                        <th rowspan="2" style="font-weight: bold;">Estado</th>
                        <th colspan="4" style="font-weight: bold;">Datos de las reparaciones</th>
                        <th rowspan="2" style="font-weight: bold;">&nbsp;&nbsp;&nbsp;&nbsp; Totales &nbsp;&nbsp;&nbsp;&nbsp;</th>
                    </tr>
                    <tr>
                        <th style="font-weight: bold;">ID</th>
                        <th style="font-weight: bold;">Reparacion</th>
                        <th style="font-weight: bold;">Descripcion</th>
                        <th style="font-weight: bold;">Costo</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($vehiculo->mantenimientos as $mantenimiento)
                    <tr>
                        <td rowspan="{{ $mantenimiento->detallesMantenimiento->count() }}">{{ $mantenimiento->id }}</td>
                        <td rowspan="{{ $mantenimiento->detallesMantenimiento->count() }}">{{ $mantenimiento->tipo }}</td>
                        <td rowspan="{{ $mantenimiento->detallesMantenimiento->count() }}">{{ $mantenimiento->expediente }}</td>
                        <td rowspan="{{ $mantenimiento->detallesMantenimiento->count() }}">RUC: {{ $mantenimiento->proveedor->ruc }} - {{ $mantenimiento->proveedor->nombre }}</td>
                        <td rowspan="{{ $mantenimiento->detallesMantenimiento->count() }}" class="text-center"><span class="badge {{ $mantenimiento->estado_class }}">{{ $mantenimiento->estado }}</span></td>
                        @foreach ($mantenimiento->detallesMantenimiento as $index => $detalle)
                            @if ($index === 0)
                                <!-- Columnas de reparaciones solo para la primera fila -->
                                <td>{{ $detalle->id }}</td>
                                <td>{{ $detalle->reparacion->elemento }}</td>
                                <td>{{ $detalle->descripcion ?? '' }}</td>
                                <td style="text-align:right;">{{ number_format($detalle->costo, 2, ',', '.') }} S/.</td>
                                <td style="text-align:right;" rowspan="{{ $mantenimiento->detallesMantenimiento->count() }}">{{ number_format($mantenimiento->detallesMantenimiento->sum('costo'), 2, ',', '.') }} S/.</td>
                            @else
                                <!-- Columnas vacías para las filas adicionales de reparaciones -->
                                <tr>
                                    <td>{{ $detalle->id }}</td>
                                    <td>{{ $detalle->reparacion->elemento }}</td>
                                    <td>{{ $detalle->descripcion ?? '' }}</td>
                                    <td style="text-align:right;">{{ number_format($detalle->costo, 2, ',', '.') }} S/.</td>
                                </tr>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
                <!-- Fila para el total invertido en todos los mantenimientos -->
                <tr>
                    <td colspan="9" style="text-align: center; font-weight: bold;">Total invertido en los mantenimientos historicos:</td>
                    <td style="text-align: right; font-weight: bold;">{{ number_format($vehiculo->mantenimientos->flatMap->detallesMantenimiento->sum('costo'), 2, ',', '.') }} S/.</td>
                </tr>
                </tbody>
            </table>


</div>
<script type="text/php">
        if ( isset($pdf) ) {
            $pdf->page_script('
                $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                $pdf->text(400, 560, "Pág $PAGE_NUM de $PAGE_COUNT", $font, 10);
            ');
        }
</script>
<script type="text/php">
    if (isset($pdf)) {
        $size = 10;
        $text = date('d.m.Y H:i:s');
        $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
        $text_height = $fontMetrics->get_font_height($font, $size);
        $width = $fontMetrics->get_text_width($text, $font, $size);
        $w = $pdf->get_width() - $width - 40;
        $y = $pdf->get_height() - $text_height - 570;

        $pdf->page_text($w, $y, $text, $font, $size);
    }
</script>

</body>
</html>
