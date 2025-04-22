<?php

$server = "localhost";
$user = "root";
$pass = "";
$DB = "fincamachado";

$conexion = new mysqli($server, $user, $pass, $DB) ;

if ($conexion-> connect_errno){

    die("Conexion Fallida". $conexion->connect_errno);
}else {
    
}

?>