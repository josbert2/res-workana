<?php
require('admin/config/modomall.php');
use Transbank\Webpay\Oneclick;
use Transbank\Webpay\Oneclick\MallInscription;
use Transbank\Webpay\Oneclick\MallTransaction;
$message = "REVERSA";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(isset($_POST['buyOrder'])){
        
    $buyOrder      = $_POST['buyOrder'];
    $childBuyOrder = $buyOrder;
    $amount        = $_POST['amount'];
    
    //echo "buyOrder: ".$buyOrder."\nchildCommerceCode: ".$childcommerceCode."\nchildBuyOrder: ".$childBuyOrder."\namount: ".$amount;
        
    $result = MallTransaction::refund($buyOrder, $childcommerceCode, $childBuyOrder, $amount);
    //$result = $result->type;
    
    var_dump($result);
    
    /*
    if(($result = "REVERSED") OR ($result = "NULLIFY")) {
        $message = "PAGO REVERSADO CON EXITO";
    }
    else{
        $message = "LA REVERSA HA FALLADO";
    }
    */
}
?>

<h2><?php echo $message; ?> RETORNO <?php echo $result; ?></h2>
    <form action="https://planes.rest911.cl/reembolso.php" method="post">
        <label for="buyOrder">Orden de compra</label>
        <input type="input" name="buyOrder" placeholder="Orden de compra">
        
        <label for="amount">Monto</label>
        <input type="input" name="amount" placeholder="Monto">
        
        <input type="submit" value="Continuar">
    </form>
<br>