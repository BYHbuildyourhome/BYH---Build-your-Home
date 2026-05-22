<?php
require_once "conexion.php";
header('Content-Type: application/json; charset=utf-8');

$id = (int)($_GET['id'] ?? 0);

if ($id <= 0) {
    echo json_encode(["success" => false, "error" => "ID no válido"]);
    exit;
}

$stmt = $conn->prepare("SELECT id, nombre, apellidos, email, telefono, tipo, avatar, fecha_registro FROM usuarios WHERE id = ? LIMIT 1");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode(["success" => true, "user" => $row]);
} else {
    echo json_encode(["success" => false, "error" => "Usuario no encontrado"]);
}
?>
