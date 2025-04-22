<?php
session_start(); // Iniciar la sesión

include('conexion.php'); 

$error_message = "";

$conn = new mysqli($server, $user, $pass, $DB);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuario WHERE (User = ? OR Correo = ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $usuario, $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user_data = $result->fetch_assoc();

        if (password_verify($password, $user_data['Password'])) {
            $_SESSION['ID'] = $user_data['ID'];
            $_SESSION['nombre'] = $user_data['Nombre'];
            $_SESSION['apellido'] = $user_data['Apellido'];
            $_SESSION['user'] = $user_data['User'];

            header("Location: ../Inicio.php");
            exit();
        } else {
            $error_message = "Usuario o contraseña incorrectos";
        }
    } else {
        $error_message = "Usuario no encontrado";
    }

    $stmt->close();
}

$conn->close(); 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        <h2>Iniciar Sesión</h2>
        
        <?php if (!empty($error_message)): ?>
            <div class="message error"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>

        <form action="index.php" method="POST">
            <input type="text" class="input-field" name="usuario" placeholder="Correo o nombre de usuario" required><br>
            <input type="password" class="input-field" name="password" placeholder="Contraseña" required><br>
            <button type="submit" class="btn">Ingresar</button>
        </form>
        <a href="registrarse.php" class="signup-link">¿No tienes cuenta? Registrate</a>
    </div>
    


</body>
</html>
