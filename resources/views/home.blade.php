@extends('layouts.app')

@section('content')
<script>
$.noConflict();
jQuery(document).ready(function($) {
    $('#vehiculos-home').DataTable({
        "language": {
            "lengthMenu": "Mostrar " +
                '<select><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option><option value="-1">Todo</option></select>' +
                " registros",
            "zeroRecords": "Nada encontrado - disculpa",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(Filtrado de _MAX_ registros totales)",
            "search": "Buscar:",
            "paginate": { "next": "Siguiente", "previous": "Anterior" }
        },
        processing: true,
        serverSide: true,
        ajax: "{{ route('home.datatable') }}",
        columns: [
            { data: 'id', name: 'id'},
            { data: 'vehiculox', name: 'vehiculox' }, // Corregido el nombre de la columna
			{ 
                data: 'estado', 
                name: 'estado',
                render: function(data) {
                    var badges = data.split(' - ');
                    var estado = badges[0].trim();
                    var disponibilidad = badges[1].trim();
                    var estadoClass = '';
                    var disponibilidadClass = '';
                    switch (estado) {
                        case 'Sin mantenimiento':
                            estadoClass = 'badge bg-secondary';
                            break;
                        case 'En mantenimiento':
                            estadoClass = 'badge bg-warning';
                            break;
                        case 'Mantenimiento completo':
                            estadoClass = 'badge bg-primary';
                            break;
                        default:
                            estadoClass = 'badge bg-secondary';
                    }
                    switch (disponibilidad) {
                        case 'Disponible':
                            disponibilidadClass = 'badge bg-success';
                            break;
                        case 'Ocupado':
                            disponibilidadClass = 'badge bg-danger';
                            break;
                        default:
                            disponibilidadClass = 'badge bg-secondary';
                    }
                    return '<span class="' + estadoClass + '">' + estado + '</span><br><span class="' + disponibilidadClass + '">' + disponibilidad + '</span>';
                }
            },
            { data: 'action', name: 'action', orderable: false },
        ],
        order: [[0, 'desc']], // Esto ordena por la primera columna (ID) de forma descendente
    });
});
</script>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Dashboard') }}</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
			<!-- <h3 class="text-primary text-center">
				Bienvenido al Sistema de Gestión de Mantenimiento de Vehículos
			</h3> --> <!-- Esto se tendrá que poner a modo de alerta -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
	<div class="content">
    <div class="container-fluid">
        <div class="row" style="font-size:18px;">
            <div class="col-md-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $vehiculosCount }}</h3>
                        <p>Motorizados</p>
                    </div>
                    <div class="icon">
					<i class="fas fa-car-side"></i>
                    </div>
                    <a href="vehiculos" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $operariosCount }}</h3>
                        <p>Operarios</p>
                    </div>
                    <div class="icon">
						<i class="fas fa-users-cog"></i>
                    </div>
                    <a href="personas" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h3>{{ $mantenimientosCount }}</h3>
                        <p>Mantenimientos</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-tools"></i>
                    </div>
                    <a href="mantenimientos" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $proveedoresCount }}</h3>
                        <p>Proveedores</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-store"></i>
                    </div>
                    <a href="proveedores" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div> <!-- fin de primer row -->

        <div class="row">
            <div class="col-lg-8">
                <div class="card card-primary card-tabs">
                    <div class="card-header p-0 pt-1">
                        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-one-nmantenimientos-tab" data-toggle="pill" href="#custom-tabs-one-nmantenimientos" role="tab" aria-controls="custom-tabs-one-nmantenimientos" aria-selected="true">N° de mantenimientos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-tabs-one-minversion-tab" data-toggle="pill" href="#custom-tabs-one-minversion" role="tab" aria-controls="custom-tabs-one-minversion" aria-selected="false">Tipos de mantenimiento</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-one-estadosvehiculos-tab" data-toggle="pill" href="#custom-tabs-one-estadosvehiculos" role="tab" aria-controls="custom-tabs-one-estadosvehiculos" aria-selected="false">Vehículos reincidentes</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-one-reparacionescomunes-tab" data-toggle="pill" href="#custom-tabs-one-reparacionescomunes" role="tab" aria-controls="custom-tabs-one-reparacionescomunes" aria-selected="false">Reparaciones más frecuentes</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-one-tabContent">
                            <div class="tab-pane fade" id="custom-tabs-one-nmantenimientos" role="tabpanel" aria-labelledby="custom-tabs-one-nmantenimientos-tab">
                                <!-- Contenido de N° de mantenimientos -->
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="text-center text-bold">Buscar por rango de fecha</h6><hr>
                                        <form id="searchForm">
                                            <div class="row">
                                                <div class="col-md-4 row">
                                                    <label for="fecha_inicio" class="form-label col">Fecha de inicio:</label>
                                                    <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control col">
                                                </div>
                                                <div class="col-md-4 row">
                                                    <label for="fecha_fin" class="form-label col">Fecha de fin:</label>
                                                    <input type="date" id="fecha_fin" name="fecha_fin" class="form-control col">
                                                </div>
                                                <div class="col-md-4 text-right mx-auto d-grid gap-2">
                                                    <button type="submit" class="btn btn-success">Buscar &nbsp&nbsp<i class="fas fa-search"></i></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="grafico_mantenimientos" class="chart"></canvas><br>
                                        <table id="tabla_estados_mantenimientos" class="table table-bordered table-hover"></table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade active show" id="custom-tabs-one-minversion" role="tabpanel" aria-labelledby="custom-tabs-one-minversion-tab">
                                <!-- Contenido de tipos de mantenimiento -->
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="text-center text-bold">Buscar por rango de fecha</h6><hr>
                                        <form id="searchForm2">
                                            <div class="row">
                                                <div class="col-md-4 row">
                                                    <label for="fecha_inicio2" class="form-label col">Fecha de inicio:</label>
                                                    <input type="month" id="fecha_inicio2" name="fecha_inicio2" class="form-control col">
                                                </div>
                                                <div class="col-md-4 row">
                                                    <label for="fecha_fin2" class="form-label col">Fecha de fin:</label>
                                                    <input type="month" id="fecha_fin2" name="fecha_fin2" class="form-control col">
                                                </div>
                                                <div class="col-md-4 text-right mx-auto d-grid gap-2">
                                                    <button type="submit" class="btn btn-success">Buscar &nbsp&nbsp<i class="fas fa-search"></i></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="grafico_tipos_mantenimientos" class="chart"></canvas><br>
                                        <table id="tabla_tipos_mantenimientos" class="table table-bordered table-hover"></table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-one-estadosvehiculos" role="tabpanel" aria-labelledby="custom-tabs-one-estadosvehiculos-tab">
                                <!-- Contenido de Vehiculos reincidentes -->
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="text-center text-bold">Mantenimientos por Vehículo</h6><hr>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="grafico_vehiculos" class="chart"></canvas><br>
                                        <table id="tabla_vehiculos_chart" class="table table-bordered table-hover" style=""></table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-one-reparacionescomunes" role="tabpanel" aria-labelledby="custom-tabs-one-reparacionescomunes-tab">
                                <!-- Contenido de Reparaciones frecuentes -->
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="text-center text-bold">Reparaciones más Frecuentes</h6><hr>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="grafico_reparaciones" class="chart"></canvas><br>
                                        <table id="tabla_promedio_precios" class="table table-bordered table-hover" style=""></table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
				@if ($message = Session::get('success'))
				<div class="alert alert-success">
					<p>{{ $message }}</p>
				</div>
				@endif
				<div class="card card-warning card-tabs">
					<div class="card-header p-0 pt-1"><br>
						<h5 class="text-center">Historial de mantenimientos por vehículo</h5>
					</div>
					<div class="card-body"  style="padding-left:3%;padding-right: 3%;">
					<table class="table table-hover" id="vehiculos-home" style="width:100%;text-align: center;">
						<thead class="table-warning" style="width:100%;text-align: center;">
							<tr>
								<th>ID</th>
								<th>VEHÍCULO</th>
								<th>ESTADO</th>
								<th>REPORTE</th>
							</tr>
						</thead>
					</table>
					</div>
				</div>
            </div>
        </div> <!--/.row -->
    </div><!-- /.container-fluid -->
</div><!-- /.content -->
<script type="text/javascript">
	jQuery(document).ready(function() {
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
			}
		});
	});
    function imprimirFunc(id) {
    // Mostrar el indicador de carga
    $('#loading-spinner').show();

    $.ajax({
        type: "POST",
        url: "{{ url('home/print') }}",
        data: { id: id },
        success: function(response) {
            // Ocultar el indicador de carga
            $('#loading-spinner').hide();

            // Mostrar un mensaje de éxito con SweetAlert
            Swal.fire({
                title: 'Éxito',
                text: 'El reporte se generó con éxito.',
                icon: 'success',
                confirmButtonText: 'Ver PDF'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Abre una nueva ventana con la URL del PDF
                    window.open(response.url, '_blank');
                }
            });
        },
        error: function(xhr, status, error) {
            // Ocultar el indicador de carga
            $('#loading-spinner').hide();

            // Mostrar un mensaje de error con SweetAlert
            Swal.fire({
                title: 'Error',
                text: 'Ocurrió un error al intentar imprimir el registro.',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });

            console.error(xhr.responseText);
        }
    });
}


</script>
<script type="text/javascript">
    let graficoMantenimientos = null; // Variable global para almacenar el gráfico

    jQuery(document).ready(function($) {
        // Función para cargar y actualizar el gráfico
        function cargarGrafico(datos) {
            // Si ya hay un gráfico, destrúyelo antes de crear uno nuevo
            if (graficoMantenimientos) {
                graficoMantenimientos.destroy();
            }

            // Configurar los datos del gráfico
            const config = {
                type: 'bar',
                data: {
                    labels: datos.dias, // Cambiar a 'dias' en lugar de 'meses'
                    datasets: [{
                        label: 'Mantenimientos Solicitados',
                        data: datos.solicitados,
                        backgroundColor: 'rgba(255, 99, 132, 0.5)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1,
                        barThickness: 12
                    }, {
                        label: 'Mantenimientos Terminados',
                        data: datos.terminados,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        barThickness: 12
                    }]
                },
                options: {
                  //  indexAxis: 'y',
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Mantenimientos por Día' // Cambiar el título del gráfico
                        }
                    },
                    scales: {
                        y: {
                            ticks: {
                                stepSize: 1, // Establecer el tamaño del paso a 1 para mostrar solo enteros
                                precision: 0 // Establecer la precisión a 0 para que no aparezcan decimales
                            }
                        }
                    }
                }
            };

            // Crear el gráfico
            var ctx = document.getElementById('grafico_mantenimientos').getContext('2d');
            graficoMantenimientos = new Chart(ctx, config);

            var tablaHTML1 = `<table><thead class="table-dark text-center"><tr><th>Estado de Mantenimientos del ${datos.fecha_inicio1} a ${datos.fecha_fin1}</th><th>Número</th></tr></thead><tbody>`;
            // Correctivos
            var totalSolicitados = datos.solicitados.reduce((a, b) => a + b, 0);
            tablaHTML1 += '<tr><td>Mantenimientos solicitados</td><td class="text-right">' + totalSolicitados + '</td></tr>';
            // Preventivos
            var totalTerminados = datos.terminados.reduce((a, b) => a + b, 0);
            tablaHTML1 += '<tr><td>Mantenimientos terminados</td><td class="text-right">' + totalTerminados + '</td></tr>';
            tablaHTML1 += '</tbody></table>';
            // Insertar la tabla en el documento
            $('#tabla_estados_mantenimientos').html(tablaHTML1);
        }

        // Realizar la solicitud AJAX para obtener los datos del gráfico al cargar la página
        $.ajax({
            url: '{{ url("home/obtener_datos_grafico") }}',
            type: 'GET',
            success: function(response) {
                // Cargar el gráfico con los datos obtenidos
                cargarGrafico(response);

            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });

        // Manejar el envío del formulario para cargar el gráfico con el rango de fechas especificado
        $('#searchForm').on('submit', function(event) {
            event.preventDefault(); // Evitar el envío del formulario

            // Obtener las fechas del formulario
            var fechaInicio = $('#fecha_inicio').val();
            var fechaFin = $('#fecha_fin').val();
            if (new Date(fechaInicio) > new Date(fechaFin)) {
                // Mostrar una notificación de error con Toastr
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                    });
                    Toast.fire({
                    icon: "warning",
                    title: "La fecha de inicio no puede ser mayor a la fecha de fin."
                    });
                // Detener la ejecución de la función para evitar hacer la solicitud AJAX
                return;
            }
            // Realizar la solicitud AJAX para obtener los datos del gráfico con el rango de fechas especificado
            $.ajax({
                url: '{{ url("home/obtener_datos_grafico") }}',
                type: 'GET',
                data: {
                    fecha_inicio: fechaInicio,
                    fecha_fin: fechaFin
                },
                success: function(response) {
                    // Cargar el gráfico con los datos obtenidos
                    const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                    });
                    Toast.fire({
                    icon: "success",
                    title: "Se aplicó el rango de fechas."
                    });
                    cargarGrafico(response);
                    $('#fecha_inicio').val('');
                    $('#fecha_fin').val('');
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                    });
                    Toast.fire({
                    icon: "success",
                    title: "Hubo un error en el rango de fechas."
                    });
                }
            });
        });
    });
</script>
<script type="text/javascript">
    let graficoTiposMantenimientos = null; // Variable global para almacenar el gráfico

jQuery(document).ready(function($) {

    function cargarGrafico2(datos) {
        if (graficoTiposMantenimientos) {
        graficoTiposMantenimientos.destroy();
    }
        // Configurar y cargar el segundo gráfico (Tipos de Mantenimientos)
        const config = {
            type: 'bar',
            data: {
                labels: datos.meses,
                datasets: [{
                    label: 'Mantenimientos Correctivos',
                    data: datos.correctivos,
                    backgroundColor: 'rgba(216, 9, 107, 0.5)',
                    borderColor: 'rgba(85, 142, 47, 1)',
                    borderWidth: 1,
                    barThickness: 20
                }, {
                    label: 'Mantenimientos Preventivos',
                    data: datos.preventivos,
                    backgroundColor: 'rgba(17, 227, 217, 0.5)',
                    borderColor: 'rgba(17, 182, 118, 1)',
                    borderWidth: 1,
                    barThickness: 20
                }, {
                    label: 'Mantenimientos Correctivos/Preventivos',
                    data: datos.preventivoscorrectivos,
                    backgroundColor: 'rgba(4, 186, 18 , 0.5)',
                    borderColor: 'rgba(14, 162, 18, 1)',
                    borderWidth: 1,
                    barThickness: 20
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Tipos de Mantenimientos'
                    }
                },
                scales: {
                    y: {
                        ticks: {
                            stepSize: 1,
                            precision: 0
                        }
                    }
                }
            }
        };

        // Crear el gráfico
        var ctx = document.getElementById('grafico_tipos_mantenimientos').getContext('2d');
        graficoTiposMantenimientos = new Chart(ctx, config);
        // Construir la tabla con los datos recibidos
var tablaHTML = `<table><thead class="table-dark text-center"><tr><th>Tipo de Mantenimiento del ${datos.fecha_inicio2} a ${datos.fecha_fin2}</th><th>Número</th></tr></thead><tbody>`;
// Correctivos
        var totalCorrectivos = datos.correctivos.reduce((a, b) => a + b, 0);
        tablaHTML += '<tr><td>Mantenimientos Correctivos</td><td class="text-right">' + totalCorrectivos + '</td></tr>';
        // Preventivos
        var totalPreventivos = datos.preventivos.reduce((a, b) => a + b, 0);
        tablaHTML += '<tr><td>Mantenimientos Preventivos</td><td class="text-right">' + totalPreventivos + '</td></tr>';
        // Correctivos/Preventivos
        var totalPreventivosCorrectivos = datos.preventivoscorrectivos.reduce((a, b) => a + b, 0);
        tablaHTML += '<tr><td>Mantenimientos Correctivos/Preventivos</td><td class="text-right">' + totalPreventivosCorrectivos + '</td></tr>';
        // Total general de todos los mantenimientos
        var totalGeneral = totalCorrectivos + totalPreventivos + totalPreventivosCorrectivos;
        tablaHTML += '<tr><td><strong>Total General</strong></td><td class="text-right"><strong>' + totalGeneral + '</strong></td></tr>';
        tablaHTML += '</tbody></table>';
        // Insertar la tabla en el documento
        $('#tabla_tipos_mantenimientos').html(tablaHTML);
    }

    // Realizar la solicitud AJAX para obtener los datos del segundo gráfico
    $.ajax({
        url: '{{ url("home/obtener_datos_grafico2") }}',
        type: 'GET',
        success: function(response) {
            cargarGrafico2(response);
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });

    // Manejar el envío del formulario para cargar el segundo gráfico con el rango de fechas especificado
    $('#searchForm2').on('submit', function(event) {
        event.preventDefault();

        var fechaInicio2 = $('#fecha_inicio2').val();
        var fechaFin2 = $('#fecha_fin2').val();
        if (new Date(fechaInicio2) > new Date(fechaFin2)) {
                // Mostrar una notificación de error con Toastr
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                    });
                    Toast.fire({
                    icon: "warning",
                    title: "La fecha de inicio no puede ser mayor a la fecha de fin."
                    });
                // Detener la ejecución de la función para evitar hacer la solicitud AJAX
                return;
            }

        $.ajax({
            url: '{{ url("home/obtener_datos_grafico2") }}',
            type: 'GET',
            data: {
                fecha_inicio2: fechaInicio2,
                fecha_fin2: fechaFin2
            },
            success: function(response) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                    });
                    Toast.fire({
                    icon: "success",
                    title: "Se aplicó el rango de fechas."
                    });
                cargarGrafico2(response);
                $('#fecha_inicio2').val('');
                $('#fecha_fin2').val('');
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                    });
                    Toast.fire({
                    icon: "error",
                    title: "Hubo un error aplicando el rango de fechas."
                    });
            }
        });
    });
});
</script>
<script type="text/javascript">
    let graficoVehiculos = null; // Variable global para almacenar el gráfico

jQuery(document).ready(function($) {
    function cargarGraficoReincidentes(datos) {
    // Configurar y cargar el gráfico de vehículos reincidentes
    if (graficoVehiculos) {
        graficoVehiculos.destroy();
    }
    
    // Definir arrays de colores para cada barra
    const backgroundColors = [
        'rgba(54, 162, 235, 0.5)',
        'rgba(75, 192, 192, 0.5)',
        'rgba(255, 99, 132, 0.5)',
        'rgba(255, 206, 86, 0.5)',
        'rgba(153, 102, 255, 0.5)',
        'rgba(255, 159, 64, 0.5)',
        'rgba(199, 199, 199, 0.5)',
        // Agrega más colores según necesites
    ];
    
    const borderColors = [
        'rgba(54, 162, 235, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(255, 99, 132, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)',
        'rgba(199, 199, 199, 1)',
        // Agrega más colores según necesites
    ];
    
    // Configuración del gráfico
    const config = {
        type: 'bar',
        data: {
            labels: datos.vehiculos, // Vehículos reincidentes
            datasets: [{
                label: 'Número de Mantenimientos',
                data: datos.num_mantenimientos,
                backgroundColor: backgroundColors.slice(0, datos.num_mantenimientos.length),
                borderColor: borderColors.slice(0, datos.num_mantenimientos.length),
                borderWidth: 1,
                barThickness: 20
            }]
        },
        options: {
            indexAxis: 'y', // Eje horizontal
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                    display: false
                },
                title: {
                    display: true,
                    text: 'Número de Mantenimientos por Vehículos'
                }
            },
            scales: {
                x: {
                    ticks: {
                        stepSize: 1,
                        precision: 0 // Establece la precisión a 0 para eliminar decimales
                    }
                }
            }
        }
    };

    // Crear el gráfico
    var ctx = document.getElementById('grafico_vehiculos').getContext('2d');
    graficoVehiculos = new Chart(ctx, config);
// Inicializa la tabla HTML
let tablaHTML2 = '<table class="table table-bordered"><thead class="table-dark text-center"><tr><th colspan="2">Vehículo</th><th colspan="2">Número de Mantenimientos</th></tr></thead><tbody>';

// Variables para contar el total de vehículos y el total de mantenimientos
let totalVehiculos = datos.vehiculosDatosCompletos.length;
let totalMantenimientos = 0;

// Recorre los datos de vehículos reincidentes
for (let i = 0; i < datos.vehiculosDatosCompletos.length; i++) {
    // Muestra la información completa del vehículo
    tablaHTML2 += '<tr><td colspan="2">' + datos.vehiculosDatosCompletos[i] + '</td><td class="text-right" colspan="2">' + datos.num_mantenimientos[i] + '</td></tr>';
    // Acumula el total de mantenimientos
    totalMantenimientos += datos.num_mantenimientos[i];
}

// Agrega la última fila con el total de vehículos y total de mantenimientos
tablaHTML2 += '<tr><td><strong>Total Vehículos:</strong></td><td class="text-center"><strong>' + totalVehiculos + '</strong></td><td><strong>Total Mantenimientos:</strong></td><td class="text-right"><strong>' + totalMantenimientos + '</strong></td></tr>';
// Cierra la tabla HTML
tablaHTML2 += '</tbody></table>';

// Inserta la tabla en el documento
$('#tabla_vehiculos_chart').html(tablaHTML2);

}
// Realiza la solicitud AJAX para obtener los datos de los vehículos reincidentes
$.ajax({
    url: '{{ url("home/obtener_vehiculos_reincidentes") }}',
    type: 'GET',
    success: function(response) {
        cargarGraficoReincidentes(response);
    },
    error: function(xhr, status, error) {
        console.error('Error al obtener datos:', error);
    }
});

});
</script><script type="text/javascript">
let graficoReparaciones = null; // Variable global para almacenar el gráfico

jQuery(document).ready(function($) {
    // Genera un color aleatorio
    function generarColorAleatorio(opacidad = 0.5) {
        const rojo = Math.floor(Math.random() * 256);
        const verde = Math.floor(Math.random() * 256);
        const azul = Math.floor(Math.random() * 256);
        return `rgba(${rojo}, ${verde}, ${azul}, ${opacidad})`;
    }

    // Función para cargar el gráfico de reparaciones
    function cargarGraficoReparaciones(datos) {
        // Destruir el gráfico anterior si existe
        if (graficoReparaciones) {
            graficoReparaciones.destroy();
        }

        // Generar colores aleatorios para las reparaciones
        const backgroundColors = [];
        for (let i = 0; i < datos.frecuencias.length; i++) {
            backgroundColors.push(generarColorAleatorio());
        }

        // Configuración del gráfico de tipo pie
        const config = {
            type: 'pie',
            data: {
                labels: datos.reparaciones,
                datasets: [{
                    data: datos.frecuencias,
                    backgroundColor: backgroundColors,
                    borderColor: '#fff', // Borde blanco alrededor de cada sección
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                aspectRatio: 1.3,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: false,
                        text: 'Reparaciones más frecuentes'
                    }
                }
            }
        };

        // Crear el gráfico
        const ctx = document.getElementById('grafico_reparaciones').getContext('2d');
        graficoReparaciones = new Chart(ctx, config);
    }

    // Solicitud AJAX para obtener los datos de las reparaciones más frecuentes
    $.ajax({
        url: '{{ url("home/obtener_reparaciones_frecuentes") }}',
        type: 'GET',
        success: function(response) {
            // Verificar el contenido de response
            console.log(response);
            cargarGraficoReparaciones(response);
        },
        error: function(xhr, status, error) {
            console.error('Error al obtener datos:', error);
        }
    });
    function generarTablaPromedioPreciosReparaciones(datos) {
        // Inicializa el HTML de la tabla
        let tablaHTML = '<table class="table table-bordered"><thead class="table-dark text-center"><tr><th>ID</th><th>Reparación</th><th>Promedio de Precio</th></tr></thead><tbody>';
        
        // Itera sobre los datos y crea las filas de la tabla
        datos.forEach(reparacion => {
            tablaHTML += `<tr><td>${reparacion.id}</td><td>${reparacion.elemento}</td><td class="text-right">${reparacion.promedio_costo.toFixed(2)} S/.</td></tr>`;
        });

        // Cierra la tabla
        tablaHTML += '</tbody></table>';

        // Inserta la tabla debajo del gráfico de reparaciones
        $('#tabla_promedio_precios').html(tablaHTML);
    }

    // Llama a la función para realizar la solicitud AJAX al cargar la página
    $(document).ready(function() {
        $.ajax({
            url: '{{ url("home/obtener_promedio_precios_reparaciones") }}',
            type: 'GET',
            success: function(response) {
                generarTablaPromedioPreciosReparaciones(response);
            },
            error: function(xhr, status, error) {
                console.error('Error al obtener datos:', error);
            }
        });
    });

});

</script>


@endsection