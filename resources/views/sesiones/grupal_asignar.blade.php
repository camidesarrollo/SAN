<div class="modal-body" style="overflow-y:auto;">
	<form name="asignar_form" id="asignar_form" method="post" action="{{ route('sesiones.grupal.asignar',['gru_id'=>$grupal->gru_id]) }}"  >
		{{ csrf_field() }}
		<input type="hidden" id="gru_id" name="gru_id" value="{{ $grupal->gru_id }}">
		<input type="hidden" id="val_gru_nna" name="val_gru_nna" value="{{  route('sesiones.grupal.validar') }}">
		
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
								<input readonly required type="text" class="form-control" name="gru_rut" id="gru_rut" placeholder="12.345.678-5" value="{{ $grupal->gru_rut }}">
							</div>
							<div class="col form-group">
								<label><h6>Nombre</h6></label>
								<input readonly required type="text" class="form-control" name="gru_nom" id="gru_nom" placeholder="Nombres" value="{{ $grupal->gru_nom }}">
							</div>
							<div class="col form-group">
								<label><h6>Fecha Sesion</h6></label>
								<div  class="input-group date" id="datetimepicker4" data-target-input="nearest">
									<input readonly name="gru_fec" type="text" class="form-control datetimepicker-input" data-target="#datetimepicker4" value="{{ $grupal->fecha }}"/>
									<div class="input-group-append" data-target="#datetimepicker4" data-toggle="datetimepicker">
										<div class="input-group-text"><i class="fa fa-calendar"></i></div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<ul class="nav nav-tabs" id="myTab" role="tablist">
									<li class="nav-item">
										<a class="nav-link active" id="asignar1-tab" data-toggle="tab" href="#asignar1" role="tab" aria-controls="asignar1" aria-selected="true">Sus Casos</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="asignar2-tab" data-toggle="tab" href="#asignar2" role="tab" aria-controls="asignar2" aria-selected="false">Otros Casos Asignados</a>
									</li>
								</ul>
							</div>
						</div>
						<div class="row pt-2">
							<div class="col ">
								<div class="tab-content" id="myTabContent">
									<div class="tab-pane fade show active" id="asignar1" role="tabpanel" aria-labelledby="asignar1-tab">
										<div class="row">
											<div class="col form-group">
												@php($i=0)
												@foreach($casos as $caso)
													@if(($i%2)==0)
														<label>
															@if(isset($sesiones[$caso->cas_id]))
																<input checked disabled name="casos[]" type="checkbox" value="{{ $caso->cas_id }}">
																<b>{{ $caso->caso->persona->per_run }} -
																	{{ $caso->caso->persona->nombre_corto }}</b>
															@else
																<input name="casos[]" type="checkbox" value="{{ $caso->cas_id }}" onclick="valSesionesGrupales(this, {{ $caso->cas_id }});">
																{{ $caso->caso->persona->per_run }} -
																{{ $caso->caso->persona->nombre_corto }}
															@endif
														</label>
														<br>
													@endif
													@php($i++)
												@endforeach
											</div>
											<div class="col form-group">
												@php($i=0)
												@foreach($casos as $caso)
													@if(($i%2)!=0)
														<label>
															@if(isset($sesiones[$caso->cas_id]))
																<input checked disabled name="casos[]" type="checkbox" value="{{ $caso->cas_id }}">
																<b>{{ $caso->caso->persona->per_run }} -
																	{{ $caso->caso->persona->nombre_corto }}</b>
															@else
																<input name="casos[]" type="checkbox" value="{{ $caso->cas_id }}" onclick="valSesionesGrupales(this, {{ $caso->cas_id }});">
																{{ $caso->caso->persona->per_run }} -
																{{ $caso->caso->persona->nombre_corto }}
															@endif
														</label>
														<br>
													@endif
													@php($i++)
												@endforeach
											</div>
										</div>
									</div>
									<div class="tab-pane fade" id="asignar2" role="tabpanel" aria-labelledby="asignar2-tab">
										<div class="row">
											<div class="col form-group">
												@php($i=0)
												@foreach($grupales as $sesion_grupal)
													@if(($i%2)==0)
														<label>
															<input checked disabled name="grupales[]" type="checkbox" value="{{ $sesion_grupal->cas_id }}">
															<b>{{ $sesion_grupal->caso->persona->per_run }} -
																{{ $sesion_grupal->caso->persona->nombre_corto }}</b>
														
														</label>
														<br>
													@endif
													@php($i++)
												@endforeach
											</div>
											<div class="col form-group">
												@php($i=0)
												@foreach($grupales as $sesion_grupal)
													@if(($i%2)!=0)
														<label>
																<input checked disabled name="grupales[]" type="checkbox" value="{{ $sesion_grupal->cas_id }}">
																<b>{{ $sesion_grupal->caso->persona->per_run }} -
																	{{ $sesion_grupal->caso->persona->nombre_corto }}</b>
															
														</label>
														<br>
													@endif
													@php($i++)
												@endforeach
											</div>
										</div>
									</div>
									
								</div>
							</div>
						</div>
						
						<div class="row align-items-center">
							<div class="col-md-6">
							</div>
							<div class="col-md-6 text-right">
								<button type="button" class="btn btn-primary " id="btnGuardar" onclick="enviaFormSerialize('#asignar_form', '', 'asignarOk', '');">
									Agendar Casos a Sesión Grupal
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>

