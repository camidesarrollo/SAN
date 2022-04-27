		<!-- HIDDEN -->
		 <input type="hidden" id="url_runificador" value="<?php echo e(route('consulta.runificador')); ?>">
		<!-- HIDDEN  -->

		<nav id="sidebar" class="est_men_izq">
            <div class="sticky-top">
                <button id="sidebarCollapse" class="btn" onclick="cambiarMenu();">
                    <span id="bot-menu" class="fa fa-bars" data-toggle="tooltip" data-placement="right" title="Menu"></span>

                    <span id="bot-esconder" class="fa fa-angle-left" data-toggle="tooltip" data-placement="right" title="Esconder"></span>
                </button>
                <div class="sidebar-header">
                    <p class="vertical-text p-2"><?php echo e(ucfirst(Session::get('tipo_perfil'))); ?></p>
                </div>
                <ul class="list-unstyled components">
                	<li><a href="<?php echo e(route('main')); ?>" data-toggle="tooltip" data-placement="right" title="Inicio"><i class="fa fa-home"></i> <span>Inicio</span></a></li>
	
					<!-- roles -->
					<?php if(Session::get('menupri')): ?>
						<?php $__currentLoopData = Session::get('menupri'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<li>
								<?php if($menu->nombre): ?>
									<span class="titulo"><?php echo e($menu->nombre); ?></span>
									
			<!-- 						 -->
			<!-- 					<?php else: ?>
									<a href="<?php echo e(env('APP_URL').$rol->ruta); ?>" ><?php echo e($menu->nombre); ?><span class="caret"></span></a> -->
								<?php endif; ?>
							<!-- funciones -->
								<?php if(Session::get('funciones')): ?>
									<ul class="list-unstyled" id="Submenu-<?php echo e($menu->id); ?>" >
										<?php $__currentLoopData = Session::get('funciones'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $funcion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<?php if($menu->id==$funcion->id_padre): ?>
												<li><a href="<?php echo e(asset($funcion->ruta)); ?>" data-toggle="tooltip" data-placement="right" title="<?php echo e($funcion->nombre); ?>"><i id="<?php echo e($funcion->nombre); ?>" class="<?php echo e($funcion->clase); ?>"></i> <span><?php echo e($funcion->nombre); ?></span></a></li>
											<?php endif; ?>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</ul>
								<?php endif; ?>
							</li>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					<?php endif; ?>
				</ul>
                <br>
                <!--<div class="alertar">
                    <div id="alertar-full" class="m-4 ">
                        <a href="<?php echo e(route('alertas.crear')); ?>" class="btn btn-block btn-outline-primary btn-sm" data-toggle="tooltip" data-placement="right" title="Crear nueva Alerta Manual" id="Crear alerta">+ Crear alerta</a>    
                    </div>
                    <div id="alertar-icon" class="m-1">
                        <a id="alerta-icon" href="<?php echo e(route('alertas.crear')); ?>" class="btn btn-outline-primary" data-toggle="tooltip" data-placement="right" title="Crear nueva Alerta Manual" id="Crear alerta"><i class="fa fa-plus-circle"></i></a>    
                    </div>
                </div>-->
            </div>
        </nav>





