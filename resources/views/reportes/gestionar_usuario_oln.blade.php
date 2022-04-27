@extends('layouts.main')
@section('contenido')

<style type="text/css">
.multiselect-container>li {
	width:200px;
	padding:0px;
	margin:0px;
}
.lbl{
    margin-left:20px;
}
.lblAdd{
    width: 150px;
}
.form-control{
    margin-bottom: 8px;
    width: 300px;
}
.dv{
    position: relative;
    margin-left: -5px;
    margin-top: 5px;
}
.digver{
    margin-left: -5px;
    width: 40px;
}
.inputRut{
    width: 160px;
}
.btnAddComuna{
    margin-left:120px;
}
.listComuna{
    border: 1px solid #428bca;
    min-height: 30px;
    margin-left: 150px;
    width: 350px;
    margin-bottom: 10px;
    padding: 5px;
}
.listComunaEdit{
    border: 1px solid #428bca;
    min-height: 30px;
    margin-left: 150px;
    width: 350px;
    margin-bottom: 10px;
    padding: 5px;
}
.itemComuna{
    
}
.tdComuna{
    padding: 3px;
}
.itemComuna:hover{
    background-color: #E6E6E6;
}
</style>	
<!-- INICIO DC SPRINT 66 -->
	<main id="content">
		<section class="p-1 cabecera">
			<div class="container-fluid">
				<div class="row align-items-center">
					<div class="col-md-12">
						<h5><i class="{{$icono}}"></i>Gestionar Usuarios por OLN</h5>
					</div>
				</div>
			</div>
		</section>
		<section>
			<div class="container-fluid">
				<div class="card p-4 shadow-sm">
					<div class="col-5"  >
						<button type="button" class="btn btn-primary" onclick="agregarUsuario();"><i class="fa fa-user-plus"></i> Agregar Usuario</button>
					</div>	
					<br>
					<div class="form-group row">
						<label for="inputPassword" class="lbl col-form-label"><b>Filtrar por:</b></label>
						<div>
                            <select id="opc_oln" name="opc_oln" class="form-control" style="margin-right:30px">
								
                            </select>
						</div>
						@php $perfiles = Helper::getPerfiles(); @endphp
						<div>
                            <select id="cbxPerfil" name="opc_oln" class="form-control">
								<option value="">Seleccione un Perfil</option>								
                                @foreach($perfiles as $value)
    								<option value="{{$value->id}}">{{$value->nombre}}</option>    								
    							@endforeach
                            </select>
						</div>
						<div class="text-right lbl"  >
							<button id="btnFiltrar" type="submit" class="btn btn-primary" onclick="procesarReporte();"><i class="fa fa-search"></i> Filtrar</button>
						</div>						
					</div>
					<div class="row">
						<!-- REPORTES -->
						<div class="col-12">
                            <div id="reporte-contenido"></div>												
                        </div>
                        <!-- REPORTES -->
				    </div>
                </div>
			</div>
		</section>

	</main>	
	
	<div id="modalAgregarUsuario" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog">
    	<div class="modal-dialog modal-lg" role="document">
    		<div class="modal-content p-4">
    			<div class="modal-header">
    				<div style="margin: 0 auto;"><h5>Agregar Usuario</h5></div>
    				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute; margin: 0; top: 5px; right: 33px;">
    					<span aria-hidden="true">&times;</span>
    				</button>
    			</div>
    			<div class="modal-body">
    				<div class="row">
						<label class="lblAdd col-form-label">RUN:</label>
						<div class="col-sm-3"  >
							<input type="text" id="addRun" class="form-control inputRut" onKeyPress="return soloNumeros(event)">
						</div>	
						<label class="dv">-</label>	
						<div class="col-sm-3">
							<input type="text" id="addDV" maxlength="1" class="form-control digver" onKeyPress="return digVer(event)" onblur="getRunificador()">
						</div>		
					</div>					
					<div class="row">
						<label class="lblAdd col-form-label">Nombres:</label>
						<div class="col-sm-3"  >
							<input type="text" id="addNombres" class="form-control" disabled="disabled">
						</div>		
					</div>
					<div class="row">
						<label class="lblAdd col-form-label">Apellido 1:</label>
						<div class="col-sm-3"  >
							<input type="text" id="addApePat" class="form-control" disabled="disabled">
						</div>		
					</div>
					<div class="row">
						<label class="lblAdd col-form-label">Apellido 2:</label>
						<div class="col-sm-3"  >
							<input type="text" id="addApeMat" class="form-control" disabled="disabled">
						</div>		
					</div>
					<div class="row">
						<label class="lblAdd col-form-label">Teléfono:</label>
						<div class="col-sm-3"  >
							<input type="text" id="addFono" class="form-control" onKeyPress="return soloNumeros(event)">
						</div>		
					</div>
					<div class="row">
						<label class="lblAdd col-form-label">Mail:</label>
						<div class="col-sm-3"  >
							<input type="text" id="addMail" class="form-control">
						</div>		
					</div>
		<div class="row">
						<label class="lblAdd col-form-label">Región:</label>
						<div class="col-sm-3"  >
							<select id="addRegion" name="addRegion" class="form-control" onchange="getComunas(this.value)">
								<option value="0">Seleccione una Región</option>															
                            </select>
						</div>		
					</div>
					<div class="row">
						<label class="lblAdd col-form-label">Comuna:</label>
						<div class="col-sm-3"  >
							<select id="addComuna" name="addComuna" class="form-control" >
								<option value="0">Seleccione una Comuna</option>								
                            </select>                            
						</div>								
					</div>
					@php $instituciones = Helper::getInstituciones(); @endphp
					<div class="row">
						<label class="lblAdd col-form-label">Nombre Institución:</label>
						<div class="col-sm-3"  >
							<table>
								<tr>
									<td>
							<select id="addInstituciones" name="addInstituciones" class="form-control">
								<option value="0">Seleccione una Institución</option>								
                                @foreach($instituciones as $value)
    								<option value="{{$value->id_ins}}">{{$value->nom_ins}}</option>    								
    							@endforeach
                            </select>
									</td>
									<td>
										<button type="button" class="btn btn-success" onclick="addInstitucion();">+</button>
									</td>
								</tr>
							</table>
							                       
						</div>		
					</div>
					<div class="row">
						<label class="lblAdd col-form-label">Perfil:</label>
						<div class="col-sm-3"  >
							<select id="addPerfil" name="addPerfil" class="form-control">
								<option value="0">Seleccione un Perfil</option>								
                                @foreach($perfiles as $value)
    								<option value="{{$value->id}}">{{$value->nombre}}</option>    								
    							@endforeach
                            </select>
						</div>		
					</div>
					<div class="row">
						<label class="lblAdd col-form-label ">Clave Provisoria</label>

						<div class="input-group col-sm-6">
							<input class="form-control" type="password" id="clave" disabled>
							<div class="input-group-append" id="show_hide_password">
								<span class="input-group-text" id="basic-addon2"><i class="fas fa-eye-slash" id="icono-ojo"></i></span>
							</div>
						</div>
					</div>
					<div class="row">
						<label class="lblAdd col-form-label">Vigente en SAN:</label>
						<div class="col-sm-5"  >
							<input type="checkbox" id="checkVigente" class="vigencia-agregar">
							<span class="badge badge-pill badge-danger" style="display:none" id="mensaje-agregar">Usuario quedara inactivo del sistema</span>
						</div>		
					</div>
    			</div>
    			<div class="modal-footer" style="background-color: white;">
				
				<span class="badge badge-pill badge-danger" style="font-size: small !important; display: none" id="mensaje-SSO-SAN">El usuario ya existe en SAN, si desea modificarlo, seleccione editar en la busqueda de usuarios.</span>
    				<button type="button" class="btn btn-primary" onclick="guardarUsuario();" id="botonGuardar">Guardar</button>
    				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
    			</div>
    		</div>
    	</div>
    </div>
    <div id="modalEditarUsuario" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog">
    	<div class="modal-dialog modal-lg" role="document">
    		<div class="modal-content p-4">
    			<div class="modal-header">
    				<div style="margin: 0 auto;"><h5>Editar Usuario</h5></div>
    				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute; margin: 0; top: 5px; right: 33px;">
    					<span aria-hidden="true">&times;</span>
    				</button>
    			</div>
    			<div class="modal-body">
    				<input type="hidden" id="editId">
    				<div class="row">
						<label class="lblAdd col-form-label">RUN:</label>
						<div class="col-sm-3"  >
							<input type="text" id="editRun" disabled="disabled" class="form-control inputRut" onKeyPress="return soloNumeros(event)">
						</div>	
						<label class="dv">-</label>	
						<div class="col-sm-3">
							<input type="text" id="editDV" disabled="disabled" maxlength="1" class="form-control digver" onKeyPress="return digVer(event)">
						</div>		
					</div>					
					<div class="row">
						<label class="lblAdd col-form-label">Nombres:</label>
						<div class="col-sm-3"  >
							<input type="text" id="editNombres" disabled="disabled" class="form-control">
						</div>		
					</div>
					<div class="row">
						<label class="lblAdd col-form-label">Apellido 1:</label>
						<div class="col-sm-3"  >
							<input type="text" id="editApePat" disabled="disabled" class="form-control">
						</div>		
					</div>
					<div class="row">
						<label class="lblAdd col-form-label">Apellido 2:</label>
						<div class="col-sm-3"  >
							<input type="text" id="editApeMat" disabled="disabled" class="form-control">
						</div>		
					</div>
					<div class="row">
						<label class="lblAdd col-form-label">Teléfono:</label>
						<div class="col-sm-3"  >
							<input type="text" id="editFono" class="form-control" onKeyPress="return soloNumeros(event)">
						</div>		
					</div>
					<div class="row">
						<label class="lblAdd col-form-label">Mail:</label>
						<div class="col-sm-3"  >
							<input type="text" id="editMail" class="form-control">
						</div>		
					</div>
					@php $regiones = Helper::getRegiones(); @endphp
					<div class="row">
						<label class="lblAdd col-form-label">Región:</label>
						<div class="col-sm-3"  >
							<select id="editRegion" name="editRegion" class="form-control" onchange="getComunas(this.value)" disabled="disabled">
								<option value="0">Seleccione una Región</option>															
                            </select>
						</div>		
					</div>
					<div class="row">
						<label class="lblAdd col-form-label">Comuna:</label>
						<div class="col-sm-3"  >
							<select id="editComuna" name="editComuna" class="form-control" disabled="disabled">
								<option value="0">Seleccione una Comuna</option>								
                            </select>
						</div>	
							
						</div>		
					@php $instituciones = Helper::getInstituciones(); @endphp
					<div class="row">
						<label class="lblAdd col-form-label">Nombre Institución:</label>
						<div class="col-sm-3"  >
							<table>
								<tr>
									<td>
							<select id="editInstituciones" name="editInstituciones" class="form-control">
								<option value="0">Seleccione una Institución</option>								
                                @foreach($instituciones as $value)
    								<option value="{{$value->id_ins}}">{{$value->nom_ins}}</option>    								
    							@endforeach
                            </select>
									</td>
									<td>
										<button type="button" class="btn btn-success" onclick="addInstitucion();">+</button>
									</td>
								</tr>
							</table>
							
						</div>		
					</div>
					<div class="row">
						<label class="lblAdd col-form-label">Perfil:</label>
						<div class="col-sm-3"  >
							<select id="editPerfil" name="editPerfil" class="form-control">
								<option value="0">Seleccione un Perfil</option>								
                                @foreach($perfiles as $value)
    								<option value="{{$value->id}}">{{$value->nombre}}</option>    								
    							@endforeach
                            </select>
                            <input type="hidden" id="hiddenPerfil">
						</div>		
					</div>
					<div class="row">
						<label class="lblAdd col-form-label">Vigente en SAN:</label>
						<div class="col-sm-5"  >
							<input type="checkbox" id="checkeditVigente"  class="vigencia-editar">
							<span class="badge badge-pill badge-danger" style="display:none"  id="mensaje-editar">Usuario quedara inactivo del sistema</span>
						</div>		
					</div>
    			</div>
    			<div class="modal-footer" style="background-color: white;">
    				<button type="button" class="btn btn-primary" onclick="editUsuario();">Guardar</button>
    				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
    			</div>
    		</div>
    	</div>
    </div>
    <div id="modalAddInstitucion" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog">
    	<div class="modal-dialog" role="document">
    		<div class="modal-content p-4">
    			<div class="modal-header">
    				<div style="margin: 0 auto;"><h5>Agregar Institución</h5></div>
    				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute; margin: 0; top: 5px; right: 33px;">
    					<span aria-hidden="true">&times;</span>
    				</button>
    			</div>
    			<div class="modal-body">
    									
					<div class="row">
						<label class="lblAdd col-form-label">Nombre:</label>
						<div class="col-sm-3"  >
							<input type="text" id="nomInstitucion" class="form-control">
						</div>		
					</div>
					
    			</div>
    			<div class="modal-footer" style="background-color: white;">
    				<button type="button" class="btn btn-primary" onclick="agregarInstitucion();">Agregar</button>
    				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
    			</div>
    		</div>
    	</div>
    </div>
    <!-- FIN DC SPRINT 66 -->
@endsection

@section('script')

	<script type="text/javascript">
	//INICIO CZ SPRINT 72 
	$( document ).ready(function() {
		getComunas();
		getRegion();
		$("#show_hide_password span").on('click', function(event) {
			event.preventDefault();
			if($('#clave').attr("type") == "text"){
				$('#clave').attr('type', 'password');
				$('#icono-ojo').addClass( "fa-eye-slash" );
				$('#icono-ojo').removeClass( "fa-eye" );
			}else if($('#clave').attr("type") == "password"){
				$('#clave').attr('type', 'text');
				$('#icono-ojo').removeClass( "fa-eye-slash" );
				$('#icono-ojo').addClass( "fa-eye" );
			}
		});
		$('.vigencia-editar').change(function() {
			if(!this.checked) {
				$("#mensaje-editar").css("display","initial");
			}else{
				$("#mensaje-editar").css("display","none");
			}
			       
    	});

		$('.vigencia-agregar').change(function() {
			if(!this.checked) {
				$("#mensaje-agregar").css("display","initial");
			}else{
				$("#mensaje-agregar").css("display","none");
			}
			       
    	});
	});
	//FIN CZ SPRINT 72 
		//INICIO DC SPRINT 66
		function agregarInstitucion(){
			var nomInst = $('#nomInstitucion').val();
			if(nomInst == ''){
				mensajeTemporalRespuestas(0, 'Ingrese una Institucion');
				$("#nomInstitucion").css("border","1px solid #FF0000");
			}else{
				let data = new Object();
        		data.nomInst = nomInst;
				$.ajax({
            		url: "{{ route('add.institucion') }}",
            		type: "GET",
            		data: data
            	}).done(function(resp){
            		if(resp.estado == 0){
            			mensajeTemporalRespuestas(1, resp.mensaje);
            			$('#modalAddInstitucion').modal('hide');
            			getInstituciones();
            		}else{
            			mensajeTemporalRespuestas(0, resp.mensaje);
            		}     			
            	}).fail(function(obj){
            		console.log(obj); return false;
            	});
			}
		}
		function getInstituciones(){
			let data = new Object();
			$.ajax({
            	url: "{{ route('get.instituciones') }}",
            	type: "GET",
            	data: data
            }).done(function(resp){ 
            	//formulario agregar usuario
            	$('#addInstituciones').html($('<option />', {
                	text: 'Seleccione una Institucion',
                    value: 0,
                }));
            	for (var i = 0; i < resp.length; i+=1) {
                	var id = resp[i].id_ins;
                	var nom = resp[i].nom_ins;
                	$('#addInstituciones').append($('<option />', {
                    	text: nom,
                        value: id,
                    }));
               }
               	//formulario editar usuario
            	$('#editInstituciones').html($('<option />', {
                	text: 'Seleccione una Institucion',
                    value: 0,
                }));
            	for (var i = 0; i < resp.length; i+=1) {
                	var id = resp[i].id_ins;
                	var nom = resp[i].nom_ins;
                	$('#editInstituciones').append($('<option />', {
                    	text: nom,
                        value: id,
                    }));
               	}
            }).fail(function(obj){
            	console.log(obj); return false;
            });
		}
		function addInstitucion(){
			$('#nomInstitucion').val('');
			$('#modalAddInstitucion').modal();
		}
		//INICIO CZ SPRINT 72 
		function eliminarDiacriticos(texto) {
			return texto.normalize('NFD').replace(/[\u0300-\u036f]/g,"");
		}

		function eliminarCaracterEspeciales(texto){
			return texto.replace(/[^a-zA-Z ]/g, "");
		}

		var Fn = {
			// Valida el rut con su cadena completa "XXXXXXXX-X"
			validaRut : function (rutCompleto) {
				if (!/^[0-9]+[-|‐]{1}[0-9kK]{1}$/.test( rutCompleto ))
					return false;
				var tmp 	= rutCompleto.split('-');
				var digv	= tmp[1]; 
				var rut 	= tmp[0];
				if ( digv == 'K' ) digv = 'k' ;
				return (Fn.dv(rut) == digv );
			},
			dv : function(T){
				var M=0,S=1;
				for(;T;T=Math.floor(T/10))
					S=(S+T%10*(9-M++%6))%11;
				return S?S-1:'k';
			}
		}
		//FIN CZ SPRINT 72 
		//INICIO CZ SPRINT 72 
		function getRunificador(){
			var run = $('#addRun').val();
			var dv = $('#addDV').val();
			var buscarPunto = run.indexOf(".");
			var buscarGuion = run.indexOf("-");
			if(buscarPunto != -1 || buscarGuion != -1 ){
				var runLimpio = limpiarFormatoRun(run);
				var dv =  runLimpio.substr(-1);
				run = runLimpio.slice(0, -1) 
				$('#addRun').val(run);
				$('#addDV').val(dv);
			var rut = run+'-'+dv;
				obtenerDatos(rut);
			}else if(run != "" && buscarPunto == -1 && dv == ""){
				var rut;
				var div1, div2, div3, div4;
				rut=run;

				if(rut.length==9){    
					div1=rut.slice(0,2);
					div2=rut.slice(2,5);
					div3=rut.slice(5,8);
					div4=rut.slice(8,9);

					$('#addRun').val(div1 + div2 + div3);
					$("#addDV").val(div4);
				}

				if(rut.length==8){    
					div1=rut.slice(0,1);
					div2=rut.slice(1,4);
					div3=rut.slice(4,7);
					div4=rut.slice(7,8);

					$('#addRun').val(div1 + div2 + div3);
					$("#addDV").val(div4);
				}
				rut = limpiarFormatoRun($('#addRun').val()) + "-" + $("#addDV").val(); 
				obtenerDatos(rut, );
			}else if(run != "" && dv != ""){
				var rut = limpiarFormatoRun(run)+'-'+dv;
				obtenerDatos(rut);
			}	
		}
		function buscarUsuarioSSO(rut){
			let data = new Object();
        		data.rut = rut;
			$.ajax({
				url: "{{ route('ver.sso') }}",
				type: "GET",
				data: data
			}).done(function(resp){       						
				if(resp.respuesta.Cantidad == 1){
					mensajeTemporalRespuestas(1, "Usuario ya se encuentra en el SSO");
					$("#addMail").val(resp.respuesta.Resultado.Usuario.Correo);	
					// $("#addMail").prop( "disabled", true );
					buscarBaseDatos($('#addRun').val());
				}else if(resp.respuesta.Cantidad == 2){
					$("#addMail").val(resp.respuesta.Resultado.Usuario[0].Correo);
					buscarBaseDatos($('#addRun').val());
				}else if(resp.respuesta.Cantidad == 0){
					mensajeTemporalRespuestas(0, "Usuario no existe en el SSO");
					buscarBaseDatos($('#addRun').val());
				}
				desbloquearPantalla();
			}).fail(function(obj){
				console.log(obj); return false;
			});
			
		}

		function buscarBaseDatos(run){
			let data = new Object();
        	data.run = run;
			$.ajax({
    			url: "{{ route('get.usuario') }}",
    			type: "GET",
    			data: data
    		}).done(function(resp){
    			var datos = JSON.parse(resp);
				if(datos.length >0){
					$("#addInstituciones").prop( "disabled", true );
					$('#addFono').prop( "disabled", true );
					$('#addRegion').prop( "disabled", true );
					$("#addComuna").prop( "disabled", true );
					$('#addPerfil').prop( "disabled", true );
					$('#hiddenPerfil').prop( "disabled", true );
					$("#botonGuardar").prop( "disabled", true );
					mensajeTemporalRespuestas(1, "Usuario registrado en el sistema");
					// $('#editRun').val(datos[0].run);
					// var dv = calculaDv(datos[0].run);
					// $('#editDV').val(dv);
					getComunas(datos[0].id_region);
					setTimeout(function(){
						
						$("#addInstituciones").val(datos[0].id_institucion);
						$('#addFono').val(datos[0].telefono);
						$('#addMail').val(datos[0].email);
						var region = "";
						if(datos[0].id_region.length == 1){
							region = "0" + datos[0].id_region;
						}else{
							region = datos[0].id_region;
						}
						$('#addRegion').val(region);
						$("#addComuna").val(datos[0].com_id);
						$('#addPerfil').val(datos[0].id_perfil);
						$('#hiddenPerfil').val(datos[0].id_perfil);
						$("#mensaje-SSO-SAN").css("display","block");
						}, 2000);
				
			
					if(datos[0].id_estado == 1){
						$("#checkeditVigente").prop("checked", true); 
					}else{
						$("#checkeditVigente").prop("checked", false);
					}
					
				}else{
					$("#mensaje-SSO-SAN").css("display","none");
					$("#botonGuardar").prop( "disabled", false );
					$("#addInstituciones").prop( "disabled", false );
					$('#addFono').prop( "disabled", false );
					$('#addRegion').prop( "disabled", false );
					$("#addComuna").prop( "disabled", false );
					$('#addPerfil').prop( "disabled", false );
					$('#hiddenPerfil').prop( "disabled", false );
					$('#addFono').val('');
					$('#addMail').val('');
					$('#addRegion').val(0);
					$('#addComuna').val(0);
					$('#addInstituciones').val(0);
					$('#addPerfil').val(0);
					$("#checkVigente").prop("checked", true);  
					$("#mensaje-SSO-SAN").css("display","none");
					mensajeTemporalRespuestas(0, "Usuario no registrado en el sistema");
				}
    			
    		}).fail(function(obj){
    			console.log(obj); return false;
				desbloquearPantalla()
    		});
		}
		function obtenerDatos(rut){
			if(Fn.validaRut(rut)){
			obtenerInformacionRunificador(rut).then(function(data) {
					var nombres = data.respuesta.Nombres.split(' ');
					var nombre = "";
					for(var i = 0; i < nombres.length; i++){
						nombre += ' ' + nombres[i].charAt(0).toUpperCase() + nombres[i].slice(1).toLowerCase()
					}
					$('#addNombres').val(nombre);
					$('#addApePat').val(data.respuesta.ApellidoPaterno.charAt(0).toUpperCase() + data.respuesta.ApellidoPaterno.slice(1).toLowerCase());
					$('#addApeMat').val(data.respuesta.ApellidoMaterno.charAt(0).toUpperCase() + data.respuesta.ApellidoMaterno.slice(1).toLowerCase());
					var clave1Diacriticos = eliminarDiacriticos(data.respuesta.ApellidoPaterno);
					var clave1SinCaracterEspeciales = eliminarCaracterEspeciales(clave1Diacriticos);
					var clave1 = clave1SinCaracterEspeciales.substr( 0, 3);
					var clave2 = $('#addRun').val().substr( 0, 4);
					var clave = clave1.split("").reverse().join("").toLowerCase()  + "." + clave2;
					clave = clave.charAt(0).toUpperCase() + clave.slice(1);
					$("#clave").val(clave);
					buscarUsuarioSSO($('#addRun').val() + "-" + $("#addDV").val());
					desbloquearPantalla();
			}).catch(function(error) {
					desbloquearPantalla();
                console.log(error);
            });
			}else{
				mensajeTemporalRespuestas(0, "El rut no contiene un formato valido");
		}
		}
		//FIN CZ SPRINT 72 
		//FIN DC SPRINT 66
		function soloNumeros(e){
        	var key = window.Event ? e.which : e.keyCode
        	return (key >= 48 && key <= 57)
        }
        function digVer(e){
        	var key = window.Event ? e.which : e.keyCode
        	if(key>=48 && key<=57 || key == 107) { // is a number.
              return true;
            } else{ // other keys.
              return false;
            }
        }
        var comunas = [];
        function addComuna(input, list){
			var idComuna = $('#'+input).val();
			var nomComuna = $('#'+input+' option:selected').html();
			var existe = 0;
			if(idComuna == 0){
				mensajeTemporalRespuestas(0, 'Seleccione una Comuna');
				$("#"+input).css("border","1px solid #FF0000");
			}else{
				for(var i = 0; i < comunas.length; i++){
					if(comunas[i][0] == idComuna){
						existe = 1;
					}
				}
				if(existe == 1){
					mensajeTemporalRespuestas(0, 'La Comuna ya existe');
				}else{
					$("#"+input).css("border","1px solid #d1d3e2");				
    				$('.'+list).append('<tr id="'+idComuna+'" class="itemComuna"><td width=300 class="tdComuna">'+nomComuna+'</td><td class="tdComuna"><button type="button" class="btn btn-danger btnDelComuna" onclick="delComunaEdit('+idComuna+');">-</button></td></tr>');
    				$('#'+input).val(0);
    				comunas.push([
                    	idComuna,
                    	nomComuna,
                    	1
                    ]);
				}
			}
		}
		function delComuna(idComuna){
			$('#'+idComuna).remove();
			for(var i = 0; i < comunas.length; i++){
				if(comunas[i][0] == idComuna){
					comunas.splice(i, 1);
				}
			}
		}
		function delComunaEdit(idComuna){
			$('#'+idComuna).remove();
			for(var i = 0; i < comunas.length; i++){
				if(comunas[i][0] == idComuna){
					comunas[i][2] = 0;
				}
			}
		}
		//INICIO DC SPRINT 67
        function editUsuario(){
        	var run = $('#editRun').val();
			var dv = $('#editDV').val();
			var nombres = $('#editNombres').val();
			var apePat = $('#editApePat').val();
			var apeMat = $('#editApeMat').val();
			var fono = $('#editFono').val();
			var mail = $('#editMail').val();
			var region = $('#editRegion').val();
			var comuna = $('#editComuna').val();
			var institucion = $('#editInstituciones').val();
			var perfil = $('#editPerfil').val();
			var id = $('#editId').val();
			var error = 0;
			var msj = '';
			if(fono == ''){
				msj = msj + '- Debe ingresar el Fono<br>';
				error = 1;
				$("#editFono").css("border","1px solid #FF0000");
			}else{
				$("#editFono").css("border","1px solid #d1d3e2");
			}
			if(mail == ''){
				msj = msj + '- Debe ingresar un Mail<br>';
				error = 1;
				$("#editMail").css("border","1px solid #FF0000");
			}else{
				var respMail = validarEmail(mail);
				if(respMail == false){
					error = 1;
					msj = msj + '- Debe ingresar un Mail valido<br>';
					$("#editMail").css("border","1px solid #FF0000");
				}else{
					$("#editMail").css("border","1px solid #d1d3e2");
				}
			}
			
			if(institucion == '0' || institucion == null){
				msj = msj + '- Debe seleccionar una Institución<br>';
				error = 1;
				$("#editInstituciones").css("border","1px solid #FF0000");
			}else{
				$("#editInstituciones").css("border","1px solid #d1d3e2");
			}
			if(perfil == '0' || perfil == null){
				msj = msj + '- Debe seleccionar una Perfil<br>';
				error = 1;
				$("#editPerfil").css("border","1px solid #FF0000");
			}else{
				$("#editPerfil").css("border","1px solid #d1d3e2");
			}
			if(error == 1){
				mensajeTemporalRespuestas(0, msj);
			}else{
				bloquearPantalla(); 
        		let data = new Object();
        		data.id = id;
        		data.fono = fono;
        		data.mail = mail;
        		data.region = region;
        		data.comuna = comuna;
        		data.institucion = institucion;
        		data.perfil = perfil;
        		data.rut = run+'-'+dv;
        		if($('#checkeditVigente').prop('checked')){ //Vigente
        			data.estado = 1;
        			//Verifica si usuario existe en SSO
        			$.ajax({
        			url: "{{ route('ver.sso') }}",
        			type: "GET",
        			data: data
        		}).done(function(resp){      
        					
        			if(resp.respuesta.Cantidad == 0){ //No existe en SSO
        				if(perfil != $('#hiddenPerfil').val()){ //se edita perfil
            					let data3 = new Object();
                            	data3.id = id;
                            	$.ajax({
                            		url: "{{ route('verificar.casos') }}",
                            		type: "GET",
                            		data: data3	
                            	}).done(function(resp){
                            		if(resp[0].existe > 0){ //Posee casos asociados
                            			mensajeTemporalRespuestas(0, 'El usuario posee casos asociados, no puede cambiar el Perfil');
                            			desbloquearPantalla();
                            		}else{ //No Posee casos asociados
                            			$.ajax({
                                        	url: "{{ route('editar.usuario') }}",
                                            type: "GET",
                                            data: data
                                       }).done(function(resp){
                                       		if(resp.estado == 0){
                                            	mensajeTemporalRespuestas(1, resp.mensaje);
                                            }else{
                                            	mensajeTemporalRespuestas(0, resp.mensaje);
                                            }
                                            desbloquearPantalla();
                                            procesarReporte();        			
                                       }).fail(function(obj){
                                       		console.log(obj); return false;
                                       });
                            		}
                				}).fail(function(obj){
                					console.log(obj); return false;
                				});
                            		
            				}else{ //mismo perfil
            					$.ajax({
                                	url: "{{ route('editar.usuario') }}",
                                    type: "GET",
                                    data: data
                               }).done(function(resp){
                               		if(resp.estado == 0){
                                    	mensajeTemporalRespuestas(1, resp.mensaje);
                                    }else{
                                    	mensajeTemporalRespuestas(0, resp.mensaje);
                                    }
                                    desbloquearPantalla();
                                    procesarReporte();        			
										$('#modalEditarUsuario').modal('hide');      			
                               }).fail(function(obj){
                               		console.log(obj); return false;
                               });
            				}
        			}else{ //Si existe en SSO
        			$.ajax({
            			url: "{{ route('addVigencia.sso') }}",
            			type: "GET",
            			data: data
            		}).done(function(resp){
            			console.log(resp);
            			if(resp.respuesta.Estado != 1){
            				mensajeTemporalRespuestas(0, resp.respuesta.Detalle);
            				desbloquearPantalla();
									$('#modalEditarUsuario').modal('hide');
            			}else{
            				if(perfil != $('#hiddenPerfil').val()){ //se edita perfil
            					let data3 = new Object();
                            	data3.id = id;
                            	$.ajax({
                            		url: "{{ route('verificar.casos') }}",
                            		type: "GET",
                            		data: data3	
                            	}).done(function(resp){
                            		if(resp[0].existe > 0){ //Posee casos asociados
                            			mensajeTemporalRespuestas(0, 'El usuario posee casos asociados, no puede cambiar el Perfil');
                            			desbloquearPantalla();
                            		}else{ //No Posee casos asociados
                            			$.ajax({
                                        	url: "{{ route('editar.usuario') }}",
                                            type: "GET",
                                            data: data
                                       }).done(function(resp){
                                       		if(resp.estado == 0){
                                            	mensajeTemporalRespuestas(1, resp.mensaje);
        		}else{
                                            	mensajeTemporalRespuestas(0, resp.mensaje);
                                            }
                                            desbloquearPantalla();
                                            procesarReporte();        			
													$('#modalEditarUsuario').modal('hide');  			
                                       }).fail(function(obj){
                                       		console.log(obj); return false;
                                       });
                            		}
                				}).fail(function(obj){
                					console.log(obj); return false;
                				});
                            		
            				}else{ //mismo perfil
            					$.ajax({
                                	url: "{{ route('editar.usuario') }}",
                                    type: "GET",
                                    data: data
                               }).done(function(resp){
                               		if(resp.estado == 0){
                                    	mensajeTemporalRespuestas(1, resp.mensaje);
                                    }else{
                                    	mensajeTemporalRespuestas(0, resp.mensaje);
                                    }
                                    desbloquearPantalla();
                                    procesarReporte();        			
											$('#modalEditarUsuario').modal('hide');    			
                               }).fail(function(obj){
                               		console.log(obj); return false;
                               });
            				}
            			}     			
            			
            		}).fail(function(obj){
            			console.log(obj); return false;
            		});
        			}
        		}).fail(function(obj){
        			console.log(obj); return false;
        		});
					//FIN CZ SPRINT 72 
        		}else{ //No Vigente
        			let data2 = new Object();
                	data2.id = id;
                	$.ajax({
                		url: "{{ route('verificar.casos') }}",
                		type: "GET",
                		data: data
                	}).done(function(resp){
                		console.log(resp[0].existe);
                		if(resp[0].existe > 0){ //Posee casos asociados
                			mensajeTemporalRespuestas(0, 'El usuario posee casos asociados, no puede quedar No Vigente');
                			desbloquearPantalla();
                		}else{ //No posee casos asociados
        			data.estado = 0;
                			
                			
                			$.ajax({
                    			url: "{{ route('ver.sso') }}",
                    			type: "GET",
                    			data: data
                    		}).done(function(resp){      
                    					
                    			if(resp.respuesta.Cantidad == 0){ //No existe en SSO
                    				$.ajax({
                            			url: "{{ route('editar.usuario') }}",
                            			type: "GET",
                            			data: data
                            		}).done(function(resp){
                            			if(resp.estado == 0){
                            				mensajeTemporalRespuestas(1, resp.mensaje);
                            			}else{
                            				mensajeTemporalRespuestas(0, resp.mensaje);
                            			}
                            			desbloquearPantalla();
                            			procesarReporte();        			
										$('#modalEditarUsuario').modal('hide');      			
                            		}).fail(function(obj){
                            			console.log(obj); return false;
                            		});
                    			}else{ //Si existe en SSO
								//INICIO CZ SPRINT 72 
                			//Quitar vigencia en SSO
                			$.ajax({
                    			url: "{{ route('vigencia.sso') }}",
                    			type: "GET",
                    			data: data
                    		}).done(function(resp){
                            			console.log(resp);
                    			if(resp.respuesta.Estado != 1){
                    				mensajeTemporalRespuestas(0, resp.respuesta.Detalle);
                    				desbloquearPantalla();
                    			}else{
        		$.ajax({
        			url: "{{ route('editar.usuario') }}",
        			type: "GET",
        			data: data
        		}).done(function(resp){
        			if(resp.estado == 0){
        				mensajeTemporalRespuestas(1, resp.mensaje);
        			}else{
        				mensajeTemporalRespuestas(0, resp.mensaje);
        			}
        			desbloquearPantalla();
        			procesarReporte();        			
												$('#modalEditarUsuario').modal('hide');      			
        		}).fail(function(obj){
        			console.log(obj); return false;
        		});
			}
                    		}).fail(function(obj){
                    			console.log(obj); return false;
                    		});
                		}     			
                	}).fail(function(obj){
                		console.log(obj); return false;
                	});
        }
                	}).fail(function(obj){
                		console.log(obj); return false;
                	});
        		}
        	//FIN CZ SPRINT 72 
			}
        }
        //FIN DC SPRINT 67
        function guardarComunasEdit(idUsuario){
        	for(var i = 0; i < comunas.length; i++){
				if(comunas[i][2] == 0){ //eliminados
					let data = new Object();
            		data.idUsuario = idUsuario;
            		data.idComuna = comunas[i][0];
            		$.ajax({
            			url: "{{ route('quitar.comunas') }}",
            			type: "GET",
            			data: data
            		}).done(function(resp){   
            			   			
            			if(resp.estado != 0){
            				mensajeTemporalRespuestas(0, resp.mensaje);
            			}
            		}).fail(function(obj){
            			console.log(obj); return false;
            		});
				}else{
					let data = new Object();
            		data.idUsuario = idUsuario;
            		data.idComuna = comunas[i][0];
            		$.ajax({
            			url: "{{ route('guardar.comunas') }}",
            			type: "GET",
            			data: data
            		}).done(function(resp){   
            			   			
            			if(resp.estado != 0){
            				mensajeTemporalRespuestas(0, resp.mensaje);
            			}
            		}).fail(function(obj){
            			console.log(obj); return false;
            		});
				}
			}
        }
        //INICIO CZ SPRINT 77
		function guardarUsuario_2(){
			var run = $('#addRun').val();
			var dv = $('#addDV').val();
			var nombres = $('#addNombres').val();
			var apePat = $('#addApePat').val();
			var apeMat = $('#addApeMat').val();
			var fono = $('#addFono').val();
			var mail = $('#addMail').val();
			var region = $('#addRegion').val();
			var institucion = $('#addInstituciones').val();
			var perfil = $('#addPerfil').val();
			var comuna = $('#addComuna').val();
			var error = 0;
			var msj = '';
			if(run == ''){
				msj = msj + '- Debe ingresar un RUN<br>';
				error = 1;
				$("#addRun").css("border","1px solid #FF0000");
			}else{
				$("#addRun").css("border","1px solid #d1d3e2");
			}
			if(dv == ''){
				msj = msj + '- Debe ingresar el Digito Verificador<br>';
				error = 1;
				$("#addDV").css("border","1px solid #FF0000");
			}else{
				$("#addDV").css("border","1px solid #d1d3e2");
			}
			if(run != '' && dv != ''){
				var resp = checkRut(run+'-'+dv);
				if(resp == false){
					msj = msj + '- Debe ingresar un RUN valido<br>';
					$("#addRun").css("border","1px solid #FF0000");
					$("#addDV").css("border","1px solid #FF0000");
					error = 1;
				}else{
					$("#addRun").css("border","1px solid #d1d3e2");
					$("#addDV").css("border","1px solid #d1d3e2");
				}
			}
			if(nombres == ''){
				msj = msj + '- Debe ingresar los Nombres<br>';
				error = 1;
				$("#addNombres").css("border","1px solid #FF0000");
			}else{
				$("#addNombres").css("border","1px solid #d1d3e2");
			}
			if(apePat == ''){
				msj = msj + '- Debe ingresar el Apellido Paterno<br>';
				error = 1;
				$("#addApePat").css("border","1px solid #FF0000");
			}else{
				$("#addApePat").css("border","1px solid #d1d3e2");
			}
			if(apeMat == ''){
				msj = msj + '- Debe ingresar el Apellido Materno<br>';
				error = 1;
				$("#addApeMat").css("border","1px solid #FF0000");
			}else{
				$("#addApeMat").css("border","1px solid #d1d3e2");
			}
			if(fono == ''){
				msj = msj + '- Debe ingresar el Fono<br>';
				error = 1;
				$("#addFono").css("border","1px solid #FF0000");
			}else{
				$("#addFono").css("border","1px solid #d1d3e2");
			}
			if(mail == ''){
				msj = msj + '- Debe ingresar un Mail<br>';
				error = 1;
				$("#addMail").css("border","1px solid #FF0000");
			}else{
				var respMail = validarEmail(mail);
				if(respMail == false){
					error = 1;
					msj = msj + '- Debe ingresar un Mail valido<br>';
					$("#addMail").css("border","1px solid #FF0000");
				}else{
					$("#addMail").css("border","1px solid #d1d3e2");
				}
			}
			if(region == '0' || region == null){
				msj = msj + '- Debe seleccionar una Región<br>';
				error = 1;
				$("#addRegion").css("border","1px solid #FF0000");
			}else{
				$("#addRegion").css("border","1px solid #d1d3e2");
			}
			if(institucion == '0' || institucion == null){
				msj = msj + '- Debe seleccionar una Institución<br>';
				error = 1;
				$("#addInstituciones").css("border","1px solid #FF0000");
			}else{
				$("#addInstituciones").css("border","1px solid #d1d3e2");
			}
			if(perfil == '0' || perfil == null){
				msj = msj + '- Debe seleccionar una Perfil<br>';
				error = 1;
				$("#addPerfil").css("border","1px solid #FF0000");
			}else{
				$("#addPerfil").css("border","1px solid #d1d3e2");
			}

			if(error == 1){
				mensajeTemporalRespuestas(0, msj);
			}else{
				bloquearPantalla(); 
        		let data = new Object();
        		data.run = run;
        		data.rut = run+'-'+dv;
        		data.nombres = nombres;
        		data.apePat = apePat;
        		data.apeMat = apeMat;
        		data.fono = fono;
        		data.mail = mail;
        		data.region = region;
        		data.institucion = institucion;
        		data.perfil = perfil;
        		data.comuna = comuna;
				data.clave = $("#clave").val();
        		if($('#checkVigente').prop('checked')){
        			data.estado = 1;
        		}else{
        			data.estado = 0;
        		}
        		//Verifica usuario en SSO
        		$.ajax({
        			url: "{{ route('ver.sso') }}",
        			type: "GET",
        			data: data
        		}).done(function(resp){      
        			if(resp.respuesta.Cantidad == 0){ //No existe en SSO
        				//Ingresa en SSO
        				$.ajax({
                			url: "{{ route('guardar.sso') }}",
                			type: "GET",
                			data: data
                		}).done(function(resp){  
                			console.log(resp);     			
                			//INICIO CZ SPRINT 72 		
                			if(resp.estado == '1'){ //Ingresado en SSO
                				//Guardar en BD
        	    $.ajax({
        			url: "{{ route('guardar.usuario') }}",
        			type: "GET",
        			data: data
        		}).done(function(resp){       			
                        			console.log(resp);    			
									if(resp.estado == 1){	
										// guardarComunas(resp.idUsuario, comuna);
        				mensajeTemporalRespuestas(1, resp.mensaje);
        				$('#modalAgregarUsuario').modal('hide');
        			}else{
        				mensajeTemporalRespuestas(0, resp.mensaje);
        			}
        			desbloquearPantalla();
        		}).fail(function(obj){
        			console.log(obj); return false;
        		});
                			}else{ //Error en SSO
								console.log(resp);
								//FIN CZ SPRINT 72 
                				mensajeTemporalRespuestas(0, resp.respuesta.Detalle);
                			}
                			desbloquearPantalla();
                		}).fail(function(obj){
                			console.log(obj); return false;
                		});
        			}else{ //Si existe en SSO
        				//Guardar en BD
                				$.ajax({
                        			url: "{{ route('guardar.usuario') }}",
                        			type: "GET",
                        			data: data
                        		}).done(function(resp){     			
                        			if(resp.estado == 0){	
                        				// guardarComunas(resp.idUsuario, comuna);
                        				mensajeTemporalRespuestas(1, resp.mensaje);
                        				$('#modalAgregarUsuario').modal('hide');
                        			}else{
                        				mensajeTemporalRespuestas(0, resp.mensaje);
                        			}
                        			desbloquearPantalla();
                        		}).fail(function(obj){
                        			console.log(obj); return false;
                        		});
        			}
        		}).fail(function(obj){
        			console.log(obj); return false;
        		});
        		
			}
		}
		//FIN DC SPRINT 67
		
		function guardarComunas(idUsuario, comuna){
				let data = new Object();
        		data.idUsuario = idUsuario;
        	data.idComuna = comuna;
        		$.ajax({
        			url: "{{ route('guardar.comunas') }}",
        			type: "GET",
        			data: data
        		}).done(function(resp){       			
        			if(resp.estado != 0){
        				mensajeTemporalRespuestas(0, resp.mensaje);
        			}
        		}).fail(function(obj){
        			console.log(obj); return false;
        		});
			}
		
		function validarEmail(valor) {
          if (/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i.test(valor)){
           return true;
          } else {
           return false;
          }
        }
		//INICIO CZ SPRINT 72 
		// function getComuna(region, input){
		// 	bloquearPantalla(); 
    	// 	let data = new Object();
    	// 	data.region = region;
    	//     $.ajax({
    	// 		url: "{{ route('get.comunas') }}",
    	// 		type: "GET",
    	// 		data: data
    	// 	}).done(function(resp){
    	// 		var dato = JSON.parse(resp);
    	// 		$('#'+input).html($('<option />', {
        //         	text: 'Seleccione una Comuna',
        //             value: 0,
        //         }));
        //         for (var i = 0; i < dato.length; i+=1) {
        //         	$('#'+input).append($('<option />', {
        //             	text: dato[i].com_nom,
        //                 value: dato[i].com_id,
        //             }));
        //         }
    	// 		desbloquearPantalla();
    	// 	}).fail(function(obj){
    	// 		console.log(obj); return false;
    	// 	});
		// }
		//FIN CZ SPRINT 72 
		function agregarUsuario(){
			comunas.length = 0;
			$('.listComuna').html('');
			$('#addRun').val('');
			$('#addDV').val('');
			$('#addNombres').val('');
			$('#addApePat').val('');
			$('#addApeMat').val('');
			$('#addFono').val('');
			$('#addMail').val('');
			//INICIO CZ SPRINT 72 
			$('#clave').val('');
			//FIN CZ SPRINT 72 
			$('#addRegion').val(0);
			$('#addComuna').val(0);
			$('#addInstituciones').val(0);
			$('#addPerfil').val(0);
			//INICIO CZ SPRINT 72 
			$("#botonGuardar").prop( "disabled", false );
			$('#addFono').prop( "disabled", false );
			$('#addMail').prop( "disabled", false );
			$('#addRegion').prop( "disabled", false );
			$('#addComuna').prop( "disabled", false );
			$('#addInstituciones').prop( "disabled", false );
			$('#addPerfil').prop( "disabled", false );
			//FIN CZ SPRINT 72 
			$("#checkVigente").prop("checked", true);  
			//INICIO CZ SPRINT 72 
			$("#mensaje-SSO-SAN").css("display","none");
			//FIN CZ SPRINT 72 
			$("#addRun").css("border","1px solid #d1d3e2");
			$("#addDV").css("border","1px solid #d1d3e2");
			$("#addNombres").css("border","1px solid #d1d3e2");
			$("#addApePat").css("border","1px solid #d1d3e2");
			$("#addApeMat").css("border","1px solid #d1d3e2");
			$("#addFono").css("border","1px solid #d1d3e2");
			$("#addMail").css("border","1px solid #d1d3e2");
			$("#addRegion").css("border","1px solid #d1d3e2");
			$("#addComuna").css("border","1px solid #d1d3e2");
			$("#addInstituciones").css("border","1px solid #d1d3e2");
			$("#addPerfil").css("border","1px solid #d1d3e2");
			$('#modalAgregarUsuario').modal();
		}
		
		function calculaDv(rut){
			// type check
        	if (!rut || !rut.length || typeof rut !== 'string') {
        		return -1;
        	}
        	// serie numerica
        	var secuencia = [2,3,4,5,6,7,2,3];
        	var sum = 0;
        	//
        	for (var i=rut.length - 1; i >=0; i--) {
        		var d = rut.charAt(i)
        		sum += new Number(d)*secuencia[rut.length - (i + 1)];
        	};
        	// sum mod 11
        	var rest = 11 - (sum % 11);
        	// si es 11, retorna 0, sino si es 10 retorna K,
        	// en caso contrario retorna el numero
        	return rest === 11 ? 0 : rest === 10 ? "K" : rest;
		}
		
		function editarUsuario(id){
			comunas.length = 0;
			$('.listComunaEdit').html('');
			$("#checkeditVigente").prop("checked", false);  
			$("#editRun").css("border","1px solid #d1d3e2");
			$("#editDV").css("border","1px solid #d1d3e2");
			$("#editNombres").css("border","1px solid #d1d3e2");
			$("#editApePat").css("border","1px solid #d1d3e2");
			$("#editApeMat").css("border","1px solid #d1d3e2");
			$("#editFono").css("border","1px solid #d1d3e2");
			$("#editMail").css("border","1px solid #d1d3e2");
			$("#editRegion").css("border","1px solid #d1d3e2");
			$("#editComuna").css("border","1px solid #d1d3e2");
			$("#editInstituciones").css("border","1px solid #d1d3e2");
			$("#editPerfil").css("border","1px solid #d1d3e2");
			bloquearPantalla(); 
    		let data = new Object();
    		data.id = id;
    		$('#editId').val(id);
    	    $.ajax({
    			url: "{{ route('get.usuario') }}",
    			type: "GET",
    			data: data
    		}).done(function(resp){
    			var datos = JSON.parse(resp);
    			$('#editRun').val(datos[0].run);
    			var dv = calculaDv(datos[0].run);
    			$('#editDV').val(dv);
    			$('#editNombres').val(datos[0].nombres);
    			$('#editApePat').val(datos[0].apellido_paterno);
    			$('#editApeMat').val(datos[0].apellido_materno);
    			$('#editFono').val(datos[0].telefono);
    			$('#editMail').val(datos[0].email);
				//INICIO CZ SPRINT 72 
				var region = "";
				if(datos[0].id_region.length == 1){
					region = "0" + datos[0].id_region;
				}else{
					region = datos[0].id_region;
				}
				//FIN CZ SPRINT 72 
				$('#editRegion').val(region);
    			$('#editInstituciones').val(datos[0].id_institucion);
    			$('#editPerfil').val(datos[0].id_perfil);
    			$('#hiddenPerfil').val(datos[0].id_perfil);
    			if(datos[0].id_estado == 1){
    				$("#checkeditVigente").prop("checked", true); 
    			}else{
    				$("#checkeditVigente").prop("checked", false);
    			}
    			desbloquearPantalla();
    		}).fail(function(obj){
    			console.log(obj); return false;
    		});
    		getComunasUsuario(id);
    		$('#modalEditarUsuario').modal();
    	}
    	
    	function getComunasUsuario(idUsuario){
    		let data = new Object();
    		data.id = idUsuario;
    	    $.ajax({
    			url: "{{ route('get.comuna.usuario') }}",
    			type: "GET",
    			data: data
    		}).done(function(resp){
    			var datos = JSON.parse(resp);
    			var com_nom = datos[0].com_nom;
    			var com_id = datos[0].com_id;
    			$('#editComuna').html($('<option />', {
                	text: datos[0].com_nom,
                    value: datos[0].com_id,
                }));
    		}).fail(function(obj){
    			console.log(obj); return false;
    		});
    	}
//INICIO CZ SPRINT 72 
		function getComunas(datos = null){
			let data = new Object();
    		data.region = datos;
    	    $.ajax({
    			url: "{{ route('get.comunas') }}",
    			type: "GET",
				data: data,
    		}).done(function(resp){
				if(datos != null){
					
					$('#addComuna').html($('<option />', {
                	text: 'Seleccione una Comuna',
                    value: 0,
                }));
                for (var i = 0; i < resp.length; i+=1) {
                	$('#addComuna').append($('<option />', {
                    	text: resp[i].com_nom,
                        value: resp[i].com_id,
                    }));
                }
				}else{
					$('#opc_oln').html($('<option />', {
                	text: 'Seleccione una Comuna',
                    value: 0,
                }));
                for (var i = 0; i < resp.length; i+=1) {
                	$('#opc_oln').append($('<option />', {
                    	text: resp[i].com_nom,
                        value: resp[i].com_id,
                    }));
                }
				}
				
    			desbloquearPantalla();
    		}).fail(function(obj){
    			console.log(obj); return false;
    		});
    	}

		function getRegion(){
    		let data = new Object();
    	    $.ajax({
    			url: "{{ route('get.regiones') }}",
    			type: "GET",
    		}).done(function(resp){
				
					$('#addRegion').html($('<option />', {
						text: 'Seleccione una Region',
						value: 0,
                	}));
                for (var i = 0; i < resp.length; i+=1) {
                	$('#editRegion').append($('<option />', {
                    	text: resp[i].reg_nom,
                        value: resp[i].reg_cod,
                    }));
                }
				for (var i = 0; i < resp.length; i+=1) {
                	$('#addRegion').append($('<option />', {
                    	text: resp[i].reg_nom,
                        value: resp[i].reg_cod,
                    }));
                }
    			desbloquearPantalla();
    		}).fail(function(obj){
    			console.log(obj); return false;
    		});
    	}
//FIN CZ SPRINT 72 
		function validarOpcion(){

			$("#opc_oln").removeClass("is-invalid");
			
			$("#cbxPerfil").removeClass("is-invalid");

			let respuesta = true;

			let opc_oln = $('#opc_oln option:selected').val();
			
			let perfil = $('#cbxPerfil option:selected').val();

			if (opc_oln == "" || typeof opc_oln === "undefined"){
				respuesta = false;
				$("#opc_oln").addClass("is-invalid");
				
			}
			
			
			return respuesta;

		}

		function procesarReporte(){
			let data = new Object();
			let resp = validarOpcion();

			if(!resp){
				mensajeTemporalRespuestas(0, 'Seleccione la OLN para generar el reporte'); 
				return false;
			}

			bloquearPantalla();

			data.option = 2;				

			$.ajax({

				url: "{{ route('reportes.usuarios.cargar') }}",
				type: "GET",
				data: data,
				timeout: 12000

			}).done(function(resp){
				desbloquearPantalla();

				if (resp.estado == 1){
					$("#reporte-contenido").html(resp.respuesta);

				}else if(resp.estado == 0){
					let mensaje = "Ocurrio un error al momento de desplegar el reporte solicitado. Por favor intente nuevamente.";
					mensajeTemporalRespuestas(0, mensaje); 

					return false;
				}
			}).fail(function(objeto, tipoError, errorHttp){
				let cantidad_intentos = (recargar + 1);

				if (cantidad_intentos < 3){ 
					procesarReporte(option, comunas, cantidad_intentos);

				}else{
					desbloquearPantalla();

					manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

					return false;
				}
			});
		
		}
		
		function checkRut(rut) {
            // Despejar Puntos
            var valor = rut;
            // Despejar Gui�n
            valor = valor.replace('-','');
            
            // Aislar Cuerpo y D�gito Verificador
            cuerpo = valor.slice(0,-1);
            dv = valor.slice(-1).toUpperCase();
            
            // Formatear RUN
            rut.value = cuerpo + '-'+ dv
            
            // Si no cumple con el m�nimo ej. (n.nnn.nnn)
            if(cuerpo.length < 7) { return false;}
            
            // Calcular D�gito Verificador
            suma = 0;
            multiplo = 2;
            
            // Para cada d�gito del Cuerpo
            for(i=1;i<=cuerpo.length;i++) {
            
                // Obtener su Producto con el M�ltiplo Correspondiente
                index = multiplo * valor.charAt(cuerpo.length - i);
                
                // Sumar al Contador General
                suma = suma + index;
                
                // Consolidar M�ltiplo dentro del rango [2,7]
                if(multiplo < 7) { multiplo = multiplo + 1; } else { multiplo = 2; }
          
            }
            
            // Calcular D�gito Verificador en base al M�dulo 11
            dvEsperado = 11 - (suma % 11);
            
            // Casos Especiales (0 y K)
            dv = (dv == 'K')?10:dv;
            dv = (dv == 0)?11:dv;
            
            // Validar que el Cuerpo coincide con su D�gito Verificador
            if(dvEsperado != dv) { return false; }
            
            // Si todo sale bien, eliminar errores (decretar que es v�lido)
            return true;
        }
	</script>
@endsection