<?php
session_start();
$id = $_GET['id'] ?? 0;

if(isset($_SESSION['carrito'])){
    $_SESSION['carrito'] = array_diff($_SESSION['carrito'], [$id]);
}

header("Location: carrito.php");
exit();
?>