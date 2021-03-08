
<?php
error_reporting(E_ERROR | E_PARSE);
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
    $randomNumber = rand(); 
?>

<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="facebook-domain-verification" content="kdyvg3elrsxn39mlv78686royvyroj" />
    <title>Rest911 - Pago</title>
    <!--<link rel="stylesheet" href="css/formulario2.css">-->
    <link rel="icon" href="img/logo.png">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;1,800&display=swap" rel="stylesheet">
    <!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-170826221-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());
	  gtag('config', 'UA-170826221-1');
	</script>
  
    <link href="css/app.css?v=<?php echo $randomNumber; ?>" rel="stylesheet">
   <!-- Event snippet for Cliente potencial conversion page In your html page, add the snippet and call gtag_report_conversion when someone clicks on the chosen link or button. --> <script> function gtag_report_conversion(url) { var callback = function () { if (typeof(url) != 'undefined') { window.location = url; } }; gtag('event', 'conversion', { 'send_to': 'AW-701895642/ZmuNCI_xy68BENqn2M4C', 'event_callback': callback }); return false; } </script>
   
    
    <!-- JQuery -->
    <script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous">
    </script>
</head>
<body>
     <!-- Google Tag Manager (noscript) -->
     <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WTGGS8G"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
<input type="hidden" value="<?php echo $_GET["utm_source"]; ?>" id="utm_source">
    <input type="hidden" value="<?php echo $_GET["utm_medium"]; ?>" id="utm_medium">
    <input type="hidden" value="<?php echo $_GET["utm_campaign"]; ?>" id="utm_campaign">
    
    <form action="" method="post" id="tbkform">
        <input type="hidden" name="TBK_TOKEN" value="" id="tbk_token">
    </form>
    <main>
        <section class="hero" style="background: url('img/home-img.jpg')">
            <header class="hero-header">
                <h1 class="hero-title">Entregamos soluciones de <br> atención médica y de urgencia <br> domiciliaria.</h1>
                <div class="d-flex flex-column sub-hero__header m-t-25">
                    <p>
                        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0zm0 0h24v24H0V0z" fill="none"/><path d="M16.59 7.58L10 14.17l-3.59-3.58L5 12l5 5 8-8zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"/></svg>
                        <span>Atendemos todo tipo de pacientes sin restricción de edad.</span>
                    </p>
                    <p>
                        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0zm0 0h24v24H0V0z" fill="none"/><path d="M16.59 7.58L10 14.17l-3.59-3.58L5 12l5 5 8-8zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"/></svg>
                        <span>Atendemos pacientes con preexistencias.</span>
                    </p>
                    <p>
                        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0zm0 0h24v24H0V0z" fill="none"/><path d="M16.59 7.58L10 14.17l-3.59-3.58L5 12l5 5 8-8zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"/></svg>
                        <span> Cobertura médica en antofagasta, Calama, Copiapó, Coquimbo y La Serena.</span>
                    </p>
                </div>
                <button class="btn btn-primary-header m-t-15">
                    contrata tu plan aquí
                </button>
            </header>
        </section>
        <section class="hidden-min suscribir-mobile">
            <div class="container">
                <div class="d-flex flex-column collapse-container">
                    <div class="items-collapse-primary">
                        <span> PLAN SIN COPAGO</span>
                        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M11.29 8.71L6.7 13.3c-.39.39-.39 1.02 0 1.41.39.39 1.02.39 1.41 0L12 10.83l3.88 3.88c.39.39 1.02.39 1.41 0 .39-.39.39-1.02 0-1.41L12.7 8.71c-.38-.39-1.02-.39-1.41 0z"/></svg>
                    </div>
                    <div class="content-collapse">
                        <div class="section__tables">
                            <div class="title__pricing m-b-10">
                                Plan Sin Copago
                            </div>
                            <div class=" color-default">
                                Desde
                            </div>
                            <div class="price__pricing">
                                $19.990
                            </div>
                            <div class=" color-default">
                                Valor Mensual
                            </div>
                            <ul class="list__details__pricing">
                                <li>
                                    <span class="color-blue">Emergencias y Urgencias GRATUITAS</span>
                                </li>
                                <li>
                                    <span>Consultas Médicas ILIMITADAS</span>
                                </li>
                                <li>
                                    <span>Traslado de Ambulancias SIN COSTO</span>
                                </li>
                                <li>
                                    <span>Disponibilidad las 14 horas los 365 días</span>
                                </li>
                                <li>
                                    <span>ALO Doctor 24/7 disponible</span>
                                </li>
                                <li>
                                    <span>Entrega de primera medicación de emergencia</span>
                                </li>
                                <li>
                                    <span>Pago Automático Mensual</span>
                                </li>
                            </ul>
                            <div class="container__btn">
                                <button class="btn__table__main">
                                    SIGUIENTE
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="items-collapse-primary sub-color">
                        <span>PLAN CON COPAGO</span>
                        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M11.29 8.71L6.7 13.3c-.39.39-.39 1.02 0 1.41.39.39 1.02.39 1.41 0L12 10.83l3.88 3.88c.39.39 1.02.39 1.41 0 .39-.39.39-1.02 0-1.41L12.7 8.71c-.38-.39-1.02-.39-1.41 0z"/></svg>
                    </div>
                    <div class="content-collapse">
                            <div class="d-flex justify-content-center m-t-15 flex-column align-items-center">
                                <a href="" class="color-blue m-b-20" style="text-decoration: underline;font-weight:900">
                                    Mapa de cobertura
                                </a>
                                <div class="container-consulta-servicio">
                                    <div class="m-b-10  p-t-15" style="font-weight:400; border-top: 1px solid #e0e0e0">
                                        Consultas del servicio:
                                    </div>
                                    <div class="color-default">
                                        comercial@rest911.cl
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="">
                
                </div>
            </div>
        </section>
        <section class="padding-section reset-section suscribir" style="background: #e7f2ff">
                <h2 class="main-text__section m-t-10 m-b-45">Suscríbete a nuestros planes</h2>

                <div class="section__tables">
                    <div class="table__pricing">
                        <div class="title__pricing m-b-10">
                            Plan Sin Copago
                        </div>
                        <div class=" color-default">
                            Desde
                        </div>
                        <div class="price__pricing">
                            $19.990
                        </div>
                        <div class=" color-default" id="vm">
                            Valor Mensual
                        </div> 
                        <ul class="list__details__pricing">
                            <li>
                                <span class="color-blue">Emergencias y Urgencias GRATUITAS</span>
                            </li>
                            <li>
                                <span>Consultas Médicas ILIMITADAS</span>
                            </li>
                            <li>
                                <span>Traslado de Ambulancias SIN COSTO</span>
                            </li>
                            <li>
                                <span>Disponibilidad las 14 horas los 365 días</span>
                            </li>
                            <li>
                                <span>ALO Doctor 24/7 disponible</span>
                            </li>
                            <li>
                                <span>Entrega de primera medicación de emergencia</span>
                            </li>
                            <li>
                                <span>Pago Automático Mensual</span>
                            </li>
                        </ul>
                        <div class="container__btn">
                            <button class="btn__table__main">
                                SIGUIENTE
                            </button>
                        </div>
                    </div>
                    <div class="table__pricing">
                        <div class="title__pricing m-b-10">
                            Plan Sin Copago
                        </div>
                        <div class=" color-default">
                            Desde
                        </div>
                        <div class="price__pricing">
                            $19.990
                        </div>
                        <div class=" color-default">
                            Valor Mensual
                        </div>
                        <ul class="list__details__pricing">
                            <li>
                                <span class="color-blue">Emergencias y Urgencias GRATUITAS</span>
                            </li>
                            <li>
                                <span>Consultas Médicas ILIMITADAS</span>
                            </li>
                            <li>
                                <span>Traslado de Ambulancias SIN COSTO</span>
                            </li>
                            <li>
                                <span>Disponibilidad las 14 horas los 365 días</span>
                            </li>
                            <li>
                                <span>ALO Doctor 24/7 disponible</span>
                            </li>
                            <li>
                                <span>Entrega de primera medicación de emergencia</span>
                            </li>
                            <li>
                                <span>Pago Automático Mensual</span>
                            </li>
                        </ul>
                        <div class="container__btn">
                            <button class="btn__table__main color__secondary__main">
                                SIGUIENTE
                            </button>
                        </div>
                    </div>
                </div>
                <small class="m-t-45" style="text-align:center;margin-top: 50px;display:block">*El cargo de nuestras suscripciones se realizará de forma automática</small>
        </section>

        <section class="padding-section reset-section">
                <h2 class="main-text__section m-t-10 m-b-45">Plan Sin Copago</h2>
                <div class="color-default" style="text-align:center">
                    Atención por Médicos Certificados 24 Horas, Orientación Telefónica Médica, Emisión de recetas médicas, <br> Medicamentos para iniciar un tratamiento, Ordenes de exámenes y Certificados Médicos.
                </div>
                <form action="" id="registro">
                <div class="container-step m-t-40">
                    <div class="container">
                        <div class="d-flex align-items-center justify-content-center flex-column">
                            <div class="progress-container">
                                <div class="progress" id="progress"></div>
                                <div class="circle active">1</div>
                                <div class="circle">2</div>
                                <div class="circle">3</div>
                               

                            </div>
                            <div class="container-steps">
                                <div class="container-items-step" data-id="0" >
                                    <div class="d-flex justify-content-between m-t-40 m-b-40 flex-column-max">
                                        <div class="hidden-min m-b-10 color-blue" style="font-weight: 700">
                                            Beneficiario
                                        </div>
                                        <div class="">


                                            <div class="cont_select_center">
                                                <div class="select_mate" data-mate-select="active" >
                                                <select class="input" id="num_benef" name="" onchange="" onclick="return false;" id="">
                                                    <?php for($i = 0; $i <= $num_benef; $i++){ ?>
                                                        <?php if($i == 0){ ?>
                                                            <option selected value="<?php echo $i?>">-</option>
                                                        <?php } else { ?>
                                                            <option value="<?php echo $i?>"><?php echo $i?></option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </select>
                                                <p class="selecionado_opcion"  onclick="open_select(this)" ></p>
                                                <span onclick="open_select(this)" class="icon_select_mate" >
                                                    <svg fill="#000000" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M7.41 7.84L12 12.42l4.59-4.58L18 9.25l-6 6-6-6z"/>
                                                        <path d="M0-.75h24v24H0z" fill="none"/>
                                                    </svg>
                                                </span>
                                                    <div class="cont_list_select_mate">
                                                        <ul class="cont_select_int">  </ul> 
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>
                                        <div class="price-big">
                                            <div class="t" id="vm">
                                                Valor Mensual: <a id="valor_mensual"></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="container-items-step w400" data-id="1" style="display:none">
                                    <form  id="titular2">
                                        <div class="row" id="titular">
                                            <div class="col-md-12 title-step">
                                                Datos del Titular Beneficiario
                                            </div>
                                            <div class="col-md-12 form-control-input">
                                                <label for="">Nombre*</label>
                                                <input type="text" type="text" id="nombres"    placeholder="Nombres">
                                            </div>
                                            <div class="col-md-6 form-control-input">
                                                <label for="">Apellido Paterno*</label>
                                                <input type="text" id="apellido_p" placeholder="Apellido Paterno">
                                            </div>
                                            <div class="col-md-6 form-control-input">
                                                <label for="">Apellido Materno*</label>
                                                <input type="text" id="apellido_m" placeholder="Apellido Materno">
                                            </div>
                                            <div class="col-md-6 form-control-input">
                                                <label for="">Rut*</label>
                                                <input type="text" id="rut"  placeholder="RUT">
                                            </div>
                                            <div class="col-md-6 form-control-input flex-column">
                                                <label for="">Fecha de Naimiento*</label>
                                                <div class="d-flex " style="height:46px">   
                                                <div class="m-r-10" style="    flex: 1 1 100%;">
                                                    <div class="select-editable" style="border-radius: 5px 0 0 5px;">
                                                        <select id="dia" style="border-radius: 5px 0 0 5px;" onchange="this.nextElementSibling.value=this.value">
                                                            <option selected="true" disabled="disabled" value="0">día</option>
                                                                <?php for($i = 1; $i <= 31; $i++){ ?>
                                                                    <?php if($i < 10){ ?>
                                                                        <option value="<?php echo "0$i"?>"><?php echo $i?></option>
                                                                    <?php } else { ?>
                                                                        <option value="<?php echo $i?>"><?php echo $i?></option>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                        </select>
                                                        <input type="text" style="border-radius: 5px 0 0 5px;" name="format" value=""/>
                                                    </div>
                                                   
                                                </div>
                                                <div class="m-r-10" style="    flex: 1 1 100%;">
                                                    <div class="select-editable">
                                                        <select id="dia" onchange="this.nextElementSibling.value=this.value">
                                                            <option selected="true" disabled="disabled" value="0">mes</option>
                                                            <?php for($i = 1; $i <= 12; $i++){ ?>
                                                                <?php if($i < 10){ ?>
                                                                    <option value="<?php echo "0$i"?>"><?php echo $i?></option>
                                                                <?php } else { ?>
                                                                    <option value="<?php echo $i?>"><?php echo $i?></option>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </select>
                                                        <input type="text" name="format" value=""/>
                                                     </div>
                                                     
                                                </div>
                                                <div class="" style="    flex: 1 1 100%;">
                                                    <div class="select-editable" style="border-radius: 0 5px 5px 0">
                                                        <select style="border-radius: 0 5px 5px 0" id="ano" onchange="this.nextElementSibling.value=this.value">
                                                            <option selected="true" disabled="disabled" value="0">año</option>
                                                            <?php for($i = 1920; $i <= 2020; $i++){ ?>
                                                            <option value="<?php echo $i?>"><?php echo $i?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <input type="text" name="format" value=""/>
                                                    </div>
                                                 
                                                </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6 form-control-input">
                                                <label for="">Teléfono*</label>
                                                <input type="text"  id="fono_p" maxlength="9" placeholder="9 dígitos">
                                            </div>
                                            <div class="col-md-6 form-control-input">
                                                <label for="">Teléfono 2</label>
                                                <input type="text" id="fono_s" maxlength="9" placeholder="9 dígitos">
                                            </div>
                                            <div class="col-md-6 form-control-input">
                                                <label for="">Dirección</label>
                                                <input type="text" id="direccion"  placeholder="Dirección">
                                            </div>
                                            <div class="col-md-6 form-control-input">
                                                <label for="">Ciudad*</label>   
                                                <div class="">
                                                    
                                            

                                                            <div class="cont_select_center">
                                                                <div class="select_mate" data-mate-select="active" >
                                                                <select name="" onchange="" onclick="return false;" id="comunas">
                                                                    <option value="ANTOFAGASTA">ANTOFAGASTA</option>
                                                                    <option value="CALAMA">CALAMA</option>
                                                                    <option value="COPIAPO">COPIAPO</option>
                                                                    <option value="COQUIMBO">COQUIMBO</option>
                                                                    <option value="LA SERENA">LA SERENA</option>
                                                                    <option value="SANTIAGO">SANTIAGO</option>
                                                                </select>
                                                                <p class="selecionado_opcion"  onclick="open_select(this)" ></p>
                                                                <span onclick="open_select(this)" class="icon_select_mate" >
                                                                    <svg fill="#000000" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M7.41 7.84L12 12.42l4.59-4.58L18 9.25l-6 6-6-6z"/>
                                                                        <path d="M0-.75h24v24H0z" fill="none"/>
                                                                    </svg>
                                                                </span>
                                                                    <div class="cont_list_select_mate">
                                                                        <ul class="cont_select_int">  </ul> 
                                                                    </div>
                                                                </div>
                                                            </div> 
                                                    </div>
                                            </div>
                                            <div class="col-md-6 form-control-input">
                                                <label for="">Email*</label>
                                                <input type="email"   id="correo"  placeholder="Correo Electrónico">
                                            </div>
                                            <div class="col-md-6 form-control-input">
                                                <label for="">Confirmar Email*</label>
                                                <input type="email" id="correo_conf"   placeholder="Correo Electrónico">
                                            </div>
                                            <div class="col-md-12">
                                                <input id="check_benef" type="checkbox"  id="soy_benef">
                                                <label for="check_benef" style="font-weight: 900">Soy beneficiario</label>
                                            </div>
                                            <div class="col-md-12">
                                                (*) Campos obligatorios
                                            </div>
                                        </div>

                                    </form>
                                    <div class="" id="new_benificiario" style="display:none">
                                            <div class="row">
                                            <div class="col-md-12 title-step">
                                                    Datos del Titular Beneficiario
                                                </div>
                                            </div>  
                                            <div class="">
                                            <div class="beneficiario-item-collapse">
                                                Beneficiario 1
                                            </div>
                                          
                                            <div class="row">
                                               
                                                <div class="col-md-12 form-control-input">
                                                    <label for="">Nombre*</label>
                                                    <input type="text" placeholder="Nombre">
                                                </div>
                                                <div class="col-md-6 form-control-input">
                                                    <label for="">Apellido Paterno*</label>
                                                    <input type="text" placeholder="Nombre">
                                                </div>
                                                <div class="col-md-6 form-control-input">
                                                    <label for="">Apellido Materno*</label>
                                                    <input type="text" placeholder="Nombre">
                                                </div>
                                                <div class="col-md-6 form-control-input">
                                                    <label for="">Fecha de Naimiento*</label>   
                                                    <div class="">
                                                        
                                                

                                                                <div class="cont_select_center">
                                                                    <div class="select_mate" data-mate-select="active" >
                                                                    <select name="" onchange="" onclick="return false;" id="">
                                                                        <option value=""  >Seleciona una Opcion </option>
                                                                        <option value="1">Select option 1</option>
                                                                        <option value="2" >Select option 2</option>
                                                                        <option value="3">Select option 3</option>
                                                                    </select>
                                                                    <p class="selecionado_opcion"  onclick="open_select(this)" ></p>
                                                                    <span onclick="open_select(this)" class="icon_select_mate" >
                                                                        <svg fill="#000000" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                                                            <path d="M7.41 7.84L12 12.42l4.59-4.58L18 9.25l-6 6-6-6z"/>
                                                                            <path d="M0-.75h24v24H0z" fill="none"/>
                                                                        </svg>
                                                                    </span>
                                                                        <div class="cont_list_select_mate">
                                                                            <ul class="cont_select_int">  </ul> 
                                                                        </div>
                                                                    </div>
                                                                </div> 
                                                        </div>
                                                </div>
                                                <div class="col-md-6 form-control-input">
                                                    <label for="">Teléfono*</label>
                                                    <input type="text" placeholder="Nombre">
                                                </div> 
                                                <div class="col-md-6 form-control-input">
                                                    <label for="">Dirección*</label>
                                                    <input type="text" placeholder="Nombre">
                                                </div> 
                                                <div class="col-md-6 form-control-input">
                                                    <label for="">Ciudad*</label>   
                                                        <div class="">
                                                            
                                                    

                                                                    <div class="cont_select_center">
                                                                        <div class="select_mate" data-mate-select="active" >
                                                                        <select name="" onchange="" onclick="return false;" id="">
                                                                            <option value=""  >Seleciona una Opcion </option>
                                                                            <option value="1">Select option 1</option>
                                                                            <option value="2" >Select option 2</option>
                                                                            <option value="3">Select option 3</option>
                                                                        </select>
                                                                        <p class="selecionado_opcion"  onclick="open_select(this)" ></p>
                                                                        <span onclick="open_select(this)" class="icon_select_mate" >
                                                                            <svg fill="#000000" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                                                                <path d="M7.41 7.84L12 12.42l4.59-4.58L18 9.25l-6 6-6-6z"/>
                                                                                <path d="M0-.75h24v24H0z" fill="none"/>
                                                                            </svg>
                                                                        </span>
                                                                            <div class="cont_list_select_mate">
                                                                                <ul class="cont_select_int">  </ul> 
                                                                            </div>
                                                                        </div>
                                                                    </div> 
                                                            </div>
                                                    </div>
                                            
                                            </div>


                                            </div>

                                                <div class="col-md-12">
                                                        (*) Campos obligatorios
                                                   
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="m-t-20">
                                                        <button type="button" class="btn__table__main color__secondary__main back_to_steps">
                                                            VOLVER
                                                        </button>
                                                        <button   type="button" class="btn__table__main m-l-15">
                                                            CONTINUAR
                                                        </button>
                                                    </div>

                                                </div>

                                                  
                                    </div>
                                </div>
                                <div class="container-items-step" data-id="2" style="display:none">
                                        <div class="d-flex justify-content-between align-items-center flex-column-max">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="col-md-6 form-control-input">
                                                    <label for="" class="color-blue" style="font-weight: 700">Seleccione meses de pago</label>   
                                                    <div class="">
                                                        
                                                

                                                                <div class="cont_select_center">
                                                                    <div class="select_mate" data-mate-select="active" >
                                                                    <select name="" onchange="" onclick="return false;" id="">
                                                                        <option value=""  >Seleciona una Opcion </option>
                                                                        <option value="1">Select option 1</option>
                                                                        <option value="2" >Select option 2</option>
                                                                        <option value="3">Select option 3</option>
                                                                    </select>
                                                                    <p class="selecionado_opcion"  onclick="open_select(this)" ></p>
                                                                    <span onclick="open_select(this)" class="icon_select_mate" >
                                                                        <svg fill="#000000" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                                                            <path d="M7.41 7.84L12 12.42l4.59-4.58L18 9.25l-6 6-6-6z"/>
                                                                            <path d="M0-.75h24v24H0z" fill="none"/>
                                                                        </svg>
                                                                    </span>
                                                                        <div class="cont_list_select_mate">
                                                                            <ul class="cont_select_int">  </ul> 
                                                                        </div>
                                                                    </div>
                                                                </div> 
                                                        </div>
                                                </div>
                                            </div>
                                            <div class="">
                                                <div class="price-big underline">
                                                    $19.990 x 6 MESES
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-t-40 d-flex flex-column">
                                            <div class="d-flex justify-content-between align-items-center m-b-15">
                                                <div class="d-flex text-muted">
                                                    Precio sin descuento:
                                                </div>
                                                <div class="text-bold">
                                                    $199.400
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center m-b-25">
                                                <div class="d-flex text-muted">
                                                    % de descuento:
                                                </div>
                                                <div class="text-bold">
                                                    $11.900
                                                </div>
                                            </div>
                                         
                                            <div class="d-flex justify-content-between align-items-center total-container">
                                                <div class="d-flex text-bold">
                                                    Total a pagar:
                                                </div>
                                                <div class="text-bold">
                                                    $107.460
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                       
                        <div class="d-flex align-items-center justify-content-center btn-steps">
                            <button type="button" id="next" class="btn-primary-closed">SIGUIENTE</button>
                            <div class="m-l-10">
                                <button class="btn__table__main" id="step_2_btn" type="button" style="display:none">
                                    REGISTRAR BENEFICIARIOS
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
                

	
        </section>
    </main>
  
  

    

    <script src="js/app.js?v=<?php echo $randomNumber; ?>"></script>
    <?php 
    include('admin/est/footerp.php');
    ?>
</body>