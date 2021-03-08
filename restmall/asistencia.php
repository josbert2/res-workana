<?php
    include_once('config/permisos.php');
    include_once('config/ajax.php');

    session_start();
    $rol    = $_SESSION['rol'];
    $userid = $_SESSION['userid'];
    $currentPage = "asistencia";
    $acceso = getPermisos($currentPage, $rol);
    if(!$acceso){
        header("location: ../login.php");    
    }

    include_once('est/header.php');

    function getDia(){
        date_default_timezone_set("America/Santiago");
        setlocale(LC_ALL,"es_ES");
        return strftime("%A %d de %B del %Y");
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rest911 - Contratación</title>
    <link rel="stylesheet" type="text/css" href="../css/asistencia.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    
    <!-- JQuery -->
    <script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous">
    </script>
    
    <!-- JQuery DatePicker -->
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    
</head>
<body>
    <div id="userid" style="display: none;"><?php echo $_SESSION['userid'] ?></div>
    <section>
        <div id="fecha">
            <?php echo getDia(); ?>
        </div>
        <br>
        <div id="titulo">
            <h1>Registro Clientes</h1>
            <select class="input" id="clase">
                <option selected disabled value="">Seleccione Tipo</option>
                <option value="998">Tipo B (Inscripción y Cobro)</option>
                <option value="999">Tipo C (Solo Inscripción)</option>
            </select>
        </div>
        <form>
            <div>
                <label for="nombre">Nombres</label>
                <input class="input" type="text" id="nombre" placeholder="Ingrese Nombre">
            </div>

            <div>
                <div class="right">
                    <label for="apellido_p">Apellido Paterno</label>
                    <input class="input" type="text" id="apellido_p" placeholder="Ingrese Apellido Paterno">
                </div>

                <div class="left">
                    <label for="apellido_m">Apellido Materno</label>
                    <input class="input" type="text" id="apellido_m" placeholder="Ingrese Apellido Materno">
                </div>
            </div>

            <div>
                <div class="right">
                    <label for="rut">RUT (sin puntos ni guión)</label>
                    <input class="input" type="text" id="rut" maxlength="12" placeholder="Ingrese RUT">
                </div>

                <div class="left">
                    <label for="email">Email</label>
                    <input class="input" type="text" id="email" placeholder="Ingrese Email">
                </div>
            </div>

            <div>
                <div class="right">
                    <label for="telefono">Teléfono</label>
                    <input class="input" type="text" id="telefono" maxlength="9" placeholder="Ingrese Telefono">
                </div>
                
                <div class="left">
                    <label for="factura">Fecha Siguiente de Facturación</label>
                    <input class="input" type="text" id="factura" placeholder="Ingrese Fecha Facturación">
                </div>
            </div>
                
            <div>
                <div class="right">
                    <label for="monto">Monto Plan Actual</label>
                    <input class="input" type="text" id="monto" placeholder="Ingrese Monto">
                </div>

                <div class="left">
                    <label for="meses">Meses Iniciales</label>
                    <input class="input" type="text" id="meses" placeholder="Ingrese Meses Iniciales">
                </div>
            </div>

            <div class="left">
                <label for="descuento">Descuento (%)</label>
                <input class="input" type="text" id="descuento" maxlength="3" placeholder="Ingrese Descuento" value="0" onfocus="this.value=''">
            </div>

            <div class="left">
                <label for="nuevo_monto">Monto a Pagar</label>
                <input readonly class="input" type="text" id="nuevo_monto">
            </div>
                
            <div>
                <label for="observaciones">Observaciones</label>
                <textarea class="input" id="observaciones" rows="4" cols="50" placeholder="Ingrese Observaciones"></textarea>        
            </div>
                
            <div>
                <div class="right">
                    <input class="button" type="button" id="submit" value="Registrar">
                </div>

                <div class="left">
                    <input class="button" type="reset" id="reset" value="Limpiar">
                </div>
            </div>    

            <div>
                <label for="link">Enlace</label>
                <input readonly class="input" type="url" id="link" value="">
            </div>

            <div class="left">
                <input class="button" type="button" id="copy" value="Copiar">
            </div> 
        </form>
    </section>
</body>
    <script type="text/javascript" src="../js/asistencia.js"></script>
</html>

<?php
    include_once('est/footerp.php');
?>