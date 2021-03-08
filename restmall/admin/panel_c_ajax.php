<?php
include_once('config/conn.php');
include('config/modo1.php');
include_once "config/permisos.php";

session_start();
$rol = $_SESSION['rol'];
$currentPage = "panel_c";
$acceso = getPermisos($currentPage, $rol);
if(!$acceso){
    header("location: ../login.php");    
}

use Transbank\Webpay\Oneclick\MallInscription;
use Transbank\Webpay\Oneclick\MallTransaction;

$mesesMoroso = 24;

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

function getFechaYHora(){
    date_default_timezone_set("America/Santiago");
    $time  = time();
    $hora = date('Y-m-d H:i:s', $time);
    return $hora;
}

function getFechabuy(){
    date_default_timezone_set("America/Santiago");
    $fecha = date("Ymd");
    return $fecha;
}

function getFecha(){
    date_default_timezone_set("America/Santiago");
    $time  = time();
    $fecha = date("Y-m-d", $time);
    return $fecha;
}

function filtrarCobro($datos){
    $fecha_actual = getFecha();
    foreach($datos as $k => $cliente){
        $date1 = date_create($fecha_actual);
        $date2 = date_create($cliente["fec_fac"]);

        $diff1 = date_diff($date1, $date2);
        $diff1 = $diff1->format('%m');

        if(($fecha_actual < $cliente["fec_fac"]) || ($diff1 < 1)){
            unset($datos[$k]);
        }
    }
    return array_filter($datos);
}

function filtrarClientes($datos){
    $datos = filtrarCobro($datos);
    return $datos;
}

function getClientesI(){
    $conn = getConn();
    $sql  = "SELECT pagos, rut, CAST(fec_pag AS DATE) AS fec_pag, num_mes, fec_fac, valor_plan, clase 
            FROM pagos_clientes
            WHERE ((estado = 'I') AND (fec_fac != 'NULL')) ORDER BY pagos DESC;";
    
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0){
        $datos = array();
        while($row = mysqli_fetch_array($query)){
            $datos[] = $row;
        }
        $datos = filtrarClientes($datos);
        return $datos;
    }
    else{
        //die;
        return NULL;
    }
}

function getClientesS(){
    $conn = getConn();
    $sql  = "SELECT pagos_clientes.pagos, pagos_clientes.rut, CAST(pagos_clientes.fec_pag AS DATE) AS fec_pag, 
            pagos_clientes.num_mes, pagos_clientes.valor_plan_benef, pagos_clientes.clase as clase, MAX(pagos_transac.t_fec_fac) AS fec_fac,
            CAST(MAX(pagos_transac.t_fecha_tbk) AS DATE) AS t_fecha_tbk FROM pagos_clientes INNER JOIN pagos_transac 
            ON ((pagos_clientes.pagos = pagos_transac.t_cod_pagos) AND (pagos_clientes.estado = 'S')
            AND (pagos_clientes.fec_pag != 'NULL') AND (pagos_clientes.num_mes != 'NULL')
            AND (pagos_transac.t_fec_fac != 'NULL') AND (pagos_transac.t_fecha_tbk != 'NULL')) 
            GROUP BY pagos_clientes.pagos ORDER BY pagos_clientes.pagos DESC;";
    
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0){
        $datos = array();
        while($row = mysqli_fetch_array($query)){
            $datos[] = $row; 
        }
        $datos = filtrarClientes($datos);
        return $datos;
    }
    else{
        //die;
        return NULL;
    }
}

function getDatosClientes(){
    $clientesS = getClientesS();
    $clientesI = getClientesI();
    if(($clientesS != NULL) && ($clientesI != NULL)){
        return array_merge($clientesI, $clientesS);
    }
    elseif(($clientesS == NULL) && ($clientesI == NULL)){
        return NULL;
    }
    elseif($clientesS == NULL){
        return $clientesI;
    }
    else{
        return $clientesS;
    }
}

if(isset($_POST['function'])){
    if($_POST['function'] == 'cobrarClientes' && !empty($_POST['ids'])){
    
        $ids    = $_POST['ids'];
		$userid = $_POST['userid'];
        $data   = array();
        $childBuyOrder = getFechabuy();
        
        $conn = getConn();
        foreach($ids as $k => $id){
            
            $sql = "SELECT pagos_clientes.t_nombres, pagos_clientes.t_apellido1, 
                    pagos_clientes.rut, pagos_clientes.estado, pagos_transac.t_fec_fac 
                    FROM pagos_clientes INNER JOIN pagos_transac 
                    ON ((pagos_clientes.pagos = $id) AND (pagos_transac.t_cod_pagos = $id)
                    AND ((pagos_clientes.estado = 'S') || (pagos_clientes.estado = 'I'))) 
                    ORDER BY t_fec_fac DESC LIMIT 1;";
            $query = mysqli_query($conn, $sql);
            
            //Es tipo S
            if(mysqli_num_rows($query) > 0){ 
                $resp_query = mysqli_fetch_array($query);
                $nombre  = $resp_query["t_nombres"]." ".$resp_query["t_apellido1"];
                $rut     = $resp_query["rut"];
                $fec_fac = $resp_query["t_fec_fac"];
                $estado  = $resp_query["estado"];
            }
            
            //Es tipo I
            else{
                $sql   = "SELECT t_nombres, t_apellido1, rut, estado, fec_fac FROM pagos_clientes 
                        WHERE ((pagos = $id) AND ((estado = 'S') || (estado = 'I')));";
                $query = mysqli_query($conn, $sql);
                
                if(mysqli_num_rows($query) > 0){ 
                    $resp_query = mysqli_fetch_array($query);
                    $nombre  = $resp_query["t_nombres"]." ".$resp_query["t_apellido1"];
                    $rut     = $resp_query["rut"];
                    $fec_fac = $resp_query["fec_fac"];
                    $estado  = $resp_query["estado"];
                }
                else{
                    //ERROR
                }
            }
            
            //Comprobar si es necesario cobrar
            if(!empty($fec_fac)){
                
                $fecha_actual = getFecha();

                $date1 = date_create($fecha_actual);
                $date2 = date_create($fec_fac);

                $diff1 = date_diff($date1, $date2);
                $diff1 = $diff1->format('%m');
                
                if(($fecha_actual > $fec_fac) && ($diff1 >= 1)){
                    $cobrar = TRUE;
                }
                else{
                    $cobrar = FALSE;
                }
            }
            else{
                $cobrar = FALSE;
            }
            
            //Es necesario cobrar
            if($cobrar){
                
                //Traer datos necesarios para la transacción
                $sql   = "SELECT t_nombres, t_apellido1, username, tbkuser, valor_plan_benef, estado 
                        FROM pagos_clientes WHERE pagos = $id;";
                $query = mysqli_query($conn, $sql);

                //Datos necesarios para la transacción
                if(mysqli_num_rows($query) > 0){
                    $resp_query = mysqli_fetch_array($query);
                    $username = $resp_query["username"];
                    $tbkuser  = $resp_query["tbkuser"];
                    $amount   = $resp_query["valor_plan_benef"];
                    $estado   = $resp_query["estado"];
                }

                $childbuyOrder = $childBuyOrder.rand();
                $details = [
                    [
                        "commerce_code" => $childcommerceCode,
                        "buy_order" => $childbuyOrder,
                        "amount" => $amount,
                        "installments_number" => NULL
                    ]
                ];
                
                $data[$k]["id"]     = $id;
                $data[$k]["rut"]    = $rut;
                $data[$k]["nombre"] = $nombre;
                $data[$k]["fecha"]  = getFechaYHora();
                $data[$k]["monto"]  = $amount;
                
                //Se intenta realizar la transaccion
                try{
                    
                    //Realiza la transacción
                    $response = MallTransaction::authorize($username, $tbkuser, $childbuyOrder, $details);

                    //Datos para mostrar post transaccion

                    $data[$k]["orden"]  = $childbuyOrder;
                    $data[$k]["pago"]   = $response->details[0]["payment_type_code"];
                    $responseCode       = $response->details[0]["response_code"];

                    //Transacción exitosa
                    if($response->details[0]["status"] == "AUTHORIZED"){
         
                        $auth_code        = $response->details[0]["authorization_code"];

                        //Si es estado I
                        if($estado == 'I'){

                            //Cambiar estado de 'I' a 'S'
                            $fecha_tbk         = getFechaYHora();
                            $payment_type_code = $response->details[0]["payment_type_code"];
                            $new_fec_fac       = addMonths($fec_fac, 1);
         
                            //Se activa el trigger y se registra una nueva transacción
                            $sql = "UPDATE pagos_clientes SET estado = 'S', buyorder = $childbuyOrder,
                                    authorizationcode = $auth_code, fecha_tbk = '$fecha_tbk', 
                                    payment_type_code = '$payment_type_code',
                                    fec_fac = '$new_fec_fac'
                                    WHERE ((pagos = $id) AND (estado = 'I'));";
                            $query = mysqli_query($conn, $sql);

                            //Si se logró cambiar el estado
                            if($query){
                            
                                //Se deshabilitan los registros de deudas si existen
                                $sql = "UPDATE fallidas SET f_estado = 'N' WHERE f_cod_pagos = $id;";
                                $query = mysqli_query($conn, $sql);

                                $sql = "UPDATE pagos_transac SET t_userid = $userid, t_observa = 'COBRO MENSUAL ASISTIDO' WHERE t_cod_pagos = $id ORDER BY t_cod_tran DESC LIMIT 1;";
								$query = mysqli_query($conn, $sql);
                        
                                $resCode = 0;
                            }

                            //Si no se logró cambiar el estado
                            else{
                                $resCode = 100;
                                //echo("Error description: " . mysqli_error($conn));
                            }

                        }

                        //Si es estado S
                        else{

                            /* AÑADIR EL VENDEDOR AL UPDATE
                            +
                            +
                            +
                            +
                            */

                        
                            //Registrar nueva transaccion en la tabla
                            $sql        = "select (select t_correl_pago from pagos_transac where t_cod_pagos = $id ORDER BY t_correl_pago DESC LIMIT 1) as t_correl_pago, (select t_fec_fac from pagos_transac where t_cod_pagos = $id ORDER BY t_fec_fac DESC LIMIT 1) as t_fec_fac;";
                            $query      = mysqli_query($conn, $sql);
                            $resp_query = mysqli_fetch_array($query);

                            $resp_fec_fac        = $resp_query["t_fec_fac"];

                            //Datos para guardar
                            $t_cod_pagos         = $id;
                            $t_correl_pago       = $resp_query["t_correl_pago"] + 1;
                            $t_fec_fac           = addMonths($resp_fec_fac, 1);
                            $t_val_mensual       = $amount;
                            $t_val_plan          = $amount;
                            $t_buyorder          = $childbuyOrder;
                            $t_authorizationcode = $response->details[0]["authorization_code"];
                            $t_fecha_tbk         = getFechaYHora();
                            $t_payment_type_code = $response->details[0]["payment_type_code"];
                            $t_observa           = "COBRO MENSUAL ASISTIDO";

                            $sql = "CALL INSERT_TRANSAC('$t_cod_pagos','$t_correl_pago','$t_fec_fac','$t_val_mensual', 0, '$t_val_plan', 'S', '$t_buyorder', '$t_authorizationcode', '$t_fecha_tbk', '$t_payment_type_code', '$t_observa' );";
                            $query = mysqli_query($conn, $sql);

                            //Si el registro se hizo
                            if($query){
                                $resCode = 0;

								$sql = "UPDATE pagos_transac SET t_userid = $userid WHERE t_cod_pagos = $id ORDER BY t_cod_tran DESC LIMIT 1;";
								$query = mysqli_query($conn, $sql);
                                
                                //Se deshabilitan los registros de deudas si existen
                                $sql = "UPDATE fallidas SET f_estado = 'N' WHERE f_cod_pagos = $id;";
                                $query = mysqli_query($conn, $sql);
                            }

                            //Si no se hizo el registro
                            else{
                                $resCode = 101;
                                //echo("Error description: " . mysqli_error($conn));
                            }
                        }
                    }

                    //Transacción fallida
                    else{
            
                        $fecha_tbk  = getFechaYHora();
                        $tipo_pago  = $response->details[0]["payment_type_code"];

                        $sql        = "SELECT f_correl_fall FROM fallidas 
                                       WHERE (f_cod_pagos = $id AND estado = 'S') ORDER BY f_correl_fall DESC;";
                        $query      = mysqli_query($conn, $sql);
                        $resp_query = mysqli_fetch_array($query);

                        //Si hay transacciones fallidas anteriormente
                        if($resp_query){
                            $correl = $resp_query["f_correl_fall"] + 1;
                        }

                        //No hay transacciones fallidas anteriormente
                        else{
                            $correl = 1;
                        }

                        //Traducir responseCode
                        if($responseCode == -1){
                            $log = "Error en el ingreso de datos (-1)";
                        }
                        elseif($responseCode == -2){
                            $log = "Error en parámetros de la tarjeta y/o su cuenta asociada (-2)";
                        }
                        elseif($responseCode == -3){
                            $log = "Error interno de Transbank (-3)";
                        }
                        elseif($responseCode == -4){
                            $log = "Rechazada por parte del emisor (-4)";
                        }
                        elseif($responseCode == -5){
                            $log = "Transacción con riesgo de fraude (-5)";
                        }
                        elseif($responseCode == -97){
                            $log = "Máximo monto diario de pago excedido (-97)";
                        }
                        elseif($responseCode == -98){
                            $log = "Máximo monto de pago excedido (-98)";
                        }
                        elseif($responseCode == -99){
                            $log = "Máxima cantidad de pagos diarios excedido (-99)";
                        }

                        //Verificar si es moroso
                        if(($fecha_actual > $fec_fac) && ($diff1 >= $mesesMoroso)){
                            $moroso = TRUE;
                            $log    = $log.", cliente pasa a estado MOROSO";
                        }   

                        //Registro nueva transacción fallida
                        $sql        = "INSERT INTO fallidas (f_cod_pagos, f_correl_fall, 
                                       f_fec_fac, f_val_mensual, f_val_plan, f_buyorder, f_responsecode,
                                       t_fecha_tbk, f_payment_type_code, f_log, f_userid) VALUES
                                       ($id, $correl, STR_TO_DATE('$fec_fac','%Y-%m-%d'), $amount,
                                       $amount, $childbuyOrder, $responseCode, 
                                       STR_TO_DATE('$fecha_tbk','%Y-%m-%d %H:%i:%s'), '$tipo_pago', '$log', $userid);";             
                                       
                        $query      = mysqli_query($conn, $sql);

                        //Si se registró la transaccion fallida
                        if($query){

                            //Cambiar estado a M
                            if($moroso){
                                $sql   = "UPDATE pagos_clientes SET estado = 'M' 
                                          WHERE ((pagos = $id) AND ((estado = 'S') || (estado = 'I')));";
                                $query = mysqli_query($conn, $sql);

                                //Si se cambió el estado
                                if($query){
                                    $resCode = 102;
                                }

                                //Si no se cambió el estado
                                else{
                                    $resCode = 103;
                                }
                            }

                            //Si no es moroso
                            else{
                                $resCode = 104;
                            }
                        }

                        //Si no se registró la transacción fallida
                        else{

                            //Cambiar estado a M
                            if($moroso){
                                $sql   = "UPDATE pagos_clientes SET estado = 'M' 
                                          WHERE ((pagos = $id) AND ((estado = 'S') || (estado = 'I')));";
                                $query = mysqli_query($conn, $sql);

                                //Si se cambió el estado
                                if($query){
                                    $resCode = 105;
                                }

                                //Si no se cambió el estado
                                else{
                                    $resCode = 106;
                                }
                            }

                            //Si no es moroso
                            else{
                                $resCode = 107;
                            }
                        }
                    } 

                    //Traducir respCode
                    
                    if($resCode == 0){
                        $data[$k]["cod"] = 0;
                        $data[$k]["resp"] = "TRANS. EXITOSA";
                    }
                    elseif($resCode == 100){
                        $data[$k]["cod"] = 100;
                        $data[$k]["resp"] = "TRANS. EXITOSA. ERROR AL REGISTRAR EN BD";
                    }
                    elseif($resCode == 101){
                        $data[$k]["cod"] = 101;
                        $data[$k]["resp"] = "TRANS. EXITOSA. ERROR AL REGISTRAR EN BD";
                    }
                    elseif($resCode == 102){
                        $data[$k]["cod"] = 102;
                        $data[$k]["error"] = "TRANS. RECHAZADA POR TBK. CLIENTE MOVIDO A MOROSOS";
                    }
                    elseif($resCode == 103){
                        $data[$k]["cod"] = 103;
                        $data[$k]["error"] = "TRANS. RECHAZADA POR TBK. ERROR AL MOVER CLIENTE A MOROSOS";
                    }
                    elseif($resCode == 104){
                        $data[$k]["cod"] = 104;
                        $data[$k]["error"] = "TRANS. RECHAZADA POR TBK.";
                    }
                    elseif($resCode == 105){
                        $data[$k]["cod"] = 105;
                        $data[$k]["error"] = "TRANS. RECHAZADA POR TBK. ERROR AL REGISTRAR EN BD. CLIENTE MOVIDO A MOROSOS";
                    }
                    elseif($resCode == 106){
                        $data[$k]["cod"] = 106;
                        $data[$k]["error"] = "TRANS. RECHAZADA POR TBK. ERROR AL REGISTRAR EN BD. ERROR AL MOVER CLIENTE A MOROSOS";
                    }
                    elseif($resCode == 107){
                        $data[$k]["cod"] = 107;
                        $data[$k]["error"] = "TRANS. RECHAZADA POR TBK. ERROR AL REGISTRAR EN BD.";
                    }        
                }
                
                //Si hay error en la transacción
                catch(Exception $e){
                    $data[$k]["orden"]  = "N/A";
                    $data[$k]["pago"]   = "N/A";
                    $data[$k]["cod"] = 108;
                    $data[$k]["error"] = "ERROR DATOS LOCAL / TBK NO DISPONIBLE";
                    
                    $log        = "ERROR DATOS LOCAL / TBK NO DISPONIBLE";
                    $fecha_tbk  = getFechaYHora();
                    $sql        = "SELECT f_correl_fall FROM fallidas 
                                   WHERE (f_cod_pagos = $id AND f_estado = 'S') ORDER BY f_correl_fall DESC;";
                    $query      = mysqli_query($conn, $sql);
                    $resp_query = mysqli_fetch_array($query);

                    //Si hay transacciones fallidas anteriormente
                    if($resp_query){
                        $correl = $resp_query["f_correl_fall"] + 1;
                    }

                    //No hay transacciones fallidas anteriormente
                    else{
                        $correl = 1;
                    }
                    
                    //Verificar si es moroso
		    		$fecha_actual = getFecha();

                    $date1 = date_create($fecha_actual);
                    $date2 = date_create($fec_fac);

                    $diff1 = date_diff($date1, $date2);
                    $diff1 = $diff1->format('%m');
                
                    if(($fecha_actual > $fec_fac) && ($diff1 >= $mesesMoroso)){
                        $moroso = true;
                        $log    = $log.", CLIENTE PASA A ESTADO MOROSO";
                    }
                    else{
                        $moroso = false;
                    }
                    
                    //Registro nueva transacción fallida
                    $sql        = "INSERT INTO fallidas (f_cod_pagos, f_correl_fall, 
                                   f_fec_fac, f_val_mensual, f_val_plan, f_buyorder, f_responsecode,
                                   t_fecha_tbk, f_payment_type_code, f_log, f_userid) VALUES
                                   ($id, $correl, STR_TO_DATE('$fec_fac','%Y-%m-%d'), $amount, $amount, NULL,
                                   NULL, STR_TO_DATE('$fecha_tbk','%Y-%m-%d %H:%i:%s'), NULL, '$log', $userid);";               
                    $query      = mysqli_query($conn, $sql);

                    //Cambiar estado a M
                    if($moroso){
                        $sql   = "UPDATE pagos_clientes SET estado = 'M' 
                                  WHERE ((pagos = $id) AND ((estado = 'S') || (estado = 'I')));";
                        $query = mysqli_query($conn, $sql);
                    }
                }
            }
        }
        echo json_encode($data);
    }
}
?>