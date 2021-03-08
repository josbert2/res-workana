<?php
include "config/func.php"; 
include_once "config/permisos.php";
require_once 'consulta_sql.php';

session_start();
$rol = $_SESSION['rol'];
$currentPage = "consulta_t"; 
$acceso = getPermisos($currentPage, $rol);
if(!$acceso){
    header("location: ../login.php");    
}
include_once ('est/header.php');

$fechahoy = getFecha();

//DATOS DE BUSQUEDA
if(empty($_REQUEST['transc'])){
    $transc = 'T';
}else{
    $transc = $_REQUEST['transc'];
    }
if( (empty($_REQUEST['bdesde'])) OR (empty($_REQUEST['bhasta'])) ){
    $bdesde = $fechahoy;
    $bhasta = $fechahoy;
    }else{
    $bdesde = strtolower($_REQUEST['bdesde']);
    $bhasta = strtolower($_REQUEST['bhasta']);
}

$nave = "?bdesde=$bdesde&bhasta=$bhasta&transc=$transc";
$datos = getTransc($transc,$bdesde,$bhasta);
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

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rest911 - Consulta de Cobros</title>
    <!--<link rel="icon" href="../img/logo.png">-->
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <style>
    body{
    font-family: Arial, Helvetica, sans-serif;
    }
    .form_search{
        display: flex;
        float:right;
        background: initial;
        padding-right: 10px;
        border-radius: 10px;
    }
    .formulario{
       /* padding-bottom: 10%; */
        width: 95%;
        margin-left: 2%;
        margin-top: 2%;
        margin-bottom: 2%;
    }
    .btn-success{
        float: left;
        position: relative;
        color: #000;
        background-color: #d7e811;
        border-color: #d7e811;
        margin-left: 5px;
        border-radius: 10px;
        margin-bottom: 20px;
    }
    .inputsss{
        margin: 5px;
        text-align: center;
    }
    label {
        margin-left: 3px;
        }
    </style>
    <!-- Libs -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
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

 <section class="formulario">
    <h2>Consulta de Cobros</h2>
     <a href="exportar_reg.php<?php echo $nave ?>" class="btn btn-success" target="_blank">Exportar Registros</a>
    <form action="" method="get" class="form_search">
            <div class="inputsss">
            <input type="radio" name="transc" <?php if (isset($transc) && $transc=="T") echo "checked";?> value="T"><label for="solo_t"> Todos</label></div>
            <div class="inputsss">
            <input type="radio" name="transc" <?php if (isset($transc) && $transc=="A") echo "checked";?> value="A"><label for="solo_a"> Transacciones Exitosas</label></div>
            <div class="inputsss">
            <input type="radio" name="transc" <?php if (isset($transc) && $transc=="F") echo "checked";?> value="F"><label for="solo_f"> Transacciones Fallidas</label></div>
            <!--<div class="inputsss">
            <input type="radio" name="transc" <?php if (isset($transc) && $transc=="M") echo "checked";?> value="M"><label for="solo_m"> Clientes Morosos</label></div>-->
            <div class="inputsss">
            <label for="busqueda">Desde: </label>
            <input type="date" step="1" min="2020-04-01" max="<?php echo date("Y-m-d");?>" value="<?php echo $bdesde ?>" name="bdesde" id="bdesde" placeholder="Desde">
            </div>
            <div class="inputsss">
            <label for="hasta"> Hasta: </label>
            <input type="date" step="1" min="2020-04-01" max="<?php echo date("Y-m-d");?>" value="<?php echo $bhasta ?>" name="bhasta" id="bhasta" placeholder="Hasta">
            </div>
            <input type="submit" name="Buscar" class="btn btn-primary" value="Buscar">
    </form>
</section>
<?php  if($transc == "A"){ ?>
    <section style="padding:2%;">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr style="background-color:#0049a2; color: white;">
                    <th>Cod. Transac</th>
                    <th>Cod. Cliente</th>
                    <th>Clase</th>
                    <th style="min-width:100px">Rut Cliente</th>
                    <th>Última Facturación</th>
                    <th>Fecha Transacción</th>
                    <th>Monto</th>
                    <th>Orden de Compra</th>
                    <th>Cod. Autorización</th>
                    <th>Tipo Pago</th>
                    <th>Usuario</th>
                    <th>Observación</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($datos)){ ?>
                    <?php foreach($datos as $k => $cliente){ ?>
                        <tr>        
                            <td><?php echo $cliente["t_cod_tran"]                   ?></td>
                            <td><?php echo "CC.".$cliente['pagos'].""               ?></td>
                            <td><?php echo $cliente["clase"]                        ?></td>
                            <td><?php echo $cliente["rut"]                          ?></td>
                            <td><?php $newDate = date("d-m-Y", strtotime($cliente["t_fec_fac"]));echo $newDate ?></td>
                            <td><?php $newDate2 = date("d-m-Y H:i:s", strtotime($cliente["t_fecha_tbk"]));echo $newDate2 ?></td>
                            <td><?php echo '$'.number_format($cliente["t_val_plan"],0,"",".") ?></td>
                            <td><?php echo $cliente["t_buyorder"]                   ?></td>
                            <td><?php echo $cliente["t_authorizationcode"]          ?></td>
                            <td><?php echo $cliente["t_payment_type_code"]          ?></td>
                            <td><?php echo $cliente["usuario"]                      ?></td>
                            <td><?php echo $cliente["t_observa"]                    ?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
    </section>
<?php }elseif($transc == "F"){ ?>
    <section style="padding:2%;">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr style="background-color:#0049a2; color: white;">
                    <th>Cod. Fallida</th>
                    <th>Cod. Cliente</th>
                    <th>Clase</th>
                    <th style="min-width:100px">Rut Cliente</th>
                    <th>Última Facturación</th>
                    <th>Fecha Rechazo</th>
                    <th>Monto</th>
                    <th>Orden de Compra</th>
                    <th>Tipo Pago</th>
                    <th>Usuario</th>
                    <th>Error</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($datos)){ ?>
                    <?php foreach($datos as $k => $cliente){ ?>
                        <tr>        
                            <td><?php echo $cliente["f_cod_fall"]                   ?></td>
                            <td><?php echo "CC.".$cliente['pagos'].""               ?></td>
                            <td><?php echo $cliente["clase"]                        ?></td>
                            <td><?php echo $cliente["rut"]                          ?></td>
                            <td><?php $newDate3 = date("d-m-Y", strtotime($cliente["f_fec_fac"]));echo $newDate3 ?></td>
                            <td><?php $newDate4 = date("d-m-Y H:i:s", strtotime($cliente["t_fecha_tbk"]));echo $newDate4 ?></td>
                            <td><?php echo '$'.number_format($cliente["f_val_plan"],0,"",".") ?></td>
                            <td><?php echo $cliente["f_buyorder"]                   ?></td>
                            <td><?php echo $cliente["f_payment_type_code"]          ?></td>
                            <td><?php echo $cliente["usuario"]                      ?></td>
                            <td><?php echo $cliente["f_log"]                        ?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
    </section>
<?php }elseif($transc == "M"){ ?>
    <section style="padding:2%;">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr style="background-color:#0049a2; color: white;">
                    <th>Cod. Cliente</th>
                    <th>Clase</th>
                    <th>Fecha Facturación</th>
                    <th>Fecha Moroso</th>
                    <th>Nombre</th>
                    <th style="min-width:100px">Rut Cliente</th>
                    <th>Correo</th>
                    <th>Telefono</th>
                    <th>Valor Plan</th>
                    <th>Usuario</th>
                    <th>Observación</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($datos)){ ?>
                    <?php foreach($datos as $k => $cliente){ ?>
                        <tr>        
                            <td><?php echo "CC.".$cliente['pagos'].""                       ?></td>
                            <td><?php echo $cliente["clase"]                                ?></td>
                            <td><?php $newDate6 = date("d-m-Y", strtotime($cliente["f_fec_fac"]));echo $newDate6 ?></td>
                            <td><?php $newDate7 = date("d-m-Y H:i:s", strtotime($cliente["t_fecha_tbk"]));echo $newDate7 ?></td>
                            <td><?php echo $cliente["t_nombres"]." ".$cliente["t_apellido1"]?></td>
                            <td><?php echo $cliente["rut"]                                  ?></td>
                            <td><?php echo $cliente["email"]                                ?></td>
                            <td><?php echo $cliente["telefono"]                             ?></td>
                            <td><?php echo '$'.number_format($cliente["f_val_plan"],0,"",".") ?></td>
                            <td><?php echo $cliente["usuario"]                              ?></td>
                            <td><?php echo $cliente["f_log"]                                ?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
    </section>
<?php }else{ ?>
    <section style="padding:2%;">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr style="background-color:#0049a2; color: white;">
                    <th>Cod. Tran/Rchz</th>
                    <th>Cod. Cliente</th>
                    <th>Clase</th>
                    <th style="min-width:100px">Rut Cliente</th>
                    <th>Última Facturación</th>
                    <th>Fecha Tran/Rchz</th>
                    <th>Monto</th>
                    <th>Orden de Compra</th>
                    <th>Cod. Autorización</th>
                    <th>Tipo Pago</th>
                    <th>Usuario</th>
                    <th>Observación/Error</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($datos)){ ?>
                    <?php foreach($datos as $k => $cliente){ ?>
                        <tr>        
                            <td><?php echo $cliente["t_cod_tran"]                   ?></td>
                            <td><?php echo "CC.".$cliente['pagos'].""               ?></td>
                            <td><?php echo $cliente["clase"]                        ?></td>
                            <td><?php echo $cliente["rut"]                          ?></td>
                            <td><?php $newDate7 = date("d-m-Y", strtotime($cliente["t_fec_fac"]));echo $newDate7 ?></td>
                            <td><?php $newDate7 = date("d-m-Y H:i:s", strtotime($cliente["t_fecha_tbk"]));echo $newDate7 ?></td>
                            <td><?php echo '$'.number_format($cliente["t_val_plan"],0,"",".") ?></td>
                            <td><?php echo $cliente["t_buyorder"]                   ?></td>
                            <td><?php if($cliente["t_authorizationcode"] != NULL){ echo $cliente["t_authorizationcode"]; }else{ echo "Cobro Fallido"; }?></td>
                            <td><?php echo $cliente["t_payment_type_code"]          ?></td>
                            <td><?php echo $cliente["usuario"]                      ?></td>
                            <td><?php echo $cliente["t_observa"]                    ?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
    </section>
<?php } ?>
</body>