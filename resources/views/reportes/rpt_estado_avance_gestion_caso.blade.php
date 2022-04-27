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
	
	<div class="row">
		<div class="table-responsive" >
			<table class="table table-striped table-hover encabezado_datatable cell-border dataTables_wrapper  w-100" cellspacing="0" id="tabla_registros"  >
				<thead>
					<tr>
						<th rowspan="2" style="text-align: center;">Gestión de Casos</th>
						<th rowspan="2" style="text-align: center;">Cobertura Inicial</th>
						<th colspan="2" style="text-align: center;">Casos Asignados</th>
						<th colspan="2" style="text-align: center;">{{$titulo_prediagnostico}}</th>
						<th colspan="2" style="text-align: center;">{{$titulo_diagnostico}}</th>
						<th colspan="2" style="text-align: center;">{{$titulo_elaboracion_paf}}</th>
						<th colspan="2" style="text-align: center;">{{$titulo_ejecucion_paf}}</th>
						<th colspan="2" style="text-align: center;">{{$titulo_evaluacion_paf}}</th>
						<th colspan="2" style="text-align: center;">{{$titulo_seguimiento_paf}}</th>
						<th colspan="2" style="text-align: center;">Casos en Gestión</th>
						<th rowspan="2" style="text-align: center;">N° de Encuestas de Satisfacción</th>
						<th rowspan="2" style="text-align: center;">Total de Casos Egresados</th>
					</tr>

					<tr>
						<th style="text-align: center;">N° Casos</th>
						<th style="text-align: center;">N° NNA</th>
						<th style="text-align: center;">N° Casos</th>
						<th style="text-align: center;">N° NNA</th>
						<th style="text-align: center;">N° Casos</th>
						<th style="text-align: center;">N° NNA</th>
						<th style="text-align: center;">N° Casos</th>
						<th style="text-align: center;">N° NNA</th>
						<th style="text-align: center;">N° Casos</th>
						<th style="text-align: center;">N° NNA</th>
						<th style="text-align: center;">N° Casos</th>
						<th style="text-align: center;">N° NNA</th>
						<th style="text-align: center;">N° Casos</th>
						<th style="text-align: center;">N° NNA</th>
						<th style="text-align: center;">N° Casos</th>
						<th style="text-align: center;">N° NNA</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($registros AS $c1 => $v1)
						<tr>
							<td>{{$v1->nombre_gestor}}</td>
							<td>{{config('constantes.cobertura_inicial_gestor')}}</td>
							<td>{{$v1->cant_casos}}</td>
							<td>{{$v1->cant_nna}}</td>
							<td>{{$v1->cant_casos_pre_diag}}</td>
							<td>{{$v1->cant_nna_pre_diag}}</td>
							<td>{{$v1->cant_casos_diag}}</td>
							<td>{{$v1->cant_nna_diag}}</td>
							<td>{{$v1->cant_casos_elab_paf}}</td>
							<td>{{$v1->cant_nna_elab_paf}}</td>
							<td>{{$v1->cant_casos_ejec_paf}}</td>
							<td>{{$v1->cant_nna_ejec_paf}}</td>
							<td>{{$v1->cant_casos_cierre_paf}}</td>
							<td>{{$v1->cant_nna_cierre_paf}}</td>
							<td>{{$v1->cant_casos_seg_paf}}</td>
							<td>{{$v1->cant_nna_seg_paf}}</td>
							<td>{{$v1->cant_casos_gestion}}</td>
							<td>{{$v1->cant_nna_gestion}}</td>

							<td>{{$v1->cant_encuenta_satif}}</td>
							<td>{{$v1->cant_egresados}}</td>


						</tr>
					@endforeach
				</tbody>
				
				<tfoot>
					<tr>
						<th>Total</th>
							<th style="text-align: right;">0</th>
							<th style="text-align: right;">0</th>
							<th style="text-align: right;">0</th>
							<th style="text-align: right;">0</th>
							<th style="text-align: right;">0</th>
							<th style="text-align: right;">0</th>
							<th style="text-align: right;">0</th>
							<th style="text-align: right;">0</th>
							<th style="text-align: right;">0</th>
							<th style="text-align: right;">0</th>
							<th style="text-align: right;">0</th>
							<th style="text-align: right;">0</th>
							<th style="text-align: right;">0</th>
							<th style="text-align: right;">0</th>
							<th style="text-align: right;">0</th>
							<th style="text-align: right;">0</th>
							<th style="text-align: right;">0</th>
							<th style="text-align: right;">0</th>
							<th style="text-align: right;">0</th>
					</tr>
				</tfoot>
			</table>
		</div>
		<div class="col-md-12">
			<div id="grafico_casos_desestimados" style="width: 100%; height: 350px;">		
			</div>
		</div>
	</div>
</div>

<input type="hidden" name="fec_ini" id="fec_ini" value="{{$fec_ini}}">
<input type="hidden" name="fec_fin" id="fec_fin" value="{{$fec_fin}}">

<script type="text/javascript">
	$(document).ready( function () {

		tabla_registros = $('#tabla_registros').DataTable({
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},	
			"autoWidth": true,	

			 footerCallback: function ( row, data, start, end, display ) {
        		var api = this.api(), data;

	            // Remove the formatting to get integer data for summation
	            var intVal = function ( i ) {
	                return typeof i === 'string' ?
	                    i.replace(/[\$,]/g, '')*1 :
	                    typeof i === 'number' ?
	                        i : 0;
	            };

	            var columnas = tabla_registros.columns(':visible').count();

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
		fec_ini = fec_ini.replace("/", "-");
		fec_ini = fec_ini.replace("/", "-");
		fec_fin = fec_fin.replace("/", "-");
		fec_fin = fec_fin.replace("/", "-");
	
		window.location.assign("{{ route('rptExportEstadoAvance') }}" + "/" + comunas+ "/" + fec_ini + "/" + fec_fin);
		//window.location.assign("{{ route('rptExportEstadoAvance') }}");
	}

</script>


