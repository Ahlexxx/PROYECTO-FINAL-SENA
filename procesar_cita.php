<?php
session_start();
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $accion = $_POST['accion'];

    if ($accion == 'agendar') {
        $usuario = $_SESSION['usuario'];
        $servicio = $_POST['servicio'];
        $funcionario = $_POST['funcionario'];
        $fecha = $_POST['fecha'];
        $hora = $_POST['hora'];


        $query = "INSERT INTO citas (usuario, servicio, funcionario, fecha, hora) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param('sssss', $usuario, $servicio, $funcionario, $fecha, $hora);
        $stmt->execute();
        echo json_encode(["success" => true, "message" => "Cita agendada exitosamente."]);
    } elseif ($accion == 'eliminar') {
        $id = $_POST['id'];
        $query = "DELETE FROM citas WHERE id = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        echo json_encode(["success" => true, "message" => "Cita eliminada exitosamente."]);
    } elseif ($accion == 'actualizar') {
        $id = $_POST['id'];
        $servicio = $_POST['servicio'];
        $funcionario = $_POST['funcionario'];
        $fecha = $_POST['fecha'];
        $hora = $_POST['hora'];

        $query = "UPDATE citas SET servicio = ?, funcionario = ?, fecha = ?, hora = ? WHERE id = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param('ssssi', $servicio, $funcionario, $fecha, $hora, $id);
        $stmt->execute();
        echo json_encode(["success" => true, "message" => "Cita actualizada exitosamente."]);
    } else {
        echo json_encode(["success" => false, "message" => "Acción no válida."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Método de solicitud no válido."]);
}
?>
