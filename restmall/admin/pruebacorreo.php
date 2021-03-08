<?php 

/** BASE DE DATOS CONN, FECHA Y HORA PARA REGISTROS**/
include("config/func.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/** Mail Interno **/

                 $fila = 2;
                 $sql_direccion_correos = "CALL TRAER_MAIL($fila);";
                 $conn = getConn();
                 $query_direccion_correos = mysqli_query($conn, $sql_direccion_correos);

                 $result_direccion_correos = mysqli_num_rows($query_direccion_correos);
                
                 mysqli_close($conn);
                
                if($result_direccion_correos == 0){
                    $message8 = "TRAER EMAIL NO FUNCIONO";

                }else{
                    $message8 = "TRAER EMAIL FUNCIONA CORRECTO"; 
                    while ($data3 = mysqli_fetch_array($query_direccion_correos)) {

                       $destinatario   = $data3['Pdes1'];
                       $destinatario2  = $data3['Pdes2'];
                       $cc             = $data3['Pcop1'];
                       $cc2            = $data3['Pcop2'];

                    }
                    mysqli_free_result($query_direccion_correos);
                }
echo $destinatario;
echo $destinatario2; 
echo $cc;
echo $cc2; 
?>