<div id="crearObjetivoModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="crearObjetivoModal" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content p-4">
			<div class="card p-4 shadow-sm">
				
				<div class="modal-header">
					<h5 class="modal-title" id="form_familiar_tit"><strong>Crear Objetivo</strong></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true" style="position: absolute; right: 5px; top: 5px; width: 23px; height: 23px; padding: 0; margin: 0;">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-row">
						<div class="form-group col-md-12">
							<label for="obj_nom_modal_principal">Objetivo:</label>
							<input maxlength="1000" onkeypress='return caracteres_especiales(event)' required type="text" name="obj_nom_modal_principal" id="obj_nom_modal_principal" class="form-control"  placeholder="Nombre del objetivo">
							<p id="val_frm_obj_nom_modal_principal" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar el nombre del objetivo.</p>
						</div>
					</div>
					
				</div>

				<div class="text-right">
					<button type="button" id="btn_guardar_objetivo" class="btn btn-success" onclick="guardarObjetivo();">Guardar</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				</div>

			</div>
		</div>
	</div>
</div>