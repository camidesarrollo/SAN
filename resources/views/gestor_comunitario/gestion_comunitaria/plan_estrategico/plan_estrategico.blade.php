<div class="row"> 
    <div class="card shadow-sm p-4 w-100">        
        <div class="tab-content" id="myTabContent">

			 <!-- Plan Estrategico Comunitario -->
             <div class="tab-pane fade" id="plan-est-com" role="tabpanel" aria-labelledby="plan-est-com" style="display: none">
			 	@includeif('gestor_comunitario.gestion_comunitaria.plan_estrategico.informe_pec.plan_estrategico_com')   
				 <div class="text-center"> 
                    <button type="button" id="btn-plan-est-com" disabled class="btn btn-success btnEtapa" onclick="cambiarEstadoGestorComunitario();">Ir a la siguiente etapa - <strong>Linea de salida</strong></button>
		</div>
	</a>
	<div class="collapse" id="listar_informe">
		<div class="card-body">
    		
		</div>

			<!-- Linea Salida -->
			<div class="tab-pane fade" id="linea-salida-com" role="tabpanel" aria-labelledby="linea-salida-com" style="display: none">                
				@includeif('gestor_comunitario.gestion_comunitaria.plan_estrategico.linea_salida.linea_salida')
                <div class="text-center"> 
                    <button type="button" id="btn-linea-salida-com" disabled class="btn btn-success btnEtapa" onclick="cambiarEstadoGestorComunitario();">Ir a la siguiente etapa - <strong>Informe plan estrategico comunitario</strong></button>
	</div>
</div>

			<!-- Informe Plan Estrategico Comunitario  -->
            <div class="tab-pane fade" id="inf-plan-est-com" role="tabpanel" aria-labelledby="inf-plan-est-com" style="display: none">                
				@includeif('gestor_comunitario.gestion_comunitaria.plan_estrategico.informe_pec.informe_pec')   
		</div>

		</div>
	</div>
</div>

<script>
	var actividad = [];
	let cont_frm_div_per_com = "";
    function valTextAreaMatDivergencia2(input){
      num_caracteres_permitidos   = 2000;
      num_caracteres = $(input).val().length;
       if (num_caracteres > num_caracteres_permitidos){ 
            $(input).val(cont_frm_div_per_com);

       }else{ 
          cont_frm_div_per_com = $(input).val(); 
       }
       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_"+input.id).css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_"+input.id).css("color", "#000000");

       }       
       $("#cant_carac_"+input.id).text($(input).val().length);
	}
	
    function guardxarEjePkanEst(){
    	var id = $('#idProb').val();
 		var resultado = $('#inf_resultado').val();
 		var Facilitadores = $('#inf_faqcilitadores').val();
 		var Obstaculizadores = $('#inf_obstaculizaciones').val();
 		var Aprendizajes = $('#inf_aprendisaje').val();
 		var error = 0;
 		var msj = '';
 		if(resultado == ''){
 			error = 1;
 			$("#inf_resultado").css("border-color", "#ff0000");
 			msj = msj + 'Debe ingresar el Resultado<br>';
 		}else{
 			$("#inf_resultado").css("border-color", "#d1d3e2");
 		}
 		if(Facilitadores == ''){
 			error = 1;
 			$("#inf_faqcilitadores").css("border-color", "#ff0000");
 			msj = msj + 'Debe ingresar los facilitadores<br>';
 		}else{
 			$("#inf_faqcilitadores").css("border-color", "#d1d3e2");
 		}
 		if(Obstaculizadores == ''){
 			error = 1;
 			$("#inf_obstaculizaciones").css("border-color", "#ff0000");
 			msj = msj + 'Debe ingresar los Obstaculizadores<br>';
 		}else{
 			$("#inf_obstaculizaciones").css("border-color", "#d1d3e2");
 		}
 		if(Aprendizajes == ''){
 			error = 1;
 			$("#inf_aprendisaje").css("border-color", "#ff0000");
 			msj = msj + 'Debe ingresar el Aprendizaje<br>';
 		}else{
 			$("#inf_aprendisaje").css("border-color", "#d1d3e2");
 		}
 		if(error != 0){
 		
 			mensajeTemporalRespuestas(0, msj);
 		}else{
 			bloquearPantalla();
 			let data = new Object();
        	data.id = id;
        	data.resultado = resultado;
        	data.Facilitadores = Facilitadores;
        	data.Obstaculizadores = Obstaculizadores;
        	data.Aprendizajes = Aprendizajes;
        	$.ajax({
                type: "GET",
                url: "{{route('guardar.datos.pec')}}",
                data: data
            }).done(function(resp){
               
               if(resp == 1){
               	mensajeTemporalRespuestas(1, "Datos editados");	
               }else{
               mensajeTemporalRespuestas(0, "Ha ocurrido un error inesperado");	
              }
				desbloquearPantalla(); 
            }).fail(function(objeto, tipoError, errorHttp){
    
                desbloquearPantalla();
                manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
                return false;
    
            });
 		}
	}
	
    function addActividades(idPlan){
    	bloquearPantalla();
    	//Se insertan actividades
        for(var i = 0; i < actividad.length; i++){
        	let data2 = new Object();
            data2.Actividad = actividad[i][1];
            data2.checkRelCom = actividad[i][6];
            data2.checkTallCom = actividad[i][7];
            data2.checkIniCom = actividad[i][8];
            data2.Metodologia = actividad[i][3];
            data2.Responsables = actividad[i][4];
            data2.Plazo = actividad[i][5];
            data2.idPlan = idPlan;
            $.ajax({
            	type: "GET",
                url: "{{route('edit.actividad.pe')}}",
                data: data2
            }).done(function(resp){
            	mensajeTemporalRespuestas(1, 'Se han guardado las actividades.');					  
    			$('#PlanActividades').modal('hide');
    			desbloquearPantalla();
            }).fail(function(objeto, tipoError, errorHttp){
                desbloquearPantalla();
                manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
                return false;
            });
        }
    }
    
    function cargarInformeAnexosPEC(){
    	bloquearPantalla(); 
    	var form = document.getElementById('adj_info_anex');
    	let formData = new FormData(form);
    	formData.append('pro_an_id', {{$pro_an_id}});
    	formData.append('_token', $('input[name=_token]').val());
    	console.log(formData);
    	$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: "{{ route('cargar.documentosPEC') }}",
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        }).done(function(resp){
			if(resp == 1){
				mensajeTemporalRespuestas(1, "Se ha subido el archivo");	
				desplegarInfPlanEst();
			}else if(resp == -1){
				mensajeTemporalRespuestas(1, "Formato incorrecto");
			}else{
				mensajeTemporalRespuestas(0, "Ha ocurrido un error inesperado");
			}
			desbloquearPantalla();
        }).fail(function(objeto, tipoError, errorHttp){
            desbloquearPantalla();
            setTimeout(function(){ $("#alert-err-doc"+tipo).hide(); }, 5000);
            setTimeout(function(){ $("#alert-err-doc-ext"+tipo).hide(); }, 5000);

            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

            return false;
        });
        
    }
    
    function registrarInformePE(){
    	bloquearPantalla();
        let data = new Object();
        //IDENTIFICACIOON
        data.nomGestorComCar = $('#inf_nomGestorComCar').val();
        data.comuna = $('#inf_comuna').val();
        data.com_pri = $('#inf_com_pri').val();
        data.fec_pri_con = $("#info_fec_pri_con").data('date');
        data.fec_ter_dpc = $("#info_fec_ter_dpc").data('date');
        //INTRODUCCION
        data.info_intro = $('#info_intro').val();
        //RESULTADOS
        data.info_result = $('#info_result').val();
        //CONCLUSIONES Y RECOMENDACIONES
        data.info_con_rec = $('#info_con_rec').val();      
        data.pro_an_id = {{$pro_an_id}};
        $.ajax({
        	type: "GET",
            url: "{{route('guardar.informe.pe')}}",
            data: data
        }).done(function(resp){
        	console.log(resp);
        	if(resp.estado == 1){
        		mensajeTemporalRespuestas(1, resp.mensaje);	
        	}else{
        		mensajeTemporalRespuestas(0, 'Ha ocurrido un error inesperado');	
        	}
        	desbloquearPantalla();
        }).fail(function(objeto, tipoError, errorHttp){
        	desbloquearPantalla();
            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
            return false;
        });
    }
    
    function updateActividades(idPlan){
    	bloquearPantalla();
		if(actividad.length == 0){
    		mensajeTemporalRespuestas(0, 'Debe ingresar actividades.');
    	}else{
			//Se eliminan actividades
    		let data3 = new Object();
    		data3.idPlan = idPlan;
    		$.ajax({
            	type: "GET",
                url: "{{route('delete.actividad.pe')}}",
                data: data3
           }).done(function(resp1){
           		//Se insertan actividades
               	for(var i = 0; i < actividad.length; i++){
                	let data2 = new Object();
                    data2.Actividad = actividad[i][1];
                    data2.checkRelCom = actividad[i][6];
                    data2.checkTallCom = actividad[i][7];
                    data2.checkIniCom = actividad[i][8];
                    data2.Metodologia = actividad[i][3];
                    data2.Responsables = actividad[i][4];
                    data2.Plazo = actividad[i][5];
                    data2.idPlan = resp1;
                    $.ajax({
                    	type: "GET",
                        url: "{{route('edit.actividad.pe')}}",
                        data: data2
                    }).done(function(resp){
                    	mensajeTemporalRespuestas(1, 'Se han guardado las actividades.');					  
    					$('#PlanActividades').modal('hide');
						// INICIO CZ SPRINT 67
						desplegarPlanEstCom();
						// FIN CZ SPRINT 67
    					desbloquearPantalla();
                    }).fail(function(objeto, tipoError, errorHttp){
                    	desbloquearPantalla();
                        manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
                        return false;
                    });
                }
                desbloquearPantalla();
           	}).fail(function(objeto, tipoError, errorHttp){
              		desbloquearPantalla();
                	manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
                    return false;
            });
    	}
    }
    
    function editarActividades(idProb, idPlan){
    	bloquearPantalla();  
    	$('#frmAddAct').fadeOut();
    	$('#tblAct').fadeIn();
    	$('#btnAddAct').html('Agregar Actividad');
    	$('#btnAddAct').attr('onclick', 'addAct()');
    	actividad.length = 0;
    	actualizaTablaAct();
    	if(idPlan == null){
    		$('#btnGuardarEditarAct').attr('disabled', 'disabled');
    		$('#msj_error').fadeIn(0);
    		desbloquearPantalla();
    	}else{    
    		$('#btnGuardarEditarAct').removeAttr('disabled');	
    		$('#btnGuardarEditarAct').attr('onClick', 'updateActividades('+idPlan+')');
    		$('#msj_error').fadeOut(0);	
    		let data2 = new Object();
        	data2.idPlan = idPlan;
        	$.ajax({
            	type: "GET",
            	url: "{{route('get.actividad.plan.estrategico')}}",
            	data: data2
            }).done(function(resp2){
            	console.log(resp2);
            	var datos = JSON.parse(resp2);
            	if(datos.length > 0){        				
            		for (var i = 0; i < datos.length; i+=1) {
            			var estrategia = '';
            			if(datos[i].act_checkrelcom == 1){
                        	estrategia = estrategia + '- Relacionamiento Comunitario<br>';
                        }
                        if(datos[i].act_checktallcom == 1){
                        	estrategia = estrategia + '- Talleres Comunitarios<br>';
                        }
                        if(datos[i].act_checkinicom == 1){
                        	estrategia = estrategia + '- Iniciativa Comunitaria<br>';
                        }
                        actividad.push([
                        	actividad.length + 1,
                            datos[i].act_nombre, 
                            estrategia,
                            datos[i].act_metodologia, 
                            datos[i].act_responsables,
                            datos[i].act_plazo,
                            datos[i].act_checkrelcom, 
                            datos[i].act_checktallcom,
                            datos[i].act_checkinicom
                        ]);
                    }
                    actualizaTablaAct();
            	}
            	desbloquearPantalla();
            }).fail(function(objeto, tipoError, errorHttp){
            	desbloquearPantalla();
                manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
                return false;
            });
    	}
    	$('#PlanActividades').modal('show');
    }
    
    function guardarAct(){
    	var Actividad = $('#txt_plan_actividad').val();
    	var Metodologia = $('#txt_plan_metodologia').val();
    	var Responsables = $('#txt_plan_responsables').val();
    	var Plazo = $('#txtPlazoPlan').val();
    	var error = 0;
    	if(Actividad == ''){
    		$("#txt_plan_actividad").css("border-color", "#ff0000");
    		$('#val_txt_plan_actividad').fadeIn(200);
    		mensajeTemporalRespuestas(0, 'Ingrese la Actividad.');
    		error = 1; 
    	}else{
    		$("#txt_plan_actividad").css("border-color", "#d1d3e2");
    		$('#val_txt_plan_actividad').fadeOut(200); 
    	}
    	if(Metodologia == ''){
    		$("#txt_plan_metodologia").css("border-color", "#ff0000");
    		$('#val_txt_plan_metodologia').fadeIn(200);
    		mensajeTemporalRespuestas(0, 'Ingrese la Metodologia.'); 
    		error = 1;
    	}else{
    		$("#txt_plan_metodologia").css("border-color", "#d1d3e2");
    		$('#val_txt_plan_metodologia').fadeOut(200); 
    	}
    	if(Responsables == ''){
    		$("#txt_plan_responsables").css("border-color", "#ff0000");
    		$('#val_txt_plan_responsables').fadeIn(200); 
    		mensajeTemporalRespuestas(0, 'Ingrese los Responsables.'); 
    		error = 1;
    	}else{
    		$("#txt_plan_responsables").css("border-color", "#d1d3e2");
    		$('#val_txt_plan_responsables').fadeOut(200); 
    	}
    	if(Plazo == ''){
    		$("#txtPlazoPlan").css("border-color", "#ff0000");
    		$('#val_txtPlazoPlan').fadeIn(200); 
    		mensajeTemporalRespuestas(0, 'Ingrese el Plazo.'); 
    		error = 1;
    	}else{
    		if(Plazo > 16){
    			$("#txtPlazoPlan").css("border-color", "#ff0000");
    			mensajeTemporalRespuestas(0, 'El plazo maximo es de 16 semanas.');
    			error = 1;
    		}else{
    			$("#txtPlazoPlan").css("border-color", "#d1d3e2");
    			$('#val_txtPlazoPlan').fadeOut(200); 
    		}    		
    	}
		if (!$('#checkRelCom').is(':checked') && !$('#checkTallCom').is(':checked') && !$('#checkIniCom').is(':checked')) {
            error = 1;
            $('#val_checkEstrategia').fadeIn(200);
            mensajeTemporalRespuestas(0, 'Debe seleccionar la Estrategia.');
        }else{
        	$('#val_checkEstrategia').fadeOut(200);
        }
        if(error == 0){
            var estrategia = '';
            var checkRelCom = 0;
            var checkTallCom = 0;
            var checkIniCom = 0;
            if($('#checkRelCom').is(':checked')){
            	estrategia = estrategia + '- Relacionamiento Comunitario<br>';
            	checkRelCom = 1;
            }
            if($('#checkTallCom').is(':checked')){
            	estrategia = estrategia + '- Talleres Comunitarios<br>';
            	checkTallCom = 1;
            }
            if($('#checkIniCom').is(':checked')){
            	estrategia = estrategia + '- Iniciativa Comunitaria<br>';
            	checkIniCom = 1;
            }
        	actividad.push([
        		actividad.length + 1,
        		Actividad, 
        		estrategia,
        		Metodologia, 
        		Responsables,
        		Plazo,
        		checkRelCom, 
        		checkTallCom,
        		checkIniCom
        	]);
        	mensajeTemporalRespuestas(1, 'Actividad Agregada (Presione "Guardar" para aplicar cambios).');
        	volverAddAct();
        }
    }
    
    function actualizaTablaAct(){    	
    	$('#tblAct tbody').html('');
    	var cont = 0;
    	for(var i = 0; i < actividad.length; i++){
    		cont++;    			
    		var id = actividad[i][0];
        	var Actividad = actividad[i][1];
        	var Estrategia = actividad[i][2];
        	var Metodologia = actividad[i][3];
        	var Responsables = actividad[i][4];
        	var Plazo = actividad[i][5];
        	$('#tblAct tbody').append('<tr>'+
        	'<td>'+Actividad+'</td>'+
        	'<td>'+Estrategia+'</td>'+
        	'<td>'+Metodologia+'</td>'+
        	'<td>'+Responsables+'</td>'+
        	'<td>'+Plazo+'</td>'+
        	'<td>'+
        		'<button onclick="editAct('+id+')" type="button" class="btn btn-primary">Editar</button><br>'+
        		'<button onclick="delAct('+id+')" type="button" class="btn btn-danger">Quitar</button></td>'+
        	'</td>'+
        	'</tr>');
    		  		
    	}
    	$('#cont_act').html(cont);
    }
    
    function editarAct(){
    	var id = $('#idAct').val();
    	var Actividad = $('#txt_plan_actividad').val();
    	var Metodologia = $('#txt_plan_metodologia').val();
    	var Responsables = $('#txt_plan_responsables').val();
    	var Plazo = $('#txtPlazoPlan').val();
    	var estrategia = '';
        var checkRelCom = 0;
        var checkTallCom = 0;
        var checkIniCom = 0;
        var error = 0;
        if(Actividad == ''){
        	mensajeTemporalRespuestas(0, 'Ingrese la Actividad.');
    		$("#txt_plan_actividad").css("border-color", "#ff0000");
    		$('#val_txt_plan_actividad').fadeIn(200);
    		error = 1; 
    	}else{
    		$("#txt_plan_actividad").css("border-color", "#d1d3e2");
    		$('#val_txt_plan_actividad').fadeOut(200); 
    	}
    	if(Metodologia == ''){
    		mensajeTemporalRespuestas(0, 'Ingrese la Metodologia.');
    		$("#txt_plan_metodologia").css("border-color", "#ff0000");
    		$('#val_txt_plan_metodologia').fadeIn(200); 
    		error = 1;
    	}else{
    		$("#txt_plan_metodologia").css("border-color", "#d1d3e2");
    		$('#val_txt_plan_metodologia').fadeOut(200); 
    	}
    	if(Responsables == ''){
    		mensajeTemporalRespuestas(0, 'Ingrese los Responsables.');
    		$("#txt_plan_responsables").css("border-color", "#ff0000");
    		$('#val_txt_plan_responsables').fadeIn(200); 
    		error = 1;
    	}else{
    		$("#txt_plan_responsables").css("border-color", "#d1d3e2");
    		$('#val_txt_plan_responsables').fadeOut(200); 
    	}
    	if(Plazo == ''){
    		mensajeTemporalRespuestas(0, 'Ingrese el Plazo.');
    		$("#txtPlazoPlan").css("border-color", "#ff0000");
    		$('#val_txtPlazoPlan').fadeIn(200); 
    		error = 1;
    	}else{
    		if(Plazo > 16){
    			$("#txtPlazoPlan").css("border-color", "#ff0000");
    			mensajeTemporalRespuestas(0, 'El plazo maximo es de 16 semanas.');
    			error = 1;
    		}else{
    			$("#txtPlazoPlan").css("border-color", "#d1d3e2");
    			$('#val_txtPlazoPlan').fadeOut(200); 
    		}    		
    	}
    	if (!$('#checkRelCom').is(':checked') && !$('#checkTallCom').is(':checked') && !$('#checkIniCom').is(':checked')) {
            error = 1;
            $('#val_checkEstrategia').fadeIn(200);
            mensajeTemporalRespuestas(0, 'Debe seleccionar la Estrategia.');
        }else{
        	$('#val_checkEstrategia').fadeOut(200);
        }
    	if(error == 0){
    		if($('#checkRelCom').is(':checked')){
            	estrategia = estrategia + '- Relacionamiento Comunitario<br>';
                checkRelCom = 1;
            }
            if($('#checkTallCom').is(':checked')){
            	estrategia = estrategia + '- Talleres Comunitarios<br>';
                checkTallCom = 1;
            }
            if($('#checkIniCom').is(':checked')){
            	estrategia = estrategia + '- Iniciativa Comunitaria<br>';
                checkIniCom = 1;
            }
        	for(var i = 0; i < actividad.length; i++){
        		if(actividad[i][0] == id){
        			actividad[i][1] = Actividad;
            		actividad[i][2] = estrategia;
            		actividad[i][3] = Metodologia;
            		actividad[i][4] = Responsables;
            		actividad[i][5] = Plazo;
            		actividad[i][6] = checkRelCom;
            		actividad[i][7] = checkTallCom;
            		actividad[i][8] = checkIniCom;
            		volverAddAct();
            		mensajeTemporalRespuestas(1, 'Actividad Editada (Presione "Guardar" para aplicar cambios).');
        		}
        	}
    	}
        
    }
    
    function editAct(id){
    	$('#idAct').val(id);
    	$('#btnEditAct').fadeIn(0);
    	$('#btnGuardarAct').fadeOut(0);
    	$('#tblAct').fadeOut(0);
    	$('#frmAddAct').fadeIn(100);
    	$('#btnAddAct').html('Volver');
    	$('#btnAddAct').attr('onclick', 'volverAddAct()');
    	$('#txt_plan_actividad').val('');
    	$("#checkRelCom").prop("checked", false);
    	$("#checkTallCom").prop("checked", false);
    	$("#checkIniCom").prop("checked", false);
    	$('#txt_plan_metodologia').val('');
    	$('#txt_plan_responsables').val('');
    	$('#txtPlazoPlan').val('');
    	$("#txt_plan_actividad").css("border-color", "#d1d3e2");
    	$('#val_txt_plan_actividad').fadeOut(0);
    	$('#val_checkEstrategia').fadeOut(0);	
    	$("#txt_plan_metodologia").css("border-color", "#d1d3e2");
    	$('#val_txt_plan_metodologia').fadeOut(0);	
    	$("#txt_plan_responsables").css("border-color", "#d1d3e2");
    	$('#val_txt_plan_responsables').fadeOut(0);
    	$("#txtPlazoPlan").css("border-color", "#d1d3e2");
    	$('#val_txtPlazoPlan').fadeOut(0);	
    	for(var i = 0; i < actividad.length; i++){
    		if(actividad[i][0] == id){
    			$('#txt_plan_actividad').val(actividad[i][1]);
    			if(actividad[i][6] == 1){
    				$("#checkRelCom").prop("checked", true);
    			}else{
    				$("#checkRelCom").prop("checked", false);
    			}
    			if(actividad[i][7] == 1){
    				$("#checkTallCom").prop("checked", true);
    			}else{
    				$("#checkTallCom").prop("checked", false);
    			}
    			if(actividad[i][8] == 1){
    				$("#checkIniCom").prop("checked", true);
    			}else{
    				$("#checkIniCom").prop("checked", false);
    			}
    			$('#txt_plan_metodologia').val(actividad[i][3]);
    			$('#txt_plan_responsables').val(actividad[i][4]);
    			$('#txtPlazoPlan').val(actividad[i][5]);
    			calculaCaracteres('txt_plan_actividad');
    			calculaCaracteres('txt_plan_metodologia');
    			calculaCaracteres('txt_plan_responsables');
    		}
    	}
    }
    
    function delAct(id){
    	for(var i = 0; i < actividad.length; i++){
    		if(actividad[i][0] == id){
				actividad.splice( i, 1 );
    			mensajeTemporalRespuestas(1, 'Actividad eliminada (Presione "Guardar" para aplicar cambios").');
    		}
    	}
    	console.log(actividad);
    	actualizaTablaAct();
    }
    
    function addAct(){
    	$('#btnGuardarAct').fadeIn(0);
    	$('#btnEditAct').fadeOut(0);
    	$('#tblAct').fadeOut(0);
    	$('#frmAddAct').fadeIn(100);
    	$('#btnAddAct').attr('onclick', 'volverAddAct()');
    	$('#btnAddAct').html('Volver');
    	$('#txt_plan_actividad').val('');
    	$("#checkRelCom").prop("checked", false);
    	$("#checkTallCom").prop("checked", false);
    	$("#checkIniCom").prop("checked", false);
    	$('#txt_plan_metodologia').val('');
    	$('#txt_plan_responsables').val('');
    	$('#txtPlazoPlan').val('');
    	calculaCaracteres('txt_plan_actividad');
    	calculaCaracteres('txt_plan_metodologia');
    	calculaCaracteres('txt_plan_responsables');
    	$("#txt_plan_actividad").css("border-color", "#d1d3e2");
    	$('#val_txt_plan_actividad').fadeOut(0);
    	$('#val_checkEstrategia').fadeOut(0);	
    	$("#txt_plan_metodologia").css("border-color", "#d1d3e2");
    	$('#val_txt_plan_metodologia').fadeOut(0);	
    	$("#txt_plan_responsables").css("border-color", "#d1d3e2");
    	$('#val_txt_plan_responsables').fadeOut(0);
    	$("#txtPlazoPlan").css("border-color", "#d1d3e2");
    	$('#val_txtPlazoPlan').fadeOut(0);	
    }
    
    function volverAddAct(){
    	$('#frmAddAct').fadeOut(0);
    	$('#tblAct').fadeIn(100);
    	$('#btnAddAct').html('Agregar Actividad');
    	$('#btnAddAct').attr('onclick', 'addAct()');
    	actualizaTablaAct();
    }
    
    function editPlanEstrategico(){
    	var idProb = $('#idProb').val();
    	var idPlan = $('#idPlan').val();
    	var Objetivo = $('#txt_plan_objetivo').val();    	
    	var Resultado = $('#txt_plan_resultados').val();
    	var Indicador = $('#txt_plan_indicador').val();
    	var error = 0;
    	if(Objetivo == ''){
    		$("#txt_plan_objetivo").css("border-color", "#ff0000"); 
    		$('#val_txt_plan_objetivo').fadeIn(200);
    		error = 1;
    	}else{
    		$("#txt_plan_objetivo").css("border-color", "#d1d3e2");
    		$('#val_txt_plan_objetivo').fadeOut(200);
    	}    	
    	if(Resultado == ''){
    		$("#txt_plan_resultados").css("border-color", "#ff0000");
    		$('#val_txt_plan_resultados').fadeIn(200); 
    		error = 1;
    	}else{
    		$("#txt_plan_resultados").css("border-color", "#d1d3e2");
    		$('#val_txt_plan_resultados').fadeOut(200); 
    	}
    	if(Indicador == ''){
    		$("#txt_plan_indicador").css("border-color", "#ff0000");
    		$('#val_txt_plan_indicador').fadeIn(200); 
    		error = 1;
    	}else{
    		$("#txt_plan_indicador").css("border-color", "#d1d3e2");
    		$('#val_txt_plan_indicador').fadeOut(200); 
    	}    	
    	if(error == 0){
    		bloquearPantalla();
    		let data = new Object();
    		data.idProb = idProb;
    		data.idPlan = idPlan;
			data.Objetivo = Objetivo;
			data.Resultado = Resultado;
			data.Indicador = Indicador;
		  	$.ajax({
    			type: "GET",
    			url: "{{route('edit.plan.estrategico')}}",
    			data: data
    		}).done(function(resp){
    			mensajeTemporalRespuestas(1, 'Se ha guardado el Plan Estrategico Comunitario.');					  
    			$('#PlanModal').modal('hide');
    			desplegarPlanEstCom();	
    			desbloquearPantalla();
    		}).fail(function(objeto, tipoError, errorHttp){
    			desbloquearPantalla();
                manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
                return false;
            });
    	}
    }
    
    function guardarPlanEstrategico(){
    	bloquearPantalla();
    	var idProb = $('#idProb').val();
    	var Objetivo = $('#txt_plan_objetivo').val();
    	var Resultado = $('#txt_plan_resultados').val();
    	var Indicador = $('#txt_plan_indicador').val();
    	var error = 0;
    	if(Objetivo == ''){
    		$("#txt_plan_objetivo").css("border-color", "#ff0000"); 
    		$('#val_txt_plan_objetivo').fadeIn(200);
    		error = 1;
    	}else{
    		$("#txt_plan_objetivo").css("border-color", "#d1d3e2");
    		$('#val_txt_plan_objetivo').fadeOut(200);
    	}
    	if(Resultado == ''){
    		$("#txt_plan_resultados").css("border-color", "#ff0000");
    		$('#val_txt_plan_resultados').fadeIn(200); 
    		error = 1;
    	}else{
    		$("#txt_plan_resultados").css("border-color", "#d1d3e2");
    		$('#val_txt_plan_resultados').fadeOut(200); 
    	}
    	if(Indicador == ''){
    		$("#txt_plan_indicador").css("border-color", "#ff0000");
    		$('#val_txt_plan_indicador').fadeIn(200); 
    		error = 1;
    	}else{
    		$("#txt_plan_indicador").css("border-color", "#d1d3e2");
    		$('#val_txt_plan_indicador').fadeOut(200); 
    	}
    	if(error == 0){
    		let data = new Object();
    		data.idProb = idProb;
			data.Objetivo = Objetivo;
			data.Resultado = Resultado;
			data.Indicador = Indicador;
		  	$.ajax({
    			type: "GET",
    			url: "{{route('plan.estrategico')}}",
    			data: data
    		}).done(function(resp){
    			mensajeTemporalRespuestas(1, 'Se ha guardado el Plan Estrategico Comunitario.');					  
    			$('#PlanModal').modal('hide');
    			desplegarPlanEstCom();	    			
    			desbloquearPantalla();
    		}).fail(function(objeto, tipoError, errorHttp){
    				desbloquearPantalla();
                    manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
                    return false;
            });
    	}else{
    		desbloquearPantalla();
    	}
    }
</script>