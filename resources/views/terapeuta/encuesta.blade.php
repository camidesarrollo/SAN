@extends('layouts.main')
@section('contenido')
<main id="content">

	<section class=" p-1 cabecera">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-12">
					<h2><span class="oi oi-circle-check"></span> Diagnosticar Caso</h2>
				</div>
			</div>
		</div>
	</section>

	@if(Session::has('success'))
		<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>{{ Session::get('success') }}</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	@endif

	@if(Session::has('danger'))
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
			<strong>{{ Session::get('danger') }}</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	@endif

		<div id="alert-encuesta-error" style="display:none;" class="alert alert-danger alert-dismissible fade show" role="alert">
			<strong>Error al momento de guardar el registro. Por favor intente nuevamente.</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>

		<div id="alert-encuesta" style="display:none;" class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>Registro Guardado Exitosamente.</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>

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

	<section>
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-12 p-3">
					<p>El siguiente diagnóstico será asignado al caso:</p>

					<div class="card p-4">
						<div class="row">

							<div class="col"><s</mall>
								<h6>Nombre</h6>
								<h4><strong>{{ $nombres }}</strong></h4>
							</div>
							<div class="col-4"><s</mall>
								<h6>RUT</h6>
								<h4><strong><?php print_r(Helper::devuelveRutX($rut)); ?></strong></h4>
								<input type="hidden" name="ruta_ficha_caso" id="ruta_ficha_caso" value="{{ route('atencion-nna') }}/{{ $rutsinformato }}/{{$caso->cas_id}}">
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section>
		<div class="container">
			<form action="{{route('caso.diagnostico.cambiar.fase')}}" method="post" id="frm_encuesta" name="frm_encuesta" enctype="multipart/form-data" >
				{{ csrf_field() }}
				<input type="hidden" name="cas_id" id="cas_id" value="{{$caso->cas_id}}" >
				<input type="hidden" name="opcion" id="opcion" value="{{$opcion}}" >
				<input type="hidden" name="caso_diagnostico_grabar" id="caso_diagnostico_grabar" value="{{ route('caso.diagnostico.grabar')  }}">
				<input type="hidden" name="total_input" id="total_input" value="" >
				<input type="hidden" id="rutsinformato" name="rutsinformato" value="{{$rutsinformato}}">
			<div class="card p-3">
				<div class="row">
					<div class="col-md-3">
						<p>Dimensiones</p>
						<hr>

						<div class="list-group" id="list-tab" role="tablist">
							@foreach($dimensiones as $d)
								<a @if(($caso->fas_id==0)&&($caso->est_cas_id==1)||($caso->fas_id==1)&&($caso->est_cas_id==5))
								onclick="guardarDimensionFase();"
								@endif 
								class="list-group-item list-group-item-action" id="list-{{$d->dim_enc_id}}-list" data-toggle="list" href="#list-{{$d->dim_enc_id}}" role="tab" aria-controls="dim-{{$d->dim_enc_id}}">{{$d->dim_enc_nom}}</a>
							@endforeach
						</div>
					</div>
					<div class="col-md-9">
						<div class="tab-content" id="nav-tabContent">
							<?php
							$indice=0;
							?>
							@foreach($dimensiones as $d)
							<div class="tab-pane fade" id="list-{{$d->dim_enc_id}}" role="tabpanel" aria-labelledby="dim-{{$d->dim_enc_id}}">
								<h4>{{($d->dim_enc_nom)}}</h4>
								<p>{{($d->dim_enc_not)?$d->dim_enc_not:""}}</p>



								@php( $preguntasDim = $d->preguntas->where('dim_id',$d->dim_id)->sortBy('pre_ord'))

								@foreach($preguntasDim as $p)

									@if($p->pre_tip==1)

										<table class="table table-hover table-responsive table-sm tablaEncuesta" attr1="{{$p->pre_id}}" >
											<thead>
											<tr>
												<th colspan="9">
													<h5>{{$p->nom_var}}</h5>
												</th>
											</tr>
											<tr>
												<th scope="col"><small></small></th>
												@foreach($alternativas as $alt)
													<th scope="col" style="width: 12.5%" ><small>{{$alt->alt_nom}} </small></th>
												@endforeach
											</tr>
											</thead>
											<tbody>
											<tr>
												<td>
													<div style="height: 0px; overflow:auto;">

													</div>
												</td>
												<td class="headGravedadEncuesta1" ></td>
												<td class="headGravedadEncuesta2" ></td>
												<td class="headGravedadEncuesta3" ></td>
												<td class="headGravedadEncuesta4" ></td>
												<td class="headGravedadEncuesta5" ></td>
												<td class="headGravedadEncuesta6" ></td>
												<td class="headGravedadEncuesta7" ></td>
												<td class="headGravedadEncuesta8" ></td>
											</tr>

											@foreach($fases as $fa)
												@if($fa->fas_id==$fase_actual)
													<tr class="currentFase" >
														<th scope="row">{{$fa->fas_nom}} </th>
														@foreach($alternativas as $alt)
														<td>
															<div class="form-check form-check-inline">

															@if (($opcion==config('constantes.en_diagnostico') && $fa->fas_id==config('constantes.ncfas_fs_ingreso'))
															or
															($opcion==config('constantes.en_cierre_paf') && $fa->fas_id==config('constantes.ncfas_fs_cierre')
															)
															or
															($opcion==config('constantes.en_seguimiento_paf') && $fa->fas_id==config('constantes.ncfas_fs_cierre_ptf')
															))
															<input class="form-check-input" type="radio" name="radio-{{$p->pre_id}}-{{$fa->fas_id}}" id="mi-label-{{$p->pre_id}}" value="{{$alt->alt_id}}" {{($alt->alt_ord==1)?"required":""}} 

															@foreach($respuestas as $res)
															
															@if(($res->fas_id==$fa->fas_id)&&($res->pre_id==$p->pre_id)&&($res->alt_id==$alt->alt_id))

															checked="checked"

															@endif			

															@endforeach
																>
																<label class="form-check-label" for="mi-label-{{$p->pre_id}}">{{$alt->alt_val}}</label>
															@else
																<label class="form-check-label" >{{$alt->alt_val}}</label>
															@endif
															</div>
														</td>
														@endforeach
													</tr>
												@else
													@if($fa->fas_id != 2)
												{{-- validar fase???? print respuesat --}}
													<tr>
														<td scope="row">{{$fa->fas_nom}}</td>
														@if($fa->fas_id < $fase_actual)
															@foreach($alternativas as $alt)
																<td>

																	<div class="form-check form-check-inline"  >
																		@foreach($respuestas as $res)
															
																			@if (($res->fas_id==$fa->fas_id)&&($res->pre_id==$p->pre_id)&&($res->alt_id==$alt->alt_id))

																				<input disabled
																				class="form-check-input" type="radio" name="" attr1="{{$alt->alt_id}}"  value="" checked="checked" >

																			@endif			
																		@endforeach
																					
																		<label class="form-check-label" >{{$alt->alt_val}}</label>
																	</div>
			
																</td>
															@endforeach
															<?php
															$indice++;
															?>

														@elseif($fa->fas_id>$fase_actual)
															@foreach($alternativas as $alt)
															<td>
																<div class="form-check form-check-inline">
																	@foreach($respuestas as $res)
															
																			@if (($res->fas_id==$fa->fas_id)&&($res->pre_id==$p->pre_id)&&($res->alt_id==$alt->alt_id))

																				<input disabled
																				class="form-check-input" type="radio" name="" attr1="{{$alt->alt_id}}"  value="" checked="checked" >

																			@endif			
																	@endforeach	
																	<label class="form-check-label" >{{$alt->alt_val}}</label>
																</div>
															</td>
															@endforeach
														@endif


													</tr>
													@endif
												@endif

											@endforeach
											</tbody>
										</table>
										<hr>

									@else

										@if($p->pre_tip==2 )

											<?php $mostrar_texarea=1; ?>

											@forelse($comentarios as $com)
												 @if($d->dim_enc_id==$com->dim_enc_id)
														<div class="form-group">
														@if(session()->all()["editar"])
															<label><h5>{{$p->nom_var}}</h5></label>
															<textarea maxlength="2000" onkeypress='return caracteres_especiales(event)' type="text" name="text-{{$p->pre_id}}-{{$fase_actual}}"  id="text-{{$p->pre_id}}-{{$fase_actual}}" class="form-control " 
															>{{$com->res_com}}</textarea>
														@elseif(session()->all()["visualizar"])
														<label><h5>{{$p->nom_var}}</h5></label>
															<label>{{$com->res_com}}</label>
														@else
														@endif
														</div>
													
													<?php $mostrar_texarea=0; ?>
												@endif
											@empty
											@endforelse

												@if($fase_actual<4)
													@if($mostrar_texarea==1)
													<div class="form-group">
														@if(session()->all()["editar"])
														<label><h5>{{$p->nom_var}}</h5></label>
														<textarea  
														required maxlength="2000" onkeypress='return caracteres_especiales(event)' type="text" id="text-{{$p->pre_id}}-{{$fase_actual}}" name="text-{{$p->pre_id}}-{{$fase_actual}}" class="form-control " placeholder="Comentario" aria-label="Comentario"></textarea>
														@endif
													</div>

													@endif
												@endif											
											
										@endif

										@if($p->pre_tip==3 )
											@forelse($archivos as $arch)
												@if($com->fas_id==$arch->fas_id)
													@if($d->dim_enc_id==$arch->dim_enc_id)
														<div class="form-group">
															<a href="{{route('adjunto',['adj_id'=>$arch->adj_id])}}" class="btn btn-info btn-sm" target="_blank"  >
															<span class="oi oi-data-transfer-download"></span> {{$arch->adj_nom}}
															</a>
														</div>
													@endif
												@endif
											@empty
												@if($fase_actual<4)
													<div class="form-group">
														<div class="custom-file">
															<input class="file_pdf" type="file" name="file-{{$p->pre_id}}-{{$fase_actual}}" >
														</div>
													</div>
												@endif
											@endforelse
										@endif

									@endif

								@endforeach
							</div>
							@endforeach
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2 offset-md-3" > 
						{{-- TRAER DATOS DE TERAPEUTA (AI_TERAPIA) PARA MOSTRAR O OCUULTAR BOTON DIAGNOSTICAR Validar todo por terpia y session terapeuta --}}
						<button 
						@if(($caso->fas_id==0)&&($caso->est_cas_id==1)||($caso->fas_id==1)&&($caso->est_cas_id==5))
						onclick="guardarDimensionFase();"
						@endif	
						type="button" id="atrasDim" class="btn btn-secondary"><span class="oi oi-arrow-left"></span> Anterior Dimensión</button>
					</div>
					<div class="col-md-2 offset-md-1">
						<button type="submit" class="btn btn-primary btn-lg" id="diagnosticar" >Diagnosticar</button>
					</div>
					<div class="col-md-2 offset-md-1" >
						<button @if(($caso->fas_id==0)&&($caso->est_cas_id==1)||($caso->fas_id==1)&&($caso->est_cas_id==5))
						onclick="guardarDimensionFase();"
						@endif	type="button" id="adelanteDim" class="btn btn-secondary float-right" >Siguiente Dimensión <span class="oi oi-arrow-right"></span></button>
					</div>
				</div>

				<div class="row">
					<div class="col-md-2" style="margin-top:-35px;">
						<!-- <a href="javascript:history.go(-1)" type="button" id="atrasDim" class="btn btn-success"><span class="oi oi-arrow-left"></span> Volver a Ficha</a> -->
						<!-- INICIO CZ SPRINT 63 Casos ingresados a ONL -->
						@if(session()->all()["perfil"] == config('constantes.perfil_terapeuta'))
						<a href="/gestion-terapia-familiar/{{$rutsinformato}}/{{$caso->cas_id}}" type="button" id="atrasDim" class="btn btn-success"><span class="oi oi-arrow-left"></span> Volver a Ficha</a>
						@else
						<a href="/atencion-nna/{{$rutsinformato}}/{{$caso->cas_id}}" type="button" id="atrasDim" class="btn btn-success"><span class="oi oi-arrow-left"></span> Volver a Ficha</a>
						@endif
						<!-- FIN CZ SPRINT 63 Casos ingresados a ONL -->
					</div>
				</div>

			</div>
			</form>
		</div>
	</section>
</main>

@stop
@section('script')
	<script type="text/javascript" >
		$(document).ready(function(){


			$("input[type='file']").on('change', function() {
				let maxSize = 1*1024;
				var file = this.files[0];
				let size = Math.ceil(file.size/1024);
				let sizeMsg = size+" KB";
				if(maxSize<size){
					alert("El archivo "+file.name+" \npesa "+sizeMsg+" y el limite es "+maxSize+" KB.");
					$(this).val("");
				}
				if(file.type !== 'application/pdf'){
					alert("El archivo "+file.name+" no es un PDF.");
					$(this).val("");
				}

			});

			$("#frm_encuesta input[type='radio']:not(:enabled):checked").each(function(){

				var _this = this;
				var gravedad = $(_this).attr('attr1');
				$(_this).parents('td').addClass('gravedadEncuesta'+gravedad);
				$(_this).hide();

			});

			$("#frm_encuesta input[type='radio'][name^='radio-']:enabled").on("change",function(){
				var _this = this;
				if($(_this).prop('checked')==true){

					$(_this).parents("tr").each(function(){

						$(this).find("td").removeClass(function() {
							return $( this ).attr( "class" );
						});
					});
					var  gravedad = $(_this).attr('value');
					$(_this).parents("td").addClass("headGravedadEncuesta"+gravedad);
				}
			});

			$("#diagnosticar").click(function(e){
				e.preventDefault();

				var _this = $(this);
				var totalAlternativas = 58; //58 - 70
				var totalComentarios = 8; //8 - 10
				var alternativas = $("#frm_encuesta input[type='radio'][name*='radio-']:enabled:checked").length;
				var comentados = 0;
				$("#frm_encuesta textarea:enabled").each(function(){

					if($(this).val().length > 0){
						comentados++;
					}
				});

				var alternativasRestantes = totalAlternativas-alternativas;
				var comentariosRestantes = totalComentarios-comentados;
				var totalRestantes = alternativasRestantes + comentariosRestantes;

				var msj = "";
				msj += "Faltan \n";
				msj += "Evaluacion(es) con  Alternativa(s): " + alternativasRestantes + " \n";
				msj += "Comentario(s): " + comentariosRestantes + " \n";
				msj += "Por favor, revise las dimensiones marcadas en color.";

				if(totalRestantes>0){
					alert(msj);

					$('html, body').animate({ scrollTop: 390 },1000,'swing',function(){

						$("#nav-tabContent .tab-pane").each(function(){
							var this2 = this;
							var indiceDim = "#"+$(this2).attr("id");
							var nroAltsDim = $(this2).find("tr.currentFase").length;
							var nroAltsDimLlenadas = $(this2).find("tr.currentFase input[type='radio']:enabled:checked").length;
							var comLlenado = $(this2).find("textarea:enabled").val().length;

							if(nroAltsDimLlenadas<nroAltsDim || comLlenado==0){
								$("#list-tab a[href='"+indiceDim+"']").addClass('restantes');
							}
						});

					});
				}else if(totalRestantes==0){
					$("#total_input").val("1");

					$("#frm_encuesta").submit();

					$(".form-check-input").hide();
					
					setTimeout(function(){ VolverAficha(); }, 3000);
				}
			});

			$("#list-tab a").click(function(){
				$(this).removeClass('restantes');
			});

			$("#diagnosticar").hide();
			$('#list-tab a:first-child').tab('show');
			$("#atrasDim").hide();

			$("#adelanteDim").click(function(){
				var _this = this;
				var indexActual = $('#list-tab a.active').index();
				var indexNuevo =  indexActual+1;
				var indexMinimo = 0;
				var indexMaximo = $('#list-tab a').length-1;

				$(_this).prop('disabled',true);
				$('html, body').animate({ scrollTop: 390 },1000,'swing',function(){
					$(_this).prop('disabled',false);
					if(indexNuevo<indexMaximo && indexNuevo>indexMinimo){
						$('#list-tab a:eq('+indexNuevo+')').tab("show");
					}else if(indexNuevo==indexMaximo){
						$('#list-tab a:eq('+indexNuevo+')').tab("show");
					}
				});

			});

			$("#atrasDim").click(function(){

				var _this = this;
				var indexActual = $('#list-tab a.active').index();
				var indexNuevo =  indexActual-1;
				var indexMinimo = 0;
				var indexMaximo = $('#list-tab a').length-1;

				$(this).prop('disabled',true);
				$('html, body').animate({ scrollTop: 390 },1000,'swing',function(){
					$(_this).prop('disabled',false);
					if(indexNuevo<indexMaximo && indexNuevo>indexMinimo){
						$('#list-tab a:eq('+indexNuevo+')').tab("show");
					}else if(indexNuevo==indexMinimo){
						$('#list-tab a:eq('+indexNuevo+')').tab("show");
					}
				});

			});

			$('a[data-toggle="list"]').on('show.bs.tab', function (e) {

				var indexNuevo =  $(e.target).index();
				var indexMinimo = 0;
				var indexMaximo = $('#list-tab a').length-1;
				if(indexNuevo<indexMaximo && indexNuevo>indexMinimo){
					$("#atrasDim").show();
					$("#adelanteDim").show();
					$("#diagnosticar").hide();
				}else if(indexNuevo==indexMinimo){
					$("#atrasDim").hide();
					$("#adelanteDim").show();
					$("#diagnosticar").hide();
				}else if(indexNuevo==indexMaximo){
					$("#atrasDim").show();
					$("#adelanteDim").hide();
					$("#diagnosticar").show();
				}
				//e.target // newly activated tab
				//e.relatedTarget // previous active tab
			})


		});

 function guardarPreguntaFase(pre_id,fas_id,alt_id=null){

	 	var cas_id = $("#cas_id").val();

	 	//alert(" - cas_id: "+cas_id+" - fas_id:  "+fas_id+" - pre_id: "+pre_id+" - alt_id: "+alt_id);

	 	let res_com = $("#text-"+pre_id+"-"+fas_id).val();

	 	//alert(res_com);

		let url = $("#caso_diagnostico_grabar").val();
		let data = new Object();
	    data.cas_id = cas_id;
	    data.fas_id = fas_id;
		data.pre_id = pre_id;
		data.alt_id = alt_id;
		data.res_com = res_com;

		//alert(data);

		$.ajax({
			url: url,
			type: "GET",
			data: data
		}).done(function(resp){
			let html= resp.mensaje;

			if (resp.estado == 1){

				

				$('#alert-encuesta').show();
				
				setTimeout(function(){ 
					$("#alert-encuesta").hide();
				}, 5000);
			
			}else{

				$('#alert-encuesta-error').show();
				
				setTimeout(function(){ 
					$("#alert-encuesta-error").hide();
				}, 5000);

			}

		}).fail(function(obj){

			$('#alert-encuesta-error').show();
				setTimeout(function(){ 
					$("#alert-encuesta-error").hide();
			}, 5000);

		});



	 }


	 function guardarDimensionFase(){

	 	$("#frm_encuesta").submit();

	 }


	$("#frm_encuesta").submit(function(e){
		let finalizar = $("#total_input").val();

		if (finalizar) bloquearPantalla();

	// evito que propague el submit
	e.preventDefault();
		  
	// agrego la data del form a formData
	var form = document.getElementById('frm_encuesta');
	var formData = new FormData(form);
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
		}
	});

	$.ajax({
	    type:'POST',
	    data:formData,
	    url: "{{ route('frm.encuesta') }}",
	    cache:false,
	    contentType: false,
	    processData: false,
	    success:function(resp){
	      if (finalizar) desbloquearPantalla();
	      	
	      if (resp.estado == 1){

	      		$(".file_pdf").val(null);

				$('#alert-encuesta').show();
				
				setTimeout(function(){ 
					$("#alert-encuesta").hide();
				}, 5000);
			
			}else{

				$('#alert-encuesta-error').show();
				
				setTimeout(function(){ 
					$("#alert-encuesta-error").hide();
				}, 5000);

			}
		    
		},
		error: function(jqXHR, text, errors){
			if (finalizar) desbloquearPantalla();

			$('#alert-encuesta-error').show();
				setTimeout(function(){ 
					$("#alert-encuesta-error").hide();
			}, 5000);

		}

	});

});

function VolverAficha(){
	let ruta = $("#ruta_ficha_caso").val();

	alert("NCFAS-G realizado con éxito.");
	window.location.href = ruta;
}


	</script>
@endsection