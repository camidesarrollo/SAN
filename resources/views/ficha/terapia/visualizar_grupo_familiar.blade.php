<div class="table-responsive">
		<table class="table table-bordered table-hover table-striped text-center" id="visualizar_grupo_familiar">
			<thead>
			<tr>
				<th>RUN</th>
				<th>Nombres</th>
				<th>Apellido</th>
				<th>Parentesco</th>
				<th>Edad</th>
				<!--<th>Estado</th>-->
			</tr>
			</thead>
			<tbody></tbody>
		</table>
</div>
<script type="text/javascript">
	function visualizarGrupoFamiliar(caso_id){
		let data_grupoFamiliar = $('#visualizar_grupo_familiar').DataTable();

		data_grupoFamiliar.destroy();

		let data = new Object();
		data.caso_id = caso_id;
		data.grupo_familiar_activo = true;

		data_grupoFamiliar =	$('#visualizar_grupo_familiar').DataTable({
			"colReorder": true,
			"fixedHeader": { header:true },
			"dom": '<lf<t>ip>',
			//"language"	: { "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json" },
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			"processing": true,
			"serverSide": false,
			"paging"    : false,
			"ordering"  : false,
			"searching" : false,
			"info"		: false,
			"ajax"		: { "url" :	"{{ route('listar.grupo.familiar') }}", "type": "GET",  "data": data },
			"createdRow": function( row, data, dataIndex ){},
			"columns"	: [
				/*{
					"data": "N°", //N°
					"width": "10px",
					"className": "text-center verticalText",
					"render": function(data, type, row, dataIndex){
						let cant = dataIndex.row + 1;

						return cant;
					}
				},*/
				{
					"data": "gru_fam_run", //RUN
					"className": "text-center verticalText",
					'render': function (data, type, full, meta) {
						let dv = obtenerDv(data);
						let run = formatearRun(data+"-"+dv);

						return run;
					}
				},
				{
					"data":'gru_fam_nom', //NOMBRE
					"className": "text-center verticalText",
					"render": function(data, type, row){
						return primeraLetraMayuscula(data);
					}
				},
				{
					"data":'gru_fam_ape_pat', //Apellidos
					"className": "text-center verticalText",
					'render': function (data, type, row, meta) {
						let paterno = primeraLetraMayuscula(data);
						let materno = primeraLetraMayuscula(row.gru_fam_ape_mat);

						return paterno+" "+materno;
					}
				},
				{
					"data": "par_gru_fam_nom", //Parentesco
					"className": "text-center verticalText",
					"render" : function (data, type, row){
                        return primeraLetraMayuscula(data);
					}
				},
				{
					"data": "gru_fam_nac", //EDAD
					"className": "text-center verticalText",
					'render': function (data, type, full, meta) {
						return calcularEdad(data);
					}
				}/*,
				{
					"data": "gru_fam_est", //Estado
					"className": "text-center verticalText",
					"render" : function (data, type, row){
						let html = '<p class="text-success"><strong>Vigente</strong></p>';

						if (data == 0) html = '<p class="text-danger"><strong>No vigente</strong></p>';


						return html;
					}
				}*/
			],
			"drawCallback": function (settings){}
		});

		$('#visualizar_grupo_familiar').addClass("headerTablas");

		$('#visualizar_grupo_familiar').find("thead th").removeClass("sorting_asc");
	}
</script>