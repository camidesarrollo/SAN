
<div id="msgCambioEstadoTerapia" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content p-4">
			<div class="modal-header">
				<div style="margin: 0 auto;"><h5>Cambio de Estado Terapia</h5></div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute; margin: 0; top: 5px; right: 33px;">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			
			@php $list_rechazos = Helper::estadosRechazoTerapia(); @endphp
			
			<div class="modal-body">
				<!-- INICIO DC -->
				<div class="form-group" id="contenedor_rechazo_estado_persona">
					<label for="rechazo_estado_persona">Motivo:</label>
					<select name="rechazo_estado_terapia" id="rechazo_estado_terapia" class="form-control" onchange="getDescr(this.value)" >
						<option value="">Seleccione una opción</option>


							@foreach($list_rechazos as $value)
								<option value="{{$value->est_tera_id}}">{{$value->est_tera_nom}}</option>
							@endforeach

<!-- 						<option value="7">Familia rechaza participación en TF</option>
						<option value="8">Familia no aplica</option>
						<option value="9">NNA presenta vulneración de derechos</option>
						<option value="10">Familia no asiste</option>
						<option value="11">Familia renuncia a la TF</option> -->

		
					
					</select>
					<p id="val_msg_rec" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe escoger una opción.</p>
					<br>
				<div class="form-group">
					<label for="comentario_estado_terapia">Definición Motivo:</label>
					<textarea id="definicion_motivo" class="form-control" disabled="disabled" rows="4" >Seleccione un motivo</textarea>
				</div>
				</div>
				<!-- FIN DC -->
				<div class="form-group" id="contenedor_comentario_estado">
					<label for="comentario_estado">Comentario:</label>
					<textarea maxlength="500" onkeypress='return caracteres_especiales(event)' class="form-control" id="comentario_estado_terapia" 
					rows="4" onKeyDown="valTextAreaCambioEstadoRechazo()" onKeyUp="valTextAreaCambioEstadoRechazo()"></textarea>
					<div class="row">
						<div class="col">
							<h6><small class="form-text text-muted">Mínimo 3 y máximo 500 caracteres.</small></h6>
						</div>
						<div class="col text-left">
							<h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_cam_est" style="color: #000000;">0</strong></small></h6>
						</div>
					</div>
					<p id="val_msg_com" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe escribir un comentario mínimo de 3 caracteres.</p>
					<br>
					<div class="form-group">
						<label for="comentario_estado">Carta de Renuncia:</label>
						<div class="input-group mb-6">
						<form enctype="multipart/form-data" id="adj_doc" method="post" class="w-100" onsubmit="">
							{{ csrf_field() }}
							<div class="custom-file" style="z-index:0;">
									<input type="file" class="custom-file-input " name="doc_carta_renuncia" id="doc_carta_renuncia" onchange="inputfilename()">
									<label id="filename" class="custom-file-label" for="doc_carta_renuncia" aria-describedby="inputfilerenuncia">Cargar archivo</label>
							</div>
						</form>
						<div id="descargar_carta_renuncia" style="display: none;">
							<div class="input-group-append">
								<span class="input-group-text" id="inputfilerenuncia"><a download href="" id="ruta_documento_carta_renuncia"><img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjUxMnB4IiBoZWlnaHQ9IjUxMnB4IiB2aWV3Qm94PSIwIDAgNDc1LjA3OCA0NzUuMDc3IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA0NzUuMDc4IDQ3NS4wNzc7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4KPGc+Cgk8Zz4KCQk8cGF0aCBkPSJNNDY3LjA4MywzMTguNjI3Yy01LjMyNC01LjMyOC0xMS44LTcuOTk0LTE5LjQxLTcuOTk0SDMxNS4xOTVsLTM4LjgyOCwzOC44MjdjLTExLjA0LDEwLjY1Ny0yMy45ODIsMTUuOTg4LTM4LjgyOCwxNS45ODggICAgYy0xNC44NDMsMC0yNy43ODktNS4zMjQtMzguODI4LTE1Ljk4OGwtMzguNTQzLTM4LjgyN0gyNy40MDhjLTcuNjEyLDAtMTQuMDgzLDIuNjY5LTE5LjQxNCw3Ljk5NCAgICBDMi42NjQsMzIzLjk1NSwwLDMzMC40MjcsMCwzMzguMDQ0djkxLjM1OGMwLDcuNjE0LDIuNjY0LDE0LjA4NSw3Ljk5NCwxOS40MTRjNS4zMyw1LjMyOCwxMS44MDEsNy45OSwxOS40MTQsNy45OWg0MjAuMjY2ICAgIGM3LjYxLDAsMTQuMDg2LTIuNjYyLDE5LjQxLTcuOTljNS4zMzItNS4zMjksNy45OTQtMTEuOCw3Ljk5NC0xOS40MTR2LTkxLjM1OEM0NzUuMDc4LDMzMC40MjcsNDcyLjQxNiwzMjMuOTU1LDQ2Ny4wODMsMzE4LjYyN3ogICAgIE0zNjAuMDI1LDQxNC44NDFjLTMuNjIxLDMuNjE3LTcuOTA1LDUuNDI0LTEyLjg1NCw1LjQyNHMtOS4yMjctMS44MDctMTIuODQ3LTUuNDI0Yy0zLjYxNC0zLjYxNy01LjQyMS03Ljg5OC01LjQyMS0xMi44NDQgICAgYzAtNC45NDgsMS44MDctOS4yMzYsNS40MjEtMTIuODQ3YzMuNjItMy42Miw3Ljg5OC01LjQzMSwxMi44NDctNS40MzFzOS4yMzIsMS44MTEsMTIuODU0LDUuNDMxICAgIGMzLjYxMywzLjYxLDUuNDIxLDcuODk4LDUuNDIxLDEyLjg0N0MzNjUuNDQ2LDQwNi45NDIsMzYzLjYzOCw0MTEuMjI0LDM2MC4wMjUsNDE0Ljg0MXogTTQzMy4xMDksNDE0Ljg0MSAgICBjLTMuNjE0LDMuNjE3LTcuODk4LDUuNDI0LTEyLjg0OCw1LjQyNGMtNC45NDgsMC05LjIyOS0xLjgwNy0xMi44NDctNS40MjRjLTMuNjEzLTMuNjE3LTUuNDItNy44OTgtNS40Mi0xMi44NDQgICAgYzAtNC45NDgsMS44MDctOS4yMzYsNS40Mi0xMi44NDdjMy42MTctMy42Miw3Ljg5OC01LjQzMSwxMi44NDctNS40MzFjNC45NDksMCw5LjIzMywxLjgxMSwxMi44NDgsNS40MzEgICAgYzMuNjE3LDMuNjEsNS40MjcsNy44OTgsNS40MjcsMTIuODQ3QzQzOC41MzYsNDA2Ljk0Miw0MzYuNzI5LDQxMS4yMjQsNDMzLjEwOSw0MTQuODQxeiIgZmlsbD0iIzAwMDAwMCIvPgoJCTxwYXRoIGQ9Ik0yMjQuNjkyLDMyMy40NzljMy40MjgsMy42MTMsNy43MSw1LjQyMSwxMi44NDcsNS40MjFjNS4xNDEsMCw5LjQxOC0xLjgwOCwxMi44NDctNS40MjFsMTI3LjkwNy0xMjcuOTA4ICAgIGM1Ljg5OS01LjUxOSw3LjIzNC0xMi4xODIsMy45OTctMTkuOTg2Yy0zLjIzLTcuNDIxLTguODQ3LTExLjEzMi0xNi44NDQtMTEuMTM2aC03My4wOTFWMzYuNTQzYzAtNC45NDgtMS44MTEtOS4yMzEtNS40MjEtMTIuODQ3ICAgIGMtMy42Mi0zLjYxNy03LjkwMS01LjQyNi0xMi44NDctNS40MjZoLTczLjA5NmMtNC45NDYsMC05LjIyOSwxLjgwOS0xMi44NDcsNS40MjZjLTMuNjE1LDMuNjE2LTUuNDI0LDcuODk4LTUuNDI0LDEyLjg0N1YxNjQuNDUgICAgaC03My4wODljLTcuOTk4LDAtMTMuNjEsMy43MTUtMTYuODQ2LDExLjEzNmMtMy4yMzQsNy44MDEtMS45MDMsMTQuNDY3LDMuOTk5LDE5Ljk4NkwyMjQuNjkyLDMyMy40Nzl6IiBmaWxsPSIjMDAwMDAwIi8+Cgk8L2c+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==" height="20px"/></a></span>
							</div>
						</div>
						<div class="text-left"><small>En caso de no tener la carta de renuncia puede descargarlo haciendo <a href="/documentos/Carta_de_Renuncia_Voluntaria_Terapia_Familiar.docx" class="text-primary">click acá</a></small></div>
					</div>
					<p id="val_doc_carta_renuncia" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Debe cargar la Carta de Renuncia.</p>
					</div>
				</div>
				
				<div class="text-center" id="msg_cambioEstado_body" style="font-weight: 800; display: none;"></div>
			</div>
			<div class="modal-footer" style="background-color: white;">
				<button type="button" id="cambiar_estado" class="btn btn-primary" onclick="validarComentarioModalEstadoTerapia();">Guardar</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<input id="val_carta_renuncia" type="hidden" value="">
<script type="text/javascript">

	function inputfilename(){
		$('#val_carta_renuncia').val(true);
		let input = $("#doc_carta_renuncia").val();
		input = document.getElementById('doc_carta_renuncia');
		for (var i = 0; i < input.files.length; ++i) {
			$("#filename").text(input.files.item(i).name);
		}
	}

	function cargarCartaRenuncia(resp){

		if(!$('#val_carta_renuncia').val()) return resp = true;

		var form = document.getElementById('adj_doc');
        let formData = new FormData(form);
		formData.append('tera_id', {{$nna_teparia->tera_id }});
        //formData.append('_token', $('input[name=_token]').val());

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{route('documento.carta.renuncia')}}",
            data: formData,
            cache: false,
            contentType: false,
			processData: false,
			async: false
        }).done(function(resp){

                if (resp.estado == 1){                 
					return resp = true;
					// $('#descargar_carta_renuncia').show();
                    // $("#ruta_documento_carta_renuncia").attr("href","../../doc/"+resp.filename);
					// mensajeTemporalRespuestas(1, resp.mensaje);

                }else if (resp.estado == 0){
					mensajeTemporalRespuestas(0, resp.mensaje);
					return resp = false;
                }

        }).fail(function(objeto, tipoError, errorHttp){

            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

            return false;
        });
	}
	//INICIO DC
	function getDescr(valor){
		bloquearPantalla(); 
		let data = new Object();
		data.valor = valor;
		data.perfil = {{session()->all()['perfil']}};
	    $.ajax({
			url: "{{ route('get.definicion') }}",
			type: "GET",
			data: data
		}).done(function(resp){
			var dato = JSON.parse(resp);
			$('#definicion_motivo').html(dato[0].cat_des_descripcion);
			desbloquearPantalla();
		}).fail(function(obj){
			console.log(obj); return false;
		});
	}
	//FIN DC
</script>