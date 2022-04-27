@extends('layouts.main')

@section('contenido')

	<section class="p-1 cabecera">
		<div class="container-fluid">
			<div class="row align-items-center">
				<div class="col">
					<h5> <i class="{{ $icono }}"></i> Listado de Procesos Anuales</h5>
				</div>
			</div>
		</div>
	</section>
	
	
	@if(Session::has('success'))
		<div class="container-fluid">
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>{{ Session::get('success') }}</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		</div>
	@endif

	@if(Session::has('danger'))
		<div class="container-fluid">
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>{{ Session::get('danger') }}</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		</div>
	@endif
	@if ($errors->any())
		<div class="container-fluid">
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		</div>
	@endif

	<section>
		<div class="container-fluid">
			<div class="card p-4 shadow-sm">
				@foreach ($acciones as $accion)
              		@if ($accion->cod_accion == "GCM01")
						<div class="text-right">
							<button type="button" onclick="{{ $accion->ruta }}" class="btn btn-success" data-target="#frmProceso" data-placement="left" title="Nuevo Proceso Anual" id="proceso_anual" ><i class="{{ $accion->clase }}"></i>  {{ $accion->nombre }}</button>
						</div>
					@endif
				@endforeach

				<div class="table-responsive">
					<table class="table table-striped table-hover w-100" cellspacing="0" id="tabla_proceso_anual">
						<thead>
							<tr>
								<th>Fecha de Creación</th>
								<th>Nombre Proceso Anual</th>
								<th>Creado Por</th>
								<th>Etapa Actual</th>
								<!-- <th>Avance</th> -->
								@foreach ($acciones as $accion)
              						@if ($accion->cod_accion == "GCM02")
										<th>Acciones</th>
									@endif	
								@endforeach
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>
	</section>
	<div id="frmProceso" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="formComponentesLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content p-4">
				<div class="card p-4 shadow-sm">
					<h5 class="modal-title text-center" id="formComponentesLabel"><b>Proceso Anual</b></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true" style="position: absolute; right: 5px; top: 5px; width: 23px; height: 23px; padding: 0; margin: 0;">&times;</span>
					</button>
					<br>
					<form>
						<div class="form-group">
							<label for="form_pro_an_fec">Año de Proceso: </label>
							<div class="input-group date-pick" id="form_pro_an_fec" data-target-input="nearest" style="width: 20%;">
								<input onkeypress='return caracteres_especiales_fecha(event)' type="text" class="form-control datetimepicker-input " data-target="#form_pro_an_fec"/>
								<div class="input-group-append" data-target="#form_pro_an_fec" data-toggle="datetimepicker">
									<div class="input-group-text"><i class="fa fa-calendar"></i></div>
								</div>								
							</div>
							<p id="val_frm_pro_an_fec" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar un Año.</p>
						</div>
						<div class="form-group">
							<label for="form_pro_an_nom">Nombre del Proceso:</label>
							<input maxlength="50" onkeypress="return caracteres_especiales(event)" type="text" class="form-control " id="form_pro_an_nom">
							<p id="val_frm_pro_an_nom" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar un Nombre.</p>
						</div>
					</form>
					<div class="text-right">
						<button type="button" class="btn btn-success" onclick="crearProcesoAnual();">Guardar</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
					</div>					
				</div>                
			</div>
		</div>
	</div>
@endsection
@include('gestor_comunitario.gestion_comunitaria.ver_desestimado_modal')
@section('script')
<script type="text/javascript">
	$(document).ready(function(){
		listarProcesoAnual();


		// FORMATO CALENDARIO POR AÑOS
		$('#form_pro_an_fec').datetimepicker({
			format: 'YYYY',
			viewMode: "years",
		});

	});

	function listarProcesoAnual(){
		let proceso_anual = $('#tabla_proceso_anual').DataTable();
        proceso_anual.clear().destroy();	

  		proceso_anual = $('#tabla_proceso_anual').DataTable({
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			"lengthChange": false,
			"ajax": "{{ route('listar.proceso.anual.data') }}",
			"columnDefs": [
            	{ //FECHA DE CREACIÓN
					"targets": 0,
					"className": 'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
				{ //GESTION COMUNITARIA
					"targets": 1,
					"className": 'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
				{ //CREADO POR
					"targets": 2,
					"className": 'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
				{ //ESTADO ACTUAL
					"targets": 3,
					"className": 'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
				@foreach ($acciones as $accion)
              		@if ($accion->cod_accion == "GCM02")
						{ //ACCIONES
							"targets": 4,
							"className": 'dt-head-center dt-body-center',
							"createdCell": function(td, cellData, rowData, row, col){
						        $(td).css("vertical-align", "middle");
						     
						    }
						}		
					@endif
				@endforeach
    		],				
			"columns": [{ //FECHA DE CREACIÓN
							 "data": "pro_an_fec",
							 "className": "text-center",
					 		"render": function(data, type, row){
								let fecha = new Date(data);
								let dia = fecha.getDate();
								let mes = fecha.getMonth() + 1;
								let año = fecha.getFullYear();

								if (dia < 10) {
							        dia = "0" + dia;
							    }
							    if (mes < 10) {
							        mes = "0" + mes;
							    }

								return `${dia}-${mes}-${año}`;
							}
						},
						{ //GESTION COMUNITARIA
							 "data": "pro_an_nom",
							 "className": "text-center",
							 "render": function(data, type, row){
								año = new Date(row.pro_an_fec); 
								pro_nom = row.pro_an_nom +' '+año.getFullYear();
								return pro_nom;
							 }
						},
						{ //CREADO POR
							"data": "nombre",
							"className": "text-center"
						},
						{ //ETAPA ACTUAL
							"data": "est_pro_nom",
							"className": "text-center"
						},
						// { //AVANCE
						// 	"data": ""
						// },
							//inicio Andres F
						@foreach ($acciones as $accion)
              				@if ($accion->cod_accion == "GCM02")
								{ //ACCIONES
									"data": "",
									"render": function(data, type, row){
										// INICIO DC SPRINT 64

										let html = '';
										if(row.est_pro_nom == "Desestimado"){
											html = '<div style="display: flex;"><div class="flex-item"><button type="button" data-pro-an-id="'+row.pro_an_id+'" class="btn btn-warning" onclick="{{ $accion->ruta }}"><i class="{{ $accion->clase }}"></i>  Ver</button></div><div class="flex-item"><button type="button" class="btn btn-primary" style="margin-left: 3px;margin-right: 3px;" data-toggle="modal" data-target="#estadoDesestimado" onclick="cargarModalVerDesestimacion('+row.pro_an_id+');"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16"><path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"></path><path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"></path></svg></button></div></div>';
										}else if(row.est_pro_nom == "Finalizado"){
											html = '<div style="display: flex;"><div class="flex-item"><button type="button" data-pro-an-id="'+row.pro_an_id+'" class="btn btn-warning" onclick="{{ $accion->ruta }}"><i class="{{ $accion->clase }}"></i>  Ver</button></div></div>';
										}else{
											html = '<div><div><button type="button" data-pro-an-id="'+row.pro_an_id+'" class="btn btn-warning" onclick="{{ $accion->ruta }}"><i class="{{ $accion->clase }}"></i>  {{ $accion->nombre }}</button></div></div>';
										}
										return html;
										// FIN DC SPRINT 64
									}
								},
							@endif
						@endforeach
					]
					//Fin Andres F.
		});
	 }
	 
	// function formatoFecha(){
	// 	// $('#form_pro_an_fec').datetimepicker('format', 'DD/MM/Y');
	// }
	//INCIO CZ SPRINT 56
	function cargarModalVerDesestimacion(id){
		$("#comentario_estado_desestimado").val("")
		bloquearPantalla();
		let data = new Object();
		data.id = id
		console.log(id);
		$.ajax({
			url: "{{ route('listar.proceso.obtenerComentarioDesestimacion') }}",
			type: "GET",
			data: data
		}).done(function(resp){
			console.log(resp);
			let respuesta = resp.estado;
			$("#comentario_estado_desestimado").val(respuesta[0].pro_est_des)
			desbloquearPantalla();
		}).fail(function(jqXHR, textStatus, errorThrown){
			desbloquearPantalla();
			let mensaje = "Hubo un error al momento de actualizar el estado de la derivación. Por favor intente nuevamente. \n \n";

			if (typeof jqXHR.responseJSON.mensaje != "undefined" && jqXHR.responseJSON.mensaje != ""){
				mensaje += "Error: "+jqXHR.responseJSON.mensaje+".";

			}else{
				mensaje += "Error: Sin información.";

			}

			alert(mensaje);
		});

	}
	//FIN CZ SPRINT 56 
	function validarFormularioProceso(){
		let respuesta   = true;
		let fec_ing     = $('#form_pro_an_fec').data('date');
		let nom         = $("#form_pro_an_nom").val();

		console.log(fec_ing);

		if (fec_ing == "" || typeof fec_ing === "undefined"){
			respuesta = false;
			$("#val_frm_pro_an_fec").show();
		}

		if (nom == "" || typeof nom === "undefined"){
			respuesta = false;
			$("#val_frm_pro_an_nom").show();
		}

		return respuesta;
	}

	function verificarProcesoCrear(){

		let data = new Object();

		data.com_id = {{Session::get('com_id')}};

		$.ajaxSetup({
    		headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
   	 		}
		});

		$.ajax({
			type: "POST",
			url: "{{ route('verificar.proceso.anual') }}",
			data: data
		}).done(function(resp){

			if(resp.estado > 0){

				mensaje = 'Debe culminar el proceso actual.';
				mensajeTemporalRespuestas(0, mensaje);
				
			}else{
				limpiarFormularioProceso();
				$('#frmProceso').modal('show');				
			}

		}).fail(function(objeto, tipoError, errorHttp){

			manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

			return false;
		});

	}

	function crearProcesoAnual(){

		let val_form = validarFormularioProceso();
    	if (!val_form){ return false; }
		bloquearPantalla();

		let data = new Object();

		data.pro_an_fec 	= $('#form_pro_an_fec').data('date');
		data.pro_an_nom 	= $('#form_pro_an_nom').val();

		$.ajaxSetup({
    		headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
   	 		}
		});

		$.ajax({
  			type: "POST",  
			url: "{{ route('crear.proceso.anual') }}",
			data: data
		}).done(function(resp){
			desbloquearPantalla();

  			if (resp.estado == 1){
				  listarProcesoAnual();
				  $('#frmProceso').modal('hide'); 
				  limpiarFormularioProceso();

  				mensajeTemporalRespuestas(1, resp.mensaje);
  			}else if(resp.estado == 0){
  				mensajeTemporalRespuestas(0, resp.mensaje);

  			}
		}).fail(function(objeto, tipoError, errorHttp){
			desbloquearPantalla();

			manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

			return false;
		});
	}	

	function limpiarFormularioProceso(){
		
		$('#form_pro_an_fec').datetimepicker('clear');
		$("#form_pro_an_nom").val("");

		$('#val_frm_pro_an_fec').hide();
		$("#val_frm_pro_an_nom").hide();
	}

	function editarProcesoAnual(_this){
		let id = $(_this).attr("data-pro-an-id");
		let url = "{{ route('gestion.proceso.anual') }}";

		location.href = url+"?tipo_gestion=0&pro_an_id="+id;
	}
</script>
<!-- INICIO CZ SPRINT 56 -->
<style>
#tabla_proceso_anual tbody td.dt-body-center {
    text-align: initial;
}
</style>
<!-- FIN CZ SPRINT 56 -->
@endsection