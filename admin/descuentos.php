<!-- Menu -->
<?php
    include_once "config/conexion.php";
    include_once "config/permisos.php";

    session_start();
    $rol = $_SESSION['rol'];
    $currentPage = "descuentos";
    $acceso = getPermisos($currentPage, $rol);
    if(!$acceso){
        header("location: ../login.php");    
    }
    include_once ('est/header.php');
?>
<!--POST-->
<?php
    if(isset($_POST['actualizar'])){
        
/* contador de entradas */
        $sql_register = mysqli_query($conn, "SELECT COUNT(*) as total_registro FROM tipopago ");
        $result_register = mysqli_fetch_array($sql_register);
        $total_registro = $result_register['total_registro'];
        
        if($total_registro > 0){
            $alert='';
            $empty=0;
        for($i = 1; $i <= $total_registro; $i++){
        if(empty($_POST['cod_pago'.$i.''])       || empty($_POST['nom_pago'.$i.''])           ||
           empty($_POST['num_mes'.$i.''])        || empty($_POST['descuento'.$i.''])          ||
           empty($_POST['est_pago'.$i.'']))
           {
            $alert='<p class="msg_error">Todos los campos son Obligatorios.</p>';
            $empty = 1;
            break;
           }
        }
        if($empty == 0){
               $num = 1;
               for($num = 1; $num <= $total_registro; $num++){
                   $cod_pago        = $_POST['cod_pago'.$num.''];
                   $num_mes         = $_POST['num_mes'.$num.''];
                   $nom_pago        = $_POST['nom_pago'.$num.''];
                   $descuento       = $_POST['descuento'.$num.''];
                   $est_pago        = $_POST['est_pago'.$num.''];

               
               $query = mysqli_query($conn,"SELECT * FROM tipopago WHERE cod_pago = '$cod_pago' ");
               $result = mysqli_fetch_array($query);
               
               if($result <= 0){
                   $alert='<p class="msg_error">dato repetido.</p>';
               }else{
                    $sql_update = mysqli_query($conn,"UPDATE tipopago SET num_mes = '$num_mes', nom_pago = '$nom_pago', descuento = '$descuento', est_pago = '$est_pago' WHERE cod_pago = '$cod_pago' ");
                    
               
                if($sql_update){
                    $alert='<p class="msg_save">Descuento actualizado correctamente.</p>';
                }else{
                    $alert='<p class="msg_error">Error al actualizar el descuento.</p>';
                
                }
               }
            }   
        }
    }
}
if(isset($_POST['boton_aut'])){
    if(!empty($_POST['codaut'])){
        
        $pass = $_POST['codaut'];
        $sql_update = mysqli_query($conn,"UPDATE user SET pass = MD5('$pass') WHERE userid = 0 ");
               
        if($sql_update){
            $alert2='<p class="msg_save">Código de autorización actualizado corretamente.</p>';
        }else{
            $alert2='<p class="msg_error">Error al actualizar el código de autorización.</p>';
        }
    }else{
        $alert2='<p class="msg_error">Error al actualizar el codigo de autorización.</p>';
            
    }
}
?>
<!-- CONTENIDO PAGINA -->
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
    <title>Descuentos</title>
    <link rel="stylesheet" href="../css/transacciones.css">
    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script> 
</head>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P7VCFXL"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

    <section class="formulario">
        <h2s>Descuentos</h2s><br>
        <a href="exportar_tp.php" class="btn btn-successR pull-right">Exportar descuentos activos</a>
        <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
        <form action="" method="post">
        <table>
            <tr>
                <th WIDTH=65px;>Cod</th>
                <th>Nombre de pago</th>
                <th>Cantidad de meses</th>
                <th>Descuento (multiplo)</th>
                <th>Activo S <br> Inactivo N</th>
            </tr>
<!--CARGAR DATOS-->
            <?php
            
            $query_2 = mysqli_query($conn, "SELECT tp.cod_pago, tp.num_mes, tp.nom_pago, tp.descuento, tp.est_pago FROM tipopago tp ORDER BY tp.cod_pago ASC");
            
            mysqli_close($conn);
            $result = mysqli_num_rows($query_2);
            if($result > 0){
                $i = 1;
                while($data = mysqli_fetch_array($query_2)){
                    if($data["cod_pago"] != 22222){
            ?>
            
                                <tr id="heading<?php echo $i; ?>">
                                    <td WIDTH=25px;><input class="mininputtable"  type="text"    name="cod_pago<?php echo $i?>" id="cod_pago<?php echo $i?>" value="<?php echo $data["cod_pago"]?>" readonly>
                                    </td>
                                    <td><input  class="inputtable"  type="text"    name="nom_pago<?php echo $i?>"     id="nom_pago<?php echo $i?>"     placeholder="Ingrese nombre del pago"     value="<?php echo $data["nom_pago"]?>"   required></td>
                                    <td><input  class="inputtable"  type="text"    name="num_mes<?php echo $i?>"     id="num_mes<?php echo $i?>"     placeholder="Ingrese cantidad de meses"     value="<?php echo $data["num_mes"]?>"   required>
                                    </td>
                                    <td><input  class="inputtable"  type="text"    name="descuento<?php echo $i?>"     id="descuento<?php echo $i?>"     placeholder="Ingrese descuento (multiplo)"     value="<?php echo $data["descuento"]?>"   required></td>
                                    <td><input  class="inputtable"  type="text"    name="est_pago<?php echo $i?>"     id="est_pago<?php echo $i?>"     placeholder="s ACTIVADO - n DESACTIVADO"     value="<?php echo $data["est_pago"]?>"   required></td>
                                </tr>
                                        
                                   
            <?php
                    }
                $i++;
                }
            }
            ?>
            </table>
<!-- BOTONES -->
            <div class="botones">
                <input class="btn_azul" type="reset" value="Reestablecer">
                <input  class="btn_verdello"       type="submit"        name="actualizar"      value="Actualizar Descuentos">
            </div>
            </form>
    </section>
<!-- CLAVE DE AUTH -->
        <section class="formulario">
        <h2s>Modificar Código de Autorización Reversas</h2s><br>
        <div class="alert"><?php echo isset($alert2) ? $alert2 : ''; ?></div>
        <form action="" method="post">
<!-- BOTONES -->
            <div class="botones">
                <input  class="inputtable2"  type="text"    name="codaut"     id="codaut"     placeholder="Ingrese Nuevo Codigo de Autorización"     value=""   required>
                <input  class="btn_verdello"       type="submit"        name="boton_aut"      value="Actualizar Código de Autorización">
            </div>
            </form>
    </section>
</body>
</html>

<?php
    include_once('est/footerp.php');
?>