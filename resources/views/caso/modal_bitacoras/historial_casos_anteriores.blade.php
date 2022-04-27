<!-- //CZ SPRINT 73 -->
<div id="frmCasosAnteriores" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content p-4">
            <div class="card p-4 m-0 shadow-sm">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="position: absolute; right: 5px; top: 5px; width: 23px; height: 23px; padding: 0; margin: 0;">&times;</span>
                </button>
                <div class="row">
					<div class="col text-center">
						<h4 class="modal-title"><b>Historial de Casos</b>
						</h4>
						<p id="subti_modal" style="text-align:left"></p>
						<br>
					</div>
				</div>

				<table class="table table-bordered table-hover table-striped w-100" cellspacing="0" id="tabla_casos_anteriores">
							<thead>
								<tr>
									<th class="text-center">Estado</th>
									<th class="text-center">Descripción</th>
									<th class="text-center">Fecha</th>
								</tr>
							</thead>
							<tbody></tbody>
				</table>
				<div id="contenedor-tabs"></div>
                <br>
                <div class="text-right">                    
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>					
            </div>                
        </div>
    </div>
</div>
<script>
    	function infoModalCasos(run_nna){
			//console.log('nnarun: '+run_nna);
			$("#accordionExample").hide();
			$("#subti_modal").hide();
			$('#tabla_casos_anteriores').hide();
			let data = new Object();
        	data.run_nna = run_nna;
			$.ajax({
            	type: "GET",
            	url: "{{route('get.casos.anteriores')}}",
            	data: data
        	}).done(function(resp){
            	console.log(resp);
				if(resp.data.length == 1){
					// INICIO CZ SPRINT 63
					$("#accordionExample").hide();
					$('#subti_modal').show();
					$('#tabla_casos_anteriores').show();
					$('#subti_modal').html('Id Caso: '+resp.data[0].cas_id);
					// FIN CZ SPRINT 63
					let casos_anteriores = $('#tabla_casos_anteriores').DataTable();
					casos_anteriores.clear().destroy(); 
					casos_anteriores =	$('#tabla_casos_anteriores').DataTable({
						"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
						"paging"    : false,
						"ordering"  : false,
						"searching" : false,
						"info"		: false,
						"ajax"		: {
							"url" :	"{{ route('casos.bitacoraCaso') }}"+"/"+resp.data[0].cas_id
						},
						"columns"	: [
							{
							"data": 		"estado_caso",
							"name": 		"estado_caso",
							"width": 		"20px"
							},
							{
							"data": 		"descripcion_bitacora",
							"name": 		"descripcion_bitacora",
							"width": 		"120px"
							},
							{
							"data": 		"fecha_bitacora",
							"name": 		"fecha_bitacora",
							"width": 		"70px"
							}
						],
					});
				}
				else{
					// INICIO CZ SPRINT 63
					$('#tabla_casos_anteriores').hide();
					$("#accordionExample").show();
					$("#subti_modal").hide();
					// FIN CZ SPRINT 63
					htmlTabs = '<div class="card colapsable" id="accordionExample">';
					for(i = 0; i < resp.data.length; i++){
						htmlTabs += '<div class="card colapsable"><a class="text-left p-0" style="cursor:pointer" type="button" data-toggle="collapse" data-target="#collapse'+i+'" aria-expanded="true" aria-controls="collapseOne" onclick="desplegarTablaCasosAnteriores('+resp.data[i].cas_id+')"><div class="card-header p3" id="headingOne"><h5 class="mb-0"><button class="btn btn-info" type="button" data-toggle="collapse" data-target="#collapse'+i+'" aria-expanded="true" aria-controls="collapseOne" onclick="desplegarTablaCasosAnteriores('+resp.data[i].cas_id+')"><i class="fa fa-info"></i></button> ID Caso:'+resp.data[i].cas_id;
						htmlTabs += '</h5></div></a><div id="collapse'+i+'" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample"><div class="card-body"><table class="table table-bordered table-hover table-striped w-100" cellspacing="0" id="tabla_ca'+resp.data[i].cas_id+'">';
						htmlTabs += '<thead><tr><th class="text-center">Estado</th><th class="text-center">Descripción</th><th class="text-center">Fecha</th></tr></thead><tbody></tbody></table></div></div></div>';
					}
					htmlTabs += '</div>';
					$("#contenedor-tabs").html(htmlTabs);
				}
            
        	}).fail(function(objeto, tipoError, errorHttp){            
           
            	manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

            	return false;
        	});

			$("#frmCasosAnteriores").modal('show');
		}
function desplegarTablaCasosAnteriores(id_caso){
	
	let casos_anteriores = $('#tabla_ca'+id_caso).DataTable();
	casos_anteriores.clear().destroy(); 
	casos_anteriores =	$('#tabla_ca'+id_caso).DataTable({
		"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
		"paging"    : false,
		"ordering"  : false,
		"searching" : false,
		"info"		: false,
		"ajax"		: {
			"url" :	"{{ route('casos.bitacoraCaso') }}"+"/"+id_caso
		},
		"columns"	: [
			{
			"data": 		"estado_caso",
			"name": 		"estado_caso",
			"width": 		"20px"
			},
			{
			"data": 		"descripcion_bitacora",
			"name": 		"descripcion_bitacora",
			"width": 		"120px"
			},
			{
			"data": 		"fecha_bitacora",
			"name": 		"fecha_bitacora",
			"width": 		"70px"
			}
		],
	});

}

</script>
<!-- //CZ SPRINT 73 -->