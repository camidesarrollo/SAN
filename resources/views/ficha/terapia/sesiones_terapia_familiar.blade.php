@extends('layouts.main')

@section('contenido')
	<input type="hidden" name="nna_run" id="nna_run" value="{{$nna_run}}">

	<!-- CALENDARIO -->
	<div class="container-fluid">
			<div id="calendar" style="width: 100%; padding: 25px;"></div>
	</div>

	<!-- MODAL -->
	<div class="modal fade" id="planificacionSesionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Planificar Sesi&oacute;n</h5>
				</div>
				<div class="modal-body">
					<div class="form-group" id="run_nna_buscar"></div>
					<div class="form-group ocultarPlanificacion">
						<label class="col-form-label">Nombre NNA:</label>
						<label class="form-control" id="nna_nombre_completo">{{ $nombre_completo }}</label>
					</div>
					<div class="form-group ocultarPlanificacion">
						<label class="col-form-label">Tipo Sesi&oacute;n:</label>
						<select class="form-control" id="ptf_actividad" onchange="filtroActividadObjetivo();">
							@foreach ($ptf_actividad as $sesion)
								<option id="{{$sesion->ptf_actividad}}">{{$sesion->ptf_actividad}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group ocultarPlanificacion">
						<label class="col-form-label">Objetivo:</label>
						<select class="form-control" id="ptf_id" onchange="establecerNumeroSesion();">
							@foreach ($ptf_objetivo as $objetivo)
								<option id="{{$objetivo->ptf_id}}" data-id="{{$objetivo->ptf_actividad}}" data-sesion="{{ $objetivo->ptf_numero }}">{{ $objetivo->ptf_numero." - ".$objetivo->ptf_objetivo}}</option>
							@endforeach
						</select>
					</div>
					<div class="row ocultarPlanificacion">
						<div class="col-md-1" style="display: none;">
							<div class="form-group">
								<label class="col-form-label">N° Sesi&oacute;n:</label>
								<input class="form-control" type="number" id="ses_ptf_n_ses" name="ses_ptf_n_ses" min="1" max="10" value="1" >
								<div id="msg_ses_ptf_n_ses" class="invalid-feedback">Falta completar el campo N° Sesi&oacute;n</div>
							</div>
						</div>
						<div class="col-md-6 ocultarPlanificacion">
							<div class="form-group">
								<label class="col-form-label">Hora inicio:</label>
								<input class="form-control" type="time" id="ses_ptf_hor_ini" name="ses_ptf_hor_ini" value="00:00">
								<div id="msg_ses_ptf_hor_ini" class="invalid-feedback">Falta completar el campo Hora inicio</div>
							</div>
						</div>
						<div class="col-md-6 ocultarPlanificacion">
							<div class="form-group">
								<label class="col-form-label">Hora fin:</label>
								<input class="form-control" type="time" id="ses_ptf_hor_fin" name="ses_ptf_hor_fin" value="00:00">
								<div id="msg_ses_ptf_hor_fin" class="invalid-feedback">Falta completar el campo Hora fin</div>
							</div>
						</div>
						<input type="hidden" id="tera_id"		name="tera_id"		value="{{ $tera_id }}" />
						<input type="hidden" id="ses_ptf_fec"	name="ses_ptf_fec"	value="" />
						<input type="hidden" id="ses_ptf_id"	name="ses_ptf_id"	value="" />
					</div>
					<div class="form-group ocultarPlanificacion">
						<label for="message-text" class="col-form-label">Observaciones:</label>
						<textarea maxlength="2000" onkeypress="return caracteres_especiales(event)" onkeyup="valTextAreaSesPTFCom()" onkeydown="valTextAreaSesPTFCom()" class="form-control " rows="7" id="ses_ptf_com"></textarea>
						<p id="ses_dev_com_2" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar el minimo de caracteres.</p>
						<div id="msg_ses_ptf_com" class="invalid-feedback">Falta completar el campo observaciones</div>
						<div class="row"></div>
						<div class="col">
							<h6><small class="form-text text-muted">Mínimo 3 y máximo 2000 caracteres.</small></h6>
						</div>
						<div class="col text-left">
							<h6><small class="form-text text-muted">N° de caracteres: <strong id="ses_ptf_com_len" style="color: #000000;">0</strong></small></h6>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button id="modal_cerrar" 	type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
					@if(Session::get('perfil')==config('constantes.perfil_terapeuta'))
						<button id="modal_guardar" type="button" class="btn btn-success ocultarPlanificacion">Guardar</button>
						<button id="modal_eliminar"	type="button" class="btn btn-danger ocultarPlanificacion" onclick="eliminarSesionesTerapiaFamiliar();">Eliminar</button>
					@endif
				</div>
			</div>
		</div>
	</div>

@stop

@section('script')
<script type="text/javascript" >
	var ajaxFlag	= 0;
	var ajaxFlagTope= 2;

$(document).ready(function(){
	getSesionesTerapiaFamiliar({{ $tipo_planificacion }});

	// Evitar ingreso de texto en un input
	jQuery('#ses_ptf_n_ses').bind('keypress', function(e) {
		var arrKeyCode = new Array(49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 48, 101);
		if (jQuery.inArray( e.keyCode , arrKeyCode )){ return false; }
		e.stopPropagation(); 
	});

	filtroActividadObjetivo();

	@if ($tipo_planificacion == 1) ocultarSegunTipoPlanificación(true); @endif
});


/**
 * Función que valida los caracteres ingresados en un textarea
 */
function valTextAreaSesPTFCom(){
	num_caracteres_permitidos 	= 2000;
    num_caracteres 				= $("#ses_ptf_com").val().length;

    if (num_caracteres > num_caracteres_permitidos){ 
    	$("#ses_ptf_com").val(contenido_textarea_com_ses);
    }else{ 
    	contenido_textarea_com_ses = $("#ses_ptf_com").val(); 
    }

    if (num_caracteres >= num_caracteres_permitidos){ 
    	$("#ses_ptf_com_len").css("color", "#ff0000"); 
    }else{ 
    	$("#ses_ptf_com_len").css("color", "#000000");
    } 
      
    $("#ses_ptf_com_len").text($("#ses_ptf_com").val().length);
}


/**
 * Función que realiza la llamada de las sesiones de terapia familiar ya cargadas
 */
function getSesionesTerapiaFamiliar(tipo_planificacion){
	let data = new Object();

	data.tipo_planificacion = tipo_planificacion;
	if (tipo_planificacion == 0) data.nna_run = $('#nna_run').val();

	$.ajax({
		url : "{{ route('getSesionesTerapiaFamiliar') }}",
		data :  data,
		type : 'GET',
		dataType : 'json',
		success : function(jsonRequest){
			let fcEvent	= new Array();
			$(jsonRequest.sesiones).each(function( index, element ) {
				var fcEvent_	= new Object();
				var fechaEvento	= element.ses_ptf_fec.split(' ')[0];
				fcEvent_.id 	= element.ses_ptf_id;
				fcEvent_.title 	= ` - N°${element.ses_ptf_n_ses} - ${element.ptf_actividad}`;
				fcEvent_.tera_id = element.tera_id;
				fcEvent_.backgroundColor = element.est_tera_back_col;
				// fcEvent_.textColor = "#000000";
				fcEvent_.start 	= `${fechaEvento}T${element.ses_ptf_hor_ini}:00`;
				fcEvent_.end 	= `${fechaEvento}T${element.ses_ptf_hor_fin}:00`;
				fcEvent.push(fcEvent_);
			});

			$('#calendar').html('');

			var calendarEl = document.getElementById('calendar');

			var calendar = new FullCalendar.Calendar(calendarEl, {
				locale			: 'es',
				timeZone		: 'local',
				plugins			: [ 'dayGrid', 'interaction', 'timeGrid' ],
  				selectable		: true,
  				businessHours	: true,
  				editable 		: false,
  				events 			: fcEvent,
  				eventTimeFormat : {
    				hour: '2-digit',
    				minute: '2-digit',
    				// second: '2-digit',
    				meridiem: false
  				},
				dateClick: function(info) {
					if (tipo_planificacion == 0){
						@if(Session::get('perfil')==config('constantes.perfil_terapeuta'))
							planificacionSesionModal(info, jsonRequest.tera_id, {{ $tipo_planificacion }});
						@endif

					}else if(tipo_planificacion == 1){
						@if(Session::get('perfil')==config('constantes.perfil_terapeuta'))
							planificacionSesionModal(info, "", {{ $tipo_planificacion }});
						@endif

					}
				},
				select: function(info) {
					//alert('selected ' + info.startStr + ' to ' + info.endStr);
				},
				eventClick: function(info){
					planificacionSesionModal(info, info.event.extendedProps.tera_id, {{ $tipo_planificacion }});
				}
			});
			
			calendar.render();

			if (tipo_planificacion == 0){
				$('#calendar').append('<br/>');
				$('#calendar').append('<a href="{{ route('gestion-terapia-familiar') }}/'+data.nna_run+'" class="btn btn-primary btn-lg" role="button"><i class="fa fa-reply" aria-hidden="true"></i> Volver Ficha</a>');

			}
		},
		error : function(jqXHR, textStatus, errorThrown){
			if (ajaxFlag < ajaxFlagTope){
				ajaxFlag++;
				getSesionesTerapiaFamiliar({{ $tipo_planificacion }});
			
			}else{
				manejoPeticionesFailAjax(jqXHR, textStatus, errorThrown);
			
			}
		}
	});
}


/**
 * Functión que registra las sesiones de terapia familiar ingresadas.
 */
function guardarSesionesTerapiaFamiliar(tera_id){
	bloquearPantalla();

	if (!validarModalSesionesTerapiaFamiliar()){
		desbloquearPantalla();

		return false;
	}

	let data 			= new Object();
	data.tera_id		= tera_id;
	data.ptf_actividad 	= $('#ptf_actividad option:selected').attr('id');
	data.ptf_id 		= $('#ptf_id option:selected').attr('id');
	data.ses_ptf_com	= $('#ses_ptf_com').val();
	data.ses_ptf_n_ses	= $('#ses_ptf_n_ses').val();
	data.ses_ptf_fec	= $('#ses_ptf_fec').val();
	data.ses_ptf_hor_ini= $('#ses_ptf_hor_ini').val();
	data.ses_ptf_hor_fin= $('#ses_ptf_hor_fin').val();

	$.ajaxSetup({
		headers: {
		    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$.ajax({
		url 	: "{{ route('registrarSesionesTerapiaFamiliar') }}",
		data 	: data,
		type 	: 'POST',
		dataType: 'json',
		success : function(jsonRequest) {
			desbloquearPantalla();
			
			if (jsonRequest.estado == 1){
				mensajeTemporalRespuestas(1, jsonRequest.mensaje);

				$('#planificacionSesionModal').modal('hide');
				getSesionesTerapiaFamiliar({{ $tipo_planificacion }});
			}else{
				mensajeTemporalRespuestas(0, jsonRequest.mensaje);
			
			}
		},
		error 	: function(jqXHR, textStatus, errorThrown){
			desbloquearPantalla();

			manejoPeticionesFailAjax(jqXHR, textStatus, errorThrown);
		}
	});
}


/**
 * Functión que despliega modal para los eventos del calendario.
 */
function planificacionSesionModal(info, tera_id = null, tipo_planificacion){
	let html = '<label class="col-form-label">RUN:</label><br/>';

	// BLOQUEO DE PANTALLA
	bloquearPantalla();

	// CREACION SESION
	if (typeof(info.event) == 'undefined'){
		// VALIDADOR DE FECHA PLANIFICACION
		if (!validarFechaSesionTerapiaFamiliar(info.dateStr)){
			let mensaje = "¡Atencion! No se pueden planificar sesiones con fechas inferiores a la actual.";
			alert(mensaje);

			// SE DESBLOQUEA PANTALLA
			desbloquearPantalla(); return false;
		}

		if (tipo_planificacion == 0){ // FICHA
			html += '<label class="form-control" id="nna_run_formato">{{ $run_formateado }}</label>';

			activacionBotonGuardarEliminar(0, tera_id);
		}else if (tipo_planificacion == 1){ //MENU
			html += '<input type="input" class="form-control" id="nna_run_formato" onchange="this.value = formatearRun(this.value);" onkeyup="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();" onblur="validarRunPlanificadorSesiones(this.value);">';
		}

		// LIMPIAMOS FORMULARIO
		limpiarFormularioPlanificadorSesiones(tipo_planificacion);
		
		// SE DESPLIEGA FORMULARIO
		$("#run_nna_buscar").html(html);
		$('#ses_ptf_fec').val(info.dateStr);
		$('#planificacionSesionModal').modal('show');

		// SE DESBLOQUEA PANTALLA
		desbloquearPantalla();
	
	}else{ //VISUALIZAR O ELIMINAR SESION
		// SE CAPTURA EVENTO
		var eventObj	= info.event;

		// SE OBTIENE INFORMACION DE SESION
		$.ajax({
			url : "{{ route('getSesionesTerapiaFamiliar') }}",
			data : { 
				nna_run 	: $('#nna_run').val(),
				tera_id 	: tera_id,
				ses_ptf_id	: eventObj.id,
				tipo_planificacion : tipo_planificacion
			},
			type : 'GET',
			dataType : 'json',
			success : function(jsonRequest){
				// HTML RUN
				html += '<label class="form-control" id="nna_run_formato">{{ $run_formateado }}</label>';

				// SE LIMPIA EL FORMULARIO
				limpiarFormularioPlanificadorSesiones(tipo_planificacion);

				// SE APLICA HTML EN FORMULARIO
				$("#run_nna_buscar").html(html);
				activacionBotonGuardarEliminar();
				
				// SE BUSCA NOMBRE Y RUN DEL NNA INDICE ASOCIADO A LA TERAPIA
				if (tipo_planificacion == 1){ // MENU
					let nombre = jsonRequest.sesiones[0].nombre;
					let run = formatearRun(jsonRequest.sesiones[0].per_run+jsonRequest.sesiones[0].per_dig);

					$("#nna_run_formato").text(run);
					$("#nna_nombre_completo").text(nombre);
					ocultarSegunTipoPlanificación(false);
				}

				// DESPLIEGUE DE LA INFORMACIÓN DE LA SESION
				$(jsonRequest.sesiones).each(function( index, element ) {

					if (validarFechaSesionTerapiaFamiliar(element.ses_ptf_fec.split(' ')[0])){
						activacionBotonGuardarEliminar(1, tera_id);
					
					}else{
						activacionBotonGuardarEliminar();
					
					}

					// Tipo Sesión
					var ptf_actividad	= $('#ptf_id').find('option[id="'+element.ptf_id+'"]').attr("data-id");
					$('#ptf_actividad').find('option[id="'+ptf_actividad+'"]').prop("selected", true);
					$('#ptf_actividad').attr('disabled', true);

					// Objetivo
					$('#ptf_id').find('option[id="'+element.ptf_id+'"]').prop("selected", true);
					$('#ptf_id').attr('disabled', true);

					// N° Sesión
					$('#ses_ptf_n_ses').val(element.ses_ptf_n_ses);
					$('#ses_ptf_n_ses').attr('disabled', true);

					// Hora Inicio
					$('#ses_ptf_hor_ini').val(element.ses_ptf_hor_ini);
					$('#ses_ptf_hor_ini').attr('disabled', true);

					// Hora Fin
					$('#ses_ptf_hor_fin').val(element.ses_ptf_hor_fin);
					$('#ses_ptf_hor_fin').attr('disabled', true);

					// Observaciones
					$('#ses_ptf_com').val(element.ses_ptf_com);
					$('#ses_ptf_com').attr('disabled', true);

					// SES_PTF_ID
					$('#ses_ptf_id').val(eventObj.id);

				});

				// SE DESPLIEGA FORMULARIO
				$('#planificacionSesionModal').modal('show');

				// SE DESBLOQUEA PANTALLA
				desbloquearPantalla();

			},
			error 	: function(jqXHR, textStatus, errorThrown){
				manejoPeticionesFailAjax(jqXHR, textStatus, errorThrown);
				
			},
		});
	}
}


/**
 * Functión que valida las fechas por creación/edición de sesiones de terapia familiar.
 */
function validarFechaSesionTerapiaFamiliar(fecha_evento){

	var d 		= new Date();
	var month 	= d.getMonth()+1;
	var day 	= d.getDate();
	var output 	= d.getFullYear() + '-' + (month<10 ? '0' : '') + month + '-' + (day<10 ? '0' : '') + day;
	//console.log(new Date(output).getTime() +' > '+ new Date(fecha_evento).getTime());
	if (new Date(output).getTime() > new Date(fecha_evento).getTime()){
		return false;
	}else{
		return true
	}
}


/**
 * Functión que valida los objetivos correspondiente a la actividad seleccionada.
 */
function filtroActividadObjetivo(){
	let actividad = $("#ptf_actividad option:selected").attr('id');

	$("#ptf_id > option").each(function(){
		if (actividad == $(this).attr('data-id')){
			$(this).show();
		
		}else{
			$(this).hide();
		
		}
	});

	let selected = $("#ptf_id [data-id='"+actividad+"']:first").attr('id');
	$('#ptf_id option#'+selected).prop('selected', true);

	establecerNumeroSesion();
}


/**
 * Functión que elimina las sesiones de terapia familiar registradas.
 */
function eliminarSesionesTerapiaFamiliar(tera_id){
	if (confirm("¿Desea eliminar esta sesión de terapia familiar?")) {

		$.ajax({
			url : "{{ route('eliminarSesionesTerapiaFamiliar') }}",
			data : { 
				// nna_run 	: $('#nna_run').val(),
				tera_id		: tera_id,
				ses_ptf_id	: $('#ses_ptf_id').val()
			},
			type : 'GET',
			dataType : 'json',
			success : function(jsonRequest) {
				$('#planificacionSesionModal').modal('hide');
				alert(jsonRequest.mensaje);
				getSesionesTerapiaFamiliar({{ $tipo_planificacion }});
			
			},
			error 	: function(jqXHR, textStatus, errorThrown){
				manejoPeticionesFailAjax(jqXHR, textStatus, errorThrown);
			
			}
		});
	}
}


/**
 * Functión que valida los datos ingresados en el modal de sesiones de terapia familiar.
 */
function validarModalSesionesTerapiaFamiliar(){

	var showFalse	= false;

	// N° Sesión
	// if ($('#ses_ptf_n_ses').val() == ''){
	// 	$('#ses_ptf_n_ses').css('border-color', 'red');
	// 	$('#msg_ses_ptf_n_ses').show();
	// 	showFalse	= true;
	// }else{
	// 	$('#ses_ptf_n_ses').css('border-color', '');
	// 	$('#msg_ses_ptf_n_ses').hide();
	// }

	// Hora inicio
	if ($('#ses_ptf_hor_ini').val() == ''){
		$('#ses_ptf_hor_ini').css('border-color', 'red');
		$('#msg_ses_ptf_hor_ini').show();
		showFalse	= true;
	}else{
		$('#ses_ptf_hor_ini').css('border-color', '');
		$('#msg_ses_ptf_hor_ini').hide();
	}

	// Hora fin
	if ($('#ses_ptf_hor_fin').val() == ''){
		$('#ses_ptf_hor_fin').css('border-color', 'red');
		$('#msg_ses_ptf_hor_fin').show();
		showFalse	= true;
	}else{
		$('#ses_ptf_hor_fin').css('border-color', '');
		$('#msg_ses_ptf_hor_fin').hide();
	}

	// Observaciones
	if ($('#ses_ptf_com').val() == ''){
		$('#ses_ptf_com').css('border-color', 'red');
		$('#msg_ses_ptf_com').show();
		showFalse	= true;
	}else{
		$('#ses_ptf_com').css('border-color', '');
		$('#msg_ses_ptf_com').hide();
	}

	if (showFalse){ return false; }

	return true;

}

/**
 * Functión que valida el run ingresado
 */
function validarRunPlanificadorSesiones(run){
	let data = new Object();
	data.run = run;

	let val_run = rutEsValido(run);
	if (!val_run){
		ocultarSegunTipoPlanificación(true);

		let mensaje = "RUN Incorrecto. Por favor verificar e intentar nuevamente";
		alert(mensaje); 

		return false;
	}

	bloquearPantalla();

	$.ajax({
			url : "{{ route('planificar.sesionesTerapiaFamiliar.validar') }}",
			data : data,
			type : 'GET',
			dataType : 'json'
	}).done(function(resp){
		desbloquearPantalla();

		if (resp.estado == 1){
			$('#nna_run').val(resp.run);
			$('#nna_nombre_completo').text(resp.nombre);

			ocultarSegunTipoPlanificación(false);
			activacionBotonGuardarEliminar(0, resp.tera_id);
		}else if(resp.estado == 0){
			ocultarSegunTipoPlanificación(true);
			activacionBotonGuardarEliminar();

			let mensaje = resp.mensaje;
			alert(mensaje); return false;
		}
  	}).fail(function(jqXHR, textStatus, errorThrown){
  		desbloquearPantalla();

  		manejoPeticionesFailAjax(jqXHR, textStatus, errorThrown);
  	})
}


/**
 * Functión que oculta parte del formulario
 */
function ocultarSegunTipoPlanificación(ocultar){
	if (ocultar){
		$(".ocultarPlanificacion").hide();
		
	}else if(!ocultar){
		$(".ocultarPlanificacion").show();

	}
}

/**
 * Functión que limpia el formulario
 */
function limpiarFormularioPlanificadorSesiones(tipo_planificacion){
	if (tipo_planificacion == 1) ocultarSegunTipoPlanificación(true);

	//$('#ptf_actividad option:selected').removeAttr('selected');
	//$('#ptf_id option:selected').removeAttr('selected');

	$('#ptf_actividad').attr('disabled', false);
	$('#ptf_id').attr('disabled', false);
	$('#ses_ptf_n_ses').attr('disabled', false);
	$('#ses_ptf_hor_ini').attr('disabled', false);
	$('#ses_ptf_hor_fin').attr('disabled', false);
	$('#ses_ptf_com').attr('disabled', false);

	$("#ptf_actividad").prop('selectedIndex', 0);
	$("#ptf_id").prop('selectedIndex', 0);
	$('#ses_ptf_n_ses').val('1');
	$('#ses_ptf_hor_ini').val('00:00');
	$('#ses_ptf_hor_fin').val('00:00');
	$('#ses_ptf_com').val('');
}

/**
 * Functión que activa los botones de accion del formulario
 */
function activacionBotonGuardarEliminar(opcion, tera_id = null){
	switch(opcion){
		case 0: //GUARDAR
			$("#modal_guardar").removeAttr("onclick");
			$("#modal_guardar").attr("onclick", "guardarSesionesTerapiaFamiliar("+tera_id+")");

			$('#modal_guardar').show();
			$('#modal_eliminar').hide();
		break;

		case 1: // ELIMINAR
			$("#modal_eliminar").removeAttr("onclick");
			$("#modal_eliminar").attr("onclick", "eliminarSesionesTerapiaFamiliar("+tera_id+")");

			$('#modal_eliminar').show();
			$('#modal_guardar').hide();
		break;

		default: // NINGUNO
			$('#modal_guardar').hide();
			$('#modal_eliminar').hide();
	}
}

function establecerNumeroSesion(){
	let numero 	= $("#ptf_id option:selected").attr("data-sesion");

	numero 		= numero.split('°');

	$("#ses_ptf_n_ses").val(numero[1]);
}
</script>
@endsection