<?php
session_start();
require_once("database/conexion.php");
$db = new Database;
$con = $db->conectar();

$sql = $con->query("SELECT p.*, c.nombre_categoria 
                    FROM productos p 
                    INNER JOIN categorias c ON p.id_categoria = c.id_categoria");
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Ferretería Online</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
  <?php include "navbar.php"; ?>

  <div class="container mt-4">
    <div class="row">
      <?php while ($row = $sql->fetch(PDO::FETCH_ASSOC)): ?>
        <div class="col-md-3 mb-4">
          <div class="card shadow-sm border-0">
            <img src="img/productos/<?= $row['id_producto']; ?>.jpg" class="card-img-top" style="height:200px; object-fit:cover;">
            <div class="card-body">
              <h5 class="card-title"><?= $row['nombre_producto']; ?></h5>
              <p class="card-text text-success fw-bold">$<?= number_format($row['precio'], 2); ?></p>
              <a href="comprar.php?id=<?= $row['id_producto']; ?>" class="btn btn-primary w-100">Comprar</a>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>
</body>

</html>