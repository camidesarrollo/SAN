
<div class="card p-4 shadow-sm">
	<div class="row">
		<div class="col-10 text-left">
			<h5><b>{{ $nombre_reporte }}</b></h5>
		</div>
		<div class="col-2 text-right">
			<button class='btn btn-success' id="xls_reporte" name="xls_reporte" onclick="descargarReporteXComuna()">
			<i class="fas fa-download"></i> Descargar
			</button>
		</div>
	</div>	
	
	<div class="row">
		<div class="table-responsive">
			<table class="table table-striped table-hover encabezado_datatable cell-border w-100" cellspacing="0" id="tabla_alertas_territoriales_por_comuna">
				<thead>
				<tr>
					<th class="text-center" style="width: 70%">Comuna</th>
					<th class="text-center" style="width: 30%">N° de Alertas Territoriales en SAN (ingresadas por sectorialistas)</th>
				</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div>
		<div class="col-md-12" style="display:none;">
			<div id="grafico_alertas_territoriales_por_comuna" style="width: 100%; height: 350px;"></div>
		</div>
	</div>		
</div>
<input type="hidden" name="fec_ini" id="fec_ini" value="{{$fec_ini}}">
<input type="hidden" name="fec_fin" id="fec_fin" value="{{$fec_fin}}">

<script type="text/javascript">
	$(document).ready( function () {
		
		let chkcomuna	= new Array();
		$.each($('#chkcomuna option:selected'), function(){ chkcomuna.push($(this).val()); });
		comunas			= chkcomuna.join(',');
		fec_ini = $('#fec_ini').val();
		fec_fin = $('#fec_fin').val();

		tabla_alertas_territoriales_por_comuna = $('#tabla_alertas_territoriales_por_comuna').on('error.dt',
		function (e, settings, techNote, message) {
			tabla_alertas_territoriales_por_comuna.ajax.reload(null,false);
    		console.log('Ocurrió un error en el datatable de: rpt_alertas_territoriales_por_comuna.index.blade.php, el error es: ', message);
		}).DataTable({
			"serverSide": true,
			"order":[
				[ 1, "desc" ]
			],
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			//"ajax": "{{ route('rptDataAlertasTerritorialesPorComuna') }}",
			"ajax": "{{ route('rptDataAlertasTerritorialesPorComuna') }}/" + comunas+'/'+fec_ini+'/'+fec_fin,
			"columns": [
				{
				 "data": "com_nom",
				 "className": "text-left"
				},
				{
				 "data": "total",
				 "className": "text-right"
				}
			],
			 drawCallback: function (settings) {
				$('#grafico_alertas_territoriales_por_comuna').highcharts({
		            data: {
		                table: 'tabla_alertas_territoriales_por_comuna'
		            },
		            chart: {
		                type: 'pie'
		            },
		            title: {
		                text: 'Alertas Territoriales por Comuna'
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

	            if ($("#total1").text()=='0'){
	            	$("#total1").text(total);
	        	}

    		}

		});


	});

	function descargarReporteXComuna(){
		let chkcomuna	= new Array();
		$.each($('#chkcomuna option:selected'), function(){ chkcomuna.push($(this).val()); });
		comunas			= chkcomuna.join(',');
		fec_ini = $('#fec_ini').val();
		fec_fin = $('#fec_fin').val();
		window.location.assign("{{ route('rptExportAlertasTerritorialesPorComuna') }}" + "/" + comunas+'/'+fec_ini+'/'+fec_fin);
		//window.location.assign("{{ route('rptExportAlertasTerritorialesPorComuna') }}");
	}

</script>

