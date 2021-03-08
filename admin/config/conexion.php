<?php
const MODO1 = "P";

if(MODO1 == "P"){
    $servername = "localhost";
    $username   = "restcl_admin";
    $password   = "SbSimdou@&G@";
    $db         = "mall_restcl";
}
if(MODO1 == "I"){
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
?>
