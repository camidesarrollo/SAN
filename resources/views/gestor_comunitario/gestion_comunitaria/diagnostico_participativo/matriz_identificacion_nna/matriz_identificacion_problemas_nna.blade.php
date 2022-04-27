<div class="card colapsable shadow-sm" id="contenedor_matriz_identificacion_problemas_ll">
    <a class="btn text-left p-0 collapsed" id="desplegar_matriz_identificacion_problemas" data-toggle="collapse" data-target="#contenedor_matriz_identificacion_problemas" aria-expanded="false" aria-controls="contenedor_matriz_identificacion_problemas" onclick="if($(this).attr('aria-expanded') == 'false') listarMatrizIdentificacionProblema();">
		<div class="card-header p-3">
			<h5 class="mb-0">
				<button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
				&nbsp;&nbsp;Matriz Identificación de Problemas que Constituyen un Factor de Riesgo para Los NNA
			</h5>
		</div>
	</a>
	
	
	<div class="collapse" id="contenedor_matriz_identificacion_problemas">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover w-100" cellspacing="0" id="matriz_identificacion_problemas">
                    <thead>
                        <tr>
                            <th>Categorías o Ejes Temáticos</th>
                            <th>Problemática Identificada</th>
                            <th>Causas</th>
                            <th>Efectos</th>
                            <th>Acciones que se han Realizado para Abordar el Problema</th>
                            <th>Avances</th>
                            <th>Convergencia de Percepciones de la Comunidad</th>
                            <th>Divergencia de Percepciones de la Comunidad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
             <!-- INICIO DC -->
             <button type="button" class="btn btn-success btnIdeProbFR" onclick="levantarFormularioMatrizIdentificacionProblema(0);"><i class="fa fa-plus-circle"></i> Agregar</button>             
             <a href="{{route('reporte.matriz.identificacion').'/'.$pro_an_id}}"><button type="button" class="btn btn-success btnExcelIde"><i class="fa fa-file-excel-o"></i> Descargar Matriz</button></a>
            <!-- FIN DC -->
            </div>
        </div>      	
	</div>
</div>
<!-- INICIO CZ SPRINT 67 -->
<div id="frm_mtr_iden_pro_nna" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="tit_frm_mtr_iden_pro_nna" aria-hidden="true" data-backdrop="static" data-keyboard="false">
<!-- FIN CZ SPRINT 67 -->
    <div class="modal-dialog modal-lg">
        <div class="modal-content p-4">
            <div class="card p-4 shadow-sm">
                <h5 class="modal-title text-center" id="tit_frm_mtr_iden_pro_nna"><b>Matriz Identificación de Problemas que Constituyen un Factor de Riesgo para los NNA</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="position: absolute; right: 5px; top: 5px; width: 23px; height: 23px; padding: 0; margin: 0;">&times;</span>
                </button>
                <br>
                <form>     
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Categorías o Ejes Temáticos:</label>
                        
                        <div class="col-sm-9">
                            <select class="form-control" id="frm_cat_eje_tem" name="frm_cat_eje_tem" onchange="habilitarInputOtros(3,this)">
                            </select>

                            <p id="val_frm_cat_eje_tem" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debes seleccionar una opción.</p>
                        </div>    
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Problemática Identificada:</label>

                        <div class="col-sm-9">
                            <input maxlength="100" id="frm_pro_ide" name="frm_pro_ide" onkeypress="return caracteres_especiales(event)" type="input" class="form-control">

                            <p id="val_frm_pro_ide" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debes seleccionar una opción.</p>
                        </div>                              
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Causas:</label>

                        <div class="col-sm-9">
                                <textarea maxlength="2000" onkeypress='return caracteres_especiales(event)'  onKeyUp="valTextAreaMatCausas()" onKeyDown="valTextAreaMatCausas()" class="form-control mb-2" rows="5" id="frm_cau"></textarea>
                                <div class="row">
                                    <div class="col">
                                        <h6><small class="form-text text-muted">Mínimo 3 y máximo 2000 caracteres.</small></h6>
                                    </div>
                                    <div class="col text-left">
                                        <h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_frm_cau" style="color: #000000;">0</strong></small></h6>
                                    </div>        
                                </div>
                                <p id="val_frm_cau" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar .</p>
                        </div>                              
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Efectos:</label>

                        <div class="col-sm-9">
                                <textarea maxlength="2000" onkeypress='return caracteres_especiales(event)'  onKeyUp="valTextAreaMatEfectos()" onKeyDown="valTextAreaMatEfectos()" class="form-control mb-2" rows="5" id="frm_efe"></textarea>
                                <div class="row">
                                    <div class="col">
                                        <h6><small class="form-text text-muted">Mínimo 3 y máximo 2000 caracteres.</small></h6>
                                    </div>
                                    <div class="col text-left">
                                        <h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_frm_efe" style="color: #000000;">0</strong></small></h6>
                                    </div>        
                                </div>
                                <p id="val_frm_efe" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar .</p>
                        </div>                               
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Acciones que se han realizado para abordar el problema:</label>

                        <div class="col-sm-9">
                                <textarea maxlength="2000" onkeypress='return caracteres_especiales(event)'  onKeyUp="valTextAreaMatAcciones()" onKeyDown="valTextAreaMatAcciones()" class="form-control mb-2" rows="5" id="frm_acc_rea_abo_pro"></textarea>
                                <div class="row">
                                    <div class="col">
                                        <h6><small class="form-text text-muted">Mínimo 3 y máximo 2000 caracteres.</small></h6>
                                    </div>
                                    <div class="col text-left">
                                        <h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_frm_acc_rea_abo_pro" style="color: #000000;">0</strong></small></h6>
                                    </div>        
                                </div>
                                <p id="val_frm_acc_rea_abo_pro" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar .</p>
                        </div>                            
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Avances:</label>

                        <div class="col-sm-9">
                                <textarea maxlength="2000" onkeypress='return caracteres_especiales(event)'  onKeyUp="valTextAreaMatAvances()" onKeyDown="valTextAreaMatAvances()" class="form-control mb-2" rows="5" id="frm_ava"></textarea>
                                <div class="row">
                                    <div class="col">
                                        <h6><small class="form-text text-muted">Mínimo 3 y máximo 2000 caracteres.</small></h6>
                                    </div>
                                    <div class="col text-left">
                                        <h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_frm_ava" style="color: #000000;">0</strong></small></h6>
                                    </div>        
                                </div>
                                <p id="val_frm_ava" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar .</p>
                        </div>                               
                    </div>
                     <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Convergencia de percepciones de la comunidad:</label>

                        <div class="col-sm-9">
                                <textarea maxlength="2000" onkeypress='return caracteres_especiales(event)'  onKeyUp="valTextAreaMatConvergencia()" onKeyDown="valTextAreaMatConvergencia()" class="form-control mb-2" rows="5" id="frm_con_per_com"></textarea>
                                <div class="row">
                                    <div class="col">
                                        <h6><small class="form-text text-muted">Mínimo 3 y máximo 2000 caracteres.</small></h6>
                                    </div>
                                    <div class="col text-left">
                                        <h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_frm_con_per_com" style="color: #000000;">0</strong></small></h6>
                                    </div>        
                                </div>
                                <p id="val_frm_con_per_com" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar .</p>
                        </div>                               
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Divergencia de percepciones de la comunidad:</label>

                        <div class="col-sm-9">
                                <textarea maxlength="2000" onkeypress='return caracteres_especiales(event)'  onKeyUp="valTextAreaMatDivergencia()" onKeyDown="valTextAreaMatDivergencia()" class="form-control mb-2" rows="5" id="frm_div_per_com"></textarea>
                                <div class="row">
                                    <div class="col">
                                        <h6><small class="form-text text-muted">Mínimo 3 y máximo 2000 caracteres.</small></h6>
                                    </div>
                                    <div class="col text-left">
                                        <h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_frm_div_per_com" style="color: #000000;">0</strong></small></h6>
                                    </div>        
                                </div>
                                <p id="val_frm_div_per_com" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar .</p>
                        </div>                              
                    </div>
                </form>
                <div class="text-right">
                    <button type="button" class="btn btn-success" id="gua_frm_mat_ide_pro_nna">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>                  
            </div>                
        </div>
    </div>
</div>
<script type="text/javascript">

    let cont_frm_cau = "";
    function valTextAreaMatCausas(){
      num_caracteres_permitidos   = 2000;
      num_caracteres = $("#frm_cau").val().length;
       if (num_caracteres > num_caracteres_permitidos){ 
            $("#frm_cau").val(cont_frm_cau);
       }else{ 
          cont_frm_cau = $("#frm_cau").val(); 
       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_frm_cau").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_frm_cau").css("color", "#000000");

       } 
      
       $("#cant_carac_frm_cau").text($("#frm_cau").val().length);
    }

    let cont_frm_efe = "";
    function valTextAreaMatEfectos(){
      num_caracteres_permitidos   = 2000;
      num_caracteres = $("#frm_efe").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#frm_efe").val(cont_frm_efe);

       }else{ 
          cont_frm_efe = $("#frm_efe").val(); 
       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_frm_efe").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_frm_efe").css("color", "#000000");

       }       
       $("#cant_carac_frm_efe").text($("#frm_efe").val().length);
    }

    let cont_frm_acc_rea_abo_pro = "";
    function valTextAreaMatAcciones(){
      num_caracteres_permitidos   = 2000;
      num_caracteres = $("#frm_acc_rea_abo_pro").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#frm_acc_rea_abo_pro").val(cont_frm_acc_rea_abo_pro);

       }else{ 
          cont_frm_acc_rea_abo_pro = $("#frm_acc_rea_abo_pro").val(); 
       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_frm_acc_rea_abo_pro").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_frm_acc_rea_abo_pro").css("color", "#000000");

       }       
       $("#cant_carac_frm_acc_rea_abo_pro").text($("#frm_acc_rea_abo_pro").val().length);
    }

    let cont_frm_ava = "";
    function valTextAreaMatAvances(){
      num_caracteres_permitidos   = 2000;
      num_caracteres = $("#frm_ava").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#frm_ava").val(cont_frm_ava);

       }else{ 
          cont_frm_ava = $("#frm_ava").val(); 
       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_frm_ava").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_frm_ava").css("color", "#000000");

       }       
       $("#cant_carac_frm_ava").text($("#frm_ava").val().length);
    }

    let cont_frm_con_per_com = "";
    function valTextAreaMatConvergencia(){
      num_caracteres_permitidos   = 2000;
      num_caracteres = $("#frm_con_per_com").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#frm_con_per_com").val(cont_frm_con_per_com);

       }else{ 
          cont_frm_con_per_com = $("#frm_con_per_com").val(); 
       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_frm_con_per_com").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_frm_con_per_com").css("color", "#000000");

       }       
       $("#cant_carac_frm_con_per_com").text($("#frm_con_per_com").val().length);
    }

    let cont_frm_div_per_com = "";
    function valTextAreaMatDivergencia(){
      num_caracteres_permitidos   = 2000;
      num_caracteres = $("#frm_div_per_com").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#frm_div_per_com").val(cont_frm_div_per_com);

       }else{ 
          cont_frm_div_per_com = $("#frm_div_per_com").val(); 
       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_frm_div_per_com").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_frm_div_per_com").css("color", "#000000");

       }       
       $("#cant_carac_frm_div_per_com").text($("#frm_div_per_com").val().length);
    }
</script>