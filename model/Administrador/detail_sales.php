<?php
require_once("../../database/conexion.php");

if (!isset($_GET['id'])) {
    die("Error: No se especificó una venta.");
}

$idVenta = $_GET['id'];

$db = new Database();
$pdo = $db->conectar();

// Consulta para traer los detalles de la venta
$sql = "SELECT p.nombre AS producto, d.cantidad, d.precio_unitario, 
               (d.cantidad * d.precio_unitario) AS subtotal
        FROM detalle_ventas d
        INNER JOIN productos p ON d.id_producto = p.id_producto
        WHERE d.id_venta = :idVenta";

$stmt = $pdo->prepare($sql);
$stmt->execute(['idVenta' => $idVenta]);
$detalles = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Consulta para mostrar la info general de la venta
$sqlVenta = "SELECT v.id_venta, v.fecha_venta, v.total, u.nombre AS cliente
             FROM ventas v
             INNER JOIN usuarios u ON v.documento = u.documento
             WHERE v.id_venta = :idVenta";

$stmtVenta = $pdo->prepare($sqlVenta);
$stmtVenta->execute(['idVenta' => $idVenta]);
$venta = $stmtVenta->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Detalle de Venta</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">
    <header class="bg-primary text-white py-3 shadow">
        <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <img src="../../img/Logo_ferreteria.png" alt="logo" class="me-3" style="width:60px; height:60px;">
                <h4 class="mb-0">Detalle de Venta</h4>
            </div>
            <a href="sales.php" class="btn btn-outline-light text-decoration-none text-white">
                <i class="bi bi-arrow-left-circle"></i> Volver
            </a>
        </div>
    </header>
    <div class="container mt-4">
        <div class="card shadow-lg">
            <div class="card-body">
                <h4 class="card-title text-primary">Venta #<?php echo $venta['id_venta']; ?></h4>
                <p class="mb-1"><strong>Cliente:</strong> <?php echo $venta['cliente']; ?></p>
                <p class="mb-1"><strong>Fecha:</strong> <?php echo $venta['fecha_venta']; ?></p>
                <p class="mb-3"><strong>Total:</strong> <span class="text-success fw-bold">$<?php echo number_format($venta['total'], 2); ?></span></p>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped align-middle">
                        <thead class="table-dark text-center">
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio Unitario</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php if (!empty($detalles)): ?>
                                <?php foreach ($detalles as $detalle): ?>
                                    <tr>
                                        <td><?= $detalle['producto'] ?></td>
                                        <td><?= $detalle['cantidad'] ?></td>
                                        <td>$<?= number_format($detalle['precio_unitario'], 2) ?></td>
                                        <td>$<?= number_format($detalle['subtotal'], 2) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-muted">No hay productos en esta venta</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-3 text-end">
                    <a href="sales.php" class="btn btn-secondary">
                        <i class="bi bi-box-arrow-left"></i> Regresar al Historial
                    </a>
                </div>
            </div>
        </div>
    </div>

</body>

</html>