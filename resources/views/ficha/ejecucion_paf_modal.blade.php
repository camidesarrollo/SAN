<div id="ejecucionPAFmodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="asignarTerapeutaModal" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content ">
			<div class="card p-4 shadow-sm">

				<button type="button" class="close" data-dismiss="modal" style="position: absolute; right: 5px; top: 5px; width: 23px; height: 23px; padding: 0; margin: 0;">&times;</button>
				@if (count($titulos_modal) >= 3)
					<h3 class="modal-title" id="title_ejecucion" data-id-est="{{ $titulos_modal[2]->id_est }}">{{ $titulos_modal[2]->titulo }}</h3>
				@else
					<h3 class="modal-title" id="title_ejecucion" data-id-est=""></h3>
				@endif

				<p>RUT: {{ number_format($caso->run,0,",",".")."-".($caso->dig)  }}</p>
				<hr>

			

				<!-- <h6 class="modal-title" id="mod-paf-nom"><b>Fecha de Inicio: 12/03/2019 - Fecha Estimada de Tiempo: 15/04/2019 </b></h6> -->

				@php  

				$alertas = Helper::get_alertas($caso->cas_id);

				$ofertas = Helper::get_ofertas($alertas);

				@endphp


				@foreach ($alertas as $ale_tip)

				<div class="modal-body" id="mod-paf-des">

				<table class="table table-bordered table-hover dataTable no-footer">
					<thead>
						<tr role="row">
							<th aria-controls="tabla_alertas" colspan="5">{{$ale_tip->ale_tip_nom}} </th>
						</tr>
					</thead>
						<tbody>
						<tr style="background-color:#C3C3C3;">
							<td class="text-center" >Componente</td>
							<td class="text-center" >Responsable</td>
							<td class="text-center" >Institución</td>
							<td class="text-center" >Estado</td>
						</tr>

					
					@php $ofe_existe=0; @endphp

					 @foreach ($ofertas as $ofe) 
					    @if($ofe->ale_man_id==$ale_tip->ale_man_id)
					
						@php $ofe_existe=1; @endphp

						<tr>
							<td class="text-center" >{{$ofe->ofe_nom}}</td>
							<td class="text-center" >{{$ofe->nombres}} {{$ofe->apellido_paterno}}</td>
							<td class="text-center" >{{$ofe->nom_ins}}</td>
							<td class="text-center" >PENDIENTE</td>
						</tr>

						@endif
					@endforeach

					@if($ofe_existe==1)
                        <!-- <tr role="row" class="odd"> 
                            <td class=" text-left" colspan="5" >
                              <span style="color:red"><b></b></span>
                            </td>
                        </tr> -->
                    @endif
						
					</tbody>
		   		</table>

		   		</div>

		   		@endforeach

			<!-- 	<div class="form-group">
					<label for="comment">Comentario:</label>
					<textarea class="form-control" rows="5" id="comment" placeholder="Escribe tu comentario aquí."></textarea>
				</div> -->

	

<!-- 		<div class="modal-body" id="mod-paf-des">
			<table class="table table-bordered table-hover dataTable no-footer">
				<thead>
					<tr role="row">
						<th aria-controls="tabla_alertas" colspan="5">Terapia</th>
					</tr>
				</thead>
						<tbody>
						<tr style="background-color:#C3C3C3;">
							<td class="text-center" >#</td>
							<td class="text-center" >Etapa</td>
							<td class="text-center" >Estado</td>
							<td class="text-center" >Acciones</td>
						</tr>
						<tr>
							<td class="text-left" ><span class="oi oi-circle-check"></span></td>
							<td class="text-left" >Invitación a Etapa Familiar</td>
							<td class="text-center" >Realizado</td>
							<td class="text-center" ><span class="oi oi-eye"></span></td>	

						</tr>

						<tr>
							<td class="text-left" ><span class="oi oi-caret-right"></span></td>
							<td class="text-left" >Plan de Terapia Familiar</td>
							<td class="text-center" >Por Iniciar</td>
							<td class="text-center" ><span class="oi oi-eye"></span></td>
						</tr>

						<tr>
							<td class="text-left" ><span class="oi oi-caret-right"></span></td>
							<td class="text-left" >Sesiones Realizadas</td>
							<td class="text-center" >Por Iniciar</td>
							<td class="text-center" ><span class="oi oi-eye"></span></td>
						</tr>
						<tr>
								<td class="text-left" ><span class="oi oi-caret-right"></span></td>
							<td class="text-left" >Cierre Plan de Terapia Familiar</td>
							<td class="text-center" >Por Iniciar</td>
							<td class="text-center" ><span class="oi oi-eye"></span></td>
						</tr>
						<tr>
								<td class="text-left" ><span class="oi oi-caret-right"></span></td>
							<td class="text-left" >Egreso Plan de Terapia Familiar</td>
							<td class="text-center" >Por Iniciar</td>
							<td class="text-center" ><span class="oi oi-eye"></span></td>
						</tr>
						<tr>
							<td class="text-left" ><span class="oi oi-caret-right"></span></td>
							<td class="text-left" >Encuesta de Satifacción</td>
							<td class="text-center" >Por Iniciar</td>
							<td class="text-center" ><span class="oi oi-clipboard

"></span></td>	

						</tr>
						
				</tbody>
		   	</table>
		</div> -->

		<!-- 	<div class="modal-footer" style="background:#cde9ef;">
				<button type="button" class="btn btn-primary" data-dismiss="modal">Guardar</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		 -->	
		<hr> 
	       	  <div class="modal-body">
					<div class="form-row">
						<div class="form-group col-md-6">

					@if($terapeuta!=null)
						<h6><b>Terapeuta Asignado:</b></h6>
						<h5>{{ $terapeuta }}</h5>
						<hr>
					@else
						<h6>Sin Terapeuta Asignado</h6>
						<h5></h5>
						<hr>
					@endif						
						<br/>
						</div>
					</div>
		       </div>

		
			<div>
				<label for="bitacora_estado_ejecucion" style="font-weight: 800;">Bitacora Estado Actual del Caso:</label>
				<textarea class="form-control txtAreEtapa" name="bit-etapa-ejecucion" id="bitacora_estado_ejecucion" rows="3" onBlur="cambioEstadoCaso(5, {{ $caso->cas_id }}, $(this).val());"
			    @if (config('constantes.en_ejecucion_paf')  != $estado_actual_caso) disabled @endif>{{ $bitacoras_estados[2] }}</textarea>
			</div>
		
		</div>
		<div class="modal-footer card text-white bg-secondary">
			<button type="button" class="btn btn-warning btn-sm btnRechEst" data-dismiss="modal" onclick="comentarioEstado(1, {{ $caso->cas_id }});"
					@if (config('constantes.rechazado_por_familiares') == $estado_actual_caso || config('constantes.rechazado_por_gestor') == $estado_actual_caso) disabled @endif >
				Rechazado por Familia
			</button>
			<button type="button" class="btn btn-danger btn-sm btnRechEst" data-dismiss="modal" onclick="comentarioEstado(2, {{ $caso->cas_id }});"
					@if (config('constantes.rechazado_por_familiares') == $estado_actual_caso || config('constantes.rechazado_por_gestor') == $estado_actual_caso) disabled @endif >
				Rechazado por Gestor
			</button>
			<button type="button" id="btn-etapa-ejecucion" class="btn btn-success btn-sm btnEtapa" style="float: right;" onclick="siguienteEtapa(10, {{ $caso->cas_id }});"
			@if (config('constantes.rechazado_por_familiares') == $estado_actual_caso || config('constantes.rechazado_por_gestor') == $estado_actual_caso ||
			config('constantes.en_ejecucion_paf') != $estado_actual_caso ) disabled @endif >Ir a siguiente etapa - Cierre PAF</button>
		</div>
	</div>
</div>
</div>