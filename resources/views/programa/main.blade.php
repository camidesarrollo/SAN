@extends('layouts.main')
@section('contenido')

	<section class=" p-1 cabecera">
		<div class="container-fluid">
			<div class="row align-items-center">
				<div class="col-md-12">
					<h5><i class="{{$icono}} mr-2"></i> Mapa de Oferta</h5>
				</div>
			</div>
		</div>
	</section>

	<section>
		<div class="container-fluid">
			<div class="card p-4 shadow-sm">
				<div class="row">
					<div class="col text-left">
						<h4> Programas </h4>
					</div>
					@if(session()->all()['perfil'] != config("constantes.perfil_administrador_central") && session()->all()['perfil'] != config("constantes.perfil_coordinador_regional"))
					<div class="col text-right">
						<a type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear nuevo Programa" href="{{ route('programa.crear') }}" id="IDnuevo" ><i class="fa fa-plus-circle mr-1"></i> Crear Programa</a>
					</div>
					@endif
				</div>
				<hr>

					<input id="token" hidden value="{{ csrf_token() }}">
					<div class="table-responsive">
						<table class="table table-striped table-hover w-100" cellspacing="0" id="tabla_programa">
							<thead>
								<tr>
									<th class="text-center">Nombre</th>
									<th class="text-center">Dimensión</th>
									<th class="text-center">Tipo</th>
									<th class="text-center">Disponible</th>
									<th class="text-center">Acciones</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
					<hr>
			</div>
		</div>
	</section>

	

@endsection

@section('script')

	<script type="text/javascript">

		$(document).ready( function () {

			cargarListadoProgramas();

		});

		function cargarListadoProgramas() {
			let tabla_programa = $('#tabla_programa').DataTable();
        	tabla_programa.clear().destroy();	

			tabla_programa = $('#tabla_programa').DataTable({
				"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
				"ajax": "{{ route('programa.listar') }}",
				"columnDefs": [ 
				{
					"targets": 		0,
					"className": 	'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				        $(td).css("word-break", "break-word");
				     
				    }
				},
				{
					"targets": 		1,
					"className": 	'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				        $(td).css("word-break", "break-word");
				     
				    }
				},
				{
					"targets": 		2,
					"className": 	'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				        $(td).css("word-break", "break-word");
				     
				    }
				},
				{
					"targets": 		3,
					"className": 	'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				        $(td).css("word-break", "break-word");
				     
				    }
				},
				{
					"targets": 		4,
					"className": 	'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				        $(td).css("word-break", "break-word");
				     
				    }
				}
				],
				"columns": [
					{ "data": "pro_nom" },
					{ "data": "dim_nom" },
					{ "data": "pro_tip" },
					{ 
						"data": "pro_com_est", 
						"render": function (data, type, row, meta){
							let disponible = "NO";
							
							if (row.pro_com_est == 1){
								disponible = "SI";

							}

							return disponible;
						}
					},
					{
						"data": "",
						"orderable": false,
						"className": "text-center",
						'render': function (data, type, full, meta) {
							@if(session()->all()['perfil'] == config("constantes.perfil_administrador_central") && session()->all()['perfil'] == config("constantes.perfil_coordinador_regional"))
							let html = '<a type="button" class="btn btn-primary mr-2" data-toggle="tooltip" data-placement="left" title="Editar Programa" href="{{ route("programa.crear") }}/'+full.prog_id+'"><i class="fa fa-plus-circle mr-1"></i> Editar Programa</a>';
							@else
							let html = '<a type="button" class="btn btn-primary mr-2" data-toggle="tooltip" data-placement="left" title="Editar Programa" href="{{ route("programa.crear") }}/'+full.prog_id+'"><i class="fa fa-plus-circle mr-1"></i> Ver Programa</a>';
							@endif
							return html;
						}
					}
				]
			});

		}

		function insertarPrograma(){

			$('#zModal').modal('hide');

			$('#tabla_programa').DataTable().draw();

			tabla_programa.destroy();

			cargarListadoProgramas();

		}

		function actualizarPrograma(){

			$('#zModal').modal('hide');
			$('#tabla_programa').DataTable().draw();

		}

		function insertarOferta(){
			
			$('#zModal').modal('hide');
			$('#tabla_programa').DataTable().draw();

			// $('#zModal').modal('hide');
			// $('#tabla_ofertas').DataTable().draw();
			// tabla_ofertas.destroy();
			// cargaOfertas();
			
		}



	</script>
	<script type="text/javascript">
		$(function () {
	  $('[data-toggle="popover"]').popover()
	})
	$(function () {
	  $('[data-toggle="tooltip"]').tooltip()
	})
	</script>

@endsection