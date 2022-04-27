<div class="row p-2">
    <label class="col-3" for="">Nombre del Gestor/a Comunitario/a a Cargo</label>
    <div class="col-sm-5">
        @if($est_pro_id != config('constantes.plan_estrategico'))
            <input maxlength="100" id="info_gestor" name="info_gestor" onkeypress="return caracteres_especiales(event)" type="input" class="form-control" onblur="registrarInforme();">
            <p id="val_info_gestor" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar un Nombre.</p>
        @else
            <label id="info_gestor" for=""></label>
        @endif
    </div>   
</div>

<div class="row p-2">
    <label class="col-3" for="">Comuna</label>
    <div class="col-sm-5">
        <!-- INICIO CZ SPRINT 55 -->
        @if($est_pro_id != config('constantes.plan_estrategico'))
            <input maxlength="100" id="info_com" name="info_com" onkeypress="return caracteres_especiales(event)" type="input" class="form-control" onblur="registrarInforme();" value="{{ Session::get('comuna') }}" disabled>
            <!-- FIN CZ SPRINT 55 -->
            <p id="val_info_com" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar una Comuna.</p>
        @else
            <label id="info_com" for=""></label>
        @endif
    </div>   
</div>

<div class="row p-2">
    <label class="col-3" for="">Comunidad Priorizada</label>
    <div class="col-5">
        @if($est_pro_id != config('constantes.plan_estrategico'))
            <select name="info_com_pri" class="form-control" id="info_com_pri" onchange="registrarInforme();" disabled>
                <option value="">Seleccione un Opci�n</option>
            </select>
        @else
            <label id="info_com_pri" for=""></label>
        @endif
    </div>
    <p id="val_info_com" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe seleccionar una comunidad priorizada.</p>
</div>

<div class="row p-2">
    <div class="group-form p-3">
            <label for="">Fecha Primer Contacto</label>
            <!-- INICIO CZ  -->
            <div class="input-group date-pick" id="div_info_fec_primer_contacto" data-target-input="nearest">
                <input onkeypress="return caracteres_especiales_fecha(event)" type="text" name="fec_primer_contacto" class="form-control datetimepicker-input " data-target="#div_info_fec_primer_contacto" id="fec_primer_contacto" value="" onblur="registrarInforme();">
                <div class="input-group-append" data-target="#div_info_fec_primer_contacto" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
  
            <p id="val_frm_bit_fec_ing" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe registrar una Fecha</p>
        
    </div>
    <div class="group-form p-3">
            <!-- INICIO CZ SPRINT 55 -->
            <label for="">Fecha de Término DPC</label>
            <!-- FIN CZ SPRINT 55 -->

            <!-- INICIO CZ -->
            <div class="input-group date-pick" id="div_info_fec_termino_dpc" data-target-input="nearest">
                <input onkeypress="return caracteres_especiales_fecha(event)" type="text" name="fec_termino_dpc" class="form-control datetimepicker-input " data-target="#div_info_fec_termino_dpc" id="fec_termino_dpc" value="" onblur="registrarInforme();">
                <div class="input-group-append" data-target="#div_info_fec_termino_dpc" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
            <p id="val_info_fec_ter_dpc" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe registrar una Fecha</p>
        
    </div>
</div>

<script type="text/javascript">
// INICIO CZ
    function dataintroduccion(){
        $('#div_info_fec_primer_contacto').datetimepicker('format', 'DD/MM/Y');
        $('#div_info_fec_termino_dpc').datetimepicker('format', 'DD/MM/Y');
    }
</script>
