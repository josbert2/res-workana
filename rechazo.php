<?php
    include_once('admin/est/headerf.php');
    $error = strtolower($_REQUEST['error']);
    switch ($error) {

    case "101":
            $mensaje ="Ha ocurrido un error con Webpay";
    break;
    case "202":
            $mensaje ="Ha ocurrido un error en la transacción";
            $texto = "Las posibles causas de este rechazo son:<br>
            * Error en el ingreso de los datos de su tarjeta de Crédito o Débito (fecha y/o código de seguridad).<br>
            * Su tarjeta de Crédito o Débito no cuenta con saldo suficiente.<br>
            * Tarjeta aún no habilitada en el sistema financiero.";
    break;
    case "303":
            $mensaje ="Ha ocurrido un error, no se ha podido completar su inscripción";
            $texto = "Las posibles causas de este rechazo son:<br>
            * Error en el ingreso de los datos de su tarjeta de Crédito o Débito (fecha y/o código de seguridad).<br>
            * Su tarjeta de Crédito o Débito no cuenta con saldo suficiente.<br>
            * Tarjeta aún no habilitada en el sistema financiero.";
    break;
    case "505":
            $mensaje ="Ha ocurrido un error, no se ha podido completar la transacción, problemas con Webpay";
    break;
    case "606":
            $mensaje ="No hemos podido registrar su transacción en nuestra base de datos, intente denuevo.";
            $texto = "Si el probablema se mantiene, porfavor contactenos";
    break;
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-P7VCFXL');</script>
<!-- End Google Tag Manager -->

<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '454249578889591');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=454249578889591&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rest911 - Transacción Rechazada</title>
    <link rel="stylesheet" href="css/transaccion2.css">
    <link rel="icon" href="img/logo.png">
    
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-170826221-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-170826221-1');
	</script>

    <!-- JQuery -->
    <script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous">
    </script>
    
</head>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P7VCFXL"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

    <section>
    <div class="contenedor flex">
        <div class="imagen">
            <img src="img/rest_perro.jpg">
        </div>
        <div class="texto">
            <h2>Transacción Rechazada<br>Error (<?php echo $error ?>) <?php echo $mensaje ?></h2>
            <p><?php echo $texto ?></p>
            <p><b>Ha ocurrido un error, vuelva a intentarlo más tarde o comuníquese con asistencia.
                </b></p>
        </div>
    </div>
    <div class="eslogan">
        <div class="logo">
            <img src="img/logoc.png">
        </div>
        <div class="texto">
            <p>No sólo entregamos un gran beneficio para
            <br>
            tu tranquilidad, si no que nos comprometemos a dar un servicio de
            <br>
            excelencia las 24 horas del día y los 7 días de la semana
            </p>
        </div>
    </div>
    </section>
    <?php include('admin/est/footerp.php');
    ?>
</body>