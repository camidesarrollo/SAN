@extends('layouts.main')

@section('contenido')
{{ csrf_field() }}

<div class="container-fluid">
    <div class="row">
        <div class="col">
            <h5><i class="fa fa-file-text"></i><b>  Documentación</b></h5>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="card p-4 shadow-sm">
        <div class="row">
            <div class="card colapsable shadow-sm w-100" id="contenedor_prot_ref_cont">
                <a class="btn text-left p-0 collapsed" id="desplegar_prot_ref_cont" data-toggle="collapse" data-target="#prot_ref_cont" aria-expanded="false" aria-controls="prot_ref_cont" >
                    <div class="card-header p-3">
                        <h5 class="mb-0">
                            <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
                            &nbsp;&nbsp; Protocolos de Referencia y Contrarreferencia elaborados con la Red Comunal de Niñez
                        </h5>
                    </div>
                </a>				
                <div class="collapse" id="prot_ref_cont">
                    <div class="card-body">
                        <br>
                        @if(session()->all()['perfil'] != config("constantes.perfil_administrador_central") && session()->all()['perfil'] != config("constantes.perfil_coordinador_regional") && session()->all()['perfil'] != config("constantes.perfil_coordinador_regional"))
                        <div class="input-group mb-3">
                            <form enctype="multipart/form-data" id="adj_coor_doc_1" method="post" onsubmit="cargarDocumentosCoordinador(1);">
                                <div class="custom-file" style="z-index:0;">
                                        <input type="file" class="custom-file-input " name="doc_prot" id="doc_prot" onchange="$('#adj_coor_doc_1').submit();">
                                        <label class="custom-file-label" for="doc_prot" aria-describedby="inputGroupFileAddon02">Cargar archivo</label>
                                </div>
                            </form>
                        </div>
                        <div style="margin-top: -15px; margin-left: 2px;"><small>Sólo subir archivos con las siguientes extensiones: ".pdf", ".docx" y ".doc".</small></div>
                        <br>
                        @endif
                        <div class="card colapsable shadow-sm w-100" id="contenedor_hist_prot">
                            <a class="btn text-left p-0 collapsed" id="desplegar_hist_prot" data-toggle="collapse" data-target="#hist_prot" aria-expanded="false" aria-controls="doc_2_!" onclick="if($(this).attr('aria-expanded') == 'false') listarDocumentoProtocolos();">
                                <div class="card-header p-3">
                                    <h5 class="mb-0">
                                        <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
                                        &nbsp;&nbsp; Historial Protocolos de Referencia y Contrarreferencia
                                    </h5>
                                </div>
                            </a>				
                            <div class="collapse" id="hist_prot">
                                <div class="card-body">
                                    <br>
                                    @if(session()->all()['perfil'] == config("constantes.perfil_administrador_central") && session()->all()['perfil'] != config("constantes.perfil_coordinador_regional"))
                                        <div class="form-group row">
                                            <div class="col-sm-6"  >
                                                <label for="inputPassword" class="col-form-label">
                                                    <b>Elije la(s) comuna(s)</b>
                                                </label>
                                                <select id="chkcomuna1" name="chkcomuna1" multiple="multiple" class="form-control chkveg" style="color: #858796;">																		
                                                 <!-- CZ SPRINT 76  -->																	
                                                @php $getComunas = Helper::getComunas(); @endphp
                                                    @foreach($getComunas AS $c1 => $v1)
                                                     <!-- CZ SPRINT 76  -->
                                                        <option value="{{$v1->com_id}}"
                                                            @if(Session::get('com_id')==$v1->com_id)
                                                                {{ "selected" }}
                                                            @endif
                                                            >{{$v1->com_nom}}</option>
                                                    @endforeach
                                                </select>
                                                <button type="button" class="btn btn-primary" onclick="listarDocumentoProtocolos();">Filtrar</button>
                                            </div>  								
                                        </div>
                                    @endif
                                    <div class="card-body">
                                        <table class="table table-striped table-hover w-100" cellspacing="0" id="tabla_prot_ref_cont">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Nombre</th>
                                                    <th class="text-center">Fecha</th>
                                                    <th class="text-center">Usuario</th>
                                                    <th class="text-center">Comuna</th>
                                                    <th class="text-center">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="card colapsable shadow-sm w-100" id="contenedor_hist_act_lis">
                <a class="btn text-left p-0 collapsed" id="desplegar_hist_act_lis" data-toggle="collapse" data-target="#hist_act_lis" aria-expanded="false" aria-controls="doc_2" >
                    <div class="card-header p-3">
                        <h5 class="mb-0">
                            <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
                            &nbsp;&nbsp; Actas y listas de asistencia
                        </h5>
                    </div>
                </a>				
                <div class="collapse" id="hist_act_lis">
                    <div class="card-body">
                        <br>
                        @if(session()->all()['perfil'] != config("constantes.perfil_administrador_central") && session()->all()['perfil'] != config("constantes.perfil_coordinador_regional"))
                        <label class="col-form-label p-1" style="color:#858796;"><b>Tipo de Actas:</b></label>
                        <div class="form-group row">
                            <div class="form-group p-1">
                                <select class="form-control" id="tip_act" name="tip_act" onchange="habilitardocumento();" >
                                <option value="" >Seleccione una Opción</option>
                                @foreach($tipo_doc as $tipo)
                                    <option value="{{$tipo->doc_tip_id}}" >{{$tipo->doc_tip_nom}}</option>
                                @endforeach
                                </select>
                                <p id="val_tip_act" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Seleccionar la opción.</p>
                            </div>    
                            <div class="form-group p-1">
                                <form enctype="multipart/form-data" id="adj_coor_doc_2" method="post" onsubmit="cargarDocumentosCoordinador(2);">
                                    <div class="custom-file" style="z-index:0;">
                                            <input type="file" class="custom-file-input " name="doc_act_lis" id="doc_act_lis" disabled onchange="$('#adj_coor_doc_2').submit();">
                                            <label class="custom-file-label" for="doc_act_lis" aria-describedby="inputGroupFileAddon02">Cargar archivo</label>
                                    </div>
                                </form>
                                <div style="margin-left: 2px;"><small>Sólo subir archivos con las siguientes extensiones: ".pdf", ".docx" y ".doc".</small></div>
                            </div>
                        </div>
                        <br>
                        @endif
                        <div class="card colapsable shadow-sm w-100" id="contenedor_hist_act">
                            <a class="btn text-left p-0 collapsed" id="desplegar_hist_act" data-toggle="collapse" data-target="#hist_act" aria-expanded="false" aria-controls="hist_act" onclick="if($(this).attr('aria-expanded') == 'false') listarDocumentoActas();">
                                <div class="card-header p-3">
                                    <h5 class="mb-0">
                                        <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
                                        &nbsp;&nbsp; Historial Actas y listas de asistencia
                                    </h5>
                                </div>
                            </a>				
                            <div class="collapse" id="hist_act">
                                <div class="card-body">
                                    <br>
                                    @if(session()->all()['perfil'] == config("constantes.perfil_administrador_central") && session()->all()['perfil'] != config("constantes.perfil_coordinador_regional"))
                                        <div class="form-group row">
                                            <div class="col-sm-6"  >
                                                <label for="inputPassword" class="col-form-label">
                                                    <b>Elije la(s) comuna(s)</b>
                                                </label>
                                                <select id="chkcomuna2" name="chkcomuna2" multiple="multiple" class="form-control chkveg" style="color: #858796;">																		
                                                <!-- CZ SPRINT 76  --> 
                                                @php $getComunas = Helper::getComunas(); @endphp
                                                    @foreach($getComunas AS $c1 => $v1)
                                                     <!-- CZ SPRINT 76  -->
                                                        <option value="{{$v1->com_id}}"
                                                            @if(Session::get('com_id')==$v1->com_id)
                                                                {{ "selected" }}
                                                            @endif
                                                            >{{$v1->com_nom}}</option>
                                                    @endforeach
                                                </select>
                                                <button type="button" class="btn btn-primary" onclick="listarDocumentoActas();">Filtrar</button>
                                            </div>								
                                        </div>
                                    @endif
                                    <div class="card-body">
                                        <table class="table table-striped table-hover w-100" cellspacing="0" id="tabla_act_lis_asis">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Nombre</th>
                                                    <th class="text-center">Fecha</th>
                                                    <th class="text-center">Usuario</th>
                                                    <th class="text-center">Comuna</th>
                                                    <th class="text-center">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
            <br>
            <div class="card colapsable shadow-sm w-100" id="contenedor_mat_doc">
                <a class="btn text-left p-0 collapsed" id="desplegar_mat_doc" data-toggle="collapse" data-target="#mat_doc" aria-expanded="false" aria-controls="doc_3" >
                    <div class="card-header p-3">
                        <h5 class="mb-0">
                            <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
                            &nbsp;&nbsp; Materiales y documentos de elaboración propia para apoyar el trabajo de las líneas de acción de la OLN
                        </h5>
                    </div>
                </a>				
                <div class="collapse" id="mat_doc">
                    <div class="card-body">
                        <br>
                        @if(session()->all()['perfil'] != config("constantes.perfil_administrador_central") && session()->all()['perfil'] != config("constantes.perfil_coordinador_regional"))
                        <div class="input-group mb-3">
                            <form enctype="multipart/form-data" id="adj_coor_doc_6" method="post" onsubmit="cargarDocumentosCoordinador(6);">
                                <div class="custom-file" style="z-index:0;">
                                        <input type="file" class="custom-file-input " name="doc_mat_doc" id="doc_mat_doc" onchange="$('#adj_coor_doc_6').submit();">
                                        <label class="custom-file-label" for="doc_mat_doc" aria-describedby="inputGroupFileAddon02">Cargar archivo</label>
                                </div>
                            </form>
                        </div>
                        <div style="margin-top: -15px; margin-left: 2px;"><small>Sólo subir archivos con las siguientes extensiones: ".pdf", ".docx" y ".doc".</small></div>
                        <br>
                        @endif
                        <div class="card colapsable shadow-sm w-100" id="contenedor_hist_mat_doc">
                            <a class="btn text-left p-0 collapsed" id="desplegar_hist_mat_doc" data-toggle="collapse" data-target="#hist_mat_doc" aria-expanded="false" aria-controls="hist_mat_doc" onclick="if($(this).attr('aria-expanded') == 'false') listarDocumentoMateriales();">
                                <div class="card-header p-3">
                                    <h5 class="mb-0">
                                        <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
                                        &nbsp;&nbsp; Historial Materiales y documentos de elaboración
                                    </h5>
                                </div>
                            </a>				
                            <div class="collapse" id="hist_mat_doc">
                                <div class="card-body">
                                    <br>
                                    @if(session()->all()['perfil'] == config("constantes.perfil_administrador_central") && session()->all()['perfil'] != config("constantes.perfil_coordinador_regional"))
                                        <div class="form-group row">
                                            <div class="col-sm-6"  >
                                                <label for="inputPassword" class="col-form-label">
                                                    <b>Elije la(s) comuna(s)</b>
                                                </label>
                                                <select id="chkcomuna3" name="chkcomuna3" multiple="multiple" class="form-control chkveg" style="color: #858796;">																		
                                                 <!-- CZ SPRINT 76  -->
                                                @php $getComunas = Helper::getComunas(); @endphp
                                                    @foreach($getComunas AS $c1 => $v1)
                                                     <!-- CZ SPRINT 76  -->
                                                        <option value="{{$v1->com_id}}"
                                                            @if(Session::get('com_id')==$v1->com_id)
                                                                {{ "selected" }}
                                                            @endif
                                                            >{{$v1->com_nom}}</option>
                                                    @endforeach
                                                </select>
                                                <button type="button" class="btn btn-primary" onclick="listarDocumentoMateriales();">Filtrar</button>
                                            </div>								
                                        </div>
                                    @endif
                                    <div class="card-body">
                                        <table class="table table-striped table-hover w-100" cellspacing="0" id="tabla_mat_doc_ela">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Nombre</th>
                                                    <th class="text-center">Fecha</th>
                                                    <th class="text-center">Usuario</th>
                                                    <th class="text-center">Comuna</th>
                                                    <th class="text-center">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- INICIO DC -->
            <br>
            <div class="card colapsable shadow-sm w-100" id="contenedor_prot_sos_vul">
                <a class="btn text-left p-0 collapsed" id="desplegar_prot_sos_vul" data-toggle="collapse" data-target="#prot_sos_vul" aria-expanded="false" aria-controls="prot_sos_vul" >
                    <div class="card-header p-3">
                        <h5 class="mb-0">
                            <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
                            &nbsp;&nbsp; Protocolos de sospecha de vulneración de derechos
                        </h5>
                    </div>
                </a>				
                <div class="collapse" id="prot_sos_vul">
                    <div class="card-body">                   
                    	<div style="margin-left: 2px;font-size: 15px">Descargue el documento formato "Protocolos de sospecha de vulneración de derechos", <a href="javascript:descargarDoc()" style="color: #0404B4">aquí.</a></div>                     
                        <br>
                        @if(session()->all()['perfil'] != config("constantes.perfil_administrador_central") && session()->all()['perfil'] != config("constantes.perfil_coordinador_regional"))
                        <div class="input-group mb-3">
                            <form enctype="multipart/form-data" id="adj_coor_doc_7" method="post" onsubmit="cargarDocumentosCoordinador(7);">
                                <div class="custom-file" style="z-index:0;">
                                        <input type="file" class="custom-file-input " name="doc_prot_sos" id="doc_prot_sos" onchange="$('#adj_coor_doc_7').submit();">
                                        <label class="custom-file-label" for="doc_prot_sos" aria-describedby="inputGroupFileAddon02">Cargar archivo</label>
                                </div>
                            </form>
                        </div>
                        <div style="margin-top: -15px; margin-left: 2px;"><small>Sólo subir archivos con las siguientes extensiones: ".pdf", ".docx" y ".doc".</small></div>
                        <br>
                        @endif
                        <div class="card colapsable shadow-sm w-100" id="contenedor_hist_prot">
                            <a class="btn text-left p-0 collapsed" id="desplegar_hist_prot" data-toggle="collapse" data-target="#hist_prot_sos" aria-expanded="false" aria-controls="doc_2_!" onclick="if($(this).attr('aria-expanded') == 'false') listarDocumentoProtocolosVul();">
                                <div class="card-header p-3">
                                    <h5 class="mb-0">
                                        <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
                                        &nbsp;&nbsp; Historial Protocolos de sospecha de vulneración de derechos
                                    </h5>
                                </div>
                            </a>				
                            <div class="collapse" id="hist_prot_sos">
                                <div class="card-body">
                                    <br>
                                    
                                    <div class="card-body">
                                        <table class="table table-striped table-hover w-100" cellspacing="0" id="tabla_prot_vul_der">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Nombre</th>
                                                    <th class="text-center">Fecha</th>
                                                    <th class="text-center">Usuario</th>
                                                    <th class="text-center">Comuna</th>
                                                    <th class="text-center">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- FIN DC -->
        </div>
    </div>
</div>
<style type="text/css">	
    .multiselect-container>li {
    
        width:200px;
        padding:0px;
        margin:0px;
    
    }
</style>
@section('script')
<script type="text/javascript">    
    
    $(document).ready(function(){

		$("#adj_coor_doc_1").submit(function(e){      
            e.preventDefault();
        });

        $("#adj_coor_doc_2").submit(function(e){
            e.preventDefault();
        });

        $("#adj_coor_doc_6").submit(function(e){  
            e.preventDefault();
        });

        $("#adj_coor_doc_7").submit(function(e){  
            e.preventDefault();
        });

        $('.chkveg').multiselect({
		    includeSelectAllOption: false     
		});
        
	});

    function habilitardocumento(){
        let tipo = $("#tip_act").val();
        console.log(tipo);
        if(tipo != ""){
            $("#doc_act_lis").prop("disabled",false);
        }else{
            $("#doc_act_lis").prop("disabled",true);
        }
    }

    function cargarDocumentosCoordinador(tipo = null){      
        bloquearPantalla();  
        // agrego la data del form a formData
        
        var form = document.getElementById('adj_coor_doc_'+tipo);
        //inicio ch
        let formData = new FormData(form);
        //INICIO CZ
        if(tipo == 1 || tipo == 6 || tipo == 7){
        //FIN CZ 
            formData.append('tipo', tipo);
        }else{
            
            formData.append('tipo', $("#tip_act").val());
        }
        //fin ch
        
        formData.append('_token', $('input[name=_token]').val());

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ route('coordinador.cargar.documento') }}",
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        }).done(function(resp){//inicio ch
                desbloquearPantalla();
                console.log(resp);
                
                if (resp.estado == 1){  
                    mensajeTemporalRespuestas(1, resp.mensaje);              
                    setTimeout(function(){ 
                        location.reload();
                    }, 3000);                    
                }else{
                    mensajeTemporalRespuestas(0, resp.mensaje);
                }//fin ch
        }).fail(function(objeto, tipoError, errorHttp){
            desbloquearPantalla();

            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

            return false;
        });


    }

    //INICIO DC
    function listarDocumentoProtocolosVul(){
    	let tabla_prot_ref_cont = $('#tabla_prot_vul_der').DataTable();
        tabla_prot_ref_cont.clear().destroy();
        let data = new Object();
        data.comunas 	= {{Session::get('com_id')}};
        tabla_prot_ref_cont = $('#tabla_prot_vul_der').DataTable({
            "language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
            "lengthChange": false,
            "info": 		false,
            "ajax": {
                "url": "{{ route('listar.coordinador.protocolo2') }}",//ch
                "type": "GET",
                "data": data
            },
            "columnDefs": [
                { //NOMBRE DEL DOCUMENTO
                    "targets": 0,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //FECHA DE CREACION
                    "targets": 1,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //USUARIO
                    "targets": 2,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //COMUNA
                    "targets": 3,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //ACCIONES
                    "targets": 4,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                }
            ],				
            "columns": [
                        { //NOMBRE DEL DOCUMENTO
                            "data": "doc_act_nom",
                            "className": "text-center"
                        },
                        { //FECHA DE CREACION
                            "data": "created_at",
                            "className": "text-center",
                            "render": function(data, type, row){
                                        let fec = new Date(data);
                                        fec = fec.getDate()+"-"+(fec.getMonth() + 1 )+"-"+fec.getFullYear();
                                        
                                        return fec;
                                    }
                        },
                        { //USUARIO
                            "data": "usuario",
                            "className": "text-center"
                            @if(session()->all()['perfil'] == config("constantes.perfil_coordinador"))
                            ,
                            "visible": 	false
                            @endif
                        },
                        { //COMUNA
                            "data": "com_nom",
                            "className": "text-center"
                            @if(session()->all()['perfil'] == config("constantes.perfil_coordinador"))
                            ,
                            "visible": 	false
                            @endif
                        },
                        { //ACCIONES
                            "data": "doc_act_nom",
                            "className": "text-center",
                            "render": function(data, type, row){
                                        let html = '<a href="javascript:descProtVul(\''+data+'\')"><button type="button" class="btn btn-success"><i class="fas fa-download"></i> Descargar</button></a>';
                                        return html;
                                    }
                        }
                    ]
        });
    }
    
    function descargarDoc(){
    	window.open('{{str_replace("documentacion/main", "", url()->current()."documentos/Reporte_de_vulneracion_de_derechos_del_NNA.docx")}}', "_blank");
    }
    
    function descProtVul(archivo){
    	window.open('{{str_replace("documentacion/main", "", url()->current()."doc_coordinador/")}}'+archivo, "_blank");
    }
    //FIN DC

    function listarDocumentoProtocolos(){

        let tabla_prot_ref_cont = $('#tabla_prot_ref_cont').DataTable();
        tabla_prot_ref_cont.clear().destroy();
        
        let data = new Object();
        @if(session()->all()['perfil'] == config("constantes.perfil_administrador_central") && session()->all()['perfil'] != config("constantes.perfil_coordinador_regional"))
            let chkcomuna	= new Array();
            $.each($('#chkcomuna1 option:selected'), function(){ chkcomuna.push($(this).val()); });
            comunas			= chkcomuna.join(',');
            data.comunas 	= comunas;
        @else
            data.comunas 	= {{Session::get('com_id')}};
        @endif
            
        tabla_prot_ref_cont = $('#tabla_prot_ref_cont').DataTable({
            "language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
            "lengthChange": false,
            "info": 		false,
            "ajax": {
                "url": "{{ route('listar.coordinador.protocolo') }}",//ch
                "type": "GET",
                "data": data
            },
            "columnDefs": [
                { //NOMBRE DEL DOCUMENTO
                    "targets": 0,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //FECHA DE CREACION
                    "targets": 1,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //USUARIO
                    "targets": 2,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //COMUNA
                    "targets": 3,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //ACCIONES
                    "targets": 4,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                }
            ],				
            "columns": [
                        { //NOMBRE DEL DOCUMENTO
                            "data": "doc_act_nom",
                            "className": "text-center"
                        },
                        { //FECHA DE CREACION
                            "data": "created_at",
                            "className": "text-center",
                            "render": function(data, type, row){
                                        let fec = new Date(data);
                                        fec = fec.getDate()+"-"+(fec.getMonth() + 1 )+"-"+fec.getFullYear();
                                        
                                        return fec;
                                    }
                        },
                        { //USUARIO
                            "data": "usuario",
                            "className": "text-center"
                            @if(session()->all()['perfil'] == config("constantes.perfil_coordinador"))
                            ,
                            "visible": 	false
                            @endif
                        },
                        { //COMUNA
                            "data": "com_nom",
                            "className": "text-center"
                            @if(session()->all()['perfil'] == config("constantes.perfil_coordinador"))
                            ,
                            "visible": 	false
                            @endif
                        },
                        { //ACCIONES
                            "data": "doc_act_nom",
                            "className": "text-center",
                            "render": function(data, type, row){
                                        let html = '<a href="{{config("constantes.repositorio_coordinador")}}'+data+'"><button type="button" class="btn btn-success"><i class="fas fa-download"></i> Descargar</button></a>';
                                        return html;
                                    }
                        }
                    ]
        });
        
    }

    function listarDocumentoActas(){

        let tabla_act_lis_asis = $('#tabla_act_lis_asis').DataTable();
        tabla_act_lis_asis.clear().destroy();

        let data = new Object();
        @if(session()->all()['perfil'] == config("constantes.perfil_administrador_central") && session()->all()['perfil'] != config("constantes.perfil_coordinador_regional"))
            let chkcomuna	= new Array();
            $.each($('#chkcomuna2 option:selected'), function(){ chkcomuna.push($(this).val()); });
            comunas			= chkcomuna.join(',');
            data.comunas 	= comunas;
        @else
            data.comunas 	= {{Session::get('com_id')}};
        @endif

        tabla_act_lis_asis = $('#tabla_act_lis_asis').DataTable({
            "language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
            "lengthChange": false,
            "info": 		false,
            "ajax": {
                "url": "{{ route('listar.coordinador.actas') }}",//ch
                "type": "GET",
                "data": data
            },
            "columnDefs": [
                { //NOMBRE DEL DOCUMENTO
                    "targets": 0,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //FECHA DE CREACION
                    "targets": 1,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //USUARIO
                    "targets": 2,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //COMUNA
                    "targets": 3,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //ACCIONES
                    "targets": 4,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                }
            ],				
            "columns": [
                        { //NOMBRE DEL DOCUMENTO
                            "data": "doc_act_nom",
                            "className": "text-center"
                        },
                        { //FECHA DE CREACION
                            "data": "created_at",
                            "className": "text-center",
                            "render": function(data, type, row){
                                        let fec = new Date(data);
                                        fec = fec.getDate()+"-"+(fec.getMonth() + 1 )+"-"+fec.getFullYear();
                                        
                                        return fec;
                                    }
                        },
                        { //USUARIO
                            "data": "usuario",
                            "className": "text-center"
                            @if(session()->all()['perfil'] == config("constantes.perfil_coordinador"))
                            ,
                            "visible": 	false
                            @endif
                        },
                        { //COMUNA
                            "data": "com_nom",
                            "className": "text-center"
                            @if(session()->all()['perfil'] == config("constantes.perfil_coordinador"))
                            ,
                            "visible": 	false
                            @endif
                        },
                        { //ACCIONES
                            "data": "doc_act_nom",
                            "className": "text-center",
                            "render": function(data, type, row){
                                        let html = '<a href="{{config("constantes.repositorio_coordinador")}}'+data+'"><button type="button" class="btn btn-success"><i class="fas fa-download"></i> Descargar</button></a>';
                                        return html;
                                    }
                        }
                    ]
        });
        
    }

    function listarDocumentoMateriales(){

        let tabla_mat_doc_ela = $('#tabla_mat_doc_ela').DataTable();
        tabla_mat_doc_ela.clear().destroy();

        let data = new Object();
        @if(session()->all()['perfil'] == config("constantes.perfil_administrador_central") && session()->all()['perfil'] != config("constantes.perfil_coordinador_regional"))
            let chkcomuna	= new Array();
            $.each($('#chkcomuna3 option:selected'), function(){ chkcomuna.push($(this).val()); });
            comunas			= chkcomuna.join(',');
            data.comunas 	= comunas;
        @else
            data.comunas 	= {{Session::get('com_id')}};
        @endif

        tabla_mat_doc_ela = $('#tabla_mat_doc_ela').DataTable({
            "language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
            "lengthChange": false,
            "info": 		false,
            "ajax": {
                "url": "{{ route('listar.coordinador.materiales') }}",//ch
                "type": "GET",
                "data": data
            },
            "columnDefs": [
                { //NOMBRE DEL DOCUMENTO
                    "targets": 0,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //FECHA DE CREACION
                    "targets": 1,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //USUARIO
                    "targets": 2,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //COMUNA
                    "targets": 3,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //ACCIONES
                    "targets": 4,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                }
            ],				
            "columns": [
                        { //NOMBRE DEL DOCUMENTO
                            "data": "doc_act_nom",
                            "className": "text-center"
                        },
                        { //FECHA DE CREACION
                            "data": "created_at",
                            "className": "text-center",
                            "render": function(data, type, row){
                                        let fec = new Date(data);
                                        fec = fec.getDate()+"-"+(fec.getMonth() + 1 )+"-"+fec.getFullYear();
                                        
                                        return fec;
                                    }
                        },
                        { //USUARIO
                            "data": "usuario",
                            "className": "text-center"
                            @if(session()->all()['perfil'] == config("constantes.perfil_coordinador"))
                            ,
                            "visible": 	false
                            @endif
                        },
                        { //COMUNA
                            "data": "com_nom",
                            "className": "text-center"
                            @if(session()->all()['perfil'] == config("constantes.perfil_coordinador"))
                            ,
                            "visible": 	false
                            @endif
                        },
                        { //ACCIONES
                            "data": "doc_act_nom",
                            "className": "text-center",
                            "render": function(data, type, row){
                                        let html = '<a href="{{config("constantes.repositorio_coordinador")}}'+data+'"><button type="button" class="btn btn-success"><i class="fas fa-download"></i> Descargar</button></a>';
                                        return html;
                                    }
                        }
                    ]
        });
    }
</script>
@endsection
@stop