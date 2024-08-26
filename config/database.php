<?php
class Database
{
    private $host = "localhost";
    private $database = "tienda_online";
    private $user = "root";
    private $password = "";
    private $charset = "utf8";

    function conectar()
    {
        $conexion = "mysql:host=" . $this->host . ";dbname=" . $this->database . ";charset=" . $this->charset;
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false
        ];
        try {
            $pdo = new PDO($conexion, $this->user, $this->password, $options);
            return $pdo;
        } catch (PDOException $e) {
            print_r("Error al conectar: " . $e->getMessage());
            exit;
        }
    }

}
?>