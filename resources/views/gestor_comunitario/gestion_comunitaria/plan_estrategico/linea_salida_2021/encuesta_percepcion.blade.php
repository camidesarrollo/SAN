<div class="card-body">
    <form method="post" action="#" enctype="multipart/form-data" id="adj_doc_percepcion">
        <div class="alert alert-success alert-dismissible fade show" id="alert-docu-paf-exito" role="alert"
            style="display:none;">
            Documento subido satisfactoriamente.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="alert alert-danger alert-dismissible fade show" id="alert-docu-paf-error" role="alert"
            style="display:none;">
            Error al momento de subir el documento. Por favor intente nuevamente..
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="border p-3 bg-light form-group">
                    <div class="row">
                        <dt class="col-sm-1">
                            <h4><span class="badge badge-secondary">a</span></h4>
                        </dt>
                        <dd class="col-sm-11">
                            <p>Descargue el siguiente documento con la encuesta de Satisfacción de NNA</p>
                            <a download href="../../documentos/{{ config('constantes.Encuesta_de_percepción_de_NNA_GCOM')  }}" id="imp_doc"
                                aria-describedby="imp_doc_ayu" class="btn btn-primary"><i class="fa fa-print"></i>
                                Descargar Documento</a>
                            <!-- <small id="imp_doc_ayu" class="form-text text-muted">*El documento debe ser firmado por la
                                Familia del NAA.</small> -->
                            
                        </dd>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="border p-3 bg-light form-group">
                    <div class="row">
                        <dt class="col-sm-1">
                            <h4> <span class="badge badge-secondary">b</span></h4>
                        </dt>
                        <dd class="col-sm-11">
                            <div class="" style="width: 100%;">
                                <input name="_token" type="hidden" value="tkhKbEfb2yZAtMYOlm20RGUvEBhgdkDMRHzjGiiM">
                                <input name="tipo_gestion" type="hidden" value="0">
                                <input name="tipo" type="hidden" value="5">
                                <input name="pro_an_id" type="hidden" value="763">
                                <input type="file" class="custom-file-input doc_percepcion" name="doc_percepcion" id="doc_percepcion"
                                    onchange="cargar_doc_percepcion('doc_percepcion')">
                                <label class="custom-file-label" for="doc_percepcion" aria-describedby="inputGroupFileAddon02">Cargar
                                    archivo</label>
                            </div>
                            <small class="form-text text-muted">* Solo subir documentos con las siguientes extensiones:
                                doc, docx o pdf.<br> Tamaño máximo permitido: 5 MB.</small>
                        </dd>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <br>
    <!-- <div class="alert alert-success alert-dismissible fade show" id="alert-doc5" role="alert" style="display: none;">
        Documento Guardado Exitosamente.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>

    <div class="alert alert-danger alert-dismissible fade show" id="alert-err-doc5" role="alert" style="display: none;">
        Error al momento de guardar el registro. Por favor intente nuevamente.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
    <div class="alert alert-danger alert-dismissible fade show" id="alert-err-doc-ext5" role="alert"
        style="display: none;">
        EL formato del archivo no es permitido. Sólo subir archivos con las siguientes extensiones: ".pdf", ".jpeg",
        ".jpg" y ".png"
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
    <h6 class="text-center">Cargue el documento de encuesta de percepción (escaneo o
        fotografía).</h6>
    <br> -->

    <!-- <div class="input-group mb-3">
        <form method="post" action="#" enctype="multipart/form-data" id="adj_doc_percepcion">
            <div class="custom-file" style="z-index:0;">
                <input name="_token" type="hidden" value="tkhKbEfb2yZAtMYOlm20RGUvEBhgdkDMRHzjGiiM">
                <input name="tipo_gestion" type="hidden" value="0">
                <input name="tipo" type="hidden" value="5">
                <input name="pro_an_id" type="hidden" value="763">
                <input type="file" class="custom-file-input doc_percepcion" name="doc_percepcion" id="doc_percepcion"
                    onchange="cargar_doc_percepcion('doc_percepcion')">
                <label class="custom-file-label" for="doc_percepcion" aria-describedby="inputGroupFileAddon02">Cargar
                    archivo</label>
            </div>
        </form>
    </div>
    <div style="margin-top: -15px; margin-left: 2px;"><small>Sólo subir archivos con las siguientes extensiones: ".pdf",
            ".jpeg", ".jpg" y ".png".</small></div>
    <br>
    <div style="margin-top: -15px; margin-left: 2px;"><small>Maximo tamaño permitido: 4.000 MB (4.000.000 bytes)</small>
    </div>
    <br> -->
    <div class="table-responsive">
        <table class="table"  style="width: 100%;" id="tabla_doc_percepcion" >
            <thead>
                <tr>
                    <th>Fecha Creación</th>
                    <th>Documento</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    <!-- fin ch -->
</div>
<meta name="_token" content="{{ csrf_token() }}">
<div class="modal fade" id="eliminarDocPercepion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Confirmar la eliminación</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <p>Está a punto de borrar una documento, este procedimiento es irreversible.</p>
                <p>¿Quieres continuar?</p>
                <p class="debug-url"></p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="cerrar-modal-confirm">Cancel</button>
                <button type="button" class="btn btn-danger" id ="btnConfimDocPercp" onclick="">Eliminar</button>
            </div>
        </div>
    </div>
</div>