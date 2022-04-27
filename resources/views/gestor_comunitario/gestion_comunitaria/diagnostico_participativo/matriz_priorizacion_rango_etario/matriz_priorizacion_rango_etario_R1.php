<!-- INICIO DC SPRINT 67 -->
<div class="card colapsable shadow-sm" id="contenedor_matriz_prg_1_">
    <a class="btn text-left p-0 collapsed" id="desplegar_matriz_prg_1_" data-toggle="collapse" data-target="#contenedor_matriz_prg_1" aria-expanded="false" aria-controls="contenedor_matriz_prg_1" onclick="if($(this).attr('aria-expanded') == 'false') cargarMPRE(1);">
		<div class="card-header p-3">
			<h5 class="mb-0">
				<button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
				&nbsp;&nbsp;Matriz de priorización de problemas
			</h5>
		</div>
	</a>

	<div class="collapse" id="contenedor_matriz_prg_1">
        <div class="card-body">
            <!-- HIDDEN -->
            <input type="hidden" id="MTRE_1" value="">
            <!-- HIDDEN -->

            <div class="table-responsive">
                <table class="table table-striped table-hover w-100" cellspacing="0" id="table_matriz_rango_etario_1">
                    <thead>
                        <tr>
                            <th>Problemática</th>
                            <th>Magnitud</th>
                            <th>Gravedad</th>
                            <th>Capacidad</th>
                            <th>Alternativa</th>
                            <th>Beneficio</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div><br>

        </div>      	
	</div>
</div>
<!-- FIN DC SPRINT 67 -->