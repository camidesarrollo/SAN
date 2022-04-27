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
			<table class="table table-striped table-hover encabezado_datatable cell-border w-100" cellspacing="0" id="tabla_tiempos_intervencion_tf">
				<thead>
				<tr>
					<th class="text-center" colspan="2"></th>
					<th class="text-center" colspan="4">Fecha de Estado de Intervención</th>
					<th class="text-center" colspan="2"></th>
					<th class="text-center" colspan="4">Cantidad de Días Intervención</th>
				</tr>
				<tr>
					<th class="text-center">ID Caso</th>
					<th class="text-center">Nombre terapueuta<div class="espacio"></div></th>
					<th class="text-center">Fecha de asignación/Prediagnóstico</th>
					<th class="text-center">Diagnóstico</th>
					<th class="text-center">Ejecución</th>
					<th class="text-center">Seguimiento</th>
					<th class="text-center">Cantidad de meses de intervención</th>
					<th class="text-center">Total Días Intervención</th>
					<th class="text-center">Invitación</th>
					<th class="text-center">Diagnóstico</th>
					<th class="text-center">Ejecución</th>
					<th class="text-center">Seguimiento</th>
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
		data.terapeuta = '{{ $terapeuta }}';

		let tabla_at_diagnostico = $('#tabla_tiempos_intervencion_tf').DataTable();
        tabla_at_diagnostico.clear().destroy();
        
        tabla_at_diagnostico = $('#tabla_tiempos_intervencion_tf').DataTable({
            "language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
            "lengthChange": false,
			"info": 		false,
			"searching":	true,
			"paging":		true,
            "ajax": {
                "url": "{{ route('listar.rptTiemposIntervencionTF') }}",
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
				{ //Nombre terapueuta
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
                { //Diagnostico
                    "targets": 3,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //Ejecucion
                    "targets": 4,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //Seguimiento
                    "targets": 5,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //Cantidad de meses de intervencion
                    "targets": 6,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //Total Dias Intervencion
                    "targets": 7,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //Invitacion
                    "targets": 8,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //Diagnostico
                    "targets": 9,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //Ejecucion
                    "targets": 10,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //Seguimiento
                    "targets": 11,
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
						{ //Nombre terapueuta
                            "data": "nombre",
                            "className": "text-center"
                        },
                        { //Fecha de asignacion/Prediagnostico
                            "data": "fecha_asignacion",
                            "className": "text-center"
                        },
                        { //Diagnostico
                            "data": "fecha_diagnostico",
                            "className": "text-center"
                        },
                        { //Ejecucion
                            "data": "fecha_ejecucion",
                            "className": "text-center"
                        },
                        { //Seguimiento
                            "data": "fecha_seguimiento",
                            "className": "text-center"
                        },
                        { //Cantidad de meses de intervencion
                            "data": "meses",
                            "className": "text-center"
                        },
                        { //Total Dias Intervencion
                            "data": "dias",
                            "className": "text-center"
                        },
                        { //Invitacion
                            "data": "dias_invitacion",
                            "className": "text-center"
                        },
                        { //Diagnostico
                            "data": "dias_diagnostico",
                            "className": "text-center"
                        },
                        { //Ejecucion
                            "data": "dias_ejecucion",
                            "className": "text-center"
                        },
                        { //Seguimiento
                            "data": "dias_seguimiento",
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
		window.location.assign("{{ route('rptExportTiemposIntervencionTF') }}" + "/{{ $comunas }}/"+inicio+"/"+fin+"/"+caso+"/{{ $terapeuta }}");
	}
	
	function replaceAll(string, search, replace) {
      return string.split(search).join(replace);
    }

</script>
