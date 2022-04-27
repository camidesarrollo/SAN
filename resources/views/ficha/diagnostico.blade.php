<style type="text/css">
.padre {
  /*IMPORTANTE*/
  display: flex;
  justify-content: center;
  align-items: center;
}

.hijo {
  width: 50%;
  justify-content: center !important;
} 
</style>				
				<div class="container">
				<div class="row">
					<div class="col">
						@if (count($titulos_modal) >= 1)
							<h5 class="modal-title" id="title_ejecucion" data-id-est="{{ $titulos_modal[2]->id_est }}">
								<b><img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIj8+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiBoZWlnaHQ9IjUxMnB4IiB2aWV3Qm94PSItMjcgMCA1MTIgNTEyIiB3aWR0aD0iNTEycHgiPjxwYXRoIGQ9Im0xODggNDkyYzAgMTEuMDQ2ODc1LTguOTUzMTI1IDIwLTIwIDIwaC04OGMtNDQuMTEzMjgxIDAtODAtMzUuODg2NzE5LTgwLTgwdi0zNTJjMC00NC4xMTMyODEgMzUuODg2NzE5LTgwIDgwLTgwaDI0NS44OTA2MjVjNDQuMTA5Mzc1IDAgODAgMzUuODg2NzE5IDgwIDgwdjE5MWMwIDExLjA0Njg3NS04Ljk1NzAzMSAyMC0yMCAyMC0xMS4wNDY4NzUgMC0yMC04Ljk1MzEyNS0yMC0yMHYtMTkxYzAtMjIuMDU0Njg4LTE3Ljk0NTMxMy00MC00MC00MGgtMjQ1Ljg5MDYyNWMtMjIuMDU0Njg4IDAtNDAgMTcuOTQ1MzEyLTQwIDQwdjM1MmMwIDIyLjA1NDY4OCAxNy45NDUzMTIgNDAgNDAgNDBoODhjMTEuMDQ2ODc1IDAgMjAgOC45NTMxMjUgMjAgMjB6bTExNy44OTA2MjUtMzcyaC0yMDZjLTExLjA0Njg3NSAwLTIwIDguOTUzMTI1LTIwIDIwczguOTUzMTI1IDIwIDIwIDIwaDIwNmMxMS4wNDI5NjkgMCAyMC04Ljk1MzEyNSAyMC0yMHMtOC45NTcwMzEtMjAtMjAtMjB6bTIwIDEwMGMwLTExLjA0Njg3NS04Ljk1NzAzMS0yMC0yMC0yMGgtMjA2Yy0xMS4wNDY4NzUgMC0yMCA4Ljk1MzEyNS0yMCAyMHM4Ljk1MzEyNSAyMCAyMCAyMGgyMDZjMTEuMDQyOTY5IDAgMjAtOC45NTMxMjUgMjAtMjB6bS0yMjYgNjBjLTExLjA0Njg3NSAwLTIwIDguOTUzMTI1LTIwIDIwczguOTUzMTI1IDIwIDIwIDIwaDEwNS4xMDkzNzVjMTEuMDQ2ODc1IDAgMjAtOC45NTMxMjUgMjAtMjBzLTguOTUzMTI1LTIwLTIwLTIwem0zNTUuNDcyNjU2IDE0Ni40OTYwOTRjLS43MDMxMjUgMS4wMDM5MDYtMy4xMTMyODEgNC40MTQwNjItNC42MDkzNzUgNi4zMDA3ODEtNi42OTkyMTggOC40MjU3ODEtMjIuMzc4OTA2IDI4LjE0ODQzNy00NC4xOTUzMTIgNDUuNTU4NTk0LTI3Ljk3MjY1NiAyMi4zMjQyMTktNTYuNzU3ODEzIDMzLjY0NDUzMS04NS41NTg1OTQgMzMuNjQ0NTMxcy01Ny41ODU5MzgtMTEuMzIwMzEyLTg1LjU1ODU5NC0zMy42NDQ1MzFjLTIxLjgxNjQwNi0xNy40MTAxNTctMzcuNDk2MDk0LTM3LjEzNjcxOS00NC4xOTE0MDYtNDUuNTU4NTk0LTEuNS0xLjg4NjcxOS0zLjkxMDE1Ni01LjMwMDc4MS00LjYxMzI4MS02LjMwMDc4MS00Ljg0NzY1Ny02Ljg5ODQzOC00Ljg0NzY1Ny0xNi4wOTc2NTYgMC0yMi45OTYwOTQuNzAzMTI1LTEgMy4xMTMyODEtNC40MTQwNjIgNC42MTMyODEtNi4zMDA3ODEgNi42OTUzMTItOC40MjE4NzUgMjIuMzc1LTI4LjE0NDUzMSA0NC4xOTE0MDYtNDUuNTU0Njg4IDI3Ljk3MjY1Ni0yMi4zMjQyMTkgNTYuNzU3ODEzLTMzLjY0NDUzMSA4NS41NTg1OTQtMzMuNjQ0NTMxczU3LjU4NTkzOCAxMS4zMjAzMTIgODUuNTU4NTk0IDMzLjY0NDUzMWMyMS44MTY0MDYgMTcuNDEwMTU3IDM3LjQ5NjA5NCAzNy4xMzY3MTkgNDQuMTkxNDA2IDQ1LjU1ODU5NCAxLjUgMS44ODY3MTkgMy45MTAxNTYgNS4zMDA3ODEgNC42MTMyODEgNi4zMDA3ODEgNC44NDc2NTcgNi44OTg0MzggNC44NDc2NTcgMTYuMDkzNzUgMCAyMi45OTIxODh6bS00MS43MTg3NS0xMS40OTYwOTRjLTMxLjgwMDc4MS0zNy44MzIwMzEtNjIuOTM3NS01Ny05Mi42NDQ1MzEtNTctMjkuNzAzMTI1IDAtNjAuODQzNzUgMTkuMTY0MDYyLTkyLjY0NDUzMSA1NyAzMS44MDA3ODEgMzcuODMyMDMxIDYyLjkzNzUgNTcgOTIuNjQ0NTMxIDU3czYwLjg0Mzc1LTE5LjE2NDA2MiA5Mi42NDQ1MzEtNTd6bS05MS42NDQ1MzEtMzhjLTIwLjk4ODI4MSAwLTM4IDE3LjAxMTcxOS0zOCAzOHMxNy4wMTE3MTkgMzggMzggMzggMzgtMTcuMDExNzE5IDM4LTM4LTE3LjAxMTcxOS0zOC0zOC0zOHptMCAwIiBmaWxsPSIjMDAwMDAwIi8+PC9zdmc+Cg==" height="20px" /> {{ $titulos_modal[0]->titulo }}</b>
							</h5>
						@else
							<h5 class="modal-title" id="title_ejecucion" data-id-est=""></h5>
						@endif
					</div>
					<div class="col text-right">
						<button type="button" class="btn btn-danger btn-sm btnRechEst" data-dismiss="modal"
								@if (config('constantes.rechazado_por_familiares') == $estado_actual_caso || config('constantes.direccion_incorrecta') == $estado_actual_caso || config('constantes.direccion_desactualizada') == $estado_actual_caso || config('constantes.rechazado_por_gestor') == $estado_actual_caso ||
								config('constantes.en_seguimiento_paf') == $estado_actual_caso || config('constantes.egreso_paf') == $estado_actual_caso)
								disabled @else onclick="comentarioEstado({{ $caso_id }});" @endif >
								Desestimar Caso
						</button>
					</div>
				</div>
				</div>
				<hr>
	
				<!-- Mensajes de Alertas -->
				<div style="display:none;" class="alert alert-success alert-dismissible fade show" id="alert-exi" role="alert">
					Registro Guardado Exitosamente.
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<div style="display:none;" class="alert alert-danger alert-dismissible fade show" id="alert-err" role="alert">
					Error al momento de guardar el registro. Por favor intente nuevamente.
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<!-- Fin Mensajes de Alertas -->

			
				<!-- Frm diagnostico -->


				<!--<form enctype="multipart/form-data" id="adj_cons" method="post">-->
					<!-- HIDDEN FORM -->
					<meta name="_token" content="{{ csrf_token() }}"/>
					{{ csrf_field() }}
					<input type="hidden" name="cas_id" id="cas_id" value="{{$caso_id}}">
					<!-- HIDDEN FORM -->
					<div>
					<!-- BENEFICIOS NNA -->
                    <div class="card colapsable shadow-sm">
                    	<a class="btn text-left p-0" id="btn_beneficios_grupo_familiar"  data-toggle="collapse" data-target="#beneficios_grupo_familiar" aria-expanded="false" aria-controls="beneficios_grupo_familiar" onclick="if($(this).attr('aria-expanded') == 'false') listarGrupoFamiliar({{$caso_id}});">
							<div class="card-header p-3">
	      						<h5 class="mb-0"><button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Beneficios otorgados a cada miembro del grupo familiar"><i class="fa fa-info"></i></button>&nbsp;&nbsp;Beneficios&nbsp;</h5>
	      					</div>
	      				</a>
	      				<div class="collapse" id="beneficios_grupo_familiar">
	      					<div class="card-body">
								@includeif('ficha.beneficios_grupo_familiar')
					    	</div>
					    </div>
					</div>
					</div>

					<!-- FIN BENEFICIOS NNA  -->
					<div>
					<!-- GRUPO FAMILIAR -->
                    <div class="card colapsable shadow-sm">
                    	<a class="btn text-left p-0" id="btn_despliegue_grupo_familiar"  data-toggle="collapse" data-target="#listar_grupo_familiar" aria-expanded="false" aria-controls="listar_grupo_familiar" onclick="if($(this).attr('aria-expanded') == 'false') listarGrupoFamiliar({{$caso_id}});">
							<div class="card-header p-3">
	      						<h5 class="mb-0"><button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Identifique los miembros del grupo familiar."><i class="fa fa-info"></i></button>&nbsp;&nbsp;Grupo Familiar</h5>
	      					</div>
	      				</a>
	      				<div class="collapse" id="listar_grupo_familiar">
	      					<div class="card-body">
					        	@includeif('ficha.listar_grupo_familiar')
					    	</div>
					    </div>
					</div>
					</div>

					<!-- FIN GRUPO FAMILIAR -->

					<div>
					<!-- VISITAS -->
					<!-- VALOR MOSTRAR OCULTAR VISITAS -->
					@if(($visitas[0]->visita!=null)&&($visitas[1]->visita!=null)&&($visitas[2]->visita!=null)) 
					<input type="hidden" name="cont_vis" id="cont_vis" value="3">
					@endif
					
					@if(($visitas[0]->visita!=null)&&($visitas[1]->visita!=null)) 
					<input type="hidden" name="cont_vis" id="cont_vis" value="2">
					@else
					<input type="hidden" name="cont_vis" id="cont_vis" value="1">
					@endif
                    <div class="card colapsable shadow-sm">
                    	<a class="btn text-left p-0" id="btn_despliegue_visitas"  data-toggle="collapse" data-target="#listar_visitas" aria-expanded="false" aria-controls="listar_visitas">
							<div class="card-header p-3">
	      						<h5 class="mb-0"><button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Registre cada visita al hogar del NNA. Si no lo encuentra, debe dejar un comentario de esas visitas fallidas. Puede registrar hasta 3 intentos."><i class="fa fa-info"></i></button>&nbsp;&nbsp;Visitas</h5>
	      						<!-- <a href="{{ route('alertas.crear') }}" class="btn btn-success float-right" data-toggle="tooltip" data-placement="left" title="" id="IDnuevo" data-original-title="Nueva Alerta manual"><i class="fa fa-plus-circle"></i> Crear alerta</a>  -->
	      					</div>
	      				</a>
	      				<div class="collapse" id="listar_visitas">
	      					<div class="card-body">
						        @includeif('ficha.listar_visitas_diagnostico')
								@includeif('ficha.formulario_visitas_diagnostico')

						        <!-- BITACORA VISITA 1 --> 
								<!--<div class="form-group card p-3 bg-light">
									<div class="row">
										<div class="col-md-2">
											<h5><b>Visita N° 1:</b></h5>
										</div>
										<div class="col-md-3">
											<label for=""> Fecha: </label>	
											<div class="input-group date-pick" id="fecha_visita_1" data-target-input="nearest">
												<input  type="text" name="hora_ini" class="form-control datetimepicker-input" data-target="#fecha_visita_1"
												 @if (count($visitas) > 0) value="{{ $visitas[0]->fecha }}" @endif onblur="validarFormDiagnostico(1);"/>
												<div class="input-group-append" data-target="#fecha_visita_1" data-toggle="datetimepicker">
													<div class="input-group-text"><i class="fa fa-calendar"></i>
													</div>
												</div>
											</div>
										</div>
										<div class="col">
											<label for=""> Descripción: </label>
											<textarea onkeypress='return caracteres_especiales(event)' class="form-control " id="bitacora_visita_1" cols="30" rows="3" onblur="guardarFormDiagnostico(1, {{ $caso_id }});">@if (count($visitas) > 0){{ $visitas[0]->visita }}@endif</textarea>
											<p id="val_diag_vis_1" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Falta información a completar de esta visita.</p>
										</div>
									</div>
								</div>-->
								<!-- FIN BITACORA VISITA 1 -->

								<!--<div id="vis_2"  style="<?php if($visitas[1]->visita==null){ echo  "display:none"; }  ?>">-->
								 <!-- BITACORA VISITA 2 -->
								<!--<div class="form-group card p-3 bg-light"">-->
									<!--<div class="row">-->
										<!-- <button type="button" id="cerrar_2" class="close" style="right:5px;top:5px;width:23px;height:23px;padding:0;margin:0;">×</button> -->
									<!--	<div class="col-md-2">
											<h5><b>Visita N° 2:</b></h5>
										</div>
										<div class="col-md-3">
											<label for=""> Fecha: </label>	
											<div class="input-group date-pick" id="fecha_visita_2" data-target-input="nearest">
												<input type="text" name="hora_ini" class="form-control datetimepicker-input" data-target="#fecha_visita_2" @if (count($visitas) > 0) value="{{ $visitas[1]->fecha }}" @endif onblur="validarFormDiagnostico(2);"/>
												<div class="input-group-append" data-target="#fecha_visita_2" data-toggle="datetimepicker">
													<div class="input-group-text"><i class="fa fa-calendar"></i></div>
												</div>
											</div>
										</div>
										<div class="col">
											<label for=""> Descripción: </label>
											  <textarea onkeypress='return caracteres_especiales(event)' class="form-control " id="bitacora_visita_2" cols="30" rows="3" style="" onblur="guardarFormDiagnostico(2, {{ $caso_id }});">@if (count($visitas) > 0){{ $visitas[1]->visita }}@endif</textarea>
											  <p id="val_diag_vis_2" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Falta información a completar de esta visita.</p>
										</div>
									</div>
								</div>-->
								<!-- FIN BITACORA VISITA 2 -->
										  
								<!--<div id="vis_3" style="<?php if($visitas[2]->visita==null){ echo  "display:none"; } ?>">-->
								<!-- BITACORA VISITA 3 -->
								<!--<div class="form-group card p-3 bg-light">
									<div class="row">-->
										  <!-- 	<button type="button" id="cerrar_3" class="close" style="right:5px;top:5px;width:23px;height:23px;padding:0;margin:0;">×</button> -->
										<!--<div class="col-md-2">
											<h5><b>Visita N° 3:</b></h5>
										</div>
										<div class="col-md-3">
											<label for=""> Fecha: </label>
												<div style="width:150px;" class="input-group date-pick" id="fecha_visita_3" data-target-input="nearest">
												  <input type="text" name="hora_ini" class="form-control datetimepicker-input" data-target="#fecha_visita_3" @if (count($visitas) > 0) value="{{ $visitas[2]->fecha }}" @endif onblur="validarFormDiagnostico(3);"/>
												  <div class="input-group-append" data-target="#fecha_visita_3" data-toggle="datetimepicker">
													  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
												  </div>
											  </div>
										</div>
										<div class="col">
											<label for=""> Descripción: </label>
											<textarea onkeypress='return caracteres_especiales(event)' class="form-control " id="bitacora_visita_3" cols="30" rows="3" style="" onblur="guardarFormDiagnostico(3, {{ $caso_id }});">@if (count($visitas) > 0){{ $visitas[2]->visita }}@endif</textarea>
											<p id="val_diag_vis_3" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display: none;">* Falta información a completar de esta visita.</p>
										  </div>
										</div>
									</div>
								</div>-->
								<!-- FIN BITACORA VISITA 3 -->

						    <!--<ul class="list-group list-group-flush">
	    						<li class="list-group-item"><button type="button" class="btn btn-success" id="agregar_visita"> <i class="fa fa-plus-circle"></i> Agregar Visita</button></li>
	    					</ul>-->
					    	</div>
					    </div>
					</div>
					</div>
					<!-- FIN VISITAS -->

				<!-- DOCUMENTO DE CONSENTIMIENTO -->
					<div>
                    <div class="card colapsable shadow-sm">
                    	<a class="btn text-left p-0" id="btn_consentimiento"  data-toggle="collapse" data-target="#consentimiento" aria-expanded="false" aria-controls="consentimiento" onclick="if($(this).attr('aria-expanded') == 'false') listarGrupoFamiliar({{$caso_id}});">
							<div class="card-header p-3">
	      						<h5 class="mb-0"><button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Descargue el Documento de Consentimiento para que el tutor legal del NNA lo firme. Luego vuelva a cargarlo al sistema por éste conducto."><i class="fa fa-info"></i></button>&nbsp;&nbsp;Consentimiento</h5>
	      					</div>
	      				</a>
	      				<div class="collapse" id="consentimiento">
	      					<div class="card-body">
	      						<br>
					        	<h6 class="text-center">Cargue el documento de consentimiento firmado por los involucrados, debe ser digitalizado (escaneo o fotografía).</h6>
					        	<br>
								<div class="input-group mb-3">
								  <div class="custom-file">
								    <input type="file" class="custom-file-input" id="inputGroupFile02">
								    <label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">Cargar archivo</label>
								  </div>
								  <div class="input-group-append">
								    <span class="input-group-text" id="inputGroupFileAddon02"><a href="#"><img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjUxMnB4IiBoZWlnaHQ9IjUxMnB4IiB2aWV3Qm94PSIwIDAgNDc1LjA3OCA0NzUuMDc3IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA0NzUuMDc4IDQ3NS4wNzc7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4KPGc+Cgk8Zz4KCQk8cGF0aCBkPSJNNDY3LjA4MywzMTguNjI3Yy01LjMyNC01LjMyOC0xMS44LTcuOTk0LTE5LjQxLTcuOTk0SDMxNS4xOTVsLTM4LjgyOCwzOC44MjdjLTExLjA0LDEwLjY1Ny0yMy45ODIsMTUuOTg4LTM4LjgyOCwxNS45ODggICAgYy0xNC44NDMsMC0yNy43ODktNS4zMjQtMzguODI4LTE1Ljk4OGwtMzguNTQzLTM4LjgyN0gyNy40MDhjLTcuNjEyLDAtMTQuMDgzLDIuNjY5LTE5LjQxNCw3Ljk5NCAgICBDMi42NjQsMzIzLjk1NSwwLDMzMC40MjcsMCwzMzguMDQ0djkxLjM1OGMwLDcuNjE0LDIuNjY0LDE0LjA4NSw3Ljk5NCwxOS40MTRjNS4zMyw1LjMyOCwxMS44MDEsNy45OSwxOS40MTQsNy45OWg0MjAuMjY2ICAgIGM3LjYxLDAsMTQuMDg2LTIuNjYyLDE5LjQxLTcuOTljNS4zMzItNS4zMjksNy45OTQtMTEuOCw3Ljk5NC0xOS40MTR2LTkxLjM1OEM0NzUuMDc4LDMzMC40MjcsNDcyLjQxNiwzMjMuOTU1LDQ2Ny4wODMsMzE4LjYyN3ogICAgIE0zNjAuMDI1LDQxNC44NDFjLTMuNjIxLDMuNjE3LTcuOTA1LDUuNDI0LTEyLjg1NCw1LjQyNHMtOS4yMjctMS44MDctMTIuODQ3LTUuNDI0Yy0zLjYxNC0zLjYxNy01LjQyMS03Ljg5OC01LjQyMS0xMi44NDQgICAgYzAtNC45NDgsMS44MDctOS4yMzYsNS40MjEtMTIuODQ3YzMuNjItMy42Miw3Ljg5OC01LjQzMSwxMi44NDctNS40MzFzOS4yMzIsMS44MTEsMTIuODU0LDUuNDMxICAgIGMzLjYxMywzLjYxLDUuNDIxLDcuODk4LDUuNDIxLDEyLjg0N0MzNjUuNDQ2LDQwNi45NDIsMzYzLjYzOCw0MTEuMjI0LDM2MC4wMjUsNDE0Ljg0MXogTTQzMy4xMDksNDE0Ljg0MSAgICBjLTMuNjE0LDMuNjE3LTcuODk4LDUuNDI0LTEyLjg0OCw1LjQyNGMtNC45NDgsMC05LjIyOS0xLjgwNy0xMi44NDctNS40MjRjLTMuNjEzLTMuNjE3LTUuNDItNy44OTgtNS40Mi0xMi44NDQgICAgYzAtNC45NDgsMS44MDctOS4yMzYsNS40Mi0xMi44NDdjMy42MTctMy42Miw3Ljg5OC01LjQzMSwxMi44NDctNS40MzFjNC45NDksMCw5LjIzMywxLjgxMSwxMi44NDgsNS40MzEgICAgYzMuNjE3LDMuNjEsNS40MjcsNy44OTgsNS40MjcsMTIuODQ3QzQzOC41MzYsNDA2Ljk0Miw0MzYuNzI5LDQxMS4yMjQsNDMzLjEwOSw0MTQuODQxeiIgZmlsbD0iIzAwMDAwMCIvPgoJCTxwYXRoIGQ9Ik0yMjQuNjkyLDMyMy40NzljMy40MjgsMy42MTMsNy43MSw1LjQyMSwxMi44NDcsNS40MjFjNS4xNDEsMCw5LjQxOC0xLjgwOCwxMi44NDctNS40MjFsMTI3LjkwNy0xMjcuOTA4ICAgIGM1Ljg5OS01LjUxOSw3LjIzNC0xMi4xODIsMy45OTctMTkuOTg2Yy0zLjIzLTcuNDIxLTguODQ3LTExLjEzMi0xNi44NDQtMTEuMTM2aC03My4wOTFWMzYuNTQzYzAtNC45NDgtMS44MTEtOS4yMzEtNS40MjEtMTIuODQ3ICAgIGMtMy42Mi0zLjYxNy03LjkwMS01LjQyNi0xMi44NDctNS40MjZoLTczLjA5NmMtNC45NDYsMC05LjIyOSwxLjgwOS0xMi44NDcsNS40MjZjLTMuNjE1LDMuNjE2LTUuNDI0LDcuODk4LTUuNDI0LDEyLjg0N1YxNjQuNDUgICAgaC03My4wODljLTcuOTk4LDAtMTMuNjEsMy43MTUtMTYuODQ2LDExLjEzNmMtMy4yMzQsNy44MDEtMS45MDMsMTQuNDY3LDMuOTk5LDE5Ljk4NkwyMjQuNjkyLDMyMy40Nzl6IiBmaWxsPSIjMDAwMDAwIi8+Cgk8L2c+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==" height="20px"/></a></span>
								  </div>
								</div>
								<div style="margin-top: -15px; margin-left: 2px;"><small>Solo subir archivos con las siguientes extensiones: ".pdf", ".jpg" y ".png".</small></div>
								<br>
								<div class="text-center"><small>En caso de no tener el documento de consentimiento puede descargarlo haciendo <a href="#" class="text-primary">click acá</a></small></div>
					    	</div>
					    </div>
					</div>
					</div>
      			<!--FIN DOCUMENTO DE CONSENTIMIENTO -->	
				<!-- NCFAS - G -->
					<div>
                    <div class="card colapsable shadow-sm">
                    	<a class="btn text-left p-0" id="btn_ncfas"  data-toggle="collapse" data-target="#ncfas" aria-expanded="false" aria-controls="ncfas" onclick="if($(this).attr('aria-expanded') == 'false') listarGrupoFamiliar({{$caso_id}});">
							<div class="card-header p-3">
	      						<h5 class="mb-0"><button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Identifique los miembros del grupo familiar."><i class="fa fa-info"></i></button>&nbsp;&nbsp;Evaluación Familiar NCFAS-G</h5>
	      					</div>
	      				</a>
	      				<div class="collapse" id="ncfas">
	      					<div class="card-body">
	      						
					        	<div class="row">
					        		<div class="col-md-12 col-lg-6 text-center">
					        			<br>
					        			<a href="{{ route('caso.diagnostico',[ 'ficha' => $caso_id, 'opcion'=>config('constantes.en_diagnostico')]) }}" class="btn" style="background: #fff; border: 1px solid #01e0bc; color: #01e0bc;"><i class="fas fa-check-circle"></i> Aplicar NCFAS-G</a>
					        		</div>
					        		<div class="col-md-12 col-lg-6 text-center">
					        			<br>
					        			@if($ncfasg_realizado)
					        			<a class="btn" style="background: #01e0bc; color: #fff;">Realizado</a>
										@else
										<a class="btn" style="background: #01e0bc; color: #fff;">No realizado</a>
										@endif
										<div id="val_diag_ncfas" class="alert alert-secondary text-danger p-1" style=" display: none;">
											<small>* Falta completar este item.</small>
										</div>
						        	</div>
					        	</div>
					        	<br>
					    	</div>
					    </div>
					</div>
					</div>	
				<!-- FIN NCFAS - G -->
				<!-- BITACORA ESTADO ACTUAL -->
				<div class="card shadow-sm alert-info">
					<div class="card-header p-3">
						<h5 class="mb-0"><i class="fa fa-pencil"></i> Bitácora</h5>
			      	</div>
			      	<div class="card-body">
					  	<label for="bitacora_estado_diagnostico" style="font-weight: 800;" class="">Estado actual del caso:</label>
					  	<textarea onkeypress='return caracteres_especiales(event)'class="form-control txtAreEtapa " name="bit-etapa-prediagnostico" id="bitacora_estado_prediagnostico" rows="3" onBlur="cambioEstadoCaso(13, {{ $caso_id }}, $(this).val());" @if (config('constantes.en_prediagnostico')  != $estado_actual_caso) disabled @endif>{{ $bitacoras_estados[5] }}</textarea>
					  </div>
				</div>
				<!-- FIN BITACORA ESTADO ACTUAL -->
				<div class="text-center">
					<button type="button" id="btn-etapa-diagnostico" class="btn btn-success btnEtapa" onclick="siguienteEtapa(8, {{ $caso_id }});" disabled>Ir a siguiente etapa - <strong>Elaborar PAF</strong></button>
				</div>
			<!--</form>-->
	
			<!-- Fin Frm diagnostico -->
			
			

@includeif('ficha.formulario_grupo_familiar')

<input type="hidden" name="valida_doc" id="valida_doc" value="0">

<input type="hidden" name="ncfasg_realizado" id="ncfasg_realizado" value="{{$ncfasg_realizado}}">

<script type="text/javascript">
	    /*Input Date Formulario Grupo Familiar*/
		$(function(){
			$('#form_familiar_nac').datetimepicker('format', 'DD/MM/Y');
		});

	   $(function() {
         $('#fecha_visita_1').datetimepicker({
           format: 'DD/MM/YY'
         });
        });	

	  $(function() {
      	$('#fecha_visita_2').datetimepicker({
            format: 'DD/MM/YY'
         });
       });

	   $(function() {
         $('#fecha_visita_3').datetimepicker({
            format: 'DD/MM/YY'
         });
        });

	$( document ).ready(function() {
		/*Validacion RUN Formulario Grupo Familiar*/
		$('#form_familiar_run').rut({
			fn_error: function(input){
				if (input.val() != ''){
					$('#form_familiar_run').attr("data-val-run", false);
					$("#val_frm_gfam_1").text("* RUN Inválido.");
					$("#val_frm_gfam_1").show();
				}
			},
			fn_validado: function(input){
				$('#form_familiar_run').attr("data-val-run", true);
				$("#val_frm_gfam_1").hide();

				autoCompletarFormularioFamiliar();
			}
		});


		$("#alert-exi").hide();
		$("#alert-err").hide();

		$("#alert-doc").hide();
		$("#alert-err-doc").hide();

		var cont = $("#cont_vis").val();

		// if(cont==3){  $("#cerrar_2").hide(); }

	//VISUALIZAMOS LAS VISITAS CON UN MAX DE 3
	$('#agregar_visita').click(function(){

		

		if(cont>=3){
			alert("Se han agregado el maximo de visitas"); 
		}else{

			cont++;

			// if(cont==3){  $("#cerrar_2").hide(); }	

			$("#vis_"+cont).show();
			
			$("#cont_vis").val()=cont;


		}
		
	});

	//OCULTAR ITEMS VISITAS
	$('#cerrar_2').click(function(){ 
	 	
	 	$("#vis_2").hide(); 
	 	
	 	//$("#fecha_visita_2 > input").val("");
		//$("#bitacora_visita_2").val("");

		cont=1;

		//var cas_id = $("#cas_id").val();

		//guardarFormDiagnostico(2, cas_id, 1);


	});

	$('#cerrar_3').click(function(){ 
		
		$("#vis_3").hide(); 
		$("#cerrar_2").show();

		//$("#fecha_visita_3 > input").val("");
		//$("#bitacora_visita_3").val("");

		cont=2;

		//var cas_id = $("#cas_id").val();
		//guardarFormDiagnostico(3, cas_id, 1);

	});

	//ADJUNTAR DOCUMENTO CONSENTIMIENTO
		 $("#doc_cons").change(function(e) {
			$("#adj_cons").submit();
		 });

		 $("#adj_cons").submit(function(e){
	
		  // evito que propague el submit
		  e.preventDefault();
		  
		  // agrego la data del form a formData
		  var form = document.getElementById('adj_cons');
		  var formData = new FormData(form);
		  formData.append('_token', $('input[name=_token]').val());

		  $.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			}
		  });

		  $.ajax({
		      type:'POST',
		      url: "{{ route('enviararhcons') }}",
		      data:formData,
		      cache:false,
		      contentType: false,
		      processData: false,
		      success:function(resp){
		           if (resp.estado == 1){
                    $("#alert-doc").show();	
						//$("#valida_doc").val()=1;
						$("#valida_doc").val(1);
					
					setTimeout(function(){ 
						$("#alert-doc").hide();
					 }, 5000);

					}else if (resp.estado == 0){
                    $("#alert-err-doc").show();
					setTimeout(function(){ $("#alert-error-doc").hide(); }, 5000);
				}
		      },
		      error: function(jqXHR, text, error){

		      		$("#alert-err-doc").show();
					setTimeout(function(){ $("#alert-error-doc").hide(); }, 5000);

		          // toastr.error('Validation error!', 'No se pudo Añadir los datos<br>' + error, {timeOut: 5000});
		      }
		  });

		});

	});	 
		//FIN DOCUMENTO CONSENTIMIENTO

	function mensajesErrorDiagnostico(option){
        switch (option){
			case 1: //VISITA 1
              $("#val_diag_vis_1").show();
              $("#fecha_visita_1 > input").addClass("is-invalid");
              $("#bitacora_visita_1").addClass("is-invalid");
			break;

			case 2: //VISITA 2
				$("#val_diag_vis_2").show();
				$("#fecha_visita_2 > input").addClass("is-invalid");
				$("#bitacora_visita_2").addClass("is-invalid");
			break;

			case 3: //VISITA 3
				$("#val_diag_vis_3").show();
				$("#fecha_visita_3 > input").addClass("is-invalid");
				$("#bitacora_visita_3").addClass("is-invalid");
			break;
		}
	}

	function validarFormDiagnostico(option){
		let respuesta = false;
		let fecha = "";
		let comentario = "";

		switch (option) {
			case 1: //VISITA 1
				fecha = $("#fecha_visita_1 > input").val();
				comentario = $("#bitacora_visita_1").val();

				if (fecha != ""){
					//$("#bitacora_visita_1").fadeIn('slow');

				}else if (fecha == ""){
					//$("#bitacora_visita_1").fadeOut('slow');

				}

				if (fecha != "" && comentario != "" && comentario.length >= 2){
					$("#val_diag_vis_1").hide();
					$("#fecha_visita_1 > input").removeClass("is-invalid");
					$("#bitacora_visita_1").removeClass("is-invalid");
					//$("#bitacora_visita_1").fadeIn('slow');
					respuesta = true;
				}
			break;

			case 2: //VISITA 2
				fecha = $("#fecha_visita_2 > input").val();
				comentario = $("#bitacora_visita_2").val();		

				if (fecha != ""){
					//$("#bitacora_visita_2").fadeIn('slow');

				}else if (fecha == ""){
					//$("#bitacora_visita_2").fadeOut('slow');

				}

				if (fecha != "" && comentario != "" && comentario.length >= 2){
					$("#val_diag_vis_2").hide();
					$("#fecha_visita_2 > input").removeClass("is-invalid");
					$("#bitacora_visita_2").removeClass("is-invalid");
					$("#bitacora_visita_2").fadeIn('slow');
					respuesta = true;
				}
			break;

			case 3: //VISITA 3
				fecha = $("#fecha_visita_3 > input").val();
				comentario = $("#bitacora_visita_3").val();

				if (fecha != ""){
					//$("#bitacora_visita_3").fadeIn('slow');

				}else if (fecha == ""){
					//$("#bitacora_visita_3").fadeOut('slow');

				}

				if (fecha != "" && comentario != "" && comentario.length >= 2){
					$("#val_diag_vis_3").hide();
					$("#fecha_visita_3 > input").removeClass("is-invalid");
					$("#bitacora_visita_3").removeClass("is-invalid");
					$("#bitacora_visita_3").fadeIn('slow');
					respuesta = true;
				}
			break;

			case 4: //NCFAS
	               let data2 = new Object();
				   data2.cas_id = $("#cas_id").val();

	               $.ajax({
				     url: "{{ route('valida.ncfas') }}",
				     type: "GET",
				     data: data2
					}).done(function(resp){
						if (resp.estado == 1){
							 if (resp.respuesta == true){
							 	respuesta = true;
							 	$("#val_diag_ncfas").hide();

							 }else if (resp.respuesta == false){
							 	$("#val_diag_ncfas").show();

							 }
						}
					}).fail(function(obj){
						console.log(obj); return false;

					});

			break;


			case 5: //DOCUMENTO DE CONSENTIMIENTO
	               let data = new Object();
				   data.cas_id = $("#cas_id").val();

	               $.ajax({
				     url: "{{ route('valida.doc.cons') }}",
				     type: "GET",
				     data: data
					}).done(function(resp){
						if (resp.estado == 1){
							 if (resp.respuesta == true){
							 	respuesta = true;
							 	$("#val_diag_doc_cons").hide();

							 }else if (resp.respuesta == false){
							 	$("#val_diag_doc_cons").show();

							 }
						}
					}).fail(function(obj){
						console.log(obj); return false;

					});

			break;
		}

		return respuesta;
	}

	function guardarFormDiagnostico(option, caso_id, borrar = null){

		let validacion = validarFormDiagnostico(option);

		if(borrar==1){ validacion=true;}

		if (validacion == false) { 

			mensajesErrorDiagnostico(option); return false;
		
		}

		let data = new Object();
		data.option = option;
		data.cas_id = caso_id;

		borrar = null;

		switch (option){
			case 1: //VISITA 1
				data.comentario = $("#bitacora_visita_1").val();
				data.fecha      = $("#fecha_visita_1 > input").val();
			break;

			case 2: //VISITA 2
				data.comentario = $("#bitacora_visita_2").val();
				data.fecha      = $("#fecha_visita_2 > input").val();
			break;

			case 3: //VISITA 3
				data.comentario = $("#bitacora_visita_3").val();
				data.fecha      = $("#fecha_visita_3 > input").val();
			break;

			case 4: //DOCUMENTO DE CONSENTIMIENTO

			break;
		}

		$.ajaxSetup({
			headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}
		});

		$.ajax({
			url: "{{ route('casos.form.diagnostico') }}",
			type: "GET",
			data: data
		}).done(function(resp){
			if (resp.estado == 1){
				//console.log("01"); return false;
				$("#alert-exi").show();
				setTimeout(function(){ $("#alert-exi").hide(); }, 5000);

			}else if (resp.estado == 0){
				//console.log("02"); return false;
				$("#alert-err").show();
				setTimeout(function(){ $("#alert-err").hide(); }, 5000);

			}
		}).fail(function(obj){
			//console.log("03");
			console.log(obj); return false;

			//$("#alert-err").show();
			//setTimeout(function(){ $("#alert-err").hide(); }, 5000);

		});
	}
	$(function () {
	  $('[data-toggle="popover"]').popover()
	})
	$(function () {
	  $('[data-toggle="tooltip"]').tooltip()
	})
</script>

