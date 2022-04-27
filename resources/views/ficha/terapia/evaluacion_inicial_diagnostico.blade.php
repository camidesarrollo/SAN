<div class="container">
	 <div class="row">
		<div class="col-md-12 col-lg-6 text-center">
			<br>
			<!-- <a href="{{ route('gestion-terapia-familiar.evaluacion',[ 'tera_id' => $nna_teparia->tera_id, 'run_sin_formato' => $run, 'run_con_formato' => $run_terapia_formateado]) }}" class="btn" style="background: #fff; border: 1px solid #01e0bc; color: #01e0bc;"><i class="fas fa-check-circle" ></i> Aplicar Evaluación</a> -->
			<a id="boton-EvaluacionTF" href="{{ route('gestion-terapia-familiar.evaluacion',[ 'tera_id' => $nna_teparia->tera_id, 'run_sin_formato' => $run, 'run_con_formato' => $run_terapia_formateado]) }}" 
			 class="btn" style="background: #fff; border: 1px solid #01e0bc; color: #01e0bc; display:none"><i class="fas fa-check-circle" ></i> Aplicar Evaluación</a>
			 <a id="boton-validación" onclick="validacionEvaluacion()"    
			 class="btn" style="background: #fff; border: 1px solid #01e0bc; color: #01e0bc;"><i class="fas fa-check-circle" ></i> Aplicar Evaluación</a>

			<input id="inputHiddendef_pro_preg_1" type="hidden">
			<!--<a href="#" class="btn" style="background: #fff; border: 1px solid #01e0bc; color: #01e0bc;"><i class="fas fa-check-circle"></i> Aplicar Evaluación Inicial</a>-->
		</div>
		<div class="col-md-12 col-lg-6 text-center">
			<br>
			@if($evaluacion_inicial_realizada == 1)
				<a class="btn" style="background: #01e0bc; color: #fff;">Realizado</a>
			@elseif ($evaluacion_inicial_realizada == 0)
				<a class="btn" style="background: #01e0bc; color: #fff;">No realizado</a>
			@endif
			<!--<div id="val_diag_ncfas" class="alert alert-secondary text-danger p-1" style=" display: none;">
				<small>* Falta completar este item.</small>
			</div>-->
    	</div>
	</div>
</div>
<script>


$( "#btn_evaluacion_inicial_diagnostico" ).click(function() {
	let data = new Object();
	data.tera_id = {{"$nna_teparia->tera_id"}};
	$.ajax({
	      url: "{{ route('buscar.definicion.problema') }}",
	      type: "GET",
	      data: data
	    }).done(function(resp){
			console.log(resp);
	    	if (resp.estado == 1){
	    		if (resp.respuesta.length > 0){
					$("#inputHiddendef_pro_preg_1").val(resp.respuesta[0].def_pro_preg_1);
					if($("#inputHiddendef_pro_preg_1").val() == ""){
						$("#boton-validación").css("display", "initial");
						$("#boton-EvaluacionTF").css("display", "none");
					}else{
						$("#boton-EvaluacionTF").css("display", "initial");
						$("#boton-validación").css("display", "none");
					}
				}else{
					$("#boton-validación").css("display", "initial");
						$("#boton-EvaluacionTF").css("display", "none");
				}
	    	}
	    }).fail(function(obj){
	    });

});
</script>
<script>
function validacionEvaluacion(){
	if($("#inputHiddendef_pro_preg_1").val() == ""){
		toastr.error("Debe ingresar Motivo de la TF para aplicar Evaluacion Inicial");
		$("#boton-validación").css("display", "initial");
		$("#boton-EvaluacionTF").css("display", "none");
	}
}
</script>