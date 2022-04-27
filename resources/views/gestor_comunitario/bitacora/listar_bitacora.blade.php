<div class="table-responsive">
	@foreach ($acciones as $accion)
        @if ($accion->cod_accion == "GCM03")
			<div class="text-right mb-2">
				<a href="#crear" onclick="{{ $accion->ruta }}" class="btn btn-success" data-toggle="tooltip" data-placement="left" title="Nueva Bitacora" id="IDnuevo" ><i class="{{ $accion->clase }}"></i>  {{ $accion->nombre }}</a>
			</div>
		@endif
	@endforeach

	<table class="table table-striped table-hover w-100" cellspacing="0" id="tabla_bitacora">
		<thead>
			<tr>
				<th>Fecha de Bitácora</th>
				<th>Título</th>
				<th>Nº de Actividades</th>
				<th>Creado por</th>
				@foreach ($acciones as $accion)
        			@if ($accion->cod_accion == "GCM04")
						<th>Acciones</th>
					@endif
				@endforeach
			</tr>
			
		</thead>
		<tbody></tbody>
	</table>
</div>
<!-- INICIO CZ SPRINT 67 -->

	<div id="modalEliminarBitacora" class="modal fade" tabindex="-1"
	role="dialog" aria-labelledby="tit_modalEliminarBitacora"
	aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content p-4">
			<div class="card p-4 shadow-sm">
				<h5 class="modal-title text-center" id="tit_modalEliminarBitacora">
					¿Seguro(a) que desea eliminar Bitacora<span
						id="tit_prob2"></span>?
				</h5>
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true"
						style="position: absolute; right: 5px; top: 5px; width: 23px; height: 23px; padding: 0; margin: 0;">&times;</span>
				</button>
				<br> <br> <input type="hidden" id="modalEliminarBitacora">
				<div class="text-right">
					<button type="button" 
						class="btn btn-danger" id="confirm-eliminarBitacora">Eliminar Bitacora</button>
					<button type="button" class="btn btn-secondary"
						data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- FIN CZ SPRINT 67 -->
<script type="text/javascript">
function listarBitacora(){
	let tabla_bitacora = $('#tabla_bitacora').DataTable();
	tabla_bitacora.clear().destroy();	

    let data 		= new Object();
	data.pro_an_id 	= $('#pro_an_id').val();
	data.tipo = getTipoGestion();
	
	tabla_bitacora = $('#tabla_bitacora').DataTable({
		"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
		"lengthChange": false,
		"searching": 	false,
		"ajax": {
			"url": "{{ route('listar.bitacora.data') }}",
			"data": data	
		},
		"columnDefs": [
        	{ //FECHA DE CREACION
				"targets": 0,
				"className": 'dt-head-center dt-body-center',
				"createdCell": function (td, cellData, rowData, row, col) {
			        $(td).css("vertical-align", "middle");
			     
			    }
			},
			{ //TITULO
				"targets": 1,
				"className": 'dt-head-center dt-body-left',
				"createdCell": function (td, cellData, rowData, row, col) {
			        $(td).css("vertical-align", "middle");
			     
			    }
			},
			{ //ACTIVIDADES
				"targets": 2,
				"className": 'dt-head-center dt-body-center',
				"createdCell": function (td, cellData, rowData, row, col) {
			        $(td).css("vertical-align", "middle");
			     
			    }
			},
			{ //CREADO POR
				"targets": 3,
				"className": 'dt-head-center dt-body-center',
				"createdCell": function (td, cellData, rowData, row, col) {
			        $(td).css("vertical-align", "middle");
			     
			    }
			},
			@foreach ($acciones as $accion)
        		@if ($accion->cod_accion == "GCM04")
					{ //ACCIONES
						"targets": 4,
						"className": 'dt-head-center dt-body-center',
						"createdCell": function (td, cellData, rowData, row, col) {
					        $(td).css("vertical-align", "middle");
					     
					    }
					}
				@endif
			@endforeach
		],				
		"columns": [{ //
						 "data": "bitacorausu.bit_fec_cre",
						 "className": "text-center",
				 	 	"render": function(data, type, row){
							let fec_sht = row.bitacorausu.bit_fec_cre.substring(0,10);
							let fec = fec_sht.split('-');
							let fecha = fec[2]+'-'+fec[1]+'-'+fec[0];							

							return fecha;
						}

					},
					{ //
						 "data": "bitacorausu.bit_tit",
						 "className": "text-center"
					},
					{ //
						"data": "actividades",
						"className": "text-center"
					},
					{ //
						"data": "usuarios.nombre_completo",
						"className": "text-center"
					},
					@foreach ($acciones as $accion)
        				@if ($accion->cod_accion == "GCM04")
							{ //ACCIONES
								"data": "",
								"render": function(data, type, row){
									let html = '<div>'	
									// INICIO CZ SPRINT 67
									 html += '<button type="button" class="btn btn-warning editarBitacora" data-bit-id="'+row.bit_id+'" onclick="{{ $accion->ruta }}"><i class="{{ $accion->clase }}"></i>  {{ $accion->nombre }}</button>';
									//  FIN CZ SPRINT 67
									 html += ' <button type="button" class="btn btn-danger" id ="btn-eliminarBitacora" data-toggle="modal" data-target="#modalEliminarBitacora" onclick="enviarParametroBitacora('+row.bit_id+')">Eliminar bitacora</button>';
									 html += '</div>'
									//INICIO CZ SPRINT 67 correccion
									if($("#est_pro_id").val() == {{ config('constantes.finalizado') }} || $("#est_pro_id").val() == {{ config('constantes.desestimado') }} ){
										$('.btn-danger').attr('disabled', 'disabled');
										$('.editarBitacora').removeAttr('disabled', 'disabled');
									}
									//FIN CZ SPRINT 67 correccion
									
									return html;
								}
							},
						@endif
					@endforeach

				]
	});
}
// INICIO CZ SPRINT 67
function enviarParametroBitacora(id){
	$("#confirm-eliminarBitacora").attr('onclick', 'eliminarBitacora("'+id+'")');
}
// FIN CZ SPRINT 67
function crearBitacora(){
	// INICIO CZ SPRINT 67
	$("#editarDatosBitacora").css("display", "none");
	if($("#est_pro_id").val() == {{ config('constantes.finalizado') }} || $("#est_pro_id").val() == {{ config('constantes.desestimado') }} ){
		$('#botonGuardarBitacora').attr('disabled', 'disabled');
	}
	// FIN CZ SPRINT 67
	$('#form_bit_fec_ing').datetimepicker('format', 'DD/MM/Y');
	limpiarFormularioBitacora();
	desplegarSeccionBitacora(2);
	mostrarSeccionFormularioBitacora(1);
}

function getTipoGestion(){

	menu = '{{ $menu }}';

	if(menu === 'Gestión Comunitaria'){
		return 0;
	}else if(menu === 'Plan Comunal'){
		return 1;
	}
}

function editarBitacora(_this){
	let bit_id = $(_this).attr("data-bit-id");
	// INICIO CZ SPRINT 67 
	$("#editarDatosBitacora").attr('onclick', 'editarDatos("'+bit_id+'")');
	$("#editarDatosBitacora").css("display", "initial");
	if($("#est_pro_id").val() == {{ config('constantes.finalizado') }} || $("#est_pro_id").val() == {{ config('constantes.desestimado') }} ){
			$( ".ingresarActividad" ).prop( "disabled", true );
			$('input').attr('disabled', 'disabled');
        }
	// FIN CZ SPRINT 67
	let data = new Object();
	data.pro_an_id 	= $("#pro_an_id").val();
	data.bit_id 	= bit_id;

	bloquearPantalla();

    $.ajax({
        type: "GET",  
        url: "{{ route('bitacora.editar') }}",
        data: data
    }).done(function(resp){
        desbloquearPantalla();

        if (resp.estado == 1){
			 //INICIO CZ SPRINT 67 correccion
			 if($("#est_pro_id").val() == {{ config('constantes.finalizado') }} || $("#est_pro_id").val() == {{ config('constantes.desestimado') }} ){
            	$('#editarDatosBitacora').attr('disabled', 'disabled');
       		 }
        //FIN CZ SPRINT 67 correccion

        	limpiarFormularioBitacora();

        	let fec = new Date(resp.respuesta.bit_fec_cre);
			fec = fec.getDate()+"/"+(fec.getMonth() + 1 )+"/"+fec.getFullYear();

			
			$('#form_bit_fec_ing').datetimepicker('format', 'DD/MM/Y');
			$('#form_bit_fec_ing').datetimepicker('date', fec);			

			$("#form_bit_nom").val(resp.respuesta.bit_tit);
			$("#current_name").html(resp.respuesta.bit_tit);
			
			$('#form_bit_fec_ing input').prop( "disabled", true );
			$('#form_bit_nom').prop( "disabled", true );

        	$("#bit_id").val(bit_id);
            desplegarSeccionBitacora(2);
            mostrarSeccionFormularioBitacora(2);

        }else if(resp.estado == 0){
            mensajeTemporalRespuestas(0, resp.mensaje);

        }
    }).fail(function(objeto, tipoError, errorHttp){
        desbloquearPantalla();

        manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

        return false;
    });
}
// INICIO CZ SPRINT 67
function eliminarBitacora(id){
    bloquearPantalla();
	let data = new Object();
	data.bit_id = id;
	$.ajaxSetup({
				headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}
			});
	$.ajax({
			type:"post",
			url: "{{route('eliminarBitacora')}}",
			data: data
		}).done(function(resp){
			$('#modalEliminarBitacora').modal('hide')
			desbloquearPantalla();
			if(resp.estado == 1){
				toastr.success(resp.mensaje);  
				listarBitacora();      
			}
		}).fail(function(objeto, tipoError, errorHttp){            
			desbloquearPantalla();
			manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

			return false;
		});
}
// FIN CZ SPRINT 67
</script>