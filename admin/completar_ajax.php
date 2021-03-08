<?php
include_once('config/conn.php');
include('config/modo1.php');
include_once "config/permisos.php";

session_start();
$rol = $_SESSION['rol'];
$currentPage = "completar";

$acceso = getPermisos($currentPage, $rol);
if(!$acceso){
    header("location: ../login.php");    
}

if(isset($_POST['function'])){
    if($_POST['function'] == 'getDatos' && !empty($_POST['id'])){
        $id    = $_POST['id'];
        $datos = array();
        
        $conn  = getConn();
        $sql   = "SELECT t_nombres, t_apellido1, rut, email, telefono, num_benef FROM pagos_clientes WHERE pagos = $id;";
        $query = mysqli_query($conn, $sql);
        if(mysqli_num_rows($query) > 0){
            while($row = mysqli_fetch_assoc($query)){
                $datos[] = $row; 
            }
        }
        echo json_encode($datos[0]);
    }
    
    elseif($_POST['function'] == 'setCliente'){
        $id         = $_POST['id'];
        $userid     = $_POST['userid'];
        $nombre     = $_POST['nombre'];
        $apellido_p = $_POST['apellido_p'];
        $apellido_m = $_POST['apellido_m'];
        $rut        = $_POST['rut'];
        $email      = $_POST['email'];
        $fono_p     = "56".$_POST['fono_p'];
        $fono_s     = "56".$_POST['fono_s'];
        $direccion  = $_POST['direccion'];
        $fec_nac    = $_POST['fec_nac'];
        $benefs     = $_POST['benefs'];
        
        $conn  = getConn();
        $sql   = "UPDATE pagos_clientes SET t_nombres = '$nombre', t_apellido1 = '$apellido_p',
                  t_apellido2 = '$apellido_m', rut = '$rut', email = '$email', telefono = '$fono_p', 
                  telefono2 = '$fono_s', direccion = '$direccion', t_fec_nac = '$fec_nac', userid = $userid WHERE pagos = $id;";
        $query = mysqli_query($conn, $sql);
        
        if($query){
            $error = false;
            foreach($benefs as $k => $benef){
                $sql   = "INSERT INTO beneficiarios(pagos, nombres, apellido1, apellido2, fec_nac, cor_benef) 
                          VALUES ($id, '$benef[0]', '$benef[1]', '$benef[2]', '$benef[3]', $k + 1);";
                $query = mysqli_query($conn, $sql);
                if(!$query){
                    $error = true;
                }
            }
            if(!$error){
                //echo "NICE";
                echo "Datos del cliente actualizados correctamente";
            }
            else{
                //echo ("Error description: " . mysqli_error($conn));
                echo "Error al registrar los beneficiarios en la base de datos";
            }
        }
        else{
            echo "Error al conectarse con la base de datos";
        }
    }
}