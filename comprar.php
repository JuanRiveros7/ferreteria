<?php
session_start();

// Verificamos si viene por POST (formulario) o GET (enlace)
$id_producto = $_POST['id_producto'] ?? ($_GET['id'] ?? 0);
$cantidad = $_POST['cantidad'] ?? 1;

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php?redirigir=carrito.php");
    exit();
}

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

/*
   Estructura del carrito:
   $_SESSION['carrito'] = [
      id_producto => cantidad,
      id_producto2 => cantidad,
      ...
   ];
*/

if (isset($_SESSION['carrito'][$id_producto])) {
    $_SESSION['carrito'][$id_producto] += $cantidad;
} else {
    $_SESSION['carrito'][$id_producto] = $cantidad;
}

header("Location: carrito.php");
exit();