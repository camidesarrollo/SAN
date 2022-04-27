<section>
	<div class="container-fluid">
		<div class="card p-4 shadow-sm">

				<h5>Información de Educación</h5>
	
					<div class="row">
						<div class="col">
							<h5>Rol</h5>
							<h5>Nombre</h5>
							<h5>Nivel Enseñanza</h5>
							<h5>Codigo Grado</h5>
							<h5>Letra Curso </h5>
							<h5>Asistencia </h5>
							<h5>Promedio </h5>
							<h5>Situacion Final </h5>
						</div>
						<div class="col">
							@if(!empty($caso->rbd_rbd))
								
								<h5><strong>{{ $caso->rbd_rbd }}</strong> </h5>
								<h5><strong> {{ ucwords(mb_strtolower($caso->rbd_nom)) }} </strong> </h5>
								<h5><strong> {{ $nivel[array_rand($nivel)] }} </strong> </h5>
								<h5><strong> {{ $caso->cod_gra }} </strong> </h5>
								<h5><strong> {{ $caso->gra_let }} </strong> </h5>
							@endif
						</div>
					</div>


		</div>
	</div>
</section>
<!--<section class="p-1">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-md-12">
				<h4><span class="oi oi-puzzle-piece"></span> Información de Salud</h4>
				<div class="card p-4">
					<div class="row">
					No presenta datos para esta dimensión
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="p-1">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-md-12">
				<h4><span class="oi oi-puzzle-piece"></span> Información de Justicia</h4>
				<div class="card p-4">
					<div class="row">
					No presenta datos para esta dimensión
					</div>
				</div>
			</div>
		</div>
	</div>
</section>-->