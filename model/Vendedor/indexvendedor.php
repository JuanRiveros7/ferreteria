<?php
session_start();
require_once("../../database/conexion.php");

if (!isset($_SESSION['documento'])) {
    header("Location: ../../index.php");
    exit();
}
$doc = $_SESSION['documento'];
$nombre = $_SESSION['name_user'] ?? 'Cliente';
$db = new Database();
$con = $db->conectar();
$sql->execute([':doc' => $docCliente]);
$compras = $sql->fetchAll(PDO::FETCH_ASSOC);
