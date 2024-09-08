<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'empleado') {
    header('Location: iniciar.html');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles_empleado.css">
    <title>Panel de Control - Empleado</title>
</head>
<body>
    <div class="navbar">
        <img src="imagenes/t.png" alt="Logo">
        <a href="empleado_dashboard.php" class="active">Inicio</a>
        <a href="citas_asignadas.php">Citas Asignadas</a>
        <a href="logout.php">Cerrar Sesión</a>
    </div>

    <div class="container">
        <h1>Bienvenido al Panel del Empleado</h1>
        <div class="dashboard-sections">
            <div class="section">
                <h2>Citas Asignadas</h2>
                <p>Visualiza las citas que te han sido asignadas.</p>
                <a href="citas_asignadas.php" class="btn">Ir a Citas Asignadas</a>
            </div>
        </div>
    </div>

</body>
</html>