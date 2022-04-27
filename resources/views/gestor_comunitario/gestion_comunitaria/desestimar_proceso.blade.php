

<div class="card m-0 p-4">
    <div class="row">
        <div class="col-3">
		<!-- inicio CH -->
        	<h5>Nombre del proceso: {{ strtoupper($nombre_proceso).' '.$año_proceso }}</h5>
		<!-- Fin CH -->
        </div>
        <div class="col-3">
        	<small><i class="far fa-calendar-alt mr-1"></i><b>Fecha:</b><br/> {{$fecha}}</small>
        </div>
        <div class="col-3">
        </div>
        <div class="col-3 text-right">
        	@foreach ($acciones as $accion)
              @if ($accion->cod_accion == "GCM07")
            	@if(($est_pro_id != 3) && ($est_pro_id !=4))            
	                <button id="btn_desestimar" type="button" onclick="{{ $accion->ruta }}" class="btn btn-danger btn-sm btn-block btnRechEst" data-toggle="modal" data-target="#frmDesestimarProceso"><i class="{{ $accion->clase }}"></i>  <b>{{ $accion->nombre }}</b></button>
            	@endif
              @endif
            @endforeach
        </div>
    </div>
</div>

<div id="frmDesestimarProceso" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content p-4">
			<div class="modal-header">
				<div style="margin: 0 auto;"><h5>Desestimar Proceso Anual</h5></div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute; margin: 0; top: 5px; right: 33px;">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			@php $list_rechazos = Helper::estadosRechazoProceso(); @endphp
			<div class="modal-body">
				<div class="form-group" id="contenedor_desestimar_proceso">
					<label for="desestimar_proceso">Motivo:</label>
					<select name="desestimar_proceso" id="desestimar_proceso" class="form-control" >
						<option value="">Seleccione una opción</option>
						
							@foreach($list_rechazos as $value)
								<option value="{{$value->est_pro_id}}">{{$value->est_pro_nom}}</option>
							@endforeach
					</select>
					<p id="val_msg_rec" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe escoger una opción.</p>
				</div>
				<div class="form-group" id="contenedor_comentario_estado">
					<label for="comentario_estado">Comentario:</label>
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
				<button type="button" id="cambiar_estado" class="btn btn-primary" onclick="desestimarProceso()">Guardar</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
