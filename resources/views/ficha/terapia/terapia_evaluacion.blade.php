@extends('layouts.main')

@section('contenido')
<main>
	<!-- TITULO -->
	<section class=" p-1 cabecera">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-12">
					<h2><span class="oi oi-circle-check"></span> {{ $evaluacion->titulo }}</h2>
				</div>
			</div>
		</div>
	</section>
	<!-- TITULO -->

	<!-- MENSAJES DE PROCESO -->
	@if(Session::has('success'))
		<div class="alert alert-success alert-dismissible fade show" id="evaluacion-exito" role="alert">
			<strong>{{ Session::get('success') }}</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	@endif

	@if(Session::has('danger'))
		<div class="alert alert-danger alert-dismissible fade show" id="evaluacion-error" role="alert">
			<strong>{{ Session::get('danger') }}</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	@endif

	@if ($errors->any())
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
	@endif
	<!-- MENSAJES DE PROCESO -->

	<!-- ENCABEZADO TERAPIA -->
	<section>
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-12 p-3">
					<p>Información de la Terapia Familiar:</p>

					<div class="card p-4">
						<div class="row">
							<div class="col">
								<h6>Nombre NNA</h6>
								<h4><strong>{{ $nombre_nna }}</strong></h4>
							</div>
							<div class="col-4">
								<h6>RUT</h6>
								<h4><strong>{{ $run_con_formato }}</strong></h4>
							</div>
						</div><br>

						<div class="row">
							<div class="col">
								<h6>Nombre Terapeuta</h6>
								<h4><strong>{{ $nombre_terapeuta }}</strong></h4>
							</div>
							<div class="col-4">
								<h6>RUT</h6>
								<h4><strong>{{ $run_terapeuta }}</strong></h4>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- ENCABEZADO TERAPIA -->

	<!-- COMENTARIO -->
	<!-- <section>
		<div class="container">
			<div class="card p-3">
				<div class="form-group">
  					<label for="comment">{{ $comentario[0]->eva_pre_nom }}</label>
					<textarea maxlength="1000" onkeypress="return caracteres_especiales(event);" rows="5" class="form-control" placeholder="Ingrese motivo de la consulta" id="eva_com_mot" onkeydown="validarCantidadCaracteresComentarioMotivo();" onkeyup="validarCantidadCaracteresComentarioMotivo();" onblur="guardarRespuestaTemporal(this, {{ $tera_id }}, {{ $fase }}, {{ $comentario[0]->eva_pre_id }}, null, $(this).val());" 
						@if ($etapa_visualizacion) disabled @endif>{{ $valor_comentario }}</textarea>

					<div class="row">
						<div class="col-6">
							<h6><small class"form-text text-muted">Mínimo 3 y máximo 1000 caracteres.</small></h6>
						</div>
						<div class="col-6">
							<h6><small class"form-text text-muted">N° de caracteres: <strong id="eva_can_car_com_mot" style="color: #000000;">0</strong></small></h6>
						</div>
					</div>

  					<p id="val_eva_com_mot" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar un comentario válido.</p>
				</div>
			</div>	
		</div>		
	</section> -->
	<!-- COMENTARIO -->

	<!-- EVALUACION -->
	<section>
		<div class="container">
			<form action="{{ route('gestion-terapia-familiar.evaluacion.finalizar') }}" method="POST" id="form-eva-ter" enctype="multipart/form-data">
			{{ csrf_field() }}	
			<input type="hidden" name="eva_tera_id" id="eva_tera_id" value="{{ $tera_id }}" >
			<input type="hidden" name="eva_run_sin_formato" id="eva_run_sin_formato" value="{{ $run_sin_formato }}" >
			<input type="hidden" name="eva_run_con_formato" id="eva_run_con_formato" value="{{ $run_con_formato }}" >
			<input type="hidden" name="eva_fase" id="eva_fase" value="{{ $fase }}" >
			<input type="hidden" name="modo_evaluacion" id="modo_evaluacion" value="{{ $etapa_visualizacion }}" >

			<p>Responder los siguientes ítems en relación con el motivo de consulta descrito anteriormente:</p>
				<div class="card p-3">
					<div class="row">
						<div class="col-md-3">
							<!--<p>XXXXX</p>
							<hr>-->

							<div class="list-group" id="list-eva-tab" role="tablist">
							@foreach($evaluacion->dimensiones AS $c0 => $v0)
								<a class="list-group-item list-group-item-action" id="list-eva-{{ $v0->eva_dim_id  }}-list" data-toggle="list" href="#list-eva-{{ $v0->eva_dim_id }}" role="tab" aria-controls="dim-eva-{{ $v0->eva_dim_id }}">{{ $v0->eva_dim_nom }}</a>
							@endforeach
							</div>
						</div>

						<div class="col-md-9">
							<div class="tab-content" id="nav-tabContent-eva">
								@foreach($evaluacion->dimensiones AS $c1 => $v1)
								<div class="tab-pane fade" id="list-eva-{{ $v1->eva_dim_id }}" role="tabpanel" aria-labelledby="dim-eva-{{ $v1->eva_dim_id }}">
									<h4>{{ $v1->eva_dim_nom }}</h4>
									<!--<p>NOTA</p>-->

									@foreach($v1->preguntas AS $c2 => $v2)
									<table class="table table-hover table-responsive table-sm">
										<!-- PREGUNTA -->
										<thead>
											<tr>
												<th class="text-center" colspan="6"><h5>{{ $v2->eva_pre_nom }}</h5></th>
											</tr>
											<tr>
												<th scope="col" style="width: 13%;"><small></small></th>
												@foreach($v2->fases[0]->alternativas AS $a0 => $b0)
													<th class="text-center" scope="col" style="width: 15%;"><small>{{ $b0->eva_alt_nom }}</small></th>
												@endforeach
											</tr>
										</thead>
										<!-- PREGUNTA -->

										<!-- ALTERNATIVA/RESPUESTA -->
										<tbody>
											<!-- COLOR ALTERNATIVA -->
											<tr>
												<td><div style="height: 0px; overflow:auto;"></div></td>
												<td class="headGravedadEncuesta7"></td>
												<td class="headGravedadEncuesta6"></td>
												<td class="headGravedadEncuesta5"></td>
												<td class="headGravedadEncuesta4"></td>
												<td class="headGravedadEncuesta3"></td>
											</tr>
											<!-- COLOR ALTERNATIVA -->

											@foreach($v2->fases AS $c3 => $v3)
											<!-- RESPUESTA -->
											<tr class="currentFase" >
												@if ($v3->etapa) <!-- Fase Actual-->
													<th scope="row">{{ $v3->eva_fase_nom }}</th>
												@elseif (!$v3->etapa) <!-- Fases Restantes -->
													<td scope="row">{{ $v3->eva_fase_nom }}</td>
												@endif

												@foreach($v3->alternativas AS $c4 => $v4)
													@if ($v3->eva_fase_id == $fase)
													
													<td @if ($v3->visualizacion && $v4->respuesta) class="{{ $v4->eva_alt_clas }}" @endif style="text-align: center;">

													@elseif ($v3->eva_fase_id != $fase)
													
													<td @if (!$v3->visualizacion && $v4->respuesta) class="{{ $v4->eva_alt_clas }}" @endif style="text-align: center;">

													@endif	

													@if ($v3->etapa) <!-- Fase Actual-->
														@if ($v3->visualizacion)
														   	<label class="form-check-label" >{{$v4->eva_alt_nom}}</label>

														@elseif (!$v3->visualizacion)
															<div class="form-check form-check-inline">
																<input class="form-check-input" type="radio" name="radio-eva-{{ $v3->eva_fase_id }}-{{ $v2->eva_pre_id }}" id="mi-label-eva-{{ $v4->eva_alt_id }}"
																value="{{ $v4->eva_alt_val }}"
																@if ($v4->respuesta) checked @endif 
																onclick="guardarRespuestaTemporal(this, {{ $tera_id }}, {{ $v3->eva_fase_id }}, {{ $v2->eva_pre_id }}, {{ $v4->eva_alt_id }});">

																<label class="form-check-label" for="mi-label-eva-{{ $v4->eva_alt_id }}">{{ $v4->eva_alt_nom }}</label>
															</div>
														@endif

													@elseif (!$v3->etapa) <!-- Fases Restantes -->
															<label class="form-check-label" >{{$v4->eva_alt_nom}}</label>
													@endif
													</td>
												@endforeach
											</tr>	
											<!-- RESPUESTA -->
											@endforeach
										</tbody>
										<!-- ALTERNATIVA/RESPUESTA -->
									</table><br>	
									@endforeach

								</div>
								@endforeach
							</div>
						</div>	
					</div>

					<!-- DESPLIEGUE DE BOTONES -->
					<div class="row">
						<div class="col-md-2 offset-md-3" >
							<button type="button" id="btn_eva_ant" class="btn btn-secondary" onclick="btnAnterior(this);"><span class="oi oi-arrow-left"></span> Anterior</button>
						</div>


						<div class="col-md-2 offset-md-1">
							<button type="button" class="btn btn-primary btn-lg" id="btn_fin_eva" onclick="validarEvaluacion(this);" @if ($etapa_visualizacion) style="display: none;" @endif>Finalizar Evaluación</button>
						</div>

						<div class="col-md-2 offset-md-1" >
							<button type="button" id="btn_eva_sig" class="btn btn-secondary float-right" onclick="btnSiguiente(this);">Siguiente <span class="oi oi-arrow-right"></span></button>
						</div>
					</div>

					<div class="row">
						<div class="col-md-2" style="margin-top:-35px;">
							<!-- <a href="javascript:history.go(-1)" type="button" id="atrasDim" class="btn btn-success"><span class="oi oi-arrow-left"></span> Volver a Ficha</a> -->
							<a href="{{ route('gestion-terapia-familiar') }}/{{ $run_sin_formato }}/{{$id_caso}}" type="button" id="atrasDim" class="btn btn-success"><span class="oi oi-arrow-left"></span> Volver a Ficha</a>
						</div>
					</div>
					<!-- DESPLIEGUE DE BOTONES -->

				</div>	
			</form>
		</div>	
	</section>
	<!-- EVALUACION -->
</main>
@stop
<style type="text/css">
	.validacion_color{
		 background-color: #0097d091 !important;
	}
</style>
@section('script')
<script type="text/javascript" >
	$( document ).ready(function(){
    	cargaInicialEvaluacion();

    	$('a[data-toggle="list"]').on('show.bs.tab', function (e){
			var indexNuevo =  $(e.target).index();
			var indexMinimo = 0;
			var indexMaximo = $('#list-eva-tab a').length-1;
			if(indexNuevo<indexMaximo && indexNuevo>indexMinimo){
				$("#btn_eva_ant").show();
				$("#btn_eva_sig").show();
				$("#btn_fin_eva").hide();
			}else if(indexNuevo==indexMinimo){
				$("#btn_eva_ant").hide();
				$("#btn_eva_sig").show();
				$("#btn_fin_eva").hide();
			}else if(indexNuevo==indexMaximo){
				$("#btn_eva_ant").show();
				$("#btn_eva_sig").hide();

				if (!$("#modo_evaluacion").val()) $("#btn_fin_eva").show();

			}
			//e.target // newly activated tab
			//e.relatedTarget // previous active tab
		});

		$("#list-eva-tab a").click(function(){
			$(this).removeClass('validacion_color');
		});

	});

	function cargaInicialEvaluacion(){
		$('#list-eva-tab a:first-child').tab('show');
		$("#btn_fin_eva").hide();
		$("#btn_eva_ant").hide();
	}

	function btnSiguiente(_this){
		var indexActual = $('#list-eva-tab a.active').index();
		var indexNuevo =  indexActual+1;
		var indexMinimo = 0;
		var indexMaximo = $('#list-eva-tab a').length-1;

		$(_this).prop('disabled',true);
		$('html, body').animate({ scrollTop: 380 },500,'swing',function(){
			$(_this).prop('disabled',false);
			if(indexNuevo<indexMaximo && indexNuevo>indexMinimo){
				$('#list-eva-tab a:eq('+indexNuevo+')').tab("show");
			}else if(indexNuevo==indexMaximo){
				$('#list-eva-tab a:eq('+indexNuevo+')').tab("show");
			}
		});
	}

	function btnAnterior(_this){
		var indexActual = $('#list-eva-tab a.active').index();
		var indexNuevo =  indexActual-1;
		var indexMinimo = 0;
		var indexMaximo = $('#list-eva-tab a').length-1;

		$(this).prop('disabled',true);
		$('html, body').animate({ scrollTop: 380 },500,'swing',function(){
			$(_this).prop('disabled',false);
			if(indexNuevo<indexMaximo && indexNuevo>indexMinimo){
				$('#list-eva-tab a:eq('+indexNuevo+')').tab("show");
			}else if(indexNuevo==indexMinimo){
				$('#list-eva-tab a:eq('+indexNuevo+')').tab("show");
			}
		});
	}

	function validarEvaluacion(_this){
		eliminarMensajeErrorComentarioMotivo();
		$("#list-eva-tab a").removeClass('validacion_color');

		var totalAlternativas 	= 10; 
		var totalComentarios 	= 1;
		var alternativas 		= $("#form-eva-ter input[type='radio'][name*='radio-eva-']:enabled:checked").length;
		// INICIO CZ SPRINT 57
		// var comentados = 0;
		// $("#eva_com_mot:enabled").each(function(){

		// 	if($(this).val().length >= 3){
		// 		comentados++;
		// 	}
		// });
		// FIN CZ SPRINT 57
		var alternativasRestantes 	= totalAlternativas - alternativas;
		// INICIO CZ SPRINT 57
		// var comentariosRestantes 	= totalComentarios  - comentados;
		// var totalRestantes 			= alternativasRestantes + comentariosRestantes;
		// FIN CZ SPRINT 57
		var totalRestantes 			= alternativasRestantes;

		var msj = "";
		msj += "Faltan \n";
		msj += "Pregunta(s) con  Alternativa(s): " + alternativasRestantes + " \n";
		// INICIO CZ SPRINT 57
		// msj += "Comentario: " + comentariosRestantes + " \n";
		// FIN CZ SPRINT 57
		msj += "Por favor, revise las secciones marcadas en color.";

		if(totalRestantes > 0){
			alert(msj);

			$('html, body').animate({ scrollTop: 380 }, 500,'swing',function(){

				$("#nav-tabContent-eva .tab-pane").each(function(){
					var this2 = this;
					var indiceDim = "#"+$(this2).attr("id");
					var nroAltsDim = $(this2).find("table").length;
					var nroAltsDimLlenadas = $(this2).find("tr.currentFase input[type='radio'][name*='radio-eva-']:enabled:checked").length;

					if(nroAltsDimLlenadas < nroAltsDim){
						$("#list-eva-tab a[href='"+indiceDim+"']").addClass('validacion_color');
					
					}

					if (comentados == 0){
						$("#eva_com_mot").addClass("is-invalid");
						$("#val_eva_com_mot").show();

					}
				});

			});
		}else if(totalRestantes == 0){
			// INICIO CZ SPRINT 60
			$("#form-eva-ter").submit();
			// guardarMotivoTF();
			// FIN CZ SPRINT 60

		}
	}
// INCIO CZ SPRINT 57
	function guardarMotivoTF(){

		console.log("entro a la funcion");
		let data = new Object();
		data.tera_id 		 = $("#eva_tera_id").val();
		data.eva_fase_id 	 = $("#eva_fase").val();

		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});

		$.ajax({
	      url: "{{ route('gestion-terapia-familiar.evaluacion.MotivoTF') }}",
	      type: "POST",
	      data: data
	    }).done(function(resp){
	    	desbloquearPantalla();
			console.log(resp);
			if(resp.estado == 1){
			$("#form-eva-ter").submit();
			}
	    }).fail(function(objeto, tipoError, errorHttp){
	    	desbloquearPantalla();
	    	
	    	manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

	        console.log(objeto);
	    });

		}

	function guardarRespuestaTemporal(_this, tera_id, eva_fase_id, eva_pre_id, eva_alt_id = null, eva_res_alt_com = null){
		let data = new Object();

		bloquearPantalla();

		data.tera_id 		 = tera_id;
		data.eva_fase_id 	 = eva_fase_id;
		data.eva_pre_id 	 = eva_pre_id;
		data.eva_alt_id 	 = eva_alt_id;
		data.eva_res_alt_com = $("#def_pro_preg_1").val();

		if (eva_alt_id == null && eva_res_alt_com != null){
			let validacion_comentario = validarComentarioMotivo();

			if (!validacion_comentario){
				desbloquearPantalla();

				return false;
			} 
		}

		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});

		$.ajax({
	      url: "{{ route('gestion-terapia-familiar.evaluacion.guardar.temporal') }}",
	      type: "POST",
	      data: data
	    }).done(function(resp){
	    	desbloquearPantalla();

	    	if (resp.estado == 1){
	    		mensajeTemporalRespuestas(1, resp.mensaje);
	    		
	    	}else if (resp.estado == 0){
	    		mensajeTemporalRespuestas(0, resp.mensaje);

	    	}
	    }).fail(function(objeto, tipoError, errorHttp){
	    	desbloquearPantalla();
	    	
	    	manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

	        console.log(objeto);
	    });
	}
	//FIN CZ SPRINT 57

	valor_comentario_motivo = new Array(); 
    function validarCantidadCaracteresComentarioMotivo(){
      let num_caracteres_permitidos = 1000;
      let num_caracteres 			= $("#eva_com_mot").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#eva_com_mot").val(valor_comentario_motivo);

       }else{ 
          valor_comentario_motivo = $("#eva_com_mot").val();

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#eva_can_car_com_mot").css("color", "#ff0000"); 

       }else{ 
          $("#eva_can_car_com_mot").css("color", "#000000");

       } 

      
       $("#eva_can_car_com_mot").text($("#eva_com_mot").val().length);
    }

    function validarComentarioMotivo(){
    	let respuesta = true;

		eliminarMensajeErrorComentarioMotivo();

		let comentario = $("#eva_com_mot").val().trim();

		if (comentario == "" || comentario.length < 3 || typeof comentario === "undefined"){
			respuesta = false;
			$("#eva_com_mot").addClass("is-invalid");
			$("#val_eva_com_mot").show();
		}

		return respuesta;
    }

    function eliminarMensajeErrorComentarioMotivo(){
    	$("#eva_com_mot").removeClass("is-invalid");
    	$("#val_eva_com_mot").hide();
    }

	/*function guardarComentarioMotivo(){
		let data = new Object();

		$.ajax({
	      url: "{ { route('gestion-terapia-familiar.evaluacion.finalizar') }}",
	      type: "GET",
	      data: data
	    }).done(function(resp){
	    	if (resp.estado == 1){
	    		//$(_this).attr("onclick", "guardarRespuestaTemporal(_this, "+tera_id+", "+eva_fase_id+", "+eva_pre_id+", "+eva_alt_id+", "+eva_res_alt_com+")");
	    	
	    	}else if (resp.estado == 0){
	    		alert(resp.mensaje);

	    	}
	    }).fail(function(obj){
	    	let mensaje = "Hubo un error al momento de guardar la respuesta. Por favor intente nuevamente.";

	    	alert(mensaje);
	        console.log(obj);
	    });
	}*/
</script>	
@endsection