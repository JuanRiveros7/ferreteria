<?php
session_start();
require_once("database/conexion.php");
$db = new Database;
$con = $db->conectar();

if (!isset($_SESSION['usuario'])) {
  header("Location: login.php");
  exit();
}

$productos = [];
if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0) {
  $ids = implode(",", array_keys($_SESSION['carrito']));
  $sql = $con->query("SELECT * FROM productos WHERE id_producto IN ($ids)");
  $productos = $sql->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Carrito</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <?php include "navbar.php"; ?>

  <div class="container mt-4">
    <h3>Tu Carrito</h3>
    <?php if (empty($productos)): ?>
      <p>No tienes productos en el carrito.</p>
    <?php else: ?>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Producto</th>
            <th>Precio Unitario</th>
            <th>Cantidad</th>
            <th>Subtotal</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $total = 0;
          foreach ($productos as $p):
            $id = $p['id_producto'];
            $cantidad = $_SESSION['carrito'][$id];
            $subtotal = $p['precio'] * $cantidad;
            $total += $subtotal;
          ?>
            <tr>
              <td><?= $p['nombre_producto']; ?></td>
              <td>$<?= number_format($p['precio'], 2); ?></td>
              <td><?= $cantidad; ?></td>
              <td>$<?= number_format($subtotal, 2); ?></td>
              <td>
                <a href="eliminar_carrito.php?id=<?= $id; ?>&accion=restar" class="btn btn-warning btn-sm">-</a>
                <a href="eliminar_carrito.php?id=<?= $id; ?>&accion=sumar" class="btn btn-success btn-sm">+</a>
                <a href="eliminar_carrito.php?id=<?= $id; ?>&accion=eliminar" class="btn btn-danger btn-sm ms-2">Eliminar</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
        <tfoot>
          <tr>
            <th colspan="3" class="text-end">Total</th>
            <th colspan="2">$<?= number_format($total, 2); ?></th>
          </tr>
        </tfoot>
      </table>
      <?php if (!empty($productos)): ?>
        <div class="mt-3 text-end">
          <a href="checkout.php" class="btn btn-primary">Confirmar Compra</a>
        </div>
      <?php endif; ?>

    <?php endif; ?>
  </div>
</body>
</html>