@extends('layouts.main')
@section('contenido')
<!-- //CZ 75 -->

<style type="text/css">
.multiselect-container>li {
    width: 200px;
    padding: 0px;
    margin: 0px;
}

.lbl {
    margin-left: 20px;
}

.lblAdd {
    width: 150px;
}

.form-control {
    margin-bottom: 8px;
    width: 300px;
}

.dv {
    position: relative;
    margin-left: -5px;
    margin-top: 5px;
}

.digver {
    margin-left: -5px;
    width: 40px;
}

.inputRut {
    width: 160px;
}

.btnAddComuna {
    margin-left: 120px;
}

.listComuna {
    border: 1px solid #428bca;
    min-height: 30px;
    margin-left: 150px;
    width: 350px;
    margin-bottom: 10px;
    padding: 5px;
}

.listComunaEdit {
    border: 1px solid #428bca;
    min-height: 30px;
    margin-left: 150px;
    width: 350px;
    margin-bottom: 10px;
    padding: 5px;
}

.itemComuna {}

.tdComuna {
    padding: 3px;
}

.itemComuna:hover {
    background-color: #E6E6E6;
}
</style>
<!-- INICIO DC SPRINT 66 -->
<main id="content">
    <section class="p-1 cabecera">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <h5><i class="{{$icono}}"></i>Gestionar Usuarios por OLN</h5>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container-fluid">
            <div class="card p-4 shadow-sm">
                <div class="col-5">
                    <button type="button" class="btn btn-primary" onclick="agregarUsuario();"><i
                            class="fa fa-user-plus"></i> Agregar Usuario</button>
                </div>
                <br>
                <div class="form-group row">
                    <label for="inputPassword" class="lbl col-form-label"><b>Filtrar por:</b></label>
                    <div>
                        <select id="opc_oln" name="opc_oln" class="form-control" style="margin-right:30px">

                        </select>
                    </div>
                    @php $perfiles = Helper::getPerfiles(); @endphp
                    <div>
                        <select id="cbxPerfil" name="" class="form-control">
                            <option value="">Seleccione un Perfil</option>
                            @foreach($perfiles as $value)
                            <option value="{{$value->id}}">{{$value->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="text-right lbl">
                        <button id="btnFiltrar" type="submit" class="btn btn-primary" onclick="procesarReporte();"><i
                                class="fa fa-search"></i> Filtrar</button>
                    </div>
                </div>
                <div class="row">
                    <!-- REPORTES -->
                    <div class="col-12">
                        <div id="reporte-contenido"></div>
                    </div>
                    <!-- REPORTES -->
                </div>
            </div>
        </div>
    </section>

</main>
<!-- FIN DC SPRINT 66 -->
@include('administrador.usuario.modal_Usuario')
@include('administrador.usuario.modal_intituciones')
@endsection

@section('script')
<!-- FUNCIONES DEL MODAL -->
<script>
getComunas();
getRegion();
$(document).ready(function() {
    $('#nna_run').rut({
        fn_error: function(input) {
            let run = input.val();
            let html = "<span class='align-middle'>El RUT ingresado es incorrecto. Favor validar.</span>";
            $("#val_nna_run").html(html);
            $("#val_nna_run").css("display", "block");
        },
        fn_validado: function(input) {
            $("#val_nna_run").html("");
            $("#val_nna_run").css("display", "none");
            var run = $("#nna_run").val();
            // INICIO CZ SPRINT 69
            bloquearPantalla();
            obtenerInformacionRunificador(run).then(function(data) {
                var nombres = data.respuesta.Nombres.split(' ');
                var nombre = "";
                for (var i = 0; i < nombres.length; i++) {
                    nombre += ' ' + nombres[i].charAt(0).toUpperCase() + nombres[i].slice(1)
                        .toLowerCase()
                }
                $('#addNombres').val(nombre);
                $('#addApePat').val(data.respuesta.ApellidoPaterno.charAt(0).toUpperCase() +
                    data.respuesta.ApellidoPaterno.slice(1).toLowerCase());
                $('#addApeMat').val(data.respuesta.ApellidoMaterno.charAt(0).toUpperCase() +
                    data.respuesta.ApellidoMaterno.slice(1).toLowerCase());
                var clave1Diacriticos = eliminarDiacriticos(data.respuesta.ApellidoPaterno);
                var clave1SinCaracterEspeciales = eliminarCaracterEspeciales(
                    clave1Diacriticos);
                var clave1 = clave1SinCaracterEspeciales.substr(0, 3);
                // CZ SPRINT 76
                var clave2 = $('#nna_run').val().split(".").join("").substr(0, 4);
                var clave = clave1.split("").reverse().join("").toLowerCase() + "." +clave2;
                // CZ SPRINT 76
                clave = clave.charAt(0).toUpperCase() + clave.slice(1);
                $("#clave").val(clave);
                    buscarUsuarioSSO($('#nna_run').val().split(".").join(""));
                desbloquearPantalla();
            }).catch(function(error) {
                console.log(error);
                desbloquearPantalla();
            });
        },
    });
    getComunas();
    getRegion();
    $("#show_hide_password span").on('click', function(event) {
        event.preventDefault();
        if ($('#clave').attr("type") == "text") {
            $('#clave').attr('type', 'password');
            $('#icono-ojo').addClass("fa-eye-slash");
            $('#icono-ojo').removeClass("fa-eye");
        } else if ($('#clave').attr("type") == "password") {
            $('#clave').attr('type', 'text');
            $('#icono-ojo').removeClass("fa-eye-slash");
            $('#icono-ojo').addClass("fa-eye");
        }
    });
    $('.vigencia-editar').change(function() {
        if (!this.checked) {
            $("#mensaje-editar").css("display", "initial");
        } else {
            $("#mensaje-editar").css("display", "none");
        }

    });

    $('.vigencia-agregar').change(function() {
        if (!this.checked) {
            $("#mensaje-agregar").css("display", "initial");
        } else {
            $("#mensaje-agregar").css("display", "none");
        }

    });
})
// CZ SPRINT 76
let recargar = 0
// CZ SPRINT 76
function validarEmail(valor) {
    if (/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i.test(valor)){
    return true;
    } else {
    return false;
    }
}

function guardarUsuario(){
    var splitrun = $('#nna_run').val().split(".").join("").split("-")[0];
    var run = $('#nna_run').val().split(".").join("");
    var  runCompleto = $('#nna_run').val();
    var nombres = $('#addNombres').val();
    var apePat = $('#addApePat').val();
    var apeMat = $('#addApeMat').val();
    var fono = $('#addFono').val();
    var mail = $('#addMail').val();
    var region = $('#addRegion').val();
    var institucion = $('#addInstituciones').val();
    var perfil = $('#addPerfil').val();
    var comuna = $('#addComuna').val();

    var validar = validar_formulario();
    
    if(validar == true){
        let data3 = new Object();
        data3.id = $("#id_usuario").val();
        if(data3.id != ''){
                $.ajax({
                url: "{{ route('verificar.casos') }}",
                type: "GET",
                data: data3	
            }).done(function(resp){
                // CZ SPRINT 76
                if((resp > 0 && static_perfil != perfil)){ //Posee casos asociados
                    mensajeTemporalRespuestas(0, 'El usuario posee casos asociados, no puede cambiar el Perfil');
                    desbloquearPantalla();
                }else if(resp > 0 && static_comuna != comuna){
                    mensajeTemporalRespuestas(0, 'El usuario posee casos asociados, no puede cambiar de OLN');
                    desbloquearPantalla();
                }else{ //No Posee casos asociados
                // CZ SPRINT 76
                    bloquearPantalla(); 
                    let data = new Object();
                    data.runCompleto = runCompleto;
                    data.run = splitrun;
                    data.rut = run;
                    data.nombres = nombres;
                    data.apePat = apePat;
                    data.apeMat = apeMat;
                    data.fono = fono;
                    data.mail = mail;
                    data.region = region;
                    data.institucion = institucion;
                    data.perfil = perfil;
                    data.comuna = comuna;
                    data.clave = $("#clave").val();
                    if($('#checkVigente').prop('checked')){
                        data.estado = 1;
                    }else{
                        data.estado = 0;
                    }
                    $.ajax({
                        url: "{{ route('guardar.usuario') }}",
                        type: "GET",
                        data: data
                    }).done(function(resp){       		
                        desbloquearPantalla();
                        toastr.success(resp.mensaje); 
                        let opc_oln = $('#opc_oln option:selected').val();

                        if (opc_oln != '0') {
                            procesarReporte();	
                        }
                        
                        // $('#modalAgregarUsuario').modal('hide');
                    }).fail(function(obj){
                        // $('#modalAgregarUsuario').modal('hide');
                        toastr.error('Ocurrió un error al guardar la información');
                        console.log(obj); return false;
                        desbloquearPantalla();
                    });
                }
            }).fail(function(obj){
                console.log(obj); return false;
            });
        }else{
            bloquearPantalla(); 
            let data = new Object();
            data.runCompleto = runCompleto;
            data.run = splitrun;
            data.rut = run;
            data.nombres = nombres;
            data.apePat = apePat;
            data.apeMat = apeMat;
            data.fono = fono;
            data.mail = mail;
            data.region = region;
            data.institucion = institucion;
            data.perfil = perfil;
            data.comuna = comuna;
            data.clave = $("#clave").val();
            if($('#checkVigente').prop('checked')){
                data.estado = 1;
            }else{
                data.estado = 0;
            }
            $.ajax({
                url: "{{ route('guardar.usuario') }}",
                type: "GET",
                data: data
            }).done(function(resp){       		
                desbloquearPantalla();
                // CZ SPRINT 77
                toastr.success(resp.mensaje); 
                let opc_oln = $('#opc_oln option:selected').val();

                if (opc_oln != '0') {
                    procesarReporte();	
                }
                
                // $('#modalAgregarUsuario').modal('hide');
            }).fail(function(obj){
                // $('#modalAgregarUsuario').modal('hide');
                toastr.error('Ocurrió un error al guardar la información');
                console.log(obj); return false;
                desbloquearPantalla();
            });
        }
    }
    
}

function guardarUsuario_2(){
    var splitrun = $('#nna_run').val().split(".").join("").split("-")[0];
    var run = $('#nna_run').val().split(".").join("");
    var  runCompleto = $('#nna_run').val();
    var nombres = $('#addNombres').val();
    var apePat = $('#addApePat').val();
    var apeMat = $('#addApeMat').val();
    var fono = $('#addFono').val();
    var mail = $('#addMail').val();
    var region = $('#addRegion').val();
    var institucion = $('#addInstituciones').val();
    var perfil = $('#addPerfil').val();
    var comuna = $('#addComuna').val();

    var validar = validar_formulario();
    
    if(validar == true){
        let data3 = new Object();
        data3.id = $("#id_usuario").val();
        if(data3.id != ''){
                $.ajax({
                url: "{{ route('verificar.casos') }}",
                type: "GET",
                data: data3	
            }).done(function(resp){
                // CZ SPRINT 76
                if((resp > 0 && static_perfil != perfil)){ //Posee casos asociados
                    mensajeTemporalRespuestas(0, 'El usuario posee casos asociados, no puede cambiar el Perfil');
                    desbloquearPantalla();
                }else if(resp > 0 && static_comuna != comuna){
                    mensajeTemporalRespuestas(0, 'El usuario posee casos asociados, no puede cambiar de OLN');
                    desbloquearPantalla();
                }else{ //No Posee casos asociados
                // CZ SPRINT 76
                    bloquearPantalla(); 
                    let data = new Object();
                    data.runCompleto = runCompleto;
                    data.run = splitrun;
                    data.rut = run;
                    data.nombres = nombres;
                    data.apePat = apePat;
                    data.apeMat = apeMat;
                    data.fono = fono;
                    data.mail = mail;
                    data.region = region;
                    data.institucion = institucion;
                    data.perfil = perfil;
                    data.comuna = comuna;
                    data.clave = $("#clave").val();
                    if($('#checkVigente').prop('checked')){
                        data.estado = 1;
                    }else{
                        data.estado = 0;
                    }
                    $.ajax({
                        url: "{{ route('administar.guardar_usuario') }}",
                        type: "GET",
                        data: data
                    }).done(function(resp){       		
                        desbloquearPantalla();
                        console.log("-----------------------------------------------------------------------------------------");
                        console.log("RESPUESTA DEL SSO AL MOMENTO DE GUARDAR EL USUARIO");
                        console.log(resp.sso_respuesta);
                        console.log("-----------------------------------------------------------------------------------------");
                toastr.success(resp.mensaje); 
                let opc_oln = $('#opc_oln option:selected').val();

                if (opc_oln != '0') {
                    procesarReporte();	
                }
                
                // $('#modalAgregarUsuario').modal('hide');
            }).fail(function(obj){
                // $('#modalAgregarUsuario').modal('hide');
                toastr.error('Ocurrió un error al guardar la información');
                console.log(obj); return false;
                desbloquearPantalla();
            });
        }
            }).fail(function(obj){
                console.log(obj); return false;
            });
        }else{
            bloquearPantalla(); 
            let data = new Object();
            data.runCompleto = runCompleto;
            data.run = splitrun;
            data.rut = run;
            data.nombres = nombres;
            data.apePat = apePat;
            data.apeMat = apeMat;
            data.fono = fono;
            data.mail = mail;
            data.region = region;
            data.institucion = institucion;
            data.perfil = perfil;
                data.perfil_option = perfil;
            
            data.comuna = comuna;
            data.clave = $("#clave").val();
            if($('#checkVigente').prop('checked')){
                data.estado = 1;
            }else{
                data.estado = 0;
            }
            $.ajax({
                url: "{{ route('administar.guardar_usuario') }}",
                type: "GET",
                data: data
            }).done(function(resp){       		
                desbloquearPantalla();
                console.log("-----------------------------------------------------------------------------------------");
                console.log("RESPUESTA DEL SSO AL MOMENTO DE GUARDAR EL USUARIO");
                console.log(resp.sso_respuesta);
                console.log("-----------------------------------------------------------------------------------------");
                toastr.success(resp.mensaje); 
                toastr.success(resp.mensaje); 
                let opc_oln = $('#opc_oln option:selected').val();

                if (opc_oln != '0') {
                    procesarReporte();	
                }
                
                // $('#modalAgregarUsuario').modal('hide');
            }).fail(function(obj){
                // $('#modalAgregarUsuario').modal('hide');
                toastr.error('Ocurrió un error al guardar la información');
                console.log(obj); return false;
                desbloquearPantalla();
            });
        }
    }
    
    }
    
function asignarRoles(){
    var splitrun = $('#nna_run').val().split(".").join("").split("-")[0];
    var run = $('#nna_run').val().split(".").join("");
    var  runCompleto = $('#nna_run').val();
    var nombres = $('#addNombres').val();
    var apePat = $('#addApePat').val();
    var apeMat = $('#addApeMat').val();
    var fono = $('#addFono').val();
    var mail = $('#addMail').val();
    var region = $('#addRegion').val();
    var institucion = $('#addInstituciones').val();
    var perfil = $('#addPerfil').val();
    var comuna = $('#addComuna').val();

    bloquearPantalla(); 
    let data = new Object();
    data.runCompleto = runCompleto;
    data.run = splitrun;
    data.rut = run;
    data.nombres = nombres;
    data.apePat = apePat;
    data.apeMat = apeMat;
    data.fono = fono;
    data.mail = mail;
    data.region = region;
    data.institucion = institucion;
    data.perfil = perfil;
    data.comuna = comuna;
    data.clave = $("#clave").val();
    if($('#checkVigente').prop('checked')){
        data.estado = 1;
    }else{
        data.estado = 0;
    }

    $.ajax({
        url: "{{ route('administar.asignar_roles') }}",
        type: "GET",
        data: data
    }).done(function(resp){       		
        desbloquearPantalla();
        console.log("-----------------------------------------------------------------------------------------");
        console.log("RESPUESTA DEL SSO AL MOMENTO DE ASIGNAR ROLES");
        console.log(resp.respuesta_SSO);
        console.log("-----------------------------------------------------------------------------------------");
        toastr.success(resp.respuesta_SSO.Detalle); 
        let opc_oln = $('#opc_oln option:selected').val();

        if (opc_oln != '0') {
            procesarReporte();	
        }
        
        // $('#modalAgregarUsuario').modal('hide');
    }).fail(function(obj){
        // $('#modalAgregarUsuario').modal('hide');
        toastr.error('Ocurrió un error al guardar la información');
        console.log(obj); return false;
        desbloquearPantalla();
    });
}

function eliminarVigencia(){
    var splitrun = $('#nna_run').val().split(".").join("").split("-")[0];
    var run = $('#nna_run').val().split(".").join("");
    var  runCompleto = $('#nna_run').val();
    var nombres = $('#addNombres').val();
    var apePat = $('#addApePat').val();
    var apeMat = $('#addApeMat').val();
    var fono = $('#addFono').val();
    var mail = $('#addMail').val();
    var region = $('#addRegion').val();
    var institucion = $('#addInstituciones').val();
    var perfil = $('#addPerfil').val();
    var comuna = $('#addComuna').val();

    bloquearPantalla(); 
    let data = new Object();
    data.runCompleto = runCompleto;
    data.run = splitrun;
    data.rut = run;
    data.nombres = nombres;
    data.apePat = apePat;
    data.apeMat = apeMat;
    data.fono = fono;
    data.mail = mail;
    data.region = region;
    data.institucion = institucion;
    data.perfil = perfil;
    data.comuna = comuna;
    data.clave = $("#clave").val();
    if($('#checkVigente').prop('checked')){
        data.estado = 1;
    }else{
        data.estado = 0;
    }

    $.ajax({
        url: "{{ route('administar.eliminar_vigencia') }}",
        type: "GET",
        data: data
    }).done(function(resp){       		
        desbloquearPantalla();
        console.log("-----------------------------------------------------------------------------------------");
        console.log("RESPUESTA DEL SSO AL MOMENTO DE SACAR LA VIGENCIA DEL SSO");
        console.log(resp.respuesta_SSO);
        console.log("-----------------------------------------------------------------------------------------");
        toastr.success(resp.respuesta_SSO.Detalle); 
        let opc_oln = $('#opc_oln option:selected').val();

        if (opc_oln != '0') {
            procesarReporte();	
        }
        
        // $('#modalAgregarUsuario').modal('hide');
    }).fail(function(obj){
        // $('#modalAgregarUsuario').modal('hide');
        toastr.error('Ocurrió un error al guardar la información');
        console.log(obj); return false;
        desbloquearPantalla();
    });
}
var comunas = [];

function validar_formulario() {
    var run = $('#nna_run').val();
    var nombres = $('#addNombres').val();
    var apePat = $('#addApePat').val();
    var apeMat = $('#addApeMat').val();
    var fono = $('#addFono').val();
    var mail = $('#addMail').val();
    var region = $('#addRegion').val();
    var institucion = $('#addInstituciones').val();
    var perfil = $('#addPerfil').val();
    var comuna = $('#addComuna').val();
    var error = 0;
    var msj = '';
    if (run == '') {
        msj = msj + '- Debe ingresar un RUN<br>';
        error = 1;
        $("#addRun").css("border", "1px solid #FF0000");
    } else {
        $("#addRun").css("border", "1px solid #d1d3e2");
    }
    if (nombres == '') {
        msj = msj + '- Debe ingresar los Nombres<br>';
        error = 1;
        $("#addNombres").css("border", "1px solid #FF0000");
    } else {
        $("#addNombres").css("border", "1px solid #d1d3e2");
    }
    if (apePat == '') {
        msj = msj + '- Debe ingresar el Apellido Paterno<br>';
        error = 1;
        $("#addApePat").css("border", "1px solid #FF0000");
    } else {
        $("#addApePat").css("border", "1px solid #d1d3e2");
    }
    if (apeMat == '') {
        msj = msj + '- Debe ingresar el Apellido Materno<br>';
        error = 1;
        $("#addApeMat").css("border", "1px solid #FF0000");
    } else {
        $("#addApeMat").css("border", "1px solid #d1d3e2");
    }
    if (fono == '') {
        msj = msj + '- Debe ingresar el Fono<br>';
        error = 1;
        $("#addFono").css("border", "1px solid #FF0000");
    } else {
        $("#addFono").css("border", "1px solid #d1d3e2");
    }
    if (mail == '') {
        msj = msj + '- Debe ingresar un Mail<br>';
        error = 1;
        $("#addMail").css("border", "1px solid #FF0000");
    } else {
        var respMail = validarEmail(mail);
        if (respMail == false) {
            error = 1;
            msj = msj + '- Debe ingresar un Mail valido<br>';
            $("#addMail").css("border", "1px solid #FF0000");
        } else {
            $("#addMail").css("border", "1px solid #d1d3e2");
        }
    }
    if (region == '0' || region == null) {
        msj = msj + '- Debe seleccionar una Región<br>';
        error = 1;
        $("#addRegion").css("border", "1px solid #FF0000");
    } else {
        $("#addRegion").css("border", "1px solid #d1d3e2");
    }

    if($("#addPerfil").val() != 10){
    if (comuna == '0' || comuna == null) {
        msj = msj + '- Debe seleccionar una Comuna<br>';
        error = 1;
        $("#addComuna").css("border", "1px solid #FF0000");
    } else {
        $("#addComuna").css("border", "1px solid #d1d3e2");
    }
    }
    

    if (institucion == '0' || institucion == null) {
        msj = msj + '- Debe seleccionar una Institución<br>';
        error = 1;
        $("#addInstituciones").css("border", "1px solid #FF0000");
    } else {
        $("#addInstituciones").css("border", "1px solid #d1d3e2");
    }
    if (perfil == '0' || perfil == null) {
        msj = msj + '- Debe seleccionar una Perfil<br>';
        error = 1;
        $("#addPerfil").css("border", "1px solid #FF0000");
    } else {
        $("#addPerfil").css("border", "1px solid #d1d3e2");
    }

    if (error == 1) {
        mensajeTemporalRespuestas(0, msj);
        return false;
    } else {
        return true;
    }
}

function limpiar_formulario() {
    $("#mensaje-agregar").css("display", "none");
    $("#id_usuario").val("");
    $('#nna_run').removeAttr('disabled');
    $('#addNombres').removeAttr('disabled');
    $('#addApePat').removeAttr('disabled');
    $('#addApeMat').removeAttr('disabled');
    $('#addRegion').removeAttr('disabled');
    $('#addComuna').removeAttr('disabled');
    comunas.length = 0;
    $('.listComuna').html('');
    $('#addRun').val('');
    $('#nna_run').val('');
    $('#addDV').val('');
    $('#addNombres').val('');
    $('#addApePat').val('');
    $('#addApeMat').val('');
    $('#addFono').val('');
    $('#addMail').val('');
    //INICIO CZ SPRINT 72 
    $('#clave').val('');
    //FIN CZ SPRINT 72 
    $('#addRegion').val(0);
    $('#addComuna').val(0);
    $('#addInstituciones').val(0);
    $('#addPerfil').val(0);
    //INICIO CZ SPRINT 72 
    $("#botonGuardar").prop("disabled", false);
    $('#addFono').prop("disabled", false);
    $('#addMail').prop("disabled", false);
    $('#addRegion').prop("disabled", false);
    $('#addComuna').prop("disabled", false);
    $('#addInstituciones').prop("disabled", false);
    $('#addPerfil').prop("disabled", false);
    //FIN CZ SPRINT 72 
    $("#checkVigente").prop("checked", true);
    //INICIO CZ SPRINT 72 
    $("#mensaje-SSO-SAN").css("display", "none");
    //FIN CZ SPRINT 72 
    $("#addRun").css("border", "1px solid #d1d3e2");
    $("#addDV").css("border", "1px solid #d1d3e2");
    $("#addNombres").css("border", "1px solid #d1d3e2");
    $("#addApePat").css("border", "1px solid #d1d3e2");
    $("#addApeMat").css("border", "1px solid #d1d3e2");
    $("#addFono").css("border", "1px solid #d1d3e2");
    $("#addMail").css("border", "1px solid #d1d3e2");
    $("#addRegion").css("border", "1px solid #d1d3e2");
    $("#addComuna").css("border", "1px solid #d1d3e2");
    $("#addInstituciones").css("border", "1px solid #d1d3e2");
    $("#addPerfil").css("border", "1px solid #d1d3e2");
    $("#row_comuna").css("display","flex");
    static_comuna = "";
    static_perfil = "";
}

function agregarUsuario() {
    limpiar_formulario();
    $("#titulo_modal").html("Agregar Usuario");
    $('#modalAgregarUsuario').modal();
    $("#boton_eliminarVigencia").css('display', 'none');
    $("#limpiarFormulario").css('display', 'initial');
}

function eliminarDiacriticos(texto) {
    return texto.normalize('NFD').replace(/[\u0300-\u036f]/g, "");
}

function eliminarCaracterEspeciales(texto) {
    return texto.replace(/[^a-zA-Z ]/g, "");
}

function getInstituciones() {
    let data = new Object();
    $.ajax({
        url: "{{ route('get.instituciones') }}",
        type: "GET",
        data: data
    }).done(function(resp) {
        //formulario agregar usuario
        $('#addInstituciones').html($('<option />', {
            text: 'Seleccione una Institucion',
            value: 0,
        }));
        for (var i = 0; i < resp.length; i += 1) {
            var id = resp[i].id_ins;
            var nom = resp[i].nom_ins;
            $('#addInstituciones').append($('<option />', {
                text: nom,
                value: id,
            }));
        }
        //formulario editar usuario
        $('#editInstituciones').html($('<option />', {
            text: 'Seleccione una Institucion',
            value: 0,
        }));
        for (var i = 0; i < resp.length; i += 1) {
            var id = resp[i].id_ins;
            var nom = resp[i].nom_ins;
            $('#editInstituciones').append($('<option />', {
                text: nom,
                value: id,
            }));
        }
    }).fail(function(obj) {
        console.log(obj);
        return false;
    });
}

function addInstitucion() {
    $('#nomInstitucion').val('');
    $('#modalAddInstitucion').modal();
}

function getComunas(datos = null) {
    let data = new Object();
    data.region = datos;
    $.ajax({
        url: "{{ route('get.comunas') }}",
        type: "GET",
        data: data,
    }).done(function(resp) {
        if (datos != null) {

            $('#addComuna').html($('<option />', {
                text: 'Seleccione una Comuna',
                value: 0,
            }));
            for (var i = 0; i < resp.length; i += 1) {
                $('#addComuna').append($('<option />', {
                    text: resp[i].com_nom,
                    value: resp[i].com_id,
                }));
            }
        } else {
            $('#opc_oln').html($('<option />', {
                text: 'Seleccione una Comuna',
                value: 0,
            }));
            for (var i = 0; i < resp.length; i += 1) {
                $('#opc_oln').append($('<option />', {
                    text: resp[i].com_nom,
                    value: resp[i].com_id,
                }));
            }
        }

        // desbloquearPantalla();
    }).fail(function(obj) {
        console.log(obj);
        return false;
    });
}

function getRegion() {
    let data = new Object();
    $.ajax({
        url: "{{ route('get.regiones') }}",
        type: "GET",
    }).done(function(resp) {
        $('#addRegion').html($('<option />', {
            text: 'Seleccione una Region',
            value: 0,
        }));
        for (var i = 0; i < resp.length; i += 1) {
            $('#editRegion').append($('<option />', {
                text: resp[i].reg_nom,
                value: resp[i].reg_cod,
            }));
        }
        for (var i = 0; i < resp.length; i += 1) {
            $('#addRegion').append($('<option />', {
                text: resp[i].reg_nom,
                value: resp[i].reg_cod,
            }));
        }
        desbloquearPantalla();
    }).fail(function(obj) {
        console.log(obj);
        return false;
    });
}

function buscarUsuarioSSO(rut) {
    let data = new Object();
    data.rut = rut;
    $.ajax({
        url: "{{ route('ver.sso') }}",
        type: "GET",
        data: data
    }).done(function(resp) {
        rut = rut.split("-");
        if (resp.respuesta.Cantidad == 1) {
            mensajeTemporalRespuestas(1, "Usuario ya se encuentra en el SSO");
            $("#addMail").val(resp.respuesta.Resultado.Usuario.Correo);
            // $("#addMail").prop( "disabled", true );
            buscarBaseDatos(rut[0]);
        } else if (resp.respuesta.Cantidad == 2) {
            $("#addMail").val(resp.respuesta.Resultado.Usuario[0].Correo);
            buscarBaseDatos(rut[0]);
        } else if (resp.respuesta.Cantidad == 0) {
            mensajeTemporalRespuestas(0, "Usuario no existe en el SSO");
            buscarBaseDatos(rut[0]);
        }
        desbloquearPantalla();
    }).fail(function(obj) {
        console.log(obj);
        return false;
    });

}

function buscarBaseDatos(run) {
    let data = new Object();
    data.run = run;
    $.ajax({
        url: "{{ route('get.usuario') }}",
        type: "GET",
        data: data
    }).done(function(resp) {
        var datos = JSON.parse(resp);
        console.log(datos);
        if (datos.length > 0) {
            $("#addInstituciones").prop("disabled", true);
            $('#addFono').prop("disabled", true);
            $('#addRegion').prop("disabled", true);
            $("#addComuna").prop("disabled", true);
            $('#addPerfil').prop("disabled", true);
            $('#hiddenPerfil').prop("disabled", true);
            $("#botonGuardar").prop("disabled", true);
            mensajeTemporalRespuestas(1, "Usuario registrado en el sistema");
            // $('#editRun').val(datos[0].run);
            // var dv = calculaDv(datos[0].run);
            // $('#editDV').val(dv);
            getComunas(datos[0].reg_cod);
            setTimeout(function() {

                $("#addInstituciones").val(datos[0].id_institucion);
                $('#addFono').val(datos[0].telefono);
                $('#addMail').val(datos[0].email);
                var region = "";
                if (datos[0].length > 1) {
                    region = "0" + datos[0].reg_id;
                } else {
            region = datos[0].reg_cod;
                }

            $('#addRegion').val(region);
                $("#addComuna").val(datos[0].com_id);
                $('#addPerfil').val(datos[0].id_perfil);
                $('#hiddenPerfil').val(datos[0].id_perfil);
                $("#mensaje-SSO-SAN").css("display", "block");
            }, 2000);


            if (datos[0].id_estado == 1) {
                $("#checkeditVigente").prop("checked", true);
            } else {
                $("#checkeditVigente").prop("checked", false);
            }

        } else {
            $("#mensaje-SSO-SAN").css("display", "none");
            $("#botonGuardar").prop("disabled", false);
            $("#addInstituciones").prop("disabled", false);
            $('#addFono').prop("disabled", false);
            $('#addRegion').prop("disabled", false);
            $("#addComuna").prop("disabled", false);
            $('#addPerfil').prop("disabled", false);
            $('#hiddenPerfil').prop("disabled", false);
            $('#addFono').val('');
            // $('#addMail').val('');
            $('#addRegion').val(0);
            $('#addComuna').val(0);
            $('#addInstituciones').val(0);
            $('#addPerfil').val(0);
            $("#checkVigente").prop("checked", true);
            $("#mensaje-SSO-SAN").css("display", "none");
            mensajeTemporalRespuestas(0, "Usuario no registrado en el sistema");
        }

    }).fail(function(obj) {
        console.log(obj);
        return false;
        desbloquearPantalla()
    });
}

// FUNCION PARA FILTRAR 
function procesarReporte() {
    let data = new Object();
    let resp = validarOpcion();

    if (!resp) {
        mensajeTemporalRespuestas(0, 'Seleccione la OLN para generar el reporte');
        return false;
    }

    bloquearPantalla();

    data.option = 2;

    $.ajax({

        url: "{{ route('reportes.usuarios.cargar') }}",
        type: "GET",
        data: data,
        timeout: 12000

    }).done(function(resp) {
        desbloquearPantalla();

        if (resp.estado == 1) {
            $("#reporte-contenido").html(resp.respuesta);

        } else if (resp.estado == 0) {
            let mensaje =
                "Ocurrio un error al momento de desplegar el reporte solicitado. Por favor intente nuevamente.";
            mensajeTemporalRespuestas(0, mensaje);

            return false;
        }
    }).fail(function(objeto, tipoError, errorHttp) {
        let cantidad_intentos = (recargar + 1);

        if (cantidad_intentos < 3) {
            procesarReporte(option, comunas, cantidad_intentos);

        } else {
            desbloquearPantalla();

            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
            // CZ SPRINT 76
            recargar = 0;
            // CZ SPRINT 76
            return false;
        }
    });

}

function validarOpcion() {

    $("#opc_oln").removeClass("is-invalid");

    $("#cbxPerfil").removeClass("is-invalid");

    let respuesta = true;

    let opc_oln = $('#opc_oln option:selected').val();

    let perfil = $('#cbxPerfil option:selected').val();

    if (opc_oln == "" || typeof opc_oln === "undefined" || opc_oln == '0') {
        respuesta = false;
        $("#opc_oln").addClass("is-invalid");

    }


    return respuesta;

}

function dgv(T)    //digito verificador
{  
      var M=0,S=1;
	  for(;T;T=Math.floor(T/10))
      S=(S+T%10*(9-M++%6))%11;
    return S?S-1:'k';
      
      alert(S?S-1:'k');
 }


let static_perfil = "";
let static_comuna = "";

function editarUsuario(id) {
    $('#addComuna').html('');
    var region = "";
    var com_id = $("#opc_oln").val();
    $("#titulo_modal").html("Editar Usuario");
    $("#boton_eliminarVigencia").css('display', 'initial');
    $("#limpiarFormulario").css('display', 'none');
    comunas.length = 0;
    limpiar_formulario();
    bloquearPantalla();
    $('#nna_run').attr('disabled','disabled');
    $('#addNombres').attr('disabled','disabled');
    $('#addApePat').attr('disabled','disabled');
    $('#addApeMat').attr('disabled','disabled');
    // $('#addRegion').attr('disabled','disabled');
    // $('#addComuna').attr('disabled','disabled');
    $('#id_usuario').val(id);
    let data = new Object();
    data.id = id;
    data.com_id = com_id;
    $('#editId').val(id);
    $.ajax({
        url: "{{ route('get.usuario') }}",
        type: "GET",
        data: data
    }).done(function(resp) {
        var datos = JSON.parse(resp);
        console.log(datos[0].run);
        $('#nna_run').val(datos[0].run+dgv(datos[0].run));
        console.log( $('#nna_run'));
        let value = $('#nna_run').val().replace(/\./g, '').replace('-', '');
  
        if (value.match(/^(\d{2})(\d{3}){2}(\w{1})$/)) {
            value = value.replace(/^(\d{2})(\d{3})(\d{3})(\w{1})$/, '$1.$2.$3-$4');
        }
        else if (value.match(/^(\d)(\d{3}){2}(\w{0,1})$/)) {
            value = value.replace(/^(\d)(\d{3})(\d{3})(\w{0,1})$/, '$1.$2.$3-$4');
        }
        else if (value.match(/^(\d)(\d{3})(\d{0,2})$/)) {
            value = value.replace(/^(\d)(\d{3})(\d{0,2})$/, '$1.$2.$3');
        }
        else if (value.match(/^(\d)(\d{0,2})$/)) {
            value = value.replace(/^(\d)(\d{0,2})$/, '$1.$2');
        }
        $('#nna_run').val(value);

        $('#addNombres').val(datos[0].nombres);
        $('#addApePat').val(datos[0].apellido_paterno);
        $('#addApeMat').val(datos[0].apellido_materno);
        $('#addFono').val(datos[0].telefono);
        $('#addMail').val(datos[0].email);
        region = datos[0].reg_cod;

        $('#addRegion').val(region);
      
        $('#addInstituciones').val(datos[0].id_institucion);
        static_perfil = datos[0].id_perfil
        $('#addPerfil').val(datos[0].id_perfil);
        $('#hiddenPerfil').val(datos[0].id_perfil);
        if (datos[0].id_estado == 1) {
            $("#checkVigente").prop("checked", true);
        } else {
            $("#checkVigente").prop("checked",false);
        }
           
        setTimeout(function(){ getComunas(region); }, 2000);
        setTimeout(function(){ getComunasUsuario(id, region); }, 3000);
        setTimeout(function(){ desbloquearPantalla(); }, 5000);
   
    }).fail(function(obj) {
        console.log(obj);
        return false;
    });

    
    $('#modalAgregarUsuario').modal();
 
}

function getComunasUsuario(idUsuario, region) {
    let data = new Object();
    data.id = idUsuario;
    data.region = region;
    $.ajax({
        url: "{{ route('get.comuna.usuario') }}",
        type: "GET",
        data: data
    }).done(function(resp) {
        var datos = JSON.parse(resp);
        if(datos.length > 0){
        static_comuna = $("#opc_oln").val();
        $("#addComuna").val($("#opc_oln").val());
        }
        //else{

        // }
        // // var com_nom = datos[0].com_nom;
        // // var com_id = datos[0].com_id;
        // // static_comuna = $("#opc_oln").val();
        // // $("#addComuna").val($("#opc_oln").val());
    }).fail(function(obj) {
        console.log(obj);
        return false;
    });
}

function agregarInstitucion(){
    var nomInst = $('#nomInstitucion').val();
    if(nomInst == ''){
        mensajeTemporalRespuestas(0, 'Ingrese una Institucion');
        $("#nomInstitucion").css("border","1px solid #FF0000");
    }else{
        let data = new Object();
        data.nomInst = nomInst;
        $.ajax({
            url: "{{ route('add.institucion') }}",
            type: "GET",
            data: data
        }).done(function(resp){
            if(resp.estado == 0){
                mensajeTemporalRespuestas(1, resp.mensaje);
                $('#modalAddInstitucion').modal('hide');
                getInstituciones();
            }else{
                mensajeTemporalRespuestas(0, resp.mensaje);
            }     			
        }).fail(function(obj){
            console.log(obj); return false;
        });
    }
}

function cambioPerfil(dato){
    if(dato == 10){
        $("#row_comuna").css("display","none");
    }else{
        $("#row_comuna").css("display","flex");
    }
}

</script>
@endsection
