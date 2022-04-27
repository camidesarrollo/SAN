
<style type="text/css">	
.multiselect {  width: 200px; }
.selectBox {  position: relative; }
.selectBox select { width: 100%; font-weight: bold;}
.overSelect {position: absolute;left:0;right:0;top: 0;bottom:0;}
#checkboxes { display: none; border: 1px #dadada solid; }
#checkboxes label { display: block;}
#checkboxes label:hover { background-color: #1e90ff;}

</style>

<div id="elaborarPafModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="asignarTerapeutaModal" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content ">

			<div class="card p-4 shadow-sm">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute;right: 5px;top: 5px;width: 23px;height: 23px;padding: 0;margin: 0;">
					<span aria-hidden="true">&times;</span>
				</button>
				<h3><span class="oi oi-briefcase"></span> Elaborar PAF</h3>

				<p>RUT: {{ number_format($caso->run,0,",",".")."-".($caso->dig)  }}</p>

				<hr>

				<!-- Mensajes de Alertas -->
				<div class="alert alert-success alert-dismissible fade show" id="alert-exi-paf" role="alert">
					Registro Guardado Exitosamente.
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<div class="alert alert-danger alert-dismissible fade show" id="alert-err-paf" role="alert">
					Error al momento de guardar el registro. Por favor intente nuevamente.
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<!-- Fin Mensajes de Alertas -->


			<div class="modal-body">

				<!-- Listar grupo familiar asociado -->

				@php $grupoFam = Helper::get_grupoFamiliarAsoc($caso->cas_id); @endphp


				<!--2. Resultados Diagnóstico Integral -->
				<button class="btn btn-default" id="btn_despliegue_diagnostico_integral" type="button" data-toggle="collapse" data-target="#listar_diagnostico_integral"
						aria-expanded="false" aria-controls="listar_diagnostico_integral" style="font-weight: 800; width: 100%;"
						onclick="if($(this).attr('aria-expanded') == 'false') listarDiagnosticoIntegral({{$caso->cas_id}});">
					Resultados Diagnóstico Integral
				</button>

				@includeif('ficha.listar_diagnostico_integral')

				<hr>

				@php $cont=1; $elemt=0;  $elemt_ofe=0; @endphp

				<div class="acordeon">

			    @foreach ($ale_man_nna_tip as $ale_tip)

			    <div>

					<label><u><b>Alerta Territorial<?php echo $cont++;?>:</b></u></label><br>
					<span> Estado: <span id="est_{{$ale_tip->ale_man_id}}" style="color:#747474;">{{$ale_tip->est_ale_nom}}</span> / <span> {{ ucfirst($ale_tip->tipo) }}: <span style="color:#747474;"> {{$ale_tip->nombres}} {{$ale_tip->apellido_paterno}} {{$ale_tip->apellido_materno}}</span></span>

					<button onclick="guardarFormPAF(5, this.value);" style="width:142px; 
					<?php if($ale_tip->est_ale_id==7){  } else { echo"display:none"; } ?>"
					value="{{$ale_tip->ale_man_id}}-1" id="btn_hab_{{$ale_tip->ale_man_id}}"type="button" class="btn btn-success float-right" >Habilitar</button>

					<button onclick="guardarFormPAF(5, this.value);" style="<?php if($ale_tip->est_ale_id==7){ echo"display:none"; } ?>" value="{{$ale_tip->ale_man_id}}-2" id="btn_des_{{$ale_tip->ale_man_id}}" type="button" class="btn btn-danger float-right">No Corresponde</button>
				

				<form enctype="multipart/form-data" id="adj_paf" method="post">

					<meta name="_token" content="{{ csrf_token() }}"/>

					{{ csrf_field() }}

					<input type="hidden" name="cas_id" id="cas_id" value="{{$caso->cas_id}}">
					<input type="hidden" name="ale_man_id[]" id="ale_man_id[]" value="{{$ale_tip->ale_man_id}}">
					
					<table class="table table-bordered table-hover dataTable no-footer">
					<tbody>
						 <tr>
							<td class=" text-left" colspan="2"><b>- {{$ale_tip->ale_tip_nom}}</b></td>
						 </tr>
						 <tr role="row">
							 <td aria-controls="tabla_alertas" colspan="2"><u><b>Ofertas Asociadas:</b></u></td>
						 </tr>

						 @php 

						
						 $ofertasParentesco = Helper::get_ofertasParentesco($ale_tip->ale_man_id);

						 @endphp

						 @if(in_array($ale_tip->ale_tip_id, $tip_array))
								@foreach ($alertaManualTipOfe as $ofe)

									@if(($ofe->ale_tip_id)==($ale_tip->ale_tip_id))
										 @php $cont++; $elemt++; @endphp
										<tr role="row">
											<td>
												
												<div class="acordeon__contenedor">
												<h6 class="acordeon__titulo" style="cursor: pointer;"><span style="color:#17a673;" class="oi oi-arrow-thick-bottom">
												</span>
												<span class="form-check-label" for="ofe_id[]">{{$ofe->ofe_nom}}</span></h6>
												<div class="acordeon__contenido" style="display: none;">
												<div class="row">
							                  	<div class="col form-group">
							                       	<label><b>Asignar a Grupo Familiar:<b></label>
							                       	<br>

												  <div class="multiselect ">
												    <div class="selectBox" onclick="showCheckboxes({{$elemt}})">
												      <select style="width:400px;border: 0;">
												        <option> - Seleccione Familiar:</option>
												      </select>
												      <div class="overSelect"></div>
												    </div>
												    <div id="checkboxes_{{$elemt}}" style="background-color:white;width:400px;display:none;">
									 
		@foreach($grupoFam as $value)

		<?php $elemt_ofe++; ?>
		
		<label style="background-color:white;width:400px" for="one">&nbsp;-
			<input id="grup_fam_id_{{$elemt_ofe}}" style="border-color:black; " value="{{$ofe->ofe_id}}-{{$ofe->ale_man_id}}-{{$value->gru_fam_id}}-{{$elemt_ofe}}" id="{{$value->gru_fam_id}}" name="{{$value->gru_fam_id}}" type="checkbox" onclick="guardarFormPAF(3, this.value);"

			<?php $est_prest_id=0; foreach ($ofertasParentesco as $chk){

			if(($ofe->ale_man_id==$chk->ale_man_id) && ($ofe->ofe_id==$chk->ofe_id) && ($value->gru_fam_id==$chk->gru_fam_id))
			{  
				echo"checked";
				echo"  ";
				$est_prest_id=$chk->est_prest_id;
				echo"disabled";
			}
			}
			?> >

			{{ucwords($value->gru_fam_nom)}}
			
				<button id="btn_ofe_no_{{$elemt_ofe}}" onclick="guardarFormPAF(6, this.value);" style="width:142px;max-height:25px;padding:0px;<?php //if($est_prest_id==6){ echo"display:none"; }?>" <?php if(($est_prest_id==6)||($est_prest_id==0)){ echo"disabled"; }?> value="{{$ofe->ofe_id}}-{{$ofe->ale_man_id}}-{{$value->gru_fam_id}}-1-{{$elemt_ofe}}" type="button" class="btn btn-danger float-right">No Corresponde</button>

			<!-- 	<button id="btn_ofe_hab_{{$elemt_ofe}}" onclick="guardarFormPAF(6, this.value);" style="width:142px;max-height:25px;padding:0px;<?php //if($est_prest_id!=6){ echo"display:none"; }?> " 
				value="{{$ofe->ofe_id}}-{{$ofe->ale_man_id}}-{{$value->gru_fam_id}}-2-{{$elemt_ofe}}" type="button" class="btn btn-success float-right" >Habilitar</button> -->

		</label>

		@endforeach

		 </div>
		</div>

												</div>
												</div>

												</div>
												</div>
												</div>
											</td>
										</tr>
									@endif

								@endforeach
						 @else
							<tr role="row" class="odd">
								<td class=" text-left" >
									<span style="color: red;">No existen ofertas para esta alerta.</span>
								</td>
							</tr>
						 @endif
					</tbody>
					</table>
				<hr>
			</div>
		@endforeach
</div>

					<!--<div class="modal-body">-->
					<div class="form-group">
						<label for="nec_ter"><u><b>¿ Necesita Terapia ?</b></u></label>
							<select class="form-control"name="nec_ter[]" id="nec_ter" onchange="activarTerapeutas(this);">
								<option value="">Seleccione una opción</option>
								<option value="1" @if ($necesita_terapeuta == 1) selected @endif>Sí</option>
								<option value="0" @if ($necesita_terapeuta == 0) selected @endif>No</option>
							</select>
					</div>

					<div class="form-group" id="cont_ter" style="display:none">
							<label for="ter"><u><b>Terapeuta:</b></u></label>
							<select class="form-control" name="ter[]" id="ter" onchange="guardarFormPAF(2, this.value);">
								<option value="" >Seleccione Terapeuta</option>
								@foreach( $terapeutas as $terapeuta)
									<option value="{{$terapeuta->id}}" @if ($terapeuta->id == $terapeuta_asignado) selected @endif>{{$terapeuta->nombre}}</option>
								@endforeach
							</select>
							<br>
							<label><u><b>Justificación Terapia:</b></u></label>
							<textarea class="form-control" 
							name="cas_just_terapia" id="cas_just_terapia" rows="3" onchange="guardarFormPAF(4, this.value);">@if($just_terapia) {{$just_terapia}} @endif</textarea>
					</div>

					<hr>
					<div class="form-group text-center">
							<a href="{{ route('imprimir.paf') }}/{{$caso->cas_id}}" id="imp_doc" aria-describedby="imp_doc_ayu" type="submit" class="btn btn-primary" >Imprimir Documento</a>
							<small id="imp_doc_ayu" class="form-text text-muted">*El documento debe ser firmado por la Familia del NAA y el Gestor correspondiente.</small>
					</div>

					<hr>
				
					<div class="form-group">
						<label for="sub_paf"><u><b>Adjuntar documento:</b></u></label><br>
						 <input type="file" name="archivo" id="archivo">
					</div>

					<hr>
					
						<h4><img src="/img/ico-alertas.svg" width="30px" height="30px"/> Historial Documentos PAF</h4>
								<div class="table-responsive">
									<table class="table"  style="width: 100%;" id="tabla_doc_paf" >
									<thead>
									<tr>
										<th>Fecha Creación</th>
										<th>Documento</th>
									</tr>
									</thead>
									<tbody></tbody>
									</table>
								</div>
					<hr>
					<div>
						<label for="bitacora_estado_ejecucion" style="font-weight: 800;">Bitacora Estado Actual del Caso:</label>
						<textarea class="form-control txtAreEtapa" name="bit-etapa-elaborar" id="bitacora_estado_ejecucion" rows="3" onBlur="cambioEstadoCaso(4, {{ $caso->cas_id }}, $(this).val());"
								  @if (config('constantes.en_elaboracion_paf')  != $estado_actual_caso) disabled @endif>{{ $bitacoras_estados[1] }}</textarea>
					</div>

				</form>

	     	</div>
		 </div>
			<div class="modal-footer card text-white bg-secondary">
				<button type="button" class="btn btn-warning btn-sm btnRechEst" data-dismiss="modal" onclick="comentarioEstado(1, {{ $caso->cas_id }});"
						@if (config('constantes.rechazado_por_familiares') == $estado_actual_caso || config('constantes.rechazado_por_gestor') == $estado_actual_caso) disabled @endif >
					Rechazado por Familia
				</button>
				<button type="button" class="btn btn-danger btn-sm btnRechEst" data-dismiss="modal" onclick="comentarioEstado(2, {{ $caso->cas_id }});"
						@if (config('constantes.rechazado_por_familiares') == $estado_actual_caso || config('constantes.rechazado_por_gestor') == $estado_actual_caso) disabled @endif >
					Rechazado por Gestor
				</button>
				<button type="button" id="btn-etapa-elaborar" class="btn btn-success btn-sm btnEtapa" style="float: right;" onclick="siguienteEtapa(9, {{ $caso->cas_id }});"
						@if (config('constantes.rechazado_por_familiares') == $estado_actual_caso || config('constantes.rechazado_por_gestor') == $estado_actual_caso ||
						config('constantes.en_elaboracion_paf') != $estado_actual_caso ) disabled @endif >Ir a siguiente etapa - Ejecución PAF</button>
			</div>
	   </div>
    </div>
</div>


<script type="text/javascript">

	var expanded = false;

		function showCheckboxes(elemt) {

		  var checkboxes = document.getElementById("checkboxes_"+elemt);
		  if (!expanded) {
		    checkboxes.style.display = "block";
		    expanded = true;
		  } else {
		    checkboxes.style.display = "none";
		    expanded = false;
		  }
		}

	$( document ).ready(function() {
			
		$(function() {

			$('.chkgrupfam').multiselect({

			includeSelectAllOption: false

			});

		});

		//ACORDEON OFERTA PARENTESCO

		$('.acordeon').on('click','h6',function(){
			var t = $(this);
			var tp = t.next();
			var p = t.parent().siblings().find('div');
			tp.slideToggle();
			p.slideUp();
		});

		cargarHistPaf();

		//ADJUNTAR DOCUMENTO PAF

		 $("#archivo").change(function(e) {

		// evito que propague el submit
		  e.preventDefault();
		  
		 // agrego la data del form a formData
		  var form = document.getElementById('adj_paf');
		  var formData = new FormData(form);
		 // formData.append('_token', $('input[name=_token]').val());

		 $.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			}
		 });

		 $.ajax({
		      type:'POST',
		      url: "{{ route('enviararh') }}",
		      data:formData,
		      cache:false,
		      contentType: false,
		      processData: false,
		      success:function(resp){
		      	  tabla_doc_paf.destroy();
		      	  cargarHistPaf();

		      	  if (resp.estado == 1){
                    $("#alert-exi-paf").show();
					setTimeout(function(){ $("#alert-exi-paf").hide(); }, 5000);

					}else if (resp.estado == 0){
                    $("#alert-err-paf").show();
					setTimeout(function(){ $("#alert-err-paf").hide(); }, 5000);
					}
		      },
		      error: function(jqXHR, text, error){

		          $("#alert-err-paf").show();
					setTimeout(function(){ $("#alert-err-paf").hide(); }, 5000);

		          alert('Error! No se realizo la subida del documento. Por favor intente nuevamente.');
		      }
		  });

		});

		//FIN ADJUNTAR DOCUMENTO PAF
	});

	//CARGA EL HISTORIAL PAF 
	function cargarHistPaf(){
		
			var cas_id = $("#cas_id").val();

			tabla_doc_paf = $('#tabla_doc_paf').DataTable({
			//"language" : { "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json" },
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
					"ajax": "{{ route('doc.paf') }}/"+cas_id,
					"columns": [
						{ "data": "doc_fec", "className": "text-center" },
						{ "data": "doc_paf_arch", "className": "text-center" }
					]
				});

			$(".alert").hide();

			if ($("#nec_ter").val() == 1) $("#cont_ter").css("display", "block");

	}

	function validarFrm(){
		//Validar form antes de imprimir

	}

	function activarTerapeutas(){

		let ele_sel = $("#nec_ter").val();
		let respuesta = "none";

        if (ele_sel === "" || typeof ele_sel === "undefined"){
			$("#cont_ter").css("display", "none");

		}else if (ele_sel === "0"){
			respuesta = false;
			$("#cont_ter").css("display", "none");

		}else if (ele_sel === "1"){
			respuesta = true;
			$("#cont_ter").css("display", "block");

		}

		if (respuesta == true || respuesta == false) guardarFormPAF(1, ele_sel);
	}

	function filtroOfeAsoc(){

		var chk_com	= $('input[name="ofe_id[]"]:checked');

		total = chk_com.length;

		return total;
	}

	function guardarFormPAF(option, valor){
		let data = new Object();
		data.option = option;
		data.valor = valor;
		data.caso_id = $("#cas_id").val();

		if (option == 3){ //Asignacion de ofertas x alerta
			console.log(valor);
			let des_val = valor.split("-");


			if (des_val.length < 2){
				$("#alert-err").show();
				setTimeout(function(){ $("#alert-err").hide(); }, 5000);
				return false;

			}
						
			data.ofe_id = des_val[0];
			data.ale_id = des_val[1];
			data.parent_id = des_val[2];
			var am_ofe_id = des_val[3];

			
		}
		
		if (option == 5){ //Cambia estado alerta territorial a "NO CORRESPONDE"		

			let btn_val = valor.split("-");
			data.valor= btn_val[0];
			data.btn= btn_val[1];

			var texto;

			if(data.btn==2){ texto = "descartar"; } else { texto = "habilitar"; } 

			if (confirm('¿Esta seguro que desea '+texto+' esta alerta territorial?')) {

				if(data.btn==2){

					var justificar = prompt("Favor ingrese justificación para el estado 'No corresponde'");

					var lar_text = justificar.length;

					if(lar_text<=2) { justificar=null; }

					while (!justificar) {
  						
					var justificar = prompt("Favor ingrese justificación para el estado 'No corresponde con el minimo de caracteres'");

					lar_text = justificar.length;

					if(lar_text<2) { justificar=null; }

					}
		
					data.justificar=justificar;
				}

			} else {
    			return false;
			}	
		}


		if (option == 6){  // HABILITA O DESESTIMA ASIGNACION OFERTA.

			let btn_val = valor.split("-");
			data.ofe_id = btn_val[0];
			data.ale_man_id = btn_val[1];
			data.gru_fam_id = btn_val[2];
			data.btn = btn_val[3];
			var elemt = btn_val[4];
		
			var texto;

			if(data.btn==1){ texto = "descartar"; } else { texto = "habilitar"; } 

			if (confirm('¿Esta seguro que desea '+texto+' esta oferta?')) {

				if(data.btn==1){

					var justificar = prompt("Favor ingrese justificación para el estado 'No corresponde'");

					var lar_text = justificar.length;

					if(lar_text<=2) { justificar=null; }

					while (!justificar) {
  						
					var justificar = prompt("Favor ingrese justificación para el estado 'No corresponde con el minimo de caracteres'");

					lar_text = justificar.length;

					if(lar_text<2) { justificar=null; }

					}
		
					data.justificar=justificar;
				}

			} else {
    			return false;
			}	
		}

		$.ajaxSetup({
			headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}
		});

		$.ajax({
			url: "{{ route('elaborar.paf') }}",
			type: "POST",
			data: data
		}).done(function(resp){

			if (resp.estado == 1){

				$("#alert-exi-paf").show();
				setTimeout(function(){ $("#alert-exi-paf").hide(); }, 5000);


				if(option==3){
				   $("#btn_ofe_no_"+am_ofe_id).prop('disabled', false);
				   $("#grup_fam_id_"+am_ofe_id).prop('disabled', true);   
				 }


				if(option==5){

					if(data.btn==2){
				  	$("#btn_des_"+data.valor).hide();
  					$("#btn_hab_"+data.valor).show();
  					$("#est_"+data.valor).html("No corresponde");
					$(".ofe_"+data.valor).prop('disabled', true);
					}
					else {
					$("#btn_hab_"+data.valor).hide();	
  					$("#btn_des_"+data.valor).show();
  					$("#est_"+data.valor).html("Sin Gestionar");
  					$(".ofe_"+data.valor).prop('disabled', false);
					}

				}

				if(option==6){

					if(data.btn==1){
				  	// $("#btn_ofe_no_"+elemt).hide();
  					// $("#btn_ofe_hab_"+elemt).show();

  					$("#btn_ofe_no_"+elemt).prop('disabled', true);

					}
					else {
					// $("#btn_ofe_hab_"+elemt).hide();	
  			// 		$("#btn_ofe_no_"+elemt).show();
					}

				}

			}else if (resp.estado == 0){

				$("#alert-err-paf").show();
				setTimeout(function(){ $("#alert-err-paf").hide(); }, 5000);

			}
		}).fail(function(obj){
			//console.log("03");
			console.log(obj); return false;

			//$("#alert-err").show();
			//setTimeout(function(){ $("#alert-err").hide(); }, 5000);

		});
	}
</script>
