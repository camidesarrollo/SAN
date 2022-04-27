@extends('layouts.main')
@section('contenido')

</style>
<!-- //CZ 75 -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<main id="content">
    <section class="p-1 cabecera">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <!-- CZ SPRINT 76 -->
                    <h5><i class="{{$icono}} mr-2"></i>Gestionar OLN</h5>
                    <!-- CZ SPRINT 76 -->
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container-fluid">
            <div class="card p-4 shadow-sm">
                <table class="table table-bordered table-hover table-striped w-100" cellspacing="0"
                    id="tabla_oln">
                    <thead>
                        <tr>
                            <th colspan="8">
                                <div id="filtros-table"></div>
                            </th>
                        </tr>
                        <tr>
                            <th class="text-center">Acción</th>
                            <th class="text-center">Es OLN</th>
                            <th class="text-center">ID comuna</th>
                            <th class="text-center">Comuna</th>
                            <th class="text-center">ID Región</th>
                            <th class="text-center">Región</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </section>
    
</main>
@include('administrador.administrar_oln.dialog_box')
@endsection

@section('script')
<script>
$(document).ready(function() {
    getOln();
})

function getOln() {
    var data_tabla_oln = $('#tabla_oln').DataTable();
    data_tabla_oln.clear().destroy();

    data_tabla_oln = $('#tabla_oln').DataTable({
        // "fixedHeader": { header:true },
        "dom": '<lf<t>ip>',
        //"language"	: { "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json" },
        "language": {
            "url": "{{ route('index') }}/js/dataTables.spanish.json"
        },
        "order": [
            //[ 2, "desc"],
            [4, "asc"]
        ],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "{{ route('get.oln') }}",
            "error": function(jqXHR, text, error) {
                console.log(error);
                if (ajaxFlag < ajaxFlagTope) {
                    ajaxFlag++;
                    getOln();
                } else {
                    desbloquearPantalla();
                    manejoPeticionesFailAjax(jqXHR, text, error);
                }
            },
        },
        "columnDefs": [{
                "targets": 0, //ACCION
                "className": 'dt-head-center dt-body-left',
                "createdCell": function(td, cellData, rowData, row, col) {
                    $(td).css("vertical-align", "middle");

                }
            },
            {
                "targets": 1, //ES OLN
                "className": 'dt-head-center dt-body-center',
                "createdCell": function(td, cellData, rowData, row, col) {
                    $(td).css("vertical-align", "middle");

                }
            },
            {
                "targets": 2, //ID COMUNA
                "className": 'dt-head-center dt-body-center',
                "createdCell": function(td, cellData, rowData, row, col) {
                    $(td).css("vertical-align", "middle");

                }
            },
            {
                "targets": 3, //COMUNA
                "className": 'dt-head-center dt-body-center',
                "createdCell": function(td, cellData, rowData, row, col) {
                    $(td).css("vertical-align", "middle");

                }
            },

            {
                "targets": 4, //ID REGION
                "className": 'dt-head-center dt-body-center',
                "createdCell": function(td, cellData, rowData, row, col) {
                    $(td).css("vertical-align", "middle");

                }
            },
            {
                "targets": 5, //REGION
                "className": 'dt-head-center dt-body-center',
                "createdCell": function(td, cellData, rowData, row, col) {
                    $(td).css("vertical-align", "middle");
                }
            },
        ],
        "columns": [{
            "data": "vigente",
                "name": "vigente",
                "className": "text-center",
                "visible": true,
                "orderable": true,
                "searchable": true,
                "render": function(data,type,row){
					var html = '';
                    if(data == 'N'){
                        html += `<button type="button" class="btn btn-outline-success crear_oln" onclick="confirmacionhabilitarOLN(${row.com_id},'${row.comuna}')" >Crear OLN</button>`;

                    }else{
                        html +=`<button type="button" class="btn btn-outline-danger deshabilitar_oln" onclick="confirmaciondeshabilitarOLN(${row.com_id},'${row.comuna}')">Deshabilitar</button>`;
                    }
                    return html;
				}
            },
            {
                "data": "vigente",
                "name": "vigente",
                "className": "text-center",
                "visible": true,
                "orderable": true,
                "searchable": true,
                "render": function(data,type,row){
					var html = '';
                    if(data == 'N'){
                        html += '<svg style="color: #e74a3b;border-color: #e74a;" xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-x-octagon-fill" viewBox="0 0 16 16"><path d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zm-6.106 4.5L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708z"></path></svg>';

                    }else{
                        html +='<svg style="color: #1cc88a;border-color: #1cc88a;" xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path><path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"></path></svg>';
                    }
                    return html;
				}
            },
            {
                "data": "id_comuna",
                "name": "id_comuna",
                "className": "text-center",
                "visible": true,
                "orderable": true,
                "searchable": false
            },
            {
                "data": "comuna",
                "name": "comuna",
                "className": "text-center",
                "visible": true,
                "orderable": true,
                "searchable": true,
                "width": "85px"
            },
            {
                "data": "id_region",
                "name": "id_region",
                "className": "text-center",
                "visible": true,
                "orderable": true,
                "searchable": false,
                "width": "85px"
            },
            {
                "data": "region",
                "name": "region",
                "className": "text-center",
                "visible": true,
                "orderable": true,
                "searchable": true
            },
        ],
    });

}
function confirmacionhabilitarOLN(id_comuna,comuna){
    $('#habilitarOLN').attr('onClick', 'habilitarOLN('+id_comuna+');');
    $("#mensaje").html("<h5 >¿Está seguro de crear la nueva OLN <b ></b>"+comuna+"</h5><p>Para esta nueva OLN el sistema creará su mapa de oferta y quedará habilitada para la creación de usuarios.</p>")
    $('#dialog_box').modal('show');
}
function confirmaciondeshabilitarOLN(id_comuna,comuna){
    $('#habilitarOLN').attr('onClick', 'deshabilitarOLN('+id_comuna+');');
    $("#mensaje").html("<h5 >¿Está seguro que desea deshabilitar la  OLN <b >"+comuna+"</b></h5>")
    $('#dialog_box').modal('show');
}
function habilitarOLN(id_comuna){

    $('#dialog_box').modal('hide');

    bloquearPantalla();
    let data = new Object();
    data.id_comuna 	= id_comuna;
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });
    console.log(data);
    $.ajax({
        type: "POST",
        url: "{{route('administar.habilitarOLN')}}",
        data: data
    }).done(function(resp){
        if(resp.estado == 1){
            mensajeTemporalRespuestas(1, resp.mensaje);	
        }else{
            mensajeTemporalRespuestas(0, 'Ha ocurrido un error inesperado');	
        }
        desbloquearPantalla();
        getOln();
    }).fail(function(objeto, tipoError, errorHttp){
        desbloquearPantalla();
        manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
        return false;
    });
}

function deshabilitarOLN(id_comuna){
    $('#dialog_box').modal('hide');
    bloquearPantalla();
    let data = new Object();
    data.id_comuna 	= id_comuna;
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });
    console.log(data);
    $.ajax({
        type: "POST",
        url: "{{route('administar.deshabilitarOLN')}}",
        data: data
    }).done(function(resp){
        if(resp.estado == 1){
            mensajeTemporalRespuestas(1, resp.mensaje);	
        }else{
            mensajeTemporalRespuestas(0, 'Ha ocurrido un error inesperado');	
        }
        desbloquearPantalla();
        getOln();
    }).fail(function(objeto, tipoError, errorHttp){
        desbloquearPantalla();
        manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
        return false;
    });
}
</script>

@endsection