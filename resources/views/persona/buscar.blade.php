@extends('layouts.main')
@section('contenido')
<section class="cabecera">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<h2><span class="oi oi-magnifying-glass"></span> Buscar Ficha </h2>
			</div>
		</div>
	</div>
</section>

<section class="pr-3 pl-3">
	<div class="container-fluid p-3 alert alert-info">
		<h4 class="text-center">Realice una b&uacute;squeda por RUN o Nombres para ver la ficha de una afectado.</h4>
		<hr>
		<div class="row justify-content-md-center">
			<div class="col-md-6">
				<div class="input-group mb-3">
					<input onkeypress='return caracteres_especiales(event)' type="text" class="form-control form-control-lg" placeholder="Buscar" aria-label="Buscar" aria-describedby="basic-addon2">
					<div class="input-group-append">
						<button class="btn btn-primary btn-lg" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Buscar</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
	@stop