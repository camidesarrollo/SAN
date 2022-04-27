<div id="asignarProgramaIntegrante" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="asignarProgramaIntegrante" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content p-4">
			<div class="p-4">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" style="position: absolute; right: 38px; top: 23px; width: 23px; height: 23px; padding: 0; margin: 0;">&times;</span>
				</button>
				<div class="row">
					<div class="col text-center">
						<h4 class="modal-title"><b>Derivar Programas con Alertas</b></h4>
						<small id ="nom-int-asig"></small>
					</div>
				</div>

				<!-- //CZ SPRINT 74 -->
				<div class="tabla_derivarProgramaConAlerta" style="display:none">
				<hr>
				<div class="p-4" id="body_asignacion_programas"></div>

				<div class="p-4" id="cuerpo_asignacion_programas">
					<h5><b>Programas/Establecimientos:</b></h5>		
							<div id="contenedor_tabla_program" style="margin-top: 15px;">
						<table class="table table-bordered cell-border" id="tabla_programas_con_alertas" style="width: 100%">
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
					<br>
				</div>				
				</div>
				<div class="mensaje_tabla"></div>
				<!-- //CZ SPRINT 74 -->
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