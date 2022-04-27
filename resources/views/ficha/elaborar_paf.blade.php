<style type="text/css">

/*.multiselect {  width: 200px; }*/
.selectBox {  position: relative; }
.selectBox select { width: 100%; font-weight: bold;}
.overSelect {position: absolute;left:0;right:0;top: 0;bottom:0;}
#checkboxes { display: none; border: 1px #dadada solid; }
#checkboxes label { display: block;}
#checkboxes label:hover { background-color: #1e90ff;}
</style>
<div class="container-fluid">
	<div class="row">
		<div class="col">
			@if (count($titulos_modal) >= 1)
				<h5 class="modal-title" id="title_ejecucion" data-id-est="{{ $titulos_modal[2]->id_est }}"><b> <i class="fas fa-archive"></i> {{ $titulos_modal[1]->titulo }}</b></h5>
			@else
				<h5 class="modal-title" id="title_ejecucion" data-id-est=""></h5>
			@endif
		</div>
		@if ($modo_visualizacion == 'edicion')
			<div class="col text-right">
				<button type="button" class="btn btn-danger btn-sm btnRechEst" data-dismiss="modal"
						@if($est_cas_fin)
							disabled 
						@else 
							onclick="comentarioEstado({{ $caso_id }});" 
						@endif >
						Desestimar Caso
				</button>
			</div>
		@endif
	</div>
	<hr>

	<!-- HIDDEN -->
		<meta name="_token" content="{{ csrf_token() }}"/>
		{{ csrf_field() }}
		<input type="hidden" name="cas_id" id="cas_id" value="{{$caso_id}}">
		<input type="hidden" id="url_listar_programa" name="url_listar_programa" value="{{ route('programa.comuna') }}">
		<input type="hidden" id="url_listar_programa_sin_aler" name="url_listar_programa_sin_aler" value="{{ route('listar.programas.sinalertas') }}">
		<input type="hidden" id="grup_fam_id" name="grup_fam_id"  value="" >
	<!-- HIDDEN -->

	<!-- Mensajes de Alertas -->
	<div class="alert alert-success alert-dismissible fade show" id="alert-exi-paf" role="alert" style="display:none;">
		Registro Guardado Exitosamente.
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<div class="aler2 alert-info alert-dismissible fade show" id="alert-err-paf" role="alert" style="display:none;">
		Error al momento de guardar el registro. Por favor intente nuevamente.
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<!-- Fin Mensajes de Alertas -->
	<!--<div class="modal-body">-->
	<!--2. Resultados Diagnóstico Integral -->
	<!--<div class="row justify-content-center">-->
	<div class="card colapsable shadow-sm">
		<a class="btn text-left p-0"  id="btn_despliegue_diagnostico_integral"  data-toggle="collapse" data-target="#listar_diagnostico_integral"aria-expanded="false" aria-controls="listar_diagnostico_integral" onclick="if($(this).attr('aria-expanded') == 'false') listarDiagnosticoIntegral({{$caso_id}});">
			<div class="card-header p-3" data-toggle="tooltip" data-placement="top" data-original-title="Revisa los resultados del Diagnótico NCFAS">
				<h5 class="mb-0">Resultados Diagnóstico Integral NCFAS-G</h5>
			</div>
		</a>
		<!--<button class="btn btn-default" id="btn_despliegue_diagnostico_integral" type="button" data-toggle="collapse" data-target="#listar_diagnostico_integral"
			aria-expanded="false" aria-controls="listar_diagnostico_integral" style="font-weight: 800; width: 100%;"
			onclick="if($(this).attr('aria-expanded') == 'false') listarDiagnosticoIntegral({{$caso_id}});">
			Resultados Diagnóstico Integral
		</button>-->
		<!-- Listar grupo familiar asociado -->
		<div class="collapse" id="listar_diagnostico_integral" style="margin-top: 15px;">
			<div class="card-body">
			@includeif('ficha.listar_diagnostico_integral')
			</div>
		</div>
	</div>
	<hr>

<!-- OBJETIVOS -->
<div>
<div class="card shadow-sm">
	<div class="card-header p-3">
		<div class="row">
			<div class="col">
				<h5 class="p-2 mb-0"><span class="badge badge-secondary">1</span> Objetivos</h5>
			</div>
			<div class="col">
				<button type="button" class="btn btn-info float-right ml-3" data-toggle="popover" title="Objetivos" data-content="Registre el detalle de los Objetivos"><i class="fa fa-info"></i></button>
			</div>
		</div>
	</div>
	<div class="card-body">
		<div class="form-group row">            
			<label class="col-sm-4 p-2 col-form-label">Nº de Tareas Comprometidas:
				<!-- INICIO DC -->
				<span id="cantComp">{{$cont_tar}}</span>
				<!-- FIN DC -->
			</label>
			                           
		</div>
		@includeif('ficha.titulo_objetivo')
		@includeif('ficha.listar_objetivos')
		@includeif('ficha.detalle_objetivo')
	</div>
</div>
</div>

<!-- FIN OBJETIVOS -->
<br>


	<!-- ALERTAS TERRITORIALES -->
	<div class="card shadow-sm">
		<div class="card-header p-3">
			<div class="row">
				<div class="col-8">
					<h5 class="p-2 mb-0"><span class="badge badge-secondary">2</span> Asignar Programas con Alerta Territorial SAN Asociada</h5>
				</div>
				<div class="col">
					<button type="button" class="btn btn-info float-right" data-toggle="popover" title="Alertas NNA" data-content="Revise el NNA y gestione los Componentes para cada alerta particular que posea este miembro"><i class="fa fa-info"></i></button>
				</div>
			</div>
		</div>
		<div class="card-body">
			@if (count($alertasXnna) == 0)
				<h6 class="text-center">No se encuentran Alertas Territoriales sin gestionar asociadas al Caso.</h6>

			@elseif (count($alertasXnna) > 0)
				@foreach ($alertasXnna AS $ca1 => $a1)
					<div class="card p-4 alert-info">
						<p class="mb-0"><i class="fa fa-user mr-2"></i> {{ $a1["persona_nombre"] }}</p>
						<br>

						@foreach ($a1["descripcion"] AS $cd1 => $d1)
						<div class="card mb-2 colapsable">
							<a class="p-2" data-toggle="collapse" data-target="#tip_ale_{{ $cd1 }}_{{$a1['per_id']}}" aria-expanded="false" aria-controls="tip_ale_{{ $cd1 }}_{{$a1['per_id'] }}">
								<div data-toggle="tooltip" data-placement="top" data-original-title="Gestiona los programas para esta alerta">
									<p class="mb-0">
										<i class="fa fa-warning mr-2"></i> 
										{{ $d1["ale_tip_nom"] }}
									</p>
								</div>
							</a>
							<div id="tip_ale_{{ $cd1 }}_{{$a1['per_id']}}" class="collapse">
								<div class="card-body">
								      	<div class="row">
								      		<div class="col">
								      			<label><b>USUARIO:</b></label><br>
								      			<small>{{ $d1["responsable"] }}</small><br>
								      			<label><b>FONO: </b></label>
								      			<small>{{ $d1["telefono"] }}</small><br>
								      			<label><b>EMAIL: </b></label>
								      			<small>{{ $d1["email"] }}</small>
								      		</div>
								      		<div class="col">
								      			<div class="float-right">
								      			<small><b>ESTADO:</b></small>
								        		<div id="est_{{$d1['ale_man_id']}}"><small style="font-weight: 800;">{{$d1['est_ale_nom']}}</small></div>

								        		@if ($modo_visualizacion == 'edicion' || $habilitar_funcion == true)	
									        		<button onclick="guardarFormPAF(5, this.value);"
									        		style="<?php if($d1['est_ale_id']==7){  } else { echo"display:none"; } ?>"
													value="{{$d1['ale_man_id']}}-1" id="btn_hab_{{$d1['ale_man_id']}}" type="button" class="btn btn-success btn-sm float-left" >Habilitar</button>
													@if($est_cas_fin == false)
														<button onclick="guardarFormPAF(5, this.value);" style="<?php if($d1['est_ale_id']==7){ echo"display:none"; } ?>" value="{{$d1['ale_man_id']}}-2" id="btn_des_{{$d1['ale_man_id']}}" type="button" class="btn btn-danger btn-sm float-left">Desestimar</button>
													@endif
												@endif

												</div>
								      		</div>
								      	</div>
								      	<hr>
								      	<div class="row">
								      		<label style="margin-left: 12px;"><b>Grupo Familiar</b></label>
								      	</div>
								      	@foreach($grupo_familiar AS $cg1 => $g1)


								      	@if ($modo_visualizacion == 'edicion' || $habilitar_funcion == true)
									     	<div class="row asignarMargin">
										      		<div class="col-5">
										      			<label><b>Nombre:</b> {{ $g1->gru_fam_nom }} {{ $g1->gru_fam_ape_pat }} {{ $g1->gru_fam_ape_mat }}</label>
										      		</div>
										      		<div class="col-4">
										      			<label><b>Parentesco:</b> {{ $g1->parentesco }}</label>
													  </div>
													@if($est_cas_fin == false)
										      		<div class="col-3">
										      			<button class="btn" style="width: 100%; background-color: #53e5c6; color: white;" onclick="asignarProgramaIntegrante1({{ $g1->gru_fam_id }}, {{ $d1['ale_man_id'] }}); $('#asignarProgramaIntegrante').modal('show');">Asignar programas</button>
													  </div>
													@endif
									      	</div>	 

									    @elseif ($modo_visualizacion == 'visualizacion')
								      		<div class="row asignarMargin">
								      			<div class="col-6">
								      				<label><b>Nombre:</b> {{ $g1->gru_fam_nom }} {{ $g1->gru_fam_ape_pat }} {{ $g1->gru_fam_ape_mat }}</label>
								      			</div>
								      			<div class="col-6">
								      				<label><b>Parentesco:</b> {{ $g1->parentesco }}</label>
								      			</div>
								      		</div>	
									    @endif  	

								      	@endforeach
								</div>
							</div>	
						</div>
						@endforeach
					</div>	
				@endforeach

			@endif
		</div>	
	</div>	


	@includeif('ficha.formulario_asignacion_programa')

	@includeif('ficha.formulario_asignacion_programa_sin_alerta')

	@php $cont=1; $elemt=0;  $elemt_ofe=0; @endphp

<!-- FIN ALERTAS TERRITORIALES -->

<!-- ASIGNAR PROGRAMAS SIN AT ASOCIADA -->

	<div class="card shadow-sm">
		<div class="card-header p-3">
			<div class="row">
				<div class="col-8">
					<h5 class="p-2 mb-0">
						<span class="badge badge-secondary">3</span> 
						Asignar Programas Sin Alerta Territorial SAN Asociada
					</h5>
				</div>
				<div class="col">
					<button type="button" class="btn btn-info float-right" data-toggle="popover" title="Asignar Programas" data-content="Asignar Programas sin AT Asociada"><i class="fa fa-info"></i></button>
				</div>
			</div>
		</div>

		<div class="card-body">
			<div class="card p-4 alert-info">
				<div class="row">
					<label style="margin-left: 12px;"><b>Grupo Familiar</b></label>
				</div>
				@foreach($grupo_familiar AS $cg1 => $g1)
					@if ($modo_visualizacion == 'edicion' || $habilitar_funcion == true)
						<div class="row asignarMargin">
							<div class="col-5">
								<label><b>Nombre:</b> {{ $g1->gru_fam_nom }} {{ $g1->gru_fam_ape_pat }} {{ $g1->gru_fam_ape_mat }}</label>
							</div>
							<div class="col-4">
								<label><b>Parentesco:</b> {{ $g1->parentesco }}</label>
							</div>
							
							@if($est_cas_fin == false)
							<div class="col-3">
								<button class="btn" style="width: 100%; background-color: #53e5c6; color: white;" onclick="asignarProgramaIntegranteSinAlerta({{ $g1->gru_fam_id }});">Asignar programas</button>
							</div>
							@endif
						</div>	 

					@elseif ($modo_visualizacion == 'visualizacion')
						<div class="row asignarMargin">
							<div class="col-6">
								<label><b>Nombre:</b> {{ $g1->gru_fam_nom }} {{ $g1->gru_fam_ape_pat }} {{ $g1->gru_fam_ape_mat }}</label>
							</div>
							<div class="col-6">
								<label><b>Parentesco:</b> {{ $g1->parentesco }}</label>
							</div>
						</div>	 

					@endif
				@endforeach
			</div>	
		</div>
	</div>
	<br>
<!-- FIN ASIGNAR PROGRAMAS SIN AT ASOCIADA -->


<!-- TERAPIA -->
@if ($modo_visualizacion == 'visualizacion' || $modo_visualizacion == 'edicion')
<div class="card shadow-sm">
	<div class="card-header p-3">
			<div class="row">
				<div class="col">
					<h5 class="p-2 mb-0"><span class="badge badge-secondary">4</span>  Terapia</h5>
				</div>
				<div class="col">
					<button type="button" class="btn btn-info float-right" data-toggle="popover" title="Terapia" data-content="Seleccione si este grupo familiar necesita Plan de Atención Familiar"><i class="fa fa-info"></i></button>
				</div>
			</div>
	</div>

	<div class="card-body">
		<div class="row">
			<div class="col-md-12">
				<div class="border p-3">
					@if ($modo_recomendacion == "visualizar")

						@if ($nombre_terapeuta_asignado == 'na')
							<label>Terapeuta: <b>No requiere terapia.</b></label><br>
							<label>Justificación Terapia: <b>Sin información.</b></label>

						@elseif ($nombre_terapeuta_asignado != 'na')
							<div class="col-12">
								<label>Terapeuta: 
									@if ($nombre_terapeuta_asignado == "necesita_terapia")
										<b>En proceso de asignación de Terapeuta.</b>
									@elseif ($nombre_terapeuta_asignado != "necesita_terapia")
										<b>{{$nombre_terapeuta_asignado}}</b>
									@endif
								</label>
							</div><br>
							<div class="col-12">
								<label>Justificación Terapia: </label>

								@if ($just_terapia) 
									<label class="font-weight-bold" style="word-break: break-all;">{{$just_terapia}}</label>

								@elseif (!$just_terapia)	
									<label class="font-weight-bold">Sin información.</label>
								
								@endif
							</div>
						@endif

					@elseif ($modo_recomendacion == "editar")
						<label><b>¿Necesita Terapia?</b></label>
						<select class="form-control" name="nec_ter[]" id="nec_ter" onchange="habilitarJustificacionRecomendacion($('#nec_ter').val()); guardarRecomendacion(); @if(config('constantes.en_elaboracion_paf') != $estado_actual_caso) bloquearSelectorRecomendacion($('#nec_ter').val()); @endif">
							<option value="" @if($necesita_terapeuta == "") selected @endif>Seleccione una opción</option>
							<option value="1" @if($necesita_terapeuta === "1") selected @endif>Sí</option>
							<option value="0" @if($necesita_terapeuta === "0") selected @endif>No</option>
						</select><br>
						<div id="seccion_justificacion_recomendacion" @if($necesita_terapeuta != "1") style="display: none;" @endif>
							<label><b>Justificación Terapia:</b></label>
							<textarea maxlength="2000" onkeypress='return caracteres_especiales(event)' class="form-control " name="cas_just_terapia" id="cas_just_terapia" rows="3" onchange="guardarRecomendacion();">{{ $just_terapia }}</textarea>
						</div>	
					@endif
	      		</div>
	      	</div>
		</div>
	</div>
</div>
<br>
@endif
<!-- FIN TERAPIA -->

<!-- DOCUMENTO -->
<!--<hr>-->
<div class="card shadow-sm">
	<div class="card-header p-3">
		
			<div class="row">
				<div class="col">
					<h5 class="p-2 mb-0"><span class="badge badge-secondary">5</span>  Documentos</h5>
				</div>
				<div class="col">
					<button type="button" class="btn btn-info float-right" data-toggle="popover" title="Documentos" data-content="Descargue el documento resumen del Plan de Atención Familiar para que sea revisado y aprobado por los usuarios"><i class="fa fa-info"></i></button>
				</div>
			</div>
	</div>
	<div class="card-body">
		@if ($modo_visualizacion == 'edicion' || ($modo_visualizacion == 'visualizacion' && $habilitar_funcion == true))
			<form enctype="multipart/form-data" id="adj_paf" method="post">
				<div class="alert alert-success alert-dismissible fade show" id="alert-docu-paf-exito" role="alert" style="display:none;">
					Documento subido satisfactoriamente.
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="alert alert-danger alert-dismissible fade show" id="alert-docu-paf-error" role="alert" style="display:none;">
					Error al momento de subir el documento. Por favor intente nuevamente..
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="border p-3 bg-light form-group">
							<div class="row">
								<dt class="col-sm-1"> <h4><span class="badge badge-secondary">a</span></h4></dt>
								<dd class="col-sm-11"> 
									<p>Descargue el siguiente documento con el Plan de Atención Familiar para que la familia involucrada firme voluntariamente</p>
									<a href="{{ route('imprimir.paf') }}/{{ $run }}/{{$caso_id}}" id="imp_doc" aria-describedby="imp_doc_ayu" class="btn btn-primary" ><i class="fa fa-print"></i> Descargar Documento</a>
									<small id="imp_doc_ayu" class="form-text text-muted">*El documento debe ser firmado por la Familia del NAA y el Gestor correspondiente.</small>
								</dd>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="border p-3 bg-light form-group">
							<div class="row">
								<dt class="col-sm-1"><h4> <span class="badge badge-secondary">b</span></h4></dt>
								<dd class="col-sm-11">
									<p>Un vez firmado el documento con el Plan de Atención Familiar por los involucrados, debe ser digitalizado (escaneo o fotografía) para volver a cargarlo al sistema por este conducto</p>
									<p>Cargar Documento</p>
									<div class="btn btn-primary" style="width: 100%;">
									<!-- INICIO CZ SPRINT 59 -->
									@if($est_cas_fin)
										<input disabled type="file" name="archivo" id="archivo">
										<input disabled type="hidden" name="cas_id" id="cas_id" value="{{$caso_id}}"> 
									@else 
										<input type="file" name="archivo" id="archivo">
										<input type="hidden" name="cas_id" id="cas_id" value="{{$caso_id}}">
									@endif
									<!-- FIN CZ SPRINT 59 -->
									</div>
									<small class="form-text text-muted">* Solo subir documentos con las siguientes extensiones: doc, docx o pdf.<br> Tamaño máximo permitido: 5 MB.</small>
								</dd>
							</div>
						</div>
					</div>
				</div>
			</form>

		@elseif ($modo_visualizacion == 'visualizacion')
			<div class="border p-3 bg-light text-center">
				<label>Descargue el Plan de Atención Familiar actual de este caso haciendo <a href="{{ route('imprimir.paf') }}/{{ $run }}/{{$caso_id}}" class="text-primary"> Click aquí.</a></label>
			</div>
			
		@endif
	</div>
</div>
<br>
<div class="card colapsable shadow-sm">
	<a class="btn text-left p-0" id="btn_despliegue_historial_plan_de_accion2"  data-toggle="collapse" data-target="#listar_historial_doc_paf"aria-expanded="false" aria-controls="listar_historial_doc_paf">
		<div class="card-header p-3" data-toggle="tooltip" data-placement="top" data-original-title="Revisa el Historial de este Plan de Acción">
			<h5 class="mb-0">Historial Plan de Atención Familiar</h5>
		</div>
	</a>
	<div class="container-fluid collapse" id="listar_historial_doc_paf">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table"  style="width: 100%;" id="tabla_doc_paf" >
					<thead>
						<tr>
							<th>Fecha Creación</th>
							<th>Documento</th>
							<th>Descarga</th>
						</tr>
					</thead>
				<tbody></tbody>
			</table>
		</div>
	</div>
</div>
</div>
<!-- <div class="row justify-content-center">
	<button class="btn btn-default" id="btn_despliegue_diagnostico_integral" type="button" data-toggle="collapse" data-target="#listar_historial_doc_paf"
		aria-expanded="false" aria-controls="listar_diagnostico_integral" style="font-weight: 800; width: 100%;"
		>
		Historial Plan de Acción Familiar
	</button>
</div> -->
<!-- 					<div class="container-fluid collapse" id="listar_historial_doc_paf">
	<div class="table-responsive">
			<table class="table"  style="width: 100%;" id="tabla_doc_paf" >
					<thead>
						<tr>
								<th>Fecha Creación</th>
								<th>Documento</th>
						</tr>
					</thead>
				<tbody></tbody>
		</table>
	</div>
</div>
-->

<!--					<h4><img src="/img/ico-alertas.svg" width="30px" height="30px"/> Historial Documentos PAF</h4>
	<div class="table-responsive">
		<table class="table"  style="width: 100%;" id="tabla_doc_paf" >
			<thead>
				<tr>
						<th>Fecha Creación</th>
						<th>Documento</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
</div>
-->
<!-- FIN DOCUMENTO -->



		<!-- BITACORA ACTUAL CASO -->
		<div class="card shadow-sm alert-info">
			<div class="card-header p-3">
				<h5 class="mb-0"><i class="fa fa-pencil"></i>  Bitácora Estado Actual del Caso</h5>
			</div>
			<div class="card-body">
				<label for="bitacora_estado_ejecucion" style="font-weight: 800;">Bitácora Estado Actual del Caso:</label>
				<!-- <textarea onkeypress='return caracteres_especiales(event)' class="form-control txtAreEtapa " name="bit-etapa-elaborar" id="bitacora_estado_ejecucion" rows="3" onBlur="cambioEstadoCaso(4, {{ $caso_id }}, $(this).val());"
				@if(config('constantes.en_elaboracion_paf')!= $estado_actual_caso)) disabled @endif>{{ $bitacoras_estados[1] }}</textarea> -->

				@if ($modo_visualizacion == 'visualizacion')
					<div class="text-success" style="word-break: break-all;">
						<label class="font-weight-bold">{{ $bitacoras_estados[1] }}</label>
					</div>
				@elseif ($modo_visualizacion == 'edicion')
					<textarea maxlength="2000" onkeypress='return caracteres_especiales(event)' class="form-control txtAreEtapa " name="bit-etapa-elaborar" id="bitacora_estado_ejecucion" rows="3" onBlur="cambioEstadoCaso('b4', {{ $caso_id }}, $(this).val());"
					@if(config('constantes.en_elaboracion_paf')!= $estado_actual_caso)) disabled @endif>{{ $bitacoras_estados[1] }}</textarea>
				@endif

<!-- 				<button type="button" id="btn-etapa-elaborar" class="btn btn-success btnEtapa" style="float: right;" onclick="siguienteEtapa(9, {{ $caso_id }});" disabled>
					Ir a siguiente etapa - <strong>Ejecución PAF</strong>
				</button> -->
			</div>
		</div>
		<!-- FIN BITACORA ACTUAL CASO -->

	</div>
	<!-- BOTONES CAMBIOS DE ESTADOS -->
				<!-- <button type="button" id="btn-etapa-elaborar" class="btn btn-success btnEtapa" style="float: right;" onclick="siguienteEtapa(9, {{ $caso_id }});" disabled>
					Ir a la siguiente etapa - <strong>Ejecución PAF</strong>
				</button> -->
				@if ($modo_visualizacion == 'edicion')
				<button type="button" id="btn-etapa-elaborar" class="btn btn-success btnEtapa" style="float: right;" onclick="siguienteEtapa({{config('constantes.en_ejecucion_paf')}}, {{ $caso_id }});" disabled>
					Ir a la siguiente etapa - <strong>Ejecución PAF</strong>
				</button>
				@endif

<!-- FIN BOTONES CAMBIOS DE ESTADOS -->

<script type="text/javascript">

	//----------------RECOMENDACION A TERAPIA ------------------
	function guardarRecomendacion(){
		let data = new Object();
		data.option 	= 1;
		data.caso_id 	= $("#cas_id").val();
		data.nec_ter 	= $("#nec_ter").val();
		data.cas_just_terapia = $("#cas_just_terapia").val();

		$.ajaxSetup({
			headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}
		});


		$.ajax({
			url: "{{ route('elaborar.paf') }}",
			type: "POST",
			data: data
		}).done(function(resp){

			if (resp.estado == 1){
				$("#alert-exi-paf").show();
				setTimeout(function(){ $("#alert-exi-paf").hide(); }, 5000);
				
			}else if (resp.estado == 0){
				$("#alert-err-paf").show();
				setTimeout(function(){ $("#alert-err-paf").hide(); }, 5000);
			}
		}).fail(function(obj){
			$("#alert-err-paf").show();
			setTimeout(function(){ $("#alert-err-paf").hide(); }, 5000);

			console.log(obj); return false;
		});
	}

	function habilitarJustificacionRecomendacion(opcion){
		if (opcion == 1){ //visible
			$("#seccion_justificacion_recomendacion").show();

		}else if (opcion == 0 || opcion == ""){ //Oculta
			$("#seccion_justificacion_recomendacion").hide();
			$("#cas_just_terapia").val("");

		}
	}

	function bloquearSelectorRecomendacion(opcion){
		if (opcion == 1){
			$("#nec_ter").attr("disabled", "true");
		}
	}
	//----------------RECOMENDACION A TERAPIA ------------------



	function elemt(tip,elemt){
		
	//alert(elemt+'--'+elemt);

		if(tip==1) $("#group-of-rows-"+elemt).removeClass("show");
		
		if(tip==2) $("#group-of-rows-eyes-"+elemt).removeClass("show");

	}		

	var expanded = false;
		function showCheckboxes(elemt) {
		var checkboxes = document.getElementById("checkboxes_"+elemt);
		if (!expanded) {
		checkboxes.style.display = "block";
		expanded = true;
		} else {
		checkboxes.style.display = "none";
		expanded = false;
		}
		}
	$( document ).ready(function() {

		$(function() {
			$('.chkgrupfam').multiselect({
			includeSelectAllOption: false
			});
		});
		//ACORDEON OFERTA PARENTESCO
		$('.acordeon__contenedor').on('click','h6',function(){
			var t = $(this);
			var tp = t.next();
			var p = t.parent().siblings().find('div');
			tp.slideToggle();
			p.slideUp();
		});
		cargarHistPaf();
		//ADJUNTAR DOCUMENTO PAF
		$("#archivo").change(function(e) {
			$("#adj_paf").submit();
		});
		//$("#archivo").change(function(e) {

		$("#adj_paf").submit(function(e){

			bloquearPantalla();

			// evito que propague el submit
			e.preventDefault();
		
			// agrego la data del form a formData
			var form = document.getElementById('adj_paf');
			var formData = new FormData(form);
			formData.append('_token', $('input[name=_token]').val());
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
				}
			});

			$.ajax({
			type:'POST',
			url: "{{ route('enviararh') }}",
			data:formData,
			cache:false,
			contentType: false,
			processData: false,
			success:function(resp){

				desbloquearPantalla();

				if (resp.estado == 1){
					tabla_doc_paf.destroy();
					cargarHistPaf();

					$("#alert-docu-paf-exito").show();
					setTimeout(function(){ $("#alert-docu-paf-exito").hide(); }, 10000);
				
				}else if (resp.estado == 0){
					$("#alert-docu-paf-error").show();
					$("#alert-docu-paf-error").text(resp.mensaje);

					setTimeout(function(){ $("#alert-docu-paf-error").hide(); }, 10000);
					setTimeout(function(){  
						$("#alert-docu-paf-error").text('Error al momento de subir el documento. Por favor intente nuevamente.');
					}, 10000);
					
				}
			},
			error: function(jqXHR, text, error){

				desbloquearPantalla();
				
				$("#alert-docu-paf-error").show();

				setTimeout(function(){ $("#alert-docu-paf-error").hide(); }, 5000);
			}
			});
		});
		//FIN ADJUNTAR DOCUMENTO PAF




	});
	//CARGA EL HISTORIAL PAF
	function cargarHistPaf(){
		
			var cas_id = $("#cas_id").val();
			tabla_doc_paf = $('#tabla_doc_paf').DataTable({
				//"paging":   false,
				"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json" },
					"ajax": "{{ route('doc.paf') }}/"+cas_id,
					"columns": [
						{ "data": "doc_fec", "className": "text-center" },
						{ "data": "doc_paf_arch", "className": "text-center" },
						{
						'render': function (data, type, full, meta) {
							return 	'<a href="/doc/'+full.doc_paf_arch+'" target="_blank" >Descargar Documento</a>';
						}, "className": "text-center"
					}
					]
				});
			$(".alert").hide();
			if ($("#nec_ter").val() == 1) $("#cont_ter").css("display", "block");
	}
	function validarFrm(){
		//Validar form antes de imprimir
	}

// 	function activarTerapeutas(){
// 		let ele_sel = $("#nec_ter").val();
// 		let respuesta = "none";
// if (ele_sel === "" || typeof ele_sel === "undefined"){
// 			$("#cont_ter").css("display", "none");
// 		}else if (ele_sel === "0"){
// 			respuesta = false;
// 			$("#cont_ter").css("display", "none");
// 		}else if (ele_sel === "1"){
// 			respuesta = true;
// 			$("#cont_ter").css("display", "block");
// 		}
// 		if (respuesta == true || respuesta == false) guardarFormPAF(1, ele_sel);
// 	}




	function filtroOfeAsoc(){
			var chk_com	= $('input[name="ofe_id[]"]:checked');
		total = chk_com.length;
		return total;
	}
	function guardarFormPAF(option, valor){

		let data = new Object();
		data.option = option;
		data.valor = valor;
		data.caso_id = $("#cas_id").val();

		if (option == 1){ //Asignacion terapia caso
			$("#cas_just_terapia").val("");
			$("#ter").val("");
		}	

		if (option == 3){ //Asignacion de ofertas x alerta
			let des_val = valor.split("-");
			if (des_val.length < 2){
				$("#alert-err").show();
				setTimeout(function(){ $("#alert-err").hide(); }, 5000);
				return false;
			}
						
			data.ofe_id = des_val[0];
			data.ale_id = des_val[1];
			data.parent_id = des_val[2];
			var am_ofe_id = des_val[3];
			
		}
		
			if (option == 5){ //Cambia estado alerta territorial a "NO CORRESPONDE"
			let btn_val = valor.split("-");
			data.valor= btn_val[0];
			data.btn= btn_val[1];
			var texto;
			if(data.btn==2){ texto = "descartar"; } else { texto = "habilitar"; }
			if (confirm('¿Esta seguro que desea '+texto+' esta alerta territorial?')) {
				if(data.btn==2){
					var justificar = prompt("Favor ingrese justificación para el estado 'No corresponde'");
					var lar_text = justificar.length;
					if(lar_text<=2) { justificar=null; }
					while (!justificar) {
						
					var justificar = prompt("Favor ingrese justificación para el estado 'No corresponde con el minimo de caracteres'");
					lar_text = justificar.length;
					if(lar_text<2) { justificar=null; }
					}
		
					data.justificar=justificar;
				}
			} else {
			return false;
				}
		}
		if (option == 6){  // HABILITA O DESESTIMA ASIGNACION OFERTA.
			let btn_val = valor.split("-");
			data.ofe_id = btn_val[0];
			data.ale_man_id = btn_val[1];
			data.gru_fam_id = btn_val[2];
			data.btn = btn_val[3];
			var elemt = btn_val[4];
		
			var texto;
			if(data.btn==1){ texto = "descartar"; } else { texto = "habilitar"; }
			if (confirm('¿Esta seguro que desea '+texto+' esta oferta?')) {
				if(data.btn==1){
					var justificar = prompt("Favor ingrese justificación para el estado 'No corresponde'");
					var lar_text = justificar.length;
					if(lar_text<=2) { justificar=null; }
					while (!justificar) {
						
					var justificar = prompt("Favor ingrese justificación para el estado 'No corresponde con el minimo de caracteres'");
					lar_text = justificar.length;
					if(lar_text<2) { justificar=null; }
					}
		
					data.justificar=justificar;
				}
			} else {
			return false;
				}
		}
		$.ajaxSetup({
			headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}
		});
		$.ajax({
			url: "{{ route('elaborar.paf') }}",
			type: "POST",
			data: data
		}).done(function(resp){
			if (resp.estado == 1){
				$("#alert-exi-paf").show();
				setTimeout(function(){ $("#alert-exi-paf").hide(); }, 5000);
				if(option==3){
				$("#btn_ofe_no_"+am_ofe_id).prop('disabled', false);
				$("#grup_fam_id_"+am_ofe_id).prop('disabled', true);
				}
				if(option==5){
					if (data.btn==2){
						$("#btn_des_"+data.valor).hide();
						$("#btn_hab_"+data.valor).show();
						$("#est_"+data.valor).html('<small style="font-weight: 800;">No corresponde</small>');
						$(".ofe_"+data.valor).prop('disabled', true);
					
					}else {
						$("#btn_hab_"+data.valor).hide();
						$("#btn_des_"+data.valor).show();
						$("#est_"+data.valor).html('<small style="font-weight: 800;">Sin Gestionar</small>');
						$(".ofe_"+data.valor).prop('disabled', false);
					
					}

					location.reload();
				}
				if(option==6){
					if(data.btn==1){
					// $("#btn_ofe_no_"+elemt).hide();
					// $("#btn_ofe_hab_"+elemt).show();
					$("#btn_ofe_no_"+elemt).prop('disabled', true);
					}
					else {
					// $("#btn_ofe_hab_"+elemt).hide();
					// $("#btn_ofe_no_"+elemt).show();
					}
				}
			}else if (resp.estado == 0){
				$("#alert-err-paf").show();
				setTimeout(function(){ $("#alert-err-paf").hide(); }, 5000);
			}
		}).fail(function(obj){
			//console.log("03");
			console.log(obj); return false;
			//$("#alert-err").show();
			//setTimeout(function(){ $("#alert-err").hide(); }, 5000);
		});
	}

	$(function () {
	  $('[data-toggle="popover"]').popover()
	})
	$(function () {
	  $('[data-toggle="tooltip"]').tooltip()
	})

	function asignarProgramaIntegrante1(gru_fam_id, id_alerta){
        let tabla_programas_con_alertas = $('#tabla_programas_con_alertas').DataTable();
        tabla_programas_con_alertas.clear().destroy();

		$('[data-toggle="tooltip"]').tooltip('hide');
		
		var est_act_cas = $("#est_act_cas").val();
		var cas_id = $("#cas_id").val();
		
		let data = new Object();
		data.id_familiar = gru_fam_id;
		data.id_alerta 	= id_alerta;

        tabla_programas_con_alertas = $('#tabla_programas_con_alertas').DataTable({
            "language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
            "lengthChange": false,
            "info": 		false,
            "ajax": {
                "url": "{{ route('elaborarpaf.desplegar.asignar') }}",
                "type": "GET",
                "data": data
            },
            "columnDefs": [
                { //PROGRAMA
                    "targets": 0,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");                        
                    
                    }
                },
                { //RESPONSABLE
                    "targets": 1,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");                        
                    
                    }
                },
                { //ESTABLECIMIENTO
                    "targets": 2,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");                        
                    
                    }
                },
                { //ACCIONES
                    "targets": 3,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");                        
                    
                    }
                },
                { //OBSERVACIONES
                    "targets": 4,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");                        
                    
                    }
                }
            ],				
            "columns": [
                    { //PROGRAMA
                        "data": "pro_nom"
                    },
                    { //RESPONSABLE
                        "data": "",
                        "className": "text-center",
						"render" : function (data, type, row){
							$("#nom-int-asig").text(row.integrante);

							let html = '<span id="sectorialista_'+row.prog_id+' class="d-inline-block" tabindex="0" data-toggle="tooltip" title="'+row.contacto+'"><button class="btn btn-primary" style="pointer-events: none;" type="button"><i class="fa fa-user-circle"></i></button></span>';
							
							return html;
						}
                    },
                    { //ESTABLECIMIENTO
                        "data": "estab_nom"
                    },
                    { //ACCIONES
                        "data": "",
                        "className": "text-center",
						"render" : function (data, type, row){
								let html = '';

								if ( row.asignar == "checked" ){									
									html = '<p style="color:#1cc88a;"><b>ASIGNADO</b></p>';						
									
								}else{
									if (row.brecha != 0){
										html = '<p style="color:red"><b>BRECHA</b></p>';
										
									}else{
										html = '<button data-toggle="tooltip" title="Presione SI para asignar el programa" type="button" style="width:50%;" class="btn btn-outline-primary btn-sm" onclick="guardarAsignacionPrograma('+row.prog_id+', '+row.id_ale+', '+row.id_fam+', '+row.id_tip_ale+', 0, '+row.estab_id+');">Si</button><button data-toggle="tooltip" title="Presione NO para generar Brecha" type="button" style="width:50%;" class="btn btn-outline-primary btn-sm" onclick="registrarBrecha('+row.prog_id+','+cas_id+','+row.id_fam+','+row.id_ale+');">No</button>';
										
									}
								}
								
								return html;	
							}
                        },
                        { //OBSERVACIONES
                            "data": "",
                            "className": "text-center",
							"width":    "117px",
							"render": function(data, type, row){
								let observacion_brecha = row.observacion_brecha;
								if (observacion_brecha==null){
									observacion_brecha = '';
								}
							
								if((row.brecha!=0)){
									html = "<textarea maxlength=2000 data-obs-bre='"+row.brecha+"' onkeypress='return caracteres_especiales(event)' onBlur='guardarObservacionBrecha("+row.brecha+",$(this).val());' class='form-control ' rows='3' id='observacion_brecha_"+row.prog_id+"_"+cas_id+"_"+gru_fam_id+"' name='observacion_brecha_"+row.prog_id+"_"+cas_id+"_"+gru_fam_id+"'>"+observacion_brecha+"</textarea>";
								}else{
									html = "<textarea disabled maxlength=2000 data-obs-bre='"+row.brecha+"' onkeypress='return caracteres_especiales(event)' onBlur='guardarObservacionBrecha("+row.brecha+",$(this).val());' class='form-control ' rows='3' id='observacion_brecha_"+row.prog_id+"_"+cas_id+"_"+gru_fam_id+"' name='observacion_brecha_"+row.prog_id+"_"+cas_id+"_"+gru_fam_id+"'>"+observacion_brecha+"</textarea>";
								}

								return html;
										
                            }
                        }
                    ],
					//CZ SPRINT 74 -->
					"fnDrawCallback": function( oSettings ) {
				// se aplica estilo a los tooltips de todas las paginas
				console.log($('#tabla_programas_con_alertas').children('tbody').children('tr').children('td')[0].innerHTML);
				var mensaje = $('#tabla_programas_con_alertas').children('tbody').children('tr').children('td')[0].innerHTML;
				if(mensaje == 'Ningún dato disponible en esta tabla'){
					console.log("entro al mensaje");
					$(".mensaje_tabla").css("display", "block");
					$(".mensaje_tabla").html('<hr><div class="alert alert-warning" role="alert"><span class="badge badge-warning mr-3"><i class="fa fa-info"></i></span>No existen responsables y establecimiento para el o los programas. Por favor comuníquese con el coordinador para su definición en el mapa de ofertas.</div>');
					$(".tabla_derivarProgramaConAlerta").css("display", "none");
				}else{
					$(".tabla_derivarProgramaConAlerta").css("display", "block");
					$(".mensaje_tabla").css("display", "none");
				}
			}
			//CZ SPRINT 74 -->
            });
    }

	function habilitarCheckPrograma(index){
		$('[data-toggle="tooltip"]').tooltip('hide');
		$('#programa-check-'+index).attr("disabled", false);	
	}

	function habilitarCheckEstablecimiento(prog_id,establecimiento_id){
		$('[data-toggle="tooltip"]').tooltip('hide');
		$('#programa-check-estab-'+prog_id+'-'+establecimiento_id).attr("disabled", false);	
	}

	function guardarAsignacionPrograma(prog_id, id_ale, id_gru_fam, id_tip_ale, index, estab_id = null){
		let confirmacion = confirm("¿Confirma asignar el Programa?");
  		if (!confirmacion) return false;

		bloquearPantalla();
		
		let data = new Object();
		data.prog_id 	= prog_id;
		data.id_ale 	= id_ale;
		data.id_gru_fam = id_gru_fam;
		data.id_tip_ale = id_tip_ale;
		data.estab_id 	= estab_id;
		data.cas_id 	= $("#cas_id").val();

		$.ajax({
			url: "{{ route('elaborarpaf.desplegar.guardar') }}",
			type: "GET",
			data: data
		}).done(function(resp){
			desbloquearPantalla();

			if (resp.estado == 1){
				asignarProgramaIntegrante1(id_gru_fam, id_ale);
				mensajeTemporalRespuestas(1, resp.mensaje);

			}else if (resp.estado == 0){
				let mensaje = "Hubo un error al momento de asignar programa. Por favor intente nuevamente.";

				mensajeTemporalRespuestas(0, mensaje);
			}
		}).fail(function(obj){
			desbloquearPantalla();

			let mensaje = "Hubo un error al momento de asignar programa. Por favor intente nuevamente.";
			
			mensajeTemporalRespuestas(0, mensaje);
		});
	}

	function desestimarAsignacionPrograma(prog_id, id_ale, id_gru_fam, id_am_prog, index, estab_id = null){
		let data = new Object();
		data.prog_id 	= prog_id;
		data.id_ale 	= id_ale;
		data.id_gru_fam = id_gru_fam;
		data.id_am_prog = id_am_prog;
		data.estab_id 	= estab_id;

		$.ajax({
			url: "{{ route('elaborarpaf.desplegar.desestimar') }}",
			type: "GET",
			data: data
		}).done(function(resp){
			if (resp.estado == 1){
				if (estab_id != "" && typeof estab_id != "undefined" && estab_id != null){
					let funcion = 'desestimarAsignacionPrograma('+prog_id+', '+id_ale+', '+id_gru_fam+', null,'+index+', '+estab_id+');';


					$(".pro-estab-"+prog_id).removeAttr("disabled");
					$(".pro-estab-"+prog_id).prop('checked', false);

					//$("#programa-check-estab-"+prog_id+"-"+index).removeAttr("checked");

					$("#btn-check-des-"+prog_id+"-"+index).removeAttr("onclick");
					$("#btn-check-des-"+prog_id+"-"+index).attr("onclick", funcion);
					$("#btn-check-des-"+prog_id+"-"+index).hide();	

				}else{
					let funcion = 'desestimarAsignacionPrograma('+prog_id+', '+id_ale+', '+id_gru_fam+', null, '+index+');';

					$("#programa-check-"+index).removeAttr("disabled");

					//$("#programa-check-"+index).removeAttr("checked");
					$("#programa-check-"+index).prop('checked', false);

					$("#btn-check-des-"+index).removeAttr("onclick");
					$("#btn-check-des-"+index).attr("onclick", funcion);
					$("#btn-check-des-"+index).hide();

				}

				asignarProgramaIntegrante1(id_gru_fam, id_ale);

			}else if (resp.estado == 0){
				let mensaje = "Hubo un error al momento de eliminar la derivación de la asignación del programa. Por favor intente nuevamente.";

				console.log(resp.mensaje);
				alert(mensaje);
			}
		}).fail(function(obj){
			let mensaje = "Hubo un error al momento de eliminar la derivación de la asignación del programa. Por favor intente nuevamente.";

			console.log(obj);
			alert(mensaje);
		});
	}



	function listarProgramasSinAlertas(gru_fam_id){
		let tabla_programas_sin_alertas = $('#tabla_programas_sin_alertas').DataTable();

        tabla_programas_sin_alertas.clear().destroy();	

		var url_listar_programa = $('#url_listar_programa').val();

		let data = new Object();
		let cas_id = $('#cas_id').val();
		data.grup_fam_id = gru_fam_id;
		data.cas_id = cas_id;
		tabla_programas_sin_alertas = $('#tabla_programas_sin_alertas').DataTable({
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			"ajax"		: 
				{ 
					"url" :	url_listar_programa,
					"type": "GET",  
					"data": data ,
				},
				"rowsGroup" : [0],
				"ordering":false,
			"columns":[
				{																		
					"data": 		"pro_nom",
					"name": 		"pro_nom",
					"width": 		"200px",
					"className": 	"left-center",
				},
				{																		
					"data": 		"",
					"name": 		"sectorialista",
					"width": 		"20px",
					"className": 	"left-center",
					"render" : function (data, type, row){
						let html = "<span id='sectorialista_"+row.prog_id+"' class='d-inline-block' tabindex='0' data-toggle='tooltip' title='"+row.contacto_establecimiento+"'><button class='btn btn-primary' style='pointer-events: none;' type='button'><i class='fa fa-user-circle'></i></button></span>";

						return html;
					}
				},
				{
					"data": "estab_nom", 
					"className": "text-center",
					"width": "200px"
				},
				{
					"data": "", 
					"className": "text-center",
					"width": "200px",
					"render" : function (data, type, row){
						let html = '';

						if (row.estab_asig == 1){	
								html = '<p style="color:#1cc88a;"><b>ASIGNADO</b></p>';						
						
						}else{
							if(row.brecha != 0){
								html = '<p style="color:red"><b>BRECHA</b></p>';
							
							}else{
								html = '<button data-toggle="tooltip" title="Presione SI para asignar el programa" type="button" style="width:50%;" class="btn btn-outline-primary btn-sm" onclick="asignarProgGrupFam('+row.prog_id+','+row.estab_id+',\''+row.pro_nom+'\');">Si</button><button data-toggle="tooltip" title="Presione NO para generar Brecha" type="button" style="width:50%;" class="btn btn-outline-primary btn-sm" onclick="registrarBrecha('+row.prog_id+','+cas_id+','+gru_fam_id+',-1);">No</button>';
								
							}
						}

						return html;
					}
				},
		        {
		          "data": "", 
		          "className": "text-center",
		          "render" : function (data, type, row){

					let observacion_brecha = row.observacion_brecha;

					if (observacion_brecha==null){
						observacion_brecha = '';
					}

					if((row.brecha!=0)){

 		            	html = "<textarea maxlength=2000 data-obs-bre='"+row.brecha+"' onkeypress='return caracteres_especiales(event)' onBlur='guardarObservacionBrecha("+row.brecha+",$(this).val());' class='form-control ' rows='3' id='observacion_brecha_"+row.prog_id+"_"+cas_id+"_"+gru_fam_id+"' name='observacion_brecha_"+row.prog_id+"_"+cas_id+"_"+gru_fam_id+"'>"+observacion_brecha+"</textarea>";

 		            }else{

 		            	html = "<textarea disabled data-obs-bre='"+row.brecha+"' maxlength=2000 onkeypress='return caracteres_especiales(event)' onBlur='guardarObservacionBrecha("+row.brecha+",$(this).val());' class='form-control ' rows='3' id='observacion_brecha_"+row.prog_id+"_"+cas_id+"_"+gru_fam_id+"' name='observacion_brecha_"+row.prog_id+"_"+cas_id+"_"+gru_fam_id+"'>"+observacion_brecha+"</textarea>";
 		            }

		            return html;
		          },
		          "width":    "117px"
		        }
			],
			"fnDrawCallback": function( oSettings ) {
				// se aplica estilo a los tooltips de todas las paginas
			    $('[data-toggle="tooltip"]').tooltip();
				console.log($('#tabla_programas_sin_alertas').children('tbody').children('tr').children('td')[0].innerHTML);
				var mensaje = $('#tabla_programas_sin_alertas').children('tbody').children('tr').children('td')[0].innerHTML;
				if(mensaje == 'Ningún dato disponible en esta tabla'){
					console.log("entro al mensaje");
					$("#mensaje_tabla_programas_sin_alertas").css("display", "block");
					$("#mensaje_tabla_programas_sin_alertas").html('<hr><div class="alert alert-warning" role="alert"><span class="badge badge-warning mr-3"><i class="fa fa-info"></i></span>No existen responsables y establecimiento para el o los programas. Por favor comuníquese con el coordinador para su definición en el mapa de ofertas.</div>');
					$("#contenedor_tabla_programas_sin_alertas").css("display", "none");
				}else{
					$("#contenedor_tabla_programas_sin_alertas").css("display", "block");
					$("#mensaje_tabla_programas_sin_alertas").css("display", "none");
			    }
			}
				
		});
	}

	function guardarObservacionBrecha(id_brecha, observacion){
		bloquearPantalla();

		$("[data-obs-bre="+id_brecha+"]").val(observacion);

		$.ajax({
			url: "{{ route('guardarObservacionBrecha') }}"+"/"+id_brecha+"/"+observacion,
			type: "GET"
		}).done(function(resp){
			desbloquearPantalla();

			if (resp.estado == 1){
				let mensaje = "Información registrada con éxito.";

				mensajeTemporalRespuestas(1, mensaje);
			}else{
				let mensaje = "Error al momento de guardar la información. Por favor intente nuevamente.";

				mensajeTemporalRespuestas(0, mensaje);
			}
		}).fail(function(obj){
			desbloquearPantalla();

			let mensaje = "Error al momento de guardar la información. Por favor intente nuevamente.";
			
			mensajeTemporalRespuestas(0, mensaje);
		});

	}

	function registrarBrecha(prog_id, cas_id, gru_fam_id, id_alerta){

		$('[data-toggle="tooltip"]').tooltip('hide');

		if (confirm('¿Está seguro de registrar la Brecha?')) {
			bloquearPantalla();

			$.ajax({
				url: "{{ route('generarBrecha') }}"+"/"+prog_id+"/"+cas_id+"/"+gru_fam_id+"/"+id_alerta,
				type: "GET"
			}).done(function(resp){
				desbloquearPantalla();

				if (resp.estado == 1){
					if (id_alerta==-1){
						// se actualiza la data del datatable
						
						var tabla = $('#tabla_programas_sin_alertas').DataTable();
						tabla.ajax.reload(null,false);
					}else{
						asignarProgramaIntegrante1(gru_fam_id, id_alerta);

					}

					mensajeTemporalRespuestas(1, "Brecha registrada con éxito.");
				}else{
					mensajeTemporalRespuestas(0, "Error al momento de crear la brecha. Por favor intente nuevamente.");

				}

			}).fail(function(obj){
				desbloquearPantalla();

				mensajeTemporalRespuestas(0, "Error al momento de crear la brecha. Por favor intente nuevamente.");

			});
		}

	}

	function asignarProgGrupFam(prog_id,estab_id = null, prog_nom=null){
		$('[data-toggle="tooltip"]').tooltip('hide');

		if (confirm('¿Confirma asignar el Programa '+prog_nom+'?')) {

			bloquearPantalla();

			var grup_fam_id = $("#grup_fam_id").val();
			var estab_id = estab_id;

			let data = new Object();
			data.prog_id 	 = prog_id;
			data.grup_fam_id = grup_fam_id;
			data.estab_id 	 = estab_id;
			data.cas_id 	 = $("#cas_id").val();

			$.ajax({
				url: "{{ route('asignar.programas.sinalertas') }}",
				type: "GET",
				data: data
			}).done(function(resp){
				desbloquearPantalla();

				if(resp.estado == 1){
					
					cargaAsignados();

					listarProgramasSinAlertas(grup_fam_id);
					
					$("#alert-asig-sin-alert").show();
						setTimeout(function(){ $("#alert-asig-sin-alert").hide(); }, 5000);
				} else {

					$("#alert-error-sin-alert").show();
						setTimeout(function(){ $("#alert-error-sin-alert").hide(); }, 5000);

				}
			
			}).fail(function(obj){
				desbloquearPantalla();

				let mensaje = "Hubo un error al momento de asignar programa. Por favor intente nuevamente.";
				
				console.log(obj);
				alert(mensaje);
			});

		} else {
		    return false;
		
		}
	}


	function cargaAsignados(){
		let tabla_programas_asignacion = $('#tabla_programas_asignacion').DataTable();
        tabla_programas_asignacion.clear().destroy();	

		let grup_fam_id = $("#grup_fam_id").val();
		let url_listar_programa_sin_aler = $('#url_listar_programa_sin_aler').val();

		let data = new Object();
		data.grup_fam_id = grup_fam_id;


		tabla_programas_asignacion = $('#tabla_programas_asignacion').DataTable({
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			"ajax"		: 
				{ 
					"url" :	url_listar_programa_sin_aler,
					"type": "GET",  
					"data": data ,
				},
			"ordering":false,
			"columns":[
				{																		
					"data": 		"pro_nom",
					"name": 		"pro_nom",
					"width": 		"200px",
					"className": 	"left-center",
				},
				{
					"data": "estab_nom", 
					"className": "text-center",
					"width": "200px"
				},
				{
					"data": "", 
					"className": "text-center",
					"width": "200px",
					"render" : function (data, type, row){
						let disabled = '';

						@if (config('constantes.en_elaboracion_paf') != $estado_actual_caso)
							disabled = 'disabled';

						@else
							if (row.est_prog_fin == 1){
								disabled = 'disabled';

							}
						@endif

						let html = '<button type="button" '+disabled+' style="width:100%;" class="btn btn-outline-danger btn-sm" onclick="desestimarProgGrupFam('+row.grup_fam_prog_id+',\''+row.pro_nom+'\');">Eliminar Derivación</button>';

						return html;
					}
				}
			]
		});

	}

	function desestimarProgGrupFam(grup_fam_prog_id, pro_nom=null){
		if (confirm('¿Confirma que desea desestimar el Programa '+pro_nom+'?')) {

			var grup_fam_id = $("#grup_fam_id").val();
			var est_prog_id = {{ config('constantes.no_corresponde') }};

			let data = new Object();
			data.grup_fam_prog_id = grup_fam_prog_id;
			data.est_prog_id = est_prog_id;

			$.ajax({
				url: "{{ route('desestimar.programas.sinalertas') }}",
				type: "GET",
				data: data
			}).done(function(resp){
				
				if(resp.estado == 1){
					cargaAsignados();
					listarProgramasSinAlertas(grup_fam_id);
					
					mensajeTemporalRespuestas(1, resp.mensaje);
				} else {
					mensajeTemporalRespuestas(0, resp.mensaje);

				}
			}).fail(function(obj){
				desbloquearPantalla();

				let mensaje = "Hubo un error al momento de desestimar la derivación. Por favor verifique e intente nuevamente.";
				
				mensajeTemporalRespuestas(0, mensaje);
			});

		}else {
		    return false;

		}
	}

	function registrarNumeroTareas(){
		bloquearPantalla();
		let data = new Object();

		data.cas_id = $("#cas_id").val();
		data.cas_can_tar = $("#ela_tar_com").val();

		$.ajaxSetup({
    		headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
   	 		}
        });

		$.ajax({
			type: "POST",
			url: "{{route('registrar.tareas.comprometidas')}}",
			data: data
		}).done(function(resp){
			desbloquearPantalla();

            if(resp.estado == 1){
                mensajeTemporalRespuestas(1, resp.mensaje);

            }else if (resp.estado == 0){
                mensajeTemporalRespuestas(0, resp.mensaje);
            }
        }).fail(function(objeto, tipoError, errorHttp){
            desbloquearPantalla();

            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
            return false;
        });
	}
</script>