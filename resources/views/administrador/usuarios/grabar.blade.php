<form class="form-horizontal" id="frmGrabarUsuario" role="form" method="post" action="{{ route('usuarios.update') }}">
	{{ csrf_field() }}
	<input type="hidden" value="{{$id}}" name="id" id="IDid" />
	<div class="panel-body">
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group">
					<label class="col-lg-2 control-label" for="Rut">Rut: </label>
					<div class="col-lg-4" >
						@if(@$oUsuario->run!='')
					<input type="text" class="form-control" id="IDrun" name="run" onkeypress="return isNumberKey(event);" required oninput="checkRut(this)" placeholder="Ingrese RUT" onchange="Valida_Rut(this);" value="{{@$oUsuario->run}} - {{@dv($oUsuario->run)}}" readonly="readonly">
						@else
					<input type="text" class="form-control" id="IDrun" name="run" onkeypress="return isNumberKey(event);" required oninput="checkRut(this)" placeholder="Ingrese RUT" onchange="Valida_Rut(this);" value="" >
						@endif
					</div>
					<label class="col-lg-2 control-label" for="nombres">Nombres: </label>
					<div class="col-lg-4"><input type="text" class="form-control" id="IDnombre" name="nombres" placeholder="Nombres"  value="{{@$oUsuario->nombres}}" ></div>
				</div>
			</div>
		</div>
		<div class="row">
				<div class="col-sm-12">
				<div class="form-group">
					<label class="col-lg-2 control-label" for="apellido_paterno">Apellido Paterno: </label>
					<div class="col-lg-4"><input type="text" class="form-control" id="IDapellidoP" name="apellido_paterno" placeholder="Apellido Paterno" value="{{@$oUsuario->apellido_paterno}}" ></div>
					<label class="col-lg-2 control-label" for="apellido_materno">Apellido Materno: </label>
					<div class="col-lg-4"><input type="text" class="form-control" id="IDapellidoM" name="apellido_materno" placeholder="Apellido Materno" value="{{@$oUsuario->apellido_materno}}" ></div>
				</div>
				</div>
		</div>
		<div class="row">
				<div class="col-sm-12">
				<div class="form-group">
					<label class="col-lg-2 control-label" for="telefono">Teléfono: </label>
					<div class="col-lg-4" ><input type="text" class="form-control" id="IDtelefono" name="telefono" placeholder="Telefono" value="{{@$oUsuario->telefono}}" ></div>
					<label class="col-lg-2 control-label" for="nombre">Email: </label>
					<div class="col-lg-4"><input type="text" class="form-control" id="IDemail" name="email" placeholder="Email" value="{{@$oUsuario->email}}" ></div>
				</div>
				</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group">
					<label class="col-lg-2 control-label" for="id_region">Región: </label>
					<div class="col-lg-4">
						<select class="form-control" id="IDreg_id" name="id_region" >
						   <option  value="0" >Seleccione Región:</option>
							 @foreach($lstRegion as $o)
									@if(@$oUsuario->id_region==$o->reg_id)
										<option value="{{$o->reg_id}}" selected="selected" >{{$o->reg_descripcion}}</option>
									@else
										<option value="{{$o->reg_id}}">{{$o->reg_descripcion}}</option>
									@endif
							@endforeach
						</select>
					</div>
	
					<label class="col-lg-2 control-label" for="Perfil">Perfil: </label>
					<div class="col-lg-4">
						<select class="form-control" id="IDid_perfil" name="id_perfil" >
						   <option  value="0" >Seleccione Perfil:</option>
							 @foreach($lstPerfil as $o)
									@if(@$oUsuario->id_perfil==$o->id)
										<option value="{{$o->id}}" selected="selected" >{{$o->nombre}}</option>
									@else
										<option value="{{$o->id}}">{{$o->nombre}}</option>
									@endif
							@endforeach
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group">
					<label class="col-lg-2 control-label" for="Institucion">Institución: </label>
					<div class="col-lg-10">
						<select class="form-control" id="IDinstitucion" name="id_institucion" >
							<option  value="0" >Seleccione Institución:</option>
							@foreach($lstInstitucion as $o)
								@if(@$oUsuario->id_institucion==$o->id)
									<option value="{{$o->id}}" selected="selected" >{{$o->nombre}}</option>
								@else
									<option value="{{$o->id}}">{{$o->nombre}}</option>
								@endif
							@endforeach
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group">
					<label class="col-lg-2 control-label" for="Institucion">Estado: </label>
					<div class="col-lg-10">
						<select class="form-control" id="IDid_estado" name="id_estado" >
							<option value="0" >Seleccione Estado:</option>
							@foreach($lstEstado as $o)
								@if(@$oUsuario->id_estado==$o->valor)
									<option value="{{$o->valor}}" selected="selected" >{{$o->nombre}}</option>
								@else
									<option value="{{$o->valor}}">{{$o->nombre}}</option>
								@endif
							@endforeach
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>


