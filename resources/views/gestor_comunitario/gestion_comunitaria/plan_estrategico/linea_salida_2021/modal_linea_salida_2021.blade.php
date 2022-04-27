<!-- INICIO CZ SPRINT 70 -->
<div id="frmlineaSalida_2021" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="formComponentesLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl">
      <div class="modal-content p-4">
        <div class="card p-4 m-0 shadow-sm">
          <h5 class="modal-title text-center" id="formComponentesLabel"><b>LÍNEA DE SALIDA GESTIÓN COMUNITARIA</b></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" style="position: absolute; right: 5px; top: 5px; width: 23px; height: 23px; padding: 0; margin: 0;">&times;</span>
          </button>
		  
          <br>
		  
            <div class="form-group">
                <div class="card colapsable shadow-sm" id="contenedor_identificacion">
                    <a class="btn text-left p-0 collapsed" id="desplegar_identificacion" data-toggle="collapse" data-target="#identificacion_linea_salida_2021" aria-expanded="false" aria-controls="identificacion">
                        <div class="card-header p-3">
                            <h5 class="mb-0">
                                <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
                                &nbsp;&nbsp;I. Identificación
                            </h5>
                        </div>
                    </a>
            
			
                    <div class="collapse" id="identificacion_linea_salida_2021">
                        <div class="card-body">
                            <br>
                            @includeif('gestor_comunitario.gestion_comunitaria.plan_estrategico.linea_salida_2021.identificacion_linea_base_Salida_2021')
                        </div>
                    </div>
                </div>
                <div class="card colapsable shadow-sm" id="contenedor_servicio_prestaciones">
                    <a class="btn text-left p-0 collapsed" id="desplegar_servicio_prestaciones" data-toggle="collapse" data-target="#servicio_prestaciones_linea_salida" aria-expanded="false" aria-controls="servicio_prestaciones_linea_salida" >
                        <div class="card-header p-3">
                            <h5 class="mb-0">
                                <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
                                &nbsp;&nbsp;II. Servicios y Prestaciones
                            </h5>
                        </div>
                    </a>
            
                    <div class="collapse" id="servicio_prestaciones_linea_salida">
                        <div class="card-body">
                            <br>
                            @includeif('gestor_comunitario.gestion_comunitaria.plan_estrategico.linea_salida_2021.servicios_prestaciones_Salida_2021')                        </div>
                    </div>
                </div>

                <div class="card colapsable shadow-sm" id="contenedor_recursos_comunidad_2021">
                    <a class="btn text-left p-0 collapsed" id="desplegar_recursos_comunidad_linea_salida_2021" data-toggle="collapse" data-target="#recursos_comunidad_linea_salida_2021" aria-expanded="false" aria-controls="recursos_comunidad_linea_salida_2021" >
                        <div class="card-header p-3">
                            <h5 class="mb-0">
                                <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
                                &nbsp;&nbsp;III. Recursos de la Comunidad
                            </h5>
                        </div>
                    </a>
            
                    <div class="collapse" id="recursos_comunidad_linea_salida_2021">
                        <div class="card-body">
                            <br>
                            @includeif('gestor_comunitario.gestion_comunitaria.plan_estrategico.linea_salida_2021.recursos_comunidad_Salida_2021')  
                        </div>
                    </div>
                </div>            
                <div class="card colapsable shadow-sm" id="contenedor_derecho_part_nna">
                    <a class="btn text-left p-0 collapsed" id="desplegar_derecho_part_nna_linea_salida" data-toggle="collapse" data-target="#derecho_part_nna_linea_salida" aria-expanded="false" aria-controls="derecho_part_nna_linea_salida" >
                        <div class="card-header p-3">
                        <!-- INICIO CZ SPRINT 62 -->
                            <h5 class="mb-0" id="titulo_derecho_part_nna_linea_salida" style="display:block">
                            <!-- FIN CZ  SPRINT 62 -->
                                <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
                                &nbsp;&nbsp;
                                IV. Derechos y Participación de los Niños, Niñas y Adolescentes
                                
                            </h5>
                            <!-- INICIO CZ SPRINT 62 -->
                            <h5 class="mb-0" id="titulo_derecho_part_nnaPantallaChica" style="display:none">
                            
                                <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
                                &nbsp;&nbsp;
                                IV. Derechos y Participación <br>de los Niños,Niñas y Adolescentes
                                
                            </h5>
                            <!-- FIN CZ  SPRINT 62 -->
                        </div>
                    </a>
            
                    <div class="collapse" id="derecho_part_nna_linea_salida">
                        <div class="card-body" id="derecho_participacion_linea_salida"> 
                            <br>
                            @includeif('gestor_comunitario.gestion_comunitaria.plan_estrategico.linea_salida_2021.derecho_participacion_Salida_2021')  
                        </div>
                    </div>
                </div>
                <div class="card colapsable shadow-sm" id="contenedor_continuidad_proyecto_linea_salida_2021">
                    <a class="btn text-left p-0 collapsed" id="desplegar_continuidad_proyecto_linea_salida_2021" data-toggle="collapse" data-target="#continuidad_proyecto_linea_salida_2021" aria-expanded="false" aria-controls="continuidad_proyecto_linea_salida_2021" >
                        <div class="card-header p-3">
                            <h5 class="mb-0">
                                <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
                                &nbsp;&nbsp;V. Continuidad del proyecto
                            </h5>
                        </div>
                    </a>
            
                    <div class="collapse" id="continuidad_proyecto_linea_salida_2021">
                        <div class="card-body">
                            <br>
                            @includeif('gestor_comunitario.gestion_comunitaria.plan_estrategico.linea_salida_2021.continuidad_proyecto_Salida_2021')  
                        </div>
                    </div>
                </div>
            </div>
          <div class="text-right">
            <button id="btn_lb_guardar" type="button" class="btn btn-success btn_lb_guardar" onclick="guardarLineaSalida_2021();" >Guardar</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>					
        </div>                
      </div>
    </div>
  </div>
  <!-- FIN CZ SPRINT 70 -->