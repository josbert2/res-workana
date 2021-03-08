<?php
session_start();
if(!empty($_SESSION['active'])){
    if($_SESSION['rol'] == 1){
        header('location: ocnormal/index.php');
    }
}else{
    if(isset($_POST['login'])){
        $alert = '';
        if(empty($_POST['user']) || empty($_POST['pass'])){
            $alert = 'Debe ingresar usuario y clave';
            }else{
                require_once "ocnormal/config/conexion.php";
            
                $user = mysqli_real_escape_string($conn,$_POST['user']);
                $pass = md5(mysqli_real_escape_string($conn,$_POST['pass']));
                
                $query = mysqli_query($conn,"SELECT * FROM user WHERE usuario = '$user' AND pass = '$pass'");
                mysqli_close($conn);
                $result = mysqli_num_rows($query);
            
                if($result > 0){
                    $data = mysqli_fetch_array($query);
 
                    $_SESSION['active'] = true;
                    $_SESSION['run'] = $data['user'];
                    $_SESSION['rol'] = $data['rol'];
                    
                    if($_SESSION['rol'] == 1){
                        header('location: ocnormal/index.php');
                    }
                }else{
                    $alert = 'El usuario o la clave son incorrectas';
                    session_destroy();
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rest911 OCnormal - Ingreso</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
        <div class="login">
            <img width="216" height="80" src="img/logo.png" class="attachment-large size-large" alt="" style="margin-top: 8%;margin-bottom: 20%;">
            <div class="alert"><?php echo $alert; ?> </div>
            <form method="post">
            <div class="group">
                <input type="text" name="user" placeholder="Usuario" required>
                <i class="fa fa-user"></i>
            </div>
            <div class="group">
                <input type="password" name="pass" placeholder="Contraseña" required>
                <i class="fa fa-lock"></i>
            </div>
            <div class="group2">
            <input type="submit" class="submit-btn" value="Ingresar" name="login">
            </div>
            <p class="fs"></p>
            </form>
        </div>
</body>
</html>