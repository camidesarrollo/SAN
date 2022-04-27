<?php $list_modalidad_visita = Helper::listadoModalidadVisita(); ?>
<div id="formVisitasDiagnostico" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="formVisitasDiagnostico" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content p-4">
			<div class="card p-4 shadow-sm">
				<div class="row">
					<div class="col">
						<h5 class="modal-title" id="form_diag_visi_tit">Agregar Visita</h5>
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
					<hidden id="total_visitas_actuales" value=""></hidden>
					<hidden id="numero_visita" value=""></hidden>
					<!-- HIDDEN FORM -->
					
					<!--FECHA DE VISITA-->
					<div class="form-group">
						<label for="form_diag_visi_fec">Fecha</label>
						<div class="input-group date-pick" id="form_diag_visi_fec" data-target-input="nearest" style="width: 220px;">
							<input onkeypress='return caracteres_especiales_fecha(event)' type="text" class="form-control datetimepicker-input " data-target="#form_diag_visi_fec"/>
							<div class="input-group-append" data-target="#form_diag_visi_fec" data-toggle="datetimepicker">
								<div class="input-group-text"><i class="fa fa-calendar"></i></div>
							</div>
						</div>
						<p id="val_frm_dv_1" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar Fecha de Visita.</p>
						<p id="val_frm_dv_3" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* La fecha ingresada no puede ser mayor a la fecha actual.</p>
					</div>
					<!--FECHA DE VISITA-->

					<!--MODALIDAD-->
					<div class="form-group" id="contenedor_modalidad_visita">
						<label for="modalidad_visita">Modalidad:</label>
						<select name="modalidad_visita" id="modalidad_visita" class="form-control" >
							<option value="" selected disabled>Seleccione una modalidad</option>
								<?php foreach($list_modalidad_visita as $value){ ?>
									<option value="<?php echo $value->mod_visita_id; ?>">
										<?php echo $value->mod_visita_nombre; ?>
									</option>
								<?php } ?>
						</select>
						<p id="val_msg_modalidad_visita" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe escoger una modalidad.</p>
					</div>
					<!--MODALIDAD-->

					<!--DESCRIPCIÓN-->
					<div class="form-group">
						<label for="form_diag_visi_des">Descripción</label>
						<textarea maxlength="1000" onkeypress='return caracteres_especiales(event)' class="form-control " id="form_diag_visi_des" name="form_diag_visi_des" rows="4" onKeyUp="valTextCrearAlertaActividad()" onKeyDown="valTextCrearAlertaActividad()"></textarea>
						<p id="val_frm_dv_2" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar una descripción de la visita.</p>
						<div class="row">
                            <div class="col">
                                <h6><small class="form-text text-muted">Mínimo 3 y máximo 1000 caracteres.</small></h6>
                            </div>
                            <div class="col text-left">
                                <h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_1" style="color: #000000;">0</strong></small></h6>
                            </div>
                        </div>
						<!--<input required onkeypress="return soloLetras(event)" type="text" class="form-control" id="form_familiar_mat">-->
					</div>
					<!--DESCRIPCIÓN-->

					<div class="text-right">
						<button type="button" class="btn btn-primary btn-sm" id="btn_editar_guardar_visitas_diagnostico">Guardar</button>
						<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>