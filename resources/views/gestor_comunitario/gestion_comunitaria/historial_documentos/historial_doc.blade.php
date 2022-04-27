<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="row">
    <div class="card shadow-sm p-4 w-100">
        <div class="card colapsable shadow-sm" id="contenedor_actas_listas">
                <!-- inicio ch -->
                <a class="btn text-left p-0 collapsed" id="desplegar_actas_listas" data-toggle="collapse" data-target="#collapseOne"  aria-controls="collapseOne" aria-expanded="false" onclick="if($(this).attr('aria-expanded') == 'false') gethistorialData({{ config('constantes.tip_acta_listas_asistencias') }});">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <button class="btn btn-info" type="button" data-toggle="collapse" aria-expanded="false"><!-- fin ch -->
                                <i class="fa fa-info"></i></button>
                                &nbsp;&nbsp;Actas y Listas de Asistencia
                        </h5>
                    </div>
                </a>
				
				
            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body">
                    <br>
                    <div class="alert alert-success alert-dismissible fade show" id="alert-doc5" role="alert" style="display: none;">
                        Documento Guardado Exitosamente.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
					
                    <div class="alert alert-danger alert-dismissible fade show" id="alert-err-doc5" role="alert" style="display: none;">
                        Error al momento de guardar el registro. Por favor intente nuevamente.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                     <!-- INICIO CZ SPRINT 62 -->
                    <div class="alert alert-danger alert-dismissible fade show" id="alert-err-doc-ext5" role="alert" style="display: none;">
                        EL formato del archivo no es permitido. Sólo subir archivos con las siguientes extensiones: ".pdf", ".jpeg", ".jpg" y ".png"
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!--FIN CZ SPRINT 62 -->
                    <h6 class="text-center">Cargue el documento de actas y listas de asistencias, debe ser digitalizado (escaneo o fotografía).</h6>
                    <br>
                    @if(session()->all()['perfil'] != config("constantes.perfil_administrador_central") && session()->all()['perfil'] != config("constantes.perfil_coordinador_regional"))

                    <div class="input-group mb-3">
                    <!-- INICIO CZ -->
                        <!-- <form method="POST" action="{{ route('hist.doc.cargar') }}" enctype="multipart/form-data">
                          <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                          <input name="tipo_gestion" type="hidden" value="{{$tipo_gestion}}"/>
                          <input name="tipo" type="hidden" value="5"/>
                          <input name="pro_an_id" type="hidden" value="{{$pro_an_id}}"/>
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="doc_actas" lang="es" name="doc_actas" require required>
                            <label class="custom-file-label" for="doc_actas">Seleccionar Archivo</label>
                          </div>
                          <input type="submit" value="Subir">
                        </form> -->
                        <form method="post" action="#" enctype="multipart/form-data" id="adj_doc_actas">
                            <div class="custom-file" style="z-index:0;">
                                <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                                <input name="tipo_gestion" type="hidden" value="{{$tipo_gestion}}"/>
                                <input name="tipo" type="hidden" value="5"/>
                                <input name="pro_an_id" type="hidden" value="{{$pro_an_id}}"/>
                                <!-- INICIO CZ SPRINT 62 -->
                                <input type="file" class="custom-file-input doc_actas" name="doc_actas" id="doc_actas" onchange="enviarData('doc_actas')">
                                <!-- FIN CZ SPRINT 62 -->
                                    <label class="custom-file-label" for="doc_actas" aria-describedby="inputGroupFileAddon02">Cargar archivo</label>
                            </div>
                        </form>
                      
                    <!-- FIN CZ -->
                        <div id="descargaractas" style="display: none;">
                            <div class="input-group-append">
                                <span class="input-group-text" id="inputGroupFileAddon07"><a download href="" id="ruta_documento_actas"><img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjUxMnB4IiBoZWlnaHQ9IjUxMnB4IiB2aWV3Qm94PSIwIDAgNDc1LjA3OCA0NzUuMDc3IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA0NzUuMDc4IDQ3NS4wNzc7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4KPGc+Cgk8Zz4KCQk8cGF0aCBkPSJNNDY3LjA4MywzMTguNjI3Yy01LjMyNC01LjMyOC0xMS44LTcuOTk0LTE5LjQxLTcuOTk0SDMxNS4xOTVsLTM4LjgyOCwzOC44MjdjLTExLjA0LDEwLjY1Ny0yMy45ODIsMTUuOTg4LTM4LjgyOCwxNS45ODggICAgYy0xNC44NDMsMC0yNy43ODktNS4zMjQtMzguODI4LTE1Ljk4OGwtMzguNTQzLTM4LjgyN0gyNy40MDhjLTcuNjEyLDAtMTQuMDgzLDIuNjY5LTE5LjQxNCw3Ljk5NCAgICBDMi42NjQsMzIzLjk1NSwwLDMzMC40MjcsMCwzMzguMDQ0djkxLjM1OGMwLDcuNjE0LDIuNjY0LDE0LjA4NSw3Ljk5NCwxOS40MTRjNS4zMyw1LjMyOCwxMS44MDEsNy45OSwxOS40MTQsNy45OWg0MjAuMjY2ICAgIGM3LjYxLDAsMTQuMDg2LTIuNjYyLDE5LjQxLTcuOTljNS4zMzItNS4zMjksNy45OTQtMTEuOCw3Ljk5NC0xOS40MTR2LTkxLjM1OEM0NzUuMDc4LDMzMC40MjcsNDcyLjQxNiwzMjMuOTU1LDQ2Ny4wODMsMzE4LjYyN3ogICAgIE0zNjAuMDI1LDQxNC44NDFjLTMuNjIxLDMuNjE3LTcuOTA1LDUuNDI0LTEyLjg1NCw1LjQyNHMtOS4yMjctMS44MDctMTIuODQ3LTUuNDI0Yy0zLjYxNC0zLjYxNy01LjQyMS03Ljg5OC01LjQyMS0xMi44NDQgICAgYzAtNC45NDgsMS44MDctOS4yMzYsNS40MjEtMTIuODQ3YzMuNjItMy42Miw3Ljg5OC01LjQzMSwxMi44NDctNS40MzFzOS4yMzIsMS44MTEsMTIuODU0LDUuNDMxICAgIGMzLjYxMywzLjYxLDUuNDIxLDcuODk4LDUuNDIxLDEyLjg0N0MzNjUuNDQ2LDQwNi45NDIsMzYzLjYzOCw0MTEuMjI0LDM2MC4wMjUsNDE0Ljg0MXogTTQzMy4xMDksNDE0Ljg0MSAgICBjLTMuNjE0LDMuNjE3LTcuODk4LDUuNDI0LTEyLjg0OCw1LjQyNGMtNC45NDgsMC05LjIyOS0xLjgwNy0xMi44NDctNS40MjRjLTMuNjEzLTMuNjE3LTUuNDItNy44OTgtNS40Mi0xMi44NDQgICAgYzAtNC45NDgsMS44MDctOS4yMzYsNS40Mi0xMi44NDdjMy42MTctMy42Miw3Ljg5OC01LjQzMSwxMi44NDctNS40MzFjNC45NDksMCw5LjIzMywxLjgxMSwxMi44NDgsNS40MzEgICAgYzMuNjE3LDMuNjEsNS40MjcsNy44OTgsNS40MjcsMTIuODQ3QzQzOC41MzYsNDA2Ljk0Miw0MzYuNzI5LDQxMS4yMjQsNDMzLjEwOSw0MTQuODQxeiIgZmlsbD0iIzAwMDAwMCIvPgoJCTxwYXRoIGQ9Ik0yMjQuNjkyLDMyMy40NzljMy40MjgsMy42MTMsNy43MSw1LjQyMSwxMi44NDcsNS40MjFjNS4xNDEsMCw5LjQxOC0xLjgwOCwxMi44NDctNS40MjFsMTI3LjkwNy0xMjcuOTA4ICAgIGM1Ljg5OS01LjUxOSw3LjIzNC0xMi4xODIsMy45OTctMTkuOTg2Yy0zLjIzLTcuNDIxLTguODQ3LTExLjEzMi0xNi44NDQtMTEuMTM2aC03My4wOTFWMzYuNTQzYzAtNC45NDgtMS44MTEtOS4yMzEtNS40MjEtMTIuODQ3ICAgIGMtMy42Mi0zLjYxNy03LjkwMS01LjQyNi0xMi44NDctNS40MjZoLTczLjA5NmMtNC45NDYsMC05LjIyOSwxLjgwOS0xMi44NDcsNS40MjZjLTMuNjE1LDMuNjE2LTUuNDI0LDcuODk4LTUuNDI0LDEyLjg0N1YxNjQuNDUgICAgaC03My4wODljLTcuOTk4LDAtMTMuNjEsMy43MTUtMTYuODQ2LDExLjEzNmMtMy4yMzQsNy44MDEtMS45MDMsMTQuNDY3LDMuOTk5LDE5Ljk4NkwyMjQuNjkyLDMyMy40Nzl6IiBmaWxsPSIjMDAwMDAwIi8+Cgk8L2c+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==" height="20px"/></a></span>
                            </div>
                        </div>
                       
                    </div>
                      <!-- INICIO CZ SPRINT 62 -->
                      <div style="margin-top: -15px; margin-left: 2px;"><small>Sólo subir archivos con las siguientes extensiones: ".pdf", ".jpeg", ".jpg" y ".png".</small></div>   
                    <br>                    
                    <div style="margin-top: -15px; margin-left: 2px;"><small>Maximo tamaño permitido: 4.000 MB (4.000.000 bytes)</small></div>
                    @endif
                    <!-- FIN CZ SPRINT 62 -->
                    <br>
                    <!-- inicio ch -->
                    <div class="table-responsive">
                      <table class="table table-striped">
                        <thead>
                            <th>Nombre del documento: </th>
                            <th>Fecha del documento: </th>
                            <th>Descarga del documento: </th>
                            @if(session()->all()['perfil'] != config('constantes.perfil_coordinador_regional') && session()->all()['perfil'] != config('constantes.perfil_coordinador'))
                            <!-- INICO CZ SPRINT 67 -->
                            <th>Acción</th>
                            <!-- FIN CZ SPRINT 67 -->
                            @endif
                        </thead>
                        <tbody id="ACT"></tbody>
                    </table>
                    </div>
                    <!-- fin ch -->
                </div>
            </div>
        </div>

        <div class="card colapsable shadow-sm" id="contenedor_materiales">
        <!-- inicio ch -->
            <a class="btn text-left p-0 collapsed" id="desplegar_materiales" data-toggle="collapse" data-target="#collapseTwo" aria-controls="collapseTwo" aria-expanded="false" onclick="if($(this).attr('aria-expanded') == 'false') gethistorialData({{ config('constantes.tip_materiales') }});">
                <div class="card-header" id="headingTwo">
                    <h5 class="mb-0">
                        <button class="btn btn-info" type="button" data-toggle="collapse" aria-expanded="false"><!-- fin ch -->
                        <i class="fa fa-info"></i></button> &nbsp;&nbsp;Materiales
                    </h5>
                </div>
            </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                    <div class="card-body">
                    <br>
                        <div class="alert alert-success alert-dismissible fade show" id="alert-doc6" role="alert" style="display: none;">
                            Documento Guardado Exitosamente.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="alert alert-danger alert-dismissible fade show" id="alert-err-doc6" role="alert" style="display: none;">
                            Error al momento de guardar el registro. Por favor intente nuevamente.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <!-- INICIO CZ SPRINT 62 -->
                        <div class="alert alert-danger alert-dismissible fade show" id="alert-err-doc-ext6" role="alert" style="display: none;">
                            EL formato del archivo no es permitido. Sólo subir archivos con las siguientes extensiones: ".pdf", ".jpeg", ".jpeg", ".jpg" y ".png"
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <!-- FIN CZ SPRINT 62 -->

                        <h6 class="text-center">Cargue el documento de materiales, debe ser digitalizado (escaneo o fotografía).</h6>
                        <br>
                        @if(session()->all()['perfil'] != config("constantes.perfil_administrador_central") && session()->all()['perfil'] != config("constantes.perfil_coordinador_regional"))

                        <div class="input-group mb-3">
                        <!-- INICIO CZ -->
                            <!-- <form method="POST" action="{{ route('hist.doc.cargar') }}" enctype="multipart/form-data">
                            <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                            <input name="tipo_gestion" type="hidden" value="{{$tipo_gestion}}"/>
                            <input name="tipo" type="hidden" value="6"/>
                            <input name="pro_an_id" type="hidden" value="{{$pro_an_id}}"/>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="doc_mat" lang="es" name="doc_actas" require onchange="fun">
                                <label class="custom-file-label" for="doc_mat">Seleccionar Archivo</label>
                            </div>
                            <input type="submit" value="Subir">
                            </form> -->
                           
                            <form method="post" action="#" enctype="multipart/form-data" id="adj_doc_mat">
                                <div class="custom-file" style="z-index:0;">
                                    <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                                    <input name="tipo_gestion" type="hidden" value="{{$tipo_gestion}}"/>
                                    <input name="tipo_doc_mat" type="hidden" value="6"/>
                                    <input name="pro_an_id" type="hidden" value="{{$pro_an_id}}"/>
                                   <!-- INICIO CZ SPRINT 62 -->
                                   <input type="file" class="custom-file-input doc_mat" name="doc_actas" id="doc_actas" onchange="enviarData('doc_mat')">
                                    <!-- FIN CZ SPRINT 62 -->
                                        <label class="custom-file-label" for="doc_actas" aria-describedby="inputGroupFileAddon02">Cargar archivo</label>
                                </div>
                            </form>
                        <!-- FIN CZ -->
                            <div id="descargar_materiales" style="display: none;">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="inputGroupFileAddon06"><a download href="" id="ruta_documento_materiales"><img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjUxMnB4IiBoZWlnaHQ9IjUxMnB4IiB2aWV3Qm94PSIwIDAgNDc1LjA3OCA0NzUuMDc3IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA0NzUuMDc4IDQ3NS4wNzc7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4KPGc+Cgk8Zz4KCQk8cGF0aCBkPSJNNDY3LjA4MywzMTguNjI3Yy01LjMyNC01LjMyOC0xMS44LTcuOTk0LTE5LjQxLTcuOTk0SDMxNS4xOTVsLTM4LjgyOCwzOC44MjdjLTExLjA0LDEwLjY1Ny0yMy45ODIsMTUuOTg4LTM4LjgyOCwxNS45ODggICAgYy0xNC44NDMsMC0yNy43ODktNS4zMjQtMzguODI4LTE1Ljk4OGwtMzguNTQzLTM4LjgyN0gyNy40MDhjLTcuNjEyLDAtMTQuMDgzLDIuNjY5LTE5LjQxNCw3Ljk5NCAgICBDMi42NjQsMzIzLjk1NSwwLDMzMC40MjcsMCwzMzguMDQ0djkxLjM1OGMwLDcuNjE0LDIuNjY0LDE0LjA4NSw3Ljk5NCwxOS40MTRjNS4zMyw1LjMyOCwxMS44MDEsNy45OSwxOS40MTQsNy45OWg0MjAuMjY2ICAgIGM3LjYxLDAsMTQuMDg2LTIuNjYyLDE5LjQxLTcuOTljNS4zMzItNS4zMjksNy45OTQtMTEuOCw3Ljk5NC0xOS40MTR2LTkxLjM1OEM0NzUuMDc4LDMzMC40MjcsNDcyLjQxNiwzMjMuOTU1LDQ2Ny4wODMsMzE4LjYyN3ogICAgIE0zNjAuMDI1LDQxNC44NDFjLTMuNjIxLDMuNjE3LTcuOTA1LDUuNDI0LTEyLjg1NCw1LjQyNHMtOS4yMjctMS44MDctMTIuODQ3LTUuNDI0Yy0zLjYxNC0zLjYxNy01LjQyMS03Ljg5OC01LjQyMS0xMi44NDQgICAgYzAtNC45NDgsMS44MDctOS4yMzYsNS40MjEtMTIuODQ3YzMuNjItMy42Miw3Ljg5OC01LjQzMSwxMi44NDctNS40MzFzOS4yMzIsMS44MTEsMTIuODU0LDUuNDMxICAgIGMzLjYxMywzLjYxLDUuNDIxLDcuODk4LDUuNDIxLDEyLjg0N0MzNjUuNDQ2LDQwNi45NDIsMzYzLjYzOCw0MTEuMjI0LDM2MC4wMjUsNDE0Ljg0MXogTTQzMy4xMDksNDE0Ljg0MSAgICBjLTMuNjE0LDMuNjE3LTcuODk4LDUuNDI0LTEyLjg0OCw1LjQyNGMtNC45NDgsMC05LjIyOS0xLjgwNy0xMi44NDctNS40MjRjLTMuNjEzLTMuNjE3LTUuNDItNy44OTgtNS40Mi0xMi44NDQgICAgYzAtNC45NDgsMS44MDctOS4yMzYsNS40Mi0xMi44NDdjMy42MTctMy42Miw3Ljg5OC01LjQzMSwxMi44NDctNS40MzFjNC45NDksMCw5LjIzMywxLjgxMSwxMi44NDgsNS40MzEgICAgYzMuNjE3LDMuNjEsNS40MjcsNy44OTgsNS40MjcsMTIuODQ3QzQzOC41MzYsNDA2Ljk0Miw0MzYuNzI5LDQxMS4yMjQsNDMzLjEwOSw0MTQuODQxeiIgZmlsbD0iIzAwMDAwMCIvPgoJCTxwYXRoIGQ9Ik0yMjQuNjkyLDMyMy40NzljMy40MjgsMy42MTMsNy43MSw1LjQyMSwxMi44NDcsNS40MjFjNS4xNDEsMCw5LjQxOC0xLjgwOCwxMi44NDctNS40MjFsMTI3LjkwNy0xMjcuOTA4ICAgIGM1Ljg5OS01LjUxOSw3LjIzNC0xMi4xODIsMy45OTctMTkuOTg2Yy0zLjIzLTcuNDIxLTguODQ3LTExLjEzMi0xNi44NDQtMTEuMTM2aC03My4wOTFWMzYuNTQzYzAtNC45NDgtMS44MTEtOS4yMzEtNS40MjEtMTIuODQ3ICAgIGMtMy42Mi0zLjYxNy03LjkwMS01LjQyNi0xMi44NDctNS40MjZoLTczLjA5NmMtNC45NDYsMC05LjIyOSwxLjgwOS0xMi44NDcsNS40MjZjLTMuNjE1LDMuNjE2LTUuNDI0LDcuODk4LTUuNDI0LDEyLjg0N1YxNjQuNDUgICAgaC03My4wODljLTcuOTk4LDAtMTMuNjEsMy43MTUtMTYuODQ2LDExLjEzNmMtMy4yMzQsNy44MDEtMS45MDMsMTQuNDY3LDMuOTk5LDE5Ljk4NkwyMjQuNjkyLDMyMy40Nzl6IiBmaWxsPSIjMDAwMDAwIi8+Cgk8L2c+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==" height="20px"/></a></span>
                                </div>
                            </div>
                           
                        </div>
                         <!-- INICIO CZ SPRINT 62 -->
                         <div style="margin-top: -15px; margin-left: 2px;"><small>Sólo subir archivos con las siguientes extensiones: ".pdf", ".jpeg", ".jpg" y ".png".</small></div>
                        
                        <br>
                       
                        <div style="margin-top: -15px; margin-left: 2px;"><small>Maximo tamaño permitido: 4.000 MB (4.000.000 bytes)</small></div>
                        @endif
                        <!-- FIN CZ SPRINT 62 -->                        <br>
                        <!-- inicio ch -->
                        <div class="table-responsive">
                          <table class="table table-striped">
                            <thead>
                                <th>Nombre del documento: </th>
                                <th>Fecha del documento: </th>
                                <th>Descarga del documento: </th>
                                @if(session()->all()['perfil'] != config('constantes.perfil_coordinador_regional') && session()->all()['perfil'] != config('constantes.perfil_coordinador'))
                                <!-- INICO CZ SPRINT 67 -->
                                <th>Acción</th>
                                <!-- FIN CZ SPRINT 67 -->
                                @endif
                            </thead>
                            <tbody id="MAT"></tbody>       
                        </table>
                        </div>
                        <!-- fin ch -->
                    </div>
                </div>
        </div>
    @if($tipo_gestion != 1)
        <div class="card colapsable shadow-sm" id="contenedor_asentamientos">
        <!-- inicio ch -->
            <a class="btn text-left p-0 collapsed" id="desplegar_asentamientos" data-toggle="collapse" data-target="#collapseThree" aria-controls="collapseThree" aria-expanded="false" onclick="if($(this).attr('aria-expanded') == 'false') gethistorialData({{ config('constantes.tip_asentamientos_consentimientos') }});">
                <div class="card-header" id="headingThree">
                    <h5 class="mb-0">
                        <button class="btn btn-info" type="button" data-toggle="collapse" aria-expanded="false" > <!-- fin ch -->
                        <i class="fa fa-info"></i></button> &nbsp;&nbsp;Asentimientos y Consentimientos
                    </h5>
                </div>
            </a>    
                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                    <div class="card-body">
                    <br>
                        <div class="alert alert-success alert-dismissible fade show" id="alert-doc7" role="alert" style="display: none;">
                            Documento Guardado Exitosamente.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="alert alert-danger alert-dismissible fade show" id="alert-err-doc7" role="alert" style="display: none;">
                            Error al momento de guardar el registro. Por favor intente nuevamente.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <!-- INICIO CZ SPRINT 62 -->
                        <div class="alert alert-danger alert-dismissible fade show" id="alert-err-doc-ext7" role="alert" style="display: none;">
                            EL formato del archivo no es permitido. Sólo subir archivos con las siguientes extensiones: ".pdf", ".jpeg", ".jpg" y ".png"
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <!-- FIN CZ SPRINT 62 -->

                        <h6 class="text-center">Cargue el documento de asentimientos y consentimientos, debe ser digitalizado (escaneo o fotografía).</h6>
                        <br>
                        @if(session()->all()['perfil'] != config("constantes.perfil_administrador_central") && session()->all()['perfil'] != config("constantes.perfil_coordinador_regional"))

                        <div class="input-group mb-3">
                        <!-- INICIO CZ -->
                            <!-- <form method="POST" action="{{ route('hist.doc.cargar') }}" enctype="multipart/form-data">
                                <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                                <input name="tipo_gestion" type="hidden" value="{{$tipo_gestion}}"/>
                                <input name="tipo" type="hidden" value="7"/>
                                <input name="pro_an_id" type="hidden" value="{{$pro_an_id}}"/>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="doc_asent" lang="es" name="doc_actas" require required>
                                    <label class="custom-file-label" for="doc_asent">Seleccionar Archivo</label>
                                </div>
                                <input type="submit" value="Subir"> 
                            </form> -->
                            
                            <form method="post" action="#" enctype="multipart/form-data" id="adj_doc_asent">
                                <div class="custom-file" style="z-index:0;">
                                    <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                                    <input name="tipo_gestion" type="hidden" value="{{$tipo_gestion}}"/>
                                    <input name="tipo_doc_asent" type="hidden" value="7"/>
                                    <input name="pro_an_id" type="hidden" value="{{$pro_an_id}}"/>
                                    <!-- INICIO CZ SPRINT 62 -->
                                    <input type="file" class="custom-file-input doc_asent" name="doc_actas" id="doc_actas" onchange="enviarData('doc_asent')">
                                    <!-- FIN CZ SPRINT 62 -->
                                        <label class="custom-file-label" for="doc_actas" aria-describedby="inputGroupFileAddon02">Cargar archivo</label>
                                </div>
                            </form>
                        <!-- FIN CZ  -->
                            <div id="descargar_asentamiento" style="display: none;">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="inputGroupFileAddon07"><a download href="" id="ruta_documento_asentamiento"><img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjUxMnB4IiBoZWlnaHQ9IjUxMnB4IiB2aWV3Qm94PSIwIDAgNDc1LjA3OCA0NzUuMDc3IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA0NzUuMDc4IDQ3NS4wNzc7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4KPGc+Cgk8Zz4KCQk8cGF0aCBkPSJNNDY3LjA4MywzMTguNjI3Yy01LjMyNC01LjMyOC0xMS44LTcuOTk0LTE5LjQxLTcuOTk0SDMxNS4xOTVsLTM4LjgyOCwzOC44MjdjLTExLjA0LDEwLjY1Ny0yMy45ODIsMTUuOTg4LTM4LjgyOCwxNS45ODggICAgYy0xNC44NDMsMC0yNy43ODktNS4zMjQtMzguODI4LTE1Ljk4OGwtMzguNTQzLTM4LjgyN0gyNy40MDhjLTcuNjEyLDAtMTQuMDgzLDIuNjY5LTE5LjQxNCw3Ljk5NCAgICBDMi42NjQsMzIzLjk1NSwwLDMzMC40MjcsMCwzMzguMDQ0djkxLjM1OGMwLDcuNjE0LDIuNjY0LDE0LjA4NSw3Ljk5NCwxOS40MTRjNS4zMyw1LjMyOCwxMS44MDEsNy45OSwxOS40MTQsNy45OWg0MjAuMjY2ICAgIGM3LjYxLDAsMTQuMDg2LTIuNjYyLDE5LjQxLTcuOTljNS4zMzItNS4zMjksNy45OTQtMTEuOCw3Ljk5NC0xOS40MTR2LTkxLjM1OEM0NzUuMDc4LDMzMC40MjcsNDcyLjQxNiwzMjMuOTU1LDQ2Ny4wODMsMzE4LjYyN3ogICAgIE0zNjAuMDI1LDQxNC44NDFjLTMuNjIxLDMuNjE3LTcuOTA1LDUuNDI0LTEyLjg1NCw1LjQyNHMtOS4yMjctMS44MDctMTIuODQ3LTUuNDI0Yy0zLjYxNC0zLjYxNy01LjQyMS03Ljg5OC01LjQyMS0xMi44NDQgICAgYzAtNC45NDgsMS44MDctOS4yMzYsNS40MjEtMTIuODQ3YzMuNjItMy42Miw3Ljg5OC01LjQzMSwxMi44NDctNS40MzFzOS4yMzIsMS44MTEsMTIuODU0LDUuNDMxICAgIGMzLjYxMywzLjYxLDUuNDIxLDcuODk4LDUuNDIxLDEyLjg0N0MzNjUuNDQ2LDQwNi45NDIsMzYzLjYzOCw0MTEuMjI0LDM2MC4wMjUsNDE0Ljg0MXogTTQzMy4xMDksNDE0Ljg0MSAgICBjLTMuNjE0LDMuNjE3LTcuODk4LDUuNDI0LTEyLjg0OCw1LjQyNGMtNC45NDgsMC05LjIyOS0xLjgwNy0xMi44NDctNS40MjRjLTMuNjEzLTMuNjE3LTUuNDItNy44OTgtNS40Mi0xMi44NDQgICAgYzAtNC45NDgsMS44MDctOS4yMzYsNS40Mi0xMi44NDdjMy42MTctMy42Miw3Ljg5OC01LjQzMSwxMi44NDctNS40MzFjNC45NDksMCw5LjIzMywxLjgxMSwxMi44NDgsNS40MzEgICAgYzMuNjE3LDMuNjEsNS40MjcsNy44OTgsNS40MjcsMTIuODQ3QzQzOC41MzYsNDA2Ljk0Miw0MzYuNzI5LDQxMS4yMjQsNDMzLjEwOSw0MTQuODQxeiIgZmlsbD0iIzAwMDAwMCIvPgoJCTxwYXRoIGQ9Ik0yMjQuNjkyLDMyMy40NzljMy40MjgsMy42MTMsNy43MSw1LjQyMSwxMi44NDcsNS40MjFjNS4xNDEsMCw5LjQxOC0xLjgwOCwxMi44NDctNS40MjFsMTI3LjkwNy0xMjcuOTA4ICAgIGM1Ljg5OS01LjUxOSw3LjIzNC0xMi4xODIsMy45OTctMTkuOTg2Yy0zLjIzLTcuNDIxLTguODQ3LTExLjEzMi0xNi44NDQtMTEuMTM2aC03My4wOTFWMzYuNTQzYzAtNC45NDgtMS44MTEtOS4yMzEtNS40MjEtMTIuODQ3ICAgIGMtMy42Mi0zLjYxNy03LjkwMS01LjQyNi0xMi44NDctNS40MjZoLTczLjA5NmMtNC45NDYsMC05LjIyOSwxLjgwOS0xMi44NDcsNS40MjZjLTMuNjE1LDMuNjE2LTUuNDI0LDcuODk4LTUuNDI0LDEyLjg0N1YxNjQuNDUgICAgaC03My4wODljLTcuOTk4LDAtMTMuNjEsMy43MTUtMTYuODQ2LDExLjEzNmMtMy4yMzQsNy44MDEtMS45MDMsMTQuNDY3LDMuOTk5LDE5Ljk4NkwyMjQuNjkyLDMyMy40Nzl6IiBmaWxsPSIjMDAwMDAwIi8+Cgk8L2c+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==" height="20px"/></a></span>
                                </div>
                            </div>
                            
                        </div>
                          <!-- INICIO CZ SPRINT 62 -->
                          <div style="margin-top: -15px; margin-left: 2px;"><small>Sólo subir archivos con las siguientes extensiones: ".pdf", ".jpeg", ".jpg" y ".png".</small></div>
                        <br>
                        <div style="margin-top: -15px; margin-left: 2px;"><small>Maximo tamaño permitido: 4.000 MB (4.000.000 bytes)</small></div>
                        @endif
                        <!-- FIN CZ SPRINT 62 -->                        <br>
                        <!-- inicio ch -->
                        <div class="table-responsive">
                          <table class="table table-striped">
                            <thead>
                                <th>Nombre del documento: </th>
                                <th>Fecha del documento: </th>
                                <th>Descarga del documento: </th>
                                @if(session()->all()['perfil'] != config('constantes.perfil_coordinador_regional') && session()->all()['perfil'] != config('constantes.perfil_coordinador'))
                                <!-- INICO CZ SPRINT 67 -->
                                <th>Acción</th>
                                <!-- FIN CZ SPRINT 67 -->
                                @endif
                            </thead>
                            <tbody id="ASENT"></tbody>
                        </table>
                        </div>
                        <!-- fin ch -->
                    </div>
                </div>
        </div>
    @endif    
    </div>
</div>
<script type="text/javascript"> 
    function gethistorialData(tipo_documento){
    	//INICIO DC
    	
    	if($('#desestimado').val() == 1 || $('#est_pro_id').val() == 3){
        	$('input').attr('disabled', 'disabled');
        }
        if('{{ Session::get('perfil') }}' == 2){
        	$('.custom-file-input').attr('disabled', 'disabled');
        }
		//FIN DC
        let data = {
            'pro_an_id' : {{$pro_an_id}},
            'tipo_gestion' : {{$tipo_gestion}}
        };

        $.ajax({
            type:"GET",
            url: "{{route('hist.documentos.data')}}",
            data: data
        }).done(function(resp){
        if(resp.estado == 1){
        
                if(resp.alas != "-"){
                    //$('#descargar_acta').show();
                    //$("#ruta_documento_actas").attr("href","../../doc/"+resp.alas);
                    
                    
                    if (tipo_documento == 5) {
                        let valor = resp.alas; 
                        $("#ACT").empty();
                        $('#ACT').html(valor);
                        }
                    }
            if(resp.mater != "-"){
                    //$('#descargar_materiales').show();
                    //$("#ruta_documento_materiales").attr("href","../../doc/"+resp.mater);
                   
                    
                    if (tipo_documento == 6) {
                        let valor = resp.mater; 
                        $("#MAT").empty();
                        $('#MAT').html(valor);
                }
                }

                if(resp.asycon != "-"){
                    //$('#descargar_asentamientos').show();
                    //$("#ruta_documento_asentamientos").attr("href","../../doc/"+resp.asycon);
                                      
                    if (tipo_documento == 7) {
                        let valor = resp.asycon; 
                    $("#ASENT").empty();
                        $('#ASENT').html(valor);
                }//inicio ch se borra corchete de más
                }//fin ch
            }

        //INICIO CZ SPRINT 67 correccion
         if($("#est_pro_id").val() == {{ config('constantes.finalizado') }} || $("#est_pro_id").val() == {{ config('constantes.desestimado') }} ){
            $('.btn-danger').attr('disabled', 'disabled');
        }
        //FIN CZ SPRINT 67 correccion

        }).fail(function(objeto, tipoError, errorHttp){            

            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

            return false;
        });
        
    }
    function limpiarMensajesDocumentos(){
        $("#alert-doc5").hide();
        $("#alert-err-doc5").hide();
        $("#alert-err-doc-ext5").hide();

        $("#alert-doc6").hide();
        $("#alert-err-doc6").hide();
        $("#alert-err-doc-ext6").hide();

        $("#alert-doc7").hide();
        $("#alert-err-doc7").hide();
        $("#alert-err-doc-ext7").hide();

    }
 

    
</script>
<!-- CZ-->
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script>
function enviarData(parametro){
    cargarhistorialDoc(parametro);
}
function cargarhistorialDoc(parametro){
    bloquearPantalla();
    //console.log(parametro);
    if(parametro ==  "doc_actas"){
        //console.log("entro un archivo doc_actas");
        var form = document.getElementById("adj_doc_actas");
    }else if(parametro == "doc_mat"){
        //console.log("entro un archivo doc_mat");
        var form = document.getElementById("adj_doc_mat");
    }else if(parametro == "doc_asent"){
        //console.log("entro un archivo doc_asent");
        var form = document.getElementById("adj_doc_asent");
    }


    var formData = new FormData(form);
    formData.append('_token', $('input[name=_token]').val());
    formData.append('tipo_gestion', $('input[name=tipo_gestion]').val());
    formData.append('pro_an_id', $('input[name=pro_an_id]').val());

    if(parametro ==  "doc_actas"){
        //console.log("entro un archivo doc_actas");
        formData.append('tipo', $('input[name=tipo]').val());
    }else if(parametro == "doc_mat"){
        //console.log("entro un archivo doc_mat");
        formData.append('tipo', $('input[name=tipo_doc_mat]').val());
    }else if(parametro == "doc_asent"){
        //console.log("entro un archivo doc_asent");
        formData.append('tipo', $('input[name=tipo_doc_asent]').val());
    }
    // INICIO CZ SPRINT 62
    var imgsize = document.getElementsByClassName(parametro)[0].files[0].size;
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
    url: '{{ route("hist.doc.cargar") }}',
    type: 'POST',
    data: formData,
    contentType: false,
    processData: false,
        success: function(response) {
                    //console.log(response);
            if (response.estado == 1){

                if(parametro ==  "doc_actas"){
                    $("#alert-doc5").css('display', 'block')
                    $("#alert-err-doc5").css('display', 'none');
                    $("#alert-err-doc-ext5").css('display', 'none');
                    // INICIO CZ SPRINT 67
                    gethistorialData({{ config('constantes.tip_acta_listas_asistencias') }});
                    // FIN CZ SPRINT 67
                }else if(parametro ==  "doc_mat"){
                    $("#alert-doc6").css('display', 'block')
                    $("#alert-err-doc6").css('display', 'none');
                    $("#alert-err-doc-ext6").css('display', 'none');
                    // INICIO CZ SPRINT 67
                    gethistorialData({{ config('constantes.tip_materiales') }});
                    // FIN CZ SPRINT 67
                }else if(parametro ==  "doc_asent"){
                    $("#alert-doc7").css('display', 'block')
                    $("#alert-err-doc7").css('display', 'none');
                    $("#alert-err-doc-ext7").css('display', 'none');
                    // INICIO CZ SPRINT 67
                    gethistorialData({{ config('constantes.tip_asentamientos_consentimientos') }});
                    // FIN CZ SPRINT 67
                }
                
                // listarInformeAnexos();
                if(parametro ==  "doc_actas"){
                    setTimeout(function(){
                    $("#alert-doc6").css('display', 'none');
                }, 3000);
                }else if(parametro ==  "doc_mat"){
                    setTimeout(function(){
                    $("#alert-doc6").css('display', 'none');
                }, 3000);
                }else if(parametro ==  "doc_asent"){
                    setTimeout(function(){
                    $("#alert-doc6").css('display', 'none');
                }, 3000);
                }

            }else if (response.estado == 0){
                if(parametro ==  "doc_actas"){
                    $("#alert-err-doc5").css('display', 'block');
                    setTimeout(function(){ $("#alert-err-doc5").css('display', 'none'); }, 5000);
                }else if(parametro ==  "doc_mat"){
                    $("#alert-err-doc6").css('display', 'block');
                    setTimeout(function(){ $("#alert-err-doc6").css('display', 'none'); }, 5000);
                }else if(parametro ==  "doc_asent"){
                    $("#alert-err-doc7").css('display', 'block');
                    setTimeout(function(){ $("#alert-err-doc7").css('display', 'none'); }, 5000);
                }
            }else{
                if(parametro ==  "doc_actas"){
                    $("#alert-err-doc-ext5").css('display', 'block');
                    setTimeout(function(){ $("#alert-err-doc-ext5").css('display', 'none'); }, 5000);

                }else if(parametro ==  "doc_mat"){
                    $("#alert-err-doc-ext6").css('display', 'block');
                    setTimeout(function(){ $("#alert-err-doc-ext6").css('display', 'none'); }, 5000);

                }else if(parametro ==  "doc_asent"){
                    $("#alert-err-doc-ext7").css('display', 'block');
                    setTimeout(function(){ $("#alert-err-doc-ext7").css('display', 'none'); }, 5000);
                }

            }
            desbloquearPantalla();
        },
        error: function(jqXHR, text, error){
            desbloquearPantalla();
                if(parametro ==  "doc_actas"){
                    $("#alert-doc5").css('display', 'none')
                    $("#alert-err-doc-ext5").css('display', 'block');
                    setTimeout(function(){ $("#alert-err-doc-ext5").css('display', 'none'); }, 5000);

                }else if(parametro ==  "doc_mat"){
                    $("#alert-doc6").css('display', 'none')
                    $("#alert-err-doc-ext6").css('display', 'block');
                    setTimeout(function(){ $("#alert-err-doc-ext6").css('display', 'none'); }, 5000);

                }else if(parametro ==  "doc_asent"){
                    $("#alert-doc7").css('display', 'none')
                    $("#alert-err-doc-ext7").css('display', 'block');
                    setTimeout(function(){ $("#alert-err-doc-ext7").css('display', 'none'); }, 5000);
                }
                manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
        }
    });
    }
    return false;
    // FIN CZ SPRINT 62
}

// INICIO CZ SPRINT 67
function eliminarDocumento(tipo, id){
    document.getElementById('btn-ok').setAttribute('onclick','eliminarDocumentos('+id+','+tipo+', '+$('input[name=pro_an_id]').val()+', '+$('input[name=tipo_gestion]').val()+')');
   
}
// FIN CZ SPRINT 67
</script> 
<!-- INICIO CZ SPRINT 67 -->
@include('gestor_comunitario.gestion_comunitaria.historial_documentos.confirm_popup')
<!-- FIN CZ SPRINT 67 -->