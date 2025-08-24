<?php
session_start();
$nombre = $_SESSION['name_user'] ?? 'Usuario desconocido';
$rol = $_SESSION['rol'] ?? '';

if (isset($_POST['cerrar'])) {
    session_destroy();
    header("Location: ../../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <header class="bg-primary text-white py-3 shadow">
        <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <img src="../../img/Logo_ferreteria.png" alt="logo" class="me-3" style="width:60px; height:60px;">
                <h4 class="mb-0">
                    Bienvenido, <?php echo htmlspecialchars($nombre); ?>
                    <small class="text-light">| Rol: <?php echo htmlspecialchars($rol); ?></small>
                </h4>
            </div>
            <form method="post" action="../../logout.php" class="mt-3 mt-md-0">
                <button type="submit" name="cerrar" class="btn btn-outline-light">
                    <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                </button>
            </form>
        </div>
    </header>
    <main class="container my-5">
        <div class="row g-4">

            <!-- Card Usuarios -->
            <div class="col-md-6">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <i class="bi bi-tools" style="font-size:3rem;"></i>
                        <h5 class="card-title mt-3">Agregar Herramientas</h5>
                        <a href="add_tool.php" class="btn btn-primary">
                            <i class="bi bi-plus-circle-fill"></i> Agregar
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card ir al index.php -->
            <div class="col-md-6">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <i class="bi bi-tags-fill" style="font-size:3rem;"></i>
                        <h5 class="card-title mt-3">Ir a la interfaz</h5>
                        <a href="#" class="btn btn-primary"
                            onclick="window.open('../../index.php', '', 'width=2000%,height=1000%,toolbar=NO'); return false;">
                            <i class="bi bi-pencil-square"></i> Abrir
                        </a>
                    </div>
                </div>
            </div>



            <!-- Card Tipos de Usuarios -->
            <div class="col-md-6">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <i class="bi bi-pencil-square" style="font-size:3rem;"></i>
                        <h5 class="card-title mt-3">Editar Herramientas</h5>
                        <a href="edit_tool.php" class="btn btn-primary">
                            <i class="bi bi-gear-wide"></i> Gestionar
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card Ventas -->
            <div class="col-md-6">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <i class="bi bi-cart-fill" style="font-size:3rem;"></i>
                        <h5 class="card-title mt-3">Ventas</h5>
                        <a href="../Administrador/sales.php" class="btn btn-primary">
                            <i class="bi bi-graph-up-arrow"></i> Gestionar
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card Detalle de Ventas -->
            <div class="col-md-6">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <i class="bi bi-file-earmark-text" style="font-size:3rem;"></i>
                        <h5 class="card-title mt-3">Detalle de Ventas</h5>
                        <a href="../Administrador/detail_sales.php" class="btn btn-primary">
                            <i class="bi bi-receipt"></i> Gestionar
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card Usuarios -->
            <div class="col-md-6">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <i class="bi bi-people-fill" style="font-size:3rem;"></i>
                        <h5 class="card-title mt-3">Usuarios</h5>
                        <a href="../Administrador/usuarios.php" class="btn btn-primary">
                            <i class="bi bi-people"></i> Gestionar
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card Reportes -->
            <div class="col-md-6">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <i class="bi bi-file-earmark-text" style="font-size:3rem;"></i>
                        <h5 class="card-title mt-3">Reportes de ventas</h5>
                        <a href="../../ventas.php" class="btn btn-primary">
                            <i class="bi bi-file-earmark-text"></i> Gestionar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>