<?php
require_once "conexion.php";
header('Content-Type: application/json; charset=utf-8');

$id = (int)($_POST['id'] ?? 0);
if ($id <= 0) {
    echo json_encode(["success" => false, "error" => "ID no válido"]);
    exit;
}

$stmt = $conn->prepare("SELECT avatar FROM usuarios WHERE id = ? LIMIT 1");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row && !empty($row['avatar'])) {
    $file = __DIR__ . "/" . ltrim($row['avatar'], "/");
    if (is_file($file)) {
        unlink($file);
    }
}

$update = $conn->prepare("UPDATE usuarios SET avatar = NULL WHERE id = ?");
$update->bind_param("i", $id);
$update->execute();

echo json_encode(["success" => true]);
?>
