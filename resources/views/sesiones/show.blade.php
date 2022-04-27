<div class="modal-header">
	<h5 class="modal-title" id="xModalTitle">Sesiones</h5>
	<button type="button" class="close cerrar_sup" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
<div class="modal-body" id="ses_mod" style="overflow-y:auto;">
	<section class="bd-masthead pr-3 pl-3">
		<div class="container-fluid">
			<div class="row align-items-center">
				<div class="col-md-12">
					<div class="row card bg-light p-4">
						<form id="form_sesion" name="form_sesion" method="post" action="{{ route('sesiones.actualizar',['cas_id'=>$sesion->cas_id,'ses_id'=>$sesion->ses_id]) }}" >
							{{ csrf_field() }}

							<?php ?>
							<input type="hidden" name="cas_id" value="{{ @$sesion->cas_id }}" >
							<input type="hidden" name="ses_id" value="{{ @$sesion->ses_id }}" >
							<input type="hidden" name="ter_id" value="{{ @$sesion->ter_id }}" >
							<div class="row">
								<div class="col form-group">
									<label><h6>Observación</h6></label>

										<!-- <textarea {{ $desabilitar }} name="ses_obs" type="text" class="form-control"  placeholder="Observacion">{{ @$sesion->ses_obs }}</textarea> -->

									<textarea {{ $desabilitar }} name="ses_obs" id="ses_obs" type="text" class="form-control"  placeholder="Observacion"></textarea>
								</div>
								
							</div>
							<div class="row">
								<div class="col form-group">
									<label><h6>Diagnostico</h6></label>

									<!-- <textarea {{ $desabilitar }} name="ses_dia" type="text" class="form-control"  placeholder="Diagnostico">{{ @$sesion->ses_dia }}</textarea> -->

									<textarea {{ $desabilitar }} name="ses_dia" id="ses_dia" type="text" class="form-control"  placeholder="Diagnostico"></textarea>
								</div>
							</div>
							<div class="row">
								<div class="col form-group">
									<label><h6>Tipo</h6></label>
									{{ Form::select('ses_tip', config('constantes.sesion_tipos'), $sesion->ses_tip, ['class'=>'custom-select','disabled'=>'disabled']) }}
								</div>
								<div class="col form-group">
									<label><h6>Fecha</h6></label>
									<div class="input-group date" id="datetimemodal" data-target-input="nearest">
										<input {{ $desabilitar }} name="ses_fec" id="ses_fec" value="{{ @$sesion->fecha }}" type="text" class="form-control datetimepicker-input" data-target="#datetimemodal"/>
										<div class="input-group-append" data-target="#datetimemodal" data-toggle="datetimepicker">
											<div class="input-group-text"><i class="fa fa-calendar"></i></div>
										</div>
									</div>
								</div>
								<div class="col form-group">
									<label><h6>Estado</h6></label>
									{{ Form::select('est_ses_id', $estados, $estado->est_ses_id, ['id'=>'est_ses_id','class'=>'custom-select',$desabilitar]) }}
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default btn_cerrar" data-dismiss="modal">Cerrar</button>
	<button type="button" class="btn btn-primary" {{ $desabilitar }} data-loading-text="Guardando..." id="btnGuardar" onclick="enviaFormSerialize('#form_sesion', '', 'actualizarOk', '');">Aceptar</button>
</div>

