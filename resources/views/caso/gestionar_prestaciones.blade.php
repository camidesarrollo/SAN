@extends('layouts.main')

@section('contenido')

	<section class="p-1 cabecera">
		<div class="container-fluid">
			<div class="row align-items-center">
				<div class="col-md-12">
					<h5> <i class="{{$icono}}"></i> {{ $nombre_ventana }}</h5>
				</div>
			</div>
		</div>
	</section>

	@if(Session::has('success'))
		<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>{{ Session::get('success') }}</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	@endif
	@if(Session::has('danger'))
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
			<strong>{{ Session::get('danger') }}</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	@endif

	@if ($errors->any())
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
	@endif

	<section>
		<div class="container-fluid">
			<div class="card p-4 shadow-sm">
				<!--<h5>Total Integrantes Asignados <span class="badge badge-warning" id="total_integrantes_asignados">0</span></h5>
				<h5>Total Casos <span class="badge badge-danger">0</span></h5>-->
				<h5 style="font-weight: 600;">Integrantes derivados</h5>
				
				<table id="prestaciones_asignadas" class="table w-100">
					<thead>
						<tr>
							<th>Caso</th>
							<th>Integrantes</th>
							<th>RUN</th>
							<th>Gestor</th>
							<th>Programa o iniciativa que requiere</th>
							<!-- INCIO CZ SPRINT 56 -->
							<th>Fecha derivación</th>
							<th>Estado derivación</th>
							<!-- FIN CZ SPRINT 56 -->
							<th>Gestión</th>
							<th>Run Sin Formato</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>

			</div>
		</div>
	</section>

@includeif('caso.cambiar_estado_prestacion_modal')
<!-- INICIO CZ SPRINT 56 -->
@include('caso.estado_prestacion_modal')
<!-- FIN CZ SPRINT 56 -->
@stop
@section('script')
<script type="text/javascript">
	$(document).ready(function(){
		cargarPrestacionesAsignadas();
	});

	function cargarPrestacionesAsignadas(){
		bloquearPantalla();

		let table = $('#prestaciones_asignadas').DataTable();
        table.clear().destroy();
                
        table = $('#prestaciones_asignadas').DataTable({
        	"order": [[4, "asc"]],
			"serverSide": true,
			"language"	: {"url": "{{ route('index') }}/js/dataTables.spanish.json"},
			"ajax":{
				"type": "GET",
				"url": "{{ route('casos.gestionar.prestaciones.listar') }}"
			},
			"columnDefs": [
		        { 
		        	"targets": 0,
					"className": 	'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col){
				        $(td).css("vertical-align", "middle");
				     
				    }
		        },
		        { 
		        	"targets": 1,
					"className": 	'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col){
				        $(td).css("vertical-align", "middle");
				     
				    }
		        },
		        { 
		        	"targets": 2,
					"className": 	'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col){
				        $(td).css("vertical-align", "middle");
				     
				    }
		        },
		        { 
		        	"targets": 3,
					"className": 	'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col){
				        $(td).css("vertical-align", "middle");
				     
				    }
		        },
		        { 
		        	"targets": 4,
					"className": 	'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col){
				        $(td).css("vertical-align", "middle");
				     
				    }
		        },
		        { 
		        	"targets": 5,
					"className": 	'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col){
				        $(td).css("vertical-align", "middle");
				     
				    }
		        },
		        { 
		        	"targets": 6,
					"className": 	'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col){
				        $(td).css("vertical-align", "middle");
				     
				    }
		        },
		        { 
		        	"targets": 7,
					"className": 	'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col){
				        $(td).css("vertical-align", "middle");
				     
				    }
		        },
		        { targets: [8], visible: false},
		    ],
			"columns":[
				{
					"data": 		"cas_id",
					"name": 		"cas_id",
					"width": 		"10%"
			 	},
			 	{
			 		"data": 		"",
					"name": 		"",
				 	"orderable": 	false,
					"searchable": 	false,
					"width": 		"23%",
				 	"render": function(data, type, row){ 

				 		if(!row.gru_fam_telefono) row.gru_fam_telefono="Sin información";

				 		if(!row.gru_fam_email) row.gru_fam_email="Sin información";

				 		let result = '<label  title="Fono: '+row.gru_fam_telefono+' Correo: '+row.gru_fam_email+'">'+row.nombre_integrante+'</label>';

				 		return result;
				 	}
			 	},

			 	{
			 		"data": 		"gru_fam_run_formato",
					"name": 		"gru_fam_run_formato",
					"width": 		"13%",
				 	"render": function(data, type, row){ 
				 		let run = esconderRut(data, "{{ config('constantes.ofuscacion_run') }}");

				 		return run;
				 	}
			 	},
			 	{
			 		"data": 		"",
					"name": 		"",
				 	"orderable": 	false,
					"searchable": 	false,
					"width": 		"30%",
				 	"render": function(data, type, row){ 
				 		let result = '<label  title="Fono: '+row.fono_gestor+' Correo: '+row.correo_gestor+'">'+row.nombre_gestor+'</label>';
				 		return result;
				 	}
			 	},
			 	{
			 		"data": 		"pro_nom",
					"name": 		"pro_nom",
					"width": 		"30%"
			 	},
			 	{
			 		"data": 		"fecha_derivacion",
					"name": 		"fecha_derivacion"
			 	},
			 	{
			 		"data": 		"est_prog_nom",
					"name": 		"est_prog_nom",
					"width": 		"20%"
			 	},
			 	{
			 		"data": 		"",
					"name": 		"",
				 	"orderable": 	false,
					"searchable": 	false,
				 	"render": function(data, type, row){
				 		let val_estado = false;
				 		//let html = '<button type="button" class="btn btn-primary" disabled>Gestionar</button>';
						//  INICIO CZ SPRINT 56
						let html = '<div style="display: flex;"><div class="flex-item"><button type="button" class="btn btn-primary" style="margin-left: 3px;margin-right: 3px;" disabled>Gestionar</button></div><div class="flex-item"><button type="button" class="btn btn-primary" style="margin-left: 3px;margin-right: 3px;" data-toggle="modal" data-target="#estadoPrestacion" onclick="cargarModalVerDerivacion('+row.am_prog_id+');"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16"><path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"></path><path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"></path></svg></button></div></div>'
						 //FIN CZ SPRINT 56
				 	    if ((row.est_cas_id == "{{ config('constantes.en_ejecucion_paf') }}" || row.est_cas_id == "{{ config('constantes.en_cierre_paf') }}" || row.est_cas_id == "{{ config('constantes.en_seguimiento_paf') }}") && row.est_prog_id == "{{ config('constantes.pendiente') }}"){
				 	    	val_estado = true;
				 	    	
				 	    }

				 	    if (val_estado){
				 		   	html = '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#cambiarEstadoPrestacion" onclick="cargarModalEstadoDerivaciones('+row.am_prog_id+');">Gestionar</button>';
				 		
				 		}

				 		return html;
				 	}
			 	},
			 	{
					"data": 		"gru_fam_run",
					"name": 		"gru_fam_run",
					"className": 	"text-center"
				}
			],
			"drawCallback": function (settings){
				desbloquearPantalla();
				//$("#total_integrantes_asignados").text(settings._iRecordsTotal);
			
			}
        });

	}

	function validarCambioEstadoDerivacion(){
		let respuesta = true;
		let motivo = $("#motivo_cambio_estado_derivacion").val();
		let comentario = $("#comentario_cambio_estado_derivacion").val().trim();

		if (typeof motivo == "undefined" || motivo == ""){
			respuesta = false;
			$("#val_motivo_cambio_estado_derivacion").show();
			$("#motivo_cambio_estado_derivacion").addClass("is-invalid");

		}else{
			$("#val_motivo_cambio_estado_derivacion").hide();
			$("#motivo_cambio_estado_derivacion").removeClass("is-invalid");

		}

		if (comentario === "" || comentario.length < 3 || typeof comentario == "undefined"){
			respuesta = false;
			$("#val_comentario_cambio_estado_derivacion").show();
			$("#comentario_cambio_estado_derivacion").addClass("is-invalid");

		}else{
			$("#val_comentario_cambio_estado_derivacion").hide();
			$("#comentario_cambio_estado_derivacion").removeClass("is-invalid");

		}

		return respuesta;
	}

	function cargarModalEstadoDerivaciones(id){
		$("#id_derivacion_asignada").val(id);

		document.getElementById("motivo_cambio_estado_derivacion").value = '';
		$("#comentario_cambio_estado_derivacion").val("");
		$("#cantidad_caracteres_comentario").text(0);

		$("#val_motivo_cambio_estado_derivacion").hide();
		$("#val_comentario_cambio_estado_derivacion").hide();
		$("#motivo_cambio_estado_derivacion").removeClass("is-invalid");
		$("#comentario_cambio_estado_derivacion").removeClass("is-invalid");
	}
		// INICIO CZ SPRINT 56
	function cargarModalVerDerivacion(id){
		$("#txtmotivo_estado_derivacion").val("");
		$("#comentario_estado_derivacion").val("");

		bloquearPantalla();
		let data = new Object();
		data.id = id
		console.log(id);
		$.ajax({
			url: "{{ route('casos.gestionar.prestaciones.ver.estados') }}",
			type: "GET",
			data: data
		}).done(function(resp){
			$("#txtmotivo_estado_derivacion").val(resp.respuesta[0].est_prog_nom);
			$("#comentario_estado_derivacion").val(resp.respuesta[0].est_prog_bit_des);
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
	// FIN CZ SPRINT 56


	function cambiarEstadoDerivacion(){
		let validacion = validarCambioEstadoDerivacion();
		if (!validacion) return false;

		let confirmacion = confirm("¿Esta seguro que desea cambiar el estado de la derivación?");
   		if (!confirmacion) return false;

   		let data = new Object();
   		data.id = $("#id_derivacion_asignada").val();
   		data.estado = document.getElementById("motivo_cambio_estado_derivacion").value;
   		data.comentario = $("#comentario_cambio_estado_derivacion").val();
		
		$.ajax({
			url: "{{ route('casos.gestionar.prestaciones.estados') }}",
			type: "GET",
			data: data
		}).done(function(resp){
			if (resp.estado == 1){
				alert(resp.mensaje);
				$('#cambiarEstadoPrestacion').modal('hide');
				cargarPrestacionesAsignadas();

			}else if (resp.estado == 0){
				alert(resp.mensaje);

			}
		}).fail(function(jqXHR, textStatus, errorThrown){
			let mensaje = "Hubo un error al momento de actualizar el estado de la derivación. Por favor intente nuevamente. \n \n";

			if (typeof jqXHR.responseJSON.mensaje != "undefined" && jqXHR.responseJSON.mensaje != ""){
				mensaje += "Error: "+jqXHR.responseJSON.mensaje+".";

			}else{
				mensaje += "Error: Sin información.";

			}

			alert(mensaje);
			console.log(jqXHR);
		});
	}

	contenido_textarea_derivacion_estados = ""; 
  	function valTextAreaCambioEstadoDerivacion(){
      num_caracteres_permitidos   = 2000;

      num_caracteres = $("#comentario_cambio_estado_derivacion").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#comentario_cambio_estado_derivacion").val(contenido_textarea_derivacion_estados);

       }else{ 
          contenido_textarea_derivacion_estados = $("#comentario_cambio_estado_derivacion").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cantidad_caracteres_comentario").css("color", "#ff0000"); 

       }else{ 
          $("#cantidad_caracteres_comentario").css("color", "#000000");

       } 

      
       $("#cantidad_caracteres_comentario").text($("#comentario_cambio_estado_derivacion").val().length);
   	}
</script>
<!-- INICIO CZ SPRINT 56 -->
<style>
#prestaciones_asignadas tbody td.dt-body-center {
    text-align: initial;
}
</style>
<!-- FIN CZ SPRINT 56 -->
@endsection