<div class="card p-4 shadow-sm">
	<div class="row">
		<div class="col-10 text-left">
			<h5><b>{{ $nombre_reporte }}</b></h5>
		</div>
		<div class="col-2 text-right">
			<button class='btn btn-success' onclick="descargarReportePrioridadAlerta();">
			   <i class="fas fa-download"></i> Descargar
			</button>
		</div>
	</div>	
	

	<div class="row">
		<div class="table-responsive">
			<table class="table table-striped table-hover encabezado_datatable cell-border w-100" cellspacing="0" id="tabla_g_c_documentos">
				<thead>
				<tr>
					<th class="text-center">Tipo de documento</th>
					<th class="text-center">Cantidad de documentos</th>
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
<script type="text/javascript">
	$(document).ready(function(){

		let chkcomuna	= new Array();
		$.each($('#chkcomuna option:selected'), function(){ chkcomuna.push($(this).val()); });
		comunas			= chkcomuna.join(',');

        let data = new Object();
		data.comunas = '{{ $comunas }}';

		let tabla_at_diagnostico = $('#tabla_g_c_documentos').DataTable();
        tabla_at_diagnostico.clear().destroy();
        
        tabla_at_diagnostico = $('#tabla_g_c_documentos').DataTable({
            "language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
            "lengthChange": false,
			"info": 		false,
			"searching":	true,
			"paging":		true,
            "ajax": {
                "url": "{{ route('listar.rptPlanComunalDocumentos') }}",
                "type": "GET",
                "data": data
            },
            "columnDefs": [
                { //Hito
                    "targets": 0,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
				{ //Tipo de actor
                    "targets": 1,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                }
            ],				
            "columns": [
                        { //TIPO DE ALERTAS
                            "data": "tip_nom",
                            "className": "text-center"
                        },
						{ //CANTIDAD
                            "data": "cantidad",
                            "className": "text-center"
                        }
                    ]
            });

	});	

	function descargarReportePrioridadAlerta(){
		let chkcomuna	= new Array();
		// INICIO CZ SPRINT 69 MANTIS 9810
		$.each($('#chkcomuna4 option:selected'), function(){ chkcomuna.push($(this).val()); });
		comunas			= chkcomuna.join(',');
		// FIN CZ SPRINT 69
		window.location.assign("{{ route('rptExportPlanComunalDocumentos') }}" + "/{{ $comunas }}");
	}


</script>
