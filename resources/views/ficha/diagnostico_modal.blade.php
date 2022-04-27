<div id="diagnosticoModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="asignarTerapeutaModal" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content p-4">

			<div class="card p-4 shadow-sm">
				<button type="button" class="close" data-dismiss="modal" style="position: absolute; right: 5px; top: 5px; width: 23px; height: 23px; padding: 0; margin: 0;">&times;</button>
				@if (count($titulos_modal) >= 1)
					<h3 class="modal-title" id="title_diagnostico" data-id-est="{{ $titulos_modal[0]->id_est }}">{{ $titulos_modal[0]->titulo }}</h3>
				@else
					<h3 class="modal-title" id="title_diagnostico" data-id-est=""></h3>
				@endif

				<p>RUT: {{ number_format($caso->run,0,",",".")."-".($caso->dig)  }}</p>
				
				<hr>

				<!-- Mensajes de Alertas -->
				<div class="alert alert-success alert-dismissible fade show" id="alert-exi" role="alert">
					Registro Guardado Exitosamente.
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<div class="alert alert-danger alert-dismissible fade show" id="alert-err" role="alert">
					Error al momento de guardar el registro. Por favor intente nuevamente.
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<!-- Fin Mensajes de Alertas -->
		
				<div class="modal-body" id="mod-eje-paf-des">
					<form enctype="multipart/form-data" id="adj_cons" method="post">
						<!-- HIDDEN FORM -->
						  <meta name="_token" content="{{ csrf_token() }}"/>
						  {{ csrf_field() }}
					      <input type="hidden" name="cas_id" id="cas_id" value="{{$caso->cas_id}}">
						  <!-- HIDDEN FORM -->
                          <!-- GRUPO FAMILIAR -->
						  <button class="btn btn-default" id="btn_despliegue_grupo_familiar" type="button" data-toggle="collapse" data-target="#listar_grupo_familiar"
							  aria-expanded="false" aria-controls="listar_grupo_familiar" style="font-weight: 800; width: 100%;"
							  onclick="if($(this).attr('aria-expanded') == 'false') listarGrupoFamiliar({{$caso->cas_id}});">
							  Identificación del Grupo Familiar
						  </button>
						  @includeif('ficha.listar_grupo_familiar')
							  <!-- GRUPO FAMILIAR -->

							  <!-- VALOR MOSTRAR OCULTAR VISITAS -->
						 @if(($visitas[1]->visita==null)&&($visitas[2]->visita==null)) 
							 	<input type="hidden" name="cont_vis" id="cont_vis" value="2">
							 @else   
							 	<input type="hidden" name="cont_vis" id="cont_vis" value="3">
							 @endif

							  <br>
							  <hr>

							  <button type="button" class="btn btn-primary btn-xs" id="agregar_visita">Agregar Visita</button>

							  <br>
							  <hr>

							<!-- BITACORA VISITA 1 -->
							  
							<div class="form-group">
							<label for=""><b>Visita N° 1:<b></label><br>
							<label for=""> Fecha: </label>	
							<div style="width:150px;" class="input-group date-pick" id="fecha_visita_1" data-target-input="nearest">
								  	
							<br>
							<input  type="text" name="hora_ini" class="form-control datetimepicker-input" data-target="#fecha_visita_1" @if (count($visitas) > 0) value="{{ $visitas[0]->fecha }}" @endif onblur="validarFormDiagnostico(1);"/>
									   
							<div class="input-group-append" data-target="#fecha_visita_1" data-toggle="datetimepicker">
										  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
									  </div>
								  </div><br>
							<label for=""> Descripción: </label>
								  <textarea class="form-control" id="bitacora_visita_1" cols="30" rows="3" onblur="guardarFormDiagnostico(1, {{ $caso->cas_id }});">@if (count($visitas) > 0){{ $visitas[0]->visita }}@endif</textarea>
								  <p id="val_diag_vis_1" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Falta información a completar de esta visita.</p>
							  </div>
							   <script type="text/javascript">
                                        $(function() {
                                            $('#fecha_visita_1').datetimepicker({
                                                format: 'DD/MM/Y'
                                            });
                                        });
                               </script>
							  <!-- BITACORA VISITA 1 -->
							<hr>

							<div id="vis_2"  style="<?php if($visitas[1]->visita==null){ echo  "display:none"; }  ?>">
							  <!-- BITACORA VISITA 2 -->
							  <div class="form-group">
							  	<button type="button" id="cerrar_2" class="close" style="right:5px;top:5px;width:23px;height:23px;padding:0;margin:0;">×</button>
								  <label for="">Visita N° 2:</label><br>
								  <label for=""> Fecha: </label>	
								  <div style="width:150px;"  class="input-group date-pick" id="fecha_visita_2" data-target-input="nearest">
									  <input type="text" name="hora_ini" class="form-control datetimepicker-input" data-target="#fecha_visita_2" @if (count($visitas) > 0) value="{{ $visitas[1]->fecha }}" @endif onblur="validarFormDiagnostico(2);"/>
									  <div class="input-group-append" data-target="#fecha_visita_2" data-toggle="datetimepicker">
										  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
									  </div>
								  </div><br>
								   	<label for=""> Descripción: </label>
								  <textarea class="form-control" id="bitacora_visita_2" cols="30" rows="3" style="" onblur="guardarFormDiagnostico(2, {{ $caso->cas_id }});">@if (count($visitas) > 0){{ $visitas[1]->visita }}@endif</textarea>
								  <p id="val_diag_vis_2" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Falta información a completar de esta visita.</p>
							  </div>
							  <!-- BITACORA VISITA 2 -->
							    <script type="text/javascript">
                                        $(function() {
                                            $('#fecha_visita_2').datetimepicker({
                                                format: 'DD/MM/Y'
                                            });
                                        });
                               </script>

							  <hr>

							</div>

							<div id="vis_3" style="<?php if($visitas[2]->visita==null){ echo  "display:none"; } ?>">
							  <!-- BITACORA VISITA 3 -->
							  <div class="form-group">
							  	<button type="button" id="cerrar_3" class="close" style="right:5px;top:5px;width:23px;height:23px;padding:0;margin:0;">×</button>
								  <label for="">Visita N° 3:</label><br>
								  <label for=""> Fecha: </label>								  <div style="width:150px;" class="input-group date-pick" id="fecha_visita_3" data-target-input="nearest">
									  <input type="text" name="hora_ini" class="form-control datetimepicker-input" data-target="#fecha_visita_3" @if (count($visitas) > 0) value="{{ $visitas[2]->fecha }}" @endif onblur="validarFormDiagnostico(3);"/>
									  <div class="input-group-append" data-target="#fecha_visita_3" data-toggle="datetimepicker">
										  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
									  </div>
								  </div><br>
								   	<label for=""> Descripción: </label>
								  <textarea class="form-control" id="bitacora_visita_3" cols="30" rows="3" style="" onblur="guardarFormDiagnostico(3, {{ $caso->cas_id }});">@if (count($visitas) > 0){{ $visitas[2]->visita }}@endif</textarea>
								  <p id="val_diag_vis_3" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Falta información a completar de esta visita.</p>
							  </div>
							  <!-- BITACORA VISITA 3 -->
							    <script type="text/javascript">
                                        $(function() {
                                            $('#fecha_visita_3').datetimepicker({
                                                format: 'DD/MM/Y'
                                            });
                                        });
                               </script>
							  <hr>
							</div>

							  <!-- NCFAS - G -->
							  <div class="form-row align-items-center">
								  <div class="col-auto">
									  <a href="{{ route('caso.diagnostico',[ 'ficha' => $caso->cas_id]) }}" class="btn btn-warning" style="width: 187px;">Aplicar NCFAS - G</a>
								  </div>
								  <div class="col-auto">
									  <div class="col form-group text-left">
										  
										  @if(($fas_id==1)||($fas_id==3))
										  <h6><span class="oi oi-circle-check">	
										  </span> <span> Realizado</span></h6>
										  @endif

										  @if(($fas_id==0))
										  <h6><span class="oi oi-circle-x"></span> No Realizado</span><h6>
										  @endif

										   <p id="val_diag_ncfas" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Falta completar este item.</p>
									  </div>
								  </div>
							  </div>
							  <hr>
							  <!-- NCFAS - G -->

							  <!-- ALERTAS TERRITORIALES -->
							  <div class="form-group">
								  <a href="{{ route('alertas.crear') }}" class="btn btn-success" style="width: 187px;">Agregar Alerta Manual</a>
							  </div>
							  <hr>
							  <!-- ALERTAS TERRITORIALES -->

							  <!-- DOCUMENTO DE CONSENTIMIENTO -->
							  <div class="form-group">
								  <label for=""><b>Documento de Consentimiento</b></label>
								  <div class="custom-file">
									  <input type="file" class="custom-file-input" name="doc_cons" id="doc_cons">
									  <label class="custom-file-label" for="customFile">Subir documento</label>
								  </div>
								   <p id="val_diag_vis_3" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Falta adjuntar el documento de consentimiento.</p>
							  </div>
							  <div class="form-row align-items-center">
								  <div class="col-auto">
									  <a href="/casos/descarga/documento/1" class="" style="width: 187px;"><span class="input-group-text oi oi-arrow-circle-bottom" id="basic-addon1"></span></a>
								  </div>
								  <div class="col-auto">
									  <small style="font-weight: bold;">* Descargar Documento de Consentimiento</small>
								  </div>
							  </div>
							  <hr>
							  <!-- DOCUMENTO DE CONSENTIMIENTO -->

							  <!-- BITACORA ESTADO ACTUAL -->
							  <div class="form-group">
								  <label for="bitacora_estado_diagnostico" style="font-weight: 800;">Bitacora Estado Actual del Caso:</label>
								  <textarea class="form-control txtAreEtapa" name="bit-etapa-diagnostico" id="bitacora_estado_diagnostico" rows="3" onBlur="cambioEstadoCaso(3, {{ $caso->cas_id }}, $(this).val());"
											@if (config('constantes.en_diagnostico')  != $estado_actual_caso) disabled @endif>{{ $bitacoras_estados[0] }}</textarea>
							  </div>
							  <!-- BITACORA ESTADO ACTUAL -->

						</form>
				</div>
			</div>

			<!-- BOTONES CAMBIOS DE ESTADOS CASO -->
			<div class="modal-footer card text-white bg-secondary">
				<button type="button" class="btn btn-warning btn-sm btnRechEst" data-dismiss="modal" onclick="comentarioEstado(1, {{ $caso->cas_id }});"
						@if (config('constantes.rechazado_por_familiares') == $estado_actual_caso || config('constantes.rechazado_por_gestor') == $estado_actual_caso) disabled @endif >
					Rechazado por Familia
				</button>
				<button type="button" class="btn btn-danger btn-sm btnRechEst" data-dismiss="modal" onclick="comentarioEstado(2, {{ $caso->cas_id }});"
						@if (config('constantes.rechazado_por_familiares') == $estado_actual_caso || config('constantes.rechazado_por_gestor') == $estado_actual_caso) disabled @endif >
					Rechazado por Gestor
				</button>
				<button type="button" id="btn-etapa-diagnostico" class="btn btn-success btn-sm btnEtapa" style="float: right;" onclick="siguienteEtapa(8, {{ $caso->cas_id }});"
						@if (config('constantes.rechazado_por_familiares') == $estado_actual_caso || config('constantes.rechazado_por_gestor') == $estado_actual_caso ||
						config('constantes.en_diagnostico') != $estado_actual_caso ) disabled @endif >Ir a siguiente etapa - Elaborar PAF</button>
			</div>
			<!-- BOTONES CAMBIOS DE ESTADOS CASO -->

		</div>
	</div>
</div>

@includeif('ficha.formulario_grupo_familiar')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js">
</script>
<script type="text/javascript">

	$( document ).ready(function() {

		$("#alert-exi").hide();
		$("#alert-err").hide();
		var cont = $("#cont_vis").val();

	//VISUALIZAMOS LAS VISITAS CON UN MAX DE 3
	$('#agregar_visita').click(function(){

		if(cont==3){  $("#cerrar_2").hide(); }

		if(cont>3){
			alert("Se han agregado el maximo de visitas"); 
		}else{
			$("#vis_"+cont).show();
			cont++;
			$("#cont_vis").val()=cont;
		}
		
	});

	//OCULTAR ITEMS VISITAS
	$('#cerrar_2').click(function(){ 
	 	
	 	$("#vis_2").hide(); 
	 	
	 	$("#fecha_visita_2 > input").val("");
		$("#bitacora_visita_2").val("");

		cont=2;

		//var cas_id = $("#cas_id").val();

		//guardarFormDiagnostico(2, cas_id, 1);


	});

	$('#cerrar_3').click(function(){ 
		
		$("#vis_3").hide(); 
		$("#cerrar_2").show();

		$("#fecha_visita_3 > input").val("");
		$("#bitacora_visita_3").val("");

		cont--;

		//var cas_id = $("#cas_id").val();
		//guardarFormDiagnostico(3, cas_id, 1);

	});

	//ADJUNTAR DOCUMENTO CONSENTIMIENTO
		 $("#doc_cons").change(function(e) {
	
		  // evito que propague el submit
		  e.preventDefault();
		  
		  // agrego la data del form a formData
		  var form = document.getElementById('adj_cons');
		  var formData = new FormData(form);
		  formData.append('_token', $('input[name=_token]').val());

		  $.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			}
		  });

		  $.ajax({
		      type:'POST',
		      url: "{{ route('enviararhcons') }}",
		      data:formData,
		      cache:false,
		      contentType: false,
		      processData: false,
		      success:function(resp){
		           if (resp.estado == 1){
                    $("#alert-exi").show();
					setTimeout(function(){ $("#alert-exi").hide(); }, 5000);

					}else if (resp.estado == 0){
                    $("#alert-err").show();
					setTimeout(function(){ $("#alert-err").hide(); }, 5000);
				}
		      },
		      error: function(jqXHR, text, error){
		          toastr.error('Validation error!', 'No se pudo Añadir los datos<br>' + error, {timeOut: 5000});
		      }
		  });

		});

	});	 
		//FIN DOCUMENTO CONSENTIMIENTO

	function mensajesErrorDiagnostico(option){
        switch (option){
			case 1: //VISITA 1
              $("#val_diag_vis_1").show();
              $("#fecha_visita_1 > input").addClass("is-invalid");
              $("#bitacora_visita_1").addClass("is-invalid");
			break;

			case 2: //VISITA 2
				$("#val_diag_vis_2").show();
				$("#fecha_visita_2 > input").addClass("is-invalid");
				$("#bitacora_visita_2").addClass("is-invalid");
			break;

			case 3: //VISITA 3
				$("#val_diag_vis_3").show();
				$("#fecha_visita_3 > input").addClass("is-invalid");
				$("#bitacora_visita_3").addClass("is-invalid");
			break;
		}
	}

	function validarFormDiagnostico(option){
		let respuesta = false;
		let fecha = "";
		let comentario = "";

		switch (option) {
			case 1: //VISITA 1
				fecha = $("#fecha_visita_1 > input").val();
				comentario = $("#bitacora_visita_1").val();

				if (fecha != ""){
					//$("#bitacora_visita_1").fadeIn('slow');

				}else if (fecha == ""){
					//$("#bitacora_visita_1").fadeOut('slow');

				}

				if (fecha != "" && comentario != "" && comentario.length >= 2){
					//$("#val_diag_vis_1").hide();
					$("#fecha_visita_1 > input").removeClass("is-invalid");
					$("#bitacora_visita_1").removeClass("is-invalid");
					//$("#bitacora_visita_1").fadeIn('slow');
					respuesta = true;
				}
			break;

			case 2: //VISITA 2
				fecha = $("#fecha_visita_2 > input").val();
				comentario = $("#bitacora_visita_2").val();

				if (fecha != ""){
					//$("#bitacora_visita_2").fadeIn('slow');

				}else if (fecha == ""){
					//$("#bitacora_visita_2").fadeOut('slow');

				}

				if (fecha != "" && comentario != "" && comentario.length >= 2){
					$("#val_diag_vis_2").hide();
					$("#fecha_visita_2 > input").removeClass("is-invalid");
					$("#bitacora_visita_2").removeClass("is-invalid");
					$("#bitacora_visita_2").fadeIn('slow');
					respuesta = true;
				}
			break;

			case 3: //VISITA 3
				fecha = $("#fecha_visita_3 > input").val();
				comentario = $("#bitacora_visita_3").val();

				if (fecha != ""){
					//$("#bitacora_visita_3").fadeIn('slow');

				}else if (fecha == ""){
					//$("#bitacora_visita_3").fadeOut('slow');

				}

				if (fecha != "" && comentario != "" && comentario.length >= 2){
					$("#val_diag_vis_3").hide();
					$("#fecha_visita_3 > input").removeClass("is-invalid");
					$("#bitacora_visita_3").removeClass("is-invalid");
					$("#bitacora_visita_3").fadeIn('slow');
					respuesta = true;
				}
			break;

			case 4: //NCFAS
	               let data2 = new Object();
				   data2.cas_id = $("#cas_id").val();

	               $.ajax({
				     url: "{{ route('valida.ncfas') }}",
				     type: "GET",
				     data: data2
					}).done(function(resp){
						if (resp.estado == 1){
							 if (resp.respuesta == true){
							 	respuesta = true;
							 	$("#val_diag_ncfas").hide();

							 }else if (resp.respuesta == false){
							 	$("#val_diag_ncfas").show();

							 }
						}
					}).fail(function(obj){
						console.log(obj); return false;

					});

			break;


			case 5: //DOCUMENTO DE CONSENTIMIENTO
	               let data = new Object();
				   data.cas_id = $("#cas_id").val();

	               $.ajax({
				     url: "{{ route('valida.doc.cons') }}",
				     type: "GET",
				     data: data
					}).done(function(resp){
						if (resp.estado == 1){
							 if (resp.respuesta == true){
							 	respuesta = true;
							 	$("#val_diag_doc_cons").hide();

							 }else if (resp.respuesta == false){
							 	$("#val_diag_doc_cons").show();

							 }
						}
					}).fail(function(obj){
						console.log(obj); return false;

					});

			break;
		}

		return respuesta;
	}

	function guardarFormDiagnostico(option, caso_id, borrar = null){

		let validacion = validarFormDiagnostico(option);

		if(borrar==1){ validacion=true;}

		if (validacion == false) { 

			mensajesErrorDiagnostico(option); return false;
		
		}

		let data = new Object();
		data.option = option;
		data.cas_id = caso_id;

		borrar = null;

		switch (option){
			case 1: //VISITA 1
				data.comentario = $("#bitacora_visita_1").val();
				data.fecha      = $("#fecha_visita_1 > input").val();
			break;

			case 2: //VISITA 2
				data.comentario = $("#bitacora_visita_2").val();
				data.fecha      = $("#fecha_visita_2 > input").val();
			break;

			case 3: //VISITA 3
				data.comentario = $("#bitacora_visita_3").val();
				data.fecha      = $("#fecha_visita_3 > input").val();
			break;

			case 4: //DOCUMENTO DE CONSENTIMIENTO

			break;
		}

		$.ajaxSetup({
			headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}
		});

		$.ajax({
			url: "{{ route('casos.form.diagnostico') }}",
			type: "GET",
			data: data
		}).done(function(resp){
			if (resp.estado == 1){
				//console.log("01"); return false;
				$("#alert-exi").show();
				setTimeout(function(){ $("#alert-exi").hide(); }, 5000);

			}else if (resp.estado == 0){
				//console.log("02"); return false;
				$("#alert-err").show();
				setTimeout(function(){ $("#alert-err").hide(); }, 5000);

			}
		}).fail(function(obj){
			//console.log("03");
			console.log(obj); return false;

			//$("#alert-err").show();
			//setTimeout(function(){ $("#alert-err").hide(); }, 5000);

		});
	}
</script>

