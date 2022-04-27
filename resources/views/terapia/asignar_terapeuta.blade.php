@extends('layouts.main')

@section('contenido')

	<section class="p-1 cabecera">
		<div class="container-fluid">
			<div class="row align-items-center">
				<div class="col-md-12">
					<h5><i class="{{$icono}} mr-2"></i> Asignar a Terapeuta</h5>
				</div>
			</div>
		</div>
	</section>


<input type="hidden" id ="com_cod" name="com_cod" value="{{$com_cod}}">

	@if(Session::has('success'))
		<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>{{ Session::get('success') }}</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	@endif
	@if(Session::has('danger'))
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
			<strong>{{ Session::get('danger') }}</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	@endif

	@if ($errors->any())
		<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif
	
	<section>
		<div class="container-fluid">
			<div class="card p-4 shadow-sm">
				<h5>Total NNA <span class="badge badge-warning" id="totalNNA">0</span></h5>
				<h5>Total Casos <span class="badge badge-danger">{{ $cantidad_casos }}</span></h5>
				
				<table id="asignar_terapeuta_registrados" class="table table-hover table-striped" attr2="{{route('coordinador.caso.ficha')}}" style="width: 100% !important">
					<thead>
						<tr>
							<th colspan="16"><div id="filtros-table"></div></th>
						</tr>
						<tr>
							<th style="display: none;">R.U.N</th>
							<th>Nombre NNA</th>
							<th>Prioridad</th>
							<th>Alerta Nómina</th>
							<th>Últimas<br>Alertas SAN</th>
							<th>Estado Gesti&oacute;n Caso</th>
							<th>Estado Terapia Familiar</th>
							<th>Gestión</th>
							<th>RUNSINFORMATO</th>
							<!-- INICIO CZ SPRINT 71 MANTIS 9849 -->
							<th class="text-center">Caso</th>
							<!-- FIN CZ SPRINT 71 MANTIS 9849 -->
						</tr>
					</thead>
					<tbody></tbody>
				</table>

			</div>
		</div>

		<div class="card-body">

			<div id="asignarTerapeutaModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="asignarTerapeutaModal" aria-hidden="true">
				<div class="modal-dialog modal-lg">
					<div class="modal-content p-4">
						<div class="modal-header">

							<h2 class="modal-title" id="form_familiar_tit">Asignar a Terapeuta</h2>

							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>

						<div class="modal-body">

							<input type="hidden" id="cas_id" name="cas_id">

							<div class="form-row">
								{{ csrf_field() }}


							<div class="form-group col-md-12">
								<label id="label_justificacion_gestor"></label>
						    	<textarea disabled rows="4" id="justificacion" class="form-control"></textarea>
						      	
						    </div>

							<div class="form-group col-md-12" style="display:none;">
									<label><b>Aprobar Terapia</b></label>
									<br>
									<input type="radio" name="aprobar_terapia" id="aprobar_terapia" value="1" checked onchange="validarAprobacion(1)"> Si<br>
									<input type="radio" name="aprobar_terapia" id="aprobar_terapia" value="2" onchange="validarAprobacion(2)"> No<br>
							</div>

							<div id="seleccionar_terapeuta" class="form-group col-md-12" style="display:none">
								<label><b>Asignar a Terapeuta:</b></label>
								<select class="form-control" name="terapeuta" id="terapeuta">
									<option value="" >Seleccione al Terapeuta</option>
									@foreach($terapeutas as $terapeuta)
									    <option value="{{$terapeuta->id}}">{{$terapeuta->nombre}}</option>
									@endforeach
								</select>
								<p id="val_frm_terapeuta" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe seleccionar el terapeuta.</p>
							</div>

							<div id="div_justificacion_coordinador" class="form-group col-md-12" style="display:none">
								<label><b>Justificación de Coordinador</b></label>
						      	<textarea rows="4" id="justificacion_coordinador" name="justificacion_coordinador" class="form-control" onkeypress='return caracteres_especiales(event)' onKeyUp="valTextAreaRechazo()" onKeyDown="valTextAreaRechazo()"></textarea>
						      	<p id="val_frm_justificacion_rechazo" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe escribir el motivo de rechazo.</p>
							    <div class="row">
									<div class="col-md-12 col-lg-6">
										<h6><small class="form-text text-muted">Mínimo 3 y máximo 1000 caracteres.</small></h6>
									</div>
									<div class="col-md-12 col-lg-6">
										<h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_1" style="color: #000000;">0</strong></small></h6>
									</div>
								</div>

					    	</div>

									
								</div>

								<div class="text-left">
									<button type="button" id="btn_guardar_objetivo" class="btn btn-primary" onclick="asignarTerapeuta();">Asignar</button>
									<button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
								</div>

						</div>
					</div>
				</div>
			</div>

		</div>

	</section>
@stop

@section('script')
<script type="text/javascript" >

	var ajaxFlag	= 0;
	var ajaxFlagTope= 2;

	$(document).ready(function(){

		validarAprobacion(1);

        //listarCasos();
		var ordenacionesEstablecidas = new Array();

		listarTerapeutasRegistrados();

		$('#asignar_terapeuta_registrados').addClass("headerTablas");

		var filaDeCombos = '<div class="row">';
		var contador = 1;

		for (var fila = 0; fila <= 1; fila += 2){
			
			filaDeCombos +=	'<div class="col">';
			filaDeCombos +=	'<b>Ordenar por</b><br>';
			filaDeCombos += '<select class="form-control form-control-sm selector_de_criterio" style="margin-left: 12px; margin-top: 2px;">';
			filaDeCombos += '<option value="-1" selected>Sin Selección</option>';
			filaDeCombos +=	'</select>';
			filaDeCombos +=	'</div>';
			filaDeCombos +=	'<div class="col" style="padding-top: 15px;">';
			filaDeCombos += '<div class="custom-control custom-radio">';
			filaDeCombos += '<input type="radio" id="radio_asc_1" class="custom-control-input sentido_ascendente" name="sentido_'+(contador-1)+'" checked disabled>';
			filaDeCombos += '<label class="custom-control-label" for="radio_asc_1">Ascendente</label>';
			filaDeCombos += '</div>';
			filaDeCombos += '<div class="custom-control custom-radio">';
			filaDeCombos += '<input type="radio" id="radio_des_2" class="custom-control-input sentido_descendente" name="sentido_'+(contador-1)+'" disabled>';
			filaDeCombos += '<label class="custom-control-label" for="radio_des_2">Descendente</label>';
			filaDeCombos += '</div>';
			filaDeCombos += '</div>';
			contador ++;

			filaDeCombos +=	'<div class="col">';
			filaDeCombos +=	'<b>Luego por</b><br>';
			filaDeCombos += '<select class="form-control form-control-sm selector_de_criterio" style="margin-left: 12px; margin-top: 2px;">';
			filaDeCombos += '<option value="-1" selected>Sin Selección</option>';
			filaDeCombos +=	'</select>';
			filaDeCombos +=	'</div>';
			filaDeCombos +=	'<div class="col" style="padding-top: 15px;">';
			filaDeCombos += '<div class="custom-control custom-radio">';
			filaDeCombos += '<input type="radio" id="radio_asc_3" class="custom-control-input sentido_ascendente" name="sentido_'+(contador-1)+'" checked disabled>';
			filaDeCombos += '<label class="custom-control-label" for="radio_asc_3">Ascendente</label>';
			filaDeCombos += '</div>';
			filaDeCombos += '<div class="custom-control custom-radio">';
			filaDeCombos += '<input type="radio" id="radio_des_4" class="custom-control-input sentido_descendente" name="sentido_'+(contador-1)+'" disabled>';
			filaDeCombos += '<label class="custom-control-label" for="radio_des_4">Descendente</label>';
			filaDeCombos += '</div>';
			filaDeCombos += '</div>';
			contador ++;
		}

		filaDeCombos +=	'<div class="col-1" style="padding: 0;">';
		filaDeCombos += '<input type="button" id="botonDeOrdenar" class="btn btn-outline-primary btn-xs" value="Ordenar" style="position: absolute; bottom: 22px;" disabled>';
		filaDeCombos +=	'</div>';
		filaDeCombos += '</div>';

		var setDeCombos = $(filaDeCombos);
		setDeCombos.appendTo('#filtros-table');
		$('.selector_de_criterio:gt(0)').prop('disabled', true);

		var opciones = new Array();

		opciones[0] = $("<option value='0'>R.U.N</option>");
		opciones[1] = $("<option value='1'>Prioridad</option>");
		opciones[2] = $("<option value='2'>Alerta Nómina</option>");
		opciones[3] = $("<option value='3'>Últimas Alertas SAN</option>");
		opciones[4] = $("<option value='4'>Estado</option>");

		for (var i = 0; i <= 4; i ++) opciones[i].appendTo('.selector_de_criterio');
		
		$('.selector_de_criterio').on('change', function(){
			
			var indiceDeCombo = $(this).index('.selector_de_criterio');
			var criterioSeleccionado = $('.selector_de_criterio:eq('+indiceDeCombo+')').prop('value');

			if (criterioSeleccionado == '-1'){
				
				$('.sentido_ascendente').prop('checked', true);
				$('.sentido_ascendente:eq('+indiceDeCombo+'), .sentido_descendente:eq('+indiceDeCombo+')').prop('disabled', true);

				while (indiceDeCombo < 4){
					indiceDeCombo ++;
					$('.selector_de_criterio:eq('+indiceDeCombo+')').prop({'value':'-1', 'disabled':true});
					$('.sentido_ascendente:eq('+indiceDeCombo+'), .sentido_descendente:eq('+indiceDeCombo+')').prop('disabled', true);
				}

			} else {
				
				if (indiceDeCombo < 4) $('.selector_de_criterio:eq('+(indiceDeCombo + 1)+')').prop({'value':'-1', 'disabled':false});
				$('.sentido_ascendente:eq('+indiceDeCombo+'), .sentido_descendente:eq('+indiceDeCombo+')').prop('disabled', false);
				
			}

			inhabilitarSeleccionados();
			recrearOrdenaciones();
			
		});

		$('.sentido_ascendente, .sentido_descendente').on('click', function(){
			recrearOrdenaciones();
		});

		$('#botonDeOrdenar').on('click', function(){
			var dataTable_asignar_terapeuta_reg = $('#asignar_terapeuta_registrados').DataTable();
			dataTable_asignar_terapeuta_reg.order(ordenacionesEstablecidas).draw();
		});


		function recrearOrdenaciones(){
	ordenacionesEstablecidas = new Array();

	for (var i = 0; i <= 1; i ++){
		if ($('.selector_de_criterio:eq('+i+')').prop('value') != '-1'){
			sentidoDeOrdenacion = ($('.sentido_ascendente:eq('+i+')').prop('checked'))?'asc':'desc';
			criterioDeOrdenacion = new Array(parseInt($('.selector_de_criterio:eq('+i+')').prop('value')), sentidoDeOrdenacion);
			ordenacionesEstablecidas.push(criterioDeOrdenacion);
		}
	}

	$('#botonDeOrdenar').prop('disabled', (ordenacionesEstablecidas.length == 0));
			
}

function inhabilitarSeleccionados(){
	for (var i = 1; i <= 6; i ++){
		$('.selector_de_criterio').each(function(){
			$($(this)[0].options[i]).css('display', 'inline-block');
		});
	}

	$('.selector_de_criterio').each(function(){
		
		var opcionDeEsteCombo = $($(this)[0]).prop('value');
		var indiceDeEsteCombo = $('.selector_de_criterio').index(this);

		if (opcionDeEsteCombo == '-1') return;

		for (var i = 0; i <= 1; i ++){
			if (i == indiceDeEsteCombo) continue;
			$($('.selector_de_criterio:eq('+i+')')[0].options).each(function(){
				if ($(this).prop('value') == opcionDeEsteCombo) $(this).css('display', 'none');
			});
		}
		
	});
}


	});	

function listarTerapeutasRegistrados(){

	let data = new Object();
	data.com_cod = $('#com_cod').val();

	var dataTable_asignar_terapeuta_reg = $('#asignar_terapeuta_registrados').DataTable();
    dataTable_asignar_terapeuta_reg.clear().destroy();

	dataTable_asignar_terapeuta_reg = $('#asignar_terapeuta_registrados').DataTable({
		"dom": '<lf<t>ip>',
		"order":[
			[1, "asc"]
		],
		"processing": true,
		"serverSide": true,
		"searching": true,
		"ajax":{
			"url":"{{ route('data.terapia.asignar_terapeuta') }}",
			"type": "GET",  
			"dataType": "JSON",
			"data": data,
			"error":  function(jqXHR, text, error){
           		if (ajaxFlag < ajaxFlagTope){
					ajaxFlag++;
					listarTerapeutasRegistrados();
				}else{
					manejoPeticionesFailAjax(jqXHR, text, error);
				}
			}
		},
		"rowGroup": {
            	dataSrc: "cas_id",
				startRender: function ( rows, group ) {
                	return "Caso " + group;
				}
        },
		"columns":[
		{
			"data": 		"nna_run_con_formato",
			"name": 		"nna_run_con_formato",
		 	"className": 	"text-center",
		 	"visible": 		false,
			"orderable": 	true,
			"searchable": 	true,
			"render": function(data, type, row){ 
				console.log(data, type, row);

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
				return '<label data-toggle="tooltip" data-html="true" title="R.U.N.: ' + full.nna_run_con_formato + '<br />Nombre completo:<br />' + full.nna_nombre_completo + '">' + full.nna_nom + ' ' + full.nna_ape_pat + '</label>';
			}
		},
		{																		
			"data": 		"score",
			"name": 		"score",
			"className": 	"text-center",
			"orderable": 	true,
			"searchable": 	false
		},
		{																					
			"data": 		"n_alertas",
			"name": 		"n_alertas",
			"className": 	"text-center",
			"width": 		"85px",
			"orderable": 	true,
			"searchable": 	false,
			"render": function(data, type, row){ return listarIconoAlerta(row.n_alertas); }
		},   
		{																		
			"data": 		"n_am",
			"name": 		"n_am",
			"className": 	"text-center",
			"orderable": 	true,
			"searchable": 	false,
			"render": function(data, type, row){ return listarIconoAlerta(row.n_am); }
		},  
		{																				
			"data": 		"est_cas_nom",
			"name": 		"est_cas_nom",
			"className": 	"text-left",
			"orderable": 	true,
			"render" : function (data, type, full, meta){
				//####### Se agrega icono de pausa en los casos que corresponda ##############
				let html = full.est_cas_nom;
				if(full.cas_est_pau == 0){
					html += '<br><i class="far fa-pause-circle fa-2x" style="color:red;" title="Caso Pausado"></i>';
				}
				return html;
			 }
		},
		{
			"data"		: "est_tera_nom",
			"name"		: "est_tera_nom",
			"className"	: "text-center",
			"visible"	: true,
			"orderable"	: true,
			"searchable": true
		}, 
		{
			"data": "", 
			"className": "text-center",
			"width": "25px",
			"orderable": 	false,
			"searchable": 	false,
			"render" : function (data, type, row){
				@if(session()->all()['perfil'] != config("constantes.perfil_coordinador"))
				let html = '<button type="button" disabled style="width:100%;" class="btn btn-outline-primary btn-sm" onclick="modalAsignarTerapeuta('+row.cas_id+');">Asignar <span class="oi oi-pencil"></span></button>';
				@else
				let html = '<button type="button" style="width:100%;" class="btn btn-outline-primary btn-sm" onclick="modalAsignarTerapeuta('+row.cas_id+');">Asignar <span class="oi oi-pencil"></span></button>';
				@endif
				return html;
			}
		},
		{
			 "data": 		"nna_run",
			 "name": 		"nna_run",
			 "className": 	"text-center",
			 "visible": 	false,
			 "orderable": 	false,
			 "searchable": 	true
		},
		// INICIO CZ SPRINT 71 MANTIS 9849
		{
			"data": 		"cas_id",
			"name": 		"cas_id",
			"className": 	"text-center",
			"visible":      false,
			"orderable": 	false
		}
		// FIN CZ SPRINT 71 MANTIS 9849
	],
		"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
		"drawCallback": function (settings){
			$("#totalNNA").text(settings._iRecordsTotal);
			$('[data-toggle="tooltip"]').tooltip();
		}
	});

}



function modalAsignarTerapeuta(cas_id){

		let data = new Object();
		data.cas_id = cas_id;

		$.ajax({
			"url" : '{{ route("data.terapia.asignar_terapeuta.justificacion_terapia") }}',
			"type": "GET",
			"dataType" : 'json',
			"data": data
		}).done(function(resp){
			$("#justificacion").val(resp.cas_just_terapia);
		}).fail(function(obj){
			console.log(obj);
		});

		$.ajax({
			"url" : '{{ route("data.terapia.asignar_terapeuta.nombreGestor") }}',
			"type": "GET",
			"dataType" : 'json',
			"data": data
		}).done(function(resp){
			$("#label_justificacion_gestor").html('<b>Justificación del Gestor: '+resp[0].usuario_nomb+'</b>');
		}).fail(function(obj){
			console.log(obj);
		});

		$("#cas_id").val(cas_id);
		$('#asignarTerapeutaModal').modal('show');

		ocultarMensajesError();
		limpiarModalTerapia();

		let validacion = true;

	}

	function ocultarMensajesError(){
		$("#val_frm_terapeuta").hide();
		$("#val_frm_justificacion_rechazo").hide();
	}

	function limpiarModalTerapia(){
		$('#terapeuta').val('');
		$('#justificacion_coordinador').val('');
	}



	function validarModalTerapia(){
		let respuesta = true;


		if ($("#aprobar_terapia").val()==1){
			let terapeuta	= $("#terapeuta").val();
			if (terapeuta == "" || typeof terapeuta === "undefined"){
				respuesta = false;
				$("#val_frm_terapeuta").show();
			}			
		}

		if ($("#aprobar_terapia").val()==2){
			let justificacion_coordinador	= $("#justificacion_coordinador").val();
			if (justificacion_coordinador == "" || typeof justificacion_coordinador === "undefined"){
				respuesta = false;
				$("#val_frm_justificacion_rechazo").show();
			}			
		}

		return respuesta;
	}

	
   function recolectarValorModalTerapeuta(){
		
		let data = new Object();
		data.tera_id = $("#terapeuta").val();
		data.cas_id = $("#cas_id").val();
		data.aprobar_terapia = $("#aprobar_terapia").val();
		data.justificacion_coordinador = $("#justificacion_coordinador").val();
		return data;
	}

	function validarAprobacion(opcion){
		ocultarMensajesError();
		if (opcion==1){
			$("#aprobar_terapia").val(1);
			$('#seleccionar_terapeuta').show();
			$('#div_justificacion_coordinador').hide();
		}

		if (opcion==2){
			$("#aprobar_terapia").val(2);
			$('#seleccionar_terapeuta').hide();
			$('#div_justificacion_coordinador').show();
		}

	}


	contenido_textarea_rechazo = ""; 
  	function valTextAreaRechazo(){
      num_caracteres_permitidos   = 1000;

      num_caracteres = $("#justificacion_coordinador").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#justificacion_coordinador").val(contenido_textarea_observacion1);

       }else{ 
          contenido_textarea_observacion1 = $("#justificacion_coordinador").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_1").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_1").css("color", "#000000");

       } 

      
       $("#cant_carac_1").text($("#justificacion_coordinador").val().length);
   }


   function asignarTerapeuta(){

		validar = validarModalTerapia();

		if (validar){

		let data = new Object();
		data = recolectarValorModalTerapeuta();

		bloquearPantalla();

		$.ajax({
			"url" : '{{ route("data.terapia.asignar_terapeuta.crear_terapia") }}',
			"type": "GET",
			"dataType" : 'json',
			"data": data
		}).done(function(resp){
			if (resp.estado == 1){

						ocultarMensajesError();
						limpiarModalTerapia();


				$('#asignarTerapeutaModal').modal('hide');

				location.reload();

			}else{
				alert('no se pude asignar el terapeuta');
			}

			desbloquearPantalla();

		}).fail(function(obj){
			desbloquearPantalla();
			console.log(obj);
		});
	
		}

	}

</script>
@endsection