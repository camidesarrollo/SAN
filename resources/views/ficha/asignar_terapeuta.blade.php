			<div class="card p-4 shadow-sm">
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
						<textarea onkeypress='return caracteres_especiales(event)' rows="5" required type="text" name="comentario" class="form-control" placeholder="Comentario" aria-label="Comentario"></textarea>
					</div>
					<br>
				<input type="submit" class="btn btn-primary" value="Asignar a terapeuta">
				</form>
			</div>