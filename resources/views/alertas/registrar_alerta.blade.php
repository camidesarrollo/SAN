@extends('layouts.main')
@section('contenido')
<input id="token_general" hidden value="{{ csrf_token() }}">
<section class=" p-1 cabecera">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12">
                <h5>Registrar Alerta </h5>
            </div>
        </div>
    </div>
</section>

<!-- MENSAJES DE ALERTAS -->
<!--@ if(Session::has('success'))-->
<div class="container-fluid">
    <div class="alert alert-success alert-dismissible fade show" id="msg_alerta_exitosa" role="alert">
        <!--<strong>{ { Session::get('success') }}</strong>-->
        Registro Guardado Exitosamente.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>

<!--@ endif @ if(Session::has('danger'))-->
<div class="container-fluid">
    <div class="alert alert-danger alert-dismissible fade show" id="msg_alerta_erronea" role="alert">
        <!--<strong>{{ Session::get('danger') }}</strong>-->
        Error al momento de guardar el registro. Por favor intente nuevamente.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
<!--@ endif-->
<!-- FIN MENSAJES DE ALERTAS -->

@includeif('alertas.frm_contactos')

<section>
    <div class="container-fluid">
        <div class="card p-4 shadow-sm">
            <div class="row">
                <div class="col-md-12">

                    <form name="ingr_alert" id="ingr_alert" method="post">
                        {{ csrf_field() }}

                        <input type="hidden" id="com_id" nombre="com_id" value="{{Session::get('com_id')}}">
                        <input type="hidden" id="url_pro" value="{{ route('alertas.problematica') }}">
                        <input type="hidden" id="url_rut" value="{{ route('alertas.rut') }}">
                        <input type="hidden" id="url_ingresar_alerta" nombre="url_ingresar_alerta"
                            value="{{ route('alertas.registrar')}}">
                        @if (config('constantes.activar_maestro_direcciones'))
                        <input type="hidden" id="nna_sin_run" value="">
                        <input type="hidden" id="id_dir" value="">
                        <input type="hidden" id="reg_id" value="">
                        <input type="hidden" id="com_id_nna" value="">
                        <input type="hidden" id="nna_calle" value="">
                        <input type="hidden" id="nna_dir" value="">
                        <input type="hidden" id="nna_depto" value="">
                        <input type="hidden" id="nna_block" value="">
                        <input type="hidden" id="nna_casa" value="">
                        <input type="hidden" id="nna_km_sitio" value="">
                        <input type="hidden" id="nna_ref" value="">
                        @endif

                        <!--  INICIO IDENTIFICACIÓN SECTORIALISTA -->

                        <hr style="background-color:black;">
                        <h5><b>I. IDENTIFICACIÓN USUARIO:</b></h5>
                        <br>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Sector
                                    Institución:</b></label>
                            <div class="col-sm-9">

                                <select id="dim_id" name="dim_id" class="form-control"
                                    onchange="activaSector(this.value);">
                                    <option value=""> Seleccione Sector Institución</option>
                                    @foreach($dimension as $d)
                                    <option value="{{$d->dim_id}}">{{$d->dim_nom}}</option>
                                    @endforeach
                                </select>
                                <p id="val_dim_id"
                                    style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">
                                    * Debe elegir Sector Institución.</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Nombre
                                    Institución:</b></label>
                            <div class="col-sm-9">
                                <input readonly required type="input" class="form-control"
                                    placeholder="Ej. Cesfam Juan Pablo Segundo" value="{{$usuSec[0]->nom_ins}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label"
                                style="color:#858796;"><b>Dirección:</b></label>
                            <div class="col-sm-9">
                                <input maxlength="100" id="dir_usu_nna" name="dir_usu_nna"
                                    onkeypress="return caracteres_especiales(event)" type="input" class="form-control"
                                    placeholder="Ej. Catedral ...">
                                <p id="val_dir_usu"
                                    style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">
                                    * Debe Ingresar una Dirección.</p>
                            </div>

                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Nombre
                                    Sectorialista:</b></label>
                            <div class="col-sm-9">
                                <input readonly required type="input" class="form-control" id=""
                                    placeholder="Ej. Sonia Jiménez" value="{{$usuSec[0]->usuario_nombre}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label"
                                style="color:#858796;"><b>Teléfono:</b></label>
                            <div class="col-sm-9">
                                <input readonly required type="input" class="form-control" id=""
                                    placeholder="Ej. 223334455" value="{{$usuSec[0]->telefono}}">
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Run:</b></label>
                            <div class="col-sm-9">
                                <input readonly required type="input" class="form-control" id=""
                                    placeholder="Ej. 6.778.987-k" value="{{$rut_completo_usu}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Cargo:</b></label>
                            <div class="col-sm-9">
                                <input maxlength="100" id="car_usu" name="car_usu"
                                    onkeypress="return caracteres_especiales(event)" type="input" class="form-control "
                                    placeholder="">
                                <p id="val_car_usu"
                                    style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">
                                    * Debe Ingresar el Cargo.</p>
                            </div>
                        </div>

                        <!--  FIN INICIO IDENTIFICACIÓN SECTORIALISTA -->

                        <!--  IDENTIFICACION DEL NNA o GESTANTE -->

                        <hr style="background-color:black;">
                        <h5><b>II. IDENTIFICACIÓN DEL NNA o GESTANTE MENOR A 18 AÑOS:</b></h5>
                        <br>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Run:</b></label>
                            <div class="col-sm-5">
                                <input type="input" class="form-control" id="nna_run" name="nna_run"
                                    placeholder="Ej. 20.667.876-2">
                                <p id="val_nna_run"
                                    style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">
                                    * Debe Ingresar el Rut del NNA o Gestante.</p>
                            </div>
                            <div class="col-sm-4">
                                <input type="checkbox" id="chk_sin_run"><label for="" class="col-sm-3 col-form-label"
                                    style="color:#858796;"><b>Sin Run</b></label>
                            </div>

                        </div>

                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Nombre:</b></label>
                            <div class="col-sm-9">
                                <input maxlength="100" onkeypress="return caracteres_especiales(event)" type="input"
                                    class="form-control " placeholder="Ej. Juan Perez" name="nna_nombre"
                                    id="nna_nombre">
                                <p id="val_nna_nombre"
                                    style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">
                                    * Debe Ingresar el Nombre del NNA o Gestante.</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Fecha de
                                    Nacimiento:</b></label>
                            <div class="col-sm-3">
                                {{-- <input maxlength="100" onkeypress="return caracteres_especiales(event)" type="input" class="form-control " id="nna_fecha_nac" name="nna_fecha_nac" placeholder="Ej. 99/99/9999"> --}}
                                <div class="input-group date-pick" id="div_nna_fecha_nac" data-target-input="nearest">
                                    <input onkeypress="return caracteres_especiales_fecha(event)" type="text"
                                        name="fec_ses_tar" class="form-control datetimepicker-input "
                                        data-target="#div_nna_fecha_nac" id="nna_fecha_nac" value="">
                                    <div class="input-group-append" data-target="#div_nna_fecha_nac"
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                                <p id="val_nna_fecha_nac"
                                    style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">
                                    * Debe Ingresar la Fecha de Nacimiento .</p>

                            </div>
                        </div>

                        <div class="form-group row" style="display: none">
                            <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Edad (años y
                                    meses):</b></label>

                            <div class="col-sm-9">
                                <input maxlength="100" onkeypress="return caracteres_especiales(event)" type="hidden"
                                    class="form-control " id="nna_edad" name="nna_edad"
                                    placeholder="Edad (años y meses)">
                                <p id="val_nna_edad"
                                    style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">
                                    * Debe Ingresar la Edad.</p>
                            </div>
                        </div>

                        <!--  <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Meses:</b></label>
                                
                                <div class="col-sm-1">
                                  <input type="number" class="form-control" id="meses" nombre="meses" placeholder="Meses">
                                </div>
                              </div> -->

                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Sexo:</b></label>
                            <div class="col-sm-2">

                                <select class="form-control" id="nna_sexo" name="nna_sexo">
                                    <option value="">Seleccione</option>
                                    <option value="1">Masculino</option>
                                    <option value="2">Femenino</option>
                                </select>
                                <p id="val_nna_sexo"
                                    style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">
                                    * Debe Seleccionar el Sexo.</p>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label" style="color:#858796;">
                                <b>Cuidador principal del NNA:</b>
                            </label>
                            <div class="col-sm-9">
                                <input maxlength="100" onkeypress="return caracteres_especiales(event)" type="input"
                                    class="form-control " id="nna_nom_cui" name="nna_nom_cui"
                                    placeholder="Ej. Juan Perez">
                                <p id="val_nna_nom_cui"
                                    style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">
                                    * Debe Ingresar Cuidador Principal.</p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label" style="color:#858796;">
                                <b>Telefono de Cuidador Principal:</b>
                            </label>
                            <div class="col-sm-9">
                                <input maxlength="100" onkeypress="return caracteres_especiales(event)" type="input"
                                    class="form-control " id="nna_num_cui" name="nna_num_cui"
                                    placeholder="Ej. 986765726" maxlength="12">
                                <p id="val_nna_num_cui"
                                    style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">
                                    * Debe Telefono Cuidador Principal.</p>
                            </div>
                        </div>

                        <!-- DATOS DEL NNA SIN RUT -->
                        <div id="contenido_sin_rut" style="display: none">
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label" style="color:#858796;">
                                    <b>Nombre de la Madre:</b>
                                </label>
                                <div class="col-sm-9">
                                    <input maxlength="100" onkeypress="return caracteres_especiales(event)" type="input"
                                        class="form-control " id="nna_nom_mad" name="nna_nom_mad"
                                        placeholder="Ej. Emilia">
                                    <p id="val_nna_nom_mad"
                                        style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">
                                        * Debe ingresar el nombre de la madre.</p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label" style="color:#858796;">
                                    <b>Apellido de la Madre:</b>
                                </label>
                                <div class="col-sm-9">
                                    <input maxlength="100" onkeypress="return caracteres_especiales(event)" type="input"
                                        class="form-control " id="nna_ape_mad" name="nna_ape_mad"
                                        placeholder="Ej. Perez">
                                    <p id="val_nna_ape_mad"
                                        style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">
                                        * Debe ingresar el apellido de la madre.</p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label" style="color:#858796;">
                                    <b>Nombre del Padre:</b>
                                </label>
                                <div class="col-sm-9">
                                    <input maxlength="100" onkeypress="return caracteres_especiales(event)" type="input"
                                        class="form-control " id="nna_nom_pad" name="nna_nom_pad"
                                        placeholder="Ej. Tomás">
                                    <p id="val_nna_nom_pad"
                                        style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">
                                        * Debe ingresar el nombre del padre.</p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label" style="color:#858796;">
                                    <b>Apellido del Padre:</b>
                                </label>
                                <div class="col-sm-9">
                                    <input maxlength="100" onkeypress="return caracteres_especiales(event)" type="input"
                                        class="form-control " id="nna_ape_pad" name="nna_ape_pad"
                                        placeholder="Ej. Gonzalez">
                                    <p id="val_nna_ape_pad"
                                        style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">
                                        * Debe ingresar debe ingresar el apellido del padre.</p>
                                </div>
                            </div>

                            @if (config('constantes.activar_maestro_direcciones'))
                            <hr style="background-color:black;">
                            <h5><b>DIRECCIONES: </b></h5><br>

                            <!-- PRIMERA PARTE SECCION DIRECCIONES -->
                            <div class="row">
                                <div class="col-3">
                                    <div class="form-group row">
                                        <label class="col-form-label" style="color:#858796;"><b>Región:</b></label>
                                        <select class="form-control" id="reg_id_snr" name="reg_id_snr"
                                            onchange="buscarDireccion();">
                                            <option value="">Seleccione</option>
                                            @foreach ($region as $v)
                                            <option value="{{$v->reg_id}}">{{$v->reg_nom}}</option>
                                            @endforeach
                                        </select>
                                        <p id="val_nna_region"
                                            style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">
                                            * Debe Seleccionar la Región.</p>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label" style="color:#858796;"><b>Comuna:</b></label>
                                        <select class="form-control" id="com_id_nna_snr" name="com_id_nna_snr"
                                            onchange="buscarDireccion();">
                                            <option value="">Seleccione</option>
                                            @foreach ($comunas as $v)
                                            <option value="{{$v->com_id}}">{{$v->com_nom}}</option>
                                            @endforeach
                                        </select>
                                        <p id="val_nna_comuna"
                                            style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">
                                            * Debe Seleccionar la Comuna.</p>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label" style="color:#858796;"><b>Calle / V&iacute;a /
                                                Camino:</b></label>
                                        <input maxlength="100" onkeypress="return caracteres_especiales(event)"
                                            type="input" class="form-control " id="nna_calle_snr" name="nna_calle_snr"
                                            placeholder=" Ej. Catedral" onblur="buscarDireccion();">
                                        <p id="val_nna_calle"
                                            style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">
                                            * Debe Ingresar la Calle.</p>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label"
                                            style="color:#858796;"><b>Numeraci&oacute;n:</b></label>
                                        <input maxlength="100" type="input"
                                            onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                                            class="form-control " id="nna_dir_snr" name="nna_dir_snr"
                                            placeholder="Ej. 2345" onblur="buscarDireccion();">
                                        <p id="val_nna_dir"
                                            style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">
                                            * Debe Ingresar la Dirección.</p>
                                    </div>
                                </div>

                                <div class="col-9" style="padding-left: 30px; padding-bottom: 30px;">
                                    <iframe id="mapa_AT" src="{{ $url_mapa }}" width="100%" height="100%"
                                        frameborder="0" style="border: 2px solid #3d8ece;"></iframe>
                                </div>
                            </div>
                            <!-- PRIMERA PARTE SECCION DIRECCIONES -->

                            <!-- SEGUNDA PARTE SECCION DIRECCIONES -->
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label class="col-form-label"
                                        style="color:#858796; padding-bottom: 0px;"><b>Depto.</b></label><br />
                                    <small class="text-muted" style="font-size: xx-small;">Ingrese el n&uacute;mero del
                                        departamento.</small>
                                    <input maxlength="100" type="text" class="form-control " id="nna_depto_snr"
                                        name="nna_depto_snr" value="" placeholder="Ej. Depto 23"
                                        onblur="buscarDireccion();">
                                </div>
                                <div class="col-sm-3">
                                    <label class="col-form-label"
                                        style="color:#858796; padding-bottom: 0px;"><b>Block</b></label><br />
                                    <small class="text-muted" style="font-size: xx-small;">Ingrese el n&uacute;mero o la
                                        letra del block.</small>
                                    <input maxlength="100" type="text" class="form-control " id="nna_block_snr"
                                        name="nna_block_snr" value="" placeholder="Ej. B" onblur="buscarDireccion();">
                                </div>
                                <div class="col-sm-3">
                                    <label class="col-form-label"
                                        style="color:#858796; padding-bottom: 0px;"><b>Casa</b></label><br />
                                    <small class="text-muted" style="font-size: xx-small;">Ingrese el n&uacute;mero de
                                        la casa.</small>
                                    <input maxlength="100" type="text" class="form-control " id="nna_casa_snr"
                                        name="nna_casa_snr" value="" placeholder="Ej. Casa 23"
                                        onblur="buscarDireccion();">
                                </div>
                                <div class="col-sm-3">
                                    <label class="col-form-label" style="color:#858796; padding-bottom: 0px;"><b>KM /
                                            Sitio</label><br />
                                    <small class="text-muted" style="font-size: xx-small;">Ingrese el kil&oacute;metro o
                                        el n&uacute;mero de sitio.</small>
                                    <input maxlength="100" type="text" class="form-control " id="nna_km_sitio_snr"
                                        name="nna_km_sitio_snr" value="" placeholder="Ej. Km 23 / Parcela 3"
                                        onblur="buscarDireccion();">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label"
                                    style="color:#858796; padding-bottom: 0px;"><b>Referencia</b></label><br />
                                <small class="text-muted" style="font-size: xx-small;">Ay&uacute;danos a encontrar tu
                                    domicilio, ingresa alg&uacute;n punto de referencia como calle principal, barrio o
                                    zona.</small>
                                <input maxlength="1000" type="text" class="form-control col-sm-12" id="nna_ref_snr"
                                    name="nna_ref_snr" value=""
                                    placeholder="Ej. Frente a la Iglesia Santa Ana, esquina San Martín">
                                <p id="val_nna_ref"
                                    style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">
                                    * Debe Ingresar Referencia.</p>
                            </div><br>
                            <!-- SEGUNDA PARTE SECCION DIRECCIONES -->
                            @endif
                        </div>

                        <!-- DATOS DEL NNA SIN RUT -->

                        <!-- MODAL NNA CON DATOS SIMILARES-->

                        <div id="frmNNAsimilar" class="modal fade" tabindex="-1" role="dialog"
                            aria-labelledby="formComponentesLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content p-4">
                                    <div class="card p-4 m-0 shadow-sm">
                                        <h5 class="modal-title text-center" id="formComponentesLabel"><b>El NNA
                                                ingresado presenta datos similares con el siguiente NNA:</b></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true"
                                                style="position: absolute; right: 5px; top: 5px; width: 23px; height: 23px; padding: 0; margin: 0;">&times;</span>
                                        </button>
                                        <br>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover" cellspacing="0"
                                                id="tabla_nna_similares">
                                                <thead>
                                                    <tr>
                                                        <!--<th>Run</th>-->
                                                        <th>Nombre del NNA</th>
                                                        <th>Fecha Nacimiento</th>
                                                        <th>Edad</th>
                                                        <th>Sexo</th>
                                                        <th>Datos de la Madre</th>
                                                        <th>Datos del Padre</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                        <div class="text-right">
                                        <span style="margin-right: 20px;">¿La alerta ingresada corresponde al siguiente NNA?</span>
                                            <button type="button" class="btn btn-success"
                                                onclick="ingresarAlertaNNaSinRun();" style="margin-right: 20px;">Sí</button>
                                            <button type="button" class="btn btn-primary" onclick="ingresarAlerta(1);"
                                                data-dismiss="modal">No</button>
                                            {{-- @if (config('constantes.activar_maestro_direcciones'))
                                          <button type="button" class="btn btn-primary" onclick="registrarDireccionAlerta(1);" data-dismiss="modal" style="margin-right: 20px;">No</button>
                                        @else
                                          <button type="button" class="btn btn-primary" onclick="ingresarAlerta(1);" data-dismiss="modal">No</button>
                                        @endif --}}

                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- MODAL NNA CON DATOS SIMILARES-->

                        <!--  FIN IDENTIFICACION DEL NNA o GESTANTE -->

                        <!--  III. DIRECCIONES -->
                        @if (!config('constantes.activar_maestro_direcciones'))
                        <hr style="background-color:black;">
                        <h5><b>III. DIRECCIONES: </b></h5><br>

                        <h5><b>REGISTRADAS: </b></h5><br>
                        <!-- // INICIO CZ SPRINT 69 -->
                        <table class="table tabla_dir" style="width: 100%;">
                            <thead>
                                <th>Región</th>
                                <th>Provincia</th>
                                <th>Comuna</th>
                                <th>Calle</th>
                                <th>Número</th>
                                <th>Depto</th>
                                <th>Block</th>
                                <th>Casa</th>
                                <th>KM / Sitio</th>
                                <th>Ubicación NNA</th>
                                <!--  <th>Acción</th> -->
                            <!-- // FIN CZ SPRINT 69 -->
                            </thead>
                            <tbody id="tabla_direcciones">

                            </tbody>
                        </table>
                        <!-- PRIMERA PARTE SECCION DIRECCIONES -->
                        <br>
                        <br>
                        <h5><b>NUEVA DIRECCION: </b></h5><br>
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group row">
                                    <label class="col-form-label" style="color:#858796;"><b>Región:</b></label>
                                    <!-- INICIO CZ SPRINT 55 -->
                                    <select class="form-control" id="reg_id" name="reg_id" onchange="buscarDireccion();"
                                        disabled>
                                        <!-- FIN CZ SPRINT 55 -->
                                        <option value="">Seleccione</option>
                                        @foreach ($region as $v)
                                        <option value="{{$v->reg_id}}">{{$v->reg_nom}}</option>
                                        @endforeach
                                    </select>
                                    <p id="val_nna_region"
                                        style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">
                                        * Debe Seleccionar la Región.</p>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label" style="color:#858796;"><b>Comuna:</b></label>
                                    <!-- INICIO CZ SPRINT 55 -->
                                    <select class="form-control" id="com_id_nna" name="com_id_nna"
                                        onchange="buscarDireccion();" disabled>
                                        <!-- FIN CZ SPRINT 55 -->
                                        <option value="">Seleccione</option>
                                        @foreach ($comunas as $v)
                                        <option value="{{$v->com_id}}">{{$v->com_nom}}</option>
                                        @endforeach
                                    </select>
                                    <p id="val_nna_comuna"
                                        style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">
                                        * Debe Seleccionar la Comuna.</p>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label" style="color:#858796;"><b>Calle / V&iacute;a /
                                            Camino:</b></label>
                                    <input maxlength="100" onkeypress="return caracteres_especiales(event)" type="input"
                                        class="form-control " id="nna_calle" name="nna_calle"
                                        placeholder=" Ej. Catedral" onblur="buscarDireccion();">
                                    <p id="val_nna_calle"
                                        style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">
                                        * Debe Ingresar la Calle.</p>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label"
                                        style="color:#858796;"><b>Numeraci&oacute;n:</b></label>
                                    <input maxlength="100" type="input"
                                        onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                                        class="form-control " id="nna_dir" name="nna_dir" placeholder="Ej. 2345"
                                        onblur="buscarDireccion();">
                                    <p id="val_nna_dir"
                                        style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">
                                        * Debe Ingresar la Dirección.</p>
                                </div>
                            </div>

                            <div class="col-9" style="padding-left: 30px; padding-bottom: 30px;">
                                <iframe id="mapa_AT" src="{{ $url_mapa }}" width="100%" height="100%" frameborder="0"
                                    style="border: 2px solid #3d8ece;"></iframe>
                            </div>
                        </div>
                        <!-- PRIMERA PARTE SECCION DIRECCIONES -->

                        <!-- SEGUNDA PARTE SECCION DIRECCIONES -->
                        <div class="form-group row">
                            <div class="col-sm-3">
                                <label class="col-form-label"
                                    style="color:#858796; padding-bottom: 0px;"><b>Depto.</b></label><br />
                                <small class="text-muted" style="font-size: xx-small;">Ingrese el n&uacute;mero del
                                    departamento.</small>
                                <input maxlength="100" type="text" class="form-control " id="nna_depto" name="nna_depto"
                                    value="" placeholder="Ej. Depto 23" onblur="buscarDireccion();">
                            </div>
                            <div class="col-sm-3">
                                <label class="col-form-label"
                                    style="color:#858796; padding-bottom: 0px;"><b>Block</b></label><br />
                                <small class="text-muted" style="font-size: xx-small;">Ingrese el n&uacute;mero o la
                                    letra del block.</small>
                                <input maxlength="100" type="text" class="form-control " id="nna_block" name="nna_block"
                                    value="" placeholder="Ej. B" onblur="buscarDireccion();">
                            </div>
                            <div class="col-sm-3">
                                <label class="col-form-label"
                                    style="color:#858796; padding-bottom: 0px;"><b>Casa</b></label><br />
                                <small class="text-muted" style="font-size: xx-small;">Ingrese el n&uacute;mero de la
                                    casa.</small>
                                <input maxlength="100" type="text" class="form-control " id="nna_casa" name="nna_casa"
                                    value="" placeholder="Ej. Casa 23" onblur="buscarDireccion();">
                            </div>
                            <div class="col-sm-3">
                                <label class="col-form-label" style="color:#858796; padding-bottom: 0px;"><b>KM /
                                        Sitio</label><br />
                                <small class="text-muted" style="font-size: xx-small;">Ingrese el kil&oacute;metro o el
                                    n&uacute;mero de sitio.</small>
                                <input maxlength="100" type="text" class="form-control " id="nna_km_sitio"
                                    name="nna_km_sitio" value="" placeholder="Ej. Km 23 / Parcela 3"
                                    onblur="buscarDireccion();">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label"
                                style="color:#858796; padding-bottom: 0px;"><b>Referencia</b></label><br />
                            <small class="text-muted" style="font-size: xx-small;">Ay&uacute;danos a encontrar tu
                                domicilio, ingresa alg&uacute;n punto de referencia como calle principal, barrio o
                                zona.</small>
                            <input maxlength="1000" type="text" class="form-control col-sm-12" id="nna_ref"
                                name="nna_ref" value=""
                                placeholder="Ej. Frente a la Iglesia Santa Ana, esquina San Martín">
                            <p id="val_nna_ref"
                                style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">*
                                Debe Ingresar Referencia.</p>
                        </div><br>
                        <!-- SEGUNDA PARTE SECCION DIRECCIONES -->
                        @endif
                        <!--  FIN DIRECCIONES -->

                        </br>
                        <div id="frmDireccion" class="modal fade" tabindex="-1" role="dialog"
                            aria-labelledby="formComponentesLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content p-4">
                                    <div class="card p-4 shadow-sm">
                                        <h5 class="modal-title" id="formComponentesLabel"><b>Agregar Dirección Alerta
                                                Territorial.</b></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true"
                                                style="position: absolute; right: 5px; top: 5px; width: 23px; height: 23px; padding: 0; margin: 0;">&times;</span>
                                        </button>
                                        <br>

                                        <form action="">
                                            <input type="hidden" name="id_componente" id="id_componente" value="">
                                            <input type="hidden" name="id_index" id="id_index" value="">

                                            <!-- REGION -->
                                            <div class="form-group">
                                                <label class="col-form-label"
                                                    style="color:#858796;"><b>Región:</b></label>
                                                <select class="form-control" id="reg_id_nna" name="reg_id_nna"
                                                    onchange="buscarDireccion();">
                                                    <option value="">Seleccione</option>
                                                    @foreach ($region as $v)
                                                    <option value="{{$v->reg_id}}">{{$v->reg_nom}}</option>
                                                    @endforeach
                                                </select>
                                                <p id="val_nna_region"
                                                    style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">
                                                    * Debe Seleccionar la Región.</p>
                                            </div>
                                            <!-- FIN REGION -->

                                            <!-- COMUNA -->
                                            <div class="form-group">
                                                <label class="col-form-label"
                                                    style="color:#858796;"><b>Comuna:</b></label>
                                                <select class="form-control" id="com_id_nna1" name="com_id_nna1"
                                                    onchange="buscarDireccion();">
                                                    <option value="">Seleccione</option>
                                                    @foreach ($comunas as $v)
                                                    <option value="{{$v->com_id}}">{{$v->com_nom}}</option>
                                                    @endforeach
                                                </select>
                                                <p id="val_nna_comuna"
                                                    style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">
                                                    * Debe Seleccionar la Comuna.</p>
                                            </div>
                                            <!-- FIN COMUNA -->

                                            <!-- CALLE-->
                                            <div class="form-group">
                                                <label for="form_dir"><b>Calle:</b></label>
                                                <input maxlength="100" type="text" maxlength="11" class="form-control "
                                                    name="dir_nom_call" id="dir_nom_call" placeholder="Calle"></input>
                                                <p id="val_dir_nom_call"
                                                    style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">
                                                    * Debe ingresar el nombre de la calle.</p>
                                            </div>
                                            <!-- FIN CALLE -->

                                            <!-- NUMERO CALLE-->
                                            <div class="form-group">
                                                <label for="form_dir"><b>Número:</b></label>
                                                <input maxlength="100" onkeypress='return caracteres_especiales(event)'
                                                    class="form-control " name="dir_num_call" id="dir_num_call"
                                                    placeholder="numero"></input>
                                                <p id="val_dir_num_call"
                                                    style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">
                                                    * Debe ingresar el número de la calle.</p>
                                            </div>
                                            <!-- FIN NUMERO CALLE -->

                                            <!-- GUARDAR COMPONENTE O VOLVER-->
                                            <div class="text-right">
                                                <button type="button" class="btn btn-primary btn-md" id="id_btn_mod_dir"
                                                    onclick="guardarDireccion();">Guardar</button>
                                                <button type="button" class="btn btn-default btn-md"
                                                    data-dismiss="modal">Cerrar</button>
                                            </div>
                                            <!-- GUARDAR COMPONENTE O VOLVER-->

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- INICIO CZ -->
                        <!-- <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#frmDireccion" 
                        onclick="limpiarFormularioContacto();"><i class="fa fa-plus-circle"></i> Agregar Dirección</button> -->
                        <!-- FIN CZ -->

                        <!--  OTROS CONTACTOS DEL NNA -->

                        <hr style="background-color:black;">
                        @if (config('constantes.activar_maestro_direcciones'))
                        <h5><b>IV. OTROS CONTACTOS DEL NNA:</b></h5>
                        @else
                        <h5><b>IV. OTROS CONTACTOS DEL NNA:</b></h5>
                        @endif
                        <br>

                        <table class="table" id="tabla_contactos" style="width: 100%;">
                            <thead>
                                <th>Nombre</th>
                                <th>Parentesco o Relación</th>
                                <th>Teléfono</th>
                                <th>Dirección</th>
                                <th>Acción</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <br>

                        <button type="button" class="btn btn-outline-success" data-toggle="modal"
                            data-target="#frmContactos" onclick="limpiarFormularioContacto();"><i
                                class="fa fa-plus-circle"></i> Agregar Contacto</button>

                        <!--  FIN OTROS CONTACTOS DEL NNA -->


                        <!--  INICIO ALERTAS DETECTADAS -->

                        <hr style="background-color:black;">
                        @if (config('constantes.activar_maestro_direcciones'))
                        <h5><b>VI. ALERTAS DETECTADAS:</b></h5>
                        @else
                        <h5><b>VI. ALERTAS DETECTADAS:</b></h5>
                        @endif
                        <br>

                        <div class="row">
                            <div class="col form-group">
                                <!-- <h4><label for="">Alerta Territorial</label></h4> -->
                                <div class="col-sm-12">
                                    <input id="token" hidden value="{{ csrf_token() }}">
                                    <div class="table-responsive">
                                        <table class="table" cellspacing="0" id="tabla_alertas">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th class="text-center">Alerta Territorial</th>
                                                    <th class="text-center"> Información Relevante Detectada</th>

                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--  FIN INICIO ALERTAS DETECTADAS -->



                        <!--  ANTECEDENTES FAMILIARES: -->
                        <hr style="background-color:black;">
                        @if (config('constantes.activar_maestro_direcciones'))
                        <h5><b>VI. ANTECEDENTES FAMILIARES:</b></h5>
                        @else
                        <h5><b>VI. ANTECEDENTES FAMILIARES:</b></h5>
                        @endif
                        <br>

                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Historia
                                    familiar:</b></label>
                            <div class="col-sm-9">
                                <textarea maxlength="1000" onkeypress="return caracteres_especiales(event)"
                                    onKeyUp="valTextCrearAlertaHistFam()" onKeyDown="valTextCrearAlertaHistFam()"
                                    class="form-control" id="ante_hist_fam" name="ante_hist_fam"
                                    placeholder="Dinámica familiar, estilos de crianza, roles"></textarea>

                                <div class="row">
                                    <div class="col">
                                        <h6><small class="form-text text-muted">Mínimo 3 y máximo 1000
                                                caracteres.</small></h6>
                                    </div>
                                    <div class="col text-left">
                                        <h6><small class="form-text text-muted">N° de caracteres: <strong
                                                    id="cant_carac_1" style="color: #000000;">0</strong></small></h6>
                                    </div>
                                </div>

                                <p id="val_ante_hist_fam"
                                    style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">
                                    * Ingrese Historia Familiar.</p>

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Aspectos del grupo
                                    familiar relevantes:</b></label>
                            <div class="col-sm-9">
                                <textarea maxlength="1000" onkeypress="return caracteres_especiales(event)"
                                    onKeyUp="valTextCrearAlertaAnteAspec()" onKeyDown="valTextCrearAlertaAnteAspec()"
                                    class="form-control" id="ante_aspec_fam" name="ante_aspec_fam"
                                    placeholder="Indique situaciones que permitan realizar un análisis compresivo de las alertas detectadas(Tratamiento psiquiátrico, consumo de OH y/o drogas, conductas infractoras, estado de abandono, episodios de VIF, situación de riesgo que afecte al NNA)"></textarea>


                                <div class="row">
                                    <div class="col">
                                        <h6><small class="form-text text-muted">Mínimo 3 y máximo 1000
                                                caracteres.</small></h6>
                                    </div>
                                    <div class="col text-left">
                                        <h6><small class="form-text text-muted">N° de caracteres: <strong
                                                    id="cant_carac_2" style="color: #000000;">0</strong></small></h6>
                                    </div>
                                </div>

                                <p id="val_ante_aspec_fam"
                                    style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">
                                    * Ingrese Aspectos del grupo familiar relevantes.</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Intervenciones y
                                    acciones previas realizadas por el profesional/sector que identifica la/las
                                    alertas:</b></label>
                            <div class="col-sm-9">
                                <textarea maxlength="1000" onkeypress="return caracteres_especiales(event)"
                                    onKeyUp="valTextCrearAlertaAnteInterv()" onKeyDown="valTextCrearAlertaAnteInterv()"
                                    class="form-control" id="ante_interv_fam" name="ante_interv_fam"
                                    placeholder="Detalle aquellas orientadas a mitigar los factores de riesgo identificados en el NNA y su familia"></textarea>

                                <div class="row">
                                    <div class="col">
                                        <h6><small class="form-text text-muted">Mínimo 3 y máximo 1000
                                                caracteres.</small></h6>
                                    </div>
                                    <div class="col text-left">
                                        <h6><small class="form-text text-muted">N° de caracteres: <strong
                                                    id="cant_carac_3" style="color: #000000;">0</strong></small></h6>
                                    </div>
                                </div>

                                <p id="val_ante_interv_fam"
                                    style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">
                                    * Ingrese Aspectos del grupo familiar relevantes.</p>

                            </div>
                        </div>

                        <!--  FIN ANTECEDENTES FAMILIARES:  -->

                        <!--  INICIO ESCOLARIDAD NNA -->
                        <div id="sector_escolaridad" name="sector_escolaridad" style="display:none">

                            <hr style="background-color:black;">
                            <h5><b>VII. ESCOLARIDAD NNA:</b></h5>
                            <br>
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Establecimiento
                                        Educacional:</b></label>
                                <div class="col-sm-9">
                                    <input maxlength="100" type="input" class="form-control" id="ale_man_est_edu"
                                        name="ale_man_est_edu" placeholder="Establecimiento Educacional">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label"
                                    style="color:#858796;"><b>Curso:</b></label>
                                <div class="col-sm-9">
                                    <input maxlength="100" id="ale_man_cur" name="ale_man_cur" type="input"
                                        class="form-control" placeholder="Curso">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label"
                                    style="color:#858796;"><b>Asistencia:</b></label>
                                <div class="col-sm-9">
                                    <input maxlength="100" id="ale_man_asi" name="ale_man_asi" type="input"
                                        class="form-control" placeholder="Asistencia">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Rendimiento:</b>
                                </label>
                                <div class="col-sm-9">
                                    <input maxlength="100" type="input" class="form-control" id="ale_man_ren"
                                        name="ale_man_ren" placeholder="Último promedio">
                                </div>
                            </div>
                        </div>
                        <!--  FIN ESCOLARIDAD NNA -->

                        <div id="sector_salud" name="" style="display:none">
                            <!--  INICIO SALUD NNA -->

                            <hr style="background-color:black;">
                            <h5><b>VII. SALUD NNA:</b></h5>

                            <br>
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label"
                                    style="color:#858796;"><b>Previsión:</b></label>
                                <div class="col-sm-9">
                                    <input maxlength="100" type="input" class="form-control" id="ale_man_pre"
                                        name="ale_man_pre" placeholder="Ej. Fonasa">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Centro de salud
                                        de control:</b></label>
                                <div class="col-sm-9">
                                    <input maxlength="100" type="input" class="form-control" id="ale_man_cen_sal"
                                        name="ale_man_cen_sal" placeholder="Ej. Centro de salud">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Antecedentes de
                                        salud relevante:</b></label>
                                <div class="col-sm-9">
                                    <textarea onkeypress="return caracteres_especiales(event)" maxlength="100"
                                        class="form-control" id="ale_man_ant_rel" name="ale_man_ant_rel"
                                        placeholder="Antecedentes de salud relevante..."></textarea>
                                </div>
                            </div>

                            <!--  FIN SALUD NNA -->
                        </div>

                        <hr style="background-color:black;">

                        <!--  <div class="form-group row">
                                <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                                <div class="col-sm-10">
                                  <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
                                </div>
                              </div> -->
                        <!--         <fieldset class="form-group">
                                <div class="row">
                                  <legend class="col-form-label col-sm-2 pt-0">Radios</legend>
                                  <div class="col-sm-10">
                                    <div class="form-check">
                                      <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="option1" checked>
                                      <label class="form-check-label" for="gridRadios1">
                                        First radio
                                      </label>
                                    </div>
                                  </div>
                                </div>
                               </fieldset>
                              <div class="form-group row">
                                <div class="col-sm-2">Checkbox</div>
                                <div class="col-sm-10">
                                  <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="gridCheck1">
                                    <label class="form-check-label" for="gridCheck1">
                                      Example checkbox
                                    </label>
                                  </div>
                                </div>
                              </div> -->
                        <!-- <div class="form-group row">
                                <div class="col-sm-10">
                                  <button type="submit" class="btn btn-primary">Sign in</button>
                                </div>
                              </div> -->

                        <hr style="border:15px;background-color:black;">


                        <!--  <div class="row">
                                <div class="col form-group">
                                    <h6><label>RUT</label></h6>
                                    <input required type="text" class="form-control" name="rut" id="rut" placeholder="15.373.345-k">
                                </div>
                            </div> -->

                        <!--   <div class="row">
                                <div class="col form-group">
                                    <h6><label>Nombres</label></h6>
                                    <input readonly type="text" required class="form-control" name="nombre_completo" id="nombre_completo" placeholder="Nombres">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col form-group">
                                    <h6><label>Observación</label></h6>
                                    <textarea readonly required class="form-control" id="ale_man_obs" name="ale_man_obs" placeholder="Observación..."></textarea>
                                </div>
                            </div>
 -->
                        <!--  <div class="row">
                                <div class="col form-group">
                                    <h4><label for="">Alerta Territorial</label></h4>
                                    <div class="col-sm-12">
                                        <input id="token" hidden value="{{ csrf_token() }}">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover" cellspacing="0" id="tabla_alertas">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th class="text-center">Alerta Territorial</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <br>
                            <hr> -->

                        <div class="row align-items-center">
                            <div class="col-md-6">
                            </div>
                            <div class="col-md-6 text-right">
                                @if(isset($run))
                                <a href="{{ route('atencion-nna').'/'.$run }}" onclick=""
                                    class="btn btn-success btn-lg">Regresar</a>
                                @endif
                                <input name="btn_reg" id="btn_reg" type="button" class="btn btn-primary btn-lg"
                                    value="Registrar Alerta" onclick="opcionIngresarAlerta();">

                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="mod-at" tabindex="-1" role="dialog" aria-labelledby="mod-at-nom" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-left-info">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                    style="position: absolute; right: 5px; top: 5px; width: 23px; height: 23px; padding: 0; margin: 0;">&times;</button>
                <h5> <i class="fa fa-info-circle fa-2x mr-2 text-info"></i> <span class="modal-title"
                        id="mod-at-nom"></span></h5>
            </div>
            <div class="modal-body" id="mod-at-des"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="elem_cont" nombre="elem_cont" value="0">
<input type="hidden" id="token" nombre="token" value="">

<!-- Modales -->
@includeif('alertas.msg_registrar_alerta')
@includeif('alertas.modal_direcciones_alerta')
<!-- INICIO CZ SPRINT 55 -->
<?php
      $com_id = session()->all()['com_id']; 
    ?>
<!-- FIN CZ SPRINT 55 -->
@stop
@section('script')
<script>
var alertas_contactos_add = new Array();
cargaTipoAlerta();

$(".alert").hide();

$(function() {

    $('.date-pick').datetimepicker({
        maxDate: $.now(),
        format: 'DD/MM/Y'
    });
    $('#nna_fecha_nac').val('');
});

$(document).ready(function() {
    // INICIO CZ SPRINT 55
    $("#reg_id").prop("disabled", true);
    $("#com_id_nna").prop("disabled", true);
    //FIN CZ SPINT 55
    // INICIO CZ SPRINT 55
    var idComuna = "<?php echo $com_id; ?>";

    let dataComuna = new Object();
    dataComuna.idComuna = idComuna;
    $.ajax({
        type: "GET",
        url: "{{route('buscar.region')}}",
        data: dataComuna
    }).done(function(resp) {
        var idComuna = resp['comuna'][0].com_id;
        var idRegion = resp['region'][0].reg_id;
        // var idProvincia = resp['region'][0].reg_id
        $("#reg_id option[value=" + idRegion + "]").attr("selected", true);
        $("#com_id_nna option[value=" + idComuna + "]").attr("selected", true);
        desbloquearPantalla();
    }).fail(function(objeto, tipoError, errorHttp) {
        desbloquearPantalla();
        manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
        return false;
    });
    //FIN CZ SPRINT 55 
    //capturar rut para mostrar direccion de nna
    $('#chk_sin_run').change(function() {

        if ($('#chk_sin_run').prop('checked')) {
            $("#nna_run").prop('disabled', true);
            $("#nna_run").val("");
            $("#contenido_sin_rut").fadeIn("slow");

        } else {
            $("#nna_run").prop('disabled', false);
            $("#contenido_sin_rut").fadeOut("slow");
            limpiarValNnaSinRut();
            $("#nna_ape_mad").val("");
            $("#nna_nom_mad").val("");
            $("#nna_ape_pad").val("");
            $("#nna_nom_pad").val("");
        }

    });

    $("#ingr_alert").submit(function(eventObj) {
        $("<input />").attr("type", "hidden").attr("name", "contactos").attr("value", JSON.stringify(
            alertas_contactos_add)).appendTo("#ingr_alert");

        return true;
    });

    //Valida el campo run y en caso de ser valido activa la funcion de busqueda

    $('#nna_run').rut({
        fn_error: function(input) {
            if (input.val() != '') {
                let run = input.val();
                let html = "<span class='align-middle'>RUN " + run + " es incorrecto.</span>";

                // limpiarFormulariAM();
                $("#msgRegistrar-modal-title").text("Error");
                $("#msgRegistrar-modal-body").html(html);
                $('#msgRegistrarAlerta').modal('show');
            }
        },
        fn_validado: function(input) {
           var run = $("#nna_run").val();
            // INICIO CZ SPRINT 69
            bloquearPantalla();
            let nna = $("#nna_run").val();
            if (nna.length > 7) {
                let run = nna.split('-');
                if (run[1]) {
                    let parametros = {
                        'per_run': run[0],
                        'per_dig': run[1]

                    }
                    let data = new Object();
                    data.per_run = run[0];
                    data.per_dig = run[1];
                    $.ajax({
                        type: "GET",
                        url: "{{route('buscar.alertaReg')}}",
                        data: data
                    }).done(function(resp) {
                        //INICIO CZ SPRINT 55
                        if (resp != "") {
                            $('#tabla_direcciones').empty().html(resp);
                        } else {
                            $('#tabla_direcciones').empty();
                            $("#nna_calle").val("");
                            $("#nna_dir").val("");
                            $("#nna_depto").val("");
                            $("#nna_block").val("");
                            $("#nna_km_sitio").val("");
                            $("#nna_calle").prop("disabled", false);
                            $("#nna_dir").prop("disabled", false);
                            $("#nna_depto").prop("disabled", false);
                            $("#nna_block").prop("disabled", false);
                            $("#nna_casa").prop("disabled", false);
                            $("#nna_km_sitio").prop("disabled", false);
                            $("#nna_ref").prop("disabled", false);
                        }
                        desbloquearPantalla();
                    }).fail(function(objeto, tipoError, errorHttp) {
                        desbloquearPantalla();
                        manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
                        return false;
                    });
                }
            }
            // FIN CZ SPRINT 69
            //alert(run);

            obtenerInformacionRunificador(run).then(function(data) {

                @if(Session::get('perfil') == config('constantes.perfil_gestor'))
                validarFrmNNAasignado(run, function(result) {

                    if (!result) {
                        data.estado = 0;
                        alert(
                            'NNA no puede ser asignado por este perfil, no se encuentra en nomina o asignado a este gestor.');
                        return false;
                    }
                });
                @endif

                if (data.estado == 1) {
                    // INICIO CZ SPRINT 61
                    let fec_res = moment(data.respuesta.FechaNacimiento).format(
                        "YYYY/MM/DD");
                    let fec = new Date(fec_res);
                    var edad = calcularEdad(fec);
                    fec = fec.getDate() + "/" + (fec.getMonth() + 1) + "/" + fec
                        .getFullYear();
                    $('#nna_fecha_nac').datetimepicker('date', fec);


                    if (edad > 18) {
                        alert("No se puede ingresar alerta a NNA mayor de 18");
                        $("#nna_run").val('');
                        // INICIO CZ SPRINT 62
                        $("#nna_nombre").val('');
                        $("#nna_fecha_nac").val('');
                        $("#nna_sexo").val('');

                        // FIN CZ SPRINT 62
                    } else {
                        $("#nna_nombre").val(data.respuesta.Nombres + " " + data.respuesta
                            .ApellidoPaterno + " " + data.respuesta.ApellidoMaterno);
                        let val_sex = 1;
                        if (data.respuesta.Sexo == "FEMENINO") val_sex = 2;
                        document.getElementById("nna_sexo").value = val_sex;
                        $("#nna_fecha_nac").val(fec);
                    }
                    // FIN CZ SPRINT 61

                } else if (data.estado == 0) {
                    console.log(data.mensaje);

                }
            }).catch(function(error) {
                console.log(error);

            });

            //autoCompletarFormularioFamiliar();
        }
    });
});

//INICIO CZ SPRINT 61
function calcularEdad(fecha) {
    var hoy = new Date();
    var cumpleanos = new Date(fecha);
    var edad = hoy.getFullYear() - cumpleanos.getFullYear();
    var m = hoy.getMonth() - cumpleanos.getMonth();

    if (m < 0 || (m === 0 && hoy.getDate() < cumpleanos.getDate())) {
        edad--;
    }

    return edad;
}
//FIN CZ SPRINT 61

function eliminarDireccion(id) {

    $.ajax({
        type: "GET",
        url: "{{route('eliminar.alertaReg')}}",
        data: {
            'id': id
        }
    }).done(function(resp) {
        var nna = $('#nna_run').val();
        var nna1 = nna.replace(/\./g, "");
        let run1 = nna1.split('-');
        if (run1[1]) {
            let data = new Object();
            data.per_run = run1[0];
            data.per_dig = run1[1];
            $.ajax({
                type: "GET",
                url: "{{route('buscar.alertaReg')}}",
                data: data
            }).done(function(resp) {
                $('#tabla_direcciones').empty().html(resp);

            }).fail(function(objeto, tipoError, errorHttp) {
                desbloquearPantalla();
                manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
                return false;
            });
        }


    }).fail(function(objeto, tipoError, errorHttp) {
        desbloquearPantalla();
        manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
        return false;
    });




}

function actualizarEstado(id, status) {
    let parametros = {
        'id': id,
        'estado': status
    }


    let data = new Object();
    data.id = id;
    data.estado = status;
    $.ajax({
        type: "GET",
        url: "{{route('estado.alertaReg')}}",
        data: data
    }).done(function(resp) {
        var nna = $('#nna_run').val();
        var nna1 = nna.replace(/\./g, "");
        let run1 = nna1.split('-');
        if (run1[1]) {

            let data2 = new Object();
            data2.per_run = run1[0];
            data2.per_dig = run1[1];
            $.ajax({
                type: "GET",
                url: "{{route('buscar.alertaReg')}}",
                data: data2
            }).done(function(resp) {
                $('#tabla_direcciones').empty().html(resp);

            }).fail(function(objeto, tipoError, errorHttp) {
                desbloquearPantalla();
                manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
                return false;
            });
        }
    }).fail(function(objeto, tipoError, errorHttp) {
        desbloquearPantalla();
        manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
        return false;
    });

}

function levantarTipoAlerta(_this) {
    let titulo = $(_this).text();
    let id = $(_this).attr("data-ale-tip-id");
    let descripcion = $("#tip_ale_des_" + id).html();

    $("#mod-at-nom").html(titulo);
    $("#mod-at-des").html(descripcion);
}

function limpiarValidacionesFormularioCrearAlerta() {

    $("#val_dim_id").hide();
    $("#dim_id").removeClass("is-invalid");

    $("#val_dir_usu").hide();
    $("#dir_usu_nna").removeClass("is-invalid");

    $("#val_car_usu").hide();
    $("#car_usu").removeClass("is-invalid");

    $("#val_nna_run").hide();
    $("#nna_run").removeClass("is-invalid");

    $("#val_nna_nombre").hide();
    $("#nna_nombre").removeClass("is-invalid");

    $("#val_nna_fecha_nac").hide();
    $("#nna_fecha_nac").removeClass("is-invalid");

    $("#val_nna_edad").hide();
    $("#nna_edad").removeClass("is-invalid");

    $("#val_nna_sexo").hide();
    $("#nna_sexo").removeClass("is-invalid");

    $("#val_nna_region").hide();
    $("#reg_id").removeClass("is-invalid");

    $("#val_nna_comuna").hide();
    $("#com_id_nna").removeClass("is-invalid");

    $("#val_nna_calle").hide();
    $("#nna_calle").removeClass("is-invalid");

    $("#val_nna_dir").hide();
    $("#nna_dir").removeClass("is-invalid");

    $("#val_nna_ref").hide();
    $("#nna_ref").removeClass("is-invalid");

    $("#val_nna_nom_cui").hide();
    $("#nna_nom_cui").removeClass("is-invalid");

    $("#val_nna_num_cui").hide();
    $("#nna_num_cui").removeClass("is-invalid");

    $("#val_ante_hist_fam").hide();
    $("#ante_hist_fam").removeClass("is-invalid");

    $("#val_ante_aspec_fam").hide();
    $("#ante_aspec_fam").removeClass("is-invalid");

    $("#val_ante_interv_fam").hide();
    $("#ante_interv_fam").removeClass("is-invalid");

}


function limpiarInfoRev() {

    var chk_com = $('input[name="ale_tip_id[]"]');

    var total = chk_com.length;

    for (var i = 0; i < total; i++) {

        var limpiar_id = chk_com[i];

        //alert(limpiar_id.value);

        $("#val_" + limpiar_id.value).hide();

        $(".info_rel_" + limpiar_id.value).removeClass("is-invalid");

    }

}

function validaInput() {

    var vinput = true;

    var dim_id = $("#dim_id").val();
    var dir_usu = $("#dir_usu_nna").val();
    var car_usu = $("#car_usu").val();
    var nna_run = $("#nna_run").val();
    var nna_nombre = $("#nna_nombre").val();
    var nna_fecha_nac = $("#nna_fecha_nac").val();
    //var nna_edad = $("#nna_edad").val();  
    var nna_sexo = $("#nna_sexo").val();
    var nna_region = $("#reg_id").val();
    var nna_comuna = $("#com_id_nna").val();
    var nna_calle = $("#nna_calle").val();
    var nna_dir = $("#nna_dir").val();
    var nna_ref = $("#nna_ref").val();
    var nna_nom_cui = $("#nna_nom_cui").val();
    var nna_num_cui = $("#nna_num_cui").val();

    var ante_hist_fam = $("#ante_hist_fam").val();
    var ante_aspec_fam = $("#ante_aspec_fam").val();
    var ante_interv_fam = $("#ante_interv_fam").val();

    if (dim_id == "") {
        $("#val_dim_id").show();
        $("#dim_id").addClass("is-invalid");
    }

    if (dir_usu == "") {
        $("#val_dir_usu").show();
        $("#dir_usu_nna").addClass("is-invalid");
        vinput = false;
    }

    if (car_usu == "") {
        $("#val_car_usu").show();
        $("#car_usu").addClass("is-invalid");
        vinput = false;
    }
    if (!$("#chk_sin_run").prop('checked')) {
        if (nna_run == "") {
            $("#val_nna_run").show();
            $("#nna_run").addClass("is-invalid");
            vinput = false;
        }
    }

    if (nna_nombre == "") {
        $("#val_nna_nombre").show();
        $("#nna_nombre").addClass("is-invalid");
        vinput = false;
    }

    if (nna_fecha_nac == "") {
        $("#val_nna_fecha_nac").show();
        $("#nna_fecha_nac").addClass("is-invalid");
        vinput = false;
    }

    if (nna_edad == "") {
        $("#val_nna_edad").show();
        $("#nna_edad").addClass("is-invalid");
        vinput = false;
    }

    if (nna_sexo == "") {
        $("#val_nna_sexo").show();
        $("#nna_sexo").addClass("is-invalid");
        vinput = false;
    }

    @if(!config('constantes.activar_maestro_direcciones'))
    if (nna_region == "") {
        $("#val_nna_region").show();
        $("#reg_id").addClass("is-invalid");
        vinput = false;
    }

    if (nna_comuna == "") {
        $("#val_nna_comuna").show();
        $("#com_id_nna").addClass("is-invalid");
        vinput = false;
    }

    if (nna_calle == "") {
        $("#val_nna_calle").show();
        $("#nna_calle").addClass("is-invalid");
        vinput = false;
    }

    if (nna_dir == "") {
        $("#val_nna_dir").show();
        $("#nna_dir").addClass("is-invalid");
        vinput = false;
    }
    //INICIO CZ SPRINT 55 
    // if(nna_ref==""){   
    //     $("#val_nna_ref").show();
    //     $("#nna_ref").addClass("is-invalid");
    //     vinput = false;
    // }
    //FIN CZ SPRINT 55
    @else
    if ($("#chk_sin_run").prop('checked')) {
        vinput = validaDireccionNNASinRun(vinput);
    }
    @endif

    if (nna_nom_cui == "") {
        $("#val_nna_nom_cui").show();
        $("#nna_nom_cui").addClass("is-invalid");
        vinput = false;
    }

    if (nna_num_cui == "") {
        $("#val_nna_num_cui").show();
        $("#nna_num_cui").addClass("is-invalid");
        vinput = false;
    }

    // V. ANTECEDENTES FAMILIARES

    if (ante_hist_fam.length < 3) {
        $("#val_ante_hist_fam").show();
        $("#ante_hist_fam").addClass("is-invalid");
        vinput = false;
    }

    if (ante_aspec_fam.length < 3) {
        $("#val_ante_aspec_fam").show();
        $("#ante_aspec_fam").addClass("is-invalid");
        vinput = false;
    }

    if (ante_interv_fam.length < 3) {
        $("#val_ante_interv_fam").show();
        $("#ante_interv_fam").addClass("is-invalid");
        vinput = false;
    }

    // FIN V. ANTECEDENTES FAMILIARES

    result = verificarSeleccionarAlerta();

    if (result == false) {

        vinput = false;
    }

    return vinput;

}


function ValidaFrm() {

    limpiarInfoRev();

    limpiarValidacionesFormularioCrearAlerta();

    var vinput = true;

    if ($("#chk_sin_run").prop('checked')) {

        limpiarValNnaSinRut();
        vinput = verificarCamposNNAsinRut();
    }

    vinput = validaInput();

    if (vinput == false) {
        //alert("Faltan campos por completar. Por favor verificar.");
        mensaje = "Faltan campos por completar. Por favor verificar.";
        mensajeTemporalRespuestas(0, mensaje);
    }
    console.log(vinput);
    return vinput;
}

function cargaTipoAlerta(recargar = 0) {
    let html = "";

    $.ajax({
        url: "{{ route('alertas.tipo') }}",
        type: "GET",
        timeout: 4000
    }).done(function(resp) {
        if (resp.estado == 1) {
            let respuesta = resp.respuesta;

            for (let c00 in respuesta) {
                let columna_1 =
                    '<input style="cursor: pointer" type="checkbox" name="ale_tip_id[]" id="ale_tip_id[]" value="' +
                    respuesta[c00]["ale_tip_id"] + '" ">';

                let columna_2 = '<div data-ale-tip-id="' + respuesta[c00]["ale_tip_id"] +
                    '" onclick="levantarTipoAlerta(this)">' + respuesta[c00]["ale_tip_nom"];

                columna_2 +=
                    '<div class="ml-2 btn btn-sm btn-info" data-toggle="modal" data-target="#mod-at"><small class="fa fa-search"></small> Detalle</div></div>';

                columna_2 += '<div id="tip_ale_des_' + respuesta[c00]["ale_tip_id"] +
                    '" style="display: none;">' + respuesta[c00]["ale_tip_des"] + '</div>';


                let columna_3 =
                    '<textarea onkeypress="return caracteres_especiales(event)" maxlength="1000" class="info_rel_' +
                    respuesta[c00]["ale_tip_id"] +
                    ' form-control  " name="ale_info_rel[]" id="ale_info_rel[]" style="height:60px;width:100%;" ></textarea> <p id="val_' +
                    respuesta[c00]["ale_tip_id"] +
                    '" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Ingrese Información Relevante.</p>';

                html += "<tr>";
                html += "<td>" + columna_1 + "</td>";
                html += "<td>" + columna_2 + "</td>";
                html += "<td>" + columna_3 + "</td>";
                html += "</tr>";
            }

            $('#tabla_alertas > tbody').html(html);

            $('#tabla_alertas').DataTable({
                language: {
                    "url": "{{ route('index') }}/js/dataTables.spanish.json"
                },
                ordering: false,
                paging: false,
                searching: false,
                info: false,
                columnDefs: [{
                        "className": "dt-center",
                        "targets": [0]
                    },
                    {
                        "className": "dt-left",
                        "targets": [1]
                    },
                    {
                        "className": "dt-left",
                        "targets": [2]
                    }
                ],
            });

        } else if (resp.estado == 0) {
            if (recargar < 1) {
                let contador = recargar + 1;

                cargaTipoAlerta(contador);

            } else {
                html = "<tr><td colspan='3'><b>" + resp.mensaje + "</b></td></tr>";

                $('#tabla_alertas > tbody').html(html);

                $('#tabla_alertas').DataTable({
                    language: {
                        "url": "{{ route('index') }}/js/dataTables.spanish.json"
                    },
                    ordering: false,
                    paging: false,
                    searching: false,
                    info: false,
                    columnDefs: [{
                            "className": "dt-center",
                            "targets": [0]
                        },
                        {
                            "className": "dt-left",
                            "targets": [1]
                        },
                        {
                            "className": "dt-left",
                            "targets": [2]
                        }
                    ],
                });
            }
        }
    }).fail(function(objeto, tipoError, errorHttp) {
        if (recargar < 2) {
            let contador = recargar + 1;

            cargaTipoAlerta(contador);

        } else {
            let mensaje =
                "Hubo un error al momento de buscar los tipos de Alertas Territoriales. Por favor intente nuevamente.";

            if (objeto.status === 0) {
                alert(mensaje + "\n\n- Sin conexión: Verifique su red o intente nuevamente.");

            } else if (objeto.status == 404) {
                alert(mensaje + "\n\n- Página solicitada no encontrada [404].");

            } else if (objeto.status == 500) {
                alert(mensaje + "\n\n- Error interno del servidor [500].");

            } else if (tipoError === 'parsererror') {
                alert(mensaje + "\n\n- Error al manipular respuesta JSON.");

            } else if (tipoError === 'timeout') {
                alert(mensaje + "\n\n- Error de tiempo de espera.");

            } else if (tipoError === 'abort') {
                alert(mensaje + "\n\n- Solicitud Ajax abortada.");

            } else {
                alert(mensaje);

                console.log('Error no capturado: ' + objeto.responseText);
            }

            console.log(objeto);
            return false;

        }
    });

    //ids = $('#com_id').val();
    /*  let tabla_alertas = $('#tabla_alertas').DataTable();
      tabla_alertas.clear().destroy();

      tabla_alertas = $('#tabla_alertas').on('error.dt',
      function (e, settings, techNote, message) {
          tabla_alertas.ajax.reload(null,false);

          console.log('Ocurrió un error al desplegar la información: ', message);

      //tabla_alertas = $('#tabla_alertas').DataTable({
      }).DataTable({  
          "language": { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
          "ordering":false,
          "processing": false, 
          "filter": false, 
          "destroy": true,
          "orderMulti": false, 
          "bPaginate": false,
          "ajax":{
            "url": "{{ route('alertas.tipo') }}",
            "timeout": 8000
          }, 


          //"{{ route('alertas.tipo') }}",
          "columns":[
              {
                "className": "text-center",
                'render': function(data, type, full, meta){
                    return '<input style="cursor: pointer" type="checkbox" name="ale_tip_id[]" id="ale_tip_id[]" value="' + full.ale_tip_id + '" ">';
                    //onclick="validarTipoAlerta(this);
                }
              },
              {
                "className": "text-left",
                'render': function(data, type, full, meta){
                    let html = '<div data-ale-tip-id="' + full.ale_tip_id + '" onclick="levantarTipoAlerta(this)">' + full.ale_tip_nom;
                    
                    html += '<div class="ml-2 btn btn-sm btn-info" data-toggle="modal" data-target="#mod-at"><small class="fa fa-search"></small> Detalle</div></div>';
                    
                    html += '<div id="tip_ale_des_' + full.ale_tip_id + '" style="display: none;">' + full.ale_tip_des + '</div>';

                    return html;
                }
              },
              { 
                'render': function(data, type, full, meta) {
                      let html = '<textarea class="info_rel_'+full.ale_tip_id+' form-control  " name="ale_info_rel[]" id="ale_info_rel[]" style="height:60px;width:100%;" ></textarea> <p id="val_'+full.ale_tip_id+'" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Ingrese Información Relevante.</p>';
                  
                      return html;
                }
              }]
      });*/
}


function verificarSeleccionarAlerta() {

    var vsalerta = true;

    var chk_com = $('input[name="ale_tip_id[]"]:checked');

    total = chk_com.length;

    if (total > 0) {
        result = validarCamposInfoRel();
        vsalerta = result;
    } else {
        alert("Debe Elegir Alerta(s) Territoriales para generar el registro.");
        vsalerta = false;
    }

    return vsalerta;

}

function validarCamposInfoRel() {

    var vcinfo = true;

    var chk_com = $('input[name="ale_tip_id[]"]:checked');
    var ale_info_rel = document.getElementsByName('ale_info_rel[]');

    total = chk_com.length;

    for (var i = 0; i < total; i++) {

        var info_rel = ale_info_rel[i];

        var ale_id = chk_com[i];

        var elem = $(".info_rel_" + ale_id.value).val();

        if (elem == "") {

            $("#val_" + ale_id.value).show();

            $(".info_rel_" + ale_id.value).addClass("is-invalid");

            vcinfo = false;

        }

    }

    return vcinfo;

}

function getFiltroOfertas() {
    var chk_com = $('input[name="ale_tip_id[]"]:checked');
    var str_com = new Array();

    var x = 0;

    for (i = 0; i < chk_com.length; i++) {
        //str_com.push(chk_com[i].value);
        str_com = str_com + "," + chk_com[i].value;
    }

    str_com = str_com.substring(1);

    return str_com;
}


function getAlertasDetectadas() {
    var chk_com = $('input[name="ale_tip_id[]"]:checked');
    var str_com = new Array();

    var x = 0;

    for (i = 0; i < chk_com.length; i++) {
        str_com.push(chk_com[i].value);
        //str_com = str_com + "," + chk_com[i].value;
    }

    //str_com = str_com.substring(1);

    return str_com;
}

function getInfoRelev() {

    var vcinfo = true;

    var chk_com = $('input[name="ale_tip_id[]"]:checked');
    var ale_info_rel = document.getElementsByName('ale_info_rel[]');

    total = chk_com.length;

    var info_rel = new Array();

    for (var i = 0; i < total; i++) {

        var ale_id = chk_com[i];

        info_rel.push($(".info_rel_" + ale_id.value).val());
    }

    return info_rel;

}


function buscarRut() {
    let url = $('#url_rut').val();
    let rut = $('#rut').val();

    $.get(url + '/' + rut, function(data) {

        //alert(data.persona.info_num_contacto_1);

        if (data.encontrado == true) {
            let html = "";

            if (data.pertenece_comuna == false) {
                html = "El RUN del NNA ingresado no pertenece a su comuna.<br>";
                html += "¿Desea ingresar de todas formas?";

                $("#msgRegistrar-modal-title").text("Mensaje");
                $("#msgRegistrar-modal-body").html(html);
                $("#msgRegistrar-modal-acep").css("display", "block");
                $("#msgRegistrar-modal-acep").attr("onclick", "habilitarFormAM('" + data.persona
                    .nombre_completo + "','" + data.persona.sexo + "','" + data.persona.fecha_nac + "','" +
                    data.persona.edad_agno + "','" + data.persona.edad_meses + "','" + data.persona
                    .info_nom_contacto_1 + "','" + data.persona.info_num_contacto_1 + "','" + data.persona
                    .dir_calle_1 + "','" + data.persona.dir_num_1 + "','" + data.persona.dir_com_1 + "','" +
                    data.persona.dir_reg_1 + "' ); cerrarModal();");
                $('#msgRegistrarAlerta').modal('show');
            } else if (data.pertenece_comuna == true) {
                habilitarFormAM(data.persona.nombre_completo, data.persona.sexo, data.persona.fecha_nac, data
                    .persona.edad_agno, data.persona.meses, data.persona.info_nom_contacto_1, data.persona
                    .info_num_contacto_1, data.persona.dir_calle_1, data.persona.dir_num_1, data.persona
                    .dir_com_1, data.persona.dir_reg_1);
            }
        } else if (data.encontrado == false) {
            limpiarFormulariAM();

            html = "El RUN no se encuentra registrado.";

            $("#msgRegistrar-modal-title").text("Error");
            $("#msgRegistrar-modal-body").html(html);
            $('#msgRegistrarAlerta').modal('show');
        }
    }).fail(function(data) {
        limpiarFormulariAM();

        html = "Hubo un error al momento de consultar el RUN ingresado.<br>Por favor intente nuevamente.";

        $("#msgRegistrar-modal-title").text("Error");
        $("#msgRegistrar-modal-body").html(html);
        $('#msgRegistrarAlerta').modal('show');
    });
}

function habilitarFormAM(nombre, sexo, fecha_nac, nna_ano, nna_meses, nom, num, calle, dir, com_cod, reg_cod) {

    if (nom == 'null') nom = "";
    if (num == 'null') num = "";

    var ano = fecha_nac.slice(0, 4);
    var mes = fecha_nac.slice(4, 6);
    var dia = fecha_nac.slice(6, 8);

    var f_nac = dia + "/" + mes + "/" + ano;

    //alert(reg_cod);

    $('#nombre_completo').val(nombre);
    $("#nombre_completo").prop('readonly', true);
    $('#ano').val(nna_ano);
    $("#ano").prop('readonly', true);
    $('#meses').val(nna_meses);
    $("#meses").prop('readonly', true);
    $('#nna_sexo').val(sexo);
    $("#nna_sexo").attr('disabled', 'disabled');
    $('#nna_region').val(reg_cod);
    $("#nna_region").attr('disabled', 'disabled');
    $('#nna_comuna').val(com_cod);
    $("#nna_comuna").attr('disabled', 'disabled');
    $('#fecha_nac').val(f_nac);
    $("#fecha_nac").prop('readonly', true);
    $('#nna_nom_cui').val(nom);
    $("#nna_nom_cui").prop('readonly', true);
    $('#nna_num_cui').val(num);
    $("#nna_num_cui").prop('readonly', true);
    $('#nna_calle').val(calle);
    $("#nna_calle").prop('readonly', true);
    $('#nna_dir').val(dir);
    $("#nna_dir").prop('readonly', true);

    $("#ale_man_obs").prop('readonly', false);
    $('#ale_man_obs').attr('disabled', false);
    $('#btn_reg').attr('disabled', false);

    //cargaTipoAlerta();
}

function cerrarModal() {
    $("#msgRegistrar-modal-title").text(" ");
    $("#msgRegistrar-modal-acep").css("display", "none");
    $("#msgRegistrar-modal-acep").removeAttr("onclick");
    $('#msgRegistrarAlerta').modal('hide');
}

function limpiarFormulariAM() {
    $('#rut').val('');
    $('#nombre_completo').val('');
    $('#ale_man_obs').attr('disabled', true);
    $('#btn_reg').attr('disabled', true);
    $('#tabla_alertas > tbody').remove();
    $('#tabla_alertas_info').remove();
}

function activaSector(opSelect) {

    $('#sector_salud').hide();
    $('#sector_escolaridad').hide();

    if (opSelect == 1) $('#sector_salud').show();

    if (opSelect == 2) $('#sector_escolaridad').show();

}

function validarTipoAlerta(_this) {
    let data = new Object();
    data.run = $('#rut').val();
    data.id = $(_this).val();

    $.ajax({
        url: "{{ route('alertas.tipo.validar') }}",
        type: "GET",
        data: data
    }).done(function(resp) {
        if (resp.estado == 1) {
            if (resp.respuesta == false) {
                $(_this).prop('checked', false);

                html = "NNA se encuentra con el mismo tipo de alerta territorial ya levantada.";

                $("#msgRegistrar-modal-title").text("<i class='fa fa-warning'></i> Error");
                $("#msgRegistrar-modal-body").html(html);
                $('#msgRegistrarAlerta').modal('show');
            }
        } else if (resp.estado == 0) {
            console.log(
                "Error al momento de validar el tipo de alerta territorial. Por favor intente nuevamente.");

        }
    }).fail(function(obj) {
        console.log(obj);
        console.log("Error al momento de validar el tipo de alerta territorial. Por favor intente nuevamente.");

    });
}


con_text_1 = "";

function valTextCrearAlertaHistFam() {
    num_caracteres_permitidos = 1000;

    num_caracteres = $("#ante_hist_fam").val().length;

    if (num_caracteres > num_caracteres_permitidos) {
        $("#ante_hist_fam").val(con_text_1);

    } else {
        con_text_1 = $("#ante_hist_fam").val();

    }

    if (num_caracteres >= num_caracteres_permitidos) {
        $("#cant_carac_1").css("color", "#ff0000");

    } else {
        $("#cant_carac_1").css("color", "#000000");

    }


    $("#cant_carac_1").text($("#ante_hist_fam").val().length);
}

con_text_2 = "";

function valTextCrearAlertaAnteAspec() {
    num_caracteres_permitidos = 1000;

    num_caracteres = $("#ante_aspec_fam").val().length;

    if (num_caracteres > num_caracteres_permitidos) {
        $("#ante_aspec_fam").val(con_text_2);

    } else {
        con_text_2 = $("#ante_aspec_fam").val();

    }

    if (num_caracteres >= num_caracteres_permitidos) {
        $("#cant_carac_2").css("color", "#ff0000");

    } else {
        $("#cant_carac_2").css("color", "#000000");

    }

    $("#cant_carac_2").text($("#ante_aspec_fam").val().length);
}

con_text_3 = "";

function valTextCrearAlertaAnteInterv() {
    num_caracteres_permitidos = 1000;

    num_caracteres = $("#ante_interv_fam").val().length;

    if (num_caracteres > num_caracteres_permitidos) {
        $("#ante_interv_fam").val(con_text_3);

    } else {
        con_text_3 = $("#ante_interv_fam").val();

    }

    if (num_caracteres >= num_caracteres_permitidos) {
        $("#cant_carac_3").css("color", "#ff0000");

    } else {
        $("#cant_carac_3").css("color", "#000000");

    }

    $("#cant_carac_3").text($("#ante_interv_fam").val().length);
}


function limpiarFormularioContacto() {
    $("#ale_man_con_par").val("");
    $("#ale_man_con_nom").val("");
    $("#ale_man_con_tel").val("");
    $("#ale_man_con_dir").val("");

}

function limpiarValidacionesFrmContacto() {

    $("#val_ale_man_con_par").hide();
    $("#val_ale_man_con_nom").hide();
    $("#val_ale_man_con_tel").hide();
    $("#val_ale_man_con_dir").hide();

    $("#ale_man_con_par").removeClass("is-invalid");
    $("#ale_man_con_nom").removeClass("is-invalid");
    $("#ale_man_con_tel").removeClass("is-invalid");
    $("#ale_man_con_dir").removeClass("is-invalid");
}
//inicio ch
function guardarDireccion() {

    var nna = $('#nna_run').val();
    var nna1 = nna.replace(/\./g, "");
    let run1 = nna1.split('-');
    let parametros = {
        'persona': run1[0],
        'region': $('#reg_id_nna').val(),
        'comuna': $('#com_id_nna1').val(),
        'calle': $('#dir_nom_call').val(),
        'num': $('#dir_num_call').val()
    }
    let parametros2 = {
        'per_run': run1[0],
        'per_dig': run1[1]
    }
    let data = new Object();
    data.persona = run1[0];
    data.region = $('#reg_id_nna').val();
    data.comuna = $('#com_id_nna1').val();
    data.calle = $('#dir_nom_call').val();
    data.num = $('#dir_num_call').val();





    $.ajax({
        type: "GET",
        url: "{{route('guardar.alertaReg')}}",
        data: data
    }).done(function(resp) {
        let data2 = new Object();
        data2.per_run = run1[0];
        data2.per_dig = run1[1];
        alert('Direccion Registrada');
        $.ajax({
            type: "GET",
            url: "{{route('buscar.alertaReg')}}",
            data: data2
        }).done(function(resp) {
            $('#tabla_direcciones').empty().html(resp);

        }).fail(function(objeto, tipoError, errorHttp) {
            desbloquearPantalla();
            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
            return false;
        });

    }).fail(function(objeto, tipoError, errorHttp) {
        desbloquearPantalla();
        manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
        return false;
    });

}
//fin ch
function guardarAlertaContacto() {
    limpiarValidacionesFrmContacto();

    let val_frm = validarFrmAlertaContacto();
    if (val_frm == false) return false;

    $("#frmContactos").modal('hide');

    var t = $('#tabla_contactos').DataTable({
        "language": {
            "url": "{{ route('index') }}/js/dataTables.spanish.json"
        },
        "paging": false,
        "searching": false,
        "info": false,
        "ordering": false,
        "bDestroy": true
    });

    // var input= "<input type='input' id='otros_contac[]' name='otros_contac[]' value="+ $("#ale_man_con_nom").val()+" >";

    var elem = $("#elem_cont").val();

    let nombre = $("#ale_man_con_nom").val();
    let parentesco = $("#ale_man_con_par").val();
    let telefono = $("#ale_man_con_tel").val();
    let direccion = $("#ale_man_con_dir").val();

    alertas_contactos_add[elem] = Object();
    alertas_contactos_add[elem].nombre = nombre;
    alertas_contactos_add[elem].parentesco = parentesco;
    alertas_contactos_add[elem].telefono = telefono;
    alertas_contactos_add[elem].direccion = direccion;

    t.row.add([
        "<input type='input' class='elem_" + elem +
        "' disabled style='border: 0px solid; background-color: white;' id='otros_contac_nom[]' name='otros_contac_nom[]' value='" +
        nombre + "''>",
        "<input type='input' class='elem_" + elem +
        "' disabled style='border: 0px solid; background-color: white;' id='otros_contac_par[]' name='otros_contac_par[]' value='" +
        parentesco + "'>",
        "<input type='input' class='elem_" + elem +
        "' disabled style='border: 0px solid; background-color: white;' id='otros_contac_tel[]' name='otros_contac_tel[]' value='" +
        telefono + "'>",
        "<input type='input' class='elem_" + elem +
        "' disabled style='border: 0px solid; background-color: white;' id='otros_contac_dir[]' name='otros_contac_dir[]' value='" +
        direccion + "'>",
        "<button type='button' onclick='eliminarFrmAlerContacto(this, " + elem +
        ");' class='btn btn-primary btn-sm elem_" + elem + "'>Eliminar</button>",
        //"+elem+"
    ]).draw(false);

    elem++;

    $("#elem_cont").val(elem);

    // Automatically add a first row of data
    $('#addRow').click();

    //recolectarDataFrmContacto();

    // listarComponentes();

    // limpiarFormularioComponente();


}

function eliminarFrmAlerContacto(elem, index) {
    let table = $('#tabla_contactos').DataTable();

    table.row($(elem).parent().parent()).remove().draw();
    alertas_contactos_add.splice(index, 1);

    //console.log(); return false;

    //$(elem).parent().parent().remove();
    /*$(".elem_"+elem).parent().parent().remove();
    let index = $("#elem_cont").val();
    $("#elem_cont").val(index - 1);*/
}

function validarFrmGuardarDireccion() {
    let respuesta = true;

    let reg = $("#reg_id").val();
    let com = $("#com_id_nna").val();
    let call = $("#dir_nom_call").val();
    let num = $("#dir_num_call").val();

    if (reg == "" || typeof reg === "undefined") {
        respuesta = false;
        $("#val_nna_region").show();
        $("#reg_id").addClass("is-invalid");
    }

    if (com == "" || typeof com === "undefined") {
        respuesta = false;
        $("#val_nna_comuna").show();
        $("#com_id_nna").addClass("is-invalid");
    }

    if (call == "" || typeof call === "undefined") {
        respuesta = false;
        $("#val_dir_nom_call").show();
        $("#dir_nom_call").addClass("is-invalid");
    }

    if (num == "" || typeof num === "undefined") {
        respuesta = false;
        $("#val_dir_num_call").show();
        $("#dir_num_call").addClass("is-invalid");
    }

    return respuesta;
}

function validarFrmAlertaContacto() {

    let respuesta = true;

    let nom = $("#ale_man_con_nom").val();
    let par = $("#ale_man_con_par").val();
    let tel = $("#ale_man_con_tel").val();
    let dir = $("#ale_man_con_dir").val();

    if (nom == "" || typeof nom === "undefined") {
        respuesta = false;
        $("#val_ale_man_con_nom").show();
        $("#ale_man_con_nom").addClass("is-invalid");
    }

    if (par == "" || typeof par === "undefined") {
        respuesta = false;
        $("#val_ale_man_con_par").show();
        $("#ale_man_con_par").addClass("is-invalid");
    }

    if (tel == "" || typeof tel === "undefined") {
        respuesta = false;
        $("#val_ale_man_con_tel").show();
        $("#ale_man_con_tel").addClass("is-invalid");
    }

    if (dir == "" || typeof dir === "undefined") {
        respuesta = false;
        $("#val_ale_man_con_dir").show();
        $("#ale_man_con_dir").addClass("is-invalid");
    }

    return respuesta;

}

@if(config('constantes.activar_maestro_direcciones'))

function ingresarAlerta(estado, run) {
    $("#btn_reg").attr("onclick", "ingresarAlerta(" + estado + "," + run + ");");
    @else

    function ingresarAlerta(estado, nna_srn = null) {
        let res_val_frm = ValidaFrm();
        if (res_val_frm == false) return false;
        @endif

        bloquearPantalla();

        let url = $("#url_ingresar_alerta").val();
        //var frm = document.getElementById('ingr_alert');
        var data = new Object();

        // I. IDENTIFICACIÓN USUARIO
        data.dim_id = $("#dim_id").val();
        data.dir_usu_nna = $("#dir_usu_nna").val();
        data.car_usu = $("#car_usu").val();

        // II. IDENTIFICACIÓN DEL NNA o GESTANTE MENOR A 18 AÑOS
        @if(config('constantes.activar_maestro_direcciones'))
        data.estado = estado;
        data.nna_run = run;
        if (estado == 1) {
            data.nom_mad = $("#nna_nom_mad").val();
            data.ape_mad = $("#nna_ape_mad").val();
            data.nom_pad = $("#nna_nom_pad").val();
            data.ape_pad = $("#nna_ape_pad").val();
            data.estado = estado;

        }

        // AGREGA DIRECCIONES A LOS NNA SIN RUN CON MAESTRO DE DIRECCIONES
        if ($("#chk_sin_run").prop('checked')) direccionesNNASinRun();

        @else
        if (estado == 0) {
            data.nna_run = $("#nna_run").val();
            data.estado = estado;
        } else if (estado == 1) {
            data.nna_run = "";
            data.nom_mad = $("#nna_nom_mad").val();
            data.ape_mad = $("#nna_ape_mad").val();
            data.nom_pad = $("#nna_nom_pad").val();
            data.ape_pad = $("#nna_ape_pad").val();
            data.estado = estado;
        } else {
            data.nna_run = nna_srn;
            data.estado = estado;
        }
        @endif

        let nna_nombre = $("#nna_nombre").val();
        data.nna_nombre = nna_nombre.toUpperCase();
        data.nna_fecha_nac = $("#nna_fecha_nac").val();
        //data.nna_edad = $("#nna_edad").val();
        data.nna_edad = calcularEdades($("#nna_fecha_nac").val());
        data.nna_sexo = $("#nna_sexo").val();



        // DIRECCIÓN NNA
        data.id_dir = $("#id_dir").val();
        data.reg_id = $("#reg_id").val();
        data.com_id_nna = $("#com_id_nna").val();
        data.nna_calle = $("#nna_calle").val();
        data.nna_dir = $("#nna_dir").val();
        data.nna_depto = $("#nna_depto").val();
        data.nna_block = $("#nna_block").val();
        data.nna_casa = $("#nna_casa").val();
        data.nna_km_sitio = $("#nna_km_sitio").val();
        data.nna_ref = $("#nna_ref").val();
        data.nna_nom_cui = $("#nna_nom_cui").val();
        data.nna_num_cui = $("#nna_num_cui").val();

        // III. OTROS CONTACTOS DEL NNA

        data.contactos = alertas_contactos_add;

        // IV. ALERTAS DETECTADAS

        let ale_tip_id = getAlertasDetectadas();

        data.ale_tip_id = ale_tip_id;

        let ale_info_rel = getInfoRelev();

        data.ale_info_rel = ale_info_rel;

        // V. ANTECEDENTES FAMILIARES
        data.ante_hist_fam = $("#ante_hist_fam").val();
        data.ante_aspec_fam = $("#ante_aspec_fam").val();
        data.ante_interv_fam = $("#ante_interv_fam").val();

        // VI. SALUD NNA
        data.ale_man_pre = $("#ale_man_pre").val();
        data.ale_man_cen_sal = $("#ale_man_cen_sal").val();
        data.ale_man_ant_rel = $("#ale_man_ant_rel").val();

        // VI. ESCOLARIDAD NNA:
        data.ale_man_est_edu = $("#ale_man_est_edu").val();
        data.ale_man_cur = $("#ale_man_cur").val();
        data.ale_man_asi = $("#ale_man_asi").val();
        data.ale_man_ren = $("#ale_man_ren").val();
        data.estadoIncor = 1;
        data.ale_man_tipo = 1;

        $.ajaxSetup({
            //headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}
            headers: {
                'X-CSRF-TOKEN': $('#token_general').val()
            }
        });
        $.ajax({
            url: url,
            type: "POST",
            data: data
        }).done(function(resp) {
            desbloquearPantalla();
            console.log(resp);
            if (resp.estado == 1) {
                let mensaje = "Alerta(s) Territorial(es) registrada(s) exitosamente."
                alert(mensaje);
                @if(!isset($run))
                window.location.replace("{{ route('alertas.listar') }}");
                @else
                window.location.replace("{{ route('atencion-nna').'/'.$run }}");
                @endif
            } else if (resp.estado == 0) {
                let mensaje =
                    "Hubo un error al momento de crear la(s) Alerta(s) Territorial(es). Por favor intente nuevamente.";
                alert(resp.mensaje);

                $("#msg_alerta_erronea").show();
                setTimeout(function() {
                    $("#msg_alerta_erronea").fadeOut(2000);
                }, 3000);
            }
        }).fail(function(objeto, tipoError, errorHttp) {
            desbloquearPantalla();

            let mensaje = "Hubo un error al momento de guardar la(s) Alerta(s) Territorial(es) solicitada(s).";

            if (objeto.status === 0) {
                alert(mensaje + "\n\n- Sin conexión: Verifique su red o intente nuevamente.");

            } else if (objeto.status == 404) {
                alert(mensaje + "\n\n- Página solicitada no encontrada [404].");

            } else if (objeto.status == 500) {
                alert(mensaje + "\n\n- Error interno del servidor [500].");

            } else if (tipoError === 'parsererror') {
                alert(mensaje + "\n\n- Error al manipular respuesta JSON.");

            } else if (tipoError === 'timeout') {
                alert(mensaje + "\n\n- Error de tiempo de espera.");

            } else if (tipoError === 'abort') {
                alert(mensaje + "\n\n- Solicitud Ajax abortada.");

            } else {
                alert(mensaje);

                console.log('Error no capturado: ' + objeto.responseText);
            }

            $("#msg_alerta_erronea").show();
            setTimeout(function() {
                $("#msg_alerta_erronea").fadeOut(2000);
            }, 3000);
        });

    }

    function buscarDireccion() {
        let src = "{{ $url_mapa }}";

        let region = $("#reg_id option:selected").val();
        if (region == "" || region == null) {
            return false;
        }

        let comuna = $("#com_id_nna option:selected").val();
        if (comuna == "" || comuna == null) {
            return false;
        }

        let calle = $("#nna_calle").val();
        if ((calle.replace(/ /g, "")).length == 0 || calle == null) {
            return false;
        }

        let numeracion = $("#nna_dir").val();
        if ((numeracion.replace(/ /g, "")).length == 0 || numeracion == null) {
            numeracion = "S/N";
        }

        let block = " " + $("#nna_block").val();
        if ((block.replace(/ /g, "")).length == 0 || block == null) {
            block = "";
        }

        let depto = " " + $("#nna_depto").val();
        if ((depto.replace(/ /g, "")).length == 0 || depto == null) {
            depto = "";
        }

        let casa = " " + $("#nna_casa").val();
        if ((casa.replace(/ /g, "")).length == 0 || casa == null) {
            casa = "";
        }

        let km = " " + $("#nna_km_sitio").val();
        if ((km.replace(/ /g, "")).length == 0 || km == null) {
            km = "";
        }

        comuna = $("#com_id_nna option:selected").text();
        region = $("#reg_id option:selected").text();
        let direccion = `${calle} ${numeracion}${block}${depto}${casa}${km}, ${comuna}, ${region}`

        $('#mapa_AT').attr('src', `${src}&dirGeoCod=${direccion}`);
    }

    function verificarCamposNNAsinRut() {

        let respuesta = true;
        let nom_mad = $("#nna_nom_mad").val();
        let ape_mad = $("#nna_ape_mad").val();
        let nom_pad = $("#nna_nom_pad").val();
        let ape_pad = $("#nna_ape_pad").val();

        if ((nom_mad == "" || typeof nom_mad === "undefined") && (ape_mad == "" || typeof ape_mad === "undefined")) {

            if ((nom_pad == "" || typeof nom_pad === "undefined") && (ape_pad == "" || typeof ape_pad ===
                "undefined")) {

                respuesta = false;
                $("#val_nna_nom_mad").show();
                $("#nna_nom_mad").addClass("is-invalid");

                $("#val_nna_ape_mad").show();
                $("#nna_ape_mad").addClass("is-invalid");

            } else if (nom_pad == "" || typeof nom_pad === "undefined") {

                respuesta = false;
                $("#val_nna_nom_pad").show();
                $("#nna_nom_pad").addClass("is-invalid");

            } else if (ape_pad == "" || typeof ape_pad === "undefined") {

                respuesta = false;
                $("#val_nna_ape_pad").show();
                $("#nna_ape_pad").addClass("is-invalid");

            }

        } else if (nom_mad == "" || typeof nom_mad === "undefined") {

            respuesta = false;
            $("#val_nna_nom_mad").show();
            $("#nna_nom_mad").addClass("is-invalid");

        } else if (ape_mad == "" || typeof ape_mad === "undefined") {

            respuesta = false;
            $("#val_nna_ape_mad").show();
            $("#nna_ape_mad").addClass("is-invalid");

        }

        return respuesta;
    }

    function opcionIngresarAlerta() {
        if (!$("#chk_sin_run").prop('checked')) {
            @if(config('constantes.activar_maestro_direcciones'))
            registrarDireccionAlerta(0);
            @else
            ingresarAlerta(0);
            @endif
        } else {

            verificarNNAsinRut();
        }

    }

    function ingresarAlertaNNaSinRun() {

        let run = $("input:radio[name ='rd_nna_run']:checked").val();
        if (run == "" || typeof run === "undefined") {
            mensaje = "Por favor seleccione un NNA";
            mensajeTemporalRespuestas(0, mensaje);
        } else {
            $('#frmNNAsimilar').modal('hide');
            ingresarAlerta(2, run);
        }
    }

    function limpiarValNnaSinRut() {

        $("#val_nna_nom_mad").hide();
        $("#val_nna_ape_mad").hide();
        $("#val_nna_nom_pad").hide();
        $("#val_nna_ape_pad").hide();

        $("#nna_ape_mad").removeClass("is-invalid");
        $("#nna_nom_mad").removeClass("is-invalid");
        $("#nna_ape_pad").removeClass("is-invalid");
        $("#nna_nom_pad").removeClass("is-invalid");

    }

    function verificarNNAsinRut() {
        let res_val_frm = ValidaFrm();
        if (!res_val_frm) return false;

        bloquearPantalla();
        let data = new Object();

        data.nna_nom = $("#nna_nombre").val();
        data.nna_fec = $("#nna_fecha_nac").val();
        data.nom_mad = $("#nna_nom_mad").val();
        data.ape_mad = $("#nna_ape_mad").val();
        data.nom_pad = $("#nna_nom_pad").val();
        data.ape_pad = $("#nna_ape_pad").val();


        $.ajax({
            url: "{{ route('alertas.consulta.sinrun') }}",
            type: "GET",
            data: data
        }).done(function(resp) {

            let estado = resp.estado;
            let codigo = resp.codigo;

            if (estado == 0) {

                ingresarAlerta(1, '');
            } else if (estado == 1) {

                data.codigo = codigo;

                let tabla_nna_similares = $('#tabla_nna_similares').DataTable();
                tabla_nna_similares.clear().destroy();

                tabla_nna_similares = $('#tabla_nna_similares').DataTable({
                    "language": {
                        "url": "{{ route('index') }}/js/dataTables.spanish.json"
                    },
                    "lengthChange": false,
                    "searching": false,
                    "ajax": {
                        "url": "{{ route('alertas.listar.sinrun') }}",
                        "data": data
                    },
                    "columnDefs": [{ //NOMBRE DEL NNA
                            "targets": 0,
                            "className": 'dt-head-center dt-body-center',
                            "createdCell": function(td, cellData, rowData, row, col) {
                                $(td).css("vertical-align", "middle");

                            }
                        },
                        { //FECHA DE NACIMIENTO
                            "targets": 1,
                            "className": 'dt-head-center dt-body-left',
                            "createdCell": function(td, cellData, rowData, row, col) {
                                $(td).css("vertical-align", "middle");

                            }
                        },
                        { //EDAD
                            "targets": 2,
                            "className": 'dt-head-center dt-body-center',
                            "createdCell": function(td, cellData, rowData, row, col) {
                                $(td).css("vertical-align", "middle");

                            }
                        },
                        { //SEXO
                            "targets": 3,
                            "className": 'dt-head-center dt-body-center',
                            "createdCell": function(td, cellData, rowData, row, col) {
                                $(td).css("vertical-align", "middle");

                            }
                        },
                        { //DATOS DE LA MADRE
                            "targets": 4,
                            "className": 'dt-head-center dt-body-center',
                            "createdCell": function(td, cellData, rowData, row, col) {
                                $(td).css("vertical-align", "middle");

                            }
                        }
                    ],
                    "columns": [{
                            "data": "ale_man_nna_nombre",
                            "className": "text-center"
                        },
                        {
                            "data": "ale_man_nna_fec_nac",
                            "className": "text-center"
                        },
                        {
                            "data": "ale_man_nna_edad",
                            "className": "text-center"
                        },
                        {
                            "data": "ale_man_nna_sexo",
                            "className": "text-center",
                            "render": function(data, type, row) {
                                if (row.ale_man_nna_sexo == 1) {
                                    return "Maculino";
                                } else {
                                    return "Femenino";
                                }
                            }
                        },
                        {
                            "data": "dat_mat",
                            "className": "text-center"
                        },
                        {
                            "data": "dat_pat",
                            "className": "text-center"
                        },
                        {
                            "data": "ale_man_run",
                            "className": "text-center",
                            "render": function(data, type, row) {
                                let html = '<input type="radio" name="rd_nna_run" value="' + row
                                    .ale_man_run + '">';

                                return html;
                            }
                        }
                    ]
                });
                desbloquearPantalla();
                //$("input:radio[name=rd_nna_run]:first").prop("checked",true);
                $('#frmNNAsimilar').modal('show');
            }
            desbloquearPantalla();
        }).fail(function(objeto, tipoError, errorHttp) {
            desbloquearPantalla();
            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
            return false;
        });



    }

    function validarRegistroDireccion(opc, ID_transaccion, run) {
        let data = new Object();
        data.ID_transaccion = ID_transaccion;

        $.ajax({
            "url": "{{ route('validar.guardar.direccion') }}",
            "type": "GET",
            "data": data
        }).done(function(response) {

            if (response.status == 1) {
                $("#id_dir").val(response.query[0].id_dir);
                $("#reg_id").val(response.query[0].c_region);
                $("#com_id_nna").val(response.query[0].comunaine_txt);
                $("#nna_calle").val(response.query[0].n_calle);
                $("#nna_dir").val(response.query[0].numdomicilio);
                $("#nna_depto").val(response.query[0].dpto);
                $("#nna_block").val(response.query[0].block);
                $("#nna_casa").val(response.query[0].casa);
                $("#nna_km_sitio").val(response.query[0].sitio);
                $("#nna_ref").val(response.query[0].referencia);

                ingresarAlerta(opc, run);
            } else if (response.status != 1 && ($("#ModalIframe").data('bs.modal') || {})._isShown) {
                setTimeout(function() {
                    validarRegistroDireccion(opc, ID_transaccion, run);
                }, 3000);

            }
        }).fail(function(objeto, tipoError, errorHttp) {
            if (($("#ModalIframe").data('bs.modal') || {})._isShown) {
                setTimeout(function() {
                    validarRegistroDireccion(opc, ID_transaccion, run);
                }, 3000);
            }

        });
    }

    function registrarDireccionAlerta(opc) {
        let res_val_frm = ValidaFrm();
        if (res_val_frm == false) {
            $("#btn_reg").attr("onclick", "registrarDireccionAlerta(" + opc + ");");

            return false;
        }
        generarTokenSeguridad();
        let run = obtenerRUN(opc);
        let url = "{{ config('constantes.url_registrar_direccion') }}";
        let ID_fuente = "{{ config('constantes.ID_sistema_fuente') }}";
        let ID_negocio = "{{ config('constantes.ID_negocio') }}";
        let ID_transaccion = generarIDTransaccion(run);
        let token = $("#token").val();

        if (typeof token === "undefined") return false;

        let ruta = url + token + '/' + ID_fuente + '/' + run + '/' + ID_transaccion + '/' + ID_negocio +
            '/null/null/null/null';

        $("#iframe_direcciones").attr('src', ruta);

        //$("#ModalIframe").modal("show");
        $("#ModalIframe").modal({
            show: true,
            backdrop: 'static',
            keyboard: false
        });
        validarRegistroDireccion(opc, ID_transaccion, run);
    }

    function generarTokenSeguridad() {

        $.ajax({
            type: "GET",
            url: "{{route('generar.token.seguridad')}}",
            async: false,
        }).done(function(resp) {

            $("#token").val(resp.token);

        }).fail(function(objeto, tipoError, errorHttp) {

            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
            return false;
        });

    }

    function generarIDTransaccion(run) {
        // ID SISTEMA FUENTE
        let ID_fuente = "{{ config('constantes.ID_sistema_fuente') }}";

        // MARCA TEMPORAL
        let timestamp = new Date();
        timestamp = Math.floor(timestamp.getTime() / 1000)

        // NUMERO ALEATORIO
        let random = Math.floor(Math.random() * 90000);
        random = random + 10000;

        return respuesta = ID_fuente + run + timestamp + random;
    }

    function obtenerRUN(opc) {
        let run = "";

        if (opc == 0) {
            run = $("#nna_run").val();
            run = run.split('-')[0];

            run = limpiarFormatoRun(run);

        } else if (opc == 1) {
            run = "{{ Helper::crearRunAT() }}";
            run = run.split("-");
            run = run[0];

        } else {
            run = $("#nna_sin_run").val();

        }

        return run;
    }

    function pruebaAT() {
        let data = new Object();
        data.id_dir = "20200600685324153977231591104652";
        data.nna_run = "15397723";

        $.ajax({
            "url": "{{ route('alertas.registrar') }}",
            "type": "GET",
            "data": data
        }).done(function(response) {

        }).fail(function(objeto, tipoError, errorHttp) {


        });
    }

    function calcularEdades(fecha) {

        if (typeof fecha != "string" && fecha && esNumero(fecha.getTime())) {
            fecha = formatDate(fecha, "dd/MM/yyyy");
        }

        var values = fecha.split("/");
        var dia = values[0];
        var mes = values[1];
        var ano = values[2];

        // cogemos los valores actuales
        var fecha_hoy = new Date();
        var ahora_ano = fecha_hoy.getYear();
        var ahora_mes = fecha_hoy.getMonth() + 1;
        var ahora_dia = fecha_hoy.getDate();

        // realizamos el calculo
        var edad = (ahora_ano + 1900) - ano;
        if (ahora_mes < mes) {
            edad--;
        }
        if ((mes == ahora_mes) && (ahora_dia < dia)) {
            edad--;
        }
        if (edad > 1900) {
            edad -= 1900;
        }

        // calculamos los meses
        // var meses = 0;

        // if (ahora_mes > mes && dia > ahora_dia)
        //     meses = ahora_mes - mes - 1;
        // else if (ahora_mes > mes)
        //     meses = ahora_mes - mes
        // if (ahora_mes < mes && dia < ahora_dia)
        //     meses = 12 - (mes - ahora_mes);
        // else if (ahora_mes < mes)
        //     meses = 12 - (mes - ahora_mes + 1);
        // if (ahora_mes == mes && dia > ahora_dia)
        //     meses = 11;

        return edad;
    }

    function validaDireccionNNASinRun(valid) {

        let respuesta = valid;

        var nna_region = $("#reg_id_snr").val();
        var nna_comuna = $("#com_id_nna_snr").val();
        var nna_calle = $("#nna_calle_snr").val();
        var nna_dir = $("#nna_dir_snr").val();
        var nna_ref = $("#nna_ref_snr").val();

        if ($("#chk_sin_run").prop('checked')) {
            if (nna_region == "") {
                $("#val_nna_region").show();
                $("#reg_id_snr").addClass("is-invalid");
                respuesta = false;
            }

            if (nna_comuna == "") {
                $("#val_nna_comuna").show();
                $("#com_id_nna_snr").addClass("is-invalid");
                respuesta = false;
            }

            if (nna_calle == "") {
                $("#val_nna_calle").show();
                $("#nna_calle_snr").addClass("is-invalid");
                respuesta = false;
            }

            if (nna_dir == "") {
                $("#val_nna_dir").show();
                $("#nna_dir_snr").addClass("is-invalid");
                respuesta = false;
            }

            if (nna_ref == "") {
                $("#val_nna_ref").show();
                $("#nna_ref_snr").addClass("is-invalid");
                respuesta = false;
            }
        }
        return respuesta;
    }


    function direccionesNNASinRun() {

        $("#reg_id").val($("#reg_id_snr").val());
        $("#com_id_nna").val($("#com_id_nna_snr").val());
        $("#nna_calle").val($("#nna_calle_snr").val());
        $("#nna_dir").val($("#nna_dir_snr").val());
        $("#nna_depto").val($("#nna_depto_snr").val());
        $("#nna_block").val($("#nna_block_snr").val());
        $("#nna_casa").val($("#nna_casa_snr").val());
        $("#nna_km_sitio").val($("#nna_km_sitio_snr").val());
        $("#nna_ref").val($("#nna_ref_snr").val());

    }

    // VALIDA SI EL GESTOR PUEDE LEVANTAR UNA ALERTA DEL NNA INGRESADO
    function validarFrmNNAasignado(run, result) {
        let data = new Object();
        data.run = run;

        $.ajax({
            type: "GET",
            url: "{{route('validar.gestor.run')}}",
            data: data,
            async: false
        }).done(function(resp) {

            if (resp.estado == 1) {
                result(true);
            } else {
                $("#nna_run").val("");
                $("#nna_nombre").val("");
                $("#nna_fecha_nac").val("");
                result(false);
            }

        }).fail(function(objeto, tipoError, errorHttp) {
            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
            return false;
        });
    }
    // $(document).on('click', '#check_estado', function() {      
    //     console.log("aqui entro2"); 
    //     $("#check_estado").not(this).prop('checked', false);      
    // });
    // INICIO CZ SPRINT 69 -->
    function encontrado($key)
    {
        var chekbox_checkeados = 0;
        var no_check = 0;
        if($("#tabla_direcciones tr").length > 0){
            for(var i = 0; i < $("#tabla_direcciones tr").length; i++){
                if($(".checkbox_encontrado")[i].checked == true){
                    if(i != $key){
                        $("#radio"+i).prop('checked', false);  
                        $("#label_"+i).css("display", "none");
                    }
                }else{
                    no_check++;
                }
            }
        }
        if(chekbox_checkeados == 0 && no_check == $("#tabla_direcciones tr").length){
            $("#label_"+$key).css("display", "none");
            $("#nna_calle").val("");
            $("#nna_dir").val("");
            $("#nna_depto").val("");
            $("#nna_block").val("");
            $("#nna_casa").val("");
            $("#nna_km_sitio").val("");
            $( "#nna_calle" ).prop( "disabled", false );
            $( "#nna_dir" ).prop( "disabled", false );
            $( "#nna_depto" ).prop( "disabled", false );
            $( "#nna_block" ).prop( "disabled", false );
            $( "#nna_casa" ).prop( "disabled", false );
            $( "#nna_km_sitio" ).prop( "disabled", false );
        }else{
            $("#nna_calle").val($("#dir_call_"+$key).text());
            $("#nna_dir").val($("#dir_num_"+$key).text());
            $("#nna_depto").val($("#dir_dep_"+$key).text());
            $("#nna_block").val($("#dir_block_"+$key).text());
            $("#nna_casa").val($("#dir_casa_"+$key).text());
            $("#nna_km_sitio").val($("#dir_sit_"+$key).text());
            $("#label_"+$key).css("display", "contents");
            $( "#nna_calle" ).prop( "disabled", true );
            $( "#nna_dir" ).prop( "disabled", true );
            $( "#nna_depto" ).prop( "disabled", true );
            $( "#nna_block" ).prop( "disabled", true );
            $( "#nna_casa" ).prop( "disabled", true );
            $( "#nna_km_sitio" ).prop( "disabled", true );
        }
    }
    // FIN CZ SPRINT 69 -->
</script>
@stop