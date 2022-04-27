<div id="msgCambioEstado" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content p-4">
			<div class="modal-header">
				<div style="margin: 0 auto;"><h5>Cambio de Estado Caso</h5></div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute; margin: 0; top: 5px; right: 33px;">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>	
			
			@php $list_rechazos = Helper::estadosRechazoCaso(); @endphp
			<div class="modal-body">
			<!-- INICIO DC -->
				<div class="form-group" id="contenedor_rechazo_estado_persona">
					<label for="rechazo_estado_persona">Motivo:</label>
					<select name="rechazo_estado_persona" id="rechazo_estado_persona" class="form-control" onchange="getDescr(this.value)" >
						<option value="">Seleccione una opción</option>
						
							@foreach($list_rechazos as $value)
								@if ($value->est_cas_id!=8 && $value->est_cas_id!=9 && $value->est_cas_id!=21)
								<option value="{{$value->est_cas_id}}">{{$value->est_cas_nom}}</option>
								@endif
							@endforeach
					</select>
					<p id="val_msg_rec" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe escoger una opción.</p>
					<!-- INICIO CZ SPRINT 61 -->
					<br>
				<div class="form-group">
						<label for="definicion_motivo">Definición Motivo:</label>
					<textarea id="definicion_motivo" class="form-control" disabled="disabled" rows="4" >Seleccione un motivo</textarea>
				</div>
					<!-- FIN CZ SPRINT 61 -->
				</div>
				<!-- FIN DC -->
				<div class="form-group" id="contenedor_comentario_estado">
					<label for="definicion_motivo">Comentario:</label>
					<textarea maxlength="255" onkeypress='return caracteres_especiales(event)' class="form-control" id="comentario_estado" 
					rows="4" onKeyDown="valTextAreaCambioEstadoRechazo()" onKeyUp="valTextAreaCambioEstadoRechazo()"></textarea>
					<div class="row">
						<div class="col">
							<h6><small class="form-text text-muted">Mínimo 3 y máximo 255 caracteres.</small></h6>
						</div>
						<div class="col text-left">
							<h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_cam_est" style="color: #000000;">0</strong></small></h6>
						</div>
					</div>
					<p id="val_msg_com" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe escribir un comentario mínimo de 3 caracteres.</p>
				</div>
				<div class="text-center" id="msg_cambioEstado_body" style="font-weight: 800; display: none;"></div>
			</div>
			<div class="modal-footer" style="background-color: white;">
				<button type="button" id="cambiar_estado" class="btn btn-primary" onclick="validarComentarioModalEstado();">Guardar</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
<script>
	//INICIO DC
	function getDescr(valor){
		bloquearPantalla(); 
		let data = new Object();
		data.valor = valor;
		data.perfil = {{session()->all()['perfil']}};
	    $.ajax({
			url: "{{ route('get.definicion') }}",
			type: "GET",
			data: data
		}).done(function(resp){
			var dato = JSON.parse(resp);
			$('#definicion_motivo').html(dato[0].cat_des_descripcion);
			desbloquearPantalla();
		}).fail(function(obj){
			console.log(obj); return false;
		});
	}
	//FIN DC
</script>