<?php
session_start(); // Asegura que la sesión está iniciada

// Conexión a la base de datos
include("conexion.php");

// Verificar si el usuario está autenticado y obtener su ID
if (!isset($_SESSION['ID'])) {
    die("<script>alert('Error: No hay un usuario autenticado.'); window.location.href = 'index.php';</script>");
}

$id_usuario = $_SESSION['ID']; // Ahora sí está definido correctamente

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tratamientos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>  
    body {
        background: url('../images/Fondo.jpg') no-repeat center center;
        background-size: cover;
        background-attachment: fixed;
        width: 100%;
        margin: 0;
        font-family: 'Georgia', serif;
        color: #3c2f2f;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        transition: margin-left 0.3s ease;
        overflow-x: hidden;
    }

    header {
        width: 100%;
        background: url('../images/1.png') no-repeat center center;
        background-size: cover;
        color: #f8f1e4;
        font-size: 3em;
        font-weight: bold;
        text-align: center;
        padding: 200px 0;
        text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.7);
        position: relative;
        z-index: 1;
    }

    header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: -1;
    }

    .menu-btn {
        position: fixed;
        top: 15px;
        left: 15px;
        background: #8c6d48;
        color: white;
        padding: 12px 18px;
        cursor: pointer;
        font-size: 20px;
        border-radius: 8px;
        transition: background 0.3s ease;
        z-index: 1001;
    }

    .menu-btn:hover {
        background: #a27951;
    }

    .menu {
        position: fixed;
        left: -260px;
        top: 0;
        width: 260px;
        height: 100%;
        background: #4a3226;
        color: white;
        padding-top: 60px;
        transition: left 0.3s ease;
        z-index: 1000;
    }

    .menu a {
        display: block;
        padding: 15px;
        text-decoration: none;
        color: #f8f1e4;
        font-size: 18px;
        border-bottom: 1px solid #7d5a4a;
        transition: background 0.3s;
    }

    .menu a:hover {
        background: #a27951;
    }

    .menu.active {
        left: 0;
    }

    body.menu-open .content {
        margin-left: 260px;
    }

    .content {
        flex: 1;
        padding: 30px;
        transition: margin-left 0.3s ease;
    }

    .footer {
        background: #4a3226;
        color: #f8f1e4;
        text-align: center;
        padding: 20px;
        font-size: 16px;
        width: 100%;
    }

    .footer a {
        color: #d4a15a;
        text-decoration: none;
        margin: 0 10px;
    }

    .footer a:hover {
        color: #a27951;
    }

    .user-info {
        padding: 10px 15px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background-color: #8c6d48;
        color: white;
        font-size: 14px;
        border-top: 1px solid #7d5a4a;
    }

    .logout-icon {
        color: white;
        font-size: 14px;
        cursor: pointer;
    }

    .logout-icon:hover {
        color: #d4a15a;
    }


    .login-container {
        box-sizing: content-box;
        width: 500px; /* Aumenta el ancho del formulario */
        margin: -30px auto;
        padding: 40px; /* Aumenta el espacio interior */
        background-color: #f4efe8;
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
        background-color: #6c8e6d;
        color: white;
    }

    .message.error {
        background-color: #b85c5c;
        color: white;
    }

    .submenu {
        position: relative;
    }

    .submenu-content {
        display: none;
        position: absolute;
        left: 100%;
        top: 0;
        background: #4a3226;
        width: 220px;
        padding: 10px 0;
    }

    .submenu-content a {
        display: block;
        padding: 10px;
        color: white;
        text-decoration: none;
        border-bottom: 1px solid #7d5a4a;
    }

    .submenu-content a:hover {
        background: #a27951;
    }

    .submenu:hover .submenu-content {
        display: block;
    }
</style>
</head>
<body>
<header></header>

    <div class="menu-btn" id="menuBtn">
        <i class="fas fa-bars"></i>
    </div>
    <br>
    

    <nav class="menu" id="menu">
    <div class="user-info">
        <a> 
            <i class="fas fa-user-circle"></i> 
            <?php
                if (isset($_SESSION['nombre']) && isset($_SESSION['apellido'])) {
                    echo $_SESSION['nombre'] . " " . $_SESSION['apellido'];
                } else {
                    echo "Usuario no logueado";
                }
            ?>
             
        <?php if (isset($_SESSION['nombre'])): ?>
            <a href="logout.php" class="logout-icon" title="Cerrar sesión">
                <i class="fas fa-door-open"></i> 
            </a>
        <?php endif; ?>
        </a>

       
    </div>

        <a href="../Inicio.php">Inicio</a>
        <a href="AddAnimal.php">Agregar Ganado</a>

        <div class="submenu">
        <a href="#" class="submenu-toggle">Tratamientos y vacunas</a>
        <div class="submenu-content">
            <a href="vacunacion.php">Vacunación</a>
            <a href="reporteVacunas.php">Registro de Vacunas</a>
            <a href="reporteTrata.php">Registro de Tratamientos</a>
        </div>
    </div>
    <div class="submenu">
        <a href="Insemina.php" class="submenu-toggle">Inseminación Artificial</a>
        <div class="submenu-content">
        <a href="reporteinsemina.php">Registro de Inseminaciones</a>
        <a href="../php/Addsemen.php">Muestras de semen</a>
        <a href="../php/reportesemen.php" class="submenu-toggle">Reporte de semen</a>

        </div>
    </div>
    <a href="AddEvento.php">Agregar Eventos</a>  
    <div class="submenu">
        <a href="reportestablo.php" class="submenu-toggle">Reporte de lugares de ganado</a>
        <div class="submenu-content">
        <a href="Addlugar.php">Agregar Nuevo Lugar</a>
            <a href="cambiarestablo.php">Cambiar a ganado de Lugar</a>
        </div>
        </div>
        <a href="UpDeAnimal.php">Vender o eliminar Ganado</a>  

    </nav>


    <div class="content">
    <div class="login-container">


     <h2>¿A quien le daremos tratamientos?</h2>
     
     <form action="Tratamiento.php" method="POST">

     <select name="Animal" class="input-field" required><br>
        <option selected disabled>--Seleccionar Paciente--</option>
        <?php
include("conexion.php");
// Consulta para obtener las pólizas
$sql = $conexion->query("SELECT * FROM animales Where  IdUser = $id_usuario");
while ($resultado = $sql->fetch_assoc()) {
    echo "<option value='" . $resultado['ID'] . "'>" . $resultado['Nombre']  . " ---- Raza: " . $resultado['Raza'] . "</option>";
}
?>
</select>
     <input type="date" class="input-field" name="Fecha" placeholder="Fecha inicio de Tratamiento (año-mes-dia)" required><br>
     <input type="date" class="input-field" name="Fecha2" placeholder="Fin de Tratamiento (año-mes-dia) (opcional)" ><br>
     <textarea class="input-field" name="comentarios" rows="4"  placeholder="Detalles del Tratamiento"></textarea><br>
     <input type="text"class="input-field" name="Medicamento" placeholder="¿Qué medicamento le dio?" ><br>
        
        
         <button type="submit" class="btn">Agregar</button>
     </form>
     
 </div>
    </div>

    <footer class="footer">

    </footer>

    <script>
    let menuBtn = document.getElementById('menuBtn');
    let menu = document.getElementById('menu');
    
    // Recupera el estado guardado del menú (si está abierto o cerrado)
    let isOpen = localStorage.getItem('menuOpen') === 'true';

    // Si el menú está abierto en el almacenamiento local, aplicamos los cambios correspondientes
    if (isOpen) {
        menu.classList.add('active');
        document.body.classList.add('menu-open');
        menuBtn.style.left = '10px'; // Ajusta la posición si el menú está abierto
    } else {
        menu.classList.remove('active');
        document.body.classList.remove('menu-open');
        menuBtn.style.left = '20px'; // Ajusta la posición si el menú está cerrado
    }

    // Maneja el clic en el botón del menú
    menuBtn.addEventListener('click', function() {
        isOpen = !isOpen; // Cambia el estado del menú
        menu.classList.toggle('active');
        menuBtn.style.left = isOpen ? '10px' : '20px'; // Cambia la posición del botón

        // Cambia el estado del body para ajustar el contenido
        if (isOpen) {
            document.body.classList.add('menu-open');
        } else {
            document.body.classList.remove('menu-open');
        }

        // Guarda el estado del menú en localStorage
        localStorage.setItem('menuOpen', isOpen);
    });
</script>

</body>
</html>
<?php
include("conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_animal = !empty($_POST['Animal']) ? trim($_POST['Animal']) : "NULL";
    $fecha_inicio = trim($_POST['Fecha']);
    $fecha_fin = !empty($_POST['Fecha2']) ? $_POST['Fecha2'] : "Tratamiento Vigente";
    $comentarios = trim($_POST['comentarios']);
    $medicamento = !empty($_POST['Medicamento']) ? $_POST['Medicamento'] : "NULL";
    $titulo = $_POST['titulo'];
    $fecha_inicio = $_POST['Fecha'];
    $fecha_fin = $_POST['Fecha2'];

    if (strtotime($fecha_inicio) && strtotime($fecha_fin)) {
        // Convertir las fechas a un formato adecuado si es necesario
        $fecha_inicio = date('Y-m-d', strtotime($fecha_inicio));
        $fecha_fin = date('Y-m-d', strtotime($fecha_fin));
    }


    if (empty($id_animal) || empty($fecha_inicio) || empty($comentarios) || empty($medicamento)) {
        echo "<script>alert('Error: Los campos Animal, Fecha, Medicamento y Comentarios son obligatorios.'); window.history.back();</script>";
        exit();
    }


    $sql = "INSERT INTO Tratamiento (IdAnimal, FechaInicio, FechaFin, Detalles, Medicamento)
            VALUES ('$id_animal', '$fecha_inicio', '$fecha_fin', '$comentarios', '$medicamento')";

            
    if (mysqli_query($conexion, $sql)) {
        echo "<script>alert('Registro exitoso.'); window.location.href = 'Tratamiento.php';</script>";
    } else {
        echo "<script>alert('Error al registrar: " . mysqli_error($conexion) . "'); window.history.back();</script>";
    }

$sql2 = "INSERT INTO eventos (titulo, fecha_inicio, fecha_fin, descripcion,Iduser) 
        VALUES ('$titulo', '$fecha_inicio', '$fecha_fin', '$comentarios','$id_usuario')";        

    if (mysqli_query($conexion, $sql2)) {
        echo "<script>alert('Registro exitoso.'); window.location.href = 'Tratamiento.php';</script>";
    } else {
        echo "<script>alert('Error al registrar: " . mysqli_error($conexion) . "'); window.history.back();</script>";
    }
}
?>

    