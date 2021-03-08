<?php
require('vendor/autoload.php');
require_once('pi.php');

use Transbank\Webpay\Configuration;

if(MODO == "P"){
    /** PRODUCCION **/
    $commerce_code     = 597035416323;
    $childcommerceCode = 597035670025;
    
    $configuration = new Oneclick();
    $configuration->setApiKey("B059D9725FE00A34BEF0B80C024A90292D1652061C3C4AD8F4233240D206A5D3");
    $configuration->setCommerceCode($commerce_code);
    $configuration->setIntegrationType("LIVE");
    
    $urlReturn = "https://planes.rest911.cl/ins.php?action=OneClickFinishInscription";
}
        
if(MODO == "I"){
    /** INTEGRACION **/
    $commerce_code     = 597055555541;
    $childcommerceCode = 597055555542;
    
    $configuration = new Oneclick();
    $configuration->setApiKey("579B532A7440BB0C9079DED94D31EA1615BACEB56610332264630D42D0A36B1C");
    $configuration->setCommerceCode($commerce_code);
    $configuration->setIntegrationType("TEST");

    $urlReturn = "https://planes.rest911.cl/restmall/ins.php?action=OneClickFinishInscription";   
    
    //$configuration = Oneclick::configureOneclickMallForTesting();
}
?>