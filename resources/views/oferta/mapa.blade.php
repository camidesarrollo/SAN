@extends('layouts.main')

@section('contenido')
    <section class=" p-1 cabecera">
		<div class="container-fluid">
			<div class="row align-items-center">
				<div class="col-md-12">
					<h5><i class="fa fa-map mr-2"></i> Mapa de Oferta Local</h5>
				</div>
			</div>
		</div>
	</section>

	<section>
		<div class="container-fluid">
			<div class="card p-4">
				<div class="row">
					<div class="col">
						<div class="form-group">
    						<label>Tipo Oferta</label>
    						<select class="form-control" name="map_ofe" id="map_ofe" >
	    						<option value="0">Seleccione un tipo de reporte</option>
	   							<option value="1">Por Programa</option>
	    						<option value="2">Por Alerta Territoral</option>
    						</select>
     					</div>
     				</div>
					<div class="col">
						<label>Descargar</label><br>
						<a href="{{ route("ofertas.mapa.exportable") }}" class="btn btn-info"><i class="fa fa-download mr-1"></i> Descargar Exportable</a>
					</div>
     			</div>
			
				<hr>

				<!--  <input type="hidden" id="ofertas_nom" nombre="ofertas_nom" value="{{ route('ofertas.nombre') }}"> -->

				<input id="token" hidden value="{{ csrf_token() }}">
				<div class="table-responsive" id="alerta_programa" style="display: none;"></div>
				<div class="table-responsive" id="alerta_territorial" style="display: none;"></div>
			</div>
		</div>
	</section>

@endsection

@section('script')
	<script type="text/javascript">
		$(document).ready(function(){
			$(function(){
				$("#map_ofe").on('change', function() {
					var selectValue = $(this).val();

					switch (selectValue) {
						case "0": //Seleccione uno
							if ($("#alerta_territorial").css("display") == "block") $("#alerta_territorial").empty();
							if ($("#alerta_programa").css("display") == "block") $("#alerta_programa").empty();

							$("#alerta_programa").hide();
							$("#alerta_territorial").hide();
							break;

						case "1": //Por Programa
							if ($("#alerta_territorial").css("display") == "block") $("#alerta_territorial").empty();
							$("#alerta_territorial").hide();

							reportePorPrograma();
							break;

						case "2": //Por Alerta Territorial
							if ($("#alerta_programa").css("display") == "block") $("#alerta_programa").empty();
							$("#alerta_programa").hide();

							reportePorTipoAlerta();
							break;
					}
				}).change();
			});
		});

		function reportePorPrograma(){
			let html = '<table class="table table-bordered" cellspacing="0" id="tabla_alerta_programa">';
			html += '<thead>';
			html += '<tr>';
			html += '<th>Sector</th>';
			html += '<th>Programa</th>';
			html += '<th>Componente</th>';
			html += '<th>Alertas Territorial</th>';
			html += '</tr>';
			html += '</thead>';
			html += '<tbody>';

			$.ajax({
				method: "GET",
				url: "{{ route('ofertas.programas') }}"
			}).done(function( data ){
				    if (data.estado == true){
						let respuesta = data.respuesta;

                        if (Object.keys(respuesta).length > 0){
							for (let c01 in respuesta){
								for (let c02 in respuesta[c01]){
									for (let c03 in respuesta[c01][c02]){
										for (let c04 in respuesta[c01][c02][c03]){
											for (let c05 in respuesta[c01][c02][c03][c04]){
												for (let c06 in respuesta[c01][c02][c03][c04][c05]){
													html += "<tr>";
													html += "<td>"+c01+"</td>";
													html += "<td>"+c03+"</td>";
													html += "<td>"+c05+"</td>";
													html += "<td>"+respuesta[c01][c02][c03][c04][c05][c06]+"</td>";
													html += "</tr>";
												}
											}
										}
									}
								}
							}
						} else if (Object.keys(respuesta).length == 0){
							html += "<tr><td colspan='4'><b>No se encuentran ningún Sector.</b></td></tr>";

                        }

					}else if (data.estado == false){
						html += "<tr><td colspan='4'><b>"+data.mensaje+"</b></td></tr>";

					}

				html += '</tbody>';
				html += '</table>';

				$("#alerta_programa").html(html);

				$("#alerta_programa").show();
				$('#tabla_alerta_programa').DataTable({
					ordering: false,
					paging: false,
					searching: true,
					info:     true,
					rowsGroup: [0,1,2],
					columnDefs: [
						{"className": "dt-center", "targets": [0]},
						{"className": "dt-center", "targets": [1]},
						{"className": "dt-left", "targets": [2]},
						{"className": "dt-left", "targets": [3]}],
					//language: { "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"}
					language: { "url": "{{ route('index') }}/js/dataTables.spanish.json"}
				});
			}).fail(function(data){
				html += "<tr><td colspan='4'><b>Ocurrio un error al momento de obtener el reporte. Por favor intente nuevamente.</b></td></tr>";
				html += '</tbody>';
				html += '</table>';

				$("#alerta_programa").html(html);

				$("#alerta_programa").show();
				$('#tabla_alerta_programa').DataTable({
					ordering: false,
					paging: false,
					searching: true,
					info:     true,
					rowsGroup: [0,1,2],
					columnDefs: [
						{"className": "dt-center", "targets": [0]},
						{"className": "dt-center", "targets": [1]},
						{"className": "dt-left", "targets": [2]},
						{"className": "dt-left", "targets": [3]}],
					//language: { "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"}
					language: { "url": "{{ route('index') }}/js/dataTables.spanish.json"}
				});

				console.log(data);
			});
		}


		function reportePorTipoAlerta(){
           let html = '<table class="table table-bordered" cellspacing="0" id="tabla_alerta_territorial">';
           html += '<thead>';
           html += '<tr>';
           html += '<th>Alertas Territorial</th>';
           html += '<th>Componente</th>';
		   html += '<th>Instituci&oacute;n</th>';
		   html += '<th>Programa</th>';
		   html += '<th>Sector</th>';
		   html += '</tr>';
		   html += '</thead>';
		   html += '<tbody>';

			$.ajax({
				method: "GET",
				dataType: "json",
				url: "{{ route('ofertas.alertas') }}"
			}).done(function( data ){
				if (data.estado == true){
					let respuesta = data.respuesta;

                    if (respuesta.estado == true){
                    	for (let c01 in respuesta["respuesta"]){
							for (let c02 in respuesta["respuesta"][c01]){
								for (let c03 in respuesta["respuesta"][c01][c02]){
									html += "<tr>";
									html += "<td >" + c02 + "</td>";
									html += "<td>"+respuesta["respuesta"][c01][c02][c03]["ofe_nom"]+"</td>";
									html += "<td>"+respuesta["respuesta"][c01][c02][c03]["pro_nom"]+"</td>";
									html += "<td>"+respuesta["respuesta"][c01][c02][c03]["inst_nom"]+"</td>";
									html += "<td>"+respuesta["respuesta"][c01][c02][c03]["dim_nom"]+"</td>";
									html += "</tr>";
								}
							}
                    	}

					}else if (respuesta.estado == false){
						html += "<tr><td colspan='5'><b>No se encuentran ningún tipo de Alerta Territorial.</b></td></tr>";

					}
				}else if (data.estado == false){
					 html += "<tr><td colspan='5'><b>"+data.mensaje+"</b></td></tr>";

				}

				html += '</tbody>';
				html += '</table>';

				$("#alerta_territorial").html(html);

				$("#alerta_territorial").show();
				let table = $('#tabla_alerta_territorial').DataTable({
					ordering: false,
					paging: false,
					searching: true,
					info:     true,
					rowsGroup: [0],
					columnDefs: [
						{"className": "dt-center", "targets": [0]},
						{"className": "dt-center", "targets": [1]},
						{"className": "dt-left", "targets": [2]},
						{"className": "dt-left", "targets": [3]},
						{"className": "dt-left", "targets": [4]}],
					//language: { "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"}
					language: { "url": "{{ route('index') }}/js/dataTables.spanish.json"}
				});
			}).fail(function(data){
				html += "<tr><td colspan='5'><b>Ocurrio un error al momento de obtener el reporte. Por favor intente nuevamente.</b></td></tr>";
				html += '</tbody>';
				html += '</table>';

				$("#alerta_territorial").html(html);

				$("#alerta_territorial").show();
				let table = $('#tabla_alerta_territorial').DataTable({
					ordering: false,
					paging: false,
					searching: true,
					info:     true,
					rowsGroup: [0],
					columnDefs: [
						{"className": "dt-center", "targets": [0]},
						{"className": "dt-center", "targets": [1]},
						{"className": "dt-left", "targets": [2]},
						{"className": "dt-left", "targets": [3]},
						{"className": "dt-left", "targets": [4]}],
					//language: { "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"}
					language: { "url": "{{ route('index') }}/js/dataTables.spanish.json"}
				});

				console.log(data);
			});
		}
	</script>
@endsection
