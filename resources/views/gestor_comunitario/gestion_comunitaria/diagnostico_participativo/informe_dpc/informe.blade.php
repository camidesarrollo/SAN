<div class="card colapsable shadow-sm" id="contenedor_info_identificacion">
    <a class="btn text-left p-0 collapsed" id="desplegar_info_identificacion" data-toggle="collapse" data-target="#info_identificacion" aria-expanded="false" aria-controls="info_identificacion" onclick="dataintroduccion();">
        <div class="card-header p-3">
            <h5 class="mb-0">
                <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
                &nbsp;&nbsp;I. Identificación
            </h5>
        </div>
    </a>


    <div class="collapse" id="info_identificacion">
        <div class="card-body">
            <br>
            @includeif('gestor_comunitario.gestion_comunitaria.diagnostico_participativo.informe_dpc.identificacion_formulario')
        </div>
    </div>
</div>

<div class="card colapsable shadow-sm" id="contenedor_info_introduccion">
    <a class="btn text-left p-0 collapsed" id="desplegar_info_introduccion" data-toggle="collapse" data-target="#info_introduccion" aria-expanded="false" aria-controls="info_introduccion" onclick="">
        <div class="card-header p-3">
            <h5 class="mb-0">
                <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
                &nbsp;&nbsp;II. Introducción
            </h5>
        </div>
    </a>

    <div class="collapse" id="info_introduccion">
        <div class="card-body">
            <br>
            @includeif('gestor_comunitario.gestion_comunitaria.diagnostico_participativo.informe_dpc.introduccion')
        </div>
    </div>
</div>

<div class="card colapsable shadow-sm" id="contenedor_info_gurpo_accion">
    <a class="btn text-left p-0 collapsed" id="desplegar_info_gurpo_accion" data-toggle="collapse" data-target="#info_gurpo_accion" aria-expanded="false" aria-controls="info_gurpo_accion" onclick="">
        <div class="card-header p-3">
            <h5 class="mb-0">
                <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
                &nbsp;&nbsp;III. Grupo de Acción
            </h5>
        </div>
    </a>

    <div class="collapse" id="info_gurpo_accion">
        <div class="card-body">
            <br>
            @includeif('gestor_comunitario.gestion_comunitaria.diagnostico_participativo.informe_dpc.grupo_accion')
        </div>
    </div>
</div>
<!-- INICIO DC SPRINT 67-->

<div class="card colapsable shadow-sm" id="contenedor_info_ejec_diag_part">
    <a class="btn text-left p-0 collapsed" id="desplegar_info_ejec_diag_part" data-toggle="collapse" data-target="#info_ejec_diag_part" aria-expanded="false" aria-controls="info_ejec_diag_part" onclick="listarInformeEjecucionDPC();">
        <div class="card-header p-3">
            <h5 class="mb-0">
                <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
                &nbsp;&nbsp;IV. Ejecución del Diagnóstico Participativo Comunitario
            </h5>
        </div>
    </a>

    <div class="collapse" id="info_ejec_diag_part">
        <div class="card-body">
            <br>
            <label for="">En el presente apartado, el Gestor/a Comunitario/a debe incluir todas aquellas actividades realizadas junto al Grupo de Acción y a la comunidad, con el fin de levantar</label>
            <br>
            <div class="form-group">
                <table class="table table-striped table-hover w-100" cellspacing="0" id="tabla_ejecucion_dpc">
                    <thead>
                        <tr>
                            <th>Actividades Realizadas</th>
                            <th>Destinatarios</th>
                            <th>Medios de difusión y convocatoria</th>
                            <th>Metodología</th>
                            <th>Cantidad de Participantes</th>
                            <th>Facilitadores</th>
                            <th>Obstaculizadores</th>
                            @if($est_pro_id != config('constantes.plan_estrategico'))
                                <th>Acciones</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <button type="button" class="btn btn-outline-success btnAddEjecucion" data-toggle="modal" data-target="#frmEjecucionDPC" onclick="limpiarFrmEjecucionDPC();"><i class="fa fa-plus-circle"></i> Agregar Ejecución</button>                                
            </div> 
            @includeif('gestor_comunitario.gestion_comunitaria.diagnostico_participativo.informe_dpc.ejecucion_dpc')
        </div>
    </div>
</div>
 <!-- FIN DC SPRINT 67-->

<div class="card colapsable shadow-sm" id="contenedor_info_resultados">
<!-- INICIO CZ -->
    <a class="btn text-left p-0 collapsed" id="desplegar_info_resultados" data-toggle="collapse" data-target="#info_resultados" aria-expanded="false" aria-controls="info_resultados" onclick="">
        <div class="card-header p-3">
            <h5 class="mb-0">
                <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
                &nbsp;&nbsp;V. Resultados
            </h5>
        </div>
    </a>
<!-- FIN CZ -->
    <div class="collapse" id="info_resultados">
        <div class="card-body">
            <br>
            @if($est_pro_id != config('constantes.plan_estrategico'))
            <!-- INICIO CZ -->
                <textarea id="info_result" maxlength="3000" onkeypress='return caracteres_especiales(event)'  onKeyUp="valTextAreaInfoResult()" onKeyDown="valTextAreaInfoResult()" class="form-control info_resultado" rows="5" onblur="registrarInforme();" placeholder="En el presente apartado se presentan los principales resultados del DPC. En este apartado el Gestor/a Comunitario/a podrá incluir los puntos que estime conveniente según el análisis realizado. Para sugerencias ver Documento de Apoyo a la Gestión Comunitaria"></textarea>
                <div class="row">
                    <div class="col">
                        <h6><small class="form-text text-muted">Mínimo 3 y máximo 3000 caracteres.</small></h6>
                    </div>
                    <div class="col text-left">
                        <h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_info_result" class="cant_carac_info_resultado" style="color: #000000;">0</strong></small></h6>
                    </div>        
                </div>
                <p id="val_info_result" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar factor familiar.</p>
            <!-- FIN CZ -->
            @else
                <label id="info_result" for=""></label>
            @endif
        </div>
    </div>
</div>

<div class="card colapsable shadow-sm" id="contenedor_info_conclusiones">
    <a class="btn text-left p-0 collapsed" id="desplegar_info_conclusiones" data-toggle="collapse" data-target="#info_conclusiones" aria-expanded="false" aria-controls="info_conclusiones" onclick="">
        <div class="card-header p-3">
            <h5 class="mb-0">
                <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
                &nbsp;&nbsp;VI. Conclusiones y Recomendaciones
            </h5>
        </div>
    </a>

    <div class="collapse" id="info_conclusiones">
        <div class="card-body">
            <br>
            @if($est_pro_id != config('constantes.plan_estrategico'))
                <textarea id="info_con_rec" maxlength="3000" onkeypress='return caracteres_especiales(event)'  onKeyUp="valTextAreaInfoCon()" onKeyDown="valTextAreaInfoCon()" class="form-control info_con_recomendaciones" rows="5" onblur="registrarInforme();" placeholder="En el presente apartado el Gestor/a Comunitario/a debe establecer conclusiones y recomendaciones técnicas al DPC."></textarea>
                <div class="row">
                    <div class="col">
                        <h6><small class="form-text text-muted">Mínimo 3 y máximo 3000 caracteres.</small></h6>
                    </div>
                    <div class="col text-left">
                        <h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_info_con_rec" class="cant_carac_info_con_recomendaciones" style="color: #000000;">0</strong></small></h6>
                    </div>        
                </div>
                <p id="val_info_con_rec" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar factor familiar.</p>
            @else
                <label id="info_con_rec" for=""></label>
            @endif
        </div>
    </div>
</div>

<div class="card colapsable shadow-sm" id="contenedor_info_anexos">
    <a class="btn text-left p-0 collapsed" id="desplegar_info_anexos" data-toggle="collapse" data-target="#info_anexos" aria-expanded="false" aria-controls="info_ejec_diag_part" onclick="">
        <div class="card-header p-3">
            <h5 class="mb-0">
                <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
                &nbsp;&nbsp;VII. Anexos
            </h5>
        </div>
    </a>

    <div class="collapse" id="info_anexos">
        <div class="card-body">
            <br>
            @includeif('gestor_comunitario.gestion_comunitaria.diagnostico_participativo.informe_dpc.anexos')
        </div>
    </div>
    <!-- INCIO CZ SPRINT 56-->
    <p id="msj_error_descInfDPC" style="font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar todos los campos para descargar el informe DPC.</p>
    <!-- FIN CZ SPRINT 56-->
</div>
<!-- INICIO DC -->
<a id="descInfDPC" style="display:none" target="_blank" href="{{route('informe.dpc').'/'.$pro_an_id}}"><button type="button" style="margin-bottom: 20px" class="btn btn-success"><i class="fa fa-file-excel-o"></i> Descargar Informe Diagnostico Participativo</button></a>
<!-- FIN DC -->
<!-- HIDDEN -->
<input type="hidden" name="hid_eje_id" id="hid_eje_id" value="">
<!-- HIDDEN -->
<!-- INICIO CZ SPRINT 55 -->
<?php
$com_id = session()->all()['comuna'];
?>
<!-- FIN CZ SPRINT 55 -->

<script type="text/javascript">

    function dataInformeDPC(){
        bloquearPantalla();
        var idComuna = "<?php echo $com_id; ?>" ;
        $("#info_com").val('{{ Session::get('comuna') }}');

        let data = new Object();

        data.pro_an_id = {{ $pro_an_id }};
        $.ajax({
            type: "GET",
            url: "{{route('data.informe.diagnostico')}}",
            data: data
        }).done(function(resp){
            // INICIO CZ SPRINT 55
            // $("#info_gestor").val(resp.dataUsuario[0].nombre)
            //FIN CZ SPRINT 55
            $.each(resp.com_pri, function(i, item){
                $('#info_com_pri').append('<option value="'+ item.com_pri_id +'">'+item.com_pri_nom+'</option>');
                $('#inf_com_pri').append('<option value="'+ item.com_pri_id +'">'+item.com_pri_nom+'</option>'); 
                
            });
   
            //INICIO CZ SPRINT 55 
            /*
            $("#info_com_pri").val($("#iden_com_pri").val());    
            if(resp.iden_com != null){
                $("#info_com_pri").val(resp.iden_com.com_pri_id);
            $( "#info_com_pri" ).prop( "disabled", true );
            }*/
            // FIN CZ SPRINT 55
            let data = resp.data;
            if(resp.estado == 1 && data != null){
                @if($est_pro_id != config('constantes.plan_estrategico'))
                    if(data.info_fec_pri != null){
                        let fec1 = new Date(data.info_fec_pri);
                        fec1 = fec1.getDate()+"/"+(fec1.getMonth() + 1 )+"/"+fec1.getFullYear();
                        // INICIO CZ
                        $('#div_info_fec_primer_contacto').datetimepicker('format', 'DD/MM/Y');
                        $('#div_info_fec_primer_contacto').datetimepicker('date', fec1);
                        // FIN CZ
                    }

                    if(data.info_fec_ter != null){
                        let fec2 = new Date(data.info_fec_ter);
                        fec2 = fec2.getDate()+"/"+(fec2.getMonth() + 1 )+"/"+fec2.getFullYear();
                        // INICIO CZ
                        $('#div_info_fec_termino_dpc').datetimepicker('format', 'DD/MM/Y');
                        $('#div_info_fec_termino_dpc').datetimepicker('date', fec2);
                        // FIN
                    }			
                
                    $("#info_gestor").val(data.info_resp);
                    //INICIO DC
                    $("#info_com").val('{{ Session::get('comuna') }}');
                    $('#info_com').attr('disabled', 'disabled');
                    $( "#info_com" ).prop( "disabled", true );
                    //FIN DC

                    // INICIO CZ
                    // PRESENTACION DEL INFORME 
                    // $("#info_intro").val(data.info_intro);
                    $(".presentacion_informe").val(data.info_intro);
                    // FIN CZ
                    $("#intro_vinculacion").val(data.info_vin_oln);
                    $("#grupo_conf").val(data.info_gru_acc);
                    $("#grupo_plan").val(data.info_plan_act);
                    // $("#ejec_act_plan").val(data.info_act_plan);
                    // $("#ejec_act_real").val(data.info_act_real);
                    // $("#ejec_desti").val(data.info_dest);
                    // $("#ejec_med_dif").val(data.info_med_dif);
                    // $("#ejec_metodo").val(data.info_met);
                    // $("#ejec_cant_part").val(data.info_can_par);
                    // $("#ejec_facil").val(data.info_fac);
                    // $("#ejec_obsti").val(data.info_obst);
                    // INICIO CZ 
                    $(".info_resultado").val(data.info_res);
                    // FIN CZ 
                    // INICIO CZ
                    $(".info_con_recomendaciones").val(data.info_con_res);
                    // FIN CZ
                    //INICIO DC
                    if(data.info_resp != null && data.info_com != null && data.com_pri_id != null && data.info_fec_pri != null && data.info_fec_ter != null && data.info_intro != null && data.info_vin_oln != null && data.info_gru_acc != null && data.info_plan_act != null && data.info_res != null && data.info_con_res != null){
                    	// INCIO CZ SPRINT 56
                            $("#msj_error_descInfDPC").css("display","none");
                        // FIN CZ SPRINT 56
                    	$('#descInfDPC').fadeIn(0);
                    	$('#descInfDPC button').fadeIn(0);
                    }else{
                        	// INCIO CZ SPRINT 56
                            $("#msj_error_descInfDPC").css("display","block");
                        // FIN CZ SPRINT 56
                    	$('#descInfDPC').fadeOut(0);
                    }
                    //FIN DC
            @else
                if(data.info_fec_pri != null){
                    let fec1 = new Date(data.info_fec_pri);
                    fec1 = fec1.getDate()+"/"+(fec1.getMonth() + 1 )+"/"+fec1.getFullYear();
                    $('#fec_primer_contacto').text(fec1);
                }

                if(data.info_fec_ter != null){
                    let fec2 = new Date(data.info_fec_ter);
                    fec2 = fec2.getDate()+"/"+(fec2.getMonth() + 1 )+"/"+fec2.getFullYear();
                    $('#info_fec_ter_dpc').text(fec2);
                }			
               
                $("#info_gestor").text(data.info_resp);
                $("#info_com").text(data.info_com);
                // $("#inf_com_pri").val(data.com_pri_id);
                
                $("#info_intro").text(data.info_intro);
                $("#intro_vinculacion").text(data.info_vin_oln);
                $("#grupo_conf").text(data.info_gru_acc);
                $("#grupo_plan").text(data.info_plan_act);
                // $("#ejec_act_plan").text(data.info_act_plan);
                // $("#ejec_act_real").text(data.info_act_real);
                // $("#ejec_desti").text(data.info_dest);
                // $("#ejec_med_dif").text(data.info_med_dif);
                // $("#ejec_metodo").text(data.info_met);
                // $("#ejec_cant_part").text(data.info_can_par);
                // $("#ejec_facil").text(data.info_fac);
                // $("#ejec_obsti").text(data.info_obst);
                $("#info_result").text(data.info_res);
                $("#info_con_rec").text(data.info_con_res);
                //INICIO DC
                    if(data.info_resp != null && data.info_com != null && data.com_pri_id != null && data.info_fec_pri != null && data.info_fec_ter != null && data.info_intro != null && data.info_vin_oln != null && data.info_gru_acc != null && data.info_plan_act != null && data.info_res != null && data.info_con_res != null){
                    		// INCIO CZ SPRINT 56
                            $("#msj_error_descInfDPC").css("display","none");
                        // FIN CZ SPRINT 56
                    	$('#descInfDPC').fadeIn(0);
                    	$('#descInfDPC button').fadeIn(0);
                    }else{
                        	// INCIO CZ SPRINT 56
                            $("#msj_error_descInfDPC").css("display","block");
                        // FIN CZ SPRINT 56
                    	$('#descInfDPC').fadeOut(0);
                    }
                //FIN DC
            @endif
                
            }
            //INICIO CZ SPRINT 55
            let dat2 = new Object();
            dat2.pro_an_id = {{ $pro_an_id }};
            $.ajax({
                    type: "GET",
                    url: "{{route('identificacion.priorizada.mostrar')}}",
                    data: dat2
                }).done(function(resp){
                        iden_com = $.parseJSON(resp.iden_com);
                         $("#info_com_pri option[value='"+iden_com.com_pri_id+"']").attr("selected", true);
                         $('#inf_com_pri').append('<option value="'+ iden_com.com_pri_id +'">'+iden_com.com_pri_id+'</option>');   

                }).fail(function(objeto, tipoError, errorHttp){            

                    manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

                    return false;
                });
                //FIN CZ SPRINT 55 


            desbloquearPantalla();
        }).fail(function(objeto, tipoError, errorHttp){

            desbloquearPantalla();
            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
            return false;

        });

        $("#adj_info_anex").submit(function(e){
            e.preventDefault();
        });
    }

    function recolectarDataInforme(){
        let data = new Object();
        
        let cant = $("#ejec_cant_part").val();
        if(cant > 99){
            $("#ejec_cant_part").val(99);
            cant = 99;
        } 
        data.info_resp = $("#info_gestor").val();
        data.info_com = $("#info_com").val();
        data.com_pri_id = $("#info_com_pri").val();
        // INICIO CZ
        data.info_fec_pri = $('#div_info_fec_primer_contacto').data('date');
        
        data.info_fec_ter = $('#div_info_fec_termino_dpc').data('date');
        // FIN CZ
        // INICIO CZ
        data.info_intro =  $(".presentacion_informe").val();
        // FIN CZ
        data.info_vin_oln = $("#intro_vinculacion").val();
        data.info_gru_acc = $("#grupo_conf").val();
        data.info_plan_act = $("#grupo_plan").val();
        // INICIO CZ
        data.info_act_plan = $(".info_resultado").val();
        // FIN CZ
        data.info_act_real = $(".info_con_recomendaciones").val();
        data.info_dest = $("#ejec_desti").val();
        data.info_med_dif = $("#ejec_med_dif").val();
        data.info_met = $("#ejec_metodo").val();
        data.info_can_par = cant;
        data.info_fac = $("#ejec_facil").val();
        data.info_obst = $("#ejec_obsti").val();
        // INICIO CZ
        data.info_res = $(".info_resultado").val();
        // FIN CZ
        // INICIO CZ
        data.info_con_res = $(".info_con_recomendaciones").val();
        // FIN CZ 
        console.log("recolectarDataInforme");
        console.log(data);
        return data;
    }

    function registrarInforme(){

        bloquearPantalla();

        let data = new Object();
        data = recolectarDataInforme();
        data.pro_an_id = {{$pro_an_id}};

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{route('registrar.informe.diagnostico')}}",
            data: data
        }).done(function(resp){
            desbloquearPantalla();

            if(resp.estado == 1){
                mensajeTemporalRespuestas(1, resp.mensaje);
                //INICIO DC
            	if($('#info_gestor').val() != '' && $('#info_com').val() != '' && $('#info_com_pri').val() != '' && $('#fec_primer_contacto').val() != '' && $('#fec_termino_dpc').val() != '' && $(".presentacion_informe").val() != '' && $('#intro_vinculacion').val() != '' && $('#grupo_conf').val() && $('#grupo_plan').val() && $(".info_resultado").val() != '' && $(".info_con_recomendaciones").val() != ''){
                    // INCIO CZ SPRINT 56
                    $("#msj_error_descInfDPC").css("display","none");
                    // FIN CZ SPRINT 56
                	$('#descInfDPC').fadeIn(0);
                	$('#descInfDPC button').fadeIn(0);
                }else{
                    // INCIO CZ SPRINT 56
                    $("#msj_error_descInfDPC").css("display","block");
                    // FIN CZ SPRINT 56
                    $('#descInfDPC').fadeOut(0);
                }
                //FIN DC
            }else if (resp.estado == 0){
                mensajeTemporalRespuestas(0, resp.mensaje);

            }
        }).fail(function(objeto, tipoError, errorHttp){            
            desbloquearPantalla();

            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

            return false;
        });

    }

    let cont_result = "";
    // INICIO CZ
    function valTextAreaInfoResult(){
      num_caracteres_permitidos   = 3000;

      num_caracteres = $(".info_resultado").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $(".info_resultado").val(cont_result);

       }else{ 
          cont_result = $(".info_resultado").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $(".cant_carac_info_resultado").css("color", "#ff0000"); 

       }else{ 
          $(".cant_carac_info_resultado").css("color", "#000000");

       } 

      
       $(".cant_carac_info_resultado").text($(".info_resultado").val().length);
   }
// FIN CZ

// INICIO CZ
    let cont_con_rec = "";
    function valTextAreaInfoCon(){
      num_caracteres_permitidos   = 3000;

      num_caracteres = $(".info_con_recomendaciones").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $(".info_con_recomendaciones").val(cont_con_rec);

       }else{ 
          cont_con_rec = $(".info_con_recomendaciones").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $(".cant_carac_info_con_recomendaciones").css("color", "#ff0000"); 

       }else{ 
          $(".cant_carac_info_con_recomendaciones").css("color", "#000000");

       } 

      
       $(".cant_carac_info_con_recomendaciones").text($(".info_con_recomendaciones").val().length);
   }
//  FIN CZ  

   function listarInformeEjecucionDPC(){
        let tabla_ejecucion_dpc = $('#tabla_ejecucion_dpc').DataTable();
        tabla_ejecucion_dpc.clear().destroy();

        let data = new Object();
        data.pro_an_id 	= {{$pro_an_id}};
		//INICIO DC SPRINT 67
        tabla_ejecucion_dpc = $('#tabla_ejecucion_dpc').DataTable({
            "language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
            "lengthChange": false,
            "info": 		false,
            "ajax": {
                "url": "{{ route('listar.informe.ejecucion') }}",
                "type": "GET",
                "data": data
            },
            "columnDefs": [
                { //ACTIVIDADES REALIZADAS
                    "targets": 0,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //DESTINATARIOS
                    "targets": 1,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //MEDIOS DE DIFUSIÓN Y CONVOCATORIA
                    "targets": 2,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //METODOLOGÍA
                    "targets": 3,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //CANTIDAD DE PARTICIPANTES
                    "targets": 4,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //FACILITADORES
                    "targets": 5,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //OBSTACULIZADORES
                    "targets": 6,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                }@if($est_pro_id != config('constantes.plan_estrategico'))
                    ,
                    { //ACCIONES
                        "targets": 7,
                        "className": 'dt-head-center dt-body-left',
                        "createdCell": function (td, cellData, rowData, row, col) {
                            $(td).css("vertical-align", "middle");
                        
                        }
                    }
                @endif
            ],				
            "columns": [
                        { //ACTIVIDADES REALIZADAS
                            "data": "eje_act_real",
                            "className": "text-center"
                        },
                        { //DESTINATARIOS
                            "data": "eje_dest",
                            "className": "text-center"
                        },
                        { //MEDIOS DE DIFUSIÓN Y CONVOCATORIA
                            "data": "eje_med_dif",
                            "className": "text-center"
                        },
                        { //METODOLOGÍA
                            "data": "eje_met",
                            "className": "text-center"
                        },
                        { //CANTIDAD DE PARTICIPANTES
                            "data": "eje_can_par",
                            "className": "text-center"
                        },
                        { //FACILITADORES
                            "data": "eje_fac",
                            "className": "text-center"
                        },
                        { //OBSTACULIZADORES
                            "data": "eje_obst",
                            "className": "text-center"
                        }@if($est_pro_id != config('constantes.plan_estrategico'))
                            ,
                            { //ACCIONES
                                "data": "eje_id",
                                "className": "text-center",
                                "visible"	: 	true,
                                "render": function(data, type, row){
                                	//INICIO DC
                                	let html = '';
                                	if('{{ Session::get('perfil') }}' == 2){
                                		html = '<button disabled="disabled" type="button" class="btn btn-warning" onclick="limpiarFrmEjecucionDPC();editarEjecucionDPC('+data+');"><i class="fas fa-pen"></i> Editar</button>';
                                    	html+= ' <button disabled="disabled" type="button" class="btn btn-danger" onclick="eliminarEjecucionDPC('+data+')"><i class="fa fa-remove"></i> Eliminar</button>';
                                	}else{
                                		html = '<button type="button" class="btn btn-warning" onclick="limpiarFrmEjecucionDPC();editarEjecucionDPC('+data+');"><i class="fas fa-pen"></i> Editar</button>';
                                            html+= ' <button type="button" class="btn btn-danger" onclick="eliminarEjecucionDPC('+data+')"><i class="fa fa-remove"></i> Eliminar</button>';
                                	}
                                	//FIN DC                               	
                                    //INICIO CZ SPRINT 67 correccion
                                    if($("#est_pro_id").val() == {{ config('constantes.finalizado') }} || $("#est_pro_id").val() == {{ config('constantes.desestimado') }} ){
                                        $('.btn-danger').attr('disabled', 'disabled');
                                    }
                                    //FIN CZ SPRINT 67 correccion                            	
                                            return html;
                                        }
                            }
                        @endif
                    ]
        });
        //FIN DC SPRINT 67
    }

    function limpiarFrmEjecucionDPC(){

        $("#ejec_act_plan").val("");
        $("#ejec_act_real").val("");
        $("#ejec_desti").val("");
        $("#ejec_med_dif").val("");
        $("#ejec_metodo").val("");
        $("#ejec_cant_part").val("");
        $("#ejec_facil").val("");
        $("#ejec_obsti").val("");
        $("#hid_eje_id").val("");
        limpiarValidacionCaracteristicas();
    }

    function limpiarValidacionCaracteristicas(){
        $("#val_ejec_act_plan").hide();
        $("#ejec_act_plan").removeClass("is-invalid");  

        $("#val_ejec_act_real").hide();
        $("#ejec_act_real").removeClass("is-invalid");  

        $("#val_ejec_desti").hide();
        $("#ejec_desti").removeClass("is-invalid");  

        $("#val_ejec_med_dif").hide();
        $("#ejec_med_dif").removeClass("is-invalid");  

        $("#val_ejec_metodo").hide();
        $("#ejec_metodo").removeClass("is-invalid");  

        $("#val_ejec_cant_part").hide();
        $("#ejec_cant_part").removeClass("is-invalid");  

        $("#val_ejec_facil").hide();
        $("#ejec_facil").removeClass("is-invalid");  

        $("#val_ejec_obsti").hide();
        $("#ejec_obsti").removeClass("is-invalid");         
    }

	//INICIO DC SPRINT 67
    function validaInformeEjecucionDPC(){

        let ejec_act_real = $("#ejec_act_real").val();
        let ejec_desti = $("#ejec_desti").val();
        let ejec_med_dif = $("#ejec_med_dif").val();
        let ejec_metodo = $("#ejec_metodo").val();        
        let ejec_cant_part = $("#ejec_cant_part").val();
        let ejec_facil = $("#ejec_facil").val();
        let ejec_obsti = $("#ejec_obsti").val();
        let respuesta = true;

        if (ejec_act_real == "" || typeof ejec_act_real === "undefined"){
            respuesta = false;
            $("#val_ejec_act_real").show();
            $("#ejec_act_real").addClass("is-invalid");
        }else{
            $("#val_ejec_act_real").hide();
            $("#ejec_act_real").removeClass("is-invalid");            
        }

        if (ejec_desti == "" || typeof ejec_desti === "undefined"){
            respuesta = false;
            $("#val_ejec_desti").show();
            $("#ejec_desti").addClass("is-invalid");
        }else{
            $("#val_ejec_desti").hide();
            $("#ejec_desti").removeClass("is-invalid");            
        }

        if (ejec_med_dif == "" || typeof ejec_med_dif === "undefined"){
            respuesta = false;
            $("#val_ejec_med_dif").show();
            $("#ejec_med_dif").addClass("is-invalid");
        }else{
            $("#val_ejec_med_dif").hide();
            $("#ejec_med_dif").removeClass("is-invalid");            
        }
        

        if (ejec_metodo == "" || typeof ejec_metodo === "undefined"){
            respuesta = false;
            $("#val_ejec_metodo").show();
            $("#ejec_metodo").addClass("is-invalid");
        }else{
            $("#val_ejec_metodo").hide();
            $("#ejec_metodo").removeClass("is-invalid");            
        }

        if (ejec_desti == "" || typeof ejec_desti === "undefined"){
            respuesta = false;
            $("#val_ejec_cant_part").show();
            $("#ejec_cant_part").addClass("is-invalid");
        }else{
            $("#val_ejec_cant_part").hide();
            $("#ejec_cant_part").removeClass("is-invalid");            
        }

        if (ejec_med_dif == "" || typeof ejec_med_dif === "undefined"){
            respuesta = false;
            $("#val_ejec_facil").show();
            $("#ejec_facil").addClass("is-invalid");
        }else{
            $("#val_ejec_facil").hide();
            $("#ejec_facil").removeClass("is-invalid");            
        }
        

        if (ejec_metodo == "" || typeof ejec_metodo === "undefined"){
            respuesta = false;
            $("#val_ejec_obsti").show();
            $("#ejec_obsti").addClass("is-invalid");
        }else{
            $("#val_ejec_obsti").hide();
            $("#ejec_obsti").removeClass("is-invalid");            
        }

        return respuesta;
    }
    //FIN DC SPRINT 67

    function registrarInformeEjecucionDPC(){
        let resp = validaInformeEjecucionDPC();
        if(!resp) return false;

        let data = new Object();
        data.eje_id = $("#hid_eje_id").val();
        data.eje_real = $("#ejec_act_real").val();
        data.eje_dest = $("#ejec_desti").val();
        data.eje_mdif = $("#ejec_med_dif").val();
        data.eje_meto = $("#ejec_metodo").val();        
        data.eje_cant = $("#ejec_cant_part").val();
        data.eje_faci = $("#ejec_facil").val();
        data.eje_obst = $("#ejec_obsti").val();
        data.pro_an_id = {{ $pro_an_id }};

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{route('registrar.informe.ejecucion')}}",
            data: data
        }).done(function(resp){
            desbloquearPantalla();

            if(resp.estado == 1){
                mensajeTemporalRespuestas(1, resp.mensaje);
                $('#tabla_ejecucion_dpc').DataTable().ajax.reload();
                $("#frmEjecucionDPC").modal('hide');
            
            }else if (resp.estado == 0){
                mensajeTemporalRespuestas(0, resp.mensaje);

            }
        }).fail(function(objeto, tipoError, errorHttp){            
            desbloquearPantalla();

            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

            return false;
        });
    }

    function editarEjecucionDPC(eje_id){
        bloquearPantalla();
        let data = new Object()
        data.eje_id = eje_id;
        
        $.ajax({
            type: "GET",
            url: "{{route('editar.informe.ejecucion')}}",
            data: data
        }).done(function(resp){
            desbloquearPantalla();
            
            let eje = resp.data;
            if(resp.estado == 1){
                $("#hid_eje_id").val(eje.eje_id);
                $("#ejec_act_plan").val(eje.eje_act_plan);
                $("#ejec_act_real").val(eje.eje_act_real);
                $("#ejec_desti").val(eje.eje_dest);
                $("#ejec_med_dif").val(eje.eje_med_dif);
                $("#ejec_metodo").val(eje.eje_met);
                $("#ejec_cant_part").val(eje.eje_can_par);
                $("#ejec_facil").val(eje.eje_fac);
                $("#ejec_obsti").val(eje.eje_obst);
                $("#frmEjecucionDPC").modal('show');
            
            }else if (resp.estado == 0){
                mensajeTemporalRespuestas(0, resp.mensaje);

            }
            
        }).fail(function(objeto, tipoError, errorHttp){            
            desbloquearPantalla();

            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

            return false;
        });

    }

    function eliminarEjecucionDPC(eje_id){
        let confirmacion = confirm("¿Esta seguro que desea eliminar el registro?");		
        if (confirmacion == false) return false;

        bloquearPantalla();
        let data = new Object();
        data.eje_id = eje_id;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{route('eliminar.informe.ejecucion')}}",
            data: data,
        }).done(function(resp){
            desbloquearPantalla();
            
            let int = resp.data;
            if(resp.estado == 1){
                mensajeTemporalRespuestas(0, resp.mensaje);
                $('#tabla_ejecucion_dpc').DataTable().ajax.reload();
            }else if (resp.estado == 0){
                mensajeTemporalRespuestas(0, resp.mensaje);
            }
            
        }).fail(function(objeto, tipoError, errorHttp){            
            desbloquearPantalla();

            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

            return false;
        });
    }
</script>