@extends('layouts.main')
@section('contenido')


<style type="text/css">
	
.multiselect-container>li {

	width:200px;
	padding:0px;
	margin:0px;

}

</style>	
	<main id="content">
		<section class="p-1 cabecera">
			<div class="container-fluid">
				<div class="row align-items-center">
					<div class="col-md-12">
						<h5><i class="{{$icono}}"></i>Usuarios por OLN</h5>
					</div>
				</div>
			</div>
		</section>

		<section>
			<div class="container-fluid">
				<div class="card p-4 shadow-sm">
					<div class="form-group row">
						<label for="inputPassword" class="col-sm-4 col-form-label"><b>Elije la comunidad que deseas ver</b></label>
						<div class="col-sm-3"  >
                            <select id="opc_oln" name="opc_oln" class="form-control">
								<option value="">Selecciona una Opcion</option><!-- CZ SPRINT 76 -->
								@php $getComunas = Helper::getComunas(); @endphp		<!-- CZ SPRINT 76 -->						
                                @foreach ($getComunas AS $c1 => $v1)<!-- CZ SPRINT 76 -->
                                    <option value="{{$v1->com_id}}">{{$v1->com_nom}}</option>
                                @endforeach
                            </select>
						</div>
						<div class="col-5 text-right"  >
							<button type="submit" class="btn btn-primary" onclick="procesarReporte();">Filtrar</button>
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
@endsection

@section('script')

	<script type="text/javascript">

		function validarOpcion(){

			$("#opc_oln").removeClass("is-invalid");

			let respuesta = true;

			let opc_oln = $('#opc_oln option:selected').val();

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

			data.option = 1;				

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
	</script>
@endsection