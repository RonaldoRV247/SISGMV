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
                        <p>Vehículos</p>
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
                                <a class="nav-link active" id="custom-tabs-one-nmantenimientos-tab" data-toggle="pill" href="#custom-tabs-one-nmantenimientos" role="tab" aria-controls="custom-tabs-one-nmantenimientos" aria-selected="true">N° de mantenimientos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-one-minversion-tab" data-toggle="pill" href="#custom-tabs-one-minversion" role="tab" aria-controls="custom-tabs-one-minversion" aria-selected="false">Tipos de mantenimiento</a>
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
                            <div class="tab-pane fade active show" id="custom-tabs-one-nmantenimientos" role="tabpanel" aria-labelledby="custom-tabs-one-nmantenimientos-tab">
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
                                        <canvas id="grafico_mantenimientos" class="chart"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-one-minversion" role="tabpanel" aria-labelledby="custom-tabs-one-minversion-tab">
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
                                        <canvas id="grafico_tipos_mantenimientos" class="chart"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-one-estadosvehiculos" role="tabpanel" aria-labelledby="custom-tabs-one-estadosvehiculos-tab">
                                <!-- Contenido de Vehiculos reincidentes -->
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-one-reparacionescomunes" role="tabpanel" aria-labelledby="custom-tabs-one-reparacionescomunes-tab">
                                <!-- Contenido de Reparaciones frecuentes -->
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
		$.ajax({
			type: "POST",
			url: "{{ url('home/print')}}",
			data: { id: id },
			success: function(response) {
				// Abre una nueva ventana con la URL del PDF
				window.open(response.url, '_blank');
			},
			error: function(xhr, status, error) {
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
                    cargarGrafico(response);
                    $('#fecha_inicio').val('');
                    $('#fecha_fin').val('');
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
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

        $.ajax({
            url: '{{ url("home/obtener_datos_grafico2") }}',
            type: 'GET',
            data: {
                fecha_inicio2: fechaInicio2,
                fecha_fin2: fechaFin2
            },
            success: function(response) {
                cargarGrafico2(response);
                $('#fecha_inicio2').val('');
                $('#fecha_fin2').val('');
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
});

</script>

@endsection