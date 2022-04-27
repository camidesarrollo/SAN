
<div id="diag_part_sub" class="row" style="display: none">
    <ul class="nav nav-pills mt-0 p-1 bg-white sticky-top h-100 dpc_sub_menu" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link h-100 des-hab-est" id="iden-com-tab" data-toggle="tab" href="#ident-com-ges-com" role="tab" aria-controls="iden-com-ges-com" aria-selected="false">Identificación Comunidad
                <i class="fa fa-check-circle ml-2 text-light" id="ident_com-tab-ico"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link h-100 des-hab-est" id="documentos-tab" data-toggle="tab" href="#doc-ges-com" role="tab" aria-controls="documentos-ges-com" aria-selected="false">Documentos
                <i class="fa fa-check-circle ml-2 text-light" id="document-tab-ico"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link h-100 des-hab-est" id="lin-bas-tab" data-toggle="tab" href="#linea-ges-com" role="tab" aria-controls="documentos-ges-com" aria-selected="false">Linea Base
                <i class="fa fa-check-circle ml-2 text-light" id="lineBase-tab-ico"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link h-100 des-hab-est" id="mat-ide-pro-nna-tab" data-toggle="tab" href="#mat-ide-pro-nna" role="tab" aria-controls="mat-ide-pro-nna" aria-selected="false">Matriz Identificación de Problemas que Constituyen un Factor de Riesgo para Los NNA
                <i class="fa fa-check-circle ml-2 text-light" id="matrizIdenPro-tab-ico"></i>
            </a>
        </li>
        <!-- INICIO DC SPRINT 67 -->
        <li class="nav-item">
            <a class="nav-link h-100 des-hab-est" id="mat-ide-pro-ran-eta-tab" data-toggle="tab" href="#mat-ide-pro-ran-eta" role="tab" aria-controls="mat-ide-pro-ran-eta" aria-selected="false">Matriz de priorización de problemas
            <i class="fa fa-check-circle ml-2 text-light" id="matrizPrioPro-tab-ico"></i>
            </a>
        </li>   
        <!-- FIN DC SPRINT 67 -->   
        <li class="nav-item">
            <a class="nav-link h-100 des-hab-est" id="mat-fac-tab" data-toggle="tab" href="#mat_fac_ges_com" role="tab" aria-controls="mat_fac-ges-com" aria-selected="false">Matriz de Factores Protectores
                <i class="fa fa-check-circle ml-2 text-light" id="matrizFact-tab-ico"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link h-100 des-hab-est" id="inf-dpc-tab" data-toggle="tab" href="#inf_dpc" role="tab" aria-controls="inf_dpc" aria-selected="false">Informe Diagnóstico Participativo Comunitario 
                <i class="fa fa-check-circle ml-2 text-light" id="infodpc-tab-ico"></i>
            </a>
        </li>
    </ul>
</div>

<style>
    .icon-success{
        color: #28a745 !important;
    }
    .dpc_sub_menu{
        background-color: #F17C6B !important;
    }
    .nav-pills .nav-item .nav-link.show:after {
    display: flex;
    content: none;
    position: absolute;
    font-size: 1.8em;
    top: 25px;
    z-index: -999;
}
