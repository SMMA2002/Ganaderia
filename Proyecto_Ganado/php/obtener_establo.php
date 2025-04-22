<?php
session_start();
include("conexion.php");
$id_usuario = $_SESSION['ID'];
if (isset($_GET['animal_id'])) {
    $animal_id = intval($_GET['animal_id']);
    $sql = $conexion->query("SELECT establo.NOMBRE, establo.UBICACION
                             FROM animales 
                             INNER JOIN establo ON animales.Idestablo = establo.ID 
                             WHERE animales.ID = $animal_id AND animales.IdUser = $id_usuario");

    if ($fila = $sql->fetch_assoc()) {
        echo $fila['NOMBRE'] . " - " . $fila['UBICACION'];
    } else {
        echo "No encontrado";
    }
    exit; 
}

?>
