<div id="terapiaPtf" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg modal-ptf" role="document">
		<div class="modal-content p-4">
			<div class="modal-header">
				<div style="margin: 0 auto;"><h5>Plan Terapia Familiar</h5></div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute; margin: 0; top: 5px; right: 33px;">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<div class="form-group" id="contenedor_tabla_ptf_sesion">
					<h5>Sesiones Familiares</h5>
					<!-- inicio ch -->
					Nº de Sesiones Familiares Realizadas: <span id="sesiones_realizadas"></span>
					<br>
					Nº de Sesiones Familiares Comprometidas: <span id="sesiones_comprometidas"></span>
					<br>
					<!-- fin ch -->
					Porcentaje de Logro: <span id="porcentaje_logro"></span>
					<table width="100%" class="table table-bordered table-hover table-striped" id="tabla_ptf_sesion">
						<thead>
							<th>Id</th>
							<th>Sesión</th>
							<th>Actividad</th>
							<th>Objetivo</th>
							<th>Meta /<br>Resultado Esperado</th>
							<th>Estrategias utilizadas</th>
							<th>Resultado Alcanzado</th>
							<th>Observaciones y<br>Comentarios</th>
							<th>Fecha</th>
							@if ($modo_visualizacion == 'edicion')
								<th>Acciones</th>
							@endif
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
				

				<div class="form-group" id="contenedor_tabla_ptf_taller">
					<h5>Sesiones Multifamiliares</h5>
					<!-- inicio ch -->
					Nº de Sesiones Multifamiliares Realizadas: <span id="sesiones_realizadas2"></span>
					<br>
					Nº de Sesiones Multifamiliares Comprometidas: <span id="sesiones_comprometidas2"></span>
					<br>
					<!-- fin ch -->
					Porcentaje de Logro: <span id="porcentaje_logro2"></span>
					<table width="100%" class="table table-bordered table-hover table-striped" id="tabla_ptf_taller">
						<thead>
							<th>Id</th>
							<th>Sesión</th>
							<th>Actividad</th>
							<th>Objetivo</th>
							<th>Meta /<br>Resultado Esperado</th>
							<th>Estrategias utilizadas</th>
							<th>Resultado Alcanzado</th>
							<th>Observaciones y<br>Comentarios</th>
							<th>Fecha</th>
							@if ($modo_visualizacion == 'edicion')
								<th>Acciones</th>
							@endif
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
				
			</div>
			<div class="modal-footer" style="background-color: white;">
		
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<style>
.modal-ptf {
    max-width: 100%;
}
</style>