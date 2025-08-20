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
  $ids = implode(",", $_SESSION['carrito']);
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
      <ul class="list-group">
        <?php foreach ($productos as $p): ?>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <?= $p['nombre_producto']; ?> - $<?= number_format($p['precio'], 2); ?>
            <a href="eliminar_carrito.php?id=<?= $p['id_producto']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  </div>
</body>

</html>