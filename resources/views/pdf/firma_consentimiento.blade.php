<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Document</title>
        <style>
        h1{text-align: center; text-transform: uppercase;}
        .contenido{ font-size: 20px;}
        #primero{ background-color: #ccc;}
        #segundo{ color:#44a359;}
        #tercero{ text-decoration:line-through;}
        body {margin: 0px;padding: 0px;font-family: Arial, Helvetica, sans-serif; max-width: 1000px; }
        html {font-family: Arial, Helvetica, sans-serif;font-size: 9pt; line-height: 1.2em;}
        html {break-before: always}
        p, h1, h3, h4, h5 {orphans: 3;widows: 3;padding: 0px;margin: 0px;}
        h1 {font-size: 16pt;  margin-bottom: 15px;}
        h2 {font-size: 14pt; margin-bottom: 10px;}
        h3 {font-size: 12pt; margin-bottom: 10px;}
        h4 {font-size: 10pt;}
        h5 {font-size: 10px;}
        .box  {-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px; border: 1px solid #ccc; border-bottom: 3px solid #ccc;padding: 10px; margin-bottom: 10px;}
        .box .box  {margin-bottom: 0px}
    </style>
    </head>

<body>
    <table width="100%" cellpadding="15" cellspacing="0" class="cartola-header">
      <tr>
        <td><img src="http://www.ministeriodesarrollosocial.gob.cl/img/logo-main.jpg" alt="Ministerio de Desarrollo Social" class="cartola-logo"></td>
        <td width="70%">
            <h1>Firma Consentimiento</h1>
            <h3>Ministerio de Desarrollo Social y Familia</h3>
        </td>
        <td align="center" class="box"><p>Fecha Emisión</p><h3>{{$today}}</h3></td>
      </tr>
    </table>

    
    <div class="cartola-body">


      <div class="box">

        <table width="100%" border="0" cellspacing="0" cellpadding="5" class="valign-top">
          <tbody>
            <tr>
              <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="15" class="tabla">
                  <!-- <thead>
                    <tr>
                      <th></th>
                    </tr>
                  </thead> -->
                  <tbody>
                    <tr>
                      <td>
                        <p id="primero">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore nihil illo odit aperiam alias rem voluptatem odio maiores doloribus facere recusandae suscipit animi quod voluptatibus, laudantium obcaecati quisquam minus modi.</p>
                      </td>
                      <td>
                        <p id="segundo">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore nihil illo odit aperiam alias rem voluptatem odio maiores doloribus facere recusandae suscipit animi quod voluptatibus, laudantium obcaecati quisquam minus modi.</p>
                      </td>
                      <td>
                        <p id="tercero">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore nihil illo odit aperiam alias rem voluptatem odio maiores doloribus facere recusandae suscipit animi quod voluptatibus, laudantium obcaecati quisquam minus modi.</p>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>
          </tbody>
        </table>
      </div>


      <div class="box">
        <table width="100%" border="0" cellspacing="0" cellpadding="15" class="fila">
          <tbody>
            <tr>
              <td width="50%"><p> Texto de declaración o condiciones</p></td>
              <td width="50%">
                <table width="100%" border="0" cellspacing="0" cellpadding="15" class="firma" align="center">
                  <tbody>
                    <tr>
                      <td class="box" align="center"><br><br><br><br><br>_________________________________<br>Firma<br></td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <table width="100%" border="0" cellspacing="10" cellpadding="15" align="center">
        <tbody>
          <tr>
            <td width="10%"><img width="100" src="http://www.ministeriodesarrollosocial.gob.cl/storage/image/MDS_logo-compacto.png"></td>
            <td>Ministerio de Desarrollo Social y Familia<br>Gobierno de Chile</td>
          </tr>
        </tbody>
      </table>


      
    </div>
    


</body>

</html>

