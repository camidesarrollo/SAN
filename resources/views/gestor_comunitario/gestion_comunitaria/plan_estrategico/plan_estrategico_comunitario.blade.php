<!--INICIO SECCION INFORME PLAN ESTRATEGICO -->

<div class="fechaPlazo"><i style="margin-left:10px" class="far fa-calendar-alt mr-1"></i> Fecha estimada para avanzar de
    etapa: <span class="txtPlazo"></span></div>
<!-- INICIO DC -->
<form method="post" action="#" enctype="multipart/form-data" id="frm_inf_pec">
<input type="hidden" id="pro_an_id_inf" name="pro_an_id_inf" value="{{$pro_an_id}}">
<div class="card colapsable shadow-sm" id="contenedor_listar_informe">
        <a class="btn text-left p-0 collapsed" id="desplegar_problemas_priorizados_MRE" data-toggle="collapse"
            data-target="#contenedor_identificacion" aria-expanded="false"
            aria-controls="contenedor_problemas_priorizados_MRE"
            onclick="if($(this).attr('aria-expanded') == 'false') listarProblemasPriorizadosMRE();">
        <div class="card-header p-3">
            <h5 class="mb-0">
                    <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i
                            class="fa fa-info"></i></button>
                &nbsp;&nbsp;I. Identificación
            </h5>
        </div>
    </a>
	
    <div class="collapse" id="contenedor_identificacion">
        <div class="card-body">
			<div class="row p-2">
                <label class="col-3" for="">Nombre del Gestor/a Comunitario/a a Cargo</label>
                <div class="col-sm-5">
                        <input maxlength="100" id="inf_nomGestorComCar" name="inf_nomGestorComCar"
                            onkeypress="return caracteres_especiales(event)" type="input" class="form-control"
                            onblur="registrarInformePE();">
                        <p id="val_info_gestor"
                            style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe
                            ingresar un Nombre.</p>
                </div>   
            </div>
            
            <div class="row p-2">
                <label class="col-3" for="">Comuna</label>
                <div class="col-sm-5">
                        <input maxlength="100" id="inf_comuna" name="inf_comuna"
                            onkeypress="return caracteres_especiales(event)" type="input" class="form-control"
                            onblur="registrarInformePE();">
                    <input type="hidden" id="h_inf_comuna" name="h_inf_comuna">
                </div>   
            </div>
            <!-- INICIO CZ SPRINT 55 -->
            <div class="row p-2">
                <label class="col-3" for="">Comunidad Priorizada</label>
                <div class="col-5">
                        <select name="inf_com_pri" class="form-control" id="inf_com_pri" onchange="registrarInformePE()"
                            disabled>
                    	<option value="">Seleccione un Opción</option>
                    </select>
                </div>
                <input type="hidden" id="h_inf_com_pri" name="h_inf_com_pri">
            </div>
            <!-- FIN CZ SPRINT 55 -->
            <div class="row p-2">
                <div class="group-form p-3">
                        <label for="">Fecha Primer Contacto</label>
                        
                        <div class="input-group date-pick" id="info_fec_pri_con" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input" name="info_fec_pri_con"
                                onblur="registrarInformePE();" />
                            <div class="input-group-append" data-target="#info_fec_pri_con"
                                data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                        <p id="val_frm_bit_fec_ing"
                            style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe registrar
                            una Fecha</p>
                </div>
                <div class="group-form p-3">
                <!-- INICIO DC -->
                        <label for="">Fecha de Término PEC</label>
                <!-- FIN DC -->
                        <div class="input-group date-pick" id="info_fec_ter_dpc" data-target-input="nearest">
                            <input onkeypress='return caracteres_especiales_fecha(event)' name="info_fec_ter_dpc"
                                type="text" class="form-control datetimepicker-input " data-target="#info_fec_ter_dpc"
                                onblur="registrarInformePE();" />
                            <div class="input-group-append" data-target="#info_fec_ter_dpc"
                                data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                        <p id="val_info_fec_ter_dpc"
                            style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe registrar
                            una Fecha</p>
                </div>
            </div>
        </div>          
    </div>
</div>
    
<div class="card colapsable shadow-sm" id="contenedor_introduccionInf">    
        <a class="btn text-left p-0 collapsed" id="desplegar_problemas_priorizados_MRE" data-toggle="collapse"
            data-target="#contenedor_introduccion" aria-expanded="false"
            aria-controls="contenedor_problemas_priorizados_MRE"
            onclick="if($(this).attr('aria-expanded') == 'false') listarProblemasPriorizadosMRE();">
        <div class="card-header p-3">
            <h5 class="mb-0">
                    <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i
                            class="fa fa-info"></i></button>
                &nbsp;&nbsp;II. Introducción
            </h5>
        </div>
    </a>
    <div class="collapse" id="contenedor_introduccion">
        <div class="card-body">
			<div class="card-body">
			<!-- INICIO DC -->
                    <textarea name="info_intro" id="info_intro" maxlength="3000"
                        onkeypress='return caracteres_especiales(event)' onblur="registrarInformePE();"
                        onKeyUp="valTextAreaMatDivergencia2(this)" onKeyDown="valTextAreaMatDivergencia2(this)"
                        class="form-control" cols="30" rows="5" style="resize: none"
                        placeholder="Realizar presentación del informe, contexto, objetivos, fuentes de información utilizadas, incluyendo Línea de Base y Línea de Salida. Este informe se comprende como un complemento al 'Informe del DPC', por lo que debe hacer referencia a este."></textarea>
               <!-- FIN DC -->
               <div class="row">
               		<div class="col">
                		<h6><small class="form-text text-muted">Mínimo 3 y máximo 3000 caracteres.</small></h6>
                	</div>
                	<div class="col text-left">
                            <h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_info_intro"
                                        style="color: #000000;">0</strong></small></h6>
                    </div>        
                </div>
                    <p id="val_info_intro" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">*
                        Debe ingresar una introducción.</p>
            </div>
        </div>          
    </div>
</div>
 <div class="card colapsable shadow-sm" id="contenedor_eje_plan_est_comInf">     
        <a class="btn text-left p-0 collapsed" id="desplegar_problemas_priorizados_MRE" data-toggle="collapse"
            data-target="#contenedor_eje_plan_est_com" aria-expanded="false"
            aria-controls="contenedor_problemas_priorizados_MRE"
            onclick="if($(this).attr('aria-expanded') == 'false') listarProblemasPriorizadosMRE();">
        <div class="card-header p-3">
            <h5 class="mb-0">
                    <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i
                            class="fa fa-info"></i></button>
                &nbsp;&nbsp;III. Ejecución Plan Estrategico Comunitario
            </h5>
        </div>
    </a>
    <div class="collapse" id="contenedor_eje_plan_est_com">
        <div class="card-body">
                <p>En el presente apartado, el Gestor/a Comunitario/a debe incluir todas aquellas actividades realizadas
                    junto al Grupo de Acción y a la comunidad del PEC, presentando la planificación previa y las
                    actividades realizadas, según "Formato Plan Estrategico Comunitario". A cada una de ellas debe
                    incorporar un análisis de estrategias, facilitadores, obstaculizadores y principales resultados.
                    Incorporar todos los cuadros que correspondan. </p>
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
                
<div class="card colapsable shadow-sm" id="contenedor_resultadosInf">    
        <a class="btn text-left p-0 collapsed" id="desplegar_problemas_priorizados_MRE" data-toggle="collapse"
            data-target="#contenedor_resultados" aria-expanded="false"
            aria-controls="contenedor_problemas_priorizados_MRE"
            onclick="if($(this).attr('aria-expanded') == 'false') listarProblemasPriorizadosMRE();">
        <div class="card-header p-3">
            <h5 class="mb-0">
                    <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i
                            class="fa fa-info"></i></button>
                &nbsp;&nbsp;IV. Resultados
            </h5>
        </div>
    </a>
    <div class="collapse" id="contenedor_resultados">
        <div class="card-body">
        <!-- INICIO DC -->
                <textarea name="info_result" id="info_result" maxlength="3000"
                    onkeypress='return caracteres_especiales(event)' onKeyUp="valTextAreaMatDivergencia2(this)"
                    onKeyDown="valTextAreaMatDivergencia2(this)" onblur="registrarInformePE();" class="form-control "
                    rows="5"
                    placeholder="En el presente apartado se presentan los principales resultados del DPC. En este apartado el Gestor/a Comunitario/a podrá incluir los puntos que estime conveniente según el análisis realizado. Para sugerencias ver Documento de Apoyo a la Gestión Comunitaria"></textarea>
        <!-- FIN DC -->        
                <div class="row">
                    <div class="col">
                        <h6><small class="form-text text-muted">Mínimo 3 y máximo 3000 caracteres.</small></h6>
                    </div>
                    <div class="col text-left">
                        <h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_info_result"
                                    style="color: #000000;">0</strong></small></h6>
                    </div>        
                </div>
                <p id="val_info_result" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe
                    ingresar factor familiar.</p>
        </div>          
    </div>
</div>
    
<div class="card colapsable shadow-sm" id="contenedor_conclusiones_recomendacionesInf">  
        <a class="btn text-left p-0 collapsed" id="desplegar_problemas_priorizados_MRE" data-toggle="collapse"
            data-target="#contenedor_conclusiones_recomendaciones" aria-expanded="false"
            aria-controls="contenedor_problemas_priorizados_MRE"
            onclick="if($(this).attr('aria-expanded') == 'false') listarProblemasPriorizadosMRE();">
        <div class="card-header p-3">
            <h5 class="mb-0">
                    <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i
                            class="fa fa-info"></i></button>
                &nbsp;&nbsp;V. Conclusiones y Recomendaciones
            </h5>
        </div>
    </a>
    <div class="collapse" id="contenedor_conclusiones_recomendaciones">
        <div class="card-body">
        <!-- INICIO DC -->
                <textarea name="info_con_rec" id="info_con_rec" maxlength="3000"
                    onkeypress='return caracteres_especiales(event)' onblur="registrarInformePE();"
                    onKeyUp="valTextAreaMatDivergencia2(this)" onKeyDown="valTextAreaMatDivergencia2(this)"
                    class="form-control " rows="5"
                    placeholder="En el presente apartado el Gestor/a Comunitario/a debe establecer conclusiones y recomendaciones técnicas una vez finalizado el PEC."></textarea>
        <!-- FIN DC -->
                <div class="row">
                    <div class="col">
                        <h6><small class="form-text text-muted">Mínimo 3 y máximo 3000 caracteres.</small></h6>
                    </div>
                    <div class="col text-left">
                        <h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_info_con_rec"
                                    style="color: #000000;">0</strong></small></h6>
                    </div>        
                </div>
                <p id="val_info_con_rec" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">*
                    Debe ingresar factor familiar.</p>
        </div>          
    </div>
</div>
    
<div class="card colapsable shadow-sm" id="contenedor_anexosInf"> 
        <a class="btn text-left p-0 collapsed" id="desplegar_problemas_priorizados_MRE" data-toggle="collapse"
            data-target="#contenedor_anexos" aria-expanded="false" aria-controls="contenedor_problemas_priorizados_MRE"
            onclick="if($(this).attr('aria-expanded') == 'false') listarProblemasPriorizadosMRE();">
        <div class="card-header p-3">
            <h5 class="mb-0">
                    <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i
                            class="fa fa-info"></i></button>
                &nbsp;&nbsp;VI. Anexos
            </h5>
        </div>
    </a>
    <div class="collapse" id="contenedor_anexos">
        <div class="card-body">
                <div class="alert alert-success alert-dismissible fade show" id="alert-doc" role="alert"
                    style="display: none;">
            	Documento Guardado Exitosamente.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                	<span aria-hidden="true">&times;</span>
                </button>
                </div>

                <div class="alert alert-danger alert-dismissible fade show" id="alert-err-doc" role="alert"
                    style="display: none;">
                    Error al momento de guardar el registro. Por favor intente nuevamente.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="alert alert-danger alert-dismissible fade show" id="alert-err-doc-ext" role="alert"
                    style="display: none;">
                    EL formato del archivo no es permitido. Sólo subir archivos con las siguientes extensiones: ".pdf",
                    ".doc" y ".docx"
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>                
                <br>
                <!-- INICIO CZ SPRINT 65 -->
                <div class="input-group mb-3">
                    <div style="display:none">
                    <form method="post" action="#" enctype="multipart/form-data" id="adj_doc_anexo_pec">
                        <div class="custom-file" style="z-index:0;">
                                <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                                <input name="tipo" type="hidden" value="5"/>
                                <input name="pro_an_id" type="hidden" value="{{$pro_an_id}}"/>
                                <input type="file" class="custom-file-input doc_anex" name="doc_anex" id="doc_anex"
                                    onchange="cargarInformeAnexosPEC()" style="display:none">
                                <label class="custom-file-label" for="doc_anex" aria-describedby="inputGroupFileAddon02"
                                    style="display:none">Cargar archivo</label>
                                </div>
                        </form>
                    </div> 
                    <form method="post" action="#" enctype="multipart/form-data" id="adj_doc_anexo">
                            <div class="custom-file" style="z-index:0;">
                                <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                                <input name="tipo_gestion" type="hidden" value="{{$tipo_gestion}}"/>
                                <input name="tipo" type="hidden" value="5"/>
                                <input name="pro_an_id" type="hidden" value="{{$pro_an_id}}"/>
                                <!-- INICIO CZ SPRINT 62 -->
                            <input type="file" class="custom-file-input doc_anex" name="doc_anex" id="doc_anex"
                                onchange="cargarInformeAnexosPEC()">
                                <!-- FIN CZ SPRINT 62 -->
                            <label class="custom-file-label" for="doc_anex"
                                aria-describedby="inputGroupFileAddon02">Cargar archivo</label>
                        </div>
                    </form>
                </div>
                <!-- FIN CZ SPRINT 65 -->
                <div style="margin-top: -15px; margin-left: 2px;"><small>Sólo subir archivos con las siguientes
                        extensiones: ".pdf", ".doc" y ".docx".</small></div>
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
                <!-- INICIO CZ SPRINT 67 -->
                <meta name="_token" content="{{ csrf_token() }}">
                <div class="modal fade" id="eliminarAnexoPec" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">Confirmar la eliminación</h4>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>
                            </div>

                            <div class="modal-body">
                                <p>Está a punto de borrar una documento, este procedimiento es irreversible.</p>
                                <p>¿Quieres continuar?</p>
                                <p class="debug-url"></p>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal"
                                    id="cerrar-modal-confirm">Cancel</button>
                                <button type="button" class="btn btn-danger" id ="elimPec" onclick="">Eliminar</button>
                            </div>
                        </div>
                    </div>
                </div>
<!-- FIN CZ SPRINT 67 -->
        </div>          
    </div>
</div>
</form>
<!-- FIN DC -->
<!-- INICIO CZ SPRINT  67-->
<div id="modalNoRealizado" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="tit_no_realizado"
	aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content p-4">
			<div class="card p-4 shadow-sm">
				<h5 class="modal-title text-center" id="tit_no_realizado">
                    ¿Seguro(a) que desea cambiar estado a No Realizado<span id="tit_prob2"></span>?
				</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"
						style="position: absolute; right: 5px; top: 5px; width: 23px; height: 23px; padding: 0; margin: 0;">&times;</span>
				</button>
				<br> <br> <input type="hidden" id="no_realizado">
				<div class="text-right">
                    <button type="button" onclick="noRealizadoPec()" class="btn btn-danger"
                        id="confirm-noRealizadoPec">No Realizado</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- FIN CZ SPRINT 67 -->
<!-- INICIO CZ SPRINT  67-->
<div class="modal fade" id="ModalEjePlanEst" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true" data-backdrop="static" data-keyboard="false">
<!-- FIN CZ SPRINT  67-->
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Ejecución Plan Estrategico</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
              <form method="post" action="#" enctype="multipart/form-data" id="frm_eje_pec">
              <input type="hidden" id="idProb" name="idProb">
              <div class="form-group row">
                  	<label class="col-sm-3 col-form-label">Resultado:</label>
                    <div class="col-sm-9">
                            <textarea maxlength="3000" onkeypress='return caracteres_especiales(event)'
                                onKeyUp="valTextAreaMatDivergencia2(this)" onKeyDown="valTextAreaMatDivergencia2(this)"
                                class="form-control mb-2" rows="5" id="inf_resultado" name="inf_resultado"></textarea>
                        <div class="row">
                        	<div class="col">
                                    <h6><small class="form-text text-muted">Mínimo 3 y máximo 3000 caracteres.</small>
                                    </h6>
                           </div>
                           <div class="col text-left">
                                    <h6><small class="form-text text-muted">N° de caracteres: <strong
                                                id="cant_carac_inf_resultado" style="color: #000000;">0</strong></small>
                                    </h6>
                           </div>        
                        </div>                                
                    </div>                           
              </div>
              <div class="form-group row">
                  	<label class="col-sm-3 col-form-label">Facilitadores:</label>
                    <div class="col-sm-9">
                            <textarea maxlength="3000" onkeypress='return caracteres_especiales(event)'
                                onKeyUp="valTextAreaMatDivergencia2(this)" onKeyDown="valTextAreaMatDivergencia2(this)"
                                class="form-control mb-2" rows="5" id="inf_faqcilitadores"
                                name="inf_faqcilitadores"></textarea>
                        <div class="row">
                        	<div class="col">
                                    <h6><small class="form-text text-muted">Mínimo 3 y máximo 3000 caracteres.</small>
                                    </h6>
                           </div>
                           <div class="col text-left">
                                    <h6><small class="form-text text-muted">N° de caracteres: <strong
                                                id="cant_carac_inf_faqcilitadores"
                                                style="color: #000000;">0</strong></small></h6>
                           </div>        
                        </div>                                
                    </div>                           
              </div>  
              <div class="form-group row">
                  	<label class="col-sm-3 col-form-label">Obstaculizadores:</label>
                    <div class="col-sm-9">
                            <textarea maxlength="3000" onkeypress='return caracteres_especiales(event)'
                                onKeyUp="valTextAreaMatDivergencia2(this)" onKeyDown="valTextAreaMatDivergencia2(this)"
                                class="form-control mb-2" rows="5" id="inf_obstaculizaciones"
                                name="inf_obstaculizaciones"></textarea>
                        <div class="row">
                        	<div class="col">
                                    <h6><small class="form-text text-muted">Mínimo 3 y máximo 3000 caracteres.</small>
                                    </h6>
                           </div>
                           <div class="col text-left">
                                    <h6><small class="form-text text-muted">N° de caracteres: <strong
                                                id="cant_carac_inf_obstaculizaciones"
                                                style="color: #000000;">0</strong></small></h6>
                           </div>        
                    </div>   
                </div>
                    </div>   
              <div class="form-group row">
                  	<label class="col-sm-3 col-form-label">Aprendizajes:</label>
                    <div class="col-sm-9">
                            <textarea maxlength="3000" onkeypress='return caracteres_especiales(event)'
                                onKeyUp="valTextAreaMatDivergencia2(this)" onKeyDown="valTextAreaMatDivergencia2(this)"
                                class="form-control mb-2" rows="5" id="inf_aprendisaje"
                                name="inf_aprendisaje"></textarea>
                        <div class="row">
                        	<div class="col">
                                    <h6><small class="form-text text-muted">Mínimo 3 y máximo 3000 caracteres.</small>
                                    </h6>
                </div>
                           <div class="col text-left">
                                    <h6><small class="form-text text-muted">N° de caracteres: <strong
                                                id="cant_carac_inf_aprendisaje"
                                                style="color: #000000;">0</strong></small></h6>
                    </div>   
                </div>
</div>   
                </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardxarEjePkanEst()">Guardar</button>
              </div>
            </div>
          </div>
        </div>
<!-- INICIO DC -->
<!-- INCIO CZ SPRINT 56-->
<p id="msj_error_descInfPEC" style="font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar
    todos los campos para descargar el informe PEC.</p>
<!-- FIN CZ SPRINT 56-->
<a id="descInfPEC" style="display:none;" target="_blank"
    href="{{route('informe.plan.estrategico').'/'.$pro_an_id}}"><button type="button" class="btn btn-success"><i
            class="fa fa-file-excel-o"></i> Descargar informe PEC</button></a>

<button id="finPEC" type="button" style="margin-left:45%;display:none" class="btn btn-success" onclick="finalizarPec()">
    Finalizar Proceso</button>
<!-- FIN DC -->
<!-- FIN SECCION INFORME PLAN ESTRATEGICO  -->

<!-- INICIO SECCION PLAN ESTRATEGICO COMUNITARIO -->
<div class="card colapsable shadow-sm" id="contenedor_listar_plan">
    <a class="btn text-left p-0 collapsed" id="desplegar_listar_plan" data-toggle="collapse"
        data-target="#listar_bitacora" aria-expanded="false" aria-controls="listar_bitacora"
        onclick="if($(this).attr('aria-expanded') == 'false') mostrarBitacora();">
		<div class="card-header p-3">
			<h5 class="mb-0">
                <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i
                        class="fa fa-info"></i></button>
				Plan Estrategico Comunitario
			</h5>
		</div>
	</a>
	<div class="collapse" id="listar_plan">
		<div class="card-body">
			<input type="hidden" id="errorAct" value="0">
    		<div class="table-responsive">
                <table class="table table-striped table-hover w-100" cellspacing="0" id="tbl_plan_estrategico">
                    <thead>
                        <tr>
                        	<th>ID Prob</th>
                            <th>Problema Priorizadon</th>
                            <th>Objetivo</th>
                            <th>Resultado Esperado</th>
                            <th>Indicador</th>
                            <th>N° de Actividades Realizadas</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <a href="{{route('reporte.plan.estrategico').'/'.$pro_an_id}}"><button type="button"
                        class="btn btn-success"><i class="fa fa-file-excel-o"></i> Descargar Plan
                        Estrategico</button></a>
            </div>
            <button type="button" id="btn-etapa-plan-estrategico" class="btn btn-success btnEtapa"
                style="margin-left:30%" onclick="cambiarEstadoPlanEstrategico();">Ir a la siguiente etapa -
                <strong>Linea de salida</strong></button>
		</div>
		
	</div>
    <!-- INCIO CZ SPRINT 67 -->
    <div class="modal fade" id="PlanModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" data-backdrop="static" data-keyboard="false">
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
                                <textarea maxlength="3000" onkeypress='return caracteres_especiales(event)'
                                    onKeyUp="valTextAreaMatDivergencia2(this)"
                                    onKeyDown="valTextAreaMatDivergencia2(this)" class="form-control mb-2" rows="5"
                                    id="txt_plan_objetivo"></textarea>
                            <div class="row">
                            	<div class="col">
                                        <h6><small class="form-text text-muted">Mínimo 3 y máximo 3000
                                                caracteres.</small></h6>
                                </div>
                                <div class="col text-left">
                                        <h6><small class="form-text text-muted">N° de caracteres: <strong
                                                    id="cant_carac_txt_plan_objetivo"
                                                    style="color: #000000;">0</strong></small></h6>
                                </div>        
                            </div>
                                <p id="val_txt_plan_objetivo"
                                    style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Ingrese
                                    el Objetivo.</p>
                        </div>                           
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Resultado:</label>
                        <div class="col-sm-9">
                                <textarea maxlength="3000" onkeypress='return caracteres_especiales(event)'
                                    onKeyUp="valTextAreaMatDivergencia2(this)"
                                    onKeyDown="valTextAreaMatDivergencia2(this)" class="form-control mb-2" rows="5"
                                    id="txt_plan_resultados"></textarea>
                            <div class="row">
                            	<div class="col">
                                        <h6><small class="form-text text-muted">Mínimo 3 y máximo 3000
                                                caracteres.</small></h6>
                                </div>
                                <div class="col text-left">
                                        <h6><small class="form-text text-muted">N° de caracteres: <strong
                                                    id="cant_carac_txt_plan_resultados"
                                                    style="color: #000000;">0</strong></small></h6>
                                </div>        
                            </div>
                                <p id="val_txt_plan_resultados"
                                    style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Ingrese
                                    el Resultado.</p>
                        </div>                           
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Indicador:</label>
                        <div class="col-sm-9">
                                <textarea maxlength="3000" onkeypress='return caracteres_especiales(event)'
                                    onKeyUp="valTextAreaMatDivergencia2(this)"
                                    onKeyDown="valTextAreaMatDivergencia2(this)" class="form-control mb-2" rows="5"
                                    id="txt_plan_indicador"></textarea>
                            <div class="row">
                            	<div class="col">
                                        <h6><small class="form-text text-muted">Mínimo 3 y máximo 3000
                                                caracteres.</small></h6>
                                </div>
                                <div class="col text-left">
                                        <h6><small class="form-text text-muted">N° de caracteres: <strong
                                                    id="cant_carac_txt_plan_indicador"
                                                    style="color: #000000;">0</strong></small></h6>
                                </div>        
                            </div>
                                <p id="val_txt_plan_indicador"
                                    style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Ingrese
                                    el Indicador.</p>
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
    <div class="modal fade" id="PlanActividades" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" data-backdrop="static" data-keyboard="false">
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
                        <p id="msj_error" style="font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe
                            ingresar el Objetivo para ingresar Actividades.</p>
                    <div class="card colapsable shadow-sm">
                        <div class="card-header p-3">
                    			<h5 class="mb-0">
                    				Actividad (<span id="cont_act">0</span>)
                                    <button id="btnAddAct" type="button" class="btn btn-info" data-toggle="tooltip"
                                        data-placement="top" title="" style="float:right;" onclick="addAct()">Agregar
                                        Actividad</button>
                    			</h5>
                    		</div>
                    	<div class="collapse" style="display:block;">
                    		<div class="card-body">
                    		
                                    <table id="tblAct" class="table table-striped table-hover w-100" cellspacing="0"
                                        id="tbl_plan_estrategico">
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
                                                <textarea maxlength="3000"
                                                    onkeypress='return caracteres_especiales(event)'
                                                    onKeyUp="valTextAreaMatDivergencia2(this)"
                                                    onKeyDown="valTextAreaMatDivergencia2(this)"
                                                    class="form-control mb-2" rows="5"
                                                    id="txt_plan_actividad"></textarea>
                                            <div class="row">
                                            	<div class="col">
                                                        <h6><small class="form-text text-muted">Mínimo 3 y máximo 3000
                                                                caracteres.</small></h6>
                                                </div>
                                                <div class="col text-left">
                                                        <h6><small class="form-text text-muted">N° de caracteres:
                                                                <strong id="cant_carac_txt_plan_actividad"
                                                                    style="color: #000000;">0</strong></small></h6>
                                                </div>        
                                            </div>
                                                <p id="val_txt_plan_actividad"
                                                    style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">
                                                    * Ingrese la Actividad.</p>
                                        </div>                           
                                    </div>
                                <!-- INICIO DC SPRINT 67 -->
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Estrategia:</label>
                                        <div class="col-sm-9">
                                                <input type="checkbox" id="checkDifCap"> Actividades comunitarias de
                                                difusión y capacitación
                                        	<br>
                                        	<input type="checkbox" id="checkRelCom"> Relacionamiento Comunitario
                                        	<br>
                                        	<input type="checkbox" id="checkTallCom"> Talleres Comunitarios
                                        	<br>
                                        	<input type="checkbox" id="checkIniCom"> Iniciativa Comunitaria
                                        	<br>
                                                <input type="checkbox" id="checkOtro" onchange="getOtroEstrategia()">
                                                Otro
                                        	<br>
                                        	<input type="text" id="txtOtro" style="width: 80%;display:none">
                                                <p id="val_checkEstrategia"
                                                    style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">
                                                    * Debe seleccionar la Estrategia.</p>
                                                <p id="val_checkOtro"
                                                    style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">
                                                    * Debe ingresar una Estrategia.</p>
                                        </div>                           
                                    </div>
                                <!-- FIN DC SPRINT 67 -->    
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Metodologia:</label>
                                        <div class="col-sm-9">
                                                <textarea maxlength="3000"
                                                    onkeypress='return caracteres_especiales(event)'
                                                    onKeyUp="valTextAreaMatDivergencia2(this)"
                                                    onKeyDown="valTextAreaMatDivergencia2(this)"
                                                    class="form-control mb-2" rows="5"
                                                    id="txt_plan_metodologia"></textarea>
                                            <div class="row">
                                            	<div class="col">
                                                        <h6><small class="form-text text-muted">Mínimo 3 y máximo 3000
                                                                caracteres.</small></h6>
                                                </div>
                                                <div class="col text-left">
                                                        <h6><small class="form-text text-muted">N° de caracteres:
                                                                <strong id="cant_carac_txt_plan_metodologia"
                                                                    style="color: #000000;">0</strong></small></h6>
                                                </div>        
                                            </div>
                                                <p id="val_txt_plan_metodologia"
                                                    style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">
                                                    * Ingrese la Metodologia.</p>
                                        </div>                           
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Responsables:</label>
                                        <div class="col-sm-9">
                                                <textarea maxlength="3000"
                                                    onkeypress='return caracteres_especiales(event)'
                                                    onKeyUp="valTextAreaMatDivergencia2(this)"
                                                    onKeyDown="valTextAreaMatDivergencia2(this)"
                                                    class="form-control mb-2" rows="5"
                                                    id="txt_plan_responsables"></textarea>
                                            <div class="row">
                                            	<div class="col">
                                                        <h6><small class="form-text text-muted">Mínimo 3 y máximo 3000
                                                                caracteres.</small></h6>
                                                </div>
                                                <div class="col text-left">
                                                        <h6><small class="form-text text-muted">N° de caracteres:
                                                                <strong id="cant_carac_txt_plan_responsables"
                                                                    style="color: #000000;">0</strong></small></h6>
                                                </div>        
                                            </div>
                                                <p id="val_txt_plan_responsables"
                                                    style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">
                                                    * Ingrese los Responsables.</p>
                                        </div>                           
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Plazo:</label>
                                        <div class="col-sm-9">
                                        	<table>
                                        		<tr>
                                                        <td width="100"><input maxlength="3" id="txtPlazoPlan"
                                                                name="txtPlazoPlan"
                                                                onkeypress="return soloNumeros(event)" type="number"
                                                                max="100" min="1" class="form-control" onblur=""></td>
                                        			<td width="5"></td>
                                        			<td><span class="sem" style="float: left">Semanas</span></td>
                                        		</tr>
                                        	</table>
                                        	 
                                                <p id="val_txtPlazoPlan"
                                                    style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">
                                                    * Ingrese el Plazo.</p>
                                        </div>                           
                                    </div>                                    
                                        <button id="btnGuardarAct" type="button" class="btn btn-success"
                                            data-toggle="tooltip" data-placement="top" title=""
                                            onclick="guardarAct()">Agregar Actividad</button>
                                        <button id="btnEditAct" style="display:none;" type="button"
                                            class="btn btn-success" data-toggle="tooltip" data-placement="top" title=""
                                            onclick="editarAct()">Editar Actividad</button>
                                        <button type="button" class="btn btn-secondary" data-toggle="tooltip"
                                            data-placement="top" title="" onclick="volverAddAct()">Cancelar</button>
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

<!-- INICIO LINEA SALIDA -->
<div class="card colapsable shadow-sm" id="contenedor_listar_linea">
    <a class="btn text-left p-0 collapsed" id="desplegar_listar_linea" data-toggle="collapse"
        data-target="#listar_linea_salida" aria-expanded="false" aria-controls="listar_linea_salida"
        onclick="if($(this).attr('aria-expanded') == 'false') mostrarBitacora();">
		<div class="card-header p-3">
			<h5 class="mb-0">
                <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i
                        class="fa fa-info"></i></button>
                I. Linea Salida
			</h5>
		</div>
	</a>
    <div class="collapse" id="listar_linea_salida">
		<div class="card-body">
    <table class="table table-striped table-hover w-100" cellspacing="0" id="tabla_linea_salida">
        <thead>
            <tr>
                <th>RUT</th>
                <th>Nombre</th>
                <th>Edad</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>Linea Salida</th>
                <th>Descargar</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table><br>
        <!-- INICIO CZ SPRINT 70 -->
        @if($flag_linea == 1)
            <a class="btn btn-success" href="{{route('reporte.lineabase').'/'.$pro_an_id.'/2'}}"><i
                    class="fa fa-download"></i>Descargar Linea de Salida</a>
    @elseif($flag_linea == 2)
            <a class="btn btn-success" href="{{route('reporte.lineabase_2021').'/'.$pro_an_id.'/2'}}"><i
                    class="fa fa-download"></i>Descargar Linea de Salida</a>
    @endif
    <!-- FIN CZ SPRINT 70 -->
    <br>
            <button type="button" id="btn-etapa-linea-salida" disabled="" class="btn btn-success btnEtapa"
                style="margin-left:25%" onclick="cambiarEstadoPlanEstrategico();">Ir a la siguiente etapa -
                <strong>Informe Plan Estrategico Comunitario</strong></button>
</div>

<!-- INICIO CZ SPRINT 70 -->
@if($flag_linea == 1)
@includeif('gestor_comunitario.gestion_comunitaria.plan_estrategico.linea_salida.modal_linea_salida')
@elseif($flag_linea == 2)
@includeif('gestor_comunitario.gestion_comunitaria.plan_estrategico.linea_salida_2021.modal_linea_salida_2021')

@endif 
<!-- FIN CZ SPRINT 70 -->
<input id="lin_bas_id" type="hidden" value="">
<input id="lb_fas_id" type="hidden" value="">
<input id="accion" type="hidden" value="0">
<style type="text/css">
	.datatable_encabezado_lb{
		background-color: #e6f3fd;
    	text-align: center;
    	font-weight: 800;
    	text-transform: uppercase;
    	padding: 6px 0;
	}
</style>
		</div>

</div>
@if($flag_linea == 2)
    <div class="card colapsable shadow-sm" id="contenedor_encuesta_prercepcion">
        <a class="btn text-left p-0 collapsed" id="desplegar_encuesta_prercepcion" data-toggle="collapse" data-target="#listar_encuesta_prercepcion" aria-expanded="false" aria-controls="listar_encuesta_prercepcion" onclick="if($(this).attr('aria-expanded') == 'false');">
            <div class="card-header p-3">
                <h5 class="mb-0">
                    <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
                    &nbsp;&nbsp;II. Encuesta de percepción
                </h5>
            </div>
        </a>

        <div class="collapse" id="listar_encuesta_prercepcion">
            @includeif('gestor_comunitario.gestion_comunitaria.plan_estrategico.linea_salida_2021.encuesta_percepcion')
	</div>
    </div>
@endif
<!-- FIN LINEA SALIDA -->
<script>
    function cargar_doc_percepcion(parametro){
        var form = document.getElementById("adj_doc_percepcion");
        var formData = new FormData(form);
        formData.append('_token', $('input[name=_token]').val());
        formData.append('tipo_gestion', $('input[name=tipo_gestion]').val());
        formData.append('pro_an_id', $('input[name=pro_an_id]').val());
        formData.append('tipo', 9);
        var imgsize = document.getElementsByClassName(parametro)[0].files[0].size;
        if(imgsize > 4000000){
            //console.log("aqui");
            toastr.error('El archivo debe tener un peso maximo de 4.000 MB', {timeOut: 3000});
            desbloquearPantalla();
        }else{
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
                $.ajax({
                    url: '{{ route("percepcion.doc.cargar") }}',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        desbloquearPantalla();
                        if(response.estado = 1){
                            toastr.success(response.mensaje); 
                        }
                        obtener_doc_percepcion();
                    },
                    error: function(jqXHR, text, error){
                        desbloquearPantalla();
                        manejoPeticionesFailAjax(jqXHR, text, error);
                    }
            });
	    }
    }
	//INICIO DC SPRINT 67
	function getOtroEstrategia(){
		if($('#checkOtro').is(':checked')){
			$('#txtOtro').fadeIn(0);
			$('#txtOtro').val('');
			$('#txtOtro').focus();
		}else{
			$('#txtOtro').fadeOut(0);
		}
	}
	//FIN DC SPRINT 67

    function obtener_doc_percepcion(){
        console.log("aca, entro, obtener_doc_percepcion");
        let tabla_info_anexos = $('#tabla_doc_percepcion').DataTable();
        tabla_info_anexos.clear().destroy();

        let data = new Object();
        data.pro_an_id 	= {{$pro_an_id}};

        tabla_info_anexos = $('#tabla_doc_percepcion').DataTable({
            "language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
            "lengthChange": false,
            "info": 		false,
            "ajax": {
                "url": "{{ route('get.doc.percepcion') }}",
                "type": "GET",
                "data": data
            },
            "columnDefs": [
                { //FECHA DE CREACION
                    "targets": 0,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //NOMBRE DEL DOCUMENTO
                    "targets": 1,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //ACCIONES
                    "targets": 2,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                }
            ],				
            "columns": [
                        { //FECHA DE CREACION
                            "data": "created_at",
                            "className": "text-center"
                        },
                        { //NOMBRE DEL DOCUMENTO
                            "data": "doc_nom",
                            "className": "text-center"
                        },
                        { //ACCIONES
                            "data": "doc_nom",
                            "className": "text-center",
                            "render": function(data, type, row){
                                    // INICIO CZ SPRINT 67
                                    let html = `<a download href="${row.ruta}"><button type="button" class="btn btn-primary"><i class="fas fa-download"></i> Descargar</button></a><button type="button" class="btn btn-danger" OnClick="eliminarDocPer(${row.doc_gc_id},${row.pro_an_id})" data-toggle="modal" data-target="#eliminarDocPercepion" style="margin-left:5px">Eliminar</button>`;   
                                    // FIN CZ SPRINT 67
                                      //INICIO CZ SPRINT 67 correccion
                                      if($("#est_pro_id").val() == {{ config('constantes.finalizado') }} || $("#est_pro_id").val() == {{ config('constantes.desestimado') }} ){
                                            $('.btn-danger').attr('disabled', 'disabled');
                                        }
                                    //FIN CZ SPRINT 67 correccion  
                                        return html;
                                    }
                        }
                    ]
        });
    }

    function eliminarDocPer(id, pro_an_id){
        document.getElementById('btnConfimDocPercp').setAttribute('onclick','eliminarDocPercepcion('+id+','+pro_an_id+')');    
    }

    function eliminarDocPercepcion(id, pro_an_id){
        let data = new Object();
        data.id = id;
        data.id_pro_an_id = pro_an_id;
        $.ajaxSetup({
                    headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}
                });
        $.ajax({
                type:"post",
                url: "{{route('eliminarDocPercepion')}}",
                data: data
            }).done(function(resp){
                obtener_doc_percepcion();
                if(resp.estado == 1){
                    $('#eliminarDocPercepion').modal('hide');
                    toastr.success(resp.mensaje);    
                    
                }
               
            }).fail(function(objeto, tipoError, errorHttp){            
                obtener_doc_percepcion();
                manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

                return false;
            });
    }

	$(document).ready(function() {
		$('#info_fec_pri_con').datetimepicker('format', 'DD/MM/Y');
        $('#info_fec_ter_dpc').datetimepicker('format', 'DD/MM/Y');
		//Validar actividades
        let data3 = new Object();
		data3.pro_an_id = $("#pro_an_id").val();
        $.ajax({
        	type: "GET",
            url: "{{ route('get.plan.estrategico') }}",
            data: data3
        }).done(function(resp){ 
        	var datos = JSON.parse(resp);
            datos = datos.data;
            for (var i = 0; i < datos.length; i+=1) {
            	var id = datos[i].id;
                let data4 = new Object();
        		data4.idPlan = id;
        		$.ajax({
                	type: "GET",
                    url: "{{route('get.actividad.plan.estrategico')}}",
                    data: data4
                }).done(function(resp2){
                	var act = JSON.parse(resp2);
                    if(act.length == 0){
 						$( "#btn-etapa-plan-estrategico" ).attr('onclick', 'mensajeError()');
                    }            	
                }).fail(function(objeto, tipoError, errorHttp){
                	desbloquearPantalla();
                    manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
                    return false;
                });
            }
        }).fail(function(objeto, tipoError, errorHttp){
        	desbloquearPantalla();                
            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);                
            return false;
        });


	});
	function validaActividades(){
		//Validar actividades
        let data3 = new Object();
		data3.pro_an_id = $("#pro_an_id").val();
        $.ajax({
        	type: "GET",
            url: "{{ route('get.plan.estrategico') }}",
            data: data3
        }).done(function(resp){         	
        	var datos = JSON.parse(resp);
            datos = datos.data;
            if(datos.length > 0){
            	$( "#btn-etapa-plan-estrategico" ).attr('onclick', 'cambiarEstadoPlanEstrategico()');
            	for (var i = 0; i < datos.length; i+=1) {
            		var id = datos[i].id;
					if(id == null){
						$( "#btn-etapa-plan-estrategico" ).attr('onclick', 'mensajeError()');
					}else{
						let data4 = new Object();
                		data4.idPlan = id;
                		$.ajax({
                        	type: "GET",
                            url: "{{route('get.actividad.plan.estrategico')}}",
                            data: data4
                        }).done(function(resp2){
                        	var act = JSON.parse(resp2);
                            if(act.length == 0){
         						$( "#btn-etapa-plan-estrategico" ).attr('onclick', 'mensajeError()');
                            }            	
                        }).fail(function(objeto, tipoError, errorHttp){
                        	desbloquearPantalla();
                            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
                            return false;
                        });
					}
            	}
            }else{
            	$( "#btn-etapa-plan-estrategico" ).attr('onclick', 'mensajeError()');
            }
            
        }).fail(function(objeto, tipoError, errorHttp){
        	desbloquearPantalla();                
            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);                
            return false;
        });
	}
	function mensajeError(){	
		mensajeTemporalRespuestas(0, 'Debe ingresar al menos una actividad por objetivo.');
	}
	//FIN DC
	var actividad = [];
	// let cont_frm_div_per_com = "";
    function valTextAreaMatDivergencia2(input){
        num_caracteres_permitidos   = 3000;
      num_caracteres = $(input).val().length;

      
       if (num_caracteres > num_caracteres_permitidos){ 
            $(input).val(cont_frm_div_per_com);

       }else{ 
          cont_frm_div_per_com = $(input).val(); 
       }
       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_"+input.id).css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_"+input.id).css("color", "#000000");

       }       
       $("#cant_carac_"+input.id).text($(input).val().length);
    }
    //INICIO DC
    function finalizarPec(){
    	bloquearPantalla();
    	let data = new Object();
        data.pro_an_id = {{$pro_an_id}};
    	$.ajax({
        	type: "GET",
            url: "{{route('finalizar.pec')}}",
            data: data
        }).done(function(resp){
        	if(resp == 1){
        		mensajeTemporalRespuestas(1, 'El proceso ha finalizado');
        		$('#finPEC').attr('disabled', 'disabled');
        		$('#finPEC').text('Finalizado');
        	}else{
        		mensajeTemporalRespuestas(0, 'Ha ocurrido un error inesperado');
        	}
			desbloquearPantalla(); 
        }).fail(function(objeto, tipoError, errorHttp){
        	desbloquearPantalla();
            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
            return false;
        });
    }
    //FIN DC
    function guardxarEjePkanEst(){
    	var id = $('#idProb').val();
 		var resultado = $('#inf_resultado').val();
 		var Facilitadores = $('#inf_faqcilitadores').val();
 		var Obstaculizadores = $('#inf_obstaculizaciones').val();
 		var Aprendizajes = $('#inf_aprendisaje').val();
 		var error = 0;
 		var msj = '';
 		if(resultado == ''){
 			error = 1;
 			$("#inf_resultado").css("border-color", "#ff0000");
 			msj = msj + 'Debe ingresar el Resultado<br>';
 		}else{
 			$("#inf_resultado").css("border-color", "#d1d3e2");
 		}
 		if(Facilitadores == ''){
 			error = 1;
 			$("#inf_faqcilitadores").css("border-color", "#ff0000");
 			msj = msj + 'Debe ingresar los facilitadores<br>';
 		}else{
 			$("#inf_faqcilitadores").css("border-color", "#d1d3e2");
 		}
 		if(Obstaculizadores == ''){
 			error = 1;
 			$("#inf_obstaculizaciones").css("border-color", "#ff0000");
 			msj = msj + 'Debe ingresar los Obstaculizadores<br>';
 		}else{
 			$("#inf_obstaculizaciones").css("border-color", "#d1d3e2");
 		}
 		if(Aprendizajes == ''){
 			error = 1;
 			$("#inf_aprendisaje").css("border-color", "#ff0000");
 			msj = msj + 'Debe ingresar el Aprendizaje<br>';
 		}else{
 			$("#inf_aprendisaje").css("border-color", "#d1d3e2");
 		}
 		if(error != 0){
 		
 			mensajeTemporalRespuestas(0, msj);
 		}else{
 			bloquearPantalla();
 			var form = document.getElementById('frm_eje_pec');
 			var formData = new FormData(form);
 			formData.append('_token', $('input[name=_token]').val());
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
    		});
        	$.ajax({
                url: '{{ route("guardar.datos.pec") }}',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(resp) {
    				console.log(resp);
               if(resp == 1){
               	mensajeTemporalRespuestas(1, "Datos editados");	
               }else{
               mensajeTemporalRespuestas(0, "Ha ocurrido un error inesperado");	
              }
                desbloquearPantalla();
                },
    			error: function(jqXHR, text, error){
    				desbloquearPantalla();
    				console.log(error);
    			}
            });
 		}
    }
    function addActividades(idPlan){
    	bloquearPantalla();
    	//Se insertan actividades
        for(var i = 0; i < actividad.length; i++){
        	let data2 = new Object();
            data2.Actividad = actividad[i][1];
            data2.checkRelCom = actividad[i][6];
            data2.checkTallCom = actividad[i][7];
            data2.checkIniCom = actividad[i][8];
            data2.Metodologia = actividad[i][3];
            data2.Responsables = actividad[i][4];
            data2.Plazo = actividad[i][5];
            data2.idPlan = idPlan;
            $.ajax({
            	type: "GET",
                url: "{{route('edit.actividad.pe')}}",
                data: data2
            }).done(function(resp){
            	mensajeTemporalRespuestas(1, 'Se han guardado las actividades.');					  
    			$('#PlanActividades').modal('hide');
    			desbloquearPantalla();
            }).fail(function(objeto, tipoError, errorHttp){
                desbloquearPantalla();
                manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
                return false;
            });
        }
    }
    
    function cargarInformeAnexosPEC(){
    	bloquearPantalla(); 
        // INICIO CZ SPRINT 65
        // var form2 = document.getElementById("adj_doc_anexo_pec");
        var form2 = document.getElementById("adj_doc_anexo");
        // FIN CZ SPRINT 65
        var formData = new FormData(form2);
    	$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: "{{ route('cargar.documentosPEC') }}",
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        }).done(function(resp){
			if(resp == 1){
				mensajeTemporalRespuestas(1, "Se ha subido el archivo");	
				desplegarInfPlanEst();
			}else if(resp == -1){
				mensajeTemporalRespuestas(0, "Formato incorrecto");
			}else{
				mensajeTemporalRespuestas(0, "Ha ocurrido un error inesperado");
			}
			desbloquearPantalla();
        }).fail(function(objeto, tipoError, errorHttp){
            desbloquearPantalla();
            setTimeout(function(){ $("#alert-err-doc"+tipo).hide(); }, 5000);
            setTimeout(function(){ $("#alert-err-doc-ext"+tipo).hide(); }, 5000);

            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

            return false;
        });
        
    }
    //INICIO DC
    function registrarInformePE(){
    	bloquearPantalla();
        let data = new Object();
        var form = document.getElementById('frm_inf_pec');
        var formData = new FormData(form);
        formData.append('_token', $('input[name=_token]').val());
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
		});	
        $.ajax({
            url: '{{ route("guardar.informe.pe") }}',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(resp) {
				console.log(resp);
        	if(resp.estado == 1){
        		mensajeTemporalRespuestas(1, resp.mensaje);	
        		if($('#inf_nomGestorComCar').val() != '' && $('#inf_comuna').val() != '' && $('#inf_com_pri').val() != 0 && $('#info_fec_pri_con input').val() != '' && $('#info_fec_ter_dpc input').val() != '' && $('#info_intro').val() != '' && $('#info_result').val() != '' && $('#info_con_rec').val() != ''){
                    $("#msj_error_descInfPEC").css("display","none");
        			$('#descInfPEC').fadeIn(0);
        			$('#finPEC').fadeIn(0);
        		}else{
                    $("#msj_error_descInfPEC").css("display","block");
        			$('#descInfPEC').fadeOut(0);
        			$('#finPEC').fadeOut(0);
        		}
        	}else{
        		mensajeTemporalRespuestas(0, 'Ha ocurrido un error inesperado');	
        	}
        	desbloquearPantalla();
            },
			error: function(jqXHR, text, error){
        	desbloquearPantalla();
				console.log(error);
			}
        });
    }
    //FIN DC
    //INICIO DC SPRINT 67
    function updateActividades(idPlan){
    	bloquearPantalla();
		if(actividad.length == 0){
    		mensajeTemporalRespuestas(0, 'Debe ingresar actividades.');
    		desbloquearPantalla();
    	}else{
			//Se eliminan actividades
    		let data3 = new Object();
    		data3.idPlan = idPlan;
    		$.ajax({
            	type: "GET",
                url: "{{route('delete.actividad.pe')}}",
                data: data3
           }).done(function(resp1){
           		//Se insertan actividades
               	for(var i = 0; i < actividad.length; i++){
                	let data2 = new Object();
                    data2.Actividad = actividad[i][1];
                    data2.checkRelCom = actividad[i][6];
                    data2.checkTallCom = actividad[i][7];
                    data2.checkIniCom = actividad[i][8];
                    data2.Metodologia = actividad[i][3];
                    data2.Responsables = actividad[i][4];
                    data2.Plazo = actividad[i][5];
                    data2.ActComDifCap = actividad[i][9];
                    data2.otro = actividad[i][10];
                    data2.idPlan = resp1;
                    
                    $.ajax({
                    	type: "GET",
                        url: "{{route('edit.actividad.pe')}}",
                        data: data2
                    }).done(function(resp){
                    	console.log(resp);
                    	mensajeTemporalRespuestas(1, 'Se han guardado las actividades.');					  
    					$('#PlanActividades').modal('hide');
    					validaActividades();
                        // INICIO CZ SPRINT 67
						desplegarPlanEstCom();
						// FIN CZ SPRINT 67
    					desbloquearPantalla();
                    }).fail(function(objeto, tipoError, errorHttp){
                    	desbloquearPantalla();
                        manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
                        return false;
                    });
                }
                desbloquearPantalla();
           	}).fail(function(objeto, tipoError, errorHttp){
              		desbloquearPantalla();
                	manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
                    return false;
            });
    	}
    }
    
    function editarActividades(idProb, idPlan){
    	bloquearPantalla();  
    	$('#frmAddAct').fadeOut();
    	$('#tblAct').fadeIn();
    	$('#btnAddAct').html('Agregar Actividad');
    	$('#btnAddAct').attr('onclick', 'addAct()');
    	actividad.length = 0;
    	actualizaTablaAct();
    	if(idPlan == null){
    		$('#btnGuardarEditarAct').attr('disabled', 'disabled');
    		$('#msj_error').fadeIn(0);
    		desbloquearPantalla();
    	}else{    
    		$('#btnGuardarEditarAct').removeAttr('disabled');	
    		$('#btnGuardarEditarAct').attr('onClick', 'updateActividades('+idPlan+')');
    		$('#msj_error').fadeOut(0);	
    		let data2 = new Object();
        	data2.idPlan = idPlan;
        	$.ajax({
            	type: "GET",
            	url: "{{route('get.actividad.plan.estrategico')}}",
            	data: data2
            }).done(function(resp2){
            	var datos = JSON.parse(resp2);
            	if(datos.length > 0){        				
            		for (var i = 0; i < datos.length; i+=1) {
            			var estrategia = '';
            			if(datos[i].act_checkrelcom == 1){
                        	estrategia = estrategia + '- Relacionamiento Comunitario<br>';
                        }
                        if(datos[i].act_checktallcom == 1){
                        	estrategia = estrategia + '- Talleres Comunitarios<br>';
                        }
                        if(datos[i].act_checkinicom == 1){
                        	estrategia = estrategia + '- Iniciativa Comunitaria<br>';
                        }
                        if(datos[i].act_checkcomdifcap == 1){
                        	estrategia = estrategia + '- Actividades comunitarias de difusion y capacitacion<br>';
                        }
						//INICIO DC SPRINT 67
                        if(datos[i].act_checkotros != '' && datos[i].act_checkotros != null){
                        	estrategia = estrategia + '- Otros: '+datos[i].act_checkotros+'<br>';
                        }
						//FIN DC SPRINT 67
                        actividad.push([
                        	actividad.length + 1,
                            datos[i].act_nombre, 
                            estrategia,
                            datos[i].act_metodologia, 
                            datos[i].act_responsables,
                            datos[i].act_plazo,
                            datos[i].act_checkrelcom, 
                            datos[i].act_checktallcom,
                            datos[i].act_checkinicom,
                            datos[i].act_checkcomdifcap,
                            datos[i].act_checkotros
                        ]);
                        console.log(actividad);
                    }
                    actualizaTablaAct();
            	}
            	desbloquearPantalla();
            }).fail(function(objeto, tipoError, errorHttp){
            	desbloquearPantalla();
                manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
                return false;
            });
    	}
    	//INICIO DC
    	if('{{ Session::get('perfil') }}' == 2){
    		$('#btnAddAct').attr('disabled', 'disabled'); 
    		$('#btnGuardarEditarAct').attr('disabled', 'disabled');
    	}
    	//FIN DC   
    	$('#PlanActividades').modal('show');
    }
    
    function guardarAct(){
    	var Actividad = $('#txt_plan_actividad').val();
    	var Metodologia = $('#txt_plan_metodologia').val();
    	var Responsables = $('#txt_plan_responsables').val();
    	var Plazo = $('#txtPlazoPlan').val();
    	var error = 0;
    	if(Actividad == ''){
    		$("#txt_plan_actividad").css("border-color", "#ff0000");
    		$('#val_txt_plan_actividad').fadeIn(200);
    		mensajeTemporalRespuestas(0, 'Ingrese la Actividad.');
    		error = 1; 
    	}else{
    		$("#txt_plan_actividad").css("border-color", "#d1d3e2");
    		$('#val_txt_plan_actividad').fadeOut(200); 
    	}
    	if(Metodologia == ''){
    		$("#txt_plan_metodologia").css("border-color", "#ff0000");
    		$('#val_txt_plan_metodologia').fadeIn(200);
    		mensajeTemporalRespuestas(0, 'Ingrese la Metodologia.'); 
    		error = 1;
    	}else{
    		$("#txt_plan_metodologia").css("border-color", "#d1d3e2");
    		$('#val_txt_plan_metodologia').fadeOut(200); 
    	}
    	if(Responsables == ''){
    		$("#txt_plan_responsables").css("border-color", "#ff0000");
    		$('#val_txt_plan_responsables').fadeIn(200); 
    		mensajeTemporalRespuestas(0, 'Ingrese los Responsables.'); 
    		error = 1;
    	}else{
    		$("#txt_plan_responsables").css("border-color", "#d1d3e2");
    		$('#val_txt_plan_responsables').fadeOut(200); 
    	}
    	if(Plazo == ''){
    		$("#txtPlazoPlan").css("border-color", "#ff0000");
    		$('#val_txtPlazoPlan').fadeIn(200); 
    		mensajeTemporalRespuestas(0, 'Ingrese el Plazo.'); 
    		error = 1;
    	}else{
    		if(Plazo > 16){
    			$("#txtPlazoPlan").css("border-color", "#ff0000");
    			mensajeTemporalRespuestas(0, 'El plazo maximo es de 16 semanas.');
    			error = 1;
    		}else{
    			$("#txtPlazoPlan").css("border-color", "#d1d3e2");
    			$('#val_txtPlazoPlan').fadeOut(200); 
    		}    		
    	}
		if (!$('#checkRelCom').is(':checked') && !$('#checkTallCom').is(':checked') && !$('#checkIniCom').is(':checked') && !$('#checkDifCap').is(':checked') && !$('#checkOtro').is(':checked')) {
            error = 1;
            $('#val_checkEstrategia').fadeIn(200);
            mensajeTemporalRespuestas(0, 'Debe seleccionar la Estrategia.');
        }else{
        	$('#val_checkEstrategia').fadeOut(200);
        }
        if($('#checkOtro').is(':checked')){	
        	if($('#txtOtro').val() == ''){
        		error = 1;
        		$('#val_checkOtro').fadeIn(200);
            	mensajeTemporalRespuestas(0, 'Debe seleccionar la Estrategia.');
            	$("#txtOtro").css("border-color", "#ff0000");
        	}else{
        		$('#val_checkOtro').fadeOut(200);
        		$("#txtOtro").css("border-color", "#d1d3e2");
        	}
        }
        
        if(error == 0){
            var estrategia = '';
            var checkDifCap = 0;
            var checkRelCom = 0;
            var checkTallCom = 0;
            var checkIniCom = 0;
            var checkOtro = 0;
            if($('#checkDifCap').is(':checked')){
            	estrategia = estrategia + '- Actividades comunitarias de difusion y capacitacion<br>';
            	checkDifCap = 1;
            }
            if($('#checkRelCom').is(':checked')){
            	estrategia = estrategia + '- Relacionamiento Comunitario<br>';
            	checkRelCom = 1;
            }
            if($('#checkTallCom').is(':checked')){
            	estrategia = estrategia + '- Talleres Comunitarios<br>';
            	checkTallCom = 1;
            }
            if($('#checkIniCom').is(':checked')){
            	estrategia = estrategia + '- Iniciativa Comunitaria<br>';
            	checkIniCom = 1;
            }
            if($('#checkOtro').is(':checked')){
            	estrategia = estrategia + '- Otro: '+$('#txtOtro').val()+'<br>';
            	checkOtro = 1;
            }
        	actividad.push([
        		actividad.length + 1,
        		Actividad, 
        		estrategia,
        		Metodologia, 
        		Responsables,
        		Plazo,
        		checkRelCom, 
        		checkTallCom,
        		checkIniCom,
        		checkDifCap,
        		$('#txtOtro').val()
        	]);
        	mensajeTemporalRespuestas(1, 'Actividad Agregada (Presione "Guardar" para aplicar cambios).');
        	volverAddAct();
        }
    }
    //FIN DC SPRINT 67
    function actualizaTablaAct(){    	
    	$('#tblAct tbody').html('');
    	var cont = 0;
    	for(var i = 0; i < actividad.length; i++){
    		cont++;    			
    		var id = actividad[i][0];
        	var Actividad = actividad[i][1];
        	var Estrategia = actividad[i][2];
        	var Metodologia = actividad[i][3];
        	var Responsables = actividad[i][4];
        	var Plazo = actividad[i][5];
        	//INICIO DC
            // INICIO CZ SPRINT 67
            if($("#est_pro_id").val() == {{ config('constantes.finalizado') }} || $("#est_pro_id").val() == {{ config('constantes.desestimado') }} ){
                $('#tblAct tbody').append('<tr>'+
        	'<td>'+Actividad+'</td>'+
        	'<td>'+Estrategia+'</td>'+
        	'<td>'+Metodologia+'</td>'+
        	'<td>'+Responsables+'</td>'+
        	'<td>'+Plazo+'</td>'+
        	'<td>'+
        		'<button onclick="editAct('+id+')" type="button" class="btn btn-primary btnEditarAct">Editar</button><br>'+
        		'<button disabled onclick="delAct('+id+')" type="button" class="btn btn-danger btnQuitarAct">Quitar</button></td>'+
        	'</td>'+
        	'</tr>');
            }else{
                // FIN CZ SPRINT 67
        	$('#tblAct tbody').append('<tr>'+
        	'<td>'+Actividad+'</td>'+
        	'<td>'+Estrategia+'</td>'+
        	'<td>'+Metodologia+'</td>'+
        	'<td>'+Responsables+'</td>'+
        	'<td>'+Plazo+'</td>'+
        	'<td>'+
        		'<button onclick="editAct('+id+')" type="button" class="btn btn-primary btnEditarAct">Editar</button><br>'+
        		'<button onclick="delAct('+id+')" type="button" class="btn btn-danger btnQuitarAct">Quitar</button></td>'+
        	'</td>'+
        	'</tr>');
            }
    	}
    	if('{{ Session::get('perfil') }}' == 2){
    		$('.btnEditarAct').attr('disabled', 'disabled');
    		$('.btnQuitarAct').attr('disabled', 'disabled');
    	}
    	//FIN DC
    	$('#cont_act').html(cont);
    }
    //INICIO DC SPRINT 67
    function editarAct(){
    	var id = $('#idAct').val();
    	var Actividad = $('#txt_plan_actividad').val();
    	var Metodologia = $('#txt_plan_metodologia').val();
    	var Responsables = $('#txt_plan_responsables').val();
    	var Plazo = $('#txtPlazoPlan').val();
    	var estrategia = '';
        var checkRelCom = 0;
        var checkTallCom = 0;
        var checkIniCom = 0;
        var checkActComDifCap = 0;
        var checkOtros = 0;
        var error = 0;
        if(Actividad == ''){
        	mensajeTemporalRespuestas(0, 'Ingrese la Actividad.');
    		$("#txt_plan_actividad").css("border-color", "#ff0000");
    		$('#val_txt_plan_actividad').fadeIn(200);
    		error = 1; 
    	}else{
    		$("#txt_plan_actividad").css("border-color", "#d1d3e2");
    		$('#val_txt_plan_actividad').fadeOut(200); 
    	}
    	if(Metodologia == ''){
    		mensajeTemporalRespuestas(0, 'Ingrese la Metodologia.');
    		$("#txt_plan_metodologia").css("border-color", "#ff0000");
    		$('#val_txt_plan_metodologia').fadeIn(200); 
    		error = 1;
    	}else{
    		$("#txt_plan_metodologia").css("border-color", "#d1d3e2");
    		$('#val_txt_plan_metodologia').fadeOut(200); 
    	}
    	if(Responsables == ''){
    		mensajeTemporalRespuestas(0, 'Ingrese los Responsables.');
    		$("#txt_plan_responsables").css("border-color", "#ff0000");
    		$('#val_txt_plan_responsables').fadeIn(200); 
    		error = 1;
    	}else{
    		$("#txt_plan_responsables").css("border-color", "#d1d3e2");
    		$('#val_txt_plan_responsables').fadeOut(200); 
    	}
    	if(Plazo == ''){
    		mensajeTemporalRespuestas(0, 'Ingrese el Plazo.');
    		$("#txtPlazoPlan").css("border-color", "#ff0000");
    		$('#val_txtPlazoPlan').fadeIn(200); 
    		error = 1;
    	}else{
    		if(Plazo > 16){
    			$("#txtPlazoPlan").css("border-color", "#ff0000");
    			mensajeTemporalRespuestas(0, 'El plazo maximo es de 16 semanas.');
    			error = 1;
    		}else{
    			$("#txtPlazoPlan").css("border-color", "#d1d3e2");
    			$('#val_txtPlazoPlan').fadeOut(200); 
    		}    		
    	}
    	if($('#checkOtro').is(':checked')){
    		if($("#txtOtro").val() == ''){
    			$("#txtOtro").css("border-color", "#ff0000");
    			mensajeTemporalRespuestas(0, 'Debe ingresar la Estrategia.');
    			error = 1;
    		}else{
    			$("#txtOtro").css("border-color", "#d1d3e2");
    		}
    	}
    	if (!$('#checkRelCom').is(':checked') && !$('#checkTallCom').is(':checked') && !$('#checkIniCom').is(':checked') && !$('#checkDifCap').is(':checked') && !$('#checkOtro').is(':checked')) {
            error = 1;
            $('#val_checkEstrategia').fadeIn(200);
            mensajeTemporalRespuestas(0, 'Debe seleccionar la Estrategia.');
        }else{
        	$('#val_checkEstrategia').fadeOut(200);
        }
    	if(error == 0){
    		if($('#checkRelCom').is(':checked')){
            	estrategia = estrategia + '- Relacionamiento Comunitario<br>';
                checkRelCom = 1;
            }
            if($('#checkTallCom').is(':checked')){
            	estrategia = estrategia + '- Talleres Comunitarios<br>';
                checkTallCom = 1;
            }
            if($('#checkIniCom').is(':checked')){
            	estrategia = estrategia + '- Iniciativa Comunitaria<br>';
                checkIniCom = 1;
            }
            if($('#checkDifCap').is(':checked')){
            	estrategia = estrategia + '- Actividades comunitarias de difusion y capacitacion<br>';
                checkActComDifCap = 1;
            }
            if($('#checkOtro').is(':checked')){
            	estrategia = estrategia + '- Otro: '+$('#txtOtro').val()+'<br>';
                checkOtros = 1;
            }else{
            	$('#txtOtro').val('');
            }
        	for(var i = 0; i < actividad.length; i++){
        		if(actividad[i][0] == id){
        			actividad[i][1] = Actividad;
            		actividad[i][2] = estrategia;
            		actividad[i][3] = Metodologia;
            		actividad[i][4] = Responsables;
            		actividad[i][5] = Plazo;
            		actividad[i][6] = checkRelCom;
            		actividad[i][7] = checkTallCom;
            		actividad[i][8] = checkIniCom;
            		actividad[i][9] = checkActComDifCap;
            		actividad[i][10] = $('#txtOtro').val();
            		volverAddAct();
            		mensajeTemporalRespuestas(1, 'Actividad Editada (Presione "Guardar" para aplicar cambios).');
        		}
        	}
    	}
        
    }
    
    function editAct(id){
    	$('#idAct').val(id);
    	$('#btnEditAct').fadeIn(0);
    	$('#btnGuardarAct').fadeOut(0);
    	$('#tblAct').fadeOut(0);
    	$('#frmAddAct').fadeIn(100);
    	$('#btnAddAct').html('Volver');
    	$('#btnAddAct').attr('onclick', 'volverAddAct()');
    	$('#txt_plan_actividad').val('');
    	$("#checkRelCom").prop("checked", false);
    	$("#checkTallCom").prop("checked", false);
    	$("#checkIniCom").prop("checked", false);
    	$('#txt_plan_metodologia').val('');
    	$('#txt_plan_responsables').val('');
    	$('#txtPlazoPlan').val('');
    	$("#txt_plan_actividad").css("border-color", "#d1d3e2");
    	$('#val_txt_plan_actividad').fadeOut(0);
    	$('#val_checkEstrategia').fadeOut(0);	
    	$("#txt_plan_metodologia").css("border-color", "#d1d3e2");
    	$('#val_txt_plan_metodologia').fadeOut(0);	
    	$("#txt_plan_responsables").css("border-color", "#d1d3e2");
    	$('#val_txt_plan_responsables').fadeOut(0);
    	$("#txtPlazoPlan").css("border-color", "#d1d3e2");
    	$('#val_txtPlazoPlan').fadeOut(0);	
    	for(var i = 0; i < actividad.length; i++){
    		if(actividad[i][0] == id){
    			$('#txt_plan_actividad').val(actividad[i][1]);
    			if(actividad[i][6] == 1){
    				$("#checkRelCom").prop("checked", true);
    			}else{
    				$("#checkRelCom").prop("checked", false);
    			}
    			if(actividad[i][7] == 1){
    				$("#checkTallCom").prop("checked", true);
    			}else{
    				$("#checkTallCom").prop("checked", false);
    			}
    			if(actividad[i][8] == 1){
    				$("#checkIniCom").prop("checked", true);
    			}else{
    				$("#checkIniCom").prop("checked", false);
    			}
    			if(actividad[i][9] == 1){
    				$("#checkDifCap").prop("checked", true);
    			}else{
    				$("#checkDifCap").prop("checked", false);
    			}
    			if(actividad[i][10] != '' && actividad[i][10] != null){
					$('#txtOtro').fadeIn(0);
    				$('#txtOtro').val(actividad[i][10]);
    				$("#checkOtro").prop("checked", true);
    			}else{
    				$('#txtOtro').fadeOut(0);
    				$('#txtOtro').val('');
    				$("#checkOtro").prop("checked", false);
    			}
    			
    			$('#txt_plan_metodologia').val(actividad[i][3]);
    			$('#txt_plan_responsables').val(actividad[i][4]);
    			$('#txtPlazoPlan').val(actividad[i][5]);
    			calculaCaracteres('txt_plan_actividad');
    			calculaCaracteres('txt_plan_metodologia');
    			calculaCaracteres('txt_plan_responsables');
    		}
    	}
    }
    //FIN DC SPRINT 67
    function delAct(id){
    	for(var i = 0; i < actividad.length; i++){
    		if(actividad[i][0] == id){
				actividad.splice( i, 1 );
    			mensajeTemporalRespuestas(1, 'Actividad eliminada (Presione "Guardar" para aplicar cambios").');
    		}
    	}
    	console.log(actividad);
    	actualizaTablaAct();
    }
    
    function addAct(){
    	$('#btnGuardarAct').fadeIn(0);
    	$('#btnEditAct').fadeOut(0);
    	$('#tblAct').fadeOut(0);
    	$('#frmAddAct').fadeIn(100);
    	$('#btnAddAct').attr('onclick', 'volverAddAct()');
    	$('#btnAddAct').html('Volver');
    	$('#txt_plan_actividad').val('');
    	$("#checkRelCom").prop("checked", false);
    	$("#checkTallCom").prop("checked", false);
    	$("#checkIniCom").prop("checked", false);
    	$('#txt_plan_metodologia').val('');
    	$('#txt_plan_responsables').val('');
    	$('#txtPlazoPlan').val('');
    	//INICIO DC SPRINT 67
    	$("#checkDifCap").prop("checked", false);
    	$("#checkOtro").prop("checked", false);
    	$('#txtOtro').fadeOut(0);
    	$('#txtOtro').val('');
    	//FIN DC SPRINT 67
    	calculaCaracteres('txt_plan_actividad');
    	calculaCaracteres('txt_plan_metodologia');
    	calculaCaracteres('txt_plan_responsables');
    	$("#txt_plan_actividad").css("border-color", "#d1d3e2");
    	$('#val_txt_plan_actividad').fadeOut(0);
    	$('#val_checkEstrategia').fadeOut(0);	
    	$("#txt_plan_metodologia").css("border-color", "#d1d3e2");
    	$('#val_txt_plan_metodologia').fadeOut(0);	
    	$("#txt_plan_responsables").css("border-color", "#d1d3e2");
    	$('#val_txt_plan_responsables').fadeOut(0);
    	$("#txtPlazoPlan").css("border-color", "#d1d3e2");
    	$('#val_txtPlazoPlan').fadeOut(0);	
    }
    
    function volverAddAct(){
    	$('#frmAddAct').fadeOut(0);
    	$('#tblAct').fadeIn(100);
    	$('#btnAddAct').html('Agregar Actividad');
    	$('#btnAddAct').attr('onclick', 'addAct()');
    	actualizaTablaAct();
    }
    
    function editPlanEstrategico(){
    	var idProb = $('#idProb').val();
    	var idPlan = $('#idPlan').val();
    	var Objetivo = $('#txt_plan_objetivo').val();    	
    	var Resultado = $('#txt_plan_resultados').val();
    	var Indicador = $('#txt_plan_indicador').val();
    	var error = 0;
    	if(Objetivo == ''){
    		$("#txt_plan_objetivo").css("border-color", "#ff0000"); 
    		$('#val_txt_plan_objetivo').fadeIn(200);
    		error = 1;
    	}else{
    		$("#txt_plan_objetivo").css("border-color", "#d1d3e2");
    		$('#val_txt_plan_objetivo').fadeOut(200);
    	}    	
    	if(Resultado == ''){
    		$("#txt_plan_resultados").css("border-color", "#ff0000");
    		$('#val_txt_plan_resultados').fadeIn(200); 
    		error = 1;
    	}else{
    		$("#txt_plan_resultados").css("border-color", "#d1d3e2");
    		$('#val_txt_plan_resultados').fadeOut(200); 
    	}
    	if(Indicador == ''){
    		$("#txt_plan_indicador").css("border-color", "#ff0000");
    		$('#val_txt_plan_indicador').fadeIn(200); 
    		error = 1;
    	}else{
    		$("#txt_plan_indicador").css("border-color", "#d1d3e2");
    		$('#val_txt_plan_indicador').fadeOut(200); 
    	}    	
    	if(error == 0){
    		bloquearPantalla();
    		let data = new Object();
    		data.idProb = idProb;
    		data.idPlan = idPlan;
			data.Objetivo = Objetivo;
			data.Resultado = Resultado;
			data.Indicador = Indicador;
		  	$.ajax({
    			type: "GET",
    			url: "{{route('edit.plan.estrategico')}}",
    			data: data
    		}).done(function(resp){
    			mensajeTemporalRespuestas(1, 'Se ha guardado el Plan Estrategico Comunitario.');					  
    			$('#PlanModal').modal('hide');
    			desplegarPlanEstCom();	
    			desbloquearPantalla();
    		}).fail(function(objeto, tipoError, errorHttp){
    			desbloquearPantalla();
                manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
                return false;
            });
    	}
    }
    
    function guardarPlanEstrategico(){
    	bloquearPantalla();
    	var idProb = $('#idProb').val();
    	var Objetivo = $('#txt_plan_objetivo').val();
    	var Resultado = $('#txt_plan_resultados').val();
    	var Indicador = $('#txt_plan_indicador').val();
    	var error = 0;
    	if(Objetivo == ''){
    		$("#txt_plan_objetivo").css("border-color", "#ff0000"); 
    		$('#val_txt_plan_objetivo').fadeIn(200);
    		error = 1;
    	}else{
    		$("#txt_plan_objetivo").css("border-color", "#d1d3e2");
    		$('#val_txt_plan_objetivo').fadeOut(200);
    	}
    	if(Resultado == ''){
    		$("#txt_plan_resultados").css("border-color", "#ff0000");
    		$('#val_txt_plan_resultados').fadeIn(200); 
    		error = 1;
    	}else{
    		$("#txt_plan_resultados").css("border-color", "#d1d3e2");
    		$('#val_txt_plan_resultados').fadeOut(200); 
    	}
    	if(Indicador == ''){
    		$("#txt_plan_indicador").css("border-color", "#ff0000");
    		$('#val_txt_plan_indicador').fadeIn(200); 
    		error = 1;
    	}else{
    		$("#txt_plan_indicador").css("border-color", "#d1d3e2");
    		$('#val_txt_plan_indicador').fadeOut(200); 
    	}
    	if(error == 0){
    		let data = new Object();
    		data.idProb = idProb;
			data.Objetivo = Objetivo;
			data.Resultado = Resultado;
			data.Indicador = Indicador;
		  	$.ajax({
    			type: "GET",
    			url: "{{route('plan.estrategico')}}",
    			data: data
    		}).done(function(resp){
    			mensajeTemporalRespuestas(1, 'Se ha guardado el Plan Estrategico Comunitario.');					  
    			$('#PlanModal').modal('hide');
    			desplegarPlanEstCom();	    			
    			desbloquearPantalla();
    		}).fail(function(objeto, tipoError, errorHttp){
    				desbloquearPantalla();
                    manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
                    return false;
            });
    	}else{
    		desbloquearPantalla();
    	}
    }
    let respuestaPreguntas2 = new Array();

    function listarPreguntas2(opcion,id=''){

        $("#lin_bas_id").val(id);
        $("#accion").val(opcion);

        respuestaPreguntas2.length = 0;
        $("#identificacion2").collapse('show');
        $("#servicio_prestaciones2").collapse('hide');
        $("#organizacion_comunitaria2").collapse('hide');
        $("#derecho_part_nna2").collapse('hide');
        listaPreServiciosLs();
        listaPreProgramasLs();
        listaPreServicios2Ls();
        listaPreBienesLs();
        listaPreOrganizacionesLs();
        listaPreParticipacionLs();

        $('#linea_rut2').rut({
			fn_error: function(input){
				if (input.val() != ''){
					$('#linea_rut2').attr("data-val-run", false);
                    mensajeTemporalRespuestas(0, "* RUN Inválido.");
					$("#val_linea_rut2").show();
				}
			},
			fn_validado: function(input){
				$('#linea_rut2').attr("data-val-run", true);
				$("#val_linea_rut2").hide();

                autoCompletarNombre();

			}
		});
    }
    // INICIO CZ SPRINT 70
    @if($flag_linea == 1)
    function listarLineaSalida(){

        let tabla_linea_salida = $('#tabla_linea_salida').DataTable();

        tabla_linea_salida.clear().destroy();

        let data = new Object();
		data.pro_an_id 	= {{$pro_an_id}};

        tabla_linea_salida = $('#tabla_linea_salida').DataTable({
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			"ordering": 	false,
			"lengthChange": false,
			"info": 		false,
            // INICIO CZ SPRINT 67
			"searching": 	true,
            // FIN CZ SPRINT 67
			"paging":   	false,
			"ajax": {
    			"url": "{{ route('listar.linea.salida') }}",
    			"type": "GET",
				"data": data
  			},
			"columnDefs": [
            	{ //RUT
					"targets": 0,
					"className": 'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
				{ //NOMBRES
					"targets": 1,
					"className": 'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
                { //EDAD
					"targets": 2,
					"className": 'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
                { //TELEFONO
					"targets": 3,
					"className": 'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
                { //CORREO
					"targets": 4,
					"className": 'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
                { //LLINEA DE SALIDA inicio ch
					"targets": 5,
					"className": 'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},//fin ch
                { //DESCARGAR inicio ch
					"targets": 6,
					"className": 'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				}
				}//fin ch
    		],				
			"columns": [
						{ //RUT
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
							"className": "text-center"
						},
						{ //CORREO
							"data": "lin_bas_cor",
							"className": "text-center"
						},
						{ //LINEA SALIDA
							"data": "lin_bas_id",
							"className": "text-center",
                            "render": function(data, type, row){
                                    let html ='';
                                    if( row.lb_fas_id == 2){
                                        //html+= ' <button type="button" class="btn btn-danger" onclick="eliminarLineaBase('+data+')"><i class=""></i>  <b>Eliminar</b></button>';
										
                                        html = '<p class="text-success"><b><i class="fas fa-check-circle"></i>Linea Salida</b></p>';
									}else{
										html = '<button type="button" class="btn btn-outline-success" onclick="editarLineaSalida('+data+');limpiarfrmValidadiones();"><i class="fa fa-plus-circle"></i> <b>Linea Salida</b></button>';
                                    }
                                    return html;
                            }
						},
                        { //Descargar INICIO CH
							"data": "lin_bas_id",
							"className": "text-center",
                            "render": function(data, type, row){
                                    let html ='';
                                    
                                    if( row.lb_fas_id == 2){
                                        
                                        html = '<button type="button" class="btn btn-primary" onclick="descargarLineaSalida('+data+');limpiarfrmValidadiones();"><i class="fa fa-download"></i> <b>Descargar</b></button>';
                                    }else{
                                        html = '<button type="button" class="btn btn-primary disabled" disabled="true" onclick="descargarLineaSalida('+data+');limpiarfrmValidadiones();"><i class="fa fa-download"></i> <b>Descargar</b></button>';
                                    }
										return html;
						    }
						}// FIN CH
					]
		});
    }
    @endif
     // FIN CZ SPRINT 70
    function descargarLineaSalida(id){
        window.open( `/descargarLineaSalida/${id}`, '_blank');
    }


    function agregarRepuestaLineaSalida(tipo, id, opcion = ''){
            
        respuestaPreguntas2[opcion+id]          = Object();
        respuestaPreguntas2[opcion+id].id        = id;
        respuestaPreguntas2[opcion+id].tipo     = tipo;
        if($("#preg11_"+opcion+id).prop('checked')){
            respuestaPreguntas2[opcion+id].resp11  = 1;
        }else{
            respuestaPreguntas2[opcion+id].resp11  = 0;
        }

        if($("#preg21_"+opcion+id).prop('checked')){
            respuestaPreguntas2[opcion+id].resp21  = 1;
        }else{
            respuestaPreguntas2[opcion+id].resp21  = 0;
        }

        if(tipo == 4){
            if($("#preg31_"+id).prop('checked')){
                respuestaPreguntas2[id].resp31  = 1;
            }else{
                respuestaPreguntas2[id].resp31  = 0;
            }
        }else{
            respuestaPreguntas2[opcion+id].resp31  = 0;
        }        


    }

    function recolectarSelLineaSalida(){

        let data = new Object();

        data.preguntas = respuestaPreguntas2;
        data.ser_niv_com2    = $("#ser_niv_com2").val();
        data.ser_pro_soc2    = $("#ser_pro_soc2").val();
        data.ser_ser_sec2    = $("#ser_ser_sec2").val();
        data.bie_com2        = $("#bie_com2").val();
        data.bien_org_otr2   = $("#bien_org_otr2").val();
        data.bien_org_part2  = $("#bien_org_part2").val();
        
        return data;
    }

    function guardarLineaSalida(){

        let respuesta2 = validarfrmIdentificacionLS();
        console.log(respuesta2);
        if(!respuesta2){
            $("#identificacion2").collapse('hide');
            $("#servicio_prestaciones2").collapse('hide');
            $("#organizacion_comunitaria2").collapse('hide');
            $("#derecho_part_nna2").collapse('hide');
            mensaje = "Faltaron Campos Por Responder";
            mensajeTemporalRespuestas(0, mensaje);
            return false;
        }

        respuesta2 = verificarfrmDerechoParticipacionLs();
        if(!respuesta2){
            $("#derecho_part_nna2").collapse('show');
            $("#identificacion2").collapse('hide');
            $("#servicio_prestaciones2").collapse('hide');
            $("#organizacion_comunitaria2").collapse('hide');
            mensaje = "Completar Derechos y Participacion NNA";
            mensajeTemporalRespuestas(0, mensaje);
            return false;
        }

        bloquearPantalla();

        let data = new Object();

        data.lin_bas_id = $("#lin_bas_id").val();
        data.iden       = recolectarDataIdentificacionLS();
        data.preg       = recolectarSelLineaSalida();
        data.part       = recolectarfrmDerechoParticipacionLs();
        data.pro_an_id  = {{$pro_an_id}};
        
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });

        $.ajax({
            type: "POST",
            url: "{{route('guardar.linea.salida')}}",
            data: data
        }).done(function(resp){
            
            if(resp.estado == 1){
                mensajeTemporalRespuestas(1, resp.mensaje);
                listarLineaBase(); 
                listarLineaSalida();
                //$('#tabla_linea_base').DataTable().ajax.reload();
            }

            if(resp.estado == 0){
                mensajeTemporalRespuestas(0, resp.mensaje);
            }
            $('#frmlineabase2').modal('hide');
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
                $('#tabla_linea_salida').DataTable().ajax.reload();
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

    function editarLineaSalida(id){
        $("#btn_lb_guardar").show();
        listarPreguntas2(1,id);
        getDataIdentificacionLs(id);
        $('#frmlineabase2').modal('show');


    }
    //INICIO DC
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
	//FIN DC
    function autoCompletarNombre(){
		let respuesta 	= "";
		let run 		= $("#linea_rut2").val();

        if (rutEsValido(run)){
        	obtenerInformacionRunificador(run).then(function (data){
        		console.log(data);
        		if (data.estado == 1){
        			$("#linea_nom2").val(data.respuesta.Nombres+' '+data.respuesta.ApellidoPaterno+' '+data.respuesta.ApellidoMaterno);
					//INICIO DC
					let edad = calculaEdad(data.respuesta.FechaNacimiento);
					$('#linea_edad2').val(edad);
					//FIN DC
        		}else if (data.estado == 0){
        			console.log(data.mensaje);

        		}
        	}).catch(function (error){
        		console.log(error);
        	});
        }
	}
</script>
<!-- INICIO CZ SPRINT 70-->
<script type="text/javascript">
    @if($flag_linea == 2)
    function listarLineaSalida_2021(){

        let tabla_linea_salida = $('#tabla_linea_salida').DataTable();

        tabla_linea_salida.clear().destroy();

        let data = new Object();
        data.pro_an_id 	= {{$pro_an_id}};

        tabla_linea_salida = $('#tabla_linea_salida').DataTable({
            "language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
            "ordering": 	false,
            "lengthChange": false,
            "info": 		false,
            "searching": 	false,
            "paging":   	false,
            "ajax": {
                "url": "{{ route('listar.linea.salida_2021') }}",
                "type": "GET",
                "data": data
            },
            "columnDefs": [
                { //RUT
                    "targets": 0,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //NOMBRES
                    "targets": 1,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //EDAD
                    "targets": 2,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //TELEFONO
                    "targets": 3,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //CORREO
                    "targets": 4,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //LLINEA DE SALIDA inicio ch
                    "targets": 5,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },//fin ch
                { //DESCARGAR inicio ch
                    "targets": 6,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                }
                }//fin ch
            ],				
            "columns": [
                        { //RUT
                            "data": "iden_run",
                            "className": "text-center"
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
                        { //LINEA SALIDA
                            "data": "iden_id",
                            "className": "text-center",
                            "render": function(data, type, row){
                                    let html ='';
                                    if(row.tiene_respuesta == false) {
                                        html = '<button type="button" class="btn btn-outline-success" onclick="editarLineaSalida_2021('+data+');limpiarfrmValidadiones_2021();" id="btn_linea_salida_'+data+'"><i class="fa fa-plus-circle"></i> <b>Ingresar Linea Salida</b></button>';

                                    }else{
                                        html = '<button type="button" class="btn btn-outline-success" onclick="editarLineaSalida_2021('+data+');limpiarfrmValidadiones_2021();" id="btn_linea_salida_'+data+'"><i class="fa fa-plus-circle"></i> <b>Editar Linea Salida</b></button>';

                                    }
                                    return html;
                            }
                        },
                        { //Descargar 
                            "data": "iden_id",
                            "className": "text-center",
                            "render": function(data, type, row){
                                    let html ='';
                                    if(row.tiene_respuesta == false) {
                                        html = '<button disabled type="button" id="btn_linea_salida_'+data+'" class="btn btn-primary" onclick="descargarLineaSalida_2021('+data+','+{{$pro_an_id}}+');limpiarfrmValidadiones_2021();"><i class="fa fa-download"></i> <b>Descargar</b></button>';
                                    }else{
                                        html = '<button type="button" id="btn_linea_salida_'+data+'" class="btn btn-primary" onclick="descargarLineaSalida_2021('+data+','+{{$pro_an_id}}+');limpiarfrmValidadiones_2021();"><i class="fa fa-download"></i> <b>Descargar</b></button>';
                                    }
                            
                                    return html;
                            }
                        }
                    ]
            });
        }
    @endif

    function editarLineaSalida_2021(id) {
        listarPreguntasSalida_2021(1, id);
        getDataIdentificacionSalida_2021(id);
        getOtroSalida_2021(id);
        $('#frmlineaSalida_2021').modal('show');
    }
    
    function listarPreguntasSalida_2021(opcion, id = '') {
        $("#lin_bas_id").val(id);
        $("#accion").val(opcion);

        respuestaPreguntas.length = 0;
        // CZ SPRINT 76
        $("#ser_niv_com").val("");
        $("#ser_pro_soc").val("");
        $("#ser_ser_sec").val("");
        $("#bien_org_otr").val("");
        // CZ SPRINT 76
        $("#identificacion_linea_salida_2021").collapse('hide');
        $("#servicio_prestaciones_linea_salida").collapse('hide');
        $("#recursos_comunidad_linea_salida_2021").collapse('hide');
        $("#derecho_part_nna_linea_salida").collapse('hide');
        $("#continuidad_proyecto_linea_salida_2021").collapse('hide');
        listaPreServicios_Salida_2021();
        listaPreProgramas_Salida_2021();
        listaPreBienesComunitarios_Salida_2021();
        listaPreOrganizaciones_Salida_2021();
        listaPreParticipacion_Salida_2021();
        listaPreProyecto_Salida_2021();

        $('#linea_rut').rut({
            fn_error: function(input) {
                if (input.val() != '') {
                    $('#linea_rut').attr("data-val-run", false);
                    mensajeTemporalRespuestas(0, "* RUN Inválido.");
                    $("#val_linea_rut").show();
                }
            },
            fn_validado: function(input) {
                $('#linea_rut').attr("data-val-run", true);
                $("#val_linea_rut").hide();

                autoCompletarNombre();
                
            }
        });
    }
    function getOtroSalida_2021(id){
        let data = new Object();

        data.id = id;
        data.tipo_line_base = 2;
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
                        $("#ser_niv_com").val(resp.otro[i].otro_descripcion);
                    }
                    
                    if (resp.otro[i].otro_tipo == '2.2'){
                        $("#ser_pro_soc").val(resp.otro[i].otro_descripcion);
                    }
                    
                    if(resp.otro[i].otro_tipo == '3.1'){
                        $("#ser_ser_sec").val(resp.otro[i].otro_descripcion);
                    }
                    
                    if(resp.otro[i].otro_tipo == '3.2'){
                        $("#bien_org_otr").val(resp.otro[i].otro_descripcion);
                    }
                }
            }else{
                $("#ser_niv_com").val("");
                $("#ser_pro_soc").val("");
                $("#ser_ser_sec").val("");
                $("#bien_org_otr").val("");
            }
        }).fail(function(objeto, tipoError, errorHttp){

                manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

                return false;
        });
    }
    function guardarLineaSalida_2021() {

        respuesta = verificarfrmDerechoParticipacion_linea_salida_2021();
        if (!respuesta) {
            $("#derecho_part_nna_linea_salida").collapse('show');
            $("#identificacion_linea_salida_2021").collapse('hide');
            $("#servicio_prestaciones_linea_salida").collapse('hide');
            $("#recursos_comunidad_linea_salida_2021").collapse('hide');
            $("#derecho_part_nna_linea_salida").collapse('hide');
            $("#continuidad_proyecto_linea_salida_2021").collapse('hide');
            mensaje = "Completar Derechos y Participacion NNA";
            mensajeTemporalRespuestas(0, mensaje);
            return false;
        }


        respuesta = verificarfrmContinuidadProyecto_linea_salida()
        if (!respuesta) {
            $("#continuidad_proyecto_linea_salida_2021").collapse('show');
            $("#servicio_prestaciones_linea_salida").collapse('hide');
            $("#recursos_comunidad_linea_salida_2021").collapse('hide');
            $("#derecho_part_nna_linea_salida").collapse('hide');
            $("#continuidad_proyecto_linea_salida_2021").collapse('hide');
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
        data.iden = recolectarDataIdentificacionLS_2021();
        data.preg = recolectarSelLineaBase_2021();
        data.part = recolectarfrmDerechoParticipacion_linea_salida_2021();
        data.cont = recolectarfrmContinuidadProyecto_linea_salida();
        otros = new Array();
        otros[0] = $("#ser_niv_com").val();
        otros[1] = $("#ser_pro_soc").val();
        otros[2] = $("#ser_ser_sec").val();
        otros[3] = $("#bien_org_otr").val();
        data.otros = otros;
        data.pro_an_id = {{$pro_an_id}};
        data.tipo_line_base = 2;  
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
                listarLineaSalida_2021();
                respuestaPreguntas_2021 = [];
                console.log(respuestaPreguntas_2021);
            }

            if (resp.estado == 0) {
                mensajeTemporalRespuestas(0, resp.mensaje);
            }
            $('#frmlineaSalida_2021').modal('hide');
            // $("#btn_linea_salida_"+id).prop( "disabled", true );
            // $("#btn_linea_salida_"+id).prop( "disabled", false );
            desbloquearPantalla();

        }).fail(function(objeto, tipoError, errorHttp) {
            desbloquearPantalla();

            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

            return false;
        });
    }
    let respuestaPreguntas_2021 = new Array();
    function recolectarSelLineaBase_2021(){
        let data = new Object();
        data.preguntas = respuestaPreguntasLineaBase_2021;
        return data;
    }
   
    function agregarRepuestaSalida_2021(tipo, id, opcion = '',tipoTabla,) {
        let index  = respuestaPreguntasLineaBase_2021.findIndex(x => x.id === id);
        if(index == -1){
            respuesta_2021 = Object();
            respuesta_2021.id = id; //id de la pregunta
            respuesta_2021.tipo = tipo; //columna de respuesta
            respuesta_2021.opcion = opcion;
            respuesta_2021.tipoTabla = tipoTabla; //tipo tabla
        
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
        // CZ SPRINT 76
    }

    function descargarLineaSalida_2021(id,pro_an_id) {
        window.open(`/descargarLineaBase_2021/${id}/2/${pro_an_id}`, '_blank');
    }

</script>
<!-- FIN CZ SPRINT 70-->

