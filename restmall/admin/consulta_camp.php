<!-- Menu -->
<?php

include_once "config/conexion.php";
include_once "config/permisos.php";

session_start();
$rol = $_SESSION['rol'];
$currentPage = "campana";
$acceso = getPermisos($currentPage, $rol);
if(!$acceso){
    header("location: ../login.php");    
}
include_once ('est/header.php');
?>
<!--POST-->
<?php
    if(!empty($_POST)){
        
/* contador de entradas */
        $sql_register = mysqli_query($conn, "SELECT COUNT(*) as total_registro FROM campania ");
        $result_register = mysqli_fetch_array($sql_register);
        $total_registro = $result_register['total_registro'];
        
        if($total_registro > 0){
            $alert='';
            $empty=0;
        if($empty == 0){
            $num = 1;
            for($num = 1; $num <= $total_registro; $num++){
               $cod_camp        = $_POST['cod_camp'.$num.''];
               $estado         = $_POST['estado'.$num.''];
               
           if(!empty($cod_camp) || !empty($estado)){
               
               $query = mysqli_query($conn,"SELECT * FROM campania WHERE (cod_camp = '$cod_camp') ");
               $result = mysqli_fetch_array($query);
               
               if($result <= 0){
                   $alert='<p class="msg_error">Dato Repetido.</p>';
               }else{
                    $sql_update = mysqli_query($conn,"UPDATE campania SET estado = '$estado' WHERE (cod_camp = '$cod_camp') ");
               
                    if($sql_update){
                            $alert='<p class="msg_save">Campañas Actualizadas Correctamente.</p>';
                    }else{
                            $alert='<p class="msg_error">Error al actualizar estado de campañas.</p>';

                    }
                }
             }
            }   
        }
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
    <title>Consulta de Campañas</title>
    <!-- Stylesheets -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="css/consulta_us.css">
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
                stateSave: true, order: [[ 0, 'desc' ], [ 0, 'asc' ]]
            });
        });
    </script>
</head>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P7VCFXL"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

    <section style="padding:2%;">
        <div style="display: flex; justify-content: space-between;">
	       <h2>Consulta de Campañas</h2>
            <a href="exportar_camp.php" class="btn btn-successR pull-right">Exportar Campañas</a>
	    </div>
        <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
        <form action="" method="post">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead> 
            <tr style="background-color:#0049a2; color: white;">
                <th style="max-width:50px">Cod. Campaña</th>
                <th>Nombre Campaña</th>
                <th>Promocion</th>
                <th>Fecha Inicio</th>
                <th>Fecha Termino</th>
                <th>Usuario</th>
                <th>Descripción</th>
                <th style="max-width:100px">Estado 'S' Activo - 'N' Inactivo</th>
                <th>Acción</th>
            </tr>
        </thead>
<!--CARGAR DATOS-->
        <tbody>
            <?php
            
            $query_2 = mysqli_query($conn, "SELECT CA.cod_camp, CA.nombre, CA.descuento, CA.meses, CA.dias, CA.fec_ini, CA.fec_ter, CA.descripcion, US.usuario, CA.enlace, CA.estado FROM campania CA INNER JOIN user US on CA.user_id = US.userid ORDER BY CA.cod_camp ASC");
            
            mysqli_close($conn);
            $result = mysqli_num_rows($query_2);
            if($result > 0){
                $i = 1;
                while($data = mysqli_fetch_array($query_2)){
            ?>
            
                                <tr id="heading<?php echo $i; ?>">
                                    <td><?php echo $data["cod_camp"]                   ?>
                                    <input class="mininputtable"  type="hidden"    name="cod_camp<?php echo $i?>" id="cod_camp<?php echo $i?>" value="<?php echo $data["cod_camp"]?>">
                                    </td>
                                    <td><?php echo $data["nombre"]                   ?></td>
                                    <td><?php if($data["descuento"] != NULL && $data["meses"] != 0){ echo 'Descuento '.$data["descuento"].'% por '.$data["meses"].' meses'; }elseif($data["descuento"] != NULL && $data["meses"] == 0){ echo 'Descuento '.$data["descuento"].'% permanente'; }elseif($data["dias"] != NULL){ echo 'Gratis por '.$data["dias"].' días'; }
                                        ?></td>
                                    <td><?php $newDate = date("d-m-Y", strtotime($data["fec_ini"]));echo $newDate ?></td>
                                    <td><?php $newDate2 = date("d-m-Y", strtotime($data["fec_ter"]));echo $newDate2 ?></td>
                                    <td><?php echo $data["usuario"]                   ?></td>
                                    <td><?php echo $data["descripcion"]                   ?></td>
                                    <td><select id="estado<?php echo $i?>" name="estado<?php echo $i?>">
                                    <option value="S" <?php if(isset($data['estado']) && $data['estado'] == 'S'){ echo 'selected'; } ?> >S ACTIVO</option>
                                    <option value="N" <?php if(isset($data['estado']) && $data['estado'] == 'N'){ echo 'selected'; } ?> >N INACTIVO</option>
                                    </select></td>
                                    <td><a href="../promo.php?p=<?php echo $data['enlace'] ?>" target="_blank">Ir al sitio</a> | <a href="modificar_camp.php?c=<?php echo $data['cod_camp'] ?>"  style="color:#9ba70b;">Modificar</a></td>
                                </tr>
                                        
                                   
            <?php
                    
                $i++;
                }
            }
            ?>
        </tbody>
        </table>
<!-- BOTONES -->
            <div class="botones">
                <input class="btn_azul" type="reset" value="Reestablecer">
                <input  class="btn_verdello"       type="submit"        name="actualizar"      value="Grabar Estados">
            </div>
            </form>
    </section>
</body>
</html>