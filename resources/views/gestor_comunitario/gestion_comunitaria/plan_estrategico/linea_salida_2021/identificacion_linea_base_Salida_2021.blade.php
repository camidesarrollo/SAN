<!-- INICIO CZ SPRINT 70-->
<div class="form-group">

    <div class="form-group row ml-3">
        <label for="" class="col-sm-3 col-form-label"><b>RUT:</b></label>
        <div class="col-sm-6">
            <input maxlength="100" id="linea_rut" name="linea_rut" onkeypress="return caracteres_especiales(event)" type="input" class="form-control" onblur=""disabled>
            <p id="val_linea_rut" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar un RUT valido.</p>
        </div>                          
    </div>

    <div class="form-group row ml-3">
        <label for="" class="col-sm-3 col-form-label"><b>Nombre y Apellido:</b></label>
        <div class="col-sm-6">
            <input maxlength="100" id="linea_nom" name="linea_nom" onkeypress="return caracteres_especiales(event)" type="input" class="form-control" onblur="" disabled>
            <p id="val_linea_nom" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar un nombre.</p>
        </div>                              
    </div>   
    
    <div class="form-group row ml-3">
        <label for="" class="col-sm-3 col-form-label"><b>Sexo:</b></label>
        <div class="col-sm-6">
            <select name="linea_sexo" class="form-control" id="linea_sexo" disabled>
                <option value="">Seleccione sexo</option>
                <option value="0">Masculino</option>
                <option value="1">Femenino</option>
            </select>
            <p id="val_linea_sexo" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Ingresar sexo.</p>  
        </div>                          
    </div>

    <div class="form-group row ml-3">
        <label for="" class="col-sm-12 col-form-label"><b>¿Usted o alguien de su hogar cuenta con acceso a internet?</b></label>
        <div class="col-sm-6">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="acceso_internet_si" value="1" name="check_acceso_internet[]" disabled>
                <label class="form-check-label" for="label_acceso_internet_si">Si</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="acceso_interernet_no" value="0" name="check_acceso_internet[]" disabled>
                <label class="form-check-label" for="label_acceso_interernet_no">No</label>
            </div>
            <p id="val_linea_acesso_internet" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar respuesta de acceso a internet.</p>  
        </div>                          
    </div>

    <div class="form-group row ml-3">
        <label for="" class="col-sm-12 col-form-label"><b>¿Usted o alguien de su hogar cuenta con equipos que permitan la comunicación a distancia? (Teléfono, Tablet, Notebook, PC)</b></label>
        <div class="col-sm-6">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="equipos_comunicacion_si" value="1"  name="check_equipos_comunicacion[]" disabled>
                <label class="form-check-label" for="label_equipos_comunicacion_si">Si</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="equipos_comunicacion_no" value="0" name="check_equipos_comunicacion[]" disabled>
                <label class="form-check-label" for="label_equipos_comunicacion_no">No</label>
            </div>
            <p id="val_linea_electronico_comunicacion" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar respuesta de acceso a aparatos electrónicos de comunicación.</p>  
        </div>                          
    </div>
    <div class="form-group row ml-3">
        <label for="" class="col-sm-12 col-form-label"><b>¿En su hogar viven niños, niñas y adolescentes (entre 0 y 17 años)?</b></label>
        <div class="col-sm-12">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="viven_nn_si" value="1" name="check_viven_nn[]" disabled>
            <label class="form-check-label" for="label_viven_nn_si">Si</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="viven_nn_no" value="0" name="check_viven_nn[]" disabled>
            <label class="form-check-label" for="label_viven_nn_no">No</label>
        </div>
        <div class="form-check form-check-inline">
                <label class="form-check-label" for="inlineCheckbox2">De responder SI, indique cuántos por tramo etario:</label>
            </div>
</div>
</div>
    <!-- CZ SPRINT 76 -->
    <div class="contenedor-edad">
        <div class="form-group row ml-3">
            <label for="" class="col-sm-3 col-form-label"><b>0-3 años</b></label>
            <div class="col-sm-2 pr-0">
                <input maxlength="3" id="rango_edad_0" name="rango_edad_0" onkeypress="return soloNumeros(event)" type="number" max="100" min="1" class="form-control col-sm-6" onblur="" disabled>
            </div>
        </div>
        <div class="form-group row ml-3">
            <label for="" class="col-sm-3 col-form-label"><b>4-5 años</b></label>
            <div class="col-sm-2 pr-0">
                <input maxlength="3" id="rango_edad_4" name="rango_edad_4" onkeypress="return soloNumeros(event)" type="number" max="100" min="1" class="form-control col-sm-6" onblur="" disabled>
            </div>
        </div>
        <div class="form-group row ml-3">
            <label for="" class="col-sm-3 col-form-label"><b>6-13 años</b></label>
            <div class="col-sm-2 pr-0">
                <input maxlength="3" id="rango_edad_6" name="rango_edad_6" onkeypress="return soloNumeros(event)" type="number" max="100" min="1" class="form-control col-sm-6" onblur="" disabled>
            </div>                          
            </div>
        <div class="form-group row ml-3">
            <label for="" class="col-sm-3 col-form-label"><b>14-17 años</b></label>
            <div class="col-sm-2 pr-0">
                <input maxlength="3" id="rango_edad_14" name="rango_edad_14" onkeypress="return soloNumeros(event)" type="number" max="100" min="1" class="form-control col-sm-6" onblur="" disabled>
            </div>
         </div>                          
    </div>
    <!-- CZ SPRINT 76 -->
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
            <input maxlength="100" id="linea_cal" name="linea_cal" onkeypress="return caracteres_especiales(event)" type="input" class="form-control" onblur="" disabled>
            <p id="val_linea_cal" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Ingresar una calle.</p>            
        </div>               
        <div class="col-sm-3">
            <label for="" class=" col-form-label"><b>Número:</b></label>
            <input maxlength="100" id="linea_num" name="linea_num" onkeypress="return soloNumeros(event)" type="input" class="form-control" onblur="" disabled>
            <p id="val_linea_num" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Ingresar un número.</p>            
        </div>
        <div class="col-sm-3">
            <label for="" class=" col-form-label"><b>Block:</b></label>
            <input maxlength="100" id="linea_bloc" name="linea_bloc" onkeypress="return caracteres_especiales(event)" type="input" class="form-control" onblur="" disabled>
            <p id="val_linea_bloc" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Ingresar una departamento.</p>            
        </div>        
        <div class="col-sm-3">
            <label for="" class=" col-form-label"><b>Departamento:</b></label>
            <input maxlength="100" id="linea_dep" name="linea_dep" onkeypress="return caracteres_especiales(event)" type="input" class="form-control" onblur="" disabled>
            <p id="val_linea_dep" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Ingresar un block.</p>            
        </div>
    </div>
    <div class="form-group row ml-3">
        <label for="" class="col-sm-3 col-form-label"><b>Teléfono:</b></label>
        <div class="col-sm-4">
            <input maxlength="10" id="linea_telf" name="linea_telf" onkeypress="return soloNumeros(event)" type="input" class="form-control" onblur="" disabled>
            <!-- <p id="val_linea_telf" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar una teléfono.</p> --><!--  inicio ch -->
        </div>                              
    </div>
    <div class="form-group row ml-3">
        <label for="" class="col-sm-3 col-form-label"><b>Correo:</b></label>
        <div class="col-sm-6">
            <input maxlength="100" id="linea_correo" name="linea_correo" onkeypress="" type="email" class="form-control" onblur="" disabled>
            <!-- <p id="val_linea_correo" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar un correo.</p> --><!-- fin ch -->
        </div>                              
    </div>
    <div class="form-group row ml-3">            
        <label for="" class="col-sm-3 col-form-label"><b>Edad:</b></label>
        <!-- inicio ch -->
        <div class="col-sm-2 pr-0">
            <input maxlength="3" id="linea_edad" name="linea_edad" onkeypress="return soloNumeros(event)" type="number" max="100" min="1"class="form-control col-sm-6" onblur="" disabled>
            <p id="val_linea_edad" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar una edad.</p>
            <!-- inicio ch -->
            <p id="val_linea_edad1" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar una edad válida.</p>
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
            <input maxlength="100" id="linea_com" name="linea_com" onkeypress="return caracteres_especiales(event)" type="input" class="form-control" onblur="" value="{{ Session::get('comuna') }}" disabled>
            <p id="val_linea_com" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Ingresar una comuna.</p>            
        </div>
    </div>
</div>
<script type="text/javascript">

    function limpiarfrmIdentificacionLB_2021(){

        $("#linea_nom").val("");
        $("#linea_rut").val("");
        //$("#linea_com").val("");
        // $("#linea_dir").val("");
        $("#linea_cal").val("");
        $("#linea_num").val("");
        $("#linea_bloc").val("");
        $("#linea_dep").val("");
        $("#linea_telf").val("");
        $("#linea_correo").val("");
        $("#linea_edad").val("");
        $("#linea_sexo option[value="+ 0+"]").attr("selected",false);
        $("#linea_sexo option[value="+ 1+"]").attr("selected",false);
        $('input[name="check_acceso_internet[]"]').prop('checked', false);
        $('input[name="check_equipos_comunicacion[]"]').prop('checked', false);
        $('input[name="check_viven_nn[]"]').prop('checked', false);
        $('input[name="check_rango_edad[]"]').prop('checked', false);
    }

    function limpiarfrmValidadiones_2021(){

        $("#val_linea_nom").hide();
        $("#val_linea_rut").hide();
        $("#val_linea_com").hide();
        $("#val_linea_cal").hide();
        $("#val_linea_num").hide();
        $("#val_linea_bloc").hide();
        $("#val_linea_dep").hide();
        $("#val_linea_telf").hide();
        $("#val_linea_correo").hide();
        $("#val_linea_edad").hide();
        $("#val_linea_sexo").hide();
        $("#val_linea_acesso_internet").hide();
        $("#val_linea_electronico_comunicacion").hide();
        $("#val_viven_nna").hide();
        $("#val_rago_edad").hide();
        //se elimina validacion extra 

        $("#linea_nom").removeClass("is-invalid");
        $("#linea_rut").removeClass("is-invalid");
        $("#linea_com").removeClass("is-invalid");
        $("#linea_cal").removeClass("is-invalid");
        $("#linea_num").removeClass("is-invalid");
        $("#linea_bloc").removeClass("is-invalid");
        $("#linea_dep").removeClass("is-invalid");
        $("#linea_telf").removeClass("is-invalid");
        $("#linea_correo").removeClass("is-invalid");
        $("#linea_edad").removeClass("is-invalid");
        $("#linea_sexo").removeClass("is-invalid");
        $('input[name="check_acceso_internet[]"]').removeClass("is-invalid");
        $('input[name="check_equipos_comunicacion[]"]').removeClass("is-invalid");
        $("#viven_nn_si").removeClass("is-invalid");
        $("#viven_nn_no").removeClass("is-invalid");
        $("#rango_edad_0_3").removeClass("is-invalid");
        $("#rango_edad_4_5").removeClass("is-invalid");
        $("#rango_edad_6_13").removeClass("is-invalid");
        $("#rango_edad_14_17").removeClass("is-invalid");
        
    }

    function validarfrmIdentificacionLB_2021(){
        limpiarfrmValidadiones_2021();
        let respuesta = true;

        let linea_nom = $("#linea_nom").val();
        let linea_rut = $("#linea_rut").val();
        let linea_com = $("#linea_com").val();
        // let linea_dir = $("#linea_dir").val();
        let linea_cal = $("#linea_cal").val();
        let linea_num = $("#linea_num").val();
        let linea_bloc = $("#linea_bloc").val();
        let linea_dep = $("#linea_dep").val();
        let linea_telf = $("#linea_telf").val();
        let linea_correo = $("#linea_correo").val();
        let linea_edad = $("#linea_edad").val();
        let linea_sexo = $("#linea_sexo").val();
        let acceso_internet_si = $("#acceso_internet_si").val();
        let acceso_internet_no = $("#acceso_internet_no").val();
        let equipos_comunicacion_si = $("#equipos_comunicacion_si").val();
        let equipos_comunicacion_no = $("#equipos_comunicacion_no").val();
        let viven_nn_si = $("#viven_nn_si");
        let viven_nn_no = $("#viven_nn_no");
        let rango_edad_0_3 = $("#rango_edad_0-3");
        let rango_edad_4_5 = $("#rango_edad_4-5");
        let rango_edad_6_13 = $("#rango_edad_6-13");
        let rango_edad_14_17 = $("#rango_edad_14-17");       

        if (linea_nom == "" || typeof linea_nom === "undefined"){
            respuesta = false;
            $("#val_linea_nom").show();
            $("#linea_nom").addClass("is-invalid");
        }

        if (linea_rut == "" || typeof linea_rut === "undefined"){
            respuesta = false;
            $("#val_linea_rut").show();
            $("#linea_rut").addClass("is-invalid");
        }

        if (linea_com == "" || typeof linea_com === "undefined"){
            respuesta = false;
            $("#val_linea_com").show();
            $("#linea_com").addClass("is-invalid");
        }

        if (linea_cal == "" || typeof linea_cal === "undefined"){
            respuesta = false;
            $("#val_linea_cal").show();
            $("#linea_cal").addClass("is-invalid");
        }

        if (linea_num == "" || typeof linea_num === "undefined"){
            respuesta = false;
            $("#val_linea_num").show();
            $("#linea_num").addClass("is-invalid");
        }

        if (linea_telf == "" || typeof linea_telf === "undefined"){
            respuesta = true;
            $("#val_linea_telf").show();
        }

        if (linea_correo == "" || typeof linea_correo === "undefined"){
            respuesta = true;
            $("#val_linea_correo").show();

        }else{
            let regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if(!regex.test(linea_correo)){
                respuesta = false;
                $("#val_linea_correo").show();
                $("#linea_correo").addClass("is-invalid");
            }
        }

        if (linea_edad == "" || typeof linea_edad === "undefined"){
            respuesta = false;
            $("#val_linea_edad").show();
            $("#linea_edad").addClass("is-invalid");
            
        }

        if(linea_edad > 100){
            respuesta = false;
            $("#val_linea_edad1").show();
            $("#linea_edad").addClass("is-invalid");
        }

        if(linea_sexo == "" || typeof linea_sexo === "undefined" ){
            $("#val_linea_sexo").show();
            $("#linea_sexo").addClass("is-invalid");
        }
        
        if ( $('input[id="acceso_internet_si"]').prop('checked') == false && $('input[id="acceso_interernet_no"]').prop('checked') == false){  
            $("#val_linea_acesso_internet").show();
            $('input[id="acceso_interernet_no"]').addClass("is-invalid");
            $('input[id="acceso_internet_si"]').addClass("is-invalid");
        } 
        if ($('input[id="equipos_comunicacion_si"]').prop('checked') == false && $('input[id="equipos_comunicacion_no"]').prop('checked') == false){  
            $("#val_linea_electronico_comunicacion").show();
            $('input[name="check_equipos_comunicacion[]"]').addClass("is-invalid");
        } 
        if (  $('input[id="viven_nn_si"]').prop('checked') == false && $('input[id="viven_nn_no"]').prop('checked') == false){  
            $("#val_viven_nna").show();
            $('input[name="check_viven_nn[]"]').addClass("is-invalid");
        } 
        if($('input[id="viven_nn_si"]').prop('checked') == true || $('input[id="viven_nn_no"]').prop('checked') == true){
            if ($('input[id="rango_edad_0_3"]').prop('checked') == false && $('input[id="rango_edad_4_5"]').prop('checked') == false && $('input[id="rango_edad_6_13"]').prop('checked') == false && $('input[id="rango_edad_14_17"]').prop('checked') == false){  
                $("#val_rago_edad").show();
                $('input[id="rango_edad_0_3"]').addClass("is-invalid");
                $('input[id="rango_edad_4_5"]').addClass("is-invalid");
                $('input[id="rango_edad_6_13"]').addClass("is-invalid");
                $('input[id="rango_edad_14_17"]').addClass("is-invalid");
            } 
        }
        return respuesta;

    }

    function recolectarDataIdentificacionLS_2021(){

        let data = new Object();
        let run = limpiarFormatoRun($("#linea_rut").val());
		run = dividirRut(run);
        
        let acceso_internet_si = $("#acceso_internet_si").val();
        let acceso_internet_no = $("#acceso_internet_no").val();
        let equipos_comunicacion_si = $("#equipos_comunicacion_si").val();
        let equipos_comunicacion_no = $("#equipos_comunicacion_no").val();
        let viven_nn_si = $("#viven_nn_si").val();
        let viven_nn_no = $("#viven_nn_no").val();
        // CZ SPRINT 76
        let rango_edad_0_3 = $("#rango_edad_0").val();
        let rango_edad_4_5 = $("#rango_edad_4").val();
        let rango_edad_6_13 = $("#rango_edad_6").val();
        let rango_edad_14_17 = $("#rango_edad_14").val();  
        // CZ SPRINT 76
        data.iden_nombre = $("#linea_nom").val();
        data.iden_run = run[0];
        data.iden_dv  = run[1];
        data.iden_comuna = $("#linea_com").val();
        // data.lin_bas_dir = $("#linea_dir").val();
        data.iden_calle = $("#linea_cal").val();
        data.iden_numero = $("#linea_num").val();
        data.iden_block = $("#linea_bloc").val();
        data.iden_departamento = $("#linea_dep").val();
        data.iden_fono = $("#linea_telf").val();
        data.iden_correo = $("#linea_correo").val();
        data.iden_edad = $("#linea_edad").val();
        data.iden_sexo = $("#linea_sexo").val();
        // CZ SPRINT 76
        data.rango_edad_0_3_linea_base = rango_edad_0_3;
        data.rango_edad_4_5_linea_base = rango_edad_4_5;
        data.rango_edad_6_13_linea_base = rango_edad_6_13;
        data.rango_edad_14_17_linea_base = rango_edad_14_17;
        // CZ SPRINT 76
        $('input[name="check_acceso_internet[]"]:checked').each(function() {
            data.iden_internet = $(this).val();
        });
        $('input[name="check_equipos_comunicacion[]"]:checked').each(function() {
            data.iden_electronicos = $(this).val();
        });
        $('input[name="check_viven_nn[]"]:checked').each(function() {
            data.iden_hogar_nna = $(this).val();
        });
        $('input[name="check_rango_edad[]"]:checked').each(function() {
            data.iden_hogar_rango_nna = $(this).val();
        });
        return data;
    }

    function getDataIdentificacionSalida_2021(id){
        $('#viven_nn_si').prop('checked', false);
        $('#viven_nn_no').prop('checked', false);
        $('#acceso_internet_si').prop('checked', false);
        $('#acceso_internet_no').prop('checked', false);
        $('#equipos_comunicacion_si').prop('checked', false);
        $('#equipos_comunicacion_no').prop('checked', false);
        $('#rango_edad_0_3').prop('checked', false);
        $('#rango_edad_4_5').prop('checked', false);
        $('#rango_edad_6_13').prop('checked', false);
        $('#rango_edad_14_17').prop('checked', false);
        let data = new Object();
        
        data.id = id;

        $.ajax({
            type: "GET",
            url: "{{route('editar.linea.ident_2021')}}",
            data: data
        }).done(function(resp){
            
            iden_lb = $.parseJSON(resp.iden_lb);
            $('#linea_nom').val(iden_lb.iden_nombre);
            var linerun = iden_lb.iden_run.toString() +iden_lb.iden_dv.toString()  
            var run = formatearRun(linerun);
            $('#linea_rut').val(run);
            $('#linea_com').val(iden_lb.iden_comuna);
            // $('#linea_dir').val(iden_lb.lin_bas_dir);
            $('#linea_cal').val(iden_lb.iden_calle);
            $('#linea_num').val(iden_lb.iden_numero);
            $('#linea_bloc').val(iden_lb.iden_block);
            $('#linea_dep').val(iden_lb.iden_departamento);
            $('#linea_telf').val(iden_lb.iden_fono);
            $('#linea_correo').val(iden_lb.iden_correo);
            $('#linea_edad').val(iden_lb.iden_edad);
            $("#linea_sexo option[value="+ iden_lb.iden_sexo +"]").attr("selected",true);
            $('input[name="check_acceso_internet[]"]').each(function() {
                if($(this).val() == iden_lb.iden_internet){
                    $(this).prop('checked', true)
                }else{
                    $(this).prop('checked', false)
                }
                
            });
            $('input[name="check_equipos_comunicacion[]"]').each(function() {
                if($(this).val() == iden_lb.iden_electronicos){
                    $(this).prop('checked', true);
                }else{
                    $(this).prop('checked', false)
                }
                
            });
            $('input[name="check_viven_nn[]"]').each(function() {
                if($(this).val() == iden_lb.iden_hogar_nna){
                    $(this).prop('checked', true);
                }else{
                    $(this).prop('checked', false)
                }
                
            });
// CZ SPRINT 76
            if(iden_lb.iden_hogar_nna == 1){
                $(".contenedor-edad").css("display","block");
                $("#rango_edad_0").val(iden_lb.iden_cant_rang_1);
                $("#rango_edad_4").val(iden_lb.iden_cant_rang_2);
                $("#rango_edad_6").val(iden_lb.iden_cant_rang_3);
                $("#rango_edad_14").val(iden_lb.iden_cant_rang_4);
                }else{
                $(".contenedor-edad").css("display","none");
                }
 // CZ SPRINT 76
        }).fail(function(objeto, tipoError, errorHttp){

                manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

                return false;
        });
    }
    
    $('input[name="check_acceso_internet[]"]').on('change', function() {
        $('input[name="check_acceso_internet[]"]').not(this).prop('checked', false);
    });
    $('input[name="check_equipos_comunicacion[]"]').on('change', function() {
        $('input[name="check_equipos_comunicacion[]"]').not(this).prop('checked', false);
    });
    $('input[name="check_viven_nn[]"]').on('change', function() {
        $('input[name="check_viven_nn[]"]').not(this).prop('checked', false);
    });
    $('input[name="check_rango_edad[]"]').on('change', function() {
        $('input[name="check_rango_edad[]"]').not(this).prop('checked', false);
    });
</script>
<!-- FIN CZ SPRINT 70-->