<?php
/*$servername = "localhost";
$userbase   = "restcl_admin";
$password   = "SbSimdou@&G@";
$db         = "restcl"; */



$servername = "localhost";
$userbase   = "root";
$password   = "";
$db         = "res";

// Create connection
$conn = mysqli_connect($servername, $userbase, $password, $db);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
