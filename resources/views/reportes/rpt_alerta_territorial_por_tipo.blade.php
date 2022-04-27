

<div class="card p-4 shadow-sm">
		<div class="row">
			<div class="col-10 text-left">
				<h5><b>{{ $nombre_reporte }}</b></h5>
			</div>
			<div class="col-2 text-right">
				<button class='btn btn-success' onclick="descargarReporteAlertasTipoDetalle();">
				   <i class="fas fa-download"></i> Descargar
				</button>
			</div>
		</div>
		
		<div class="row">
			<div class="table-responsive">
				<table class="table table-striped table-hover encabezado_datatable cell-border w-100" cellspacing="0" id="tabla_alertas_territoriales_tipo_detalle">
					<thead>
					<tr>
						<th class="text-center" style="width: 400px;">Tipo de Alerta Territorial</th>
						<th class="text-center" style="width: 120px;">Sectorialista</th>
						<th class="text-center" style="width: 120px;">Fecha de Ingreso Alerta</th>
						<th class="text-center" style="width: 120px;">Rut NNA</th>
						<th class="text-center">RUTSINFORMATO</th>
						<th class="text-center">Comuna</th>
						<th class="text-center" style="width: 120px;">Fecha Asignación Caso</th>
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
<input type="hidden" name="fec_ini" id="fec_ini" value="{{$fec_ini}}">
<input type="hidden" name="fec_fin" id="fec_fin" value="{{$fec_fin}}">
<input type="hidden" name="tip_ale" id="tip_ale" value="{{$tip_ale}}">

<script type="text/javascript">
	$(document).ready(function(){

		let chkcomuna = new Array();
		$.each($('#chkcomuna option:selected'), function(){chkcomuna.push($(this).val())});
		comunas = chkcomuna.join(',');
		fec_ini = $('#fec_ini').val();
		fec_fin = $('#fec_fin').val();
		if($('#tip_ale').val() > 0){
			tip_ale = $('#tip_ale').val();
		}else{
			tip_ale = 0;
		}
		console.log(comunas);

        dataTable_alertasTipoDetalle = $("#tabla_alertas_territoriales_tipo_detalle").on('error.dt', 
		function(e, settings, techNote, message){
			let mensaje = "Ocurrio un error al momento de buscar la información solicitada. Por favor intente nuevamente. (Error: "+message+")";

			console.log(mensaje);
			dataTable_alertasTipoDetalle.ajax.reload(null,false);
        }).DataTable({
        	"dom": '<lf<t>ip>',
        	"order":[
				[1, "desc"]
			],
			//"processing": true,
			//"serverSide": true,
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			"ajax":{
				//"url":"{{route('rptDataAlertasTerritorialesInfoTipoAlerta')}}"
				"url":"{{route('rptDataAlertasTerritorialesInfoTipoAlerta')}}/" +comunas+'/'+tip_ale+'/'+fec_ini+'/'+fec_fin 
			},
			"columns": [
				{
				 "data": "ale_tip_nom",
				 "className": "text-left"
				},
				{
				 "data": "nombre",
				 "className": "text-left"
				},
				{
				 "data": "ale_man_fec",
				 "className": "text-left"
				},
				{
				 "data": "ale_man_run_con_formato",
				 "className": "text-left"
				},
				{
				 "data": "ale_man_run_sin_formato",
				 "className": "text-left",
				 "visible": false
				},
				{
				 "data": "com_nom",
				 "className": "text-left"
				},
				{
				 "data": "ale_ing_nomina",
				 "className": "text-left", 
				 "render": function(data, type, row){ 
				 		if (data != null){
							 return data;
						 }else{
							 return "Sin asignar"
						 }
				 	}
				}
			]
        });

	});	

	function descargarReporteAlertasTipoDetalle(){

		let chkcomuna = new Array();
		$.each($('#chkcomuna option:selected'), function(){chkcomuna.push($(this).val())});
		comunas = chkcomuna.join(',');
		fec_ini = $('#fec_ini').val();
		fec_fin = $('#fec_fin').val();
		if($('#tip_ale').val() > 0){
			tip_ale = $('#tip_ale').val();
		}else{
			tip_ale = 0;
		}
		window.location.assign("{{ route('rptExportAlertasTerritorialesInfoTipoAlerta') }}/" + comunas+'/'+tip_ale+'/'+fec_ini+'/'+fec_fin);
		//window.location.assign("{{ route('rptExportAlertasTerritorialesInfoTipoAlerta') }}");
	}
</script>
