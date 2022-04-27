<style type="text/css">
.full-width-tabs > ul.nav.nav-pills {
    display: table;
    width: 100%;
    table-layout: fixed;
}
.full-width-tabs > ul.nav.nav-pills > li {
    float: none;
    display: table-cell;
}
.full-width-tabs > ul.nav.nav-pills > li > a {
    text-align: center;
}
.take-all-space-you-can{
    width:100%;
}
</style>


<div class="container">
	<div class="row">
		<div class="full-width-tabs">
			<ul class="nav nav-pills nav-fill" id="Registro_Seguimiento_Tab" role="tablist">
		        <li class="nav-item take-all-space-you-can">
		          <a class="nav-link seg-link active" id="info-tab" data-toggle="tab" href="#info" role="tab" aria-controls="info" aria-selected="true"><i class="fas fa-info-circle" aria-hidden="true"></i><b>  Información</b></a>
		        </li>
		        {{-- <li class="nav-item take-all-space-you-can">
		          <a class="nav-link seg-link" id="pen_paf-tab-tareas" data-toggle="tab" href="#pen-paf-tareas" role="tab" aria-controls="pen-paf-tareas" aria-selected="false"><i class="fas fa-tasks fa-2x" aria-hidden="true"></i></br></br><b>Tareas</b></a>
		        </li>
		        <li class="nav-item take-all-space-you-can">
		          <a class="nav-link seg-link" id="pen_paf-tab-derivaciones" data-toggle="tab" href="#pen_paf-derivaciones" role="tab" aria-controls="pen_paf-derivaciones" aria-selected="false"><i class="fas fa-random fa-2x" aria-hidden="true"></i></br></br><b>Derivaciones</b></a>
		        </li>
		        <li class="nav-item take-all-space-you-can">
		          <a class="nav-link seg-link" id="pen_ale-tab" data-toggle="tab" href="#pen_ale" role="tab" aria-controls="pen_ale" aria-selected="false"><i class="fas fa-exclamation-circle fa-2x" aria-hidden="true"></i></br></br><b>Alertas Territoriales</b></a>
		        </li> --}}

		        <li class="nav-item take-all-space-you-can">
		          <a class="nav-link seg-link" id="pas-tab" data-toggle="tab" href="#pas" role="tab" aria-controls="pas" aria-selected="false"><i class="fas fa-eye" aria-hidden="true"></i><b>  Observaciones</b></a>
		        </li>
		    </ul>
	    </div>

		<div class="tab-content" id="myTabContent" style="width:100%;">

		<!-- INFORMACION -->
			<div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab" >
				<div class="container" style="margin-top:50px;">
				  

					<div class="form-group row">
					    <label for="fecha_ingreso_reporte" class="col-sm col-form-label text-right"><b>Fecha Ingreso:</b></label>
						    <div class="col-sm">
						  		<div class="input-group date-pick" id="fec_ing_rep" data-target-input="nearest">
						  		<input onkeypress='return caracteres_especiales_fecha(event)' type="text" name="" class="form-control datetimepicker-input "  data-target="#fec_ing_rep" id="fecha_ingreso_reporte" value="{{date('dd/mm/Y')}}" >
								<div class="input-group-append" data-target="#fec_ing_rep" data-toggle="datetimepicker">
								<div class="input-group-text"><i class="fa fa-calendar"></i></div>
								</div>
								<p id="val_fecha_ingreso_reporte" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar una Fecha de ingreso del reporte.</p>
								</div>
					    	</div>
					    	<div class="col-sm"></div>
				  	</div>


				    <div class="row">
				   		
					    <div class="col-sm text-right">
					      <label><b>Número de Reporte:</b></label>
					    </div>
					   
					    <div class="col-sm">
					        <input type="text" class="form-control " id="n_rep" placeholder="" value="{{$numero_reporte}}" disabled>
					    </div>

					    <div class="col-sm">
					          <label>Total Reportes: {{$numero_reporte - 1}}</label>
					    </div>
				  	
					</div>

					<br>
					  
					<div class="form-group row">
						<label for="frm_modalidad_seguimiento" class="col-sm-4 col-form-label text-right"><b>Modalidad Seguimiento:</b></label>
						<div class="col-sm-4">
						  	<select class="form-control" id="frm_modalidad_seguimiento">
							  	<option value="">Seleccione</option>
								<option value="0" >Revisión de plataforma</option>
								<option value="1" >Revisión de plataforma y llamados telefónicos</option>
								<option value="2" >Visita al domicilio</option>
								<!-- INICIO CZ SPRINT 59 -->
								<option value="3" >Llamado telefónico</option>
								<!-- FIN CZ SPRINT 59 -->
							</select>
						  	<p id="val_mod_rp_derv_seg" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar Modalidad de Seguimiento.</p>
						</div>
					</div>
					
					<br>

				  	<div class="text-center">
					     <button type="button" class="btn btn-outline-success" onclick="$('#pas-tab').click();cerrarFormulariosModalReporte();" >Siguiente</button>
					</div>

				</div>
			</div>
		<!-- INFORMACION -->

		{{-- <!-- PENDIENTES PAF - TAREAS Y ACCIONES -->
		    <div class="tab-pane fade" id="pen-paf-tareas" role="tabpanel" aria-labelledby="pen_paf-tab-tareas"><br>

				<!-- <div class="container"><br> -->
				<h6><b>Tareas:</b></h6>
				<p>Identificando las tareas y acciones que a la fecha están pendientes en el PAF, responda si existen avances en cada una de ellas.</p>

				<div class="table-responsive">
					<table class="table table-bordered table-hover table-striped text-center" id="tabla_acciones_tareas">
						<thead>
							<tr>
								<th>N°</th>
								<th>Tarea</th>
								<th>Modalidad de Seguimiento</th>
								<th>Fecha de Seguimiento</th>
								<th>Avances</th>
								<th>Descripción</th>
								<th>Finalizar Tarea</th>
								<th>Pasos a Seguir</th>
								<th></th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div><br>

				<div class="text-center">	
					<button  type="button" class="btn btn-outline-success" onclick="$('#info-tab').click();cerrarFormulariosModalReporte();">Anterior</button>
					<button  type="button" class="btn btn-outline-success" onclick="$('#pen_paf-tab-derivaciones').click();cerrarFormulariosModalReporte();">Siguiente</button>
				</div>

				<!-- </div>   -->

			</div>
				        
			<!-- PENDIENTES PAF - TAREAS Y ACCIONES --> --}}

			{{-- <!-- PENDIENTES PAF - DERIVACIONES -->
			<div class="tab-pane fade" id="pen_paf-derivaciones" role="tabpanel" aria-labelledby="pen_paf-tab-derivaciones"><br>
			<!-- <div class="container"><br> -->
				<h6><b>Derivaciones:</b></h6>
				<p>Respecto los servicios, prestaciones y/o beneficios que consideró tramitar el PAF en su diagnóstico, responda si existen avances en cada derivación.</p>

				<div class="table-responsive">
					<table class="table table-bordered table-hover table-striped text-center" id="tabla_derivaciones">
						<thead>
							<tr>
								<th>N°</th>
								<th>Derivaciones</th>
								<th>Modalidad de Seguimiento</th>
								<th>Fecha de Seguimiento</th>
								<th>Avances</th>
								<th>Razón</th>
								<th>Descripción</th>
								<th>Finalizar</th>
								<th>Pasos a Seguir</th>
								<th></th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
					</div>
					<br>

					<div class="text-center">	
					   	<button  type="button" class="btn btn-outline-success" onclick="$('#pen_paf-tab-tareas').click();cerrarFormulariosModalReporte();">Anterior</button>
						<button  type="button" class="btn btn-outline-success" onclick="$('#pen_ale-tab').click();cerrarFormulariosModalReporte();">Siguiente</button>
					</div>
			<!-- </div> -->	
			</div>
				        
		   <!-- PENDIENTES PAF - DERIVACIONES --> --}}

				         {{-- <!-- NUEVAS ALERTAS TERRITORIALES -->
				        <div class="tab-pane fade" id="pen_ale" role="tabpanel" aria-labelledby="pen_ale-tab"><br>

				        	<!-- <div class="container"><br> -->
					          <h6><b>Nuevas Alertas Territoriales:</b></h6>
					          <p>¿Existen nuevas alertas territoriales para alguno de los integrantes de la familia?</p>

					         	<div class="table-responsive">
									<table class="table table-bordered table-hover table-striped text-center" id="tabla_pendientes_alertas">
									<thead>
										<tr>
											<th>N°</th>
											<th>Integrante</th>
											<th>Fecha de levantamiento de Alerta</th>
											<th>Nombre Sectorialista</th>
											<th>Tipo de Alerta Territorial</th>
											<th>Pasos a Seguir</th>
											<th></th>
										</tr>
										</thead>
										<tbody></tbody>
									</table>
								</div><br>

							  	<div class="text-center">
					            	<button  type="button" class="btn btn-outline-success" onclick="$('#pen_paf-tab-derivaciones').click();cerrarFormulariosModalReporte();">Anterior</button>
					     			<button  type="button" class="btn btn-outline-success" onclick="$('#pas-tab').click();cerrarFormulariosModalReporte();">Siguiente</button>
					     		</div>

			     			<!--  </div>  -->
				        </div>
				        <!-- NUEVAS ALERTAS TERRITORIALES --> --}}

				        <!-- PASOS A SEGUIR -->
				        <div class="tab-pane fade" id="pas" role="tabpanel" aria-labelledby="pas-tab"><br>

				        <!-- 	<div class="container"><br> -->
					        	
					        	<div class="form-group">
								    <label for="exampleFormControlTextarea1"><b>Observaciones:</b></label>
								    <!-- <p>Tomando en cuenta la información recopilada en este seguimiento (pendientes del PAF, nuevas alertas), ¿cuáles son los pasos a seguir con esta familia?</p> -->

								    	<textarea maxlength="500" onkeypress='return caracteres_especiales(event)'class="form-control " name="frm_campo_pasos_a_seguir" id="frm_campo_pasos_a_seguir" rows="3" onKeyUp="valTextPasSeg()" onKeyDown="valTextPasSeg()"></textarea>

								    	 <p id="val_pas_seg" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe Ingresar observaciones.</p>

								    	<div class="row">
											<div class="col-md-12 col-lg-12">
												<h6><small class="form-text text-muted">Mínimo 3 y máximo 500 caracteres.</small></h6>
											</div>
											<div class="col-md-12 col-lg-12">
												<h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_pas_seg" style="color: #000000;">0</strong></small></h6>
											</div>
										</div>
								</div><br>
							
							  	<div class="text-center">
					            	<button  type="button" class="btn btn-outline-success" onclick="$('#info-tab').click();cerrarFormulariosModalReporte();">Anterior</button>
					     			<button id="btn_g_seg" type="button" class="btn btn-success" onclick="guardarInformacionReporte();">Guardar</button>
					     		</div>

				     	<!-- 	</div>  -->

				        </div>
				        <!-- PASOS A SEGUIR -->
		</div>
	</div>
</div>


<!-- Modal EDITAR TAREAS-->
<div class="modal fade" id="agre_tar_pen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content p-4">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar tarea</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group row">
								    <label for="frm_campo_tra_tarea" class="col-sm-4 col-form-label"><b>Tarea:</b></label>
								    <div class="col-sm-8">
								      <input type="text" class="form-control " id="frm_campo_tra_tarea" placeholder="" value="1" disabled>
								    </div>
								  </div>

								  <div class="form-group row">
								    <label for="frm_campo_tra_modalidad_seguimiento" class="col-sm-4 col-form-label"><b>Modalidad Seguimiento:</b></label>
								    <div class="col-sm-4">
								       <select class="form-control" id="frm_campo_tra_modalidad_seguimiento" >
								      		<option value="">Seleccione</option>
	  										<option value="0" >Revisión de plataforma</option>
	  										<option value="1" >Revisión de plataforma y llamados telefónicos</option>
	  										<option value="2" >Visita al domicilio</option>
										</select>
									<p id="val_mod_rp_tar_seg" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar Modalidad Seguimiento.</p>
								    </div>
								  </div>	

								<div class="form-group row">
								    <label for="colFormLabelLg" class="col-sm-4 col-form-label"><b>Fecha Ingreso:</b></label>
									    <div class="col-sm-4">
									  		<div class="input-group date-pick" id="fec_rep_tar" data-target-input="nearest">
									  		<input onkeypress='return caracteres_especiales_fecha(event)' type="text" name="" class="form-control datetimepicker-input "  data-target="#fec_rep_tar" id="fecha_reporte_tar" value="{{date('dd/mm/Y')}}" >
											<div class="input-group-append" data-target="#fec_rep_tar" data-toggle="datetimepicker">
											<div class="input-group-text"><i class="fa fa-calendar"></i></div>
											</div>
											<p id="val_fecha_reporte_tar" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar fecha ingreso.</p>
											</div>
								    	</div>
							  	</div>

								<div class="form-group row">
									<label for="frm_campo_tra_avance" class="col-sm-4 col-form-label"><b> Avances:</b></label>
									<div class="col-sm-4">
									<select class="form-control" id="frm_campo_tra_avance">
								    	<option value="">Seleccione</option>
	  									<option value="1">Si</option>
	  									<option value="0">No</option>
									</select>
									<p id="val_av_rp_tar_seg" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar el avance.</p>
								</div>

								</div>

								  <div class="form-group row">
								    <label for="frm_campo_tra_descripcion" class="col-sm-4 col-form-label"  title="Ingrese Descripción" title="Ingrese Descripción" ><b>Descripción:</b></label>
								    <div class="col-sm-8">

								      <textarea maxlength="500" onkeypress='return caracteres_especiales(event)'class="form-control " name="des_ac_tar_pen" id="frm_campo_tra_descripcion" rows="3" onKeyUp="valDesAcTarPen()" onKeyDown="valDesAcTarPen()"></textarea>
								       <p id="val_des_ac_tar_pen" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar la descripción.</p>

								       <div class="row">
											<div class="col-md-12 col-lg-6">
												<h6><small class="form-text text-muted">Mínimo 3 y máximo 500 caracteres.</small></h6>
											</div>
											<div class="col-md-12 col-lg-6">
												<h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_des_ac_tar_pen" style="color: #000000;">0</strong></small></h6>
											</div>
										</div>
								    
								    </div>
								  </div>

								<div class="form-group row">
								    <label for="frm_campo_pro_ter" class="col-sm-4 col-form-label"><b> Finalizado:</b></label>
								    <div class="col-sm-4">
										<select class="form-control" id="frm_campo_tar_ter" onchange="activarNac();">
								      		<option value="">Seleccione</option>
			  								<option value="1">Si</option>
			  								<option value="0">No</option>
										</select>
										<p id="val_frm_campo_tar_ter" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar si esta finalizado.</p>
									</div>
								</div>

								<div class="form-group row" id="mostrar_n_ac" style="display:none;">
									    <label for="frm_campo_tra_nuevas_acciones" class="col-sm-4 col-form-label"><b>Pasos a Seguir:</b></label>
								    <div class="col-sm-8">

								      <textarea maxlength="500" onkeypress='return caracteres_especiales(event)'class="form-control " name="nuev_ac_tar_pen" id="frm_campo_tra_nuevas_acciones" rows="3" onKeyUp="valNuevAcTarPen()" onKeyDown="valNuevAcTarPen()"></textarea>

								       <p id="val_nuev_ac_tar_pe" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar pasos a seguir.</p>

								      <div class="row">
										<div class="col-md-12 col-lg-6">
											<h6><small class="form-text text-muted">Mínimo 3 y máximo 500 caracteres.</small></h6>
										</div>
										<div class="col-md-12 col-lg-6">
										<h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_nuev_ac_tar_pen" style="color: #000000;">0</strong></small></h6>
												</div>
											</div>
									    </div>
								</div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="guardar_formulario_tareas">Guardar</button>
		<button type="button" class="btn btn-success" onclick="$('#agre_tar_pen').modal('hide');" >Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal EDITAR DERIVACIONES-->
<div class="modal fade" id="agre_dev_pen" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content p-4">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Editar Derivación</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        	<div class="form-group row">
									    <label for="frm_campo_pro_derivacion" class="col-sm-4 col-form-label"><b>Derivación:</b></label>
									    <div class="col-sm-8">
									      <input type="text" class="form-control " id="frm_campo_pro_derivacion" placeholder="" value="1" disabled>
									    </div>
									  </div>

									   <div class="form-group row">
									    <label for="frm_campo_pro_modalidad_seguimiento" class="col-sm-4 col-form-label"><b>Modalidad Seguimiento:</b></label>
									    <div class="col-sm-4">
									      <select class="form-control" id="frm_campo_pro_modalidad_seguimiento">
								      		<option value="">Seleccione</option>
												<option value="0" >Revisión de plataforma</option>
	  											<option value="1" >Revisión de plataforma y llamados telefónicos</option>
	  											<option value="2" >Visita al domicilio</option>
										</select>
										  <p id="val_mod_rp_derv_seg" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar Modalidad de Seguimiento.</p>
									    </div>
									  </div>


									 <div class="form-group row">
								    <label for="colFormLabelLg" class="col-sm-4 col-form-label"><b>Fecha Ingreso:</b></label>
									    <div class="col-sm-4">
									  		<div class="input-group date-pick" id="fec_rep_der" data-target-input="nearest">
									  		<input onkeypress='return caracteres_especiales_fecha(event)' type="text" name="" class="form-control datetimepicker-input "  data-target="#fec_rep_der" id="fecha_reporte_dev" value="" >
											<div class="input-group-append" data-target="#fec_rep_der" data-toggle="datetimepicker">
											<div class="input-group-text"><i class="fa fa-calendar"></i></div>
											</div>
											<p id="val_fecha_reporte_der" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar fecha ingreso.</p>
											</div>
								    	</div>
							  	</div>

									<div class="form-group row">
									    <label for="frm_campo_pro_avance" class="col-sm-4 col-form-label"><b> Avances:</b></label>
									    <div class="col-sm-4">
									      <select class="form-control" id="frm_campo_pro_avance" >
								      		<option  value="">Seleccione</option>
												<option value="1">Si</option>
												<option value="0">No</option>
										</select>
										<p id="val_av_rp_der_seg" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar Avances.</p>
									    </div>
									</div>

									<div class="form-group row" id="razon_mostrar">
										    <label for="frm_campo_pro_razon" class="col-sm-4 col-form-label"><b> Razón:</b></label>
										    <div class="col-sm-8">
										      <select class="form-control" id="frm_campo_pro_razon">
									      		<option value="">Seleccione</option>
													<option value="0">En proceso de postulación en trámite.</option>
													<option value="1">No acceso por pérdida de cupo.</option>
													<option value="2">Abandona por razones familiares.</option>
													<option value="3">Abandona por características del Programa.</option>
													<option value="4">Continúa en el programa/beneficio.</option>
											</select>
											<p id="val_raz_derv_pen" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar Razón.</p>
										    </div>
									</div>

									  <div class="form-group row">
									    <label for="frm_campo_pro_descripcion" title="Ingrese Descripción"  class="col-sm-4 col-form-label"><b>Descripción:</b></label>
									    <div class="col-sm-8">

									      <textarea maxlength="500" onkeypress='return caracteres_especiales(event)'class="form-control " name="des_derv_pen" id="frm_campo_pro_descripcion" rows="3" onKeyUp="valDesDervPen()" onKeyDown="valDesDervPen()"></textarea>
									      <p id="val_des_derv_pen" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar Descripción.</p>

									       <div class="row">
												<div class="col-md-12 col-lg-6">
													<h6><small class="form-text text-muted">Mínimo 3 y máximo 500 caracteres.</small></h6>
												</div>
												<div class="col-md-12 col-lg-6">
													<h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_derv_pen" style="color: #000000;">0</strong></small></h6>
												</div>
											</div>
									    
									    </div>
									  </div>

									  <div class="form-group row">
										    <label for="frm_campo_dev_ter" class="col-sm-4 col-form-label"><b>Finalizar pendientes:</b></label>
										    <div class="col-sm-4">
												<select class="form-control" id="frm_campo_dev_ter" onchange="activarPen();" >
										      		<option value="">Seleccione</option>
			  										<option value="1">Si</option>
			  										<option value="0">No</option>
												</select>
												<p id="val_frm_campo_dev_ter" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar si esta finalizado.</p>
									   		</div>
									  </div>

									  <div class="form-group row" style="display:none;" id="mostrar_pasos_a_seguir">
									    <label for="frm_campo_pro_nuevas_acciones" class="col-sm-4 col-form-label"><b>Pasos a Seguir:</b></label>
									    <div class="col-sm-8">
									      <textarea maxlength="500" onkeypress='return caracteres_especiales(event)'class="form-control " name="n_derv_pen" id="frm_campo_pro_nuevas_acciones" rows="3" onKeyUp="valNuevDervPen()" onKeyDown="valNuevAcTarPen()"></textarea>

									        <p id="val_n_derv_pen" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar Nuevas Acciones.</p>

									      <div class="row">
												<div class="col-md-12 col-lg-6">
													<h6><small class="form-text text-muted">Mínimo 3 y máximo 500 caracteres.</small></h6>
												</div>
												<div class="col-md-12 col-lg-6">
													<h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_n_derv_pen" style="color: #000000;">0</strong></small></h6>
												</div>
											</div>
									    </div>
									  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="guardar_formulario_programas">Guardar</button>
		<button type="button" class="btn btn-success" onclick="$('#agre_dev_pen').modal('hide');" >Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal EDITAR ALERTAS-->
<div class="modal fade" id="agre_ale_pen" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content p-4">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Editar Alerta Territorial</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group row">
									    <label for="frm_campo_ale_tipo" class="col-sm-4 col-form-label"><b>Tipo de Alerta:</b></label>
									    <div class="col-sm-8">
									      <input type="text" class="form-control " id="frm_campo_ale_tipo" name="n_rep" placeholder=""disabled >
									    </div>
								  	</div>

									<div class="form-group row">
									    <label for="frm_campo_ale_sectorialista" class="col-sm-4 col-form-label"><b>Usuario:</b></label>
									    <div class="col-sm-8">
									      <input type="text" class="form-control " id="frm_campo_ale_sectorialista" placeholder="" disabled value="">
									    </div>
								  	</div>

								  	<div class="form-group row">
									    <label for="frm_campo_ale_fec_ing" class="col-sm-4 col-form-label"><b>Fecha Ingreso:</b></label>
									    <div class="col-sm-8">

									      <input type="text" class="form-control " 
									      id="frm_campo_ale_fec_ing" placeholder="" disabled value="">
									    </div>
								  	</div>

								  	<div class="form-group row">
										    <label for="frm_campo_ale_ter" class="col-sm-4 col-form-label"><b>Finalizar pendiente:</b></label>
										    <div class="col-sm-4">
												<select class="form-control" id="frm_campo_ale_ter" onchange="activarPenAle();" >
										      		<option value="">Seleccione</option>
			  										<option value="1">Si</option>
			  										<option value="0">No</option>
												</select>
												<p id="val_frm_campo_ale_ter" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar si esta finalizado.</p>
									   		</div>
									</div>

									<div class="form-group row" style="display:none;" id="mostrar_pasos_a_seguir_ale">
									    <label for="frm_campo_ale_pasos_a_seguir" class="col-sm-4 col-form-label"><b>Pasos a Seguir:</b></label>
									    <div class="col-sm-8">
									      <textarea maxlength="500" onkeypress='return caracteres_especiales(event)'class="form-control " name="frm_campo_ale_pasos_a_seguir" id="frm_campo_ale_pasos_a_seguir" rows="3" onKeyUp="valPasSegAlePen()" onKeyDown="valPasSegAlePen()"></textarea>

									        <p id="val_frm_campo_ale_pasos_a_seguir" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar pasos a seguir.</p>

									      <div class="row">
												<div class="col-md-12 col-lg-6">
													<h6><small class="form-text text-muted">Mínimo 3 y máximo 500 caracteres.</small></h6>
												</div>
												<div class="col-md-12 col-lg-6">
													<h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_campo_ale_pasos_a_seguir" style="color: #000000;">0</strong></small></h6>
												</div>
											</div>
									    </div>
									</div>
		
								  <!-- 	<div class="form-group row">
									    <label for="frm_campo_ale_nueva" class="col-sm-4 col-form-label"><b>Nueva Alerta:</b></label>
									    <div class="col-sm-4">
									      	<select class="form-control" id="frm_campo_ale_nueva">
									      		<option value="" >Seleccione</option>
		  										<option value="1" >Si</option>
		  										<option value="0" >No</option>
											</select>
											 <p id="val_na_rp_seg" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe seleccionar Nueva Alerta.</p>
									    </div>
								  	</div>

								  	<div class="form-group row">
									    <label for="frm_campo_ale_modalidad_seguimiento" class="col-sm-4 col-form-label"><b>Modalidad Seguimiento:</b></label>
									    <div class="col-sm-4">
									   		<select class="form-control" id="frm_campo_ale_modalidad_seguimiento">
									      		<option value="" >Seleccione</option>
		  										<option value="0" >Llamada telefónica </option>
		  										<option value="1" >A través de SAN</option>
											</select>
											 <p id="val_mod_rp_seg" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe seleccionar Modalidad Seguimiento.</p>
									    </div>
								  	</div> -->

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="guardar_formulario_alertas">Guardar</button>
		<button type="button" class="btn btn-success" onclick="$('#agre_ale_pen').modal('hide');" >Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	$(function() {
			$('.date-pick').datetimepicker({
				format: 'DD/MM/Y'
			});
		});
			$(function () {
	  $('[data-toggle="popover"]').popover()
	})


	function tabFrsPaf(num){

		if (num==1){
			    $('#info').removeClass('active show');
			    $('#info-tab').removeClass('active');
    			$('#pen_paf').addClass('active show');
    			$('#pen_paf-tab').addClass('active');
		}

		if (num==2){
			    $('#info').addClass('active show');
			    $('#info-tab').addClass('active');
    			$('#pen_paf').removeClass('active show');
    			$('#pen_paf-tab').removeClass('active');
    			
		}

		if (num==3){
			    $('#pen_ale').addClass('active show');
			    $('#pen_ale-tab').addClass('active');
    			$('#pen_paf').removeClass('active show');
    			$('#pen_paf-tab').removeClass('active');
		}	

		if (num==4){
			    $('#pen_ale').removeClass('active show');
			    $('#pen_ale-tab').removeClass('active');
    			$('#pen_paf').addClass('active show');
    			$('#pen_paf-tab').addClass('active');
		}	

		if (num==5){
			    $('#pen_ale').removeClass('active show');
			    $('#pen_ale-tab').removeClass('active');
    			$('#pas').addClass('active show');
    			$('#pas-tab').addClass('active');
		}	

		if (num==6){
			    $('#pen_ale').addClass('active show');
			    $('#pen_ale-tab').addClass('active');
    			$('#pas').removeClass('active show');
    			$('#pas-tab').removeClass('active');
		}	

		if (num==7){	
    		$('#info').addClass('active show');
			$('#info-tab').addClass('active');
    		
    		$('#pen-paf-tareas').removeClass('active show');
    		$('#pen_paf-tab-tareas').removeClass('active');
    		$('#pen_paf-derivaciones').removeClass('active show');
    		$('#pen_paf-tab-derivaciones').removeClass('active');
    		$('#pen_ale').removeClass('active show');
			$('#pen_ale-tab').removeClass('active');
			$('#pas').removeClass('active show');
    		$('#pas-tab').removeClass('active');
		}	

		if (num==8){
  				
  				$('#info').removeClass('active show');
			    $('#info-tab').removeClass('active');
    			$('#pen_paf').removeClass('active show');
    			$('#pen_paf-tab').removeClass('active');
    			$('#pen_ale').removeClass('active show');
			    $('#pen_ale-tab').removeClass('active');
			    $('#pas').removeClass('active show');
    			$('#pas-tab').removeClass('active');

    			$('#pen-paf-tareas').addClass('active show');
    			$('#pen_paf-tab-tareas').addClass('active');

		}

		if (num==9){
  				
  				$('#info').removeClass('active show');
			    $('#info-tab').removeClass('active');
    			$('#pen_paf').removeClass('active show');
    			$('#pen_paf-tab').removeClass('active');
    			$('#pen_ale').removeClass('active show');
			    $('#pen_ale-tab').removeClass('active');
			    $('#pas').removeClass('active show');
    			$('#pas-tab').removeClass('active');

    			$('#pen_paf-derivaciones').addClass('active show');
    			$('#pen_paf-tab-derivaciones').addClass('active');

		}		

		if (num==10){
  				
  				$('#info').removeClass('active show');
			    $('#info-tab').removeClass('active');
    			$('#pen_paf').removeClass('active show');
    			$('#pen_paf-tab').removeClass('active');
    			$('#pen_ale').removeClass('active show');
			    $('#pen_ale-tab').removeClass('active');
			    $('#pas').removeClass('active show');
    			$('#pas-tab').removeClass('active');

    			$('#pen_ale').addClass('active show');
    			$('#pen_ale-tab').addClass('active');

		}		
	}

	contenido_textarea_pas_seg = "";
  function valTextPasSeg(){
      num_caracteres_permitidos   = 500;

      num_caracteres = $("#frm_campo_pasos_a_seguir").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#frm_campo_pasos_a_seguir").val(contenido_textarea_pas_seg);

       }else{ 
          contenido_textarea_pas_seg = $("#frm_campo_pasos_a_seguir").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_pas_seg").css("color", "#ff0000");

       }else{ 
          $("#cant_pas_seg").css("color", "#000000");

       } 

      
       $("#cant_pas_seg").text($("#frm_campo_pasos_a_seguir").val().length);
   }

   	nuev_ac_tar_pen = "";
  function valNuevAcTarPen(){
      num_caracteres_permitidos   = 500;

      num_caracteres = $("#frm_campo_tra_nuevas_acciones").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#frm_campo_tra_nuevas_acciones").val(nuev_ac_tar_pen);

       }else{ 
          nuev_ac_tar_pen = $("#frm_campo_tra_nuevas_acciones").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_nuev_ac_tar_pen").css("color", "#ff0000");

       }else{ 
          $("#cant_nuev_ac_tar_pen").css("color", "#000000");

       } 
      
       $("#cant_nuev_ac_tar_pen").text($("#frm_campo_tra_nuevas_acciones").val().length);
   }


     des_ac_tar_pen = "";
  	function valDesAcTarPen(){
      num_caracteres_permitidos   = 500;

      num_caracteres = $("#frm_campo_tra_descripcion").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#frm_campo_tra_descripcion").val(avances_ac_tar_pen);

       }else{ 
          avances_ac_tar_pen = $("#frm_campo_tra_descripcion").val();

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_des_ac_tar_pen").css("color", "#ff0000");

       }else{ 
          $("#cant_des_ac_tar_pen").css("color", "#000000");

       } 

      
       $("#cant_des_ac_tar_pen").text($("#frm_campo_tra_descripcion").val().length);
   }


 	des_derv_pen = "";
  	function valDesDervPen(){
      num_caracteres_permitidos   = 500;

      num_caracteres = $("#frm_campo_pro_descripcion").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#frm_campo_pro_descripcion").val(des_derv_pen);

       }else{ 
          des_derv_pen = $("#frm_campo_pro_descripcion").val();

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_derv_pen").css("color", "#ff0000");

       }else{ 
          $("#cant_derv_pen").css("color", "#000000");

       } 

      
       $("#cant_derv_pen").text($("#frm_campo_pro_descripcion").val().length);
   }

   n_derv_pen = "";
  	function valNuevDervPen(){
      num_caracteres_permitidos   = 500;

      num_caracteres = $("#frm_campo_pro_nuevas_acciones").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#frm_campo_pro_nuevas_acciones").val(n_derv_pen);

       }else{ 
          n_derv_pen = $("#frm_campo_pro_nuevas_acciones").val();

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_n_derv_pen").css("color", "#ff0000");

       }else{ 
          $("#cant_n_derv_pen").css("color", "#000000");

       } 

      
       $("#cant_n_derv_pen").text($("#frm_campo_pro_nuevas_acciones").val().length);
   }

    frm_campo_ale_pasos_a_seguir = "";
  	function valPasSegAlePen(){
      num_caracteres_permitidos   = 500;

      num_caracteres = $("#frm_campo_ale_pasos_a_seguir").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#frm_campo_ale_pasos_a_seguir").val(frm_campo_ale_pasos_a_seguir);

       }else{ 
          frm_campo_ale_pasos_a_seguir = $("#frm_campo_ale_pasos_a_seguir").val();

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_campo_ale_pasos_a_seguir").css("color", "#ff0000");

       }else{ 
          $("#cant_campo_ale_pasos_a_seguir").css("color", "#000000");

       } 
      
       $("#cant_campo_ale_pasos_a_seguir").text($("#frm_campo_ale_pasos_a_seguir").val().length);
   }

   
   function cerrarFormulariosModalReporte(){
   		$("#agre_tar_pen").hide();
   		$("#agre_dev_pen").hide();
   		$("#agre_ale_pen").hide();
   }


   function activarRazon(){

   		var op = $("#frm_campo_pro_avance").val();

   		if(op==0){

   			$("#razon_mostrar").show();

   		}else{

   			$("#razon_mostrar").hide();

   		}

   }

    function activarNac(){

   		var op = $("#frm_campo_tar_ter").val();

   		//alert(op);

   		if(op=='0'){

   			$("#mostrar_n_ac").show();

   		}else{

   			$("#mostrar_n_ac").hide();

   		}

   }

    function activarPen(){

   		var op = $("#frm_campo_dev_ter").val();

   		//alert(op);

   		if((op==0)&&(op!="")){

   			$("#mostrar_pasos_a_seguir").show();

   		}else{

   			$("#mostrar_pasos_a_seguir").hide();

   		}

    }


     function activarPenAle(){

   		var op = $("#frm_campo_ale_ter").val();

   		//alert(op);

   		if((op==0)&&(op!="")){

   			$("#mostrar_pasos_a_seguir_ale").show();

   		}else{

   			$("#mostrar_pasos_a_seguir_ale").hide();

   		}

    }

</script>
