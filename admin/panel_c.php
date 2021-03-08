<?php
require_once 'panel_c_ajax.php';
$HcurrentPage = "panel_c";
include_once "config/permisos.php";

session_start();
$rol = $_SESSION['rol'];
$currentPage = "panel_c";
$acceso = getPermisos($currentPage, $rol);
if(!$acceso){
    header("location: ../login.php");    
}
include_once ('est/headerc.php');

$datos = getDatosClientes();
$cont  = 1;
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
    <title>Rest911 - Cobros</title>
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
    
    <!-- Datatable -->
    <script>
        $(document).ready(function(){
            var tabla = $('#example').dataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
                },
                stateSave: true,
            });

	    $("#submit").hide();
            
            //Permite seleccionar todos los checkboxes existentes a traves de las páginas
            var paginas = tabla.fnGetNodes();
            $('section').on('click', '#select-all', function () {
                if($(this).hasClass('allChecked')) {
                    $('input[type="checkbox"]', paginas).prop('checked', false);
                    $("#select-all").text("Seleccionar todos");
                }
                else{
                    $('input[type="checkbox"]', paginas).prop('checked', true);
                    $("#select-all").text("Deseleccionar todos");
                }
                $(this).toggleClass('allChecked');
            });

	    $('#exampleModalCenter').on('shown.bs.modal', function (e) {
		var flag = false;
  	        var checked = $("input:checked");
		if(checked.length > 0){
		    $("#exampleModalLongTitle").text("Confirmacion");
		    $("#exampleModalBody").text('Al presionar el boton "Aceptar" procedera a realizar los cobros seleccionados anteriormente.');
		    $("#close").hide();
		    $("#submit").show();
		}
	    });

            //Manda la informacion de los checkbox seleccionados al presionar el boton
            $('#submit').click(function(){
                var checkboxes = [];
                $("input:checked", tabla.fnGetNodes()).each(function(){
                    checkboxes.push($(this).attr("id"));
                });
				var userid = $('#userid').text();
                $.ajax({
                    url: 'panel_c_ajax.php',
                    type: 'POST',
                    dataType: "json",
                    data: {function: 'cobrarClientes', ids: checkboxes, userid: userid},
                    success: function(data){
                        mostrarResultados(data);
                    }
                });
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
    <section style="padding:2%;">
        <div style="display: flex; justify-content: space-between;">
	    <h2>Panel de Cobros</h2>
	    <h5>Usuario: <?php echo $_SESSION['usuario']; ?></h5>
	</div>
        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr style="background-color:#0049a2; color: white;">
                    <th>Seleccionar</th>
                    <th>Cod. Cliente</th>
                    <th>Clase</th>
                    <th>RUT</th>
                    <th>Ingreso Sistema</th>
                    <th>Meses Iniciales</th>
                    <th>Siguiente Facturación</th>
                    <th>Último pago</th>
                    <th>Monto Mensual</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($datos)){ ?>
                    <?php foreach($datos as $k => $cliente){ ?>
                        <tr>        
                            <td><input type="checkbox" id="<?php echo $cliente["pagos"]?>"><?php echo " ".$cont ?></td>
                            <td><?php echo $cliente["pagos"]                ?></td>
                            <td><?php echo $cliente["clase"]                ?></td>
                            <td><?php echo $cliente["rut"]                  ?></td>
                            <td><?php echo date("d-m-Y", strtotime($cliente["fec_pag"]))?></td>
                            <td><?php echo $cliente["num_mes"]              ?></td>
                            <td><?php echo date("d-m-Y", strtotime(addMonths($cliente["fec_fac"], 1)))?></td>
                            <?php if(!empty($cliente["t_fecha_tbk"])){ ?>
                                <td><?php echo date("d-m-Y", strtotime($cliente["t_fecha_tbk"]))?></td>
                            <?php } else{ ?>
                                <td><?php echo "Sin registro"             ?></td>
                            <?php } ?>
			    <?php if($cliente["clase"] == 'C'){ ?>
                            	<td><?php echo '$'.number_format($cliente["valor_plan"],0,"",".") ?></td>
			    <?php } else{ ?>
				<td><?php echo '$'.number_format($cliente["valor_plan_benef"],0,"",".") ?></td>
			    <?php } ?>
                        </tr>
                        <?php $cont++; ?>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
        <br>
        <button type="button" id="select-all" class="btn btn-primary">Seleccionar todos</button>
        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#exampleModalCenter">Procesar</button>
        
	<!-- Modal -->
	<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  	    <div class="modal-dialog modal-dialog-centered" role="document">
    		<div class="modal-content">
      		    <div class="modal-header">
        		<h5 class="modal-title" id="exampleModalLongTitle">Alerta</h5>
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          		    <span aria-hidden="true">&times;</span>
        		</button>
      		    </div>
      		    <div class="modal-body" id="exampleModalBody">
        		Para proceder al pago automatico debe seleccionar al menos un cliente al cual cobrar.
      		    </div>
      		    <div class="modal-footer">
			<button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">Close</button>
        		<button type="button" id="submit" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
      		    </div>
    		</div>
  	    </div>
	</div>

        <div class="big-modal">
	    <!-- Modal -->
            <div class="modal fade" id="transacciones" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Resultado de Transacciones</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                        <div class="modal-body">
			    <div class="modal-title" style="display: flex; justify-content: space-between;">
                                <h5 id="tituloEx">Transacciones Exitosas: </h5>
			        <h5 id="montoEx" style="right: 0;">Monto Total: </h5>
			    </div>
                            <table id="tablaExitosa" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>RUT</th>
                                        <th>Nombre</th>
                                        <th>Fecha TBK</th>
                                        <th>Monto</th>
                                        <th>Orden de Compra</th>
                                        <th>Tipo de Pago</th>
                                        <th>Resumen</th>
                                    </tr>
                                </thead>
                                <tbody id="transExito">
                                </tbody>
                            </table>
                            <br>
                            <div class="modal-title" style="display: flex; justify-content: space-between;">
                                <h5 id="tituloRe">Transacciones Fallidas: </h5>
			        <h5 id="montoRe" style="right: 0;">Monto Total: </h5>
			    </div>
			    <table id="tablaRechazada" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>RUT</th>
                                        <th>Nombre</th>
                                        <th>Fecha TBK</th>
                                        <th>Monto</th>
                                        <th>Orden de Compra</th>
                                        <th>Tipo de Pago</th>
                                        <th>Cód. Error</th>
                                    </tr>
                                </thead>
                                <tbody id="transError">
                                </tbody>
                            </table>
                         </div>
                         <div class="modal-footer">
                             <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                         </div>
                    </div>
                </div>
            </div>
	</div>
    </section>
    
    <script>
        $("#transacciones").on("hidden.bs.modal", function () {
            location.reload();
        });

	    function formatNumber(num) {
    	    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
	    }
        
        function mostrarResultados(datos){
            var htmlExitosa = '';
            var htmlRechazada = '';
            var registrosEx = 0;
            var registrosRe = 0;
	        var ganancia = 0;
	        var perdida = 0;
            datos.forEach(function(resultado, index){
                if(resultado.cod == 0 || resultado.cod == 100 || resultado.cod == 101){
                    ganancia += parseInt(resultado.monto);
                    registrosEx++;
                    htmlExitosa += '<tr>'
                                    + '<td>' + resultado.id     + '</td>'
                                    + '<td>' + resultado.rut    + '</td>'
                                    + '<td>' + resultado.nombre + '</td>'
                                    + '<td>' + resultado.fecha  + '</td>'
                                    + '<td>' + '$' + formatNumber(resultado.monto)  + '</td>'
                                    + '<td>' + resultado.orden  + '</td>'
                                    + '<td>' + resultado.pago   + '</td>'
                                    + '<td>' + resultado.resp   + '</td>'
                                 + '</tr>';
                }
                else{
		            perdida += parseInt(resultado.monto);
                    registrosRe++;
                    htmlRechazada += '<tr>'
                                      + '<td>' + resultado.id     + '</td>'
                                      + '<td>' + resultado.rut    + '</td>'
                                      + '<td>' + resultado.nombre + '</td>'
                                      + '<td>' + resultado.fecha  + '</td>'
                                      + '<td>' + '$' + formatNumber(resultado.monto)  + '</td>'
                                      + '<td>' + resultado.orden  + '</td>'
                                      + '<td>' + resultado.pago   + '</td>'
                                      + '<td>' + resultado.error   + '</td>'
                                   + '</tr>';
                }
            });
            document.getElementById('transExito').innerHTML = htmlExitosa;
            document.getElementById('transError').innerHTML = htmlRechazada;
            
            document.getElementById('tituloEx').innerHTML += registrosEx;
	        document.getElementById('montoEx').innerHTML += '$' + formatNumber(ganancia);

            document.getElementById('tituloRe').innerHTML += registrosRe;
	        document.getElementById('montoRe').innerHTML += '$' + formatNumber(perdida);
	            
            $('#transacciones').modal();
        }
    </script>
</body>