$.noConflict();
var urlmantenimientos = '/mantenimientos';
var urlmantenimientosedit = '/mantenimientos/edit';
var urlmantenimientosdelete = '/mantenimientos/delete';
var urlmantenimientosstore = '/mantenimientos/store';
var urlmantenimientosprint = '/mantenimientos/print';
var urlmantenimientosprintgen = '/mantenimientos/printgen';
        

jQuery( document ).ready(function( $ ) {
    
    $('#mantenimientos').DataTable({
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
                        ajax: urlmantenimientos,
                        columns: [
                            { data: 'id', name: 'id' },
                            { data: 'tipo', name: 'tipo' },
                            { data: 'expediente', name: 'expediente' },
                            { data: 'fecha_requerimiento', name: 'fecha_requerimiento' },
                            { data: 'fecha_conformidad_servicio', name: 'fecha_conformidad_servicio' },
                            { data: 'fecha_ingreso_taller', name: 'fecha_ingreso_taller' },
                            { data: 'fecha_salida_taller', name: 'fecha_salida_taller' },
                            { data: 'vehiculox', name: 'vehiculox' },
                            { data: 'proveedorx', name: 'proveedorx' },
                            /*{
                                data:'estado',
                                name:'estado',
                                render: function(data) {
                                    var badges = data.split(' - ');
                                    var estado = badges[0].trim();
                                    var estadoClass = '';
                                    switch (estado) {
                                        case 'Completado':
                                            estadoClass = 'badge bg-primary';
                                            break;
                                        case 'En curso':
                                            estadoClass = 'badge bg-warning';
                                            break;
                                        case 'Por validar':
                                            estadoClass = 'badge bg-succes';
                                            break;
                                        case 'Solicitado':
                                            estadoClass = 'badge bg-secondary';
                                            break;
                                        default:
                                            estadoClass = 'badge bg-danger';
                                        }
                                        return '<span class="' + estadoClass + '">' + estado + '</span>'
                                }
                            },*/
                            { data: 'action', name: 'action', orderable: false},
                        ],
                        order: [[0, '']]
    });
    $('#tipo').select2({
        language: {
            noResults: function() {return "No hay resultado";},
            searching: function() {return "Buscando..";}
            },
        placeholder: "Selecciona un tipo",
        allowClear: true,
        dropdownParent: $('#mantenimientos-modal'),
        theme: 'bootstrap-5',
        width: '100%',
        minimunResultsForSearch: Infinity,
    });

    $('#proveedores_id').select2({
        language: {
            noResults: function() {return "No hay resultado";},
            searching: function() {return "Buscando..";}
            },
        placeholder: "Selecciona un proveedor",
        allowClear: true,
        dropdownParent: $('#mantenimientos-modal'),
        theme: 'bootstrap-5',
        width: '100%',
        minimunResultsForSearch: Infinity,
    });
        

        $('#vehiculos_id').select2({
        language: {
            noResults: function() {return "No hay resultado";},
            searching: function() {return "Buscando..";}
            },
        placeholder: "Selecciona un vehiculo",
        allowClear: true,
        dropdownParent: $('#mantenimientos-modal'),
        theme: 'bootstrap-5',
        width: '100%',
        minimunResultsForSearch: Infinity,
    });

    $('#reparaciones_id').select2({
        language: {
            noResults: function() {return "No hay resultado";},
            searching: function() {return "Buscando..";}
            },
        placeholder: "Selecciona una o más reparaciones",
        allowClear: true,
        dropdownParent: $('#mantenimientos-modal'),
        theme: 'bootstrap-5',
        width:'100%',
        minimunResultsForSearch: Infinity,
    });$('#reparaciones_id').val(null).trigger('change');

    $('#tipo').on("select2:unselect", function (e) {
    $(this).val('').trigger('change');
    e.preventDefault();
    });
    $('#vehiculos_id').on("select2:unselect", function (e) {
    $(this).val('').trigger('change');
    e.preventDefault();
    });
    $('#proveedores_id').on("select2:unselect", function (e) {
    $(this).val('').trigger('change');
    e.preventDefault();
    });
    $('#reparaciones_id').on("select2:unselect", function (e) {
    e.preventDefault();
    });

    function limpiarSelect2() {
        $('#tipo').val(null).trigger('change');
        $('#proveedores_id').val(null).trigger('change');
        $('#vehiculos_id').val(null).trigger('change');
        $('#reparaciones_id').val(null).trigger('change');
        $('#select2-proveedores_id-container').val(null).trigger('change');
        $('#select2-tipo-container').val(null).trigger('change');
        $('#select2-vehiculos_id-container').val(null).trigger('change');
        $('#select2-reparaciones_id-container').empty().val(null).trigger('change');
        $('#precios-container').empty().val(null).trigger('change');
    }

    jQuery('#mantenimientos-modal').on('hidden.bs.modal', function (event) {
        limpiarSelect2();
    });
});
