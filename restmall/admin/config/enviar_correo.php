<?php

/* FUNCION ENVIAR CORREO CLIENTE
    ORDEN: t_nombres,t_apellido1,email,creditcardtype,last4carddigits */

function enviarcorreo_cliente($t_nombres,$t_apellido1,$email,$creditcardtype,$last4carddigits){
        
    $mensaje = " ".$t_nombres." ".$t_apellido1.": ¡Bienvenido a REST911 servicio MEDICO EN ATENCION DOMICILIARIA! REST911 es la empresa líder en la ZONA NORTE DEL PAIS y esperamos que su experiencia de contratación en línea haya cumplido con sus expectativas, al igual que miles de familias han confiado en nosotros, es nuestro desafío atender sus requerimientos en atención oportuna que usted y su familia necesitan.
    Sus servicios quedaran activados dentro de las próximas 24 HORAS Hábiles, adjuntamos Instructivo de uso del servicio.
    Si tiene una emergencia debe llamarnos al 442 469 911 desde cualquier teléfono fijo o móvil o si lo prefiera al número 225738555. Nuestros profesionales de servicio están las 24 horas del día todo los días del año, listos para para ayudar de manera oportuna.
    Si tiene cualquier duda o consulta con las características de su plan, puede escribirnos a sac@rest911.cl 
    Su pago inicial se aplicó conforme al Tipo de Plan seleccionado y en adelante sus pagos (mensual-trimestral-semestral ó anual) se aplicarán en modalidad automática para su comodidad y tranquilidad con cargo a su tarjeta ".$creditcardtype." número XXXX XXXX XXXX ".$last4carddigits." . 
    REST911 más de 10 años protegiendo a las familias y al cuidado de los trabajadores.
    Por cualquier duda o consulta, no dude en contactarnos.
    Saludos";

    $destinatario = $email;

    $asunto = "REST911 Bienvenida y Confirmación de Pago - Activación en 24 Horas Hábiles";

    // Datos de la cuenta de correo utilizada para enviar vía SMTP
    $smtpHost = "pyme91.pymedns.net";  // Dominio alternativo brindado en el email de alta 
    $smtpUsuario = "autocontrato@rest911.cl";  // Mi cuenta de correo
    $smtpClave = "%&auto&%web2020";  // Mi contraseña
    $correo = ('autocontrato@rest911.cl'); // Email desde donde se envia el correo
    $nombre = "REST911";
    
    
    


    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true; // authentication enabled
    $mail->Port = 465; 
    $mail->IsHTML(true); 
    $mail->CharSet = "utf-8";
    $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
    
    //adicional
    //$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
    //$mail->SMTPDebug = 2;
    //$mail->Debugoutput = 'html';
    
    
    // VALORES A MODIFICAR //
    $mail->Host = $smtpHost; 
    $mail->Username = $smtpUsuario; 
    $mail->Password = $smtpClave;


    $mail->From = ($correo); // Email desde donde envío el correo.
    $mail->FromName = $nombre;
    $mail->AddAddress($destinatario); // Esta es la dirección a donde enviamos los datos del formulario
    //ADJUNTO
    $url = 'https://planes.rest911.cl/docu/Rest911%20Instructivo%20Usuario%20Activacion%20Servicio.pdf';
    $fichero = file_get_contents($url);
    $mail->addStringAttachment($fichero, 'Rest911 Instructivo Usuario Activacion Servicio.pdf');
	
    $mail->Subject = $asunto; // Este es el titulo del email.
    $mensajeHtml = nl2br($mensaje);
    
    $mail->Body = "
    <html> 
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
    <body> 
    <img src='https://planes.rest911.cl/img/c_header.jpg'>
    <div style='color:black !important; max-width: 800px;'>
    <p style='color:black !important;'>{$t_nombres} {$t_apellido1} :<br></p>
    
    <span style='color:black !important;'> ¡Bienvenido a REST911 servicio MEDICO EN ATENCION DOMICILIARIA! REST911 es la empresa líder en la ZONA NORTE DEL PAIS y esperamos que su experiencia de contratación en línea haya cumplido con sus expectativas, al igual que miles de familias han confiado en nosotros, es nuestro desafío atender sus requerimientos en atención oportuna que usted y su familia necesitan.<br><br>
    
    Sus servicios quedaran activados dentro de las <b>próximas 24 HORAS Hábiles</b>, adjuntamos Instructivo de uso del servicio. <br><br>
    
    Si tiene una emergencia debe llamarnos al <b>442 469 911</b> desde cualquier teléfono fijo o móvil o si lo prefiera al número <b>225738555</b>. Nuestros profesionales de servicio están las 24 horas del día todo los días del año, listos para para ayudar de manera oportuna.<br></span>
    
    <p><span style='color:black !important;'>Si tiene cualquier duda o consulta con las características de su plan, puede escribirnos a <a href='mailto:sac@rest911.cl'> sac@rest911.cl</a></span></p>
    
    <span style='color:black !important;'>Su pago inicial se aplicó conforme al Tipo de Plan seleccionado y en adelante sus pagos (mensual-trimestral-semestral ó anual) se aplicarán en modalidad automática para su comodidad y tranquilidad con cargo a su tarjeta {$creditcardtype} número XXXX XXXX XXXX {$last4carddigits} . <br><br></span>
    
    <span style='color:black !important;'><b>REST911</b> más de 10 años <b>protegiendo a las familias</b> y al <b>cuidado de los trabajadores.</b> <br><br></span>
    
    <span style='color:black !important;'>Por cualquier duda o consulta, no dude en contactarnos.<br><br></span>
    
    <span style='color:black !important;'>Saludos<br></span>
    <img src='https://rest911.cl/static/logo-3cec0a38c5f2697a65884f76e6b7f978.png' alt='REST911' ALIGN='right' />
    </div>
	<img src='https://planes.rest911.cl/img/c_footer.jpg'>
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
}

/* FUNCION ENVIAR CORREO INTERNO
    ORDEN: destinatario,destinatario2,cc,cc2,pagos,fec_pag,t_nombres,t_apellido1,t_apellido2,rut,t_fec_nac,email,telefono,telefono2,direccion,comuna,cod_plan,nom_plan,num_benef,valor_plan_benef,cod_pago,tipo_pago,cant_descuento,valor_plan,token,buyorder,username,authorizationcode,creditcardtype,payment_type_code,last4carddigits,tbkuser,fecha_tbk,estado,clase,responsecode */
function enviarcorreo_interno($destinatario,$destinatario2,$cc,$cc2,$pagos,$fec_pag,$t_nombres,$t_apellido1,$t_apellido2,$rut,$t_fec_nac,$email,$telefono,$telefono2,$direccion,$comuna,$cod_plan,$estado,$nom_plan,$num_benef,$valor_plan_benef,$cod_pago,$tipo_pago,$cant_descuento,$valor_plan,$token,$buyorder,$authorizationcode,$creditcardtype,$last4carddigits,$tbkuser,$username,$fecha_tbk,$payment_type_code,$fec_fac,$clase,$observa,$responsecode,$campania,$camp_nombre){
    
    /* Estado del Cliente */
    if($estado == 'S'){
        $titulo = 'Transacción Exitosa';
    }elseif($estado == 'R'){
        $titulo = 'Rechaza Cobro';
    }elseif($estado == 'T'){
        $titulo = 'Rechazo TBK';
    }elseif($estado == 'I'){
        $titulo = 'Nueva Suscripción';    
    }else{
        $titulo = '';
    }
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
    /* Tipo de Error Clientes antiguos*/
    if($responsecode == '0'){
        $obs_error = ''; 
    }elseif($responsecode == '-97'){
        $obs_error = '-97 máximo monto diario de pago excedido';
    }elseif($responsecode == '-98'){
        $obs_error = '-98 máximo monto de pago excedido';
    }elseif($responsecode == '-99'){
        $obs_error = '-99 máxima cantidad de pagos diarios excedido'; 
    }elseif(substr($responsecode,0, 1) != 'i' && substr($responsecode,0, 1) != 'c'){
        if($responsecode < 0 && $responsecode > -9){
        $obs_error = 'Rechazo TBK'; 
        }
    }
    /* Tipo de Error COBRO  */
    elseif($responsecode == 'c-97'){
        $obs_error = '-97 máximo monto diario de pago excedido';
    }elseif($responsecode == 'c-98'){
        $obs_error = '-98 máximo monto de pago excedido';
    }elseif($responsecode == 'c-99'){
        $obs_error = '-99 máxima cantidad de pagos diarios excedido'; 
    }elseif(substr($responsecode,0, 1) == 'c'){
        if(substr($responsecode,1) < 0 && substr($responsecode,1) > -9){
        $obs_error = 'Rechazo TBK'; 
        } 
    }
    /* Tipo de Error INSCRIPCION */
    elseif($responsecode == 'i-1'){
        $obs_error = '-1 máximo monto diario de pago excedido';
    }elseif($responsecode == 'i-2'){
        $obs_error = '-2 máximo monto de pago excedido';
    }elseif($responsecode == 'i-3'){
        $obs_error = '-3 máxima cantidad de pagos diarios excedido'; 
    }elseif($responsecode == 'i-4'){
        $obs_error = '-4 máxima cantidad de pagos diarios excedido'; 
    }elseif($responsecode == 'i-5'){
        $obs_error = '-5 Rechazo - Posible Fraude (Transacción con riesgo de posible fraude)'; 
    }else{
        $obs_error = 'No especifica';
    }
    
    //FORMATO FECHA TBK
    $newDate_tbk = date("d-m-Y H:i:s", strtotime($fecha_tbk));
        
    $mensaje = "CODIGO: {$pagos}, FECHA REGISTRO: {$fec_pag}, NOMBRE TITULAR: {$t_nombres} {$t_apellido1} {$t_apellido2}, RUT: {$rut}, FECHA NAC: {$t_fec_nac}, EMAIL: {$email}, TELEFONO: {$telefono}, TELEFONO 2: {$telefono2}, DIRECCION: {$direccion}, COMUNA: {$comuna}, CODIGO PLAN: {$cod_plan}, NOMBRE PLAN: {$nom_plan}, CANT BENEFICIARIOS: {$num_benef}, VALOR PLAN: {$valor_plan_benef}, COD PAGO: {$cod_pago}, TIPO PAGO: {$tipo_pago}, DESCUENTO: {$cant_descuento}, VALOR FINAL: {$valor_plan}, ESTADO: {$titulo}, TOKEN: {$token}, ORDEN DE COMPRA: {$buyorder}, CODIGO AUTORIZACION TBK: {$authorizationcode}, TIPO DE TARJETA: {$creditcardtype}, ULTIMOS 4 DIGITOS: {$last4carddigits}, USUARIO TBK: {$username}, COD USUARIO TBK: {$tbkuser}, FECHA TBK: {$newDate_tbk}, COD TIPO DE PAGO: {$payment_type_code}, FECHA FACTURACION: {$fec_fac}, CODIGO CAMPAÑA: {$campania}, NOMBRE CAMPAÑA: {$camp_nombre} , OBSERVACION ERROR: {$obs_error}, TIPO DE CLIENTE: {$tipo_clase}, COMENTARIO: {$observa} ";
    
    $fechahoy = date("Y-m-d");
    $asunto = $titulo." en Pagina Web el ".$fechahoy." Cliente ".$t_nombres." ".$t_apellido1." ".$t_apellido2." Tipo de cliente ".$clase." Rut ".$rut. ".";

    // Datos de la cuenta de correo utilizada para enviar vía SMTP
    $smtpHost = "pyme91.pymedns.net";  // Dominio alternativo brindado en el email de alta 
    $smtpUsuario = "autocontrato@rest911.cl";  // Mi cuenta de correo
    $smtpClave = "%&auto&%web2020";  // Mi contraseña
    $correo = ('autocontrato@rest911.cl'); // Email desde donde se envia el correo
    $nombre = "REST911 WEB";


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
       <TD>CODIGO:</TD>
       <TD>{$pagos}</TD>
    </TR>
    <TR>
       <TD>FECHA REGISTRO:</TD>
       <TD>{$fec_pag}</TD>
    </TR>
    <TR>
       <TD>NOMBRE TITULAR:</TD>
       <TD>{$t_nombres} {$t_apellido1} {$t_apellido2}</TD>
    </TR>
    <TR>
       <TD>RUT:</TD>
       <TD>{$rut}</TD>
    </TR>
    <TR>
       <TD>FECHA NACIMIENTO:</TD>
       <TD>{$t_fec_nac}</TD>
    </TR>
    <TR>
       <TD>EMAIL:</TD>
       <TD>{$email}</TD>
    </TR>
    <TR>
       <TD>TELEFONO:</TD>
       <TD>{$telefono}</TD>
    </TR>
    <TR>
       <TD>TELEFONO 2:</TD>
       <TD>{$telefono2}</TD>
    </TR>
    <TR>
       <TD>DIRECCION:</TD>
       <TD>{$direccion}</TD>
    </TR>
    <TR>
       <TD>COMUNA:</TD>
       <TD>{$comuna}</TD>
    </TR>
    <TR>
       <TD>CODIGO PLAN:</TD>
       <TD>{$cod_plan}</TD>
    </TR>
    <TR>
       <TD>NOMBRE PLAN:</TD>
       <TD>{$nom_plan}</TD>
    </TR>
    <TR>
       <TD>CANT BENEFICIARIOS:</TD>
       <TD>{$num_benef}</TD>
    </TR>
    <TR>
       <TD>VALOR PLAN:</TD>
       <TD>{$valor_plan_benef}</TD>
    </TR>
    <TR>
       <TD>COD PAGO:</TD>
       <TD>{$cod_pago}</TD>
    </TR>
       <TD>TIPO PAGO:</TD>
       <TD>{$tipo_pago}</TD>
    </TR>
    <TR>
       <TD>DESCUENTO:</TD>
       <TD>{$cant_descuento}</TD>
    </TR>
    <TR>
       <TD>VALOR FINAL:</TD>
       <TD>{$valor_plan}</TD>
    </TR>
    <TR>
       <TD>ESTADO:</TD>
       <TD>{$titulo}</TD>
    </TR>
    <TR>
       <TD>TOKEN:</TD>
       <TD>{$token}</TD>
    </TR>
    <TR>
       <TD>ORDEN DE COMPRA:</TD>
       <TD>{$buyorder}</TD>
    </TR>
    <TR>
       <TD>CODIGO AUTORIZACION TBK:</TD>
       <TD>{$authorizationcode}</TD>
    </TR>
    <TR>
       <TD>TIPO DE TARJETA:</TD>
       <TD>{$creditcardtype}</TD>
    </TR>
    <TR>
       <TD>ULTIMOS 4 DIGITOS:</TD>
       <TD>{$last4carddigits}</TD>
    </TR>
    <TR>
       <TD>USUARIO TBK:</TD>
       <TD>{$username}</TD>
    </TR>
    <TR>
       <TD>COD USUARIO TBK:</TD>
       <TD>{$tbkuser}</TD>
    </TR>
    <TR>
       <TD>FECHA TBK:</TD>
       <TD>{$newDate_tbk}</TD>
    </TR>
    <TR>
       <TD>COD TIPO DE PAGO:</TD>
       <TD>{$payment_type_code}</TD>
    </TR>
    <TR>
       <TD>FECHA FACTURACION:</TD>
       <TD>{$fec_fac}</TD>
    </TR>
    <TR>
       <TD>OBSERVACION ERROR:</TD>
       <TD>{$obs_error}</TD>
    </TR>
    <TR>
       <TD>TIPO DE CLIENTE:</TD>
       <TD>{$tipo_clase}</TD>
    </TR>
    <TR>
       <TD>CODIGO CAMPAÑA:</TD>
       <TD>{$campania}</TD>
    </TR>
     <TR>
       <TD>NOMBRE CAMPAÑA:</TD>
       <TD>{$camp_nombre}</TD>
    </TR>
    <TR>
       <TD>COMENTARIO:</TD>
       <TD>{$observa}</TD>
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
    
}

/* FUNCION ENVIAR CORREO REVERSA ORDEN: destinatario, destinatario2, cc, cc2, codigo de reversa, codigo transaccion, codigo de cliente, clase, rut cliente, fecha de la facturación, fecha de la reversa,valor del plan, monto reversado, orden de compra, tipo de pago,usuario, observación,estado R reversa F falllido  */
function enviarcorreo_interno_reversa($destinatario,$destinatario2,$cc,$cc2,$r_cod_rev,$r_cod_tran,	$r_cod_pagos,$clase,$rut,$r_fec_fac,$r_fecha_tbk,$r_val_mensual,$r_val_plan,$r_buyorder,$r_payment_type_code,$usuario,$r_observa,$estado){
    
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
    
    /* Estado */
    if($estado == 'R'){
        $titu = 'REVERSA';
        $cod_ti = 'REVERSA';
    }elseif($estado == 'F'){
        $titu = 'REVERSA FALLIDA';
        $cod_ti = 'FALLIDA';
    }
    
    //FORMATO FECHA TBK
    $newDate_tbk = date("d-m-Y H:i:s", strtotime($r_fecha_tbk));
        
    $mensaje = "CODIGO REVERSA: {$r_cod_rev}, CODIGO TRANSACCION: {$r_cod_tran}, CODIGO CLIENTE: {$r_cod_pagos}, CLASE: {$clase}, RUT: {$rut}, FECHA FACTURACION: {$r_fec_fac}, FECHA REVERSA: {$r_fecha_tbk},VALOR PLAN: {$r_val_mensual}, MONTO REVERSADO: {$r_val_plan}, ORDEN DE COMPRA: {$r_buyorder}, TIPO PAGO: {$r_payment_type_code}, USUARIO: {$usuario}, OBSERVACION: {$r_observa}";
    
    $fechahoy = date("Y-m-d");
    $asunto = "Se ha realizado una ".$titu." en Pagina Web el ".$fechahoy." Cliente Rut ".$rut. " Tipo de cliente ".$clase." ." ;

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
       <TD>{$r_cod_rev}</TD>
    </TR>
    <TR>
       <TD>CODIGO TRANSACCION:</TD>
       <TD>{$r_cod_tran}</TD>
    </TR>
    <TR>
       <TD>CODIGO CLIENTE:</TD>
       <TD>{$r_cod_pagos}</TD>
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
       <TD>{$r_fec_fac}</TD>
    </TR>
    <TR>
       <TD>FECHA REVERSA:</TD>
       <TD>{$r_fecha_tbk}</TD>
    </TR>
    <TR>
       <TD>VALOR DEL PLAN:</TD>
       <TD>{$r_val_mensual}</TD>
    </TR>
    <TR>
       <TD>MONTO REVERSADO:</TD>
       <TD>{$r_val_plan}</TD>
    </TR>
    <TR>
       <TD>ORDEN DE COMPRA:</TD>
       <TD>{$r_buyorder}</TD>
    </TR>
    <TR>
       <TD>TIPO PAGO:</TD>
       <TD>{$r_payment_type_code}</TD>
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
    
}
?>