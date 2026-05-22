<?php
include("conexion.php");

$id_cliente = (int)($_POST['id_cliente'] ?? 0);
$id_profesional = (int)($_POST['id_profesional'] ?? 0);
$comentario = trim($_POST['comentario'] ?? '');
$estrellas = (int)($_POST['estrellas'] ?? 5);

if ($id_cliente <= 0) {
    echo "ERROR: id_cliente no llega";
    exit;
}

if ($id_profesional <= 0) {
    echo "ERROR: id_profesional no llega";
    exit;
}

if ($comentario === '') {
    echo "ERROR: comentario vacío";
    exit;
}

if ($estrellas < 1 || $estrellas > 5) {
    $estrellas = 5;
}

$sql = "INSERT INTO valoraciones 
        (id_cliente, id_profesional, estrellas, comentario)
        VALUES (?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo "ERROR SQL: " . $conn->error;
    exit;
}

$stmt->bind_param("iiis", $id_cliente, $id_profesional, $estrellas, $comentario);

if ($stmt->execute()) {
    echo "OK";
} else {
    echo "ERROR INSERT: " . $stmt->error;
}

$conn->close();
?>