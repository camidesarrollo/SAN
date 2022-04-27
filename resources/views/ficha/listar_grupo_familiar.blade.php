<!-- Inicio Andres Sprint 57 -->
<div class="table-responsive">
		<table class="table table-bordered table-hover table-striped text-center w-100" id="tabla_grupo_familiar">
			<thead>
			<tr>
				<th>N°</th>
				<th>Nombre</th>
				<th>Apellido</th>
				<th>RUN</th>
				<th>Edad</th>
				<th>Parentesco</th>
				<th>Estado</th>
				@if ($modo_visualizacion == 'edicion' || $habilitar_funcion == true)
					<th>Acción</th>
				@endif
			</tr>
			</thead>
			<tbody></tbody>
			
		</table>
</div>

<!-- Fin Andres Sprint 57 -->
@if ($modo_visualizacion == 'edicion' || $habilitar_funcion == true)
	<!-- INICIO CZ SPRINT 60 -->
    <button type="button" class="btn btn-outline-success m-4 float-right" 
	@if($est_cas_fin)
									disabled 
								@else 
									onclick="$('#diagnosticoModal').modal('hide'); cambioFuncionformulario(1); $('#formGrupoFamiliar').modal('show'); limpiarFormularioFamiliar();">
								@endif 
								<i class="fa fa-plus-circle"></i> Agregar Integrante</button>
								<!-- FIN CZ SPRINT 60 -->
@endif	    

<br>
<script type="text/javascript">
	function listarGrupoFamiliar(caso_id){
		let data_grupoFamiliar = $('#tabla_grupo_familiar').DataTable();

		data_grupoFamiliar.destroy();
		let data = new Object();
		data.caso_id = caso_id;

		data_grupoFamiliar =	$('#tabla_grupo_familiar').DataTable({
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
			"ajax"		: { "url" :	"{{ route('listar.grupo.familiar') }}", "type": "GET",  "data": data },
			"createdRow": function( row, data, dataIndex ){
				//console.log("que sucede?", row, data, dataIndex); return false;
			},
			"columns"	: [
				{
					"data": "N°", //N°
					"width": "10px",
					"className": "text-center verticalText",
					"render": function(data, type, row, dataIndex){
						let cant = dataIndex.row + 1;

						return cant;
					}
				},
				{
					"data":'gru_fam_nom', //NOMBRE
					"className": "text-center verticalText",
					"render": function(data, type, row){
						let formato = formateoNombres(data);

						return formato.nombre;
					}
				},
				{
					"data":'gru_fam_ape_pat', //Apellidos
					"className": "text-center verticalText",
					'render': function (data, type, row, meta) {
						let formato = formateoNombres(null, data, row.gru_fam_ape_mat);
						let apellido = formato.ape_pat + ' ' + formato.ape_mat;

						return apellido;
					}
				},
				{
					"data": "gru_fam_run", //RUN
					"width": "71px",
					"className": "text-center",
					'render': function (data, type, full, meta) {
						
						let dv = full.gru_fam_dv;
						//let dv = obtenerDv(data);
						
						let run = formatearRun(data+"-"+dv);

						run = esconderRut(run, "{{ config('constantes.ofuscacion_run') }}");

						return run;
					}
				},
				{
					"data": "gru_fam_nac", //EDAD
					"className": "text-center verticalText",
					'render': function (data, type, full, meta) {
						//CZ SPRINT 74 -->
						if(data != null){
						return calcularEdad(data);
						}else{
							return 'Sin datos';
						}
						//CZ SPRINT 74 -->
					}
				},
				{
					"data": "par_gru_fam_nom", //Parentesco
					"className": "text-center verticalText",
					"render" : function (data, type, row){
                        let parentesco = data;

						if (parentesco == "" || parentesco == undefined){
							parentesco = "Sin información";
						}

                        return parentesco;
					}
				},
// Inicio Andres Sprint 57
				{
					"data": "gru_fam_est", //estado
					"className": "text-center verticalText",
					"render" : function (data, type, row){
                        let estado = "Vigente";

						if (data == 0){
							estado = "No vigente";
						}

                        return estado;
					}
				},
//Fin Andres Sprint 57				
				@if ($modo_visualizacion == 'edicion' || $habilitar_funcion == true)
				{
					"data": "gru_fam_est", //Estado
					"className": "text-center verticalText",
					"render" : function (data, type, row){
						//console.log(data, type, row);
						let activo = "Vigente";

						if (data == 0) activo = "No vigente";
						// INICIO CZ SPRINT 59
						@if($est_cas_fin)
							let html = '<button type="button" style="width:100%;" disabled class="btn btn-primary edita_direccion" onclick="accionesFamilia(1, '+row.gru_fam_id+');"><span class="oi oi-pencil"></span>&nbsp;Editar</button>';
						@else 
						let html = '<button type="button" style="width:100%;" class="btn btn-primary edita_direccion" onclick="accionesFamilia(1, '+row.gru_fam_id+');"><span class="oi oi-pencil"></span>&nbsp;Editar</button>';
						@endif 
						// FIN CZ SPRINT 59
						return html;
					}
				}
				@endif

			],
			"drawCallback": function (settings){
				$("#totalNNA").text(settings._iRecordsTotal);
			}
		});

		$('#tabla_grupo_familiar').addClass("headerTablas");

		$('#tabla_grupo_familiar').find("thead th").removeClass("sorting_asc");
	}

	function validarFormInteFamiliar(){
		let respuesta = true;

		/*Se rescatan los valores del formulario*/
		let run	= $("#form_familiar_run").val();
		let nac = $('#form_familiar_nac').data('date');
		let nom = $("#form_familiar_nom").val();
		let pat = $("#form_familiar_pat").val();
		let mat = $("#form_familiar_mat").val();
		let sex = $("#form_familiar_sex").val();
		let par = $("#form_familiar_par").val();
		let email = $("#form_familiar_email").val();
		let fono = $("#form_familiar_fono").val();
		let pat_otr = $("#form_otro_par").val();

        /*Validacion RUN*/
		if (!$('#form_familiar_chk_sin_run').prop('checked') && (run == "" || typeof run === "undefined")){
			respuesta = false;
			$("#val_frm_gfam_1").text("* Debe ingresar RUN.");
			$("#val_frm_gfam_1").show();
		}

		let val_run = $('#form_familiar_run').attr("data-val-run");

		if (val_run == false || val_run == "false"){
			respuesta = false;
			$("#val_frm_gfam_1").text("* RUN Inválido.");
			$("#val_frm_gfam_1").show();
		}

		/*Validación Fecha de Nacimiento*/
		if (!validarFormatoFecha(nac)){
			respuesta = false;
			$("#val_frm_gfam_2").show();
		}

		if (!existeFecha(nac)){
			respuesta = false;
			$("#val_frm_gfam_2").show();
		}

		/*Validacion Nombre*/
		if (nom == "" || typeof nom === "undefined"){
			respuesta = false;
			$("#val_frm_gfam_3").show();
		}

		/*Validacion Apellido Paterno*/
		if (pat == "" || typeof pat === "undefined"){
			respuesta = false;
			$("#val_frm_gfam_4").show();
		}

		/*Validacion Apellido Materno*/
		if (mat == "" || typeof mat === "undefined"){
			respuesta = false;
			$("#val_frm_gfam_5").show();
		}

		
		/*Validacion Parentesco*/
		if (par == "" || typeof par === "undefined"){
			respuesta = false;
			$("#val_frm_gfam_7").show();
		}else if(par == 12){
			if (pat_otr == "" || typeof pat_otr === "undefined"){
				respuesta = false;
				$("#val_frm_gfam_10").show();
			}
		}

		/*Validacion Email*/
		// if (email == "" || typeof email === "undefined"){
		// 	respuesta = false;
		// 	$("#val_frm_gfam_8").show();
		// }
		// else{

		// 	if( validarEmail( email ) )
		// 	{
		// 	    //alert("El email es correcto");
		// 	    respuesta = true;

		// 	}
		// 	else
		// 	{
		// 	  $("#form_familiar_email").addClass("is-invalid");
  //  			    alert("El email NO es correcto");
		// 	    respuesta = false;
		// 	}
		// }

		/*Validacion Email*/
		if (email != ""){
			if( validarEmail( email ) ){
				respuesta = true;
			}else{
   			    $("#val_frm_gfam_8").show();
			    respuesta = false;
			}
		}

		/*Validacion Telefono*/
		// if (fono == "" || typeof fono === "undefined"){
		// 	respuesta = false;
		// 	$("#val_frm_gfam_9").show();
		// }

		/*Validación Sexo*/
		if (sex == "" || typeof sex === "undefined"){
			respuesta = false;
			$("#val_frm_gfam_6").show();
		}

		return respuesta;
	}

	function ocultarMensajesErrorFormulario(){
		$("#val_frm_gfam_1").hide();
		$("#val_frm_gfam_2").hide();
		$("#val_frm_gfam_3").hide();
		$("#val_frm_gfam_4").hide();
		$("#val_frm_gfam_5").hide();
		$("#val_frm_gfam_6").hide();
		$("#val_frm_gfam_7").hide();
		$("#val_frm_gfam_8").hide();
		$("#val_frm_gfam_9").hide();
		$("#val_frm_gfam_10").hide();

		$("#form_familiar_email").removeClass("is-invalid");
	}

	function accionesFamilia(option, familiar_id = null){
		let validacion = true;
		let data = new Object();

		ocultarMensajesErrorFormulario();

		switch (option){
			case 1: //Buscar información integrante familiar
				$('#diagnosticoModal').modal('hide');
				data.gru_fam_id = familiar_id;
			break;

			case 2: //Registrar nuevo integrante familiar
				validacion = validarFormInteFamiliar();

				data = recolectarValorFormularioFamiliar();
			break;

			case 3: //Actualizar integrante familiar
				validacion = validarFormInteFamiliar();

				data = recolectarValorFormularioFamiliar();
				data.id = $("#id_familiar").val();
			break;
		}

		if (validacion == false) return false;

		data.option = option;
		$("#listar_grupo_familiar").collapse('hide');
		$.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="_token_formulario_familiar"]').attr('content')} });

		$.ajax({
			"url" : '{{ route("formulario.acciones.familiar") }}',
			"type": "GET",
			"dataType" : 'json',
			"data": data
		}).done(function(resp){
			if (resp.estado == 1){
				//console.log(resp.respuesta); return false;

				switch (option) {
					case 1: //Mostrar información para editar
						limpiarFormularioFamiliar();
						// INICIO CZ SPRINT 58 
						$("#div_form_familiar_chk_sin_run").css("display","none");
						let run = formatearRun(resp.respuesta[0].gru_fam_run+"-"+resp.respuesta[0].gru_fam_dv);
						// FIN CZ SPRINT 58 
						$("#form_familiar_run").val(esconderRut(run, "{{ config('constantes.ofuscacion_run') }}"));
						$("#form_familiar_run").attr("disabled", true);
						$('#form_familiar_run').attr("data-val-run", true);
						$("#id_familiar").val(resp.respuesta[0].gru_fam_id);
						$("#form_familiar_nom").val(resp.respuesta[0].gru_fam_nom);
						$("#form_familiar_pat").val(resp.respuesta[0].gru_fam_ape_pat);
						$("#form_familiar_mat").val(resp.respuesta[0].gru_fam_ape_mat);

							$("#form_familiar_fono").val(resp.respuesta[0].gru_fam_telefono);
							$("#form_familiar_email").val(resp.respuesta[0].gru_fam_email);

						let fec = new Date(resp.respuesta[0].gru_fam_nac);
						fec = fec.getDate()+"/"+(fec.getMonth() + 1 )+"/"+fec.getFullYear();

						$('#form_familiar_nac').datetimepicker('date', fec);

						document.getElementById("form_familiar_sex").value = resp.respuesta[0].gru_fam_sex;
						if(resp.respuesta[0].gru_fam_par == 12){
							document.getElementById("form_familiar_par").value = resp.respuesta[0].gru_fam_par;
							$("#inp_otro_par").show();
						}else if((resp.respuesta[0].gru_fam_par > 13) && (resp.respuesta[0].gru_fam_par != 99)){
							document.getElementById("form_familiar_par").value = 12;
							$("#inp_otro_par").show();
							document.getElementById("form_otro_par").value = resp.respuesta[0].gru_fam_par;	
						}else{
							document.getElementById("form_familiar_par").value = resp.respuesta[0].gru_fam_par;
						}
						
						
						if (resp.respuesta[0].gru_fam_est == 1){
							$("#form_familiar_vig").prop('checked', true);

						}else if (resp.respuesta[0].gru_fam_est == 0){
							$("#form_familiar_no_vig").prop('checked', true);

						}

						cambioFuncionformulario(2);
					break;

					case 2: //Registrar nuevo integrante familiar
						// INICIO CZ SPRINT 58 
						$("#div_form_familiar_chk_sin_run").css("display","block");
						// FIN CZ SPRINT 58 
						limpiarFormularioFamiliar();
						$('#formGrupoFamiliar').modal('hide');
						$('#diagnosticoModal').modal('show');
						$("#alert-exi").show();
						setTimeout(function(){ $("#alert-exi").hide(); }, 5000);
					break;

					case 3: //Actualizar integrante familiar
						limpiarFormularioFamiliar();
						cambioFuncionformulario(1);

						$('#formGrupoFamiliar').modal('hide');
						$('#diagnosticoModal').modal('show');
						$("#alert-exi").text("Registro actualizado exitosamente.");

						$("#alert-exi").show();
						setTimeout(function(){ $("#alert-exi").hide(); }, 5000);
						setTimeout(function(){ $("#alert-exi").text("Registro Guardado Exitosamente."); }, 6000);
					break;
				}

				$('#formGrupoFamiliar').modal('show');
			}else if (resp.estado == 0){
				switch (option){
					case 1: //Mostrar información para editar
						$('#formGrupoFamiliar').modal('hide');
						$('#diagnosticoModal').modal('show');

						$("#alert-err").text(resp.mensaje);
						$("#alert-err").show();

						setTimeout(function(){ $("#alert-err").hide(); }, 5000);
						setTimeout(function(){ $("#alert-err").text("Error al momento de guardar el registro. Por favor intente nuevamente."); }, 6000);
					break;

					case 2: //Registrar nuevo integrante familiar
						$('#diagnosticoModal').modal('hide');
						$('#formGrupoFamiliar').modal('show');

						alert(resp.mensaje);
					break;

					case 3: //Actualizar integrante familiar
						$('#diagnosticoModal').modal('hide');
						$('#formGrupoFamiliar').modal('show');

						alert(resp.mensaje);
					break;

				}
			}
		}).fail(function(obj){
			console.log(obj);

			switch (option){
				case 1: //Mostrar información para editar
					limpiarFormularioFamiliar();
					$('#formGrupoFamiliar').modal('hide');
					$('#diagnosticoModal').modal('show');

					$("#alert-err").text("Error al momento de buscar registro. Por favor intente nuevamente.");
					$("#alert-err").show();

					setTimeout(function(){ $("#alert-err").hide(); }, 5000);
					setTimeout(function(){ $("#alert-err").text("Error al momento de guardar el registro. Por favor intente nuevamente."); }, 6000);
				break;

				case 2: //Registrar nuevo integrante familiar
					limpiarFormularioFamiliar();
					$('#formGrupoFamiliar').modal('hide');
					$('#diagnosticoModal').modal('show');

					$("#alert-err").show();
					setTimeout(function(){ $("#alert-err").hide(); }, 5000);
				break;

				case 3: //Actualizar integrante familiar
					limpiarFormularioFamiliar();
					$('#formGrupoFamiliar').modal('hide');
					$('#diagnosticoModal').modal('show');

					$("#alert-err").text("Error al momento de actualizar registro. Por favor intente nuevamente.");
					$("#alert-err").show();

					setTimeout(function(){ $("#alert-err").hide(); }, 5000);
					setTimeout(function(){ $("#alert-err").text("Error al momento de guardar el registro. Por favor intente nuevamente."); }, 6000);
				break;
			}

		});
	}

	function recolectarValorFormularioFamiliar(){
		let data = new Object();
		let run = limpiarFormatoRun($("#form_familiar_run").val());
		run = dividirRut(run);

		data.run = run[0];
		data.dv  = run[1];
		data.cas_id = {{ $caso_id }};
		data.ges_id = {{ $g_asig_id }};
		data.nac = $('#form_familiar_nac').data('date');
		data.nom = $("#form_familiar_nom").val();
		data.paterno = $("#form_familiar_pat").val();
		data.materno = $("#form_familiar_mat").val();
		data.sexo = $("#form_familiar_sex").val();
		data.parentesco = $("#form_familiar_par").val();
		if(data.parentesco == 12){
			data.parentesco = $("#form_otro_par").val();
		}
		data.estado = $("[name=form_familiar_estado]:checked").val();
		data.fono = $("#form_familiar_fono").val();
		data.email = $("#form_familiar_email").val();
		return data;
	}

	function limpiarFormularioFamiliar(){
		$('#form_familiar_nac').datetimepicker('clear');

		$("#form_familiar_run").val("");
		$("#form_familiar_run").attr("disabled", false);
		$('#form_familiar_run').removeAttr("data-val-run");

		$("#form_familiar_nom").val("");
		$("#form_familiar_pat").val("");
		$("#form_familiar_mat").val("");

		document.getElementById("form_familiar_sex").value = '';
		document.getElementById("form_familiar_par").value = '';

		$("[name=form_familiar_estado]").removeAttr("checked");
		$("#form_familiar_vig").attr('checked', 'checked');

		$("#val_frm_gfam_1").hide();

		$("#val_frm_gfam_2").hide();

		$("#val_frm_gfam_3").hide();

		$("#val_frm_gfam_4").hide();

		$("#val_frm_gfam_5").hide();

		$("#val_frm_gfam_6").hide();

		$("#val_frm_gfam_7").hide();

		$("#val_frm_gfam_10").hide();

		$("#form_otro_par").val("");

		$('#inp_otro_par').hide();

	}

	function cambioFuncionformulario(option){
		let titulo = "Agregar Integrante Familiar";

		switch(option){
			case 1: //Insertar nuevo registro
				// INICIO CZ SPRINT 58
				$("#div_form_familiar_chk_sin_run").css("display","block");
				// FIN CZ SPRINT 58
				$("#form_familiar_tit").text(titulo);
				$("#btn_editar_guardar_integrante").attr("onclick", "accionesFamilia(2);");
				$("#btn_editar_guardar_integrante").text("Guardar");
			break;

			case 2: //Modificar registro
				titulo = "Modificar Integrante Familiar";

				$("#form_familiar_tit").text(titulo);
				$("#btn_editar_guardar_integrante").attr("onclick", "accionesFamilia(3);");
				$("#btn_editar_guardar_integrante").text("Modificar");
			break;
		}
	}

	function habilitarOtrosFamiliares(_this){
		let valor = $(_this).val();

		if(valor == 12){
			$('#inp_otro_par').fadeIn('slow');
		}else{
			$('#inp_otro_par').fadeOut('slow');
		}
	}

	function validarParentescoIntegrante(cas_id, _this){
		let data = new Object();
		data.cas_id 	    = cas_id;
		data.par_gru_fam_id = $(_this).val();

		$.ajax({
			"url" : '{{ route("validar.parentesco.integrante") }}',
			"type": "GET",
			"data": data
		}).done(function(resp){
			if (resp.estado == 1){
               if (resp.respuesta == true){
				   alert("No puede existir más de un jefe(a) de hogar por caso. Por favor intente con otra opción.");
				   document.getElementById("form_familiar_par").value = '';
			   }
			}else if (resp.estado == 0){
				alert("Error al momento de validar parentesco de integrante familiar. Por favor intente nuevamente.");

			}
		}).fail(function(obj){
			alert("Error al momento de validar parentesco de integrante familiar. Por favor intente nuevamente.");
			console.log(obj);
		});
	}

	function autoCompletarFormularioFamiliar(){
		let respuesta 	= "";
		let run 		= $("#form_familiar_run").val();

        if (rutEsValido(run)){
        	obtenerInformacionRunificador(run).then(function (data){
        		console.log(data);
        		if (data.estado == 1){
        			$("#form_familiar_nom").val(data.respuesta.Nombres);
					$("#form_familiar_pat").val(data.respuesta.ApellidoPaterno);
					$("#form_familiar_mat").val(data.respuesta.ApellidoMaterno);

					let fec_res = moment(data.respuesta.FechaNacimiento).format("YYYY/MM/DD");
					let fec = new Date(fec_res);
					fec = fec.getDate()+"/"+(fec.getMonth() + 1 )+"/"+fec.getFullYear();
					$('#form_familiar_nac').datetimepicker('date', fec);

					let val_sex = 1;
					if (data.respuesta.Sexo == "FEMENINO") val_sex = 2;
					document.getElementById("form_familiar_sex").value = val_sex;

					if (data.respuesta.FechaDefuncion == 0){
						$("#form_familiar_vig").attr('checked', true);

					}else if (data.respuesta.FechaDefuncion != 0){
						$("#form_familiar_no_vig").attr('checked', true);

					}
        		}else if (data.estado == 0){
        			console.log(data.mensaje);

        		}
        	}).catch(function (error){
        		console.log(error);

        	});
        }
	}



 function validarEmail( email ) 
{
    var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email) ? true : false;
}
</script>