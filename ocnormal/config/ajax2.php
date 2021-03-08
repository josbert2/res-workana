    <?php
    include_once('conn.php');
    require_once ('../../vendor/autoload.php');

    use Transbank\Webpay\Configuration;
    use Transbank\Webpay\Webpay;

    if(isset($_POST['function'])){
        if($_POST['function'] == 'registrarTitular'){
            $fec_pago    = getFecha();
            $nombres     = $_POST['nombres'];
            $apellido_p  = $_POST['apellido_p'];
            $apellido_m  = $_POST['apellido_m'];
            $rut         = $_POST['rut'];
            $fecha_nac   = $_POST['fecha_nac'];
            $correo      = $_POST['correo'];
            $fono_p      = '56'.$_POST['fono_p'];
            if(!empty($_POST['fono_s'])){
                $fono_s  = '56'.$_POST['fono_s'];
            }
            else{
                $fono_s  = NULL;
            }
            $direccion   = $_POST['direccion'];
            $comuna      = $_POST['comuna'];
            $cod_plan    = $_POST['plan'];
            $nom_plan    = getNombrePlan($cod_plan);
            $benef       = $_POST['benef'];
            $valor_plan  = getValorPlan($cod_plan, $benef);
            $valor_plan  = str_replace('.', '', $valor_plan);
            
            $conn        = getConn();
            $sql         = "CALL ACTUALIZA_PAGOS('$fec_pago', '$nombres', '$apellido_p', '$apellido_m', '$rut', '$fecha_nac', '$correo', '$fono_p', '$fono_s', '$direccion', '$comuna', $cod_plan, '$nom_plan', $benef, $valor_plan, NULL, NULL, NULL, NULL, 'N', @resp);";
            
            $query       = mysqli_query($conn, $sql);
            if($query){
                $query_resp = mysqli_query($conn, "SELECT @resp;");
                $result     = mysqli_fetch_array($query_resp);
                $cod_resp   = $result['@resp'];
            
                echo $cod_resp;
            }
            else{
                echo("Error description: " . mysqli_error($conn));
            }
        }
        else if($_POST['function'] == 'registrarOrden'){
            $fec_pago    = getFecha();
            $nombres     = $_POST['nombres'];
            $apellido_p  = $_POST['apellido_p'];
            $apellido_m  = $_POST['apellido_m'];
            $rut         = $_POST['rut'];
            $fecha_nac   = $_POST['fecha_nac'];
            $correo      = $_POST['correo'];
            $fono_p      = '56'.$_POST['fono_p'];
            if(!empty($_POST['fono_s'])){
                $fono_s  = '56'.$_POST['fono_s'];
            }
            else{
                $fono_s  = NULL;
            }
            $direccion   = $_POST['direccion'];
            $comuna      = $_POST['comuna'];
            $cod_plan    = $_POST['plan'];
            $nom_plan    = getNombrePlan($cod_plan);
            $benef       = $_POST['benef'];
            $valor_plan  = getValorPlan($cod_plan, $benef);
            $valor_plan  = str_replace('.', '', $valor_plan);
            $cod_pago    = $_POST['cod_pago'];
            $tipo_pago   = $_POST['tipo_pago'];
            $ahorro      = $_POST['ahorro'];
            $valor_pagar = $_POST['valor_pagar'];
            $conn        = getConn();
            $sql         = "CALL ACTUALIZA_PAGOS('$fec_pago', '$nombres', '$apellido_p', '$apellido_m', '$rut', '$fecha_nac', '$correo', '$fono_p', '$fono_s', '$direccion', '$comuna', $cod_plan, '$nom_plan', $benef, $valor_plan, $cod_pago, '$tipo_pago', $ahorro, $valor_pagar, 'E', @resp);";
            
            $query       = mysqli_query($conn, $sql);
            if($query){
                $query_resp = mysqli_query($conn, "SELECT @resp;");
                $result     = mysqli_fetch_array($query_resp);
                $cod_resp   = $result['@resp'];
                echo $cod_resp;
            }
            else{
                echo("Error description: " . mysqli_error($conn));
            }
        }
        else if($_POST['function'] == 'registrarBeneficiarios'){
            $beneficiarios = $_POST['beneficiarios'];
            $conn          = getConn();
            $success       = true;
            
            for($i = 0; $i < sizeof($beneficiarios); $i++){
                $benef   = $beneficiarios[$i];
                 
                $sql_del   = "CALL BORRA_BENEF($benef[0]);";
                $query_del = mysqli_query($conn, $sql_del);
                
                $sql       = "CALL INSERT_BENEF($benef[0], '$benef[1]', '$benef[2]', '$benef[3]', '$benef[4]', $benef[5]);";
                $query     = mysqli_query($conn, $sql);
                
                if(!$query){
                    $success = false;
                }
            }
            if($success){
                echo true;
            }
            else{
                echo false;
            }
        }
        else if($_POST['function'] == 'getToken'){
            $sample_baseurl = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
            
            /** PRODUCCION **/
            $commerce_code = 597035230610;
            $configuration = new Configuration();
            $configuration->setEnvironment("PRODUCCION");
            $configuration->setCommerceCode($commerce_code);

            $path_base      = "../../app/private/".$commerce_code;
            $pathKey        = $path_base.'.key';
            $pathCert       = $path_base.'.crt';
            $pathWebpayCert = '../../app/private/serverTBK.crt';
            $cert           = file_get_contents($pathCert);
            $key            = file_get_contents($pathKey);
            $webpayCert     = file_get_contents($pathWebpayCert);
            $configuration->setPublicCert($cert);
            $configuration->setPrivateKey($key);
            $configuration->setWebpayCert($webpayCert);
            
            $webpay = new Webpay($configuration);
            
            $pagos     = $_POST['pagos'] * 1;
            $email     = $_POST['email'];
            $urlReturn = "https://planes.rest911.cl/ins.php?action=OneClickFinishInscription";
            
            $conn       = getConn();
            $sql_tbk    = "SELECT username FROM pagos_clientes WHERE pagos = $pagos;";
            $query_tbk  = mysqli_query($conn, $sql_tbk);
            $result_tbk = mysqli_fetch_array($query_tbk);
            $username   = $result_tbk['username'];
            
            
            $request = array(
                "username" => $username,
                "email" => $email,
                "urlReturn" => $urlReturn
            );

            $result = $webpay->getOneClickTransaction()->initInscription($username, $email, $urlReturn);
            $result = get_object_vars($result);

            if(!empty($result["token"])) {
                $token = $result["token"];
                $next_page = $result["urlWebpay"];
            } 
            
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
    }

    else if(isset($_POST['tipo_pago'])){
        if(isset($_POST['num_benef'])){
            if(isset($_POST['plan_id'])){
                $plan_id   = $_POST['plan_id'];
                $num_benef = $_POST['num_benef'];
                $tipo_pago = $_POST['tipo_pago'];
                $data      = array();
                $conn      = getConn();
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
            $plan_id   = $_POST['plan_id'];
            $num_benef = $_POST['num_benef'];
            $data      = array();
            $conn      = getConn();
            $sql       = "CALL TRAER_VALORES($plan_id, $num_benef, 1);";
            $query     = mysqli_query($conn, $sql);
            if(mysqli_num_rows($query) > 0){
                while($row = mysqli_fetch_array($query)){
                    $data[] = number_format($row['VALOR_PLAN'], 0, '.', '.');
                }
            }
        }
        echo $data[0];
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
?>