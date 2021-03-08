<?php
    include_once('admin/est/headerp.php');
    include_once('admin/config/func.php');
    $num_benef      = 7;
    $num_planes     = getNumPlanes();
    $nom_planes     = getNombrePlanes();
    $descrip_planes = getDescripPlan();
    $pago           = getTipoPago();
    $tipo_pago      = $pago[0];
    $cod_pago       = $pago[1];
    $num_mes        = $pago[2];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rest911 - Pago</title>
    <link rel="stylesheet" href="css/formulario2.css">
    <link rel="icon" href="img/logo.png">
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-170826221-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());
	  gtag('config', 'UA-170826221-1');
	</script>
    
    <!-- JQuery -->
    <script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous">
    </script>
</head>
<body>
    <input type="hidden" value="<?php echo $_GET["utm_source"]; ?>" id="utm_source">
    <input type="hidden" value="<?php echo $_GET["utm_medium"]; ?>" id="utm_medium">
    <input type="hidden" value="<?php echo $_GET["utm_campaign"]; ?>" id="utm_campaign">
    
    <form action="" method="post" id="tbkform">
        <input type="hidden" name="TBK_TOKEN" value="" id="tbk_token">
    </form>
    <div id="arriba">
        <div id="rest">
            <h4>REST911</h4><br>
            <p>Entrega soluciones de atención médica y de urgencia domiciliaria a todas las familias que buscan una atención oportuna en su domicilio y con profesionales calificados de la salud.</p>
        </div>
        <div id="beneficios">
            <h4>Beneficios</h4><br>
            <p><img src="img/tic.png"> Atendemos todo tipo de pacientes sin restricción de edad.</p>
            <p><img src="img/tic.png"> Atendemos pacientes con preexistencias.</p>
        </div>
        <div id="enun_bene">
            <br><br>
            <p><img src="img/tic.png"> Cobertura médica en todas las ciudades donde estamos presente.</p>
            <p><img src="img/tic.png"> Ciudades con atención REST911 Calama, Antofagasta, Copiapo, Coquimbo y La Serena</p>
        </div>
    </div>
    <form id="registro">
        <section>
            <div class="encabezado">
                <div class="titulo">
                    <h4>Paso 1</h4>
                </div>
                <div class="bajada_titulo">
                    <h2>Seleccione Plan a Contratar</h2>
                </div>
            </div>
            <div class="contenido">
                <div class="caja_simple">
                    <div class="contenido_caja">
                        <p>Atención por Médicos Certificados 24 horas, Orientación Telefónica Médica, Emisión de recetas médicas, Medicamentos para iniciar un tratamiento, Ordenes de exámenes y Certificados Médicos</p>
                    </div>
                </div>
                <div class="planes">
                    <?php for($i = 1; $i <= $num_planes; $i++){ ?>
                        <div class="plan">
                            <div class="titulo_caja">
                                <label class="container"><?php echo $nom_planes[$i - 1]?>
                                    <input type="radio" name="plan" value="<?php echo $i?>">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="franja_body">
                            </div>
                            <div class="contenido_caja">
                                <p><?php echo nl2br($descrip_planes[$i - 1]);?></p>
                            </div>
                        </div>
                    <?php } ?>
                </div> 
                <div class="caja_simple">
                    <div class="contenido_caja">
                        <div class="datos_pago">
                            <div class="columna izquerda">
                                <label for="num_benef"><b>Beneficiarios:</b></label>
                                <select class="input" id="num_benef">
                                    <?php for($i = 0; $i <= $num_benef; $i++){ ?>
                                        <?php if($i == 0){ ?>
                                            <option selected value="<?php echo $i?>">-</option>
                                        <?php } else { ?>
                                            <option value="<?php echo $i?>"><?php echo $i?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="columna derecha">
                                <div id="vm">
                                    Valor Mensual: <a id="valor_mensual"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="encabezado">
                <div class="titulo">
                    <h4>Paso 2</h4>
                </div>
                <div class="bajada_titulo">
                    <h2>Datos del Titular y Beneficiarios</h2>
                </div>
            </div>
            <div class="contenido">
                <div class="formulario">
                    <div class="titular" id="titular">
                        <label for="nombres">Nombres*</label>
                        <input required class="input" type="text" id="nombres"    placeholder="Nombres">
                        <div class="columnas">
                            <div class="columna izquerda">
                                <label for="apellido_p">Apellido Paterno*</label>
                                <input required class="input" type="text" id="apellido_p" placeholder="Apellido Paterno">
                                <label for="apellido_m">Apellido Materno*</label>
                                <input required class="input" type="text" id="apellido_m" placeholder="Apellido Materno">
                                <label for="RUT">RUT*</label>
                                <input required class="input" type="text" id="rut"        placeholder="RUT">
                                <label for="correo">Email*</label>
                                <input required class="input" type="email" id="correo"     placeholder="Correo Electrónico">
                                <label for="correo_conf">Confirmar Email*</label>
                                <input required class="input" type="email" id="correo_conf"     placeholder="Correo Electrónico">
                            </div>
                            <div class="columna derecha">
                                <label for="fecha_nac">Fecha de Nacimiento*</label>
                                <div id="fecha_nac">
                                    <select required class="input" id="dia">
                                        <option selected="true" disabled="disabled" value="0">día</option>
                                        <?php for($i = 1; $i <= 31; $i++){ ?>
                                            <?php if($i < 10){ ?>
                                                <option value="<?php echo "0$i"?>"><?php echo $i?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo $i?>"><?php echo $i?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                    <select required class="input" id="mes">
                                        <option selected="true" disabled="disabled" value="0">mes</option>
                                        <?php for($i = 1; $i <= 12; $i++){ ?>
                                            <?php if($i < 10){ ?>
                                                <option value="<?php echo "0$i"?>"><?php echo $i?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo $i?>"><?php echo $i?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                    <select required class="input" id="ano">
                                        <option selected="true" disabled="disabled" value="0">año</option>
                                        <?php for($i = 1920; $i <= 2020; $i++){ ?>
                                        <option value="<?php echo $i?>"><?php echo $i?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <label for="fono_p">Teléfono* (ej: 987654321)</label>
                                <input class="input" type="text" id="fono_p" maxlength="9" placeholder="9 dígitos" onkeypress="return controltag(event)">
                                <label for="fono_s">Teléfono 2</label>
                                <input class="input" type="text" id="fono_s" maxlength="9" placeholder="9 dígitos" onkeypress="return controltag(event)">
                                <label for="direccion">Dirección*</label>
                                <input required class="input" type="text" id="direccion"  placeholder="Dirección">
                                <label for="comunas">Ciudad*</label>
                                <select required class="input" id="comunas">
                                    <option value="ANTOFAGASTA">ANTOFAGASTA</option>
                                    <option value="CALAMA">CALAMA</option>
                                    <option value="COPIAPO">COPIAPO</option>
                                    <option value="COQUIMBO">COQUIMBO</option>
                                    <option value="LA SERENA">LA SERENA</option>
                                    <option value="SANTIAGO">SANTIAGO</option>
                                </select>
                            </div>
                        </div>
                        <p>(*) Campos Obligatorios</p>
                        <label class="container" id="soy_benef">Soy Beneficiario
                            <input type="checkbox" id="check_benef">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <input class="button" type="button" id="cont_benef" value="Continuar">
                    <div class="beneficiarios" id="beneficiarios">
                    </div>
                    <input class="button" type="button" id="cont_titular" value="Volver">
                    <input class="button" type="button" id="cont_modal" value="Continuar" data-toggle="modal" data-target="#exampleModalCenter">
		    <br><br>
                    <b>Ver mapas de cobertura:</b>
                    <br><a href="map/mapas_antofagasta.pdf" target="_blank">> Antofagasta</a>
                    <br><a href="map/mapas_calama.pdf"      target="_blank">> Calama</a>
                    <br><a href="map/mapas_copiapo.pdf"     target="_blank">> Copiapo</a>
                    <br><a href="map/mapas_coquimbo.pdf"    target="_blank">> Coquimbo</a>
                    <br><a href="map/mapas_laserena.pdf"    target="_blank">> La Serena</a>

                </div>
            </div>
        </section>
        <section>
            <div class="encabezado">
                <div class="titulo">
                    <h4>Paso 3</h4>
                </div>
                <div class="bajada_titulo">
                    <h2>Método de Pago</h2>
                </div>
            </div>
            <div class="contenido">
                <div class="caja_info">
                    <div class="titulo_caja">
                        <div class="nombre_caja">
                            Método de Pago
                        </div>
                    </div>
                    <div class="franja_body">
                    </div>
                    <div class="contenido_caja">
                        <p>Seleccione Tipo de Pago:</p>
                        <select class="input" id="tipo_pago">
                            <?php for($i = 1; $i <= sizeof($tipo_pago); $i++){ ?>
                                <?php if($i == 1){ ?>
                                    <option selected id="<?php echo $num_mes[$i - 1]?>" value="<?php echo $cod_pago[$i - 1]?>"><?php echo $tipo_pago[$i - 1]?></option>
                                <?php } else { ?>
                                    <option id="<?php echo $num_mes[$i - 1]?>" value="<?php echo $cod_pago[$i - 1]?>"><?php echo $tipo_pago[$i - 1]?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                        <div class="precios">
                            <div class="columna izquerda">
                                <p id="resalto">Precio Sin<br>Descuento: </p>
                                <p id="resalto">%Ahorro: </p>
                                <p id="resalto2">Valor a Pagar: </p>
                            </div>
                            <div class="columna derecha">
                                <p id="resalto"><a id="precio_sin_dscto">$</a></p>
                                <p id="resalto"><a id="ahorro">$</a></p>
                                <p id="resalto2"><a id="valor_pagar">$</a></p>
                            </div>
                        </div>
                        <label class="container"><a href="docu/Terminos%20y%20Condiciones%20REST911.pdf" download>Acepto Terminos y Condiciones</a>
                            <input id="tyc" type="checkbox">
                            <span class="checkmark"></span>
                        </label>
                        <button class="button" type="submit" disabled="true" id="btn_pagar">Pagar</button>
                    </div>
                </div>
            </div>
            <p id="cargos"><b>* </b>El Cargo se efectuará automáticamente cada 30 días para las suscripciones MES a MES <br><br>
            <b>* </b>En caso de consultas, puede enviar un mail a la siguiente dirección de correo: <a href="mailto:sac@rest911.cl">sac@rest911.cl</a></p>
        </section>
    </form>
    <div id="abajo">
        <div>
            <img src="img/rest_perro.jpg">
        </div>
        <div id="eslogan">
            <img src="img/logoc.png">
            <p id="frase">
                No sólo entregamos un gran beneficio para<br>
                tu tranquilidad, si no que nos comprometemos a dar un servicio de<br>
                excelencia las 24 horas del día y los 7 días de la semana
            </p>
        </div>
    </div>

    <!-- Boton -->
    <!-- <input class="button" type="button" id="cont_modal" value="Continuar" data-toggle="modal" data-target="#exampleModalCenter"> -->
    <!-- Modal -->

    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Aviso</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Al continuar no podrá volver a editar los datos del formulario, está seguro que desea continuar de todos modos?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Volver</button>
                    <button type="button" class="btn btn-primary" id="conf_modal" data-dismiss="modal">Continuar</button>
                </div>
            </div>
        </div>
    </div>
    <script src="js/formulario2.js"></script>
    <script src="js/ajax2.js"></script>

    <!-- JQuery JAM -->
    <script type="text/javascript"> function controltag(e) 
    {
        tecla = (document.all) ? e.keyCode : e.which;
        if (tecla==8) return true;
        else if (tecla==0||tecla==9)  return true;
       // patron =/[0-9\s]/;// -> solo letras
        patron =/[0-9\s]/;// -> solo numeros
        te = String.fromCharCode(tecla);
        return patron.test(te);
    }
	</script>
    <?php 
    include('admin/est/footerp.php');
    ?>
</body>