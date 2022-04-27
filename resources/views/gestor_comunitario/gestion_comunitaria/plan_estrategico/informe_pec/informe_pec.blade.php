<!--INICIO SECCION INFORME PLAN ESTRATEGICO -->
<div class="card colapsable shadow-sm" id="contenedor_listar_informe">
    <a class="btn text-left p-0 collapsed" id="desplegar_problemas_priorizados_MRE" data-toggle="collapse" data-target="#contenedor_identificacion" aria-expanded="false" aria-controls="contenedor_problemas_priorizados_MRE" onclick="if($(this).attr('aria-expanded') == 'false') listarProblemasPriorizadosMRE();">
        <div class="card-header p-3">
            <h5 class="mb-0">
                <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
                &nbsp;&nbsp;I. Identificación
            </h5>
        </div>
    </a>
	
    <div class="collapse" id="contenedor_identificacion">
        <div class="card-body">
        
        
			<div class="row p-2">
                <label class="col-3" for="">Nombre del Gestor/a Comunitario/a a Cargo</label>
                <div class="col-sm-5">
                    <input maxlength="100" id="inf_nomGestorComCar" name="inf_nomGestorComCar" onkeypress="return caracteres_especiales(event)" type="input" class="form-control" onblur="registrarInformePE();">
                    <p id="val_info_gestor" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar un Nombre.</p>
                </div>   
            </div>
            
            <div class="row p-2">
                <label class="col-3" for="">Comuna</label>
                <div class="col-sm-5">
                    <input maxlength="100" id="inf_comuna" name="inf_comuna" onkeypress="return caracteres_especiales(event)" type="input" class="form-control" onblur="registrarInformePE();">
                        <p id="val_info_com" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar una Comuna.</p>
                </div>   
            </div>
            
            <div class="row p-2">
                <label class="col-3" for="">Comunidad Priorizada</label>
                <div class="col-5">
                    <select name="inf_com_pri" class="form-control" id="inf_com_pri" onchange="registrarInformePE()">
                    	<option value="">Seleccione un Opción</option>
                    </select>
                </div>
                <p id="val_info_com" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe seleccionar una comunidad priorizada.</p>
            </div>
            
            <div class="row p-2">
                <div class="group-form p-3">
                        <label for="">Fecha Primer Contacto</label>
                        
                        <div class="input-group date-pick" id="info_fec_pri_con" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input" onblur="registrarInformePE();" />
                            <div class="input-group-append" data-target="#info_fec_pri_con" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                        <p id="val_frm_bit_fec_ing" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe registrar una Fecha</p>                    
                </div>
                <div class="group-form p-3">
                        <label for="">Fecha de Termino DPC</label>
                        
                        <div class="input-group date-pick" id="info_fec_ter_dpc" data-target-input="nearest">
                            <input onkeypress='return caracteres_especiales_fecha(event)' type="text" class="form-control datetimepicker-input " data-target="#info_fec_ter_dpc" onblur="registrarInformePE();" />
                            <div class="input-group-append" data-target="#info_fec_ter_dpc" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                        <p id="val_info_fec_ter_dpc" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe registrar una Fecha</p>
                    
                </div>
            </div>
            
        </div>          
    </div>
</div>
    
<div class="card colapsable shadow-sm" id="contenedor_introduccionInf">    
    <a class="btn text-left p-0 collapsed" id="desplegar_problemas_priorizados_MRE" data-toggle="collapse" data-target="#contenedor_introduccion" aria-expanded="false" aria-controls="contenedor_problemas_priorizados_MRE" onclick="if($(this).attr('aria-expanded') == 'false') listarProblemasPriorizadosMRE();">
        <div class="card-header p-3">
            <h5 class="mb-0">
                <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
                &nbsp;&nbsp;II. Introducción
            </h5>
        </div>
    </a>
    <div class="collapse" id="contenedor_introduccion">
        <div class="card-body">
			<div class="card-body">
               <textarea name="info_intro" id="info_intro" maxlength="2000" onkeypress='return caracteres_especiales(event)' onblur="registrarInformePE();"  onKeyUp="valTextAreaInfo1()" onKeyDown="valTextAreaInfo1()" class="form-control" cols="30" rows="5" style="resize: none"  placeholder="Realizar presentación del informe, contexto, objetivos, fuentes de información utilizadas, incluyendo Línea de Base y Línea de Salida. Este informe se comprende como un complemento al 'Informe del DPC', por lo que debe hacer referencia a este."></textarea>
               <div class="row">
               		<div class="col">
                		<h6><small class="form-text text-muted">Mínimo 3 y máximo 2000 caracteres.</small></h6>
                	</div>
                	<div class="col text-left">
                    	<h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_info_intro" style="color: #000000;">0</strong></small></h6>
                    </div>        
                </div>
               <p id="val_info_intro" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar una introducción.</p>
            </div>
        </div>          
    </div>
</div>
    
    
 <div class="card colapsable shadow-sm" id="contenedor_eje_plan_est_comInf">     
    <a class="btn text-left p-0 collapsed" id="desplegar_problemas_priorizados_MRE" data-toggle="collapse" data-target="#contenedor_eje_plan_est_com" aria-expanded="false" aria-controls="contenedor_problemas_priorizados_MRE" onclick="if($(this).attr('aria-expanded') == 'false') listarProblemasPriorizadosMRE();">
        <div class="card-header p-3">
            <h5 class="mb-0">
                <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
                &nbsp;&nbsp;III. Ejecución Plan Estrategico Comunitario
            </h5>
        </div>
    </a>
    <div class="collapse" id="contenedor_eje_plan_est_com">
        <div class="card-body">
        	<p>En el presente apartado, el Gestor/a Comunitario/a debe incluir todas aquellas actividades realizadas junto al Grupo de Acción y a la comunidad del PEC, presentando la planificación previa y las actividades realizadas, según "Formato Plan Estrategico Comunitario". A cada una de ellas debe incorporar un análisis de estrategias, facilitadores, obstaculizadores y principales resultados. Incorporar todos los cuadros que correspondan. </p>
        	<table class="table table-striped table-hover w-100" cellspacing="0" id="tbl_actividadesInf">
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
        </div>          
    </div>
</div>
    <!-- INICIO CZ SPRINT  67-->
    <div class="modal fade" id="ModalEjePlanEst" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <!-- FIN CZ SPRINT 67 -->
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Ejecución Plan Estrategico</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
              <input type="hidden" id="idProb">
                <div class="row p-2">
                    <label class="col-3" for="">Resultado</label>
                    <div class="col-sm-5">
                        <input maxlength="100" id="inf_resultado" name="inf_resultado" onkeypress="return caracteres_especiales(event)" type="input" class="form-control">
                        <p id="val_info_gestor" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar un Nombre.</p>
                    </div>   
                </div>
                <div class="row p-2">
                    <label class="col-3" for="">Facilitadores</label>
                    <div class="col-sm-5">
                        <input maxlength="100" id="inf_faqcilitadores" name="inf_faqcilitadores" onkeypress="return caracteres_especiales(event)" type="input" class="form-control">
                        <p id="val_info_gestor" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar un Nombre.</p>
                    </div>   
                </div>
                <div class="row p-2">
                    <label class="col-3" for="">Obstaculizadores</label>
                    <div class="col-sm-5">
                        <input maxlength="100" id="inf_obstaculizaciones" name="inf_obstaculizaciones" onkeypress="return caracteres_especiales(event)" type="input" class="form-control">
                        <p id="val_info_gestor" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar un Nombre.</p>
                    </div>   
                </div>
                <div class="row p-2">
                    <label class="col-3" for="">Aprendizajes</label>
                    <div class="col-sm-5">
                        <input maxlength="100" id="inf_aprendisaje" name="inf_aprendisaje" onkeypress="return caracteres_especiales(event)" type="input" class="form-control">
                        <p id="val_info_gestor" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar un Nombre.</p>
                    </div>   
                </div>
                
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardxarEjePkanEst()">Guardar</button>
              </div>
            </div>
          </div>
        </div>
<div class="card colapsable shadow-sm" id="contenedor_resultadosInf">    
    <a class="btn text-left p-0 collapsed" id="desplegar_problemas_priorizados_MRE" data-toggle="collapse" data-target="#contenedor_resultados" aria-expanded="false" aria-controls="contenedor_problemas_priorizados_MRE" onclick="if($(this).attr('aria-expanded') == 'false') listarProblemasPriorizadosMRE();">
        <div class="card-header p-3">
            <h5 class="mb-0">
                <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
                &nbsp;&nbsp;IV. Resultados
            </h5>
        </div>
    </a>
    <div class="collapse" id="contenedor_resultados">
        <div class="card-body">
			<textarea id="info_result" maxlength="2000" onkeypress='return caracteres_especiales(event)'  onKeyUp="valTextAreaInfoResult()" onKeyDown="valTextAreaInfoResult()" onblur="registrarInformePE();" class="form-control " rows="5" placeholder="En el presente apartado se presentan los principales resultados del DPC. En este apartado el Gestor/a Comunitario/a podrá incluir los puntos que estime conveniente según el análisis realizado. Para sugerencias ver Documento de Apoyo a la Gestión Comunitaria"></textarea>
                <div class="row">
                    <div class="col">
                        <h6><small class="form-text text-muted">Mínimo 3 y máximo 2000 caracteres.</small></h6>
                    </div>
                    <div class="col text-left">
                        <h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_info_result" style="color: #000000;">0</strong></small></h6>
                    </div>        
                </div>
                <p id="val_info_result" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar factor familiar.</p>
        </div>          
    </div>
</div>
    
<div class="card colapsable shadow-sm" id="contenedor_conclusiones_recomendacionesInf">  
    <a class="btn text-left p-0 collapsed" id="desplegar_problemas_priorizados_MRE" data-toggle="collapse" data-target="#contenedor_conclusiones_recomendaciones" aria-expanded="false" aria-controls="contenedor_problemas_priorizados_MRE" onclick="if($(this).attr('aria-expanded') == 'false') listarProblemasPriorizadosMRE();">
        <div class="card-header p-3">
            <h5 class="mb-0">
                <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
                &nbsp;&nbsp;V. Conclusiones y Recomendaciones
            </h5>
        </div>
    </a>
    <div class="collapse" id="contenedor_conclusiones_recomendaciones">
        <div class="card-body">
			<textarea id="info_con_rec" maxlength="2000" onkeypress='return caracteres_especiales(event)' onblur="registrarInformePE();"  onKeyUp="valTextAreaInfoCon()" onKeyDown="valTextAreaInfoCon()" class="form-control " rows="5" placeholder="En el presente apartado el Gestor/a Comunitario/a debe establecer conclusiones y recomendaciones técnicas una vez finalizado el PEC."></textarea>
                <div class="row">
                    <div class="col">
                        <h6><small class="form-text text-muted">Mínimo 3 y máximo 2000 caracteres.</small></h6>
                    </div>
                    <div class="col text-left">
                        <h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_info_con_rec" style="color: #000000;">0</strong></small></h6>
                    </div>        
                </div>
                <p id="val_info_con_rec" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar factor familiar.</p>
        </div>          
    </div>
</div>
    
<div class="card colapsable shadow-sm" id="contenedor_anexosInf"> 
    <a class="btn text-left p-0 collapsed" id="desplegar_problemas_priorizados_MRE" data-toggle="collapse" data-target="#contenedor_anexos" aria-expanded="false" aria-controls="contenedor_problemas_priorizados_MRE" onclick="if($(this).attr('aria-expanded') == 'false') listarProblemasPriorizadosMRE();">
        <div class="card-header p-3">
            <h5 class="mb-0">
                <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
                &nbsp;&nbsp;VI. Anexos
            </h5>
        </div>
    </a>
    <div class="collapse" id="contenedor_anexos">
        <div class="card-body">
        	<div class="alert alert-success alert-dismissible fade show" id="alert-doc" role="alert" style="display: none;">
            	Documento Guardado Exitosamente.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                	<span aria-hidden="true">&times;</span>
                </button>
                </div>

                <div class="alert alert-danger alert-dismissible fade show" id="alert-err-doc" role="alert" style="display: none;">
                    Error al momento de guardar el registro. Por favor intente nuevamente.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="alert alert-danger alert-dismissible fade show" id="alert-err-doc-ext" role="alert" style="display: none;">
                    EL formato del archivo no es permitido. Sólo subir archivos con las siguientes extensiones: ".pdf", ".doc" y ".docx"
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>                
                <br>
                <div class="input-group mb-3">
                    <form enctype="multipart/form-data" id="adj_info_anex" method="post" onsubmit="cargarInformeAnexosPEC();">
                        <div class="custom-file" style="z-index:0;">
                                <input type="file" class="custom-file-input " name="doc_anex" id="doc_anex" onchange="cargarInformeAnexosPEC();">
                                <label class="custom-file-label" for="doc_anex" aria-describedby="inputGroupFileAddon01">Cargar archivo</label>
                        </div>
                    </form>
                </div>
                <div style="margin-top: -15px; margin-left: 2px;"><small>Sólo subir archivos con las siguientes extensiones: ".pdf", ".doc" y ".docx".</small></div>
                <br>
                <table class="table table-striped table-hover w-100" cellspacing="0" id="tbl_anexos">
                    <thead>
                        <tr>
                        	<th>Archivo</th>
                            <th>Tipo</th>
                            <th>Usuario</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
        </div>          
    </div>
</div>

<!-- FIN SECCION INFORME PLAN ESTRATEGICO  -->
