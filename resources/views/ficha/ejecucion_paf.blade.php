<div class="container-fluid" >
	<div class="row">
		<div class="col">
			@if (count($titulos_modal) >= 3)
				<h5 class="modal-title" id="title_ejecucion" data-id-est="{{ $titulos_modal[2]->id_est }}"><b><i class="fas fa-archive"></i> {{ $titulos_modal[2]->titulo }}</b></h5>
			@else
				<h5 class="modal-title" id="title_ejecucion" data-id-est=""></h5>
			@endif
		</div>
		@if ($modo_visualizacion == 'edicion')
			<div class="col text-right">
				<button type="button" class="btn btn-danger btn-sm btnRechEst" data-dismiss="modal"
						@if($est_cas_fin)
							disabled 
						@else 
							onclick="comentarioEstado({{ $caso_id }});" 
						@endif>
						Desestimar Caso
				</button>
			</div>
		@endif
	</div>


	<hr>

	<!-- Historial Seguimiento Programas -->

	<div class="card shadow-sm">
		<div class="card-header p-3">
			<h5 class="mb-0"><span class="fa fa-list mr-2"></span>Historial Seguimiento Programas</h5>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table cell-border"  style="width: 100%;" id="tabla_historial_ejecucion_paf" >
					<thead>
						<tr>
							<th>Integrantes</th>
							<th>Alerta Territorial</th>
							<th>Programa / Establecimiento</th>
							<th>Responsable</th>
							<th>Estado</th>
							<th>Historial de Estados</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>


	<!-- Historial Seguimiento Programas sin Alertas-->

	<div class="card shadow-sm">
		<div class="card-header p-3">
			<h5 class="mb-0"><span class="fa fa-list mr-2"></span>Historial Seguimiento Programas sin AT Asociada</h5>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table cell-border"  style="width: 100%;" id="tabla_historial_ejecucion_paf_sin_at" >
					<thead>
						<tr>
							<th>Integrantes</th>
							<th>Programa / Establecimiento</th>
							<th>Responsable</th>
							<th>Estado</th>
							<th>Historial de Estados</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>



<!-- OBJETIVOS -->
<div>
<div class="card shadow-sm">
	<div class="card-header p-3">
		<div class="row">
			<div class="col">
				<h5 class="p-2 mb-0">Objetivos</h5>
			</div>
		</div>
	</div>
	<div class="row p-4">
	<!-- INICIO DC -->
		<table>
			<tr>
				<td><b>Nº Tareas Logradas: <span id="tarLog">{{$actividades}}</span></b></td>
			</tr>
			<tr>
				<td><b>Nº de Tareas Comprometidas: <span id="tarComp">{{$cont_tar}}</span></b></td>
			</tr>
			<tr>
				<td><b>Porcentaje de logro: <span id="porLog">{{$p_logro}}</span></b></td>
			</tr>
		</table>
    <!-- FIN DC -->
			
		</div>
	<div class="card-body">

		@includeif('ficha.listar_objetivos_ejecucion_paf')
		@includeif('ficha.registrar_sesion_objetivo_tarea_modal')
		@includeif('ficha.ver_sesion_objetivo_tarea_modal')
		@includeif('ficha.detalle_objetivo_ejecucion_paf')

	</div>
</div>
</div>

<!-- FIN OBJETIVOS -->


	<div class="card shadow-sm">
		<div class="card-header p-3">
			<h5 class="mb-0">Terapeuta Asignado</h5>
		</div>
		<div class="card-body">
			@if($terapeuta!=null)
			{!! $terapeuta !!}
			@else
			Sin Terapeuta Asignado
			@endif		
		</div>
	</div>


		
	<!--<div>
		<label for="bitacora_estado_ejecucion" style="font-weight: 800;">Bitacora Estado Actual del Caso:</label>
		<textarea onkeypress='return caracteres_especiales(event)' class="form-control txtAreEtapa " name="bit-etapa-ejecucion" id="bitacora_estado_ejecucion" rows="3" onBlur="cambioEstadoCaso(5, { { $caso_id }}, $(this).val());"
	    @ if (config('constantes.en_ejecucion_paf')  != $estado_actual_caso) disabled @ endif>{ { $bitacoras_estados[2] }}</textarea>
	</div>-->

	<!-- BITACORA ACTUAL CASO -->
	<div class="card shadow-sm alert-info">
		<div class="card-header p-3">
			<h5 class="mb-0"><i class="fa fa-pencil"></i>  Bitácora Estado Actual del Caso</h5>
		</div>
		<div class="card-body">
			<label for="bitacora_estado_ejecucion" style="font-weight: 800;">Bitácora Estado Actual del Caso:</label>
			<!-- <textarea onkeypress='return caracteres_especiales(event)' class="form-control txtAreEtapa " name="bit-etapa-ejecucion" id="bitacora_estado_ejecucion" rows="3" onBlur="cambioEstadoCaso(5, {{ $caso_id }}, $(this).val());"
		  	@if (config('constantes.en_ejecucion_paf')  != $estado_actual_caso) disabled @endif>{{ $bitacoras_estados[2] }}</textarea> -->

		  	@if ($modo_visualizacion == 'visualizacion')
					<div class="text-success" style="word-break: break-all;">
						<label class="font-weight-bold">{{ $bitacoras_estados[2] }}</label>
					</div>
		  	@elseif ($modo_visualizacion == 'edicion')
				<textarea maxlength="2000" onkeypress='return caracteres_especiales(event)' class="form-control txtAreEtapa " name="bit-etapa-ejecucion" id="bitacora_estado_ejecucion" rows="3" onBlur="cambioEstadoCaso('b5', {{ $caso_id }}, $(this).val());"
			  	@if (config('constantes.en_ejecucion_paf')  != $estado_actual_caso) disabled @endif>{{ $bitacoras_estados[2] }}</textarea>
		  	@endif



			<!-- <button type="button" id="btn-etapa-ejecucion" class="btn btn-success btn-sm btnEtapa" style="float: right;" onclick="siguienteEtapa(10, {{ $caso_id }});" disabled>
				Ir a siguiente etapa - <strong>Evaluación PAF</strong>
			</button> -->


			@if ($modo_visualizacion == 'edicion')
				<button type="button" id="btn-etapa-ejecucion" class="btn btn-success btn-sm btnEtapa" style="float: right;" onclick="siguienteEtapa({{config('constantes.en_cierre_paf')}}, {{ $caso_id }});" disabled>
					Ir a siguiente etapa - <strong>Evaluación PAF</strong>
				</button>
			@endif
		</div>
	</div>
	<!-- FIN BITACORA ACTUAL CASO -->

		
	<!--<div class="col-sm-12">
		<button type="button" class="btn btn-warning btn-sm btnRechEst" data-dismiss="modal" onclick="comentarioEstado(1, {{ $caso_id }});"
				@if (config('constantes.rechazado_por_familiares') == $estado_actual_caso || config('constantes.rechazado_por_gestor') == $estado_actual_caso) disabled @endif >
				Rechazado por Familia
		</button>
		<button type="button" class="btn btn-danger btn-sm btnRechEst" data-dismiss="modal" onclick="comentarioEstado(2, {{ $caso_id }});"
					@if (config('constantes.rechazado_por_familiares') == $estado_actual_caso || config('constantes.rechazado_por_gestor') == $estado_actual_caso) disabled @endif >
				Rechazado por Gestor
		</button>

		<button type="button" id="btn-etapa-ejecucion" class="btn btn-success btn-sm btnEtapa" style="float: right;" onclick="siguienteEtapa(10, {{ $caso_id }});"
		@if (config('constantes.rechazado_por_familiares') == $estado_actual_caso || config('constantes.rechazado_por_gestor') == $estado_actual_caso ||
		config('constantes.en_ejecucion_paf') != $estado_actual_caso ) disabled @endif >Ir a siguiente etapa - Cierre PAF
		</button>
	</div>-->

</div>

@includeif('ficha.ver_historial_estado_prestacion')
@includeif('ficha.ver_historial_estado_prestacion_sin_at')

<script type="text/javascript">
	
	$( document ).ready(function() {

		cargarSegPrest();

		cargarSegPrestSinAt();

	});

	function cargarSegPrest(){

			var cas_id = {{ $caso_id }};

			let tabla_historial_ejecucion_paf = $('#tabla_historial_ejecucion_paf').DataTable();
        	tabla_historial_ejecucion_paf.clear().destroy();	
	
			tabla_historial_ejecucion_paf = $('#tabla_historial_ejecucion_paf').on('error.dt',
            function (e, settings, techNote, message) {
                tabla_historial_ejecucion_paf.ajax.reload(null,false);
                console.log('Ocurrió un error en el datatable de: Historial Seguimiento Programas, el error es: ', message);
            }).DataTable({
				"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json" },
					"ajax": "{{ route('listarsegprest') }}/"+cas_id,
					"rowsGroup" : [0,1],
					"ordering":false,
					"columns": [
						{ "data": "integrantes", "className": "text-left","name":"integrantes"},
						{ "data": "ale_tip_nom", "className": "text-left","name":"ale_tip_nom"},
						{ "data": "", "className": "text-left",
							'render': function(data, type, full, meta){

								let pro_nom = full.pro_nom;
								let estab_nom = full.estab_nom;

								if(full.estab_id==null){ 
									return pro_nom;
								}else{
									return estab_nom;
								}

							}
						},
						{ "data": "", "className": "text-left",
							'render': function(data, type, full, meta){
								//console.log(full, full.am_ofe_id, full.gru_fam_id); return false;
								let usu_res = full.usu_responsable;

								if(usu_res==null){ usu_res="Sin Información";}

								return usu_res;
							}
						},
						{ "data": "est_prog_nom", "className": "text-left" },

						// { "data": "", "className": "text-left",
						// 	'render': function(data, type, full, meta){
						// 		let html = '<a href="#" class="btn-link" data-toggle="tooltip" title="Correo: '+full.email+', Teléfono: '+full.telefono+'">'+full.usu_responsable+'</a>';
						// 		return html;
						// 	}
						// },
						// { "data": "pro_nom", "className": "text-left",
						//    'render': function(data, type, full, meta){
						// 	   let html = "";
						// 	   let ofertas = data.split("-");

						// 	   for(let i=0; i < ofertas.length; i++){
						// 		   html += '<img src="/img/ico-alertas.svg" width="20px" height="20px"/> '+ofertas[i]+'<br><br>';
						// 	   }

						// 	   return html;
						//    }
				  //   	},
						{ "data": "", "className": "text-left",
							'render': function(data, type, full, meta){
								//console.log(full, full.am_ofe_id, full.gru_fam_id); return false;
								let html = '<button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#verHistorialEstadoPrestacion" onclick="verHistorialEstadoPrestacion('+full.cas_id+', '+full.gru_fam_id+', '+full.ale_man_id+', '+full.prog_id+');" ><i class="fa fa-history"></i> Ver Historial</button>';

								return html;
							}
						}
					]

				});
	}

	function verHistorialEstadoPrestacion(cas_id, gru_fam_id, ale_man_id, ofe_id){
		let data_historialPrestacion = $('#ver_historial_prestacion').DataTable();

		data_historialPrestacion.destroy();

		let data = new Object();
		data.cas_id = cas_id;
		data.gru_fam_id  = gru_fam_id;
		data.ale_man_id = ale_man_id;
		data.ofe_id 	= ofe_id;

		data_historialPrestacion =	$('#ver_historial_prestacion').DataTable({
			"colReorder": true,
			"fixedHeader": { header:true },
			"dom": '<lf<t>ip>',
			//"language"	: { "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json" },
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			"processing": true,
			"serverSide": false,
			"paging"    : false,
			"ordering"  : false,
			"searching" : false,
			"info"		: false,
			"ajax"		: { "url" :	"{{ route('seguimiento.ver.historial.prestacion') }}", "type": "GET",  "data": data },
			"createdRow": function( row, data, dataIndex ){
				//console.log(row, data, dataIndex); return false;
			},
			"columns"	: [
				{
					"data": "N°", //N°
					"width": "21px",
					"className": "text-center",
					"render": function(data, type, row, dataIndex){
						let cant = dataIndex.row + 1;

						return cant;
					}
				},
				{
					"data": "est_prog_nom",
					"className": "text-center"
				},
				{
					"data": "est_prog_bit_des",
					"className": "text-center"
				},
				{
					"data": "est_prog_bit_fec",
					"className": "text-center"
				}
			],
			"drawCallback": function (settings){
				$("#totalNNA").text(settings._iRecordsTotal);
			}
		});

		$('#ver_historial_prestacion').addClass("headerTablas");

		$('#ver_historial_prestacion').find("thead th").removeClass("sorting_asc");
	}


	function cargarSegPrestSinAt(){

			var cas_id = {{ $caso_id }};

			let tabla_historial_ejecucion_paf_sin_at = $('#tabla_historial_ejecucion_paf_sin_at').DataTable();
        	tabla_historial_ejecucion_paf_sin_at.clear().destroy();	
	
			tabla_historial_ejecucion_paf_sin_at = $('#tabla_historial_ejecucion_paf_sin_at').on('error.dt',
	            function (e, settings, techNote, message){
	                tabla_historial_ejecucion_paf_sin_at.ajax.reload(null,false);
	                console.log('Ocurrió un error en el datatable de: Historial Seguimiento Programas sin AT Asociada, el error es: ', message);
            }).DataTable({
				"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json" },
					"ajax": "{{ route('listarsegprestasinat') }}/"+cas_id,
					"rowsGroup" : [0],
					"ordering":false,
					"columns": [
						{ "data": "integrantes", "className": "text-left","name":"integrantes"},
						// { "data": "ale_tip_nom", "className": "text-left","name":"ale_tip_nom"},
						{ "data": "", "className": "text-left",
							'render': function(data, type, full, meta){

								let pro_nom = full.pro_nom;
								let estab_nom = full.estab_nom;

								if(full.estab_id==null){ 
									return pro_nom;
								}else{
									return estab_nom;
								}

							}
						},
						{ "data": "", "className": "text-left",
							'render': function(data, type, full, meta){
								//console.log(full, full.am_ofe_id, full.gru_fam_id); return false;
								let usu_res = full.usu_responsable;

								let usu_resp_estab = full.usu_resp_estab;

								var resp = "Sin Información";
								var cont = usu_res.replace(/ /g,"")

								if(usu_res!=null && cont.length != 0) resp = usu_res;
								if(usu_resp_estab!=null)  resp = usu_resp_estab;

								return resp;

							}
						},
						{ "data": "est_prog_nom", "className": "text-left" },

						// { "data": "", "className": "text-left",
						// 	'render': function(data, type, full, meta){
						// 		let html = '<a href="#" class="btn-link" data-toggle="tooltip" title="Correo: '+full.email+', Teléfono: '+full.telefono+'">'+full.usu_responsable+'</a>';
						// 		return html;
						// 	}
						// },
						// { "data": "pro_nom", "className": "text-left",
						//    'render': function(data, type, full, meta){
						// 	   let html = "";
						// 	   let ofertas = data.split("-");

						// 	   for(let i=0; i < ofertas.length; i++){
						// 		   html += '<img src="/img/ico-alertas.svg" width="20px" height="20px"/> '+ofertas[i]+'<br><br>';
						// 	   }

						// 	   return html;
						//    }
				  //   	},
						{ "data": "", "className": "text-left",
							'render': function(data, type, full, meta){
								//console.log(full, full.am_ofe_id, full.gru_fam_id); return false;
								let html = '<button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#verHistorialEstadoPrestacionSinAt" onclick="verHistorialEstadoPrestacionSinAt('+full.grup_fam_prog_id+');" ><i class="fa fa-history"></i> Ver Historial</button>';

								return html;
							}
						}
					]

				});
	}


	function verHistorialEstadoPrestacionSinAt(grup_fam_prog_id){

		let ver_historial_estado_prestacion_sin_at = $('#ver_historial_estado_prestacion_sin_at').DataTable();

		ver_historial_estado_prestacion_sin_at.destroy();

		let data = new Object();
		data.grup_fam_prog_id  = grup_fam_prog_id;

		ver_historial_estado_prestacion_sin_at =	$('#ver_historial_estado_prestacion_sin_at').DataTable({
			"colReorder": true,
			"fixedHeader": { header:true },
			"dom": '<lf<t>ip>',
			//"language"	: { "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json" },
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			"processing": true,
			"serverSide": false,
			"paging"    : false,
			"ordering"  : false,
			"searching" : false,
			"info"		: false,
			"ajax"		: { "url" :	"{{ route('seguimiento.ver.historial.prestacion.sin.at') }}", "type": "GET",  "data": data },
			"createdRow": function( row, data, dataIndex ){
				//console.log(row, data, dataIndex); return false;
			},
			"columns"	: [
				{
					"data": "N°", //N°
					"width": "21px",
					"className": "text-center",
					"render": function(data, type, row, dataIndex){
						let cant = dataIndex.row + 1;

						return cant;
					}
				},
				{
					"data": "est_prog_nom",
					"className": "text-center"
				},
				{
					"data": "est_prog_bit_des",
					"className": "text-center"
				},
				{
					"data": "est_prog_bit_fec",
					"className": "text-center"
				}
			],
			"drawCallback": function (settings){
				$("#totalNNA").text(settings._iRecordsTotal);
			}
		});
		$('#ver_historial_estado_prestacion_sin_at').addClass("headerTablas");
		$('#ver_historial_estado_prestacion_sin_at').find("thead th").removeClass("sorting_asc");
	}
</script>
