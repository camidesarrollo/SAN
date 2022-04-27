<!-- INICIO DC SPRINT 67 -->
<div class="card colapsable shadow-sm" id="contenedor_problemas_priorizados_MRE_">
    <a class="btn text-left p-0 collapsed" id="desplegar_problemas_priorizados_MRE" data-toggle="collapse" data-target="#contenedor_problemas_priorizados_MRE" aria-expanded="false" aria-controls="contenedor_problemas_priorizados_MRE" onclick="if($(this).attr('aria-expanded') == 'false') listarProblemasPriorizadosMRE();">
        <div class="card-header p-3">
            <h5 class="mb-0">
                <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
                &nbsp;&nbsp;Problemas Priorizados
            </h5>
        </div>
    </a>


    <div class="collapse" id="contenedor_problemas_priorizados_MRE">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-striped table-hover w-100" cellspacing="0" id="tabla_problemas_priorizados_MRE">
                    <thead>
                        <tr>
                            <th class="w-75">Problemas</th>
                            <th class="w-25">Categorías o Ejes Temáticos</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div><br>

        </div>          
    </div>
</div>
<!-- FIN DC SPRINT 67 -->