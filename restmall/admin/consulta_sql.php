<?php

include_once "config/permisos.php";

session_start();
$rol = $_SESSION['rol'];
$currentPage = "consulta_t"; 
$acceso = getPermisos($currentPage, $rol);
if(!$acceso){
    header("location: ../login.php");    
}

function getTransc($transc,$bdesde,$bhasta){
    $conn = getConn();
    
    if($transc == "A"){
        $sql  = "SELECT PT.t_cod_tran, PC.pagos, PC.clase, PC.rut, PT.t_fec_fac, PT.t_fecha_tbk, PT.t_val_plan, PT.t_buyorder, PT.t_authorizationcode, PT.t_payment_type_code, US.usuario, PT.t_observa FROM pagos_clientes PC INNER JOIN pagos_transac PT on PC.pagos = PT.t_cod_pagos INNER JOIN user US on PT.t_userid = US.userid WHERE ( (CAST(PT.t_fecha_tbk AS DATE) >= '$bdesde') AND (CAST(PT.t_fecha_tbk AS DATE) <= '$bhasta') AND (PC.estado = 'S') ) ORDER BY PT.t_cod_tran, PT.t_fecha_tbk ASC";

        $query = mysqli_query($conn, $sql);
        if(mysqli_num_rows($query) > 0){
            $datos = array();
            while($row = mysqli_fetch_array($query)){
                $datos[] = $row; 
            }
            return $datos;
        }
        else{
            //die;
            return NULL;
        }
    }elseif($transc == "AR"){
        $sql  = "SELECT PT.t_cod_tran, PC.pagos, PC.clase, PC.rut, PT.t_fec_fac, PT.t_fecha_tbk, PT.t_val_plan, PT.t_buyorder, PT.t_authorizationcode, PT.t_payment_type_code, US.usuario, PT.t_observa FROM pagos_clientes PC INNER JOIN pagos_transac PT on PC.pagos = PT.t_cod_pagos INNER JOIN user US on PT.t_userid = US.userid WHERE ( (CAST(PT.t_fecha_tbk AS DATE) >= '$bdesde') AND (CAST(PT.t_fecha_tbk AS DATE) <= '$bhasta') AND (PC.estado = 'S') AND (PT.t_estado = 'S') ) ORDER BY PT.t_cod_tran, PT.t_fecha_tbk ASC";

        $query = mysqli_query($conn, $sql);
        if(mysqli_num_rows($query) > 0){
            $datos = array();
            while($row = mysqli_fetch_array($query)){
                $datos[] = $row; 
            }
            return $datos;
        }
        else{
            //die;
            return NULL;
        }
    }elseif($transc == "F"){
        $sql  = "SELECT FA.f_cod_fall, PC.pagos, PC.clase, PC.rut, FA.f_fec_fac, FA.t_fecha_tbk, FA.f_val_plan, FA.f_buyorder, FA.f_payment_type_code, US.usuario, FA.f_log FROM pagos_clientes PC INNER JOIN fallidas FA on PC.pagos = FA.f_cod_pagos INNER JOIN user US on FA.f_userid = US.userid WHERE ( (CAST(FA.t_fecha_tbk AS DATE) >= '$bdesde') AND (CAST(FA.t_fecha_tbk AS DATE) <= '$bhasta') AND ( (PC.estado = 'S') OR (PC.estado = 'I') ) AND (FA.f_estado = 'S')) ORDER BY FA.f_cod_fall, FA.t_fecha_tbk ASC";

        $query = mysqli_query($conn, $sql);
        if(mysqli_num_rows($query) > 0){
            $datos = array();
            while($row = mysqli_fetch_array($query)){
                $datos[] = $row; 
            }
            return $datos;
        }
        else{
            //die;
            return NULL;
        }
    }elseif($transc == "M"){
        $sql  = "SELECT * FROM (SELECT PC.pagos, PC.clase, MAX(FA.f_cod_fall) as f_cod_fall, FA.f_fec_fac, FA.t_fecha_tbk, PC.t_nombres, PC.t_apellido1, PC.rut, PC.email, PC.telefono, FA.f_val_plan, US.usuario, FA.f_log FROM pagos_clientes PC INNER JOIN fallidas FA on PC.pagos = FA.f_cod_pagos INNER JOIN user US on FA.f_userid = US.userid WHERE ( (CAST(FA.t_fecha_tbk AS DATE) >= '$bdesde') AND (CAST(FA.t_fecha_tbk AS DATE) <= '$bhasta') AND PC.estado = 'M' ) GROUP BY FA.f_cod_pagos DESC) as r
        INNER JOIN fallidas f
        ON f.f_cod_pagos = r.pagos AND f.f_cod_fall= r.f_cod_fall ORDER BY f.f_cod_fall DESC";

        $query = mysqli_query($conn, $sql);
        if(mysqli_num_rows($query) > 0){
            $datos = array();
            while($row = mysqli_fetch_array($query)){
                $datos[] = $row; 
            }
            return $datos;
        }
        else{
            //die;
            return NULL;
        }
    }elseif($transc == "R"){
        $sql  = "SELECT RE.r_cod_rev, RE.r_cod_tran, PC.pagos, PC.clase, PC.rut, RE.r_fec_fac, RE.r_fecha_tbk, RE.r_val_mensual, RE.r_val_plan, RE.r_buyorder, RE.r_authorizationcode, RE.r_payment_type_code, US.usuario, RE.r_observa FROM pagos_clientes PC INNER JOIN reversas RE on PC.pagos = RE.r_cod_pagos INNER JOIN user US on RE.r_userid = US.userid WHERE ( (CAST(RE.r_fecha_tbk AS DATE) >= '$bdesde') AND (CAST(RE.r_fecha_tbk AS DATE) <= '$bhasta') AND (PC.estado = 'S') ) ORDER BY RE.r_cod_rev, RE.r_fecha_tbk ASC";

        $query = mysqli_query($conn, $sql);
        if(mysqli_num_rows($query) > 0){
            $datos = array();
            while($row = mysqli_fetch_array($query)){
                $datos[] = $row; 
            }
            return $datos;
        }
        else{
            //die;
            return NULL;
        }
    }elseif($transc == "FR"){
        $sql  = "SELECT FA.f_cod_fall, PC.pagos, PC.clase, PC.rut, FA.f_fec_fac, FA.t_fecha_tbk, FA.f_val_mensual, FA.f_val_plan, FA.f_buyorder, FA.f_payment_type_code, US.usuario, FA.f_log FROM pagos_clientes PC INNER JOIN fallidas FA on PC.pagos = FA.f_cod_pagos INNER JOIN user US on FA.f_userid = US.userid WHERE ( (CAST(FA.t_fecha_tbk AS DATE) >= '$bdesde') AND (CAST(FA.t_fecha_tbk AS DATE) <= '$bhasta') AND ( (PC.estado = 'S') OR (PC.estado = 'I') ) AND (FA.f_estado = 'R') ) ORDER BY FA.f_cod_fall, FA.t_fecha_tbk ASC";

        $query = mysqli_query($conn, $sql);
        if(mysqli_num_rows($query) > 0){
            $datos = array();
            while($row = mysqli_fetch_array($query)){
                $datos[] = $row; 
            }
            return $datos;
        }
        else{
            //die;
            return NULL;
        }
    }else{
        $sql  = "(SELECT t_cod_tran, PC.pagos, PC.clase, PC.rut, t_fec_fac, t_fecha_tbk, t_val_plan, t_buyorder, t_authorizationcode, t_payment_type_code, US.usuario, t_observa FROM pagos_clientes PC INNER JOIN pagos_transac on PC.pagos = t_cod_pagos INNER JOIN user US on t_userid = US.userid WHERE ( (CAST(t_fecha_tbk AS DATE) >= '$bdesde') AND (CAST(t_fecha_tbk AS DATE) <= '$bhasta') AND (PC.estado = 'S') AND (t_estado != 'X') ) )
        UNION
        (SELECT f_cod_fall, PC.pagos, PC.clase, PC.rut, f_fec_fac, t_fecha_tbk, f_val_plan, f_buyorder, NULL, f_payment_type_code, US.usuario, f_log FROM pagos_clientes PC INNER JOIN fallidas on PC.pagos = f_cod_pagos INNER JOIN user US on f_userid = US.userid WHERE ( (CAST(t_fecha_tbk AS DATE) >= '$bdesde') AND (CAST(t_fecha_tbk AS DATE) <= '$bhasta') AND ( (PC.estado = 'S') OR (PC.estado = 'I') ) AND (f_estado = 'S') ) ) ORDER BY t_fecha_tbk ASC";

        $query = mysqli_query($conn, $sql);
        if(mysqli_num_rows($query) > 0){
            $datos = array();
            while($row = mysqli_fetch_array($query)){
                $datos[] = $row; 
            }
            return $datos;
        }
        else{
            //die;
            return NULL;
        }
    }
}
