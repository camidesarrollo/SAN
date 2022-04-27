<div class="container">
	@if ($modo_visualizacion == 'visualizacion')
		<div class="form-group row">            
		<!-- inicio ch 
		        <label class="col-6 col-form-label">N° de Sesiones Familiares Comprometidas: <span class="badge badge-primary" id="num_ses_fam"></span></label>
				<label class="pr-2" style="font-size: 1rem;">Nº de Sesiones Familiares Comprometidas:</label> 
					<select id="ter_com_fir" style="width: 60;" onchange="registrarNumeroSesionesTFComprometidas();">
						<option value="0">0</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>
						<option value="7">7</option>
						<option value="8">8</option>
					</select>
					Fin ch  -->
					<!-- INICIO CZ SPRINT 69 -->
					@if($nna_teparia->flag_modelo_terapia == 1)
					<label class="pr-2" style="font-size: 1rem;">Nº de Sesiones Familiares Comprometidas: <span class="badge badge-primary">{{$ter_com_fir}}</span></label>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="pr-2" style="font-size: 1rem;">Nº de Sesiones Multifamiliares Comprometidas: <span class="badge badge-primary">4</span></label>
					@elseif($nna_teparia->flag_modelo_terapia == 2)    
					<label class="pr-2" style="font-size: 1rem;">Nº de Sesiones Familiares Comprometidas: <span class="badge badge-primary">{{$ter_com_fir}}</span></label>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="pr-2" style="font-size: 1rem;">Nº de Sesiones Multifamiliares Comprometidas: <span class="badge badge-primary">3</span></label>  
					@endif   
					<!-- FIN CZ SPRINT 69 -->    
    	</div>		
		<div class="border p-3 bg-light text-center">
				<!-- INICIO CZ SPRINT 74 -->
				<label>Descargue el Plan de Terapia Familiar para este caso haciendo <a href="../../documentos/{{ config('constantes.firma_plan_terapia_familiar_2021')  }}" class="text-primary"> Click aquí.</a></label>
				<!-- FIN CZ SPRINT 74 -->
			</div>
			
	@elseif ($modo_visualizacion == 'edicion')
		<form enctype="multipart/form-data" name="enviar_firma_plan" id="enviar_firma_plan" method="post">
			{{ csrf_field() }}
			<div class="alert alert-success alert-dismissible fade show" id="firma_plan_exitoso" role="alert" style="display:none;">
					Documento subido satisfactoriamente.
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
			</div>
			<div class="aler2 alert-info alert-dismissible fade show" id="firma_plan_error" role="alert" style="display:none;">
					Error al momento de subir el documento. Por favor intente nuevamente.
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
			</div>

			<div class="row align-items-center mb-5">
				<!-- // INICIO CZ SPRINT 69 -->
				@if($nna_teparia->flag_modelo_terapia == 1)
				<!-- // FIN CZ SPRINT 69 -->
				<div class="col-sm-6">
					<label class="pr-2" style="font-size: 1rem;">Nº de Sesiones Familiares Comprometidas:</label> 
					<select id="ter_com_fir" style="width: 60;" onchange="registrarNumeroSesionesTFComprometidas();">
						<option value="0">0</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>
						<option value="7">7</option>
						<option value="8">8</option>
					</select>
				</div>
				<div class="col-sm-6">
					<label class="pr-2" style="font-size: 1rem;">Nº de Sesiones Multifamiliares Comprometidas: <span class="badge badge-primary">4</span></label>	
		        </div>                              
				<!-- // INICIO CZ SPRINT 69 -->
				@elseif($nna_teparia->flag_modelo_terapia == 2)
				<div class="col-sm-6">
					<label class="pr-2" style="font-size: 1rem;">Nº de Sesiones Familiares Comprometidas:</label> 
					<select id="ter_com_fir" style="width: 60;" onchange="registrarNumeroSesionesTFComprometidas();">
						<!-- <option value="0">0</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option> -->
						<option value="7">7</option>
						<option value="8">8</option>
						<option value="9">9</option>
					</select>
				</div>
				<div class="col-sm-6">
					<label class="pr-2" style="font-size: 1rem;">Nº de Sesiones Multifamiliares Comprometidas: <span class="badge badge-primary">3</span></label>	
		        </div>  
				@endif      
				<!-- // INICIO CZ SPRINT 69 -->            
    		</div>

			<div class="row">
				<div class="col-6">
					<div class="border p-3 bg-light form-group">
							<div class="row">
								<dt class="col-sm-1"> <h4><span class="badge badge-secondary">a</span></h4></dt>
								<dd class="col-sm-11"> 
									<p>Descargue el siguiente documento con el Plan de Terapia Familiar para que la familia involucrada firme voluntariamente</p>
									<!-- INICIO CZ SPRINT 74 -->
									<a href="../../documentos/{{ config('constantes.firma_plan_terapia_familiar_2021')  }}" id="" aria-describedby="" class="btn btn-primary" ><i class="fa fa-print"></i> Descargar Documento</a>
									<!-- FIN CZ SPRINT 74 -->
									<small id="imp_doc_ayu" class="form-text text-muted">*El documento debe ser firmado por los integrantes que participarán de la terapia y el terapeuta correspondiente.</small>
								</dd>
							</div>
					</div>
				</div>
				<div class="col-6">
					<div class="border p-3 bg-light form-group">
							<div class="row">
								<dt class="col-sm-1"><h4> <span class="badge badge-secondary">b</span></h4></dt>
								<dd class="col-sm-11">
									<p>Una vez firmado el documento con el Plan de Terapia Familiar por los involucrados, debe ser digitalizado (escaneo o fotografía) para volver a cargarlo al sistema por este conducto</p>
									<p>Cargar Documento</p>

									<div class="btn btn-primary">
										<input type="file" class="form-control-file" name="file_firma_plan" id="file_firma_plan"  @if (config('constantes.gtf_diagnostico')  != $estado_actual_terapia) disabled @endif>
										<input type="hidden" name="fir_tera_id" id="fir_tera_id" value="{{ $nna_teparia->tera_id }}">
										<input type="hidden" name="doc_fir_pla_ter_id" id="doc_fir_pla_ter_id" value="">
									</div>
								</dd>
							</div>
					</div>
				</div>
			</div>
		</form>
	@endif	
</div>
<script type="text/javascript">

	$("#file_firma_plan").change(function(e){
	  $('#enviar_firma_plan').submit();
	});

	$("#enviar_firma_plan").submit(function(e){

		bloquearPantalla();

   	  	e.preventDefault();

   	  	let form = document.getElementById('enviar_firma_plan');
		let formData = new FormData(form);

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			}
		});

		$.ajax({
	      type: 'post',
	      url: "{{ route('guardar.documento.plan.terapia') }}",
	      data: formData,
	      cache: false,
	      contentType: false,
	      processData: false,
	      success:function(resp){	

	      	desbloquearPantalla();

		    if (resp.estado == 1){
		  		$("#firma_plan_error").hide();

		  		$("#firma_plan_exitoso").show();

		  		buscarHistorialPlanTerapiaFamiliar($('#fir_tera_id').val());
		        setTimeout(function(){ $("#firma_plan_exitoso").hide(); }, 5000);

			}else if (resp.estado == 0){
				$("#firma_plan_exitoso").hide();

		  		$("#firma_plan_error").show();
		        setTimeout(function(){ $("#firma_plan_error").hide(); }, 5000);
			}
	      },
	      error: function(jqXHR, text, error){

	      	desbloquearPantalla();
	      	
	      	$("#firma_plan_exitoso").hide();

	  		$("#firma_plan_error").show();
	        setTimeout(function(){ $("#firma_plan_error").hide(); }, 5000);

	      	console.log(jqXHR, text, error);
		          // toastr.error('Validation error!', 'No se pudo Añadir los datos<br>' + error, {timeOut: 5000});
	      }
		});
   	});


   	function registrarNumeroSesionesTFComprometidas(){
   		let valor = $("#ter_com_fir").val();

		//console.log(valor);
   		if (typeof valor === 'undefined' || valor == "" || valor == null){
   			return false;
		}

   		bloquearPantalla();

   		let data = new Object();
   		data.ter_com_fir = valor;
   		data.tera_id = $("#tera_id").val();


   		$.ajaxSetup({
    		headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
   	 		}
        });
        
        $.ajax({
            type: "POST",
            url: "{{ route('terapias.comprometidas') }}",
            data: data
        }).done(function(resp){
            desbloquearPantalla();

            if(resp.estado == 1){
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
	   //inicio ch
	function verSesionesTerapia(){
		$.ajax({
			type: "GET",
			url: "{{ route('verterapias.comprometidas') }}",
			data: {'tera_id': $("#tera_id").val()}
		}).done(function(resp){
			$(`#ter_com_fir option[value='${resp}']`).attr("selected", true);
			$('#num_ses_fam').text(resp);
		}).fail(function(objeto, tipoError, errorHttp){
            desbloquearPantalla();

            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

            return false;
        });
	}
	//fin ch
</script>	
