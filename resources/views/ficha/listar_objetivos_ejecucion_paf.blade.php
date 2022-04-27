<div id="" style="margin-top: 15px;">
		<table class="table table-bordered cell-border" id="tabla_objetivos_elaborar_paf" style="width: 100%">
			<thead>
				<tr>
					<th>N°</th>
					<th>Objetivos</th>
					<th>Tareas</th>
					<th>Plazos <br>(Semanas)</th>
					<th>Responsable (s)</th>
					<th>Estado</th>
					@if ($modo_visualizacion == 'edicion' || ($modo_visualizacion == 'visualizacion' && $habilitar_funcion == true))
						<th>Sesiones</th>
					@endif
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
		<hr>
</div>

<br>
<script type="text/javascript">

	   $(function() {
         $('#fecha_ejecucion_tarea').datetimepicker({
           format: 'DD/MM/YYYY'
         });
        });	

	$(document).ready(function(){
		
		$('#formulario_tarea_ejecucion_paf').hide();
		listarObjetivosEjecucionPaf();

		$( "#btn_agregar_tarea" ).click(function() {
			$('#formulario_tarea_ejecucion_paf').show();
			ocultarMensajesError();
			limpiarFormularioTareaEjecucionPaf();
		});

	});

	function guardarDescripcionObjetivo(obj_id){

		if ($('#obj_nom').val()==''){
			alert ('Debe escribir el nombre del objetivo');
			return false;
		}

		let data = new Object();
		data.obj_id = $('#obj_id_ejecucion_paf').val();
		data.obj_nom = $('#obj_nom_ejecucion_paf').val();

		$.ajax({
			"url" : '{{ route("casos.guardarDescripcionObjetivo") }}',
			"type": "GET",
			"dataType" : 'json',
			"data": data
		}).done(function(resp){
			if (resp.estado == 1){

				let listartabla_objetivos_elaborar_paf = $('#tabla_objetivos_elaborar_paf').DataTable();
        		listartabla_objetivos_elaborar_paf.clear().destroy();
				listarObjetivosEjecucionPaf();
				alert('Descripción del objetivo Actualizada satisfactoriamente');

						
			}else{
				alert('no se pude actualizar la descripción del objetivo');
			}

		}).fail(function(obj){
			console.log(obj);
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

	function limpiarFormularioObjetivoPrincipal(){
		$("#obj_nom_modal_principal").val('');
		$("#val_frm_obj_nom_modal_principal").hide();
	}

	function guardarObjetivo(){

		let data = new Object();
		data.caso_id = $('#cas_id').val();


		validacion = validarFormObjetivoPrincipal();
		data.descripcion_objetivo = $('#obj_nom_modal_principal').val();

		if (validacion){
		$.ajax({
			"url" : '{{ route("casos.guardarObjetivoPrincipal") }}',
			"type": "GET",
			"dataType" : 'json',
			"data": data
		}).done(function(resp){
			if (resp.estado == 1){

				limpiarFormularioObjetivoPrincipal();

				
				let listartabla_objetivos_elaborar_paf = $('#tabla_objetivos_elaborar_paf').DataTable();
        		listartabla_objetivos_elaborar_paf.clear().destroy();

				listarObjetivosEjecucionPaf();
				$('#crearObjetivoModal').modal('hide');

						
			}else{
				alert('no se pude crear el objetivo');
			}

		}).fail(function(obj){
			console.log(obj);
		});

		}


	}

	function listarObjetivosEjecucionPaf(){
		let data = new Object();
		let cont_reg = 0;

		data.caso_id = $('#cas_id').val();

		var tabla_objetivos_elaborar_paf = $('#tabla_objetivos_elaborar_paf').DataTable({
			//"dom": '<lf<t>ip>',
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			"processing": true,
			"serverSide": false,
			"paging"    : false,
			"ordering"  : false,
			"searching" : false,
			"info"		: false,
			"ajax"		: 
				{ 
					"url" :	"{{ route('casos.listarObjetivosEjecucionPaf') }}", 
					"type": "GET",  
					"data": data ,
				},
			"rowsGroup" : [0,1],
			"columnDefs": [
				{
					"targets": 0,
					"className": 	'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
				{
					"targets": 1,
					"className": 	'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				        $(td).css("word-break", "break-word");
				     
				    }
				},
				{
					"targets": 2,
					"className": 	'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				        $(td).css("word-break", "break-word");
				     
				    }
				},
				{
					"targets": 3,
					"className": 	'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
				{
					"targets": 4,
					"className": 	'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
				{
					"targets": 5,
					"className": 	'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
				@if ($modo_visualizacion == 'edicion' || ($modo_visualizacion == 'visualizacion' && $habilitar_funcion == true))
				{
					"targets": 6,
					"className": 	'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				}
				@endif
			],
			"columns":[
				{
					"data":"num_reg"
				},
				{
					"data": 		"obj_nom",
					"name": 		"obj_nom"
				}, 
				{																		
					"data": 		"tar_descripcion",
					"name": 		"tar_descripcion"
				},  
				{																		
					"data": 		"plazo",
					"name": 		"plazo"
				},  
				{																		
					"data": 		"responsable",
					"name": 		"responsable",
					"render": function (data, type, row, meta){

						var cadena = data.replace(/\-/g, "<br>"+"- ");
						let html = "<p>"+cadena+"</p>";
						
						return html;
					}
				},
                                //inicio DC
				{																		
					"data": 		"estado",
					"name": 		"estado",
					"render" : function (data, type, row){					
						return row.estado;
					}
				},  
                                //fin dc

				@if ($modo_visualizacion == 'edicion' || ($modo_visualizacion == 'visualizacion' && $habilitar_funcion == true))
				{
					"data": "", 
					"className": "text-center p-2",
					"render" : function (data, type, row){
						let html = '';						
						if((row.estado == 'En Ejecución') && row.tar_id != null){

							@if($est_cas_fin == false)
							//CZ SPRINT 74 -->
							 html = '<button type="button" style="width:45%;" class="btn btn-outline-primary btn-sm" onclick="accionesObjetivoEjecucionPaf(1,'+row.tar_id+',\''+row.tar_descripcion+'\');"><i class="fas fa-plus"></i></span></button><button type="button" style="width:45%;" class="btn btn-outline-primary btn-sm" onclick="accionesObjetivoEjecucionPaf(2,'+row.tar_id+');"><i class="fas fa-eye"></i></button><br><button type="button" class="btn btn-outline-primary btn-sm mb-2 mt-2" onclick="finalizar_tarea(3 ,'+row.tar_id+');">Lograda</button><br><button type="button" class="btn btn-outline-primary btn-sm mb-2" onclick="finalizar_tarea(5, '+row.tar_id+')">No Lograda</button>';
							 //CZ SPRINT 74 -->
							 
							@endif

						}else if(row.estado == 'Vigente' && row.tar_id != null){
							@if($est_cas_fin == false)					
						    //CZ SPRINT 74 -->  
							html = '<button type="button" style="width:45%;" class="btn btn-outline-primary btn-sm" onclick="accionesObjetivoEjecucionPaf(1,'+row.tar_id+',\''+row.tar_descripcion+'\');"><i class="fas fa-plus"></i></span></button><button type="button" style="width:45%;" class="btn btn-outline-primary btn-sm" onclick="accionesObjetivoEjecucionPaf(2,'+row.tar_id+');"><i class="fas fa-eye"></i></button> <br><button type="button" class="btn btn-outline-primary btn-sm mb-2 mt-2" onclick="finalizar_tarea(2 ,'+row.tar_id+');">En Ejecución</button>';
							//CZ SPRINT 74 -->
							@endif

						}else if(row.estado == 'Lograda' && row.tar_id != null){
							//CZ SPRINT 74 -->
							 html = '<button type="button" class="btn btn-outline-primary btn-sm" onclick="accionesObjetivoEjecucionPaf(2,'+row.tar_id+');"><i class="fas fa-eye"></i></button>';
							 //CZ SPRINT 74 -->
						}else if(row.estado == 'No Lograda'){
							//CZ SPRINT 74 -->
							html = '<button type="button" class="btn btn-outline-primary btn-sm" onclick="accionesObjetivoEjecucionPaf(2,'+row.tar_id+');"><i class="fas fa-eye"></i></button>';
							//CZ SPRINT 74 -->
						}
						
						return html;
					}
				}
				@endif

			]
		});

	}
	//DC Inicio
	function selEstadoTarea(estado, idObjetivo, idTarea){
		if (confirm('¿Está seguro de que desea cambiar estado de la tarea?')) {
			let data = new Object();
        	data.caso_id 	= $("#cas_id").val();
        	data.estado 	= estado;	
        	data.idObjetivo 	= idObjetivo;
        	data.idTarea = idTarea;	
        	$.ajax({
        		type: "GET",
        		url: "{{route('casos.updEstadoTarea')}}",
        		data: data
        	}).done(function(resp){
        		if(resp == 1){
        			mensajeTemporalRespuestas(1, "Estado actualizado");
        			let listartabla_objetivos_elaborar_paf = $('#tabla_objetivos_elaborar_paf').DataTable();
                	listartabla_objetivos_elaborar_paf.clear().destroy();
        			listarObjetivosEjecucionPaf();
        		}else{
        			mensajeTemporalRespuestas(0, "Ha ocurrido un error al intentar actualizar");
        		}
        	}).fail(function(objeto, tipoError, errorHttp){
        		alert("Hubo un problema, favor intente nuevamente");
            });	
		}
	}
	//DC Fin
	function mostrarTareasEjecucionPaf(obj_id){

		$('#formulario_tarea_ejecucion_paf').hide();
		
		let data = new Object();

		let listarTablaTareas = $('#tabla_tareas_ejecucion_paf').DataTable();
        listarTablaTareas.clear().destroy();

		data.obj_id = obj_id;

		var tabla_tareas_ejecucion_paf = $('#tabla_tareas_ejecucion_paf').DataTable({
			"fixedHeader": { header:true },
			"dom": '<lf<t>ip>',
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			"colReorder": true,
			"processing": true,
			"serverSide": false,
			"paging"    : false,
			"ordering"  : false,
			"searching" : false,
			"info"		: false,
			"ajax"		: 
				{ 
					"url" :	"{{ route('casos.listarTareas') }}", 
					"type": "GET",  
					"data": data ,
				},
			"columns":[
				{
					"data": 		"tar_id",
					"name": 		"tar_id",
					"visible": 		false
				}, 
				{																		
					"data": 		"tar_descripcion",
					"name": 		"tar_descripcion",
					"className": 	"text-center",
					"width": "100px;"
				},  
				{																		
					"data": 		"tar_plazo",
					"name": 		"tar_plazo",
					"className": 	"text-center",
				},  
				/*{																		
					"data": 		"tar_observacion",
					"name": 		"tar_observacion",
				},*/
				{
					"data":'tar_observacion',
					//"className": "text-center verticalText",
					/*'render': function (data, type, row, meta){
						let html = '<div style="width: 320px;overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">'+data+'</div>';*/
					'render': function (data, type, row, meta){
						if (data==null){
							data='';
						}
						let html = '<div style="height: 300px;overflow: auto;">'+data+'</div>';

						return html;
					}
				},
				{																		
					"data": 		"nombre_responsable",
					"name": 		"nombre_responsable",
					"className": 	"text-center",
					"width": "10px;"
				}, 
				{
					"name": 		"tar_fecha_seg",
					"render" : function (data, type, row){
						let fec = "";
						if (row.tar_fecha_seg!=null){
							fec = new Date(row.tar_fecha_seg);
							fec = fec.getDate()+"/"+(fec.getMonth() + 1 )+"/"+fec.getFullYear();
						}
						return fec;
					}
				},
				/*{																		
					"data": 		"tar_comentario_seg",
					"name": 		"tar_comentario_seg",
				},*/
				{
					"data":'tar_comentario_seg',
					"name":'tar_comentario_seg',
					//"className": "text-center verticalText",
					/*'render': function (data, type, row, meta){
						let html = '<div style="width: 320px;overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">'+data+'</div>';*/
					'render': function (data, type, row, meta){
						if (data==null){
							data='';
						}
						let html = '<div style="height: 300px;overflow: auto;">'+data+'</div>';

						return html;
					}
				},
				{
					"data": "", 
					"className": "text-center",
					"render" : function (data, type, row){
						let html = '<button type="button" style="width:100%;" class="btn btn-outline-primary btn-sm" onclick="accionesTareaEjecucionPaf(1,'+row.tar_id+');">Editar <span class="oi oi-pencil"></span></button>';
						return html;
					}
				}
			]
		});
	}

	function actualizarTarea(){

		validar = validarFormTarea();

		if (validar){

		let data = new Object();
		data = recolectarValorFormularioTarea();

		$.ajax({
			"url" : '{{ route("casos.actualizarTarea") }}',
			"type": "GET",
			"dataType" : 'json',
			"data": data
		}).done(function(resp){
			if (resp.estado == 1){

						ocultarMensajesError();
						limpiarFormularioTareaEjecucionPaf();

						mostrarTareasEjecucionPaf(resp.obj_id);

						let listartabla_objetivos_elaborar_paf = $('#tabla_objetivos_elaborar_paf').DataTable();
        				listartabla_objetivos_elaborar_paf.clear().destroy();
						listarObjetivosEjecucionPaf();

				$('#formulario_tarea_ejecucion_paf').hide();
						
			}else{
				alert('no se pude actualizar la tarea');
			}

		}).fail(function(obj){
			console.log(obj);
		});
	
		}

	}


	function accionesTareaEjecucionPaf(option,tar_id){

		ocultarMensajesError();

		let validacion = true;
		let data = new Object();
		
		data.option = option;

		switch (option) {
			case 1: //Mostrar información para editar
				$('#formulario_tarea_ejecucion_paf').show();
				$('#tar_comentario_ejecucion_paf').focus();
				data.tar_id = tar_id;

				break;

			case 3: //Actualiza
				data.tar_id = ('#tar_id_ejecucion_paf').val();

				break;

		}


		$.ajax({
			"url" : '{{ route("casos.recuperarDataTarea") }}',
			"type": "GET",
			"dataType" : 'json',
			"data": data
		}).done(function(resp){
			if (resp.estado == 1){


				switch (option) {
					case 1: //Mostrar información para editar
						
						$('#tar_id_ejecucion_paf').val(resp.respuesta.tar_id);
						$('#tar_descripcion_ejecucion_paf').val(resp.respuesta.tar_descripcion);
						$('#tar_plazo_ejecucion_paf').val(resp.respuesta.tar_plazo);
						$('#tar_observacion_ejecucion_paf').val(resp.respuesta.tar_observacion);
						
						$('#fecha_ejecucion_tarea').datetimepicker('clear');
						if (resp.respuesta.tar_fecha_seg!=null){
							let fec = new Date(resp.respuesta.tar_fecha_seg);
							fec = fec.getDate()+"/"+(fec.getMonth() + 1 )+"/"+fec.getFullYear();
							$('#fecha_ejecucion_tarea').datetimepicker('date', fec);
						}


						$('#tar_comentario_ejecucion_paf').val(resp.respuesta.tar_comentario_seg);

						document.getElementById("responsable_ejecucion_paf").value = resp.respuesta.id_responsable;

						break;

					case 3: //Actualizar tarea

        				$('#tabla_tareas_ejecucion_paf').DataTable().clear().destroy();

						mostrarTareasEjecucionPaf();

						break;

				}

			}

		}).fail(function(obj){
			console.log(obj);
		});

	}

	function accionesObjetivoEjecucionPaf(option,tar_id=null,nom_tar=null){

		// let data = new Object();

		// data.option = option;

		//alert(tar_id);

		switch (option) {
			case 1: // Registrar Sesiones objetivos de tareas
				
				// data.obj_id = obj_id;

				$('#tar_id').val(tar_id);

				$('#nom_tar_paf').html(nom_tar);

				$('#fec_ses_tar').val("");

				$('#tar_sesion_ejecucion_paf').val("");

				$('#cant_carac_tar_sesion_ejecucion_paf').html(0);

				$("#val_fec_ses_tar").hide();
				
				$("#val_ses_tar").hide();

				$('#objetivoModalRegistrarSesion').modal('show');

				break;

			case 2: // Visualizar Sesiones objetivos de tareas

				//$('#tar_id').val(tar_id);

				listarSesionObjTar(tar_id);

				$('#verModalRegistrarSesion').modal('show');
				// validacion = validarFormTarea();
				// data = recolectarValorFormularioTarea();
				// data.option = option;

				break;

		}


		// ocultarMensajesError();
		// limpiarFormularioTareaEjecucionPaf();

		// let validacion = true;
		// let data = new Object();

		// data.option = option;

		// switch (option) {
		// 	case 1: //Mostrar información para editar
		// 		data.obj_id = obj_id;

		// 		mostrarTareasEjecucionPaf(obj_id);

		// 		break;

		// 	case 3: //Actualizar nueva tarea
		// 		validacion = validarFormTarea();
		// 		data = recolectarValorFormularioTarea();
		// 		data.option = option;

		// 		break;

		// }



		// $.ajax({
		// 	"url" : '{{ route("casos.accionesObjetivo") }}',
		// 	"type": "GET",
		// 	"dataType" : 'json',
		// 	"data": data
		// }).done(function(resp){
		// 	if (resp.estado == 1){

		// 		switch (option) {
		// 			case 1: //Mostrar información para editar


		// 				$("#obj_id_ejecucion_paf").val(resp.respuesta.obj_id);
		// 				$("#obj_nom_ejecucion_paf").val(resp.respuesta.obj_nom);

		// 				break;

		// 			case 3: //Actualizar tarea
		// 				limpiarFormularioTareaEjecucionPaf();

  //       				$('#tabla_objetivos_elaborar_paf').DataTable().clear().destroy();

		// 				$('#objetivoModalEjecucionPaf').modal('hide');
		// 				listarObjetivosEjecucionPaf();

		// 				break;

		// 		}
				
		// 		$('#objetivoModalEjecucionPaf').modal('show');

		// 	}else{
		// 		alert(resp.mensaje);

		// 	}
		// }).fail(function(obj){
		// 	console.log(obj);
		// });

	}

	function listarSesionObjTar(tar_id){
		
		let data = new Object();

		data.tar_id = tar_id;

		let sum_reg=0;

		let listarTablaSesionesTareas = $('#ver_historial_sesiones_objetivos_paf').DataTable();

        listarTablaSesionesTareas.clear().destroy();

		var ver_historial_sesiones_objetivos_paf = $('#ver_historial_sesiones_objetivos_paf').DataTable({
			"fixedHeader": { header:true },
			"dom": '<lf<t>ip>',
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			"colReorder": true,
			"processing": true,
			"serverSide": false,
			"paging"    : false,
			"ordering"  : false,
			"searching" : false,
			"info"		: false,
			"ajax"		: 
				{ 
					"url" :	"{{ route('casos.listar.sesiones.tareas') }}",
					"type": "GET",  
					"data": data ,
				},
					"columns":[
				{
					
					"data":"registro",
					"className": "",
					"width":'8%',  
					'render': function (data, type, row, meta){
						
						sum_reg = sum_reg + 1;

						return sum_reg;
					}
				}, 
				{																		
					"data": 		"nom_usu",
					"name": 		"nom_usu",
					"className": 	"text-center",
					"width":'22%',
				},
				{																		
					"data": 		"fecha",
					"name": 		"fecha",
					"className": 	"text-center",
					"width":'20%',
				},
				{																		
					"data": 		"comentario",
					"name": 		"comentario",
					"className": 	"text-center",
					"width":'50%',
				}
			]
		});

	}

	function ocultarMensajesError(){
		$("#val_frm_tar_descripcion").hide();
		$("#val_frm_tar_plazo").hide();
		$("#val_frm_tar_responsable").hide();
		$("#val_fecha_ejecucion_tarea_1").hide();
	}

	function validarFormTarea(){
		let respuesta = true;

		/*Se rescatan los valores del formulario*/
		let tar_descripcion	= $("#tar_descripcion_ejecucion_paf").val();
		let tar_plazo = $("#tar_plazo_ejecucion_paf").val();
		let responsable = $("#responsable_ejecucion_paf").val();
		let fecha = $("#fecha_ejecucion_tarea_input").val();
		let comentario = $("#tar_comentario_ejecucion_paf").val();

		/*Validacion Descripción*/
		if (tar_descripcion == "" || typeof tar_descripcion === "undefined"){
			respuesta = false;
			$("#val_frm_tar_descripcion").show();
		}

		/*Validacion Plazo*/
		if (tar_plazo == "" || typeof tar_plazo === "undefined"){
			respuesta = false;
			$("#val_frm_tar_plazo").show();
		}

		/*Validacion Responsable */
		if (responsable == "" || typeof responsable === "undefined"){
			respuesta = false;
			$("#val_frm_tar_responsable").show();
		}

		/*Validacion Fecha */
		if (fecha == "" || typeof fecha === "undefined"){
			respuesta = false;
			$("#val_fecha_ejecucion_tarea_1").show();
		}

		return respuesta;
	}


	function cambioFuncionformulario(option){
		let titulo = "Agregar Tarea";

		switch(option){
			case 1: //Insertar nuevo registro
				$("#form_tarea_tit").text(titulo);
				$("#btn_guardar_tarea").attr("onclick", "accionesTareaEjecucionPaf(2);");
				$("#btn_guardar_tarea").text("Guardar");
			break;

			case 2: //Modificar registro
				titulo = "Modificar Tarea: ";

				$("#form_tarea_tit").text(titulo);
				$("#btn_guardar_tarea").attr("onclick", "accionesTareaEjecucionPaf(3);");
				$("#btn_guardar_tarea").text("Modificar");
			break;
		}
	}


	function limpiarFormularioTareaEjecucionPaf(){
		$('#tar_id_ejecucion_paf').val('');
		$('#tar_descripcion_ejecucion_paf').val('');
		$('#tar_plazo_ejecucion_paf').val('');
		$('#tar_observacion_ejecucion_paf').val('');
		$('#responsable_ejecucion_paf').val('');
		$('#fecha_ejecucion_tarea').datetimepicker('clear');
		$('#tar_comentario_ejecucion_paf').val('');
		$("#cant_carac_tar_comentario_ejecucion_paf").text(0);
	}

	function recolectarValorFormularioTarea(){
		
		let data = new Object();

		data.tar_id = $("#tar_id_ejecucion_paf").val();
		data.tar_descripcion = $("#tar_descripcion_ejecucion_paf").val();
		data.tar_plazo = $("#tar_plazo_ejecucion_paf").val();
		data.tar_observacion = $("#tar_observacion_ejecucion_paf").val();
		data.id_responsable = $("#responsable_ejecucion_paf").val();
		data.obj_id = $("#obj_id_ejecucion_paf").val();
		data.fecha_ejecucion_tarea = $("#fecha_ejecucion_tarea").data('date');
		data.tar_comentario_ejecucion_paf = $("#tar_comentario_ejecucion_paf").val();

		return data;
	}


	contenido_textarea_observacion = ""; 
  	function valTextAreaobservacion(){
	    num_caracteres_permitidos   = 1000;

	    num_caracteres = $("#tar_observacion_ejecucion_paf").val().length;

	    if (num_caracteres > num_caracteres_permitidos){ 
	    	$("#tar_observacion_ejecucion_paf").val(contenido_textarea_observacion1);
	    }else{ 
	    	contenido_textarea_observacion = $("#tar_observacion_ejecucion_paf").val(); 
	    }

	    if (num_caracteres >= num_caracteres_permitidos){ 
	    	$("#cant_carac_tar_observacion_ejecucion_paf").css("color", "#ff0000"); 
	    }else{ 
	    	$("#cant_carac_tar_observacion_ejecucion_paf").css("color", "#000000");
	    } 
	      
	    $("#cant_carac_tar_observacion_ejecucion_paf").text($("#tar_observacion_ejecucion_paf").val().length);
   }


  	function valTextAreacomentariotarea(){
	    num_caracteres_permitidos   = 1000;

	    num_caracteres = $("#tar_comentario_ejecucion_paf").val().length;

	    if (num_caracteres > num_caracteres_permitidos){ 
	    	$("#tar_comentario_ejecucion_paf").val(contenido_textarea_observacion1);
	    }else{ 
	    	contenido_textarea_observacion = $("#tar_comentario_ejecucion_paf").val(); 
	    }

	    if (num_caracteres >= num_caracteres_permitidos){ 
	    	$("#cant_carac_tar_comentario_ejecucion_paf").css("color", "#ff0000"); 
	    }else{ 
	    	$("#cant_carac_tar_comentario_ejecucion_paf").css("color", "#000000");
	    } 
	      
	    $("#cant_carac_tar_comentario_ejecucion_paf").text($("#tar_comentario_ejecucion_paf").val().length);
   }

   function guardarSesionesObjTarPaf(){
   		let validarFrmIngreSesTar = valFrmIngreSesTar();
   		if (!validarFrmIngreSesTar){ return false;}

   		bloquearPantalla();

	   	let data = new Object();
		data.tar_id =  $("#tar_id").val();
		data.fec_ses_tar =  $("#fec_ses_tar").val();
		data.tar_sesion_ejecucion_paf =  $("#tar_sesion_ejecucion_paf").val();

		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});

	   	$.ajax({
			"type": 'POST',
			"dataType" : 'json',
			"url" : '{{ route("casos.guardar.sesion.ojb.tar") }}',
			"data": data
		}).done(function(resp){
			desbloquearPantalla();

			if (resp.estado == 1){
				mensajeTemporalRespuestas(1, resp.mensaje);

				$('#objetivoModalRegistrarSesion').modal('hide');
			}else{
				mensajeTemporalRespuestas(0, resp.mensaje);

			}
		}).fail(function(objeto, tipoError, errorHttp){
			manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

			desbloquearPantalla();
			return false;
		});
   }

	function valFrmIngreSesTar(){

		$("#val_fec_ses_tar").hide();
		$("#val_ses_tar").hide();

		let respuesta = true;

		let fec_ses_tar = $("#fec_ses_tar").val();

		let tar_sesion_ejecucion_paf = $("#tar_sesion_ejecucion_paf").val();

		if (fec_ses_tar == "" || typeof fec_ses_tar === "undefined"){
			respuesta = false;
			$("#val_fec_ses_tar").show();
		}
		
		tar_sesion_ejecucion_paf = tar_sesion_ejecucion_paf.trim();

		tar_sesion_ejecucion_paf = tar_sesion_ejecucion_paf.replace(/ /g,'');

		if (tar_sesion_ejecucion_paf == "" || typeof tar_sesion_ejecucion_paf === "undefined" || tar_sesion_ejecucion_paf.length < 3 ){
			respuesta = false;
			$("#val_ses_tar").show();
		}

		return respuesta;
	}
	//INICIO DC
	function actualizaPorLog(){
		let data = new Object();
		data.caso_id = {{ $caso_id }};;

		$.ajax({
			type: "GET",
			url: "{{route('validar.actualizaPorLog')}}",
			data: data
		}).done(function(resp){
			var datos = JSON.parse(resp);
			$('#tarLog').html(datos.lobgradas);
			$('#tarComp').html(datos.comprometidas);
			$('#porLog').html(datos.porLog);
		}).fail(function(objeto, tipoError, errorHttp){
				desbloquearPantalla();
                manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
                return false;
        });
	}
	//FIN DC

	function finalizar_tarea(est_id, tar_id){


	   		let data = new Object();
			data.est_id =  est_id;
			data.tar_id =  tar_id;

		if ((typeof data.est_id !== 'undefined') && (typeof data.tar_id !== 'undefined')) {

			if (confirm('¿Está seguro de que desea cambiar estado de la tarea?')) {

	   		$.ajax({
				"url" : '{{ route("casos.finalizarTarea") }}',
				"type": "GET",
				"dataType" : 'json',
				"data": data
			}).done(function(resp){

				if (resp.estado == 1){

				let listartabla_objetivos_elaborar_paf = $('#tabla_objetivos_elaborar_paf').DataTable();
        		listartabla_objetivos_elaborar_paf.clear().destroy();
				listarObjetivosEjecucionPaf();
				alert("El estado de la tarea se ha modificado correctamente.");
					//INICIO DC
					actualizaPorLog();
					//FIN DC
				}else{
					alert(resp.mensaje);

				}
			}).fail(function(obj){
				console.log(obj);
			});
			}else{
				return false;
			}
		}
		// console.log('Error: '+data);
	}
</script>