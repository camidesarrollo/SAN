@extends('layouts.main')
@section('contenido')

<!-- HIDDEN -->
  <input type="hidden" name="url_terapia_cambio_estado" id="url_terapia_cambio_estado" value="{{ route('terapia.cambio.estado')  }}">
  <input type="hidden" name="cas_id" id="cas_id" value="{{ $caso->cas_id}}">
  <input type="hidden" name="perfil" id="perfil" value="{{session()->all()['perfil']}}">

  <input type="hidden" name="run_nna" id="run_nna" value="{{ $run }}">
  <!-- //CZ SPRINT 74 -->
  <input type="hidden" name="url_tabla_notificacion_Intervencion" id="url_tabla_notificacion_Intervencion" value="{{ route('data.notificacionTiempoIntervencionTabla')  }}">
  <input type="hidden" name="url_cantidad_notificacion" id="url_cantidad_notificacion" value="{{ route('data.cantidadNotificaciones')  }}">
  <input type="hidden" name="url_cantidadNotificacionesTiempo" id="url_cantidadNotificacionesTiempo" value="{{ route('data.cantidadNotificacionesTiempo')  }}">
  <input type="hidden" name="url_dataTables_spanish" id="url_dataTables_spanish" value="{{ route('index') }}/js/dataTables.spanish.json">
  <input type="hidden" name="url_caso" id="url_caso" value="{{ route('coordinador.caso.ficha') }}">
  <!-- //CZ SPRINT 74 -->
<!-- 
  <input type="hidden" name="est_act_cas" id="est_act_cas" value="{{-- $estado_actual_caso --}} "> -->
  <input type="hidden" name="url_cambiar_bitacora_terapia" id="url_cambiar_bitacora_terapia" value="{{ route('terapia.cambio.bitacora')  }}">
  <input type="hidden" name="est_act_ter" id="est_act_ter" value="{{ $nna_teparia->est_tera_id }}">

  <input type="hidden" name="tera_id" id="tera_id" value="{{ $nna_teparia->tera_id }}">

  <!-- <input type="hidden" name="est_prediag_cons" id="est_prediag_cons" value="{{ config('constantes.en_prediagnostico')  }}">
  <input type="hidden" name="est_diag_cons" id="est_diag_cons" value="{{ config('constantes.en_diagnostico')  }}">
  <input type="hidden" name="est_elab_cons" id="est_elab_cons" value="{{ config('constantes.en_elaboracion_paf')  }}">
  <input type="hidden" name="est_ejec_cons" id="est_ejec_cons" value="{{ config('constantes.en_ejecucion_paf')  }}">
  <input type="hidden" name="est_cier_cons" id="est_cier_cons" value="{{ config('constantes.en_cierre_paf')  }}">
  <input type="hidden" name="est_segu_cons" id="est_segu_cons" value="{{ config('constantes.en_seguimiento_paf')  }}">
  <input type="hidden" name="est_segu_cons" id="est_egre_cons" value="{{ config('constantes.egreso_paf')  }}">
  <input type="hidden" name="est_segu_cons" id="est_rech_fami_cons" value="{{ config('constantes.rechazado_por_familiares')  }}">
  <input type="hidden" name="est_segu_cons" id="est_rech_gest_cons" value="{{ config('constantes.rechazado_por_gestor')  }}"> -->
<!-- HIDDEN -->


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
                  Caso: {{$caso->cas_id}} - {{ $caso->nombre }}
                   <!--FIN CZ SPRINT  57 -->
                  <small><i class="fa fa-id-card ml-3 mr-2"></i> {{ number_format($caso->run,0,",",".")."-".($caso->dig) }} </small>
                  <small><i class="fa fa-birthday-cake ml-3 mr-2"></i>  {{ $caso->edad_ani }} Años</small>
                   <small>
                   
                  @if($caso->est_pau==1)
                     <!-- Fecha: 02/02/2022 Motivo: El proceso actual no permite pausar casos -->
                      <!-- <button  class="btn  btn-outline-danger  btn-sm" data-toggle="modal" type="button" @if((Session::get('perfil')==config('constantes.perfil_gestor')))  data-target="#crearPausaModal" @endif>
                      <i class="fas fa-pause ml-2 mr-2" aria-hidden="true"></i> -->
                    @else
                      <button  class="btn  btn-outline-success  btn-sm" data-toggle="modal" type="button"  @if((Session::get('perfil')==config('constantes.perfil_gestor')))  data-target="#crearPausaModal" @endif   >
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
        <!-- INICIO CZ SPRINT  63 -->
            <li class="nav-item">
                @if($caso->cas_id != "")
                  <a class="nav-link" href="{{ route('coordinador.caso.ficha') }}/{{ $run }}/{{$caso->cas_id}}">ANTECEDENTES</a>
                @else
                  <a class="nav-link" href="{{ route('coordinador.caso.ficha') }}/{{ $run }}/0">ANTECEDENTES</a>
                @endif
          <!-- FIN CZ SPRINT  63 -->      
            </li>

            @if (Session::get('perfil') == config('constantes.perfil_coordinador') || (Session::get('perfil') == config('constantes.perfil_coordinador_regional')))
            <!-- INICIO CZ SPRINT  63 -->
                <li class="nav-item">
                @if($caso->cas_id != "")
                    <a class="nav-link" href="{{ route('atencion-nna') }}/{{ $run }}/{{$caso->cas_id}}">GESTIÓN DE CASOS</a>
                @else
                  <a class="nav-link" href="{{ route('atencion-nna') }}/{{ $run }}/0">GESTIÓN DE CASOS</a>
                @endif
                <!-- INICIO CZ SPRINT  63 -->
                </li>
            @endif

            @if ((Session::get('perfil') == config('constantes.perfil_terapeuta')) || (Session::get('perfil') == config('constantes.perfil_coordinador')) || (Session::get('perfil') == config('constantes.perfil_coordinador_regional')))
            <!-- INICIO CZ SPRINT  63 -->
                <li class="nav-item">
                @if($caso->cas_id != "")
                    <a class="nav-link active show" href="{{ route('gestion-terapia-familiar') }}/{{ $run }}/{{$caso->cas_id}}">TERAPIA FAMILIAR</a>
                    @else
                    <a class="nav-link active show" href="{{ route('gestion-terapia-familiar') }}/{{ $run }}/0">TERAPIA FAMILIAR</a>
                    @endif
                    <!-- FIN CZ SPRINT  63 -->
                </li>
            @endif

            <li class="nav-item">
            <!-- INICIO CZ SPRINT  63 -->
            @if($caso->cas_id != "")
                <a class="nav-link" href="{{ route('historial-nna') }}/{{ $run }}/{{$caso->cas_id}}">HISTORIAL NNA</a>
                @else
                <a class="nav-link" href="{{ route('historial-nna') }}/{{ $run }}/0">HISTORIAL NNA</a>
                @endif
                <!-- FIN CZ SPRINT  63 -->
            </li> 
        </ul>
        <input type="hidden" name="run" id="run" value="{{$run}}">
        <!-- FIN MENU MAIN  -->

          <ul class="nav nav-pills mt-0 p-1 sticky-top" id="myTab" role="tablist">
               <li class="nav-item">
                  <a class="nav-link" id="resumen-tab" data-toggle="tab" href="#resumen" role="tab" aria-controls="resumen" aria-selected="false">Resumen TF<!-- <i class="fa fa-check-circle ml-2 text-light" id="resumen-tab-ico"></i> --></a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" id="invitacion-tab" data-toggle="tab" href="#invitacion" role="tab" aria-controls="invitacion" aria-selected="false">Invitación<!-- <i class="fa fa-check-circle ml-2 text-light" id="diagnostico-tab-ico"></i> --></a>
              </li>
              <li class="nav-item">
                  <a class="nav-link disable-btn-nav-est" id="diagnostico-tab" data-toggle="tab" href="#diagnostico" role="tab" aria-controls="diagnostico" aria-selected="false">Diagnóstico<!-- <i class="fa fa-check-circle ml-2 text-light" id="diagnostico-tab-ico"></i> --></a>
              </li>
              <li class="nav-item">
                  <a class="nav-link disable-btn-nav-est" id="ejecucion-tab" data-toggle="tab" href="#ejecucion" role="tab" aria-controls="ejecucion" aria-selected="false">Ejecución<!-- <i class="fa fa-check-circle ml-2 text-light" id="ejecucion-tab-ico"></i> --></a>
              </li>
              <li class="nav-item">
                  <a class="nav-link disable-btn-nav-est" id="seguimiento-tab" data-toggle="tab" href="#seguimiento" role="tab" aria-controls="seguimiento" aria-selected="false">Seguimiento<!-- <i class="fa fa-check-circle ml-2 text-light" id="seguimiento-tab-ico"></i> --></a>
              </li>
          </ul>

         <!--@ includeif('ficha.cambio_estado_caso_modal')-->

        <div class="card shadow-sm p-4 ">
            <div class="tab-content" id="myTabContent">
            	<!-- INICIO DC -->
				<div id="fechaPlazo"><i style="margin-left:10px" class="far fa-calendar-alt mr-1"></i> Fecha estimada para avanzar de etapa: <span class="txtPlazo"></span></div>
                <!-- FIN DC -->
                <!-- ----------------INVITACION--------------->
                <div class="tab-pane active show fade" id="invitacion" role="tabpanel" aria-labelledby="invitacion-tab">
                    <div class="card p-2 mb-3">
                        <div class="row">
                            <div id="cont_invitacion" class="col-sm-12" ></div>
                        </div>
                    </div>
                </div>
                <!---------------FIN INVITACION--------------->

                <!-- ----------------DIAGNOSTICO-------------->
                <div class="tab-pane fade" id="diagnostico" role="tabpanel" aria-labelledby="diagnostico-tab">
                    <div class="card p-2 mb-3">
                        <div class="row">
                            <div id="cont_diagnostico" class="col-sm-12" ></div>
                        </div>
                    </div>
                </div>
                <!-- --------------FIN DIAGNOSTICO------------>

                <!-- -----------------EJECUCIÓN--------------->
                <div class="tab-pane" id="ejecucion" role="tabpanel" aria-labelledby="ejecucion-tab">
                    <div class="card p-2 mb-3">
                        <div class="row">
                            <div id="cont_ejecucion" class="col-sm-12" ></div>
                        </div>
                    </div>
                </div>
                <!-- ---------------FIN EJECUCIÓN------------->

                <!-- -----------------SEGUIMIENTO------------->
                <div class="tab-pane" id="seguimiento" role="tabpanel" aria-labelledby="seguimiento-tab">
                    <div class="card p-2 mb-3">
                        <div class="row">
                            <div id="cont_seguimiento" class="col-sm-12" ></div>
                        </div>
                    </div>
                </div>
                <!-- ---------------FIN SEGUIMIENTO----------->

                <!-- ------------------RESUMEN---------------->
                <div class="tab-pane" id="resumen" role="tabpanel" aria-labelledby="resumen-tab">
                    <div class="card p-2 mb-3">
                        <div class="row">
                          <div id="cont_resumen" class="col-sm-12" >
                            @includeif('ficha.terapia.gtf_resumen', ['caso_id' => $caso->cas_id])
                          </div>
                        </div>
                    </div>
                </div>
                <!-------------------FIN RESUMEN-------------->

            </div>
        </div>

    </div>
</div>

@includeif('ficha.ncfas_modal_imprimir')

</section>

</main>
<!-- INCLUDE -->
@includeif('ficha.pausas.historial_pausa_modal')
@includeif('ficha.pausas.crear_pausa_modal')

@includeif('ficha.cambio_estado_terapia_modal')
@includeif('ficha.errores_cambio_estado_modal')
@includeif('terapia.terapia_ptf_modal', ['sesiones' => $sesiones])
<!-- // INICIO CZ SPRINT 69 -->
@includeif('ficha.terapia.plan_familiar_2021.modal_plan_familiar_2021', ['sesiones' => $sesiones])
<!-- // INICIO CZ SPRINT 69 -->
<!-- INCLUDE -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="{{ env('APP_URL') }}/js/vis.min.js" type="text/javascript"></script>

<script type="text/javascript">
  $( document ).ready(function(){


    $('#seccion_grupo_familiar_san').collapse({
      show: true
    })

    $('#resumen-tab').on('shown.bs.tab', function (e) {
      network.fit();
    });

    $("#invitacion-tab").attr("onclick", "procesoTerapiaCaso({{ config('constantes.gtf_invitacion')  }}, " + $("#cas_id").val() + ", false);");

    $("#diagnostico-tab").attr("onclick", "procesoTerapiaCaso({{ config('constantes.gtf_diagnostico')  }}, " + $("#cas_id").val() + ", false);");

    $("#ejecucion-tab").attr("onclick", "procesoTerapiaCaso({{ config('constantes.gtf_ejecucion')  }}, " + $("#cas_id").val() + ", false);");

    $("#seguimiento-tab").attr("onclick", "procesoTerapiaCaso({{ config('constantes.gtf_seguimiento')  }}, " + $("#cas_id").val() + ", false);");

      procesoTerapiaCaso($("#est_act_ter").val(), $("#cas_id").val(), true);

    $("#adj_doc").submit(function(e){
        e.preventDefault();
    });

	obtienePlazo();
  });
  //INICIO DC
  function verificaEstadoPlazo(estadoClick){
  	bloquearPantalla();
		let data = new Object();
		data.idTera = $("#tera_id").val();
		$.ajax({
            type: "GET",
            url: "{{route('get.estadoTera')}}",
            data: data
        }).done(function(resp){
        	desbloquearPantalla();
            var estadoActual = JSON.parse(resp);
            if(estadoActual[0].est_tera_id == estadoClick){
                	$('#fechaPlazo').fadeIn(0);
                }else{
                	$('#fechaPlazo').fadeOut(0);
                }
        }).fail(function(objeto, tipoError, errorHttp){  
           desbloquearPantalla();
           manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
           return false;
        });
  }
  
  function obtienePlazo(){
		let data = new Object();
		data.pro_an_id 	= $("#tera_id").val();
		data.tipo = 2;
		$.ajax({
            type: "GET",
            url: "{{route('get.plazo')}}",
            data: data
        }).done(function(resp){
            var plazo = JSON.parse(resp);
            if(plazo.plazo != null){
            	$('.txtPlazo').html(plazo.plazo);
            }            
        }).fail(function(objeto, tipoError, errorHttp){  
           desbloquearPantalla();
           manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
           return false;
        });
	}
	//FIN DC
  
  function obtienePlazo(){
		let data = new Object();
		data.pro_an_id 	= $("#tera_id").val();
		data.tipo = 2;
		$.ajax({
            type: "GET",
            url: "{{route('get.plazo')}}",
            data: data
        }).done(function(resp){
            var plazo = JSON.parse(resp);
            if(plazo.plazo != null){
            	$('.txtPlazo').html(plazo.plazo);
            }            
        }).fail(function(objeto, tipoError, errorHttp){  
           desbloquearPantalla();
           manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
           return false;
        });
	}

  contenido_textarea_bit_invitacion = ""; 
  function valTextAreaBitInvitacion(){
      num_caracteres_permitidos   = 1000;

      num_caracteres = $("#bitacora_estado_gtf-invitacion").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#bitacora_estado_gtf-invitacion").val(contenido_textarea_bit_invitacion);

       }else{ 
          contenido_textarea_bit_invitacion = $("#bitacora_estado_gtf-invitacion").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_bit_invitacion").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_bit_invitacion").css("color", "#000000");

       } 

       $("#cant_carac_bit_invitacion").text($("#bitacora_estado_gtf-invitacion").val().length);
   }


  contenido_textarea_bit_diagnostico = ""; 
  function valTextAreaBitDiagnostico(){
      num_caracteres_permitidos   = 1000;

      num_caracteres = $("#bitacora_estado_gtf-diagnostico").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#bitacora_estado_gtf-diagnostico").val(contenido_textarea_bit_diagnostico);

       }else{ 
          contenido_textarea_bit_diagnostico = $("#bitacora_estado_gtf-diagnostico").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_bit_diagnostico").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_bit_diagnostico").css("color", "#000000");

       } 

       $("#cant_carac_bit_diagnostico").text($("#bitacora_estado_gtf-diagnostico").val().length);
   }


  contenido_textarea_bit_ejecucion = ""; 
  function valTextAreaBitEjecucion(){
      num_caracteres_permitidos   = 1000;

      num_caracteres = $("#bitacora_estado_gtf-ejecucion").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#bitacora_estado_gtf-ejecucion").val(contenido_textarea_bit_ejecucion);

       }else{ 
          contenido_textarea_bit_ejecucion = $("#bitacora_estado_gtf-ejecucion").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_bit_ejecucion").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_bit_ejecucion").css("color", "#000000");

       } 

       $("#cant_carac_bit_ejecucion").text($("#bitacora_estado_gtf-ejecucion").val().length);
   }

  contenido_textarea_bit_seguimiento = ""; 
  function valTextAreaBitSeguimiento(){
      num_caracteres_permitidos   = 1000;

      num_caracteres = $("#bitacora_estado_gtf-seguimiento").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#bitacora_estado_gtf-seguimiento").val(contenido_textarea_bit_seguimiento);

       }else{ 
          contenido_textarea_bit_seguimiento = $("#bitacora_estado_gtf-seguimiento").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_bit_seguimiento").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_bit_seguimiento").css("color", "#000000");

       } 

       $("#cant_carac_bit_seguimiento").text($("#bitacora_estado_gtf-seguimiento").val().length);
   }

 function procesoTerapiaCaso(option = null, valor = null, cargaInicial){
 	//INICIO DC
	obtienePlazo();
	verificaEstadoPlazo(option);
	//FIN DC
    if (option == "" || typeof option == "undefined" ||
    valor == "" || typeof valor == "undefined") return false;

    let data = new Object();
    let estado_actual = $("#est_act_ter").val();

    if (estado_actual == {{config('constantes.gtf_invitacion')}}){ 
        $("#diagnostico-tab").addClass("disabled", true);
        $("#ejecucion-tab").addClass("disabled", true);
        $("#seguimiento-tab").addClass("disabled", true);
    }

    if (estado_actual == {{config('constantes.gtf_diagnostico')}}){ 
        $("#ejecucion-tab").addClass("disabled", true);
        $("#seguimiento-tab").addClass("disabled", true);
    }

    if (estado_actual == {{config('constantes.gtf_ejecucion')}}){ 
        $("#seguimiento-tab").addClass("disabled", true);
    }

    option =  parseInt(option);
    data.option     = option;
    data.cas_id     = valor;
    data.run        = $("#run").val();

    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}});

    $.ajax({
      url: "{{ route('proceso.terapia.caso') }}",
      type: "GET",
      data: data,
      timeout: 8000
    }).done(function(resp){
          switch (option) {
            case {{ config('constantes.gtf_invitacion')  }}: // BOTON INVITACION
              $("#ejecucion-tab").removeClass("active show");
              $("#diagnostico-tab").removeClass("active show");
              $("#resumen-tab").removeClass("active show");
              $("#seguimiento-tab").removeClass("active show");

            $( "#cont_invitacion" ).html(resp.html);
            $("#invitacion-tab").addClass("active show");

            if (estado_actual == {{config('constantes.gtf_invitacion')}}){

                $("#diagnostico-tab").attr("disabled", true);
               
            } else {

                $("#btn-etapa-invitacion").attr("disabled", true);

                //$("#btn_dest_invit").attr("disabled", true);
            }


            //$("#invitacion-tab").attr("onclick", "procesoTerapiaCaso({{ config('constantes.gtf_invitacion')  }}, " + valor + ", false);");
            break;

            case {{ config('constantes.gtf_diagnostico')  }}: // BOTON DIAGNOSTICO

              $("#invitacion").removeClass("active show");

              $("#diagnostico-tab").addClass("active show");
              $("#diagnostico").addClass("active show");  

              $("#resumen-tab").removeClass("active show");
              $("#invitacion-tab").removeClass("active show");
              $("#ejecucion-tab").removeClass("active show");
              $("#seguimiento-tab").removeClass("active show");

              $("#cont_diagnostico").html(resp.html);

              $("#diagnostico-tab").removeClass("disable-btn-nav-est");


              //$("#invitacion-tab").attr("onclick", "procesoTerapiaCaso({{ config('constantes.gtf_invitacion')  }}, " + valor + ", false);");

              //$("#diagnostico-tab").attr("onclick", "procesoTerapiaCaso({{ config('constantes.gtf_diagnostico')  }}, " + valor + ", false);");

              if (estado_actual != {{config('constantes.gtf_diagnostico')}}){
                $("#btn-etapa-diagnostico").attr("disabled", true);
              }
    
            break;

            case {{ config('constantes.gtf_ejecucion')  }}: // BOTON EJECUCION

              $("#invitacion").removeClass("active show");
              $("#diagnostico").removeClass("active show");

              $("#ejecucion-tab").addClass("active show");
              $("#ejecucion").addClass("active show");  

              $("#invitacion-tab").removeClass("active show");
              $("#diagnostico-tab").removeClass("active show");
              $("#resumen-tab").removeClass("active show");
              $("#seguimiento-tab").removeClass("active show");

              $("#cont_ejecucion").html(resp.html);

              $("#diagnostico-tab").removeClass("disable-btn-nav-est");
              $("#ejecucion-tab").removeClass("disable-btn-nav-est");

              if (estado_actual != {{config('constantes.gtf_ejecucion')}}){
                $("#btn-etapa-ejecucion").attr("disabled", true);
              }
    
            break;

            case {{ config('constantes.gtf_seguimiento')  }}: // BOTON SEGUIMENTO
              $("#invitacion").removeClass("active show");
              $("#diagnostico").removeClass("active show");
              $("#ejecucion").removeClass("active show");

              $("#seguimiento-tab").addClass("active show");
              $("#seguimiento").addClass("active show");  

              $("#resumen-tab").removeClass("active show");
              $("#invitacion-tab").removeClass("active show");
              $("#diagnostico-tab").removeClass("active show");
              $("#ejecucion-tab").removeClass("active show");

              $("#cont_seguimiento").html(resp.html);

              $("#diagnostico-tab").removeClass("disable-btn-nav-est");
              $("#seguimiento-tab").removeClass("disable-btn-nav-est");
              $("#ejecucion-tab").removeClass("disable-btn-nav-est");
    

              if (estado_actual != {{config('constantes.gtf_seguimiento')}}){
                $("#btn-etapa-seguimiento").attr("disabled", true);
              }

            break;

            case {{ config('constantes.gtf_egreso')  }}: // BOTON EGRESO

              $("#invitacion").removeClass("active show");
              $("#diagnostico").removeClass("active show");
              $("#ejecucion").removeClass("active show");
              $("#resumen-tab").removeClass("active show");
              $("#invitacion-tab").removeClass("active show");
              $("#diagnostico-tab").removeClass("active show");
              $("#ejecucion-tab").removeClass("active show");

              $("#diagnostico-tab").removeClass("disable-btn-nav-est");
              $("#seguimiento-tab").removeClass("disable-btn-nav-est");
              $("#ejecucion-tab").removeClass("disable-btn-nav-est");

              //$(".btnRechEst").attr("disabled", "true");


            break;

           default:

              $("#invitacion").removeClass("active show");
              $("#diagnostico").removeClass("active show");
              $("#ejecucion").removeClass("active show");
              $("#seguimiento").removeClass("active show");
              $("#invitacion-tab").removeClass("active show");
              $("#diagnostico-tab").removeClass("active show");
              $("#ejecucion-tab").removeClass("active show");
              $("#seguimiento-tab").removeClass("active show");

              $("#diagnostico-tab").removeClass("disable-btn-nav-est");
              $("#ejecucion-tab").removeClass("disable-btn-nav-est");

              //$("#invitacion-tab").attr("onclick", "procesoTerapiaCaso({{ config('constantes.gtf_invitacion')  }}, " + valor + ", false);");

              //$("#diagnostico-tab").attr("onclick", "procesoTerapiaCaso({{ config('constantes.gtf_diagnostico')  }}, " + valor + ", false);");

              $("#resumen-tab").click();
              //$("#resumen-tab").addClass("active show");
              //$("#resumen").addClass("active show");  

              //$("#resumen-tab").removeClass("disabled"); 

              //$("#cont_resumen").html(resp.html);


            break;

            // case {{ config('constantes.gtf_ejecucion')  }}: // BOTON EJECUCION 
            // $( "#cont_ejecucion" ).html(resp.html);
            // $("#ejecucion-tab").addClass("active show");

            // $("#ejecucion-tab").attr("onclick", "procesoTerapiaCaso({{ config('constantes.gtf_invitacion')  }}, " + valor + ", false);");

            // $("#diagnostico-tab").attr("onclick", "procesoTerapiaCaso({{ config('constantes.gtf_diagnostico')  }}, " + valor + ", false);");

            // $("#invitacion-tab").attr("onclick", "procesoTerapiaCaso({{ config('constantes.gtf_invitacion')  }}, " + valor + ", false);");
            // // }
            // break;
         
      }

      if (cargaInicial) {
        $("#invitacion").removeClass("active show");
        $("#diagnostico").removeClass("active show");
        $("#ejecucion").removeClass("active show");
        $("#seguimiento").removeClass("active show");
        $("#invitacion-tab").removeClass("active show");
        $("#diagnostico-tab").removeClass("active show");
        $("#ejecucion-tab").removeClass("active show");
        $("#seguimiento-tab").removeClass("active show");
        $("#resumen-tab").click();
      }

    }).fail(function(obj){
       alert("Hubo un error al momento de cargar la información de la ventana. Por favor intente nuevamente.");
       console.log(obj); return false;
    });
  }

   function valTextAreaCambioEstadoRechazo(){
      num_caracteres_permitidos   = 500;

      num_caracteres = $("#comentario_estado_terapia").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#comentario_estado_terapia").val(contenido_textarea_rechazo_estados);

       }else{ 
          contenido_textarea_rechazo_estados = $("#comentario_estado_terapia").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_cam_est").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_cam_est").css("color", "#000000");

       } 

      
       $("#cant_carac_cam_est").text($("#comentario_estado_terapia").val().length);
   }
   // INICIO CZ SPRINT 69 -->
   function terapiaPtf_2021(terapia){
    let data2 = new Object();
    data2.cas_id = $("#cas_id").val();
    data2.terapia = terapia; 
          $.ajax({
                type: "GET",
                url: "{{route('listar.datos.sesiones_2021')}}",
                data: data2
              }).done(function(resp){
                $('#sesiones_realizadas_2021').html(resp['sesiones_realizadas']);
                $('#sesiones_comprometidas_2021').html(resp['sesiones_comprometidas']);
                $('#porcentaje_logro_2021').html(resp['porcentaje_logro']+'%');
                
                //inicio ch
                let a = $('#sesiones_realizadas_2021').text();
                let b = $('#sesiones_comprometidas_2021').text();
                if (a > b) {
                  $('#porcentaje_logro_2021').html('100%');
                }
                //fin
              }).fail(function(objeto, tipoError, errorHttp){
                  desbloquearPantalla();
                          manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
                          return false;
                  });
          //inicio ch
          $.ajax({
                type: "GET",
                url: "{{route('listar.datos.sesionesfm_2021')}}",
                data: data2
              }).done(function(resp){
                $('#sesiones_realizadas2_2021').html(resp['sesiones_realizadas2']);
                $('#sesiones_comprometidas2_2021').html(resp['sesiones_comprometidas2']);
                $('#porcentaje_logro2_2021').html(resp['porcentaje_logro2']+'%');
                
                
              }).fail(function(objeto, tipoError, errorHttp){
                  desbloquearPantalla();
                          manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
                          return false;
                  });
    let data = new Object();

    data.tera_id = terapia;

    var tabla_ptf_sesion = $('#tabla_ptf_2021').DataTable();
    tabla_ptf_sesion.destroy();

    var tabla_ptf_sesion = $('#tabla_ptf_2021').DataTable({
      "dom": '<lf<t>ip>',
      "language"  : { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
      "processing": true,
      "serverSide": false,
      "paging"    : false,
      "ordering"  : false,
      "searching" : false,
      "info"    : false,
      "ajax"    : 
        { 
          "url" : "{{ route('terapia.listarPtfSesion_2021') }}", 
          "type": "GET",
          "data": data  
        },
        "columnDefs": [
        @if ($modo_visualizacion == 'edicion')
          {
            "targets":    7, //Acciones
            "width":      "10%",
            "className":  'dt-head-center dt-body-center',
            "createdCell": function (td, cellData, rowData, row, col) {
                  $(td).css("vertical-align", "middle");
               
              }
          }
        @endif
      ],
        "columns":[
        {
          "data":     "tituloagrupacion",
          "name":     "tituloagrupacion"
        },
        {
          "data":     "ptf_numero",
          "name":     "ptf_numero",
          "width":    "10%"
        }, 
        {                                   
          "data":     "ptf_objetivo",
          "name":     "ptf_objetivo",
          "width":    "20%",
          "render" : function (data, type, row){
            let input = row.ptf_objetivo;
            var fields = input.split('•');
            html = "<ul>";
            let i=0;
            fields.forEach(function(element) {
              html = html + "<li>";
              html = html + fields[i];
              html = html + "</li>";
              i++;
            });
            html = html + "</ul>";
            return html;
          }
        },  
        {
          "data": "", 
          "className": "text-center",
          "width":    "15%",
          "render" : function (data, type, row){
            let html = "";
            let ptf_det_resultado = "";

            if(row.ptf_det_resultado) ptf_det_resultado = row.ptf_det_resultado;
            
            @if ($modo_visualizacion == 'visualizacion')
              if (ptf_det_resultado == "") ptf_det_resultado = "Sin información";

              html = "<p>"+ptf_det_resultado+"</p>";    

            @elseif($modo_visualizacion == 'edicion')
              // html = "<textarea maxlength=1000 onkeypress='return caracteres_especiales(event)' onBlur='guardarPtf("+terapia+","+row.ptf_id+",$(this).val(),2);' class='form-control ' rows='3' id='resultado_sesion_"+row.ptf_id+"' name='resultado_sesion_"+row.ptf_id+"'>"+ptf_det_resultado+"</textarea>";
              
              if(row.ptf_id == 16 || row.ptf_id == 19 || row.ptf_id == 22){
                html = "<textarea maxlength=1000 onkeypress='return caracteres_especiales(event)' onBlur='HabilitarGuardarPTF_2021("+terapia+","+row.ptf_id+", 2);' class='form-control ' rows='3' id='resultado_taller_"+row.ptf_id+"' name='resultado_taller_"+row.ptf_id+"'>"+ptf_det_resultado+"</textarea>";

              }else{
                html = "<textarea maxlength=1000 onkeypress='return caracteres_especiales(event)' onBlur='HabilitarGuardarPTF_2021("+terapia+","+row.ptf_id+", 1);' class='form-control ' rows='3' id='resultado_sesion_"+row.ptf_id+"' name='resultado_sesion_"+row.ptf_id+"'>"+ptf_det_resultado+"</textarea>";


              }
              
            @endif

              
            return html;
          }
        },
        {
          "data": "", 
          "className": "text-center",
          "width":    "15%",
          "render" : function (data, type, row){
            let html = "";
            let ptf_det_observacion = "";

            if(row.ptf_det_observacion) ptf_det_observacion = row.ptf_det_observacion;
            
            @if ($modo_visualizacion == 'visualizacion')
              if (ptf_det_observacion == "") ptf_det_observacion = "Sin información";

              html = "<p>"+ptf_det_observacion+"</p>";

            @elseif($modo_visualizacion == 'edicion')
              // html = "<textarea maxlength=1000 onkeypress='return caracteres_especiales(event)' onBlur='guardarPtf("+terapia+","+row.ptf_id+",$(this).val(),3);' class='form-control ' rows='3' id='observacion_sesion_"+row.ptf_id+"' name='observacion_sesion_"+row.ptf_id+"'>"+ptf_det_observacion+"</textarea>";
              if(row.ptf_id == 16 || row.ptf_id == 19 || row.ptf_id == 22){
                html = "<textarea maxlength=1000 onkeypress='return caracteres_especiales(event)' onBlur='HabilitarGuardarPTF_2021("+terapia+","+row.ptf_id+", 2);' class='form-control ' rows='3' id='observacion_taller_"+row.ptf_id+"' name='observacion_taller_"+row.ptf_id+"'>"+ptf_det_observacion+"</textarea>";

            }else{
              html = "<textarea maxlength=1000 onkeypress='return caracteres_especiales(event)' onBlur='HabilitarGuardarPTF_2021("+terapia+","+row.ptf_id+", 1);' class='form-control ' rows='3' id='observacion_sesion_"+row.ptf_id+"' name='observacion_sesion_"+row.ptf_id+"'>"+ptf_det_observacion+"</textarea>";


            }
              

            @endif
            
            return html;
          }
        },
        {
          "data": "", 
          "className": "text-center",
          "width":    "10%",
          "render" : function (data, type, row){
            let html = "";
            let ptf_det_fecha = "";

            if(row.ptf_det_fecha){
              ptf_det_fecha = row.ptf_det_fecha;
              var todayTime = new Date(ptf_det_fecha);
              var month = todayTime .getMonth() + 1;
              var day = todayTime .getDate();
              var year = todayTime .getFullYear();
              ptf_det_fecha=day + "/" + month + "/" + year;
            }

            @if ($modo_visualizacion == 'visualizacion')
              if (ptf_det_fecha == "") ptf_det_fecha = "Sin información";

              html = "<p>"+ptf_det_fecha+"</p>";

            @elseif ($modo_visualizacion == 'edicion')
            if(row.ptf_id == 16 || row.ptf_id == 19 || row.ptf_id == 22){
              html="<div class='input-group date-pick' id='fecha_sesion_"+row.ptf_id+"'      data-target-input='nearest'><input onkeypress='return caracteres_especiales_fecha(event)' type='text' name='fecha_sesion_name_"+row.ptf_id+"' class='form-control datetimepicker-input '  data-target='#fecha_sesion_"+row.ptf_id+"' id='fecha_sesion_id_"+row.ptf_id+"' onBlur='HabilitarGuardarPTF_2021("+terapia+", "+row.ptf_id+", 2);' value='"+ptf_det_fecha+"'><div class='input-group-append' data-target='#fecha_sesion_"+row.ptf_id+"' data-toggle='datetimepicker'><div class='input-group-text'><i class='fa fa-calendar'></i></div></div></div>";

            }else{
              html="<div class='input-group date-pick' id='fecha_sesion_"+row.ptf_id+"'      data-target-input='nearest'><input onkeypress='return caracteres_especiales_fecha(event)' type='text' name='fecha_sesion_name_"+row.ptf_id+"' class='form-control datetimepicker-input '  data-target='#fecha_sesion_"+row.ptf_id+"' id='fecha_sesion_id_"+row.ptf_id+"' onBlur='HabilitarGuardarPTF_2021("+terapia+", "+row.ptf_id+", 1);' value='"+ptf_det_fecha+"'><div class='input-group-append' data-target='#fecha_sesion_"+row.ptf_id+"' data-toggle='datetimepicker'><div class='input-group-text'><i class='fa fa-calendar'></i></div></div></div>";

            }
            @endif

            return html;
          }
        },
        {
          "data": "", 
          "className": "text-center",
          "width":    "11%",
          "render" : function (data, type, row){
            let html = "";
            @if ($modo_visualizacion == 'edicion')
            var x  = "";
            if(row.ptf_id == 16 || row.ptf_id == 19 || row.ptf_id == 22){
              x  = "onclick='HabilitarGuardarPTF_2021("+terapia+", "+row.ptf_id+", 2);'";
            }else{
              x = "onclick='HabilitarGuardarPTF_2021("+terapia+", "+row.ptf_id+", 1);'";
            }
            html +='<select class="form-control" id="id_estado_'+row.ptf_id+'" name="id_estado" '+x+'><option value="">Seleccione Estado</option>';
            if(row.ptf_estado == "1"){
              html += '<option value="1" selected="selected">Realizado</option>';
              html += '<option value="2">No Realizado</option>';
              html += '<option value="3">No Aplica</option></select>';
            }else if(row.ptf_estado == "2"){
              html += '<option value="1">Realizado</option>';
              html += '<option value="2" selected="selected">No Realizado</option>';
              html += '<option value="3">No Aplica</option></select>';
            }else if(row.ptf_estado == "3"){
              html += '<option value="1">Realizado</option>';
              html += '<option value="2">No Realizado</option>';
              html += '<option value="3" selected="selected">No Aplica</option></select>';
            }else{
              html += '<option value="1">Realizado</option>';
              html += '<option value="2">No Realizado</option>';
              html += '<option value="3">No Aplica</option></select>';
            }
            @else
            if(row.ptf_estado  == "1"){
              html += "<p>Realizado</p>";
            }else if(row.ptf_estado  == "2"){
              html += "<p>No Realizado</p>";
            }else if(row.ptf_estado  == "3"){
              html += "<p>No Aplica</p>";
            //INICIO CZ SPRINT 69 
            }else{
              html += "Sin Información";
            }
            // FIN CZ SPRINT 69

            @endif
            return html;
          }
        },
        @if ($modo_visualizacion == 'edicion')
          {
            "data": "",
            "render" : function (data, type, row){
              let html = '<button type="button" class="btn btn-success" id="btn_guardar_ptf_'+row.ptf_id+'" disabled="true">Guardar</button>';

              return html;
            }
          }
        @endif
        ],
        'rowsGroup': [0],
        "fnDrawCallback":function(){ 
        $('.date-pick').datetimepicker({
          format: 'DD/MM/Y'
        });
        $('[data-toggle="popover"]').popover();
      }
      });
    $('#plan_familiar_2021').modal('show');
   }
    // FIN CZ SPRINT 69 
   function terapiaPtf(terapia){
   				let data2 = new Object();
    			data2.cas_id = $("#cas_id").val();
    			data2.terapia = terapia; 
                $.ajax({
                			type: "GET",
                			url: "{{route('listar.datos.sesiones')}}",
                			data: data2
                		}).done(function(resp){
                      console.log(resp);
                			$('#sesiones_realizadas').html(resp['sesiones_realizadas']);
                			$('#sesiones_comprometidas').html(resp['sesiones_comprometidas']);
                			$('#porcentaje_logro').html(resp['porcentaje_logro']+'%');
                			
                      //inicio ch
                      let a = $('#sesiones_realizadas').text();
                      let b = $('#sesiones_comprometidas').text();
                			if (a > b) {
                        $('#porcentaje_logro').html('100%');
                      }
                			//fin
                		}).fail(function(objeto, tipoError, errorHttp){
                				desbloquearPantalla();
                                manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
                                return false;
                        });
                //inicio ch
                $.ajax({
                			type: "GET",
                			url: "{{route('listar.datos.sesionesfm')}}",
                			data: data2
                		}).done(function(resp){
                			$('#sesiones_realizadas2').html(resp['sesiones_realizadas2']);
                			$('#sesiones_comprometidas2').html(resp['sesiones_comprometidas2']);
                			$('#porcentaje_logro2').html(resp['porcentaje_logro2']+'%');
                			
                			
                		}).fail(function(objeto, tipoError, errorHttp){
                				desbloquearPantalla();
                                manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
                                return false;
                        });
                        //fin ch

  if (typeof terapia == "undefined" || terapia == "") return false;

    let data = new Object();

    data.tera_id = terapia;

    var tabla_ptf_sesion = $('#tabla_ptf_sesion').DataTable();
    tabla_ptf_sesion.destroy();

    var tabla_ptf_taller = $('#tabla_ptf_taller').DataTable();
    tabla_ptf_taller.destroy();

    var tabla_ptf_sesion = $('#tabla_ptf_sesion').DataTable({
      "dom": '<lf<t>ip>',
      "language"  : { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
      "processing": true,
      "serverSide": false,
      "paging"    : false,
      "ordering"  : false,
      "searching" : false,
      "info"    : false,
      "ajax"    : 
        { 
          "url" : "{{ route('terapia.listarPtfSesion') }}", 
          "type": "GET",
          "data": data  
        },
      "columnDefs": [
        {
          "targets":    0, //ID
          "visible":    false,
          "className":  'dt-head-center dt-body-left',
          "createdCell": function (td, cellData, rowData, row, col) {
                $(td).css("vertical-align", "middle");
             
            }
        },
        {
          "targets":    1, //Sesion
          "width":    "10%",
          "className":  'dt-head-center dt-body-center',
          "createdCell": function (td, cellData, rowData, row, col){
                $(td).css("vertical-align", "middle");
             
            }
        },
        {
          "targets":    2, //Actividad
          "visible":    false,
          "className":  'dt-head-center dt-body-left',
          "createdCell": function (td, cellData, rowData, row, col){
                $(td).css("vertical-align", "middle");

            }
        },
        {
          "targets":    3, //Objetivo
          "width":      "20%",
          "className":  'dt-head-center dt-body-left',
          "createdCell": function (td, cellData, rowData, row, col){
                $(td).css("vertical-align", "middle");

            }
        },
        {
          "targets":    4, //Meta
          "width":      "15%",
          "className":  'dt-head-center dt-body-left',
          "createdCell": function (td, cellData, rowData, row, col){
                $(td).css("vertical-align", "middle");

            }
        },
        {
          "targets":    5, //Estrategia
          "width":      "15%",
          "className":  'dt-head-center dt-body-left',
          "createdCell": function (td, cellData, rowData, row, col) {
                $(td).css("vertical-align", "middle");
                $(td).css("word-break", "break-word");
             
            }
        },
        {
          "targets":    6, //Resultado
          "width":      "15%",
          "className":  'dt-head-center dt-body-left',
          "createdCell": function (td, cellData, rowData, row, col) {
                $(td).css("vertical-align", "middle");
                $(td).css("word-break", "break-word");
             
            }
        },
        {
          "targets":    7, //Observaciones
          "width":      "15%",
          "className":  'dt-head-center dt-body-left',
          "createdCell": function (td, cellData, rowData, row, col) {
                $(td).css("vertical-align", "middle");
                $(td).css("word-break", "break-word");
             
            }
        },
        {
          "targets":    8, //Fecha
          "width":      "10%",
          "className":  'dt-head-center dt-body-center',
          "createdCell": function (td, cellData, rowData, row, col) {
                $(td).css("vertical-align", "middle");
             
            }
        },
        @if ($modo_visualizacion == 'edicion')
          {
            "targets":    9, //Acciones
            "width":      "10%",
            "className":  'dt-head-center dt-body-center',
            "createdCell": function (td, cellData, rowData, row, col) {
                  $(td).css("vertical-align", "middle");
               
              }
          }
        @endif
      ],  
      "columns":[
        {
          "data":     "ptf_id",
          "name":     "ptf_id"
        },

        {
          "data":     "ptf_numero",
          "name":     "ptf_numero",
          "width":    "10%"
        }, 
        {                                   
          "data":     "ptf_actividad",
          "name":     "ptf_actividad"
        },  
        {                                   
          "data":     "ptf_objetivo",
          "name":     "ptf_objetivo",
          "width":    "20%"
        },  
        {
          "data": "ptf_meta", 
          "width": "15%",
          "render" : function (data, type, row){
            let input = row.ptf_meta;
            var fields = input.split('|');
            html = "<ul>";
            let i=0;
            fields.forEach(function(element) {
              html = html + "<li>";
              html = html + fields[i];
              html = html + "</li>";
              i++;
            });
            html = html + "</ul>";
            return html;
          }
        }, 
        {
          "data": "", 
          "className": "text-center",
          "width":    "15%",
          "render" : function (data, type, row){
            let html = "";
            let ptf_det_estrategia = "";

            if(row.ptf_det_estrategia) ptf_det_estrategia = row.ptf_det_estrategia;
            
            @if ($modo_visualizacion == 'visualizacion')
              if (ptf_det_estrategia == "") ptf_det_estrategia = "Sin información";

              html = "<p>"+ptf_det_estrategia+"</p>";

            @elseif($modo_visualizacion == 'edicion')
              // html = "<textarea maxlength=1000 onkeypress='return caracteres_especiales(event)' onBlur='guardarPtf("+terapia+","+row.ptf_id+",$(this).val(),1);' class='form-control ' rows='3' id='estrategia_sesion_"+row.ptf_id+"' name='estrategia_sesion_"+row.ptf_id+"'>"+ptf_det_estrategia+"</textarea>";
              
              html = "<textarea maxlength=1000 onkeypress='return caracteres_especiales(event)' onBlur='HabilitarGuardarPTF("+terapia+","+row.ptf_id+", 1);' class='form-control ' rows='3' id='estrategia_sesion_"+row.ptf_id+"' name='estrategia_sesion_"+row.ptf_id+"'>"+ptf_det_estrategia+"</textarea>";

            @endif

            return html;
          }
        },
        {
          "data": "", 
          "className": "text-center",
          "width":    "15%",
          "render" : function (data, type, row){
            let html = "";
            let ptf_det_resultado = "";

            if(row.ptf_det_resultado) ptf_det_resultado = row.ptf_det_resultado;
            
            @if ($modo_visualizacion == 'visualizacion')
              if (ptf_det_resultado == "") ptf_det_resultado = "Sin información";

              html = "<p>"+ptf_det_resultado+"</p>";    

            @elseif($modo_visualizacion == 'edicion')
              // html = "<textarea maxlength=1000 onkeypress='return caracteres_especiales(event)' onBlur='guardarPtf("+terapia+","+row.ptf_id+",$(this).val(),2);' class='form-control ' rows='3' id='resultado_sesion_"+row.ptf_id+"' name='resultado_sesion_"+row.ptf_id+"'>"+ptf_det_resultado+"</textarea>";
              
              html = "<textarea maxlength=1000 onkeypress='return caracteres_especiales(event)' onBlur='HabilitarGuardarPTF("+terapia+","+row.ptf_id+", 1);' class='form-control ' rows='3' id='resultado_sesion_"+row.ptf_id+"' name='resultado_sesion_"+row.ptf_id+"'>"+ptf_det_resultado+"</textarea>";

            @endif

              
            return html;
          }
        },
        {
          "data": "", 
          "className": "text-center",
          "width":    "15%",
          "render" : function (data, type, row){
            let html = "";
            let ptf_det_observacion = "";

            if(row.ptf_det_observacion) ptf_det_observacion = row.ptf_det_observacion;
            
            @if ($modo_visualizacion == 'visualizacion')
              if (ptf_det_observacion == "") ptf_det_observacion = "Sin información";

              html = "<p>"+ptf_det_observacion+"</p>";

            @elseif($modo_visualizacion == 'edicion')
              // html = "<textarea maxlength=1000 onkeypress='return caracteres_especiales(event)' onBlur='guardarPtf("+terapia+","+row.ptf_id+",$(this).val(),3);' class='form-control ' rows='3' id='observacion_sesion_"+row.ptf_id+"' name='observacion_sesion_"+row.ptf_id+"'>"+ptf_det_observacion+"</textarea>";
              
              html = "<textarea maxlength=1000 onkeypress='return caracteres_especiales(event)' onBlur='HabilitarGuardarPTF("+terapia+","+row.ptf_id+", 1);' class='form-control ' rows='3' id='observacion_sesion_"+row.ptf_id+"' name='observacion_sesion_"+row.ptf_id+"'>"+ptf_det_observacion+"</textarea>";


            @endif
            
            return html;
          }
        },
        {
          "data": "", 
          "className": "text-center",
          "width":    "10%",
          "render" : function (data, type, row){
            let html = "";
            let ptf_det_fecha = "";

            if(row.ptf_det_fecha){
              ptf_det_fecha = row.ptf_det_fecha;
              var todayTime = new Date(ptf_det_fecha);
              var month = todayTime .getMonth() + 1;
              var day = todayTime .getDate();
              var year = todayTime .getFullYear();
              ptf_det_fecha=day + "/" + month + "/" + year;
            }

            @if ($modo_visualizacion == 'visualizacion')
              if (ptf_det_fecha == "") ptf_det_fecha = "Sin información";

              html = "<p>"+ptf_det_fecha+"</p>";

            @elseif ($modo_visualizacion == 'edicion')
              html="<div class='input-group date-pick' id='fecha_sesion_"+row.ptf_id+"'      data-target-input='nearest'><input onkeypress='return caracteres_especiales_fecha(event)' type='text' name='fecha_sesion_name_"+row.ptf_id+"' class='form-control datetimepicker-input '  data-target='#fecha_sesion_"+row.ptf_id+"' id='fecha_sesion_id_"+row.ptf_id+"' onBlur='HabilitarGuardarPTF("+terapia+", "+row.ptf_id+", 1);' value='"+ptf_det_fecha+"'><div class='input-group-append' data-target='#fecha_sesion_"+row.ptf_id+"' data-toggle='datetimepicker'><div class='input-group-text'><i class='fa fa-calendar'></i></div></div></div>";

            @endif

            return html;
          }
        },
        @if ($modo_visualizacion == 'edicion')
          {
            "data": "",
            "render" : function (data, type, row){
              let html = '<button type="button" class="btn btn-success" id="btn_guardar_ptf_'+row.ptf_id+'" disabled="true">Guardar</button>';

              return html;
            }
          }
        @endif
      ],
      "fnDrawCallback":function(){ 
        $('.date-pick').datetimepicker({
          format: 'DD/MM/Y'
        });
        $('[data-toggle="popover"]').popover();
      }
    });


    var tabla_ptf_taller = $('#tabla_ptf_taller').DataTable({
      "dom": '<lf<t>ip>',
      "language"  : { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
      "processing": true,
      "serverSide": false,
      "paging"    : false,
      "ordering"  : false,
      "searching" : false,
      "info"    : false,
      "ajax"    : 
        { 
          "url" : "{{ route('terapia.listarPtfTaller') }}", 
          "type": "GET",  
          "data": data ,
        },
      "columnDefs": [
        {
          "targets":    0, //ID
          "visible":    false,
          "className":  'dt-head-center dt-body-center',
          "createdCell": function (td, cellData, rowData, row, col){
                $(td).css("vertical-align", "middle");
             
          }
        },
        {
          "targets":    1, //N° Sesión
          "width":    "10%",
          "className":  'dt-head-center dt-body-center',
          "createdCell": function (td, cellData, rowData, row, col){
                $(td).css("vertical-align", "middle");
             
          }
        },
        {
          "targets":    2, //Actividad
          "visible":    false,
          "className":  'dt-head-center dt-body-left',
          "createdCell": function (td, cellData, rowData, row, col){
                $(td).css("vertical-align", "middle");
             
          }
        },
        {
          "targets":    3, //Objetivo
          "width":      "15%",
          "className":  'dt-head-center dt-body-left',
          "createdCell": function (td, cellData, rowData, row, col){
                $(td).css("vertical-align", "middle");
             
          }
        },
        {
          "targets":    4, //Meta
          "width":      "20%",
          "className":  'dt-head-center dt-body-left',
          "createdCell": function (td, cellData, rowData, row, col){
                $(td).css("vertical-align", "middle");
             
          }
        },
        {
          "targets":    5, //Estrategia
          "width":      "15%",
          "className":  'dt-head-center dt-body-left',
          "createdCell": function (td, cellData, rowData, row, col){
                $(td).css("vertical-align", "middle");
                $(td).css("word-break", "break-word");
             
          }
        },
        {
          "targets":    6, //Resultado
          "width":      "15%",
          "className":  'dt-head-center dt-body-left',
          "createdCell": function (td, cellData, rowData, row, col){
                $(td).css("vertical-align", "middle");
                $(td).css("word-break", "break-word");
             
          }
        },
        {
          "targets":    7, //Observaciones
          "width":      "15%",
          "className":  'dt-head-center dt-body-left',
          "createdCell": function (td, cellData, rowData, row, col){
                $(td).css("vertical-align", "middle");
                $(td).css("word-break", "break-word");
             
          }
        },
        {
          "targets":    8, //Fecha
          "width":      "10%",
          "className":  'dt-head-center dt-body-center',
          "createdCell": function (td, cellData, rowData, row, col){
                $(td).css("vertical-align", "middle");
             
          }
        },
        @if ($modo_visualizacion == 'edicion')
          {
            "targets":    9, //Acciones
            "width":      "10%",
            "className":  'dt-head-center dt-body-center',
            "createdCell": function (td, cellData, rowData, row, col) {
                  $(td).css("vertical-align", "middle");
               
              }
          }
        @endif
      ],
      "columns":[
        {
          "data":     "ptf_id",
          "name":     "ptf_id"
        },
        {
          "data":     "ptf_numero",
          "name":     "ptf_numero",
          "width":    "10%"
        }, 
        {                                   
          "data":     "ptf_actividad",
          "name":     "ptf_actividad"
        },  
        {                                   
          "data":     "ptf_objetivo",
          "name":     "ptf_objetivo",
          "width":    "15%"
        },  
        {
          "data":     "ptf_meta",
          "width":    "20%",
          "render" : function (data, type, row){
            let input = row.ptf_meta;
            var fields = input.split('|');
            html = "<ul>";
            let i=0;
            fields.forEach(function(element) {
              html = html + "<li>";
              html = html + fields[i];
              html = html + "</li>";
              i++;
            });
            html = html + "</ul>";
            return html;
          }
        }, 
        {
          "data": "", 
          "className": "text-center",
          "width":    "15%",
          "render" : function (data, type, row){
            let html = "";
            let ptf_det_estrategia = "";
            if(row.ptf_det_estrategia) ptf_det_estrategia = row.ptf_det_estrategia;
            

            @if ($modo_visualizacion == 'visualizacion')
              if (ptf_det_estrategia == "" || ptf_det_estrategia == undefined)ptf_det_estrategia = "Sin información";

              html = "<p>"+ptf_det_estrategia+"</p>";

            @elseif ($modo_visualizacion == 'edicion')  
                // html = "<textarea maxlength=1000 onkeypress='return caracteres_especiales(event)' onBlur='guardarPtf("+terapia+","+row.ptf_id+",$(this).val(),1);' class='form-control ' rows='3' id='estrategia_taller_"+row.ptf_id+"' name='estrategia_taller_"+row.ptf_id+"'>"+ptf_det_estrategia+"</textarea>";
                
                html = "<textarea maxlength=1000 onkeypress='return caracteres_especiales(event)' onBlur='HabilitarGuardarPTF("+terapia+", "+row.ptf_id+", 2);' class='form-control ' rows='3' id='estrategia_taller_"+row.ptf_id+"' name='estrategia_taller_"+row.ptf_id+"'>"+ptf_det_estrategia+"</textarea>";




            @endif

            return html;
          }
        },
        {
          "data": "", 
          "className": "text-center",
          "width":    "15%",
          "render" : function (data, type, row){
            let html = "";
            let ptf_det_resultado = "";
            if(row.ptf_det_resultado) ptf_det_resultado = row.ptf_det_resultado;
            
            @if ($modo_visualizacion == 'visualizacion')
                if (ptf_det_resultado == "" || ptf_det_resultado == undefined)ptf_det_resultado = "Sin información";

                html = "<p>"+ptf_det_resultado+"</p>";

            @elseif ($modo_visualizacion == 'edicion')  
                // html = "<textarea maxlength=1000 onkeypress='return caracteres_especiales(event)' onBlur='guardarPtf("+terapia+","+row.ptf_id+",$(this).val(),2);' class='form-control ' rows='3' id='resultado_taller_"+row.ptf_id+"' name='resultado_taller_"+row.ptf_id+"'>"+ptf_det_resultado+"</textarea>";
                
                html = "<textarea maxlength=1000 onkeypress='return caracteres_especiales(event)' onBlur='HabilitarGuardarPTF("+terapia+","+row.ptf_id+", 2);' class='form-control ' rows='3' id='resultado_taller_"+row.ptf_id+"' name='resultado_taller_"+row.ptf_id+"'>"+ptf_det_resultado+"</textarea>";

            @endif

            return html;
          }
        },
        {
          "data": "", 
          "className": "text-center",
          "width":    "15%",
          "render" : function (data, type, row){
            let html = "";
            let ptf_det_observacion = "";
            if(row.ptf_det_observacion) ptf_det_observacion = row.ptf_det_observacion;
            
            @if ($modo_visualizacion == 'visualizacion')
                if (ptf_det_observacion == "" || ptf_det_observacion == undefined)ptf_det_observacion = "Sin información";

                html = "<p>"+ptf_det_observacion+"</p>";

            @elseif ($modo_visualizacion == 'edicion')    
                // html = "<textarea maxlength=1000 onkeypress='return caracteres_especiales(event)' onBlur='guardarPtf("+terapia+","+row.ptf_id+",$(this).val(),3);' class='form-control ' rows='3' id='observacion_taller_"+row.ptf_id+"' name='observacion_taller_"+row.ptf_id+"'>"+ptf_det_observacion+"</textarea>";
                
                html = "<textarea maxlength=1000 onkeypress='return caracteres_especiales(event)' onBlur='HabilitarGuardarPTF("+terapia+","+row.ptf_id+", 2);' class='form-control ' rows='3' id='observacion_taller_"+row.ptf_id+"' name='observacion_taller_"+row.ptf_id+"'>"+ptf_det_observacion+"</textarea>";

            @endif


            return html;
          }
        },
        {
          "data": "", 
          "className": "text-center",
          "width":    "10%",
          "render" : function (data, type, row){
            let html = "";
            let ptf_det_fecha = "";

            if(row.ptf_det_fecha){
              ptf_det_fecha = row.ptf_det_fecha;
              var todayTime = new Date(ptf_det_fecha);
              var month = todayTime .getMonth() + 1;
              var day = todayTime .getDate();
              var year = todayTime .getFullYear();
              ptf_det_fecha=day + "/" + month + "/" + year;
            }



            @if ($modo_visualizacion == 'visualizacion')
              if (ptf_det_fecha == "") ptf_det_fecha = "Sin información";

              html = "<p>"+ptf_det_fecha+"</p>";



            @elseif ($modo_visualizacion == 'edicion')  
                // html = "<div class='input-group date-pick' id='fecha_taller_"+row.ptf_id+"'      data-target-input='nearest'><input value="+ptf_det_fecha+"   onkeypress='return caracteres_especiales_fecha(event)' type='text' name='fecha_taller_name_"+row.ptf_id+"' class='form-control datetimepicker-input '  data-target='#fecha_taller_"+row.ptf_id+"' id='fecha_taller_id_"+row.ptf_id+"' onBlur='guardarPtf("+terapia+","+row.ptf_id+",$(this).val(),4);'><div class='input-group-append' data-target='#fecha_taller_"+row.ptf_id+"' data-toggle='datetimepicker'><div class='input-group-text'><i class='fa fa-calendar'></i></div></div></div>";
                
                html = "<div class='input-group date-pick' id='fecha_taller_"+row.ptf_id+"'      data-target-input='nearest'><input value="+ptf_det_fecha+"   onkeypress='return caracteres_especiales_fecha(event)' type='text' name='fecha_taller_name_"+row.ptf_id+"' class='form-control datetimepicker-input '  data-target='#fecha_taller_"+row.ptf_id+"' id='fecha_taller_id_"+row.ptf_id+"' onBlur='HabilitarGuardarPTF("+terapia+","+row.ptf_id+", 2);'><div class='input-group-append' data-target='#fecha_taller_"+row.ptf_id+"' data-toggle='datetimepicker'><div class='input-group-text'><i class='fa fa-calendar'></i></div></div></div>";

            @endif
          
            return html;
          }
        },
        @if ($modo_visualizacion == 'edicion')
          {
            "data": "",
            "render" : function (data, type, row){
              let html = '<button type="button" class="btn btn-success" id="btn_guardar_ptf_'+row.ptf_id+'" disabled="true">Guardar</button>';

              return html;
            }
          }
        @endif
      ],
      "fnDrawCallback":function(){ 
        $('.date-pick').datetimepicker({
          format: 'DD/MM/Y'
        });

        $('[data-toggle="popover"]').popover();
      }
    });

  $('#terapiaPtf').modal('show');
}

function HabilitarGuardarPTF(tera_id, ptf_id, tip_ses){
    $("#btn_guardar_ptf_"+ptf_id).removeAttr("disabled");
    $("#btn_guardar_ptf_"+ptf_id).attr("onclick", "guardarPtf("+tera_id+", "+ptf_id+", "+tip_ses+")");

}
// INICIO CZ SPRINT 69 
function HabilitarGuardarPTF_2021(tera_id, ptf_id, tip_ses){
    $("#btn_guardar_ptf_"+ptf_id).removeAttr("disabled");
    $("#btn_guardar_ptf_"+ptf_id).attr("onclick", "guardarPtf_2021("+tera_id+", "+ptf_id+", "+tip_ses+")");

}
// FIN CZ SPRINT 69 

// function guardarPtf(tera_id, ptf_id, valor = null, tipo){
function guardarPtf(tera_id, ptf_id, tip_ses){
    let valor = new Array();
    // let valor = new Object();

    if (tip_ses == 1){
        respuesta = validarPTFSesion(ptf_id);

        if (!respuesta){
            let mensaje = "Faltan campos por completar para registrar la sesión. Por favor verifique e intente nuevamente.";

            mensajeTemporalRespuestas(0, mensaje);
            
            return false;
        }

        valor = recolectarPTFSesion(ptf_id);
        
    }else if (tip_ses == 2){
        respuesta = validarPTFTaller(ptf_id);

        if (!respuesta){
            let mensaje = "Faltan campos por completar para registrar la sesión. Por favor verifique e intente nuevamente.";

            mensajeTemporalRespuestas(0, mensaje);
            
            return false;
        }

       valor = recolectarPTFTaller(ptf_id);
    }

    bloquearPantalla();


    let data = new Object();
    data.tera_id = tera_id;
    data.ptf_id = ptf_id;
    data.tip_ses = tip_ses;
    data.valor = valor;

  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  $.ajax({
    url: "{{ route('terapia.guardarPtfDetalle') }}",
    type: "POST",
    data: data
  }).done(function(resp){
    desbloquearPantalla();
    //inicio ch
    terapiaPtf({{$nna_teparia->tera_id}});
    //fin ch

    if (resp.estado == 1){
        mensajeTemporalRespuestas(1, resp.mensaje);


        $("#btn_guardar_ptf_"+ptf_id).attr("disabled", true);
        $("#btn_guardar_ptf_"+ptf_id).removeAttr("onclick");
    }else if (resp.estado == 0){
        mensajeTemporalRespuestas(0, resp.mensaje);
        
    }
  }).fail(function(obj){
    desbloquearPantalla();

    manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

    return false;
  });
}
// INICIO CZ SPRINT 69 
function guardarPtf_2021(tera_id, ptf_id, tip_ses){
    let valor = new Array();
    // let valor = new Object();

    if (tip_ses == 1){
        respuesta = validarPTFSesion_2021(ptf_id);

        if (!respuesta){
            let mensaje = "Faltan campos por completar para registrar la sesión. Por favor verifique e intente nuevamente.";

            mensajeTemporalRespuestas(0, mensaje);
            
            return false;
        }

        valor = recolectarPTFSesion_2021(ptf_id);

        
    }else if (tip_ses == 2){
        respuesta = validarPTFTaller_2021(ptf_id);

        if (!respuesta){
            let mensaje = "Faltan campos por completar para registrar la sesión. Por favor verifique e intente nuevamente.";

            mensajeTemporalRespuestas(0, mensaje);
            
            return false;
        }

       valor = recolectarPTFTaller_2021(ptf_id);
    }

    bloquearPantalla();


    let data = new Object();
    data.tera_id = tera_id;
    data.ptf_id = ptf_id;
    data.tip_ses = tip_ses;
    data.valor = valor;

  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  $.ajax({
    url: "{{ route('terapia.guardarPtfDetalle_2021') }}",
    type: "POST",
    data: data
  }).done(function(resp){
    desbloquearPantalla();
    //inicio ch
    terapiaPtf_2021({{$nna_teparia->tera_id}});
    //fin ch

    if (resp.estado == 1){
        mensajeTemporalRespuestas(1, resp.mensaje);


        $("#btn_guardar_ptf_"+ptf_id).attr("disabled", true);
        $("#btn_guardar_ptf_"+ptf_id).removeAttr("onclick");
    }else if (resp.estado == 0){
        mensajeTemporalRespuestas(0, resp.mensaje);
        
    }
  }).fail(function(obj){
    desbloquearPantalla();
    toastr.error('Ocurrió un error al guardar la información');
		console.log(obj);
    return false;
  });
}
// FIN CZ SPRINT 69 
function recolectarPTFSesion(ptf_id){
  let data = new Array();

  data[0] = $("#estrategia_sesion_"+ptf_id).val();
  data[1] = $("#resultado_sesion_"+ptf_id).val();
  data[2] = $("#observacion_sesion_"+ptf_id).val();
  data[3] = $("#fecha_sesion_id_"+ptf_id).val();
  
  return data;
}

function recolectarPTFTaller(ptf_id){
  let data = new Array();

  data[0] = $("#estrategia_taller_"+ptf_id).val();
  data[1] = $("#resultado_taller_"+ptf_id).val();
  data[2] = $("#observacion_taller_"+ptf_id).val();
  data[3] = $("#fecha_taller_id_"+ptf_id).val();

  return data;
}

// INICIO CZ SPRINT 69 
function recolectarPTFSesion_2021(ptf_id){
  let data = new Array();

  data[0] = $("#resultado_sesion_"+ptf_id).val();
  data[1] = $("#observacion_sesion_"+ptf_id).val();
  data[2] = $("#fecha_sesion_id_"+ptf_id).val();
  data[3] = $("#id_estado_"+ptf_id).val();
  
  return data;
}

function recolectarPTFTaller_2021(ptf_id){
  let data = new Array();

  data[0] =$("#resultado_taller_"+ptf_id).val();
  data[1] = $("#observacion_taller_"+ptf_id).val();
  data[2] = $("#fecha_sesion_id_"+ptf_id).val();
  data[3] = $("#id_estado_"+ptf_id).val();
  return data;
}

// FIN CZ SPRINT 69


function validarPTFSesion(ptf_id){
  let respuesta = true;
  let data1 = $("#estrategia_sesion_"+ptf_id).val();
  let data2 = $("#resultado_sesion_"+ptf_id).val();
  let data3 = $("#observacion_sesion_"+ptf_id).val();
  let data4 = $("#fecha_sesion_id_"+ptf_id).val();

  if (data1 == "" || typeof data1 == "undefined" || data1 == null){
     respuesta = false;
     $("#estrategia_sesion_"+ptf_id).addClass("is-invalid");

  }else{
     $("#estrategia_sesion_"+ptf_id).removeClass("is-invalid");

  }

  if (data2 == "" || typeof data2 == "undefined" || data2 == null){
     respuesta = false;
     $("#resultado_sesion_"+ptf_id).addClass("is-invalid");

  }else{
     $("#resultado_sesion_"+ptf_id).removeClass("is-invalid");

  }

  if (data3 == "" || typeof data3 == "undefined" || data3 == null){
     respuesta = false;
     $("#observacion_sesion_"+ptf_id).addClass("is-invalid");

  }else {
     $("#observacion_sesion_"+ptf_id).removeClass("is-invalid");

  }

  if (data4 == "" || typeof data4 == "undefined" || data4 == null){
     respuesta = false;
     $("#fecha_sesion_id_"+ptf_id).addClass("is-invalid");

  }else{
     $("#fecha_sesion_id_"+ptf_id).removeClass("is-invalid");

  }

  return respuesta;
}
// INICIO CZ SPRINT 69 
function validarPTFSesion_2021(ptf_id){
  let respuesta = true;
  let data2 = $("#resultado_sesion_"+ptf_id).val();
  let data3 = $("#observacion_sesion_"+ptf_id).val();
  let data4 = $("#fecha_sesion_id_"+ptf_id).val();
  let dataEstado = $("#id_estado_"+ptf_id).val();

  // INICIO CZ SPRINT 69

  if((ptf_id != 15) && (ptf_id != 18) && (ptf_id != 21)){

  if (data2 == "" || typeof data2 == "undefined" || data2 == null){
     respuesta = false;
     $("#resultado_sesion_"+ptf_id).addClass("is-invalid");

  }else{
     $("#resultado_sesion_"+ptf_id).removeClass("is-invalid");

  }

  if (data3 == "" || typeof data3 == "undefined" || data3 == null){
     respuesta = false;
     $("#observacion_sesion_"+ptf_id).addClass("is-invalid");

  }else {
     $("#observacion_sesion_"+ptf_id).removeClass("is-invalid");

  }

  if (data4 == "" || typeof data4 == "undefined" || data4 == null){
     respuesta = false;
     $("#fecha_sesion_id_"+ptf_id).addClass("is-invalid");

  }else{
     $("#fecha_sesion_id_"+ptf_id).removeClass("is-invalid");

  }
  }
  // FIN CZ SPRINT 69
  if(dataEstado == ""){
    respuesta = false;
     $("#id_estado_"+ptf_id).addClass("is-invalid");
  }else{
    $("#id_estado_"+ptf_id).removeClass("is-invalid");
  }

  return respuesta;
}
// FIN CZ SPRINT 69 
function validarPTFTaller(ptf_id){
  let respuesta = true;
  let data1 = $("#estrategia_taller_"+ptf_id).val();
  let data2 = $("#resultado_taller_"+ptf_id).val();
  let data3 = $("#observacion_taller_"+ptf_id).val();
  let data4 = $("#fecha_taller_id_"+ptf_id).val();

  if (data1 == "" || typeof data1 == "undefined" || data1 == null){
     respuesta = false;
     $("#estrategia_taller_"+ptf_id).addClass("is-invalid");

  }else{
     $("#estrategia_taller_"+ptf_id).removeClass("is-invalid");

  }

  if (data2 == "" || typeof data2 == "undefined" || data2 == null){
     respuesta = false;
     $("#resultado_taller_"+ptf_id).addClass("is-invalid");

  }else{
     $("#resultado_taller_"+ptf_id).removeClass("is-invalid");

  }

  if (data3 == "" || typeof data3 == "undefined" || data3 == null){
     respuesta = false;
     $("#observacion_taller_"+ptf_id).addClass("is-invalid");

  }else {
     $("#observacion_taller_"+ptf_id).removeClass("is-invalid");

  }

  if (data4 == "" || typeof data4 == "undefined" || data4 == null){
     respuesta = false;
     $("#fecha_taller_id_"+ptf_id).addClass("is-invalid");

  }else{
     $("#fecha_taller_id_"+ptf_id).removeClass("is-invalid");

  }

  return respuesta;
}
// INICIO CZ SPRINT 69 
function validarPTFTaller_2021(ptf_id){
  let respuesta = true;
  let data2 = $("#resultado_taller_"+ptf_id).val();
  let data3 = $("#observacion_taller_"+ptf_id).val();
  let data4 = $("#fecha_sesion_id_"+ptf_id).val();
  let dataEstado = $("#id_estado_"+ptf_id).val();
  if (data2 == "" || typeof data2 == "undefined" || data2 == null){
     respuesta = false;
     $("#resultado_taller_"+ptf_id).addClass("is-invalid");

  }else{
     $("#resultado_taller_"+ptf_id).removeClass("is-invalid");

  }

  if (data3 == "" || typeof data3 == "undefined" || data3 == null){
     respuesta = false;
     $("#observacion_taller_"+ptf_id).addClass("is-invalid");

  }else {
     $("#observacion_taller_"+ptf_id).removeClass("is-invalid");

  }

  if (data4 == "" || typeof data4 == "undefined" || data4 == null){
     respuesta = false;
     $("#fecha_taller_id_"+ptf_id).addClass("is-invalid");

  }else{
     $("#fecha_taller_id_"+ptf_id).removeClass("is-invalid");

  }

  if(dataEstado == ""){
    respuesta = false;
     $("#id_estado_"+ptf_id).addClass("is-invalid");
  }else{
    $("#id_estado_"+ptf_id).removeClass("is-invalid");
  }

  return respuesta;
}
// FIN CZ SPRINT 69 

var array_par_gru_fam_nom = [];
var array_gru_fam_nom = [];
var array_gru_fam_ape_pat = [];
var array_gru_fam_ape_mat = [];

let data = new Object();
data.caso_id = $("#cas_id").val();

$.ajax({
      url : "{{ route('listar.grupo.familiarAraña') }}", "type": "GET",  "data": data
    }).done(function(resp){

      if(resp.length>0){
      
      function colorNodoFuente(codigo){

        let color = {}
        switch (codigo) {
          case "elcaso":
            color.node = "#F8D1BE";
            color.label = "#000000";
            color.border = "#FF0000";
          break;

          default:
            color.node  = "#F5F5F5";
            color.label = "#000000";
            color.border = "#018989";
        }

        return color;
      }


      let rutCaso=$('#run').val();
      let nodesArray = [];
      let filtro = 1;
      let idJefeHogar = 0;
      let container = document.getElementById('animation_container');
      let color;

      var options = {
        layout:{
          randomSeed: 966922
        },
        nodes:{
          shape: 'box',
          color: {
            highlight: {
              border: "grey",
              background: "#ffcd14"
            },
            hover: {
              border: "grey",
              background: "#a7d0d0"
            }
          },
          heightConstraint: 50,
          borderWidth: 3,
          shadow:true,
          widthConstraint: {
            minimum: 150,
            maximum: 150
          }
        },
        interaction:{
          hover:true,
          navigationButtons:true,
          keyboard:true
        },
        edges: {
          smooth: {
            "type": "curvedCW",
            "forceDirection": "none",
            "roundness": 0.1
          },
          color: {
             "color": "grey"
          },
          width: 3,
          shadow:true
        },
        physics: {
          repulsion: {
            centralGravity: 1,
            nodeDistance: 150,
            damping: 0.2
          },
          minVelocity: 0.74,
          solver: "repulsion"
        }
      };

      for (var i = 0;i<resp.length;i++){
        if(resp[i].par_gru_fam_cod==1){
          idJefeHogar = i;
        }

        let rut = "";
        if(resp[i].gru_fam_run != null){
          rut = resp[i].gru_fam_run+'-'+resp[i].gru_fam_dv;
        }else{
          rut = "-Error en Rut";
        }

        let parentescoNombre = resp[i].par_gru_fam_nom.replace(/(\([0-9]*\)\s[0-9]*\.\s)/,'');
        let coincidenciasParentesco = resp[i].par_gru_fam_nom.match(/\(([0-9]*)\)/);

        let sexoNombre = resp[i].gru_fam_sex;

        // Colores de los Nodos y las fuentes
        parentescoCodigo ="";
        if(resp[i].indice=='1'){
        //if(rutCaso==resp[i].gru_fam_run){
          parentescoCodigo ="elcaso";
          var nodeIdCaso = i;
          //color = colorNodoFuente(parentescoCodigo);
        }else{
          //color = colorNodoFuente(parentescoCodigo);
          //color = {node:'#ffffff',label:'#000000'}
        }

          color = colorNodoFuente(parentescoCodigo);
        //if(filtro==1){
        //  color = colorNodoFuente(parentescoCodigo);
        //}else{
        //  color = {node:'#ffffff',label:'#000000'}
        //}

        var label = "";
        if(resp[i]['par_gru_fam_cod']==1){
          label = '<b>'+ parentescoNombre + '</b> \n\n ' + resp[i].gru_fam_nom + '';
        }else{
          label = '<b>'+ parentescoNombre + '</b> \n\n ' + resp[i].gru_fam_nom +'';
        }


        let title =  resp[i].gru_fam_nom+ ' ' +resp[i].gru_fam_ape_pat + ' ' + resp[i].gru_fam_ape_mat;

        nodesArray.push({
          id    : i,
          label : label,
          title   : ponerMayuscula(title),
          font  : {multi:true, color:color.label},
          color :   {background: color.node, border: color.border},
          rut   : rut,
          nombres : resp[i].gru_fam_nom,
          appat : resp[i].gru_fam_ape_pat,
          apmat : resp[i].gru_fam_ape_mat,
          //nacimiento  : fechaNacimiento,
          //edad  : edad,
          //sexo  : ponerMayuscula(sexoNombre),
          parentesco  : parentescoNombre,
          jefe  : resp[i].par_gru_fam_cod
        });

      }

      let nodesDataSet = new vis.DataSet(nodesArray);
      let filtroNodes = nodesDataSet;
      let edgesArray = [];
      let edgesObjeto= {};

      $.each(nodesArray, function(i, val) {
        if(idJefeHogar!=val.id){
          edgesArray.push({
            from  : idJefeHogar,
            to  : val.id,
            arrows:"to"
          });
        }
      });

      edgesObjeto.datos = edgesArray;
      let edgesDataSet = new vis.DataSet(edgesObjeto.datos);

      //Fin de creacion de nodes y edges
      switch (filtro) {
        case 1:
          filtroNodes = nodesDataSet;
          break;
        case 2:
          nodesDataSet.forEach(function(item){
            if(item.sexo=="Mujer" ){
              nodesDataSet.update({id:item.id,color:filtroColorFondo,font:{multi:true,color:filtroColorLetra}});
            }
          });
          break;
        case 3:

          nodesDataSet.forEach(function(item){
            if(item.sexo=="Hombre" ){
              nodesDataSet.update({id:item.id,color:filtroColorFondo,font:{multi:true,color:filtroColorLetra}});
            }
          });
          break;
      }

      filtroNodes = nodesDataSet;
      let data = {
        nodes: filtroNodes,
        edges: edgesDataSet
      };


      network = new vis.Network(container, data, options);

      network.on("hoverNode", function (params) {
        if(typeof params.node!== 'undefined'){
          $("#vis_panel").show();
          var nodoClickeado =  nodesDataSet.get(params.node);
          $("#vis_nombre").text( ponerMayuscula(nodoClickeado.nombres+" "+nodoClickeado.appat+" "+nodoClickeado.apmat));
          $("#vis_rut").text(nodoClickeado.rut);
          $("#vis_sexo").text(nodoClickeado.sexo);
          $("#vis_edad").text(nodoClickeado.edad);
        }else{
          $("#vis_panel").find("dd").text("");
          $("#vis_panel").hide();
        }
      });

      }else{
        $("#animation_container").append('<br><br><br><br><div class="text-center" >RUN no se encuentra en el sistema SAN</div>')
      }

    }).fail(function(obj){
      console.log('error');
    });

  contenido_textarea_ptf_seg_recursos = ""; 
  function valTextAreaptf_seg_recursos(){
      num_caracteres_permitidos   = 1000;

      num_caracteres = $("#ptf_seg_recursos").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#ptf_seg_recursos").val(contenido_textarea_ptf_seg_recursos);

       }else{ 
          contenido_textarea_ptf_seg_recursos = $("#ptf_seg_recursos").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_seg_recursos").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_seg_recursos").css("color", "#000000");

       } 

       $("#cant_carac_seg_recursos").text($("#ptf_seg_recursos").val().length);
   }


  contenido_textarea_ptf_seg_redes = ""; 
  function valTextAreaptf_seg_redes(){
      num_caracteres_permitidos   = 1000;

      num_caracteres = $("#ptf_seg_redes").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#ptf_seg_redes").val(contenido_textarea_ptf_seg_redes);

       }else{ 
          contenido_textarea_ptf_seg_redes = $("#ptf_seg_redes").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_seg_redes").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_seg_redes").css("color", "#000000");

       } 

       $("#cant_carac_seg_redes").text($("#ptf_seg_redes").val().length);
   }


  contenido_textarea_ptf_seg_riesgo = ""; 
  function valTextAreaptf_seg_riesgo(){
      num_caracteres_permitidos   = 1000;

      num_caracteres = $("#ptf_seg_riesgo").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#ptf_seg_riesgo").val(contenido_textarea_ptf_seg_riesgo);

       }else{ 
          contenido_textarea_ptf_seg_riesgo = $("#ptf_seg_riesgo").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_seg_riesgo").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_seg_riesgo").css("color", "#000000");

       } 

       $("#cant_carac_seg_riesgo").text($("#ptf_seg_riesgo").val().length);
   }


  contenido_textarea_ptf_seg_observacion = ""; 
  function valTextAreaptf_seg_observacion(){
      num_caracteres_permitidos   = 1000;

      num_caracteres = $("#ptf_seg_observacion").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#ptf_seg_observacion").val(contenido_textarea_ptf_seg_observacion);

       }else{ 
          contenido_textarea_ptf_seg_observacion = $("#ptf_seg_observacion").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_seg_observacion").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_seg_observacion").css("color", "#000000");

       } 

       $("#cant_carac_seg_observacion").text($("#ptf_seg_observacion").val().length);
   }

</script>

@endsection

<style type="text/css">
  .disable-btn-nav-est{
      color: currentColor;
      cursor: not-allowed;
      opacity: 0.5;
      pointer-events: none;
  }
</style>