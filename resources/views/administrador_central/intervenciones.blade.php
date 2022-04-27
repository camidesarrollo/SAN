@extends('layouts.main')

@section('contenido')

	<section class="p-1 cabecera">
		<div class="container-fluid">
			<div class="row align-items-center">
				<div class="col-md-12">
					<h5> <i class="{{$icono}}"></i> Intervenciones</h5>
				</div>
			</div>
		</div>
	</section>
	@if (Session::get('perfil') == config('constantes.perfil_coordinador_regional'))
	
	@php
	$n = 3
	@endphp

	@elseif (Session::get('perfil') == config('constantes.perfil_coordinador'))
	
		@php
		$n = 3
		@endphp
	
        
	@elseif(Session::get('perfil') == config('constantes.perfil_administrador_central'))
		
		@php
		$n = 2
		@endphp
	
	
	@endif

	<section>
		<div class="container-fluid">
			<div class="card p-4 shadow-sm">
				
				<table class="table table-hover table-striped">
					<thead>
							<tr>
								<th colspan="12">
									<div class="row justify-content-center">
										<div class="col-md-{{$n}}">
										 <label>Fecha inicio: </label>
									        <div class="input-group date-pick" id="int_start_date_" data-target-input="nearest">
												<input onkeypress='return caracteres_especiales_fecha(event)' type="text" name="int_start_date" class="form-control datetimepicker-input"  data-target="#int_start_date_" id="int_start_date"  value="">
												<div class="input-group-append" data-target="#int_start_date_" data-toggle="datetimepicker">
													<div class="input-group-text"><i class="fa fa-calendar"></i></div>
												</div>
											</div>
											<p id="val_int_start_date" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar una Fecha Valida.</p>  
										</div>
										<div class="col-md-{{$n}}">
											    <label>Fecha Fin</label>
										        <div class="input-group date-pick" id="int_end_date_" data-target-input="nearest">
													<input onkeypress='return caracteres_especiales_fecha(event)' type="text" name="int_end_date" class="form-control datetimepicker-input"  data-target="#int_end_date_" id="int_end_date"  value="">
													<div class="input-group-append" data-target="#int_end_date_" data-toggle="datetimepicker">
														<div class="input-group-text"><i class="fa fa-calendar"></i></div>
													</div>
												</div>
												<p id="val_int_end_date" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar una Fecha Valida.</p>  
								    	</div>
								    	<div class="col-md-{{$n}}">
										     	<label>Estado Caso</label>
							                    <select class="form-control" id="estado_caso" name="estado_caso">
							                        <option value="">Estado Caso</option>
							                         <?php 
							                             foreach($estado_caso as $est_cas) {
							                                $selected ="";
							                                echo "<option value='{$est_cas->est_cas_id}' {$selected}>".$est_cas->est_cas_nom."</option>";
							                             }
							                         ?>  
							                    </select>
						                </div>
						                <div class="col-md-{{$n}}">
										     	<label>Estado Tarea</label>
							                    <select class="form-control" id="estado_tarea" name="estado_tarea">
							                        <option value="">Estado Tarea</option>
							                         <?php 
							                             foreach($estado_tarea as $est_tar) {
							                                $selected ="";
							                                echo "<option value='{$est_tar->est_tar_id}' {$selected}>".$est_tar->est_tar_nom."</option>";
							                             }
							                         ?>  
							                    </select>
						                </div>
						                @if (Session::get('perfil') == config('constantes.perfil_administrador_central') || Session::get('perfil') == config('constantes.perfil_coordinador_regional'))
						                <div class="col-md-3">
										     	<label>Comunas</label></br>
							                    <select class="form-control chkcom" id="comunas" multiple="multiple" name="comunas" style="background-color:#fff;">
							                         <?php
									    foreach (session()->all()["comunas"] AS $c1 => $v1): ?>
								    		<option value="<?php echo $v1->com_id; ?>" 
								    			<?php 
								    			if(Session::get('com_id')==$v1->com_id){ echo"selected"; }?>>
								    			<?php echo $v1->com_nom; ?>
								    		</option>
								    	<?php endforeach ?>
							                    </select>
						                </div>
						                @endif 
								    </div>
								    <div class="row">
											    <div class="col-lg-12 mt-3 mr-3">
											        <button id="btnLimpiar" class="btn btn-info float-right">Limpiar</button>

											        <button class="btn btn-success float-right mr-3" id="xls_intervenciones" onclick="descargarIntervenciones()" name="xls_alertas">
						   								<i class="fas fa-download"></i> Descargar
													</button>
											    </div>
										</div>
								    <br>
								</th>
							</tr>
					</thead>
				</table>

			</div>
		</div>
	</section>
	@stop
@section('script')
	<script type="text/javascript">
		$(document).ready( function () {

			var int_date = new Date();
			var int_firstDay = new Date(int_date.getFullYear(), int_date.getMonth(), 1);

			$('#int_start_date_').datetimepicker({
				locale: 'es',
				// maxDate: $.now(),
				minDate: new Date('2019/06/01'),
				defaultDate: int_firstDay,
				format: 'DD/MM/Y'
			});

			$('#int_end_date_').datetimepicker({
				locale: 'es',
				maxDate: $.now(),
				minDate: new Date('2019/06/01'),
				defaultDate: $.now(),
				format: 'DD/MM/Y'
			});

			$('.chkcom').multiselect({

	        includeSelectAllOption: true,
	        maxHeight: 400


	   		 });

			$(".btn-group").css({'background-color':'#fff'});

			$("#btnLimpiar").click(function(){
		        
		        $('#estado_caso').val('');
		        $('#estado_tarea').val('');
		        $('#comunas option:selected').each(function() {
			        $(this).prop('selected', false);
			    })
			    $('#comunas').multiselect('refresh');
		    });

		});


		function descargarIntervenciones() {
			// Data to post
				let val = validFecha();
				if(!val) return false;
				let ex_int_start_date = $('#int_start_date').val();
				let ex_int_end_date = $('#int_end_date').val();
				let ex_estado_caso = $('#estado_caso').val();
				let ex_comunas = $('#comunas').val();

				var params = 'int_start_date='+ ex_int_start_date +'&int_end_date='+ex_int_end_date+'&estado_caso='+ex_estado_caso +'&comunas='+ex_comunas;

				// Use XMLHttpRequest instead of Jquery $ajax
				xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function() {
					var a;
					if (xhttp.readyState === 4 && xhttp.status === 200) {
						// Trick for making downloadable link
						a = document.createElement('a');
						a.href = window.URL.createObjectURL(xhttp.response);
						// Give filename you wish to download
						a.download = 'Intervenciones_'+ex_int_start_date+'_'+ex_int_end_date+'_.xlsx';
						a.style.display = 'none';
						document.body.appendChild(a);
						a.click();
					}
				};
				// Post data to URL which handles post request
				xhttp.open("GET", '{{route('ExcelIntervenciones')}}?'+params,true);
				xhttp.setRequestHeader("Content-Type", "application/json");
				// You should set responseType as blob for binary responses
				xhttp.responseType = 'blob';
				xhttp.send(null);
		};

	function validFecha(){
		let respuesta = true;
		let ex_int_start_date = $('#int_start_date').val();
		let ex_int_end_date = $('#int_end_date').val();
		let ex_comunas = $('#comunas').val();

		if (ex_int_start_date == "" || typeof ex_int_start_date === "undefined"){
                respuesta = false;
                $("#int_start_date").addClass("is-invalid");
		}else{
			if (!validarFormatoFecha(ex_int_start_date)){
				respuesta = false;
				$("#int_start_date").addClass("is-invalid");
			}else if (!existeFecha(ex_int_start_date)){
				respuesta = false;
				$("#int_start_date").addClass("is-invalid");
			}else{
				$("#int_start_date").removeClass("is-invalid");
			}
		}

		if (ex_int_end_date == "" || typeof ex_int_end_date === "undefined"){
                respuesta = false;
                $("#int_end_date").addClass("is-invalid");
		}else{
			if (!validarFormatoFecha(ex_int_end_date)){
				respuesta = false;
				$("#int_end_date").addClass("is-invalid");
				
			}else if (!existeFecha(ex_int_end_date)){
				respuesta = false;
				$("#int_end_date").addClass("is-invalid");
			}else{
				$("#int_end_date").removeClass("is-invalid");
			}
		}

		if(!respuesta) mensajeTemporalRespuestas(0, 'Ingrese una Fecha Válida');
		
		return respuesta;
	}
	</script>
@endsection