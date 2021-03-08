<?php
require('admin/config/modomall.php');
use Transbank\Webpay\Oneclick\MallInscription;
use Transbank\Webpay\Oneclick\MallTransaction;
$message = "DESINSCRIPCION";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(isset($_POST['tbkUser'])){
    $tbkUser  = $_POST['tbkUser'];
    $username = $_POST['username'];
    
    $response = MallInscription::delete($tbkUser, $username, NULL);

    if($response){
        $message   = "Usuario Eliminado";
    }
    else{
        $message   = "Error en Eliminación";
    }
    session_unset();
}
?>

<h2><?php echo $message; ?></h2>
    <form action="https://planes.rest911.cl/restmall/desinscribir.php" method="post">
        <label for="tbkUser">tbkUser</label>
        <input type="input" name="tbkUser" placeholder="tbkUser">
        
        <label for="username">username</label>
        <input type="input" name="username" placeholder="username">
        
        <input type="submit" value="Continuar">
    </form>
<br>