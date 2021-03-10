<?php
const MODO2 = "P";

function getConn(){
    if(MODO2 == "P"){
        /*$servername = "localhost";
        $username   = "restcl_admin";
        $password   = "SbSimdou@&G@";
        $db         = "mall_restcl"; */

        $servername = "localhost";
        $username   = "root";
        $password   = "";
        $db         = "res_mall";
    }

    if(MODO2 == "I"){
        $servername = "localhost";
        $username   = "restcl_admin";
        $password   = "SbSimdou@&G@";
        $db         = "defensau_restcl";
    }
    
    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $db);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}
?>