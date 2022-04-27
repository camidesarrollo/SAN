<div id="agregarDireccionModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="diagnosticarModal" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content p-4">
			<div class="modal-header" >
				<h3><span class="oi oi-map-marker"></span> Agregar Dirección</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" >
				<!-- <form method="post" name="agregarDireccionForm" action="{{ route('caso.agregar.direccion') }}" > -->
				<form method="post" name="agregarDireccionForm" action="">
					<input type="hidden" name="origen" value="{{$origen_info_nna}}" >
					<input type="hidden" name="id" id="id">
					<input type="hidden" name="opc" id="opc">
					<input type="hidden" name="run" id="run" value="{{$caso->run}}" >
					<input id="per_id" name="per_id" type="hidden" value="{{$caso->per_id}}" >
					<input name="url_ingreso_direccion" id="url_ingreso_direccion" type="hidden" 
					value="{{route('caso.agregar.direccion')}}">
					<input name="url_editar_direccion" id="url_editar_direccion" type="hidden" 
					value="{{route('coordinador.caso.editar.direccion')}}">

					<div class="form-row">
						<div class="form-group col-md-10">
							<label >Calle</label>
							<input type="text" name="calle" id="form_dir_call" class="form-control "  placeholder="Calle">
							<p id="val_form_dir_call" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe escribir una dirección.</p>
						</div>
						<div class="form-group col-md-2">
							<label >N°</label>
							<input required type="number" name="numero" id="form_dir_num" class="form-control " placeholder="N°">
							<p id="val_form_dir_num" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe escribir un numero de dirección.</p>
						</div>	
					</div>

					<div class="form-row">
						<div class="form-group col-md-3">
							<label>N° de Depto</label>
							<input onkeypress='return caracteres_especiales(event)' type="text" name="depto" id="form_dir_dpto" class="form-control " placeholder="N° de Depto">
						</div>
						<div class="form-group col-md-3">
							<label>Block</label>
							<input onkeypress='return caracteres_especiales(event)' type="text" name="block" id="form_dir_bloc" class="form-control " placeholder="Block">
						</div>
						
						<div class="form-group col-md-3">
							<label>Sitio</label>
							<input onkeypress='return caracteres_especiales(event)' type="text" name="sitio" id="form_dir_sit" class="form-control " placeholder="Sitio">
						</div>
						<div class="form-group col-md-3">
							<label>N° de Casa</label>
							<input onkeypress='return caracteres_especiales(event)' type="text" name="depto" id="form_dir_cas" class="form-control " placeholder="N° de Casa">
						</div>
					</div>

					<div class="form-group">
						<label >Región</label>
						<select name="region" id="form_dir_reg" data-dir="direccionRegion" class="form-control" attr1="{ {route('provincias.por.region')}}" onchange="seleccionarRegionFormularioDirecciones();">
							<option selected value="">Elegir región</option>
							@foreach($regiones AS $region)
								<option value="{{ $region->reg_id }}" >{{ $region->reg_nom }}</option>
							@endforeach
						</select>
						<p id="val_form_dir_reg" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe escoger una región.</p>
					</div>
					<div class="form-group"  >
						<label >Provincia</label>
						<select name="Provincia" id="form_dir_pro" data-dir="direccionProvincia" class="form-control" attr1="{ {route('comunas.por.provincia')}}" onchange="seleccionarProvinciaFormularioDirecciones();">
							<option selected value="">Elegir provincia</option>
							@foreach($provincias AS $provincia)
								<option value="{{ $provincia->pro_id }}" data-reg="{{ $provincia->reg_id }}">{{ $provincia->pro_nom }}</option>
							@endforeach
						</select>
						<p id="val_form_dir_pro" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe escoger una provincia.</p>
					</div>
					<div class="form-group"  >
						<label >Comuna</label>
						<select name="comuna" id="form_dir_com" data-dir="direccionComuna" class="form-control" onchange="seleccionarComunasFormularioDirecciones();">
							<option  value="">Elegir comuna</option>
							@foreach($comunas AS $comuna)
								<option value="{{ $comuna->com_id }}" data-pro="{{ $comuna->pro_id }}">{{ $comuna->com_nom }}</option>
							@endforeach
						</select>
						<p id="val_form_dir_com" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe escoger una comuna.</p>
					</div>

					<div class="form-group">
						<label >Prioridad (La prioridad 1 es la mas alta)</label>
						<input type="hidden" name="direcciones_count" id="form_dir_prio" value="{{ count($direcciones) }}" >
						<select name="prioridad" id="form_dir_prioridad" class="form-control" required>
							<option value="">Escoja</option>
							@for ($i = 0; $i < count($direcciones)+1; $i++)
								<option attr1="" value="{{$i+1}}" >{{$i+1}}</option>
							@endfor
						</select>
						<p id="val_form_dir_prio" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe escoger una prioridad de la dirección.</p>
					</div>

					<div class="form-group">
							<label >Referencias o información adicional</label>
							<textarea onkeypress='return caracteres_especiales(event)' required name="descripcion" id="form_dir_ref" class="form-control " irows="3"></textarea>
					</div>

					<button type="button" class="btn btn-primary" onclick="procesoDirecciones();">Agregar</button>

					
				</form>
			</div>

		</div>
	</div>
</div>