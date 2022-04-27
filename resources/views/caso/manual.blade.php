@extends('layouts.main')

@section('contenido')
	<form name="form_ingresar" method="post" action="{{ route('coordinador.caso.manual.ingresar') }}">
		{{ csrf_field() }}
		<section class=" p-1 cabecera">
			<div class="container-fluid">
				<div class="row align-items-center">
					<div class="col-md-12">
						<h5>Registrar Casos</h5>
					</div>
				</div>
			</div>
		</section>
		
		@if(Session::has('success'))
			<div class="container-fluid">
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					<strong>{{ Session::get('success') }}</strong>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			</div>
		@endif
		@if(Session::has('danger'))
			<div class="container-fluid">
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<strong>{{ Session::get('danger') }}</strong>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			</div>
		@endif
		
		<section>
			<div class="container-fluid">
				<div class="card p-4 shadow-sm">
					<div class="row">
						<div class="col-lg-12">
							<h4>Datos del Caso</h4>
							<div class="row">
								<div class="col">
									<label><h6>RUT</h6></label>
									<input type="text" class="form-control " name="rut" id="rut" placeholder="15.373.345-k">
								</div>
							</div>
							{{--<div class="form-check">
								
								<input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
								<label class="form-check-label" for="defaultCheck1">No posee documento</label>
							</div>--}}
							<div class="row">
								<div class="col form-group"></div>
							
							
							</div>
							<div class="row">
								<div class="col form-group">
									<label><h6>Nombres</h6></label>
									<input onkeypress='return caracteres_especiales(event)' type="text" required class="form-control " name="nombres" id="nombres" placeholder="Nombres">
								</div>
							</div>
							<div class="row">
								<div class="col form-group">
									<label><h6>Apellido Paterno</h6></label>
									<input onkeypress='return caracteres_especiales(event)' type="text" class="form-control " name="apellido_p" id="apellido_p" placeholder="Apellido Paterno">
								
								</div>
								<div class="col form-group">
									<label><h6>Apellido Materno</h6></label>
									<input onkeypress='return caracteres_especiales(event)' type="text" class="form-control " name="apellido_m" id="apellido_m" placeholder="Apellido Materno">
								</div>
							</div>
							<div class="row">
								<div class="col form-group">
									<div>
										<label><h6>Sexo</h6></label>
									</div>
									<div class="col-3 form-check form-check-inline">
										<input required type="radio" class="form-check-input" id="masculino" name="sexo" value="1">
										<label class="form-check-label" for="masculino"> Masculino</label>
									</div>
									<div class="col-3 form-check form-check-inline">
										<input required type="radio" class="form-check-input" id="femenino" name="sexo" value="2">
										<label class="form-check-label" for="femenino"> Femenino</label>
									</div>
								</div>
								<div class="col form-group">
									<div>
										<label><h6>Nacionalidad</h6></label>
									</div>
									<div class="col-3 form-check form-check-inline">
										<input required type="radio" class="form-check-input" id="chileno" name="per_chi" value="1">
										<label class="form-check-label" for="chileno"> Chileno</label>
									</div>
									<div class="col-3 form-check form-check-inline">
										<input required type="radio" class="form-check-input" id="extranjero" name="per_chi" value="0">
										<label class="form-check-label" for="extranjero"> Extranjero</label>
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col form-group">
									
									<label><h6>Fecha Nacimiento</h6></label>
									<div class="input-group date" id="datetimepicker4" data-target-input="nearest">
										<input onkeypress='return caracteres_especiales_fecha(event)' required name="fecha_nac" type="text" class="form-control datetimepicker-input " data-target="#datetimepicker4"/>
										<div class="input-group-append" data-target="#datetimepicker4" data-toggle="datetimepicker">
											<div class="input-group-text"><i class="fa fa-calendar"></i></div>
										</div>
									</div>
								</div>
								<div class="col form-group"></div>
							</div>
							<div><label><h5>Direcciones</h5></label></div>
							<div class="row">
								<div class="col form-group">
									<label><h6>Calle</h6></label>
									<input onkeypress='return caracteres_especiales(event)' type="text" class="form-control " name="dir_call[]" placeholder="Calle">
								</div>
								<div class="col form-group">
									<label><h6>N°</h6></label>
									<input type="number" class="form-control " name="dir_num[]" placeholder="">
								</div>
								<div class="col form-group">
									<label><h6>N° de Depto/Casa</h6></label>
									<input onkeypress='return caracteres_especiales(event)' type="text" class="form-control " name="dir_dep[]" placeholder="N° de Depto/Casa">
								</div>
							</div>
							<div class="row">
								<div class="col form-group">
									<label><h6>Calle</h6></label>
									<input onkeypress='return caracteres_especiales(event)' type="text" class="form-control " name="dir_call[]" placeholder="Calle">
								</div>
								<div class="col form-group">
									<label><h6>N°</h6></label>
									<input type="number" class="form-control " name="dir_num[]" placeholder="">
								</div>
								<div class="col form-group">
									<label><h6>N° de Depto/Casa</h6></label>
									<input onkeypress='return caracteres_especiales(event)' type="text" class="form-control " name="dir_dep[]" placeholder="N° de Depto/Casa">
								</div>
							</div>
							<div class="row">
								<div class="col form-group">
									<label><h6>Calle</h6></label>
									<input onkeypress='return caracteres_especiales(event)' type="text" class="form-control " name="dir_call[]" placeholder="Calle">
								</div>
								<div class="col form-group">
									<label><h6>N°</h6></label>
									<input type="number" class="form-control " name="dir_num[]" placeholder="">
								</div>
								<div class="col form-group">
									<label><h6>N° de Depto/Casa</h6></label>
									<input onkeypress='return caracteres_especiales(event)' type="text" class="form-control " name="dir_dep[]" placeholder="N° de Depto/Casa">
								</div>
							</div>
							<div><label><h5>Contactos</h5></label></div>
							<div class="row">
								<div class="col form-group">
									<label><h6>Nombres</h6></label>
									<input onkeypress='return caracteres_especiales(event)' type="text" class="form-control " name="con_nom[]" placeholder="Nombres">
								</div>
								<div class="col form-group">
									<label><h6>Apellido Paterno</h6></label>
									<input onkeypress='return caracteres_especiales(event)' type="text" class="form-control " name="con_pat[]" placeholder="Apellido Paterno">
								</div>
								<div class="col form-group">
									<label><h6>Apellido Materno</h6></label>
									<input onkeypress='return caracteres_especiales(event)' type="text" class="form-control " name="con_mat[]" placeholder="Apellido Materno">
								</div>
								<div class="col form-group">
									<label><h6>Teléfono</h6></label>
									<input onkeypress='return caracteres_especiales(event)' type="text" class="form-control " name="con_tlf[]" placeholder="Teléfono">
								</div>
							</div>
							<div class="row">
								<div class="col form-group">
									<label><h6>Nombres</h6></label>
									<input onkeypress='return caracteres_especiales(event)' type="text" class="form-control " name="con_nom[]" placeholder="Nombres">
								</div>
								<div class="col form-group">
									<label><h6>Apellido Paterno</h6></label>
									<input onkeypress='return caracteres_especiales(event)' type="text" class="form-control " name="con_pat[]" placeholder="Apellido Paterno">
								</div>
								<div class="col form-group">
									<label><h6>Apellido Materno</h6></label>
									<input onkeypress='return caracteres_especiales(event)' type="text" class="form-control " name="con_mat[]" placeholder="Apellido Materno">
								</div>
								<div class="col form-group">
									<label><h6>Teléfono</h6></label>
									<input onkeypress='return caracteres_especiales(event)' type="text" class="form-control " name="con_tlf[]" placeholder="Teléfono">
								</div>
							</div>
							<div class="row">
								<div class="col form-group">
									<label><h6>Nombres</h6></label>
									<input onkeypress='return caracteres_especiales(event)' type="text" class="form-control " name="con_nom[]" placeholder="Nombres">
								</div>
								<div class="col form-group">
									<label><h6>Apellido Paterno</h6></label>
									<input onkeypress='return caracteres_especiales(event)' type="text" class="form-control " name="con_pat[]" placeholder="Apellido Paterno">
								</div>
								<div class="col form-group">
									<label><h6>Apellido Materno</h6></label>
									<input onkeypress='return caracteres_especiales(event)' type="text" class="form-control " name="con_mat[]" placeholder="Apellido Materno">
								</div>
								<div class="col form-group">
									<label><h6>Teléfono</h6></label>
									<input onkeypress='return caracteres_especiales(event)' type="text" class="form-control " name="con_tlf[]" placeholder="Teléfono">
								</div>
							</div>
							<div><label><h5>Datos Escolares</h5></label></div>
							<div class="row">
								<div class="col form-group">
									<label><h6>Centro Educacional</h6></label>
									<input onkeypress='return caracteres_especiales(event)' type="text" class="form-control " name="nombre_rbd" id="nombre_rbd" placeholder="Centro Educacional">
								</div>
								<div class="col-3 form-group">
									<label><h6>Codigo</h6></label>
									<input onkeypress='return caracteres_especiales(event)' type="text" class="form-control " name="rbd_rbd" placeholder="Rbd">
								</div>
							</div>
							<div class="row">
								<div class="col-6 form-group">
									<label><h6>Nivel</h6></label>
									<input onkeypress='return caracteres_especiales(event)' type="text" class="form-control " name="rbd_nivel" id="rbd_nivel" placeholder="Nivel">
								
								</div>
								<div class="col-3 form-group">
									<label><h6>Curso</h6></label>
									<input onkeypress='return caracteres_especiales(event)' type="text" class="form-control " name="rbd_curso" id="rbd_curso" placeholder="Curso">
								</div>
								<div class="col-3 form-group">
									<label><h6>Letra</h6></label>
									<input onkeypress='return caracteres_especiales(event)' type="text" class="form-control " name="rbd_letra" id="rbd_letra" placeholder="Letra">
								</div>
							</div>
						</div>
					
					</div>
				</div>
			</div>
		</section>
		
		<section>
			<div class="container-fluid">
				<div class="card p-4 shadow-sm">
					
					<h4>Datos del Caso</h4>
					<div class="row">
						<div class="form-group">
							<label for="exampleFormControlSelect2">Dimensión de la problemática</label>
							<select required class="form-control" id="dim_id" name="dim_id">
								@foreach($dimensiones as $dimension)
								<option value="{{ $dimension->dim_id }}">{{ $dimension->dim_nom }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<label>Descripición</label>
							<textarea onkeypress='return caracteres_especiales(event)' required class="form-control " name="desc_alerta" id="desc_alerta" placeholder="Descripción de la alerta"></textarea>
						</div>
					</div>
				</div>
			</div>
		</section>
		
		<section>
			<div class="container-fluid">
				<div class="row align-items-center">
					<div class="col text-right">
						<input type="submit" class="btn btn-primary btn-lg" value="Registrar Caso">
					</div>
				</div>
			</div>
		</section>
	</form>

@stop

@section('script')
	{{-- Libreria Validacion Rut --}}
	<script type="text/javascript" src="{{ env('APP_URL') }}/js/jquery.rut.chileno.min.js"></script>
	<script type="text/javascript">
		
		$(document).ready(function () {
			// activas campos de fecha
			$('#datetimepicker4').datetimepicker({
				format: 'L',
				locale: 'es'
			});
			
			// activa campo de rut
			$('#rut').rut({
				fn_error : function(input){
					alert('El rut: ' + input.val() + ' es incorrecto');
					input.val('')
				},
				
				placeholder: true
			});
		});
	
	</script>

@endsection