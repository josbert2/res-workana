<?php
session_start();
if(!empty($_SESSION['active'])){
        header('location: admin/index.php');
}else{
    if(isset($_POST['login'])){
        $alert = '';
        if(empty($_POST['user']) || empty($_POST['pass'])){
            $alert = 'Debe ingresar usuario y clave';
            }else{
                require_once "admin/config/conexion.php";
            
                $user = htmlspecialchars(mysqli_real_escape_string($conn,$_POST['user']));
                $pass = md5(mysqli_real_escape_string($conn,$_POST['pass']));
                
                $query = mysqli_query($conn,"SELECT * FROM user WHERE usuario = '$user' AND pass = '$pass'");
                mysqli_close($conn);
                $result = mysqli_num_rows($query);
            
                if($result > 0){
                    $data = mysqli_fetch_array($query);
 
                    $_SESSION['active']  = true;
                    $_SESSION['estado']  = $data['estado'];
                    $_SESSION['rol']     = $data['rol'];
                    $_SESSION['usuario'] = $data['usuario'];
                    $_SESSION['userid']  = $data['userid'];
                    
                    if($_SESSION['estado'] == 'N'){
                    $alert = 'El usuario se encuentra inactivo';
                    session_destroy();    
                    }else{
                    header('location: admin/index.php');
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
    <title>Rest911 - Ingreso</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P7VCFXL"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

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