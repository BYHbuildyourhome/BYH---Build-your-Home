<?php
include("conexion.php");

$id_usuario = $_POST['id_usuario'];
$id_profesional = $_POST['id_profesional'];

// comprobar si ya existe conversación
$sql = "SELECT id FROM mensajes
        WHERE (id_emisor=? AND id_receptor=?)
        OR (id_emisor=? AND id_receptor=?)
        LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iiii", $id_usuario, $id_profesional, $id_profesional, $id_usuario);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {

    // primer mensaje automático del profesional
    $mensaje = "Hola, soy tu profesional, ¿en qué puedo ayudarte?";

    $sql2 = "INSERT INTO mensajes (id_emisor, id_receptor, mensaje)
             VALUES (?, ?, ?)";

    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param("iis", $id_profesional, $id_usuario, $mensaje);
    $stmt2->execute();
}

echo "OK";

$conn->close();
?>