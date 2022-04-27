<div id="asignarTerapeutaModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="asignarTerapeutaModal" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content p-4">

			<div class="card p-4 shadow-sm">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h3><span class="oi oi-briefcase"></span> Asignar a Terapeuta</h3>
				<p>RUT: {{ number_format($caso->run,0,",",".")."-".($caso->dig)  }}</p>
				
				<p><b> * El caso puede ser asignado a un terapeuta para ejecutar el plan de acción</b></p>

				<hr>
				<form method="post" action="{{ route('coordinador.caso.asignar') }}"  >
					{{ csrf_field() }}
					<input type="hidden" name="id_caso" value="{{ $caso->cas_id }}" >
					<input type="hidden" name="run" value="{{ $caso->run }}" >
					<input type="hidden" name="origen" value="{{ $origen }}" >
					<div class="form-group">
						<label>Terapeuta</label>
						<select class="form-control form-control" style="height: auto;" name="terapeuta_id" required>
							<option value="" >Seleccione Terapeuta</option>
							@foreach( $terapeutas as $terapeuta)
								<option value="{{$terapeuta->id}}" >{{$terapeuta->nombre}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<textarea rows="5" required type="text" name="comentario" class="form-control" placeholder="Comentario" aria-label="Comentario"></textarea>
					</div>
					<br>
				<input type="submit" class="btn btn-primary" value="Asignar a terapeuta">
				</form>
			</div>
		</div>
	</div>
</div>