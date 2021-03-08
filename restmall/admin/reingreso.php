<?php
require_once 'panel_c_ajax.php';
include_once "config/permisos.php";

session_start();
$rol = $_SESSION['rol'];
$currentPage = "reingreso";
$acceso = getPermisos($currentPage, $rol);
if(!$acceso){
    header("location: ../login.php");    
}
include_once ('est/headerc.php');
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
    <title>Rest911 - Reingreso</title>
    <link rel="icon" href="../img/logo.png">
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="../css/asistencia.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    
    <!-- Libs -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    
    <!-- JQuery DatePicker -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    
    <style>
        label, input{
            margin: 5px 10px 5px 0;
        }
    </style>
    
</head>
<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P7VCFXL"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    
    <!-- Pedir RUT -->
    <section>
        <div style="display: flex; justify-content: space-between;">
            <h2>Panel de Reingreso (Buscador)</h2>
            <h5>Usuario: <?php echo $_SESSION['usuario']; ?></h5>
            <h5 id="usuario" style="display: none;"><?php echo $_SESSION['userid']; ?></h5>
        </div>
        <br>
        <label for="rut">RUT</label>
        <input class="input" type="text" id="rut" maxlength="9" placeholder="Ingrese RUT">
        <input class="button" type="button" id="ver_rut" value="Confirmar" onclick="getDatos()">
    </section>
    
    <!-- Mensaje de Error -->
    <section id="error" style="display: none;">
        <h5>El RUT ingresado no es válido o no cumple con las condiciones para realizar su reingreso.</h5>
    </section>
    
    <!-- Tabla -->
    <section id=tabla style="padding: 2%; display: none;">    
    </section>
    
    <!-- Respuesta -->
    <section id="respuesta" style="display: none;">
        <h2>Respuesta</h2>
        <br>
        <h5 id="resp"></h5>
    </section>
    
    <!-- Formulario -->
    <section id="formulario" style="display: none;">
        <form>
            <label for="nombre">Nombre</label>
            <input class="input" type="text" id="nombre" disabled style="background: #BECBF7">

            <label for="monto_actual">Monto Actual</label>
            <input class="input" type="text" id="monto_actual" disabled style="background: #BECBF7">

            <label for="monto_nuevo">Nuevo Monto</label>
            <input class="input" type="text" id="monto_nuevo" placeholder="Ingrese nuevo monto">

            <label for="fecha_actual">Próxima Fecha Facturación</label>
            <input class="input" type="text" id="fecha_actual" disabled style="background: #BECBF7">

            <label for="fecha_nueva">Nueva Fecha Facturación</label>
            <input class="input" type="text" id="fecha_nueva" placeholder="Ingrese nueva fecha de facturacion">
            
            <label for="observaciones">Observaciones</label>
            <textarea class="input" id="observaciones" rows="4" cols="50" placeholder="Ingrese Observaciones"></textarea>

            <input class="button" type="button" id="submit" value="Confirmar">
        </form>
    </section>
    
    <script>
        var registroCliente;
        var idCliente;
        
        $('#rut').blur(function(){
            formatearRut();
        });
        
        $('input').keypress(function(e) {
            if($(e.target).attr('id') == 'rut'){
                if((e.which < 48 || e.which > 57) && (e.which != 75) && (e.which != 107)){
                    e.preventDefault();
                }
            }
            else if($(e.target).attr('id') == 'monto_nuevo'){
                if((e.which < 48 || e.which > 57) && (e.which != 46)){
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
        
        $('#monto_nuevo').blur(function(){
            var monto = $(this).val();
            if(monto == 0){
                $(this).val(1);
            }
            else{
                while(monto.includes('.')){
                    monto = monto.replace('.', '');
                }
                $(this).val(monto);
            }
        });
        
        $('#fecha_nueva').datepicker({ 
            closeText: 'Cerrar',
            prevText: '< Ant',
            nextText: 'Sig >',
            currentText: 'Hoy',
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio',
                        'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
            dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
            dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
            weekHeader: 'Sm',
            dateFormat: 'dd-mm-yy',
            defaultDate: '+1m'
            }
        );
        
        function getDatos(){
            var rut = $('#rut').val();
            if(rut){
                $.ajax({
                    url: 'reingreso_ajax.php',
                    type: 'POST',
                    dataType: "json",
                    data: {function: 'getDatos', 
                           rut:       rut},
                    success: function(data){   
                        if(data.length > 0){
                            $('#error').hide();
                            crearTabla(data);
                            registroCliente = data;
                        }
                        else{
                            $('#error').show();
                        }
                    }
                });
            }
        }
        
        function crearTabla(data){
            var html = '<table id="example" class="table table-striped table-bordered" style="width:100%"><thead><tr style="background-color:#48516F; color: white;"><th>Cod. Cliente</th><th>Nombre</th><th>Estado</th><th>N° Benef.</th><th>Monto</th><th>Último Pago</th><th>Accion</th></tr></thead><tbody>';
            for(var i = 0; i < data.length; i++){
                var cliente = data[i];
                
                if(cliente.estado == 'S'){
                    var estadoCliente = 'Activo';
                }
                else{
                    var estadoCliente = 'Moroso';
                }
                
                if(cliente.num_benef == null){
                    var cliente_benef = "Sin registro";
                }
                else{
                    var cliente_benef = cliente.num_benef;
                }
                
                /*
                if(cliente.fec_fac == null){
                    var cliente_fecfac = "Sin registro";
                }
                else{
                    var fechaF = cliente.fec_fac.split('-');
                    var cliente_fecfac = fechaF[2] + '-' + fechaF[1] + '-' + fechaF[0];
                }
                */
                
                if(cliente.fecha_tbk == null){
                    var cliente_fecha_tbk = 'Sin registro';
                }
                else{
                    var cliente_fecha_tbk = cliente.fecha_tbk;
                }
                
                var newHtml = '<tr><td>' + cliente.pagos + '</td>'
                                + '<td>' + cliente.t_nombres + ' ' + cliente.t_apellido1 +  '</td>'
                                + '<td>' + estadoCliente +'</td>'
                                + '<td>' + cliente_benef +'</td>'
                                + '<td>' + cliente.valor_plan_benef + '</td>'
                                + '<td>' + cliente_fecha_tbk + '</td>'
                                + '<td><input class="button" type="button" id="' + cliente.pagos + '" value="Seleccionar" onclick="showForm()"></td></tr>';
                html += newHtml;
            }
            html += '</tbody></table>';
            $('#tabla').html(html);
            
            var tabla = $('#example').dataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
                },
                stateSave: true,
            });
            $('#respuesta').hide();
            $('#tabla').show();
        }
        
        function showForm(){
            $('#monto_nuevo').val('');
            $('#fecha_nueva').val('');
            $('#observaciones').val('');
            $('#tabla').hide();
            idCliente = showForm.caller.arguments[0].target.id;
            for(var i = 0; i < registroCliente.length; i++){
                if(registroCliente[i][0] == idCliente){
                    var cliente = registroCliente[i];
                }
            }
            
            $('#nombre').val(cliente.t_nombres + ' ' + cliente.t_apellido1 + ' ' + cliente.t_apellido2);
            $('#monto_actual').val(cliente.valor_plan_benef);
            $('#fecha_actual').val(cliente.fec_fac);
            $('#fecha_nueva').datepicker('option', 'minDate', cliente.fec_fac);
            $('#formulario').show();
        }
        
        $('#submit').click(function(){
           registrarCambios(); 
        });
        
        /*
        function addMonth(date){
            var fecha = date.split('-');

            var year = parseInt(fecha[0]);
            var month = parseInt(fecha[1]);
            var day = parseInt(fecha[2]);
            
            month ++;
            
            var d = new Date(year, (month - 1), day);
            
            if(d.getMonth() == month){
                var d = new Date(year, month, 0);
            }
            
            var form_fecha = d.toLocaleDateString().split('/');

            var form_year = form_fecha[2];
            var form_month = form_fecha[1];
            var form_day = form_fecha[0];
            
            if(form_month.length == 1){
                form_month = '0' + form_month;
            }
            if(form_day.length == 1){
                form_day = '0' + form_day;
            }
            
            return form_day + '-' + form_month + '-' + form_year;
        }
        */
        
        function camposVacios(){
            var val = false;
            $('form input[type=text]').each(function(){
                if(!$(this).val()){
                    val = true;
                }
            });
            return val;
        }
        
        function registrarCambios(){
            if(!camposVacios()){
                var usuario    = $('#usuario').text();
                var nuevoMonto = $('#monto_nuevo').val();
                var nuevaFecha = $('#fecha_nueva').val();
                var obs        = $('#observaciones').val();
                                
                $.ajax({
                    url: 'reingreso_ajax.php',
                    type: 'POST',
                    data: {function: 'setDatos', 
                           id:        idCliente,
                           usuario:   usuario,
                           monto:     nuevoMonto,
                           fecha:     nuevaFecha,
                           obs:       obs},
                    success: function(data){
                        if(data == 1){
                            $('#resp').html("Operación exitosa.");
                        }
                        else if(data == 2){
                            $('#resp').html("Error al modificar el registro.");
                        }
                        else if(data == 3){
                            $('#resp').html("Error al regularizar cliente.");
                        }
                        else if(data == 4){
                            $('#resp').html("Error con la base de datos.");
                        }
                        $('#formulario').hide();
                        $('#respuesta').show();
                    }
                });
            }
            else{
                alert("Debe completar los campos antes de poder realizar la actualización de datos.");
            }
        }
        
    </script>
</body>