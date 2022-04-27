<div class="container">

@if ($modo_visualizacion == 'visualizacion')
	<div class="row">
		<div class="col-6 text-left">
		<!-- // INICIO CZ SPRINT 69 -->
		@if($nna_teparia->flag_modelo_terapia == 1)
			<h6>1. Motivo de derivación a TF</h6>
		@elseif ($nna_teparia->flag_modelo_terapia == 2)
		<h6>1. Motivo de participación en Fortaleciendo Familias. Especificar Dimensiones NCFAS-G descendidas y el conflicto o problema co construido con la familia, que se relaciona con los resultados del instrumento.</h6>

		@endif
		<!-- // FIN CZ SPRINT 69		 -->
		</div>	
		<div class="col-6" style="word-break: break-all;">
			<label id="def_pro_preg_1" class="font-weight-bold"></label>
		</div>	
	</div>

@elseif ($modo_visualizacion == 'edicion')	
  <div class="row">
  	<div class="col-6">
		  		<!-- // INICIO CZ SPRINT 69 -->
	  @if($nna_teparia->flag_modelo_terapia == 1)
  		<h6>1. Motivo de derivación a TF</h6>
		@elseif ($nna_teparia->flag_modelo_terapia == 2)
		<h6>1. Motivo de participación en Fortaleciendo Familias. Especificar Dimensiones NCFAS-G descendidas y el conflicto o problema co construido con la familia, que se relaciona con los resultados del instrumento.</h6>
		@endif  	
			<!-- // FIN CZ SPRINT 69 -->
  	</div>
  	<div class="col-6">
  		<textarea maxlength="1000" onkeypress="return caracteres_especiales(event);" class="form-control  input_desabilitar" rows="7" id="def_pro_preg_1" placeholder="Ingrese respuesta"
  		onkeydown="validarCantidadCaracteresDefinicionProblema(1);" onkeyup="validarCantidadCaracteresDefinicionProblema(1);" @if (config('constantes.gtf_diagnostico')  != $estado_actual_terapia) disabled @endif></textarea>

  		<div class="row">
			<div class="col-6">
				<h6><small class="form-text text-muted">Mínimo 3 y máximo 1000 caracteres.</small></h6>
			</div>
			<div class="col-6">
				<h6><small class="form-text text-muted">N° de caracteres: <strong id="can_def_pro_preg_1" style="color: #000000;">0</strong></small></h6>
			</div>
		</div>

  		<p id="val_def_pro_preg_1" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar un comentario válido.</p>
  	</div>
  </div>
@endif

  <br>

  <!-- <div class="row">
  	<div class="col-6">
  		<h6>2. Derivante (Nombre persona y/o institución) explique descripción de la solicitud realizada por el derivante</h6>
  	</div>
  	<div class="col-6">
  		<textarea onkeypress="return caracteres_especiales(event);" class="form-control " rows="7" id="def_pro_preg_2" placeholder="Ingrese respuesta" 
  		onkeydown="validarCantidadCaracteresDefinicionProblema(2);" onkeyup="validarCantidadCaracteresDefinicionProblema(2);"></textarea>

  		<div class="row">
			<div class="col-6">
				<h6><small class"form-text text-muted">Mínimo 3 y máximo 1000 caracteres.</small></h6>
			</div>
			<div class="col-6">
				<h6><small class"form-text text-muted">N° de caracteres: <strong id="can_def_pro_preg_2" style="color: #000000;">0</strong></small></h6>
			</div>
		</div>

  		<p id="val_def_pro_preg_2" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar un comentario válido.</p>
  	</div>
  </div>
  <br> -->

@if ($modo_visualizacion == 'visualizacion')
  <div class="row">
		<div class="col-6 text-left">
		<!-- // INICIO CZ SPRINT 69 -->
		@if($nna_teparia->flag_modelo_terapia == 1)
			<h6>2. Describa como explica la familia su propia motivación para asistir a TF. Describa la motivación de cada integrante de la familia y la coincidencia o no con el motivo de derivación. ¿Quién pide ayuda y para qué?</h6>
		@elseif ($nna_teparia->flag_modelo_terapia == 2)
		<h6>2. Describa la motivación de cada integrante de la familia para participar de Fortaleciendo Familiar y qué espera cada uno/a que cambie al finalizar la intervención (expectativas).</h6>
		@endif  
				<!-- // FIN CZ SPRINT 69 -->
		</div>	
		<div class="col-6" style="word-break: break-all;">
			<label id="def_pro_preg_3" class="font-weight-bold"></label>
		</div>	
  </div>
@elseif ($modo_visualizacion == 'edicion')
  <div class="row">
  	<div class="col-6">
		  		<!-- // INICIO CZ SPRINT 69 -->
	  @if($nna_teparia->flag_modelo_terapia == 1)
  		<h6>2. Describa como explica la familia su propia motivación para asistir a TF. Describa la motivación de cada integrante de la familia y la coincidencia o no con el motivo de derivación. ¿Quién pide ayuda y para qué?</h6>
		@elseif ($nna_teparia->flag_modelo_terapia == 2)
		<h6>2. Describa la motivación de cada integrante de la familia para participar de Fortaleciendo Familiar y qué espera cada uno/a que cambie al finalizar la intervención (expectativas).</h6>
		@endif    	
			<!-- // FIN CZ SPRINT 69 -->
  	</div>
  	<div class="col-6">
  		<textarea maxlength="1000" onkeypress="return caracteres_especiales(event);" class="form-control  input_desabilitar" rows="7" id="def_pro_preg_3" placeholder="Ingrese respuesta" 
  		onkeydown="validarCantidadCaracteresDefinicionProblema(3);" onkeyup="validarCantidadCaracteresDefinicionProblema(3);" @if (config('constantes.gtf_diagnostico')  != $estado_actual_terapia) disabled @endif></textarea>

  		<div class="row">
			<div class="col-6">
				<h6><small class="form-text text-muted">Mínimo 3 y máximo 1000 caracteres.</small></h6>
			</div>
			<div class="col-6">
				<h6><small class="form-text text-muted">N° de caracteres: <strong id="can_def_pro_preg_3" style="color: #000000;">0</strong></small></h6>
			</div>
		</div>

  		<p id="val_def_pro_preg_3" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar un comentario válido.</p>
  	</div>
  </div>
@endif
<br>

@if ($modo_visualizacion == 'visualizacion')
  <div class="row">
		<div class="col-6 text-left">
					<!-- // INICIO CZ SPRINT 69 -->
		@if($nna_teparia->flag_modelo_terapia == 1)
			<h6>3. Hitos relevantes en relación al motivo de consulta de la familia: inicio de síntomas/conductas, acontecimientos ocurridos antes de eso, soluciones intentadas, etc)</h6>
		@elseif ($nna_teparia->flag_modelo_terapia == 2)
		<h6>3. Hitos relevantes en relación al motivo de participación de la familia en Fortaleciendo Familias: inicio de síntomas/conductas, acontecimientos ocurridos antes de eso que puedan relacionarse al problema actual, soluciones intentadas, etc)</h6>
		@endif  
				<!-- // FIN CZ SPRINT 69 -->
		</div>	
		<div class="col-6" style="word-break: break-all;">
			<label id="def_pro_preg_4" class="font-weight-bold"></label>
		</div>	
  </div>
@elseif ($modo_visualizacion == 'edicion')
  <div class="row">
  	<div class="col-6">
		  		<!-- // INICIO CZ SPRINT 69 -->
	 	 @if($nna_teparia->flag_modelo_terapia == 1)
  		<h6>3. Hitos relevantes en relación al motivo de consulta de la familia: inicio de síntomas/conductas, acontecimientos ocurridos antes de eso, soluciones intentadas, etc)</h6>
		@elseif ($nna_teparia->flag_modelo_terapia == 2)
		<h6>3. Hitos relevantes en relación al motivo de participación de la familia en Fortaleciendo Familias: inicio de síntomas/conductas, acontecimientos ocurridos antes de eso que puedan relacionarse al problema actual, soluciones intentadas, etc)</h6>
		@endif    	
				<!-- //  CZ SPRINT 69 -->
  	</div>
  	<div class="col-6">
  		<textarea maxlength="1000" onkeypress="return caracteres_especiales(event);" class="form-control  input_desabilitar" rows="7" id="def_pro_preg_4" placeholder="Ingrese respuesta" 
  		onkeydown="validarCantidadCaracteresDefinicionProblema(4);" onkeyup="validarCantidadCaracteresDefinicionProblema(4);" @if (config('constantes.gtf_diagnostico')  != $estado_actual_terapia) disabled @endif></textarea>

  		<div class="row">
			<div class="col-6">
				<h6><small class="form-text text-muted">Mínimo 3 y máximo 1000 caracteres.</small></h6>
			</div>
			<div class="col-6">
				<h6><small class="form-text text-muted">N° de caracteres: <strong id="can_def_pro_preg_4" style="color: #000000;">0</strong></small></h6>
			</div>
		</div>

  		<p id="val_def_pro_preg_4" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar un comentario válido.</p>
  	</div>
  </div>
@endif
<br>
  		<!-- // INICIO CZ SPRINT 69 -->
@if ($modo_visualizacion == 'visualizacion')
  <div class="row">
		<div class="col-6 text-left">
			<h6>4. ¿Cuales han sido las soluciones intentadas hasta ahora para enfrentar este problema?¿Por qué creen que esos intentos fracasaron?¿Qué podrían hacer diferente hoy para evitar el fracaso de este nuevo intento?</h6>
		</div>	
		<div class="col-6" style="word-break: break-all;">
			<label id="def_pro_preg_7" class="font-weight-bold"></label>
		</div>	
  </div>
@elseif ($modo_visualizacion == 'edicion')
  <div class="row">
  	<div class="col-6">
  		<h6>4. ¿Cuales han sido las soluciones intentadas hasta ahora para enfrentar este problema?¿Por qué creen que esos intentos fracasaron?¿Qué podrían hacer diferente hoy para evitar el fracaso de este nuevo intento?</h6>
  	</div>
  	<div class="col-6">
  		<textarea maxlength="1000" onkeypress="return caracteres_especiales(event);" class="form-control  input_desabilitar" rows="7" id="def_pro_preg_7" placeholder="Ingrese respuesta" 
  		onkeydown="validarCantidadCaracteresDefinicionProblema(7);" onkeyup="validarCantidadCaracteresDefinicionProblema(7);" @if (config('constantes.gtf_diagnostico')  != $estado_actual_terapia) disabled @endif></textarea>

  		<div class="row">
			<div class="col-6">
				<h6><small class="form-text text-muted">Mínimo 3 y máximo 1000 caracteres.</small></h6>
			</div>
			<div class="col-6">
				<h6><small class="form-text text-muted">N° de caracteres: <strong id="can_def_pro_preg_7" style="color: #000000;">0</strong></small></h6>
			</div>
		</div>

  		<p id="val_def_pro_preg_7" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar un comentario válido.</p>
  	</div>
  </div>
@endif	
<br>
  		<!-- // FIN CZ SPRINT 69 -->
@if($nna_teparia->flag_modelo_terapia == 1)
@if ($modo_visualizacion == 'visualizacion')
  <div class="row">
		<div class="col-6 text-left">
			<h6>4. Circuito del problema: Describa como se relaciona cada integrante del grupo familiar con el problema definido. ¿Quién hace qué? ¿Cuando?</h6>
		</div>	
		<div class="col-6" style="word-break: break-all;">
			<label id="def_pro_preg_5" class="font-weight-bold"></label>
		</div>	
  </div>	
@elseif ($modo_visualizacion == 'edicion')
  <div class="row">
  	<div class="col-6">
  		<h6>4. Circuito del problema: Describa como se relaciona cada integrante del grupo familiar con el problema definido. ¿Quién hace qué? ¿Cuando?</h6>
  	</div>
  	<div class="col-6">
  		<textarea maxlength="1000" onkeypress="return caracteres_especiales(event);" class="form-control  input_desabilitar" rows="7" id="def_pro_preg_5" placeholder="Ingrese respuesta" 
  		onkeydown="validarCantidadCaracteresDefinicionProblema(5);" onkeyup="validarCantidadCaracteresDefinicionProblema(5);" @if (config('constantes.gtf_diagnostico')  != $estado_actual_terapia) disabled @endif></textarea>

  		<div class="row">
			<div class="col-6">
				<h6><small class="form-text text-muted">Mínimo 3 y máximo 1000 caracteres.</small></h6>
			</div>
			<div class="col-6">
				<h6><small class="form-text text-muted">N° de caracteres: <strong id="can_def_pro_preg_5" style="color: #000000;">0</strong></small></h6>
			</div>
		</div>

  		<p id="val_def_pro_preg_5" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar un comentario válido.</p>
  	</div>
  </div>
@endif
<br>

@if ($modo_visualizacion == 'visualizacion')
  <div class="row">
		<div class="col-6 text-left">
			<h6>5. ¿Qué es lo que cada uno espera que cambie a partir del trabajo en TF? Escriba textualmente la expectativa de cambio de cada integrante</h6>
		</div>	
		<div class="col-6" style="word-break: break-all;">
			<label id="def_pro_preg_6" class="font-weight-bold"></label>
		</div>	
  </div>
@elseif ($modo_visualizacion == 'edicion')
  <div class="row">
  	<div class="col-6">
  		<h6>5. ¿Qué es lo que cada uno espera que cambie a partir del trabajo en TF? Escriba textualmente la expectativa de cambio de cada integrante</h6>
  	</div>
  	<div class="col-6">
  		<textarea maxlength="1000" onkeypress="return caracteres_especiales(event);" class="form-control  input_desabilitar" rows="7" id="def_pro_preg_6" placeholder="Ingrese respuesta" 
  		onkeydown="validarCantidadCaracteresDefinicionProblema(6);" onkeyup="validarCantidadCaracteresDefinicionProblema(6);" @if (config('constantes.gtf_diagnostico')  != $estado_actual_terapia) disabled @endif></textarea>

  		<div class="row">
			<div class="col-6">
				<h6><small class="form-text text-muted">Mínimo 3 y máximo 1000 caracteres.</small></h6>
			</div>
			<div class="col-6">
				<h6><small class="form-text text-muted">N° de caracteres: <strong id="can_def_pro_preg_6" style="color: #000000;">0</strong></small></h6>
			</div>
		</div>

  		<p id="val_def_pro_preg_6" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar un comentario válido.</p>
  	</div>
  </div>
@endif
<br>


@if ($modo_visualizacion == 'visualizacion')
  <div class="row">
		<div class="col-6 text-left">
			<h6>6. ¿Cuales han sido las soluciones intentadas hasta ahora para enfrentar este problema?¿Por qué creen que esos intentos fracasaron?¿Qué podrían hacer diferente hoy para evitar el fracaso de este nuevo intento?</h6>
		</div>	
		<div class="col-6" style="word-break: break-all;">
			<label id="def_pro_preg_7" class="font-weight-bold"></label>
		</div>	
  </div>
@elseif ($modo_visualizacion == 'edicion')
  <div class="row">
  	<div class="col-6">
  		<h6>6. ¿Cuales han sido las soluciones intentadas hasta ahora para enfrentar este problema?¿Por qué creen que esos intentos fracasaron?¿Qué podrían hacer diferente hoy para evitar el fracaso de este nuevo intento?</h6>
  	</div>
  	<div class="col-6">
  		<textarea maxlength="1000" onkeypress="return caracteres_especiales(event);" class="form-control  input_desabilitar" rows="7" id="def_pro_preg_7" placeholder="Ingrese respuesta" 
  		onkeydown="validarCantidadCaracteresDefinicionProblema(7);" onkeyup="validarCantidadCaracteresDefinicionProblema(7);" @if (config('constantes.gtf_diagnostico')  != $estado_actual_terapia) disabled @endif></textarea>

  		<div class="row">
			<div class="col-6">
				<h6><small class="form-text text-muted">Mínimo 3 y máximo 1000 caracteres.</small></h6>
			</div>
			<div class="col-6">
				<h6><small class="form-text text-muted">N° de caracteres: <strong id="can_def_pro_preg_7" style="color: #000000;">0</strong></small></h6>
			</div>
		</div>

  		<p id="val_def_pro_preg_7" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar un comentario válido.</p>
  	</div>
  </div>
@endif	
<br>


@if ($modo_visualizacion == 'visualizacion')
  <div class="row">
		<div class="col-6 text-left">
			<h6>7. Otras instituciones o personas interviniendo actualmente en el sistema familiar. Especifique otras instancias de la red social que requieren ser activadas por la OLN.</h6>
		</div>	
		<div class="col-6" style="word-break: break-all;">
			<label id="def_pro_preg_8" class="font-weight-bold"></label>
		</div>	
  </div>
@elseif ($modo_visualizacion == 'edicion')
  <div class="row">
  	<div class="col-6">
  		<h6>7. Otras instituciones o personas interviniendo actualmente en el sistema familiar. Especifique otras instancias de la red social que requieren ser activadas por la OLN.</h6>
  	</div>
  	<div class="col-6">
  		<textarea maxlength="1000" onkeypress="return caracteres_especiales(event);" class="form-control  input_desabilitar" rows="7" id="def_pro_preg_8" placeholder="Ingrese respuesta" 
  		onkeydown="validarCantidadCaracteresDefinicionProblema(8);" onkeyup="validarCantidadCaracteresDefinicionProblema(8);" @if (config('constantes.gtf_diagnostico')  != $estado_actual_terapia) disabled @endif></textarea>

  		<div class="row">
			<div class="col-6">
				<h6><small class="form-text text-muted">Mínimo 3 y máximo 1000 caracteres.</small></h6>
			</div>
			<div class="col-6">
				<h6><small class="form-text text-muted">N° de caracteres: <strong id="can_def_pro_preg_8" style="color: #000000;">0</strong></small></h6>
			</div>
		</div>

  		<p id="val_def_pro_preg_8" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar un comentario válido.</p>
  	</div>
  </div>
@endif
<!-- // INICIO CZ SPRINT 69 -->
@elseif ($nna_teparia->flag_modelo_terapia ==2)


@if ($modo_visualizacion == 'visualizacion')
  <div class="row">
		<div class="col-6 text-left">
			<h6>5. Otras instituciones o personas interviniendo actualmente en el sistema familiar. Especifique otras instancias de la red social que requieren ser activadas por la OLN.</h6>
		</div>	
		<div class="col-6" style="word-break: break-all;">
			<label id="def_pro_preg_8" class="font-weight-bold"></label>
		</div>	
  </div>
@elseif ($modo_visualizacion == 'edicion')
  <div class="row">
  	<div class="col-6">
  		<h6>5. Otras instituciones o personas interviniendo actualmente en el sistema familiar. Especifique otras instancias de la red social que requieren ser activadas por la OLN.</h6>
  	</div>
  	<div class="col-6">
  		<textarea maxlength="1000" onkeypress="return caracteres_especiales(event);" class="form-control  input_desabilitar" rows="7" id="def_pro_preg_8" placeholder="Ingrese respuesta" 
  		onkeydown="validarCantidadCaracteresDefinicionProblema(8);" onkeyup="validarCantidadCaracteresDefinicionProblema(8);" @if (config('constantes.gtf_diagnostico')  != $estado_actual_terapia) disabled @endif></textarea>

  		<div class="row">
			<div class="col-6">
				<h6><small class="form-text text-muted">Mínimo 3 y máximo 1000 caracteres.</small></h6>
			</div>
			<div class="col-6">
				<h6><small class="form-text text-muted">N° de caracteres: <strong id="can_def_pro_preg_8" style="color: #000000;">0</strong></small></h6>
			</div>
		</div>

  		<p id="val_def_pro_preg_8" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar un comentario válido.</p>
  	</div>
  </div>
@endif
@endif	
<!-- // FIN CZ SPRINT 69 -->
</div>
<script type="text/javascript">
  valor_definicion_problema = new Array(); 
  function validarCantidadCaracteresDefinicionProblema(option){
      let num_caracteres_permitidos = 1000;
      let num_caracteres 			= $("#def_pro_preg_"+option).val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#def_pro_preg_"+option).val(valor_definicion_problema[option]);

       }else{ 
          valor_definicion_problema[option] = $("#def_pro_preg_"+option).val();

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#can_def_pro_preg_"+option).css("color", "#ff0000"); 

       }else{ 
          $("#can_def_pro_preg_"+option).css("color", "#000000");

       } 

      
       $("#can_def_pro_preg_"+option).text($("#def_pro_preg_"+option).val().length);
   }

	function validarDefinicionProblemas(){
		let respuesta = true;

		eliminarMensajesErrorDefinicionProblema();

		let pregunta_1 = $("#def_pro_preg_1").val().trim();
		// let pregunta_2 = $("#def_pro_preg_2").val().trim();
		let pregunta_3 = $("#def_pro_preg_3").val().trim();
		let pregunta_4 = $("#def_pro_preg_4").val().trim();
		let pregunta_5 = $("#def_pro_preg_5").val().trim();
		let pregunta_6 = $("#def_pro_preg_6").val().trim();
		let pregunta_7 = $("#def_pro_preg_7").val().trim();
		let pregunta_8 = $("#def_pro_preg_8").val().trim();

		if (pregunta_1 == "" || pregunta_1.length < 3 || typeof pregunta_1 === "undefined"){
			respuesta = false;
			$("#def_pro_preg_1").addClass("is-invalid");
			$("#val_def_pro_preg_1").show();
		}

		// if (pregunta_2 == "" || pregunta_2.length < 3 || typeof pregunta_2 === "undefined"){
		// 	respuesta = false;
		// 	$("#def_pro_preg_2").addClass("is-invalid");
		// 	$("#val_def_pro_preg_2").show();
		// }

		if (pregunta_3 == "" || pregunta_3.length < 3 || typeof pregunta_3 === "undefined"){
			respuesta = false;
			$("#def_pro_preg_3").addClass("is-invalid");
			$("#val_def_pro_preg_3").show();
		}

		if (pregunta_4 == "" || pregunta_4.length < 3 || typeof pregunta_4 === "undefined"){
			respuesta = false;
			$("#def_pro_preg_4").addClass("is-invalid");
			$("#val_def_pro_preg_4").show();
		}

		if (pregunta_5 == "" || pregunta_5.length < 3 || typeof pregunta_5 === "undefined"){
			respuesta = false;
			$("#def_pro_preg_5").addClass("is-invalid");
			$("#val_def_pro_preg_5").show();
		}

		if (pregunta_6 == "" || pregunta_6.length < 3 || typeof pregunta_6 === "undefined"){
			respuesta = false;
			$("#def_pro_preg_6").addClass("is-invalid");
			$("#val_def_pro_preg_6").show();
		}

		if (pregunta_7 == "" || pregunta_7.length < 3 || typeof pregunta_7 === "undefined"){
			respuesta = false;
			$("#def_pro_preg_7").addClass("is-invalid");
			$("#val_def_pro_preg_7").show();
		}

		if (pregunta_8 == "" || pregunta_8.length < 3 || typeof pregunta_8 === "undefined"){
			respuesta = false;
			$("#def_pro_preg_8").addClass("is-invalid");
			$("#val_def_pro_preg_8").show();
		}

		return respuesta;
	}

	function eliminarMensajesErrorDefinicionProblema(){
		$("#def_pro_preg_1").removeClass("is-invalid");
		$("#def_pro_preg_2").removeClass("is-invalid");
		$("#def_pro_preg_3").removeClass("is-invalid");
		$("#def_pro_preg_4").removeClass("is-invalid");
		$("#def_pro_preg_5").removeClass("is-invalid");
		$("#def_pro_preg_6").removeClass("is-invalid");
		$("#def_pro_preg_7").removeClass("is-invalid");
		$("#def_pro_preg_8").removeClass("is-invalid");

		$("#val_def_pro_preg_1").hide();
		$("#val_def_pro_preg_2").hide();
		$("#val_def_pro_preg_3").hide();
		$("#val_def_pro_preg_4").hide();
		$("#val_def_pro_preg_5").hide();
		$("#val_def_pro_preg_6").hide();
		$("#val_def_pro_preg_7").hide();
		$("#val_def_pro_preg_8").hide();
	}

	function limpiarTextAreaDefinicionProblema(){
		$("#def_pro_preg_1").val("");
		$("#def_pro_preg_2").val("");
		$("#def_pro_preg_3").val("");
		$("#def_pro_preg_4").val("");
		$("#def_pro_preg_5").val("");
		$("#def_pro_preg_6").val("");
		$("#def_pro_preg_7").val("");
		$("#def_pro_preg_8").val("");
	}

	function limpiarOnBlurDefinicionProblema(){
		$("#def_pro_preg_1").removeAttr("onBlur");
		$("#def_pro_preg_2").removeAttr("onBlur");
		$("#def_pro_preg_3").removeAttr("onBlur");
		$("#def_pro_preg_4").removeAttr("onBlur");
		$("#def_pro_preg_5").removeAttr("onBlur");
		$("#def_pro_preg_6").removeAttr("onBlur");
		$("#def_pro_preg_7").removeAttr("onBlur");
		$("#def_pro_preg_8").removeAttr("onBlur");
	}

	function rescatarDefinicionProblema(option){
		let pregunta = $("#def_pro_preg_"+option).val();

		return pregunta;
	}

	function buscarDefinicionProblema(tera_id){
		let data = new Object();
		data.tera_id = tera_id;

		limpiarTextAreaDefinicionProblema();
		limpiarOnBlurDefinicionProblema();

		$.ajax({
	      url: "{{ route('buscar.definicion.problema') }}",
	      type: "GET",
	      data: data
	    }).done(function(resp){
	    	if (resp.estado == 1){
	    		if (resp.respuesta.length > 0){
	    			@if ($modo_visualizacion == 'visualizacion')
	    				$("#def_pro_preg_1").text(resp.respuesta[0].def_pro_preg_1);
						$("#def_pro_preg_2").text(resp.respuesta[0].def_pro_preg_2);
						$("#def_pro_preg_3").text(resp.respuesta[0].def_pro_preg_3);
						$("#def_pro_preg_4").text(resp.respuesta[0].def_pro_preg_4);
						$("#def_pro_preg_5").text(resp.respuesta[0].def_pro_preg_5);
						$("#def_pro_preg_6").text(resp.respuesta[0].def_pro_preg_6);
						$("#def_pro_preg_7").text(resp.respuesta[0].def_pro_preg_7);
						$("#def_pro_preg_8").text(resp.respuesta[0].def_pro_preg_8);

	    			@elseif ($modo_visualizacion == 'edicion')	
			    		$("#def_pro_preg_1").attr("onBlur", "guardarDefinicionProblema("+tera_id+", 1,"+resp.respuesta[0].def_pro_id+");");
			    		$("#def_pro_preg_2").attr("onBlur", "guardarDefinicionProblema("+tera_id+", 2,"+resp.respuesta[0].def_pro_id+");");
			    		$("#def_pro_preg_3").attr("onBlur", "guardarDefinicionProblema("+tera_id+", 3,"+resp.respuesta[0].def_pro_id+");");
			    		$("#def_pro_preg_4").attr("onBlur", "guardarDefinicionProblema("+tera_id+", 4,"+resp.respuesta[0].def_pro_id+");");
			    		$("#def_pro_preg_5").attr("onBlur", "guardarDefinicionProblema("+tera_id+", 5,"+resp.respuesta[0].def_pro_id+");");
			    		$("#def_pro_preg_6").attr("onBlur", "guardarDefinicionProblema("+tera_id+", 6,"+resp.respuesta[0].def_pro_id+");");
			    		$("#def_pro_preg_7").attr("onBlur", "guardarDefinicionProblema("+tera_id+", 7,"+resp.respuesta[0].def_pro_id+");");
			    		$("#def_pro_preg_8").attr("onBlur", "guardarDefinicionProblema("+tera_id+", 8,"+resp.respuesta[0].def_pro_id+");");

			    		$("#def_pro_preg_1").val(resp.respuesta[0].def_pro_preg_1);
						$("#def_pro_preg_2").val(resp.respuesta[0].def_pro_preg_2);
						$("#def_pro_preg_3").val(resp.respuesta[0].def_pro_preg_3);
						$("#def_pro_preg_4").val(resp.respuesta[0].def_pro_preg_4);
						$("#def_pro_preg_5").val(resp.respuesta[0].def_pro_preg_5);
						$("#def_pro_preg_6").val(resp.respuesta[0].def_pro_preg_6);
						$("#def_pro_preg_7").val(resp.respuesta[0].def_pro_preg_7);
						$("#def_pro_preg_8").val(resp.respuesta[0].def_pro_preg_8);
					@endif
						
				}else if (resp.respuesta.length == 0){
					@if ($modo_visualizacion == 'edicion')
						$("#def_pro_preg_1").attr("onBlur", "guardarDefinicionProblema("+tera_id+", 1, null);");
			    		$("#def_pro_preg_2").attr("onBlur", "guardarDefinicionProblema("+tera_id+", 2, null);");
			    		$("#def_pro_preg_3").attr("onBlur", "guardarDefinicionProblema("+tera_id+", 3, null);");
			    		$("#def_pro_preg_4").attr("onBlur", "guardarDefinicionProblema("+tera_id+", 4, null);");
			    		$("#def_pro_preg_5").attr("onBlur", "guardarDefinicionProblema("+tera_id+", 5, null);");
			    		$("#def_pro_preg_6").attr("onBlur", "guardarDefinicionProblema("+tera_id+", 6, null);");
			    		$("#def_pro_preg_7").attr("onBlur", "guardarDefinicionProblema("+tera_id+", 7, null);");
			    		$("#def_pro_preg_8").attr("onBlur", "guardarDefinicionProblema("+tera_id+", 8, null);");
		    		@endif

				}
	    	}else if (resp.estado == 0){
	    		let mensaje = "Error al momento de buscar información sobre la definición del problema. Por favor intente nuevamente.";

	    		console.log(resp.mensaje);
	    		alert(mensaje);
	    	}
	    }).fail(function(obj){
	    	let mensaje = "Error al momento de buscar información sobre la definición del problema. Por favor intente nuevamente.";

	       	console.log(obj);
	       	alert(mensaje);
	    });
	}

	function guardarDefinicionProblema(tera_id, option, def_pro_id = null){
		let valor = rescatarDefinicionProblema(option);

		eliminarMensajesErrorDefinicionProblema();
		if (valor == "" || valor.length < 3 || typeof valor === "undefined"){
			mensajeTemporalRespuestas(0, "Respuesta entregada no válida. Por verifique e ingrese nuevamente.");

			$("#def_pro_preg_"+option).addClass("is-invalid");
			$("#val_def_pro_preg_"+option).show();
			return false;
		}

		bloquearPantalla();

		let data 		= new Object();
		data.option  	= option;
		data.tera_id 	= tera_id;
		data.def_pro_id = def_pro_id;
		data.valor 	 	= valor;

		$.ajaxSetup({
			headers: {
			    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
	      url: "{{ route('guardar.definicion.problema') }}",
	      type: "POST",
	      data: data
	    }).done(function(resp){
	    	desbloquearPantalla();

	    	if (resp.estado == 1){
	    		mensajeTemporalRespuestas(1, resp.mensaje);

	    		limpiarOnBlurDefinicionProblema();

	    		$("#def_pro_preg_1").attr("onBlur", "guardarDefinicionProblema("+tera_id+", 1,"+resp.respuesta+");");
	    		$("#def_pro_preg_2").attr("onBlur", "guardarDefinicionProblema("+tera_id+", 2,"+resp.respuesta+");");
	    		$("#def_pro_preg_3").attr("onBlur", "guardarDefinicionProblema("+tera_id+", 3,"+resp.respuesta+");");
	    		$("#def_pro_preg_4").attr("onBlur", "guardarDefinicionProblema("+tera_id+", 4,"+resp.respuesta+");");
	    		$("#def_pro_preg_5").attr("onBlur", "guardarDefinicionProblema("+tera_id+", 5,"+resp.respuesta+");");
	    		$("#def_pro_preg_6").attr("onBlur", "guardarDefinicionProblema("+tera_id+", 6,"+resp.respuesta+");");
	    		$("#def_pro_preg_7").attr("onBlur", "guardarDefinicionProblema("+tera_id+", 7,"+resp.respuesta+");");
	    		$("#def_pro_preg_8").attr("onBlur", "guardarDefinicionProblema("+tera_id+", 8,"+resp.respuesta+");");
				// INICIO CZ SPRINT 57
				$("#inputHiddendef_pro_preg_1").val($("#def_pro_preg_1").val());
				$("#boton-EvaluacionTF").css("display", "initial");
				$("#boton-validación").css("display", "none");
				//FIN CZ SPRINT 57
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