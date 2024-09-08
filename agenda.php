<?php

// Habilitar errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'cliente') {
    header('Location: iniciar.html');
    exit();
}

include('db.php');

$query = "SELECT * FROM citas WHERE usuario = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param('s', $_SESSION['usuario']);
$stmt->execute();
$result = $stmt->get_result();

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
    <link rel="stylesheet" href="styles2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Salón de Belleza</title>
</head>
<body>
    <div class="navbar">
        <img src="imagenes/t.png" alt="Logo">
        <a href="logout.php">
        <i class="fas fa-sign-out-alt"></i></a>>
        <a href="catalogo.php">CATALOGO</a>
        <a href="agenda.php" class="agenda"> AGENDAR</a>
        <a href="inicio1.php" class="active">INICIO</a>
    </div>
    <br>
    <div class="container">
        <h2>Agenda tu Cita</h2>
        <form id="citaForm" action="procesar_cita.php" method="post">
            <input type="hidden" id="citaId" name="id">
            <input type="hidden" id="accion" name="accion">
            <div>
                <label for="servicio">Nombre de los servicios:</label>
                <select id="servicio" name="servicio">
                    <option value="Corte de pelo">Corte de pelo</option>
                    <option value="Manicura">Manicura</option>
                </select>
            </div>
            <div>
                <label for="funcionario">Funcionario:</label>
                <select id="funcionario" name="funcionario">
                    <option value="Andrea">Andrea</option>
                    <option value="Juan">Juan</option>
                    <option value="Ivonne">Ivonne</option>
                    <option value="Camila">Camila</option>
                    <option value="Luis">Luis</option>
                </select>
            </div>
            <div>
                <label for="fecha">Fecha:</label>
                <input type="date" id="fecha" name="fecha" required>
            </div>
            <div>
                <label for="hora">Hora:</label>
                <input type="time" id="hora" name="hora" required>
            </div>
            <div>
                <button type="submit" class="btn-agendar">Agendar</button>
            </div>
            <div>
                <button type="button" class="btn-cancelar" onclick="cancelarCita()">Cancelar</button>
            </div>
        </form>
    </div>

    <div class="container" id="misReservas">
        <h2>Mis Reservas</h2>
        <div id="listaReservas">
            <?php foreach ($citas as $cita): ?>
            <?php
            $hora_12 = date("h:i A", strtotime($cita['hora']));
            ?>
            <div class="reserva" data-id="<?= $cita['id'] ?>">
                <h3><?= htmlspecialchars($cita['servicio']) ?> con <?= htmlspecialchars($cita['funcionario']) ?></h3>
                <p>Fecha: <?= htmlspecialchars($cita['fecha']) ?></p>
                <p>Hora: <?= htmlspecialchars($hora_12) ?></p>
                <button type="button" onclick="eliminarReserva(this)">Eliminar</button>
                <button type="button" onclick="editarReserva(this)">Actualizar</button>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div id="message-container">
        <div id="message-box">
            <p id="message-text"></p>
            <button id="accept-button">Aceptar</button>
        </div>
    </div>

    <script>
        document.getElementById('citaForm').addEventListener('submit', function(event) {
            event.preventDefault();
            
            const id = document.getElementById('citaId').value;
            const servicio = document.getElementById('servicio').value;
            const funcionario = document.getElementById('funcionario').value;
            const fecha = document.getElementById('fecha').value;
            const hora = document.getElementById('hora').value;
            const accion = id ? 'actualizar' : 'agendar';

            document.getElementById('accion').value = accion;
            
            fetch('procesar_cita.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    id: id,
                    servicio: servicio,
                    funcionario: funcionario,
                    fecha: fecha,
                    hora: hora,
                    accion: accion
                })
            })
            .then(response => response.json())
            .then(data => {
                mostrarMensaje(data.message, !data.success, data.success);
            });
        });

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
            
            document.getElementById('citaId').value = id;
            document.getElementById('servicio').value = servicio;
            document.getElementById('funcionario').value = funcionario;
            document.getElementById('fecha').value = fecha;
            document.getElementById('hora').value = hora;
        }

        function cancelarCita() {
            document.getElementById('citaForm').reset();
            document.getElementById('citaId').value = '';
            document.getElementById('accion').value = '';
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


    <style>
        #message-container {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        #message-box {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }

        #message-box.error {
            border: 2px solid red;
        }

        #accept-button {
            background-color: blue;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #accept-button:hover {
            background-color: darkblue;
    </style>
</body>
</html>


