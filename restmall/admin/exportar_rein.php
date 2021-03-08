<?php
include "config/func.php";
require_once 'exportar_rein_sql.php';
include_once "config/permisos.php";

session_start();
$rol = $_SESSION['rol'];
$currentPage = "reingreso"; 
$acceso = getPermisos($currentPage, $rol);
if(!$acceso){
    header("location: ../login.php");    
}

//get records from database
$date = getFecha();
$fechahora = getFechaYHoraExcel();

//DATOS DE BUSQUEDA
if(empty($_REQUEST['transc'])){
    header("location: consulta_trein.php");
}else{
    $transc = $_REQUEST['transc'];
    }
if( (empty($_REQUEST['bdesde'])) OR (empty($_REQUEST['bhasta'])) ){
    header("location: consulta_rein.php");
    }else{
    $bdesde = strtolower($_REQUEST['bdesde']);
    $bhasta = strtolower($_REQUEST['bhasta']);
}

//$tip
if($transc == "T"){
    $tip= "reingresos";
}

$sql = getTransc($transc,$bdesde,$bhasta);
$conn = getConn();
$query = mysqli_query($conn, $sql);

if($query->num_rows > 0){
    $delimiter = ";";
    $filename = "REST911_consulta_".$tip."_desde_".$bdesde."_hasta_".$bhasta.".csv";
    
    //create a file pointer
    $f = fopen('php://memory', 'w');
    
    //CASOS
    if($transc == "T"){
        //set column headers
        $fields = array('COD.MODIFICAR', 'COD.CLIENTE', 'RUT', 'MONTO ORIGINAL', 'MONTO NUEVO', 'FEC. FAC. ORIGINAL', 'FEC. FAC. NUEVA', 'FEC. MODIFICACION', 'USUARIO', 'OBSERVACION' );
        fputcsv($f, $fields, $delimiter);

        //output each row of the data, format line as csv and write to file pointer
        while($row = $query->fetch_assoc()){
            $status = ($row['status'] == '1')?'Active':'Inactive';
            $lineData = array($row['cod_mod'], $row['cod_pag'], $row['rut'], $row['monto_orig'], $row['monto_new'], $row['fecfac_orig'], $row['fecfac_new'], $row['fec_mod'], $row['usuario'], $row['obs']);
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