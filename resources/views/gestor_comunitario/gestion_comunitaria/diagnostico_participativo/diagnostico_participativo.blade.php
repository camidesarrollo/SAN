<!-- VENTANAS DIAGNOSTICO PARTICIPATIVO -->

<div class="row">
	<div class="fechaPlazo"><i style="margin-left:10px" class="far fa-calendar-alt mr-1"></i> Fecha estimada para avanzar de etapa: <span class="txtPlazo"></span></div>
    <div class="card shadow-sm p-4 w-100">        
        <div class="tab-content" id="myTabContent">		
             <!-- IDENTIFICACION DE LA COMUNIDAD -->
             <div class="tab-pane fade" id="ident-com-ges-com" role="tabpanel" aria-labelledby="ident-com-tab" style="display: none">
                @includeif('gestor_comunitario.gestion_comunitaria.diagnostico_participativo.identificacion_comunidad.identificacion_comunidad')    
            </div>
            <!-- IDENTIFICACION DE LA COMUNIDAD -->
            <!-- DOCUMENTOS LINEA BASE  inicio ch -->
            <div class="tab-pane fade" id="linea-ges-com" role="tabpanel" aria-labelledby="linea-part-tab" style="display: none">                
                @includeif('gestor_comunitario.gestion_comunitaria.diagnostico_participativo.linea_base_gc.linea_base')
            <div class="text-center"> 
                        <button type="button" id="btn-linea-ges-com" disabled class="btn btn-success btnEtapa" onclick="cambiarEstadoGestorComunitario();">Ir a la siguiente etapa - <strong>Matriz Identificación de Problemas</strong></button>
                    </div>
            </div>
            <!-- DOCUMENTOS LINEA BASE fin ch-->
        
            <!-- MATRIZ IDENTIFICACIÓN DE PROBLEMAS QUE CONSTITUYEN UN FACTOR DE RIESGO PARA LOS NNA -->
            <div class="tab-pane fade" id="mat-ide-pro-nna" role="tabpanel" aria-labelledby="mat-ide-pro-nna-tab" style="display: none">
                @includeif('gestor_comunitario.gestion_comunitaria.diagnostico_participativo.matriz_identificacion_nna.matriz_identificacion_problemas_nna')
                <div class="text-center"> <!-- inicio ch -->
                <!-- INICIO CZ SPRINT 61 -->
                    <button type="button" id="btn-matriz_identificacion_nna" class="btn btn-success btnEtapa" onclick="cambiarEstadoGestorComunitario();">Ir a la siguiente etapa - <strong>Matriz Priorización de Problemas</strong></button>
                </div>
                <!-- FIN CZ SPRINT 61 -->
                <!-- fin ch -->
            </div>
            <!-- MATRIZ IDENTIFICACIÓN DE PROBLEMAS QUE CONSTITUYEN UN FACTOR DE RIESGO PARA LOS NNA -->

            <!-- MATRIZ DE PRIORIZACIÓN DE PROBLEMAS POR RANGO ETARIO  -->
            <div class="tab-pane fade" id="mat-ide-pro-ran-eta" role="tabpanel" aria-labelledby="mat-ide-pro-ran-eta-tab" >    
                <input type="hidden" id="editar_pri" value="0" >
                <!--INICIO DC SPRINT 67 -->
                @includeif('gestor_comunitario.gestion_comunitaria.diagnostico_participativo.matriz_priorizacion_rango_etario.matriz_priorizacion_rango_etario_R1')
                @includeif('gestor_comunitario.gestion_comunitaria.diagnostico_participativo.matriz_priorizacion_rango_etario.matriz_priorizacion_rango_etario_R3')
				<!--FIN DC SPRINT 67 -->
                <a href="{{route('reporte.matriz.rango.etario').'/'.$pro_an_id}}"><button type="button" class="btn btn-success btnMatPri"><i class="fa fa-file-excel-o"></i> Descargar Matriz</button></a>
                <!-- FIN DC -->
                    <div class="text-center"> 
                        <button type="button" id="btn-mat-ide-pro-ran-eta" disabled class="btn btn-success btnEtapa" onclick="confirmarMatriz();">Ir a la siguiente etapa - <strong>Matriz de Factores Protectores</strong></button>
                    </div>
                    <script>
                        function confirmarMatriz(){

                            let data = new Object();
                            data.pro_an_id = $("#pro_an_id").val();

                            var url = "<?php echo e(route('listar.problemas.matriz.rango.etario')); ?>";

                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                            $.ajax({
                                type: "GET",
                                url: url,
                                data: data
                            }).done(function(resp){
                                var data = JSON.parse(resp);
                                if(data.data.length > 0){
                            $("#modal_priorizacion").modal('show');
                                }else{
                                    toastr.error('Existen problemas sin priorizar. Para poder pasar de etapa debe priorizar al menos un problema');
                                }

                            }).fail(function(objeto, tipoError, errorHttp){
                                desbloquearPantalla();

                                manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

                                return false;
                            });
                        }
                    </script>
            </div>
            <div class="modal fade" id="modal_priorizacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">¿Está seguro de desea avanzar de etapa?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Al momento de cambiar de etapa no sera posible volver a priorizar
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="cambiarEstadoGestorComunitario();">Si</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                    </div>
                    </div>
            </div>
            <!-- MATRIZ DE PRIORIZACIÓN DE PROBLEMAS POR RANGO ETARIO  -->

            <!-- MATRIZ DE FACTORES PROTECTORES -->
            <div class="tab-pane fade" id="mat_fac_ges_com" role="tabpanel" aria-labelledby="mat_fac_ges_com">                
                @includeif('gestor_comunitario.gestion_comunitaria.diagnostico_participativo.matriz_factores.matriz_factores')
                <div class="text-center"> 
                    <button type="button" id="btn-mat-fac-pro" disabled class="btn btn-success btnEtapa" onclick="cambiarEstadoGestorComunitario();">Ir a la siguiente etapa - <strong>Informe Diagnóstico Participativo</strong></button>
                </div>
            </div>
            <!-- MATRIZ DE FACTORES PROTECTORES -->

            <!-- INFORME DIAGNOSTICO PARTICIPATIVO -->
            <div class="tab-pane fade" id="inf_dpc" role="tabpanel" aria-labelledby="mat_fac_ges_com">                
                @includeif('gestor_comunitario.gestion_comunitaria.diagnostico_participativo.informe_dpc.informe')
                <div class="text-center"> 
                    <button type="button" id="btn-inf-dia-par-com" disabled class="btn btn-success btnEtapa" OnClick="mensaje_confirmacion()" data-toggle="modal" data-target="#confirmarCambioEtapa">Ir a la siguiente etapa - <strong>Plan Estratégico Comunitario</strong></button>
                </div>
            </div>
            <!-- INFORME DIAGNOSTICO PARTICIPATIVO -->

            <!-- DOCUMENTOS GESTION COMUNITARIA inicio ch -->
            <div class="tab-pane fade" id="doc-ges-com" role="tabpanel" aria-labelledby="doc-part-tab" style="display: none">                
                @includeif('gestor_comunitario.gestion_comunitaria.documentos')
            </div>
            <!-- DOCUMENTOS GESTION COMUNITARIA fin ch-->
        </div>	
    </div>	
</div>
<!-- VENTANAS DIAGNOSTICO PARTICIPATIVO -->	
<!-- INICIO CZ SPRINT 67 -->
<div id="modalEditProb" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="tit_frm_mtr_iden_pro_nna" aria-hidden="true" data-backdrop="static" data-keyboard="false">
<!-- FIN CZ SPRINT 67 -->
    <div class="modal-dialog modal-lg">
        <div class="modal-content p-4">
            <div class="card p-4 shadow-sm">
                <h5 class="modal-title text-center" id="tit_frm_mtr_iden_pro_nna"><b>Priorizar Problematica: <span id="tit_prob"></span></b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="position: absolute; right: 5px; top: 5px; width: 23px; height: 23px; padding: 0; margin: 0;">&times;</span>
                </button>
                <br>
                <form>
                	<!-- INICIO DC -->     
                    <input type="hidden" id="mat_idePro_nna_id" >
                    <input type="hidden" id="mat_idePro_nna_tipo" >
                    <!-- FIN DC -->
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Magnitud:</label>

                        <div class="col-sm-9">
                                <textarea maxlength="2000" onkeypress='return caracteres_especiales(event)'  onKeyUp="contCaracteres(this)" onKeyDown="contCaracteres(this)" class="form-control mb-2" rows="5" id="txtMagnitud"></textarea>
                                <div class="row">
                                    <div class="col">
                                        <h6><small class="form-text text-muted">Mínimo 3 y máximo 2000 caracteres.</small></h6>
                                    </div>
                                    <div class="col text-left">
                                        <h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_txtMagnitud" style="color: #000000;">0</strong></small></h6>
                                    </div>        
                                </div>
                                <p id="val_frm_cau" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar .</p>
                        </div>                              
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Gravedad:</label>

                        <div class="col-sm-9">
                                <textarea maxlength="2000" onkeypress='return caracteres_especiales(event)'  onKeyUp="contCaracteres(this)" onKeyDown="contCaracteres(this)" class="form-control mb-2" rows="5" id="txtGravedad"></textarea>
                                <div class="row">
                                    <div class="col">
                                        <h6><small class="form-text text-muted">Mínimo 3 y máximo 2000 caracteres.</small></h6>
                                    </div>
                                    <div class="col text-left">
                                        <h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_txtGravedad" style="color: #000000;">0</strong></small></h6>
                                    </div>        
                                </div>
                                <p id="val_frm_efe" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar .</p>
                        </div>                               
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Capacidad:</label>

                        <div class="col-sm-9">
                                <textarea maxlength="2000" onkeypress='return caracteres_especiales(event)'  onKeyUp="contCaracteres(this)" onKeyDown="contCaracteres(this)" class="form-control mb-2" rows="5" id="txtCapacidad"></textarea>
                                <div class="row">
                                    <div class="col">
                                        <h6><small class="form-text text-muted">Mínimo 3 y máximo 2000 caracteres.</small></h6>
                                    </div>
                                    <div class="col text-left">
                                        <h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_txtCapacidad" style="color: #000000;">0</strong></small></h6>
                                    </div>        
                                </div>
                                <p id="val_frm_acc_rea_abo_pro" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar .</p>
                        </div>                            
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Alternativa de Solución:</label>

                        <div class="col-sm-9">
                                <textarea maxlength="2000" onkeypress='return caracteres_especiales(event)'  onKeyUp="contCaracteres(this)" onKeyDown="contCaracteres(this)" class="form-control mb-2" rows="5" id="txtAlterSol"></textarea>
                                <div class="row">
                                    <div class="col">
                                        <h6><small class="form-text text-muted">Mínimo 3 y máximo 2000 caracteres.</small></h6>
                                    </div>
                                    <div class="col text-left">
                                        <h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_txtAlterSol" style="color: #000000;">0</strong></small></h6>
                                    </div>        
                                </div>
                                <p id="val_frm_ava" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar .</p>
                        </div>                               
                    </div>
                     <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Beneficio:</label>

                        <div class="col-sm-9">
                                <textarea maxlength="2000" onkeypress='return caracteres_especiales(event)'  onKeyUp="contCaracteres(this)" onKeyDown="contCaracteres(this)" class="form-control mb-2" rows="5" id="txtBeneficio"></textarea>
                                <div class="row">
                                    <div class="col">
                                        <h6><small class="form-text text-muted">Mínimo 3 y máximo 2000 caracteres.</small></h6>
                                    </div>
                                    <div class="col text-left">
                                        <h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_txtBeneficio" style="color: #000000;">0</strong></small></h6>
                                    </div>        
                                </div>
                                <p id="val_frm_con_per_com" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar .</p>
                        </div>                               
                    </div>
                </form>
                <div class="text-right">
                @if(session()->all()['perfil'] != config("constantes.perfil_administrador_central") && session()->all()['perfil'] != config("constantes.perfil_coordinador_regional"))
                    <button type="button" onclick="guardarProblematica()" class="btn btn-success guardarPrio" id="gua_frm_mat_ide_pro_nna">Guardar</button>
                    
                @endif
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>                  
            </div>                
        </div>
    </div>
</div>
<!-- INICIO DC SPRINT 67 -->
<div id="modalEditProb2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="tit_frm_mtr_iden_pro_nna" aria-hidden="true" data-backdrop="static" data-keyboard="false">
<!-- FIN CZ SPRINT 67 -->
    <div class="modal-dialog modal-lg">
        <div class="modal-content p-4">
            <div class="card p-4 shadow-sm">
                <h5 class="modal-title text-center" id="tit_frm_mtr_iden_pro_nna"><b>Editar Problematica: <span id="tit_prob3"></span></b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="position: absolute; right: 5px; top: 5px; width: 23px; height: 23px; padding: 0; margin: 0;">&times;</span>
                </button>
                <br>
                <form>
                	<input type="hidden" id="mat_idePro_nna_id2" >
                	<div class="form-group row">
                        <label class="col-sm-3 col-form-label">Magnitud:</label>

                        <div class="col-sm-9">
                                <textarea maxlength="2000" onkeypress='return caracteres_especiales(event)'  onKeyUp="contCaracteres(this)" onKeyDown="contCaracteres(this)" class="form-control mb-2" rows="5" id="txtMagnitud2"></textarea>
                                <div class="row">
                                    <div class="col">
                                        <h6><small class="form-text text-muted">Mínimo 3 y máximo 2000 caracteres.</small></h6>
                                    </div>
                                    <div class="col text-left">
                                        <h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_txtMagnitud2" style="color: #000000;">0</strong></small></h6>
                                    </div>        
                                </div>
                                <p id="val_frm_cau" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar .</p>
                        </div>                              
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Gravedad:</label>

                        <div class="col-sm-9">
                                <textarea maxlength="2000" onkeypress='return caracteres_especiales(event)'  onKeyUp="contCaracteres(this)" onKeyDown="contCaracteres(this)" class="form-control mb-2" rows="5" id="txtGravedad2"></textarea>
                                <div class="row">
                                    <div class="col">
                                        <h6><small class="form-text text-muted">Mínimo 3 y máximo 2000 caracteres.</small></h6>
                                    </div>
                                    <div class="col text-left">
                                        <h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_txtGravedad2" style="color: #000000;">0</strong></small></h6>
                                    </div>        
                                </div>
                                <p id="val_frm_efe" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar .</p>
                        </div>                               
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Capacidad:</label>

                        <div class="col-sm-9">
                                <textarea maxlength="2000" onkeypress='return caracteres_especiales(event)'  onKeyUp="contCaracteres(this)" onKeyDown="contCaracteres(this)" class="form-control mb-2" rows="5" id="txtCapacidad2"></textarea>
                                <div class="row">
                                    <div class="col">
                                        <h6><small class="form-text text-muted">Mínimo 3 y máximo 2000 caracteres.</small></h6>
                                    </div>
                                    <div class="col text-left">
                                        <h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_txtCapacidad2" style="color: #000000;">0</strong></small></h6>
                                    </div>        
                                </div>
                                <p id="val_frm_acc_rea_abo_pro" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar .</p>
                        </div>                            
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Alternativa de Solución:</label>

                        <div class="col-sm-9">
                                <textarea maxlength="2000" onkeypress='return caracteres_especiales(event)'  onKeyUp="contCaracteres(this)" onKeyDown="contCaracteres(this)" class="form-control mb-2" rows="5" id="txtAlterSol2"></textarea>
                                <div class="row">
                                    <div class="col">
                                        <h6><small class="form-text text-muted">Mínimo 3 y máximo 2000 caracteres.</small></h6>
                                    </div>
                                    <div class="col text-left">
                                        <h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_txtAlterSol2" style="color: #000000;">0</strong></small></h6>
                                    </div>        
                                </div>
                                <p id="val_frm_ava" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar .</p>
                        </div>                               
                    </div>
                     <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Beneficio:</label>

                        <div class="col-sm-9">
                                <textarea maxlength="2000" onkeypress='return caracteres_especiales(event)'  onKeyUp="contCaracteres(this)" onKeyDown="contCaracteres(this)" class="form-control mb-2" rows="5" id="txtBeneficio2"></textarea>
                                <div class="row">
                                    <div class="col">
                                        <h6><small class="form-text text-muted">Mínimo 3 y máximo 2000 caracteres.</small></h6>
                                    </div>
                                    <div class="col text-left">
                                        <h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_txtBeneficio2" style="color: #000000;">0</strong></small></h6>
                                    </div>        
                                </div>
                                <p id="val_frm_con_per_com" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar .</p>
                        </div>                               
                    </div>
                	
              	</form>
                <div class="text-right">
                @if(session()->all()['perfil'] != config("constantes.perfil_administrador_central") && session()->all()['perfil'] != config("constantes.perfil_coordinador_regional"))
                    <button type="button" onclick="guardarEditProblematica()" class="btn btn-success guardarPrio" id="gua_frm_mat_ide_pro_nna">Guardar</button>
                    @endif
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>                  
            </div>                
        </div>
    </div>
</div>

<div id="modalDespriorizar" class="modal fade" tabindex="-1"
	role="dialog" aria-labelledby="tit_frm_mtr_iden_pro_nna"
	aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content p-4">
			<div class="card p-4 shadow-sm">
				<h5 class="modal-title text-center" id="tit_frm_mtr_iden_pro_nna">
					¿Seguro(a) que desea despriorizar la Problemática: <span
						id="tit_prob2"></span>?
				</h5>
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true"
						style="position: absolute; right: 5px; top: 5px; width: 23px; height: 23px; padding: 0; margin: 0;">&times;</span>
				</button>
				<br> <br> <input type="hidden" id="mat_idePro_nna_id2">
				<div class="text-right">
                @if(session()->all()['perfil'] != config("constantes.perfil_administrador_central") && session()->all()['perfil'] != config("constantes.perfil_coordinador_regional"))
					<button type="button" onclick="despriorizarProblematica()"
						class="btn btn-danger guardarPrio" id="gua_frm_mat_ide_pro_nna">Despriorizar</button>
                @endif
					<button type="button" class="btn btn-secondary"
						data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
</div>
<meta name="_token" content="{{ csrf_token() }}">
<div class="modal fade" id="confirmarCambioEtapa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Confirmar cambio de etapa</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <p>Está a punto de pasar a la etapa Plan Estratégico.</p>
                <p>¿Desea continuar?</p>
                <p class="debug-url"></p>
                <div class="alert alert-warning">
                    <strong>Advertencia:</strong> Al momento de pasar de etapa <strong>NO</strong> podrá volver a editar la etapa de Diagnóstico Participativo.
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="cerrar-modal-confirm">Cancelar</button>
                <button type="button" class="btn btn-primary" id ="btnConfirmar" onclick="">Confirmar</button>
            </div>
        </div>
    </div>
</div>
<!-- FIN DC SPRINT 67 -->

<script type="text/javascript">
    function mensaje_confirmacion(){
        document.getElementById('btnConfirmar').setAttribute('onclick','cambiarEstadoGestorComunitario(); $("#confirmarCambioEtapa").modal("hide");');   
    }
	//INICIO DC SPRINT 67
	function guardarEditProblematica(){
		var Magnitud = $('#txtMagnitud2').val();
		var Gravedad = $('#txtGravedad2').val();
		var Capacidad = $('#txtCapacidad2').val();
		var AlterSol = $('#txtAlterSol2').val();
		var Beneficio = $('#txtBeneficio2').val();
		var id = $('#mat_idePro_nna_id2').val();
		var tipo = 1;
		var msj = '';
		var error = 0;
		if(Magnitud == ''){
			error = 1;
			msj = msj + '- Debe ingresar la Magnitud<br>';
		}
		if(Gravedad == ''){
			error = 1;
			msj = msj + '- Debe ingresar la Gravedad<br>';
		}
		if(Capacidad == ''){
			error = 1;
			msj = msj + '- Debe ingresar la Capacidad<br>';
		}
		if(AlterSol == ''){
			error = 1;
			msj = msj + '- Debe ingresar la Alternativa de Solucion<br>';
		}
		if(Beneficio == ''){
			error = 1;
			msj = msj + '- Debe ingresar el Beneficio<br>';
		}
		if(error == 1){
			mensajeTemporalRespuestas(0, msj);
		}else{
			let data = new Object();
            data.pro_an_id = {{$pro_an_id}};
            data.Magnitud = Magnitud;
            data.Gravedad = Gravedad;
            data.Capacidad = Capacidad;
            data.AlterSol = AlterSol;
            data.Beneficio = Beneficio;
            data.id = id;
            data.tipo = tipo
            bloquearPantalla();
            $.ajax({
            	type: "GET",
                url: "{{route('guardar.problematica')}}",
                data: data
            }).done(function(resp){
                    	console.log(resp);
            	if(resp == 1){
            		mensajeTemporalRespuestas(1, 'Problematica guardada');
            		listarProblematicaMPRE(tipo);
            		$('#modalEditProb').modal('hide');
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
	}
	function guardarProblematica(){
		var Magnitud = $('#txtMagnitud').val();
		var Gravedad = $('#txtGravedad').val();
		var Capacidad = $('#txtCapacidad').val();
		var AlterSol = $('#txtAlterSol').val();
		var Beneficio = $('#txtBeneficio').val();
		var id = $('#mat_idePro_nna_id').val();
		var tipo = $('#mat_idePro_nna_tipo').val();
		var msj = '';
		var error = 0;
		if(Magnitud == ''){
			error = 1;
			msj = msj + '- Debe ingresar la Magnitud<br>';
		}
		if(Gravedad == ''){
			error = 1;
			msj = msj + '- Debe ingresar la Gravedad<br>';
		}
		if(Capacidad == ''){
			error = 1;
			msj = msj + '- Debe ingresar la Capacidad<br>';
		}
		if(AlterSol == ''){
			error = 1;
			msj = msj + '- Debe ingresar la Alternativa de Solucion<br>';
		}
		if(Beneficio == ''){
			error = 1;
			msj = msj + '- Debe ingresar el Beneficio<br>';
		}
		if(error == 1){
			mensajeTemporalRespuestas(0, msj);
		}else{
			let data = new Object();
            data.pro_an_id = {{$pro_an_id}};
            data.Magnitud = Magnitud;
            data.Gravedad = Gravedad;
            data.Capacidad = Capacidad;
            data.AlterSol = AlterSol;
            data.Beneficio = Beneficio;
            data.id = id;
            data.tipo = tipo
            bloquearPantalla();
            //Verifica cantidad de priorizados
            $.ajax({
            	type: "GET",
                url: "{{route('verifica.priorizacion')}}",
                data: data
            }).done(function(resp){
            	if(resp[0].cantidad >= 3){
														   
            		mensajeTemporalRespuestas(0, 'Solo se permite un máximo de 3 priorizaciones');
            		desbloquearPantalla();
												
            	}else{
        	$.ajax({
            	type: "GET",
                url: "{{route('guardar.problematica')}}",
                data: data
            }).done(function(resp){
                    	console.log(resp);
            	if(resp == 1){
            		priorizarProblemaMatrizRangoEtario(tipo, id);
            		mensajeTemporalRespuestas(1, 'Priorizacion guardada');
            		listarProblematicaMPRE(tipo);
            		$('#modalEditProb').modal('hide');
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
            	
            }).fail(function(objeto, tipoError, errorHttp){
            	desbloquearPantalla();
                manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
                return false;
            });
            
	}
	}
	//FIN DC SPRINT 67
	function contCaracteres(input){
      num_caracteres_permitidos   = 2000;
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
    function habilitarInputOtros(tipo, _this){
        let valor = $(_this).val();
         console.log(tipo,valor);
        switch(tipo){
            case 1:
                if(valor == 17){
                    $('#cont_org_tip_otr').fadeIn('slow');
                }else{
                    $('#cont_org_tip_otr').fadeOut('slow');
                    $('#org_tip_otr').val('');
                }
            break;
            case 2:
                if(valor == 5){
                    $('#cont_org_gra_otr').fadeIn('slow');
                }else{
                    $('#cont_org_gra_otr').fadeOut('slow');
                    $('#org_gra_otr').val('');
                }
            break;
            case 3:
                if(valor == 17){
                    $('#cont_ins_tip_otr').fadeIn('slow');
                }else{
                    $('#cont_ins_tip_otr').fadeOut('slow');
                    $('#ins_tip_otr').val('');
                }
            break;
            case 4:
                if(valor == 6){
                    $('#cont_bien_com_otr').fadeIn('slow');
                }else{
                    $('#cont_bien_com_otr').fadeOut('slow');
                    $('#bien_com_otr').val('');
                }
            break;
        }		
	}

//---------- MATRIZ IDENTIFICACIÓN DE PROBLEMAS QUE CONSTITUYEN UN FACTOR DE RIESGO PARA LOS NNA --------------------- 
    function listarMatrizIdentificacionProblema(){
        //se elimina alerta inicio ch
        let data = new Object();
        data.pro_an_id = $("#pro_an_id").val();

        let matriz_identificacion_problemas = $('#matriz_identificacion_problemas').DataTable();
        matriz_identificacion_problemas.clear().destroy(); 

        matriz_identificacion_problemas = $('#matriz_identificacion_problemas').DataTable({
            "language"  : { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
            "lengthChange": false,
            "ajax":{
                "type":"GET",
                "url": "{{ route('matriz.identificacion.problema.nna') }}",
                "data": data
            },
            "columnDefs": [
                { //CATEGORÍAS O EJES TEMÁTICOS
                    "targets": 0,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                     
                    }
                },
                { //PROBLEMÁTICA IDENTIFICADA
                    "targets": 1,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                     
                    }
                },
                { //CAUSAS
                    "targets": 2,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                     
                    }
                },
                { //EFECTOS
                    "targets": 3,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                     
                    }
                },
                { //ACCIONES QUE SE HAN REALIZADO PARA ABORDAR EL PROBLEMA
                    "targets": 4,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                     
                    }
                },
                { //AVANCES
                    "targets": 5,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                     
                    }
                },
                { //CONVERGENCIA DE PERCEPCIONES DE LA COMUNIDAD
                    "targets": 6,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                     
                    }
                },
                { //DIVERGENCIA DE PERCEPCIONES DE LA COMUNIDAD
                    "targets": 7,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                     
                    }
                }, 
                { //ACCIONES
                    "targets": 8,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                     
                    }
                }
            ],              
            "columns": [{ //CATEGORÍAS O EJES TEMÁTICOS
                            "data": "mat_eje_tem_nom",
                            "className": "text-center",
                        },
                        { //PROBLEMÁTICA IDENTIFICADA
                             "data": "mat_ide_pro_nna_pro_iden",
                             "className": "text-center",
                        },
                        { //CAUSAS
                            "data": "mat_ide_pro_nna_cau",
                            "className": "text-center"
                        },
                        { //EFECTOS
                            "data": "mat_ide_pro_nna_efe",
                            "className": "text-center",
                        },
                        { //ACCIONES QUE SE HAN REALIZADO PARA ABORDAR EL PROBLEMA
                             "data": "mat_ide_pro_nna_acc_abo",
                             "className": "text-center",
                        },
                        { //AVANCES
                            "data": "mat_ide_pro_nna_ava",
                            "className": "text-center"
                        },
                        { //CONVERGENCIA DE PERCEPCIONES DE LA COMUNIDAD
                            "data": "mat_ide_pro_nna_con_per_com",
                            "className": "text-center",
                        },
                        { //DIVERGENCIA DE PERCEPCIONES DE LA COMUNIDAD
                             "data": "mat_ide_pro_nna_div_per_com",
                             "className": "text-center",
                        },
                        // @ if($diag_estado == 1)
                        { //ACCIONES
                            "data": "",
                            "className": "text-center",
                            "render": function(data, type, row){
                            	//INICIO DC
                            	let html = '';
                            	if('{{ Session::get('perfil') }}' != 2){
                            		html = '<button type="button" class="btn btn-warning btn_bns_com mr-2" onclick="levantarFormularioMatrizIdentificacionProblema(1, '+row.mat_ide_pro_nna_id+')"><span class="oi oi-pencil"></span> Editar</button>';
                            	}else{
                            		html = '<button type="button" disabled="disabled" class="btn btn-warning btn_bns_com mr-2" onclick="levantarFormularioMatrizIdentificacionProblema(1, '+row.mat_ide_pro_nna_id+')"><span class="oi oi-pencil"></span> Editar</button>';
                            	}
                            	//FIN DC
                                    // html += '<button type="button" class="btn btn-danger btn_bns_com" data-bit-id="'+data+'" onclick="eliminarFrmBienesComunes('+data+')"><span class="oi oi-delete"></span> Eliminar</button>';

                                    return html;
                                }
                        }
                        // @ endif
                    ]
        });
    }
    function levantarFormularioMatrizIdentificacionProblema(opc, id = null){
        let data = new Object();
        data.opc = opc;
        data.pro_an_id = $("#pro_an_id").val();

        if (opc == 1){ //EDITAR
            data.mat_ide_pro_nna_id = id;
        }

        bloquearPantalla();

        $.ajax({
            type: "GET",
            url: "{{route('formulario.matriz.identificacion.problema.nna')}}",
            data: data
        }).done(function(resp){
            desbloquearPantalla();

            if (resp.estado == 1){
                limpiarFormularioMatrizIdentificacionProblema();

                let matriz = "<option value=''>Seleccione una opcion</option>";

                $.each( resp.respuesta.matriz, function( key, value ){
                    matriz += "<option value='"+resp.respuesta.matriz[key].mat_eje_tem_id+"'>"+resp.respuesta.matriz[key].mat_eje_tem_nom+"</option>"
                });

                $("#frm_cat_eje_tem").html(matriz);

                if (opc == 0){ //AGREGAR
                    $("#gua_frm_mat_ide_pro_nna").attr("onclick", "guardarFormularioMatrizIdentificacionProblema(0);");
                    
                }else if (opc == 1){ //EDITAR
                    $('#frm_cat_eje_tem').prop('selectedIndex', resp.respuesta.consulta.mat_eje_tem_id);
                    $("#frm_pro_ide").val(resp.respuesta.consulta.mat_ide_pro_nna_pro_iden);
                    $("#frm_cau").val(resp.respuesta.consulta.mat_ide_pro_nna_cau);
                    $("#frm_efe").val(resp.respuesta.consulta.mat_ide_pro_nna_efe);
                    $("#frm_acc_rea_abo_pro").val(resp.respuesta.consulta.mat_ide_pro_nna_acc_abo);
                    $("#frm_ava").val(resp.respuesta.consulta.mat_ide_pro_nna_ava);
                    $("#frm_con_per_com").val(resp.respuesta.consulta.mat_ide_pro_nna_con_per_com);
                    $("#frm_div_per_com").val(resp.respuesta.consulta.mat_ide_pro_nna_div_per_com);

                    $("#gua_frm_mat_ide_pro_nna").attr("onclick", "guardarFormularioMatrizIdentificacionProblema(1,"+resp.respuesta.consulta.mat_ide_pro_nna_id+");");
                }

                $('#frm_mtr_iden_pro_nna').modal('show');
            }else if (resp.estado == 0){
                mensajeTemporalRespuestas(0, resp.mensaje);

            }
        }).fail(function(objeto, tipoError, errorHttp){            

            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

            return false;
        });
    }

    function guardarFormularioMatrizIdentificacionProblema(opc, id = null){
        let val = validacionFormularioMatrizIdentificacionProblema();
        if (!val) { return false; }

        bloquearPantalla();

        let data = new Object();
        data.opc = opc;
        data.pro_an_id = $("#pro_an_id").val();
        data.mat_eje_tem_id = $('#frm_cat_eje_tem').prop('selectedIndex');
        data.mat_ide_pro_nna_pro_iden = $("#frm_pro_ide").val();
        data.mat_ide_pro_nna_cau = $("#frm_cau").val();
        data.mat_ide_pro_nna_efe = $("#frm_efe").val();
        data.mat_ide_pro_nna_acc_abo = $("#frm_acc_rea_abo_pro").val();
        data.mat_ide_pro_nna_ava = $("#frm_ava").val();
        data.mat_ide_pro_nna_con_per_com = $("#frm_con_per_com").val();
        data.mat_ide_pro_nna_div_per_com = $("#frm_div_per_com").val();

        if (opc == 1){ //EDITAR
            data.mat_ide_pro_nna_id = id;
        }

        // $.ajaxSetup({
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     }
        // });

        $.ajax({
            type:"GET",
            // type:"POST",
            url: "{{route('guardar.formulario.matriz.identificacion.problema.nna')}}",
            data: data
        }).done(function(resp){
            desbloquearPantalla();

            if (resp.estado == 1){
               mensajeTemporalRespuestas(1, resp.mensaje);

               listarMatrizIdentificacionProblema();
               $('#frm_mtr_iden_pro_nna').modal('hide'); 
               //INICIO DC SPRINT 67
               $('#btn-matriz_identificacion_nna').removeAttr('disabled');
               //FIN DC SPRINT 67
            }else if (resp.estado == 0){
                mensajeTemporalRespuestas(0, resp.mensaje);

            }
        }).fail(function(objeto, tipoError, errorHttp){   
            desbloquearPantalla();

            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

            return false;
        });
    }

    function validacionFormularioMatrizIdentificacionProblema(){
        let respuesta   = true;
        let cat_eje_tem = $("#frm_cat_eje_tem option:selected").val();
        let pro_ide     = $("#frm_pro_ide").val();
        let cau         = $("#frm_cau").val();
        let efe         = $("#frm_efe").val();
        let acc_rea_abo_pro = $("#frm_acc_rea_abo_pro").val();
        let ava         = $("#frm_ava").val();
        let con_per_com = $("#frm_con_per_com").val();
        let div_per_com = $("#frm_div_per_com").val();

        // CATEGORÍAS O EJES TEMÁTICOS
        if (cat_eje_tem == "" || typeof cat_eje_tem === "undefined"){
            respuesta = false;

            $("#val_frm_cat_eje_tem").show();
            $("#frm_cat_eje_tem").addClass("is-invalid");
        }else{
            $("#val_frm_cat_eje_tem").hide();
            $("#frm_cat_eje_tem").removeClass("is-invalid");
            
        }

        // PROBLEMÁTICA IDENTIFICADA
        if (pro_ide == "" || typeof pro_ide === "undefined"){
            respuesta = false;

            $("#val_frm_pro_ide").show();
            $("#frm_pro_ide").addClass("is-invalid");
        }else{
            $("#val_frm_pro_ide").hide();
            $("#frm_pro_ide").removeClass("is-invalid");
            
        }

        // CAUSAS
        if (cau == "" || typeof cau === "undefined"){
            respuesta = false;

            $("#val_frm_cau").show();
            $("#frm_cau").addClass("is-invalid");
        }else{
            $("#val_frm_cau").hide();
            $("#frm_cau").removeClass("is-invalid");
            
        }

        if (efe == "" || typeof efe === "undefined"){
            respuesta = false;

            $("#val_frm_efe").show();
            $("#frm_efe").addClass("is-invalid");
        }else{
            $("#val_frm_efe").hide();
            $("#frm_efe").removeClass("is-invalid");
            
        }

        if (acc_rea_abo_pro == "" || typeof acc_rea_abo_pro === "undefined"){
            respuesta = false;

            $("#val_frm_acc_rea_abo_pro").show();
            $("#frm_acc_rea_abo_pro").addClass("is-invalid");
        }else{
            $("#val_frm_acc_rea_abo_pro").hide();
            $("#frm_acc_rea_abo_pro").removeClass("is-invalid");
            
        }

        if (ava == "" || typeof ava === "undefined"){
            respuesta = false;

            $("#val_frm_ava").show();
            $("#frm_ava").addClass("is-invalid");
        }else{
            $("#val_frm_ava").hide();
            $("#frm_ava").removeClass("is-invalid");
            
        }

        if (con_per_com == "" || typeof con_per_com === "undefined"){
            respuesta = false;

            $("#val_frm_con_per_com").show();
            $("#frm_con_per_com").addClass("is-invalid");
        }else{
            $("#val_frm_con_per_com").hide();
            $("#frm_con_per_com").removeClass("is-invalid");
            
        }

        if (div_per_com == "" || typeof div_per_com === "undefined"){
            respuesta = false;

            $("#val_frm_div_per_com").show();
            $("#frm_div_per_com").addClass("is-invalid");
        }else{
            $("#val_frm_div_per_com").hide();
            $("#frm_div_per_com").removeClass("is-invalid");
            
        }

        return respuesta;
    }

    function limpiarFormularioMatrizIdentificacionProblema(){
        $("#frm_cat_eje_tem").prop('selectedIndex', 0);
        $("#frm_pro_ide").val("");
        $("#frm_cau").val("");
        $("#frm_efe").val("");
        $("#frm_acc_rea_abo_pro").val("");
        $("#frm_ava").val("");
        $("#frm_con_per_com").val("");
        $("#frm_div_per_com").val("");

        $("#frm_cat_eje_tem").removeClass("is-invalid");
        $("#frm_pro_ide").removeClass("is-invalid");
        $("#frm_cau").removeClass("is-invalid");
        $("#frm_efe").removeClass("is-invalid");
        $("#frm_acc_rea_abo_pro").removeClass("is-invalid");
        $("#frm_ava").removeClass("is-invalid");
        $("#frm_con_per_com").removeClass("is-invalid");
        $("#frm_div_per_com").removeClass("is-invalid");

        $("#val_frm_cat_eje_tem").hide();
        $("#val_frm_pro_ide").hide();
        $("#val_frm_cau").hide();
        $("#val_frm_efe").hide();
        $("#val_frm_acc_rea_abo_pro").hide();
        $("#val_frm_ava").hide();
        $("#val_frm_con_per_com").hide();
        $("#val_frm_div_per_com").hide();
    }

//---------- MATRIZ IDENTIFICACIÓN DE PROBLEMAS QUE CONSTITUYEN UN FACTOR DE RIESGO PARA LOS NNA --------------------- 


//----------------------------- MATRIZ DE PRIORIZACIÓN DE PROBLEMAS POR RANGO ETARIO --------------------------------- 
    function cargarMPRE(tipo){
        listarProblematicaMPRE(tipo);
        cargarMatrizRangoEtario(tipo);

    }   

	//INICIO DC SPRINT 67
    function listarProblematicaMPRE(tipo){
        let proceso = $("#pro_an_id").val();

        let data = new Object();
        data.pro_an_id = proceso;
        data.mat_tip_ran_eta_id = tipo;

        let id = '#table_matriz_rango_etario_'+tipo;

        let table_matriz_rango_etario = $(id).DataTable();
        table_matriz_rango_etario.clear().destroy(); 

        table_matriz_rango_etario = $(id).DataTable({
            "language"  : { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
            "lengthChange": false,
            "ajax":{
                "type":"GET",
                "url": "{{ route('listar.matriz.rango.etario') }}",
                "data": data
            },
            "columnDefs": [
                { //PROBLEMÁTICAS
                    "targets": 0,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                     
                    }
                },
				{ //MAGNITUD
                    "targets": 1,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                     
                    }
                },
                { //GRAVEDAD
                    "targets": 2,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                     
                    }
                },
                { //CAPACIDAD
                    "targets": 3,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                     
                    }
                },
                { //ALTERNATIVA
                    "targets": 4,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                     
                    }
                },
                { //BENEFICIO
                    "targets": 5,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                     
                    }
                },
                { //ACCIONES
                    "targets": 6,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                     
                    }
                }
            ],              
            "columns": [{ //PROBLEMÁTICAS
                            "data": "",
                            "className": "text-center",
                            "render": function(data, type, row){
                                let html = row.mat_eje_tem_nom+" - "+row.mat_ide_pro_nna_pro_iden;

                                return html;
                            }
                        },
						{ //MAGNITUD
                            "data": "",
                            "className": "text-center",
                            "render": function(data, type, row){
                                let html = row.mat_ran_eta_mag;
                                return html;
                            }
                        },
                        { //GRAVEDAD
                            "data": "",
                            "className": "text-center",
                            "render": function(data, type, row){
                                let html = row.mat_ran_eta_grav;
                                return html;
                            }
                        },
                        { //CAPACIDAD
                            "data": "",
                            "className": "text-center",
                            "render": function(data, type, row){
                                let html = row.mat_ran_eta_cap;
                                return html;
                            }
                        },
                        { //ALTERNATIVA
                            "data": "",
                            "className": "text-center",
                            "render": function(data, type, row){
                                let html = row.mat_ran_eta_alt_sol;
                                return html;
                            }
                        },
                         { //BENEFICIO
                            "data": "",
                            "className": "text-center",
                            "render": function(data, type, row){
                                let html = row.mat_ran_eta_ben;
                                return html;
                            }
                        },
                        { //ACCIONES
                            "data": "",
                            "className": "text-center",
                            "render": function(data, type, row){
                                // let html = '<button type="button" class="btn btn-primary">Ver</button>';             
                                let html = "";
                                //INICIO DC
                                if($('#desestimado').val() == 1){
                                	if (row.priorizado){
                                		html = '<button type="button" class="btn btn-success" disabled="true">Priorizado</button>'+
                                		'<button type="button" class="btn btn-success" style="margin-left:5px" onclick="editarProblemaMatrizRangoEtario('+tipo+', '+row.mat_ide_pro_nna_id+', \''+row.mat_eje_tem_nom+' - '+row.mat_ide_pro_nna_pro_iden+'\');">Ver</button>';
                                	}
                                }else if('{{ Session::get('perfil') }}' == 2){
                                	if (row.priorizado){
                                		html = '<button type="button" class="btn btn-success" disabled="true">Priorizado</button>'+
                                		'<button type="button" class="btn btn-success" style="margin-left:5px" onclick="editarProblemaMatrizRangoEtario('+tipo+', '+row.mat_ide_pro_nna_id+', \''+row.mat_eje_tem_nom+' - '+row.mat_ide_pro_nna_pro_iden+'\');">Ver</button>';
                                	}else{
                                		html = '<button type="button" disabled="disabled" class="btn btn-success" onclick="editarProblemaMatrizRangoEtario('+tipo+', '+row.mat_ide_pro_nna_id+', \''+row.mat_eje_tem_nom+' - '+row.mat_ide_pro_nna_pro_iden+'\');">Priorizar</button>';
                                	}
                                }else{
                                if (row.priorizado){
                                		if($('#editar_pri').val() == 1){
                                			html = '<button type="button" class="btn btn-success" disabled="true">Priorizado</button>'+
                                			'<button type="button" class="btn btn-danger" onclick="despriorizarProblemaMatrizRangoEtario('+row.mat_ide_pro_nna_id+', \''+row.mat_eje_tem_nom+' - '+row.mat_ide_pro_nna_pro_iden+'\');">Despriorizar</button>'+
                                        	//INICIO DC SPRINT 67
											'<button type="button" class="btn btn-primary" style="margin-left:5px" onclick="editarProblema('+tipo+', '+row.mat_ide_pro_nna_id+', \''+row.mat_eje_tem_nom+' - '+row.mat_ide_pro_nna_pro_iden+'\');">Editar</button>';
											//FIN DC SPRINT 67
                                		}else{
                                			html = '<button type="button" class="btn btn-success" disabled="true">Priorizado</button>'+
                                        '<button type="button" class="btn btn-success" style="margin-left:5px" onclick="editarProblemaMatrizRangoEtario('+tipo+', '+row.mat_ide_pro_nna_id+', \''+row.mat_eje_tem_nom+' - '+row.mat_ide_pro_nna_pro_iden+'\');">Ver</button>';
                                		}
                                }else{
                                    var estado = 0; 
                                    if({{$est_pro_id}} < $("#est_pro_id").val() || {{$est_pro_id}} == $("#est_pro_id").val()){
                                        estado =$("#est_pro_id").val();
                                    }else{
                                        estado = {{$est_pro_id}};
                                    }
                                    console.log({{$est_pro_id}});
                                    console.log($("#est_pro_id").val());
                                    if ({{config('constantes.matriz_priorización_problemas')}} == estado ){
                                    	html = '<button type="button" class="btn btn-success" onclick="editarProblemaMatrizRangoEtario('+tipo+', '+row.mat_ide_pro_nna_id+', \''+row.mat_eje_tem_nom+' - '+row.mat_ide_pro_nna_pro_iden+'\');">Priorizar</button>';
                                    }else{
                                        html = '<button type="button" class="btn btn-success" disabled="true" onclick="editarProblemaMatrizRangoEtario('+tipo+', '+row.mat_ide_pro_nna_id+', \''+row.mat_eje_tem_nom+' - '+row.mat_ide_pro_nna_pro_iden+'\');">NO Priorizado</button>';
                                    }
                                }
                                }
								//FIN DC
                                return html;      
                            }
                        }
                    ]
        });
        
    }   
    function despriorizarProblemaMatrizRangoEtario(mat_ide_pro_nna_id, problema){
    	$('#tit_prob2').html(problema);
    	$('#mat_idePro_nna_id2').val(mat_ide_pro_nna_id);
    	$('#modalDespriorizar').modal('show');
    }
    function despriorizarProblematica(){
    	bloquearPantalla();
    	var mat_idePro_nna_id = $('#mat_idePro_nna_id2').val();
    	let data = new Object();
        data.pro_an_id = {{$pro_an_id}};
        data.mat_idePro_nna_id = mat_idePro_nna_id;
        $.ajax({
            type: "GET",
            url: "{{route('despriorizar.problematica')}}",
            data: data
        }).done(function(resp){
        	if(resp.estado == 1){
        		mensajeTemporalRespuestas(1, resp.mensaje);
            	listarProblematicaMPRE(1);
            	$('#modalDespriorizar').modal('hide');
        	}else{
        		mensajeTemporalRespuestas(0, resp.mensaje);
        	}
        	desbloquearPantalla(); 
        }).fail(function(objeto, tipoError, errorHttp){
        	desbloquearPantalla();
            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
            return false;
        });
    }
    
    function editarProblema(tipo, mat_ide_pro_nna_id, problematica){
    	$('#mat_idePro_nna_id2').val(mat_ide_pro_nna_id);
    	$('#modalEditProb2').modal('show');
    	let data = new Object();
        data.pro_an_id = {{$pro_an_id}};
        data.id = mat_ide_pro_nna_id;
        data.tipo = 1;
        $('#tit_prob3').html(problematica);
        bloquearPantalla();
        $.ajax({
            type: "GET",
            url: "{{route('cargar.problematica')}}",
            data: data
        }).done(function(resp){
        	if(resp.length > 0){
        		$('#txtMagnitud2').val(resp[0].mat_ran_eta_mag);
        		$('#cant_carac_txtMagnitud').html(resp[0].mat_ran_eta_mag.length);
        		$('#txtGravedad2').val(resp[0].mat_ran_eta_grav);
        		$('#cant_carac_txtGravedad').html(resp[0].mat_ran_eta_grav.length);
        		$('#txtCapacidad2').val(resp[0].mat_ran_eta_cap);
        		$('#cant_carac_txtCapacidad').html(resp[0].mat_ran_eta_cap.length);
        		$('#txtAlterSol2').val(resp[0].mat_ran_eta_alt_sol);
        		$('#cant_carac_txtAlterSol').html(resp[0].mat_ran_eta_alt_sol.length);
        		$('#txtBeneficio2').val(resp[0].mat_ran_eta_ben);
        		$('#cant_carac_txtBeneficio').html(resp[0].mat_ran_eta_ben.length);
        		
        	}else{
        		$('#txtMagnitud2').val('');
        		$('#txtGravedad2').val('');
        		$('#txtCapacidad2').val('');
        		$('#txtAlterSol2').val('');
        		$('#txtBeneficio2').val('');
        	}
        	desbloquearPantalla(); 
        }).fail(function(objeto, tipoError, errorHttp){
        	desbloquearPantalla();
            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
            return false;
        });
    }
    //FIN DC SPRINT 67
    function editarProblemaMatrizRangoEtario(tipo, mat_ide_pro_nna_id, problematica){
    	if($('#editar_pri').val() == 0){
        	$('.guardarPrio').attr('disabled', 'disabled');
        }
    	$('#tit_prob').html(problematica);
    	$('#modalEditProb').modal('show');
    	$('#mat_idePro_nna_id').val(mat_ide_pro_nna_id);
    	$('#mat_idePro_nna_tipo').val(tipo);
    	let data = new Object();
        data.pro_an_id = {{$pro_an_id}};
        data.id = mat_ide_pro_nna_id;
        data.tipo = tipo;
        bloquearPantalla();
        $.ajax({
            type: "GET",
            url: "{{route('cargar.problematica')}}",
            data: data
        }).done(function(resp){
        	if(resp.length > 0){
        		$('#txtMagnitud').val(resp[0].mat_ran_eta_mag);
        		$('#cant_carac_txtMagnitud').html(resp[0].mat_ran_eta_mag.length);
        		$('#txtGravedad').val(resp[0].mat_ran_eta_grav);
        		$('#cant_carac_txtGravedad').html(resp[0].mat_ran_eta_grav.length);
        		$('#txtCapacidad').val(resp[0].mat_ran_eta_cap);
        		$('#cant_carac_txtCapacidad').html(resp[0].mat_ran_eta_cap.length);
        		$('#txtAlterSol').val(resp[0].mat_ran_eta_alt_sol);
        		$('#cant_carac_txtAlterSol').html(resp[0].mat_ran_eta_alt_sol.length);
        		$('#txtBeneficio').val(resp[0].mat_ran_eta_ben);
        		$('#cant_carac_txtBeneficio').html(resp[0].mat_ran_eta_ben.length);
        		
        	}else{
        		$('#txtMagnitud').val('');
        		$('#txtGravedad').val('');
        		$('#txtCapacidad').val('');
        		$('#txtAlterSol').val('');
        		$('#txtBeneficio').val('');
        	}
        	desbloquearPantalla(); 
        }).fail(function(objeto, tipoError, errorHttp){
        	desbloquearPantalla();
            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
            return false;
        });
    }
    //FIN DC

    function cargarMatrizRangoEtario(tipo){
        bloquearPantalla();

        let data = new Object();
        data.pro_an_id = $("#pro_an_id").val();
        data.mat_tip_ran_eta_id = tipo;

        $.ajax({
            type:"GET",
            url: "{{route('cargar.matriz.rango.etario')}}",
            data: data
        }).done(function(resp){
            desbloquearPantalla();

            if (resp.estado == 1){
                cargarDataFormularioMRE(tipo, resp.respuesta[0]);
 
            }else if (resp.estado == 0){
                mensajeTemporalRespuestas(0, resp.mensaje);

            }
        }).fail(function(objeto, tipoError, errorHttp){   
            desbloquearPantalla();

            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

            return false;
        });
    }

    function cargarDataFormularioMRE(tipo, data){
        let cantidad_caracteres_TextArea_GCM = parseInt("{{ config('constantes.cantidad_caracteres_TextArea_GCM') }}");

        if (data != "" && typeof data != "undefined"){
            $("#MTRE_"+tipo).val(data.mat_ran_eta_id);

            $("#frm_mag_"+tipo).val(data.mat_ran_eta_mag);
            $("#frm_gra_"+tipo).val(data.mat_ran_eta_grav);
            $("#frm_cap_"+tipo).val(data.mat_ran_eta_cap);
            $("#frm_alt_sol_"+tipo).val(data.mat_ran_eta_alt_sol);
            $("#frm_ben_"+tipo).val(data.mat_ran_eta_ben);

            let cantidad_1 = data.mat_ran_eta_mag;
            $("#cant_carac_frm_mag_"+tipo).text(cantidad_1.length);
            if (cantidad_1.length >= cantidad_caracteres_TextArea_GCM){
                $("#cant_carac_frm_mag_"+tipo).css("color", "#ff0000");

            }else{
                $("#cant_carac_frm_mag_"+tipo).css("color", "#000000");

            }

            let cantidad_2 = data.mat_ran_eta_grav;
            if(cantidad_2 != null){
            $("#cant_carac_frm_gra_"+tipo).text(cantidad_2.length);
            if (cantidad_2.length >= cantidad_caracteres_TextArea_GCM){
                $("#cant_carac_frm_gra_"+tipo).css("color", "#ff0000");

            }else{
                $("#cant_carac_frm_gra_"+tipo).css("color", "#000000");

            }
            }
            

            let cantidad_3 = data.mat_ran_eta_cap;
            if(cantidad_3 != null){
            $("#cant_carac_frm_cap_"+tipo).text(cantidad_3.length);
            if (cantidad_3.length >= cantidad_caracteres_TextArea_GCM){
                $("#cant_carac_frm_cap_"+tipo).css("color", "#ff0000");

            }else{
                $("#cant_carac_frm_cap_"+tipo).css("color", "#000000");

            }
            }
            

            let cantidad_4 = data.mat_ran_eta_alt_sol;
            $("#cant_carac_frm_alt_sol_"+tipo).text(cantidad_4.length);
            if (cantidad_4.length >= cantidad_caracteres_TextArea_GCM){
                $("#cant_carac_frm_alt_sol_"+tipo).css("color", "#ff0000");

            }else{
                $("#cant_carac_frm_alt_sol_"+tipo).css("color", "#000000");

            }

            let cantidad_5 = data.mat_ran_eta_ben;
            $("#cant_carac_frm_ben_"+tipo).text(cantidad_5.length);
            if (cantidad_5.length >= cantidad_caracteres_TextArea_GCM){
                $("#cant_carac_frm_ben_"+tipo).css("color", "#ff0000");

            }else{
                $("#cant_carac_frm_ben_"+tipo).css("color", "#000000");

            }
        
        }else{
            $("#cant_carac_frm_mag_"+tipo).text(0);
            $("#cant_carac_frm_gra_"+tipo).text(0);
            $("#cant_carac_frm_cap_"+tipo).text(0);
            $("#cant_carac_frm_alt_sol_"+tipo).text(0);
            $("#cant_carac_frm_ben_"+tipo).text(0);

            $("#cant_carac_frm_mag_"+tipo).css("color", "#000000");
            $("#cant_carac_frm_gra_"+tipo).css("color", "#000000");
            $("#cant_carac_frm_cap_"+tipo).css("color", "#000000");
            $("#cant_carac_frm_alt_sol_"+tipo).css("color", "#000000");
            $("#cant_carac_frm_ben_"+tipo).css("color", "#000000");
        }

        $(".txt-can-car-help").html('<h6><small class"form-text text-muted">Mínimo 3 y máximo {{ config("constantes.cantidad_caracteres_TextArea_GCM") }} caracteres.</small></h6>');
    }

    function regitrarDataMatrizRangoEtario(tipo, _this){
        bloquearPantalla();

        let data = new Object();
        data.pro_an_id = $("#pro_an_id").val();
        data.mat_tip_ran_eta_id = tipo;
        data.mat_ran_eta_id = $("#MTRE_"+tipo).val();

        let valor = $(_this).val();
        let tip_res = $(_this).attr("id");
        switch(tip_res){
            case "frm_mag_"+tipo: //MAGNITUD
                data.mat_ran_eta_mag = valor;           
            break;

            case "frm_gra_"+tipo: //GRAVEDAD
                data.mat_ran_eta_grav = valor;
            break;

            case "frm_cap_"+tipo: //CAPACIDAD 
                data.mat_ran_eta_cap = valor;
            break;

            case "frm_alt_sol_"+tipo: //ALTERNATIVA DE SOLUCIÓN
                data.mat_ran_eta_alt_sol = valor;
            break;

            case "frm_ben_"+tipo: //BENEFICIO
                data.mat_ran_eta_ben = valor;
            break;
        }
        
        // $.ajaxSetup({
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     }
        // });

        $.ajax({
            type:"GET",
            // type:"POST",
            url: "{{route('registrar.matriz.rango.etario')}}",
            data: data
        }).done(function(resp){
            desbloquearPantalla();

            if (resp.estado == 1){
               let mensaje = "Información registrada con éxito."; 
               mensajeTemporalRespuestas(1, mensaje);
 
               $("#MTRE_"+tipo).val(resp.mat_ran_eta_id);
            }else if (resp.estado == 0){
                mensajeTemporalRespuestas(0, resp.mensaje);

            }
        }).fail(function(objeto, tipoError, errorHttp){   
            desbloquearPantalla();

            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

            return false;
        });
    }
    

    function priorizarProblemaMatrizRangoEtario(tipo, id){
        bloquearPantalla();

        let data = new Object();
        data.pro_an_id = $("#pro_an_id").val();
        data.mat_ran_eta_id = $("#MTRE_"+tipo).val();
        data.mat_ide_pro_nna_id = id;
        data.mat_tip_ran_eta_id = tipo;

         $.ajax({
            type:"GET",
            // type:"POST",
            url: "{{route('priorizar.problema.matriz.rango.etario')}}",
            data: data
        }).done(function(resp){
            desbloquearPantalla();

            if (resp.estado == 1){
               
 
                // listarProblemasPriorizadosMRE();

                $("#MTRE_"+tipo).val(resp.mat_ran_eta_id);
            }else if (resp.estado == 0){
                mensajeTemporalRespuestas(0, resp.mensaje);

            }
        }).fail(function(objeto, tipoError, errorHttp){   
            desbloquearPantalla();

            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

            return false;
        });
    }


    function limpiarFormMPRE_1(){
        $("#frm_mag_1").val("");
        $("#frm_gra_1").val("");
        $("#frm_cap_1").val("");
        $("#frm_alt_sol_1").val("");
        $("#frm_ben_1").val("");
    }   

    function validarFormMPRE_1(){
        let respuesta   = true;
        let frm_mag_1 = $("#frm_mag_1").val();
        let frm_gra_1 = $("#frm_gra_1").val();
        let frm_cap_1 = $("#frm_cap_1").val();
        let frm_alt_sol_1 = $("#frm_alt_sol_1").val();
        let frm_ben_1 = $("#frm_ben_1").val();

        if (frm_mag_1 == "" || typeof frm_mag_1 === "undefined"){
            respuesta = false;

            $("#val_frm_mag_1").show();
            $("#frm_mag_1").addClass("is-invalid");
        }else{
            $("#val_frm_mag_1").hide();
            $("#frm_mag_1").removeClass("is-invalid");
            
        }

        if (frm_gra_1 == "" || typeof frm_gra_1 === "undefined"){
            respuesta = false;

            $("#val_frm_gra_1").show();
            $("#frm_gra_1").addClass("is-invalid");
        }else{
            $("#val_frm_gra_1").hide();
            $("#frm_gra_1").removeClass("is-invalid");
            
        }


        if (frm_cap_1 == "" || typeof frm_cap_1 === "undefined"){
            respuesta = false;

            $("#val_frm_cap_1").show();
            $("#frm_cap_1").addClass("is-invalid");
        }else{
            $("#val_frm_cap_1").hide();
            $("#frm_cap_1").removeClass("is-invalid");
            
        }

        if (frm_alt_sol_1 == "" || typeof frm_alt_sol_1 === "undefined"){
            respuesta = false;

            $("#val_frm_alt_sol_1").show();
            $("#frm_alt_sol_1").addClass("is-invalid");
        }else{
            $("#val_frm_alt_sol_1").hide();
            $("#frm_alt_sol_1").removeClass("is-invalid");
            
        }

        if (frm_ben_1 == "" || typeof frm_ben_1 === "undefined"){
            respuesta = false;

            $("#val_frm_ben_1").show();
            $("#frm_ben_1").addClass("is-invalid");
        }else{
            $("#val_frm_ben_1").hide();
            $("#frm_ben_1").removeClass("is-invalid");
            
        }

        return respuesta;
    } 


    // --------------------- VALIDACION CARACTERES TEXT AREA MRE 1 --------------------------
    contenido_frm_mag_1 = ""; 
    function valTextAreaFrmMag1(){
      let num_caracteres_permitidos   = "{{ config('constantes.cantidad_caracteres_TextArea_GCM') }}";

      num_caracteres = $("#frm_mag_1").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#frm_mag_1").val(contenido_frm_mag_1);

       }else{ 
          contenido_frm_mag_1 = $("#frm_mag_1").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_frm_mag_1").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_frm_mag_1").css("color", "#000000");

       } 

       $("#cant_carac_frm_mag_1").text($("#frm_mag_1").val().length);
   }  

   contenido_frm_gra_1 = ""; 
    function valTextAreaFrmGra1(){
      let num_caracteres_permitidos   = "{{ config('constantes.cantidad_caracteres_TextArea_GCM') }}";

      num_caracteres = $("#frm_gra_1").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#frm_gra_1").val(contenido_frm_gra_1);

       }else{ 
          contenido_frm_gra_1 = $("#frm_gra_1").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_frm_gra_1").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_frm_gra_1").css("color", "#000000");

       } 

       $("#cant_carac_frm_gra_1").text($("#frm_gra_1").val().length);
    }

    contenido_frm_cap_1 = ""; 
    function valTextAreaFrmCap1(){
      let num_caracteres_permitidos   = "{{ config('constantes.cantidad_caracteres_TextArea_GCM') }}";

      num_caracteres = $("#frm_cap_1").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#frm_cap_1").val(contenido_frm_cap_1);

       }else{ 
          contenido_frm_cap_1 = $("#frm_cap_1").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_frm_cap_1").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_frm_cap_1").css("color", "#000000");

       } 

       $("#cant_carac_frm_cap_1").text($("#frm_cap_1").val().length);
    }

    contenido_frm_alt_sol_1 = ""; 
    function valTextAreaFrmAltSol1(){
      let num_caracteres_permitidos   = "{{ config('constantes.cantidad_caracteres_TextArea_GCM') }}";

      num_caracteres = $("#frm_alt_sol_1").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#frm_alt_sol_1").val(contenido_frm_alt_sol_1);

       }else{ 
          contenido_frm_alt_sol_1 = $("#frm_alt_sol_1").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_frm_alt_sol_1").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_frm_alt_sol_1").css("color", "#000000");

       } 

       $("#cant_carac_frm_alt_sol_1").text($("#frm_alt_sol_1").val().length);
    }

    contenido_frm_ben_1 = ""; 
    function valTextAreaFrmBen1(){
      let num_caracteres_permitidos   = "{{ config('constantes.cantidad_caracteres_TextArea_GCM') }}";

      num_caracteres = $("#frm_ben_1").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#frm_ben_1").val(contenido_frm_ben_1);

       }else{ 
          contenido_frm_ben_1 = $("#frm_ben_1").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_frm_ben_1").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_frm_ben_1").css("color", "#000000");

       } 

       $("#cant_carac_frm_ben_1").text($("#frm_ben_1").val().length);
    }   

    // --------------------- VALIDACION CARACTERES TEXT AREA MRE 1 --------------------------

    // --------------------- VALIDACION CARACTERES TEXT AREA MRE 2 --------------------------

    contenido_frm_mag_2 = ""; 
    function valTextAreaFrmMag2(){
      let num_caracteres_permitidos   = "{{ config('constantes.cantidad_caracteres_TextArea_GCM') }}";

      num_caracteres = $("#frm_mag_2").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#frm_mag_2").val(contenido_frm_mag_2);

       }else{ 
          contenido_frm_mag_2 = $("#frm_mag_2").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_frm_mag_2").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_frm_mag_2").css("color", "#000000");

       } 

       $("#cant_carac_frm_mag_2").text($("#frm_mag_2").val().length);
   }  

   contenido_frm_gra_2 = ""; 
    function valTextAreaFrmGra2(){
      let num_caracteres_permitidos   = "{{ config('constantes.cantidad_caracteres_TextArea_GCM') }}";

      num_caracteres = $("#frm_gra_2").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#frm_gra_2").val(contenido_frm_gra_2);

       }else{ 
          contenido_frm_gra_2 = $("#frm_gra_2").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_frm_gra_2").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_frm_gra_2").css("color", "#000000");

       } 

       $("#cant_carac_frm_gra_2").text($("#frm_gra_2").val().length);
    }

    contenido_frm_cap_2 = ""; 
    function valTextAreaFrmCap2(){
      let num_caracteres_permitidos   = "{{ config('constantes.cantidad_caracteres_TextArea_GCM') }}";

      num_caracteres = $("#frm_cap_2").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#frm_cap_2").val(contenido_frm_cap_2);

       }else{ 
          contenido_frm_cap_2 = $("#frm_cap_2").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_frm_cap_2").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_frm_cap_2").css("color", "#000000");

       } 

       $("#cant_carac_frm_cap_2").text($("#frm_cap_2").val().length);
    }

    contenido_frm_alt_sol_2 = ""; 
    function valTextAreaFrmAltSol2(){
      let num_caracteres_permitidos   = "{{ config('constantes.cantidad_caracteres_TextArea_GCM') }}";

      num_caracteres = $("#frm_alt_sol_2").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#frm_alt_sol_2").val(contenido_frm_alt_sol_2);

       }else{ 
          contenido_frm_alt_sol_2 = $("#frm_alt_sol_2").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_frm_alt_sol_2").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_frm_alt_sol_2").css("color", "#000000");

       } 

       $("#cant_carac_frm_alt_sol_2").text($("#frm_alt_sol_2").val().length);
    }

    contenido_frm_ben_2 = ""; 
    function valTextAreaFrmBen2(){
      let num_caracteres_permitidos   = "{{ config('constantes.cantidad_caracteres_TextArea_GCM') }}";

      num_caracteres = $("#frm_ben_2").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#frm_ben_2").val(contenido_frm_ben_2);

       }else{ 
          contenido_frm_ben_2 = $("#frm_ben_2").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_frm_ben_2").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_frm_ben_2").css("color", "#000000");

       } 

       $("#cant_carac_frm_ben_2").text($("#frm_ben_2").val().length);
    }

    // --------------------- VALIDACION CARACTERES TEXT AREA MRE 2 --------------------------

    // --------------------- VALIDACION CARACTERES TEXT AREA MRE 3 --------------------------

    contenido_frm_mag_3 = ""; 
    function valTextAreaFrmMag3(){
      let num_caracteres_permitidos   = "{{ config('constantes.cantidad_caracteres_TextArea_GCM') }}";

      num_caracteres = $("#frm_mag_3").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#frm_mag_3").val(contenido_frm_mag_3);

       }else{ 
          contenido_frm_mag_3 = $("#frm_mag_3").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_frm_mag_3").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_frm_mag_3").css("color", "#000000");

       } 

       $("#cant_carac_frm_mag_3").text($("#frm_mag_3").val().length);
   }  

   contenido_frm_gra_3 = ""; 
    function valTextAreaFrmGra3(){
      let num_caracteres_permitidos   = "{{ config('constantes.cantidad_caracteres_TextArea_GCM') }}";

      num_caracteres = $("#frm_gra_3").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#frm_gra_3").val(contenido_frm_gra_3);

       }else{ 
          contenido_frm_gra_3 = $("#frm_gra_3").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_frm_gra_3").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_frm_gra_3").css("color", "#000000");

       } 

       $("#cant_carac_frm_gra_3").text($("#frm_gra_3").val().length);
    }

    contenido_frm_cap_3 = ""; 
    function valTextAreaFrmCap3(){
      let num_caracteres_permitidos   = "{{ config('constantes.cantidad_caracteres_TextArea_GCM') }}";

      num_caracteres = $("#frm_cap_3").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#frm_cap_3").val(contenido_frm_cap_3);

       }else{ 
          contenido_frm_cap_3 = $("#frm_cap_3").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_frm_cap_3").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_frm_cap_3").css("color", "#000000");

       } 

       $("#cant_carac_frm_cap_3").text($("#frm_cap_3").val().length);
    }

    contenido_frm_alt_sol_3 = ""; 
    function valTextAreaFrmAltSol3(){
      let num_caracteres_permitidos   = "{{ config('constantes.cantidad_caracteres_TextArea_GCM') }}";

      num_caracteres = $("#frm_alt_sol_3").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#frm_alt_sol_3").val(contenido_frm_alt_sol_3);

       }else{ 
          contenido_frm_alt_sol_3 = $("#frm_alt_sol_3").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_frm_alt_sol_3").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_frm_alt_sol_3").css("color", "#000000");

       } 

       $("#cant_carac_frm_alt_sol_3").text($("#frm_alt_sol_3").val().length);
    }

    contenido_frm_ben_3 = ""; 
    function valTextAreaFrmBen3(){
      let num_caracteres_permitidos   = "{{ config('constantes.cantidad_caracteres_TextArea_GCM') }}";

      num_caracteres = $("#frm_ben_3").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#frm_ben_3").val(contenido_frm_ben_3);

       }else{ 
          contenido_frm_ben_3 = $("#frm_ben_3").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_frm_ben_3").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_frm_ben_3").css("color", "#000000");

       } 

       $("#cant_carac_frm_ben_3").text($("#frm_ben_3").val().length);
    }

    // --------------------- VALIDACION CARACTERES TEXT AREA MRE 3 --------------------------

//----------------------------- MATRIZ DE PRIORIZACIÓN DE PROBLEMAS POR RANGO ETARIO --------------------------------- 


//----------------------------- PROBLEMAS PRIORIZADOS --------------------------------- 
function listarProblemasPriorizadosMRE(){
        let data = new Object();
        data.pro_an_id = $("#pro_an_id").val();

        let tabla_problemas_priorizados_MRE = $('#tabla_problemas_priorizados_MRE').DataTable();
        tabla_problemas_priorizados_MRE.clear().destroy(); 

        tabla_problemas_priorizados_MRE = $('#tabla_problemas_priorizados_MRE').DataTable({
            "language"  : { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
            "lengthChange": false,
            "ajax":{
                "type":"GET",
                "url": "{{ route('listar.problemas.matriz.rango.etario') }}",
                "data": data
            },
            "rowsGroup" : [0, 1],
            "columnDefs": [
                { //N°
                    "targets": 0,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                     
                    }
                },
                { //PROBLEMAS
                    "targets": 1,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                     
                    }
                }
            ],              
            "columns": [{ //PROBLEMAS
                            "data": "mat_ide_pro_nna_pro_iden",
                            "className": "text-center",
                        },
                        { //CATEGORÍAS O EJES TEMÁTICOS
                            "data": "mat_eje_tem_nom",
                            "className": "text-center"
                        }
                    ]
        });
    }
//----------------------------- PROBLEMAS PRIORIZADOS --------------------------------- 
</script><!-- INICIO CZ SPRINT 67 -->
<script type="text/javascript">

    
    function valTextAreaMatCausas(){
        let cont_frm_cau = "";
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

    function valTextAreaMatEfectos(){
        let cont_frm_efe = "";
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

    
    function valTextAreaMatAcciones(){
        let cont_frm_acc_rea_abo_pro = "";
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

    
    function valTextAreaMatAvances(){
        let cont_frm_ava = "";
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

    
    function valTextAreaMatConvergencia(){
        let cont_frm_con_per_com = "";
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

   
    function valTextAreaMatDivergencia(){
        let cont_frm_div_per_com = "";
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
<!-- FIN CZ SPRINT 67 -->