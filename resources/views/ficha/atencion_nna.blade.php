@extends('layouts.main')
@section('contenido')
        <!-- HIDDEN -->
        <input type="hidden" name="url_guardar_obs_prediagnostico" id="url_guardar_obs_prediagnostico" value="{{ route('casos.guardar_obs_prediagnostico')  }}">
        <input type="hidden" name="url_guardar_fecha_prediagnostico" id="url_guardar_fecha_prediagnostico" value="{{ route('casos.guardar_fecha_prediagnostico')  }}">
        <input type="hidden" name="url_finalizar_caso" id="url_finalizar_caso" value="{{ route('casos.cambio.estado')  }}">
        <!-- //CZ SPRINT 74 -->
        <input type="hidden" name="url_tabla_notificacion_Intervencion" id="url_tabla_notificacion_Intervencion" value="{{ route('data.notificacionTiempoIntervencionTabla')  }}">
        <input type="hidden" name="url_cantidad_notificacion" id="url_cantidad_notificacion" value="{{ route('data.cantidadNotificaciones')  }}">
        <input type="hidden" name="url_cantidadNotificacionesTiempo" id="url_cantidadNotificacionesTiempo" value="{{ route('data.cantidadNotificacionesTiempo')  }}">
        <input type="hidden" name="url_dataTables_spanish" id="url_dataTables_spanish" value="{{ route('index') }}/js/dataTables.spanish.json">
        <input type="hidden" name="url_caso" id="url_caso" value="{{ route('coordinador.caso.ficha') }}">
        <!-- //CZ SPRINT 74 -->

        <input type="hidden" name="cas_id" id="cas_id" value="{{ $caso->cas_id }}">
        <input type="hidden" name="perfil" id="perfil" value="{{session()->all()['perfil']}}">
        <input type="hidden" name="run_nna" id="run_nna" value="{{ $run }}">
        <input type="hidden" name="est_act_cas" id="est_act_cas" value="{{ $estado_actual_caso }}">
        <input type="hidden" name="est_prediag_cons" id="est_prediag_cons" value="{{ config('constantes.en_prediagnostico')  }}">
        <input type="hidden" name="est_diag_cons" id="est_diag_cons" value="{{ config('constantes.en_diagnostico')  }}">
        <input type="hidden" name="est_elab_cons" id="est_elab_cons" value="{{ config('constantes.en_elaboracion_paf')  }}">
        <input type="hidden" name="est_ejec_cons" id="est_ejec_cons" value="{{ config('constantes.en_ejecucion_paf')  }}">
        <input type="hidden" name="est_cier_cons" id="est_cier_cons" value="{{ config('constantes.en_cierre_paf')  }}">
        <input type="hidden" name="est_segu_cons" id="est_segu_cons" value="{{ config('constantes.en_seguimiento_paf')  }}">
        <input type="hidden" name="est_segu_cons" id="est_egre_cons" value="{{ config('constantes.egreso_paf')  }}">
        <input type="hidden" name="est_segu_cons" id="est_rech_fami_cons" value="{{ config('constantes.rechazado_por_familiares')  }}">
        <input type="hidden" name="est_segu_cons" id="est_rech_gest_cons" value="{{ config('constantes.rechazado_por_gestor')  }}">
        <!-- HIDDEN -->
        <!-- VALOR MOSTRAR OCULTAR VISITAS -->
        <!--@ if(($visitas[1]->visita==null)&&($visitas[2]->visita==null))
        <input type="hidden" name="cont_vis" id="cont_vis" value="2">
        @ else
        <input type="hidden" name="cont_vis" id="cont_vis" value="3">
        @ endif-->
<main id="content">
<section>
    @if(Session::has('success'))
        <div class="container-fluid">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ Session::get('success') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif
    @if(Session::has('danger'))
        <div class="container-fluid">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{ Session::get('danger') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif
    @if ($errors->any())
        <div class="container-fluid">
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
<div class="container-fluid">
    <div id="atencion-nna">

        <div id="datos-nna" class="sticky-top">
            <div class="m-3">
                <h5 class="">
                  <img class="mr-3" src="/img/ico-nna.png">  
                    <!--INICIO CZ SPRINT  57 -->
                  Caso: {{$caso->cas_id}} -  {{ $caso->nombre }}
                  <!-- FIN CZ SPRINT 57 -->
                  <small><i class="fa fa-id-card ml-3 mr-2"></i> <?php print_r(Helper::devuelveRutX(number_format($caso->run,0,",",".")."-".($caso->dig))); ?> </small>
                  <small><i class="fa fa-birthday-cake ml-3 mr-2"></i>  {{ $caso->edad_ani }} Años</small>

                  <small>
                   
                  @if($caso->est_pau==1)
                  <!-- INICIO CZ SPRINT 60 -->
                    @if($est_cas_fin)
                    <!-- <button  class="btn  btn-outline-danger  btn-sm pl-2" disabled data-toggle="modal" type="button" @if((Session::get('perfil')==config('constantes.perfil_gestor')))  data-target="#crearPausaModal" @endif>
                      <i class="fas fa-pause ml-2 mr-2" aria-hidden="true"></i> -->
                    @else 
                      <!-- <button  class="btn  btn-outline-danger  btn-sm pl-2" data-toggle="modal" type="button" @if((Session::get('perfil')==config('constantes.perfil_gestor')))  data-target="#crearPausaModal" @endif>
                      <i class="fas fa-pause ml-2 mr-2" aria-hidden="true"></i> -->
                    @endif
                  <!-- FIN CZ SPRINT 60 -->
                  @else
                  <!-- INICIO CZ SPRINT 60 -->
                    @if($est_cas_fin)
                    <!-- <button  class="btn  btn-outline-success  btn-sm pl-2" disabled data-toggle="modal" type="button"  @if((Session::get('perfil')==config('constantes.perfil_gestor')))  data-target="#crearPausaModal" @endif   >
                      <i class="fa fa-play ml-2 mr-2" aria-hidden="true"></i> -->
                    @else
                      <!-- <button  class="btn  btn-outline-success  btn-sm pl-2" data-toggle="modal" type="button"  @if((Session::get('perfil')==config('constantes.perfil_gestor')))  data-target="#crearPausaModal" @endif   >
                      <i class="fa fa-play ml-2 mr-2" aria-hidden="true"></i> -->
                    @endif
                    <!-- FIN CZ SPRINT 60 -->
                    @endif

                    <!-- INICIO CZ SPRINT 60 -->
                    @if($caso->est_pau==1)
                    <!-- Fecha: 02/02/2022 Motivo: El proceso actual no permite pausar casos -->
		           		  	<!-- <button  class="btn  btn-outline-danger  btn-sm" data-toggle="modal" type="button" @if((Session::get('perfil')==config('constantes.perfil_gestor')))  data-target="#crearPausaModal" @endif>
		                 	<i class="fas fa-pause ml-2 mr-2" aria-hidden="true"></i> -->
		                @else
		                 	<button  class="btn  btn-outline-success  btn-sm" data-toggle="modal" type="button"  @if((Session::get('perfil')==config('constantes.perfil_gestor')))  data-target="#crearPausaModal" @endif   >
		                 	<i class="fa fa-play ml-2 mr-2" aria-hidden="true"></i>
                    @endif
                    <!-- FIN CZ SPRINT 60 -->

                      </button>
                     </small>
                     @if($caso->est_pau != 1)
                    <small>
                      <button  class="btn btn-outline-success btn-sm" data-toggle="modal" type="button" data-target="#historialPausaModal" onclick="listadoHistorialPausaCaso({{ $caso->cas_id }});">Historial Pausas
                      </button>
                    </small>
                    @endif
                </h5>
            </div>
        </div>

        <!-- MENU MAIN  -->
        <ul class="nav nav-tabs sticky-top" id="menu-ficha-acciones" role="tablist">
            <li class="nav-item">
                   <!-- INICIO CZ SPRINT 63 Casos ingresados a ONL -->
                  @if($caso->cas_id != "")
                      <a class="nav-link" href="{{ route('coordinador.caso.ficha') }}/{{ $run }}/{{$caso->cas_id}}">ANTECEDENTES</a>
                  @else
                      <a class="nav-link" href="{{ route('coordinador.caso.ficha') }}/{{ $run }}/0">ANTECEDENTES</a>
                  @endif
                  <!-- FIN CZ SPRINT 63 Casos ingresados a ONL -->
            </li>

            @if ((Session::get('perfil') == config('constantes.perfil_gestor')) || (Session::get('perfil') == config('constantes.perfil_coordinador_regional')) || (Session::get('perfil') == config('constantes.perfil_coordinador')) || (Session::get('perfil') == config('constantes.perfil_super_usuario')))
                <li class="nav-item">
                  <!-- INICIO CZ SPRINT 63 Casos ingresados a ONL -->
                    @if($caso->cas_id != "")
                    <a class="nav-link active show" href="{{ route('atencion-nna') }}/{{ $run }}/{{$caso->cas_id}}">GESTIÓN DE CASOS</a>
                    @else
                    <a class="nav-link active show" href="{{ route('atencion-nna') }}/{{ $run }}/0">GESTIÓN DE CASOS</a>
                    @endif
                <!-- FIN CZ SPRINT 63 Casos ingresados a ONL -->
                </li>
            @endif

            @if (Session::get('perfil') == config('constantes.perfil_coordinador') || (Session::get('perfil') == config('constantes.perfil_coordinador_regional')))
              @if ($caso_con_terapia)
                <li class="nav-item"> 
                <!-- INICIO CZ SPRINT 63 Casos ingresados a ONL --> 
                  <a class="nav-link" href="{{ route('gestion-terapia-familiar') }}/{{ $run }}/{{$caso->cas_id}}">TERAPIA FAMILIAR</a>
                  <!-- FIN CZ SPRINT 63 Casos ingresados a ONL -->
                </li>
              @endif  
            @endif
            
            <li class="nav-item">
                <!-- INICIO CZ SPRINT 63 Casos ingresados a ONL -->
                  @if($caso->cas_id != "")
                  <a class="nav-link " href="{{ route('historial-nna') }}/{{ $run }}/{{$caso->cas_id}}">HISTORIAL NNA</a>
                  @else
                  <a class="nav-link " href="{{ route('historial-nna') }}/{{ $run }}/0">HISTORIAL NNA</a>
                  @endif
                <!-- FIN CZ SPRINT 63 Casos ingresados a ONL -->
            </li> 
        </ul>

        <input type="hidden" name="run" id="run" value="{{$run}}">
        <!-- FIN MENU MAIN  -->

        <ul class="nav nav-pills mt-0 p-1 sticky-top" id="myTab" role="tablist">
            <!-- <li class="nav-item">
                <a class="nav-link " id="asignarTerapeuta-tab" data-toggle="tab" href="#asignarTerapeuta" role="tab" aria-controls="asignarTerapeuta" aria-selected="true">Asignar Terapeuta <span class="ml-4 p-1 bg-success"><i class="fa fa-check text-light"></i></span></a>
            </li> -->
@if (Session::get('perfil')==2)
          @foreach ($acciones as $accion)
              @if( $accion->cod_accion=="ac1" )
        <div class="container-fluid">
          <div class="row">
            
                  @if ($caso->descartado == 0)  
                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#asignarGestorModal">
                        @if ($gestor_asignado != null)
                          <span class="oi oi-person"></span> Gestor(a): {{ $gestor_asignado }}
                        @else
                          <span class="oi oi-person"></span> {{ $accion->nombre }}
                        @endif
                    </button>
                    <br>
                  @endif

                  @if($terapeuta_asignado)
                  <button  style="margin-left:7px;" type="button" class="btn btn-secondary" data-toggle="modal" data-target="#reAsignarTerapeutaModal">
                    <span class="oi oi-person"></span> Terapeuta: 
                    {{$terapeuta_asignado}}
                  </button>
                  @endif
          </div>
        </div>
        @endif
        @endforeach
@endif
            
          @foreach ($acciones as $accion)
              {{-- @ if( $accion->cod_accion=="ac1" )

                @ if (Session::get('perfil')==2 || Session::get('perfil') == 10)

                  <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#asignarGestorModal">
                      @ if ($gestor_asignado != null)
                        <span class="oi oi-person"></span> {{ $gestor_asignado }}
                      @ else
                        <span class="oi oi-person"></span> {{ $accion->nombre }}
                      @ endif
                  </button>

                  <br>

                  @ if($terapeuta_asignado)
                  <button  style="margin-left:7px;" type="button" class="btn btn-secondary" data-toggle="modal" data-target="#reAsignarTerapeutaModal">
                    <span class="oi oi-person"></span> Terapeuta: 
                    {{ $terapeuta_asignado }}
                  </button>
                  @ endif
              
                    <!--<li class="nav-item">
                        <a class="nav-link" id="asignarGestor-tab" data-toggle="tab" href="#asignarGestor" role="tab" aria-controls="asignarGestor" aria-selected="false">
                            @ if ($gestor_asignado != null)
                                { { $gestor_asignado }} <i class="fa fa-check-circle ml-2 text-success" id="asignarGestor-tab-ico"></i>
                            @ else
                                { { $accion->nombre }} <i class="fa fa-check-circle ml-2 text-light" id="asignarGestor-tab-ico"></i>
                            @ endif
                        </a>
                    </li>-->
                @endif --}}

              @if($accion->cod_accion=="ac0") <!-- Pre Diagnóstico -->

                  <li class="nav-item">
                    <a class="nav-link disable-btn-nav-est" id="prediagnostico-tab" data-toggle="tab" href="#prediagnostico" role="tab" aria-controls="prediagnostico" aria-selected="false">{{ substr($submenu[5]->titulo,3) }}<i class="fa fa-check-circle ml-2 text-light" id="prediagnostico-tab-ico"></i></a>
                  </li>

              @elseif($accion->cod_accion=="ac3") <!-- Diagnóstico -->

                  <!--<a href="{{ route('caso.diagnostico',[ 'ficha' => $caso->cas_id]) }}" class="btn btn-secondary">-->
                  
                  <li class="nav-item">
                    <a class="nav-link disable-btn-nav-est" id="diagnostico-tab" data-toggle="tab" href="#diagnostico" role="tab" aria-controls="diagnostico" aria-selected="false">{{ substr($submenu[0]->titulo,3) }}<i class="fa fa-check-circle ml-2 text-light" id="diagnostico-tab-ico"></i></a>
                  </li>
          
                  <!-- <button class="btn btn-secondary" data-toggle="modal" data-target="#diagnosticoModal">
                    <span class="oi oi-clipboard"></span> -->
                    <!-- {{ $accion->nombre }}-->
                  <!-- </button> -->

                  <!--@if($caso->estado!=1 && $caso->estado!=3 && $caso->estado != config('constantes.estado_descartado', ''))-->

                  <!--@else
                    <button disabled type="button" class="btn btn-secondary" attr1=""  >
                      <span class="oi oi-briefcase"></span>
                      {{ $accion->nombre }}
                    </button>
                  @endif-->

              <!--@ elseif($accion->cod_accion=="ac4")
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#asignarTerapeutaModal">
                  <span class="oi oi-person"></span>
                  {{ $accion->nombre }}
                </button> -->

              @elseif($accion->cod_accion=="ac5")
                @if($caso->estado!=1 && $caso->estado!=3 && $caso->estado != config('constantes.estado_descartado', ''))
                  <a href="{{ route('agendas.mostrar',['caso' => $caso->cas_id]) }}" class="btn btn-secondary">
                    <span class="oi oi-briefcase"></span> {{ $accion->nombre }}  </a>
                @else
                  <button disabled type="button" class="btn btn-secondary"  >
                    <span class="oi oi-briefcase"></span>
                    {{ $accion->nombre }}
                  </button>
                @endif


              @elseif($accion->cod_accion=="ac6")
                <button {{($caso->estado != config('constantes.estado_rechazado', ''))? "":"disabled"}}
                class="btn btn-secondary" type="button" data-toggle="modal" data-target="#rechazarModal">
                  <span class="oi oi-circle-x"></span> {{ $accion->nombre }}
                </button>
              @elseif($accion->cod_accion=="ac7") <!-- Planificar Sesiones Individuales -->
                <a href="{{ route('sesiones.index',['caso' => $caso->cas_id]) }}" class="btn btn-secondary">
                <span class="oi oi-list"></span> {{ $accion->nombre }}</a>
              @elseif($accion->cod_accion=="ac8")
                <button class="btn btn-secondary " type="button"  id="derivarBtn" data-derivar-href="{{ route('derivar.show',['caso' => $caso->cas_id]) }}">
                  <span class="oi oi-external-link"></span> {{ Lang::get('messages.derivar.titulo') }}</a>
                </button>

              @elseif($accion->cod_accion=="ac9") <!-- Ejecución PAF-->
                <li class="nav-item">
                  <a class="nav-link disable-btn-nav-est" id="ejecucionPAF-tab" data-toggle="tab" href="#ejecucionPAF" role="tab" aria-controls="ejecucionPAF" aria-selected="false">{{ substr($submenu[2]->titulo,3) }} <i class="fa fa-check-circle ml-2 text-light" id="ejecucionPAF-tab-ico"></i></a>
                </li>
              @elseif($accion->cod_accion=="ac10") <!-- Cierre PAF -->
              <li class="nav-item">
                <a class="nav-link disable-btn-nav-est" id="cierrePAF-tab" data-toggle="tab" href="#cierrePAF" role="tab" aria-controls="cierrePAF" aria-selected="false">{{ substr($submenu[3]->titulo,3) }} <i class="fa fa-check-circle ml-2 text-light" id="cierrePAF-tab-ico"></i></a>
              </li>
              
              @elseif($accion->cod_accion=="ac11") <!-- Egreso PAF-->

              <li class="nav-item">
                <a class="nav-link disable-btn-nav-est" id="seguimientoPAF-tab" data-toggle="tab" href="#seguimientoPAF" role="tab" aria-controls="seguimientoPAF" aria-selected="false">{{ substr($submenu[4]->titulo,3) }} <i class="fa fa-check-circle ml-2 text-light" id="seguimientoPAF-tab-ico"></i></a>
              </li>

              @elseif ($accion->cod_accion=="ac12") <!-- Elaborar PAF -->
              <li class="nav-item">
                <a class="nav-link disable-btn-nav-est" id="elaborarPAF-tab" data-toggle="tab" href="#elaborarPAF" role="tab" aria-controls="elaborarPAF" aria-selected="false">{{ substr($submenu[1]->titulo,3) }} <i class="fa fa-check-circle ml-2 text-light" id="elaborarPAF-tab-ico"></i></a>
              </li>

              @elseif ($accion->cod_accion=="ac15") <!-- Elaborar PTF -->
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#elaborarPtfModal">
                  <span class="oi oi-briefcase"></span>
                  {{ $accion->nombre }}
                </button>

              @elseif ($accion->cod_accion=="ac16") <!-- Ejecución PTF -->
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#ejecucionPtfModal">
                  <span class="oi oi-caret-right"></span>
                  {{ $accion->nombre }}
                </button>

              @elseif ($accion->cod_accion=="ac17") <!-- Seguimiento PTF -->
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#seguimientoPtfModal">
                  <span class="oi oi-briefcase"></span>
                  {{ $accion->nombre }}
                </button>
              @endif
                  
            @endforeach
            
        </ul>

         <!--@ includeif('ficha.cambio_estado_caso_modal')-->

        <div class="card shadow-sm p-4 ">
            <div class="tab-content" id="myTabContent">
            <!-- INICIO DC -->
            @if($caso->cas_id != "")
				<div id="fechaPlazo"><i style="margin-left:10px" class="far fa-calendar-alt mr-1"></i> Fecha estimada para avanzar de etapa: <span class="txtPlazo"></span></div>
            @endif
            <!-- FIN DC -->
                <!-- ----------------ASIGNAR GESTOR--------------->
                <!--<div class="tab-pane active show fade" id="asignarGestor" role="tabpanel" aria-labelledby="asignarGestor-tab">
                    <div class="card p-2 mb-3">
                        <div class="row">
                            <div id="cont_asignarGestor" class="col-sm-12" ></div>
                        </div>
                    </div>
                </div>-->
                <!-- ----------------ASIGNAR GESTOR--------------->

                <!-- ----------------PREDIAGNOSTICO--------------->
                <div class="tab-pane active show fade" id="prediagnostico" role="tabpanel" aria-labelledby="prediagnostico-tab">
                    <div class="card p-2 mb-3">
                        <div class="row">
                            <div id="cont_prediagnostico" class="col-sm-12" ></div>
                        </div>

                    </div>
                </div>
                <!-- ----------------PREDIAGNOSTICO--------------->

                <!-- ----------------DIAGNOSTICO--------------->
                <div class="tab-pane active show fade" id="diagnostico" role="tabpanel" aria-labelledby="diagnostico-tab">
                    <div class="card p-2 mb-3">
                        <div class="row">
                            <div id="cont_diagnostico" class="col-sm-12" ></div>
                        </div>

                    </div>
                </div>
                <!-- ----------------DIAGNOSTICO--------------->

                <!-- ----------------ELABORAR PAF--------------->
                <div class="tab-pane fade" id="elaborarPAF" role="tabpanel" aria-labelledby="elaborarPAF-tab">
                    <div class="card p-2 mb-3">
                        <div class="row">
                          <div id="cont_elaborarPAF" class="col-sm-12" ></div>
                        </div>
                    </div>
                </div>
                <!-- ----------------ELABORAR PAF--------------->

                <!-- ----------------asignarTerapeuta--------------->
                <!--<div class="tab-pane fade" id="asignarTerapeuta" role="tabpanel" aria-labelledby="asignarTerapeuta-tab">
                    <div class="card p-2 mb-3">
                        <div class="row">
                          
                          @ includeif('ficha.asignar_terapeuta')

                        </div>
                    </div>
                </div> -->
                <!-- ----------------asignarTerapeuta--------------->

                <!-- ----------------EJECUCION PAF--------------->
                <div class="tab-pane fade" id="ejecucionPAF" role="tabpanel" aria-labelledby="ejecucionPAF-tab">
                    <div class="card p-2 mb-3">
                        <div class="row">
                          <div id="cont_ejecutarPAF" class="col-sm-12" ></div>
                        </div>
                    </div>
                </div>
                <!-- ----------------EJECUCION PAF--------------->

                <!-- ----------------CIERRE PAF--------------->
                <div class="tab-pane fade" id="cierrePAF" role="tabpanel" aria-labelledby="cierrePAF-tab">
                    <div class="card p-2 mb-3">
                        <div class="row">
                          <div id="cont_cierrePAF" class="col-sm-12" ></div>
                        </div>
                    </div>
                </div>
                <!-- ----------------CIERRE PAF--------------->

                <!-- ----------------SEGUIMIENTO PAF--------------->
                <div class="tab-pane fade" id="seguimientoPAF" role="tabpanel" aria-labelledby="seguimientoPAF-tab">
                    <div class="card p-2 mb-3">
                        <div class="row">
                            <div id="cont_egresoPAF" class="col-sm-12" >

                            </div>
                        </div>
                    </div>
                </div>
                <!-- ----------------SEGUIMIENTO PAF--------------->

            </div>
        </div>

    </div>
</div>

</section>

</main>
<!-- INCLUDE -->

@includeif('ficha.pausas.historial_pausa_modal')
@includeif('ficha.pausas.crear_pausa_modal')

@includeif('ficha.asignar_gestor_modal')
@includeif('ficha.cambio_estado_caso_modal')
@includeif('ficha.errores_cambio_estado_modal')
@includeif('ficha.reasignar_terapeuta_modal')
<!-- INCLUDE -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
  $( document ).ready(function(){

      let cargar_diagnostico=$("#perfil").val();

      // alert(cargar_diagnostico);

      if((cargar_diagnostico=={{ config('constantes.perfil_gestor')  }})||(cargar_diagnostico=={{ config('constantes.perfil_super_usuario')   }})||(cargar_diagnostico=={{ config('constantes.perfil_coordinador')   }}) || (cargar_diagnostico=={{ config('constantes.perfil_coordinador_regional')  }})) {
        procesoAtencionCaso($("#est_act_cas").val(), $("#cas_id").val(), true);
      }
      
	//INICIO DC
	obtienePlazo();
	//FIN DC
  });

  var contador_intentos = 0;
  //INICIO DC
  function verificaEstadoPlazo(estadoClick){
		let data = new Object();
		data.idCaso = $("#cas_id").val();
    // INICIO CZ SPRINT 58
    if($("#cas_id").val() != ""){
		$.ajax({
            type: "GET",
            url: "{{route('get.estadoNNA')}}",
            data: data
        }).done(function(resp){
           var estadoActual = JSON.parse(resp);
           if(estadoActual[0].est_cas_id == estadoClick){
                $('#fechaPlazo').fadeIn(0);
           }else{
           		$('#fechaPlazo').fadeOut(0);
           }
        }).fail(function(objeto, tipoError, errorHttp){  
           desbloquearPantalla();
           contador_intentos++;
           if(contador_intentos <=3){
            verificaEstadoPlazo();
           }else{
           manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
           }
       
         
     
           return false;
        });
  }
    // FIN CZ SPRINT 58
  }
  
  function obtienePlazo(){
  		$('#fechaPlazo').fadeIn(0);
		let data = new Object();
		data.pro_an_id 	= $("#cas_id").val();
		data.tipo = 1;
    // INICIO CZ SPRINT 58
    if($("#cas_id").val() != ""){
		$.ajax({
            type: "GET",
            url: "{{route('get.plazo')}}",
            data: data
        }).done(function(resp){
            var plazo = JSON.parse(resp);
            $('.txtPlazo').html(plazo.plazo);
        }).fail(function(objeto, tipoError, errorHttp){  
           desbloquearPantalla();
           manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
           return false;
  });
	}
    // FIN CZ SPRINT 58
	}
	//FIN DC

  function procesoAtencionCaso(option = null, valor = null, cargaInicial, recargar = 0){
    //INICIO DC
    verificaEstadoPlazo(option);
    //FIN DC
    if (option == "" || typeof option == "undefined" ||
		valor == "" || typeof valor == "undefined") return false;

    if (recargar == 0 ) bloquearPantalla();  

  	let data = new Object();
    let estado_actual = $("#est_act_cas").val();

    option =  parseInt(option);
    data.option     = option;
    data.caso_id    = valor;
    data.run        = $("#run").val();

    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}});

    $.ajax({
      url: "{{ route('proceso.atencion.caso') }}",
      type: "GET",
      data: data,
      timeout: 12000
    }).done(function(resp){
      console.log(resp);
      desbloquearPantalla();

          switch (option) {
            case {{ config('constantes.en_prediagnostico')  }}: // BOTON PREDIAGNOSTICO
            //alert('ok');
          $( "#cont_prediagnostico" ).html(resp.html);

          if (estado_actual == {{ config('constantes.en_prediagnostico')  }}) $("#btn-etapa-prediagnostico").prop("disabled", false);

          if (cargaInicial == true) {
            $('#prediagnostico-tab').click();
            $("#prediagnostico-tab").focus();
            $("#prediagnostico-tab").addClass("active");

            $("#prediagnostico-tab").removeClass("disable-btn-nav-est");
            $("#prediagnostico-tab-ico").removeClass("text-light");

            $("#prediagnostico-tab-ico").addClass("text-success");
            $("#prediagnostico-tab").attr("onclick", "procesoAtencionCaso({{ config('constantes.en_prediagnostico')  }}, " + valor + ", false);");
          }
            break;


              case {{ config('constantes.en_diagnostico')  }}: // BOTON DIAGNOSTICO
				  $( "#cont_diagnostico" ).html(resp.html);

				  if (estado_actual == {{ config('constantes.en_diagnostico')  }}) $("#btn-etapa-diagnostico").prop("disabled", false);

				  if (cargaInicial == true) {
					  $('#diagnostico-tab').click();
					  $("#diagnostico-tab").focus();
					  $("#diagnostico-tab").addClass("active");

            $("#prediagnostico-tab").removeClass("disable-btn-nav-est");
            $("#prediagnostico-tab-ico").removeClass("text-light");
            $("#prediagnostico-tab-ico").addClass("text-success");

					  $("#diagnostico-tab").removeClass("disable-btn-nav-est");
					  $("#diagnostico-tab-ico").removeClass("text-light");

					  $("#diagnostico-tab-ico").addClass("text-success");
            
            $("#prediagnostico-tab").attr("onclick", "procesoAtencionCaso({{ config('constantes.en_prediagnostico')  }}, " + valor + ", false);");

					  $("#diagnostico-tab").attr("onclick", "procesoAtencionCaso({{ config('constantes.en_diagnostico')  }}, " + valor + ", false);");
				  }
              break;

              case {{ config('constantes.en_elaboracion_paf')  }}: // BOTON ELABORAR PAF
                  $("#diagnostico").removeClass("active show");
        				  $( "#cont_elaborarPAF" ).html(resp.html);

        				  if (estado_actual == {{ config('constantes.en_elaboracion_paf')  }}) $("#btn-etapa-elaborar").prop("disabled", false);

        				  if (cargaInicial == true) {
        					  $('#elaborarPAF-tab').click();
        					  $("#elaborarPAF-tab").focus();
        					  $("#elaborarPAF-tab").addClass("active");

                    $("#prediagnostico-tab").removeClass("disable-btn-nav-est");
        					  $("#diagnostico-tab").removeClass("disable-btn-nav-est");
        					  $("#elaborarPAF-tab").removeClass("disable-btn-nav-est");
                    $("#prediagnostico-tab-ico").removeClass("text-light");
        					  $("#diagnostico-tab-ico").removeClass("text-light");
        					  $("#elaborarPAF-tab-ico").removeClass("text-light");

                    $("#prediagnostico-tab-ico").addClass("text-success");
        					  $("#diagnostico-tab-ico").addClass("text-success");
        					  $("#elaborarPAF-tab-ico").addClass("text-success");
                    $("#prediagnostico-tab").attr("onclick", "procesoAtencionCaso({{ config('constantes.en_prediagnostico')  }}, " + valor + ", false);");
        					  $("#diagnostico-tab").attr("onclick", "procesoAtencionCaso({{ config('constantes.en_diagnostico')  }}, " + valor + ", false);");
        					  $("#elaborarPAF-tab").attr("onclick", "procesoAtencionCaso({{ config('constantes.en_elaboracion_paf')  }}, " + valor + ", false);");
        				  }
              break;

              case {{ config('constantes.en_ejecucion_paf')  }}: // BOTON EJECUTAR PAF
              $("#diagnostico").removeClass("active show");
				  $( "#cont_ejecutarPAF" ).html(resp.html);

				  if (estado_actual == {{ config('constantes.en_ejecucion_paf')  }}) $("#btn-etapa-ejecucion").prop("disabled", false);

				  if (cargaInicial == true) {
					  $('#ejecucionPAF-tab').click();
					  $("#ejecucionPAF-tab").focus();
					  $("#ejecucionPAF-tab").addClass("active");

            $("#prediagnostico-tab").removeClass("disable-btn-nav-est");
					  $("#diagnostico-tab").removeClass("disable-btn-nav-est");
					  $("#elaborarPAF-tab").removeClass("disable-btn-nav-est");
					  $("#ejecucionPAF-tab").removeClass("disable-btn-nav-est");
            $("#prediagnostico-tab-ico").removeClass("text-light");
					  $("#diagnostico-tab-ico").removeClass("text-light");
					  $("#elaborarPAF-tab-ico").removeClass("text-light");
					  $("#ejecucionPAF-tab-ico").removeClass("text-light");

            $("#prediagnostico-tab-ico").addClass("text-success");
					  $("#diagnostico-tab-ico").addClass("text-success");
					  $("#elaborarPAF-tab-ico").addClass("text-success");
					  $("#ejecucionPAF-tab-ico").addClass("text-success");
            $("#prediagnostico-tab").attr("onclick", "procesoAtencionCaso({{ config('constantes.en_prediagnostico')  }}, " + valor + ", false);");
					  $("#diagnostico-tab").attr("onclick", "procesoAtencionCaso({{ config('constantes.en_diagnostico')  }}, " + valor + ", false);");
					  $("#elaborarPAF-tab").attr("onclick", "procesoAtencionCaso({{ config('constantes.en_elaboracion_paf')  }}, " + valor + ", false);");
					  $("#ejecucionPAF-tab").attr("onclick", "procesoAtencionCaso({{ config('constantes.en_ejecucion_paf')  }}, " + valor + ", false);");
				  }
              break;

              case {{ config('constantes.en_cierre_paf')  }}: // BOTON CIERRE PAF
              $("#diagnostico").removeClass("active show");
				  $( "#cont_cierrePAF" ).html(resp.html);

				  if (estado_actual == {{ config('constantes.en_cierre_paf')  }}) $("#btn-etapa-cierre").prop("disabled", false);

				  if (cargaInicial == true) {
					  $('#cierrePAF-tab').click();
					  $("#cierrePAF-tab").focus();
					  $("#cierrePAF-tab").addClass("active");

            $("#prediagnostico-tab").removeClass("disable-btn-nav-est");
					  $("#diagnostico-tab").removeClass("disable-btn-nav-est");
					  $("#elaborarPAF-tab").removeClass("disable-btn-nav-est");
					  $("#ejecucionPAF-tab").removeClass("disable-btn-nav-est");
					  $("#cierrePAF-tab").removeClass("disable-btn-nav-est");
            $("#prediagnostico-tab-ico").removeClass("text-light");
					  $("#diagnostico-tab-ico").removeClass("text-light");
					  $("#elaborarPAF-tab-ico").removeClass("text-light");
					  $("#ejecucionPAF-tab-ico").removeClass("text-light");
					  $("#cierrePAF-tab-ico").removeClass("text-light");

            $("#prediagnostico-tab-ico").addClass("text-success");
					  $("#diagnostico-tab-ico").addClass("text-success");
					  $("#elaborarPAF-tab-ico").addClass("text-success");
					  $("#ejecucionPAF-tab-ico").addClass("text-success");
					  $("#cierrePAF-tab-ico").addClass("text-success");
            $("#prediagnostico-tab").attr("onclick", "procesoAtencionCaso({{ config('constantes.en_prediagnostico')  }}, " + valor + ", false);");
					  $("#diagnostico-tab").attr("onclick", "procesoAtencionCaso({{ config('constantes.en_diagnostico')  }}, " + valor + ", false);");
					  $("#elaborarPAF-tab").attr("onclick", "procesoAtencionCaso({{ config('constantes.en_elaboracion_paf')  }}, " + valor + ", false);");
					  $("#ejecucionPAF-tab").attr("onclick", "procesoAtencionCaso({{ config('constantes.en_ejecucion_paf')  }}, " + valor + ", false);")
					  $("#cierrePAF-tab").attr("onclick", "procesoAtencionCaso({{ config('constantes.en_cierre_paf')  }}, " + valor + ", false);");
				  }
              break;

              case {{ config('constantes.en_seguimiento_paf')  }}: // BOTON SEGUIMIENTO PAF
			  case {{ config('constantes.egreso_paf')  }}: // ESTADO FINAL
          $("#diagnostico").removeClass("active show");
				  $( "#cont_egresoPAF" ).html(resp.html);

				  if (estado_actual == {{ config('constantes.en_seguimiento_paf')  }}) $("#btn-etapa-egreso").prop("disabled", false);

				  if (cargaInicial == true) {
					  $('#seguimientoPAF-tab').click();
					  $("#seguimientoPAF-tab").focus();
					  $("#seguimientoPAF-tab").addClass("active");

            $("#prediagnostico-tab").removeClass("disable-btn-nav-est");
					  $("#diagnostico-tab").removeClass("disable-btn-nav-est");
					  $("#elaborarPAF-tab").removeClass("disable-btn-nav-est");
					  $("#ejecucionPAF-tab").removeClass("disable-btn-nav-est");
					  $("#cierrePAF-tab").removeClass("disable-btn-nav-est");
					  $("#seguimientoPAF-tab").removeClass("disable-btn-nav-est");
            $("#prediagnostico-tab-ico").removeClass("text-light");
					  $("#diagnostico-tab-ico").removeClass("text-light");
					  $("#elaborarPAF-tab-ico").removeClass("text-light");
					  $("#ejecucionPAF-tab-ico").removeClass("text-light");
					  $("#cierrePAF-tab-ico").removeClass("text-light");
					  $("#seguimientoPAF-tab-ico").removeClass("text-light");

            $("#prediagnostico-tab-ico").addClass("text-success"); 
					  $("#diagnostico-tab-ico").addClass("text-success");
					  $("#elaborarPAF-tab-ico").addClass("text-success");
					  $("#ejecucionPAF-tab-ico").addClass("text-success");
					  $("#cierrePAF-tab-ico").addClass("text-success");
					  $("#seguimientoPAF-tab-ico").addClass("text-success");
            $("#prediagnostico-tab").attr("onclick", "procesoAtencionCaso({{ config('constantes.en_prediagnostico')  }}, " + valor + ", false);");
					  $("#diagnostico-tab").attr("onclick", "procesoAtencionCaso({{ config('constantes.en_diagnostico')  }}, " + valor + ", false);");
					  $("#elaborarPAF-tab").attr("onclick", "procesoAtencionCaso({{ config('constantes.en_elaboracion_paf')  }}, " + valor + ", false);");
					  $("#ejecucionPAF-tab").attr("onclick", "procesoAtencionCaso({{ config('constantes.en_ejecucion_paf')  }}, " + valor + ", false);");
					  $("#cierrePAF-tab").attr("onclick", "procesoAtencionCaso({{ config('constantes.en_cierre_paf')  }}, " + valor + ", false);");
					  $("#seguimientoPAF-tab").attr("onclick", "procesoAtencionCaso({{ config('constantes.en_seguimiento_paf')  }}, " + valor + ", false);");
				  }
              break;

          default:
            $( "#cont_prediagnostico" ).html(resp.html);

            if (cargaInicial == true) {
              $('#prediagnostico-tab').click();
              $("#prediagnostico-tab").focus();
              $("#prediagnostico-tab").addClass("active");

              $("#prediagnostico-tab").removeClass("disable-btn-nav-est");
              $("#diagnostico-tab").removeClass("disable-btn-nav-est");
              $("#elaborarPAF-tab").removeClass("disable-btn-nav-est");
              $("#ejecucionPAF-tab").removeClass("disable-btn-nav-est");
              $("#cierrePAF-tab").removeClass("disable-btn-nav-est");
              $("#seguimientoPAF-tab").removeClass("disable-btn-nav-est");
              $("#prediagnostico-tab-ico").removeClass("text-light");
              $("#diagnostico-tab-ico").removeClass("text-light");
              $("#elaborarPAF-tab-ico").removeClass("text-light");
              $("#ejecucionPAF-tab-ico").removeClass("text-light");
              $("#cierrePAF-tab-ico").removeClass("text-light");
              $("#seguimientoPAF-tab-ico").removeClass("text-light");

              $("#prediagnostico-tab-ico").addClass("text-success");
              $("#diagnostico-tab-ico").addClass("text-success");
              $("#elaborarPAF-tab-ico").addClass("text-success");
              $("#ejecucionPAF-tab-ico").addClass("text-success");
              $("#cierrePAF-tab-ico").addClass("text-success");
              $("#seguimientoPAF-tab-ico").addClass("text-success");
              $("#prediagnostico-tab").attr("onclick", "procesoAtencionCaso({{ config('constantes.en_prediagnostico')  }}, " + valor + ", false);");$("#diagnostico-tab").attr("onclick", "procesoAtencionCaso({{ config('constantes.en_diagnostico')  }}, " + valor + ", false);");
              $("#elaborarPAF-tab").attr("onclick", "procesoAtencionCaso({{ config('constantes.en_elaboracion_paf')  }}, " + valor + ", false);");
              $("#ejecucionPAF-tab").attr("onclick", "procesoAtencionCaso({{ config('constantes.en_ejecucion_paf')  }}, " + valor + ", false);");
              $("#cierrePAF-tab").attr("onclick", "procesoAtencionCaso({{ config('constantes.en_cierre_paf')  }}, " + valor + ", false);");
              $("#seguimientoPAF-tab").attr("onclick", "procesoAtencionCaso({{ config('constantes.en_seguimiento_paf')  }}, " + valor + ", false);");
            }
		  }
    }).fail(function(objeto, tipoError, errorHttp){
      let cantidad_intentos = (recargar + 1);
      
      if (cantidad_intentos < 3){ 
        procesoAtencionCaso(option, valor, cargaInicial, cantidad_intentos);
      
      }else{
        desbloquearPantalla();

        let mensaje = "Hubo un error al momento de cargar la información solicitada.";

        if (objeto.status === 0){
          alert(mensaje+"\n\n- Sin conexión: Verifique su red o intente nuevamente.");

        } else if (objeto.status == 404){
          alert(mensaje+"\n\n- Página solicitada no encontrada [404].");

        } else if (objeto.status == 500){
          alert(mensaje+"\n\n- Error interno del servidor [500].");

        } else if (tipoError === 'parsererror') {
          alert(mensaje+"\n\n- Error al manipular respuesta JSON.");

        } else if (tipoError === 'timeout') {
          alert(mensaje+"\n\n- Error de tiempo de espera.");

        } else if (tipoError === 'abort') {
          alert(mensaje+"\n\n- Solicitud Ajax abortada.");

        } else {
          alert(mensaje);

          console.log('Error no capturado: ' + objeto.responseText);
        }

        console.log(objeto); return false;
      }

    });
  }

  contenido_textarea_rechazo_estados = ""; 
  function valTextAreaCambioEstadoRechazo(){
      num_caracteres_permitidos   = 255;

      num_caracteres = $("#comentario_estado").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#comentario_estado").val(contenido_textarea_rechazo_estados);

       }else{ 
          contenido_textarea_rechazo_estados = $("#comentario_estado").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_cam_est").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_cam_est").css("color", "#000000");

       } 

      
       $("#cant_carac_cam_est").text($("#comentario_estado").val().length);
   }


  contenido_textarea_observacion1 = ""; 
  function valTextAreaprediagnostico_observacion1(){
      num_caracteres_permitidos   = 1000;

      num_caracteres = $("#obs_prediagnostico_1").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#obs_prediagnostico_1").val(contenido_textarea_observacion1);

       }else{ 
          contenido_textarea_observacion1 = $("#obs_prediagnostico_1").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_1").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_1").css("color", "#000000");

       } 

      
       $("#cant_carac_1").text($("#obs_prediagnostico_1").val().length);
   }



contenido_textarea_observacion2 = ""; 
  function valTextAreaprediagnostico_observacion2(){
      num_caracteres_permitidos   = 1000;

      num_caracteres = $("#obs_prediagnostico_2").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#obs_prediagnostico_2").val(contenido_textarea_observacion2);

       }else{ 
          contenido_textarea_observacion2 = $("#obs_prediagnostico_2").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_2").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_2").css("color", "#000000");

       } 

      
       $("#cant_carac_2").text($("#obs_prediagnostico_2").val().length);
   }

contenido_textarea_observacion3 = ""; 
  function valTextAreaprediagnostico_observacion3(){
      num_caracteres_permitidos   = 1000;

      num_caracteres = $("#obs_prediagnostico_3").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#obs_prediagnostico_3").val(contenido_textarea_observacion3);

       }else{ 
          contenido_textarea_observacion3 = $("#obs_prediagnostico_3").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_3").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_3").css("color", "#000000");

       } 

      
       $("#cant_carac_3").text($("#obs_prediagnostico_3").val().length);
   }

contenido_textarea_observacion4 = ""; 
  function valTextAreaprediagnostico_observacion4(){
      num_caracteres_permitidos   = 1000;

      num_caracteres = $("#obs_prediagnostico_4").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#obs_prediagnostico_4").val(contenido_textarea_observacion4);

       }else{ 
          contenido_textarea_observacion4 = $("#obs_prediagnostico_4").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_4").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_4").css("color", "#000000");

       } 

      
       $("#cant_carac_4").text($("#obs_prediagnostico_4").val().length);
   }



contenido_textarea_observacion5 = ""; 
  function valTextAreaprediagnostico_observacion5(){
      num_caracteres_permitidos   = 1000;

      num_caracteres = $("#obs_prediagnostico_5").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#obs_prediagnostico_5").val(contenido_textarea_observacion5);

       }else{ 
          contenido_textarea_observacion5 = $("#obs_prediagnostico_5").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_5").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_5").css("color", "#000000");

       } 

      
       $("#cant_carac_5").text($("#obs_prediagnostico_5").val().length);
   }

contenido_textarea_observacion6 = ""; 
  function valTextAreaprediagnostico_observacion6(){
      num_caracteres_permitidos   = 1000;

      num_caracteres = $("#obs_prediagnostico_6").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#obs_prediagnostico_6").val(contenido_textarea_observacion6);

       }else{ 
          contenido_textarea_observacion6 = $("#obs_prediagnostico_6").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_6").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_6").css("color", "#000000");

       } 

      
       $("#cant_carac_6").text($("#obs_prediagnostico_6").val().length);
   }


  function validarCantAsig(){

    let id_usu = $('#id_usu').val();
    let run_nna = $('#run_nna').val();

    let data = new Object();
    data.run = run_nna;
    data.nna = run_nna;
    data.id_usu = id_usu;
        $.ajax({
            'type'    : "GET",
            'dataType'  : "JSON",
            'url'   : "{{route('casos.verificar.opd')}}",
            'data'    : data
          }).done(function(resp) {

              let cant_asignaciones = resp[3];

              let estado_desestimado = resp[2];

              let verificar_opd = resp[1];

              let nombre_gestor= resp[0];

              let observacion = "";

               // if(cant_asignaciones>=40){

               //  alert("ALERTA: No se puede asignar al Gestor(a): "+nombre_gestor+", ya que tiene asignado el máximo de casos activos.");

               //  return false;

               // }

               if(verificar_opd==1){
                  observacion = "Nota: El NNA fue atendido anteriormente y fue desestimado. \n \n Estado de desestimación: "+estado_desestimado+".";
                }

               let confirmacion = confirm("¿Esta seguro que desea realizar la siguiente asignación? \n \n Gestor(a): "+nombre_gestor+". \n \n "+observacion+"");
          
                if (confirmacion) {

                  if($('#id_caso').val() != 0){
                    gestionCasoAsignarNNA();
                  }else{
                  $.ajax({
                    type		: "GET",
                    dataType	: "json",
                    url			: "{{route('validar.asignacion_caso_periodo')}}",
                    data		: data
                  }).done(function(obj) {
                    console.log(obj);
                    if (obj.estado == 1){

                      if(obj.cantidad_periodo == 0){
                  gestionCasoAsignarNNA();
                      }else{
                        alert("No es posible asignar NNA, debido a que ya fue asignado en el mes.");
                      }

                    }else{
                      alert("Error al momento de asignar NNA al Gestor, Por favor intente nuevamente.");

                    }
                  }).fail(function(obj){
                    if (obj.responseJSON.mensaje){
                      alert(obj.responseJSON.mensaje);
                    }else{
                      alert("Error al momento de asignar NNA al Gestor, Por favor intente nuevamente.");
                }
                  });

                }
                 
                }
          }).fail(function(resp){
          
            alert("Hubo un problema, favor intente nuevamente");

          });

  }

function gestionCasoAsignarNNA(){
    bloquearPantalla();
    let data = new Object();
    data.id_usu = $('#id_usu').val();
    data.nna = $('#run_nna').val();
    data.id_usu_anterior = $('#id_usu_anterior').val();
    // INICIO CZ SPRINT 68
    if($('#id_caso').val() != 0){
      var url = "{{route('casos.reasignarNNAaGestor')}}";
    }else{
      var url = "{{route('casos.asignarNNAaGestor')}}";
    }
    // FIN CZ SPRINT 68
    data.id_caso = $('#id_caso').val();
    //data.post = $('#post').val();
    //data.run_nna = $('#run_nna').val();

  $.ajax({
     type    : "GET",
     dataType  : "json",
     url     : url,
     data    : data
     }).done(function(obj) {
       desbloquearPantalla();
     if (obj.estado == 1){

      alert(obj.mensaje);

      if($('#id_caso').val() == 0){
        var redirect = "{{route('atencion-nna')}}/"+ data.nna+"/"+obj.caso_asig;
        setTimeout( function() { window.location.href = redirect  }, 3000 );

      }else{
      location.reload();
      }
      }else{
     
      alert("Error al momento de asignar NNA al Gestor, Por favor intente nuevamente.");

     }
     }).fail(function(obj){
      desbloquearPantalla();
     if (obj.responseJSON.mensaje){
      alert(obj.responseJSON.mensaje);
      }else{

      alert("Error al momento de asignar NNA al Gestor, Por favor intente nuevamente.");
      
      }
  });

}


</script>
<style type="text/css">
  .disable-btn-nav-est{
      color: currentColor;
      cursor: not-allowed;
      opacity: 0.5;
      pointer-events: none;
  }
</style>
@endsection