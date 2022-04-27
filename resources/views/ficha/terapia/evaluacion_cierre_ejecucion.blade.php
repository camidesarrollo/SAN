<div class="container">
	 <div class="row">
		<div class="col-md-12 col-lg-6 text-center">
			<br>
			<!-- <a href="{{ route('gestion-terapia-familiar.evaluacion',[ 'tera_id' => $nna_teparia->tera_id, 'run_sin_formato' => $run, 'run_con_formato' => $run_terapia_formateado]) }}" class="btn" style="background: #fff; border: 1px solid #01e0bc; color: #01e0bc;"><i class="fas fa-check-circle"></i> Aplicar Evaluación</a> -->
			<a href="{{ route('gestion-terapia-familiar.evaluacion',[ 'tera_id' => $nna_teparia->tera_id, 'run_sin_formato' => $run, 'run_con_formato' => $run_terapia_formateado]) }}" class="btn" style="background: #fff; border: 1px solid #01e0bc; color: #01e0bc;"><i class="fas fa-check-circle"></i> Aplicar Evaluación</a>
			<!--<a href="#" class="btn" style="background: #fff; border: 1px solid #01e0bc; color: #01e0bc;"><i class="fas fa-check-circle"></i> Aplicar Evaluación Cierre</a>-->
		</div>
		<div class="col-md-12 col-lg-6 text-center">
			<br>
			@if($evaluacion_cierre_realizada == 1)
				<a class="btn" style="background: #01e0bc; color: #fff;">Realizado</a>
			@elseif ($evaluacion_cierre_realizada == 0)
				<a class="btn" style="background: #01e0bc; color: #fff;">No realizado</a>
			@endif
			<!--<div id="val_diag_ncfas" class="alert alert-secondary text-danger p-1" style=" display: none;">
				<small>* Falta completar este item.</small>
			</div>-->
    	</div>
	</div>
</div>