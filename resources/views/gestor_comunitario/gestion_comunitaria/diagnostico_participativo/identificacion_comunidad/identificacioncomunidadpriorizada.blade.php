<div class="card-body">    
    <div class="form-group row">
        <label class="col-sm-3 col-form-label"><b>Comunidad Priorizada:</b></label>
        <div class="col-sm-6">
            <select class="form-control" id="iden_com_pri" name="iden_com_pri" onchange="registrarDataIdentComuna()">
                <option value="" >Seleccione una opcion</option>
            </select>
            <p id="val_iden_com_pri" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Seleccionar la Comunidad.</p>
        </div>    
    </div>
	
	
    <div class="form-group row">
        <label class="col-sm-3 col-form-label"><b>Zona Geográfica:</b></label>
        <div class="col-sm-6">
            <select class="form-control" id="iden_zon_geo" name="iden_zon_geo" onchange="registrarDataIdentComuna()">
                <option value="" >Seleccione una opcion</option>
            </select>
            <p id="val_iden_zon_geo" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Seleccionar la Zona.</p>
        </div>    
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label"><b>Lugar:</b></label>
        <div class="col-sm-6">
            <select class="form-control" id="iden_dir_lug" name="iden_dir_lug" onchange="registrarDataIdentComuna()">
                <option value="" >Seleccione una opcion</option>
            </select>
            <p id="val_iden_dir_lug" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Seleccionar la Lugar.</p>
        </div>    
    </div><br>

    <!-- <div class="form-group row">        
            <label for="" class="col-sm-3"><b>Dirección:</b></label>              
            <div class="col-sm-6">
                <input maxlength="100" id="iden_dir_dir" name="iden_dir_dir" onkeypress="return caracteres_especiales(event)" type="input" class="form-control" onblur="registrarDataIdentComuna()">
                <p id="val_iden_dir_dir" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Ingresar una dirección.</p>            
            </div>
        </div>                             
    </div> -->

    <div class="row">
        <h6 class="col-12" style="font-weight: 800;"><u>Dirección Sede Vecinal o del Representante de la Comunidad:</u></h6>   
    </div>


    <div class="form-group row"> 
        <div class="col-sm-3">
            <label for="" class=" col-form-label"><b>Calle:</b></label>
            <input maxlength="100" id="iden_dir_cal" name="iden_dir_cal" onkeypress="return caracteres_especiales(event)" type="input" class="form-control" onblur="registrarDataIdentComuna()">
            <p id="val_iden_dir_cal" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Ingresar una calle.</p>            
        </div>               
        <div class="col-sm-3">
            <label for="" class=" col-form-label"><b>Número:</b></label>
            <input maxlength="100" id="iden_dir_num" name="iden_dir_num" onkeypress="return soloNumeros(event)" type="input" class="form-control" onblur="registrarDataIdentComuna()">
            <p id="val_iden_dir_num" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Ingresar un número.</p>            
        </div>
        <div class="col-sm-3">
            <label for="" class=" col-form-label"><b>Block:</b></label>
            <input maxlength="100" id="iden_dir_bloc" name="iden_dir_bloc" onkeypress="return caracteres_especiales(event)" type="input" class="form-control" onblur="registrarDataIdentComuna()">
            <p id="val_iden_dir_bloc" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Ingresar un block.</p>            
        </div>
        <div class="col-sm-3">
            <label for="" class=" col-form-label"><b>Departamento:</b></label>
            <input maxlength="100" id="iden_dir_dep" name="iden_dir_dep" onkeypress="return caracteres_especiales(event)" type="input" class="form-control" onblur="registrarDataIdentComuna()">
            <p id="val_iden_dir_dep" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Ingresar una departamento.</p>            
        </div>
    </div><br>

    <div class="form-group row">
        <label for="" class="col-sm-3 col-form-label"><b>Nombre de Representante:</b></label>
        <div class="col-sm-6">
            <input maxlength="100" id="iden_rep_nom" name="iden_rep_nom" onkeypress="return caracteres_especiales(event)" type="input" class="form-control" onblur="registrarDataIdentComuna()">
            <p id="val_iden_rep_nom" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar un nombre.</p>
        </div>                              
    </div>
    <div class="form-group row">
        <label for="" class="col-sm-3 col-form-label"><b>RUT:</b></label>
        <div class="col-sm-6">
            <input maxlength="10" id="iden_rep_rut" name="iden_rep_rut" onkeypress="return caracteres_especiales(event)" type="input" class="form-control" onblur="integrantesRut()">
            <p id="val_iden_rep_rut" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar un rut.</p>
        </div>                              
    </div>
    <div class="form-group row">
        <label for="" class="col-sm-3 col-form-label"><b>Teléfono:</b></label>
        <div class="col-sm-6">
            <input maxlength="10" id="iden_rep_tel" name="iden_rep_tel" onkeypress="return soloNumeros(event)" type="input" class="form-control" onblur="registrarDataIdentComuna()">
            <!-- <p id="val_iden_rep_tel" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar una teléfono.</p> --> <!-- inicio ch -->
        </div>                              
    </div>
    <div class="form-group row">
        <label for="" class="col-sm-3 col-form-label"><b>Correo:</b></label>
        <div class="col-sm-6">
            <input maxlength="100" id="iden_rep_cor" name="iden_rep_cor" onkeypress="" type="email" class="form-control" onblur="representanteCorreo()">
            <!-- <p id="val_iden_rep_cor" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar un correo.</p> --> <!-- fin ch -->
        </div>                              
    </div>
    <!-- INICIO CZ SPRINT 67 -->
    <div class="form-group row">            
        <label for="" class="col-sm-3 col-form-label"><b>Nº NNA:</b></label>
        <div class="col-sm-6">
            <input maxlength="100" id="iden_num_nna" name="iden_num_nna" onkeypress="return soloNumeros(event)" type="number" max="100" min="1" class="form-control col-sm-3" onblur="registrarDataIdentComuna()" onKeyUp="sumarParticipantes()" onKeyDown="sumarParticipantes()">
            <p id="val_iden_num_nna" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar un número.</p>
        </div>                              
    </div>
    <div class="form-group row">            
        <label for="" class="col-sm-3 col-form-label"><b>Nº de Adultos:</b></label>
        <div class="col-sm-6">
            <input maxlength="100" id="iden_num_adu" name="iden_num_adu" onkeypress="return soloNumeros(event)" type="number" max="100" min="1" class="form-control col-sm-3" onblur="registrarDataIdentComuna()" onKeyUp="sumarParticipantes()" onKeyDown="sumarParticipantes()">
            <p id="val_iden_num_adu" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar un número.</p>
        </div>                              
    </div>
     <!-- INICIO CZ SPRINT 67 -->
    <div class="form-group row">            
        <label for="" class="col-sm-3 col-form-label"><b>Total de Personas:</b></label>
        <div class="col-sm-6">
            <input disabled maxlength="100" id="iden_num_participantes" name="iden_num_participantes" onkeypress="return soloNumeros(event)" type="number" max="100" min="1" class="form-control col-sm-3" onblur="registrarDataIdentComuna()"> 
            <p id="val_iden_num_participantes" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar un número.</p>
        </div>                              
    </div>
     <!-- FIN CZ SPRINT 67 -->
    <div class="form-group row">            
        <label for="" class="col-sm-3 col-form-label"><b>Nº Familias:</b></label>
        <div class="col-sm-6">
            <input maxlength="100" id="iden_num_fam" name="iden_num_fam" onkeypress="return soloNumeros(event)" type="number" max="100" min="1" class="form-control col-sm-3" onblur="registrarDataIdentComuna()"> 
            <p id="val_iden_num_fam" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar un número.</p>
        </div>                              
    </div>                         
    <!-- FIN CZ SPRINT 67 -->                      
    <div class="form-group row">  
        <label for="" class="col-sm-3 col-form-label"><b>Nº de Organizaciones Funcionales Comunitaras:</b></label>          
        <div class="col-sm-6">                
            <input disabled maxlength="100" id="iden_num_org" name="iden_num_org" onkeypress="return soloNumeros(event)" type="number" max="100" min="1" class="form-control col-sm-3" value="0">
            <p id="val_iden_num_org" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar un número.</p>
        </div>                              
    </div>
    <div class="form-group row">  
        <label for="" class="col-sm-3 col-form-label"><b>Nº de Instituciones Presentes:</b></label>          
        <div class="col-sm-6">                
            <input disabled maxlength="100" id="iden_num_ins" name="iden_num_ins" onkeypress="return soloNumeros(event)" type="number" max="100" min="1" class="form-control col-sm-3" value="0">
            <p id="val_iden_num_ins" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar un número.</p>
        </div>                              
    </div>   
</div>
<input type="hidden" name="hid_rut_val" id="hid_rut_val" value="0">
<input type="hidden" name="hid_cor_val" id="hid_cor_val" value="0">
<script type="text/javascript"> 

    function dataIdentificacionPriorizada(){

        $.ajax({
            type: "GET",
            url: "{{route('identificacion.priorizada')}}"
        }).done(function(resp){


            zon_rur = $.parseJSON(resp.zon_rur);
            com_pri = $.parseJSON(resp.com_pri);
            lug_gc = $.parseJSON(resp.lug_gc);

            $.each(com_pri, function(i, item){
                $('#iden_com_pri').append('<option value="'+ item.com_pri_id +'">'+item.com_pri_nom+'</option>');                                           
            });

            $.each(zon_rur, function(i, item){
                $('#iden_zon_geo').append('<option value="'+ item.zon_rur_id +'">'+item.zon_rur_nom+'</option>');    
            });

            $.each(lug_gc, function(i, item){
                $('#iden_dir_lug').append('<option value="'+ item.lug_gc_id +'">'+item.lug_gc_nom+'</option>');                    
            });

            

        }).fail(function(objeto, tipoError, errorHttp){            

            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

            return false;
        });
    }

    function getDataIdentComunidad(){
        //console.log("esta es la funcion que esta tomando");
        let data = new Object();

        data.pro_an_id = {{$pro_an_id}};

        $.ajax({
            type: "GET",
            url: "{{route('identificacion.priorizada.mostrar')}}",
            data: data
        }).done(function(resp){

            com_pri = $.parseJSON(resp.com_pri);
            zon_rur = $.parseJSON(resp.zon_rur);
            lug_gc = $.parseJSON(resp.lug_gc);
            $('#iden_com_pri').empty();
            $('#iden_com_pri').append('<option value="">Seleccione una opción</option>');
            $('#iden_zon_geo').empty();
            $('#iden_zon_geo').append('<option value="">Seleccione una opción</option>');
            $('#iden_dir_lug').empty();
            $('#iden_dir_lug').append('<option value="">Seleccione una opción</option>');

            if(resp.estado == 1){
                iden_com = $.parseJSON(resp.iden_com);
                

                $('#form_diag_fec_lev').datetimepicker('date', iden_com.iden_fec_lev);
                
                $('#iden_com_pri').find('option[id="'+iden_com.com_pri_id+'"]').prop("selected", true);
                // INCIO CZ SPRINT 55
                $('#info_com_pri').find('option[id="'+iden_com.com_pri_id+'"]').prop("selected", true);
                //console.log("aqui");
                $('#inf_com_pri').find('option[id="'+iden_com.com_pri_id+'"]').prop("selected", true);
                //console.log($('#inf_com_pri').val());
                // FIN CZ SPRINT 55
                $('#iden_zon_geo').find('option[id="'+iden_com.zon_rur_id+'"]').prop("selected", true);
                $('#iden_dir_lug').find('option[id="'+iden_com.lug_gc_id+'"]').prop("selected", true);
                $('#iden_dir_dir').val(iden_com.iden_dir);
                $('#iden_dir_cal').val(iden_com.iden_cal);
                $('#iden_dir_num').val(iden_com.iden_num);
                $('#iden_dir_bloc').val(iden_com.iden_bloc);
                $('#iden_dir_dep').val(iden_com.iden_dep);
                $('#iden_rep_nom').val(iden_com.iden_nom_rep);
                $('#iden_rep_rut').val(iden_com.iden_rut);
                $('#iden_rep_tel').val(iden_com.iden_telf);
                $('#iden_rep_cor').val(iden_com.iden_cor);
                $('#iden_num_fam').val(iden_com.iden_num_fam);
                $('#iden_num_nna').val(iden_com.iden_num_nna);
                $('#iden_num_adu').val(iden_com.iden_num_adl);
                // INICIO CZ SPRINT 67
                $('#iden_num_participantes').val(iden_com.iden_num_total_personas);
                // FIN CZ SPRINT 67
                $('#iden_num_org').val(iden_com.iden_num_org);
                $('#iden_num_ins').val(iden_com.iden_num_ins);

                $.each(com_pri, function(i, item){
                    // INCIO CZ SPRINT 55
                    if(iden_com.com_pri_id == item.com_pri_id){
                        $('#iden_com_pri').append('<option selected="selected" value="'+ item.com_pri_id +'">'+item.com_pri_nom+'</option>');
                        $('#info_com_pri').append('<option selected="selected" value="'+ item.com_pri_id +'">'+item.com_pri_nom+'</option>');
                        $('#inf_com_pri').append('<option selected="selected" value="'+ item.com_pri_id +'">'+item.com_pri_nom+'</option>');
                    }else{
                        $('#iden_com_pri').append('<option value="'+ item.com_pri_id +'">'+item.com_pri_nom+'</option>');
                        $('#info_com_pri').append('<option value="'+ item.com_pri_id +'">'+item.com_pri_nom+'</option>');
                        $('#inf_com_pri').append('<option value="'+ item.com_pri_id +'">'+item.com_pri_nom+'</option>');
                    }
                    // FIN CZ SPRINT 55
                });

                $.each(zon_rur, function(i, item){
                    if(iden_com.zon_rur_id == item.zon_rur_id){
                        $('#iden_zon_geo').append('<option selected="selected" value="'+ item.zon_rur_id +'">'+item.zon_rur_nom+'</option>');    
                    }else{                        
                        $('#iden_zon_geo').append('<option value="'+ item.zon_rur_id +'">'+item.zon_rur_nom+'</option>');    
                    }
                });

                $.each(lug_gc, function(i, item){
                    if(iden_com.lug_gc_id == item.lug_gc_id){
                        $('#iden_dir_lug').append('<option selected="selected" value="'+ item.lug_gc_id +'">'+item.lug_gc_nom+'</option>');                    
                    }else{
                        $('#iden_dir_lug').append('<option value="'+ item.lug_gc_id +'">'+item.lug_gc_nom+'</option>');                    
                    }
                });

            }else{
                // INCIO CZ SPRINT 55
                $.each(com_pri, function(i, item){
                    $('#iden_com_pri').append('<option value="'+ item.com_pri_id +'">'+item.com_pri_nom+'</option>');                                           
                    $('#info_com_pri').append('<option value="'+ item.com_pri_id +'">'+item.com_pri_nom+'</option>');                                           
                    $('#inf_com_pri').append('<option value="'+ item.com_pri_id +'">'+item.com_pri_nom+'</option>');                                           
                });
                // FIN CZ SPRINT 55
                $.each(zon_rur, function(i, item){
                    $('#iden_zon_geo').append('<option value="'+ item.zon_rur_id +'">'+item.zon_rur_nom+'</option>');    
                });

                $.each(lug_gc, function(i, item){
                    $('#iden_dir_lug').append('<option value="'+ item.lug_gc_id +'">'+item.lug_gc_nom+'</option>');                    
                });
            }
        }).fail(function(objeto, tipoError, errorHttp){            

            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

            return false;
        });
    }

    function limpiarFrmIdentificacion(){

        $('#iden_com_pri').prop('selectedIndex', 0);
        $('#iden_zon_geo').prop('selectedIndex', 0);
        $('#iden_dir_lug').prop('selectedIndex', 0);
        $('#iden_dir_dir').val("");
        $('#iden_dir_cal').val("");
        $('#iden_dir_num').val("");
        $('#iden_dir_bloc').val("");
        $('#iden_dir_dep').val("");
        $('#iden_rep_nom').val("");
        $('#iden_rep_rut').val("");
        $('#iden_rep_tel').val("");
        $('#iden_rep_cor').val("");
        $('#iden_num_fam').val("");
        $('#iden_num_nna').val("");
        $('#iden_num_adu').val("");
        $('#iden_num_org').val("");
        $('#iden_num_ins').val("");
        
    }

    function limpiarIdentificacionValidacion(){

        $("#val_frm_diag_fec_lev").hide();
        $("#val_iden_com_pri").hide();
        $("#val_iden_zon_geo").hide();
        $("#val_iden_dir_lug").hide();
        $("#val_iden_dir_dir").hide();
        $("#val_iden_dir_cal").hide();
        $("#val_iden_dir_num").hide();
        $("#val_iden_rep_nom").hide();
        $("#val_iden_rep_rut").hide();
        $("#val_iden_rep_tel").hide();
        $("#val_iden_rep_cor").hide();
        $("#val_iden_num_fam").hide();
        $("#val_iden_num_nna").hide();
        $("#val_iden_num_adu").hide();
        $("#val_iden_num_org").hide();
        $("#val_iden_num_ins").hide();

        $("#form_diag_fec_lev").removeClass("is-invalid");
        $("#iden_com_pri").removeClass("is-invalid");
        $("#iden_zon_geo").removeClass("is-invalid");
        $("#iden_dir_lug").removeClass("is-invalid");
        $("#iden_dir_dir").removeClass("is-invalid");
        $("#iden_dir_cal").removeClass("is-invalid");
        $("#iden_dir_num").removeClass("is-invalid");
        $("#iden_rep_nom").removeClass("is-invalid");
        $("#iden_rep_rut").removeClass("is-invalid");
        $("#iden_rep_tel").removeClass("is-invalid");
        $("#iden_rep_cor").removeClass("is-invalid");
        $("#iden_num_fam").removeClass("is-invalid");
        $("#iden_num_nna").removeClass("is-invalid");
        $("#iden_num_adu").removeClass("is-invalid");
        $("#iden_num_org").removeClass("is-invalid");
        $("#iden_num_ins").removeClass("is-invalid");
        
    }
    
    function validarFrmIdentificacion(){
        let respuesta = true;
        limpiarIdentificacionValidacion();

        let iden_fec_lev    = $('#form_diag_fec_lev').data('date');
        let iden_com_pri    = $('#iden_com_pri option:selected').val();
        let iden_zon_geo    = $('#iden_zon_geo option:selected').val();
        let iden_dir_lug    = $('#iden_dir_lug option:selected').val();
        let iden_dir_dir    = $('#iden_dir_dir').val();
        let iden_dir_cal    = $('#iden_dir_cal').val();
        let iden_dir_num    = $('#iden_dir_num').val();
        let iden_dir_bloc   = $('#iden_dir_bloc').val();
        let iden_dir_dep    = $('#iden_dir_dep').val();
        let iden_rep_nom    = $('#iden_rep_nom').val();
        let iden_rep_rut    = $('#iden_rep_rut').val();
        let iden_rep_tel    = $('#iden_rep_tel').val();
        let iden_rep_cor    = $('#iden_rep_cor').val();
        let iden_num_fam    = $('#iden_num_fam').val();
        let iden_num_nna    = $('#iden_num_nna').val();
        let iden_num_adu    = $('#iden_num_adu').val();
        let iden_num_org    = $('#iden_num_org').val();
        let iden_num_ins    = $('#iden_num_ins').val();

        if (iden_fec_lev == "" || typeof iden_fec_lev === "undefined"){
                respuesta = false;
                $("#val_frm_diag_fec_lev").show();
                $("#form_diag_fec_lev").addClass("is-invalid");
                colapsable = 1;
            }else{
                if (!validarFormatoFecha(iden_fec_lev)){
                    respuesta = false;
                    $("#val_frm_diag_fec_lev").show();
                    $("#form_diag_fec_lev").addClass("is-invalid");
                    colapsable = 1;
                }

                if (!existeFecha(iden_fec_lev)){
                    respuesta = false;
                    $("#val_frm_diag_fec_lev").show();
                    $("#form_diag_fec_lev").addClass("is-invalid");
                    colapsable = 1;
                }
            }

        if (iden_com_pri == "" || typeof iden_com_pri === "undefined"){
            respuesta = false;
            $("#val_iden_com_pri").show();
            $("#iden_com_pri").addClass("is-invalid");
        } 

        if (iden_zon_geo == "" || typeof iden_zon_geo === "undefined"){
            respuesta = false;
            $("#val_iden_zon_geo").show();
            $("#iden_zon_geo").addClass("is-invalid");
        }

        if (iden_dir_lug == "" || typeof iden_dir_lug === "undefined"){
            respuesta = false;
            $("#val_iden_dir_lug").show();
            $("#iden_dir_lug").addClass("is-invalid");
        }

        if (iden_dir_dir == "" || typeof iden_dir_dir === "undefined"){
            respuesta = false;
            $("#val_iden_dir_dir").show();
            $("#iden_dir_dir").addClass("is-invalid");
        }

        if (iden_dir_cal == "" || typeof iden_dir_cal === "undefined"){
            respuesta = false;
            $("#val_iden_dir_cal").show();
            $("#iden_dir_cal").addClass("is-invalid");
        }
        
        if (iden_dir_num == "" || typeof iden_dir_num === "undefined"){
            respuesta = false;
            $("#val_iden_dir_num").show();
            $("#iden_dir_num").addClass("is-invalid");
        }

        if (iden_rep_nom == "" || typeof iden_rep_nom === "undefined"){
            respuesta = false;
            $("#val_iden_rep_nom").show();
            $("#iden_rep_nom").addClass("is-invalid");
        } 
        
        if (iden_rep_rut == "" || typeof iden_rep_rut === "undefined"){
            respuesta = false;
            $("#val_iden_rep_rut").show();
            $("#iden_rep_rut").addClass("is-invalid");
        }

        if (iden_rep_tel == "" || typeof iden_rep_tel === "undefined"){//inicio ch
            respuesta = true;
            //$("#val_iden_rep_tel").show();
            $("#iden_rep_tel").addClass("is-valid");//fin ch
        } 

        if (iden_rep_cor == "" || typeof iden_rep_cor === "undefined"){//inicio ch
            respuesta = true;
            //$("#val_iden_rep_cor").show();
            //$("#iden_rep_cor").addClass("is-valid");//fin ch
        } 

        if (iden_num_fam == "" || typeof iden_num_fam === "undefined"){
            respuesta = false;
            $("#val_iden_num_fam").show();
            $("#iden_num_fam").addClass("is-invalid");
        }

        if (iden_num_nna == "" || typeof iden_num_nna === "undefined"){
            respuesta = false;
            $("#val_iden_num_nna").show();
            $("#iden_num_nna").addClass("is-invalid");
        }

        if (iden_num_adu == "" || typeof iden_num_adu === "undefined"){
            respuesta = false;
            $("#val_iden_num_adu").show();
            $("#iden_num_adu").addClass("is-invalid");
        }

        if (iden_num_org == "" || typeof iden_num_org === "undefined"){
            respuesta = false;
            $("#val_iden_num_org").show();
            $("#iden_num_org").addClass("is-invalid");
        }

        if (iden_num_ins == "" || typeof iden_num_ins === "undefined"){
            respuesta = false;
            $("#val_iden_num_ins").show();
            $("#iden_num_ins").addClass("is-invalid");
        }

        return respuesta;
    }

    function recolectarIdentComunidadPriorizada(){
        let data_iden = new Object();

        data_iden.iden_fec_lev    = $('#form_diag_fec_lev').data('date');
        data_iden.iden_com_pri    = $('#iden_com_pri option:selected').val();
        data_iden.iden_zon_geo    = $('#iden_zon_geo option:selected').val();
        data_iden.iden_dir_lug    = $('#iden_dir_lug option:selected').val();
        data_iden.iden_dir_dir    = "CAMPO DESESTIMADO";//$('#iden_dir_dir').val();
        data_iden.iden_dir_cal    = $('#iden_dir_cal').val();
        data_iden.iden_dir_num    = $('#iden_dir_num').val();
        data_iden.iden_dir_bloc   = $('#iden_dir_bloc').val();
        data_iden.iden_dir_dep    = $('#iden_dir_dep').val();
        data_iden.iden_rep_nom    = $('#iden_rep_nom').val();
        data_iden.iden_rep_rut    = $('#iden_rep_rut').val();
        data_iden.iden_rep_tel    = $('#iden_rep_tel').val();
        data_iden.iden_rep_cor    = $('#iden_rep_cor').val();
        data_iden.iden_num_fam    = $('#iden_num_fam').val();
        data_iden.iden_num_nna    = $('#iden_num_nna').val();
        data_iden.iden_num_adu    = $('#iden_num_adu').val();
        data_iden.iden_num_org    = $('#iden_num_org').val();
        data_iden.iden_num_ins    = $('#iden_num_ins').val();
        data_iden.iden_num_ins    = $('#iden_num_ins').val();
        data_iden.iden_num_total_personas       = $('#iden_num_participantes').val();
        data_iden.pro_an_id       = {{$pro_an_id}};
        return data_iden;
    }

    function representanteRut(){
        $('#iden_rep_rut').rut({
			fn_error: function(input){
				if (input.val() != ''){
					$('#iden_rep_rut').attr("data-val-run", false);
                    mensajeTemporalRespuestas(0, "* RUN Inválido.");
					$("#val_iden_rep_rut").show();
                    $("#hid_rut_val").val(1);
				}
			},
			fn_validado: function(input){
				$('#iden_rep_rut').attr("data-val-run", true);
				$("#val_iden_rep_rut").hide();
                $("#hid_rut_val").val(0);
                registrarDataIdentComuna();
			}
		});
    }

    function representanteCorreo(){
        iden_rep_cor = $("#iden_rep_cor").val();
        let regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if(!regex.test(iden_rep_cor)){
                respuesta = false;
                $("#val_iden_rep_cor").show();
                $("#hid_cor_val").val(1);
               // $("#iden_rep_cor").addClass("is-valid");//inicio ch
            }else{
                $("#val_iden_rep_cor").hide();
                $("#hid_cor_val").val(0);
               // $("#iden_rep_cor").removeClass("is-valid");  //fin ch
                registrarDataIdentComuna();          
            }
    }
        // INICIO CZ SPRINT 67
        function sumarParticipantes(){
        var suma = parseInt($("#iden_num_adu").val()) + parseInt($("#iden_num_nna").val());
        $("#iden_num_participantes").val(suma);
    
    }
    // FIN CZ SPRINT 67
</script>