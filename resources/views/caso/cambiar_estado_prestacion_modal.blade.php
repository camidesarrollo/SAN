<div id="cambiarEstadoPrestacion" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="cambiarEstadoPrestacionLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="p-4">
			<div class="modal-header">
		        <h5 class="modal-title text-center" id="cambiarEstadoPrestacionLabel" style="width: 100%;">Cambiar Estado Derivación</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
	      	</div>
	      	<div class="modal-body">
	      		<input type="hidden" name="id_derivacion_asignada" id="id_derivacion_asignada" value="">

       			<div class="form-group">
					<label for="motivo_cambio_estado_derivacion">Motivo:</label>
					<select name="motivo_cambio_estado_derivacion" id="motivo_cambio_estado_derivacion" class="form-control" >
						<option value="">Seleccione una opción</option>
						@foreach($estados_programa AS $value)
							<option value="{{ $value->est_prog_id }}">{{ $value->est_prog_nom }}</option>
						@endforeach
					</select>
					<p id="val_motivo_cambio_estado_derivacion" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe escoger una opción.</p>
				</div>

				<div class="form-group">
					<label for="comentario_cambio_estado_derivacion">Comentario:</label>
					<textarea maxlength="2000" onkeypress='return caracteres_especiales(event)' class="form-control" name="comentario_cambio_estado_derivacion" id="comentario_cambio_estado_derivacion" 
					rows="4" onKeyDown="valTextAreaCambioEstadoDerivacion();" onKeyUp="valTextAreaCambioEstadoDerivacion();"></textarea>
					<div class="row">
						<div class="col">
							<h6><small class"form-text text-muted">Mínimo 3 y máximo 2000 caracteres.</small></h6>
						</div>
						<div class="col text-left">
							<h6><small class"form-text text-muted">N° de caracteres: <strong id="cantidad_caracteres_comentario" style="color: #000000;">0</strong></small></h6>
						</div>
					</div>
					<p id="val_comentario_cambio_estado_derivacion" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe escribir un comentario mínimo de 3 caracteres.</p>
				</div>
      		</div>
      		<div class="modal-footer" style="background-color: unset;">
		        <button type="button" class="btn btn-primary" onclick="cambiarEstadoDerivacion();">Guardar</button>
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      		</div>
      		</div>

		</div>
	</div>
</div>