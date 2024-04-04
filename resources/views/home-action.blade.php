<div class="btn-group" role="group" aria-label="Vertical button group">
    @isset($fecha_inicio_vehi)
        <a href="javascript:void(0);" id="print-compnay" onClick="imprimirFunc({{ $id }}, {{ $fecha_inicio_vehi }}, {{ $fecha_fin_vehi }})" data-toggle="tooltip" title="Imprimir" class="print btn btn-warning">
            <i class="fas fa-print"></i> 
        </a>
    @else
        <a href="javascript:void(0);" id="print-compnay" onClick="imprimirFunc({{ $id }}, null, null)" data-toggle="tooltip" title="Imprimir todos los mantenimientos" class="print btn btn-warning">
            <i class="fas fa-print"></i> 
        </a>
    @endisset
</div>
