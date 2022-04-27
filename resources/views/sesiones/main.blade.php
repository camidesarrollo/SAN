@extends('layouts.main')

@section('contenido')
	
	<section class="p-1 cabecera">
		<div class="container-fluid">
			<div class="row align-items-center">
				<div class="col-md-12">
					<h2><span class="oi oi-list"></span> Diseñar Plan de Acción Individual</h2>
				</div>
			</div>
		</div>



	</section>
	
	<section>
		<div class="container-fluid">
			<div class="row align-items-center">
				<div class="col-md-12 p-3">
					
					<div class="card p-4">
						<div class="row">
							
							<div class="col">
								<h6>Nombre</h6>
								<h4><strong>{{ $caso->persona->nombres }}</strong></h4>
							</div>
							<div class="col-4">
								<h6>RUT</h6>
								<h4><strong>{{ $caso->persona->rut }} {{ @$pedro }}</strong></h4>
							</div>
						
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>


	<section>
		<div class="container-fluid">
			<div class="card p-3">

				{{--<div class="table-responsive">--}}
                <div class="row" style="padding-bottom: 5px;">
					<div class="col-6" style="padding-top: 8px;"><p style="margin: 0;">Seleccione la sesión que desea planificar</p></div>
				<!-- 	<div class="col-6 text-right"><button class="btn btn-default" type="button" @if ($val_btn_agr == false) disabled @endif onclick="valSesionesIndividuales(this, {{ @$caso->cas_id }});">Agregar Sesión</button></div> -->
				</div>

				<div>
					{{ csrf_field() }}
					<input type="hidden" value="{{ @$caso->cas_id }}" id="cas_id" name="cas_id" >
					<input type="hidden" value="I" id="ses_tip" name="ses_tip" >
					<input type="hidden" id="val_ind_nna" name="val_ind_nna" value="{{  route('sesiones.individuales.validar') }}">

					<table id="table_sesiones" class="table table-bordered tablas" data-crear-href="{{ route('sesiones.grabar',['caso'=>$caso->cas_id]) }}">
						<thead>
						<tr class="text-center">
							<th>Sesiones</th>
							<th>Fecha</th>
							<th>Estado</th>
							<th>Gestión</th>
							<th>Bitácora</th>
						</tr>
						</thead>
						<tbody>

						@for ($i = 0; $i < $can_ses; $i++)
							@php( $sesion = $sesiones->where('ses_num',$i + 1)->first() )

							<?php //dd($sesion->estados[0]); ?>

							<tr data-ses-num="{{ $i+1 }}" data-ses-id="{{ @$sesion->ses_id }}" class="{{ @$sesion->clase }}">
								<td class="align-middle">Sesión {{ $i + 1 }}</td>
								
								@if( $sesiones->where('ses_num',$i + 1)->count() > 0 )
									<td class="align-middle text-right">{{ $sesion->fecha }}</td>
									<td class="align-middle text-center"> -{{ $sesion->estados[0]->nombre }}</td>
									<td class="align-middle text-center">
										@if( $caso->estados[0]->est_cas_nom!='Derivado')
											<button class="btn btn-primary btnShow" type="button" >
												Modificar
											</button>
										@else
											<button class="btn btn-primary btnShow" type="button" >
												Modificar
											</button>
										@endif
									</td>
					
								
								{{--@elseif( $caso->estados[0]->est_cas_nom=='Derivado')
									<td class="align-middle">{{ @$sesion->fecha }}</td>
									<td class="align-middle">{{ @$sesion->estados[0]->nombre }} --> 2 </td>
									<td class="align-middle"></td>--}}
								@else
									<td class="align-middle text-right">
										<div class="input-group date" id="fecha{{ $i+1 }}" data-target-input="nearest">
											<input required name="ses_fec" type="text" class="form-control datetimepicker-input" data-target="#fecha{{ $i+1 }}"/>
											<div class="input-group-append " data-target="#fecha{{ $i+1 }}" data-toggle="datetimepicker">
												<div class="input-group-text"><i class="fa fa-calendar"></i></div>
											</div>
										</div>
									</td>
									<td class="align-middle text-center">{{ config('constantes.sesion_sin_estado','') }}</td>
									<td class="align-middle text-center">
										<button class="btn btn-primary btnSelect" type="button" >
											Planificar
										</button>
										<button class="btn btn-primary btnShow" type="button" hidden>
											Modificar
										</button>
									</td>
								@endif

								<td class="align-middle">
									<span class="oi oi-loop-square">
											
									<a href="#" id="{{ $i }}"  class="hist_est" > - Abrir</a>

									</span>
							</tr>
							<tbody class="text-left" id="est_ses_{{ $i }}"  style="display:none; background-color: #58D68D">
							<tr >
								<td>Estado</td>
								<td colspan="2">Observación</td>
								<td>Diagnostico</td>
								<td>Fecha</td>
							</tr>

							<?php $vacio=0;  ?>

							@if(isset($sesion->ses_id))

								@foreach ($tot_bit_ses as $bit_ses)
				
									@if($bit_ses->ses_id==$sesion->ses_id)

									<?php $vacio=1; ?>

									<tr style="background-color: #ABEBC6">
									@if($bit_ses->est_ses_id==1)
										<td>Planificada</td>
									@elseif($bit_ses->est_ses_id==2)
										<td>Finalizada</td>
									@elseif($bit_ses->est_ses_id==6)
										<td>Inasistencia</td>
									@elseif($bit_ses->est_ses_id==7)
										<td>Inubicable</td>
									@endif
									<td colspan="2" style="max-width:200px;">
										{{ $bit_ses->ses_obs }}
									</td>
									<td style="max-width:100px;">
										{{ $bit_ses->ses_dia }}
									</td>
									<td>{{ $bit_ses->ses_est_ses_fec }}</td>
									</tr>
									@endif
								@endforeach

								@if($vacio==0)
								<tr style="background-color: #ABEBC6">
									<td  colspan="5"> No existen datos </td>
								</tr>
								@endif

							@endif

								<?php $vacio=0; ?>

							</tbody>

						@endfor
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</section>

	<!--Sesiones de seguimiento -->
	<section>
		<div class="container-fluid" @if($val_ses_adi == false) style="display: none;" @endif>
			<div class="card p-3">
				 <h5>Sesiones de seguimiento</h5>

				 <div>
					 {{ csrf_field() }}
					 <input type="hidden" id="ses_tip_seg" name="ses_tip_seg" value="C">

					 <table id="table_sesiones_seguimiento" class="table table-bordered tablas" data-crear-href="{{ route('sesiones.grabar',['caso'=>$caso->cas_id]) }}">
                         <thead>
						   <tr class="text-center">
							   <th>Sesiones</th>
							   <th>Fecha</th>
							   <th>Estado</th>
							   <th>Gestión</th>
						   </tr>
					     </thead>
						 <tbody>


						 @for ($n=0; $n < $can_ses_seg; $n++)
							 @php( $sesion_seguimiento = $lis_ssg_est->where('ses_num',$n + 1)->first() )
							 <tr data-ses-num="{{ $n+1 }}" data-ses-id="{{ @$sesion_seguimiento->ses_id }}" class="{{ @$sesion_seguimiento->clase }}">
							   <td class="align-middle">Sesión de seguimiento {{ $n+1 }}</td>

							   @if ( $lis_ssg_est->where('ses_num', $n + 1)->count() > 0 )
									 <td class="align-middle text-right">{{ $sesion_seguimiento->fecha }}</td>
									 <td class="align-middle text-center">{{ $sesion_seguimiento->estados[0]->nombre }}</td>
									 <td class="align-middle text-center">
										 @if( $sesion_seguimiento->estados[0]->est_cas_nom!='Derivado')
											 <button class="btn btn-primary btnShow" type="button" >
												 Modificar
											 </button>
										 @else
											 <button class="btn btn-primary btnShow" type="button" >
												 Modificar
											 </button>
										 @endif
									 </td>
								@else
									 <td class="align-middle text-right">
										 <div class="input-group date" name="fec_ses_seg" id="fecha{{ $n+1 }}" data-target-input="nearest">
											 <input required name="ses_fec" type="text" class="form-control datetimepicker-input" data-target="#fecha{{ $n+1 }}"/>
											 <div class="input-group-append " data-target="#fecha{{ $n+1 }}" data-toggle="datetimepicker">
												 <div class="input-group-text"><i class="fa fa-calendar"></i></div>
											 </div>
										 </div>
									 </td>
									 <td class="align-middle text-center">{{ config('constantes.sesion_sin_estado','') }}</td>
									 <td class="align-middle text-center">
										 <button class="btn btn-primary btnSelect" type="button" >
											 Planificar
										 </button>
										 <button class="btn btn-primary btnShow" type="button" hidden>
											 Modificar
										 </button>
									 </td>
								@endif
						     </tr>
						 @endfor
						 </tbody>
					 </table>
				 </div>
			</div>
		</div>
	</section>

	<!-- Sesiones de retroalimentación -->
	<section>
		<div class="container-fluid" @if($val_ses_adi == false) style="display: none;" @endif>
			<div class="card p-3">
				<h5>Sesiones de retroalimentación y egreso</h5>

				<div>
					{{ csrf_field() }}
					<input type="hidden" id="ses_tip_ret" name="ses_tip_ret" value="R">

					<input type="hidden" id="blockear_mod" name="blockear_mod" value="1">

					<table id="table_sesiones_retroalimentacion" class="table table-bordered tablas" data-crear-href="{{ route('sesiones.grabar',['caso'=>$caso->cas_id]) }}">
						<thead>
						<tr class="text-center">
							<th>Sesiones</th>
							<th>Fecha</th>
							<th>Estado</th>
							<th>Gestión</th>
						</tr>
						</thead>
						<tbody>
						@for ($l=0; $l < $can_ses_ret; $l++)
							@php( $sesion_retroalimentacion = $lis_srt_est->where('ses_num',$l + 1)->first() )
							<tr data-ses-num="{{ $l+1 }}" data-ses-id="{{ @$sesion_retroalimentacion->ses_id }}" class="{{ @$sesion_retroalimentacion->clase }}">
								<td class="align-middle">Sesión de retroalimentación y egreso {{ $l+1 }}</td>

								@if ( $lis_srt_est->where('ses_num', $l + 1)->count() > 0 )
									<td class="align-middle text-right">{{ $sesion_retroalimentacion->fecha }}</td>
									<td class="align-middle text-center">{{ $sesion_retroalimentacion->estados[0]->nombre }}</td>
									<td class="align-middle text-center">
										@if( $sesion_retroalimentacion->estados[0]->est_cas_nom!='Derivado')
											<button class="btn btn-primary btnShow" type="button" >
												Modificar
											</button>
										@else
											<button class="btn btn-primary btnShow" type="button" >
												Modificar
											</button>
										@endif
									</td>
						        @else
									<td class="align-middle text-right">
										<div class="input-group date" name="fec_ses_ret" id="fecha{{ $l+1 }}" data-target-input="nearest">
											<input required name="ses_fec" type="text" class="form-control datetimepicker-input" data-target="#fecha{{ $l+1 }}"/>
											<div class="input-group-append " data-target="#fecha{{ $l+1 }}" data-toggle="datetimepicker">
												<div class="input-group-text"><i class="fa fa-calendar"></i></div>
											</div>
										</div>
									</td>
									<td class="align-middle text-center">{{ config('constantes.sesion_sin_estado','') }}</td>
									<td class="align-middle text-center">
										<button class="btn btn-primary btnSelect" type="button" >
											Planificar
										</button>
										<button class="btn btn-primary btnShow" type="button" hidden>
											Modificar
										</button>
									</td>
							    @endif
							</tr>
						@endfor
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</section>



@endsection

@section('script')
	
	<script type="text/javascript">

		$(".hist_est").click(function(){
	        
	        var id_sesion = $(this).attr("id");

	        if($("#"+id_sesion).text()==' - Cerrar'){
	        	$("#"+id_sesion).text(' - Abrir');
	        }else{
	        	$("#"+id_sesion).text(' - Cerrar');
	        }

	        $('#est_ses_'+id_sesion).toggle();
	        
	    });

		function crearSesion(param){
			// get the current row
			let boton = $(this);
			let currentRow=$(this).closest("tr");
			let sesion = {
				cas_id: $('#cas_id').val(),
				_token: $('[name=_token]').val(),
				ses_fec: currentRow.find("td:eq(1) input").val(),
				ses_num: currentRow.data('ses-num')
			};

			switch(param.data.tip_ses){
				case 'I': //Sesion Individual
					var url = $('#table_sesiones').data('crear-href');
					sesion.ses_tip = $('#ses_tip').val();

				break;

				case 'C': //Sesion Seguimiento
					var url = $('#table_sesiones_seguimiento').data('crear-href');
					sesion.ses_tip = $('#ses_tip_seg').val();

				break;

				case 'R': //Sesion Retroalimentación
					var url = $('#table_sesiones_retroalimentacion').data('crear-href');
					sesion.ses_tip = $('#ses_tip_ret').val();

				break;
			}

			$.ajax({
				type: "POST",
				url: url,
				data: JSON.stringify(sesion),
				dataType: 'json',
				contentType: 'application/json; charset=utf-8',
				error: function(obj)
				{
					let resp = JSON.parse(obj.responseText);
					let errores = resp.errors;
					
					if (resp.errors) {
						//console.log('entro2')
						let txt = "<ul>"
						for (x in errores) {
							for (y in errores[x]){
								txt += '<li>' + errores[x][y] + '</i>'
								//console.log(errores[x][y])
							}
						}
						txt += "</ul>";

						$('#msjInfo').empty();
						$('#msjInfo').html(txt);
						$('#modalMsj').modal('show');
					}else {
						if (resp.mensaje) {
							$('#msjInfo').empty();
							$('#msjInfo').html(resp.mensaje);
							$('#modalMsj').modal('show');
						}
						else {
							$('#msjInfo').empty();
							$('#msjInfo').html('Ocurrio un Error Inesperado');
							$('#modalMsj').modal('show');
						}
					}
				},
				success: function(obj) {
					$('#msjInfo').html(obj.mensaje);
					$('#modalMsj').modal('show');
					
					if (obj.estado == '1') {
						currentRow.find("td:eq(1) input").prop( "disabled", true );
						currentRow.find("td:eq(3) button").prop( "hidden", false );
						boton.prop( "disabled", true );
						boton.hide();
						sesion = JSON.parse(obj.sesion);
						sesion_estado = JSON.parse(obj.sesion_estado);
						currentRow.data('ses-id',sesion.ses_id);
						currentRow.find("td:eq(2)").html(sesion_estado.nombre);
						currentRow.find("td:eq(1)").html(sesion.fecha);
						currentRow.addClass(sesion.clase);
					}
				}
			});
		}

		function showFrmSesion(param){
			let currentRow=$(this).closest("tr");
			let id = currentRow.data('ses-id') || 0;
			let titulo = "";
			let datos = {};

			switch(param.data.tip_ses){
				case 'I': //Sesion Individual
				  var url = $('#table_sesiones').data('crear-href') + '/' + id;

				break;

				case 'C': //Sesion Seguimiento
				  var url = $('#table_sesiones_seguimiento').data('crear-href') + '/' + id;

				break;

				case 'R': //Sesion Retroalimentación
				  var url = $('#table_sesiones_retroalimentacion').data('crear-href') + '/' + id;

				break;
			}

			showModalzAjax(url,titulo,"frmSesionOk('#form_sesion')",'',datos);
		}

		function frmSesionOk(id) {
			$(id + ' .date').datetimepicker({
				locale: 'es',
				format: 'DD/MM/Y HH:mm',
			});
		}

		function actualizarOk(obj){

			//$('#ses_mod').appendTo("body");

            let a = JSON.parse(obj.sesion_estado);

            let est = JSON.parse(a.est_ses_id);

            //$('#btn_cerrar').attr("disabled", true);

			let sesion = JSON.parse(obj.sesion);

			if (obj.estado == '1') {
				switch(sesion.ses_tip){
					case 'I': //Sesion Individual
						act_ses_fec = $('#table_sesiones > tbody tr[data-ses-num="' + sesion.ses_num+ '"] td:eq(1)');
						act_ses_est = $('#table_sesiones > tbody tr[data-ses-num="' + sesion.ses_num+ '"] td:eq(2)');
					break;

					case 'C': //Sesion Seguimiento
						act_ses_fec = $('#table_sesiones_seguimiento > tbody tr[data-ses-num="' + sesion.ses_num+ '"] td:eq(1)');
						act_ses_est = $('#table_sesiones_seguimiento > tbody tr[data-ses-num="' + sesion.ses_num+ '"] td:eq(2)');
					break;

					case 'R': //Sesion Retroalimentación
						act_ses_fec = $('#table_sesiones_retroalimentacion > tbody tr[data-ses-num="' + sesion.ses_num+ '"] td:eq(1)');
						act_ses_est = $('#table_sesiones_retroalimentacion > tbody tr[data-ses-num="' + sesion.ses_num+ '"] td:eq(2)');
					break;
				}

				let sesion_estado = JSON.parse(obj.sesion_estado);

				act_ses_fec.html(sesion.fecha);
				act_ses_est.html(sesion_estado.nombre);

				$("#ses_obs").val("");
				$("#ses_dia").val("");

            if((est==7)||(est==6)){
            	
            	$('.cerrar_sup').attr("disabled", true);
            	$('.btn_cerrar').attr("disabled", true);


				$('#msjInfo').empty();
				$('#msjInfo').html('El estado se ha actualizado correctamente, debe planificar la sesion cerrar el formulario.');
            }
            else{
            	$('.cerrar_sup').attr("disabled", false);
            	$('.btn_cerrar').attr("disabled", false);
				$('#zModal').modal('hide');
				location.reload();

            }

			}
		}

		$(document).ready(function () {

			$('div .date').datetimepicker({
				locale: 'es',
				format: 'DD/MM/Y HH:mm',
			});

			//Sesiones de retroalimentación
			$("[name='fec_ses_ret']").datetimepicker({
				locale: 'es',
				format: 'DD/MM/Y HH:mm',
			});

			$("[name='fec_ses_seg']").datetimepicker({
				locale: 'es',
				format: 'DD/MM/Y HH:mm',
			});

			//Sesiones individuales
			$("#table_sesiones").on("click",'.btnSelect', {tip_ses: 'I'}, crearSesion);
			$("#table_sesiones").on("click",'.btnShow', {tip_ses: 'I'}, showFrmSesion);

			//Sesiones seguimiento
			$("#table_sesiones_seguimiento").on("click",'.btnSelect', {tip_ses : 'C'}, crearSesion);
			$("#table_sesiones_seguimiento").on("click",'.btnShow', {tip_ses : 'C'}, showFrmSesion);

			//Sesiones retroalimentación
			$("#table_sesiones_retroalimentacion").on("click",'.btnSelect', {tip_ses: 'R'}, crearSesion);
			$("#table_sesiones_retroalimentacion").on("click",'.btnShow', {tip_ses: 'R'}, showFrmSesion);

		});

		function valSesionesIndividuales(_this, id_caso){

			$.ajax({
				url: $("#val_ind_nna").val(),
				cache: false,
				data: { caso_id : id_caso }
			}).done(function( resp ) {

				if (resp.respuesta == true){
					var ind = $("#table_sesiones > tbody > tr").length + 1;
					var html = '<tr data-ses-num="'+ind+'" data-ses-id="" class="">';
					html += '<td class="align-middle">Sesion '+ind+'</td>';
					html += '<td class="align-middle text-right">';
					html += '<div class="input-group date" id="fecha'+ind+'" data-target-input="nearest">';
					html += '<input required name="ses_fec" type="text" class="form-control datetimepicker-input" data-target="#fecha'+ind+'">';
					html += '<div class="input-group-append " data-target="#fecha'+ind+'" data-toggle="datetimepicker">';
                    html += '<div class="input-group-text">';
                    html += '<i class="fa fa-calendar"></i>';
                    html += '</div></div></div></td>';
					html += '<td class="align-middle text-center">{{ config("constantes.sesion_sin_estado","") }}</td>';
					html += '<td class="align-middle text-center">';
					html += '<button class="btn btn-primary btnSelect" type="button" >Planificar</button>';
					html += '<button class="btn btn-primary btnShow" type="button" hidden>Modificar</button></td>';
					html += '</tr>';

					$("#table_sesiones > tbody").append(html);

					$('div .date').datetimepicker({
						locale: 'es',
						format: 'DD/MM/Y HH:mm',
					});

				}else if (resp.respuesta == false){
					alert("No se puede agregar más sesiones indivuales al NNA. Debido a que completo el máximo de sesiones Planificadas o Finalizadas.");
					$(_this).attr("disabled", true);
				}

			}).fail(function(obj) {
				console.log(obj);
				alert("Error al momento de validar las sesiones individuales agendadas del NNA. Por favor volver a intentar.");

			});
		}

	
	</script>
	
@endsection