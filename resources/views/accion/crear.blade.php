
<div class="modal-body" style="overflow-y:auto;">
	
	@if (isset($accion->acc_id))
		<form name="accion_form" id="accion_form" method="post" action="{{ route('accion.actualizar') }}"  >
	@else
		<form name="accion_form" id="accion_form" method="post" action="{{ route('accion.insertar') }}"  >
	@endif
					
		{{ csrf_field() }}
		
		<div class="container-fluid">
			<div class="row align-items-center">
				<div class="col-md-12">
					
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					
					@if (isset($ofertas->ofe_id))
						<h4>Modificar Acci&oacute;n</h4>
					@else
						<h4>Nueva Acci&oacute;n</h4>
					@endif
					
					<div class="row card bg-light p-4">
						
						@if (isset($accion->acc_id))
							<div class="row">
								<div class="col form-group">
									<label><h6>Id</h6></label>
									<label class="form-control">{{$accion->acc_id}}</label>
									<input type="hidden" name="acc_id" id="acc_id" value="{{@$accion->acc_id}}">
								</div>
							</div>
						@endif
						
						<div class="row">
							<div class="col form-group">
								<label><h6>Nombre</h6></label>
								<input required onkeypress='return caracteres_especiales(event)' type="text" class="form-control" name="acc_nom" id="acc_nom" placeholder="Nombre" value="{{@$accion->acc_nom}}">
							</div>
						</div>
						
						<div class="row">
							<div class="col form-group">
								<label><h6>Descripci&oacute;n</h6></label>
								<textarea required onkeypress='return caracteres_especiales(event)' class="form-control" name="acc_des" id="acc_des" placeholder="Descripción" >{{@$accion->acc_des}}</textarea>
							</div>
						</div>
						
						<div class="row">
							<div class="col form-group">
								<label>Cuota</label>
								<input required type="number" class="form-control" name="ofe_cuo" min="1" value="{{@$ofertas->ofe_cuo}}">
							</div>
						</div>
						
						<div class="row">
							<div class="col form-group">
								<label>Tipo Oferta</label>
								<select class="form-control" name="ofe_tip" id="ofe_tip" >
									<option value="0" @if (@$ofertas->ofe_tip == 0) selected @endif>Municipal</option>
									<option value="1" @if (@$ofertas->ofe_tip == 1) selected @endif>Nacional</option>
								</select>
							</div>
						</div>
						
						<div class="row align-items-center">
							<div class="col-md-6">
							</div>
							<div class="col-md-6 text-right">
								@if (isset($ofertas->ofe_id))
									<button type="button" class="btn btn-primary btn-lg" id="btnGuardar" onclick="enviaFormSerialize('#ofertas_form', '', 'actualizarOferta', '');">
										Modificar Oferta
									</button>
								@else
									<button type="button" class="btn btn-primary btn-lg" id="btnGuardar" onclick="enviaFormSerialize('#ofertas_form', '', 'insertarOferta', '');">
										Registrar Oferta
									</button>
								@endif
							</div>
						</div>
					
					</div>
				
				</div>
			</div>
		</div>
	
	</form>

</div>

