<!-- //CZ SPRINT 73 -->
@extends('layouts.main')
@section('contenido')
<div class="container-fluid">
    <div id="ficha-nna">
        <div id="datos-nna" class="sticky-top">
            <div class="m-3">
                <h5 class="">

                    <img class="mr-3" src="/img/ico-nna.png">
                    {{$datos_NNA->per_nom}}
                    <small><i class="fa fa-id-card ml-3 mr-2"></i> {{$run_formato}} </small>
                    <small><i class="fa fa-birthday-cake ml-3 mr-2"></i> {{$datos_NNA->per_ani}} años</small>
                </h5>
            </div>
        </div>

        <div class="card shadow p-4 ">
            @if($tablaNomina == true)
            <div class="sticky-top">
                <div class="m-3">
                    <h5> <i class="fa fa-address-book"></i>NNA en Nómina Comunal del Mes</h5>
                    <section>
                        <div class="container-fluid">
                            <div class="card p-4 shadow-sm">
                                <table class="table table-bordered table-hover table-striped w-100" cellspacing="0"
                                    id="tabla_nomina">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="display: none;">R.U.N</th>
                                            <th class="text-center">Nombre NNA</th>
                                            <th class="text-center">Mes/Año</th>
                                            <th class="text-center">Prioridad</th>
                                            <th class="text-center">Estado Caso</th>
                                            <th class="text-center">En Programa<br>SENAME</th>
                                            <th class="text-center">Acciones</th>
                                            <th class="text-center">RUNSINFORMATO</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            @endif
            @if($tablaCasoGestion == true)
            <div class="sticky-top">
                <div class="m-3">
                    <h5> <i class="fa fa-folder-open"></i>NNA en Gestión de Casos</h5>
                    <section>
                        <div class="container-fluid">
                            <div class="card p-4 shadow-sm">
                                <table class="table table-bordered table-hover table-striped w-100" cellspacing="0"
                                    id="tabla_oficina_local">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="display: none;">R.U.N</th>
                                            <th class="text-center">Nombre NNA</th>
                                            <th class="text-center">Tipo</th>
                                            <th class="text-center">Periodo Nómina</th>
                                            <th class="text-center">Alerta<br> Nómina</th>
                                            <th class="text-center">Últimas<br>Alertas SAN</th>
                                            <th class="text-center">Prioridad</th>
                                            <th class="text-center">Fecha de Asignación</th>
                                            <th class="text-center">Gestores</th>
                                            <th class="text-center">Estado Gesti&oacute;n Caso</th>
                                            <th class="text-center">Terapeuta</th>
                                            <th class="text-center">Estado Terapia Familiar</th>
                                            <th class="text-center">Acciones</th>
                                            <th class="text-center">RUNSINFORMATO</th>
                                            <th class="text-center">Caso</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            @endif
            @if($tablaCasoDesestimados == true)
            <div class="sticky-top">
                <div class="m-3">
                    <h5> <i class="fa fa-archive"></i> NNA Egresado o Destimado</h5>
                    <section>
                        <div class="container-fluid">
                            <div class="card p-4 shadow-sm">
                                <table id="desestimados" class="table table-hover table-striped w-100">
                                    <thead>
                                        <tr>
                                            <th style="display: none"></th>
                                            <th style="display: none"></th>
                                            <th style="display: none"></th>
                                            <th>Nombre NNA</th>
                                            <th>Tipo</th>
                                            <th>Periodo Nomina</th>
                                            <th>Alerta Nómina</th>
                                            <th>Últimas<br>Alertas SAN</th>
                                            <th>Prioridad</th>
                                            <th>Fecha de asignación</th>
                                            <th>Nombre Gestor</th>
                                            <th>Estado Gesti&oacute;n Caso
                                            </th>
                                            <th>Nombre Terapeuta</th>
                                            <th>Estado Terapia</th>
                                            <th>Seguimiento</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@include('caso.modal_bitacoras.historial_caso')
@include('caso.modal_bitacoras.historial_terapia')
@include('caso.modal_bitacoras.historial_casos_anteriores')
@endsection
@section('script')
<script type="text/javascript">
$(document).ready(function() {
    @if($tablaCasoDesestimados == true)
    desestimadoNNA();
    @endif
    @if($tablaCasoGestion == true)
    gestionNNA();
    @endif
    @if($tablaNomina == true)
    nnaNomina();
    @endif
});
let data = new Object();
data.run = {{$run}};
@if($tablaCasoDesestimados == true)

function desestimadoNNA() {
    desestimados = $('#desestimados').DataTable({
        //"fixedHeader": { header:true },
        "dom": '<lf<t>ip>',
        "order": [
            //[2, "desc"],
            [4, "desc"]
        ],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "{{route('data.casos.desestimadoNNA')}}",
            "data": data,
            "error": function(xhr, status) {
                desbloquearPantalla();

                let mensaje =
                    "Hubo un error al momento de cargar el listado de casos desestimados. Por favor intente nuevamente.";

                if (xhr.status === 0) {
                    alert(mensaje + "\n\n- Sin conexión: Verifique su red o intente nuevamente.");

                } else if (xhr.status == 404) {
                    alert(mensaje + "\n\n- Página solicitada no encontrada [404].");

                } else if (xhr.status == 500) {
                    alert(mensaje + "\n\n- Error interno del servidor [500].");

                } else if (tipoError === 'parsererror') {
                    alert(mensaje + "\n\n- Error al manipular respuesta JSON.");

                } else if (tipoError === 'timeout') {
                    alert(mensaje + "\n\n- Error de tiempo de espera.");

                } else if (tipoError === 'abort') {
                    alert(mensaje + "\n\n- Solicitud Ajax abortada.");

                } else {
                    alert(mensaje);

                    console.log('Error no capturado: ' + xhr.responseText);
                }

                console.log(xhr);
                return false;
            }
        },
        "rowGroup": {
            startRender: function(rows, group) {
                return "Caso " + group;
            },
            dataSrc: "cas_id"
        },
        "columns": [
            {
                "data": "cas_id",
                "name": "cas_id",
                "className": "text-center",
                "visible": false,
            },
            {
                "data": "nna_run_con_formato",
                "name": "nna_run_con_formato",
                "className": "text-center",
                "visible": false,
                "render": function(data, type, full, meta) {
                    let rut = esconderRut(data, "{{ config('constantes.ofuscacion_run') }}");
                    return rut;
                }
            },
            {
                "data": "nna_run",
                "name": "nna_run",
                "className": "text-center",
                "visible": false,
            },
            {
                "data": "nna_nombre_completo",
                "name": "nna_nombre_completo",
                "className": "text-left",
                "visible": true,
                "orderable": true,
                "searchable": true,
                "render": function(data, type, full, meta) {
                    //return '<label data-toggle="tooltip" title="R.U.N.: '+full.nna_run_con_formato+'">'+data+'</label>';
                    html = '<label data-toggle="tooltip" data-html="true" title="R.U.N.: ' + full
                        .nna_run_con_formato + '<br />Nombre completo:<br />' + full
                        .nna_nombre_completo + '">' + full.nna_nom + ' ' + full.nna_ape_pat +
                        '</label>';
                    return html;
                }
            },
            {
                "data": "per_ind",
                "name": "per_ind",
                "className": "text-left",
                "visible": true,
                "orderable": true,
                "searchable": true,
                "render": function(data, type, full, meta) {
                    console.log(data);
                    var html = "";
                    if (data == 1) {
                        html = 'Indice';
                    } else {
                        html = 'Secundario';
                    }
                    return html;
                }
            },
            {
                "data": "periodo",
                "name": "periodo",
                "className": "text-center",
                "visible": true,
                "orderable": true,
                "searchable": true,
                "render" : function (data, type, full, meta){
                    let fechasplit = data.split("");
                    var fecha = new Date(fechasplit[0]+fechasplit[1]+fechasplit[2]+fechasplit[3]+'/'+fechasplit[4]+fechasplit[5]);
                    var options = { year: 'numeric', month: 'long' };

                    console.log(
                    fecha.toLocaleDateString("es-ES", options)
                    );

                    return fecha.toLocaleDateString("es-ES", options).charAt(0).toUpperCase() + fecha.toLocaleDateString("es-ES", options).slice(1).toLowerCase();
                }
            },
            {
                "data": "n_alertas",
                "name": "n_alertas",
                "className": "text-center",
                "width": "85px",
                "orderable": true,
                "searchable": false,
                "render": function(data, type, row) {
                    return listarIconoAlerta(row.n_alertas);
                }
            },
            {
                "data": "n_am",
                "name": "n_am",
                "className": "text-center",
                "orderable": true,
                "searchable": false,
                "render": function(data, type, row) {
                    return listarIconoAlerta(row.n_am);
                }
            },
            {
                "data": "score",
                "name": "score",
                "className": "text-center",
                "visible": true,
                "orderable": true,
                "searchable": false
            },
            {
                "data": "fec_cre",
                "name": "fec_cre",
                "className": "text-center",
                "orderable": true,
                "searchable": false
            },
            {
                "data": "nombres",
                "name": "nombres",
                "className": "text-center",
                "visible": true,
                "orderable": true,
                "searchable": true,
                "render": function(data, type, row) {
                    return data + ' ' + row.apellido_paterno + ' ' + row.apellido_materno;
                }
            },
            {
                "name": "est_cas_nom",
                "className": "text-left",
                "orderable": true,
                "className": "text-center",
                "render": function(data, type, row) {

                    // return row.est_cas_nom;

                    //####### Se agrega icono de pausa en los casos que corresponda ##############
                    let html = row.est_cas_nom;
                    if (row.cas_est_pau == 0) {
                        html +=
                            '<br><i class="far fa-pause-circle fa-2x" style="color:red;" title="Caso Pausado"></i>';
                    }
                    html += '<label style="display: none;">' + row.cas_id + '</label>';
                    return html;

                }
            },
            {
                "data": "nombre_ter",
                "name": "nombre_ter",
                "className": "text-center",
                "visible": true,
                "orderable": true,
                "searchable": true,
                "render": function(data, type, row) {
                    var html = "";
                    if (data != 'SIN TERAPIA') {
                        html = data + " " + row.ap_paterno_ter + " " + row.ap_materno_ter;
                    } else {
                        html = "SIN TERAPIA";

                    }
                    return html;

                }
            },
            {
                "data": "est_tera_nom",
                "name": "est_tera_nom",
                "className": "text-center",
                "visible": true,
                "orderable": true,
                "searchable": true
            },
            {
                "className": "text-center",
                "orderable": false,
                "searchable": false,
                "render": function(data, type, row) {
                    let html = '';
                    let cas_id = row.cas_id;
                    let est_cas = row.es_cas_id;
                    // INICIO CZ SPRINT 59
                    let urlFichaCompleta = $("#desestimados").attr("attr2");

                    // INICIO CZ SPRINT 63 Casos ingresados a ONL
                    urlFichaCompleta += '/' + row.run + '/' + row.cas_id;
                    // FIN CZ SPRINT 63 Casos ingresados a ONL

                    // FIN CZ SPRINT 59

                    if ((est_cas == {{config('constantes.nna_presenta_medida_proteccion') }}) || (est_cas == {{config('constantes.nna_vulneracion_derecho_delito')}}) || (est_cas == {{config('constantes.nna_vulneracion_derecho_no_delito')}})) {


                        html = '<button class="btn btn-success btn-sm" onclick="desestimaCasoDos(' +
                            cas_id + ', ' + est_cas +
                            ');" title="Agregar seguimiento" ><span class="oi oi-plus"></span></button>&nbsp;&nbsp;';

                        html += '<button class="btn btn-info btn-sm" onclick="verDetalleSeguimiento(' +
                            cas_id +
                            ');" title="Ver resumen de seguimiento"><span class="oi oi-eye"></span></button>';
                    } else {
                        html = '<b>No Aplica</b>';
                    }

                    return html;

                }
            },
            {
                "className": "text-center",
                "orderable": false,
                "searchable": false,
                "render": function(data, type, row) {
                    let html = '<div class="btn-group">';

                    html += '<button type="button" class="btn btn-info mr-2" id="detalle_' + row
                        .cas_id +
                        '" data-toggle="tooltip" data-placement="top" title="Ver Bitácora de Estados del Caso" onclick="abrirModalBitacora(' +
                        row.cas_id + ',' + "'" + row.nna_run_con_formato + "'" +
                        ')"><span class="oi oi-magnifying-glass"></button>';
                    if (row.ter_id != null) {
                        html +=
                            '<button type="button" class="btn btn-warning mr-2" data-toggle="tooltip" data-placement="top" title="Ver Bitácora de Estados de Terapia" onclick="abrirModalBitacoraTerapia(' +
                            row.cas_id + ',' + "'" + row.nna_run_con_formato + "'" +
                            ')"><span class="oi oi-magnifying-glass"></button>';
                    }
                    html += `<a href="{{ route('coordinador.caso.ficha') }}/${row.run}/${row.cas_id}" class="btn btn-primary w-100" style="margin-bottom: 5px;">Ficha NNA</a>`;

                    // INICIO CZ SPRINT 63 Casos ingresados a ONL 
               
                    // FIN CZ SPRINT 63 Casos ingresados a ONL

                    html += '</div>';

                    return html;

                }
            }
        ],
        "language": {
            "url": "{{ route('index') }}/js/dataTables.spanish.json"
        },
        "drawCallback": function(settings) {
            $('[data-toggle="tooltip"]').tooltip();
        },
    });
}
@endif
@if($tablaCasoGestion == true)

function gestionNNA() {
    var data_oficinaLocal = $('#tabla_oficina_local').DataTable();
    data_oficinaLocal.clear().destroy();

    $('#tabla_oficina_local').DataTable({
        "dom": '<lf<t>ip>',
        "language": {
            "url": "{{ route('index') }}/js/dataTables.spanish.json"
        },
        "order": [
            //[ 2, "desc"],
            [3, "desc"]
        ],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "{{ route('data.casos.gestionNNA') }}",
            "data": data
        },
        "rowGroup": {
            startRender: function(rows, group) {
                return "Caso " + group;
            },
            dataSrc: "cas_id"
        },
        "columns": [{
                "data": "nna_run_con_formato",
                "name": "nna_run_con_formato",
                "className": "text-center",
                "visible": false,
                "orderable": true,
                "searchable": true,
                "width": "90px",
                "render": function(data, type, row) {
                    let rut = esconderRut(data, "{{ config('constantes.ofuscacion_run') }}");
                    return rut;
                }
            },
            {
                "data": "nna_nombre_completo",
                "name": "nna_nombre_completo",
                "className": "text-left",
                "visible": true,
                "orderable": true,
                "searchable": true,
                "render": function(data, type, full, meta) {
                    let formato = formateoNombres(full.nna_nom, full.nna_ape_pat);
                    //return '<label data-toggle="tooltip" title="R.U.N.: '+full.nna_run_con_formato+'">'+data+'</label>';
                    return '<label data-toggle="tooltip" data-html="true" title="R.U.N.: ' + full
                        .nna_run_con_formato + '<br />Nombre completo:<br />' + full
                        .nna_nombre_completo + '">' + formato.nombre + ' ' + formato.ape_pat +
                        '</label>';
                }
            },
            {
                "data": "per_ind",
                "name": "per_ind",
                "className": "text-left",
                "visible": true,
                "orderable": true,
                "searchable": true,
                "render": function(data, type, full, meta) {
                    var html = "";
                    if (data == 1) {
                        html = 'Indice';
                    } else {
                        html = 'Secundario';
                    }
                    return html;
                }
            },
            {
                "data": "periodo",
                "name": "periodo",
                "className": "text-center",
                "visible": true,
                "orderable": true,
                "searchable": true,
                "render" : function (data, type, full, meta){
                    if (data != null){                    
                    let fechasplit = data.split("");
                    var fecha = new Date(fechasplit[0]+fechasplit[1]+fechasplit[2]+fechasplit[3]+'/'+fechasplit[4]+fechasplit[5]);
                    var options = { year: 'numeric', month: 'long' };

                    console.log(
                    fecha.toLocaleDateString("es-ES", options)
                    );
                    return fecha.toLocaleDateString("es-ES", options).charAt(0).toUpperCase() + fecha.toLocaleDateString("es-ES", options).slice(1).toLowerCase();
                }
                }
            },
            {
                "data": "n_alertas",
                "name": "n_alertas",
                "className": "text-center",
                "visible": true,
                "orderable": true,
                "searchable": false,
                "width": "70px",
                'render': function(data, type, full, meta) {
                    return listarIconoAlerta(full.n_alertas);
                }
            },
            {
                "data": "n_am",
                "name": "n_am",
                "className": "text-center",
                "visible": true,
                "orderable": true,
                "searchable": false,
                "width": "85px",
                'render': function(data, type, full, meta) {
                    return listarIconoAlerta(full.n_am);
                }
            },
            {
                "data": "score",
                "name": "score",
                "className": "text-center",
                "visible": true,
                "orderable": true,
                "searchable": false
            },
            {
                "data": "fec_cre",
                "name": "fec_cre",
                "className": "text-center",
                "visible": true,
                "orderable": true,
                "searchable": true
            },
            {
                "data": "nombres",
                "name": "nombres",
                "className": "text-center",
                "visible": true,
                "orderable": true,
                "searchable": true,
                "render": function(data, type, row) {
                    return data + ' ' + row.apellido_paterno + ' ' + row.apellido_materno;
                }
            },
            {
                "data": "est_cas_nom",
                "name": "est_cas_nom",
                "className": "text-center",
                "visible": true,
                "orderable": true,
                "searchable": true,
                "render": function(data, type, full, meta) {
                    if (full.n_casos > 1) {
                        let can_caso = full.n_casos - 1;
                        let title = "NNA con " + can_caso + " caso anteriormente registrado.";

                        if (can_caso > 1) title = "NNA con " + full.n_casos - 1 +
                            " casos anteriormente registrados.";

                        let html = full.est_cas_nom +
                            '<i class="fas fa-exclamation-circle fa-2x" style="color:#00a1b9;" title="' +
                            title + '"></i>';

                        if (full.cas_est_pau == 0) {
                            html +=
                                '<br><i class="far fa-pause-circle fa-2x" style="padding-top: 2px;color:red;" title="Caso Pausado"></i>';
                        }

                        return html;
                    } else {
                        let html = full.est_cas_nom;
                        if (full.cas_est_pau == 0) {
                            html +=
                                '<br><i class="far fa-pause-circle fa-2x" style="color:red;" title="Caso Pausado"></i>';
                        }
                        return html;
                    }
                }
            },
            {
                "data": "nombre_ter",
                "name": "nombre_ter",
                "className": "text-center",
                "visible": true,
                "orderable": true,
                "searchable": true,
                "render": function(data, type, row) {
                    var html = "";
                    if (data != 'SIN TERAPIA') {
                        html = data + " " + row.ap_paterno_ter + " " + row.ap_materno_ter;
                    } else {
                        html = "SIN TERAPIA";

                    }
                    return html;

                }
            },
            {
                "data": "est_tera_nom",
                "name": "est_tera_nom",
                "className": "text-center",
                "visible": true,
                "orderable": true,
                "searchable": true
            },
            {
                "data": "",
                "className": "text-center",
                "visible": true,
                "orderable": false,
                "searchable": false,
                'render': function(data, type, full, meta) {
                    let html = '<div class="btn-group">';

                    html += '<button type="button" class="btn btn-info mr-2" id="detalle_' + full
                        .cas_id +
                        '" data-toggle="tooltip" data-placement="top" title="Ver Bitácora de Estados del Caso" onclick="abrirModalBitacora(' +
                        full.cas_id + ',' + "'" + full.nna_run_con_formato + "'" +
                        ')"><span class="oi oi-magnifying-glass"></button>';
                    if(full.est_tera_nom != 'SIN TERAPIA'){
                        html +=
                        '<button type="button" class="btn btn-warning mr-2" data-toggle="tooltip" data-placement="top" title="Ver Bitácora de Estados de Terapia" onclick="abrirModalBitacoraTerapia(' +
                        full.cas_id + ',' + "'" + full.nna_run_con_formato + "'" +
                        ')"><span class="oi oi-magnifying-glass"></button>';
                    }
                    html += `<a href="{{ route('coordinador.caso.ficha') }}/${full.run}/${full.cas_id}" class="btn btn-primary w-100" style="margin-bottom: 5px;">Ficha NNA</a>`;

                    html += '</div>';

                    return html;
                }
            },
            {
                "data": "nna_run",
                "className": "text-center",
                "visible": false,
                "orderable": false,
                "searchable": true
            },
            {
                "data": "cas_id",
                "name": "cas_id",
                "className": "text-center",
                "visible": false,
                "orderable": false
            }
        ],
        "drawCallback": function(settings) {
            $("#totalNNA").text(settings._iRecordsTotal);
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
}
@endif
@if($tablaNomina == true)

function nnaNomina(){

    var data_nomina = $('#tabla_nomina').DataTable();
    data_nomina.clear().destroy();	

    data_nomina =	$('#tabla_nomina').DataTable({
        "dom": '<lf<t>ip>',
        "language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
        "order":[
            //[ 2, "desc"],
            [ 1, "desc" ]
        ],
        "processing": true,
        "serverSide": true,
        "ajax"		: {
            "url"  :  "{{ route('data.nnaNomina') }}",
            "error":  function(jqXHR, text, error){
                console.log(error);
                if (ajaxFlag < ajaxFlagTope){
                    ajaxFlag++;
                    listarNNA();
                }else{
                    desbloquearPantalla();
                    manejoPeticionesFailAjax(jqXHR, text, error);
                }
            },
            "data": data
        },
        "columnDefs": [ 
            {
                "targets": 		0, //NOMBRE NNA
                "className": 	'dt-head-center dt-body-left',
                "createdCell": function (td, cellData, rowData, row, col) {
                    $(td).css("vertical-align", "middle");

                
                }
            },
            {
                "targets": 		1, //periodo
                "className": 	'dt-head-center dt-body-left',
                "createdCell": function (td, cellData, rowData, row, col) {
                    $(td).css("vertical-align", "middle");
                
                }
            },
            
            {
                "targets": 		2, //PRIORIDAD
                "className": 	'dt-head-center dt-body-center',
                "createdCell": function (td, cellData, rowData, row, col) {
                    $(td).css("vertical-align", "middle");
                
                }
            },
            {
                "targets": 		3, //ESTADO CASO
                "className": 	'dt-head-center dt-body-center',
                "createdCell": function (td, cellData, rowData, row, col) {
                    $(td).css("vertical-align", "middle");
                
                }
            },
            {
                "targets": 		4, 
                "className": 	'dt-head-center dt-body-center',
                "createdCell": function (td, cellData, rowData, row, col) {
                    $(td).css("vertical-align", "middle");
                
                }
            },
            {
                "targets": 		5, //ALERTA NÓMINA  
                "className": 	'dt-head-center dt-body-center',
                "createdCell": function (td, cellData, rowData, row, col) {
                    $(td).css("vertical-align", "middle");
                
                }
            },
            {
                "targets": 		6, //ÚLTIMAS ALERTAS SAN
                "className": 	'dt-head-center dt-body-center',
                "createdCell": function (td, cellData, rowData, row, col) {
                    $(td).css("vertical-align", "middle");
                }
            },
        ],
        "columns"	: [
            {
            "data": 		"nna_run_con_formato",
            "name": 		"nna_run_con_formato",
            "className": 	"text-center",
            "visible": 	false,
            "orderable": 	true,
            "searchable": 	true,
            "render": function(data, type, row){ 
                let rut = esconderRut(data, "{{ config('constantes.ofuscacion_run') }}");
                return rut;
            }
            },
            {
                "data"		: "nna_nombre_completo",
                "name"		: "nna_nombre_completo",
                "className"	: "text-left",
                "visible"	: true,
                "orderable"	: true,
                "searchable": true,
                "render" : function (data, type, full, meta){
                    //return '<label data-toggle="tooltip" title="R.U.N.: '+full.nna_run_con_formato+'">'+data+'</label>';
                    return '<label data-toggle="tooltip" data-html="true" title="R.U.N.: ' + full.nna_run_con_formato + '<br />Nombre completo:<br />' + full.nna_nombre_completo + '">' + full.nna_nombre_completo + '</label>';
                }
            },
            {
                "data"		: "periodo",
                "name"		: "periodo",
                "className"	: "text-center",
                "visible"	: true,
                "orderable"	: true,
                "searchable": true,
                "render" : function (data, type, full, meta){
                    console.log(data.split(""));
                    let fechasplit = data.split("");
                    var fecha = new Date(fechasplit[0]+fechasplit[1]+fechasplit[2]+fechasplit[3]+'/'+fechasplit[4]+fechasplit[5]);
                    var options = { year: 'numeric', month: 'long' };

                    console.log(
                    fecha.toLocaleDateString("es-ES", options)
                    );
                    return fecha.toLocaleDateString("es-ES", options).charAt(0).toUpperCase() + fecha.toLocaleDateString("es-ES", options).slice(1).toLowerCase();
                }
            },
            {
            "data": 		"color",
            "name": 		"score",
            "className": 	"text-center",
            "visible": 	true,
            "orderable": 	true,
            "searchable": 	false
            },
            {
            "data": 		"est_cas_nom",
            "name": 		"est_cas_nom",
            "className": 	"text-center",
            "visible": 	true,
            "orderable": 	true,
            "searchable": 	true,
            "render" : function (data, type, full, meta){
                    if (full.n_casos > 1){
                        
                        let can_caso = full.n_casos - 1;
                        let title = "NNA con "+can_caso+" caso anteriormente registrado.";

                        if (can_caso > 1) title = "NNA con "+full.n_casos - 1+" casos anteriormente registrados.";

                        let html = full.est_cas_nom + '<i class="fas fa-exclamation-circle fa-2x" style="color:#00a1b9;" title="'+title+'"></i>';
                        if(full.est_cas_id > 6 && full.est_cas_id < 31){
                            html = '<button type="button" class="btn btn-info mr-2" id="detalleCasoAnterior" onclick="infoModalCasos('+full.run+');"><span class="oi oi-magnifying-glass"></span></button>';

                        }
                        if(full.cas_est_pau == 0){
                            html += '<br><i class="far fa-pause-circle fa-2x" style="padding-top: 2px;color:red;" title="Caso Pausado"></i>';
                        }
                        return html;
                    }else{ 
                        let html = ''; 
                        if(full.est_cas_id != null){
                            html += '<button type="button" class="btn btn-info mr-2" id="detalleCasoAnterior" onclick="infoModalCasos('+full.run+');"><span class="oi oi-magnifying-glass"></span></button>';
                        return html;
                    }else{
                        let html = full.est_cas_nom;
                        if(full.cas_est_pau == 0){
                            html += '<br><i class="far fa-pause-circle fa-2x" style="color:red;" title="Caso Pausado"></i>';
                        }
                        return html;
                    }
            }
            }
            },
            {
            "data": 		"sename",
            "name": 		"sename",
            "className": 	"text-center",
            "visible": 	true,
            "orderable": 	true,
            "searchable": 	true,
            "render" : function (data, type, full, meta){
                var html = '';
                    if(full.sename=="Si"){
                        html = '<span class="badge badge-danger" style="font-size: 17px;font-weight: 500;">'+full.sename+'</span>';
                    }
                    return html;
            }
            },
            {
                "data": 		"",
                "name": 		"",
                "visible": 		true,
                "orderable": 	false,
                "searchable": 	false,
                'render': function (data, type, full, meta) {
                    let html 		= "";
                    var cas_id; 
                    if(full.cas_id == null){
                        cas_id = 0; 
                    }else{
                        if(full.est_cas_fin == 1){
                            cas_id = 0;
                        }else{
                            cas_id = full.cas_id;
                        }
                        
                    } 
                    html += `<a href="{{ route('coordinador.caso.ficha') }}/${full.run}/${cas_id}" class="btn btn-primary w-100" style="margin-bottom: 5px;">Ficha NNA</a>`;

                    return html;

                }, "className": "text-center"
            },
            {
            "data": 			"nna_run",
            "className": 		"text-center",
            "visible": 		false,
            "orderable": 		false,
            "searchable": 		true
            },
        ],
        "drawCallback": function (settings){
            desbloquearPantalla();
            $("#totalNNA").text(settings._iRecordsTotal);
            $('[data-toggle="tooltip"]').tooltip();
        }
    });

}


@endif
</script>
@endsection
<!-- //CZ SPRINT 73 -->