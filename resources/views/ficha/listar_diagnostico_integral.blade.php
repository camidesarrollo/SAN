
<!--<div class="container-fluid collapse" id="listar_diagnostico_integral">-->
		<table class="table table-sm" id="tabla_diagnostico_integral">
			<thead>
				<tr>
					<th>Dimensión</th>
					<th style="text-align: center">Sub Escala con Deficiencia</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
		
<br>






<script type="text/javascript">
	function listarDiagnosticoIntegral(caso_id){
		let data_diagnosticoIntegral = $('#tabla_diagnostico_integral').DataTable();
		data_diagnosticoIntegral.destroy();

		let data = new Object();
		data.caso_id = caso_id;

		data_diagnosticoIntegral =	$('#tabla_diagnostico_integral').DataTable({
			//"fixedHeader": { header:true },
			//"dom": '<lf<t>ip>',
			//"language"	: { "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json" },
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			"processing": true,
			"serverSide": false,
			"paging"    : false,
			"ordering"  : false,
			"searching" : false,
			"info"		: false,
			"ajax"		: { "url" :	"{{ route('dimension.listar.resultado') }}", "type": "GET",  "data": data },
			"createdRow": function( row, data, dataIndex ){
				//console.log("que sucede?", row, data, dataIndex);
			},
			"columns"	: [
				{
					"data": 		"dim_enc_nom", //Dimensión
					"className": 	"text-center font-weight-bold border",
					"width": 		"20%"
				},
				{
					"data": 		"nom_var", //Pregunta
					"className": 	"border",
					"width": 		"80%",
					"render": function(data, type, row){
						let html = 	'<table class="table table-sm m-0" width="100%">';
							html += '<tr>';															
							html +=	'<td width="30%">'+data+'</td>';							
							html +=	'<td>';								
							html +=	'<div class="progress">';
							html += '<div class="progress-bar progress-bar-striped '; 
							html +=	'progress-bar-animated text-left pl-1 ';

							if (row.alt_val == "-1"){
								html += 'bg-warning"';
								html +=	'style="width: 25%;" aria-valuenow="25" '; 

							}else if (row.alt_val == "-2"){
								html += 'bg-orange-pro"';
								html +=	'style="width: 50%;" aria-valuenow="50" '; 

							}else if (row.alt_val == "-3"){
								html += 'bg-danger"';
								html +=	'style="width: 100%;" aria-valuenow="100" '; 

							}

							html += 'role="progressbar" aria-valuemin="0" aria-valuemax="100">';
							html += '<small>'+row.alt_nom+' ('+row.alt_val+')</small>';
							html += '</div></div></td>';								
							html += '</tr></table>';

						return html;
					}
				}
			],
			"rowsGroup" : [0],
			"columnDefs": [{"className": "dt-center", "targets": [0]},
						   {"className": "dt-center", "targets": [1]}],
		});

		//$('#tabla_diagnostico_integral').addClass("headerTablas");

		$('#tabla_diagnostico_integral').find("thead th").removeClass("sorting_asc");
	}
</script>
<style type="text/css">
	.bg-orange-pro{
		background-color: #FD7D0B;
	}

	#tabla_diagnostico_integral > tbody > tr > td {
     	vertical-align: middle;
	}
</style>