
<?php

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
    <link rel="stylesheet" href="admin/bootstrap/bootstrap.css">
        <link rel="stylesheet" href="admin/css/header.css">
        
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->     
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="admin/bootstrap/bootstrap.js"></script>
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
    <link href="css/datepicker.css?v=<?php echo $randomNumber; ?>" rel="stylesheet">
</head>
<body>
      <?php include_once('admin/est/headermain.php'); ?>
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
                <h1 class="hero-title">Entregamos soluciones de <br> atenci??n m??dica y de urgencia <br> domiciliaria.</h1>
                <div class="d-flex flex-column sub-hero__header m-t-25">
                    <p>
                        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0zm0 0h24v24H0V0z" fill="none"/><path d="M16.59 7.58L10 14.17l-3.59-3.58L5 12l5 5 8-8zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"/></svg>
                        <span>Atendemos todo tipo de pacientes sin restricci??n de edad.</span>
                    </p>
                    <p>
                        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0zm0 0h24v24H0V0z" fill="none"/><path d="M16.59 7.58L10 14.17l-3.59-3.58L5 12l5 5 8-8zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"/></svg>
                        <span>Atendemos pacientes con preexistencias.</span>
                    </p>
                    <p>
                        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0zm0 0h24v24H0V0z" fill="none"/><path d="M16.59 7.58L10 14.17l-3.59-3.58L5 12l5 5 8-8zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"/></svg>
                        <span> Cobertura m??dica en antofagasta, Calama, Copiap??, Coquimbo y La Serena.</span>
                    </p>
                </div>
                <button class="btn btn-primary-header m-t-15">
                    contrata tu plan aqu??
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
                                    <span>Consultas M??dicas ILIMITADAS</span>
                                </li>
                                <li>
                                    <span>Traslado de Ambulancias SIN COSTO</span>
                                </li>
                                <li>
                                    <span>Disponibilidad las 14 horas los 365 d??as</span>
                                </li>
                                <li>
                                    <span>ALO Doctor 24/7 disponible</span>
                                </li>
                                <li>
                                    <span>Entrega de primera medicaci??n de emergencia</span>
                                </li>
                                <li>
                                    <span>Pago Autom??tico Mensual</span>
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
        <section class="padding-section reset-section suscribir"  style="background: #e7f2ff">
                <h2 class="main-text__section m-t-10 m-b-45">Suscr??bete a nuestros planes</h2>
                  
                <div class="section__tables">
                    <?php for($i = 1; $i <= $num_planes; $i++){ ?>
                        <input type="radio" name="plan" id="option-<?php echo $i?>" value="<?php echo $i?>">
                        <label class="table__pricing option option-<?php echo $i?> m-r-10" for="option-<?php echo $i?>">
                        <div class="title__pricing m-b-10">
                        <?php echo $nom_planes[$i - 1]?>
                        </div>
                        <div class=" color-default">
                            Desde
                        </div>
                        <div class="price__pricing">
                            <?php if ($i == 1){ 
                                echo '$19.990';
                                }else{ 
                                    echo '$9.990';
                                     }  ?>
                        </div>
                        <div class=" color-default" id="vm">
                            Valor Mensual
                        </div> 
                        <p><?php echo nl2br($descrip_planes[$i - 1]);?></p>
                        
                       
                        <!--<div class=" color-default">
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
                                <span>Consultas M??dicas ILIMITADAS</span>
                            </li>
                            <li>
                                <span>Traslado de Ambulancias SIN COSTO</span>
                            </li>
                            <li>
                                <span>Disponibilidad las 14 horas los 365 d??as</span>
                            </li>
                            <li>
                                <span>ALO Doctor 24/7 disponible</span>
                            </li>
                            <li>
                                <span>Entrega de primera medicaci??n de emergencia</span>
                            </li>
                            <li>
                                <span>Pago Autom??tico Mensual</span>
                            </li>
                        </ul> -->
                        <div class="container__btn">
                            <button class="btn__table__main">
                                SIGUIENTE
                            </button>
                        </div>
                    </label>
                    <?php } ?>
                    
                    <!--<input type="radio" name="plan" id="option-2" value="2">
                    
                    <label class="table__pricing option option-2" for="option-2">
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
                                <span>Consultas M??dicas ILIMITADAS</span>
                            </li>
                            <li>
                                <span>Traslado de Ambulancias SIN COSTO</span>
                            </li>
                            <li>
                                <span>Disponibilidad las 14 horas los 365 d??as</span>
                            </li>
                            <li>
                                <span>ALO Doctor 24/7 disponible</span>
                            </li>
                            <li>
                                <span>Entrega de primera medicaci??n de emergencia</span>
                            </li>
                            <li>
                                <span>Pago Autom??tico Mensual</span>
                            </li>
                        </ul>
                        <div class="container__btn">
                            <button class="btn__table__main color__secondary__main">
                                SIGUIENTE
                            </button>
                        </div>
                    </label> -->
                </div>
                <small class="m-t-45" style="text-align:center;margin-top: 50px;display:block">*El cargo de nuestras suscripciones se realizar?? de forma autom??tica</small>
        </section>

        <section class="padding-section reset-section" id="suscribir">
                <h2 class="main-text__section m-t-10 m-b-45" id="main-text__section">Plan Sin Copago</h2>
                <div class="color-default" style="text-align:center">
                    Atenci??n por M??dicos Certificados 24 Horas, Orientaci??n Telef??nica M??dica, Emisi??n de recetas m??dicas, <br> Medicamentos para iniciar un tratamiento, Ordenes de ex??menes y Certificados M??dicos.
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
                                        <div class="edit-select flex">


                                        <select class="input" id="num_benef" name=""  id="">
                                                    
                                            <?php for($i = 0; $i <= $num_benef; $i++){ ?>
                                                <?php if($i == 0){ ?>
                                                    <option selected value="<?php echo $i?>">-</option>
                                                <?php } else { ?>
                                                    <option value="<?php echo $i?>"><?php echo $i?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                        </div>
                                        <div class="price-big flex">
                                            <div class="t" id="vm">
                                                Valor Mensual: <a id="valor_mensual"></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="container-items-step w400" data-id="1" style="display:none">
                                    <form  id="titular2">
                                        <div class="row" id="titular">
                                            <div class="col-md-12 title-step m-b-20">
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
                                                            <option selected="true" disabled="disabled" value="0">d??a</option>
                                                                <?php for($i = 1; $i <= 31; $i++){ ?>
                                                                    <?php if($i < 10){ ?>
                                                                        <option value="<?php echo "0$i"?>"><?php echo $i?></option>
                                                                    <?php } else { ?>
                                                                        <option value="<?php echo $i?>"><?php echo $i?></option>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                        </select>
                                                        <input type="text" style="border-radius: 5px 0 0 5px;" id="dia" placeholder="D??a" name="format" value=""/>
                                                    </div>
                                                   
                                                </div>
                                                <div class="m-r-10" style="    flex: 1 1 100%;">
                                                    <div class="select-editable">
                                                        <select id="mes" onchange="this.nextElementSibling.value=this.value">
                                                            <option selected="true" disabled="disabled" value="0">mes</option>
                                                            <?php for($i = 1; $i <= 12; $i++){ ?>
                                                                <?php if($i < 10){ ?>
                                                                    <option value="<?php echo "0$i"?>"><?php echo $i?></option>
                                                                <?php } else { ?>
                                                                    <option value="<?php echo $i?>"><?php echo $i?></option>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </select>
                                                        <input type="text" name="format" value="" id="mes" placeholder="Mes"/>
                                                     </div>
                                                     
                                                </div>
                                                <div class="" style="    flex: 1 1 100%;">
                                                    <div class="select-editable" style="border-radius: 0 5px 5px 0">
                                                        <select style="border-radius: 0 5px 5px 0"  onchange="this.nextElementSibling.value=this.value">
                                                            <option selected="true" disabled="disabled" value="0">a??o</option>
                                                            <?php for($i = 1920; $i <= 2020; $i++){ ?>
                                                            <option value="<?php echo $i?>"><?php echo $i?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <input type="text" name="format" value="" id="ano" placeholder="A??o"/>
                                                    </div>
                                                 
                                                </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6 form-control-input">
                                                <label for="">Tel??fono*</label>
                                                <input type="text"  id="fono_p" maxlength="9" placeholder="9 d??gitos">
                                            </div>
                                            <div class="col-md-6 form-control-input">
                                                <label for="">Tel??fono 2</label>
                                                <input type="text" id="fono_s" maxlength="9" placeholder="9 d??gitos">
                                            </div>
                                            <div class="col-md-6 form-control-input">
                                                <label for="">Direcci??n</label>
                                                <input type="text" id="direccion"  placeholder="Direcci??n">
                                            </div>
                                            <div class="col-md-6 form-control-input">
                                                <label for="">Ciudad*</label>   
                                                <div class="">
                                                            <div class="edit-select">
                                                               
                                                                <select name="" onchange=""  id="comunas">
                                                                    <option value="ANTOFAGASTA">ANTOFAGASTA</option>
                                                                    <option value="CALAMA">CALAMA</option>
                                                                    <option value="COPIAPO">COPIAPO</option>
                                                                    <option value="COQUIMBO">COQUIMBO</option>
                                                                    <option value="LA SERENA">LA SERENA</option>
                                                                    <option value="SANTIAGO">SANTIAGO</option>
                                                                </select>
                                                                
                                                            </div> 
                                                    </div>
                                            </div>
                                            <div class="col-md-6 form-control-input">
                                                <label for="">Email*</label>
                                                <input type="email"   id="correo"  placeholder="Correo Electr??nico">
                                            </div>
                                            <div class="col-md-6 form-control-input">
                                                <label for="">Confirmar Email*</label>
                                                <input type="email" id="correo_conf"   placeholder="Correo Electr??nico">
                                            </div>
                                            <div class="col-md-12">
                                                <input id="check_benef" type="checkbox"  >
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
                                            <div >
                                            
                                                <div class="col-md-12">
                                                        (*) Campos obligatorios
                                                   
                                                </div>
                                               
                                            </div>                                    
                                                  
                                    </div>

                                    



                                    <div class="beneficiarios" id="beneficiarios" style="display:none">
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
                                                                <input type="text" data-toggle="datepicker">
                                                            </div>
                                                            <div class="col-md-6 form-control-input">
                                                                <label for="">Tel??fono*</label>
                                                                <input type="text" placeholder="Nombre">
                                                            </div> 
                                                            <div class="col-md-6 form-control-input">
                                                                <label for="">Direcci??n*</label>
                                                                <input type="text" placeholder="Nombre">
                                                            </div> 
                                                            <div class="col-md-6 form-control-input edit-select">
                                                                <label for="">Ciudad*</label>   
                                                                <select required="" class="input " id="comunas">
                                                                    <option value="ANTOFAGASTA">ANTOFAGASTA</option>
                                                                    <option value="CALAMA">CALAMA</option>
                                                                    <option value="COPIAPO">COPIAPO</option>
                                                                    <option value="COQUIMBO">COQUIMBO</option>
                                                                    <option value="LA SERENA">LA SERENA</option>
                                                                    <option value="SANTIAGO">SANTIAGO</option>
                                                                </select>
                                                        </div>


                                                    </div>
                                                </div>
                                </div>
                                <div class="container-items-step" data-id="2" style="display:none">
                                    <div class="d-flex justify-content-between align-items-center flex-column" style="width:100%">
                                        <div class="d-flex justify-content-between align-items-center" style="width:100%">
                                            <div class="form-control-input">
                                                <label for="" class="color-blue" style="font-weight: 700">Seleccione meses de pago</label>   
                                                <div class="edit-select">
                                                    <select name="" onchange=""  id="tipo_pago">
                                                    <?php for($i = 1; $i <= sizeof($tipo_pago); $i++){ ?>
                                                        <?php if($i == 1){ ?>
                                                            <option selected id="<?php echo $num_mes[$i - 1]?>" value="<?php echo $cod_pago[$i - 1]?>"><?php echo $tipo_pago[$i - 1]?></option>
                                                        <?php } else { ?>
                                                            <option id="<?php echo $num_mes[$i - 1]?>" value="<?php echo $cod_pago[$i - 1]?>"><?php echo $tipo_pago[$i - 1]?></option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                    </select>
                                            </div>
                                        </div>
                                        <div class="">
                                            <div class="price-big underline">
                                                <span id="text-cuota"></span> x <span id="cuotas-meses"></span> MESES
                                            </div>
                                        </div>
                                    </div>
                                    <div class="m-t-40 d-flex flex-column" style="width:100%">
                                        <div class="d-flex justify-content-between align-items-center m-b-15">
                                            <div class="d-flex text-muted">
                                                Precio sin descuento:
                                            </div>
                                            <div class="text-bold">
                                                <p id="resalto"><a id="precio_sin_dscto">$</a></p>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center m-b-25">
                                            <div class="d-flex text-muted">
                                                % de descuento:
                                            </div>
                                            <div class="text-bold">
                                                <p id="resalto"><a id="ahorro">$</a></p>
                                            </div>
                                        </div>
                                        
                                        <div class="d-flex justify-content-between align-items-center total-container">
                                            <div class="d-flex text-bold">
                                                Total a pagar:
                                            </div>
                                            <div class="text-bold">
                                                <p id="resalto2"><a id="valor_pagar">$</a></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="m-t-25">
                                        <label class="container">
                                            <input id="tyc" type="checkbox">
                                            <span class="checkmark"></span>
                                            <a href="docu/Terminos%20y%20Condiciones%20REST911.pdf" download="">Acepto Terminos y Condiciones</a>
                                            
                                        </label>
                                        <button type="submit" id="btn_pagar" class="btn-primary-closed">Pagar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                        <div class="less-flex align-items-center justify-content-center btn-steps">
                            <button type="button" id="next" class="btn-primary-closed">SIGUIENTE</button>
                            <div class="m-l-10">
                                <!--id="step_2_btn"-->
                                <button class="btn__table__main" id="cont_benef"  type="button" style="display:none">
                                    REGISTRAR BENEFICIARIOS
                                </button>
                            </div>
                        </div>
                        <div class="less-flex btn-accion-beneficiario flex-column-max" style="display:none">
                                <button type="button" id="cont_titular" class="btn-primary-closed m-r-10" style="display:none">Volver</button>                            
                                <button class="btn__table__main" id="cont_modal"  type="button"  data-toggle="modal" data-target="#exampleModalCenter" style="display:none">
                                   Continuar
                                </button>                                  

                        </div>
                        <div>

                        </div>
                    </div>
                </div>
                </form>
                

	
        </section>
    </main>
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
                    Al continuar no podr?? volver a editar los datos del formulario, est?? seguro que desea continuar de todos modos?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Volver</button>
                    <button type="button" class="btn btn-primary" id="conf_modal" data-dismiss="modal">Continuar</button>
                </div>
            </div>
        </div>
    </div>
  
  

    

    <script src="js/formulario2.js"></script>
    <script src="js/ajax2.js?v=<?php echo $randomNumber; ?>"></script>
    <script src="js/app.js?v=<?php echo $randomNumber; ?>"></script>
    <script src="js/datapicker.js"></script>
    <script>
    $('[data-toggle="datepicker"]').datepicker();
    </script>
    <?php 
    include('admin/est/footerp.php');
    ?>
</body>