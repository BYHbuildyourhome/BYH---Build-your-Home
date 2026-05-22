<?php
require_once "conexion.php";

$id_emisor = (int)($_POST['id_emisor'] ?? 0);
$id_receptor = (int)($_POST['id_receptor'] ?? 0);
$mensaje = trim($_POST['mensaje'] ?? '');

if ($id_emisor <= 0 || $id_receptor <= 0 || $mensaje === '') {
    echo "ERROR";
    exit;
}

$stmt = $conn->prepare("INSERT INTO mensajes (id_emisor, id_receptor, mensaje) VALUES (?, ?, ?)");
$stmt->bind_param("iis", $id_emisor, $id_receptor, $mensaje);

echo $stmt->execute() ? "OK" : "ERROR";
?>
