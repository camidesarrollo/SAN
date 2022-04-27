@extends('layouts.main')
@section('contenido')
<!-- HIDDEN -->
<input type="hidden" name="pro_an_id" id="pro_an_id" value="{{ $pro_an_id }}">
<input type="hidden" name="est_pro_id" id="est_pro_id" value="{{ $est_pro_id }}">
<!-- INICIO DC -->
<input type="hidden" name="desestimado" id="desestimado" value="0">
<!-- HIDDEN -->
<style>
.isDisabled {
  cursor: not-allowed;
  opacity: 0.5;
  pointer-events: none;
}
</style>

<!-- FIN DC -->
	@if(Session::has('success'))
		<div class="container-fluid">
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>{{ Session::get('success') }}</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		</div>
	@endif
	@if(Session::has('danger'))
		<div class="container-fluid">
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>{{ Session::get('danger') }}</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		</div>
	@endif
	@if ($errors->any())
		<div class="container-fluid">
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		</div>
	@endif	

<div class="container-fluid">	
	<!-- MENU BOTON DESESTIMAR PROCESO  -->
	<div class="row">
		<div class="card shadow-sm p-1 w-100" >				
			@includeif('gestor_comunitario.gestion_comunitaria.desestimar_proceso')
		</div>
	</div>		
	<!-- FIN MENU BOTON DESESTIMAR PROCESO  -->

	<!-- MENU GESTION COMUNITARIA  -->
	<div class="row">
		<ul class="nav nav-pills mt-0 p-1 bg-white sticky-top menu_gestion" id="myTab" role="tablist">
			<li class="nav-item">
				<a class="nav-link h-100" id="bitacora-tab" data-toggle="tab" href="#bitacora-ges-com" role="tab" aria-controls="bitacora-ges-com" aria-selected="false" onclick="menuGestionProcesoDesplegar(0);">Bitácora</a>
			</li>
<!-- 			inicio ch -->
				<li class="nav-item">		
					<a class="nav-link h-100" id="historial-doc-tab" data-toggle="tab" href="#historial-ges-com" role="tab" aria-controls="historial-ges-com" aria-selected="false" onclick="menuGestionProcesoDesplegar(3);" >Historial <br>Documentos</a>
				</li>
<!-- 			fin ch -->
			@if ($tipo_gestion != 1)
				<li class="nav-item dpc">
					<a class="nav-link h-100" id="diagnostico-part-tab" data-toggle="tab" href="#diagnostico-ges-com" role="tab" aria-controls="diagnostico-ges-com" aria-selected="false" onclick="menuGestionProcesoDesplegar(1); colorCheck();" >Diagnóstico <br>Participativo</a>
				</li>
				<li class="nav-item pc">
					<a class="nav-link h-100s" id="plan-est-tab" data-toggle="tab" href="#plan-est-ges-com" role="tab" aria-controls="plan-est-ges-com" aria-selected="false" onclick="menuGestionProcesoDesplegar(2);colorCheck();">Plan <br>Estratégico</a>
				</li>
			@endif
		</ul>
	</div>
	<style>
		.menu_gestion{
			padding: 0px!important;
		}

		.menu_gestion li.dpc .active{
			/* background-color: #CF90B5 !important; */
			background-color: #F17C6B !important; 
		}

		.menu_gestion li.pc .active{
			/* background-color: #CF90B5 !important; */
			background-color: #F8A51B !important; 
		}
			/* .nav-pills .nav-link.active {
		background-color: rgba(0, 0, 0, 0.3) !important;
		color: #fff;
		} */
	</style>
	<!-- MENU GESTION COMUNITARIA  -->

	<!-- SUB MENU DIAGNOSTICO PARTICIPATIVO  -->
	@if(View::exists('gestor_comunitario.gestion_comunitaria.diagnostico_participativo.sub_menu_diagnostico'))
		@include('gestor_comunitario.gestion_comunitaria.diagnostico_participativo.sub_menu_diagnostico')
		@include('gestor_comunitario.gestion_comunitaria.plan_estrategico.sub_menu_plan_estrategico')
	@endif
	<!-- SUB MENU DIAGNOSTICO PLAN ESTRATEGICO  -->
	@if(View::exists('gestor_comunitario.gestion_comunitaria.plan_estrategico.sub_menu_plan_estrategico'))
    	@include('gestor_comunitario.gestion_comunitaria.plan_estrategico.sub_menu_plan_estrategico')

	@endif
		
	<!-- SUB MENU PLAN ESTRATEGICO COMUNITARIO  -->

	
	

	<!-- VENTANAS GESTION COMUNITARIA -->
	<div class="row">
		<div class="card shadow-sm p-4 w-100">
			<!-- TITULO -->
			<nav aria-label="breadcrumb">
			<ol class="breadcrumb shadow-sm" style="padding: 5px 10px 5px 10px; font-size: 16px; 	background-color: #e6f3fd;">
				<li class="breadcrumb-item"><b>{{ $menu }}</b></li>
				<!-- inicio ch -->
				<li class="breadcrumb-item">{{ $nombre_proceso.' '.$año_proceso }}</li>
				<!-- fin ch -->
				<li class="breadcrumb-item" aria-current="page"><label id="current_name">Resumen Bitácora</label></li>
			</ol>
			</nav>
			<!-- TITULO -->

			<div class="tab-content" id="myTabContent">
				<!-- BITACORA -->
				<div class="tab-pane fade" id="bitacora-ges-com" role="tabpanel" aria-labelledby="bitacora-tab">
					<!--<div class="card p-2 mb-3"> -->
						@includeif('gestor_comunitario.gestion_comunitaria.bitacora')
					<!-- </div> -->
				</div>
				<!-- BITACORA -->

				<!-- HISTORIAL DOCUMENTOS inicio ch-->
				<div class="tab-pane fade" id="historial-ges-com" role="tabpanel" aria-labelledby="historial-part-tab">
					@includeif('gestor_comunitario.gestion_comunitaria.historial_documentos.historial_doc')
				</div>
				<!-- HISTORIAL DOCUMENTOS fin ch-->

				<!-- PLAN ESTRATÉGICO -->
				<div class="tab-pane fade" id="plan-est-ges-com" role="tabpanel" aria-labelledby="plan-est-tab">
					@includeif('gestor_comunitario.gestion_comunitaria.plan_estrategico.plan_estrategico_comunitario')
                    
				</div>
				<!-- PLAN ESTRATÉGICO -->

				<!-- DIAGNOSTICO PARTICIPATIVO -->
				<div class="tab-pane fade" id="diagnostico-ges-com" role="tabpanel" aria-labelledby="diagnostico-part-tab">
					@includeif('gestor_comunitario.gestion_comunitaria.diagnostico_participativo.diagnostico_participativo')
				</div>
				<!-- DIAGNOSTICO PARTICIPATIVO -->


				
			</div>	
		</div>	
	</div>
	<!-- VENTANAS GESTION COMUNITARIA -->	
</div>

@endsection

<style type="text/css">
    .des-hab-est{
        color: currentColor;
        cursor: not-allowed;
        opacity: 0.5;
        pointer-events: none;
    }
</style>
@section('script')
<script type="text/javascript">
	$(document).ready(function(){

		$('#bitacora-tab').click();

		menuGestionProcesoDesplegar(0);

		 $("#adj_doc1").submit(function(e){      
            e.preventDefault();
        });

        $("#adj_doc2").submit(function(e){
            e.preventDefault();
        });

        $("#adj_doc3").submit(function(e){  
            e.preventDefault();
        });

        $("#adj_doc4").submit(function(e){
            e.preventDefault();
        });
        //INICIO DC
        obtienePlazo();
        if('{{ Session::get('perfil') }}' == 2 || '{{ Session::get('perfil') }}' == 10 ){
        	$('#doc_actas').attr('disabled', 'disabled');
        	$('.btnAgregarLB').attr('disabled', 'disabled');
        	$('.btnAddIdeProb').attr('disabled', 'disabled');
        	$('.btnEtapa').attr('disabled', 'disabled');
        	$('.btnAddMatPri').attr('disabled', 'disabled');
        	$('#info_gestor').attr('disabled', 'disabled');
        	$('#fec_primer_contacto').attr('disabled', 'disabled');
        	$('#fec_termino_dpc').attr('disabled', 'disabled');
        	$('.presentacion_informe').attr('disabled', 'disabled');
        	$('#intro_vinculacion').attr('disabled', 'disabled');
        	$('#grupo_conf').attr('disabled', 'disabled');
        	$('.btnAddGA').attr('disabled', 'disabled');
        	$('#grupo_plan').attr('disabled', 'disabled');
        	$('.btnAddEjecucion').attr('disabled', 'disabled');
        	$('.info_resultado').attr('disabled', 'disabled');
        	$('.info_con_recomendaciones').attr('disabled', 'disabled');
        	$('#doc_anexoDiag').attr('disabled', 'disabled');
        	$('.form-control').attr('disabled', 'disabled');
        	$('.form-check-input').attr('disabled', 'disabled');
        	$('.btn_lb_guardar').attr('disabled', 'disabled');
        	$('#btn-etapa-linea-salida').attr('disabled', 'disabled');
        	$('.custom-file-input').attr('disabled', 'disabled');
        }
        //FIN DC
	});
	//INICIO DC
	function verificaEstadoPlazo(estadoClick){
		bloquearPantalla();
		let data = new Object();
		data.pro_an_id 	= $("#pro_an_id").val();
		$.ajax({
            type: "GET",
            url: "{{route('get.estado')}}",
            data: data
        }).done(function(resp){
        	desbloquearPantalla();
            var estadoActual = JSON.parse(resp);
            if(estadoActual[0].est_pro_id == 4){ //Desestimado
            	$('.fechaPlazo').fadeOut(0);
            }else if(estadoActual[0].est_pro_id == 3){ //Finalizado
            	$('.fechaPlazo').fadeOut(0);
            }else{
            	if(estadoActual[0].est_pro_id == estadoClick){
                	if(estadoClick == 5){ //Documentos
						$('.fechaPlazo').fadeOut(0);
					}else if(estadoClick == 3){ //Finalizado
						$('.fechaPlazo').fadeOut(0);
					}else{
                	$('.fechaPlazo').fadeIn(0);
					}  
                }else{
                	$('.fechaPlazo').fadeOut(0);
                }
            }
        
        }).fail(function(objeto, tipoError, errorHttp){  
           desbloquearPantalla();
           manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
           return false;
	});
	}
	function obtienePlazo(){
		let data = new Object();
		data.pro_an_id 	= $("#pro_an_id").val();
		data.tipo = 3;
		$.ajax({
            type: "GET",
            url: "{{route('get.plazo')}}",
            data: data
        }).done(function(resp){
            var plazo = JSON.parse(resp);
            if(plazo.plazo != null){
            	$('.txtPlazo').html(plazo.plazo);
            }            
        }).fail(function(objeto, tipoError, errorHttp){  
           desbloquearPantalla();
           manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
           return false;
        });
	}
	//FIN DC
	function menuGestionProcesoDesplegar(opcion){
		//INICIO DC
    	if({{ $est_pro_id }} == 4){
    		$('#desestimado').val(1);
    	}
    	//FIN DC
		switch(opcion){
			case 1: //DIAGNOSTICO PARTICIPATIVO
				$("#current_name").text("Diagnóstico Participativo");
				
				$("#diag_part_sub").show();

				$("#diag_part_sub2").hide();
				// INICIO CZ SPRINT 67
				desplegarGestionComunitaria(parseInt($("#est_pro_id").val()), true);
				// FIN CZ SPRINT 67
				$('#plan-est-com-tab').fadeOut(0);
				$('#linea-salida-tab').fadeOut(0);
				$('#inf-plan-est-tab').fadeOut(0);
				//INICIO DC
				if('{{ Session::get('perfil') }}' == 2){
                   	$('.btnEtapa').attr('disabled', 'disabled');
                   	$('.btnIdeProbFR').attr('disabled', 'disabled');
                }
                //FIN DC
			break;

			case 2: //PLAN ESTRATÉGICO
				validaActividades();
				$("#current_name").text("Plan Estratégico");
				$("#diag_part_sub2").show();

				$("#diag_part_sub").hide();
				
				$('#plan-est-com-tab').fadeIn(0);
				$('#linea-salida-tab').fadeIn(0);
				$('#inf-plan-est-tab').fadeIn(0);
				
				desplegarPlanEstrategico({{ $est_pro_id }}, true);
						
			break;

			case 3: //HISTORIAL DOCUMENTOS inicio ch
				desplegarSeccionBitacora(3);
				$("#diag_part_sub").hide();
				$("#diag_part_sub2").hide();
				$("#current_name").text("Historial Documentos");
				$('#plan-est-com-tab').fadeOut(0);
				$('#linea-salida-tab').fadeOut(0);
				$('#inf-plan-est-tab').fadeOut(0);
			break;
			// fin ch
			case 0:
			default: //BITACORA
				desplegarSeccionBitacora(1);
				$("#diag_part_sub").hide();
				$("#diag_part_sub2").hide();
				$("#current_name").text("Resumen Bitácora");
				$('#plan-est-com-tab').fadeOut(0);
				$('#linea-salida-tab').fadeOut(0);
				$('#inf-plan-est-tab').fadeOut(0);
		}
	}

	contenido_textarea_rechazo_estados = ""; 
	function valTextAreaCambioEstadoRechazo(){
		num_caracteres_permitidos   = 255;

		num_caracteres = $("#comentario_estado").val().length;

		if (num_caracteres > num_caracteres_permitidos){ 
				$("#comentario_estado").val(contenido_textarea_rechazo_estados);

		}else{ 
			contenido_textarea_rechazo_estados = $("#comentario_estado").val(); 

		}

		if (num_caracteres >= num_caracteres_permitidos){ 
			$("#cant_carac_cam_est").css("color", "#ff0000"); 

		}else{ 
			$("#cant_carac_cam_est").css("color", "#000000");

		} 

		
		$("#cant_carac_cam_est").text($("#comentario_estado").val().length);
	}

	function desestimarProceso(){

		let comentario 	= $("#comentario_estado").val().trim();
		let opcion    	= $("#desestimar_proceso").val();
		let pro_an_id 	= $("#pro_an_id").val();
		let validacion 	= true;

		//Validación caja de comentario
		if (comentario === "" || comentario.length < 3 || typeof comentario == "undefined"){
			$("#val_msg_com").show();
			$("#comentario_estado").addClass("is-invalid");
			validacion = false;
		}else{
			$("#val_msg_com").hide();
			$("#comentario_estado").removeClass("is-invalid");
		}

		//Validación rechazado por
			if (typeof opcion == "undefined" || opcion == ""){
				$("#val_msg_rec").show();
				$("#desestimar_proceso").addClass("is-invalid");
				validacion = false;
			}else{
				$("#val_msg_rec").hide();
				$("#desestimar_proceso").removeClass("is-invalid");
			}

		if (validacion == false) return false;

		let confirmacion = confirm("¿Esta seguro que desea desestimar el proceso?");
		
		if (confirmacion == false) return false;

		cambioEstadoProceso(opcion, pro_an_id, comentario);

	}

	function limpiarModalMsgEstadosProceso(){
		$("#cambiar_estado").show();
		$("#contenedor_comentario_estado").show();
		$("#contenedor_desestimar_proceso").show();
		$("#msg_cambioEstado_body").hide();

		$("#val_msg_com").hide();
		$("#comentario_estado").removeClass("is-invalid");
		$("#comentario_estado").val("");

		$("#val_msg_rec").hide();
		$("#desestimar_proceso").removeClass("is-invalid");
		document.getElementById("desestimar_proceso").value = '';

		$("#cant_carac_cam_est").css("color", "#000000");
		$("#cant_carac_cam_est").text(0);
	}

	function cambioEstadoProceso(opcion, pro_an_id, comentario){
		
		let data = new Object();

		data.pro_an_id 	= pro_an_id;
		data.opcion		= opcion;
		data.comentario = comentario;
		
		$.ajax({
			type: "GET",
			url: "{{ route('cambio.estado.proceso') }}",
			data: data
		}).done(function(resp){
			let html= resp.mensaje;
			if(resp.estado == 1){
				limpiarModalMsgEstadosProceso();
				$("#cambiar_estado").hide();
				$("#contenedor_comentario_estado").hide();
				$("#contenedor_desestimar_proceso").hide();
				$("#btn_desestimar").hide();

				$("#msg_cambioEstado_body").html(html);
				$("#msg_cambioEstado_body").show();
				$('#frmDesestimarProceso').modal('show');
				
			}
			
		}).fail(function(obj){
			let html = "Error al momento de realizar la actualización del estado del proceso. Por favor intente nuevamente.";
		
			console.log(obj);
			$("#cambiar_estado").hide();
			$("#contenedor_comentario_estado").hide();
			$("#contenedor_desestimar_proceso").hide();

			$("#msg_cambioEstado_body").html(html);
			$("#msg_cambioEstado_body").show();
			$('#frmDesestimarProceso').modal('show');
		});

	}

	function cambiarEstadoGestorComunitario(estado_actual){
        bloquearPantalla();
		$("#modal_priorizacion").modal('hide');
        let data = new Object();
        data.estado_actual = $("#est_pro_id").val();
        data.pro_an_id = $("#pro_an_id").val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "GET",
            url: "{{ route('gestor.comunitario.cambio.estado') }}",
            data: data
        }).done(function(resp){
            console.log(resp);
            desbloquearPantalla();
            
            if(resp.estado == 1){
                mensajeTemporalRespuestas(1, resp.mensaje);
                $("#est_pro_id").val(resp.est_pro_id);
				$("#nombre_estado_proceso").html(resp.est_pro_nom);
                //INICIO DC
				obtienePlazo();
				//FIN DC
                siguienteEtapaGestionComunitaria(resp.est_pro_id);               
				cambiarColorCheck(resp.est_pro_id);  
            }else if (resp.estado == 0){
                mensajeTemporalRespuestas(0, resp.mensaje);

            }
        }).fail(function(objeto, tipoError, errorHttp){
            desbloquearPantalla();

            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

            return false;
        });
    }
    var existeAct = [];
    function cambiarEstadoPlanEstrategico(){
        bloquearPantalla();

        let data = new Object();
        data.estado_actual = $("#est_pro_id").val();
        data.pro_an_id = $("#pro_an_id").val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
		if($("#est_pro_id").val() == 2){
			let data2 = new Object();
			data2.pro_an_id = {{$pro_an_id}};

        $.ajax({
            type: "GET",
                url: "{{route('valida.objetivos')}}",
                data: data2
            }).done(function(resp){
               var datos = JSON.parse(resp);
               if(datos.length > 0){  
               		var error = 0;
               		for (var i = 0; i < datos.length; i+=1) {
               			if(datos[i].existe == 0){
               				error = 1;
               			}
               		}
               		if(error == 1){
               			mensajeTemporalRespuestas(0, 'Error: Faltan Objetivos.');
               			desbloquearPantalla();
               		}else{
               			validaActividades();
               			$.ajax({
                            type: "GET",
            url: "{{ route('gestor.comunitario.cambio.estado') }}",
            data: data
        }).done(function(resp){
            desbloquearPantalla();
            if(resp.estado == 1){
                mensajeTemporalRespuestas(1, resp.mensaje);
                $("#est_pro_id").val(resp.est_pro_id);
                                verificaEstadoPlanEstrategico();             
                                //INICIO DC    
                                obtienePlazo(); 
                                //FIN DC        
                            }else if (resp.estado == 0){
                                mensajeTemporalRespuestas(0, resp.mensaje);
                            }
                        }).fail(function(objeto, tipoError, errorHttp){
                            desbloquearPantalla();
                            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
                            return false;
                        });
               		}
               }
            }).fail(function(objeto, tipoError, errorHttp){
    
                desbloquearPantalla();
                manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
                return false;
    
            });
		}else{
			$.ajax({
                type: "GET",
                url: "{{ route('gestor.comunitario.cambio.estado') }}",
                data: data
            }).done(function(resp){
                desbloquearPantalla();
                
                if(resp.estado == 1){
                    mensajeTemporalRespuestas(1, resp.mensaje);
                    $("#est_pro_id").val(resp.est_pro_id);
                    //INICIO DC
    				obtienePlazo();
    				//FIN DC
                    verificaEstadoPlanEstrategico();             
            }else if (resp.estado == 0){
                mensajeTemporalRespuestas(0, resp.mensaje);

            }
        }).fail(function(objeto, tipoError, errorHttp){
            desbloquearPantalla();

            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

            return false;
        });
    }


    }

	function desplegarPlanEstrategico(estado, inicial = false){
	/*
		//Tab Plan Estrategico Comunitario
        $("#plan-est-tab").removeClass("des-hab-est");       	
        $("#plan-est-tab").click();
        $("#plan-est-tab").focus();
        $("#plan-est-tab").addClass("active");
        $("#plan-est-tab").attr("onclick", "desplegarPlanEstrategico2({{config('constantes.identificacion_comunidad')}}, false);");
        
        //Tab Linea de Salida
        $("#linea-salida-tab").removeClass("des-hab-est");       	
        $("#linea-salida-tab").click();
        $("#linea-salida-tab").focus();
        $("#linea-salida-tab").addClass("active");
        $("#linea-salida-tab").attr("onclick", "desplegarPlanEstrategico2({{config('constantes.identificacion_comunidad')}}, false);");
        
        //Tab Informe Plan Estrategico Comunitario
        $("#inf-plan-est-tab").removeClass("des-hab-est");       	
        $("#inf-plan-est-tab").click();
        $("#inf-plan-est-tab").focus();
        $("#inf-plan-est-tab").addClass("active");
        $("#inf-plan-est-tab").attr("onclick", "desplegarPlanEstrategico2({{config('constantes.identificacion_comunidad')}}, false);");
       */
		// INICIO CZ SPRINT 67 correcion
		$("#plan_estrategico").css("display","flex");
		// FIN CZ SPRINT 67
       $("#plan-est-com-tab").removeClass("des-hab-est");
       $("#plan-est-com-tab").attr("onclick", "desplegarPlanEstCom();");
       
       $("#linea-salida-tab").removeClass("des-hab-est"); 
       $("#linea-salida-tab").attr("onclick", "desplegarLineaSalida();");
         
       $("#inf-plan-est-tab").removeClass("des-hab-est"); 
       $("#inf-plan-est-tab").attr("onclick", "desplegarInfPlanEst();");
       
       //verifica estado
       verificaEstadoPlanEstrategico();
       
       tblPlanEstrategicoCom();
       
       tblEjecucionPec();
       
       desplegarAnexos();
       
       
	}
	
	function verificaEstadoPlanEstrategico(){
		bloquearPantalla();
		let data = new Object();
		data.pro_an_id = {{$pro_an_id}};
		$.ajax({
        	type: "GET",
            url: "{{route('verifica.estado.pec')}}",
            data: data
       }).done(function(resp){
            var datos = JSON.parse(resp);
            if(datos[0].est_pro_id == 2){ //plan estrategico comunitario
            	$('#linea-salida-tab').addClass('des-hab-est');
            	$('#inf-plan-est-tab').addClass('des-hab-est');
            	$('#plan-est-com-tab').removeClass('des-hab-est');
            	$('#plan-est-com-tab').addClass('active');
            	$('#linea-salida-tab').removeClass('active');
            	$('#inf-plan-est-tab').removeClass('active');
            	desplegarPlanEstCom();
            	$('#btn-etapa-plan-estrategico').removeAttr('disabled');
				
				$("#ident_com-tab-ico").removeClass('text-light');
				$("#ident_com-tab-ico").addClass('icon-success');
				$("#document-tab-ico").removeClass('text-light');
				$("#document-tab-ico").addClass('icon-success');
				$("#lineBase-tab-ico").removeClass('text-light');
				$("#lineBase-tab-ico").addClass('icon-success');
				$("#matrizIdenPro-tab-ico").removeClass('text-light');
				$("#matrizIdenPro-tab-ico").addClass('icon-success');
				$("#matrizPrioPro-tab-ico").removeClass('text-light');
				$("#matrizPrioPro-tab-ico").addClass('icon-success');
				$("#matrizFact-tab-ico").removeClass('text-light');
				$("#matrizFact-tab-ico").addClass('icon-success');
				$("#infodpc-tab-ico").removeClass('text-light');
				$("#infodpc-tab-ico").addClass('icon-success');
				$("#plan-est-tab-ico").removeClass('text-light');
				$("#plan-est-tab-ico").addClass('icon-success');
            
            }else if(datos[0].est_pro_id == 11){ //linea salida
            	$('#inf-plan-est-tab').addClass('des-hab-est');
            	$('#plan-est-com-tab').removeClass('des-hab-est');
            	$('#linea-salida-tab').removeClass('des-hab-est');
            	$('#linea-salida-tab').addClass('active');
            	$('#plan-est-com-tab').removeClass('active');
            	$('#inf-plan-est-tab').removeClass('active');
            	desplegarLineaSalida();
            	$('#btn-etapa-linea-salida').removeAttr('disabled');
            	$('#btn-etapa-plan-estrategico').attr('disabled', 'disabled');
				console.log("realizando cambio display boton");
				$(".btn_lb_guardar").css("display","initial");

				$("#ident_com-tab-ico").removeClass('text-light');
				$("#ident_com-tab-ico").addClass('icon-success');
				$("#document-tab-ico").removeClass('text-light');
				$("#document-tab-ico").addClass('icon-success');
				$("#lineBase-tab-ico").removeClass('text-light');
				$("#lineBase-tab-ico").addClass('icon-success');
				$("#matrizIdenPro-tab-ico").removeClass('text-light');
				$("#matrizIdenPro-tab-ico").addClass('icon-success');
				$("#matrizPrioPro-tab-ico").removeClass('text-light');
				$("#matrizPrioPro-tab-ico").addClass('icon-success');
				$("#matrizFact-tab-ico").removeClass('text-light');
				$("#matrizFact-tab-ico").addClass('icon-success');
				$("#infodpc-tab-ico").removeClass('text-light');
				$("#infodpc-tab-ico").addClass('icon-success');
				$("#plan-est-tab-ico").removeClass('text-light');
				$("#plan-est-tab-ico").addClass('icon-success');
				$("#line-salid-tab-ico").removeClass('text-light');
				$("#line-salid-tab-ico").addClass('icon-success');


            }else if(datos[0].est_pro_id == 12){ //informe pec
            	$('#inf-plan-est-tab').removeClass('des-hab-est');
            	$('#plan-est-com-tab').removeClass('des-hab-est');
            	$('#linea-salida-tab').removeClass('des-hab-est');
            	$('#inf-plan-est-tab').addClass('active');
            	$('#plan-est-com-tab').removeClass('active');
            	$('#linea-salida-tab').removeClass('active');
            	desplegarInfPlanEst();
            	$('#btn-etapa-linea-salida').attr('disabled', 'disabled');
            	$('#btn-etapa-plan-estrategico').attr('disabled', 'disabled');

				$("#ident_com-tab-ico").removeClass('text-light');
				$("#ident_com-tab-ico").addClass('icon-success');
				$("#document-tab-ico").removeClass('text-light');
				$("#document-tab-ico").addClass('icon-success');
				$("#lineBase-tab-ico").removeClass('text-light');
				$("#lineBase-tab-ico").addClass('icon-success');
				$("#matrizIdenPro-tab-ico").removeClass('text-light');
				$("#matrizIdenPro-tab-ico").addClass('icon-success');
				$("#matrizPrioPro-tab-ico").removeClass('text-light');
				$("#matrizPrioPro-tab-ico").addClass('icon-success');
				$("#matrizFact-tab-ico").removeClass('text-light');
				$("#matrizFact-tab-ico").addClass('icon-success');
				$("#infodpc-tab-ico").removeClass('text-light');
				$("#infodpc-tab-ico").addClass('icon-success');
				$("#plan-est-tab-ico").removeClass('text-light');
				$("#plan-est-tab-ico").addClass('icon-success');
				$("#line-salid-tab-ico").removeClass('text-light');
				$("#line-salid-tab-ico").addClass('icon-success');
				$("#info-pec-tab-ico").removeClass('text-light');
				$("#info-pec-tab-ico").addClass('icon-success');

            //INICIO DC
            }else if(datos[0].est_pro_id == 4){ //desestimado
            	$('#inf-plan-est-tab').removeClass('des-hab-est');
            	$('#plan-est-com-tab').removeClass('des-hab-est');
            	$('#linea-salida-tab').removeClass('des-hab-est');
            	$('#inf-plan-est-tab').addClass('active');
            	$('#plan-est-com-tab').removeClass('active');
            	$('#linea-salida-tab').removeClass('active');
            	desplegarInfPlanEst();
            	$('#btn-etapa-linea-salida').attr('disabled', 'disabled');
            	$('#btn-etapa-plan-estrategico').attr('disabled', 'disabled');
            	$('input').attr('disabled', 'disabled');
            	$('textarea').attr('disabled', 'disabled');
            }else if(datos[0].est_pro_id == 3){ //finalizado
            	$('#inf-plan-est-tab').removeClass('des-hab-est');
            	$('#plan-est-com-tab').removeClass('des-hab-est');
            	$('#linea-salida-tab').removeClass('des-hab-est');
            	$('#inf-plan-est-tab').addClass('active');
            	$('#plan-est-com-tab').removeClass('active');
            	$('#linea-salida-tab').removeClass('active');
            	desplegarInfPlanEst();
            	$('#btn-etapa-linea-salida').attr('disabled', 'disabled');
            	$('#btn-etapa-plan-estrategico').attr('disabled', 'disabled');
            	$('input').attr('disabled', 'disabled');
            	$('textarea').attr('disabled', 'disabled');
            //FIN DC
            }else{
            	$('#inf-plan-est-tab').addClass('des-hab-est');
            	$('#plan-est-com-tab').addClass('des-hab-est');
            	$('#linea-salida-tab').addClass('des-hab-est');
            	$('#contenedor_listar_informe').fadeOut(0);
            	$('#contenedor_introduccionInf').fadeOut(0);
            	$('#contenedor_eje_plan_est_comInf').fadeOut(0);
            	$('#contenedor_resultadosInf').fadeOut(0);
            	$('#contenedor_conclusiones_recomendacionesInf').fadeOut(0);
            	$('#contenedor_anexosInf').fadeOut(0);
            	$('#contenedor_listar_plan').fadeOut(0);
            	$('#contenedor_listar_linea').fadeOut(0);
				$('#contenedor_encuesta_prercepcion').fadeOut(0);
            }
            $("#est_pro_id").val(datos[0].est_pro_id);
            //INICIO DC
            if('{{ Session::get('perfil') }}' == 2){
               	$('.btnEtapa').attr('disabled', 'disabled');
            }
            //FIN DC
			desbloquearPantalla(); 
       }).fail(function(objeto, tipoError, errorHttp){
       		desbloquearPantalla();
            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
            return false;
    
       });
       
	}
	
	function desplegarLineaSalida(){
		//INICIO DC
		verificaEstadoPlazo(11);
		$('#contenedor_matriz_factores').fadeOut(0);
		$('#contenedor_carta_compromiso').fadeOut(0);
		$('#contenedor_acta_constitucion').fadeOut(0);
		$('#contenedor_acta_reunion').fadeOut(0);
		$('#contenedor_acta_reunion_asamblea').fadeOut(0);
		$('#contenedor_identificacion_com_pri').fadeOut(0);
		$('#contenedor_organizaciones_fun_com').fadeOut(0);
		$('#contenedor_instituciones_serv').fadeOut(0);
		$('#contenedor_bienes_com_com').fadeOut(0);
		$('#contenedor_factores_rie_factores_pro').fadeOut(0);
		$("#descInfPEC").css("display", "none");
		setTimeout(function(){ 
            $("#descInfPEC").css("display", "none");
        }, 1000);
		
		//INICIO CZ SPRINT 56
		$("#msj_error_descInfPEC").css("display", "none");
		setTimeout(function(){ 
            $("#msj_error_descInfPEC").css("display", "none");
        }, 1000);
		// FIN CZ SPRINT 56
		$('#linea-ges-com').fadeOut(0);
		
		$('#contenedor_matriz_identificacion_problemas_ll').fadeOut(0);
		
		$('#contenedor_matriz_prg_1_').fadeOut(0);
		$('#contenedor_matriz_prg_2_').fadeOut(0);
		$('#contenedor_matriz_prg_3_').fadeOut(0);
		$('#contenedor_problemas_priorizados_MRE_').fadeOut(0);
		$('#diagnostico-ges-com button').fadeOut(0);
		
		$('#contenedor_info_identificacion').fadeOut(0);
		$('#contenedor_info_introduccion').fadeOut(0);
		$('#contenedor_info_gurpo_accion').fadeOut(0);
		$('#contenedor_info_ejec_diag_part').fadeOut(0);
		$('#contenedor_info_resultados').fadeOut(0);
		$('#contenedor_info_conclusiones').fadeOut(0);
		$('#contenedor_info_anexos').fadeOut(0);
	
		$('#contenedor_listar_informe').fadeOut(0);
		$('#listar_informe').fadeOut(0);
		
		$('#contenedor_listar_plan').fadeOut(0);
		$('#listar_plan').fadeOut(0);
		
		$('#contenedor_listar_linea').fadeIn(0);
		$('#listar_linea').fadeIn(0);
		$('#contenedor_encuesta_prercepcion').fadeIn(0);
		
		$('#contenedor_introduccionInf').fadeOut(0);
		
		$('#contenedor_eje_plan_est_comInf').fadeOut(0);
		
		$('#contenedor_resultadosInf').fadeOut(0);
		
		$('#contenedor_conclusiones_recomendacionesInf').fadeOut(0);
		
		$('#contenedor_anexosInf').fadeOut(0);
		// INICIO CZ SPRINT 56 
		$('#finPEC').fadeOut(0);
		// FIN CZ SPRINT 56
		$('#btnDescargarInf').fadeOut(0);
		// INICIO CZ SPRINT 70
		@if($flag_linea == 1)
		listarLineaSalida();
		@elseif ($flag_linea == 2)
		listarLineaSalida_2021();
		obtener_doc_percepcion();
		@endif
		// FIN CZ SPRINT 70
	}
	
	function tblPlanEstrategicoCom(){
		let data = new Object();
		data.pro_an_id = $("#pro_an_id").val();
		
		let tabla_alertas = $('#tbl_plan_estrategico').DataTable();
        tabla_alertas.clear().destroy();
        
        tabla_alertas = $('#tbl_plan_estrategico').DataTable({
            "language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
            "lengthChange": false,
			"info": 		false,
			"searching":	false,
			"paging":		false,
            "ajax": {
                "url": "{{ route('get.plan.estrategico') }}",
                "type": "GET",
                "data": data
            },
 				"columnDefs": [
 					{ //prob_priorizado
						"targets": 0,
						"className": 'dt-head-center dt-body-center',
						"visible": false,
						"createdCell": function (td, cellData, rowData, row, col) {
							$(td).css("vertical-align", "middle");
						
						}
					},
            		{ //prob_priorizado
						"targets": 1,
						"className": 'dt-head-center dt-body-center',
						"createdCell": function (td, cellData, rowData, row, col) {
							$(td).css("vertical-align", "middle");
						
						}
					},
            		{ //objetivo
						"targets": 2,
						"className": 'dt-head-center dt-body-center',
						"createdCell": function (td, cellData, rowData, row, col) {
							$(td).css("vertical-align", "middle");
						
						}
					},
            		{ //actividad
						"targets": 3,
						"className": 'dt-head-center dt-body-center',
						"createdCell": function (td, cellData, rowData, row, col) {
							$(td).css("vertical-align", "middle");
						
						}
					},
            		{ //estrategia
						"targets": 4,
						"className": 'dt-head-center dt-body-center',
						"createdCell": function (td, cellData, rowData, row, col) {
							$(td).css("vertical-align", "middle");
						
						}
					},
            		{ //metodologia
						"targets": 5,
						"className": 'dt-head-center dt-body-center',
						"createdCell": function (td, cellData, rowData, row, col) {
							$(td).css("vertical-align", "middle");
						
						}
                                      //Inicio Andres Sprint 57
					},
					{ //num actividades
						"targets": 6,
						"className": 'dt-head-center dt-body-center',
						"createdCell": function (td, cellData, rowData, row, col) {
							$(td).css("vertical-align", "middle");
						
						}
                                      
					}
        		],				
				"columns": [
					{ "data": "idprob", "className": "text-left" },
					{ "data": "prob_priorizado", "className": "text-left" },
					{ "data": "objetivo", "className": "text-left" },
					{ "data": "resultado", "className": "text-center" },
					{ "data": "indicador", "className": "text-center" },
					{ "data": "num_acti", "className": "text-center" },
					{
						"data"		: "idprob",
						"name"		: "idprob",
						"className"	: "text-center",
						"visible"	: true,
						"orderable"	: true,
						"searchable": true,
						"render" : function (data, type, row){
							return '<button type="button" class="btn btn-primary" onclick="editarPlanEstrategico('+data+', '+row.id+')">Editar Objetivo</button> <button type="button" class="btn btn-primary" onclick="editarActividades('+data+', '+row.id+')">Actividades</button>';
						}
					}				
                                     //Fin Andres Sprint 57				
					
				]
			});
	}
	
	function desplegarPlanEstCom(){
		//INICIO DC
		verificaEstadoPlazo(2);
		$('#contenedor_matriz_factores').fadeOut(0);
		$('#contenedor_carta_compromiso').fadeOut(0);
		$('#contenedor_acta_constitucion').fadeOut(0);
		$('#contenedor_acta_reunion').fadeOut(0);
		$('#contenedor_acta_reunion_asamblea').fadeOut(0);
		$('#contenedor_identificacion_com_pri').fadeOut(0);
		$('#contenedor_organizaciones_fun_com').fadeOut(0);
		$('#contenedor_instituciones_serv').fadeOut(0);
		$('#contenedor_bienes_com_com').fadeOut(0);
		$('#contenedor_factores_rie_factores_pro').fadeOut(0);
		$("#descInfPEC").css("display", "none");
		setTimeout(function(){ 
            $("#descInfPEC").css("display", "none");
        }, 1000);		
		//FIN DC
		
		//INICIO CZ SPRINT 56
		$("#msj_error_descInfPEC").css("display", "none");
		setTimeout(function(){ 
            $("#msj_error_descInfPEC").css("display", "none");
        }, 1000);
		// FIN CZ SPRINT 56

		// INICIO CZ SPRINT 57
		$("#finPEC").css("display", "none");
		setTimeout(function(){ 
            $("#finPEC").css("display", "none");
        }, 1000);
		//FIN CZ SPRINT 57  

		$('#linea-ges-com').fadeOut(0);
		
		$('#contenedor_matriz_identificacion_problemas_ll').fadeOut(0);
		
		$('#contenedor_matriz_prg_1_').fadeOut(0);
		$('#contenedor_matriz_prg_2_').fadeOut(0);
		$('#contenedor_matriz_prg_3_').fadeOut(0);
		$('#contenedor_problemas_priorizados_MRE_').fadeOut(0);
		$('#diagnostico-ges-com button').fadeOut(0);
		
		$('#contenedor_info_identificacion').fadeOut(0);
		$('#contenedor_info_introduccion').fadeOut(0);
		$('#contenedor_info_gurpo_accion').fadeOut(0);
		$('#contenedor_info_ejec_diag_part').fadeOut(0);
		$('#contenedor_info_resultados').fadeOut(0);
		$('#contenedor_info_conclusiones').fadeOut(0);
		$('#contenedor_info_anexos').fadeOut(0);
		
		
		$('#contenedor_listar_informe').fadeOut(0);
		$('#listar_informe').fadeOut(0);
		
		$('#contenedor_listar_linea').fadeOut(0);
		$('#listar_linea').fadeOut(0);
		$('#contenedor_encuesta_prercepcion').fadeOut(0);
		
		$('#contenedor_introduccionInf').fadeOut(0);
		
		$('#contenedor_eje_plan_est_comInf').fadeOut(0);
		
		$('#contenedor_resultadosInf').fadeOut(0);
		
		$('#contenedor_conclusiones_recomendacionesInf').fadeOut(0);
		
		$('#contenedor_anexosInf').fadeOut(0);
		
		$('#btnDescargarInf').fadeOut(0);
		
		$('#contenedor_listar_plan').fadeIn(0);
		$('#listar_plan').fadeIn(0);
		
		let data = new Object();
		data.pro_an_id = $("#pro_an_id").val();
		
		let tabla_alertas = $('#tbl_plan_estrategico').DataTable();
        $('#tbl_plan_estrategico').DataTable().ajax.reload();
        
        tabla_alertas = $('#tbl_plan_estrategico').DataTable({
            "language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
            "lengthChange": false,
			"info": 		false,
			"searching":	false,
			"paging":		false,
            "ajax": {
                "url": "{{ route('get.plan.estrategico') }}",
                "type": "GET",
                "data": data
            },
 				"columnDefs": [
 					{ //prob_priorizado
						"targets": 0,
						"className": 'dt-head-center dt-body-center',
						"visible": false,
						"createdCell": function (td, cellData, rowData, row, col) {
							$(td).css("vertical-align", "middle");
						
						}
					},
            		{ //prob_priorizado
						"targets": 1,
						"className": 'dt-head-center dt-body-center',
						"createdCell": function (td, cellData, rowData, row, col) {
							$(td).css("vertical-align", "middle");
						
						}
					},
            		{ //objetivo
						"targets": 2,
						"className": 'dt-head-center dt-body-center',
						"createdCell": function (td, cellData, rowData, row, col) {
							$(td).css("vertical-align", "middle");
						
						}
					},
            		{ //actividad
						"targets": 3,
						"className": 'dt-head-center dt-body-center',
						"createdCell": function (td, cellData, rowData, row, col) {
							$(td).css("vertical-align", "middle");
						
						}
					},
            		{ //estrategia
						"targets": 4,
						"className": 'dt-head-center dt-body-center',
						"createdCell": function (td, cellData, rowData, row, col) {
							$(td).css("vertical-align", "middle");
						
						}
					},
            		{ //metodologia
						"targets": 5,
						"className": 'dt-head-center dt-body-center',
						"createdCell": function (td, cellData, rowData, row, col) {
							$(td).css("vertical-align", "middle");
						
						}
					}
        		],				
				"columns": [
					{ "data": "idprob", "className": "text-left" },
					{ "data": "prob_priorizado", "className": "text-left" },
					{ "data": "objetivo", "className": "text-left" },
					{ "data": "resultado", "className": "text-center" },
					{ "data": "indicador", "className": "text-center" },
					{
						"data"		: "idprob",
						"name"		: "idprob",
						"className"	: "text-center",
						"visible"	: true,
						"orderable"	: true,
						"searchable": true,
						"render" : function (data, type, row){
							return '<button type="button" class="btn btn-primary" onclick="editarPlanEstrategico('+data+', '+row.id+')">Editar Objetivo</button> <button type="button" class="btn btn-primary" onclick="editarActividades('+data+', '+row.id+')">Actividades</button>';
						}
					}				
					
				]
			});
			obtener_doc_percepcion();	
	}
	
	function desplegarAnexos(){
    	//carga anexos
	    let data2 = new Object();
		data2.pro_an_id = $("#pro_an_id").val();
	    let tabla_anexos = $('#tbl_anexos').DataTable();
        tabla_anexos.clear().destroy();
        tabla_anexos = $('#tbl_anexos').DataTable({
            "language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
            "lengthChange": false,
			"info": 		false,
			"searching":	false,
			"paging":		false,
            "ajax": {
                "url": "{{ route('get.anexos.pec') }}",
                "type": "GET",
                "data": data2
            },
 				"columnDefs": [
 					{ //prob_priorizado
						"targets": 0,
						"className": 'dt-head-center dt-body-center',
						"createdCell": function (td, cellData, rowData, row, col) {
							$(td).css("vertical-align", "middle");
						
						}
					},
            		{ //prob_priorizado
						"targets": 1,
						"className": 'dt-head-center dt-body-center',
						"createdCell": function (td, cellData, rowData, row, col) {
							$(td).css("vertical-align", "middle");
						
						}
					},
            		{ //objetivo
						"targets": 2,
						"className": 'dt-head-center dt-body-center',
						"createdCell": function (td, cellData, rowData, row, col) {
							$(td).css("vertical-align", "middle");
						
						}
					},
					{ //objetivo
						"targets": 3,
						"className": 'dt-head-center dt-body-center',
						"createdCell": function (td, cellData, rowData, row, col) {
							$(td).css("vertical-align", "middle");
						
						}
					}
        		],				
				"columns": [
					{ "data": "doc_nom", "className": "text-left" },
					{ "data": "tip_nom", "className": "text-left" },
					{ "data": "usuario", "className": "text-left" },
					{
						"data"		: "idprob",
						"name"		: "idprob",
						"className"	: "text-center",
						"visible"	: true,
						"orderable"	: true,
						"searchable": true,
						"render" : function (data, type, row){
							//INICIO CZ SPRINT 67 correccion
							let html ='';
							   if($("#est_pro_id").val() == {{ config('constantes.finalizado') }} || $("#est_pro_id").val() == {{ config('constantes.desestimado') }} ){
									// html ='<button type="button" class="btn btn-primary" onclick="descArchivoPec('+row.doc_gc_id+', \''+row.doc_nom+'\')">Descargar</button><button type="button" class="btn btn-danger" disabled="disabled" onclick="eliminarDocPec('+row.doc_gc_id+')" data-toggle="modal" data-target="#eliminarAnexoPec">Eliminar</button>';
									html = `<a download href="${row.ruta}"><button type="button" class="btn btn-primary"><i class="fas fa-download"></i> Descargar</button></a>`
								}else{
									html = `<a download href="${row.ruta}" target="_blank"><button type="button" class="btn btn-primary"><i class="fas fa-download"></i> Descargar</button></a><button type="button" class="btn btn-danger" onclick="eliminarDocPec(${row.doc_gc_id})" data-toggle="modal" data-target="#eliminarAnexoPec" style="margin-left:5px">Eliminar</button>`
								}
							return html;
        						//FIN CZ SPRINT 67 correccion
						}
					}				
					
				]
			});
    }
	// INICIO CZ SPRINT 67
	function eliminarDocPec(id){
			console.log("aqui");
			document.getElementById('elimPec').setAttribute('onclick','elimArchivoPec('+id+')');
	}
	// FIN CZ SPRINT 67
	
	function tblEjecucionPec(){
		let data = new Object();
		data.pro_an_id = $("#pro_an_id").val();
		
		let tabla_alertas = $('#tbl_actividadesInf').DataTable();
        tabla_alertas.clear().destroy();
        
        tabla_alertas = $('#tbl_actividadesInf').DataTable({
            "language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
            "lengthChange": false,
			"info": 		false,
			"searching":	false,
			"paging":		false,
            "ajax": {
                "url": "{{ route('get.plan.estrategico') }}",
                "type": "GET",
                "data": data
            },
 				"columnDefs": [
 					{ //prob_priorizado
						"targets": 0,
						"className": 'dt-head-center dt-body-center',
						"visible": false,
						"createdCell": function (td, cellData, rowData, row, col) {
							$(td).css("vertical-align", "middle");
						
						}
					},
            		{ //prob_priorizado
						"targets": 1,
						"className": 'dt-head-center dt-body-center',
						"createdCell": function (td, cellData, rowData, row, col) {
							$(td).css("vertical-align", "middle");
						
						}
					},
            		{ //objetivo
						"targets": 2,
						"className": 'dt-head-center dt-body-center',
						"createdCell": function (td, cellData, rowData, row, col) {
							$(td).css("vertical-align", "middle");
						
						}
					},
            		{ //actividad
						"targets": 3,
						"className": 'dt-head-center dt-body-center',
						"createdCell": function (td, cellData, rowData, row, col) {
							$(td).css("vertical-align", "middle");
						
						}
					},
            		{ //estrategia
						"targets": 4,
						"className": 'dt-head-center dt-body-center',
						"createdCell": function (td, cellData, rowData, row, col) {
							$(td).css("vertical-align", "middle");
						
						}
					},
            		{ //metodologia
						"targets": 5,
						"className": 'dt-head-center dt-body-center',
						"createdCell": function (td, cellData, rowData, row, col) {
							$(td).css("vertical-align", "middle");
						
						}
					}
        		],				
				"columns": [
					{ "data": "idprob", "className": "text-left" },
					{ "data": "prob_priorizado", "className": "text-left" },
					{ "data": "objetivo", "className": "text-left" },
					{ "data": "resultado", "className": "text-center" },
					{ "data": "indicador", "className": "text-center" },
					{
						"data"		: "idprob",
						"name"		: "idprob",
						"className"	: "text-center",
						"visible"	: true,
						"orderable"	: true,
						"searchable": true,
						"render" : function (data, type, row){
							if(row.id == null){
								return '';
							}else{
								//INICIO DC
								if('{{ Session::get('perfil') }}' == 2){
									// INICIO CZ SPRINT 67
									if(row.check_realizado == 1){
										// INICIO CZ SPRINT 67 correccion
										return '<button type="button" disabled="disabled" class="btn btn-warning" onclick="RealizadoPEC('+row.id+')" id="btn-realizadoPec_'+row.id+'">Realizado</button>&nbsp;';
										// FIN CZ SPRINT 67 correccion
									}else{
										return '<button type="button" disabled="disabled" class="btn btn-danger"data-toggle="modal" data-id="'+row.id+'" data-target="#modalNoRealizado" id="btn-noRealizadoPec'+row.id+'">No Realizado</button>';

									}
								}else if($("#est_pro_id").val() == {{ config('constantes.finalizado') }} || $("#est_pro_id").val() == {{ config('constantes.desestimado') }} ){
									return '<button disabled="disabled" type="button" class="btn btn-warning" onclick="Realizado('+row.id+')">Realizado</button>&nbsp;<button disabled="disabled" type="button" data-id="'+row.id+'" class="btn btn-danger"data-toggle="modal" data-target="#modalNoRealizado" id="btn-noRealizadoPec'+row.id+'">No Realizado</button>';
								// FIN CZ SPRINT 67
								}else{
									if(row.check_realizado == 1){
										// INICIO CZ SPRINT 67 correccion
										return '<button type="button" disabled="disabled" class="btn btn-warning" onclick="RealizadoPEC('+row.id+')" id="btn-realizadoPec_'+row.id+'">Realizado</button>&nbsp;<button type="button" data-id="'+row.id+'" class="btn btn-danger"data-toggle="modal" data-target="#modalNoRealizado" id="btn-noRealizadoPec'+row.id+'">No Realizado</button>';
										// FIN CZ SPRINT 67 correccion
									}else{
										return '<button type="button" class="btn btn-warning" onclick="RealizadoPEC('+row.id+')" id="btn-realizadoPec_'+row.id+'">Realizado</button>&nbsp;<button type="button" disabled="disabled" class="btn btn-danger"data-toggle="modal" data-id="'+row.id+'" data-target="#modalNoRealizado" id="btn-noRealizadoPec'+row.id+'">No Realizado</button>';

									}
							}
								//FIN DC
							}
							
						}
					}				
					
				]
			});
	}
	
	// INICIO CZ SPRINT 67
	function RealizadoPEC(id){
		console.log(id);
		let data = new Object();
		data.id = id;
		bloquearPantalla();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
    		});
        	$.ajax({
                url: '{{ route("realizadopec") }}',
                type: 'POST',
                data: data,
                success: function(resp) {
    				if(resp.estado == 1){
						toastr.success("Se ha realizado cambio de estado con exito!");
					}
					$("#btn-realizadoPec_"+id).prop("disabled", true);			
					$("#btn-noRealizadoPec"+id).prop("disabled", false);			
					desbloquearPantalla();	
                },
    			error: function(jqXHR, text, error){
    				desbloquearPantalla();
    				console.log(error);
    			}
            });
	}
	$('#modalNoRealizado').on('show.bs.modal', function(e) {
		var Id = $(e.relatedTarget).data('id');
		$("#confirm-noRealizadoPec").attr('onclick', 'noRealizadoPec("'+Id+'")');
	});
	function noRealizadoPec(id){
		console.log(id);
		let data = new Object();
		data.id = id;
		bloquearPantalla();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
    		});
        	$.ajax({
                url: '{{ route("norealizadopec") }}',
                type: 'POST',
                data: data,
                success: function(resp) {
					$("#btn-noRealizadoPec"+id).prop("disabled", true);		
					$("#btn-realizadoPec_"+id).prop("disabled", false);
					$('#modalNoRealizado').modal('hide');		
					if(resp.estado == 1){
						toastr.success("Se ha realizado cambio de estado con exito!");
					}
					desbloquearPantalla();	
                },
    			error: function(jqXHR, text, error){
    				desbloquearPantalla();
    				console.log(error);
    			}
            });
	}
	// FIN CZ SPRINT 67
	function desplegarInfPlanEst(){
		bloquearPantalla();
		//INICIO DC
		$('.fechaPlazo').fadeOut(0);
		$('#contenedor_matriz_factores').fadeOut(0);
		$('#contenedor_carta_compromiso').fadeOut(0);
		$('#contenedor_acta_constitucion').fadeOut(0);
		$('#contenedor_acta_reunion').fadeOut(0);
		$('#contenedor_acta_reunion_asamblea').fadeOut(0);
		$('#contenedor_identificacion_com_pri').fadeOut(0);
		$('#contenedor_organizaciones_fun_com').fadeOut(0);
		$('#contenedor_instituciones_serv').fadeOut(0);
		$('#contenedor_bienes_com_com').fadeOut(0);
		$('#contenedor_factores_rie_factores_pro').fadeOut(0);
		//FIN DC
		
		$('#linea-ges-com').fadeOut(0);
		
		$('#contenedor_matriz_identificacion_problemas_ll').fadeOut(0);
		
		$('#contenedor_matriz_prg_1_').fadeOut(0);
		$('#contenedor_matriz_prg_2_').fadeOut(0);
		$('#contenedor_matriz_prg_3_').fadeOut(0);
		$('#contenedor_problemas_priorizados_MRE_').fadeOut(0);
		$('#diagnostico-ges-com button').fadeOut(0);
		
		$('#contenedor_info_identificacion').fadeOut(0);
		$('#contenedor_info_introduccion').fadeOut(0);
		$('#contenedor_info_gurpo_accion').fadeOut(0);
		$('#contenedor_info_ejec_diag_part').fadeOut(0);
		$('#contenedor_info_resultados').fadeOut(0);
		$('#contenedor_info_conclusiones').fadeOut(0);
		$('#contenedor_info_anexos').fadeOut(0);
		$('#descInfPEC').fadeOut(0);
		
		$('#contenedor_listar_plan').fadeOut(0);
		$('#listar_plan').fadeOut(0);
		
		$('#contenedor_listar_linea').fadeOut(0);
		$('#listar_linea').fadeOut(0);
	
		$('#contenedor_encuesta_prercepcion').fadeOut(0);
	
		$('#contenedor_listar_informe').fadeIn(0);
		$('#listar_informe').fadeIn(0);
		
		$('#contenedor_listar_informe2').fadeIn(0);
		$('#listar_informe2').fadeIn(0);
		
		$('#contenedor_introduccionInf').fadeIn(0);
		
		$('#contenedor_eje_plan_est_comInf').fadeIn(0);
		
		$('#contenedor_resultadosInf').fadeIn(0);
		
		$('#contenedor_conclusiones_recomendacionesInf').fadeIn(0);
		
		$('#contenedor_anexosInf').fadeIn(0);
		
		$('#btnDescargarInf').fadeIn(0);
		
		getComunidadPriorizada();
		
		let data = new Object();
		data.pro_an_id = $("#pro_an_id").val();
		
		let tabla_alertas = $('#tbl_actividadesInf').DataTable();
        $('#tbl_actividadesInf').DataTable().ajax.reload();
        
        tabla_alertas = $('#tbl_actividadesInf').DataTable({
            "language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
            "lengthChange": false,
			"info": 		false,
			"searching":	false,
			"paging":		false,
            "ajax": {
                "url": "{{ route('get.plan.estrategico') }}",
                "type": "GET",
                "data": data
            },
 				"columnDefs": [
 					{ //prob_priorizado
						"targets": 0,
						"className": 'dt-head-center dt-body-center',
						"visible": false,
						"createdCell": function (td, cellData, rowData, row, col) {
							$(td).css("vertical-align", "middle");
						
						}
					},
            		{ //prob_priorizado
						"targets": 1,
						"className": 'dt-head-center dt-body-center',
						"createdCell": function (td, cellData, rowData, row, col) {
							$(td).css("vertical-align", "middle");
						
						}
					},
            		{ //objetivo
						"targets": 2,
						"className": 'dt-head-center dt-body-center',
						"createdCell": function (td, cellData, rowData, row, col) {
							$(td).css("vertical-align", "middle");
						
						}
					},
            		{ //actividad
						"targets": 3,
						"className": 'dt-head-center dt-body-center',
						"createdCell": function (td, cellData, rowData, row, col) {
							$(td).css("vertical-align", "middle");
						
						}
					},
            		{ //estrategia
						"targets": 4,
						"className": 'dt-head-center dt-body-center',
						"createdCell": function (td, cellData, rowData, row, col) {
							$(td).css("vertical-align", "middle");
						
						}
					},
            		{ //metodologia
						"targets": 5,
						"className": 'dt-head-center dt-body-center',
						"createdCell": function (td, cellData, rowData, row, col) {
							$(td).css("vertical-align", "middle");
						
						}
					}
        		],				
				"columns": [
					{ "data": "idprob", "className": "text-left" },
					{ "data": "prob_priorizado", "className": "text-left" },
					{ "data": "objetivo", "className": "text-left" },
					{ "data": "resultado", "className": "text-center" },
					{ "data": "indicador", "className": "text-center" },
					{
						"data"		: "idprob",
						"name"		: "idprob",
						"className"	: "text-center",
						"visible"	: true,
						"orderable"	: true,
						"searchable": true,
						"render" : function (data, type, row){
							if(row.id == null){
								return '';
							}else{
								return '<button type="button" class="btn btn-primary" onclick="editarPlanEstrategicoInf('+row.id+')">Editar</button>';
							}
							
						}
					}				
					
				]
			});
			
	    //carga anexos
	    let data2 = new Object();
		data2.pro_an_id = $("#pro_an_id").val();
		
	    let tabla_anexos = $('#tbl_anexos').DataTable();
        $('#tbl_anexos').DataTable().ajax.reload();
        
        tabla_anexos = $('#tbl_anexos').DataTable({
            "language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
            "lengthChange": false,
			"info": 		false,
			"searching":	false,
			"paging":		false,
            "ajax": {
                "url": "{{ route('get.anexos.pec') }}",
                "type": "GET",
                "data": data2
            },
 				"columnDefs": [
 					{ //prob_priorizado
						"targets": 0,
						"className": 'dt-head-center dt-body-center',
						"createdCell": function (td, cellData, rowData, row, col) {
							$(td).css("vertical-align", "middle");
						
						}
					},
            		{ //prob_priorizado
						"targets": 1,
						"className": 'dt-head-center dt-body-center',
						"createdCell": function (td, cellData, rowData, row, col) {
							$(td).css("vertical-align", "middle");
						
						}
					},
            		{ //objetivo
						"targets": 2,
						"className": 'dt-head-center dt-body-center',
						"createdCell": function (td, cellData, rowData, row, col) {
							$(td).css("vertical-align", "middle");
						
						}
					},
					{ //objetivo
						"targets": 3,
						"className": 'dt-head-center dt-body-center',
						"createdCell": function (td, cellData, rowData, row, col) {
							$(td).css("vertical-align", "middle");
						
						}
					}
        		],				
				"columns": [
					{ "data": "doc_nom", "className": "text-left" },
					{ "data": "tip_nom", "className": "text-left" },
					{ "data": "usuario", "className": "text-left" },
					{
						"data"		: "idprob",
						"name"		: "idprob",
						"className"	: "text-center",
						"visible"	: true,
						"orderable"	: true,
						"searchable": true,
						"render" : function (data, type, row){
									//INICIO CZ SPRINT 67 correccion
							let html ='';
							 html ='<button type="button" class="btn btn-primary" onclick="descArchivoPec('+row.doc_gc_id+', \''+row.doc_nom+'\')">Descargar</button><button type="button" class="btn btn-danger" onclick="eliminarDocPec('+row.doc_gc_id+')" data-toggle="modal" data-target="#eliminarAnexoPec">Eliminar</button>';
							   
							if($("#est_pro_id").val() == {{ config('constantes.finalizado') }} || $("#est_pro_id").val() == {{ config('constantes.desestimado') }} ){
								$('.btn-danger').prop('disabled', true);
							}
							return html;
        						//FIN CZ SPRINT 67 correccion
						}
					}				
					
				]
			});
		cargarDatosInf();
		   //INICIO CZ SPRINT 67 correccion
		   if($("#est_pro_id").val() == {{ config('constantes.finalizado') }} || $("#est_pro_id").val() == {{ config('constantes.desestimado') }} ){
            $('.btn-danger').attr('disabled', 'disabled');
        	}   
        //FIN CZ SPRINT 67 correccion

		
	}
	
	function editarPlanEstrategico(idprob, id){
		bloquearPantalla();  
		
		$("#txt_plan_objetivo").css("border-color", "#d1d3e2");
    	$('#val_txt_plan_objetivo').fadeOut(200);	
    	$("#txt_plan_resultados").css("border-color", "#d1d3e2");
    	$('#val_txt_plan_resultados').fadeOut(200);	
    	$("#txt_plan_indicador").css("border-color", "#d1d3e2");
    	$('#val_txt_plan_indicador').fadeOut(200);	
    	//INICIO DC
    	if('{{ Session::get('perfil') }}' == 2){
    		$('#btnGuardarEditar').attr('disabled', 'disabled');
    	}
    	//FIN DC 	
		if(id == null){ //agregar
			$('#idProb').val(idprob);
			$('#btnGuardarEditar').attr('onClick', 'guardarPlanEstrategico()');
			$('#txt_plan_objetivo').val('');    		
    		$('#txt_plan_resultados').val('');
    		$('#txt_plan_indicador').val('');  
    		desbloquearPantalla();
		}else{ //editar
			$('#idProb').val(idprob);
			$('#idPlan').val(id);
			$('#btnGuardarEditar').attr('onClick', 'editPlanEstrategico()');
			let data = new Object();
    		data.idprob = idprob;
    		data.idPlan = id;
			$.ajax({
    			type: "GET",
    			url: "{{route('obtener.plan.estrategico')}}",
    			data: data
    		}).done(function(resp){
    			var datos = JSON.parse(resp);    			
    			$('#txt_plan_objetivo').val(datos[0].objetivo);
    			$('#txt_plan_resultados').val(datos[0].resultado);
    			$('#txt_plan_indicador').val(datos[0].indicador); 
    			calculaCaracteres('txt_plan_objetivo');
    			calculaCaracteres('txt_plan_resultados');
    			calculaCaracteres('txt_plan_indicador');
    			desbloquearPantalla();
    			
    		}).fail(function(objeto, tipoError, errorHttp){
    			desbloquearPantalla();
                manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
                return false;
            });
		}
		
		$('#PlanModal').modal('show');
	}
	
	function calculaCaracteres(id){
		num_caracteres_permitidos   = 2000;
    	num_caracteres = $('#'+id).val().length;
    	$('#cant_carac_'+id).html(num_caracteres);
	}
	
	function getEstrategias(id, id_act){
		let data = new Object();
		data.id = id;
		data.id_act = id_act;
		$.ajax({
    		type: "GET",
    		url: "{{route('get.estrategia.plan')}}",
    		data: data
    	}).done(function(resp){
    		var datos = JSON.parse(resp);
    		var texto = '';
    		if(datos[0].act_checkrelcom == 1){
    			texto = texto + '-Relacionamiento Comunitario<br>';
    		}
    		if(datos[0].act_checktallcom == 1){
    			texto = texto + '-Talleres Comunitarios<br>';
    		}
    		if(datos[0].act_checkinicom == 1){
    			texto = texto + '-Iniciativa Comunitaria<br>';
    		}
    		$('#tabla_estrategia'+id+id_act).html(texto);
    
    	}).fail(function(objeto, tipoError, errorHttp){
    		desbloquearPantalla();
            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
            return false;
        });
	}
	
	
	function editarPlanEstrategicoInf(id){
		bloquearPantalla();
		$('#idProb').val(id);
		$("#inf_resultado").css("border-color", "#d1d3e2");
		$("#inf_faqcilitadores").css("border-color", "#d1d3e2");
		$("#inf_obstaculizaciones").css("border-color", "#d1d3e2");
		$("#inf_aprendisaje").css("border-color", "#d1d3e2");
		$('#ModalEjePlanEst').modal();
		let data = new Object();
        data.id = id;
		$.ajax({
            type: "GET",
            url: "{{route('get.datos.pec')}}",
            data: data
        }).done(function(resp){
        	
           var datos = JSON.parse(resp);
           if(datos.length > 0){
           	$('#inf_resultado').val(datos[0].resultado);
           	if(datos[0].resultado != null){
           	$('#cant_carac_inf_resultado').html(datos[0].resultado.length);
           	}           	
 			$('#inf_faqcilitadores').val(datos[0].facilitadores);
 			if(datos[0].facilitadores != null){
 			$('#cant_carac_inf_faqcilitadores').html(datos[0].facilitadores.length);
 			}			
 			$('#inf_obstaculizaciones').val(datos[0].obstaculizadores);
 			if(datos[0].obstaculizadores != null){
 			$('#cant_carac_inf_obstaculizaciones').html(datos[0].obstaculizadores.length);
 			} 			
 			$('#inf_aprendisaje').val(datos[0].aprendizajes);
 			if(datos[0].aprendizajes != null){
 			$('#cant_carac_inf_aprendisaje').html(datos[0].aprendizajes.length);
 			}
 			
           }
           	
           desbloquearPantalla(); 
        }).fail(function(objeto, tipoError, errorHttp){

            desbloquearPantalla();
            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
            return false;

        });
		
	}
	function elimArchivoPec(id){
		bloquearPantalla();
		let data = new Object();
		
		data.tip_id = 8;
        data.id = id;
		data.id_pro_an_id = $("#pro_an_id").val();
		data.tipo_gest = 0;
		$.ajaxSetup({
			    headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}
            });
		$.ajax({
            type: "Post",
            url: "{{route('eliminarDocumento')}}",
            data: data
        }).done(function(resp){
			console.log(resp);
           if(resp.estado == 1){
           		mensajeTemporalRespuestas(1, resp.mensaje);	
				desplegarInfPlanEst();
				// INICIO CZ SPRINT 67
				$('#eliminarAnexoPec').modal('hide')
				// FIN CZ SPRINT 67
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
	function descArchivoPec(id, archivo){
		bloquearPantalla();
		let data = new Object();
        data.archivo = archivo;
		$.ajax({
            type: "GET",
            url: "{{route('descarga.anexo.pec')}}",
            data: data
        }).done(function(resp){
           window.open(resp, "_blank");
           desbloquearPantalla(); 
        }).fail(function(objeto, tipoError, errorHttp){

            desbloquearPantalla();
            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
            return false;

        });
	}
	function formatearFecha(fpc){
		if(fpc != null){
			var f = fpc.split(" "); 
        	var fecha = f[0].split("-");
        	var year = fecha[0];
        	var mes = fecha[1];
        	var dia = fecha[2];
        	var hrs = f[1].split(":");
        	var hora = parseInt(hrs[0]);
        	var minuto = hrs[1]; 
        	var ampm = '';
        	if(hora > 11){
        		ampm = 'PM';
        	}else{
        		ampm = 'AM';
        	}
        	var final = mes+'/'+dia+'/'+year+' '+hora+':'+minuto+' '+ampm;
        	return final;
		}
    }

	function cargarDatosInf(){
		// INICIO CZ SPRINT 56
		getComunidadPriorizada();
		// FIN CZ SPRINT 56
		let data = new Object();
        data.pro_an_id = {{ $pro_an_id }};
        $.ajax({
            type: "GET",
            url: "{{route('get.informe.pec')}}",
            data: data
        }).done(function(resp){
            var datos = JSON.parse(resp);            
            //INICIO DC
            $('#inf_comuna').attr('disabled', 'disabled');
            $('#inf_comuna').val('{{ Session::get('comuna') }}');
            $('#h_inf_comuna').val('{{ Session::get('comuna') }}');  
			
			//INICIO CZ SPRINT 55
			$.ajax({
            type: "GET",
            url: "{{route('data.informe.diagnostico')}}",
            data: data
			}).done(function(resp){
				$("#inf_com_pri option[value="+resp.com_pri[0].com_pri_id+"]").attr("selected", true);
				$('#h_inf_com_pri').val(resp.com_pri[0].com_pri_id);
             
			}).fail(function(objeto, tipoError, errorHttp){

				desbloquearPantalla();
				manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
				return false;

			});
			//FIN CZ SPRINT 55
            //FIN DC    
            if(datos.length > 0){
				// INICIO CZ SPRINT 55
				$('#inf_nomGestorComCar').val(datos[0].info_resp);
				$( "#inf_com_pri" ).prop( "disabled", true );
				
            	// setTimeout(function(){ 
            	// 	if(datos[0].com_pri_id == null || datos[0].com_pri_id == 0){
            	// 		$('#inf_com_pri').val('0');
            	// 	}else{
            	// 	$('#inf_com_pri').val(datos[0].com_pri_id);
            			
            	// 	}
            	// }, 1000);
            	//FIN CZ SPRINT 55
            	//INICIO DC
            	if(datos[0].info_fec_pri != null){
            	let fec1 = new Date(datos[0].info_fec_pri);
                fec1 = fec1.getDate()+"/"+(fec1.getMonth() + 1 )+"/"+fec1.getFullYear();
                $('#info_fec_pri_con').datetimepicker('format', 'DD/MM/Y');
                $('#info_fec_pri_con').datetimepicker('date', fec1);
            	}
            	if(datos[0].info_fec_ter != null){
                let fec2 = new Date(datos[0].info_fec_ter);
                fec2 = fec2.getDate()+"/"+(fec2.getMonth() + 1 )+"/"+fec2.getFullYear();
                $('#info_fec_ter_dpc').datetimepicker('format', 'DD/MM/Y');
                $('#info_fec_ter_dpc').datetimepicker('date', fec2);
            	}                
                //FIN DC
                
            	$('#info_intro').val(datos[0].info_intro);
            	$("#cant_carac_info_intro").text($('#info_intro').val().length);
            	$('#info_result').val(datos[0].info_act_plan);
            	$("#cant_carac_info_result").text($('#info_result').val().length);
            	$('#info_con_rec').val(datos[0].info_act_real);
            	$("#cant_carac_info_con_rec").text($('#info_con_rec').val().length);
            	if(datos[0].info_resp != null && datos[0].info_com != null && datos[0].com_pri_id != null && datos[0].com_pri_id != 0 && datos[0].info_fec_pri != null && datos[0].info_fec_ter != null && datos[0].info_intro != null && datos[0].info_act_plan != null && datos[0].info_act_real != null){
            		$('#descInfPEC').fadeIn(0);
            		$('#finPEC').fadeIn(0);
					//INICIO CZ SPRINT 56
					$("#msj_error_descInfPEC").css("display","none");
					//FIN CZ SPRINT 56
            	}else{
					//INICIO CZ SPRINT 56
					$("#msj_error_descInfPEC").css("display","block");
					//FIN CZ SPRINT 56
            		$('#descInfPEC').fadeOut(0);
					
					
            	}
            }
            desbloquearPantalla();
        }).fail(function(objeto, tipoError, errorHttp){
            desbloquearPantalla();
            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
            return false;
        });
	}
	function getComunidadPriorizada(){
		bloquearPantalla();
		let data = new Object();

        data.pro_an_id = {{ $pro_an_id }};
        $.ajax({
            type: "GET",
            url: "{{route('data.informe.diagnostico')}}",
            data: data
        }).done(function(resp){
            $('#inf_com_pri').html('');
            $('#inf_com_pri').html('<option value="0">Seleccione Comuna Priorizada</option>');
            $.each(resp.com_pri, function(i, item){
                $('#inf_com_pri').append('<option value="'+ item.com_pri_id +'">'+item.com_pri_nom+'</option>'); 
            });
            desbloquearPantalla();
        }).fail(function(objeto, tipoError, errorHttp){

            desbloquearPantalla();
            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
            return false;

        });
	}
	
    function desplegarGestionComunitaria(estado, inicial = false){  	
		console.log(estado);
		colorCheck();
    	//INICIO DC
     	verificaEstadoPlazo(estado);
     	//FIN DC
		//se elimina console.log(); que mostraba un dato.
		// INICIO CZ SPRINT 55
		if(estado != {{ config('constantes.identificacion_comunidad') }}){
			$( "#iden_com_pri" ).prop( "disabled", true );
		}
		//FIN CZ SPRINT 55
		// INICIO CZ SPRINT 67
		$("#plan_estrategico").css("display","none");
		// FIN CZ SPRINT 67
        switch(estado){
            case {{ config('constantes.identificacion_comunidad') }}: //IDENTIFICACION DE LA COMUNIDAD
            	//INICIO DC
            	$('#contenedor_listar_plan').fadeOut(0);
            	$('#contenedor_listar_linea').fadeOut(0);
				$('#contenedor_encuesta_prercepcion').fadeOut(0);
            	$('#contenedor_listar_informe').fadeOut(0);
            	$('#contenedor_introduccionInf').fadeOut(0);
            	$('#contenedor_eje_plan_est_comInf').fadeOut(0);
            	$('#contenedor_resultadosInf').fadeOut(0);
            	$('#contenedor_conclusiones_recomendacionesInf').fadeOut(0);
            	$('#contenedor_anexosInf').fadeOut(0);
            	$('#contenedor_identificacion_com_pri').fadeIn(0);
				$('#contenedor_organizaciones_fun_com').fadeIn(0);
				$('#contenedor_instituciones_serv').fadeIn(0);
				$('#contenedor_bienes_com_com').fadeIn(0);
				$('#contenedor_factores_rie_factores_pro').fadeIn(0);
				//FIN DC
            	
            	$("#documentos-tab").removeClass("active");
            	$("#documentos-tab").removeClass("show");
            	$("#doc-ges-com").hide();

            	$("#lin-bas-tab").removeClass("active");
            	$("#lin-bas-tab").removeClass("show");
            	$("#linea-ges-com").hide();

				$("#mat-ide-pro-nna-tab").removeClass("active");
            	$("#mat-ide-pro-nna-tab").removeClass("show");
				$("#mat-ide-pro-nna").hide();

				$("#mat-ide-pro-ran-eta-tab").removeClass("active");
            	$("#mat-ide-pro-ran-eta-tab").removeClass("show");
				$("#mat-ide-pro-ran-eta").hide();

				$("#mat-fac-tab").removeClass("active");
            	$("#mat-fac-tab").removeClass("show");
				$("#mat_fac_ges_com").hide();

				$("#inf-dpc-tab").removeClass("active");
            	$("#inf-dpc-tab").removeClass("show");
				$("#inf_dpc").hide();
				// INICIO CZ SPRINT 67
				$(".validar-btnEtapa").attr("disabled",true);
				$(".validar-btnEtapa").css("display","none");
				// FIN CZ SPRINT 67
            	if (inicial){
                	$("#iden-com-tab").removeClass("des-hab-est");

                	$("#iden-com-tab").click();
                	$("#iden-com-tab").focus();
            		$("#iden-com-tab").addClass("active");
                	$("#btn-ident-com-ges-com").attr('disabled',false);
					// INICIO CZ SPRINT 67
					$(".validar-btnEtapa").attr("disabled",false);
					$(".validar-btnEtapa").css("display","initial");
					// FIN CZ SPRINT 67
                	$("#iden-com-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.identificacion_comunidad')}}, false);");							
            	}

                getDataIdentComunidad();

                $('#form_diag_fec_lev').datetimepicker('format', 'DD/MM/Y');
            	$("#ident-com-ges-com").show();
				// $("#ident_com-tab-ico").removeClass('text-light');
				// $("#ident_com-tab-ico").addClass('icon-success');
            break;

            case {{ config('constantes.carta_compromiso_comunidad') }}: //CARTA DE COMPROMISO DE COMUNIDAD
            	//INICIO DC
            	$('#contenedor_listar_plan').fadeOut();
            	$('#contenedor_listar_linea').fadeOut(0);
				$('#contenedor_encuesta_prercepcion').fadeOut(0);
            	$('#contenedor_listar_informe').fadeOut(0);
            	$('#contenedor_introduccionInf').fadeOut(0);
            	$('#contenedor_eje_plan_est_comInf').fadeOut(0);
            	$('#contenedor_resultadosInf').fadeOut(0);
            	$('#contenedor_conclusiones_recomendacionesInf').fadeOut(0);
            	$('#contenedor_anexosInf').fadeOut(0);
                $('#contenedor_carta_compromiso').fadeIn(0);
				$('#contenedor_acta_constitucion').fadeIn(0);
				$('#contenedor_acta_reunion').fadeIn(0);
				$('#contenedor_acta_reunion_asamblea').fadeIn(0);
            	//FIN DC
            	$("#iden-com-tab").removeClass("active");
            	$("#iden-com-tab").removeClass("show");
            	$("#ident-com-ges-com").hide();

            	$("#lin-bas-tab").removeClass("active");
            	$("#lin-bas-tab").removeClass("show");
            	$("#linea-ges-com").hide();
				
				$("#mat-ide-pro-nna-tab").removeClass("active");
            	$("#mat-ide-pro-nna-tab").removeClass("show");
				$("#mat-ide-pro-nna").hide();

				$("#mat-ide-pro-ran-eta-tab").removeClass("active");
            	$("#mat-ide-pro-ran-eta-tab").removeClass("show");
				$("#mat-ide-pro-ran-eta").hide();

				$("#mat-fac-tab").removeClass("active");
            	$("#mat-fac-tab").removeClass("show");
				$("#mat_fac_ges_com").hide();

				$("#inf-dpc-tab").removeClass("active");
            	$("#inf-dpc-tab").removeClass("show");
				$("#inf_dpc").hide();


            	if (inicial == true){
                	$("#documentos-tab").removeClass("des-hab-est");
                	$("#iden-com-tab").removeClass("des-hab-est");
                	
                	$("#documentos-tab").click();
                	$("#documentos-tab").focus();
            		$("#documentos-tab").addClass("active");

            		$("#iden-com-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.identificacion_comunidad')}}, false);");
                	$("#documentos-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.carta_compromiso_comunidad')}}, false);");
            	}

            	$("#doc-ges-com").show();
				// $("#ident_com-tab-ico").removeClass('text-light');
				// $("#ident_com-tab-ico").addClass('icon-success');
				// $("#document-tab-ico").removeClass('text-light');
				// $("#document-tab-ico").addClass('icon-success');
            break;

            case {{ config('constantes.linea_base') }}: //LINEA BASE
            	//INICIO DC           	
				// INICIO CZ SPRINT 70
				$('#tipo_linea').val(1);
				$(".btn_lb_guardar").css("display","inline");
				$(".cerrar_modal_linea_base").css("display","inline");

				// FIN CZ SPRINT 70
            	$('#linea-ges-com').fadeIn(0);
            	$('#contenedor_listar_plan').fadeOut();
            	$('#contenedor_listar_linea').fadeOut(0);
				$('#contenedor_encuesta_prercepcion').fadeOut(0);
            	$('#contenedor_listar_informe').fadeOut(0);
            	$('#contenedor_introduccionInf').fadeOut(0);
            	$('#contenedor_eje_plan_est_comInf').fadeOut(0);
            	$('#contenedor_resultadosInf').fadeOut(0);
            	$('#contenedor_conclusiones_recomendacionesInf').fadeOut(0);
            	$('#contenedor_anexosInf').fadeOut(0);
            	//FIN DC
            	
            	$("#iden-com-tab").removeClass("active");
            	$("#iden-com-tab").removeClass("show");
				$("#ident-com-ges-com").hide();

            	$("#documentos-tab").removeClass("active");
            	$("#documentos-tab").removeClass("show");
            	$("#doc-ges-com").hide();
				
				$("#mat-ide-pro-nna-tab").removeClass("active");
            	$("#mat-ide-pro-nna-tab").removeClass("show");
				$("#mat-ide-pro-nna").hide();

				$("#mat-ide-pro-ran-eta-tab").removeClass("active");
            	$("#mat-ide-pro-ran-eta-tab").removeClass("show");
				$("#mat-ide-pro-ran-eta").hide();

				$("#mat-fac-tab").removeClass("active");
            	$("#mat-fac-tab").removeClass("show");
				$("#mat_fac_ges_com").hide();

				$("#inf-dpc-tab").removeClass("active");
            	$("#inf-dpc-tab").removeClass("show");
				$("#inf_dpc").hide();

            	if (inicial == true){
                	$("#documentos-tab").removeClass("des-hab-est");
                	$("#iden-com-tab").removeClass("des-hab-est");
                	$("#lin-bas-tab").removeClass("des-hab-est");
            		
            		$("#lin-bas-tab").click();
                	$("#lin-bas-tab").focus();
                	$("#lin-bas-tab").addClass("active");
					$("#btn-linea-ges-com").attr('disabled',false);
					

                	$("#iden-com-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.identificacion_comunidad')}}, false);");
                	$("#documentos-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.carta_compromiso_comunidad')}}, false);");
                	$("#lin-bas-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.linea_base')}}, false);");
            	}
				listarLineaBase();
                $("#linea-ges-com").show();
				// $("#ident_com-tab-ico").removeClass('text-light');
				// $("#ident_com-tab-ico").addClass('icon-success');
				// $("#document-tab-ico").removeClass('text-light');
				// $("#document-tab-ico").addClass('icon-success');
				// $("#lineBase-tab-ico").removeClass('text-light');
				// $("#lineBase-tab-ico").addClass('icon-success');
            break;

			case {{ config('constantes.matriz_identificación_problemas') }}: //MATRIZ IDENTIFICACIÓN DE PROBLEMAS QUE CONSTITUYEN UN FACTOR DE RIESGO PARA LOS NNA
            	//INICIO DC
            	$('#contenedor_listar_plan').fadeOut();
            	$('#contenedor_listar_linea').fadeOut(0);
				$('#contenedor_encuesta_prercepcion').fadeOut(0);
            	$('#contenedor_listar_informe').fadeOut(0);
            	$('#contenedor_introduccionInf').fadeOut(0);
            	$('#contenedor_eje_plan_est_comInf').fadeOut(0);
            	$('#contenedor_resultadosInf').fadeOut(0);
            	$('#contenedor_conclusiones_recomendacionesInf').fadeOut(0);
            	$('#contenedor_anexosInf').fadeOut(0);
            	$('#contenedor_matriz_identificacion_problemas_ll').fadeIn(0);
            	$("#iden-com-tab").removeClass("active");
            	$("#iden-com-tab").removeClass("show");
				$("#ident-com-ges-com").hide();
				//FIN DC
				
				$("#inf_dpc").hide();

            	$("#documentos-tab").removeClass("active");
            	$("#documentos-tab").removeClass("show");
            	$("#doc-ges-com").hide();

				$("#lin-bas-tab").removeClass("active");
				$("#lin-bas-tab").removeClass("show");
				$("#linea-ges-com").hide();

				$("#mat-ide-pro-ran-eta-tab").removeClass("active");
            	$("#mat-ide-pro-ran-eta-tab").removeClass("show");
				$("#mat-ide-pro-ran-eta").hide();

				$("#mat-fac-tab").removeClass("active");
            	$("#mat-fac-tab").removeClass("show");
				$("#mat_fac_ges_com").hide();	

				$("#inf-dpc-tab").removeClass("active");
            	$("#inf-dpc-tab").removeClass("show");
				$("#inf_dpc").hide();

				//INICIO CZ SPRINT 61 
				$("#btn-matriz_identificacion_nna").attr("disabled",true);
				//INICIO FIN SPRINT 61 
            	if (inicial == true){
                	$("#documentos-tab").removeClass("des-hab-est");
                	$("#iden-com-tab").removeClass("des-hab-est");
                	$("#lin-bas-tab").removeClass("des-hab-est");
					$("#mat-ide-pro-nna-tab").removeClass("des-hab-est");
            		
            		$("#mat-ide-pro-nna-tab").click();
                	$("#mat-ide-pro-nna-tab").focus();
                	$("#mat-ide-pro-nna-tab").addClass("active");
					$("#btn-mat-ide-pro-nna").attr('disabled',false);
					// INICIO CZ SPRINT 67
					$("#btn-matriz_identificacion_nna").attr('disabled',false);	
					// FIN CZ SPRINT 67
                	$("#iden-com-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.identificacion_comunidad')}}, false);");
                	$("#documentos-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.carta_compromiso_comunidad')}}, false);");
                	$("#lin-bas-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.linea_base')}}, false);");
					$("#mat-ide-pro-nna-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.matriz_identificación_problemas')}}, false);");
            	}
				$("#mat-ide-pro-nna").show();
				//INICIO DC SPRINT 67
				if({{ config('constantes.matriz_identificación_problemas') }} == $('#est_pro_id').val() ){
            		$('#btn-matriz_identificacion_nna').removeAttr('disabled');
            	}
            	//FIN DC SPRINT 67
				// $("#ident_com-tab-ico").removeClass('text-light');
				// $("#ident_com-tab-ico").addClass('icon-success');
				// $("#document-tab-ico").removeClass('text-light');
				// $("#document-tab-ico").addClass('icon-success');
				// $("#lineBase-tab-ico").removeClass('text-light');
				// $("#lineBase-tab-ico").addClass('icon-success');
				// $("#matrizIdenPro-tab-ico").removeClass('text-light');
				// $("#matrizIdenPro-tab-ico").addClass('icon-success');
            break;

			case {{ config('constantes.matriz_priorización_problemas') }}: //MATRIZ DE PRIORIZACIÓN DE PROBLEMAS POR RANGO ETARIO
            	//INICIO DC
            	$('#contenedor_listar_plan').fadeOut();
            	$('#contenedor_listar_linea').fadeOut(0);
				$('#contenedor_encuesta_prercepcion').fadeOut(0);
            	$('#contenedor_listar_informe').fadeOut(0);
            	$('#contenedor_introduccionInf').fadeOut(0);
            	$('#contenedor_eje_plan_est_comInf').fadeOut(0);
            	$('#contenedor_resultadosInf').fadeOut(0);
            	$('#contenedor_conclusiones_recomendacionesInf').fadeOut(0);
            	$('#contenedor_anexosInf').fadeOut(0);
            	$('#contenedor_matriz_prg_1_').fadeIn(0);
				$('#contenedor_matriz_prg_2_').fadeIn(0);
				$('#contenedor_matriz_prg_3_').fadeIn(0);
				$('#contenedor_problemas_priorizados_MRE_').fadeIn(0);
				$('#diagnostico-ges-com button').fadeIn(0);
				if({{ $est_pro_id }} == {{ config('constantes.matriz_priorización_problemas') }}){
            		$('#editar_pri').val(1);
            	}
            	listarProblematicaMPRE(1);
            	//FIN DC
            	
            	$("#iden-com-tab").removeClass("active");
            	$("#iden-com-tab").removeClass("show");
            	$("#ident-com-ges-com").hide();

            	$("#documentos-tab").removeClass("active");
            	$("#documentos-tab").removeClass("show");
            	$("#doc-ges-com").hide();

				$("#lin-bas-tab").removeClass("active");
				$("#lin-bas-tab").removeClass("show");
				$("#linea-ges-com").hide();
				
				$("#mat-ide-pro-nna-tab").removeClass("active");
            	$("#mat-ide-pro-nna-tab").removeClass("show");
				$("#mat-ide-pro-nna").hide();

				$("#mat-fac-tab").removeClass("active");
            	$("#mat-fac-tab").removeClass("show");
				$("#mat_fac_ges_com").hide();

				$("#inf-dpc-tab").removeClass("active");
				$("#inf-dpc-tab").removeClass("show");
				$("#inf_dpc").hide();
				// INICIO CZ SPRINT 67
				$("#btn-mat-ide-pro-ran-eta").attr('disabled',true);
				console.log(inicial);
				// FIN CZ SPRINT 67
            	if (inicial == true){
                	$("#documentos-tab").removeClass("des-hab-est");
                	$("#iden-com-tab").removeClass("des-hab-est");
                	$("#lin-bas-tab").removeClass("des-hab-est");
					$("#mat-ide-pro-nna-tab").removeClass("des-hab-est");
					$("#mat-ide-pro-ran-eta-tab").removeClass("des-hab-est");
            		
            		$("#mat-ide-pro-ran-eta-tab").click();
                	$("#mat-ide-pro-ran-eta-tab").focus();
                	$("#mat-ide-pro-ran-eta-tab").addClass("active");
					$("#btn-mat-ide-pro-ran-eta").attr('disabled',false);

                	$("#iden-com-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.identificacion_comunidad')}}, false);");
                	$("#documentos-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.carta_compromiso_comunidad')}}, false);");
                	$("#lin-bas-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.linea_base')}}, false);");
					$("#mat-ide-pro-nna-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.matriz_identificación_problemas')}}, false);");
					$("#mat-ide-pro-ran-eta-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.matriz_priorización_problemas')}}, false);");
            	}
				$("#mat-ide-pro-ran-eta").show();
				//INICIO DC SPRINT 67
				$('#btn-mat-ide-pro-ran-eta').fadeIn(0);
				//FIN DC SPRINT 67
				// $("#ident_com-tab-ico").removeClass('text-light');
				// $("#ident_com-tab-ico").addClass('icon-success');
				// $("#document-tab-ico").removeClass('text-light');
				// $("#document-tab-ico").addClass('icon-success');
				// $("#lineBase-tab-ico").removeClass('text-light');
				// $("#lineBase-tab-ico").addClass('icon-success');
				// $("#matrizIdenPro-tab-ico").removeClass('text-light');
				// $("#matrizIdenPro-tab-ico").addClass('icon-success');
				// $("#matrizPrioPro-tab-ico").removeClass('text-light');
				// $("#matrizPrioPro-tab-ico").addClass('icon-success');
            break;

            case {{ config('constantes.matriz_factores_protectores') }}: // MATRIZ DE FACTORES PROTECTORES
            	//INICIO DC
            	$('#contenedor_listar_plan').fadeOut();
            	$('#contenedor_listar_linea').fadeOut(0);
				$('#contenedor_encuesta_prercepcion').fadeOut(0);
            	$('#contenedor_listar_informe').fadeOut(0);
            	$('#contenedor_introduccionInf').fadeOut(0);
            	$('#contenedor_eje_plan_est_comInf').fadeOut(0);
            	$('#contenedor_resultadosInf').fadeOut(0);
            	$('#contenedor_conclusiones_recomendacionesInf').fadeOut(0);
            	$('#contenedor_anexosInf').fadeOut(0);
            	$('#contenedor_matriz_factores').fadeIn(0);
            	//FIN DC
            	
				$("#iden-com-tab").removeClass("active");
				$("#iden-com-tab").removeClass("show");
				$("#ident-com-ges-com").hide();

				$("#documentos-tab").removeClass("active");
				$("#documentos-tab").removeClass("show");
				$("#doc-ges-com").hide();

				$("#lin-bas-tab").removeClass("active");
				$("#lin-bas-tab").removeClass("show");
				$("#linea-ges-com").hide();
				
				$("#mat-ide-pro-nna-tab").removeClass("active");
            	$("#mat-ide-pro-nna-tab").removeClass("show");
				$("#mat-ide-pro-nna").hide();

				$("#mat-ide-pro-ran-eta-tab").removeClass("active");
            	$("#mat-ide-pro-ran-eta-tab").removeClass("show");
				$("#mat-ide-pro-ran-eta").hide();

				$("#inf-dpc-tab").removeClass("active");
            	$("#inf-dpc-tab").removeClass("show");
				$("#inf_dpc").hide();
				// INICIO CZ SPRINT 55
				dataInformeDPC();
				$("#btn-mat-fac-pro").attr('disabled',true);
				// FIN CZ SPRINT 55
				if (inicial == true){
				    $("#documentos-tab").removeClass("des-hab-est");
				    $("#iden-com-tab").removeClass("des-hab-est");
				    $("#lin-bas-tab").removeClass("des-hab-est");
					$("#mat-ide-pro-nna-tab").removeClass("des-hab-est");
					$("#mat-ide-pro-ran-eta-tab").removeClass("des-hab-est");
				    $("#mat-fac-tab").removeClass("des-hab-est");

				    $("#mat-fac-tab").click();
				    $("#mat-fac-tab").focus();
				    $("#mat-fac-tab").addClass("active");
					$("#btn-mat-fac-pro").attr('disabled',false);

				    $("#iden-com-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.identificacion_comunidad')}}, false);");
				    $("#documentos-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.carta_compromiso_comunidad')}}, false);");
				    $("#lin-bas-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.linea_base')}}, false);");
					$("#mat-ide-pro-nna-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.matriz_identificación_problemas')}}, false);");
					$("#mat-ide-pro-ran-eta-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.matriz_priorización_problemas')}}, false);");
				    $("#mat-fac-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.matriz_factores_protectores')}}, false);");
				}

				listarMatrizFactores();
				$("#mat_fac_ges_com").show();
				// INICIO CZ SPRINT 67 correcion
				$(".close").fadeIn(0);	
				// FIN CZ SPRINT 67 correcion
				
				
				//INICIO DC SPRINT 67
				if({{ config('constantes.matriz_factores_protectores') }} == $('#est_pro_id').val() ){
            		$('#btn-mat-fac-pro').removeAttr('disabled');
            	}
            	//FIN DC SPRINT 67

				// $("#ident_com-tab-ico").removeClass('text-light');
				// $("#ident_com-tab-ico").addClass('icon-success');
				// $("#document-tab-ico").removeClass('text-light');
				// $("#document-tab-ico").addClass('icon-success');
				// $("#lineBase-tab-ico").removeClass('text-light');
				// $("#lineBase-tab-ico").addClass('icon-success');
				// $("#matrizIdenPro-tab-ico").removeClass('text-light');
				// $("#matrizIdenPro-tab-ico").addClass('icon-success');
				// $("#matrizPrioPro-tab-ico").removeClass('text-light');
				// $("#matrizPrioPro-tab-ico").addClass('icon-success');
				// $("#matrizFact-tab-ico").removeClass('text-light');
				// $("#matrizFact-tab-ico").addClass('icon-success');
				
			break;

			case {{ config('constantes.informe_dpc') }}: // INFORME DIAGNOSTICO PARTICIPATIVO COMUNITARIO
				//INICIO DC
				$('#contenedor_listar_plan').fadeOut();
				$('#contenedor_listar_linea').fadeOut(0);
				$('#contenedor_encuesta_prercepcion').fadeOut(0);
            	$('#contenedor_listar_informe').fadeOut(0);
            	$('#contenedor_introduccionInf').fadeOut(0);
            	$('#contenedor_eje_plan_est_comInf').fadeOut(0);
            	$('#contenedor_resultadosInf').fadeOut(0);
            	$('#contenedor_conclusiones_recomendacionesInf').fadeOut(0);
            	$('#contenedor_anexosInf').fadeOut(0);
				$('#contenedor_info_identificacion').fadeIn(0);
        		$('#contenedor_info_introduccion').fadeIn(0);
        		$('#contenedor_info_gurpo_accion').fadeIn(0);
        		$('#contenedor_info_ejec_diag_part').fadeIn(0);
        		$('#contenedor_info_resultados').fadeIn(0);
        		$('#contenedor_info_conclusiones').fadeIn(0);
        		$('#contenedor_info_anexos').fadeIn(0);
        		//FIN DC
			
				$("#iden-com-tab").removeClass("active");
				$("#iden-com-tab").removeClass("show");
				$("#ident-com-ges-com").hide();

				$("#documentos-tab").removeClass("active");
				$("#documentos-tab").removeClass("show");
				$("#doc-ges-com").hide();

				$("#lin-bas-tab").removeClass("active");
				$("#lin-bas-tab").removeClass("show");
				$("#linea-ges-com").hide();
				
				$("#mat-ide-pro-nna-tab").removeClass("active");
            	$("#mat-ide-pro-nna-tab").removeClass("show");
				$("#mat-ide-pro-nna").hide();

				$("#mat-ide-pro-ran-eta-tab").removeClass("active");
            	$("#mat-ide-pro-ran-eta-tab").removeClass("show");
				$("#mat-ide-pro-ran-eta").hide();

				$("#mat-fac-tab").removeClass("active");
            	$("#mat-fac-tab").removeClass("show");
				$("#mat_fac_ges_com").hide();
				// INICIO CZ SPRINT 67
				$('#cerrar-modal-confirm').fadeIn(0);
				$('#btnConfimAnexo').fadeIn(0);
				// FIN CZ SPRINT 67
				if (inicial == true){
				    $("#documentos-tab").removeClass("des-hab-est");
				    $("#iden-com-tab").removeClass("des-hab-est");
				    $("#lin-bas-tab").removeClass("des-hab-est");
					$("#mat-ide-pro-nna-tab").removeClass("des-hab-est");
					$("#mat-ide-pro-ran-eta-tab").removeClass("des-hab-est");
				    $("#mat-fac-tab").removeClass("des-hab-est");
					$("#inf-dpc-tab").removeClass("des-hab-est");

				    $("#inf-dpc-tab").click();
				    $("#inf-dpc-tab").focus();
				    $("#inf-dpc-tab").addClass("active");
					$("#btn-inf-dia-par-com").attr('disabled',false);

				    $("#iden-com-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.identificacion_comunidad')}}, false);");
				    $("#documentos-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.carta_compromiso_comunidad')}}, false);");
				    $("#lin-bas-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.linea_base')}}, false);");
					$("#mat-ide-pro-nna-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.matriz_identificación_problemas')}}, false);");
					$("#mat-ide-pro-ran-eta-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.matriz_priorización_problemas')}}, false);");
					$("#mat-fac-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.matriz_factores_protectores')}}, false);");
					$("#inf-dpc-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.informe_dpc')}}, false);");
				}

				dataInformeDPC();
				$("#inf_dpc").show();

				// $("#ident_com-tab-ico").removeClass('text-light');
				// $("#ident_com-tab-ico").addClass('icon-success');
				// $("#document-tab-ico").removeClass('text-light');
				// $("#document-tab-ico").addClass('icon-success');
				// $("#lineBase-tab-ico").removeClass('text-light');
				// $("#lineBase-tab-ico").addClass('icon-success');
				// $("#matrizIdenPro-tab-ico").removeClass('text-light');
				// $("#matrizIdenPro-tab-ico").addClass('icon-success');
				// $("#matrizPrioPro-tab-ico").removeClass('text-light');
				// $("#matrizPrioPro-tab-ico").addClass('icon-success');
				// $("#matrizFact-tab-ico").removeClass('text-light');
				// $("#matrizFact-tab-ico").addClass('icon-success');
				// $("#infodpc-tab-ico").removeClass('text-light');
				// $("#infodpc-tab-ico").addClass('icon-success');

			break;
			case {{ config('constantes.plan_estrategico') }}: // PLAN ESTRATEGICO COMUNITARIO
			$("#documentos-tab").removeClass("active");
            	$("#documentos-tab").removeClass("show");
            	$("#doc-ges-com").hide();

            	$("#lin-bas-tab").removeClass("active");
            	$("#lin-bas-tab").removeClass("show");
            	$("#linea-ges-com").hide();

				$("#mat-ide-pro-nna-tab").removeClass("active");
            	$("#mat-ide-pro-nna-tab").removeClass("show");
				$("#mat-ide-pro-nna").hide();

				$("#mat-ide-pro-ran-eta-tab").removeClass("active");
            	$("#mat-ide-pro-ran-eta-tab").removeClass("show");
				$("#mat-ide-pro-ran-eta").hide();

				$("#mat-fac-tab").removeClass("active");
            	$("#mat-fac-tab").removeClass("show");
				$("#mat_fac_ges_com").hide();

				$("#inf-dpc-tab").removeClass("active");
            	$("#inf-dpc-tab").removeClass("show");
				$("#inf_dpc").hide();

				if (inicial == true){
				    $("#documentos-tab").removeClass("des-hab-est");
					$("#iden-com-tab").removeClass("des-hab-est");
					$("#lin-bas-tab").removeClass("des-hab-est");
					$("#mat-ide-pro-nna-tab").removeClass("des-hab-est");
					$("#mat-ide-pro-ran-eta-tab").removeClass("des-hab-est");
					$("#mat-fac-tab").removeClass("des-hab-est");
					$("#inf-dpc-tab").removeClass("des-hab-est");

				    $("#iden-com-tab").click();
                	$("#iden-com-tab").focus();
            		$("#iden-com-tab").addClass("active");

					$("#iden-com-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.identificacion_comunidad')}}, false);");
				    $("#documentos-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.carta_compromiso_comunidad')}}, false);");
					$("#lin-bas-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.linea_base')}}, false);");
					$("#mat-ide-pro-nna-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.matriz_identificación_problemas')}}, false);");
					$("#mat-ide-pro-ran-eta-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.matriz_priorización_problemas')}}, false);");
					$("#mat-fac-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.matriz_factores_protectores')}}, false);");
					$("#inf-dpc-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.informe_dpc')}}, false);");
					
				}

				// $("#ident_com-tab-ico").removeClass('text-light');
				// $("#ident_com-tab-ico").addClass('icon-success');
				// $("#document-tab-ico").removeClass('text-light');
				// $("#document-tab-ico").addClass('icon-success');
				// $("#lineBase-tab-ico").removeClass('text-light');
				// $("#lineBase-tab-ico").addClass('icon-success');
				// $("#matrizIdenPro-tab-ico").removeClass('text-light');
				// $("#matrizIdenPro-tab-ico").addClass('icon-success');
				// $("#matrizPrioPro-tab-ico").removeClass('text-light');
				// $("#matrizPrioPro-tab-ico").addClass('icon-success');
				// $("#matrizFact-tab-ico").removeClass('text-light');
				// $("#matrizFact-tab-ico").addClass('icon-success');
				// $("#infodpc-tab-ico").removeClass('text-light');
				// $("#infodpc-tab-ico").addClass('icon-success');
				// $("#plan-est-tab-ico").removeClass('text-light');
				// $("#plan-est-tab-ico").addClass('icon-success');
			break;
			
			case {{ config('constantes.linea_salida') }}: // LINEA DE SALIDA
				// INICIO CZ SPRINT 70
				$(".btn_lb_guardar").css("display","inline");
				$(".cerrar_modal_linea_base").css("display","inline");
				// FIN CZ SPRINT 70
			$("#documentos-tab").removeClass("active");
            	$("#documentos-tab").removeClass("show");
            	$("#doc-ges-com").hide();

            	$("#lin-bas-tab").removeClass("active");
            	$("#lin-bas-tab").removeClass("show");
            	$("#linea-ges-com").hide();

				$("#mat-ide-pro-nna-tab").removeClass("active");
            	$("#mat-ide-pro-nna-tab").removeClass("show");
				$("#mat-ide-pro-nna").hide();

				$("#mat-ide-pro-ran-eta-tab").removeClass("active");
            	$("#mat-ide-pro-ran-eta-tab").removeClass("show");
				$("#mat-ide-pro-ran-eta").hide();

				$("#mat-fac-tab").removeClass("active");
            	$("#mat-fac-tab").removeClass("show");
				$("#mat_fac_ges_com").hide();

				$("#inf-dpc-tab").removeClass("active");
            	$("#inf-dpc-tab").removeClass("show");
				$("#inf_dpc").hide();

				if (inicial == true){
				    $("#documentos-tab").removeClass("des-hab-est");
					$("#iden-com-tab").removeClass("des-hab-est");
					$("#lin-bas-tab").removeClass("des-hab-est");
					$("#mat-ide-pro-nna-tab").removeClass("des-hab-est");
					$("#mat-ide-pro-ran-eta-tab").removeClass("des-hab-est");
					$("#mat-fac-tab").removeClass("des-hab-est");
					$("#inf-dpc-tab").removeClass("des-hab-est");

				    $("#iden-com-tab").click();
                	$("#iden-com-tab").focus();
            		$("#iden-com-tab").addClass("active");

					$("#iden-com-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.identificacion_comunidad')}}, false);");
				    $("#documentos-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.carta_compromiso_comunidad')}}, false);");
					$("#lin-bas-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.linea_base')}}, false);");
					$("#mat-ide-pro-nna-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.matriz_identificación_problemas')}}, false);");
					$("#mat-ide-pro-ran-eta-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.matriz_priorización_problemas')}}, false);");
					$("#mat-fac-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.matriz_factores_protectores')}}, false);");
					$("#inf-dpc-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.informe_dpc')}}, false);");
				}

				// $("#ident_com-tab-ico").removeClass('text-light');
				// $("#ident_com-tab-ico").addClass('icon-success');
				// $("#document-tab-ico").removeClass('text-light');
				// $("#document-tab-ico").addClass('icon-success');
				// $("#lineBase-tab-ico").removeClass('text-light');
				// $("#lineBase-tab-ico").addClass('icon-success');
				// $("#matrizIdenPro-tab-ico").removeClass('text-light');
				// $("#matrizIdenPro-tab-ico").addClass('icon-success');
				// $("#matrizPrioPro-tab-ico").removeClass('text-light');
				// $("#matrizPrioPro-tab-ico").addClass('icon-success');
				// $("#matrizFact-tab-ico").removeClass('text-light');
				// $("#matrizFact-tab-ico").addClass('icon-success');
				// $("#infodpc-tab-ico").removeClass('text-light');
				// $("#infodpc-tab-ico").addClass('icon-success');
				// $("#plan-est-tab-ico").removeClass('text-light');
				// $("#plan-est-tab-ico").addClass('icon-success');
				// $("#line-salid-tab-ico").removeClass('text-light');
				// $("#line-salid-tab-ico").addClass('icon-success');

			break;
			
			case {{ config('constantes.informe_plan_estrategico') }}: // INFORME PLAN ESTRATEGICO
			$("#documentos-tab").removeClass("active");
            	$("#documentos-tab").removeClass("show");
            	$("#doc-ges-com").hide();

            	$("#lin-bas-tab").removeClass("active");
            	$("#lin-bas-tab").removeClass("show");
            	$("#linea-ges-com").hide();

				$("#mat-ide-pro-nna-tab").removeClass("active");
            	$("#mat-ide-pro-nna-tab").removeClass("show");
				$("#mat-ide-pro-nna").hide();

				$("#mat-ide-pro-ran-eta-tab").removeClass("active");
            	$("#mat-ide-pro-ran-eta-tab").removeClass("show");
				$("#mat-ide-pro-ran-eta").hide();

				$("#mat-fac-tab").removeClass("active");
            	$("#mat-fac-tab").removeClass("show");
				$("#mat_fac_ges_com").hide();

				$("#inf-dpc-tab").removeClass("active");
            	$("#inf-dpc-tab").removeClass("show");
				$("#inf_dpc").hide();

				if (inicial == true){
				    $("#documentos-tab").removeClass("des-hab-est");
					$("#iden-com-tab").removeClass("des-hab-est");
					$("#lin-bas-tab").removeClass("des-hab-est");
					$("#mat-ide-pro-nna-tab").removeClass("des-hab-est");
					$("#mat-ide-pro-ran-eta-tab").removeClass("des-hab-est");
					$("#mat-fac-tab").removeClass("des-hab-est");
					$("#inf-dpc-tab").removeClass("des-hab-est");

				    $("#iden-com-tab").click();
                	$("#iden-com-tab").focus();
            		$("#iden-com-tab").addClass("active");

					$("#iden-com-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.identificacion_comunidad')}}, false);");
				    $("#documentos-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.carta_compromiso_comunidad')}}, false);");
					$("#lin-bas-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.linea_base')}}, false);");
					$("#mat-ide-pro-nna-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.matriz_identificación_problemas')}}, false);");
					$("#mat-ide-pro-ran-eta-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.matriz_priorización_problemas')}}, false);");
					$("#mat-fac-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.matriz_factores_protectores')}}, false);");
					$("#inf-dpc-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.informe_dpc')}}, false);");
				}

				// $("#ident_com-tab-ico").removeClass('text-light');
				// $("#ident_com-tab-ico").addClass('icon-success');
				// $("#document-tab-ico").removeClass('text-light');
				// $("#document-tab-ico").addClass('icon-success');
				// $("#lineBase-tab-ico").removeClass('text-light');
				// $("#lineBase-tab-ico").addClass('icon-success');
				// $("#matrizIdenPro-tab-ico").removeClass('text-light');
				// $("#matrizIdenPro-tab-ico").addClass('icon-success');
				// $("#matrizPrioPro-tab-ico").removeClass('text-light');
				// $("#matrizPrioPro-tab-ico").addClass('icon-success');
				// $("#matrizFact-tab-ico").removeClass('text-light');
				// $("#matrizFact-tab-ico").addClass('icon-success');
				// $("#infodpc-tab-ico").removeClass('text-light');
				// $("#infodpc-tab-ico").addClass('icon-success');
				// $("#plan-est-tab-ico").removeClass('text-light');
				// $("#plan-est-tab-ico").addClass('icon-success');
				// $("#line-salid-tab-ico").removeClass('text-light');
				// $("#line-salid-tab-ico").addClass('icon-success');
				// $("#info-pec-tab-ico").removeClass('text-light');
				// $("#info-pec-tab-ico").addClass('icon-success');

			break;
			//INICIO DC
			case {{ config('constantes.desestimado') }}: //DESESTIMADO
				$('#desestimado').val(1);
				
				$("#documentos-tab").removeClass("active");
            	$("#documentos-tab").removeClass("show");
            	$("#doc-ges-com").hide();

            	$("#lin-bas-tab").removeClass("active");
            	$("#lin-bas-tab").removeClass("show");
            	$("#linea-ges-com").hide();

				$("#mat-ide-pro-nna-tab").removeClass("active");
            	$("#mat-ide-pro-nna-tab").removeClass("show");
				$("#mat-ide-pro-nna").hide();

				$("#mat-ide-pro-ran-eta-tab").removeClass("active");
            	$("#mat-ide-pro-ran-eta-tab").removeClass("show");
				$("#mat-ide-pro-ran-eta").hide();

				$("#mat-fac-tab").removeClass("active");
            	$("#mat-fac-tab").removeClass("show");
				$("#mat_fac_ges_com").hide();

				$("#inf-dpc-tab").removeClass("active");
            	$("#inf-dpc-tab").removeClass("show");
				$("#inf_dpc").hide();

				if (inicial == true){
				    $("#documentos-tab").removeClass("des-hab-est");
					$("#iden-com-tab").removeClass("des-hab-est");
					$("#lin-bas-tab").removeClass("des-hab-est");
					$("#mat-ide-pro-nna-tab").removeClass("des-hab-est");
					$("#mat-ide-pro-ran-eta-tab").removeClass("des-hab-est");
					$("#mat-fac-tab").removeClass("des-hab-est");
					$("#inf-dpc-tab").removeClass("des-hab-est");

				    $("#iden-com-tab").click();
                	$("#iden-com-tab").focus();
            		$("#iden-com-tab").addClass("active");

					$("#iden-com-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.identificacion_comunidad')}}, false);");
				    $("#documentos-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.carta_compromiso_comunidad')}}, false);");
					$("#lin-bas-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.linea_base')}}, false);");
					$("#mat-ide-pro-nna-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.matriz_identificación_problemas')}}, false);");
					$("#mat-ide-pro-ran-eta-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.matriz_priorización_problemas')}}, false);");
					$("#mat-fac-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.matriz_factores_protectores')}}, false);");
					$("#inf-dpc-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.informe_dpc')}}, false);");
				}
				$('input').attr('disabled', 'disabled');
				$('select').attr('disabled', 'disabled');
				$('textarea').attr('disabled', 'disabled');
				$("button").prop('disabled', true);
				// INICIO CZ SPRINT 67 correccion
				$('.close').removeAttr('disabled');
				$(".close").prop('disabled', false);
				$(".close").fadeIn(0);	
				// FIN CZ SPRINT 67 correccion
				$('.btnExcelIde').removeAttr('disabled');
				$('.btnMatPri').removeAttr('disabled');
				$('.matFact').removeAttr('disabled');
				$("#inf_dpc").show();
			break;
			
			case {{ config('constantes.finalizado') }}: //FINALIZADO
				$('#desestimado').val(1);
				
				$("#documentos-tab").removeClass("active");
            	$("#documentos-tab").removeClass("show");
            	$("#doc-ges-com").hide();

            	$("#lin-bas-tab").removeClass("active");
            	$("#lin-bas-tab").removeClass("show");
            	$("#linea-ges-com").hide();

				$("#mat-ide-pro-nna-tab").removeClass("active");
            	$("#mat-ide-pro-nna-tab").removeClass("show");
				$("#mat-ide-pro-nna").hide();

				$("#mat-ide-pro-ran-eta-tab").removeClass("active");
            	$("#mat-ide-pro-ran-eta-tab").removeClass("show");
				$("#mat-ide-pro-ran-eta").hide();

				$("#mat-fac-tab").removeClass("active");
            	$("#mat-fac-tab").removeClass("show");
				$("#mat_fac_ges_com").hide();

				$("#inf-dpc-tab").removeClass("active");
            	$("#inf-dpc-tab").removeClass("show");
				$("#inf_dpc").hide();

				if (inicial == true){
				    $("#documentos-tab").removeClass("des-hab-est");
					$("#iden-com-tab").removeClass("des-hab-est");
					$("#lin-bas-tab").removeClass("des-hab-est");
					$("#mat-ide-pro-nna-tab").removeClass("des-hab-est");
					$("#mat-ide-pro-ran-eta-tab").removeClass("des-hab-est");
					$("#mat-fac-tab").removeClass("des-hab-est");
					$("#inf-dpc-tab").removeClass("des-hab-est");

				    $("#iden-com-tab").click();
                	$("#iden-com-tab").focus();
            		$("#iden-com-tab").addClass("active");

					$("#iden-com-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.identificacion_comunidad')}}, false);");
				    $("#documentos-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.carta_compromiso_comunidad')}}, false);");
					$("#lin-bas-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.linea_base')}}, false);");
					$("#mat-ide-pro-nna-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.matriz_identificación_problemas')}}, false);");
					$("#mat-ide-pro-ran-eta-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.matriz_priorización_problemas')}}, false);");
					$("#mat-fac-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.matriz_factores_protectores')}}, false);");
					$("#inf-dpc-tab").attr("onclick", "desplegarGestionComunitaria({{config('constantes.informe_dpc')}}, false);");
				}
				$('input').attr('disabled', 'disabled');
				$('select').attr('disabled', 'disabled');
				$('textarea').attr('disabled', 'disabled');
				// $('button').attr('disabled', 'disabled');
				$("button").prop('disabled', true);
				// INICIO CZ SPRINT 67 correccion
				$('.close').removeAttr('disabled');
				$(".close").prop('disabled', false);
				$(".close").fadeIn(0);				
				// FIN CZ SPRINT 67 correccion
				$('.btnExcelIde').removeAttr('disabled');
				$('.btnMatPri').removeAttr('disabled');
				$('.matFact').removeAttr('disabled');
				$("#inf_dpc").show();

				// $("#ident_com-tab-ico").removeClass('text-light');
				// $("#ident_com-tab-ico").addClass('icon-success');
				// $("#document-tab-ico").removeClass('text-light');
				// $("#document-tab-ico").addClass('icon-success');
				// $("#lineBase-tab-ico").removeClass('text-light');
				// $("#lineBase-tab-ico").addClass('icon-success');
				// $("#matrizIdenPro-tab-ico").removeClass('text-light');
				// $("#matrizIdenPro-tab-ico").addClass('icon-success');
				// $("#matrizPrioPro-tab-ico").removeClass('text-light');
				// $("#matrizPrioPro-tab-ico").addClass('icon-success');
				// $("#matrizFact-tab-ico").removeClass('text-light');
				// $("#matrizFact-tab-ico").addClass('icon-success');
				// $("#infodpc-tab-ico").removeClass('text-light');
				// $("#infodpc-tab-ico").addClass('icon-success');
				// $("#plan-est-tab-ico").removeClass('text-light');
				// $("#plan-est-tab-ico").addClass('icon-success');
				// $("#line-salid-tab-ico").removeClass('text-light');
				// $("#line-salid-tab-ico").addClass('icon-success');
				// $("#info-pec-tab-ico").removeClass('text-light');
				// $("#info-pec-tab-ico").addClass('icon-success');
				
			break;
			//FIN DC

        }
	
    }

	function colorCheck(){
		console.log("aca entro");
		
		var estado = parseInt($("#est_pro_id").val());
        switch(estado){

            case {{ config('constantes.identificacion_comunidad') }}: //IDENTIFICACION DE LA COMUNIDAD
				$("#ident_com-tab-ico").removeClass('text-light');
				$("#ident_com-tab-ico").addClass('icon-success');
            break;

            case {{ config('constantes.carta_compromiso_comunidad') }}: //CARTA DE COMPROMISO DE COMUNIDAD
            	$("#ident_com-tab-ico").removeClass('text-light');
				$("#ident_com-tab-ico").addClass('icon-success');
				$("#document-tab-ico").removeClass('text-light');
				$("#document-tab-ico").addClass('icon-success');
            break;

            case {{ config('constantes.linea_base') }}: //LINEA BASE
				console.log("aca entro lb");
				$("#ident_com-tab-ico").removeClass('text-light');
				$("#ident_com-tab-ico").addClass('icon-success');
				$("#document-tab-ico").removeClass('text-light');
				$("#document-tab-ico").addClass('icon-success');
				$("#lineBase-tab-ico").removeClass('text-light');
				$("#lineBase-tab-ico").addClass('icon-success');
            break;

			case {{ config('constantes.matriz_identificación_problemas') }}: //MATRIZ IDENTIFICACIÓN DE PROBLEMAS QUE CONSTITUYEN UN FACTOR DE RIESGO PARA LOS NNA
				$("#ident_com-tab-ico").removeClass('text-light');
				$("#ident_com-tab-ico").addClass('icon-success');
				$("#document-tab-ico").removeClass('text-light');
				$("#document-tab-ico").addClass('icon-success');
				$("#lineBase-tab-ico").removeClass('text-light');
				$("#lineBase-tab-ico").addClass('icon-success');
				$("#matrizIdenPro-tab-ico").removeClass('text-light');
				$("#matrizIdenPro-tab-ico").addClass('icon-success');
            break;

			case {{ config('constantes.matriz_priorización_problemas') }}: //MATRIZ DE PRIORIZACIÓN DE PROBLEMAS POR RANGO ETARIO
				$("#ident_com-tab-ico").removeClass('text-light');
				$("#ident_com-tab-ico").addClass('icon-success');
				$("#document-tab-ico").removeClass('text-light');
				$("#document-tab-ico").addClass('icon-success');
				$("#lineBase-tab-ico").removeClass('text-light');
				$("#lineBase-tab-ico").addClass('icon-success');
				$("#matrizIdenPro-tab-ico").removeClass('text-light');
				$("#matrizIdenPro-tab-ico").addClass('icon-success');
				$("#matrizPrioPro-tab-ico").removeClass('text-light');
				$("#matrizPrioPro-tab-ico").addClass('icon-success');
            break;

            case {{ config('constantes.matriz_factores_protectores') }}: // MATRIZ DE FACTORES PROTECTORES

				$("#ident_com-tab-ico").removeClass('text-light');
				$("#ident_com-tab-ico").addClass('icon-success');
				$("#document-tab-ico").removeClass('text-light');
				$("#document-tab-ico").addClass('icon-success');
				$("#lineBase-tab-ico").removeClass('text-light');
				$("#lineBase-tab-ico").addClass('icon-success');
				$("#matrizIdenPro-tab-ico").removeClass('text-light');
				$("#matrizIdenPro-tab-ico").addClass('icon-success');
				$("#matrizPrioPro-tab-ico").removeClass('text-light');
				$("#matrizPrioPro-tab-ico").addClass('icon-success');
				$("#matrizFact-tab-ico").removeClass('text-light');
				$("#matrizFact-tab-ico").addClass('icon-success');
				
			break;
			
			case {{ config('constantes.informe_dpc') }}: // INFORME DIAGNOSTICO PARTICIPATIVO COMUNITARIO
				
				$("#ident_com-tab-ico").removeClass('text-light');
				$("#ident_com-tab-ico").addClass('icon-success');
				$("#document-tab-ico").removeClass('text-light');
				$("#document-tab-ico").addClass('icon-success');
				$("#lineBase-tab-ico").removeClass('text-light');
				$("#lineBase-tab-ico").addClass('icon-success');
				$("#matrizIdenPro-tab-ico").removeClass('text-light');
				$("#matrizIdenPro-tab-ico").addClass('icon-success');
				$("#matrizPrioPro-tab-ico").removeClass('text-light');
				$("#matrizPrioPro-tab-ico").addClass('icon-success');
				$("#matrizFact-tab-ico").removeClass('text-light');
				$("#matrizFact-tab-ico").addClass('icon-success');
				$("#infodpc-tab-ico").removeClass('text-light');
				$("#infodpc-tab-ico").addClass('icon-success');

			break;
		
			case '2': // PLAN ESTRATEGICO COMUNITARIO
				$("#ident_com-tab-ico").removeClass('text-light');
				$("#ident_com-tab-ico").addClass('icon-success');
				$("#document-tab-ico").removeClass('text-light');
				$("#document-tab-ico").addClass('icon-success');
				$("#lineBase-tab-ico").removeClass('text-light');
				$("#lineBase-tab-ico").addClass('icon-success');
				$("#matrizIdenPro-tab-ico").removeClass('text-light');
				$("#matrizIdenPro-tab-ico").addClass('icon-success');
				$("#matrizPrioPro-tab-ico").removeClass('text-light');
				$("#matrizPrioPro-tab-ico").addClass('icon-success');
				$("#matrizFact-tab-ico").removeClass('text-light');
				$("#matrizFact-tab-ico").addClass('icon-success');
				$("#infodpc-tab-ico").removeClass('text-light');
				$("#infodpc-tab-ico").addClass('icon-success');
				$("#plan-est-tab-ico").removeClass('text-light');
				$("#plan-est-tab-ico").addClass('icon-success');
				
				
			break;

			case '11': // PLAN ESTRATEGICO COMUNITARIO
				$("#ident_com-tab-ico").removeClass('text-light');
				$("#ident_com-tab-ico").addClass('icon-success');
				$("#document-tab-ico").removeClass('text-light');
				$("#document-tab-ico").addClass('icon-success');
				$("#lineBase-tab-ico").removeClass('text-light');
				$("#lineBase-tab-ico").addClass('icon-success');
				$("#matrizIdenPro-tab-ico").removeClass('text-light');
				$("#matrizIdenPro-tab-ico").addClass('icon-success');
				$("#matrizPrioPro-tab-ico").removeClass('text-light');
				$("#matrizPrioPro-tab-ico").addClass('icon-success');
				$("#matrizFact-tab-ico").removeClass('text-light');
				$("#matrizFact-tab-ico").addClass('icon-success');
				$("#infodpc-tab-ico").removeClass('text-light');
				$("#infodpc-tab-ico").addClass('icon-success');
				$("#plan-est-tab-ico").removeClass('text-light');
				$("#plan-est-tab-ico").addClass('icon-success');
				$("#line-salid-tab-ico").removeClass('text-light');
				$("#line-salid-tab-ico").addClass('icon-success');
			break;

			case '12': // PLAN ESTRATEGICO COMUNITARIO
				$("#ident_com-tab-ico").removeClass('text-light');
				$("#ident_com-tab-ico").addClass('icon-success');
				$("#document-tab-ico").removeClass('text-light');
				$("#document-tab-ico").addClass('icon-success');
				$("#lineBase-tab-ico").removeClass('text-light');
				$("#lineBase-tab-ico").addClass('icon-success');
				$("#matrizIdenPro-tab-ico").removeClass('text-light');
				$("#matrizIdenPro-tab-ico").addClass('icon-success');
				$("#matrizPrioPro-tab-ico").removeClass('text-light');
				$("#matrizPrioPro-tab-ico").addClass('icon-success');
				$("#matrizFact-tab-ico").removeClass('text-light');
				$("#matrizFact-tab-ico").addClass('icon-success');
				$("#infodpc-tab-ico").removeClass('text-light');
				$("#infodpc-tab-ico").addClass('icon-success');
				$("#plan-est-tab-ico").removeClass('text-light');
				$("#plan-est-tab-ico").addClass('icon-success');
				$("#line-salid-tab-ico").removeClass('text-light');
				$("#line-salid-tab-ico").addClass('icon-success');
				$("#info-pec-tab-ico").removeClass('text-light');
				$("#info-pec-tab-ico").addClass('icon-success');
				
				
			break;

			case {{ config('constantes.finalizado') }}: //FINALIZADO
				$("#ident_com-tab-ico").removeClass('text-light');
				$("#ident_com-tab-ico").addClass('icon-success');
				$("#document-tab-ico").removeClass('text-light');
				$("#document-tab-ico").addClass('icon-success');
				$("#lineBase-tab-ico").removeClass('text-light');
				$("#lineBase-tab-ico").addClass('icon-success');
				$("#matrizIdenPro-tab-ico").removeClass('text-light');
				$("#matrizIdenPro-tab-ico").addClass('icon-success');
				$("#matrizPrioPro-tab-ico").removeClass('text-light');
				$("#matrizPrioPro-tab-ico").addClass('icon-success');
				$("#matrizFact-tab-ico").removeClass('text-light');
				$("#matrizFact-tab-ico").addClass('icon-success');
				$("#infodpc-tab-ico").removeClass('text-light');
				$("#infodpc-tab-ico").addClass('icon-success');
				$("#plan-est-tab-ico").removeClass('text-light');
				$("#plan-est-tab-ico").addClass('icon-success');
				$("#line-salid-tab-ico").removeClass('text-light');
				$("#line-salid-tab-ico").addClass('icon-success');
				$("#info-pec-tab-ico").removeClass('text-light');
				$("#info-pec-tab-ico").addClass('icon-success');
				
			break;
        }
    }

    function siguienteEtapaGestionComunitaria(estado){
    	
		
    	
        switch(estado){
            case {{ config('constantes.carta_compromiso_comunidad') }}: //CARTA DE COMPROMISO DE COMUNIDAD
            	$("#ident-com-ges-com").hide();
				$("#btn-ident-com-ges-com").attr('disabled',true);
                $("#documentos-tab").removeClass("des-hab-est");

                $("#documentos-tab").click();
                $("#documentos-tab").focus();
                $("#documentos-tab").addClass("active");

            	$("#doc-ges-com").show();
				//INICIO DC
				$('.fechaPlazo').fadeOut(0);
				//FIN DC
				// INICIO CZ SPRINT 67
				$(". validar-btnEtapa").css("display","none");
				if(estado == 2){
					$("#validar-btnEtapa").attr('disabled',false);
				}
				// FIN CZ SPRINT 67
               	$("#documentos-tab").attr("onclick", "desplegarGestionComunitaria({{ config('constantes.carta_compromiso_comunidad') }});");
            break;

            case {{ config('constantes.linea_base') }}: //LINEA BASE
            	// INICIO CZ SPRINT 55
				// $("#doc-ges-com").hide();
                //FIN CZ SPRINT 55
                $("#lin-bas-tab").removeClass("des-hab-est");

				// INICIO CZ SPRINT 55
                // $("#lin-bas-tab").click();
                // $("#lin-bas-tab").focus();
                //$("#lin-bas-tab").addClass("active");
                //$("#linea-ges-com").show();
				//FIN CZ SPRINT 55
				$("#btn-linea-ges-com").attr('disabled',false);
  
               	$("#lin-bas-tab").attr("onclick", "desplegarGestionComunitaria({{ config('constantes.linea_base') }});");
				   
            break;

			case {{ config('constantes.matriz_identificación_problemas') }}: //MATRIZ INDENTIFICACIÓN DE PROBLEMAS
            	$("#linea-ges-com").hide();
				$("#btn-linea-ges-com").attr('disabled',true);
                $("#mat-ide-pro-nna-tab").removeClass("des-hab-est");


                $("#mat-ide-pro-nna-tab").click();
                $("#mat-ide-pro-nna-tab").focus();
                $("#mat-ide-pro-nna-tab").addClass("active");

                $("#mat-ide-pro-nna").show();
				$("#btn-mat-ide-pro-nna").attr('disabled',false);
  
               	$("#mat-ide-pro-nna-tab").attr("onclick", "desplegarGestionComunitaria({{ config('constantes.matriz_identificación_problemas') }});");

            break;

			case {{ config('constantes.matriz_priorización_problemas') }}: //MATRIZ DE PRIORIZACIÓN DE PROBLEMAS POR RANGO ETARIO
            	$("#mat-ide-pro-nna").hide();
				$("#btn-mat-ide-pro-nna").attr('disabled',true);
                $("#mat-ide-pro-ran-eta-tab").removeClass("des-hab-est");


                $("#mat-ide-pro-ran-eta-tab").click();
                $("#mat-ide-pro-ran-eta-tab").focus();
                $("#mat-ide-pro-ran-eta-tab").addClass("active");

                $("#mat-ide-pro-ran-eta").show();
				$("#btn-mat-ide-pro-ran-eta").attr('disabled',false);
  
               	$("#mat-ide-pro-ran-eta-tab").attr("onclick", "desplegarGestionComunitaria({{ config('constantes.matriz_priorización_problemas') }});");
               	//INICIO DC
            	$('#editar_pri').val(1);
            	//FIN DC
            break;

			case {{ config('constantes.matriz_factores_protectores') }}: // MATRIZ DE FACTORES PROTECTORES
            	//INICIO DC
            	$('#editar_pri').val(0);
            	//FIN DC
            	$("#mat-ide-pro-ran-eta").hide();
				$("#btn-mat-ide-pro-ran-eta").attr('disabled',false);
				$("#btn-mat-fac-pro").attr('disabled',false);
                $("#mat-fac-tab").removeClass("des-hab-est");


                $("#mat-fac-tab").click();
                $("#mat-fac-tab").focus();
                $("#mat-fac-tab").addClass("active");

                $("#mat_fac_ges_com").show();
  
               	$("#mat-fac-tab").attr("onclick", "desplegarGestionComunitaria({{ config('constantes.matriz_factores_protectores') }});");
            	//INICIO DC SPRINT 67
            	listarMatrizFactores();
            	//FIN DC SPRINT 67

            break;

			case {{ config('constantes.informe_dpc') }}: // INFORME DIAGNOSTICO PARTICIPATIVO
            	$("#mat_fac_ges_com").hide();
				$("#btn-mat-fac-pro").attr('disabled',true);
				$("#btn-inf-dia-par-com").attr('disabled',false);
                $("#inf-dpc-tab").removeClass("des-hab-est");


                $("#inf-dpc-tab").click();
                $("#inf-dpc-tab").focus();
                $("#inf-dpc-tab").addClass("active");

                $("#inf_dpc").show();
  
               	$("#inf-dpc-tab").attr("onclick", "desplegarGestionComunitaria({{ config('constantes.informe_dpc') }});");
            break;

			case {{ config('constantes.plan_estrategico') }}: // PLAN ESTRATEGICO
				$("#iden-com-tab").click();
                $("#iden-com-tab").focus();
                $("#iden-com-tab").addClass("active");

            break;
        }

        $('html, body').animate({scrollTop:80}, 'slow');
    }

	function cambiarColorCheck(estado){
		console.log(estado);
		console.log("{{ config('constantes.carta_compromiso_comunidad') }}");

		switch(estado){

            case {{ config('constantes.carta_compromiso_comunidad') }}: //CARTA DE COMPROMISO DE COMUNIDAD
				$("#ident_com-tab-ico").removeClass('text-light');
				$("#ident_com-tab-ico").addClass('icon-success');
				$("#document-tab-ico").removeClass('text-light');
				$("#document-tab-ico").addClass('icon-success');
		
            break;
			case {{ config('constantes.linea_base') }}: //LINEA BASE
				console.log("aca entro lb");
				$("#ident_com-tab-ico").removeClass('text-light');
				$("#ident_com-tab-ico").addClass('icon-success');
				$("#document-tab-ico").removeClass('text-light');
				$("#document-tab-ico").addClass('icon-success');
				$("#lineBase-tab-ico").removeClass('text-light');
				$("#lineBase-tab-ico").addClass('icon-success');
				$("#ident_com-tab-ico").removeClass('text-light');
				$("#ident_com-tab-ico").addClass('icon-success');
				$("#document-tab-ico").removeClass('text-light');
				$("#document-tab-ico").addClass('icon-success');
				$("#lineBase-tab-ico").removeClass('text-light');
				$("#lineBase-tab-ico").addClass('icon-success');

				   
            break;

			case {{ config('constantes.matriz_identificación_problemas') }}: //MATRIZ INDENTIFICACIÓN DE PROBLEMAS

				$("#ident_com-tab-ico").removeClass('text-light');
				$("#ident_com-tab-ico").addClass('icon-success');
				$("#document-tab-ico").removeClass('text-light');
				$("#document-tab-ico").addClass('icon-success');
				$("#lineBase-tab-ico").removeClass('text-light');
				$("#lineBase-tab-ico").addClass('icon-success');
				$("#ident_com-tab-ico").removeClass('text-light');
				$("#ident_com-tab-ico").addClass('icon-success');
				$("#document-tab-ico").removeClass('text-light');
				$("#document-tab-ico").addClass('icon-success');
				$("#lineBase-tab-ico").removeClass('text-light');
				$("#lineBase-tab-ico").addClass('icon-success');
				$("#matrizIdenPro-tab-ico").removeClass('text-light');
				$("#matrizIdenPro-tab-ico").addClass('icon-success');
            break;

			case {{ config('constantes.matriz_priorización_problemas') }}: //MATRIZ DE PRIORIZACIÓN DE PROBLEMAS POR RANGO ETARIO
				$("#ident_com-tab-ico").removeClass('text-light');
				$("#ident_com-tab-ico").addClass('icon-success');
				$("#document-tab-ico").removeClass('text-light');
				$("#document-tab-ico").addClass('icon-success');
				$("#lineBase-tab-ico").removeClass('text-light');
				$("#lineBase-tab-ico").addClass('icon-success');
				$("#ident_com-tab-ico").removeClass('text-light');
				$("#ident_com-tab-ico").addClass('icon-success');
				$("#document-tab-ico").removeClass('text-light');
				$("#document-tab-ico").addClass('icon-success');
				$("#lineBase-tab-ico").removeClass('text-light');
				$("#lineBase-tab-ico").addClass('icon-success');
				$("#matrizIdenPro-tab-ico").removeClass('text-light');
				$("#matrizIdenPro-tab-ico").addClass('icon-success');
				$("#matrizPrioPro-tab-ico").removeClass('text-light');
				$("#matrizPrioPro-tab-ico").addClass('icon-success');
            break;

			case {{ config('constantes.matriz_factores_protectores') }}: // MATRIZ DE FACTORES PROTECTORES
				$("#ident_com-tab-ico").removeClass('text-light');
				$("#ident_com-tab-ico").addClass('icon-success');
				$("#document-tab-ico").removeClass('text-light');
				$("#document-tab-ico").addClass('icon-success');
				$("#lineBase-tab-ico").removeClass('text-light');
				$("#lineBase-tab-ico").addClass('icon-success');
				$("#ident_com-tab-ico").removeClass('text-light');
				$("#ident_com-tab-ico").addClass('icon-success');
				$("#document-tab-ico").removeClass('text-light');
				$("#document-tab-ico").addClass('icon-success');
				$("#lineBase-tab-ico").removeClass('text-light');
				$("#lineBase-tab-ico").addClass('icon-success');
				$("#matrizIdenPro-tab-ico").removeClass('text-light');
				$("#matrizIdenPro-tab-ico").addClass('icon-success');
				$("#matrizPrioPro-tab-ico").removeClass('text-light');
				$("#matrizPrioPro-tab-ico").addClass('icon-success');
				$("#matrizFact-tab-ico").removeClass('text-light');
				$("#matrizFact-tab-ico").addClass('icon-success');
				
            break;

			case {{ config('constantes.informe_dpc') }}: // INFORME DIAGNOSTICO PARTICIPATIVO
				$("#ident_com-tab-ico").removeClass('text-light');
				$("#ident_com-tab-ico").addClass('icon-success');
				$("#document-tab-ico").removeClass('text-light');
				$("#document-tab-ico").addClass('icon-success');
				$("#lineBase-tab-ico").removeClass('text-light');
				$("#lineBase-tab-ico").addClass('icon-success');
				$("#ident_com-tab-ico").removeClass('text-light');
				$("#ident_com-tab-ico").addClass('icon-success');
				$("#document-tab-ico").removeClass('text-light');
				$("#document-tab-ico").addClass('icon-success');
				$("#lineBase-tab-ico").removeClass('text-light');
				$("#lineBase-tab-ico").addClass('icon-success');
				$("#matrizIdenPro-tab-ico").removeClass('text-light');
				$("#matrizIdenPro-tab-ico").addClass('icon-success');
				$("#matrizPrioPro-tab-ico").removeClass('text-light');
				$("#matrizPrioPro-tab-ico").addClass('icon-success');
				$("#matrizFact-tab-ico").removeClass('text-light');
				$("#matrizFact-tab-ico").addClass('icon-success');
				$("#infodpc-tab-ico").removeClass('text-light');
				$("#infodpc-tab-ico").addClass('icon-success');

               	$("#inf-dpc-tab").attr("onclick", "desplegarGestionComunitaria({{ config('constantes.informe_dpc') }});");
            break;

			case {{ config('constantes.plan_estrategico') }}: // PLAN ESTRATEGICO

				$("#ident_com-tab-ico").removeClass('text-light');
				$("#ident_com-tab-ico").addClass('icon-success');
				$("#document-tab-ico").removeClass('text-light');
				$("#document-tab-ico").addClass('icon-success');
				$("#lineBase-tab-ico").removeClass('text-light');
				$("#lineBase-tab-ico").addClass('icon-success');
				$("#ident_com-tab-ico").removeClass('text-light');
				$("#ident_com-tab-ico").addClass('icon-success');
				$("#document-tab-ico").removeClass('text-light');
				$("#document-tab-ico").addClass('icon-success');
				$("#lineBase-tab-ico").removeClass('text-light');
				$("#lineBase-tab-ico").addClass('icon-success');
				$("#matrizIdenPro-tab-ico").removeClass('text-light');
				$("#matrizIdenPro-tab-ico").addClass('icon-success');
				$("#matrizPrioPro-tab-ico").removeClass('text-light');
				$("#matrizPrioPro-tab-ico").addClass('icon-success');
				$("#matrizFact-tab-ico").removeClass('text-light');
				$("#matrizFact-tab-ico").addClass('icon-success');
				$("#infodpc-tab-ico").removeClass('text-light');
				$("#infodpc-tab-ico").addClass('icon-success');

				$("#iden-com-tab").click();
                $("#iden-com-tab").focus();
                $("#iden-com-tab").addClass("active");

            break;
        }

        $('html, body').animate({scrollTop:80}, 'slow');
	}
</script>
@endsection