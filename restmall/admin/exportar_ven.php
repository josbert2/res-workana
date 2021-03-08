<?php
include_once('config/conn.php');
include('config/modo1.php');
include_once "config/permisos.php";

session_start();
$rol = $_SESSION['rol'];
$currentPage = "vencidos";
$acceso = getPermisos($currentPage, $rol);
if(!$acceso){
    header("location: ../login.php");    
}

function getFecha(){
    date_default_timezone_set("America/Santiago");
    $time  = time();
    $fecha = date("Y-m-d", $time);
    return $fecha;
}

function getFechaYHoraExcel(){
    date_default_timezone_set("America/Santiago");
    $hora = date('Y-m-d_h.i_A');
    return $hora;
}

function filtrarCobro($datos){
    $fecha_actual = getFecha();
    foreach($datos as $k => $cliente){
        $date1 = date_create($fecha_actual);
        $date2 = date_create($cliente["t_fecha_tbk"]);

        $diff1 = date_diff($date1, $date2);
        $diff1 = $diff1->format('%m');

        if(($fecha_actual < $cliente["t_fecha_tbk"]) || ($diff1 < 1)){
            unset($datos[$k]);
        }
        else{
            $datos[$k]["meses"] = $diff1;
        }
    }
    return array_filter($datos);
}

function filtrarClientes($datos){
    $datos = filtrarCobro($datos);
    return $datos;
}

function getClientesI(){
    $conn = getConn();
    $sql  = "SELECT pagos, rut, CAST(fec_pag AS DATE) AS fec_pag, fec_fac as t_fecha_tbk, valor_plan as valor_plan_benef, clase 
            FROM pagos_clientes WHERE ((estado = 'I') AND (fec_fac != 'NULL')) ORDER BY pagos DESC";
    
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0){
        $datos = array();
        while($row = mysqli_fetch_array($query)){
            $datos[] = $row;
        }
        $datos = filtrarClientes($datos);
        return $datos;
    }
    else{
        //die;
        return NULL;
    }
}

function getClientesS(){
    $conn = getConn();
    $sql  = "SELECT pagos_clientes.pagos, pagos_clientes.rut, CAST(pagos_clientes.fec_pag AS DATE) AS fec_pag, 
			pagos_clientes.valor_plan_benef, pagos_clientes.clase as clase,
            CAST(MAX(pagos_transac.t_fecha_tbk) AS DATE) AS t_fecha_tbk FROM pagos_clientes INNER JOIN pagos_transac 
            ON ((pagos_clientes.pagos = pagos_transac.t_cod_pagos) AND (pagos_clientes.estado = 'S')
            AND (pagos_clientes.fec_pag != 'NULL') AND (pagos_clientes.num_mes != 'NULL')
            AND (pagos_transac.t_fec_fac != 'NULL') AND (pagos_transac.t_fecha_tbk != 'NULL')) 
            GROUP BY pagos_clientes.pagos ORDER BY pagos_clientes.pagos DESC";
    
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0){
        $datos = array();
        while($row = mysqli_fetch_array($query)){
            $datos[] = $row; 
        }
        $datos = filtrarClientes($datos);
        return $datos;
    }
    else{
        //die;
        return NULL;
    }
}

function getDatosClientes(){
    $clientesS = getClientesS();
    $clientesI = getClientesI();
    if(($clientesS != NULL) && ($clientesI != NULL)){
        return array_merge($clientesI, $clientesS);
    }
    elseif(($clientesS == NULL) && ($clientesI == NULL)){
        return NULL;
    }
    elseif($clientesS == NULL){
        return $clientesI;
    }
    else{
        return $clientesS;
    }
}

function exportarCSV($datos){
    $delimiter = ";";
    $filename  = "REST911_vencidos_" . getFechaYHoraExcel() .".csv";
    
    $f      = fopen('php://memory', 'w');
    $fields = array('CODIGO', 'CLASE', 'RUT', 'INGRESO SISTEMA', 'MESES RETRASO', 'ULTIMO PAGO', 'MONTO MENSUAL');
    fputcsv($f, $fields, $delimiter);
    
    foreach($datos as $k => $cliente){
        $status = ($cliente['status'] == '1')?'Active':'Inactive';
        $lineData = array($cliente["pagos"], $cliente["clase"], $cliente["rut"], $cliente["fec_pag"], $cliente["meses"], $cliente["t_fecha_tbk"], $cliente["valor_plan_benef"]);
        fputcsv($f, $lineData, $delimiter);
    }
    
    //move back to beginning of file
    fseek($f, 0);
    
    //set headers to download file rather than displayed
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');
    
    //output all remaining data on a file pointer
    fpassthru($f);
    exit;
}

$datos = getDatosClientes();
exportarCSV($datos);
?>