<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
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

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $conn->query("DELETE FROM usuarios WHERE id = $id");
}

if (isset($_POST['update_role'])) {
    $id = intval($_POST['id']);
    $role = $_POST['role'];
    $conn->query("UPDATE usuarios SET rol = '$role' WHERE id = $id");
}

if (isset($_POST['add_user'])) {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $cedula = $_POST['cedula'];
    $telefono = $_POST['telefono'];
    $usuario = $_POST['usuario'];
    $password = password_hash($_POST['contrasena'], PASSWORD_BCRYPT);
    $rol = $_POST['rol'];
    
    $conn->query("INSERT INTO usuarios (nombre, apellidos, cedula, telefono, usuario, contrasena, rol) VALUES ('$nombre', '$apellidos', '$cedula', '$telefono', '$usuario', '$password', '$rol')");
}

$usuarios = $conn->query("SELECT * FROM usuarios");

$conn->close();
?> 

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles_admin2.css">
    <title>Gestión de Usuarios</title>
</head>
<body>
    <div class="navbar">
        <img src="imagenes/t.png" alt="Logo">
        <a href="admin_dashboard.php">Inicio</a>
        <a href="gestionar_usuarios.php" class="active">Gestión de Usuarios</a>
        <a href="gestionar_citas.php">Gestión de Citas</a>
        <a href="logout.php">Cerrar Sesión</a>
    </div>

    <div class="container">
        <h1>Gestión de Usuarios</h1>


        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Cédula</th>
                    <th>Teléfono</th>
                    <th>Usuario</th>
                    <th>Rol</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($usuario = $usuarios->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $usuario['id']; ?></td>
                        <td><?php echo $usuario['nombre']; ?></td>
                        <td><?php echo $usuario['apellidos']; ?></td>
                        <td><?php echo $usuario['cedula']; ?></td>
                        <td><?php echo $usuario['telefono']; ?></td>
                        <td><?php echo $usuario['usuario']; ?></td>
                        <td>
                            <form action="gestionar_usuarios.php" method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
                                <select name="role">
                                    <option value="admin" <?php if ($usuario['rol'] == 'admin') echo 'selected'; ?>>Administrador</option>
                                    <option value="empleado" <?php if ($usuario['rol'] == 'empleado') echo 'selected'; ?>>Empleado</option>
                                    <option value="cliente" <?php if ($usuario['rol'] == 'cliente') echo 'selected'; ?>>Cliente</option>
                                </select>
                                <input type="submit" name="update_role" value="Actualizar Rol" class="btn">
                            </form>
                            <a href="gestionar_usuarios.php?action=delete&id=<?php echo $usuario['id']; ?>" class="btn" onclick="return confirm('¿Estás seguro de que quieres eliminar este usuario?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>


        <button class="btn" id="toggleFormBtn">Agregar Nuevo Usuario</button>


        <div class="form-container" id="formContainer">
            <h2>Agregar Nuevo Usuario</h2>
            <form action="gestionar_usuarios.php" method="post">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" required><br>
                <label for="apellidos">Apellidos:</label>
                <input type="text" name="apellidos" required><br>
                <label for="cedula">Cédula:</label>
                <input type="text" name="cedula" required><br>
                <label for="telefono">Teléfono:</label>
                <input type="text" name="telefono" required><br>
                <label for="usuario">Usuario:</label>
                <input type="text" name="usuario" required><br>
                <label for="contrasena">Contraseña:</label>
                <input type="password" name="contrasena" required><br>
                <label for="rol">Rol:</label>
                <select name="rol" required>
                    <option value="admin">Administrador</option>
                    <option value="empleado">Empleado</option>
                    <option value="cliente">Cliente</option>
                </select><br>
                <input type="submit" name="add_user" value="Agregar Usuario" class="btn">
            </form>
        </div>
    </div>

    <script>
        document.getElementById('toggleFormBtn').addEventListener('click', function() {
            var formContainer = document.getElementById('formContainer');
            if (formContainer.style.display === 'none' || formContainer.style.display === '') {
                formContainer.style.display = 'block';
                this.textContent = 'Ocultar Formulario';
            } else {
                formContainer.style.display = 'none';
                this.textContent = 'Agregar Nuevo Usuario';
            }
        });
    </script>
</body>
</html>