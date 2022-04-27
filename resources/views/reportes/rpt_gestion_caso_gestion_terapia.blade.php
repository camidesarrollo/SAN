
<div class="card p-4 shadow-sm">


	<div class="row">
		<div class="col-10 text-left">
			<h5><b>{{ $nombre_reporte }}</b></h5>
		</div>
		<div class="col-2 text-right">
			<button class='btn btn-success' id="xls_reporte" name="xls_reporte" onclick="descargarReporteCasos()">
				<i class="fas fa-download"></i> Descargar
			</button>
		</div>
	</div>
		

	<!--<input id="token" hidden value="{{ csrf_token() }}">-->
		
	<div class="row">
		<div class="table-responsive">
			<table class="table table-striped table-hover encabezado_datatable cell-border w-100" cellspacing="0" id="tabla_caso_terapia">
				<thead>
				<tr>
					<th rowspan="2" style="text-align: center;width: 25%">Comuna</th>
					<th rowspan="2" style="text-align: center;width: 25%">Región</th>
					<th colspan="2" style="text-align: center;width: 25%">N° Casos en GC</th>
					<th colspan="2" style="text-align: center;width: 25%">N° Casos en TF</th>
				</tr>

				<tr>
					<th style="text-align: center;width: 25%">Cantidad de NNA</th>
					<th style="text-align: center;width: 25%">Cantidad de Familias</th>
					<th style="text-align: center;width: 25%">Cantidad de NNA</th>
					<th style="text-align: center;width: 25%">Cantidad de Familias</th>
				</tr>

				</thead>
				<tbody>
					@foreach ($registros AS $c1 => $v1)
						<tr>
							<td>{{$c1}}</td>
							@foreach ($v1 AS $c2 => $v2)
								<td style="text-align: left;">{{$c2}}</td>
								@foreach ($v2 AS $c3 => $v3)
									@foreach ($v3 AS $c4 => $v4)
										<td style="text-align: right;">{{$v4}}</td>
									@endforeach
								@endforeach
							@endforeach
						</tr>
					@endforeach
				</tbody>
				
				<tfoot>
					<tr>
						<th>Total</th>
							<th style="text-align: right;padding: 10px;"></th>
							<th style="text-align: right;padding: 10px;">0</th>
							<th style="text-align: right;padding: 10px;">0</th>
							<th style="text-align: right;padding: 10px;">0</th>
							<th style="text-align: right;padding: 10px;">0</th>
					</tr>
				</tfoot>


			</table>
		</div>
		<div class="col-md-12">
			<div id="grafico_casos" style="width: 100%; height: 350px;"></div>
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
		let chkcomuna	= new Array();
		$.each($('#chkcomuna option:selected'), function(){ chkcomuna.push($(this).val()); });
		comunas			= chkcomuna.join(',');
		
		tabla_caso_terapia = $('#tabla_caso_terapia').DataTable({
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

	            var columnas = tabla_caso_terapia.columns(':visible').count();

				for (var i = 2; i <= columnas-1; i++) {
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

	function descargarReporteCasos(){
		
		// let chkcomuna	= new Array();
		// $.each($('#chkcomuna option:selected'), function(){ chkcomuna.push($(this).val()); });
		// comunas			= chkcomuna.join(',');
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
		fec_ini = $('#fec_ini').val();
		fec_fin = $('#fec_fin').val();
		window.location.assign("{{ route('rptExportGestionCasoTerapia') }}" + "/" + comunas+ "/" + fec_ini + "/" + fec_fin);
		//window.location.assign("{{ route('rptExportGestionCasoTerapia') }}");
	}

</script>




