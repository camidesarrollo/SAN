<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9">
<link rel="stylesheet" href="css/ie8.css">
<![endif]-->
<!--[if gt IE 8]><!--> <html lang="es" class="no-js"> <!--<![endif]-->
<head>
	@include('layouts.head')
	@include('layouts.estilos')
	@yield('estilos')
</head>
<!-- inicio modal zModal -->
<div class="modal fade" id="zModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content" id="body1"></div>
	</div>
</div>
<!-- fin modal zModal -->

<!--Modal mensajes-->
<div id="modalMsj" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" >
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalMsjLabel">Información</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="msjInfo">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
			</div>
		</div>
	</div>
</div>
<!-- /.modal -->
<!-- modal xModal -->
<div class="modal fade" id="xModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="xModalTitle"></h4>
			</div>
			<div class="modal-body" id="body1" style="overflow-y:auto;"></div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button  type="button" class="btn btn-primary" data-loading-text="Guardando..." id="btnGuardar"   onclick=" enviaFormModal('#frmEditarInstitucion', '#msgerror', 'btnGuardado(\'#btnGuardar\')', ''); cargaTablaParametros();">Aceptar</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- / .modal xModal -->

<body class="archive">
	@include('caso.historial_notificacion')
	@include('layouts.header_main')
	<div class="wrapper">
		
		<!-- Sidebar  -->
		@include('layouts.menu')
		<!-- FIN Sidebar  -->
		
		<!-- MAIN  -->
		<main id="content">
			@yield('contenido')
		</main>
		<!-- FIN MAIN -->
	</div>
	@include('layouts.footer')
	@include('layouts.scripts')
	@yield('script')
</body>
</html>