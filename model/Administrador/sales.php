<?php 
session_start();

// Incluir la clase Database
require_once "../../database/conexion.php";

// Crear instancia y obtener conexión
$db = new Database();
$pdo = $db->conectar(); 

// Consultar ventas con PDO
$sql = "SELECT v.id_venta, v.fecha_venta, v.total, u.nombre AS usuario 
        FROM ventas v
        INNER JOIN usuarios u ON v.documento = u.documento
        ORDER BY v.fecha_venta DESC";
$stmt = $pdo->query($sql);
$ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Ventas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<div>
    <!-- HEADER -->
    <header class="bg-primary text-white py-3 shadow">
        <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <img src="../../controller/image/avatar.png" alt="logo" class="me-3" style="width:60px; height:60px;">
                <h4 class="mb-0">Bienvenido</h4>
            </div>
            <a href="indexadmin.php" class="btn btn-outline-light text-decoration-none text-white">
                <i class="bi bi-box-arrow-left"></i> Regresar
            </a>
        </div>
    </header>
</div>

<body class="bg-light">

<div class="container mt-4">
    <h2 class="mb-4 text-dark">Historial de Ventas</h2>

    <table class="table table-bordered table-hover table-striped align-middle">
        <thead class="table-dark text-center">
            <tr>
                <th>ID Venta</th>
                <th>Fecha</th>
                <th>Total</th>
                <th>Usuario</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <?php if (!empty($ventas)): ?>
                <?php foreach ($ventas as $row): ?>
                    <tr>
                        <td><?= $row['id_venta'] ?></td>
                        <td><?= $row['fecha_venta'] ?></td>
                        <td>$<?= number_format($row['total'], 0, ',', '.') ?></td>
                        <td><?= $row['usuario'] ?></td>
                        <td>
                            <a href="detail_sales.php?id=<?= $row['id_venta'] ?>" 
                               class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i> Ver Detalle
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center text-muted">No hay ventas registradas</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>