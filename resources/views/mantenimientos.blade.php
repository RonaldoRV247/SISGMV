@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <style>
    .select2-selection__clear {
        display: none;
    }
    
    </style>
    <script src="{{ asset('js/mantenimientos.js') }}"></script>

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Gestión de Mantenimientos') }}</h1>
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
                <div class="container mt-2 card card-primary card-tabs">
                    <br>
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <div class="">
                            <a class="btn btn-primary" onClick="add()" href="javascript:void(0)"> Nuevo Mantenimiento</a>
                            <a class="btn btn-info" onClick="imprimirGenFunc()" href="javascript:void(0)"> Imprimir Reporte</a>
                        </div>
                    </div>
                </div>
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <div class="card-body">
                    <table class="table table-bordered table-hover" id="mantenimientos" style="width:100%;text-align: center;">
                        <thead class="table-dark" style="width:100%;text-align: center;">
                            <tr>
                                <th>ID</th>
                                <th>TIPO</th>
                                <th>EXPEDIENTE</th>
                                <th>FECHA DE REQUERIMIENTO</th>
                                <th>FECHA DE CONFORMIDAD DE SERVICIO</th>
                                <th>FECHA DE INGRESO AL TALLER</th>
                                <th>FECHA DE SALIDA DEL TALLER</th>
                                <th>VEHÍCULO</th>
                                <th>PROVEEDOR</th>
                                <th>OPCIONES</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            
            <!-- boostrap vehiculos model -->
            <div class="modal fade" id="mantenimientos-modal" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Mantenimientos</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body container">
                            <form action="javascript:void(0)" id="MantenimientosForm" name="MantenimientosForm" class="form-horizontal" method="POST" enctype="multipart/form-data">
                            @csrf    
                            <input type="hidden" name="id" id="id">
                                <div class="form-group row col-sm-12">
                                    <label for="tipo" class="col-sm-2 control-label">Tipo</label>
                                        <div class="col-sm">
                                        <select name="tipo" class="form-select" id="tipo" required>
                                        <option value="" hidden>Seleccione tipo</option>
                                            <option value="CORRECTIVO">CORRECTIVO</option>
                                            <option value="PREVENTIVO">PREVENTIVO</option>
                                            <option value="CORRECTIVO / NO EJECUTADO">CORRECTIVO NO EJECUTADO</option>
                                            <option value="PREVENTIVO / NO EJECUTADO">PREVENTIVO NO EJECUTADO</option>
                                            <option value="PREVENTIVO / CORRECTIVO">PREVENTIVO / CORRECTIVO</option>
                                        </select>
                                    </div>
                                    <label for="expediente" class="col-sm-2 control-label">Expediente</label>
                                        <div class="col-sm">
                                        <input type="text" class="form-control" id="expediente" name="expediente" placeholder="Ingresa el Expediente"required>
                                    </div>
                                </div>  
                                <div class="form-group row col-sm-12">
                                    <label for="fecha_requerimiento" class="col-sm-2 control-label">Fecha de requerimiento</label>
                                        <div class="col-sm">
                                        <input type="date" class="form-control" id="fecha_requerimiento" name="fecha_requerimiento" placeholder="" required>
                                    </div>
                                    <label for="fecha_conformidad_servicio" class="col-sm-2 control-label">Fecha de conformidad de servicio</label>
                                        <div class="col-sm">
                                        <input type="date" class="form-control" id="fecha_conformidad_servicio" name="fecha_conformidad_servicio" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group row col-sm-12">
                                    <label for="fecha_ingreso_taller" class="col-sm-2 control-label">Fecha de ingreso al taller</label>
                                        <div class="col-sm">
                                        <input type="date" class="form-control" id="fecha_ingreso_taller" name="fecha_ingreso_taller" placeholder="">
                                    </div>
                                    <label for="fecha_salida_taller" class="col-sm-2 control-label">Fecha de salida del taller</label>
                                        <div class="col-sm">
                                        <input type="date" class="form-control" id="fecha_salida_taller" name="fecha_salida_taller" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group row col-sm-12">
                                    <label for="vehiculos_id" class="col-sm-2 control-label">Vehículo</label>
                                        <div class="col-sm-4">
                                        <select name="vehiculos_id" class="form-control" id="vehiculos_id" required>
                                        <option value="" hidden></option>
                                            @foreach($vehiculos as $vehiculo)
                                                <option value="{{ $vehiculo->id }}">{{ $vehiculo->id }}.- Placa: {{ $vehiculo->placa }} - {{ $vehiculo->unidad }} {{ $vehiculo->marca }} {{ $vehiculo->modelo }} {{ $vehiculo->anio }}</option>
                                            @endforeach
                                        </select>
                                        </div>
                                    <label for="proveedores_id" class="col-sm-2 control-label">Proveedor</label>
                                        <div class="col-sm-4">
                                        <select name="proveedores_id" class="form-control" id="proveedores_id" required>
                                        <option value="" hidden>Seleccione proveedor</option>
                                            @foreach($proveedores as $proveedor)
                                                <option value="{{ $proveedor->id }}">{{ $proveedor->id }}.- RUC: {{ $proveedor->ruc }} - {{ $proveedor->nombre }}</option>
                                            @endforeach
                                        </select>
                                        </div>
                                </div>
                                <div class="form-group row col-sm-12">
                                <div class="card" style="width: 100%;" id="divreparaciones">
                                <br>
                                    <label for="reparaciones_id" class="col-sm-2 control-label">Reparaciones</label>
                                        <div class="col-sm-12">
                                        <select name="reparaciones_id[]" class="form-control" id="reparaciones_id" multiple required>
                                            
                                            @foreach($reparaciones as $reparacion)
                                                <option value="{{ $reparacion->id }}">&nbsp&nbsp&nbsp{{ $reparacion->id }}.- {{ $reparacion->elemento }}</option>
                                            @endforeach
                                        </select>
                                        </div>
                                        <br>
                                    <div class="card-footer">
                                    <script>
                                        jQuery('#reparaciones_id').on('select2:select', function (e) {
                                            var selectedReparation = e.params.data;
                                            var inputField = $('<div class="form-group row">' +
                                                                    '<label for="precios[]" class="col-sm-4 control-label">' + selectedReparation.text + '</label>' +
                                                                    '<div class="col-sm-4">' +
                                                                        '<textarea type="text" step="0.01" class="form-control" name="descripcion[' + selectedReparation.id + ']" placeholder="Descripcion" rows="1"></textarea>' +
                                                                    '</div>' +
                                                                    '<div class="col-sm-4">' +
                                                                        '<input type="number" step="0.01" class="form-control" name="precios[' + selectedReparation.id + ']" placeholder="Ingrese precio en soles" required>' +
                                                                    '</div>' +
                                                                '</div>');
                                            $('#precios-container').append(inputField);
                                        });

                                        jQuery('#reparaciones_id').on('select2:unselect', function (e) {
                                            var unselectedReparation = e.params.data;
                                            $('input[name="precios[' + unselectedReparation.id + ']"]').closest('.form-group').remove();
                                        });
                                        
                                    </script>
                                        Por favor, especifique los precios en soles de cada reparación:
                                            <br>
                                            <div id="precios-container" class="col-sm-12 row mt-3">
                                            <input type="hidden" name="precios" id="precios">
                                    </div>
                                    
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
            <script>
            var reparacionesData = @json($reparaciones);
            function add(){
            $('#MantenimientosForm').trigger("reset");
            $('#MantenimientosModal').html("Add Mantenimientos");
            $('#mantenimientos-modal').modal('show');
            $('#id').val('');
            }   
            
            function cargarDetallesMantenimientoParaEdicion(detalles_mantenimiento) {
                detalles_mantenimiento.forEach(function(detalles_mantenimiento) {
                    //actualizar select2
                    $('#reparaciones_id').append('<option value="" id="opcion_vacia" hidden selected></option>');
                    $('#opcion_vacia').remove();
                    
                    var nombreReparacion = obtenerNombreReparacionPorId(detalles_mantenimiento.reparaciones_id);
                    var descripcion = detalles_mantenimiento.descripcion ? detalles_mantenimiento.descripcion : ''; // Verifica si es null y asigna una cadena vacía en su lugar
                    var inputField = $('<div class="form-group row">' +
                                            '<label for="precios[]" class="col-sm-4 control-label">&nbsp&nbsp&nbsp' + detalles_mantenimiento.reparaciones_id + '.- ' + nombreReparacion + '</label>' +
                                            '<div class="col-sm-4">' +
                                                '<textarea type="text" step="0.01" class="form-control" name="descripcion[' + detalles_mantenimiento.reparaciones_id + ']" placeholder="Descripcion" rows="1">' + descripcion + '</textarea>' +
                                            '</div>' +
                                            '<div class="col-sm-4">' +
                                                '<input type="number" step="0.01" class="form-control" name="precios[' + detalles_mantenimiento.reparaciones_id + ']" value="' + detalles_mantenimiento.costo + '" placeholder="Ingrese precio en soles" required>' +
                                            '</div>' +
                                    '</div>');
                    $('#precios-container').append(inputField);
                });
            }


            function obtenerNombreReparacionPorId(id) {
                var reparacion = reparacionesData.find(function(reparacion) {
                    return reparacion.id === id;
                });
                return reparacion ? reparacion.elemento : '';
            }
            function editFunc(id){
            
            $.ajax({
                type:"POST",
                url: urlmantenimientosedit,
                data: { id: id, _token: jQuery('meta[name="csrf-token"]').attr('content') },
                dataType: 'json',
                success: function(res){
                    $('#mantenimientos-modal').modal('show');
                    $('#id').val(res.id);
                    $('#tipo').val(res.tipo);
                    $('#MantenimientosModal').html("Editar Mantenimientos");
                    $('#select2-tipo-container').text(res.tipo);
                    $('#expediente').val(res.expediente);
                    $('#fecha_requerimiento').val(res.fecha_requerimiento);
                    $('#fecha_conformidad_servicio').val(res.fecha_conformidad_servicio);
                    $('#fecha_ingreso_taller').val(res.fecha_ingreso_taller);
                    $('#fecha_salida_taller').val(res.fecha_salida_taller);
                    $('#vehiculos_id').val(res.vehiculos_id);
                    $('#select2-vehiculos_id-container').text($('#vehiculos_id option:selected').text());
                    $('#proveedores_id').val(res.proveedores_id);
                    $('#select2-proveedores_id-container').text($('#proveedores_id option:selected').text());
                    // Reparaciones
                    var detallesMantenimiento = res.detalles_mantenimiento;
                    var reparacionesSeleccionadas = [];

                    $.each(detallesMantenimiento, function(index, detalle) {
                        reparacionesSeleccionadas.push(detalle.reparaciones_id.toString());
                    });
                    $('#reparaciones_id').val(reparacionesSeleccionadas);
                    $('#reparaciones_id').trigger('change');
                    cargarDetallesMantenimientoParaEdicion(res.detalles_mantenimiento);
                    }
                
            });
            } 

            function imprimirFunc(id) {
                $.ajax({
                    type: "POST",
                    url: urlmantenimientosprint,
                    data: { id: id, _token: jQuery('meta[name="csrf-token"]').attr('content') },
                    success: function(response) {
                        // Abre una nueva ventana con la URL del PDF
                        window.open(response.url, '_blank');
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
            function imprimirGenFunc(){
                $.ajax({
                    type:"POST",
                    url: urlmantenimientosprintgen,
                    data: {_token: jQuery('meta[name="csrf-token"]').attr('content') },
                    success: function(response){
                        window.open(response.url, '_blank');
                    },
                    error: function(xhr, status, error){
                        console.error(xhr.responseText);
                    }
                });
            }
            function deleteFunc(id){
            if (confirm("¿Borrar Registro?") == true) {
                var id = id;
                // ajax
                $.ajax({
                    type:"POST",
                    url: urlmantenimientosdelete,
                    data: { id: id, _token: $('meta[name="csrf-token"]').attr('content') },
                    dataType: 'json',
                    success: function(res){
                        var tableex = new DataTable('#mantenimientos');
                        tableex.ajax.reload();
                        tableex.draw(false);
                    }
                });
            }
            }

            jQuery('#MantenimientosForm').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type:'POST',
                url: urlmantenimientosstore,
                data: formData,
                cache:false,
                contentType: false,
                processData: false,

                success: (data) => {
                    $("#mantenimientos-modal").modal('hide');
                    
                    var tableex = new DataTable('#mantenimientos');
                        tableex.ajax.reload();
                        tableex.draw(false);
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
    </div>
@endsection