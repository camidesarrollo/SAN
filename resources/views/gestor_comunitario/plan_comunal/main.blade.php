@extends('layouts.main')

@section('contenido')

	<section class="p-1 cabecera">
		<div class="container-fluid">
			<div class="row align-items-center">
				<div class="col">
					<h5><i class="{{$icono}}"></i> Listado de Actividades</h5>
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
				@includeif('gestor_comunitario.bitacora.formulario_actividades')
			</div>
		</section>

	<section>
		<div class="container-fluid">

			<?php $com_ses = Session::get('comunas'); ?>
			
			<div class="card p-4 shadow-sm">
				<div class="table-responsive">
					<div class="text-right">
						<button type="button" onclick="limpiarFormularioActividades()" class="btn btn-outline-success" data-toggle="modal" data-target="#frmActividades"><i class="fa fa-plus-circle"></i> Crear</button>
					</div>
					<table class="table table-striped table-hover" cellspacing="0" id="tabla_actividades">
	
						<thead>
	
						<tr>                        
							<th class="text-center">Fecha de Actividad</th>
							<th class="text-center">Lugar</th>
							<th class="text-center">Hitos</th>
							<th class="text-center">Actividades Planificadas</th>
							<th class="text-center">Actividades Realizadas</th>
							<!--@ if(Session::get('perfil')!=5)-->
							<th class="text-center">Acciones</th>
							<!--@ endif-->
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
			verificarDireccion();
			$('#tabla_actividades').DataTable({
				"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
				"ajax": "{{ route('listar.actividad') }}",
				"columnDefs": [
            	{ //FECHA DE LA ACTIVIDAD
					"targets": 0,
					"className": 'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
				{ //LUGAR
					"targets": 1,
					"className": 'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
				{ //HITO
					"targets": 2,
					"className": 'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
				{ //ACTIVIDADES PLANIFICADAS
					"targets": 3,
					"className": 'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
				{ //ACTIVIDADES REALIZADAS
					"targets": 4,
					"className": 'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
				{ //ACCIONES
					"targets": 5,
					"className": 'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				}
    		],		
				"columns": [
					{ "data": "act_fec_act", 
                        "className": "text-center",
                        "render": function(data, type, row){
								let fec_act = row.act_fec_act.substring(0,10);
								//alert(row.hito.cb_hito_nom)
								return fec_act;
							}
						},
                        { "data": "lugarbitacora.0.cb_lug_bit_nom", "className": "text-center" },
                        { "data": 'hito.0.cb_hito_nom', "className": "text-center" },
                        { "data": "act_plan", "className": "text-center" },
                        { "data": "act_real", "className": "text-center" },
						{ //ACCIONES
							"data": "",
							"render": function(data, type, row){
								let html = '<button type="button" class="btn btn-primary" onclick="editarActividad('+row.act_id+');" data-toggle="modal" data-target="#frmActividades"><span class="oi oi-pencil"></span> Editar</button>';

								return html;
							}
						},
				],select: true,
			});
			
		});

		function limpiarFormularioActividades(){
			dir_est = {{ $dir_est }};
	//INFORMACION GENERAL
	$("#start_date").val("");
	$("#lug_id").prop('selectedIndex', 0);
	if(dir_est == 0){
		$("#reg_id").prop('selectedIndex', 0);
		$("#com_id").prop('selectedIndex', 0);
		$("#act_cal").val("");
		$("#act_num").val("");
	}		
	

	//PARTICIPANTES
	$("#act_id").prop('selectedIndex', 0);
	$("#act_tot_part").val("");
	$("#act_num_nna").val("");
	$("#act_num_adult").val(""); 

	//ACTIVIDADES
	$("#hit_id").prop('selectedIndex', 0);
	$("#act_plan").val("");
	$("#act_real").val("");
	$("#act_mat").val("");
	$("#act_des").val("");
	$("#act_obs").val("");
}

function limpiarValidacionesFrmActividades(){

	//INFORMACION GENERAL
	$("#val_start_date").hide();
	$("#val_lug_id").hide();
	$("#val_reg_id").hide();
	$("#val_com_id").hide();
	$("#val_act_cal").hide();
	$("#val_act_num").hide();

	$("#star_date").removeClass("is-invalid");
	$("#lug_id").removeClass("is-invalid");
	$("#nna_region").removeClass("is-invalid");
	$("#com_id").removeClass("is-invalid");
	$("#act_cal").removeClass("is-invalid");
	$("#act_num").removeClass("is-invalid");        

	//PARTICIPANTES
	$("#val_act_id").hide();
	$("#val_act_tot_part").hide();
	$("#val_act_num_nna").hide();
	$("#val_act_num_adult").hide(); 

	$("#act_id").removeClass("is-invalid");
	$("#act_tot_part").removeClass("is-invalid");
	$("#act_num_nna").removeClass("is-invalid");
	$("#act_num_adult").removeClass("is-invalid");

	//ACTIVIDADES
	$("#val_hit_id").hide();
	$("#val_act_plan").hide();
	$("#val_act_real").hide();
	$("#val_act_mat").hide();
	$("#val_act_des").hide();

	$("#hit_id").removeClass("is-invalid");
	$("#act_plan").removeClass("is-invalid");
	$("#act_real").removeClass("is-invalid");
	$("#act_des").removeClass("is-invalid");
	$("#act_mat").removeClass("is-invalid");
}

// function editarActividad(){

// }

function validarFrm(){

	limpiarValidacionesFrmActividades();

	let respuesta = true;
	
	//INFORMACION GENERAL
	let act_fec =  $("#start_date").val();
	let act_lug =  $("#lug_id option:selected").val();
	let act_reg =  $("#reg_id option:selected").val();
	let act_com =  $("#com_id option:selected").val();
	let act_cal =  $("#act_cal").val();
	let act_num =  $("#act_num").val();

	//PARTICIPANTES
	let act_act =  $("#act_id option:selected").val();
	let act_tot =  $("#act_tot_part").val();
	let act_nna =  $("#act_num_nna").val();
	let act_adl =  $("#act_num_adult").val(); 

	//ACTIVIDADES
	let act_hito =  $("#hit_id option:selected").val();
	let act_plan =  $("#act_plan").val();
	let act_real =  $("#act_real").val();
	let act_desc =  $("#act_des").val();
	let act_mate =  $("#act_mat").val();

	if (act_fec == "" || typeof act_fec === "undefined"){
		respuesta = false;
		$("#val_star_date").show();
		$("#start_date").addClass("is-invalid");
	}  
	
	if (act_lug == "" || typeof act_lug === "undefined"){
		respuesta = false;
		$("#val_lug_id").show();
		$("#lug_id").addClass("is-invalid");
	}

	if (act_reg == "" || typeof act_reg === "undefined"){
		respuesta = false;
		$("#val_nna_region").show();
		$("#reg_id").addClass("is-invalid");
	} 

	if (act_com == "" || typeof act_com === "undefined"){
		respuesta = false;
		$("#val_com_id").show();
		$("#com_id").addClass("is-invalid");
	} 

	// if (act_cal == "" || typeof act_cal === "undefined"){
	//     respuesta = false;
	//     $("#val_act_cal").show();
	//     $("#act_cal").addClass("is-invalid");
	// } 

	if (act_num == "" || typeof act_num === "undefined"){
		respuesta = false;
		$("#val_act_num").show();
		$("#act_num").addClass("is-invalid");
	} 

	//  PARTICIPANTES

	if (act_act == "" || typeof act_act === "undefined"){
		respuesta = false;
		$("#val_act_id").show();
		$("#act_id").addClass("is-invalid");
	}
	
	if (act_tot == "" || typeof act_tot === "undefined"){
		respuesta = false;
		$("#val_act_tot_part").show();
		$("#act_tot_part").addClass("is-invalid");
	} 

	if (act_nna == "" || typeof act_nna === "undefined"){
		respuesta = false;
		$("#val_act_num_nna").show();
		$("#act_num_nna").addClass("is-invalid");
	} 

	if (act_adl == "" || typeof act_adl === "undefined"){
		respuesta = false;
		$("#val_act_num_adult").show();
		$("#act_num_adult").addClass("is-invalid");
	} 

	//  ACTIVIDADES

	if (act_hito == "" || typeof act_hito === "undefined"){
		respuesta = false;
		$("#val_hit_id").show();
		$("#hit_id").addClass("is-invalid");
	} 

	if (act_plan == "" || typeof act_plan === "undefined"){
		respuesta = false;
		$("#val_act_plan").show();
		$("#act_plan").addClass("is-invalid");
	}

	if (act_real == "" || typeof act_real === "undefined"){
		respuesta = false;
		$("#val_act_real").show();
		$("#act_real").addClass("is-invalid");
	}

	if (act_desc == "" || typeof act_desc === "undefined"){
		respuesta = false;
		$("#val_act_des").show();
		$("#act_des").addClass("is-invalid");
	}

	if (act_mate == "" || typeof act_mate === "undefined"){
		respuesta = false;
		$("#val_act_mat").show();
		$("#act_mat").addClass("is-invalid");
	}

	return respuesta;

}    

function ingresarActividad(){
	
  let res_val_frm = validarFrm();
  
  if (res_val_frm == false) return false;

  bloquearPantalla(); 

  var data = new Object();

  // I. INFORMACION GENERAL
  
  data.fec_act = $("#start_date").val();
  data.lugar = $("#lug_id option:selected").val();
  data.reg = $("#reg_id").val();
  data.com = $("#com_id").val();
  data.cal = $("#act_cal").val();
  data.num = $("#act_num").val();

  // II. PARTICIPANTES

  data.actor        = $("#act_id option:selected").val();
  data.tot_part     = $("#act_tot_part").val();
  data.num_nna      = $("#act_num_nna").val();
  data.num_adult    = $("#act_num_adult").val();

  // III.   ACTIVIDADES

  data.hito         = $("#hit_id option:selected").val();
  data.act_plan     = $("#act_plan").val();
  data.act_real     = $("#act_real").val();
  data.act_des      = $("#act_des").val();
  data.act_mat      = $("#act_mat").val();
  data.act_obs      = $("#act_obs").val();
  
  data.bit_id    = {{ $bit_id }};
  data.dir_est   = {{ $dir_est }};
  
  $.ajaxSetup({
	headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
  });

  $.ajax({
	  url: "{{ route('registrar.actividad') }}",
	  type: "POST",
	  data: data
  }).done(function(resp){alert(1);
		limpiarFormularioActividades();
		desbloquearPantalla();

		  if (resp.estado == 1){

			  mensajeTemporalRespuestas(1, resp.mensaje);
		  }else if(resp.estado == 0){
			  
			  mensajeTemporalRespuestas(0, resp.mensaje);

		  }
	}).fail(function(objeto, tipoError, errorHttp){
		desbloquearPantalla();

		manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

		return false;
	});

}

function verificarDireccion(){
	dir_est = {{ $dir_est }};
	
	if(dir_est != 0){
		
		$('#reg_id').find('option[value="'+{{$dir_reg}}+'"]').prop("selected", true);
		$('#reg_id').attr('disabled', true);

		$('#com_id').find('option[value="'+{{$dir_com}}+'"]').prop("selected", true);
		$('#com_id').attr('disabled', true);

		$('#act_cal').val({{$dir_cal}});
		$('#act_cal').attr('disabled', true);

		$('#act_num').val({{$dir_num}});
		$('#act_num').attr('disabled', true);
		

	}

}

	</script>

@endsection