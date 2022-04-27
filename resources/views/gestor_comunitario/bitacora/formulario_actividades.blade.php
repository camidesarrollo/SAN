<!-- INICIO CZ SPRINT 67 -->
<div id="frmActividades" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="formComponentesLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
<!-- FIN CZ SPRINT 67 -->
    <div class="modal-dialog modal-lg">
        <div class="modal-content p-4">
            <div class="card p-4 shadow-sm">
                <h5 class="modal-title  text-center" id="formComponentesLabel"><b>Actividades</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="position: absolute; right: 5px; top: 5px; width: 23px; height: 23px; padding: 0; margin: 0;">&times;</span>
                </button>
                <br>
				
                <div class="col-md-12">
                    <div class="card colapsable">
                        <a class="btn text-left p-0" id="btn_informacion"  data-toggle="collapse" data-target="#informacion" aria-expanded="false" aria-controls="informacion">
                            <div class="card-header p-3" data-toggle="tooltip" data-placement="top" data-original-title="Informacion General">
                                <h5 class="mb-0">I. Información General</h5>
                            </div>
                        </a>
                        <div class="collapse" id="informacion">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Fecha de Actividad: </b></label>
                                    <div class="col-md-9">
                                        <div class="input-group date-pick" id="act_fec_act" data-target-input="nearest" style="width: 35%;">
                                            <input onkeypress='return caracteres_especiales_fecha(event)' type="text" name="act_fec_act" class="form-control datetimepicker-input "  data-target="#act_fec_act" id="act_fec_act"  value="">
                                            <div class="input-group-append" data-target="#act_fec_act" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                        <p id="val_act_fec_act" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar una Fecha.</p>  
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Lugar:</b></label>
                                    <div class="col-sm-9">                                  
                                        <select id="lug_id" name="lug_id" class="form-control" onchange="myFunction()">
                                            <option value="">Seleccione Lugar</option>
                                         
                                        </select>
                                        <p id="val_lug_id" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe elegir Lugar.</p>  
                                    </div>
                                </div>
                                <!-- INICIO CZ SPRINT 67 -->
                                <div class="form-group row" id="div-text_lug">
                                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Otro</b></label>
                                    <div class="col-sm-9">
                                        <input maxlength="100" id="text_lug" name="text_lug" onkeypress="return caracteres_especiales(event)" type="input" class="form-control" placeholder="">
                                        <p id="meng_text_lug" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar un Lugar.</p>
                                    </div>                              
                                </div>
                                <!-- FIN CZ SPRINT 67 -->
                                <div class="form-group row" style="display:none">
                                    <label class="col-sm-3 col-form-label" style="color:#858796;"><b>Región:</b></label>
                                    <div class="col-sm-9">
                                        <select class="form-control" id="reg_id" name="reg_id" >
                                        <option value="" >Seleccione Region</option>
                                        {{-- @foreach ($region as $v)
                                            <option value="{{$v->reg_id}}">{{$v->reg_nom}}</option>
                                        @endforeach --}}
                                        </select>
                                        <p id="val_nna_region" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Seleccionar la Región.</p>
                                    </div>    
                                </div>
                                <div class="form-group row" style="display:none">
                                    <label class="col-sm-3 col-form-label" style="color:#858796;"><b>Comuna:</b></label>
                                    <div class="col-sm-9">
                                        <select class="form-control" id="com_id" name="com_id" >
                                            <option value="" >Seleccione Comuna</option>
                                            {{-- @foreach ($comuna as $v)
                                              <option value="{{$v->com_id}}">{{$v->com_nom}}</option>
                                            @endforeach --}}
                                        </select>
                                        <p id="val_com_id" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Seleccionar la Comuna.</p>
                                    </div>    
                                </div>
                                <div class="form-group row" style="display:none">
                                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Calle:</b></label>
                                    <div class="col-sm-9">
                                        <input maxlength="100" id="act_cal" name="act_cal" onkeypress="return caracteres_especiales(event)" type="input" class="form-control" placeholder="Ej. Catedral" >
                                        <p id="val_act_cal" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar una calle.</p>
                                    </div>                              
                                </div>
                                <div class="form-group row" style="display:none">
                                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Numeración:</b></label>
                                    <div class="col-sm-9">
                                        <input maxlength="100" id="act_num" name="act_num" onkeypress="return soloNumeros(event)" type="input" class="form-control" placeholder="Ej. 2345">
                                        <p id="val_act_num" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar una Numeración.</p>
                                    </div>                              
                                </div>
                                <div class="form-group row" style="display:none">
                                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Depto:</b></label>
                                    <div class="col-sm-9">
                                        <input maxlength="100" id="act_dep" name="act_dep" onkeypress="return caracteres_especiales(event)" type="input" class="form-control" placeholder="Ej. Depto 10">
                                        <p id="val_act_dep" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar una Depto.</p>
                                    </div>                              
                                </div>
                                <div class="form-group row" style="display:none">
                                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Block:</b></label>
                                    <div class="col-sm-9">
                                        <input maxlength="100" id="act_blo" name="act_blo" onkeypress="return caracteres_especiales(event)" type="input" class="form-control" placeholder="Ej. B">
                                        <p id="val_act_blo" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar un Block.</p>
                                    </div>                              
                                </div>
                                <div class="form-group row" style="display:none">
                                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Casa:</b></label>
                                    <div class="col-sm-9">
                                        <input maxlength="100" id="act_cas" name="act_cas" onkeypress="return caracteres_especiales(event)" type="input" class="form-control" placeholder="Ej. Casa 23">
                                        <p id="val_act_cas" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar Casa.</p>
                                    </div>                              
                                </div>
                                <div class="form-group row" style="display:none">
                                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>KM / Sitio:</b></label>
                                    <div class="col-sm-9">
                                        <input maxlength="100" id="act_sit" name="act_sit" onkeypress="return caracteres_especiales(event)" type="input" class="form-control" placeholder="Ej. Km 23 / Parcela 3">
                                        <p id="val_act_sit" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar KM / Sitio.</p>
                                    </div>                              
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Referencia:</b></label>
                                    <div class="col-sm-9">
                                        <input maxlength="100" id="act_ref" name="act_ref" onkeypress="return caracteres_especiales(event)" type="input" class="form-control" placeholder="Ej. Frente a la Iglesia Santa Ana">
                                        <p id="val_act_ref" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Ingresar una Referencia.</p>
                                    </div>                              
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card colapsable">
                        <a class="btn text-left p-0" id="btn_participantes"  data-toggle="collapse" data-target="#participantes"aria-expanded="false" aria-controls="participantes">
                            <div class="card-header p-3" data-toggle="tooltip" data-placement="top" data-original-title="Números de Participantes">
                                <h5 class="mb-0">II. Participantes</h5>
                            </div>
                        </a>
                        <div class="collapse" id="participantes">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Tipo de Actor:</b></label>
                                    <div class="col-sm-9">                                  
                                        <select id="act_id" name="act_id" class="form-control" >
                                            <option value="">Seleccione Tipo de Actor</option>
  
                                        </select>
                                        <p id="val_act_id" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe elegir Lugar.</p>  
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Número de NNA:</b></label>
                                    <div class="col-sm-9">
                                        <input max="100" min="1" id="act_num_nna" name="act_num_nna" onkeypress="return caracteres_especiales(event)" onKeyUp="sumarParticipantes()" onKeyDown="sumarParticipantes()" type="number" class="form-control" onchange="sumar(this.value);">
                                        <p id="val_act_num_nna" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Ingresar un Número de NNA.</p>
                                    </div>                              
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Número de Adultos:</b></label>
                                    <div class="col-sm-9">
                                        <input max="100" min="1" id="act_num_adult" name="act_num_adult" onkeypress="return caracteres_especiales(event)" onKeyUp="sumarParticipantes()" onKeyDown="sumarParticipantes()" type="number" class="form-control" onchange="sumar(this.value);">
                                        <p id="val_act_num_adult" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Ingresar un Número de Adultos.</p>
                                    </div>                              
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Total de Participantes:</b></label>
                                    <div class="col-sm-9">
                                        <input max="100" min="1" id="act_tot_part" name="act_tot_part" onkeypress="return caracteres_especiales(event)" type="number" class="form-control" disabled>
                                        <p id="val_act_tot_part" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Ingresar un Número de Participantes.</p>
                                    </div>                              
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card colapsable" id="contenedor_actividades">
                        <a class="btn text-left p-0" id="btn_actividades"  data-toggle="collapse" data-target="#actividades" aria-expanded="false" aria-controls="actividades">
                            <div class="card-header p-3" data-toggle="tooltip" data-placement="top" data-original-title="Descripcion de Actividades">
                                <h5 class="mb-0">III. Actividades</h5>
                            </div>
                        </a>
                        <div class="collapse" id="actividades">
                            <div class="card-body">
                                <!-- HITO -->
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Hito:</b></label>
                                    <div class="col-sm-9">                                  
                                        <select id="hit_id" name="hit_id" class="form-control" onchange="cambioHito()">
                                            <option value="">Seleccione Hito</option>
                                        </select>
                                        <p id="val_hit_id" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe elegir un Hito.</p>  
                                    </div>
                                </div>
                                <!-- FIN HITO -->
                                <!-- INICIO CZ SPRINT 67 -->
                                <div class="form-group row" id="div-txt_hit">
                                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Otro</b></label>
                                    <div class="col-sm-9">
                                        <input maxlength="100" id="txt_hit" name="txt_hit" onkeypress="return caracteres_especiales(event)" type="input" class="form-control" placeholder="">
                                        <p id="meng_text_hito" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar un Hito.</p>        
                                    </div>                              
                                </div>
                                <!-- FIN CZ SPRINT 67 -->
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Nombre de la Actividad</b></label>
                                        <div class="col-sm-9"> 
                                            <textarea maxlength="2000" onkeypress='return caracteres_especiales(event)'  onKeyUp="valTextAreaPlanificadas()" onKeyDown="valTextAreaPlanificadas()" class="form-control " rows="7" id="act_plan"></textarea>
                                            <div class="row">
                                                <div class="col">
                                                    <h6><small class"form-text text-muted">Mínimo 3 y máximo 2000 caracteres.</small></h6>
                                                </div>
                                                <div class="col text-left">
                                                    <h6><small class"form-text text-muted">N° de caracteres: <strong id="cant_carac_act_plan" style="color: #000000;">0</strong></small></h6>
                                                </div>        
                                            </div>
                                            <p id="val_act_plan" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar Actividades Planificadas.</p>
                                        </div>
                                </div>
                                
                                <!-- FIN ACTIVIDADES PLANIFICADAS -->

                                <!-- ACTIVIDADES REALIZADAS-->
                                
                                <div class="form-group row" style="display: none">
                                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Actividades Realizadas:</b></label>
                                    <div class="col-sm-9"> 
                                        <textarea maxlength="2000" onkeypress='return caracteres_especiales(event)'  onKeyUp="valTextAreaRealizadas()" onKeyDown="valTextAreaRealizadas()" class="form-control " rows="7" id="act_real"></textarea>
                                        <div class="row">
                                            <div class="col">
                                                <h6><small class"form-text text-muted">Mínimo 3 y máximo 2000 caracteres.</small></h6>
                                            </div>
                                            <div class="col text-left">
                                                <h6><small class"form-text text-muted">N° de caracteres: <strong id="cant_carac_act_real" style="color: #000000;">0</strong></small></h6>
                                            </div>        
                                        </div>
                                        <p id="val_act_real" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar el Actividades Realizadas.</p>
                                    </div>
                                </div>
                                <!-- FIN ACTIVIDADES REALIZADAS -->

                                <!-- DESCRIPCIÓN-->
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Descripción:</b></label>
                                    <div class="col-sm-9">
                                        <textarea maxlength="2000" onkeypress='return caracteres_especiales(event)'  onKeyUp="valTextAreaDescripcion()" onKeyDown="valTextAreaDescripcion()" class="form-control " rows="7" id="act_des"></textarea>
                                        <div class="row">
                                            <div class="col">
                                                <h6><small class"form-text text-muted">Mínimo 3 y máximo 2000 caracteres.</small></h6>
                                            </div>
                                            <div class="col text-left">
                                                <h6><small class"form-text text-muted">N° de caracteres: <strong id="cant_carac_act_des" style="color: #000000;">0</strong></small></h6>
                                            </div>        
                                        </div>
                                        <p id="val_act_des" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar la descripción.</p>
                                    </div>
                                </div>
                                <!-- FIN DESCRIPCIÓN -->

                                <!-- MATERIALES Y/O INSTRUMENTOS-->
                                <div class="form-group row" style="display: none">
                                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Materiales y/o Instrumentos:</b></label>
                                    <div class="col-sm-9">
                                        <textarea maxlength="2000" onkeypress='return caracteres_especiales(event)'  onKeyUp="valTextAreaMateriales()" onKeyDown="valTextAreaMateriales()" class="form-control " rows="7" id="act_mat"></textarea>
                                        <div class="row">
                                            <div class="col">
                                                <h6><small class"form-text text-muted">Mínimo 3 y máximo 2000 caracteres.</small></h6>
                                            </div>
                                            <div class="col text-left">
                                                <h6><small class"form-text text-muted">N° de caracteres: <strong id="cant_carac_act_mat" style="color: #000000;">0</strong></small></h6>
                                            </div>        
                                        </div>
                                        <p id="val_act_mat" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar Materiales y/o Instrumentos.</p>
                                    </div>
                                </div>

                                <!-- FIN MATERIALES Y/O INSTRUMENTOS -->

                                <!-- OBSERVACIONES-->
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Observaciones:</b></label>
                                    <div class="col-sm-9">
                                        <textarea maxlength="2000" onkeypress='return caracteres_especiales(event)'  onKeyUp="valTextAreaObservaciones()" onKeyDown="valTextAreaObservaciones()" class="form-control " rows="7" id="act_obs"></textarea>
                                        <div class="row">
                                            <div class="col">
                                                <h6><small class"form-text text-muted">Mínimo 3 y máximo 2000 caracteres.</small></h6>
                                            </div>
                                            <div class="col text-left">
                                                <h6><small class"form-text text-muted">N° de caracteres: <strong id="cant_carac_act_obs" style="color: #000000;">0</strong></small></h6>
                                            </div>        
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Observaciones:</b></label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" rows="5" id="act_obs" placeholder="Escribe tu observacion aquí."></textarea>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>                                           


                        <div class="row align-items-center">
                            <div class="col-md-6">
                            </div>
                            <div class="col-md-6 text-right">
                                {{-- <input name="btn_reg" id="btn_reg" type="button" class="btn btn-primary btn-lg" value="Guardar" onclick="ingresarActividad();" > --}}
                                <button type="button" class="btn btn-success ingresarActividad" onclick="ingresarActividad(0);">Guardar</button>
						        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </form>
                </div>                
            </div>
        </div>
    </div>
</div>
<!-- INICIO CZ SPRINT 67 -->
<div id="modalEliminarActividad" class="modal fade" tabindex="-1"
	role="dialog" aria-labelledby="tit_modalEliminarActividad"
	aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content p-4">
			<div class="card p-4 shadow-sm">
				<h5 class="modal-title text-center" id="tit_modalEliminarActividad">
					¿Seguro(a) que desea eliminar actividad<span
						id="tit_prob2"></span>?
				</h5>
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true"
						style="position: absolute; right: 5px; top: 5px; width: 23px; height: 23px; padding: 0; margin: 0;">&times;</span>
				</button>
				<br> <br> <input type="hidden" id="modalEliminarActividad">
				<div class="text-right">
					<button type="button" 
						class="btn btn-danger" id="confirm-eliminarActividad">Eliminar Actividad</button>
					<button type="button" class="btn btn-secondary"
						data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- FIN CZ SPRINT 67 -->
<script type="text/javascript"> 

    let cont_plan = "";
    function valTextAreaPlanificadas(){
      num_caracteres_permitidos   = 2000;

      num_caracteres = $("#act_plan").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#act_plan").val(cont_plan);

       }else{ 
          cont_plan = $("#act_plan").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_act_plan").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_act_plan").css("color", "#000000");

       } 

      
       $("#cant_carac_act_plan").text($("#act_plan").val().length);
   }

    let cont_real = "";
    function valTextAreaRealizadas(){
      num_caracteres_permitidos   = 2000;

      num_caracteres = $("#act_real").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#act_real").val(cont_real);

       }else{ 
          cont_real = $("#act_real").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_act_real").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_act_real").css("color", "#000000");

       } 

      
       $("#cant_carac_act_real").text($("#act_real").val().length);
   }

    let cont_desc = "";
    function valTextAreaDescripcion(){
      num_caracteres_permitidos   = 2000;

      num_caracteres = $("#act_des").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#act_des").val(cont_desc);

       }else{ 
          cont_desc = $("#act_des").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_act_des").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_act_des").css("color", "#000000");

       } 

      
       $("#cant_carac_act_des").text($("#act_des").val().length);
   }
    
    let cont_mat = "";
    function valTextAreaMateriales(){
      num_caracteres_permitidos   = 2000;

      num_caracteres = $("#act_mat").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#act_mat").val(cont_mat);

       }else{ 
          cont_mat = $("#act_mat").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_act_mat").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_act_mat").css("color", "#000000");

       } 

      
       $("#cant_carac_act_mat").text($("#act_mat").val().length);
    }

    let cont_obs = "";
    function valTextAreaObservaciones(){
      num_caracteres_permitidos   = 2000;
    
      num_caracteres = $("#act_obs").val().length;
        
       if (num_caracteres > num_caracteres_permitidos){ 
            $("#act_obs").val(cont_obs);

       }else{ 
          cont_obs = $("#act_obs").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_act_obs").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_act_obs").css("color", "#000000");

       } 

      
       $("#cant_carac_act_obs").text($("#act_obs").val().length);
   }

// INICIO CZ SPRINT 67   
function myFunction() {
  var selectLugar = document.getElementById("lug_id").value;
  if(selectLugar== "7"){
        $("#div-text_lug").css("display", "flex");
        $( "#text_lug" ).prop( "disabled", false );
    }else{
        $("#div-text_lug").css("display", "none");
        $("#text_lug").val("");
        $( "#text_lug" ).prop( "disabled", true );
    }
}
function cambioHito(){
    var selectHito = document.getElementById("hit_id").value;
  if(selectHito== 20){
        $("#div-txt_hit").css("display", "flex");
        $( "#txt_hit" ).prop( "disabled", false );
    }else{
        $("#div-txt_hit").css("display", "none");
        $("#txt_hit").val("");
        $( "#txt_hit" ).prop( "disabled", true );
    }
}
function sumarParticipantes(){
    console.log("entro al metodo");
    // var suma = parseInt($("#act_num_nna").val()) + parseInt($("#act_num_adult").val())
    // $("#act_tot_part").val(suma);
}
function sumar (valor) {
    var total = 0;	
    valor = parseInt(valor); // Convertir el valor a un entero (número).
	
    total = $("#act_tot_part").val();
	
    // Aquí valido si hay un valor previo, si no hay datos, le pongo un cero "0".
    total = (total == null || total == undefined || total == "") ? 0 : total;
	
    /* Esta es la suma. */
    total = (parseInt(total) + parseInt(valor));
	
    // Colocar el resultado de la suma en el control "span".
    $("#act_tot_part").val(total);
    if(total > (parseInt($("#act_num_nna").val()) + parseInt($("#act_num_adult").val()))){
        $("#act_tot_part").val((parseInt($("#act_num_nna").val()) + parseInt($("#act_num_adult").val())));
    }
}
// FIN CZ SPRINT 67
</script>
