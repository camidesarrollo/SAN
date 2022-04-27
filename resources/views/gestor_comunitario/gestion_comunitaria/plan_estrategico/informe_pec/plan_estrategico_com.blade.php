<!-- INICIO SECCION PLAN ESTRATEGICO COMUNITARIO -->
<div class="card colapsable shadow-sm" id="contenedor_listar_plan">
    <a class="btn text-left p-0 collapsed" id="desplegar_listar_plan" data-toggle="collapse" data-target="#listar_plan" aria-expanded="false" aria-controls="listar_plan" onclick="if($(this).attr('aria-expanded') == 'false') mostrarBitacora();">
		<div class="card-header p-3">
			<h5 class="mb-0">
				<button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
				Plan Estrategico Comunitario
			</h5>
		</div>
	</a>


	<div class="collapse" id="listar_plan">
		<div class="card-body">
    		<div class="table-responsive">
                <table class="table table-striped table-hover w-100" cellspacing="0" id="tbl_plan_estrategico">
                    <thead>
                        <tr>
                        	<th>ID Prob</th>
                            <th>Problema Priorizado</th>
                            <th>Objetivo</th>
                            <th>Resultado Esperado</th>
                            <th>Indicador</th>
                            <th>Acciones</th>
                            
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
             <a href="{{route('reporte.plan.estrategico').'/'.$pro_an_id}}"><button type="button" class="btn btn-success"><i class="fa fa-file-excel-o"></i> Descargar Plan Estrategico</button></a>
            </div>
		</div>
	</div>
    <!-- INICIO CZ SPRINT 67 -->
	<div class="modal fade" id="PlanModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <!-- FIN CZ SPRINT 67 -->
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Agregar Plan Estrategico Comunitario</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <form id="frmPlanEstr"> 
                <input type="hidden" id="idProb">
                <input type="hidden" id="idPlan">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Objetivo:</label>
                    <div class="col-sm-9">
                        <textarea maxlength="2000" onkeypress='return caracteres_especiales(event)'  onKeyUp="valTextAreaMatDivergencia2(this)" onKeyDown="valTextAreaMatDivergencia2(this)" class="form-control mb-2" rows="5" id="txt_plan_objetivo"></textarea>
                        <div class="row">
                            <div class="col">
                                <h6><small class="form-text text-muted">Mínimo 3 y máximo 2000 caracteres.</small></h6>
                            </div>
                            <div class="col text-left">
                                <h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_txt_plan_objetivo" style="color: #000000;">0</strong></small></h6>
                            </div>        
                        </div>
                        <p id="val_txt_plan_objetivo" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Ingrese el Objetivo.</p>
                    </div>                           
                </div>
                
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Resultado:</label>
                    <div class="col-sm-9">
                        <textarea maxlength="2000" onkeypress='return caracteres_especiales(event)'  onKeyUp="valTextAreaMatDivergencia2(this)" onKeyDown="valTextAreaMatDivergencia2(this)" class="form-control mb-2" rows="5" id="txt_plan_resultados"></textarea>
                        <div class="row">
                            <div class="col">
                                <h6><small class="form-text text-muted">Mínimo 3 y máximo 2000 caracteres.</small></h6>
                            </div>
                            <div class="col text-left">
                                <h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_txt_plan_resultados" style="color: #000000;">0</strong></small></h6>
                            </div>        
                        </div>
                        <p id="val_txt_plan_resultados" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Ingrese el Resultado.</p>
                    </div>                           
                </div>
                
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Indicador:</label>
                    <div class="col-sm-9">
                        <textarea maxlength="2000" onkeypress='return caracteres_especiales(event)'  onKeyUp="valTextAreaMatDivergencia2(this)" onKeyDown="valTextAreaMatDivergencia2(this)" class="form-control mb-2" rows="5" id="txt_plan_indicador"></textarea>
                        <div class="row">
                            <div class="col">
                                <h6><small class="form-text text-muted">Mínimo 3 y máximo 2000 caracteres.</small></h6>
                            </div>
                            <div class="col text-left">
                                <h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_txt_plan_indicador" style="color: #000000;">0</strong></small></h6>
                            </div>        
                        </div>
                        <p id="val_txt_plan_indicador" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Ingrese el Indicador.</p>
                    </div>                           
                </div>                     
            </form>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button id="btnGuardarEditar" type="button" class="btn btn-primary">Guardar</button>
            </div>
        </div>
        </div>
    </div>
    <!-- INCIO CZ SPRINT 67 -->
        <div class="modal fade" id="PlanActividades" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <!-- FIN CZ SPRINT 67 -->
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Actividades</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form id="frmPlanEstr"> 
                	<input type="hidden" id="idProb">
                	<input type="hidden" id="idPlan">
                	<p id="msj_error" style="font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar el Objetivo para ingresar Actividades.</p>
                    
                    
                    <div class="card colapsable shadow-sm">
                        <div class="card-header p-3">
                    			<h5 class="mb-0">
                    				Actividad (<span id="cont_act">0</span>)
                    				<button id="btnAddAct" type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="" style="float:right;" onclick="addAct()">Agregar Actividad</button>                    				
                    			</h5>
                    		</div>
                    	<div class="collapse" style="display:block;">
                    		<div class="card-body">
                    		
                        		<table id="tblAct" class="table table-striped table-hover w-100" cellspacing="0" id="tbl_plan_estrategico">
                                    <thead>
                                        <tr>
                                            <th>Actividad</th>
                                            <th>Estrategia</th>
                                            <th>Metodología</th>
                                            <th>Responsables</th>
                                            <th>Plazo (Semanas)</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                                
                                <div id="frmAddAct" style="display:none;">
                                	<input type="hidden" id="idAct" >
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Actividad:</label>
                                        <div class="col-sm-9">
                                        	<textarea maxlength="2000" onkeypress='return caracteres_especiales(event)'  onKeyUp="valTextAreaMatDivergencia2(this)" onKeyDown="valTextAreaMatDivergencia2(this)" class="form-control mb-2" rows="5" id="txt_plan_actividad"></textarea>
                                            <div class="row">
                                            	<div class="col">
                                                	<h6><small class="form-text text-muted">Mínimo 3 y máximo 2000 caracteres.</small></h6>
                                                </div>
                                                <div class="col text-left">
                                                	<h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_txt_plan_actividad" style="color: #000000;">0</strong></small></h6>
                                                </div>        
                                            </div>
                                            <p id="val_txt_plan_actividad" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Ingrese la Actividad.</p>
                                        </div>                           
                                    </div>
                                
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Estrategia:</label>
                                        <div class="col-sm-9">
                                        	<input type="checkbox" id="checkRelCom"> Relacionamiento Comunitario
                                        	<br>
                                        	<input type="checkbox" id="checkTallCom"> Talleres Comunitarios
                                        	<br>
                                        	<input type="checkbox" id="checkIniCom"> Iniciativa Comunitaria
                                            <p id="val_checkEstrategia" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe seleccionar la Estrategia.</p>
                                        </div>                           
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Metodologia:</label>
                                        <div class="col-sm-9">
                                        	<textarea maxlength="2000" onkeypress='return caracteres_especiales(event)'  onKeyUp="valTextAreaMatDivergencia2(this)" onKeyDown="valTextAreaMatDivergencia2(this)" class="form-control mb-2" rows="5" id="txt_plan_metodologia"></textarea>
                                            <div class="row">
                                            	<div class="col">
                                                	<h6><small class="form-text text-muted">Mínimo 3 y máximo 2000 caracteres.</small></h6>
                                                </div>
                                                <div class="col text-left">
                                                	<h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_txt_plan_metodologia" style="color: #000000;">0</strong></small></h6>
                                                </div>        
                                            </div>
                                            <p id="val_txt_plan_metodologia" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Ingrese la Metodologia.</p>
                                        </div>                           
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Responsables:</label>
                                        <div class="col-sm-9">
                                        	<textarea maxlength="2000" onkeypress='return caracteres_especiales(event)'  onKeyUp="valTextAreaMatDivergencia2(this)" onKeyDown="valTextAreaMatDivergencia2(this)" class="form-control mb-2" rows="5" id="txt_plan_responsables"></textarea>
                                            <div class="row">
                                            	<div class="col">
                                                	<h6><small class="form-text text-muted">Mínimo 3 y máximo 2000 caracteres.</small></h6>
                                                </div>
                                                <div class="col text-left">
                                                	<h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_txt_plan_responsables" style="color: #000000;">0</strong></small></h6>
                                                </div>        
                                            </div>
                                            <p id="val_txt_plan_responsables" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Ingrese los Responsables.</p>
                                        </div>                           
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Plazo:</label>
                                        <div class="col-sm-9">
                                        	<table>
                                        		<tr>
                                        			<td width="100"><input maxlength="3" id="txtPlazoPlan" name="txtPlazoPlan" onkeypress="return soloNumeros(event)" type="number" max="100" min="1"class="form-control" onblur=""></td>
                                        			<td width="5"></td>
                                        			<td><span class="sem" style="float: left">Semanas</span></td>
                                        		</tr>
                                        	</table>
                                        	 
                                            <p id="val_txtPlazoPlan" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Ingrese el Plazo.</p>
                                        </div>                           
                                    </div>                                    
                                    <button id="btnGuardarAct" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="" onclick="guardarAct()">Agregar Actividad</button>
                                    <button id="btnEditAct" style="display:none;" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="" onclick="editarAct()">Editar Actividad</button>
                                    <button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="" onclick="volverAddAct()">Cancelar</button>                                 
                                </div>                                
                    		</div>
                    	</div>
                    </div>
                                        
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button id="btnGuardarEditarAct" type="button" class="btn btn-primary">Guardar</button>
              </div>
            </div>
          </div>
        </div>
</div>
<!-- FIN SECCION PLAN ESTRATEGICO COMUNITARIO -->