<?php
session_start();

// Bloquear cache del navegador
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Verificar sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

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
            <img src="img/productos/<?= $row['id_producto']; ?>.jpg"
              class="card-img-top"
              style="height:200px; object-fit:cover;">
            <div class="card-body">
              <h5 class="card-title"><?= $row['nombre_producto']; ?></h5>
              <p class="card-text text-success fw-bold">$<?= number_format($row['precio'], 2); ?></p>
              <form action="comprar.php" method="POST">
                <input type="hidden" name="id_producto" value="<?= $row['id_producto']; ?>">
                <div class="input-group mb-2">
                  <input type="number" name="cantidad" class="form-control" value="1" min="1">
                </div>
                <button type="submit" class="btn btn-primary w-100">Comprar</button>
              </form>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>
</body>

</html>