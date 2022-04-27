<div id="" style="margin-top: 15px;">
		<br>
		<table class="table table-bordered cell-border" id="tabla_objetivos" style="width: 100%">
			<thead>
			<tr role="row">
				<th colspan="9" rowspan="1">
					<div id="filtros-table-objetivos">
						<div class="row">
							<div class="col-md-3">
								<b>Fecha Inicio</b>
								<div style="max-width: 150px; padding: 20px 0px 20px 0px;">
									<div class="input-group date-pick" id="fecha_ini" data-target-input="nearest">
									<input onkeypress='return caracteres_especiales_fecha(event)' type="text" name="fecha_inicio" class="form-control datetimepicker-input "  data-target="#fecha_ini" id="fecha_inicio"  value="">
									<div class="input-group-append" data-target="#fecha_ini" data-toggle="datetimepicker">
									<div class="input-group-text"><i class="fa fa-calendar"></i>
								</div>
							</div>
						</div>
					</div>
				</div>


				<div class="col-md-3">
					<b>Fecha Termino</b>
					<div style="max-width: 150px; padding: 20px 0px 20px 0px;">
						<div class="input-group date-pick" id="fecha_ter" data-target-input="nearest">
							<input onkeypress='return caracteres_especiales_fecha(event)' type="text" name="fecha_termino" class="form-control datetimepicker-input "  data-target="#fecha_ter" id="fecha_termino"  value="">
							<div class="input-group-append" data-target="#fecha_ter" data-toggle="datetimepicker">
								<div class="input-group-text"><i class="fa fa-calendar"></i>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-4">
					<b>Estado</b><br>
					<div style="max-width: 150px; padding: 20px 0px 20px 0px;">
						<select id="chkestados" name="chkestados" multiple="multiple" class="form-control chkveg" style="background-color:#fff;">
						    <option value="1" selected >Vigente</option>
						    <option value="2" selected >Ejecución</option>
						    <option value="3" selected >Lograda</option>
						    <option value="4" selected >No Lograda</option>
						    <option value="5" selected >Sin Tarea</option>
						</select>
					</div>
				</div>
				<div class="col-md-4 col-sm-12">
					{{-- <b>Filtrar</b> --}}
					<div style="max-width: 150px; padding: 20px 0px 20px 0px;">
						<input type="button" value="Filtrar Datos" class="btn btn-outline-primary" onclick="filtroListarObjetivo();" style="margin-top: 15px;">
					</div>	
				</div>

				</div>
				</div>

			</th>

			</tr>
				<tr>
					<th>Objetivos</th> 
					<th>Vincular Alerta</th> 
					<th>Tareas</th>
					<th>Plazos <br>(Semanas)</th>
					<th>Responsable (s)</th>
					<th>Resultados esperados</th>
					<th>Estado</th>
					<th>Fecha</th>
					@if (($modo_visualizacion == 'edicion' || $habilitar_funcion == true) && $est_cas_fin == false)
						<th>Acciones</th>
					@endif
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
		<hr>
		
		@if (($modo_visualizacion == 'edicion' || $habilitar_funcion == true) && $est_cas_fin == false)
	    	<button type="button" class="btn btn-outline-success" id="btn_agregar_objetivo" style="margin-top: 10px; float: right;" data-toggle="modal" onclick="mostrarModalObjetivoPrincipal()"><i class="fa fa-plus-circle"></i> Agregar Objetivo</button>
	    @endif	
</div>
<br>


<script type="text/javascript">
//INICIO CH
	$(function() {
	grillaHistorial();
//Fin CH
	    $('.chkveg').multiselect({

	        includeSelectAllOption: false	       

	    });

	    filtroListarObjetivo();


	    //  $('.date-pick').datetimepicker({
		// 	maxDate: $.now(),
		// 	minDate: new Date('2019/06/01'),
		// 	format: 'DD/MM/Y',
		// 	locale: 'es'
		// });

	    var currentDate = new Date();

	    $('.date-pick').datetimepicker({
			format: 'DD/MM/Y',
			locale: 'es'
		}).attr('readonly', 'readonly');
    	$(".date-pick").datepicker("setDate", currentDate);
		$( ".btnCerrar" ).click(function() {		
          	$('.modal-backdrop').fadeOut(0);
        });

	});


	function filtroListarObjetivo(filtro=null,obj){

		var fec_ini = $('#fecha_inicio').val();

		var fec_ter = $('#fecha_termino').val();

		var chkestados = $('#chkestados').val();

		if(chkestados=="") chkestados=0;

		if(chkestados==5) chkestados=5;

		let listartabla_objetivos = $('#tabla_objetivos').DataTable();
        		
        listartabla_objetivos.clear().destroy();

		listarObjetivos(fec_ini,fec_ter,chkestados);
	}


	$(document).ready(function(){
		

		$('#fecha_inicio').val("");

		$('#fecha_termino').val("");

		$(".multiselect-selected-text").css({'background-color':'#fff'});

		$(".btn-group").css({'background-color':'#fff'});
		
		$("#contenedor_formulario_tareas_paf").hide().fadeOut(1000);
		listarObjetivos();
		//limpiarFormularioObjetivoPrincipal();

	});

	function agregarTarea(){
		$("#nombre_formulario_tareas").text("Agregar Tarea");

		$("#contenedor_formulario_tareas_paf").show().fadeIn(1000);
		$("#contenedor_tareas_paf").hide().fadeOut(1000);

		ocultarMensajesError();
		limpiarFormularioTarea();
	}

	function guardarDescripcionObjetivo(){
		let obj_id = $('#obj_id').val();
		let obj_nom = $('#obj_nom').val();

		if (obj_id == "" || typeof obj_id === "undefined"){
			let mensaje = "No se encuentra ID del Objetivo. Por favor verifique e intente nuevamente.";

			mensajeTemporalRespuestas(0, mensaje); return false;
		}

		if (obj_nom == "" || typeof obj_nom === "undefined"){
			let mensaje = "Debe escribir un nombre para el Objetivo. Por favor verifique e intente nuevamente.";

			mensajeTemporalRespuestas(0, mensaje); return false;
		}

		 bloquearPantalla();

		let data = new Object();
		data.obj_id = obj_id;
		data.obj_nom = obj_nom;

		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});

		$.ajax({
			"url" : '{{ route("casos.guardarDescripcionObjetivo") }}',
			"type": "POST",
			"data": data
		}).done(function(resp){
			desbloquearPantalla();

			if (resp.estado == 1){
				mensajeTemporalRespuestas(1, resp.mensaje);
				
				listarObjetivos();					
			}else if (resp.estado == 0){
				mensajeTemporalRespuestas(0, resp.mensaje);
			
			}
		}).fail(function(objeto, tipoError, errorHttp){
			desbloquearPantalla();

			manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
		});
	}

	function mostrarModalObjetivoPrincipal(){
		limpiarFormularioObjetivoPrincipal();
		$('#crearObjetivoModal').modal('show');
	}

	function validarFormObjetivoPrincipal(){

		let respuesta = true;

		/*Se rescatan los valores del formulario*/
		let obj_nom_modal_principal	= $("#obj_nom_modal_principal").val();

		/*Validacion Descripción*/
		if (obj_nom_modal_principal == "" || typeof obj_nom_modal_principal === "undefined"){
			respuesta = false;
			$("#val_frm_obj_nom_modal_principal").show();
		}

		return respuesta;

	}

	function asignarProgramaIntegranteSinAlerta(id_familiar){

		

		let data = new Object();
		data.id_familiar = id_familiar;

		$.ajax({
			url: "{{ route('ver.familiar') }}",
			type: "GET",
			data: data
		}).done(function(resp){
			//desbloquearPantalla();

			let html = "";
			
			if (resp.estado == 1){

				$("#nom-int-fam").text(resp.fam_des['nombre']);
				$("#run-int-fam").text(esconderRut(resp.fam_des['run'], "{{ config('constantes.ofuscacion_run') }}"));
				$("#grup_fam_id").val(resp.fam_des['gru_fam_id']);

				$('#asignarProgramaIntegranteSinAlerta').modal('show');
				
				cargaAsignados();

				let gru_fam_id = resp.fam_des['gru_fam_id'];

				//alert(gru_fam_id);

				listarProgramasSinAlertas(gru_fam_id);

			}else if (resp.estado == 0){
				console.log(resp.mensaje);

				html += '<div class="text-center">';
				html += '<label><b>Hubo un error al momento de buscar los programas asociados al tipo de alerta.</b></label>';
				html += '</div>';
				$("#cuerpo_asignacion_programas").hide();
				$('#body_asignacion_programas').html(html);
				$('#asignarProgramaIntegrante').modal('show');
			}
		}).fail(function(obj){
			desbloquearPantalla();

			console.log(obj);

			let html = "";
			html += '<div class="text-center">';
			html += '<label><b>Hubo un error al momento de desplegar los programas.</b></label>';
			html += '</div>';
			$("#cuerpo_asignacion_programas").hide();
			$('#body_asignacion_programas').html(html);
			$('#asignarProgramaIntegrante').modal('show');
		});

	}
	
	

	function limpiarFormularioObjetivoPrincipal(){
		$("#obj_nom_modal_principal").val('');
		$("#val_frm_obj_nom_modal_principal").hide();
	}

	function guardarObjetivo(){
		validacion = validarFormObjetivoPrincipal();
		if (!validacion){ return false; }
		
		bloquearPantalla();

		let data = new Object();
		data.caso_id = $('#cas_id').val();
		data.descripcion_objetivo = $('#obj_nom_modal_principal').val();

		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});

		$.ajax({
			"url" : '{{ route("casos.guardarObjetivoPrincipal") }}',
			"type": "POST",
			// "dataType" : 'json',
			"data": data
		}).done(function(resp){
			desbloquearPantalla();

			if (resp.estado == 0){
				mensajeTemporalRespuestas(0, resp.mensaje);

			}else{
				var idObj = resp.id;
				$("input[name=checkVincular]").each(function (index) {  
                   if($(this).is(':checked')){
                      var idAlerta = $(this).val();
                      realizarVinculacion2(idAlerta, idObj);
                      
                   }
                });
				$('#crearObjetivoModal').modal('hide');

				mensajeTemporalRespuestas(1, resp.mensaje);
				limpiarFormularioObjetivoPrincipal();

				listarObjetivos();

			}
		}).fail(function(objeto, tipoError, errorHttp){
			desbloquearPantalla();
			
			manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
		});
	}

	function listarObjetivos(fec_ini=null,fec_ter=null,chkestados=null){
		var tabla_objetivos = $('#tabla_objetivos').DataTable();
        tabla_objetivos.clear().destroy();
		//alert(chkestados);

		let data = new Object();
		data.fec_ini = fec_ini;

		data.fec_ter = fec_ter;
		
		data.chkestados = chkestados;
		
		//alert(data.chkestados);

		data.caso_id = $('#cas_id').val();
		//INICIO DC
		tabla_objetivos = $('#tabla_objetivos').DataTable({
			//"fixedHeader": { header:true },
			"dom": '<lf<t>ip>',
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			//"colReorder": true,
			"processing": true,
			"serverSide": false,
			"paging"    : false,
			"ordering"  : false,
			"searching" : false,
			"info"		: false,
			"ajax"		: 
				{ 
					"url" :	"{{ route('casos.listarObjetivosPaf') }}", 
					"type": "GET",  
					"data": data ,
				},
			"rowsGroup" : [0,1],
			"columnDefs": [ 
				{
					"targets": 		0,
					"className": 	'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				        $(td).css("word-break", "break-word");
				     
				    }
				},
				{
					"targets": 		1,
					"className": 	'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				        $(td).css("word-break", "break-word");
				     
				    }
				},
				{
					"targets": 		2,
					"className": 	'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				        $(td).css("word-break", "break-word");
				     
				    }
				},
				{
					"targets": 		3,
					"className": 	'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
				{
					"targets": 		4,
					"className": 	'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
				{
					"targets": 		5,
					"className": 	'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				        $(td).css("word-break", "break-all");
				    }
				},
				{
					"targets": 		6,
					"className": 	'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
				{
					"targets": 		7,
					"className": 	'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
				@if (($modo_visualizacion == 'edicion' || $habilitar_funcion == true) && $est_cas_fin == false)
					{
						"targets": 		8,
						"className": 	'dt-head-center dt-body-center',
						"createdCell": function (td, cellData, rowData, row, col) {
					        $(td).css("vertical-align", "middle");
					     
					    }
					}
				@endif
			],
			"columns":[
				{
					"data": 		"obj_nom",
					"name": 		"obj_nom",
					"render": function (data, type, row, meta){
						let nombre = data;
						if (nombre == "" || nombre == undefined) nombre = "Sin información";

						return nombre;
					}
				}, 
				{																		
					"data": 		"obj_nom",
					"name": 		"obj_nom",
					"render": function (data, type, row, meta){
						let html = '';
						// INICIO CZ SPRINT 59
						@if($est_cas_fin)
						html = '<button type="button" style="width:100%;" disabled class="btn btn-outline-primary btn-sm" onclick="vincularAlerta('+row.obj_id+', \''+row.obj_nom+'\');">Vincular alerta <span class="oi oi-pencil"></span></button>'; 
						@else 
						html = '<button type="button" style="width:100%;" class="btn btn-outline-primary btn-sm" onclick="vincularAlerta('+row.obj_id+', \''+row.obj_nom+'\');">Vincular alerta <span class="oi oi-pencil"></span></button>';
						@endif
						// FIN CZ SPRINT 59
						return html;
														
					}
				}, 
				{																		
					"data": 		"tar_descripcion",
					"name": 		"tar_descripcion",
					"render": function (data, type, row, meta){
						let tarea = data;
						if (tarea == "" || tarea == undefined) tarea = "Sin información";

						return tarea;
					}
				},  
				{																		
					"data": 		"plazo",
					"name": 		"plazo",
					"render": function (data, type, row, meta){
						let plazo = data;
						if (plazo == "" || plazo == undefined) plazo = "Sin información";

						return plazo;
					}
				},  
				{																		
					"data": 		"responsable",
					"name": 		"responsable",
					"render": function (data, type, row, meta){
						let resp = data;
						if (resp == "" || resp == undefined) resp = "Sin información";
						
						resp = resp.replace(/\-/g, "<br>"+"- ");


						let html = "<p>"+resp+"</p>";
						
						return html;
					}
				},  
				{
					"data":'observacion',
					"render": function (data, type, row, meta){
						let obs = data;
						if (obs == "" || obs == undefined) obs = "Sin información";

						return obs;
					}
				},
				{																		
					"data": 		"estado",
					"name": 		"estado",
					"render": function (data, type, row, meta){
						let estado = data;
						if (estado == "" || estado == undefined) estado = "Sin información";

						return estado;
					}
				},  
				{																		
					"data": 		"fecha_estado",
					"name": 		"fecha_estado",
					"render": function (data, type, row, meta){
						let fecha = data;
						if (fecha == "" || fecha == undefined) fecha = "Sin información";

						return fecha;
					}
				},
				@if (($modo_visualizacion == 'edicion' || $habilitar_funcion == true) && $est_cas_fin == false) 
					{
						"data": "",
						"render" : function (data, type, row){

							let html;
							//INICIO DC
							if((row.est_tar_id==1)||(row.est_tar_id==2)||(row.est_tar_id==3))
							{
								//CZ SPRINT 74 -->
							html = '<button type="button" style="width:100%;" class="btn btn-outline-primary btn-sm" onclick="accionesObjetivo(1,'+row.obj_id+');">Editar/Crear <span class="oi oi-pencil"></span></button><br><br><button type="button" style="width:100%;" class="btn btn-outline-primary btn-sm" onclick="accionesObjetivo(4,'+row.obj_id+','+row.tar_id+');"> Eliminar <span class="oi oi-delete"></span></button>';
							//CZ SPRINT 74 -->
							}
							else if(row.est_tar_id==4){

							html = '<button type="button" disabled style="width:100%;" class="btn btn-outline-primary btn-sm" onclick="accionesObjetivo(1,'+row.obj_id+');">Editar/Crear <span class="oi oi-pencil"></span></button>';

							}else {

							html = '<button type="button" style="width:100%;" class="btn btn-outline-primary btn-sm" onclick="accionesObjetivo(1,'+row.obj_id+');">Editar/Crear <span class="oi oi-pencil"></span></button>';

							}
							
							return html;
							//FIN DC

						}
					}
				@endif
			]
		});
		//FIN DC
		actualizaCantComp();
	}
	//INICIO DC
	function actualizaCantComp(){
		let data = new Object();
		data.caso_id = {{ $caso_id }};;

		$.ajax({
			type: "GET",
			url: "{{route('validar.actualizaCantComp')}}",
			data: data
		}).done(function(resp){
			$('#cantComp').html(resp);

		}).fail(function(objeto, tipoError, errorHttp){
				desbloquearPantalla();
                manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
                return false;
        });
	}
	//FIN DC
//INICIO CH
function grillaHistorial(){

	var cas_id = $("#cas_id").val();
	tabla_doc_paf = $('#tabla_doc_paf').DataTable({
		//"paging":   false,
		"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json" },
			"ajax": "{{ route('doc.paf') }}/"+cas_id,

			
			"columns": [
				{ "data": "doc_fec", "className": "text-center" },
				{ "data": "doc_paf_arch", "className": "text-center" },
				{
				'render': function (data, type, full, meta) {
					return 	'<a href="/doc/'+full.doc_paf_arch+'" target="_blank" >Descargar Documento</a>';
				}, "className": "text-center"
			}
			]
		});
	$(".alert").hide();
	if ($("#nec_ter").val() == 1) $("#cont_ter").css("display", "block");
}// FIN CH
	function actualizarTarea(){
		ocultarMensajesError();
		validar = validarFormTarea();
		if (!validar){ return false; }

		bloquearPantalla();

		let data = new Object();
		data = recolectarValorFormularioTarea();

		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});

		$.ajax({
			"url" : '{{ route("casos.actualizarTarea") }}',
			"type": "POST",
			"data": data
		}).done(function(resp){
			desbloquearPantalla();

			if (resp.estado == 1){
				$("#contenedor_formulario_tareas_paf").hide().fadeOut(1000);
				$("#contenedor_tareas_paf").show().fadeIn(1000);	
				
				mostrarTareas(resp.obj_id);
				mensajeTemporalRespuestas(1, resp.mensaje);
				
				ocultarMensajesError();
				limpiarFormularioTarea();

				listarObjetivos();
				
			}else if (resp.estado == 0){
				mensajeTemporalRespuestas(0, resp.mensaje);
			
				return false;
			}
		}).fail(function(objeto, tipoError, errorHttp){
			desbloquearPantalla();

			manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

			return false;
		});
	}


	function accionesTarea(option,tar_id){
		$("#nombre_formulario_tareas").text("Editar Tarea");
		$("#contenedor_tareas_paf").hide().fadeOut(1000);
		$("#contenedor_formulario_tareas_paf").show().fadeIn(1000);
		
		bloquearPantalla();

		ocultarMensajesError();
		limpiarFormularioTarea();

		let data = new Object();
		data.option = option;
		data.tar_id = tar_id;

		$.ajax({
			"url" : '{{ route("casos.recuperarDataTarea") }}',
			"type": "GET",
			"data": data
		}).done(function(resp){
			desbloquearPantalla();

			if (resp.estado == 1){
				$('#tar_id').val(resp.respuesta.tar_id);
				$('#tar_descripcion').val(resp.respuesta.tar_descripcion);
				$('#tar_plazo').val(resp.respuesta.tar_plazo);
				$('#tar_observacion').val(resp.respuesta.tar_observacion);

				let chk_arr =  document.getElementsByName("responsable[]");

				let chklength = chk_arr.length; 
				for (let i = 0; i < chklength; i++) { 
					chk_arr[i].checked = false; 
				}

				let chk_resp = resp.respuesta.responsables;
				let chk_resp_length = resp.respuesta.responsables.length;
				let separa_valor;

				for (let k = 0; k < chklength; k++){
					for (let z = 0; z < chk_resp_length; z++){
						separa_valor = chk_arr[k].value;
						let valor = separa_valor.split('-');
						let id = valor[0];

						if(chk_resp[z] == id){
							chk_arr[k].checked = true;
						}
					}	
				}
			}else if(resp.estado == 0){
				mensajeTemporalRespuestas(0, resp.mensaje);

				return false;
			}
		}).fail(function(objeto, tipoError, errorHttp){
			desbloquearPantalla();
		
			manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
		});
	}
	//INICIO DC
	function vincularAlerta(obj_id, obj_nom){
			ocultarMensajesError();
			desbloquearPantalla();
		$('#vincularModal').modal({keyboard: false});
		verAlertasDetectadas(obj_id);
		$('#nomObjetivo').html(obj_nom);		
		}
	//FIN DC
	function verAlertasDetectadas(obj_id){
		let data = new Object();
		data.cas_id = {{ $caso_id }};
		data.obj_id = obj_id;
		let tabla_at_diagnostico = $('#tabla_alertas_detectadas2').DataTable();
        tabla_at_diagnostico.clear().destroy();
        tabla_at_diagnostico = $('#tabla_alertas_detectadas2').DataTable({
            "language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
            "lengthChange": false,
			"info": 		false,
			"searching":	false,
			"paging":		false,
            "ajax": {
                "url": "{{ route('listar.alerta.detectada') }}",
                "type": "GET",
                "data": data
            },
            "columnDefs": [
                { //TIPO DE ALERTAS
                    "targets": 0,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
				{ //CANTIDAD
                    "targets": 1,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //ACCIONES
                    "targets": 2,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                        $(td).css("width", "30%");
                    
                    }
                },
                { //ESTADO
                    "targets": 3,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                        $(td).css("width", "30%");
                    
                    }
                }
            ],				
            "columns": [
                        { //TIPO DE ALERTAS
                            "data": "ale_tip_nom",
                            "className": "text-center"
                        },
						{ //CANTIDAD
                            "data": "cantidad",
                            "className": "text-center"
                        },
                        { //ACCIONES
                            "data": "ale_man_id",
                            "className": "text-center",
                            "render": function(data, type, row){
                            	let html = '';
								
								if(row.vinculado > 0){
									html = '<button id="btnVincular_'+data+'" type="button" class="btn btn-success" data-toggle="modal" data-target="#frmlistadoAlertasporTipo" disabled>Vinculado</button>';
								}else{
									if(row.est_ale_id == 2 || row.est_ale_id == 4){ //Validada o Incorporada
										html = '<button id="btnVincular_'+data+'" type="button" class="btn btn-primary" data-toggle="modal" data-target="#frmlistadoAlertasporTipo" onclick="realizarVinculacion('+data+', '+obj_id+');"><i class="fas fa-search"></i> Vincular</button>';
									}else{
										html = '';
									}									
								}								
								return html;
                            }
                        },
                        { //ESTADO
                            "data": "est_ale_id",
                            "className": "text-center",
                            "render": function(data, type, row){
								return row.est_ale_nom;
                            }
                        }
                    ]
            });
            
	}
	function verVinculacion(alerta, obj_id){
		let data = new Object();
		data.cas_id = {{ $caso_id }};
		data.alerta = alerta;
		data.obj_id = obj_id;
		$.ajax({
			type: "GET",
			url: "{{route('listar.alerta.verVinculacion')}}",
			data: data
		}).done(function(resp){
			var datos = JSON.parse(resp);
			if(datos.data[0].vinculados > 0){
				$('#btnVincular_'+alerta).html('Vinculada');
				$('#btnVincular_'+alerta).removeClass("btn-primary");
				$('#btnVincular_'+alerta).addClass("btn-success");
				$('#btnVincular_'+alerta).attr("disabled", true);
				
			}
			
		}).fail(function(objeto, tipoError, errorHttp){
				desbloquearPantalla();
                manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
                return false;
        });
	}
	function verAlertasVinculadas(){
	
	}
	function verificaVinculacion(obj_id){
		let data = new Object();
		data.cas_id = {{ $caso_id }};
		data.obj_id = obj_id
		$.ajax({
			type: "GET",
			url: "{{route('listar.alerta.detectada')}}",
			data: data
		}).done(function(resp){
			var datos = JSON.parse(resp);

			for (var i = 0; i < datos.data.length; i+=1) {
				var alerta = datos.data[i].ale_man_id
				$('#btnVincular_'+alerta).html('Vinculada');
				$('#btnVincular_'+alerta).removeClass("btn-primary");
				$('#btnVincular_'+alerta).addClass("btn-success");
				$('#btnVincular_'+alerta).attr("disabled", true);
			}
		}).fail(function(objeto, tipoError, errorHttp){
				desbloquearPantalla();
                manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
                return false;
        });
	}
	function realizarVinculacion(idAlerta, idObj){
		let confirmacion = confirm("¿ Esta seguro(a) en realizar la vinculacion ?");
		if(confirmacion == true){
			bloquearPantalla();
			let data = new Object();
			data.cas_id = {{ $caso_id }};
			data.idAlerta = idAlerta;
			data.idObj = idObj;
			$.ajax({
			"url" : '{{ route("casos.vincularObjetivo") }}',
			"type": "GET",
			"dataType" : 'json',
			"data": data
		}).done(function(resp){
			desbloquearPantalla();
			if(resp.data == true){
				
				mensajeTemporalRespuestas(1, 'Se ha vinculado la alerta.');
				//INICIO DC
				vincularAlerta(idObj, $('#nomObjetivo').html());
				//FIN DC
			}else{
				mensajeTemporalRespuestas(0, 'Ha ocurrido un error al intentar vincular la alerta.');
			}
		}).fail(function(obj){
			console.log(obj);
		});
		}else{
			return false;
		}
	}
	//INICIO DC
	function realizarVinculacion2(idAlerta, idObj){
		bloquearPantalla();
			let data = new Object();
			data.cas_id = {{ $caso_id }};
			data.idAlerta = idAlerta;
			data.idObj = idObj;
			$.ajax({
			"url" : '{{ route("casos.vincularObjetivo") }}',
			"type": "GET",
			"dataType" : 'json',
			"data": data
		}).done(function(resp){
			desbloquearPantalla();
			if(resp.data != true){
				mensajeTemporalRespuestas(0, 'Ha ocurrido un error al intentar vincular la alerta.');
			}
		}).fail(function(obj){
			console.log(obj);
		});
	}
	//FIN DC
	function accionesObjetivo(option,obj_id=null,tar_id=null){

		ocultarMensajesError();
		limpiarFormularioTarea();

		let validacion = true;
		let data = new Object();

		data.option = option;

		switch (option) {
			case 1: //Mostrar información para editar
				data.obj_id = obj_id;

				mostrarTareas(obj_id);

				break;

			case 3: //Actualizar nueva tarea
				validacion = validarFormTarea();
				data = recolectarValorFormularioTarea();
				data.option = option;

				break;

			case 4: //Dejar no vigente la tarea
				data.option = option;
				data.tar_id = tar_id;

				 let confirmacion = confirm("¿ Esta seguro de cambiar el estado de la Tarea a No Lograda ?");

				 if (confirmacion == false) return false;

				break;

		}



		$.ajax({
			"url" : '{{ route("casos.accionesObjetivo") }}',
			"type": "GET",
			"dataType" : 'json',
			"data": data
		}).done(function(resp){
			if (resp.estado == 1){

				switch (option) {
					case 1: //Mostrar información para editar

						$("#obj_id").val(resp.respuesta.obj_id);
						$("#obj_nom").val(resp.respuesta.obj_nom);
						$('#objetivoModal').modal('show');

						$("#contenedor_tareas_paf").show().fadeIn(1000);
						$("#contenedor_formulario_tareas_paf").hide().fadeOut(1000);
					break;

					case 3: //Actualizar tarea
						limpiarFormularioTarea();

        				$('#tabla_objetivos').DataTable().clear().destroy();

						$('#objetivoModal').modal('hide');
						listarObjetivos();
						$('#objetivoModal').modal('show');
						break;

					case 4: //Actualizar tarea

						let listartabla_objetivos = $('#tabla_objetivos').DataTable();
		        		listartabla_objetivos.clear().destroy();
						listarObjetivos();
						
						alert("El registro ha sido actualizado correctamente");

						break;

				}

				

			}else{
				alert(resp.mensaje);

			}
		}).fail(function(obj){
			console.log(obj);
		});

	}

	function ocultarMensajesError(){
		$("#val_frm_tar_descripcion").hide();
		$("#val_frm_tar_observacion").hide();
		$("#val_frm_tar_plazo").hide();
		$("#val_frm_tar_responsable").hide();
	}

	function validarFormTarea(){
		let respuesta = true;

		/*Se rescatan los valores del formulario*/
		let tar_descripcion	= $("#tar_descripcion").val();
		let tar_plazo = $("#tar_plazo").val();
		let responsable = $("#responsable").val();
		let tar_observacion = $("#tar_observacion").val();

		/*Validacion Descripción*/
		if (tar_descripcion == "" || typeof tar_descripcion === "undefined"){
			respuesta = false;
			$("#val_frm_tar_descripcion").show();
		}

		/*Validacion Descripción*/
		if (tar_observacion == "" || typeof tar_observacion === "undefined"){
			respuesta = false;
			$("#val_frm_tar_observacion").show();
		}

		/*Validacion Plazo*/
		if (tar_plazo == "" || typeof tar_plazo === "undefined"){
			respuesta = false;
			$("#val_frm_tar_plazo").show();
		}

		/*Validacion Responsable */
		var chk_arr =  document.getElementsByName("responsable[]");
		var chklength = chk_arr.length;

		let res_check = false;

		for(k=0;k< chklength;k++){

			if(chk_arr[k].checked == true){

				res_check = true;

			}

		} 

		if(res_check==false){

			respuesta = false;

			$("#val_frm_tar_responsable").show();
		
		}

		return respuesta;
	}


	function cambioFuncionformulario(option){
		let titulo = "Agregar Tarea";

		switch(option){
			case 1: //Insertar nuevo registro
				$("#form_tarea_tit").text(titulo);
				$("#btn_guardar_tarea").attr("onclick", "accionesTarea(2);");
				$("#btn_guardar_tarea").text("Guardar");
			break;

			case 2: //Modificar registro
				titulo = "Modificar Tarea: ";

				$("#form_tarea_tit").text(titulo);
				$("#btn_guardar_tarea").attr("onclick", "accionesTarea(3);");
				$("#btn_guardar_tarea").text("Modificar");
			break;
		}
	}


	function limpiarFormularioTarea(){
		
		$('#tar_id').val('');
		$('#tar_descripcion').val('');
		$('#tar_plazo').val('');
		$('#tar_observacion').val('');
		$('#responsable').val('');

		//limpia check

		var chk_arr =  document.getElementsByName("responsable[]");
		var chklength = chk_arr.length; 
		for(k=0;k< chklength;k++) { chk_arr[k].checked = false; }

	}

	function recolectarValorFormularioTarea(){
		
		let data = new Object();

		data.tar_id = $("#tar_id").val();
		data.tar_descripcion = $("#tar_descripcion").val();
		data.tar_plazo = $("#tar_plazo").val();
		data.tar_observacion = $("#tar_observacion").val();
		data.obj_id = $("#obj_id").val();
		data.cas_id = $("#cas_id").val();

		data.id_responsable = null;

		let grup_fam_id = [];

		var chk_arr =  document.getElementsByName("responsable[]");
		var chklength = chk_arr.length; 
		let i = 0;
		let separa_valor;

		for(k=0;k< chklength;k++){

			if(chk_arr[k].checked == true){

				separa_valor = chk_arr[k].value;

				let valor = separa_valor.split('-');

				let id = valor[0];
				let perfil = valor[1];

				if(perfil==3){

				data.id_responsable = id;

				} else {

				grup_fam_id[i] = id;

				}

				//grup_fam_id[i] = chk_arr[k].value;

				i++;

			}
		}

		data.grup_fam_id = grup_fam_id;

		return data;

	}


	contenido_textarea_observacion = ""; 
  	function valTextAreaobservacion(){
	    num_caracteres_permitidos   = 1000;

	    num_caracteres = $("#tar_observacion").val().length;

	    if (num_caracteres > num_caracteres_permitidos){ 
	    	$("#tar_observacion").val(contenido_textarea_observacion1);
	    }else{ 
	    	contenido_textarea_observacion = $("#tar_observacion").val(); 
	    }

	    if (num_caracteres >= num_caracteres_permitidos){ 
	    	$("#cant_carac_tar_observacion").css("color", "#ff0000"); 
	    }else{ 
	    	$("#cant_carac_tar_observacion").css("color", "#000000");
	    } 
	      
	    $("#cant_carac_tar_observacion").text($("#tar_observacion").val().length);
   }
</script>
