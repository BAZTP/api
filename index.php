<?php
require 'conexion.php';

header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

switch ($_GET['entity']) {
    case 'pacientes':
        handlePacientes($method, $input);
        break;
    case 'medicos':
        handleMedicos($method, $input);
        break;
    case 'citas':
        handleCitas($method, $input);
        break;
    default:
        echo json_encode(["error" => "Entidad no válida"]);
}

function handlePacientes($method, $input)
{
    global $conn;
    switch ($method) {
        case 'GET':
            $id = $_GET['id'] ?? null;
            $sql = $id ? "SELECT * FROM Pacientes WHERE id_paciente = $id" : "SELECT * FROM Pacientes";
            $result = $conn->query($sql);
            $data = $result->fetch_all(MYSQLI_ASSOC);
            echo json_encode($data);
            break;
        case 'POST':
            $nombre = $input['nombre'];
            $apellido = $input['apellido'];
            $telefono = $input['telefono'];
            $direccion = $input['direccion'];
            $fecha_nacimiento = $input['fecha_nacimiento'];
            $sql = "INSERT INTO Pacientes (nombre, apellido, telefono, direccion, fecha_nacimiento) VALUES ('$nombre', '$apellido', '$telefono', '$direccion', '$fecha_nacimiento')";
            if ($conn->query($sql) === TRUE) {
                echo json_encode(["id" => $conn->insert_id]);
            } else {
                echo json_encode(["error" => $conn->error]);
            }
            break;
        case 'PUT':
            $id = $_GET['id'];
            $nombre = $input['nombre'];
            $apellido = $input['apellido'];
            $telefono = $input['telefono'];
            $direccion = $input['direccion'];
            $fecha_nacimiento = $input['fecha_nacimiento'];
            $sql = "UPDATE Pacientes SET nombre='$nombre', apellido='$apellido', telefono='$telefono', direccion='$direccion', fecha_nacimiento='$fecha_nacimiento' WHERE id_paciente=$id";
            echo json_encode(["success" => $conn->query($sql)]);
            break;
        case 'DELETE':
            $id = $_GET['id'];
            $sql = "DELETE FROM Pacientes WHERE id_paciente=$id";
            echo json_encode(["success" => $conn->query($sql)]);
            break;
    }
}

function handleMedicos($method, $input)
{
    global $conn;
    switch ($method) {
        case 'GET':
            $id = $_GET['id'] ?? null;
            $sql = $id ? "SELECT * FROM Medicos WHERE id_medico = $id" : "SELECT * FROM Medicos";
            $result = $conn->query($sql);
            $data = $result->fetch_all(MYSQLI_ASSOC);
            echo json_encode($data);
            break;
        case 'POST':
            $nombre = $input['nombre'];
            $apellido = $input['apellido'];
            $telefono = $input['telefono'];
            $direccion = $input['direccion'];
            $especialidad = $input['especialidad'];
            $sql = "INSERT INTO Medicos (nombre, apellido, telefono, direccion, especialidad) VALUES ('$nombre', '$apellido', '$telefono', '$direccion', '$especialidad')";
            if ($conn->query($sql) === TRUE) {
                echo json_encode(["id" => $conn->insert_id]);
            } else {
                echo json_encode(["error" => $conn->error]);
            }
            break;
        case 'PUT':
            $id = $_GET['id'];
            $nombre = $input['nombre'];
            $apellido = $input['apellido'];
            $telefono = $input['telefono'];
            $direccion = $input['direccion'];
            $especialidad = $input['especialidad'];
            $sql = "UPDATE Medicos SET nombre='$nombre', apellido='$apellido', telefono='$telefono', direccion='$direccion', especialidad='$especialidad' WHERE id_medico=$id";
            echo json_encode(["success" => $conn->query($sql)]);
            break;
        case 'DELETE':
            $id = $_GET['id'];
            $sql = "DELETE FROM Medicos WHERE id_medico=$id";
            echo json_encode(["success" => $conn->query($sql)]);
            break;
    }
}

function handleCitas($method, $input)
{
    global $conn;
    switch ($method) {
        case 'GET':
            $id = $_GET['id'] ?? null;
            $sql = $id ? "SELECT * FROM Citas WHERE id_cita = $id" : "SELECT * FROM Citas";
            $result = $conn->query($sql);
            $data = $result->fetch_all(MYSQLI_ASSOC);
            echo json_encode($data);
            break;
        case 'POST':
            $id_paciente = $input['id_paciente'];
            $id_medico = $input['id_medico'];
            $fecha = $input['fecha'];
            $hora = $input['hora'];
            $sql = "INSERT INTO Citas (id_paciente, id_medico, fecha, hora) VALUES ($id_paciente, $id_medico, '$fecha', '$hora')";
            if ($conn->query($sql) === TRUE) {
                echo json_encode(["id" => $conn->insert_id]);
            } else {
                echo json_encode(["error" => $conn->error]);
            }
            break;
        case 'PUT':
            $id = $_GET['id'];
            $id_paciente = $input['id_paciente'];
            $id_medico = $input['id_medico'];
            $fecha = $input['fecha'];
            $hora = $input['hora'];
            $sql = "UPDATE Citas SET id_paciente=$id_paciente, id_medico=$id_medico, fecha='$fecha', hora='$hora' WHERE id_cita=$id";
            echo json_encode(["success" => $conn->query($sql)]);
            break;
        case 'DELETE':
            $id = $_GET['id'];
            $sql = "DELETE FROM Citas WHERE id_cita=$id";
            echo json_encode(["success" => $conn->query($sql)]);
            break;
    }
}

$conn->close();

?>
