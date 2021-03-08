<!-- Menu -->
<?php
    include "config/func.php";
    require('config/modo1.php');
    include_once "config/permisos.php";

    session_start();
    $rol = $_SESSION['rol'];
    $currentPage = "desvincular";
    $acceso = getPermisos($currentPage, $rol);
    if(!$acceso){
        header("location: ../login.php");    
    }
    include_once ('est/header.php');
    //No tocar
    use Transbank\Webpay\Options;
    use Transbank\Webpay\authorize;
    use Transbank\Webpay\Oneclick;
    use Transbank\Webpay\Oneclick\MallInscription;
    use Transbank\Webpay\Oneclick\MallTransaction;
    use Transbank\Webpay\WebpayPlus;

    $fechahoy = getFecha();
    $pagos = $_REQUEST['p'];
?>

<!-- Transbank -->
<?php
if(isset($_POST['tbkuser'])){
    
    $tbkuser  = $_POST['tbkuser'];
    $username = $_POST['username'];
    $pagos    = $_POST['pagosid'];
    $observa  = $_POST['observa'];
try{
    $response = MallInscription::delete($tbkuser, $username, NULL);
    
    if($response->status == 'OK'){
        $title     = "Eliminación Correcta";
        $message   = "El cliente ha sido desvinculado exitosamente";
        echo '<div style="display:none" data-condition id="mensaje"></div>';
        // CAMBIO DE ESTADO EN BASE DE DATOS
        $conn = getConn();
        $sql_registro_d = mysqli_query($conn, "UPDATE pagos_clientes
            SET estado = 'D', responsecode = '$response->code', observa = '$observa'
            WHERE pagos = '$pagos'
            AND ((estado = 'S') OR (estado = 'I')); ");
        mysqli_close($conn);
        if($sql_registro_d){
                $titulo    = "<h2 style='text-align:center;color:green;' >Cliente Desvinculado, Estado Actualizado en Base de datos</h2>";         
            }else{
                $titulo    = "<h2 style='text-align:center;color:red;' >Cliente Desvinculado, El estado no pudo ser actualizado en base de datos</h2>";
            }
        echo '<div style="display:none" data-condition id="mensaje"></div>';
    }else{
        $title     = "Error en Eliminación";
        $message   = "Ha ocurrido un error, el cliente no puedo ser desvinculado, intente más tarde.";
        $titulo    = "<h2 style='text-align:center;color:red;'>Problema al desvincular Cliente</h2>";
        echo '<div style="display:none" data-condition id="mensaje"></div>';
    }
}catch(Exception $e){
        $title     = "Error en Eliminación";
        $message   = "Ha ocurrido un error, el cliente no puedo ser desvinculado, intente más tarde.";
        $titulo    = "<h2 style='text-align:center;color:red;'>Problema al desvincular Cliente</h2>";
        echo '<div style="display:none" data-condition id="mensaje"></div>';
    }
}
?>

<!-- CONTENIDO PAGINA -->
    <!DOCTYPE html>
<html lang="es">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <title>Confirmar Desvinculación Oneclick Mall</title>
    <link rel="stylesheet" href="../css/transacciones.css">
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <!-- BS JavaScript -->
    <script type="text/javascript" src="bootstrap/bootstrap.js"></script>
    <meta http-equiv=”Content-Type” content=”text/html; charset=UTF-8″ />
    <script type="text/javascript">
    $(document).ready(function() {
        if ($('#mensaje').length){
            $('#myModal').modal('show');
        }
    });
    </script>
    
</head>
<body>
    <section class="formulario">
        <h2 style="text-align: left; float: left;">Confirmar Desinscripción</h2>
        <!-- <h2 style="text-align: right; float: right;"><?php echo $_SESSION['usuario'] ?></h2>
        Nombre de usuario a la derecha -->
        <?php echo $titulo ?>
<?php
if(!empty($pagos)){
        //$username_tbk = $_REQUEST['username_tbk'];
        //DATOS DE PAGOS_CLIENTE
        $conn = getConn();
        $query_2 = mysqli_query($conn, "SELECT p.pagos, CAST(p.fec_pag AS DATE) as fec_pag, CAST(FEC_PAG AS TIME) as hora, p.t_nombres, p.t_apellido1, p.t_apellido2, p.rut, p.t_fec_nac, p.email, p.telefono, p.telefono2, p.direccion, p.comuna, p.cod_plan, p.nom_plan, p.num_benef, p.valor_plan_benef, p.cod_pago, p.tipo_pago, p.cant_descuento, p.valor_plan, p.clase, CASE 
        WHEN p.estado = 'S' THEN 'TRANSACC EXITOSA'
        WHEN p.estado = 'I' THEN 'SUSCRIPCION'
        ELSE 'N/A'
        END AS estado, p.token, p.buyorder,p.authorizationcode, p.creditcardtype, p.last4carddigits, p.tbkuser, p.transactionid, p.username, p.fecha_tbk, DATE_ADD(p.fec_fac,INTERVAL '1' MONTH) as fec_fac, 
        CASE
        WHEN p.clase = 'A' THEN '(A) Autocontratados'
        WHEN p.clase = 'B' THEN '(B) Inscripción y Cobro'
        WHEN p.clase = 'C' THEN '(C) Solo Inscripción'
        ELSE 'N/A'
        END AS clase, p.observa FROM pagos_clientes p WHERE pagos = '$pagos' AND (estado = 'I' OR estado = 'S') ORDER BY p.pagos ASC");
        mysqli_close($conn);    
        $result = mysqli_num_rows($query_2);
        if($result > 0){
            $i = 1;
            while($data = mysqli_fetch_array($query_2)){
?>
                                <table>
                                    <tr>
                                        <th>Datos Titular</th>
                                        <th>Beneficiarios</th>
                                    </tr>
                                    <tr align="left">
                                    <td>
                                        <div style="margin-left:50px">
                                        <b>Fecha:</b> <?php $newDate = date("d-m-Y", strtotime($data["fec_pag"]));echo $newDate ?><br>
                                        <b>Codigo:</b> <?php echo $data["pagos"]?><br>
                                        <b>Nombres:</b> <?php echo $data["t_nombres"]." ".$data["t_apellido1"]." ".$data["t_apellido2"]?><br>
                                        <b>Rut:</b> <?php echo $data["rut"]?><br>
                                        <b>Email:</b> <?php echo $data["email"]?><br>
                                        <b>Teléfono:</b> <?php echo $data["telefono"]?><br>
                                        <b>Estado:</b> <?php echo $data["estado"]?><br>
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
                                        <b>Siguiente Facturación:</b> <?php echo $data["fec_fac"]?><br>
                                        <b>Tipo de cliente:</b> <?php echo $data["clase"]?><br>
                                        <b>Observaciónes:</b> <?php echo $data["observa"]?><br>
                                        </div>
                                    </td>
                <?php
                /* Datos para generar desvinculacion */
                $tbkuser    = $data["tbkuser"];
                $username   = $data["username"];
                $pagosid    = $data["pagos"];
                $rut        = $data["rut"];
                
                //Registro edit:
                $observa = "Cliente desvinculado el ".$fechahoy." por el usuario ".$_SESSION['usuario']." -  ".$data["observa"];
                                                        
                $conn = getConn();                                        
                $query_benef = mysqli_query($conn, "SELECT COUNT(*) as cant_benef FROM beneficiarios WHERE pagos = $pagosid");
                mysqli_close($conn); 
                $result_benef = mysqli_fetch_array($query_benef);
                $cant_benef = $result_benef["cant_benef"];
                $conn = getConn();
                $query_3 = mysqli_query($conn, "SELECT b.pagos, b.nombres, b.apellido1, b.apellido2, b.fec_nac, b.cor_benef FROM beneficiarios b WHERE b.pagos = $pagosid ORDER BY b.cor_benef ASC ");
                mysqli_close($conn);        
                $results = mysqli_num_rows($query_3);
                if($results > 0){        
                    
                    while($datab = mysqli_fetch_array($query_3)){
                ?>
                
                                        <td>
                                        <div style="margin-left:50px">
                                            <b>Beneficiario <?php echo $datab["cor_benef"]?></b><br>
                                            Nombres: <?php echo $datab["nombres"]?> <?php echo $datab["apellido1"]?> <?php echo $datab["apellido2"]?> <br>
                                            Fecha de Nacimiento: <?php echo $datab["fec_nac"]?><br> 
                                            </div>
                                        </td>
                                        
                                    
                <?php 
                    
                       }
                    }
                
                ?>
            <?php
                
                $i++;
                }
            ?>
                                        </tr>
                                    </table>
       <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" data-id="<?php echo $data["pagos"]?>">Confirmar Desvinculación</button>-->
        
             <!-- The Modal -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title"><?php echo $title ?></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <p style="color:black;"><?php echo $message ?></p>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <a href="desvincular.php?username_tbk=<?php echo $rut; ?>&Buscar=Buscar" class="btn btn-secondary">Volver</a>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        </div>
        
      </div>
    </div>
  </div>
        <form action="" method="post" class="form_tbk_user" method="post" style="margin:15px;">
            <a href="desvincular.php?username_tbk=<?php echo $rut; ?>&Buscar=Buscar" class="btn btn-secondary" style="margin-right:30px;">Volver a busqueda</a>
            <input type="hidden" name="tbkuser" value="<?php echo $tbkuser; ?>">
            <input type="hidden" name="username" value="<?php echo $username; ?>">
            <input type="hidden" name="pagosid" value="<?php echo $pagosid; ?>">
            <input type="hidden" name="observa" value="<?php echo $observa; ?>">
            <input type="submit" class="btn btn-danger" name="desvincular" value="Confirmar Desvinculación">
        </form>
<?php
        }else{
?>
    <label for="user_no"> Cliente no encontrado en los registros activos. </label>
        <a href="desvincular.php" class="btn btn-secondary">Volver</a>
        
<?php
        }
     }
?>
    </section>
</body>
</html>