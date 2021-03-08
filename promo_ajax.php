<?php
include_once('admin/config/conn.php');
require('admin/config/modomall.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Transbank\Webpay\Oneclick;
use Transbank\Webpay\Oneclick\MallInscription;
use Transbank\Webpay\Oneclick\MallTransaction;

function getFecha(){
    date_default_timezone_set("America/Santiago");
    $fecha = date("Y-m-d");
    return $fecha;
}

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
    if($_POST['function'] == 'getValores' && !empty($_POST['plan']) && !empty($_POST['benef'])){
        $plan      = $_POST['plan'];
        $benef     = $_POST['benef'];
        
        $conn  = getConn();
        $sql   = "CALL TRAER_VALORES($plan, $benef, 1);";
        $query = mysqli_query($conn, $sql);
        if(mysqli_num_rows($query) > 0){
            $result = mysqli_fetch_assoc($query);
            $valor  = $result["VALOR_PLAN_REAL"];
            echo $valor;
        }
        else{
            echo null;
        }
    }
    else if($_POST['function'] == 'registrarOrden'){
        $fec_pag   = getFechaYHora();
        $nombre    = $_POST['nombre'];
        $apellido  = $_POST['apellido'];
        $rut       = $_POST['rut'];
        $email     = $_POST['email'];
        $fono      = '56'.$_POST['fono'];
        $ciudad    = $_POST['ciudad'];
        
        $plan      = $_POST['plan'];
        $nom_plan  = $_POST['nom_plan'];
        $benef     = $_POST['benef'];
        
        $dscto     = $_POST['dscto'];
        $dias      = $_POST['dias'];
        $valor     = $_POST['valor'];
        $cant_desc = $_POST['original'] - $valor;
        if($_POST['meses'] > 0){
            $meses = $_POST['meses'];
        }
        else{
            $meses = 1;
        }
        $cod_camp  = $_POST['cod_camp'];
        $fec_dscto = addMonths(getFecha(), $meses);
        
        $fecha_tbk = getFechaYHora();
        $obs       = "INGRESO POR CAMPANA";

        $conn      = getConn();
        
        #Descuento por meses
        if($dscto && $_POST['meses'] > 0){
            $fec_fac   = getFecha();
            $sql       = "INSERT INTO pagos_clientes(fec_pag, t_nombres, t_apellido1, rut, email, telefono, comuna, 
                      cod_plan, nom_plan, num_benef, valor_plan_benef, valor_plan, num_mes, campania, cant_descuento, fec_descuento, 
                      estado, fecha_tbk, fec_fac, clase, observa, userid) 
                      VALUES ('$fec_pag', '$nombre', '$apellido', '$rut', '$email', '$fono', '$ciudad', 
                      $plan, '$nom_plan', $benef, $valor, $valor, $meses, $cod_camp, $cant_desc, '$fec_dscto',
                      'E', '$fecha_tbk', '$fec_fac', 'D', '$obs', -1);";
        }
        #Descuento permanente
        else if($dscto && $_POST['meses'] == 0){
            $fec_fac   = getFecha();
            $sql       = "INSERT INTO pagos_clientes(fec_pag, t_nombres, t_apellido1, rut, email, telefono, comuna, 
                      cod_plan, nom_plan, num_benef, valor_plan_benef, valor_plan, num_mes, campania, cant_descuento, fec_descuento, 
                      estado, fecha_tbk, fec_fac, clase, observa, userid) 
                      VALUES ('$fec_pag', '$nombre', '$apellido', '$rut', '$email', '$fono', '$ciudad', 
                      $plan, '$nom_plan', $benef, $valor, $valor, $meses, $cod_camp, $cant_desc, NULL,
                      'E', '$fecha_tbk', '$fec_fac', 'D', '$obs', -1);";
        }
        #Descuento por dias
        else{
            $fec_fac   = addMonths(getFecha(), ($meses - 1));
            $sql       = "INSERT INTO pagos_clientes(fec_pag, t_nombres, t_apellido1, rut, email, telefono, comuna, 
                      cod_plan, nom_plan, num_benef, valor_plan_benef, valor_plan, num_mes, campania, cant_descuento, fec_descuento, 
                      estado, fecha_tbk, fec_fac, clase, observa, userid) 
                      VALUES ('$fec_pag', '$nombre', '$apellido', '$rut', '$email', '$fono', '$ciudad', 
                      $plan, '$nom_plan', $benef, $valor, $valor, $meses, $cod_camp, $cant_desc, NULL,
                      'E', '$fecha_tbk', '$fec_fac', 'D', '$obs', -1);";
        }
        
        $query = mysqli_query($conn, $sql);
        if($query){
            $pagos    = mysqli_insert_id($conn);
            $username = str_replace(".","",$rut).'_'.$pagos;
            
            $result = MallInscription::start($username, $email, $urlReturn);           
            $result = get_object_vars($result);

            if(!empty($result["token"])){
                $token     = $result["token"];
                $next_page = $result["urlWebpay"];
                
                $sql  = "UPDATE pagos_clientes SET username = '$username' ,token = '$token' WHERE pagos = $pagos;";
                $query = mysqli_query($conn, $sql);
                
                if($query){
                    $datos = array($token, $next_page);
                    echo json_encode($datos);
					//echo "OK";
                }
                else{
                    //echo("Error description: " . mysqli_error($conn));
                    echo "Error al guardar registro post-inscripción";
                }
            }
            else{
                echo("Error con Transbank");
            }
        }
        else{
            //echo("Error description: " . mysqli_error($conn));
            echo("Error al conectar con base de datos");
        }
    }
}
?>