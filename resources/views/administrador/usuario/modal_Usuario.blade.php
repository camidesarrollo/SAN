<!-- //CZ 75 -->
<div id="modalAgregarUsuario" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content p-4">
            <div class="modal-header">
                <div style="margin: 0 auto;">
                    <h5 id="titulo_modal"></h5>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                    style="position: absolute; margin: 0; top: 5px; right: 33px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" class="form-control" id="id_usuario" name="id_usuario">
                <div class="row">
                    <label class="lblAdd col-form-label">RUN:</label>
                    <div class="col-sm-5">
                        <!-- <input type="text" id="addRun" class="form-control inputRut" onKeyPress="return soloNumeros(event)" autocomplete="off"> -->
                        <input type="input" class="form-control" id="nna_run" name="nna_run" placeholder="Ej. 20.667.876-2" autocomplete="off">
                        <p id="val_nna_run" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;"></p>
                    </div>
                </div>
                <div class="row">
                    <label class="lblAdd col-form-label">Nombres:</label>
                    <div class="col-sm-3">
                        <input type="text" id="addNombres" class="form-control" disabled="disabled">
                    </div>
                </div>
                <div class="row">
                    <label class="lblAdd col-form-label">Apellido 1:</label>
                    <div class="col-sm-3">
                        <input type="text" id="addApePat" class="form-control" disabled="disabled">
                    </div>
                </div>
                <div class="row">
                    <label class="lblAdd col-form-label">Apellido 2:</label>
                    <div class="col-sm-3">
                        <input type="text" id="addApeMat" class="form-control" disabled="disabled">
                    </div>
                </div>
                <div class="row">
                    <label class="lblAdd col-form-label">Teléfono:</label>
                    <div class="col-sm-3">
                        <input type="text" id="addFono" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <label class="lblAdd col-form-label">Mail:</label>
                    <div class="col-sm-3">
                        <input type="text" id="addMail" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <label class="lblAdd col-form-label">Perfil:</label>
                    <div class="col-sm-3">
                        <select id="addPerfil" name="addPerfil" class="form-control" onchange="cambioPerfil(this.value)">
                            <option value="0">Seleccione un Perfil</option>
                            @foreach($perfiles as $value)
                            <option value="{{$value->id}}">{{$value->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <label class="lblAdd col-form-label">Región:</label>
                    <div class="col-sm-3">
                        <select id="addRegion" name="addRegion" class="form-control" onchange="getComunas(this.value)">
                            <option value="0">Seleccione una Región</option>
                        </select>
                    </div>
                </div>
                <div class="row" id="row_comuna">
                    <label class="lblAdd col-form-label">Comuna:</label>
                    <div class="col-sm-3">
                        <select id="addComuna" name="addComuna" class="form-control">
                            <option value="0">Seleccione una Comuna</option>
                        </select>
                    </div>
                </div>
                @php $instituciones = Helper::getInstituciones(); @endphp
                <div class="row">
                    <label class="lblAdd col-form-label">Nombre Institución:</label>
                    <div class="col-sm-3">
                        <table>
                            <tr>
                                <td>
                                    <select id="addInstituciones" name="addInstituciones" class="form-control">
                                        <option value="0">Seleccione una Institución</option>
                                        @foreach($instituciones as $value)
                                        <option value="{{$value->id_ins}}">{{$value->nom_ins}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-success" onclick="addInstitucion();">+</button>
                                </td>
                            </tr>
                        </table>

                    </div>
                </div>
                <div class="row">
                    <label class="lblAdd col-form-label ">Clave Provisoria</label>

                    <div class="input-group col-sm-6">
                        <input class="form-control" type="password" id="clave" disabled>
                        <div class="input-group-append" id="show_hide_password">
                            <span class="input-group-text" id="basic-addon2"><i class="fas fa-eye-slash"
                                    id="icono-ojo"></i></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label class="lblAdd col-form-label">Vigente en SAN:</label>
                    <div class="col-sm-5">
                        <input type="checkbox" id="checkVigente" class="vigencia-agregar">
                        <span class="badge badge-pill badge-danger" style="display:none" id="mensaje-agregar">Usuario
                            quedara inactivo del sistema</span>
                    </div>
                    <span class="badge badge-pill badge-danger" style="font-size: small !important; display: none"
                    id="mensaje-SSO-SAN">El usuario ya existe en SAN, si desea modificarlo, seleccione editar en la
                    busqueda de usuarios.</span>
                </div>
            </div>
            <div class="modal-footer" style="background-color: white;">
                    <div>
                    <!-- CZ SPRINT 77 -->
                    <button type="button" class="btn btn-primary" onclick="guardarUsuario_2();"
                        id="botonGuardar">Guardar usuario</button>
                    <button type="button" class="btn btn-primary" onclick="asignarRoles();"
                        id="botonGuardar">Asignar Roles SSO</button>
                    <button type="button" class="btn btn-primary" onclick="eliminarVigencia();"
                        id="boton_eliminarVigencia">Eliminar Vigencia SSO</button>
                        <button type="button" class="btn btn-primary" onclick="limpiar_formulario();" id="limpiarFormulario">Limpiar Formulario</button>

                <!-- <button type="button" class="btn btn-primary" onclick="guardarUsuario();"
                    id="botonGuardar">Guardar</button> -->
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
</div>

