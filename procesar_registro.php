<?php
session_start();
header('Content-Type: application/json');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('db.php');

$response = ['success' => false, 'message' => 'Error al registrar el usuario.'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $cedula = $_POST['cedula'];
    $telefono = $_POST['telefono'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);

    $query = "INSERT INTO usuarios (usuario, contrasena, nombre, apellidos, cedula, telefono, rol) VALUES (?, ?, ?, ?, ?, ?, 'cliente')";
    $stmt = $conexion->prepare($query);
    
    if (!$stmt) {
        $response['message'] = "Error en la preparación de la consulta: " . $conexion->error;
        echo json_encode($response);
        exit();
    }

    $stmt->bind_param('ssssss', $usuario, $contrasena, $nombre, $apellidos, $cedula, $telefono);
    
    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Registro exitoso.';
    } else {
        $response['message'] = 'Error: ' . $stmt->error;
    }

    $stmt->close();
    $conexion->close();
}

echo json_encode($response);
?>