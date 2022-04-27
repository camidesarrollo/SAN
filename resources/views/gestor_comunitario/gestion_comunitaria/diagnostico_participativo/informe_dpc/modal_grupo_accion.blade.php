<!-- INICIO CZ SPRINT 67 -->
<div id="frmintegrantesgrupo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="formComponentesLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
<!-- FIN CZ SPRINT 67 -->
    <div class="modal-dialog">
      <div class="modal-content p-4">
        <div class="card p-4 m-0 shadow-sm">
          <h5 class="modal-title text-center" id="formComponentesLabel"><b>INTEGRANTES DEL GRUPO DE ACCIÓN</b></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" style="position: absolute; right: 5px; top: 5px; width: 23px; height: 23px; padding: 0; margin: 0;">&times;</span>
          </button>
          <br>
		  
            <div class="form-group">                
            
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Nombres</b></label>
                    <div class="col-sm-9">
                        <input maxlength="100" id="grupo_nom" name="grupo_nom" onkeypress="return caracteres_especiales(event)" type="input" class="form-control">
                        <p id="val_grupo_nom" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar un Nombre.</p>
                    </div>                              
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>RUT:</b></label>
                    <div class="col-sm-9">
                        <input maxlength="100" id="grupo_rut" name="grupo_rut" onkeypress="return caracteres_especiales(event)" type="input" class="form-control">
                        <p id="val_grupo_rut" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar un Rut valido.</p>
                    </div>                              
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Teléfono:</b></label>
                    <div class="col-sm-9">
                        <input maxlength="10" id="grupo_tele" name="grupo_tele" onkeypress="return caracteres_especiales(event)" type="input" class="form-control">
                        <p id="val_grupo_tele" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar un Teléfono.</p>
                    </div>                              
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Correo</b></label>
                    <div class="col-sm-9">
                        <input maxlength="100" id="grupo_cor" name="grupo_cor" onkeypress="" type="input" class="form-control">
                        <p id="val_grupo_cor" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar un Correo.</p>
                    </div>                              
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Rol</b></label>
                    <div class="col-sm-9">
                        <input maxlength="100" id="grupo_rol" name="grupo_rol" onkeypress="return caracteres_especiales(event)" type="input" class="form-control">
                        <p id="val_grupo_rol" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar un Rol.</p>
                    </div>                              
                </div>

            </div>
          <div class="text-right">
            <button type="button" class="btn btn-success" onclick="registrarIntegrantes();" >Guardar</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>					
        </div>                
      </div>
    </div>
  </div>

<script type="text/javascript">

</script>