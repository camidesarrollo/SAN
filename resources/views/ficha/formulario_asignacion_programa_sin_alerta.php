<div id="asignarProgramaIntegranteSinAlerta" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="asignarProgramaIntegranteSinAlerta" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content p-4">
			<div class="p-4">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" style="position: absolute; right: 38px; top: 23px; width: 23px; height: 23px; padding: 0; margin: 0;">&times;</span>
				</button>
				<div class="row">
					<div class="col text-center">
						<h4 class="modal-title"><b>Derivar Programas sin Alertas</b></h4>
						<br>
					</div>
				</div>

				<div class="row">
					<div class="col-12">
						<h5><b>Nombre: </b><small id ="nom-int-fam"></small></h5>
					</div>
		
					<div class="col-12">
						<h5><b>Run: </b><small id ="run-int-fam"></small></h5>
					</div>	
				</div>
				<hr>

					<!-- Mensajes de Alertas -->
					<div class="alert alert-success alert-dismissible fade show" id="alert-asig-sin-alert" role="alert" style="display:none;">
						Registro Guardado Exitosamente.
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="alert alert-danger alert-dismissible fade show" id="alert-error-sin-alert" role="alert" style="display:none;">
						Error al momento de guardar el registro. Por favor intente nuevamente.
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<!-- Fin Mensajes de Alertas -->

				<div class="p-4" id="body_asignacion_programas_sin_alertas">

					<h5><b>Programas/Establecimientos:</b></h5>
					<!-- //CZ SPRINT 74 -->
					<div id="contenedor_tabla_programas_sin_alertas" style="margin-top: 15px; display:none">
					<!-- //CZ SPRINT 74 -->
						<table class="table table-bordered cell-border" id="tabla_programas_sin_alertas" style="width: 100%">
							<thead>
								<tr>
									<th>Programa</th> 
									<th></th>
									<th>Establecimiento</th>
									<th>Acciones</th>
									<th>Observaciones Brecha</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>						
						<hr>

					</div>
<!-- //CZ SPRINT 74 -->
					<div id="mensaje_tabla_programas_sin_alertas">

					</div>
<!-- //CZ SPRINT 74 -->
					<br>

				</div>

				<div class="p-4" id="">

					<h5><b>Derivaciones:</b></h5>
		
					<div id="" style="margin-top: 15px;">
						<table class="table table-bordered cell-border" id="tabla_programas_asignacion" style="width: 100%">
							<thead>
								<tr>
									<th>Programa</th> 
									<th>Establecimiento</th>
									<th>Acciones</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
						
						<hr>

					</div>

					<br>

				</div>

				<div class="text-right">
				  <button type="button" class="btn btn-default" data-dismiss="modal" style="background-color: #858898; color: white;">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
</div>




<style type="text/css">
	.boton-asig-des{
		width: 100%;
	}

	.div-asig-pro{
		padding-bottom: 11px;
	}

	.div-asig-estab{
		padding-left: 40px; 
		padding-bottom: 11px;
	}
</style>
