<?php
//include_once 'conn.php';

//PANEL OC HECHO MANUALMENTE NO EN ESTA PÁGINA

/*
CONSULTA DE CLIENTES      => index
CONSULTA DE TRANSACCIONES => consulta_t
MANTENEDOR DE DESCUENTOS  => descuentos
INGRESO ASISTIDO          => asistencia
PANEL OC                  =>
REVERSAS DE CARGOS        => consulta_re
CREADOR DE USUARIOS       => registro_usuarios
DESVINCULACION            => desvincular
PANEL DE COBROS           => panel_c
REINGRESO                 => reingreso
VENCIDOS                  => vencidos
CAMPAÑA                   => campana
COMPLETAR                 => completar
*/

function getPermisos($pagina, $rol){
    $sadmin = array("index", "consulta_t", "descuentos", "asistencia", "consulta_re", "registro_usuarios", "desvincular", "panel_c", "ocnormal", "reingreso", "vencidos", "campana", "completar");
    $admin  = array("index", "consulta_t", "descuentos", "asistencia", "registro_usuarios", "desvincular", "panel_c", "ocnormal", "completar");
    $svisor = array("index", "consulta_t", "asistencia", "registro_usuarios", "desvincular", "panel_c", "ocnormal", "completar");
    $sac    = array("index", "consulta_t", "asistencia", "ocnormal");
    $rec    = array("index", "consulta_t", "asistencia", "consulta_re", "desvincular", "panel_c", "ocnormal", "reingreso", "vencidos");
    $com    = array("index", "asistencia", "campana", "completar");
    
    /*
    $userid     = $_SESSION['userid'];
    $sql        = "SELECT estado FROM user WHERE userid = $userid;";
    $query      = mysqli_query($conn, $sql);
    $resp_query = mysqli_fetch_array($query);
    if($resp_query["estado"] == 'S'){
    
    */
    
        if($rol == 1){
            return in_array($pagina, $sadmin);
        }
        elseif($rol == 2){
            return in_array($pagina, $admin);
        }
        elseif($rol == 3){
            return in_array($pagina, $svisor);
        }
        elseif($rol == 4){
            return in_array($pagina, $sac);
        }
        elseif($rol == 5){
            return in_array($pagina, $rec);
        }
        elseif($rol == 6){
            return in_array($pagina, $com);
        }
        else{
            return false;
        }
    
    
    /*
    }
    else{
        return false;
    }
    */
}

?>