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

$query = mysqli_query($conn, "SELECT CA.cod_camp, CA.nombre, CA.descuento, CA.meses, CA.dias, CA.fec_ini, CA.fec_ter, CA.descripcion, US.usuario, CA.enlace, CA.estado, CA.titulo, CA.mensaje, CA.terminos FROM campania CA INNER JOIN user US on CA.user_id = US.userid ORDER BY CA.cod_camp ASC");

if($query->num_rows > 0){
    $delimiter = ";";
    $filename = "REST911_TipoPago_" . $fechahora . ".csv";
    
    //create a file pointer
    $f = fopen('php://memory', 'w');
    
    //set column headers
    $fields = array('COD. CAMPANA', 'NOMBRE CAMPANA', 'PROMOCION', 'FECHA INICIO', 'FECHA TERMINO', 'USUARIO', 'DESCRIPCION','ESTADO S ACTIVO - N INACTIVO', 'TITULO WEB', 'MENSAJE WEB', 'TERMINOS WEB' );
    fputcsv($f, $fields, $delimiter);
    
    //output each row of the data, format line as csv and write to file pointer
    while($row = $query->fetch_assoc()){
        $status = ($row['status'] == '1')?'Active':'Inactive';
        
        if($row['descuento'] != NULL){ 
            $promo = 'Descuento '.$row["descuento"].'% por '.$row["meses"].' meses';
        }elseif($row["dias"] != NULL){ 
            $promo = 'Gratis por '.$row["dias"].' dias'; 
        }
        
        $lineData = array($row['cod_camp'], $row['nombre'], $promo, $row['fec_ini'], $row['fec_ter'], $row['usuario'], $row['descripcion'], $row['estado'], $row['titulo'], $row['mensaje'], $row['terminos']);
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