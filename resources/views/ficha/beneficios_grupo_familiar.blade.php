<!-- 				<div class="card p-4">		 -->		
					<div class="row">
            <div class="col-md-12 col-lg-6">
              <div class="card shadow-sm">
                <div class="card-header" style="background: white;">
                  <h5>Historial de beneficios</h5>
                </div>
                                  <div class="card-body">
                    <!--   <ol class="list-group" id="ultimos_beneficios_sociales" data-ultimos-beneficios-href="{{  route('ultimosbeneficios') }}">
                    </ol> -->
                  @foreach ($arrayHB as $value)

                    @if($value["EstadoConsulta"]==0)

                      <h6>&nbsp;&nbsp;&nbsp;&nbsp;El Servicio no está disponible disculpe las molestias.</h6>

                      @php break; @endphp

                    @else

                        @php 
                        
                        $dv = Rut::set($value["run"])->calculateVerificationNumber(); 

                        $rut = $value["run"].$dv;

                        $rut = Rut::parse($rut)->format();   

                        $rut = Helper::devuelveRutX($rut);                     

                        @endphp

                        <h6><b>RUT: {{$rut}} - {{$value["grupoFam"]}}</b></h6>

                        @if($value["estado"]==1)  

                          @foreach($value["beneficios"] as $b)

                            @php $fecha = $b["fecha_recepcion"]; 

                            $newDate = date("d-m-Y", strtotime($fecha));

                            @endphp

                            <h6>&nbsp;&nbsp;&nbsp;&nbsp;
                              <span class="fa fa-check mr-2" style="color:#1cc88a;"></span>
                               {{$b["nombre_programa"]}}. - <b>Fecha: </b>{{$newDate}}
                            </h6>
                          @endforeach  
                               
                        @else

                        <h6>&nbsp;&nbsp;&nbsp;&nbsp;La persona consultada no tiene beneficios registrados.</h6>

                        @endif

                    @endif

                  @endforeach    

                </div>
                                
            </div>
                <!-- <h5><span class="fa fa-puzzle-piece mr-2"></span> Beneficios a los que puede acceder</h5>
                <div class="card p-4 mb-4">
                <ol class="list-group">
                <li class="list-group-item">No presenta datos para esta dimensión</li>
                </ol>
                </div> -->
            </div>

           <div class="col-md-12 col-lg-6">
              <div class="card shadow-sm">
                <div class="card-header" style="background: white;">
                  <h5>Beneficios en uso</h5>
                </div>
                  <div class="card-body">
                    <!--   <ol class="list-group" id="ultimos_beneficios_sociales" data-ultimos-beneficios-href="{{  route('ultimosbeneficios') }}">
                    </ol> -->

                    @foreach ($arrayUB as $value)
                      
                     @php @endphp

                         @if($value["EstadoConsulta"]==0)

                          <h6>&nbsp;&nbsp;&nbsp;&nbsp;El Servicio no está disponible disculpe las molestias.</h6>

                          @php break; @endphp

                        @else

                            @php 
                            
                            $dv = Rut::set($value["run"])->calculateVerificationNumber(); 

                            $rut = $value["run"].$dv;

                            $rut = Rut::parse($rut)->format();

                            $rut = Helper::devuelveRutX($rut);        

                            @endphp

                            <h6><b>RUT: {{$rut}} - {{$value["grupoFam"]}} </b></h6>
                        
                          @if($value["estado"]==1)  

                            @foreach($value["beneficios"] as $b)

                              @php $fecha = $b["fecharecepcionultben"];

                              $newDate = date("d-m-Y", strtotime($fecha));

                              @endphp

                            <h6>&nbsp;&nbsp;&nbsp;&nbsp;
                              <span class="fa fa-check mr-2" style="color:#1cc88a;"></span>
                               {{$b["nombre_programa"]}}. - <b>Fecha: </b>{{$newDate}} 
                            </h6>
                            @endforeach
                               
                          @else

                          <h6>&nbsp;&nbsp;&nbsp;&nbsp;La persona consultada no tiene beneficios registrados.</h6>

                          @endif

                        @endif
                  
                     @endforeach

                </div>
                                
            </div>

        </div>
      
<!--   		</div> -->
