<!-- INICIO CZ SPRINT 66 -->
<div id="formBitacoraTerapia" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="formBitacoraTerapia"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content p-4">
            <div class="card p-4 shadow-sm">
                <div class="row">
				
                    <div class="col-11 text-center">
                        <h5 class="modal-title"><b  id="title"></b></h5>
                    </div>
                    <div class="col-1">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div><br>
                <div class="row pl-3">
                    <label>RUN NNA:</label>&nbsp
                    <p id="run_nna"></p>
                </div>
                <div class="row pl-3">
                    <label id="label_tipo_nna"></label>&nbsp
                    <p id="tipo_nna"></p>
                </div>
                <div class="row pl-3" style="display:none">
                    <p id="id_estado_actual"></p>
                </div>
                <div class="row pl-3">
                    <label id="label_estado_actual">Estado Actual:</label>&nbsp
                    <p id="estado_actual"></p>
                </div>
                <div class="row pl-3">
                <select id="estado_cambiar" name="dim_id" class="form-control">
                    <option value=""> Seleccione estado a cambiar</option>
                </select>
                </div>
                <br>
                <div class="text-right">
                    <button type="button" class="btn btn-success" id="btn_cambio_estado">Confirmar cambio</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn_cerrar_modal">Cerrar</button>
                </div>


            </div>
        </div>
    </div>
</div>
<!-- FIN CZ SPRINT 66 -->