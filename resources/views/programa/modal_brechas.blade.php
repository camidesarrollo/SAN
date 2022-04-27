<div id="ModalBrechas" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="ModalBrechas" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content p-4">
			<div class="modal-header">

				<h2 class="modal-title" id="form_familiar_tit">Detalle Brecha</h2>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body">

					<div class="form-row">
						{{ csrf_field() }}
						<div class="form-group col-md-12">
							<table width="100%" class="table table-bordered table-hover table-striped" id="tabla_detalle_brechas">
								<thead>
									<tr>
										
										<th style="width: 180px;">Gestor</th> 
										<th style="width: 230px;">Rut Integrante</th>
										<th style="width: 140px;">Nombre Integrante</th>
										<th style="width: 160px;">Alerta Territorial</th>
										<th style="width: 226px;">Comentario</th>
										<th>Acciones</th>
										<th>RUTSINFORMATO</th>
									</tr>
								</thead>
							</table>
						</div> 
				</div>
		</div>
	</div>
</div>
</div>

