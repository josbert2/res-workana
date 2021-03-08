<?php
include "config/func.php";
require_once 'consulta_reg.php';
include_once "config/permisos.php";

session_start();
$rol = $_SESSION['rol'];
$currentPage = "consulta_t"; 
$acceso = getPermisos($currentPage, $rol);
if(!$acceso){
    header("location: ../login.php");    
}

//get records from database
$date = getFecha();
$fechahora = getFechaYHoraExcel();

//DATOS DE BUSQUEDA
if(empty($_REQUEST['transc'])){
    header("location: consulta_t.php");
}else{
    $transc = $_REQUEST['transc'];
    }
if( (empty($_REQUEST['bdesde'])) OR (empty($_REQUEST['bhasta'])) ){
    header("location: consulta_t.php");
    }else{
    $bdesde = strtolower($_REQUEST['bdesde']);
    $bhasta = strtolower($_REQUEST['bhasta']);
}

//$tip
if($transc == "A"){
    $tip= "Exitosas";
}elseif($transc == "A"){
    $tip= "Exitosas_no_reversadas";
}elseif($transc == "F"){
    $tip= "Fallidas";
}elseif($transc == "M"){
    $tip= "Morosos";
}elseif($transc == "R"){
    $tip= "Reversas";
}elseif($transc == "FR"){
    $tip= "Reversas_Fallidas";
}else{
    $tip= "Totales";
}

$sql = getTransc($transc,$bdesde,$bhasta);
$conn = getConn();
$query = mysqli_query($conn, $sql);

if($query->num_rows > 0){
    $delimiter = ";";
    $filename = "REST911_Transacciones_".$tip."_desde_".$bdesde."_hasta_".$bhasta.".csv";
    
    //create a file pointer
    $f = fopen('php://memory', 'w');
    
    //CASOS
    if($transc == "A"){
        //set column headers
        $fields = array('COD.TRANSAC', 'COD.CLIENTE', 'CLASE','RUT', 'FECHA FACTURACIÓN', 'FECHA TRANSACCION', 'MONTO', 'ORDEN DE COMPRA', 'COD.AUTORIZACION', 'TIPO DE PAGO', 'USUARIO', 'OBSERVACION' );
        fputcsv($f, $fields, $delimiter);

        //output each row of the data, format line as csv and write to file pointer
        while($row = $query->fetch_assoc()){
            $status = ($row['status'] == '1')?'Active':'Inactive';
            $lineData = array($row['t_cod_tran'], $row['pagos'], $row['clase'], $row['rut'], $row['t_fec_fac'], $row['t_fecha_tbk'], $row['t_val_plan'], $row['t_buyorder'], $row['t_authorizationcode'], $row['t_payment_type_code'], $row['usuario'], $row['t_observa']);
            fputcsv($f, $lineData, $delimiter);
        }
    }elseif($transc == "AR"){
        //set column headers
        $fields = array('COD.TRANSAC', 'COD.CLIENTE', 'CLASE','RUT', 'FECHA FACTURACIÓN', 'FECHA TRANSACCION', 'MONTO', 'ORDEN DE COMPRA', 'COD.AUTORIZACION', 'TIPO DE PAGO', 'USUARIO', 'OBSERVACION' );
        fputcsv($f, $fields, $delimiter);

        //output each row of the data, format line as csv and write to file pointer
        while($row = $query->fetch_assoc()){
            $status = ($row['status'] == '1')?'Active':'Inactive';
            $lineData = array($row['t_cod_tran'], $row['pagos'], $row['clase'], $row['rut'], $row['t_fec_fac'], $row['t_fecha_tbk'], $row['t_val_plan'], $row['t_buyorder'], $row['t_authorizationcode'], $row['t_payment_type_code'], $row['usuario'], $row['t_observa']);
            fputcsv($f, $lineData, $delimiter);
        }
    }elseif($transc == "F"){
        //set column headers
        $fields = array('COD.FALLIDA', 'COD.CLIENTE', 'CLASE', 'RUT', 'FECHA ULTIMO PAGO', 'FECHA RECHAZO', 'MONTO', 'ORDEN DE COMPRA', 'TIPO DE PAGO', 'USUARIO', 'ERROR' );
        fputcsv($f, $fields, $delimiter);

        //output each row of the data, format line as csv and write to file pointer
        while($row = $query->fetch_assoc()){
            $status = ($row['status'] == '1')?'Active':'Inactive';
            $lineData = array($row['f_cod_fall'], $row['pagos'], $row['clase'], $row['rut'], $row['f_fec_fac'], $row['t_fecha_tbk'], $row['f_val_plan'], $row['f_buyorder'], $row['f_payment_type_code'], $row['usuario'], $row['f_log']);
            fputcsv($f, $lineData, $delimiter);
        }
    }elseif($transc == "M"){
        //set column headers
        $fields = array('COD.CLIENTE', 'CLASE', 'FECHA FACTURACIÓN', 'FECHA ESTADO MOROSO', 'NOMBRE', 'APELLIDO', 'RUT', 'CORREO', 'TELEFONO', 'VALOR DEL PLAN', 'USUARIO', 'OBSERVACION' );
        fputcsv($f, $fields, $delimiter);

        //output each row of the data, format line as csv and write to file pointer
        while($row = $query->fetch_assoc()){
            $status = ($row['status'] == '1')?'Active':'Inactive';
            $lineData = array($row['pagos'], $row['clase'], $row['f_fec_fac'], $row['t_fecha_tbk'], $row['t_nombres'], $row['t_apellido1'], $row['rut'], $row['email'], $row['telefono'], $row['f_val_plan'], $row['usuario'], $row['f_log']);
            fputcsv($f, $lineData, $delimiter);
        }
    }elseif($transc == "R"){
        //set column headers
        $fields = array('COD.REVERSA', 'COD.TRANSAC', 'COD.CLIENTE', 'CLASE','RUT CLIENTE', 'FECHA FACTURACIÓN', 'FECHA REVERSA', 'MONTO PAGO', 'MONTO REVERSADO', 'ORDEN DE COMPRA', 'AUTORIZACION TBK', 'TIPO PAGO', 'USUARIO', 'OBSERVACION' );
        fputcsv($f, $fields, $delimiter);

        //output each row of the data, format line as csv and write to file pointer
        while($row = $query->fetch_assoc()){
            $status = ($row['status'] == '1')?'Active':'Inactive';
            $lineData = array($row['r_cod_rev'], $row['r_cod_tran'],$row['pagos'], $row['clase'], $row['rut'], $row['r_fec_fac'], $row['r_fecha_tbk'], $row['r_val_mensual'], $row['r_val_plan'], $row['r_buyorder'], $row['r_authorizationcode'], $row['r_payment_type_code'], $row['usuario'], $row['r_observa']);
            fputcsv($f, $lineData, $delimiter);
        }
    }elseif($transc == "FR"){
        //set column headers
        $fields = array('COD.FALLIDA', 'COD.CLIENTE', 'CLASE', 'RUT', 'FECHA FACTURACION', 'FECHA REVERSA FALLIDA', 'MONTO PAGO', 'MONTO REVERSA', 'ORDEN DE COMPRA', 'TIPO DE PAGO', 'USUARIO', 'ERROR' );
        fputcsv($f, $fields, $delimiter);

        //output each row of the data, format line as csv and write to file pointer
        while($row = $query->fetch_assoc()){
            $status = ($row['status'] == '1')?'Active':'Inactive';
            $lineData = array($row['f_cod_fall'], $row['pagos'], $row['clase'], $row['rut'], $row['f_fec_fac'], $row['t_fecha_tbk'], $row['f_val_mensual'], $row['f_val_plan'], $row['f_buyorder'], $row['f_payment_type_code'], $row['usuario'], $row['f_log']);
            fputcsv($f, $lineData, $delimiter);
        }
    }else{
        //set column headers
        $fields = array('COD.TRAN/RECHA', 'COD.CLIENTE', 'CLASE', 'RUT', 'FECHA ULTIMA FAC.', 'FECHA TRAN/RECHA', 'MONTO', 'ORDEN DE COMPRA', 'COD.AUTORIZACION', 'TIPO DE PAGO', 'USUARIO', 'OBS/ERROR' );
        fputcsv($f, $fields, $delimiter);

        //output each row of the data, format line as csv and write to file pointer
        while($row = $query->fetch_assoc()){
            $status = ($row['status'] == '1')?'Active':'Inactive';
            $lineData = array($row['t_cod_tran'], $row['pagos'], $row['clase'], $row['rut'], $row['t_fec_fac'], $row['t_fecha_tbk'], $row['t_val_plan'], $row['t_buyorder'], $row["t_authorizationcode"], $row['t_payment_type_code'], $row['usuario'], $row['t_observa']);
            fputcsv($f, $lineData, $delimiter);
        }
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