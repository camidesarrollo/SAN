@extends('layouts.main')
@section('contenido')

	<section class="p-1 cabecera">
		<div class="container-fluid">
			<div class="row align-items-center">
				<div class="col">
					<h5><i class="{{$icono}}"></i> Alertas Territoriales</h5>
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

			<?php $com_ses = Session::get('comunas');

// dd(Session::get('perfil'));

?>
			<!--
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6" @if (count($com_ses) == 1) style="display: none;" @endif>
					<p>Filtro por Comuna</p>

					<select class="selectpicker col-xs-12 col-sm-12 col-md-12 col-lg-12" data-live-search="true" data-style="btn-default" name="com" id="com" onchange="filtrarAlertas(this)" multiple>
						@foreach($com_ses as $csi => $csv)
							<option value="{{$csv->com_cod}}" data-com-id="{{$csv->com_id}}" selected >{{$csv->com_nom}}
							</option>
						@endforeach
					</select>

				</div>
			</div> -->



			<div class="card p-4 shadow-sm">
					<input id="token" hidden value="{{ csrf_token() }}">
					<input id="perfil" name="perfil" type="hidden" value="{{ Session::get('perfil') }}">

					<input id="user_id" name="user_id" type="hidden" value="{{ Session::get('perfil') }}">
				<div class="text-right">
					<a href="{{ route('alertas.crear') }}" class="btn btn-success" data-toggle="tooltip" data-placement="left" title="Nueva Alerta manual" id="IDnuevo" >+ Crear alerta</a>
				</div>
					<div class="table-responsive">

						<table class="table table-striped table-hover w-100" cellspacing="0" id="tabla_alertas">

							<thead>

							<!--@ if(Session::get('perfil')!=5)

								<tr>
									<th colspan="7" class="text-center">
										<label class="btn btn-outline-primary"><i class="fa fa-list"></i> Mis Alertas <input type="checkbox" id="mis_alertas" name="mis_alertas"  onclick="misAlertas();" @ if(Session::get('perfil')==5) disabled checked @ endif>
										</label>
									</th>
								</tr>

							@ endif-->

							<tr>
								<th class="text-center">RUNSINFORMATO</th>
								<th class="text-center" style="display:none;">R.U.N</th> 
								<th class="text-center">Nombre NNA</th>
								<th class="text-center">Alerta Territorial</th>
								<th class="text-center">Observación</th>
								<th class="text-center">Estado Alerta</th>
								<th class="text-center">Usuario de Creación</th>
								@if (Session::get('perfil') == config('constantes.perfil_sectorialista'))
									<th class="text-center">Estado Caso</th>
									<th class="text-center">En nómina</th>
									<!-- // CZ SPRINT 74 -->
									<th class="text-center">Sename</th>
									<!-- // CZ SPRINT 74 -->
								@endif
								<th class="text-center">Acciones</th>
							</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
			</div>
		</div>
	</section>

@endsection

@section('script')

	<script type="text/javascript">
		$(document).ready( function () {
			setTimeout(function(){ $(".alert").alert('close'); }, 4000);

			let cap_tab = $('#tabla_alertas').DataTable();
			cap_tab.destroy(); 

			perfil= $('#perfil').val();

			//if(perfil!=5){

			tabla_alertas = $('#tabla_alertas').DataTable({
				"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
				"ajax": "{{ route('alertas') }}",
 				"columnDefs": [
            		{
                		"targets": [ 0 ],
                		"visible": false,
            		}
        		],				
				"columns": [
					{
					 "data": "rut_completo",
					 "className": "text-center"
					},
					{
					 "data":		"rut_completo",
					 "className":	"text-center",
					 "visible"	:	false,
					 "orderable":	true,
					 "searchable":	true,
					 "render": function(data, type, row){
					 		let rut = esconderRut(formatearRun(data), "{{ config('constantes.ofuscacion_run') }}");
					 		
					 		return rut;
					 	} 
					},
					{
						"data"		: "ale_man_nna_nombre",
						"name"		: "ale_man_nna_nombre",
						"className"	: "text-left",
						"visible"	: true,
						"orderable"	: true,
						"searchable": true,
						"render" : function (data, type, full, meta){
							let run = esconderRut(full.rut_completo, "{{ config('constantes.ofuscacion_run') }}");

							return '<label data-toggle="tooltip" data-html="true" title="R.U.N.: ' + run + '">' + full.ale_man_nna_nombre + '</label>';
						}
					},
					{ "data": "ale_tip_nom", "className": "text-left" },
					{ "data": "ale_man_obs", "className": "text-center", "visible": false },
					{ "data": "est_ale_nom", "className": "text-center" },
					{ "data": "usuario", "className": "text-center" },
					@if (Session::get('perfil') == config('constantes.perfil_sectorialista'))
					// CZ SPRINT 77
						{ "data": "estado_caso", "className": "text-center",
						 },
						{ "data": "ale_man_nomina", "className":	"text-center",
							"render" : function (data, type, full, meta){
								if(data == 'SI'){
									html = '<span class="badge badge-danger" style="font-size: 17px;font-weight: 500;">'+data+'</span>';
									return html;
								}else{
									return data;
								}
														
							}
						},
						//CZ SPRINT 74
						{ "data": "ale_man_sename", "className":	"text-center",
							"render" : function (data, type, full, meta){
								if(data == 'SI'){
									html = '<span class="badge badge-danger" style="font-size: 17px;font-weight: 500;">'+data+'</span>';
									return html;
								}else{
									return data;
								}
								
							}
						 },
						//CZ SPRINT 74
					@endif
					{
						"orderable": false,
						"className": "text-center",
						'render': function (data, type, full, meta){
							return 	'<a href="{{ route('alerta.editar') }}/'+ full.ale_man_id +'" class="btn btn-primary" >' +
								'Ver' +
								'</a>';

						}
					}
				],
				"drawCallback": function (settings){
					$('[data-toggle="tooltip"]').tooltip();
				}
			});
		});




		function aplicarColor(score){

			var claseCss = '';

			if (score >= 0 && score <= 20){			claseCss	= "alarmaUno";		}
			else if (score >= 21 && score <= 40){	claseCss	= "alarmaDos";		}
			else if (score >= 41 && score <= 60){	claseCss	= "alarmaTres";		}
			else if (score >= 61 && score <= 80){	claseCss	= "alarmaCuatro";	}
			else if (score >= 81 && score <= 100){	claseCss	= "alarmaCinco";	}

			return claseCss;

		}


	    function misAlertas(){

  			var checkBox = document.getElementById("mis_alertas");

  				tabla_alertas.destroy();

  			if (checkBox.checked == true){

  				tabla_alertas = $('#tabla_alertas').DataTable({
  				"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
				"ajax": "{{ route('misalertas') }}",
 				"columnDefs": [
            		{
                		"targets": [ 0 ],
                		"visible": false,
            		}
        		],				
				"columns": [
					{
					 "data": "rut_completo",
					 "className": "text-center"
					},
					{
					 "data": "rut_completo",
					 "className": "text-center",
					 "render": function(data, type, row){ return formatearRun(data); }
					},
					{ "data": "ale_tip_nom", "className": "text-left" },
					{ "data": "ale_man_obs", "className": "text-center" },
					{ "data": "est_ale_nom", "className": "text-center" },
					{ 'render': function (data, type, full, meta) {
							return full.nombres+' '+full.apellido;
						}, "className": "text-center" },
					{
						'render': function (data, type, full, meta) {
/*							return 	'<div class="dropdown">' +
								'<button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
								'Acciones' +
								'</button>' +
								'<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">' +
								'<a href="{{ route('alerta.editar') }}/'+ full.ale_man_id +'" class="dropdown-item" >' +
								'Modificar' +
								'</a>' +
								'</div>' +
								'</div>';
*/
							return 	'<a href="{{ route('alerta.editar') }}/'+ full.ale_man_id +'" class="btn btn-primary" >' +
								'Ver' +
								'</a>';


						}, "className": "text-center"
					}
				]
			});

 	 		} else {

 	 			tabla_alertas = $('#tabla_alertas').DataTable({
 	 			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
				"ajax": "{{ route('alertas') }}",
 				"columnDefs": [
            		{
                		"targets": [ 0 ],
                		"visible": false,
            		}
        		],				
				"columns": [
					{
					 "data": "rut_completo",
					 "className": "text-center"
					},
					{
					 "data": "rut_completo",
					 "className": "text-center",
					 "render": function(data, type, row){ return formatearRun(data); }
					},
					{ "data": "ale_tip_nom", "className": "text-left" },
					{ "data": "ale_man_obs", "className": "text-center" },
					{ "data": "est_ale_nom", "className": "text-center" },
					{ 'render': function (data, type, full, meta) {
							return full.nombres+' '+full.apellido;
						}, "className": "text-center" },
					{
						'render': function (data, type, full, meta) {
/*							return 	'<div class="dropdown">' +
								'<button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
								'Acciones' +
								'</button>' +
								'<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">' +
								'<a href="{{ route('alerta.editar') }}/'+ full.ale_man_id +'" class="dropdown-item" >' +
								'Modificar' +
								'</a>' +
								'</div>' +
								'</div>';
*/
							return 	'<a href="{{ route('alerta.editar') }}/'+ full.ale_man_id +'" class="btn btn-primary" >' +
								'Ver' +
								'</a>';


						}, "className": "text-center"
					}
				]
				});

 		    }

		}


		function invertirfecha(prefecha){

			fecha1 = prefecha.substring(0,4);
			fecha2 = prefecha.substring(5,7);
			fecha3 = prefecha.substring(8,10);
			fecha = fecha3+"-"+fecha2+"-"+fecha1;

			return fecha;
		}

		function actualizarAlertas(){

			$('#zModal').modal('hide');
			$('#tabla_alertas').DataTable().draw();

		}

		function filtrarAlertas(chk){

			var gfc	= getFiltroComunas('com_cod');

			if (gfc.length == 0){
				alert("Debe seleccionar al menos una comuna para realizar el filtro");
				$('.selectpicker').selectpicker('selectAll');
				return false;
			}

			tabla_alertas.destroy();

			listarFiltroAlertas();

		}

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

		function listarFiltroAlertas(){

			tabla_alertas = $('#tabla_alertas').DataTable({
				"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
				"ajax": "{{ route('alertas.filtro') }}/"+getFiltroComunas('com_cod'),
				"columnDefs": [
            		{
                		"targets": [ 0 ],
                		"visible": false,
            		}
        		],
				"columns": [
					{
					 "data": "rut_completo",
					 "className": "text-center"
					},
					{
					 "data": "rut_completo",
					 "className": "text-center",
					 "render": function(data, type, row){ return formatearRun(data); }
					},
					{ "data": "ale_tip_nom", "className": "text-left" },
					{ "data": "ale_man_obs", "className": "text-center" },
					{ "data": "est_ale_nom", "className": "text-center" },
					{ "data": "nombres"  },
					{
						'render': function (data, type, full, meta) {
/*							return 	'<div class="dropdown">' +
								'<button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
								'Acciones' +
								'</button>' +
								'<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">' +
								'<a href="{{ route('alerta.editar') }}/'+ full.ale_man_id +'" class="dropdown-item" >' +
								'Modificar' +
								'</a>' +
								'</div>' +
								'</div>';
*/
							return 	'<a href="{{ route('alerta.editar') }}/'+ full.ale_man_id +'" class="btn btn-primary" >' +
								'Ver' +
								'</a>';


						}, "className": "text-center"
					}
				]
			});
		}


	</script>

@endsection