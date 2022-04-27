@extends('layouts.main')


@section('contenido')
<main id="content">

	<!-- <section class=" p-1 cabecera">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-12">
					<h2><span class="oi oi-circle-check"></span> Diagnosticar Caso</h2>
				</div>
			</div>
		</div>
	</section> -->

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
					<h5>NCFAS-G</h5>

					<div class="card p-4">
						<div class="row">

							<div class="col">
								<h6>Nombre</h6>
								<h4><strong>{{ $nombres }}</strong></h4>
							</div>
							<div class="col-4">
								<h6>RUT</h6>
								<h4><strong>{{ $rut }}</strong></h4>
								<input type="hidden" id="rutsinformato" name="rutsinformato" value="{{$rutsinformato}}">
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section>
		<div class="container">
			<form action="{{route('caso.diagnostico.grabar')}}" method="post" id="miForm" enctype="multipart/form-data"  >
				{{ csrf_field() }}
				<input type="hidden" name="cas_id" value="{{$caso->cas_id}}" >
				<input type="hidden" name="opcion" value="{{$opcion}}" >
			<div class="card p-3">
				<div class="row">
					<div class="col-md-3">
						<p>Dimensiones</p>
						<hr>

						<div class="list-group" id="list-tab" role="tablist">
							@foreach($dimensiones as $d)
								<a class="list-group-item list-group-item-action" id="list-{{$d->dim_enc_id}}-list" data-toggle="list" href="#list-{{$d->dim_enc_id}}" role="tab" aria-controls="dim-{{$d->dim_enc_id}}">{{$d->dim_enc_nom}}</a>
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
													<th scope="col" style="width: 12.5%" ><small>{{$alt->alt_nom}}</small></th>
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
														<td scope="row">{{$fa->fas_nom}} </td>
														@foreach($alternativas as $alt)
														<td>
															<div class="form-check form-check-inline">
															@if (($opcion==config('constantes.en_diagnostico') && $fa->fas_id==config('constantes.ncfas_fs_ingreso'))
															or
															($opcion==config('constantes.en_cierre_paf') && $fa->fas_id==config('constantes.ncfas_fs_cierre')
															))
																<!-- <input class="form-check-input" type="radio" name="radio-{{$p->pre_id}}-{{$fa->fas_id}}" id="mi-label-{{$p->pre_id}}" value="{{$alt->alt_id}}" {{($alt->alt_ord==1)?"required":""}}> -->
																<label class="form-check-label" for="mi-label-{{$p->pre_id}}">{{$alt->alt_val}}</label>
															@else
																<label class="form-check-label" >{{$alt->alt_val}}</label>
															@endif
															</div>
														</td>
														@endforeach
													</tr>
												@else
													<tr>
														<td scope="row">{{$fa->fas_nom}}</td>
														@if($fa->fas_id < $fase_actual)
															@foreach($alternativas as $alt)
																<td>
																	<div class="form-check form-check-inline"  >
																		@if($respuestas->count()>$indice)

																			@if(intval($respuestas[$indice]->alt_id) == $alt->alt_id && $respuestas[$indice]->fas_id == $fa->fas_id  )
																				<input disabled class="form-check-input" type="radio" name="" attr1="{{$alt->alt_id}}"  value="" checked="checked" >
																			@endif
																		@endif

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
																	<label class="form-check-label" >{{$alt->alt_val}}</label>
																</div>
															</td>
															@endforeach
														@endif


													</tr>
												@endif

											@endforeach
											</tbody>
										</table>
										<hr>

									@else

										@if($p->pre_tip==2 )

											@forelse($comentarios as $com)
												@if($d->dim_enc_id==$com->dim_enc_id)
														<div class="form-group">
															<label><h5>{{$p->nom_var}}</h5></label>
															<textarea disabled onkeypress='return caracteres_especiales(event)' type="text" name="" class="form-control " >{{$com->res_com}}</textarea>
														</div>
												@endif
											@empty
												@if($fase_actual<4)
													<div class="form-group">
														<label><h5>{{$p->nom_var}}</h5></label>
														<textarea disabled onkeypress='return caracteres_especiales(event)' type="text" name="text-{{$p->pre_id}}-{{$fase_actual}}" class="form-control " placeholder="Comentario" aria-label="Comentario"></textarea>
													</div>
												@endif											
											@endforelse

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
													<!-- <div class="form-group">
														<div class="custom-file">
															<input type="file" name="file-{{$p->pre_id}}-{{$fase_actual}}" >
														</div>
													</div> -->
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
						<button type="button" id="atrasDim" class="btn btn-secondary"><span class="oi oi-arrow-left"></span> Anterior Dimensión</button>
					</div>
					<!-- <div class="col-md-2 offset-md-1">
						@if($fase_actual<4)
							<button type="submit" class="btn btn-primary btn-lg" id="diagnosticar" >Diagnosticar</button>
						@endif
					</div> -->
					<div class="col-md-2 offset-md-1" >
						<button type="button" id="adelanteDim" class="btn btn-secondary float-right" >Siguiente Dimensión <span class="oi oi-arrow-right"></span></button>
					</div>
				</div>

				@if (Session::get('perfil') == config('constantes.perfil_terapeuta'))
					<div class="row">
						<div class="col-md-2" style="margin-top:-35px;">
							<!-- <a href="javascript:history.go(-1)" type="button" id="atrasDim" class="btn btn-success"><span class="oi oi-arrow-left"></span> Volver a Ficha</a> -->
							<a href="/gestion-terapia-familiar/{{$rutsinformato}}" type="button" id="atrasDim" class="btn btn-success"><span class="oi oi-arrow-left"></span> Volver a Ficha</a>
						</div>
					</div>
				@elseif (Session::get('perfil') == config('constantes.perfil_coordinador') || || session()->all()['perfil'] == config('constantes.perfil_coordinador_regional'))
					<div class="row">
						<div class="col-md-2" style="margin-top:-35px;">
							<!-- <a href="javascript:history.go(-1)" type="button" id="atrasDim" class="btn btn-success"><span class="oi oi-arrow-left"></span> Volver a Ficha</a> -->
							<a href="/atencion-nna/{{$rutsinformato}}" type="button" id="atrasDim" class="btn btn-success"><span class="oi oi-arrow-left"></span> Volver a Ficha</a>
						</div>
					</div>
				@endif

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

			$("#miForm input[type='radio']:not(:enabled):checked").each(function(){

				var _this = this;
				var gravedad = $(_this).attr('attr1');
				$(_this).parents('td').addClass('gravedadEncuesta'+gravedad);
				$(_this).hide();

			});

			$("#miForm input[type='radio'][name^='radio-']:enabled").on("change",function(){
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
				var alternativas = $("#miForm input[type='radio'][name*='radio-']:enabled:checked").length;
				var comentados = 0;
				$("#miForm textarea:enabled").each(function(){

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
					$("#miForm").submit();
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
				$('html, body').animate({ scrollTop: 390 },3000,'swing',function(){
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
	</script>
@endsection