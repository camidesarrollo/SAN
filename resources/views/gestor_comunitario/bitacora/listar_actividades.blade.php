<!-- INICIO CZ SPRINT 67 -->
<?php
    $perfil = session()->all()['perfil'];
    $com_id = session()->all()['com_id']; 
?>
<!-- FIN CZ SPRINT 67 -->
<div class="table-responsive">
    @foreach ($acciones as $accion)
        @if ($accion->cod_accion == "GCM05")
            <div class="text-right mb-2">
                <button type="button" data-act-id="" onclick="{{ $accion->ruta }}" class="btn btn-success" data-toggle="modal" data-target="#frmActividades"><i class="{{ $accion->clase }}"></i>  {{ $accion->nombre }}</button>
            </div>
        @endif
    @endforeach
    <table class="table table-striped table-hover w-100" cellspacing="0" id="tabla_actividades">


        <thead>

        <tr>                        
            <th class="text-center">Fecha de Actividad</th>
            <th class="text-center">Lugar</th>
            <th class="text-center">Hitos</th>
         <!--    <th class="text-center">Actividades Planificadas</th>
            <th class="text-center">Actividades Realizadas</th> -->
            @foreach ($acciones as $accion)
                @if ($accion->cod_accion == "GCM06")
                    <th class="text-center">Acciones</th>
                @endif
            @endforeach
        </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
 <input type="hidden" name="reg_edt" id="reg_edt" value="">
 <input type="hidden" name="actb_id" id="actb_id" value="0">
 @includeif('gestor_comunitario.bitacora.formulario_actividades')
<script type="text/javascript">

        function listarActividades(){
            let tabla_actividades = $('#tabla_actividades').DataTable();
            tabla_actividades.clear().destroy();	

            let data 		= new Object();
            data.bit_id 	= $('#bit_id').val();

            tabla_actividades =$('#tabla_actividades').DataTable({
				"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
                "lengthChange": false,
                "searching":    false,
                "ajax": {
                    "url": "{{ route('listar.actividad') }}",
                    "data": data	
                },	
				"columnDefs": [
            	{ //FECHA DE LA ACTIVIDAD
					"targets": 0,
					"className": 'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
				{ //LUGAR
					"targets": 1,
					"className": 'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
				{ //HITO
					"targets": 2,
					"className": 'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
				// { //ACTIVIDADES PLANIFICADAS
				// 	"targets": 3,
				// 	"className": 'dt-head-center dt-body-center',
				// 	"createdCell": function (td, cellData, rowData, row, col) {
				//         $(td).css("vertical-align", "middle");
    //                     $(td).css("word-break", "break-word");
				     
				//     }
				// },
				// { //ACTIVIDADES REALIZADAS
				// 	"targets": 4,
				// 	"className": 'dt-head-center dt-body-center',
				// 	"createdCell": function (td, cellData, rowData, row, col) {
				//         $(td).css("vertical-align", "middle");
    //                     $(td).css("word-break", "break-word");
				     
				//     }
				// },
                @foreach ($acciones as $accion)
                    @if ($accion->cod_accion == "GCM06")
        				{ //ACCIONES
        					"targets": 3,
        					"className": 'dt-head-center dt-body-center',
        					"createdCell": function (td, cellData, rowData, row, col) {
        				        $(td).css("vertical-align", "middle");
        				     
        				    }
        				}
                    @endif
                @endforeach
    		],		
				"columns": [
					{ "data": "actividad.0.act_fec_act", 
                        "className": "text-center",
                         "render": function(data, type, row){
							let fec_sht = data.substring(0,10);
							let fec = fec_sht.split('-');
							let fecha = fec[2]+'-'+fec[1]+'-'+fec[0];							

						 	return fecha;
						 }
						},
                        { "data": "actividad.0.lugarbitacora.0.cb_lug_bit_nom", "className": "text-center", 
                            // INICIO CZ SPRINT 67
                            "render": function(data, type, row){
                            if(row.actividad[0].lugarbitacora[0].cb_lug_bit_id == "7"){
                                return row.actividad[0].lug_bit_otro;
                            }else{
                                return row.actividad[0].lugarbitacora[0].cb_lug_bit_nom;
                            }
						 } 
                        //  FIN CZ SPRINT 67
                        },
                        { "data": 'actividad.0.hito.0.cb_hito_nom', "className": "text-center",
                            // INICIO CZ SPRINT 67
                            "render": function(data, type, row){
                            if(row.actividad[0].hito[0].cb_hito_id == 20){
                                return row.actividad[0].hito_otro;
                            }else{
                                return row.actividad[0].hito[0].cb_hito_nom;
                            }
						 } 
                        //  FIN CZ SPRINT 67
                        
                        },
                        // { "data": "actividad.0.act_plan", "className": "text-center" },
                        // { "data": "actividad.0.act_real", "className": "text-center" },
                        @foreach ($acciones as $accion)
                            @if ($accion->cod_accion == "GCM06")
        						{ //ACCIONES
        							"data": "",
        							"render": function(data, type, row){
                                        let html = '<div>';
        								html += '<button type="button" class="btn btn-warning editarActividad" style="margin-right: 5px;" data-act-id="'+row.act_id+'" onclick="{{ $accion->ruta }}" data-toggle="modal" data-target="#frmActividades"><i class="{{ $accion->clase }}"></i>  {{ $accion->nombre }}</button>';
                                        html += '<button type="button" class="btn btn-danger" id ="btn-eliminarActividad" data-act-id="'+row.act_id+'" data-toggle="modal" data-target="#modalEliminarActividad" onclick="enviarParametro('+row.act_id+')">Eliminar actividad</button>';
                                        html += '</div>';
                                        	//INICIO CZ SPRINT 67 correccion
                                            if($("#est_pro_id").val() == {{ config('constantes.finalizado') }} || $("#est_pro_id").val() == {{ config('constantes.desestimado') }} ){
                                                $('select').attr('disabled', 'disabled');
                                                $('input').attr('disabled', 'disabled');
                                                $('textarea').attr('disabled', 'disabled');
                                                $('.btn-danger').attr('disabled', 'disabled');
                                                $('.close').removeAttr('disabled', 'disabled');
                                                $('.editarActividad').removeAttr('disabled', 'disabled');
                                            }
                                            //FIN CZ SPRINT 67 correccion
                                            
        								return html;
        							}
        						},
                            @endif
                        @endforeach
				]
			});
        }
        // INICIO CZ SPRINT 67
        function enviarParametro(id){
            $("#confirm-eliminarActividad").attr('onclick', 'eliminarActividad("'+id+'")');
        }
        // FIN CZ SPRINT 67
        function limpiarFormularioActividades(){
    
            //INFORMACION GENERAL
            $("#act_fec_act").datetimepicker('clear');
            $("#lug_id").prop('selectedIndex', 0);
            $("#reg_id").prop('selectedIndex', 0);
            $("#com_id").prop('selectedIndex', 0);
            $("#act_cal").val("");
            $("#act_num").val("");
            $("#act_dep").val("");
            $("#act_blo").val("");
            $("#act_cas").val("");
            $("#act_sit").val("");
            $("#act_ref").val("");

            //PARTICIPANTES
            $("#act_id").prop('selectedIndex', 0);
            $("#act_tot_part").val("");
            $("#act_num_nna").val("");
            $("#act_num_adult").val(""); 

            //ACTIVIDADES
            $("#hit_id").prop('selectedIndex', 0);
            $("#act_plan").val("");
            $("#act_real").val("");
            $("#act_mat").val("");
            $("#act_des").val("");
            $("#act_obs").val("");

            $('#act_fec_act').datetimepicker('format', 'DD/MM/Y');
            $("#informacion").collapse('hide');
            $("#participantes").collapse('hide');
            $("#actividades").collapse('hide');

            limpiarValidacionesFrmActividades();
        }

        function limpiarValidacionesFrmActividades(){

            //INFORMACION GENERAL
            $("#val_act_fec_act").hide();
            $("#val_lug_id").hide();
            // INICIO CZ SPRINT 67
            $("#meng_text_hito").hide();
            $("#meng_text_lug").hide();
            $("#text_lug").removeClass("is-invalid");
            $("#txt_hit").removeClass("is-invalid");
            // FIN CZ SPRINT 
            $("#val_nna_region").hide();
            $("#val_com_id").hide();
            //$("#val_act_cal").hide();
            $("#val_act_num").hide();

            $("#act_fec_act").removeClass("is-invalid");
            $("#lug_id").removeClass("is-invalid");
            $("#reg_id").removeClass("is-invalid");
            $("#com_id").removeClass("is-invalid");
            //$("#act_cal").removeClass("is-invalid");
            $("#act_num").removeClass("is-invalid");        

            //PARTICIPANTES
            $("#val_act_id").hide();
            $("#val_act_tot_part").hide();
            $("#val_act_num_nna").hide();
            $("#val_act_num_adult").hide(); 

            $("#act_id").removeClass("is-invalid");
            $("#act_tot_part").removeClass("is-invalid");
            $("#act_num_nna").removeClass("is-invalid");
            $("#act_num_adult").removeClass("is-invalid");

            //ACTIVIDADES
            $("#val_hit_id").hide();
            $("#val_act_plan").hide();
            $("#val_act_real").hide();
            $("#val_act_mat").hide();
            $("#val_act_des").hide();

            $("#hit_id").removeClass("is-invalid");
            $("#act_plan").removeClass("is-invalid");
            $("#act_real").removeClass("is-invalid");
            $("#act_des").removeClass("is-invalid");
            $("#act_mat").removeClass("is-invalid");
        }


        function validarFrmActividad(){

            limpiarValidacionesFrmActividades();

            let respuesta = true;
            let colapsable = 0;
            
            //INFORMACION GENERAL
            let act_fec =  $("#act_fec_act").data('date');
            let act_lug =  $("#lug_id option:selected").val();
            let act_reg =  $("#reg_id option:selected").val();
            let act_com =  $("#com_id option:selected").val();
            let act_cal =  $("#act_cal").val();
            let act_num =  $("#act_num").val();
            // INICIO CZ SPRINT 67
            let otro_lug = $("#text_lug").val();
            // FIN CZ SPRINT 67
            //PARTICIPANTES
            let act_act =  $("#act_id option:selected").val();
            let act_tot =  $("#act_tot_part").val();
            let act_nna =  $("#act_num_nna").val();
            let act_adl =  $("#act_num_adult").val(); 

            //ACTIVIDADES
            let act_hito =  $("#hit_id option:selected").val();
            // INICIO CZ SPRINT 67
            let otro_hito = $("#txt_hit").val();
            // FIN CZ SPRINT 67
            let act_plan =  $("#act_plan").val();
            let act_real =  $("#act_real").val();
            let act_desc =  $("#act_des").val();
            let act_mate =  $("#act_mat").val();

            //  ACTIVIDADES

            if (act_hito == "" || typeof act_hito === "undefined"){
                respuesta = false;
                $("#val_hit_id").show();
                $("#hit_id").addClass("is-invalid");
                colapsable = 3;
            } 
            // INICIO CZ SPRINT 67
            if (act_hito == 20){
                if (otro_hito == "" || typeof otro_hito === "undefined"){
                    respuesta = false;
                    $("#meng_text_hito").show();
                    $("#txt_hit").addClass("is-invalid");
                    colapsable = 3;
                } 
            } 
            // FIN CZ SPRINT 67
            if (act_plan == "" || typeof act_plan === "undefined"){
                respuesta = false;
                $("#val_act_plan").show();
                $("#act_plan").addClass("is-invalid");
                colapsable = 3;
            }

            // INICIO CZ SPRINT 67
            // if (act_real == "" || typeof act_real === "undefined"){
            //     respuesta = false;
            //     $("#val_act_real").show();
            //     $("#act_real").addClass("is-invalid");
            //     colapsable = 3;
            // }
                // FIN CZ SPRINT 67
            if (act_desc == "" || typeof act_desc === "undefined"){
                respuesta = false;
                $("#val_act_des").show();
                $("#act_des").addClass("is-invalid");
                colapsable = 3;
            }
            // INICIO CZ SPRINT 67
            // if (act_mate == "" || typeof act_mate === "undefined"){
            //     respuesta = false;
            //     $("#val_act_mat").show();
            //     $("#act_mat").addClass("is-invalid");
            //     colapsable = 3;
            // }
            //FIN CZ SPRINT 67 
            //  PARTICIPANTES

            if (act_act == "" || typeof act_act === "undefined"){
                respuesta = false;
                $("#val_act_id").show();
                $("#act_id").addClass("is-invalid");
                colapsable = 2;
            }
            
            if (act_tot == "" || typeof act_tot === "undefined"){
                respuesta = false;
                $("#val_act_tot_part").show();
                $("#act_tot_part").addClass("is-invalid");
                colapsable = 2;
            } 

            if (act_nna == "" || typeof act_nna === "undefined"){
                respuesta = false;
                $("#val_act_num_nna").show();
                $("#act_num_nna").addClass("is-invalid");
                colapsable = 2;
            } 

            if (act_adl == "" || typeof act_adl === "undefined"){
                respuesta = false;
                $("#val_act_num_adult").show();
                $("#act_num_adult").addClass("is-invalid");
                colapsable = 2;
            } 

            // INFORMACION GENERAL

            
            if (act_fec == "" || typeof act_fec === "undefined"){
                respuesta = false;
                $("#val_act_fec_act").show();
                $("#act_fec_act").addClass("is-invalid");
                colapsable = 1;
            }else{
                if (!validarFormatoFecha(act_fec)){
                    respuesta = false;
                    $("#val_act_fec_act").show();
                    $("#act_fec_act").addClass("is-invalid");
                    colapsable = 1;
                }

                if (!existeFecha(act_fec)){
                    respuesta = false;
                    $("#val_act_fec_act").show();
                    $("#act_fec_act").addClass("is-invalid");
                    colapsable = 1;
                }
            }            
            
            if (act_lug == "" || typeof act_lug === "undefined"){
                respuesta = false;
                $("#val_lug_id").show();
                $("#lug_id").addClass("is-invalid");
                colapsable = 1;
            }
            // INICIO CZ SPRINT 67
            if (act_lug == "7"){
                if (otro_lug == "" || typeof otro_lug === "undefined"){
                respuesta = false;
                $("#meng_text_lug").show();
                $("#text_lug").addClass("is-invalid");
                colapsable = 1;
                } 
            }
            // FIN CZ SPRINT 67

            // INICIO CZ SPRINT 67

            // if (act_reg == "" || typeof act_reg === "undefined"){
            //     respuesta = false;
            //     $("#val_nna_region").show();
            //     $("#reg_id").addClass("is-invalid");
            //     colapsable = 1;
            // } 

            // if (act_com == "" || typeof act_com === "undefined"){
            //     respuesta = false;
            //     $("#val_com_id").show();
            //     $("#com_id").addClass("is-invalid");
            //     colapsable = 1;
            // } 

            // if (act_cal == "" || typeof act_cal === "undefined"){
            //     respuesta = false;
            //     $("#val_act_cal").show();
            //     $("#act_cal").addClass("is-invalid");
            // } 

            // if (act_num == "" || typeof act_num === "undefined"){
            //     respuesta = false;
            //     $("#val_act_num").show();
            //     $("#act_num").addClass("is-invalid");
            //     colapsable = 1;
            // } 
            // FIN CZ SPRINT 67

            switch (colapsable) {
                case 1:
                    $("#informacion").collapse('show');
                    break;
                case 2:
                    $("#participantes").collapse('show');
                    break;
                case 3:
                    $("#actividades").collapse('show');
                    break;
            }

            return respuesta;

        }

        function ingresarActividad(){
           
            let res_val_frm = validarFrmActividad();
            let opcion = $("#reg_edt").val();
            
            if (res_val_frm == false){

                mensaje = "Por favor ingresar los campos requeridos";
                mensajeTemporalRespuestas(0, mensaje);
                return false;
            } 

            bloquearPantalla(); 

            var data = new Object();

            // I. INFORMACION GENERAL
            
            data.fec = $("#act_fec_act").data('date');
            data.lug = $("#lug_id option:selected").val();
            data.reg = $("#reg_id").val();
            data.com = "<?php echo $com_id; ?>";
            data.cal = $("#act_cal").val();
            data.num = $("#act_num").val();
            data.dep = $("#act_dep").val();
            data.blo = $("#act_blo").val();
            data.cas = $("#act_cas").val();
            data.sit = $("#act_sit").val();
            data.ref = $("#act_ref").val();

            // II. PARTICIPANTES

            data.act_act    = $("#act_id option:selected").val();
            data.act_par    = $("#act_tot_part").val();
            data.act_nna    = $("#act_num_nna").val();
            data.act_adl    = $("#act_num_adult").val();

            // III.   ACTIVIDADES

            data.act_hito   = $("#hit_id option:selected").val();
            data.act_plan   = $("#act_plan").val();
            data.act_real   = $("#act_real").val();
            data.act_desc   = $("#act_des").val();
            data.act_mate   = $("#act_mat").val();
            data.act_obsv   = $("#act_obs").val();

            // Hidden ID
            
            data.bit_id     = $("#bit_id").val();
            data.est_pro_id = $("#est_pro_id").val();
            data.act_id     = $("#actb_id").val();
            data.reg_opc    = opcion;
            // INICIO CZ SPRINT 67
            data.lug_bit_otro     = $("#text_lug").val(); 
            data.act_hito_otro     = $("#txt_hit").val(); 
            //FIN CZ SPRINT 67
            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });

            $.ajax({
                url: "{{ route('registrar.actividad') }}",
                type: "POST",
                data: data
            }).done(function(resp){
                    $('#frmActividades').modal('hide');
                    limpiarFormularioActividades();                    
                    
                    if (resp.estado == 1){

                        mensajeTemporalRespuestas(1, resp.mensaje);
                        $('#tabla_actividades').DataTable().ajax.reload();

                    }else if(resp.estado == 0){
                        
                        mensajeTemporalRespuestas(0, resp.mensaje);
                        $('#tabla_actividades').DataTable().ajax.reload();

                    }

                    desbloquearPantalla();
            }).fail(function(objeto, tipoError, errorHttp){
                    desbloquearPantalla();

                    manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

                    return false;
            });

         }

        

    function editarActividad(_this, opcion = 0){
            // INICIO CZ SPRINT 67
            $('#lug_id option').each(function() {
                if ( $(this).val() != '' ) {
                    $(this).remove();
                }
                
            });
            $('#act_id option').each(function() {
                if ( $(this).val() != '' ) {
                    $(this).remove();
                }
            });
            $('#hit_id option').each(function() {
                if ( $(this).val() != '' ) {
                    $(this).remove();
                }
            });
            // FIN CZ SPRINT 67
            
            let act_id = $(_this).attr("data-act-id");

            limpiarFormularioActividades()
            let data = new Object();
            data.act_id = act_id;
            data.tip_ges = {{$tipo_gestion}};
            
            $("#reg_edt").val(opcion);
            $("#actb_id").val(act_id);            
            $('#act_fec_act').datetimepicker('format', 'DD/MM/Y');

            $.ajax({
                type: "GET",  
                url: "{{ route('actividad.form.editar') }}",
                data: data
            }).done(function(resp){   
                
                act_data = $.parseJSON(resp.act_data);
                act_lug = $.parseJSON(resp.act_lug);
                act_reg = $.parseJSON(resp.act_reg);
                act_com = $.parseJSON(resp.act_com);
                act_act = $.parseJSON(resp.act_act);
                act_hit = $.parseJSON(resp.act_hit);
                act_dir = $.parseJSON(resp.act_dir);
                // INICIO CZ SPRINT 67
                $("#text_lug").val("");
                $( "#text_lug" ).prop( "disabled", false );
                $("#txt_hit").val("");
                $( "#txt_hit" ).prop( "disabled", false );
                $("#div-txt_hit").css("display", "none");
                $("#div-text_lug").css("display", "none");
                // FIN CZ SPRINT 67

                if(opcion == 0){

                                   
                    $.each(act_lug, function(i, item){
                        $('#lug_id').append('<option value="'+ item.cb_lug_bit_id +'">'+item.cb_lug_bit_nom+'</option>');
                                           
                    });

                    $.each(act_act, function(i, item){
                        $('#act_id').append('<option value="'+ item.cb_tip_act_id +'">'+item.cb_tip_act_nom+'</option>');
                        
                        
                    });

                    $.each(act_hit, function(i, item){
                        $('#hit_id').append('<option value="'+ item.cb_hito_id +'">'+item.cb_hito_nom+'</option>');
                      
                        
                    });
                    $.each(act_reg, function(i, item){
                        $('#reg_id').append('<option value="'+ item.reg_id +'">'+item.reg_nom+'</option>');
                                            
                    });

                    $.each(act_com, function(i, item){
                        $('#com_id').append('<option value="'+ item.com_id +'">'+item.com_nom+'</option>');
                                                
                    });

                }else{
                    $.each(act_lug, function(i, item){
                        if(item.cb_lug_bit_id == act_data.lug_bit_id){
                            $('#lug_id').append('<option selected="selected" value="'+ item.cb_lug_bit_id +'">'+item.cb_lug_bit_nom+'</option>');
                        }else{
                            $('#lug_id').append('<option value="'+ item.cb_lug_bit_id +'">'+item.cb_lug_bit_nom+'</option>');
                        }                    
                    });
                    $.each(act_act, function(i, item){
                        if(item.cb_tip_act_id == act_data.tip_act_id){
                            $('#act_id').append('<option selected="selected" value="'+ item.cb_tip_act_id +'">'+item.cb_tip_act_nom+'</option>');
                        }else{
                            $('#act_id').append('<option value="'+ item.cb_tip_act_id +'">'+item.cb_tip_act_nom+'</option>');
                        }
                        
                    });

                    $.each(act_hit, function(i, item){
                        if(item.cb_hito_id == act_data.hito_id){
                            $('#hit_id').append('<option selected="selected" value="'+ item.cb_hito_id +'">'+item.cb_hito_nom+'</option>');
                        }else{
                            $('#hit_id').append('<option value="'+ item.cb_hito_id +'">'+item.cb_hito_nom+'</option>');
                        }
                        
                    });

                    $.each(act_reg, function(i, item){
                        if(item.reg_id == act_dir.ciudad_id){
                            $('#reg_id').append('<option selected="selected" value="'+ item.reg_id +'">'+item.reg_nom+'</option>');
                        }else{
                            $('#reg_id').append('<option value="'+ item.reg_id +'">'+item.reg_nom+'</option>');
                        }                     
                    });

                    $.each(act_com, function(i, item){
                        if(item.com_id == act_dir.com_id){
                            $('#com_id').append('<option selected="selected" value="'+ item.com_id +'">'+item.com_nom+'</option>');
                        }else{
                            $('#com_id').append('<option value="'+ item.com_id +'">'+item.com_nom+'</option>');
                        } 
                        
                    });   
                }                    
                if(opcion == 1){
                    $('#act_cal').val(act_dir.calle_id);
                    $('#act_num').val(act_dir.dir_bit_num);
                    $("#act_dep").val(act_dir.dir_bit_dep);
                    $("#act_blo").val(act_dir.dir_bit_block);
                    $("#act_cas").val(act_dir.dir_bit_casa);
                    $("#act_sit").val(act_dir.dir_bit_km);
                    $("#act_ref").val(act_dir.dir_bit_ref);
                    
                    let fec = new Date(act_data.act_fec_act);
                    fec = fec.getDate()+"/"+(fec.getMonth() + 1 )+"/"+fec.getFullYear();

                    $('#act_fec_act').datetimepicker('date', fec);	
                    $('#act_tot_part').val(act_data.act_num_part);
                    $('#act_num_nna').val(act_data.act_num_nna);
                    $('#act_num_adult').val(act_data.act_num_adult);
                    $('#act_plan').val(act_data.act_plan);
                    $('#act_real').val(act_data.act_real);
                    $('#act_des').val(act_data.act_desc);
                    $('#act_mat').val(act_data.act_mat_ins);
                    $('#act_obs').val(act_data.act_obs);
                    //INICIO CZ SPRINT 67
                    if($('#lug_id').val() == "7"){
 
                        $("#text_lug").val(act_data.lug_bit_otro);
                        $("#div-text_lug").css("display", "flex");

                    }else{
                        $("#text_lug").val("");
                        $( "#text_lug" ).prop( "disabled", true );
                } 
                    // FIN CZ SPRINT 67
                    // INICIO CZ SPRINT 67
                
                    if($("#hit_id").val()== "20"){
                        $("#txt_hit").val(act_data.hito_otro);
                        $("#div-txt_hit").css("display", "flex");
                    }else{
                        $("#div-txt_hit").css("display", "none");
                        $("#txt_hit").val("");
                        $( "#txt_hit" ).prop( "disabled", true );
                    }
                    // FIN CZ SPRINT 67
                }
                    //INICIO CZ SPRINT 67 correccion
                    if($("#est_pro_id").val() == {{ config('constantes.finalizado') }} || $("#est_pro_id").val() == {{ config('constantes.desestimado') }} ){
                        $( "#text_lug" ).prop( "disabled", true );
                        $( "#txt_hit" ).prop( "disabled", true );
                    $( ".ingresarActividad" ).prop( "disabled", true );
                        $( ".close" ).prop( "disabled", false );
                        $( ".editarActividad" ).prop( "disabled", false );
                        
                    }
                    //FIN CZ SPRINT 67 correccion
            }).fail(function(objeto, tipoError, errorHttp){
                desbloquearPantalla();

                manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

                return false;
            });

	}
    // INICIO CZ SPRINT 67
    function eliminarActividad(id){
        bloquearPantalla();
        let data = new Object();
        data.act_id = id;
        $.ajaxSetup({
                    headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}
                });
        $.ajax({
                type:"post",
                url: "{{route('eliminarActividad')}}",
                data: data
            }).done(function(resp){
                $('#modalEliminarActividad').modal('hide')
                desbloquearPantalla();
                if(resp.estado == 1){
                    toastr.success(resp.mensaje);  
                    listarActividades();      
                }
            }).fail(function(objeto, tipoError, errorHttp){            
                desbloquearPantalla();
                manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

                return false;
            });
    }
    // FIN CZ SPRINT 67
</script>