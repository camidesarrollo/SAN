        <!--navegacion-->
      <nav class="navbar navbar-default" role="navigation">
          <div class="container-fluid">
              
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="/main">Inicio</a></li>
                    <li class="dropdown ">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Registro<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="{{asset('/adm/institucion/')}}">Precalificar Instituciones</a></li>
                          <li><a href="{{asset('/adm/institucion/mantenedor/estados')}}">Mantenedor de Estados de Folios</a></li>
                          <li class="divider"></li>
                          <li><a href="{{asset('/proyecto/mentenedor/estados')}}">Mantenedor estado de Proyectos</a></li>
                          <li><a href="{{asset('/proyecto/mentenedor/evaluar')}}">Evaluar Proyectos</a></li>
                          <li><a href="">Alerta de Proyectos Pendiente</a></li>
                          <li><a href="{{asset('/proyecto/rendirproyecto/tecnica')}}">Revisión de Informes</a></li>                          
                        </ul>
                    </li>     
                    <li class="dropdown ">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Consejo<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="{{asset('/consejo/cargar_sesion/')}}">Cargar Sesión de Consejo</a></li>
                          <li><a href="{{asset('/consejo/gestion_sesion/')}}">Gestión de Sesiones de Consejo</a></li>
                          <li class="divider"></li>
                          <li><a href="{{asset('/consejo/adjuntos')}}">Gestión de Documento del Consejo</a></li>
                        </ul>
                    </li>                                    

                    
                    <li class="dropdown ">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Reportes<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="{{asset('/reportes/institucion/')}}">Reportes de Institucion</a></li>
                          <li><a href="{{asset('/reportes/proyecto/')}}">Reportes de Proyectos</a></li>
                          <li><a href="{{asset('/reportes/consejo/')}}">Reportes Sesiones de Consejo</a></li>
                          <li><a href="{{asset('/reportes/ingresos/')}}">Reportes Otros Ingresos Pendiente</a></li>
                        </ul>
                    </li>               

                    <li>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Elección Consejo<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="{{asset('/eleccion/index_votar/')}}">Votar</a></li>
                        </ul> 
                    

                    </ul>
                
                <ul class="nav navbar-nav navbar-right">
                  <li class="dropdown">
                      <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                          <i class="fa fa-user fa-fw"></i> {{Auth::user()->nombre}}
                          <i class="fa fa-caret-down"></i>
                      </a>
                      <ul class="dropdown-menu dropdown-user">
                          
                          <li>
                            <a href="#"><span class="glyphicon glyphicon-credit-card"></span> {{Session::get('nombre_perfil')}}</a>
                            <a href="#"  onclick="generarPass({{Session::get('id_usuario')}}); "><span class="fa fa-lock"></span> Generar Nueva Contraseña</a>
                            <a href="{{asset('/logout')}}"><i class="fa fa-sign-out fa-fw"></i>Salir</a>
                          </li>
                      </ul>
                  </li>
                </ul>                
            </div>
            
       </div> 
      </nav>

