<?php
include("conexion.php");

$id_profesional = $_GET['id_profesional'];

$sql = "SELECT v.id, v.comentario, v.estrellas, u.nombre
        FROM valoraciones v
        JOIN usuarios u ON v.id_cliente = u.id
        WHERE v.id_profesional = ?
        ORDER BY v.fecha DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_profesional);
$stmt->execute();

$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {

    // Seguridad: evitar XSS
    $nombre = htmlspecialchars($row['nombre']);
    $comentario = htmlspecialchars($row['comentario']);

    // Estrellas dinámicas
    $estrellas = str_repeat("⭐", (int)$row['estrellas']);

    echo "
    <div class='mb-3 p-2 border-bottom d-flex justify-content-between align-items-start'>

        <div>
            <div class='d-flex align-items-center gap-2'>
                <strong>{$nombre}</strong>
                <span class='text-warning'>{$estrellas}</span>
            </div>

            <div class='mt-1'>
                {$comentario}
            </div>
        </div>

        <button class='btn btn-sm btn-outline-danger'
                onclick='borrarComentario({$row['id']})'>
            <i class='bi bi-trash'></i>
        </button>

    </div>
    ";
}

$conn->close();
?>