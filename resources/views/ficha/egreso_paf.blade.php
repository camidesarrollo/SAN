<style>
.nav-pills .seg-link.active {
    background-color: #e6f3fd !important;
    color: #1cc88a;
    border-bottom: 3px solid #1cc88a;   
    /* height: 160px; */
	padding-top:30px;
}
</style>


<div class="container">
	<div class="row">
		<div class="col">
			<h5 class="modal-title" id="title_ejecucion" data-id-est="4">
				<i class="fas fa-archive"></i> <b> En Seguimiento</b>
			</h5>
		</div>
		<!-- INICIO CZ SPRINT 57 -->
		@if ($modo_visualizacion == 'edicion')
		<div class="col text-right">
					 <button type="button" class="btn btn-danger btn-sm btnRechEst" data-dismiss="modal"
							 @if (config('constantes.rechazado_por_familiares') == $estado_actual_caso || config('constantes.rechazado_por_gestor') == $estado_actual_caso ||
							 config('constantes.egreso_paf') == $estado_actual_caso

									|| config('constantes.familia_intervenida_sename') == $estado_actual_caso

							|| config('constantes.nna_vulneracion_derechos') == $estado_actual_caso
									|| config('constantes.nna presenta_medida_proteccion') == $estado_actual_caso
									|| config('constantes.familia_no_aplica') == $estado_actual_caso
									|| config('constantes.familia_inubicable') == $estado_actual_caso
									|| config('constantes.familia_rechaza_oln') == $estado_actual_caso
									|| config('constantes.familia_renuncia_oln') == $estado_actual_caso  
									|| config('constantes.direccion_incorrecta') == $estado_actual_caso 
									|| config('constantes.direccion_desactualizada') == $estado_actual_caso
							 )
							 disabled @else onclick="comentarioEstado({{ $caso_id }});" @endif>
							 Desestimar Caso
					 </button>
				 </div>


		@endif
		<!-- FIN CZ SPRINT 57 -->
	</div>
</div>

<hr>

<!-- Mensajes de Alertas -->
	<div style="display:none;" class="alert alert-success alert-dismissible fade show" id="alert-exi" role="alert">
	Registro Guardado Exitosamente.
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">×</span>
		</button>
	</div>

	<div style="display:none;" class="alert alert-danger alert-dismissible fade show" id="alert-err" role="alert">
	Error al momento de guardar el registro. Por favor intente nuevamente.
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">×</span>
		</button>
	</div>
<!-- Fin Mensajes de Alertas -->

<!-- SEGUIMIENTO PAF -->

<div class="card colapsable shadow-sm">
    <a class="btn text-left p-0" id="btn_beneficios_grupo_familiar" data-toggle="collapse" data-target="#resumen_reg_seg_paf" aria-expanded="false" aria-controls="resumen_reg_seg_paf" onclick="">
		<div class="card-header p-3">
			<h5 class="mb-0">
				<button type="button" class="btn btn-info"  data-toggle="tooltip" data-placement="top" title="" data-original-title="Beneficios otorgados a cada miembro del grupo familiar"><i class="fa fa-info"></i>
				</button>&nbsp;&nbsp;Resumen Registro Seguimiento PAF
			</h5>
		</div>
	</a>
	
	<div class="collapse" id="resumen_reg_seg_paf"><!--collapse show abierto default aria-expanded="true"-->
		<div class="card-body">

			<div class="row">
    			<div class="col-md-12 col-lg-12">
            		<div class="card shadow-sm">
		                <div class="card-body" style="width:100%;" >
		                @includeif('ficha.listar_seguimiento_paf')
		                </div>
            		</div>
            	</div>
            </div>

		</div>
	</div>

	
</div>


@if ($modo_visualizacion == 'edicion')
	<div class="card colapsable shadow-sm">

		<a class="btn text-left p-0" id="btn_registro_seguimiento" data-toggle="collapse" data-target="#ficha_reg_seg_paf" aria-expanded="false" aria-controls="ficha_reg_seg_paf" onclick="levantarFichaRegistroSeguimiento({{ $caso_id }});" @if($numero_reporte>4) disabled @endif>
			<div class="card-header p-3">
				<h5 class="mb-0">
					<button type="button" class="btn btn-info"  data-toggle="tooltip" data-placement="top" title="" data-original-title="Ficha Registro Seguimiento PAF"><i class="fa fa-info"></i>
					</button>&nbsp;&nbsp;Ficha Registro Seguimiento PAF
				</h5>
			</div>
		</a>

		<div class="collapse" id="ficha_reg_seg_paf">
			<div class="card-body">

				<div class="row">
	    			<div class="col-md-12 col-lg-12">
	            		<div class="card shadow-sm">
			                <div class="card-body">
			                @includeif('ficha.ficha_registro_seguimiento')
			                </div>
	            		</div>
	            	</div>
	            </div>

			</div>
		</div>
	<!-- @ endif -->

	</div>
@endif

<!-- FIN SEGUIMIENTO PAF -->


<!-- INCLUDE -->
 @includeif('ficha.ficha_registro_seguimiento_modal')
@includeif('ficha.ncfas_modal_imprimir')
<!-- FIN INCLUDE -->

<!--  BITACORA ESTADO ACTUAL  -->
<div class="card shadow-sm alert-info">
	<div class="card-header p-3">
		<h5 class="mb-0"><i class="fa fa-pencil"></i> Bitácora</h5>
   	</div>
   	<div class="card-body">
	  	<label for="bitacora_estado_diagnostico" style="font-weight: 800;" class="">Estado actual del caso:</label>
  	
  		@if ($modo_visualizacion == 'visualizacion')
	  		<div class="text-success" style="word-break: break-all;">
				<label class="font-weight-bold">{{ $bitacoras_estados[4] }}</label>
			</div>
		@elseif ($modo_visualizacion == 'edicion')
			<textarea maxlength="2000" onkeypress='return caracteres_especiales(event)'class="form-control txtAreEtapa" name="bit-etapa-seguimiento" id="bitacora_estado_seguimiento" rows="3" onBlur="cambioEstadoCaso('b7', {{ $caso_id }}, $(this).val());" @if (config('constantes.en_seguimiento_paf')  != $estado_actual_caso) disabled @endif>{{ $bitacoras_estados[4] }}</textarea>
		@endif

  </div>
</div>

<!--  FIN BITACORA ESTADO ACTUAL  -->

@if ($modo_visualizacion == 'edicion' && session()->all()['perfil'] == config("constantes.perfil_gestor"))
	<div class="text-center">
		<button type="button" id="btn-etapa-egreso" class="btn btn-success btnEtapa" 	@if($estado_actual_caso>6) disabled @endif onclick="siguienteEtapa({{config('constantes.egreso_paf')}}, {{ $caso_id }});"> <strong>Egreso OLN</strong>
		</button>
	</div>
@endif

<script type="text/javascript">
	var dataSegRep =  new Array();
	var dataRegistroSeguimiento = new Array();
	
	$( document ).ready(function() {
		// cargarProgAleTarPen();
		cargarReporteGestion();
	});


	function limpiarModalRis(){

		$("#fecha_reporte_tar").removeClass("is-invalid");
		$("#val_fecha_reporte_tar").hide();

		$("#frm_campo_tra_avance").removeClass("is-invalid");
   	   	$("#val_av_rp_tar_seg").hide();

   	   	$("#frm_campo_tra_descripcion").removeClass("is-invalid");
   	   	$("#val_des_ac_tar_pen").hide();

   	   	$("#frm_campo_tra_nuevas_acciones").removeClass("is-invalid");
   	   	$("#val_nuev_ac_tar_pe").hide();

   	   	$("#frm_campo_tra_modalidad_seguimiento").removeClass("is-invalid");
   	   	$("#val_mod_rp_tar_seg").hide();

		$("#frm_campo_pro_avance").removeClass("is-invalid");
   	   	$("#val_av_rp_der_seg").hide();

		$("#frm_campo_pro_razon").removeClass("is-invalid");
   	   	$("#val_raz_derv_pen").hide();	

		$("#frm_campo_pro_descripcion").removeClass("is-invalid");
   	   	$("#val_des_derv_pen").hide();	
   	   	
   	   	$("#frm_campo_dev_ter").removeClass("is-invalid");
   	   	$("#val_frm_campo_dev_ter").hide();

		$("#frm_campo_pro_nuevas_acciones").removeClass("is-invalid");
   	   	$("#val_n_derv_pen").hide();

 		$("#frm_campo_pro_modalidad_seguimiento").removeClass("is-invalid");
   	   	$("#val_mod_rp_derv_seg").hide();

   	   	$("#frm_campo_pro_ter").removeClass("is-invalid");
   	   	$("#val_frm_campo_pro_ter").hide();

		$("#frm_campo_ale_ter").removeClass("is-invalid");
		$("#val_frm_campo_ale_ter").hide();

		$("#frm_campo_ale_pasos_a_seguir").removeClass("is-invalid");
		$("#val_frm_campo_ale_pasos_a_seguir").hide();

		$("#frm_campo_pasos_a_seguir").removeClass("is-invalid");
   	   	$("#val_pas_seg").hide();

   	   	$("#frm_campo_tar_ter").removeClass("is-invalid");
   	   	$("#val_frm_campo_tar_ter").hide();

		$("#fecha_reporte_dev").removeClass("is-invalid");
		$("#val_fecha_reporte_dev").hide();

	}

    function levantarFichaRegistroSeguimiento(cas_id){
    	let data = new Object();

    	data.cas_id = cas_id;

    	$.ajax({
			url: "{{ route('ficha.registro.seguimiento') }}",
			type: "GET",
			data: data
		}).done(function(resp){
			if (resp.estado == 1){
				dataRegistroSeguimiento = resp.respuesta;
				
				listarTareasPendientes();
				listarProgramasPendientes();
				listarAlertasPendientes();

			}else if (resp.estado == 0){
				alert(resp.mensaje);

			}
		}).fail(function(obj){
			let mensaje = "Hubo un error al momento de buscar la información para desplegar el reporte. Por favor intente nuevamente.";

			console.log(obj);
			alert(mensaje);
		});
    }

	function validarInformacion(){

		let respuesta = true;

		let fecha_ingreso_reporte = $("#fecha_ingreso_reporte").val();

		if (!validarFormatoFecha(fecha_ingreso_reporte) || !existeFecha(fecha_ingreso_reporte)){
			alert("Debe registrar una Fecha de Ingreso válida para el Reporte.");

    		tabFrsPaf(7); 
    		$("#fecha_ingreso_reporte").addClass("is-invalid");
			respuesta = false;

		}else{
			$("#fecha_ingreso_reporte").removeClass("is-invalid");

		}

		
		let modalidad_seguimiento = $("#frm_modalidad_seguimiento").val();

		if (modalidad_seguimiento == "" || typeof modalidad_seguimiento === "undefined"){
			respuesta = false;
			tabFrsPaf(7);
			$("#val_frm_modalidad_seguimiento").show();
			$("#frm_modalidad_seguimiento").addClass("is-invalid");
        }else{
			$("#val_frm_modalidad_seguimiento").hide();
			$("#frm_modalidad_seguimiento").removeClass("is-invalid");
		}		

		return respuesta;

	}

    function guardarInformacionReporte(){
    	let data = new Object();
    	
		var valfinf = validarInformacion();
		if(valfinf==false) return false;
    	
    	var valfpas = validarPasosAseguir();

    	if(valfpas==false) return false;
		dataRegistroSeguimiento.programas = '';
		dataRegistroSeguimiento.alertas = '';
    	dataRegistroSeguimiento["informacion"][0].fecha_reporte = $("#fecha_ingreso_reporte").val();
		dataRegistroSeguimiento["informacion"][0].modalidad_seguimiento = $("#frm_modalidad_seguimiento").val();
    	dataRegistroSeguimiento["informacion"][0].comentario = $("#frm_campo_pasos_a_seguir").val();
    	data.data = dataRegistroSeguimiento;
    	
    	console.log(data);
    	$.ajax({
			url: "{{ route('ingreso.rpt.seg') }}",
			type: "GET",
			data: data
		}).done(function(resp){
			if (resp.estado == 1){
				let mensaje = resp.mensaje;

				alert(mensaje);

				location.reload();
			}else if (resp.estado == 0){
				let mensaje = resp.mensaje;

				alert(mensaje);
			}
		}).fail(function(objeto, tipoError, errorHttp){
			manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
			
			return false;
		});
    }

    function validarRegDataTar(){

    	let val = true;

    	let tareas = dataRegistroSeguimiento.tareas;
        tareas.forEach(function(value, index){

        	if (value.tar_descripcion == "") val = false;
        	if (value.avances == "") val = false;
        	if (value.descripcion == "") val = false;
        	// if (value.nuevas_acciones == "") val = false;
        	
        });

    return val;

    }

    function validarRegDataDer(){

    	let val = true;

        let programas = dataRegistroSeguimiento.programas;
        programas.forEach(function(value, index){
       
        	if (value.avances == "") val = false;
        	if (value.descripcion == "") val = false;
        	// if (value.razon == "") val = false;

        });

    return val;

    }

    function validarRegDataAle(){

    	let val = true;

        let programas = dataRegistroSeguimiento.alertas;
       	programas.forEach(function(value, index){

       		// if (value.nuevas_acciones == "") val = false;
        	if (value.finalizar_pendiente == "") val = false;

        });

    	return val;

    }

     function validarPasosAseguir(){

     	limpiarModalRis();

     	let frm_campo_pasos_a_seguir = $("#frm_campo_pasos_a_seguir").val();

			if(frm_campo_pasos_a_seguir=="") {
					//alert("Debe ingresar los pasos a seguir");
			 $("#frm_campo_pasos_a_seguir").addClass("is-invalid");
			 $("#val_pas_seg").show();

				return false;
			}

			 var cant=frm_campo_pasos_a_seguir.length;

			if(cant<3) {
				
				alert("Debe ingresar los pasos a seguir al menos 3 caracteres");

				$("#frm_campo_pasos_a_seguir").addClass("is-invalid");
				
				return false;
			}

     }


    //-------------------- TAREAS ----------------------
    function listarTareasPendientes(){
    	let listarDataTareas = $('#tabla_acciones_tareas').DataTable();
        listarDataTareas.clear().destroy();

        let html = "";
        let tareas = dataRegistroSeguimiento.tareas;
        tareas.forEach(function(value, index){

        	// index = index +1;
        	let numeracion = index +1; 
        	let nombre = "Sin información";
        	if (value.tar_descripcion.length > 0 && value.tar_descripcion != "") nombre = value.tar_descripcion;

        	let avance = "Sin información";
        	if (value.avances.length > 0 && value.avances != ""){
        		if (value.avances == 1){
        			avance = "Sí";
        		}else if(value.avances == 0){
        			avance = "No";
        		}
        	}

        	let descripcion = "Sin información";
        	if (value.descripcion.length > 0 && value.descripcion != "") descripcion = value.descripcion;

        	let nuevas_acciones = "Sin información";
        	if (value.nuevas_acciones.length > 0 && value.nuevas_acciones != "") nuevas_acciones = value.nuevas_acciones;

        	let modalidad_seguimiento = "Sin información";
        	if (value.modalidad_seguimiento.length > 0 && value.modalidad_seguimiento != "") 
			{
				if(value.modalidad_seguimiento==0)modalidad_seguimiento = "Revisión de plataforma";
				if(value.modalidad_seguimiento==1)modalidad_seguimiento = "Revisión de plataforma y llamados telefónicos";
				if(value.modalidad_seguimiento==2)modalidad_seguimiento = "Visita al domicilio";
			}
        		
        	let fecha_ingreso = "Sin información";
            if (value.fecha_ingreso.length > 0 && value.fecha_ingreso != "") 
        		fecha_ingreso = value.fecha_ingreso;

           	let finalizar_pendiente = "Sin información";
        	if (value.finalizar_pendiente.length > 0 && value.finalizar_pendiente != ""){
        			
        		if(value.finalizar_pendiente==1){ 
        			finalizar_pendiente = "Sí"; 
        			nuevas_acciones="Sin información";
				}

				if(value.finalizar_pendiente==0) finalizar_pendiente = "No";
        	}

            html += '<tr>';
            html += '<td>'+numeracion+'</td>';
            html += '<td>'+nombre+'</td>';
            html += '<td>'+modalidad_seguimiento+'</td>';
            html += '<td>'+fecha_ingreso+'</td>';
            html += '<td>'+avance+'</td>';
            html += '<td>'+descripcion+'</td>';
            html += '<td>'+finalizar_pendiente+'</td>';
            html += '<td>'+nuevas_acciones+'</td>';
            html += '<td><button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#formComponentes" onclick="desplegarFormularioTareas('+index+');">Editar <span class="oi oi-pencil"></span></button></td>';
            html += '</tr>';
        });

        $("#tabla_acciones_tareas > tbody").html(html);

        $('#tabla_acciones_tareas').DataTable({
            ordering:   false,
            paging:     true,
            searching:  false,
            info:       true,
            columnDefs: [
                {"className": "dt-center", "targets": [0]},
                {"className": "dt-center", "targets": [1]},
                {"className": "dt-left", "targets": [2]},
                {"className": "dt-left", "targets": [3]},
                {"className": "dt-left", "targets": [4]},
                {"className": "dt-left", "targets": [5]},
                {"className": "dt-left", "targets": [6]},
                {"className": "dt-left", "targets": [7]},
                {"className": "dt-left", "targets": [8]}],
            language: { "url": "{{ route('index') }}/js/dataTables.spanish.json"}
        });

        $('#tabla_acciones_tareas').find("thead th").removeClass("sorting_asc");
    }

    function limpiarFormularioTareas(){
    	$("#frm_campo_tra_tarea").val("");
    	$("#frm_campo_tra_descripcion").val("");
    	$("#frm_campo_tra_nuevas_acciones").val("");

    	$("#fecha_reporte_tar").val("");

    	document.getElementById("frm_campo_tra_avance").value = "";
    	document.getElementById("frm_campo_tra_modalidad_seguimiento").value = "";

    	$("#guardar_formulario_tareas").removeAttr("onclick");
    }

    function desplegarFormularioTareas(indice){
    	limpiarFormularioTareas();

    	// $("#exampleModal").modal();

    	$("#frm_campo_tra_tarea").val(dataRegistroSeguimiento["tareas"][indice].tar_descripcion);

    	$("#frm_campo_tra_nuevas_acciones").val(dataRegistroSeguimiento["tareas"][indice].nuevas_acciones);


    	$("#fecha_reporte_tar").val(dataRegistroSeguimiento["tareas"][indice].fecha_ingreso);
    	$("#frm_campo_tra_nuevas_acciones").val(dataRegistroSeguimiento["tareas"][indice].nuevas_acciones);

    	document.getElementById("frm_campo_tra_avance").value = dataRegistroSeguimiento["tareas"][indice].avances;
    	document.getElementById("frm_campo_tra_modalidad_seguimiento").value = dataRegistroSeguimiento["tareas"][indice].modalidad_seguimiento;

    	document.getElementById("frm_campo_tar_ter").value = dataRegistroSeguimiento["tareas"][indice].finalizar_pendiente;
	   
	    $("#frm_campo_tra_descripcion").val(dataRegistroSeguimiento["tareas"][indice].descripcion);

    	$("#guardar_formulario_tareas").attr("onclick", "guardarFormularioTareas("+indice+");");

    	$("#agre_tar_pen").modal();

		activarNac();

    	// let posicion = $("#agre_tar_pen").offset().top;
	    // $("#frsModal").animate({
	    //     scrollTop: posicion
	    // }, 500); 
    }

    function guardarFormularioTareas(indice){
    	var valft = validarguardarFormularioTareas();

    	if(valft==false) return false;

    	let descripcion = $("#frm_campo_tra_descripcion").val();
    	let nuevas_acciones = $("#frm_campo_tra_nuevas_acciones").val();
    	let avances = document.getElementById("frm_campo_tra_avance").value;
    	let modalidad_seguimiento = document.getElementById("frm_campo_tra_modalidad_seguimiento").value;

    	let fecha_reporte_tar = $("#fecha_reporte_tar").val();

    	let finalizar_pendiente = document.getElementById("frm_campo_tar_ter").value;

    	dataRegistroSeguimiento["tareas"][indice].descripcion 			= descripcion;
    	dataRegistroSeguimiento["tareas"][indice].nuevas_acciones 		= nuevas_acciones;
    	dataRegistroSeguimiento["tareas"][indice].avances 				= avances;
    	dataRegistroSeguimiento["tareas"][indice].modalidad_seguimiento = modalidad_seguimiento;
    	dataRegistroSeguimiento["tareas"][indice].fecha_ingreso = fecha_reporte_tar;

    	dataRegistroSeguimiento["tareas"][indice].finalizar_pendiente = finalizar_pendiente;

    	//alert(finalizar_pendiente);

    	//$("#agre_tar_pen").hide();

    	$('#agre_tar_pen').modal('hide');
    	
    	listarTareasPendientes();
    }
    //-------------------- TAREAS ----------------------

     function validarguardarFormularioTareas(){
     		limpiarModalRis();

     		let frm_campo_tra_modalidad_seguimiento = $("#frm_campo_tra_modalidad_seguimiento").val();

				if(frm_campo_tra_modalidad_seguimiento=="") {
					//alert("Debe ingresar opción modalidad de seguimiento");
					$("#frm_campo_tra_modalidad_seguimiento").addClass("is-invalid");
  					$("#val_mod_rp_tar_seg").show();
					return false;
				}

			let fecha_reporte_tar = $("#fecha_reporte_tar").val();

				if(fecha_reporte_tar=="") {
					//alert("Debe ingresar opción modalidad de seguimiento");
					$("#fecha_reporte_tar").addClass("is-invalid");
  					$("#val_fecha_reporte_tar").show();
					return false;
				}


     		let frm_campo_tra_avance = $("#frm_campo_tra_avance").val();

				if(frm_campo_tra_avance=="") {

					 $("#frm_campo_tra_avance").addClass("is-invalid");
   	   				 $("#val_av_rp_tar_seg").show();

					return false;
				}


			let frm_campo_tra_descripcion = $("#frm_campo_tra_descripcion").val();

				if(frm_campo_tra_descripcion=="") {

					 $("#frm_campo_tra_descripcion").addClass("is-invalid");
   	   				 $("#val_des_ac_tar_pen").show();
					
					return false;
				}

			var cant=frm_campo_tra_descripcion.length;

				if(cant<3) {
					alert("Debe ingresar la descripción, minimo 3 caracteres");
					$("#frm_campo_tra_descripcion").addClass("is-invalid");
					return false;
				}

			let frm_campo_tar_ter = $("#frm_campo_tar_ter").val();

				if(frm_campo_tar_ter=="") {
					//alert("Debe ingresar opción modalidad de seguimiento");
					$("#frm_campo_tar_ter").addClass("is-invalid");
  					$("#val_frm_campo_tar_ter").show();
					return false;
				}	

				if(frm_campo_tar_ter==0){

					let frm_campo_tra_nuevas_acciones = $("#frm_campo_tra_nuevas_acciones").val();

						if(frm_campo_tra_nuevas_acciones=="") {
							//alert("Debe ingresar nuevas acciones");

							 $("#frm_campo_tra_nuevas_acciones").addClass("is-invalid");
		   	   				 $("#val_nuev_ac_tar_pe").show();

							return false;
						}

						var cant=frm_campo_tra_nuevas_acciones.length;

						if(cant<3) {
							alert("Debe ingresar pasos a seguir, minimo 3 caracteres");
							 $("#frm_campo_tra_nuevas_acciones").addClass("is-invalid");
							return false;
						}
		 		}
     }


    //-------------------- PROGRAMAS ----------------------
    function listarProgramasPendientes(){
    	let listarDataProgramas = $('#tabla_derivaciones').DataTable();
        listarDataProgramas.clear().destroy();

        let html = "";
        let programas = dataRegistroSeguimiento.programas;
        programas.forEach(function(value, index){

        	let numeracion = index + 1;

        	let nombre = "Sin información";
        	if (value.pro_nom.length > 0 && value.pro_nom != "") nombre = value.pro_nom;

        	let modalidad_seguimiento = "Sin información";
        	if (value.modalidad_seguimiento.length > 0 && value.modalidad_seguimiento != "") 
			{
				if(value.modalidad_seguimiento==0)modalidad_seguimiento = "Revisión de plataforma";
				if(value.modalidad_seguimiento==1)modalidad_seguimiento = "Revisión de plataforma y llamados telefónicos";
				if(value.modalidad_seguimiento==2)modalidad_seguimiento = "Visita al domicilio";
			}

        	let avances = "Sin información";
        	if (value.avances.length > 0 && value.avances != ""){
        		if (value.avances == 1){
        			avances = "Sí";
        		}else if(value.avances == 0){
        			avances = "No";
        		}
        	}
        	
        	let descripcion = "Sin información";
        	if (value.descripcion.length > 0 && value.descripcion != "") descripcion = value.descripcion;

        	let razon = "Sin información";
        	if (value.razon.length > 0 && value.razon != ""){
        		if (value.razon == 0){
        			razon = "En proceso de postulación en trámite.";
        		}else if(value.razon == 1){
        			razon = "No acceso por pérdida de cupo.";
        		}else if (value.razon == 2){
        			razon = "Abandona por razones familiares.";
        		}else if(value.razon == 3){
        			razon = "Abandona por características del Programa.";
        		}

        	}

        	let nuevas_acciones = "Sin información";
        	if (value.nuevas_acciones.length > 0 && value.nuevas_acciones != "") nuevas_acciones = value.nuevas_acciones;

        	let fecha_ingreso = "Sin información";
        	if (value.fecha_ingreso.length > 0 && value.fecha_ingreso != "") fecha_ingreso = value.fecha_ingreso;

        	let finalizar_pendiente = "Sin información";
        	if (value.finalizar_pendiente.length > 0 && value.finalizar_pendiente != ""){
        			
        		if(value.finalizar_pendiente==1){ 
        			finalizar_pendiente = "Sí"; 
        			nuevas_acciones="Sin información";
				}

				if(value.finalizar_pendiente==0) finalizar_pendiente = "No";
        	}

            html += '<tr>';
            html += '<td>'+numeracion+'</td>';
            html += '<td>'+nombre+'</td>';
            html += '<td>'+modalidad_seguimiento+'</td>';
            html += '<td>'+fecha_ingreso+'</td>';
            html += '<td>'+avances+'</td>';
            html += '<td>'+razon+'</td>';
            html += '<td>'+descripcion+'</td>';
            html += '<td>'+finalizar_pendiente+'</td>';
            html += '<td>'+nuevas_acciones+'</td>';
            html += '<td><button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#formComponentes" onclick="desplegarFormularioProgramas('+index+');">Editar <span class="oi oi-pencil"></span></button></td>';
            html += '</tr>';
        });

        $("#tabla_derivaciones > tbody").html(html);

        $('#tabla_derivaciones').DataTable({
            ordering:   false,
            paging:     true,
            searching:  false,
            info:       true,
            columnDefs: [
                {"className": "dt-center", "targets": [0]},
                {"className": "dt-center", "targets": [1]},
                {"className": "dt-left", "targets": [2]},
                {"className": "dt-left", "targets": [3]},
                {"className": "dt-left", "targets": [4]},
                {"className": "dt-left", "targets": [5]},
                {"className": "dt-left", "targets": [6]}],
            language: { "url": "{{ route('index') }}/js/dataTables.spanish.json"}
        });

        $('#tabla_derivaciones').find("thead th").removeClass("sorting_asc");
    }

    function limpiarFormularioProgramas(){
    	$("#frm_campo_pro_derivacion").val("");
    	$("#frm_campo_pro_descripcion").val("");
    	$("#frm_campo_pro_nuevas_acciones").val("");

    	document.getElementById("frm_campo_pro_modalidad_seguimiento").value 	= "";
    	document.getElementById("frm_campo_pro_razon").value 					= "";
    	document.getElementById("frm_campo_pro_avance").value 					= "";
    	//document.getElementById("frm_campo_pro_ter").value 	= "";
    	document.getElementById("frm_campo_dev_ter").value = "";

    	

    	$("#guardar_formulario_programas").removeAttr("onclick");
    }

    function desplegarFormularioProgramas(indice){
    	limpiarFormularioProgramas();

    	$("#frm_campo_pro_derivacion").val(dataRegistroSeguimiento["programas"][indice].pro_nom);
    	$("#frm_campo_pro_descripcion").val(dataRegistroSeguimiento["programas"][indice].descripcion);
    	$("#frm_campo_pro_nuevas_acciones").val(dataRegistroSeguimiento["programas"][indice].nuevas_acciones);

    	document.getElementById("frm_campo_pro_modalidad_seguimiento").value 	= dataRegistroSeguimiento["programas"][indice].modalidad_seguimiento;
    	document.getElementById("frm_campo_pro_razon").value 					= dataRegistroSeguimiento["programas"][indice].razon;
    	document.getElementById("frm_campo_pro_avance").value 					= dataRegistroSeguimiento["programas"][indice].avances;

    	document.getElementById("frm_campo_dev_ter").value = dataRegistroSeguimiento["programas"][indice].finalizar_pendiente;

    	let mostrar = document.getElementById("frm_campo_dev_ter").value;

    	if(mostrar==1) $("#razon_mostrar").hide();

    	if(mostrar==0) $("#razon_mostrar").show();
   
   		$("#guardar_formulario_programas").attr("onclick", 'guardarFormularioProgramas('+indice+');');
   		$("#agre_dev_pen").modal();

   		// let posicion = $("#agre_dev_pen").offset().top;
	    // $("#frsModal").animate({
	    //     scrollTop: posicion
	    // }, 500); 
    }

    function guardarFormularioProgramas(indice){
    	var valfp = validarGuardarFormularioProgramas();

    	if(valfp==false) return false;


    	let derivacion = $("#frm_campo_pro_derivacion").val();
    	let avances = document.getElementById("frm_campo_pro_avance").value;
    	let razon = document.getElementById("frm_campo_pro_razon").value;
    	let descripcion = $("#frm_campo_pro_descripcion").val();
    	let nuevas_acciones = $("#frm_campo_pro_nuevas_acciones").val();
    	let modalidad_seguimiento = document.getElementById("frm_campo_pro_modalidad_seguimiento").value;

    	let fecha_reporte_dev = $("#fecha_reporte_dev").val();


    	let finalizar_pendiente = document.getElementById("frm_campo_dev_ter").value;

    	dataRegistroSeguimiento["programas"][indice].avances = avances;
    	dataRegistroSeguimiento["programas"][indice].razon = razon;
    	dataRegistroSeguimiento["programas"][indice].descripcion = descripcion;
    	dataRegistroSeguimiento["programas"][indice].nuevas_acciones = nuevas_acciones;
    	dataRegistroSeguimiento["programas"][indice].modalidad_seguimiento = modalidad_seguimiento;
    	dataRegistroSeguimiento["programas"][indice].fecha_ingreso = fecha_reporte_dev;
    	dataRegistroSeguimiento["programas"][indice].finalizar_pendiente = finalizar_pendiente;

    	$('#agre_dev_pen').modal('hide');

    	listarProgramasPendientes();
    }
    //-------------------- PROGRAMAS ----------------------
    function validarGuardarFormularioProgramas(){
     		limpiarModalRis();

			let frm_campo_pro_modalidad_seguimiento = $("#frm_campo_pro_modalidad_seguimiento").val();

				if(frm_campo_pro_modalidad_seguimiento=="") {
					 $("#frm_campo_pro_modalidad_seguimiento").addClass("is-invalid");
   	   				 $("#val_mod_rp_derv_seg").show();

					return false;
				}


     		let fecha_reporte_dev = $("#fecha_reporte_dev").val();

				if(fecha_reporte_dev=="") {
					 $("#fecha_reporte_dev").addClass("is-invalid");
   	   				 $("#val_fecha_reporte_dev").show();

					return false;
				}


     		let frm_campo_pro_avance = $("#frm_campo_pro_avance").val();

				if(frm_campo_pro_avance=="") {
					 $("#frm_campo_pro_avance").addClass("is-invalid");
   	   				 $("#val_av_rp_der_seg").show();

					return false;
				}

				let frm_campo_pro_razon = $("#frm_campo_pro_razon").val();

		   		var mostrar_razon = $("#frm_campo_pro_avance").val();

		   	
					if(frm_campo_pro_razon=="") {
						 $("#frm_campo_pro_razon").addClass("is-invalid");
	   	   				 $("#val_raz_derv_pen").show();	

						return false;
					}
			
				let frm_campo_pro_descripcion = $("#frm_campo_pro_descripcion").val();

				if(frm_campo_pro_descripcion=="") {
					 $("#frm_campo_pro_descripcion").addClass("is-invalid");
   	   				 $("#val_des_derv_pen").show();

					return false;
				}

				 var cant=frm_campo_pro_descripcion.length;

				if(cant<3) {
					alert("Debe ingresar la descripción, minimo 3 caracteres");
					 $("#frm_campo_pro_descripcion").addClass("is-invalid");
					return false;
				}

				let frm_campo_dev_ter = $("#frm_campo_dev_ter").val();

				if(frm_campo_dev_ter=="") {
					 $("#frm_campo_dev_ter").addClass("is-invalid");
   	   				 $("#val_frm_campo_dev_ter").show();
					return false;
				}


				if(frm_campo_dev_ter==0) {
					let frm_campo_pro_nuevas_acciones = $("#frm_campo_pro_nuevas_acciones").val();

					if(frm_campo_pro_nuevas_acciones=="") {
						 $("#frm_campo_pro_nuevas_acciones").addClass("is-invalid");
	   	   				 $("#val_n_derv_pen").show();
						return false;
					}
				}

				 var cant=frm_campo_pro_nuevas_acciones.length;

				if(cant<3) {
					alert("Debe ingresar las nuevas acciones, minimo 3 caracteres");
					$("#frm_campo_pro_nuevas_acciones").addClass("is-invalid");
					return false;
				}
    }

    //-------------------- ALERTAS ----------------------
     function listarAlertasPendientes(){
    	let listarDataAlertas = $('#tabla_pendientes_alertas').DataTable();
        listarDataAlertas.clear().destroy();

        let html = "";
        let programas = dataRegistroSeguimiento.alertas;
        programas.forEach(function(value, index){

        	let numeracion = index + 1;
        	let integrante = "Sin información";
        	if (value.integrante.length > 0 && value.integrante != "") integrante = value.integrante;

        	let nueva_alerta = "Sin información";
        	if (value.nueva_alerta.length > 0 && value.nueva_alerta != ""){
        		if (value.nueva_alerta == 1){
        			nueva_alerta = "Sí";
        		}else if(value.nueva_alerta == 0){
        			nueva_alerta = "No";
        		}
        	}

        	let tipo_alerta = "Sin información";
        	if (value.ale_tip_nom.length > 0 && value.ale_tip_nom != "") tipo_alerta = value.ale_tip_nom;

        	let fecha_ingreso = "Sin información";
        	if (value.fecha_ingreso.length > 0 && value.fecha_ingreso != "") fecha_ingreso = value.fecha_ingreso;

        	let sectorialista = "Sin información";
        	if (value.sectorialista.length > 0 && value.sectorialista != "") sectorialista = value.sectorialista;

        	let nuevas_acciones = "Sin información";
        	if (value.nuevas_acciones.length > 0 && value.nuevas_acciones != "") nuevas_acciones = value.nuevas_acciones;


            html += '<tr>';
            html += '<td>'+numeracion+'</td>';
            html += '<td>'+integrante+'</td>';
            html += '<td>'+fecha_ingreso+'</td>';
            html += '<td>'+sectorialista+'</td>';
            html += '<td>'+tipo_alerta+'</td>';
            html += '<td>'+nuevas_acciones+'</td>';
            html += '<td><button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#formComponentes" onclick="desplegarFormularioAlertas('+index+')">Editar <span class="oi oi-pencil"></span></button></td>';
            html += '</tr>';
        });

        $("#tabla_pendientes_alertas > tbody").html(html);

        $('#tabla_pendientes_alertas').DataTable({
            ordering:   false,
            paging:     true,
            searching:  false,
            info:       true,
            columnDefs: [
                {"className": "dt-center", "targets": [0]},
                {"className": "dt-center", "targets": [1]},
                {"className": "dt-left", "targets": [2]},
                {"className": "dt-left", "targets": [3]},
                {"className": "dt-left", "targets": [4]}],
            language: { "url": "{{ route('index') }}/js/dataTables.spanish.json"}
        });

        $('#tabla_pendientes_alertas').find("thead th").removeClass("sorting_asc");
    }

    function limpiarFormularioAlertas(){
    	$("#frm_campo_ale_integrante").val();
    	$("#frm_campo_ale_tipo").val();

    	$("#guardar_formulario_alertas").removeAttr("onclick");
    }

    function desplegarFormularioAlertas(indice){
    	limpiarFormularioAlertas();

    	$("#frm_campo_ale_integrante").val(dataRegistroSeguimiento["alertas"][indice].integrante);
    	$("#frm_campo_ale_tipo").val(dataRegistroSeguimiento["alertas"][indice].ale_tip_nom);

    	$("#frm_campo_ale_sectorialista").val(dataRegistroSeguimiento["alertas"][indice].sectorialista);

    	$("#frm_campo_ale_fec_ing").val(dataRegistroSeguimiento["alertas"][indice].fecha_ingreso);

		document.getElementById("frm_campo_ale_ter").value = dataRegistroSeguimiento["alertas"][indice].finalizar_pendiente;
    	
		let mostrar= document.getElementById("frm_campo_ale_ter").value;

		if(mostrar==1) $("#mostrar_pasos_a_seguir_ale").hide();

		if(mostrar==0) $("#mostrar_pasos_a_seguir_ale").show();
	
    	$("#frm_campo_ale_pasos_a_seguir").val(dataRegistroSeguimiento["alertas"][indice].nuevas_acciones);
    
    	$("#guardar_formulario_alertas").attr("onclick", 'guardarFormularioAlertas('+indice+');');
   		$("#agre_ale_pen").modal();

   		// let posicion = $("#agre_ale_pen").offset().top;
	    // $("#frsModal").animate({
	    //     scrollTop: posicion
	    // }, 500); 
    }

    function guardarFormularioAlertas(indice){
    	limpiarModalRis();

    	var valfa = validarGuardarFormularioAlertas();

    	if(valfa==false) return false;

    	let nuevas_acciones = $("#frm_campo_ale_pasos_a_seguir").val();
    	let finalizar_pendiente = document.getElementById("frm_campo_ale_ter").value;

    	dataRegistroSeguimiento["alertas"][indice].nuevas_acciones = nuevas_acciones;
    	dataRegistroSeguimiento["alertas"][indice].finalizar_pendiente = finalizar_pendiente;
    
    	//$("#agre_ale_pen").hide();

    	$('#agre_ale_pen').modal('hide');

    	listarAlertasPendientes();

    	$("#frm_campo_ale_ter").val("");

    	$("#frm_campo_ale_pasos_a_seguir").val("");

    }


     function validarGuardarFormularioAlertas(){
		let frm_campo_ale_ter = $("#frm_campo_ale_ter").val();

		if(frm_campo_ale_ter=="") {
			$("#frm_campo_ale_ter").addClass("is-invalid");
	   			$("#val_frm_campo_ale_ter").show();

			return false;
		}

		if(frm_campo_ale_ter==0){
			let frm_campo_ale_pasos_a_seguir = $("#frm_campo_ale_pasos_a_seguir").val();

			if(frm_campo_ale_pasos_a_seguir=="") {
				$("#frm_campo_ale_pasos_a_seguir").addClass("is-invalid");
   	   			$("#val_frm_campo_ale_pasos_a_seguir").show();

				return false;
			}
		}
      }
    //-------------------- ALERTAS ----------------------
</script>