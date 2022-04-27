<!-- HIDDEN -->

<input type="hidden" name="bit_id" id="bit_id" value="">
<!-- HIDDEN -->

<div class="card colapsable shadow-sm" id="contenedor_informacion_bitacora">
    <a class="btn text-left p-0" data-toggle="collapse" data-target="#informacion_bitacora" aria-expanded="false"
        aria-controls="informacion_bitacora">
        <div class="card-header p-3">
            <h5 class="mb-0">
                I.&nbsp;Información Bitácora
            </h5>
        </div>
    </a>


    <div class="collapse" id="informacion_bitacora">
        <div class="card-body">
            <form>
                <!-- INICIO CZ SPRINT 67 -->
                <div class="form-group">
                    <label for="form_bit_fec_ing">Fecha de Bitacora:</label>
                    <div class="input-group date-pick" id="form_bit_fec_ing" data-target-input="nearest"
                        style="width: 15%;">
                        <input onkeypress='return caracteres_especiales_fecha(event)' type="text"
                            class="form-control datetimepicker-input " data-target="#form_bit_fec_ing"
                            id="bit_fec_ing" />
                        <div class="input-group-append" data-target="#form_bit_fec_ing" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                    <p id="val_frm_bit_fec_ing"
                        style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe registrar una
                        Fecha de Ingreso</p>
                </div>
                <div class="form-group">
                    <label for="form_bit_nom">Nombre Bitácora:</label>
                    <input maxlength="50" onkeypress="return caracteres_especiales(event)" type="text"
                        class="form-control " id="form_bit_nom">
                    <p id="val_frm_bit_nom" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">*
                        Debe ingresar un Nombre de Bitácora.</p>
                </div>
                <button type="button" class="btn btn-warning" id="editarDatosBitacora">Editar Bitacora</button>
                <button type="button" class="btn btn-success" style="display: none" id="guardarDatosBitacora">Guardar
                    Bitacora</button>
                <button type="button" class="btn btn-danger" style="display: none"
                    id="cancelarDatosBitacora">Cancelar</button>
                <!-- FIN CZ SPRINT 67 -->
                <script type="text/javascript">
                // INICIO CZ SPRINT 67
                function editarDatos(id) {
                    $("#bit_fec_ing").prop("disabled", false);
                    $("#form_bit_nom").prop("disabled", false);
                    $("#editarDatosBitacora").css("display", "none");
                    $("#guardarDatosBitacora").css("display", "initial");
                    $("#cancelarDatosBitacora").css("display", "initial");
                    $("#guardarDatosBitacora").attr('onclick', 'guardarDatos("' + id + '")');
                    $("#cancelarDatosBitacora").attr('onclick', 'cancelarDatos("' + id + '")');
                }

                function guardarDatos(id) {
                    let val_form = validarFormularioBitacora();
                    if (!val_form) {
                        return false;
                    }

                    bloquearPantalla();

                    let data = recolectarDataBitacora();
                    data.bit_id = id;

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type: "POST",
                        url: "{{ route('bitacora.datos.editar') }}",
                        data: data
                    }).done(function(resp) {
                        desbloquearPantalla();
                        if (resp.estado == 1) {
                            mensajeTemporalRespuestas(1, resp.respuesta);
                            $("#editarDatosBitacora").css("display", "initial");
                            $("#guardarDatosBitacora").css("display", "none");
                            $("#cancelarDatosBitacora").css("display", "none");
                            $('#form_bit_fec_ing input').prop( "disabled", true );
			                $('#form_bit_nom').prop( "disabled", true );
                        } else if (resp.estado == 0) {
                            mensajeTemporalRespuestas(0, resp.mensaje);

                        }
                    }).fail(function(objeto, tipoError, errorHttp) {
                        desbloquearPantalla();

                        manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

                        return false;
                    });
                }

                function cancelarDatos(id) {
                    $("#editarDatosBitacora").attr('onclick', 'editarDatos("' + id + '")');
                    let data = new Object();
                    data.pro_an_id = $("#pro_an_id").val();
                    data.bit_id = id;

                    bloquearPantalla();

                    $.ajax({
                        type: "GET",
                        url: "{{ route('bitacora.editar') }}",
                        data: data
                    }).done(function(resp) {
                        desbloquearPantalla();

                        if (resp.estado == 1) {
                            limpiarFormularioBitacora();

                            let fec = new Date(resp.respuesta.bit_fec_cre);
                            fec = fec.getDate() + "/" + (fec.getMonth() + 1) + "/" + fec.getFullYear();


                            $('#form_bit_fec_ing').datetimepicker('format', 'DD/MM/Y');
                            $('#form_bit_fec_ing').datetimepicker('date', fec);

                            $("#form_bit_nom").val(resp.respuesta.bit_tit);
                            $("#current_name").html(resp.respuesta.bit_tit);

                            $('#form_bit_fec_ing input').prop("disabled", true);
                            $('#form_bit_nom').prop("disabled", true);

                            $("#bit_id").val(id);

                        } else if (resp.estado == 0) {
                            mensajeTemporalRespuestas(0, resp.mensaje);

                        }
                    }).fail(function(objeto, tipoError, errorHttp) {
                        desbloquearPantalla();

                        manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

                        return false;
                    });
                    $("#editarDatosBitacora").css("display", "initial");
                    $("#guardarDatosBitacora").css("display", "none");
                    $("#cancelarDatosBitacora").css("display", "none");
                }
                // FIN CZ SPRINT 67
                </script>
            </form>
        </div>
    </div>
</div>

<div class="card colapsable shadow-sm" id="contenedor_descripcion_actividades">
    <a class="btn text-left p-0" data-toggle="collapse" data-target="#descripcion_actividades" aria-expanded="false"
        aria-controls="descripcion_actividades">
        <div class="card-header p-3">
            <h5 class="mb-0">
                II.&nbsp;Descripción de Actividades
            </h5>
        </div>
    </a>

    <div class="collapse" id="descripcion_actividades">
        <div class="card-body">
            @includeif('gestor_comunitario.bitacora.listar_actividades')
        </div>
    </div>
</div>
<div class="col-12 text-right">
    <button id="botonGuardarBitacora" type="button" class="btn btn-success"
        onclick="guardarBitacora();">Guardar</button>
    <button type="button" class="btn btn-secondary ml-2" onclick="cerrarBitacora();">Cerrar</button>
</div>
<script type="text/javascript">
function validarFormularioBitacora(){
    let respuesta   = true;
    let fec_ing     = $('#form_bit_fec_ing').data('date');
    let nom         = $("#form_bit_nom").val();

    if (fec_ing == "" || typeof fec_ing === "undefined"){
        respuesta = false;
        $("#val_frm_bit_fec_ing").show();
    }else{
        if (!validarFormatoFecha(fec_ing)){
            respuesta = false;
            $("#val_frm_bit_fec_ing").show();
        }

        if (!existeFecha(fec_ing)){
            respuesta = false;
            $("#val_frm_bit_fec_ing").show();
        }
    }

    if (nom == "" || typeof nom === "undefined"){
        respuesta = false;
        $("#val_frm_bit_nom").show();
    }

    return respuesta;
}

function recolectarDataBitacora(){
    let data = new Object();

    data.pro_an_id          = $('#pro_an_id').val();
    data.fecha_ingreso      = $('#form_bit_fec_ing').data('date');
    data.nombre_bitacora    = $("#form_bit_nom").val();
    data.tipo               = getTipoGestion();
    data.est_pro_id         = $('#est_pro_id').val();
    
    return data;
}

function guardarBitacora(){
    let val_form = validarFormularioBitacora();
    if (!val_form) {
        return false;
    }

    bloquearPantalla();

    let data = recolectarDataBitacora();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "POST",  
        url: "{{ route('bitacora.registrar') }}",
        data: data
    }).done(function(resp){
        desbloquearPantalla();

        if (resp.estado == 1){
            desplegarSeccionBitacora(1);
            ocultarFormularioBitacora();

            mensajeTemporalRespuestas(1, resp.mensaje);
        }else if(resp.estado == 0){
            mensajeTemporalRespuestas(0, resp.mensaje);

        }
    }).fail(function(objeto, tipoError, errorHttp){
        desbloquearPantalla();

        manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

        return false;
    });
}

function cerrarBitacora(){
    desplegarSeccionBitacora(1);
    ocultarFormularioBitacora();
    $("#current_name").html('Listado');
}

function mostrarSeccionFormularioBitacora(opcion){
    switch(opcion){
        case 2: //EDITAR
            $("#contenedor_descripcion_actividades").show().fadeIn(1000);
            $('#descripcion_actividades').collapse('show');


            $("#botonGuardarBitacora").hide();
            setTimeout(function() {
                listarActividades();
            }, 1000);
        break;

        case 1: //CREAR
        default:
            $("#contenedor_descripcion_actividades").hide().fadeOut(1000);
            $("#botonGuardarBitacora").show();
        break;
    }
}

function limpiarFormularioBitacora(){
    $('#form_bit_fec_ing').datetimepicker('clear');
    $("#form_bit_nom").val("");

    $('#form_bit_fec_ing input').prop( "disabled", false );
    $('#form_bit_nom').prop( "disabled", false );
    
    $("#val_frm_bit_fec_ing").hide();
    $("#val_frm_bit_nom").hide();

}
</script>