
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="http://asignacionciudadano.mds.cl/favicon.ico">
<title>Ministerio de Desarrollo Social - Gobierno de Chile</title>

<style>
  
  form { margin:0px; padding: 0px;}
</style>



  {{ HTML::style( 'administrador/css/bootstrap.min.css')  }}
  {{ HTML::style( 'administrador/css/metisMenu/metisMenu.min.css')  }}
  {{ HTML::style( 'administrador/css/admin.css?v='.date("YmdHis"))  }}
  {{ HTML::style( 'administrador/font-awesome/css/font-awesome.min.css')  }}
  {{ HTML::style( 'administrador/css/dataTables.bootstrap.min.css') }}
  {{ HTML::style( 'administrador/css/jquery-ui.css?v='.date("YmdHis"))  }}


</head>

<body>
<div id="wrapper">
  <div id="page-wrapper2">
    <header>

      <div class="bicolor"><span class="blue"></span><span class="red"></span></div>
      <h2 class="blue"><strong>Ley de Donaciones Sociales</strong></h2>
      
    </header>
    <section id="content">

  

      @section('content')

      @show
        

      </section>
  </div>
        <iframe id="ifrm" style="display:none;" name="ifrm"></iframe>  <!-- footer area -->

  <footer>
    <div class="wrapper clearfix">
      <div class="bicolor"><span class="blue"></span><span class="red"></span></div>
      <div class="top">
        <div class="listas"></div>
        <div class="cf"></div>
        <div class="sep"></div>
      </div>
      <div class="bottom">
        <div class="cf"></div>
        <div class="logo"><a href="http://www.ministeriodesarrollosocial.gob.cl/" target="_blank"><span>Ministerio de Desarrollo Social</span></a></div>
      </div>
    </div>
  </footer>
  <!-- #end footer area -->
</div>



  {{ HTML::script('administrador/js/jquery-3.2.1.min.js') }}
  {{ HTML::script('administrador/js/jquery-ui.js?v=' . date("YmdHis")) }}
  {{ HTML::script('administrador/js/bootstrap.min.js') }}
  {{ HTML::script('administrador/js/jquery.dataTables.min.js') }}
  {{ HTML::script('administrador/js/dataTables.bootstrap.min.js') }}
  {{ HTML::script('administrador/js/app.js?v=' . date("YmdHis")) }}
 
   

  @section('js')
  
  @show

</body>
</html>
