<?php
class Database
{
    private $hostname = "127.0.0.1";
    private $database = "ferreteria";
    private $username = "root";
    private $password = "";
    private $charset = "utf8";


    function conectar()
    {
        try {
            $conexion = "mysql:host=" . $this->hostname . "; dbname=" . $this->database . "; charset=" . $this->charset;
            $option = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false
            ];

            $pdo = new PDO($conexion, $this->username, $this->password, $option);
            return $pdo;
        } catch (PDOException $e) {
            echo 'Error De Conexion: ' . $e->getMessage();
            exit;
        }
    }
}
