<?php
include_once('admin/est/headerf.php');
session_start();
$clase = $_REQUEST['mod'];
switch ($clase) {
    case "A":
            $mensaje = "Cliente tipo A";
            $texto =' '.$_SESSION["t_nombres"].' '.$_SESSION["t_apellido1"].' le damos la bienvenida a <b>REST911</b> más de <b>10 años</b> protegiendo a <b>las familias</b> y al cuidado de <b>los trabajadores</b>.
            <br><br>
            Le informamos transacción ha sido exitosa, se le ha cargado el monto de $'.$_SESSION["amount"].' a su tarjeta '.$_SESSION["creditcardtype"].' con los últimos 4 dígitos '.$_SESSION["last4carddigits"].' hoy '.$_SESSION["fecha_tbk"].' .
            <br><br>
            Le hemos enviado al correo electrónico registrado un instructivo de uso del servicio (por favor revisar carpeta de spam o correo no deseado), en caso de que no lo haya recibido lo puede <a href="https://planes.rest911.cl/docu/Rest911%20Instructivo%20Usuario%20Activacion%20Servicio.pdf" download="Rest911_Instructivo_Usuario_Activacion_Servicio" target="_blank">descargar acá en nuestra página.</a>
            <br><br>
            Dentro de las próximas 48 horas hábiles el servicio estar disponible y para pedir una atención las 24 horas nos debe llamar 442 469 911 desde cualquier teléfono móvil
            ';
        break;
    case "B":
            $mensaje = "Cliente tipo B";
            $texto =' '.$_SESSION["t_nombres"].' '.$_SESSION["t_apellido1"].' le damos la bienvenida a la modalidad de pago ONE Click de    Transbank.
            <br><br>
            <b>REST911</b> más de <b>10 años</b> protegiendo a <b>las familias</b> y al cuidado de los <b>trabajadores</b>, líder en la zona norte con cobertura en Antofagasta, Calama, Copiapo, Coquimbo y La Serena. Las 24 horas los 365 días del año.
            <br><br>
            Le informamos transacción ha sido exitosa, se le ha cargado el monto de $'.$_SESSION["amount"].' a su tarjeta '.$_SESSION["creditcardtype"].' con los últimos 4 dígitos '.$_SESSION["last4carddigits"].' hoy '.$_SESSION["fecha_tbk"].' .
            <br><br>
            Recuerde que para solicitar una atención las 24 horas nos debe llamar 442 469 911 desde cualquier teléfono móvil o +56225738555 desde cualquier teléfono.
            <br><br>
            Consultas al Servicios al Cliente <a href="mailto:"sac@rest911.cl">sac@rest911.cl</a> o +56229023011 opción 2 en horarios hábil de lunes a viernes.';
        break;
    case "C":
            $mensaje = "Cliente tipo C";
            $texto =' '.$_SESSION["t_nombres"].' '.$_SESSION["t_apellido1"].' le damos la bienvenida a la modalidad de pago ONE Click de Transbank.
            <br><br>
            <b>REST911</b> más de <b>10 años</b> protegiendo a <b>las familias</b> y al cuidado de los <b>trabajadores</b>, líder en la zona norte con cobertura en Antofagasta, Calama, Copiapo, Coquimbo y La Serena. Las 24 horas los 365 días del año.
            <br><br>
            Le informamos transacción ha sido exitosa, se le realizaran futuros cobros a su tarjeta '.$_SESSION["creditcardtype"].' con los últimos 4 dígitos '.$_SESSION["last4carddigits"].'.
            <br><br>
            Recuerde que para solicitar una atención las 24 horas nos debe llamar 442 469 911 desde cualquier teléfono móvil o +56225738555 desde cualquier teléfono.
            <br><br>
            Consultas al Servicios al Cliente <a href="mailto:"sac@rest911.cl">sac@rest911.cl</a> o +56229023011 opción 2 en horarios hábil de lunes a viernes.';
        break;
    case "D":
            $mensaje = "Cliente tipo D";
            $texto =' '.$_SESSION["t_nombres"].' '.$_SESSION["t_apellido1"].' le damos la bienvenida a la modalidad de pago ONE Click de Transbank.
            <br><br>
            <b>REST911</b> más de <b>10 años</b> protegiendo a <b>las familias</b> y al cuidado de los <b>trabajadores</b>, líder en la zona norte con cobertura en Antofagasta, Calama, Copiapo, Coquimbo y La Serena. Las 24 horas los 365 días del año.
            <br><br>
            Le informamos transacción ha sido exitosa, se le realizaran futuros cobros a su tarjeta '.$_SESSION["creditcardtype"].' con los últimos 4 dígitos '.$_SESSION["last4carddigits"].'.
            <br><br>
            Recuerde que para solicitar una atención las 24 horas nos debe llamar 442 469 911 desde cualquier teléfono móvil o +56225738555 desde cualquier teléfono.
            <br><br>
            Consultas al Servicios al Cliente <a href="mailto:"sac@rest911.cl">sac@rest911.cl</a> o +56229023011 opción 2 en horarios hábil de lunes a viernes.';
        break;
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rest911 - Transacción Aprobada</title>
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
    <section>
    <div class="contenedor flex">
        <div class="imagen">
            <img src="img/rest_perro.jpg">
        </div>
        <div class="texto">
            <p><?php echo $texto ?></p>
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
    unset($_SESSION["t_nombres"]);
    unset($_SESSION["t_apellido1"]);
    unset($_SESSION["amount"]);
    unset($_SESSION["last4carddigits"]);
    unset($_SESSION["creditcardtype"]);
    unset($_SESSION["fecha_tbk"]);
    session_destroy();
    ?>

</body>