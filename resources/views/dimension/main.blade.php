@extends('layouts.main')

@section('contenido')
	
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<button type="button" class="btn btn-success btn-sm " data-toggle="tooltip" data-placement="left" title="Nueva Dimension" onclick="showModalzAjax( '{{ route('dimension.crear') }}','','','');" id="IDnuevo" >
					<i class="fa fa-plus" aria-hidden="true"></i>
				</button>
				<input id="token" hidden value="{{ csrf_token() }}">
				<div class="table-responsive">
					<table class="table table-bordered table-hover" cellspacing="0" id="tabla_dimensiones">
						<thead>
							<tr>
								<th class="text-center">Id</th>
								<th class="text-center">Nombre</th>
								<th class="text-center">Descripci&oacute;n</th>
								<th class="text-center">Estado</th>
								<th class="text-center">Acciones</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

@endsection

@section('script')
	
	<script type="text/javascript">
		
		$(document).ready( function () {
			
			$('#tabla_dimensiones').DataTable({
				"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
				"ajax": "{{ route('dimension.listar') }}",
				"columns": [
					{ "data": "dim_id" },
					{ "data": "dim_nom" },
					{ "data": "dim_des" },
					{ "data": "dim_act", "className": "text-center" },
					//{ "data": "dim_id", "className": "text-center" }
					{
						'render': function (data, type, full, meta) {
							return 	'<div class="dropdown">' +
										'<button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
											'Acciones' +
										'</button>' +
										'<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">' +
											'<a href="#" class="dropdown-item" onclick="showModalzAjax(\'{{ route('dimension.crear') }}/'+full.dim_id+'\',\'\',\'\',\'\')";>' +
												'Modificar' +
											'</a>' +
										'</div>' +
									'</div>';
						}, "className": "text-center"
					}
				]
			});
			
		});
	
		function insertarDimension(){
			
			$('#zModal').modal('hide');
			$('#tabla_dimensiones').DataTable().draw();
		
		}
		
		function actualizarDimension(){
			
			$('#zModal').modal('hide');
			$('#tabla_dimensiones').DataTable().draw();
			
		}
		
	
	</script>
	
@endsection