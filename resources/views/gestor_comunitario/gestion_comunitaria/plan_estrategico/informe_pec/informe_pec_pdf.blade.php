<!DOCTYPE html>
<html lang="en">
<style>
    * {
        font-size: x-small;
    }
    th {
        background-color: #f7f7f7;
        border-color: #959594;
        border-style: solid;
        border-width: 1px;
        text-align: center;
    }

    .bordered td {
        border-color: #959594;
        border-style: solid;
        border-width: 1px;
    }

    table {
        margin-top:1rem;
        border-collapse: collapse;
    }

    /* Para sobrescribir lo que estÃ¡ en div-table.css */
    .divTableCell,
    .divTableHead {
        padding: 0px !important;
        border: 0px !important;
    }
    header{
        position: absolute;
        top: -10px;
        left: 0px;
        right: 0px;
        margin-bottom: 2rem;
    }

</style>
<body>   
    <header>
        <img  alt ="Logo Defensoria de la niÃ±ez" src ="data:image/png;base64,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" style="height: 100px;">
    </header>

    <div class="main">
    	<br>
        <h2 align="center">Informe Plan Estratégico Comunitario.</h2>
        <br>
        <br>
        <br>
        <table border="1" width="80%" cellpading="0" cellspacing="0" align="center">
            <tr>
                <th width="100%" colspan="6">I. IDENTIFICACIÓN</th>
            </tr>
            <tbody>
                <tr>    
                    <td colspan="2">Nombre del Gestor/a Comunitario/a a Cargo</td>
                    <td colspan="4">{{$datos[0]->info_resp}}</td>
                </tr>
                <tr>
                    <td colspan="2">Comuna</td>
                    <td colspan="4">{{$datos[0]->info_com}}</td>
                </tr>
                <tr>
                    <td colspan="2">Comunidad Priorizada</td>
                    <td colspan="4">{{$datos[0]->com_pri_nom}}</td>
                </tr>                
                <tr>
                    <td colspan="2">Fecha Primer Contacto</td>
                    <td colspan="4">{{$datos[0]->info_fec_pri}}</td>
                </tr>
                <!-- INICIO DC -->
                <tr>
                    <td colspan="2">Fecha de Término PEC</td>
                    <td colspan="4">{{$datos[0]->info_fec_ter}}</td>
                </tr>
                <!-- FIN DC -->

            </tbody>
        </table>
        <br>
        <br>
        <table border="1" width="80%" cellpading="0" cellspacing="0" align="center">
            <tr>
                <th colspan="3">II. INTRODUCCIÓN</th>
            </tr>
            <tbody> 
                <tr>
                    <td colspan="3">{{$datos[0]->info_intro}}</td>
                    
                </tr>
            </tbody>
        </table>
        <br>
        <br>
        <table border="1" width="80%" cellpading="0" cellspacing="0" align="center">
            <tr>
                <th colspan="4" >III. EJECUCIÓN PLAN ESTRATÉGICO COMUNITARIO
                </th>
            </tr>
            <!-- INICIO CZ SPRINT 67 -->
            <tbody>
                <tr>
                    <td>Problema Priorizado</td>
                    <td>Objetivo</td>
                    <td>Indicador</td>
                    <td>Resultado Esperado</td>
                </tr>
              @foreach($ejecucion as $eje)
                <tr>
                    <td>{{$eje->prob_priorizado}}</td>
                    <td>{{$eje->objetivo}}</td>
                    <td>{{$eje->indicador}}</td>
                    <td>{{$eje->resultado}}</td>
                </tr>
                @endforeach
            </tbody>
            <!-- FIN CZ SPRINT 67 -->
        </table>
        <br>
        <br>
        <table border="1" width="80%" cellpading="0" cellspacing="0" align="center">
            <tr>
                <th colspan="3">IV. RESULTADOS</th>
            </tr>
            <tbody> 
                <tr>
                    <td colspan="3">{{$datos[0]->info_act_plan}}</td>
                    
                </tr>
            </tbody>
        </table>
        
        <br>
        <br>
        <table border="1" width="80%" cellpading="0" cellspacing="0" align="center">
            <tr>
                <th colspan="3">V. CONCLUSIONES Y RECOMENDACIONES</th>
            </tr>
            <tbody> 
                <tr>
                    <td colspan="3">{{$datos[0]->info_act_real}}</td>
                    
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
