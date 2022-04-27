<div id="crearPausaModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content p-4">
			<div class="modal-header">
				<div style="margin: 0 auto;"><h5>Pausar / Reiniciar Caso</h5></div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute; margin: 0; top: 5px; right: 33px;">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			
			<div class="modal-body">
				<div class="form-group">
					<label for="comentario_estado_terapia">Comentario:</label>
					<textarea maxlength="2000" onkeypress='return caracteres_especiales(event)' class="form-control " id="comentario_pausa"
					name="comentario_pausa" rows="4" onKeyDown="valTextComenPausa()" onKeyUp="valTextComenPausa()"></textarea>
					<div class="row">
						<div class="col">
							<h6><small class="form-text text-muted">Mínimo 3 y máximo 2000 caracteres.</small></h6>
						</div>
						<div class="col text-left">
							<h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_com_pau" style="color: #000000;">0</strong></small></h6>
						</div>
					</div>
					<p id="val_comentario_pausa" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe escribir un comentario mínimo de 3 caracteres.</p>
				</div>
				<div class="text-center" id="msg_comentario_pausa" style="font-weight: 800; display: none;"></div>
			</div>
			<div class="modal-footer" style="background-color: white;">
				<button type="button" id="btn_pausa" class="btn btn-primary" onclick="crearReiniciarPausa({{$caso->cas_id}},{{$caso->est_pau}});">Guardar</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<script>

function crearReiniciarPausa(cas_id = null, estado = null){
	let text_pau = "";
	let comentario = $("#comentario_pausa").val();
		
	if(comentario.length < 3 || comentario == "" || typeof comentario == "undefined"){
		$("#comentario_pausa").addClass("is-invalid");
		$("#val_comentario_pausa").show();

		return false;
	}else{
		$("#comentario_pausa").removeClass("is-invalid");
		$("#val_comentario_pausa").hide();
	
	}

	if (estado == 1){
		text_pau = "Pausar";	
	
	}else if(estado==0){
		text_pau = "Reiniciar";

	} 

	if (!confirm('¿Confirma que desea '+text_pau+' el Caso N°: '+cas_id+'?')){
		return false;
	
	}

	bloquearPantalla();

	let data = new Object();
	data.cas_id = cas_id;
	data.comentario = comentario;
	data.estado = estado;

	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});

	$.ajax({
		url: "{{ route('pausar.caso') }}",
		type: "POST",
		data: data
	}).done(function(resp){
		desbloquearPantalla();

		if (resp.estado == 1){
			mensajeTemporalRespuestas(1, resp.mensaje);

			$('#crearPausaModal').modal('hide');	
			$("#comentario_pausa").val("");	
			
			location.reload();			
		}else if (resp.estado == 0){
			mensajeTemporalRespuestas(0, resp.mensaje);

		}
	}).fail(function(objeto, tipoError, errorHttp){
		desbloquearPantalla();

        manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

        return false;
	});
}

 function valTextComenPausa(){

      num_caracteres_permitidos   = 255;

      num_caracteres = $("#comentario_pausa").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#comentario_pausa").val(contenido_textarea_rechazo_estados);

       }else{ 
          contenido_textarea_rechazo_estados = $("#comentario_pausa").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_com_pau").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_com_pau").css("color", "#000000");

       } 
      
       $("#cant_carac_com_pau").text($("#comentario_pausa").val().length);
}


</script>