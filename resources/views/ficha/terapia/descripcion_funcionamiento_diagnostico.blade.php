<div class="container">
	@if ($modo_visualizacion == 'visualizacion')
		<div class="row">
			<div class="col-6 text-left">
				<!-- // INICIO CZ SPRINT 69 -->
				@if($nna_teparia->flag_modelo_terapia == 1)
				<h6>1. Genograma. Detectar personas de la familia extensa, amigos o vecinos significativos para la familia (Subir Documento).</h6>
				@elseif ($nna_teparia->flag_modelo_terapia == 2)
				<h6>1. Genograma. Detectar personas de la familia extensa, amigos o vecinos significativos para la familia, considerando 3 generaciones. Graficar relaciones entre los/as integrantes (Subir Documento).</h6>
				@endif
<!-- // FIN CZ SPRINT 69 -->
			</div>	
			<div class="col-6 text-center">
				<h6>Descargue el Genograma subido para el caso <br>en el siguiente enlace: <a id="ruta_descarga_genograma"><b>Sin información.</b></a></h6>
			</div>	
		</div>
			
	@elseif ($modo_visualizacion == 'edicion')
		<div class="row">
			<div class="col-6">
				<!-- // INICIO CZ SPRINT 69 -->
				@if($nna_teparia->flag_modelo_terapia == 1)
				<h6>1. Genograma. Detectar personas de la familia extensa, amigos o vecinos significativos para la familia (Subir Documento).</h6>
				@elseif ($nna_teparia->flag_modelo_terapia == 2)
				<h6>1. Genograma. Detectar personas de la familia extensa, amigos o vecinos significativos para la familia, considerando 3 generaciones. Graficar relaciones entre los/as integrantes (Subir Documento).</h6>
				@endif		
				<!-- // FIN CZ SPRINT 69 -->
			</div>
			<div class="col-6">
				<div class="row">
					<div class="alert alert-success alert-dismissible fade show" id="genograma_exitoso" role="alert" style="display: none;">Documento Guardado Exitosamente.
					 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					 </button>
					</div>

					<div class="alert alert-danger alert-dismissible fade show" id="genograma_error" role="alert" style="display: none;">Error al momento de guardar el documento. Por favor intente nuevamente.
					 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					 </button>
					</div>

					<div class="alert alert-danger alert-dismissible fade show" id="genograma_formato" role="alert" style="display: none;">EL formato del documento no es permitido. Sólo subir documentos con las siguientes extensiones: ".pdf", ".jpg" y ".png"
					 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					 </button>
					</div>

					<div class="input-group mb-3">
					  <form enctype="multipart/form-data" id="enviar_genograma" name="enviar_genograma" method="post">	
					  	  {{ csrf_field() }}						  	
						  <div class="custom-file" style="z-index:0;">
						    <input type="file" class="custom-file-input input_desabilitar" name="file_genograma" id="file_genograma" @if (config('constantes.gtf_diagnostico')  != $estado_actual_terapia) disabled @endif>
						    <input type="hidden" id="des_tera_id" name="des_tera_id" value="{{ $nna_teparia->tera_id }}">
						    <input type="hidden" id="des_fun_id" name="des_fun_id" value="">
						    <label class="custom-file-label" for="file_genograma" aria-describedby="file_genograma_descargar">Cargar archivo</label>
						  </div>
					  </form>


					  <div class="input-group-append" id="cont_file_genograma_descargar" style="display: none;">
					    <span class="input-group-text" id="file_genograma_descargar"><a id="ruta_descarga_genograma" href="#" target="_blank"><img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjUxMnB4IiBoZWlnaHQ9IjUxMnB4IiB2aWV3Qm94PSIwIDAgNDc1LjA3OCA0NzUuMDc3IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA0NzUuMDc4IDQ3NS4wNzc7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4KPGc+Cgk8Zz4KCQk8cGF0aCBkPSJNNDY3LjA4MywzMTguNjI3Yy01LjMyNC01LjMyOC0xMS44LTcuOTk0LTE5LjQxLTcuOTk0SDMxNS4xOTVsLTM4LjgyOCwzOC44MjdjLTExLjA0LDEwLjY1Ny0yMy45ODIsMTUuOTg4LTM4LjgyOCwxNS45ODggICAgYy0xNC44NDMsMC0yNy43ODktNS4zMjQtMzguODI4LTE1Ljk4OGwtMzguNTQzLTM4LjgyN0gyNy40MDhjLTcuNjEyLDAtMTQuMDgzLDIuNjY5LTE5LjQxNCw3Ljk5NCAgICBDMi42NjQsMzIzLjk1NSwwLDMzMC40MjcsMCwzMzguMDQ0djkxLjM1OGMwLDcuNjE0LDIuNjY0LDE0LjA4NSw3Ljk5NCwxOS40MTRjNS4zMyw1LjMyOCwxMS44MDEsNy45OSwxOS40MTQsNy45OWg0MjAuMjY2ICAgIGM3LjYxLDAsMTQuMDg2LTIuNjYyLDE5LjQxLTcuOTljNS4zMzItNS4zMjksNy45OTQtMTEuOCw3Ljk5NC0xOS40MTR2LTkxLjM1OEM0NzUuMDc4LDMzMC40MjcsNDcyLjQxNiwzMjMuOTU1LDQ2Ny4wODMsMzE4LjYyN3ogICAgIE0zNjAuMDI1LDQxNC44NDFjLTMuNjIxLDMuNjE3LTcuOTA1LDUuNDI0LTEyLjg1NCw1LjQyNHMtOS4yMjctMS44MDctMTIuODQ3LTUuNDI0Yy0zLjYxNC0zLjYxNy01LjQyMS03Ljg5OC01LjQyMS0xMi44NDQgICAgYzAtNC45NDgsMS44MDctOS4yMzYsNS40MjEtMTIuODQ3YzMuNjItMy42Miw3Ljg5OC01LjQzMSwxMi44NDctNS40MzFzOS4yMzIsMS44MTEsMTIuODU0LDUuNDMxICAgIGMzLjYxMywzLjYxLDUuNDIxLDcuODk4LDUuNDIxLDEyLjg0N0MzNjUuNDQ2LDQwNi45NDIsMzYzLjYzOCw0MTEuMjI0LDM2MC4wMjUsNDE0Ljg0MXogTTQzMy4xMDksNDE0Ljg0MSAgICBjLTMuNjE0LDMuNjE3LTcuODk4LDUuNDI0LTEyLjg0OCw1LjQyNGMtNC45NDgsMC05LjIyOS0xLjgwNy0xMi44NDctNS40MjRjLTMuNjEzLTMuNjE3LTUuNDItNy44OTgtNS40Mi0xMi44NDQgICAgYzAtNC45NDgsMS44MDctOS4yMzYsNS40Mi0xMi44NDdjMy42MTctMy42Miw3Ljg5OC01LjQzMSwxMi44NDctNS40MzFjNC45NDksMCw5LjIzMywxLjgxMSwxMi44NDgsNS40MzEgICAgYzMuNjE3LDMuNjEsNS40MjcsNy44OTgsNS40MjcsMTIuODQ3QzQzOC41MzYsNDA2Ljk0Miw0MzYuNzI5LDQxMS4yMjQsNDMzLjEwOSw0MTQuODQxeiIgZmlsbD0iIzAwMDAwMCIvPgoJCTxwYXRoIGQ9Ik0yMjQuNjkyLDMyMy40NzljMy40MjgsMy42MTMsNy43MSw1LjQyMSwxMi44NDcsNS40MjFjNS4xNDEsMCw5LjQxOC0xLjgwOCwxMi44NDctNS40MjFsMTI3LjkwNy0xMjcuOTA4ICAgIGM1Ljg5OS01LjUxOSw3LjIzNC0xMi4xODIsMy45OTctMTkuOTg2Yy0zLjIzLTcuNDIxLTguODQ3LTExLjEzMi0xNi44NDQtMTEuMTM2aC03My4wOTFWMzYuNTQzYzAtNC45NDgtMS44MTEtOS4yMzEtNS40MjEtMTIuODQ3ICAgIGMtMy42Mi0zLjYxNy03LjkwMS01LjQyNi0xMi44NDctNS40MjZoLTczLjA5NmMtNC45NDYsMC05LjIyOSwxLjgwOS0xMi44NDcsNS40MjZjLTMuNjE1LDMuNjE2LTUuNDI0LDcuODk4LTUuNDI0LDEyLjg0N1YxNjQuNDUgICAgaC03My4wODljLTcuOTk4LDAtMTMuNjEsMy43MTUtMTYuODQ2LDExLjEzNmMtMy4yMzQsNy44MDEtMS45MDMsMTQuNDY3LDMuOTk5LDE5Ljk4NkwyMjQuNjkyLDMyMy40Nzl6IiBmaWxsPSIjMDAwMDAwIi8+Cgk8L2c+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==" height="20px"/></a></span>
					  </div>
					</div>
					<div style="margin-top: -15px; margin-left: 2px;">
						<small>Sólo subir archivos con las siguientes extensiones: ".pdf", ".jpg" y ".png".</small>
						<br>
						<small>Tamaño maximo permitido 3.40 MB.</small>
					</div><br>
				</div>
			</div>
		</div>
	@endif
	<br>

	@if ($modo_visualizacion == 'visualizacion')
		<div class="row">
			<div class="col-6 text-left">
				<h6>2. Descripción de la organización familiar: subsistemas, límites, jerarquías, alianzas, roles, otros relevantes.</h6>
			</div>	
			<div class="col-6" style="word-break: break-all;">
				<label id="des_fun_preg_2" class="font-weight-bold"></label>
			</div>	
		</div>

	@elseif ($modo_visualizacion == 'edicion')	
		<div class="row">
			<div class="col-6">
				<h6>2. Descripción de la organización familiar: subsistemas, límites, jerarquías, alianzas, roles, otros relevantes.</h6>
			</div>
			<div class="col-6">
				<textarea maxlength="1000" onkeypress="return caracteres_especiales(event);" class="form-control  input_desabilitar" rows="7" id="des_fun_preg_2" onBlur="" placeholder="Ingrese respuesta" 
				onkeydown="validarCantidadCaracteresDescripcionFuncionamiento(2);" onkeyup="validarCantidadCaracteresDescripcionFuncionamiento(2);" @if (config('constantes.gtf_diagnostico')  != $estado_actual_terapia) disabled @endif></textarea>

				<div class="row">
					<div class="col-6">
						<h6><small class="form-text text-muted">Mínimo 3 y máximo 1000 caracteres.</small></h6>
					</div>
					<div class="col-6">
						<h6><small class="form-text text-muted">N° de caracteres: <strong id="can_des_fun_preg_2" style="color: #000000;">0</strong></small></h6>
					</div>
				</div>

				<p id="val_des_fun_preg_2" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar un comentario válido.</p>
			</div>
		</div>
	@endif
	<br>

	@if ($modo_visualizacion == 'visualizacion')
		<div class="row">
			<div class="col-6 text-left">
				<!-- // INICIO CZ SPRINT 69 -->
			@if($nna_teparia->flag_modelo_terapia == 1)
				<h6>3. ¿Qué recursos de la familia pueden ser usados para hacer frente al problema definido?. ¿cómo describe la familia sus propios recursos?</h6>
			@elseif($nna_teparia->flag_modelo_terapia == 2)
			<h6>3. ¿Qué recursos de la familia pueden ser usados para hacer frente a las dimensiones NCFAS-G identificadas en el Diagnóstico Integral?. ¿Cómo describe la familia sus propios recursos?</h6>
			@endif
			<!-- // FIN CZ SPRINT 69 -->
			</div>	
			<div class="col-6" style="word-break: break-all;">
				<label id="des_fun_preg_3" class="font-weight-bold"></label>
			</div>	
		</div>
	@elseif ($modo_visualizacion == 'edicion')
		<div class="row">
			<div class="col-6">
				<!-- // INICIO CZ SPRINT 69 -->
			@if($nna_teparia->flag_modelo_terapia == 1)
				<h6>3. ¿Qué recursos de la familia pueden ser usados para hacer frente al problema definido?. ¿cómo describe la familia sus propios recursos?</h6>
			@elseif($nna_teparia->flag_modelo_terapia == 2)
			<h6>3. ¿Qué recursos de la familia pueden ser usados para hacer frente a las dimensiones NCFAS-G identificadas en el Diagnóstico Integral?. ¿Cómo describe la familia sus propios recursos?</h6>
			@endif
			<!-- // FIN CZ SPRINT 69 -->
			</div>
			<div class="col-6">
				<textarea maxlength="1000" onkeypress="return caracteres_especiales(event);" class="form-control  input_desabilitar" rows="7" id="des_fun_preg_3" onBlur="" placeholder="Ingrese respuesta" 
				onkeydown="validarCantidadCaracteresDescripcionFuncionamiento(3);" onkeyup="validarCantidadCaracteresDescripcionFuncionamiento(3);" @if (config('constantes.gtf_diagnostico')  != $estado_actual_terapia) disabled @endif></textarea>

				<div class="row">
					<div class="col-6">
						<h6><small class="form-text text-muted">Mínimo 3 y máximo 1000 caracteres.</small></h6>
					</div>
					<div class="col-6">
						<h6><small class="form-text text-muted">N° de caracteres: <strong id="can_des_fun_preg_3" style="color: #000000;">0</strong></small></h6>
					</div>
				</div>

				<p id="val_des_fun_preg_3" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar un comentario válido.</p>
			</div>
		</div>
	@endif
	<br>

	@if ($modo_visualizacion == 'visualizacion')
		<div class="row">
			<div class="col-6 text-left">
				<h6>4. Qué factores de riesgo se visibilizan a nivel individual, familiar, el contexto, la red.</h6>
			</div>	
			<div class="col-6" style="word-break: break-all;">
				<label id="des_fun_preg_4" class="font-weight-bold"></label>
			</div>	
		</div>
	@elseif ($modo_visualizacion == 'edicion')
		<div class="row">
			<div class="col-6">
				<h6>4. Qué factores de riesgo se visibilizan a nivel individual, familiar, el contexto, la red.</h6>
			</div>
			<div class="col-6">
				<textarea maxlength="1000" onkeypress="return caracteres_especiales(event);" class="form-control  input_desabilitar" rows="7" id="des_fun_preg_4" onBlur="" placeholder="Ingrese respuesta" 
				onkeydown="validarCantidadCaracteresDescripcionFuncionamiento(4);" onkeyup="validarCantidadCaracteresDescripcionFuncionamiento(4);" @if (config('constantes.gtf_diagnostico')  != $estado_actual_terapia) disabled @endif></textarea>

				<div class="row">
					<div class="col-6">
						<h6><small class="form-text text-muted">Mínimo 3 y máximo 1000 caracteres.</small></h6>
					</div>
					<div class="col-6">
						<h6><small class="form-text text-muted">N° de caracteres: <strong id="can_des_fun_preg_4" style="color: #000000;">0</strong></small></h6>
					</div>
				</div>

				<p id="val_des_fun_preg_4" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar un comentario válido.</p>
			</div>
		</div>
	@endif
	<br>


	@if ($modo_visualizacion == 'visualizacion')
		<div class="row">
			<div class="col-6 text-left">
				<!-- // INICIO CZ SPRINT 69 -->
				@if($nna_teparia->flag_modelo_terapia == 1)
				<h6>5. De acuerdo a todos estos antecedentes ¿Cómo describiría la situación contextual relacional de la familia? incluyendo el lugar que pueden ocupar los recursos para la intervención.</h6>
				@elseif ($nna_teparia->flag_modelo_terapia == 2)
				<h6>5. De acuerdo a todos estos antecedentes, realice una síntesis que permita la comprensión de la situación contextual relacional actual de la familia. Incluyendo el lugar que pueden ocupar los recursos para la intervención.</h6>
				@endif
				<!-- // FIN CZ SPRINT 69 -->
			</div>	
			<div class="col-6" style="word-break: break-all;">
				<label id="des_fun_preg_5" class="font-weight-bold"></label>
			</div>	
		</div>
	@elseif ($modo_visualizacion == 'edicion')
		<div class="row">
			<div class="col-6">
				<!-- // INICIO CZ SPRINT 69 -->
				@if($nna_teparia->flag_modelo_terapia == 1)
				<h6>5. De acuerdo a todos estos antecedentes ¿Cómo describiría la situación contextual relacional de la familia? incluyendo el lugar que pueden ocupar los recursos para la intervención.</h6>
				@elseif ($nna_teparia->flag_modelo_terapia == 2)
				<h6>5. De acuerdo a todos estos antecedentes, realice una síntesis que permita la comprensión de la situación contextual relacional actual de la familia. Incluyendo el lugar que pueden ocupar los recursos para la intervención.</h6>
				@endif
				<!-- // FIN CZ SPRINT 69 -->			</div>
			<div class="col-6">
				<textarea maxlength="1000" onkeypress="return caracteres_especiales(event);" class="form-control  input_desabilitar" rows="7" id="des_fun_preg_5" onBlur="" placeholder="Ingrese respuesta" 
				onkeydown="validarCantidadCaracteresDescripcionFuncionamiento(5);" onkeyup="validarCantidadCaracteresDescripcionFuncionamiento(5);" @if (config('constantes.gtf_diagnostico')  != $estado_actual_terapia) disabled @endif></textarea>

				<div class="row">
					<div class="col-6">
						<h6><small class="form-text text-muted">Mínimo 3 y máximo 1000 caracteres.</small></h6>
					</div>
					<div class="col-6">
						<h6><small class="form-text text-muted">N° de caracteres: <strong id="can_des_fun_preg_5" style="color: #000000;">0</strong></small></h6>
					</div>
				</div>

				<p id="val_des_fun_preg_5" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar un comentario válido.</p>
			</div>
		</div>
	@endif
</div>
<script type="text/javascript">
	$("#file_genograma").change(function(e){
	  $('#enviar_genograma').submit();
	});

   	$("#enviar_genograma").submit(function(e){

   		bloquearPantalla();

   	  	e.preventDefault();

   	  	let form = document.getElementById('enviar_genograma');
		let formData = new FormData(form);

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			}
		});

		$.ajax({
	      type: 'post',
	      url: "{{ route('guardar.documento.genograma') }}",
	      data: formData,
	      cache: false,
	      contentType: false,
	      processData: false,
	      success:function(resp){

	      		desbloquearPantalla();

		    if (resp.estado == 1){
		  		$("#genograma_error").hide();
		  		$("#genograma_formato").hide();

		  		let tera_id = $("#des_tera_id").val();
		  		let nombre_archivo = resp.nombre_archivo;
				//   INICIO CZ SPRINT 66
		  		let ruta = "../../doc/"+nombre_archivo;
				//   FIN CZ SPRINT 66
		  		$("#ruta_descarga_genograma").attr("href", ruta);
		  		$("#des_fun_id").val(resp.respuesta);

		  		$("#cont_file_genograma_descargar").show();

		        $("#genograma_exitoso").show();
		        setTimeout(function(){ $("#genograma_exitoso").hide(); }, 5000);

		        limpiarOnBlurDescripcionFuncionamiento();

		        $("#des_fun_preg_2").attr("onBlur", "guardarDescripcionFuncionamiento("+tera_id+", 2,"+resp.respuesta+");");
	    		$("#des_fun_preg_3").attr("onBlur", "guardarDescripcionFuncionamiento("+tera_id+", 3,"+resp.respuesta+");");
	    		$("#des_fun_preg_4").attr("onBlur", "guardarDescripcionFuncionamiento("+tera_id+", 4,"+resp.respuesta+");");
	    		$("#des_fun_preg_5").attr("onBlur", "guardarDescripcionFuncionamiento("+tera_id+", 5,"+resp.respuesta+");");

				//$("#valida_doc").val(1);
				//location.reload();

			}else if (resp.estado == 0){
				$("#genograma_exitoso").hide();
				$("#genograma_formato").hide();

                $("#genograma_error").show();
				setTimeout(function(){ $("#genograma_error").hide(); }, 5000);
			}
	      },
	      error: function(jqXHR, text, error){

	      		desbloquearPantalla();
	      	
	      	$("#genograma_exitoso").hide();
	      	$("#genograma_error").hide();

	     	$("#genograma_formato").show();
			setTimeout(function(){ $("#genograma_formato").hide(); }, 5000);

	      	console.log(jqXHR, text, error);
		          // toastr.error('Validation error!', 'No se pudo Añadir los datos<br>' + error, {timeOut: 5000});
	      }
		  });
   	  });

	valor_descripcion_funcionamiento = new Array();
	function validarCantidadCaracteresDescripcionFuncionamiento(option){
		let num_caracteres_permitidos = 1000;
      	let num_caracteres 			= $("#des_fun_preg_"+option).val().length;

      	if (num_caracteres > num_caracteres_permitidos){ 
            $("#des_fun_preg_"+option).val(valor_descripcion_funcionamiento[option]);

        }else{ 
          	valor_descripcion_funcionamiento[option] = $("#des_fun_preg_"+option).val();

        }

        if (num_caracteres >= num_caracteres_permitidos){ 
          $("#can_des_fun_preg_"+option).css("color", "#ff0000"); 

       	}else{ 
          $("#can_des_fun_preg_"+option).css("color", "#000000");

       	}

       	$("#can_des_fun_preg_"+option).text($("#des_fun_preg_"+option).val().length);
	}

	function validarDescripcionFuncionamiento(){
		let respuesta = true;

		eliminarMensajesErrorDescripcionFuncionamiento();

		let pregunta_2 = $("#des_fun_preg_2").val().trim();
		let pregunta_3 = $("#des_fun_preg_3").val().trim();
		let pregunta_4 = $("#des_fun_preg_4").val().trim();
		let pregunta_5 = $("#des_fun_preg_5").val().trim();

		if (pregunta_2 == "" || pregunta_2.length < 3 || typeof pregunta_2 === "undefined"){
			respuesta = false;
			$("#des_fun_preg_2").addClass("is-invalid");
			$("#val_des_fun_preg_2").show();
		}

		if (pregunta_3 == "" || pregunta_3.length < 3 || typeof pregunta_3 === "undefined"){
			respuesta = false;
			$("#des_fun_preg_3").addClass("is-invalid");
			$("#val_des_fun_preg_3").show();
		}

		if (pregunta_4 == "" || pregunta_4.length < 3 || typeof pregunta_4 === "undefined"){
			respuesta = false;
			$("#des_fun_preg_4").addClass("is-invalid");
			$("#val_des_fun_preg_4").show();
		}

		if (pregunta_5 == "" || pregunta_5.length < 3 || typeof pregunta_5 === "undefined"){
			respuesta = false;
			$("#des_fun_preg_5").addClass("is-invalid");
			$("#val_des_fun_preg_5").show();
		}

		return respuesta;
	}

	function eliminarMensajesErrorDescripcionFuncionamiento(){
		$("#des_fun_preg_2").removeClass("is-invalid");
		$("#des_fun_preg_3").removeClass("is-invalid");
		$("#des_fun_preg_4").removeClass("is-invalid");
		$("#des_fun_preg_5").removeClass("is-invalid");

		$("#val_des_fun_preg_2").hide();
		$("#val_des_fun_preg_3").hide();
		$("#val_des_fun_preg_4").hide();
		$("#val_des_fun_preg_5").hide();
	}

	function limpiarOnBlurDescripcionFuncionamiento(){
		$("#des_fun_preg_2").removeAttr("onBlur");
		$("#des_fun_preg_3").removeAttr("onBlur");
		$("#des_fun_preg_4").removeAttr("onBlur");
		$("#des_fun_preg_5").removeAttr("onBlur");
	}

	function buscarDescripcionFuncionamiento(tera_id){
		let data = new Object();

		data.tera_id = tera_id;

		$.ajax({
	      url: "{{ route('buscar.descripcion.funcionamiento') }}",
	      type: "GET",
	      data: data
	    }).done(function(resp){
	        if (resp.estado == 1){
	        	if (resp.respuesta.length > 0){
	        		@if ($modo_visualizacion == 'edicion')	
		        		$("#des_fun_preg_2").attr("onBlur", "guardarDescripcionFuncionamiento("+tera_id+", 2, "+resp.respuesta[0].des_fun_id+");");
		        		$("#des_fun_preg_3").attr("onBlur", "guardarDescripcionFuncionamiento("+tera_id+", 3, "+resp.respuesta[0].des_fun_id+");");
		        		$("#des_fun_preg_4").attr("onBlur", "guardarDescripcionFuncionamiento("+tera_id+", 4, "+resp.respuesta[0].des_fun_id+");");
		        		$("#des_fun_preg_5").attr("onBlur", "guardarDescripcionFuncionamiento("+tera_id+", 5, "+resp.respuesta[0].des_fun_id+");");
						
		        		if (resp.respuesta[0].des_fun_geno != "" && resp.respuesta[0].des_fun_geno != undefined){
			        		let nombre_archivo = resp.respuesta[0].des_fun_geno;
							// INICIO CZ SPRINT 66
				  			let ruta = "../../doc/"+nombre_archivo;
							//   FIN CZ SPRINT 66
			        		$("#ruta_descarga_genograma").attr("href", ruta);
			        		$("#cont_file_genograma_descargar").show();
						}
						
						$("#des_fun_id").val(resp.respuesta[0].des_fun_id);
		        		$("#des_fun_preg_2").val(resp.respuesta[0].des_fun_preg_2);
		        		$("#des_fun_preg_3").val(resp.respuesta[0].des_fun_preg_3);
		        		$("#des_fun_preg_4").val(resp.respuesta[0].des_fun_preg_4);
		        		$("#des_fun_preg_5").val(resp.respuesta[0].des_fun_preg_5);

		        	@elseif ($modo_visualizacion == 'visualizacion')
		        		if (resp.respuesta[0].des_fun_geno != "" && resp.respuesta[0].des_fun_geno != undefined){
			        		let nombre_archivo = resp.respuesta[0].des_fun_geno;
							// INICIO CZ SPRINT 66 
				  			let ruta = "../../doc/"+nombre_archivo;
							//   FIN CZ SPRINT 66
			        		$("#ruta_descarga_genograma").attr("href", ruta);

			        		$("#ruta_descarga_genograma").text("Click aquí.");
		        		}

		        		$("#des_fun_preg_2").text(resp.respuesta[0].des_fun_preg_2);
		        		$("#des_fun_preg_3").text(resp.respuesta[0].des_fun_preg_3);
		        		$("#des_fun_preg_4").text(resp.respuesta[0].des_fun_preg_4);
		        		$("#des_fun_preg_5").text(resp.respuesta[0].des_fun_preg_5);

		        	@endif

	        	}else if (resp.respuesta.length == 0){
	        		@if ($modo_visualizacion == 'edicion')	
		        		$("#des_fun_preg_2").attr("onBlur", "guardarDescripcionFuncionamiento("+tera_id+", 2, null);");
		        		$("#des_fun_preg_3").attr("onBlur", "guardarDescripcionFuncionamiento("+tera_id+", 3, null);");
		        		$("#des_fun_preg_4").attr("onBlur", "guardarDescripcionFuncionamiento("+tera_id+", 4, null);");
		        		$("#des_fun_preg_5").attr("onBlur", "guardarDescripcionFuncionamiento("+tera_id+", 5, null);");

		        		$("#ruta_descarga_genograma").attr("href", "#");
		        		$("#des_fun_id").val("");

		        		$("#cont_file_genograma_descargar").hide();
	        		@endif
	        		
	        	}
	        }else if (resp.estado == 0){
	        	let mensaje = "Error al momento de buscar información sobre la descripción del funcionamiento y la organización familiar. Por favor intente nuevamente.";

	        	console.log(resp);
	        	alert(mensaje);
	        }
	    }).fail(function(obj){
	    	let mensaje = "Error al momento de buscar información sobre la descripción del funcionamiento y la organización familiar. Por favor intente nuevamente.";

        	console.log(obj);
        	alert(mensaje);
	    });
	}

	function rescatarDescripcionFuncionamiento(option){
		let pregunta = $("#des_fun_preg_"+option).val();

		return pregunta;
	}

	function guardarDescripcionFuncionamiento(tera_id, option, des_fun_id = null){

		let valor = rescatarDescripcionFuncionamiento(option);
		eliminarMensajesErrorDescripcionFuncionamiento();

		if (valor == "" || valor.length < 3 || typeof valor === "undefined"){
			mensajeTemporalRespuestas(0, "Respuesta entregada no válida. Por verifique e ingrese nuevamente.");

			$("#des_fun_preg_"+option).addClass("is-invalid");
			$("#val_des_fun_preg_"+option).show();
			return false;
		}

		bloquearPantalla();

		let data = new Object();
		data.tera_id 	= tera_id;
		data.option 	= option;
		data.des_fun_id = des_fun_id;
		data.valor      = valor;

		$.ajaxSetup({
			headers: {
			    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
	      url: "{{ route('guardar.descripcion.funcionamiento') }}",
	      type: "POST",
	      data: data
	    }).done(function(resp){
	    	desbloquearPantalla();

	    	if (resp.estado == 1){
	    		mensajeTemporalRespuestas(1, resp.mensaje);

	    		limpiarOnBlurDescripcionFuncionamiento();

	    		$("#des_fun_preg_2").attr("onBlur", "guardarDescripcionFuncionamiento("+tera_id+", 2,"+resp.respuesta+");");
	    		$("#des_fun_preg_3").attr("onBlur", "guardarDescripcionFuncionamiento("+tera_id+", 3,"+resp.respuesta+");");
	    		$("#des_fun_preg_4").attr("onBlur", "guardarDescripcionFuncionamiento("+tera_id+", 4,"+resp.respuesta+");");
	    		$("#des_fun_preg_5").attr("onBlur", "guardarDescripcionFuncionamiento("+tera_id+", 5,"+resp.respuesta+");");

	    		$("#des_fun_id").val(resp.respuesta);
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