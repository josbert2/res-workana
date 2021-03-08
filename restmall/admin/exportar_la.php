<?php
include_once 'config/conexion.php';
include "config/func.php";
include_once "config/permisos.php";

session_start();
$rol = $_SESSION['rol'];
$userid = $_SESSION['userid'];

if($rol != 7){
    header("location: index.php");
}

//ROL COMERCIAL
if($rol == 6){
        $crol = "AND (p.userid = ".$userid.")";
    }
//Datos de la URL     
$bdesde = strtolower($_REQUEST['bdesde']);
$bhasta = strtolower($_REQUEST['bhasta']);

if(empty($_REQUEST['class'])){
    $class = 'A';
}else{ 
    $class = $_REQUEST['class'];
}
if( (empty($bdesde)) && (empty($bhasta)) ){
   header("location: index.php");
   mysqli_close($conn);
 }


//get records from database
$date = getFecha();
$fechahora = getFechaYHoraExcel();

$query = mysqli_query($conn, "SELECT p.pagos, CAST(p.fec_pag AS DATE) as fecha, CAST(p.fec_pag AS TIME) as hora, p.t_nombres, p.t_apellido1, p.t_apellido2, p.rut, p.t_fec_nac, p.email, p.telefono, p.telefono2, p.direccion, p.comuna, p.cod_plan, p.nom_plan, p.num_benef, p.valor_plan_benef, p.cod_pago, p.tipo_pago, p.num_mes, p.cant_descuento, p.valor_plan, p.campania,
CASE 
WHEN p.estado = 'N' THEN 'SOLO REST911'
WHEN p.estado = 'E' THEN 'ABANDONO TBK'
WHEN p.estado = 'T' THEN 'RECHAZO TBK'
WHEN p.estado = 'R' THEN 'RECHAZA COBRO'
WHEN p.estado = 'S' THEN 'TRANSACC EXITOSA'
WHEN p.estado = 'I' THEN 'SUSCRIPCION'
WHEN p.estado = 'M' THEN 'MOROSO'
WHEN p.estado = 'D' THEN 'DESVINCULADO'
ELSE 'N/A'
END AS estado, 
p.token, p.buyorder,p.authorizationcode, p.creditcardtype, p.last4carddigits, p.username, p.tbkuser, p.fecha_tbk, p.payment_type_code, DATE_ADD(p.fec_fac,INTERVAL '1' MONTH) as fec_fac, 
CASE
WHEN p.clase = 'A' THEN '(A) Autocontratados'
WHEN p.clase = 'B' THEN '(B) Inscripción y Cobro'
WHEN p.clase = 'C' THEN '(C) Solo Inscripción'
WHEN p.clase = 'D' THEN '(D) Campaña'
ELSE 'N/A'
END AS clase, p.observa,p.c_envio,
IF (SUBSTR(p.responsecode, 1, 1) = 'i',
CASE
WHEN LTRIM(RTRIM(p.responsecode)) = '0' THEN ''
WHEN LTRIM(RTRIM(SUBSTR(p.responsecode, 2))) = '-1' THEN 'ERROR -1 => Rechazo de transaccion - Reintente (Posible error en el ingreso de datos de la transaccion)'
WHEN LTRIM(RTRIM(SUBSTR(p.responsecode, 2))) = '-2' THEN 'ERROR -2 => Rechazo de transaccion (Se produjo fallo al procesar la transaccion. Este mensaje de rechazo esta relacionado a parametros de la tarjeta y/o su cuenta asociada)'
WHEN LTRIM(RTRIM(SUBSTR(p.responsecode, 2))) = '-3' THEN 'ERROR -3 => Error en transaccion (Interno Transbank)'
WHEN LTRIM(RTRIM(SUBSTR(p.responsecode, 2))) = '-4' THEN 'ERROR -4 => Rechazo emisor (Rechazada por parte del emisor)'
WHEN LTRIM(RTRIM(SUBSTR(p.responsecode, 2))) = '-5' THEN 'ERROR -5 => Rechazo - Posible Fraude (Transaccion con riesgo de posible fraude)'
ELSE 'No Especifica'
END,
CASE
WHEN LTRIM(RTRIM(p.responsecode)) = '0' THEN ''
WHEN CAST(LTRIM(RTRIM(SUBSTR(p.responsecode, 2))) AS SIGNED) > -9 AND CAST(SUBSTR(p.responsecode, 2) AS SIGNED) < 0 THEN 'RECHAZO TBK'
WHEN LTRIM(RTRIM(SUBSTR(p.responsecode, 2))) = '-96' THEN 'ERROR -96 => NO EXISTE INCRIPCION ASOCIADA'
WHEN LTRIM(RTRIM(SUBSTR(p.responsecode, 2))) = '-97' THEN 'ERROR -97 => LIMITES ONECLICK (MAXIMO MONTO DIARIO DE PAGO EXCEDIDO)'
WHEN LTRIM(RTRIM(SUBSTR(p.responsecode, 2))) = '-98' THEN 'ERROR -98 => LIMITES ONECLICK (MAXIMO MONTO DE PAGO EXCEDIDO)'
WHEN LTRIM(RTRIM(SUBSTR(p.responsecode, 2))) = '-99' THEN 'ERROR -99 => LIMITES ONECLICK (MAXIMA CANTIDAD DE PAGO EXCEDIDO)'
WHEN CAST(LTRIM(RTRIM(p.responsecode)) AS SIGNED) > -9 AND CAST(p.responsecode AS SIGNED) < 0 THEN 'RECHAZO TBK'
WHEN LTRIM(RTRIM(p.responsecode)) = '-96' THEN 'ERROR -96 => NO EXISTE INCRIPCION ASOCIADA'
WHEN LTRIM(RTRIM(p.responsecode)) = '-97' THEN 'ERROR -97 => LIMITES ONECLICK (MAXIMO MONTO DIARIO DE PAGO EXCEDIDO)'
WHEN LTRIM(RTRIM(p.responsecode)) = '-98' THEN 'ERROR -98 => LIMITES ONECLICK (MAXIMO MONTO DE PAGO EXCEDIDO)'
WHEN LTRIM(RTRIM(p.responsecode)) = '-99' THEN 'ERROR -99 => LIMITES ONECLICK (MAXIMA CANTIDAD DE PAGO EXCEDIDO)'
ELSE 'No Especifica'
END) AS responsecode, US.usuario
FROM pagos_clientes p INNER JOIN user US on p.userid = US.userid WHERE ((CAST(FEC_PAG AS DATE) >= '$bdesde') AND (CAST(FEC_PAG AS DATE) <= '$bhasta') AND (clase = 'A') AND (p.estado = 'S') ".$crol." ) ORDER BY fec_pag ASC");

if($query->num_rows > 0){
    $delimiter = ";";
    $filename = "REST911_trans_desde_" .$bdesde. "_hasta_".$bhasta."_Clase_".$class.".csv";
    
    //create a file pointer
    $f = fopen('php://memory', 'w');
    
    //set column headers
    $fields = array('CODIGO', 'FECHA REGISTRO', 'HORA', 'NOMBRE TITULAR', 'APELLIDO PAT', 'APELLIDO MAT', 'RUT', 'FECHA NAC', 'EMAIL', 'TELEFONO', 'TELEFONO 2', 'DIRECCION', 'COMUNA', 'CODIGO PLAN', 'NOMBRE PLAN', 'CANT BENEFICIARIOS', 'VALOR PLAN', 'COD PAGO', 'TIPO PAGO', 'NUM MES INICIALES', 'DESCUENTO', 'VALOR FINAL', 'ESTADO', 'TOKEN', 'ORDEN DE COMPRA', 'COD AUTORIZACION TBK', 'TIPO DE TARJETA', 'ULTIMOS 4 DIGITOS', 'USUARIO TBK', 'COD USUARIO TBK','FECHA TBK', 'COD TIPO PAGO','SIGUIENTE FACTURACION','TIPO DE CLIENTE','OBSERVACIONES','CORREO INTERNO ENVIADO', 'USUARIO', 'CODIGO CAMPANA', 'CAMPANA','TIPO DE ERROR' );
    fputcsv($f, $fields, $delimiter);
    
    //output each row of the data, format line as csv and write to file pointer
    while($row = $query->fetch_assoc()){
        
        $campania = $row['campania'];
        $query_camp = mysqli_query($conn, "SELECT nombre FROM campania WHERE cod_camp = $campania ");   $result_camp = mysqli_num_rows($query_camp);
        $camp = mysqli_fetch_array($query_camp);
        
        $status = ($row['status'] == '1')?'Active':'Inactive';
        $lineData = array($row['pagos'], $row['fecha'], $row['hora'], $row['t_nombres'], $row['t_apellido1'], $row['t_apellido2'],$row['rut'],$row['t_fec_nac'],$row['email'],$row['telefono'],$row['telefono2'],$row['direccion'],$row['comuna'],$row['cod_plan'],$row['nom_plan'],$row['num_benef'],$row['valor_plan_benef'],$row['cod_pago'],$row['tipo_pago'],$row['num_mes'],$row['cant_descuento'],$row['valor_plan'],$row['estado'],$row['token'],$row['buyorder'],$row['authorizationcode'],$row['creditcardtype'],$row['last4carddigits'],$row['username'],$row['tbkuser'],$row['fecha_tbk'],$row['payment_type_code'],$row['fec_fac'],$row['clase'],$row['observa'],$row['c_envio'],$row['usuario'],$row['campania'],$camp['nombre'],$row['responsecode']);
        fputcsv($f, $lineData, $delimiter);
    }
    
    //move back to beginning of file
    fseek($f, 0);
    
    //set headers to download file rather than displayed
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');
    
    //output all remaining data on a file pointer
    fpassthru($f);
}
exit;

?>