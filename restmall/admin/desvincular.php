<!-- Menu -->
<?php
    include_once "config/conexion.php";
    include "config/func.php";
    include_once "config/permisos.php";

    session_start();
    $rol = $_SESSION['rol'];
    $currentPage = "desvincular";
    $acceso = getPermisos($currentPage, $rol);
    if(!$acceso){
        header("location: ../login.php");    
    }
    include_once ('est/header.php');

    $fechahoy = getFecha();
    $username_tbk = $_REQUEST['username_tbk'];
?>
<?php
/*if(!empty($_POST)){
    if(!empty($_POST['username_tbk'])){
        $username_tbk = $_POST['username_tbk'];*/
?>
<!-- CONTENIDO PAGINA -->
    <!DOCTYPE html>
<html lang="es">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <title>Desvinculación Oneclick Mall</title>
    <link rel="stylesheet" href="../css/transacciones.css">
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <meta http-equiv=”Content-Type” content=”text/html; charset=UTF-8″ />
<style>
    .centered {
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .bus-col-sm{
        margin-left: 20px;
    }
</style>   
</head>
<body>
    <section class="formulario">
        <h2>Desvinculación</h2>
        
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" rel="stylesheet"/>
        
        <form action="" role="form" class="form-horizontal" style="margin:15px; align-items: center;">
            <div class="row justify-content-center">
                <label for="username_tbk" class="col-form-label"> Rut Cliente: </label>
                <div class="col-sm-2">
                    <input required type="text" maxlength = "9" value="<?php echo $username_tbk ?>" name="username_tbk" class="form-control" id="rut" placeholder="Rut SIN puntos y ni guión">
                </div>
                <div class="bus-col-sm">
                    <input type="submit" name="Buscar" class="btn btn-primary" value="Buscar">
                </div>
            </div>
        </form>
        <table>
            <tr>
                <th style="width:60px; padding-left:20px;"> Cod</th>
                <th>Fecha Vinculación</th>
                <th>Nombre</th>
                <th>Rut Cliente</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </table>
<?php
if(!empty($_REQUEST['username_tbk'])){
        $username_tbk = $_REQUEST['username_tbk'];
        //DATOS DE PAGOS_CLIENTE
        $query_2 = mysqli_query($conn, "SELECT p.pagos, CAST(p.fec_pag AS DATE) as fec_pag, CAST(FEC_PAG AS TIME) as hora, p.t_nombres, p.t_apellido1, p.t_apellido2, p.rut, p.t_fec_nac, p.email, p.telefono, p.telefono2, p.direccion, p.comuna, p.cod_plan, p.nom_plan, p.num_benef, p.valor_plan_benef, p.cod_pago, p.tipo_pago, p.cant_descuento, p.valor_plan, p.clase, CASE 
        WHEN p.estado = 'S' THEN 'TRANSACC EXITOSA'
        WHEN p.estado = 'I' THEN 'SUSCRIPCION'
        ELSE 'N/A'
        END AS estado, p.token, p.buyorder,p.authorizationcode, p.creditcardtype, p.last4carddigits, p.tbkuser, p.transactionid, p.username, p.fecha_tbk, DATE_ADD(p.fec_fac,INTERVAL '1' MONTH) as fec_fac, 
        CASE
        WHEN p.clase = 'A' THEN '(A) Autocontratados'
        WHEN p.clase = 'B' THEN '(B) Inscripción y Cobro'
        WHEN p.clase = 'C' THEN '(C) Solo Inscripción'
        ELSE 'N/A'
        END AS clase, p.observa FROM pagos_clientes p WHERE rut = '$username_tbk' AND (estado = 'I' OR estado = 'S') ORDER BY p.pagos ASC");
            
        $result = mysqli_num_rows($query_2);
        if($result > 0){
            $i = 1;
            while($data = mysqli_fetch_array($query_2)){
?>
        <div class="accordion" id="accordionExample">
                        <div class="card">
                            <div class="card-header" id="heading<?php echo $i; ?>">
                                <h2 class="mb-0" style="text-align: left;">
                                    <div style="max-width:60px;"><?php echo $data["pagos"] ?></div>
                                    <div style="padding-left:20px;"><?php $newDate = date("d-m-Y", strtotime($data["fec_pag"]));echo $newDate ?></div>
                                    <div><?php echo $data["t_nombres"]." ".$data["t_apellido1"]?></div>
                                    <div><?php echo $data["rut"]?></div>
                                    <div><?php echo $data["email"]?></div>
                                    <div><?php echo $data["telefono"]?></div>
                                    <div><?php echo $data["estado"]?></div>
                                    <div>
                                        <button class="btn btn-link <?php if($i>1) echo "collapsed"; ?>" name="card-title" type="button" data-toggle="collapse" data-target="#collapse<?php echo $i; ?>" aria-expanded="false" aria-controls="collapse<?php echo $i; ?>">
                                            <a class="link_expand">Ver</a>
                                        </button>
                                        |
                                        <a class="link_delete" href="des_conf.php?p=<?php echo $data["pagos"]    ?>">Desvincular</a>
                                    </div>
                                </h2>
                            </div>
                            <div id="collapse<?php echo $i; ?>" class="collapse" aria-labelledby="heading<?php echo $i; ?>" data-parent="#accordionExample">
                                <div class="card-body">
                                    <div>
                                        <b>Nombres:</b> <?php echo $data["t_nombres"]?><br>
                                        <b>Apellidos Paterno:</b> <?php echo $data["t_apellido1"]?><br>
                                        <b>Apellido Materno:</b> <?php echo $data["t_apellido2"]?><br>
                                        <b>Fecha de Nacimiento:</b> <?php echo $data["t_fec_nac"]?><br>
                                        <b>Segundo Telefóno:</b> <?php echo $data["telefono2"]?><br>
                                        <b>Comuna:</b> <?php echo $data["comuna"]?><br>
                                        <b>Dirección:</b> <?php echo $data["direccion"]?><br>
                                        <b>Codigo del Plan:</b> <?php echo $data["cod_plan"]?><br>
                                        <b>Nombre del plan:</b> <?php echo $data["nom_plan"]?><br>
                                        <b>Cantidad de Beneficiarios:</b> <?php echo $data["num_benef"]?><br>
                                        <b>Valor:</b> <?php echo $data["valor_plan_benef"]?><br>
                                        <b>Codigo de Pago:</b> <?php echo $data["cod_pago"]?><br>
                                        <b>Tipo de pago:</b> <?php echo $data["tipo_pago"]?><br>
                                        <b>Cantidad de descuento:</b> <?php echo $data["cant_descuento"]?><br>
                                        <b>Valor del Plan:</b> <?php echo $data["valor_plan"]?><br>
                                        <b>Token TBK:</b> <?php echo $data["token"]?><br>
                                        <b>Usuario TBK:</b> <?php echo $data["username"]?><br>
                                        <b>Order de compra</b> <?php echo $data["buyorder"]?><br>
                                        <b>Codigo Autorización TBK:</b> <?php echo $data["authorizationcode"]?><br>
                                        <b>Tipo de tarjeta:</b> <?php echo $data["creditcardtype"]?><br>
                                        <b>Ultimos 4 digitos:</b> <?php echo $data["last4carddigits"]?><br>
                                        <b>Cod. Usuario Transbank:</b> <?php echo $data["tbkuser"]?><br>
                                        <b>Codigo transacción:</b> <?php echo $data["transactionid"]?><br>
                                        <b>Fecha TBK:</b> <?php echo $data["fecha_tbk"]?><br>
                                        <b>Siguiente Facturación:</b> <?php echo $data["fec_fac"]?><br>
                                        <b>Tipo de cliente:</b> <?php echo $data["clase"]?><br>
                                        <b>Observaciónes:</b> <?php echo $data["observa"]?><br>
                                    </div>
                                    <div>
                <?php
                /* Datos para generar cobro */
                $tbkuser = $data["tbkuser"];
                $monto   = $data["valor_plan_benef"];
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
                
                $i++;
                }
            ?>
        </div>

<?php
        }else{
?>
    <label for="user_no"> Cliente no encontrado </label>    
        
<?php
        }
     }
?>
    </section>
</body>
    
<script type="text/javascript">
    
$(document).on('input', ':input[type="number"][maxlength]', function () {
    if (this.value.length > this.maxLength) {
        this.value = this.value.slice(0, this.maxLength); 
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
    
</script>
</html>