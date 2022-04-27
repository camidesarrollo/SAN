{{ csrf_field() }}
<div class="form-group">
    <table class="table table-striped table-hover w-100" cellspacing="0" id="tabla_linea_base">
        <thead>
            <tr>
                <th>RUT</th>
                <th>Nombre</th>
                <th>Edad</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>Acciones</th>
                <th>Descargar</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table><br>	
    <!-- INICIO CZ SPRINT 70 -->
    @if($flag_linea == 1)
    <button type="button" class="btn btn-outline-success btnAgregarLB" data-toggle="modal" data-target="#frmlineabase"
        onclick="limpiarfrmIdentificacionLB();limpiarfrmValidadiones();listarPreguntas(0);"><i
            class="fa fa-plus-circle"></i> Agregar Linea Base</button>
    <a class="btn btn-success btnExcelLB" href="{{route('reporte.lineabase').'/'.$pro_an_id.'/1' }}"><i
            class="fa fa-download"></i>Descargar Linea Base</a>
    @elseif($flag_linea == 2)
    <button type="button" class="btn btn-outline-success btnAgregarLB" data-toggle="modal"
        data-target="#frmlineabase_2021"
        onclick="limpiarfrmIdentificacionLineaBase_2021();limpiarfrmValidadiones_2021();listarPreguntas_2021(0);"><i
            class="fa fa-plus-circle"></i> Agregar Linea Base</button>
    <a class="btn btn-success btnExcelLB" href="{{route('reporte.lineabase_2021').'/'.$pro_an_id.'/1' }}"><i
            class="fa fa-download"></i>Descargar Linea Base</a>
    @endif
    <!-- FIN CZ SPRINT 70 -->
</div>
 <!-- INICIO CZ SPRINT 70 -->
@if($flag_linea == 1)
@includeif('gestor_comunitario.gestion_comunitaria.diagnostico_participativo.linea_base_gc.modal_linea_base')
@elseif($flag_linea == 2)
@includeif('gestor_comunitario.gestion_comunitaria.diagnostico_participativo.linea_base_gc.linea_base_2021.modal_linea_base_2021')
@endif 
 <!-- FIN CZ SPRINT 70 -->
<input id="tipo_linea" type="hidden" value="">
<input id="lin_bas_id" type="hidden" value="">
<input type="hidden" id="_token" value="{{ csrf_token() }}">
<input id="accion" type="hidden" value="0">
<style type="text/css">
/* // INICIO CZ SPRINT 70 */
	.datatable_encabezado_lb{
		background-color: #e6f3fd;
    	text-align: center;
    	font-weight: 800;
    	text-transform: uppercase;
    	padding: 6px 0;
	}
/* // FIN CZ SPRINT 70 */
</style>
<!-- INICIO CZ SPRINT 62 -->
<style>
@media (max-width: 1145px) {
	#derecho_participacion{
        overflow-y: scroll;
    }

    #contenedorGestionComunitaria{
        overflow-y: scroll;
    }

    #titulo_derecho_part_nna{
        font-size: 1rem !important;
    }

    #titulo_organizacion_comunitaria{
        font-size: 1.10rem  !important;
    }

    #titulo_derecho_part_nnaPantallaChica {}

    }
    
@media (max-width: 861px) {
    #titulo_derecho_part_nna{
        display:none !important;
    }

    #titulo_derecho_part_nnaPantallaChica{
        display:block !important;
    }
    
}

@media (max-width: 991px) {
    #titulo_derecho_part_nna{
        display:none !important;
    }

    #titulo_derecho_part_nnaPantallaChica{
        display:block !important;
    }

    #titulo_derecho_part_nnaPantallaChica{
        font-size: 1.10rem  !important;
    }
    
}

@media (max-width: 360px) {
    #titulo_derecho_part_nna{
        display:none !important;
    }

    #titulo_derecho_part_nnaPantallaChica{
        display:block !important;
    }

    #titulo_derecho_part_nnaPantallaChica{
        font-size: 1rem  !important;
    }
    
}

360
</style>
<!-- FIN CZ SPRINT 62 -->
<script type="text/javascript">
    let respuestaPreguntas = new Array();

    function listarPreguntas(opcion,id=''){

        $("#lin_bas_id").val(id);
        $("#accion").val(opcion);

        respuestaPreguntas.length = 0;
        $("#identificacion").collapse('hide');
        $("#servicio_prestaciones").collapse('hide');
        $("#organizacion_comunitaria").collapse('hide');
        $("#derecho_part_nna").collapse('hide');
    $("#continuidad_proyecto_2021").collapse('hide');
        listaPreServicios();
        listaPreProgramas();
        listaPreServicios2();
        listaPreBienes();
        listaPreOrganizaciones();
        listaPreParticipacion();

    $('#linea_rut_linea_base').rut({
			fn_error: function(input){
				if (input.val() != ''){
                $('#linea_rut_linea_base').attr("data-val-run", false);
                    mensajeTemporalRespuestas(0, "* RUN Inválido.");
					$("#val_linea_rut").show();
				}
			},
			fn_validado: function(input){
            $('#linea_rut_linea_base').attr("data-val-run", true);
				$("#val_linea_rut").hide();
                autoCompletarNombre();

			}
		});
    }

    function descargarLineaBase(id){
        window.open( `/descargarLineaBase/${id}`, '_blank');
    }

    function agregarRepuestaLineaBase(tipo, id, opcion = ''){
            
        respuestaPreguntas[opcion+id]          = Object();
        respuestaPreguntas[opcion+id].id        = id;
        respuestaPreguntas[opcion+id].tipo     = tipo;
        if($("#preg1_"+opcion+id).prop('checked')){
            respuestaPreguntas[opcion+id].resp1  = 1;
        }else{
            respuestaPreguntas[opcion+id].resp1  = 0;
        }

        if($("#preg2_"+opcion+id).prop('checked')){
            respuestaPreguntas[opcion+id].resp2  = 1;
        }else{
            respuestaPreguntas[opcion+id].resp2  = 0;
        }

        if(tipo == 4){
            if($("#preg3_"+id).prop('checked')){
                respuestaPreguntas[id].resp3  = 1;
            }else{
                respuestaPreguntas[id].resp3  = 0;
            }
        }else{
            respuestaPreguntas[opcion+id].resp3  = 0;
        }        


    }


    function recolectarSelLineaBase(){

        let data = new Object();

        data.preguntas = respuestaPreguntas;
        data.ser_niv_com    = $("#ser_niv_com").val();
        data.ser_pro_soc    = $("#ser_pro_soc").val();
        data.ser_ser_sec    = $("#ser_ser_sec").val();
        data.bie_com        = $("#bie_com").val();
        data.bien_org_otr   = $("#bien_org_otr").val();
        data.bien_org_part  = $("#bien_org_part").val();
        
        return data;
    }

    function guardarLineaBase(){

        let respuesta = validarfrmIdentificacionLB();
        if(!respuesta){
            $("#identificacion").collapse('show');
            $("#servicio_prestaciones").collapse('hide');
            $("#organizacion_comunitaria").collapse('hide');
            $("#derecho_part_nna").collapse('hide');
            mensaje = "Faltaron Campos Por Responder";
            mensajeTemporalRespuestas(0, mensaje);
            return false;
        }

        respuesta = verificarfrmDerechoParticipacion();
        if(!respuesta){
            $("#derecho_part_nna").collapse('show');
            $("#identificacion").collapse('hide');
            $("#servicio_prestaciones").collapse('hide');
            $("#organizacion_comunitaria").collapse('hide');
            mensaje = "Completar Derechos y Participacion NNA";
            mensajeTemporalRespuestas(0, mensaje);
            return false;
        }

        bloquearPantalla();

        let data = new Object();

        data.lin_bas_id = $("#lin_bas_id").val();
        data.iden       = recolectarDataIdentificacionLB();
        data.preg       = recolectarSelLineaBase();
        data.part       = recolectarfrmDerechoParticipacion();
        data.pro_an_id  = {{$pro_an_id}};
        
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        $.ajax({
            type: "POST",
            url: "{{route('guardar.linea.base')}}",
            data: data
        }).done(function(resp){
            
            if(resp.estado == 1){
                mensajeTemporalRespuestas(1, resp.mensaje);
                //borre una alerta que estaba aquí - fin ch
                listarLineaBase(); 
                //$('#tabla_linea_base').DataTable().ajax.reload();
            }

            if(resp.estado == 0){
                mensajeTemporalRespuestas(0, resp.mensaje);
            }
            $('#frmlineabase').modal('hide');
            desbloquearPantalla();

        }).fail(function(objeto, tipoError, errorHttp){
                desbloquearPantalla();

                manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

                return false;
        });

    }

    function eliminarLineaBase(id){

        let confirmacion = confirm("¿Esta seguro que desea eliminar el registro?");
		
		if (confirmacion == false) return false;

        let data = new Object();
        data.id = id;
        bloquearPantalla();
        $.ajax({
            type: "GET",
            url: "{{route('eliminar.linea.base')}}",
            data: data
        }).done(function(resp){

            if(resp.estado == 1){
                mensajeTemporalRespuestas(0, resp.mensaje);
                $('#tabla_linea_base').DataTable().ajax.reload();
            }

            if(resp.estado == 0){
                mensajeTemporalRespuestas(0, resp.mensaje);
            }
            desbloquearPantalla();
        }).fail(function(objeto, tipoError, errorHttp){
                desbloquearPantalla();

                manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

                return false;
        });
    }

    function editarLineaBase(id){
        $("#btn_lb_guardar").hide();
        listarPreguntas(1,id);
        getDataIdentificacion(id);
        $('#frmlineabase').modal('show');
    }
// //INICIO DC
    function calculaEdad(fnac){
    	let birth_year = fnac.substr(0,4);
    	let birth_month = fnac.substr(4,2);
    	let birth_day = fnac.substr(6,2);
    	today_date = new Date();
          today_year = today_date.getFullYear();
          today_month = today_date.getMonth();
          today_day = today_date.getDate();
          age = today_year - birth_year;

          if (today_month < (birth_month - 1)) {
            age--;
          }
          if (((birth_month - 1) == today_month) && (today_day < birth_day)) {
            age--;
          }
          return age;
    }
// //FIN DC

    function validarRut(){
    let rut_encontrado = false;
    $("#tabla_linea_base").find("tbody").find("td").find("div.rut_linea").each(function(){
        if($(this).text() == $("#linea_rut_linea_base").val()){
                mensaje = "El rut ya se encuentra en la linea base";
                mensajeTemporalRespuestas(0, mensaje);
                $("#linea_rut_linea_base").val("");
            rut_encontrado = true;
        }
    });
        return rut_encontrado;
    }
    function autoCompletarNombre(){
		let respuesta 	= "";
    let run = $("#linea_rut_linea_base").val();
    let rut_encontrado = validarRut();
    if(rut_encontrado == false){
        if (rutEsValido(run)){
        	obtenerInformacionRunificador(run).then(function (data){
        		if (data.estado == 1){
                    $("#linea_nom_linea_base").val(data.respuesta.Nombres + ' ' + data.respuesta.ApellidoPaterno + ' ' + data
                        .respuesta.ApellidoMaterno);
					//INICIO DC
					let edad = calculaEdad(data.respuesta.FechaNacimiento);
                    $('#linea_edad_linea_base').val(edad);
					//FIN DC
        		}else if (data.estado == 0){
        			console.log(data.mensaje);

        		}
                if (data.respuesta.Sexo == "FEMENINO") {
                    $("#linea_sexo_linea_base").val(1);
                } else {
                    $("#linea_sexo_linea_base").val(0);
                }
        	}).catch(function (error){
        		console.log(error);
        	});
        }
	}

}

function editarLineaBase_2021(id) {
    listarPreguntas_2021(1, id);
    getDataIdentificacion_2021(id);
    getOtro_2021(id);
    $("#btn_lb_guardar").hide();
    $('#frmlineabase_2021').modal('show');
}

function getOtro_2021(id){
    let data = new Object();

    data.id = id;
    data.tipo_line_base = 1;
    data.lin_bas_id = $("#lin_bas_id").val();
	data.pro_an_id 	= {{$pro_an_id}};
    $.ajax({
        type: "GET",
        url: "{{route('obtener.otro_2021')}}",
        data: data
    }).done(function(resp){
        if(resp.otro.length > 0){
            for(var i = 0; i < resp.otro.length; i++){
                if(resp.otro[i].otro_tipo == '2.1'){
                    $("#ser_niv_com_linea_base").val(resp.otro[i].otro_descripcion);
                }
                
                if (resp.otro[i].otro_tipo == '2.2'){
                    $("#ser_pro_soc_linea_base").val(resp.otro[i].otro_descripcion);
                }
                
                if(resp.otro[i].otro_tipo == '3.1'){
                    $("#ser_ser_sec_linea_base").val(resp.otro[i].otro_descripcion);
                }
                
                if(resp.otro[i].otro_tipo == '3.2'){
                    $("#bien_org_otr_linea_base").val(resp.otro[1].otro_descripcion);
                }
            }
        }else{
            $("#ser_niv_com_linea_base").val("");
            $("#ser_pro_soc_linea_base").val("");
            $("#ser_ser_sec_linea_base").val("");
            $("#bien_org_otr_linea_base").val("");
        }
    }).fail(function(objeto, tipoError, errorHttp){

            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

            return false;
    });
}
function eliminarLineaBase_2021(id) {

    let confirmacion = confirm("¿Esta seguro que desea eliminar el registro?");

    if (confirmacion == false) return false;

    let data = new Object();
    data.id = id;
    bloquearPantalla();
    $.ajax({
        type: "GET",
        url: "{{route('eliminar.linea.base_2021')}}",
        data: data
    }).done(function(resp) {

        if (resp.estado == 1) {
            mensajeTemporalRespuestas(0, resp.mensaje);
            $('#tabla_linea_base').DataTable().ajax.reload();
        }

        if (resp.estado == 0) {
            mensajeTemporalRespuestas(0, resp.mensaje);
        }
        desbloquearPantalla();
    }).fail(function(objeto, tipoError, errorHttp) {
        desbloquearPantalla();

        manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

        return false;
    });
}
function guardarLineaBase_2021() {
    let respuesta = validarfrmIdentificacionLB_2021();
    if (!respuesta) {
        $("#identificacion").collapse('show');
        $("#servicio_prestaciones").collapse('hide');
        $("#recursos_comunidad_2021").collapse('hide');
        $("#derecho_part_nna").collapse('hide');
        $("#continuidad_proyecto_2021").collapse('hide');
        mensaje = "Faltaron Campos Por Responder";
        mensajeTemporalRespuestas(0, mensaje);
        return false;

    }

    respuesta = verificarfrmDerechoParticipacion_2021();
    if (!respuesta) {
        $("#derecho_part_nna").collapse('show');
        $("#identificacion").collapse('hide');
        $("#servicio_prestaciones").collapse('hide');
        $("#recursos_comunidad_2021").collapse('hide');
        $("#continuidad_proyecto_2021").collapse('hide');
        mensaje = "Completar Derechos y Participacion NNA";
        mensajeTemporalRespuestas(0, mensaje);
        return false;
    }


    respuesta = verificarfrmContinuidadProyecto()
    if (!respuesta) {
        $("#continuidad_proyecto_2021").collapse('show');
        $("#derecho_part_nna").collapse('hide');
        $("#identificacion").collapse('hide');
        $("#servicio_prestaciones").collapse('hide');
        $("#recursos_comunidad_2021").collapse('hide');
        $("#continuidad_proyecto_2021").collapse('hide');
        mensaje = "Completar la Continuidad del Proyecto";
        mensajeTemporalRespuestas(0, mensaje);
        return false;
    }
    var mensaje = verificar_fecha();
    if(mensaje !=  ""){
        mensajeTemporalRespuestas(0, mensaje);
        return false;
    }
    bloquearPantalla();

    let data = new Object();

    data.lin_bas_id = $("#lin_bas_id").val();
    data.iden = recolectarDataIdentificacionLB_2021();
    data.preg = recolectarLineaBase_2021();
    data.part = recolectarfrmDerechoParticipacion_2021();
    data.cont = recolectarfrmContinuidadProyecto();
    console.log(data.cont);
    otros = new Array();
    otros[0] = $("#ser_niv_com_linea_base").val();
    otros[1] = $("#ser_pro_soc_linea_base").val();
    otros[2] = $("#ser_ser_sec_linea_base").val();
    otros[3] = $("#bien_org_otr_linea_base").val();
    data.otros = otros;
    data.pro_an_id = {{$pro_an_id}};
    data.tipo_line_base = $('#tipo_linea').val();  
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: "POST",
        url: "{{route('guardar.linea.base_2021')}}",
        data: data
    }).done(function(resp) {

        if (resp.estado == 1) {
            mensajeTemporalRespuestas(1, resp.mensaje);
            //borre una alerta que estaba aquí - fin ch
            listarLineaBase();
            //$('#tabla_linea_base').DataTable().ajax.reload();
            respuestaPreguntasLineaBase_2021 = [];
        }

        if (resp.estado == 0) {
            mensajeTemporalRespuestas(0, resp.mensaje);
        }
        $('#frmlineabase_2021').modal('hide');
        desbloquearPantalla();

    }).fail(function(objeto, tipoError, errorHttp) {
        desbloquearPantalla();

        manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

        return false;
    });
}
function verificar_fecha(){
    let respuestaPreguntas = new Array();
    var mensaje = "";
    for(var i = 0; i <respuestaPreguntasLineaBase_2021.length; i++){
        if(respuestaPreguntasLineaBase_2021[i].expire != "" && respuestaPreguntasLineaBase_2021[i].expire != 'N/R' ){
            var fecha =  respuestaPreguntasLineaBase_2021[i].expire.split('/');
            var mes = parseInt(fecha[0]);
            var agno = parseInt(fecha[1]);
            console.log(agno);
            var today = new Date();
            var year = today.getFullYear();
            
            if(agno > year){
                return mensaje = "Error en formato fecha: El año debe ser menor o igual a al año actual";
            }else if(agno < 1920){
                return mensaje = "Error en formato fecha: El año debe ser mayor a lo ingresado"
            }
        }
    }
    return mensaje
}
function recolectarLineaBase_2021(){
    let data = new Object();

    data.preguntas = respuestaPreguntasLineaBase_2021;
    return data;
}
let respuestaPreguntasLineaBase_2021 = new Array();
// CZ SPRINT 76
function agregarRepuestaLineaBase_2021(tipo, id, opcion = '',tipoTabla) {
    let index  = respuestaPreguntasLineaBase_2021.findIndex(x => x.id === id);
    if(index == -1){
        respuesta_2021 = Object();
        respuesta_2021.id = id; //id de la pregunta
        respuesta_2021.tipo = tipo; //columna de respuesta
        respuesta_2021.opcion = opcion;
        respuesta_2021.tipoTabla = tipoTabla; //tipo tabla
     // CZ SPRINT 76
        if(opcion == 'check'){
            if($('#no_recuerda_'+id+'_' +tipoTabla).is(":checked")){
                respuesta_2021.expire = "N/R";
                
                $("#expire_"+id+'_'+tipoTabla).val("");
            }else{
                respuesta_2021.expire = $("#expire_"+id+'_'+tipoTabla).val();
                $( "#no_recuerda_"+id+'_'+tipoTabla).prop( "checked", false );
            }
               
        }else{
            if($('#no_recuerda_'+id+'_' +tipoTabla ).is(":checked")){
                respuesta_2021.expire = "N/R";
                $("#expire_"+id+'_'+tipoTabla).val("");
            }else{
        respuesta_2021.expire = $("#expire_"+id+'_'+tipoTabla).val();
                $( "#no_recuerda_"+id+'_'+tipoTabla ).prop( "checked", false );
            }
        }
        // CZ SPRINT 76
        if(tipoTabla == 1){
            // 
            if($("#sp_preg_" + id + '_' + 1).prop('checked')){
                respuesta_2021.resp1 = 1;
            }else{
                respuesta_2021.resp1 = 0;
            }
            if($("#sp_preg_" + id + '_' + 2).prop('checked')){
                respuesta_2021.resp2 = 1;
            }else{
                respuesta_2021.resp2 = 0;
            }
            if($("#sp_preg_" + id + '_' + 3).prop('checked')){
                respuesta_2021.resp3= 1;
            }else{
                respuesta_2021.resp3= 0;
            }
        }else if(tipoTabla == 2){

            if($("#preg_" + id + '_' + 1).prop('checked')){
                respuesta_2021.resp1 = 1;
            }else{
                respuesta_2021.resp1 = 0;
            }
            if($("#preg_" + id + '_' + 2).prop('checked')){
                respuesta_2021.resp2 = 1;
            }else{
                respuesta_2021.resp2 = 0;
            }
        }else if(tipoTabla == 3){
            if ($("#org_" + id + '_' + 1).prop('checked')) {
                console.log("entre aca");
                respuesta_2021.resp1 = 1;
            } else {
                respuesta_2021.resp1 = 0;
            }
            if ($("#org_" + id + '_' + 2).prop('checked')) {
                console.log("entre aca2");
                respuesta_2021.resp2 = 1;
            } else {
                respuesta_2021.resp2 = 0;
            }
            if ($("#org_" + id + '_' + 3).prop('checked')) {
                console.log("entre aca3");
                respuesta_2021.resp3 = 1;
            } else {
                respuesta_2021.resp3 = 0;
            }
            if ($("#org_" + id + '_' + 5).prop('checked')) {
                console.log("entre aca4");   
                respuesta_2021.resp4 = 1;
            } else {
                respuesta_2021.resp4 = 0;
            }
        }else if(tipoTabla == 4){
            if ($("#org_org_" + id + '_' + 1).prop('checked')) {
                respuesta_2021.resp1 = 1;
            } else {
                respuesta_2021.resp1 = 0;
            }
            if ($("#org_org_" + id + '_' + 2).prop('checked')) {
                respuesta_2021.resp2 = 1;
            } else {
                respuesta_2021.resp2 = 0;
            }
            if ($("#org_org_" + id + '_' + 3).prop('checked')) {
                respuesta_2021.resp3 = 1;
            } else {
                respuesta_2021.resp3 = 0;
            }
            if ($("#org_org_" + id + '_' + 4).prop('checked')) {
                respuesta_2021.resp4 = 1;
            } else {
                respuesta_2021.resp4 = 0;
            }
            if ($("#org_org_" + id + '_' + 5).prop('checked')) {
                respuesta_2021.resp5 = 1;
            } else {
                respuesta_2021.resp5 = 0;
            }
        }
        respuestaPreguntasLineaBase_2021.push(respuesta_2021);    
    }else{
        respuestaPreguntasLineaBase_2021[index].expire = $("#expire_"+id+'_'+tipoTabla).val();
        // CZ SPRINT 76
        if(opcion == 'check'){
            if($('#no_recuerda_'+id+'_' +tipoTabla).is(":checked")){
                respuestaPreguntasLineaBase_2021[index].expire = "N/R";
                
                $("#expire_"+id+'_'+tipoTabla).val("");
            }else{
                respuestaPreguntasLineaBase_2021[index].expire = $("#expire_"+id+'_'+tipoTabla).val();
                $( "#no_recuerda_"+id+'_'+tipoTabla).prop( "checked", false );
            }
               
        }else{
            if($("#expire_"+id+'_'+tipoTabla).val() != ""){
                $( "#no_recuerda_"+id+'_'+tipoTabla ).prop( "checked", false );
                    respuestaPreguntasLineaBase_2021[index].expire = $("#expire_"+id+'_'+tipoTabla).val();
            }else{
                respuestaPreguntasLineaBase_2021[index].expire = "N/R";
                $("#expire_"+id+'_'+tipoTabla).val("");
            }
        }
        // CZ SPRINT 76
        if(tipoTabla == 1){
            if($("#sp_preg_" + id + '_' + 1).prop('checked')){
                 respuestaPreguntasLineaBase_2021[index].resp1 = 1;
            }else{
                respuestaPreguntasLineaBase_2021[index].resp1 = 0;
            }
            if($("#sp_preg_" + id + '_' + 2).prop('checked')){
                respuestaPreguntasLineaBase_2021[index].resp2 = 1;
            }else{
                respuestaPreguntasLineaBase_2021[index].resp2 = 0;
            }
            if($("#sp_preg_" + id + '_' + 3).prop('checked')){
                respuestaPreguntasLineaBase_2021[index].resp3= 1;
            }else{
                respuestaPreguntasLineaBase_2021[index].resp3= 0;
            }
        }else if(tipoTabla == 2){
            if($("#preg_" + id + '_' + 1).prop('checked')){
                respuestaPreguntasLineaBase_2021[index].resp1 = 1;
            }else{
                respuestaPreguntasLineaBase_2021[index].resp1 = 0;
            }
            if($("#preg_" + id + '_' + 2).prop('checked')){
                respuestaPreguntasLineaBase_2021[index].resp2 = 1;
            }else{
                respuestaPreguntasLineaBase_2021[index].resp2 = 0;
            }
        }else if(tipoTabla == 3){
            if ($("#org_" + id + '_' + 1).prop('checked')) {
                respuestaPreguntasLineaBase_2021[index].resp1 = 1;
            } else {
                respuestaPreguntasLineaBase_2021[index].resp1 = 0;
            }
            if ($("#org_" + id + '_' + 2).prop('checked')) {
                respuestaPreguntasLineaBase_2021[index].resp2 = 1;
            } else {
                respuestaPreguntasLineaBase_2021[index].resp2 = 0;
            }
            if ($("#org_" + id + '_' + 3).prop('checked')) {
                respuestaPreguntasLineaBase_2021[index].resp3 = 1;
            } else {
                respuestaPreguntasLineaBase_2021[index].resp3 = 0;
            }
            if ($("#org_" + id + '_' + 5).prop('checked')) {
                respuestaPreguntasLineaBase_2021[index].resp4 = 1;
            } else {
                respuestaPreguntasLineaBase_2021[index].resp4 = 0;
            }
        }else if(tipoTabla == 4){
            if ($("#org_org_" + id + '_' + 1).prop('checked')) {
                respuestaPreguntasLineaBase_2021[index].resp1 = 1;
            } else {
                respuestaPreguntasLineaBase_2021[index].resp1 = 0;
            }
            if ($("#org_org_" + id + '_' + 2).prop('checked')) {
                respuestaPreguntasLineaBase_2021[index].resp2 = 1;
            } else {
                respuestaPreguntasLineaBase_2021[index].resp2 = 0;
            }
            if ($("#org_org_" + id + '_' + 3).prop('checked')) {
                respuestaPreguntasLineaBase_2021[index].resp3 = 1;
            } else {
                respuestaPreguntasLineaBase_2021[index].resp3 = 0;
            }
            if ($("#org_org_" + id + '_' + 4).prop('checked')) {
                respuestaPreguntasLineaBase_2021[index].resp4 = 1;
            } else {
                respuestaPreguntasLineaBase_2021[index].resp4 = 0;
            }
            if ($("#org_org_" + id + '_' + 5).prop('checked')) {
                respuestaPreguntasLineaBase_2021[index].resp5 = 1;
            } else {
                respuestaPreguntasLineaBase_2021[index].resp5 = 0;
            }
        }
    }
}
function descargarLineaBase_2021(id) {
    var tipoLinea = $("#tipo_linea").val();
    var pro_an_id =  {{$pro_an_id}}
    window.open(`/descargarLineaBase_2021/${id}/${tipoLinea}/${pro_an_id}`, '_blank');
}
function listarLineaBase() {

    let tabla_linea_base = $('#tabla_linea_base').DataTable();

    tabla_linea_base.clear().destroy(); //ch

    let data = new Object();
    data.pro_an_id = {{$pro_an_id}};

    @if($flag_linea == 1)
    tabla_linea_base = $('#tabla_linea_base').DataTable({
        "language": {
            "url": "{{ route('index') }}/js/dataTables.spanish.json"
        },
        "ordering": false,
        "lengthChange": false,
        "info": false,
        // INICIO CZ SPRINT 67
        "searching": true,
        // FIN CZ SPRINT 67
        "paging": false,
        "ajax": {
            "url": "{{ route('listar.linea.base') }}",
            "type": "GET",
            "data": data
        },
        "columnDefs": [{ //RUT
                "targets": 0,
                "className": 'dt-head-center dt-body-center',
                "createdCell": function(td, cellData, rowData, row, col) {
                    $(td).css("vertical-align", "middle");

                }
            },
            { //NOMBRES
                "targets": 1,
                "className": 'dt-head-center dt-body-left',
                "createdCell": function(td, cellData, rowData, row, col) {
                    $(td).css("vertical-align", "middle");

                }
            },
            { //EDAD
                "targets": 2,
                "className": 'dt-head-center dt-body-left',
                "createdCell": function(td, cellData, rowData, row, col) {
                    $(td).css("vertical-align", "middle");

                }
            },
            { //TELEFONO
                "targets": 3,
                "className": 'dt-head-center dt-body-left',
                "createdCell": function(td, cellData, rowData, row, col) {
                    $(td).css("vertical-align", "middle");

                }
            },
            { //CORREO
                "targets": 4,
                "className": 'dt-head-center dt-body-left',
                "createdCell": function(td, cellData, rowData, row, col) {
                    $(td).css("vertical-align", "middle");

                }
            },
            { //ACCIONES
                "targets": 5,
                "className": 'dt-head-center dt-body-left',
                "createdCell": function(td, cellData, rowData, row, col) {
                    $(td).css("vertical-align", "middle");

                }
            },
            { //DESCARGAR inicio ch
                "targets": 6,
                "className": 'dt-head-center dt-body-left',
                "createdCell": function(td, cellData, rowData, row, col) {
                    $(td).css("vertical-align", "middle");

                }
            } //fin ch
        ],
        "columns": [{ //RUT
                "data": "lin_bas_rut",
                "className": "text-center"
            },
            { //NOMBRES
                "data": "lin_bas_nom",
                "className": "text-center"
            },
            { //EDAD
                "data": "lin_bas_eda",
                "className": "text-center"
            },
            { //TELEFONO
                "data": "lin_bas_tel",
                "className": "text-center",
                "render": function(data, type, row) {
                    if(data == ''  || data == null){
                        return 'Sin información';
                    }else{
                        return data;
                    }
                    
                }
            },
            { //CORREO
                "data": "lin_bas_cor",
                "className": "text-center",
                "render": function(data, type, row) {
                    if(data == ''  || data == null){
                        return 'Sin información';
                    }else{
                        return data;
                    }
                    
                }
            },
            { //ACCIONES
                "data": "lin_bas_id",
                "className": "text-center",
                "render": function(data, type, row) {
                    //INICIO DC SPRINT 67
                    let html =
                        '<button type="button" class="btn btn-primary" onclick="editarLineaBase(' +
                        data + ');limpiarfrmValidadiones();"><b>Editar</b></button>';
                    html +=
                        ' <button type="button" class="btn btn-danger" onclick="eliminarLineaBase(' +
                        data + ')"><i class=""></i>  <b>Eliminar</b></button>';
                    //FIN DC SPRINT 67
                    //INICIO CZ SPRINT 67 correccion
                    if ($("#est_pro_id").val() == {{config('constantes.finalizado')}} || $("#est_pro_id").val() == {{config('constantes.desestimado')}}) {
                        $('.btn-danger').attr('disabled', 'disabled');
                    }
                    //FIN CZ SPRINT 67 correccion
                    return html;
                }
            },
            { //Descargar INICIO CH
                "data": "lin_bas_id",
                "className": "text-center",
                "render": function(data, type, row) {

                    @if($flag_linea == 1)
                    let html =
                        '<button type="button" class="btn btn-primary" onclick="descargarLineaBase(' +
                        data +
                        ');limpiarfrmValidadiones();"><i class="fa fa-download"></i><b>Descargar</b></button>';

                    @elseif($flag_linea == 2)
                    let html =
                        '<button type="button" class="btn btn-primary" onclick="descargarLineaBase_2021(' +
                        data +
                        ');limpiarfrmValidadiones_2021();"><i class="fa fa-download"></i><b>Descargar</b></button>';
                    @endif
                    return html;
                }
            } // FIN CH
        ]
    });
    @elseif($flag_linea == 2)
        tabla_linea_base = $('#tabla_linea_base').DataTable({
            "language": {
                "url": "{{ route('index') }}/js/dataTables.spanish.json"
            },
            "ordering": false,
            "lengthChange": false,
            "info": false,
            // INICIO CZ SPRINT 67
            "searching": true,
            // FIN CZ SPRINT 67
            "paging": false,
            "ajax": {
                "url": "{{ route('listar.linea.base_2021') }}",
                "type": "GET",
                "data": data
            },
            "columnDefs": [{ //RUT
                    "targets": 0,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function(td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");

                    }
                },
                { //NOMBRES
                    "targets": 1,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function(td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");

                    }
                },
                { //EDAD
                    "targets": 2,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function(td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");

                    }
                },
                { //TELEFONO
                    "targets": 3,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function(td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");

                    }
                },
                { //CORREO
                    "targets": 4,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function(td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");

                    }
                },
                { //ACCIONES
                    "targets": 5,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function(td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");

                    }
                },
                { //DESCARGAR inicio ch
                    "targets": 6,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function(td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");

                    }
                } //fin ch
            ],
            "columns": [{ //RUT
                    "data": "iden_run",
                    "className": "text-center", 
                    "render": function(data, type, row) {
                        return "<div class='rut_linea'>"+data+"</div>";     
                    }
                },
                { //NOMBRES
                    "data": "iden_nombre",
                    "className": "text-center"
                },
                { //EDAD
                    "data": "iden_edad",
                    "className": "text-center"
                },
                { //TELEFONO
                    "data": "iden_fono",
                    "className": "text-center",
                    "render": function(data, type, row) {
                        if(data == '' || data == null){
                            return 'Sin información';
                        }else{
                            return data;
                        }
                        
                    }
                },
                { //CORREO
                    "data": "iden_correo",
                    "className": "text-center",
                    "render": function(data, type, row) {
                        if(data == '' || data == null){
                            return 'Sin información';
                        }else{
                            return data;
                        }
                        
                    }
                },
                { //ACCIONES
                    "data": "iden_id",
                    "className": "text-center",
                    "render": function(data, type, row) {
                        //INICIO DC SPRINT 67
                        let html = '<button type="button" class="btn btn-primary" onclick="editarLineaBase_2021('+data+');limpiarfrmValidadiones_2021();"><b>Editar</b></button>';
                        html +=
                            ' <button type="button" class="btn btn-danger" onclick="eliminarLineaBase_2021(' +
                            data + ')"><i class=""></i>  <b>Eliminar</b></button>';
                        //FIN DC SPRINT 67
                        //INICIO CZ SPRINT 67 correccion
                        if ($("#est_pro_id").val() == {{config('constantes.finalizado')}} || $("#est_pro_id").val() == {{config('constantes.desestimado')}}) {
                            $('.btn-danger').attr('disabled', 'disabled');
                        }
                        //FIN CZ SPRINT 67 correccion
                        return html;
                    }
                },
                { 
                    "data": "iden_id",
                    "className": "text-center",
                    "render": function(data, type, row) {
                        @if($flag_linea == 1)
                        let html =
                            '<button type="button" class="btn btn-primary" onclick="descargarLineaBase(' +
                            data +
                            ');limpiarfrmValidadiones();"><i class="fa fa-download"></i><b>Descargar</b></button>';

                        @elseif($flag_linea == 2)
                        let html =
                            '<button type="button" class="btn btn-primary" onclick="descargarLineaBase_2021(' +
                            data +
                            ');limpiarfrmValidadiones_2021();"><i class="fa fa-download"></i><b>Descargar</b></button>';
                        @endif
                        return html;
                    }
                } 
            ]
        });
    @endif
}
function listarPreguntas_2021(opcion, id = '') {
    $("#lin_bas_id").val(id);
    $("#accion").val(opcion);

    respuestaPreguntas.length = 0;
    $("#identificacion").collapse('hide');
    $("#servicio_prestaciones").collapse('hide');
    $("#organizacion_comunitaria").collapse('hide');
    $("#derecho_part_nna").collapse('hide');
    listaPreServicios_2021();
    listaPreProgramas_2021();
    listaPreBienesComunitarios_2021();
    listaPreOrganizaciones_2021();
    listaPreParticipacion_2021();
    listaPreProyecto_2021();

    $('#linea_rut_linea_base').rut({
        fn_error: function(input) {
            if (input.val() != '') {
                $('#linea_rut_linea_base').attr("data-val-run", false);
                mensajeTemporalRespuestas(0, "* RUN Inválido.");
                $("#val_linea_rut_linea_base").show();
            }
        },
        fn_validado: function(input) {
            $('#linea_rut_linea_base').attr("data-val-run", true);
            $("#val_linea_rut_linea_base").hide();

            autoCompletarNombre();

        }
    });
}

function countDigits( str ) {
  return Array.prototype.reduce.call( str, function( acu, val ) {
    return ( val.charCodeAt( 0 ) > 47 ) && ( val.charCodeAt( 0 ) < 58 ) ? acu + 1 : acu;
  }, 0 );
}
// CZ SPRINT 76
function limpiarfrmIdentificacionLineaBase_2021(){
        $("#linea_nom_linea_base").val("");
        $("#linea_rut_linea_base").val("");
        //$("#linea_com_linea_base").val("");
        // $("#linea_dir").val("");
        $("#linea_cal_linea_base").val("");
        $("#linea_num_linea_base").val("");
        $("#linea_bloc_linea_base").val("");
        $("#linea_dep_linea_base").val("");
        $("#linea_telf_linea_base").val("");
        $("#linea_correo_linea_base").val("");
        $("#linea_edad_linea_base").val("");
        $("#linea_sexo_linea_base option[value='']").attr("selected",true);
        $("#linea_sexo_linea_base option[value="+ 0+"]").attr("selected",false);
        $("#linea_sexo_linea_base option[value="+ 1+"]").attr("selected",false);
        $('input[name="check_acceso_internet_linea_base[]"]').prop('checked', false);
        $('input[name="check_equipos_comunicacion_linea_base[]"]').prop('checked', false);
        $('input[name="check_viven_nn_linea_base[]"]').prop('checked', false);
        $('input[name="check_rango_edad_linea_base[]"]').prop('checked', false);
        $("#ser_niv_com_linea_base").val("");
        $("#ser_pro_soc_linea_base").val("");
        $("#ser_ser_sec_linea_base").val("");
        $("#bien_org_otr_linea_base").val("");
        // CZ SPRINT 76
        $("#rango_edad").val();
        $("#rango_edad_b").val();
        $("#rango_edad_c").val();
        $("#rango_edad_d").val();
        // CZ SPRINT 76
    }

</script>