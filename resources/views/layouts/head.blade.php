<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta property="og:locale" content="es_ES" />
<meta property="og:title" content="" />
<meta property="og:type" content="website" />
<meta property="og:url" content="" />
<meta name="description" property="og:description" content="" />
<meta property="og:site_name" content="" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- DESACTIVAR CACHÉ -->

<!--  <meta http-equiv="Expires" content="0">
 <meta http-equiv="Last-Modified" content="0">
 <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
 <meta http-equiv="Pragma" content="no-cache"> -->

<!-- DESACTIVAR CACHÉ -->
<title>{{ config('app.name') }}</title>
<link rel="icon" href="{{ env('APP_URL') }}/img/gobcl-favicon.ico" type="image/x-icon"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

<!-- Global site tag (gtag.js) - Google Analytics -->

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-27104477-60"></script>

<script>

  window.dataLayer = window.dataLayer || [];

  function gtag(){dataLayer.push(arguments);}

  gtag('js', new Date());

  gtag('config', 'UA-27104477-60');

</script>