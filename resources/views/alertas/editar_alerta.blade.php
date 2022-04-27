@extends('layouts.main')

@section('contenido')

<?php // dd($amOfertas); ?>

	<form name="form_alerta" method="post" action="{{ route('alertas.registrar') }}">
		{{ csrf_field() }}
		<section class=" p-1 cabecera">
			<div class="container-fluid">
				<div class="row">
					<div class="col">
						<h5> Visualizar Alerta Territorial</h5>
					</div>
				</div>
			</div>
		</section>
		
	
		<section>
			<div class="container-fluid">
				<div class="card p-4 shadow-sm">
					<div class="row">
						<div class="col-lg-12">

							<form method="post"></form>

							<form name="ingr_alert" id="ingr_alert" method="post" onsubmit="return ValidaFrm();" action="{{ route('alertas.oferta') }}">
							{{ csrf_field() }}

							<input type="hidden" id="id_ale_man" name="id_ale_man" value="{{$alertaManual[0]->ale_man_id}}">

							<input type="hidden" id="idsAlertReg" name="idsAlertReg" value="{{$idsAlertReg}}">


							 <!--  INICIO IDENTIFICACIÓN SECTORIALISTA -->
                            
                              <hr style="background-color:black;">  
                              <h5><b>I. IDENTIFICACIÓN USUARIO:</b></h5>
                                <br>
                                  <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Sector Institución:</b></label>
                                    <div class="col-sm-9">
                                      
                                     <select disabled id="dim_id" name="dim_id" class="form-control" 
                                     onchange="activaSector(this.value);">
                                       <!--  <option value="" > Seleccione Sector Institución</option> -->
                                          @foreach($dimension as $d)
                                        <option 
                                        	<?php if($alertaManual[0]->dim_id==$d->dim_id){ 
                                        		echo"selected"; } ?>
                                        	>{{$d->dim_nom}}</option>
                                          @endforeach
                                      </select>
                                      <p id="val_dim_id" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe elegir Sector Institución.</p>  
                                    </div>
                                  </div>
                                  <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Nombre Institución:</b></label>
                                    <div class="col-sm-9">
                                      <input readonly required type="input" class="form-control" value="{{$alertaManual[0]->nom_ins}}">
                                    </div>
                                  </div>
                                   <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Dirección:</b></label>
                                    <div class="col-sm-9">
                                      <input maxlength="100" readonly required id="dir_usu_nna" name="dir_usu_nna" onkeypress="return caracteres_especiales(event)" type="input" value="{{$alertaManual[0]->ale_man_dir_usu}}" class="form-control">
                                      <p id="val_dir_usu" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Ingresar una Dirección.</p>
                                    </div>
                                  
                                  </div>
                                  <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Nombre Sectorialista:</b></label>
                                    <div class="col-sm-9">
                                      <input readonly type="input" class="form-control" id="" value="{{$alertaManual[0]->responsable}}">
                                    </div>
                                  </div>
                                  <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Teléfono:</b></label>
                                    <div class="col-sm-9">
                                      <input value="{{$alertaManual[0]->telefono}}" readonly required type="input" class="form-control" id="" value="">
                                    </div>
                                  </div>

                                  
                                  <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Run:</b></label>
                                    <div class="col-sm-9">
                                      <input readonly required type="input" class="form-control" id="" value="{{$rut_completo_usu}}">
                                    </div>
                                  </div>
                                  <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Cargo:</b></label>
                                    <div class="col-sm-9">
                                      <input maxlength="100" readonly  value="{{$alertaManual[0]->ale_man_car_usu}}"required id="car_usu" name="car_usu" onkeypress="return caracteres_especiales(event)"  type="input" class="form-control ">
                                      <p id="val_car_usu" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Ingresar el Cargo.</p>  
                                    </div>
                                  </div>                        

                            <!--  FIN INICIO IDENTIFICACIÓN SECTORIALISTA -->	

                              <!--  IDENTIFICACION DEL NNA o GESTANTE -->
                            
                              <hr style="background-color:black;">   
                              <h5><b>II. IDENTIFICACION DEL NNA o GESTANTE MENOR A 18 AÑOS:</b></h5>
                                <br>
                                   <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Run:</b></label>
                                    <div class="col-sm-9">
                                      <input  readonly type="input" class="form-control" id="nna_run" name="nna_run" value="<?php print_r(Helper::devuelveRutX($rut_completo)); ?>">
                                      <p id="val_nna_run" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Ingresar el Rut del NNA o Gestante.</p>
                                    </div>
                                  </div>

                                  <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Nombre:</b></label>
                                    <div class="col-sm-9">
                                      <input  maxlength="100" readonly  onkeypress="return caracteres_especiales(event)" type="input" class="form-control " name="nna_nombre" id="nna_nombre" value="{{$nnaNombre}}">
                                         <p id="val_nna_nombre" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Ingresar el Nombre del NNA o Gestante.</p>
                                    </div>
                                  </div>
                                  <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Fecha de Nacimiento:</b></label>
                                    <div class="col-sm-9">
                                      <input maxlength="100" readonly  onkeypress="return caracteres_especiales(event)" type="input" class="form-control " id="nna_fecha_nac" name="nna_fecha_nac"  value="{{$alertaManual[0]->ale_man_nna_fec_nac}}">
                                       <p id="val_nna_fecha_nac" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Ingresar la Fecha de Nacimiento .</p>

                                    </div>
                                  </div>

                                   <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Edad:</b></label>
                                  
                                    <div class="col-sm-9">
                                      <input maxlength="100" readonly onkeypress="return caracteres_especiales(event)" value="{{$alertaManual[0]->ale_man_nna_edad}}" type="input" class="form-control " id="nna_edad" name="nna_edad">
                                         <p id="val_nna_edad" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Ingresar la Edad.</p>
                                    </div>
                                  </div>

                                  <!--  <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Meses:</b></label>
                                    
                                    <div class="col-sm-1">
                                      <input type="number" class="form-control" id="meses" nombre="meses" placeholder="Meses">
                                    </div>
                                  </div> -->
                                 
                                  <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Sexo:</b></label>
                                    <div class="col-sm-2">
                            
                                      <select  disabled class="form-control" id="nna_sexo" name="nna_sexo">
                                      <?php 
                                      if($alertaManual[0]->ale_man_nna_sexo==1)
                                      	{?>
                                      	
                                      	<option value="1">Masculino</option>
                                      		
                                  		<?php } else { ?>

                                  		<option value="2">Femenino</option>

                                      	<?php } ?>
                                          
                                      </select>
                                       <p id="val_nna_sexo" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Seleccionar el Sexo.</p>

                                    </div>
                                  </div>

                                  <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;">
                                      <b>Cuidador principal del NNA:</b>
                                    </label>
                                    <div class="col-sm-9">
                                      <input maxlength="100" readonly onkeypress="return caracteres_especiales(event)" type="input" class="form-control " id="nna_nom_cui" name="nna_nom_cui" value="{{$alertaManual[0]->ale_man_nna_nom_cui}}">
                                      <p id="val_nna_nom_cui" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Ingresar Cuidador Principal.</p>
                                    </div>
                                  </div>

                                  <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;">
                                      <b>Telefono de Cuidador Principal:</b>
                                    </label>
                                    <div class="col-sm-9">
                                      <input maxlength="100" readonly onkeypress="return caracteres_especiales(event)" type="input" class="form-control " id="nna_num_cui" name="nna_num_cui" value="{{$alertaManual[0]->ale_man_nna_num_cui}}">
                                      <p id="val_nna_num_cui" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Telefono Cuidador Principal.</p>
                                    </div>
                                  </div>
                                  <!--  FIN IDENTIFICACION DEL NNA o GESTANTE -->

                                  <!--  DIRECCIONES -->
                            
                                    <hr style="background-color:black;">   
                                    <h5><b>III. DIRECCIONES:</b></h5><br>
                                    
                                    <!-- PRIMERA PARTE SECCION DIRECCIONES -->  
                                    <div class="row">
                                      <div class="col-3">
                                        <div class="form-group row">
                                            <label class="col-form-label" style="color:#858796;">
                                              <b>Región:</b>
                                            </label>
                                            <select  disabled class="form-control" id="reg_id" name="reg_id">
                                              @foreach ($region as $v)
                                                <option value="{{$v->reg_id}}" <?php if($alertaManual[0]->reg_id==$v->reg_id){ echo"selected"; } ?> >{{$v->reg_nom}}</option>
                                              @endforeach
                                            </select>
                                            <p id="val_nna_region" style="display: none; font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Seleccionar la Región.</p>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label" style="color:#858796;">
                                              <b>Comuna:</b>
                                            </label>
                                            <select disabled class="form-control" id="com_id_nna" name="com_id_nna">
                                              @foreach ($comunas as $v)
                                                <option value="{{$v->com_id}}" <?php if($alertaManual[0]->com_id==$v->com_id){ echo"selected"; } ?> >{{$v->com_nom}}</option>
                                              @endforeach
                                            </select>
                                            <p id="val_nna_comuna" style="display: none; font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Seleccionar la Comuna.</p>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label" style="color:#858796;">
                                              <!-- <b>Calle:</b> -->
                                              <b>Calle / V&iacute;a / Camino:</b>
                                            </label>
                                            <input maxlength="100" readonly onkeypress="return caracteres_especiales(event)" value="{{$alertaManual[0]->ale_man_nna_calle}}"" type="input" class="form-control " id="nna_calle" name="nna_calle">
                                            <p id="val_nna_calle" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Ingresar la Calle.</p>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label" style="color:#858796;">
                                              <!-- <b>Número de Casa/dpto/sitio:</b> -->
                                              <b>Numeraci&oacute;n:</b>
                                            </label>
                                            <input maxlength="100" disabled type="number" onkeypress='return event.charCode >= 48 && event.charCode <= 57' class="form-control " id="nna_dir"  name="nna_dir" value="{{$alertaManual[0]->ale_man_nna_dir}}">
                                            <p id="val_nna_dir" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Ingresar la Dirección.</p>
                                        </div>
                                      </div>

                                      <div class="col-9" style="padding-left: 30px; padding-bottom: 30px;">
                                          <iframe id="mapa_AT" src="{{ $url_mapa }}" width="100%" height="100%" frameborder="0" style="border: 2px solid #3d8ece;"></iframe>
                                      </div>
                                    </div>
                                    <!-- PRIMERA PARTE SECCION DIRECCIONES -->

                                      <!-- SEGUNDA PARTE SECCION DIRECCIONES -->
                                      <div class="form-group row">
                                          <div class="col-sm-3">
                                            <label class="col-form-label" style="color:#858796; padding-bottom: 0px;"><b>Depto.</b></label><br />
                                            <small class="text-muted" style="font-size: xx-small;">Ingrese el n&uacute;mero del departamento.</small>
                                            <input maxlength="38" disabled type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57' class="form-control " id="nna_depto"  name="nna_depto" value="{{$alertaManual[0]->ale_man_nna_depto}}">
                                          </div>
                                          <div class="col-sm-3">
                                            <label class="col-form-label" style="color:#858796; padding-bottom: 0px;"><b>Block</b></label><br />
                                            <small class="text-muted" style="font-size: xx-small;">Ingrese el n&uacute;mero o la letra del block.</small>
                                            <input maxlength="38" disabled type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57' class="form-control " id="nna_block"  name="nna_block" value="{{$alertaManual[0]->ale_man_nna_block}}">
                                          </div>
                                          <div class="col-sm-3">
                                            <label class="col-form-label" style="color:#858796; padding-bottom: 0px;"><b>Casa</b></label><br />
                                            <small class="text-muted" style="font-size: xx-small;">Ingrese el n&uacute;mero de la casa.</small>
                                            <input maxlength="38" disabled type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57' class="form-control " id="nna_casa"  name="nna_casa" value="{{$alertaManual[0]->ale_man_nna_casa}}">
                                          </div>
                                          <div class="col-sm-3">
                                            <label class="col-form-label" style="color:#858796; padding-bottom: 0px;"><b>KM / Sitio</b></label><br />
                                            <small class="text-muted" style="font-size: xx-small;">Ingrese el kil&oacute;metro o el n&uacute;mero de sitio.</small>
                                            <input maxlength="38" disabled type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57' class="form-control " id="nna_km_sitio"  name="nna_km_sitio" value="{{$alertaManual[0]->ale_man_nna_km_sitio}}">
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label class="col-form-label" style="color:#858796; padding-bottom: 0px;"><b>Referencia</b></label><br />
                                          <small class="text-muted" style="font-size: xx-small;">Ay&uacute;danos a encontrar tu domicilio, ingresa alg&uacute;n punto de referencia como calle principal, barrio o zona.</small>
                                          <input maxlength="1000" disabled type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57' class="form-control col-sm-12" id="nna_ref"  name="nna_km_sitio" value="{{$alertaManual[0]->ale_man_nna_ref}}">
                                        </div>                               
                                      <br>
                                  <!--  FIN DIRECCIONES -->

                                  <!--  OTROS CONTACTOS DEL NNA -->
                            
                              <hr style="background-color:black;">   
                              <h5><b>IV. OTROS CONTACTOS DEL NNA:</b></h5>
                                <br>

                                <table class="table table-bordered table-hover table-striped" id="tabla_contactos" style="width: 100%;">
                                    <thead>
                                        <th>Nombre</th>
                                        <th>Parentesco o Relación</th>
                                        <th>Teléfono</th>
                                        <th>Dirección</th>
                                    </thead>
                                    <tbody></tbody>

                                    @foreach($contacto_nna_alert as $v)

                                    <tr>
										                  <td>{{$v->ai_ale_man_con_nom}}</td>
	                                    <td>{{$v->ai_ale_man_con_parent}}</td>
	                                    <td>{{$v->ai_ale_man_con_fon}}</td>
	                                    <td>{{$v->ai_ale_man_con_dir}}</td>
	                                </tr>

                                    @endforeach 


                                </table>
                                <br>

                         <!--    <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#frmContactos" 
                            onclick="limpiarFormularioContacto();"><i class="fa fa-plus-circle"></i> Agregar Contacto</button>
 -->
                            <!--  FIN OTROS CONTACTOS DEL NNA -->   

                            <!--  INICIO ALERTAS DETECTADAS -->
                            
                              <hr style="background-color:black;">    
                              <h5><b>V. ALERTAS DETECTADAS:</b></h5>
                                <br>
								<div class="row">
								<div class="col form-group">
									<h4><label for="">Alerta Territorial</label></h4>
									<input id="token" hidden value="{{ csrf_token() }}">
									<div class="table-responsive">
										<table class="table table-bordered table-hover" cellspacing="0" id="tabla_alertas">
											<thead>
												<tr>
													<th>#</th>
													<th>Alerta Territorial</th>
                          <th>Información Relevante Detectada</th>
												</tr>
											</thead>
											<tbody></tbody>
										</table>
									</div>
								</div>
								</div>
							
                            <!--  FIN INICIO ALERTAS DETECTADAS -->

                             <!--   <hr style="background-color:black;">    -->
                             <!--  INICIO ESCOLARIDAD NNA -->
                            <div id="sector_escolaridad" name="sector_escolaridad" style="" >
                            
                              <hr style="background-color:black;">  
                              <h5><b>VI. ESCOLARIDAD NNA:</b></h5>
                                <br>
                                  <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Establecimiento Educacional:</b></label>
                                    <div class="col-sm-9">
                                     <input maxlength="100" disabled type="input" class="form-control" id="ale_man_est_edu" name="ale_man_est_edu" value="{{$alertaManual[0]->ale_man_est_edu}}">
                                    </div>
                                  </div>
                                   <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Curso:</b></label>
                                    <div class="col-sm-9">
                                     <input maxlength="100" disabled id="ale_man_cur" name="ale_man_cur" type="input" class="form-control" value="{{$alertaManual[0]->ale_man_cur}}">
                                    </div>
                                  </div>
                                  <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Asistencia:</b></label>
                                    <div class="col-sm-9">
                                     <input maxlength="100" disabled id="ale_man_asi" name="ale_man_asi" type="input" class="form-control" value="{{$alertaManual[0]->ale_man_asi}}">
                                    </div>
                                  </div>
                                   <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Rendimiento:</b> </label>
                                    <div class="col-sm-9">
                                     <input maxlength="100" disabled type="input" class="form-control" id="ale_man_ren" name="ale_man_ren" value="{{$alertaManual[0]->ale_man_ren}}">
                                    </div>
                                  </div>
                            </div>
                            <!--  FIN ESCOLARIDAD NNA -->

                            <div id="sector_salud" name="" style="" >
                            <!--  INICIO SALUD NNA -->
                            
                              <hr style="background-color:black;">    
                              <h5><b>VII. SALUD NNA:</b></h5>
                                <br>
                                  <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Previsión:</b></label>
                                    <div class="col-sm-9">
                                     <input maxlength="100" disabled type="input" class="form-control" id="ale_man_pre" name="ale_man_pre" value="{{$alertaManual[0]->ale_man_pre}}">
                                    </div>
                                  </div>
                                   <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Centro de salud de control:</b></label>
                                    <div class="col-sm-9">
                                     <input maxlength="100" disabled type="input" class="form-control"  id="ale_man_cen_sal" name="ale_man_cen_sal" value="{{$alertaManual[0]->ale_man_cen_sal}}">
                                    </div>
                                  </div>
                                  <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Antecedentes de salud relevante:</b></label>
                                    <div class="col-sm-9">
                                     <textarea maxlength="100" disabled class="form-control" id="ale_man_ant_rel" name="ale_man_ant_rel">{{$alertaManual[0]->ale_man_ant_rel}}</textarea> 
                                    </div>
                                  </div>

                            <!--  FIN SALUD NNA -->
                            </div>

                            <!--  ANTECEDENTES FAMILIARES: -->
                              <hr style="background-color:black;">  
                              <h5><b>VIII. ANTECEDENTES FAMILIARES:</b></h5>
                                <br>
                                  <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Historia familiar:</b></label>
                                    <div class="col-sm-9">
                                      <textarea maxlength="2000" disabled onkeypress="return caracteres_especiales(event)" onKeyUp="valTextCrearAlertaHistFam()" onKeyDown="valTextCrearAlertaHistFam()"  class="form-control" id="ante_hist_fam" name="ante_hist_fam">{{$alertaManual[0]->ale_man_ante_hist_fam}}</textarea>
                                    
                                 <!--        <div class="row">
                                            <div class="col">
                                                <h6><small class"form-text text-muted">Mínimo 3 y máximo 1000 caracteres.</small></h6>
                                            </div>
                                            <div class="col text-left">
                                                <h6><small class"form-text text-muted">N° de caracteres: <strong id="cant_carac_1" style="color: #000000;">0</strong></small></h6>
                                            </div>
                                        </div>

                                         <p id="val_ante_hist_fam" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Ingrese Historia Familiar.</p> -->
                                   
                                    </div>
                                  </div>
                                   <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Aspectos del grupo familiar relevantes:</b></label>
                                    <div class="col-sm-9">
                                     <textarea maxlength="2000" disabled onkeypress="return caracteres_especiales(event)" onKeyUp="valTextCrearAlertaAnteAspec()" onKeyDown="valTextCrearAlertaAnteAspec()"  class="form-control" id="ante_aspec_fam" name="ante_aspec_fam">{{$alertaManual[0]->ale_man_ante_aspec_fam}}</textarea>  


                                       <!--  <div class="row">
                                            <div class="col">
                                                <h6><small class"form-text text-muted">Mínimo 3 y máximo 1000 caracteres.</small></h6>
                                            </div>
                                            <div class="col text-left">
                                                <h6><small class"form-text text-muted">N° de caracteres: <strong id="cant_carac_2" style="color: #000000;">0</strong></small></h6>
                                            </div>
                                        </div>

                                        <p id="val_ante_aspec_fam" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Ingrese Aspectos del grupo familiar relevantes.</p> -->
                                    </div>
                                  </div>
                                  <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label" style="color:#858796;"><b>Intervenciones y acciones previas realizadas por el profesional/sector que identifica la/las alertas:</b></label>
                                    <div class="col-sm-9">
                                      <textarea maxlength="2000" disabled onkeypress="return caracteres_especiales(event)" onKeyUp="valTextCrearAlertaAnteInterv()" onKeyDown="valTextCrearAlertaAnteInterv()"  class="form-control" id="ante_interv_fam" name="ante_interv_fam">{{$alertaManual[0]->ale_man_ante_interv_fam}}</textarea>

                                       <!--  <div class="row">
                                            <div class="col">
                                                <h6><small class"form-text text-muted">Mínimo 3 y máximo 1000 caracteres.</small></h6>
                                            </div>
                                            <div class="col text-left">
                                                <h6><small class"form-text text-muted">N° de caracteres: <strong id="cant_carac_3" style="color: #000000;">0</strong></small></h6>
                                            </div>
                                        </div>

                                        <p id="val_ante_interv_fam" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Ingrese Aspectos del grupo familiar relevantes.</p> -->

                                    </div>
                                  </div>

                            <!--  FIN ANTECEDENTES FAMILIARES:  -->

							<!--<div class="row">
								<div class="col form-group">
									<h4><label for="">Ofertas Asociadas</label></h4>
									<input id="token" hidden value="{{ csrf_token() }}">
									<div class="table-responsive">
										<table class="table table-bordered table-hover" cellspacing="0" id="tabla_ofertas">
											<thead>
												<tr>
													<th class="text-center">#</th>
													<th class="text-center">Ofertas</th>
												</tr>
											</thead>
											<tbody></tbody>
										</table>
									</div>
								</div>
							</div>

							<div class="row align-items-center">
								<div class="col-md-6">
								</div>
								<div class="col-md-6 text-right">
									<input name="btn_reg" id="btn_reg" type="submit" class="btn btn-primary btn-lg" value="Actualizar Alerta">
								</div>
							</div>-->

							</form>

						</div>
					</div>
				</div>
        <div align="right">
            <a href="#" onclick="window.history.back();" class="btn btn-primary">Regresar</a>
        </div>
			</div>
		</section>
	
@stop

@section('script')
<script type="text/javascript" src="/js/jquery.rut.chileno.min.js"></script>
<script>
$(document).ready(function () {
		cargaTipoAlerta();
		cargarDireccionMapa();
});

		function ValidaFrm() {

		 	var totalofe;

		 	totalofe = filtroOfeAsoc();

		 	if(totalofe>0){
		 		return true;
		 	}
		 	else{
		 		alert("Debe eligir ofertas asociadas para poder Modificar la alerta");
		 		return false;
		 	}

		}

		function cargaTipoAlerta(){

			id = $('#id_ale_man').val();

			tabla_alertas = $('#tabla_alertas').DataTable({
				"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
				"processing": false,
        "serverSide": false, 
    		"paging"    : false,
        "ordering"  : false,
        "searching" : false,
        "info"    : false,
				"ajax": "{{ route('alertas.tipo.reg') }}/"+id,
        "columnDefs": [ 
              {
                "targets":    0,
                "className":  'dt-head-center dt-body-center',
                "createdCell": function (td, cellData, rowData, row, col) {
                      $(td).css("vertical-align", "middle");
                      $(td).css("word-break", "break-word");
                   
                  }
              },
              {
                "targets":    1,
                "className":  'dt-head-center dt-body-center',
                "createdCell": function (td, cellData, rowData, row, col) {
                      $(td).css("vertical-align", "middle");
                      $(td).css("word-break", "break-word");
                   
                  }
              },
              {
                "targets":    2,
                "className":  'dt-head-center dt-body-left',
                "createdCell": function (td, cellData, rowData, row, col) {
                      $(td).css("vertical-align", "middle");
                      $(td).css("word-break", "break-word");
                   
                  }
              }],
				"columns": [
					{
            "data": "",
						"render": function (data, type, full, meta) {
							let html = '<input class="" disabled type="checkbox" name="ale_tip_id[]" id="ale_tip_id[]"  checked value="'+full.ale_tip_id+'">';

              return html;
						}
					},
					{ 
            "data": "ale_tip_nom" 
          },
          {
            "data": "ale_man_info_rel" 
          }]
			});

			cargaOfertas();
		
		}

		function filtroOfeAsoc(){
			var chk_com	= $('input[name="ofe_id[]"]:checked');
			total = chk_com.length;
			return total;
		}

		function cargaOfertas(obj){

			let ids = $('#idsAlertReg').val();

		    let cod_com = $('#cod_com').val();

		    let amOfertas = $('#amOfertas').val();

		    let idsAmOfe = $('#idsAmOfe').val();

		    var idsof = idsAmOfe.split(",");

			console.log(idsAmOfe);
			
			$('#tabla_ofertas').DataTable({
				"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
							/*"language": {
            	"decimal": "",
                "emptyTable": "No hay información",
        		"info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        		"infoEmpty": "Mostrando 0 de 0 Entradas",
        		"infoFiltered": "(Filtrado de _MAX_ total entradas)",
        		"infoPostFix": "",
        		"thousands": ",",
        		"lengthMenu": "Mostrar _MENU_ Entradas",
       	 		"loadingRecords": "Cargando...",
        		"processing": "Procesando...",
        		"search": "Buscar:",
        		"zeroRecords": "Sin resultados encontrados",
        		"paginate": {
            		"first": "Primero",
            		"last": "Ultimo",
            		"next": "Siguiente",
            		"previous": "Anterior"
        			}
        		},*/
				"processing": false, // for show progress bar
				"destroy": true,
    			"filter": false, // this is for disable filter (search box)
    			"orderMulti": false, // for disable multiple column at once
            	"bPaginate": false,
				"ajax": "{{ route('ofertas.tipo') }}/"+ids+"/"+cod_com,
				"columns": [
					{
						'render': function (data, type, full, meta) {

							if(idsof.indexOf(full.ofe_id)!=-1){
								var cheked="checked";
							}

							return 	'<input class="" type="checkbox" name="ofe_id[]" id="ofe_id[]" value="'+full.ofe_id+'" '+cheked+'>';
						}, "className": "text-center"
					},
					{ "data": "ofe_nom", "className": "text-left" },
				]
			});
		
		}

function cargarDireccionMapa(){
  let src = "{{ $url_mapa }}";

  let region = $("#reg_id option:selected").val();
  if (region == "" || region == null) {
    return false;
  }

  let comuna = $("#com_id_nna option:selected").val();
  if (comuna == "" || comuna == null){
    return false;
  }

  let calle = $("#nna_calle").val();
  if ((calle.replace(/ /g, "")).length == 0 || calle == null){
    return false;
  }

  let numeracion = $("#nna_dir").val();
  if ((numeracion.replace(/ /g, "")).length == 0 || numeracion == null){
      numeracion = "S/N";
  }

  let block = " "+$("#nna_block").val();
  if ((block.replace(/ /g, "")).length == 0 || block == null){
      block = "";
  }

  let depto = " "+$("#nna_depto").val();
  if ((depto.replace(/ /g, "")).length == 0 || depto == null){
      depto = "";
  }

  let casa = " "+$("#nna_casa").val();
  if ((casa.replace(/ /g, "")).length == 0 || casa == null){
      casa = "";
  }

  let km = " "+$("#nna_km_sitio").val();
  if ((km.replace(/ /g, "")).length == 0 || km == null){
      km = "";
  }

  comuna = $("#com_id_nna option:selected").text();
  region = $("#reg_id option:selected").text();
  let direccion = `${calle} ${numeracion}${block}${depto}${casa}${km}, ${comuna}, ${region}`

  $('#mapa_AT').attr('src', `${src}&dirGeoCod=${direccion}`);
} 
</script>
@stop