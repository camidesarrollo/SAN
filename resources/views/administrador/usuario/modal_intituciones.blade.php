
<!-- //CZ 75 -->
<div id="modalAddInstitucion" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content p-4">
            <div class="modal-header">
                <div style="margin: 0 auto;">
                    <h5>Agregar Institución</h5>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                    style="position: absolute; margin: 0; top: 5px; right: 33px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <label class="lblAdd col-form-label">Nombre:</label>
                    <div class="col-sm-3">
                        <input type="text" id="nomInstitucion" class="form-control">
                    </div>
                </div>

            </div>
            <div class="modal-footer" style="background-color: white;">
                <button type="button" class="btn btn-primary" onclick="agregarInstitucion();">Agregar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>