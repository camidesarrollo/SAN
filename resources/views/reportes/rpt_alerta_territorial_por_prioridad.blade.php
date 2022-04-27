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
			<table class="table table-striped table-hover encabezado_datatable cell-border w-100" cellspacing="0" id="tabla_prioridad_alertas">
				<thead>
				<tr>
					<th class="text-center" style="width: 100px;">RUN</th>
					<th class="text-center">Edad</th>
					<th class="text-center">Sexo</th>
					<th class="text-center">Cantidad de <br>Alertas CHCC</th>
					<th class="text-center">Cantidad de <br>Alertas Territoriales</th>
					<th class="text-center">Prioridad</th>
					<th class="text-center">Región</th>
					<th class="text-center">Comuna</th>
					<th class="text-center">RUTSINFORMATO</th>
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

        dataTable_prioridadAlerta = $("#tabla_prioridad_alertas").on('error.dt', 
		function(e, settings, techNote, message){
			let mensaje = "Ocurrio un error al momento de buscar la información solicitada. Por favor intente nuevamente. (Error: "+message+")";

			console.log(mensaje);
			dataTable_prioridadAlerta.ajax.reload(null,false);
        }).DataTable({
        	"dom": '<lf<t>ip>',
        	"order":[
				[0, "desc"]
			],
			//"processing": true,
			//"serverSide": true,
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			"ajax":{
				//"url":"{{route('rptPrioridadAlerta')}}"
				"url":"{{route('rptPrioridadAlerta')}}/"+comunas
			},
			"columns": [
				{
				 "data": "runconformato",
				 "className": "text-left"
				},
				{
				 "data": "Edad",
				 "className": "text-right"
				},
				{
				 "data": "Sexo",
				 "className": "text-left"
				},
				{
				 "data": "Cantidad_de_Alertas_CHCC",
				 "className": "text-right"
				},
				{
				 "data": "Cantidad_de_Alertas_Territoriales",
				 "className": "text-right"
				},
				{
				 "data": "Prioridad",
				 "className": "text-right"
				},
				{
				 "data": "Region",
				 "className": "text-left"
				},
				{
				 "data": "Comuna",
				 "className": "text-left"
				},
				{
				 "data": "run",
				 "className": "text-left",
				 "visible": false
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
		window.location.assign("{{ route('rptExportPrioridadAlerta') }}" + "/" + comunas);
		//window.location.assign("{{ route('rptExportPrioridadAlerta') }}");
	}


</script>
