<?php
session_start();

$id = $_GET['id'] ?? 0;
$accion = $_GET['accion'] ?? '';

if (isset($_SESSION['carrito'][$id])) {
    if ($accion === 'restar') {
        $_SESSION['carrito'][$id]--;
        if ($_SESSION['carrito'][$id] <= 0) {
            unset($_SESSION['carrito'][$id]);
        }
    } elseif ($accion === 'sumar') {
        $_SESSION['carrito'][$id]++;
    } elseif ($accion === 'eliminar') {
        unset($_SESSION['carrito'][$id]);
    }
}

header("Location: carrito.php");
exit();