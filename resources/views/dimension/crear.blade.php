
<div class="modal-body" style="overflow-y:auto;">
	
	@if (isset($dimension->dim_id))
		<form name="dimension_form" id="dimension_form" method="post" action="{{ route('dimension.actualizar') }}"  >
	@else
		<form name="dimension_form" id="dimension_form" method="post" action="{{ route('dimension.insertar') }}"  >
	@endif
		
		{{ csrf_field() }}
		
		<div class="container-fluid">
			<div class="card p-4 shadow-sm">
					
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					
					@if (isset($dimension->dim_id))
						<h4>Modificar Dimensi&oacute;n</h4>
					@else
						<h4>Nueva Dimensi&oacute;n</h4>
					@endif
					
					<div class="card">
						
						@if (isset($dimension->dim_id))
							<div class="row">
								<div class="col form-group">
									<label><h6>Id</h6></label>
									<label class="form-control">{{$dimension->dim_id}}</label>
									<input type="hidden" name="dim_id" id="dim_id" value="{{$dimension->dim_id}}" >
								</div>
							</div>
						@endif
						
						<div class="row">
							<div class="col form-group">
								<label><h6>Nombre</h6></label>
								<input required type="text" class="form-control" name="dim_nom" id="dim_nom" placeholder="Nombre" value="{{@$dimension->dim_nom}}">
							</div>
						</div>
						
						<div class="row">
							<div class="col form-group">
								<label><h6>Descripci&oacute;n</h6></label>
								<textarea onkeypress='return caracteres_especiales(event)' required class="form-control" name="dim_des" id="dim_des" placeholder="Descripción" >{{@$dimension->dim_des}}</textarea>
							</div>
						</div>
						
						<div class="row">
							<div class="col form-group">
								<label>Estado</label>
								<select class="form-control" name="dim_act" id="dim_act" >
									<option value="1" @if (@$dimension->dim_act == 1) selected @endif>Activo</option>
									<option value="0" @if (@$dimension->dim_act == 0) selected @endif>Inactivo</option>
								</select>
							</div>
						</div>
						
						<div class="row align-items-center">
							<div class="col-md-6">
							</div>
							<div class="col-md-6 text-right">
								@if (isset($dimension->dim_id))
									<button type="button" class="btn btn-primary btn-lg" id="btnGuardar" onclick="enviaFormSerialize('#dimension_form', '', 'actualizarDimension', '');">
										Modificar Dimensi&oacute;n
									</button>
								@else
									<button type="button" class="btn btn-primary btn-lg" id="btnGuardar" onclick="enviaFormSerialize('#dimension_form', '', 'insertarDimension', '');">
										Registrar Dimensi&oacute;n
									</button>
								@endif
							</div>
						</div>
						
					</div>

			</div>
		</div>
		
	</form>
	
</div>

