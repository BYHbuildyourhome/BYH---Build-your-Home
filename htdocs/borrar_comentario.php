<?php
include("conexion.php");

if (!isset($_POST['id'])) {
    echo "ERROR";
    exit;
}

$id = $_POST['id'];

$sql = "DELETE FROM valoraciones WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "OK";
} else {
    echo "ERROR";
}

$conn->close();
?>