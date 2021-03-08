<?php
include_once 'config/conexion.php';
include "config/func.php";
include_once "config/permisos.php";

session_start();
$rol = $_SESSION['rol'];
$currentPage = "registro_usuarios";
$acceso = getPermisos($currentPage, $rol);
if(!$acceso){
    header("location: ../login.php");    
}

$date = getFecha();
$fechahora = getFechaYHoraExcel();

$query = mysqli_query($conn, "SELECT US.userid, US.usuario, US.rol, RL.nombre, US.estado FROM user US INNER JOIN roles RL on US.rol = RL.cod_rol WHERE ( ( (RL.estado = 'S' AND US.estado = 'S') OR (RL.estado = 'S' AND US.estado = 'N') ) AND (US.rol != 1) ) ORDER BY US.rol, US.userid ASC");

if($query->num_rows > 0){
    $delimiter = ";";
    $filename = "REST911_Usuarios_" . $fechahora . ".csv";
    
    //create a file pointer
    $f = fopen('php://memory', 'w');
    
    //set column headers
    $fields = array('CODIGO USUARIO', 'USUARIO', 'CODIGO ROL', 'NOMBRE ROL', 'ESTADO S ACTIVO - N INACTIVO' );
    fputcsv($f, $fields, $delimiter);
    
    //output each row of the data, format line as csv and write to file pointer
    while($row = $query->fetch_assoc()){
        $status = ($row['status'] == '1')?'Active':'Inactive';
        $lineData = array($row['userid'], $row['usuario'], $row['rol'], $row['nombre'], $row['estado']);
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