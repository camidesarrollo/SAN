@extends('layouts.main')
@section('contenido')

<div class="wrapper" >
	<!-- MAIN  -->
	<main id="content">
		@if(session()->has('success'))
		    <div class="alert alert-success">
		        {{ session()->get('success') }}
		        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
				</button>
		    </div>
			
		@endif
		@if(session()->has('danger'))
		    <div class="alert alert-danger">
		        {{ session()->get('danger') }}
		        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
				</button>
		    </div>
		@endif
		<section>
            <div class="container-fluid">
              <div id="ficha-nna">
              	<div id="datos-nna" class="sticky-top">
		            <div class="m-3">
		                <h5 class="">
		                	
		                  <img class="mr-3" src="/img/ico-nna.png">  
						   <!--INICIO CZ SPRINT  57 -->  
		                 Caso: {{$caso->cas_id}} - {{ $caso->nombre }}
						  <!--FIN CZ SPRINT  57 -->
		                  <small><i class="fa fa-id-card ml-3 mr-2"></i> <?php  print_r(Helper::devuelveRutX(number_format($caso->run,0,",",".")."-".($caso->dig))); ?> </small>
		                  <small><i class="fa fa-birthday-cake ml-3 mr-2"></i>  {{ $caso->edad_ani }} Años</small>

		                 <small>
		               
		           		@if($caso->est_pau==1)
						      <!-- Fecha: 02/02/2022 Motivo: El proceso actual no permite pausar casos -->
		           		  	<!-- <button  class="btn  btn-outline-danger  btn-sm" data-toggle="modal" type="button" @if((Session::get('perfil')==config('constantes.perfil_gestor')))  data-target="#crearPausaModal" @endif>
		                 	<i class="fas fa-pause ml-2 mr-2" aria-hidden="true"></i> -->
		                @else
		                 	<button  class="btn  btn-outline-success  btn-sm" data-toggle="modal" type="button"  @if((Session::get('perfil')==config('constantes.perfil_gestor')))  data-target="#crearPausaModal" @endif   >
		                 	<i class="fa fa-play ml-2 mr-2" aria-hidden="true"></i>
		                @endif

		                 	</button>
		                 </small>
							@if($caso->est_pau != 1)

		                  <small>
		                  	<button  class="btn btn-outline-success btn-sm" data-toggle="modal" type="button"  data-target="#historialPausaModal" onclick="listadoHistorialPausaCaso({{ $caso->cas_id }});">Historial Pausas
		                  	</button>
		                  </small>
						  @endif
						  <!-- INICIO CZ SPRINT 61 -->
						 	 @if($caso->programasename==1)
								
								<small>
									<span class="badge badge-danger" style="font-size: 17px; font-weight: 500;">En Programa SENAME</span>
								</small>
								
							@endif
							<!-- FIN CZ SPRINT 61 -->
		                </h5>
		            </div>
		        </div>

              	<!-- MENU MAIN  -->
                  <ul class="nav nav-tabs sticky-top" id="menu-ficha-acciones" role="tablist">
                    <li class="nav-item">
                       <!-- INICIO CZ SPRINT 63 Casos ingresados a ONL -->
						@if($caso->cas_id != "")
							<a class="nav-link active show" href="{{ route('coordinador.caso.ficha') }}/{{ $run }}/{{$caso->cas_id}}">ANTECEDENTES</a>
						@else
							<a class="nav-link active show" href="{{ route('coordinador.caso.ficha') }}/{{ $run }}/0">ANTECEDENTES</a>
						@endif
						<!-- FIN CZ SPRINT 63 Casos ingresados a ONL -->
                    </li>

                    @if ((Session::get('perfil') == config('constantes.perfil_gestor')) || (Session::get('perfil') == config('constantes.perfil_coordinador_regional')) || (Session::get('perfil') == config('constantes.perfil_coordinador')) || (Session::get('perfil') == config('constantes.perfil_super_usuario')))
	                    <li class="nav-item">
	                       <!-- INICIO CZ SPRINT 63 Casos ingresados a ONL -->
							@if($caso->cas_id != "")
							<a class="nav-link" href="{{ route('atencion-nna') }}/{{ $run }}/{{$caso->cas_id}}">GESTIÓN DE CASOS</a>
							@else
							<a class="nav-link" href="{{ route('atencion-nna') }}/{{ $run }}/0">GESTIÓN DE CASOS</a>
							@endif
						<!-- FIN CZ SPRINT 63 Casos ingresados a ONL -->
				       </li>
			       @endif

			       	@if ((Session::get('perfil') == config('constantes.perfil_terapeuta'))  || (Session::get('perfil') == config('constantes.perfil_coordinador_regional')) || (Session::get('perfil') == config('constantes.perfil_coordinador')))
                     @if ($caso_con_terapia)
                      <li class="nav-item">
					  <!-- INICIO CZ SPRINT 63 Casos ingresados a ONL -->
                        <a class="nav-link" href="{{ route('gestion-terapia-familiar') }}/{{ $run }}/{{$caso->cas_id}}">TERAPIA FAMILIAR</a>
                      <!-- FIN CZ SPRINT 63 Casos ingresados a ONL -->
                      </li>
                      @endif
                    @endif

                    <li class="nav-item">
                      <!-- INICIO CZ SPRINT 63 Casos ingresados a ONL -->
						@if($caso->cas_id != "")
						<a class="nav-link " href="{{ route('historial-nna') }}/{{ $run }}/{{$caso->cas_id}}">HISTORIAL NNA</a>
						@else
						<a class="nav-link " href="{{ route('historial-nna') }}/{{ $run }}/0">HISTORIAL NNA</a>
						@endif
						<!-- FIN CZ SPRINT 63 Casos ingresados a ONL -->
                    </li> 
                  </ul>
                <!-- FIN MENU MAIN  -->

				<!-- SUB-MENU MAIN  -->                
				<ul class="nav nav-pills mt-0 p-1 sticky-top" id="myTab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active show" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="false" >Datos </span></a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="territorial-tab" data-toggle="tab" href="#territorial" role="tab" aria-controls="territorial" aria-selected="false">Información Territorial </span></a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link " id="contacto-tab" data-toggle="tab" href="#contacto" role="tab" aria-controls="contacto" aria-selected="true">Contactos </span></a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="beneficios-tab" data-toggle="tab" href="#beneficios" role="tab" aria-controls="beneficios" aria-selected="false">Beneficios </span></a>
                    </li>
                  </ul>
				<!-- FIN SUB-MENU MAIN  -->

                <div class="card shadow p-4 ">
                  
	                <div class="tab-content" id="myTabContent">
	                    <div class="tab-pane active show fade" id="home" role="tabpanel" aria-labelledby="home-tab">
	                    	@includeif('ficha.datos_tab')
	                    </div>
	                    <div class="tab-pane fade" id="territorial" role="tabpanel" aria-labelledby="territorial-tab">
	                    	@includeif('ficha.direccion_tab')
	                    </div>
	                    <div class="tab-pane fade" id="contacto" role="tabpanel" aria-labelledby="contacto-tab">
	                    	@includeif('ficha.contacto_tab')
	                    </div>
	                    <div class="tab-pane fade" id="beneficios" role="tabpanel" aria-labelledby="beneficios-tab">
	                        @includeif('ficha.beneficio_tab')
	                    </div>
	                </div>
                	<textarea  id="integra" >@json($rsh)</textarea>
              	</div>
			  </div>
			</div>
		</section>

	</main>
	<!-- FIN MAIN -->
</div>

@includeif('ficha.pausas.historial_pausa_modal')
@includeif('ficha.pausas.crear_pausa_modal')

@includeif('ficha.agregar_contacto_modal')
@includeif('ficha.editar_contacto_modal')


@endsection

@section('script')
	<link rel="stylesheet" href="{{ env('APP_URL') }}/css/vis.min.css" >
	<link rel="stylesheet" href="{{ env('APP_URL') }}/css/vis-network.min.css" >
	<script type="text/javascript" src="{{ env('APP_URL') }}/js/vis.min.js" type="text/javascript"></script>
	
<script type="text/javascript" >
	$(document).ready(function(){
		/*----------ACTIVA Y DESACTIVA TABS EN FICHA ANTECEDENTES----------*/
		$('[data-toggle="tooltip"]').tooltip();
		var m_antec = localStorage.getItem('m_antec');

		if(m_antec==1){
		
			$("#home").removeClass("active show");
			$("#home-tab").removeClass("active show");

			$("#territorial").addClass("active show");
			$("#territorial-tab").addClass("active show");
		
			localStorage.setItem("m_antec", 0);
		}


		if(m_antec==2){
		
			$("#home").removeClass("active show");
			$("#home-tab").removeClass("active show");

			$("#territorial").removeClass("active show");
			$("#territorial-tab").removeClass("active show");

			$("#contacto").addClass("active show");
			$("#contacto-tab").addClass("active show");
		
			localStorage.setItem("m_antec", 0);
		}

		/*----------ACTIVA Y DESACTIVA TABS EN FICHA ANTECEDENTES----------*/
		
	
		/*----------CARGA INICIAL DE JAVASCRIPT----------*/

		$("#derivarBtn").on("click", showDerivarModal);
		$(".cargarMapa").on("click", cargarMapa);
		setTimeout(function(){ ultimosBeneficiosSociales(<?php echo $caso->run ?>); }, 1000);
		setTimeout(function(){ historicoBeneficiosSociales(<?php echo $caso->run ?>); }, 1000);

	});

	//---------------------- FORMULARIO DIRECCIONES ---------------------------------
	function procesoDirecciones(opc){
		let url = "";
		let tipo = "";
		@if(!config("constantes.activar_maestro_direcciones"))
		opc = $("#opc").val();
		@endif
		if (opc == 0){
			url  = $("#url_ingreso_direccion").val();
			tipo = 'GET';
		}else if (opc == 1){
			url  = $("#url_editar_direccion").val();
			tipo = 'POST';

		}
		
		limpiarMensajesFormularioDirecciones();

		let val_form 	= validacionFormularioDirecciones();
		if (val_form == false) return false;

		bloquearPantalla();

		let data = new Object();
		data = obtenerDataformDirecciones();

		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});


		$.ajax({
			url: url,
			type: tipo,
			data: data
		}).done(function(resp){
			desbloquearPantalla();

			if (resp.estado == 1){
				mensajeTemporalRespuestas(1, resp.mensaje);

				$('#agregarDireccionModal').hide();

				// window.location.href = "/caso/"+$('#run').val();
				location.reload(true);

				// cambiarMenuAntecedentes(1);
			}else if(resp.estado == 0){
				mensajeTemporalRespuestas(0, resp.mensaje);

			}
		}).fail(function(objeto, tipoError, errorHttp){
			desbloquearPantalla();
			
			manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
		});
	}

	function levantarFormularioDirecciones(opc, id = null){
		limpiarFormularioDirecciones();
		limpiarMensajesFormularioDirecciones();
		$("#opc").val(opc);

		if (opc == 0){ //AGREGAR 
			return false;
		}	
		bloquearPantalla();

		let data = new Object();
		data.id = id;

		$.ajax({
			// url: "{ { route('/caso/datadireccion') }}/"+id,
			// url: "/caso/datadireccion/"+id,
			// "{{ route('coordinador.caso.ficha') }}/${full.run}"
			url : "{{ route('coordinador.caso.data.direccion') }}",
			type: "GET",
			data: data
		}).done(function(resp){
			desbloquearPantalla();

			if (resp.estado == 1){
				$('#id').val(resp.respuesta.dir_id);

              	$('#form_dir_call').val(resp.respuesta.dir_call);
              	$('#form_dir_num').val(resp.respuesta.dir_num);
              	$('#form_dir_dpto').val(resp.respuesta.dir_dep);
              	$('#form_dir_bloc').val(resp.respuesta.dir_block);
              	$('#form_dir_sit').val(resp.respuesta.dir_sit);
              	$('#form_dir_cas').val(resp.respuesta.dir_casa);

    		  	document.getElementById("form_dir_reg").value = resp.respuesta.reg_id;
				document.getElementById("form_dir_pro").value = resp.respuesta.prov_id;
				document.getElementById("form_dir_com").value = resp.respuesta.com_id;
				document.getElementById("form_dir_prioridad").value = resp.respuesta.dir_ord;

    		  	$('#form_dir_ref').val(resp.respuesta.dir_des);

              	$('#agregarDireccionModal').modal('show');
			}else if(resp.estado == 0){
				mensajeTemporalRespuestas(0, resp.mensaje);

			}
		}).fail(function(objeto, tipoError, errorHttp){
			desbloquearPantalla();
			
			manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
		});
	}

	function limpiarFormularioDirecciones(){
		$("#form_dir_call").val("");
		$("#form_dir_num").val("");
		$("#form_dir_dpto").val("");
		$("#form_dir_bloc").val("");
		$("#form_dir_sit").val("");
		$("#form_dir_cas").val("");
		
		document.getElementById("form_dir_reg").value = "";
		document.getElementById("form_dir_pro").value = "";
		document.getElementById("form_dir_com").value = "";
		document.getElementById("form_dir_prioridad").value = "";

		$("#form_dir_prio").val("");
		$("#form_dir_ref").val("");
	}


	// $(".edita_direccion").click(function () {
	

 //         var url = '/caso/datadireccion';
 //         var direcc_id= $(this).val();
 //          // alert(edit_id);
 //          $.get(url + '/' + direcc_id, function (data) {
 //        //      //success data
 //              // console.log(data);
 //              $('#direcc_id').val(data.dir_id);
 //              $('#edit_d_calle').val(data.dir_call);
 //              $('#edit_d_numero').val(data.dir_num);
 //              $('#edit_d_depto').val(data.dir_dep);
 //              $('#edit_d_block').val(data.dir_block);
 //              $('#edit_d_sitio').val(data.dir_sit);
 //              $('#edit_d_n_casa').val(data.dir_casa);

 //              $('select[id=edit_d_region]').val(data.reg_id);
 //              $('#edit_d_comuna').attr("disabled", false);

 //              $('select[id=edit_d_provincia]').val(data.prov_id);
 //              $('#edit_d_comuna').attr("disabled", false);

 //    		  $('select[id=edit_d_comuna]').val(data.com_id);
 //    		  $('#edit_d_comuna').attr("disabled", false);

 //    		  $('select[id=edit_d_prioridad]').val(data.dir_ord);
 //    		  $('#edit_d_referencia').val(data.dir_des);
 //    		  limpiarMensajesFormulariEditarDirecciones();
 //              $('#editarDireccionModal').modal('show');

 //          }) 
 //    });


  //   $(".edita_direccion_principal").click(function () {
	

  //        var url = '/caso/datadireccion';
  //        var direcc_id= $(this).val();
  //         // alert(edit_id);
  //         $.get(url + '/' + direcc_id, function (data) {
  //       //      //success data
  //             // console.log(data);
  //             $('#direcc_id').val(data.dir_id);
  //             $('#edit_d_calle').val(data.dir_call);
  //             $('#edit_d_numero').val(data.dir_num);
  //             $('#edit_d_depto').val(data.dir_dep);
  //             $('#edit_d_block').val(data.dir_block);
  //             $('#edit_d_sitio').val(data.dir_sit);
  //             $('#edit_d_n_casa').val(data.dir_casa);

  //             $('select[id=edit_d_region]').val(data.reg_id);
  //             $('#edit_d_region').attr("disabled", true);

  //             $('select[id=edit_d_provincia]').val(data.prov_id);
  //             $('#edit_d_provincia').attr("disabled", true);

  //   		  $('select[id=edit_d_comuna]').val(data.com_id);
  //   		  $('#edit_d_comuna').attr("disabled", true);
    		  
  //   		  $('select[id=edit_d_prioridad]').val(data.dir_ord);
  //   		  $('#edit_d_referencia').val(data.dir_des);
  //   		  limpiarMensajesFormulariEditarDirecciones();
  //             $('#editarDireccionModal').modal('show');

  //         }) 
  //   });

  //    $("#limpiaModalDireccion").click(function () {
		// limpiarMensajesFormularioDirecciones();   
  //   });

	function validacionFormularioDirecciones(){

		let respuesta 	= true;
		let calle 		= $("#form_dir_call").val();
		let numero 		= $("#form_dir_num").val();
		let region 		= document.getElementById("form_dir_reg").value;
		let comuna 		= document.getElementById("form_dir_com").value;
		let provincia   = document.getElementById("form_dir_pro").value;
		let prioridad 	= document.getElementById("form_dir_prioridad").value;

		limpiarMensajesFormularioDirecciones();

		if (typeof calle == "undefined" || calle == "" || /^\s+$/.test(calle)){
			$("#val_form_dir_call").show();
			$("#form_dir_call").addClass("is-invalid");
			respuesta = false;
		}

		if (typeof numero == "undefined" || numero == ""){
			$("#val_form_dir_num").show();
			$("#form_dir_num").addClass("is-invalid");
			respuesta = false;
		}

		if (typeof region == "undefined" || region == ""){
			$("#val_form_dir_reg").show();
			$("#form_dir_reg").addClass("is-invalid");
			respuesta = false;
		}

		if (typeof provincia == "undefined" || provincia == ""){
			$("#val_form_dir_pro").show();
			$("#form_dir_pro").addClass("is-invalid");
			respuesta = false;
		}

		if (typeof comuna == "undefined" || comuna == ""){
			$("#val_form_dir_com").show();
			$("#form_dir_com").addClass("is-invalid");
			respuesta = false;
		}

		if (typeof prioridad == "undefined" || prioridad == ""){
			$("#val_form_dir_prio").show();
			$("#form_dir_prioridad").addClass("is-invalid");
			respuesta = false;
		}

		return respuesta;
	}

	// function validacionFormularioEditarDirecciones(){

	// 	let respuesta 	= true;
	// 	let calle 		= $("#edit_d_calle").val();
	// 	let numero 		= $("#edit_d_numero").val();
	// 	let region 		= document.getElementById("edit_d_region").value;
	// 	let provincia   = document.getElementById("edit_d_provincia").value;
	// 	let comuna 		= document.getElementById("edit_d_comuna").value;
	// 	let prioridad 	= document.getElementById("edit_d_prioridad").value;

	// 	limpiarMensajesFormulariEditarDirecciones();

	// 	if (typeof calle == "undefined" || calle == "" || /^\s+$/.test(calle)){
	// 		$("#val_edit_d_calle").show();
	// 		$("#edit_d_calle").addClass("is-invalid");
	// 		respuesta = false;
	// 	}

	// 	if (typeof numero == "undefined" || numero == ""){
	// 		$("#val_edit_d_numero").show();
	// 		$("#edit_d_numero").addClass("is-invalid");
	// 		respuesta = false;
	// 	}

	// 	if (typeof region == "undefined" || region == ""){
	// 		$("#val_edit_d_region").show();
	// 		$("#edit_d_region").addClass("is-invalid");
	// 		respuesta = false;
	// 	}

	// 	if (typeof provincia == "undefined" || provincia == ""){
	// 		$("#val_edit_d_provincia").show();
	// 		$("#edit_d_provincia").addClass("is-invalid");
	// 		respuesta = false;
	// 	}

	// 	if (typeof comuna == "undefined" || comuna == ""){
	// 		$("#val_edit_d_comuna").show();
	// 		$("#edit_d_comuna").addClass("is-invalid");
	// 		respuesta = false;
	// 	}

	// 	if (typeof prioridad == "undefined" || prioridad == ""){
	// 		$("#val_edit_d_prioridad").show();
	// 		$("#edit_d_prioridad").addClass("is-invalid");
	// 		respuesta = false;
	// 	}

	// 	return respuesta;
	// }

	// function limpiarMensajesFormulariEditarDirecciones(){
	// 	$("#val_edit_d_calle").hide();
	// 	$("#val_edit_d_numero").hide();
	// 	$("#val_edit_d_region").hide();
	// 	$("#val_edit_d_provincia").hide();
	// 	$("#val_edit_d_comuna").hide();
	// 	$("#val_edit_d_prioridad").hide();

	// 	$("#edit_d_calle").removeClass("is-invalid");
	// 	$("#edit_d_numero").removeClass("is-invalid");
	// 	$("#edit_d_region").removeClass("is-invalid");
	// 	$("#edit_d_provincia").removeClass("is-invalid");
	// 	$("#edit_d_comuna").removeClass("is-invalid");
	// 	$("#edit_d_prioridad").removeClass("is-invalid");
	// }

	function obtenerDataformDirecciones(){
		let data = new Object();

		data.id = $("#id").val();
		data.dir_cod_id = $("#id_dir").val();
		data.per_id 	= $("#per_id").val();
		data.dir_call 	= $("#form_dir_call").val();
		data.dir_num 	= $("#form_dir_num").val();
		data.dir_dep 	= $("#form_dir_dpto").val();
		data.dir_des 	= $("#form_dir_ref").val();
		data.dir_sit 	= $("#form_dir_sit").val();
		data.dir_block 	= $("#form_dir_bloc").val();
		data.dir_casa 	= $("#form_dir_cas").val();
		data.com_id 	= document.getElementById("form_dir_com").value;
		data.dir_ord	= document.getElementById("form_dir_prio").value; 
		data.prioridad  = $("#form_dir_prioridad").val();
		data.nna_run	= {{ $run }};
		return data;
	}

	function limpiarMensajesFormularioDirecciones(){
		$("#val_form_dir_call").hide();
		$("#val_form_dir_num").hide();
		$("#val_form_dir_reg").hide();
		$("#val_form_dir_com").hide();
		$("#val_form_dir_pro").hide();
		$("#val_form_dir_prio").hide();

		$("#form_dir_call").removeClass("is-invalid");
		$("#form_dir_num").removeClass("is-invalid");
		$("#form_dir_reg").removeClass("is-invalid");
		$("#form_dir_com").removeClass("is-invalid");
		$("#form_dir_pro").removeClass("is-invalid");
		$("#form_dir_prioridad").removeClass("is-invalid");
	}

	function seleccionarRegionFormularioDirecciones(){
		/*let valor = $("#form_dir_reg option:selected").val();

		if (typeof valor == "undefined" || valor == ""){
			$("#form_dir_pro option").show();
			$("#form_dir_pro option[value='']").attr("selected","selected");

		}else{
			$("#form_dir_pro option").hide();
			$("#form_dir_pro option[value='']").show();
			$("#form_dir_pro option[data-reg='"+valor+"']").show();
	
		}*/

	}
	
	function seleccionarProvinciaFormularioDirecciones(){
		/*let valor = $("#form_dir_pro option:selected").val();

		if (typeof valor == "undefined" || valor == ""){
			$("#form_dir_com option").show();
			$("#form_dir_reg option").show();
			$("#form_dir_com option[value='']").attr("selected","selected");
			$("#form_dir_reg option[value='']").attr("selected","selected");

		}else{
			let reg = $("#form_dir_pro option:selected").attr("data-reg");

			seleccionarRegionFormularioDirecciones();
			seleccionarComunasFormularioDirecciones();*/
			/*$("#form_dir_reg option").hide();
			$("#form_dir_reg option[value='']").show();		
			$("#form_dir_reg option[value='"+reg+"']").show();	
			$("#form_dir_reg option[value='"+reg+"']").attr("selected","selected");


			$("#form_dir_com option").hide();
			$("#form_dir_com option[value='']").show();
			$("#form_dir_com option[data-pro='"+valor+"']").show();*/
			//$("#form_dir_com option[data-pro='"+valor+"']").attr("selected","selected");
		//}
	}

	function seleccionarComunasFormularioDirecciones(){
		/*let valor = $("#form_dir_com option:selected").val();

		if (typeof valor == "undefined" || valor == ""){
			$("#form_dir_pro option").show();
			$("#form_dir_pro option[value='']").attr("selected","selected");

		}else{
			let pro_id = $("#form_dir_com option:selected").attr("data-pro");

			seleccionarProvinciaFormularioDirecciones();

			seleccionarRegionFormularioDirecciones();*/
			/*$("#form_dir_pro option").hide();
			$("#form_dir_pro option[value='']").show();
			$("#form_dir_pro option[value='"+pro_id+"']").show();
			$("#form_dir_pro option[value='"+pro_id+"']").attr("selected","selected");*/
		//}
	}
	//---------------------- FORMULARIO DIRECCIONES ---------------------------------

	function showDerivarModal(){

		let url = $(this).data('derivar-href');

		showModalzAjax(url,'','','');
	}

	function derivarOk(){

		$('#zModal').modal('hide');
	}

	function cargarMapa(){

		let direccion = $(this).data('direccion');
		let src = $(this).data('src');

		$(".ccolor").css("background-color", "#007bff");
		$(this).css("background-color", "#A9A9A9");

		$('#iframeMapa').attr('src',src+'&dirGeoCod='+direccion);

	}

	function cargarPaginaMapa(){

		var posi_arr = document.getElementsByName('mapa_boton[]');

		var posi_ar=posi_arr[0];

		let direccion = posi_ar.dataset['direccion'];
		let src = posi_ar.dataset['src'];
		$('#iframeMapa').attr('src',src+'&dirGeoCod='+direccion);
	}

	cargarPaginaMapa();

	$("#vis_panel").hide();
	$("#integra").hide();
	var rutCaso = @json($run);
	var stringJs = $("#integra").val();
	var rsh = JSON.parse(stringJs);

	//console.log(rsh.integrantes);
	if(typeof rsh.integrantes !== 'undefined'){
		var filtroColorFondo = "#ffc107";
		var filtroColorLetra = "#000000";

		var integrantes = rsh.integrantes;
		var network = null;

		function colorNodoFuente(codigo){

			let color = {}
			switch (codigo) {
				case "elcaso":
					//color.node="#be7cb5";
					color.node = "#F8D1BE";
					color.label = "#000000";
					color.border = "#FF0000";
				break;

				default:
					//color.node="#5565af";
					color.node  = "#F5F5F5";
					color.label = "#000000";
					color.border = "#018989";
			}

			return color;
		}

		function _calculateAge(birthday) { // birthday is a date
			var ageDifMs = Date.now() - birthday.getTime();
			var ageDate = new Date(ageDifMs); // miliseconds from epoch
			return Math.abs(ageDate.getUTCFullYear() - 1970);
		}

		draw();
		function destroy() {

			if (network != null) {
				network.destroy();
				network = null;
			}
		}

		function draw(filtro = 1){
			destroy();
			let nodesArray = [];
			let idJefeHogar = 0;
			let container = document.getElementById('animation_container');

			var options = {
				layout:{
					randomSeed: 966922
				},
				nodes:{
					shape: 'box',
					color: {
						//border: "#9e9e9e",
						//background: "#fced16",
						highlight: {
							//border: "#e52120",
							border: "grey",
							background: "#ffcd14"
						},
						hover: {
							//border: "#e52120",
							//background: "#ffcd14"
							border: "grey",
							background: "#a7d0d0"
						}
					},
					//height: 200,
					heightConstraint: 50,
					borderWidth: 3,
					shadow:true,
					//widthConstraint: 150
					widthConstraint: {
						minimum: 150,
						maximum: 150
					}
				},
				interaction:{
					hover:true,
					navigationButtons:true,
					keyboard:true
				},
				edges: {
					smooth: {
						"type": "curvedCW",
						"forceDirection": "none",
						"roundness": 0.1
					},
					color: {
					   "color": "grey"
					},
					width: 3,
					shadow:true
				},
				physics: {
					repulsion: {
						centralGravity: 1,
						//springLength: 170,
						nodeDistance: 150,
						damping: 0.2
					},
					minVelocity: 0.74,
					solver: "repulsion"
				}
			};

			for (var i = 0;i<integrantes.length;i++){

				if(integrantes[i]['Jefe de Hogar']==1){
					idJefeHogar = i;
				}

				let rut = "";
				if(integrantes[i]['Run'].length>0){
					rut = integrantes[i]['Run']+'-'+calculateDV(integrantes[i]['Run']);
				}else{
					rut = "-Error en Rut";
				}

				let parentescoNombre = integrantes[i]['Parentesco'].replace(/(\([0-9]*\)\s[0-9]*\.\s)/,'');
				let coincidenciasParentesco = integrantes[i]['Parentesco'].match(/\(([0-9]*)\)/);

				if (null != coincidenciasParentesco) {
					var parentescoCodigo = coincidenciasParentesco[1];
				}

				let sexoNombre = integrantes[i]['Sexo'].replace(/\([0-9]+\)\s/,'');

				// Colores de los Nodos y las fuentes
				if(rutCaso==integrantes[i]['Run']){
					parentescoCodigo ="elcaso";
					var nodeIdCaso = i;
				}

				var color;
				if(filtro==1){
					color = colorNodoFuente(parentescoCodigo);
				}else{
					color = {node:'#ffffff',label:'#000000'}
				}


				if(integrantes[i]['Fecha Nacimiento'].length>0){
					let dob = integrantes[i]['Fecha Nacimiento'];
					let year = Number(dob.substr(0, 4));
					let month = Number(dob.substr(4, 2)) - 1;
					let day = Number(dob.substr(6, 2));
					let d = new Date(year,month,day);
					var fechaNacimiento = day+"-"+(month+1)+"-"+year;
					var edad = _calculateAge(d);
				}
				var label = "";
				if(integrantes[i]['Jefe de Hogar']==1){
					label = '<b>'+ parentescoNombre + '</b> \n\n ' + integrantes[i]['Nombres'] + '';
				}else{
					label = '<b>'+ parentescoNombre + '</b> \n\n ' + integrantes[i]['Nombres'] +'';
				}

				//LABEL ANTERIOR
				//label = parentescoNombre + ' \n\n ' + rut

				let title =  integrantes[i]['Nombres']+ ' ' +integrantes[i]['Apellido Paterno'] + ' ' + integrantes[i]['Apellido Materno'];

				nodesArray.push({
					id		: i,
					label	:	label,
					title 	:	ponerMayuscula(title),
					font 	:	{multi:true, color:color.label},
					//color	:	color.node,
					color	:   {background: color.node, border: color.border},
					rut		:	rut,
					nombres	:	integrantes[i]['Nombres'],
					appat	:	integrantes[i]['Apellido Paterno'],
					apmat	:	integrantes[i]['Apellido Materno'],
					nacimiento	:	fechaNacimiento,
					edad	:	edad,
					sexo	:	ponerMayuscula(sexoNombre),
					parentesco	:	parentescoNombre,
					jefe	:	integrantes[i]['Jefe de Hogar']
				});

			} // fin For  de integrantes

			// Creacion desde cero de Nodes y Edges
			let nodesDataSet = new vis.DataSet(nodesArray);
			let filtroNodes = nodesDataSet;
			let edgesArray = [];
			let edgesObjeto= {};

			$.each(nodesArray, function(i, val) {
				if(idJefeHogar!=val.id){
					edgesArray.push({
						from	:	idJefeHogar,
						to	:	val.id,
						arrows:"to"
					});
				}
			});

			edgesObjeto.datos = edgesArray;
			let edgesDataSet = new vis.DataSet(edgesObjeto.datos);


			//Fin de creacion de nodes y edges
			switch (filtro) {
				case 1:
					filtroNodes = nodesDataSet;
					break;
				case 2:
					nodesDataSet.forEach(function(item){
						if(item.sexo=="Mujer" ){
							nodesDataSet.update({id:item.id,color:filtroColorFondo,font:{multi:true,color:filtroColorLetra}});
						}
					});
					break;
				case 3:

					nodesDataSet.forEach(function(item){
						if(item.sexo=="Hombre" ){
							nodesDataSet.update({id:item.id,color:filtroColorFondo,font:{multi:true,color:filtroColorLetra}});
						}
					});
					break;
			}

			filtroNodes = nodesDataSet;
			let data = {
				nodes: filtroNodes,
				edges: edgesDataSet
			};


			network = new vis.Network(container, data, options);



			network.on("hoverNode", function (params) {
				if(typeof params.node!== 'undefined'){
					$("#vis_panel").show();
					var nodoClickeado =  nodesDataSet.get(params.node);
					$("#vis_nombre").text( ponerMayuscula(nodoClickeado.nombres+" "+nodoClickeado.appat+" "+nodoClickeado.apmat));
					$("#vis_rut").text(nodoClickeado.rut);
					$("#vis_sexo").text(nodoClickeado.sexo);
					// $("#vis_nacimiento").text(nodoClickeado.nacimiento);
					$("#vis_edad").text(nodoClickeado.edad);
				}else{
					$("#vis_panel").find("dd").text("");
					$("#vis_panel").hide();
				}
			});

			/*if(nodeIdCaso!="undefined"){
				network.on("afterDrawing", function (ctx) {
					var nodeId = nodeIdCaso;
					var nodePosition = network.getPositions([nodeId]);

					ctx.strokeStyle = 'white';
					ctx.lineWidth = 1;
					ctx.font = "bold 35px Arial";
					ctx.fillText("CASO", nodePosition[nodeId].x-45, nodePosition[nodeId].y-40);
					ctx.strokeText("CASO", nodePosition[nodeId].x-45, nodePosition[nodeId].y-40);

				});
			}*/




		}

		$("#filtroNulo").on("click",function(){
			draw();
		});
		$("#filtroMujer").on("click",function(){
			draw(2);
		});
		$("#filtroHombre").on("click",function(){
			draw(3);
		});
	}else{

		$("#animation_container").append('<br><br><br><br><div class="text-center" >'+rsh.mensaje+'</div>')


	}


	$(".edita_contacto").click(function () {
	

        var url = '/caso/datacontacto';
        var contact_id= $(this).val();
        // alert(edit_id);
         $.get(url + '/' + contact_id, function (data) {
             //success data
             // console.log(data);
             $('#contact_id').val(data.con_id);
             $('#edit_c_nombres').val(data.con_nom);
             $('#edit_c_paterno').val(data.con_pat);
             $('#edit_c_materno').val(data.con_mat);
             $('#edit_c_telefono').val(data.con_tlf);
             $('select[id=edit_c_parentesco]').val(data.con_par);
             $('select[id=edit_c_prioridad]').val(data.con_con);
             limpiarMensajesFormularioEditarContacto();
             $('#editarContactoModal').modal('show');

         }) 
    });

    function validacionFormularioContacto(){
    	
    	let respuesta 	= true;
		let fuente 		= $("#form_contac_fuente").val();
		let nombre 	= $("#form_contac_nombrecomp").val();
		//let materno     = $("#form_contac_materno").val();
		let telefono    = $("#form_contac_telefono").val();
		let comuna 	= document.getElementById("form_contac_comuna").value;

		limpiarMensajesFormularioContacto();

		if (typeof fuente == "undefined" || fuente == "" || /^\s+$/.test(fuente)){
			$("#val_form_contac_fuente").show();
			$("#form_contac_fuente").addClass("is-invalid");
			respuesta = false;
		}

		if (typeof nombre == "undefined" || nombre == "" || /^\s+$/.test(nombre)){
			$("#val_form_contac_nombrecomp").show();
			$("#form_contac_nombrecomp").addClass("is-invalid");
			respuesta = false;
		}

		/*if (typeof materno == "undefined" || materno == "" || /^\s+$/.test(materno)){
			$("#val_form_contac_materno").show();
			$("#form_contac_materno").addClass("is-invalid");
			respuesta = false;
		}*/

		if (typeof telefono == "undefined" || telefono == ""){
			$("#val_form_contac_telefono").show();
			$("#form_contac_telefono").addClass("is-invalid");
			respuesta = false;
		}

		if (typeof comuna == "undefined" || comuna == ""){
			$("#val_form_contac_comuna").show();
			$("#form_contac_comuna").addClass("is-invalid");
			respuesta = false;
		}

		return respuesta;
    }

    function limpiarMensajesFormularioContacto(){

		$("#val_form_contac_fuente").hide();
		$("#val_form_contac_nombrecomp").hide();
		//$("#val_form_contac_materno").hide();
		$("#val_form_contac_telefono").hide();
		$("#val_form_contac_comuna").hide();


		$("#form_contac_fuente").removeClass("is-invalid");
		$("#form_contac_nombrecomp").removeClass("is-invalid");
		//$("#form_contac_materno").removeClass("is-invalid");
		$("#form_contac_telefono").removeClass("is-invalid");
		$("#form_contac_comuna").removeClass("is-invalid");
	}

	function validacionFormularioEditarContacto(){
    	
    	let respuesta 	= true;
		let nombre 		= $("#edit_c_nombres").val();
		let paterno 	= $("#edit_c_paterno").val();
		let materno     = $("#edit_c_materno").val();
		let telefono    = $("#edit_c_telefono").val();
		let prioridad 	= document.getElementById("edit_c_prioridad").value;

		limpiarMensajesFormularioEditarContacto();

		if (typeof nombre == "undefined" || nombre == "" || /^\s+$/.test(nombre)){
			$("#val_edit_c_nombres").show();
			$("#edit_c_nombres").addClass("is-invalid");
			respuesta = false;
		}

		if (typeof paterno == "undefined" || paterno == "" || /^\s+$/.test(paterno)){
			$("#val_edit_c_paterno").show();
			$("#edit_c_paterno").addClass("is-invalid");
			respuesta = false;
		}

		if (typeof materno == "undefined" || materno == "" || /^\s+$/.test(materno)){
			$("#val_edit_c_materno").show();
			$("#edit_c_materno").addClass("is-invalid");
			respuesta = false;
		}

		if (typeof telefono == "undefined" || telefono == ""){
			$("#val_edit_c_telefono").show();
			$("#edit_c_telefono").addClass("is-invalid");
			respuesta = false;
		}

		if (typeof prioridad == "undefined" || prioridad == ""){
			$("#val_edit_c_prioridad").show();
			$("#edit_c_prioridad").addClass("is-invalid");
			respuesta = false;
		}

		return respuesta;
    }

    function limpiarMensajesFormularioEditarContacto(){

		$("#val_edit_c_nombres").hide();
		$("#val_edit_c_paterno").hide();
		$("#val_edit_c_materno").hide();
		$("#val_edit_c_telefono").hide();
		$("#val_edit_c_prioridad").hide();


		$("#edit_c_nombres").removeClass("is-invalid");
		$("#edit_c_paterno").removeClass("is-invalid");
		$("#edit_c_materno").removeClass("is-invalid");
		$("#edit_c_telefono").removeClass("is-invalid");
		$("#edit_c_prioridad").removeClass("is-invalid");
	}

	 $("#limpiaModalContacto").click(function () {
		limpiarMensajesFormularioContacto(); limpiaModalContacto  
    });

	function wgFormularioDirecciones(opc){
		
		generarTokenSeguridad();
		let run             = "{{ $run }}";
		let url             = "{{ config('constantes.url_registrar_direccion') }}";
		let ID_fuente       = "{{ config('constantes.ID_sistema_fuente') }}";
		let ID_negocio      = "{{ config('constantes.ID_negocio') }}";
		let ID_transaccion  = generarIDTransaccion(run);
		let token           = $("#token").val();
		
		if(typeof token === "undefined") return false;

		let ruta = url+token+'/'+ID_fuente+'/'+run+'/'+ID_transaccion+'/'+ID_negocio+'/null/null/null/null';
			
		$("#iframe_direcciones").attr('src', ruta);

		$("#ModalIframe").modal({show: true, backdrop: 'static', keyboard: false});
		validarRegistroDireccion(opc, ID_transaccion);
	}

	function wgFormularioDireccionesEditar(opc, ID_direc, id){
		
		generarTokenSeguridad();
		let run        		= "{{ $run }}";
		let url             = "{{ config('constantes.url_registrar_direccion') }}editar/";
		let ID_fuente       = "{{ config('constantes.ID_sistema_fuente') }}";
		let ID_negocio      = "{{ config('constantes.ID_negocio') }}";
		let ID_transaccion  = generarIDTransaccion(run);
		let token           = $("#token").val();
		
		if(typeof token === "undefined") return false;
		
		let ruta = url+token+'/'+ID_fuente+'/'+ID_direc+'/'+ID_transaccion+'/'+ID_negocio;
			
		$("#iframe_direcciones").attr('src', ruta);

		$("#ModalIframe").modal({show: true, backdrop: 'static', keyboard: false});
		$("#id").val(id);
		validarRegistroDireccion(opc, ID_transaccion);
	}

	function generarIDTransaccion(run){
		// ID SISTEMA FUENTE
		let ID_fuente = "{{ config('constantes.ID_sistema_fuente') }}";

		// MARCA TEMPORAL
		let timestamp = new Date();
		timestamp = Math.floor(timestamp.getTime()/1000)

		// NUMERO ALEATORIO
		let random = Math.floor(Math.random() * 90000);
		random = random + 10000;

		return respuesta = ID_fuente+run+timestamp+random;
	}

	function generarTokenSeguridad(){

		$.ajax({
			type: "GET",
			url: "{{route('generar.token.seguridad')}}",
			async: false,
		}).done(function(resp){
			
			$("#token").val(resp.token);			

		}).fail(function(objeto, tipoError, errorHttp){

			manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
			return false;
		});

	}

	function validarRegistroDireccion(opc, ID_transaccion){
		let data = new Object();
		data.ID_transaccion = ID_transaccion;

		$.ajax({
		"url" : "{{ route('validar.guardar.direccion') }}",
		"type": "GET",
		"data": data
		}).done(function(response){
		
		if (response.status == 1){
				$("#id_dir").val(response.query[0].id_dir);
				$("#form_dir_reg").val(response.query[0].c_region);
				$("#form_dir_com").val(response.query[0].comunaine_txt);
				$("#form_dir_call").val(response.query[0].n_calle);
				$("#form_dir_num").val(response.query[0].numdomicilio);
				$("#form_dir_dpto").val(response.query[0].dpto);
				$("#form_dir_bloc").val(response.query[0].block);
				$("#form_dir_cas").val(response.query[0].casa);
				$("#form_dir_sit").val(response.query[0].sitio);
				$("#form_dir_ref").val(response.query[0].referencia);
				
				procesoDirecciones(opc);
			}else if (response.status != 1 && ($("#ModalIframe").data('bs.modal') || {})._isShown){
			setTimeout(function(){
				validarRegistroDireccion(opc, ID_transaccion);
				}, 3000);

			}
		}).fail(function(objeto, tipoError, errorHttp){
		if (($("#ModalIframe").data('bs.modal') || {})._isShown){
			setTimeout(function(){
			validarRegistroDireccion(opc, ID_transaccion);
			}, 3000);
		}
		});
	}
</script>
@endsection