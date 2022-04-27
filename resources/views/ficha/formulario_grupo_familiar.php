<div id="formGrupoFamiliar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="formGrupoFamiliar" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content p-4">
			<div class="card p-4 shadow-sm">
				<h5 class="modal-title" id="form_familiar_tit">Agregar Integrante Familiar</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" style="position: absolute; right: 5px; top: 5px; width: 23px; height: 23px; padding: 0; margin: 0;">&times;</span>
				</button>

				<?php $listaParentesco = Helper::get_parentesco(); ?>


				<form action="">
					<!-- HIDDEN FORM -->
					<hidden id="id_familiar" value=""></hidden>
					<!-- HIDDEN FORM -->

					<!--<div class="row">
						<div class="col-auto">
							<label for="form_familiar_run">Run</label>
							<input type="text" class="form-control input_rut" id="form_familiar_run" onchange="$(this).val(formatearRun(this.value));">
							<p id="val_frm_gfam_1" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar el run.</p>
						</div>
				
						<div class="col-auto">
							<label for="form_familiar_eda">Edad</label>
							<input onkeypress='return event.charCode >= 48 && event.charCode <= 57' type="number" class="form-control" id="form_familiar_eda">
							<p id="val_frm_gfam_2" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar la edad.</p>
						</div>
					</div>-->
					<br>
					<!-- INICIO CZ SPRINT 58 -->
					<!--RUN - CHECKBOX SIN RUN-->
					<div class="row" style="margin-bottom: 16px;">
						<div class="col-auto">
							<label for="form_familiar_run">Run</label>
							<input type="text" class="form-control input_rut " id="form_familiar_run">
							<p id="val_frm_gfam_1" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;"></p>
						</div>
						<div class="col-auto" style="width: 50%; align-items: center; padding: 24px;" id="div_form_familiar_chk_sin_run">
						<input type="checkbox" id="form_familiar_chk_sin_run" ><label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Sin Run</b></label>
						</div>
					</div>
					<!-- FIN CZ SPRINT 58 -->
					<!--RUN - FECHA NACIMIENTO-->
						<div class="form-group">
							<label for="form_familiar_nac">Fecha de Nacimiento</label>
							<div class="input-group date-pick" id="form_familiar_nac" data-target-input="nearest">
								<input onkeypress='return caracteres_especiales_fecha(event)' type="text" class="form-control datetimepicker-input " data-target="#form_familiar_nac"/>
								<div class="input-group-append" data-target="#form_familiar_nac" data-toggle="datetimepicker">
									<div class="input-group-text"><i class="fa fa-calendar"></i></div>
								</div>
							</div>
							<p id="val_frm_gfam_2" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar Fecha de Nacimiento.</p>
						</div>
					<!--NOMBRE-->
					<div class="form-group">
						<label for="form_familiar_nom" >Nombre</label>
						<input maxlength="50" onkeypress="return soloLetras(event)" type="text" class="form-control " id="form_familiar_nom">
						 <p id="val_frm_gfam_3" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar Nombre.</p>
					</div>
					<!--NOMBRE-->

					<!--APELLIDO PATERNO-->
					<div class="form-group">

						<label for="form_familiar_pat">Primer Apellido</label>
						
						<input maxlength="50" onkeypress="return soloLetras(event)" type="text" class="form-control " id="form_familiar_pat">
						<p id="val_frm_gfam_4" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar Primer Apellido.</p>
					</div>
					<!--APELLIDO PATERNO-->

					<!--APELLIDO MATERNO-->
					<div class="form-group">
						<label for="form_familiar_mat">Segundo Apellido</label>
						<input maxlength="50" onkeypress="return soloLetras(event)" type="text" class="form-control " id="form_familiar_mat">
						<p id="val_frm_gfam_5" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar Segundo Apellido.</p>
					</div>
					<!--APELLIDO MATERNO-->

					<!--SEXO-->
					<div class="form-group">
						<label for="form_familiar_sex">Sexo</label>
						<select class="form-control"  name="form_familiar_sex" id="form_familiar_sex">
							<option value="">Seleccione una opción</option>
							<option value="1">Masculino</option>
							<option value="2">Femenino</option>
						</select>
						<p id="val_frm_gfam_6" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar Sexo.</p>
					</div>
					<!--SEXO-->

					<!--PARENTESCO-->
					<div class="form-group">
						<label for="form_familiar_par">Parentesco</label>
						<select class="form-control"  name="form_familiar_par" id="form_familiar_par" onchange="validarParentescoIntegrante($('#cas_id').val(), this);habilitarOtrosFamiliares(this);">
							<option value="">Seleccione una opción</option>

							<?php foreach ($listaParentesco as $parentesco) { if($parentesco->par_gru_fam_id <= 13 ){ ?>
								<option value="<?php echo $parentesco->par_gru_fam_id; ?>"><?php echo $parentesco->par_gru_fam_nom; ?></option>
							<?php }} ?>

						</select>
						<p id="val_frm_gfam_7" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar Parentesco.</p>
					</div>
					<!--PARENTESCO-->

					<!--OTROS FAMILIAR-->
					<div id="inp_otro_par" class="form-group" style="display: none">
						<label for="form_otro_par">Otro Familiar</label>
						<select class="form-control"  name="form_otro_par" id="form_otro_par" onchange="">
							<option value="">Seleccione una opción</option>

							<?php foreach ($listaParentesco as $parentesco) { if($parentesco->par_gru_fam_id > 13 ){ ?>
								<option value="<?php echo $parentesco->par_gru_fam_id; ?>"><?php echo $parentesco->par_gru_fam_nom; ?></option>
							<?php }} ?>

						</select>
						<p id="val_frm_gfam_10" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar Parentesco.</p>
					</div>
					<!--OTROS FAMILIAR-->

					<!--APELLIDO EMAIL-->
					<div class="form-group">
						<label for="form_familiar_email">Email:</label>
						<input type="email"  maxlength="60" class="form-control " id="form_familiar_email"/>
						<p id="val_frm_gfam_8" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* El email NO es correcto.</p>
					</div>
					<!--APELLIDO EMAIL-->

					<!--APELLIDO TELEFONO-->
					<div class="form-group">
						<label for="form_familiar_fono">Telefono:</label>
						<input maxlength="12"onkeyup="if (!/^([0-9])*$/.test(this.value)) this.value = this.value.replace(/\D/g,'')" type="text" class="form-control " id="form_familiar_fono">
						<p id="val_frm_gfam_9" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar Telefono.</p>
					</div>
					<!--APELLIDO TELEFONO-->

					<!--ESTADO ACTUAL PARENTESCO-->
					<div class="form-group">
						<label for="">Estado Actual Composición Familiar</label><br>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" id="form_familiar_vig" name="form_familiar_estado" class="custom-control-input" value="1" checked>
							<label class="custom-control-label" for="form_familiar_vig">Vigente</label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" id="form_familiar_no_vig" name="form_familiar_estado" class="custom-control-input" value="0">
							<label class="custom-control-label" for="form_familiar_no_vig">No vigente</label>
						</div>
					</div>
					<!--ESTADO ACTUAL PARENTESCO-->

					<div class="text-right">
						<button type="button" class="btn btn-primary btn-sm" id="btn_editar_guardar_integrante" onclick="accionesFamilia(2);">Guardar</button>
						<button type="button" class="btn btn-default btn-sm" data-dismiss="modal" onclick="$('#diagnosticoModal').modal('show'); $('#btn_despliegue_grupo_familiar').attr('aria-expanded', true);">Cerrar</button>
					</div>
					
				</form>
				
			</div>
		</div>
	</div>
</div>
<!-- INICIO CZ SPRINT 58 -->
<script>

$('#form_familiar_chk_sin_run').change(function(){

if($('#form_familiar_chk_sin_run').prop('checked')){
  limpiarFormularioFamiliar();
  $("#form_familiar_run").prop('disabled',true);
}else{
  limpiarFormularioFamiliar();
  $("#form_familiar_run").prop('disabled',false);
}
});

</script>
<!-- FIN CZ SPRINT 58 -->