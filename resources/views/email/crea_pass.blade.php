<!DOCTYPE html>
<html lang="es-CL">
    <head>
        <meta charset="utf-8">
        <style>
            html, body {
                font-family:Calibri,"Segoe UI","Helvetica Neue",Helvetica,sans-serif;
            }
            code {
                font-family: Menlo,Monaco,Consolas,"Courier New",monospace;
                color: #c7254e;
            }
            
            th, td {
                padding: 5px;
 
            }
            table {
                border:2px solid black;
            }
        </style>
    </head>
    <body>
       
        <div>
            
            Estimado/a {{$nombre}} <br /><br />
            <p>Junto con saludarle, en el marco del Sistema Ley de Donaciones Sociales informo a usted su credencial de acceso.<p>
    
            <p>Usuario: {{$rut}}<br>
            Clave: {{$pass}}</p>
            <p>Sitio de acceso: {{$url}}</p>
            
            <p>Saludos cordiales </p>
            
            <p><strong>Ministerio de Desarrollo Social</strong></p><br />
            
            <p>NOTA: Le pedimos no responder este correo que es solo de carácter informativo.</p>
			
        </div>
    </body>
</html>