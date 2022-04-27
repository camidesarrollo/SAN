<div id="asignarGestorModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="asignarGestorModal" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content p-4">

			<div class="card p-4 shadow-sm">
				<div class="row">
					<div class="col">
						<h5>Asignar a Gestor</h5>
						<small>El NNA puede ser asignado a un Gestor.</small>
					</div>
					<div class="col">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				</div>
				<hr>

				<form id="frm_asignar_gestor" name="frm_asignar_gestor" method="post" action="{{ route('coordinador.caso.asignar.gestor') }}" >
					{{ csrf_field() }}
					<input type="hidden" name="id_caso" id="id_caso" value="{{ $caso->cas_id }}" >
					<input type="hidden" name="nna"  id="nna" value="{{ $caso->run }}" >

					<input type="hidden" name="id_usu_anterior"  id="id_usu_anterior" value="{{$g_asig_id}}" >
					
					<div class="form-group">
						<label>Gestor</label>
						<select id="id_usu" class="form-control form-control" style="height: auto;" name="id_usu" required>
							<option value="" >Seleccione Gestor</option>
							@foreach( $gestores as $gestor)
								<option value="{{ $gestor->id }}" <?php if(($gestor->id)==($g_asig_id)) { echo "selected" ;  }  ?> >
									{{ $gestor->nombres." ".$gestor->apellido_paterno." ".$gestor->apellido_materno }}
								</option>
							@endforeach
						</select>
					</div>
					<br>
				<input type="button" class="btn btn-primary btn-lg" value="Asignar a Gestor" onclick="validarCantAsig();">
				</form>
			</div>
		</div>
	</div>
</div>