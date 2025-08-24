<?php
session_start();
require_once("../../database/conexion.php");
$db = new Database;
$con = $db->conectar();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$sqlVentas = $con->prepare(" SELECT v.id_venta, v.fecha_venta, v.total, c.nombre_completo AS cliente, c.documento AS doc_cliente
    FROM ventas v
    INNER JOIN clientes c ON v.documento_cliente = c.documento
    ORDER BY v.fecha_venta DESC
");
$sqlVentas->execute();
$ventas = $sqlVentas->fetchAll(PDO::FETCH_ASSOC);

$sqlDetalles = $con->prepare('SELECT d.id_venta, p.nombre_producto AS producto, d.cantidad, d.precio_unitario
    FROM detalle_venta d
    INNER JOIN productos p ON d.id_producto = p.id_producto
    ORDER BY d.id_venta
');
$sqlDetalles->execute();
$detalles = $sqlDetalles->fetchAll(PDO::FETCH_ASSOC);
$detallePorVenta = [];
foreach ($detalles as $d) {
    $detallePorVenta[$d['id_venta']][] = $d;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro de Ventas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div>
        <header class="bg-primary text-white py-3 shadow">
            <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <img src="../../img/Logo_ferreteria.png" alt="logo" class="me-3" style="width:60px; height:60px;">
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

    <div class="container mt-4">
        <h2 class="mb-4">Historial de Ventas</h2>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID Venta</th>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Total</th>
                    <th>Detalles</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ventas as $venta): ?>
                    <tr>
                        <td><?= $venta['id_venta'] ?></td>
                        <td><?= $venta['fecha_venta'] ?></td>
                        <td><?= $venta['cliente'] ?> (<?= $venta['doc_cliente'] ?>)</td>
                        <td>$<?= number_format($venta['total'], 2) ?></td>
                        <td>
                            <ul>
                                <?php if (isset($detallePorVenta[$venta['id_venta']])): ?>
                                    <?php foreach ($detallePorVenta[$venta['id_venta']] as $det): ?>
                                        <li>
                                            <?= $det['producto'] ?> -
                                            <?= $det['cantidad'] ?> x $<?= number_format($det['precio_unitario'], 2) ?>
                                        </li>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <li><em>Sin productos</em></li>
                                <?php endif; ?>
                            </ul>
                        </td>
                        <td>
                            <a href="vercliente.php?doc=<?= $venta['doc_cliente'] ?>"
                                class="btn btn-info btn-sm">
                                Ver Cliente
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>