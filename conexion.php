<?php
// Archivo de conexión: conexion.php
$servername = "sql206.infinityfree.com";
$username = "if0_38133178";
$password = "Ft1100785516";
$dbname = "if0_38133178_centromedico";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
