      <!--navegacion-->
      <nav class="navbar navbar-default" role="navigation">
          <div class="container-fluid">
              
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="/main">Inicio</a></li>
                    <!-- roles -->
                    @if (Session::get('roles'))                              
                        @foreach(Session::get('roles') as $rol) 
                        <li class="dropdown ">
                            @if($rol->funciones>0)
                            <a href="{{asset($rol->ruta.'/'.$rol->id)}}" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{$rol->nombre}}<span class="caret"></span></a>
                            @else
                            <a href="{{asset($rol->ruta.'/'.$rol->id)}}" >{{$rol->nombre}}<span class="caret"></span></a>
                            @endif 
                            <!-- funciones -->
                            @if($rol->funciones>0)
                                @if (Session::get('funciones'))    
                                    <ul class="dropdown-menu" role="menu">                                                      
                                    @foreach(Session::get('funciones') as $funcion)
                                        @if($rol->id==$funcion->id_rol)
                                            <li><a href="{{asset($funcion->ruta_funcion)}}">{{$funcion->nombre_funcion}}</a></li>
                                        @endif
                                    @endforeach 
                                    </ul>
                                @endif
                            @endif   
                        </li> 
                        @endforeach                               
                    @endif                      
                </ul>                
                <ul class="nav navbar-nav navbar-right">
                  <li class="dropdown">
                      <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                          <i class="fa fa-user fa-fw"></i>  {{Session::get('nombre_usuario')}}
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

