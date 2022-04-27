@extends('administrador.layouts.main')

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<br>
				<button type="button" class="btn btn-success btn-xs " data-toggle="tooltip" data-placement="left" title="Nuevo Usuario" onclick="grabar('-1','Nuevo Usuario');" id="IDnuevo" ><i class="fa fa-plus" aria-hidden="true"></i>
				</button>
				<input id="url_api" hidden value="{{ route('usuarios.api') }}">
				<input id="url_update" hidden value="{{ route('usuarios.update') }}">
				<input id="token" hidden value="{{ csrf_token() }}">
				<div class="table-responsive">
					<table class="table table-bordered table-hover" cellspacing="0" id="tblUsuarios">
						<thead>
							<tr>
								<th>Rut</th>
								<th>Nombre</th>
								<th>Perfil</th>
								<th>Institución</th>
								<th>Estado</th>
								<th>Acción</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	
@stop

@section('js')
<script>
	
	/*$('#tblUsuarios thead th').each( function () {
		var title = $(this).text();
		if (title != 'Acción')
			$(this).html( title + '<br /><input class="form-control form-control-sm" type="text" placeholder="Buscar '+title+'" style="" />' );
	} );


	function cargaTablaUsuarios() {
		tU.columns().every( function () {
		var that = this;
 
			$( 'input', this.header() ).on( 'keyup change', function () {
				if ( that.search() !== this.value ) {
					that
						.search( this.value )
						.draw();
				}
			} );
		} );


	}*/

	//cargaTablaUsuarios();


	function grabar(id,msj){
		 url = $('#url_update').val() + '/' + id + '/';
		 btnGuardando('#btnGuardar');
		 showModalAjax('#xModal',msj, url, '', 2, 'enviaFormModal(\'#frmGrabarUsuario\',\'\',\'grabarOK()\',\'grabarError\');');
	}

	function grabarOK(){
		$('#xModal').modal('hide');
		
		$('#tblUsuarios').DataTable().draw();

		modalMsj("<p> Se grabó correctamente el usuario.</p>");
	}

	function grabarError(msj){
		modalMsj("<p>"+msj+"</p>");
	}
	
	$(document).ready( function () {
		//let tblUsuarios = $('#tblUsuarios').DataTable();
		//tblUsuarios.destroy();
		
		let tU = $('#tblUsuarios').DataTable({
			"dom": "<'row'<'col-sm-6'l><'col-sm-6'>>" +
				"<'row'<'col-sm-12'tr>>" +
				"<'row'<'col-sm-5'i><'col-sm-7'p>>",
			//"bLengthChange": false,
			//"responsive": true,
			"processing": true,
			"serverSide": true,
			"ajax": {
				"url": $('#url_api').val(),
				"type": "POST",
				"data": { "_token" : $('#token').val() }
			},
			"columns": [
				{ "data": 'run' },
				{ "data": 'nombre_completo' },
				{ "data": 'perfil.nombre'},
				{ "data": 'id_institucion' },
				{ "data": 'nombre_estado' },
				{
					"data": null, "className": "dt-center", "orderable": false,
					"render": function (data, type, full, meta) {
						return '<button type="button" class="btn btn-success btn-xs " data-toggle="tooltip" data-placement="left" title="Editar datos" onclick="grabar(' + full.id + ',\'Editar Usuario\');"><i class="fa fa-pencil" aria-hidden="true"></i></button>';
					}
				},
				/*{ "data": 'EmailConfirmed', "visible": false },
				{ "data": 'estado', "visible": false }*/
			],
			"order": [[0, "asc"]],
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			//"language": { "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json" },
			"initComplete": function (settings, json) {
				this.css('width', '100%');
			},
			"drawCallback": function (settings) {
				$("[data-toggle=tooltip]").tooltip({ html: true });
			}
		});
	});

</script>

@stop
