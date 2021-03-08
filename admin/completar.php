<?php
include_once('config/conn.php');
include_once "config/permisos.php";

session_start();
$rol = $_SESSION['rol'];
$currentPage = "completar";

$acceso = getPermisos($currentPage, $rol);
if(!$acceso){
    header("location: ../login.php");    
}

include_once ('est/headerc.php');

function filtrarClientes($datos){
    foreach($datos as $k => $cliente){
        $id = $cliente["pagos"];
        $conn = getConn();
        $sql  = "SELECT pagos FROM beneficiarios WHERE pagos = $id";
        $query = mysqli_query($conn, $sql);
        if(mysqli_num_rows($query) > 0){
            unset($datos[$k]);
        }
    }
    return $datos;
}

function getDatosClientes(){
    $conn = getConn();
    $sql  = "SELECT pagos, t_nombres, t_apellido1, rut, telefono, fec_pag, valor_plan_benef FROM pagos_clientes WHERE (clase = 'D' AND (estado = 'S' OR estado = 'I'))";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0){
        $datos = array();
        while($row = mysqli_fetch_array($query)){
            $datos[] = $row; 
        }
        $datos = filtrarClientes($datos);
        return $datos;
    }
    else{
        //die;
        return NULL;
    }
}

$datos = getDatosClientes();
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

    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rest911 - Completar</title>
    <link rel="icon" href="../img/logo.png">
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="../css/motorpago.css">
    
    <!-- Libs -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    
    <style>
        :root {
            --azul-oscuro: #1b2838;
            --amarillo: #d7e811;
        }

        *{
            -ms-box-sizing:border-box;
            -moz-box-sizing:border-box;
            -webkit-box-sizing:border-box; 
            box-sizing:border-box;
        }

        body{
            font-family: Arial, Helvetica, sans-serif;
            width: 100%;
        }

        form{
            display: flex;
            flex-direction: column;
        }

        form label{
            margin: 5px 10px 5px 0;
        }

        form input{
            vertical-align: middle;
            margin: 5px 10px 5px 0;
        }

        input, label{
            display: block;
        }

        .left, .right{
            width: 48%;
        }

        .left{
            display: inline-block;
        }

        .right{
            float: left;
            margin-right: 4%;
        }
        
        .error{
            border: 1px solid red;
        }

        input, textarea{
            width: 100%;
            padding: 5px; 
            border: 1px solid var(--azul-oscuro);
            border-radius: 5px;
            outline: none;
        }
        
        div select{
            width: 32%;
            padding: 8px; 
            border: 1px solid var(--azul-oscuro);
            border-radius: 5px;
            outline: none;
        }

        .button{
            padding-top: 10px;
            padding-bottom: 10px;
            background-color: #2a475e;
            color: white;
            margin-top: 14px;
            box-shadow: 5px 5px 10px #888888;
        }
        
        .container {
          display: block;
          position: relative;
          padding-left: 35px;
          margin-bottom: 12px;
          cursor: pointer;
          font-size: 22px;
          -webkit-user-select: none;
          -moz-user-select: none;
          -ms-user-select: none;
          user-select: none;
        }

        /* Hide the browser's default checkbox */
        .container input {
          position: absolute;
          opacity: 0;
          cursor: pointer;
          height: 0;
          width: 0;
        }

        /* Create a custom checkbox */
        .checkmark {
          position: absolute;
          top: 0;
          left: 0;
          height: 25px;
          width: 25px;
          background-color: #eee;
        }

        /* On mouse-over, add a grey background color */
        .container:hover input ~ .checkmark {
          background-color: #ccc;
        }

        /* When the checkbox is checked, add a blue background */
        .container input:checked ~ .checkmark {
          background-color: rgb(10,91,191);
        }

        /* Create the checkmark/indicator (hidden when not checked) */
        .checkmark:after {
          content: "";
          position: absolute;
          display: none;
        }

        /* Show the checkmark when checked */
        .container input:checked ~ .checkmark:after {
          display: block;
        }

        /* Style the checkmark/indicator */
        .container .checkmark:after {
          left: 9px;
          top: 5px;
          width: 5px;
          height: 10px;
          border: solid white;
          border-width: 0 3px 3px 0;
          -webkit-transform: rotate(45deg);
          -ms-transform: rotate(45deg);
          transform: rotate(45deg);
        }
    </style>
    
    <!-- Datatable -->
    <script>
        $(document).ready(function(){
            var tabla = $('#example').dataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
                },
                stateSave: true,
            });
        });
    </script>
    
</head>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P7VCFXL"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
	<div id="userid" style="display: none;"><?php echo $_SESSION['userid'] ?></div>
    <section style="width 92%; margin: 4%; margin-top: 3%; margin-bottom: 3%;">
        <div style="display: flex; justify-content: space-between;">
            <h2>Completar Registros</h2>
            <h5>Usuario: <?php echo $_SESSION['usuario']; ?></h5>
        </div>
        
        <section id="tabla_clientes">    
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr style="background-color:#0049a2; color: white;">
                        <th>Cod. Cliente</th>
                        <th>RUT</th>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Ingreso Sistema</th>
                        <th>Monto Mensual</th>
                        <th>Seleccionar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($datos)){ ?>
                        <?php foreach($datos as $k => $cliente){ ?>
                            <tr>        
                                <td><?php echo "CC.".$cliente["pagos"]?></td>
                                <td><?php echo $cliente["rut"]?></td>
                                <td><?php echo $cliente["t_nombres"].' '.$cliente["t_apellido1"]?></td>
                                <td><?php echo $cliente["telefono"]?></td>
                                <td><?php echo date("d-m-Y", strtotime($cliente["fec_pag"]))?></td>
                                <td><?php echo '$'.number_format($cliente["valor_plan_benef"],0,"",".") ?></td>
                                <td><button type="button" class="btn btn-primary" value="<?php echo $cliente["pagos"]?>">Completar</button></td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
        </section>

        <section style="margin-top: 2%; margin-bottom: 2%; display:none;" id="form_cliente">
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
                        <input class="input" type="text" id="fono_p" maxlength="9" placeholder="Ingrese Telefono">
                    </div>

                    <div class="left">
                        <label for="telefono">Otro Teléfono</label>
                        <input class="input" type="text" id="fono_s" maxlength="9" placeholder="Ingrese Telefono (opcional)">
                    </div>
                </div>

                <div>
                    <div class="right">
                        <label for="direccion">Dirección</label>
                        <input class="input" type="text" id="direccion" placeholder="Ingrese Domicilio">
                    </div>

                    <div class="left">
                        <label for="nac">Fecha Nacimiento</label>
                        <div style="display: flex; justify-content: space-between;">
                            <select required class="input" id="dia">
                                <option selected="true" disabled="disabled" value="0">Día</option>
                                <?php for($i = 1; $i <= 31; $i++){ ?>
                                    <?php if($i < 10){ ?>
                                        <option value="<?php echo "0".$i?>"><?php echo $i?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $i?>"><?php echo $i?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                            <select required class="input" id="mes">
                                <option selected="true" disabled="disabled" value="0">Mes</option>
                                <?php for($i = 1; $i <= 12; $i++){ ?>
                                    <?php if($i < 10){ ?>
                                        <option value="<?php echo "0".$i?>"><?php echo $i?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $i?>"><?php echo $i?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                            <select required class="input" id="ano">
                                <option selected="true" disabled="disabled" value="0">Año</option>
                                <?php for($i = 1920; $i <= 2020; $i++){ ?>
                                    <option value="<?php echo $i?>"><?php echo $i?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div> 
                <div class="right" style="margin-top: 15px;">
                    <label class="container">Es Beneneficiario
                        <input type="checkbox" checked="checked" id="check_benef">
                        <span class="checkmark"></span>
                    </label>    
                </div>
                <br>
                <div>
                    <input class="button" type="button" id="form_button" value="Continuar">
                </div>
            </form>
        </section>
        
        <section style="display: none;" id="form_benef">
            <form>
                <?php for($k = 1; $k < 8; $k++){
                if($k%2 > 0){ ?>
                    <div>
                <?php } ?>
                        <div style="margin-top: 2%; margin-bottom: 2%;" id="benef_<?php echo $k; ?>" class="<?php if($k%2 > 0){echo "right";}else{echo "left";}?>">
                            <h3>Beneficiario <?php echo $k; ?></h3>
                            <br>
                            <label for="nombre">Nombre</label>
                            <input class="input" type="text" id="nombre_b<?php echo $k; ?>" placeholder="Ingrese Nombre">

                            <label for="apellido_p">Apellido Paterno</label>
                            <input class="input" type="text" id="apellido_p_b<?php echo $k; ?>" placeholder="Ingrese Apellido Paterno">

                            <label for="apellido_m">Apellido Materno</label>
                            <input class="input" type="text" id="apellido_m_b<?php echo $k; ?>" placeholder="Ingrese Apellido Materno">

                            <label for="nac">Fecha Nacimiento</label>
                            <div style="display: flex; justify-content: space-between;">
                                <select required class="input" id="dia_b<?php echo $k; ?>">
                                    <option selected="true" disabled="disabled" value="0">día</option>
                                    <?php for($i = 1; $i <= 31; $i++){ ?>
                                        <?php if($i < 10){ ?>
                                            <option value="<?php echo "0".$i?>"><?php echo $i?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $i?>"><?php echo $i?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                                <select required class="input" id="mes_b<?php echo $k; ?>">
                                    <option selected="true" disabled="disabled" value="0">mes</option>
                                    <?php for($i = 1; $i <= 12; $i++){ ?>
                                        <?php if($i < 10){ ?>
                                            <option value="<?php echo "0".$i?>"><?php echo $i?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $i?>"><?php echo $i?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                                <select required class="input" id="ano_b<?php echo $k; ?>">
                                    <option selected="true" disabled="disabled" value="0">año</option>
                                    <?php for($i = 1920; $i <= 2020; $i++){ ?>
                                        <option value="<?php echo $i?>"><?php echo $i?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                <?php if($k%2 < 1){ ?>
                    </div>
                <?php }
                } ?>
                <input class="button" type="button" id="submit" value="Continuar">
            </form>
        </section>
        
    </section>
    
    <script>
        var id = 0;
        var kills = 0;
        
        $('input').change(function(){
            if($(this).val() == ""){
                $(this).addClass("error");
            }
            else{
                $(this).val($(this).val().toLocaleUpperCase());
                if($(this).hasClass("error")){
                    $(this).removeClass("error");
                }
            }
        });
        
        $('select').change(function(){
            if($(this).children("option:selected").val() != 0 && $(this).hasClass("error")){
                $(this).removeClass("error");
            }
        });
        
        $('#rut').blur(function(){
            formatearRut();
            if(!validarRUT()){
                $(this).addClass("error");
            }
            else{
                if($(this).hasClass("error")){
                    $(this).removeClass("error");
                }
            }
        });
        
        $('#fono_p').blur(function(){
            if($(this).val().length != 9){
                $(this).addClass('error');
            }
            else{
                if($(this).attr('class').includes('error')){
                    $(this).removeClass('error');
                }
            }
        })
        
        $('#fono_s').blur(function(){
            if($(this).val().length != 9){
                $(this).addClass('error');
            }
            else{
                if($(this).attr('class').includes('error')){
                    $(this).removeClass('error');
                }
            }
        })
        
        $('#email').blur(function(){
            if(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test($('#email').val())){
                if($(this).hasClass("error")){
                    $(this).removeClass("error");
                }
            }
            else{
                $(this).addClass("error");
            }
        });
        
        $('input').keypress(function(e) {
            if(($(e.target).attr('id') == 'fono_p') || ($(e.target).attr('id') == 'fono_s')){
                if(e.which < 48 || e.which > 57){
                    e.preventDefault();
                }
            }
            else if($(e.target).attr('id') == 'rut'){
                if((e.which < 48 || e.which > 57) && (e.which != 75) && (e.which != 107)){
                    e.preventDefault();
                }
            }
            else if($(e.target).attr('id') != 'email'){
                if(e.which < 58 && e.which > 47){
                    e.preventDefault();
                }
            }
        });
        
        function formatearRut(){
            var rut = $('#rut').val();
            while(rut.includes(".") || rut.includes("-")){
                rut = rut.replace(".", "");
                rut = rut.replace("-", "");
            }
            if(rut.length == 9){
                rut = rut.substring(0, 2) + '.' + rut.substring(2, 5) + '.' + rut.substring(5, 8) + '-' + rut.substring(8, 9);
            }
            else if(rut.length == 8){
                rut = rut.substring(0, 1) + '.' + rut.substring(1, 4) + '.' + rut.substring(4, 7) + '-' + rut.substring(7, 8);
            }
            $('#rut').val(rut);
        }

        function validarRUT(){
            var rut = $('#rut').val();
            if(rut.length == 11 || rut.length == 12){
                var split = rut.split('-');
                var rut   = split[0];
                var digv  = split[1];
                while(rut.includes('.')){
                    rut = rut.replace('.', '');
                }
                var i      = rut.length;
                var j      = 2;
                var serieA = 0;
                while(i > 0){
                    serieA += rut.substring(i - 1, i) * j;
                    i--;
                    if(j < 7){
                        j++;
                    }
                    else{
                        j = 2;
                    }   
                }
                var serieB = Math.trunc(serieA/11);
                serieB *= 11;
                var dig = Math.abs(serieA - serieB);
                dig = 11 - dig;
                if(dig == 11){
                    dig = 0;
                }
                else if(dig == 10){
                    dig = 'K';
                }
                if(dig == digv){
                    return true;
                }
                else{
                    return false;
                } 
            }
            else{
                return false;
            }
        }
        
        function verificarCamposCliente(){
            return (camposVaciosCliente() && camposErroresCliente());
        }

        function camposVaciosCliente(){
            var val = true;
            $('#form_cliente input[type=text]').each(function(){
                if(!$(this).val()){
                    $(this).addClass('error');
                    val = false;
                }
            });
            $('#form_cliente select').each(function(){
                if($(this).children("option:selected").val() == 0){
                    $(this).addClass('error');
                    val = false;
                }
            });
            return val;
        }

        function camposErroresCliente(){
            var val = true;
            $('#form_cliente input[type=text]').each(function(){
                if($(this).attr("class").includes('error')){
                    val = false;
                }
            });
            $('#form_cliente select').each(function(){
                if($(this).attr("class").includes('error')){
                    val = false;
                }
            });
            return val;
        }
        
        function verificarCamposBenef(){
            return (camposVaciosBenef() && camposErroresBenef());
        }

        function camposVaciosBenef(){
            var val = true;
            $('#form_benef input[type=text]').each(function(){
                if(!$(this).val()){
                    $(this).addClass('error');
                    val = false;
                }
            });
            $('#form_benef select').each(function(){
                if($(this).children("option:selected").val() == 0){
                    $(this).addClass('error');
                    val = false;
                }
            });
            return val;
        }

        function camposErroresBenef(){
            var val = true;
            $('#form_benef input[type=text]').each(function(){
                if($(this).attr("class").includes('error')){
                    val = false;
                }
            });
            $('#form_benef select').each(function(){
                if($(this).attr("class").includes('error')){
                    val = false;
                }
            });
            return val;
        }
        
        $('table button').click(function(){
            id = $(this).val();
            if(id){
                $.ajax({
                    url: 'completar_ajax.php',
                    type: 'POST',
                    dataType: "json",
                    data: {
                        function: 'getDatos', 
                        id: id
                    },
                    success: function(data){
                        $('#tabla_clientes').hide();
                        $('#nombre').val(data["t_nombres"]);
                        $('#apellido_p').val(data["t_apellido1"]);
                        $('#rut').val(data["rut"]);
                        $('#email').val(data["email"]);
                        $('#fono_p').val(data["telefono"].substring(2));
                        $('#form_cliente').show();
                        
                        kills = parseInt(data["num_benef"]) + 1;
                        for(var i = kills; i < 8; i++){
                            var target = "benef_" + i;
                            $('#' + target).empty();
                            $('#' + target).remove();
                        }
                    }
                });
            }
        });
        
        $('#form_button').click(function(){
            if(verificarCamposCliente()){
                $('#form_cliente').hide();
                if($('#check_benef').prop('checked')){
                    $('#nombre_b1').val($('#nombre').val());
                    $('#apellido_p_b1').val($('#apellido_p').val());
                    $('#apellido_m_b1').val($('#apellido_m').val());
                    $('#ano_b1').val($('#ano').children("option:selected").val());
                    $('#mes_b1').val($('#mes').children("option:selected").val());
                    $('#dia_b1').val($('#dia').children("option:selected").val());
                }
                $('#form_benef').show(); 
            }
            else{
                alert("Debe completar todos los campos correctamente para poder continuar.");
            }
        });
        
        $('#submit').click(function(){
            if(verificarCamposBenef()){
                var benefs     = new Array(kills - 1);
                var userid     = $('#userid').text();
                
                var nombre     = $('#nombre').val();
                var apellido_p = $('#apellido_p').val();
                var apellido_m = $('#apellido_m').val();
                var rut        = $('#rut').val();
                var email      = $('#email').val();
                var fono_p     = $('#fono_p').val();
                var fono_s     = $('#fono_s').val();
                var direccion  = $('#direccion').val();
                var fec_nac    = $('#dia').children("option:selected").val() + '-' 
                               + $('#mes').children("option:selected").val() + '-' 
                               + $('#ano').children("option:selected").val();
                
                for(var j = 1; j < kills; j++){
                    var nombre_benef     = $('#nombre_b' + j).val();
                    var apellido_p_benef = $('#apellido_p_b' + j).val();
                    var apellido_m_benef = $('#apellido_m_b' + j).val();
                    var fec_nac_benef    = $('#ano_b' + j).children("option:selected").val() + '-' 
                                         + $('#mes_b' + j).children("option:selected").val() + '-' 
                                         + $('#dia_b' + j).children("option:selected").val();
                    
                    var info_benef = [nombre_benef, apellido_p_benef, apellido_m_benef, fec_nac_benef];
                    benefs[j - 1]  = info_benef;
                }
                
                $.ajax({
                    url: 'completar_ajax.php',
                    type: 'POST',
                    //dataType: "json",
                    data: {
                        function: 'setCliente', 
                        id: id,
                        userid: userid,
                        nombre: nombre, 
                        apellido_p: apellido_p, 
                        apellido_m: apellido_m, 
                        rut: rut, 
                        email: email, 
                        fono_p: fono_p, 
                        fono_s: fono_s, 
                        direccion: direccion, 
                        fec_nac: fec_nac, 
                        benefs: benefs
                    },
                    success: function(data){
                        if(confirm(data)){
                            window.location.reload();   
                        }
                    }
                });
            }
            else{
                alert("Debe completar todos los campos correctamente para poder continuar.");
            }
        });
    </script>
</body>