<section class="p-1">
	<div class="container">
		<div class="card bg-verde p-2">
			<div class="row align-items-center">
				<div class="col-md-1 text-center">
					@if(Session::get('perfil')==1 || Session::get('perfil')==2)
						<h1><span class="oi oi-shield"></span></h1>
					@else
						<h1><span class="oi oi-book"></span></h1>
					@endif
				</div>
				<div class="col-md-6">
					<p>Bienvenido</p>
					<h4>{{ Session::get('nombre_usuario') }}</h4>
					<h6>RUN: {{ Session::get('rut') }}</h6>
				</div>
				<div class="col-md-5">
					<ul class="list-group">
						<li class="list-group-item d-flex justify-content-between align-items-center">
							<span class="badge badge-info badge-pill"> Rol</span> {{ ucfirst(Session::get('tipo_perfil')) }}
						</li>
						<li class="list-group-item d-flex justify-content-between align-items-center">
							<span class="badge badge-info badge-pill"> Perfil</span> {{ Session::get('nombre_perfil') }}
						</li>
						<li class="list-group-item d-flex justify-content-between align-items-center">
							<span class="badge badge-info badge-pill">Region</span> {{ ucwords(mb_strtolower(Session::get('region'))) }}
						</li>
						<li class="list-group-item d-flex justify-content-between align-items-center">
							<span class="badge badge-info badge-pill">Comuna(s)</span> <!--{{ ucwords(mb_strtolower(Session::get('comuna'))) }}-->
							@foreach(Session::get('comunas') as $comunas)
								{{$comunas->com_nom}}<br>
							@endforeach
						</li>
					</ul>
				</div>
		</div>
	</div>
</section>