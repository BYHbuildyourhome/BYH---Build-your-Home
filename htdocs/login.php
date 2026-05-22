<?php
require_once "conexion.php";
header('Content-Type: application/json; charset=utf-8');

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if ($email === '' || $password === '') {
    echo json_encode(["success" => false, "error" => "Faltan datos"]);
    exit;
}

$stmt = $conn->prepare("SELECT id, nombre, apellidos, email, telefono, password, tipo, avatar, fecha_registro FROM usuarios WHERE email = ? LIMIT 1");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows === 1) {
    $user = $result->fetch_assoc();

    $storedPassword = $user['password'];

    $passwordOk = password_verify($password, $storedPassword) || hash_equals($storedPassword, $password);

    if ($passwordOk) {
        unset($user['password']);

        echo json_encode([
            "success" => true,
            "user" => $user
        ]);
        exit;
    }
}

echo json_encode(["success" => false, "error" => "Email o contraseña incorrectos"]);
?>