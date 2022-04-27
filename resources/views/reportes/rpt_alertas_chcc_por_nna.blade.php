<div class="card p-4 shadow-sm">
		<div class="row">
			<div class="col-10 text-left">
				<h5><b>{{ $nombre_reporte }}</b></h5>
			</div>
			<div class="col-2 text-right">
				<button class='btn btn-success' id="xls_reporte_chcc" name="xls_reporte_chcc" onclick="descargarReporteCantidadCHCC()">
				   <i class="fas fa-download"></i> Descargar
				</button>
			</div>
		</div>
		<div class="row">
			<div class="table-responsive">
				<table class="table table-striped table-hover encabezado_datatable cell-border w-100" cellspacing="0" id="tabla_alertas_chile_crece_contigo">
					<thead>
					<tr>
						<th class="text-center">Tipo de Alerta ChCC Homologada</th>
						<th class="text-center">Cantidad de NNA</th>
					</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>

			<div class="col-md-12" style="display:none;">
        		<div id="grafico_alertas_chile_crece_contigo" style="width: 100%; height: 350px;"></div>
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

		tabla_alertas_chile_crece_contigo = $('#tabla_alertas_chile_crece_contigo').on('error.dt',
		function (e, settings, techNote, message) {
			tabla_alertas_chile_crece_contigo.ajax.reload(null,false);
    		console.log('Ocurrió un error en el datatable de: rpt_alertas_chile_crece_contigo.index.blade.php, el error es: ', message);
		}).DataTable({
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			//"ajax": "{{ route('rptDataAlertasChileCreceContigo') }}",
			"ajax": "{{ route('rptDataAlertasChileCreceContigo') }}/"+comunas,
			"columns": [
				{
				 "data": "ale_chcc_ind",
				 "className": "text-left"
				},
				{
				 "data": "total",
				 "className": "text-right"
				}
			],
			"order":[
				[ 1, "desc" ]
			],
			 drawCallback: function (settings) {
				$('#grafico_alertas_chile_crece_contigo').highcharts({
		            data: {
		                table: 'tabla_alertas_chile_crece_contigo'
		            },
		            chart: {
		                type: 'pie'
		            },
		            title: {
		                text: 'Alertas Chile Crece Contigo Homologadas'
		            }
		        });
			 },
			 footerCallback: function ( row, data, start, end, display ) {
        		var api = this.api(), data;

	            // Remove the formatting to get integer data for summation
	            var intVal = function ( i ) {
	                return typeof i === 'string' ?
	                    i.replace(/[\$,]/g, '')*1 :
	                    typeof i === 'number' ?
	                        i : 0;
	            };
	 
	            // Total over all pages
	            total = api
	                .column( 1 )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );
	 
	            // Update footer

	            if ($("#total2").text()=='0'){
	            	$("#total2").text(total);
	        	}


    		}
		});

		//$("#xls_reporte_chcc").click( function () {
			//window.location.assign("{{ route('rptExportChileCreceContigo') }}");
		//});


	});
	function descargarReporteCantidadCHCC(){
			let chkcomuna	= new Array();
			$.each($('#chkcomuna option:selected'), function(){ chkcomuna.push($(this).val()); });
			comunas			= chkcomuna.join(',');;
			window.location.assign("{{ route('rptExportChileCreceContigo') }}" + "/" + comunas);
			//window.location.assign("{{ route('rptExportChileCreceContigo') }}");
	}

</script>
