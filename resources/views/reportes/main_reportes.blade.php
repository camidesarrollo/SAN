@extends('layouts.main')

@section('contenido')
<!-- INICIO DC -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style type="text/css">	
.multiselect-container>li {
	width:200px;
	padding:0px;
	margin:0px;
}
.fecha_asign{
    width:200px;
}
#tabs{
    width:1000px;
}
.selReportes{
    width: 500px;
}
</style>

			<div class="container-fluid">
				<div class="row align-items-center">
					<div class="col-md-12 pt-2">
						<h5><i class="{{$icono}}"></i> Reportes</h5>
					</div>
				</div><br>

				<div class="card p-4 shadow-sm w-100">

					<div class="card p-4">
						<div class="form-group row">
							<div id="tabs">
                              <ul>
                              	@php  
                              	if(Session::get('perfil') == 2 || Session::get('perfil') == 7 || Session::get('perfil') == 10){ //coordinador, administrador central, coordinador regional
                              	@endphp
                              		<li><a href="#tabs-1">Coordinador/a</a></li>
                                	<li><a href="#tabs-2">Gestión de Casos</a></li>
                                	<li><a href="#tabs-3">Terapia Familiar</a></li>
                                	<li><a href="#tabs-4">Gestión Comunitaria</a></li>
                                @php
                              	}else if(Session::get('perfil') == 3){ //gestor
                              	@endphp
                                	<li><a href="#tabs-2">Gestión de Casos</a></li>
                                @php
                              	}else if(Session::get('perfil') == 4){ //terapeuta
                              	@endphp
                              		<li><a href="#tabs-3">Terapia Familiar</a></li>
                              	@php
                              	}else if(Session::get('perfil') == 8){ //gestor comunitario
                              	@endphp
                              		<li><a href="#tabs-4">Gestión Comunitaria</a></li>
                              	@php
								}
                              	@endphp
                              </ul>
                              @php  
                              	if(Session::get('perfil') == 2 || Session::get('perfil') == 7 || Session::get('perfil') == 10){ //coordinador o administrador central, coordinador regional
                              @endphp
                              	<div id="tabs-1">
                              	<table>
                              		<tr>
                              			<td width="238"><b>Seleccione el Reporte</b></td>
                              			<td>
                              				<select class="form-control selReportes" name="select_reportes" id="select_reportes" >
									<option value="" disabled selected>Seleccione el reporte a ejecutar...</option>
									@foreach ($acciones as $accion)	
										@if ($accion->cod_accion == "ac18")	
											<option value="1">{{ $accion->nombre }}</option>
										@endif
										@if ($accion->cod_accion == "ac19")	
											<option value="2">{{ $accion->nombre }}</option>
										@endif
										@if ($accion->cod_accion == "ac20")	
											<option value="3">{{ $accion->nombre }}</option>
										@endif
										@if ($accion->cod_accion == "ac21")	
											<option value="4">{{ $accion->nombre }}</option>
										@endif
										@if ($accion->cod_accion == "ac40")	
											<option value="18">{{ $accion->nombre }}</option>
										@endif
										@if ($accion->cod_accion == "ac22")	
											<option value="5">{{ $accion->nombre }}</option>
										@endif
										@if ($accion->cod_accion == "ac41")	
											<option value="19">{{ $accion->nombre }}</option>
										@endif										
										@if ($accion->cod_accion == "ac29")	
											<option value="12">{{ $accion->nombre }}</option>
										@endif
										@if ($accion->cod_accion == "ac30")	
											<option value="13">{{ $accion->nombre }}</option>
										@endif
										@if ($accion->cod_accion == "ac32")	
											<option value="15">{{ $accion->nombre }}</option>
										@endif
            										
									@endforeach	
								</select>
                              			</td>
                              		</tr>
                              	</table>
                                
								<br>
								<!-- INICIO FILTRO COMUNAS -->
						<div id="select_comunas_rep" class="form-group row" style="display: none;">
							<div class="col-sm-3">
								<label for="inputPassword" class="col-form-label">
									<b>Elije la(s) comuna(s)</b>
								</label>
							</div>
							<div class="col-sm-6"  >
								<select id="chkcomuna" name="chkcomuna" multiple="multiple" class="form-control chkveg" style="color: #858796;">																		
									<!-- CZ SPRINT 76 -->
								@php $getComunas = Helper::getComunas(); @endphp
								@foreach($getComunas AS $c1 => $v1)
								<!-- CZ SPRINT 76 -->
										<option value="{{$v1->com_id}}"
											@if(Session::get('perfil') != 7 || Session::get('perfil') != 10 && Session::get('com_id')==$v1->com_id)
												{{ "selected" }}
											@endif
											>{{$v1->com_nom}}</option>
									@endforeach
								</select>
							</div>								
						</div>
        						<!-- FIN FILTRO COMUNAS -->
        						<!-- INICIO FILTRO FECHA ASIGNACION-->
        						<div id="filtro_fecha_asignacion"  style="display: none;">
        							<div class="form-group row">
        								<label for="" class="col-sm-3 col-form-label"><b>Seleccione fecha asignación</b></label>
        								<div class="col-sm-9 pb-md-1">
        									<div class="input-group date-pick fecha_asign" id="per_ini_2" data-target-input="nearest">
        										<input onkeypress='return caracteres_especiales_fecha(event)' type="text" name="fecha_asig" class="form-control datetimepicker-input"  data-target="#per_ini_2" id="fecha_asig"  value="">
        										<div class="input-group-append" data-target="#per_ini_2" data-toggle="datetimepicker">
        											<div class="input-group-text"><i class="fa fa-calendar"></i></div>
        										</div>
        									</div>
        								</div>
        							</div>
        						</div>
        						<!-- FIN FILTRO FECHA ASIGNACION-->
        						<!-- INICIO FILTRO ID CASO -->
        						<div id="filtro_id_caso"  style="display: none;">
        							<div class="form-group row">
        								<label for="" class="col-sm-3 col-form-label"><b>Ingrese Nº de Caso</b></label>
        								<div class="col-sm-9 pb-md-1">
        									<div class="input-group date-pick fecha_asign"  data-target-input="nearest">
        										<input type="text" name="num_caso" class="form-control"  data-target="#num_caso" id="num_caso1"  value="">
        										<div class="input-group-append" data-target="#num_caso">
        											<div class="input-group-text"><i class="fa fa-pencil"></i></div>
        										</div>
        									</div>
        								</div>
        							</div>
        						</div>
        						<!-- FIN FILTRO ID CASO -->
        						<!-- INICIO FILTRO FECHAS -->
						<div id="filtro_fechas"  style="display: none;">
							<div class="form-group row">
								<label for="" class="col-sm-3 col-form-label"><b>Seleccione un Filtro Fecha</b></label>
								<div class="col-sm-9 pb-md-1">
        									<select class="form-control" name="filtro_fecha" id="filtro_fecha" onchange="filtroFecha(1)" >
										<option disabled selected value="">Selecciona una Opcion</option>
										<option value="0">Sin Filtro Fecha</option>
										<option value="1">Periodo Mensual</option>
										<option value="2">Rango de Fecha</option>
									</select>
									<div class="form-group row pt-3" id="contenedor_periodo_mensual">
										<div class="col-md-4">
        											<label><b>Mes</b></label>
											<div class="input-group">
												<select class="form-control" name="per_mes" id="per_mes">
												</select>
											</div>
										</div>
										<div class="col-md-4">
        											<label><b>Año</b></label>
											<div class="input-group">
												<select class="form-control" name="per_anual" id="per_anual">
												</select>
											</div>
										</div>
									</div>
									<div class="form-group row pt-3" id="contenedor_rango_fecha">
										<div class="col-md-4">
										<label>&nbsp;<b>Fecha inicio:</b></label>
											<div class="input-group date-pick" id="per_ini_" data-target-input="nearest">
        												<input onkeypress='return caracteres_especiales_fecha(event)' onblur="habilitarFechaFin(1);" type="text" name="per_ini" class="form-control datetimepicker-input"  data-target="#per_ini_" id="per_ini"  value="">
												<div class="input-group-append" data-target="#per_ini_" data-toggle="datetimepicker">
													<div class="input-group-text"><i class="fa fa-calendar"></i></div>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<label>&nbsp;<b>Fecha Fin:</b></label>
											<div class="input-group date-pick" id="per_fin_" data-target-input="nearest">
												<input onkeypress='return caracteres_especiales_fecha(event)' type="text" name="per_fin" class="form-control datetimepicker-input"  data-target="#per_fin_" id="per_fin"  value="">
												<div class="input-group-append" data-target="#per_fin_" data-toggle="datetimepicker">
													<div class="input-group-text"><i class="fa fa-calendar"></i></div>
												</div>
											</div>
										</div>
									</div>									
								</div>
							</div>
							<div class="form-group row" id="lis_tip_ale">
								<label for="" class="col-sm-3 col-form-label"><b>Seleccione Tipo de Alerta</b></label>
								<div class="col-sm-9 pb-md-1">
									<select class="form-control" name="ale_ter" id="ale_ter">
										<option value="">Selecciona una Opcion</option>										
        																			
									</select>									
								</div>
							</div>
							
						</div>
        						<!-- FIN FILTRO FECHAS -->
						<div class="row">
    								<div class="col-12 text-right"  >
    									<button type="submit" class="btn btn-success" onclick="ListarReporteXcomuna(1);">Filtrar</button>
    									<button type="submit" class="btn btn-primary" onclick="limpiarFormulario(0, 1);">Limpiar</button>
    								</div>

								</div>
                              </div>
                              <div id="tabs-2">
                                <table>
                              		<tr>
                              			<td width="238"><b>Seleccione el Reporte</b></td>
                              			<td>
                              				<select class="form-control selReportes" name="select_reportes" id="select_reportes2" >
            									<option value="" disabled selected>Seleccione el reporte a ejecutar...</option>
            									@foreach ($acciones as $accion)	
            										@if ($accion->cod_accion == "ac23")	
            											<option value="6">{{ $accion->nombre }}</option>
            										@endif
            										@if ($accion->cod_accion == "ac24")	
            											<option value="7">{{ $accion->nombre }}</option>
            										@endif
            										@if ($accion->cod_accion == "ac25")	
            											<option value="8">{{ $accion->nombre }}</option>
            										@endif
            										@if ($accion->cod_accion == "ac27")	
            											<option value="10">{{ $accion->nombre }}</option>
            										@endif										
            										@if ($accion->cod_accion == "ac31")	
            											<option value="14">{{ $accion->nombre }}</option>
            										@endif
            										@if ($accion->cod_accion == "ac32")	
            											<option value="15">{{ $accion->nombre }}</option>
            										@endif
            										@if ($accion->cod_accion == "ac33")	
            											<option value="16">{{ $accion->nombre }}</option>
            										@endif
            										@if ($accion->cod_accion == "ac48")	
            											<option value="28">{{ $accion->nombre }}</option>
            										@endif
            									@endforeach	
            								</select>
                              			</td>
                              		</tr>
                              	</table>
                              	<br>
								<!-- INICIO FILTRO COMUNAS -->
								<div id="select_comunas_rep2" class="form-group row" style="display: none;">
        							<div class="col-sm-3">
        								<label for="inputPassword" class="col-form-label">
        									<b>Elije la(s) comuna(s)</b>
        								</label>
        							</div>
        							<div class="col-sm-6"  >
        								<select id="chkcomuna2" name="chkcomuna" multiple="multiple" class="form-control chkveg" style="color: #858796;">																		
										<!-- CZ SPRINT 76 -->	
										@php $getComunas = Helper::getComunas(); @endphp
                                                    @foreach($getComunas AS $c1 => $v1)
													<!-- CZ SPRINT 76 -->
        										<option value="{{$v1->com_id}}"
        											@if(Session::get('perfil') != 7 || Session::get('perfil') != 10 && Session::get('com_id')==$v1->com_id)
        												{{ "selected" }}
        											@endif
        											>{{$v1->com_nom}}</option>
        									@endforeach
        								</select>
        							</div>								
        						</div>
        						<!-- FIN FILTRO COMUNAS -->	
        						<!-- INICIO FILTRO FECHA ASIGNACION-->
        						<div id="filtro_fecha_asignacion2"  style="display: none;">
        							<div class="form-group row">
        								<label for="" class="col-sm-3 col-form-label"><b>Seleccione fecha asignación</b></label>
        								<table>
        									<tr>
        										<td>
            										<div class="col-sm-9 pb-md-1">
                    									<div class="input-group date-pick fecha_asign" id="fec_asign_7" data-target-input="nearest">
                    										<input onkeypress='return caracteres_especiales_fecha(event)' type="text" name="fecha_asig" class="form-control datetimepicker-input"  data-target="#fecha_asig4" id="fecha_asig4"  value="" placeholder="Desde">
                    										<div class="input-group-append" data-target="#fecha_asig4" data-toggle="datetimepicker">
                    											<div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    										</div>
                    									</div>	
                    								</div>
        										</td>
        										<td>
        											<div class="col-sm-9 pb-md-1">
                    									<div class="input-group date-pick fecha_asign" id="fec_asign_8" data-target-input="nearest">
                    										<input onkeypress='return caracteres_especiales_fecha(event)' type="text" name="fecha_asig" class="form-control datetimepicker-input"  data-target="#fecha_asig5" id="fecha_asig5"  value="" placeholder="Hasta">
                    										<div class="input-group-append" data-target="#fecha_asig5" data-toggle="datetimepicker">
                    											<div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    										</div>
                    									</div>	
                    								</div>
        										</td>
        									</tr>
        								</table>
        							</div>
        						</div>
        						<!-- FIN FILTRO FECHA ASIGNACION-->
        						<!-- INICIO FILTRO ID CASO -->
        						<div id="filtro_id_caso2"  style="display: none;">
        							<div class="form-group row">
        								<label for="" class="col-sm-3 col-form-label"><b>Ingrese Nº de Caso</b></label>
        								<div class="col-sm-9 pb-md-1">
        									<div class="input-group date-pick fecha_asign"  data-target-input="nearest">
        										<input type="text" name="num_caso" class="form-control"  data-target="#num_caso" id="num_caso2"  value="">
        										<div class="input-group-append" data-target="#num_caso">
        											<div class="input-group-text"><i class="fa fa-pencil"></i></div>
        										</div>
        									</div>
        								</div>
        							</div>
        						</div>
        						<!-- FIN FILTRO ID CASO -->
        						<!-- INICIO FILTRO GESTOR-->
        						<div id="filtro_gestor2"  style="display: none;">
        							<div class="form-group row">
        								<label for="" class="col-sm-3 col-form-label"><b>Seleccione Gestor a cargo</b></label>
        								<div class="col-sm-9 pb-md-1">
        									@php $gestores = Helper::getGestores(Session::get('com_id')); @endphp
        									<select class="form-control" name="filtro_gestor" id="filtro_gestor1" >
        										<option disabled selected value="">Seleccione Gestor</option>
        										@foreach($gestores as $value)
        											<option value="{{$value->id}}">{{$value->nombre}}</option>
        										@endforeach
        									</select>
        								</div>
        							</div>
        						</div>
        						<!-- FIN FILTRO GESTOR-->
        						<!-- INICIO FILTRO FECHAS -->
        						<div id="filtro_fechas2"  style="display: none;">
        							<div class="form-group row">
        								<label for="" class="col-sm-3 col-form-label"><b>Seleccione un Filtro Fecha</b></label>
        								<div class="col-sm-9 pb-md-1">
        									<select class="form-control" name="filtro_fecha" id="filtro_fecha2" onchange="filtroFecha(2)" >
        										<option disabled selected value="">Selecciona una Opcion</option>
        										<option value="0">Sin Filtro Fecha</option>
        										<option value="1">Periodo Mensual</option>
        										<option value="2">Rango de Fecha</option>
        									</select>
        									<div class="form-group row pt-3" id="contenedor_periodo_mensual2">
        										<div class="col-md-4">
        											<label><b>Mes</b></label>
        											<div class="input-group">
        												<select class="form-control" name="per_mes" id="per_mes2">
        												</select>
        											</div>
        										</div>
        										<div class="col-md-4">
        											<label><b>Año</b></label>
        											<div class="input-group">
        												<select class="form-control" name="per_anual" id="per_anual2">
        												</select>
        											</div>
        										</div>
        									</div>
        									<div class="form-group row pt-3" id="contenedor_rango_fecha2">
        										<div class="col-md-4">
        										<label>&nbsp;<b>Fecha inicio:</b></label>
        											<div class="input-group date-pick" id="per_ini_44" data-target-input="nearest">
        												<input onkeypress='return caracteres_especiales_fecha(event)' onblur="habilitarFechaFin(2);" type="text" name="per_ini_4" class="form-control datetimepicker-input"  data-target="#per_ini_4" id="per_ini_4"  value="">
        												<div class="input-group-append" data-target="#per_ini_4" data-toggle="datetimepicker">
        													<div class="input-group-text"><i class="fa fa-calendar"></i></div>
        												</div>
        											</div>
        										</div>
        										<div class="col-md-4">
        											<label>&nbsp;<b>Fecha Fin:</b></label>
        											<div class="input-group date-pick" id="per_fin_55" data-target-input="nearest">
        												<input onkeypress='return caracteres_especiales_fecha(event)' type="text" name="per_fin" class="form-control datetimepicker-input"  data-target="#per_fin_5" id="per_fin_5"  value="">
        												<div class="input-group-append" data-target="#per_fin_5" data-toggle="datetimepicker">
        													<div class="input-group-text"><i class="fa fa-calendar"></i></div>
        												</div>
        											</div>
        										</div>
        									</div>									
        								</div>
        							</div>
        							<div class="form-group row" id="lis_tip_ale2">
        								<label for="" class="col-sm-3 col-form-label"><b>Seleccione Tipo de Alerta</b></label>
        								<div class="col-sm-9 pb-md-1">
        									<select class="form-control" name="ale_ter" id="ale_ter">
        										<option value="">Selecciona una Opcion</option>	
								
        									</select>									
        								</div>
        							</div>
								
        						</div>
        						<!-- FIN FILTRO FECHAS -->
        						<div class="row">
								<div class="col-12 text-right"  >
    									<button type="submit" class="btn btn-success" onclick="ListarReporteXcomuna(2);">Filtrar</button>
    									<button type="submit" class="btn btn-primary" onclick="limpiarFormulario(0, 2);">Limpiar</button>
								</div>

								</div>
                              </div>
                              <div id="tabs-3">
                                <table>
                              		<tr>
                              			<td width="238"><b>Seleccione el Reporte</b></td>
                              			<td>
                              				<select class="form-control selReportes" name="select_reportes" id="select_reportes3" >
            									<option value="" disabled selected>Seleccione el reporte a ejecutar...</option>
            									@foreach ($acciones as $accion)	
            										@if ($accion->cod_accion == "ac24")	
            											<option value="7">{{ $accion->nombre }}</option>
            										@endif
            										@if ($accion->cod_accion == "ac26")	
            											<option value="9">{{ $accion->nombre }}</option>
            										@endif									
            										@if ($accion->cod_accion == "ac42")	
            											<option value="20">{{ $accion->nombre }}</option>
            										@endif
            										@if ($accion->cod_accion == "ac28")	
            											<option value="11">{{ $accion->nombre }}</option>
            										@endif
            										@if ($accion->cod_accion == "ac32")	
            											<option value="15">{{ $accion->nombre }}</option>
            										@endif
            										@if ($accion->cod_accion == "ac34")	
            											<option value="17">{{ $accion->nombre }}</option>
            										@endif
            										@if ($accion->cod_accion == "ac49")	
            											<option value="29">{{ $accion->nombre }}</option>
            										@endif
            									@endforeach	
            								</select>
                              			</td>
                              		</tr>
                              	</table>
                              	<br>
								<!-- INICIO FILTRO COMUNAS -->
								<div id="select_comunas_rep3" class="form-group row" style="display: none;">
        							<div class="col-sm-3">
        								<label for="inputPassword" class="col-form-label">
        									<b>Elije la(s) comuna(s)</b>
        								</label>
        							</div>
        							<div class="col-sm-6"  >
        								<select id="chkcomuna3" name="chkcomuna" multiple="multiple" class="form-control chkveg" style="color: #858796;">																		
										<!-- CZ SPRINT 76 -->			
										@php $getComunas = Helper::getComunas(); @endphp
                                                    @foreach($getComunas AS $c1 => $v1)
													<!-- CZ SPRINT 76 -->
        										<option value="{{$v1->com_id}}"
        											@if(Session::get('perfil') != 7 || Session::get('perfil') != 10  && Session::get('com_id')==$v1->com_id)
        												{{ "selected" }}
        											@endif
        											>{{$v1->com_nom}}</option>
        									@endforeach
        								</select>
        							</div>								
        						</div>
        						<!-- FIN FILTRO COMUNAS -->	
        						<!-- INICIO FILTRO FECHA ASIGNACION-->
        						<div id="filtro_fecha_asignacion3"  style="display: none;">
        							<div class="form-group row">
        								<label for="" class="col-sm-3 col-form-label"><b>Seleccione fecha asignación</b></label>
        								<table>
        									<tr>
        										<td>
            										<div class="col-sm-9 pb-md-1">
                    									<div class="input-group date-pick fecha_asign" id="fec_asign_5" data-target-input="nearest">
                    										<input onkeypress='return caracteres_especiales_fecha(event)' type="text" name="fecha_asig" class="form-control datetimepicker-input"  data-target="#fecha_asig2" id="fecha_asig2"  value="" placeholder="Desde">
                    										<div class="input-group-append" data-target="#fecha_asig2" data-toggle="datetimepicker">
                    											<div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    										</div>
                    									</div>	
                    								</div>
        										</td>
        										<td>
        											<div class="col-sm-9 pb-md-1">
                    									<div class="input-group date-pick fecha_asign" id="fec_asign_6" data-target-input="nearest">
                    										<input onkeypress='return caracteres_especiales_fecha(event)' type="text" name="fecha_asig" class="form-control datetimepicker-input"  data-target="#fecha_asig3" id="fecha_asig3"  value="" placeholder="Hasta">
                    										<div class="input-group-append" data-target="#fecha_asig3" data-toggle="datetimepicker">
                    											<div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    										</div>
                    									</div>	
                    								</div>
        										</td>
        									</tr>
        								</table>
        							</div>
        						</div>
        						<!-- FIN FILTRO FECHA ASIGNACION-->
        						<!-- INICIO FILTRO ID CASO -->
        						<div id="filtro_id_caso3"  style="display: none;">
        							<div class="form-group row">
        								<label for="" class="col-sm-3 col-form-label"><b>Ingrese Nº de Caso</b></label>
        								<div class="col-sm-9 pb-md-1">
        									<div class="input-group date-pick fecha_asign"  data-target-input="nearest">
        										<input type="text" name="num_caso" class="form-control"  data-target="#num_caso" id="num_caso3"  value="">
        										<div class="input-group-append" data-target="#num_caso">
        											<div class="input-group-text"><i class="fa fa-pencil"></i></div>
        										</div>
        									</div>
        								</div>
        							</div>
        						</div>
        						<!-- FIN FILTRO ID CASO -->
        						<!-- INICIO FILTRO GESTOR-->
        						<div id="filtro_gestor3"  style="display: none;">
        							<div class="form-group row">
        								<label for="" class="col-sm-3 col-form-label"><b>Seleccione Terapeuta a cargo</b></label>
        								<div class="col-sm-9 pb-md-1">
        									@php $gestores = Helper::getTerapeutas(Session::get('com_id')); @endphp
        									<select class="form-control" name="filtro_gestor" id="filtro_terapeuta" >
        										<option disabled selected value="">Seleccione Terapeuta</option>
        										@foreach($gestores as $value)
        											<option value="{{$value->id}}">{{$value->nombre}}</option>
        										@endforeach
        										
        									</select>
        								</div>
        							</div>
        						</div>
        						<!-- FIN FILTRO GESTOR-->
        						<!-- INICIO FILTRO FECHAS -->
        						<div id="filtro_fechas3"  style="display: none;">
        							<div class="form-group row">
        								<label for="" class="col-sm-3 col-form-label"><b>Seleccione un Filtro Fecha</b></label>
        								<div class="col-sm-9 pb-md-1">
        									<select class="form-control" name="filtro_fecha" id="filtro_fecha3" onchange="filtroFecha(3)" >
        										<option disabled selected value="">Selecciona una Opcion</option>
        										<option value="0">Sin Filtro Fecha</option>
        										<option value="1">Periodo Mensual</option>
        										<option value="2">Rango de Fecha</option>
        									</select>
        									<div class="form-group row pt-3" id="contenedor_periodo_mensual3">
        										<div class="col-md-4">
        											<label><b>Mes</b></label>
        											<div class="input-group">
        												<select class="form-control" name="per_mes" id="per_mes3">
        												</select>
        											</div>
        										</div>
        										<div class="col-md-4">
        											<label><b>Año</b></label>
        											<div class="input-group">
        												<select class="form-control" name="per_anual" id="per_anual3">
        												</select>
        											</div>
        										</div>
        									</div>
        									<div class="form-group row pt-3" id="contenedor_rango_fecha3">
        										<div class="col-md-4">
        										<label>&nbsp;<b>Fecha inicio:</b></label>
        											<div class="input-group date-pick" id="per_ini_66" data-target-input="nearest">
        												<input onkeypress='return caracteres_especiales_fecha(event)' onblur="habilitarFechaFin(3);" type="text" name="per_ini_6" class="form-control datetimepicker-input"  data-target="#per_ini_6" id="per_ini_6"  value="">
        												<div class="input-group-append" data-target="#per_ini_6" data-toggle="datetimepicker">
        													<div class="input-group-text"><i class="fa fa-calendar"></i></div>
        												</div>
        											</div>
        										</div>
        										<div class="col-md-4">
        											<label>&nbsp;<b>Fecha Fin:</b></label>
        											<div class="input-group date-pick" id="per_fin_77" data-target-input="nearest">
        												<input onkeypress='return caracteres_especiales_fecha(event)' type="text" name="per_fin" class="form-control datetimepicker-input"  data-target="#per_fin_7" id="per_fin_7"  value="">
        												<div class="input-group-append" data-target="#per_fin_7" data-toggle="datetimepicker">
        													<div class="input-group-text"><i class="fa fa-calendar"></i></div>
        												</div>
        											</div>
        										</div>
        									</div>									
        								</div>
        							</div>
        							<div class="form-group row" id="lis_tip_ale3">
        								<label for="" class="col-sm-3 col-form-label"><b>Seleccione Tipo de Alerta</b></label>
        								<div class="col-sm-9 pb-md-1">
        									<select class="form-control" name="ale_ter" id="ale_ter">
        										<option value="">Selecciona una Opcion</option>	
        																			
        									</select>									
        								</div>
        							</div>
							
        						</div>
        						<!-- FIN FILTRO FECHAS -->
        						<div class="row">
    								<div class="col-12 text-right"  >
    									<button type="submit" class="btn btn-success" onclick="ListarReporteXcomuna(3);">Filtrar</button>
    									<button type="submit" class="btn btn-primary" onclick="limpiarFormulario(0, 3);">Limpiar</button>
    								</div>

						</div>
                              </div>
                              
                              <div id="tabs-4">
                                <table>
                              		<tr>
                              			<td width="238"><b>Seleccione el Reporte</b></td>
                              			<td>
                              				<select class="form-control selReportes" name="select_reportes" id="select_reportes4" >
            									<option value="" disabled selected>Seleccione el reporte a ejecutar...</option>
            									@foreach ($acciones as $accion)	
            										@if ($accion->cod_accion == "ac47")	
            											<option value="27">{{ $accion->nombre }}</option>
            										@endif
            										@if ($accion->cod_accion == "ac46")	
            											<option value="26">{{ $accion->nombre }}</option>
            										@endif
            										@if ($accion->cod_accion == "ac45")	
            											<option value="25">{{ $accion->nombre }}</option>
            										@endif
            										@if ($accion->cod_accion == "ac43")	
            											<option value="23">{{ $accion->nombre }}</option>
            										@endif
            										@if ($accion->cod_accion == "ac44")	
            											<option value="24">{{ $accion->nombre }}</option>
            										@endif
            									@endforeach	
            								</select>
                              			</td>
                              		</tr>
                              	</table>
                              	<br>
								<!-- INICIO FILTRO COMUNAS -->
								<div id="select_comunas_rep4" class="form-group row" style="display: none;">
        							<div class="col-sm-3">
        								<label for="inputPassword" class="col-form-label">
        									<b>Elije la(s) comuna(s)</b>
        								</label>
        							</div>
        							<div class="col-sm-6"  >
        								<select id="chkcomuna4" name="chkcomuna" multiple="multiple" class="form-control chkveg" style="color: #858796;">																		
										<!-- CZ SPRINT 76 -->		
										@php $getComunas = Helper::getComunas(); @endphp
                                                @foreach($getComunas AS $c1 => $v1)<!-- CZ SPRINT 76 -->
        										<option value="{{$v1->com_id}}"
        											@if(Session::get('perfil') != 7 || Session::get('perfil') != 10  && Session::get('com_id')==$v1->com_id)
        												{{ "selected" }}
        											@endif
        											>{{$v1->com_nom}}</option>
        									@endforeach
        								</select>
        							</div>								
        						</div>
        						<!-- FIN FILTRO COMUNAS -->	
        						
        						<div class="row">
    								<div class="col-12 text-right"  >
    									<button type="submit" class="btn btn-success" onclick="ListarReporteXcomuna(4);">Filtrar</button>
    									<button type="submit" class="btn btn-primary" onclick="limpiarFormulario(0, 4);">Limpiar</button>
    								</div>

								</div>
                              </div>
                              @php  
                              	}else if(Session::get('perfil') == 3){ //gestor
                              @endphp
                              <div id="tabs-2">
                                <table>
                              		<tr>
                              			<td width="238"><b>Seleccione el Reporte</b></td>
                              			<td>
                              				<select class="form-control selReportes" name="select_reportes" id="select_reportes2" >
            									<option value="" disabled selected>Seleccione el reporte a ejecutar...</option>
            									@foreach ($acciones as $accion)	
            										@if ($accion->cod_accion == "ac23")	
            											<option value="6">{{ $accion->nombre }}</option>
            										@endif
            										@if ($accion->cod_accion == "ac24")	
            											<option value="7">{{ $accion->nombre }}</option>
            										@endif
            										@if ($accion->cod_accion == "ac25")	
            											<option value="8">{{ $accion->nombre }}</option>
            										@endif
            										@if ($accion->cod_accion == "ac27")	
            											<option value="10">{{ $accion->nombre }}</option>
            										@endif										
            										@if ($accion->cod_accion == "ac31")	
            											<option value="14">{{ $accion->nombre }}</option>
            										@endif
            										@if ($accion->cod_accion == "ac32")	
            											<option value="15">{{ $accion->nombre }}</option>
            										@endif
            										@if ($accion->cod_accion == "ac33")	
            											<option value="16">{{ $accion->nombre }}</option>
            										@endif
            										@if ($accion->cod_accion == "ac48")	
            											<option value="28">{{ $accion->nombre }}</option>
            										@endif
            									@endforeach	
            								</select>
                              			</td>
                              		</tr>
                              	</table>
                              	<br>
								<!-- INICIO FILTRO COMUNAS -->
								<div id="select_comunas_rep2" class="form-group row" style="display: none;">
        							<div class="col-sm-3">
        								<label for="inputPassword" class="col-form-label">
        									<b>Elije la(s) comuna(s)</b>
        								</label>
        							</div>
        							<div class="col-sm-6"  >
        								<select id="chkcomuna2" name="chkcomuna" multiple="multiple" class="form-control chkveg" style="color: #858796;">																		
											@php $getComunas = Helper::getComunas(); @endphp<!-- CZ SPRINT 76 -->
                                            @foreach($getComunas AS $c1 => $v1)<!-- CZ SPRINT 76 -->
        										<option value="{{$v1->com_id}}"
        											@if(Session::get('perfil') != 7 || Session::get('perfil') != 10  && Session::get('com_id')==$v1->com_id)
        												{{ "selected" }}
        											@endif
        											>{{$v1->com_nom}}</option>
        									@endforeach
        								</select>
        							</div>								
        						</div>
        						<!-- FIN FILTRO COMUNAS -->	
        						<!-- INICIO FILTRO FECHA ASIGNACION-->
        						<div id="filtro_fecha_asignacion2"  style="display: none;">
        							<div class="form-group row">
        								<label for="" class="col-sm-3 col-form-label"><b>Seleccione fecha asignación</b></label>
        								<table>
        									<tr>
        										<td>
            										<div class="col-sm-9 pb-md-1">
                    									<div class="input-group date-pick fecha_asign" id="fec_asign_7" data-target-input="nearest">
                    										<input onkeypress='return caracteres_especiales_fecha(event)' type="text" name="fecha_asig" class="form-control datetimepicker-input"  data-target="#fecha_asig4" id="fecha_asig4"  value="" placeholder="Desde">
                    										<div class="input-group-append" data-target="#fecha_asig4" data-toggle="datetimepicker">
                    											<div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    										</div>
                    									</div>	
                    								</div>
        										</td>
        										<td>
        											<div class="col-sm-9 pb-md-1">
                    									<div class="input-group date-pick fecha_asign" id="fec_asign_8" data-target-input="nearest">
                    										<input onkeypress='return caracteres_especiales_fecha(event)' type="text" name="fecha_asig" class="form-control datetimepicker-input"  data-target="#fecha_asig5" id="fecha_asig5"  value="" placeholder="Hasta">
                    										<div class="input-group-append" data-target="#fecha_asig5" data-toggle="datetimepicker">
                    											<div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    										</div>
                    									</div>	
                    								</div>
        										</td>
        									</tr>
        								</table>
        							</div>
        						</div>
        						<!-- FIN FILTRO FECHA ASIGNACION-->
        						<!-- INICIO FILTRO ID CASO -->
        						<div id="filtro_id_caso2"  style="display: none;">
        							<div class="form-group row">
        								<label for="" class="col-sm-3 col-form-label"><b>Ingrese Nº de Caso</b></label>
        								<div class="col-sm-9 pb-md-1">
        									<div class="input-group date-pick fecha_asign"  data-target-input="nearest">
        										<input type="text" name="num_caso" class="form-control"  data-target="#num_caso" id="num_caso2"  value="">
        										<div class="input-group-append" data-target="#num_caso">
        											<div class="input-group-text"><i class="fa fa-pencil"></i></div>
        										</div>
        									</div>
        								</div>
        							</div>
        						</div>
        						<!-- FIN FILTRO ID CASO -->
        						<!-- INICIO FILTRO GESTOR-->
        						<div id="filtro_gestor2"  style="display: none;">
        							<div class="form-group row">
        								<label for="" class="col-sm-3 col-form-label"><b>Seleccione Gestor a cargo</b></label>
        								<div class="col-sm-9 pb-md-1">
        									@php $gestores = Helper::getGestores(Session::get('com_id')); @endphp
        									<select class="form-control" name="filtro_gestor" id="filtro_gestor1" >
        										<option disabled selected value="">Seleccione Gestor</option>
        										@foreach($gestores as $value)
        											<option value="{{$value->id}}">{{$value->nombre}}</option>
        										@endforeach
        									</select>
        								</div>
        							</div>
        						</div>
        						<!-- FIN FILTRO GESTOR-->
        						<!-- INICIO FILTRO FECHAS -->
        						<div id="filtro_fechas2"  style="display: none;">
        							<div class="form-group row">
        								<label for="" class="col-sm-3 col-form-label"><b>Seleccione un Filtro Fecha</b></label>
        								<div class="col-sm-9 pb-md-1">
        									<select class="form-control" name="filtro_fecha" id="filtro_fecha2" onchange="filtroFecha(2)" >
        										<option disabled selected value="">Selecciona una Opcion</option>
        										<option value="0">Sin Filtro Fecha</option>
        										<option value="1">Periodo Mensual</option>
        										<option value="2">Rango de Fecha</option>
        									</select>
        									<div class="form-group row pt-3" id="contenedor_periodo_mensual2">
        										<div class="col-md-4">
        											<label><b>Mes</b></label>
        											<div class="input-group">
        												<select class="form-control" name="per_mes" id="per_mes2">
        												</select>
        											</div>
        										</div>
        										<div class="col-md-4">
        											<label><b>Año</b></label>
        											<div class="input-group">
        												<select class="form-control" name="per_anual" id="per_anual2">
        												</select>
        											</div>
        										</div>
        									</div>
        									<div class="form-group row pt-3" id="contenedor_rango_fecha2">
        										<div class="col-md-4">
        										<label>&nbsp;<b>Fecha inicio:</b></label>
        											<div class="input-group date-pick" id="per_ini_44" data-target-input="nearest">
        												<input onkeypress='return caracteres_especiales_fecha(event)' onblur="habilitarFechaFin(2);" type="text" name="per_ini_4" class="form-control datetimepicker-input"  data-target="#per_ini_4" id="per_ini_4"  value="">
        												<div class="input-group-append" data-target="#per_ini_4" data-toggle="datetimepicker">
        													<div class="input-group-text"><i class="fa fa-calendar"></i></div>
        												</div>
        											</div>
        										</div>
        										<div class="col-md-4">
        											<label>&nbsp;<b>Fecha Fin:</b></label>
        											<div class="input-group date-pick" id="per_fin_55" data-target-input="nearest">
        												<input onkeypress='return caracteres_especiales_fecha(event)' type="text" name="per_fin" class="form-control datetimepicker-input"  data-target="#per_fin_5" id="per_fin_5"  value="">
        												<div class="input-group-append" data-target="#per_fin_5" data-toggle="datetimepicker">
        													<div class="input-group-text"><i class="fa fa-calendar"></i></div>
        												</div>
        											</div>
        										</div>
        									</div>									
        								</div>
        							</div>
        							<div class="form-group row" id="lis_tip_ale2">
        								<label for="" class="col-sm-3 col-form-label"><b>Seleccione Tipo de Alerta</b></label>
        								<div class="col-sm-9 pb-md-1">
        									<select class="form-control" name="ale_ter" id="ale_ter">
        										<option value="">Selecciona una Opcion</option>	
        																			
        									</select>									
        								</div>
        							</div>
        							
        						</div>
        						<!-- FIN FILTRO FECHAS -->
        						<div class="row">
    								<div class="col-12 text-right"  >
    									<button type="submit" class="btn btn-success" onclick="ListarReporteXcomuna(2);">Filtrar</button>
    									<button type="submit" class="btn btn-primary" onclick="limpiarFormulario(0, 2);">Limpiar</button>
    								</div>

					</div>
                              </div>
                              @php
                              	}else if(Session::get('perfil') == 4){ //terapeuta
                              @endphp
                              <div id="tabs-3">
                                <table>
                              		<tr>
                              			<td width="238"><b>Seleccione el Reporte</b></td>
                              			<td>
                              				<select class="form-control selReportes" name="select_reportes" id="select_reportes3" >
            									<option value="" disabled selected>Seleccione el reporte a ejecutar...</option>
            									@foreach ($acciones as $accion)	
            										@if ($accion->cod_accion == "ac24")	
            											<option value="7">{{ $accion->nombre }}</option>
            										@endif
            										@if ($accion->cod_accion == "ac26")	
            											<option value="9">{{ $accion->nombre }}</option>
            										@endif									
            										@if ($accion->cod_accion == "ac42")	
            											<option value="20">{{ $accion->nombre }}</option>
            										@endif
            										@if ($accion->cod_accion == "ac28")	
            											<option value="11">{{ $accion->nombre }}</option>
            										@endif
            										@if ($accion->cod_accion == "ac32")	
            											<option value="15">{{ $accion->nombre }}</option>
            										@endif
            										@if ($accion->cod_accion == "ac34")	
            											<option value="17">{{ $accion->nombre }}</option>
            										@endif
            										@if ($accion->cod_accion == "ac49")	
            											<option value="29">{{ $accion->nombre }}</option>
            										@endif
            									@endforeach	
            								</select>
                              			</td>
                              		</tr>
                              	</table>
                              	<br>
								<!-- INICIO FILTRO COMUNAS -->
								<div id="select_comunas_rep3" class="form-group row" style="display: none;">
        							<div class="col-sm-3">
        								<label for="inputPassword" class="col-form-label">
        									<b>Elije la(s) comuna(s)</b>
        								</label>
        							</div>
        							<div class="col-sm-6"  >
        								<select id="chkcomuna3" name="chkcomuna" multiple="multiple" class="form-control chkveg" style="color: #858796;">																		
											@php $getComunas = Helper::getComunas(); @endphp<!-- CZ SPRINT 76 -->
                                            @foreach($getComunas AS $c1 => $v1)<!-- CZ SPRINT 76 -->
        										<option value="{{$v1->com_id}}"
        											@if(Session::get('perfil') != 7 || Session::get('perfil') != 10  && Session::get('com_id')==$v1->com_id)
        												{{ "selected" }}
        											@endif
        											>{{$v1->com_nom}}</option>
        									@endforeach
        								</select>
        							</div>								
        						</div>
        						<!-- FIN FILTRO COMUNAS -->	
        						<!-- INICIO FILTRO FECHA ASIGNACION-->
        						<div id="filtro_fecha_asignacion3"  style="display: none;">
        							<div class="form-group row">
        								<label for="" class="col-sm-3 col-form-label"><b>Seleccione fecha asignación</b></label>
        								<table>
        									<tr>
        										<td>
            										<div class="col-sm-9 pb-md-1">
                    									<div class="input-group date-pick fecha_asign" id="fec_asign_5" data-target-input="nearest">
                    										<input onkeypress='return caracteres_especiales_fecha(event)' type="text" name="fecha_asig" class="form-control datetimepicker-input"  data-target="#fecha_asig2" id="fecha_asig2"  value="" placeholder="Desde">
                    										<div class="input-group-append" data-target="#fecha_asig2" data-toggle="datetimepicker">
                    											<div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    										</div>
                    									</div>	
                    								</div>
        										</td>
        										<td>
        											<div class="col-sm-9 pb-md-1">
                    									<div class="input-group date-pick fecha_asign" id="fec_asign_6" data-target-input="nearest">
                    										<input onkeypress='return caracteres_especiales_fecha(event)' type="text" name="fecha_asig" class="form-control datetimepicker-input"  data-target="#fecha_asig3" id="fecha_asig3"  value="" placeholder="Hasta">
                    										<div class="input-group-append" data-target="#fecha_asig3" data-toggle="datetimepicker">
                    											<div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    										</div>
                    									</div>	
                    								</div>
        										</td>
        									</tr>
        								</table>
        							</div>
        						</div>
        						<!-- FIN FILTRO FECHA ASIGNACION-->
        						<!-- INICIO FILTRO ID CASO -->
        						<div id="filtro_id_caso3"  style="display: none;">
        							<div class="form-group row">
        								<label for="" class="col-sm-3 col-form-label"><b>Ingrese Nº de Caso</b></label>
        								<div class="col-sm-9 pb-md-1">
        									<div class="input-group date-pick fecha_asign"  data-target-input="nearest">
        										<input type="text" name="num_caso" class="form-control"  data-target="#num_caso" id="num_caso3"  value="">
        										<div class="input-group-append" data-target="#num_caso">
        											<div class="input-group-text"><i class="fa fa-pencil"></i></div>
        										</div>
        									</div>
        								</div>
        							</div>
        						</div>
        						<!-- FIN FILTRO ID CASO -->
        						<!-- INICIO FILTRO GESTOR-->
        						<div id="filtro_gestor3"  style="display: none;">
        							<div class="form-group row">
        								<label for="" class="col-sm-3 col-form-label"><b>Seleccione Terapeuta a cargo</b></label>
        								<div class="col-sm-9 pb-md-1">
        									@php $gestores = Helper::getTerapeutas(Session::get('com_id')); @endphp
        									<select class="form-control" name="filtro_gestor" id="filtro_terapeuta" >
        										<option disabled selected value="">Seleccione Terapeuta</option>
        										@foreach($gestores as $value)
        											<option value="{{$value->id}}">{{$value->nombre}}</option>
        										@endforeach
        									</select>
        								</div>
        							</div>
        						</div>
        						<!-- FIN FILTRO GESTOR-->
        						<!-- INICIO FILTRO FECHAS -->
        						<div id="filtro_fechas3"  style="display: none;">
        							<div class="form-group row">
        								<label for="" class="col-sm-3 col-form-label"><b>Seleccione un Filtro Fecha</b></label>
        								<div class="col-sm-9 pb-md-1">
        									<select class="form-control" name="filtro_fecha" id="filtro_fecha3" onchange="filtroFecha(3)" >
        										<option disabled selected value="">Selecciona una Opcion</option>
        										<option value="0">Sin Filtro Fecha</option>
        										<option value="1">Periodo Mensual</option>
        										<option value="2">Rango de Fecha</option>
        									</select>
        									<div class="form-group row pt-3" id="contenedor_periodo_mensual3">
        										<div class="col-md-4">
        											<label><b>Mes</b></label>
        											<div class="input-group">
        												<select class="form-control" name="per_mes" id="per_mes3">
        												</select>
        											</div>
        										</div>
        										<div class="col-md-4">
        											<label><b>Año</b></label>
        											<div class="input-group">
        												<select class="form-control" name="per_anual" id="per_anual3">
        												</select>
        											</div>
        										</div>
        									</div>
        									<div class="form-group row pt-3" id="contenedor_rango_fecha3">
        										<div class="col-md-4">
        										<label>&nbsp;<b>Fecha inicio:</b></label>
        											<div class="input-group date-pick" id="per_ini_66" data-target-input="nearest">
        												<input onkeypress='return caracteres_especiales_fecha(event)' onblur="habilitarFechaFin(3);" type="text" name="per_ini_6" class="form-control datetimepicker-input"  data-target="#per_ini_6" id="per_ini_6"  value="">
        												<div class="input-group-append" data-target="#per_ini_6" data-toggle="datetimepicker">
        													<div class="input-group-text"><i class="fa fa-calendar"></i></div>
        												</div>
        											</div>
        										</div>
        										<div class="col-md-4">
        											<label>&nbsp;<b>Fecha Fin:</b></label>
        											<div class="input-group date-pick" id="per_fin_77" data-target-input="nearest">
        												<input onkeypress='return caracteres_especiales_fecha(event)' type="text" name="per_fin" class="form-control datetimepicker-input"  data-target="#per_fin_7" id="per_fin_7"  value="">
        												<div class="input-group-append" data-target="#per_fin_7" data-toggle="datetimepicker">
        													<div class="input-group-text"><i class="fa fa-calendar"></i></div>
        												</div>
        											</div>
        										</div>
        									</div>									
        								</div>
        							</div>
        							<div class="form-group row" id="lis_tip_ale3">
        								<label for="" class="col-sm-3 col-form-label"><b>Seleccione Tipo de Alerta</b></label>
        								<div class="col-sm-9 pb-md-1">
        									<select class="form-control" name="ale_ter" id="ale_ter">
        										<option value="">Selecciona una Opcion</option>	
        																			
        									</select>									
        								</div>
        							</div>
        							
        						</div>
        						<!-- FIN FILTRO FECHAS -->
        						<div class="row">
    								<div class="col-12 text-right"  >
    									<button type="submit" class="btn btn-success" onclick="ListarReporteXcomuna(3);">Filtrar</button>
    									<button type="submit" class="btn btn-primary" onclick="limpiarFormulario(0, 3);">Limpiar</button>
    								</div>

								</div>
                              </div>
                              @php
                              	}else if(Session::get('perfil') == 8){ //gestion comunitaria
                              @endphp
                              <div id="tabs-4">
                                <table>
                              		<tr>
                              			<td width="238"><b>Seleccione el Reporte</b></td>
                              			<td>
                              				<select class="form-control selReportes" name="select_reportes" id="select_reportes4" >
            									<option value="" disabled selected>Seleccione el reporte a ejecutar...</option>
            									@foreach ($acciones as $accion)	
            										@if ($accion->cod_accion == "ac47")	
            											<option value="27">{{ $accion->nombre }}</option>
            										@endif
            										@if ($accion->cod_accion == "ac46")	
            											<option value="26">{{ $accion->nombre }}</option>
            										@endif
            										@if ($accion->cod_accion == "ac45")	
            											<option value="25">{{ $accion->nombre }}</option>
            										@endif
            										@if ($accion->cod_accion == "ac43")	
            											<option value="23">{{ $accion->nombre }}</option>
            										@endif
            										@if ($accion->cod_accion == "ac44")	
            											<option value="24">{{ $accion->nombre }}</option>
            										@endif
            									@endforeach	
            								</select>
                              			</td>
                              		</tr>
                              	</table>
                              	<br>
								<!-- INICIO FILTRO COMUNAS -->
								<div id="select_comunas_rep4" class="form-group row" style="display: none;">
        							<div class="col-sm-3">
        								<label for="inputPassword" class="col-form-label">
        									<b>Elije la(s) comuna(s)</b>
        								</label>
        							</div>
        							<div class="col-sm-6"  >
        								<select id="chkcomuna4" name="chkcomuna" multiple="multiple" class="form-control chkveg" style="color: #858796;">																		
											@php $getComunas = Helper::getComunas(); @endphp<!-- CZ SPRINT 76 -->
                                            @foreach($getComunas AS $c1 => $v1)<!-- CZ SPRINT 76 -->
        										<option value="{{$v1->com_id}}"
        											@if(Session::get('perfil') != 7 || Session::get('perfil') != 10  && Session::get('com_id')==$v1->com_id)
        												{{ "selected" }}
        											@endif
        											>{{$v1->com_nom}}</option>
        									@endforeach
        								</select>
        							</div>								
        						</div>
        						<!-- FIN FILTRO COMUNAS -->	
        						
        						<div class="row">
    								<div class="col-12 text-right"  >
    									<button type="submit" class="btn btn-success" onclick="ListarReporteXcomuna(4);">Filtrar</button>
    									<button type="submit" class="btn btn-primary" onclick="limpiarFormulario(0, 4);">Limpiar</button>
    								</div>

								</div>
                              </div>
                              
                              @php
                              	}
                              @endphp
                              
                            </div>	
						</div>
					</div>
					<!-- REPORTES -->
					
                            <div class="card p-4" id="reporte-contenido"  style="display: none"></div>										
                    
					<!-- REPORTES -->
			</div>
			<input id="comunaIngresada" name="prodId" type="hidden" value="{{$comuna_ingresada}}">
			<input id="perfilUsuario" name="prodId" type="hidden" value="{{$perfil_usuario}}">
		</div>
<!-- FIN DC -->
@endsection

@section('script')
	<script type="text/javascript">

		$(function() {
		    $('.chkveg').multiselect({
		        includeSelectAllOption: false     
		    });
		    //INICIO DC
			$('#contenedor_periodo_mensual').hide()
			$('#contenedor_rango_fecha').hide()
			$('#contenedor_periodo_mensual2').hide()
			$('#contenedor_rango_fecha2').hide()
			$('#contenedor_periodo_mensual3').hide()
			$('#contenedor_rango_fecha3').hide()
			$('#lis_tip_ale').hide()
			$('#lis_tip_ale2').hide()
			$('#lis_tip_ale3').hide()	
			getAlertaTerritorial();
			$( "#tabs" ).tabs();
			//FIN DC
		});

		$( document ).ready(function() {
			//INICIO DC
			$('#select_reportes').change(function(){
				habilitarFiltros(1, 1); 
			});
			$('#select_reportes2').change(function(){
				habilitarFiltros(1, 2); 
			});
			$('#select_reportes3').change(function(){
				habilitarFiltros(1, 3); 
			});
			$('#select_reportes4').change(function(){
				habilitarFiltros(1, 4); 
			});
			$('#chkcomuna').change(function(){
				habilitarFiltros(2, 1); 
			});
			$('#chkcomuna2').change(function(){
				habilitarFiltros(2, 2); 
			});
			$('#chkcomuna3').change(function(){
				habilitarFiltros(2, 3); 
			});
			$('#chkcomuna4').change(function(){
				habilitarFiltros(2, 4); 
			});
			$('#per_ini_').datetimepicker('format', 'DD/MM/Y');
			$('#per_fin_').datetimepicker('format', 'DD/MM/Y');
			$('#per_ini_2').datetimepicker('format', 'DD/MM/Y');
			$('#per_ini_3').datetimepicker('format', 'DD/MM/Y');
			$('#per_ini_4').datetimepicker('format', 'DD/MM/Y');
			$('#per_fin_5').datetimepicker('format', 'DD/MM/Y');
			$('#per_ini_6').datetimepicker('format', 'DD/MM/Y');
			$('#per_fin_7').datetimepicker('format', 'DD/MM/Y');
			$('#fecha_asig2').datetimepicker('format', 'DD/MM/Y');
			$('#fecha_asig3').datetimepicker('format', 'DD/MM/Y');
			$('#fecha_asig4').datetimepicker('format', 'DD/MM/Y');
			$('#fecha_asig5').datetimepicker('format', 'DD/MM/Y');
			$('#per_fin').prop('disabled',true);
			$('#per_fin_5').prop('disabled',true);
			$('#per_fin_7').prop('disabled',true);	
			//FIN DC
		});

		function desplegarListadoAlerta(opcion, tipo){
			limpiarFormFiltro(1);
				//INICIO DC
				if(tipo == 1){ //COORDINADOR
				if((opcion == 2) || (opcion == 4) || (opcion == 5)){
					$('#filtro_fechas').show().fadeIn(1000);
					$('#lis_tip_ale').show().fadeIn(1000);
    					periodoMensual(1);
    				}else if((opcion == 18) || (opcion == 19) || (opcion == 12) || (opcion == 3) || (opcion == 23) || (opcion == 24) || (opcion == 25) || (opcion == 26) || (opcion == 27) || (opcion == 28)){
					$('#filtro_fechas').hide().fadeOut(1000);
				}else{
					$('#filtro_fechas').show().fadeIn(1000);
					$('#lis_tip_ale').hide().fadeOut(1000);
    					periodoMensual(1);
    				}
				}else if(tipo == 2){ //GESTION DE CASOS
					
					if((opcion == 2) || (opcion == 4) || (opcion == 5)){
    					$('#filtro_fechas2').show().fadeIn(1000);
    					$('#lis_tip_ale2').show().fadeIn(1000);
    					periodoMensual(2);
    				}else if((opcion == 18) || (opcion == 19) || (opcion == 12) || (opcion == 3) || (opcion == 23) || (opcion == 24) || (opcion == 25) || (opcion == 26) || (opcion == 27) || (opcion == 28) || (opcion == 29)){
    					$('#filtro_fechas2').hide().fadeOut(1000);
    				}else{
    					$('#filtro_fechas2').show().fadeIn(1000);
    					$('#lis_tip_ale2').hide().fadeOut(1000);
    					periodoMensual(2);
    				}
				}else if(tipo == 3){ //TERAPIA FAMILIAR
					if((opcion == 2) || (opcion == 4) || (opcion == 5)){
    					$('#filtro_fechas3').show().fadeIn(1000);
    					$('#lis_tip_ale3').show().fadeIn(1000);
    					periodoMensual(3);
    				}else if((opcion == 18) || (opcion == 19) || (opcion == 12) || (opcion == 3) || (opcion == 23) || (opcion == 24) || (opcion == 25) || (opcion == 26) || (opcion == 27) || (opcion == 28) || (opcion == 29)){
    					$('#filtro_fechas3').hide().fadeOut(1000);
    				}else{
    					$('#filtro_fechas3').show().fadeIn(1000);
    					$('#lis_tip_ale3').hide().fadeOut(1000);
    					periodoMensual(3);
    				}
				}else if(tipo == 4){ //GESTOR COMUNITARIO
					if((opcion == 2) || (opcion == 4) || (opcion == 5)){
    					$('#lis_tip_ale4').show().fadeIn(1000);
    					periodoMensual(4);
    				}else if((opcion == 18) || (opcion == 19) || (opcion == 12) || (opcion == 3) || (opcion == 23) || (opcion == 24) || (opcion == 25) || (opcion == 26) || (opcion == 27) || (opcion == 28) || (opcion == 29)){
    					
    				}else{
    					$('#lis_tip_ale4').hide().fadeOut(1000);
    					periodoMensual(4);
    				}
				}
				//FIN DC
		}

		function periodoMensual(tipo){
			//INICIO DC
			var meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
			var fecha = new Date();
			if(tipo == 1){ //COORDINADOR
			for(i=0; i<12; i++){
				if(i == fecha.getMonth()){
					$('#per_mes').append('<option selected="selected" value="'+ i +'">'+meses[i]+'</option>');
				}else{
					$('#per_mes').append('<option value="'+ i +'">'+meses[i]+'</option>');
				}
			}
			$.ajax({
				type: "GET",  
				url: "{{ route('reportes.fecha') }}"
			}).done(function(resp){
				let año =resp.fecha.created_at.substring(0, 4);
				
				for(i=fecha.getFullYear(); i >= año; i--){
    
					$('#per_anual').append('<option value="'+ i +'">'+i+'</option>');
				}			
				
			}).fail(function(objeto, tipoError, errorHttp){
				desbloquearPantalla();
    
				manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
    
				return false;
			});
			}else if(tipo == 2){ //GESTION DE CASOS
				
				for(i=0; i<12; i++){
    				if(i == fecha.getMonth()){
    					$('#per_mes2').append('<option selected="selected" value="'+ i +'">'+meses[i]+'</option>');
    				}else{
    					$('#per_mes2').append('<option value="'+ i +'">'+meses[i]+'</option>');
		}
    			}
    
    			$.ajax({
    				type: "GET",  
    				url: "{{ route('reportes.fecha') }}"
    			}).done(function(resp){
    
    				
    				let año =resp.fecha.created_at.substring(0, 4);
    				
    				for(i=fecha.getFullYear(); i >= año; i--){
    
    					$('#per_anual2').append('<option value="'+ i +'">'+i+'</option>');
    				}			
    				
    			}).fail(function(objeto, tipoError, errorHttp){
    				desbloquearPantalla();
    
    				manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
    
						return false;
    			});
			}else if(tipo == 3){ //TERAPIA FAMILIAR
				for(i=0; i<12; i++){
    				if(i == fecha.getMonth()){
    					$('#per_mes3').append('<option selected="selected" value="'+ i +'">'+meses[i]+'</option>');
    				}else{
    					$('#per_mes3').append('<option value="'+ i +'">'+meses[i]+'</option>');
					}
				}
    
    			$.ajax({
    				type: "GET",  
    				url: "{{ route('reportes.fecha') }}"
    			}).done(function(resp){
    
    				
    				let año =resp.fecha.created_at.substring(0, 4);
    				
    				for(i=fecha.getFullYear(); i >= año; i--){
    
    					$('#per_anual3').append('<option value="'+ i +'">'+i+'</option>');
    				}			
    				
    			}).fail(function(objeto, tipoError, errorHttp){
    				desbloquearPantalla();
    
    				manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
    
    				return false;
    			});
			}
			//FIN DC
		}

		function habilitarFiltros(opcion, tipo){
			limpiarFechasInvalidas(tipo);
			$('#filtro_fecha').prop('selectedIndex', 0);
			$('#contenedor_periodo_mensual').hide();
			$('#contenedor_rango_fecha').hide();
			$('#reporte-contenido').hide();
			if(opcion == 1){
				//INICIO DC
				if(tipo == 1){ //COORDINADOR
					if($('#select_reportes').val() == 28 ){
    					$('#select_comunas_rep').hide();
        				$('#filtro_fechas').hide();
        				$('#filtro_fecha_asignacion').show();
        				$('#filtro_id_caso').show();
        				$('#filtro_gestor').show();
    				}else{
				if({{Session::get('perfil')}} == 7 || {{Session::get('perfil')}} == 10){
					$('#select_comunas_rep').show();
					$('#filtro_fechas').hide();
					$("#chkcomuna").multiselect("clearSelection");
        					$('#filtro_fecha_asignacion').hide();
        					$('#filtro_id_caso').hide();
        					$('#filtro_gestor').hide();
				}else{
					$('#filtro_fechas').show();
					alerta = $("#select_reportes option:selected").val();
        					desplegarListadoAlerta(alerta, tipo); 
        					$('#filtro_fecha_asignacion').hide();
        					$('#filtro_id_caso').hide();
        					$('#filtro_gestor').hide();
        					periodoMensual(1);
        				}
    				}
				}else if(tipo == 2){ //GESTION DE CASOS
					if($('#select_reportes2').val() == 28){
						$('#select_comunas_rep2').hide();
						$('#filtro_fecha_asignacion2').show();
						$('#filtro_id_caso2').show();
						$('#filtro_gestor2').show();
						$('#filtro_fechas2').hide();
						$('#fecha_asig4').val('');
						$('#fecha_asig5').val('');
						$('#num_caso2').val('');
						$('#filtro_gestor1').val('');
						if({{Session::get('perfil')}} == 7 || {{Session::get('perfil')}} == 10){ //administrador central
							$('#select_comunas_rep2').show();
							$('#filtro_gestor2').show();
						}else if({{Session::get('perfil')}} == 2){ //coordinador
							$('#filtro_gestor2').show();
						}else{
							$('#filtro_gestor2').hide();
						}
					}else{
						if({{Session::get('perfil')}} == 7 || {{Session::get('perfil')}} == 10){
							$('#select_comunas_rep2').show();
							$('#filtro_fecha_asignacion2').hide();
							$('#filtro_id_caso2').hide();
							$('#filtro_gestor2').hide();
							$('#filtro_fechas2').hide();
							$("#chkcomuna2").multiselect("clearSelection");
						}else{
							$('#filtro_fecha_asignacion2').hide();
							$('#filtro_id_caso2').hide();
							$('#filtro_gestor2').hide();
							$('#filtro_fechas2').show();
							periodoMensual(2);
						}
					}
				}else if(tipo == 3){ //TERAPIA FAMILIAR
					if($('#select_reportes3').val() == 29){
						$('#select_comunas_rep3').hide();
						$('#filtro_fecha_asignacion3').show();
						$('#filtro_id_caso3').show();
						$('#filtro_fechas3').hide();
						$('#fecha_asig2').val('');
						$('#fecha_asig3').val('');
						$('#num_caso3').val('');
						$('#filtro_terapeuta').val('');
						if({{Session::get('perfil')}} == 7 || {{Session::get('perfil')}} == 10){ //administrador central
							$('#select_comunas_rep3').show();
							$('#filtro_gestor3').show();
						}else if({{Session::get('perfil')}} == 2){ //coordinador
							$('#filtro_gestor3').show();
						}else{
							$('#filtro_gestor3').hide();
						}
					}else{
						if({{Session::get('perfil')}} == 7 || {{Session::get('perfil')}} == 10){
							$('#select_comunas_rep3').show();
							$('#filtro_fecha_asignacion3').hide();
							$('#filtro_id_caso3').hide();
							$('#filtro_fechas3').hide();
							$("#chkcomuna3").multiselect("clearSelection");
						}else{
							$('#filtro_fecha_asignacion3').hide();
							$('#filtro_id_caso3').hide();
							$('#filtro_fechas3').show();
							periodoMensual(3);
						}
					}
				}else if(tipo == 4){ //GESTI�N COMUNITARIA
					if({{Session::get('perfil')}} == 7 || {{Session::get('perfil')}} == 10){ //administrador central
						$('#select_comunas_rep4').show();
						$('#filtro_gestor4').show();
					}else if({{Session::get('perfil')}} == 2){ //coordinador
						$('#filtro_gestor4').show();
					}else{
						$('#filtro_gestor4').hide();
					}
				}
			}else if(opcion == 2){
				if(tipo == 1){ //COORDINADOR
				alerta = $("#select_reportes option:selected").val();
				}else if(tipo == 2){ //GESTION DE CASOS
					alerta = $("#select_reportes2 option:selected").val();
				}else if(tipo == 3){ //TERAPIA FAMILIAR
					alerta = $("#select_reportes3 option:selected").val();
				}else if(tipo == 4){ //GESTION COMUNITARIO
					alerta = $("#select_reportes4 option:selected").val();
				}	
				desplegarListadoAlerta(alerta, tipo);  
			}
			//FIN DC
			limpiarFormFiltro(0);
		}

		function habilitarFechaFin(tipo){
			//INICIO DC
			if(tipo == 1){ //COORDINADOR
			fec_ini = $('#per_ini').val();
			if (fec_ini == "" || typeof fec_ini === "undefined"){
                $('#per_fin').prop('disabled',true);         
            }else{
				$('#per_fin').prop('disabled',false);
			}
			}else if(tipo == 2){ //GESTOR DE CASOS
				fec_ini = $('#per_ini_4').val();
    			if (fec_ini == "" || typeof fec_ini === "undefined"){
                    $('#per_fin_5').prop('disabled',true);         
                }else{
    				$('#per_fin_5').prop('disabled',false);
    			}
			}else if(tipo == 3){ //TERAPIA FAMILIAR
				fec_ini = $('#per_ini_6').val();
    			if (fec_ini == "" || typeof fec_ini === "undefined"){
                    $('#per_fin_7').prop('disabled',true);         
                }else{
    				$('#per_fin_7').prop('disabled',false);
    			}
			}
			//FIN DC
		}

		function limpiarFormulario(opcion = null, tipo){
			//INICIO DC
			if(tipo == 1){ //COORDINADOR
			$('#select_comunas_rep').hide();
			$('#filtro_fechas').hide();
			$('#reporte-contenido').hide();
    			$('#filtro_fecha_asignacion').hide();
    			$('#filtro_id_caso').hide();
    			$('#filtro_gestor').hide();
			limpiarFormFiltro(0);
			$("#select_reportes").removeClass("is-invalid");
			if({{Session::get('perfil')}} == 7){
				$('#chkcomuna').prop('selectedIndex', 0);
			}
			if(opcion== 0){
				$('#select_reportes').prop('selectedIndex', 0);
				$('#reporte-contenido').html("");
			}
			}else if(tipo == 2){ //GESTOR DE CASOS
				$('#select_comunas_rep2').hide();
    			$('#filtro_fechas2').hide();
    			$('#reporte-contenido').hide();
    			$('#filtro_fecha_asignacion2').hide();
    			$('#filtro_id_caso2').hide();
    			$('#filtro_gestor2').hide();
    			limpiarFormFiltro(0);
    			$("#select_reportes2").removeClass("is-invalid");
    			if({{Session::get('perfil')}} == 7){
    				$('#chkcomuna2').prop('selectedIndex', 0);
    			}
    			if(opcion== 0){
    				$('#select_reportes2').prop('selectedIndex', 0);
    				$('#reporte-contenido').html("");
    			}
			}else if(tipo == 3){ //TERAPIA FAMILIAR
				$('#select_comunas_rep3').hide();
    			$('#filtro_fechas3').hide();
    			$('#reporte-contenido').hide();
    			$('#filtro_fecha_asignacion3').hide();
    			$('#filtro_id_caso3').hide();
    			$('#filtro_gestor3').hide();
    			limpiarFormFiltro(0);
    			$("#select_reportes3").removeClass("is-invalid");
    			if({{Session::get('perfil')}} == 7){
    				$('#chkcomuna3').prop('selectedIndex', 0);
    			}
    			if(opcion== 0){
    				$('#select_reportes3').prop('selectedIndex', 0);
    				$('#reporte-contenido').html("");
    			}
			}else if(tipo == 4){ //GESTION COMUNITARIA
				$('#select_comunas_rep4').hide();
				$('#reporte-contenido').hide();
				limpiarFormFiltro(0);
				$("#select_reportes4").removeClass("is-invalid");
				if({{Session::get('perfil')}} == 7){
    				$('#chkcomuna4').prop('selectedIndex', 0);
    			}
    			if(opcion== 0){
    				$('#select_reportes4').prop('selectedIndex', 0);
    				$('#reporte-contenido').html("");
    			}
			}
			//FIN DC
		}
		
		function limpiarFormFiltro(opcion){
			var fecha = new Date();
			if(opcion == 0){
				$("#per_mes").prop('selectedIndex', fecha.getMonth());
				$('#per_anual').prop('selectedIndex', 0);
				$('#per_ini').datetimepicker('clear');
				$('#per_fin_').datetimepicker('clear');				
				$('#per_fin').prop('disabled',true);
				$("#per_ini").removeClass("is-invalid");
				$("#per_fin").removeClass("is-invalid");
			}else{				
				$('#ale_ter').prop('selectedIndex', 0);
			}
		}

		function limpiarFechasInvalidas(tipo){
			//INICIO DC
			if(tipo == 1){ //COORDINADOR
			$("#per_ini").removeClass("is-invalid");
			$("#per_fin").removeClass("is-invalid");
			$("#select_reportes").removeClass("is-invalid");
			$("#chkcomuna").removeClass("is-invalid");
			$("#filtro_fecha").removeClass("is-invalid");
			}else if(tipo == 2){ //GESTION DE CASOS
				$("#per_ini_4").removeClass("is-invalid");
    			$("#per_fin_5").removeClass("is-invalid");
    			$("#select_reportes2").removeClass("is-invalid");
    			$("#chkcomuna2").removeClass("is-invalid");
    			$("#filtro_fecha2").removeClass("is-invalid");
			}else if(tipo == 3){ //TERAPIA FAMILIAR
				$("#per_ini_6").removeClass("is-invalid");
    			$("#per_fin_7").removeClass("is-invalid");
    			$("#select_reportes3").removeClass("is-invalid");
    			$("#chkcomuna3").removeClass("is-invalid");
    			$("#filtro_fecha3").removeClass("is-invalid");
			}
			//FIN DC
		}

		function filtroFecha(tipo){
			limpiarFormFiltro(0);
			//INICIO DC
			if(tipo == 1){ //COORDINADOR
			opcion = $('#filtro_fecha option:selected').val();
				switch(opcion){
					case '0':				
						$('#contenedor_periodo_mensual').hide();
						$('#contenedor_rango_fecha').hide();
					break;
					case '1':
						$('#contenedor_rango_fecha').hide();
						$('#contenedor_periodo_mensual').show()
					break;
					case '2':				
						$('#contenedor_periodo_mensual').hide();
						$('#contenedor_rango_fecha').show()
					break;
				}
			}else if(tipo == 2){ //GESTION DE CASOS
				opcion = $('#filtro_fecha2 option:selected').val();
				switch(opcion){
					case '0':				
						$('#contenedor_periodo_mensual2').hide();
						$('#contenedor_rango_fecha2').hide();
					break;
					case '1':
						$('#contenedor_rango_fecha2').hide();
						$('#contenedor_periodo_mensual2').show()
					break;
					case '2':				
						$('#contenedor_periodo_mensual2').hide();
						$('#contenedor_rango_fecha2').show()
					break;
				}
			}else if(tipo == 3){ //TERAPIA FAMILIAR
				opcion = $('#filtro_fecha3 option:selected').val();
				switch(opcion){
					case '0':				
						$('#contenedor_periodo_mensual3').hide();
						$('#contenedor_rango_fecha3').hide();
					break;
					case '1':
						$('#contenedor_rango_fecha3').hide();
						$('#contenedor_periodo_mensual3').show()
					break;
					case '2':				
						$('#contenedor_periodo_mensual3').hide();
						$('#contenedor_rango_fecha3').show()
					break;
				}
			}
			//FIN DC
		}

		function diasEnUnMes(mes, año) {

			return new Date(año, mes, 0).getDate();
		}

			
		
		function verificarSelects(tipo){
			let respuesta = true;
			//INICIO DC	
			if(tipo == 1){ //COORDINADOR
			select_reportes = $("#select_reportes option:selected").val();
			filtro_fecha = $("#filtro_fecha option:selected").val();
			if (select_reportes == "" || typeof select_reportes === "undefined"){				
				respuesta = false;
				$("#select_reportes").addClass("is-invalid");
				mensajeTemporalRespuestas(0, "Debe seleccionar una opcion");                
			}
			if (($('#chkcomuna option:selected').length < 1)){
				if({{Session::get('perfil')}} == 7){				
					if(respuesta) mensajeTemporalRespuestas(0, "Debe ingresar una comuna.");
					$("#chkcomuna").addClass("is-invalid");
					respuesta = false;
				}
			}
    			if(select_reportes != 28 && select_reportes != 29){
			if (filtro_fecha == "" || typeof filtro_fecha === "undefined"){  
				if((select_reportes != 18) && (select_reportes != 19) && (select_reportes != 12) && (select_reportes != 3) && (select_reportes != 23) && (select_reportes != 24) && (select_reportes != 25) && (select_reportes != 26) && (select_reportes != 27)){
					$("#filtro_fecha").addClass("is-invalid");
					if(respuesta) mensajeTemporalRespuestas(0, "Debe seleccionar un filtro fecha");  
					respuesta = false; 				
				}            
			}
    			}
			}else if(tipo == 2){ //GESTION COMUNITARIA
				select_reportes = $("#select_reportes2 option:selected").val();
				filtro_fecha = $("#filtro_fecha2 option:selected").val();
				if (select_reportes == "" || typeof select_reportes === "undefined"){				
    				respuesta = false;
    				$("#select_reportes2").addClass("is-invalid");
    				mensajeTemporalRespuestas(0, "Debe seleccionar una opcion");                
    			}
    			if (($('#chkcomuna2 option:selected').length < 1)){
    				if({{Session::get('perfil')}} == 7){				
    					if(respuesta) mensajeTemporalRespuestas(0, "Debe ingresar una comuna.");
    					$("#chkcomuna2").addClass("is-invalid");
    					respuesta = false;
    				}
    			}
    			if(select_reportes != 28 && select_reportes != 29){
    				if (filtro_fecha == "" || typeof filtro_fecha === "undefined"){  
        				if((select_reportes != 18) && (select_reportes != 19) && (select_reportes != 12) && (select_reportes != 3) && (select_reportes != 23) && (select_reportes != 24) && (select_reportes != 25) && (select_reportes != 26) && (select_reportes != 27)){
        					$("#filtro_fecha2").addClass("is-invalid");
        					if(respuesta) mensajeTemporalRespuestas(0, "Debe seleccionar un filtro fecha");  
        					respuesta = false; 				
        				}            
        			}
    			}
			}else if(tipo == 3){ //TERAPIA FAMILIAR
				select_reportes = $("#select_reportes3 option:selected").val();
				filtro_fecha = $("#filtro_fecha3 option:selected").val();
				if (select_reportes == "" || typeof select_reportes === "undefined"){				
    				respuesta = false;
    				$("#select_reportes3").addClass("is-invalid");
    				mensajeTemporalRespuestas(0, "Debe seleccionar una opcion");                
    			}
    			if (($('#chkcomuna3 option:selected').length < 1)){
    				if({{Session::get('perfil')}} == 7){				
    					if(respuesta) mensajeTemporalRespuestas(0, "Debe ingresar una comuna.");
    					$("#chkcomuna3").addClass("is-invalid");
    					respuesta = false;
    				}
    			}
    			if(select_reportes != 28 && select_reportes != 29){
					// INICIO CZ SPRINT 66
    				// alert(select_reportes);
					// FIN CZ SPRINT 66
    				if (filtro_fecha == "" || typeof filtro_fecha === "undefined"){  
        				if((select_reportes != 18) && (select_reportes != 19) && (select_reportes != 12) && (select_reportes != 3) && (select_reportes != 23) && (select_reportes != 24) && (select_reportes != 25) && (select_reportes != 26) && (select_reportes != 27)){
        					$("#filtro_fecha3").addClass("is-invalid");
        					if(respuesta) mensajeTemporalRespuestas(0, "Debe seleccionar un filtro fecha");  
        					respuesta = false; 				
        				}            
        			}
    			}
			}
			//FIN DC
			return respuesta;
		}
		
		function verificarFormatoFecha(fec_ini = "", fec_fin = "", tipo){
			let respuesta = true;
			//INICIO DC
			if(tipo == 1){ //COORDINADOR
			if (fec_ini == "" || typeof fec_ini === "undefined"){
				respuesta = false;
                $("#per_ini").addClass("is-invalid");
            }else{
				if (!validarFormatoFecha(fec_ini)){
					respuesta = false;
                    $("#per_ini").addClass("is-invalid");
                    }    				
                if (!existeFecha(fec_ini)){
					respuesta = false;
                    $("#per_ini").addClass("is-invalid");                    
                }
			}
			if(!$("#per_fin").prop('disabled')){
				if (fec_fin == "" || typeof fec_fin === "undefined"){
					respuesta = false;
					$("#per_fin").addClass("is-invalid");                
				}else{
					if (!validarFormatoFecha(fec_fin)){
						respuesta = false;
						$("#per_fin").addClass("is-invalid");                    
					}
					
					if (!existeFecha(fec_fin)){
						respuesta = false;
						$("#per_fin").addClass("is-invalid");                    
					}
				}
			}else{
				respuesta = false;
    			}
			}else if(tipo == 2){ //GESTOR DE CASO
				if (fec_ini == "" || typeof fec_ini === "undefined"){
    				respuesta = false;
                    $("#per_ini_4").addClass("is-invalid");
                }else{
    				if (!validarFormatoFecha(fec_ini)){
    					respuesta = false;
                        $("#per_ini_4").addClass("is-invalid");
			}			
                    if (!existeFecha(fec_ini)){
    					respuesta = false;
                        $("#per_ini_4").addClass("is-invalid");                    
                    }
    			}
    			if(!$("#per_fin_5").prop('disabled')){
    				if (fec_fin == "" || typeof fec_fin === "undefined"){
    					respuesta = false;
    					$("#per_fin_5").addClass("is-invalid");                
    				}else{
    					if (!validarFormatoFecha(fec_fin)){
    						respuesta = false;
    						$("#per_fin_5").addClass("is-invalid");                    
    					}
			
    					if (!existeFecha(fec_fin)){
    						respuesta = false;
    						$("#per_fin_5").addClass("is-invalid");                    
    					}
    				}
    			}else{
    				respuesta = false;
    			}
			}else if(tipo == 3){ //TERAPIA FAMILIAR
				if (fec_ini == "" || typeof fec_ini === "undefined"){
    				respuesta = false;
                    $("#per_ini_6").addClass("is-invalid");
                }else{
    				if (!validarFormatoFecha(fec_ini)){
    					respuesta = false;
                        $("#per_ini_6").addClass("is-invalid");
                    }    				
                    if (!existeFecha(fec_ini)){
    					respuesta = false;
                        $("#per_ini_6").addClass("is-invalid");                    
                    }
    			}
    			if(!$("#per_fin_7").prop('disabled')){
    				if (fec_fin == "" || typeof fec_fin === "undefined"){
    					respuesta = false;
    					$("#per_fin_7").addClass("is-invalid");                
    				}else{
    					if (!validarFormatoFecha(fec_fin)){
    						respuesta = false;
    						$("#per_fin_7").addClass("is-invalid");                    
    					}
			
    					if (!existeFecha(fec_fin)){
    						respuesta = false;
    						$("#per_fin_7").addClass("is-invalid");                    
    					}
    				}
    			}else{
    				respuesta = false;
    			}
			}
			//FIN DC
			return respuesta;
		}	
		
		
		function getAlertaTerritorial(){

			$.ajax({
				type: "GET",  
				url: "{{ route('reportes.alerta.lista') }}"
			}).done(function(resp){

				tip_ale = resp.tip_ale;
				$.each(tip_ale, function(i, item){
						$('#ale_ter').append('<option value="'+ item.ale_tip_id +'">'+item.ale_tip_nom+'</option>');
				});
				
			}).fail(function(objeto, tipoError, errorHttp){
				desbloquearPantalla();

				manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

				return false;
			});
		}

		function ListarReporteXcomuna(tipo){
			//INICIO DC
			if(tipo == 1){ //COORDINADOR
			let select_reportes = $('#select_reportes').val();
				let valid = verificarSelects(tipo);
			if(valid) {	
				let chkcomuna	= new Array();				
				
				$.each($('#chkcomuna option:selected'), function(){ chkcomuna.push($(this).val()); });
				chkcomuna		= chkcomuna.join(',');
    
				if(chkcomuna=="") chkcomuna=0;
    
				let listartabla_objetivos = $('#tabla_objetivos').DataTable();
				listartabla_objetivos.clear().destroy();
				console.log('chk_comuna: '+chkcomuna);
    				if (chkcomuna != 0){ 
    					procesarReporte(select_reportes,chkcomuna,0, 1); 
    				}
    
    			}
			}else if(tipo == 2){ //GESTOR DE CASO
				let select_reportes = $('#select_reportes2').val();
				let valid = verificarSelects(tipo);
				if(valid) {	
    				let chkcomuna	= new Array();				
    				
    				$.each($('#chkcomuna2 option:selected'), function(){ chkcomuna.push($(this).val()); });
    				chkcomuna		= chkcomuna.join(',');
    
    				if(chkcomuna=="") chkcomuna=0;
    
    				let listartabla_objetivos = $('#tabla_objetivos').DataTable();
    				listartabla_objetivos.clear().destroy();
    				console.log('chk_comuna: '+chkcomuna);
    				if (chkcomuna != 0){ 
    					procesarReporte(select_reportes,chkcomuna,0, 2); 
    				}
    
			}
			}else if(tipo == 3){ //TERAPIA FAMILIAR
				let select_reportes = $('#select_reportes3').val();
				let valid = verificarSelects(tipo);
				if(valid) {	
    				let chkcomuna	= new Array();				
    				
    				$.each($('#chkcomuna3 option:selected'), function(){ chkcomuna.push($(this).val()); });
    				chkcomuna		= chkcomuna.join(',');
    				if(chkcomuna=="") chkcomuna=0;
    
    				let listartabla_objetivos = $('#tabla_objetivos').DataTable();
    				listartabla_objetivos.clear().destroy();
    				console.log('chk_comuna: '+chkcomuna);
    				if (chkcomuna != 0){ 
    					procesarReporte(select_reportes,chkcomuna,0, 3); 
    				}
    
    			}
			}else if(tipo == 4){ //GESTOR COMUNITARIO
				let select_reportes = $('#select_reportes4').val();
				let valid = verificarSelects(tipo);
				if(valid) {	
    				let chkcomuna	= new Array();				
    				
    				$.each($('#chkcomuna4 option:selected'), function(){ chkcomuna.push($(this).val()); });
    				chkcomuna		= chkcomuna.join(',');
    				if(chkcomuna=="") chkcomuna=0;
    
    				let listartabla_objetivos = $('#tabla_objetivos').DataTable();
    				listartabla_objetivos.clear().destroy();
    				console.log('chk_comuna: '+chkcomuna);
    				if (chkcomuna != 0){ 
    					procesarReporte(select_reportes,chkcomuna,0, 4); 
    				}
    
    			}
			}
			//FIN DC
		}

		function procesarReporte(option, comunas = null, recargar = 0, tipo){
			let data = new Object();
			//INICIO DC
				let fec_ini = "";
    		let fec_fin = "";
			// CZ SPRINT 75
			data.filtro_fecha2 = $("#filtro_fecha2").val();
			// CZ SPRINT 75
			if(tipo == 1){ //COORDINADOR
				limpiarFechasInvalidas(tipo);
				if (recargar == 0 ){ bloquearPantalla(); }	
					
			let filtro = $('#filtro_fecha option:selected').val();
			if(filtro == 1){
				let mes = 1 + parseInt($('#per_mes option:selected').val());
				let año = $('#per_anual option:selected').val();
				let dia = diasEnUnMes(mes,año)
				fec_ini = '01/'+mes+'/'+año;
				fec_fin = dia+'/'+mes+'/'+año;
				data.mes = mes;
				data.año = año;
			}else if(filtro == 2){
				fec_ini = $('#per_ini').val();
        			fec_fin = $('#per_fin').val();	
        			respuesta = verificarFormatoFecha(fec_ini, fec_fin, 1);			
				if(!respuesta){
					desbloquearPantalla();
					mensajeTemporalRespuestas(0, "Debe ingresar un rango fecha.");
					return respuesta;
				}
			}
			}else if(tipo == 2){ //GESTION COMUNITARIO
				limpiarFechasInvalidas(tipo);
				if (recargar == 0 ){ bloquearPantalla(); }
				let filtro = $('#filtro_fecha2 option:selected').val();
				if(filtro == 1){
					// INICIO CZ SPRINT 75 MANTIS 10067
        			let mes = 1 + parseInt($('#per_mes2 option:selected').val());
        			let año = $('#per_anual2 option:selected').val();
        			let dia = diasEnUnMes(mes,año)
        			fec_ini = '01-'+mes+'-'+año;
        			fec_fin = dia+'-'+mes+'-'+año;
					data.mes = mes;
					data.año = año;
					// FIN CZ SPRINT 75 MANTIS 10067
    			}else if(filtro == 2){
					// INICIO CZ SPRINT 75 MANTIS 10067
        			fec_ini = $('#per_ini_4').val();
        			fec_fin = $('#per_fin_5').val();
        			respuesta = verificarFormatoFecha(fec_ini, fec_fin, 2);			
					// FIN CZ SPRINT 75 MANTIS 10067			
        			if(!respuesta){
        				desbloquearPantalla();
        				mensajeTemporalRespuestas(0, "Debe ingresar un rango fecha.");
        				return respuesta;
        			}
    			}
			}else if(tipo == 3){ //TERAPIA FAMILIAR
				limpiarFechasInvalidas(tipo);
				if (recargar == 0 ){ bloquearPantalla(); }
				let filtro = $('#filtro_fecha3 option:selected').val();
				if(filtro == 1){
        			let mes = 1 + parseInt($('#per_mes3 option:selected').val());
        			let año = $('#per_anual3 option:selected').val();
        			let dia = diasEnUnMes(mes,año)
        			fec_ini = '01/'+mes+'/'+año;
        			fec_fin = dia+'/'+mes+'/'+año;
					data.mes = mes;
					data.año = año;
    			}else if(filtro == 2){
        			fec_ini = $('#per_ini_6').val();
        			fec_fin = $('#per_fin_7').val();
					// INICIO CZ SPRINT 67
						respuesta = verificarFormatoFecha(fec_ini, fec_fin, 3);	
					// FIN CZ SPRINT 67 	
        			if(!respuesta){
        				desbloquearPantalla();
        				mensajeTemporalRespuestas(0, "Debe ingresar un rango fecha.");
        				return respuesta;
        			}
    			}
			}else if(tipo == 4){ //GESTOR COMUNITARIO
				if (recargar == 0 ){ bloquearPantalla(); }	
			}
			//FIN DC
			data.option = option;
			data.fec_ini = fec_ini;
			data.fec_fin = fec_fin;
			data.tip_ale = $('#ale_ter option:selected').val();
			
			//INICIO DC
			if(tipo == 1){ //COORDINADOR
			if ((comunas == null) && ($('#chkcomuna option:selected').length < 1)){
					desbloquearPantalla();
					alert('Debe ingresar una comuna.');
					return false;
			}
    
			if (comunas == null){
				let chkcomuna	= new Array();
				$.each($('#chkcomuna option:selected'), function(){ chkcomuna.push($(this).val()); });
				comunas			= chkcomuna.join(',');
				data.comunas 	= comunas;
			}else{
				data.comunas 	= comunas;
			}
			}else if(tipo == 2){ //GESTOR DE CASOS
				if(option == 28){
    				data.fAsignacionIni = $('#fecha_asig4').val();
    				data.fAsignacionFin = $('#fecha_asig5').val();
    				if($('#fecha_asig4').val() == ''){
    					desbloquearPantalla();
            			mensajeTemporalRespuestas(0, "Debe ingresar un rango fecha.");
            			return false;
    				}
    				if($('#fecha_asig5').val() == ''){
    					desbloquearPantalla();
            			mensajeTemporalRespuestas(0, "Debe ingresar un rango fecha.");
            			return false;
    				}
    				data.nCaso = $('#num_caso2').val();
    			}
				if ((comunas == null) && ($('#chkcomuna2 option:selected').length < 1)){
    					desbloquearPantalla();
    					alert('Debe ingresar una comuna.');
    					return false;
    			}
			
    			if (comunas == null){
    				let chkcomuna	= new Array();
    				$.each($('#chkcomuna2 option:selected'), function(){ chkcomuna.push($(this).val()); });
    				comunas			= chkcomuna.join(',');
    				data.comunas 	= comunas;
    			}else{
    				data.comunas 	= comunas;
    			}
    			if({{Session::get('perfil')}} == 2){ //coordinador
    				data.gestor = $('#filtro_gestor1 option:selected').val();
    			}else if({{Session::get('perfil')}} == 7){ //administrador central
    				data.gestor = $('#filtro_gestor1 option:selected').val();
    			}else if({{Session::get('perfil')}} == 3){ //gestor
    				data.gestor = {{Session::get('id_usuario')}};
    			}
			}else if(tipo == 3){ //TERAPIA FAMILIAR
				if(option == 29){
    				data.fAsignacionIni = $('#fecha_asig2').val();
    				data.fAsignacionFin = $('#fecha_asig3').val();
    				if($('#fecha_asig2').val() == ''){
    					desbloquearPantalla();
            			mensajeTemporalRespuestas(0, "Debe ingresar un rango fecha.");
            			return false;
    				}
    				if($('#fecha_asig3').val() == ''){
    					desbloquearPantalla();
            			mensajeTemporalRespuestas(0, "Debe ingresar un rango fecha.");
            			return false;
    				}
    				data.nCaso = $('#num_caso3').val();
    			}
				if ((comunas == null) && ($('#chkcomuna3 option:selected').length < 1)){
    					desbloquearPantalla();
    					alert('Debe ingresar una comuna.');
    					return false;
    			}
    			if (comunas == null){
    				let chkcomuna	= new Array();
    				$.each($('#chkcomuna3 option:selected'), function(){ chkcomuna.push($(this).val()); });
    				comunas			= chkcomuna.join(',');
    				data.comunas 	= comunas;
    			}else{
    				data.comunas 	= comunas;
    			}
    			if({{Session::get('perfil')}} == 2){ //coordinador
    				data.terapeuta = $('#filtro_terapeuta option:selected').val();
    			}else if({{Session::get('perfil')}} == 7){ //administrador central
    				data.terapeuta = $('#filtro_terapeuta option:selected').val();
    			}else if({{Session::get('perfil')}} == 4){ //terapeuta
    				data.terapeuta = {{Session::get('id_usuario')}};
    			}
			}else if(tipo == 4){ //GESTOR COMUNITARIO
				if ((comunas == null) && ($('#chkcomuna4 option:selected').length < 1)){
    					desbloquearPantalla();
    					alert('Debe ingresar una comuna.');
    					return false;
    			}
    			if (comunas == null){
    				let chkcomuna	= new Array();
    				$.each($('#chkcomuna4 option:selected'), function(){ chkcomuna.push($(this).val()); });
    				comunas			= chkcomuna.join(',');
    				data.comunas 	= comunas;
    			}else{
    				data.comunas 	= comunas;
    			}
			}
			
			console.log(data);
			//FIN DC
			$.ajax({

				url: "{{ route('reportes.cargar') }}",
				type: "GET",
				data: data,
				timeout: 12000

			}).done(function(resp){
				desbloquearPantalla();
				console.log(resp);
				if (resp.estado == 1){
					$('#reporte-contenido').show()
					$("#reporte-contenido").html(resp.respuesta);

				}else if(resp.estado == 0){
					let mensaje = "Ocurrio un error al momento de desplegar el reporte solicitado. Por favor intente nuevamente.";
					mensajeTemporalRespuestas(0, mensaje); 

					return false;
				}
			}).fail(function(objeto, tipoError, errorHttp){
				// let cantidad_intentos = (recargar + 1);

				// if (cantidad_intentos < 3){ 
        		// 	procesarReporte(option, comunas, cantidad_intentos);
      
      			// }else{
				// 	desbloquearPantalla();

				// 	manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

				// 	return false;
      			// }
			});
		}
	</script>
@endsection