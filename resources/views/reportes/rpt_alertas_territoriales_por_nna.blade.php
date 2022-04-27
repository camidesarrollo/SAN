<div class="card p-4 shadow-sm">
		<div class="row">
			<div class="col-10 text-left">
				<h5><b>{{ $nombre_reporte }}</b></h5>
			</div>
			<div class="col-2 text-right">
				<button class='btn btn-success' id="xls_reporte1" name="xls_reporte" onclick="descargarReportePorNNA();">
				   <i class="fas fa-download"></i> Descargar
				</button>
			</div>
		</div>

		<div class="row">
			<div class="table-responsive">
				<table class="table table-striped table-hover encabezado_datatable cell-border w-100" cellspacing="0" id="tabla_alertas_territoriales_por_nna">
					<thead>
					<tr>
						<th class="text-center">Tipo de Alerta Territorial</th>
						<th class="text-center">Cantidad de NNA</th>
					</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>

			<div class="col-md-12" style="display:none;">
        		<div id="grafico_alertas_territoriales_por_nna" style="width: 100%; height: 350px;"></div>
    		</div>
		</div><br><br><br>
</div>
<input type="hidden" name="fec_ini" id="fec_ini" value="{{$fec_ini}}">
<input type="hidden" name="fec_fin" id="fec_fin" value="{{$fec_fin}}">
<input type="hidden" name="tip_ale" id="tip_ale" value="{{$tip_ale}}">

<script type="text/javascript">
	$(document).ready( function () {

		//let data 		= new Object();
		let chkcomuna	= new Array();
		$.each($('#chkcomuna option:selected'), function(){ chkcomuna.push($(this).val()); });
		comunas			= chkcomuna.join(',');
		fec_ini 		= $('#fec_ini').val();
		fec_fin 		= $('#fec_fin').val();
		if($('#tip_ale').val() > 0){
			tip_ale = $('#tip_ale').val();
		}else{
			tip_ale = 0;
		}
		//data.comunas 	= comunas;
		
		tabla_alertas_territoriales_por_nna = $('#tabla_alertas_territoriales_por_nna').on('error.dt',
		function (e, settings, techNote, message) {
			tabla_alertas_territoriales_por_nna.ajax.reload(null,false);
    		console.log('Ocurrió un error en el datatable de: rpt_alertas_territoriales_por_nna.index.blade.php, el error es: ', message);
		}).DataTable({
			"serverSide": true,
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			//"ajax": "{{ route('rptDataAlertasTerritorialesPorNna') }}",
			"ajax": "{{ route('rptDataAlertasTerritorialesPorNna') }}/"+comunas+'/'+tip_ale+'/'+fec_ini+'/'+fec_fin,
			"columns": [
				{
				 "data": "ale_tip_nom",
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
				$('#grafico_alertas_territoriales_por_nna').highcharts({
		            data: {
		                table: 'tabla_alertas_territoriales_por_nna'
		            },
		            chart: {
		                type: 'pie'
		            },
		            title: {
		                text: 'Alertas Territoriales por NNA'
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
		
		
		//$("#xls_reporte1").click( function () {
		//	window.location.assign("{{ route('rptExportAlertasTerritorialesPorNna') }}");
		//});

	});

	function descargarReportePorNNA(){
			let chkcomuna	= new Array();
			$.each($('#chkcomuna option:selected'), function(){ chkcomuna.push($(this).val()); });
			comunas			= chkcomuna.join(',');
			fec_ini 		= $('#fec_ini').val();
			fec_fin 		= $('#fec_fin').val();
			if($('#tip_ale').val() > 0){
				tip_ale = $('#tip_ale').val();
			}else{
				tip_ale = 0;
			}
			window.location.assign("{{ route('rptExportAlertasTerritorialesPorNna') }}" + "/" + comunas+'/'+tip_ale+'/'+fec_ini+'/'+fec_fin);
			//window.location.assign("{{ route('rptExportAlertasTerritorialesPorNna') }}");
	}

</script>
