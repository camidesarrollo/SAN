<h5><span class="fa fa-map mr-2"></span> Información Territorial Caso</h5>
	<div class="card p-4">
		<!-- DIRECCIONES--->
        <div class="row">
          <div class="col">
          	@if (count($direcciones) == 0)
      		      <table class="table bg-light">
						<thead>
							<tr>
								<th>Dirección principal</th>
								<th>Ubicación</th>
								<th>Acción</th>
							</tr>
						</thead>
						
						<tbody>
							<tr>
								<td class="text-center" colspan="2">No se encuentra información de dirección principal del NNA.</td>
							</tr>
						</tbody>		
				  </table>
				  <table class="table bg-light" id="posicionMapa">
						<thead>
							<tr>
								<th>Direcciones alternativas</th>
								<th>Ubicación</th>
								<th>Acción</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="text-center" colspan="2">No se encuentra información de direcciones alternativas del NNA.</td>
							</tr>
						</tbody>
				 </table>	
          	@elseif (count($direcciones) > 0)
          		 @foreach ($direcciones AS $c1 => $v1)
	          	     @if ($c1 == 0)
	      	    		<table class="table bg-light">
							<thead>
								<tr>
									<th>Dirección principal</th>
									<th>Fuente</th>
									<th>Fecha Actualización</th>
									<th>Ubicación</th>
									<th>Acción</th>
									<th>Estado</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>
									 {{ $v1->dir_call  }} {{$v1->dir_num }},
									 @if ($v1->dir_dep!=null)
										 N° Depto/casa {{$direcciones[0]->dir_dep}} ,
									 @endif

									 {{$v1->comunas->com_nom}},
									 {{$v1->comunas->provincias->pro_nom}},
									 {{$v1->comunas->provincias->regiones->reg_nom}}.
				
									</td>
									<td>
										@if (!is_null($v1->dir_fue) && $v1->dir_fue  != "")
		                                      {{ $v1->dir_fue }}.
		                                  @else
		                                      Sin información.
		                                  @endif
									</td>
									<td>
										 @if (!is_null($v1->dir_fecha) && $v1->dir_fecha  != "")
		                                  @php
											$fecha_act_dir  = date("d/m/Y", strtotime($v1->dir_fecha));
											@endphp
		                                     {{ $fecha_act_dir }}.
		                                  @else
		                                    Sin información.  
		                                  @endif
									</td>
									<td>
										<a href="#posicionMapa" class="btn btn-primary cargarMapa ccolor" data-src="{{ $mapaUrl }}"  name="mapa_boton[]"  value="fav_HTML" data-direccion="{{ $v1->completa }}" ><span class="fas fa-map-marker-alt mr-2"></span> Ubicar en Mapa</a>
									</td>
									<td>@if($est_cas_fin != 1)
										<button type="button" 
										
											@if ($editar)													
												@if(config("constantes.activar_maestro_direcciones"))
													@if($v1->dir_cod_id == null)
													class="btn btn-success disabled" data-toggle="tooltip" title="Se recomienda ingresar una nueva dirección"
													@else
													class="btn btn-primary edita_direccion" onclick="wgFormularioDireccionesEditar(1,'{{$v1->dir_cod_id}}', {{$v1->dir_id}});" 
													@endif
												@else
													data-toggle="modal" class="btn btn-primary edita_direccion" onclick="levantarFormularioDirecciones(1, {{$v1->dir_id}});" 
												@endif
											@else
												class="btn btn-success disabled"
											@endif
											><i class="fa fa-edit"></i> Editar dirección
										</button>
										@else
										<button type="button" data-toggle="modal" class="btn btn-primary edita_direccion" disabled><i class="fa fa-edit"></i> Editar dirección
										</button>
										@endif
									</td>
									<td>
									<!-- INICIO CZ SPRINT 60-->
										@if(isset($caso->cas_id))
											@if($est_cas_fin != 1) <!-- CASO NO FINALIZADO-->
										@if($v1->dir_status == 1)
												<input id="direccion_{{$c1}}" type="checkbox" name="estado" value="1" checked="checked" onclick="actualizarEstado('{{$v1->dir_id}}', $(this).val(), 'direccion_{{$c1}}');"/><label id="textoEstado_{{$c1}}">Actual</label>
										@else
													<input id="direccion_{{$c1}}" type="checkbox" name="estado" value="0"  onclick="actualizarEstado('{{$v1->dir_id}}', $(this).val(), 'direccion_{{$c1}}');" /><label id="textoEstado_{{$c1}}"></label>
												@endif
											@else

												@if($v1->dir_status == 1)
													Actual
										@endif
									@endif
										@endif
									<!-- FIN CZ SPRINT 60 -->
									</td>
								</tr>
							</tbody>
						</table>
	          	     @else 
	      	    		@if ($c1 == 1)
		          	    	<table class="table bg-light" id="posicionMapa">
								<thead>
									<tr>
										<th>Direcciones alternativas</th>
										<th>Fuente</th>
										<th>Fecha Actualización</th>
										<th>Ubicación</th>
										<th>Acción</th>
										<th>Estado</th>
									</tr>
								</thead>
								<tbody>
						@endif
									<tr>
										<td>
										 {{ $v1->dir_call  }} {{ $v1->dir_num }},
										 @if ($v1->dir_dep != null)
											N° Depto/casa {{ $v1->dir_dep }} ,
										 @endif
										
										 {{ $v1->comunas->com_nom }},
										 {{ $v1->comunas->provincias->pro_nom }},
										 {{ $v1->comunas->provincias->regiones->reg_nom }}.

										</td>
										<td>
											@if (!is_null($v1->dir_fue) && $v1->dir_fue  != "")
			                                      {{ $v1->dir_fue }}.
			                                  @else
			                                      Sin información.
			                                  @endif 
										</td>
										<td>
											@if (!is_null($v1->dir_fecha) && $v1->dir_fecha  != "")
			                                  @php
												$fecha_act_dir  = date("d/m/Y", strtotime($v1->dir_fecha));
												@endphp
			                                     {{ $fecha_act_dir }}.
			                                  @else
			                                    Sin información.  
			                                  @endif
										</td>
										<td>
											<a href="#posicionMapa" class="btn btn-primary cargarMapa ccolor" data-src="{{ $mapaUrl }}"  name="mapa_boton[]"  value="fav_HTML" data-direccion="{{ $v1->completa }}"><span class="fas fa-map-marker-alt mr-2"></span> Ubicar en Mapa</a>
										</td>
										<td>
										@if($est_cas_fin != 1)
										<button type="button" 
												@if ($editar)													
													@if(config("constantes.activar_maestro_direcciones"))
														@if($v1->dir_cod_id == null)
														class="btn btn-success disabled" data-toggle="tooltip" title="Se recomienda ingresar una nueva dirección"
														@else
														class="btn btn-primary edita_direccion" onclick="wgFormularioDireccionesEditar(1,'{{$v1->dir_cod_id}}', {{$v1->dir_id}});" 
														@endif
													@else
														data-toggle="modal" class="btn btn-primary edita_direccion" onclick="levantarFormularioDirecciones(1, {{$v1->dir_id}});" 
													@endif
												@else
													class="btn btn-success disabled"
												@endif
												><i class="fa fa-edit"></i> Editar dirección
											</button>
											@else
											<button type="button" disabled data-toggle="modal" class="btn btn-primary edita_direccion"><i class="fa fa-edit"></i> Editar dirección
											</button>
											@endif
									</td>
									<td>
										<!-- INICIO CZ SPRINT 60-->
										@if(isset($caso->cas_id))
											@if($est_cas_fin != 1)
										@if($v1->dir_status == 1)
												<input id="direccion_{{$c1}}" type="checkbox" name="estado" value="1" checked="checked" onclick="actualizarEstado('{{$v1->dir_id}}', $(this).val(), 'direccion_{{$c1}}');"/><label id="textoEstado_{{$c1}}">Actual</label>
													@else
													<input id="direccion_{{$c1}}" type="checkbox" name="estado" value="0"  onclick="actualizarEstado('{{$v1->dir_id}}', $(this).val(), 'direccion_{{$c1}}');" /><label id="textoEstado_{{$c1}}"></label>
												@endif
										@else
												@if($v1->dir_status == 1)
													Actual
												@endif
										@endif
									@endif

										<!-- FIN CZ SPRINT 60 -->
									</td>
									</tr>
						@if ((count($direcciones) - 1) == $c1)
								</tbody>
							</table>
						@endif
	          	     @endif
    			 @endforeach
          	@endif
          </div>
        </div>
        <hr>
        <!-- DIRECCIONES--->

        <!-- BOTON AGREGAR DIRECCION--->	
      	<div class="row">
          <div class="col">
		  		@if($est_cas_fin != 1)
				
				<button data-toggle="modal" type="button" 
				@if ($origen_info_nna == 'PREDICTIVO')
					 class="btn btn-success disabled"
				@else
					@if(config("constantes.activar_maestro_direcciones"))
					class="btn btn-success" id="limpiaModalDireccion" onclick="wgFormularioDirecciones(0)"
					@else
					class="btn btn-success" data-target="#agregarDireccionModal" id="limpiaModalDireccion" onclick="levantarFormularioDirecciones(0);"
					@endif
				@endif
					><i class="fa fa-plus-circle"></i> Agregar dirección
				</button>
				@endif
          </div>
        </div>
        <hr>
        <!-- BOTON AGREGAR DIRECCION--->
		@if(!isset($caso->cas_id))
        @if (count($direcciones_adicionales) == 0)
        		<table class="table bg-light">
						<thead>
							<tr>
								<th>Direcciones adicionales</th>
								<th>Ubicación</th>
								<th>Acción</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="text-center" colspan="2">No se encuentra información de dirección adicional del NNA.</td>
							</tr>
						</tbody>		
				  </table>
			   <hr>
	    @elseif(count($direcciones_adicionales) > 0)
	    		<table class="table bg-light">
							<thead>
								<tr>
									<th>Direcciones adicionales</th>
									<th>Referencia</th>
									<th>Información Adicional</th>
									<th>Ubicación</th>
								</tr>
							</thead>
							<tbody>
							@foreach ($direcciones_adicionales AS $dir)
								<tr>
									<td>{{$dir->dir_calle}} {{$dir->dir_num}},
										@if ($dir->dir_dpto!=null)
										 N° Depto/casa {{$dir->dir_dpto}} ,
									 	@endif

									 	{{ucwords(mb_strtolower($dir->com_nom))}},
									 	{{ucwords(mb_strtolower($dir->pro_nom))}},
									 	{{ucwords(mb_strtolower($dir->reg_nom))}}.
									</td>
									<td>{{$dir->dir_referencia}}</td>
									<td>{{$dir->dir_info_adicional}}</td>
									<td>
										<a href="#posicionMapa" class="btn btn-primary cargarMapa ccolor" data-src="{{$mapaUrl}}"  name="mapa_boton[]"  value="fav_HTML" data-direccion="{{$dir->dir_calle.' '.$dir->dir_num.', '. $dir->com_nom.', '.$dir->pro_nom.', '.$dir->reg_nom}}" ><span class="fa fa-map-marker-alt mr-2"></span> Ubicar en Mapa</a>
									</td>
								</tr>
							@endforeach
							</tbody>
						</table>
						<hr>
	  	@endif
		@endif
        <!-- MAPA -->
        <div class="row">
          <div class="col" id="mapa">
            <iframe id="iframeMapa" src="{{ $mapaUrl }}" width="100%" height="600px" frameborder="0" style="border:0"></iframe>
          </div>
        </div>
        <!-- MAPA -->

        <!--<div class="row">
				<div class="col">
					<h5>Servicios cercanos</h5>
					<table class="table bg-light">
						<thead>
						<tr>
							<th scope="col">Servicio</th>
							<th scope="col">Tipo</th>
							<th scope="col">Horario</th>
						</tr>
						</thead>
						<tbody>
						<tr>
							<td>CESFAM </td>
							<td>Salud</td>
							<td>7:00 - 18:000</td>
						</tr>
						<tr>
							<td>Jardin Junji </td>
							<td>Educación</td>
							<td>7:00 - 14:000</td>
						</tr>
						<tr>
							<td>Comisaría </td>
							<td>Seguridad</td>
							<td>6:00 - 22:000</td>
						</tr>
						</tbody>
					</table>
				</div>
			</div>-->
                            
	</div>
	@if (config('constantes.activar_maestro_direcciones'))
		<input type="hidden" id="id" value="">
		<input type="hidden" id="id_dir" value="">
		<input type="hidden" id="per_id" value="{{$caso->per_id}}">
		<input type="hidden" id="form_dir_reg" value="">
		<input type="hidden" id="form_dir_pro" value="0">
		<input type="hidden" id="form_dir_com" value="">
		<input type="hidden" id="form_dir_call" value="">
		<input type="hidden" id="form_dir_num" value="">
		<input type="hidden" id="form_dir_dpto" value="">
		<input type="hidden" id="form_dir_bloc" value="">
		<input type="hidden" id="form_dir_cas" value="">
		<input type="hidden" id="form_dir_sit" value="">
		<input type="hidden" id="form_dir_ref" value="">
		<input type="hidden" id="form_dir_prio" value="{{ count($direcciones) }}">
		<input type="hidden" id="form_dir_prioridad" value="{{ count($direcciones) + 1}}">
		<input type="hidden" id="token" value="">
		<input type="hidden" id="url_ingreso_direccion" value="{{route('caso.agregar.direccion')}}">
		<input type="hidden" id="url_editar_direccion" value="{{route('coordinador.caso.editar.direccion')}}">		
		@includeif('alertas.modal_direcciones_alerta')
	@else
	@includeif('ficha.agregar_direccion_modal')
	@includeif('ficha.editar_direccion_modal')
	@endif


	<!-- INICIO CZ SPRINT 60 -->
	<script>
      function actualizarEstado(id, status, idCheckbox){
		  var SplitCheck = idCheckbox.split("_");
		var num = SplitCheck[1];
		bloquearPantalla();
		var actualizarStatus;
		var textoEstado ="";
		if( status == 0){
			actualizarStatus = 1;
			textoEstado = "Actual";
		}else{
			actualizarStatus = 0;
		}

        	let data = new Object();
			data.id = id;
			data.estado = actualizarStatus;
        $.ajax({
    			type: "GET",
    			url: "{{route('actualizar.estado.direccion')}}",
    			data: data
    		}).done(function(resp){
				desbloquearPantalla();
				if(resp.estado == "1"){
					toastr.success(resp.mensaje);
					
					$("#direccion_"+idCheckbox).val(actualizarStatus);
					$("#textoEstado_"+num).text(textoEstado);
					var inputChecked= $( "input:checked" );
			
					if(inputChecked.length > 1){
					
						for(var i=0;i<inputChecked.length;i++){
							
							var idCheckboxChecked = inputChecked[i].id;
							var idActualCheck = idCheckbox;
						
							if(idCheckboxChecked != idActualCheck){
								$("#"+inputChecked[i].id).prop( "checked", false );
								$("#"+inputChecked[i].id).val(0);
								var SplitCheck = inputChecked[i].id.split("_");
								$("#textoEstado_"+SplitCheck[1]).text("");
							}
						}
					}	
				}else{
					toastr.error(resp.mensaje);
				}
				// inputChecked.prop( "checked", false );
    		}).fail(function(objeto, tipoError, errorHttp){
				desbloquearPantalla();
				manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
				return false;
        });
        
      }
</script>
	<!-- FIN CZ SPRINT 60 -->