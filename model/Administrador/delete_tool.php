<?php
session_start();
require_once("../../database/conexion.php");
$db = new Database;
$con = $db->conectar();

if (!isset($_GET['id'])) {
    header("Location: edit_tool.php");
    exit;
}

$id = $_GET['id'];

$sql = "DELETE FROM productos WHERE id_producto = ?";
$stmt = $con->prepare($sql);
$stmt->execute([$id]);

header("Location: edit_tool.php");
exit;
