<!-- INICIO CZ SPRINT 56 -->
<div id="estadoPrestacion" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="estadoPrestacionLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="p-4">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="estadoPrestacionLabel" style="width: 100%;">Estado Derivación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="cerrarModalDetallePrestaciones">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_derivacion_asignada" id="id_derivacion_asignada" value="">

                    <div class="form-group">
                        <label for="motivo_estado_derivacion">Motivo:</label>
                        <input type="text" name="motivo_estado_derivacion" id="txtmotivo_estado_derivacion" value="" class="form-control" disabled>
                        <!-- <select name="select_motivo_estado_derivacion" id="select_motivo_estado_derivacion" class="form-control"disabled>
                            <option value="">Seleccione una opción</option>
                            @foreach($estados_programa AS $value)
                                <option value="{{ $value->est_prog_id }}">{{ $value->est_prog_nom }}</option>
                            @endforeach
					    </select> -->
                    </div>

                    <div class="form-group">
                        <label for="comentario_estado_derivacion">Comentario:</label>
                        <textarea maxlength="2000" class="form-control" name="comentario_estado_derivacion" id="comentario_estado_derivacion" 
                        rows="4" disabled></textarea>
                    </div>
                </div>
      		</div>

		</div>
	</div>
</div>
<!-- FIN CZ SPRINT 56 -->
