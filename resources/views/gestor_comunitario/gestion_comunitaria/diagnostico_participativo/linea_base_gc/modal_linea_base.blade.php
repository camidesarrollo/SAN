<!-- INICIO CZ SPRINT 67 -->
<div id="frmlineabase" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="formComponentesLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
<!-- FIN CZ SPRINT 67 -->    
    <div class="modal-dialog modal-xl">
      <div class="modal-content p-4">
        <div class="card p-4 m-0 shadow-sm">
          <h5 class="modal-title text-center" id="formComponentesLabel"><b>LÍNEA DE BASE GESTIÓN COMUNITARIA</b></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" style="position: absolute; right: 5px; top: 5px; width: 23px; height: 23px; padding: 0; margin: 0;">&times;</span>
          </button>
		  
          <br>
		  
            <div class="form-group">
                <div class="card colapsable shadow-sm" id="contenedor_identificacion">
                    <a class="btn text-left p-0 collapsed" id="desplegar_identificacion" data-toggle="collapse" data-target="#identificacion" aria-expanded="false" aria-controls="identificacion">
                        <div class="card-header p-3">
                            <h5 class="mb-0">
                                <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
                                &nbsp;&nbsp;I. Identificación
                            </h5>
                        </div>
                    </a>
            
			
                    <div class="collapse" id="identificacion">
                        <div class="card-body">
                            <br>
                            @includeif('gestor_comunitario.gestion_comunitaria.diagnostico_participativo.linea_base_gc.identificacion_linea_base')
                        </div>
                    </div>
                </div>
                <div class="card colapsable shadow-sm" id="contenedor_servicio_prestaciones">
                    <a class="btn text-left p-0 collapsed" id="desplegar_servicio_prestaciones" data-toggle="collapse" data-target="#servicio_prestaciones" aria-expanded="false" aria-controls="servicio_prestaciones" >
                        <div class="card-header p-3">
                            <h5 class="mb-0">
                                <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
                                &nbsp;&nbsp;II. Servicios y Prestaciones
                            </h5>
                        </div>
                    </a>
            
                    <div class="collapse" id="servicio_prestaciones">
                        <div class="card-body">
                            <br>
                            @includeif('gestor_comunitario.gestion_comunitaria.diagnostico_participativo.linea_base_gc.servicios_prestaciones')
                        </div>
                    </div>
                </div>
            
                <div class="card colapsable shadow-sm" id="contenedor_organizacion_comunitaria">
                    <a class="btn text-left p-0 collapsed" id="desplegar_organizacion_comunitaria" data-toggle="collapse" data-target="#organizacion_comunitaria" aria-expanded="false" aria-controls="organizacion_comunitaria" >
                        <div class="card-header p-3">
                        <!-- INICIO CZ SPRINT 62 -->
                            <h5 class="mb-0" id="titulo_organizacion_comunitaria" >
                                <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
                                &nbsp;&nbsp;III. Organización Comunitaria
                            </h5>
                            <!-- FIN CZ  SPRINT 62 -->
                        </div>
                    </a>
            
                    <div class="collapse" id="organizacion_comunitaria">
                        <div class="card-body">
                            <br>
                            @includeif('gestor_comunitario.gestion_comunitaria.diagnostico_participativo.linea_base_gc.organizacion_comunitaria')
                        </div>
                    </div>
                </div>
            
                <div class="card colapsable shadow-sm" id="contenedor_derecho_part_nna">
                    <a class="btn text-left p-0 collapsed" id="desplegar_derecho_part_nna" data-toggle="collapse" data-target="#derecho_part_nna" aria-expanded="false" aria-controls="derecho_part_nna" >
                        <div class="card-header p-3">
                        <!-- INICIO CZ SPRINT 62 -->
                            <h5 class="mb-0" id="titulo_derecho_part_nna" style="display:block">
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
            
                    <div class="collapse" id="derecho_part_nna">
                        <div class="card-body" id="derecho_participacion"> 
                            <br>
                            @includeif('gestor_comunitario.gestion_comunitaria.diagnostico_participativo.linea_base_gc.derecho_participacion')
                        </div>
                    </div>
                </div>
            </div>
          <div class="text-right">
          <!-- INICIO DC -->
            <button id="btn_lb_guardar" type="button" class="btn btn-success btn_lb_guardar" onclick="guardarLineaBase();" >Guardar</button>
          <!-- FIN DC -->
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>					
        </div>                
      </div>
    </div>
  </div>