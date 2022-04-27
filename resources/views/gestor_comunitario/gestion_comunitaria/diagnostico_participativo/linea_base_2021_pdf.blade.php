<!-- INICIO CZ SPRINT 70 -->

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
    margin-top: 1rem;
    border-collapse: collapse;
}

/* Para sobrescribir lo que está en div-table.css */
.divTableCell,
.divTableHead {
    padding: 0px !important;
    border: 0px !important;
}

header {
    position: absolute;
    top: -10px;
    left: 0px;
    right: 0px;
    margin-bottom: 2rem;
}

.titulo-b {
    font-size: 13px;
    font-family: Open sans-serif;

}

label {
    font-size: 13px !important;
}
.td-titulo{
    text-align: center;
}
</style>

<body>
    <header>
        <img alt="Logo Defensoria de la niñez"
            src="data:image/png;base64,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"
            style="height: 100px;">
    </header>

    <div class="main">
        <h2 align="center">Instrumento de Línea de Base y Línea de Salida.</h2>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <div class="form-group">
            <div class="form-group row ml-3">
                <h2 align="left" style="color: rgb(84,141,212); font-family: Open sans-serif;"><b
                        style="unicode-bidi: bidi-override; letter-spacing: -0.153200px;     
                        font-weight: 700;    font-size: 13px;  font-family: ff5; 
                        color: rgb(84,141,212);line-height: 1.432129;font-style: normal;visibility: visible;">1.
                        IDENTIFICACIÓN.</b></h2>
            </div>
            <br>            
            <div class="form-group row ml-3">
                <label for="" class="col-sm-12 col-form-label"><b class="titulo-b">1.1  </b>Nombre y Apellido:
                    {{$identificacion->iden_nombre}}</label>
            </div>
            <br>
            <div class="form-group row ml-3">
                <label for="" class="col-sm-12 col-form-label"><b class="titulo-b">1.2  </b>RUT:
                    {{$identificacion->iden_run}}</label>
            </div>
            <br>
            <div class="form-group row ml-3">
                <label for="" class="col-sm-12 col-form-label"><b class="titulo-b">1.3  </b>Sexo:
                    {{$identificacion->sexo}}</label>
            </div>
            <br>
            <div class="form-group row ml-3">
                <label for="" class="col-sm-12 col-form-label"><b class="titulo-b">1.4 
                    </b>Edad: {{$identificacion->iden_edad}}</label>
            </div>
            <br>
            <div class="form-group row ml-3">
                <label for="" class="col-sm-12 col-form-label"><b class="titulo-b">1.5 
                    </b>Teléfono: {{$identificacion->iden_fono}}</label>
            </div>
            <br>
            <div class="form-group row ml-3">
                <label for="" class="col-sm-12 col-form-label"><b class="titulo-b">1.6 
                    </b> Correo:{{$identificacion->iden_correo}}</label>
            </div>
            <br>
            <div class="form-group row ml-3">
                <label for="" class="col-sm-12 col-form-label"><b class="titulo-b">1.7  </b>
                ¿Usted o alguien de su hogar
                        cuenta con acceso a
                        internet?
                    {{$identificacion->iden_internet}}
                </label>
            </div>
            <br>
            <div class="form-group row ml-3">
                <label for="" class="col-sm-12 col-form-label"><b class="titulo-b">1.8  </b> ¿Usted o alguien de su hogar
                        cuenta con equipos que
                        permitan la comunicación a distancia? (Teléfono, Tablet, Notebook, PC)
                    {{$identificacion->iden_electronico}}</label>
            </div>
            <br>
            <div class="form-group row ml-3">
                <label for="" class="col-sm-12 col-form-label"><b class="titulo-b">1.9  </b> ¿En su hogar viven niños, niñas y
                        adolescentes (entre
                        0 y 17 años)?  {{$identificacion->iden_hogar_nna}}</label>
            </div>
            <br>
            @if($identificacion->iden_hogar_nna == 'Si')
            <div class="form-group row ml-3">
                <label for="" class="col-sm-12 col-form-label"><b class="titulo-b">De responder SI, </b> indique cuántos por
                        tramo etario:
                </label>
            </div>
            <br>
            <!-- CZ SPRINT 76 -->
            <div  class="form-group row ml-3">
                @if($identificacion->iden_cant_rang_1 != null)
                <label for="" class="col-sm-12 col-form-label"><b class="titulo-b"> </b>0-3 años:</label> {{$identificacion->iden_cant_rang_1}} <br>
                @endif
                @if($identificacion->iden_cant_rang_2 != null)
                <label for="" class="col-sm-12 col-form-label"><b class="titulo-b"> </b>4-5 años:</label> {{$identificacion->iden_cant_rang_2}}
                @endif
                <br>
                @if($identificacion->iden_cant_rang_3 != null)
                <label for="" class="col-sm-12 col-form-label"><b class="titulo-b"> </b>6-13 años:</label> {{$identificacion->iden_cant_rang_3}}
                @endif
                <br>
                @if($identificacion->iden_cant_rang_4 != null)
                <label for="" class="col-sm-12 col-form-label"><b class="titulo-b"> </b>14-17 años:</label> {{$identificacion->iden_cant_rang_4}}
                @endif
            <!-- CZ SPRINT 76 -->
            </div>
            @endif
            <br>
            <div class="form-group row ml-3">
                <label for="" class="col-sm-12"><b class="titulo-b">1.10. </b>Dirección (Calle, número. Block, depto.):
                    {{$identificacion->iden_calle}} {{$identificacion->iden_numero}} {{$identificacion->iden_block}}
                    {{$identificacion->iden_departamento}} </label>
            </div>
            <br>
            <div class="form-group row ml-3">
                <label for="" class="col-sm-12"><b class="titulo-b">1.11 
                    </b>Comuna: {{$identificacion->iden_comuna}}</label>
            </div>
        </div>
        <br>
        <br>
        <div class="form-group row ml-3">
            <h2 align="left" style="color: cornflowerblue; font-family: Open sans-serif;"><b
            style="color: rgb(84,141,212); font-family: Open sans-serif;"><b
                        style="unicode-bidi: bidi-override; letter-spacing: -0.153200px;     
                        font-weight: 700;    font-size: 13px;  font-family: ff5; 
                        color: rgb(84,141,212);line-height: 1.432129;font-style: normal;visibility: visible;">2. SERVICIOS Y
                    PRESTACIONES.</b></h2>
        </div>
        <table border="1" width="80%" cellpading="0" cellspacing="0" align="center">
            <tr>
                <th colspan="5">En caso de ser afirmativa la respuesta marca el checkbox.</th>
            </tr>
            <tbody>
                <tr>
                    <td><b class="titulo-b">2.1. Respecto a Servicios Comunales. </b>
                    </td>
                    <td class="td-titulo">¿Conoces en tu comuna?
                    <hr>
                        Indicar <br><br><b class="titulo-b">SI o NO<b>
                    </td>
                    <td class="td-titulo">¿Está cercano a tu vivienda? (a menos de 15 min. caminando<hr>Indicar <br><br><br><b class="titulo-b">SI o NO<b></td>
                    <td class="td-titulo">¿Alguien de tu hogar o tú lo han utilizado o acudido? <hr>Indicar <br><br><br><b class="titulo-b">SI o NO<b></td>
                    <td class="td-titulo">¿Cuándo fue la última vez? (presencial o virtual)<hr><br>Indicar mes y año. <b class="titulo-b">Si no recuerda (NR)<br></td>
                </tr>
                @foreach($serviciosComunales as $resp)
                <tr>
                    <td>{{$resp->nombre}}</td>
                    @if($resp->sc_preg1 == 1)
                    <td style="text-align: center;">X</td>
                    @else
                    <td></td>
                    @endif
                    @if($resp->sc_preg2 == 1)
                    <td style="text-align: center;">X</td>
                    @else
                    <td></td>
                    @endif
                    @if($resp->sc_preg3 == 1)
                    <td style="text-align: center;">X</td>
                    @else
                    <td style="text-align: center;"></td>
                    @endif
                    <td style="text-align: center;">{{$resp->sc_mesyear}}</td>
                </tr>
                @endforeach
                <tr>
                    <td>2.1. "Otro", ¿cuál?</td>
                    @if (!isset($otro1->otro_descripcion))
                    <td colspan="4"></td>
                    @else
                    <td colspan="4">{{$otro1->otro_descripcion}}</td>
                    @endif

                </tr>
            </tbody>
        </table>
        <br>
        <div class="form-group row ml-3">
           <span>*Para el reporte sólo se visualizan las respuestas que usted a marcado como afirmativas en el ingreso de la linea base. </span>
        </div>
        <br>
        <br>
        <table border="1" width="80%" cellpading="0" cellspacing="0" align="center">
            <tr>
                <th colspan="4">En caso de ser afirmativa la respuesta marca el checkbox.</th>
            </tr>
            <tbody>
                <tr>
                    <td ><b class="titulo-b">2.2. Respecto a Programas Sociales, Subsidios o Becas.</b></td>
                    <td class="td-titulo">¿Conoces en la comuna? 
                        <hr>
                        Indicar<br><b class="titulo-b"> SI o NO</b></td>
                    <td class="td-titulo">¿Alguien de tu hogar o tú han participado o sido beneficiado?<hr>
                        Indicar<br><b class="titulo-b"> SI o NO</b></td>
                    <td class="td-titulo">¿Cuándo fue la última vez? (presencial o virtual)<hr>Indicar mes y año. <br><b class="titulo-b">Si no recuerda (NR)</b></td>
                </tr>
                @foreach($programasSocialesPrestaciones as $resp)
                <tr>
                    <td>{{$resp->nombre}}</td>
                    @if($resp->sp_preg1 == 1)
                    <td style="text-align: center;">X</td>
                    @else
                    <td style="text-align: center;"></td>
                    @endif
                    @if($resp->sp_preg2 == 1)
                    <td style="text-align: center;">X</td>
                    @else
                    <td></td>
                    @endif
                    <td style="text-align: center;">{{$resp->sp_mesyear}}</td>
                </tr>
                @endforeach
                <tr>
                    <td>2.2. "Otro", ¿cuál?</td>
                    @if (!isset($otro2->otro_descripcion))
                    <td colspan="3"></td>
                    @else
                    <td colspan="3">{{$otro2->otro_descripcion}}</td>
                    @endif
                </tr>
            </tbody>
        </table>
        <br />
        <div class="form-group row ml-3">
           <span>*Para el reporte sólo se visualizan las respuestas que usted a marcado como afirmativas en el ingreso de la linea base. </span>
        </div>
        <br>
        <br>
        <div class="form-group row ml-3">
            <h2 align="left" style="color: cornflowerblue; font-family: Open sans-serif;"><b
            style="color: rgb(84,141,212); font-family: Open sans-serif;"><b
                        style="unicode-bidi: bidi-override; letter-spacing: -0.153200px;     
                        font-weight: 700;    font-size: 13px;  font-family: ff5; 
                        color: rgb(84,141,212);line-height: 1.432129;font-style: normal;visibility: visible;">3. RECURSOS DE LA COMUNIDAD.</b></h2>
        </div>
        <table border="1" width="80%" cellpading="0" cellspacing="0" align="center">
            <tr>
                <th colspan="6">En caso de ser afirmativa la respuesta marca el checkbox.</th>
            </tr>
            <tbody>
                <tr>
                    <td>3.1. Respecto a Bienes Comunitarios de acceso gratuito.</td>
                    <td class="td-titulo">¿Es importante que exista en la comunidad?
                    <hr>
                    <br><br>Indicar <br><br><b class="titulo-b">SI o NO</b>
                    </td>
                    <td class="td-titulo">¿Conoces en tu sector?
                    <hr>
                    <br>Indicar<br><b class="titulo-b">SI o NO</b>
                    </td>
                    <td class="td-titulo">¿Está cercano a tu vivienda? (a menos de 15 min. caminando)
                    <hr>
                    <br><br><br>Indicar <br><b class="titulo-b">SI o NO</b>
                    </td>
                    <td class="td-titulo">¿Alguien de tu hogar o tú lo han utilizado?
                    <hr>
                    <br><br>Indicar <br><b class="titulo-b">SI o NO</b>
                    </td>
                    <td class="td-titulo">¿Cuándo fue la última vez? (presencial o virtual)
                    <hr>
                    <br><br> Indicar mes y año <b class="titulo-b">Si no recuerda (NR)</br>
                    </td>
                </tr>
                @foreach($bienesComunitarios as $resp)
                <tr>
                    <td>{{$resp->nombre}}</td>
                    @if($resp->org_bc_preg1 == 1)
                    <td style="text-align: center;">X</td>
                    @else
                    <td style="text-align: center;"></td>
                    @endif
                    @if($resp->org_bc_preg2 == 1)
                    <td style="text-align: center;">X</td>
                    @else
                    <td style="text-align: center;"></td>
                    @endif
                    @if($resp->org_bc_preg3 == 1)
                    <td style="text-align: center;">X</td>
                    @else
                    <td style="text-align: center;"></td>
                    @endif
                    @if($resp->org_bc_preg4 == 1)
                    <td style="text-align: center;">X</td>
                    @else
                    <td style="text-align: center;"></td>
                    @endif
                    <td style="text-align: center;">{{$resp->org_bc_mesyear}}</td>
                </tr>
                @endforeach
                <tr>
                    <td>3.1. "Otro", ¿cuál?</td>
                    @if (!isset($otro3->otro_descripcion))
                    <td colspan="5"></td>
                    @else
                    <td colspan="5">{{$otro3->otro_descripcion}}</td>
                    @endif
                </tr>
            </tbody>
        </table>
        <br>
        <div class="form-group row ml-3">
           <span>*Para el reporte sólo se visualizan las respuestas que usted a marcado como afirmativas en el ingreso de la linea base. </span>
        </div>
        <br>
        <table border="1" width="80%" cellpading="0" cellspacing="0" align="center">
            <tr>
                <th colspan="7">En caso de ser afirmativa la respuesta marca el checkbox.</th>
            </tr>
            <tbody>
                <tr>
                    <td>3.2. Respecto a Organizaciones Comunitarias.</td>
                    <td class="td-titulo">¿Es importante su presencia en la comunidad?<hr>
                        Indicar <br><b class="titulo-b">SI o NO</b></td>
                    <td class="td-titulo">¿Conoces en la comuna?<hr>
                        Indicar <br><b class="titulo-b">SI o NO</b></td>
                    <td class="td-titulo">¿Participas o has participado en ella?<hr>
                        Indicar <br><b class="titulo-b">SI o NO</b</td>
                    <td class="td-titulo">¿Cuándo fue la última vez que participaste? (presencial o virtual)<hr>Indicar mes y año. <br><b class="titulo-b">Si no recuerda (NR)</b></td>
                    <td class="td-titulo">¿La organización funciona cerca de tu vivienda? (a menos de 15 min. caminando)<hr>
                        Indicar <br><b class="titulo-b">SI o NO</b></td>
                    <td class="td-titulo">¿Conoces a alguno(a) de sus dirigentes?<hr>
                        Indicar <br><b class="titulo-b">SI o NO</b></td>
                </tr>
                @foreach($organizacionesComunitarias as $resp)
                <tr>
                    <td>{{$resp->nombre}}</td>
                    @if($resp->org_preg1 == 1)
                    <td style="text-align: center;">X</td>
                    @else
                    <td></td>
                    @endif
                    @if($resp->org_preg2 == 1)
                    <td style="text-align: center;">X</td>
                    @else
                    <td></td>
                    @endif
                    @if($resp->org_preg3 == 1)
                    <td style="text-align: center;">X</td>
                    @else
                    <td></td>
                    @endif
                    <td style="text-align: center;">{{$resp->org_mesyear}}</td>
                    @if($resp->org_preg4 == 1)
                    <td style="text-align: center;">X</td>
                    @else
                    <td></td>
                    @endif
                    @if($resp->org_preg5 == 1)
                    <td style="text-align: center;">X</td>
                    @else
                    <td></td>
                    @endif
                </tr>
                @endforeach
                <tr>
                    <td>3.2. "Otro", ¿cuál?</td>
                    @if (!isset($otro4->otro_descripcion))
                    <td colspan="6"></td>
                    @else
                    <td colspan="6">{{$otro4->otro_descripcion}}</td>
                    @endif
                </tr>
            </tbody>
        </table>
        <br>
        <div class="form-group row ml-3">
           <span>*Para el reporte sólo se visualizan las respuestas que usted a marcado como afirmativas en el ingreso de la linea base. </span>
        </div>
        <br>
        <div class="form-group row ml-3">
            <h2 align="left" style="color: cornflowerblue; font-family: Open sans-serif;"><b
            style="color: rgb(84,141,212); font-family: Open sans-serif;"><b
                        style="unicode-bidi: bidi-override; letter-spacing: -0.153200px;     
                        font-weight: 700;    font-size: 13px;  font-family: ff5; 
                        color: rgb(84,141,212);line-height: 1.432129;font-style: normal;visibility: visible;">4. DERECHOS Y PARTICIPACIÓN DE NIÑOS, NIÑAS Y ADOLESCENTES.</b></h2>
        </div>
        <table border="1" width="80%" cellpading="0" cellspacing="0" align="center">
            <tbody>
                <tr>
                    <td>Marca con X su respuesta, identificando su nivel de acuerdo con las siguientes afirmaciones:</td>
                    <td class="td-titulo">Muy en desacuerdo</td>
                    <td class="td-titulo">En desacuerdo</td>
                    <td class="td-titulo">De acuerdo</td>
                    <td class="td-titulo">Muy de acuerdo</td>
                </tr>
                @foreach($derechoNNA as $respuesta)
                <tr>
                    <td><b>{{$respuesta->numero}} </b>{{$respuesta->lb_par_nom}}</td>
                    @if($respuesta->valor == 1)
                    <td style="text-align: center;">X</td>
                    @else
                    <td> </td>
                    @endif

                    @if($respuesta->valor == 2)
                    <td style="text-align: center;">X</td>
                    @else
                    <td> </td>
                    @endif

                    @if($respuesta->valor == 3)
                    <td style="text-align: center;">X</td>
                    @else
                    <td> </td>
                    @endif

                    @if($respuesta->valor == 4)
                    <td style="text-align: center;">X</td>
                    @else
                    <td> </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
        <br><br>
        <div class="form-group row ml-3">
            <h2 align="left" style="color: cornflowerblue; font-family: Open sans-serif;"><b
            style="color: rgb(84,141,212); font-family: Open sans-serif;"><b
                        style="unicode-bidi: bidi-override; letter-spacing: -0.153200px;     
                        font-weight: 700;    font-size: 13px;  font-family: ff5; 
                        color: rgb(84,141,212);line-height: 1.432129;font-style: normal;visibility: visible;">5. HERRAMIENTAS Y PROYECCIÓN DEL ROL DE CO GARANTE.</b></h2>
        </div>
        <table border="1" width="80%" cellpading="0" cellspacing="0" align="center">
            <tbody>
                <tr>
                    <td>Marca con X su respuesta, identificando su nivel de acuerdo con las siguientes afirmaciones:</td>
                    <td class="td-titulo">Muy en desacuerdo</td>
                    <td class="td-titulo">En desacuerdo</td>
                    <td class="td-titulo">De acuerdo</td>
                    <td class="td-titulo">Muy de acuerdo</td>
                </tr>
                @foreach($tabla_continuidadProyecto as $respuesta)
                <tr>
                    <td><b>{{$respuesta->numero}} </b> {{$respuesta->lb_cont_nom}}</td>
                    @if($respuesta->valor == 1)
                    <td style="text-align: center;">X</td>
                    @else
                    <td> </td>
                    @endif

                    @if($respuesta->valor == 2)
                    <td style="text-align: center;">X</td>
                    @else
                    <td> </td>
                    @endif

                    @if($respuesta->valor == 3)
                    <td style="text-align: center;">X</td>
                    @else
                    <td> </td>
                    @endif

                    @if($respuesta->valor == 4)
                    <td style="text-align: center;">X</td>
                    @else
                    <td> </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</body>

</html>
<!-- FIN CZ SPRINT 70 -->