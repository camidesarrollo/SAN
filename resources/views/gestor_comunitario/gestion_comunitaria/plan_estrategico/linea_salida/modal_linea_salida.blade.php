<!-- INCIO CZ SPRINT 67 -->
<div id="frmlineabase2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="formComponentesLabel2" aria-hidden="true" data-backdrop="static" data-keyboard="false">
<!-- FIN CZ SPRINT 67 --> 
    <div class="modal-dialog modal-xl">
      <div class="modal-content p-4">
        <div class="card p-4 m-0 shadow-sm">
          <h5 class="modal-title text-center" id="formComponentesLabel2"><b>LÍNEA DE SALIDA GESTIÓN COMUNITARIA</b></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" style="position: absolute; right: 5px; top: 5px; width: 23px; height: 23px; padding: 0; margin: 0;">&times;</span>
          </button>
          <br>
		  
            <div class="form-group">
                <div class="card colapsable shadow-sm" id="contenedor_identificacion2">
                    <a class="btn text-left p-0 collapsed" id="desplegar_identificacion2" data-toggle="collapse" data-target="#identificacion2" aria-expanded="false" aria-controls="identificacion">
                        <div class="card-header p-3">
                            <h5 class="mb-0">
                                <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
                                &nbsp;&nbsp;I. Identificación
                            </h5>
                        </div>
                    </a>
            
                    <div class="collapse" id="identificacion2">
                        <div class="card-body">
                            <br>
                            @includeif('gestor_comunitario.gestion_comunitaria.plan_estrategico.linea_salida.identificacion_linea_salida')
                        </div>
                    </div>
                </div>
                <div class="card colapsable shadow-sm" id="contenedor_servicio_prestaciones2">
                    <a class="btn text-left p-0 collapsed" id="desplegar_servicio_prestaciones2" data-toggle="collapse" data-target="#servicio_prestaciones2" aria-expanded="false" aria-controls="servicio_prestaciones" >
                        <div class="card-header p-3">
                            <h5 class="mb-0">
                                <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
                                &nbsp;&nbsp;II. Servicios y Prestaciones
                            </h5>
                        </div>
                    </a>
            
                    <div class="collapse" id="servicio_prestaciones2">
                        <div class="card-body">
                            <br>
                            @includeif('gestor_comunitario.gestion_comunitaria.plan_estrategico.linea_salida.servicios_prestaciones_ls')
                        </div>
                    </div>
                </div>
            
                <div class="card colapsable shadow-sm" id="contenedor_organizacion_comunitaria2">
                    <a class="btn text-left p-0 collapsed" id="desplegar_organizacion_comunitaria2" data-toggle="collapse" data-target="#organizacion_comunitaria2" aria-expanded="false" aria-controls="organizacion_comunitaria2" >
                        <div class="card-header p-3">
                            <h5 class="mb-0">
                                <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
                                &nbsp;&nbsp;III. Organización Comunitaria
                            </h5>
                        </div>
                    </a>
            
                    <div class="collapse" id="organizacion_comunitaria2">
                        <div class="card-body">
                            <br>
                            @includeif('gestor_comunitario.gestion_comunitaria.plan_estrategico.linea_salida.organizacion_comunitaria_ls')
                        </div>
                    </div>
                </div>
            
                <div class="card colapsable shadow-sm" id="contenedor_derecho_part_nna2">
                    <a class="btn text-left p-0 collapsed" id="desplegar_derecho_part_nna2" data-toggle="collapse" data-target="#derecho_part_nna2" aria-expanded="false" aria-controls="derecho_part_nna" >
                        <div class="card-header p-3">
                            <h5 class="mb-0">
                                <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
                                &nbsp;&nbsp;IV. Derechos y Participación de los Niños, Niñas y Adolescentes
                            </h5>
                        </div>
                    </a>
            
                    <div class="collapse" id="derecho_part_nna2">
                        <div class="card-body">
                            <br>
                            @includeif('gestor_comunitario.gestion_comunitaria.plan_estrategico.linea_salida.derecho_participacion_ls')
                        </div>
                    </div>
                </div>
            </div>
          <div class="text-right">
          <!-- INICIO DC -->
            <button id="btn_lb_guardar" type="button" class="btn btn-success btn_lb_guardar" onclick="guardarLineaSalida();">Guardar</button>
          <!-- FIN DC -->
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>					
        </div>                
      </div>
    </div>
</div>