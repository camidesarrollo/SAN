<div class="card p-4">        
  <div class="row">
    <div class="col">
      <div class="card shadow-sm mb-1">
        <!-- inicia Andres F -->
        <div class="card-header">
          <h5><span class="fa fa-check mr-2"></span> Últimos beneficios recibidos</h5>
        </div>
		
		
		
        <!-- Fin Andres F -->
        <div class="card-body">
		
          @if (count($arrayUB) == 0)
              <h6>Sin Grupo Familiar Asociado en Servicio RSH.</h6>
          @elseif (count($arrayUB) > 0)
            @foreach ($arrayUB as $value)
              @if ($value["EstadoConsulta"] == 0)
                <h6>El Servicio no está disponible disculpe las molestias.</h6>
                @php break; @endphp
              @else
                @php 
                  $dv = Rut::set($value["run"])->calculateVerificationNumber(); 
                  $rut = $value["run"].$dv;
                  $rut = Rut::parse($rut)->format();      
                  $rut = Helper::devuelveRutX($rut);         
                @endphp

                <h6><b>RUN: {{$rut}} - {{$value["Parentesco"]}} </b></h6>
                
                @if($value["estado"] == 1)  
                    @foreach($value["beneficios"] as $b)
                      @php 
                        $fecha = $b["fecharecepcionultben"];
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

            @if ($rshEstado==202)
              <h6>RUN no se encuentra en el Registro Social de Hogares.</h6>
            @endif

            @if (($rshEstado==401) || ($rshEstado==400) || ($rshEstado==500) || ($rshEstado == ""))
              <h6>El servicio configurado para la institución no se encuentra activo.</h6>
            @endif
          @endif
        </div>     
      </div>

      <div class="row" >
        <div class="col-md-4">
          <p style="font-size:9px;">
            <b>Fuente: RSH</b>
          </p> 
        </div>
        
        <div class="col-md-8 text-right" >
          <p style="font-size:9px;">
            <b>Fecha de Actualización: {{ $fecha_act_rsh }}.</b>
          </p>
        </div>
      </div>
    </div>

   <div class="col">
      <div class="card shadow-sm mb-1">
        <div class="card-header">
          <h5><span class="fa fa-check mr-2"></span> Beneficios históricos </h5>
        </div>
        <div class="card-body">
          @if (count($arrayHB) == 0)
              <h6>Sin Grupo Familiar Asociado en Servicio RSH.</h6>
          
          @elseif (count($arrayHB) > 0)

                    @foreach ($arrayHB as $clave => $value)
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

                <h6><b>RUT: {{$rut}} - {{$value["Parentesco"]}} </b></h6>

                @if($value["estado"]==1)  

                    @foreach($value["beneficios"] as $clave => $b)
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

          @if($rshEstado==202)
              <h6>RUN no se encuentra en el Registro Social de Hogares.</h6>
          @endif

          @if(($rshEstado==401) || ($rshEstado==400) || ($rshEstado==500) || ($rshEstado == ""))
              <h6>El servicio configurado para la institución no se encuentra activo.</h6>
          @endif
        @endif
        </div>
                        
    </div>

         <div class="row" >
            <div class="col-md-4">
              <p style="font-size:9px;">
                <b>Fuente: RSH</b>
              </p> 
            </div>
            <div class="col-md-8 text-right" >
              <p style="font-size:9px;">
                <b>Fecha de Actualización: {{ $fecha_act_rsh }}.</b>
              </p>
            </div>
        </div>
        </div>
    </div>
</div>
        <!-- INICIO CZ SPRINT 56 BENEFICIOS SENAME -->
<div class="card p-4">
    <div class="row">
        <div class="col">
            <div class="card shadow-sm mb-1">
                <div class="card-header">
                    <h5><span class="fa fa-check mr-2"></span> Programas SENAME </h5>
                </div>
                <div class="card-body">
                    @if (count($arrayUS) == 0)
                    <h6>Sin Grupo Familiar Asociado en Servicio RSH.</h6>

                    @elseif (count($arrayUS) > 0)

                    @foreach ($arrayUS as $clave => $value)

                        @if($value["EDAD"]<=18 )
                        <!-- INICIO CZ SPRINT 62 -->
                        @if($value["EstadoConsulta"]==0) <h6>&nbsp;&nbsp;&nbsp;&nbsp;El Servicio no
                        está disponible disculpe las molestias. /MENSAJE SERVICIO: {{$beneficioSename_Mensaje}} /ERROR SERVICIO: {{$beneficioSename_Error}}</h6>
                        <!-- FIN CZ SPRINT 62 -->
                                @php break; @endphp

                            @else

                                @php

                                $dv = Rut::set($value["run"])->calculateVerificationNumber();

                                $rut = $value["run"].$dv;

                                $rut = Rut::parse($rut)->format();

                                $rut = Helper::devuelveRutX($rut);

                                @endphp
                                    
                                <h6><b>RUT: {{$rut}} - {{$value["Parentesco"]}} </b></h6>

                                @if($value["Nro_registros"]!=0)

                        @for($i = 0; $i < $value["Nro_registros"]; $i++) @php
                            $fecha=$value["beneficiosSename"][$i]["FECHA_INGRESO"]; $newDate=date("d-m-Y",
                            strtotime($fecha)); $fechaEgreso=$value["beneficiosSename"][$i]["FECHA_EGRESO"];
                            $newDatefechaEgreso=date("d-m-Y", strtotime($fechaEgreso)); @endphp <h6>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <span class="fa fa-check mr-2" style="color:#1cc88a;"></span>
                                            <b>Fecha ingreso: </b>{{$newDate}} -  <b>Fecha egreso: </b>{{$newDatefechaEgreso}}
                                        </h6>
                                        <h6>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <span class="fa fa-check mr-2" style="color:#1cc88a;"></span>
                                            <b> Tipo de proyecto: </b>{{$value["beneficiosSename"][$i]["TIPO_PROYECTO"]}}
                                        </h6>
                                        <h6>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <span class="fa fa-check mr-2" style="color:#1cc88a;"></span>
                                            <b>Modelo: </b>{{$value["beneficiosSename"][$i]["MODELO"]}} 
                                        </h6>
                                        <h6>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <span class="fa fa-check mr-2" style="color:#1cc88a;"></span>
                                            <b>Nombre de proyecto: </b>{{$value["beneficiosSename"][$i]["NOMBREPROYECTO"]}}  
                                        </h6>
                                    @endfor

                                @else

                            <h6>&nbsp;&nbsp;&nbsp;&nbsp;La persona consultada no tiene beneficios sename registrados.
                            </h6>

                            @endif
                        @endif
                    @endif

                    @endforeach

                    @endif
                </div>

</div>

            <div class="row">
                <div class="col-md-4">
                    <p style="font-size:9px;">
                        <b>Fuente: RSH</b>
                    </p>
                </div>
                <div class="col-md-8 text-right">
                    <p style="font-size:9px;">
                        <b>Fecha de Actualización: {{ $fecha_act_rsh }}.</b>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
  <!-- FIN CZ SPRINT 56 BENEFICIOS SENAME -->
