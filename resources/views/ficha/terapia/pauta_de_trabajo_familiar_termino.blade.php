<div class="container">
	<div class="row">
		<div class="col-6 text-left">
			<!-- INICIO CZ SPRINT 69 -->
			@if($nna_teparia->flag_modelo_terapia == 1)
			<h6>Motivo de derivación a TF</h6>
				 @elseif($nna_teparia->flag_modelo_terapia == 2)
				 <h6>Motivo de participación en Fortaleciendo Familias. Especificar Dimensiones NCFAS-G descendidas y el conflicto o problema co construido con la familia, que se relaciona con los resultados del instrumento.</h6>				 
				 @endif
				<!-- FIN CZ SPRINT 69 -->
		</div>	
		<div class="col-6" style="word-break: break-all;">
			<label id="def_pro_preg_1" class="font-weight-bold"></label>
		</div>	
	</div>
	<br>


  @if ($modo_visualizacion == 'visualizacion')
  	  <div class="row">
	 	<div class="col-md-12 col-lg-6">
	 		<div class="col-12 text-left">
			 <!-- INICIO CZ SPRINT 69 -->
			 	@if($nna_teparia->flag_modelo_terapia == 1)
		 		<h6>1. ¿Cuál es la percepción de cada integrante de la familia acerca del problema que los trajo a TF?</h6>
				 @elseif($nna_teparia->flag_modelo_terapia == 2)
				 <h6>1. ¿Cuál es la percepción de cada integrante de la familia acerca del problema que los trajo a Fortaleciendo Familias?</h6>
				 @endif
				 <!-- FIN CZ SPRINT 69 -->
			</div>
	 	</div>
	 	<div class="col-md-12 col-lg-6" style="word-break: break-all;">
	 		<label id="ptf_preg_1" class="font-weight-bold"></label>
	 	</div>
	  </div>
	  <br>
  @elseif ($modo_visualizacion == 'edicion')
	  <div class="row">
	  	<div class="col-6">
			<!-- INICIO CZ SPRINT 69 -->
		  @if($nna_teparia->flag_modelo_terapia == 1)
	  		<h6>1. ¿Cuál es la percepción de cada integrante de la familia acerca del problema que los trajo a TF?</h6>
				 @elseif($nna_teparia->flag_modelo_terapia == 2)
				 <h6>1. ¿Cuál es la percepción de cada integrante de la familia acerca del problema que los trajo a Fortaleciendo Familias?</h6>
				 @endif	  	</div>
				 <!-- FIN CZ SPRINT 69 -->
	  	<div class="col-6">
	  		<textarea maxlength="1000" onkeypress="return caracteres_especiales(event);" class="form-control  input_desabilitar" rows="7" id="ptf_preg_1" placeholder="Ingrese respuesta"  onblur="guardarPauTrabFamTer({{$nna_teparia->tera_id}},1);"
	  		onkeydown="validarCantidadCaracteresPauTrabFamTer(1);" onkeyup="validarCantidadCaracteresPauTrabFamTer(1);"  @if (config('constantes.gtf_ejecucion')  != $estado_actual_terapia) disabled @endif></textarea>

	  		<div class="row">
				<div class="col-6">
					<h6><small class="form-text text-muted">Mínimo 3 y máximo 1000 caracteres.</small></h6>
				</div>
				<div class="col-6">
					<h6><small class="form-text text-muted">N° de caracteres: <strong id="can_ptf_preg_1" style="color: #000000;">0</strong></small></h6>
				</div>
			</div>

	  		<p id="val_ptf_preg_1" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar un comentario válido.</p>
	  	</div>
	  </div>
	  <br>
  @endif


{{--   @if ($modo_visualizacion == 'visualizacion')
	<div class="row">
	 	<div class="col-md-12 col-lg-6">
	 		<div class="col-12 text-left">
		 		<h6>2. ¿Qué es lo que cada uno señala que cambió?</h6>
			</div>
	 	</div>
	 	<div class="col-md-12 col-lg-6" style="word-break: break-all;">
	 		<label id="ptf_preg_2" class="font-weight-bold"></label>
	 	</div>
	</div>
	<br>

  @elseif ($modo_visualizacion == 'edicion')
	  <div class="row">
	  	<div class="col-6">
	  		<h6>2. ¿Qué es lo que cada uno señala que cambió?</h6>
	  	</div>
	  	<div class="col-6">
	  		<textarea maxlength="1000" onkeypress="return caracteres_especiales(event);" class="form-control  input_desabilitar" rows="7" id="ptf_preg_2" placeholder="Ingrese respuesta" 
	  		onkeydown="validarCantidadCaracteresPauTrabFamTer(2);" onkeyup="validarCantidadCaracteresPauTrabFamTer(2);" onblur="guardarPauTrabFamTer({{$nna_teparia->tera_id}},2)"  @if (config('constantes.gtf_ejecucion')  != $estado_actual_terapia) disabled @endif></textarea>

	  		<div class="row">
				<div class="col-6">
					<h6><small class="form-text text-muted">Mínimo 3 y máximo 1000 caracteres.</small></h6>
				</div>
				<div class="col-6">
					<h6><small class="form-text text-muted">N° de caracteres: <strong id="can_ptf_preg_2" style="color: #000000;">0</strong></small></h6>
				</div>
			</div>

	  		<p id="val_ptf_preg_2" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar un comentario válido.</p>
	  	</div>
	  </div>
	  <br>

  @endif --}}

  @if ($modo_visualizacion == 'visualizacion')
  	<div class="row">
	 	<div class="col-md-12 col-lg-6">
	 		<div class="col-12 text-left">
				<!-- INICIO CZ SPRINT 69 -->
			 @if($nna_teparia->flag_modelo_terapia == 1)
		 		<h6>2. Describa ¿cómo se modificó el circuito del problema?</h6>
			@elseif($nna_teparia->flag_modelo_terapia == 2)
			<h6>2. Describa cómo cambió la situacion problema durante la intervención, qué cambios ven respecto a la participación que tenía cada integrante de la familia en este problema.</h6>
			@endif
			<!-- FIN CZ SPRINT 69 -->
			</div>
	 	</div>
	 	<div class="col-md-12 col-lg-6" style="word-break: break-all;">
	 		<label id="ptf_preg_3" class="font-weight-bold"></label>
	 	</div>
	</div>
	<br>

  @elseif ($modo_visualizacion == 'edicion')
	  <div class="row">
	  	<div class="col-6">
			  <!-- INICIO CZ SPRINT 69 -->
		  @if($nna_teparia->flag_modelo_terapia == 1)
	  		<h6>2. Describa ¿cómo se modificó el circuito del problema?</h6>
			@elseif($nna_teparia->flag_modelo_terapia == 2)
			<h6>2. Describa cómo cambió la situacion problema durante la intervención, qué cambios ven respecto a la participación que tenía cada integrante de la familia en este problema.</h6>
			@endif	  	
		<!-- FIN CZ SPRINT 69 -->
	  	</div>
	  	<div class="col-6">
	  		<textarea maxlength="1000" onkeypress="return caracteres_especiales(event);" class="form-control  input_desabilitar" rows="7" id="ptf_preg_3" placeholder="Ingrese respuesta" 
	  		onkeydown="validarCantidadCaracteresPauTrabFamTer(3);" onkeyup="validarCantidadCaracteresPauTrabFamTer(3);" onblur="guardarPauTrabFamTer({{$nna_teparia->tera_id}},3)"  @if (config('constantes.gtf_ejecucion')  != $estado_actual_terapia) disabled @endif></textarea>

	  		<div class="row">
				<div class="col-6">
					<h6><small class="form-text text-muted">Mínimo 3 y máximo 1000 caracteres.</small></h6>
				</div>
				<div class="col-6">
					<h6><small class="form-text text-muted">N° de caracteres: <strong id="can_ptf_preg_3" style="color: #000000;">0</strong></small></h6>
				</div>
			</div>

	  		<p id="val_ptf_preg_3" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar un comentario válido.</p>
	  	</div>
	  </div>
	  <br>

  @endif

  {{-- @if ($modo_visualizacion == 'visualizacion')
  	<div class="row">
	 	<div class="col-md-12 col-lg-6">
	 		<div class="col-12 text-left">
		 		<h6>4. Describa ¿cómo los recursos de la familia favorecieron (o nó) los cambios?</h6>
			</div>
	 	</div>
	 	<div class="col-md-12 col-lg-6" style="word-break: break-all;">
	 		<label id="ptf_preg_4" class="font-weight-bold"></label>
	 	</div>
	</div>
	<br>

  @elseif ($modo_visualizacion == 'edicion')
	  <div class="row">
	  	<div class="col-6">
	  		<h6>4. Describa ¿cómo los recursos de la familia favorecieron (o nó) los cambios?</h6>
	  	</div>
	  	<div class="col-6">
	  		<textarea maxlength="1000" onkeypress="return caracteres_especiales(event);" class="form-control  input_desabilitar" rows="7" id="ptf_preg_4" placeholder="Ingrese respuesta" 
	  		onkeydown="validarCantidadCaracteresPauTrabFamTer(4);" onkeyup="validarCantidadCaracteresPauTrabFamTer(4);" onblur="guardarPauTrabFamTer({{$nna_teparia->tera_id}},4);"  @if (config('constantes.gtf_ejecucion')  != $estado_actual_terapia) disabled @endif></textarea>

	  		<div class="row">
				<div class="col-6">
					<h6><small class="form-text text-muted">Mínimo 3 y máximo 1000 caracteres.</small></h6>
				</div>
				<div class="col-6">
					<h6><small class="form-text text-muted">N° de caracteres: <strong id="can_ptf_preg_4" style="color: #000000;">0</strong></small></h6>
				</div>
			</div>

	  		<p id="val_ptf_preg_4" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar un comentario válido.</p>
	  	</div>
	  </div>
	  <br>
  @endif --}}

  {{-- @if ($modo_visualizacion == 'visualizacion')
  	<div class="row">
	 	<div class="col-md-12 col-lg-6">
	 		<div class="col-12 text-left">
		 		<h6>5. Describa la evolución de los factores de riesgos individuales y familiares.</h6>
			</div>
	 	</div>
	 	<div class="col-md-12 col-lg-6" style="word-break: break-all;">
	 		<label id="ptf_preg_5" class="font-weight-bold"></label>
	 	</div>
	</div>
	<br>

  @elseif ($modo_visualizacion == 'edicion')
	  <div class="row">
	  	<div class="col-6">
	  		<h6>5. Describa la evolución de los factores de riesgos individuales y familiares.</h6>
	  	</div>
	  	<div class="col-6">
	  		<textarea maxlength="1000" onkeypress="return caracteres_especiales(event);" class="form-control  input_desabilitar" rows="7" id="ptf_preg_5" placeholder="Ingrese respuesta" 
	  		onkeydown="validarCantidadCaracteresPauTrabFamTer(5);" onkeyup="validarCantidadCaracteresPauTrabFamTer(5);" onblur="guardarPauTrabFamTer({{$nna_teparia->tera_id}},5)"  @if (config('constantes.gtf_ejecucion')  != $estado_actual_terapia) disabled @endif></textarea>

	  		<div class="row">
				<div class="col-6">
					<h6><small class="form-text text-muted">Mínimo 3 y máximo 1000 caracteres.</small></h6>
				</div>
				<div class="col-6">
					<h6><small class="form-text text-muted">N° de caracteres: <strong id="can_ptf_preg_5" style="color: #000000;">0</strong></small></h6>
				</div>
			</div>

	  		<p id="val_ptf_preg_5" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar un comentario válido.</p>
	  	</div>
	  </div>
	  <br>

  @endif --}}


 {{--  @if ($modo_visualizacion == 'visualizacion')
  	<div class="row">
	 	<div class="col-md-12 col-lg-6">
	 		<div class="col-12 text-left">
		 		<h6>5. Describa la evolución de los factores de riesgos individuales y familiares.</h6>
			</div>
	 	</div>
	 	<div class="col-md-12 col-lg-6" style="word-break: break-all;">
	 		<label id="ptf_preg_6" class="font-weight-bold"></label>
	 	</div>
	</div>
	<br>

  @elseif ($modo_visualizacion == 'edicion')
	  <div class="row">
	  	<div class="col-6">
	  		<h6>6. De acuerdo con éstos antecedentes ¿cómo describiría la situación contextual relacional actual de la familia?. ¿qué cambios se observan respecto a la situación inicial?</h6>
	  	</div>
	  	<div class="col-6">
	  		<textarea maxlength="1000" onkeypress="return caracteres_especiales(event);" class="form-control  input_desabilitar" rows="7" id="ptf_preg_6" placeholder="Ingrese respuesta" 
	  		onkeydown="validarCantidadCaracteresPauTrabFamTer(6);" onkeyup="validarCantidadCaracteresPauTrabFamTer(6);" onblur="guardarPauTrabFamTer({{$nna_teparia->tera_id}},6)"  @if (config('constantes.gtf_ejecucion')  != $estado_actual_terapia) disabled @endif></textarea>

	  		<div class="row">
				<div class="col-6">
					<h6><small class="form-text text-muted">Mínimo 3 y máximo 1000 caracteres.</small></h6>
				</div>
				<div class="col-6">
					<h6><small class="form-text text-muted">N° de caracteres: <strong id="can_ptf_preg_6" style="color: #000000;">0</strong></small></h6>
				</div>
			</div>

	  		<p id="val_ptf_preg_6" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar un comentario válido.</p>
	  	</div>
	  </div>
	  <br>
  @endif --}}


  @if ($modo_visualizacion == 'visualizacion')
  	<div class="row">
	 	<div class="col-md-12 col-lg-6">
	 		<div class="col-12 text-left">
				 <!-- INICIO CZ SPRINT 69 -->
				 @if($nna_teparia->flag_modelo_terapia == 1)
		 		<h6>3. De acuerdo con el objetivo terapéutico planteado, ¿cómo evalúa el logro o nó de éste a partir del trabajo de TF?</h6>
				 @elseif($nna_teparia->flag_modelo_terapia == 2)
				 <h6>3. De acuerdo con el objetivo terapéutico planteado y co construido con a familia ¿Cómo evalúa el logro o nó de éste a partir del trabajo Fortaleciendo Familias?</h6>
				 @endif	
				 <!-- FIN CZ SPRINT 69 -->		
			</div>
	 	</div>
	 	<div class="col-md-12 col-lg-6" style="word-break: break-all;">
	 		<label id="ptf_preg_7" class="font-weight-bold"></label>
	 	</div>
	</div>
	<br>

  @elseif ($modo_visualizacion == 'edicion')
	  <div class="row">
	  	<div class="col-6">
			  <!-- INICIO CZ SPRINT 69 -->
		  		@if($nna_teparia->flag_modelo_terapia == 1)
	  		<h6>3. De acuerdo con el objetivo terapéutico planteado, ¿cómo evalúa el logro o nó de éste a partir del trabajo de TF?</h6>
				 @elseif($nna_teparia->flag_modelo_terapia == 2)
				 <h6>3. De acuerdo con el objetivo terapéutico planteado y co construido con a familia ¿Cómo evalúa el logro o nó de éste a partir del trabajo Fortaleciendo Familias?</h6>
				 @endif
				 <!-- FIN CZ SPRINT 69 -->
	  	</div>
	  	<div class="col-6">
	  		<textarea maxlength="1000" onkeypress="return caracteres_especiales(event);" class="form-control  input_desabilitar" rows="7" id="ptf_preg_7" placeholder="Ingrese respuesta" 
	  		onkeydown="validarCantidadCaracteresPauTrabFamTer(7);" onkeyup="validarCantidadCaracteresPauTrabFamTer(7);" onblur="guardarPauTrabFamTer({{$nna_teparia->tera_id}},7)"  @if (config('constantes.gtf_ejecucion')  != $estado_actual_terapia) disabled @endif></textarea>

	  		<div class="row">
				<div class="col-6">
					<h6><small class="form-text text-muted">Mínimo 3 y máximo 1000 caracteres.</small></h6>
				</div>
				<div class="col-6">
					<h6><small class="form-text text-muted">N° de caracteres: <strong id="can_ptf_preg_7" style="color: #000000;">0</strong></small></h6>
				</div>
			</div>

	  		<p id="val_ptf_preg_7" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar un comentario válido.</p>
	  	</div>
	  </div>
	  <br>

  @endif

{{--   @if ($modo_visualizacion == 'visualizacion')
  	<div class="row">
	 	<div class="col-md-12 col-lg-6">
	 		<div class="col-12 text-left">
		 		<h6>8. ¿Cómo ha variado el circuito del problema descrito inicialmente?</h6>
			</div>
	 	</div>
	 	<div class="col-md-12 col-lg-6" style="word-break: break-all;">
	 		<label id="ptf_preg_8" class="font-weight-bold"></label>
	 	</div>
	</div>
	<br>

  @elseif ($modo_visualizacion == 'edicion')
	   <div class="row">
	  	<div class="col-6">
	  		<h6>8. ¿Cómo ha variado el circuito del problema descrito inicialmente?</h6>
	  	</div>
	  	<div class="col-6">
	  		<textarea maxlength="1000" onkeypress="return caracteres_especiales(event);" class="form-control  input_desabilitar" rows="7" id="ptf_preg_8" placeholder="Ingrese respuesta" 
	  		onkeydown="validarCantidadCaracteresPauTrabFamTer(8);" onkeyup="validarCantidadCaracteresPauTrabFamTer(8);" onblur="guardarPauTrabFamTer({{$nna_teparia->tera_id}},8)"  @if (config('constantes.gtf_ejecucion')  != $estado_actual_terapia) disabled @endif></textarea>

	  		<div class="row">
				<div class="col-6">
					<h6><small class="form-text text-muted">Mínimo 3 y máximo 1000 caracteres.</small></h6>
				</div>
				<div class="col-6">
					<h6><small class="form-text text-muted">N° de caracteres: <strong id="can_ptf_preg_8" style="color: #000000;">0</strong></small></h6>
				</div>
			</div>

	  		<p id="val_ptf_preg_8" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar un comentario válido.</p>
	  	</div>
	  </div>
	  <br>

  @endif --}}

  @if ($modo_visualizacion == 'visualizacion')
  	<div class="row">
	 	<div class="col-md-12 col-lg-6">
	 		<div class="col-12 text-left">
				 <!-- INICIO CZ SPRINT 69 -->
			 	@if($nna_teparia->flag_modelo_terapia == 1)
		 		<h6>4. ¿Cuáles fueron los principales focos de la intervención realizada?</h6>
				 @elseif($nna_teparia->flag_modelo_terapia == 2)
				 <h6>4. Indique cuáles fueron las dimensiones NCFAS-G que estaban diosminuidas y cuál fue el abordaje que se hizo de estas en la intervención.</h6>

				 @endif
				 <!-- FIN CZ SPRINT 69 -->
			</div>
	 	</div>
	 	<div class="col-md-12 col-lg-6" style="word-break: break-all;">
	 		<label id="ptf_preg_9" class="font-weight-bold"></label>
	 	</div>
	</div>
	<br>

  @elseif ($modo_visualizacion == 'edicion')
	  <div class="row">
	  	<div class="col-6">
			  <!-- INICIO CZ SPRINT 69 -->
			@if($nna_teparia->flag_modelo_terapia == 1)
	  		<h6>4. ¿Cuáles fueron los principales focos de la intervención realizada?</h6>
				@elseif($nna_teparia->flag_modelo_terapia == 2)
				<h6>4. Indique cuáles fueron las dimensiones NCFAS-G que estaban diosminuidas y cuál fue el abordaje que se hizo de estas en la intervención.</h6>

			@endif	  	
			<!-- FIN CZ SPRINT 69 -->
	  	</div>
	  	<div class="col-6">
	  		<textarea maxlength="1000" onkeypress="return caracteres_especiales(event);" class="form-control  input_desabilitar" rows="7" id="ptf_preg_9" placeholder="Ingrese respuesta" 
	  		onkeydown="validarCantidadCaracteresPauTrabFamTer(9);" onkeyup="validarCantidadCaracteresPauTrabFamTer(9);" onblur="guardarPauTrabFamTer({{$nna_teparia->tera_id}},9)"  @if (config('constantes.gtf_ejecucion')  != $estado_actual_terapia) disabled @endif></textarea>

	  		<div class="row">
				<div class="col-6">
					<h6><small class="form-text text-muted">Mínimo 3 y máximo 1000 caracteres.</small></h6>
				</div>
				<div class="col-6">
					<h6><small class="form-text text-muted">N° de caracteres: <strong id="can_ptf_preg_9" style="color: #000000;">0</strong></small></h6>
				</div>
			</div>

	  		<p id="val_ptf_preg_9" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar un comentario válido.</p>
	  	</div>
	  </div>
	  <br>

  @endif

  @if ($modo_visualizacion == 'visualizacion')
  	<div class="row">
	 	<div class="col-md-12 col-lg-6">
	 		<div class="col-12 text-left">
				 <!-- INICIO CZ SPRINT 69 -->
			 	@if($nna_teparia->flag_modelo_terapia == 1)
		 		<h6>5. ¿Cuál de las estrategias de intervención utilizadas considera que impactó de manera más favorable al logro de los objetivos?</h6>
				 @elseif($nna_teparia->flag_modelo_terapia == 2)
				 <h6>5. ¿Cuál de las estrategias de intervención utilizadas (en las sesiones familiares y/o multifamiliares) considera que impactó de manera más favorable al logro de los objetivos?</h6>
				 @endif
				 <!-- FIN CZ SPRINT 69 -->
			</div>
	 	</div>
	 	<div class="col-md-12 col-lg-6" style="word-break: break-all;">
	 		<label id="ptf_preg_10" class="font-weight-bold"></label>
	 	</div>
	</div>
	<br>

  @elseif ($modo_visualizacion == 'edicion')
     <div class="row">
	  	<div class="col-6">
			  <!-- INICIO CZ SPRINT 69 -->
		  		@if($nna_teparia->flag_modelo_terapia == 1)
	  		<h6>5. ¿Cuál de las estrategias de intervención utilizadas considera que impactó de manera más favorable al logro de los objetivos?</h6>
				 @elseif($nna_teparia->flag_modelo_terapia == 2)
				 <h6>5. ¿Cuál de las estrategias de intervención utilizadas (en las sesiones familiares y/o multifamiliares) considera que impactó de manera más favorable al logro de los objetivos?</h6>
				 @endif
				 <!-- FIN CZ SPRINT 69 -->
	  	</div>
	  	<div class="col-6">
	  		<textarea maxlength="1000" onkeypress="return caracteres_especiales(event);" class="form-control  input_desabilitar" rows="7" id="ptf_preg_10" placeholder="Ingrese respuesta" 
	  		onkeydown="validarCantidadCaracteresPauTrabFamTer(10);" onkeyup="validarCantidadCaracteresPauTrabFamTer(10);" onblur="guardarPauTrabFamTer({{$nna_teparia->tera_id}},10)"  @if (config('constantes.gtf_ejecucion')  != $estado_actual_terapia) disabled @endif></textarea>

	  		<div class="row">
				<div class="col-6">
					<h6><small class="form-text text-muted">Mínimo 3 y máximo 1000 caracteres.</small></h6>
				</div>
				<div class="col-6">
					<h6><small class="form-text text-muted">N° de caracteres: <strong id="can_ptf_preg_10" style="color: #000000;">0</strong></small></h6>
				</div>
			</div>

	  		<p id="val_ptf_preg_10" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar un comentario válido.</p>
	  	</div>
	 </div>
	 <br>

  @endif

  @if ($modo_visualizacion == 'visualizacion')
  	<div class="row">
	 	<div class="col-md-12 col-lg-6">
	 		<div class="col-12 text-left">
		 		<h6>6. ¿Qué estrategias o herramientas debería mantener la familia en el tiempo para enfrentar situaciones similares?</h6>
			</div>
	 	</div>
	 	<div class="col-md-12 col-lg-6" style="word-break: break-all;">
	 		<label id="ptf_preg_11" class="font-weight-bold"></label>
	 	</div>
	</div>
	<br>

  @elseif ($modo_visualizacion == 'edicion')
   	<div class="row">
	  	<div class="col-6">
	  		<h6>6. ¿Qué estrategias o herramientas debería mantener la familia en el tiempo para enfrentar situaciones similares?</h6>
	  	</div>
	  	<div class="col-6">
	  		<textarea maxlength="1000" onkeypress="return caracteres_especiales(event);" class="form-control  input_desabilitar" rows="7" id="ptf_preg_11" placeholder="Ingrese respuesta" 
	  		onkeydown="validarCantidadCaracteresPauTrabFamTer(11);" onkeyup="validarCantidadCaracteresPauTrabFamTer(11);" onblur="guardarPauTrabFamTer({{$nna_teparia->tera_id}},11)"  @if (config('constantes.gtf_ejecucion')  != $estado_actual_terapia) disabled @endif></textarea>

	  		<div class="row">
				<div class="col-6">
					<h6><small class="form-text text-muted">Mínimo 3 y máximo 1000 caracteres.</small></h6>
				</div>
				<div class="col-6">
					<h6><small class="form-text text-muted">N° de caracteres: <strong id="can_ptf_preg_11" style="color: #000000;">0</strong></small></h6>
				</div>
			</div>

	  		<p id="val_ptf_preg_11" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar un comentario válido.</p>
	  	</div>
	</div>
    <br>
    
  @endif

</div>
<script type="text/javascript">
  valor_definicion_problema = new Array(); 
  function validarCantidadCaracteresPauTrabFamTer(option){

      let num_caracteres_permitidos = 1000;
      let num_caracteres = $("#ptf_preg_"+option).val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#ptf_preg_"+option).val(valor_definicion_problema[option]);

       }else{ 
          valor_definicion_problema[option] = $("#ptf_preg_"+option).val();

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#can_ptf_preg_"+option).css("color", "#ff0000"); 

       }else{ 
          $("#can_ptf_preg_"+option).css("color", "#000000");

       } 
      
       $("#can_ptf_preg_"+option).text(num_caracteres);
   }

	function validarPauTrabFamTer(){
		let respuesta = true;

		eliminarMensajesTrabFamTer();

		let pregunta_1 = $("#ptf_preg_1").val().trim();
		// let pregunta_2 = $("#ptf_preg_2").val().trim();
		let pregunta_3 = $("#ptf_preg_3").val().trim();
		// let pregunta_4 = $("#ptf_preg_4").val().trim();
		// let pregunta_5 = $("#ptf_preg_5").val().trim();
		// let pregunta_6 = $("#ptf_preg_6").val().trim();
		let pregunta_7 = $("#ptf_preg_7").val().trim();
		// let pregunta_8 = $("#ptf_preg_8").val().trim();
		let pregunta_9 = $("#ptf_preg_9").val().trim();
		let pregunta_10 = $("#ptf_preg_10").val().trim();
		let pregunta_11 = $("#ptf_preg_11").val().trim();
		// let pregunta_12 = $("#ptf_preg_12").val().trim();

		if (pregunta_1 == "" || pregunta_1.length < 3 || typeof pregunta_1 === "undefined"){
			respuesta = false;
			$("#ptf_preg_1").addClass("is-invalid");
			$("#val_ptf_preg_1").show();
		}

		// if (pregunta_2 == "" || pregunta_2.length < 3 || typeof pregunta_2 === "undefined"){
		// 	respuesta = false;
		// 	$("#ptf_preg_2").addClass("is-invalid");
		// 	$("#val_ptf_preg_2").show();
		// }

		if (pregunta_3 == "" || pregunta_3.length < 3 || typeof pregunta_3 === "undefined"){
			respuesta = false;
			$("#ptf_preg_3").addClass("is-invalid");
			$("#val_ptf_preg_3").show();
		}

		// if (pregunta_4 == "" || pregunta_4.length < 3 || typeof pregunta_4 === "undefined"){
		// 	respuesta = false;
		// 	$("#ptf_preg_4").addClass("is-invalid");
		// 	$("#val_ptf_preg_4").show();
		// }

		// if (pregunta_5 == "" || pregunta_5.length < 3 || typeof pregunta_5 === "undefined"){
		// 	respuesta = false;
		// 	$("#ptf_preg_5").addClass("is-invalid");
		// 	$("#val_ptf_preg_5").show();
		// }

		// if (pregunta_6 == "" || pregunta_6.length < 3 || typeof pregunta_6 === "undefined"){
		// 	respuesta = false;
		// 	$("#ptf_preg_6").addClass("is-invalid");
		// 	$("#val_ptf_preg_6").show();
		// }

		if (pregunta_7 == "" || pregunta_7.length < 3 || typeof pregunta_7 === "undefined"){
			respuesta = false;
			$("#ptf_preg_7").addClass("is-invalid");
			$("#val_ptf_preg_7").show();
		}

		// if (pregunta_8 == "" || pregunta_8.length < 3 || typeof pregunta_8 === "undefined"){
		// 	respuesta = false;
		// 	$("#ptf_preg_8").addClass("is-invalid");
		// 	$("#val_ptf_preg_8").show();
		// }

		if (pregunta_9 == "" || pregunta_9.length < 3 || typeof pregunta_9 === "undefined"){
			respuesta = false;
			$("#ptf_preg_9").addClass("is-invalid");
			$("#val_ptf_preg_9").show();
		}

		if (pregunta_10 == "" || pregunta_10.length < 3 || typeof pregunta_10 === "undefined"){
			respuesta = false;
			$("#ptf_preg_10").addClass("is-invalid");
			$("#val_ptf_preg_10").show();
		}

		if (pregunta_11 == "" || pregunta_11.length < 3 || typeof pregunta_11 === "undefined"){
			respuesta = false;
			$("#ptf_preg_11").addClass("is-invalid");
			$("#val_ptf_preg_11").show();
		}

		return respuesta;
	}

	function eliminarMensajesErrorPauTrabFamTer(){
		$("#ptf_preg_1").removeClass("is-invalid");
		// $("#ptf_preg_2").removeClass("is-invalid");
		$("#ptf_preg_3").removeClass("is-invalid");
		// $("#ptf_preg_4").removeClass("is-invalid");
		// $("#ptf_preg_5").removeClass("is-invalid");
		// $("#ptf_preg_6").removeClass("is-invalid");
		$("#ptf_preg_7").removeClass("is-invalid");
		// $("#ptf_preg_8").removeClass("is-invalid");
		$("#ptf_preg_9").removeClass("is-invalid");
		$("#ptf_preg_10").removeClass("is-invalid");
		$("#ptf_preg_11").removeClass("is-invalid");

		$("#val_ptf_preg_1").hide();
		// $("#val_ptf_preg_2").hide();
		$("#val_ptf_preg_3").hide();
		// $("#val_ptf_preg_4").hide();
		// $("#val_ptf_preg_5").hide();
		// $("#val_ptf_preg_6").hide();
		$("#val_ptf_preg_7").hide();
		// $("#val_ptf_preg_8").hide();
		$("#val_ptf_preg_9").hide();
		$("#val_ptf_preg_10").hide();
		$("#val_ptf_preg_11").hide();
	}

	function limpiarTextAreaPauTrabFamTer(){
		$("#ptf_preg_1").val("");
		// $("#ptf_preg_2").val("");
		$("#ptf_preg_3").val("");
		// $("#ptf_preg_4").val("");
		// $("#ptf_preg_5").val("");
		// $("#ptf_preg_6").val("");
		$("#ptf_preg_7").val("");
		// $("#ptf_preg_8").val("");
		$("#ptf_preg_9").val("");
		$("#ptf_preg_10").val("");
		$("#ptf_preg_11").val("");
	}

	function limpiarOnBlurPauTrabFamTer(){
		$("#ptf_preg_1").removeAttr("onBlur");
		// $("#ptf_preg_2").removeAttr("onBlur");
		$("#ptf_preg_3").removeAttr("onBlur");
		// $("#ptf_preg_4").removeAttr("onBlur");
		// $("#ptf_preg_5").removeAttr("onBlur");
		// $("#ptf_preg_6").removeAttr("onBlur");
		$("#ptf_preg_7").removeAttr("onBlur");
		// $("#ptf_preg_8").removeAttr("onBlur");
		$("#ptf_preg_9").removeAttr("onBlur");
		$("#ptf_preg_10").removeAttr("onBlur");
		$("#ptf_preg_11").removeAttr("onBlur");
	}

	function rescatarPauTrabFamTer(option){
		let pregunta = $("#ptf_preg_"+option).val();

		return pregunta;
	}

	function guardarPauTrabFamTer(tera_id, option, def_pro_id = null){
		let valor = rescatarPauTrabFamTer(option);

		eliminarMensajesErrorPauTrabFamTer();

		if (valor == "" || valor.length < 3 || typeof valor === "undefined"){
			$("#ptf_preg_"+option).addClass("is-invalid");
			$("#val_ptf_preg_"+option).show();
			return false;
		}

		let data = new Object();
		data.option  	= option;
		data.tera_id 	= tera_id;
		data.valor 	 	= valor;

		bloquearPantalla();

		$.ajaxSetup({
			headers: {
			    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
	      url: "{{ route('guardar.pauta.trabajo.fam.ter') }}",
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

            return false;
	    });
	}
</script>	