<div id="modal_descarte_revertir_nna" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content p-4">
			<div class="modal-header">
				<div style="margin: 0 auto;"><h5 id="titulo_modal_descartados"></h5></div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute; margin: 0; top: 5px; right: 33px;">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<input type="hidden" id="token_formulario_descartar" value="{{ csrf_token() }}">

			<div class="modal-body">
				<div class="container">
				
					<div class="row">
						<div class="col-3" style="font-weight: 800;">
							<label>Nombre NNA:</label>
						</div>
						<div class="col-9">
							<label id="nombre_descarte_revertir_nna"></label>
						</div>
					</div>

					<div class="row">
						<div class="col-3" style="font-weight: 800;">
							<label>RUN:</label>
						</div>
						<div class="col-9">
							<label id="run_descarte_revertir_nna"></label>
						</div>
					</div>

					<div class="row">
						<div class="col-3" style="font-weight: 800;">
							<label>Fecha:</label>
						</div>
						<div class="col-9">
							<label>{{ date("d/m/Y") }}</label>
						</div>
					</div><br>

					<div class="row">
						<div class="col-12" style="font-weight: 800;">
							<label>Comentario:</label>
						</div>
						<div class="col-12">
							<textarea maxlength="2000" onkeypress='return caracteres_especiales(event)' class="form-control" name="comentario_descarte_revertir_nna" id="comentario_descarte_revertir_nna" rows="3" onKeyUp="cantidadCaracteresCajaDescartarRevertirNNA();" onKeyDown="cantidadCaracteresCajaDescartarRevertirNNA();" onFocus="cantidadCaracteresCajaDescartarRevertirNNA();"></textarea>
						</div>

						<div class="col-md-12 col-lg-6">
							<h6><small class"form-text text-muted">Mínimo 3 y máximo 2000 caracteres.</small></h6>
						</div>
						<div class="col-md-12 col-lg-6">
							<h6><small class"form-text text-muted">N° de caracteres: <strong id="cant_carac_descartar_revertir_nna" style="color: #000000;">0</strong></small></h6>
						</div>

						<div class="col-12">
							<p id="val_descarte_revertir_nna" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar un comentario válido.</p>
						</div>
					</div>
					

				</div>	
			</div>

			<div class="modal-footer" style="background-color: white;">
				<button type="button" id="confirmar_descarte_revertir_nna" class="btn btn-primary"></button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
			</div>

		</div>
	</div>
</div>
<script type="text/javascript">
	function registrarDescarteRevertirNNA(run, periodo, descartar){
		let validacion = validarRegistrarDescarteRevertirNNA();
		if (!validacion) return false;

		bloquearPantalla();

		let data 		= new Object();
		data.run 		= run;
		data.periodo 	= periodo;
		data.descartar 	= descartar;
		data.comentario = $("#comentario_descarte_revertir_nna").val();

		$.ajaxSetup({
        	headers: {'X-CSRF-TOKEN': $('#token_formulario_descartar').val()}
      	});

		$.ajax({
		  url: "{{ route('casos.guardar.desestimacion.nomina') }}",
		  type: "POST",
		  data: data
		}).done(function( resp ) {
		   desbloquearPantalla();

		   if (resp.estado == 1){
		   	   alert(resp.mensaje);

		   	   $("#modal_descarte_revertir_nna").modal("hide");
		   	   $($('#Submenu-60').find('li')[0]).find('a')[0].click();
		   }else if(resp.estado == 0){
		   	 alert(resp.mensaje);

		   }
		}).fail(function(objeto, tipoError, errorHttp){
			desbloquearPantalla();

        	manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

        	console.log(objeto); return false;
		});

	}

  function validarRegistrarDescarteRevertirNNA(){
  	let comentario = $("#comentario_descarte_revertir_nna").val();
  	let respuesta = true;

  	if (comentario.length <= 2 || comentario == "" || typeof comentario == "undefined"){
  	   respuesta = false;
  	   $("#val_descarte_revertir_nna").show();
   	   $("#comentario_descarte_revertir_nna").addClass("is-invalid");

  	}else{
	   $("#val_descarte_revertir_nna").hide();
	   $("#comentario_descarte_revertir_nna").removeClass("is-invalid");
   	
   	}

   	return respuesta;

  }

  contenido_textarea_descartar_revertir_nna = ""; 
  function cantidadCaracteresCajaDescartarRevertirNNA(){
      num_caracteres = $("#comentario_descarte_revertir_nna").val().length;

      let num_caracteres_permitidos   = 2000;
      if (num_caracteres > num_caracteres_permitidos){ 
          $("#comentario_descarte_revertir_nna").val(contenido_textarea_descartar_revertir_nna);

      }else{ 
          contenido_textarea_descartar_revertir_nna = $("#comentario_descarte_revertir_nna").val(); 

      }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_descartar_revertir_nna").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_descartar_revertir_nna").css("color", "#000000");

       } 

      
       $("#cant_carac_descartar_revertir_nna").text($("#comentario_descarte_revertir_nna").val().length);
   }
</script>