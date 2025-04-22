<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrate</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        background-color: #E3C8B1;
        font-family: Arial, sans-serif;
    }
        .login-container {
        box-sizing: content-box;
        width: 500px; /* Aumenta el ancho del formulario */
        margin:  auto;
        padding: 40px; /* Aumenta el espacio interior */
        background-color:rgb(255, 255, 255);
        border-radius: 15px; /* Bordes más redondeados */
        text-align: center;
        box-shadow: 0px 6px 10px rgba(0, 0, 0, 0.15); /* Sombra más pronunciada */
    }

    .login-container h2 {
        color: #8c6d48;
        margin-bottom: 30px; /* Más espacio debajo del título */
        font-size: 2em; /* Tamaño más grande */
    }

    .input-field {
        width: 90%; /* Reduce un poco el margen respecto a los bordes del contenedor */
        padding: 15px; /* Más espacio en los campos de entrada */
        margin: 15px 0; /* Más espacio entre los campos */
        background-color: #efe7dc;
        color: black;
        border: 1px solid #a27951;
        border-radius: 8px; /* Bordes más suaves */
        font-size: 1.1em; /* Texto más grande */
    }

    .input-field::placeholder {
        color: #8c6d48;
        font-size: 1em;
    }

    .btn {
        width: 90%; /* Coincide con el ancho de los campos */
        padding: 15px; /* Más alto y cómodo */
        background-color: #8c6d48;
        color: white;
        border: none;
        border-radius: 8px; /* Bordes suaves */
        font-size: 1.2em; /* Botón más grande */
        cursor: pointer;
    }

    .btn:hover {
        background-color: #a27951;
        color: black;
    }

    .signup-link {
        display: block;
        margin-top: 20px; /* Más espacio respecto al botón */
        color: #8c6d48;
        font-size: 1em; /* Tamaño más grande */
        text-decoration: none;
    }

    .signup-link:hover {
        color: #b85c5c;
    }

     
.message {
    padding: 15px;
    margin: 20px 0;
    border-radius: 5px;
    font-size: 16px;
    text-align: center;
}

.message.success {
    background-color: #4CAF50; 
    color: white;
}

.message.error {
    background-color: #f44336;
    color: white;
}
.footer {
            background: rgb(161, 101, 49);
            color: white;
            text-align: center;
            padding: 30px;
            width: 100%;
            position: relative;
            z-index: 30;
        }

        .footer a {
            color: white;
            margin: 0 20px;
            text-decoration: none;
            font-size: 20px;
        }

        .footer a:hover {
            color: #ffcc00;
        }
        * {
    box-sizing: border-box;
}
    </style>
</head>
<body>

    <div class="login-container">
 
    <img src="../images/11.png" width="180" height="180">

        <h2>Registrate</h2>
        <form action="registrarse.php" method="POST">
            <input type="text" class="input-field" name="nombre" placeholder="Nombre" required><br>
            <input type="text"class="input-field" name="apellido" placeholder="Apellido" required><br>
            <input type="text" class="input-field" name="usuario" placeholder="Usuario" required><br>
            <input type="email" class="input-field" name="correo" placeholder="Correo" required><br>
            <input type="password" class="input-field" name="password" placeholder="Contraseña" required><br>
            <button type="submit" class="btn">Registrarse</button><br><br>
            <button type="submit" class="btn" onclick="location.href='index.php'">Cancelar</button>
        </form>
        
    </div>

</body>
</html>

<?php
include('conexion.php');

$conn = new mysqli($server, $user, $pass, $DB) ;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $usuario = $_POST['usuario'];
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    // Encriptar la contraseña antes de guardarla
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insertar usuario en la base de datos
    $sql = "INSERT INTO usuario (Nombre, Apellido, User, Correo, Password) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $nombre, $apellido, $usuario, $correo, $hashed_password);
    header("Location: index.php");

    if ($stmt->execute()) {
        echo "<div class='message success'>Usuario registrado correctamente.</div>";
    } else {
        echo "<div class='message error'>Error al registrar usuario.</div>";
    }

    $stmt->close();
    $conn->close();
}
?>
