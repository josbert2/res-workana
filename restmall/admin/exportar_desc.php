<?php
include_once 'config/conexion.php';
include "config/func.php";
include_once "config/permisos.php";

session_start();
$rol = $_SESSION['rol'];
$currentPage = "reingreso";
$acceso = getPermisos($currentPage, $rol);
if(!$acceso){
    header("location: ../login.php");    
}

$fechahoy = getFecha();
$fechahoy = date('Y-m-d', strtotime($fechahoy. ' + 7 days'));
$fechahora = getFechaYHoraExcel();

$query = mysqli_query($conn, "SELECT PC.pagos, PC.t_nombres, PC.t_apellido1, PC.rut, CA.nombre, PC.fec_pag, PC.fec_descuento, PC.telefono, PC.valor_plan_benef, US.usuario FROM pagos_clientes PC INNER JOIN user US on PC.userid = US.userid INNER JOIN campania CA on PC.campania = CA.cod_camp WHERE ((CAST(PC.fec_descuento AS DATE) <= '$fechahoy') AND PC.clase = 'D' ) ORDER BY PC.fec_descuento ASC");

if($query->num_rows > 0){
    $delimiter = ";";
    $filename = "REST911_Clientes_Descuentos_Finalizados_" . $fechahora . ".csv";
    
    //create a file pointer
    $f = fopen('php://memory', 'w');
    
    //set column headers
    $fields = array('COD. CLIENTE', 'NOMBRE', 'RUT', 'CAMPANA', 'FEC. INGRESO', 'FEC. FIN DESCUENTO', 'TELEFONO', 'MONTO ACTUAL', 'USUARIO' );
    fputcsv($f, $fields, $delimiter);
    
    //output each row of the data, format line as csv and write to file pointer
    while($row = $query->fetch_assoc()){
        $completo = $row['t_nombres'].$row['t_apellido1'];
        $status = ($row['status'] == '1')?'Active':'Inactive';
        $lineData = array($row['pagos'], $completo, $row['rut'], $row['nombre'], $row['fec_pag'],$row['fec_descuento'],$row['telefono'],$row['valor_plan_benef'],$row['usuario']);
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