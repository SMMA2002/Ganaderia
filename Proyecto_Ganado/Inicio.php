<?php
session_start(); // Asegura que la sesión está iniciada

// Conexión a la base de datos
include("php/conexion.php");

// Verificar si el usuario está autenticado y obtener su ID
if (!isset($_SESSION['ID'])) {
    die("<script>alert('Error: No hay un usuario autenticado.'); window.location.href = 'php/index.php';</script>");
}

$id_usuario = $_SESSION['ID']; // Ahora sí está definido correctamente

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganadería</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/es.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tooltipster/4.2.8/css/tooltipster.bundle.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tooltipster/4.2.8/js/tooltipster.bundle.min.js"></script>
    <style>
    body {
        background: url('images/Fondito.jpg') no-repeat center center;
        background-size: cover;
        background-attachment: fixed;
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
        background: url('images/1.png') no-repeat center center;
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

    #calendar {
        width: 90%;
        margin: 20px auto;
        max-width: 1200px;
        background: #f8f1e4;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0px 6px 10px rgba(0, 0, 0, 0.15);
        color: #3c2f2f;
    }

    #calendar h2 {
        color: #8c6d48;
        text-align: center;
        font-size: 1.8em;
        margin-bottom: 15px;
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
            <a href="php/logout.php" class="logout-icon" title="Cerrar sesión">
                <i class="fas fa-door-open"></i> 
            </a>
        <?php endif; ?>
        </a>

       
    </div>
    

    <a href="php/AddAnimal.php">Agregar Ganado</a>
    <div class="submenu">
        <a href="#" class="submenu-toggle">Tratamientos y vacunas</a>
        <div class="submenu-content">
            <a href="php/vacunacion.php">Vacunación</a>
            <a href="php/reporteVacunas.php">Registro de Vacunas</a>
            <a href="php/Tratamiento.php">Tratamientos</a>
            <a href="php/reporteTrata.php">Registro de Tratamientos</a>
        </div>
    </div>
    <div class="submenu">
        <a href="php/Insemina.php" class="submenu-toggle">Inseminación Artificial</a>
        <div class="submenu-content">
        <a href="php/reporteinsemina.php">Registro de Inseminaciones</a>
        <a href="php/Addsemen.php">Muestras de semen</a>
        <a href="../php/reportesemen.php" class="submenu-toggle">Reporte de semen</a>

        </div>
    </div>
    <a href="php/AddEvento.php">Agregar Eventos</a>
    <div class="submenu">
        <a href="php/reportestablo.php" class="submenu-toggle">Reporte de lugares de ganado</a>
        <div class="submenu-content">
        <a href="php/Addlugar.php">Agregar Nuevo Lugar</a>
            <a href="php/cambiarestablo.php">Cambiar a ganado de Lugar</a>
        </div> 
    </div>
        <a href="php/UpDeAnimal.php">Vender o eliminar Ganado</a>
        
        </div>

    </nav>


    <div class="content">
    <h2 style="text-align: center;">Calendario de Actividades</h2>
    <div id="calendar"></div>

    <script>
      document.addEventListener('DOMContentLoaded', function() {
    let calendarEl = document.getElementById('calendar');
    let calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        editable: true,
        events: 'php/eventos.php',

        eventDrop: function(info) {
            let id = info.event.id;
            let fechaInicio = info.event.startStr;
            let fechaFin = info.event.endStr;

            fetch('actualizar_evento.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `id=${id}&fecha_inicio=${fechaInicio}&fecha_fin=${fechaFin}`
            });
        },

        eventContent: function(info) {
            return {
                html: `<b>${info.event.title}</b><br><small>${info.event.extendedProps.description || ''}</small>`
            };
        },

        eventClick: function(info) {
            let eventoId = info.event.id;
            let descripcion = info.event.extendedProps.description || "Sin descripción";

            let confirmacion = confirm(`Descripción: ${descripcion}\n\n¿Ya realizaste este evento? Si confirmas, se eliminará.`);

            if (confirmacion) {
                fetch('php/Eliminarevento.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `id=${eventoId}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        info.event.remove();
                        alert("Evento eliminado correctamente.");
                    } else {
                        alert("Error al eliminar el evento.");
                    }
                })
                .catch(error => console.error("Error:", error));
            }
        }
    });

    calendar.render();
});

    </script>
    </div>



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
