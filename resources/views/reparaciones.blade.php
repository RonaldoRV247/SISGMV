@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <script>
        $.noConflict();
        jQuery( document ).ready(function( $ ) {
            $('#reparaciones').DataTable({
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
                                ajax: "{{ url('reparaciones') }}",
                                columns: [
                                    { data: 'id', name: 'id' },
                                    { data: 'elemento', name: 'elemento' },
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
                    <h1 class="m-0">{{ __('Gestión de Reparaciones') }}</h1>
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
                            <a class="btn btn-primary" onClick="add()" href="javascript:void(0)"> Nuevo Registro</a>
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
                    <table class="table table-bordered table-hover" id="reparaciones" style="width:100%;text-align: center;">
                        <thead class="table-dark" style="width:100%;text-align: center;">
                            <tr>
                                <th>ID</th>
                                <th>ELEMENTO</th>
                                <th>OPCIONES</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            
            <!-- boostrap reparaciones model -->
            <div class="modal fade" id="reparaciones-modal" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Reparaciones</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="javascript:void(0)" id="ReparacionesForm" name="ReparacionesForm" class="form-horizontal" method="POST" enctype="multipart/form-data">
                            @csrf    
                            <input type="hidden" name="id" id="id">
                                <div class="form-group">
                                    <label for="elemento" class="col-sm-2 control-label">Elemento</label>
                                        <div class="col-sm-12">
                                        <input type="text" class="form-control" id="elemento" name="elemento" placeholder="Ingresa elemento" required>
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
                $('#ReparacionesForm').trigger("reset");
                $('#ReparacionesModal').html("Add Reparaciones");
                $('#reparaciones-modal').modal('show');
                $('#id').val('');
            }   
                
            function editFunc(id){
                $.ajax({
                    type:"POST",
                    url: "{{ url('reparaciones/edit') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){
                        $('#ReparacionesModal').html("Editar Reparaciones");
                        $('#reparaciones-modal').modal('show');
                        $('#id').val(res.id);
                        $('#elemento').val(res.elemento);
                    }
                    
                });
            }  
            function imprimirFunc(id) {
                $.ajax({
                    type: "POST",
                    url: "{{ url('reparaciones/print')}}",
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
                if (confirm("¿Borrar Registro?\nRecuerde que para eliminar una reparación, esta no debe tener ningún mantenimiento asignado.") == true) {
                    var id = id;
                    // ajax
                    $.ajax({
                        type:"POST",
                        url: "{{ url('reparaciones/delete') }}",
                        data: { id: id },
                        dataType: 'json',
                        success: function(res){
                            var tableex = new DataTable('#reparaciones');
                            tableex.ajax.reload();
                            tableex.draw(false);
                        }
                    });
                }
            }
            
            jQuery('#ReparacionesForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type:'POST',
                    url: "{{ url('reparaciones/store')}}",
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,

                    success: (data) => {
                        $("#reparaciones-modal").modal('hide');
                        /*var onTable = $('#reparaciones').dataTable()._fnAjaxUpdate();
                        onTable.fnDraw(false);*/
                        var tableex = new DataTable('#reparaciones');
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
@endsection