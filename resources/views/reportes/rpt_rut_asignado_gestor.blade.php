<div class="card p-4 shadow-sm">

	<div class="row">
		<div class="col-10 text-left">
			<h5><b>{{ $nombre_reporte }}</b></h5>
		</div>
		<div class="col-2 text-right">
			<button class='btn btn-success' id="xls_reporte" name="xls_reporte" onclick="descargarReporteRutAsignadoGestor();">
				<i class="fas fa-download"></i> Descargar
			</button>
		</div>
	</div>
		

	<!--<input id="token" hidden value="{ { csrf_token() }}">-->	
	<!--<h5>Total <span class="badge badge-warning" id="total1">0</span></h5>-->

	<div class="row">
		<div class="table-responsive">
			<table class="table table-striped table-hover encabezado_datatable cell-border w-100" cellspacing="0" id="tabla_rut_asignado_gestor">
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
					<th class="text-center">Nombre Gestor/a</th>
				</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div>
	</div>
			
</div>
<!-- INICIO CZ SPRINT 65 -->
<?php
    $perfil = session()->all()['perfil'];
    $com_id = session()->all()['com_id']; 
?>
<!-- FIN CZ SPRINT 65 -->
<input type="hidden" name="fec_ini" id="fec_ini" value="{{$fec_ini}}">
<input type="hidden" name="fec_fin" id="fec_fin" value="{{$fec_fin}}">
<!-- CZ SPRINT 75 -->
<input type="hidden" name="mes" id="mes" value="{{$año}}">
<input type="hidden" name="año" id="año" value="{{$mes}}">
<!-- CZ SPRINT 75 -->
<script type="text/javascript">
	$(document).ready( function () {

		var idComuna = "<?php echo $com_id; ?>";
		var perfil =  "<?php echo $perfil; ?>";

		let chkcomuna	= new Array();
		$.each($('#chkcomuna2 option:selected'), function(){ chkcomuna.push($(this).val()); });
		chkcomuna		= chkcomuna.join(',');
		console.log('chk_comuna: '+chkcomuna);

		if(perfil == 7){ //ADMINISTRADOR CENTRAL
			comunas			= chkcomuna;
		}else{ 
			comunas = idComuna;
		}
		// FIN CZ SPRINT 65
		
		fec_ini = $('#fec_ini').val();
		fec_fin = $('#fec_fin').val();

		// let filtro = filtro;

		// INICIO CZ SPRINT 75 MANTIS 10067

		let data = new Object();
		data.comunas = comunas;
		data.fec_ini = fec_ini;
		data.fec_fin = fec_fin;
		
		data.tipofecha = {{$tipofecha}};

		var reporte_asignado_gestor = $('#tabla_rut_asignado_gestor').DataTable();
        reporte_asignado_gestor.clear().destroy();	

		reporte_asignado_gestor = $('#tabla_rut_asignado_gestor').DataTable({
			//"fixedHeader": { header:true },
			"dom": '<lf<t>ip>',
			"order":[
				//[2, "desc"],
				[1, "asc"]
			],
			"processing": true,
			"serverSide": true,
			"ajax":{
				"url":"{{ route('rptDataRutAsignadoGestor') }}",
				"data": data,
				//"timeout": 20000,
    			"error" : function(xhr, status){
					console.log(xhr);
					console.log(status);
        			desbloquearPantalla();

			        let mensaje = "Hubo un error al momento de cargar el listado de casos reporte asignado gestor. Por favor intente nuevamente.";
			
			        if (xhr.status === 0){
			          alert(mensaje+"\n\n- Sin conexión: Verifique su red o intente nuevamente.");

			        } else if (xhr.status == 404){
			          alert(mensaje+"\n\n- Página solicitada no encontrada [404].");

			        } else if (xhr.status == 500){
			          alert(mensaje+"\n\n- Error interno del servidor [500].");

			        } else if (tipoError === 'parsererror') {
			          alert(mensaje+"\n\n- Error al manipular respuesta JSON.");

			        } else if (tipoError === 'timeout') {
			          alert(mensaje+"\n\n- Error de tiempo de espera.");

			        } else if (tipoError === 'abort') {
			          alert(mensaje+"\n\n- Solicitud Ajax abortada.");

			        } else {
			          alert(mensaje);
		
			          console.log('Error no capturado: ' + xhr.responseText);
			        }
			
			        console.log(xhr); return false;
    			}
			},
			"rowGroup": {
				startRender: function ( rows, group ) {
                	return "Caso " + group;
				},
            	dataSrc: "cas_id",
        	},
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
				 "data": "caso_creacion",
				 "className": "text-center",
				 'render': function (data, type, full, meta) {
					 return full.fec_cre;
				 }
				},
				{
				 "data": "est_cas_nom",
				 "className": "text-center"
				},
				{
				 "data": "usuario_nomb",
				 "className": "text-left"
				},
			],
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			"drawCallback": function (settings){
				$('[data-toggle="tooltip"]').tooltip();
			}, 
		});

	});
// FIN CZ SPRINT 75 MANTIS 10067
// INICIO CZ SPRINT 75 MANTIS 10067
	function descargarReporteRutAsignadoGestor(){
				// INICIO CZ SPRINT 66
				var idComuna = "<?php echo $com_id; ?>";
		var perfil =  "<?php echo $perfil; ?>";

		let chkcomuna	= new Array();
		$.each($('#chkcomuna2 option:selected'), function(){ chkcomuna.push($(this).val()); });
		chkcomuna		= chkcomuna.join(',');
		console.log('chk_comuna: '+chkcomuna);

		if(perfil == 7){ //ADMINISTRADOR CENTRAL
			comunas			= chkcomuna;
		}else{ 
			comunas = idComuna;
		}	
		// FIN CZ SPRINT 66
		fec_ini = $('#fec_ini').val().replace("/", '-');
		fec_fin = $('#fec_fin').val().replace("/", '-');
		var tipo = {{$tipofecha}};
		// INICIO CZ SPRINT 77
		if(tipo == 0){
			console.log("{{ route('rptExportRutAsignadoGestor') }}" + "/" + comunas+"/"+0+"/"+0+ "/" + tipo);
			window.location.assign("{{ route('rptExportRutAsignadoGestor') }}" + "/" + comunas+"/"+0+"/"+0+ "/" + tipo);
		}else{
		console.log("{{ route('rptExportRutAsignadoGestor') }}" + "/" + comunas+"/"+fec_ini.replace("/", '-')+"/"+fec_fin.replace("/", '-')+ "/" + tipo);
		window.location.assign("{{ route('rptExportRutAsignadoGestor') }}" + "/" + comunas+"/"+fec_ini.replace("/", '-')+"/"+fec_fin.replace("/", '-')+ "/" + tipo);
		
		}
		// FIN CZ SPRINT 77
	}

	// FIN CZ SPRINT 75 MANTIS 10067

</script>


