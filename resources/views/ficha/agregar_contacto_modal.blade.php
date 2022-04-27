<div id="agregarContactoModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="diagnosticarModal" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content p-4">
			<div class="modal-header">
				<h3><i class="fa fa-phone"></i> Agregar contacto </h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			
			<div class="modal-body">
				<form method="post" id="agregarContactoForm" action="{{ route('coordinador.caso.agregar.contacto') }}" >
					<div class="form-row">
						{{ csrf_field() }}
						<!-- INICIO CZ SPRINT 67 -->
						<input type="hidden" name="cas_id" value="{{$caso->cas_id}}" >
						<!-- FIN CZ SPRINT 67 -->
						<input type="hidden" name="run" value="{{$caso->run}}" >
						<div class="form-group col-md-6">
							<label >Fuente</label>
							<input onkeypress='return caracteres_especiales(event)'  type="text" name="fuente" id="form_contac_fuente" class="form-control "  placeholder="Fuente">
							<p id="val_form_contac_fuente" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe escribir una Fuente.</p>
						</div>
						<div class="form-group col-md-6">
							<label >Nombre completo</label>
							<input onkeypress='return caracteres_especiales(event)'  type="text" name="nombrecomp" id="form_contac_nombrecomp" class="form-control " placeholder="Nombre completo">
							<p id="val_form_contac_nombrecomp" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe escribir el Nombre completo.</p>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label >Teléfono</label>

					<input onkeypress='return caracteres_especiales(event)' onkeyup="if (!/^([0-9])*$/.test(this.value)) this.value = this.value.replace(/\D/g,'')"  type="text" name="telefono" id="form_contac_telefono" class="form-control " placeholder="Teléfono" maxlength="9">
					<p id="val_form_contac_telefono" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe escribir un número de teléfono.</p>
						</div>
						<div class="form-group col-md-6">
							<label >Tipo número</label>

								<select name="tipo_num" class="form-control" required>
								  <option value="0">Sin información</option>
								  <option value="1">Teléfono</option>
								  <option value="2">Celular</option>
								</select>
							<!-- <input required name="parentesco" type="text" class="form-control" placeholder="Parentesco"> -->
						</div>

					</div>
					<div class="form-row">
						<div class="form-group col-md-6"  >
							<label >Comuna</label>
							<select name="comuna" id="form_contac_comuna" data-dir="direccionComuna" class="form-control">
								<option  value="">Elegir comuna</option>
								@foreach($comunas AS $comuna)
									<option value="{{ $comuna->com_cod }}" data-pro="{{ $comuna->pro_id }}">{{ $comuna->com_nom }}</option>
								@endforeach
							</select>
							<p id="val_form_contac_comuna" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe escoger una Comuna.</p> 
					
						</div>
						<div class="form-group col-md-6"  >
							<label style="margin-left: 13px;">Categoría</label>
							{{ Form::select('size', array(1 => 'Sin chequear', 2 => 'Número SI Corresponde', 
														3 => 'Número NO existe', 4 => 'Número No contesta o apagado',
														5 => 'Número NO corresponde a contacto de la familia',
														6 => 'Número contesta pero rechazan las llamadas'),0,
														array('class' => 'form-control select2me', 'style'=>'max-width:80%;font-size: 0.9em;', 
														'data-placeholder' => 'Seleccione...',
														'name' => 'id_categoria'
							
														)) 
												}}						
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label >Parentesco</label>

								<select name="parentesco" class="form-control" required>
								  <option value="JEFE(A) HOGAR">Jefe(a) de Hogar</option>
								  <option value="CONYUGE O PAREJA">Cónyuge o pareja</option>
								  <option value="HIJO(A) DE AMBOS">Hijo(a) de ambos</option>
								  <option value="HIJO(A) SOLO DEL JEFE DE HOGAR">Hijo(a) sólo del Jefe(a) de hogar</option>
								  <option value="HIJO(A) SOLO DEL CONYUGE O PAREJA">Hijo(a) sólo del cónyuge o pareja</option>
								  <option value="PADRE O MADRE">Padre o madre</option>
								  <option value="SUEGRO O SUEGRA">Suegro o Suegra</option>
								  <option value="YERNO O NUERA">Yerno o nuera</option>
								  <option value="NIETO(A)">Nieto(a)</option>
								  <option value="HERMANO(A)">Hermano(a)</option>
								  <option value="CUÑADO(A)">Cuñado(a)</option>
								  <option value="OTRO FAMILIAR">Otro familiar</option>
								  <option value="NO FAMILIAR">No familiar</option>
								</select>
							<!-- <input required name="parentesco" type="text" class="form-control" placeholder="Parentesco"> -->
							<input name="per_id" type="hidden" value="{{$caso->per_id}}" >
							<input name="periodo" type="hidden" value="<?php echo(date('Ym'))?>" >
						</div>
						<!--@ if($origen!=1)-->
							<div class="form-group col-md-6">
								<label >Tipo dato</label>

									<select name="tipo_dato" class="form-control" required>
									<option value="1">Persona</option>
									<option value="2">Institución</option>
								</select>	
								<!-- <label >Prioridad (La prioridad 1 es la mas alta)</label>
								<input type="hidden" name="contactos_count" value="{{ count($contactos) }}" >
								<select name="prioridad" class="form-control" id="form_contac_prioridad" >
									<option value="" selected>Escoja</option>
									@for ($i = 0; $i < count($contactos)+1;$i++)
										<option value="{{$i+1}}" >{{$i+1}}</option>
									@endfor
								</select>
								<p id="val_form_contac_prioridad" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe ingresar una prioridad.</p> -->
						</div>
							</div>
						<!--@ endif-->


					</div>

					<!--<button type="submit" class="btn btn-primary"  >Agregar</button><br>-->
					
				</form>
				<button id="btnEnviar" onclick="envioForm()" class="btn btn-primary"  >Enviar</button>
			</div>


		</div>
	</div>
</div>
<script type="text/javascript" >
	function envioForm(){
		valida = validacionFormularioContacto();
		form = $("#agregarContactoForm");
		var btnEnviar = $("#btnEnviar");
		if(valida){
			form.submit();

		}
	}
</Script>
