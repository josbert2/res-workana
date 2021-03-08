<?php
    session_start();
    if(empty($_SESSION['rol']) || $_SESSION['rol'] == 6){
    header("location: ../loginoc.php");     
    }
//include database configuration file
include_once 'config/conexion.php';
include "config/func.php";

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

$query = mysqli_query($conn, "SELECT p.pagos, CAST(p.fec_pag AS DATE) as fecha, CAST(p.fec_pag AS TIME) as hora, p.t_nombres, p.t_apellido1, p.t_apellido2, p.rut, p.t_fec_nac, p.email, p.telefono, p.telefono2, p.direccion, p.comuna, p.cod_plan, p.nom_plan, p.num_benef, p.valor_plan_benef, p.cod_pago, p.tipo_pago, p.cant_descuento, p.valor_plan,
CASE 
WHEN p.estado = 'N' THEN 'SOLO REST911'
WHEN p.estado = 'E' THEN 'ERROR EN TBK'
WHEN p.estado = 'R' THEN 'RECHAZA COBRO'
WHEN p.estado = 'S' THEN 'TRANSACC EXITOSA'
WHEN p.estado = 'I' THEN 'SUSCRIPCION'
ELSE 'N/A'
END AS estado, 
p.token, p.username, p.buyorder,p.authorizationcode, p.creditcardtype, p.last4carddigits, p.tbkuser, p.transactionid, p.fecha_tbk, p.fec_fac, 
CASE
WHEN p.clase = 'A' THEN '(A) Autocontratados'
WHEN p.clase = 'B' THEN '(B) Inscripción y Cobro'
WHEN p.clase = 'C' THEN '(C) Solo Inscripción'
ELSE 'N/A'
END AS clase, p.observa FROM pagos_clientes p WHERE ((CAST(FEC_PAG AS DATE) >= '$bdesde') AND (CAST(FEC_PAG AS DATE) <= '$bhasta') AND (p.clase = '$class')) ORDER BY fec_pag ASC");

if($query->num_rows > 0){
    $delimiter = ";";
    $filename = "REST911_trans_desde_" .$bdesde. "_hasta_".$bhasta.".csv";
    
    //create a file pointer
    $f = fopen('php://memory', 'w');
    
    //set column headers
    $fields = array('CODIGO', 'FECHA', 'HORA', 'NOMBRES TITULAR', 'APELLIDO PAT', 'APELLIDO MAT', 'RUT', 'FECHA NAC', 'EMAIL', 'TELEFONO', 'TELEFONO 2', 'DIRECCION', 'COMUNA', 'CODIGO PLAN', 'NOMBRE PLAN', 'CANT BENEFICIARIOS', 'VALOR PLAN', 'COD PAGO', 'TIPO PAGO', 'DESCUENTO', 'VALOR FINAL', 'ESTADO', 'TOKEN', 'USUARIO TBK', 'ORDEN DE COMPRA', 'COD AUTORIZACION TBK', 'TIPO TARJETA', 'ULTIMOS 4 DIGITOS', 'COD USUARIO TBK', 'COD TRANSACCION', 'FECHA TBK','FECHA FACTURACION','TIPO DE CLIENTE','OBSERVACIONES' );
    fputcsv($f, $fields, $delimiter);
    
    //output each row of the data, format line as csv and write to file pointer
    while($row = $query->fetch_assoc()){
        $status = ($row['status'] == '1')?'Active':'Inactive';
        $lineData = array($row['pagos'], $row['fecha'], $row['hora'], $row['t_nombres'], $row['t_apellido1'], $row['t_apellido2'],$row['rut'],$row['t_fec_nac'],$row['email'],$row['telefono'],$row['telefono2'],$row['direccion'],$row['comuna'],$row['cod_plan'],$row['nom_plan'],$row['num_benef'],$row['valor_plan_benef'],$row['cod_pago'],$row['tipo_pago'],$row['cant_descuento'],$row['valor_plan'],$row['estado'],$row['token'],$row['username'],$row['buyorder'],$row['authorizationcode'],$row['creditcardtype'],$row['last4carddigits'],$row['tbkuser'],$row['transactionid'],$row['fecha_tbk'],$row['fec_fac'],$row['clase'],$row['observa']);
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