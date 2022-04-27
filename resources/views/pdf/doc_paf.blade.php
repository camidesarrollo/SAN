<!DOCTYPE html>
<html lang="es">
    <head>
        <!--<meta charset="UTF-8">-->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <!--<title>Document</title>-->
        <link rel='stylesheet' type='text/css' href="{{ env('APP_URL') }}/css/bootstrap.css" >
        <style type="text/css" media="all">
        .contenido{
        font-size: 12px;
        }
        .titulo-1 {font-family: sans-serif; font-size: 20px}
        .small {font-size: 9px; text-align: center;}

        .gris {background-color: #ebebeb; padding: 10px}
        #primero{
        background-color: #6FE172;
        }
        #segundo{
        color:#49AE32;
        }
        #tercero{
        text-decoration:line-through;
        }

        #imp-doc-paf-tit{
            text-align: center;
            text-decoration: underline;
        }

        .imp-doc-paf-cont-tit-sec{
            display: table;
            height: 40px;
            width: 100%;
            border-bottom: 1px solid #cccccc;
            background-color: #ebebeb;
            font-weight: bold;
            text-align: center;
        }

        .imp-doc-paf-tit-sec{
            display: table-cell;
            vertical-align: middle;
        }

        .imp-doc-paf-sub-tit-sec{
            text-align: left !important;
            padding-left: 10px;
        }

        .imp-doc-paf-table{
            display: table;
        }

		.imp-doc-paf-hea{
			display: table-row;
		}

        .imp-doc-paf-row{
            display: table-row;
        }

        .imp-doc-paf-cell{
            display: table-cell;
            border: 1px solid #cccccc;
            padding-left: 5px;
            padding-right: 5px;
        }

        #imp-doc-paf-rsh1{
            width: 136px;
            padding: 3px;
            padding-left: 10px;
        }

        #imp-doc-paf-rsh2{
            width: 280px;
            padding: 3px;
            padding-left: 10px;
        }

        #imp-doc-paf-if1{
            width: 100%;
        }

        #imp-doc-paf-if2{
            text-align: center;
            border: 1px solid #333333;
            border-top: none;
        }
        .col {
            float: left;
            display: inline-block;
            width:  
        }

        .paf-nom-firma{
            padding-bottom: 71px;
            padding-right: 160px;
        }

        .paf-firma{
            padding-bottom: 71px;
            padding-right: 278px;
        }

        .paf-border-top{
            border-top: none;
        }

        .paf-border-bottom{
                border-bottom: none;
        }   
        </style>
    </head>
    <body>
        <div class="contenido">

        	<table cellpadding="10">
        		<tr>
        			<td><img src="{{ asset('img/logo-mds-familia.jpg') }}" width="100px"></td>
        			<td width="300"><span class="titulo-1">Plan de Atención Familiar</span><br>
        				<span style="font-family: sans-serif;">Sistema Alerta Niñez</span>
        			</td>
        			<td>
        				<table>
        					<tr>
                                <!--<td bgcolor="#ebebeb" align="right"><span>RUN: { { $nna_rut }}</span></td>-->
        						<td bgcolor="#ebebeb" align="right">
                                    <span>RUN: {{ $run_formateado }}</span>
                                </td>
        					</tr>
        				</table>
        			</td>
        		</tr>
        	</table>

            <br>

            <!--TITULO DOCUMENTO -->
            <div class="imp-doc-paf-cont-tit-sec">
                <span class="imp-doc-paf-tit-sec">I. Plan de Atención Familiar</span>
            </div>
            <br>

            <div class="mp-doc-paf-sub-tit-sec">
                <p>En la presente sección se registra el Plan de Atención Familiar que el Gestor de Casos debe trabajar con el NNA y su familia. Se completa en base al resultado del Diagnóstico Integral a la Familia, y establece Objetivos, Tareas a desplegar por el Gestor de Casos, Acuerdos establecidos con la familia y la red, Plazos de respuesta, Responsables, y Observaciones.</p>
            </div>
            <br>

            @foreach ($data AS $c1 => $v1)
                <table class="table table-bordered">
                    <tr>
                        <th colspan="4" class="text-center" >
                              Objetivos {{ ($c1 + 1) }}:     
                            <br>
                            {{ wordwrap($v1->obj_nom, 30, chr(10), true) }}
                        </th>
                    </tr>
                    <tr>
                        <th width="35%">Tareas</th>
                        <th width="5%">Plazos <br/>(Semanas)</th>
                        <th width="20%">Responsable (s)</th>
                        <th width="40%">Resultados esperados</th>
                    </tr>

                     @foreach ($v1->tareas AS $c2 => $v2)

                     <tr>
                        <td>{{  wordwrap($v2->tar_descripcion, 30, chr(10), true) }}</td>
                        <td>{{  wordwrap($v2->tar_plazo, 30, chr(10), true) }}</td>
                        <td>{{  wordwrap($v2->responsable, 30, chr(10), true) }}</td>
                        <td>{{  wordwrap($v2->tar_observacion, 30, chr(10), true) }}</td>
                    </tr>

                     @endforeach
                </table>                
            @endforeach             

            <br><br>

            <div class="imp-doc-paf-table">
                <div class="imp-doc-paf-row">
                    <div class="imp-doc-paf-cell paf-nom-firma"><b>Nombre Integrante Familia</b></div>
                    <div class="imp-doc-paf-cell paf-firma"><b>Firma</b></div>
                </div>
                <div class="imp-doc-paf-row">
                    <div class="imp-doc-paf-cell paf-nom-firma"><b>Nombre NNA</b></div>
                    <div class="imp-doc-paf-cell paf-firma"><b>Firma</b></div>
                </div>
                <div class="imp-doc-paf-row">
                    <div class="imp-doc-paf-cell paf-nom-firma"><b>Nombre Gestor de Casos</b></div>
                    <div class="imp-doc-paf-cell paf-firma"><b>Firma</b></div>
                </div>
            </div>
            <br>      

            <div class="mp-doc-paf-sub-tit-sec" style="font-size: 11px;">
                <p>Fecha de Firma: {{ $today }}</p>
            </div>

            <span class="small">Ministerio de Desarrollo Social y Familia - Dirección: Catedral 1575, Santiago - Teléfono: +562 2675 1400</span><br>
        </div>
    </body>
</html>