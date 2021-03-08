<?php
include_once('admin/est/headerf.php');
include('admin/config/modomall.php');

use Transbank\Webpay\Oneclick\MallInscription;

/* LECTURA DE USERNAME */
if(empty($_REQUEST['id'])){
    $msje = "id vacio";
    header("location: https://rest911.cl/");
}else{
    include_once "admin/config/conexion.php";
    $id = htmlspecialchars(mysqli_real_escape_string($conn, $_REQUEST['id']));
    $query = mysqli_query($conn, "SELECT pagos,  t_nombres, t_apellido1, t_apellido2, email, rut, cant_descuento, valor_plan, estado, username, clase FROM pagos_clientes WHERE ((MD5(username) = '$id') AND ((clase = 'B') OR (clase = 'C')) AND ((estado = 'N') OR (estado = 'E') OR (estado = 'T'))) ");
    $result = mysqli_num_rows($query);
    if($result > 0){
        /** CORREO ENVIO**/
        session_start(); 
        $_SESSION["c_envio"] = 1;
        $msje = "id correcto";
        while($data = mysqli_fetch_array($query)){
            $pagos          = $data["pagos"];
            $t_nombres      = $data["t_nombres"];
            $t_apellido1    = $data["t_apellido1"];
            $t_apellido2    = $data["t_apellido2"];
            $rut            = $data["rut"];
            $email          = $data["email"];
            /*$cant_descuento = $data["cant_descuento"];*/
            $valor_plan     = $data["valor_plan"];
            $estado         = $data["estado"];
            $username       = $data["username"];
            $clase          = $data["clase"];
        }
        /*if(empty($cant_descuento)){
            $cant_descuento = 0;
        }
        $valor_ori =  $valor_plan + $cant_descuento;*/
        $formato_valor = number_format($valor_plan, 0, '', '.');
        
        if( (($clase == 'B') OR ($clase == 'C')) AND (($estado == 'N') OR ($estado == 'E') OR ($estado == 'T'))){

            /** Iniciamos Transaccion */
            $result = MallInscription::start($username, $email, $urlReturn);           
            $result = get_object_vars($result);

            /** Verificamos respuesta de inicio en webpay */
            if (!empty($result["token"])) {
                $message = "Sesion iniciada con exito en Webpay";
                $token = $result["token"];
                $next_page = $result["urlWebpay"];
            
                /* base de datos */    
                $query2 = mysqli_query($conn, "UPDATE pagos_clientes SET estado = 'E', token = '$token' WHERE ((pagos = '$pagos') AND ( (estado = 'N') OR (estado = 'E') OR (estado = 'T')))");
                if($query2){
                    $msje2 = "token en base de datos";
                }else{
                    $msje2 = "problemas con la base de datos";
                    mysqli_close($conn);
                }
            
            } else {
                $message = "webpay no disponible";
            }
            
            /* TEXTO CLIENTE*/
            if($clase == 'B'){
                $texto='<b>'.$t_nombres.' '.$t_apellido1.' '.$t_apellido2.' :</b>
                <br><br>
                Para finalizar su inscripción se le generara la siguiente transacción:
                <br></p>
                <table style="width:60%;font-weight: bold;">
                    <tr>
                        <td bgcolor="#ccd9ff">Valor a Pagar:</td>
                        <td bgcolor="#ccd9ff">$ '.$formato_valor.'</td>
                    </tr>
                </table>
                <br>
                <p>Para realizar la inscripción seleccióne el boton inferior.';
                $boton='Ir al pago &raquo;';
                
            }elseif($clase == 'C'){
                $texto='<b>'.$t_nombres.' '.$t_apellido1.' '.$t_apellido2.' :</b>
                <br>
                <p>Para realizar la inscripción seleccióne el boton inferior.';;
                $boton='Ir a la Inscripción &raquo;';
            }else{
                $texto='clase incorrecta';
                $boton='no valido';
            }
            
            
        }else{
            $msje2 = "Estado o clase del cliente no corresponde";
            mysqli_close($conn);
            header("location: https://rest911.cl/");
        }
    }else{
        $msje = "id invalido";
        mysqli_close($conn);
        header("location: https://rest911.cl/");
    }
    
    mysqli_close($conn);
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

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rest911 - Inscripción</title>
    <link rel="stylesheet" href="css/transaccion2.css">
    <link rel="stylesheet" href="css/ins_manual.css">
    <link rel="icon" href="img/logo.png">
    
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

    <section>
    <div class="contenedor flex">
        <div class="imagen">
            <img src="img/rest_perro.jpg">
        </div>
        <div class="texto">
            <h2>Continua con tu inscripción<br></h2>
            <p>
            <?php echo $texto; ?>
            </p>
            <form action="<?php echo $next_page; ?>" method="post" class="formu">
            <input type="hidden" name="TBK_TOKEN" value="<?php echo $token; ?>">
            <input type="submit" class="boton_tbk" value="<?php echo $boton; ?>">
            </form>
        </div>
    </div>
    <div class="eslogan">
        <div class="logo">
            
        </div>
        <div class="texto">
            
        </div>
    </div>
    </section>
    <?php include('admin/est/footerins_man.php');
    ?>

</body>