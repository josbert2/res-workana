<?php
include_once('config/conn.php');
include('config/modo1.php');
include_once "config/permisos.php";

//include("config/func.php");
require_once("config/class.phpmailer.php");
require_once("config/class.smtp.php");
include_once("config/reversa_correo.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
$rol 			 = $_SESSION['rol'];
$currentPage = "consulta_re";
$acceso 		 = getPermisos($currentPage, $rol);
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

if(isset($_POST['function'])){
    if($_POST['function'] == 'getResumen' && !empty($_POST['id'])){
        $id         = $_POST['id'];
        $conn       = getConn();
        $datos      = array();
        
        $sql        = "SELECT t_cod_pagos FROM pagos_transac WHERE t_cod_tran = $id;";
        $query      = mysqli_query($conn, $sql);
        $resp_query = mysqli_fetch_array($query);
        $pagos      = $resp_query["t_cod_pagos"];
        
        $sql        = "SELECT pagos_clientes.rut, DATE_FORMAT(pagos_transac.t_fec_fac, '%d-%m-%Y'),  DATE_FORMAT(pagos_transac.t_fecha_tbk, '%d-%m-%Y'), pagos_transac.t_payment_type_code, pagos_transac.t_val_plan
		FROM pagos_clientes INNER JOIN pagos_transac
		WHERE (t_cod_tran = $id AND pagos = $pagos);";
        $query      = mysqli_query($conn, $sql);
        
        while($row = mysqli_fetch_array($query)){
            $datos[] = $row; 
        }
        echo json_encode($datos);
    }
    
    elseif($_POST['function'] == 'reversar' && !empty($_POST['id']) && !empty($_POST['auth']) && !empty($_POST['monto'])){

    	// DATOS DEL POST
    	$id      = $_POST['id'];
    	$auth    = $_POST['auth'];
    	$userid  = $_POST['userid'];
		$usuario = $_POST['usuario'];
    	$dscto   = $_POST['monto'];
    	$observa = $_POST['obs'];

    	// BUSCAR CLAVE DE AUTORIZACION
    	$conn       = getConn();
    	$sql        = "SELECT pass FROM user WHERE userid = 0;";
    	$query      = mysqli_query($conn, $sql);
    	$resp_query = mysqli_fetch_array($query);
    	$pass       = $resp_query["pass"];
		       
    	// CLAVE DE AUTORIZACION CORRECTA
    	if(md5($auth) == $pass){
        
        	//DATOS DE LA TRANSACCION A REVERSAR Y CORREOS
        	$sql        = "SELECT pagos_transac.t_cod_pagos, pagos_transac.t_correl_pago, pagos_transac.t_buyorder,
                       	   pagos_transac.t_fec_fac, pagos_transac.t_payment_type_code, pagos_transac.t_val_plan,
                           pagos_clientes.rut, pagos_clientes.clase 
                           FROM pagos_transac, pagos_clientes 
                           WHERE (pagos_transac.t_cod_tran = $id AND pagos_clientes.pagos = pagos_transac.t_cod_pagos);";
        	$query      = mysqli_query($conn, $sql);
        	$resp_query = mysqli_fetch_array($query);
            
        	$cod_pagos = $resp_query["t_cod_pagos"];
        	$correl    = $resp_query["t_correl_pago"];
       		$buyorder  = $resp_query["t_buyorder"];
        	$fec_fac   = $resp_query["t_fec_fac"];
        	$type_code = $resp_query["t_payment_type_code"];
        	$amount    = $resp_query["t_val_plan"];
        	$rut       = $resp_query["rut"];
        	$clase     = $resp_query["clase"];
        	$fecha_tbk = getFechaYHora();
       
        	// INTENTAR REVERSA
        	try{
            
            	// REVERSA
            	$response = MallTransaction::refund($buyorder, $childcommerceCode, $buyorder, $dscto);
            
            	// DATOS POST REVERSA
            	$auth_code = $response->authorizationCode;
            	$type      = $response->type;

            	// REVERSA EXITOSA
            	if(($type == "REVERSED") || ($type == "NULLIFIED")){   
                
                	// REGISTRAR REVERSA EN BD Y CAMBIAR ESTADO DE LA TRANSACCION ORIGINAL
                	$sql   = "INSERT INTO reversas (r_cod_tran, r_cod_pagos, r_fec_fac, r_val_mensual, r_val_plan, r_buyorder, 
                    	      r_payment_type_code, r_authorizationcode, r_fecha_tbk, r_observa, r_respcode, r_userid) 
                    	      VALUES ($id, $cod_pagos, STR_TO_DATE('$fec_fac','%Y-%m-%d'), $amount, $dscto, '$buyorder',
                    	      '$type_code', $auth_code, STR_TO_DATE('$fecha_tbk', '%Y-%m-%d %H:%i:%s'), '$observa', '$type', $userid);";
                	$query = mysqli_query($conn, $sql);
                
                	// SI SE HICIERON LOS CAMBIOS EN LA BD
                	if($query){
                    
                	    // ID DE LA REVERSA
                	    $r_cod_rev = mysqli_insert_id($conn);
								
								 
						// CAMBIAR ESTADO
						$sql = "UPDATE fallidas SET f_estado = 'RN' WHERE f_buyorder = $buyorder;";
						$query = mysqli_query($conn, $sql);

						$sql = "UPDATE pagos_transac SET t_estado = 'R' WHERE t_buyorder = $buyorder;";
						$query = mysqli_query($conn, $sql);
                    
                	    // ENVIAR CORREO
                	    $enviarcorreo_reversa = enviarcorreo_interno_reversa($id, $r_cod_rev, 'R', $conn, $fecha_tbk, $dscto, $usuario, $observa);
                    
                	    // SI SE ENVI� EL CORREO
                	    if($enviarcorreo_reversa){
                	        echo "Reversa Exitosa. Correos enviados. Registrado en BD";
                	    }
                	    
                	    // SI NO SE ENVI� EL CORREO
                	    else{
                	        echo "Reversa Exitosa. Error al enviar correos. Registrado en BD";
                	    }
                	}
                
                	// SI NO SE HICIERON LOS CAMBIOS EN LA BD
                	else{
                	    echo "Reversa Exitosa. Error al enviar correos. Error al registrar en BD";
                	}
            	}
            
            	// REVERSA FALLIDA
            	else{
                
                	// REGISTRAR REVERSA FALLIDA
                	$sql   = "INSERT INTO fallidas(f_cod_pagos, f_correl_fall, f_fec_fac, f_val_mensual, f_can_desc, f_val_plan, 
                	          f_estado, f_buyorder, f_responsecode, t_fecha_tbk, f_payment_type_code, f_log, f_userid) 
                	          VALUES ($cod_pagos, $correl, STR_TO_DATE('$fec_fac','%Y-%m-%d'), $amount, 0, $dscto, 'R', '$buyorder',
                	          -1, STR_TO_DATE('$fecha_tbk', '%Y-%m-%d %H:%i:%s'), '$type_code', '$observa', $userid);";
                	$query = mysqli_query($conn, $sql);
                
                	// SI SE REGISTR� EN BD
                	if($query){
                    
                	    // ID DE REGISTRO
                	    $f_cod_fall = mysqli_insert_id($conn);
                	    
                	    // ENVIAR CORREO
                	    $enviarcorreo_reversa = enviarcorreo_interno_reversa($id, $f_cod_fall, 'F', $conn, $fecha_tbk, $dscto, $usuario, $observa);
                    
                	    // SI SE ENVI� EL CORREO
                	    if($enviarcorreo_reversa){
                	        echo "Reversa Fallida. Correos enviados. Registrado en BD";
                	    }
                    
               	    	// SINO SE ENVI� EL CORREO
                    	else{
                    	    echo "Reversa Fallida. Error al enviar correos. Registrado en BD";
                    	}
                	}
                
                	// SI NO SE REGISTR� EN BD
                	else{
                	    echo "Reversa Fallida. Error al enviar correos. Error al registrar en BD";
                	}
            	 }
        	}
        
        	// FALL� EL INTENTO DE REVERSA
        	catch(Exception $e){
                
        	    // REGISTRAR REVERSA FALLIDA
        	    $sql   = "INSERT INTO fallidas(f_cod_pagos, f_correl_fall, f_fec_fac, f_val_mensual, f_can_desc, f_val_plan, 
        	              f_estado, f_buyorder, f_responsecode, t_fecha_tbk, f_payment_type_code, f_log, f_userid) 
        	              VALUES ($cod_pagos, $correl, STR_TO_DATE('$fec_fac','%Y-%m-%d'), $amount, 0, $dscto, 'R', '$buyorder',
        	              -2, STR_TO_DATE('$fecha_tbk', '%Y-%m-%d %H:%i:%s'), '$type_code', '$observa', $userid);";
        	    $query = mysqli_query($conn, $sql);
                
        	    // SI SE REGISTR� EN BD
        	    if($query){
                    
        	        // ID DE REGISTRO
        	        $f_cod_fall = mysqli_insert_id($conn);
                
        	        // ENVIAR CORREO
        	        $enviarcorreo_reversa = enviarcorreo_interno_reversa($id, $f_cod_fall, 'F', $conn, $fecha_tbk, $dscto, $usuario, $observa);
        	            
        	        // SI SE ENVI� EL CORREO
        	        if($enviarcorreo_reversa){
        	            echo "Reversa Fallida por Transbank. Correos enviados. Registrado en BD";
        	        }
        	            
        	        // SINO SE ENVI� EL CORREO
        	        else{
        	            echo "Reversa Fallida por Transbank. Error al enviar correos. Registrado en BD";
        	        }
        	    }
        	        
        	    // SI NO SE REGISTR� EN BD
        	    else{
        	        echo "Reversa Fallida por Transbank. Error al enviar correos. Error al registrar en BD";
                  //echo("Error description: ".mysqli_error($conn));
        	    }
        	}
    	}
    
    	// CLAVE DE AUTORIZACION ERRONEA 
    	else{
    	    echo "Error. Clave de autorizaci�n erronea.";
    	}
	}
}
?>