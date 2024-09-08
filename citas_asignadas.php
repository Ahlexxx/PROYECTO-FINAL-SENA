<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start(); 
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'empleado') {
    header('Location: iniciar.html');
    exit();
}


$host = 'localhost'; 
$db = 'salon_de_belleza'; 
$user = 'root'; 
$pass = ''; 

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}


$empleado_usuario = $_SESSION['usuario'];

$sql = "SELECT * FROM citas WHERE funcionario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $empleado_usuario);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles_empleado1.css">
    <title>Citas Asignadas</title>
</head>
<body>
    <div class="navbar">
        <img src="imagenes/t.png" alt="Logo">
        <a href="empleado_dashboard.php">Inicio</a>
        <a href="citas_asignadas.php" class="active">Citas Asignadas</a>
        <a href="logout.php">Cerrar Sesión</a>
    </div>

    <div class="container">
        <h1>Citas Asignadas</h1>
        <table border="1">
            <tr>
                <th>Cliente</th>
                <th>Servicio</th>
                <th>Fecha</th>
                <th>Hora</th>
            </tr>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['usuario']; ?></td>
                        <td><?php echo $row['servicio']; ?></td>
                        <td><?php echo $row['fecha']; ?></td>
                        <td><?php echo $row['hora']; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No tienes citas asignadas.</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>