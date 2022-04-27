<div class="modal-body" style="overflow-y:auto;">
	<div class="card p-4 shadow-sm">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<h5> {{ Lang::get('messages.derivar.titulo') }} </h5>
		{{--<p>En esta sección podrá validar o desechar un caso respecto del análisis en terreno se haga del caso.</p>--}}
		<hr>
		<form name="derivar_form" id="derivar_form" method="post" action="{{ route('derivar.actualizar',['caso'=>$caso->cas_id]) }}" enctype="multipart/form-data" >
			{{ csrf_field() }}
			<input type="hidden" name="cas_id" value="{{ $caso->cas_id }}" >
			<input type="hidden" name="est_cas_id" value="{{ $caso->est_cas_id }}" >
			<div class="form-group">
				<label>{{ Lang::get('messages.derivar.terceros_label') }}</label>
				{{ Form::select('ter_id', $terceros, @$caso->terceros[0]->ter_id, ['ter_id'=>'ter_id','class'=>'form-control',$desabilitar]) }}
			</div>
			<div class="form-group">
				<textarea {{ $desabilitar }} onkeypress='return caracteres_especiales(event)' rows="6" name="cas_est_cas_des" type="text" class="form-control"  placeholder="Comentario" aria-label="Comentario">{{ @$estado_caso->pivot->cas_est_cas_des }}</textarea>
			</div>
			{{--<div class="form-group">
				<label for="exampleFormControlFile1">Cargar Archivo Adjunto</label><br>
				<small>Formato PDF, JPG, Excel, Word. Maximo 1mb cada uno.</small>
				<div class="custom-file">
					<input type="file" class="custom-file-input" id="adjunto" name="adjunto" lang="es" onchange="$(this).next().after().text($(this).val().split('\\').slice(-1)[0])">
					<label class="custom-file-label" for="adjunto">Seleccionar Adjunto</label>
				</div>
			</div>--}}
			<button {{ $desabilitar }} type="button" class="btn btn-primary btn-lg" id="btnGuardar" onclick="enviaFormSerialize('#derivar_form', '', 'derivarOk', '');">
				{{ Lang::get('messages.derivar.boton') }}
			</button>
		</form>
	</div>
</div>