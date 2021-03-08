<?php
    include_once "config/permisos.php";
    include_once "config/func.php";

    session_start();
    $currentPage = "campana";
    $rol = $_SESSION['rol'];
    $acceso = getPermisos($currentPage, $rol);
    if(!$acceso){
        header("location: ../login.php");    
    }
    include_once ('est/header.php');

//RECIBIR CAMPAÑA
$cod_camp = $_REQUEST['c'];
$conn  = getConn();
$fechahoy = getFecha();

// ACTUALIZAR DATOS
if(isset($_POST["submit"])){

    $nombre = $_POST['nombre'];
    $fec_ini = $_POST['fec_ini'];
    $fec_ter = $_POST['fec_ter'];
    $descripcion = $_POST['descripcion']; 
    $titulo = $_POST['titulo'];
    $mensaje = $_POST['mensaje'];
    $terminos = $_POST['terminos'];
    $estado = $_POST['estado'];
    
    if(!empty($_POST['descuento']) && empty($_POST['dias'])){
        $descuento = $_POST['descuento'];
        $meses = $_POST['c_meses'];
        $dias = 'NULL';
        
    }elseif(empty($_POST['descuento']) && !empty($_POST['dias'])){
        $descuento = 'NULL';
        $meses = ($_POST['dias']/30);
        $dias   = $_POST['dias'];
    }else{
        $msg2 = "Para registrar una campaña debe completar todos los campos.";
    }
    
    if($_POST['permanente'] == 'perma'){
        $meses = 0;
    }
    
    if(!empty($_POST['nombre']) && !empty ($_POST['fec_ini']) && !empty ($_POST['fec_ter']) && !empty ($_POST['estado'])){
    $user_id = $_SESSION['userid'];
        
        $sql   = "UPDATE campania SET nombre = '$nombre', descuento = $descuento, meses = $meses, dias = $dias, fec_ini = STR_TO_DATE('$fec_ini', '%Y-%m-%d'), fec_ter = STR_TO_DATE('$fec_ter', '%Y-%m-%d'), descripcion = '$descripcion', titulo = '$titulo', mensaje = '$mensaje', terminos = '$terminos', estado = '$estado', user_id = $user_id WHERE cod_camp = $cod_camp ";
        $query = mysqli_query($conn, $sql);
        if($query){
            $msg = "<h2 style='text-align:center;color:green;' >Campaña $nombre actualizada exitosamente.<br></h2>";
            $enla = 1;
        }else{
            $msg = "<h2 style='text-align:center;color:red;' >Error al actualizar la campaña $nombre.</h2>";
            $enla = 0;
            //echo("Error description: " . mysqli_error($conn));
            }
    }else{
        $msg = "<h2 style='text-align:center;color:DarkOrange;' >Para actualizar la campaña debe completar todos los campos.</h2>";
        $enla = 0;
    }
}

// TRAER DATOS

$query_2 = mysqli_query($conn, "SELECT CA.nombre, CA.descuento, CA.meses, CA.dias, CA.fec_ini, CA.fec_ter, CA.descripcion, US.usuario, CA.enlace, CA.estado, CA.titulo, CA.mensaje, CA.terminos FROM campania CA INNER JOIN user US on CA.user_id = US.userid WHERE cod_camp = $cod_camp ORDER BY CA.cod_camp ASC");
            
mysqli_close($conn);
$result = mysqli_num_rows($query_2);
if($result > 0){
    $data = mysqli_fetch_array($query_2);
}else{
    $msg = "<h2 style='text-align:center;color:red;' >Error: Campaña no encontrada</h2>";
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
    <title>Rest911 - Modificar Campaña</title>
    <link rel="stylesheet" type="text/css" href="../css/registro_camp.css">
    <!--<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">-->
    
    <!-- JQuery -->
    <script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous">
    </script>
<!-- Copiar JS -->
    <script>
            function copyToClipboard(elemento) {
  var $temp = $("<input>")
  $("body").append($temp);
  $temp.val($(elemento).text()).select();
  document.execCommand("copy");
  $temp.remove();
}
            </script>
    
</head>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P7VCFXL"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

    <?php if($msg != ""){ ?>
        <div id="resp">
            <?php echo $msg ?>
            <?php if($enla == 1){ ?>
            <label for="sitio">Sitio de Campaña:</label>
                    <input class="inputs" type="text" id="sitio" name="sitio" value="https://planes.rest911.cl/promo.php?p=<?php echo $data["enlace"] ?>" readonly><button class="button inputs"  onclick="copyToClipboard('#sitio2')">Copiar </button>
            <div style="visibility: hidden"><p id="sitio2">https://planes.rest911.cl/promo.php?p=<?php echo $data["enlace"] ?></p> </div>
            <?php } ?>
        </div>
    <?php } ?>
    <section>
        <!--<div id="titulo">
            <h1>Modificar Campaña <?php echo $meses ?></h1>
        </div>-->
        <div style="display: flex; justify-content: space-between;">
            <h2>Modificar Campaña</h2>
            <h5>Usuario: <?php echo $_SESSION['usuario']; ?></h5>
            <h5 id="usuario" style="display: none;"><?php echo $_SESSION['userid']; ?></h5>
        </div>
        <form method="post">
            <div>
                <label for="nombre">Nombre de Campaña</label>
                <input class="inputs" type="text" name="nombre" placeholder="Ingrese Nombre" value="<?php if(isset($data["nombre"])){ echo $data["nombre"]; } ?>" required>
            </div>
            <div>
                <?php if(!empty($data["descuento"]) && empty($data["dias"])){ ?>
                <label for="descuento">Promoción con Descuento</label>
                <input class="inputs" type="number" onKeyDown="if(this.value.length==2) return false;" min="1" max="99" step="1" name="descuento" id="descuento" value="<?php if(isset($data["descuento"])){ echo $data["descuento"]; } ?>" placeholder="Ingrese el descuento en porcentual">
                <input class="inputs" type="number" type="number" onKeyDown="if(this.value.length==2) return false;" min="1" max="99" step="1" name="c_meses" id="c_meses" value="<?php if(isset($data["meses"]) && $data["meses"] != 0 ){ echo $data["meses"]; } ?>" placeholder="Ingrese cantidad de meses con descuento" <?php if($data["meses"] == 0){ echo 'disabled'; } ?> >
                <label for="permanente">
                <input type="checkbox" id="permanente" name="permanente" value="perma" <?php if($data["meses"] == 0){ echo 'checked'; } ?> >Descuento Permanente
                </label>
                  <?php  }elseif(empty($data["descuento"]) && !empty($data["meses"]) && !empty($data["dias"])){ ?>
                <label for="dias">Prueba Gratis</label>
                <select class="selects" name="dias" id="dias">
                       <option disabled="true" selected="selected" >Seleccione cantidad de días de prueba</option>
                       <option value="30" <?php if(isset($data["dias"]) && $data["dias"] == 30 ){ echo 'selected="selected"'; } ?> >30 Días</option>
                       <option value="60" <?php if(isset($data["dias"]) && $data["dias"] == 60 ){ echo 'selected="selected"'; } ?> >60 Días</option>
                       <option value="90" <?php if(isset($data["dias"]) && $data["dias"] == 90 ){ echo 'selected="selected"'; } ?> >90 Días</option>
                </select>
                <?php } ?>
            </div>
            <div>
                <label for="fec_ini">Fecha de Inicio</label>
                <input class="inputs" type="date" name="fec_ini" value="<?php if(isset($data["fec_ini"])){ echo $data["fec_ini"]; } ?>" placeholder="Ingrese fecha de inicio de la campaña" required>
            </div>
            <div>
                <label for="fec_ter">Fecha de Termino</label>
                <input class="inputs" type="date" name="fec_ter" min="<?php echo $fechahoy; ?>" value="<?php if(isset($data["fec_ter"])){ echo $data["fec_ter"]; } ?>" placeholder="Ingrese fecha de termino de la campaña" required>
            </div>
            <div>
                <label for="descripcion">Descripción</label>
                <textarea class="inputs" type="text" name="descripcion" cols="40" rows="5" placeholder="Ingrese una descripción interna de la campaña" onkeypress="if (this.value.length > 1000) { return false; }"><?php if(isset($data["descripcion"])){ echo $data["descripcion"]; } ?></textarea>
            </div>
            <div class="dropdown-divider"></div>
            <h1>Información Web</h1>
            <div>
                <label for="titulo">Titulo</label>
                <input class="inputs" type="text" name="titulo" maxlength="70" value="<?php if(isset($data["titulo"])){ echo $data["titulo"]; } ?>" placeholder="Ingrese titulo de sitio web campaña (Máximo 70 Caracteres)" required>
            </div>
            <div>
                <label for="mensaje">Mensaje</label>
                <textarea class="inputs" type="text" name="mensaje" cols="60" rows="5" placeholder="Ingrese mensaje a mostrar en sitio web campaña (Máximo 700 Caracteres)" onkeypress="if (this.value.length > 700) { return false; }" required><?php if(isset($data["mensaje"])){ echo $data["mensaje"]; } ?></textarea>
            </div>
            <div>
                <label for="terminos">Terminos</label>
                <textarea class="inputs" type="text" name="terminos" cols="40" rows="5" placeholder="Ingrese T&C para sitio web campaña (Máximo 360 Caracteres)" onkeypress="if (this.value.length > 360) { return false; }"><?php if(isset($data["terminos"])){ echo $data["terminos"]; } ?></textarea>
            </div>
            <div>
                <label for="enlace">Enlace (ejemplo: CYBERDAY)</label>
                <input class="inputs" type="text" name="enlace" value="<?php if(isset($data["enlace"])){ echo $data["enlace"]; } ?>" placeholder="Ingrese nombre del enlace" required disabled>
            </div>
            <div>
                <label for="estado">Estado</label>
                <select class="inputs" name="estado" required>
                    <option selected disabled value="">Seleccione estado inicial de la campaña</option>
                            <option value="S" <?php if(isset($data["estado"]) && $data["estado"] == 'S'){ echo 'selected="selected"'; } ?> >Activa</option>
                            <option value="N" <?php if(isset($data["estado"]) && $data["estado"] == 'N'){ echo 'selected="selected"'; } ?> >Inactiva</option>
                </select>
            </div>
            <br><br>
            <div>
                <!--<input class="button" type="button" id="passGen" onClick="generate();" value="Generar Contraseña">-->
                <input class="button inputs" type="submit" name="submit" id="submit" value="Actualizar Campaña">
            </div>
        </form>
    </section>
</body>
<!-- CheckBox -->
    <script>
    document.getElementById("permanente").onclick = function(){
    			if (document.getElementById("c_meses").disabled){
    				document.getElementById('c_meses').disabled = false
    			}else{
    				document.getElementById('c_meses').disabled = true;
                    document.getElementById('c_meses').value ='';
    			}
    		}
    </script>
</html>

<?php
    include_once('est/footerp.php');
?>