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
					@if ($modo_visualizacion == 'edicion')
					<div class="col text-right">
						<button type="button" class="btn btn-danger btn-sm btnRechEst" data-dismiss="modal"
								@if($est_cas_fin)
									disabled 
								@else 
									onclick="comentarioEstado({{ $caso_id }});" 
								@endif >
								Desestimar Caso
						</button>

						<input type="hidden" id="documentoconsentimiento" value="{{$documentoconsentimiento}}">
					</div>
					@endif
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
                    <div class="card colapsable shadow-sm" >
                    	<a class="btn text-left p-0" id="btn_beneficios_grupo_familiar"  data-toggle="collapse" data-target="#beneficios_grupo_familiar" aria-expanded="false" aria-controls="beneficios_grupo_familiar">
							<div class="card-header p-3">
	      						<h5 class="mb-0"><button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Beneficios otorgados a cada miembro del grupo familiar"><i class="fa fa-info"></i></button>&nbsp;&nbsp;Beneficios</h5>
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
                    	<a class="btn text-left p-0" id="btn_despliegue_visitas"  data-toggle="collapse" data-target="#listar_visitas" aria-expanded="false" aria-controls="listar_visitas" onclick="if($(this).attr('aria-expanded') == 'false') listarVisitasDiagnosticoCaso({{$caso_id}});">

							<div class="card-header p-3">
	      						<h5 class="mb-0"><button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Registre cada visita al hogar del NNA. Si no lo encuentra, debe dejar un comentario de esas visitas fallidas. Puede registrar hasta 3 intentos."><i class="fa fa-info"></i></button>&nbsp;&nbsp;Actividad</h5>
	      					</div>
	      				</a>
	      				<div class="collapse" id="listar_visitas">
	      					<div class="card-body">
						        @includeif('ficha.listar_visitas_diagnostico')
								@includeif('ficha.formulario_visitas_diagnostico')
					    	</div>
					    </div>
					</div>
					</div>
					<!-- FIN VISITAS -->

				<!-- DOCUMENTO DE CONSENTIMIENTO -->
					<div>
                    <div class="card colapsable shadow-sm">
                    	<a class="btn text-left p-0" id="btn_consentimiento"  data-toggle="collapse" data-target="#consentimiento" aria-expanded="false" aria-controls="consentimiento">
							<div class="card-header p-3">
	      						<h5 class="mb-0"><button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Descargue el Documento de Consentimiento para que el tutor legal del NNA lo firme. Luego vuelva a cargarlo al sistema por éste conducto."><i class="fa fa-info"></i></button>&nbsp;&nbsp;Consentimiento</h5>
	      					</div>
	      				</a>

	      				<div class="collapse" id="consentimiento">
	
	      					@if ($modo_visualizacion == 'visualizacion')
	      						<div class="card-body">
	      							<div class="col-12">
	      								<h6 class="text-center">Descargue el documento de consentimiento subido para este caso en el siguiente enlace: 
	      								@if ($documentoconsentimiento == 'na')
	      								 <label class="font-weight-bold">Sin información.</label>
	      								@elseif ($documentoconsentimiento != 'na')
										  <!-- CZ SPRINT 77 -->
										    <a class="text-primary" href="{{config('constantes.app_url')}}doc/{{$documentoconsentimiento}}" id="ruta_documento_consentimiento">Click acá.</a>
											
										@endif	
	      								</h6>  
									</div>
									<div class="col-12 text-center">
										<small>En caso de no tener cargado el documento de consentimiento puede descargarlo en español haciendo <a href="/documentos/consentimiento.docx" class="text-primary">click acá</a> o en Kreyòl <a href="/documentos/consentimiento_Kreyòl.docx" class="text-primary">click acá</a> </small>
									</div>
	      						</div>
	      						

	      					@elseif ($modo_visualizacion == 'edicion')
	      					<div class="card-body">
	      						<br>

	      						<div class="alert alert-success alert-dismissible fade show" id="alert-doc" role="alert">
											Documento Guardado Exitosamente.
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
											</button>
								</div>

								<div class="alert alert-danger alert-dismissible fade show" id="alert-err-doc" role="alert">
									Error al momento de guardar el registro. Por favor intente nuevamente.
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>

								<div class="alert alert-danger alert-dismissible fade show" id="alert-err-doc-ext" role="alert">
									EL formato del archivo no es permitido. Sólo subir archivos con las siguientes extensiones: ".pdf", ".jpg" y ".png"
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>

					        	<h6 class="text-center">Cargue el documento de consentimiento firmado por los involucrados, debe ser digitalizado (escaneo o fotografía).</h6>
					        	<br>
								<div class="input-group mb-3">


									<!-- <form enctype="multipart/form-data" id="adj_cons" method="post">
										<div class="custom-file" style="z-index:0;">
						      					<input type="file" @if(config('constantes.en_diagnostico')!= $estado_actual_caso) disabled @endif class="custom-file-input " name="doc_cons" id="doc_cons">
						      					<input type="hidden" id="cas_id" name="cas_id" value={{$caso_id}}>
						      					<label class="custom-file-label" for="doc_cons" aria-describedby="inputGroupFileAddon02">Cargar archivo</label>
						      			</div>
									</form> -->
									<form method="post" action="#" enctype="multipart/form-data" id="adj_const">
										<div class="custom-file" style="z-index:0;">
													<input type="file" @if(config('constantes.en_diagnostico')!= $estado_actual_caso) disabled @endif class="custom-file-input" name="doc_cons2" id="doc_cons2">
													<input type="hidden" id="cas_id" name="cas_id" value={{$caso_id}}>
													<label class="custom-file-label" for="doc_cons2" aria-describedby="inputGroupFileAddon02">Cargar archivo</label>
											</div>
										
									</form>


									
								  <!-- <div class="custom-file">
								    <input type="file" class="custom-file-input" id="inputGroupFile02">
								    <label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">Cargar archivo</label>
								  </div>
 -->
<div id="descargarconsentimiento">
								  <div class="input-group-append">
								    <span class="input-group-text" id="inputGroupFileAddon02"><a download href="../doc/{{$documentoconsentimiento}}" id="ruta_documento_consentimiento"><img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjUxMnB4IiBoZWlnaHQ9IjUxMnB4IiB2aWV3Qm94PSIwIDAgNDc1LjA3OCA0NzUuMDc3IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA0NzUuMDc4IDQ3NS4wNzc7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4KPGc+Cgk8Zz4KCQk8cGF0aCBkPSJNNDY3LjA4MywzMTguNjI3Yy01LjMyNC01LjMyOC0xMS44LTcuOTk0LTE5LjQxLTcuOTk0SDMxNS4xOTVsLTM4LjgyOCwzOC44MjdjLTExLjA0LDEwLjY1Ny0yMy45ODIsMTUuOTg4LTM4LjgyOCwxNS45ODggICAgYy0xNC44NDMsMC0yNy43ODktNS4zMjQtMzguODI4LTE1Ljk4OGwtMzguNTQzLTM4LjgyN0gyNy40MDhjLTcuNjEyLDAtMTQuMDgzLDIuNjY5LTE5LjQxNCw3Ljk5NCAgICBDMi42NjQsMzIzLjk1NSwwLDMzMC40MjcsMCwzMzguMDQ0djkxLjM1OGMwLDcuNjE0LDIuNjY0LDE0LjA4NSw3Ljk5NCwxOS40MTRjNS4zMyw1LjMyOCwxMS44MDEsNy45OSwxOS40MTQsNy45OWg0MjAuMjY2ICAgIGM3LjYxLDAsMTQuMDg2LTIuNjYyLDE5LjQxLTcuOTljNS4zMzItNS4zMjksNy45OTQtMTEuOCw3Ljk5NC0xOS40MTR2LTkxLjM1OEM0NzUuMDc4LDMzMC40MjcsNDcyLjQxNiwzMjMuOTU1LDQ2Ny4wODMsMzE4LjYyN3ogICAgIE0zNjAuMDI1LDQxNC44NDFjLTMuNjIxLDMuNjE3LTcuOTA1LDUuNDI0LTEyLjg1NCw1LjQyNHMtOS4yMjctMS44MDctMTIuODQ3LTUuNDI0Yy0zLjYxNC0zLjYxNy01LjQyMS03Ljg5OC01LjQyMS0xMi44NDQgICAgYzAtNC45NDgsMS44MDctOS4yMzYsNS40MjEtMTIuODQ3YzMuNjItMy42Miw3Ljg5OC01LjQzMSwxMi44NDctNS40MzFzOS4yMzIsMS44MTEsMTIuODU0LDUuNDMxICAgIGMzLjYxMywzLjYxLDUuNDIxLDcuODk4LDUuNDIxLDEyLjg0N0MzNjUuNDQ2LDQwNi45NDIsMzYzLjYzOCw0MTEuMjI0LDM2MC4wMjUsNDE0Ljg0MXogTTQzMy4xMDksNDE0Ljg0MSAgICBjLTMuNjE0LDMuNjE3LTcuODk4LDUuNDI0LTEyLjg0OCw1LjQyNGMtNC45NDgsMC05LjIyOS0xLjgwNy0xMi44NDctNS40MjRjLTMuNjEzLTMuNjE3LTUuNDItNy44OTgtNS40Mi0xMi44NDQgICAgYzAtNC45NDgsMS44MDctOS4yMzYsNS40Mi0xMi44NDdjMy42MTctMy42Miw3Ljg5OC01LjQzMSwxMi44NDctNS40MzFjNC45NDksMCw5LjIzMywxLjgxMSwxMi44NDgsNS40MzEgICAgYzMuNjE3LDMuNjEsNS40MjcsNy44OTgsNS40MjcsMTIuODQ3QzQzOC41MzYsNDA2Ljk0Miw0MzYuNzI5LDQxMS4yMjQsNDMzLjEwOSw0MTQuODQxeiIgZmlsbD0iIzAwMDAwMCIvPgoJCTxwYXRoIGQ9Ik0yMjQuNjkyLDMyMy40NzljMy40MjgsMy42MTMsNy43MSw1LjQyMSwxMi44NDcsNS40MjFjNS4xNDEsMCw5LjQxOC0xLjgwOCwxMi44NDctNS40MjFsMTI3LjkwNy0xMjcuOTA4ICAgIGM1Ljg5OS01LjUxOSw3LjIzNC0xMi4xODIsMy45OTctMTkuOTg2Yy0zLjIzLTcuNDIxLTguODQ3LTExLjEzMi0xNi44NDQtMTEuMTM2aC03My4wOTFWMzYuNTQzYzAtNC45NDgtMS44MTEtOS4yMzEtNS40MjEtMTIuODQ3ICAgIGMtMy42Mi0zLjYxNy03LjkwMS01LjQyNi0xMi44NDctNS40MjZoLTczLjA5NmMtNC45NDYsMC05LjIyOSwxLjgwOS0xMi44NDcsNS40MjZjLTMuNjE1LDMuNjE2LTUuNDI0LDcuODk4LTUuNDI0LDEyLjg0N1YxNjQuNDUgICAgaC03My4wODljLTcuOTk4LDAtMTMuNjEsMy43MTUtMTYuODQ2LDExLjEzNmMtMy4yMzQsNy44MDEtMS45MDMsMTQuNDY3LDMuOTk5LDE5Ljk4NkwyMjQuNjkyLDMyMy40Nzl6IiBmaWxsPSIjMDAwMDAwIi8+Cgk8L2c+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==" height="20px"/></a></span>
								  </div>
</div>
								</div>
								<div style="margin-top: -15px; margin-left: 2px;"><small>Sólo subir archivos con las siguientes extensiones: ".pdf", ".jpg" y ".png".</small></div>
								<br>

								<!-- <div class="row">
										  <dt class="col-sm-1"> <h4><span class="badge badge-secondary">a</span></h4></dt>
										  <dd class="col-sm-11"><p> Descargue el siguiente documento para que la familia involucrada firme voluntariamnete entregue el consentiminento y aceptación de la intervención</p>
										  <a href="/documentos/consentimiento.docx" class="btn btn-primary"><i class="fa fa-download mr-2"></i>  Descargar Documento</a></dd>
								</div> -->


								<div class="text-center"><small>En caso de no tener el documento de consentimiento puede descargarlo en español haciendo <a href="/documentos/consentimiento.docx" class="text-primary">click acá</a> o en Kreyòl <a href="/documentos/consentimiento_Kreyòl.docx" class="text-primary">click acá</a> </small></div>
					    	</div>
					    	@endif

					    </div>
					</div>
					</div>
      			<!--FIN DOCUMENTO DE CONSENTIMIENTO -->	
				<!-- NCFAS - G -->
					<div>
                    <div class="card colapsable shadow-sm">
						<a class="btn text-left p-0 no-collapsable" id="btn_ncfas"  data-toggle="collapse" data-target="#ncfas" aria-expanded="false" aria-controls="ncfas">
							<div class="card-header p-3">
	      						<h5 class="mb-0"><button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Realice la evaluación NCFAS-G"><i class="fa fa-info"></i></button>&nbsp;&nbsp;Evaluación Familiar NCFAS-G</h5>
	      					</div>
	      				</a>
	      				<div class="collapse" id="ncfas">
	      					<div class="card-body">
	      						

	      						@if ($modo_visualizacion == 'visualizacion')
	      							<div class="row">
	      								<div class="col-6 text-center">
	      									<button type="button" class="btn btn-info" onclick="$('#ncfasModal').modal('show');">Visualizar NCFAS-G</button>
	      								</div>
	      								<div class="col-6 text-center">
	      									@if($ncfasg_realizado)
						        				<a class="btn" style="background: #01e0bc; color: #fff;">Realizado</a>
											@else
												<a class="btn" style="background: #01e0bc; color: #fff;">No realizado</a>
											@endif
	      								</div>
	      							</div>
								@elseif ($modo_visualizacion == 'edicion')
						        	<div class="row">
						        		<div class="col-md-12 col-lg-6 text-center">
						        			<br>
											@if ($documentoconsentimiento != 'na')
						        			<a 
											
						        				@if ($ncfasg_realizado && config('constantes.en_diagnostico')!= $estado_actual_caso) 
						        					disabled 
						        				@else 
						        					href="{{ route('caso.diagnostico',[ 'ficha' => $caso_id, 'run' => $run, 'opcion' => config('constantes.en_diagnostico')]) }}"
						        				@endif

						        					class="btn" style="background: #fff; border: 1px solid #01e0bc; color: #01e0bc;"><i class="fas fa-check-circle" data-anr="{{$ncfasg_realizado}}"></i> 
													Aplicar NCFAS-G
												</a>
													
											@else	
	
													<button type="button" style="background: #fff; border: 1px solid #01e0bc; color: #01e0bc;border-radius: 10px !important;padding:0.375rem 0.75rem;cursor:pointer
" onclick="alert('Debe ingresar Documento de Consentimiento')"><i class="fas fa-check-circle" data-anr="{{$ncfasg_realizado}}"></i> Aplicar NCFAS-G</button>
													<p style="color:red;font-size:13px;float:right;margin-right:35px;margin-top:9px">El documento de consentimiento no ha sido cargado!</p>
											@endif
						        		</div>

						        		<div class="col-md-12 col-lg-6 text-center">
						        			<br>
						        			@if ($ncfasg_realizado)
							        			<a class="btn" style="background: #01e0bc; color: #fff;">Realizado</a>

							        			<button type="button" class="btn btn-info" onclick="$('#ncfasModal').modal('show');">Imprimir NCFAS-G</button>
											
											@else
												<a class="btn" style="background: #01e0bc; color: #fff;">No realizado</a>

											@endif
											
											<div id="val_diag_ncfas" class="alert alert-secondary text-danger p-1" style=" display: none;">
												<small>* Falta completar este item.</small>
											</div>
							        	</div>

						        	</div>
						        	<br>
					        	@endif


					    	</div>
					    </div>
					</div>
					</div>	
				<!-- FIN NCFAS - G -->

				<!-- ALERTAS TERRITORIALES  -->
				<div class="card colapsable shadow-sm" id="contenedor_contenedor_at_diagnostico">
					<a class="btn text-left p-0 collapsed" id="desplegar_contenedor_at_diagnostico" data-toggle="collapse" data-target="#contenedor_at_diagnostico" aria-expanded="false" aria-controls="contenedor_at_diagnostico" onclick="">
						<div class="card-header p-3">
							<h5 class="mb-0">
								<button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
								&nbsp;&nbsp; Alertas Territoriales Asociadas
							</h5>
						</div>
					</a>				
					<div class="collapse" id="contenedor_at_diagnostico">
						<div class="card-body">
							<br>							
							<div class="card colapsable shadow-sm" id="contenedor_at_diagnostico_tipo">
								<a class="btn text-left p-0 collapsed" id="desplegar_at_diagnostico_tipo" data-toggle="collapse" data-target="#at_diagnostico_tipo" aria-expanded="false" aria-controls="at_diagnostico_tipo" onclick="listarATPriorizada()">
									<div class="card-header p-3">
										<h5 class="mb-0">
											<button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
											&nbsp;&nbsp; Alertas Territoriales
										</h5>
									</div>
								</a>				
								<div class="collapse" id="at_diagnostico_tipo">
									<div class="card-body">
										<br>
										<div class="form-group">
											<table class="table table-striped table-hover w-100" cellspacing="0" id="tabla_at_diagnostico">
												<thead>
													<tr>
														<th>Tipo de Alerta</th>
														<th>Cantidad</th>
														<th>Acciones</th>											
														<th>Estado</th>											
														<th>Información Relevante</th>	
														<th>Dimensiones NCFAS-G Vinculadas</th>											
												</tr>
												</thead>
												<tbody></tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
							<br>
							<div class="card colapsable shadow-sm" id="contenedor_resumen_ncfas">
								<a class="btn text-left p-0 collapsed" id="desplegar_resumen_ncfas" data-toggle="collapse" data-target="#resumen_ncfas" aria-expanded="false" aria-controls="resumen_ncfas" onclick="if($(this).attr('aria-expanded') == 'false') listarDiagnosticoIntegral({{$caso_id}});">
									<div class="card-header p-3">
										<h5 class="mb-0">
											<button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
											&nbsp;&nbsp; Resultados NCFAS-G
										</h5>
									</div>
								</a>				
								<div class="collapse" id="resumen_ncfas">
									<div class="card-body">
										<br>
										<div class="card-body">
											@includeif('ficha.listar_duagnostico_integrar_eva_diag')
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>				

				<div id="frmlistadoAlertasporTipo" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog">
					<div class="modal-dialog modal-xl" role="document">
						<div class="modal-content p-4">
							<div class="modal-header">
								<div style="margin: 0 auto;"><h5>AT vinculadas a las dimensiones del NCFAS-G</h5></div>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute; margin: 0; top: 5px; right: 33px;">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							
							<div class="modal-body">
								<div class="table-responsive">

									<table class="table table-striped table-hover w-100" cellspacing="0" id="tabla_alertas">			
										<thead>			
											<tr>
												<th class="text-center">Nombre NNA</th>
												<th class="text-center">Alerta Territorial</th>
												<th class="text-center">Estado Alerta</th>
												<th class="text-center">Dimensiones</th>
												<th class="text-center">Usuario de Creación</th>
												<th class="text-center">Acciones</th>
											</tr>
										</thead>
										<tbody></tbody>
									</table>
								</div>
							</div>
							<div class="modal-footer" style="background-color: white;">								
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
							</div>
						</div>
					</div>
				</div>
				<!-- FIN ALERTAS TERRITORIALES  -->

				<div id="frmlistadoDimensiones" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog">
					<div class="modal-dialog" role="document">
						<div class="modal-content p-4">
							<div class="modal-header">
								<div style="margin: 0 auto;"><h5>Dimensiones Vinculadas</h5></div>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute; margin: 0; top: 5px; right: 33px;">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							
							<div class="modal-body">
								<div class="table-responsive">

									<table class="table table-striped table-hover w-100" cellspacing="0" id="tabla_dim_vinculadas">			
										<thead>			
											<tr>
												<th class="text-center">Dimensión</th>
												
											</tr>
										</thead>
										<tbody></tbody>
									</table>
								</div>
							</div>
							<div class="modal-footer" style="background-color: white;">								
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
							</div>
						</div>
					</div>
				</div>

				<!-- BITACORA ESTADO ACTUAL -->
				<div class="card shadow-sm alert-info">
					<div class="card-header p-3">
						<h5 class="mb-0"><i class="fa fa-pencil"></i> Bitácora</h5>
			      	</div>
			      	<div class="card-body">
					  	<label for="bitacora_estado_diagnostico" style="font-weight: 800;" class="">Estado actual del caso:</label>
					  	<!-- <textarea onkeypress='return caracteres_especiales(event)'class="form-control txtAreEtapa " name="bit-etapa-prediagnostico" id="bitacora_estado_prediagnostico" rows="3" onBlur="cambioEstadoCaso(13, {{ $caso_id }}, $(this).val());" @if (config('constantes.en_prediagnostico')  != $estado_actual_caso) disabled @endif>{{ $bitacoras_estados[5] }}</textarea> -->
					  	<!-- <textarea onkeypress='return caracteres_especiales(event)'class="form-control txtAreEtapa " name="bit-etapa-diagnostico" id="bitacora_estado_diagnostico" rows="3" onBlur="cambioEstadoCaso(3, {{ $caso_id }}, $(this).val());" @if (config('constantes.en_diagnostico')  != $estado_actual_caso) disabled @endif>{{ $bitacoras_estados[0] }}</textarea> -->
					  	@if ($modo_visualizacion == 'visualizacion')
					  		<div class="text-success" style="word-break: break-all;">
								<label class="font-weight-bold">{{ $bitacoras_estados[0] }}</label>
							</div>
					  	@elseif ($modo_visualizacion == 'edicion')
					  		<textarea maxlength="2000" onkeypress='return caracteres_especiales(event)'class="form-control txtAreEtapa " name="bit-etapa-diagnostico" id="bitacora_estado_diagnostico" rows="3" onBlur="cambioEstadoCaso('b3', {{ $caso_id }}, $(this).val());" @if (config('constantes.en_diagnostico')  != $estado_actual_caso) disabled @endif>{{ $bitacoras_estados[0] }}</textarea>
					  	@endif

					  </div>
				</div>
				<!-- FIN BITACORA ESTADO ACTUAL -->

				@if ($modo_visualizacion == 'edicion')
					<div class="text-center">
						<!-- <button type="button" id="btn-etapa-diagnostico" class="btn btn-success btnEtapa" onclick="siguienteEtapa(8, {{ $caso_id }});" disabled>Ir a la siguiente etapa - <strong>Elaborar PAF</strong></button> -->

						<button type="button" id="btn-etapa-diagnostico" class="btn btn-success btnEtapa" onclick="siguienteEtapa({{config('constantes.en_elaboracion_paf')}}, {{ $caso_id }});" disabled>Ir a la siguiente etapa - <strong>Elaborar PAF</strong></button>
					</div>
				@endif
			<!--</form>-->
	
			<!-- Fin Frm diagnostico -->

@includeif('ficha.ncfas_modal_imprimir')

@includeif('ficha.formulario_grupo_familiar')

<input type="hidden" name="valida_doc" id="valida_doc" value="0">

<input type="hidden" name="ncfasg_realizado" id="ncfasg_realizado" value="{{$ncfasg_realizado}}">

<script>

$(document).ready(function() {
	$("#doc_cons2").change(function(e) {
			$("#adj_const").submit();
	});

	$("#adj_const").submit(function(e){
		bloquearPantalla();  		
	
	// evito que propague el submit
	e.preventDefault();

		var form = document.getElementById('adj_const');
		
		var formData = new FormData(form);
		  formData.append('tipo', $("#adj_const").val());
		  formData.append('_token', $('input[name=_token]').val());
		formData.append('_token', $('input[name=_token]').val());

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
		});
		
        $.ajax({
            url: '{{ route("enviararhcons") }}',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
				console.log(response);
				desbloquearPantalla();

				if (response.estado == 1){

						$("#alert-err-doc").hide();
					$("#alert-err-doc-ext").hide();
					$("#alert-doc").show();
					//$("#valida_doc").val()=1;
					$("#valida_doc").val(1);
				
				setTimeout(function(){ 
					$("#alert-doc").hide();
				}, 5000);

				location.reload();
				//window.location.reload();

				}else if (response.estado == 0){
				$("#alert-err-doc").show();
				setTimeout(function(){ $("#alert-err-doc").hide(); }, 5000);
				}
            },
			error: function(jqXHR, text, error){

			desbloquearPantalla();

			$("#alert-err-doc-ext").show();
			setTimeout(function(){ $("#alert-err-doc").hide(); }, 5000);
			setTimeout(function(){ $("#alert-err-doc-ext").hide(); }, 5000);

			// toastr.error('Validation error!', 'No se pudo Añadir los datos<br>' + error, {timeOut: 5000});
			}
        });
        return false;
	});
});
</script>

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

		if ($('#documentoconsentimiento').val()=='na'){
			$('#descargarconsentimiento').hide();
		}


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
		$("#alert-err-doc-ext").hide();

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

		  bloquearPantalla();  		
	
		  // evito que propague el submit
		  e.preventDefault();
		  
		  // agrego la data del form a formData
		  console.log("entra al metodo");
		  var form = document.getElementById('adj_cons');
		
		  var formData = new FormData(form);
		  formData.append('tipo', $("#adj_cons").val());
		  formData.append('_token', $('input[name=_token]').val());
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
		      contentType: false,
		      processData: false,
		      success:function(resp){

		      		desbloquearPantalla();

		           if (resp.estado == 1){

		           		$("#alert-err-doc").hide();
		  				$("#alert-err-doc-ext").hide();
                    	$("#alert-doc").show();
						//$("#valida_doc").val()=1;
						$("#valida_doc").val(1);
					
					setTimeout(function(){ 
						$("#alert-doc").hide();
					 }, 5000);

					location.reload();
					//window.location.reload();

					}else if (resp.estado == 0){
                    $("#alert-err-doc").show();
					setTimeout(function(){ $("#alert-err-doc").hide(); }, 5000);
				}
		      },
		      error: function(jqXHR, text, error){

		      		 desbloquearPantalla();

		      		$("#alert-err-doc-ext").show();
					setTimeout(function(){ $("#alert-err-doc").hide(); }, 5000);
					setTimeout(function(){ $("#alert-err-doc-ext").hide(); }, 5000);

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

	function listarATPriorizada(){

		if(!$("#desplegar_at_diagnostico_tipo").attr("aria-expanded")) return false;

		let data = new Object();
		data.cas_id = {{ $caso_id }};

		let tabla_at_diagnostico = $('#tabla_at_diagnostico').DataTable();
        tabla_at_diagnostico.clear().destroy();

        tabla_at_diagnostico = $('#tabla_at_diagnostico').DataTable({
            "language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
            "lengthChange": false,
			"info": 		false,
			"searching":	false,
			"paging":		false,
            "ajax": {
                "url": "{{ route('listar.alerta.priorizada') }}",
                "type": "GET",
                "data": data
            },
            "columnDefs": [
                { //TIPO DE ALERTAS
                    "targets": 0,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
				{ //CANTIDAD
                    "targets": 1,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //ACCIONES
                    "targets": 2,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                        $(td).css("width", "30%");
                    
                    }
                },
                { //ESTADO
                    "targets": 3,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                        $(td).css("width", "30%");
                    
                    }
                },
                { //INFORMACION RELEVANTE
                    "targets": 4,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                        $(td).css("width", "30%");
                    
                    }
                },
                { //DIMENSION
                    "targets": 5,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                        $(td).css("width", "30%");
                    
                    }
                }
            ],				
            "columns": [
                        { //TIPO DE ALERTAS
                            "data": "ale_tip_nom",
                            "className": "text-center"
                        },
						{ //CANTIDAD
                            "data": "cantidad",
                            "className": "text-center"
                        },
                        { //ACCIONES
                            "data": "ale_tip_id",
                            "className": "text-center",
                            "render": function(data, type, row){
                            //INICIO DC
                            			let html = '';
										if(row.ale_man_dir_usu != null){ 
											html = '<a href="{{ route('alerta.editar') }}/'+ row.ale_man_id +'" class="btn btn-primary" target="_blank">' +
												'<i class="fas fa-search"></i> Ver Alerta' +
											'</a>';
										}
							//FIN DC
										return html;
                                    }
                        },
                        { //ESTADO
                            "data": "ale_man_id",
                            "className": "text-center",
                            "render": function(data, type, row){
								let html = '';
								if(row.est_ale_id == 1){ //Por validar
									// INICIO CZ SPRINT 59
									@if($est_cas_fin)
									html = '<select disabled id="sel_estado_'+data+'" onChange="validarAlerta(this.value, '+data+')" style="padding: 8px;"><option value="'+row.est_ale_id+'">'+row.est_ale_nom+'</option></select>';									
									@else 
									html = '<select id="sel_estado_'+data+'" onChange="validarAlerta(this.value, '+data+')" style="padding: 8px;"><option value="'+row.est_ale_id+'">'+row.est_ale_nom+'</option></select>';									
									@endif
									// FIN CZ SPRINT 59
									let data2 = new Object();
									data2.estado_id = row.est_ale_id;
									$.ajax({
                            			type: "GET",
                            			url: "{{route('listar.alerta.estados')}}",
                            			data: data2
                            		}).done(function(resp){
                            			var obj = JSON.parse(resp);
                            			$('#sel_estado_'+data).html($('<option />', {
                                            text: row.est_ale_nom,
                                            value: row.est_ale_id,
                                          }));
                            			for (var i = 0; i < obj.length; i+=1) {
                            				 $('#sel_estado_'+data).append($('<option />', {
                                                text: obj[i].est_ale_nom,
                                                value: obj[i].est_ale_id,
                                              }));
                            			}
                            			                     
                            		}).fail(function(objeto, tipoError, errorHttp){
                            			desbloquearPantalla();
                                        manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
                                        return false;
                                    });
                                    									
								}else{
									// INICIO CZ SPRINT 59
									@if($est_cas_fin)
										html = '<select disabled id="sel_estado_'+data+'" style="padding: 8px;">'+
										'<option value="'+row.est_ale_id+'">'+row.est_ale_nom+'</option>'+
										'</select>';
									@else 
									html = '<select id="sel_estado_'+data+'" style="padding: 8px;">'+
									'<option value="'+row.est_ale_id+'">'+row.est_ale_nom+'</option>'+
									'</select>';
									@endif
									// FIN CZ SPRINT 59
								}
								
										return html;
                            }
                        },
                        { //INFORMACION RELEVANTE
                            "data": "ale_man_info_rel",
                            "className": "text-center"
                        },
                        //INICIO DC
                        { //DIMENSION
                            "data": "ale_man_id",
                            "className": "text-center",
                            "render": function(data, type, row){
                            	//let html = '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#frmlistadoDimensiones" onclick="verDimension('+data+');"><i class="fas fa-search"></i> Ver</button>';
								let html = '<table class="table-striped w-100" cellspacing="0" id="tabla_dim_vinculadas'+data+'">	'+		
										'<thead>'+			
											'<tr>'+
												'<th></th>'+												
											'</tr>'+
										'</thead>'+
										'<tbody></tbody>'+
									'</table>';		
									
									
									verDimension(data);
									
										return html;
                            }
                            }
                        //FIN DC
                    ]
            });

			
	}
	//INICIO DC
	function verDimension(idAlerta){
		let data = new Object();
		data.cas_id = {{ $caso_id }};
		data.alerta_id = idAlerta;
		let tabla = $('#tabla_dim_vinculadas'+idAlerta).DataTable();
        tabla.clear().destroy();
        tabla = $('#tabla_dim_vinculadas'+idAlerta).DataTable({
            "language"	: { 
            	
            	"emptyTable": "Sin datos",
            	"loadingRecords": "Cargando..."
            },
            "lengthChange": false,
			"info": 		false,
			"searching":	false,
			"paging":		false,
            "ajax": {
                "url": "{{ route('listar.dimension.vinculada') }}",
                "type": "GET",
                "data": data
            },
            "drawCallback": function() {
              $(this.api().table().header()).hide();
              
          	},
          	"rowCallback" : function(nRow, aData, iDisplayIndex) {
            	$(nRow).css("background-color", "rgba(0,0,0,0)");
          	},
          	fnInitComplete : function() {
      			if ($(this).find('tbody .dataTables_empty').length>0) {
         			$(this).parent().hide();
      			}
            },
            "columnDefs": [
                { //TIPO DE ALERTAS
                    "targets": 0
                }
            ],				
            "columns": [
                        { //TIPO DE ALERTAS
                            "data": "dimension"
                        }
                    ]
            });
            
	}
	//FIN DC
	//INICIO DC
	function asignaEstado(){
		let data = new Object();
		data.cas_id = {{ $caso_id }};
		$.ajax({
			type: "GET",
			url: "{{route('listar.alerta.priorizada')}}",
			data: data
		}).done(function(resp){
			var obj = JSON.parse(resp);
			for (var i = 0; i < obj.data.length; i+=1) {
				if(obj.data[i].est_ale_id == 1){ //Por validar
					$('#sel_estado_'+obj.data[i].ale_man_id).html($('<option />', {
                        text: 'Por Validar',
                        value: 1,
                      }));
                      $('#sel_estado_'+obj.data[i].ale_man_id).append($('<option />', {
                        text: 'Validada',
                        value: 2,
                      }));
                      $('#sel_estado_'+obj.data[i].ale_man_id).append($('<option />', {
                        text: 'No Validada',
                        value: 3,
                      }));
				}else if(obj.data[i].est_ale_id == 2){ //Validada
					$('#sel_estado_'+obj.data[i].ale_man_id).html($('<option />', {
                        text: 'Validada',
                        value: 2,
                      }));
                     
				}else if(obj.data[i].est_ale_id == 3){ //No validada
					$('#sel_estado_'+obj.data[i].ale_man_id).html($('<option />', {
                        text: 'No Validada',
                        value: 3,
                      }));
                       
				}else if(obj.data[i].est_ale_id == 4){ //Incorporada
					$('#sel_estado_'+obj.data[i].ale_man_id).html($('<option />', {
                        text: 'Incorporada',
                        value: 4,
                      }));                       
				}else if(obj.data[i].est_ale_id == 5){ //En atencion
					$('#sel_estado_'+obj.data[i].ale_man_id).html($('<option />', {
                        text: 'En atencion',
                        value: 5,
                      }));                       
				}
              $('#sel_estado_'+obj.data[i].ale_man_id).val(obj.data[i].est_ale_id);
            }

		}).fail(function(objeto, tipoError, errorHttp){
				desbloquearPantalla();
                manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
                return false;
        });
	}
	//FIN DC
	function validarAlerta(estado, alerta){
		
		let confirmacion = confirm("¿Seguro(a) que desea cambiar el estado de la Alerta?");	
		if (confirmacion == false) return false;
		bloquearPantalla();
		let data = new Object();

		data.cas_id = {{$caso_id}};
		data.ale_estado = estado;
		data.ale_id = alerta;
		data.nom_estado = $("#sel_estado_"+alerta+" option:selected").text();
		
		$.ajax({
			type: "GET",
			url: "{{route('validar.nna.alerta')}}",
			data: data
		}).done(function(resp){
			desbloquearPantalla();
			if(resp == 1){
				mensajeTemporalRespuestas(1, 'Se ha actualizado el estado de la alerta.');
				listarATPriorizada();
			}else{
				mensajeTemporalRespuestas(0, 'Ha ocurrido un error al intentar actualizar la alerta.');
			}

		}).fail(function(objeto, tipoError, errorHttp){
				desbloquearPantalla();
                manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
                return false;
        });
	}
	function visualizarATporTipo(tipo){

			let data = new Object();
			data.cas_id = {{$caso_id}};
			data.ale_tip_id = tipo;

			let tabla_alertas = $('#tabla_alertas').DataTable();
        	tabla_alertas.clear().destroy();

        	tabla_alertas = $('#tabla_alertas').DataTable({
            "language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
            "lengthChange": false,
			"info": 		false,
			"searching":	false,
			"paging":		false,
            "ajax": {
                "url": "{{ route('alertas.asociadas.tipo') }}",
                "type": "GET",
                "data": data
            },
 				"columnDefs": [
            		{ //Nombre de NNA
						"targets": 0,
						"className": 'dt-head-center dt-body-center',
						"createdCell": function (td, cellData, rowData, row, col) {
							$(td).css("vertical-align", "middle");
						
						}
					},
            		{ //Alerta Territorial
						"targets": 1,
						"className": 'dt-head-center dt-body-center',
						"createdCell": function (td, cellData, rowData, row, col) {
							$(td).css("vertical-align", "middle");
						
						}
					},
            		{ //Estado de Alerta
						"targets": 2,
						"className": 'dt-head-center dt-body-center',
						"createdCell": function (td, cellData, rowData, row, col) {
							$(td).css("vertical-align", "middle");
						
						}
					},
            		{ //Dimension
						"targets": 3,
						"className": 'dt-head-center dt-body-center',
						"createdCell": function (td, cellData, rowData, row, col) {
							$(td).css("vertical-align", "middle");
						
						}
					},
            		{ //Usuario de Creacion
						"targets": 4,
						"className": 'dt-head-center dt-body-center',
						"createdCell": function (td, cellData, rowData, row, col) {
							$(td).css("vertical-align", "middle");
						
						}
					},
            		{ //Acciones
						"targets": 5,
						"className": 'dt-head-center dt-body-center',
						"createdCell": function (td, cellData, rowData, row, col) {
							$(td).css("vertical-align", "middle");
						
						}
					},
        		],				
				"columns": [
					{
						"data"		: "ale_man_nna_nombre",
						"name"		: "ale_man_nna_nombre",
						"className"	: "text-center",
						"visible"	: true,
						"orderable"	: true,
						"searchable": true,
						"render" : function (data, type, full, meta){
							let run = esconderRut(full.rut_completo, "{{ config('constantes.ofuscacion_run') }}");

							return '<label data-toggle="tooltip" data-html="true" title="R.U.N.: ' + run + '">' + full.ale_man_nna_nombre + '</label>';
						}
					},
					{ "data": "ale_tip_nom", "className": "text-left" },
					{ "data": "est_ale_nom", "className": "text-center" },
					{ "data": "dimension", "className": "text-center" },
					{ "data": "usuario", "className": "text-center" },
					{
						"orderable": false,
						"className": "text-center",
						'render': function (data, type, full, meta){
							return 	'<a href="{{ route('alerta.editar') }}/'+ full.ale_man_id +'" class="btn btn-primary" target="_blank">' +
								'Ver' +
								'</a>';

						}
					}
				]
			});
	}

	function desestimarAlertaAsociadas(tipo){
		let confirmacion = confirm("¿Desea desestimar la Alerta?");		
        if (confirmacion == false) return false;

		bloquearPantalla();
		let data = new Object();

		data.cas_id = {{$caso_id}};
		data.ale_tip_id = tipo;

		$.ajax({
			type: "GET",
			url: "{{route('desestimar.alertas.tipo')}}",
			data: data
		}).done(function(resp){
			desbloquearPantalla();
			if(resp.estado == 1){
				mensajeTemporalRespuestas(1, resp.mensaje);
				listarATPriorizada();
			}
			if(resp.estado == 0){
				mensajeTemporalRespuestas(0, resp.mensaje);
			}

		}).fail(function(objeto, tipoError, errorHttp){

				desbloquearPantalla();
                manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
                return false;

        });

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
