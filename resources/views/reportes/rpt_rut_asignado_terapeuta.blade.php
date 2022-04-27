<!-- INICIO CZ SPRINT 66 -->
<?php
    $perfil = session()->all()['perfil'];
    $com_id = session()->all()['com_id']; 
?>
<!-- FIN CZ SPRINT 66 -->

<div class="card p-4 shadow-sm">

	<div class="row">
		<div class="col-10 text-left">
			<h5><b>{{ $nombre_reporte }}</b></h5>
		</div>
		<div class="col-2 text-right">
			<button class='btn btn-success' id="xls_reporte" name="xls_reporte" onclick="descargarReporteRutAsignadoTerapeuta();">
				<i class="fas fa-download"></i> Descargar
			</button>
		</div>
	</div>
		

	<!--<input id="token" hidden value="{ { csrf_token() }}">-->	
	<!--<h5>Total <span class="badge badge-warning" id="total1">0</span></h5>-->

	<div class="row">
		<div class="table-responsive">
			<table class="table table-striped table-hover encabezado_datatable cell-border w-100" cellspacing="0" id="tabla_rut_asignado_terapeuta">
				<thead>
				<tr>
					<th class="text-center">RUNSINFORMATO</th>
					<th class="text-center" style="width: 75px;">RUN</th>
					<th class="text-center">Prioridad</th>
					<th class="text-center">Cantidad de Alertas<br>Territoriales</th>
					<th class="text-center">Cantidad de Alertas<br>ChCC Homologadas</th>
					<th class="text-center">Comuna</th>
					<th class="text-center">Región</th>
					<th class="text-center">ID Caso</th>
					<th class="text-center">Fecha Asignación</th>
					<th class="text-center">Estado</th>
					<th class="text-center">Nombre Terapeuta</th>
				</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div>
	</div>
			
</div>
<input type="hidden" name="fec_ini" id="fec_ini" value="{{$fec_ini}}">
<input type="hidden" name="fec_fin" id="fec_fin" value="{{$fec_fin}}">
<!-- INICIO CZ SPRINT 66 -->
<?php
    $perfil = session()->all()['perfil'];
    $com_id = session()->all()['com_id']; 
?>
<!-- FIN CZ SPRINT 66 -->
<script type="text/javascript">
	$(document).ready( function () {

		//let data 		= new Object();
		let chkcomuna	= new Array();
		// INICIO CZ SPRINT 66
		var idComuna = "<?php echo $com_id; ?>";
		var perfil =  "<?php echo $perfil; ?>";

		var comunas;

		$.each($('#chkcomuna2 option:selected'), function(){ chkcomuna.push($(this).val()); });
		chkcomuna		= chkcomuna.join(',');

		if(perfil == 7){ //ADMINISTRADOR CENTRAL
			comunas			= chkcomuna;
		}else{ 
			comunas = idComuna;
		}
		// FIN CZ SPRINT 66
		
		fec_ini = $('#fec_ini').val();
		fec_fin = $('#fec_fin').val();
		//data.comunas 	= comunas;

		tabla_rut_asignado_terapeuta = $('#tabla_rut_asignado_terapeuta').on('error.dt',
		function (e, settings, techNote, message) {
			tabla_rut_asignado_terapeuta.ajax.reload(null,false);
    		console.log('Ocurrió un error en el datatable de: rpt_rut_asignado_terapeuta.index.blade.php, el error es: ', message);
		}).DataTable({
			"order":[
				[ 2, "desc" ]
			],
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			"ajax": "{{ route('rptDataRutAsignadoTerapeuta') }}/"+comunas+'/'+fec_ini+'/'+fec_fin,
			"columns": [
				{
					 "data": 		"nna_run",
					 "name": 		"nna_run",
					 "visible": 	false
				},
				{
				 "data": "nna_run_con_formato",
				 "className": "text-left"
				},
				{
				 "data": "score",
				 "className": "text-right"
				},
				{
				 "data": "alertas_territoriales",
				 "className": "text-right"
				},
				{
				 "data": "alertas_chcc",
				 "className": "text-right"
				},
				{
				 "data": "com_nom",
				 "className": "text-left"
				},
				{
				 "data": "reg_nom",
				 "className": "text-left"
				},
				{
				 "data": "cas_id",
				 "className": "text-right"
				},
				{
				 "data": "tera_est_tera_fec",
				 "className": "text-center",
                 "render": function(data, type, row){
                        let fec = new Date(data);
                        fec = fec.getDate()+"-"+(fec.getMonth() + 1 )+"-"+fec.getFullYear();
                        
                        return fec;
                    }
				},
				{
				 "data": "est_tera_nom",
				 "className": "text-center"
				},
				{
				 "data": "usuario_nomb",
				 "className": "text-left"
				},
			],
			"drawCallback": function (settings){
				$("#total1").text(settings._iRecordsTotal);
			}
		});

	});

	function descargarReporteRutAsignadoTerapeuta(){
		let chkcomuna	= new Array();
			// INICIO CZ SPRINT 66
			var idComuna = "<?php echo $com_id; ?>";
		var perfil =  "<?php echo $perfil; ?>";

		var comunas;

		$.each($('#chkcomuna2 option:selected'), function(){ chkcomuna.push($(this).val()); });
		chkcomuna		= chkcomuna.join(',');

		if(perfil == 7){ //ADMINISTRADOR CENTRAL
			comunas			= chkcomuna;
		}else{ 
			comunas = idComuna;
		}
		// FIN CZ SPRINT 66
		fec_ini = $('#fec_ini').val();
		fec_fin = $('#fec_fin').val();
		window.location.assign("{{ route('rptExportRutAsignadoTerapeuta') }}" + "/" + comunas+'/'+fec_ini+'/'+fec_fin);
		
	}

</script>


