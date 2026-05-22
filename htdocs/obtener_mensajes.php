<?php
require_once "conexion.php";

$id_usuario = (int)($_GET['usuario'] ?? 0);
$id_pro = (int)($_GET['pro'] ?? 0);

$stmt = $conn->prepare("SELECT id_emisor, mensaje FROM mensajes
    WHERE (id_emisor = ? AND id_receptor = ?) OR (id_emisor = ? AND id_receptor = ?)
    ORDER BY fecha ASC");
$stmt->bind_param("iiii", $id_usuario, $id_pro, $id_pro, $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    echo (int)$row['id_emisor'] . "|" . htmlspecialchars($row['mensaje'], ENT_QUOTES, 'UTF-8') . "||";
}
?>
