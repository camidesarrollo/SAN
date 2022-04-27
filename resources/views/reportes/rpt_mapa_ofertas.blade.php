
<div class="card p-4 shadow-sm"> 

	<div class="row">
		<div class="col-10 text-left">
			<h5><b>{{ $nombre_reporte }}</b></h5>
		</div>
		<div class="col-2 text-right">
			<button class='btn btn-success' id="xls_reporte" name="xls_reporte" onclick="descargarReporte();">
				<i class="fas fa-download"></i> Descargar
			</button>
		</div>
	</div>
		

	<!--<input id="token" hidden value="{ { csrf_token() }}">-->	
	<!--<h5>Total <span class="badge badge-warning" id="total1">0</span></h5>-->

	<div class="row">
		<div class="table-responsive">
			<table class="table table-striped table-hover encabezado_datatable cell-border w-100" cellspacing="0" id="tabla_mapa_oferta">
				<thead>
				<tr>
					<th>Nombre Programa</th>
					<th>Institución Responsable</th>
					<th>Cupos Comunales Programa</th>
					<th>Sector</th>
					<th>Disponible en la Comuna</th>
					<th>Contacto Comunal</th>
					<th>Tipo AT Que Mitiga</th>
					<th>Establecimiento</th>
					<th>Responsable</th>
					<th>Fecha de Actualización</th>
					<th>Tipo Programa</th>
				</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div>
	</div>
			
</div>
<script type="text/javascript">
	$(document).ready( function () {

		let chkcomuna	= new Array();
		$.each($('#chkcomuna option:selected'), function(){ chkcomuna.push($(this).val()); });
		comunas			= chkcomuna.join(',');

		tabla_mapa_oferta = $('#tabla_mapa_oferta').on('error.dt',
		function (e, settings, techNote, message) {
			tabla_mapa_oferta.ajax.reload(null,false);
    		console.log('Ocurrió un error en el datatable de: rpt_mapa_ofertas.blade.php, el error es: ', message);
		}).DataTable({
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			"ajax": "{{ route('rptDataMapaOfertas') }}/" + comunas,
			"columnDefs": [ 
				{ // NOMBRE PROGRAMA
					"targets": 		0,
					"width":       "20%",
					"className": 	'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				        // $(td).css("word-break", "break-word");
				     
				    }
				},
				{ // INSTITUCIÓN RESPONSABLE
					"targets": 		1,
					"width":       "5%",
					"className": 	'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				        $(td).css("word-break", "break-word");
				     
				    }
				},
				{ // CUPOS COMUNALES PROGRAMA
					"targets": 		2,
					"width":       "5%",
					"className": 	'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				        $(td).css("word-break", "break-word");
				     
				    }
				},
				{ // SECTOR
					"targets": 		3,
					"width":       "5%",
					"className": 	'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				        $(td).css("word-break", "break-word");
				     
				    }
				},
				{ // DISPONIBLE EN LA COMUNA
					"targets": 		4,
					"width":       "5%",
					"className": 	'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				        $(td).css("word-break", "break-word");
				     
				    }
				},
				{ // CONTACTO COMUNAL
					"targets": 		5,
					"width":       "10%",
					"className": 	'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				        $(td).css("word-break", "break-word");
				     
				    }
				},
				{ // TIPO AT QUE MITIGA
					"targets": 		6,
					"width":       "20%",
					"className": 	'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				        $(td).css("word-break", "break-word");
				     
				    }
				},
				{ // ESTABLECIMIENTO
					"targets": 		7,
					"width":       "15%",
					"className": 	'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				        $(td).css("word-break", "break-word");
				     
				    }
				},
				{ // RESPONSABLE
					"targets": 		8,
					"width":       "10%",
					"className": 	'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				        $(td).css("word-break", "break-word");
				     
				    }
				},
				{ // FECHA DE ACTUALIZACIÓN
					"targets": 		9,
					"width":       "5%",
					"className": 	'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				        $(td).css("word-break", "break-word");
				     
				    }
				},
				{ // TIPO PROGRAMA inicio ch
					"targets": 		10,
					"width":       "5%",
					"className": 	'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				        $(td).css("word-break", "break-word");
				     
				    }
				}
			],
			"rowsGroup" : [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],//fin ch	
			"columns": [
				{
				 "data": "pro_nom" //NOMBRE PROGRAMA
				},
				{
				 "data": "institucion" //INSTITUCIÓN RESPONSABLE
				},
				{
				 "data": "pro_cup" //CUPOS COMUNALES PROGRAMA
				},
				{
				 "data": "sector" //SECTOR
				},
				{
				 "data": "disponible" //DISPONIBLE EN LA COMUNA
				},
				{
				 "data": "contacto" //CONTACTO COMUNAL
				},
				{
				 "data": "tipo_at" //TIPO AT QUE MITIGA
				},
				{
				 "data": "establecimiento" //ESTABLECIMIENTO
				},
				{
				 "data": "responsable" //RESPONSABLE
				},
				{
				 "data": "fecha_actualizacion", //FECHA DE ACTUALIZACIÓN
				 "render": function (data, type, row, meta){
						let respuesta = "Sin información";

						if (data != "" && data != undefined){
						 	let fecha = new Date(data);
              
              				let month = fecha.getMonth() + 1;
              				let day = fecha.getDate();
              				let year = fecha.getFullYear();
              
              				respuesta = day + "/" + month + "/" + year;

						}	

						return respuesta;
				 }
				},
				{//inicio ch
				 "data": "tipo" //TIPO PROGRAMA 
				}//fin ch
			],
			"drawCallback": function (settings){
				$("#total1").text(settings._iRecordsTotal);
			}
		});
	});

	function descargarReporte(){
	
		let chkcomuna	= new Array();
		$.each($('#chkcomuna option:selected'), function(){ chkcomuna.push($(this).val()); });
		comunas			= chkcomuna.join(',');;
		window.location.assign("{{ route('rptExportMapaOfertas') }}" + "/" + comunas);
		//window.location.assign("{{ route('rptExportMapaOfertas') }}");
	}

</script>