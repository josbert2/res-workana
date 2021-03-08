<?php
    session_start();
    if($_SESSION['rol'] != 1){
    header("location: ../loginoc.php");     
    }
//include database configuration file
include_once 'config/conexion.php';
include "config/func.php";

$class = $_REQUEST['class'];
//get records from database
$date = getFecha();
$fechahora = getFechaYHoraExcel();
    
$query = mysqli_query($conn, "SELECT BE.pagos, CAST(PC.fec_pag AS DATE) as fecha, CAST(PC.fec_pag AS TIME) as hora, PC.rut, BE.cor_benef, PC.nom_plan, BE.nombres, BE.apellido1, BE.apellido2, BE.fec_nac FROM pagos_clientes PC INNER JOIN beneficiarios BE on PC.pagos = BE.pagos WHERE ((CAST(PC.fec_pag AS DATE) = '$date') AND (PC.estado = 'S') AND (PC.clase = '$class')) ORDER BY BE.pagos, BE.cor_benef ASC");

if($query->num_rows > 0){
    $delimiter = ";";
    $filename = "REST911_benef_" . $fechahora . ".csv";
    
    //create a file pointer
    $f = fopen('php://memory', 'w');
    
    //set column headers
    $fields = array('CODIGO', 'FECHA', 'HORA', 'RUT TITULAR', 'COR.BENEFICIARIO', 'PLAN', 'NOMBRES', 'APELLIDO PAT', 'APELLIDO MAT', 'FECHA NAC'  );
    fputcsv($f, $fields, $delimiter);
    
    //output each row of the data, format line as csv and write to file pointer
    while($row = $query->fetch_assoc()){
        $status = ($row['status'] == '1')?'Active':'Inactive';
        $lineData = array($row['pagos'], $row['fecha'], $row['hora'], $row['rut'], $row['cor_benef'], $row['nom_plan'], $row['nombres'], $row['apellido1'], $row['apellido2'],$row['fec_nac']);
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