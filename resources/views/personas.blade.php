@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <script>
        $.noConflict();
        jQuery( document ).ready(function( $ ) {
            $('#personas').DataTable({
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
                                ajax: "{{ url('personas') }}",
                                columns: [
                                    { data: 'id', name: 'id' },
                                    { data: 'nombre', name: 'nombre' },
                                    { data: 'apellidos', name: 'apellidos' },
                                    { data: 'celular', name: 'celular' },
                                    { data: 'vehiculos', name: 'vehiculos' },
                                    { data: 'action', name: 'action', orderable: false},
                                ],
                                order: [[0, 'desc']]
            });
            
        });
    </script>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Gestión de Operarios') }}</h1>
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
                            <a class="btn btn-primary" onClick="add()" href="javascript:void(0)"> Nuevo Operario</a>
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
                    <table class="table table-bordered table-hover" id="personas" style="width:100%;text-align: center;">
                        <thead class="table-dark" style="width:100%;text-align: center;">
                            <tr>
                                <th>ID</th>
                                <th>NOMBRE</th>
                                <th>APELLIDOS</th>
                                <th>CELULAR</th>
                                <th>VEHÍCULOS A CARGO</th>
                                <th>OPCIONES</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            
            <!-- boostrap personas model -->
            <div class="modal fade" id="personas-modal" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Operarios</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="javascript:void(0)" id="PersonasForm" name="PersonasForm" class="form-horizontal" method="POST" enctype="multipart/form-data">
                            @csrf    
                            <input type="hidden" name="id" id="id">
                                <div class="form-group">
                                    <label for="nombre" class="col-sm-2 control-label">Nombres</label>
                                        <div class="col-sm-12">
                                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingresa Nombres" required>
                                    </div>
                                </div>  
                                <div class="form-group">
                                    <label for="apellidos" class="col-sm-2 control-label">Apellidos</label>
                                        <div class="col-sm-12">
                                        <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Ingresa Apellidos"required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="celular" class="col-sm-2 control-label">Celular</label>
                                        <div class="col-sm-12">
                                        <input type="number" class="form-control" id="celular" name="celular" placeholder="Ingresa Celular"maxlength="9" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" />
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
                $('#PersonasForm').trigger("reset");
                $('#PersonasModal').html("Add Personas");
                $('#personas-modal').modal('show');
                $('#id').val('');
            }   
                
            function editFunc(id){
                $.ajax({
                    type:"POST",
                    url: "{{ url('personas/edit') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){
                        $('#PersonasModal').html("Editar Personas");
                        $('#personas-modal').modal('show');
                        $('#id').val(res.id);
                        $('#nombre').val(res.nombre);
                        $('#apellidos').val(res.apellidos);
                        $('#celular').val(res.celular);
                    }
                    
                });
            } 
            function imprimirFunc(id) {
                $.ajax({
                    type: "POST",
                    url: "{{ url('personas/print')}}",
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
            
            function deleteFunc(id){
                if (confirm("¿Borrar Registro? \nRecuerde que para eliminar a un operario, este no debe tener ningún vehículo asignado. ") == true) {
                    var id = id;
                    // ajax
                    $.ajax({
                        type:"POST",
                        url: "{{ url('personas/delete') }}",
                        data: { id: id },
                        dataType: 'json',
                        success: function(res){
                            var tableex = new DataTable('#personas');
                            tableex.ajax.reload();
                            tableex.draw(false);
                        }
                    });
                }
            }
            
            jQuery('#PersonasForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type:'POST',
                    url: "{{ url('personas/store')}}",
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,

                    success: (data) => {
                        $("#personas-modal").modal('hide');
                        /*var onTable = $('#personas').dataTable()._fnAjaxUpdate();
                        onTable.fnDraw(false);*/
                        var tableex = new DataTable('#personas');
                            tableex.ajax.reload();
                            tableex.draw(false);
                        
                        $("#btn-guardar").html('Guardar');
                        $("#btn-guardar"). attr("disabled", false);
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            });
            </script>
                </div>   
            </div><!--Row-->
        </div><!-- /.container-fluid -->
    </div><!-- /.content -->
@endsection