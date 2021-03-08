<!-- Menu -->
<?php
    session_start();
    if($_SESSION['rol'] != 1){
    header("location: ../loginoc.php");    
    }
	$currentPage='cobros';
    include ('est/header.php');
    include_once "config/conexion.php";
    include "config/func.php";
    $fechahoy = getFecha();
    $username_tbk = $_REQUEST['username_tbk'];
?>
<?php
/*if(!empty($_POST)){
    if(!empty($_POST['username_tbk'])){
        $username_tbk = $_POST['username_tbk'];*/
?>
<!-- CONTENIDO PAGINA -->
    <!DOCTYPE html>
<html lang="es">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <title>Consulta de Transacciones</title>
    <link rel="stylesheet" href="../css/transacciones.css">
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <meta http-equiv=”Content-Type” content=”text/html; charset=UTF-8″ />
</head>
<body>
    <section class="formulario">
        <h2>Cobros</h2>
        <form action="" class="form_tbk_user">
            <label for="username_tbk"> Username TBK: </label>
            <input type="input" value="<?php echo $username_tbk ?>" name="username_tbk" id="username_tbk" placeholder="Rut sin Puntos _ N°pago">
            <input type="submit" name="Buscar" class="btn_buscar" value="Buscar">
        </form>
<?php
if(!empty($_REQUEST['username_tbk'])){
        $username_tbk = $_REQUEST['username_tbk'];
        //DATOS DE PAGOS_CLIENTE
        $query_2 = mysqli_query($conn, "SELECT p.pagos, CAST(p.fec_pag AS DATE) as fec_pag, CAST(FEC_PAG AS TIME) as hora, p.t_nombres, p.t_apellido1, p.t_apellido2, p.rut, p.t_fec_nac, p.email, p.telefono, p.telefono2, p.direccion, p.comuna, p.cod_plan, p.nom_plan, p.num_benef, p.valor_plan_benef, p.cod_pago, p.tipo_pago, p.cant_descuento, p.valor_plan, p.clase, CASE 
        WHEN p.estado = 'N' THEN 'SOLO REST911'
        WHEN p.estado = 'E' THEN 'ERROR EN TBK'
        WHEN p.estado = 'R' THEN 'RECHAZA COBRO'
        WHEN p.estado = 'S' THEN 'TRANSACC EXITOSA'
        WHEN p.estado = 'I' THEN 'SUSCRIPCION'
        ELSE 'N/A'
        END AS estado, p.token, p.buyorder,p.authorizationcode, p.creditcardtype, p.last4carddigits, p.tbkuser, p.transactionid, p.username, p.fecha_tbk, p.fec_fac, 
        CASE
        WHEN p.clase = 'A' THEN '(A) Autocontratados'
        WHEN p.clase = 'B' THEN '(B) Inscripción y Cobro'
        WHEN p.clase = 'C' THEN '(C) Solo Inscripción'
        ELSE 'N/A'
        END AS clase, p.observa FROM pagos_clientes p WHERE username = '$username_tbk' ORDER BY p.pagos ASC");
            
        $result = mysqli_num_rows($query_2);
        if($result > 0){
            $i = 1;
            while($data = mysqli_fetch_array($query_2)){
?>
        <table>
            <tr>
                <th>Fecha</th>
                <th>Nombre</th>
                <th>RUT</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </table>
        <div class="accordion" id="accordionExample">
                        <div class="card">
                            <div class="card-header" id="heading<?php echo $i; ?>">
                                <h2 class="mb-0">
                                    <div><?php $newDate = date("d-m-Y", strtotime($data["fec_pag"]));echo $newDate ?></div>
                                    <div><?php echo $data["t_nombres"]." ".$data["t_apellido1"]?></div>
                                    <div><?php echo $data["rut"]?></div>
                                    <div><?php echo $data["email"]?></div>
                                    <div><?php echo $data["telefono"]?></div>
                                    <div><?php echo $data["estado"]?></div>
                                    <div>
                                        <button class="btn btn-link <?php if($i>1) echo "collapsed"; ?>" name="card-title" type="button" data-toggle="collapse" data-target="#collapse<?php echo $i; ?>" aria-expanded="false" aria-controls="collapse<?php echo $i; ?>">
                                            <a class="link_expand">Ver</a>
                                        </button>
                                    </div>
                                </h2>
                            </div>
                            <div id="collapse<?php echo $i; ?>" class="collapse" aria-labelledby="heading<?php echo $i; ?>" data-parent="#accordionExample">
                                <div class="card-body">
                                    <div>
                                        <b>Nombres:</b> <?php echo $data["t_nombres"]?><br>
                                        <b>Apellidos Paterno:</b> <?php echo $data["t_apellido1"]?><br>
                                        <b>Apellido Materno:</b> <?php echo $data["t_apellido2"]?><br>
                                        <b>Fecha de Nacimiento:</b> <?php echo $data["t_fec_nac"]?><br>
                                        <b>Segundo Telefóno:</b> <?php echo $data["telefono2"]?><br>
                                        <b>Comuna:</b> <?php echo $data["comuna"]?><br>
                                        <b>Dirección:</b> <?php echo $data["direccion"]?><br>
                                        <b>Codigo del Plan:</b> <?php echo $data["cod_plan"]?><br>
                                        <b>Nombre del plan:</b> <?php echo $data["nom_plan"]?><br>
                                        <b>Cantidad de Beneficiarios:</b> <?php echo $data["num_benef"]?><br>
                                        <b>Valor:</b> <?php echo $data["valor_plan_benef"]?><br>
                                        <b>Codigo de Pago:</b> <?php echo $data["cod_pago"]?><br>
                                        <b>Tipo de pago:</b> <?php echo $data["tipo_pago"]?><br>
                                        <b>Cantidad de descuento:</b> <?php echo $data["cant_descuento"]?><br>
                                        <b>Valor del Plan:</b> <?php echo $data["valor_plan"]?><br>
                                        <b>Token TBK:</b> <?php echo $data["token"]?><br>
                                        <b>Usuario TBK:</b> <?php echo $data["username"]?><br>
                                        <b>Order de compra</b> <?php echo $data["buyorder"]?><br>
                                        <b>Codigo Autorización TBK:</b> <?php echo $data["authorizationcode"]?><br>
                                        <b>Tipo de tarjeta:</b> <?php echo $data["creditcardtype"]?><br>
                                        <b>Ultimos 4 digitos:</b> <?php echo $data["last4carddigits"]?><br>
                                        <b>Cod. Usuario Transbank:</b> <?php echo $data["tbkuser"]?><br>
                                        <b>Codigo transacción:</b> <?php echo $data["transactionid"]?><br>
                                        <b>Fecha TBK:</b> <?php echo $data["fecha_tbk"]?><br>
                                        <b>Fecha Facturación:</b> <?php echo $data["fec_fac"]?><br>
                                        <b>Tipo de cliente:</b> <?php echo $data["clase"]?><br>
                                        <b>Observaciónes:</b> <?php echo $data["observa"]?><br>
                                    </div>
                                    <div>
                <?php
                /* Datos para generar cobro */
                $tbkuser = $data["tbkuser"];
                $monto   = $data["valor_plan_benef"];
                $pagosid = $data["pagos"];
                
                                                        
                $query_benef = mysqli_query($conn, "SELECT COUNT(*) as cant_benef FROM beneficiarios WHERE pagos = $pagosid");
                $result_benef = mysqli_fetch_array($query_benef);
                $cant_benef = $result_benef["cant_benef"];
                
                $query_3 = mysqli_query($conn, "SELECT b.pagos, b.nombres, b.apellido1, b.apellido2, b.fec_nac, b.cor_benef FROM beneficiarios b WHERE b.pagos = $pagosid ORDER BY b.cor_benef ASC ");
                        
                $results = mysqli_num_rows($query_3);
                if($results > 0){        
                    
                    while($datab = mysqli_fetch_array($query_3)){
                ?>
                
                                    
                                        <b>Beneficiario <?php echo $datab["cor_benef"]?></b><br>
                                        Nombres: <?php echo $datab["nombres"]?> <?php echo $datab["apellido1"]?> <?php echo $datab["apellido2"]?> <br>
                                        Fecha de Nacimiento: <?php echo $datab["fec_nac"]?><br> 
                                    
                <?php 
                    
                       }
                    }
                
                ?>
                                    </div>
                                </div>
                            </div>
                        </div>
            <?php
                
                $i++;
                }
            ?>
        </div>
            <form action="cobro_action.php" method="post" class="form_tbk_user">
            <label for="valor_p"> Valor del Plan: </label>
            <input type="input" value="<?php echo $monto ?>" name="monto" placeholder="Monto a Cobrar">
            <input type="hidden" name="username_tbk" value="<?php echo $username_tbk; ?>">
            <input type="hidden" name="tbkuser" value="<?php echo $tbkuser; ?>">
            <input type="submit" name="cobrar" class="btn_cobrar" value="Cobrar">
        </form>
<?php
        }else{
?>
    <label for="user_no"> Cliente no encontrado </label>    
        
<?php
        }
     }
?>
    </section>
</body>
</html>