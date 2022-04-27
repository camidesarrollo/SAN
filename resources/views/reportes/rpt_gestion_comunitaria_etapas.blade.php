<style>
    .borde{
        border: 1px solid #ccc;
        padding: 5px;
        background-color: #E6E6E6;
    }
    .borde2{
        border: 1px solid #ccc;
        padding: 5px;
    }
</style>
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
			<table>
				<tr>
					<td class="borde"><b>Nombre Etapa</b></td>
					<td class="borde"><b>Estuvo en la etapa</b></td>
					<td class="borde"><b>Cantidad de días en etapa</b></td>
					<td class="borde"><b>Cantidad de registros</b></td>
				</tr>
				@php $pro_an_id = Helper::getProceso($comunas); @endphp
				@php $etapas = Helper::getEtapas(); @endphp
				@foreach($etapas as $value)
					@php $et = Helper::estuvoEtapa($pro_an_id[0]->pro_an_id, $value->est_pro_id); @endphp
					@php $cant = Helper::diasEtapa($pro_an_id[0]->pro_an_id, $value->est_pro_id); @endphp
				<tr>
					<td class="borde2">{{$value->est_pro_nom}}</td>
					<td class="borde2">
					@php
						if($et[0]->existe == 0){
							echo 'No';
						}else{
							echo 'Sí';
						}
					@endphp
					</td>
					<td class="borde2">{{$cant}}</td>
					<td class="borde2">
					@php
						if($et[0]->existe != 0){
							if($value->est_pro_id == 6){ //L�nea Base
    							$cantLB = Helper::cantidadLineaBase($pro_an_id[0]->pro_an_id);
    							echo $cantLB[0]->cantidad;
    						}else if($value->est_pro_id == 11){ //Linea Salida
    							$cantLS = Helper::cantidadLineaSalida($pro_an_id[0]->pro_an_id);
    							echo $cantLS[0]->cantidad;
    						}else{
    							echo 'No aplica';
    						}
						}
					@endphp
					</td>
				</tr>
				@endforeach
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
		data.comunas = 'test';

		let tabla_at_diagnostico = $('#tabla_g_c_documentos').DataTable();
        tabla_at_diagnostico.clear().destroy();
        
        tabla_at_diagnostico = $('#tabla_g_c_documentos').DataTable({
            "language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
            "lengthChange": false,
			"info": 		false,
			"searching":	true,
			"paging":		true,
            "ajax": {
                "url": "{{ route('listar.rptPlanComunalDocumentos') }}",
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
                }
            ],				
            "columns": [
                        { //TIPO DE ALERTAS
                            "data": "tip_nom",
                            "className": "text-center"
                        },
						{ //CANTIDAD
                            "data": "cantidad",
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
		window.location.assign("{{ route('rptExportGestionComunitariaEtapas') }}" + "/" + comunas);
		
	}


</script>
