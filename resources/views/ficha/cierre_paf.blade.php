	<div class="container-fluid">
		 <div class="row">
			 <div class="col">
				 @if (count($titulos_modal) >= 4)
					 <h5 class="modal-title" id="title_cierre" data-id-est="{{ $titulos_modal[3]->id_est }}"><b> <i class="fas fa-archive"></i>  {{ $titulos_modal[3]->titulo }}</b></h5>
				 @else
					 <h5 class="modal-title" id="title_cierre" data-id-est=""></h5>
				 @endif
			 </div>	 
			 @if ($modo_visualizacion == 'edicion')
				 <div class="col text-right">
					 <button type="button" class="btn btn-danger btn-sm btnRechEst" data-dismiss="modal"
							 @if (config('constantes.rechazado_por_familiares') == $estado_actual_caso || config('constantes.rechazado_por_gestor') == $estado_actual_caso ||
							 config('constantes.en_seguimiento_paf') == $estado_actual_caso || config('constantes.egreso_paf') == $estado_actual_caso

									|| config('constantes.familia_intervenida_sename') == $estado_actual_caso

							|| config('constantes.nna_vulneracion_derechos') == $estado_actual_caso
									|| config('constantes.nna presenta_medida_proteccion') == $estado_actual_caso
									|| config('constantes.familia_no_aplica') == $estado_actual_caso
									|| config('constantes.familia_inubicable') == $estado_actual_caso
									|| config('constantes.familia_rechaza_oln') == $estado_actual_caso
									|| config('constantes.familia_renuncia_oln') == $estado_actual_caso  
									|| config('constantes.direccion_incorrecta') == $estado_actual_caso 
									|| config('constantes.direccion_desactualizada') == $estado_actual_caso
							 )
							 disabled @else onclick="comentarioEstado({{ $caso_id }});" @endif>
							 Desestimar Caso
					 </button>

					 <input type="hidden" id="documentoencuestasatisfaccion" value="{{$encuestasatisfaccion}}">

				 </div>
			 @endif
		 </div>

		 <hr>

	       	    
		<div class="row p-4">
		<!-- INICIO DC -->
			<table>
				<tr>
					<td><label><b>Nº Tareas Logradas: {{$actividades}}</b></label></td>
				</tr>
				<tr>
					<td><label><b>Nº de Tareas Comprometidas: {{$cont_tar}}</b></label></td>
				</tr>
				<tr><!-- inicio ch -->
					<td><label><b>Porcentaje de Logro: {{$p_logro}}</b></td>
					<!-- fin ch -->
				</tr>
			</table>
		<!-- FIN DC -->	
		</div>

		<!-- NCFAS - G -->
		<div class="card shadow-sm">
			<div class="card-header p-3">
      			<div class="row">
					<div class="col">
						<h5 class="p-2 mb-0"><span class="badge badge-secondary">1</span> Evaluación Familiar y de Competencias Parentales</h5>
					</div>
					<div class="col">
						<button type="button" class="btn btn-info float-right ml-3" data-toggle="popover" title="Evaluación" data-content="Realice la evalución NCFAS-G"><i class="fa fa-info"></i></button>
					</div>
				</div>
      		</div>
      		<div class="card-body">
      			@if ($modo_visualizacion == 'visualizacion')
						<div class="row">
							<div class="col-6 text-center">
								<button type="button" class="btn btn-info" onclick="$('#ncfasModal').modal('show');">Visualizar NCFAS-G</button>
							</div>
							<div class="col-6 text-center">
								@if($ncfasg_realizado)
		        				<a class="btn" style="background: #01e0bc; color: #fff;">Realizado</a>
							@else
								<a class="btn" style="background: #01e0bc; color: #fff;">No realizado</a>
							@endif
							</div>
						</div>

					@elseif ($modo_visualizacion == 'edicion')	
						<div class="row">
			        		<div class="col-6 text-center">
			        			<a
			        			@if ($ncfasg_realizado && config('constantes.en_cierre_paf')!= $estado_actual_caso) 
						        	disabled 
								@else 
			        				href="{{ route('caso.diagnostico',[ 'ficha' => $caso_id, 'run' => $run, 'opcion'=>config('constantes.en_cierre_paf')]) }}" 
						        @endif
			        			class="btn btn-warning btn-lg"> <i class="fa fa-external-link"></i> Aplicar NCFAS-G</a>
			        		</div>

			        		<div class="col-6 text-center pt-1">
			        			@if($ncfasg_realizado)
				        			<a class="btn" style="background: #01e0bc; color: #fff;">Realizado</a>

				        			<button type="button" class="btn btn-info" onclick="$('#ncfasModal').modal('show');">Imprimir NCFAS-G</button>
								
								@else
									<a class="btn" style="background: #01e0bc; color: #fff;">No realizado</a>

								@endif
								
								<div id="val_diag_ncfas" class="alert alert-secondary text-danger p-1" style=" display: none;">
									<small>* Falta completar este item.</small>
								</div>
				        	</div>

		        	</div>
		        	<br>

					@endif
      		</div>
      	</div>
		<!-- NCFAS - G -->

		
		<!--  -->
		
		<div class="card shadow-sm">
			<div class="card-header p-3">
      			<div class="row">
					<div class="col">
						<h5 class="p-2 mb-0"><span class="badge badge-secondary">2</span> Alertas Territoriales Asociadas</h5>
					</div>
					
				</div>
      		</div>
      		<div class="card-body">
      			<table class="table table-striped table-hover w-100" cellspacing="0" id="tabla_alertas_detectadas3">
                	<thead>
                    	<tr>
                        	<th style="width:15%">Tipo de alerta</th>
                            <th style="width:45%">Cantidad</th>   
                            <th style="width:45%">Estado</th>
                            <!-- INICIO DC -->
                            <th style="width:45%">Motivo</th>
                            <!-- FIN DC -->
                    	</tr>
                    </thead>
                    <tbody></tbody>
                </table> 
      		</div>
      		
      		<h5 style="padding:15px">Porcentaje de logro: <span id="porLogro"></span></h5>
      	</div>

	<!-- Encuesta de Satisfacción -->



<div class="card shadow-sm">
	<div class="card-header p-3">
		<h5 class="mb-0">
			<span class="badge badge-secondary">3</span>
			Sesi&oacute;n de Devoluci&oacute;n de Resultados
		</h5>
	</div>	
	<div class="card-body">
		<div class="container">
			<!-- FECHA DE SESSION -->
			@if ($modo_visualizacion == 'visualizacion')
				<div class="row">
					<div class="col-md-12 col-lg-6" style="display: flex;">
						<h6><label for="" class="col-form-label">Fecha de Sesión:</label></h6>						
					</div>
					<div class="col-md-12 col-lg-6" style="word-break: break-all;">
						<label id="vis_fec_ses" class="font-weight-bold"></label>
					</div>
				</div>
			@elseif ($modo_visualizacion == 'edicion')

				<div class="row">
					<div class="col-lg-6" style="display: flex;">
						<h6><label for="ses_dev_pre1" class="col-form-label">Fecha de Sesión:</label></h6>						
					</div>
					
					<div class="col-md-4 text-left">	
						<div class="input-group date-pick" id="div_ses_dev_fec" data-target-input="nearest">
							<input onkeypress="return caracteres_especiales_fecha(event)" type="text" name="fec_ses_tar" class="form-control datetimepicker-input " data-target="#div_ses_dev_fec" id="ses_dev_fec" value="" onblur="guardarSesDevPreguntas('sesion_fecha',$(this).val())">
							<div class="input-group-append" data-target="#div_ses_dev_fec" data-toggle="datetimepicker">
								<div class="input-group-text"><i class="fa fa-calendar"></i></div>
							</div>							
						</div>
						<p id="val_ses_dev_fec" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Por favor ingresar una fecha valida.</p>
					</div>
				</div>
			@endif
			<br>
			<br>
			<!-- FECHA DE SESSION -->

			<!-- PREGUNTA 1 -->
			@if ($modo_visualizacion == 'visualizacion')
				<div class="row">
					<div class="col-md-12 col-lg-6" style="display: flex;">
						<h6><label for="" class="col-form-label">1. Análisis de resultados de la aplicación de la NCFAS-G compartidos con la familia:</label></h6>						
					</div>
					<div class="col-md-12 col-lg-6" style="word-break: break-all;">
						<label id="vis_pre_1" class="font-weight-bold"></label>
					</div>
				</div>
			@elseif ($modo_visualizacion == 'edicion')

				<div class="row">
					<div class="col-md-12 col-lg-6" style="display: flex;">
						<h6><label for="ses_dev_pre1" class="col-form-label">1. Análisis de resultados de la aplicación de la NCFAS-G compartidos con la familia:</label></h6>						
					</div>
					
					<div class="col-md-12 col-lg-6">
						<textarea maxlength="1000" onkeypress='return caracteres_especiales(event)' onpaste="onpasteval(1);" onkeyup="valTextAreaSesDevPre1()" onkeydown="valTextAreaSesDevPre1()" onblur="guardarSesDevPreguntas('sesion_pregunta_1',$(this).val())" @if (config('constantes.en_cierre_paf')!= $estado_actual_caso) disabled @endif class="form-control " rows="7" id="ses_dev_pre_1"></textarea>
						<p id="val_ses_pre_1" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar un comentario valido.</p>
						<div class="row">
							<div class="col-md-12 col-lg-8">
								<h6><small class="form-text text-muted">Mínimo 3 y máximo 1000 caracteres.</small></h6>
							</div>
							<div class="col-md-12 col-lg-4">
								<h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_1" style="color: #000000;">0</strong></small></h6>
							</div>
						</div>
					</div>
				</div>
			@endif
			<br>
			<br>
			<!-- PREGUNTA 1 -->

			<!-- PREGUNTA 2 -->
			@if ($modo_visualizacion == 'visualizacion')
				<div class="row">
					<div class="col-md-12 col-lg-6" style="display: flex;">
						<h6><label for="" class="col-form-label">2. Principales logros alcanzados durante la intervención identificados con la familia:</label></h6>						
					</div>
					<div class="col-md-12 col-lg-6" style="word-break: break-all;">
						<label id="vis_pre_2" class="font-weight-bold"></label>
					</div>
				</div>
			@elseif ($modo_visualizacion == 'edicion')

				<div class="row">
					<div class="col-md-12 col-lg-6" style="display: flex;">
						<h6><label for="ses_dev_pre2" class="col-form-label">2. Principales logros alcanzados durante la intervención identificados con la familia:</label></h6>						
					</div>
					<div class="col-md-12 col-lg-6">
						<textarea maxlength="1000" onkeypress='return caracteres_especiales(event)' onpaste="onpasteval(2);" onkeyup="valTextAreaSesDevPre2()" onkeydown="valTextAreaSesDevPre2()" onblur="guardarSesDevPreguntas('sesion_pregunta_2',$(this).val())" @if (config('constantes.en_cierre_paf')!= $estado_actual_caso) disabled @endif class="form-control " rows="7" id="ses_dev_pre_2"></textarea>
						<p id="val_ses_pre_2" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar un comentario valido.</p>
						<div class="row">
							<div class="col-md-12 col-lg-8">
								<h6><small class="form-text text-muted">Mínimo 3 y máximo 1000 caracteres.</small></h6>
							</div>
							<div class="col-md-12 col-lg-4">
								<h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_2" style="color: #000000;">0</strong></small></h6>
							</div>
						</div>
					</div>
				</div>
			@endif
			<br>
			<br>
			<!-- PREGUNTA 2 -->

			<!-- PREGUNTA 3 -->
			@if ($modo_visualizacion == 'visualizacion')
				<div class="row">
					<div class="col-md-12 col-lg-6" style="display: flex;">
						<h6><label for="" class="col-form-label">3. Principales dificultades que experimentaron durante la intervención y las acciones que llevaron a cabo para enfrentarlas:</label></h6>						
					</div>
					<div class="col-md-12 col-lg-6" style="word-break: break-all;">
						<label id="vis_pre_3" class="font-weight-bold"></label>
					</div>
				</div>
			@elseif ($modo_visualizacion == 'edicion')

				<div class="row">
					<div class="col-md-12 col-lg-6" style="display: flex;">
						<h6><label for="ses_dev_pre3" class="col-form-label">3. Principales dificultades que experimentaron durante la intervención y las acciones que llevaron a cabo para enfrentarlas:</label></h6>						
					</div>
					
					<div class="col-md-12 col-lg-6">
						<textarea maxlength="1000" onkeypress='return caracteres_especiales(event)' onpaste="onpasteval(3);" onkeyup="valTextAreaSesDevPre3()" onkeydown="valTextAreaSesDevPre3()" onblur="guardarSesDevPreguntas('sesion_pregunta_3',$(this).val())" @if (config('constantes.en_cierre_paf')!= $estado_actual_caso) disabled @endif class="form-control " rows="7" id="ses_dev_pre_3"></textarea>
						<p id="val_ses_pre_3" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar un comentario valido.</p>
						<div class="row">
							<div class="col-md-12 col-lg-8">
								<h6><small class="form-text text-muted">Mínimo 3 y máximo 1000 caracteres.</small></h6>
							</div>
							<div class="col-md-12 col-lg-4">
								<h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_3" style="color: #000000;">0</strong></small></h6>
							</div>
						</div>
					</div>
				</div>
			@endif
			<br>
			<br>
			<!-- PREGUNTA 3 -->

			<!-- PREGUNTA 4 -->
			@if ($modo_visualizacion == 'visualizacion')
				<div class="row">
					<div class="col-md-12 col-lg-6" style="display: flex;">
						<h6><label for="" class="col-form-label">4. Registrar acciones que quedaron pendientes y acuerdos con la familia sobre los siguientes pasos que realizarán de manera autónoma:</label></h6>						
					</div>
					<div class="col-md-12 col-lg-6" style="word-break: break-all;">
						<label id="vis_pre_4" class="font-weight-bold"></label>
					</div>
				</div>
			@elseif ($modo_visualizacion == 'edicion')

				<div class="row">
					<div class="col-md-12 col-lg-6" style="display: flex;">
						<h6><label for="ses_dev_pre4" class="col-form-label">4. Registrar acciones que quedaron pendientes y acuerdos con la familia sobre los siguientes pasos que realizarán de manera autónoma:</label></h6>						
					</div>
					<div class="col-md-12 col-lg-6">
						<textarea maxlength="1000" onkeypress='return caracteres_especiales(event)' onpaste="onpasteval(4);" onkeyup="valTextAreaSesDevPre4()" onkeydown="valTextAreaSesDevPre4()" onblur="guardarSesDevPreguntas('sesion_pregunta_4',$(this).val())"  @if (config('constantes.en_cierre_paf')!= $estado_actual_caso) disabled @endif class="form-control " rows="7" id="ses_dev_pre_4"></textarea>
						<p id="val_ses_pre_4" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar un comentario valido.</p>
						<div class="row">
							<div class="col-md-12 col-lg-8">
								<h6><small class="form-text text-muted">Mínimo 3 y máximo 1000 caracteres.</small></h6>
							</div>
							<div class="col-md-12 col-lg-4">
								<h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_4" style="color: #000000;">0</strong></small></h6>
							</div>
						</div>
					</div>
				</div>
			@endif
			<br>
			<br>
			<!-- PREGUNTA 4 -->

			<!-- PREGUNTA 5 -->
			@if ($modo_visualizacion == 'visualizacion')
				<div class="row">
					<div class="col-md-12 col-lg-6" style="display: flex;">
						<h6><label for="" class="col-form-label">5. Comentarios realizados por la familia acerca del término de la Gestión de Casos:</label></h6>						
					</div>
					<div class="col-md-12 col-lg-6" style="word-break: break-all;">
						<label id="vis_pre_5" class="font-weight-bold"></label>
					</div>
				</div>
			@elseif ($modo_visualizacion == 'edicion')

				<div class="row">
					<div class="col-md-12 col-lg-6" style="display: flex;">
						<h6><label for="ses_dev_pre5" class="col-form-label">5. Comentarios realizados por la familia acerca del término de la Gestión de Casos:</label></h6>						
					</div>
					
					<div class="col-md-12 col-lg-6">
						<textarea maxlength="1000" onkeypress='return caracteres_especiales(event)' onpaste="onpasteval(5);" onkeyup="valTextAreaSesDevPre5()" onkeydown="valTextAreaSesDevPre5()" onblur="guardarSesDevPreguntas('sesion_pregunta_5',$(this).val())" @if (config('constantes.en_cierre_paf')!= $estado_actual_caso) disabled @endif class="form-control " rows="7" id="ses_dev_pre_5"></textarea>
						<p id="val_ses_pre_5" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar un comentario valido.</p>
						<div class="row">
							<div class="col-md-12 col-lg-8">
								<h6><small class="form-text text-muted">Mínimo 3 y máximo 1000 caracteres.</small></h6>
							</div>
							<div class="col-md-12 col-lg-4">
								<h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_5" style="color: #000000;">0</strong></small></h6>
							</div>
						</div>
					</div>
				</div>
			@endif
			<!-- PREGUNTA 5 -->

		</div>
	</div>
	
</div>

<div class="card shadow-sm">
	<div class="card-header p-3">
	 <h5 class="mb-0"> <span class="badge badge-secondary">4</span> Encuesta de Satisfacción</h5>
	</div>

	@if ($modo_visualizacion == 'visualizacion')
		<div class="card-body">
			<div class="col-12">
				<h6 class="text-center">Descargue la Encuesta de Satisfacción subida para este caso en el siguiente enlace: 

					@if ($encuestasatisfaccion == 'na')
					 	<label class="font-weight-bold">Sin información.</label>
					
					@elseif ($encuestasatisfaccion != 'na')
						<!-- INICIO DC -->
				    	<a class="text-primary" href="{{config('constantes.app_url')}}doc/{{$encuestasatisfaccion}}">Click acá.</a>
						<!-- FIN DC -->
					@endif	

				</h6>  
			</div>
			<div class="col-12 text-center">
				<small>En caso de no tener cargada la Encuesta de Satisfacción puede descargarla en español haciendo <a href="/documentos/encuesta_satisfaccion.docx" class="text-primary">Click acá</a> o en Kreyòl <a href="/documentos/encuesta_satisfaccion_Kreyol.docx" class="text-primary">Click acá</a></small>
			</div>
		</div>



	@elseif ($modo_visualizacion == 'edicion')
		<div class="card-body">
				<div class="row"> 
					<div class="col-md-6">
						<div class="border p-3 bg-light form-group">
							<div class="alert alert-success alert-dismissible fade show" id="alert-doc" role="alert" style="display: none;">
							Documento Guardado Exitosamente.
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
					<div class="alert alert-danger alert-dismissible fade show" id="alert-err-doc" role="alert" style="display: none;">
					Error al momento de guardar el registro. Por favor intente nuevamente.
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>

				<div class="alert alert-danger alert-dismissible fade show" id="alert-err-doc-ext" role="alert" style="display: none;">
					EL formato del archivo no es permitido. Sólo subir archivos con las siguientes extensiones: ".pdf", ".jpg" y ".png"
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<div class="row">
				  <dt class="col-sm-1"> <h4><span class="badge badge-secondary">a</span></h4></dt>
					  <dd class="col-sm-11"><p> Descargue el siguiente documento para la encuesta de Satisfacción</p>
					  <a href="/documentos/encuesta_satisfaccion.docx" class="btn btn-primary"><i class="fa fa-download mr-2"></i>  Descargar Documento en Español</a><br><br>
					  <a href="/documentos/encuesta_satisfaccion_Kreyol.docx" class="btn btn-primary"><i class="fa fa-download mr-2"></i>  Descargar Documento en Kreyol</a></dd>
				</div>
			<!-- 	/casos/descarga/documento/1 -->
				</div>
				</div>
			<div class="col-md-6">
				<div class="border p-3 bg-light form-group">
					<div class="row">
					  <dt class="col-sm-1"><h4> <span class="badge badge-secondary">b</span></h4></dt>
						  <dd class="col-sm-11"><p>Un vez realizada la Encuesta de Satisfacción, debe ser digitalizado (escaneo o fotografía) para volver a cargarlo al sistema por este conducto.</p>
						  <p>Cargar Documento</p>
						<div class="input-group mb-3">
							<form enctype="multipart/form-data" id="adj_enc_sati" method="post">
								<div class="custom-file" style="z-index:0;">
									<input type="file" class="custom-file-input" name="enc_sati" id="enc_sati"   >
									<input type="hidden" id="cas_id" name="cas_id" value={{$caso_id}}>
									<label class="custom-file-label" for="enc_sati" aria-describedby="inputGroupFileAddon02">Cargar Documento</label>
								</div>
							</form>

							<div id="descargarencuestasatisfaccion">
										  <div class="input-group-append">
										    <span class="input-group-text" id="inputGroupFileAddon02"><a download href="../doc/{{$encuestasatisfaccion}}" id="ruta_documento_consentimiento"><img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjUxMnB4IiBoZWlnaHQ9IjUxMnB4IiB2aWV3Qm94PSIwIDAgNDc1LjA3OCA0NzUuMDc3IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA0NzUuMDc4IDQ3NS4wNzc7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4KPGc+Cgk8Zz4KCQk8cGF0aCBkPSJNNDY3LjA4MywzMTguNjI3Yy01LjMyNC01LjMyOC0xMS44LTcuOTk0LTE5LjQxLTcuOTk0SDMxNS4xOTVsLTM4LjgyOCwzOC44MjdjLTExLjA0LDEwLjY1Ny0yMy45ODIsMTUuOTg4LTM4LjgyOCwxNS45ODggICAgYy0xNC44NDMsMC0yNy43ODktNS4zMjQtMzguODI4LTE1Ljk4OGwtMzguNTQzLTM4LjgyN0gyNy40MDhjLTcuNjEyLDAtMTQuMDgzLDIuNjY5LTE5LjQxNCw3Ljk5NCAgICBDMi42NjQsMzIzLjk1NSwwLDMzMC40MjcsMCwzMzguMDQ0djkxLjM1OGMwLDcuNjE0LDIuNjY0LDE0LjA4NSw3Ljk5NCwxOS40MTRjNS4zMyw1LjMyOCwxMS44MDEsNy45OSwxOS40MTQsNy45OWg0MjAuMjY2ICAgIGM3LjYxLDAsMTQuMDg2LTIuNjYyLDE5LjQxLTcuOTljNS4zMzItNS4zMjksNy45OTQtMTEuOCw3Ljk5NC0xOS40MTR2LTkxLjM1OEM0NzUuMDc4LDMzMC40MjcsNDcyLjQxNiwzMjMuOTU1LDQ2Ny4wODMsMzE4LjYyN3ogICAgIE0zNjAuMDI1LDQxNC44NDFjLTMuNjIxLDMuNjE3LTcuOTA1LDUuNDI0LTEyLjg1NCw1LjQyNHMtOS4yMjctMS44MDctMTIuODQ3LTUuNDI0Yy0zLjYxNC0zLjYxNy01LjQyMS03Ljg5OC01LjQyMS0xMi44NDQgICAgYzAtNC45NDgsMS44MDctOS4yMzYsNS40MjEtMTIuODQ3YzMuNjItMy42Miw3Ljg5OC01LjQzMSwxMi44NDctNS40MzFzOS4yMzIsMS44MTEsMTIuODU0LDUuNDMxICAgIGMzLjYxMywzLjYxLDUuNDIxLDcuODk4LDUuNDIxLDEyLjg0N0MzNjUuNDQ2LDQwNi45NDIsMzYzLjYzOCw0MTEuMjI0LDM2MC4wMjUsNDE0Ljg0MXogTTQzMy4xMDksNDE0Ljg0MSAgICBjLTMuNjE0LDMuNjE3LTcuODk4LDUuNDI0LTEyLjg0OCw1LjQyNGMtNC45NDgsMC05LjIyOS0xLjgwNy0xMi44NDctNS40MjRjLTMuNjEzLTMuNjE3LTUuNDItNy44OTgtNS40Mi0xMi44NDQgICAgYzAtNC45NDgsMS44MDctOS4yMzYsNS40Mi0xMi44NDdjMy42MTctMy42Miw3Ljg5OC01LjQzMSwxMi44NDctNS40MzFjNC45NDksMCw5LjIzMywxLjgxMSwxMi44NDgsNS40MzEgICAgYzMuNjE3LDMuNjEsNS40MjcsNy44OTgsNS40MjcsMTIuODQ3QzQzOC41MzYsNDA2Ljk0Miw0MzYuNzI5LDQxMS4yMjQsNDMzLjEwOSw0MTQuODQxeiIgZmlsbD0iIzAwMDAwMCIvPgoJCTxwYXRoIGQ9Ik0yMjQuNjkyLDMyMy40NzljMy40MjgsMy42MTMsNy43MSw1LjQyMSwxMi44NDcsNS40MjFjNS4xNDEsMCw5LjQxOC0xLjgwOCwxMi44NDctNS40MjFsMTI3LjkwNy0xMjcuOTA4ICAgIGM1Ljg5OS01LjUxOSw3LjIzNC0xMi4xODIsMy45OTctMTkuOTg2Yy0zLjIzLTcuNDIxLTguODQ3LTExLjEzMi0xNi44NDQtMTEuMTM2aC03My4wOTFWMzYuNTQzYzAtNC45NDgtMS44MTEtOS4yMzEtNS40MjEtMTIuODQ3ICAgIGMtMy42Mi0zLjYxNy03LjkwMS01LjQyNi0xMi44NDctNS40MjZoLTczLjA5NmMtNC45NDYsMC05LjIyOSwxLjgwOS0xMi44NDcsNS40MjZjLTMuNjE1LDMuNjE2LTUuNDI0LDcuODk4LTUuNDI0LDEyLjg0N1YxNjQuNDUgICAgaC03My4wODljLTcuOTk4LDAtMTMuNjEsMy43MTUtMTYuODQ2LDExLjEzNmMtMy4yMzQsNy44MDEtMS45MDMsMTQuNDY3LDMuOTk5LDE5Ljk4NkwyMjQuNjkyLDMyMy40Nzl6IiBmaWxsPSIjMDAwMDAwIi8+Cgk8L2c+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==" height="20px"/></a></span>
										  </div>
							</div>
						</div>
					  </dd>
					</div>
					<!-- <p id="val_diag_vis_3" style="display: none;">* Falta adjuntar el documento de consentimiento.</p> -->
					</div>
				</div>
			</div>
		</div>
	@endif



	</div>
	
	<!-- fin Encuesta de Satisfacción -->

	<!-- 	<div class="form-group">
			<label for="comment"><b>Encuesta de Satisfacción</b></label>
				<br>
				<br>
				<table class="table table-bordered table-hover dataTable no-footer">
					<tbody>
					 <tr>
						<td class="text-left" style="width:15px"><span class="oi oi-circle-check"></span></td>
						<td class="text-left" style="width:260px">Subir Encuesta de Satifacción</td>
						<td class="text-center" >Por Iniciar</td>
						<td class="text-center" ><span class="oi oi-arrow-circle-top"></span></td>	
					 </tr>
					</tbody>
			   	</table>
		</div>
	 -->
	<br>

	</div>

			<!-- BITACORA ACTUAL CASO -->
			<div class="card shadow-sm alert-info">
				<div class="card-header p-3">
					<h5 class="mb-0"><i class="fa fa-pencil"></i>  Bitácora Estado Actual del Caso</h5>
				</div>
				<div class="card-body">
					<label for="bitacora_estado_cierre" style="font-weight: 800;">Comentario Cierre:</label>
					<!-- <textarea onkeypress='return caracteres_especiales(event)' class="form-control txtAreEtapa " name="bit-etapa-cierre" id="bitacora_estado_cierre" rows="3" onBlur="cambioEstadoCaso(6, {{ $caso_id }}, $(this).val());"
				  	@if (config('constantes.en_cierre_paf')  != $estado_actual_caso) disabled @endif>{{ $bitacoras_estados[3] }}</textarea> -->

				  	@if ($modo_visualizacion == 'visualizacion')
				  		<div class="text-success" style="word-break: break-all;">
							<label class="font-weight-bold">{{ $bitacoras_estados[3] }}</label>
						</div>
				  	@elseif ($modo_visualizacion == 'edicion')
						<textarea maxlength="2000" onkeypress='return caracteres_especiales(event)' class="form-control txtAreEtapa " name="bit-etapa-cierre" id="bitacora_estado_cierre" rows="3" onBlur="cambioEstadoCaso('b6', {{ $caso_id }}, $(this).val());"
					  	@if (config('constantes.en_cierre_paf')  != $estado_actual_caso) disabled @endif>{{ $bitacoras_estados[3] }}</textarea>
				  	@endif


<!-- 					<button type="button" id="btn-etapa-cierre" class="btn btn-success btn-sm btnEtapa" style="float: right;" onclick="siguienteEtapa(11, {{ $caso_id }});" disabled>
						Ir a siguiente etapa - <strong>Seguimiento PAF</strong>
					</button> -->
					<br>
					@if ($modo_visualizacion == 'edicion')
						<button type="button" id="btn-etapa-cierre" class="btn btn-success btn-sm btnEtapa" style="float: right;" onclick="siguienteEtapa({{config('constantes.en_seguimiento_paf')}}, {{ $caso_id }});" disabled>
							Ir a siguiente etapa - <strong>Seguimiento PAF</strong>
						</button>
					@endif

				</div>
			</div>
			<!-- FIN BITACORA ACTUAL CASO -->

		</div>
			<!--<div class="col-sm-12">
				<button type="button" id="btn-etapa-cierre" class="btn btn-success btn-sm btnEtapa" style="float: right;" onclick="siguienteEtapa(11, { { $caso_id }});"
				@ if (config('constantes.rechazado_por_familiares') == $estado_actual_caso || config('constantes.rechazado_por_gestor') == $estado_actual_caso ||
				config('constantes.en_cierre_paf') != $estado_actual_caso) disabled @ endif >Ir a siguiente etapa - Seguimiento PAF</button>
			</div>-->
</div>
<!-- INICIO DC -->
	<div id="modalNoMitigada" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog">
					<div class="modal-dialog" role="document">
						<div class="modal-content p-4">
							<div class="modal-header">
								<div style="margin: 0 auto;"><h5>Motivo No Mitigada</h5></div>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute; margin: 0; top: 5px; right: 33px;">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							
							<div class="modal-body">
								<div class="table-responsive">
									<input type="hidden" id="txtAlerta">
									<input type="hidden" id="txtEstado">
									<textarea id="txtMotivoNM" maxlength="300" onKeyUp="cantCaracMotivo(this)" onKeyDown="cantCaracMotivo(this)" placeholder="Ingrese el motivo por la cual la Alerta se encuentra No Mitigada" style="width: 100%;height: 200px"></textarea>
									<div>
                                   		<div class="col">
                                    		<h6><small class="form-text text-muted">Mínimo 3 y máximo 300 caracteres.</small></h6>
                                    	</div>
                                    	<div class="col text-left">
                                        	<h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_txtMotivoNM" style="color: #000000;">0</strong></small></h6>
                                        </div>        
                                    </div>
								</div>
							</div>
							<div class="modal-footer" style="background-color: white;">								
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
								<button onclick="guardarMotivoNoMit()" type="button" class="btn btn-success">Guardar</button>
							</div>
						</div>
					</div>
				</div>
				<!-- FIN DC -->
@includeif('ficha.ncfas_modal_imprimir')

<script type="text/javascript">
	$(function () {
	  $('[data-toggle="popover"]').popover()
	})
	$(function () {
	  $('[data-toggle="tooltip"]').tooltip()
	})
</script>

<script type="text/javascript">
	//INICIO DC
	function cantCaracMotivo(input){
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
	function guardarMotivoNoMit(){
		var motivo = $('#txtMotivoNM').val();
		if(motivo == ''){
			mensajeTemporalRespuestas(0, 'Debe ingresar el Motivo.');
		}else{
			if(motivo.length < 3){
				mensajeTemporalRespuestas(0, 'EL minimo es de 3 caracteres.');
			}else{
				bloquearPantalla();
        		let data = new Object();
            	data.cas_id = {{$caso_id}};
            	data.ale_estado = $('#txtEstado').val();
            	data.ale_id = $('#txtAlerta').val();
            	data.motivo = motivo;
            	data.nom_estado = $("#sel_estado_"+$('#txtAlerta').val()+" option:selected").text();
            	$.ajax({
            		type: "GET",
            		url: "{{route('upd.alerta.noMitigar')}}",
            		data: data
            	}).done(function(resp){
            		desbloquearPantalla();
            		var obj = JSON.parse(resp);
            		if(obj.data == 1){
            			mensajeTemporalRespuestas(1, 'Se ha actualizado el estado de la alerta.');
            			cargaAlertasAsociadas();
                        calculaPorcentajeLogro();
                        $('#modalNoMitigada').modal('hide');
            		}else{
            			mensajeTemporalRespuestas(0, 'Ha ocurrido un error al intentar actualizar la alerta.');
            		}
            	}).fail(function(objeto, tipoError, errorHttp){
            		desbloquearPantalla();
                    manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
                    return false;
                });
			}
			
		}
	}
	//FIN DC

	$( document ).ready(function() {
		let data2 = new Object();
		data2.cas_id = {{ $caso_id }};
		$.ajax({
			type: "GET",
			url: "{{route('validar.porcentaje.logro')}}",
			data: data2
		}).done(function(resp){
			var obj = JSON.parse(resp);
			//inicio DC
			if(obj.data['porcentaje'] == '-1'){
				$('#porLogro').html('No aplica');
			}else{
			$('#porLogro').html(obj.data['porcentaje']+'%');
			}
			//fin DC
		}).fail(function(objeto, tipoError, errorHttp){
			desbloquearPantalla();
            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
            return false;
        });
	
	
		let data = new Object();
		data.cas_id = {{ $caso_id }};
		let tabla_at_diagnostico = $('#tabla_alertas_detectadas3').DataTable();
        tabla_at_diagnostico.clear().destroy();
        tabla_at_diagnostico = $('#tabla_alertas_detectadas3').DataTable({
            "language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
            "lengthChange": false,
			"info": 		false,
			"searching":	false,
			"paging":		false,
            "ajax": {
                "url": "{{ route('listar.alerta.enAtencion') }}",
                "type": "GET",
                "data": data
            },
            "columnDefs": [
                { //TIPO DE ALERTAS
                    "targets": 0,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
				{ //CANTIDAD
                    "targets": 1,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },                
                { //ESTADO
                    "targets": 2,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                        $(td).css("width", "30%");
                    
                    }
                },
                { //MOTIVO
                    "targets": 3,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                        $(td).css("width", "30%");
                    
                    }
                }
            ],				
            "columns": [
                        { //TIPO DE ALERTAS
                            "data": "ale_tip_nom",
                            "className": "text-center"
                        },
						{ //CANTIDAD
                            "data": "cantidad",
                            "className": "text-center"
                        },
                        { //ESTADO
                            "data": "ale_man_id",
                            "className": "text-center",
                            "render": function(data, type, row){
                            	if(row.est_ale_id == 5){ //En atencion
									// INICIO CZ SPRINT 59
									@if($est_cas_fin)
										html = '<select id="sel_estado_'+data+'" disabled style="padding: 8px;" onchange="selEstado(this.value, '+data+')"><option value="'+row.est_ale_id+'">'+row.est_ale_nom+'</option></select>'; 
									@else 
                            		html = '<select id="sel_estado_'+data+'" style="padding: 8px;" onchange="selEstado(this.value, '+data+')"><option value="'+row.est_ale_id+'">'+row.est_ale_nom+'</option></select>';
									@endif
									// FIN CZ SPRINT 59
                            		let data2 = new Object();
									data2.estado_id = row.est_ale_id;
									$.ajax({
                            			type: "GET",
                            			url: "{{route('listar.alerta.estados')}}",
                            			data: data2
                            		}).done(function(resp){
                            			var obj = JSON.parse(resp);
                            			$('#sel_estado_'+data).html($('<option />', {
                                            text: row.est_ale_nom,
                                            value: row.est_ale_id,
                                          }));
                            			for (var i = 0; i < obj.length; i+=1) {
                            				 $('#sel_estado_'+data).append($('<option />', {
                                                text: obj[i].est_ale_nom,
                                                value: obj[i].est_ale_id,
                                              }));
                            			}      			                  
                            		}).fail(function(objeto, tipoError, errorHttp){
                            			desbloquearPantalla();
                                        manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
                                        return false;
                                    });
                            		
                            	}else{
									// INICIO CZ SPRINT 59
									@if($est_cas_fin)
										html = '<select id="sel_estado_'+data+'" disabled style="padding: 8px;" onchange="selEstado(this.value, '+data+')"><option value="'+row.est_ale_id+'">'+row.est_ale_nom+'</option></select>'; 
									@else 
                            		html = '<select id="sel_estado_'+data+'" style="padding: 8px;" onchange="selEstado(this.value, '+data+')"><option value="'+row.est_ale_id+'">'+row.est_ale_nom+'</option></select>';
									@endif
									//FIN CZ SPRINT 59
                            	}                           	                            	
								return html;
                            }
                        },
                        { //MOTIVO
                            "data": "ale_man_motivo_no_mitigada",
                            "className": "text-center"
                        }
                    ]
            });
            
            

		$("#alert-err-doc-ext").hide();

		if ($('#documentoencuestasatisfaccion').val()=='na'){
			$('#descargarencuestasatisfaccion').hide();
		}


		$("#enc_sati").change(function(e) {
			$("#adj_enc_sati").submit();
		});

		 $("#adj_enc_sati").submit(function(e){

		  bloquearPantalla();
	
		  // evito que propague el submit
		  e.preventDefault();
		  
		  // agrego la data del form a formData
		  var form = document.getElementById('adj_enc_sati');
		  var formData = new FormData(form);
		  formData.append('_token', $('input[name=_token]').val());

		  $.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			}
		  });

		  $.ajax({
		      type:'POST',
		      url: "{{ route('enviarencsati') }}",
		      data:formData,
		      cache:false,
		      contentType: false,
		      processData: false,
		      success:function(resp){

		      	desbloquearPantalla();

		           if (resp.estado == 1){

		           		$("#alert-err-doc").hide();
		  				$("#alert-err-doc-ext").hide();
                    	$("#alert-doc").show();
						//$("#valida_doc").val(1);
					
					setTimeout(function(){ 
						$("#alert-doc").hide();
					 }, 5000);

					location.reload();

					}else if (resp.estado == 0){
                    $("#alert-err-doc").show();
					setTimeout(function(){ $("#alert-err-doc").hide(); }, 5000);
				}
		      },
		      error: function(jqXHR, text, error){

		      	desbloquearPantalla();
		      	
		      		$("#alert-err-doc-ext").show();
					setTimeout(function(){ $("#alert-err-doc").hide(); }, 5000);
		      }
		  });

		});

		listarSesionDevolucion();

		setTimeout(function(){ 
						asignaEstado();
	    }, 1000);

	});	
	function cargaAlertasAsociadas(){
		let data = new Object();
		data.cas_id = {{ $caso_id }};
		let tabla_at_diagnostico = $('#tabla_alertas_detectadas3').DataTable();
        $('#tabla_alertas_detectadas3').DataTable().ajax.reload();
        tabla_at_diagnostico = $('#tabla_alertas_detectadas3').DataTable({
            "language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
            "lengthChange": false,
			"info": 		false,
			"searching":	false,
			"paging":		false,
            "ajax": {
                "url": "{{ route('listar.alerta.enAtencion') }}",
                "type": "GET",
                "data": data
            },
            "columnDefs": [
                { //TIPO DE ALERTAS
                    "targets": 0,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");                    
                    }
                },
				{ //CANTIDAD
                    "targets": 1,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");                   
                    }
                },                
                { //ESTADO
                    "targets": 2,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                        $(td).css("width", "30%");
                    
                    }
                }
            ],				
            "columns": [
                        { //TIPO DE ALERTAS
                            "data": "ale_tip_nom",
                            "className": "text-center"
                        },
						{ //CANTIDAD
                            "data": "cantidad",
                            "className": "text-center"
                        },
                        { //ESTADO
                            "data": "ale_man_id",
                            "className": "text-center",
                            "render": function(data, type, row){
                            	if(row.est_ale_id == 5){ //En atencion
                            		html = '<select id="sel_estado_'+data+'" style="padding: 8px;" onchange="selEstado(this.value, '+data+')"><option value="'+row.est_ale_id+'">'+row.est_ale_nom+'</option></select>';
                            		let data2 = new Object();
									data2.estado_id = row.est_ale_id;
									$.ajax({
                            			type: "GET",
                            			url: "{{route('listar.alerta.estados')}}",
                            			data: data2
                            		}).done(function(resp){
                            			var obj = JSON.parse(resp);
                            			$('#sel_estado_'+data).html($('<option />', {
                                            text: row.est_ale_nom,
                                            value: row.est_ale_id,
                                          }));
                            			for (var i = 0; i < obj.length; i+=1) {
                            				 $('#sel_estado_'+data).append($('<option />', {
                                                text: obj[i].est_ale_nom,
                                                value: obj[i].est_ale_id,
                                              }));
                            			}      			                  
                            		}).fail(function(objeto, tipoError, errorHttp){
                            			desbloquearPantalla();
                                        manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
                                        return false;
                                    });
                            		
                            	}else{
                            		html = '<select id="sel_estado_'+data+'" style="padding: 8px;" onchange="selEstado(this.value, '+data+')"><option value="'+row.est_ale_id+'">'+row.est_ale_nom+'</option></select>';
                            	}                           	                            	
								return html;
                            }
                        }
                    ]
            });
	}
	function calculaPorcentajeLogro(){
		let data2 = new Object();
		data2.cas_id = {{ $caso_id }};
		$.ajax({
			type: "GET",
			url: "{{route('validar.porcentaje.logro')}}",
			data: data2
		}).done(function(resp){
			var obj = JSON.parse(resp);
			//INICIO DC
			if(obj.data['porcentaje'] == '-1'){
				$('#porLogro').html('No aplica');
			}else{
			$('#porLogro').html(obj.data['porcentaje']+'%');
			}
			//FIN DC
		}).fail(function(objeto, tipoError, errorHttp){
			desbloquearPantalla();
            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
            return false;
        });
	}
	// Funcion que registra las preguntas de las sesiones de devolucion
	function selEstado(estado, alerta){
		if(estado != 5){
			let confirmacion = confirm("¿Seguro(a) que desea cambiar el estado de la Alerta?");
    		if (confirmacion == false) return false;
    		if(estado == 6){//Mitigada
    		bloquearPantalla();
    		let data = new Object();
    		data.cas_id = {{$caso_id}};
    		data.ale_estado = estado;
    		data.ale_id = alerta;
    		data.nom_estado = $("#sel_estado_"+alerta+" option:selected").text();
    		$.ajax({
    			type: "GET",
    			url: "{{route('upd.alerta.mitigar')}}",
    			data: data
    		}).done(function(resp){
    			desbloquearPantalla();
    			var obj = JSON.parse(resp);
    			if(obj.data == 1){
    				mensajeTemporalRespuestas(1, 'Se ha actualizado el estado de la alerta.');
    				cargaAlertasAsociadas();
                          calculaPorcentajeLogro();
    			}else{
    				mensajeTemporalRespuestas(0, 'Ha ocurrido un error al intentar actualizar la alerta.');
    			}
    		}).fail(function(objeto, tipoError, errorHttp){
    				desbloquearPantalla();
                    manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
                    return false;
            });
    		}else if(estado == 7){//No mitigada
    			$('#txtEstado').val(estado);
    			$('#txtAlerta').val(alerta);
    			$('#modalNoMitigada').modal('show');
    		}	
		}	
	}
	function asignaEstado(){
		let data = new Object();
		data.cas_id = {{ $caso_id }};
		$.ajax({
			type: "GET",
			url: "{{route('listar.alerta.enAtencion')}}",
			data: data
		}).done(function(resp){
			var obj = JSON.parse(resp);
			for (var i = 0; i < obj.data.length; i+=1) {
				var id_estado = obj.data[i].est_ale_id;
				var nom_estado = obj.data[i].est_ale_nom;
				var id_alerta = obj.data[i].ale_man_id;
					$('#sel_estado_'+obj.data[i].ale_man_id).html($('<option />', {
                	text: nom_estado,
                    value: id_estado,
                    }));
                if(id_estado == 5){ //en atencion
                	let data3 = new Object();
					data3.estado_id = 5;
					$('#sel_estado_'+id_alerta).append($('<option />', {
                        text: 'Mitigada',
                        value: 6,
                    }));
                    $('#sel_estado_'+id_alerta).append($('<option />', {
                        text: 'No Mitigada',
                        value: 7,
                    }));
				}
			}
		}).fail(function(objeto, tipoError, errorHttp){
				desbloquearPantalla();
                manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
                return false;
        });
	}

	function guardarSesDevPreguntas(tipo, valor){

		limpiarMensajesFormularioSesionDevolucion();
				
		let data = new Object();

		data.cas_id = $('#cas_id').val();
		data.tipo	= tipo;
		data.valor  = valor;
		if(tipo == 'sesion_fecha'){
			if(!validarFecha(valor)){				
				return false
			} 
		}
		

		toastr.options = {
            "closeButton": true,
            "debug": true,
            "newestOnTop": true,
            "progressBar": false,
            "positionClass=": "toast-top-right",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "0",
            "hideDuration": "0",
            "timeOut": "2000",
            "extendedTimeOut": "2000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

		$.ajax({
			type: "GET",
			url: "{{ route('casos.guardarSesDevPreguntas') }}",
			data: data
		}).done(function(resp){
			toastr.success('Información almacenada satisfactoriamente');
		}).fail(function(obj){
			toastr.error('Ocurrió un error al guardar la información');
			console.log(obj);
		});
	
	}


	function validarFecha(){

		ses_dev_fec = $('#ses_dev_fec').val();
		let respuesta 	= true;

		if (ses_dev_fec == "" || typeof ses_dev_fec === "undefined"){
                respuesta = false;
                $("#val_ses_dev_fec").show();
		}else{
			if (!validarFormatoFecha(ses_dev_fec)){
				respuesta = false;
				$("#val_ses_dev_fec").show();
			}

			if (!existeFecha(ses_dev_fec)){
				respuesta = false;
				$("#val_ses_dev_fec").show();
			}
		}

		return respuesta;

	}

	function validacionPreguntasSesion(){

		let respuesta 	= true;
		let ses_dev_fec = $('#ses_dev_fec').val();
		let ses_dev_pre_1	= $("#ses_dev_pre_1").val();
		let ses_dev_pre_2	= $("#ses_dev_pre_2").val();
		let ses_dev_pre_3	= $("#ses_dev_pre_3").val();
		let ses_dev_pre_4	= $("#ses_dev_pre_4").val();
		let ses_dev_pre_5	= $("#ses_dev_pre_5").val();

		if (ses_dev_fec == "" || typeof ses_dev_fec === "undefined"){
                respuesta = false;
                $("#val_ses_dev_fec").show();
		}

		if (typeof ses_dev_pre_1 == "undefined" || ses_dev_pre_1 == ""){
			$("#val_ses_pre_1").show();
			$("#ses_dev_pre_1").addClass("is-invalid");
			respuesta = false;
		}

		if (typeof ses_dev_pre_2 == "undefined" || ses_dev_pre_2 == ""){
			$("#val_ses_pre_2").show();
			$("#ses_dev_pre_2").addClass("is-invalid");
			respuesta = false;
		}

		if (typeof ses_dev_pre_3 == "undefined" || ses_dev_pre_3 == ""){
			$("#val_ses_pre_3").show();
			$("#ses_dev_pre_3").addClass("is-invalid");
			respuesta = false;
		}

		if (typeof ses_dev_pre_4 == "undefined" || ses_dev_pre_4 == ""){
			$("#val_ses_pre_4").show();
			$("#ses_dev_pre_4").addClass("is-invalid");
			respuesta = false;
		}

		if (typeof ses_dev_pre_5 == "undefined" || ses_dev_pre_5 == ""){
			$("#val_ses_pre_5").show();
			$("#ses_dev_pre_5").addClass("is-invalid");
			respuesta = false;
		}

		return respuesta;
	}


	function limpiarMensajesFormularioSesionDevolucion(){
		
		$("#val_ses_dev_fec").hide();
		$("#val_ses_pre_1").hide();
		$("#val_ses_pre_2").hide();
		$("#val_ses_pre_3").hide();
		$("#val_ses_pre_4").hide();
		$("#val_ses_pre_5").hide();
		
		$('#ses_dev_pre_1').removeClass("is-invalid");
		$('#ses_dev_pre_2').removeClass("is-invalid");
		$('#ses_dev_pre_3').removeClass("is-invalid");
		$('#ses_dev_pre_4').removeClass("is-invalid");
		$('#ses_dev_pre_5').removeClass("is-invalid");

	}


	/**
	 * Función que lista las sesiones de devolución
	 */
	function listarSesionDevolucion(){

		let data 	= new Object();
		data.cas_id	= $('#cas_id').val();

		$.ajax({
			url: "{{ route('casos.listarSesionDevolucion') }}",
			type: "GET",
			data: data
		}).done(function(resp){

			sesDev = $.parseJSON(resp.data);

			if(resp.estado == 1){
				
				if("{{$modo_visualizacion}}" == "edicion" ){
					
					$('#ses_dev_pre_1').val(sesDev.ses_dev_pre_1);
					$('#ses_dev_pre_2').val(sesDev.ses_dev_pre_2);
					$('#ses_dev_pre_3').val(sesDev.ses_dev_pre_3);
					$('#ses_dev_pre_4').val(sesDev.ses_dev_pre_4);
					$('#ses_dev_pre_5').val(sesDev.ses_dev_pre_5);
					$('#ses_dev_fec').val(sesDev.ses_dev_fec);
					// $('.contFec').text(sesDev.ses_dev_fec);

					// $('#contenedor_pre_edit').show();
					// $('#div_btn_agr_ses_dev').hide();

				}else{

					$('#vis_pre_1').text(sesDev.ses_dev_pre_1);
					$('#vis_pre_2').text(sesDev.ses_dev_pre_2);
					$('#vis_pre_3').text(sesDev.ses_dev_pre_3);
					$('#vis_pre_4').text(sesDev.ses_dev_pre_4);
					$('#vis_pre_5').text(sesDev.ses_dev_pre_5);
					$('#vis_fec_ses').text(sesDev.ses_dev_fec);
				}


			}else{
				$('#div_btn_agr_ses_dev').show();
			}

		}).fail(function(objeto, tipoError, errorHttp){
                    desbloquearPantalla();

                    manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

                    return false;
        });

	}


	/**
	 * Función que valida los caracteres ingresados en un textarea
	 */
	function valTextAreaSesDevCom(){

  	 	num_caracteres_permitidos 	= 2000;
	    num_caracteres 				= $("#ses_dev_com").val().length;

	    if (num_caracteres > num_caracteres_permitidos){ 
	    	$("#ses_dev_com").val(contenido_textarea_com_ses);
	    }else{ 
	    	contenido_textarea_com_ses = $("#ses_dev_com").val(); 
	    }

	    if (num_caracteres >= num_caracteres_permitidos){ 
	    	$("#ses_dev_com_len").css("color", "#ff0000"); 
	    }else{ 
	    	$("#ses_dev_com_len").css("color", "#000000");
	    } 
	      
	    $("#ses_dev_com_len").text($("#ses_dev_com").val().length);
   }
   
	function onpasteval(opc){
		setTimeout(function(){ 
		switch(opc){
			case 1:
			valTextAreaSesDevPre1(); 
			break;
			case 2:
			valTextAreaSesDevPre2(); 
			break;
			case 3:
			valTextAreaSesDevPre3(); 
			break;
			case 4:
			valTextAreaSesDevPre4(); 
			break;
			case 5:
			valTextAreaSesDevPre5(); 
			break;
		}
			
		}, 1);
	}

   function valTextAreaSesDevPre1(){

		num_caracteres_permitidos 	= 1000;
		num_caracteres 				= $("#ses_dev_pre_1").val().length;

		if (num_caracteres > num_caracteres_permitidos){ 
			$("#ses_dev_pre_1").val(contenido_textarea_com_ses);
		}else{ 
			contenido_textarea_com_ses = $("#ses_dev_pre_1").val(); 
		}

		if (num_caracteres >= num_caracteres_permitidos){ 
			$("#cant_carac_1").css("color", "#ff0000"); 
		}else{ 
			$("#cant_carac_1").css("color", "#000000");
		} 

		$("#cant_carac_1").text($("#ses_dev_pre_1").val().length);
	}

   function valTextAreaSesDevPre2(){

		num_caracteres_permitidos 	= 1000;
		num_caracteres 				= $("#ses_dev_pre_2").val().length;

		if (num_caracteres > num_caracteres_permitidos){ 
			$("#ses_dev_pre_2").val(contenido_textarea_com_ses);
		}else{ 
			contenido_textarea_com_ses = $("#ses_dev_pre_2").val(); 
		}

		if (num_caracteres >= num_caracteres_permitidos){ 
			$("#cant_carac_2").css("color", "#ff0000"); 
		}else{ 
			$("#cant_carac_2").css("color", "#000000");
		} 

		$("#cant_carac_2").text($("#ses_dev_pre_2").val().length);
	}

   function valTextAreaSesDevPre3(){

		num_caracteres_permitidos 	= 1000;
		num_caracteres 				= $("#ses_dev_pre_3").val().length;

		if (num_caracteres > num_caracteres_permitidos){ 
			$("#ses_dev_pre_3").val(contenido_textarea_com_ses);
		}else{ 
			contenido_textarea_com_ses = $("#ses_dev_pre_3").val(); 
		}

		if (num_caracteres >= num_caracteres_permitidos){ 
			$("#cant_carac_3").css("color", "#ff0000"); 
		}else{ 
			$("#cant_carac_3").css("color", "#000000");
		} 

		$("#cant_carac_3").text($("#ses_dev_pre_3").val().length);
	}

   function valTextAreaSesDevPre4(){

		num_caracteres_permitidos 	= 1000;
		num_caracteres 				= $("#ses_dev_pre_4").val().length;

		if (num_caracteres > num_caracteres_permitidos){ 
			$("#ses_dev_pre_4").val(contenido_textarea_com_ses);
		}else{ 
			contenido_textarea_com_ses = $("#ses_dev_pre_4").val(); 
		}

		if (num_caracteres >= num_caracteres_permitidos){ 
			$("#cant_carac_4").css("color", "#ff0000"); 
		}else{ 
			$("#cant_carac_4").css("color", "#000000");
		} 

		$("#cant_carac_4").text($("#ses_dev_pre_4").val().length);
	}
		
   function valTextAreaSesDevPre5(){

		num_caracteres_permitidos 	= 1000;
		num_caracteres 				= $("#ses_dev_pre_5").val().length;

		if (num_caracteres > num_caracteres_permitidos){ 
			$("#ses_dev_pre_5").val(contenido_textarea_com_ses);
		}else{ 
			contenido_textarea_com_ses = $("#ses_dev_pre_5").val(); 
		}

		if (num_caracteres >= num_caracteres_permitidos){ 
			$("#cant_carac_5").css("color", "#ff0000"); 
		}else{ 
			$("#cant_carac_5").css("color", "#000000");
		} 

		$("#cant_carac_5").text($("#ses_dev_pre_5").val().length);
	}

   $(function() {
			
		$('.date-pick').datetimepicker({
			maxDate: $.now(),
			minDate: new Date('2019/01/01'),
			format: 'DD/MM/Y'
		});
		$('#ses_dev_fec').val('');
	});

   $('#agregar_ses_dev_modal').click(function(){
    //Some code
    	limpiarMensajesFormularioSesionDevolucion();
	});
</script>
