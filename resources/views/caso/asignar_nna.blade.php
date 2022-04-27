@extends('layouts.main')
@section('contenido')

	<section class=" p-1 cabecera">
		<div class="container-fluid">
			<div class="row align-items-center">
				<div class="col-md-12">
					<h5><i class="{{$icono}} mr-2"></i> Asignar a Gestor</h5>
				</div>
			</div>
		</div>
	</section>
	
	<section>
		<div class="container-fluid">

				<!--<div class="row">
					<div class="col" @if (count($com_ses) == 1) style="display: none;" @endif>
						<p>Filtro por Comuna</p>
						<select class="selectpicker col-xs-12 col-sm-12 col-md-12 col-lg-12" data-live-search="true" data-style="btn-default" name="com" id="com" onchange="filtrarAsignadosNNA(this)" multiple>
							@foreach($com_ses as $csi => $csv)
								<option value="{{$csv->com_cod}}" data-com-id="{{$csv->com_id}}" selected>{{$csv->com_nom}}</option>
							@endforeach
						</select>
						<br /><br />
					</div>
				</div>-->
				<div class="row">
					<div class="col-lg-7 card p-4 shadow-sm">
						<input id="token" hidden value="{{ csrf_token() }}">
						<div class="table-responsive">
							<table class="table table-sm table-hover table-striped w-100" cellspacing="0" id="tabla_asignar_nna">
								<thead>
								<tr>
									<th></th>
									<th class="text-center"  style="display: none;">R.U.N</th>
									<th class="text-center">Nombre NNA</th>
									<th class="text-center">RUNSINFORMATO</th>
									<th class="text-center">Prioridad</th>
									<th class="text-center">Alerta</th>
									<th>Estado Caso</th>
									<!-- INICIO CZ SPRINT 61 -->
									<th class="text-center">En Programa SENAME</th>
									<!-- FIN CZ SPRINT 61 -->
									<th class="text-center">Gesti&oacute;n</th>
								</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
					</div>
					<div class="col-md-1 col-lg-1">
				        <div class="bg-celeste p-2 text-center">
				          <img src="/img/ani-mover.gif"><br>
				          <small>Arrastre el NAA hacia el tablero Gestores para asignarlo</small>
				        </div>
				    </div>
					<div class="col-lg-4 card p-4 shadow-sm">
						<div class="table-responsive" id="div_titulo_gestores">
							<h5>Gestores</h5>
						</div>
						<div class="table-responsive" id="tabla_gestores">
							<table class="table table-sm table-hover table-striped w-100" cellspacing="0" id="tabla_asignar_gestor">
								<thead>
								<tr>
									<th></th>
									<!--<th class="text-center">R.U.N</th>-->
									<th class="text-center">Nombre</th>
									<th class="text-center">N° de Casos Asignados</th>
								</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
						<br>
						<h5>Total Casos Asignados <span class="badge badge-danger" id="totalAsignaciones">0</span></h5>
					</div>
				</div>
			
		</div>
	</section>
	<!-- Inicio Andres F. Sprint 63-->
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
</div><!-- Fin Andres F. Sprint 63-->

	@include('ficha.resumen')

@endsection

@section('script')

	<script type="text/javascript" >

		var ajaxFlag	= 0;
		var ajaxFlagTope= 2;

		$( document ).ready(function(){

			var tabla_asignar_nna;
			var tabla_asignar_gestor;
			var asignarNNAaGestor	= new Array();

			listarAsignadosNNA();

			listarAsignadosGestores();

		});


		/**
		 * Functión que realiza la recoleción de códigos de comunas para generar el filtro del listado de NNA para ser asignados a gestores
		 */
		function getFiltroComunas(campo){

			var sel_com	= $('#com option:selected');
			var str_com	= new Array();

			if (campo == 'com_cod'){
				for (i=0; i<sel_com.length; i++){ str_com.push($(sel_com[i]).val()); }
			}else if (campo == 'com_id'){
				for (i=0; i<sel_com.length; i++){ str_com.push($(sel_com[i]).attr('data-com-id')); }
			}

			return str_com;

		}


		/**
		 * Función que realiza el listado de NNA para ser asignados a los gestores
		 */
		function listarAsignadosNNA(){
			
			tabla_asignar_nna	= $('#tabla_asignar_nna').DataTable({
				"dom": '<lf<t>ip>',
				"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json" },
				"order":[
					[ 4, "asc" ]
				],
				"processing": true,
				"serverSide": true,
				"ajax"		: {
		            "url"	:  "{{ route('casos.listarAsignarNNA') }}/{{ Session::get('com_cod') }}",
		           	"error"	:  function(jqXHR, text, error){
		           		if (ajaxFlag < ajaxFlagTope){
							ajaxFlag++;
							listarAsignadosNNA();
						}else{
							manejoPeticionesFailAjax(jqXHR, text, error);
						}
					}
			    },
 				"columnDefs": [
            		{
                		"targets": [ 2 ],
                		"visible": false,
            		}, 
        		],				
				"createdRow": function( row, data, dataIndex ){
					//console.log(row, data, dataIndex);

					$(row).attr('data-run', data.nna_run);
					$(row).attr('draggable', 'true');
					$(row).attr('ondragstart', 'drag(event)');
					$(row).css('cursor', 'grab');
				},
				"columns"	: [
					{
						"className": 	"text-center",
						"visible": 		false,
						"orderable": 	false,
						"searchable": 	false,
						'render': function (data, type, full, meta) { return '<i class="fa fa-grip-vertical text-secondary"></i>'; }
					},
					{
					  "data": 			"nna_run_con_formato",
					  "name":           "nna_run_con_formato",
				      "className": 		"text-center",
				      "visible": 		false,
					  "orderable": 		true,
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
					  "data": 			"nna_run",
					  "name": 			"nna_run",
					  "visible": 		false,
					  "orderable": 		false,
					  "searchable": 	true
					},
					{
						"data": 		"score",
						"name": 		"score",
						"className": 	"text-center",
						"visible": 		true,
					  	"orderable": 	true,
					  	"searchable": 	false,
						'render': function (data, type, full, meta) { 
							return full.score;
						}
					},
					{
						//"data": 		"n_am",
						//"name": 		"n_am",
						"data": 		"n_alertas",
						"name": 		"n_alertas",
						"className": 	"text-center",
						"visible": 		true,
					  	"orderable": 	true,
					  	"searchable": 	false,
						'render': function (data, type, full, meta) { return listarIconoAlerta(full.n_alertas); }
					},
					{
						"data": 		"est_cas_nom",
						"name": 		"est_cas_nom",
						"className": 	"text-center",
						"visible": 		true,
					  	"orderable": 	false,
					  	"searchable": 	true,
						'render': function (data, type, full, meta) {

							// if (full.n_casos > 1){
							// 	let can_caso = full.n_casos - 1;
							// 	let title = "NNA con "+can_caso+" caso anteriormente registrado.";

							// 	if (can_caso > 1) title = "NNA con "+full.n_casos - 1+" casos anteriormente registrados.";

							// 	return full.est_cas_nom + '<img src="/img/ico-alertas.svg" width="29px" height="29px" title="'+title+'"/>';
							// }else{
							// 	return full.est_cas_nom;

							// }

							//####### Se agrega icono de pausa en los casos que corresponda ##############
							console.log('casos: '+full.n_casos);
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
						console.log(full);
						 var html = '';
							if(full.sename == "Si"){
								html = '<span class="badge badge-danger" style="font-size: 17px; font-weight: 500;">'+full.sename+'</span>';
							}
							return html;
					 }
					},
					//FIN CZ SPRINT 61
					{
						"visible": 		true,
						"orderable": 	false,
						"searchable": 	false,
						"className": 	"text-center",
						'render': function (data, type, full, meta) {
								// INICIO CZ SPRINT 63 Casos ingresados a ONL
								return 	'<a href="{{ route('coordinador.caso.ficha') }}/'+full.run+'/0" class="btn btn-primary btn-sm">Ficha NNA</a>' +
										'	</div>' +
										'</div>';
							// FIN CZ SPRINT 63 Casos ingresados a ONL


						}
					}
				],
				"drawCallback": function (settings){
					$('[data-toggle="tooltip"]').tooltip();
				}
			});
			
		}

		/* Inicio Andres F. Sprint 63 */
		/**
		 * Función que muestra modal con info de casos anteriores
		 */
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
		/* Inicio Andres F. Sprint 63 */

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

		/**
		 * Función que realiza el filtrado del listado de NNA para ser asignados a los gestores
		 */
		function filtrarAsignadosNNA(chk){
			console.log("aqui");
			var gfc	= getFiltroComunas('com_cod');

			if (gfc.length == 0){
				alert("Debe seleccionar al menos una comuna para realizar el filtro");
				$('.selectpicker').selectpicker('selectAll');
			}

			tabla_asignar_nna.destroy();
			tabla_asignar_gestor.destroy();

			listarAsignadosNNA();
			listarAsignadosGestores();

		}


		/**
		 * Función que realiza el listado de Gestores con la cantidad de NNA asignados
		 */
		function listarAsignadosGestores(){
			
			tabla_asignar_gestor	= $('#tabla_asignar_gestor').DataTable({
				"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json" },
				//"ajax"		: "{{ route('casos.listarAsignadosGestor') }}/"+getFiltroComunas('com_id'),
				//"ajax"		: "{{ route('casos.listarAsignadosGestor') }}/{{ Session::get('com_id') }}",
				"ajax"		: {
		            "url"  :  "{{ route('casos.listarAsignadosGestor') }}/{{ Session::get('com_id') }}",
		           	"error":  function(jqXHR, text, error){
		           		if (ajaxFlag < ajaxFlagTope){
							ajaxFlag++;
							//CZ SPRINT 74
							listarAsignadosGestores();
							//CZ SPRINT 74
						}else{
							desbloquearPantalla();
							manejoPeticionesFailAjax(jqXHR, text, error);
						}
					}
			    },
				"searching"	: false,
				"paging"	: false,
				"info"		: false,
				"ordering"	: false,
				"createdRow": function( row, data, dataIndex ){
					$(row).attr('data-id', data.id);
					$(row).attr('ondrop', 'drop(event)');
					$(row).attr('ondragover', 'allowDrop(event)');
				},
				"columns"	: [
					{
						"className": "text-center",
						'render': function (data, type, full, meta) { return '<i class="fa fa-angle-right text-secondary"></i>'; }
					},
					/*{
				      "data": "run",
					  "className": "text-center",
						'render': function (data, type, full, meta) {
				      	   let dv  = obtenerDv(data);
				      	   let run = data+"-"+dv;

				      	   return formatearRun(run);
						}
					},*/
					// {
					// 	'render': function (data, type, full, meta) {

					// 		let nombreGestor = full.nombre;

					// 		// let nombreGestor	= full.nombres+' '+full.apellido_paterno+' '+full.apellido_materno;

					// 		return nombreGestor;
					// 	}
					// },
					{ "data": "nombre", "className": "text-center" },
					{ "data": "asignados", "className": "text-center" }
				],
				 drawCallback: function () {
				      var api = this.api();
				      $("#totalAsignaciones").text(api.column( 2, {page:'current'} ).data().sum());
				    }

			});

		}


		/**
		 *
		 * @param ev
		 */
		function drag(ev) {

			//console.log($(ev.target).attr('data-run'));
			ev.dataTransfer.setData("data-run", $(ev.target).attr('data-run'));

		}


		/**
		 *
		 * @param ev
		 */
		function allowDrop(ev) {
			ev.preventDefault();
		}

		/**
		 *
		 * @param ev
		 */
		function drop(ev){
			let run = ev.dataTransfer.getData('data-run');
			let nna = run.split('-');
			let data = {
				     'run': run,
					 'nna': nna[0],
				     'id_usu': $(ev.target).parent().attr('data-id'),
					 'post': 0
		    };

		    // Consultar nombre de gestor para asignar y Verificar si fue desestimado X OPD.

		    nomGesVerificarOpd(nna[0],$(ev.target).parent().attr('data-id')).then(function(resp){

		    	 let cant_asignaciones = resp[3];

		    	 let estado_desestimado = resp[2];

		    	 let verificar_opd = resp[1];

		    	 let nombre_gestor= resp[0];

		    	 let observacion = "";

    			 // if(cant_asignaciones>=40){

    			 // 	alert("ALERTA: No se puede asignar al Gestor(a): "+nombre_gestor+", ya que tiene asignado el máximo de casos activos.");

    			 // 	return false;
    			 // }

				    if(verificar_opd==1){
				    	observacion = "Nota: El NNA fue atendido anteriormente y fue desestimado. \n \n Estado de desestimación: "+estado_desestimado+".";
				    }

				    let confirmacion = confirm("¿Esta seguro que desea realizar la siguiente asignación? \n \n Gestor(a): "+nombre_gestor+". \n \n "+observacion+"");

					// let confirmacion = confirm("¿Esta seguro que desea realizar la siguiente asignación?");
					@if(session()->all()['perfil'] != config("constantes.perfil_administrador_central") && session()->all()['perfil'] != config("constantes.perfil_coordinador_regional"))
					if (confirmacion) {

						$.ajax({
							type		: "GET",
							dataType	: "json",
							url			: "{{route('validar.asignacion_caso_periodo')}}",
							data		: data
						}).done(function(obj) {
							console.log(obj);
							if (obj.estado == 1){

								if(obj.cantidad_periodo == 0){
									$.ajax({
										type		: "GET",
										dataType	: "json",
							url			: "{{route('casos.asignarNNAaGestor')}}",
							data		: data
						}).done(function(obj) {
							if (obj.estado == 1){

								alert(obj.mensaje);

								tabla_asignar_nna.destroy();
								tabla_asignar_gestor.destroy();

								listarAsignadosNNA();
								listarAsignadosGestores();

							}else{
								console.log(obj);
								alert("Error al momento de asignar NNA al Gestor, Por favor intente nuevamente.");

							}
						}).fail(function(obj){
							if (obj.responseJSON.mensaje){
								alert(obj.responseJSON.mensaje);
							}else{
								alert("Error al momento de asignar NNA al Gestor, Por favor intente nuevamente.");
							}
						});
								}else{
									alert("No es posible asignar NNA, debido a que ya fue asignado durante el mes.");
								}
							}else{
								alert(obj.mensaje);

							}
						}).fail(function(obj){
							if (obj.responseJSON.mensaje){
								alert(obj.responseJSON.mensaje);
							}else{
								alert("Error al momento de asignar NNA al Gestor, Por favor intente nuevamente.");
							}
						});



					}
				@else
					alert("Usuario no autorizado para asignar NNA")
				@endif

			}).catch(function (error){
        		//alert("Hubo un error al momento de validar la OPD."); 
      		});

		}

		function nomGesVerificarOpd(run,id_usu){

			let data = new Object();
			data.run = run;
			data.id_usu = id_usu;

			return new Promise(function (resolve, reject){
				$.ajax({
						'type'		: "GET",
						'dataType'	: "JSON",
						'url'		: "{{route('casos.verificar.opd')}}",
						'data'		: data
					}).done(function(resp) {
						resolve(resp);
				}).fail(function(resp){
					reject(resp);
				});
			})			

		}


	</script>

@endsection

<style type="text/css">
	#div_titulo_gestores{
		padding-top: 6px;
	}

	#tabla_gestores{
		padding-top: 14px;		
	}
</style>