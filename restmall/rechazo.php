<?php
    include_once('admin/est/headerf.php');
    $error = strtolower($_REQUEST['error']);
    switch ($error) {

    case "101":
            $mensaje ="Ha ocurrido un error con Webpay";
    break;
    case "202":
            $mensaje ="Ha ocurrido un error en la trasacción";
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rest911 - Transacción Rechazada</title>
    <link rel="stylesheet" href="css/transaccion2.css">
    <link rel="icon" href="img/logo.png">
    
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<!-- <script async src="https://www.googletagmanager.com/gtag/js?id=UA-170826221-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-170826221-1');
	</script>-->

    <!-- JQuery -->
    <script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous">
    </script>
    
</head>
<body>
    <section>
    <div class="contenedor flex">
        <div class="imagen">
            <img src="img/rest_perro.jpg">
        </div>
        <div class="texto">
            <h2>Transacción Rechazada<br>Error (<?php echo $error ?>) <?php echo $mensaje ?></h2>
            <p><?php echo $texto ?></p>
            <p><b>Ha ocurrido un error, puedes volver a intentarlo haciendo <a href="https://planes.rest911.cl/">clic aqui !</a>
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