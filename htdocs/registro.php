<?php
require_once "conexion.php";
header('Content-Type: application/json; charset=utf-8');

$nombre = trim($_POST['nombre'] ?? '');
$apellidos = trim($_POST['apellidos'] ?? '');
$email = trim($_POST['email'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$password = $_POST['password'] ?? '';
$tipo = $_POST['tipo'] ?? 'cliente';

if ($nombre === '' || $apellidos === '' || $email === '' || $telefono === '' || $password === '') {
    echo json_encode(["success" => false, "error" => "Rellena todos los campos"]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["success" => false, "error" => "Email no válido"]);
    exit;
}

if (!in_array($tipo, ['cliente', 'profesional', 'trabajador', 'admin'], true)) {
    $tipo = 'cliente';
}

$check = $conn->prepare("SELECT id FROM usuarios WHERE email = ? LIMIT 1");
$check->bind_param("s", $email);
$check->execute();
$checkResult = $check->get_result();

if ($checkResult && $checkResult->num_rows > 0) {
    echo json_encode(["success" => false, "error" => "Ese email ya está registrado"]);
    exit;
}

$hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO usuarios (nombre, apellidos, email, telefono, password, tipo) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $nombre, $apellidos, $email, $telefono, $hash, $tipo);

if ($stmt->execute()) {
    $user = [
        "id" => $stmt->insert_id,
        "nombre" => $nombre,
        "apellidos" => $apellidos,
        "email" => $email,
        "telefono" => $telefono,
        "tipo" => $tipo,
        "avatar" => null
    ];
    echo json_encode(["success" => true, "user" => $user]);
} else {
    echo json_encode(["success" => false, "error" => "No se pudo registrar el usuario"]);
}
?>
