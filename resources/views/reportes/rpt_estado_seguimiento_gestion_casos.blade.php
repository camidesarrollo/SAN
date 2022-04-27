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
			<button class='btn btn-success' id="xls_reporte" name="xls_reporte" onclick="descargarReporte();">
				<i class="fas fa-download"></i> Descargar
			</button>
		</div>
	</div>
		

	<!--<input id="token" hidden value="{{ csrf_token() }}">-->
		
	<div class="row">
		<div class="table-responsive">
			<table class="table table-striped table-hover encabezado_datatable cell-border w-100" cellspacing="0" id="tabla_registros_seguimiento_caso">
				<thead>
					<tr>
						<th rowspan="2" style="text-align: center;width: 60%">Nombre Gestor</th>
						<th colspan="4" style="text-align: center;">Seguimiento</th>
						<th rowspan="2" style="text-align: center;width: 60%">Total de casos egresados</th>
					</tr>

					<tr>
						<th style="text-align: center;width: 10%">Llamado Telefónico</th>
						<th style="text-align: center;width: 10%">Visita Domiciliaria</th>
						<th style="text-align: center;width: 10%">Revisión de Plataforma</th>
						<th style="text-align: center;width: 10%">Total</th>
					</tr>
					</thead>
				<tbody>
					@foreach ($registros AS $c1 => $v1)
						<tr>
							<td>{{ $v1->nombre_gestor}}</td>
							<td>{{ $v1->llamadas}}</td>
							<td>{{ $v1->visitas}}</td>
							<td>{{ $v1->revision}}</td>
							<td>{{ $v1->total}}</td>
							<td>{{ $v1->casos_egresados}}</td>
						</tr>
					@endforeach
				</tbody>
				
				<tfoot>
					<tr>
						<th>Total</th>
							<th style="text-align: right;padding: 10px;">0</th>
							<th style="text-align: right;padding: 10px;">0</th>
							<th style="text-align: right;padding: 10px;">0</th>
							<th style="text-align: right;padding: 10px;">0</th>
							<th style="text-align: right;padding: 10px;">0</th>
					</tr>
					</tfoot>

			</table>
		</div>

		<div class="col-md-12">
		<h7>Promedio mensual de visitas domiciliarias <span class="badge badge-warning" id="promedio_presencial">0</span></h7>
		</div>

		<div class="col-md-12">
		<h7>Promedio mensual de llamados telefónicos <span class="badge badge-warning" id="promedio_telefonico">0</span></h7>
		</div>

		<div class="col-md-12">
		<h7>Promedio mensual de revision de plataforma <span class="badge badge-warning" id="promedio_revision">0</span></h7>
		</div>

		<div class="col-md-12">
			<div id="grafico_casos_desestimados" style="width: 100%; height: 350px;"></div>
		</div>	
	</div>

</div>
<input type="hidden" name="fec_ini" id="fec_ini" value="{{$fec_ini}}">
<input type="hidden" name="fec_fin" id="fec_fin" value="{{$fec_fin}}">

<script type="text/javascript">
	$(document).ready( function () {

		let chkcomuna	= new Array();
		$.each($('#chkcomuna option:selected'), function(){ chkcomuna.push($(this).val()); });
		comunas			= chkcomuna.join(',');

		tabla_registros_seguimiento_caso = $('#tabla_registros_seguimiento_caso').DataTable({
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},

			 footerCallback: function ( row, data, start, end, display ) {
        		var api = this.api(), data;

	            // Remove the formatting to get integer data for summation
	            var intVal = function ( i ) {
	                return typeof i === 'string' ?
	                    i.replace(/[\$,]/g, '')*1 :
	                    typeof i === 'number' ?
	                        i : 0;
	            };

	            var columnas = tabla_registros_seguimiento_caso.columns(':visible').count();

				for (var i = 1; i <= columnas-1; i++) {
		            // Total over all pages
		            total = api
		                .column( i )
		                .data()
		                .reduce( function (a, b) {
		                    return intVal(a) + intVal(b);
		                }, 0 );

	            	$( api.column( i ).footer() ).html(total);

				}

	            var total_registros = tabla_registros_seguimiento_caso.rows().count();

	            total_telefonico = api
		                .column( 1 )
		                .data()
		                .reduce( function (a, b) {
		                    return intVal(a) + intVal(b);
		                }, 0 );

	            total_presencial = api
		                .column( 2 )
		                .data()
		                .reduce( function (a, b) {
		                    return intVal(a) + intVal(b);
		                }, 0 );

				total_revision = api
		                .column( 3 )
		                .data()
		                .reduce( function (a, b) {
		                    return intVal(a) + intVal(b);
		                }, 0 );

		        promedio_telefonico = (total_telefonico/total_registros).toFixed(2);

		        promedio_presencial = (total_presencial/total_registros).toFixed(2);

				promedio_revision = (total_revision).toFixed(2);

		        $('#promedio_telefonico').text(promedio_telefonico);
		        $('#promedio_presencial').text(promedio_presencial);
				$('#promedio_revision').text(promedio_revision);//pendiente


    		}

		});

	});

	function descargarReporte(){
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
		window.location.assign("{{ route('rptExportEstadoSeguimientoGestionCasos') }}" + "/" + comunas+ "/" + fec_ini + "/" + fec_fin);
		//window.location.assign("{{ route('rptExportEstadoSeguimientoGestionCasos') }}");
	}

</script>

