<div id="objetivoModalEjecucionPaf" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="objetivoModalEjecucionPaf" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content p-4">
			<div class="modal-header">

				<h2 class="modal-title" id="form_familiar_tit">Objetivo</h2>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<input type="hidden" id="obj_id_ejecucion_paf">
			<input type="hidden" id="tar_id_ejecucion_paf">

			@php $grupoFam = Helper::get_grupoFamiliarGestorCaso($caso_id,$run); @endphp

			<div class="modal-body">

					<div class="form-row">
						{{ csrf_field() }}

						<div class="form-group col-md-12">
							<label>Objetivo</label>
							

							<input disabled onkeypress='return caracteres_especiales(event)' required type="text" name="obj_nom_ejecucion_paf" id="obj_nom_ejecucion_paf" class="form-control "  placeholder="Tarea"
							onBlur="guardarDescripcionObjetivo(document.getElementById('obj_id_ejecucion_paf'));"
							>


							<p id="val_frm_obj_nom_ejecucion_paf" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar el nombre del objetivo.</p>
						</div>

						<div class="form-group col-md-12">
							<h4>Tareas</h4>
							<table width="100%" class="table table-bordered table-hover table-striped" id="tabla_tareas_ejecucion_paf">
								<thead>
									<tr>
										<th>Id Tarea</th> 
										<th>Tarea</th> 
										<th>Plazo</th>
										<th>Observación</th>
										<th>Responsable</th>
										<th>Fecha</th>
										<th>Comentarios</th>
										<th>Acciones</th>
									</tr>
								</thead>
							</table>
						</div> 

						<div class="form-group col-md-12">
							<!--<button id="btn_agregar_tarea" type="button" class="btn btn-primary">Agregar Tarea</button>-->
							<button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
						</div> 


						<div id="formulario_tarea_ejecucion_paf" class="form-group col-md-12" style="display:none;">
						<div class="form-group col-md-12">
							<label>Tarea</label>
							<input disabled onkeypress='return caracteres_especiales(event)' required type="text" name="tar_descripcion_ejecucion_paf" id="tar_descripcion_ejecucion_paf" class="form-control "  placeholder="Tarea">
							<p id="val_frm_tar_descripcion_ejecucion_paf" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar la descripción.</p>
						</div>

						<div class="form-group col-md-12">
							<label>Plazo</label>
							<input disabled onkeypress='return event.charCode >= 48 && event.charCode <= 57' required type="text" name="tar_plazo_ejecucion_paf" id="tar_plazo_ejecucion_paf" class="form-control "  placeholder="Plazo">
							<p id="val_frm_tar_plazo_ejecucion_paf" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar el plazo.</p>
						</div>

						<div class="form-group col-md-12">
							<label>Responsable</label>
							<select disabled class="form-control" name="responsable_ejecucion_paf" id="responsable_ejecucion_paf">
								<option value="" >Seleccione Responsable</option>
								@foreach($grupoFam as $value)
								    <option value="{{$value->gru_fam_id}}">{{$value->gru_fam_nom}}</option>
								@endforeach
							</select>
							<p id="val_frm_tar_responsable_ejecucion_paf" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe seleccionar el responsable.</p>
						</div>

						<div class="form-group col-md-12">
							<label>Observación</label>
					      	<textarea disabled maxlength="1000" onkeypress='return caracteres_especiales(event)'  onKeyUp="valTextAreaobservacion()" onKeyDown="valTextAreaobservacion()" class="form-control " rows="7" id="tar_observacion_ejecucion_paf"></textarea>
					      	<div class="row">
								<div class="col">
									<h6><small class"form-text text-muted">Mínimo 3 y máximo 1000 caracteres.</small></h6>
								</div>
								<div class="col text-left">
									<h6><small class"form-text text-muted">N° de caracteres: <strong id="cant_carac_tar_observacion_ejecucion_paf" style="color: #000000;">0</strong></small></h6>
								</div>
							</div>


					    </div>


						<!--FECHA-->
						<div class="form-group col-md-12">
							<label for="fecha_ejecucion_tarea">Fecha</label>
							<div class="input-group date-pick" id="fecha_ejecucion_tarea" name="fecha_ejecucion_tarea" data-target-input="nearest" style="width: 220px;">
								<input id="fecha_ejecucion_tarea_input" name="fecha_ejecucion_tarea_input" onkeypress='return caracteres_especiales_fecha(event)' type="text" class="form-control datetimepicker-input " data-target="#fecha_ejecucion_tarea"/>
								<div class="input-group-append" data-target="#fecha_ejecucion_tarea" data-toggle="datetimepicker">
									<div class="input-group-text"><i class="fa fa-calendar"></i></div>
								</div>
							</div>
							<p id="val_fecha_ejecucion_tarea_1" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar Fecha de Tarea.</p>
							<p id="val_fecha_ejecucion_tarea_3" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* La fecha ingresada no puede ser mayor a la fecha actual.</p>
						</div>
						<!--FECHA-->

						<div class="form-group col-md-12">
							<label>Comentarios</label>
					      	<textarea  maxlength="1000" onkeypress='return caracteres_especiales(event)'  onKeyUp="valTextAreacomentariotarea()" onKeyDown="valTextAreacomentariotarea()" class="form-control " rows="7" id="tar_comentario_ejecucion_paf"></textarea>
					      	<div class="row">
								<div class="col">
									<h6><small class="form-text text-muted">Mínimo 3 y máximo 1000 caracteres.</small></h6>
								</div>
								<div class="col text-left">
									<h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_tar_comentario_ejecucion_paf" style="color: #000000;">0</strong></small></h6>
								</div>
							</div>


					    </div>

						<div class="form-group col-md-12 text-left">
							<button type="button" id="btn_guardar_tarea" class="btn btn-primary" onclick="actualizarTarea();">Guardar Tarea</button>

					</div>
					</div>

			</div>
		</div>
	</div>
</div>