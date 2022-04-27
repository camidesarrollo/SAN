<!-- INICIO CZ SPRINT 67 -->
<div id="frmEjecucionDPC" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="formComponentesLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
<!-- FIN CZ SPRINT 67 -->
    <div class="modal-dialog modal-lg">
      <div class="modal-content p-4">
        <div class="card p-4 m-0 shadow-sm">
          <h5 class="modal-title text-center" id="formComponentesLabel"><b>CARACTERÍSTICAS GENERALES</b></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" style="position: absolute; right: 5px; top: 5px; width: 23px; height: 23px; padding: 0; margin: 0;">&times;</span>
          </button>
          <br>
		  
          <div class="form-group">
            <!-- ACTIVIDADES REALIZADAS -->                
            <div class="form-group row ml-3">
                <label for="" class="col-sm-4 col-form-label"><b>Actividades Realizadas</b></label>
                <div class="col-sm-8">
                    @if($est_pro_id != config('constantes.plan_estrategico'))
                        <textarea id="ejec_act_real" maxlength="3000" onkeypress='return caracteres_especiales(event)'  onKeyUp="valTextAreaInfoEjec2()" onKeyDown="valTextAreaInfoEjec2()" class="form-control " rows="5" onblur="" ></textarea>
                        <div class="row">
                            <div class="col">
                                <h6><small class="form-text text-muted">Mínimo 3 y máximo 3000 caracteres.</small></h6>
                            </div>
                            <div class="col text-left">
                                <h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_ejec_act_real" style="color: #000000;">0</strong></small></h6>
                            </div>        
                        </div>
                        <p id="val_ejec_act_real" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar una actividad.</p>
                    @else
                        <label id="ejec_act_real" for=""></label>
                    @endif
                </div>                           
            </div>
            <!-- ACTIVIDADES REALIZADAS -->
            <!-- DESTINATARIOS -->
            <div class="form-group row ml-3">
                <label for="" class="col-sm-4 col-form-label"><b>Destinatarios</b></label>
                <div class="col-sm-8">
                    @if($est_pro_id != config('constantes.plan_estrategico'))
                        <textarea id="ejec_desti" maxlength="3000" onkeypress='return caracteres_especiales(event)'  onKeyUp="valTextAreaInfoEjec3()" onKeyDown="valTextAreaInfoEjec3()" class="form-control " rows="5" onblur="" ></textarea>
                        <div class="row">
                            <div class="col">
                                <h6><small class="form-text text-muted">Mínimo 3 y máximo 3000 caracteres.</small></h6>
                            </div>
                            <div class="col text-left">
                                <h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_ejec_desti" style="color: #000000;">0</strong></small></h6>
                            </div>        
                        </div>
                        <p id="val_ejec_desti" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar un destinatario.</p>
                    @else
                        <label id="ejec_desti" for=""></label>
                    @endif
                </div>                              
            </div>
            <!-- DESTINATARIOS -->
            <!-- MEDIOS DE DIFUSION -->
            <div class="form-group row ml-3">
                <label for="" class="col-sm-4 col-form-label"><b>Medios de difusión y convocatoria</b></label>
                <div class="col-sm-8">
                    @if($est_pro_id != config('constantes.plan_estrategico'))
                        <textarea id="ejec_med_dif" maxlength="3000" onkeypress='return caracteres_especiales(event)'  onKeyUp="valTextAreaInfoEjec4()" onKeyDown="valTextAreaInfoEjec4()" class="form-control " rows="5" onblur="" ></textarea>
                        <div class="row">
                            <div class="col">
                                <h6><small class="form-text text-muted">Mínimo 3 y máximo 3000 caracteres.</small></h6>
                            </div>
                            <div class="col text-left">
                                <h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_ejec_med_dif" style="color: #000000;">0</strong></small></h6>
                            </div>        
                        </div>
                        <p id="val_ejec_med_dif" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar un Medio</p>
                    @else
                        <label id="ejec_med_dif" for=""></label>
                    @endif
                </div>                              
            </div>
            <!-- MEDIOS DE DIFUSION -->
            <!-- METODOLOGIAS -->
            <div class="form-group row ml-3">
                <label for="" class="col-sm-4 col-form-label"><b>Metodología</b></label>
                <div class="col-sm-8">
                    @if($est_pro_id != config('constantes.plan_estrategico'))
                        <textarea id="ejec_metodo" maxlength="3000" onkeypress='return caracteres_especiales(event)'  onKeyUp="valTextAreaInfoEjec5()" onKeyDown="valTextAreaInfoEjec5()" class="form-control " rows="5" onblur="" ></textarea>
                        <div class="row">
                            <div class="col">
                                <h6><small class="form-text text-muted">Mínimo 3 y máximo 3000 caracteres.</small></h6>
                            </div>
                            <div class="col text-left">
                                <h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_ejec_metodo" style="color: #000000;">0</strong></small></h6>
                            </div>        
                        </div>
                        <p id="val_ejec_metodo" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar una Metodología.</p>
                    @else
                        <label id="ejec_metodo" for=""></label>
                    @endif
                </div>                              
            </div>
            <!-- METODOLOGIAS -->
            <!-- CANTIDAD DE PARTICIPANTES -->
            <div class="form-group row ml-3">
                <label for="" class="col-sm-4 col-form-label"><b>Cantidad de Participantes</b></label>
                <div class="col-sm-2">
                    @if($est_pro_id != config('constantes.plan_estrategico'))
                        <!-- INICIO CZ SPRINT 55-->
                        <input maxlength="2" max="99" min="1" id="ejec_cant_part" name="ejec_cant_part" onkeypress="return soloNumeros(event)" type="number" class="form-control"  onblur="validarCantidad()">
                        <!-- FIN CZ SPRINT 55 -->
                        <p id="val_ejec_cant_part" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar una cantidad.</p>
                    @else
                        <label id="ejec_cant_part" for=""></label>
                    @endif
                    
                </div>                              
            </div>
            <!-- CANTIDAD DE PARTICIPANTES -->
            <!-- FACILITADORES -->
            <div class="form-group row ml-3">
                <label for="" class="col-sm-4 col-form-label"><b>Facilitadores</b></label>
                <div class="col-sm-8">
                    @if($est_pro_id != config('constantes.plan_estrategico'))
                        <textarea id="ejec_facil" maxlength="3000" onkeypress='return caracteres_especiales(event)'  onKeyUp="valTextAreaInfoEjec6()" onKeyDown="valTextAreaInfoEjec6()" class="form-control " rows="5" onblur="" ></textarea>
                        <div class="row">
                            <div class="col">
                                <h6><small class="form-text text-muted">Mínimo 3 y máximo 3000 caracteres.</small></h6>
                            </div>
                            <div class="col text-left">
                                <h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_ejec_facil" style="color: #000000;">0</strong></small></h6>
                            </div>        
                        </div>
                        <p id="val_ejec_facil" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar un Facilicitador</p>
                    @else
                        <label id="ejec_facil" for=""></label>
                    @endif
                </div>                              
            </div>
            <!-- FACILITADORES -->
            <!-- OBSTACULIZADORES -->
            <div class="form-group row ml-3">
                <label for="" class="col-sm-4 col-form-label"><b>Obstaculizadores</b></label>
                <div class="col-sm-8">
                    @if($est_pro_id != config('constantes.plan_estrategico'))
                        <textarea id="ejec_obsti" maxlength="3000" onkeypress='return caracteres_especiales(event)'  onKeyUp="valTextAreaInfoEjec7()" onKeyDown="valTextAreaInfoEjec7()" class="form-control " rows="5" onblur="" ></textarea>
                        <div class="row">
                            <div class="col">
                                <h6><small class="form-text text-muted">Mínimo 3 y máximo 3000 caracteres.</small></h6>
                            </div>
                            <div class="col text-left">
                                <h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_ejec_obsti" style="color: #000000;">0</strong></small></h6>
                            </div>        
                        </div>
                        <p id="val_ejec_obsti" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar una obstaculización.</p>
                    @else
                        <label id="ejec_obsti" for=""></label>
                    @endif
                </div>                              
            </div>
            <!-- OBSTICULIZADORES -->
        </div>   
          <div class="text-right">
            <button type="button" class="btn btn-success" onclick="registrarInformeEjecucionDPC();" >Guardar</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>					
        </div>                
      </div>
    </div>
  </div>
<!-- FIN DC SPRINT 67 -->
<script type="text/javascript">

</script>

<script type="text/javascript"> 

    let cont_act_ejec = "";
    function valTextAreaInfoEjec1(){
      num_caracteres_permitidos   = 3000;

      num_caracteres = $("#ejec_act_plan").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#ejec_act_plan").val(cont_act_ejec);

       }else{ 
          cont_act_ejec = $("#ejec_act_plan").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_ejec_act_plan").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_ejec_act_plan").css("color", "#000000");

       } 

      
       $("#cant_carac_ejec_act_plan").text($("#ejec_act_plan").val().length);
   }

    let cont_real_ejec = "";
    function valTextAreaInfoEjec2(){
      num_caracteres_permitidos   = 3000;

      num_caracteres = $("#ejec_act_real").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#ejec_act_real").val(cont_real_ejec);

       }else{ 
          cont_real_ejec = $("#ejec_act_real").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_ejec_act_real").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_ejec_act_real").css("color", "#000000");

       } 

      
       $("#cant_carac_ejec_act_real").text($("#ejec_act_real").val().length);
   }

    let cont_dest_ejec = "";
    function valTextAreaInfoEjec3(){
      num_caracteres_permitidos   = 3000;

      num_caracteres = $("#ejec_desti").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#ejec_desti").val(cont_dest_ejec);

       }else{ 
          cont_dest_ejec = $("#ejec_desti").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_ejec_desti").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_ejec_desti").css("color", "#000000");

       } 

      
       $("#cant_carac_ejec_desti").text($("#ejec_desti").val().length);
   }
    
    let cont_med_ejec = "";
    function valTextAreaInfoEjec4(){
      num_caracteres_permitidos   = 3000;

      num_caracteres = $("#ejec_med_dif").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#ejec_med_dif").val(cont_med_ejec);

       }else{ 
          cont_med_ejec = $("#ejec_med_dif").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_ejec_med_dif").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_ejec_med_dif").css("color", "#000000");

       } 

      
       $("#cant_carac_ejec_med_dif").text($("#ejec_med_dif").val().length);
    }

   let cont_met_ejec = "";
    function valTextAreaInfoEjec5(){
      num_caracteres_permitidos   = 3000;

      num_caracteres = $("#ejec_metodo").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#ejec_metodo").val(cont_part_car);

       }else{ 
          cont_part_car = $("#ejec_metodo").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_ejec_metodo").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_ejec_metodo").css("color", "#000000");

       } 

      
       $("#cant_carac_ejec_metodo").text($("#ejec_metodo").val().length);
    }

    let cont_facil_ejec = "";
    function valTextAreaInfoEjec6(){
      num_caracteres_permitidos   = 3000;
    
      num_caracteres = $("#ejec_facil").val().length;
        
       if (num_caracteres > num_caracteres_permitidos){ 
            $("#ejec_facil").val(cont_facil_ejec);

       }else{ 
          cont_facil_ejec = $("#ejec_facil").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_ejec_facil").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_ejec_facil").css("color", "#000000");

       } 

      
       $("#cant_carac_ejec_facil").text($("#ejec_facil").val().length);
   }


    let cont_obs_ejec = "";
    function valTextAreaInfoEjec7(){
      num_caracteres_permitidos   = 3000;
    
      num_caracteres = $("#ejec_obsti").val().length;
        
       if (num_caracteres > num_caracteres_permitidos){ 
            $("#ejec_obsti").val(cont_obs_ejec);

       }else{ 
          cont_obs_ejec = $("#ejec_obsti").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_ejec_obsti").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_ejec_obsti").css("color", "#000000");

       } 

      
       $("#cant_carac_ejec_obsti").text($("#ejec_obsti").val().length);
   }
    // INICIO CZ SPRINT 55
   function validarCantidad(){
       if(parseInt($("#ejec_cant_part").val()) >999){
           alert("La cantidad de participantes no puede ser mayor a 999! Intentelo nuevamente");
           $("#ejec_cant_part").val("");
       }
   }
// FIN CZ SPRINT 55
</script>
