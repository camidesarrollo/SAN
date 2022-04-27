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
				<h5>Total NNA <span class="badge badge-warning" id="totalNNA">0</span></h5>
				<h5>Total Casos <span class="badge badge-danger">{{ $cantidad_casos }}</span></h5>
				
				<table id="casos_egresados" class="table table-hover table-striped w-100" attr2="{{route('coordinador.caso.ficha')}}"  >
					<thead>
						<tr>
							<th colspan="8"><div id="filtros-table"></div></th>
						</tr>
						<tr>
							<th>R.U.N</th>
							<th>Nombre NNA</th>
							<th>Alerta Nómina</th>
							<th>Últimas<br>Alertas SAN</th>
							<th>Estado Gesti&oacute;n Caso</th>
							<!-- INICIO CZ -->
							<th>Fecha de Egreso</th>
							<!-- FIN CZ -->
							<th>Estado Terapia Familiar</th>
							<th>Acciones</th>
							<th>RUNSINFORMATO</th>
							<th>Caso</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>

			</div>
		</div>
	</section>
@stop

@section('script')
<script type="text/javascript" >
	$(document).ready(function(){
		var ordenacionesEstablecidas = new Array();

		var dataTable_casos = $('#casos_egresados').DataTable();
        dataTable_casos.clear().destroy();	

		dataTable_casos = $('#casos_egresados').DataTable({
			"order":[
				//[2, "desc"],
				//CZ SPRINT 74
				[5, "desc"]
				//CZ SPRINT 74
			],
			// "processing": true,
			"serverSide": true,
			"ajax":{
				"url":"{{route('data.casos.egresados')}}"
			},
			"rowGroup": {
				startRender: function ( rows, group ) {
                	return "Caso " + group;
				},
            	dataSrc: "cas_id"
        	},
			"columns":[
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
					console.log(full);
					let formato = formateoNombres(full.nna_nom, full.nna_ape_pat);
					return '<label data-toggle="tooltip" data-html="true" title="R.U.N.: ' + full.nna_run_con_formato + '<br />Nombre completo:<br />' + full.nna_nombre_completo + '">' + formato.nombre + ' ' + formato.ape_pat + '</label>';
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
				"render": 		function(data,type,row){
					let html = row.est_cas_nom;
					if(row.cas_est_pau == 0) html += '<br><i class="far fa-pause-circle fa-2x" style="color:red;" title="Caso Pausado"></i>';
						
					return html;

				}	
			},
			// INICIO CZ
			{																		
				"data": 		"cas_est_cas_fec",
				"name": 		"cas_est_cas_fec",
				"className": 	"text-center",
				"orderable": 	true,
				"searchable": 	false,
				"render" : function (data, type, full, meta){
					let date = new Date(full.cas_est_cas_fec)
					let day = date.getDate()
					let month = date.getMonth() + 1
					let year = date.getFullYear()
					if(month < 10){
					return '<label>'+`${day}/0${month}/${year}`+'</label>';
					}else{
					return '<label>'+`${day}/${month}/${year}`+'</label>';
					}
				}
			},
			//FIN CZ
			{
				"data"		: "est_tera_nom",
				"name"		: "est_tera_nom",
				"className"	: "text-left",
				"visible"	: true,
				"orderable"	: true,
				"searchable": true
			},
			{																					
				"className": 	"text-center",
				"orderable": 	false,
				"searchable": 	false,
				"render": 		function(data,type,row){
					let urlFichaCompleta = $("#casos_egresados").attr("attr2");
					// INICIO CZ SPRINT 63 Casos ingresados a ONL
					urlFichaCompleta	+= '/'+row.run + '/' + row.cas_id;
					// FIN CZ SPRINT 63 Casos ingresados a ONL
					
					let html = '<a class="btn btn-primary" href="'+urlFichaCompleta+'">Ficha NNA</a>';
				
					return html;
					
				}
			},
			{
				 "data": 		"nna_run",
				 "name": 		"nna_run",
				 "className": 	"text-center",
				 "visible": 	false
			},
			{
				"data": 		"cas_id",
				"name": 		"cas_id",
			 	"className": 	"text-center",
			 	"visible":      false
			}
			],
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			"drawCallback": function (settings){
				$("#totalNNA").text(settings._iRecordsTotal);
				$('[data-toggle="tooltip"]').tooltip();
			}
		});
		

		$('#casos_egresados').addClass("headerTablas");

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
			dataTable_casos.order(ordenacionesEstablecidas).draw();
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
</script>
@endsection