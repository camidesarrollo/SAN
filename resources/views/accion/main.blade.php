@extends('layouts.main')

@section('contenido')
	
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<br />
				<button type="button" class="btn btn-success btn-xs " data-toggle="tooltip" data-placement="left" title="Nueva Acción" onclick="showModalzAjax( '{{ route('accion.crear') }}','','','');" id="IDnuevo" >
					<i class="fa fa-plus" aria-hidden="true"></i>
				</button>
				<input id="token" hidden value="{{ csrf_token() }}">
				<div class="table-responsive">
					<table class="table table-bordered table-hover" cellspacing="0" id="tabla_acciones">
						<thead>
						<tr>
							<th>Id</th>
							<th>Nombre</th>
							<th>Descripci&oacute;n</th>
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
			
			$('#tabla_acciones').DataTable({
				"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
				"ajax": "{{ route('accion.listar') }}",
				"columns": [
					{ "data": "acc_id", "className": "text-right" },
					{ "data": "acc_nom" },
					{ "data": "acc_des" }
				]
			});
			
		});
		
		function insertarAccion(){
			
			$('#zModal').modal('hide');
			$('#tabla_acciones').DataTable().draw();
			
		}
		
		function actualizarAccion(){
			
			$('#zModal').modal('hide');
			$('#tabla_acciones').DataTable().draw();
			
		}
	
	
	</script>

@endsection