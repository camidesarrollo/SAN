
<!-- INICIO CZ SPRINT 66 -->
<?php
    $perfil = session()->all()['perfil'];
    $com_id = session()->all()['com_id']; 
?>
<!-- FIN CZ SPRINT 66 -->
<div class="card p-4 shadow-sm w-100">


	<div class="row">
		<div class="col-10 text-left">
			<h5><b>{{ $nombre_reporte }}</b></h5>
		</div>
		<div class="col-2 text-right">
			<button class='btn btn-success' id="xls_reporte" name="xls_reporte" onclick="descargarReporteCasosDesestimadosGestor();">
				<i class="fas fa-download"></i> Descargar
			</button>
		</div>
	</div>
		

	<!--<input id="token" hidden value="{{ csrf_token() }}">-->
		
	<div class="row w-100">
		<div class="table-responsive">
			<table class="table table-striped table-hover encabezado_datatable cell-border" cellspacing="0" id="tabla_desestimacion_caso_gestor">
				<thead>
				<tr>
					<th style="text-align: center;width: 20%">Gestor</th>
					@foreach ($titulosMotivosDesestimacion AS $c1 => $v1)
						<th style="text-align: center;">{{$v1->est_cas_nom}}</th>
					@endforeach
				</tr>
				</thead>
				<tbody>
					@foreach ($registrosCasosDesestimados AS $c1 => $v1)
						<tr>
							<td>{{$v1->nombre_gestor}}</td>
							<td>{{$v1->rech_por_fami}}</td>
							<td>{{$v1->desc_gest}}</td>
							<td>{{$v1->direc_incon}}</td>
							<td>{{$v1->direc_desact}}</td>
							<td>{{$v1->program_senam}}</td>
							<td>{{$v1->vulner_derec}}</td>
							<td>{{$v1->medi_protec}}</td>
							<td>{{$v1->fam_no_aplic}}</td>
							<td>{{$v1->fam_inu}}</td>
							<td>{{$v1->fam_rec_oln}}</td>
							<td>{{$v1->fam_renun_oln}}</td>
							<td>{{$v1->dere_cont_del}}</td>
							<td>{{$v1->dere_no_cont_del}}</td>
						</tr>
					@endforeach
				</tbody>
				
				<tfoot>
					<tr>
						<th>Total</th>
							@foreach ($titulosMotivosDesestimacion AS $c1 => $v1)
								<th style="text-align: right;padding: 10px;">0</th>
							@endforeach
					</tr>
					</tfoot>

			</table>
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

		tabla_desestimacion_caso_gestor = $('#tabla_desestimacion_caso_gestor').DataTable({
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

	            var columnas = tabla_desestimacion_caso_gestor.columns(':visible').count();

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

	function descargarReporteCasosDesestimadosGestor(){
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
		window.location.assign("{{ route('rptExportDesestimacionDeCasoGestor') }}/" + comunas+ "/" + fec_ini + "/" + fec_fin);
		//window.location.assign("{{ route('rptExportDesestimacionDeCasoGestor') }}");
	}

</script>


