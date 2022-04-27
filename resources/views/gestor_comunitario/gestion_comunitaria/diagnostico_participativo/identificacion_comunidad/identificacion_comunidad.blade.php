<div class="form-group">
<!-- inicio ch -->
    <!-- <div class="form-group row p-4"> -->
<!--         <label for="form_diag_fec_lev"><b>Fecha de Levantamiento:</b></label>
        <div class="col-sm-9"> -->
            <!-- @ if($diag_estado == 1) -->
<!--             <div class="input-group date-pick" id="form_diag_fec_lev" data-target-input="nearest">
                <input onkeypress='return caracteres_especiales_fecha(event)' type="text" class="form-control datetimepicker-input " data-target="#form_diag_fec_lev" onblur="registrarDataIdentComuna();"/>
                <div class="input-group-append" data-target="#form_diag_fec_lev" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
            <p id="val_frm_diag_fec_lev" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe registrar una Fecha de Ingreso</p> -->
            <!-- @ else -->
                <!-- <label id="ver_diag_fec_lev" for=""></label> -->
            <!-- @ endif -->
<!--         </div>
    </div> -->
<!-- fin ch -->
    <div class="card colapsable shadow-sm" id="contenedor_identificacion_com_pri">
        <a class="btn text-left p-0 collapsed" id="desplegar_identificacion_com_pri" data-toggle="collapse" data-target="#identificacion_com_pri" aria-expanded="false" aria-controls="identificacion_com_pri" onclick="if($(this).attr('aria-expanded') == 'false') getDataIdentComunidad(); representanteRut();">
            <div class="card-header p-3">
                <h5 class="mb-0">
                    <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
                    &nbsp;&nbsp;I. Identificación Comunidad Priorizada
                </h5>
            </div>
        </a>

        <div class="collapse" id="identificacion_com_pri">
            <div class="card-body">
                <br>
                @if($est_pro_id != config('constantes.plan_estrategico'))
                    @includeif('gestor_comunitario.gestion_comunitaria.diagnostico_participativo.identificacion_comunidad.identificacioncomunidadpriorizada')
                @else
                    @includeif('gestor_comunitario.gestion_comunitaria.diagnostico_participativo.identificacion_comunidad.comunidad_priorizada')
                @endif                
            </div>
        </div>
    </div>

    <div class="card colapsable shadow-sm" id="contenedor_organizaciones_fun_com">
        <a class="btn text-left p-0 collapsed" id="desplegar_organizaciones_fun_com" data-toggle="collapse" data-target="#organizaciones_fun_com" aria-expanded="false" aria-controls="organizaciones_fun_com" onclick="if($(this).attr('aria-expanded') == 'false') listarOrganizacionesFuncionales();">
            <div class="card-header p-3">
                <h5 class="mb-0">
                    <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
                    &nbsp;&nbsp;II. Organizaciones Funcionales Comunitarias
                </h5>
            </div>
        </a>

        <div class="collapse" id="organizaciones_fun_com">
            <div class="card-body">
                <br>
                @includeif('gestor_comunitario.gestion_comunitaria.diagnostico_participativo.identificacion_comunidad.organizacionesfuncionales')
            </div>
        </div>
    </div>

    <div class="card colapsable shadow-sm" id="contenedor_instituciones_serv">
        <a class="btn text-left p-0 collapsed" id="desplegar_instituciones_serv" data-toggle="collapse" data-target="#instituciones_serv" aria-expanded="false" aria-controls="instituciones_serv" onclick="if($(this).attr('aria-expanded') == 'false') listarInstitucionesServicios();">
            <div class="card-header p-3">
                <h5 class="mb-0">
                    <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
                    &nbsp;&nbsp;III. Instituciones y Servicios Presentes en la Comunidad
                </h5>
            </div>
        </a>

        <div class="collapse" id="instituciones_serv">
            <div class="card-body">
                <br>
                @includeif('gestor_comunitario.gestion_comunitaria.diagnostico_participativo.identificacion_comunidad.institucioneservicios')
            </div>
        </div>
    </div>

    <div class="card colapsable shadow-sm" id="contenedor_bienes_com_com">
        <a class="btn text-left p-0 collapsed" id="desplegar_bienes_com_com" data-toggle="collapse" data-target="#bienes_com_com" aria-expanded="false" aria-controls="bienes_com_com" onclick="if($(this).attr('aria-expanded') == 'false') listarBienesComunes();">
            <div class="card-header p-3">
                <h5 class="mb-0">
                    <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
                    &nbsp;&nbsp;IV. Bienes Comunes Comunitarios
                </h5>
            </div>
        </a>

        <div class="collapse" id="bienes_com_com">
            <div class="card-body">
                <br>
                @includeif('gestor_comunitario.gestion_comunitaria.diagnostico_participativo.identificacion_comunidad.bienes_comunitarios')
            </div>
        </div>
    </div>

    <div class="card colapsable shadow-sm" id="contenedor_factores_rie_factores_pro">
        <a class="btn text-left p-0 collapsed" id="desplegar_factores_rie_factores_pro" data-toggle="collapse" data-target="#factores_rie_factores_pro" aria-expanded="false" aria-controls="factores_rie_factores_pro" onclick="if($(this).attr('aria-expanded') == 'false') listarFactores();">
            <div class="card-header p-3">
                <h5 class="mb-0">
                    <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
                    &nbsp;&nbsp;V. Factores de Riesgo y Factores Protectores
                </h5>
            </div>
        </a>

        <div class="collapse" id="factores_rie_factores_pro">
            <div class="card-body">
                <br>
                @includeif('gestor_comunitario.gestion_comunitaria.diagnostico_participativo.identificacion_comunidad.factores_riesgo_protectores')	
            </div>
        </div>
    </div>

    @if (Session::get('perfil') == config('constantes.perfil_gestor_comunitario'))
        @foreach ($acciones as $accion)
            @if ($accion->cod_accion == "GCM22")
                <div class="text-center"> 
                    <button type="button" id="btn-ident-com-ges-com" disabled class="btn btn-success btnEtapa" onclick="{{ $accion->ruta }}" style="display:none">Ir a la siguiente etapa - <strong>{{ $accion->nombre }}</strong></button>
                    <!-- INICIO CZ SPRINT 55 -->
                    <button type="button" id="validar" class="btn btn-success validar-btnEtapa" onclick="validarData()">Ir a la siguiente etapa - <strong>{{ $accion->nombre }}</strong></button>
                    <!-- FIN CZ SPRINT 55 -->
                </div>
            @endif
        @endforeach
    @endif
</div>
<script type="text/javascript">
    function validarIdentComuna(){
        let com_pri = true;

        com_pri = validarFrmIdentificacion();

        return com_pri;
    }

    function registrarDataIdentComuna(){
         // INICIO CZ SPRINT 67
         let iden_com_pri = $("#iden_com_pri").val();
            if (iden_com_pri == "" || typeof iden_com_pri === "undefined"){
                $("#iden_com_pri").show();
                $("#iden_com_pri").addClass("is-invalid");
                alert("Debe ingresar la identificación de la comunidad priorizada")
                return false;
            }else{
                $("#iden_com_pri").removeClass("is-invalid");
            }
        // FIN CZ SPRINT 67
        if($("#hid_rut_val").val() != 0 || $("#hid_cor_val").val() != 0) return false;
        bloquearPantalla();

        let data = new Object();
        data = recolectarIdentComunidadPriorizada();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{route('identificacion.priorizada.registrar')}}",
            data: data
        }).done(function(resp){
            desbloquearPantalla();

            if(resp.estado == 1){
                mensajeTemporalRespuestas(1, resp.mensaje);
            
            }else if (resp.estado == 0){
                mensajeTemporalRespuestas(0, resp.mensaje);

            }
        }).fail(function(objeto, tipoError, errorHttp){            
            desbloquearPantalla();
            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
            return false;
        });
        // INICIO CZ SPRINT 55
        $('#info_com_pri').val($('#iden_com_pri').val());
        $('#inf_com_pri').val($('#iden_com_pri').val());
        // FIN CZ SPRINT 55
    }
        // INCIO CZ SPRINT 55
        function validarData(){
            console.log("aqui entro");
        if($("#iden_com_pri").val() == ""){
            alert("Debe ingresar comunidad priorizada para avanzar de etapa");
        }else{
            $("#btn-ident-com-ges-com").click();
            $("#validar").css("display","none");
            $("#btn-ident-com-ges-com").css("display","initial");
            $("#iden_com_pri").prop( "disabled", true );
            $("#btn-ident-com-ges-com").prop( "disabled", true );
        }
    }
    //FIN CZ SPRINT 55
</script> 
