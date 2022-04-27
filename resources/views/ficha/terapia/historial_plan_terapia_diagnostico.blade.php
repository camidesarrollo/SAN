<div class="container">
	<div class="table-responsive">
		<table class="table"  style="width: 100%;" id="listar_plan_terapia_familiar">
			<thead>
				<tr>
					<th>Fecha Creación</th>
					<th>Nombre Documento</th>
					<th>Descargar</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
	</div>
</div>
<script type="text/javascript">
	function buscarHistorialPlanTerapiaFamiliar(tera_id){
		let data_listar_terapia = $("#listar_plan_terapia_familiar").DataTable();

		data_listar_terapia.destroy();

		let data 		= new Object();
		data.tera_id 	= tera_id;

		data_listar_terapia = $('#listar_plan_terapia_familiar').DataTable({
			"colReorder": true,
			"fixedHeader": { header:true },
			"dom": '<lf<t>ip>',
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			"processing": true,
			"serverSide": false,
			"paging"    : false,
			"ordering"  : false,
			"searching" : false,
			"info"		: false,
			"ajax"		: { 
				"type": "GET",  
				"data": data, 
				"url" :	"{{ route('listar.historial.plan.terapia') }}", 
			},
			"createdRow": function( row, data, dataIndex ){},
			"columns"	: [
				{ 
				  "data": "doc_fir_pla_ter_fec", 
				  "className": "text-center",
				  "render" : function (data, type, row){
				  	let fecha = new Date(data);
				  	let dia = fecha.getDate();
				  	let mes = (fecha.getMonth() + 1);
				  	let hora = fecha.getHours();
				  	let minutos = fecha.getMinutes();
				  	let segundos = fecha.getSeconds();

				  	if (dia < 10) dia = "0" + dia;
				  	if (mes < 10) mes = "0" + mes;
				  	if (hora < 10) hora = "0" + hora;
				  	if (minutos < 10) minutos = "0" + minutos;
				  	if (segundos < 10) segundos = "0" + segundos;
				  	

				  	//let fecha_formateada = fecha.getDate()+"-"+(fecha.getMonth() + 1)+"-"+fecha.getFullYear()+" "+fecha.getHours()+":"+fecha.getMinutes()+":"+fecha.getSeconds();

				  	let fecha_formateada = dia+"-"+mes+"-"+fecha.getFullYear()+" "+hora+":"+minutos+":"+segundos;

					return fecha_formateada;	
				  }
				},
				{ "data": "doc_fir_pla_ter_arc", "className": "text-center" },
				{
				  "data": "",
				  "className": "text-center",
				  "render" : function (data, type, row){
				  	//INICIO DC
					return 	'<i class="fa fa-download" aria-hidden="true"></i> <a href="{{config('constantes.app_url')}}/doc/'+row.doc_fir_pla_ter_arc+'" target="_blank" >Descargar</a>';	
				  	//FIN DC
				  }
				}
			],
			"drawCallback": function (settings){}
		});

		$('#listar_plan_terapia_familiar').addClass("headerTablas");

		$('#listar_plan_terapia_familiar').find("thead th").removeClass("sorting_asc");
	}
</script>