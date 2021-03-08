<?php
if(isset($_POST["submit"])){
    $nombre = $_POST['nombre'];
    $fec_ini = $_POST['fec_ini'];
    $fec_ter = $_POST['fec_ter'];
    $descripcion = $_POST['descripcion']; 
    $titulo = $_POST['titulo'];
    $mensaje = $_POST['mensaje'];
    $terminos = $_POST['terminos'];
    $enlace = strtoupper($_POST['enlace']);
    $estado = $_POST['estado'];
    $promo = $_POST['promo'];
    if($_POST['promo'] == 'p_descuento' && !empty($_POST['descuento'])){
        $descuento = $_POST['descuento'];
        $meses = $_POST['c_meses'];
        $dias = 'NULL';
        
    }elseif($_POST['promo'] == 'p_gratis'  && !empty($_POST['dias'])){
        $descuento = 'NULL';
        $meses = ($_POST['dias']/30);
        $dias   = $_POST['dias'];
    }else{
        $msg = "Para registrar una campaña debe completar todos los campos.";
    }
    if($_POST['permanente'] == 'perma'){
        $meses = 0;
    }
    
    if(!empty($_POST['nombre']) && !empty($_POST['promo']) && !empty ($_POST['fec_ini']) && !empty ($_POST['fec_ter']) && !empty ($_POST['enlace']) && !empty ($_POST['estado'])){
            
        $user_id = $_SESSION['userid'];
        $conn  = getConn();
            
            $sql   = "SELECT enlace FROM campania WHERE enlace = '$enlace';";
            $query = mysqli_query($conn, $sql);
            if(mysqli_num_rows($query) == 0){
                $sql   = "INSERT INTO campania(nombre, descuento, meses, dias, fec_ini, fec_ter, user_id, descripcion, titulo, mensaje, terminos, enlace, estado) VALUES ( '$nombre', $descuento, $meses, $dias, STR_TO_DATE('$fec_ini', '%Y-%m-%d'), STR_TO_DATE('$fec_ter', '%Y-%m-%d'), '$user_id', '$descripcion', '$titulo', '$mensaje', '$terminos', '$enlace', '$estado' )";
                $query = mysqli_query($conn, $sql);
                if($query){
                    $msg = "<h2 style='text-align:center;color:green;' >Campaña $nombre registrada exitosamente.<br></h2>";
                    $enla = 1;
                }
                else{
                    $msg = "<h2 style='text-align:center;color:red;' >Error al registrar la campaña $nombre.</h2>";
                    $enla = 0;
                     echo("Error description: " . mysqli_error($conn));
                }
            }
            else{
                $msg = "<h2 style='text-align:center;color:red;' >Error: el enlace $enlace ya pertenece a otra campaña.</h2>";
                $enla = 0;
            }
        }else{
            $msg = "<h2 style='text-align:center;color:DarkOrange;' >Para registrar una campaña debe completar todos los campos.</h2>";
            $enla = 0;
        }
    }
    else{
        $msg = "";
    }

    ?>