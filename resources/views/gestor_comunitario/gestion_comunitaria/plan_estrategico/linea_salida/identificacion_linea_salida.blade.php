<div class="form-group">

    <div class="form-group row ml-3">
        <label for="" class="col-sm-3 col-form-label"><b>RUT:</b></label>
        <div class="col-sm-6">
            <input maxlength="100" id="linea_rut2" name="linea_rut2" onkeypress="return caracteres_especiales(event)" type="input" class="form-control" onblur="">
            <p id="val_linea_rut2" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar un RUT valido.</p>
        </div>                          
    </div>

    <div class="form-group row ml-3">
        <label for="" class="col-sm-3 col-form-label"><b>Nombre y Apellido:</b></label>
        <div class="col-sm-6">
            <input maxlength="100" id="linea_nom2" name="linea_nom2" onkeypress="return caracteres_especiales(event)" type="input" class="form-control" onblur="">
            <p id="val_linea_nom2" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar un nombre.</p>
        </div>                              
    </div>    

    <div class="form-group row ml-3">        
        <label for="" class="col-sm-3"><b>Comuna:</b></label>              
        <div class="col-sm-6">
            <input maxlength="100" id="linea_com2" name="linea_com2" onkeypress="return caracteres_especiales(event)" type="input" class="form-control" onblur="">
            <p id="val_linea_com2" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Ingresar una comuna.</p>            
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
            <input maxlength="100" id="linea_cal2" name="linea_cal2" onkeypress="return caracteres_especiales(event)" type="input" class="form-control" onblur="">
            <p id="val_linea_cal2" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Ingresar una calle.</p>            
        </div>               
        <div class="col-sm-3">
            <label for="" class=" col-form-label"><b>Número:</b></label>
            <input maxlength="100" id="linea_num2" name="linea_num2" onkeypress="return soloNumeros(event)" type="input" class="form-control" onblur="">
            <p id="val_linea_num2" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Ingresar un número.</p>            
        </div>
        <div class="col-sm-3">
            <label for="" class=" col-form-label"><b>Block:</b></label>
            <input maxlength="100" id="linea_bloc2" name="linea_bloc2" onkeypress="return caracteres_especiales(event)" type="input" class="form-control" onblur="">
            <p id="val_linea_bloc2" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Ingresar una departamento.</p>            
        </div>        
        <div class="col-sm-3">
            <label for="" class=" col-form-label"><b>Departamento:</b></label>
            <input maxlength="100" id="linea_dep2" name="linea_dep2" onkeypress="return caracteres_especiales(event)" type="input" class="form-control" onblur="">
            <p id="val_linea_dep2" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Ingresar un block.</p>            
        </div>
    </div>
    <div class="form-group row ml-3">
        <label for="" class="col-sm-3 col-form-label"><b>Teléfono:</b></label>
        <div class="col-sm-4">
            <input maxlength="10" id="linea_telf2" name="linea_telf2" onkeypress="return soloNumeros(event)" type="input" class="form-control" onblur="">
            <!-- <p id="val_linea_telf" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar una teléfono.</p> --><!--  inicio ch -->
        </div>                              
    </div>
    <div class="form-group row ml-3">
        <label for="" class="col-sm-3 col-form-label"><b>Correo:</b></label>
        <div class="col-sm-6">
            <input maxlength="100" id="linea_correo2" name="linea_correo2" onkeypress="" type="email" class="form-control" onblur="">
            <!-- <p id="val_linea_correo" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar un correo.</p> --><!-- fin ch -->
        </div>                              
    </div>
    <div class="form-group row ml-3">            
        <label for="" class="col-sm-3 col-form-label"><b>Edad:</b></label>
        <!-- inicio ch -->
        <div class="col-sm-2 pr-0">
            <input maxlength="3" id="linea_edad2" name="linea_edad2" onkeypress="return soloNumeros(event)" type="number" max="100" min="1"class="form-control col-sm-6" onblur="">
            <p id="val_linea_edad2" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar una edad.</p>
            <!-- inicio ch -->
            <p id="val_linea_edad3" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar una edad válida.</p>
            <!-- fin ch -->
        </div>   
        <div class="col-sm-4 pl-0">
            <span id="msg"></span>
        </div>   
        <!-- fin ch -->                         
    </div>
</div>
<script type="text/javascript">

    function limpiarfrmIdentificacionLs(){

        $("#linea_nom2").val("");
        $("#linea_rut2").val("");
        $("#linea_com2").val("");
        // $("#linea_dir").val("");
        $("#linea_cal2").val("");
        $("#linea_num2").val("");
        $("#linea_bloc2").val("");
        $("#linea_dep2").val("");
        $("#linea_telf2").val("");
        $("#linea_correo2").val("");
        $("#linea_edad2").val("");
    }

    function limpiarfrmValidadiones(){

        $("#val_linea_nom2").hide();
        $("#val_linea_rut2").hide();
        $("#val_linea_com2").hide();
        // $("#val_linea_dir").hide();
        $("#val_linea_cal2").hide();
        $("#val_linea_num2").hide();
        $("#val_linea_bloc2").hide();
        $("#val_linea_dep2").hide();
        $("#val_linea_telf2").hide();
        $("#val_linea_correo2").hide();
        $("#val_linea_edad2").hide();
        //inicio ch
        $("#val_linea_edad3").hide();
        //fin ch
        //se elimina validacion extra inicio ch

        $("#linea_nom2").removeClass("is-invalid");
        $("#linea_rut2").removeClass("is-invalid");
        $("#linea_com2").removeClass("is-invalid");
        // $("#linea_dir").removeClass("is-invalid");
        $("#linea_cal2").removeClass("is-invalid");
        $("#linea_num2").removeClass("is-invalid");
        $("#linea_bloc2").removeClass("is-invalid");
        $("#linea_dep2").removeClass("is-invalid");
        $("#linea_telf2").removeClass("is-invalid");
        $("#linea_correo2").removeClass("is-invalid");
        $("#linea_edad2").removeClass("is-invalid");

    }
    
    function validarfrmIdentificacionLS(){
        limpiarfrmValidadiones();
        let respuesta = true;

        let linea_nom = $("#linea_nom2").val();
        let linea_rut = $("#linea_rut2").val();
        let linea_com = $("#linea_com2").val();
        // let linea_dir = $("#linea_dir").val();
        let linea_cal = $("#linea_cal2").val();
        let linea_num = $("#linea_num2").val();
        let linea_bloc = $("#linea_bloc2").val();
        let linea_dep = $("#linea_dep2").val();
        let linea_telf = $("#linea_telf2").val();
        let linea_correo = $("#linea_correo2").val();
        let linea_edad = $("#linea_edad2").val();

        
        if (linea_nom == "" || typeof linea_nom === "undefined"){
            respuesta = false;
            $("#val_linea_nom2").show();
            $("#linea_nom2").addClass("is-invalid");
        }

        if (linea_rut == "" || typeof linea_rut === "undefined"){
            respuesta = false;
            $("#val_linea_rut2").show();
            $("#linea_rut2").addClass("is-invalid");
        }

        if (linea_com == "" || typeof linea_com === "undefined"){
            respuesta = false;
            $("#val_linea_com2").show();
            $("#linea_com2").addClass("is-invalid");
        }

        // if (linea_dir == "" || typeof linea_dir === "undefined"){
        //     respuesta = false;
        //     $("#val_linea_dir").show();
        //     $("#linea_dir").addClass("is-invalid");
        // }

        if (linea_cal == "" || typeof linea_cal === "undefined"){
            respuesta = false;
            $("#val_linea_cal2").show();
            $("#linea_cal2").addClass("is-invalid");
        }

        if (linea_num == "" || typeof linea_num === "undefined"){
            respuesta = false;
            $("#val_linea_num2").show();
            $("#linea_num2").addClass("is-invalid");
        }

        if (linea_telf == "" || typeof linea_telf === "undefined"){
            respuesta = true;//inicio ch
            $("#val_linea_telf2").show();
            //$("#linea_telf").addClass("is-invalid"); fin ch
        }

        if (linea_correo == "" || typeof linea_correo === "undefined"){
            respuesta = true;//inicio ch
            $("#val_linea_correo").show();
            //$("#linea_correo").addClass("is-invalid");
        }else{
            let regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if(!regex.test(linea_correo)){
                respuesta = false;//fin ch
                $("#val_linea_correo").show();
                $("#linea_correo2").addClass("is-invalid");
            }
        }

        if (linea_edad2 == "" || typeof linea_edad2 === "undefined"){
            respuesta = false;
            $("#val_linea_edad2").show();
            $("#linea_edad2").addClass("is-invalid");
            
        }
        //inicio ch
        if(linea_edad > 100){
            respuesta = false;
            $("#val_linea_edad3").show();
            $("#linea_edad2").addClass("is-invalid");
        }//fin ch
        return respuesta;

    }

    function recolectarDataIdentificacionLS(){

        let data = new Object();
        let run = limpiarFormatoRun($("#linea_rut2").val());
		run = dividirRut(run);
        
        data.lin_bas_nom = $("#linea_nom2").val();
        data.lin_bas_rut = run[0];
        data.lin_bas_dv  = run[1];
        data.lin_bas_com = $("#linea_com2").val();
        // data.lin_bas_dir = $("#linea_dir").val();
        data.lin_bas_cal = $("#linea_cal2").val();
        data.lin_bas_num = $("#linea_num2").val();
        data.lin_bas_bloc = $("#linea_bloc2").val();
        data.lin_bas_dep = $("#linea_dep2").val();
        data.lin_bas_tel = $("#linea_telf2").val();
        data.lin_bas_cor = $("#linea_correo2").val();
        data.lin_bas_eda = $("#linea_edad2").val();

        return data;
    }

    function getDataIdentificacionLs(id){

        let data = new Object();

        data.id = id;

        $.ajax({
            type: "GET",
            url: "{{route('editar.linea.identls')}}",
            data: data
        }).done(function(resp){


            iden_lb = $.parseJSON(resp.iden_lb);
            
            
            $('#linea_nom2').val(iden_lb.lin_bas_nom);
            $('#linea_rut2').val(iden_lb.lin_bas_rut);
            $('#linea_com2').val(iden_lb.lin_bas_com);
            // $('#linea_dir').val(iden_lb.lin_bas_dir);
            $('#linea_cal2').val(iden_lb.lin_bas_cal);
            $('#linea_num2').val(iden_lb.lin_bas_num);
            $('#linea_bloc2').val(iden_lb.lin_bas_bloc);
            $('#linea_dep2').val(iden_lb.lin_bas_dep);
            $('#linea_telf2').val(iden_lb.lin_bas_tel);
            $('#linea_correo2').val(iden_lb.lin_bas_cor);
            $('#linea_edad2').val(iden_lb.lin_bas_eda);

            $("#ser_niv_com2").val(iden_lb.lin_bas_otr1_1);
            $("#ser_pro_soc2").val(iden_lb.lin_bas_otr2_1);
            $("#ser_ser_sec2").val(iden_lb.lin_bas_otr3_1);
            $("#bie_com2").val(iden_lb.lin_bas_otr4_1);
            $("#bien_org_otr2").val(iden_lb.lin_bas_otr5_1);
            $("#bien_org_part2").val(iden_lb.lin_bas_part_1);

        }).fail(function(objeto, tipoError, errorHttp){

                manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

                return false;
        });
    }
</script>