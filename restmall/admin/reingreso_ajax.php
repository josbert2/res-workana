<?php
include_once('config/conn.php');
include('config/modo1.php');
include_once "config/permisos.php";

session_start();
$rol = $_SESSION['rol'];
$currentPage = "reingreso";
$acceso = getPermisos($currentPage, $rol);
if(!$acceso){
    header("location: ../login.php");    
}

use Transbank\Webpay\Oneclick\MallInscription;
use Transbank\Webpay\Oneclick\MallTransaction;

function getFechaYHora(){
    date_default_timezone_set("America/Santiago");
    $time  = time();
    $hora = date('Y-m-d H:i:s', $time);
    return $hora;
}

function addMonths($date, $monthToAdd){
    $d1 = DateTime::createFromFormat('Y-m-d', $date);

    $year = $d1->format('Y');
    $month = $d1->format('n');
    $day = $d1->format('d');

    $year += floor($monthToAdd/12);
    $monthToAdd = $monthToAdd%12;
    $month += $monthToAdd;

    if($month > 12) {
        $year ++;
        $month = $month % 12;
        if($month === 0)
            $month = 12;
    }
    if($monthToAdd < 0){
        if(($month + $monthToAdd) <= 0){
            $year --;
            $month = $month + $monthToAdd + 13;
        }
        else{
            $month += $monthToAdd; 
        }
    }

    if(!checkdate($month, $day, $year)) {
        $d2 = DateTime::createFromFormat('Y-n-j', $year.'-'.$month.'-1');
        $d2->modify('last day of');
    }else {
        $d2 = DateTime::createFromFormat('Y-n-d', $year.'-'.$month.'-'.$day);
    }
    return $d2->format('Y-m-d');
}

if(isset($_POST['function'])){
    if($_POST['function'] == 'getDatos' && !empty($_POST['rut'])){
        $rut   = $_POST['rut'];
        
        $datos = array();
        $conn  = getConn();
        $sql   = "SELECT pagos_clientes.pagos, pagos_clientes.t_nombres, pagos_clientes.t_apellido1,
                  pagos_clientes.t_apellido2, pagos_clientes.num_benef, pagos_clientes.valor_plan_benef,
                  pagos_clientes.estado, DATE_FORMAT(DATE_ADD(MAX(pagos_transac.t_fec_fac), INTERVAL 1 MONTH), '%d-%m-%Y') as fec_fac,
                  DATE_FORMAT(MAX(pagos_transac.t_fecha_tbk), '%d-%m-%Y %H:%i:%s') as fecha_tbk 
                  FROM pagos_clientes INNER JOIN pagos_transac 
                  ON ((pagos_clientes.estado = 'S' OR pagos_clientes.estado = 'M')
                  AND (pagos_clientes.rut = '$rut') AND (pagos_clientes.pagos = pagos_transac.t_cod_pagos))
                  GROUP BY pagos_clientes.pagos ORDER BY pagos_clientes.pagos DESC";
        $query = mysqli_query($conn, $sql);
        if(mysqli_num_rows($query) > 0){
            while($row = mysqli_fetch_array($query)){
                $datos[] = $row; 
            }
        }
        echo json_encode($datos);
    }
    else if($_POST['function'] == 'setDatos' && !empty($_POST['id']) && !empty($_POST['usuario']) && !empty($_POST['monto']) && !empty($_POST['fecha'])){
        $id          = $_POST['id'];
        $usuario     = $_POST['usuario'];
        $monto_nuevo = $_POST['monto'];
        $fecha_sf    = $_POST['fecha'];
        $fecha_nueva = date("Y-m-d", strtotime($fecha_sf));  
        
        $obs         = $_POST['obs'];
        
        #Hacer copia registro original en tabla reingreso
        $conn  = getConn();
        $sql   = "SELECT pagos_clientes.rut, pagos_clientes.valor_plan_benef, pagos_clientes.estado,
                  DATE_ADD(MAX(pagos_transac.t_fec_fac), INTERVAL 1 MONTH) as fec_fac, MAX(pagos_transac.t_fecha_tbk) as fecha_tbk 
                  FROM pagos_clientes INNER JOIN pagos_transac 
                  ON ((pagos_clientes.estado = 'S' OR pagos_clientes.estado = 'M')
                  AND (pagos_clientes.pagos = $id) AND (pagos_transac.t_cod_pagos = $id))
                  GROUP BY pagos_clientes.pagos ORDER BY pagos_clientes.pagos DESC";
        $query      = mysqli_query($conn, $sql);
        $result     = mysqli_fetch_array($query);
        
        $rut        = $result['rut'];
        $monto_orig = $result['valor_plan_benef'];
        $estado     = $result['estado'];
        $fecha_orig = $result['fec_fac'];
        $fecha_mod  = getFechaYHora();
        $fecha_tbk  = $result['fecha_tbk'];
        
        $sql   = "INSERT INTO reingreso(cod_pag, rut, monto_orig, monto_new, fecfac_orig, fecfac_new, fec_mod, user, obs)
                  VALUES($id, '$rut', $monto_orig, $monto_nuevo, STR_TO_DATE('$fecha_orig','%Y-%m-%d'), 
                  STR_TO_DATE('$fecha_nueva','%Y-%m-%d'), STR_TO_DATE('$fecha_mod','%Y-%m-%d %H:%i:%s'),
                  $usuario, '$obs');";
        $query = mysqli_query($conn, $sql);
        if($query){
            
            #Crear transaccion de regularizacion
            $sql   = "INSERT INTO pagos_transac(t_cod_pagos, t_correl_pago, t_fec_fac, t_val_mensual, t_can_desc, 
                      t_val_plan, t_estado, t_buyorder, t_authorizationcode, t_transactionid, t_fecha_tbk, 
                      t_payment_type_code, t_observa, t_userid)
                      VALUES($id, 0, DATE_SUB(STR_TO_DATE('$fecha_nueva','%Y-%m-%d'), INTERVAL 1 MONTH), $monto_nuevo, 0, 0, 'X', 'NULL',
                      'NULL', 'NULL', STR_TO_DATE('$fecha_tbk','%Y-%m-%d %H:%i:%s'), 'NULL', 'REGISTRO DE REGULARIZACION SIN COBRO', $usuario);";
            $query = mysqli_query($conn, $sql);
            if($query){
                
                #Modificar registro original con el de reingreso
                if($estado = 'M'){
                    $sql = "UPDATE pagos_clientes SET fec_descuento = NULL, valor_plan_benef = $monto_nuevo, estado = 'S' WHERE pagos = $id;";
                }
                else{
                    $sql = "UPDATE pagos_clientes SET fec_descuento = NULL, valor_plan_benef = $monto_nuevo WHERE pagos = $id;";
                }
                $query = mysqli_query($conn, $sql);
                if($query){
                    #Todo perfecto
                    echo 1;
                    //echo("Error description: " . mysqli_error($conn));
                }
                else{
                    #Error modificacion
                    echo 2;
                    //echo("Error description: " . mysqli_error($conn));
                }
            }
            else{
                #Error transaccion
                echo 3;
                //echo("Error description: " . mysqli_error($conn));
            }
        }
        else{
            #Error todo
            echo 4;
            //echo("Error description: " . mysqli_error($conn));
        }
    }
}
?>