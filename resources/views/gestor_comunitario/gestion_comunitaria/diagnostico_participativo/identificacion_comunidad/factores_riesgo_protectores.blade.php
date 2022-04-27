<div class="row">
	<div class="col-6">
		<div class="datatable_encabezado_frp">FACTORES DE RIESGO SOCIONATURALES</div>
		<table class="table table-striped table-hover w-100" cellspacing="0" id="tabla_riesgo_socio_naturales">
			<thead>
				<tr>
					<th>Factores</th>
					@if (Session::get('perfil') == config('constantes.perfil_gestor_comunitario') || Session::get('perfil') == config('constantes.perfil_coordinador') || session()->all()['perfil'] == config('constantes.perfil_coordinador_regional'))
						<th></th>
					@endif
				</tr>
			</thead>
			<tbody></tbody>
		</table>
	</div>
	
	<div class="col-6">
		<div class="datatable_encabezado_frp">FACTORES DE RIESGO INFRAESTRUCTURA</div>
		<table class="table table-striped table-hover w-100" cellspacing="0" id="tabla_riesgo_infraestructura">
			<thead>
				<tr>
					<th>Factores</th>
					@if (Session::get('perfil') == config('constantes.perfil_gestor_comunitario'))
						<th></th>
					@endif
				</tr>
			</thead>
			<tbody></tbody>
		</table>
	</div>
</div><br><br>

<div class="row">
	<div class="col-6">
		<div class="datatable_encabezado_frp">FACTORES DE RIESGO SOCIOCOMUNITARIOS</div>
		<table class="table table-striped table-hover w-100" cellspacing="0" id="tabla_riesgo_sociocomunitario">
			<thead>
				<tr>
					<th>Factores</th>
					@if (Session::get('perfil') == config('constantes.perfil_gestor_comunitario'))
						<th></th>
					@endif
				</tr>
			</thead>
			<tbody></tbody>
		</table>
	</div>
	<div class="col-6">
		<div class="datatable_encabezado_frp">FACTORES PROTECTORES INFRAESTRUCTURA</div>
		<table class="table table-striped table-hover w-100" cellspacing="0" id="tabla_protectores_infraestructura">
			<thead>
				<tr>
					<th>Factores</th>
					@if (Session::get('perfil') == config('constantes.perfil_gestor_comunitario'))
						<th></th>
					@endif
				</tr>
			</thead>
			<tbody></tbody>
		</table>
	</div>
</div><br><br>

<div class="row">
	<div class="col-6">
		<div class="datatable_encabezado_frp">FACTORES PROTECTORES SOCIOCOMUNITARIOS</div>
		<table class="table table-striped table-hover w-100" cellspacing="0" id="tabla_protectores_sociocomunitario">
			<thead>
				<tr>
					<th>Factores</th>
					@if (Session::get('perfil') == config('constantes.perfil_gestor_comunitario'))
						<th></th>
					@endif
				</tr>
			</thead>
			<tbody></tbody>
		</table>
	</div>
</div>
<style type="text/css">
	.datatable_encabezado_frp{
		background-color: #e6f3fd;
    	text-align: center;
    	font-weight: 800;
    	text-transform: uppercase;
    	text-decoration: underline;
    	padding: 6px 0;
	}
</style>

<script type="text/javascript">

	function listarFactores(){
		listarSocioNaturales();
    	listarRiesgoInfraEstructura();
    	listarProtectoresInfraEstructura();
    	listarRiesgoSocioComunitarios();
    	listarProtectoresSocioComunitarios();
	}

	// FACTORES DE RIESGO SOCIONATURALES 
	function listarSocioNaturales(){
		let tabla_riesgo_socio_naturales = $('#tabla_riesgo_socio_naturales').DataTable();
        tabla_riesgo_socio_naturales.clear().destroy();	

        let data = new Object();
        data.pro_an_id 	    = $("#pro_an_id").val();
		data.fac_gc_tip 	= 1;

  		tabla_riesgo_socio_naturales = $('#tabla_riesgo_socio_naturales').DataTable({
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			"ordering": 	false,
			"lengthChange": false,
			"info": 		false,
			"searching": 	false,
			"paging":   	false,
			"ajax": {
    			"url": "{{ route('listar.socio.naturales') }}",
    			"type": "GET",
				"data": data
  			},
			"columnDefs": [
            	{ //FACTORES
					"targets": 0,
					"className": 'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
				@if (Session::get('perfil') == config('constantes.perfil_gestor_comunitario'))
					{ //CHECK
						"targets": 1,
						"className": 'dt-head-center dt-body-left',
						"createdCell": function (td, cellData, rowData, row, col) {
					        $(td).css("vertical-align", "middle");
					     
					    }
					}
				@endif
    		],				
			"columns": [
						{ //FACTORES
							"data": "fac_gc_nom",
							"className": "text-center"
						},
						@if (Session::get('perfil') == config('constantes.perfil_gestor_comunitario') || Session::get('perfil') == config('constantes.perfil_coordinador') || session()->all()['perfil'] == config('constantes.perfil_coordinador_regional'))
							{ //ETAPA ACTUAL
								"data": "fac_gc_id",
								"className": "text-center",
								"render": function(data, type, row){
									let html = "";

									@foreach ($acciones as $accion)
                                        @if ($accion->cod_accion == "GCM20")
											html = '<div class="form-check"><input class="form-check-input" type="checkbox" data-fac-gc-id="'+data+'" onchange="guardarRespuestaFactor(this)"';

											if (row.checked){
										 		html += ' checked="true"></div>';

											}else{
										 		html += '></div>';

											}
										@endif
									@endforeach	


									if (html == ""){
										@foreach ($acciones as $accion)
											@if ($accion->cod_accion == "GCM21")
												if (row.checked){
													html += '<i class="fa fa-check-circle fa-3" aria-hidden="true"></i>';

												}
                                        	@endif
										@endforeach	
									}
									//INICIO CZ SPRINT 67
									if($('#desestimado').val() == 1 || $('#est_pro_id').val() == 3){
										$('input').attr('disabled', 'disabled');
									}
									//FIN CZ SPRINT 67
									return html;
								}
							}
						@endif
					]
		});
	}


	// FACTORES DE RIESGO INFRAESTRUCTURA
	function listarRiesgoInfraEstructura(){
		let tabla_riesgo_infraestructura = $('#tabla_riesgo_infraestructura').DataTable();
        tabla_riesgo_infraestructura.clear().destroy();

        let data = new Object();
        data.pro_an_id 	    = $("#pro_an_id").val();
		data.fac_gc_tip 	= 2;	

  		tabla_riesgo_infraestructura = $('#tabla_riesgo_infraestructura').DataTable({
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			"ordering": 	false,
			"lengthChange": false,
			"info": 		false,
			"searching": 	false,
			"paging":   	false,
			"ajax": {
    			"url": "{{ route('listar.riesgo.infraestructura') }}",
    			"type": "GET",
				"data": data
  			},
			"columnDefs": [
            	{ //FACTORES
					"targets": 0,
					"className": 'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
				// CZ 75
				@if (Session::get('perfil') == config('constantes.perfil_gestor_comunitario'))
				{ //CHECK
					"targets": 1,
					"className": 'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				}
				@endif
				// CZ 75
    		],				
			"columns": [
						{ //FACTORES
							"data": "fac_gc_nom",
							"className": "text-center"
						},
						// CZ 75
						@if (Session::get('perfil') == config('constantes.perfil_gestor_comunitario'))
						{ //ETAPA ACTUAL
							"data": "fac_gc_id",
							"className": "text-center",
							"render": function(data, type, row){
								let html = "";
						// CZ 75
									@foreach ($acciones as $accion)
                                        @if ($accion->cod_accion == "GCM20")
											html = '<div class="form-check"><input class="form-check-input" type="checkbox" data-fac-gc-id="'+data+'" onchange="guardarRespuestaFactor(this)"';

											if (row.checked){
										 		html += ' checked="true"></div>';

											}else{
										 		html += '></div>';

											}
										@endif
									@endforeach	


									if (html == ""){
										@foreach ($acciones as $accion)
											@if ($accion->cod_accion == "GCM21")
												if (row.checked){
													html += '<i class="fa fa-check-circle fa-3" aria-hidden="true"></i>';

												}
                                        	@endif
										@endforeach	
									}
									//INICIO CZ SPRINT 67
									if($('#desestimado').val() == 1 || $('#est_pro_id').val() == 3){
										$('input').attr('disabled', 'disabled');
									}
									//FIN CZ SPRINT 67
									return html;
							}
						}
						@endif
						// CZ 75
					]
		});
	}


	// FACTORES DE RIESGO SOCIOCOMUNITARIOS
	function listarRiesgoSocioComunitarios(){
		let tabla_riesgo_sociocomunitario = $('#tabla_riesgo_sociocomunitario').DataTable();
        tabla_riesgo_sociocomunitario.clear().destroy();

        let data = new Object();
        data.pro_an_id 	    = $("#pro_an_id").val();
		data.fac_gc_tip 	= 3;	

  		tabla_riesgo_sociocomunitario = $('#tabla_riesgo_sociocomunitario').DataTable({
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			"ordering": 	false,
			"lengthChange": false,
			"info": 		false,
			"searching": 	false,
			"paging":   	false,
			"ajax": {
    			"url": "{{ route('listar.riesgo.sociocomunitarios') }}",
    			"type": "GET",
				"data": data
  			},
			"columnDefs": [
            	{ //FACTORES
					"targets": 0,
					"className": 'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
				// CZ 75
				@if (Session::get('perfil') == config('constantes.perfil_gestor_comunitario'))
				{ //CHECK
					"targets": 1,
					"className": 'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				}
				@endif
				// CZ 75
    		],				
			"columns": [
						{ //FACTORES
							"data": "fac_gc_nom",
							"className": "text-center"
						},
						// CZ 75
						@if (Session::get('perfil') == config('constantes.perfil_gestor_comunitario'))
						{ //ETAPA ACTUAL
							"data": "fac_gc_id",
							"className": "text-center",
							"render": function(data, type, row){
								let html = "";

								@foreach ($acciones as $accion)
                                    @if ($accion->cod_accion == "GCM20")
										html = '<div class="form-check"><input class="form-check-input" type="checkbox" data-fac-gc-id="'+data+'" onchange="guardarRespuestaFactor(this)"';

										if (row.checked){
									 		html += ' checked="true"></div>';

										}else{
									 		html += '></div>';

										}
									@endif
								@endforeach	


								if (html == ""){
									@foreach ($acciones as $accion)
										@if ($accion->cod_accion == "GCM21")
											if (row.checked){
												html += '<i class="fa fa-check-circle fa-3" aria-hidden="true"></i>';

											}
                                    	@endif
									@endforeach	
								}
								//INICIO CZ SPRINT 67
									if($('#desestimado').val() == 1 || $('#est_pro_id').val() == 3){
										$('input').attr('disabled', 'disabled');
									}
									//FIN CZ SPRINT 67
								return html;
							}
						}
						@endif
						// CZ 75
					]
		});
	}

	// FACTORES PROTECTORES INFRAESTRTUCTURA
	function listarProtectoresInfraEstructura(){
		let tabla_protectores_infraestructura = $('#tabla_protectores_infraestructura').DataTable();
        tabla_protectores_infraestructura.clear().destroy();	

        let data = new Object();
        data.pro_an_id 	    = $("#pro_an_id").val();
		data.fac_gc_tip 	= 4;

  		tabla_protectores_infraestructura = $('#tabla_protectores_infraestructura').DataTable({
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			"ordering": 	false,
			"lengthChange": false,
			"info": 		false,
			"searching": 	false,
			"paging":   	false,
			"ajax": {
    			"url": "{{ route('listar.protectores.infraestructura') }}",
    			"type": "GET",
				"data": data
  			},
			"columnDefs": [
            	{ //FACTORES
					"targets": 0,
					"className": 'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
				// CZ 75
				@if (Session::get('perfil') == config('constantes.perfil_gestor_comunitario'))
				{ //CHECK
					"targets": 1,
					"className": 'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				}
				@endif
				// CZ 75
    		],				
			"columns": [
						{ //FACTORES
							"data": "fac_gc_nom",
							"className": "text-center"
						},
						// CZ 75
						@if (Session::get('perfil') == config('constantes.perfil_gestor_comunitario'))
						{ //ETAPA ACTUAL
							"data": "fac_gc_id",
							"className": "text-center",
							"render": function(data, type, row){
								let html = "";

								@foreach ($acciones as $accion)
                                    @if ($accion->cod_accion == "GCM20")
										html = '<div class="form-check"><input class="form-check-input" type="checkbox" data-fac-gc-id="'+data+'" onchange="guardarRespuestaFactor(this)"';

										if (row.checked){
									 		html += ' checked="true"></div>';

										}else{
									 		html += '></div>';

										}
									@endif
								@endforeach	


								if (html == ""){
									@foreach ($acciones as $accion)
										@if ($accion->cod_accion == "GCM21")
											if (row.checked){
												html += '<i class="fa fa-check-circle fa-3" aria-hidden="true"></i>';

											}
                                    	@endif
									@endforeach	
								}
								//INICIO CZ SPRINT 67
									if($('#desestimado').val() == 1 || $('#est_pro_id').val() == 3){
										$('input').attr('disabled', 'disabled');
									}
									//FIN CZ SPRINT 67
								return html;
							}
						}
						@endif
						// CZ 75
					]
		});
	}

	

	// FACTORES PROTECTORES SOCIOCOMUNITARIOS
	function listarProtectoresSocioComunitarios(){
		let tabla_protectores_sociocomunitario = $('#tabla_protectores_sociocomunitario').DataTable();
        tabla_protectores_sociocomunitario.clear().destroy();

        let data = new Object();
        data.pro_an_id 	    = $("#pro_an_id").val();
		data.fac_gc_tip 	= 5;	

  		tabla_protectores_sociocomunitario = $('#tabla_protectores_sociocomunitario').DataTable({
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			"ordering": 	false,
			"lengthChange": false,
			"info": 		false,
			"searching": 	false,
			"paging":   	false,
			"ajax": {
    			"url": "{{ route('listar.protectores.sociocomunitarios') }}",
    			"type": "GET",
				"data": data
  			},
			"columnDefs": [
            	{ //FACTORES
					"targets": 0,
					"className": 'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
				// CZ 75
				@if (Session::get('perfil') == config('constantes.perfil_gestor_comunitario'))
				{ //CHECK
					"targets": 1,
					"className": 'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				}
				@endif
				// CZ 75
    		],				
			"columns": [
						{ //FACTORES
							"data": "fac_gc_nom",
							"className": "text-center"
						},
						// CZ 75
						@if (Session::get('perfil') == config('constantes.perfil_gestor_comunitario'))
						{ //ETAPA ACTUAL
							"data": "fac_gc_id",
							"className": "text-center",
							"render": function(data, type, row){
								let html = "";

								@foreach ($acciones as $accion)
                                    @if ($accion->cod_accion == "GCM20")
										html = '<div class="form-check"><input class="form-check-input" type="checkbox" data-fac-gc-id="'+data+'" onchange="guardarRespuestaFactor(this)"';

										if (row.checked){
									 		html += ' checked="true"></div>';

										}else{
									 		html += '></div>';

										}
									@endif
								@endforeach	


								if (html == ""){
									@foreach ($acciones as $accion)
										@if ($accion->cod_accion == "GCM21")
											if (row.checked){
												html += '<i class="fa fa-check-circle fa-3" aria-hidden="true"></i>';

											}
                                    	@endif
									@endforeach	
								}
								//INICIO CZ SPRINT 67
									if($('#desestimado').val() == 1 || $('#est_pro_id').val() == 3){
										$('input').attr('disabled', 'disabled');
									}
									//FIN CZ SPRINT 67
								return html;
							}
						}
						@endif
						// CZ 75
					]
		});
	}

	function guardarRespuestaFactor(_this){
		let data = new Object();

		data.pro_an_id 	    = $("#pro_an_id").val();
		data.fac_gc_id 		= $(_this).attr("data-fac-gc-id");

		data.accion 		= "Agregar";
		if (!$(_this).prop('checked')){
			data.accion 		= "Eliminar";
		
		}
		// data.re_fa_gc_des 	= cas_id;


		bloquearPantalla();
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});

		$.ajax({
			"url" : '{{ route("guardar.factores") }}',
			"type": "POST",
			"data": data
		}).done(function(resp){
			desbloquearPantalla();

			if (resp.estado == 1){
               mensajeTemporalRespuestas(1, resp.mensaje);

			}else if (resp.estado == 0){
               mensajeTemporalRespuestas(0, resp.mensaje);
				
			}
		}).fail(function(objeto, tipoError, errorHttp){
			desbloquearPantalla();
			manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

			return false;
		});
	}
</script>