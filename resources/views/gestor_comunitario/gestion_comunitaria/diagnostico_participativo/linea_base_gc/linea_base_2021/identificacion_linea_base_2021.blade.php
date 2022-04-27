<div class="form-group">

    <div class="form-group row ml-3">
        <label for="" class="col-sm-3 col-form-label"><b>RUT:</b></label>
        <div class="col-sm-6">
            <input maxlength="100" id="linea_rut_linea_base" name="linea_rut_linea_base"
                onkeypress="return caracteres_especiales(event)" type="input" class="form-control" onblur="">
            <p id="val_linea_rut_linea_base"
                style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar un
                RUT valido.</p>
        </div>                          
    </div>

    <div class="form-group row ml-3">
        <label for="" class="col-sm-3 col-form-label"><b>Nombre y Apellido:</b></label>
        <div class="col-sm-6">
            <input maxlength="100" id="linea_nom_linea_base" name="linea_nom_linea_base"
                onkeypress="return caracteres_especiales(event)" type="input" class="form-control" onblur="" disabled>
            <p id="val_linea_nom_linea_base"
                style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar un
                nombre.</p>
        </div>                              
    </div>   
    
    <div class="form-group row ml-3">
        <label for="" class="col-sm-3 col-form-label"><b>Sexo:</b></label>
        <div class="col-sm-6">
            <select name="linea_sexo_linea_base" class="form-control" id="linea_sexo_linea_base" disabled>
                <option value="">Seleccione sexo</option>
                <option value="0">Masculino</option>
                <option value="1">Femenino</option>
            </select>
            <p id="val_linea_sexo_linea_base"
                style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Ingresar
                sexo.</p>
        </div>                          
    </div>

    <div class="form-group row ml-3">
        <label for="" class="col-sm-12 col-form-label"><b>¿Usted o alguien de su hogar cuenta con acceso a
                internet?</b></label>
        <div class="col-sm-6">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="acceso_internet_si_linea_base" value="1"
                    name="check_acceso_internet_linea_base[]">
                <label class="form-check-label" for="label_acceso_internet_si_linea_base">Si</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="acceso_interernet_no_linea_base" value="0"
                    name="check_acceso_internet_linea_base[]">
                <label class="form-check-label" for="label_acceso_interernet_no_linea_base">No</label>
            </div>
            <p id="val_linea_acesso_internet"
                style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar
                respuesta de acceso a internet.</p>
        </div>                          
    </div>

    <div class="form-group row ml-3">
        <label for="" class="col-sm-12 col-form-label"><b>¿Usted o alguien de su hogar cuenta con equipos que permitan
                la comunicación a distancia? (Teléfono, Tablet, Notebook, PC)</b></label>
        <div class="col-sm-6">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="equipos_comunicacion_si_linea_base" value="1"
                    name="check_equipos_comunicacion_linea_base[]">
                <label class="form-check-label" for="label_equipos_comunicacion_si_linea_base">Si</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="equipos_comunicacion_no_linea_base" value="0"
                    name="check_equipos_comunicacion_linea_base[]">
                <label class="form-check-label" for="label_equipos_comunicacion_no_linea_base">No</label>
            </div>
            <p id="val_linea_electronico_comunicacion"
                style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar
                respuesta de acceso a aparatos electrónicos de comunicación.</p>
        </div>                          
    </div>
    <div class="form-group row ml-3">
        <label for="" class="col-sm-12 col-form-label"><b>¿En su hogar viven niños, niñas y adolescentes (entre 0 y 17
                años)?</b></label>
        <div class="col-sm-12">
        <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="viven_nn_si_linea_base" value="1"
                    name="check_viven_nn_linea_base[]">
            <label class="form-check-label" for="label_viven_nn_si_linea_base">Si</label>
        </div>
        <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="viven_nn_no_linea_base" value="0"
                    name="check_viven_nn_linea_base[]">
            <label class="form-check-label" for="label_viven_nn_no_linea_base">No</label>
        </div>
        <div class="form-check form-check-inline">
                <label class="form-check-label" for="inlineCheckbox2">De responder SI, indique cuántos NNA por tramo
                    etario:</label>
            </div>
</div>
    </div>
    <div class="contenedor-edad">
        <div class="form-group row ml-3">
            <label for="" class="col-sm-3 col-form-label"><b>0-3 años</b></label>
            <div class="col-sm-2 pr-0">
                <input maxlength="3" id="rango_edad" name="rango_edad"
                onkeypress="return soloNumeros(event)" type="number" max="99" min="1" class="form-control col-sm-6"
                onblur=""> 
            </div>
        </div>
        <div class="form-group row ml-3">
            <label for="" class="col-sm-3 col-form-label"><b>4-5 años</b></label>
            <div class="col-sm-2 pr-0">
                <input maxlength="3" id="rango_edad_b" name="rango_edad_b"
                onkeypress="return soloNumeros(event)" type="number" max="99" min="1" class="form-control col-sm-6"
                onblur=""> 
            </div>
        </div>
        <div class="form-group row ml-3">
            <label for="" class="col-sm-3 col-form-label"><b>6-13 años</b></label>
            <div class="col-sm-2 pr-0">
            <input maxlength="3" id="rango_edad_c" name="rango_edad_c"
                onkeypress="return soloNumeros(event)" type="number" max="99" min="1" class="form-control col-sm-6"
                onblur="">             </div>                          
            </div>
        <div class="form-group row ml-3">
            <label for="" class="col-sm-3 col-form-label"><b>14-17 años</b></label>
            <div class="col-sm-2 pr-0">
            <input maxlength="3" id="rango_edad_d" name="rango_edad_d"
                onkeypress="return soloNumeros(event)" type="number" max="99" min="1" class="form-control col-sm-6"
                onblur="">    
            </div>
</div>                          
    </div>
    
    <div class="form-group row ml-3">        
        <label for="" class="col-sm-3"><b><u>Dirección:</u></b></label>              
        <div class="col-sm-6">
            <!-- <input maxlength="100" id="linea_dir" name="linea_dir" onkeypress="return caracteres_especiales(event)" type="input" class="form-control" onblur=""> -->
            <!-- <p id="val_linea_dir" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Ingresar una dirección.</p>       -->      
        </div>
    </div>        
    <div class="form-group row p-3"> 
        <div class="col-sm-3">
            <label for="" class=" col-form-label"><b>Calle:</b></label>
            <input maxlength="100" id="linea_cal_linea_base" name="linea_cal_linea_base"
                onkeypress="return caracteres_especiales(event)" type="input" class="form-control" onblur="">
            <p id="val_linea_cal_linea_base"
                style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Ingresar una
                calle.</p>
        </div>               
        <div class="col-sm-3">
            <label for="" class=" col-form-label"><b>Número:</b></label>
            <input maxlength="100" id="linea_num_linea_base" name="linea_num_linea_base"
                onkeypress="return soloNumeros(event)" type="input" class="form-control" onblur="">
            <p id="val_linea_num_linea_base"
                style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Ingresar un
                número.</p>
        </div>
        <div class="col-sm-3">
            <label for="" class=" col-form-label"><b>Block:</b></label>
            <input maxlength="100" id="linea_bloc_linea_base" name="linea_bloc_linea_base"
                onkeypress="return caracteres_especiales(event)" type="input" class="form-control" onblur="">
            <p id="val_linea_bloc_linea_base"
                style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Ingresar una
                departamento.</p>
        </div>        
        <div class="col-sm-3">
            <label for="" class=" col-form-label"><b>Departamento:</b></label>
            <input maxlength="100" id="linea_dep_linea_base" name="linea_dep_linea_base"
                onkeypress="return caracteres_especiales(event)" type="input" class="form-control" onblur="">
            <p id="val_linea_dep_linea_base"
                style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Ingresar un
                block.</p>
        </div>
    </div>
    <div class="form-group row ml-3">
        <label for="" class="col-sm-3 col-form-label"><b>Teléfono:</b></label>
        <div class="col-sm-4">
            <input maxlength="10" id="linea_telf_linea_base" name="linea_telf_linea_base"
                onkeypress="return soloNumeros(event)" type="input" class="form-control" onblur="">
            <!-- <p id="val_linea_telf_linea_base" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar una teléfono.</p> -->
            <!--  inicio ch -->
        </div>                              
    </div>
    <div class="form-group row ml-3">
        <label for="" class="col-sm-3 col-form-label"><b>Correo:</b></label>
        <div class="col-sm-6">
            <input maxlength="100" id="linea_correo_linea_base" name="linea_correo_linea_base" onkeypress=""
                type="email" class="form-control" onblur="">
            <!-- <p id="val_linea_correo_linea_base" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar un correo.</p> -->
            <!-- fin ch -->
        </div>                              
    </div>
    <div class="form-group row ml-3">            
        <label for="" class="col-sm-3 col-form-label"><b>Edad:</b></label>
        <!-- inicio ch -->
        <div class="col-sm-2 pr-0">
            <input maxlength="3" id="linea_edad_linea_base" name="linea_edad_linea_base"
                onkeypress="return soloNumeros(event)" type="number" max="100" min="1" class="form-control col-sm-6"
                onblur="" disabled>
            <p id="val_linea_edad_linea_base"
                style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar una
                edad.</p>
            <!-- inicio ch -->
            <p id="val_linea_edad_linea_base1"
                style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar una
                edad válida.</p>
            <!-- fin ch -->
        </div>   
        <div class="col-sm-4 pl-0">
            <span id="msg"></span>
        </div>   
        <!-- fin ch -->                         
    </div>
    <div class="form-group row ml-3">        
        <label for="" class="col-sm-3"><b>Comuna:</b></label>              
        <div class="col-sm-6">
            <input maxlength="100" id="linea_com_linea_base" name="linea_com_linea_base"
                onkeypress="return caracteres_especiales(event)" type="input" class="form-control" onblur=""
                value="{{ Session::get('comuna') }}" disabled>
            <p id="val_linea_com_linea_base"
                style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Ingresar una
                comuna.</p>
        </div>
    </div>
</div>
<script type="text/javascript">
    function limpiarfrmValidadiones_2021(){

        $("#val_linea_nom_linea_base").hide();
        $("#val_linea_rut_linea_base").hide();
        $("#val_linea_com_linea_base").hide();
        $("#val_linea_cal_linea_base").hide();
        $("#val_linea_num_linea_base").hide();
        $("#val_linea_bloc_linea_base").hide();
        $("#val_linea_dep_linea_base").hide();
        $("#val_linea_telf_linea_base").hide();
        $("#val_linea_correo_linea_base").hide();
        $("#val_linea_edad_linea_base").hide();
        $("#val_linea_sexo_linea_base").hide();
        $("#val_linea_acesso_internet").hide();
        $("#val_linea_electronico_comunicacion").hide();
        $("#val_viven_nna").hide();
        $("#val_rago_edad").hide();
        //se elimina validacion extra 

        $("#linea_nom_linea_base").removeClass("is-invalid");
        $("#linea_rut_linea_base").removeClass("is-invalid");
        $("#linea_com_linea_base").removeClass("is-invalid");
        $("#linea_cal_linea_base").removeClass("is-invalid");
        $("#linea_num_linea_base").removeClass("is-invalid");
        $("#linea_bloc_linea_base").removeClass("is-invalid");
        $("#linea_dep_linea_base").removeClass("is-invalid");
        $("#linea_telf_linea_base").removeClass("is-invalid");
        $("#linea_correo_linea_base").removeClass("is-invalid");
        $("#linea_edad_linea_base").removeClass("is-invalid");
        $("#linea_sexo_linea_base").removeClass("is-invalid");
        $('input[name="check_acceso_internet_linea_base[]"]').removeClass("is-invalid");
        $('input[name="check_equipos_comunicacion_linea_base[]"]').removeClass("is-invalid");
        $("#viven_nn_si_linea_base").removeClass("is-invalid");
        $("#viven_nn_no_linea_base").removeClass("is-invalid");
        $("#rango_edad").removeClass("is-invalid");
        $("#rango_edad_b").removeClass("is-invalid");
        $("#rango_edad_c").removeClass("is-invalid");
        $("#rango_edad_d").removeClass("is-invalid");
        
    }

    function validarfrmIdentificacionLB_2021(){
        limpiarfrmValidadiones_2021();
        let respuesta = true;

        let linea_nom_linea_base = $("#linea_nom_linea_base").val();
        let linea_rut_linea_base = $("#linea_rut_linea_base").val();
        let linea_com_linea_base = $("#linea_com_linea_base").val();
        // let linea_dir = $("#linea_dir").val();
        let linea_cal_linea_base = $("#linea_cal_linea_base").val();
        let linea_num_linea_base = $("#linea_num_linea_base").val();
        let linea_bloc_linea_base = $("#linea_bloc_linea_base").val();
        let linea_dep_linea_base = $("#linea_dep_linea_base").val();
        let linea_telf_linea_base = $("#linea_telf_linea_base").val();
        let linea_correo_linea_base = $("#linea_correo_linea_base").val();
        let linea_edad_linea_base = $("#linea_edad_linea_base").val();
        let linea_sexo_linea_base = $("#linea_sexo_linea_base").val();
        let acceso_internet_si_linea_base = $("#acceso_internet_si_linea_base").val();
        let acceso_internet_no = $("#acceso_internet_no").val();
        let equipos_comunicacion_si_linea_base = $("#equipos_comunicacion_si_linea_base").val();
        let equipos_comunicacion_no_linea_base = $("#equipos_comunicacion_no_linea_base").val();
        let viven_nn_si_linea_base = $("#viven_nn_si_linea_base");
        let viven_nn_no_linea_base = $("#viven_nn_no_linea_base");
        let rango_edad_0_3_linea_base = $("#rango_edad_0-3");
        let rango_edad_4_5_linea_base = $("#rango_edad_4-5");
        let rango_edad_6_13_linea_base = $("#rango_edad_6-13");
        let rango_edad_14_17_linea_base = $("#rango_edad_14-17");       

        if (linea_nom_linea_base == "" || typeof linea_nom_linea_base === "undefined"){
            respuesta = false;
            $("#val_linea_nom_linea_base").show();
            $("#linea_nom_linea_base").addClass("is-invalid");
        }

        if (linea_rut_linea_base == "" || typeof linea_rut_linea_base === "undefined"){
            respuesta = false;
            $("#val_linea_rut_linea_base").show();
            $("#linea_rut_linea_base").addClass("is-invalid");
        }

        if (linea_com_linea_base == "" || typeof linea_com_linea_base === "undefined"){
            respuesta = false;
            $("#val_linea_com_linea_base").show();
            $("#linea_com_linea_base").addClass("is-invalid");
        }

        if (linea_cal_linea_base == "" || typeof linea_cal_linea_base === "undefined"){
            respuesta = false;
            $("#val_linea_cal_linea_base").show();
            $("#linea_cal_linea_base").addClass("is-invalid");
        }

        if (linea_num_linea_base == "" || typeof linea_num_linea_base === "undefined"){
            respuesta = false;
            $("#val_linea_num_linea_base").show();
            $("#linea_num_linea_base").addClass("is-invalid");
        }

        if (linea_telf_linea_base == "" || typeof linea_telf_linea_base === "undefined"){
            respuesta = true;
            $("#val_linea_telf_linea_base").show();
        }

        if (linea_correo_linea_base == "" || typeof linea_correo_linea_base === "undefined"){
            respuesta = true;
            $("#val_linea_correo_linea_base").show();

        }else{
            let regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if(!regex.test(linea_correo_linea_base)){
                respuesta = false;
                $("#val_linea_correo_linea_base").show();
                $("#linea_correo_linea_base").addClass("is-invalid");
            }
        }

        if (linea_edad_linea_base == "" || typeof linea_edad_linea_base === "undefined"){
            respuesta = false;
            $("#val_linea_edad_linea_base").show();
            $("#linea_edad_linea_base").addClass("is-invalid");
            
        }

        if(linea_edad_linea_base > 100){
            respuesta = false;
            $("#val_linea_edad_linea_base1").show();
            $("#linea_edad_linea_base").addClass("is-invalid");
        }

        if(linea_sexo_linea_base == "" || typeof linea_sexo_linea_base === "undefined" ){
            $("#val_linea_sexo_linea_base").show();
            $("#linea_sexo_linea_base").addClass("is-invalid");
        }
        
    if ($('input[id="acceso_internet_si_linea_base"]').prop('checked') == false && $(
            'input[id="acceso_interernet_no_linea_base"]').prop('checked') == false) {
            respuesta = false;
            $("#val_linea_acesso_internet").show();
            $('input[id="acceso_interernet_no_linea_base"]').addClass("is-invalid");
            $('input[id="acceso_internet_si_linea_base"]').addClass("is-invalid");
        } 
    if ($('input[id="equipos_comunicacion_si_linea_base"]').prop('checked') == false && $(
            'input[id="equipos_comunicacion_no_linea_base"]').prop('checked') == false) {
            respuesta = false;
            $("#val_linea_electronico_comunicacion").show();
            $('input[name="check_equipos_comunicacion_linea_base[]"]').addClass("is-invalid");
        } 
    if ($('input[id="viven_nn_si_linea_base"]').prop('checked') == false && $('input[id="viven_nn_no_linea_base"]')
        .prop('checked') == false) {
            respuesta = false;
            $("#val_viven_nna").show();
            $('input[name="check_viven_nn_linea_base[]"]').addClass("is-invalid");
        } 
        if($('input[id="viven_nn_si_linea_base"]').prop('checked') == true){
        if ($("#rango_edad_0_3_linea_base") == "" && $("#rango_edad_4_5_linea_base") == "" && $("#rango_edad_6_13_linea_base") == "" && $("#rango_edad_14_17_linea_base") == "") {
                respuesta = false;
                $("#val_rago_edad").show();
                $('input[id="rango_edad_0_3_linea_base"]').addClass("is-invalid");
                $('input[id="rango_edad_4_5_linea_base"]').addClass("is-invalid");
                $('input[id="rango_edad_6_13_linea_base"]').addClass("is-invalid");
                $('input[id="rango_edad_14_17_linea_base"]').addClass("is-invalid");
            } 
        }
        return respuesta;

    }

    function recolectarDataIdentificacionLB_2021(){

        let data = new Object();
        let run = limpiarFormatoRun($("#linea_rut_linea_base").val());
		run = dividirRut(run);
        
        let acceso_internet_si_linea_base = $("#acceso_internet_si_linea_base").val();
        let acceso_internet_no = $("#acceso_internet_no").val();
        let equipos_comunicacion_si_linea_base = $("#equipos_comunicacion_si_linea_base").val();
        let equipos_comunicacion_no_linea_base = $("#equipos_comunicacion_no_linea_base").val();
        let viven_nn_si_linea_base = $("#viven_nn_si_linea_base").val();
        let viven_nn_no_linea_base = $("#viven_nn_no_linea_base").val();
    let rango_edad_0_3_linea_base = $("#rango_edad").val();
    let rango_edad_4_5_linea_base = $("#rango_edad_b").val();
    let rango_edad_6_13_linea_base = $("#rango_edad_c").val();
    let rango_edad_14_17_linea_base = $("#rango_edad_d").val();

        data.iden_nombre = $("#linea_nom_linea_base").val();
        data.iden_run = run[0];
        data.iden_dv  = run[1];
        data.iden_comuna = $("#linea_com_linea_base").val();
        // data.lin_bas_dir = $("#linea_dir").val();
        data.iden_calle = $("#linea_cal_linea_base").val();
        data.iden_numero = $("#linea_num_linea_base").val();
        data.iden_block = $("#linea_bloc_linea_base").val();
        data.iden_departamento = $("#linea_dep_linea_base").val();
        data.iden_fono = $("#linea_telf_linea_base").val();
        data.iden_correo = $("#linea_correo_linea_base").val();
        data.iden_edad = $("#linea_edad_linea_base").val();
        data.iden_sexo = $("#linea_sexo_linea_base").val();
        $('input[name="check_acceso_internet_linea_base[]"]:checked').each(function() {
            data.iden_internet = $(this).val();
        });
        $('input[name="check_equipos_comunicacion_linea_base[]"]:checked').each(function() {
            data.iden_electronicos = $(this).val();
        });
        $('input[name="check_viven_nn_linea_base[]"]:checked').each(function() {
            data.iden_hogar_nna = $(this).val();
        });
    data.rango_edad_0_3_linea_base = rango_edad_0_3_linea_base;
    data.rango_edad_4_5_linea_base = rango_edad_4_5_linea_base;
    data.rango_edad_6_13_linea_base = rango_edad_6_13_linea_base;
    data.rango_edad_14_17_linea_base = rango_edad_14_17_linea_base;
    // $('input[name="check_rango_edad_linea_base[]"]:checked').each(function() {
    //     data.iden_hogar_rango_nna = $(this).val();
    // });
        return data;
    }

    function getDataIdentificacion_2021(id){
        $('#viven_nn_si').prop('checked', false);
        $('#viven_nn_no').prop('checked', false);
        $('#acceso_internet_si').prop('checked', false);
        $('#acceso_internet_no').prop('checked', false);
        $('#equipos_comunicacion_si').prop('checked', false);
        $('#equipos_comunicacion_no').prop('checked', false);
    $('#rango_edad').prop('checked', false);
    $('#rango_edad_b').prop('checked', false);
    $('#rango_edad_c').prop('checked', false);
    $('#rango_edad_d').prop('checked', false);
        let data = new Object();

        data.id = id;

        $.ajax({
            type: "GET",
            url: "{{route('editar.linea.ident_2021')}}",
            data: data
        }).done(function(resp){
            
            iden_lb = $.parseJSON(resp.iden_lb);
        console.log(iden_lb.iden_cant_rang_1);
        $("#rango_edad").val(iden_lb.iden_cant_rang_1);
        $("#rango_edad_b").val(iden_lb.iden_cant_rang_2);
        $("#rango_edad_c").val(iden_lb.iden_cant_rang_3);
        $("#rango_edad_d").val(iden_lb.iden_cant_rang_4);
            $('#linea_nom_linea_base').val(iden_lb.iden_nombre);
            var linerun = iden_lb.iden_run.toString() +iden_lb.iden_dv.toString()  
            var run = formatearRun(linerun);
            $('#linea_rut_linea_base').val(run);
            $('#linea_com_linea_base').val(iden_lb.iden_comuna);
            // $('#linea_dir').val(iden_lb.lin_bas_dir);
            $('#linea_cal_linea_base').val(iden_lb.iden_calle);
            $('#linea_num_linea_base').val(iden_lb.iden_numero);
            $('#linea_bloc_linea_base').val(iden_lb.iden_block);
            $('#linea_dep_linea_base').val(iden_lb.iden_departamento);
            $('#linea_telf_linea_base').val(iden_lb.iden_fono);
            $('#linea_correo_linea_base').val(iden_lb.iden_correo);
            $('#linea_edad_linea_base').val(iden_lb.iden_edad);
            $("#linea_sexo_linea_base option[value="+ iden_lb.iden_sexo +"]").attr("selected",true);
            $('input[name="check_acceso_internet_linea_base[]"]').each(function() {
                if($(this).val() == iden_lb.iden_internet){
                    $(this).prop('checked', true);
                }else{
                    $(this).prop('checked', false)
                }
                
            });
            $('input[name="check_equipos_comunicacion_linea_base[]"]').each(function() {
                if($(this).val() == iden_lb.iden_electronicos){
                    $(this).prop('checked', true);
                }else{
                    $(this).prop('checked', false)
                }
                
            });
            $('input[name="check_viven_nn_linea_base[]"]').each(function() {
                if($(this).val() == iden_lb.iden_hogar_nna){
                    $(this).prop('checked', true);
                }else{
                    $(this).prop('checked', false)
                }
            if(iden_lb.iden_hogar_nna == 0){
                
                $(".contenedor-edad").css("display", "none");
            }else{
                $(".contenedor-edad").css("display", "block");
            }
                
            });

            $('input[name="check_rango_edad_linea_base[]"]').each(function() {
                if($(this).val() == iden_lb.iden_hogar_rango_nna){
                    $(this).prop('checked', true);
                }else{
                    $(this).prop('checked', false)
                }
                
            });
            // $("#linea_acesso_internet option[value="+ iden_lb.iden_internet+"]").attr("selected",true);
            // $("#linea_electronico_comunicacion option[value="+ iden_lb.iden_electronicos+"]").attr("selected",true);


        }).fail(function(objeto, tipoError, errorHttp){

                manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

                return false;
        });
    }
    
    $('input[name="check_acceso_internet_linea_base[]"]').on('change', function() {
        $('input[name="check_acceso_internet_linea_base[]"]').not(this).prop('checked', false);
    });
    $('input[name="check_equipos_comunicacion_linea_base[]"]').on('change', function() {
        $('input[name="check_equipos_comunicacion_linea_base[]"]').not(this).prop('checked', false);
    });
    $('input[name="check_viven_nn_linea_base[]"]').on('change', function() {
        $('input[name="check_viven_nn_linea_base[]"]').not(this).prop('checked', false);
        console.log($(this).val());
        
        if(  $(this).val() == 0){
        $("#rango_edad").prop("disabled", true);
        $("#rango_edad_b").prop("disabled", true);
        $("#rango_edad_c").prop("disabled", true);
        $("#rango_edad_d").prop("disabled", true);
        $(".contenedor-edad").css("display","none");
        
            $('input[name="check_rango_edad_linea_base[]"]').prop('checked', false);
        }else{
        $("#rango_edad").prop("disabled", false);
        $("#rango_edad_b").prop("disabled", false);
        $("#rango_edad_c").prop("disabled", false);
        $("#rango_edad_d").prop("disabled", false);
        $(".contenedor-edad").css("display","block");
        }
        
    });
    $('input[name="check_rango_edad_linea_base[]"]').on('change', function() {
        $('input[name="check_rango_edad_linea_base[]"]').not(this).prop('checked', false);
    });
</script>
