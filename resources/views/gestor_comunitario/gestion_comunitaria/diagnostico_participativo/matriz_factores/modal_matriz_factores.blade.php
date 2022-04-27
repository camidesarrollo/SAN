<!-- INICIO CZ SPRINT 67 -->
<div id="frmmatrizfactores" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="formComponentesLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
<!-- FIN CZ SPRINT 67 -->
    <div class="modal-dialog modal-lg">
      <div class="modal-content p-4">
        <div class="card p-4 m-0 shadow-sm">
          <h5 class="modal-title text-center" id="formComponentesLabel"><b>INGRESO MATRIZ DE FACTORES PROTECTORES</b></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" style="position: absolute; right: 5px; top: 5px; width: 23px; height: 23px; padding: 0; margin: 0;">&times;</span>
          </button>
          <br>
		  
            <div class="form-group">                
            
                <div class="form-group row ml-3">
                    <label for="" class="col-sm-4 col-form-label"><b>Factores protectores:</b></label>
                    <div class="col-sm-8">
                        <textarea id="mat_fac" maxlength="500" onkeypress='return caracteres_especiales(event)'  onKeyUp="valTextAreaMatFactores()" onKeyDown="valTextAreaMatFactores()" class="form-control " rows="5"></textarea>
                        <div class="row">
                            <div class="col">
                                <h6><small class="form-text text-muted">Mínimo 3 y máximo 500 caracteres.</small></h6>
                            </div>
                            <div class="col text-left">
                                <h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_mat_fac" style="color: #000000;">0</strong></small></h6>
                            </div>        
                        </div>
                        <p id="val_mat_fac" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar factor protector.</p>
                    </div>                              
                </div>

                <div class="form-group row ml-3">
                    <label for="" class="col-sm-4 col-form-label"><b>A nivel familiar:</b></label>
                    <div class="col-sm-8">
                        <textarea id="mat_fam" maxlength="500" onkeypress='return caracteres_especiales(event)'  onKeyUp="valTextAreaMatFamiliar()" onKeyDown="valTextAreaMatFamiliar()" class="form-control " rows="5"></textarea>
                        <div class="row">
                            <div class="col">
                                <h6><small class="form-text text-muted">Mínimo 3 y máximo 500 caracteres.</small></h6>
                            </div>
                            <div class="col text-left">
                                <h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_mat_fam" style="color: #000000;">0</strong></small></h6>
                            </div>        
                        </div>
                        <p id="val_mat_fam" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar factor familiar.</p>
                    </div>                           
                </div>

                <div class="form-group row ml-3">
                    <label for="" class="col-sm-4 col-form-label"><b>A nivel escolar:</b></label>
                    <div class="col-sm-8">
                        <textarea id="mat_esc" maxlength="500" onkeypress='return caracteres_especiales(event)'  onKeyUp="valTextAreaMatEscolar()" onKeyDown="valTextAreaMatEscolar()" class="form-control " rows="5"></textarea>
                        <div class="row">
                            <div class="col">
                                <h6><small class="form-text text-muted">Mínimo 3 y máximo 500 caracteres.</small></h6>
                            </div>
                            <div class="col text-left">
                                <h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_mat_esc" style="color: #000000;">0</strong></small></h6>
                            </div>        
                        </div>
                        <p id="val_mat_esc" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar factor escolar.</p>
                    </div>                              
                </div>

                <div class="form-group row ml-3">
                    <label for="" class="col-sm-4 col-form-label"><b>A nivel comunitario:</b></label>
                    <div class="col-sm-8">
                        <textarea id="mat_com" maxlength="500" onkeypress='return caracteres_especiales(event)'  onKeyUp="valTextAreaMatComunitario()" onKeyDown="valTextAreaMatComunitario()" class="form-control " rows="5"></textarea>
                        <div class="row">
                            <div class="col">
                                <h6><small class="form-text text-muted">Mínimo 3 y máximo 500 caracteres.</small></h6>
                            </div>
                            <div class="col text-left">
                                <h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_mat_com" style="color: #000000;">0</strong></small></h6>
                            </div>        
                        </div>
                        <p id="val_mat_com" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar factor comunitario</p>
                    </div>                              
                </div>

                <div class="form-group row ml-3">
                    <label for="" class="col-sm-4 col-form-label"><b>A nivel institucional:</b></label>
                    <div class="col-sm-8">
                        <textarea id="mat_ins" maxlength="500" onkeypress='return caracteres_especiales(event)'  onKeyUp="valTextAreaMatInstituciones()" onKeyDown="valTextAreaMatInstituciones()" class="form-control " rows="5"></textarea>
                        <div class="row">
                            <div class="col">
                                <h6><small class="form-text text-muted">Mínimo 3 y máximo 500 caracteres.</small></h6>
                            </div>
                            <div class="col text-left">
                                <h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_mat_ins" style="color: #000000;">0</strong></small></h6>
                            </div>        
                        </div>
                        <p id="val_mat_ins" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar factor institucional.</p>
                    </div>                              
                </div>

                <div class="form-group row ml-3">
                    <label for="" class="col-sm-4 col-form-label"><b>Otros:</b></label>
                    <div class="col-sm-8">
                        <textarea id="mat_otros" maxlength="500" onkeypress='return caracteres_especiales(event)'  onKeyUp="valTextAreaMatOtros()" onKeyDown="valTextAreaMatOtros()" class="form-control " rows="5"></textarea>
                        <div class="row">
                            <div class="col">
                                <h6><small class="form-text text-muted">Mínimo 3 y máximo 500 caracteres.</small></h6>
                            </div>
                            <div class="col text-left">
                                <h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_mat_otros" style="color: #000000;">0</strong></small></h6>
                            </div>        
                        </div>
                        <p id="val_mat_otros" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar factor institucional.</p>
                    </div>                              
                </div>

            </div>
          <div class="text-right">
            <button type="button" class="btn btn-success" onclick="guardarMatrizFactores();" >Guardar</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>					
        </div>                
      </div>
    </div>
  </div>
<!-- FIN DC SPRINT 67 -->
<script type="text/javascript">

    let cont_mat_ins_com_esc_fam_fac = "";
    function valTextAreaMatFactores(){
      num_caracteres_permitidos   = 500;
      num_caracteres = $("#mat_fac").val().length;
       if (num_caracteres > num_caracteres_permitidos){ 
            $("#mat_fac").val(cont_mat_ins_com_esc_fam_fac);
       }else{ 
          cont_mat_ins_com_esc_fam_fac = $("#mat_fac").val(); 
       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_mat_fac").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_mat_fac").css("color", "#000000");

       } 
      
       $("#cant_carac_mat_fac").text($("#mat_fac").val().length);
    }

    let cont_mat_ins_com_esc_fam = "";
    function valTextAreaMatFamiliar(){
      num_caracteres_permitidos   = 500;
      num_caracteres = $("#mat_fam").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#mat_fam").val(cont_mat_ins_com_esc_fam);

       }else{ 
          cont_mat_ins_com_esc_fam = $("#mat_fam").val(); 
       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_mat_fam").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_mat_fam").css("color", "#000000");

       }       
       $("#cant_carac_mat_fam").text($("#mat_fam").val().length);
    }

    let cont_mat_ins_com_esc = "";
    function valTextAreaMatEscolar(){
      num_caracteres_permitidos   = 500;
      num_caracteres = $("#mat_esc").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#mat_esc").val(cont_mat_ins_com_esc);

       }else{ 
          cont_mat_ins_com_esc = $("#mat_esc").val(); 
       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_mat_esc").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_mat_esc").css("color", "#000000");

       }       
       $("#cant_carac_mat_esc").text($("#mat_esc").val().length);
    }

    let cont_mat_ins_com = "";
    function valTextAreaMatComunitario(){
      num_caracteres_permitidos   = 500;
      num_caracteres = $("#mat_com").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#mat_com").val(cont_mat_ins_com);

       }else{ 
          cont_mat_ins_com = $("#mat_com").val(); 
       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_mat_com").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_mat_com").css("color", "#000000");

       }       
       $("#cant_carac_mat_com").text($("#mat_com").val().length);
    }

    let cont_mat_ins = "";
    function valTextAreaMatInstituciones(){
      num_caracteres_permitidos   = 500;
      num_caracteres = $("#mat_ins").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#mat_ins").val(cont_mat_ins);

       }else{ 
          cont_mat_ins = $("#mat_ins").val(); 
       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_mat_ins").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_mat_ins").css("color", "#000000");

       }       
       $("#cant_carac_mat_ins").text($("#mat_ins").val().length);
    }
    //INICIO DC SPRINT 67
    let cont_mat_otros = "";
    function valTextAreaMatOtros(){
      num_caracteres_permitidos   = 500;
      num_caracteres = $("#mat_otros").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#mat_otros").val(cont_mat_otros);

       }else{ 
          cont_mat_otros = $("#mat_otros").val(); 
       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_mat_otros").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_mat_otros").css("color", "#000000");

       }       
       $("#cant_carac_mat_otros").text($("#mat_otros").val().length);
       //FIN DC SPRINT 67
    }

</script>