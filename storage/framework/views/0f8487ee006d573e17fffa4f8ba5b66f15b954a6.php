<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9">
<link rel="stylesheet" href="css/ie8.css">
<![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->

<head>
	<?php echo $__env->make('layouts.head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php echo $__env->make('layouts.estilos', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</head>
<body class="archive">
	<?php echo $__env->make('layouts.header_login', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	
	<!-- MAIN -->
	<main>
			<section class="section bg-celeste p-4">
			  <div class="container">
			    <div class="row">
						<div class="col-12 col-md-8 p-3">
							<article class="article ">
					          <h3 class="article_title ">Bienvenido al <span style="font-weight: 700">Sistema Alerta Niñez</span></h3>
					          <hr>
					          <p>Este Sistema contiene un instrumento de focalización e información de contexto en una plataforma de gestión que permitirá identificar a los NNA con índice de mayor riesgo, así como también registrar las acciones vinculadas con la gestión del caso y las intervenciones familiares que se realicen en el contexto de las Oficinas Locales de la Niñez</p>
					        </article>
						</div>
						<div class="col-12 col-md-4 p-3 text-center">
							<div class="card p-3">
								<h3 class="text-dark">Acceso</h3>
								<p class="text-dark">Ingrese al <?php echo e(env('APP_NAME')); ?></p>
								<hr class="half-rule">
								<a href="<?php echo e(env('SSO_URL') . "?AID=" . env('SSO_AID')); ?>" class="btn btn-primary btn-lg"><span class="oi oi-account-login"></span> Acceder</a> 

								
								
							</div>
						</div>
					</div>
			  </div>
			</section>


			<section class="bg-gris p-3">
				<div class="container">

					<div class="row">
						<div class="col-lg-4 text-center">
							<a href="http://www.creciendoconderechos.gob.cl/" target="_blank" >
								<img src="http://www.ministeriodesarrollosocial.gob.cl/storage/image/banner-CreciendoconDerechos.png" alt="" class="shadow-sm">
							</a>
						</div>

						<div class="col-lg-4  text-center">
							<a href="http://www.crececontigo.gob.cl/" target="_blank" >
								<img src="http://www.ministeriodesarrollosocial.gob.cl/storage/images/banner/chcc.png" alt="" class="shadow-sm">
							</a>
						</div>

						<div class="col-lg-4  text-center">
							<a href="http://www.chileseguridadesyoportunidades.gob.cl/" target="_blank" >
								<img src="http://www.ministeriodesarrollosocial.gob.cl/storage/image/banner-ssyoo.png" alt="" class="shadow-sm">
							</a>
						</div>

					</div>	

				</div>
			</section>

	</main>
	<!-- FIN MAIN -->

	<?php echo $__env->make('layouts.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php echo $__env->make('layouts.scripts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</body>
</html>
