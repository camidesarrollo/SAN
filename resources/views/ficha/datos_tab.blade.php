			<h5><span class="fa fa-user mr-2"></span>  Datos del NNA</h5>
						<div class="card p-4">
                          <div class="row">
                              <div class="col col-md-4">
                                <small>Educación</small>
                                <table class="table table-striped table-sm m-0">
                                  <tbody>
                                    <tr>
                                      <td>Rol:</td>
                                      <td>
                                        @if (!is_null($caso->rbd_rbd) && $caso->rbd_rbd != "")
                                            <strong>{{ $caso->rbd_rbd }}</strong>
                                        @else
                                            <strong>Sin información.</strong>
                                        @endif
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>Nombre:</td>
                                      <td>
                                          @if (!is_null($caso->rbd_nom) && $caso->rbd_nom != "")
                                              <strong>{{ ucwords(mb_strtolower($caso->rbd_nom)) }}</strong>
                                          @else
                                               <strong>Sin información.</strong>   
                                          @endif      
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>Nivel:</td>
                                      <td>  
                                        <strong>{{ $nombre_codigo_ens }}</strong>
                                      </td>  
                                    </tr>
                                    <tr>
                                      <td>Código Grado:</td>
                                      <td>  
                                          @if (!is_null($caso->cod_gra) && $caso->cod_gra != "")
                                              <strong>{{ $caso->cod_gra }}</strong>
                                          @else
                                               <strong>Sin información.</strong>   
                                          @endif 
                                      </td>  
                                    </tr>
                                    <tr>
                                      <td>Letra Curso:</td>
                                      <td>
                                        @if (!is_null($caso->let_cur) && $caso->let_cur  != "")
                                              <strong>{{ $caso->let_cur }}</strong>
                                          @else
                                               <strong>Sin información.</strong>   
                                          @endif 
                                      </td>
                                    </tr>

                                    <!--<tr>
                                      <td>Asistencia:</td>
                                      <td><strong>-</strong></td>
                                    </tr>
                                    <tr>
                                      <td>Promedio:</td>
                                      <td><strong>-</strong></td>
                                    </tr>
                                    <tr>
                                      <td>Situacion Final:</td>
                                      <td><strong>-</strong></td>
                                    </tr>-->

                                  </tbody>
                                </table>
                           <!--     <hr> -->
                                <div class="row">
                                  <div class="col-md-5">
                                    <p style="font-size:9px;">
                                      <b>Fuente: 
                                      @if (!is_null($caso->fuente) && $caso->fuente  != "")
                                          {{ $caso->fuente }}.
                                      @else
                                          Sin información.
                                      @endif  

                                      </b>
                                    </p> 
                                  </div>
                                  <div class="col-md-7 text-right" >
                                    <p style="font-size:9px;">
                                      @if (!is_null($caso->fecha_act) && $caso->fecha_act  != "")
                                        <b>Fecha de Actualización: {{ $caso->fecha_act }}.</b>
                                      @else
                                        <b>Sin información.</b>   
                                      @endif  
                                    </p>
                                  </div>
                                </div>

                                <br>

                                <small>Registro Social de Hogares</small>
                                  <div class="row">
                                    <div class="col-md-7">
                                      <small>Calificación</small>
                                      <div class="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{ $calificacion }}%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                                      </div>
                                      <div class="row">
                                        <div class="col">
                                          <small>0%</small>
                                        </div>
                                        <div class="col">
                                          <h5 class="p-1 text-center">{{ $calificacion }}%</h5>
                                        </div>
                                        <div class="col">
                                          <small>100%</small>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      @if($calificacion>0)
                                      <small>Cartola</small> 
                                      <small><a class="btn btn-primary btn-sm" href="#" onclick="window.open('{{ route('caso.cartola', [ 'run' => $run]) }}');"><span class="fa fa-download mr-2"></span>Descargar</a></small>
                                      @endif
                                    </div>
                                      <div class="col-md-4">
                                        <p style="font-size:9px;">
                                          <b>Fuente: RSH</b>
                                        </p> 
                                      </div>
                                      <div class="col-md-8 text-right" >
                                        @if($calificacion>0)
                                          <p style="font-size:9px;">
                                            <b>Fecha de Actualización: {{ $fecha_act_rsh }}.</b>
                                          </p>
                                        @endif
                                      </div>
                     

                                  </div>
                              </div>
                             
                              <div class="col col-md-8">
                                <div id="diagrama-hogar" class="p-2">
                                  <div class="row">
                                    <div class="col">
                                      <h6>Composición del hogar</h6>
                                    </div>

                                    <!--<div class="col text-right">
                                      <small>Filtrar por:</small>
                                      <select type="aria-selected" name="">
                                        <option id="filtroNulo" name="radio" type="radio" class="text-center"> - Sin Filtro</option>
                    										<option id="filtroMujer" name="radio" type="radio" class="text-center"> - Mujer</option>
                    										<option id="filtroHombre" name="radio" type="radio" class="text-center"> - Hombre</option>
                    										<option id="filtroMujer" name="radio" type="radio" class="text-center"> - Adultos mayores </option>
                    										<option id="filtroMujer" name="radio" type="radio" class="text-center"> - Gestantes</option>
                    										<option id="filtroMujer" name="radio" type="radio" class="text-center"> - En edad escolar </option>
                    										<option id="filtroMujer" name="radio" type="radio" class="text-center"> - En edad escolar con rezago </option>
                                      </select>
                                    </div>-->

                                  </div>
                                  <div class="row">
                                    <div class="col-12 text-center">
                                      <div id="animation_container"></div>   
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-12">
                                      <table class="table table-sm">
                                        <tbody>
                                          <tr>
                                            <td><small style="border: 3px solid #ff0000"><span style="color: #fff">_</span></small></td>
                                            <td><small>NNA objeto del caso</small></td>
                                            <td><small style="border: 3px solid #ffa500"><span style="color: #fff">_</span></small></td>
                                            <td><small>NNA con alertas</small></td>
                                            <td><small style="border: 3px solid #cccccc"><span style="color: #fff">_</span></small></td>
                                            <td><small>Integrantes del hogar</small></td>
                                            <td><small style="border: 3px solid #ffff00; background-color: #ffff00"><span style="color: #ffff00">_</span></small></td>
                                            <td><small>Selección según filtro</small></td>
                                          </tr>  
                                        </tbody>
                                      </table>
                                    </div>
                                  </div>
                                </div> 
                                  <div class="row" >
                                      <div class="col-md-4">
                                        <p style="font-size:9px;">
                                          <b>Fuente: RSH</b>
                                        </p> 
                                      </div>
                                      <div class="col-md-8 text-right" >
                                        <p style="font-size:9px;">
                                          <b>Fecha de Actualización: {{ $fecha_act_rsh }}.</b>
                                        </p>
                                      </div>
                                    </div>
                              </div>
                          </div>
                        </div>
                        <!--<div class="card mb-4 p-4">
                          <div class="row">
                            <div class="col">
                              <small>Estado actual</small> 
                              <h6>En Diagnóstico</h6>
                            </div>
                            <div class="col">
                              <small>Alertas anteriores:</small> 
                              <h6>8</h6>
                            </div>
                            <div class="col">
                              <small>PAF anteriores:</small> 
                              <h6>1</h6>
                            </div>
                            <div class="col">
                              <a class="btn btn-sm btn-primary" id="historial-tab" data-toggle="tab" href="#historial" role="tab" aria-controls="historial" aria-selected="false"><i class="fa fa-plus-circle"></i> Historial</a>
                            </div>
                          </div>
                        </div>-->












		<!-- <div class="card p-4 shadow-sm">
			<div class="row">
				<div class="col-md-3">
					
					<h5><strong>{{ $caso->nombre }}</strong></h5>
					<br>
					
					<h5><strong>{{ number_format($caso->run,0,",",".")."-".($caso->dig)  }}</strong></h5>
					<br>
					{{--<h6>Fecha de Nacimiento</h6>
					<h5><strong>{{ date('d-m-Y', strtotime($caso->nacimiento)) }}</strong></h5>--}}
					<h6>Edad</h6>
					<h5>{{ $caso->edad_ani }} Años </h5>
					<h6>Sexo</h6>
					<h5>{{ $caso->sexo }} </h5>
					@if($caso->score!=null)
					<h6>Score</h6>
					<table>
					<tr>
						<td><div class="circuloFicha {{$caso->color}}" >{{$caso->score}}</div> </td>
					</tr>
					</table>
					@endif
					<br>

					<h6>Escolaridad</h6>
					<h5>{{ $caso->rbd_nom }}</h5>
					<h5>{{ $caso->cod_gra  }}  { { $caso->gra_let }} </h5>
					<br>

					<h6>Consultorio</h6>
					<h5>Centro de Salud Familiar Los Castaños</h5>
                    <h5>Diagonal Los Castaños #5820,La Florida.</h5>
					<br>

					<h6>Calificación socio económica</h6>
					<h5>40%</h5>
					<br>	

					@ if($terapeuta!=null)
						<h6>Terapeuta Asignado</h6>
						<h5>{ { $terapeuta }}</h5>
						<hr>
					@ endif
					<h6>Registro Social de Hogares</h6>
					<a class="btn btn-warning btn-sm" href="#" onclick="window.open('{{ route('caso.cartola', [ 'run' => $run]) }}');"><span class="oi oi-data-transfer-download"></span> </span> Descargar Cartola RSH</a>
				</div>
				
				<div class="col-md-6">

					<h6>Jefe de Familia y Parentesco</h6>

						<div id="animation_container"></div>

						<dl id="vis_panel"  class="row">
							<dt class="col-sm-3">Nombre</dt>
							<dd class="col-sm-9" id="vis_nombre" ></dd>

							<dt class="col-sm-3">Rut</dt>
							<dd class="col-sm-9" id="vis_rut" ></dd>

							<dt class="col-sm-3">Sexo</dt>
							<dd class="col-sm-9" id="vis_sexo" ></dd>

							<dt class="col-sm-3">Fecha de nacimiento</dt>
							<dd class="col-sm-9" id="vis_nacimiento" ></dd>

							<dt class="col-sm-3">Años de edad</dt>
							<dd class="col-sm-9" id="vis_edad" ></dd>
						</dl> 
				</div>

				<div class="col-md-3" >
					<h2>Filtros</h2>
					<input id="filtroNulo" name="radio" type="radio" class="text-center"> - Sin Filtro</input>
					<br>
					<input id="filtroMujer" name="radio" type="radio" class="text-center"> - Mujer</input>
					<br>
					<input id="filtroHombre" name="radio" type="radio" class="text-center"> - Hombre</input>
				    <br>
					<input id="filtroMujer" name="radio" type="radio" class="text-center"> - Adultos mayores </input>
					<br>
					<input id="filtroMujer" name="radio" type="radio" class="text-center"> - Gestantes</input>
					<br>
					<input id="filtroMujer" name="radio" type="radio" class="text-center"> - En edad escolar </input>
					<br>
					<input id="filtroMujer" name="radio" type="radio" class="text-center"> - En edad escolar con rezago </input>
					<br>
				</div>
			</div>
		
		</div> -->
