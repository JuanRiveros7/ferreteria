<?php
session_start();
require_once("../../database/conexion.php");
$db = new Database;
$con = $db->conectar();

// Consulta productos con su categoría
$sql = "
    SELECT 
        p.id_producto,
        p.nombre_producto,
        p.descripcion,
        p.precio,
        p.stock,
        c.nombre_categoria
    FROM productos p
    JOIN categorias c ON p.id_categoria = c.id_categoria
    ORDER BY p.nombre_producto ASC
";
$stmt = $con->prepare($sql);
$stmt->execute();
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Herramientas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<div>
    <header class="bg-primary text-white py-3 shadow">
        <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <img src="../../controller/image/avatar.png" alt="logo" class="me-3" style="width:60px; height:60px;">
                <h4 class="mb-0">
                    Bienvenido
                </h4>
            </div>
            <a href="indexadmin.php" class="btn btn-outline-light text-decoration-none text-white">
                <i class="bi bi-box-arrow-right"></i> Regresar
            </a>
        </div>
    </header>
</div>

<body class="bg-light">

    <div class="container mt-4">
        <h2 class="mb-4 text-dark">Gestión de Herramientas</h2>

        <table class="table table-bordered table-hover table-striped align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Categoría</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php foreach ($productos as $producto): ?>
                    <tr>
                        <td><?= $producto['id_producto'] ?></td>
                        <td><?= $producto['nombre_producto'] ?></td>
                        <td><?= $producto['descripcion'] ?></td>
                        <td>$<?= number_format($producto['precio'], 2) ?></td>
                        <td><?= $producto['stock'] ?></td>
                        <td><?= $producto['nombre_categoria'] ?></td>
                        <td>
                            <a href="update_tool.php?id=<?= $producto['id_producto'] ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="delete_tool.php?id=<?= $producto['id_producto'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este producto?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>

</html>