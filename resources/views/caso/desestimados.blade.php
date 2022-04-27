<!-- //CZ SPRINT 73 -->
@extends('layouts.main')
@section('contenido')
<style>
.dot {
	height: 15px;
    width: 15px;
    background-color: #39FF14;
  border-radius: 50%;
  display: inline-block;
}
</style>
	<section class="p-1 cabecera">
		<div class="container-fluid">
			<div class="row align-items-center">
				<div class="col-md-12">
					<h5> <i class="{{$icono}}"></i> Casos Desestimados </h5>
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
					<h5>Total NNA <span class="badge badge-warning" id="totalNNA">0</span></h5>
					
				<!-- INICIO CZ SPRINT 59  -->
				<table id="desestimados" class="table table-hover table-striped w-100" attr2="{{route('coordinador.caso.ficha')}}" >
				<!-- //CZ SPRINT 73 -->	
				<!-- FIN CZ SPRINT 59  -->
					<thead>
						<tr>
							<!-- //INICIO CZ SPRINT 72 -->
							<th colspan="12"><div id="filtros-table"></div></th>
							<!-- //FIN CZ SPRINT 72 -->
						</tr>
						<tr>
							<!-- //INICIO CZ SPRINT 72 -->
							<th style="display: none"></th>
							<th style="display: none"></th>
							<th style="display: none"></th>
							<!-- //FIN CZ SPRINT 72 -->
							<th>Nombre NNA</th>
							<th></th>
							<!--<th>Prioridad</th>-->
							<th>Alerta Nómina</th>
							<th>Últimas<br>Alertas SAN</th>
							<th>Estado Gesti&oacute;n Caso
								<!-- //INICIO CZ SPRINT 72 -->
								<br>
								<br>
								<select id="estados" class="form-control form-control-sm"></select>
								<!-- //FIN CZ SPRINT 72 -->
							</th>
							<th>Estado Terapia Caso</th>
							<!-- //INICIO CZ SPRINT 72 -->
							<th>Nombre Gestor</th>
							<!-- //FIN CZ SPRINT 72 -->
							<th>Seguimiento</th>
							<!-- //INICIO CZ SPRINT 72 -->
							<th>Acciones</th>
							<!-- //FIN CZ SPRINT 72 -->
						</tr>
					</thead>
					<tbody></tbody>
						<!-- //CZ SPRINT 73 -->
				</table>

			</div>
		</div>
	</section>

	<input type="hidden" name="url_egresos_caso_desestimados" id="url_egresos_caso_desestimados" value="{{ route('egreso.casos.desestimados') }}">
	<!-- //INICIO CZ SPRINT 72 -->
	<div id="formBitacoraCaso" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="formBitacoraCaso" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content p-4">
				<div class="card p-4 shadow-sm">
					<div class="row">
						<div class="col-11 text-center">
							<h5 class="modal-title" id="titulo_modal_bitacora_estados"><b>Bitácora de Estados del Caso</b></h5>
						</div>
						<div class="col-1">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					</div><br>
					<div class="row pl-3">
						<label>RUN NNA:</label>&nbsp
						<p id="run_nna_bitacora_estado"></p>
					</div>
					<hr>
						
						<table class="table table-bordered table-hover table-striped w-100" cellspacing="0" id="tabla_bitacora">
							<thead>
								<tr>
									<th class="text-center">Estado</th>
									<th class="text-center">Descripción</th>
									<th class="text-center">Fecha</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>

						<hr>

						<div class="text-right">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
						</div>


				</div>
			</div>
		</div>
	</div>

	<div id="formBitacoraTerapia" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="formBitacoraTerapia" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content p-4">
				<div class="card p-4 shadow-sm">
					<div class="row">
						<div class="col-11 text-center">
							<h5 class="modal-title"><b>Bitácora de Estados de Terapia</b></h5>
						</div>
						<div class="col-1">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					</div><br>
					<div class="row pl-3">
						<label>RUN NNA:</label>&nbsp
						<p id="run_nna_bitacora_estado_terapia"></p>
					</div>
					<hr>
						
						<table class="table table-bordered table-hover table-striped w-100" cellspacing="0" id="tabla_bitacora_terapia">
							<thead>
								<tr>
									<th class="text-center">Estado</th>
									<th class="text-center">Fecha</th>
									<th class="text-center">Descripción</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>

						<hr>

						<div class="text-right">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
						</div>


				</div>
			</div>
		</div>
	</div>
	<!-- //FIN CZ SPRINT 72 -->



<!-- include modal	 -->

@include('caso.confirmacion_desestimacion_caso_modal')
@include('caso.ver_detalle_seguimiento_desestimacion_modal')


@stop

@section('script')
<script type="text/javascript" >
	//INICIO CZ SPRINT 72 
		let filtrolet=null;
	//FIN CZ SPRINT 72 
	$(document).ready(function(){
		//INICIO CZ SPRINT 72 
		obtenerDestimados();
		//FIN CZ SPRINT 72 
		//cargarListaDesestimados();
		var int_date = new Date();
		var int_firstDay = new Date(int_date.getFullYear(), int_date.getMonth(), 1);

		$('#int_date_').datetimepicker({
			locale: 'es',
			maxDate: $.now(),
			minDate: new Date('2019/06/01'),
			defaultDate: int_firstDay,
			format: 'DD/MM/Y'
		});

		$('#estado_seguimiento').change(function(){
		  // $('#diagnostico1').removeAttr('disabled');
		  if($("#estado_seguimiento").val() == "8" || $("#estado_seguimiento").val() == "9" || $("#estado_seguimiento").val() == "10"){
		  	$('#prog_atencion').prop('disabled', false);
		  	$('#nom_proyecto').prop('disabled', false);
		  
		  }else{
		  	
		  	$("#prog_atencion").val("");
			var nom_proyecto = '<option value="">Seleccione Programa de Atención</option>';
			$("#nom_proyecto").html(nom_proyecto);
		  	$('#prog_atencion').prop('disabled', 'disabled');
        	$('#nom_proyecto').prop('disabled', 'disabled');
		  	
		  }
		});

		$("#prog_atencion").change(function(){
		      let prog_atencion = $(this).val();

		      if(prog_atencion == ""){
		      	var proyecto_select = '<option value="">Seleccione Programa de Atención</option>';
		      	$("#nom_proyecto").html(proyecto_select);
		      	return false
		      }

		      $.get('/programaByProyecto/'+prog_atencion, function(data){
		//esta el la peticion get, la cual se divide en tres partes. ruta,variables y funcion
		        // console.log(data);
		          var proyecto_select = '<option value="">Seleccione Proyecto</option>'
		            for (var i=0; i<data.length;i++)
		              proyecto_select+='<option value="'+data[i].pro_seg_cod_proy+'">'+data[i].pro_seg_nom+'</option>';

		            $("#nom_proyecto").html(proyecto_select);

		      });
		});
					
		bloquearPantalla();

		var ordenacionesEstablecidas = new Array();

		//setTimeout(function(){
		//INICIO CZ SPRINT 72 
		desetimados()
		//$('#filtros-table').html("");
		
		$('#desestimados').addClass("headerTablas");

		var filaDeCombos = '<div class="row">';
		var contador = 1;

		for (var fila = 0; fila <= 1; fila += 2){
			
			filaDeCombos +=	'<div class="col">';
			filaDeCombos +=	'<b>Ordenar por</b><br>';
			filaDeCombos += '<select class="form-control form-control-sm selector_de_criterio" style="margin-left: 12px; margin-top: 2px;">';
			filaDeCombos += '<option value="-1" selected>Sin Selección</option>';
			filaDeCombos +=	'</select>';
			filaDeCombos +=	'</div>';
			filaDeCombos +=	'<div class="col" style="padding-top: 15px;">';
			filaDeCombos += '<div class="custom-control custom-radio">';
			filaDeCombos += '<input type="radio" id="radio_asc_1" class="custom-control-input sentido_ascendente" name="sentido_'+(contador-1)+'" checked disabled>';
			filaDeCombos += '<label class="custom-control-label" for="radio_asc_1">Ascendente</label>';
			filaDeCombos += '</div>';
			filaDeCombos += '<div class="custom-control custom-radio">';
			filaDeCombos += '<input type="radio" id="radio_des_2" class="custom-control-input sentido_descendente" name="sentido_'+(contador-1)+'" disabled>';
			filaDeCombos += '<label class="custom-control-label" for="radio_des_2">Descendente</label>';
			filaDeCombos += '</div>';
			filaDeCombos += '</div>';
			contador ++;

			filaDeCombos +=	'<div class="col">';
			filaDeCombos +=	'<b>Luego por</b><br>';
			filaDeCombos += '<select class="form-control form-control-sm selector_de_criterio" style="margin-left: 12px; margin-top: 2px;">';
			filaDeCombos += '<option value="-1" selected>Sin Selección</option>';
			filaDeCombos +=	'</select>';
			filaDeCombos +=	'</div>';
			filaDeCombos +=	'<div class="col" style="padding-top: 15px;">';
			filaDeCombos += '<div class="custom-control custom-radio">';
			filaDeCombos += '<input type="radio" id="radio_asc_3" class="custom-control-input sentido_ascendente" name="sentido_'+(contador-1)+'" checked disabled>';
			filaDeCombos += '<label class="custom-control-label" for="radio_asc_3">Ascendente</label>';
			filaDeCombos += '</div>';
			filaDeCombos += '<div class="custom-control custom-radio">';
			filaDeCombos += '<input type="radio" id="radio_des_4" class="custom-control-input sentido_descendente" name="sentido_'+(contador-1)+'" disabled>';
			filaDeCombos += '<label class="custom-control-label" for="radio_des_4">Descendente</label>';
			filaDeCombos += '</div>';
			filaDeCombos += '</div>';
			contador ++;
		}

		filaDeCombos +=	'<div class="col-1" style="padding: 0;">';
		filaDeCombos += '<input type="button" id="botonDeOrdenar" class="btn btn-outline-primary btn-xs" value="Ordenar" style="position: absolute; bottom: 22px;" disabled>';
		filaDeCombos +=	'</div>';
		filaDeCombos += '</div>';

		var setDeCombos = $(filaDeCombos);
		setDeCombos.appendTo('#filtros-table');
		$('.selector_de_criterio:gt(0)').prop('disabled', true);

		var opciones = new Array();

		opciones[0] = $("<option value='0'>R.U.N</option>");
		//opciones[1] = $("<option value='1'>Prioridad</option>");
		opciones[1] = $("<option value='1'>Alerta Nómina</option>");
		opciones[2] = $("<option value='2'>Últimas Alertas SAN</option>");
		opciones[3] = $("<option value='3'>Estado</option>");

		for (var i = 0; i <= 3; i ++) opciones[i].appendTo('.selector_de_criterio');
		
		$('.selector_de_criterio').on('change', function(){
			
			var indiceDeCombo = $(this).index('.selector_de_criterio');
			var criterioSeleccionado = $('.selector_de_criterio:eq('+indiceDeCombo+')').prop('value');

			if (criterioSeleccionado == '-1'){
				
				$('.sentido_ascendente').prop('checked', true);
				$('.sentido_ascendente:eq('+indiceDeCombo+'), .sentido_descendente:eq('+indiceDeCombo+')').prop('disabled', true);

				while (indiceDeCombo < 3){
					indiceDeCombo ++;
					$('.selector_de_criterio:eq('+indiceDeCombo+')').prop({'value':'-1', 'disabled':true});
					$('.sentido_ascendente:eq('+indiceDeCombo+'), .sentido_descendente:eq('+indiceDeCombo+')').prop('disabled', true);
				}

			} else {
				
				if (indiceDeCombo < 3) $('.selector_de_criterio:eq('+(indiceDeCombo + 1)+')').prop({'value':'-1', 'disabled':false});
				$('.sentido_ascendente:eq('+indiceDeCombo+'), .sentido_descendente:eq('+indiceDeCombo+')').prop('disabled', false);
				
			}

			inhabilitarSeleccionados();
			recrearOrdenaciones();
			
		});

		//},300)

		$('.sentido_ascendente, .sentido_descendente').on('click', function(){
			recrearOrdenaciones();
		});

		$('#botonDeOrdenar').on('click', function(){
			
			//console.log(ordenacionesEstablecidas);

			//alert(ordenacionesEstablecidas);
		console.log(filtrolet);
		let data = new Object();
		data.estado = filtrolet;
		//FIN CZ SPRINT 72 
		var desestimados = $('#desestimados').DataTable();
        desestimados.clear().destroy();	

		desestimados = $('#desestimados').DataTable({
			//"fixedHeader": { header:true },
			"dom": '<lf<t>ip>',
			"order":[
				[0, "desc"]
			],
			"processing": true,
			"serverSide": true,
			"ajax":{
				"url":"{{route('data.casos.desestimados')}}",
				//INICIO CZ SPRINT 72 
				"data": data,
				//FIN CZ SPRINT 72 
				//"timeout": 20000,
    			"error" : function(xhr, status){
        			desbloquearPantalla();

			        let mensaje = "Hubo un error al momento de cargar el listado de casos desestimados. Por favor intente nuevamente.";

			        if (xhr.status === 0){
			          alert(mensaje+"\n\n- Sin conexión: Verifique su red o intente nuevamente.");

			        } else if (xhr.status == 404){
			          alert(mensaje+"\n\n- Página solicitada no encontrada [404].");

			        } else if (xhr.status == 500){
			          alert(mensaje+"\n\n- Error interno del servidor [500].");

			        } else if (tipoError === 'parsererror') {
			          alert(mensaje+"\n\n- Error al manipular respuesta JSON.");

			        } else if (tipoError === 'timeout') {
			          alert(mensaje+"\n\n- Error de tiempo de espera.");

			        } else if (tipoError === 'abort') {
			          alert(mensaje+"\n\n- Solicitud Ajax abortada.");

			        } else {
			          alert(mensaje);

			          console.log('Error no capturado: ' + xhr.responseText);
			        }

			        console.log(xhr); return false;
    			}
			},
			"rowGroup": {
				startRender: function ( rows, group ) {
                	return "Caso " + group;
				},
            	dataSrc: "cas_id"
        	},
			"columns":[
			//INICIO CZ SPRINT 72 
			{																					
				"data": 		"cas_id",
				"name": 		"cas_id",
				"className": 	"text-center",
				"visible": false, 
			},
			//FIN CZ SPRINT 72 
			{
				"data": 		"nna_run_con_formato",
				"name": 		"nna_run_con_formato",
				"className": 	"text-center",
				"visible"	: 	false,
				"render" : function (data, type, full, meta){
			 		let rut = esconderRut(data, "{{ config('constantes.ofuscacion_run') }}");
			 		return rut;
			 	}
			},
			{
				"data": 		"nna_run",
				"name": 		"nna_run",
				"className": 	"text-center",
				"visible": false, 
			},
			{
				"data"		: "nna_nombre_completo",
				"name"		: "nna_nombre_completo",
				"className"	: "text-left",
				"visible"	: true,
				"orderable"	: true,
				"searchable": true,
				"render" : function (data, type, full, meta){
					//return '<label data-toggle="tooltip" title="R.U.N.: '+full.nna_run_con_formato+'">'+data+'</label>';
					html = '<label data-toggle="tooltip" data-html="true" title="R.U.N.: ' + full.nna_run_con_formato + '<br />Nombre completo:<br />' + full.nna_nombre_completo + '">' + full.nna_nom + ' ' + full.nna_ape_pat + '</label>';
					return html;
				}
			},
			{																					
				"data"		: "per_ind",
				"name"		: "per_ind",
				"className"	: "text-left",
				"visible"	: true,
				"orderable"	: true,
				"searchable": true,
				"render" : function (data, type, full, meta){
					
					
					let html = "";

					if(full.per_ind == 1){
						html  ='<span class="dot"></span>';
					}

					return html;
				}
			},
			{																					
				"data": 		"n_alertas",
				"name": 		"n_alertas",
				"className": 	"text-center",
				"width": 		"85px",
				"orderable": 	true,
				"searchable": 	false,
				"render": function(data, type, row){ return listarIconoAlerta(row.n_alertas); }
			},   
			{																		
				"data": 		"n_am",
				"name": 		"n_am",
				"className": 	"text-center",
				"orderable": 	true,
				"searchable": 	false,
				"render": function(data, type, row){ return listarIconoAlerta(row.n_am); }
			},  
			{
				"name": 		"est_cas_nom",
				"className": 	"text-left",
				"orderable": 	true,
				"className": 	"text-center",
				"render": 		function(data,type,row){

					// return row.est_cas_nom;

					//####### Se agrega icono de pausa en los casos que corresponda ##############
					let html = row.est_cas_nom;
					if(row.cas_est_pau == 0){
						html += '<br><i class="far fa-pause-circle fa-2x" style="color:red;" title="Caso Pausado"></i>';
					}
				html += '<label style="display: none;">'+row.cas_id+'</label>';
					return html;
					
				}
			},
			{
				"data"		: "est_tera_nom",
				"name"		: "est_tera_nom",
				"className"	: "text-center",
				"visible"	: true,
				"orderable"	: true,
				"searchable": true
			},
			{																				
				"data"		: "nombres",
				"name"		: "nombres",
				"className"	: "text-center",
				"visible"	: true,
				"orderable"	: true,
				"searchable": true,
				"render": 		function(data,type,row){
					return data + ' ' + row.apellido_paterno + ' ' +   row.apellido_materno;
				}
			},
			{																				
				"className": 	"text-center",
				"orderable": 	false,
				"searchable": 	false,
				"render": 		function(data,type,row){
					let html = '';
					let cas_id = row.cas_id;
					let est_cas = row.es_cas_id;
					// INICIO CZ SPRINT 59
					let urlFichaCompleta = $("#desestimados").attr("attr2");
					
					// INICIO CZ SPRINT 63 Casos ingresados a ONL
					urlFichaCompleta	+= '/'+row.run+ '/' +row.cas_id;
					// FIN CZ SPRINT 63 Casos ingresados a ONL

					// FIN CZ SPRINT 59

					if((est_cas == {{config('constantes.nna_presenta_medida_proteccion')}}) || (est_cas == {{config('constantes.nna_vulneracion_derecho_delito')}}) || (est_cas == {{config('constantes.nna_vulneracion_derecho_no_delito')}} )){


						html = '<button class="btn btn-success btn-sm" onclick="desestimaCasoDos('+cas_id+', '+est_cas+');" title="Agregar seguimiento" ><span class="oi oi-plus"></span></button>&nbsp;&nbsp;';

						html += '<button class="btn btn-info btn-sm" onclick="verDetalleSeguimiento('+cas_id+');" title="Ver resumen de seguimiento"><span class="oi oi-eye"></span></button>';
					}else{
						html = '<b>No Aplica</b>';
					}

					return html;
					
				}
			},
			{
				 "className": 	"text-center",
				"orderable": 	false,
				"searchable": 	false,
				"render": 		function(data,type,row){
					let html = '<div class="btn-group">';
							
					html += '<button type="button" class="btn btn-info mr-2" id="detalle_'+row.cas_id+'" data-toggle="tooltip" data-placement="top" title="Ver Bitácora de Estados del Caso" onclick="abrirModalBitacora('+row.cas_id+','+"'"+row.nna_run_con_formato+"'"+')"><span class="oi oi-magnifying-glass"></button>';
					if(row.ter_id !=null){
						html += '<button type="button" class="btn btn-warning mr-2" data-toggle="tooltip" data-placement="top" title="Ver Bitácora de Estados de Terapia" onclick="abrirModalBitacoraTerapia('+row.cas_id+','+"'"+row.nna_run_con_formato+"'"+')"><span class="oi oi-magnifying-glass"></button>';
					}
									
					// INICIO CZ SPRINT 63 Casos ingresados a ONL 
					html += '<a href="{{ route('coordinador.caso.ficha') }}/'+row.run+'/'+row.cas_id+'" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Ver Ficha NNA" >Ficha NNA</a>';
					// FIN CZ SPRINT 63 Casos ingresados a ONL

					html += '</div>';

					return html;
					
				}
			}],
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			"drawCallback": function (settings){
				$("#totalNNA").text(settings._iRecordsTotal);
				$('[data-toggle="tooltip"]').tooltip();
			}, 
		});
		//INICIO CZ SPRINT 72 
			desestimados.order(ordenacionesEstablecidas).draw();

			setTimeout(function(){ desbloquearPantalla(); }, 7000);
		});
		//FIN CZ SPRINT 72 

		
	//}
	//INICIO CZ SPRINT 72 
	function desetimados(filtro=null){
		filtrolet = filtro;
		let data = new Object();
		data.estado = filtro;
		var desestimados = $('#desestimados').DataTable();
        desestimados.clear().destroy();	

		desestimados = $('#desestimados').DataTable({
			//"fixedHeader": { header:true },
			"dom": '<lf<t>ip>',
			"order":[
				//[2, "desc"],
				// INCIO CZ SPRINT 75 MANTIS 10071
				[0, "desc"]
				// FIN CZ SPRINT 75 MANTIS 10071
			],
			"processing": true,
			"serverSide": true,
			"ajax":{
				"url":"{{route('data.casos.desestimados')}}",
				"data": data,
				//"timeout": 20000,
    			"error" : function(xhr, status){
					console.log(xhr);
					console.log(status);
        			desbloquearPantalla();

			        let mensaje = "Hubo un error al momento de cargar el listado de casos desestimados. Por favor intente nuevamente.";
			
			        if (xhr.status === 0){
			          alert(mensaje+"\n\n- Sin conexión: Verifique su red o intente nuevamente.");

			        } else if (xhr.status == 404){
			          alert(mensaje+"\n\n- Página solicitada no encontrada [404].");

			        } else if (xhr.status == 500){
			          alert(mensaje+"\n\n- Error interno del servidor [500].");

			        } else if (tipoError === 'parsererror') {
			          alert(mensaje+"\n\n- Error al manipular respuesta JSON.");

			        } else if (tipoError === 'timeout') {
			          alert(mensaje+"\n\n- Error de tiempo de espera.");

			        } else if (tipoError === 'abort') {
			          alert(mensaje+"\n\n- Solicitud Ajax abortada.");

			        } else {
			          alert(mensaje);
		
			          console.log('Error no capturado: ' + xhr.responseText);
			        }
			
			        console.log(xhr); return false;
    			}
			},
			"rowGroup": {
				startRender: function ( rows, group ) {
                	return "Caso " + group;
				},
            	dataSrc: "cas_id",
        	},
			"columns":[
			{																					
				"data": 		"cas_id",
				"name": 		"cas_id",
				"className": 	"text-center",
				"visible": false, 
			},
			{																					
				"data": 		"nna_run_con_formato",
				"name": 		"nna_run_con_formato",
				"className": 	"text-center",
				"visible": false, 
				"render" : function (data, type, full, meta){
					let rut = esconderRut(data, "{{ config('constantes.ofuscacion_run') }}");
					return rut;
				}
			},
			{																					
				"data": 		"nna_run",
				"name": 		"nna_run",
				"className": 	"text-center",
				"visible": false, 
			},
			{
				"data"		: "nna_nombre_completo",
				"name"		: "nna_nombre_completo",
				"className"	: "text-left",
				"visible"	: true,
				"orderable"	: true,
				"searchable": true,
				"render" : function (data, type, full, meta){
					//return '<label data-toggle="tooltip" title="R.U.N.: '+full.nna_run_con_formato+'">'+data+'</label>';
					let html = '<label data-toggle="tooltip" data-html="true" title="R.U.N.: ' + full.nna_run_con_formato + '<br />Nombre completo:<br />' + full.nna_nombre_completo + '">' + full.nna_nom + ' ' + full.nna_ape_pat + '</label>';
					return html;
				}
			},
			{
				"data"		: "per_ind",
				"name"		: "per_ind",
				"className"	: "text-left",
				"visible"	: true,
				"orderable"	: true,
				"searchable": true,
				"render" : function (data, type, full, meta){
				
					
					let html = "";

					if(full.per_ind == 1){
						html  ='<span class="dot"></span>';
					}

					return html;
				}
			},
			{																					
				"data": 		"n_alertas",
				"name": 		"n_alertas",
				"className": 	"text-center",
				"width": 		"85px",
				"orderable": 	true,
				"searchable": 	false,
				"render": function(data, type, row){ return listarIconoAlerta(row.n_alertas); }
			},   
			{																		
				"data": 		"n_am",
				"name": 		"n_am",
				"className": 	"text-center",
				"orderable": 	true,
				"searchable": 	false,
				"render": function(data, type, row){ return listarIconoAlerta(row.n_am); }
			},  
			{
				"name": 		"est_cas_nom",
				"className": 	"text-left",
				"orderable": 	true,
				"className": 	"text-center",
				"render": 		function(data,type,row){

				// return row.est_cas_nom;
				
				//####### Se agrega icono de pausa en los casos que corresponda ##############
				let html = row.est_cas_nom;
				if(row.cas_est_pau == 0){
					html += '<br><i class="far fa-pause-circle fa-2x" style="color:red;" title="Caso Pausado"></i>';
				}
				html += '<label style="display: none;">'+row.cas_id+'</label>';
				return html;

		}
			},
			{
				"data"		: "est_tera_nom",
				"name"		: "est_tera_nom",
				"className"	: "text-center",
				"visible"	: true,
				"orderable"	: true,
				"searchable": true
			},
			{
				"data"		: "nombres",
				"name"		: "nombres",
				"className"	: "text-center",
				"visible"	: true,
				"orderable"	: true,
				"searchable": true,
				"render": 		function(data,type,row){
						// <!-- //CZ 75 -->
					if(row.vigencia == 0){
						return '<label style="color: #4A4F54;">'+data + ' ' + row.apellido_paterno + ' ' +   row.apellido_materno+'</label>';
					}else{
					return data + ' ' + row.apellido_paterno + ' ' +   row.apellido_materno;
				}
					
				}
			},
			{																				
				"className": 	"text-center",
				"orderable": 	false,
				"searchable": 	false,
				"render": 		function(data,type,row){
					let html = '';
					let cas_id = row.cas_id;
					let est_cas = row.es_cas_id;
					// INICIO CZ SPRINT 59
					let urlFichaCompleta = $("#desestimados").attr("attr2");

					// INICIO CZ SPRINT 63 Casos ingresados a ONL
					urlFichaCompleta	+= '/'+row.run+ '/' +row.cas_id;
					// FIN CZ SPRINT 63 Casos ingresados a ONL
				
					// FIN CZ SPRINT 59
				
					if((est_cas == {{config('constantes.nna_presenta_medida_proteccion')}}) || (est_cas == {{config('constantes.nna_vulneracion_derecho_delito')}}) || (est_cas == {{config('constantes.nna_vulneracion_derecho_no_delito')}} )){

						@if ((Session::get('perfil') != config('constantes.perfil_coordinador_regional')))
							html = '<button class="btn btn-success btn-sm" onclick="desestimaCasoDos('+cas_id+', '+est_cas+');" title="Agregar seguimiento" ><span class="oi oi-plus"></span></button>&nbsp;&nbsp;';
						@endif
			
						
						html += '<button class="btn btn-info btn-sm" onclick="verDetalleSeguimiento('+cas_id+');" title="Ver resumen de seguimiento"><span class="oi oi-eye"></span></button>';
					}else{
						html = '<b>No Aplica</b>';
					}

					return html;

				}
			},
			{																				
				"className": 	"text-center",
				"orderable": 	false,
				"searchable": 	false,
				"render": 		function(data,type,row){
					let html = '<div class="btn-group">';
			
					html += '<button type="button" class="btn btn-info mr-2" id="detalle_'+row.cas_id+'" data-toggle="tooltip" data-placement="top" title="Ver Bitácora de Estados del Caso" onclick="abrirModalBitacora('+row.cas_id+','+"'"+row.nna_run_con_formato+"'"+')"><span class="oi oi-magnifying-glass"></button>';
					if(row.ter_id !=null){
						html += '<button type="button" class="btn btn-warning mr-2" data-toggle="tooltip" data-placement="top" title="Ver Bitácora de Estados de Terapia" onclick="abrirModalBitacoraTerapia('+row.cas_id+','+"'"+row.nna_run_con_formato+"'"+')"><span class="oi oi-magnifying-glass"></button>';
					}

					// INICIO CZ SPRINT 63 Casos ingresados a ONL 
					html += '<a href="{{ route('coordinador.caso.ficha') }}/'+row.run+'/'+row.cas_id+'" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Ver Ficha NNA" >Ficha NNA</a>';
					// FIN CZ SPRINT 63 Casos ingresados a ONL

					html += '</div>';

					return html;

				}
			}],
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			"drawCallback": function (settings){
				$("#totalNNA").text(settings._iRecordsTotal);
				$('[data-toggle="tooltip"]').tooltip();
			}, 
		});

		setTimeout(function(){ desbloquearPantalla(); }, 7000);
	}

	$('#estados').on('change', function (e) {
		var optionSelected = $("option:selected", this);
		var valueSelected = this.value;
		bloquearPantalla();
		desetimados(valueSelected);
	});
	//FIN CZ SPRINT 72 
	function recrearOrdenaciones(){
			
			ordenacionesEstablecidas = new Array();

			for (var i = 0; i <= 1; i ++){
				if ($('.selector_de_criterio:eq('+i+')').prop('value') != '-1'){
					sentidoDeOrdenacion = ($('.sentido_ascendente:eq('+i+')').prop('checked'))?'asc':'desc';
					criterioDeOrdenacion = new Array(parseInt($('.selector_de_criterio:eq('+i+')').prop('value')), sentidoDeOrdenacion);

					//console.log(ordenacionesEstablecidas);


					ordenacionesEstablecidas.push(criterioDeOrdenacion);
				}
			}

			$('#botonDeOrdenar').prop('disabled', (ordenacionesEstablecidas.length == 0));
			
	}

	function inhabilitarSeleccionados(){
			
			for (var i = 1; i <= 5; i ++){
				$('.selector_de_criterio').each(function(){
					$($(this)[0].options[i]).css('display', 'inline-block');
				});
			}

			$('.selector_de_criterio').each(function(){
				
				var opcionDeEsteCombo = $($(this)[0]).prop('value');
				var indiceDeEsteCombo = $('.selector_de_criterio').index(this);

				if (opcionDeEsteCombo == '-1') return;

				for (var i = 0; i <= 1; i ++){
					if (i == indiceDeEsteCombo) continue;
					$($('.selector_de_criterio:eq('+i+')')[0].options).each(function(){
						if ($(this).prop('value') == opcionDeEsteCombo) $(this).css('display', 'none');
					});
				}
				
			});
			
	}

	});	


	function verDetalleSeguimiento(caso_id){
		$('#ver_detalle_seguimiento_desestimacion').modal('show');	

		listar_detalle_seguimiento_desestimacion_caso(caso_id);
	}


	function listar_detalle_seguimiento_desestimacion_caso(caso_id){
		bloquearPantalla();

		let cargar_tabla = $('#listar_detalle_seguimiento_caso').DataTable();
        cargar_tabla.clear().destroy();	

        let data = new Object();
		data.caso_id = caso_id;

		cargar_tabla = $('#listar_detalle_seguimiento_caso').DataTable({
			//"dom": '<lf<t>ip>',
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			"processing": false,
			"serverSide": false,
			"searching" : false,
			"info"		: true,
			"lengthChange": false,
			"ajax"		:{ 
				"url" :	"{{ route('listar.detalle.seguimiento.casos.desestimados') }}", 
				//"type": "GET",  
				"data": data ,
				// "timeout": 20000,
				"error" : function(xhr, status){
        			desbloquearPantalla();

			        let mensaje = "Hubo un error al momento de cargar el listado de casos desestimados. Por favor intente nuevamente.";

			        if (xhr.status === 0){
			          alert(mensaje+"\n\n- Sin conexión: Verifique su red o intente nuevamente.");

			        } else if (xhr.status == 404){
			          alert(mensaje+"\n\n- Página solicitada no encontrada [404].");

			        } else if (xhr.status == 500){
			          alert(mensaje+"\n\n- Error interno del servidor [500].");

			        } else if (tipoError === 'parsererror') {
			          alert(mensaje+"\n\n- Error al manipular respuesta JSON.");

			        } else if (tipoError === 'timeout') {
			          alert(mensaje+"\n\n- Error de tiempo de espera.");

			        } else if (tipoError === 'abort') {
			          alert(mensaje+"\n\n- Solicitud Ajax abortada.");

			        } else {
			          alert(mensaje);

			          console.log('Error no capturado: ' + xhr.responseText);
			        }

			        console.log(xhr); return false;
				}
			},
			"order": [[ 1, "desc" ]],
			//"rowsGroup" : [0],
			"columnDefs": [ 
				{
					"targets": 		0, //OBJETIVO DEL SEGUIMIENTO
					"orderable": 	false,
					//"sortable": 	false,
					"className": 	'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				        $(td).css("word-break", "break-word");
				     
				    }
				},
				{
					"targets": 		1, //FECHA
					"className": 	'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
				{
					"targets": 		2, //MODALIDAD DE CONTACTO
					"className": 	'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     	$(td).css("word-break", "break-word");
				    }
				},
				{
					"targets": 		3, //ESTADO DEL SEGUIMIENTO
					"className": 	'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
				{
					"targets": 		4, //PROGRAMA DE ATENCIÓN
					"className": 	'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				        $(td).css("word-break", "break-all");
				    }
				},
				{
					"targets": 		5, //INSTITUCIÓN A CARGO
					"className": 	'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     	$(td).css("word-break", "break-all");
				    }
				},
				{
					"targets": 		6, //OBSERVACIÓN
					"className": 	'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				        $(td).css("word-break", "break-all");
				     
				    }
				}
			],
			"columns":[
				{ //OBJETIVO DEL SEGUIMIENTO
					"data": 		"objetivo_nombre", 
					"name": 		"objetivo_nombre"
				}, 
				{ //FECHA
					"data": 		"fecha",
					"name": 		"fecha",
					"render": 		function(data, type, row){
						let fecha 	= "";
						let fec 	= new Date(data);
						let day 	= fec.getDate();
						let month  	= fec.getMonth() + 1;
						let year 	= fec.getFullYear();

						if (day < 10) {
					        day = "0" + day;
					    }

					    if (month < 10) {
					        month = "0" + month;
					    }

						fecha = day+"-"+month+"-"+year;

						return fecha;	
					}
				},  
				{ //MODALIDAD DE CONTACTO				
					"data": 		"m_contacto_nombre",
					"name": 		"m_contacto_nombre"
				},  
				{ //ESTADO DEL SEGUIMIENTO				
					"data": 		"est_cas_seg_nombre",
					"name": 		"est_cas_seg_nombre"
				},  
				{ //PROGRAMA DE ATENCIÓN
					"data": 		"tip_pro_seg_nom",
					"name": 		"tip_pro_seg_nom",
					"render": 		function(data, type, row){
						let respuesta = data;

						if (typeof data === 'undefined' || data == "" || data == null) respuesta = "Sin información";

						return respuesta;
					}
				},
				{ //INSTITUCIÓN A CARGO				
					"data": 		"pro_seg_nom",
					"name": 		"pro_seg_nom",
					"render": 		function(data, type, row){
						let respuesta = data;

						if (typeof data === 'undefined' || data == "" || data == null) respuesta = "Sin información";

						return respuesta;
					}
				},  
				{ //OBSERVACIÓN
					"data": 		"comentario",
					"name": 		"comentario",
					"render": 		function(data, type, row){
						let respuesta = data;

						if (typeof data === 'undefined' || data == "" || data == null) respuesta = "Sin información";

						return respuesta;
					}
				}
			],
			"initComplete": function(settings, json){
				desbloquearPantalla();

			}
		});
	}


//-----------------------ADD SEGUIMIENTO ---------------------
function desestimaCasoDos(caso_id, est_cas){
	bloquearPantalla();

	let data = new Object();
	data.caso_id = caso_id;
	data.est_cas_id = est_cas;

	let mensaje = "Hubo un error al momento de cargar el formulario de seguimiento solicitado. Por favor intente nuevamente."

	$.ajax({
		url: "{{ route('cargar.formulario.seguimiento.casos.desestimados') }}",
		type: "GET",
		data: data
	}).done(function(resp){
		desbloquearPantalla();

		if (resp.estado == 1){
			let html_estados = '<option value="">Seleccione Estado del Seguimiento</option>';
			let estados = resp.respuesta.estado_seguimiento_caso;

			if (estados.length > 0){
				$("#estado_seguimiento").attr("onchange", "desplegarSeccionProgramas()");

				$.each(estados, function(ind, val) {
					html_estados += '<option value="'+val.est_cas_seg_cod+'">'+val.est_cas_seg_nombre+'</option>';
				});
			}

			let html_contacto = '<option value="">Seleccione una opción</option>';
			let contactos = resp.respuesta.modalidad_contacto;

			if (contactos.length > 0){
				$.each(contactos, function(ind, val) {
					html_contacto += '<option value="'+val.m_contacto_codigo+'">'+val.m_contacto_nombre+'</option>';
				});
			}

			$("#caso_id_egreso").val(caso_id);
			$("#estado_seguimiento").html(html_estados);
			$("#modalidad_contacto").html(html_contacto);

			limpiarFormularioSeguimientoCasosDesestimados();

			$("#msgConfirmacionDesestimacion").modal("show");

		}else if (resp.estado == 0){
			alert(mensaje);

			console.log(resp.mensaje);

		}
	}).fail(function(obj){
		desbloquearPantalla();

		alert(mensaje);

		console.log(obj);

	});
}

function desplegarSeccionProgramas(){
	let opcion = $("#estado_seguimiento").val();
	let estado1 = 8; 
	let estado2 = 9;
	let estado3 = 10;

	if (estado1 == opcion || estado2 == opcion || estado3 == opcion){
		$("#seccion_programas_atencion").show();


	}else{
		$("#seccion_programas_atencion").hide();
		$("#prog_atencion").attr("disabled", true);
		$("#nom_proyecto").attr("disabled", true);

	}
} 

function validarComentarioModalConfirmEstCaso(){

	   let estados = $("#estado_seguimiento").val().trim();
	   let mod_contacto = $("#modalidad_contacto").val().trim();
	   let prog_atencion = "";
	   let nom_proyecto = "";
	   let comentario = $("#comentario_desestimacion").val().trim();
	   let int_date = $('#int_date').val();
	   let validacion = true;

	   //Validación estados seguimiento
	   if ($('#estado_seguimiento').val().trim() === '') {
	   	    $("#val_msg_com_dest1").show();
        	$("#estado_seguimiento").addClass("is-invalid");
        	validacion = false;

       }else{
       		 $("#val_msg_com_dest1").hide();
       		 $("#estado_seguimiento").removeClass("is-invalid");
       }

		//Validación modalidad contacto
       if ($('#modalidad_contacto').val().trim() === '') {
	   	    $("#val_msg_com_dest2").show();
        	$("#modalidad_contacto").addClass("is-invalid");
        	validacion = false;

       }else{
       		 $("#val_msg_com_dest2").hide();
       		 $("#modalidad_contacto").removeClass("is-invalid");
       }


       if($("#estado_seguimiento").val() == "8" || $("#estado_seguimiento").val() == "9" || $("#estado_seguimiento").val() == "10"){
       		prog_atencion = $("#prog_atencion").val().trim();
	   		nom_proyecto = $("#nom_proyecto").val().trim();
		  		
		  		if ($('#prog_atencion').val().trim() === '') {
			   	    $("#val_msg_com_dest3").show();
		        	$("#prog_atencion").addClass("is-invalid");
		        	validacion = false;

		       }else{
		       		 $("#val_msg_com_dest3").hide();
		       		 $("#prog_atencion").removeClass("is-invalid");
		       }

		       if ($('#nom_proyecto').val().trim() === '') {
			   	    $("#val_msg_com_dest4").show();
		        	$("#nom_proyecto").addClass("is-invalid");
		        	validacion = false;

		       }else{
		       		 $("#val_msg_com_dest4").hide();
		       		 $("#nom_proyecto").removeClass("is-invalid");
		       }
		  
		  }else{
		  		 $("#val_msg_com_dest3").hide();
	       		 $("#prog_atencion").removeClass("is-invalid");
	       		 $("#val_msg_com_dest4").hide();
	       		 $("#nom_proyecto").removeClass("is-invalid");
		  }



	   //Validación caja de comentario
	   if (comentario === "" || comentario.length < 3 || typeof comentario == "undefined"){
	   	   $("#val_msg_com_dest").show();
	   	   $("#comentario_desestimacion").addClass("is-invalid");
	       validacion = false;
	   }else{
		   $("#val_msg_com_dest").hide();
		   $("#comentario_desestimacion").removeClass("is-invalid");
	   }

	   if (validacion == false) return false;

	   let confirmacion = confirm("¿ Esta seguro de guardar el seguimiento realizado ?");
	   if (confirmacion == false) return false;

	   let caso_id_egreso =  $("#caso_id_egreso").val();

   confirmarEgresoCasoDeses(caso_id_egreso, comentario, estados, mod_contacto, prog_atencion, nom_proyecto, int_date);

}


function confirmarEgresoCasoDeses(caso_id, comentario, estados, mod_contacto, prog_atencion, nom_proyecto, int_date){
	let url = $("#url_egresos_caso_desestimados").val();
	let data = new Object();
	data.estados = estados;
	data.mod_contacto = mod_contacto;
	data.prog_atencion = prog_atencion;
	data.nom_proyecto = nom_proyecto;
    data.caso_id = caso_id;
	data.comentario = comentario;
	data.int_date = int_date;

	let mensaje = "Hubo un error al momento de guardar el seguimiento. Por favor intente nuevamente.";

	$.ajax({
		url: url,
		type: "GET",
		data: data
	}).done(function(resp){
		if (resp.estado == 1){
			alert(resp.mensaje);
			$('#msgConfirmacionDesestimacion').modal('hide');

			//cargarListaDesestimados();
			 location.reload();

		}else if (resp.estado == 0){
			alert(mensaje);
			console.log(resp.mensaje);

		}
	}).fail(function(obj){
		alert(mensaje);
		console.log(obj);

	});
}

function limpiarFormularioSeguimientoCasosDesestimados(){
	$("#comentario_desestimacion").val("");
	$("#prog_atencion").val("");
	$("#nom_proyecto").val("");

	$("#seccion_programas_atencion").hide();

	$("#val_msg_com_dest1").hide();
    $("#estado_seguimiento").removeClass("is-invalid");

    $("#val_msg_com_dest2").hide();
    $("#modalidad_contacto").removeClass("is-invalid");

    $("#val_msg_com_dest3").hide();
	$("#prog_atencion").removeClass("is-invalid");
	
	$("#val_msg_com_dest4").hide();
	$("#nom_proyecto").removeClass("is-invalid");

	$("#val_msg_com_dest").hide();
	$("#comentario_desestimacion").removeClass("is-invalid");
}
//-----------------------ADD SEGUIMIENTO ---------------------
//INICIO CZ SPRINT 72 
function abrirModalBitacora(cas_id,run_con_formato){
	let run = esconderRut(run_con_formato, "{{ config('constantes.ofuscacion_run') }}");

	$("#run_nna_bitacora_estado").text(run);

	let data_bitacora = $('#tabla_bitacora').DataTable();

	data_bitacora.clear().destroy(); 

	data_bitacora =	$('#tabla_bitacora').DataTable({
		"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
		"paging"    : false,
		"ordering"  : false,
		"searching" : false,
		"info"		: false,
		"ajax"		: {
			"url" :	"{{ route('casos.bitacoraCaso') }}"+"/"+cas_id
		},
		"columns"	: [
			{
				"data": 		"estado_caso",
				"name": 		"estado_caso",
				"width": 		"150px"
			},
			{
				"render" : function (data, type, full, meta){

					let descripcion = full.descripcion_bitacora;

					if (descripcion==null){
						descripcion='';
					}

					return '<div style="width: 350px;height: 80px;overflow: auto;">'+ descripcion +'</div>';
				}
			},
			{
				"data": 		"fecha_bitacora",
				"name": 		"fecha_bitacora",
				"width": 		"70px"
			}
		],
	});

	$('#tabla_bitacora').find("thead th").removeClass("sorting_asc");
	
	$('#formBitacoraCaso').modal('show');
}


function abrirModalBitacoraTerapia(cas_id, run_con_formato){
	let run = esconderRut(run_con_formato, "{{ config('constantes.ofuscacion_run') }}");

	$("#run_nna_bitacora_estado_terapia").text(run);

	let data_bitacora = $('#tabla_bitacora_terapia').DataTable();

	data_bitacora.clear().destroy(); 

	data_bitacora =	$('#tabla_bitacora_terapia').DataTable({
		"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
		"paging"    : false,
		"ordering"  : false,
		"searching" : false,
		"info"		: false,
		"ajax"		: {
			"url" :	"{{ route('casos.bitacora.terapia') }}"+"/"+cas_id
		},
		"columnDefs": [ 
			{
				"targets": 		0,
				"className": 	'dt-head-center dt-body-center',
				"createdCell": function (td, cellData, rowData, row, col) {
					$(td).css("vertical-align", "middle");
					$(td).css("word-break", "break-word");
					
				}
			},
			{
				"targets": 		1,
				"className": 	'dt-head-center dt-body-center',
				"createdCell": function (td, cellData, rowData, row, col) {
					$(td).css("vertical-align", "middle");
					$(td).css("word-break", "break-word");
					
				}
			},
			{
				"targets": 		2,
				"className": 	'dt-head-center dt-body-left',
				"createdCell": function (td, cellData, rowData, row, col) {
					
				}
			}
		],
		"columns"	: [
			{
				"data": 		"est_tera_nom",
				"name": 		"est_tera_nom",
				"width": 		"150px"
			},
			{
				"data": 		"tera_est_tera_fec",
				"name": 		"tera_est_tera_fec",
				"width": 		"70px"
			},
			{
				"data": 		"tera_est_tera_des",
				"name": 		"tera_est_tera_des",
				"render" : function (data, type, full, meta){
					let descripcion = "";

					if (data != "" && typeof data != "undefined" && data != null){
						descripcion = data;
					
					}

					return '<div style="width: 350px;height: 80px;overflow: auto;">'+ descripcion +'</div>';
				}
			}
		],
	});

	$('#tabla_bitacora_terapia').find("thead th").removeClass("sorting_asc");
	
	$('#formBitacoraTerapia').modal('show');
}
function obtenerDestimados(){

			$.ajax({
    			url: "{{ route('obtener.estados.desestimados') }}",
    			type: "GET",
    		}).done(function(resp){
				$('#estados').html($('<option />', {
                	text: 'Seleccione Estado',
                    value: 0,
                }));
                for (var i = 0; i < resp.length; i+=1) {
                	$('#estados').append($('<option />', {
                    	text: resp[i].est_cas_nom,
                        value: resp[i].est_cas_id,
                    }));
                }
    		}).fail(function(obj){
    			console.log(obj); return false;
				desbloquearPantalla()
    		});
}
//FIN CZ SPRINT 72 
</script>
@endsection