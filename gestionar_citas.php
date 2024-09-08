<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header('Location: iniciar.html');
    exit();
}

include('db.php');


$query = "SELECT citas.*, usuarios.usuario AS nombre_usuario FROM citas 
          JOIN usuarios ON citas.usuario = usuarios.usuario"; 
$result = $conexion->query($query);

if (!$result) {
    die("Error en la consulta: " . $conexion->error);
}

$citas = [];
while ($row = $result->fetch_assoc()) {
    $citas[] = $row;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles_admin1.css">
    <title>Gestión de Citas</title>
</head>
<body>
    <div class="navbar">
        <img src="imagenes/t.png" alt="Logo">
        <a href="admin_dashboard.php">Inicio</a>
        <a href="gestionar_usuarios.php">Gestión de Usuarios</a>
        <a href="gestionar_citas.php" class="active">Gestión de Citas</a>
        <a href="logout.php">Cerrar Sesión</a>
    </div>

    <div class="container">
        <h1>Gestión de Citas</h1>
        <div id="misReservas">
            <h2>Citas</h2>
            <div id="listaReservas">
                <?php foreach ($citas as $cita): ?>
                <?php
                $hora_12 = date("h:i A", strtotime($cita['hora']));
                ?>
                <div class="reserva" data-id="<?= htmlspecialchars($cita['id']) ?>">
                    <h3><?= htmlspecialchars($cita['servicio']) ?> con <?= htmlspecialchars($cita['funcionario']) ?></h3>
                    <p>Fecha: <?= htmlspecialchars($cita['fecha']) ?></p>
                    <p>Hora: <?= htmlspecialchars($hora_12) ?></p>
                    <p>Usuario: <?= htmlspecialchars($cita['nombre_usuario']) ?></p>
                    <button type="button" onclick="eliminarReserva(this)">Eliminar</button>
                    <button type="button" onclick="editarReserva(this)">Actualizar</button>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script>
        function eliminarReserva(button) {
            const reservaDiv = button.parentNode;
            const id = reservaDiv.getAttribute('data-id');
            
            fetch('procesar_cita.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    accion: 'eliminar',
                    id: id
                })
            })
            .then(response => response.json())
            .then(data => {
                mostrarMensaje(data.message, !data.success, data.success);
                if (data.success) {
                    reservaDiv.remove();
                }
            });
        }

        function editarReserva(button) {
            const reservaDiv = button.parentNode;
            const id = reservaDiv.getAttribute('data-id');
            const servicio = reservaDiv.querySelector('h3').textContent.split(' con ')[0];
            const funcionario = reservaDiv.querySelector('h3').textContent.split(' con ')[1];
            const fecha = reservaDiv.querySelector('p').textContent.split('Fecha: ')[1];
            const hora = reservaDiv.querySelector('p').nextElementSibling.textContent.split('Hora: ')[1];
            
        }

        function mostrarMensaje(mensaje, esError = false, recargar = false) {
            const messageContainer = document.getElementById('message-container');
            const messageBox = document.getElementById('message-box');
            const messageText = document.getElementById('message-text');
            
            messageText.textContent = mensaje;
            messageBox.className = esError ? 'error' : '';
            
            messageContainer.style.display = 'flex';
            
            document.getElementById('accept-button').onclick = function() {
                messageContainer.style.display = 'none';
                if (recargar) {
                    location.reload();
                }
            };
        }
    </script>
    
</body>
</html>