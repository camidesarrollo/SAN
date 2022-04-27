<div class="modal-body" style="overflow-y:auto;">
	<form name="grupal_form" id="grupal_form" method="post" action="{{ route('sesiones.grupal.crear') }}"  >
		{{ csrf_field() }}
		<input type="hidden" id="gru_id" name="gru_id" value="{{ @$grupal->gru_id ?? -1 }}">
		
		<div class="container-fluid">
			<div class="row align-items-center">
				<div class="col-md-12">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4>Datos de la Sesión</h4>
					<div class="row card bg-light p-4">
						<div class="row">
							<div class="col form-group">
								<label><h6>RUT Facilitador</h6></label>
								<input required type="text" class="form-control" name="gru_rut" id="gru_rut" placeholder="12.345.678-5" value="{{ @$grupal->rut ?? session('rut') }}">
							</div>
						</div>
						<div class="row">
							<div class="col form-group">
								<label><h6>Nombre Completo</h6></label>
								<input required type="text" class="form-control" name="gru_nom" id="gru_nom" placeholder="Nombres" value="{{ @$grupal->gru_nom ?? session('nombre_usuario') }}">
							</div>
						</div>
						<div class="row">
							<div class="col form-group">
								<label><h6>Fecha Sesion</h6></label>
								<div class="input-group date" id="datetimepicker4" data-target-input="nearest">
									<input {{ @$readonly }} required name="gru_fec" type="text" class="form-control datetimepicker-input" data-target="#datetimepicker4" value="{{ @$grupal->fecha }}"/>
									<div class="input-group-append" data-target="#datetimepicker4" data-toggle="datetimepicker">
										<div class="input-group-text"><i class="fa fa-calendar"></i></div>
									</div>
								</div>
							</div>
							<div class="col form-group"></div>
						</div>
						<div class="row">
							<div class="col form-group">
								<label>Observaciones</label>
								<textarea class="form-control" name="gru_obs" id="gru_obs" placeholder="">{{ @$grupal->gru_obs }}</textarea>
							</div>
						</div>
						<div class="row align-items-center">
							<div class="col-md-6">
							</div>
							<div class="col-md-6 text-right">
								<button type="button" class="btn btn-primary btn-lg" id="btnGuardar" onclick="enviaFormSerialize('#grupal_form', '', 'grupalOk', '');">
									Registrar Sesión
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>

