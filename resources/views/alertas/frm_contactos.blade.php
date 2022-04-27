<div id="frmContactos" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="formComponentesLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content p-4">
            <div class="card p-4 shadow-sm">
                <h5 class="modal-title" id="formComponentesLabel"><b>Agregar Contacto Alerta Territorial.</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="position: absolute; right: 5px; top: 5px; width: 23px; height: 23px; padding: 0; margin: 0;">&times;</span>
                </button>
                <br>

                <form action="">
                    <input type="hidden" name="id_componente" id="id_componente" value="">
                    <input type="hidden" name="id_index" id="id_index" value="">

                    <!-- NOMBRE CONTACTO -->
                    <div class="form-group">
                        <label for="form_com_ofe_nom" ><b>Nombre:</b></label>
                        <input maxlength="100" onkeypress='return caracteres_especiales(event)' type="text" class="form-control " id="ale_man_con_nom" name="ale_man_con_nom" placeholder="Nombre">
                         <p id="val_ale_man_con_nom" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar Nombre.</p>
                    </div>
                    <!-- FIN NOMBRE CONTACTO -->

                     <!-- PARENTESCO -->
                    <div class="form-group">
                        <label for="form_com_ofe_nom" ><b>Parentesco o Relación:</b></label>
                        <input maxlength="100" onkeypress='return caracteres_especiales(event)' type="text" class="form-control " id="ale_man_con_par" name="ale_man_con_par" placeholder="Parentesco o Relación">
                         <p id="val_ale_man_con_par" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar Parentesco o Relación.</p>
                    </div>
                    <!-- FIN PARENTESCO -->

                    <!-- TELEFONO-->
                    <div class="form-group">
                        <label for="form_com_ofe_des" ><b>Teléfono:</b></label>
                        <input maxlength="100" type="input" onkeypress='return event.charCode >= 48 && event.charCode <= 57'  maxlength="11" class="form-control " name="ale_man_con_tel" id="ale_man_con_tel" placeholder="Teléfono" ></input>
                         <p id="val_ale_man_con_tel" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar el telefono.</p>
                    </div>
                    <!-- FIN TELEFONO -->

                     <!-- DIRECCION-->
                    <div class="form-group">
                        <label for="form_com_ofe_des" ><b>Dirección:</b></label>
                        <input maxlength="100" onkeypress='return caracteres_especiales(event)' class="form-control " name="ale_man_con_dir" id="ale_man_con_dir" placeholder="Dirección" ></input>
                         <p id="val_ale_man_con_dir" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar la dirección.</p>
                    </div>
                    <!-- FIN DIRECCION -->

                    <!-- GUARDAR COMPONENTE O VOLVER-->
                    <div class="text-right">
                        <button type="button" class="btn btn-primary btn-md" id="id_btn_mod_com" onclick="guardarAlertaContacto();">Guardar</button>
                        <button type="button" class="btn btn-default btn-md" data-dismiss="modal">Cerrar</button>
                    </div>
                    <!-- GUARDAR COMPONENTE O VOLVER-->

                </form>
            </div>
        </div>
    </div>
</div>