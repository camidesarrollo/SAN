<div id="frmCaracteristicaGeneral" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="formComponentesLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content p-4">
        <div class="card p-4 m-0 shadow-sm">
          <h5 class="modal-title text-center" id="formComponentesLabel"><b>CARACTERÍSTICAS GENERALES</b></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" style="position: absolute; right: 5px; top: 5px; width: 23px; height: 23px; padding: 0; margin: 0;">&times;</span>
          </button>
          <br>
          <div class="form-group">
            <!-- ACTORES CLAVES PRESENTES -->    
            <div class="form-group row ml-3">
                <label for="" class="col-sm-4 col-form-label"><b>Actores clave presentes en la comunidad:</b></label>
                <div class="col-sm-8">
                    @if($est_pro_id != config('constantes.plan_estrategico'))
                        <textarea id="intro_caract_actores" maxlength="2000" onkeypress='return caracteres_especiales(event)'  onKeyUp="valTextAreaInfo3()" onKeyDown="valTextAreaInfo3()" class="form-control " rows="5" onblur="" ></textarea>
                        <div class="row">
                            <div class="col">
                                <h6><small class="form-text text-muted">Mínimo 3 y máximo 2000 caracteres.</small></h6>
                            </div>
                            <div class="col text-left">
                                <h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_intro_caract_actores" style="color: #000000;">0</strong></small></h6>
                            </div>        
                        </div>
                        <p id="val_intro_caract_actores" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar Actores clave presentes en la comunidad.</p>
                    @else
                        <label id="intro_caract_actores" for=""></label>
                    @endif
                </div>                              
            </div>
            <!-- ACTORES CLAVES PRESENTES -->
            <!-- ORGANIZACIONES FUNCIONALES -->                
            <div class="form-group row ml-3">
                <label for="" class="col-sm-4 col-form-label"><b>Organizaciones funcionales (formales y no formales) presentes en la comunidad</b></label>
                <div class="col-sm-8">
                    @if($est_pro_id != config('constantes.plan_estrategico'))
                        <textarea id="intro_caract_organizaciones" maxlength="2000" onkeypress='return caracteres_especiales(event)'  onKeyUp="valTextAreaInfo4()" onKeyDown="valTextAreaInfo4()" class="form-control " rows="5" onblur="" ></textarea>
                        <div class="row">
                            <div class="col">
                                <h6><small class="form-text text-muted">Mínimo 3 y máximo 2000 caracteres.</small></h6>
                            </div>
                            <div class="col text-left">
                                <h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_intro_caract_organizaciones" style="color: #000000;">0</strong></small></h6>
                            </div>        
                        </div>
                        <p id="val_intro_caract_organizaciones" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar Organizaciones funcionales.</p>
                    @else
                        <label id="intro_caract_organizaciones" for=""></label>
                    @endif
                </div>                           
            </div>
            <!-- ORGANIZACIONES FUNCIONALES -->
            <!-- INSTITUCIONES, ONG, PROGRAMAS -->
            <div class="form-group row ml-3">
                <label for="" class="col-sm-4 col-form-label"><b>Instituciones, ONG y programas presentes en la comunidad</b></label>
                <div class="col-sm-8">
                    @if($est_pro_id != config('constantes.plan_estrategico'))
                        <textarea id="intro_caract_instituciones" maxlength="2000" onkeypress='return caracteres_especiales(event)'  onKeyUp="valTextAreaInfo5()" onKeyDown="valTextAreaInfo5()" class="form-control " rows="5" onblur="" ></textarea>
                        <div class="row">
                            <div class="col">
                                <h6><small class="form-text text-muted">Mínimo 3 y máximo 2000 caracteres.</small></h6>
                            </div>
                            <div class="col text-left">
                                <h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_intro_caract_instituciones" style="color: #000000;">0</strong></small></h6>
                            </div>        
                        </div>
                        <p id="val_intro_caract_instituciones" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar Instituciones, ONG y programas.</p>
                    @else
                        <label id="intro_caract_instituciones" for=""></label>
                    @endif
                </div>                              
            </div>
            <!-- INSTITUCIONES, ONG, PROGRAMAS -->
            <!-- PARTICIPACION DE LOS NNA -->
            <div class="form-group row ml-3">
                <label for="" class="col-sm-4 col-form-label"><b>Participación de los NNA en la comunidad</b></label>
                <div class="col-sm-8">
                    @if($est_pro_id != config('constantes.plan_estrategico'))
                        <textarea id="intro_caract_participacion" maxlength="2000" onkeypress='return caracteres_especiales(event)'  onKeyUp="valTextAreaInfo6()" onKeyDown="valTextAreaInfo6()" class="form-control " rows="5" onblur="" ></textarea>
                        <div class="row">
                            <div class="col">
                                <h6><small class="form-text text-muted">Mínimo 3 y máximo 2000 caracteres.</small></h6>
                            </div>
                            <div class="col text-left">
                                <h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_intro_caract_participacion" style="color: #000000;">0</strong></small></h6>
                            </div>        
                        </div>
                        <p id="val_intro_caract_participacion" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar Participación de los NNA</p>
                    @else
                        <label id="intro_caract_participacion" for=""></label>
                    @endif
                </div>                              
            </div>
            <!-- PARTICIPACION DE LOS NNA -->
            <!-- BIENES COMUNES -->
            <div class="form-group row ml-3">
                <label for="" class="col-sm-4 col-form-label"><b>Bienes comunes presentes en la comunidad</b></label>
                <div class="col-sm-8">
                    @if($est_pro_id != config('constantes.plan_estrategico'))
                        <textarea id="into_caract_bienes" maxlength="2000" onkeypress='return caracteres_especiales(event)'  onKeyUp="valTextAreaInfo7()" onKeyDown="valTextAreaInfo7()" class="form-control " rows="5" onblur="" ></textarea>
                        <div class="row">
                            <div class="col">
                                <h6><small class="form-text text-muted">Mínimo 3 y máximo 2000 caracteres.</small></h6>
                            </div>
                            <div class="col text-left">
                                <h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_into_caract_bienes" style="color: #000000;">0</strong></small></h6>
                            </div>        
                        </div>
                        <p id="val_into_caract_bienes" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar Bienes comunes.</p>
                    @else
                        <label id="into_caract_bienes" for=""></label>
                    @endif
                </div>                              
            </div>
            <!-- BIENES COMUNES -->
        </div>   
          <div class="text-right">
            <button type="button" class="btn btn-success" onclick="registrarInformeCaractGenerales();" >Guardar</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>					
        </div>                
      </div>
    </div>
</div>

<script type="text/javascript">

</script>