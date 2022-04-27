{{ csrf_field() }}

<div class="modal fade" id="eliminarDocumento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
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
                <button type="button" class="btn btn-default" data-dismiss="modal" id="cerrar-modal">Cancel</button>
                <button type="button" class="btn btn-danger" id ="btn-confirmar" onclick="">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<div class="card colapsable shadow-sm" id="contenedor_carta_compromiso">
    <a class="btn text-left p-0 collapsed" id="desplegar_carta_compromiso" data-toggle="collapse" data-target="#carta_compromiso" aria-expanded="false" aria-controls="carta_compromiso" onclick="if($(this).attr('aria-expanded') == 'false') getDataDocumentos({{ config('constantes.tip_carta_compromiso_comunidad') }});">
		<div class="card-header p-3">
			<h5 class="mb-0">
				<button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
				&nbsp;&nbsp;Carta de Compromiso Comunidad
			</h5>
		</div>
	</a>
	<div class="collapse" id="carta_compromiso">
		{{-- @if ($modo_visualizacion == 'visualizacion')
            <div class="card-body">
                <div class="col-12">
                    <h6 class="text-center">Descargue el documento de carta compromiso subido para este caso en el siguiente enlace: 
                    @if ($documentocompromiso == 'na')
                        <label class="font-weight-bold">Sin información.</label>
                    @elseif ($documentocompromiso != 'na')
                        <a class="text-primary" href="../doc/{{$documentocompromiso}}" id="ruta_documento_compromiso">Click acá.</a>
                    @endif	
                    </h6>  
                </div>
                <div class="col-12 text-center">
                    <small>En caso de no tener cargado el documento de carta compromiso puede descargarlo haciendo <a href="/documentos/compromiso.docx" class="text-primary">Click acá</a></small>
                </div>
            </div>     
			
        @elseif ($modo_visualizacion == 'edicion') --}}
            <div class="card-body">
                <br>
                <div class="alert alert-success alert-dismissible fade show" id="alert-doc1" role="alert" style="display: none;">
                    Documento Guardado Exitosamente.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="alert alert-danger alert-dismissible fade show" id="alert-err-doc1" role="alert" style="display: none;">
                    Error al momento de guardar el registro. Por favor intente nuevamente.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- INICIO CZ SPRINT 62 -->
                <div class="alert alert-danger alert-dismissible fade show" id="alert-err-doc-ext1" role="alert" style="display: none;">
                    EL formato del archivo no es permitido. Sólo subir archivos con las siguientes extensiones: ".pdf", ".jpeg", ".jpg" y ".png"
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- FIN CZ SPRINT 62 -->
                @if(session()->all()['perfil'] != config("constantes.perfil_administrador_central") && session()->all()['perfil'] != config("constantes.perfil_coordinador_regional"))
                <h6 class="text-center">Cargue el documento de carta compromiso firmado por los involucrados, debe ser digitalizado (escaneo o fotografía).</h6>
                <br>
                
                <div class="input-group mb-3">
                    <form enctype="multipart/form-data" id="adj_doc1" method="post" onsubmit="cargarDocumentos(1);" style="display:none">
                        <div class="custom-file" style="z-index:0;">
                        <!-- INICIO CZ SPRINT 62 -->
                        
                                <input type="file" class="custom-file-input doc_comp" name="doc_comp" id="doc_comp" onchange="$('#adj_doc1').submit();">
                                <!-- FIN CZ SPRINT 62 -->
                                <label class="custom-file-label" for="doc_comp" aria-describedby="inputGroupFileAddon01">Cargar archivo</label>
                        </div>
                    </form>
                    <!-- INICIO CZ SPRINT 60 -->
                    <form enctype="multipart/form-data" id="adj_doc1False" method="post" onclick="abrirModal()" style="width:400px; display:none">
                        <div class="custom-file" style="z-index:0;">
                        <!-- INICIO CZ SPRINT 62 -->
                                <input type="input" class="custom-file-input doc_comp" name="doc_compFalse" id="doc_compFalse">
                               <!-- FIN CZ SPRINT 62 -->
                                <label class="custom-file-label" for="doc_compFalse" aria-describedby="inputGroupFileAddon01">Cargar archivo</label>
                        </div>
                    </form>
                    <!-- FIN CZ SPRINT 60 -->
                    <div id="descargarcompromiso" style="display: none;">
                        <!-- <div class="input-group-append">
                            <span class="input-group-text" id="inputGroupFileAddon01"><a download href="" id="ruta_documento_compromiso"><img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjUxMnB4IiBoZWlnaHQ9IjUxMnB4IiB2aWV3Qm94PSIwIDAgNDc1LjA3OCA0NzUuMDc3IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA0NzUuMDc4IDQ3NS4wNzc7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4KPGc+Cgk8Zz4KCQk8cGF0aCBkPSJNNDY3LjA4MywzMTguNjI3Yy01LjMyNC01LjMyOC0xMS44LTcuOTk0LTE5LjQxLTcuOTk0SDMxNS4xOTVsLTM4LjgyOCwzOC44MjdjLTExLjA0LDEwLjY1Ny0yMy45ODIsMTUuOTg4LTM4LjgyOCwxNS45ODggICAgYy0xNC44NDMsMC0yNy43ODktNS4zMjQtMzguODI4LTE1Ljk4OGwtMzguNTQzLTM4LjgyN0gyNy40MDhjLTcuNjEyLDAtMTQuMDgzLDIuNjY5LTE5LjQxNCw3Ljk5NCAgICBDMi42NjQsMzIzLjk1NSwwLDMzMC40MjcsMCwzMzguMDQ0djkxLjM1OGMwLDcuNjE0LDIuNjY0LDE0LjA4NSw3Ljk5NCwxOS40MTRjNS4zMyw1LjMyOCwxMS44MDEsNy45OSwxOS40MTQsNy45OWg0MjAuMjY2ICAgIGM3LjYxLDAsMTQuMDg2LTIuNjYyLDE5LjQxLTcuOTljNS4zMzItNS4zMjksNy45OTQtMTEuOCw3Ljk5NC0xOS40MTR2LTkxLjM1OEM0NzUuMDc4LDMzMC40MjcsNDcyLjQxNiwzMjMuOTU1LDQ2Ny4wODMsMzE4LjYyN3ogICAgIE0zNjAuMDI1LDQxNC44NDFjLTMuNjIxLDMuNjE3LTcuOTA1LDUuNDI0LTEyLjg1NCw1LjQyNHMtOS4yMjctMS44MDctMTIuODQ3LTUuNDI0Yy0zLjYxNC0zLjYxNy01LjQyMS03Ljg5OC01LjQyMS0xMi44NDQgICAgYzAtNC45NDgsMS44MDctOS4yMzYsNS40MjEtMTIuODQ3YzMuNjItMy42Miw3Ljg5OC01LjQzMSwxMi44NDctNS40MzFzOS4yMzIsMS44MTEsMTIuODU0LDUuNDMxICAgIGMzLjYxMywzLjYxLDUuNDIxLDcuODk4LDUuNDIxLDEyLjg0N0MzNjUuNDQ2LDQwNi45NDIsMzYzLjYzOCw0MTEuMjI0LDM2MC4wMjUsNDE0Ljg0MXogTTQzMy4xMDksNDE0Ljg0MSAgICBjLTMuNjE0LDMuNjE3LTcuODk4LDUuNDI0LTEyLjg0OCw1LjQyNGMtNC45NDgsMC05LjIyOS0xLjgwNy0xMi44NDctNS40MjRjLTMuNjEzLTMuNjE3LTUuNDItNy44OTgtNS40Mi0xMi44NDQgICAgYzAtNC45NDgsMS44MDctOS4yMzYsNS40Mi0xMi44NDdjMy42MTctMy42Miw3Ljg5OC01LjQzMSwxMi44NDctNS40MzFjNC45NDksMCw5LjIzMywxLjgxMSwxMi44NDgsNS40MzEgICAgYzMuNjE3LDMuNjEsNS40MjcsNy44OTgsNS40MjcsMTIuODQ3QzQzOC41MzYsNDA2Ljk0Miw0MzYuNzI5LDQxMS4yMjQsNDMzLjEwOSw0MTQuODQxeiIgZmlsbD0iIzAwMDAwMCIvPgoJCTxwYXRoIGQ9Ik0yMjQuNjkyLDMyMy40NzljMy40MjgsMy42MTMsNy43MSw1LjQyMSwxMi44NDcsNS40MjFjNS4xNDEsMCw5LjQxOC0xLjgwOCwxMi44NDctNS40MjFsMTI3LjkwNy0xMjcuOTA4ICAgIGM1Ljg5OS01LjUxOSw3LjIzNC0xMi4xODIsMy45OTctMTkuOTg2Yy0zLjIzLTcuNDIxLTguODQ3LTExLjEzMi0xNi44NDQtMTEuMTM2aC03My4wOTFWMzYuNTQzYzAtNC45NDgtMS44MTEtOS4yMzEtNS40MjEtMTIuODQ3ICAgIGMtMy42Mi0zLjYxNy03LjkwMS01LjQyNi0xMi44NDctNS40MjZoLTczLjA5NmMtNC45NDYsMC05LjIyOSwxLjgwOS0xMi44NDcsNS40MjZjLTMuNjE1LDMuNjE2LTUuNDI0LDcuODk4LTUuNDI0LDEyLjg0N1YxNjQuNDUgICAgaC03My4wODljLTcuOTk4LDAtMTMuNjEsMy43MTUtMTYuODQ2LDExLjEzNmMtMy4yMzQsNy44MDEtMS45MDMsMTQuNDY3LDMuOTk5LDE5Ljk4NkwyMjQuNjkyLDMyMy40Nzl6IiBmaWxsPSIjMDAwMDAwIi8+Cgk8L2c+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==" height="20px"/></a></span>
                        </div> -->
                    </div>
                </div>
                @endif
                <!-- INICIO CZ SPRINT 62 -->
                <div style="margin-top: -15px; margin-left: 2px;"><small>Sólo subir archivos con las siguientes extensiones: ".pdf", ".jpeg", ".jpg" y ".png".</small></div>
                
                <br>
                        <div style="margin-top: -15px; margin-left: 2px;"><small>Maximo tamaño permitido: 4.000 MB (4.000.000 bytes)</small></div>
                        <!-- FIN CZ SPRINT 62 -->
                <br>
                <!-- inicio ch -->
                <div class="table-responsive">
                  <table class="table table-striped table_comp">
                    <thead>                <!-- inicio ch -->
                        <th>Nombre del documento: </th>
                        <th>Fecha del documento: </th>
                        <th>Descargar documento: </th>
                        @if(session()->all()['perfil'] != config('constantes.perfil_coordinador_regional') && session()->all()['perfil'] != config('constantes.perfil_coordinador'))
                        <!-- INICO CZ SPRINT 67 -->
                        <th>Acción</th>
                        <!-- FIN CZ SPRINT 67 -->
                        @endif
                    </thead>
                    <tbody id="COMP"></tbody>
                </table>
                </div>
                <!-- fin ch -->
                <div class="text-center"><small>En caso de no tener el documento de carta compromiso puede descargarlo haciendo <a href="/documentos/Carta_Compromiso_Comunidad.doc" class="text-primary">click acá</a></small></div>
                <!-- INICIO CZ SPRINT 60 -->
                <button type="button" class="btn btn-primary modalBoton" data-toggle="modal" data-target="#exampleModal" style="display:none">
                Launch demo modal
                </button>
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Información importante</h5> 
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Ya existe un documento actual ¿Desea remplazarlo? En caso contrario, puede incluir mas archivos
                            en el historial de documentos</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary cerrarModal" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary subirArchivo" onclick="subirArchivo()">Cargar Archivo</button>
                        </div>
                        </div>
                    </div>
                </div>
                <!-- FIN CZ SPRINT 60 -->
            </div>
        {{-- @endif --}}
	</div>
</div>


<div class="card colapsable shadow-sm" id="contenedor_acta_constitucion">
    <a class="btn text-left p-0 collapsed" id="desplegar_acta_constitucion" data-toggle="collapse" data-target="#acta_constitucion" aria-expanded="false" aria-controls="acta_constitucion" onclick="if($(this).attr('aria-expanded') == 'false') getDataDocumentos({{ config('constantes.tip_acta_constitucion_grupo_accion') }});">
		<div class="card-header p-3">
			<h5 class="mb-0">
				<button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
				&nbsp;&nbsp;Acta Constitución Grupo de Acción
			</h5>
		</div>
	</a>

	<div class="collapse" id="acta_constitucion">
		{{-- @if ($modo_visualizacion == 'visualizacion')
            <div class="card-body">
                <div class="col-12">
                    <h6 class="text-center">Descargue el documento de acta constitución subido para este caso en el siguiente enlace: 
                    @if ($documentoconstitucion == 'na')
                        <label class="font-weight-bold">Sin información.</label>
                    @elseif ($documentoconstitucion != 'na')
                        <a class="text-primary" href="../doc/{{$documentoconstitucion}}" id="ruta_documento_constitucion">Click acá.</a>
                    @endif	
                    </h6>  
                </div>
                <div class="col-12 text-center">
                    <small>En caso de no tener cargado el documento de acta constitución puede descargarlo haciendo <a href="/documentos/constitucion.docx" class="text-primary">Click acá</a></small>
                </div>
            </div>      	
        @elseif ($modo_visualizacion == 'edicion') --}}
            <div class="card-body">
                <br>
                <div class="alert alert-success alert-dismissible fade show" id="alert-doc2" role="alert" style="display: none;">
                    Documento Guardado Exitosamente.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="alert alert-danger alert-dismissible fade show" id="alert-err-doc2" role="alert" style="display: none;">
                    Error al momento de guardar el registro. Por favor intente nuevamente.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- INICIO CZ SPRINT 62 -->
                <div class="alert alert-danger alert-dismissible fade show" id="alert-err-doc-ext2" role="alert" style="display: none;">
                    EL formato del archivo no es permitido. Sólo subir archivos con las siguientes extensiones: ".pdf", ".jpeg", ".jpg" y ".png"
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- FIN CZ SPRINT 62 -->
                <h6 class="text-center">Cargue el documento de acta constitución firmado por los involucrados, debe ser digitalizado (escaneo o fotografía).</h6>
                <br>
                @if(session()->all()['perfil'] != config("constantes.perfil_administrador_central") && session()->all()['perfil'] != config("constantes.perfil_coordinador_regional"))

                <div class="input-group mb-3">
                    <form enctype="multipart/form-data" id="adj_doc2" method="post" onsubmit="cargarDocumentos(2);">
                        <div class="custom-file" style="z-index:0;">
                        <!-- INICIO CZ SPRINT 62 -->
                                <input type="file" class="custom-file-input doc_cons" name="doc_cons" id="doc_cons" disabled onchange="$('#adj_doc2').submit();">
                               <!-- FIN CZ SPRINT 62 -->
                                <label class="custom-file-label" for="doc_cons" aria-describedby="inputGroupFileAddon02">Cargar archivo</label>
                        </div>
                    </form>
                    <div id="descargarconstitucion" style="display: none;">
                        <!-- <div class="input-group-append">
                            <span class="input-group-text" id="inputGroupFileAddon02"><a download href="" id="ruta_documento_constitucion"><img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjUxMnB4IiBoZWlnaHQ9IjUxMnB4IiB2aWV3Qm94PSIwIDAgNDc1LjA3OCA0NzUuMDc3IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA0NzUuMDc4IDQ3NS4wNzc7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4KPGc+Cgk8Zz4KCQk8cGF0aCBkPSJNNDY3LjA4MywzMTguNjI3Yy01LjMyNC01LjMyOC0xMS44LTcuOTk0LTE5LjQxLTcuOTk0SDMxNS4xOTVsLTM4LjgyOCwzOC44MjdjLTExLjA0LDEwLjY1Ny0yMy45ODIsMTUuOTg4LTM4LjgyOCwxNS45ODggICAgYy0xNC44NDMsMC0yNy43ODktNS4zMjQtMzguODI4LTE1Ljk4OGwtMzguNTQzLTM4LjgyN0gyNy40MDhjLTcuNjEyLDAtMTQuMDgzLDIuNjY5LTE5LjQxNCw3Ljk5NCAgICBDMi42NjQsMzIzLjk1NSwwLDMzMC40MjcsMCwzMzguMDQ0djkxLjM1OGMwLDcuNjE0LDIuNjY0LDE0LjA4NSw3Ljk5NCwxOS40MTRjNS4zMyw1LjMyOCwxMS44MDEsNy45OSwxOS40MTQsNy45OWg0MjAuMjY2ICAgIGM3LjYxLDAsMTQuMDg2LTIuNjYyLDE5LjQxLTcuOTljNS4zMzItNS4zMjksNy45OTQtMTEuOCw3Ljk5NC0xOS40MTR2LTkxLjM1OEM0NzUuMDc4LDMzMC40MjcsNDcyLjQxNiwzMjMuOTU1LDQ2Ny4wODMsMzE4LjYyN3ogICAgIE0zNjAuMDI1LDQxNC44NDFjLTMuNjIxLDMuNjE3LTcuOTA1LDUuNDI0LTEyLjg1NCw1LjQyNHMtOS4yMjctMS44MDctMTIuODQ3LTUuNDI0Yy0zLjYxNC0zLjYxNy01LjQyMS03Ljg5OC01LjQyMS0xMi44NDQgICAgYzAtNC45NDgsMS44MDctOS4yMzYsNS40MjEtMTIuODQ3YzMuNjItMy42Miw3Ljg5OC01LjQzMSwxMi44NDctNS40MzFzOS4yMzIsMS44MTEsMTIuODU0LDUuNDMxICAgIGMzLjYxMywzLjYxLDUuNDIxLDcuODk4LDUuNDIxLDEyLjg0N0MzNjUuNDQ2LDQwNi45NDIsMzYzLjYzOCw0MTEuMjI0LDM2MC4wMjUsNDE0Ljg0MXogTTQzMy4xMDksNDE0Ljg0MSAgICBjLTMuNjE0LDMuNjE3LTcuODk4LDUuNDI0LTEyLjg0OCw1LjQyNGMtNC45NDgsMC05LjIyOS0xLjgwNy0xMi44NDctNS40MjRjLTMuNjEzLTMuNjE3LTUuNDItNy44OTgtNS40Mi0xMi44NDQgICAgYzAtNC45NDgsMS44MDctOS4yMzYsNS40Mi0xMi44NDdjMy42MTctMy42Miw3Ljg5OC01LjQzMSwxMi44NDctNS40MzFjNC45NDksMCw5LjIzMywxLjgxMSwxMi44NDgsNS40MzEgICAgYzMuNjE3LDMuNjEsNS40MjcsNy44OTgsNS40MjcsMTIuODQ3QzQzOC41MzYsNDA2Ljk0Miw0MzYuNzI5LDQxMS4yMjQsNDMzLjEwOSw0MTQuODQxeiIgZmlsbD0iIzAwMDAwMCIvPgoJCTxwYXRoIGQ9Ik0yMjQuNjkyLDMyMy40NzljMy40MjgsMy42MTMsNy43MSw1LjQyMSwxMi44NDcsNS40MjFjNS4xNDEsMCw5LjQxOC0xLjgwOCwxMi44NDctNS40MjFsMTI3LjkwNy0xMjcuOTA4ICAgIGM1Ljg5OS01LjUxOSw3LjIzNC0xMi4xODIsMy45OTctMTkuOTg2Yy0zLjIzLTcuNDIxLTguODQ3LTExLjEzMi0xNi44NDQtMTEuMTM2aC03My4wOTFWMzYuNTQzYzAtNC45NDgtMS44MTEtOS4yMzEtNS40MjEtMTIuODQ3ICAgIGMtMy42Mi0zLjYxNy03LjkwMS01LjQyNi0xMi44NDctNS40MjZoLTczLjA5NmMtNC45NDYsMC05LjIyOSwxLjgwOS0xMi44NDcsNS40MjZjLTMuNjE1LDMuNjE2LTUuNDI0LDcuODk4LTUuNDI0LDEyLjg0N1YxNjQuNDUgICAgaC03My4wODljLTcuOTk4LDAtMTMuNjEsMy43MTUtMTYuODQ2LDExLjEzNmMtMy4yMzQsNy44MDEtMS45MDMsMTQuNDY3LDMuOTk5LDE5Ljk4NkwyMjQuNjkyLDMyMy40Nzl6IiBmaWxsPSIjMDAwMDAwIi8+Cgk8L2c+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==" height="20px"/></a></span>
                        </div> -->
                    </div>
                </div>
                @endif
                <!-- INICIO CZ SPRINT 62 -->
                <div style="margin-top: -15px; margin-left: 2px;"><small>Sólo subir archivos con las siguientes extensiones: ".pdf", ".jpeg", ".jpg" y ".png".</small></div>
                
                <br>
                        <div style="margin-top: -15px; margin-left: 2px;"><small>Maximo tamaño permitido: 4.000 MB (4.000.000 bytes)</small></div>
                        <!-- FIN CZ SPRINT 62 -->
                <br>
                <!-- inicio ch -->
                <div class="table-responsive">
                    <table class="table table-striped">
                    <thead>                <!-- inicio ch -->
                        <th>Nombre del documento: </th>
                        <th>Fecha del documento: </th>
                        <th>Descarga del documento: </th>
                        @if(session()->all()['perfil'] != config('constantes.perfil_coordinador_regional') && session()->all()['perfil'] != config('constantes.perfil_coordinador'))
                        <!-- INICO CZ SPRINT 67 -->
                        <th>Acción</th>
                        <!-- FIN CZ SPRINT 67 -->
                        @endif
                    </thead>
                    <tbody id="CONS"></tbody>       
                </table>
                </div>
                <!-- fin ch -->
                <div class="text-center"><small>En caso de no tener el documento de acta constitución puede descargarlo haciendo <a href="/documentos/Acta_Constitucion_Grupo_Accion.doc" class="text-primary">click acá</a></small></div>
            </div>
        {{-- @endif --}}
	</div>
</div>

<div class="card colapsable shadow-sm" id="contenedor_acta_reunion">
    <a class="btn text-left p-0 collapsed" id="desplegar_acta_reunion" data-toggle="collapse" data-target="#acta_reunion" aria-expanded="false" aria-controls="acta_reunion" onclick="if($(this).attr('aria-expanded') == 'false') getDataDocumentos({{ config('constantes.tip_acta_reunion_grupo_accion') }});">
		<div class="card-header p-3">
			<h5 class="mb-0">
				<button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
				&nbsp;&nbsp;Acta Reunión Grupo de Acción
			</h5>
		</div>
	</a>

	<div class="collapse" id="acta_reunion">
		{{-- @if ($modo_visualizacion == 'visualizacion')
            <div class="card-body">
                <div class="col-12">
                    <h6 class="text-center">Descargue el documento de acta reunión grupo de acción subido para este caso en el siguiente enlace: 
                    @if ($documentogrupo == 'na')
                        <label class="font-weight-bold">Sin información.</label>
                    @elseif ($documentogrupo != 'na')
                        <a class="text-primary" href="../doc/{{$documentogrupo}}" id="ruta_documento_grupo">Click acá.</a>
                    @endif	
                    </h6>  
                </div>
                <div class="col-12 text-center">
                    <small>En caso de no tener cargado el documento de acta reunión grupo de acción puede descargarlo haciendo <a href="/documentos/grupo.docx" class="text-primary">Click acá</a></small>
                </div>
            </div>      	
        @elseif ($modo_visualizacion == 'edicion') --}}
            <div class="card-body">
                <br>
                <div class="alert alert-success alert-dismissible fade show" id="alert-doc3" role="alert" style="display: none;">
                    Documento Guardado Exitosamente.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="alert alert-danger alert-dismissible fade show" id="alert-err-doc3" role="alert" style="display: none;">
                    Error al momento de guardar el registro. Por favor intente nuevamente.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- INICIO CZ SPRINT 62 -->
                <div class="alert alert-danger alert-dismissible fade show" id="alert-err-doc-ext3" role="alert" style="display: none;">
                    EL formato del archivo no es permitido. Sólo subir archivos con las siguientes extensiones: ".pdf", ".jpeg", ".jpg" y ".png"
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- FIN CZ SPRINT 62 -->
                <h6 class="text-center">Cargue el documento de acta reunión grupo de acción firmado por los involucrados, debe ser digitalizado (escaneo o fotografía).</h6>
                <br>
                @if(session()->all()['perfil'] != config("constantes.perfil_administrador_central") && session()->all()['perfil'] != config("constantes.perfil_coordinador_regional"))
                <div class="input-group mb-3">
                    <form enctype="multipart/form-data" id="adj_doc3" method="post" onsubmit="cargarDocumentos(3);">
                        <div class="custom-file" style="z-index:0;">
                        <!-- INICIO CZ SPRINT 62 -->
                                <input type="file" class="custom-file-input doc_acc" name="doc_acc" id="doc_acc" disabled onchange="$('#adj_doc3').submit();">
                                <!-- FIN CZ SPRINT 62 -->
                                <label class="custom-file-label" for="doc_acc" aria-describedby="inputGroupFileAddon03">Cargar archivo</label>
                        </div>
                    </form>
                    <div id="descargargrupo" style="display: none;">
                        <!-- <div class="input-group-append">
                            <span class="input-group-text" id="inputGroupFileAddon03"><a download href="" id="ruta_documento_grupo"><img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjUxMnB4IiBoZWlnaHQ9IjUxMnB4IiB2aWV3Qm94PSIwIDAgNDc1LjA3OCA0NzUuMDc3IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA0NzUuMDc4IDQ3NS4wNzc7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4KPGc+Cgk8Zz4KCQk8cGF0aCBkPSJNNDY3LjA4MywzMTguNjI3Yy01LjMyNC01LjMyOC0xMS44LTcuOTk0LTE5LjQxLTcuOTk0SDMxNS4xOTVsLTM4LjgyOCwzOC44MjdjLTExLjA0LDEwLjY1Ny0yMy45ODIsMTUuOTg4LTM4LjgyOCwxNS45ODggICAgYy0xNC44NDMsMC0yNy43ODktNS4zMjQtMzguODI4LTE1Ljk4OGwtMzguNTQzLTM4LjgyN0gyNy40MDhjLTcuNjEyLDAtMTQuMDgzLDIuNjY5LTE5LjQxNCw3Ljk5NCAgICBDMi42NjQsMzIzLjk1NSwwLDMzMC40MjcsMCwzMzguMDQ0djkxLjM1OGMwLDcuNjE0LDIuNjY0LDE0LjA4NSw3Ljk5NCwxOS40MTRjNS4zMyw1LjMyOCwxMS44MDEsNy45OSwxOS40MTQsNy45OWg0MjAuMjY2ICAgIGM3LjYxLDAsMTQuMDg2LTIuNjYyLDE5LjQxLTcuOTljNS4zMzItNS4zMjksNy45OTQtMTEuOCw3Ljk5NC0xOS40MTR2LTkxLjM1OEM0NzUuMDc4LDMzMC40MjcsNDcyLjQxNiwzMjMuOTU1LDQ2Ny4wODMsMzE4LjYyN3ogICAgIE0zNjAuMDI1LDQxNC44NDFjLTMuNjIxLDMuNjE3LTcuOTA1LDUuNDI0LTEyLjg1NCw1LjQyNHMtOS4yMjctMS44MDctMTIuODQ3LTUuNDI0Yy0zLjYxNC0zLjYxNy01LjQyMS03Ljg5OC01LjQyMS0xMi44NDQgICAgYzAtNC45NDgsMS44MDctOS4yMzYsNS40MjEtMTIuODQ3YzMuNjItMy42Miw3Ljg5OC01LjQzMSwxMi44NDctNS40MzFzOS4yMzIsMS44MTEsMTIuODU0LDUuNDMxICAgIGMzLjYxMywzLjYxLDUuNDIxLDcuODk4LDUuNDIxLDEyLjg0N0MzNjUuNDQ2LDQwNi45NDIsMzYzLjYzOCw0MTEuMjI0LDM2MC4wMjUsNDE0Ljg0MXogTTQzMy4xMDksNDE0Ljg0MSAgICBjLTMuNjE0LDMuNjE3LTcuODk4LDUuNDI0LTEyLjg0OCw1LjQyNGMtNC45NDgsMC05LjIyOS0xLjgwNy0xMi44NDctNS40MjRjLTMuNjEzLTMuNjE3LTUuNDItNy44OTgtNS40Mi0xMi44NDQgICAgYzAtNC45NDgsMS44MDctOS4yMzYsNS40Mi0xMi44NDdjMy42MTctMy42Miw3Ljg5OC01LjQzMSwxMi44NDctNS40MzFjNC45NDksMCw5LjIzMywxLjgxMSwxMi44NDgsNS40MzEgICAgYzMuNjE3LDMuNjEsNS40MjcsNy44OTgsNS40MjcsMTIuODQ3QzQzOC41MzYsNDA2Ljk0Miw0MzYuNzI5LDQxMS4yMjQsNDMzLjEwOSw0MTQuODQxeiIgZmlsbD0iIzAwMDAwMCIvPgoJCTxwYXRoIGQ9Ik0yMjQuNjkyLDMyMy40NzljMy40MjgsMy42MTMsNy43MSw1LjQyMSwxMi44NDcsNS40MjFjNS4xNDEsMCw5LjQxOC0xLjgwOCwxMi44NDctNS40MjFsMTI3LjkwNy0xMjcuOTA4ICAgIGM1Ljg5OS01LjUxOSw3LjIzNC0xMi4xODIsMy45OTctMTkuOTg2Yy0zLjIzLTcuNDIxLTguODQ3LTExLjEzMi0xNi44NDQtMTEuMTM2aC03My4wOTFWMzYuNTQzYzAtNC45NDgtMS44MTEtOS4yMzEtNS40MjEtMTIuODQ3ICAgIGMtMy42Mi0zLjYxNy03LjkwMS01LjQyNi0xMi44NDctNS40MjZoLTczLjA5NmMtNC45NDYsMC05LjIyOSwxLjgwOS0xMi44NDcsNS40MjZjLTMuNjE1LDMuNjE2LTUuNDI0LDcuODk4LTUuNDI0LDEyLjg0N1YxNjQuNDUgICAgaC03My4wODljLTcuOTk4LDAtMTMuNjEsMy43MTUtMTYuODQ2LDExLjEzNmMtMy4yMzQsNy44MDEtMS45MDMsMTQuNDY3LDMuOTk5LDE5Ljk4NkwyMjQuNjkyLDMyMy40Nzl6IiBmaWxsPSIjMDAwMDAwIi8+Cgk8L2c+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==" height="20px"/></a></span>
                        </div> -->
                    </div>
                </div>
                @endif
                <!-- INICIO CZ SPRINT 62 -->
                <div style="margin-top: -15px; margin-left: 2px;"><small>Sólo subir archivos con las siguientes extensiones: ".pdf", ".jpeg", ".jpg" y ".png".</small></div>
                
                <br>
                        <div style="margin-top: -15px; margin-left: 2px;"><small>Maximo tamaño permitido: 4.000 MB (4.000.000 bytes)</small></div>
                        <!-- FIN CZ SPRINT 62 -->
                <br>
                <!-- inicio ch -->
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>                        <!-- inicio ch -->
                            <th>Nombre del documento: </th>
                            <th>Fecha del documento: </th>
                            <th>Descarga del documento: </th>
                            @if(session()->all()['perfil'] != config('constantes.perfil_coordinador_regional') && session()->all()['perfil'] != config('constantes.perfil_coordinador'))
                            <!-- INICO CZ SPRINT 67 -->
                                <th>Acción</th>
                             <!-- FIN CZ SPRINT 67 -->
                            @endif
                    </thead>
                    <tbody id="ACC"></tbody>
                </table>
                </div>
                <!-- fin ch -->
                <div class="text-center"><small>En caso de no tener el documento de acta reunión grupo de acción puede descargarlo haciendo <a href="/documentos/Acta_Reunion_Grupo_Accion.doc" class="text-primary">click acá</a></small></div>
            </div>
        {{-- @endif --}}
	</div>
</div>

<div class="card colapsable shadow-sm" id="contenedor_acta_reunion_asamblea">
    <a class="btn text-left p-0 collapsed" id="desplegar_acta_reunion_asamblea" data-toggle="collapse" data-target="#acta_reunion_asamblea" aria-expanded="false" aria-controls="acta_reunion_asamblea" onclick="if($(this).attr('aria-expanded') == 'false') getDataDocumentos({{ config('constantes.tip_acta_reunion_asamblea_comunitaria') }});">
		<div class="card-header p-3">
			<h5 class="mb-0">
				<button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
				&nbsp;&nbsp;Acta Reunión Asamblea Comunitaria
			</h5>
		</div>
	</a>

	<div class="collapse" id="acta_reunion_asamblea">
		{{-- @if ($modo_visualizacion == 'visualizacion')
            <div class="card-body">
                <div class="col-12">
                    <h6 class="text-center">Descargue el documento de acta reunión asamblea comunitaria subido para este caso en el siguiente enlace: 
                    @if ($documentoasamblea == 'na')
                        <label class="font-weight-bold">Sin información.</label>
                    @elseif ($documentoasamblea != 'na')
                        <a class="text-primary" href="../doc/{{$documentoasamblea}}" id="ruta_documento_asamblea">Click acá.</a>
                    @endif	
                    </h6>  
                </div>
                <div class="col-12 text-center">
                    <small>En caso de no tener cargado el documento de acta reunión asamblea comunitaria puede descargarlo haciendo <a href="/documentos/asamblea.docx" class="text-primary">Click acá</a></small>
                </div>
            </div>      	
        @elseif ($modo_visualizacion == 'edicion') --}}
            <div class="card-body">
                <br>
                <div class="alert alert-success alert-dismissible fade show" id="alert-doc4" role="alert" style="display: none;">
                    Documento Guardado Exitosamente.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="alert alert-danger alert-dismissible fade show" id="alert-err-doc4" role="alert" style="display: none;">
                    Error al momento de guardar el registro. Por favor intente nuevamente.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- INICIO CZ SPRINT 62 -->
                <div class="alert alert-danger alert-dismissible fade show" id="alert-err-doc-ext4" role="alert" style="display: none;">
                    EL formato del archivo no es permitido. Sólo subir archivos con las siguientes extensiones: ".pdf", ".jpeg", ".jpg" y ".png"
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- FIN CZ SPRINT 62 -->
                @if(session()->all()['perfil'] != config("constantes.perfil_administrador_central") && session()->all()['perfil'] != config("constantes.perfil_coordinador_regional"))

                <h6 class="text-center">Cargue el documento de acta reunión asamblea comunitaria firmado por los involucrados, debe ser digitalizado (escaneo o fotografía).</h6>
                <br>
                <div class="input-group mb-3">
                    <form enctype="multipart/form-data" id="adj_doc4" method="post" onsubmit="cargarDocumentos(4);">
                        <div class="custom-file" style="z-index:0;">
                        <!-- INICIO CZ SPRINT 62 -->
                                <input type="file" class="custom-file-input doc_asam" name="doc_asam" id="doc_asam" disabled onchange="$('#adj_doc4').submit();">
                                <!-- FIN CZ SPRINT 62 -->
                                <label class="custom-file-label" for="doc_asam" aria-describedby="inputGroupFileAddon04">Cargar archivo</label>
                        </div>
                    </form>
                    <div id="descargarasamblea" style="display: none;">
                        <!-- <div class="input-group-append">
                            <span class="input-group-text" id="inputGroupFileAddon04"><a download href="" id="ruta_documento_asamblea"><img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjUxMnB4IiBoZWlnaHQ9IjUxMnB4IiB2aWV3Qm94PSIwIDAgNDc1LjA3OCA0NzUuMDc3IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA0NzUuMDc4IDQ3NS4wNzc7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4KPGc+Cgk8Zz4KCQk8cGF0aCBkPSJNNDY3LjA4MywzMTguNjI3Yy01LjMyNC01LjMyOC0xMS44LTcuOTk0LTE5LjQxLTcuOTk0SDMxNS4xOTVsLTM4LjgyOCwzOC44MjdjLTExLjA0LDEwLjY1Ny0yMy45ODIsMTUuOTg4LTM4LjgyOCwxNS45ODggICAgYy0xNC44NDMsMC0yNy43ODktNS4zMjQtMzguODI4LTE1Ljk4OGwtMzguNTQzLTM4LjgyN0gyNy40MDhjLTcuNjEyLDAtMTQuMDgzLDIuNjY5LTE5LjQxNCw3Ljk5NCAgICBDMi42NjQsMzIzLjk1NSwwLDMzMC40MjcsMCwzMzguMDQ0djkxLjM1OGMwLDcuNjE0LDIuNjY0LDE0LjA4NSw3Ljk5NCwxOS40MTRjNS4zMyw1LjMyOCwxMS44MDEsNy45OSwxOS40MTQsNy45OWg0MjAuMjY2ICAgIGM3LjYxLDAsMTQuMDg2LTIuNjYyLDE5LjQxLTcuOTljNS4zMzItNS4zMjksNy45OTQtMTEuOCw3Ljk5NC0xOS40MTR2LTkxLjM1OEM0NzUuMDc4LDMzMC40MjcsNDcyLjQxNiwzMjMuOTU1LDQ2Ny4wODMsMzE4LjYyN3ogICAgIE0zNjAuMDI1LDQxNC44NDFjLTMuNjIxLDMuNjE3LTcuOTA1LDUuNDI0LTEyLjg1NCw1LjQyNHMtOS4yMjctMS44MDctMTIuODQ3LTUuNDI0Yy0zLjYxNC0zLjYxNy01LjQyMS03Ljg5OC01LjQyMS0xMi44NDQgICAgYzAtNC45NDgsMS44MDctOS4yMzYsNS40MjEtMTIuODQ3YzMuNjItMy42Miw3Ljg5OC01LjQzMSwxMi44NDctNS40MzFzOS4yMzIsMS44MTEsMTIuODU0LDUuNDMxICAgIGMzLjYxMywzLjYxLDUuNDIxLDcuODk4LDUuNDIxLDEyLjg0N0MzNjUuNDQ2LDQwNi45NDIsMzYzLjYzOCw0MTEuMjI0LDM2MC4wMjUsNDE0Ljg0MXogTTQzMy4xMDksNDE0Ljg0MSAgICBjLTMuNjE0LDMuNjE3LTcuODk4LDUuNDI0LTEyLjg0OCw1LjQyNGMtNC45NDgsMC05LjIyOS0xLjgwNy0xMi44NDctNS40MjRjLTMuNjEzLTMuNjE3LTUuNDItNy44OTgtNS40Mi0xMi44NDQgICAgYzAtNC45NDgsMS44MDctOS4yMzYsNS40Mi0xMi44NDdjMy42MTctMy42Miw3Ljg5OC01LjQzMSwxMi44NDctNS40MzFjNC45NDksMCw5LjIzMywxLjgxMSwxMi44NDgsNS40MzEgICAgYzMuNjE3LDMuNjEsNS40MjcsNy44OTgsNS40MjcsMTIuODQ3QzQzOC41MzYsNDA2Ljk0Miw0MzYuNzI5LDQxMS4yMjQsNDMzLjEwOSw0MTQuODQxeiIgZmlsbD0iIzAwMDAwMCIvPgoJCTxwYXRoIGQ9Ik0yMjQuNjkyLDMyMy40NzljMy40MjgsMy42MTMsNy43MSw1LjQyMSwxMi44NDcsNS40MjFjNS4xNDEsMCw5LjQxOC0xLjgwOCwxMi44NDctNS40MjFsMTI3LjkwNy0xMjcuOTA4ICAgIGM1Ljg5OS01LjUxOSw3LjIzNC0xMi4xODIsMy45OTctMTkuOTg2Yy0zLjIzLTcuNDIxLTguODQ3LTExLjEzMi0xNi44NDQtMTEuMTM2aC03My4wOTFWMzYuNTQzYzAtNC45NDgtMS44MTEtOS4yMzEtNS40MjEtMTIuODQ3ICAgIGMtMy42Mi0zLjYxNy03LjkwMS01LjQyNi0xMi44NDctNS40MjZoLTczLjA5NmMtNC45NDYsMC05LjIyOSwxLjgwOS0xMi44NDcsNS40MjZjLTMuNjE1LDMuNjE2LTUuNDI0LDcuODk4LTUuNDI0LDEyLjg0N1YxNjQuNDUgICAgaC03My4wODljLTcuOTk4LDAtMTMuNjEsMy43MTUtMTYuODQ2LDExLjEzNmMtMy4yMzQsNy44MDEtMS45MDMsMTQuNDY3LDMuOTk5LDE5Ljk4NkwyMjQuNjkyLDMyMy40Nzl6IiBmaWxsPSIjMDAwMDAwIi8+Cgk8L2c+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==" height="20px"/></a></span>
                        </div> -->
                    </div>
                </div>
                @endif
                <!-- INICIO CZ SPRINT 62 -->
                <div style="margin-top: -15px; margin-left: 2px;"><small>Sólo subir archivos con las siguientes extensiones: ".pdf", ".jpeg", ".jpg" y ".png".</small></div>
                
                <br>
                        <div style="margin-top: -15px; margin-left: 2px;"><small>Maximo tamaño permitido: 4.000 MB (4.000.000 bytes)</small></div>
                        <!-- FIN CZ SPRINT 62 -->
                <br>
                <!-- inicio ch -->
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>                        <!-- inicio ch -->
                            <th>Nombre del documento: </th>
                            <th>Fecha del documento: </th>
                            <th>Descarga del documento: </th>
                            @if(session()->all()['perfil'] != config('constantes.perfil_coordinador_regional') && session()->all()['perfil'] != config('constantes.perfil_coordinador'))
                            <!-- INICO CZ SPRINT 67 -->
                                <th>Acción</th>
                            <!-- FIN CZ SPRINT 67 -->
                            @endif
                    </thead>
                    <tbody  id="ASAM"></tbody>
                </table>
                <div>
                <!-- fin ch -->
                <div class="text-center"><small>En caso de no tener el documento de acta reunión asamblea comunitaria puede descargarlo haciendo <a href="/documentos/Acta_Reunion_Asamblea_Comunitaria.doc" class="text-primary">click acá</a></small></div>
            </div>
        {{-- @endif --}}
	</div>
</div>
<script type="text/javascript">   

// INICIO CZ SPRINT 67
function eliminarDoc(tipo, id){
    document.getElementById('btn-confirmar').setAttribute('onclick','eliminarDocumentos('+id+','+tipo+', '+$('input[name=pro_an_id]').val()+', '+$('input[name=tipo_gestion]').val()+')');
   
}
// FIN CZ SPRINT 67
</script> 

<script type="text/javascript">   

    // INICIO CZ SPRINT 60
    $( document ).ready(function() {
        var rowCount = $('.table_comp tr').length;
        if(rowCount > 1){
            $("#doc_comp").change(function(){

            $('#adj_doc1').submit();
        })
        }

    });
    
    
    function displayInput(){
        var rowCount = $('.table_comp tr').length;
         if(rowCount <= 1){
            $("#adj_doc1").css("display","block");
            $("#adj_doc1False").css("display","none");
        }else{
            $("#adj_doc1").css("display","none");
            $("#adj_doc1False").css("display","block");
        }
    }
    
    function subirArchivo(){
        $("#doc_comp").click();
        $(".cerrarModal").click();
    }

    function abrirModal(){
        $(".modalBoton").click();
    }
    // FIN CZ SPRINT 60
    function limpiarMensajesDocumentos(){
        $("#alert-doc1").hide();
        $("#alert-err-doc1").hide();
        $("#alert-err-doc-ext1").hide();

        $("#alert-doc2").hide();
        $("#alert-err-doc2").hide();
        $("#alert-err-doc-ext2").hide();

        $("#alert-doc3").hide();
        $("#alert-err-doc3").hide();
        $("#alert-err-doc-ext3").hide();

        $("#alert-doc4").hide();
        $("#alert-err-doc4").hide();
        $("#alert-err-doc-ext4").hide();
    }

    function cargarDocumentos(tipo){      
        bloquearPantalla();  

        // agrego la data del form a formData
        var form = document.getElementById('adj_doc'+tipo);
        let formData = new FormData(form);
        formData.append('pro_an_id', {{$pro_an_id}});
        formData.append('tipo', tipo);
        formData.append('_token', $('input[name=_token]').val());

        // INICIO CZ SPRINT 62
        var imgsize;
        
        if(tipo == 1){
            imgsize = document.getElementsByClassName("doc_comp")[0].files[0].size;
        }else if(tipo ==2){
            imgsize = document.getElementsByClassName("doc_cons")[0].files[0].size;
        }else if(tipo == 3){
            imgsize = document.getElementsByClassName("doc_acc")[0].files[0].size;
        }else if(tipo == 4){
            imgsize = document.getElementsByClassName("doc_asam")[0].files[0].size;
        }
            if(imgsize > 4000000){
                //console.log("aqui");
                toastr.error('El archivo debe tener un peso maximo de 4.000 MB', {timeOut: 3000});
                desbloquearPantalla();
            }else{
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ route('cargar.documentos') }}",
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        }).done(function(resp){

                desbloquearPantalla();

                if (resp.estado == 1){

                    $("#alert-err-doc"+tipo).hide();
                    $("#alert-err-doc-ext"+tipo).hide();
                    $("#alert-doc"+tipo).show();

                    switch(tipo){
                        case {{ config('constantes.tip_carta_compromiso_comunidad') }}:
                            // INICIO CZ SPRINT 60
                            var rowCount = $('.table_comp tr').length;
                            if(rowCount <= 1){
                            cambiarEstadoGestorComunitario($("#est_pro_id").val());
                            }
                            getDataDocumentos({{ config('constantes.tip_carta_compromiso_comunidad') }});
                            // FIN CZ SPRINT 60
                        break;

                        case {{ config('constantes.tip_acta_constitucion_grupo_accion') }}:
                            $("#doc_cons").prop("disabled",false);
                            getDataDocumentos({{ config('constantes.tip_acta_constitucion_grupo_accion') }});
                        break;

                        case {{ config('constantes.tip_acta_reunion_grupo_accion') }}:
                            $("#doc_acc").prop("disabled",false);
                            getDataDocumentos({{ config('constantes.tip_acta_reunion_grupo_accion') }});
                        break;

                        case {{ config('constantes.tip_acta_reunion_asamblea_comunitaria') }}:
                            $("#doc_asam").prop("disabled",false);
                            getDataDocumentos({{ config('constantes.tip_acta_reunion_asamblea_comunitaria') }});
                        break;
                    }
                    setTimeout(function(){ 
                        $("#alert-doc"+tipo).hide();
                        getDataDocumentos();
                    }, 1000);                    

                }else if (resp.estado == 0){
                    $("#alert-err-doc"+tipo).show();
                    setTimeout(function(){ $("#alert-err-doc"+tipo).hide(); }, 5000);
                }
        }).fail(function(objeto, tipoError, errorHttp){
            desbloquearPantalla();

            $("#alert-err-doc-ext"+tipo).show();
            setTimeout(function(){ $("#alert-err-doc"+tipo).hide(); }, 5000);
            setTimeout(function(){ $("#alert-err-doc-ext"+tipo).hide(); }, 5000);

            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

            return false;
        });
            }
        //FIN CZ SPRINT 62

    }

    function getDataDocumentos(tipo_documento){

        let data = new Object();

        data.pro_an_id = {{$pro_an_id}};

        $.ajax({
            type:"GET",
            url: "{{route('documentos.data')}}",
            data: data
        }).done(function(resp){
            if(resp.estado == 1){ //INICIO CH
                if(resp.comp != "na"){
                    $('#descargarcompromiso').show();
                    $("#doc_cons").prop("disabled",false);
                    $("#COMP").empty();
                    $("#COMP").html(resp.comp);
                }//fin ch
                    
                if(resp.cons != "na"){//INICIO CH
                    $('#descargarconstitucion').show();
                    $("#doc_acc").prop("disabled",false);
                    $("#CONS").empty();
                    $("#CONS").html(resp.cons);
                }//fin ch

                if(resp.acc != "na"){
                   // $('#descargargrupo').show();
                    $("#doc_acc").prop("disabled",false);
                    if (tipo_documento == 3) {
                        let valor = resp.acc; 
                        $("#ACC").empty();
                        $("#ACC").html(valor);
                    }//Fin ch
                    displayInput();
                }

                if(resp.asam != "na"){
                    //$('#descargarasamblea').show();
                    $("#doc_asam").prop("disabled",false);
                    if (tipo_documento == 4) {//INICIO CH
                        let valor = resp.asam; 
                        $("#ASAM").empty();
                        $("#ASAM").html(valor);
                    }//Fin ch
                }
                //INICIO DC
                if($('#desestimado').val() == 1){
                	$('input').attr('disabled', 'disabled');
                }
                if('{{ Session::get('perfil') }}' == 2){
                	$('.custom-file-input').attr('disabled', 'disabled');
                }
                //FIN DC
                //INICIO CZ SPRINT 67 correccion
                if($("#est_pro_id").val() == {{ config('constantes.finalizado') }} || $("#est_pro_id").val() == {{ config('constantes.desestimado') }} ){
                    $('.btn-danger').attr('disabled', 'disabled');
                }
                //FIN CZ SPRINT 67 correccion
            }
        }).fail(function(objeto, tipoError, errorHttp){            
            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
            return false;
        });
    }
    
</script>
<!-- INICIO CZ SPRINT 67 -->
<script>
function eliminarDocumentos(id,tipo,proceso,tipo_gestion){
    bloquearPantalla();
    let data = new Object();
    data.tip_id = tipo;
    data.id = id;
    data.id_pro_an_id = proceso;
    data.tipo_gest = tipo_gestion;
    $.ajaxSetup({
			    headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}
            });
    $.ajax({
            type:"post",
            url: "{{route('eliminarDocumento')}}",
            data: data
        }).done(function(resp){
            desbloquearPantalla();
            if(resp.estado == 1){
                $('#eliminarDocumento').modal('hide');
                $('#confirm-delete').modal('hide');
                toastr.success(resp.mensaje);    
                if(tipo == 1){
                    getDataDocumentos({{ config('constantes.tip_carta_compromiso_comunidad') }});
                }else if( tipo == 2){
                    getDataDocumentos({{ config('constantes.tip_acta_constitucion_grupo_accion') }});
                }else if( tipo == 3){
                    getDataDocumentos({{ config('constantes.tip_acta_reunion_grupo_accion') }});
                }else if( tipo == 4){
                    getDataDocumentos({{ config('constantes.tip_acta_reunion_asamblea_comunitaria') }});
                }else if(tipo == 5){
                    gethistorialData({{ config('constantes.tip_acta_listas_asistencias') }});
                }else if( tipo == 6){
                    gethistorialData({{ config('constantes.tip_materiales') }});
                }else if( tipo == 7){
                    gethistorialData({{ config('constantes.tip_asentamientos_consentimientos') }});
                }   

            }
        }).fail(function(objeto, tipoError, errorHttp){            
            desbloquearPantalla();
            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

            return false;
        });
}
</script>
<!-- FIN CZ SPRINT 67 -->