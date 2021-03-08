<?php
    include('conn.php');

    function getFecha(){
        date_default_timezone_set("America/Santiago");
        $fecha = date("Y-m-d");
        return $fecha;
    }
    function getFechabuy(){
        date_default_timezone_set("America/Santiago");
        $fecha = date("Ymd");
        return $fecha;
    }
    function getFechaYHora(){
        date_default_timezone_set("America/Santiago");
        $time  = time();
        $hora = date('Y-m-d H:i:s', $time);
        return $hora;
    }
    function getFechaYHoraExcel(){
        date_default_timezone_set("America/Santiago");
        $hora = date('Y-m-d_h.i_A');
        return $hora;
    }

    function getFechaCompleta(){
        $diassemana = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $date = $diassemana[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y')." | ".date('h:i:s A');
    } 

    function getNumPlanes(){
        $conn       = getConn();
        $sql        = "SELECT COUNT(*) as num_planes FROM planes WHERE est_plan = 's'";
        $query      = mysqli_query($conn, $sql);
        $result     = mysqli_fetch_array($query);
        $num_planes = $result['num_planes'];
        return $num_planes;
    }

    function getNombrePlanes(){
        $conn       = getConn();
        $sql        = "SELECT nom_plan FROM planes WHERE est_plan = 's'";
        $query      = mysqli_query($conn, $sql);
        $nom_planes = array();
        if(mysqli_num_rows($query) > 0){
            while($row = mysqli_fetch_array($query)){
                $nom_planes[] = $row['nom_plan'];
            }
        }
        return $nom_planes;
    }

    function getDescripPlan(){
        $conn       = getConn();
        $sql        = "SELECT desc_plan FROM planes WHERE est_plan = 's'";
        $query      = mysqli_query($conn, $sql);
        $desc_planes = array();
        if(mysqli_num_rows($query) > 0){
            while($row = mysqli_fetch_array($query)){
                $desc_planes[] = $row['desc_plan'];
            }
        }
        return $desc_planes;
    }

    function getTipoPago(){
        $conn       = getConn();
        $sql        = "SELECT nom_pago, cod_pago, num_mes FROM tipopago WHERE est_pago = 'S'";
        $query      = mysqli_query($conn, $sql);
        $datos      = array();
        $tipo_pago = array();
        $cod_pago  = array();
	    $num_mes = array();
        if(mysqli_num_rows($query) > 0){
            while($row = mysqli_fetch_array($query)){
                $tipo_pago[] = $row['nom_pago'];
                $cod_pago[] = $row['cod_pago'];
		        $num_mes[] = $row['num_mes'];
            }
        }
        $datos[0] = $tipo_pago;
        $datos[1] = $cod_pago;
	    $datos[2] = $num_mes;
        return $datos;
    }
?>