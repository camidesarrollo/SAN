@extends('layouts.main')

@section('contenido')
	
	<section class="p-1 cabecera">
		<div class="container-fluid">
			<div class="row align-items-center">
				<div class="col-md-12">
					<h2><span class="oi oi-list"></span> Diseñar Plan de Acción Grupal</h2>
				</div>
			</div>
		</div>
	</section>
	
	<div class="container-fluid">
		<ul class="nav nav-tabs" id="myTab" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Listado de Fechas Grupales</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="lista-tab" data-toggle="tab" href="#lista" role="tab" aria-controls="lista" aria-selected="false">Listado de Sesiones</a>
			</li>
		</ul>
	</div>
	
	<div class="tab-content" id="myTabContent">
		<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
			<section class="p-1">
				<input type="hidden" id="url_lista" value="{{ route('sesiones.grupal.listar') }}">
				<input type="hidden" id="url_form_asignar" value="{{ route('sesiones.grupal.form.asignar') }}">
				<input type="hidden" id="url_form_crear" value="{{ route('sesiones.grupal.form') }}">
				<div class="container-fluid">
					<div class="card p-4">
						<div class="row">
							<div class="col-md-12">
								<button type="button" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="right" title="" onclick="showModalzAjax( '{{ route('sesiones.grupal.form') }}','','cargaFecha()','');" id="IDnuevo" data-original-title="Nueva Sesión Grupal"><i class="fa fa-plus" aria-hidden="true"></i>
								</button>
								<table class="table table-striped table-bordered dt-responsive nowrap" id="tabla_sesiones" style="width:100%">
									<thead>
									<tr>
										<th>ID</th>
										<th>Rut Encargado</th>
										<th>Nombre</th>
										<th>Fecha</th>
										<th>Estado</th>
										<th>Acciones</th>
									</tr>
									</thead>
									<tbody>
									
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<div class="tab-pane fade" id="lista" role="tabpanel" aria-labelledby="lista-tab">
			<section class="p-1">
				<input type="hidden" id="url_sesiones_listar" value="{{ route('sesiones.listar') }}">
				<input type="hidden" id="url_form_sesion" value="{{ route('sesiones.showFrm') }}">

				<div class="container-fluid">
					<div class="card p-4">
						<div class="row">
							<div class="col-md-12">
								<table class="table table-striped table-bordered dt-responsive nowrap" id="tabla_sesiones_g" style="width:100%">
									<thead>
									<tr>
										<th>ID</th>
										<th>Rut</th>
										<th>Nombres</th>
										<th>Fecha</th>
										<th>Estado</th>
										<th>Acciones</th>
									</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</section>
		
		</div>
		
	</div>

@endsection

@section('script')
	<script type="text/javascript">
		
		function cargaFecha(){
			$('div .date').datetimepicker({
				locale: 'es',
				format: 'DD/MM/Y HH:mm',
			});
		}
		
		function grupalOk(){
			$('#zModal').modal('hide');
			$('#tabla_sesiones').DataTable().draw();
		}
		
		function asignarOk(){
			$('#zModal').modal('hide');
			//$('#tabla_sesiones').DataTable().draw();
			$('#tabla_sesiones_g').DataTable().draw();
		}
		
		function showFrmSesion(ses_id){
			let url = $('#url_form_sesion').val() + '/' + ses_id;

			showModalzAjax(url,'','showFrmSesionOk()','','');
		
		}
		
		function showFrmSesionOk() {
			$('.date').datetimepicker({
				locale: 'es',
				format: 'DD/MM/Y HH:mm',
			});
			$('#ses_fec').attr('readonly',true);
		}
		
		function actualizarOk(obj){
			$('#zModal').modal('hide');
			$('#tabla_sesiones_g').DataTable().draw();
		}
		
		$(document).ready(function () {
			$('div .date').datetimepicker({
				locale: 'es',
				format: 'DD/MM/Y HH:mm',
			});
			
			//cargarSesiones();
			let url_lista = $('#url_lista').val();
			
			let tabla_sesiones = $('#tabla_sesiones');
			
			let dt_sesiones = tabla_sesiones.DataTable( {
				/*"fixedHeader": {
					header:true
				},*/
				//"bLengthChange": false,
				//"responsive": true,
				"dom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
				"order": [[ 0, "desc" ]],
				"processing": true,
				"serverSide": true,
				"ajax":{
					"url": url_lista,
					"data": function ( d ) {
						d.nombre = "jose";
						//d.origen = $('#origen').val();
					}
				},
				"columns":[
					{"data":'gru_id',"name":"gru_id","className": "text-center","visible": true},
					{
					 "data":'gru_rut',
					 "name":"gru_rut",
					 "render": function(data, type, row){
					    let dv = obtenerDv(data);
					    let run = data+"-"+dv;

					 	return formatearRun(run);
					  }
					},
					{"data":'gru_nom', "name":"gru_nom"},
					{"data":'fecha',"name":"gru_fec","className": "text-center"},
					{"data":'estado.est_ses_nom',"name":"estado","className": "text-center"},
					{
						"data":null,
						"orderable":false,
						"className": "text-center",
						"render":function(data,type,row){
							
							let url_form_asignar = $("#url_form_asignar").val()+'/'+row.gru_id;
							
							let botonFichaCompleta = "<a class='dropdown-item' href='#' onclick=\"showModalzAjax('"+url_form_asignar+"','','cargaFecha()','')\";>Agendar Casos</a>";
							
							let url_form_crear = $("#url_form_crear").val()+'/'+row.gru_id;
							
							let botonFichaRapida = "<a href='#' class='dropdown-item' "+
								" onclick=\"showModalzAjax('"+url_form_crear+"','','cargaFecha()','')\";>Modificar</a>";
							
							let dropb = '<div class="dropdown">'+
										'<button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Acciones </button>'+
										'<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">'+
										botonFichaCompleta+botonFichaRapida+
										'</div></div>';
							return dropb;
						}
					}
				],
				"language": {
					"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
				},
				"drawCallback": function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});
			
			//let url_lista = $('#url_sesiones_listar').val();
			let dt_sesiones2 = $('#tabla_sesiones_g').DataTable( {
				"dom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
				"order": [[ 3, "desc" ]],
				"processing": true,
				"serverSide": true,
				"ajax":{
					"url": $('#url_sesiones_listar').val(),
					"data": function ( d ) {
						d.nombre = "jose";
						//d.origen = $('#origen').val();
					}
				},
				"columns":[
					{"data":'ses_id',"name":"ses_id","className": "text-center","visible": false, searchable: false},
					{
					 "data":'caso.persona.rut',
					 "name":"caso.persona.per_run",
					 "sortable" : false,
					 "render": function(data, type, row){ return formatearRun(data); }
					},
					{"data":'caso.persona.nombre_corto', "name":"per_nom", sortable : false, searchable: false},
					{"data":'fecha',"name":"ses_fec","className": "text-center", searchable: false},
					{"data":'estados.0.est_ses_nom',"name":"ses_fec","className": "text-center", sortable : false, searchable: false},
					{
						"data":null,
						"orderable":false,
						searchable: false,
						"className": "text-center",
						"render":function(data,type,row){
							let dropb = "<button class='btn btn-primary btnShow' type='button' onclick='showFrmSesion("+row.ses_id+")'>Modificar</button>";
							
							return dropb;
						}
					}
				],
				"language": {
					"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
				},
				"drawCallback": function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});
		});

	function valSesionesGrupales(_this, id_caso){
		$.ajax({
			url: $("#val_gru_nna").val(),
			cache: false,
			data: { caso_id : id_caso }
		}).done(function( resp ) {

			if (resp.respuesta == false){
				alert("No se puede agregar más sesiones grupales al NNA. Debido a que completo el máximo de sesiones Planificadas o Finalizadas.");
				$(_this).prop('checked', false);
				$(_this).attr("disabled", true);
			}

		}).fail(function(obj) {
			console.log(obj);
			alert("Error al momento de validar las sesiones grupales agendadas del NNA. Por favor volver a intentar.");

		});
	}
	</script>


@endsection