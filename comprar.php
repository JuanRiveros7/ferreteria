<?php
session_start();
$id_producto = $_GET['id'] ?? 0;

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php?redirigir=carrito.php");
    exit();
}

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

if (!in_array($id_producto, $_SESSION['carrito'])) {
    $_SESSION['carrito'][] = $id_producto;
}

header("Location: carrito.php");
