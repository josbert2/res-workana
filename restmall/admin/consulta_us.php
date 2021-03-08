<!-- Menu -->
<?php

include_once "config/conexion.php";
include_once "config/permisos.php";

session_start();
$rol = $_SESSION['rol'];
$currentPage = "registro_usuarios";
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
        $sql_register = mysqli_query($conn, "SELECT COUNT(*) as total_registro FROM user WHERE (rol != 1) ");
        $result_register = mysqli_fetch_array($sql_register);
        $total_registro = $result_register['total_registro'];
        
        if($total_registro > 0){
            $alert='';
            $empty=0;
        /*for($i = 1; $i <= $total_registro; $i++){
        if(empty($_POST['userid'.$i.''])       || empty($_POST['estado'.$i.'']))
           {
            $alert='<p class="msg_error">Todos los campos son Obligatorios.</p>';
            $empty = 1;
            break;
           }
        }
        */
        if($empty == 0){
            $num = 1;
            for($num = 1; $num <= $total_registro; $num++){
               $userid        = $_POST['userid'.$num.''];
               $estado         = $_POST['estado'.$num.''];
               
           if(!empty($userid) || !empty($estado)){
               
               $query = mysqli_query($conn,"SELECT * FROM user WHERE ((userid = '$userid') AND (rol != 1)) ");
               $result = mysqli_fetch_array($query);
               
               if($result <= 0){
                   $alert='<p class="msg_error">Dato Repetido.</p>';
               }else{
                    $sql_update = mysqli_query($conn,"UPDATE user SET estado = '$estado' WHERE ((userid = '$userid') AND (rol != 1)) ");
               
                    if($sql_update){
                            $alert='<p class="msg_save">Usuarios Actualizados Correctamente.</p>';
                    }else{
                            $alert='<p class="msg_error">Error al actualizar los usuarios.</p>';

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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Consulta Usuarios</title>
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
                stateSave: true, order: [[ 2, 'asc' ], [ 0, 'asc' ]]
            });
        });
    </script>
</head>
<body>
    <section style="padding:2%;">
        <div style="display: flex; justify-content: space-between;">
	       <h2>Consulta de Usuarios</h2>
            <a href="exportar_us.php" class="btn btn-successR pull-right">Exportar Usuarios</a>
	    </div>
        <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
        <form action="" method="post">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead> 
            <tr style="background-color:#0049a2; color: white;">
                <th>Cod. Usuario</th>
                <th>Usuario</th>
                <th>Cod.Rol</th>
                <th>Nombre Rol</th>
                <th>Estado 'S' Activo - 'N' Inactivo</th>
            </tr>
        </thead>
<!--CARGAR DATOS-->
        <tbody>
            <?php
            
            $query_2 = mysqli_query($conn, "SELECT US.userid, US.usuario, US.rol, RL.nombre, US.estado FROM user US INNER JOIN roles RL on US.rol = RL.cod_rol WHERE ( ( (RL.estado = 'S' AND US.estado = 'S') OR (RL.estado = 'S' AND US.estado = 'N') ) AND (US.rol != 1) AND (US.rol >= '$rol' ) ) ORDER BY US.rol ASC");
            
            mysqli_close($conn);
            $result = mysqli_num_rows($query_2);
            if($result > 0){
                $i = 1;
                while($data = mysqli_fetch_array($query_2)){
            ?>
            
                                <tr id="heading<?php echo $i; ?>">
                                    <td><?php echo $data["userid"]                   ?>
                                    <input class="mininputtable"  type="hidden"    name="userid<?php echo $i?>" id="userid<?php echo $i?>" value="<?php echo $data["userid"]?>">
                                    </td>
                                    <td><?php echo $data["usuario"]                   ?></td>
                                    <td><?php echo $data["rol"]                       ?></td>
                                    <td><?php echo $data["nombre"]                 ?></td>
                                    <td><select id="estado<?php echo $i?>" name="estado<?php echo $i?>">
        <option value="S" <?php if(isset($data['estado']) && $data['estado'] == 'S'){ echo 'selected'; } ?> >S ACTIVO</option>
        <option value="N" <?php if(isset($data['estado']) && $data['estado'] == 'N'){ echo 'selected'; } ?> >N INACTIVO</option>
      </select></td>
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
                <input  class="btn_verdello"       type="submit"        name="actualizar"      value="Actualizar Estados">
            </div>
            </form>
    </section>
</body>
</html>