<section>
	<div class="container-fluid">
		<div class="card p-4 shadow-sm">

				<div class="row">
					<div class="col-10 text-left">
						<h5><b>Reporte de Usuarios por Perfil</b></h5>
					</div>
					<div class="col-2 text-right">
						<button class='btn btn-success' id="xls_reporte" name="xls_reporte" onclick="descargarReporteXComuna()">
						   <i class="fas fa-download"></i> Descargar
						</button>
					</div>
                </div>
                
				<div class="row">
					<div class="table-responsive">
						<table class="table table-striped table-hover encabezado_datatable cell-border w-100" cellspacing="0" id="tabla_usuario_perfil">
							<thead>
							<tr>
								<th class="text-center" style="width: 70%">Comuna</th>
								<th class="text-center" style="width: 30%">Nº de Personas</th>
							</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
				
		</div>
	</div>
</section>

<script type="text/javascript">
	$(document).ready( function () {
		
		perfil = $('#per_usu option:selected').val();
		//perfil = 3;	

		tabla_usuario_perfil = $('#tabla_usuario_perfil').on('error.dt',
		function (e, settings, techNote, message) {
			tabla_usuario_perfil.ajax.reload(null,false);
    		console.log('Ocurrió un error en el datatable de: rpt_usuario_perfil.index.blade.php, el error es: ', message);
		}).DataTable({
			"serverSide": true,
			"order":[[ 1, "desc" ]],
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},			
			"ajax": "{{ route('rpt.usuario.perfil') }}/" + perfil,
			"columns": [
				{
				 "data": "oln",
				 "className": "text-left"
				},
				{
				 "data": "cantidad",
				 "className": "text-right"
				}
			],
			 footerCallback: function ( row, data, start, end, display ) {
        		var api = this.api(), data;

	            // Remove the formatting to get integer data for summation
	            var intVal = function ( i ) {
	                return typeof i === 'string' ?
	                    i.replace(/[\$,]/g, '')*1 :
	                    typeof i === 'number' ?
	                        i : 0;
	            };
	 
	            // Total over all pages
	            total = api
	                .column( 1 )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );
	 
	            // Update footer

	            if ($("#total1").text()=='0'){
	            	$("#total1").text(total);
	        	}

    		}

		});

	});

	function descargarReporteXComuna(){
		perfil = $('#per_usu option:selected').val();
		//perfil = 3;
		window.location.assign("{{ route('usuario.perfil.export') }}" + "/" + perfil);
	}

</script>

