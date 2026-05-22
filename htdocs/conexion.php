<?php
$host = "sql202.infinityfree.com";
$user = "if0_41785818";
$pass = "mAiyagZ6LxAH4N0";
$db = "if0_41785818_buildyourhome";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die(json_encode(["error" => "Error de conexión"]));
}

$conn->set_charset("utf8mb4");
?>