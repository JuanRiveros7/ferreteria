<?php
session_start();
require_once("database/conexion.php");
$db = new Database;
$con = $db->conectar();

$id_categoria = $_GET['id'] ?? 0;

if ($id_categoria) {
  $sql = $con->prepare("SELECT * FROM productos WHERE id_categoria = ?");
  $sql->execute([$id_categoria]);
} else {
  $sql = $con->query("SELECT * FROM productos");
}
$productos = $sql->fetchAll(PDO::FETCH_ASSOC);

$categorias = $con->query("SELECT * FROM categorias")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Categorías</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
  <?php include "navbar.php"; ?>

  <div class="container mt-4">
    <h3>Categorías</h3>
    <ul class="nav nav-pills mb-3">
      <?php foreach ($categorias as $c): ?>
        <li class="nav-item">
          <a class="nav-link <?= $c['id_categoria'] == $id_categoria ? 'active' : ''; ?>" href="categorias.php?id=<?= $c['id_categoria']; ?>">
            <?= $c['nombre_categoria']; ?>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>

    <div class="row">
      <?php foreach ($productos as $p): ?>
        <div class="col-md-3 mb-4">
          <div class="card shadow-sm border-0">
            <img src="img/productos/<?= $p['id_producto']; ?>.jpg" class="card-img-top" style="height:200px; object-fit:cover;">
            <div class="card-body">
              <h5 class="card-title"><?= $p['nombre_producto']; ?></h5>
              <p class="card-text text-success fw-bold">$<?= number_format($p['precio'], 2); ?></p>
              <a href="comprar.php?id=<?= $p['id_producto']; ?>" class="btn btn-primary w-100">Comprar</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</body>

</html>