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


?>

			<div class="card p-4 shadow-sm">
					<input id="token" hidden value="{{ csrf_token() }}">
					<input id="perfil" name="perfil" type="hidden" value="{{ Session::get('perfil') }}">

					<input id="user_id" name="user_id" type="hidden" value="{{ Session::get('perfil') }}">
<!-- 				<div class="text-right">
					<a href="{{ route('alertas.crear') }}" class="btn btn-success" data-toggle="tooltip" data-placement="left" title="Nueva Alerta manual" id="IDnuevo" >+ Crear alerta</a>
				</div>
 -->					<div class="table-responsive">

						<table class="table table-striped table-hover" cellspacing="0" id="tabla_alertas">

							<thead>
								<tr>
										<th colspan="13">
											<div class="row">
     											<div class="col-md-3">
											    <label>Fecha inicio: </label>
											        {{-- <input type="date" name="start_date" id="start_date" class="form-control datepicker-autoclose" placeholder="Please select start date"> --}}
											        <div class="input-group date-pick" id="start_date_" data-target-input="nearest">
														<input onkeypress='return caracteres_especiales_fecha(event)' type="text" name="start_date" class="form-control datetimepicker-input "  data-target="#start_date_" id="start_date"  value="">
														<div class="input-group-append" data-target="#start_date_" data-toggle="datetimepicker">
															<div class="input-group-text"><i class="fa fa-calendar"></i></div>
														</div>
													</div>
											    </div>
											    <div class="col-md-3">
											    <label>Fecha Fin</label>
											        {{-- <input type="date" name="end_date" id="end_date" class="form-control datepicker-autoclose" placeholder="Please select end date"> --}}
											         <div class="input-group date-pick" id="end_date_" data-target-input="nearest">
														<input onkeypress='return caracteres_especiales_fecha(event)' type="text" name="end_date" class="form-control datetimepicker-input "  data-target="#end_date_" id="end_date"  value="">
														<div class="input-group-append" data-target="#end_date_" data-toggle="datetimepicker">
															<div class="input-group-text"><i class="fa fa-calendar"></i></div>
														</div>
													</div>
											    </div>
											     <div class="col-lg-2">
											     	<label>Estado Alerta</label>
								                    <select class="form-control" id="estado_alerta" name="estado_alerta">
								                        <option value="">Estado Alerta</option>
								                         <?php 
								                             foreach($estado_alerta as $est_ale) {
								                                $selected ="";
								                                echo "<option value='{$est_ale->est_ale_id}' {$selected}>".$est_ale->est_ale_nom."</option>";
								                             }
								                         ?>  
								                    </select>
								                 </div>
											     <div class="col-md-2">
											    <label>Caso</label>
											        <select name="sin_caso" id="sin_caso" class="form-control" required>
												       <option value="">Ambos</option>
												       <option value="Si" selected="selected">Sin Caso</option>
												       <option value="No">Con Caso</option>
												      </select> 
											    </div>
											    <div class="col-md-2">
											    <label>Nómina</label>
											        <select name="nomina" id="nomina" class="form-control" required>
												       <option value="">Ambos</option>
												       <option value="Si">En Nómina</option>
												       <option value="No" selected="selected">Sin Nómina</option>
												    </select>
												</div>										   
										    </div>
										    <div class="row">
											    <div class="col-lg-12 mt-3 mr-3">
											        <button type="text" id="btnFilterSubmitSearch" class="btn btn-info float-right">Filtrar</button>

											        <button class="btn btn-success float-right mr-3" id="xls_alertas" name="xls_alertas">
						   								<i class="fas fa-download"></i> Descargar
													</button>
											    </div>
											</div>
											    <br>
										</div></th>
								</tr>
							<tr>
								<th class="text-center">RUNSINFORMATO</th>
								<th class="text-center" style="display: none;">R.U.N</th> 
								<th class="text-center">Nombre NNA</th>
								<th class="text-center">Alerta Territorial</th>
								<th class="text-center">Observación</th>
								<th class="text-center">Estado Alerta</th>
								<th class="text-center">Usuario de Creación</th>
								<th class="text-center">Fecha Creación</th>
								<th class="text-center">Caso</th>
								<th class="text-center">Estado Gesti&oacute;n Caso</th>
								<th class="text-center">Estado Terapia Familiar</th>
								<th class="text-center">En Nómina</th>
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


			tabla_alertas = $('#tabla_alertas').DataTable({
				"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
				"processing": true,
         		"serverSide": true,
         		"sDom": "<'clazz'lf><'clazz-2'tr>ip",
				{{-- // "ajax": "{{ route('alertasSinNomina') }}", --}}
				ajax: {
		          "url": "{{ route('alertasSinNomina') }}",
		          "type": 'GET',
		          data: function (d) {
		           d.start_date = $('#start_date').val();
		           d.end_date = $('#end_date').val();
		           d.nomina = $('#nomina').val();
		           d.sin_caso = $('#sin_caso').val();
		           d.estado_alerta = $('#estado_alerta').val();
		          }
		         },
 				"columnDefs": [
            		{
                		"targets": [ 0 ],
                		"visible": false,
            		}
        		],				
				"columns": [
					{
					 "data": "ale_man_run",
					 "className": "text-center"
					},
					{
					 "data": 		"rut_completo",
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
						"data"		: "rut_completo",
						"name"		: "rut_completo",
						"className"	: "text-left",
						"visible"	: true,
						"orderable"	: true,
						"searchable": true,
						"render" : function (data, type, full, meta){
							let rut = esconderRut(formatearRun(data), "{{ config('constantes.ofuscacion_run') }}");
							return '<label data-toggle="tooltip" data-html="true" title="R.U.N.: ' + rut + '">' + full.ale_man_nna_nombre + '</label>';
						}
					},
					{ "data": "ale_tip_nom", "className": "text-left" },
					{ "data": "ale_man_obs", "className": "text-center", "visible": false },
					{ "data": "est_ale_nom", "className": "text-center" },
					{ "data": "usuario", "className": "text-center" },
					{
					 "data": "ale_man_fec",
					 "className": "text-center",
					 "render": function(data, type, row){

					 		let fecha = moment(row.ale_man_fec).format('DD/MM/YYYY'); 
					 		
					 		return fecha;
					 	} 
					 },
					 {
					 "data": "cas_id",
					 "className": "text-center",
					 "render": function(data, type, row){
					 		if(data == null){data = 'Sin Caso'}
					 		return data;
					 	} 
					 },
					 {
					 "data": "est_cas_nom",
					 "className": "text-center",
					 "render": function(data, type, row){
					 		if(data == null){data = 'Sin Estado'}
					 		return data;
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
					 "data": "run",
					 "className": "text-center",
					 "render": function(data, type, row){
					 		if(data == null){data = 'No'}else{data = 'Si'}
					 		return data;
					 	} 
					 },
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

		$('#btnFilterSubmitSearch').click(function(){
		     $('#tabla_alertas').DataTable().draw(true);
		 });

		


		    $("#xls_alertas").on("click", function() {
    // Data to post

    	   let ex_start_date = $('#start_date').val();
		   let ex_end_date = $('#end_date').val();
		   let ex_estado_alerta = $('#estado_alerta').val();
		   let ex_nomina = $('#nomina').val();
		   let ex_sin_caso = $('#sin_caso').val();

    // var params = 'nombre=pat';
    var params = 'start_date='+ ex_start_date +'&end_date='+ex_end_date+'&estado_alerta='+ex_estado_alerta+'&nomina='+ex_nomina+'&sin_caso='+ex_sin_caso;

    // Use XMLHttpRequest instead of Jquery $ajax
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        var a;
        if (xhttp.readyState === 4 && xhttp.status === 200) {
            // Trick for making downloadable link
            a = document.createElement('a');
            a.href = window.URL.createObjectURL(xhttp.response);
            // Give filename you wish to download
            a.download = 'Alertas_Territoriales_'+ex_start_date+'_'+ex_end_date+'_.xlsx';
            a.style.display = 'none';
            document.body.appendChild(a);
            a.click();
        }
    };
        // Post data to URL which handles post request
        xhttp.open("GET", '{{route('rptExportAlertasTerritoriales')}}?'+params,true);
        xhttp.setRequestHeader("Content-Type", "application/json");
        // You should set responseType as blob for binary responses
        xhttp.responseType = 'blob';
        xhttp.send(null);
});

		$(function() {

			var date = new Date();
			var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);


			// $('.date-pick').datetimepicker({
			// 	locale: 'es',
			// 	// maxDate: $.now(),
			// 	minDate: new Date('2019/06/01'),
			// 	defaultDate: firstDay,
			// 	format: 'DD/MM/Y'
			// });

			$('#start_date_').datetimepicker({
				locale: 'es',
				// maxDate: $.now(),
				minDate: new Date('2019/06/01'),
				defaultDate: firstDay,
				format: 'DD/MM/Y'
			});

			$('#end_date_').datetimepicker({
				locale: 'es',
				maxDate: $.now(),
				minDate: new Date('2019/06/01'),
				defaultDate: $.now(),
				format: 'DD/MM/Y'
			});

		});

	</script>

	<style type="text/css">
		div.dataTables_wrapper div.dataTables_processing {
   left: 0%;
   top: 250px;
}
	</style>

@endsection