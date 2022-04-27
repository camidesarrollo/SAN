<div class="form-group">

    <div class="form-group row ml-3">
        <label for="" class="col-sm-3 col-form-label"><b>RUT:</b></label>
        <div class="col-sm-6">
            <input maxlength="100" id="linea_rut" name="linea_rut" onkeypress="return caracteres_especiales(event)" type="input" class="form-control" onblur="">
            <p id="val_linea_rut" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar un RUT valido.</p>
        </div>                          
    </div>


    <div class="form-group row ml-3">
        <label for="" class="col-sm-3 col-form-label"><b>Nombre y Apellido:</b></label>
        <div class="col-sm-6">
            <input maxlength="100" id="linea_nom" name="linea_nom" onkeypress="return caracteres_especiales(event)" type="input" class="form-control" onblur="">
            <p id="val_linea_nom" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar un nombre.</p>
        </div>                              
    </div>    

    <div class="form-group row ml-3">        
        <label for="" class="col-sm-3"><b>Comuna:</b></label>              
        <div class="col-sm-6">
            <input maxlength="100" id="linea_com" name="linea_com" onkeypress="return caracteres_especiales(event)" type="input" class="form-control" onblur="">
            <p id="val_linea_com" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Ingresar una comuna.</p>            
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
            <input maxlength="100" id="linea_cal" name="linea_cal" onkeypress="return caracteres_especiales(event)" type="input" class="form-control" onblur="">
            <p id="val_linea_cal" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Ingresar una calle.</p>            
        </div>               
        <div class="col-sm-3">
            <label for="" class=" col-form-label"><b>Número:</b></label>
            <input maxlength="100" id="linea_num" name="linea_num" onkeypress="return soloNumeros(event)" type="input" class="form-control" onblur="">
            <p id="val_linea_num" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Ingresar un número.</p>            
        </div>
        <div class="col-sm-3">
            <label for="" class=" col-form-label"><b>Block:</b></label>
            <input maxlength="100" id="linea_bloc" name="linea_bloc" onkeypress="return caracteres_especiales(event)" type="input" class="form-control" onblur="">
            <p id="val_linea_bloc" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Ingresar una departamento.</p>            
        </div>        
        <div class="col-sm-3">
            <label for="" class=" col-form-label"><b>Departamento:</b></label>
            <input maxlength="100" id="linea_dep" name="linea_dep" onkeypress="return caracteres_especiales(event)" type="input" class="form-control" onblur="">
            <p id="val_linea_dep" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Ingresar un block.</p>            
        </div>
    </div>
    <div class="form-group row ml-3">
        <label for="" class="col-sm-3 col-form-label"><b>Teléfono:</b></label>
        <div class="col-sm-4">
            <input maxlength="10" id="linea_telf" name="linea_telf" onkeypress="return soloNumeros(event)" type="input" class="form-control" onblur="">
            <!-- <p id="val_linea_telf" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar una teléfono.</p> --><!--  inicio ch -->
        </div>                              
    </div>
    <div class="form-group row ml-3">
        <label for="" class="col-sm-3 col-form-label"><b>Correo:</b></label>
        <div class="col-sm-6">
            <input maxlength="100" id="linea_correo" name="linea_correo" onkeypress="" type="email" class="form-control" onblur="">
            <!-- <p id="val_linea_correo" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar un correo.</p> --><!-- fin ch -->
        </div>                              
    </div>
    <div class="form-group row ml-3">            
        <label for="" class="col-sm-3 col-form-label"><b>Edad:</b></label>
        <!-- inicio ch -->
        <div class="col-sm-2 pr-0">
            <input maxlength="3" id="linea_edad" name="linea_edad" onkeypress="return soloNumeros(event)" type="number" max="100" min="1"class="form-control col-sm-6" onblur="">
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
</div>
<script type="text/javascript">

    function limpiarfrmIdentificacionLB(){

        $("#linea_nom").val("");
        $("#linea_rut").val("");
        $("#linea_com").val("");
        // $("#linea_dir").val("");
        $("#linea_cal").val("");
        $("#linea_num").val("");
        $("#linea_bloc").val("");
        $("#linea_dep").val("");
        $("#linea_telf").val("");
        $("#linea_correo").val("");
        $("#linea_edad").val("");
    }

    function limpiarfrmValidadiones(){

        $("#val_linea_nom").hide();
        $("#val_linea_rut").hide();
        $("#val_linea_com").hide();
        // $("#val_linea_dir").hide();
        $("#val_linea_cal").hide();
        $("#val_linea_num").hide();
        $("#val_linea_bloc").hide();
        $("#val_linea_dep").hide();
        $("#val_linea_telf").hide();
        $("#val_linea_correo").hide();
        $("#val_linea_edad").hide();
        //inicio ch
        $("#val_linea_edad1").hide();
        //fin ch
        //se elimina validacion extra inicio ch

        $("#linea_nom").removeClass("is-invalid");
        $("#linea_rut").removeClass("is-invalid");
        $("#linea_com").removeClass("is-invalid");
        // $("#linea_dir").removeClass("is-invalid");
        $("#linea_cal").removeClass("is-invalid");
        $("#linea_num").removeClass("is-invalid");
        $("#linea_bloc").removeClass("is-invalid");
        $("#linea_dep").removeClass("is-invalid");
        $("#linea_telf").removeClass("is-invalid");
        $("#linea_correo").removeClass("is-invalid");
        $("#linea_edad").removeClass("is-invalid");

    }

    function validarfrmIdentificacionLB(){
        limpiarfrmValidadiones();
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

        // if (linea_dir == "" || typeof linea_dir === "undefined"){
        //     respuesta = false;
        //     $("#val_linea_dir").show();
        //     $("#linea_dir").addClass("is-invalid");
        // }

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
            respuesta = true;//inicio ch
            $("#val_linea_telf").show();
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
                $("#linea_correo").addClass("is-invalid");
            }
        }

        if (linea_edad == "" || typeof linea_edad === "undefined"){
            respuesta = false;
            $("#val_linea_edad").show();
            $("#linea_edad").addClass("is-invalid");
            
        }
        //inicio ch
        if(linea_edad > 100){
            respuesta = false;
            $("#val_linea_edad1").show();
            $("#linea_edad").addClass("is-invalid");
        }//fin ch
        return respuesta;

    }

    function recolectarDataIdentificacionLB(){

        let data = new Object();
        let run = limpiarFormatoRun($("#linea_rut").val());
		run = dividirRut(run);
        
        data.lin_bas_nom = $("#linea_nom").val();
        data.lin_bas_rut = run[0];
        data.lin_bas_dv  = run[1];
        data.lin_bas_com = $("#linea_com").val();
        // data.lin_bas_dir = $("#linea_dir").val();
        data.lin_bas_cal = $("#linea_cal").val();
        data.lin_bas_num = $("#linea_num").val();
        data.lin_bas_bloc = $("#linea_bloc").val();
        data.lin_bas_dep = $("#linea_dep").val();
        data.lin_bas_tel = $("#linea_telf").val();
        data.lin_bas_cor = $("#linea_correo").val();
        data.lin_bas_eda = $("#linea_edad").val();

        return data;
    }

    function getDataIdentificacion(id){

        let data = new Object();

        data.id = id;

        $.ajax({
            type: "GET",
            url: "{{route('editar.linea.ident')}}",
            data: data
        }).done(function(resp){


            iden_lb = $.parseJSON(resp.iden_lb);
            
            
            $('#linea_nom').val(iden_lb.lin_bas_nom);
            $('#linea_rut').val(iden_lb.lin_bas_rut);
            $('#linea_com').val(iden_lb.lin_bas_com);
            // $('#linea_dir').val(iden_lb.lin_bas_dir);
            $('#linea_cal').val(iden_lb.lin_bas_cal);
            $('#linea_num').val(iden_lb.lin_bas_num);
            $('#linea_bloc').val(iden_lb.lin_bas_bloc);
            $('#linea_dep').val(iden_lb.lin_bas_dep);
            $('#linea_telf').val(iden_lb.lin_bas_tel);
            $('#linea_correo').val(iden_lb.lin_bas_cor);
            $('#linea_edad').val(iden_lb.lin_bas_eda);

            $("#ser_niv_com").val(iden_lb.lin_bas_otr1);
            $("#ser_pro_soc").val(iden_lb.lin_bas_otr2);
            $("#ser_ser_sec").val(iden_lb.lin_bas_otr3);
            $("#bie_com").val(iden_lb.lin_bas_otr4);
            $("#bien_org_otr").val(iden_lb.lin_bas_otr5);
            $("#bien_org_part").val(iden_lb.lin_bas_part);

        }).fail(function(objeto, tipoError, errorHttp){

                manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

                return false;
        });
    }
</script>