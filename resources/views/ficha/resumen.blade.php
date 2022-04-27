<div id="testModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="diagnosticarModal" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="card p-4 shadow-sm">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h3> Vista rápida del Caso</h3>
				<hr>
				<h4>Caso</h4>
				<div class="card-group">
					<div class="card">
						<div class="card-body">
							<h5 class="card-title">Nombre</h5>
							<p id="vr_nombre" class="card-text"></p>
						</div>
					</div>
					<div class="card">
						<div class="card-body">
							<h5 class="card-title">RUN</h5>
							<p id="vr_run" class="card-text"></p>
						</div>
					</div>
					<div class="card">
						<div class="card-body">
							<h5 class="card-title">Edad</h5>
							<p id="vr_edad" class="card-text"></p>
						</div>
					</div>
					
				</div>
				<div class="card-group">
					<div class="card">
						<div class="card-body">
							<h5 class="card-title">Dirección</h5>
							<p id="vr_direccion" class="card-text"></p>
							<p id="vr_comuna" class="card-text"></p>
							<p id="vr_provincia" class="card-text"></p>
							<p id="vr_region" class="card-text"></p>
						</div>
					</div>
					<div class="card">
						<div class="card-body">
							<h5 class="card-title">Registro Social de Hogares</h5>
							<a class="btn btn-warning btn-sm" id="vr_rsh" href="#"><span class="oi oi-data-transfer-download"></span> </span> Descargar Cartola RSH</a>
							<input type="hidden" id="vr_url_rsh" value="{{ route('caso.cartola') }}">
						</div>
					</div>
				</div>
				
				<hr>
				<h4>Beneficios</h4>
				<div class="card">
					<div class="card-body"> <!-- inicio Andres F -->
						<h5 class="card-title">Últimos beneficios recibidos</h5>
						<ul class="list-group" id="ultimos_beneficios_sociales" data-ultimos-beneficios-href="{{  route('ultimosbeneficios') }}"></ul>
					</div> <!-- fin Andres F -->
				</div>
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Beneficios Históricos</h5>
						<ul class="list-group" id="historico_beneficios_sociales" data-historico-beneficios-href="{{  route('historicobeneficios') }}"></ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>