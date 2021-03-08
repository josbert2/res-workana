<?php

/* FUNCION ENVIAR CORREO CLIENTE
    ORDEN: t_nombres,t_apellido1,email,creditcardtype,last4carddigits */

function enviarcorreo_cliente($t_nombres,$t_apellido1,$email,$creditcardtype,$last4carddigits){
    
    //variables recibidas

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

    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->Port = 465; 
    $mail->IsHTML(true); 
    $mail->CharSet = "utf-8";

    // VALORES A MODIFICAR //
    $mail->Host = $smtpHost; 
    $mail->Username = $smtpUsuario; 
    $mail->Password = $smtpClave;

	//adicional
    $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail

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
    
    Si tiene una emergencia debe llamarnos al *<b>442 469 911</b> desde cualquier teléfono fijo o móvil o si lo prefiera al número <b>225738555</b>. Nuestros profesionales de servicio están las 24 horas del día todo los días del año, listos para para ayudar de manera oportuna.<br></span>
    
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
    ORDEN: destinatario,destinatario2,cc,cc2,pagos,fec_pag,t_nombres,t_apellido1,t_apellido2,rut,t_fec_nac,email,telefono,telefono2,
    direccion,comuna,cod_plan,nom_plan,num_benef,valor_plan_benef,cod_pago,tipo_pago,descuento,valor_plan,token,buyorder,username,authorizationcode,creditcardtype,last4carddigits,tbkuser,transactionid,fecha_tbk,estado,clase,responsecode */
function enviarcorreo_interno($destinatario,$destinatario2,$cc,$cc2,$pagos,$fec_pag,$t_nombres,$t_apellido1,$t_apellido2,$rut,$t_fec_nac,$email,$telefono,$telefono2,$direccion,$comuna,$cod_plan,$nom_plan,$num_benef,$valor_plan_benef,$cod_pago,$tipo_pago,$descuento,$valor_plan,$token,$buyorder,$username,$authorizationcode,$creditcardtype,$last4carddigits,$tbkuser,$transactionid,$fecha_tbk,$estado,$clase,$responsecode){

    $mensaje = "CODIGO: {$pagos}, FECHA PAGO: {$fec_pag}, NOMBRES TITULAR: {$t_nombres} {$t_apellido1} {$t_apellido2}, RUT: {$rut}, FECHA NAC: {$t_fec_nac}, EMAIL: {$email}, TELEFONO: {$telefono}, TELEFONO 2: {$telefono2}, DIRECCION: {$direccion}, COMUNA: {$comuna}, CODIGO PLAN: {$cod_plan}, NOMBRE PLAN: {$nom_plan}, CANT BENEFICIARIOS: {$num_benef}, VALOR PLAN: {$valor_plan_benef}, COD PAGO: {$cod_pago}, TIPO PAGO: {$tipo_pago}, DESCUENTO: {$descuento}, VALOR FINAL: {$valor_plan}, TIPO DE TARJETA: {$creditcardtype}, Ultimos 4 digitos: {$last4carddigits} Usuario TBK: {$tbkuser}, CODIGO TRANSACCIÓN TBK: {$transactionid} ";
    
    /* Estado del Cliente */
    if($estado == 'S'){
        $titulo = 'Transacción Exitosa';
    }elseif($estado == 'R'){
        $titulo = 'Rechaza Cobro';
    }elseif($estado == 'E'){
        $titulo = 'Error en TBK';
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
    /* Tipo de Cliente */
    if($responsecode == '-97'){
        $obs_error = '-97 máximo monto diario de pago excedido';
    }elseif($responsecode == '-98'){
        $obs_error = '-98 máximo monto de pago excedido';
    }elseif($responsecode == '-99'){
        $obs_error = '-99 máxima cantidad de pagos diarios excedido'; 
    }elseif($responsecode > 0 && $responsecode < -9){
        $obs_error = 'Rechazo TBK'; 
    }else{
        $obs_error = 'No aplica / No especifica';
    }
    $fechahoy = date("Y-m-d");
    $asunto = $titulo." en Pagina Web el ".$fechahoy." Cliente ".$t_nombres." ".$t_apellido1." ".$t_apellido2." Tipo de cliente ".$clase." Rut ".$rut. ".";

    // Datos de la cuenta de correo utilizada para enviar vía SMTP
    $smtpHost = "pyme91.pymedns.net";  // Dominio alternativo brindado en el email de alta 
    $smtpUsuario = "autocontrato@rest911.cl";  // Mi cuenta de correo
    $smtpClave = "%&auto&%web2020";  // Mi contraseña
    $correo = ('autocontrato@rest911.cl'); // Email desde donde se envia el correo



    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->Port = 465; 
    $mail->IsHTML(true); 
    $mail->CharSet = "utf-8";

    // VALORES A MODIFICAR //
    $mail->Host = $smtpHost; 
    $mail->Username = $smtpUsuario; 
    $mail->Password = $smtpClave;
	
	//adicional
    $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail

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
       <TD>FECHA PAGO:</TD>
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
       <TD>{$descuento}</TD>
    </TR>
    <TR>
       <TD>VALOR FINAL:</TD>
       <TD>{$valor_plan}</TD>
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
       <TD>USUARIO TBK:</TD>
       <TD>{$username}</TD>
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
       <TD>COD USUARIO TBK:</TD>
       <TD>{$tbkuser}</TD>
    </TR>
    <TR>
       <TD>CODIGO TRANSACCIÓN TBK:</TD>
       <TD>{$transactionid}</TD>
    </TR>
    <TR>
       <TD>CODIGO TRANSACCIÓN TBK:</TD>
       <TD>{$fecha_tbk}</TD>
    </TR>
    <TR>
       <TD>ESTADO:</TD>
       <TD>{$titulo}</TD>
    </TR>
    <TR>
    <TR>
       <TD>OBSERVACION ERROR:</TD>
       <TD>{$obs_error}</TD>
    </TR>
    <TR>
       <TD>TIPO DE CLIENTE:</TD>
       <TD>{$tipo_clase}</TD>
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