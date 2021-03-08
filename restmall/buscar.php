<!-- Menu -->
<?php
    session_start();
    if($_SESSION['rol'] != 1){
    header("location: ../login.php");    
    }
	$currentPage='index';
    include ('est/header.php');
    include_once "config/conexion.php";
    include "config/func.php";
    $fechahoy = getFecha();
    $class = 'T';
?>

<!-- CONTENIDO PAGINA -->
    <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv=”Content-Type” content=”text/html; charset=UTF-8″ />
    <title>Consulta de Clientes</title>
    <link rel="stylesheet" href="../css/transacciones.css">
    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script> 
</head>
<body>
    <section class="formulario">
        <h2>Consulta de Clientes por día</h2>
        
        <?php
        
            $bdesde = strtolower($_REQUEST['bdesde']);
            $bhasta = strtolower($_REQUEST['bhasta']);
            if(empty($_REQUEST['class'])){
                $class = 'T';
            }else{
                $class = $_REQUEST['class'];
            }
            if( (empty($bdesde)) && (empty($bhasta)) ){
                header("location: index.php");
                mysqli_close($conn);
            }
            $nave = "?bdesde=$bdesde&bhasta=$bhasta&class=$class";
        ?>
        
        <a href="exportar_pc.php?bdesde=<?php echo $bdesde ?>&bhasta=<?php echo $bhasta ?>&class=<?php echo $class ?>" class="btn btn-success pull-right" target="_blank">Exportar Transacciones</a>
        <a href="exportar_b.php?bdesde=<?php echo $bdesde ?>&bhasta=<?php echo $bhasta ?>&class=<?php echo $class ?>" class="btn btn-success pull-right" target="_blank">Exportar Beneficiarios</a>
        <form action="buscar.php" method="get" class="form_search">
            <div class="inputsss">
            <input type="radio" name="class" <?php if (isset($class) && $class=="T") echo "checked";?> value="T"><label for="solo_t">Todos</label></div>
            <div class="inputsss">
            <input type="radio" name="class" <?php if (isset($class) && $class=="A") echo "checked";?> value="A"><label for="solo_a">Clase A</label></div>
            <div class="inputsss">
            <input type="radio" name="class" <?php if (isset($class) && $class=="B") echo "checked";?> value="B"><label for="solo_b">Clase B</label></div>
            <div class="inputsss">
            <input type="radio" name="class" <?php if (isset($class) && $class=="C") echo "checked";?> value="C"><label for="solo_c">Clase C</label></div>
            <div class="inputsss">
            <label for="busqueda">Desde: </label>
            <input type="date" step="1" min="2020-04-01" max="<?php echo $fechahoy?>" value="<?php echo $bdesde ?>" name="bdesde" id="bdesde" placeholder="Desde"></div>
            <div class="inputsss">
            <label for="hasta"> Hasta: </label>
            <input type="date" step="1" min="2020-04-01" max="<?php echo $fechahoy?>" value="<?php echo $bhasta ?>" name="bhasta" id="bhasta" placeholder="Hasta"></div>
            <input type="submit" name="Buscar" class="btn_buscar" value="Buscar">
        </form>
        
        <table>
            <tr>
                <th style="width:30px; padding-left:20px;"> Cod</th>
                <th>Clase</th>
                <th>Fecha</th>
                <th>Nombre</th>
                <th>RUT</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Estado</th>
                <th style="width:50px;">Acción</th>
            </tr>
        </table>
        <div class="accordion" id="accordionExample">
            <?php
            //Paginador
            $sql_register = mysqli_query($conn, "SELECT COUNT(*) as total_registro FROM pagos_clientes WHERE ((CAST(FEC_PAG AS DATE) >= '$bdesde') AND (CAST(FEC_PAG AS DATE) <= '$bhasta') AND (IF('T' != '$class', clase = '$class', clase IS NOT NULL)) ) ");
            /*if(!$sql_register){
                echo mysqli_error();
            }*/
            $result_register = mysqli_fetch_array($sql_register);
            $total_registro = $result_register['total_registro'];
            $por_pagina = 10;
            if(empty($_GET['pagina'])){
                $pagina = 1;
            }else{
                $pagina = $_GET['pagina'];
            }
            
            $desde = ($pagina - 1) * $por_pagina;
            $total_paginas = ceil($total_registro / $por_pagina);
            
            $query = mysqli_query($conn, "SELECT p.pagos, p.fec_pag, CAST(FEC_PAG AS TIME) as hora, p.t_nombres, p.t_apellido1, p.t_apellido2, p.rut, p.t_fec_nac, p.email, p.telefono, p.telefono2, p.direccion, p.comuna, p.cod_plan, p.nom_plan, p.num_benef, p.valor_plan_benef, p.cod_pago, p.tipo_pago, p.cant_descuento, p.valor_plan, CASE 
            WHEN p.estado = 'N' THEN 'SOLO REST911'
            WHEN p.estado = 'E' THEN 'ABANDONO TBK'
            WHEN p.estado = 'T' THEN 'RECHAZO TBK'
            WHEN p.estado = 'R' THEN 'RECHAZA COBRO'
            WHEN p.estado = 'S' THEN 'TRANSACC EXITOSA'
            WHEN p.estado = 'I' THEN 'SUSCRIPCION'
            WHEN p.estado = 'M' THEN 'MOROSO'
            WHEN p.estado = 'D' THEN 'DESVINCULADO'
            ELSE 'N/A'
            END AS estado, p.token, p.buyorder, p.authorizationcode, p.payment_type_code, p.creditcardtype, p.last4carddigits, p.tbkuser, p.username, p.fecha_tbk, DATE_ADD(p.fec_fac,INTERVAL '1' MONTH) as fec_fac, 
            CASE
            WHEN p.clase = 'A' THEN '(A) Autocontratados'
            WHEN p.clase = 'B' THEN '(B) Inscripción y Cobro'
            WHEN p.clase = 'C' THEN '(C) Solo Inscripción'
            ELSE 'N/A'
            END AS clase, p.observa, p.c_envio,
            IF (SUBSTR(p.responsecode, 1, 1) = 'i',
            CASE
            WHEN LTRIM(RTRIM(p.responsecode)) = '0' THEN ''
            WHEN LTRIM(RTRIM(SUBSTR(p.responsecode, 2))) = '-1' THEN 'ERROR -1 => Rechazo de transacción - Reintente (Posible error en el ingreso de datos de la transacción)'
            WHEN LTRIM(RTRIM(SUBSTR(p.responsecode, 2))) = '-2' THEN 'ERROR -2 => Rechazo de transacción (Se produjo fallo al procesar la transacción. Este mensaje de rechazo está relacionado a parámetros de la tarjeta y/o su cuenta asociada)'
            WHEN LTRIM(RTRIM(SUBSTR(p.responsecode, 2))) = '-3' THEN 'ERROR -3 => Error en transacción (Interno Transbank)'
            WHEN LTRIM(RTRIM(SUBSTR(p.responsecode, 2))) = '-4' THEN 'ERROR -4 => Rechazo emisor (Rechazada por parte del emisor)'
            WHEN LTRIM(RTRIM(SUBSTR(p.responsecode, 2))) = '-5' THEN 'ERROR -5 => Rechazo - Posible Fraude (Transacción con riesgo de posible fraude)'
            ELSE 'No Específica'
            END,
            CASE
            WHEN LTRIM(RTRIM(p.responsecode)) = '0' THEN ''
	        WHEN CAST(LTRIM(RTRIM(SUBSTR(p.responsecode, 2))) AS SIGNED) > -9 AND CAST(SUBSTR(p.responsecode, 2) AS SIGNED) < 0 THEN 'RECHAZO TBK'
            WHEN LTRIM(RTRIM(SUBSTR(p.responsecode, 2))) = '-96' THEN 'ERROR -96 => NO EXISTE INCRIPCION ASOCIADA'
            WHEN LTRIM(RTRIM(SUBSTR(p.responsecode, 2))) = '-97' THEN 'ERROR -97 => LIMITES ONECLICK (MAXIMO MONTO DIARIO DE PAGO EXCEDIDO)'
            WHEN LTRIM(RTRIM(SUBSTR(p.responsecode, 2))) = '-98' THEN 'ERROR -98 => LIMITES ONECLICK (MAXIMO MONTO DE PAGO EXCEDIDO)'
            WHEN LTRIM(RTRIM(SUBSTR(p.responsecode, 2))) = '-99' THEN 'ERROR -99 => LIMITES ONECLICK (MAXIMA CANTIDAD DE PAGO EXCEDIDO)'
            WHEN CAST(LTRIM(RTRIM(p.responsecode)) AS SIGNED) > -9 AND CAST(p.responsecode AS SIGNED) < 0 THEN 'RECHAZO TBK'
            WHEN LTRIM(RTRIM(p.responsecode)) = '-96' THEN 'ERROR -96 => NO EXISTE INCRIPCION ASOCIADA'
            WHEN LTRIM(RTRIM(p.responsecode)) = '-97' THEN 'ERROR -97 => LIMITES ONECLICK (MAXIMO MONTO DIARIO DE PAGO EXCEDIDO)'
            WHEN LTRIM(RTRIM(p.responsecode)) = '-98' THEN 'ERROR -98 => LIMITES ONECLICK (MAXIMO MONTO DE PAGO EXCEDIDO)'
            WHEN LTRIM(RTRIM(p.responsecode)) = '-99' THEN 'ERROR -99 => LIMITES ONECLICK (MAXIMA CANTIDAD DE PAGO EXCEDIDO)'
            ELSE 'No Específica'
            END) AS responsecode FROM pagos_clientes p WHERE ((CAST(FEC_PAG AS DATE) >= '$bdesde') AND (CAST(FEC_PAG AS DATE) <= '$bhasta') AND (IF('T' != '$class', clase = '$class', clase IS NOT NULL)) ) order BY FEC_PAG DESC LIMIT $desde, $por_pagina");
            $result = mysqli_num_rows($query);
            if($result > 0){
                $i = 1;
                while($data = mysqli_fetch_array($query)){
                    if($data["valor_plan"] != 115){
            ?>
                        <div class="card">
                            <div class="card-header" id="heading<?php echo $i; ?>">
                                <h2 class="mb-0" style="text-align: left;">
                                    <div style="max-width:30px;"><?php echo $data["pagos"] ?></div>
                                    <div style="padding-left:50px;"><?php echo $data["clase"]?></div>
                                    <div><?php $newDate = date("d-m-Y H:i:s", strtotime($data["fec_pag"]));echo $newDate ?></div>
                                    <div><?php echo $data["t_nombres"]." ".$data["t_apellido1"]?></div>
                                    <div style="text-align: center;"><?php echo $data["rut"]?></div>
                                    <div><?php echo $data["email"]?></div>
                                    <div style="text-align: center;"><?php echo $data["telefono"]?></div>
                                    <div><?php echo $data["estado"]?></div>
                                    <div style="width:45px;">
                                        <button class="btn btn-link <?php if($i>1) echo "collapsed"; ?>" name="card-title" type="button" data-toggle="collapse" data-target="#collapse<?php echo $i; ?>" aria-expanded="false" aria-controls="collapse<?php echo $i; ?>">
                                            <a class="link_expand">Ver</a>
                                        </button>
                                    </div>
                                </h2>
                            </div>
                            <div id="collapse<?php echo $i; ?>" class="collapse" aria-labelledby="heading<?php echo $i; ?>" data-parent="#accordionExample">
                                <div class="card-body">
                                    <div>
                                        <b>Nombre:</b> <?php echo $data["t_nombres"]." ".$data["t_apellido1"]." ".$data["t_apellido2"]?><br>
                                        <b>Fecha de Nacimiento:</b> <?php echo $data["t_fec_nac"]?><br>
                                        <b>Segundo Telefóno:</b> <?php echo $data["telefono2"]?><br>
                                        <b>Comuna:</b> <?php echo $data["comuna"]?><br>
                                        <b>Dirección:</b> <?php echo $data["direccion"]?><br>
                                        <b>Codigo del Plan:</b> <?php echo $data["cod_plan"]?><br>
                                        <b>Nombre del plan:</b> <?php echo $data["nom_plan"]?><br>
                                        <b>Cantidad de Beneficiarios:</b> <?php echo $data["num_benef"]?><br>
                                        <b>Valor del Plan:</b> <?php echo $data["valor_plan_benef"]?><br>
                                        <b>Codigo de Pago:</b> <?php echo $data["cod_pago"]?><br>
                                        <b>Tipo de pago:</b> <?php echo $data["tipo_pago"]?><br>
                                        <b>Cantidad de descuento:</b> <?php echo $data["cant_descuento"]?><br>
                                        <b>Valor Cancelado:</b> <?php echo $data["valor_plan"]?><br>
                                        <b>Token TBK:</b> <?php echo $data["token"]?><br>
                                        <b>Orden de compra</b> <?php echo $data["buyorder"]?><br>
                                        <b>Codigo Autorización TBK:</b> <?php echo $data["authorizationcode"]?><br>
                                        <b>Codigo del Tipo de pago:</b> <?php echo $data["payment_type_code"]?><br>
                                        <b>Tipo de tarjeta:</b> <?php echo $data["creditcardtype"]?><br>
                                        <b>Ultimos 4 digitos:</b> <?php echo $data["last4carddigits"]?><br>
                                        <b>Usuario TBK:</b> <?php echo $data["username"]?><br>
                                        <b>Cod. Usuario Transbank:</b> <?php echo $data["tbkuser"]?><br>
                                        <b>Fecha TBK:</b> <?php $newDate_tbk = date("d-m-Y H:i:s", strtotime($data["fecha_tbk"]));echo $newDate_tbk ?><br>
                                        <b>Siguiente Facturación:</b> <?php $newDate_fac = date("d-m-Y", strtotime($data["fec_fac"]));echo $newDate_fac ?><br>
                                        <b>Tipo de cliente:</b> <?php echo $data["clase"]?><br>
                                        <b>Tipo de Error:</b> <?php echo $data["responsecode"]?><br>
                                        <b>Correo interno enviado:</b> <?php echo $data["c_envio"]?><br>
                                        <b>Observaciónes:</b> <?php echo $data["observa"]?><br>
                                    </div>
                                    <div>
            <?php
                $pagosid = $data["pagos"];
                
                $query_benef = mysqli_query($conn, "SELECT COUNT(*) as cant_benef FROM beneficiarios WHERE pagos = $pagosid");
                $result_benef = mysqli_fetch_array($query_benef);
                $cant_benef = $result_benef["cant_benef"];
                
                $query_3 = mysqli_query($conn, "SELECT b.pagos, b.nombres, b.apellido1, b.apellido2, b.fec_nac, b.cor_benef FROM beneficiarios b WHERE b.pagos = $pagosid ORDER BY b.cor_benef ASC ");
                        
                $results = mysqli_num_rows($query_3);
                if($results > 0){        
                    
                    while($datab = mysqli_fetch_array($query_3)){
                ?>
                
                                    
                                        <b>Beneficiario <?php echo $datab["cor_benef"]?></b><br>
                                        Nombres: <?php echo $datab["nombres"]?> <?php echo $datab["apellido1"]?> <?php echo $datab["apellido2"]?> <br>
                                        Fecha de Nacimiento: <?php echo $datab["fec_nac"]?><br> 
                                    
                <?php 
                    
                       }
                    }
                
                ?>
                                    </div>
                                </div>
                            </div>
                        </div>
            <?php
                    }
                $i++;
                }
            }
            ?>
        </div>
        <div class="paginador">
            <h6s>Total de registros: <?php echo $total_registro ?> </h6s>
            <ul>
            <?php
                if($pagina != 1)
                {
            ?>
                <li><a href="<?php echo $nave; ?>&pagina=<?php echo 1; ?>">|<</a></li>
                <li><a href="<?php echo $nave; ?>&pagina=<?php echo $pagina-1; ?>"><<</a></li>
            <?php
                }

                if($total_paginas >= 5){
                    if($pagina < 3){
                        for($i = 1; $i <= 5; $i++){

                            if($i == $pagina)
                            {
                                echo '<li class="pageSelected">'.$i.'</li>';
                            }else{
                                echo '<li><a href="'.$nave.'&pagina='.$i.'">'.$i.'</a></li>';
                            } 
                        }
                    }elseif($pagina+1 >= $total_paginas){
                        for($i = $total_paginas-4; $i <= $total_paginas; $i++){

                            if($i == $pagina)
                            {
                                echo '<li class="pageSelected">'.$i.'</li>';
                            }else{
                                echo '<li><a href="'.$nave.'&pagina='.$i.'">'.$i.'</a></li>';
                            } 
                        }
                    }else{
                        for($i = $pagina-2; $i <= $pagina+2; $i++){

                            if($i == $pagina)
                            {
                                echo '<li class="pageSelected">'.$i.'</li>';
                            }else{
                                echo '<li><a href="'.$nave.'&pagina='.$i.'">'.$i.'</a></li>';
                            } 
                        }
                    }
                }else{
                    for($i = 1; $i <= $total_paginas; $i++){

                        if($i == $pagina)
                        {
                            echo '<li class="pageSelected">'.$i.'</li>';
                        }else{
                            echo '<li><a href="'.$nave.'&pagina='.$i.'">'.$i.'</a></li>';
                        } 
                    }
                }
                
                if($pagina != $total_paginas)
                {
            ?>
                <li><a href="<?php echo $nave; ?>&pagina=<?php echo $pagina+1; ?>">>></a></li>
                <li><a href="<?php echo $nave; ?>&pagina=<?php echo $total_paginas; ?>">>|</a></li>
            <?php } mysqli_close($conn); ?>
            </ul>
        </div>
    </section>
</body>
</html>
    
<!-- Footer -->
<?php include 'estructura/footer.php'?> 