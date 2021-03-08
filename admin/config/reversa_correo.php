<?php

/* FUNCION ENVIAR CORREO REVERSA ORDEN: codigo transac,codigo fallida o reversa,estado R reversa F falllido,conexion, fecha hoy, valor reversado, usuario que hace el proceso, observación */
function enviarcorreo_interno_reversa($id,$cod_fr,$estado,$conn,$fecha_tbk,$r_val_plan,$usuario,$r_observa){
    
    /* Estado */
    if($estado == 'R'){
        $titu = 'REVERSA';
        $cod_ti = 'REVERSA';
    }elseif($estado == 'F'){
        $titu = 'REVERSA FALLIDA';
        $cod_ti = 'FALLIDA';
    }
    
/** Mail Interno **/

    /*$fila = 2;
    $sql_direccion_correos = "CALL TRAER_MAIL($fila);";
    $query_direccion_correos = mysqli_query($conn, $sql_direccion_correos);

    $result_direccion_correos = mysqli_num_rows($query_direccion_correos);

    if($result_direccion_correos == 0){

    }else{
        while ($data3 = mysqli_fetch_array($query_direccion_correos)) {

           $destinatario   = $data3['Pdes1'];
           $destinatario2  = $data3['Pdes2'];
           $cc             = $data3['Pcop1'];
           $cc2            = $data3['Pcop2'];

        }
    mysqli_free_result($query_direccion_correos);
    }*/

    $sql = "SELECT PT.t_cod_pagos, PT.t_correl_pago, PT.t_buyorder, PT.t_fec_fac, PT.t_payment_type_code, PT.t_val_plan, PC.rut, PC.clase, CR.Desti1, CR.Desti2, CR.Copia1, CR.Copia2 
    FROM pagos_transac PT, pagos_clientes PC, correos_rest CR
    WHERE (PT.t_cod_tran = $id AND PC.pagos = PT.t_cod_pagos AND CR.Tipo = 2);";

    $query = mysqli_query($conn, $sql);
    $result = mysqli_num_rows($query);

    while ($resp_query = mysqli_fetch_array($query)) {
        
    $cod_pagos      = $resp_query["t_cod_pagos"];
    $correl         = $resp_query["t_correl_pago"];
    $buyorder       = $resp_query["t_buyorder"];
    $fec_fac        = $resp_query["t_fec_fac"];
    $type_code      = $resp_query["t_payment_type_code"];
    $amount         = $resp_query["t_val_plan"];
    $rut            = $resp_query["rut"];
    $clase          = $resp_query["clase"];
    $destinatario   = $resp_query['Desti1'];
    $destinatario2  = $resp_query['Desti2'];
    $cc             = $resp_query['Copia1'];
    $cc2            = $resp_query['Copia2'];
    }
    //mysqli_free_result($resp_query);
    
    /* Tipo de Cliente */
    if($clase == 'A'){
        $tipo_clase = '(A) Autocontratados';
    }elseif($clase == 'B'){
        $tipo_clase = '(B) Inscripción y Cobro';
    }elseif($clase == 'C'){
        $tipo_clase = '(C) Solo Inscripción'; 
    }else{
        $tipo_clase = '';
    }
    
    //FORMATO FECHA TBK
    $newDate_tbk = date("d-m-Y H:i:s", strtotime($fecha_tbk));
        
    $mensaje = "CODIGO REVERSA/FALLIDA: {$cod_fr}, CODIGO TRANSACCION: {$id}, CODIGO CLIENTE: {$cod_pagos}, CLASE: {$clase}, RUT: {$rut}, FECHA FACTURACION: {$fec_fac}, FECHA REVERSA: {$newDate_tbk},VALOR PLAN: {$amount}, MONTO REVERSADO: {$r_val_plan}, ORDEN DE COMPRA: {$buyorder}, TIPO PAGO: {$type_code}, USUARIO: {$usuario}, OBSERVACION: {$r_observa}";
    
    $fechahoy = date("Y-m-d");
    $asunto = "Se ha realizado una ".$titu." en Pagina Web el ".$newDate_tbk." Cliente Rut ".$rut. " Tipo de cliente ".$clase." ." ;

    // Datos de la cuenta de correo utilizada para enviar vía SMTP
    $smtpHost = "pyme91.pymedns.net";  // Dominio alternativo brindado en el email de alta 
    $smtpUsuario = "autocontrato@rest911.cl";  // Mi cuenta de correo
    $smtpClave = "%&auto&%web2020";  // Mi contraseña
    $correo = ('autocontrato@rest911.cl'); // Email desde donde se envia el correo
    $nombre = "REST911 PANEL ADMINISTRACIÓN";


    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->Port = 465; 
    $mail->IsHTML(true); 
    $mail->CharSet = "utf-8";
    $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail

    // VALORES A MODIFICAR //
    $mail->Host = $smtpHost; 
    $mail->Username = $smtpUsuario; 
    $mail->Password = $smtpClave;
    
    //DEBUG
    //$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
    //$mail->SMTPDebug = 2;
    //$mail->Debugoutput = 'html';

    $mail->From = ($correo); // Email desde donde envío el correo.
    $mail->FromName = $nombre;
    $mail->AddAddress($destinatario); // Esta es la dirección a donde enviamos los datos del formulario
    $mail->AddAddress($destinatario2);
    $mail->addCC($cc); // Dirección de copia
    $mail->addCC($cc2); // Dirección de copia 2


    $mail->Subject = $asunto; // Este es el titulo del email.
    $mensajeHtml = nl2br($mensaje);
    $mail->Body = "
    <html> 

    <body> 
    <TABLE BORDER=1;>
    <TR>
       <TD>CODIGO {$cod_ti}:</TD>
       <TD>{$cod_fr}</TD>
    </TR>
    <TR>
       <TD>CODIGO TRANSACCION:</TD>
       <TD>{$id}</TD>
    </TR>
    <TR>
       <TD>CODIGO CLIENTE:</TD>
       <TD>{$cod_pagos}</TD>
    </TR>
    <TR>
       <TD>CLASE:</TD>
       <TD>{$clase}</TD>
    </TR>
    <TR>
       <TD>RUT:</TD>
       <TD>{$rut}</TD>
    </TR>
    <TR>
       <TD>FECHA FACTURACION:</TD>
       <TD>{$fec_fac}</TD>
    </TR>
    <TR>
       <TD>FECHA REVERSA:</TD>
       <TD>{$newDate_tbk}</TD>
    </TR>
    <TR>
       <TD>VALOR DEL PLAN:</TD>
       <TD>{$amount}</TD>
    </TR>
    <TR>
       <TD>MONTO REVERSADO:</TD>
       <TD>{$r_val_plan}</TD>
    </TR>
    <TR>
       <TD>ORDEN DE COMPRA:</TD>
       <TD>{$buyorder}</TD>
    </TR>
    <TR>
       <TD>TIPO PAGO:</TD>
       <TD>{$type_code}</TD>
    </TR>
    <TR>
       <TD>USUARIO:</TD>
       <TD>{$usuario}</TD>
    </TR>
    <TR>
       <TD>OBSERVACION:</TD>
       <TD>{$r_observa}</TD>
    </TR>

    </TABLE>

    </body> 

    </html>

    <br />"; // Texto del email en formato HTML
    $mail->AltBody = "{$mensaje} \n\n "; // Texto sin formato HTML
    // FIN - VALORES A MODIFICAR //

    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );

    return($mail->Send());
    //return($cod_pagos);
}

?>