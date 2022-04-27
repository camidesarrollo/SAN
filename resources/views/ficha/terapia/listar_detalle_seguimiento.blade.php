<!-- <div id="visitas" style="margin-top: 15px;" class="table-responsive-sm"> -->
<div class="row" id="visitas">
		<!-- <table class="table table-bordered table-hover table-striped" id="tabla_detalle_seguimiento" style="max-width: 100% !important; min-width: 100%;"> -->
		<div class="col-12">
			<table class="table table-bordered" id="tabla_detalle_seguimiento" style="width: 100%;">
				<thead>
					<tr>
						<th>Fecha</th>
						<th>Modalidad</th>
						<th>Recursos</th>
						<th>Redes</th>
						<th>Riesgo</th>
						<th>Situación<br> Actual/Observaciones</th>
						@if ($modo_visualizacion == 'edicion')
							<th>Acciones</th>
						@endif
					</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div>
</div>

@if ($modo_visualizacion == 'edicion')
    <button type="button" class="btn btn-outline-success" id="btn_agregar_detalle_seguimiento" style="margin-top: 25px; float: right; margin-bottom: 25px;" onclick="$('#formDetalleSeguimiento').modal('show'); cambioFuncionformularioSeguimiento(1); limpiarFormularioDetalleSeguimiento();ocultarMensajesErrorFormularioDetalleSeguimiento();"  @if (config('constantes.gtf_egreso')  == $estado_actual_terapia) disabled @endif><i class="fa fa-plus-circle"></i> Agregar Seguimiento</button>
@endif

<script type="text/javascript">
	$(document).ready(function(){
		listarDetalleSeguimiento($("#tera_id").val());

		$(function(){
			$('#ptf_seg_fecha').datetimepicker('format', 'DD/MM/Y');
		});
	});

	function listarDetalleSeguimiento(tera_id){
		let data_detalle_seguimiento = $('#tabla_detalle_seguimiento').DataTable();

		data_detalle_seguimiento.destroy();

		let data = new Object();
		data.tera_id = tera_id;

		data_detalle_seguimiento =	$('#tabla_detalle_seguimiento').DataTable({
			//"colReorder": true,
			//"fixedHeader": { header:true },
			"dom": '<lf<t>ip>',
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			"processing": true,
			"serverSide": false,
			"paging"    : false,
			"ordering"  : false,
			"searching" : false,
			"info"		: false,
			"ajax"		: { "url" :	"{{ route('listar.detalle.seguimiento') }}", 
			"type": "GET",  
			"data": data },
			"columnDefs": [
				{
					"targets": 		0,
					"className": 	'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col){
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
				{
					"targets": 		1,
					"className": 	'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col){
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
				{
					"targets": 		2,
					"className": 	'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col){
				        $(td).css("vertical-align", "middle");
				        $(td).css("word-break", "break-word");
				     
				    }
				},
				{
					"targets": 		3,
					"className": 	'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col){
				        $(td).css("vertical-align", "middle");
				        $(td).css("word-break", "break-word");
				     
				    }
				},
				{
					"targets": 		4,
					"className": 	'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col){
				        $(td).css("vertical-align", "middle");
				        $(td).css("word-break", "break-word");
				     
				    }
				},
				{
					"targets": 		5,
					"className": 	'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col){
				        $(td).css("vertical-align", "middle");
				        $(td).css("word-break", "break-word");
				     
				    }
				},
				@if ($modo_visualizacion == 'edicion')
				{
					"targets": 		6,
					"className": 	'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col){
				        $(td).css("vertical-align", "middle");
				     
				    }
				}
				@endif
			],
			"columns"	: [
				{
					"data":'ptf_seg_fecha', 
					"render": function(data, type, row){
						let fec = new Date(data);
						fec = fec.getDate()+"/"+(fec.getMonth() + 1 )+"/"+fec.getFullYear();


						return fec;
					}
				},
				{
					"data":'ptf_mod_nombre',
					"name":'ptf_mod_nombre',
				},
				{
					"data":'ptf_seg_recursos',
					'render': function (data, type, row, meta){
						let html = '';	
						if (data == null) data = 'Sin información.';
						
						html = '<p>'+data+'</p>';
						// let html = '<div style="width: 150px;height: 80px;overflow: auto;">'+data+'</div>';

						return html;
					}
				},
				{
					"data":'ptf_seg_redes',
					'render': function (data, type, row, meta){
						let html = '';	
						if (data == null) data = 'Sin información.';

						html = '<p>'+data+'</p>';
						// let html = '<div style="width: 150px;height: 80px;overflow: auto;">'+data+'</div>';

						return html;
					}
				},
				{
					"data":'ptf_seg_riesgo',
					'render': function (data, type, row, meta){
						let html = '';
						if (data == null) data = 'Sin información.';
						
						html = '<p>'+data+'</p>';
						// let html = '<div style="width: 150px;height: 80px;overflow: auto;">'+data+'</div>';

						return html;
					}
				},
				{
					"data":'ptf_seg_observacion',
					'render': function (data, type, row, meta){
						let html = '';
						if (data == null) data = 'Sin información.';
						
						html = '<p>'+data+'</p>';
						// let html = '<div style="width: 150px;height: 80px;overflow: auto;">'+data+'</div>';

						return html;
					}
				},
				@if ($modo_visualizacion == 'edicion')
				{
					"data": "", //BOTON EDITAR
					"className": "text-center verticalText",
					"render" : function (data, type, row){
						let html = '<button type="button" class="btn btn-outline-primary btn_editar_detalle_seguimiento" onclick="accionesDetalleSeguimiento(1,'+row.ptf_seg_id+'); $(\'#formDetalleSeguimiento\').modal(\'show\'); cambioFuncionformularioSeguimiento(2); limpiarFormularioDetalleSeguimiento();"  @if (config('constantes.gtf_egreso')  == $estado_actual_terapia) disabled @endif>Editar <span class="oi oi-pencil"></span></button>';

						return html;
					}
				}
				@endif
			]
		});

		$('#tabla_detalle_seguimiento').addClass("headerTablas");

		$('#tabla_detalle_seguimiento').find("thead th").removeClass("sorting_asc");
	}

	function accionesDetalleSeguimiento(option, ptf_seg_id=null){

		let validacion = true;
		let data = new Object();

		ocultarMensajesErrorFormularioDetalleSeguimiento();


		switch (option){
			case 2: //Registrar nueva visita
				validacion = validarFormDetalleSeguimiento();
				data = recolectarValorFormularioDetalleSeguimiento();
			break;

			case 3: //Actualizar visita
				validacion = validarFormDetalleSeguimiento();
				data = recolectarValorFormularioDetalleSeguimiento();
			break;
		}

		if (validacion == false) return false;

		data.option = option;

		if (ptf_seg_id!=null){
			data.ptf_seg_id = ptf_seg_id;
		}

		bloquearPantalla();

		$.ajax({
			"url" 		: '{{ route("formulario.acciones.detalle.seguimiento") }}',
			"type"		: "GET",
			"dataType" 	: 'json',
			"data"		: data
		}).done(function(resp){
			desbloquearPantalla();

			if (resp.estado == 1){

				switch (option){
					case 1: //Mostrar información para edición

						let fec = new Date(resp.respuesta.ptf_seg_fecha);
						fec = fec.getDate()+"/"+(fec.getMonth() + 1 )+"/"+fec.getFullYear();

						$('#ptf_seg_fecha').datetimepicker('date', fec);
						$('#ptf_seg_recursos').val(resp.respuesta.ptf_seg_recursos);
						$('#ptf_seg_redes').val(resp.respuesta.ptf_seg_redes);
						$('#ptf_seg_riesgo').val(resp.respuesta.ptf_seg_riesgo);
						$('#ptf_seg_observacion').val(resp.respuesta.ptf_seg_observacion);
						$('#ptf_mod_id').val(resp.respuesta.ptf_mod_id);
						$('#ptf_seg_id').val(resp.respuesta.ptf_seg_id);

					break;

					case 2: //Insertar nuevo registro
						mensajeTemporalRespuestas(1, "Registro ingresado con éxito.");

						limpiarFormularioDetalleSeguimiento();
						cambioFuncionformularioSeguimiento(1);

						$('#formDetalleSeguimiento').modal('hide');

						listarDetalleSeguimiento($("#tera_id").val());
					break;

					case 3: //Actualizar registro
						limpiarFormularioDetalleSeguimiento();
						cambioFuncionformularioSeguimiento(1);

						$('#formDetalleSeguimiento').modal('hide');
						mensajeTemporalRespuestas(1, "Registro actualizado con éxito.");

						listarDetalleSeguimiento($("#tera_id").val());
					break;
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

	function cambioFuncionformularioSeguimiento(option){


		let titulo = "Agregar Seguimiento";

		switch(option){
			case 1: //Insertar nuevo registro
				$("#form_diag_visi_tit").text(titulo);
				$("#btn_editar_guardar_detalle_seguimiento").attr("onclick", "accionesDetalleSeguimiento(2);");
				$("#btn_editar_guardar_detalle_seguimiento").text("Guardar");
			break;

			case 2: //Modificar registro
				titulo = "Modificar Seguimiento";

				$("#form_diag_visi_tit").text(titulo);
				$("#btn_editar_guardar_detalle_seguimiento").attr("onclick", "accionesDetalleSeguimiento(3);");
				$("#btn_editar_guardar_detalle_seguimiento").text("Modificar");
			break;
		}
	}

	function recolectarValorFormularioDetalleSeguimiento(){
		let data = new Object();

		data.tera_id = $("#tera_id").val();
		data.ptf_seg_id = $("#ptf_seg_id").val();
		data.ptf_seg_fecha 	= $('#ptf_seg_fecha').data('date');
		data.ptf_mod_id = $("#ptf_mod_id").val();
		data.ptf_seg_recursos = $("#ptf_seg_recursos").val();
		data.ptf_seg_redes = $("#ptf_seg_redes").val();
		data.ptf_seg_riesgo = $("#ptf_seg_riesgo").val();
		data.ptf_seg_observacion = $("#ptf_seg_observacion").val();
		return data;
	}

	function limpiarFormularioDetalleSeguimiento(){

		$("#ptf_seg_id").val("");
		$('#ptf_seg_fecha').datetimepicker('clear');
		$("#ptf_mod_id").val("");
		$("#ptf_seg_recursos").val("");
		$("#ptf_seg_redes").val("");
		$("#ptf_seg_riesgo").val("");
		$("#ptf_seg_observacion").val("");


	}

	function ocultarMensajesErrorFormularioDetalleSeguimiento(){
		$("#val_frm_dv_1").hide();
		$("#val_msg_ptf_mod_id").hide();
		$("#val_frm_ptf_seg_recursos").hide();
		$("#val_frm_ptf_seg_redes").hide();
		$("#val_frm_ptf_seg_riesgo").hide();
		$("#val_frm_ptf_seg_observacion").hide();
	}

	function validarFormDetalleSeguimiento(){
		let respuesta = true;

		let ptf_seg_fecha = $('#ptf_seg_fecha').data('date');
		let ptf_mod_id = $("#ptf_mod_id").val();
		let ptf_seg_recursos = $("#ptf_seg_recursos").val();
		let ptf_seg_redes = $("#ptf_seg_redes").val();
		let ptf_seg_riesgo = $("#ptf_seg_riesgo").val();
		let ptf_seg_observacion = $("#ptf_seg_observacion").val();

		if (!validarFormatoFecha(ptf_seg_fecha) || !existeFecha(ptf_seg_fecha)){
			respuesta = false;
			$("#val_frm_dv_1").show();
		}

		if (ptf_mod_id == null || typeof ptf_mod_id == "undefined"){
			respuesta = false;
			$("#val_msg_ptf_mod_id").show();
		}

		if (ptf_seg_recursos == "" || ptf_seg_recursos.length < 3 || typeof ptf_seg_recursos == "undefined"){
			respuesta = false;
			$("#val_frm_ptf_seg_recursos").show();
		}

		if (ptf_seg_redes == "" || ptf_seg_redes.length < 3 || typeof ptf_seg_redes == "undefined"){
			respuesta = false;
			$("#val_frm_ptf_seg_redes").show();
		}

		if (ptf_seg_riesgo == "" || ptf_seg_riesgo.length < 3 || typeof ptf_seg_riesgo == "undefined"){
			respuesta = false;
			$("#val_frm_ptf_seg_riesgo").show();
		}

		if (ptf_seg_observacion == "" || ptf_seg_observacion.length < 3 || typeof ptf_seg_observacion == "undefined"){
			respuesta = false;
			$("#val_frm_ptf_seg_observacion").show();
		}


		/*var f_actual = hoyFecha();

		var arrayf = fec.split("/");

		var fec_formatear = arrayf[2]+"-"+arrayf[1]+"-"+arrayf[0];

		fec = new Date(fec_formatear).valueOf();

		if((fec>f_actual)&&(fec!="")){

			$("#val_frm_dv_3").show();
			return false;
		}*/

		return respuesta;
	}

	
</script>