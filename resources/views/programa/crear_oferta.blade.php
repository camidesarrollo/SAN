<div id="formComponentes" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="formComponentesLabel" aria-hidden="true">
    
    <div class="modal-dialog modal-lg">
        <div class="modal-content p-4">
            <div class="card p-4 shadow-sm">
                <h5 class="modal-title" id="formComponentesLabel"><b>Agregar Componente</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="position: absolute; right: 5px; top: 5px; width: 23px; height: 23px; padding: 0; margin: 0;">&times;</span>
                </button>
                <br>

                <form action="" id="formulario_componentes">
                @if(session()->all()['perfil'] == config("constantes.perfil_administrador_central") && session()->all()['perfil'] == config("constantes.perfil_coordinador_regional"))
                <?php 
                        $disabled = '';

                    ?>
                @else
                    <?php 
                        $disabled = 'disabled';

                    ?>
                    
                @endif
                    <input type="hidden" name="id_componente" id="id_componente" value="">
                    <input type="hidden" name="id_index" id="id_index" value="">

                    <!-- NOMBRE COMPONENTE -->
                    <div class="form-group">
                        <label for="form_com_ofe_nom" ><b>Nombre de la Prestación o Componente:</b></label>
                        <input {{$disabled}} maxlength="255" onkeypress='return caracteres_especiales(event)' type="text" class="form-control " id="form_com_ofe_nom" placeholder="Nombre">
                         <p id="val_form_com_ofe_nom" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar un nombre para el componente.</p>
                    </div>
                    <!-- NOMBRE COMPONENTE -->

                    <!-- DESCRIPCION COMPONENTE -->
                    <div class="form-group">
                        <label for="form_com_ofe_des" ><b>Descripci&oacute;n de la Prestación o Componente:</b></label>
                        <textarea {{$disabled}} maxlength="2000" onkeypress='return caracteres_especiales(event)' class="form-control " name="form_com_ofe_des" id="form_com_ofe_des" placeholder="Descripción" ></textarea>
                         <p id="val_form_com_ofe_des" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar una descripción para el componente.</p>
                    </div>
                    <!-- DESCRIPCION COMPONENTE -->

                    <!-- TIPO DE BENEFICIO COMPONENTE -->
                    <div class="form-group">
                        <label for="form_com_id_tip_ben" ><b>Tipo de Beneficio:</b></label>
                        <select {{$disabled}} title="Tipo de Beneficio" class="form-control" name="form_com_id_tip_ben" id="form_com_id_tip_ben">
                            <option value="">Seleccione una opción</option>
                            @foreach ($tipoBeneficio AS $c1 => $v1)
                                <option value="{{ $v1->id_tip_ben }}">{{ $v1->nombre }}</option>
                            @endforeach
                        </select>
                         <p id="val_form_com_id_tip_ben" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe escoger un tipo de beneficio para el componente.</p>
                    </div>
                    <!-- TIPO DE BENEFICIO COMPONENTE -->

                    <!--  CUPOS COMUNALES COMPONENTE -->
                    <div class="form-group">
                        <label for="form_com_ofe_cup" ><b>Cupos Comunales:</b></label>
                        <input {{$disabled}} maxlength="25" type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57' maxlength="3" class="form-control " name="form_com_ofe_cup" id="form_com_ofe_cup" placeholder="Ingrese Cupos">
                         <p id="val_form_com_ofe_cup" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar la cantidad de cupos comunales.</p>
                    </div>
                    <!-- CUPOS COMUNALES COMPONENTE -->

                    <!-- CRITERIO PRIORIZACIÓN COMPONENTE -->
                    <div class="form-group">
                        <label for="form_com_ofe_cri_prio"><b>Criterio de Priorización:</b></label>
                        <textarea {{$disabled}} maxlength="1000" onkeypress='return caracteres_especiales(event)' class="form-control " name="form_com_ofe_cri_prio" id="form_com_ofe_cri_prio" placeholder="Criterio de priorización" ></textarea>
                        <p id="val_form_com_ofe_cri_prio" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar un criterio de priorización para el componente.</p>
                    </div>
                    <!-- CRITERIO PRIORIZACIÓN COMPONENTE -->

                    <!-- PERIODO POSTULACIÓN COMPONENTE -->
                    <div class="form-group">
                        <label for="form_com_per_pos"><b>Período de Postulación:</b></label>
                        <textarea {{$disabled}} maxlength="1000" onkeypress='return caracteres_especiales(event)' class="form-control " name="form_com_per_pos" id="form_com_per_pos" placeholder="Período de Postulación" ></textarea>
                        <p id="val_form_com_per_pos" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar el periodo de postulación al componente.</p>
                    </div>    
                    <!-- PERIODO POSTULACIÓN COMPONENTE -->

                    <!-- FORMA DE POSTULACIÓN COMPONENTE -->
                    <div class="form-group">
                        <label for="form_com_for_pos"><b>Forma de postulación:</b></label>
                        <textarea {{$disabled}} maxlength="1000" onkeypress='return caracteres_especiales(event)' class="form-control " name="form_com_for_pos" id="form_com_for_pos" placeholder="Forma de Postulación" ></textarea>
                        <p id="val_form_com_for_pos" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar una forma de postulación al componente.</p>
                    </div>                    
                    <!-- FORMA DE POSTULACIÓN COMPONENTE -->

                    <!-- HORARIO DE ATENCIÓN COMPONENTE -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><b>Horarios de atenci&oacute;n:</b></label>
                                <div class="input-group date" id="form_com_hor_ini" data-target-input="nearest">
                                    <input {{$disabled}} type="text" name="form_com_hor_ini" class="form-control datetimepicker-input " data-target="#form_com_hor_ini" value="" />
                                    <div class="input-group-append" data-target="#form_com_hor_ini" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-clock"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group" style="padding-top: 32px;"> 
                             <div class="input-group date" id="form_com_hor_fin" data-target-input="nearest">
                                <input {{$disabled}} type="text" name="form_com_hor_fin" class="form-control datetimepicker-input " data-target="#form_com_hor_fin" value="" />
                                <div class="input-group-append" data-target="#form_com_hor_fin" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-clock"></i></div>
                                </div>
                             </div>
                            </div>
                        </div>
                    </div>
                    <!-- HORARIO DE ATENCIÓN COMPONENTE -->

                    <!-- RESPONSABLE COMPONENTE -->
                    <div class="form-group">
                        <label for="form_com_usu_resp"><b>Contacto Componente:</b></label>
                        <select {{$disabled}} title="Contacto Componente" class="form-control" name="form_com_usu_resp" id="form_com_usu_resp">
                            <option value="">Seleccione una opción</option>
                            @foreach ($responsable AS $c1 => $v1)
                                <option value="{{ $v1->id }}">{{ $v1->nombres }} {{ $v1->apellido_paterno }} {{ $v1->apellido_materno }}</option>
                            @endforeach
                        </select>
                        <p id="val_form_com_usu_resp" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe seleccionar un responsable para el componente.</p>
                    </div>   
                    <!-- RESPONSABLE COMPONENTE -->

                    <!-- COMUNA COMPONENTE -->
                    <div class="form-group">
                        <label for="form_com_comuna"><b>Comuna:</b></label>
                        <select {{$disabled}} title="Comuna" class="form-control" name="form_com_comuna" id="form_com_comuna" @if(count($comunas) == 1) disabled @endif>
                            <option value="">Seleccione una opción</option>
                            @foreach ($listarComunas AS $c1 => $v1)
                                <option value="{{ $v1->com_id }}" @if(count($comunas) == 1 && $comunas[0]['com_id'] == $v1->com_id) selected @endif>{{ $v1->com_nom }}</option>
                            @endforeach
                        </select>
                        <p id="val_form_com_comuna" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe seleccionar una comuna para el componente.</p>
                    </div>
                    <!-- COMUNA COMPONENTE -->

                    <!-- DIRECCIONES COMPONENTE -->
                    <!-- <div class="card p-3 form-group">
                        <h5><b>Dirección Componente</b></h5>
                        <table class="table table-bordered table-hover table-striped" id="listar_direcccion_componente2" style="width: 100%;">
                            <thead>
                                <th>Lugar de Atención</th>
                                <th>Dirección</th>
                                <th>Referencia</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <br>

                      <div class="form-group">
                        <label for="form_com_estab_nom"><b>Lugar de Atención:</b></label>
                        <input onkeypress='return caracteres_especiales(event)' type="text" class="form-control " name="form_com_estab_nom" id="form_com_estab_nom" placeholder="Lugar de Atención">
                      </div>  
                      <div class="form-group">
                        <label for="form_com_estab_dir"><b>Dirección:</b></label>
                        <input onkeypress='return caracteres_especiales(event)' type="text" class="form-control " name="form_com_estab_dir" id="form_com_estab_dir" placeholder="Dirección">
                      </div> 
                      <div class="form-group">
                        <label for="form_com_estab_ref"><b>Referencia:</b></label>
                        <textarea onkeypress='return caracteres_especiales(event)' class="form-control " name="form_com_estab_ref" id="form_com_estab_ref" placeholder="Referencia" ></textarea>
                      </div> 
                      <button type="button" class="btn btn-outline-success m-4" id="btn_add_dir" onclick="recolectarDataDireccionComponente(); listarDireccion(dataDireccion);limpiarFormularioDireccionesComponente();"><i class="fa fa-plus-circle"></i> Agregar Dirección</button>
                    </div> -->
                    <!-- DIRECCIONES COMPONENTE -->

                    <!-- GUARDAR COMPONENTE O VOLVER-->
                    <div class="text-right">
                        <button {{$disabled}} type="button" class="btn btn-primary btn-md" id="id_btn_mod_com" onclick="guardarDataComponente();">Guardar</button>
                        <button type="button" class="btn btn-default btn-md" data-dismiss="modal" onclick="eliminarDataDirecciones();">Cerrar</button>
                    </div>
                    <!-- GUARDAR COMPONENTE O VOLVER-->

                </form>
            </div>
        </div>
    </div>
</div>