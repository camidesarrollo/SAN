<div id="msgConfirmacionDesestimacion" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content p-4">
			<div class="modal-header">
				<div style="margin: 0 auto;"><h5>Seguimiento de Desestimación por OPD</h5></div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute; margin: 0; top: 5px; right: 33px;">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<input type="hidden" name="caso_id_egreso" id="caso_id_egreso" value="">

			
			<div class="modal-body">

				<div class="container">
					<div class="row">
						<div class="col-lg-4">
							<label>Estado del Seguimiento:</label>
						</div>
	                    <div class="col-lg-8 mb-3">
	                    	<select class="form-control" id="estado_seguimiento" name="estado_seguimiento"></select>
	                    	<p id="val_msg_com_dest1" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe seleccionar estado del seguimiento.</p>
		                </div>   
					</div>

					<div class="row">
						<div class="col-lg-4">
							<label>Modalidad de Contacto:</label>
						</div>
	                    <div class="col-lg-8 mb-3">
	                    	<select class="form-control" id="modalidad_contacto" name="modalidad_contacto">
			                </select>
			                <p id="val_msg_com_dest2" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe seleccionar modalidad de contacto.</p>
		                </div>
					</div>

					<div class="row" id="seccion_programas_atencion" style="display: none;">
		                <div class="col-lg-4">
							<label>Programa de Atención:</label>
						</div>
	                    <div class="col-lg-8 mb-3">
	                    	<select class="form-control" id="prog_atencion" name="prog_atencion" disabled>
			                    <option value="">Seleccione</option>
			                         @foreach ($tipo_programa as $tip_pro)
			                         	<option value="{{$tip_pro->tip_pro_seg_cod}}">{{$tip_pro->tip_pro_seg_nom}}</option>
 									 @endforeach 
			                </select>
			                <p id="val_msg_com_dest3" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe seleccionar programa de atención.</p>
		                </div>
		                <div class="col-lg-4">
							<label>Nombre Proyecto:</label>
						</div>
	                    <div class="col-lg-8 mb-3">
	                    	<select class="form-control" id="nom_proyecto" name="nom_proyecto" disabled >
			                    <option value="">Seleccione Programa de Atención</option>
			                </select>
			                <p id="val_msg_com_dest4" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe seleccionar nombre de proyecto.</p>
		                </div>
		            </div>

					<div class="row">
						<div class="col-lg-4">
							<label>Fecha del Seguimiento:</label>
						</div>
						<div class="col-lg-8 mb-3">
							<div class="input-group date-pick" id="int_date_" data-target-input="nearest">
								<input onkeypress='return caracteres_especiales_fecha(event)' type="text" name="int_date" class="form-control datetimepicker-input "  data-target="#int_date_" id="int_date"  value="">
								
								<div class="input-group-append" data-target="#int_date_" data-toggle="datetimepicker">
									<div class="input-group-text"><i class="fa fa-calendar"></i></div>
								</div>
							</div>
						</div>	
					</div>

				
					<div class="form-group" id="contenedor_comentario_estado">
						<label for="comentario_estado_terapia">Observación:</label>
						<textarea onkeypress='return caracteres_especiales(event)' class="form-control " id="comentario_desestimacion" 
						rows="4" onKeyDown="valTextConfirmDesesCaso()" onKeyUp="valTextConfirmDesesCaso()"></textarea>
						<div class="row">
							<div class="col">
								<h6><small class"form-text text-muted">Mínimo 3 y máximo 255 caracteres.</small></h6>
							</div>
							<div class="col text-left">
								<h6><small class"form-text text-muted">N° de caracteres: <strong id="cant_carac_com_dest" style="color: #000000;">0</strong></small></h6>
							</div>
						</div>
						<p id="val_msg_com_dest" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe escribir un comentario mínimo de 3 caracteres.</p>
					</div>
				</div>	
			</div>

			<div class="modal-footer" style="background-color: white;">
				<button type="button" id="cambiar_estado" class="btn btn-primary" onclick="validarComentarioModalConfirmEstCaso();">Guardar</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
			</div>

		</div>
	</div>
</div>