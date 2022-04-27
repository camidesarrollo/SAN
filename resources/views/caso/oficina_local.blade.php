@extends('layouts.main')
@section('contenido')

	<section class=" p-1 cabecera">
		<div class="container-fluid">
			<div class="row align-items-center">
				<div class="col-md-12">
					<h5> <i class="fa fa fa-folder-open"></i> Nómina Comunal</h5>
				</div>
			</div>
		</div>
	</section>
	
	<!--<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<input id="token" hidden value="{{ csrf_token() }}">
				<div class="table-responsive">-->
                <section>
					<div class="container-fluid">
						<div class="card p-4 shadow-sm">
							<h5>Total NNA <span class="badge badge-danger" id="totalNNA">0</span></h5>
							

							<table class="table table-bordered table-hover table-striped w-100" cellspacing="0" id="tabla_oficina_local">
								<thead>
									<tr>
										<!-- INICIO CZ SPRINT 68 -->
										<th colspan="8"><div id="filtros-table"></div></th>
										<!-- FIN CZ SPRINT 68 -->
									</tr>
								<tr>
									<th class="text-center" style="display: none;">R.U.N</th>
									<th class="text-center">Nombre NNA</th>
									<th class="text-center">Prioridad</th>
									<th class="text-center">Alerta Nómina</th>
									<th class="text-center">Últimas<br>Alertas SAN</th>
									<!-- INICIO CZ SPRINT 68 -->
									<!-- <th class="text-center">Gestor</th> -->
									<!-- FIN CZ SPRINT 68 -->
									<th class="text-center">Estado Caso</th>
									<!-- INICIO CZ SPRINT 61 -->
									<th class="text-center">En Programa<br>SENAME</th>
									<!-- FIN CZ SPRINT 61 -->
									<th class="text-center">Acciones</th>
									<th class="text-center">RUNSINFORMATO</th>
								</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
					 </div>
					 <!-- INICIO CZ SPRINT 68 -->
					 <div id="frmCasosAnteriores" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-lg">
							<div class="modal-content p-4">
								<div class="card p-4 m-0 shadow-sm">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true" style="position: absolute; right: 5px; top: 5px; width: 23px; height: 23px; padding: 0; margin: 0;">&times;</span>
									</button>
									<div class="row">
										<div class="col text-center">
											<h4 class="modal-title"><b>Historial de Casos</b>
											</h4>
											<p id="subti_modal" style="text-align:left"></p>
											<br>
										</div>
									</div>

									<table class="table table-bordered table-hover table-striped w-100" cellspacing="0" id="tabla_casos_anteriores">
												<thead>
													<tr>
														<th class="text-center">Estado</th>
														<th class="text-center">Descripción</th>
														<th class="text-center">Fecha</th>
													</tr>
												</thead>
												<tbody></tbody>
									</table>
									<div id="contenedor-tabs"></div>
									<br>
									<div class="text-right">                    
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
									</div>					
								</div>                
							</div>
						</div>
					</div>
					<!-- FIN CZ SPRINT 68 -->
				</section>
				<!--</div>
			</div>
		</div>
	</div>-->

	@include('ficha.resumen')
	@include('caso.descartar.descartar_nna_nomina_modal')

@endsection


@section('script')

	<script type="text/javascript" >

		var ajaxFlag	= 0;
		var ajaxFlagTope= 2;

		$( document ).ready(function(){

			bloquearPantalla();

			listarNNA();

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


		/**
		 * Función que lista el total de nna de la nómina comunal
		 */
		function listarNNA(){

			var data_oficinaLocal = $('#tabla_oficina_local').DataTable();
        	data_oficinaLocal.clear().destroy();	

			data_oficinaLocal =	$('#tabla_oficina_local').DataTable({
				// "fixedHeader": { header:true },
				"dom": '<lf<t>ip>',
				//"language"	: { "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json" },
				"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
				"order":[
					[ 2, "asc"],
				],
				"processing": true,
				"serverSide": true,
				"ajax"		: {
		            "url"  :  "{{ route('casos.listarNNA') }}",
		           	"error":  function(jqXHR, text, error){
						console.log(error);
		           		if (ajaxFlag < ajaxFlagTope){
							ajaxFlag++;
							listarNNA();
						}else{
							desbloquearPantalla();
							manejoPeticionesFailAjax(jqXHR, text, error);
						}

		           		//let mensaje = "Hubo un error al momento de cargar el listado. Por favor intente nuevamente.";
						//desbloquearPantalla();
						//alert(mensaje);

					}
			    },
			    "columnDefs": [ 
					{
						"targets": 		0, //NOMBRE NNA
						"className": 	'dt-head-center dt-body-left',
						"createdCell": function (td, cellData, rowData, row, col) {
					        $(td).css("vertical-align", "middle");
					     
					    }
					},
					{
						"targets": 		1, //PRIORIDAD
						"className": 	'dt-head-center dt-body-center',
						"createdCell": function (td, cellData, rowData, row, col) {
					        $(td).css("vertical-align", "middle");
					     
					    }
					},
					{
						"targets": 		2, //ALERTA NÓMINA
						"className": 	'dt-head-center dt-body-center',
						"createdCell": function (td, cellData, rowData, row, col) {
					        $(td).css("vertical-align", "middle");
					     
					    }
					},
					{
						"targets": 		3, //ÚLTIMAS ALERTAS SAN
						"className": 	'dt-head-center dt-body-center',
						"createdCell": function (td, cellData, rowData, row, col) {
					        $(td).css("vertical-align", "middle");
					     
					    }
					},
					// INICIO CZ SPRINT 68
					// {
					// 	"targets": 		4, //GESTOR
					// 	"className": 	'dt-head-center dt-body-center',
					// 	"createdCell": function (td, cellData, rowData, row, col) {
					//         $(td).css("vertical-align", "middle");
					     
					//     }
					// },
					// FIN CZ SPRINT 68
					{
						"targets": 		4, //ESTADO CASO
						"className": 	'dt-head-center dt-body-center',
						"createdCell": function (td, cellData, rowData, row, col) {
					        $(td).css("vertical-align", "middle");
					     
					    }
					},
					// INICIO CZ SPRINT 61
					{
						"targets": 		5, //PROGRAMA SENAME
						"className": 	'dt-head-center dt-body-center',
						"createdCell": function (td, cellData, rowData, row, col) {
					        $(td).css("vertical-align", "middle");
					    }
					},
					// FIN CZ SPRINT 61
					{
						"targets": 		6, //ACCIONES
						"className": 	'dt-head-center dt-body-center',
						"createdCell": function (td, cellData, rowData, row, col) {
					        $(td).css("vertical-align", "middle");
					        $(td).css("padding", "8px 59px");
					     
					    }
					},
					{
						"targets": 		7, //RUNSINFORMATO
						"className": 	'dt-head-center dt-body-center',
						"createdCell": function (td, cellData, rowData, row, col) {
					        $(td).css("vertical-align", "middle");
					     
					    }
					}
				],
				"columns"	: [
					{
					 "data": 		"nna_run_con_formato",
					 "name": 		"nna_run_con_formato",
					 "className": 	"text-center",
					 "visible": 	false,
					 "orderable": 	true,
					 "searchable": 	true,
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
							//return '<label data-toggle="tooltip" title="R.U.N.: '+full.nna_run_con_formato+'">'+data+'</label>';
							return '<label data-toggle="tooltip" data-html="true" title="R.U.N.: ' + full.nna_run_con_formato + '<br />Nombre completo:<br />' + full.nna_nombre_completo + '">' + full.nna_nom + ' ' + full.nna_ape_pat + '</label>';
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
					 //"data": 		"n_am",
					 //"name": 		"n_am",
					 "data": 		"n_alertas",
					 "name": 		"n_alertas",
					 "className": 	"text-center",
					 "visible": 	true,
					 "orderable": 	true,
					 "searchable": 	false,
					 "width": 		"85px",
					 'render': function (data, type, full, meta){ 
						 return listarIconoAlerta(full.n_alertas); 
						}
					},
					{
					 "data": 		"n_am",
					 "name": 		"n_am",
					 "className": 	"text-center",
					 "visible": 	true,
					 "orderable": 	true,
					 "searchable": 	false,
					 "width": 		"85px",
					 'render': function (data, type, full, meta){ 
						 console.log(data);
						// INICIO CZ SPRINT 63 Casos ingresados a ONL
						return '<b style="font-size: 14px"; id="cantidadAlerta_'+data+'">'+data+'</b>';
						// FIN CZ SPRINT 63 Casos ingresados a ONL
						}
					},
					// {
				    //  "data": 		"usuario_nomb",
				    //  "name": 		"usuario_nomb",
				    //  "className": 	"text-center",
				    //  "visible": 	true,
					//  "orderable": 	true,
					//  "searchable": 	true,
					// //  INICIO CZ SPRINT 68
					//  "render" : function (data, type, full, meta){
					// 	 console.log(full);
					// 		if(full.est_cas_fin == 1){
					// 			return 'NO ASIGNADO';
							
					// 	 }else{
					// 		return full.usuario_nomb;
							
					//  	}
					// }
					// },
					// FIN CZ SPRINT 68
					{
					 "data": 		"est_cas_nom",
					 "name": 		"est_cas_nom",
					 "className": 	"text-center",
					 "visible": 	true,
					 "orderable": 	true,
					 "searchable": 	true,
					 "render" : function (data, type, full, meta){
						//  INICIO CZ SPRINT 68
							if (full.n_casos > 1){
								
								let can_caso = full.n_casos - 1;
								let title = "NNA con "+can_caso+" caso anteriormente registrado.";

								if (can_caso > 1) title = "NNA con "+full.n_casos - 1+" casos anteriormente registrados.";

								// let html = full.est_cas_nom + '<img src="/img/ico-alertas.svg" width="29px" height="29px" title="'+title+'"/>';
								let html = full.est_cas_nom + '<i class="fas fa-exclamation-circle fa-2x" style="color:#00a1b9;" title="'+title+'"></i>';
								/* inicio Andres F corrección sprint 63 */
								if(full.est_cas_id > 6 && full.est_cas_id < 31){
									html = '<button type="button" class="btn btn-info mr-2" id="detalleCasoAnterior" onclick="infoModalCasos('+full.run+');"><span class="oi oi-magnifying-glass"></span></button>';

								} /* FIN Andres F corrección sprint 63 */
								if(full.cas_est_pau == 0){
									html += '<br><i class="far fa-pause-circle fa-2x" style="padding-top: 2px;color:red;" title="Caso Pausado"></i>';
								}
								return html;
							}else{ 
								let html = ''; /* inicio Andres F sprint 63 */
								if(full.est_cas_id != null){
									html += '<button type="button" class="btn btn-info mr-2" id="detalleCasoAnterior" onclick="infoModalCasos('+full.run+');"><span class="oi oi-magnifying-glass"></span></button>';
								return html;
							}else{
								let html = full.est_cas_nom;
								if(full.cas_est_pau == 0){
									html += '<br><i class="far fa-pause-circle fa-2x" style="color:red;" title="Caso Pausado"></i>';
								}
								return html;
							}
					 }
						//  FIN CZ SPRINT 68
					 }
					},
					// INICIO CZ SPRINT 61
					{
					 "data": 		"sename",
					 "name": 		"sename",
					 "className": 	"text-center",
					 "visible": 	true,
					 "orderable": 	true,
					 "searchable": 	true,
					 "render" : function (data, type, full, meta){
						 var html = '';
							if(full.sename=="Si"){
								html = '<span class="badge badge-danger" style="font-size: 17px;font-weight: 500;">'+full.sename+'</span>';
							}
							return html;
					 }
					},
					//FIN CZ SPRINT 61
					{
						"data": 		"",
					 	"name": 		"",
						"visible": 		true,
						"orderable": 	false,
						"searchable": 	false,
						'render': function (data, type, full, meta) {
							console.log(full);
							let html 		= "";
							let des_pre_act = full.descartado;
							let nombre_btn 	= "Descartar";
							let color_btn 	= "btn-danger";
							let fecha 		= new Date();
							let hoy 		= fecha.getDate();
							let boton_habilitado = "{{ config('constantes.dias_habilitado_btn_descartar_nomina') }}";

							if (des_pre_act == 1){
								des_pre_act = 0;
								nombre_btn 	= "Revertir";
								color_btn 	= "btn-success";
							
							}else if (des_pre_act == 0){
								des_pre_act = 1;

							}
							
							let onclick = `levantarModalDescarteRevertirNNA('${full.run}', '${full.nna_run_con_formato}', '${full.nna_nombre_completo}', '${full.periodo}', ${des_pre_act});`;
							let disabled = "";
							let tooltip = `Quedan ${boton_habilitado - hoy} días para inhabilitar este botón.`;

							if (hoy > boton_habilitado || (full.cas_id != null && full.est_cas_id == {{config('constantes.en_prediagnostico')}} || full.est_cas_id == {{config('constantes.en_diagnostico')}} || full.est_cas_id == {{config('constantes.en_elaboracion_paf')}} || full.est_cas_id == {{config('constantes.en_ejecucion_paf')}} || full.est_cas_id == {{config('constantes.en_cierre_paf')}} || full.est_cas_id == {{config('constantes.en_seguimiento_paf')}})){
								onclick  = "";
								disabled = "disabled";
								tooltip = "Botón inhabilitado debido a cumplimiento de plazo establecido.";
							}

							// INICIO CZ SPRINT 68 Casos ingresados a ONL
								var cas_id; 
								if(full.cas_id == null){
									cas_id = 0; 
								}else{
									if(full.est_cas_fin == 1){
										cas_id = 0;
									}else{
										cas_id = full.cas_id;
									}
									
								} 
								html += `<a href="{{ route('coordinador.caso.ficha') }}/${full.run}/${cas_id}" class="btn btn-primary w-100" style="margin-bottom: 5px;">Ficha NNA</a>`;
							// FIN CZ SPRINT 68 Casos ingresados a ONL
							@if(session()->all()['perfil'] != config('constantes.perfil_coordinador_regional'))
                                if (full.cas_id == null || full.est_cas_fin == 1) {
                                    html +=
                                            `<button class="btn ${color_btn} w-100 text-white" onclick="${onclick}" ${disabled} title="${tooltip}">${nombre_btn}</button>`;
                                }							
							@endif

							return html;

						}, "className": "text-center"
					},
					{
					 "data": 			"nna_run",
					 "className": 		"text-center",
					 "visible": 		false,
					 "orderable": 		false,
					 "searchable": 		true
					},
				],
				"drawCallback": function (settings){
					desbloquearPantalla();
					$("#totalNNA").text(settings._iRecordsTotal);
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

		}


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

		function limpiarModalDescarteRevertirNNA(){
			$("#titulo_modal_descartados").text("");
			$("#comentario_descarte_revertir_nna").val("");
			$("#confirmar_descarte_revertir_nna").removeAttr();
			$("#confirmar_descarte_revertir_nna").text("");

			$("#val_descarte_revertir_nna").hide();
	   		$("#comentario_descarte_revertir_nna").removeClass("is-invalid");
		}

		function levantarModalDescarteRevertirNNA(run, run_formateado, nombre_completo, periodo, descartar){
			let boton = "Descartar";
			let titulo = "Descartar NNA";

			limpiarModalDescarteRevertirNNA();

			if (descartar == 0){
				boton = "Revertir";
				titulo = "Revertir Descartar NNA";

			}

			$("#nombre_descarte_revertir_nna").text(nombre_completo);
			$("#run_descarte_revertir_nna").text(run_formateado);
			$("#titulo_modal_descartados").text(titulo);
			$("#confirmar_descarte_revertir_nna").text(boton);
			$("#confirmar_descarte_revertir_nna").attr("onclick", `registrarDescarteRevertirNNA('${run}', '${periodo}', ${descartar})`);


			$("#modal_descarte_revertir_nna").modal("show");
		}
		//  INICIO CZ SPRINT 68
		function infoModalCasos(run_nna){
			//console.log('nnarun: '+run_nna);
			$("#accordionExample").hide();
			$("#subti_modal").hide();
			$('#tabla_casos_anteriores').hide();
			let data = new Object();
        	data.run_nna = run_nna;
			$.ajax({
            	type: "GET",
            	url: "{{route('get.casos.anteriores')}}",
            	data: data
        	}).done(function(resp){
            	console.log(resp);
				if(resp.data.length == 1){
					// INICIO CZ SPRINT 63
					$("#accordionExample").hide();
					$('#subti_modal').show();
					$('#tabla_casos_anteriores').show();
					$('#subti_modal').html('Id Caso: '+resp.data[0].cas_id);
					// FIN CZ SPRINT 63
					let casos_anteriores = $('#tabla_casos_anteriores').DataTable();
					casos_anteriores.clear().destroy(); 
					casos_anteriores =	$('#tabla_casos_anteriores').DataTable({
						"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
						"paging"    : false,
						"ordering"  : false,
						"searching" : false,
						"info"		: false,
						"ajax"		: {
							"url" :	"{{ route('casos.bitacoraCaso') }}"+"/"+resp.data[0].cas_id
						},
						"columns"	: [
							{
							"data": 		"estado_caso",
							"name": 		"estado_caso",
							"width": 		"20px"
							},
							{
							"data": 		"descripcion_bitacora",
							"name": 		"descripcion_bitacora",
							"width": 		"120px"
							},
							{
							"data": 		"fecha_bitacora",
							"name": 		"fecha_bitacora",
							"width": 		"70px"
							}
						],
					});
				}
				else{
					// INICIO CZ SPRINT 63
					$('#tabla_casos_anteriores').hide();
					$("#accordionExample").show();
					$("#subti_modal").hide();
					// FIN CZ SPRINT 63
					htmlTabs = '<div class="card colapsable" id="accordionExample">';
					for(i = 0; i < resp.data.length; i++){
						htmlTabs += '<div class="card colapsable"><a class="text-left p-0" style="cursor:pointer" type="button" data-toggle="collapse" data-target="#collapse'+i+'" aria-expanded="true" aria-controls="collapseOne" onclick="desplegarTablaCasosAnteriores('+resp.data[i].cas_id+')"><div class="card-header p3" id="headingOne"><h5 class="mb-0"><button class="btn btn-info" type="button" data-toggle="collapse" data-target="#collapse'+i+'" aria-expanded="true" aria-controls="collapseOne" onclick="desplegarTablaCasosAnteriores('+resp.data[i].cas_id+')"><i class="fa fa-info"></i></button> ID Caso:'+resp.data[i].cas_id;
						htmlTabs += '</h5></div></a><div id="collapse'+i+'" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample"><div class="card-body"><table class="table table-bordered table-hover table-striped w-100" cellspacing="0" id="tabla_ca'+resp.data[i].cas_id+'">';
						htmlTabs += '<thead><tr><th class="text-center">Estado</th><th class="text-center">Descripción</th><th class="text-center">Fecha</th></tr></thead><tbody></tbody></table></div></div></div>';
					}
					htmlTabs += '</div>';
					$("#contenedor-tabs").html(htmlTabs);
				}
            
        	}).fail(function(objeto, tipoError, errorHttp){            
           
            	manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

            	return false;
        	});

			$("#frmCasosAnteriores").modal('show');
		}
		//  INICIO CZ SPRINT 68
		function desplegarTablaCasosAnteriores(id_caso){
			
			let casos_anteriores = $('#tabla_ca'+id_caso).DataTable();
			casos_anteriores.clear().destroy(); 
			casos_anteriores =	$('#tabla_ca'+id_caso).DataTable({
				"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
				"paging"    : false,
				"ordering"  : false,
				"searching" : false,
				"info"		: false,
				"ajax"		: {
					"url" :	"{{ route('casos.bitacoraCaso') }}"+"/"+id_caso
				},
				"columns"	: [
					{
					"data": 		"estado_caso",
					"name": 		"estado_caso",
					"width": 		"20px"
					},
					{
					"data": 		"descripcion_bitacora",
					"name": 		"descripcion_bitacora",
					"width": 		"120px"
					},
					{
					"data": 		"fecha_bitacora",
					"name": 		"fecha_bitacora",
					"width": 		"70px"
					}
				],
			});

		}	
		//  FIN  CZ SPRINT 68
	</script>

@endsection