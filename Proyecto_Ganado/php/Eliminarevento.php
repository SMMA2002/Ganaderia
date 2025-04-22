<?php
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $id = $_POST["id"];
    
    // Consulta SQL para eliminar el evento
    $sql = "DELETE FROM eventos WHERE id = ?";
    
    if ($stmt = mysqli_prepare($conexion, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false]);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(["success" => false]);
    }
    
    mysqli_close($conexion);
} else {
    echo json_encode(["success" => false]);
}
?>
