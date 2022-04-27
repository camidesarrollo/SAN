<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Document</title>
    </head>

<body>
    <table width="100%" cellpadding="15" cellspacing="0" class="cartola-header">
      <tr>
        <td><img src="http://www.ministeriodesarrollosocial.gob.cl/img/logo-main.jpg" alt="Ministerio de Desarrollo Social" class="cartola-logo"></td>
        <td width="70%">
            <h3>RESULTADO </h3>
            <h1>NCFAS</h1>
        </td>
        <td align="center" class="box"><p>Fecha Emisión</p><h3>{{$today}}</h3></td>
      </tr>
    </table>

<section>
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-12 p-3">
       <!--  <p>El siguiente diagnóstico será asignado al caso:</p> -->
        <div class="card p-4">
            <div class="row">

              <div class="col">
                <h3>Nombre: <strong>{{ $nombres_persona }}</strong></h3>
              </div>
              <div class="col-4">
                <h3>RUT: <strong>{{ $rut }}</strong></h3>
              </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section> 
  <div class="container">
    <div class="card p-3">
      <div class="row">
        <div class="col-md-3">
          <hr>
         </div>
         <div class="col-md-9">
          <div class="tab-content" id="nav-tabContent">
              <?php
              $indice=0;
              ?>
              @foreach($dimensiones as $d)
                <div class="tab-pane fade" id="" role="tabpanel" aria-labelledby="">
                  <h4>{{($d->dim_enc_nom)}}</h4>
                  <p>{{($d->dim_enc_not)?$d->dim_enc_not:""}}</p>

                  @php( $preguntasDim = $d->preguntas->where('dim_id',$d->dim_id)->sortBy('pre_ord'))

                  @foreach($preguntasDim as $p)

                    @if($p->pre_tip==1)

                      <table class="table table-hover table-responsive table-sm tablaEncuesta" attr1="" >
                        <thead>
                        <tr>
                          <th colspan="9">
                            <h5>{{$p->nom_var}}</h5>
                          </th>
                        </tr>
                        <tr>
                          <th scope="col"><small></small></th>
                          @foreach($alternativas as $alt)
                            <th scope="col" style="width: 11%" ><small>{{$alt->alt_nom}} </small></th>
                          @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                          <td>
                            <div style="height: 0px; overflow:auto;">

                            </div>
                          </td>
                          <td class="headGravedadEncuesta1" ></td>
                          <td class="headGravedadEncuesta2" ></td>
                          <td class="headGravedadEncuesta3" ></td>
                          <td class="headGravedadEncuesta4" ></td>
                          <td class="headGravedadEncuesta5" ></td>
                          <td class="headGravedadEncuesta6" ></td>
                          <td class="headGravedadEncuesta7" ></td>
                          <td class="headGravedadEncuesta8" ></td>
                        </tr>

                        @foreach($fases as $fa)

                          @if($fa->fas_id==$fase_actual)
                            <tr class="currentFase" >
                              <th scope="row">{{$fa->fas_nom}} </th>
                              @foreach($alternativas as $alt)
                              <td>
                                <div class="form-check form-check-inline">
                                @if (($opcion==config('constantes.en_diagnostico') && $fa->fas_id==config('constantes.ncfas_fs_ingreso'))
                                or
                                ($opcion==config('constantes.en_cierre_paf') && $fa->fas_id==config('constantes.ncfas_fs_cierre')
                                ))
                                <input class="form-check-input" type="radio" name="" id="" value="" {{($alt->alt_ord==1)?"required":""}} 

                                @foreach($respuestas as $res)
                                
                                @if(($res->fas_id==$fa->fas_id)&&($res->pre_id==$p->pre_id)&&($res->alt_id==$alt->alt_id))

                                checked="checked"

                                @endif      

                                @endforeach
                                  >
                                  <label class="form-check-label" for="">{{$alt->alt_val}}</label>
                                @else
                                  <label class="form-check-label" >{{$alt->alt_val}}</label>
                                @endif
                                </div>
                              </td>
                              @endforeach
                            </tr>
                          @else
                            <tr>
                              <td scope="row">{{$fa->fas_nom}}</td>
                              @if($fa->fas_id < $fase_actual)
                                @foreach($alternativas as $alt)
                                  <td>
                                    <div class="form-check form-check-inline"  >
                                      @if($respuestas->count()>$indice)

                                        @if(intval($respuestas[$indice]->alt_id) == $alt->alt_id && $respuestas[$indice]->fas_id == $fa->fas_id  )
                                          <input disabled
                                          class="form-check-input" type="radio" name="" attr1=""  value="" checked="checked" >
                                        @endif
                                      @endif

                                      <label class="form-check-label" >{{$alt->alt_val}}</label>
                                    </div>
                                  </td>
                                @endforeach
                                <?php
                                $indice++;
                                ?>
                              @elseif($fa->fas_id>$fase_actual)
                                @foreach($alternativas as $alt)
                                <td>
                                  <div class="form-check form-check-inline">
                                    <label class="form-check-label" >{{$alt->alt_val}}</label>
                                  </div>
                                </td>
                                @endforeach
                              @endif


                            </tr>
                          @endif

                        @endforeach
                        </tbody>
                      </table>
                      <hr>

                    @else

                      @if($p->pre_tip==2 )

                        <?php $mostrar_texarea=1; ?>

                        @forelse($comentarios as $com)
                           @if($d->dim_enc_id==$com->dim_enc_id)
                              <div class="form-group">
                                <label><h5>{{$p->nom_var}}</h5></label>
                                <p onkeypress='return caracteres_especiales(event)' type="text" name=""  id="" class="form-control " @if(($caso->fas_id==1)&&($caso->est_cas_id==1))
                                disabled 
                                @endif
                                @if($caso->fas_id==3)
                                disabled 
                                @endif
                                >{{$com->res_com}}</p>
                              </div>

                             <?php $mostrar_texarea=0; ?>
                          @endif
                        @empty
                        @endforelse

                          @if($fase_actual<4)
                            @if($mostrar_texarea==1)
                            <div class="form-group">
                              <label><h5>{{$p->nom_var}}</h5></label>
                              <p 
                              required onkeypress='return caracteres_especiales(event)' type="text" id="" name="" class="form-control " placeholder="Comentario" aria-label="Comentario"></p>
                            </div>

                            @endif
                          @endif                      
                        
                      @endif

                    @endif

                  @endforeach
                </div>
              @endforeach
            </div>
          </div>

        </div>

      </div>

    </div>
</section>
    
</body>

</html>

