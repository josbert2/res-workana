<?php
session_start();
if($_SESSION['rol'] != 1){
    header("location: ../loginoc.php");    
}
require_once '../vendor/autoload.php';
include_once 'config/conexion.php';

use Transbank\Webpay\Configuration;
use Transbank\Webpay\Webpay;

/** PRODUCCION **/
$commerce_code = 597035230610;
$configuration = new Configuration();
$configuration->setEnvironment("PRODUCCION");
$configuration->setCommerceCode($commerce_code);

$path_base      = "../app/private/".$commerce_code;
$pathKey        = $path_base.'.key';
$pathCert       = $path_base.'.crt';
$pathWebpayCert = '../app/private/serverTBK.crt';
$cert           = file_get_contents($pathCert);
$key            = file_get_contents($pathKey);
$webpayCert     = file_get_contents($pathWebpayCert);
$configuration->setPublicCert($cert);
$configuration->setPrivateKey($key);
$configuration->setWebpayCert($webpayCert);

/** Creacion Objeto Webpay */
$webpay = new Webpay($configuration);  // Crea objeto WebPay

/** FECHA Y HORA PARA REGISTROS**/
include_once("config/func.php");
$fecha_buy = getFechabuy();

/** Identificador único de la inscripción del cliente */
if( (!empty($_REQUEST['username_tbk'])) &&
    (!empty($_REQUEST['monto'])) &&
    (!empty($_REQUEST['tbkuser'])) ){

        /** Monto del pago en pesos */
        $tbkUser    = $_REQUEST['tbkuser'];
        $username   = $_REQUEST['username_tbk'];
        $amount     = $_REQUEST['monto'];
        
    
        /** Identificador único de la compra generado por el comercio */
        $random = rand();
        $buyOrder = $fecha_buy.$random;

        $request = array(
            "buyOrder" => $buyOrder,
            "tbkUser" => $tbkUser,
            "username" => $username,
            "amount" => $amount,
        );

        /** Rescatamos resultado y datos de la transaccion */
        $result = $webpay->getOneClickTransaction()->authorize($buyOrder, $tbkUser, $username, $amount);

        $responseCode = $result->responseCode;

        if ($responseCode != 0) {
            $message = "Transacci&oacute;n RECHAZADA por webpay";
            $next_page = "";
        } else {
            $message = "Transacci&oacute;n ACEPTADA por webpay";
            $next_page = "https://steam.cl/test2/ej4.php?action=OneClickReverse";

        }
    }else{
    $message = "Usuario o Campo Incorrecto";
}
?>
<h3 style="text-align: center; font-size: 40px;"><?php echo $message; ?></h3>
<!-- <div style="background-color:lightyellow;">
    <h3>request</h3>
    <?php var_dump($request); ?>
</div>
<div style="background-color:lightgrey;">
    <h3>result</h3>
    <?php var_dump($result); ?>
</div>-->
<div style="background-color:lightgreen;text-align: center;">
    <h3>Datos Ingresados</h3>
    <table align="center" style = "border: 1px solid #dddddd;">
        <tr>
            <th>Variable</th>
            <th>Valor</th>
        </tr>
        <tr>
            <td>Usuario de TBK</td>
            <td><?php echo $username; ?></td>
        </tr>
        <tr>
            <td>Codigo de Usuario TBK</td>
            <td><?php echo $tbkUser; ?></td>
        </tr>
        <tr>
            <td>Monto</td>
            <td><?php echo $amount; ?></td>
        </tr>        
        <tr>
            <td>Orden de Compra</td>
            <td><?php echo $buyOrder; ?></td>
        </tr>
    </table>
    </div>
<div style="background-color:orange;text-align: center;">
    <h3>Resultado Transaccción</h3>
    <table align="center" style = "border: 1px solid #dddddd;">
		<tr>
            <th>Variable</th>
            <th>Valor</th>
        </tr>
        <tr>
            <td>Orden de Compra</td>
            <td><?php echo $buyOrder; ?></td>
        </tr>
        <tr>
            <td>Codigo de respuesta</td> <!--responseCode-->
            <td><?php echo $result->responseCode ?></td>
        </tr>
        <tr>
            <td>Codigo de autorización</td><!--authorizationCode-->
            <td><?php echo $result->authorizationCode ?></td>
        </tr>
        <tr>
            <td>Tipo de tarjeta</td><!--creditCardType-->
            <td><?php echo $result->creditCardType; ?></td>
        </tr>
        <tr>
            <td>Ultimos 4 digitos</td><!--las4CardDigits-->
            <td><?php echo $result->last4CardDigits; ?></td>
        </tr>
        <tr>
            <td>Codigo de transacción</td><!--transactionId-->
            <td><?php echo $result->transactionId; ?></td>
        </tr>
    </table>
    </div>
<p style="text-align: right; font-size: 30px;">
<a  href="cobro.php">&laquo; volver a cobros</a></p>