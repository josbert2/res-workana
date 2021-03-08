<?php
include_once 'config/conexion.php';
include "config/func.php";
include_once "config/permisos.php";

session_start();
$rol = $_SESSION['rol'];
$currentPage = "descuentos";
$acceso = getPermisos($currentPage, $rol);
if(!$acceso){
    header("location: ../login.php");    
}

$date = getFecha();
$fechahora = getFechaYHoraExcel();

$query = mysqli_query($conn, "SELECT * FROM tipopago WHERE est_pago = 'S' ORDER BY cod_pago ASC");

if($query->num_rows > 0){
    $delimiter = ";";
    $filename = "REST911_TipoPago_" . $fechahora . ".csv";
    
    //create a file pointer
    $f = fopen('php://memory', 'w');
    
    //set column headers
    $fields = array('CODIGO', 'NOMBRE DE PAGO', 'CANTIDAD DE MESES', 'DESCUENTO (MULTIPLO)' );
    fputcsv($f, $fields, $delimiter);
    
    //output each row of the data, format line as csv and write to file pointer
    while($row = $query->fetch_assoc()){
        $status = ($row['status'] == '1')?'Active':'Inactive';
        $lineData = array($row['cod_pago'], $row['nom_pago'], $row['num_mes'], $row['descuento']);
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