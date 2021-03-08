<?php
include_once "config/permisos.php";

session_start();
$rol = $_SESSION['rol'];
$currentPage = "reingreso"; 
$acceso = getPermisos($currentPage, $rol);
if(!$acceso){
    header("location: ../login.php");    
}

function getTransc($transc,$bdesde,$bhasta){
    
    if($transc == "T"){
        $sql  = "SELECT RE.cod_mod, RE.cod_pag, RE.rut, RE.monto_orig, RE.monto_new, RE.fecfac_orig, RE.fecfac_new, RE.fec_mod, US.usuario, RE.obs FROM reingreso RE INNER JOIN user US on RE.user = US.userid WHERE ( (CAST(RE.fec_mod AS DATE) >= '$bdesde') AND (CAST(RE.fec_mod AS DATE) <= '$bhasta') ) ORDER BY RE.cod_mod ASC";

        return $sql;

    }
}
?>