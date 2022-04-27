<?php $listadoModalidadSeguimiento = Helper::listadoModalidadSeguimiento(); ?>
<div id="formDetalleSeguimiento" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="formDetalleSeguimiento" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content p-4">
			<div class="card p-4 shadow-sm">
				<div class="row">
					<div class="col">
						<h5 class="modal-title" id="form_diag_visi_tit">Agregar Seguimiento</h5>
					</div>
					<div class="col">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				</div>
				<hr>
				
				<form>
					<!-- HIDDEN FORM -->
					<input type="hidden" id="ptf_seg_id" name="ptf_seg_id">
					<!-- HIDDEN FORM -->
					
					<!--FECHA DE VISITA-->
					<div class="form-group">
						<label for="ptf_seg_fecha">Fecha</label>
						<div class="input-group date-pick" id="ptf_seg_fecha" data-target-input="nearest" style="width: 220px;">
							<input onkeypress='return caracteres_especiales_fecha(event)' type="text" class="form-control datetimepicker-input " data-target="#ptf_seg_fecha"/>
							<div class="input-group-append" data-target="#ptf_seg_fecha" data-toggle="datetimepicker">
								<div class="input-group-text"><i class="fa fa-calendar"></i></div>
							</div>
						</div>
						<p id="val_frm_dv_1" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar Fecha de Visita.</p>
						<!--<p id="val_frm_dv_3" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* La fecha ingresada no puede ser mayor a la fecha actual.</p>-->
					</div>
					<!--FECHA DE VISITA-->

					<!--MODALIDAD-->
					<div class="form-group" id="contenedor_modalidad_visita">
						<label for="ptf_mod_id">Modalidad:</label>
						<select name="ptf_mod_id" id="ptf_mod_id" class="form-control" >
							<option value="" selected disabled>Seleccione una modalidad</option>
								<?php foreach($listadoModalidadSeguimiento as $value){ ?>
									<option value="<?php echo $value->ptf_mod_id; ?>">
										<?php echo $value->ptf_mod_nombre; ?>
									</option>
								<?php } ?>
						</select>
						<p id="val_msg_ptf_mod_id" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe escoger una modalidad.</p>
					</div>
					<!--MODALIDAD-->

					<!--ptf_seg_recursos-->
					<div class="form-group">
						<label for="ptf_seg_recursos">Recursos</label>
						<textarea maxlength="1000" onKeyUp="valTextAreaptf_seg_recursos()" onKeyDown="valTextAreaptf_seg_recursos()" onkeypress='return caracteres_especiales(event)' class="form-control " id="ptf_seg_recursos" rows="4"></textarea>

						<div class="row">
							<div class="col-md-12 col-lg-6">
								<h6><small class="form-text text-muted">Mínimo 3 y máximo 1000 caracteres.</small></h6>
							</div>
							<div class="col-md-12 col-lg-6">
								<h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_seg_recursos" style="color: #000000;">0</strong></small></h6>
							</div>
						</div>

						<p id="val_frm_ptf_seg_recursos" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar los recursos.</p>
					</div>
					<!--ptf_seg_recursos-->

					<!--ptf_seg_redes-->
					<div class="form-group">
						<label for="ptf_seg_redes">Redes</label>
						<textarea maxlength="1000" onKeyUp="valTextAreaptf_seg_redes()" onKeyDown="valTextAreaptf_seg_redes()" onkeypress='return caracteres_especiales(event)' class="form-control " id="ptf_seg_redes" rows="4"></textarea>

						<div class="row">
							<div class="col-md-12 col-lg-6">
								<h6><small class="form-text text-muted">Mínimo 3 y máximo 1000 caracteres.</small></h6>
							</div>
							<div class="col-md-12 col-lg-6">
								<h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_seg_redes" style="color: #000000;">0</strong></small></h6>
							</div>
						</div>

						<p id="val_frm_ptf_seg_redes" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar las redes.</p>
					</div>
					<!--ptf_seg_redes-->

					<!--ptf_seg_riesgo-->
					<div class="form-group">
						<label for="ptf_seg_riesgo">Riesgo</label>
						<textarea maxlength="1000" onKeyUp="valTextAreaptf_seg_riesgo()" onKeyDown="valTextAreaptf_seg_riesgo()" onkeypress='return caracteres_especiales(event)' class="form-control " id="ptf_seg_riesgo" rows="4"></textarea>

						<div class="row">
							<div class="col-md-12 col-lg-6">
								<h6><small class="form-text text-muted">Mínimo 3 y máximo 1000 caracteres.</small></h6>
							</div>
							<div class="col-md-12 col-lg-6">
								<h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_seg_riesgo" style="color: #000000;">0</strong></small></h6>
							</div>
						</div>

						<p id="val_frm_ptf_seg_riesgo" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar los riesgos.</p>
					</div>
					<!--ptf_seg_riesgo-->

					<!--ptf_seg_observacion-->
					<div class="form-group">
						<label for="ptf_seg_observacion">Observación</label>
						<textarea maxlength="1000" onKeyUp="valTextAreaptf_seg_observacion()" onKeyDown="valTextAreaptf_seg_observacion()" onkeypress='return caracteres_especiales(event)' class="form-control " id="ptf_seg_observacion" rows="4"></textarea>

						<div class="row">
							<div class="col-md-12 col-lg-6">
								<h6><small class="form-text text-muted">Mínimo 3 y máximo 1000 caracteres.</small></h6>
							</div>
							<div class="col-md-12 col-lg-6">
								<h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_seg_observacion" style="color: #000000;">0</strong></small></h6>
							</div>
						</div>

						<p id="val_frm_ptf_seg_observacion" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar la observación.</p>
					</div>
					<!--ptf_seg_observacion-->

					<div class="text-right">
						<button type="button" class="btn btn-primary btn-sm" id="btn_editar_guardar_detalle_seguimiento">Guardar</button>
						<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>