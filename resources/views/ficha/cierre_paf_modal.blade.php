<div id="cierrePAFmodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="asignarTerapeutaModal" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content p-4">

			<div class="card p-4 shadow-sm">
				<button style="position: absolute; right: 5px; top: 5px; width: 23px; height: 23px; padding: 0; margin: 0;" type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				@if (count($titulos_modal) >= 4)
					<h3 class="modal-title" id="title_cierre" data-id-est="{{ $titulos_modal[3]->id_est }}">{{ $titulos_modal[3]->titulo }}</h3>
				@else
					<h3 class="modal-title" id="title_cierre" data-id-est=""></h3>
				@endif

				<p>RUT: {{ number_format($caso->run,0,",",".")."-".($caso->dig)  }}</p>

				<h6 class="modal-title" id="mod-paf-nom"><b>Fecha de Inicio: 12/03/2019 - Fecha Estimada de Tiempo: 15/04/2019 </b></h6>
				<hr>

				{{ csrf_field() }}

	       	    <div class="modal-body">
					<div>
						<label for="bitacora_estado_cierre" style="font-weight: 800;">Comentario Cierre:</label>
						<textarea class="form-control txtAreEtapa" name="bit-etapa-cierre" id="bitacora_estado_cierre" rows="3" onBlur="cambioEstadoCaso(6, {{ $caso->cas_id }}, $(this).val());"
								  @if (config('constantes.en_cierre_paf')  != $estado_actual_caso) disabled @endif>{{ $bitacoras_estados[3] }}</textarea>
					</div>
					<!--<div class="form-row">
						<div class="form-group col-md-6">
							<label ><b> Cerrar PAF </b> <input name="nec_ter" onclick="" class="nec_ter" type="checkbox" value="1" /> </label>
							<br />
						</div>
					</div>



  					<div class="modal-body">
						<div class="form-group">
						<label for="comment">Comentario:</label>
						<textarea class="form-control" rows="5" id="comment" placeholder="Escribe tu comentario aquí."></textarea>
						</div>

						</div>

					<button  type="button" class="btn btn-primary float-right" data-dismiss="modal">Grabar</button>
					<br><br>-->


				<hr>

				<div class="form-group">
					<label for="comment"><b>NTFAS - G</b></label><br>
					<a href="{{ route('caso.diagnostico',[ 'ficha' => $caso->cas_id]) }}" class="btn btn-warning" style="width: 187px;">Aplicar NCFAS - G</a>
					<br>

					<table class="table table-bordered table-hover dataTable no-footer">
						<thead>
							<br>
						</thead>
						<tbody>
							<tr>
								<td class="text-left"style="width:15px" ><span class="oi oi-circle-check"></span></td>
								<td class="text-left" style="width:260px">NCFAS - G</td>
								<td class="text-center" >Realizado</td>
								<td class="text-center" ><span class="oi oi-eye"></span></td>	
							</tr>
						</tbody>
		   			</table>

				</div>



					
				<hr>

				<div class="form-group">
					<label for="comment"><b>Encuesta de Satisfacción</b></label><br>

					<br>

								<table class="table table-bordered table-hover dataTable no-footer">
						<tbody>
						
						<tr>
							<td class="text-left" style="width:15px"><span class="oi oi-circle-check"></span></td>
							<td class="text-left" style="width:260px">Subir Encuesta de Satifacción</td>
							<td class="text-center" >Por Iniciar</td>
							<td class="text-center" ><span class="oi oi-arrow-circle-top"></span></td>	
						</tr>

						</tbody>
		   	</table>

				</div>
				<br>

	</div>

		</div>
			<div class="modal-footer card text-white bg-secondary">
				<button type="button" id="btn-etapa-cierre" class="btn btn-success btn-sm btnEtapa" style="float: right;" onclick="siguienteEtapa(11, {{ $caso->cas_id }});"
				@if (config('constantes.rechazado_por_familiares') == $estado_actual_caso || config('constantes.rechazado_por_gestor') == $estado_actual_caso ||
				config('constantes.en_cierre_paf') != $estado_actual_caso) disabled @endif >Ir a siguiente etapa - Seguimiento PAF</button>
			</div>
		</div>
	</div>
</div>





