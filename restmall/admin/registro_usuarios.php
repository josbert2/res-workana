<?php
    include_once('config/conn.php');
    include_once "config/permisos.php";

    session_start();
    $currentPage = "registro_usuarios";
    $rol = $_SESSION['rol'];
    $acceso = getPermisos($currentPage, $rol);
    if(!$acceso){
        header("location: ../login.php");    
    }
    include_once ('est/header.php');

    if(isset($_POST["submit"])){
        if(!empty($_POST['nombre']) && !empty($_POST['password']) && !empty ($_POST['rol'])){
            $nombre   = $_POST['nombre'];
            $password = md5($_POST['password']);
            $rol      = $_POST['rol'];

            $conn  = getConn();
            
            $sql   = "SELECT usuario FROM user WHERE usuario = $nombre;";
            $query = mysqli_query($conn, $sql);
            if(mysqli_num_rows($query) == 0){
                $sql   = "INSERT INTO user(usuario, pass, rol) VALUES ('$nombre', '$password', $rol);";
                $query = mysqli_query($conn, $sql);
                if($query){
                    $msg = "Usuario $nombre registrado en la base de datos.";
                }
                else{
                    $msg = "Error al registrar el usuario $nombre en la base de datos.";
                }
            }
            else{
                $msg = "Error. Usuario $nombre ya existe en la base de datos.";
            }
        }
        elseif(!empty($_POST['nombre']) || !empty($_POST['password']) || !empty($_POST['rol'])){
            $msg = "Para registrar un usuario debe completar todos los campos.";
        }
    }
    else{
        $msg = "";
    }

    function getRoles(){
        $conn  = getConn();
        $sql   = "SELECT cod_rol, nombre FROM roles WHERE estado = 'S';";
        $query = mysqli_query($conn, $sql);
        if(mysqli_num_rows($query) > 0){
            $datos = array();
            while($row = mysqli_fetch_array($query)){
                $datos[] = $row;
            }
            return $datos;
        }
    }

    $roles = getRoles();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rest911 - Registro Usuarios</title>
    <link rel="stylesheet" type="text/css" href="../css/registro_usuarios.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    
    <!-- JQuery -->
    <script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous">
    </script>
    
</head>
<body>
    <?php if($msg != ""){ ?>
        <div id="resp">
            <?php echo $msg ?>
        </div>
    <?php } ?>
    <section>
        <div id="titulo">
            <h1>Registro de Usuarios</h1>
        </div>
        <form method="post">
            <div>
                <label for="nombre">Nombres</label>
                <input class="input" type="text" name="nombre" placeholder="Ingrese Nombre">
            </div>
            <div>
                <label for="password">Contraseña</label>
                <input class="input" type="text" id="password" name="password" placeholder="Ingrese Contraseña">
            </div>
            <div>
                <label for="rol">Rol</label>
                <select class="input" name="rol">
                    <option selected disabled value="">Seleccione Rol</option>
                    <?php foreach($roles as $k => $rol_u){ ?>
                        <?php if($rol_u["cod_rol"] >= $rol){ ?>
                            <option value="<?php echo $rol_u["cod_rol"] ?>"><?php echo $rol_u["nombre"] ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div>
            <br><br>
            <div>
                <input class="button" type="button" id="passGen" onClick="generate();" value="Generar Contraseña">
                <input class="button" type="submit" name="submit" id="submit" value="Registrar">
            </div>
        </form>
    </section>
    
    <script>
        function generate(){
            var chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOP1234567890";
            var pass = "";
            for(var x = 0; x < 12; x++) {
                var i = Math.floor(Math.random() * chars.length);
                pass += chars.charAt(i);
            }
            document.getElementById("password").value = pass;
        }
        
        if(window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>
</html>

<?php
    include_once('est/footerp.php');
?>