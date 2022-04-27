		<!-- HIDDEN -->
		 <input type="hidden" id="url_runificador" value="{{ route('consulta.runificador')  }}">
		<!-- HIDDEN  -->

		<nav id="sidebar" class="est_men_izq">
            <div class="sticky-top">
                <button id="sidebarCollapse" class="btn" onclick="cambiarMenu();">
                    <span id="bot-menu" class="fa fa-bars" data-toggle="tooltip" data-placement="right" title="Menu"></span>

                    <span id="bot-esconder" class="fa fa-angle-left" data-toggle="tooltip" data-placement="right" title="Esconder"></span>
                </button>
                <div class="sidebar-header">
                    <p class="vertical-text p-2">{{ ucfirst(Session::get('tipo_perfil')) }}</p>
                </div>
                <ul class="list-unstyled components">
                	<li><a href="{{ route('main') }}" data-toggle="tooltip" data-placement="right" title="Inicio"><i class="fa fa-home"></i> <span>Inicio</span></a></li>
	
					<!-- roles -->
					@if (Session::get('menupri'))
						@foreach(Session::get('menupri') as $menu)
							<li>
								@if($menu->nombre)
									<span class="titulo">{{ $menu->nombre }}</span>
									
			<!-- 						{{--<a href="{{asset($rol->ruta.'/'.$rol->id)}}" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{$rol->nombre}}<span class="caret"></span></a>--}} -->
			<!-- 					@else
									<a href="{{ env('APP_URL').$rol->ruta }}" >{{$menu->nombre}}<span class="caret"></span></a> -->
								@endif
							<!-- funciones -->
								@if (Session::get('funciones'))
									<ul class="list-unstyled" id="Submenu-{{ $menu->id }}" >
										@foreach(Session::get('funciones') as $funcion)
											@if($menu->id==$funcion->id_padre)
												<li><a href="{{asset($funcion->ruta)}}" data-toggle="tooltip" data-placement="right" title="{{$funcion->nombre}}"><i id="{{$funcion->nombre}}" class="{{$funcion->clase}}"></i> <span>{{$funcion->nombre}}</span></a></li>
											@endif
										@endforeach
									</ul>
								@endif
							</li>
						@endforeach
					@endif
				</ul>
                <br>
                <!--<div class="alertar">
                    <div id="alertar-full" class="m-4 ">
                        <a href="{{ route('alertas.crear') }}" class="btn btn-block btn-outline-primary btn-sm" data-toggle="tooltip" data-placement="right" title="Crear nueva Alerta Manual" id="Crear alerta">+ Crear alerta</a>    
                    </div>
                    <div id="alertar-icon" class="m-1">
                        <a id="alerta-icon" href="{{ route('alertas.crear') }}" class="btn btn-outline-primary" data-toggle="tooltip" data-placement="right" title="Crear nueva Alerta Manual" id="Crear alerta"><i class="fa fa-plus-circle"></i></a>    
                    </div>
                </div>-->
            </div>
        </nav>





