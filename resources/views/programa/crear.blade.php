@extends('layouts.main')
@section('contenido')
    <input id="token_general" hidden value="{{ csrf_token() }}">
    <section>
        <div class="container-fluid">
            <div class="card p-4">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        @if (is_null($dataPrograma[0]->id) || $dataPrograma[0]->id == "")
                             <h4><i class="fa fa-map mr-2"></i>Crear Programa</h4>
                        @elseif (!is_null($dataPrograma[0]->id) && $dataPrograma[0]->id != "")
                            <h4><i class="fa fa-map mr-2"></i>Editar Programa</h4>
                        @endif
                        <br>

                        <input type="hidden" name="id_comunas_programa" id="id_comunas_programa" value="{{ $id_comunas }}">
                        <input type="hidden" name="data_programa" id="data_programa" value="{{ $dataComponentes }}">
                        <input type="hidden" name="data_direccion" id="data_direccion" value="{{ $dataDireccion }}">
                        <input type="hidden" name="id_programa" id="id_programa" value="{{ $dataPrograma[0]->id }}">

                        <!-- NOMBRE PROGRAMA -->
                        <div class="row">
                            <div class="col form-group">
                                <label><b>Nombre:</b></label>
                                <input  maxlength="4000" onkeypress='return caracteres_especiales(event)' type="text" class="form-control " name="pro_nom" id="pro_nom" placeholder="Nombre" value="{{ $dataPrograma[0]->nombre }}" @if($dataPrograma[0]->tipo == 1) disabled @endif>
                                <p id="val_pro_nom" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe escribir un nombre del programa.</p>
                            </div>
                        </div>
                        <!-- NOMBRE PROGRAMA -->

                        <!-- DESCRIPCIÓN PROGRAMA -->
                        <div class="row">
                            <div class="col form-group">
                                <label><b>Descripci&oacute;n:</b></label>
                                <textarea maxlength="4000" onkeypress='return caracteres_especiales(event)' class="form-control " name="pro_des" id="pro_des" placeholder="Descripción" @if($dataPrograma[0]->tipo == 1) disabled @endif>{{ $dataPrograma[0]->descripcion }}</textarea>
                                <p id="val_pro_des" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe escribir una descripción del programa.</p>
                            </div>
                        </div>
                        <!-- DESCRIPCIÓN PROGRAMA -->

                        <!-- PROPOSITO PROGRAMA -->
                        <div class="row">
                            <div class="col form-group">
                                <label><b>Prop&oacute;sito:</b></label>
                                <textarea maxlength="4000" onkeypress='return caracteres_especiales(event)' class="form-control " name="pro_pro" id="pro_pro" placeholder="Propósito" @if($dataPrograma[0]->tipo == 1) disabled @endif>{{ $dataPrograma[0]->proposito }}</textarea>
                                <p id="val_pro_pro" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe escribir un propósito del programa.</p>
                            </div>
                        </div>
                        <!-- PROPOSITO PROGRAMA -->

                        <!-- POBLACION OBJETIVO PROGRAMA -->
                        <div class="row">
                            <div class="col form-group">
                                <label><b>Población Objetivo:</b></label>
                                <input maxlength="1000" onkeypress='return caracteres_especiales(event)' type="text" class="form-control " name="pro_pob_obj" id="pro_pob_obj" placeholder="Población Objetivo" value="{{ $dataPrograma[0]->pob_obj }}" @if($dataPrograma[0]->tipo == 1) disabled @endif>
                                <p id="val_pro_pob_obj" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe escribir la población objetivo del programa.</p>
                            </div>
                        </div>
                        <!-- POBLACION OBJETIVO PROGRAMA -->

                        <!-- DURACIÓN PROGRAMA -->
                        <div class="row">
                            <div class="col form-group">
                                <label><h6><b>Duración (en meses):</b></h6></label>
                                <input maxlength="255" onkeypress='return event.charCode >= 48 && event.charCode <= 57' type="text" class="form-control " name="pro_cant_mes" id="pro_cant_mes" placeholder="Duración en meses" value="{{ $dataPrograma[0]->duracion }}" @if($dataPrograma[0]->tipo == 1) disabled @endif>
                                <p id="val_pro_cant_mes" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe escribir la duración en meses.</p>
                            </div>
                        </div>
                        <!-- DURACIÓN PROGRAMA -->

                        <!-- CUPOS PROGRAMA -->
                        <div class="row">
                            <div class="col form-group">
                                <label><h6><b>Cupos Programa:</b></h6></label>
                                <input maxlength="255" type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57' maxlength="5" class="form-control " name="form_pro_cup" id="form_pro_cup" placeholder="Ingrese Cupos" value="{{ $dataPrograma[0]->pro_cup }}" @if($dataPrograma[0]->tipo == 1) disabled @endif>
                         <p id="val_form_pro_cup" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar la cantidad de cupos del programa.</p>
                            </div>
                        </div>
                        <!-- CUPOS PROGRAMA -->

                        <!-- CUPOS COMUNALES PROGRAMA -->
                        <div class="row">
                            <div class="col form-group">
                                <label><h6><b>Cupos Comunales Programa:</b></h6></label>
                                <input maxlength="100" type="text" onkeypress='return caracteres_especiales(event)' maxlength="5" class="form-control " name="form_pro_cup_comuna" id="form_pro_cup_comuna" placeholder="Ingrese Cupos Comunales" value="{{ $dataPrograma[0]->pro_com_cupos }}">
                            </div>
                        </div>
                        <!-- CUPOS COMUNALES PROGRAMA -->


                        <!-- INSTITUCIÓN RESPONSABLE PROGRAMA -->
                        <div class="row">
                            <div class="col form-group">
                                <label><b>Institución Responsable:</b></label>
                                <input maxlength="255" onkeypress='return caracteres_especiales(event)' type="text" class="form-control " name="pro_inst_resp" id="pro_inst_resp" placeholder="Institución Responsable" value="{{ $dataPrograma[0]->ins_resp }}" @if($dataPrograma[0]->tipo == 1) disabled @endif>
                                <p id="val_pro_inst_resp" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe escribir la institución del responsable.</p>
                            </div>
                        </div>
                        <!-- INSTITUCIÓN RESPONSABLE PROGRAMA -->

                        <!-- SECTOR PROGRAMA -->
                        <div class="row">
                            <div class="col form-group">
                                <label><b>Sector:</b></label>
                               <select title="Sector" class="form-control" name="dim_id" id="dim_id" @if($dataPrograma[0]->tipo == 1) disabled @endif>
                                   <option value="">Seleccione una opción</option>
                                   @foreach ($dimension AS $c1 => $v1)
                                        <option value="{{ $v1->dim_id }}" @if($v1->dim_id == $dataPrograma[0]->sector) selected @endif>{{ $v1->dim_nom }}</option>
                                   @endforeach
                               </select>
                                <p id="val_pro_sec" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe escoger el sector del programa.</p>
                            </div>
                        </div>
                        <!-- SECTOR PROGRAMA -->

                        <!-- FUENTE DE FINANCIAMIENTO PROGRAMA -->
                        <div class="row">
                            <div class="col form-group">
                                <label><b>Fuente de financiamiento:</b></label>
                                <select title="Fuente de financiamiento" class="form-control" name="id_fuen_de_financ" id="id_fuen_de_financ" @if($dataPrograma[0]->tipo == 1) disabled @endif>
                                    <option value="">Seleccione una opción</option>
                                    @foreach ($fuenteFinaciamiento AS $c1 => $v1)
                                        <option value="{{ $v1->id_fuen_de_financ }}" @if ($v1->id_fuen_de_financ == $dataPrograma[0]->fue_fin) selected @endif>{{ $v1->nombre }}</option>
                                    @endforeach
                                </select>
                                <p id="val_pro_fue_fin" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe escoger la Fuente de financiamiento</p>
                            </div>
                        </div>
                        <!-- FUENTE DE FINANCIAMIENTO PROGRAMA -->

                        <!--<div class="row d-none">
                            <div class="col form-group">
                                <label>Tipo Programa</label>
                                <select class="form-control" name="pro_tip" id="pro_tip" >
                                    <option value="0" selected>Local</option>
                                    <option value="0" @ if (@$programa->pro_tip == 0) selected @ endif>Local</option>
                                    <option value="1" @ if (@$programa->pro_tip == 1) selected @ endif>Nacional</option> 
                                </select>
                                <p id="val_tipo_programa" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe seleccionar un tipo de programa programa.</p>
                            </div>
                        </div>-->

                        <!-- PROGRAMA DISPONIBLE EN LA COMUNA -->
                        <div class="form-group">
                            <label for=""><b>Programa disponible en la comuna:</b></label><br>
                            <div class="custom-control custom-radio custom-control-inline">
                            @if(session()->all()['perfil'] != config("constantes.perfil_administrador_central") && session()->all()['perfil'] != config("constantes.perfil_coordinador_regional"))
                                <input type="radio" id="pro_com_est_act" name="pro_com_est" class="custom-control-input" value="1" @if($dataPrograma[0]->est_pro == 1) checked @endif>
                                <label class="custom-control-label" for="pro_com_est_act">Sí</label>
                            @else
                            <input type="radio" id="pro_com_est_act" name="pro_com_est" class="custom-control-input" disabled value="1" @if($dataPrograma[0]->est_pro == 1) checked @endif>
                                <label class="custom-control-label" for="pro_com_est_act">Sí</label>
                            @endif
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                            @if(session()->all()['perfil'] != config("constantes.perfil_administrador_central") && session()->all()['perfil'] != config("constantes.perfil_coordinador_regional"))
                                <input type="radio" id="pro_com_est_no_act" name="pro_com_est" class="custom-control-input" value="0" @if($dataPrograma[0]->est_pro == 0) checked @endif>
                                <label class="custom-control-label" for="pro_com_est_no_act">No</label>
                            @else
                                <input type="radio" id="pro_com_est_no_act" name="pro_com_est" disabled class="custom-control-input" value="0" @if($dataPrograma[0]->est_pro == 0) checked @endif>
                                <label class="custom-control-label" for="pro_com_est_no_act">No</label>
                            @endif
                            </div>
                        </div>     
                        <!-- PROGRAMA DISPONIBLE EN LA COMUNA -->                       

                        <!-- RESPONSABLE DEL PROGRAMA -->
                        <!-- <div class="row">
                            <div class="col form-group">
                                <label><b>Contacto Programa:</b></label>
                                <select title="Contacto Programa" class="form-control" id="pro_usu_resp" name="pro_usu_resp" @if($dataPrograma[0]->tipo == 1) disabled @endif>
                                <option value="">Seleccione una opción</option>
                                    @foreach ($responsable AS $c1 => $v1)
                                        <option value="{{ $v1->id }}" @if($v1->id == $dataPrograma[0]->responsable) selected @endif>{{ $v1->nombres }} {{ $v1->apellido_paterno }} {{ $v1->apellido_materno }}</option>
                                    @endforeach
                                </select>
                                <p id="val_pro_usu_resp" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe escoger un responsable.</p>
                            </div>
                        </div> -->
                        <!-- RESPONSABLE DEL PROGRAMA -->

                        <!-- RESPONSABLE COMUNAL DEL PROGRAMA -->
                        <!-- <div class="row">
                            <div class="col form-group">
                                <label><b>Contacto Comunal Programa:</b></label>
                                <select title="Contacto Programa" class="form-control" id="pro_usu_resp_com" name="pro_usu_resp_com">
                                <option value="">Seleccione una opción</option>
                                    @foreach ($responsable AS $c1 => $v1)
                                        <option value="{{ $v1->id }}" @if($v1->id == $dataPrograma[0]->responsable_comuna) selected @endif>{{ $v1->nombres }} {{ $v1->apellido_paterno }} {{ $v1->apellido_materno }}</option>
                                    @endforeach
                                </select>
                                <p id="val_pro_usu_resp" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe escoger un responsable Comunal.</p>
                            </div>
                        </div> -->
                        <!-- RESPONSABLE COMUNAL DEL PROGRAMA -->

                        <!-- NOMBRE RESPONSABLE COMUNAL -->
                        <div class="row">
                            <div class="col form-group">
                                <label><h6><b>Nombre Responsable Comunal:</b></h6></label>
                                <input maxlength="200" type="text" onkeypress='return caracteres_especiales(event)' maxlength="5" class="form-control " name="form_pro_usu_resp_com_nom" id="form_pro_usu_resp_com_nom" placeholder="Ingrese Nombre del Responsable Comunal" value="{{ $dataPrograma[0]->usu_resp_com_nom }}">
                            </div>
                        </div>
                        <!-- NOMBRE RESPONSABLE COMUNAL -->
                        <br>


                        <!-- TIPOS DE ALERTAS TERRITORIALES -->
                        <div class="row">
                            <div class="col">
                                <h5><b>Tipo de Alertas Territoriales</b></h5>
                            </div>
                        </div>    
                        <div class="row">
                            <div class="col form-group">
                                @foreach ($alertaTipo AS $c1 => $v1)
                                    <div class="form-check">
                                      <input class="form-check-input" type="checkbox" id="pro_tip_ale_{{ $c1 }}"
                                      name="pro_tip_ale" value="{{ $v1->ale_tip_id }}" @if(in_array($v1->ale_tip_id, $dataAlertas)) checked @endif @if($dataPrograma[0]->tipo == 1) disabled @endif>
                                      <label class="form-check-label" for="pro_tip_ale_{{ $c1 }}">
                                        {{ $v1->ale_tip_nom }}
                                      </label>
                                    </div>
                                @endforeach
                                <p id="val_pro_tip_ale" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe seleccionar al menos 1 tipo de alerta territorial.</p>
                            </div>
                        </div>
                        <!-- TIPOS DE ALERTAS TERRITORIALES -->

                        <br>

                        <!-- DIRECCIONES COMPONENTE -->
                        <!-- <div class="card p-3 form-group"> -->
                            <h5><b>Establecimientos</b></h5>
                            <table class="table table-bordered table-hover table-striped" id="listar_direcccion_componente2" style="width: 100%;">
                                <thead>
                                    <th>Lugar de Atención</th>
                                    <th>Dirección</th>
                                    <th>Indicaciones</th>
                                    <th>Responsable</th>
                                    <th>Acciones</th>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <br>
                            @if(session()->all()['perfil'] != config("constantes.perfil_administrador_central") && session()->all()['perfil'] != config("constantes.perfil_coordinador_regional"))
                          <div class="form-group">
                            <label for="form_com_estab_nom"><b>Lugar de Atención:</b></label>
                            <input maxlength="1000" onkeypress='return caracteres_especiales(event)' type="text" class="form-control " name="form_com_estab_nom" id="form_com_estab_nom" placeholder="Lugar de Atención">
                          </div>  
                          <div class="form-group">
                            <label for="form_com_estab_dir"><b>Dirección:</b></label>
                            <input maxlength="1000" onkeypress='return caracteres_especiales(event)' type="text" class="form-control " name="form_com_estab_dir" id="form_com_estab_dir" placeholder="Dirección">
                          </div> 
                          <div class="form-group">
                            <label for="form_com_estab_ref"><b>Indicaciones de apoyo a la dirección:</b></label>
                            <textarea maxlength="1000" onkeypress='return caracteres_especiales(event)' class="form-control " name="form_com_estab_ref" id="form_com_estab_ref" placeholder="Indicaciones de apoyo a la dirección" ></textarea>
                          </div> 

                        <!-- RESPONSABLE DEL PROGRAMA -->
                        <div class="form-group">
                                <label><b>Responsable:</b></label>
                                <select title="Responsable" class="form-control" id="usu_resp_establecimiento" name="usu_resp_establecimiento">
                                <option value="">Seleccione una opción</option>
                                    @foreach ($responsable AS $c1 => $v1)
                                        <option value="{{ $v1->id }}">{{ $v1->nombres }} {{ $v1->apellido_paterno }} {{ $v1->apellido_materno }}</option>
                                    @endforeach
                                </select>
                                <p id="val_usu_resp_establecimiento" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe escoger un responsable.</p>
                            </div>
                        <!-- RESPONSABLE DEL PROGRAMA -->



                          <!-- <button type="button" class="btn btn-outline-success m-4" id="btn_add_dir" onclick="recolectarDataDireccionComponente(); listarDireccion(dataDireccion);limpiarFormularioDireccionesComponente();"><i class="fa fa-plus-circle"></i> Agregar Dirección</button> -->
                          <div>
                          <button type="button" class="btn btn-outline-success" id="btn_add_dir" onclick="recolectarDataDireccion(); listarDireccion2(dataDireccion);limpiarFormularioDirecciones();"><i class="fa fa-plus-circle"></i> Agregar Establecimiento</button>
                              
                          </div>
                        @endif
                        <!-- </div> -->
                        <!-- DIRECCIONES COMPONENTE -->

                        <br>
                        <h5><b>Componentes</b></h5>
                        <div class="row">
                            <div class="col">
                                <table class="table table-bordered table-hover table-striped" id="tabla_listar_componentes" style="width: 100%;">
                                    <thead>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Acciones</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div>
<!--                             <button type="button" class="btn btn-outline-success m-4" data-toggle="modal" data-target="#formComponentes" 
                            onclick="listarDireccion(new Array()); limpiarFormularioComponente();"><i class="fa fa-plus-circle"></i> Agregar Componente</button>
                            
 -->                        
                         @if(session()->all()['perfil'] != config("constantes.perfil_administrador_central") && session()->all()['perfil'] != config("constantes.perfil_coordinador_regional"))
                            <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#formComponentes" 
                            onclick="limpiarFormularioComponente();"><i class="fa fa-plus-circle"></i> Agregar Componente</button>
                        </div>

                        <br>

                        <div>
                            @if (is_null($dataPrograma[0]->id) || $dataPrograma[0]->id == "")
                                <button type="button" class="btn btn-success" onclick="guardarFormularioProgramas(1);">Guardar Programa</button>
                           
                            @elseif (!is_null($dataPrograma[0]->id) && $dataPrograma[0]->id != "")
                                <button type="button" class="btn btn-success" onclick="guardarFormularioProgramas(2);">Modificar Programa</button>
                            
                            @endif
                        @endif
                            <button type="button" class="btn btn-info" 
                            onclick="window.location='/programa/main'">Volver</button>
                        </div>
                    </div>
                </div>
            </div>   
        </div>
    </section>

@includeif('programa.crear_oferta')

@endsection

@section('script')
<script type="text/javascript">
    var dataComponentes = new Array();
    var dataDireccion   = new Array();
    var cantComunas     = {{ count($comunas) }};

    $(document).ready( function () {

        /*$('#listar_direcccion_componente2').DataTable({
            retrieve: true,
            ordering: false,
            paging: false,
            searching: false,
            info: false,
            language  : { "url": "{{ route('index') }}/js/dataTables.spanish.json"}
        });*/

        $(function(){
            $('#form_com_hor_ini').datetimepicker({
                format: 'LT'
            });
        });

        $(function(){
            $('#form_com_hor_fin').datetimepicker({
                format: 'LT'
            });
        });

        dataComponentes = $.parseJSON($("#data_programa").val());
        
        if ($("#data_direccion").val()!="na"){
            dataDireccion = $.parseJSON($("#data_direccion").val());
            listarDireccion2(dataDireccion); 
        }else{            
            $('#listar_direcccion_componente2').DataTable({
            retrieve: true,
            ordering: false,
            paging: false,
            searching: false,
            info: false,
            language  : { "url": "{{ route('index') }}/js/dataTables.spanish.json"}
            });
        }

        listarComponentes();
        
    });

    function guardarFormularioProgramas(option){
        let data = new Object();
        let url  = '{{ route("programa.insertar") }}'; 

        if (option == 2){ 
            url  = '{{ route("programa.actualizar") }}'; 
        }
        

        let val_pro = validarFormularioProgramas();
        if (val_pro == false) return false;

        data = guardarDataFormularioProgramas();

        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('#token_general').val()}
          });
        $.ajax({
            'type'      : "POST",
            'dataType'  : "JSON",
            'url'       : url,
            'data'      : data
        }).done(function(resp) {
            if(resp.estado == 1){
                let mensaje ="Información de programa guardada con éxito.";
                if (option == 2) mensaje ="Información de programa actualizada con éxito.";
                
                alert(mensaje);
                window.location = '/programa/main';
            }else if(resp.estado == 0){
                let mensaje ="Hubo un error al momento de guardar la información del programa. Por favor intente nuevamente.";
                if (option == 2) mensaje ="Hubo un error al momento de actualizar la información del programa. Por favor intente nuevamente.";

                alert(mensaje);
            }
                
        }).fail(function(resp){
            console.log(resp);

            let mensaje ="Hubo un error al momento de guardar la información del programa. Por favor intente nuevamente.";

            if (option == 2) mensaje ="Hubo un error al momento de actualizar la información del programa. Por favor intente nuevamente.";
            alert(mensaje);
        });
    }

    function validarFormularioProgramas(){
        let respuesta       = true;
        let nombre          = $("#pro_nom").val();
        let descripcion     = $("#pro_des").val();
        let proposito       = $("#pro_pro").val();
        let pob_obj         = $("#pro_pob_obj").val();
        let duracion        = $("#pro_cant_mes").val();
        let ins_resp        = $("#pro_inst_resp").val();
        let sector          = document.getElementById("dim_id").value;
        let fue_fin         = document.getElementById("id_fuen_de_financ").value;
        let responsable     = "";
        // let responsable     = document.getElementById("pro_usu_resp").value;

        limpiarValidacionesFormularioProgramas();

        if (nombre == "" || typeof nombre === "undefined"){
            respuesta = false;
            $("#val_pro_nom").show();
            $("#pro_nom").addClass("is-invalid");
        }

        if (descripcion == "" || typeof descripcion === "undefined"){
            respuesta = false;
            $("#val_pro_des").show();
            $("#pro_des").addClass("is-invalid");
        }

         if (sector == "" || typeof sector === "undefined"){
            respuesta = false;
            $("#val_pro_sec").show();
            $("#dim_id").addClass("is-invalid");
        }


        /*if (proposito == "" || typeof proposito === "undefined"){
            respuesta = false;
            $("#val_pro_pro").show();
            $("#pro_pro").addClass("is-invalid");
        }

        if (pob_obj == "" || typeof pob_obj === "undefined"){
            respuesta = false;
            $("#val_pro_pob_obj").show();
            $("#pro_pob_obj").addClass("is-invalid");
        }

        if (duracion == "" || typeof duracion === "undefined"){
            respuesta = false;
            $("#val_pro_cant_mes").show();
            $("#pro_cant_mes").addClass("is-invalid");
        }

        if (ins_resp == "" || typeof ins_resp === "undefined"){
            respuesta = false;
            $("#val_pro_inst_resp").show();
            $("#pro_inst_resp").addClass("is-invalid");
        }

        if (fue_fin == "" || typeof fue_fin === "undefined"){
            respuesta = false;
            $("#val_pro_fue_fin").show();
            $("#id_fuen_de_financ").addClass("is-invalid");
        }

        if (responsable == "" || typeof responsable === "undefined"){
            respuesta = false;
            $("#val_pro_usu_resp").show();
            $("#pro_usu_resp").addClass("is-invalid");
        }

        let val_tip_ale = false;
        $("input[name=pro_tip_ale]:checked").each(function(){
            if (this.value != "" && typeof this.value != "undefined") val_tip_ale = true;
        });

        if (val_tip_ale == false){
            respuesta = false;
            $("#val_pro_tip_ale").show();
        }*/

        return respuesta;
    }

    function limpiarValidacionesFormularioProgramas(){
            $("#val_pro_nom").hide();
            $("#pro_nom").removeClass("is-invalid");
    
            $("#val_pro_des").hide();
            $("#pro_des").removeClass("is-invalid");

            $("#val_pro_sec").hide();
            $("#dim_id").removeClass("is-invalid");

            $("#val_pro_pro").hide();
            $("#pro_pro").removeClass("is-invalid");

            $("#val_pro_pob_obj").hide();
            $("#pro_pob_obj").removeClass("is-invalid");

            $("#val_pro_cant_mes").hide();
            $("#pro_cant_mes").removeClass("is-invalid");
        
            $("#val_pro_inst_resp").hide();
            $("#pro_inst_resp").removeClass("is-invalid");

            $("#val_pro_sec").hide();
            $("#dim_id").removeClass("is-invalid");
        
            $("#val_pro_fue_fin").hide();
            $("#id_fuen_de_financ").removeClass("is-invalid");

            // $("#val_pro_usu_resp").hide();
            // $("#pro_usu_resp").removeClass("is-invalid");

            $("#val_pro_tip_ale").hide();
    }

    function guardarDataFormularioProgramas(){
        let data    = new Object();
        let id_prog = $("#id_programa").val();

        data.id = "";
        if (id_prog != "" && typeof id_prog != "undefined") data.id = id_prog;
        
        data.nombre          = $("#pro_nom").val();
        data.descripcion     = $("#pro_des").val();
        data.proposito       = $("#pro_pro").val();
        data.pob_obj         = $("#pro_pob_obj").val();
        data.duracion        = $("#pro_cant_mes").val();
        data.ins_resp        = $("#pro_inst_resp").val();
        data.sector          = document.getElementById("dim_id").value;
        data.fue_fin         = document.getElementById("id_fuen_de_financ").value;
        data.responsable     = "";
        // data.responsable     = document.getElementById("pro_usu_resp").value;
        data.pro_tip_ale     = new Array();
        data.est_pro         = $('input:radio[name=pro_com_est]:checked').val();
        data.pro_com         = $("#id_comunas_programa").val();
        data.pro_cup         = $("#form_pro_cup").val();
        data.pro_com_cupos   = $("#form_pro_cup_comuna").val();
        data.responsable_comuna = "";
        data.usu_resp_com_nom = $("#form_pro_usu_resp_com_nom").val();

        $("input[name=pro_tip_ale]:checked").each(function(){
            data.pro_tip_ale.push(this.value);
        });

        data.componente      = dataComponentes;
        data.establecimientos = dataDireccion;

        return data;
    }

    function validarFormularioComponentes(){
        let respuesta       = true;
        let nombre          = $("#form_com_ofe_nom").val();
        let descripcion     = $("#form_com_ofe_des").val();
        let beneficio       = document.getElementById("form_com_id_tip_ben").value;
        let cupos           = $("#form_com_ofe_cup").val();
        let priorizacion    = $("#form_com_ofe_cri_prio").val();
        let periodo         = $("#form_com_per_pos").val();
        let forma           = $("#form_com_for_pos").val();
        let responsable     = document.getElementById("form_com_usu_resp").value;
        let comuna          = document.getElementById("form_com_comuna").value;

        if (nombre == "" || typeof nombre === "undefined"){
            respuesta = false;
            $("#val_form_com_ofe_nom").show();
            $("#form_com_ofe_nom").addClass("is-invalid");
        }

        if (descripcion == "" || typeof descripcion === "undefined"){
            respuesta = false;
            $("#val_form_com_ofe_des").show();
            $("#form_com_ofe_des").addClass("is-invalid");
        }

        /*if (beneficio == "" || typeof beneficio === "undefined"){
            respuesta = false;
            $("#val_form_com_id_tip_ben").show();
            $("#form_com_id_tip_ben").addClass("is-invalid");
        }

        if (cupos == "" || typeof cupos === "undefined"){
            respuesta = false;
            $("#val_form_com_ofe_cup").show();
            $("#form_com_ofe_cup").addClass("is-invalid");
        }

        if (priorizacion == "" || typeof priorizacion === "undefined"){
            respuesta = false;
            $("#val_form_com_ofe_cri_prio").show();
            $("#form_com_ofe_cri_prio").addClass("is-invalid");
        }

        if (periodo == "" || typeof periodo === "undefined"){
            respuesta = false;
            $("#val_form_com_per_pos").show();
            $("#form_com_per_pos").addClass("is-invalid");
        }

        if (forma == "" || typeof forma === "undefined"){
            respuesta = false;
            $("#val_form_com_for_pos").show();
            $("#form_com_for_pos").addClass("is-invalid");
        }

        if (responsable == "" || typeof responsable === "undefined"){
            respuesta = false;
            $("#val_form_com_usu_resp").show();
            $("#form_com_usu_resp").addClass("is-invalid");
        }*/

        if (comuna == "" || typeof comuna === "undefined"){
            respuesta = false;
            $("#val_form_com_comuna").show();
            $("#form_com_comuna").addClass("is-invalid");
        }

        return respuesta;
    }

    function recolectarDataFormularioComponentes(index = null){
        let id_componente = $("#id_componente").val();
        let indice        = dataComponentes.length;

        if ($.isNumeric(index)){
            indice = index;

            if (id_componente != "" && typeof id_componente != "undefined"){
                dataComponentes[indice].id    = id_componente;

                /*if (dataDireccion.length > 0){
                    if (typeof dataComponentes[indice].direcciones == "string" || dataComponentes[indice].direcciones == ""){
                         dataComponentes[indice].direcciones = new Array();
                    }

                    dataDireccion.forEach(function(value, index){
                        dataComponentes[indice].direcciones.push(value);
                    });
                }*/
            }else{
                dataComponentes[indice]       = new Object();
                dataComponentes[indice].id    = "";
                dataComponentes[indice].direcciones = "";
                /*if (dataDireccion.length > 0){
                    dataComponentes[indice].direcciones = new Array();

                    dataDireccion.forEach(function(value, index){
                        dataComponentes[indice].direcciones.push(value);
                    });
                }*/
            }
        }else{
            dataComponentes[indice]              = new Object();
            dataComponentes[indice].id           = "";
            dataComponentes[indice].direcciones  = "";
            //if (dataDireccion.length > 0) dataComponentes[indice].direcciones = dataDireccion;
        
        }

        /*if (id_componente != "" && typeof id_componente != "undefined"){
            let $val_componente = false;
            dataComponentes.forEach(function(value, index) {
                if (value.id == id_componente) $val_componente = index;
            });

            if ($val_componente != false){
                indice = $val_componente;
           
            }else{
                dataComponentes[indice]       = new Object();
                dataComponentes[indice].direcciones = new Array();
            }

            dataComponentes[indice].id    = id_componente;

            dataDireccion.forEach(function(value, index){
                dataComponentes[indice].direcciones.push(value);
            });
        }else{
            dataComponentes[indice]              = new Object();
            dataComponentes[indice].id           = "";
            dataComponentes[indice].direcciones  = "";
            if (dataDireccion.length > 0) dataComponentes[indice].direcciones = dataDireccion;
        }*/

        dataComponentes[indice].nombre       = $("#form_com_ofe_nom").val();
        dataComponentes[indice].descripcion  = $("#form_com_ofe_des").val();
        dataComponentes[indice].beneficio    = document.getElementById("form_com_id_tip_ben").value;
        dataComponentes[indice].cupos        = $("#form_com_ofe_cup").val();
        dataComponentes[indice].priorizacion = $("#form_com_ofe_cri_prio").val();
        dataComponentes[indice].periodo      = $("#form_com_per_pos").val();
        dataComponentes[indice].forma        = $("#form_com_for_pos").val();

        let hor_ini = $("#form_com_hor_ini").data('date'); 
        let hor_fin = $("#form_com_hor_fin").data('date'); 
        dataComponentes[indice].horario      = hor_ini+" - "+hor_fin;

        dataComponentes[indice].responsable  = document.getElementById("form_com_usu_resp").value;
        dataComponentes[indice].comuna       = document.getElementById("form_com_comuna").value;

        return dataComponentes;
    }

    function listarComponentes(){
        let listarDataComponentes = $('#tabla_listar_componentes').DataTable();
        listarDataComponentes.clear().destroy();

        let html = "";
        dataComponentes.forEach(function(value, index){
            //console.log(value, index);
            html += '<tr>';
            
            $descripcion = (value.descripcion!=null)?value.descripcion:'';
            $nombre = (value.nombre!=null)?value.nombre:'';

            html += '<td>'+$nombre+'</td>';
            html += '<td>'+$descripcion+'</td>';
            @if(session()->all()['perfil'] != config("constantes.perfil_administrador_central") && session()->all()['perfil'] != config("constantes.perfil_coordinador_regional"))
            html += '<td><button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#formComponentes" onclick="cargarInformacionFormularioComponente('+index+');">Editar <span class="oi oi-pencil"></span></button></td>';
            @else
            html += '<td><button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#formComponentes" onclick="cargarInformacionFormularioComponente('+index+');">Visualizar<span class="oi oi-pencil"></span></button></td>';
            @endif
            html += '</tr>';
        });

        $("#tabla_listar_componentes > tbody").html(html);

        $('#tabla_listar_componentes').DataTable({
            ordering:   false,
            paging:     false,
            searching:  true,
            info:       true,
            columnDefs: [
                {"className": "dt-center", "targets": [0]},
                {"className": "dt-center", "targets": [1]},
                {"className": "dt-left", "targets": [2]}],
            language: { "url": "{{ route('index') }}/js/dataTables.spanish.json"}
        });
    }

    function guardarDataComponente(index = null){
        let val_comp = validarFormularioComponentes();
        if (val_comp == false) return false;

        recolectarDataFormularioComponentes(index);

        listarComponentes();

        limpiarFormularioComponente();

        $("#formComponentes").modal('hide');
    }

    function cargarInformacionFormularioComponente(index){
        limpiarFormularioComponente();

        $("h5#formComponentesLabel").text("Modificar Componente");
        $("#id_btn_mod_com").text("Modificar");
        $("#id_btn_mod_com").removeAttr("onclick");
        $("#id_btn_mod_com").attr("onclick", "guardarDataComponente("+index+");");
        $("#id_index").val(index);

        if (dataComponentes[index].id != "" && typeof dataComponentes[index].id != "undefined"){
            $("#id_componente").val(dataComponentes[index].id);
        }    

        $("#form_com_ofe_nom").val(dataComponentes[index].nombre);
        $("#form_com_ofe_des").val(dataComponentes[index].descripcion);

        if (dataComponentes[index].beneficio != "" && dataComponentes[index].beneficio != null && typeof dataComponentes[index].beneficio != "undefined"){
            $("#form_com_id_tip_ben").val(dataComponentes[index].beneficio);
            //$("#form_com_id_tip_ben option[value="+dataComponentes[index].beneficio+"]").attr("selected",true);
        }
        
        $("#form_com_ofe_cup").val(dataComponentes[index].cupos);
        $("#form_com_ofe_cri_prio").val(dataComponentes[index].priorizacion);
        $("#form_com_per_pos").val(dataComponentes[index].periodo);
        $("#form_com_for_pos").val(dataComponentes[index].forma);

        if (dataComponentes[index].horario != "" && dataComponentes[index].horario != null && typeof dataComponentes[index].horario != "undefined"){
            let horario = dataComponentes[index].horario.split(" - ");
            $('#form_com_hor_ini').datetimepicker('date', horario[0]);
            $('#form_com_hor_fin').datetimepicker('date', horario[1]);
        }

        if (dataComponentes[index].responsable != "" && dataComponentes[index].responsable != null && typeof dataComponentes[index].responsable != "undefined"){
            $("#form_com_usu_resp").val(dataComponentes[index].responsable);
            //$("#form_com_usu_resp option[value="+dataComponentes[index].responsable+"]").attr("selected",true);
        }

        if (dataComponentes[index].comuna != "" && dataComponentes[index].comuna != null && typeof dataComponentes[index].comuna != "undefined"){
            $("#form_com_comuna option[value="+dataComponentes[index].comuna+"]").attr("selected",true);
        }

        //listarDireccion(dataComponentes[index].direcciones, true);
    }

    function limpiarFormularioComponente(){
        limpiarValidacionesFormularioComponentes();

        $("h5#formComponentesLabel").text("Agregar Componente");
        $("#id_btn_mod_com").text("Guardar");
        $("#id_btn_mod_com").removeAttr("onclick");
        $("#id_btn_mod_com").attr("onclick", "guardarDataComponente()");

        $("#id_index").val("");
        $("#id_componente").val("");
        $("#form_com_ofe_nom").val("");
        $("#form_com_ofe_des").val("");
        //$("#form_com_id_tip_ben option[value='']").attr("selected",true);
        $("#form_com_id_tip_ben").val("");
        $("#form_com_ofe_cup").val("");
        $("#form_com_ofe_cri_prio").val("");
        $("#form_com_per_pos").val("");
        $("#form_com_for_pos").val("");

        $('#form_com_hor_ini').datetimepicker('date', "00:00 AM");
        $('#form_com_hor_fin').datetimepicker('date', "00:00 PM");

        //$("#form_com_usu_resp option[value='']").attr("selected",true);
        $("#form_com_usu_resp").val("");

        if (cantComunas > 1) $("#form_com_comuna option[value='']").attr("selected",true);

        limpiarFormularioDireccionesComponente();
        eliminarDataDirecciones();
    }

    function limpiarValidacionesFormularioComponentes(){
            $("#val_form_com_ofe_nom").hide();
            $("#form_com_ofe_nom").removeClass("is-invalid");
        
            $("#val_form_com_ofe_des").hide();
            $("#form_com_ofe_des").removeClass("is-invalid");

            $("#val_form_com_id_tip_ben").hide();
            $("#form_com_id_tip_ben").removeClass("is-invalid");
        

            $("#val_form_com_ofe_cup").hide();
            $("#form_com_ofe_cup").removeClass("is-invalid");
        

            $("#val_form_com_ofe_cri_prio").hide();
            $("#form_com_ofe_cri_prio").removeClass("is-invalid");
        

            $("#val_form_com_per_pos").hide();
            $("#form_com_per_pos").removeClass("is-invalid");
        

            $("#val_form_com_for_pos").hide();
            $("#form_com_for_pos").removeClass("is-invalid");
        

            $("#val_form_com_usu_resp").hide();
            $("#form_com_usu_resp").removeClass("is-invalid");
        

            $("#val_form_com_comuna").hide();
            $("#form_com_comuna").removeClass("is-invalid");
    }

    function recolectarDataDireccionComponente(){
        let indice               = dataDireccion.length;
        dataDireccion[indice]    = new Object();

        dataDireccion[indice].id            = "";
        dataDireccion[indice].nombre        = $("#form_com_estab_nom").val();
        dataDireccion[indice].direccion     = $("#form_com_estab_dir").val();
        dataDireccion[indice].referencia    = $("#form_com_estab_ref").val();
        return dataDireccion;
    }

    function recolectarDataDireccion(){
        if ($("#form_com_estab_nom").val()!="" && $("#form_com_estab_dir").val()!="" && $("#form_com_estab_ref").val()!="" && $('select[name="usu_resp_establecimiento"] option:selected').text()!="Seleccione una opción"){
            let indice               = dataDireccion.length;
            //alert(indice);
            dataDireccion[indice]    = new Object();

            dataDireccion[indice].id            = "";
            dataDireccion[indice].nombre        = $("#form_com_estab_nom").val();
            dataDireccion[indice].direccion     = $("#form_com_estab_dir").val();
            dataDireccion[indice].referencia    = $("#form_com_estab_ref").val();
            dataDireccion[indice].id_usu_responsable    = $("#usu_resp_establecimiento").val();
            dataDireccion[indice].nombre_usu_responsable = $('select[name="usu_resp_establecimiento"] option:selected').text();

            return dataDireccion;
        }else{
            alert('Debe completar todos los datos del establecimiento');
        }
    }

    function listarDireccion(data, inicial = null){
        $('#listar_direcccion_componente2').DataTable();
        $('#listar_direcccion_componente2').DataTable().clear().destroy();

        let html = "";
        let index = $("#id_index").val();

        if (inicial != true){
            if (index != "" && typeof index != "undefined"){
                if (typeof dataComponentes[index].direcciones != "string" && dataComponentes[index].direcciones != ""){
                    dataComponentes[index].direcciones.forEach(function(value, index){
                        html += '<tr>';
                        html += '<td>'+value.nombre+'</td>';
                        html += '<td>'+value.direccion+'</td>';
                        html += '<td>'+value.referencia+'</td>';
                        html += '</tr>';
                    });
                }
            }
        }

        if (data != "" && typeof data != "undefined"){
            data.forEach(function(value, index){
                html += '<tr>';
                html += '<td>'+value.nombre+'</td>';
                html += '<td>'+value.direccion+'</td>';
                html += '<td>'+value.referencia+'</td>';
                html += '</tr>';
            });
        }

        $("#listar_direcccion_componente2 > tbody").append(html);

        $('#listar_direcccion_componente2').DataTable({
                retrieve: true,
                ordering: false,
                paging: false,
                searching: false,
                info: false,
                language  : { "url": "{{ route('index') }}/js/dataTables.spanish.json"}
            });

        /*$('#listar_direcccion_componente').DataTable({
            retrieve:   true,
            ordering:   false,
            paging:     false,
            searching:  false,
            info:       false,
            columnDefs: [
                {"className": "dt-left", "targets": [0]},
                {"className": "dt-left", "targets": [1]},
                {"className": "dt-left", "targets": [2]}],
            language: { "url": "{{ route('index') }}/js/dataTables.spanish.json"}
        });*/
    }
    function listarDireccion2(data, inicial = null){
        $('#listar_direcccion_componente2').DataTable();
        $('#listar_direcccion_componente2').DataTable().clear().destroy();

        let html = "";
        let index = $("#id_index").val();

        if (inicial != true){
            if (index != "" && typeof index != "undefined"){
                if (typeof dataDireccion != "string" && dataDireccion != ""){
                //if (typeof dataComponentes[index].direcciones != "string" && dataComponentes[index].direcciones != ""){
                    dataDireccion.forEach(function(value, index){
                   // dataComponentes[index].direcciones.forEach(function(value, index){
                        html += '<tr>';
                        html += '<td>'+value.nombre+'</td>';
                        html += '<td>'+value.direccion+'</td>';
                        html += '<td>'+value.referencia+'</td>';
                        html += '<td>'+value.nombre_usu_responsable+'</td>';
                        @if(session()->all()['perfil'] == config("constantes.perfil_administrador_central") && session()->all()['perfil'] == config("constantes.perfil_coordinador_regional"))
                        html += '<td><button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal"  onclick="eliminarDireccion('+index+');">Eliminar <span class="oi oi-pencil"></span></button></td>';
                        @else
                        html += '<td><button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal"  disabled onclick="eliminarDireccion('+index+');">Eliminar <span class="oi oi-pencil"></span></button></td>';
                        @endif

                        html += '</tr>';
                    });
                }
            }
        }

        if (data != "" && typeof data != "undefined"){
            html="";
            data.forEach(function(value, index){
                html += '<tr>';
                html += '<td>'+value.nombre+'</td>';
                html += '<td>'+value.direccion+'</td>';
                html += '<td>'+value.referencia+'</td>';
                html += '<td>'+value.nombre_usu_responsable+'</td>';
                @if(session()->all()["perfil"] == config('constantes.perfil_coordinador_regional') )
                html += '<td><button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" disabled>Eliminar <span class="oi oi-pencil"></span></button></td>';
                @else
                html += '<td><button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal"  onclick="eliminarDireccion('+index+');">Eliminar <span class="oi oi-pencil"></span></button></td>';
                @endif
                html += '</tr>';
            });
        }

        $("#listar_direcccion_componente2 > tbody").append(html);

        $('#listar_direcccion_componente2').DataTable({
                retrieve: true,
                ordering: false,
                paging: false,
                searching: false,
                info: false,
                language  : { "url": "{{ route('index') }}/js/dataTables.spanish.json"}
            });

        /*$('#listar_direcccion_componente').DataTable({
            retrieve:   true,
            ordering:   false,
            paging:     false,
            searching:  false,
            info:       false,
            columnDefs: [
                {"className": "dt-left", "targets": [0]},
                {"className": "dt-left", "targets": [1]},
                {"className": "dt-left", "targets": [2]}],
            language: { "url": "{{ route('index') }}/js/dataTables.spanish.json"}
        });*/
    }

    function limpiarFormularioDireccionesComponente(){
        $("#form_com_estab_nom").val("");
        $("#form_com_estab_dir").val("");
        $("#form_com_estab_ref").val("");
    }

    function limpiarFormularioDirecciones(){
        $("#form_com_estab_nom").val("");
        $("#form_com_estab_dir").val("");
        $("#form_com_estab_ref").val("");
        $("#usu_resp_establecimiento").val("");
    }

    function eliminarDataDirecciones(){
        //$("#listar_direcccion_componente > tbody").remove("");
        //dataDireccion = new Array();
    }

    function eliminarDireccion(index){

        let indice = index;

        let id_establecimiento = dataDireccion[index]['id'];

        if (confirm("Está seguro de eliminar el establecimiento?")) {
        
            if (id_establecimiento == ''){
                dataDireccion.splice(indice, 1);
                listarDireccion2(dataDireccion);
            }else{

                let data = new Object();
                data.id = id_establecimiento;

                $.ajax({
                    'type'      : "GET",
                    'dataType'  : "JSON",
                    'url'       : '{{ route("programa.eliminar_establecimiento") }}',
                    'data'      : data
                }).done(function(resp) {
                    if(resp.estado == 1){
                        dataDireccion.splice(indice, 1);
                        listarDireccion2(dataDireccion);

                        alert(resp.mensaje);
                    }else if(resp.estado == 0){
                        alert(resp.mensaje);
                    }
                }).fail(function(obj){
                    let mensaje = "Hubo un error al momento de eliminar el establecimiento solicitado. Por favor intente nuevamente.";
                    alert(mensaje);

                    console.log(obj);
                });

                listarDireccion2(dataDireccion);
            }        

        }
    }
</script>
@endsection