<?php
session_start(); // Iniciar la sesión

// Destruir todas las variables de sesión
session_unset();

// Destruir la sesión
session_destroy();

// Redirigir al login
header("Location: index.php"); // Cambia "login.php" por la URL o archivo que uses para el login
exit();
?>
