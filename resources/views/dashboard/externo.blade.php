@extends('layouts.main')

@section('contenido')
	<section class=" p-1 cabecera">
		<div class="container-fluid">
			<div class="row align-items-center">
				<div class="col-md-12">
					<h2><span class="oi oi-pencil"></span> </h2>
				</div>
			</div>
		</div>
	</section>
	
	@include('layouts.id')
	<hr>
	
	<section class="p-1">
		<div class="container panel">
			
			<h4 class="text-center">Puede realizar las siguientes tareas</h4>
			
			<div class="row">
				<div class="col-12">
					<div class="row">
						<div class="col-6 p-3">
							<div class="card p-3 text-center ">
								<h3><span class="oi oi-bell"></span></h3>
								<a href="{{ route('alertas.listar') }}"><h4>Registrar Alerta </h4></a>
								<p>Podra crear una alerta para un Infante</p>
							</div>
						</div>
				<!-- 		<div class="col-6 p-3">
							<div class="card p-3 text-center ">
								<h3><span class="oi oi-list"></span></h3>
								<a href="{{ route('dimension.main') }}"><h4>Dimensiones</h4></a>
								<p>Mantenedor de Dimensiones</p>
							</div>
						</div>
						<div class="col-6 p-3">
							<div class="card p-3 text-center ">
								<h3><span class="oi oi-list"></span></h3>
								<a href="{{ route('ofertas.main') }}"><h4>Ofertas</h4></a>
								<p>Mantenedor de Ofertas</p>
							</div>
						</div>
						<div class="col-6 p-3">
							<div class="card p-3 text-center ">
								<h3><span class="oi oi-list"></span></h3>
								<a href="{{ route('accion.main') }}"><h4>Acciones</h4></a>
								<p>Mantenedor de Acciones</p>
							</div>
						</div> -->
		<!-- 				<div class="col-6 p-3">
							<div class="card p-3 text-center ">
								<h3><span class="oi oi-list"></span></h3>
								<a href=""><h4>Alertas</h4></a>
								<p>Mantenedor de Alertas</p>
							</div>
						</div> -->
					</div>
				</div>
			</div>
			
		</div>
	</section>



@stop