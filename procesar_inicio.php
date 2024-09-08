<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
header('Content-Type: application/json');

include('db.php'); 

$response = ['success' => false, 'message' => 'Error al iniciar sesión.'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    $query = "SELECT * FROM usuarios WHERE usuario = ?";
    $stmt = $conexion->prepare($query);
    
    if (!$stmt) {
        $response['message'] = "Error en la preparación de la consulta: " . $conexion->error;
        echo json_encode($response);
        exit();
    }

    $stmt->bind_param('s', $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        if (password_verify($contrasena, $user['contrasena'])) {

            $_SESSION['usuario'] = $user['usuario'];
            $_SESSION['rol'] = $user['rol'];

            switch ($user['rol']) {
                case 'admin':
                    $response['redirect'] = 'admin_dashboard.php';
                    break;
                case 'empleado':
                    $response['redirect'] = 'empleado_dashboard.php';
                    break;
                case 'cliente':
                    $response['redirect'] = 'inicio1.php';
                    break;
            }

            $response['success'] = true;
            $response['message'] = "Inicio de sesión exitoso";
        } else {
            $response['message'] = "Usuario o contraseña incorrectos";
        }
    } else {
        $response['message'] = "Usuario o contraseña incorrectos";
    }

    $stmt->close();
    $conexion->close();
}

echo json_encode($response);
?>