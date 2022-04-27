<div id="visitas" class="table-responsive">
	<!-- <table class="table table-striped table-hover w-100" id="tabla_visita_diagnostico" style="max-width: 100% !important; min-width: 100%;"> -->
	<table class="table table-striped table-hover" id="tabla_visita_diagnostico" style="width: 100% !important;">
			<thead>
				<tr>
					<th>N° de Actividad</th>
					<th>Fecha</th>
					<th>Descripción</th>
					<th>Modalidad</th>
					@if ($modo_visualizacion == 'edicion' || $habilitar_funcion == true)
						<th>Acciones</th>
					@endif
				</tr>
			</thead>
			<tbody></tbody>
		</table>
		

		@if ($modo_visualizacion == 'edicion')
	    	<button type="button" class="btn btn-outline-success" @if(config('constantes.en_diagnostico')!= $estado_actual_caso) disabled @endif id="btn_agregar_diagnostico_visita" style="margin-top: 25px; float: right; margin-bottom: 25px;" onclick="if (validarCantidadVisitas() == true) {$('#formVisitasDiagnostico').modal('show'); cambioFuncionformularioVisitas(1); limpiarFormularioVisitas();ocultarMensajesErrorFormularioVisitas();}"><i class="fa fa-plus-circle"></i> Agregar Nueva Actividad</button>
	    @endif
</div>
<br>
<script type="text/javascript">
	$(document).ready(function(){
		listarVisitasDiagnosticoCaso($("#cas_id").val());

		$(function(){
			$('#form_diag_visi_fec').datetimepicker('format', 'DD/MM/Y');
		});

		setTimeout(function(){ validarCantidadVisitas(); }, 3000);
	});

	function listarVisitasDiagnosticoCaso(caso_id){
		let data_visitaDiagnostico = $('#tabla_visita_diagnostico').DataTable();

		data_visitaDiagnostico.destroy();

		let data = new Object();
		data.caso_id = caso_id;

		data_visitaDiagnostico =	$('#tabla_visita_diagnostico').DataTable({
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			"paging"    : false,
			"ordering"  : false,
			"searching" : false,
			"info"		: false,
			"ajax"		: { "url" :	"{{ route('listar.visitas.diagnostico') }}", "type": "GET",  "data": data },
			"createdRow": function( row, data, dataIndex ){
				//console.log("que sucede?", row, data, dataIndex); return false;
			},
			"columnDefs": [ 
				{ //N°
					"targets": 		0,
					"width": 		"10%",
					"className": 	'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				        $(td).css("word-break", "break-word");
				     
				    }
				},
				{ //FECHA VISITA
					"targets": 		1,
					"width": 		"20%",
					"className": 	'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				        $(td).css("word-break", "break-word");
				     
				    }
				},
				{ //DESCRIPCIÓN VISITA
					"targets": 		2,
					"width": 		"40%",
					"className": 	'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				        $(td).css("word-break", "break-word");
				     
				    }
				},
				{ //MODALIDAD VISITA
					"targets": 		3,
					"width": 		"20%",
					"className": 	'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				        $(td).css("word-break", "break-word");
				     
				    }
				},
				@if ($modo_visualizacion == 'edicion' || $habilitar_funcion == true)
				{ //ACCIONES
					"targets": 		4,
					"width": 		"10%",
					"className": 	'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				        $(td).css("word-break", "break-word");
				     
				    }
				}
				@endif
			],
			"columns"	: [
				{
					"data": "numero_visita", //N°
					"render": function(data, type, row){
						$("#total_visitas_actuales").val(data);

						return data;
					}
				},
				{
					"data":'fecha_visita', //FECHA VISITA
					"render": function(data, type, row){
						let fec = new Date(data);
						fec = fec.getDate()+"/"+(fec.getMonth() + 1 )+"/"+fec.getFullYear();


						return fec;
					}
				},
				{
					"data":'descripcion_visita', //DESCRIPCIÓN VISITA
					'render': function (data, type, row, meta){
						// let html = '<div style="width: 420px;overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">'+data+'</div>';
						let html = '<p>'+data+'</p>';

						return html;
					}
				},
				{
					"data":'modalidad_visita', //MODALIDAD VISITA
					'render': function (data, type, row, meta){
						// let html = '<div style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">'+data+'</div>';
						let html = '<p>'+data+'</p>';

						return html;
					}
				},
				@if ($modo_visualizacion == 'edicion' || $habilitar_funcion == true)
				{
					"data": "", //BOTON EDITAR
					"render" : function (data, type, row){
						//console.log(data, type, row.numero_visita);
						//INICIO CZ SPRINT 59 
						@if($est_cas_fin)
						let html = '<button type="button" disabled class="btn btn-outline-primary" onclick="accionesVisitas(1, '+row.numero_visita+'); $(\'#formVisitasDiagnostico\').modal(\'show\'); cambioFuncionformularioVisitas(2); limpiarFormularioVisitas();">Editar <span class="oi oi-pencil"></span></button>';

						@else 
						let html = '<button type="button" class="btn btn-outline-primary" onclick="accionesVisitas(1, '+row.numero_visita+'); $(\'#formVisitasDiagnostico\').modal(\'show\'); cambioFuncionformularioVisitas(2); limpiarFormularioVisitas();">Editar <span class="oi oi-pencil"></span></button>';

						@endif
						//FIN CZ SPRINT 59

						return html;
					}
				}
				@endif
			],
			"drawCallback": function (settings){}
		});

		// $('#tabla_visita_diagnostico').addClass("headerTablas");

		$('#tabla_visita_diagnostico').find("thead th").removeClass("sorting_asc");
	}

	function accionesVisitas(option, num_vis = null){
		let validacion = true;
		let data = new Object();

		ocultarMensajesErrorFormularioVisitas();

		switch (option){
			case 1: //Buscar información visita
				data.num_vis = num_vis;
			break;

			case 2: //Registrar nueva visita
				validacion = validarFormVisitas();
				data = recolectarValorFormularioVisitas();
			break;

			case 3: //Actualizar visita
				validacion 		= validarFormVisitas();
				data 			= recolectarValorFormularioVisitas();
				data.num_vis 	= $("#numero_visita").val();
			break;
		}

		if (validacion == false) return false;
		if(option == 2 || option == 3) bloquearPantalla();
		
		data.option = option;
		data.cas_id = $("#cas_id").val();
		data.cant_vis = $("#total_visitas_actuales").val();

		//console.log(data); return false;
		//$.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="_token_formulario_familiar"]').attr('content')} });

		$.ajax({
			"url" 		: '{{ route("formulario.acciones.visitas") }}',
			"type"		: "GET",
			"dataType" 	: 'json',
			"data"		: data
		}).done(function(resp){
			if (resp.estado == 1){
				switch (option){
					case 1: //Mostrar información para edición
						limpiarFormularioVisitas();

						let fec = new Date(resp.respuesta.fecha_visita);
						fec = fec.getDate()+"/"+(fec.getMonth() + 1 )+"/"+fec.getFullYear();

						$('#form_diag_visi_fec').datetimepicker('date', fec);
						$('#form_diag_visi_des').val(resp.respuesta.descripcion_visita);
						$('#modalidad_visita').val(resp.respuesta.modalidad_visita);

						$("#numero_visita").val(resp.respuesta.numero_visita);
						cambioFuncionformularioVisitas(2);
					break;

					case 2: //Insertar nuevo registro
						desbloquearPantalla();
						limpiarFormularioVisitas();
						cambioFuncionformularioVisitas(1);

						$('#formVisitasDiagnostico').modal('hide');
						alert("Registro guardado exitosamente.");

						validarCantidadVisitas();

						listarVisitasDiagnosticoCaso($("#cas_id").val());
					break;

					case 3: //Actualizar registro
						desbloquearPantalla();
						limpiarFormularioVisitas();
						cambioFuncionformularioVisitas(1);

						$('#formVisitasDiagnostico').modal('hide');
						alert("Registro actualizado exitosamente.");

						listarVisitasDiagnosticoCaso($("#cas_id").val());
					break;
				}
			}
		}).fail(function(obj){
			console.log(obj);
			desbloquearPantalla();
			let mensaje = "Error al momento de realizar la acción solicitada. Por favor intente nuevamente.";
			if (typeof obj.responseJSON.mensaje != "undefined" && obj.responseJSON.mensaje != "") mensaje = obj.responseJSON.mensaje;

			alert(mensaje);
		});
	}

	function cambioFuncionformularioVisitas(option){
		
		let titulo = "Agregar Actividad";

		switch(option){
			case 1: //Insertar nuevo registro
				$("#form_diag_visi_tit").text(titulo);
				$("#btn_editar_guardar_visitas_diagnostico").attr("onclick", "accionesVisitas(2);");
				$("#btn_editar_guardar_visitas_diagnostico").text("Guardar");
	    		$("#cant_carac_1").text(0); 
			break;

			case 2: //Modificar registro
				titulo = "Modificar Actividad";

				$("#form_diag_visi_tit").text(titulo);
				$("#btn_editar_guardar_visitas_diagnostico").attr("onclick", "accionesVisitas(3);");
				$("#btn_editar_guardar_visitas_diagnostico").text("Modificar");
				// cuenta la cantidad de caracteres del textarea al editar los datos 
				num_caracteres = $("#form_diag_visi_des").val().length;
	    		$("#cant_carac_1").text(num_caracteres);
			break;
		}
	}

	function recolectarValorFormularioVisitas(){
		let data = new Object();

		data.fecha_visita 		= $('#form_diag_visi_fec').data('date');
		data.descripcion_visita = $("#form_diag_visi_des").val();
		data.modalidad_visita = $("#modalidad_visita").val();

		
		return data;
	}

	function limpiarFormularioVisitas(){
		$('#form_diag_visi_fec').datetimepicker('clear');
		$("#form_diag_visi_des").val("");
		$("#numero_visita").val("");
		$("#modalidad_visita").val("");
	}

	function ocultarMensajesErrorFormularioVisitas(){
		$("#val_frm_dv_1").hide();
		$("#val_frm_dv_2").hide();
		$("#val_frm_dv_3").hide();
		$("#val_msg_modalidad_visita").hide();
	}

	function validarFormVisitas(){
		let respuesta = true;

		let fec = $('#form_diag_visi_fec').data('date');
		let des = $('#form_diag_visi_des').val();
		let modalidad = $('#modalidad_visita').val();

		if (!validarFormatoFecha(fec) || !existeFecha(fec)){
			respuesta = false;
			$("#val_frm_dv_1").show();
		}

		if (des == "" || des.length < 3 || typeof des == "undefined"){
			respuesta = false;
			$("#val_frm_dv_2").show();
		}

		if (modalidad == null || typeof modalidad == "undefined"){
			respuesta = false;
			$("#val_msg_modalidad_visita").show();
		}

		var f_actual = hoyFecha();

		var arrayf = fec.split("/");

		var fec_formatear = arrayf[2]+"-"+arrayf[1]+"-"+arrayf[0];

		fec = new Date(fec_formatear).valueOf();

		if((fec>f_actual)&&(fec!="")){

			$("#val_frm_dv_3").show();
			return false;
		}

		return respuesta;
	}

	function validarCantidadVisitas(){
		if ($("#total_visitas_actuales").val() >= 3){
			$("#btn_agregar_diagnostico_visita").attr("disabled", true);

			return false;
		}

		return true;
	}

	con_text_1= "";
	function valTextCrearAlertaActividad(){
	      num_caracteres_permitidos   = 1000;

	      num_caracteres = $("#form_diag_visi_des").val().length;

	       if (num_caracteres > num_caracteres_permitidos){ 
	            $("#form_diag_visi_des").val(con_text_1);

	       }else{ 
	          con_text_1 = $("#form_diag_visi_des").val(); 

	       }

	       if (num_caracteres >= num_caracteres_permitidos){ 
	          $("#cant_carac_1").css("color", "#ff0000"); 

	       }else{ 
	          $("#cant_carac_1").css("color", "#000000");

	       } 

	      
	       $("#cant_carac_1").text($("#form_diag_visi_des").val().length);
	}
</script>