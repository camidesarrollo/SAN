<!--<div class="container-fluid collapse" id="listar_diagnostico_integral">-->
    
    <table class="table table-sm" id="tabla_diagnostico_integral_eva">
        <thead>
            <tr>
                <th>Dimensión</th>
                <th style="text-align: center">Sub Escala con Deficiencia</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
<br>
<div id="frmDiagnosticoAlertaTerritorial" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="formComponentesLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content p-4">
            <div class="card p-4 m-0 shadow-sm">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="position: absolute; right: 5px; top: 5px; width: 23px; height: 23px; padding: 0; margin: 0;">&times;</span>
                </button>
                <div class="row">
					<div class="col text-center">
						<h4 class="modal-title"><b>Crear Alertas Territoriales</b></h4>
						<br>
					</div>
				</div>

				<div class="row">
					<div class="col-12">
						<h6><b>Nombre: </b><label>{{$data->nombre}}</label></h6>
                    </div>
                    
                    <div class="col-12">
						<h6><b>Rut: </b><label>{{$data->rut}}</label></h6>
					</div>
                    
                    <div class="col-12">
						<h6><b>Dimensión: </b><label id ="eva_dia_dim"></label></h6>
					</div>
				</div>
                <br>
                <div class="form-group">
                    <table class="table table-striped table-hover w-100" cellspacing="0" id="tabla_nueva_alerta">
                        <thead>
                            <tr>
                                <th>Alerta Territorial</th>
                                <th>Información Relevante Detectada</th>
                                <th>Acciones</th>
                                
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>   
                <div class="text-right">                    
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>					
            </div>                
        </div>
    </div>
</div>

<div id="frmVincularAlertaTerritorial" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="formComponentesLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content p-4">
            <div class="card p-4 m-0 shadow-sm">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="position: absolute; right: 5px; top: 5px; width: 23px; height: 23px; padding: 0; margin: 0;">&times;</span>
                </button>
                <div class="row">
					<div class="col text-center">
						<h4 class="modal-title"><b>Vincular Alertas Territoriales: <label id="dim_nombre"></label></b></h4>
						<br>
					</div>
				</div>
                
				<div class="row">
					<div class="col-12 text-center">
						<h6><b>Alertas Territoriales a Vincular</b></h6>
                    </div>  
				</div>                
                <div class="form-group">
                    <table class="table table-striped table-hover w-100" cellspacing="0" id="tabla_alertas_detectadas">
                        <thead>
                            <tr>
                                <th style="width:15%">Nombre NNA</th>
                                <th style="width:45%">Alerta Territorial</th>
                                <th style="width:25%">Usuario de Creación</th>
                                <th style="width:15%">Acciones</th>                                
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <br><br>   
                <div class="row">
					<div class="col-12 text-center">
						<h6><b>Alertas Territoriales Vinculadas</b></h6>
                    </div>  
				</div>
                <div class="form-group">
                    <table class="table table-striped table-hover w-100" cellspacing="0" id="tabla_alertas_vinculadas">
                        <thead>
                            <tr>
                                <th style="width:15%">Nombre NNA</th>
                                <th style="width:45%">Alerta Territorial</th>
                                <th style="width:25%">Usuario de Creación</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="text-right">                    
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>					
            </div>                
        </div>
    </div>
</div>
<!-- HIDDEN -->
<input type="hidden" name="dir_usu_nna" id="dir_usu_nna" value="">
<input type="hidden" name="car_usu" id="car_usu" value="{{Session::get('nombre_perfil')}}">
<input type="hidden" name="nna_run" id="nna_run" value="{{$data->run}}">
<input type="hidden" name="nna_srun" id="nna_srun" value="{{$data->run}}">
<input type="hidden" name="nna_nombre" id="nna_nombre" value="{{$data->nombre}}">
<input type="hidden" name="nna_fecha_nac" id="nna_fecha_nac" value="">
<input type="hidden" name="nna_sexo" id="nna_sexo" value="">
<input type="hidden" name="id_dir" id="id_dir" value="">
<!-- INICIO CZ SPRINT 71 MANTIS  9827--> 
<input type="hidden" name="reg_id" id="reg_id" value="{{Session::get('region')}}">
<!-- INICIO CZ SPRINT 71 MANTIS  9827--> 
@if(config('constantes.activar_maestro_direcciones'))
    <input type="hidden" name="com_id_nna" id="com_id_nna" value="{{Session::get('com_id')}}">
@else
    <input type="hidden" name="com_id_nna" id="com_id_nna" value="{{Session::get('com_id')}}">
@endif
<input type="hidden" name="nna_calle" id="nna_calle" value="{{$data->dir_call}}">
<input type="hidden" name="nna_dir" id="nna_dir" value="{{$data->dir_num}}">
<input type="hidden" name="nna_depto" id="nna_depto" value="{{$data->dir_dep}}">
<input type="hidden" name="nna_block" id="nna_block" value="">
<input type="hidden" name="nna_casa" id="nna_casa" value="">
<input type="hidden" name="nna_km_sitio" id="nna_km_sitio" value="">
<input type="hidden" name="nna_ref" id="nna_ref" value="">
<input type="hidden" name="per_id" id="per_id" value="{{$data->per_id}}">
<input type="hidden" name="dim_id" id="dim_id" value="">

<!-- HIDDEN -->

<script type="text/javascript">
    function listarDiagnosticoIntegral(caso_id){
        let data_diagnosticoIntegral = $('#tabla_diagnostico_integral_eva').DataTable();
        data_diagnosticoIntegral.destroy();

        let data = new Object();
        data.caso_id = caso_id;
        data.estado = {{config('constantes.en_diagnostico')}};

        data_diagnosticoIntegral =	$('#tabla_diagnostico_integral_eva').DataTable({
            //"fixedHeader": { header:true },
            //"dom": '<lf<t>ip>',
            //"language"	: { "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json" },
            "language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
            "processing": true,
            "serverSide": false,
            "paging"    : false,
            "ordering"  : false,
            "searching" : false,
            "info"		: false,
            "ajax"		: { "url" :	"{{ route('dimension.listar.resultado') }}", "type": "GET",  "data": data },
            "createdRow": function( row, data, dataIndex ){
                //console.log("que sucede?", row, data, dataIndex);
            },
            "columns"	: [
                {
                    "data": 		"dim_enc_nom", //Dimensión
                    "className": 	"text-center font-weight-bold border",
                    "width": 		"10%"
                },
                {
                    "data": 		"nom_var", //Pregunta
                    "className": 	"border",
                    "width": 		"80%",
                    "render": function(data, type, row){
                        let html = 	'<table class="table table-sm m-0" width="100%">';
                            html += '<tr>';															
                            html +=	'<td width="30%">'+data+'</td>';
                            html +=	'<td>';								
                            html +=	'<div class="progress">';
                            html += '<div class="progress-bar progress-bar-striped '; 
                            html +=	'progress-bar-animated text-left pl-1 ';

                            if (row.alt_val == "-1"){
                                html += 'bg-warning"';
                                html +=	'style="width: 25%;" aria-valuenow="25" '; 

                            }else if (row.alt_val == "-2"){
                                html += 'bg-orange-pro"';
                                html +=	'style="width: 50%;" aria-valuenow="50" '; 

                            }else if (row.alt_val == "-3"){
                                html += 'bg-danger"';
                                html +=	'style="width: 100%;" aria-valuenow="100" '; 

                            }

                            html += 'role="progressbar" aria-valuemin="0" aria-valuemax="100">';
                            html += '<small>'+row.alt_nom+' ('+row.alt_val+')</small>';
                            html += '</div></div></td>';								
                            html += '</tr></table>';

                        return html;
                    }
                },
                {// Acciones
                    "data": 		"", 
                    "className": 	"text-center font-weight-bold border",
                    "width": 		"10%",
                    "render": function(data, type, row){
                        // INICIO CZ SPRINT 77
                        @if(Session::get('perfil') == config('constantes.perfil_gestor'))
                        let html = '<button type="button" class="btn btn-warning" onclick="vincularAlertas('+row.dim_enc_id+',\''+row.dim_enc_nom+'\');">Vincular Alertas</button><br><br>';
                        html += '<button type="button" class="btn btn-outline-success" onclick="datamodal('+row.dim_enc_id+',\''+row.dim_enc_nom+'\');"><i class="fa fa-plus-circle"></i>  Crear alerta</button>';
                        @else
                        let html = '<button type="button" class="btn btn-warning" onclick="vincularAlertas('+row.dim_enc_id+',\''+row.dim_enc_nom+'\');" disabled>Vincular Alertas</button><br><br>';
                        html += '<button type="button" class="btn btn-outline-success" onclick="datamodal('+row.dim_enc_id+',\''+row.dim_enc_nom+'\');" disabled><i class="fa fa-plus-circle"></i>  Crear alerta</button>';
                        @endif
                        return html;
                    }
                }
            ],
            "rowsGroup" : [0,2],
            "columnDefs": [{"className": "dt-center", "targets": [0]},
                        {"className": "dt-center", "targets": [1]}],
        });

        //$('#tabla_diagnostico_integral_eva').addClass("headerTablas");

        $('#tabla_diagnostico_integral_eva').find("thead th").removeClass("sorting_asc");
    }

    function listarEvaDiagAlertasTerritoriales(){
        let tabla_nueva_alerta = $('#tabla_nueva_alerta').DataTable();
        tabla_nueva_alerta.clear().destroy();

        tabla_nueva_alerta = $('#tabla_nueva_alerta').DataTable({
            "language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
            "lengthChange": false,
            "info": 		false,
            "ajax": {
                "url": "{{ route('listar.diagnostico.alertas') }}",
                "type": "GET"
            },
            "columnDefs": [
                { //TIPO DE ALERTA
                    "targets": 0,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //JUSTIFICACION
                    "targets": 1,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //ACCIONES
                    "targets": 2,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                }
            ],				
            "columns": [
                        { //TIPO DE ALERTA
                            "data": "ale_tip_nom",
                            "className": "text-center"
                        },
                        { //JUSTIFICACION
                            "data": "ale_tip_id",
                            "className": "text-center",
                            "render": function(data, type, row){
                                // CZ SPRINT 76
                                let html = "<textarea maxlength=1000 onkeypress='return caracteres_especiales(event)'  onKeyUp='contCaracteres(this)' onKeyDown='contCaracteres(this)' onBlur='' class='form-control just_alert' rows='3' id='justificacion_alerta_"+data+"' name='justificacion_alerta_"+data+"'></textarea>";
                                html +=`<div class="row">`;
                                html +=`<div class="col">`;
                                html +=`<h6><small class="form-text text-muted">Mínimo 3 y máximo 1000 caracteres.</small></h6>`;
                                html +=`</div>`;
                                html +=`<div class="col text-left">`;
                                html +=`<h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_justificacion_alerta_${data}" style="color: #000000;">0</strong></small></h6>`;
                                html +=`</div>`;  
                                html +=`</div>`;
                                // CZ SPRINT 76
                                return html;
                            }
                        },
                        { //ACCIONES
                            "data": "ale_tip_id",
                            "className": "text-center",
                            "render": function(data, type, row){
                                        let html = '<button id="btn_alerta_'+data+'" type="button" class="btn btn-success" onclick="registrarEvaDiagAlerta('+data+');" >Guardar</button>';                                        
                                        return html;
                                    }
                        }
                    ]
        });
    }
    // CZ SPRINT 76
    let num_caracteres;
    let cont_frm_cau = "";
    let num_caracteres_permitidos   = 1000;
    function contCaracteres(input){
        var input = $(input);
        var id = input[0].id;
        num_caracteres = $("#"+id).val().length;
        if (num_caracteres > num_caracteres_permitidos){ 
            $("#"+id).val(cont_frm_cau);
       }else{ 
          cont_frm_cau = $("#"+id).val(); 
       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_"+id).css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_"+id).css("color", "#000000");

       }

       $("#cant_carac_"+id).text($("#"+id).val().length);
    }

    // CZ SPRINT 76

    function getDataAlertaTerritorial(){
        let data = new Object();
        data.per_id = $("#per_id").val();
        data.run = $("#nna_srun").val();
        data.reg = $("#reg_id").val();
        $.ajax({
            type: "GET",
            url: "{{route('get.data.nna.alerta')}}",
            data: data
        }).done(function(resp){
            let usuario = resp.usuario;
            let nna_data = resp.nna_data;
            let direccion = resp.direccion;
            let region = resp.region;
            if(resp.estado == 1){
                $("#dir_usu_nna").val(usuario.reg_nom);
                let fec = new Date(nna_data.fec_na);
                fec = fec.getDate()+"/"+(fec.getMonth() + 1 )+"/"+fec.getFullYear();
                $("#nna_fecha_nac").val(fec);
                $("#nna_sexo").val(nna_data.sexo);     
                $("#nna_block").val(direccion.dir_block);
                $("#nna_casa").val(direccion.dir_casa);
                $("#nna_km_sitio").val(direccion.dir_sit);
                $("#nna_ref").val(direccion.dir_des);
                if(region != null){
                $("#reg_id").val(region.reg_id);
                }
            }else if (resp.estado == 0){
                mensajeTemporalRespuestas(0, resp.mensaje);

            }
            
        }).fail(function(objeto, tipoError, errorHttp){            
            desbloquearPantalla();

            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

            return false;
        });
    }
    
	function datamodal(dim_id,dim_nom){		
		$("#eva_dia_dim").text(dim_nom);
        $("#dim_id").val(dim_id);
        listarEvaDiagAlertasTerritoriales();
        getDataAlertaTerritorial();
        $("#frmDiagnosticoAlertaTerritorial").modal('show');
	}

    function registrarEvaDiagAlerta(ale_tip_id,dim_id){
        let justificacion = $("#justificacion_alerta_"+ale_tip_id).val();

        if (justificacion == "" || typeof justificacion === "undefined"){
            $("#justificacion_alerta_"+ale_tip_id).addClass("is-invalid");
            mensajeTemporalRespuestas(0, 'Debe ingresar Información Relevante');
            return false;
        }else{
            $("#justificacion_alerta_"+ale_tip_id).removeClass("is-invalid");            
        }

        let confirmacion = confirm("¿Desea registra la Alerta?");		
        if (confirmacion == false) return false;

        let data = new Object();

        bloquearPantalla(); 

        // I. IDENTIFICACIÓN USUARIO
        data.dim_id = 10;
        data.dir_usu_nna = $("#dir_usu_nna").val();
        data.car_usu = $("#car_usu").val();
        data.dim_enc_id = $("#dim_id").val();

        // II. IDENTIFICACIÓN DEL NNA o GESTANTE MENOR A 18 AÑOS 
        let estado = 0;
        let cant =  $("#nna_srun").val();
        if(cant.length > 10) estado = 2;       
        if(estado == 0){
            data.nna_run = $("#nna_run").val();
            data.estado = estado;
        }else{        
            data.nna_run = $("#nna_srun").val();
            data.estado = estado;
        }        
        
        let nna_nombre = $("#nna_nombre").val();
        data.nna_nombre = nna_nombre.toUpperCase();
        data.nna_fecha_nac = $("#nna_fecha_nac").val();
        data.nna_edad = calcularEdades($("#nna_fecha_nac").val());
        data.nna_sexo = $("#nna_sexo").val();     
        

        // DIRECCIÓN NNA
        data.id_dir = $("#id_dir").val();
        data.reg_id   = $("#reg_id").val();
        data.com_id_nna = $("#com_id_nna").val();
        data.nna_calle = $("#nna_calle").val();
        data.nna_dir = $("#nna_dir").val();
        data.nna_depto = $("#nna_depto").val();
        data.nna_block = $("#nna_block").val();
        data.nna_casa = $("#nna_casa").val();
        data.nna_km_sitio = $("#nna_km_sitio").val();
        data.nna_ref = $("#nna_ref").val();
        data.nna_nom_cui = 'Registro Automático Evaluación Diagnóstica';
        data.nna_num_cui = 'Registro Automático Evaluación Diagnóstica';

        // IV. ALERTAS DETECTADAS
        let str_com = new Array();
        str_com.push(ale_tip_id);
        data.ale_tip_id = str_com;

        let str_jus = new Array();
        str_jus.push($("#justificacion_alerta_"+ale_tip_id).val());
        data.ale_info_rel = str_jus;

        // V. ANTECEDENTES FAMILIARES
        data.ante_hist_fam = 'Registro Automático Evaluación Diagnóstica';
        data.ante_aspec_fam = 'Registro Automático Evaluación Diagnóstica';
        data.ante_interv_fam = 'Registro Automático Evaluación Diagnóstica';

        // VI. SALUD NNA
        data.ale_man_pre = 'Registro Automático Evaluación Diagnóstica';
        data.ale_man_cen_sal = 'Registro Automático Evaluación Diagnóstica';
        data.ale_man_ant_rel = 'Registro Automático Evaluación Diagnóstica';
        data.estadoIncor = 4;
        data.ale_man_tipo = 2;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "{{route('alertas.registrar')}}",
            type: "POST",
            data: data
        }).done(function(resp){
        	console.log(resp);
            desbloquearPantalla();

            if (resp.estado == 1){
                let mensaje = "Alerta(s) Territorial(es) registrada(s) exitosamente."
                $("#justificacion_alerta_"+ale_tip_id).prop("disabled",true);
                $("#btn_alerta_"+ale_tip_id).prop("disabled",true);
                if($("#desplegar_at_diagnostico_tipo").attr("aria-expanded")) listarATPriorizada();
                mensajeTemporalRespuestas(1, mensaje);
            }else if (resp.estado == 0){
            let mensaje = "Hubo un error al momento de crear la(s) Alerta(s) Territorial(es). Por favor intente nuevamente.";
            mensajeTemporalRespuestas(0, resp.mensaje);
            } 
        }).fail(function(objeto, tipoError, errorHttp){            
            desbloquearPantalla();

            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

            return false;
        });
    }
    function calcularEdades(fecha) {
    
        if (typeof fecha != "string" && fecha && esNumero(fecha.getTime())) {
            fecha = formatDate(fecha, "dd/MM/yyyy");
        }

        var values = fecha.split("/");
        var dia = values[0];
        var mes = values[1];
        var ano = values[2];
        
        // cogemos los valores actuales
        var fecha_hoy = new Date();
        var ahora_ano = fecha_hoy.getYear();
        var ahora_mes = fecha_hoy.getMonth() + 1;
        var ahora_dia = fecha_hoy.getDate();

        // realizamos el calculo
        var edad = (ahora_ano + 1900) - ano;
        if (ahora_mes < mes) {
            edad--;
        }
        if ((mes == ahora_mes) && (ahora_dia < dia)) {
            edad--;
        }
        if (edad > 1900) {
            edad -= 1900;
        }
        
        return edad;
    }

    function vincularAlertas(dim_id,dim_nom){
        bloquearPantalla()
        listarAlertasDetectadas(dim_id);
        listarAlertasVinculadas(dim_id);
        $("#dim_id").val(dim_id);
        $("#dim_nombre").text(dim_nom);
        desbloquearPantalla()
        $("#frmVincularAlertaTerritorial").modal('show');
    }

    function listarAlertasDetectadas(dim_id){

        let data = new Object();
        data.cas_id = $("#cas_id").val();
        data.dim_id = dim_id;

        let tabla_alertas_detectadas = $('#tabla_alertas_detectadas').DataTable();
        tabla_alertas_detectadas.clear().destroy();

        tabla_alertas_detectadas = $('#tabla_alertas_detectadas').DataTable({
            "language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
            "lengthChange": false,
            "info": 		false,
            "searching" : false,
            "ajax": {
                "url": "{{ route('diagnostico.listar.alertas.detectadas') }}",
                "type": "GET",
                "data": data,
                "async": false
            },
            "columnDefs": [
                { //NOMBRE NNA
                    "targets": 0,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //ALERTA TERRITORIAL
                    "targets": 1,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //USUARIO DE CREACIÓN
                    "targets": 2,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //ACCIONES
                    "targets": 3,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                }
            ],				
            "columns": [
                        { //NOMBRE NNA
                            "data": "ale_man_nna_nombre",
                            "width": "15%",
                            "className": "text-center"
                        },
                        { //ALERTA TERRITORIAL
                            "data": "ale_tip_nom",
                            "width": "40%",
                            "className": "text-center"
                        },
                        { //USUARIO DE CREACIÓN
                            "data": "usuario",
                            "width": "30%",
                            "className": "text-center"
                        },
                        { //ACCIONES
                            "data": "ale_man_id",
                            "width": "15%",
                            "className": "text-center",
                            "render": function(data, type, row){
                                        //let html = '<a href="{{ route('alerta.editar') }}/'+ data +'" class="btn btn-primary w-100" target="_blank">Ver</a>';
                                        //html += '<button type="button" class="btn btn-success w-100" onclick="vincularAlertaDiagnostico('+data+');" >Vincular</button>';
                                        let html = '<button type="button" class="btn btn-success w-100" onclick="vincularAlertaDiagnostico('+data+');" >Vincular</button>';
                                        return html;
                                    }
                        }
                    ]
        });
    }

    function listarAlertasVinculadas(dim_id){

        let data = new Object();
        data.cas_id = $("#cas_id").val();
        data.dim_id = dim_id;

        let tabla_alertas_vinculadas = $('#tabla_alertas_vinculadas').DataTable();
        tabla_alertas_vinculadas.clear().destroy();

        tabla_alertas_vinculadas = $('#tabla_alertas_vinculadas').DataTable({
            "language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
            "lengthChange": false,
            "info": 		false,
            "searching" : false,
            "ajax": {
                "url": "{{ route('diagnostico.listar.alertas.vinculadas') }}",
                "type": "GET",
                "data": data,
                "async": false
            },
            "columnDefs": [
                { //NOMBRE NNA
                    "targets": 0,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //ALERTA TERRITORIAL
                    "targets": 1,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //USUARIO DE CREACIÓN
                    "targets": 2,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                }
            ],				
            "columns": [
                        { //NOMBRE NNA
                            "data": "ale_man_nna_nombre",
                            "width": "15%",
                            "className": "text-center"
                        },
                        { //ALERTA TERRITORIAL
                            "data": "ale_tip_nom",
                            "width": "40%",
                            "className": "text-center"
                        },
                        { //USUARIO DE CREACIÓN
                            "data": "usuario",
                            "width": "30%",
                            "className": "text-center"
                        }

                    ]
        });
    }

    function vincularAlertaDiagnostico(ale_man_id){

        let confirmacion = confirm("¿Desea vincular la Alerta?");		
        if (confirmacion == false) return false;
        bloquearPantalla(); 

        let data = new Object();
        data.ale_man_id = ale_man_id;
        data.cas_id = $("#cas_id").val();
        data.dim_id = $("#dim_id").val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "{{route('vincular.alerta.dimension')}}",
            type: "POST",
            data: data
        }).done(function(resp){

            if (resp.estado == 1){
                listarAlertasDetectadas($("#dim_id").val());
                listarAlertasVinculadas($("#dim_id").val());
                mensajeTemporalRespuestas(1, resp.mensaje);
            }else if (resp.estado == 0){                
                mensajeTemporalRespuestas(0, resp.mensaje);
            } 
            desbloquearPantalla();
        }).fail(function(objeto, tipoError, errorHttp){            
            desbloquearPantalla();

            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

            return false;
        });

    }

</script>
<style type="text/css">
.bg-orange-pro{
    background-color: #FD7D0B;
}

#tabla_diagnostico_integral_eva > tbody > tr > td {
     vertical-align: middle;
}
</style>
