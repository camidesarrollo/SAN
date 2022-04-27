@extends('layouts.main')

@section('contenido')
	
    <section class="p-1 cabecera">
		<div class="container-fluid">
			<div class="row align-items-center">
				<div class="col-md-12">
					<h5><i class="fa fa-map mr-2"></i> Mapa de Oferta </h5>
				</div>
			</div>
		</div>
	</section>

	<section>
		<div class="container-fluid">

			<div class="card p-4">

				<div class="row">
					<div class="col">
						<h4>Componentes </h4>
					</div>
					<div class="col text-right">
						<a href="#" onclick="history.back()" class="btn btn-link"><i class="fa fa-undo"></i> Volver a "Programas"</a>
						<button type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Nueva Oferta" onclick="showModalzAjax( '{{ route('ofertas.crear') }}','','','');" id="IDnuevo" ><i class="fa fa-plus-circle mr-1"></i> Crear Componente
						<!--<i class="fa fa-plus" aria-hidden="true"></i> -->
						</button>
					</div>
				</div>
			
				<hr>

				<input type="hidden" id="ofertas_nom" nombre="ofertas_nom" value="{{ route('ofertas.nombre') }}">

				<input id="token" hidden value="{{ csrf_token() }}">
				<div class="table-responsive">
					<table class="table table-striped table-hover" cellspacing="0" id="tabla_ofertas" name="tabla_ofertas">
						<thead>
							<tr>
								<th>Nombre</th>
								<th>Programa</th>
								<th>Dimensión</th>
								<th>Alertas Territoriales</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>
	</section>

	<section>
		
	</section>

@endsection

@section('script')
	
	<script type="text/javascript">
		
	
		$(document).ready( function () {
			
			cargaOfertas();

		});

		function cargaOfertas(){

			var tabla_ofertas = $('#tabla_ofertas').DataTable({
				"ajax": "{{ route('ofertas.listar') }}",
				"columns": [
					{ "data": "ofe_nom", "className": ""},
					{ "data": "pro_nom", "className": ""},
					{ "data": "dim_nom", "className": ""},
					{ "data": "alertas_territoriales", "className": "text-left",
					   'render': function(data, type, full, meta){
                           let html = "";
                           if (data){
	                           let alertas_territoriales = data.split("-");
	                           for(let i=0; i < alertas_territoriales.length; i++){
	                           	   html += '<ul><li> '+alertas_territoriales[i]+'</li></ul>';
	                           }
							}

                           return html;
					   }
				    },
					{
						"orderable": false,
						'render': function (data, type, full, meta) {
							return 	'<a href="#" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="left" data-original-title="Editar este componente" title="Editar" onclick="showModalzAjax(\'{{ route('ofertas.editar') }}/'+full.ofe_id+'\');">' +
								'<i class="fa fa-edit mr-1"></i> Editar componente' +
								'</a>' ;
						}, "className": "text-center"
					}
				],
				/*"language": { "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"

			},*/
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"}
			});
			

		}
		
		function insertarOferta(){
			
			$('#zModal').modal('hide');
			// $('#tabla_ofertas').DataTable().draw();
			tabla_ofertas.destroy();
			cargaOfertas();
			
		}
		
		function actualizarOferta(){
			
			$('#zModal').modal('hide');
			//$('#tabla_ofertas').DataTable().draw();
			tabla_ofertas.destroy();
			cargaOfertas();
			
		}

	
	
	</script>

@endsection