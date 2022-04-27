<h5><span class="fa fa-phone mr-2"></span>  Información Contactos</h5>
	
	<div class="card p-4">
		<div class="row">
			<div class="col">
				<strong>Familiares o Personas Cercanas</strong>
				<!-- BOTON AGREGAR CONTACTO -->
	
				@if($origen_contacto == 'aicontactoparentesco2' || $origen_info_nna == 'PERSONA')
					<button style="margin-left:26em;margin-bottom:1em" type="button" data-toggle="modal" class="btn btn-success" data-target="#agregarContactoModal" id="limpiaModalContacto">
						<i class="fa fa-plus-circle"></i> Agregar contacto
					</button>
				@endif
		
		<!-- BOTON AGREGAR CONTACTO -->
				@if (count($contact_parent) == 0)
					<table class="table bg-light">
							<thead>
								<tr>
									<th>Nombre</th>
									<th>Parentesco</th>
									<th>Número de Contacto</th>
									<th>Fuente</th>
									<th>Fecha Actualización</th>
									<th>Comuna</th>
									
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="text-center" colspan="2">
									No se encuentra información de contacto del NNA.</td>
								</tr>
							</tbody>
					</table>
				@elseif (count($contact_parent) > 0)
					<table class="table bg-light">
						<thead>
							<tr>
								<th>Nombre</th>
								<th>Parentesco</th>
								<th>Número de Contacto</th>
								<th>Fuente</th>
								<th>Fecha Actualización</th>
								<th>Comuna</th>
								@if (!$disabled)
									<th>Estado Contacto
									</th>
								@else <!-- nada -->
								@endif	
							</tr>
						</thead>
						<tbody>
							@foreach ($contact_parent AS $c1 => $v1)
								<tr>
										<td>
											{{ $v1->nombre_contacto }}
										</td>
										<td>
											{{ $v1->parentesco }}
										</td>	
										<td>
											{{ $v1->numero_contacto }}
										</td>	
										<td>
											{{ $v1->fuente }}
										</td>
										<td>
											<!--{{ $v1->fecha_ingreso }}-->
											@if($v1->fecha_ingreso == null || $v1->fecha_ingreso == 0)
												S/I
											@else
											<?php echo date("d/m/Y", strtotime($v1->fecha_ingreso)); ?>
											@endif
										</td>
										<td>
											@if($v1->com_nom == null)
												S/I
											@else
											{{ $v1->com_nom }}
											@endif	
										</td>	
										
										@if (!$disabled)													
											<td>
											{{ Form::select('size', array(1 => 'Sin chequear', 2 => 'Número SI Corresponde', 
														3 => 'Número NO existe', 4 => 'Número No contesta o apagado',
														5 => 'Número NO corresponde a contacto de la familia',
														6 => 'Número contesta pero rechazan las llamadas'),$v1->categoria,
														array('class' => 'form-control select2me', 'style'=>'max-width:80%;font-size: 0.9em;', 
														'data-placeholder' => 'Seleccione...',
														'id' => 'id_sel_parentesco_'.$v1->orden_contacto,
														'onChange' => 'cambiaCategoria('.$v1->orden_contacto.','.$v1->run.');'
														)) 
												}}
												</td>		
										@else
											
											<!--{{ Form::select('size', array(1 => 'Sin chequear', 2 => 'Número SI Corresponde', 
														3 => 'Número NO existe', 4 => 'Número No contesta o apagado',
														5 => 'Número NO corresponde a contacto de la familia',
														6 => 'Número contesta pero rechazan las llamadas'),1,
														array('class' => 'form-control select2me', 'style'=>'max-width:80%;font-size: 0.9em;', 
														'data-placeholder' => 'Seleccione...','disabled'=>'disabled',
														'id' => 'id_sel_parentesco_'.$v1->orden_contacto,
														'onChange' => 'cambiaCategoria('.$v1->orden_contacto.','.$v1->run.');'
														)) 
												}} -->

										@endif											
																	
								</tr>		
							@endforeach
						</tbody>	
					</table>						
				@endif
			</div> <!-- col -->
		</div> <!-- row -->	
		<div class="row">
			<div class="col">
			<strong>Instituciones</strong>
				@if (count($contact_insti) == 0)
					<table class="table bg-light">
							<thead>
								<tr>
									<th>Nombre</th>
									<th>Parentesco</th>
									<th>Número de Contacto</th>
									<th>Fuente</th>
									<th>Fecha Actualización</th>
									<th>Comuna</th>
									<th>Estado Contacto
									</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="text-center" colspan="2">No se encuentra información de contacto del NNA.</td>
								</tr>
							</tbody>
					</table>
				@elseif (count($contact_insti) > 0)
					<table class="table bg-light">
						<thead>
							<tr>
							<th>Nombre</th>
							<th>Parentesco</th>
							<th>Número de Contacto</th>
							<th>Fuente</th>
							<th>Fecha Actualización</th>
							<th>Comuna</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($contact_insti AS $c1 => $v1)
								<tr>
										<td>
											{{ $v1->nombre_contacto }}
										</td>
										<td>
											{{ $v1->parentesco }}
											
										</td>	
										<td>
											{{ $v1->numero_contacto }}
										</td>	
										<td>
											{{ $v1->fuente }}
										</td>
										<td>
											<!--{{ $v1->fecha_ingreso }}-->
											<?php echo date("d/m/Y", strtotime($v1->fecha_ingreso)); ?>
										</td>
										<td>
											{{ $v1->com_nom }}
										</td>	
								</tr>		
							@endforeach
						</tbody>	
					</table>						
				@endif					
			</div> <!-- col -->
		</div> <!-- row -->				
	</div> <!-- card p-4-->
<script type="text/javascript" >
	function cambiaCategoria(orden, runper){
		var valorSel = $('#id_sel_parentesco_'+orden).val();
		//alert('run '+runper+' orden: '+orden+' valor: '+valorSel);
		//alert(orden);
		let data = new Object();
		data.run = runper;
		data.orden = orden;
		data.value = valorSel;
		console.log(data);
		let confirmacion = confirm('¿Está seguro de cambiar Categoría?');

		if(confirmacion){
			console.log('entre');
			$.ajax({
			type: "GET",
			url: "{{route('coordinador.caso.actualiza.categoria')}}",
			data: data,
			}).done(function(resp){
			
				alert(resp);			

			}).fail(function(objeto, tipoError, errorHttp){

				manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
				return false;
			});
		} //confirmacion
	}
</Script>