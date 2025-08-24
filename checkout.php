<?php
session_start();
require_once("database/conexion.php");
$db = new Database;
$con = $db->conectar();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $documentoCliente = trim($_POST['documento']);
    $nombre           = trim($_POST['nombre']);
    $telefono         = trim($_POST['telefono']);
    $email            = trim($_POST['email']);
    $direccion        = trim($_POST['direccion']);

    $sql = $con->prepare("SELECT * FROM clientes WHERE documento = ?");
    $sql->execute([$documentoCliente]);
    $cliente = $sql->fetch(PDO::FETCH_ASSOC);

    if (!$cliente) {
        $insert = $con->prepare("INSERT INTO clientes (documento, nombre_completo, telefono, email, direccion) 
                                 VALUES (?, ?, ?, ?, ?)");
        $insert->execute([$documentoCliente, $nombre, $telefono, $email, $direccion]);
    }

    $total = 0;
    foreach ($_SESSION['carrito'] as $idProd => $cantidad) {
        $sqlProd = $con->prepare("SELECT precio FROM productos WHERE id_producto = ?");
        $sqlProd->execute([$idProd]);
        $prod = $sqlProd->fetch(PDO::FETCH_ASSOC);

        if ($prod) {
            $total += $prod['precio'] * $cantidad;
        }
    }

    $insertVenta = $con->prepare("INSERT INTO ventas (documento_cliente, fecha_venta, total) 
                                  VALUES (?, NOW(), ?)");
    $insertVenta->execute([$documentoCliente, $total]);
    $idVenta = $con->lastInsertId();

    foreach ($_SESSION['carrito'] as $idProd => $cantidad) {
        $sqlProd = $con->prepare("SELECT precio FROM productos WHERE id_producto = ?");
        $sqlProd->execute([$idProd]);
        $prod = $sqlProd->fetch(PDO::FETCH_ASSOC);

        if ($prod) {
            $insertDetalle = $con->prepare("INSERT INTO detalle_venta (id_venta, id_producto, cantidad, precio_unitario) 
                                            VALUES (?, ?, ?, ?)");
            $insertDetalle->execute([$idVenta, $idProd, $cantidad, $prod['precio']]);
        }
    }

    unset($_SESSION['carrito']);

    header("Location: carrito.php?success=1");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h3>Datos del Cliente</h3>
        <form method="POST">
            <div class="mb-3">
                <label>Documento</label>
                <input type="text" name="documento" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Nombre Completo</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Teléfono</label>
                <input type="text" name="telefono" class="form-control">
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control">
            </div>
            <div class="mb-3">
                <label>Dirección</label>
                <input type="text" name="direccion" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Finalizar Compra</button>
        </form>
    </div>
</body>
</html>