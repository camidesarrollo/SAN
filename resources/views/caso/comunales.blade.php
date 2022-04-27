@extends('layouts.main')
@section('contenido')
	<section class=" p-1 cabecera">
		<div class="container-fluid">
			<div class="row align-items-center">
				<div class="col-md-12">
					<h5> <i class="{{$icono}}"></i> Casos en Gestión</h5>
				</div>
			</div>
		</div>
	</section>

    <section>
		<div class="container-fluid">
			<div class="card p-4 shadow-sm">
					<h5>Total NNA <span class="badge badge-warning" id="totalNNA">0</span></h5>
					<h5>Total Casos <span class="badge badge-danger">{{ $cantidad_casos }}</span></h5>

					<table class="table table-bordered table-hover table-striped w-100" cellspacing="0" id="tabla_oficina_local">
						<thead>
							<tr>
								<th colspan="16"><div id="filtros-table"></div></th>
							</tr>
							<tr>
								<th class="text-center" style="display: none;">R.U.N</th>
								<th class="text-center">Nombre NNA</th>
								<th class="text-center">Prioridad</th>
								<th class="text-center">Alerta<br> Nómina</th>
								<th class="text-center">Últimas<br>Alertas SAN</th>
								<th class="text-center">Fecha de Asignación</th>
								<th class="text-center">Gestores</th>
								<th class="text-center">Estado Gesti&oacute;n Caso</th>
								<!-- CZ SPRINT 77 -->
								<th class="text-center">Tiempo intervención Caso</th>
								<th class="text-center">Terapeuta</th>
								<th class="text-center">Estado Terapia Familiar</th>
								<!-- CZ SPRINT 77 -->
								<th class="text-center">Tiempo intervención Terapia</th>
								<!--<th class="text-center">Motivo<br> Desestimación</th>-->
								<th class="text-center">Acciones</th>
								<th class="text-center">RUNSINFORMATO</th>
								<th class="text-center">Caso</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
			</div>
		</div>
	</section>

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


@endsection

@section('script')
	<script type="text/javascript" >
		$( document ).ready(function(){
			var data_oficinaLocal =	$('#tabla_oficina_local').DataTable();
			data_oficinaLocal.clear().destroy();	

			data_oficinaLocal = $('#tabla_oficina_local').on('error.dt',
            function (e, settings, techNote, message) {
                data_oficinaLocal.ajax.reload(null,false);

                console.log('Ocurrió un error al desplegar la información: ', message);
            }).DataTable({

			//var data_oficinaLocal =	$('#tabla_oficina_local').DataTable({
				"dom": '<lf<t>ip>',
				"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
				"order":[
					[ 12, "desc" ]
				],
				"processing": true,
				"serverSide": true,
				"ajax"		: {
		            "url" :	"{{ route('casos.listarNNAComunales') }}"
			    },
				"rowGroup": {
					startRender: function ( rows, group ) {
	                	return "Caso " + group;
					},
	            	dataSrc: "cas_id"
	        	},
				"columns"	: [
					{
					 "data": 		"nna_run_con_formato",
					 "name": 		"nna_run_con_formato",
					 "className": 	"text-center",
					 "visible": 	false,
					 "orderable": 	true,
					 "searchable": 	true,
					 "width":        "90px",
					 "render": function(data, type, row){ 
				 		let rut = esconderRut(data, "{{ config('constantes.ofuscacion_run') }}");
				 		return rut;
			 		 }
					},
					{
						"data"		: "nna_nombre_completo",
						"name"		: "nna_nombre_completo",
						"className"	: "text-left",
						"visible"	: true,
						"orderable"	: true,
						"searchable": true,
						"render" : function (data, type, full, meta){
							let formato = formateoNombres(full.nna_nom, full.nna_ape_pat);
							//return '<label data-toggle="tooltip" title="R.U.N.: '+full.nna_run_con_formato+'">'+data+'</label>';
							return '<label data-toggle="tooltip" data-html="true" title="R.U.N.: ' + full.nna_run_con_formato + '<br />Nombre completo:<br />' + full.nna_nombre_completo + '">' + formato.nombre + ' ' + formato.ape_pat + '</label>';
						}
					},
					{
					 "data": 		"color",
					 "name": 		"score",
					 "className": 	"text-center",
					 "visible": 	true,
					 "orderable": 	true,
					 "searchable": 	false
					},
					{
					 "data": 		"n_alertas",
					 "name": 		"n_alertas",
					 "className": 	"text-center",
					 "visible": 	true,
					 "orderable": 	true,
					 "searchable": 	false,
					 "width": 		"70px",
					 'render': function (data, type, full, meta){ return listarIconoAlerta(full.n_alertas); }
					},
					{
					 "data": 		"n_am",
					 "name": 		"n_am",
					 "className": 	"text-center",
					 "visible": 	true,
					 "orderable": 	true,
					 "searchable": 	false,
					 "width": 		"85px",
					 'render': function (data, type, full, meta){ return listarIconoAlerta(full.n_am); }
					},
					// <!-- //CZ 75 -->
					{
				     "data": 		"fec_creacion",
				     "name": 		"fec_creacion",
				     "className": 	"text-center",
				     "visible": 	true,
					 "orderable": 	true,
					 "searchable": 	true,
					 'render': function (data, type, full, meta){ 
						 var fecha = data.split(" ");
						 var fecha_2 = fecha[0].split("-");
						 return fecha_2[2]+ "-" + fecha_2[1] + "-" + fecha_2[0]; 
						}
					},
					{
				     "data": 		"usuario_nomb",
				     "name": 		"usuario_nomb",
				     "className": 	"text-center",
				     "visible": 	true,
					 "orderable": 	true,
					 "searchable": 	true
					},
					{
					 "data": 		"est_cas_nom",
					 "name": 		"est_cas_nom",
					 "className": 	"text-center",
					 "visible": 	true,
					 "orderable": 	true,
					 "searchable": 	true,
					 "render" : function (data, type, full, meta){
							if (full.n_casos > 1){
								let can_caso = full.n_casos - 1;
								let title = "NNA con "+can_caso+" caso anteriormente registrado.";

								if (can_caso > 1) title = "NNA con "+full.n_casos - 1+" casos anteriormente registrados.";

								let html = full.est_cas_nom + '<i class="fas fa-exclamation-circle fa-2x" style="color:#00a1b9;" title="'+title+'"></i>';

								if(full.cas_est_pau == 0){
									html += '<br><i class="far fa-pause-circle fa-2x" style="padding-top: 2px;color:red;" title="Caso Pausado"></i>';
								}

								return html;
							}else{
								let html = full.est_cas_nom;
								if(full.cas_est_pau == 0){
									html += '<br><i class="far fa-pause-circle fa-2x" style="color:red;" title="Caso Pausado"></i>';
								}
								return html;
								// CZ SPRINT 77
							}
					 }
					},
					{
					 "data": 		"cas_estado",
					 "name": 		"cas_estado",
					 "className": 	"text-center",
					 "visible": 	true,
					 "orderable": 	true,
					 "searchable": 	true,
					 "render" : function (data, type, full, meta){
						if(data == null){
							return "SIN TERAPIA";
						 }else{
							 if(data == "A TIEMPO"){
								return '<span style="font-size: 15px;font-weight: 500;" class="badge badge-success">'+data+'</span>'
							 }else if (data == "RETRASADO"){
								return '<span style="font-size: 15px;font-weight: 500;" class="badge badge-danger">'+data+'</span>'

							 }
						
							}
					 }
					},
					{
						"data"		: "terapeuta",
						"name"		: "terapeuta",
						"className"	: "text-center",
						"visible"	: true,
						"orderable"	: true,
						"searchable": false
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
						// CZ SPRINT 77
					 "data": 		"tera_estado",
					 "name": 		"tera_estado",
					 "className": 	"text-center",
					 "visible": 	true,
					 "orderable": 	true,
					 "searchable": 	true,
					 "render" : function (data, type, full, meta){
						 if(data == null){
							return "SIN TERAPIA";
						 }else{
							 if(data == "A TIEMPO"){
								return '<span style="font-size: 15px;font-weight: 500;" class="badge badge-success">'+data+'</span>'
							 }else if (data == "RETRASADO"){
								return '<span style="font-size: 15px;font-weight: 500;" class="badge badge-danger">'+data+'</span>'

							 }
						
						 }
						
					 }
					},
					{
						"data": 		"",
						"className": 	"text-center",
						"visible": 		true,
						"orderable": 	false,
						"searchable": 	false,
						'render': function (data, type, full, meta){
							let html = '<div class="btn-group">';
							
							html += '<button type="button" class="btn btn-info mr-2" id="detalle_'+full.cas_id+'" data-toggle="tooltip" data-placement="top" title="Ver Bitácora de Estados del Caso" onclick="abrirModalBitacora('+full.cas_id+','+"'"+full.nna_run_con_formato+"'"+')"><span class="oi oi-magnifying-glass"></button>';
							
							html += '<button type="button" class="btn btn-warning mr-2" data-toggle="tooltip" data-placement="top" title="Ver Bitácora de Estados de Terapia" onclick="abrirModalBitacoraTerapia('+full.cas_id+','+"'"+full.nna_run_con_formato+"'"+')"><span class="oi oi-magnifying-glass"></button>';
							
							// INICIO CZ SPRINT 63 Casos ingresados a ONL 
							html += '<a href="{{ route('coordinador.caso.ficha') }}/'+full.run+'/'+full.cas_id+'" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Ver Ficha NNA" >Ficha NNA</a>';
							// FIN CZ SPRINT 63 Casos ingresados a ONL

							html += '</div>';

							return html;
						}
					},
					{
					 "data": 			"nna_run",
					 "className": 		"text-center",
					 "visible": 		false,
					 "orderable": 		false,
					 "searchable": 		true
					},
					{
						"data": 		"cas_id",
						"name": 		"cas_id",
					 	"className": 	"text-center",
					 	"visible":      false,
					 	"orderable": 	false
					}
				],
				"drawCallback": function (settings){
					$("#totalNNA").text(settings._iRecordsTotal);
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

			$('#tabla_oficina_local').addClass("headerTablas");

			var filaDeCombos = '<div class="row">';
			var contador = 1;

			for (var fila = 0; fila <= 1; fila += 2){
				filaDeCombos +=	'<div class="col">';
				filaDeCombos +=	'<b>Ordenar por</b><br>';
				filaDeCombos += '<select class="form-control form-control-sm selector_de_criterio" style="margin-left: 12px; margin-top: 2px;">';
				filaDeCombos += '<option value="-1" selected>Sin Selección</option>';
				filaDeCombos +=	'</select>';
				filaDeCombos +=	'</div>';
				filaDeCombos +=	'<div class="col" style="padding-top: 31px;">';
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
				filaDeCombos +=	'<div class="col" style="padding-top: 31px;">';
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
			opciones[1] = $("<option value='1'>Prioridad</option>");
			opciones[2] = $("<option value='2'>Alerta Nómina</option>");
			opciones[3] = $("<option value='3'>Últimas Alertas SAN</option>");
			opciones[4] = $("<option value='4'>Gestor</option>");
			opciones[5] = $("<option value='5'>Estado Caso</option>");
			// opciones[6] = $("<option value='6'>Motivo Desestimación</option>");

			for (var i = 0; i <= 5; i ++) opciones[i].appendTo('.selector_de_criterio');

			$('.selector_de_criterio').on('change', function(){

				var indiceDeCombo = $(this).index('.selector_de_criterio');
				var criterioSeleccionado = $('.selector_de_criterio:eq('+indiceDeCombo+')').prop('value');

				if (criterioSeleccionado == '-1'){

					$('.sentido_ascendente').prop('checked', true);
					$('.sentido_ascendente:eq('+indiceDeCombo+'), .sentido_descendente:eq('+indiceDeCombo+')').prop('disabled', true);

					while (indiceDeCombo < 5){
						indiceDeCombo ++;
						$('.selector_de_criterio:eq('+indiceDeCombo+')').prop({'value':'-1', 'disabled':true});
						$('.sentido_ascendente:eq('+indiceDeCombo+'), .sentido_descendente:eq('+indiceDeCombo+')').prop('disabled', true);
					}

				} else {

					if (indiceDeCombo < 5) $('.selector_de_criterio:eq('+(indiceDeCombo + 1)+')').prop({'value':'-1', 'disabled':false});
					$('.sentido_ascendente:eq('+indiceDeCombo+'), .sentido_descendente:eq('+indiceDeCombo+')').prop('disabled', false);

				}

				inhabilitarSeleccionados();
				recrearOrdenaciones();

			});

			$('.sentido_ascendente, .sentido_descendente').on('click', function(){
				recrearOrdenaciones();
			});

			$('#botonDeOrdenar').on('click', function(){
				data_oficinaLocal.order(ordenacionesEstablecidas).draw();
			});

		});

		function recrearOrdenaciones(){

			ordenacionesEstablecidas = new Array();

			for (var i = 0; i <= 1; i ++){
				if ($('.selector_de_criterio:eq('+i+')').prop('value') != '-1'){
					sentidoDeOrdenacion = ($('.sentido_ascendente:eq('+i+')').prop('checked'))?'asc':'desc';
					criterioDeOrdenacion = new Array(parseInt($('.selector_de_criterio:eq('+i+')').prop('value')), sentidoDeOrdenacion);
					ordenacionesEstablecidas.push(criterioDeOrdenacion);
				}
			}

			$('#botonDeOrdenar').prop('disabled', (ordenacionesEstablecidas.length == 0));

		}

		function inhabilitarSeleccionados(){

			for (var i = 1; i <= 7; i ++){
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

		/**
		 * Función que retorna una clase de color dependiendo del valor del score
		 * @param score
		 * @returns {string}
		 */
		function aplicarColor(score){

			var claseCss = '';

			if (score >= 0 && score <= 20){			claseCss	= "alarmaUno";		}
			else if (score >= 21 && score <= 40){	claseCss	= "alarmaDos";		}
			else if (score >= 41 && score <= 60){	claseCss	= "alarmaTres";		}
			else if (score >= 61 && score <= 80){	claseCss	= "alarmaCuatro";	}
			else if (score >= 81 && score <= 100){	claseCss	= "alarmaCinco";	}

			return claseCss;
		}

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


	</script>

@endsection