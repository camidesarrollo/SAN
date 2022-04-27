<section>
	<div class="container-fluid">
		<div class="card p-4 shadow-sm">

				<div class="row">
					<div class="col-10 text-left">
						<h5><b>Reporte de Usuarios por OLN</b></h5>
					</div>
					<div class="col-2 text-right">
						<button class='btn btn-success' id="xls_reporte" name="xls_reporte" onclick="descargarReporteXComuna()">
						   <i class="fas fa-download"></i> Descargar
						</button>
					</div>
                </div>
                
				<div class="row">
					<div class="table-responsive">
						<table class="table table-striped table-hover encabezado_datatable cell-border w-100" cellspacing="0" id="tabla_usuario_oln">
							<thead>
							<tr>
								<th class="text-center">Run</th>
                                <th class="text-center">Nombres</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Teléfono</th>
                                <th class="text-center">Tipo</th>
                                <th class="text-center">Institución</th>
                                <th class="text-center">Estado</th>
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
		
		oln = $('#opc_oln option:selected').val();

		tabla_usuario_oln = $('#tabla_usuario_oln').on('error.dt',
		function (e, settings, techNote, message) {
			tabla_usuario_oln.ajax.reload(null,false);
    		console.log('Ocurrió un error en el datatable de: rpt_usuario_perfil.index.blade.php, el error es: ', message);
		}).DataTable({
			"serverSide": true,
			"order":[[ 4, "asc" ]],
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},			
			"ajax": "{{ route('rpt.usuario.oln') }}/" + oln,
			"columns": [
				{
				 "data": "run",
				 "className": "text-left"
				},
				{
				 "data": "nombres",
                 "className": "text-center",
                //  "render": function(data, type, row){
                //         let nombres = row.nombres+' '+row.apellido_paterno+' '+row.apellido_materno;
                //         return nombres;
                //  }
                },
                {
				 "data": "email",
				 "className": "text-center"
				},
				{
				 "data": "telefono",
				 "className": "text-center"
                },
                {
				 "data": "tipo",
				 "className": "text-center"
				},
				{
				 "data": "nom_ins",
				 "className": "text-center"
                },
                {
				 "data": "estado_usuario",
				 "className": "text-center"
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
		oln = $('#opc_oln option:selected').val();
		//perfil = 3;
		window.location.assign("{{ route('usuario.oln.export') }}" + "/" + oln);
	}

</script>