<div id="rechazarModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="diagnosticarModal" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="card p-4 shadow-sm">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h3><span class="oi oi-circle-check"></span> Desestimar Caso </h3>
				<p>En esta sección podrá rechazar un caso si los familiares lo solicitan.</p>
				<hr>
				<form name="rechazar_formulario" method="post" action="{{ route('gestor.caso.rechazar') }}" >
					{{ csrf_field() }}
					<input type="hidden" name="id_caso" value="{{ $caso->cas_id }}" >
					<input type="hidden" name="origen" value="{{ $origen }}" >
					<input type="hidden" name="estado" value="{{ $caso->estado }}" >
					<input type="hidden" name="run" value="{{ $caso->run }}" >
					<input type="hidden" name="estado_rechazado" value="{{ config('constantes.estado_rechazado', '') }}" >

					<div class="form-group">
						<textarea onkeypress='return caracteres_especiales(event)' rows="5" required name="comentario" type="text" class="form-control"  placeholder="Comentario" aria-label="Comentario"></textarea>
					</div>
					<br>
					<input type="submit" class="btn btn-primary btn-lg" value="Desestimar Caso">
				</form>
			</div>
		</div>
	</div>
</div>