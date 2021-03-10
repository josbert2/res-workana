<?php
    include_once('conn.php');
    require('../../vendor/autoload.php');

    //No tocar
    use Transbank\Webpay\Options;
    use Transbank\Webpay\authorize;
    use Transbank\Webpay\Oneclick;
    use Transbank\Webpay\Oneclick\MallInscription;
    use Transbank\Webpay\Oneclick\MallTransaction;
    use Transbank\Webpay\WebpayPlus;

    include('modo2.php');

    if(isset($_POST['function'])){
        if($_POST['function'] == 'registrarTitular'){
            $conn        = getConn();

            $fec_pago    = getFecha();
            $nombres     = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['nombres']));
            $apellido_p  = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['apellido_p']));
            $apellido_m  = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['apellido_m']));
            $rut         = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['rut']));
            $fecha_nac   = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['fecha_nac']));
            $correo      = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['correo']));
            $fono_p      = '56'.htmlspecialchars(mysqli_real_escape_string($conn, $_POST['fono_p']));
            if(!empty($_POST['fono_s'])){
                $fono_s  = '56'.htmlspecialchars(mysqli_real_escape_string($conn, $_POST['fono_s']));
            }
            else{
                $fono_s  = NULL;
            }
            $direccion   = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['direccion']));
            $comuna      = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['comuna']));
            $cod_plan    = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['plan']));
            $nom_plan    = getNombrePlan($cod_plan);
            $benef       = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['benef']));
            $valor_plan  = getValorPlan($cod_plan, $benef);
            $valor_plan  = str_replace('.', '', $valor_plan);
            
            $utm_source  = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['utm_source']));
            $utm_medium  = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['utm_medium']));
            $utm_campaign = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['utm_campaign']));
            
            if((!empty($utm_source)) && (!empty($utm_medium)) && (!empty($utm_campaign))){
                $observa = "utm_source: ".$utm_source."\nutm_medium: ".$utm_medium."\nutm_campaign: ".$utm_campaign;
            } else {
                $observa = NULL;
            }
            
            $sql         = "CALL ACTUALIZA_PAGOS('$fec_pago', NULL, '$nombres', '$apellido_p', '$apellido_m', '$rut', '$fecha_nac', '$correo', '$fono_p', '$fono_s', '$direccion', '$comuna', $cod_plan, '$nom_plan', $benef, $valor_plan, NULL, NULL, NULL, NULL, NULL, 'N', @resp);";
            
            $query       = mysqli_query($conn, $sql);
            if($query){
                $query_resp = mysqli_query($conn, "SELECT @resp;");
                $result     = mysqli_fetch_array($query_resp);
                $cod_resp   = $result['@resp'];
                
                if($observa != NULL){
                    $sql         = "UPDATE pagos_clientes SET observa = '$observa' WHERE pagos = $cod_resp;";
                    $query       = mysqli_query($conn, $sql);
                }
                
                echo $cod_resp;
            }
            else{
                echo("Error description: " . mysqli_error($conn));
            }
        }
        else if($_POST['function'] == 'registrarOrden'){
            $conn        = getConn();

            $fec_pago    = getFecha();
            $nombres     = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['nombres']));
            $apellido_p  = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['apellido_p']));
            $apellido_m  = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['apellido_m']));
            $rut         = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['rut']));
            $fecha_nac   = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['fecha_nac']));
            $correo      = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['correo']));
            $fono_p      = '56'.htmlspecialchars(mysqli_real_escape_string($conn, $_POST['fono_p']));
            if(!empty($_POST['fono_s'])){
                $fono_s  = '56'.htmlspecialchars(mysqli_real_escape_string($conn, $_POST['fono_s']));
            }
            else{
                $fono_s  = NULL;
            }
            $direccion   = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['direccion']));
            $comuna      = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['comuna']));
            $cod_plan    = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['plan']));
            $nom_plan    = getNombrePlan($cod_plan);
            $benef       = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['benef']));
            $valor_plan  = getValorPlan($cod_plan, $benef);
            $valor_plan  = str_replace('.', '', $valor_plan);
            $cod_pago    = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['cod_pago']));
            $tipo_pago   = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['tipo_pago']));
            $num_mes     = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['num_mes']));
            $ahorro      = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['ahorro']));
            $valor_pagar = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['valor_pagar']));
            $fec_fac     = getFechaCorta();
            $fec_fac     = addMonths($fec_fac, $num_mes - 1);
            
            $utm_source  = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['utm_source']));
            $utm_medium  = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['utm_medium']));
            $utm_campaign = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['utm_campaign']));
            
            if((!empty($utm_source)) && (!empty($utm_medium)) && (!empty($utm_campaign))){
                $observa = "utm_source: ".$utm_source."\nutm_medium: ".$utm_medium."\nutm_campaign: ".$utm_campaign;
            } else {
                $observa = NULL;
            }
            
            $sql         = "CALL ACTUALIZA_PAGOS('$fec_pago', '$fec_fac', '$nombres', '$apellido_p', '$apellido_m', '$rut', '$fecha_nac', '$correo', '$fono_p', '$fono_s', '$direccion', '$comuna', $cod_plan, '$nom_plan', $benef, $valor_plan, $cod_pago, '$tipo_pago', $num_mes, $ahorro, $valor_pagar, 'E', @resp);";
            
            $query       = mysqli_query($conn, $sql);
            if($query){
                $query_resp = mysqli_query($conn, "SELECT @resp;");
                $result     = mysqli_fetch_array($query_resp);
                $cod_resp   = $result['@resp'];
                
                if($observa != NULL){
                    $sql         = "UPDATE pagos_clientes SET observa = '$observa' WHERE pagos = $cod_resp;";
                    $query       = mysqli_query($conn, $sql);
                }
                
                echo $cod_resp;
            }
            else{
                //echo("Error description: " . mysqli_error($conn));
            }
        }
        else if($_POST['function'] == 'registrarBeneficiarios'){
            $conn          = getConn();
            $beneficiarios = $_POST['beneficiarios'];
            
            $cod_benef = $beneficiarios[0][0];
            $sql_del   = "CALL BORRA_BENEF($cod_benef, @resp);";
            $query_del = mysqli_query($conn, $sql_del);
            
            for($i = 0; $i < count($beneficiarios); $i++){
                $benef     = $beneficiarios[$i];
                
                $sql       = "CALL INSERT_BENEF($benef[0], '$benef[1]', '$benef[2]', '$benef[3]', '$benef[4]', $benef[5]);";
                $query     = mysqli_query($conn, $sql);
                
                /*
                if($query_del){
                    $flag = true;
                }
                else{
                    $flag = "Error description: " . mysqli_error($conn);
                }
                */
            }
            //echo $cod_benef;
        }
        else if($_POST['function'] == 'getToken'){  
            $conn       = getConn();          
            $pagos     = $_POST['pagos'] * 1;
            $email     = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['email']));
            
            $sql_tbk    = "SELECT username FROM pagos_clientes WHERE pagos = $pagos;";
            $query_tbk  = mysqli_query($conn, $sql_tbk);
            $result_tbk = mysqli_fetch_array($query_tbk);
            $username   = $result_tbk['username'];
            
            $result = MallInscription::start($username, $email, $urlReturn);           
            $result = get_object_vars($result);

            if(!empty($result["token"])) {
                $token = $result["token"];
                $next_page = $result["urlWebpay"];
                
                $sql  = "UPDATE pagos_clientes SET token = '$token' WHERE pagos = $pagos;";
                $query = mysqli_query($conn, $sql);
                
                if($query){
                    $datos = array($token, $next_page);
                    echo json_encode($datos);
                }
                else{
                    echo("Error description: " . mysqli_error($conn));
                }
            }
            else{
                echo("Error al obtener token");
            }
        }
    }

    else if(isset($_POST['tipo_pago'])){
        if(isset($_POST['num_benef'])){
            if(isset($_POST['plan_id'])){
                $conn      = getConn();

                $plan_id   = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['plan_id']));
                $num_benef = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['num_benef']));
                $tipo_pago = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['tipo_pago']));
                $data      = array();
                $sql       = "CALL TRAER_VALORES($plan_id, $num_benef, $tipo_pago);";
                $query     = mysqli_query($conn, $sql);
                if(mysqli_num_rows($query) > 0){
                    while($row = mysqli_fetch_array($query)){
                        $data[] = number_format($row['VALOR_PLAN_REAL'], 0, '.', '.');
                        $data[] = number_format($row['VALOR_PLAN_DESC'], 0, '.', '.');
                        $data[] = number_format($row['VALOR_AHORRO'], 0, '.', '.');
                    }
                }
            }
            $new_data = array($data[0], $data[1], $data[2]);
            echo json_encode($new_data);
        }
    }
    //Entra aqui si es que mando el id del plan que se seleccionó
    else if(isset($_POST['plan_id'])){
        if(isset($_POST['num_benef'])){
            $conn      = getConn();
            $plan_id   = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['plan_id']));
            $num_benef = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['num_benef']));
            echo $num_benef;
            $data      = array();
            $sql       = "CALL TRAER_VALORES($plan_id, $num_benef, 1);";
            $query     = mysqli_query($conn, $sql);
            if(mysqli_num_rows($query) > 0){
                while($row = mysqli_fetch_array($query)){
                    $data[] = number_format($row['VALOR_PLAN'], 0, '.', '.');
                }
            }
        }
        if($data){
            echo $data[0];
        }
    }

    function getNombrePlan($cod_plan){
        $conn       = getConn();
        $sql        = "SELECT nom_plan FROM planes WHERE cod_plan = $cod_plan and est_plan = 's'";
        $query      = mysqli_query($conn, $sql);
        $result     = mysqli_fetch_array($query);
        $nom_plan   = $result['nom_plan'];
        return $nom_plan;
    }

    function getValorPlan($cod_plan, $benef){
        $conn       = getConn();
        $sql        = "SELECT val_benef FROM valores WHERE cod_plan = $cod_plan and can_benef = $benef";
        $query      = mysqli_query($conn, $sql);
        $result     = mysqli_fetch_array($query);
        $valor_plan = number_format($result['val_benef'], 0, '.', '.');
        return $valor_plan;
    }

    function getFecha(){
        date_default_timezone_set("America/Santiago");
        $time  = time();
        $fecha = date("Y-m-d H:i:s", $time);
        return $fecha;
    }

    function getFechaCorta(){
        date_default_timezone_set("America/Santiago");
        $fecha = date("Y-m-d");
        return $fecha;
    }

    function addMonths($date, $monthToAdd){

        $d1 = DateTime::createFromFormat('Y-m-d', $date);

        $year = $d1->format('Y');
        $month = $d1->format('n');
        $day = $d1->format('d');

        $year += floor($monthToAdd/12);
        $monthToAdd = $monthToAdd%12;
        $month += $monthToAdd;

        if($month > 12) {
            $year ++;
            $month = $month % 12;
            if($month === 0)
                $month = 12;
        }
        if($monthToAdd < 0){
            $year ++;
        }

        if(!checkdate($month, $day, $year)) {
            $d2 = DateTime::createFromFormat('Y-n-j', $year.'-'.$month.'-1');
            $d2->modify('last day of');
        }else {
            $d2 = DateTime::createFromFormat('Y-n-d', $year.'-'.$month.'-'.$day);
        }
        return $d2->format('Y-m-d');
    }
?>