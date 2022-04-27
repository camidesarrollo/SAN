<div id="editarContactoModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="diagnosticarModal" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content p-4">
			<div class="modal-header">
				<h3><i class="fa fa-phone"></i> Editar contacto </h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" name="editarContactoForm" action="{{ route('coordinador.caso.editar.contacto') }}" onsubmit="return validacionFormularioEditarContacto();">
					<div class="form-row">
						{{ csrf_field() }}
						<input type="hidden" name="origen" value="{{$origen_info_nna}}" >
						<input type="hidden" name="contact_id" id="contact_id">
						<input type="hidden" name="run" value="{{$caso->run}}" >
						<div class="form-group col-md-6">
							<label >Nombres</label>
							<input onkeypress='return caracteres_especiales(event)'  type="text" name="nombres" id="edit_c_nombres" class="form-control "  placeholder="Nombres" maxlength = "45">
							<p id="val_edit_c_nombres" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe escribir un nombre.</p>
						</div>
						<div class="form-group col-md-6">
							<label >Primer Apellido</label>
							<input onkeypress='return caracteres_especiales(event)'  type="text" name="paterno" id="edit_c_paterno" class="form-control " placeholder="Primer Apellido" maxlength = "45">
							<p id="val_edit_c_paterno" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe escribir el Primer Apellido.</p>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label>Segundo Apellido</label>
							<input onkeypress='return caracteres_especiales(event)'  type="text" name="materno" id="edit_c_materno" class="form-control " placeholder="Segundo Apellido" maxlength = "45">
							<p id="val_edit_c_materno" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe escribir el Segundo Apellido.</p>
						</div>
						<div class="form-group col-md-6"  >
							<label >Teléfono</label>

					<input onkeypress='return caracteres_especiales(event)' onkeyup="if (!/^([0-9])*$/.test(this.value)) this.value = this.value.replace(/\D/g,'')"  type="text" name="telefono" id="edit_c_telefono" class="form-control " placeholder="Teléfono" maxlength = "12">
					<p id="val_edit_c_telefono" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe escribir un número de teléfono.</p>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label >Parentesco</label>

								<select name="parentesco" id="edit_c_parentesco" class="form-control" required>
								  <option value="1">Jefe(a) de Hogar</option>
								  <option value="2">Cónyuge o pareja</option>
								  <option value="3">Hijo(a) de ambos</option>
								  <option value="4">Hijo(a) sólo del Jefe(a) de hogar</option>
								  <option value="5">Hijo(a) sólo del cónyuge o pareja</option>
								  <option value="6">Padre o madre</option>
								  <option value="7">Suegro o Suegra</option>
								  <option value="8">Yerno o nuera</option>
								  <option value="9">Nieto(a)</option>
								  <option value="10">Hermano(a)</option>
								  <option value="11">Cuñado(a)</option>
								  <option value="12">Otro familiar</option>
								  <option value="13">No familiar</option>
								</select>
								<p id="val_edit_c_parentesco" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe ingresar una prioridad.</p>
							<!-- <input required name="parentesco" type="text" class="form-control" placeholder="Parentesco"> -->
							<input name="per_id" type="hidden" value="{{$caso->per_id}}" >
						</div>
						<!--@ if($origen!=1)-->
							<div class="form-group col-md-6">
								<label >Prioridad (La prioridad 1 es la mas alta)</label>
								<input type="hidden" name="contactos_count" value="{{ count($contactos) }}" >
								<select name="prioridad" id="edit_c_prioridad" class="form-control" >
									<option value="" selected>Escoja</option>
									@for ($i = 0; $i < count($contactos)+1;$i++)
										<option value="{{$i+1}}" >{{$i+1}}</option>
									@endfor
								</select>
							</div>
						<!--@ endif-->

					</div>

					<button type="submit" class="btn btn-primary"  >Guardar</button>
				</form>
			</div>


		</div>
	</div>
</div>