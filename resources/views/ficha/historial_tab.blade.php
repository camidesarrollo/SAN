<section>
    <div class="container-fluid">
        <div class="row p-4">
            <div class="col-md-12">
                <h5>Historial Casos NNA</h5>
            </div>
        </div>
    </div>
</section>

<section>

@php $cont=0;  @endphp 
@foreach ($casosAsignados as $casos) 
@php $cont++; $originalDate = $casos->cas_fec; $newDate = date("d-m-Y", strtotime($originalDate)); @endphp


    <div class="container-fluid">
        <div class="card p-4">
                
                <h5> Caso N° {{$cont}} / Creado: <span style="color:#49AE32;"><b>{{$newDate}}</b></span> / Estado: <span style="color:#49AE32;"><b>{{$casos->est_cas_nom}}</b></span><a  href="#" class="hist_est" id="{{$cont}}" style="color:blue;"> -> Ver Detalle</a> </h5>

                    
                           
                    <div style="display:none;" id="caso_{{$cont}}" >   

                    @if(in_array($casos->cas_id,$arrayAlertasAsoc))
                     @foreach ($alertasAsociadas as $alerta) 
                     @if($casos->cas_id==$alerta->cas_id)

                   <!--  INICIO TABLA CASO     -->              
                    <table class="table table-bordered table-hover dataTable no-footer">
                        <thead>
                            <tr role="row">
                                <th aria-controls="tabla_alertas" colspan="2">Alerta Territorial</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class=" text-left" colspan="2">{{$alerta->ale_tip_nom}} / Creada: <span style="color:#49AE32;" ><b>{{$alerta->ale_man_fec}}</b></span></td>
                            </tr>
                            <tr role="row">
                                <th aria-controls="tabla_alertas" colspan="2">Ofertas Asociadas:</th>
                            </tr>
                            @php $ofe_existe=0; @endphp
                            @foreach ($OfertasAsociadas as $oferta) @if($oferta->ale_man_id==$alerta->ale_man_id)
                            
                            <tr role="row" class="odd">
                                <td class="text-center sorting_1" style="width:40px;color:black;">
                                    <input class="" type="hidden"  style="color:black;"checked name="ofe_id[]" id="ofe_id[]" value="{{$oferta->ofe_id}}" disabled ><span class="oi oi-check"></span></td>
                                <td class=" text-left">{{$oferta->ofe_nom}}   </td>
                            </tr>

                            @php $ofe_existe=1; @endphp

                            @endif 
                            
                            @endforeach

                            @if($ofe_existe==0)
                            <tr role="row" class="odd"> 
                                <td class=" text-left" colspan="2" >
                                <span style="color:red"><b>No se han asociado ofertas para esta alerta.</b></span>
                                </td>
                            </tr>
                            @endif

                            </tr>
                        </tbody>
                    </table>
                    <br>
                    <br> 
                     <!--  FIN TABLA CASO
                    -->
                 
                    @endif 
                    @endforeach
                    @else

                    <h6 style="color:#E50909;"><b>No existen Alertas Territoriales Asociadas a este Caso</b>
                    </h6>
                    @endif

                    <div class="row">
                        <div class="col-md-12" >
                        <!-- <button type="button" data-id="{{$casos->cas_id}}" data-target="#verPafModal" data-toggle="modal" class="btn btn-primary float-right cargaAlerta">Ver PAF</button> -->
                        </div>
                    </div>

      

            </div>
        </div>
    </div>
</section>

@endforeach

<script type='text/javascript' src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript">

 $(document).ready(function() { 

        $(".hist_est").click(function(){
            
            var id = $(this).attr("id");

            if($("#"+id).text()==' -> Cerrar'){
                $("#"+id).text(' -> Ver Detalle');
            }else{
                $("#"+id).text(' -> Cerrar');
            }

            $("#caso_"+id).toggle();
            
        });

  });
</script>