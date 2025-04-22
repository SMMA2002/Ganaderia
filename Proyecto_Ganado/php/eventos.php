<?php
session_start();
include("conexion.php");
if (!isset($_SESSION['ID'])) {
    die(json_encode(["error" => "Usuario no autenticado"]));
}
$id_usuario = $_SESSION['ID'];


header('Content-Type: application/json');

$sql = "SELECT id, titulo AS title, descripcion, fecha_inicio AS start, 
               DATE_ADD(fecha_fin, INTERVAL 1 DAY) AS end 
        FROM eventos
         WHERE Iduser = $id_usuario";
$resultado = mysqli_query($conexion, $sql);

$eventos = array();
while ($fila = mysqli_fetch_assoc($resultado)) {
    // Definir colores según el título o descripción
    if (strpos(strtolower($fila["title"]), 'Tarea') !== false) {
        $color = "#007bff"; // Azul
    } elseif (strpos(strtolower($fila["title"]), 'importante') !== false) {
        $color = "#dc3545"; // Rojo
    } elseif (strpos(strtolower($fila["title"]), 'personal') !== false) {
        $color = "#28a745"; // Verde
    } else {
        $color = "#ffc107"; // Amarillo para otros eventos
    }

    $eventos[] = array(
        "id" => $fila["id"],
        "title" => $fila["title"],
        "description" => $fila["descripcion"], 
        "start" => date("Y-m-d", strtotime($fila["start"])),
        "end" => date("Y-m-d", strtotime($fila["end"])),
        "color" => $color // Se añade el color dinámicamente
    );
}

echo json_encode($eventos);
?>

