<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header('Location: iniciar.html');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles_admin.css">
    <title>Panel de Control - Admin</title>
</head>
<body>
    <div class="navbar">
        <img src="imagenes/t.png" alt="Logo">
        <a href="admin_dashboard.php" class="active">Inicio</a>
        <a href="gestionar_usuarios.php">Gestión de Usuarios</a>
        <a href="gestionar_citas.php">Gestión de Citas</a>
        <a href="logout.php">Cerrar Sesión</a>
    </div>

    <div class="container">
        <h1>Bienvenido al Panel de Control</h1>
        <div class="dashboard-sections">
            <div class="section">
                <h2>Gestión de Usuarios</h2>
                <p>Administra clientes y empleados.</p>
                <a href="gestionar_usuarios.php" class="btn">Ir a Gestión de Usuarios</a>
            </div>
            <div class="section">
                <h2>Gestión de Citas</h2>
                <p>Maneja y visualiza todas las citas.</p>
                <a href="gestionar_citas.php" class="btn">Ir a Gestión de Citas</a>
            </div>
        </div>
    </div>

</body>
</html>