
<div class="card p-4 shadow-sm">

		<div class="row">
			<div class="col-10 text-left">
				<h5><b>{{ $nombre_reporte }}</b></h5>
			</div>
			<div class="col-2 text-right">
				<button class='btn btn-success' id="xls_reporte_detalle_alertas_chcc" name="xls_reporte_detalle_alertas_chcc" onclick="descargarReporteDetalleChcc()">
					<i class="fas fa-download"></i> Descargar
				</button>
			</div>
		</div>

		<div class="row">
			<div class="table-responsive">
				<table class="table table-striped table-hover encabezado_datatable cell-border w-100" cellspacing="0" id="tabla_detalle_alertas_chcc_por_nna">
					<thead>
					<tr>
						<th class="text-center" style="padding:1px;">Tipos de Alerta Territorial</th>
						<th class="text-center" style="padding:1px;">Nombre NNA</th>
						<th class="text-center" style="padding:40px;">RUN</th>
						<th class="text-center" style="padding:1px;">Edad</th>
						<th class="text-center" style="padding:1px;">Sexo</th>
						<th class="text-center" style="padding:1px;">Comuna</th>
						<th class="text-center" style="padding:1px;">Región</th>
						<th class="text-center" style="padding:1px;">Sectorialista</th>
						<th class="text-center" style="padding:1px;">Sector</th>
						<th class="text-center" style="padding:35px;">Fecha Alerta</th>
						<th>RUNSINFORMATO</th>
					</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>

			<div class="col-md-12" style="display:none;">
				<div id="grafico_alertas_territoriales_por_nna" style="width: 100%; height: 350px;"></div>
			</div>
		</div>


</div>

<script type="text/javascript">
	$(document).ready( function () {

		//let data 		= new Object();
		let chkcomuna	= new Array();
		$.each($('#chkcomuna option:selected'), function(){ chkcomuna.push($(this).val()); });
		comunas			= chkcomuna.join(',');
		//data.comunas 	= comunas;
		
		tabla_detalle_alertas_chcc_por_nna = $('#tabla_detalle_alertas_chcc_por_nna').on('error.dt',
		function (e, settings, techNote, message) {
			tabla_detalle_alertas_chcc_por_nna.ajax.reload(null,false);
    		console.log('Ocurrió un error en el datatable de: rpt_alertas_territoriales_por_nna.index.blade.php, el error es: ', message);
		}).DataTable({
			//"serverSide": true,
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			//"ajax": "{{ route('rptDetalleAlertasChcc') }}",
			"ajax": "{{ route('rptDetalleAlertasChcc') }}/"+comunas,
			"columns": [
				{
				 "data": "ale_chcc_ind",
				 "className": "text-left"
				},
				{
				 "data": "nombre_nna",
				 "className": "text-left"
				},
				{
				 "data": "nna_run_con_formato",
				 "className": "text-left"
				},
				{
				 "data": "per_ani",
				 "className": "text-right"
				},
				{
				 "data": "ale_man_nna_sexo",
				 "className": "text-left"
				},
				{
				 "data": "com_nom",
				 "className": "text-left"
				},
				{
				 "data": "reg_nom",
				 "className": "text-left"
				},
				{
				 "data": "nombre_usuario",
				 "className": "text-left"
				},
				{
				 "data": "sector",
				 "className": "text-left"
				},
				{
				 "data": "ale_chcc_fec_ing",
				 "className": "text-left"
				},
				{
				 "data": "nna_run",
				 "visible": false
				}
			],
			"order":[
				[ 0, "desc" ]
			]
		});

		//$("#xls_reporte_detalle_alertas_chcc").click( function () {
			//window.location.assign("{{ route('rptExportDetalleAlertasChcc') }}");
		//});


	});
	function descargarReporteDetalleChcc(){
			let chkcomuna	= new Array();
			$.each($('#chkcomuna option:selected'), function(){ chkcomuna.push($(this).val()); });
			comunas			= chkcomuna.join(',');;
			window.location.assign("{{ route('rptExportDetalleAlertasChcc') }}" + "/" + comunas);
			
	}
</script>
