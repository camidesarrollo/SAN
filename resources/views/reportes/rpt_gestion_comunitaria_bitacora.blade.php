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
			<table class="table table-striped table-hover encabezado_datatable cell-border w-100" cellspacing="0" id="tabla_g_c_bitacora">
				<thead>
				<tr>
					<th class="text-center" style="width: 200px;">Hito</th>
					<th class="text-center">Tipo de actor</th>
					<th class="text-center">Cantidad de <br>actividades</th>
					<th class="text-center">Cantidad de <br>participantes</th>
					<th class="text-center">N° NNA</th>
					<th class="text-center">N° Adultos</th>
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
		data.comunas = '{{$comunas}}';
		

		let tabla_at_diagnostico = $('#tabla_g_c_bitacora').DataTable();
        tabla_at_diagnostico.clear().destroy();
        
        tabla_at_diagnostico = $('#tabla_g_c_bitacora').DataTable({
            "language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
            "lengthChange": false,
			"info": 		false,
			"searching":	true,
			"paging":		true,
            "ajax": {
                "url": "{{ route('listar.rptGestionComunitariaBitacora') }}",
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
                },
                { //Cantidad de actividades
                    "targets": 2,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //Cantidad de participantes
                    "targets": 3,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //N NNA
                    "targets": 4,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                        
                    
                    }
                },
                { //N Adultos
                    "targets": 5,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                        
                    
                    }
                }
            ],				
            "columns": [
                        { //TIPO DE ALERTAS
                            "data": "cb_hito_nom",
                            "className": "text-center"
                        },
						{ //CANTIDAD
                            "data": "cb_tip_act_nom",
                            "className": "text-center"
                        },
                        { //ACCIONES
                            "data": "actividad",
                            "className": "text-center"                           
                        },
                        { //ESTADO
                            "data": "num_part",
                            "className": "text-center"
                        },
                        { //INFORMACION RELEVANTE
                            "data": "act_num_nna",
                            "className": "text-center"
                        },
                        { //DIMENSION
                            "data": "num_adult",
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
		window.location.assign("{{ route('rptExportGestionComunitariaBitacora') }}" + "/{{$comunas}}");
	}


</script>
