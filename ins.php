<?php

/** BASE DE DATOS CONN, FECHA Y HORA PARA REGISTROS**/
include("admin/config/func.php");

//No tocar
use Transbank\Webpay\Oneclick\MallInscription;
use Transbank\Webpay\Oneclick\MallTransaction;


/** Configuracion parametros de la clase Webpay **/

//Mostrar errores en la pagina
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

/** Credenciales **/
include_once('admin/config/modomall.php');

$action = isset($_GET["action"]) ? $_GET["action"] : 'init';

/** Identificador del proceso de inscripción, entregado por Webpay en el método initInscription */
$token_tbk = filter_input(INPUT_POST, 'TBK_TOKEN');

/* DATOS ALMACENADOS EN BASE DE DATOS */

$conn = getConn();
$token = htmlspecialchars(mysqli_real_escape_string($conn, $token_tbk));
$sql_token = mysqli_query($conn, "SELECT p.pagos, p.rut, p.t_nombres, p.t_apellido1, p.email, p.valor_plan, p.username, p.estado, p.clase, p.c_envio FROM pagos_clientes p
    WHERE token = '$token'
    AND (CAST(fec_pag AS DATE) = Date_format(now(),'%Y%m%d') 
    OR CAST(fec_pag AS DATE) = Date_format(DATE_ADD(NOW(),INTERVAL -1 DAY),'%Y%m%d')) ");
$result_sql_token = mysqli_num_rows($sql_token);
    
if($result_sql_token == 0){
        $message = "TOKEN ERROR";
        header("location: rechazo.php?error=101");
        mysqli_close($conn);
}else{
        while ($data = mysqli_fetch_array($sql_token)) {
            $pagos         = $data['pagos'];
            $rut           = $data['rut'];
            $t_nombres     = $data['t_nombres'];
            $t_apellido1   = $data['t_apellido1'];
            /** Dirección de correo electrónico registrada por el comercio **/
            $email         = $data['email'];
            /** Monto del pago en pesos  **/
            $amount        = $data['valor_plan'];
            /** Usuario Transbank **/
            $username_tbk  = $data['username'];
            $estado_actual = $data['estado'];
            $clase         = $data['clase'];
            $c_envio       = $data['c_envio'];
        }
        mysqli_free_result($sql_token);
        mysqli_close($conn);
}

/* RECHAZO INTEGRACIÓN */
//$amount   = 1111000000;


switch ($action) {

 case "":
        $message = "SIN INSTRUCCIÓN";
        header("location: index.php");
        mysqli_close($conn);
        break;
        
 case "init":
        $message = "SIN ACTION";
        header("location: index.php");
        mysqli_close($conn);
        break;
        

 case "OneClickFinishInscription":
        
        /* Clase */
        if($clase == 'A'){
            $next_page = "aprobada.php?mod=A"; 
        }elseif($clase == 'B'){
            $next_page = "aprobada.php?mod=B";
        }elseif($clase == 'C'){
            $next_page = "aprobada.php?mod=C";
        }elseif($clase == 'D'){
            $next_page = "aprobada.php?mod=D";
        }else{
            $next_page = "";
        }
        if ($estado_actual == 'S' OR $estado_actual == 'I'){
            $message = "CLIENTE FINALIZO COMPRA";
            if($clase == 'A'){
               header("location: aprobada.php?mod=A"); 
            }elseif($clase == 'B'){
                header("location: aprobada.php?mod=B");
            }elseif($clase == 'C'){
                header("location: aprobada.php?mod=C");
            }else{
                header("location: aprobada.php?mod=D");
            }
            mysqli_close($conn);
            break;
            }
        elseif (!isset($_POST["TBK_TOKEN"])){
            $message = "TOKEN ERROR";
            header("location: rechazo.php?error=101");
            mysqli_close($conn);
            break;
            }
        elseif ($estado_actual == 'T'){
            $message = "CLIENTE CON ERROR";
            header("location: rechazo.php?error=101");
            mysqli_close($conn);
            break;
            }
        elseif ($estado_actual == 'R'){
            $message = "CLIENTE COMPLETO REGISTRO";
            header("location: rechazo.php?error=202");
            mysqli_close($conn);
            break;
        }elseif(empty($estado_actual)){
            $message = "TOKEN ERROR";
            header("location: rechazo.php?error=101");
            mysqli_close($conn);
            break;            
        }else{
        
        /** Rescatamos resultado y datos de la transaccion */
        $result = MallInscription::finish($token);;

        $responseCode = $result->responseCode;
        $tbkUser = $result->tbkUser;

        if ($responseCode != 0) {

            /*$message = "Transacci&oacute;n RECHAZADO por webpay INSCRIPCION RECHAZADA";*/
            $message = "CLIENTE CON ERROR EN INSCRIPCIÓN";
            $next_page = "rechazo.php?error=303";
            
            /** FECHA Y HORA PARA REGISTROS**/
            $fecha_tbk = getFechaYHora();
            
            /* CAMBIO A ESTADO T, INSCRIPCIÓN RECHAZADA */
            $conn = getConn();
            $sql_registro_t = mysqli_query($conn, "UPDATE pagos_clientes
            SET estado = 'T', fecha_tbk = '$fecha_tbk', responsecode = 'i".$result->responseCode."'
            WHERE token = '$token'
            AND (CAST(fec_pag AS DATE) = Date_format(now(),'%Y%m%d') 
            OR CAST(fec_pag AS DATE) = Date_format(DATE_ADD(NOW(),INTERVAL -1 DAY),'%Y%m%d'))
            AND (estado = 'E'); ");
            mysqli_close($conn);
            
            if($sql_registro_t){
                $message5 = "Correcto, Cambio de estado a T";         
            }else{
                $message5 = "FALLIDO CAMBIO DE ESTADO A T";
            }
            
        } else {
                        
            $message = "INSCRIPCION APROBADA";
			
            /** FECHA Y HORA PARA REGISTROS**/
			$fecha_buy = getFechabuy();
            $fecha_tbk = getFechaYHora();
            
            //Consulta tipo de campaña
            $conn = getConn();
            $sql_campania = mysqli_query($conn, "SELECT CA.descuento, CA.dias, PC.campania FROM pagos_clientes PC INNER JOIN campania CA on CA.cod_camp= PC.campania
            WHERE PC.token = '$token'
            AND (CAST(PC.fec_pag AS DATE) = Date_format(now(),'%Y%m%d') 
            OR CAST(PC.fec_pag AS DATE) = Date_format(DATE_ADD(NOW(),INTERVAL -1 DAY),'%Y%m%d')) ");
            $result_campania = mysqli_num_rows($sql_campania);
    
            if($result_campania == 0){
                $message = "NO PERTENECE A CAMPAÑA";
                mysqli_close($conn);
            }else{
                while ($c_data = mysqli_fetch_array($sql_campania)){
            
                    $c_descuento    = $c_data['descuento'];
                    $c_dias         = $c_data['dias'];
                    $campania       = $c_data['campania'];
                }
                mysqli_free_result($sql_campania);
                mysqli_close($conn);
            }

            
			/* CLIENTES TIPO D SOLO INSCRIPCIÓN DE PRUEBA GRATIS */
            
            if($clase == 'D' && empty($c_descuento) && !empty($c_dias) ){
            //variables
            //$payment_type_code = $result->details[0]["payment_type_code"]; NO LLEGA
            $conn = getConn();
                
            $sql_campania_gratis = mysqli_query($conn, "UPDATE pagos_clientes
            SET estado = 'I', authorizationcode = $result->authorizationCode, creditcardtype = '$result->cardType', last4carddigits = '$result->cardNumber', tbkuser = '$result->tbkUser', fecha_tbk = '$fecha_tbk', responsecode = '$result->responseCode'
            WHERE token = '$token'
            AND (CAST(fec_pag AS DATE) = Date_format(now(),'%Y%m%d') 
            OR CAST(fec_pag AS DATE) = Date_format(DATE_ADD(NOW(),INTERVAL -1 DAY),'%Y%m%d'))
            AND (estado = 'E'); ");

            mysqli_close($conn);
                
            if($sql_campania_gratis){
                $message5 = "Correcto, tipo D  prueba gratis inscrito";
                /* Datos para cliente en navegador */
                session_start();
                $_SESSION["creditcardtype"] =   $result->cardType;
                $_SESSION["last4carddigits"]=   $result->cardNumber;
                $_SESSION["t_nombres"]      =   $t_nombres;
                $_SESSION["t_apellido1"]    =   $t_apellido1;
                $next_page = "aprobada.php?mod=D";

            }else{
                $message5 = "ERROR, tipo D prueba gratis";
                $next_page = "rechazo.php?error=606";
            }
                
                
            /* CLIENTES TIPO C SOLO INSCRIPCIÓN */
            }elseif($clase == 'C'){
                /* CAMBIO A ESTADO I, REGISTRO COMPLETO REGISTRO RECHAZADO */
                
                //variables
                //$payment_type_code = $result->details[0]["payment_type_code"]; NO LLEGA
                
                $conn = getConn();
                $sql_registro_c = mysqli_query($conn, "UPDATE pagos_clientes
                SET estado = 'I', authorizationcode = '$result->authorizationCode', creditcardtype = '$result->cardType', last4carddigits = '$result->cardNumber', tbkuser = '$result->tbkUser', fecha_tbk = '$fecha_tbk', responsecode = '$result->responseCode' WHERE token = '$token'
                AND (CAST(fec_pag AS DATE) = Date_format(now(),'%Y%m%d') 
                OR CAST(fec_pag AS DATE) = Date_format(DATE_ADD(NOW(),INTERVAL -1 DAY),'%Y%m%d'))
                AND (estado = 'E'); ");

                mysqli_close($conn);
                
                if($sql_registro_c){
                    $message5 = "Correcto, tipo C inscrito";
                    /* Datos para cliente en navegador */
                    session_start();
                    $_SESSION["creditcardtype"] =   $result->cardType;
                    $_SESSION["last4carddigits"]=   $result->cardNumber;
                    $_SESSION["t_nombres"]      =   $t_nombres;
                    $_SESSION["t_apellido1"]    =   $t_apellido1;
                    $next_page = "aprobada.php?mod=C";

                }else{
                    $message5 = "ERROR, tipo C inscrito";
                    $next_page = "rechazo.php?error=606";

                }
                
            }else{
            
                /** Identificador único de la compra generado por el comercio */
                $random = rand();
                $buyOrder = $fecha_buy.$random;
                $buyorder = $buyOrder;
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
                $result2 = MallTransaction::authorize($username_tbk, $tbkUser, $buyOrder, $details);

                $responseCode2  = $result2->details[0]["response_code"];
                $comprobar = is_numeric($responseCode2);

                if ($responseCode2 != 0 || $comprobar == false) {
                    if($comprobar == false){
                        /*$message2 = "COBRO NULO";*/
                        $message = "CLIENTE CON ERROR EN LA TRANSACCIÓN, PROBLEMA EN EL COBRO";
                        $next_page = 'rechazo.php?error=505';

                    } else {  
                        /*$message2 = "COBRO RECHAZADO";*/
                        $message = "CLIENTE CON ERROR EN LA TRANSACCIÓN, COBRO RECHAZADO";
                        $next_page = 'rechazo.php?error=202';
                    }
                    
                    //variables
                    $authorizationcode = $result->details[0]["authorization_code"];
                    $payment_type_code = $result->details[0]["payment_type_code"];
                    $responsecode = $result2->details[0]["response_code"];
                    
                    /* CAMBIO A ESTADO R, REGISTRO COMPLETO REGISTRO RECHAZADO */
                    $conn = getConn();
                    $sql_registro = mysqli_query($conn, "UPDATE pagos_clientes
                    SET estado = 'R', authorizationcode = '$authorization_code', payment_type_code = '$payment_type_code', creditcardtype = '$result->cardType',
                    last4carddigits = '$result->cardNumber', tbkuser = '$result->tbkUser', buyorder = '$buyorder', fecha_tbk = '$fecha_tbk', responsecode = 'c".$responsecode."'
                    WHERE token = '$token'
                    AND (CAST(fec_pag AS DATE) = Date_format(now(),'%Y%m%d') 
                    OR CAST(fec_pag AS DATE) = Date_format(DATE_ADD(NOW(),INTERVAL -1 DAY),'%Y%m%d'))
                    AND (estado = 'E'); ");
                    
                    mysqli_close($conn);
                    
                    if($sql_registro){
                        $message5 = "Correcto, Cambio de estado a R";

                    }else{
                        $message5 = "FALLIDO CAMBIO DE ESTADO A R";

                    }

                } else {
                    $message2 = "COBRO APROBADO";

                    /* ALMACENAR DATOS DE TRANSACCIÓN EN BASE DE DATOS*/

                    $authorizationcode  = $result2->details[0]["authorization_code"];
                    $payment_type_code  = $result2->details[0]["payment_type_code"];
                    $last4carddigits    = $result2->cardNumber;
                    $tbkuser            = $result->tbkUser;
                    $creditcardtype     = $result->cardType;

                    /* CAMBIO A ESTADO S, REGISTRO COMPLETO Y TRANSACCION COMPLETADA */

                    $sql = "CALL ACT_PAGO('$fecha_tbk','$buyorder','$creditcardtype','$authorizationcode', '$payment_type_code', '$last4carddigits', '$tbkuser', 'S', '$responseCode2', '$token' );";
                    
                    $conn = getConn();
                    $query = mysqli_query($conn, $sql);
                    mysqli_close($conn);
                    if($query){

                        require_once("admin/config/class.phpmailer.php");
                        require_once("admin/config/class.smtp.php");
                        include_once("admin/config/enviar_correo.php");

                        $message3 = "Transacci&oacute;n Registrada en base de datos";
                        
                        /* CARGA DE BASE DE DATOS */
                        
                        $conn = getConn();
                        $sql_correos = mysqli_query($conn, "SELECT * FROM pagos_clientes
                            WHERE pagos = '$pagos'
                            AND (CAST(fec_pag AS DATE) = Date_format(now(),'%Y%m%d') 
                            OR CAST(fec_pag AS DATE) = Date_format(DATE_ADD(NOW(),INTERVAL -1 DAY),'%Y%m%d'))
                            AND (estado = 'S')  ");
                        $result_sql_correos = mysqli_num_rows($sql_correos);

                            if($result_sql_correos == 0){
                                $message7 = "Ocurrió un error BASE DE DATOS PARA CORREO.";
                                mysqli_close($conn);
                                
                            }else{
                                while ($data2 = mysqli_fetch_array($sql_correos)) {

                                    $t_nombres          = $data2['t_nombres'];
                                    $t_apellido1        = $data2['t_apellido1'];
                                    $creditcardtype     = $data2['creditcardtype'];
                                    $last4carddigits    = $data2['last4carddigits'];
                                    }
                                    mysqli_free_result($sql_correos);
                                    mysqli_close($conn);    
                                
                                    /* Datos para cliente en navegador */
                                    session_start();
                                    $_SESSION["creditcardtype"]  =   $creditcardtype;
                                    $_SESSION["amount"]          =   number_format((int)$amount,0,'','.');
                                    $_SESSION["last4carddigits"] =   $last4carddigits;
                                    $_SESSION["fecha_tbk"]       =   $fecha_tbk;
                                    $_SESSION["t_nombres"]       =   $t_nombres;
                                    $_SESSION["t_apellido1"]     =   $t_apellido1;
                                }
                        /* ENVIO DE CORREO CLIENTE */
                        if($clase == 'A'){

                            /* FUNCION ENVIAR CORREO CLIENTE
                            ORDEN: t_nombres,t_apellido1,email,last4carddigits */

                            $estadoenvio_c = enviarcorreo_cliente($t_nombres,$t_apellido1,$email,$creditcardtype,$last4carddigits);
                            if($estadoenvio_c){
                                $message4 = "El correo fue enviado correctamente";
                                $next_page = 'aprobada.php?mod=A';
                            } else {
                                $message4 = "Ocurrió un error ENVIANDO CORREO CLIENTE"; 
                                $next_page = 'aprobada.php?mod=A';
                            }   
                        }else{
                        $message4 = "CORREO NO ENVIADO";
                        }
                    }else{
                        $message3 = "Transacci&oacute;n NO SE REGISTRO en base de datos";
                    }
                $message = "REGISTRO Y TRANSACCIÓN EXITOSA";
                }
            }   
        }
        /* ESTADO DE ENVIO DE CORREO */
        if($c_envio == 'NO'){
            /* ENVIO DE CORREOS */
            require_once("admin/config/class.phpmailer.php");
            require_once("admin/config/class.smtp.php");
            include_once("admin/config/enviar_correo.php");

            /* CARGA DE BASE DE DATOS */

            if(!empty($pagos)){
                
                $conn = getConn();
                $sql_correos_int = mysqli_query($conn, "SELECT * FROM pagos_clientes
                WHERE pagos = '$pagos'
                AND (CAST(fec_pag AS DATE) = Date_format(now(),'%Y%m%d') 
                OR CAST(fec_pag AS DATE) = Date_format(DATE_ADD(NOW(),INTERVAL -1 DAY),'%Y%m%d'))
                AND ((estado = 'T') OR (estado = 'R') OR (estado = 'S') OR (estado = 'I')) ");
                $result_sql_correos_int = mysqli_num_rows($sql_correos_int);

                if($result_sql_correos_int == 0){
                    $message7 = "Ocurrió un error BASE DE DATOS PARA CORREO.";
                    mysqli_close($conn);
                }else{
                    while ($data3 = mysqli_fetch_array($sql_correos_int)) {
                        
                        $conn = getConn();
                        $campania = $data3['campania'];
                        $query_camp = mysqli_query($conn, "SELECT nombre FROM campania WHERE cod_camp = $campania ");    
                        $result_camp = mysqli_num_rows($query_camp);
                        $camp = mysqli_fetch_array($query_camp);
                        
                        $fec_pag            = $data3['fec_pag'];
                        $t_nombres          = $data3['t_nombres'];
                        $t_apellido1        = $data3['t_apellido1'];
                        $t_apellido2        = $data3['t_apellido2'];
                        $rut                = $data3['rut'];
                        $t_fec_nac          = $data3['t_fec_nac'];
                        $telefono           = $data3['telefono'];
                        $telefono2          = $data3['telefono2'];
                        $direccion          = $data3['direccion'];
                        $comuna             = $data3['comuna'];
                        $cod_plan           = $data3['cod_plan'];
                        $nom_plan           = $data3['nom_plan'];
                        $num_benef          = $data3['num_benef'];
                        $valor_plan_benef   = $data3['valor_plan_benef'];
                        $cod_pago           = $data3['cod_pago'];
                        $tipo_pago          = $data3['tipo_pago'];
                        $descuento          = $data3['cant_descuento'];
                        $valor_plan         = $data3['valor_plan'];
                        $token              = $data3['token'];
                        $buyorder           = $data3['buyorder'];
                        $username           = $data3['username'];
                        $authorizationcode  = $data3['authorizationcode'];
                        $creditcardtype     = $data3['creditcardtype'];
                        $payment_type_code  = $data3['payment_type_code'];
                        $last4carddigits    = $data3['last4carddigits'];
                        $tbkuser            = $data3['tbkuser'];
                        $fecha_tbk          = $data3['fecha_tbk'];
                        $fec_fac            = $data3['fec_fac'];
                        $clase              = $data3['clase'];
                        $observa            = $data3['observa'];
                        $estado             = $data3['estado'];
                        $responsecode       = $data3['responsecode'];
                        $campania           = $data3['campania'];
                        $camp_nombre        = $camp['nombre'];
                    }
                    mysqli_free_result($sql_correos_int);
                    mysqli_close($conn);
                }


                 /** Mail Interno **/

                 $fila = 1;
                 $sql_direccion_correos = "CALL TRAER_MAIL($fila);";
                 $conn = getConn();
                 $query_direccion_correos = mysqli_query($conn, $sql_direccion_correos);

                 $result_direccion_correos = mysqli_num_rows($query_direccion_correos);
                
                 mysqli_close($conn);
                
                if($result_direccion_correos == 0){
                    $message8 = "TRAER EMAIL NO FUNCIONO";

                }else{
                    $message8 = "TRAER EMAIL FUNCIONA CORRECTO"; 
                    while ($data3 = mysqli_fetch_array($query_direccion_correos)) {

                       $destinatario   = $data3['Pdes1'];
                       $destinatario2  = $data3['Pdes2'];
                       $cc             = $data3['Pcop1'];
                       $cc2            = $data3['Pcop2'];

                    }
                    mysqli_free_result($query_direccion_correos);
                    
                    /* FUNCION ENVIAR CORREO INTERNO
                    ORDEN: destinatario,destinatario2,cc,cc2,pagos,fec_pag,t_nombres,
                    t_apellido1,t_apellido2,rut,t_fec_nac,email,telefono,telefono2, direccion,comuna,cod_plan,estado,nom_plan,num_benef,valor_plan_benef, cod_pago,tipo_pago,cant_descuento,valor_plan,token,buyorder,username,authorizationcode,creditcardtype,payment_type_code,last4carddigits,tbkuser,fecha_tbk,clase, campaña,nombre*/

                    $estadoenvio_i = enviarcorreo_interno($destinatario,$destinatario2,$cc,$cc2,$pagos,$fec_pag,$t_nombres,$t_apellido1,$t_apellido2,$rut,$t_fec_nac,$email,$telefono,$telefono2,$direccion,$comuna,$cod_plan,$estado,$nom_plan,$num_benef,$valor_plan_benef,$cod_pago,$tipo_pago,$descuento,$valor_plan,$token,$buyorder,$authorizationcode,$creditcardtype,$last4carddigits,$tbkuser,$username,$fecha_tbk,$payment_type_code,$fec_fac,$clase,$observa,$responsecode,$campania,$camp_nombre);
                    
                    if($estadoenvio_i){
                        
                        $message6 = "El correo fue enviado INTERNO correctamente";
                        
                        //CAMBIO DE C_ENVIO A SI
                        $conn = getConn();
                        $sql_correos_int_c_envio = mysqli_query($conn, "UPDATE pagos_clientes
                        SET c_envio = 'SI'
                        WHERE pagos = '$pagos'
                        AND (CAST(fec_pag AS DATE) = Date_format(now(),'%Y%m%d') 
                        OR CAST(fec_pag AS DATE) = Date_format(DATE_ADD(NOW(),INTERVAL -1 DAY),'%Y%m%d'))
                        AND ((estado = 'T') OR (estado = 'R') OR (estado = 'S') OR (estado = 'I'));");
                        mysqli_close($conn);
                        if($sql_correos_int_c_envio){
                            $message7 = "Actualizado estado Correo a SI";
                            }else{
                            $message7 = ("Error description: " . mysqli_error($conn));
                            }
                    } else {
                        $message6 = "Ocurrió un error ENVIANDO CORREO INTERNO"; 
                    }
                 }
            }else{
                $c_me = 'pagos vacio';
                header("location: rechazo.php?error=101");
                mysqli_close($conn);
                break;
            }
        }
        //header("location: ".$next_page);
        echo "<script>window.location.href='$next_page';</script>";
        //mysqli_close($conn);
        break;
    }

}
?>

<!doctype html>

<html>
	<head>
	<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-P7VCFXL');</script>
<!-- End Google Tag Manager -->

		<title>REST911 - Procesando</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="initial-scale=1.0">
        <link rel="stylesheet" href="css/ins.css">
	</head>

	<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P7VCFXL"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

        <div class="center" id="center">
            <div id="contenedor">
                <!-- Debug
                <p style="color: #fff;">INSCRIPCIÓN <?php echo $message ?> <?php echo $result->responseCode ?></p>
                <p style="color: #fff;">TRANSACCIÓN <?php echo $message2 ?> <?php echo $responseCode2 ?></p>
                <p style="color: #fff;">BASE DE DATOS <?php echo $message3 ?><br><?php echo $message5 ?></p> 
                <p style="color: #fff;">CORREO CLIENTES <?php echo $message4 ?></p>
                <p style="color: #fff;">CORREO INTERNO <?php echo $message7 ?><br>
                    <?php echo $message8 ?> <?php echo $message6 ?><br><?php echo $destinatario2 ?> <?php echo $cc2 ?> </p>
                <p style="color: #fff;">NEXT PAGE <?php echo $next_page ?><br></p>-->
                <!-- WEB-->
                <img src="img/logob.png" style="max-width: 320px;
                max-height: 114px;">
                <div class="loader" id="loader">Espere...</div>
            </div>
        </div>
	</body>
</html>