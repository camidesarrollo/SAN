@extends('layouts.main')
@section('contenido')
<main id="content">

          <section>
            <div class="container-fluid">
              <div id="historial-nna">
                          <div id="datos-nna" class="sticky-top">
              <div class="m-3">
                <h5 class="">
                  <img class="mr-3" src="/img/ico-nna.png">  
                   <!--INICIO CZ SPRINT  57 -->
                  Caso: {{$caso->cas_id}} - {{ $caso->nombre }}
                   <!--FIN CZ SPRINT  57 -->
                  <small><i class="fa fa-id-card ml-3 mr-2"></i> <?php print_r(Helper::devuelveRutX(number_format($caso->run,0,",",".")."-".($caso->dig)));?> </small>
                  <small><i class="fa fa-birthday-cake ml-3 mr-2"></i> {{ $caso->edad_ani }} Años</small>

                  <small>
                   
                  @if($caso->est_pau==1)
                     <!-- Fecha: 02/02/2022 Motivo: El proceso actual no permite pausar casos -->
                      <!-- <button  class="btn  btn-outline-danger  btn-sm p-2" style="padding:7.5px;" data-toggle="modal" type="button" @if((Session::get('perfil')==config('constantes.perfil_gestor')))  data-target="#crearPausaModal" @endif>
                      <i class="fas fa-pause ml-2 mr-2" aria-hidden="true"></i> -->
                    @else
                      <button  class="btn  btn-outline-success  btn-sm" style="padding:7.5px;" data-toggle="modal" type="button"  @if((Session::get('perfil')==config('constantes.perfil_gestor')))  data-target="#crearPausaModal" @endif   >
                      <i class="fa fa-play ml-2 mr-2" aria-hidden="true"></i>
                    @endif

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

                    @if ((Session::get('perfil') == config('constantes.perfil_gestor')) || (Session::get('perfil') == config('constantes.perfil_coordinador_regional')) ||  (Session::get('perfil') == config('constantes.perfil_coordinador')) || (Session::get('perfil') == config('constantes.perfil_super_usuario')))
                      <li class="nav-item">
                      <!-- INICIO CZ SPRINT 63 Casos ingresados a ONL -->
                        @if($caso->cas_id != "")
                          <a class="nav-link" href="{{ route('atencion-nna') }}/{{ $run }}/{{$caso->cas_id}}">GESTIÓN DE CASOS</a>
                        @else
                          <a class="nav-link" href="{{ route('atencion-nna') }}/{{ $run }}/0">GESTIÓN DE CASOS</a>
                        @endif
                        <!-- FIN CZ SPRINT 63 Casos ingresados a ONL -->
                      </li>
                    @endif

                    @if ((Session::get('perfil') == config('constantes.perfil_terapeuta')) || (Session::get('perfil') == config('constantes.perfil_coordinador')) || (Session::get('perfil') == config('constantes.perfil_coordinador_regional')))
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
                      <a class="nav-link active show" href="{{ route('historial-nna') }}/{{ $run }}/{{$caso->cas_id}}">HISTORIAL NNA</a>
                      @else
                      <a class="nav-link active show" href="{{ route('historial-nna') }}/{{ $run }}/0">HISTORIAL NNA</a>
                      @endif
                      <!-- FIN CZ SPRINT 63 Casos ingresados a ONL -->
                    </li>
                  </ul>
                  <!-- MENU MAIN  -->
                  
                  <ul class="nav nav-pills mt-0 p-1 sticky-top" id="myTab" role="tablist">
                      <!--<li class="nav-item">
                        <a class="nav-link" id="historial-tab" data-toggle="tab" href="#historial" role="tab" aria-controls="historial" aria-selected="false">Historial del Caso</a>
                      </li>-->
                      <li class="nav-item">
                        <a class="nav-link active show" id="alertas-tab" data-toggle="tab" href="#alertas" role="tab" aria-controls="alertas" aria-selected="true">Alertas Territoriales</a>
                      </li>
                   </ul>

                  <div class="card shadow p-4 ">
                  

                    <div class="tab-content" id="myTabContent">
                      <!--<div class="tab-pane fade" id="historial" role="tabpanel" aria-labelledby="historial-tab">

                      <div class="card p-4">
                        <h5><span class="fa fa-list mr-2"></span> Historial del Caso</h5>
                          <div id="tracking-pre"></div>
                           <div id="tracking">
                              <div class="text-center status-encurso p-4 bg-warning">
                                 <h4 class="text-light">Estado: DIAGNOSTICADO</h4>
                              </div>
                              <div class="tracking-list">
                                 <div class="tracking-item">
                                    <div class="tracking-icon status-finalizado">
                                       <span class="fa fa-check mr-4"></span>
                                    </div>
                                    <div class="tracking-date">Aug 10, 2018<span>05:01 PM</span></div>
                                    <div class="tracking-content"><h5>VERIFICADO</h5><p>El caso ha sido verificado</p></div>
                                 </div>
                                 <div class="tracking-item">
                                    <div class="tracking-icon status-finalizado">
                                       <span class="fa fa-check mr-4"></span>
                                    </div>
                                    <div class="tracking-date">Jul 27, 2018<span>04:08 PM</span></div>
                                    <div class="tracking-content"><h5>ASIGNADO</h5><p>El caso fue derivado a facilitador: Felipe Bruna P. </p></div>
                                 </div>
                                 <div class="tracking-item">
                                    <div class="tracking-icon status-encurso">
                                       <span class="fa fa-asterisk mr-4"></span>
                                    </div>
                                    <div class="tracking-date">Aug 10, 2018<span>11:19 AM</span></div>
                                    <div class="tracking-content"><h5>DIAGNOSTICADO</h5><p>El facilitador ha diagnosticado y se tramita el plan de acción</p></div>
                                 </div>
                                 
                                 <div class="tracking-item">
                                    <div class="tracking-icon status-pendiente">
                                       <span class="fa fa-ban mr-4"></span>
                                    </div>
                                    <div class="tracking-date">Jul 20, 2018<span>05:25 PM</span></div>
                                    <div class="tracking-content"><h5>COMIENZA INTERVENCIÓN</h5><p>El facilitador ejecuta plan de acción</p></div>
                                 </div>
                                 <div class="tracking-item">
                                    <div class="tracking-icon status-pendiente">
                                       <span class="fa fa-ban mr-4"></span>
                                    </div>
                                    <div class="tracking-date">Jul 20, 2018<span>05:25 PM</span></div>
                                    <div class="tracking-content"><h5>FINALIZA INTERVENCIÓN</h5><p>Plan de acción ejecutado</p></div>
                                 </div>
                                 
                                 
                              </div>
                      
                        </div>
                      </div>
                      </div>-->

                    <!-- ALERTAS TERRITORIALES NNA -->

                    <div class="tab-pane fade active show" id="alertas" role="tabpanel" aria-labelledby="alertas-tab">
                        <div class="card p-4">
                          <h5 class="modal-title"><img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDQ4Ni40NjMgNDg2LjQ2MyIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNDg2LjQ2MyA0ODYuNDYzOyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgd2lkdGg9IjUxMnB4IiBoZWlnaHQ9IjUxMnB4Ij4KPGc+Cgk8Zz4KCQk8cGF0aCBkPSJNMjQzLjIyNSwzMzMuMzgyYy0xMy42LDAtMjUsMTEuNC0yNSwyNXMxMS40LDI1LDI1LDI1YzEzLjEsMCwyNS0xMS40LDI0LjQtMjQuNCAgICBDMjY4LjIyNSwzNDQuNjgyLDI1Ni45MjUsMzMzLjM4MiwyNDMuMjI1LDMzMy4zODJ6IiBmaWxsPSIjMDAwMDAwIi8+CgkJPHBhdGggZD0iTTQ3NC42MjUsNDIxLjk4MmMxNS43LTI3LjEsMTUuOC01OS40LDAuMi04Ni40bC0xNTYuNi0yNzEuMmMtMTUuNS0yNy4zLTQzLjUtNDMuNS03NC45LTQzLjVzLTU5LjQsMTYuMy03NC45LDQzLjQgICAgbC0xNTYuOCwyNzEuNWMtMTUuNiwyNy4zLTE1LjUsNTkuOCwwLjMsODYuOWMxNS42LDI2LjgsNDMuNSw0Mi45LDc0LjcsNDIuOWgzMTIuOCAgICBDNDMwLjcyNSw0NjUuNTgyLDQ1OC44MjUsNDQ5LjI4Miw0NzQuNjI1LDQyMS45ODJ6IE00NDAuNjI1LDQwMi4zODJjLTguNywxNS0yNC4xLDIzLjktNDEuMywyMy45aC0zMTIuOCAgICBjLTE3LDAtMzIuMy04LjctNDAuOC0yMy40Yy04LjYtMTQuOS04LjctMzIuNy0wLjEtNDcuN2wxNTYuOC0yNzEuNGM4LjUtMTQuOSwyMy43LTIzLjcsNDAuOS0yMy43YzE3LjEsMCwzMi40LDguOSw0MC45LDIzLjggICAgbDE1Ni43LDI3MS40QzQ0OS4zMjUsMzY5Ljg4Miw0NDkuMjI1LDM4Ny40ODIsNDQwLjYyNSw0MDIuMzgyeiIgZmlsbD0iIzAwMDAwMCIvPgoJCTxwYXRoIGQ9Ik0yMzcuMDI1LDE1Ny44ODJjLTExLjksMy40LTE5LjMsMTQuMi0xOS4zLDI3LjNjMC42LDcuOSwxLjEsMTUuOSwxLjcsMjMuOGMxLjcsMzAuMSwzLjQsNTkuNiw1LjEsODkuNyAgICBjMC42LDEwLjIsOC41LDE3LjYsMTguNywxNy42YzEwLjIsMCwxOC4yLTcuOSwxOC43LTE4LjJjMC02LjIsMC0xMS45LDAuNi0xOC4yYzEuMS0xOS4zLDIuMy0zOC42LDMuNC01Ny45ICAgIGMwLjYtMTIuNSwxLjctMjUsMi4zLTM3LjVjMC00LjUtMC42LTguNS0yLjMtMTIuNUMyNjAuODI1LDE2MC43ODIsMjQ4LjkyNSwxNTUuMDgyLDIzNy4wMjUsMTU3Ljg4MnoiIGZpbGw9IiMwMDAwMDAiLz4KCTwvZz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K" height="20px" style="margin-top: -3px;" /> Alertas</h5>
                          <hr>
                          <div>
                                <div class="card colapsable shadow-sm">
                                  <a class="btn text-left p-0" id="btn_ncfas"  data-toggle="collapse" data-target="#ncfas" aria-expanded="false" aria-controls="ncfas" onclick="">
                                  <div class="card-header p-3">
                                        <h5 class="mb-0"><button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Alertas generadas en el Sistema Alerta Niñez."><i class="fa fa-info"></i></button>&nbsp;&nbsp;Alertas Territoriales</h5>
                                  </div>
                                  </a>
                                  <div class="collapse" id="ncfas">
                                    <div class="card-body">
                                            <table class="table table-bordered table-hover table-striped">
                                              <thead>
                                                  <tr>
                                                    <th style="text-align: center;">Alerta</th>
                                                    <th style="text-align: center;">Fecha de Creación</th>
                                                    <th>Estado</th>
                                                    <th>Responable</th>
                                                  </tr>
                                              </thead>
                                              <tbody>
                                                @foreach ($alertas_san_nna as $v)

                                                @php $fecha = date('d-m-Y', strtotime($v->ale_man_fec)) @endphp

                                                  <tr style=" background-color:#ffffff;">
                                                     <td>{{$v->ale_tip_nom}}</td>
                                                     <td>{{$fecha}}</td>
                                                     <td>{{$v->est_ale_nom}}</td>
                                                     <td>{{$v->responsable}}</td>
                                                  </tr>

                                                @endforeach

                                                @if($alertas_san_nna==[])
                                                <td style="text-align: center;" colspan="5" class="dataTables_empty" valign="top">Ningún dato disponible en esta tabla</td>
                                                @endif

                                              </tbody>
                                            </table>                   
                                      </div>
                                  </div>
                                </div>
                          </div>
                          <div>
                                <div class="card colapsable shadow-sm">
                                  <a class="btn text-left p-0" id="btn_ccc"  data-toggle="collapse" data-target="#ccc" aria-expanded="false" aria-controls="ccc" onclick="">
                                  <div class="card-header p-3">
                                        <h5 class="mb-0"><button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Alertas de la Nómina Mensual."><i class="fa fa-info"></i></button>&nbsp;&nbsp;Chile Crece Contigo</h5>
                                  </div>
                                  </a>
                                  <div class="collapse" id="ccc">
                                    <div class="card-body">
                                          <table class="table table-bordered table-hover table-striped" id="listar_alertas_territoriales_historial">
                                          <thead>
                                              <tr>
                                                <th style="text-align: center;">Alerta</th>
                                                <th>Fecha de Creación</th>
                                                <th>Procede de</th>
                                                <th style="text-align: center;">Establecimiento de Origen</th>
                                                <th>Comuna del Establecimiento</th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                            @foreach ($alertas_territoriales_historial AS $c1 => $v1)
                                              <tr @if ($v1->ale_chcc_en_nom == 1) style=" background-color: #b9caef;" @else style=" background-color:#ffffff;" @endif>
                                                 <td>{{ $v1->ale_chcc_ind }}</td>
                                                 <td>{{ $v1->fecha_formateada }}</td>
                                                 <td>{{ $v1->ale_chcc_pro }}</td>
                                                 <td>{{ $v1->origen }}</td>
                                                 <td>{{ $v1->comuna_nombre }}</td>
                                              </tr>
                                            @endforeach
                                          </tbody>
                                        </table>    
                                  </div>
                                  </div>
                                </div>
                          </div>

                          <div class="card p-4" style="font-size: 0.8em;background-color: #efe0b7;">
                            <ul style="margin-bottom:0;">
                              <li>Las alertas que se presentan resaltadas en color violeta son parte de la nómina comunal actual.</li>
                            </ul>
                          </div>

                          <div class="card p-4" style="font-size: 0.8em;background-color: #efe0b7;">
                              <ul style="margin-bottom:0;">
                                <li>Las alertas que se presentan resaltadas en color violeta son parte de la nómina comunal actual.</li>
                                <li>Las Alertas ChCC relacionadas a la precariedad en la vivienda “Niño/a en condiciones de habitabilidad precarias” y “Gestante en condiciones de habitabilidad precarias”, fueron homologadas y, por ende, contabilizadas como uno en la suma de Alertas Territoriales en presencia de al menos una de ellas.</li>
                                <li>Las Alertas ChCC relacionadas a la situación socioeconómica “Familia del niño/a sin adultos que generen ingresos”, “Existe cesantía en el entorno familiar primario” y “Bajos ingresos o cesantía en el entorno familiar de la gestante”, fueron homologadas y, por ende, contabilizadas como uno en la suma de Alertas Territoriales en presencia de al menos una de ellas.</li>
                                <li>El resto de las Alertas de ChCC, “Madre con resultado alterado en aplicación de Escala de Depresión Postparto”, “Niño/a en situación de discapacidad permanente”, “Niño/a con resultado anormal en evaluación del neurodesarrollo”, “Familiares con consumo de drogas y/o alcohol”, “Padre, madre o cuidador en tratamiento o con historia de atención en Salud Mental”, “Padre, madre o cuidador en situación de reclusión”, “Situación de migración o familia en situación de migración”, “Riesgo Psicosocial de la Gestante: síntomas depresivos”, “Riesgo Psicosocial de la Gestante: abuso de sustancias”, “Riesgo Psicosocial de la Gestante: conflictos con la maternidad”, “Riesgo Psicosocial de la Gestante: insuficiente apoyo social familiar”,  fueron contabilizado como uno en la suma de Alertas Territoriales en presencia de al menos una de ellas.</li>
                              </ul>
                            </div>
<!--                           <h5><span class="fa fa-warning mr-2"></span>Alertas SAN</h5>

                            <table class="table table-bordered table-hover table-striped">
                              <thead>
                                  <tr>
                                    <th style="text-align: center;">Alerta</th>
                                    <th style="text-align: center;">Fecha de Creación</th>
                                    <th>Estado</th>
                                    <th>Responable</th>
                                  </tr>
                              </thead>
                              <tbody>
                                @foreach ($alertas_san_nna as $v)

                                @php $fecha = date('d-m-Y', strtotime($v->ale_man_fec)) @endphp

                                  <tr>
                                     <td>{{$v->ale_tip_nom}}</td>
                                     <td>{{$fecha}}</td>
                                     <td>{{$v->est_ale_nom}}</td>
                                     <td>{{$v->responsable}}</td>
                                  </tr>

                                @endforeach

                                @if($alertas_san_nna==[])
                                <td style="text-align: center;" colspan="5" class="dataTables_empty" valign="top">Ningún dato disponible en esta tabla</td>
                                @endif

                              </tbody>
                            </table> -->
                          
                      </div>

                    <!-- FIN ALERTAS TERRITORIALES NNA -->

<!--                       <div class="tab-pane fade active show" id="alertas" role="tabpanel" aria-labelledby="alertas-tab">
                        <div class="card p-4">
                          <h5><span class="fa fa-warning mr-2"></span>Alertas Chile Crece Contigo</h5>
                            <table class="table table-bordered table-hover table-striped" id="listar_alertas_territoriales_historial">
                              <thead>
                                  <tr>
                                    <th style="text-align: center;">Alerta</th>
                                    <th>Fecha de Creación</th>
                                    <th>Procede de</th>
                                    <th style="text-align: center;">Establecimiento de Origen</th>
                                    <th>Comuna del Establecimiento</th>
                                  </tr>
                              </thead>
                              <tbody>
                                @foreach ($alertas_territoriales_historial AS $c1 => $v1)
                                  <tr @if ($v1->ale_chcc_en_nom == 1) style=" background-color: #b9caef;" @endif>
                                     <td>{{ $v1->ale_chcc_ind }}</td>
                                     <td>{{ $v1->fecha_formateada }}</td>
                                     <td>{{ $v1->ale_chcc_pro }}</td>
                                     <td>{{ $v1->origen }}</td>
                                     <td>{{ $v1->comuna_nombre }}</td>
                                  </tr>
                                @endforeach
                              </tbody>
                            </table>
                            <div class="card p-4" style="font-size: 0.8em;background-color: #efe0b7;">
                              <ul>
                                <li>Las Alertas ChCC relacionadas a la precariedad en la vivienda “Niño/a en condiciones de habitabilidad precarias” y “Gestante en condiciones de habitabilidad precarias”, fueron homologadas y, por ende, contabilizadas como uno en la suma de Alertas Territoriales en presencia de al menos una de ellas.</li>
                                <li>Las Alertas ChCC relacionadas a la situación socioeconómica “Familia del niño/a sin adultos que generen ingresos”, “Existe cesantía en el entorno familiar primario” y “Bajos ingresos o cesantía en el entorno familiar de la gestante”, fueron homologadas y, por ende, contabilizadas como uno en la suma de Alertas Territoriales en presencia de al menos una de ellas.</li>
                                <li>El resto de las Alertas de ChCC, “Madre con resultado alterado en aplicación de Escala de Depresión Postparto”, “Niño/a en situación de discapacidad permanente”, “Niño/a con resultado anormal en evaluación del neurodesarrollo”, “Familiares con consumo de drogas y/o alcohol”, “Padre, madre o cuidador en tratamiento o con historia de atención en Salud Mental”, “Padre, madre o cuidador en situación de reclusión”, “Situación de migración o familia en situación de migración”, “Riesgo Psicosocial de la Gestante: síntomas depresivos”, “Riesgo Psicosocial de la Gestante: abuso de sustancias”, “Riesgo Psicosocial de la Gestante: conflictos con la maternidad”, “Riesgo Psicosocial de la Gestante: insuficiente apoyo social familiar”,  fueron contabilizado como uno en la suma de Alertas Territoriales en presencia de al menos una de ellas.</li>
                              </ul>
                            </div> -->
                      
                   <!--      <h5><span class="fa fa-warning mr-2"></span>Alertas Experto</h5> -->
  
                          <!--<h5>Alertas Chile Crece Contigo</h5>
                          <table class="table">
                            <thead>
                            <tr>
                              <th>Alerta</th>
                              <th>Acción</th>
                              <th>Estado</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                              <td>Niño/a pertenece al tramo menor o igual a 60</td>
                              <td>
                                <ul>
                                  <li>Gestionar acceso al SUF, si cumple requisitos.</li>
                                  <li>Gestionar inscripción en OMIL para acceso a trabajo y/o apresto laboral</li>
                                </ul>
                              </td>
                              <td>Pendiente</td>
                            </tr>
                            </tbody>
                          </table>-->
                      </div>

          
            
                  </div>
            </div>
          </div>
        </div>
      </div>


    </section>
</main>



@includeif('ficha.pausas.historial_pausa_modal')
@includeif('ficha.pausas.crear_pausa_modal')

@endsection
  <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script type="text/javascript" src="{{ env('APP_URL') }}/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
  $( document ).ready(function(){ 
    $('#listar_alertas_territoriales_historial').DataTable({
            ordering:   false,
            paging:     false,
            searching:  false,
            info:       true,
            columnDefs: [
                {"className": "dt-left", "targets": [0]},
                {"className": "dt-center", "targets": [1]},
                {"className": "dt-center", "targets": [2]},
                {"className": "dt-left", "targets": [3]},
                {"className": "dt-center", "targets": [4]}],
            language: { "url": "{{ route('index') }}/js/dataTables.spanish.json"}
    });
  });
</script>
<script type="text/javascript">
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })
</script>