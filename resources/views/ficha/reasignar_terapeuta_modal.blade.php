<div id="reAsignarTerapeutaModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="asignarTerapeutaModal" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content p-4">
			<div class="modal-header">
				<h2 class="modal-title" id="form_familiar_tit">Reasignar Terapeuta</h2>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-row">
				{{ csrf_field() }}
				<div id="seleccionar_terapeuta" class="form-group col-md-12">
					<label><b>Reasignar a Terapeuta:</b></label>
					<select class="form-control" name="terapeuta" id="terapeuta">
						<option value="" >Seleccione al Terapeuta</option>
						@foreach($terapeutas as $terapeuta)
					    <option value="{{$terapeuta->id}}" @if($tera_asig_id==$terapeuta->id) selected @endif >{{$terapeuta->nombre}}</option>
						@endforeach
					</select>
					<p id="val_frm_terapeuta" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe seleccionar el terapeuta.</p>
				</div>
			</div>
			<div class="text-left">
				<button type="button" id="btn_guardar_objetivo" class="btn btn-primary" onclick="asignarTerapeuta();">Asignar</button>
				<button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
			</div>
		</div>
	</div>
</div>

<script>

function asignarTerapeuta(){

	validar = validarModalReasignarTerapeuta();

	if (validar){

		let data = new Object();
		data.terapeuta_id = $("#terapeuta").val();
		data.cas_id = $("#cas_id").val();

		// bloquearPantalla();

		//alert(data.cas_id);

		$.ajax({
			"url" : '{{ route("terapia.re_asignar_terapeuta") }}',
			"type": "GET",
			"dataType" : 'json',
			"data": data
		}).done(function(resp){
			if (resp.estado == 1){

				alert(resp.mensaje);
				// ocultarMensajesError();
				// limpiarModalTerapia();

				$('#asignarTerapeutaModal').modal('hide');

				location.reload();

			}else{

				alert('No se pudo re-asignar al terapeuta, favor intente nuevamente');
			
			}

			desbloquearPantalla();

		}).fail(function(obj){
			desbloquearPantalla();
			console.log(obj);
		});
	
	}

}

function validarModalReasignarTerapeuta(){
	
	let respuesta = true;
	let terapeuta = $("#terapeuta").val();
		
		if (terapeuta == "" || typeof terapeuta === "undefined"){
			respuesta = false;
			$("#val_frm_terapeuta").show();
		}			

	return respuesta;
}


</script>