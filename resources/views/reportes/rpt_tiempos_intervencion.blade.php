<!-- INICIO DC -->
<style>
    .borde{
        border: 1px solid #ccc;
        padding: 5px;
        background-color: #E6E6E6;
    }
    .borde2{
        border: 1px solid #ccc;
        padding: 5px;
    }
    .tabla_tiempo{
        width: 85%;
    }
    .espacio{
        width: 200px;
    }
</style>
<!-- FIN DC -->

<div class="card p-4 shadow-sm tabla_tiempo">
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
			<table class="table table-striped table-hover encabezado_datatable cell-border w-100" cellspacing="0" id="tabla_tiempos_intervencion">
				<thead>
				<tr>
					<th class="text-center" colspan="2"></th>
					<th class="text-center" colspan="6">Fecha de Estado de Intervención</th>
					<th class="text-center" colspan="2"></th>
					<th class="text-center" colspan="6">Cantidad de Días Intervención</th>
				</tr>
				<tr>
					<th class="text-center">ID Caso</th>
					<th class="text-center">Nombre gestor(a)<div class="espacio"></div></th>
					<th class="text-center">Fecha de asignación/Prediagnóstico</th>
					<th class="text-center">Evaluación diagnóstica</th>
					<th class="text-center">Elaboración PAF</th>
					<th class="text-center">Ejecución PAF</th>
					<th class="text-center">Evaluación PAF y Cierre de Caso</th>
					<th class="text-center">Seguimiento PAF</th>
					<th class="text-center">Cantidad Meses Intervención</th>
					<th class="text-center">Total Días Intervención</th>
					<th class="text-center">Prediagnóstico</th>
					<th class="text-center">Evaluación Diagnóstica</th>
					<th class="text-center">Elaboración PAF</th>
					<th class="text-center">Ejecución PAF</th>
					<th class="text-center">Evaluación PAF y Cierre de Caso</th>
					<th class="text-center">Seguimiento PAF</th>
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
		data.fInicio = '{{ $fInicio }}';
		data.fFin = '{{ $fFin }}';
		data.nCaso = '{{ $nCaso }}';
		data.gestor = '{{ $gestor }}';
		
		let tabla_at_diagnostico = $('#tabla_tiempos_intervencion').DataTable();
        tabla_at_diagnostico.clear().destroy();
        
        tabla_at_diagnostico = $('#tabla_tiempos_intervencion').DataTable({
            "language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
            "lengthChange": false,
			"info": 		false,
			"searching":	true,
			"paging":		true,
            "ajax": {
                "url": "{{ route('listar.rptTiemposIntervencion') }}",
                "type": "GET",
                "data": data
            },
            "columnDefs": [
                { //ID Caso
                    "targets": 0,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
				{ //Nombre gestor
                    "targets": 1,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
				{ //Fecha de asignacion/Prediagnostico
                    "targets": 2,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //Evaluacion diagnostica
                    "targets": 3,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //Elaboracion PAF
                    "targets": 4,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //Ejecucion PAF
                    "targets": 5,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //Evaluacion PAF y Cierre de Caso
                    "targets": 6,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //Seguimiento PAF
                    "targets": 7,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //Cantidad Meses Intervencion
                    "targets": 8,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //Total Dias Intervencion
                    "targets": 9,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //Prediagnostico
                    "targets": 10,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //Evaluacion Diagnostica
                    "targets": 11,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //Elaboracion PAF
                    "targets": 12,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //Ejecucion PAF
                    "targets": 13,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //Evaluacion PAF y Cierre de Caso
                    "targets": 14,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //Seguimiento PAF
                    "targets": 15,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                }
            ],				
            "columns": [
                        { //ID Caso
                            "data": "cas_id",
                            "className": "text-center"
                        },
						{ //Nombre gestor
                            "data": "gestor",
                            "className": "text-center"
                        },
                        { //Fecha de asignacion/Prediagnostico
                            "data": "fecha_asignacion",
                            "className": "text-center"
                        },
                        { //Evaluacion diagnostica
                            "data": "fecha_evaluacion_diagnostica",
                            "className": "text-center"
                        },
                        { //Elaboracion PAF
                            "data": "fecha_elaboracion_paf",
                            "className": "text-center"
                        },
                        { //Ejecucion PAF
                            "data": "fecha_ejecucion_paf",
                            "className": "text-center"
                        },
                        { //Evaluacion PAF y Cierre de Caso
                            "data": "fecha_ev_paf_cierre_caso",
                            "className": "text-center"
                        },
                        { //Seguimiento PAF
                            "data": "fecha_seguimiento_paf",
                            "className": "text-center"
                        },
                        { //Cantidad Meses Intervencion
                            "data": "meses",
                            "className": "text-center"
                        },
                        { //Total Dias Intervencion
                            "data": "dias",
                            "className": "text-center"
                        },
                        { //Prediagnostico
                            "data": "dias_prediagnostico",
                            "className": "text-center"
                        },
                        { //Evaluacion Diagnostica
                            "data": "dias_evaluacion_diagnostica",
                            "className": "text-center"
                        },
                        { //Elaboracion PAF
                            "data": "dias_elaboracion_paf",
                            "className": "text-center"
                        },
                        { //Ejecucion PAF
                            "data": "dias_ejecucion_paf",
                            "className": "text-center"
                        },
                        { //Evaluacion PAF y Cierre de Caso
                            "data": "dias_evaluacion_paf_cierre",
                            "className": "text-center"
                        },
                        { //Seguimiento PAF
                            "data": "dias_seguimiento_paf",
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
		var inicio = replaceAll('{{ $fInicio }}', '/', '-'); 
		var fin = replaceAll('{{ $fFin }}', '/', '-'); 
		var caso = '{{ $nCaso }}';
		if(caso == ''){
			caso = 0;
		}
		window.location.assign("{{ route('rptExportTiemposIntervencion') }}" + "/{{ $comunas }}/"+inicio+"/"+fin+"/"+caso+"/{{ $gestor }}");
	}
	
	function replaceAll(string, search, replace) {
      return string.split(search).join(replace);
    }

</script>
