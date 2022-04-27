@extends('layouts.main')

@section('contenido')
	
	<div class="container-fluid">
		<div class="card p-4 shadow-sm text-center">
			<h1 style="font-size: 3.0em ">404</h1>
			<h3>La pagina que Busca no existe</h3>
			<hr>
			<a class="btn btn-primary" onclick="history.back()" >Volver</a> 
			<a class="btn btn-primary" href="/" >Ir al inicio</a> 
		</div>
	</div>


@endsection