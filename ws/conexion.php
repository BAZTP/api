<?php
/**
 * Conexión a base de datos de MySQL con PDO
 */
class Conexion extends PDO
{
    private $hostBd = 'sql206.infinityfree.com'; // Servidor del hosting
    private $nombreBd = 'if0_38133178_webservice'; // Nombre de la base de datos
    private $usuarioBd = 'if0_38133178'; // Usuario de la base de datos
    private $passwordBd = 'Ft110785516'; // Contraseña de la base de datos
    private $pdo; // Propiedad para almacenar el objeto PDO

    public function __construct()
    {
        try {
            // Crear una nueva conexión PDO
            $this->pdo = new PDO("mysql:host=$this->hostBd;dbname=$this->nombreBd;charset=utf8", $this->usuarioBd, $this->passwordBd);

            // Establecer el modo de errores de PDO a excepciones
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error al conectar a la base de datos: " . $e->getMessage();
            exit;
        }
    }

    public function obtenerConexion()
    {
        return $this->pdo;
    }
}
?>
