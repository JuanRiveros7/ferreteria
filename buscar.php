<?php
session_start();
require_once("database/conexion.php");
$db = new Database;
$con = $db->conectar();

$q = $_GET['q'] ?? '';
$sql = $con->prepare("SELECT * FROM productos WHERE nombre_producto LIKE ?");
$sql->execute(["%$q%"]);
$productos = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Buscar productos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <?php include "navbar.php"; ?>

  <div class="container mt-4">
    <h3>Resultados para: <span class="text-primary"><?= htmlspecialchars($q) ?></span></h3>
    <div class="row">
      <?php if (empty($productos)): ?>
        <p>No se encontraron productos.</p>
      <?php else: ?>
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
      <?php endif; ?>
    </div>
  </div>
</body>

</html>