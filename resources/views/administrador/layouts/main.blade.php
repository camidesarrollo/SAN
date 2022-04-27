<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ config('app.name') }}</title>
<style>
	form { margin:0px; padding: 0px;}
</style>
	{{ HTML::style( 'administrador/css/jquery-ui.css?v='.date("YmdHis"))  }}
	{{ HTML::style( 'administrador/css/bootstrap.min.css?v='.date("YmdHis"))  }}
	{{ HTML::style( 'administrador/css/metisMenu/metisMenu.min.css')  }}
	{{ HTML::style( 'administrador/css/admin.css?v='.date("YmdHis"))  }}
	{{ HTML::style( 'administrador/font-awesome/css/font-awesome.min.css')  }}
	{{ HTML::style( 'administrador/css/dataTables.bootstrap.min.css') }}
</head>

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

<!--Modal mensajes-->
<div id="modalMsj" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">Información</h4></div>
            <div class="modal-body" id="msjInfo"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<body>
<div id="wrapper">
  <div id="page-wrapper2">
    <header>

      <div class="bicolor"><span class="blue"></span><span class="red"></span></div>
      <h2 class="blue"><strong>Sistema Alerta Temprana Infancia </strong></h2>

    </header>
    <section id="content">

    @if (Auth::check())

        @include('administrador.layouts.menu')

    @endif

@section('contenido')

@show

			<div class="row">
				<div class="col-sm-12"></div>
			</div>
		</div>
	</section>
</div>
<iframe id="ifrm" style="display:none;" name="ifrm"></iframe>  <!-- footer area -->

	<footer>
		<div class="wrapper clearfix">
			<div class="bicolor"><span class="blue"></span><span class="red"></span></div>
				<div class="top">
					<div class="listas"></div>
					<div class="cf"></div>
					<div class="sep"></div>
				</div>
			<div class="bottom">
				<div class="cf"></div>
				<div class="logo">
					<a href="http://www.ministeriodesarrollosocial.gob.cl/" target="_blank">
						<span>Ministerio de Desarrollo Social</span></a>
				</div>
			</div>
		</div>
	</footer>
	<!-- #end footer area -->
</div>



{{ HTML::script('administrador/js/jquery-3.2.1.min.js') }}
{{ HTML::script('administrador/js/jquery-ui.js?v=' . date("YmdHis")) }}
{{ HTML::script('administrador/js/bootstrap.min.js') }}
{{ HTML::script('/js/jquery.dataTables.min.js') }}
{{ HTML::script('administrador/js/dataTables.bootstrap.min.js') }}
{{ HTML::script('administrador/js/app.js?v=' . date("YmdHis")) }}

<script type="text/javascript">
	$(document).ready(function () {
		$('#sidebarCollapse').on('click', function () {
			$('#sidebar').toggleClass('active');
		});

		$('.modal').on("hidden.bs.modal", function (e) { //fire on closing modal box
			if ($('.modal:visible').length) { // check whether parent modal is opend after child modal close
				$('body').addClass('modal-open'); // if open mean length is 1 then add a bootstrap css class to body of the page
			}
		});
		//this code segment will activate parent modal dialog
		//after child modal box close then scroll problem will automatically fixed
	});
</script>

@section('js')

@show

</body>
</html>
