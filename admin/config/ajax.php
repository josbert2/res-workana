<?php
    include_once('conn.php');

    if(isset($_POST['function'])){
        if($_POST['function'] == 'registrarCliente'){
            $fec_pago      = getFecha();
            $clase         = $_POST['clase'];
            $num_mes       = $_POST['meses'];
            $nombre        = $_POST['nombre'];
            $apellido_p    = $_POST['apellido_p'];
            $apellido_m    = $_POST['apellido_m'];
            $rut           = $_POST['rut'];
            $email         = $_POST['email'];
            $telefono      = $_POST['telefono'];
            $monto         = $_POST['monto'];
            $descuento     = $_POST['descuento'];
            $nuevo_monto   = $_POST['nuevo_monto'];
            $observaciones = $_POST['observaciones'];
            $factura       = $_POST['factura'];
            $factura       = addMonths($factura, -1);
            $userid        = $_POST['userid'];
            
            $conn       = getConn();
            $sql        = "CALL ACTUALIZA_PAGOS('$fec_pago', '$factura', '$nombre', '$apellido_p', '$apellido_m', '$rut', NULL, '$email', '$telefono', NULL, NULL, NULL, $clase, NULL, 1, $monto, NULL, NULL, $num_mes, $descuento, $nuevo_monto, 'N', @resp);";
            
            $query      = mysqli_query($conn, $sql);
            if($query){
                $query_resp = mysqli_query($conn, "SELECT @resp;");
                $result     = mysqli_fetch_array($query_resp);
                $cod_resp   = $result['@resp'];
                
                $sql_ex    = "UPDATE pagos_clientes SET observa = '$observaciones', userid = $userid WHERE pagos = $cod_resp;";
                $query_ex  = mysqli_query($conn, $sql_ex);
                
                if($query_ex){
                    $sql_del   = "CALL BORRA_BENEF($cod_resp, @resp);";
                    $query_del = mysqli_query($conn, $sql_del);
                    
                    $sql       = "CALL INSERT_BENEF($cod_resp, '$nombre', '$apellido_p', '$apellido_m', NULL, 1);";
                    $query     = mysqli_query($conn, $sql);
                    
                    echo $cod_resp;
                }
                else{
                    //echo("Error description 2: " . mysqli_error($conn));
                    echo false;
                }
            }
            else{
                //echo("Error description 1: " . mysqli_error($conn));
                echo false;
            }
        }
        else if($_POST['function'] == 'getUsername'){
            $pagos = $_POST['pagos'] * 1;
            
            $conn  = getConn();
            $sql   = "SELECT username FROM pagos_clientes WHERE pagos = $pagos;";
            $query = mysqli_query($conn, $sql);
            
            if($query){
                $result     = mysqli_fetch_array($query);
                $username   = $result['username'];
                echo md5($username);
            }
            else{
                //echo("Error description: " . mysqli_error($conn));
                echo false;
            }
        }
    }

    function getFecha(){
        date_default_timezone_set("America/Santiago");
        $time  = time();
        $fecha = date("Y-m-d H:i:s", $time);
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