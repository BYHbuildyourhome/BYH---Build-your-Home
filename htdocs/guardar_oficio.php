<?php
require_once "conexion.php";

$id_profesional = (int)($_POST['id_profesional'] ?? 0);
$titulo = trim($_POST['titulo'] ?? '');
$descripcion = trim($_POST['descripcion'] ?? '');
$precio = $_POST['precio'] ?? null;
$zona = trim($_POST['zona'] ?? '');

if ($id_profesional <= 0 || $titulo === '' || $descripcion === '') {
    echo "ERROR";
    exit;
}

$stmt = $conn->prepare("INSERT INTO oficios (id_profesional, titulo, descripcion, precio_orientativo, zona)
                        VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("issds", $id_profesional, $titulo, $descripcion, $precio, $zona);

echo $stmt->execute() ? "OK" : "ERROR";
?>