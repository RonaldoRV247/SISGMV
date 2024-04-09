@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <script>
        $.noConflict();
        jQuery( document ).ready(function( $ ) {
            $('#vehiculos').DataTable({
                "language": {
            "lengthMenu": "Mostrar "+
                '<select><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option><option value="-1">Todo</option></select>'
                +" registros por página",
            "zeroRecords": "Nada encontrado - disculpa",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(Filtrado de _MAX_ registros totales)",
            "search": "Buscar:",
            "paginate": {"next": "Siguiente", "previous": "Anterior"}
        },
                processing: true,
                                serverSide: true,
                                ajax: "{{ url('vehiculos') }}",
                                columns: [
                                    { data: 'id', name: 'id' },
                                    { data: 'placa', name: 'placa' },
                                    { data: 'unidad', name: 'unidad' },
                                    { data: 'marca', name: 'marca' },
                                    { data: 'modelo', name: 'modelo' },
                                    { data: 'motor', name: 'motor' },
                                    { data: 'anio', name: 'anio' },
                                    { data: 'km', name: 'km' },
                                    { data: 'carga_util_kg', name: 'carga_util_kg' },
                                    { data: 'encargado', name: 'encargado' },
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
                                            return '<span class="' + estadoClass + '">' + estado + '</span><span class="' + disponibilidadClass + '">' + disponibilidad + '</span>';
                                        }
                                    },
                                    { data: 'action', name: 'action', orderable: false},
                                ],
                                order: [[0, 'desc']]
            });
            $('#personas_id').select2({
                language: {
                    noResults: function() {return "No hay resultado";},
                    searching: function() {return "Buscando..";}
                    },
                placeholder: "Selecciona un operario",
                allowClear: true,
                dropdownParent: $('#vehiculos-modal'),
                theme: 'bootstrap-5',
                width: '100%',
                minimunResultsForSearch: Infinity,
            }).on('select2:opening', function(e) {
                    e.stopPropagation(); 
                });
                $('#personas_id').on("select2:unselect", function (e) {
                e.preventDefault();
                });
                
                function limpiarSelect2() {
                    $('#personas_id').val(null).trigger('change');
                    $('#select2-personas_id-container').val(null).trigger('change');
                }

                jQuery('#vehiculos-modal').on('hidden.bs.modal', function (event) {
                    limpiarSelect2();
                });
                
            
        });
    </script>
    <style>
    .select2-selection__clear {
        display: none;
    }
    </style>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Gestión de Vehículos') }}</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                <div class="container mt-2 card card-primary card-tabs"><br>
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <div class="">
                            <a class="btn btn-primary" onClick="add()" href="javascript:void(0)"> Nuevo Vehículo</a>
                            <a class="btn btn-info" onClick="imprimirFunc()" href="javascript:void(0)"> Imprimir Reporte</a>
                        </div>
                    </div>
                </div>
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <div class="card-body">
                    <table class="table table-bordered table-hover" id="vehiculos" style="width:100%;text-align: center;">
                        <thead class="table-dark" style="width:100%;text-align: center;">
                            <tr>
                                <th>ID</th>
                                <th>PLACA</th>
                                <th>UNIDAD</th>
                                <th>MARCA</th>
                                <th>MODELO</th>
                                <th>MOTOR</th>
                                <th>AÑO</th>
                                <th>KM</th>
                                <th>CARGA UTIL KG</th>
                                <th>OPERARIO</th>
                                <th>ESTADO</th>
                                <th>OPCIONES</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            
            <!-- boostrap vehiculos model -->
            <div class="modal fade" id="vehiculos-modal" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Vehículos</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body container">
                            <form action="javascript:void(0)" id="VehiculosForm" name="VehiculosForm" class="form-horizontal" method="POST" enctype="multipart/form-data">
                            @csrf    
                            <input type="hidden" name="id" id="id">
                                <div class="form-group">
                                    <label for="placa" class="col-sm-2 control-label">Placa</label>
                                        <div class="col-sm-12">
                                        <input type="text" class="form-control" id="placa" name="placa" placeholder="Ingresa Placa" required>
                                    </div>
                                </div>  
                                <div class="form-group">
                                    <label for="unidad" class="col-sm-2 control-label">Unidad</label>
                                        <div class="col-sm-12">
                                        <input type="text" class="form-control" id="unidad" name="unidad" placeholder="Ingresa Nombre de la Unidad"required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="marca" class="col-sm-2 control-label">Marca</label>
                                        <div class="col-sm-12">
                                        <input type="text" class="form-control" id="marca" name="marca" placeholder="Ingresa Marca">
                                    </div>
                                </div>
                                <div class="form-group row col-sm-12">
                                    <label for="modelo" class="col-sm-2 control-label">Modelo</label>
                                        <div class="col-sm">
                                        <input type="text" class="form-control" id="modelo" name="modelo" placeholder="Ingresa Modelo">
                                    </div>
                                    <label for="anio" class="col-sm-2 control-label">Año</label>
                                        <div class="col-sm">
                                        <input type="number" class="form-control" id="anio" name="anio" placeholder="Ingresa Año">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="motor" class="col-sm-2 control-label">Motor</label>
                                        <div class="col-sm-12">
                                        <input type="text" class="form-control" id="motor" name="motor" placeholder="Ingresa Motor">
                                    </div>
                                </div>
                                <div class="form-group row col-sm-12">
                                <label for="km" class="col-sm-2 control-label">Kilometraje</label>
                                        <div class="col-sm">
                                        <input type="number" step="0.01" class="form-control" id="km" name="km" placeholder="Ingresa el Kilometraje">
                                    </div>
                                    <label for="carga_util_kg" class="col-sm-2 control-label">Carga Útil kg</label>
                                        <div class="col-sm">
                                        <input type="number" step="0.01" class="form-control" id="carga_util_kg" name="carga_util_kg" placeholder="Ingresa la Capacidad en kg">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="personas_id" class="col-sm-2 control-label">Operario</label>
                                        <div class="col-sm-12">
                                        <select name="personas_id" class="form-select" id="personas_id">
                                            <option value="" hidden>Seleccione operario</option>
                                            @foreach($personas as $persona)
                                                <option value="{{ $persona->id }}">{{ $persona->id }}.- {{ $persona->nombre }} {{ $persona->apellidos }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-offset-2 col-sm-10"><br/>
                                    <button type="submit" class="btn btn-primary" id="btn-guardar">Guardar</button>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer"></div>
                    </div>
                </div>
            </div>
            <!-- end bootstrap model -->
            <script type="text/javascript">
                jQuery(document).ready( function () {

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                });
                            
            function add(){
                $('#VehiculosForm').trigger("reset");
                $('#VehiculosModal').html("Add Vehiculos");
                $('#vehiculos-modal').modal('show');
                $('#id').val('');
            }   
                
            function editFunc(id){
                $.ajax({
                    type:"POST",
                    url: "{{ url('vehiculos/edit') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){
                        $('#VehiculosModal').html("Editar Vehiculos");
                        $('#vehiculos-modal').modal('show');
                        $('#id').val(res.id);
                        $('#placa').val(res.placa);
                        $('#unidad').val(res.unidad);
                        $('#marca').val(res.marca);
                        $('#modelo').val(res.modelo);
                        $('#motor').val(res.motor);
                        $('#anio').val(res.anio);
                        $('#km').val(res.km);
                        $('#carga_util_kg').val(res.carga_util_kg);
                        $('#personas_id').val(res.personas_id);
                        $('#select2-personas_id-container').text($('#personas_id option:selected').text());
                    }
                    
                });
            }  
            function imprimirFunc() {
                $.ajax({
                    type: "POST",
                    url: "{{ url('vehiculos/print')}}",
                    success: function(response) {
                        // Abre una nueva ventana con la URL del PDF
                        window.open(response.url, '_blank');
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
            function deleteFunc(id){
                if (confirm("¿Borrar Registro?\nRecuerde que para eliminar un vehículo este no debe tener ningún mantenimiento asignado.") == true) {
                    var id = id;
                    // ajax
                    $.ajax({
                        type:"POST",
                        url: "{{ url('vehiculos/delete') }}",
                        data: { id: id },
                        dataType: 'json',
                        success: function(res){
                            var tableex = new DataTable('#vehiculos');
                            tableex.ajax.reload();
                            tableex.draw(false);
                        }
                    });
                }
            }
            
            jQuery('#VehiculosForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type:'POST',
                    url: "{{ url('vehiculos/store')}}",
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,

                    success: (data) => {
                        $("#vehiculos-modal").modal('hide');
                        /*var onTable = $('#vehiculos').dataTable()._fnAjaxUpdate();
                        onTable.fnDraw(false);*/
                        var tableex = new DataTable('#vehiculos');
                            tableex.ajax.reload();
                            tableex.draw(false);
                            $('#select2-personas_id-container').empty().text('Selecciona un operario');

                        $("#btn-guardar").html('Guardar');
                        $("#btn-guardar"). attr("disabled", false);
                    },
                    error: function(xhr) {
                        var errorMessage = JSON.parse(xhr.responseText).message;
                        alert(errorMessage); // Mostrar el mensaje de error en un alert
                    }
                });
            });
            </script>
                </div>   
            </div><!--Row-->
        </div><!-- /.container-fluid -->
    </div><!-- /.content -->
@endsection