<?php
require_once __DIR__ . "/../conexion.php";
header('Content-Type: application/json; charset=utf-8');

$id = (int)($_POST['id'] ?? 0);

if ($id <= 0 || !isset($_FILES['avatar'])) {
    echo json_encode(["success" => false, "error" => "Faltan datos"]);
    exit;
}

$allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
$mime = mime_content_type($_FILES['avatar']['tmp_name']);

if (!isset($allowed[$mime])) {
    echo json_encode(["success" => false, "error" => "Formato no permitido. Usa JPG, PNG o WEBP"]);
    exit;
}

if ($_FILES['avatar']['size'] > 2 * 1024 * 1024) {
    echo json_encode(["success" => false, "error" => "La imagen supera 2 MB"]);
    exit;
}

if (!is_dir(__DIR__)) {
    mkdir(__DIR__, 0755, true);
}

$fileName = "avatar_" . $id . "_" . time() . "." . $allowed[$mime];
$relativePath = "uploads/" . $fileName;
$targetFile = __DIR__ . "/" . $fileName;

if (move_uploaded_file($_FILES['avatar']['tmp_name'], $targetFile)) {
    $stmt = $conn->prepare("UPDATE usuarios SET avatar = ? WHERE id = ?");
    $stmt->bind_param("si", $relativePath, $id);
    $stmt->execute();
    echo json_encode(["success" => true, "url" => $relativePath]);
} else {
    echo json_encode(["success" => false, "error" => "Error al subir imagen"]);
}
?>
