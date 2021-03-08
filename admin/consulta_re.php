<?php
include "config/func.php"; 
include_once "config/permisos.php";
require_once 'consulta_sql.php';

session_start();
$rol = $_SESSION['rol'];
$currentPage = "consulta_re"; 
$acceso = getPermisos($currentPage, $rol);
if(!$acceso){
    header("location: ../login.php");    
}
include_once ('est/headerc.php');

/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/
$fechahoy = getFecha();

//DATOS DE BUSQUEDA
if(empty($_REQUEST['transc'])){
    $transc = 'AR';
}else{
    $transc = $_REQUEST['transc'];
    }
if( (empty($_REQUEST['bdesde'])) OR (empty($_REQUEST['bhasta'])) ){
    $bdesde = $fechahoy;
    $bhasta = $fechahoy;
    }else{
    $bdesde = strtolower($_REQUEST['bdesde']);
    $bhasta = strtolower($_REQUEST['bhasta']);
}

$nave = "?bdesde=$bdesde&bhasta=$bhasta&transc=$transc";
$datos = getTransc($transc,$bdesde,$bhasta);
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
    <title>Rest911 - Reversas</title>
    <!--<link rel="icon" href="../img/logo.png">-->
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <style>
    body{
    font-family: Arial, Helvetica, sans-serif;
    }
    .form_search{
        display: flex;
        float:right;
        background: initial;
        padding-right: 10px;
        border-radius: 10px;
    }
    .formulario{
       /* padding-bottom: 10%; */
        width: 95%;
        margin-left: 2%;
        margin-top: 2%;
        margin-bottom: 2%;
    }
    .btn-success{
        float: left;
        position: relative;
        color: #000;
        background-color: #d7e811;
        border-color: #d7e811;
        margin-left: 5px;
        border-radius: 10px;
        margin-bottom: 20px;
    }
    .inputsss{
        margin: 5px;
        text-align: center;
    }
    label {
        margin-left: 3px;
    }
    .modal-dialog {
        margin: 2%;
        height: 92%;
        min-width: 96%;
    }
    .modal-content {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
    }
    .modal-content input, .modal-content textarea{
        width: 100%;
        padding: 5px; 
        border: 1px solid #1b2838;
        border-radius: 5px;
        outline: none;
        vertical-align: middle;
        margin: 5px 10px 5px 0;
    }
        
    .modal-content label{
        margin: 5px 10px 5px 0;
    }
        
    textarea {
        resize: none;
    }
    #rev_resp{
        text-align: center;
        padding: 30px;    
    }
    </style>
    <!-- Libs -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    
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

<div id="userid" style="display:none;"><?php echo $_SESSION['userid'] ?></div>
<div id="usuario" style="display:none;"><?php echo $_SESSION['usuario'] ?></div>
 <section class="formulario">
    <div style="display: flex; justify-content: space-between;">
        <h2>Proceso de Reversas</h2>
        <h5>Usuario: <?php echo $_SESSION['usuario']; ?></h5>
    </div>
     <a href="exportar_reg.php<?php echo $nave ?>" class="btn btn-success" target="_blank">Exportar Registros</a>
    <form action="" method="get" class="form_search">
            <div class="inputsss">
            <input type="radio" name="transc" <?php if (isset($transc) && $transc=="AR") echo "checked";?> value="AR"><label for="solo_a"> Transacciones Exitosas</label></div>
            <div class="inputsss">
            <input type="radio" name="transc" <?php if (isset($transc) && $transc=="R") echo "checked";?> value="R"><label for="solo_r"> Transacciones Reversadas</label></div>
            <div class="inputsss">
            <input type="radio" name="transc" <?php if (isset($transc) && $transc=="FR") echo "checked";?> value="FR"><label for="solo_fr"> Reversadas Fallidas</label></div>
            <div class="inputsss">
            <label for="busqueda">Desde: </label>
            <input type="date" step="1" min="2020-04-01" max="<?php echo date("Y-m-d");?>" value="<?php echo $bdesde ?>" name="bdesde" id="bdesde" placeholder="Desde">
            </div>
            <div class="inputsss">
            <label for="hasta"> Hasta: </label>
            <input type="date" step="1" min="2020-04-01" max="<?php echo date("Y-m-d");?>" value="<?php echo $bhasta ?>" name="bhasta" id="bhasta" placeholder="Hasta">
            </div>
            <input type="submit" name="Buscar" class="btn btn-primary" value="Buscar">
    </form>
</section>
<?php  if($transc == "AR"){ ?>
    <section style="padding:2%;">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr style="background-color:#0049a2; color: white;">
                    <th>Cod. Transac</th>
                    <th>Cod. Cliente</th>
                    <th>Clase</th>
                    <th style="min-width:100px">Rut Cliente</th>
                    <th>Última Facturación</th>
                    <th>Fecha Transacción</th>
                    <th>Monto</th>
                    <th>Orden de Compra</th>
                    <th>Cod. Autorización</th>
                    <th>Tipo Pago</th>
                    <th>Usuario</th>
                    <th>Observación</th>
                    <th style="max-width:100px">Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($datos)){ ?>
                    <?php foreach($datos as $k => $cliente){ ?>
                        <tr>        
                            <td><?php echo $cliente["t_cod_tran"]                   ?></td>
                            <td><?php echo $cliente["pagos"]                        ?></td>
                            <td><?php echo $cliente["clase"]                        ?></td>
                            <td><?php echo $cliente["rut"]                          ?></td>
                            <td><?php $newDate = date("d-m-Y", strtotime($cliente["t_fec_fac"]));echo $newDate ?></td>
                            <td><?php $newDate2 = date("d-m-Y H:i:s", strtotime($cliente["t_fecha_tbk"]));echo $newDate2 ?></td>
                            <td><?php echo '$'.number_format($cliente["t_val_plan"],0,"",".") ?></td>
                            <td><?php echo $cliente["t_buyorder"]                   ?></td>
                            <td><?php echo $cliente["t_authorizationcode"]          ?></td>
                            <td><?php echo $cliente["t_payment_type_code"]          ?></td>
                            <td><?php echo $cliente["usuario"]                      ?></td>
                            <td><?php echo $cliente["t_observa"]                    ?></td>
                            <td><button id="<?php echo $cliente["t_cod_tran"]?>" name="reversa" type="button" class="btn btn-danger" data-toggle="modal" data-target=".bd-example-modal-lg">Reversar</button>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>

        <div class="modal fade bd-example-modal-lg" id="revModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" style="padding:1%;">
                    <div class="modal-header">
                        <h2 class="modal-title" id="exampleModalLongTitle">Confirmacion</h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <br>
                    <div class="modal-body">
                        <div id="modalSummary">
                            <section>
                                <table id="example" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr style="background-color:#0049a2; color: white;">
                                            <th style="min-width:100px">Rut Cliente</th>
                                            <th>Última Facturación</th>
                                            <th>Fecha Transacción</th>
											<th>Tipo Pago</th>
                                            <th>Monto</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>        
                                            <td id="rut"   ></td>
                                            <td id="u_fac" ></td>
                                            <td id="f_tran"></td>
											<td id="tipo"  ></td>
                                            <td id="monto" ></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </section>
                        </div>
                        <br>
                        <div id="modalForm">
                            <div>
                                <label for="auth">Codigo de Autorizacion</label>
                                <input class="input" type="password" id="auth" placeholder="Ingrese Codigo de Autorizacion">
                            </div>
                            <div>
                                <label for="monto">Monto a Reversar (Reversa parcial habilitada solo tipo Credito)</label>
                                <input class="input" type="text" id="monto_reversa" placeholder="Ingrese Monto a Reversar">
                            </div>
                            <div>
                                <label for="observa">Observacion</label>
                                <textarea class="input" rows="3" id="observa"></textarea>
                            </div>
                        </div>
                        <div>
                            <h3 id="rev_resp"></h3>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="reversar">Confirmar</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php }elseif($transc == "R"){ ?>
    <section style="padding:2%;">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr style="background-color:#0049a2; color: white;">
                    <th>Cod. Reversa</th>
                    <th>Cod. Transac</th>
                    <th>Cod. Cliente</th>
                    <th>Clase</th>
                    <th style="min-width:100px">Rut Cliente</th>
                    <th>Fecha Facturación</th>
                    <th>Fecha Reversa</th>
                    <th>Monto Transac</th>
                    <th>Monto Reversado</th>
                    <th>Orden de Compra</th>
                    <th>Tipo Pago</th>
                    <th>Usuario</th>
                    <th>Observación</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($datos)){ ?>
                    <?php foreach($datos as $k => $cliente){ ?>
                        <tr>        
                            <td><?php echo $cliente["r_cod_rev"]                   ?></td>
                            <td><?php echo $cliente["r_cod_tran"]                   ?></td>
                            <td><?php echo $cliente["pagos"]                        ?></td>
                            <td><?php echo $cliente["clase"]                        ?></td>
                            <td><?php echo $cliente["rut"]                          ?></td>
                            <td><?php $newDate3 = date("d-m-Y", strtotime($cliente["r_fec_fac"]));echo $newDate3 ?></td>
                            <td><?php $newDate4 = date("d-m-Y H:i:s", strtotime($cliente["r_fecha_tbk"]));echo $newDate4 ?></td>
                            <td><?php echo '$'.number_format($cliente["r_val_mensual"],0,"",".") ?></td>
                            <td><?php echo '$'.number_format($cliente["r_val_plan"],0,"",".") ?></td>
                            <td><?php echo $cliente["r_buyorder"]                   ?></td>
                            <td><?php echo $cliente["r_payment_type_code"]          ?></td>
                            <td><?php echo $cliente["usuario"]                      ?></td>
                            <td><?php echo $cliente["r_observa"]                        ?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
    </section>
<?php }elseif($transc == "FR"){ ?>
    <section style="padding:2%;">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr style="background-color:#0049a2; color: white;">
                    <th>Cod. Fallida</th>
                    <th>Cod. Cliente</th>
                    <th>Clase</th>
                    <th style="min-width:100px">Rut Cliente</th>
                    <th>Fecha Facturación</th>
                    <th>Fecha Reversa Fallida</th>
                    <th>Monto Pago</th>
                    <th>Monto Reversa</th>
                    <th>Orden de Compra</th>
                    <th>Tipo Pago</th>
                    <th>Usuario</th>
                    <th>Observación</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($datos)){ ?>
                    <?php foreach($datos as $k => $cliente){ ?>
                        <tr>        
                            <td><?php echo $cliente["f_cod_fall"]                   ?></td>
                            <td><?php echo $cliente["pagos"]                        ?></td>
                            <td><?php echo $cliente["clase"]                        ?></td>
                            <td><?php echo $cliente["rut"]                          ?></td>
                            <td><?php $newDate3 = date("d-m-Y", strtotime($cliente["f_fec_fac"]));echo $newDate3 ?></td>
                            <td><?php $newDate4 = date("d-m-Y H:i:s", strtotime($cliente["t_fecha_tbk"]));echo $newDate4 ?></td>
                            <td><?php echo '$'.number_format($cliente["f_val_mensual"],0,"",".") ?></td>
                            <td><?php echo '$'.number_format($cliente["f_val_plan"],0,"",".") ?></td>
                            <td><?php echo $cliente["f_buyorder"]                   ?></td>
                            <td><?php echo $cliente["f_payment_type_code"]          ?></td>
                            <td><?php echo $cliente["usuario"]                      ?></td>
                            <td><?php echo $cliente["f_log"]                        ?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
    </section>
<?php } ?>
    <script>
        var id;
        
        $("#revModal").on("hidden.bs.modal", function () {
            location.reload();
        });
        
        $('button[name="reversa"]').click(function(){
            id = this.id;
            $.ajax({
                url: 'consulta_re_ajax.php',
                type: 'POST',
                dataType: "json",
                data: {function: 'getResumen', id: id},
                success: function(data){
                    document.getElementById('rut').innerHTML    = data[0][0];
                    document.getElementById('u_fac').innerHTML  = data[0][1];
                    document.getElementById('f_tran').innerHTML = data[0][2];
					if(data[0][3] == 'VN'){
						document.getElementById('tipo').innerHTML = 'Credito';
					}
					else{
						document.getElementById('tipo').innerHTML = 'Debito';
					}
                    document.getElementById('monto').innerHTML  = data[0][4];
                }
            });
        });
        
        $('#reversar').click(function(){
            var auth  = $('#auth').val();
            var monto = $('#monto_reversa').val();
            var obs   = $('#observa').val();
	        var userid = $('#userid').text();
	        var usuario = $('#usuario').text();
            if((auth == "") || (monto == "")){
                alert("Debe completar todos los campos para poder continuar.");
                //alert(monto);
            }
            else{
                //alert("userid: " + userid + ", usuario: " + usuario);
				$(this).hide();
                $.ajax({
                    url: 'consulta_re_ajax.php',
                    type: 'POST',
                    //dataType: "json",
                    data: {
                        function: 'reversar',
                        id: id,
                        auth: auth,
                        monto: monto,
                        obs: obs,
			            userid: userid,
			            usuario: usuario
                    },
                    success: function(data){
                        document.getElementById('rev_resp').innerHTML = data;
                    }
                });
            }
        });
    </script>
</body>