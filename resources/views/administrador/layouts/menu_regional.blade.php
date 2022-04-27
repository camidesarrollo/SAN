        <!--navegacion-->
      <nav class="navbar navbar-default" role="navigation">
          <div class="container-fluid">
              
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="/main">Inicio</a></li>
                    <li class="dropdown ">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Registro<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">

                          <li><a href="{{asset('/institucion/crearfolio/')}}">Crear Folio Institución</a></li>
                          <li><a href="{{asset('/institucion/buscar/')}}">Buscar Folio</a></li>

                        </ul>
                    </li>     

                    
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



