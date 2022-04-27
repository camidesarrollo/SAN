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
			<table class="table table-striped table-hover encabezado_datatable cell-border w-100" cellspacing="0" id="tabla_registros_terapeuta" style="table-layout: fixed;">
				<thead>
					<tr>
						<th rowspan="2" style="text-align: center;width: 20%">Terapia Familiar</th>
						<th rowspan="2" style="text-align: center;width: 20%">Cobertura Inicial</th>
						<th colspan="2" style="text-align: center;width: 20%">Casos Asignados</th>
						<th colspan="2" style="text-align: center;width: 20%">{{$titulo_invitacion}}</th>
						<th colspan="2" style="text-align: center;width: 20%">{{$titulo_diagnostico}}</th>
						<th colspan="2" style="text-align: center;width: 20%">{{$titulo_ejecucion}}</th>
						<th colspan="2" style="text-align: center;width: 20%">{{$titulo_seguimiento}}</th>
						<th colspan="2" style="text-align: center;width: 20%">Casos en Terapia</th>
						<th rowspan="2" style="text-align: center;width: 20%">N° de Encuestas de Satisfacción</th>
						<th rowspan="2" style="text-align: center;width: 20%">Total de Casos Egresados</th>
					</tr>

					<tr>
						<th style="text-align: center;width: 20%">N° <br/>Casos</th>
						<th style="text-align: center;width: 20%">N° <br/>NNA</th>
						<th style="text-align: center;width: 20%">N° <br/>Casos</th>
						<th style="text-align: center;width: 20%">N° <br/>NNA</th>
						<th style="text-align: center;width: 20%">N° <br/>Casos</th>
						<th style="text-align: center;width: 20%">N° <br/>NNA</th>
						<th style="text-align: center;width: 20%">N° <br/>Casos</th>
						<th style="text-align: center;width: 20%">N° <br/>NNA</th>
						<th style="text-align: center;width: 20%">N° <br/>Casos</th>
						<th style="text-align: center;width: 20%">N° <br/>NNA</th>
						<th style="text-align: center;width: 20%">N° <br/>Casos</th>
						<th style="text-align: center;width: 20%">N° <br/>NNA</th>
					</tr>
					</thead>
				<tbody>
					@foreach ($registros AS $c1 => $v1)
						<tr>
							<td>{{$c1}}</td>

							@foreach ($v1 AS $c2 => $v2)

								@if ($c2 == 'Cobertura Inicial')
									<td style="text-align: right;">{{$v2}}</td>
								@endif

								@if ($c2 == 'Casos Asignados' || $c2 == 'Invitación' || $c2 == 'Diagnóstico' || $c2 == 'Ejecución' || $c2 == 'Seguimiento' || $c2 == 'Total Atendidos')

									@foreach ($v2 AS $c3 => $v3)
										<td style="text-align: right;">{{$v3}}</td>
									@endforeach

								@endif

								@if ($c2 == 'N° de Encuestas de Satisfacción')
									<td style="text-align: right;">{{$v2}}</td>
								@endif

								@if ($c2 == 'Total de Casos Egresados')
									<td style="text-align: right;">{{$v2}}</td>
								@endif

							@endforeach

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
							<th style="text-align: right;padding: 10px;">0</th>
							<th style="text-align: right;padding: 10px;">0</th>
							<th style="text-align: right;padding: 10px;">0</th>
							<th style="text-align: right;padding: 10px;">0</th>
							<th style="text-align: right;padding: 10px;">0</th>
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
			<div id="grafico_casos_desestimados" style="width: 100%; height: 350px;"></div>
		</div>	
	</div>

</div>
<input type="hidden" name="fec_ini" id="fec_ini" value="{{$fec_ini}}">
<input type="hidden" name="fec_fin" id="fec_fin" value="{{$fec_fin}}">

<script type="text/javascript">
	$(document).ready( function (){
		tabla_registros_terapeuta = $('#tabla_registros_terapeuta').DataTable({
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

	            var columnas = tabla_registros_terapeuta.columns(':visible').count();

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
		window.location.assign("{{ route('rptExportEstadoAvanceTerapia') }}" + "/" + comunas+ "/" + fec_ini + "/" + fec_fin);
		//window.location.assign("{{ route('rptExportEstadoAvanceTerapia') }}");
	}
</script>




