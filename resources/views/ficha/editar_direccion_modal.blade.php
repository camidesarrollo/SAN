<div id="editarDireccionModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="diagnosticarModal" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content p-4">
			<div class="modal-header" >
				<h3><span class="oi oi-map-marker"></span> Editar Dirección</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" >
				<!-- <form method="post" name="editarDireccionForm" action="{{route('coordinador.caso.editar.direccion')}}" onsubmit="return validacionFormularioEditarDirecciones()" > -->
				<form method="post" name="editarDireccionForm" action="">
					<input type="hidden" name="origen" value="{{$origen_info_nna}}" >
					<input type="hidden" name="direcc_id" id="direcc_id">
					<input type="hidden" name="run" id="run" value="{{$caso->run}}" >
					<input id="per_id" name="per_id" type="hidden" value="{{$caso->per_id}}" >
					<input name="url_editar_direccion" id="url_editar_direccion" type="hidden" 
					value="{{route('coordinador.caso.editar.direccion')}}">

					<div class="form-row">
						<div class="form-group col-md-10">
							<label >Calle</label>
							<input onkeypress='return caracteres_especiales(event)'  type="text" name="calle" id="edit_d_calle" class="form-control "  placeholder="Calle" maxlength = "255">
							<p id="val_edit_d_calle" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe escribir una dirección.</p>
						</div>
						<div class="form-group col-md-2">
							<label >N°</label>
							<input  type="number"  name="numero" id="edit_d_numero" class="form-control " placeholder="N°" maxlength = "255">
							<p id="val_edit_d_numero" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe escribir un numero de dirección.</p>
						</div>	
					</div>

					<div class="form-row">
						<div class="form-group col-md-3">
							<label>N° de Depto</label>
							<input onkeypress='return caracteres_especiales(event)' type="text" name="depto" id="edit_d_depto" class="form-control " placeholder="N° de Depto" maxlength = "255">
						</div>
						<div class="form-group col-md-3">
							<label>Block</label>
							<input onkeypress='return caracteres_especiales(event)' type="text" name="block" id="edit_d_block" class="form-control " placeholder="Block" maxlength = "255">
						</div>
						
						<div class="form-group col-md-3">
							<label>Sitio</label>
							<input onkeypress='return caracteres_especiales(event)' type="text" name="sitio" id="edit_d_sitio" class="form-control " placeholder="Sitio" maxlength = "255">
						</div>
						<div class="form-group col-md-3">
							<label>N° de Casa</label>
							<input onkeypress='return caracteres_especiales(event)' type="text" name="n_casa" id="edit_d_n_casa" class="form-control " placeholder="N° de Casa" maxlength = "255">
						</div>
					</div>

					<div class="form-group">
						<label >Región</label>
						<select name="region"  id="edit_d_region" data-dir="direccionRegion" class="form-control" attr1="{ {route('provincias.por.region')}}" onchange="seleccionarRegionFormularioDirecciones();">
							<option selected value="">Elegir región</option>
							@foreach($regiones AS $region)
								<option value="{{ $region->reg_id }}" >{{ $region->reg_nom }}</option>
							@endforeach
						</select>
						<p id="val_edit_d_region" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe escoger una región.</p>
					</div>
					<div class="form-group"  >
						<label >Provincia</label>
						<select name="Provincia"  id="edit_d_provincia" data-dir="direccionProvincia" class="form-control" attr1="{ {route('comunas.por.provincia')}}" onchange="seleccionarProvinciaFormularioDirecciones();">
							<option selected value="">Elegir provincia</option>
							@foreach($provincias AS $provincia)
								<option value="{{ $provincia->pro_id }}" data-reg="{{ $provincia->reg_id }}">{{ $provincia->pro_nom }}</option>
							@endforeach
						</select>
						<p id="val_edit_d_provincia" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe escoger una provincia.</p>
					</div>
					<div class="form-group"  >
						<label >Comuna</label>
						<select name="comuna"  id="edit_d_comuna" data-dir="direccionComuna" class="form-control" onchange="seleccionarComunasFormularioDirecciones();">
							<option  value="">Elegir comuna</option>
							@foreach($comunas AS $comuna)
								<option value="{{ $comuna->com_id }}" data-pro="{{ $comuna->pro_id }}">{{ $comuna->com_nom }}</option>
							@endforeach
						</select>
						<input type="hidden" name="comuna_hide" id="run" value="{{ $comuna->com_id }}" >
						<p id="val_edit_d_comuna" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe escoger una comuna.</p>
					</div>

					<div class="form-group">
						<label >Prioridad (La prioridad 1 es la mas alta)</label>
						<input type="hidden" name="direcciones_count" id="form_dir_prio" value="{{ count($direcciones) }}" >
						<select name="prioridad" id="edit_d_prioridad" class="form-control" >
							<option value="">Escoja</option>
							@for ($i = 0; $i < count($direcciones)+1; $i++)
								<option attr1="" value="{{$i+1}}" >{{$i+1}}</option>
							@endfor
						</select>
						<p id="val_edit_d_prioridad" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe escoger una prioridad de la dirección.</p>
					</div>

					<div class="form-group">
							<label >Referencias o información adicional</label>
							<textarea onkeypress='return caracteres_especiales(event)' name="descripcion" id="edit_d_referencia" class="form-control " irows="3"></textarea>
					</div>

					<button type="submit" class="btn btn-primary" onclick="procesoDirecciones(1);">Guardar</button>

					
				</form>
			</div>

		</div>
	</div>
</div>