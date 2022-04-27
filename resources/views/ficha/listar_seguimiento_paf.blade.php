<div class="table-responsive">
	<table class="table cell-border table-bordered w-100" id="tabla_reporte_gestion">
		<thead>
			<tr>
				<th>N° Reporte</th>
				<th>Fecha de ingreso</th>
				<th>Modalidad</th>
				<th>Observaciones</th>
			</tr>
		</thead>
		<tbody></tbody>
	</table>
</div>
<script type="text/javascript">
	function cargarReporteGestion(){
		let data = new Object();
		data.cas_id = $("#cas_id").val();

		let tabla_reporte_gestion = $("#tabla_reporte_gestion").DataTable();
		tabla_reporte_gestion.clear().destroy();

		tabla_reporte_gestion = $('#tabla_reporte_gestion').DataTable({
			"language" : { "url": "{{ route('index') }}/js/dataTables.spanish.json" },
		    "rowsGroup" : 	[0,1,2,3],
			"ordering": 	false,
			"searching" : 	false,
			"lengthChange": false,
			"info": 		false,
			"pageLength": 	20,
			"ajax" : { 
				"url" : "{{ route('data.reporte.gestion') }}",
				"type": "GET",  
				"data": data
			},
			"columnDefs": [
				{
					"targets": 0,
					"className": 	'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
				{
					"targets": 1,
					"className": 	'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
				{
					"targets": 2,
					"className": 	'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
				{
					"targets": 3,
					"className": 	'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				        $(td).css("word-break", "break-word");
				     
				    }
				}
			],
			"columns":[{ 
				        data: "ai_rgc_n_rep"
				     },
        			 { 
        			 	"data": "ai_rgc_fec_seg"
        			 },
					 { 
        			 	data: "ai_rgc_mod",
        			 	"render": function(data, type, row, dataIndex){
							if (row.ai_rgc_tip_rep == 4) return "Sin información.";

							return data;	
						}
        			 },
       	 			 { 
       	 			 	data: "observacion",
						"render": function(data, type, row, dataIndex){
							
							if (row.ai_rgc_tip_rep == 0) return row.ai_rgc_des;

							return data;	
						}

							
       	 			 }
    		]
		});

		$('#tabla_reporte_gestion').find("thead th").removeClass("sorting_asc");
	}
</script>