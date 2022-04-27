<style type="text/css">
.padre {
  /*IMPORTANTE*/
  display: flex;
  justify-content: center;
  align-items: center;
}

.hijo {
  width: 50%;
  justify-content: center !important;
} 
</style>
		<div class="container-fluid">

				<div class="row">
					<div class="col">
						@if (count($titulos_modal) >= 1)
							<h5 class="modal-title" id="title_ejecucion" data-id-est="{{ $titulos_modal[2]->id_est }}">
								<b><i class="far fa-list-alt"></i> {{ $titulos_modal[5]->titulo }}</b>
							</h5>
						@else
							<h5 class="modal-title" id="title_ejecucion" data-id-est=""></h5>
						@endif
					</div>
					@if ($modo_visualizacion == 'edicion')
						<div class="col text-right">
							<button type="button" class="btn btn-danger btn-sm btnRechEst" data-dismiss="modal"
									@if($est_cas_fin)
										disabled 
									@else 
										onclick="comentarioEstado({{ $caso_id }});" 
									@endif >
									Desestimar Caso
							</button>
						</div>
					@endif
				</div>

				<hr>


			<div class="card shadow-sm">

				<div class="card-header p-3">
					<div class="row">
						<div class="col">
							<h5 class="p-2 mb-0"><button type="button" class="btn btn-info" data-container="body" data-toggle="popover" data-placement="top" data-content="Registre la información necesaría para hacer un prediagnóstico exitoso"><i class="fa fa-info"></i></button>&nbsp;Pre Diagnóstico
							</h5>
						</div>
					</div>
			    </div>


				  <div class="card-body">
					<div class="container">

					@if ($modo_visualizacion == 'visualizacion')
					 <div class="row">
					 	<div class="col-md-12 col-lg-6">
					 		<div class="col-12 text-left">
						 		<h6>
							      	Información que es necesario verificar con la familia (ej. Composición familiar actual).
								</h6>
							</div>
							<div class="col-12 text-center">
								<label class="font-weight-bold">{{$prediagnostico_fec_1}}</label>
							</div>
					 	</div>
					 	<div class="col-md-12 col-lg-6" style="word-break: break-all;">
					 		<label class="font-weight-bold">{{$prediagnostico_des_1}}</label>
					 	</div>
					 </div>

					@elseif ($modo_visualizacion == 'edicion')
					  <div class="row">
					  	<!-- FECHA 1 -->
					    <div class="col-md-12 col-lg-6" style="display: flex; align-items: center;">
						    <div>	      
									<h6>
						      			Información que es necesario verificar con la familia (ej. Composición familiar actual).
									</h6>
									<div style="max-width: 250px; padding: 20px 0px 20px 0px;">
										<div class="input-group date-pick" id="fecha_1" data-target-input="nearest">
										<input onkeypress='return caracteres_especiales_fecha(event)' type="text" name="hora_ini" class="form-control datetimepicker-input "  data-target="#fecha_1" id="fecha_prediagnostico_1" onBlur="guardarFechaPreDiagnostico({{ $caso_id }}, 'fecha_prediagnostico_1',$(this).val());" value="{{$prediagnostico_fec_1}}" @if (config('constantes.en_prediagnostico')!= $estado_actual_caso) disabled @endif>
										<div class="input-group-append" data-target="#fecha_1" data-toggle="datetimepicker">
											<div class="input-group-text"><i class="fa fa-calendar"></i></div>
										</div>
									</div>
									<p id="val_obs_pre_fec_1" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar una fecha valida.</p>
						    		</div>
						    </div>
					    </div>
					    <!-- FECHA 1 -->

					    <!-- COMENTARIO 1 -->
					    <div class="col-md-12 col-lg-6">
					      	<textarea maxlength="1000" onkeypress='return caracteres_especiales(event)' onpaste="onpasteval(1);" onKeyUp="valTextAreaprediagnostico_observacion1()" onKeyDown="valTextAreaprediagnostico_observacion1()" class="form-control " rows="7" id="obs_prediagnostico_1" onBlur="guardarObsPreDiagnostico({{ $caso_id }}, 'obs_prediagnostico_1',$(this).val());" @if (config('constantes.en_prediagnostico')!= $estado_actual_caso) disabled @endif>{{$prediagnostico_des_1}}</textarea>
							<div class="row">
								<div class="col-md-12 col-lg-6">
									<h6><small class"form-text text-muted">Mínimo 3 y máximo 1000 caracteres.</small></h6>
								</div>
								<div class="col-md-12 col-lg-6">
									<h6><small class"form-text text-muted">N° de caracteres: <strong id="cant_carac_1" style="color: #000000;">0</strong></small></h6>
								</div>
							</div>

					      	<p id="val_obs_pre_1" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar un comentario valido.</p>
					    </div>
					    <!-- COMENTARIO 1 -->
					  </div>
					@endif
					<hr>

					@if ($modo_visualizacion == 'visualizacion')
						<div class="row">
							<div class="col-md-12 col-lg-6">
								<div class="col-12 text-left">
									<h6>
							      		Información obtenida a través de las coordinaciones con actores relevantes que se vinculan con el NNA y su familia.
									</h6>
								</div>
								<div class="col-12 text-center">
									<label class="font-weight-bold">{{$prediagnostico_fec_2}}</label>
								</div>
							</div>
							<div class="col-md-12 col-lg-6" style="word-break: break-all;">
								<label class="font-weight-bold">{{$prediagnostico_des_2}}</label>
							</div>
						</div>

					@elseif ($modo_visualizacion == 'edicion')
					  <div class="row">
					  	<!-- FECHA 2 -->
					    <div class="col-md-12 col-lg-6" style="display: flex; align-items: center;">
						    <div>	      
									<h6>
						      			Información obtenida a través de las coordinaciones con actores relevantes que se vinculan con el NNA y su familia.
									</h6>
									<div style="max-width: 250px; padding: 20px 0px 20px 0px;">
							      	<div class="input-group date-pick" id="fecha_2" data-target-input="nearest">
										<input onkeypress='return caracteres_especiales_fecha(event)' type="text" name="hora_ini" class="form-control datetimepicker-input "  data-target="#fecha_2" id="fecha_prediagnostico_2" onBlur="guardarFechaPreDiagnostico({{ $caso_id }}, 'fecha_prediagnostico_2',$(this).val());" value="{{$prediagnostico_fec_2}}" @if (config('constantes.en_prediagnostico')!= $estado_actual_caso) disabled @endif>
										<div class="input-group-append" data-target="#fecha_2" data-toggle="datetimepicker">
											<div class="input-group-text"><i class="fa fa-calendar"></i></div>
										</div>
									</div>
									<p id="val_obs_pre_fec_2" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar una fecha valida.</p>
						    		</div>
						    </div>
					    </div>
					    <!-- FECHA 2 -->

					    <!-- COMENTARIO 2 -->
					    <div class="col-md-12 col-lg-6">
					      	<textarea maxlength="1000" onkeypress='return caracteres_especiales(event)' onpaste="onpasteval(2);" onKeyUp="valTextAreaprediagnostico_observacion2()" onKeyDown="valTextAreaprediagnostico_observacion2()" class="form-control " rows="7" id="obs_prediagnostico_2" onBlur="guardarObsPreDiagnostico({{ $caso_id }}, 'obs_prediagnostico_2',$(this).val());" @if (config('constantes.en_prediagnostico')!= $estado_actual_caso) disabled @endif>{{$prediagnostico_des_2}}</textarea>
							<div class="row">
								<div class="col-md-12 col-lg-6">
									<h6><small class"form-text text-muted">Mínimo 3 y máximo 1000 caracteres.</small></h6>
								</div>
								<div class="col-md-12 col-lg-6">
									<h6><small class"form-text text-muted">N° de caracteres: <strong id="cant_carac_2" style="color: #000000;">0</strong></small></h6>
								</div>
							</div>

					      	<p id="val_obs_pre_2" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar un comentario valido.</p>
					    </div>
					    <!-- COMENTARIO 2 -->
					  </div>
					@endif  
					<hr>

					@if ($modo_visualizacion == 'visualizacion')
					  <div class="row">
						<div class="col-md-12 col-lg-6">
							<div class="col-12 text-left">
								<h6>
							      	Beneficios para los que uno o más miembros de la familia son elegibles y no acceden a ellos.
								</h6>
							</div>
							<div class="col-12 text-center">
								<label class="font-weight-bold">{{$prediagnostico_fec_3}}</label>
							</div>
						</div>
						<div class="col-md-12 col-lg-6" style="word-break: break-all;">
							<label class="font-weight-bold">{{$prediagnostico_des_3}}</label>
						</div>
					  </div>

					@elseif ($modo_visualizacion == 'edicion')
					  <div class="row">
					  	<!-- FECHA 3 -->
					    <div class="col-md-12 col-lg-6" style="display: flex; align-items: center;">
						    <div>	      
									<h6>
						      			Beneficios para los que uno o más miembros de la familia son elegibles y no acceden a ellos.
									</h6>
									<div style="max-width: 250px; padding: 20px 0px 20px 0px;">
									<div class="input-group date-pick" id="fecha_3" data-target-input="nearest">
										<input onkeypress='return caracteres_especiales_fecha(event)' type="text" name="hora_ini" class="form-control datetimepicker-input "  data-target="#fecha_3" id="fecha_prediagnostico_3" onBlur="guardarFechaPreDiagnostico({{ $caso_id }}, 'fecha_prediagnostico_3',$(this).val());" value="{{$prediagnostico_fec_3}}"  @if (config('constantes.en_prediagnostico')!= $estado_actual_caso) disabled @endif>
										<div class="input-group-append" data-target="#fecha_3" data-toggle="datetimepicker">
											<div class="input-group-text"><i class="fa fa-calendar"></i></div>
										</div>
									</div>
									<p id="val_obs_pre_fec_3" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar una fecha valida.</p>
						    		</div>
						    </div>
					    </div>
					    <!-- FECHA 3 -->

					    <!-- COMENTARIO 3 -->
					    <div class="col-md-12 col-lg-6">
					      	<textarea maxlength="1000" onkeypress='return caracteres_especiales(event)' onpaste="onpasteval(3);" onKeyUp="valTextAreaprediagnostico_observacion3()" onKeyDown="valTextAreaprediagnostico_observacion3()" class="form-control " rows="7" id="obs_prediagnostico_3" onBlur="guardarObsPreDiagnostico({{ $caso_id }}, 'obs_prediagnostico_3',$(this).val());" @if (config('constantes.en_prediagnostico')!= $estado_actual_caso) disabled @endif>{{$prediagnostico_des_3}}</textarea>
							<div class="row">
								<div class="col-md-12 col-lg-6">
									<h6><small class"form-text text-muted">Mínimo 3 y máximo 1000 caracteres.</small></h6>
								</div>
								<div class="col-md-12 col-lg-6">
									<h6><small class"form-text text-muted">N° de caracteres: <strong id="cant_carac_3" style="color: #000000;">0</strong></small></h6>
								</div>
							</div>

					      	<p id="val_obs_pre_3" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar un comentario valido.</p>
					    </div>
					    <!-- COMENTARIO 3 -->
					  </div>
					@endif  
					<hr>

					@if ($modo_visualizacion == 'visualizacion')
					  <div class="row">
						<div class="col-md-12 col-lg-6">
							<div class="col-12 text-left">
								<h6>
							      	Registrar otros programas que trabajan con el NNA y/o grupo familiar.
								</h6>
							</div>
							<div class="col-12 text-center">
								<label class="font-weight-bold">{{$prediagnostico_fec_4}}</label>
							</div>
						</div>
						<div class="col-md-12 col-lg-6" style="word-break: break-all;">
							<label class="font-weight-bold">{{$prediagnostico_des_4}}</label>
						</div>
					  </div>

					@elseif ($modo_visualizacion == 'edicion')
					  <div class="row">
					  	<!-- FECHA 4 -->
					    <div class="col-md-12 col-lg-6" style="display: flex; align-items: center;">
						    <div>	      
									<h6>
						      			Registrar otros programas que trabajan con el NNA y/o grupo familiar.
									</h6>
									<div style="max-width: 250px; padding: 20px 0px 20px 0px;">
							      	<div class="input-group date-pick" id="fecha_4" data-target-input="nearest">
										<input onkeypress='return caracteres_especiales_fecha(event)' type="text" name="hora_ini" class="form-control datetimepicker-input "  data-target="#fecha_4" id="fecha_prediagnostico_4" onBlur="guardarFechaPreDiagnostico({{ $caso_id }}, 'fecha_prediagnostico_4',$(this).val());" value="{{$prediagnostico_fec_4}}" @if (config('constantes.en_prediagnostico')!= $estado_actual_caso) disabled @endif>
										<div class="input-group-append" data-target="#fecha_4" data-toggle="datetimepicker">
											<div class="input-group-text"><i class="fa fa-calendar"></i></div>
										</div>
									</div>
									<p id="val_obs_pre_fec_4" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar una fecha valida.</p>
						    		</div>
						    </div>
					    </div>
					    <!-- FECHA 4 -->

					    <!-- COMENTARIO 4 -->
					    <div class="col-md-12 col-lg-6">
					      	<textarea maxlength="1000" onkeypress='return caracteres_especiales(event)' onpaste="onpasteval(4);" onKeyUp="valTextAreaprediagnostico_observacion4()" onKeyDown="valTextAreaprediagnostico_observacion4()" class="form-control " rows="7" id="obs_prediagnostico_4" onBlur="guardarObsPreDiagnostico({{ $caso_id }}, 'obs_prediagnostico_4',$(this).val());" @if (config('constantes.en_prediagnostico')!= $estado_actual_caso) disabled @endif>{{$prediagnostico_des_4}}</textarea>
							<div class="row">
								<div class="col-md-12 col-lg-6">
									<h6><small class"form-text text-muted">Mínimo 3 y máximo 1000 caracteres.</small></h6>
								</div>
								<div class="col-md-12 col-lg-6">
									<h6><small class"form-text text-muted">N° de caracteres: <strong id="cant_carac_4" style="color: #000000;">0</strong></small></h6>
								</div>
							</div>

					      	<p id="val_obs_pre_4" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar un comentario valido.</p>
					    </div>
					    <!-- COMENTARIO 4 -->
					  </div>
					@endif  
					<hr>


					@if ($modo_visualizacion == 'visualizacion')
					  <div class="row">
						<div class="col-md-12 col-lg-6">
							<div class="col-12 text-left">
								<h6>
							      	Información que pueda ir poblando las dimensiones del NCFAS-G.
								</h6>
							</div>
							<div class="col-12 text-center">
								<label class="font-weight-bold">{{$prediagnostico_fec_5}}</label>
							</div>
						</div>
						<div class="col-md-12 col-lg-6" style="word-break: break-all;">
							<label class="font-weight-bold">{{$prediagnostico_des_5}}</label>
						</div>
					  </div>	

					@elseif ($modo_visualizacion == 'edicion')
					  <div class="row">
					  	<!-- FECHA 5 -->
					    <div class="col-md-12 col-lg-6" style="display: flex; align-items: center;">
						    <div>	      
									<h6>
						      			Información que pueda ir poblando las dimensiones del NCFAS-G.
									</h6>
									<div style="max-width: 250px; padding: 20px 0px 20px 0px;">
							      	<div class="input-group date-pick" id="fecha_5" data-target-input="nearest">
										<input onkeypress='return caracteres_especiales_fecha(event)' type="text" name="hora_ini" class="form-control datetimepicker-input "  data-target="#fecha_5" id="fecha_prediagnostico_5" onBlur="guardarFechaPreDiagnostico({{ $caso_id }}, 'fecha_prediagnostico_5',$(this).val());" value="{{$prediagnostico_fec_5}}" @if (config('constantes.en_prediagnostico')!= $estado_actual_caso) disabled @endif>
										<div class="input-group-append" data-target="#fecha_5" data-toggle="datetimepicker">
											<div class="input-group-text"><i class="fa fa-calendar"></i></div>
										</div>
									</div>
									<p id="val_obs_pre_fec_5" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar una fecha valida.</p>
						    		</div>
						    </div>
					    </div>
					    <!-- FECHA 5 -->

					    <!-- COMENTARIO 5 -->
					    <div class="col-md-12 col-lg-6">
					      	<textarea maxlength="1000" onkeypress='return caracteres_especiales(event)' onpaste="onpasteval(5);" onKeyUp="valTextAreaprediagnostico_observacion5()" onKeyDown="valTextAreaprediagnostico_observacion5()" class="form-control " rows="7" id="obs_prediagnostico_5" onBlur="guardarObsPreDiagnostico({{ $caso_id }}, 'obs_prediagnostico_5',$(this).val());" @if (config('constantes.en_prediagnostico')!= $estado_actual_caso) disabled @endif>{{$prediagnostico_des_5}}</textarea>
							<div class="row">
								<div class="col-md-12 col-lg-6">
									<h6><small class"form-text text-muted">Mínimo 3 y máximo 1000 caracteres.</small></h6>
								</div>
								<div class="col-md-12 col-lg-6">
									<h6><small class"form-text text-muted">N° de caracteres: <strong id="cant_carac_5" style="color: #000000;">0</strong></small></h6>
								</div>
							</div>

					      	<p id="val_obs_pre_5" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar un comentario valido.</p>
					    </div>
					    <!-- COMENTARIO 5 -->
					  </div>
					@endif  
					<hr>

					@if ($modo_visualizacion == 'visualizacion')
					  <div class="row">
						<div class="col-md-12 col-lg-6">
							<div class="col-12 text-left">
								<h6>
							      	Determinar preliminarmente la elegibilidad de la familia para el servicio de terapia familiar.
								</h6>
							</div>
							<div class="col-12 text-center">
								<label class="font-weight-bold">{{$prediagnostico_fec_6}}</label>
							</div>
						</div>
						<div class="col-md-12 col-lg-6" style="word-break: break-all;">
							<label class="font-weight-bold">{{$prediagnostico_des_6}}</label>
						</div>
					  </div>

					@elseif ($modo_visualizacion == 'edicion')
					  <div class="row">
					  	<!-- FECHA 6 -->
					    <div class="col-md-12 col-lg-6" style="display: flex; align-items: center;">
						    <div>	      
									<h6>
						      			Determinar preliminarmente la elegibilidad de la familia para el servicio de terapia familiar.
									</h6>
									<div style="max-width: 250px; padding: 20px 0px 20px 0px;">
							      	<div class="input-group date-pick" id="fecha_6" data-target-input="nearest">
										<input onkeypress='return caracteres_especiales_fecha(event)' type="text" name="hora_ini" class="form-control datetimepicker-input "  data-target="#fecha_6" id="fecha_prediagnostico_6" onBlur="guardarFechaPreDiagnostico({{ $caso_id }}, 'fecha_prediagnostico_6',$(this).val());" value="{{$prediagnostico_fec_6}}" @if (config('constantes.en_prediagnostico')!= $estado_actual_caso) disabled @endif>
										<div class="input-group-append" data-target="#fecha_6" data-toggle="datetimepicker">
											<div class="input-group-text"><i class="fa fa-calendar"></i></div>
										</div>
									</div>
									<p id="val_obs_pre_fec_6" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar una fecha valida.</p>
						    		</div>
						    </div>
					    </div>
					    <!-- FECHA 6 -->

					    <!-- COMENTARIO 6 -->
					    <div class="col-md-12 col-lg-6">
					      	<textarea maxlength="1000" onkeypress='return caracteres_especiales(event)' onpaste="onpasteval(5);" onKeyUp="valTextAreaprediagnostico_observacion6()" onKeyDown="valTextAreaprediagnostico_observacion6()" class="form-control " rows="7" id="obs_prediagnostico_6" onBlur="guardarObsPreDiagnostico({{ $caso_id }}, 'obs_prediagnostico_6',$(this).val());" @if (config('constantes.en_prediagnostico')!= $estado_actual_caso) disabled @endif>{{$prediagnostico_des_6}}</textarea>
							<div class="row">
								<div class="col-md-12 col-lg-6">
									<h6><small class"form-text text-muted">Mínimo 3 y máximo 1000 caracteres.</small></h6>
								</div>
								<div class="col-md-12 col-lg-6">
									<h6><small class"form-text text-muted">N° de caracteres: <strong id="cant_carac_6" style="color: #000000;">0</strong></small></h6>
								</div>
							</div>

					      	<p id="val_obs_pre_6" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar un comentario valido.</p>
					    </div>
					    <!-- COMENTARIO 6 -->
					  </div>
					@endif  
					</div>
				  </div>
			</div>

			<!-- BITACORA ESTADO ACTUAL -->

			<div class="card shadow-sm alert-info">
				<div class="card-header p-3">
					<h5 class="mb-0"><i class="fa fa-pencil"></i> Bitácora</h5>
		      	</div>
		      	<div class="card-body">
				  	<label for="bitacora_estado_diagnostico" style="font-weight: 800;" class="">Estado actual del caso:</label>

				@if ($modo_visualizacion == 'visualizacion')
					<div class="text-success" style="word-break: break-all;">
						<label class="font-weight-bold">{{ $bitacoras_estados[5] }}</label>
					</div>
				@elseif ($modo_visualizacion == 'edicion')
				  	<textarea maxlength="2000" onkeypress='return caracteres_especiales(event)'class="form-control txtAreEtapa " name="bit-etapa-prediagnostico" id="bitacora_estado_prediagnostico" rows="3" onBlur="cambioEstadoCaso(13, {{ $caso_id }}, $(this).val());" @if (config('constantes.en_prediagnostico')  != $estado_actual_caso) disabled @endif>{{ $bitacoras_estados[5] }}</textarea>
				@endif
				</div>
			</div>
			<!-- FIN BITACORA ESTADO ACTUAL -->

			@if ($modo_visualizacion == 'edicion')
				<div class="text-center">
					<button type="button" id="btn-etapa-prediagnostico" class="btn btn-success btnEtapa" onclick="siguienteEtapa(15, {{ $caso_id }});" disabled> Ir a la siguiente etapa - <strong>Diagnóstico</strong></button>
				</div>
			@endif
			</div>

<script type="text/javascript">
	$(function() {
		$('.date-pick').datetimepicker({
			format: 'DD/MM/Y'
		});
	});
		$(function () {
  $('[data-toggle="popover"]').popover()
})
</script>
