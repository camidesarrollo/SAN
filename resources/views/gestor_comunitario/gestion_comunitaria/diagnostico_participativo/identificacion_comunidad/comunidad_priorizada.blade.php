<div class="card-body">    
    <div class="form-group row">
        <label class="col-sm-3 col-form-label"><b>Comunidad Priorizada:</b></label>
        <div class="col-sm-6">
            <label id="iden_com_pri" ><b> </b></label>            
        </div>    
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label"><b>Zona Geográfica:</b></label>
        <div class="col-sm-6">
            <label id="iden_zon_geo" ><b></b></label>
            
        </div>    
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label"><b>Lugar:</b></label>
        <div class="col-sm-6">
            <label id="iden_dir_lug" ><b></b></label>
            
        </div>    
    </div>
    <div class="form-group row">        
            <label for="" class="col-sm-3"><b>Dirección:</b></label>              
            <div class="col-sm-6">
                <label id="iden_dir_dir" for="" ><b></b></label>              
                
            </div>
        </div>                             
    </div>
    <div class="form-group row p-3"> 
        <div class="col-sm-3">
            <label for="" class=" col-form-label"><b>Calle:</b></label>
            <label id="iden_dir_cal" for="" ><b></b></label>
            
        </div>               
        <div class="col-sm-3">
            <label for="" class=" col-form-label"><b>Numero:</b></label>
            <label id="iden_dir_num" for="" ><b></b></label>
            
        </div>
        <div class="col-sm-3">
            <label for="" class=" col-form-label"><b>Block:</b></label>
            <label id="iden_dir_bloc" for="" ><b></b></label>
            
        </div>
        <div class="col-sm-3">
            <label for="" class=" col-form-label"><b>Departamento:</b></label>
            <label id="iden_dir_dep" for="" ><b></b></label>
            
        </div>
    </div>
    <div class="form-group row ml-3">
        <label for="" class="col-sm-3 col-form-label"><b>Nombre de Representante:</b></label>
        <div class="col-sm-6">
            <label id="iden_rep_nom" for="" ><b></b></label>
            
        </div>                              
    </div>
    <div class="form-group row ml-3">
        <label for="" class="col-sm-3 col-form-label"><b>RUT:</b></label>
        <div class="col-sm-6">
            <label id="iden_rep_rut" for="" ><b></b></label>
            
        </div>                              
    </div>
    <div class="form-group row ml-3">
        <label for="" class="col-sm-3 col-form-label"><b>Teléfono:</b></label>
        <div class="col-sm-6">
            <label id="iden_rep_tel" for="" ><b></b></label>
            
        </div>                              
    </div>
    <div class="form-group row ml-3">
        <label for="" class="col-sm-3 col-form-label"><b>Correo:</b></label>
        <div class="col-sm-6">
            <label id="iden_rep_cor" for="" ><b></b></label>
            
        </div>                              
    </div>
    <div class="form-group row ml-3">            
        <label for="" class="col-sm-3 col-form-label"><b>Nº Familias:</b></label>
        <div class="col-sm-6">
            <label id="iden_num_fam" for="" ><b></b></label>
            
        </div>                              
    </div>
    <div class="form-group row ml-3">            
        <label for="" class="col-sm-3 col-form-label"><b>Nº NNA:</b></label>
        <div class="col-sm-6">
            <label id="iden_num_nna" for="" ><b></b></label>
            
        </div>                              
    </div>
    <div class="form-group row ml-3">            
        <label for="" class="col-sm-3 col-form-label"><b>Nº de Adultos:</b></label>
        <div class="col-sm-6">
            <label id="iden_num_adu" for="" ><b></b></label>
            
        </div>                              
    </div>                         
    <div class="form-group row ml-3">  
        <label for="" class="col-sm-3 col-form-label"><b>Nº de Organizaciones Funcionales Comunitaras:</b></label>          
        <div class="col-sm-6">  
            <label id="iden_num_org" for="" ><b></b></label>                        
            
        </div>                              
    </div>
    <div class="form-group row ml-3">  
        <label for="" class="col-sm-3 col-form-label"><b>Nº de Instituciones Presentes:</b></label>          
        <div class="col-sm-6">  
            <label id="iden_num_ins" for="" ><b></b></label>                       
            
        </div>                              
    </div>   
</div>
<script type="text/javascript">     
    function getDataIdentComunidad(){
        bloquearPantalla();

        let data = new Object();
        data.pro_an_id = {{$pro_an_id}};

        $.ajax({
            type: "GET",
            url: "{{route('identificacion.priorizada.mostrar')}}",
            data: data
        }).done(function(resp){
            desbloquearPantalla();

            com_pri = $.parseJSON(resp.com_pri);
            zon_rur = $.parseJSON(resp.zon_rur);
            lug_gc = $.parseJSON(resp.lug_gc);

            if(resp.estado == 1){
                iden_com = $.parseJSON(resp.iden_com);

                $("#form_diag_fec_lev >").val(iden_com.iden_fec_lev);
                
                $('#iden_dir_dir').text(iden_com.iden_dir);
                $('#iden_dir_cal').text(iden_com.iden_cal);
                $('#iden_dir_num').text(iden_com.iden_num);
                $('#iden_dir_bloc').text(iden_com.iden_bloc);
                $('#iden_dir_dep').text(iden_com.iden_dep);
                $('#iden_rep_nom').text(iden_com.iden_nom_rep);
                $('#iden_rep_rut').text(iden_com.iden_rut);
                $('#iden_rep_tel').text(iden_com.iden_telf);
                $('#iden_rep_cor').text(iden_com.iden_cor);
                $('#iden_num_fam').text(iden_com.iden_num_fam);
                $('#iden_num_nna').text(iden_com.iden_num_nna);
                $('#iden_num_adu').text(iden_com.iden_num_adl);
                $('#iden_num_org').text(iden_com.iden_num_org);
                $('#iden_num_ins').text(iden_com.iden_num_ins);

                $.each(com_pri, function(i, item){
                    if(iden_com.com_pri_id == item.com_pri_id){
                        $('#iden_com_pri').text(item.com_pri_nom);                        
                    }
                });

                $.each(zon_rur, function(i, item){
                    if(iden_com.zon_rur_id == item.zon_rur_id){
                        $('#iden_zon_geo').text(item.zon_rur_nom);                        
                    }
                });

                $.each(lug_gc, function(i, item){
                    if(iden_com.lug_gc_id == item.lug_gc_id){
                        $('#iden_dir_lug').text(item.lug_gc_nom);                        
                    }
                });

            }else{
                $.each(com_pri, function(i, item){
                    $('#iden_com_pri').append('<option value="'+ item.com_pri_id +'">'+item.com_pri_nom+'</option>');                                           
                });

                $.each(zon_rur, function(i, item){
                    $('#iden_zon_geo').append('<option value="'+ item.zon_rur_id +'">'+item.zon_rur_nom+'</option>');    
                });

                $.each(lug_gc, function(i, item){
                    $('#iden_dir_lug').append('<option value="'+ item.lug_gc_id +'">'+item.lug_gc_nom+'</option>');                    
                });
            }
        }).fail(function(objeto, tipoError, errorHttp){            
            desbloquearPantalla();

            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

            return false;
        });
    }    
    

</script>