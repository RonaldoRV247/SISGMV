@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <script>
        $.noConflict();
        jQuery( document ).ready(function( $ ) {
            $('#proveedores').DataTable({
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
                                ajax: "{{ url('proveedores') }}",
                                columns: [
                                    { data: 'id', name: 'id' },
                                    { data: 'ruc', name: 'ruc' },
                                    { data: 'nombre', name: 'nombre' },
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
                    <h1 class="m-0">{{ __('Gestión de Proveedores') }}</h1>
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
                            <a class="btn btn-primary" onClick="add()" href="javascript:void(0)"> Nuevo Proveedor</a>
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
                    <table class="table table-bordered table-hover" id="proveedores" style="width:100%;text-align: center;">
                        <thead class="table-dark" style="width:100%;text-align: center;">
                            <tr>
                                <th>ID</th>
                                <th>RUC</th>
                                <th>NOMBRE</th>
                                <th>OPCIONES</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            
            <!-- boostrap proveedores model -->
            <div class="modal fade" id="proveedores-modal" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Proveedores</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="javascript:void(0)" id="ProveedoresForm" name="ProveedoresForm" class="form-horizontal" method="POST" enctype="multipart/form-data">
                            @csrf    
                            <input type="hidden" name="id" id="id">
                                <div class="form-group">
                                    <label for="ruc" class="col-sm-2 control-label">RUC</label>
                                        <div class="col-sm-12">
                                        <input type="number" class="form-control" id="ruc" name="ruc" placeholder="Ingresa RUC" required maxlength="11" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" />
                                    </div>
                                </div>  
                                <div class="form-group">
                                    <label for="nombre" class="col-sm-2 control-label">NOMBRE</label>
                                        <div class="col-sm-12">
                                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingresa Nombre" maxlength="90" required>
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
                $('#ProveedoresForm').trigger("reset");
                $('#ProveedoresModal').html("Add Proveedores");
                $('#proveedores-modal').modal('show');
                $('#id').val('');
            }   
                
            function editFunc(id){
                $.ajax({
                    type:"POST",
                    url: "{{ url('proveedores/edit') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){
                        $('#ProveedoresModal').html("Editar Proveedores");
                        $('#proveedores-modal').modal('show');
                        $('#id').val(res.id);
                        $('#ruc').val(res.ruc);
                        $('#nombre').val(res.nombre);
                    }
                    
                });
            }
            function imprimirFunc(id) {
                $('#loading-spinner').show();
                $.ajax({
                    type: "POST",
                    url: "{{ url('proveedores/print')}}",
                    data: { id: id },
                    success: function(response) {
                        $('#loading-spinner').hide();
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
                        })
                    },
                    rror: function(xhr, status, error) {
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
            
            function deleteFunc(id){
                Swal.fire({
                    title: '¿Borrar Registro?',
                    html: '¡No podrás revertir esto!<br>Recuerde que para eliminar un proveedor, este no debe tener ningún mantenimiento asignado.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText:'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) =>{
                    if (result.isConfirmed) {
                        $.ajax({
                            type:"POST",
                            url: "{{ url('proveedores/delete') }}",
                            data: { id: id },
                            dataType: 'json',
                            success: function(res){
                                var tableex = new DataTable('#proveedores');
                                tableex.ajax.reload();
                                tableex.draw(false);

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
                                    title: "Se eliminó el registro exitosamente"
                                    });
                            },
                            error: function(xhr, status, error){
                                if (xhr.status === 403) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Permiso denegado',
                                        text: xhr.responseJSON.error || 'No tienes permiso para realizar esta acción.'
                                    });
                                } else {
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
                                    title: "Hubo un problema al eliminar el registro."
                                    });
                                    console.error(xhr.responseText);
                                }}
                        });
                    }
                });
            }
            
            jQuery('#ProveedoresForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type:'POST',
                    url: "{{ url('proveedores/store')}}",
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,

                    success: (data) => {
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
                        title: "Acción exitosa"
                        });
                        $("#proveedores-modal").modal('hide');
                        var tableex = new DataTable('#proveedores');
                            tableex.ajax.reload();
                            tableex.draw(false);
                        
                        $("#btn-guardar").html('Guardar');
                        $("#btn-guardar"). attr("disabled", false);
                    },
                    error: function(xhr) {
                        var errorMessage = JSON.parse(xhr.responseText).message;
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
                        title: "Error al registrar:"+ errorMessage
                        });
                    }
                });
            });
            </script>
                </div>   
            </div><!--Row-->
        </div><!-- /.container-fluid -->
    </div><!-- /.content -->
@endsection