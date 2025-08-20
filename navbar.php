<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <img src="img/Logo_ferreteria.png" alt="logo" class="me-3" style="width:60px; height:60px;">
    <a class="navbar-brand fw-bold" href="index.php">Ferretería Online</a>

    <form class="d-flex ms-auto" action="buscar.php" method="GET">
      <input class="form-control me-2" type="search" name="q" placeholder="Buscar producto..." aria-label="Buscar">
      <button class="btn btn-light" type="submit"><i class="bi bi-search"></i></button>
    </form>

    <ul class="navbar-nav ms-3">
      <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
      <li class="nav-item"><a class="nav-link" href="categorias.php">Categorías</a></li>

      <?php if (isset($_SESSION['usuario'])): ?>
        <li class="nav-item"><a class="nav-link" href="carrito.php"><i class="bi bi-cart"></i> Carrito</a></li>
        <li class="nav-item"><a class="nav-link" href="logout.php"><i class="bi bi-box-arrow-right"></i> Salir</a></li>
      <?php else: ?>
        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
        <li class="nav-item"><a class="nav-link" href="registrarme.php">Registro</a></li>
      <?php endif; ?>
    </ul>
  </div>
</nav>