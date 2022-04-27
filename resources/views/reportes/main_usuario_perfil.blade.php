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
						<h5><i class="{{$icono}}"></i>Usuarios por Perfil</h5>
					</div>
				</div>
			</div>
		</section>

		<section>
			<div class="container-fluid">
				<div class="card p-4 shadow-sm">
					<div class="form-group row">
						<label for="inputPassword" class="col-sm-3 col-form-label"><b>Elije el perfil que deseas ver</b></label>
						<div class="col-sm-6">							
                            <select class="form-control" name="per_usu" id="per_usu">
								<option value="">Selecciona una Opcion</option>									
                            </select>
						</div> 	
						<div class="col-3 text-right"  >
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
		
		$(function() {
			getUsuariosPerfil();
		});	

		function getUsuariosPerfil(){

			$.ajax({
				type: "GET",  
				url: "{{ route('lista.usuario.perfil') }}"
			}).done(function(resp){
				console.log(resp.perfil);
				perfil = resp.perfil;
				$.each(perfil, function(i, item){
						$('#per_usu').append('<option value="'+ item.id +'">'+item.nombre+'</option>');
				});
				
			}).fail(function(objeto, tipoError, errorHttp){
				desbloquearPantalla();

				manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

				return false;
			});
		}

		function validarOpcion(){

			$("#per_usu").removeClass("is-invalid");

			let respuesta = true;

			let per_usu = $('#per_usu option:selected').val();

			if (per_usu == "" || typeof per_usu === "undefined"){
                respuesta = false;
                $("#per_usu").addClass("is-invalid");
                
			}
			
			return respuesta;

		}
		// CZ SPRINT 77
		let recargar = 0;
		
		function procesarReporte(){

			let data = new Object();

			let resp = validarOpcion();

			if(!resp){
				mensajeTemporalRespuestas(0, 'Seleccione un Perfil para generar el reporte'); 
				return false;
			}

			bloquearPantalla();
			
			data.option = 0;
			data.id_perfil = 2;					
			
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
				// CZ SPRINT 77
				recargar = recargar +1;
				if (cantidad_intentos < 3){ 
        			procesarReporte(option, comunas, cantidad_intentos);
      
      			}else{
					  // CZ SPRINT 77
					recargar = 0;
					desbloquearPantalla();

					manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

					return false;
      			}
			});
		}
	</script>
@endsection