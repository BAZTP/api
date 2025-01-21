<?php
/**
 * Web Service RESTful en PHP con MySQL (CRUD)
 */

require 'conexion.php';

$conexion = new Conexion();
$pdo = $conexion->obtenerConexion();

// Listar registros y consultar registro
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $sql = "SELECT * FROM contactos";
    $params = [];

    if (isset($_GET['id'])) {
        $sql .= " WHERE id=:id";
        $params[':id'] = $_GET['id'];
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    header("HTTP/1.1 200 Ok");
    echo json_encode($stmt->fetchAll());
    exit;
}

// Insertar registro
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sql = "INSERT INTO contactos (nombre, telefono, email) VALUES(:nombre, :telefono, :email)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':nombre', $_POST['nombre']);
    $stmt->bindValue(':telefono', $_POST['telefono']);
    $stmt->bindValue(':email', $_POST['email']);
    $stmt->execute();
    $idPost = $pdo->lastInsertId();
    if ($idPost) {
        header("HTTP/1.1 200 Ok");
        echo json_encode($idPost);
        exit;
    }
}

// Actualizar registro
if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $sql = "UPDATE contactos SET nombre=:nombre, telefono=:telefono, email=:email WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':nombre', $_GET['nombre']);
    $stmt->bindValue(':telefono', $_GET['telefono']);
    $stmt->bindValue(':email', $_GET['email']);
    $stmt->bindValue(':id', $_GET['id']);
    $stmt->execute();
    header("HTTP/1.1 200 Ok");
    exit;
}

//Eliminar registro
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $sql = "DELETE FROM contactos WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $_GET['id']);
    $stmt->execute();
    header("HTTP/1.1 200 Ok");
    exit;
}

// Si no coincide con ningún método de solicitud, devolver Bad Request
header("HTTP/1.1 400 Bad Request");
