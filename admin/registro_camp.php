<?php
    include_once('config/conn.php');
    include_once "config/permisos.php";

    session_start();
    $currentPage = "campana";
    $rol = $_SESSION['rol'];
    $acceso = getPermisos($currentPage, $rol);
    if(!$acceso){
        header("location: ../login.php");    
    }
    include_once ('est/header.php');
    include_once ('registro_camp_sql.php');
    
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
    <title>Rest911 - Registro de Campañas</title>
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
                    <input class="inputs" type="text" id="sitio" name="sitio" value="https://planes.rest911.cl/promo.php?p=<?php echo $enlace ?>" readonly><button class="button inputs"  onclick="copyToClipboard('#sitio2')">Copiar </button>
            <div style="visibility: hidden"><p id="sitio2">https://planes.rest911.cl/promo.php?p=<?php echo $enlace ?></p> </div>
            <?php } ?>
        </div>
    <?php } ?>
    <section>
        <!--<div id="titulo">
            <h1>Registro de Campaña</h1>
        </div>-->
        <div style="display: flex; justify-content: space-between;">
            <h2>Registro de Campaña <?php echo $meses; ?></h2>
            <h5>Usuario: <?php echo $_SESSION['usuario']; ?></h5>
            <h5 id="usuario" style="display: none;"><?php echo $_SESSION['userid']; ?></h5>
        </div>
        <form method="post">
            <div>
                <label for="nombre">Nombre de Campaña</label>
                <input class="inputs" type="text" name="nombre" placeholder="Ingrese Nombre" value="<?php if(isset($nombre)){ echo $nombre; } ?>" required>
            </div>
            <div>
                <label for="descuento">
                <input onclick="document.getElementById('descuento').disabled = false; document.getElementById('c_meses').disabled = false; document.getElementById('dias').disabled = true;
                document.getElementById('dias').value ='';
                document.getElementById('permanente').disabled = false;" type="radio" name="promo" value="p_descuento" checked="checked">Promoción con Descuento
                </label>
                <input class="inputs" type="number" onKeyDown="if(this.value.length==2) return false;" min="1" max="99" step="1" name="descuento" id="descuento" value="<?php if(isset($descuento)){ echo $descuento; } ?>" placeholder="Ingrese el descuento en porcentual">
                <input class="inputs" type="number" type="number" onKeyDown="if(this.value.length==2) return false;" min="1" max="99" step="1" name="c_meses" id="c_meses" value="<?php if(isset($meses)){ echo $meses; } ?>" placeholder="Ingrese cantidad de meses con descuento">
                <label for="permanente">
                <input type="checkbox" id="permanente" name="permanente" value="perma" >Descuento Permanente
                </label>
                <label for="dias">
                <input onclick="document.getElementById('descuento').disabled = true; document.getElementById('descuento').value =''; document.getElementById('c_meses').disabled = true; document.getElementById('c_meses').value =''; 
                document.getElementById('dias').disabled = false;
                document.getElementById('permanente').disabled = true;
                document.getElementById('permanente').checked = false; " type="radio" name="promo" value="p_gratis" >Prueba Gratis
                </label>
                <select class="selects" name="dias" id="dias" disabled="disabled">
                       <option disabled="true" selected="selected" >Seleccione cantidad de días de prueba</option>
                       <option value="30" <?php if(isset($dias) && $dias == 30 ){ echo 'selected="selected"'; } ?> >30 Días</option>
                       <option value="60" <?php if(isset($dias) && $dias == 60 ){ echo 'selected="selected"'; } ?> >60 Días</option>
                       <option value="90" <?php if(isset($dias) && $dias == 90 ){ echo 'selected="selected"'; } ?> >90 Días</option>
                </select>
            </div>
            <div>
                <label for="fec_ini">Fecha de Inicio</label>
                <input class="inputs" type="date" name="fec_ini" value="<?php if(isset($fec_ini)){ echo $fec_ini; } ?>" placeholder="Ingrese fecha de inicio de la campaña" required>
            </div>
            <div>
                <label for="fec_ter">Fecha de Termino</label>
                <input class="inputs" type="date" name="fec_ter" value="<?php if(isset($fec_ter)){ echo $fec_ter; } ?>" placeholder="Ingrese fecha de termino de la campaña" required>
            </div>
            <div>
                <label for="descripcion">Descripción</label>
                <textarea class="inputs" type="text" name="descripcion" cols="40" rows="5" placeholder="Ingrese una descripción interna de la campaña" onkeypress="if (this.value.length > 1000) { return false; }"><?php if(isset($descripcion)){ echo $descripcion; } ?></textarea>
            </div>
            <div class="dropdown-divider"></div>
            <h1>Información Web</h1>
            <div>
                <label for="titulo">Titulo</label>
                <input class="inputs" type="text" name="titulo" maxlength="70" value="<?php if(isset($titulo)){ echo $titulo; } ?>" placeholder="Ingrese titulo de sitio web campaña (Máximo 70 Caracteres)" required>
            </div>
            <div>
                <label for="mensaje">Mensaje</label>
                <textarea class="inputs" type="text" name="mensaje" cols="60" rows="5" placeholder="Ingrese mensaje a mostrar en sitio web campaña (Máximo 700 Caracteres)" onkeypress="if (this.value.length > 700) { return false; }" required><?php if(isset($mensaje)){ echo $mensaje; } ?></textarea>
            </div>
            <div>
                <label for="terminos">Terminos</label>
                <textarea class="inputs" type="text" name="terminos" cols="40" rows="5" placeholder="Ingrese T&C para sitio web campaña (Máximo 360 Caracteres)" onkeypress="if (this.value.length > 360) { return false; }"><?php if(isset($terminos)){ echo $terminos; } ?></textarea>
            </div>
            <div>
                <label for="enlace">Enlace (ejemplo: CYBERDAY)</label>
                <input class="inputs" type="text" id="enlace" name="enlace" value="<?php if(isset($enlace)){ echo $enlace; } ?>" placeholder="Ingrese nombre del enlace" required>
            </div>
            <div>
                <label for="estado">Estado Inicial</label>
                <select class="inputs" name="estado" required>
                    <option selected disabled value="">Seleccione estado inicial de la campaña</option>
                            <option value="S" <?php if(isset($estado) && $estado == 'S'){ echo 'selected="selected"'; } ?> >Activa</option>
                            <option value="N" <?php if(isset($estado) && $estado == 'N'){ echo 'selected="selected"'; } ?> >Inactiva</option>
                </select>
            </div>
            <br><br>
            <div>
                <!--<input class="button" type="button" id="passGen" onClick="generate();" value="Generar Contraseña">-->
                <input class="button inputs" type="submit" name="submit" id="submit" value="Crear Campaña">
            </div>
        </form>
    </section>
</body>
<!-- Remover espacio -->
    <script>
     $("#enlace").on('input', function(key) {
  var value = $(this).val();
  $(this).val(value.replace(/ /g, '_'));
})   
    </script>
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