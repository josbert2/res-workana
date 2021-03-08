<?php
include_once('admin/est/header_limpio.php');
include_once('admin/config/conn.php');

function getFecha(){
    date_default_timezone_set("America/Santiago");
    $time  = time();
    $fecha = date("Y-m-d", $time);
    return $fecha;
}

if(!empty($_GET["p"])){
    $promo = strtoupper($_GET["p"]);
    $conn  = getConn();
    $sql   = "SELECT cod_camp, nombre, descuento, meses, dias, fec_ini, fec_ter, titulo, mensaje, terminos, estado 
              FROM campania WHERE (enlace = '$promo' AND estado = 'S')";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0){
        $fecha_actual = getFecha();
        $datos = array();
        while($row = mysqli_fetch_assoc($query)){
            $datos[] = $row;
        }
        $datos = $datos[0];
        if($fecha_actual >= $datos["fec_ini"] && $fecha_actual <= $datos["fec_ter"]){ ?>
            
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
    <title>Rest911 - <?php echo $datos["nombre"] ?></title>
    <link rel="icon" href="../img/logo.png">
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    
    <!-- Libs -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    
    <style>
        :root {
            --azul: #0049a2;
            --azul-claro: #0a5bbf;
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
        }
        
        section{
            width: 100%;
        }
        
        section div{
            width: 50%;
            padding: 4%;
        }
        
        form label{
            margin: 5px 10px 5px 0;
        }

        form input{
            vertical-align: middle;
            margin: 5px 10px 5px 0;
        }
        
        input, select, textarea{
            width: 100%;
            padding: 5px; 
            border: 1px solid var(--azul-oscuro);
            border-radius: 5px;
            outline: none;
        }
        
        select{
            margin-bottom: 5px;
            margin-top: 5px;
            padding-bottom: 7px;
            padding-top: 7px;
        }
        
        button{
            width: 100%;
            padding: 5px; 
            background-color: var(--azul);
            border-radius: 5px;
            color: white;
            margin-top: 10px;
            /*box-shadow: -8px 8px 14px #888888;*/
        }
        
        button:hover{
            cursor: pointer;
            background: var(--azul-claro);
            transition: 0.6s;
        }
        
        .error{
            border: 1px solid red;
        }
        
        #img{
            margin-bottom: 36px;
        }
        
        @media (max-width:1024px){
            section div{
                width: 100%;
                padding: 8%;
            }
            
            #tarjeta{
                display: block !important;
                width: 100% !important;
                margin: 0 !important;
            }
            
            #img{
                display: block;
                /*margin: 0 !important;*/
            }
            
            #precios{
                flex-direction: column-reverse !important;
            }
            
            #rest_logo{
                margin-left: auto;
            }
        }

    </style>
    
</head>
<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P7VCFXL"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div id="cod_camp" style="display: none;"><?php echo $datos["cod_camp"] ?></div>
    <div id="descuento" style="display: none;"><?php echo $datos["descuento"] ?></div>
    <div id="meses" style="display: none;"><?php echo $datos["meses"] ?></div>
    <div id="dias" style="display: none;"><?php echo $datos["dias"] ?></div>
    <div id="valor" style="display: none;"></div>
    <div id="original" style="display: none;"></div>
    
    <section id="tarjeta" style="display: flex; width: 92%; margin: 4%; box-shadow: 8px 8px 14px #888888;">
        <div style="background: rgb(10,91,191); background: linear-gradient(90deg, rgba(10,91,191,1) 0%, rgba(10,91,191,1) 98%, rgba(32,68,113,1) 100%); color: white;">
            <h2><b><?php echo $datos["titulo"]?></b></h2>
            <br>
            <img id="img" src="img/rest_perro.jpg" width="100%" style="border-radius: 30px; border: 5px solid white; box-shadow: -8px 8px 14px rgba(32,68,113,1);">
            <h5><?php echo $datos["mensaje"]?></h5>
            <br>
            
            <p style="font-size: 14px; color: #c2daf9"><?php echo $datos["terminos"]?></p>
        </div>
        <div>
            <h2>Ingrese sus Datos</h2>
            <br>
            <form action="" method="post" id="tbkform">
                <input type="hidden" name="TBK_TOKEN" value="" id="tbk_token">
            </form>
            <form>
                <label for="nombre">Nombre</label>
                <input class="input" type="text" id="nombre" placeholder="Ingrese Nombre">
                
                <label for="apellido">Apellido Paterno</label>
                <input class="input" type="text" id="apellido" placeholder="Ingrese Apellido">
                
                <label for="rut">RUT</label>
                <input class="input" type="text" id="rut" maxlength="9" placeholder="Ingrese RUT">
                
                <label for="email">Correo Electrónico</label>
                <input class="input" type="text" id="email" placeholder="Ingrese Correo Electrónico">
                
                <label for="fono">Teléfono</label>
                <input class="input" type="text" id="fono" maxlength="9" placeholder="Ingrese Teléfono (+56)">
                
                <label for="ciudad">Ciudad</label>
                <select class="input" id="ciudad">
                    <option selected="true" disabled="disabled" value="0">Ingrese Ciudad</option>
                    <option value="ANTOFAGASTA">ANTOFAGASTA</option>
                    <option value="CALAMA">CALAMA</option>
                    <option value="COPIAPO">COPIAPO</option>
                    <option value="COQUIMBO">COQUIMBO</option>
                    <option value="LA SERENA">LA SERENA</option>
                    <option value="SANTIAGO">SANTIAGO</option>
                </select>
                
                <label for="plan">Plan de Pago</label>
                <select class="input" id="plan">
                    <option selected="true" disabled="disabled" value="0">Ingrese Plan</option>
                    <option value="1">SIN COPAGO</option>
                    <option value="2">CON COPAGO</option>
                </select>
                
                <label for="benef">Cantidad de Beneficiarios</label>
                <select class="input" id="benef">
                    <option selected="true" disabled="disabled" value="0">Ingrese Beneficiarios</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                </select>
                <br>
                <br>
                <section style="display: none; text-align: center; align-items: center; width: 100%;" id="precios">
                    <div style="color: var(--azul-claro);">
                        <h1 style="margin:0;" id="p_ahora"></h1>
                        <p id="p_meses"></p>
                    </div>
                    <div>
                        <h4 id="p_antes"></h4>
                    </div>
                </section>
                
                <button class="button" type="button" id="submit">Continuar</button>
            </form>
        </div>
    </section>
    
    <script>
        var ocuppied = false; 
        
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
            if($(this).children("option:selected").val() == 0){
                $(this).addClass("error");
            }
            else{
                if($(this).hasClass("error")){
                    $(this).removeClass("error");
                }
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
        
        $('#telefono').blur(function(){
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
            if(($(e.target).attr('id') == 'fono')){
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
        
        $("#plan").change(function(){
            var plan  = $(this).children("option:selected").val();
            var benef = $("#benef").children("option:selected").val();
            if(benef > 0){
                getValores(plan, benef);
            }
        });
        
        $("#benef").change(function(){
            var benef = $(this).children("option:selected").val();
            var plan  = $("#plan").children("option:selected").val();
            if(plan > 0){
                getValores(plan, benef);
            }
        });
        
        function numberFormat(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
        
        function getValores(plan, benef){
            $.ajax({
                url: 'promo_ajax.php',
                type: 'POST',
                data: {
                    function: 'getValores',
                    plan: plan,
                    benef: benef
                },
                success: function(data){
                    var dias      = $('#dias').text();
                    var meses     = $('#meses').text();
                    var descuento = $('#descuento').text();
                    
                    $('#original').text(data);
                    if(dias > 0){
                        $('#valor').text(data);
                        $('#p_ahora').html('<b><i>Ahora Gratis!</i></b>');
                        $('#p_meses').html('<b><i>por ' + dias +' días</i></b>');
                        $('#p_antes').html('<i>Antes: $' + numberFormat(data) + '/mes</i>');
                    }
                    else if(descuento > 0){
                        $('#valor').text((data * (100 - descuento))/100);
                        $('#p_antes').html('<i>Antes: $' + numberFormat(data) + '/mes</i>');
                        $('#p_ahora').html('<b><i>AHORA: $' + numberFormat((data * (100 - descuento))/100) + '/MES</i></b>');
                        if(meses > 1){
                            $('#p_meses').html('<b><i>descuento del ' + descuento + '% <br>por ' + meses +' meses</i></b>');
                        }
                        else if(meses == 1){
                            $('#p_meses').html('<b><i>descuento del ' + descuento + '% <br>por ' + meses +' mes</i></b>');
                        }
                        else{
                            $('#p_meses').html('<b><i>descuento del ' + descuento + '% <br>para siempre</i></b>');
                        }
                    }
                    $('#precios').css({"display": "flex", "flex-direction": "row-reverse"});
                }
            });
        }
        
        function verificarCampos(){
            return (camposVacios() && camposErrores());
        }

        function camposVacios(){
            var val = true;
            $('form input[type=text]').each(function(){
                if(!$(this).val()){
                    $(this).addClass('error');
                    val = false;
                }
            });
            $('form select').each(function(){
                if($(this).children("option:selected").val() == 0){
                    $(this).addClass('error');
                    val = false;
                }
            });
            return val;
        }

        function camposErrores(){
            var val = true;
            $('form input[type=text]').each(function(){
                if($(this).attr("class").includes('error')){
                    val = false;
                }
            });
            $('form select').each(function(){
                if($(this).attr("class").includes('error')){
                    val = false;
                }
            });
            return val;
        }
        
        $('#submit').click(function(){
            if(verificarCampos() && !ocuppied){
                
                var nombre   = $('#nombre').val();
                var apellido = $('#apellido').val();
                var rut      = $('#rut').val();
                var email    = $('#email').val();
                var fono     = $('#fono').val();
                
                var ciudad   = $("#ciudad").children("option:selected").val();
                var plan     = $("#plan").children("option:selected").val();
                var nom_plan = $("#plan").children("option:selected").text();
                var benef    = $("#benef").children("option:selected").val();
                
                var valor    = $('#valor').text();
                var original = $('#original').text();
                var dscto    = $('#descuento').text();
                var dias     = $('#dias').text();
                
                var meses    = $('#meses').text();
                var cod_camp = $('#cod_camp').text();
                
                $.ajax({
                    url: 'promo_ajax.php',
                    type: 'POST',
                    dataType: "json",
                    data: {
                        function: 'registrarOrden',
                        nombre:    nombre,
                        apellido:  apellido,
                        rut:       rut,
                        email:     email,
                        fono:      fono,
                        ciudad:    ciudad,
                        
                        plan:      plan,
                        nom_plan:  nom_plan,
                        benef:     benef,
                        
                        dscto:     dscto,
                        dias:      dias,
                        valor:     valor,
                        original:  original,
                        meses:     meses,
                        cod_camp:  cod_camp
                    },
                    success: function(data){
                        tbk_token = document.getElementById("tbk_token");
                        tbk_token.value = data[0];
                        tbkform = document.getElementById("tbkform");
                        tbkform.action = data[1];
                        
                        tbkform.submit();
                        ocuppied = false;
                    }
                });
            }
            else{
                
            }
        });
        
    </script>
    <?php 
        include('admin/est/footerp.php');
    ?>
</body>
                
        <?php }
        else{
            #$fecha_actual >= $datos["fec_ini"] && $fecha_actual <= $datos["fec_ter"] => FALSE
            $sql   = "UPDATE campania SET estado = 'N' WHERE nombre = '$promo'";
            $query = mysqli_query($conn, $sql);
            $error = true;
        }
    }
    else{
        #mysqli_num_rows($query) == 0
        $error = true;
    }
}
else{
    #empty($_GET["p"])
    $error = true;
}
if($error){ ?>
    
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
    <title>Rest911 - Error</title>
    <link rel="icon" href="../img/logo.png">
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    
    <!-- Libs -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    
</head>
<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P7VCFXL"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    
    <section style="width:92%; margin:4%; background: rgb(10,91,191); background: linear-gradient(90deg, rgba(10,91,191,1) 0%, rgba(10,91,191,1) 98%, rgba(32,68,113,1) 100%); color: white; text-align: center;">
        <div style="padding:4%;">
            <h1 style=""><b>Ups! Ha ocurrido un error.</b></h1>
            <br>
            <h4>Las razones pueden ser:</h4>
            <h4>El enlace ingresado es incorrecto.</h4>
            <h4>La oferta inscrita ya ha caducado.</h4>
            <br>
            <h4>Te recomendamos volver a intentarlo más tarde.</h4>
            <br><br>
            <img src="img/logoc.png" style="background: white; border-radius: 30px; border: 5px solid white; box-shadow: -8px 8px 14px rgba(32,68,113,1);">
        </div>
    </section>
</body>
<?php } ?>