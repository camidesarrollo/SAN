<header>
    <nav class="navbar navbar-expand topbar ">
          <!-- Topbar Search -->
          <div id="logo" class="m-3" >
            <a href="{{ env('APP_URL') }}"><img src="/img/logo-main-simple.png"></a>
          </div>
          <input type="hidden" value="{{route('coordinador.caso.ficha')}}" id="ruta_ficha">
		  <input type="hidden" value="{{route('coordinador.caso.resumenNNA')}}" id="ruta_resumenNNA">
          <div class="input-group" id="buscar-header">
              <input type="text" class="form-control" placeholder="Buscar un NNA" aria-label="Buscar un NNA" aria-describedby="basic-addon2" id="nna_busqueda" name="nna_busqueda">
                <div class="input-group-append">
                  <button class="btn btn-outline-light btn-sm" type="button" id="btn_busqueda" name="btn_busqueda"><span class="fa fa-search"></span> </button>
                </div>
          </div>


          <!-- Topbar Navbar -->     
          <ul class="navbar-nav ml-auto">
            <!-- <li class="nav-item m-1">
              <a class="nav-link text-light" href="#" id="link-consultas"> <small>Consultas</small></a>
            </li> -->
            <li class="nav-item m-1">
				<a class="nav-link text-light" href="{{route('documentos.gestor.casos')}}" id="link-consultas"> <small>Documentos</small></a>            
            </li>
			<!-- //CZ SPRINT 74 -->
			@if(Session::get('perfil') == config('constantes.perfil_gestor') || Session::get('perfil') == config('constantes.perfil_terapeuta'))
			<li class="nav-item dropdown m-1">
		
			<a class="nav-link dropdown-toggle text-light" id="bell" role="button"  data-toggle="modal" data-target="#ModalNotificaciones" onclick="datosTablaCaso();"> 
				<i class="far fa-bell"></i> <h6 class="text-light" style=" text-align: center;font-size: 11px;"><span id="circle">{{ Session::get('cantidad')}}</span></h6>   </a> 

			  <!-- Dropdown - User Information -->
			  	<!-- <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="bell">
					<div class="notifications cont-not-msg" id="box contenedor-notificaciones">
					</div>
				</div>					 -->
	            
            	</li>	
			@endif
			<!-- //CZ SPRINT 74 -->
            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - Alerts -->
            <!-- Nav Item - User Information -->
			<!-- <div class="notifications" id="box">
				<h2>Notifications - <span>2</span></h2>
				<div class="notifications-item"> <img src="https://i.imgur.com/uIgDDDd.jpg" alt="img">
					<div class="text">
						<h4>Samso aliao</h4>
						<p>Samso Nagaro Like your home work</p>
					</div>
				</div>
				<div class="notifications-item"> <img src="https://img.icons8.com/flat_round/64/000000/vote-badge.png" alt="img">
					<div class="text">
						<h4>John Silvester</h4>
						<p>+20 vista badge earned</p>
					</div>
				</div>
			</div> -->
            <li class="nav-item dropdown m-1">
                <a class="nav-link dropdown-toggle text-light" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <small> {{ Session::get('nombre_usuario') }}</small>
                </a>
                <!-- Dropdown - User Information -->
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                  <div class="dropdown-item" href="#">
                    <i class="fa fa-user fa-sm mr-2 text-gray"></i> {{ ucfirst(Session::get('tipo_perfil')) }}
                  </div>
                  <div class="dropdown-item" href="#">
                    <i class="fa fa-map-marker fa-sm mr-2 text-gray"></i>
                    		<!-- {{-- @foreach(Session::get('comunas') as $comunas)
								{{$comunas->com_nom}}<br>
							@endforeach --}} -->
							{{ Session::get('comuna') }}<br>
                  </div>
                  @if (count(Session::get('comunas')) > 1)
                  <div class="dropdown-item">
                <!--   	<i class="fa fa-cog fa-sm mr-2 text-gray"></i>
                  	<i class="oi oi-loop-circular text-gray"></i> -->
                  	 	<i class="oi oi-loop-square text-gray"></i>
                  	<a href="{{route('configuracion.comuna.modificar')}}" style="text-decoration: none; color: #001c41;">
                  		 &nbsp;Cambiar Comuna
                  	</a>
                  </div>
                  @endif
                  <!--<div class="dropdown-item" href="#">
                    <i class="fa fa-globe fa-sm mr-1 text-gray"></i> {{ ucwords(mb_strtolower(Session::get('region'))) }}
                  </div>-->
                  <div class="dropdown-divider"></div> 
                  <a class="dropdown-item" href="{{route('logout')}}" onclick="logout();">
                    <i class="fa fa-times fa-sm fa-fw mr-1 text-gray"></i> Salir
                  </a>
                </div>
            </li>

          </ul>

        </nav>

</header>
<!-- //CZ SPRINT 74 -->
<style>

.notifications h2 {
    font-size: 14px;
    padding: 10px;
    border-bottom: 1px solid #eee;
    color: #999
}

.notifications h2 span {
    color: #f00
}

.notifications-item {
    display: flex;
    border-bottom: 1px solid #eee;
    padding: 6px 9px;
    margin-bottom: 0px;
    cursor: pointer
}

.notifications-item:hover {
    background-color: #eee
}

.notifications-item img {
    display: block;
    width: 50px;
    height: 50px;
    margin-right: 9px;
    border-radius: 50%;
    margin-top: 2px
}

.notifications-item .text h4 {
    color: #777;
    font-size: 16px;
    margin-top: 3px
}

.notifications-item .text p {
    color: #aaa;
    font-size: 12px
}
#circle {
	position: absolute;
    top: 20px;
    left: 18px;
	width: 0.90rem;
    height: 0.90rem;
    border-radius: 100%;
    background: #f07379;
}
</style>
<!-- //CZ SPRINT 74 -->
<!-- <header>
	<div class="container">
		<div class="row align-items-center">
			<div class="col-2">
				<a href="{{ env('APP_URL') }}"><img src="/img/logo-main.png" height="80" class="img-fluid"></a>
			</div>

			<div class="col col-md-10 text-right">
				<div class="dropdown">

					<!-- NOTIFICACION
					<div class="btn-group">
						<button type="button" class="btn btn-info dropdown-toggle no-cerrar" data-toggle="dropdown" onclick="cargarNotificaciones(2);">Notificaciones <span class="badge badge-danger" id="cant-not-msg">0</span></button>
						<div class="dropdown-menu cont-not-msg" id="contenedor-notificaciones">
							<div class="border carg-not" id="cargar-notificaciones"></div>
						</div>
					</div>
					<!-- NOTIFICACION

					<!-- LOGIN 
					<div class="btn-group">
						<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ Session::get('nombre_usuario') }}
						</button>
						<div class="dropdown-menu dropdown-menu-right">
							<button class="dropdown-item" type="button" onclick="window.location.href='{{ route('logout') }}'"><span class="oi oi-x"></span> Salir</button>
						</div>
					</div>
					<!-- LOGIN

				</div>
			</div>
		</div>
	</div>
</header> -->
<style>
	.cont-not-msg{
		height: 145px;
		width: 361px;
		overflow: scroll;
		padding: 0;
		/* background-color: #17a2b8; */
	}

	.tit-not-msg{
		text-align: center;
		border: 1px solid #fffffff5;
		font-weight: 600;
	}

	.body-not-msg{
		padding: 4px;
	}

	.span-body-not-msg{
		font-weight: 800;
		font-style: italic;
		font-size: 13px;
	}

	.small-body-not-msg{
		font-style: italic;
	}

	.msg-default-not{
		height: 145px;
		width: 100%;
		font-weight: 800;
		display: flex;
		justify-content: center;
		align-items: center;
	}

	.carg-not{
		background-color: #5bcee0;
	}
</style> 
<script type="text/javascript">
//CZ SPRINT 74 -->

function irCaso(url){
	// console.log(urls);
	window.location.href = url;
}
//CZ SPRINT 74 -->
 function cargarNotificaciones(option){
	 mensajeNotificacionDefecto(1);

 	let data = new Object();
 	let html = "";
 	data.option = option;

	 $.ajax({
		 url: "{{ route('buscar.notificaciones') }}",
		 type: "GET",
		 data: data
	 }).done(function(resp){
		 if (resp.estado == 1){
		 	switch (option) {
				case 1: //CONTAR CANTIDAD DE NOTIFICACIONES
                    $("#cant-not-msg").text(resp.respuesta[0].cantidad);

				break;

				case 2: //OBTENER NOTIFICACIONES

					let cant_not = resp.respuesta.length;
					$("#cant-not-msg").text(cant_not);

					if (cant_not == 0){
						mensajeNotificacionDefecto(2);

					}else if (cant_not > 0){
						$.each( resp.respuesta, function( key, value ){
							let run = resp.respuesta[key].per_run+'-'+resp.respuesta[key].per_dig;
							let msg = resp.respuesta[key].not_des;
							let fecha = resp.respuesta[key].not_fec;
							let modulo = resp.respuesta[key].not_mod;
							let id = resp.respuesta[key].not_id;
							run = formatearRun(run);

							html += '<a class="dropdown-item tit-not-msg" data-toggle="collapse" data-target="#not-msg-'+key+'" data-id-not="'+id+'" onclick="validarNotificación(this);"><span class="oi oi-bell"></span> Notificación: '+run+'</a>';
							html += '<div id="not-msg-'+key+'" class="collapse body-not-msg">';
							html += '<span class="span-body-not-msg">'+msg+'</span><div class="row"><br>';
							html += '<div class="col-7 text-left"><small class="text-muted small-body-not-msg" >Fecha: '+fecha+'</small></div>';
							html += '<div class="col-5 text-right"><small class="text-muted small-body-not-msg" >Modulo: '+modulo+'</small></div>';
							html += '</div></div>';
						});

						$("#cargar-notificaciones").html(html);
					}
				break;
			}
		 }else if (resp.estado == 0){
			 switch (option) {
				 case 1: //CONTAR CANTIDAD DE NOTIFICACIONES
					 $("#cant-not-msg").text("Error");
				 break;

				 case 2: //OBTENER NOTIFICACIONES
					 mensajeNotificacionDefecto(3);
				 break;
			 }
		 }
	 }).fail(function(obj){
		 console.log(obj);

		 switch (option) {
			 case 1: //CONTAR CANTIDAD DE NOTIFICACIONES
				 $("#cant-not-msg").text("Error");
			 break;

			 case 2: //OBTENER NOTIFICACIONES
				 mensajeNotificacionDefecto(3);
			 break;
		 }
	 });
 }
//CZ SPRINT 74 -->
 function cantidadNotificaciones(){
	var cantidadNotificacion = 0;

	var html ="";
	$.ajax({
		url: "{{ route('data.cantidadNotificaciones') }}",
		type: "GET",
	}).done(function(resp){
		console.log(resp)
		console.log("obteniendo cantidad de notificaciones");
		cantidadNotificacion = resp;
		if(cantidadNotificacion != $("#circle").text()){
			$("#circle").html(resp);
		}
	
	}).fail(function(obj){
		cantidadNotificaciones();
	});

 }
//CZ SPRINT 74 -->
 function validarNotificación(_this){
 	let expanded = $(_this).attr("aria-expanded");
 	let id = $(_this).attr("data-id-not");

 	if (expanded == "false" || expanded == undefined){
 		// console.log("mostramos");

	}else if (expanded == "true"){
 		$(_this).fadeOut('slow');

		eliminarNotificaciones(id);
	}
 }

 function eliminarNotificaciones(id){
 	let data = new Object();
 	data.option = 3;
 	data.not_id = id;

	 $.ajax({
		 url: "{{ route('buscar.notificaciones') }}",
		 type: "GET",
		 data: data
	 }).done(function(resp){
		 if (resp.estado == 0) console.log("Error al momento de actualizar estado de notificación. Por favor intente nuevamente.");
		 cargarNotificaciones(1);
		 cargarNotificaciones(2);
	 }).fail(function(obj){
		 console.log("Hubo un error al momento de actualizar estado de notificación. Por favor intente nuevamente.");
	 });
 }

 function mensajeNotificacionDefecto(opcion){
	let html = '<div class="msg-default-not">';
	html     += '<span>';

 	switch (opcion) {
		case 1: //Cargando Notificaciones
		   html += 'Cargando Notificaciones ....';
		break;

		case 2: //No hay notificaciones
			html += 'No existen notificaciones a mostrar.';
		break;

		case 3: //Error
			html += 'Hubo un error al momento de cargar las notificaciones. Por favor intente nuevamente.';
		break;
	}

    html += '</span>';
    html += '</div>';

	 $("#cargar-notificaciones").html(html);
 }


</script>
