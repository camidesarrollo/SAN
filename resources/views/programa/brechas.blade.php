@extends('layouts.main')

@section('contenido')
	
	<section class="p-1 cabecera">
		<div class="container-fluid">
			<div class="row align-items-center">
				<div class="col-md-12">
					<h5> <i class="{{$icono}}"></i> Brechas</h5>
				</div>
			</div>
		</div>
	</section>

	<section>
		<div class="container-fluid">
			<div class="card p-4 shadow-sm">
				
				<table id="brechas" class="table table-hover table-striped w-100">
					<thead>
						<tr>
							<th>id_brecha</th>
							<th style="width: 265px;">Programa ó iniciativa</th>
							<th style="width: 200px;">Institución</th>
							<th>Cupos Comunales</th>
							<th>Brecha Mensual</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>

			</div>
		</div>
	</section>

	@includeif('programa.modal_brechas')
	@includeif('programa.modal_bitacora_brecha')

@stop

@section('script')
<script type="text/javascript" >
	$(document).ready(function(){

		dataTable_brechas = $('#brechas').DataTable({
			"ajax":{
				"url":"{{route('listarProgramasConBrechas')}}"
			},
			"columns":[
			{
				"data": 		"id_brecha",
				"name": 		"id_brecha",
			 	"className": 	"text-left",
			 	"visible": 		false
			}, 
			{
				"data": 		"pro_nom",
				"name": 		"pro_nom",
			 	"className": 	"text-left",
			}, 
			{
				"data": 		"pro_inst_resp",
				"name": 		"pro_inst_resp",
			 	"className": 	"text-left",
			}, 
			{
				"data": 		"pro_cup",
				"name": 		"pro_cup",
			 	"className": 	"text-left",
			}, 
			{
				"data": 		"brecha_mensual",
				"name": 		"brecha_mensual",
			 	"className": 	"text-left",
			}, 
			{																					
				"className": 	"text-center",
				"orderable": 	false,
				"searchable": 	false,
				"render": 		function(data,type,row){
					
					var botonBrechas = '<button class="btn btn-primary btn-sm" onclick="VerbrechasIntegrantes('+row.id_brecha+');">Brechas</button>&nbsp;<button class="btn btn-primary btn-sm" onclick="BitacoraBrecha('+row.id_brecha+');">Bitácora</button>';
				
					return botonBrechas;
					
				}
			}
			],
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"}
		});

	});	

	function grabarBrecha(){

		let observacion = $('#bitacora').val();
		let id_brecha = $('#id_brecha').val();

		if (observacion==''){
			alert('Debe escribir la bitácora a ser almacenada, intente de nuevo por favor');
		}else{

			toastr.options = {
	            "closeButton": true,
	            "debug": true,
	            "newestOnTop": true,
	            "progressBar": false,
	            "positionClass": "toast-top-center",
	            "preventDuplicates": true,
	            "onclick": null,
	            "showDuration": "0",
	            "hideDuration": "0",
	            "timeOut": "2000",
	            "extendedTimeOut": "2000",
	            "showEasing": "swing",
	            "hideEasing": "linear",
	            "showMethod": "fadeIn",
	            "hideMethod": "fadeOut"
	        };

			$.ajax({
				url: "{{ route('grabarBrecha') }}"+"/"+id_brecha+"/"+observacion,
				type: "GET"
			}).done(function(resp){

				if (resp.estado == 1){
					$('#bitacora').val('');
					var tabla = $('#tabla_bitacora_brecha').DataTable();
					tabla.ajax.reload(null,false);
					toastr.success("Bitácora registrada con éxito.");
				}else{
					toastr.error("Error al momento de guardar la bitácora. Por favor intente nuevamente.");
				}

			}).fail(function(obj){
				toastr.error("Error al momento de guardar la bitácora. Por favor intente nuevamente.");
			});

		}

	}


	function BitacoraBrecha(id_brecha){

		$('#id_brecha').val(id_brecha);
		$('#bitacora').val('');
		
		$('#ModalBitacoraBrecha').modal('show');

		if ( $.fn.dataTable.isDataTable('#tabla_bitacora_brecha')) {
			var dataTable_bitacora_brecha = $('#tabla_bitacora_brecha').DataTable();
        	dataTable_bitacora_brecha.clear().destroy();
		}


		dataTable_bitacora_brecha = $('#tabla_bitacora_brecha').DataTable({
			"ajax":{
				"url":"{{route('BitacoraBrecha')}}"+"/"+id_brecha
			},
			"columns":[
			{
				"data": 		"coordinador",
				"name": 		"coordinador",
			 	"className": 	"text-left",
			}, 
			{
				"data": 		"fecha",
				"name": 		"fecha",
			 	"className": 	"text-left",
			}, 
			{
				"data": 		"comentario",
				"name": 		"comentario",
			 	"className": 	"text-left",
			} 
			],
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"}
		});

	}

	function VerbrechasIntegrantes(id_brecha){

		$('#ModalBrechas').modal('show');

		if ( $.fn.dataTable.isDataTable('#tabla_detalle_brechas')) {
			var dataTable_detalle_brechas = $('#tabla_detalle_brechas').DataTable();
        	dataTable_detalle_brechas.clear().destroy();
		}

		dataTable_detalle_brechas = $('#tabla_detalle_brechas').DataTable({
			"ajax":{
				"url":"{{route('listarBrechas')}}"+"/"+id_brecha
			},
			"rowGroup": {
				startRender: function ( rows, group ) {
                	return "Caso " + group;
				},
            	dataSrc: "id_caso"
        	},
			"columns":[
			{
				"data": 		"gestor",
				"name": 		"gestor",
			 	"className": 	"text-left"
			}, 
			{
				"data": 		"rut_integrante_con_formato",
				"name": 		"rut_integrante_con_formato",
			 	"className": 	"text-left"
			}, 
			{
				"data": 		"nombre_integrante",
				"name": 		"nombre_integrante",
			 	"className": 	"text-left",
			}, 
			{
				"data": 		"ale_tip_nom",
				"name": 		"ale_tip_nom",
			 	"className": 	"text-left",
			}, 
			{
				"data": 		"comentario",
				"name": 		"comentario",
			 	"className": 	"text-left",
			}, 
			{																					
				"className": 	"text-center",
				"orderable": 	false,
				"searchable": 	false,
				"render": 		function(data,type,row){
					
					var botonBrechas = '<button class="btn btn-primary btn-sm" onclick="FinalizarBrecha('+row.id_brecha_inte_caso+');">Finalizar</button>';
				
					return botonBrechas;
					
				}
			},
			{
				"data": 		"rut_integrante_sin_formato",
				"name": 		"rut_integrante_sin_formato",
			 	"className": 	"text-left",
			 	"visible": 		false
			}
			],
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"}
		});

	}

	function FinalizarBrecha(id_brecha_inte_caso){

		toastr.options = {
            "closeButton": true,
            "debug": true,
            "newestOnTop": true,
            "progressBar": false,
            "positionClass": "toast-top-center",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "0",
            "hideDuration": "0",
            "timeOut": "2000",
            "extendedTimeOut": "2000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };


		var respuesta = confirm("¿Está seguro de finalizar la brecha?");
		
		if (respuesta == true) {
			$.ajax({
				url: "{{ route('finalizarBrecha') }}"+"/"+id_brecha_inte_caso,
				type: "GET"
			}).done(function(resp){

				if (resp.estado == 1){

					var tabla = $('#tabla_detalle_brechas').DataTable();
					tabla.ajax.reload(null,false);

					var tabla = $('#brechas').DataTable();
					tabla.ajax.reload(null,false);

					toastr.success("Brecha finalizada con éxito.");

				}else{
					toastr.error("Error al momento de finalizar la brecha. Por favor intente nuevamente.");
				}


			}).fail(function(resp){
				toastr.error("Error al momento de finalizar la brecha. Por favor intente nuevamente.");
			});
		}

	}

</script>
@endsection