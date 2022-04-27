<!DOCTYPE html>
<html lang="es" class="no-js">
<head>
	<script type="text/javascript" src="/js/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="/js/bootstrap.min.js"></script>
	<link rel='stylesheet' type='text/css' href="/css/bootstrap.css" >

	<style type="text/css">
		#conf_div_ses_cont{
			position: absolute; 
			height: 100%; 
			width: 100%; 
			background-color: grey;
		}

		#conf_div_ses_sub_cont{
			position: relative; 
			width: 300px; 
			top: 50%; 
			margin: 0 auto; 
			transform: translateY(-50%);
			background-color: white; 
		}

	</style>
</head>
<body >
<div id="conf_div_ses_cont">
	<div id="conf_div_ses_sub_cont">
			<div class="card text-center">
 				 <div class="card-header">
			 		<h5 class="card-title" style="margin-bottom: 0;">Cambiar Comuna</h5>
 				 </div>

				 <div class="card-body text-left" style="padding-top: 10px; padding-bottom: 10px;">
				 	<p class="card-text text-muted" style="margin-bottom: 10px;">Seleccione una comuna: </p>
				    <form id="seleccion_comuna_form" action="<?php echo route('configuracion.comuna.aplicar') ?>">
				    	<select class="custom-select" name="comuna_seleccionada" id="conf_com_def">
				    		<option value="" selected>Seleccione una opción</option>	
				    		<?php foreach (session()->all()["comunas"] AS $c1 => $v1): ?>
				    			<option value="<?php echo $c1; ?>"><?php echo $v1->com_nom; ?></option>
				    		<?php endforeach ?>
						</select>	
						<p id="val_conf_com_def" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe seleccionar una comuna.</p>	
					</form>	
				 </div>

				 <div class="card-footer">
				   	<button type="button" class="btn btn-success" onclick="accederSesion();">Acceder</button>
 				 	<button type="button" class="btn btn-danger" onclick="salirSesion();">Salir</button>
				 </div>
			</div>
	</div>
</div>
<script type="text/javascript">
	function accederSesion(){
		let validacion = validarConfiguracionDeComuna();
		if (validacion == false) return false;
		
		$("#seleccion_comuna_form").submit();
	}

	function salirSesion(){
		localStorage.removeItem('Numero');

		window.location.href = "<?php echo route('logout') ?>";
	}

	function validarConfiguracionDeComuna(){
		let respuesta = true;
		let comuna = document.getElementById("conf_com_def").value;

		$("#val_conf_com_def").hide();
		$("#conf_com_def").removeClass("is-invalid");

		if (comuna.trim() == "" || typeof comuna === "undefined"){
			respuesta = false;
			$("#val_conf_com_def").show();
			$("#conf_com_def").addClass("is-invalid");

		}

		return respuesta;
	}
</script>
</body>
</html>