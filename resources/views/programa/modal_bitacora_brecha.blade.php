<div id="ModalBitacoraBrecha" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="ModalBitacoraBrecha" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content p-4">
			<div class="modal-header">

				<h2 class="modal-title" id="form_familiar_tit">Bitácora Brecha</h2>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body">

					<div class="form-row">
						{{ csrf_field() }}
						
						<input type="hidden" name="id_brecha" id="id_brecha">
						
						<div class="form-group col-md-12">
							<label>Bitácora</label>
							<textarea rows="3" maxlength="2000" onkeypress='return caracteres_especiales(event)' class="form-control" name="bitacora" id="bitacora"></textarea>
						</div>

						<div class="form-group col-md-12">
							<button class="btn btn-primary btn-sm" onclick="grabarBrecha();">Grabar Bitácora</button>
						</div>



						<div class="form-group col-md-12">
							<table width="100%" class="table table-bordered table-hover table-striped" id="tabla_bitacora_brecha">
								<thead>
									<tr>
										<th>Coordinador</th> 
										<th>Fecha</th>
										<th>Comentario</th>
									</tr>
								</thead>
							</table>
						</div> 
				</div>
		</div>
	</div>
</div>
</div>

