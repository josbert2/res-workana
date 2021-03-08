<?php
session_start();
if($_SESSION['rol'] != 1){
    header("location: ../login.php");    
}
require_once '../vendor/autoload.php';
include_once 'config/conexion.php';

use Transbank\Webpay\Oneclick\MallTransaction;


include_once('config/modo1.php');
include_once("config/func.php");

$fecha_buy = getFechabuy();

/** Identificador único de la inscripción del cliente */
if( (!empty($_REQUEST['username_tbk'])) &&
    (!empty($_REQUEST['monto'])) &&
    (!empty($_REQUEST['tbkuser'])) ){

        $tbkUser    = $_REQUEST['tbkuser'];
        $username   = $_REQUEST['username_tbk'];
    
        $amount     = $_REQUEST['monto'];
        $random = rand();
        $buyOrder = $fecha_buy.$random;
        //$childcommerceCode = 597055555542;
        $installments_number = 1;

        $details = [
            [
                "commerce_code" => $childcommerceCode,
                "buy_order" => $buyOrder,
                "amount" => $amount,
                "installments_number" => $installments_number
            ]
        ];

        /** Rescatamos resultado y datos de la transaccion */
        $result = MallTransaction::authorize($username, $tbkUser, $buyOrder, $details);
        $responseCode = $result->details[0]["response_code"];

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
            <td><?php echo $result->details[0]["response_code"]?></td>
        </tr>
        <tr>
            <td>Codigo de autorización</td><!--authorizationCode-->
            <td><?php echo $result->details[0]["authorization_code"] ?></td>
        </tr>
        <tr>
            <td>Código tipo de pago</td><!--creditCardType-->
            <td><?php echo $result->details[0]["payment_type_code"] ?></td>
        </tr>
        <tr>
            <td>Ultimos 4 digitos</td><!--las4CardDigits-->
            <td><?php echo $result->cardNumber ?></td>
        </tr>
        <!--<tr>
            <td>Codigo de transacción</td>
            <td><?php// echo $result->transactionId; ?></td>
        </tr>-->
    </table>
    </div>
<p style="text-align: right; font-size: 30px;">
<a  href="cobromall.php">&laquo; volver a cobros</a></p>