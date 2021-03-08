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
include_once ('est/headerc.php');

function getFecha(){
    date_default_timezone_set("America/Santiago");
    $time  = time();
    $fecha = date("Y-m-d", $time);
    return $fecha;
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

$datos = getDatosClientes();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-P7VCFXL');</script>
<!-- End Google Tag Manager -->

    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rest911 - Vencidos</title>
    <link rel="icon" href="../img/logo.png">
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="../css/motorpago.css">
    
    <!-- Libs -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    
    <!-- Datatable -->
    <script>
        $(document).ready(function(){
            var tabla = $('#example').dataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
                },
                stateSave: true,
            });
        });
    </script>
    
</head>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P7VCFXL"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
	<div id="userid" style="display: none;"><?php echo $_SESSION['userid'] ?></div>
    <section style="padding:2%;">
        <div style="display: flex; justify-content: space-between;">
            <h2>Consulta Vencidos</h2>
            <h5>Usuario: <?php echo $_SESSION['usuario']; ?></h5>
        </div>
        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr style="background-color:#0049a2; color: white;">
                    <th>Cod. Cliente</th>
                    <th>Clase</th>
                    <th>RUT</th>
                    <th>Ingreso Sistema</th>
                    <th>Meses Retraso</th>
                    <th>Último pago</th>
                    <th>Monto Mensual</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($datos)){ ?>
                    <?php foreach($datos as $k => $cliente){ ?>
                        <tr>        
                            <td><?php echo $cliente["pagos"]?></td>
                            <td><?php echo $cliente["clase"]?></td>
                            <td><?php echo $cliente["rut"]?></td>
                            <td><?php echo date("d-m-Y", strtotime($cliente["fec_pag"]))?></td>
                            <td><?php echo $cliente["meses"]?></td>
                            <?php if(!empty($cliente["t_fecha_tbk"])){ ?>
                                <td><?php echo date("d-m-Y", strtotime($cliente["t_fecha_tbk"]))?></td>
                            <?php } else{
                                $datos[$k]["t_fecha_tbk"] = "Sin registro."; ?>
                                <td><?php echo $cliente["t_fecha_tbk"]?></td>
                            <?php } ?>
                            <td><?php echo '$'.number_format($cliente["valor_plan_benef"],0,"",".") ?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
        <br>
        <button type="button" class="btn btn-warning" onclick="window.location.href='exportar_ven.php'" >Exportar</button>
    </section>
</body>