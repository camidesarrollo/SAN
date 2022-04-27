<!-- INICIO DC -->
<style>
.isDisabled {
  cursor: not-allowed;
  opacity: 0.5;
  pointer-events: none;
}
</style>
<!-- FIN DC -->
<div class="card colapsable shadow-sm" id="contenedor_listar_bitacora">
    <a class="btn text-left p-0 collapsed" id="desplegar_listar_bitacora" data-toggle="collapse" data-target="#listar_bitacora" aria-expanded="false" aria-controls="listar_bitacora" onclick="if($(this).attr('aria-expanded') == 'false') mostrarBitacora();">
		<div class="card-header p-3">
			<h5 class="mb-0">
				<button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
				&nbsp;&nbsp;Resumen Bitácoras del Gestor/a Comunitario
			</h5>
		</div>
	</a>

	<div class="collapse" id="listar_bitacora">
		<div class="card-body">
    		@includeif('gestor_comunitario.bitacora.listar_bitacora')	
		</div>
	</div>
</div>

<div class="card colapsable shadow-sm" id="contenedor_formulario_bitacora">
    <a class="btn text-left p-0 collapsed" id="desplegar_formulario_bitacora" data-toggle="collapse" data-target="#formulario_bitacora" aria-expanded="false" aria-controls="formulario_bitacora" onclick="if($(this).attr('aria-expanded') == 'false') mostrarFormularioBitacora();">
		<div class="card-header p-3">
			<h5 class="mb-0">
				<button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
				&nbsp;&nbsp;Bitácora del Gestor/a Comunitario
			</h5>
		</div>
	</a>

	<div class="collapse" id="formulario_bitacora">
		<div class="card-body">
    		@includeif('gestor_comunitario.bitacora.formulario_bitacora')
		</div>
	</div>
</div>
<script type="text/javascript">
function desplegarSeccionBitacora(opcion){
		switch(opcion){
			case 1: //LISTADO BITACORA
				$("#contenedor_listar_bitacora").show().fadeIn(1000);
				$("#contenedor_formulario_bitacora").hide().fadeOut(1000);

				$("#desplegar_listar_bitacora").click();
			break;

			case 2: //FORMULARIO BITACORA
				$("#contenedor_formulario_bitacora").show().fadeIn(1000);
				$("#contenedor_listar_bitacora").hide().fadeOut(1000);
				
				$("#desplegar_formulario_bitacora").click();
			break;

			case 3: //AMBOS
				$("#contenedor_listar_bitacora").show().fadeIn(1000);
				$("#contenedor_formulario_bitacora").show().fadeIn(1000);
			break;
		}
}

function mostrarBitacora(){
	$('#listar_bitacora').collapse('show');
	setTimeout(function(){ listarBitacora(); }, 1000);
}

function ocultarBitacora(){
	$('#listar_bitacora').collapse('hide');
}

function mostrarFormularioBitacora(){
	ocultarBitacora();

    $('#formulario_bitacora').collapse('show');
    $('#informacion_bitacora').collapse('show');
}

function ocultarFormularioBitacora(){
	$('#formulario_bitacora').collapse('hide');
    $('#informacion_bitacora').collapse('hide');
}
</script>

