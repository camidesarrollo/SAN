
<div class="card p-4 shadow-sm">

	<div class="row">
		<div class="col-10 text-left">
			<h5><b>{{ $nombre_reporte }}</b></h5>
		</div>
		<div class="col-2 text-right">
			<button class='btn btn-success' id="xls_reporte_brechas" name="xls_reporte_brechas" onclick="descargarReporteBrechas();">
				<i class="fas fa-download"></i> Descargar
			</button>
		</div>
	</div>
		

	<!--<input id="token" hidden value="{ { csrf_token() }}">-->	
	<!--<h5>Total <span class="badge badge-warning" id="total1">0</span></h5>-->


	<!-- INICIO CZ SPRINT 57 -->
		<!-- <div class="row">
		<div class="table-responsive">
			<table class="table table-striped table-hover encabezado_datatable cell-border w-100" cellspacing="0" id="tabla_brechas">
				<thead>
				<tr>
					<th class="text-center">Necesidad detectada</th>
					<th class="text-center">Programa o <br>iniciativa que requiere</th>
					<th class="text-center">Institución</th>
					<th class="text-center">Brecha</th>
					<th class="text-center">Tipo de Brecha</th>
				</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div>
	</div> -->
	<div class="row">
		<div class="table-responsive">
			<table class="table table-striped table-hover encabezado_datatable cell-border w-100" cellspacing="0" id="tabla_brechas_modificación">
				<thead>
				<tr>
					<th class="text-center">Programa o <br>iniciativa que requiere</th>
					<th class="text-center">Institución</th>
					<th class="text-center">Alerta Territorial</th>
					<th class="text-center">Run</th>
					<th class="text-center">Comuna</th>
				</tr>
				</thead>
				<tbody></tbody>
			</table>
	</div>
	</div>
	<!-- FIN CZ SPRINT 57 -->
</div>
<input type="hidden" name="fec_ini" id="fec_ini" value="{{$fec_ini}}">
<input type="hidden" name="fec_fin" id="fec_fin" value="{{$fec_fin}}">

<script type="text/javascript">
	$(document).ready( function () {

		let chkcomuna = new Array();
		$.each($("#chkcomuna option:selected"), function(){chkcomuna.push($(this).val()); });
		comunas 	= chkcomuna.join(',');
		fec_ini = $('#fec_ini').val();
		fec_fin = $('#fec_fin').val();
		// INICIO CZ SPRINT 57
		// tabla_brechas = $('#tabla_brechas').on('error.dt',
		// function (e, settings, techNote, message) {
		// 	tabla_brechas.ajax.reload(null,false);
    	// 	console.log('Ocurrió un error en el datatable de: rpt_rut_asignado_gestor.index.blade.php, el error es: ', message);
		// }).DataTable({
		// 	//"serverSide": true,
		// 	"order":[
		// 		[ 0, "desc" ]
		// 	],
		// 	"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
		// 	//"ajax": "{{ route('rptMapaOfertaBrecha') }}",
		// 	"ajax": "{{ route('rptMapaOfertaBrecha') }}/"  +comunas+'/'+fec_ini+'/'+fec_fin,
		// 	"columns": [
		// 		{
		// 		 "data": "ale_tip_nom",
		// 		 "className": "text-left"
		// 		},
		// 		{
		// 		 "data": "pro_nom",
		// 		 "className": "text-left"
		// 		},
		// 		{
		// 		 "data": "pro_inst_resp",
		// 		 "className": "text-left"
		// 		},
		// 		{
		// 		 "data": "brecha",
		// 		 "className": "text-left"
		// 		},
		// 		{
		// 		 "data": "tipo_brecha",
		// 		 "className": "text-left"
		// 		}
		// 	],
		// 	"drawCallback": function (settings){
		// 		$("#total1").text(settings._iRecordsTotal);
		// 	}
		// });

		tabla_brechas2 = $('#tabla_brechas_modificación').on('error.dt',
		function (e, settings, techNote, message) {
			tabla_brechas.ajax.reload(null,false);
    		console.log('Ocurrió un error en el datatable de: rpt_rut_asignado_gestor.index.blade.php, el error es: ', message);
		}).DataTable({
			//"serverSide": true,
			"order":[
				[ 0, "desc" ]
			],
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			//"ajax": "{{ route('rptMapaOfertaBrecha') }}",
			"ajax": "{{ route('rptMapaOfertaBrecha') }}/"  +comunas+'/'+fec_ini+'/'+fec_fin,
			"columns": [
				{
				 "data": "nombre_programa",
				 "className": "text-left"
				},
				{
				 "data": "institucion",
				 "className": "text-left"
				},
				{
				 "data": "alerta",
				 "className": "text-left",
				 "width": "20%",
				},
				{
				 "data": "run",
				 "className": "text-left"
				},
				{
				 "data": "comuna",
				 "className": "text-left"
				}
			],
			"drawCallback": function (settings){
				$("#total1").text(settings._iRecordsTotal);
			}
		});
		// FIN CZ SPRINT 57
	});

	function descargarReporteBrechas(){

			let chkcomuna = new Array();
			$.each($('#chkcomuna option:selected'), function(){ chkcomuna.push($(this).val())});
			comunas 	= chkcomuna.join(',');
			fec_ini = $('#fec_ini').val();
			fec_fin = $('#fec_fin').val();
			window.location.assign("{{ route('rptExportMapaOfertaBrecha') }}/" + comunas+'/'+fec_ini+'/'+fec_fin);
			//window.location.assign("{{ route('rptExportMapaOfertaBrecha') }}");
	}

</script>