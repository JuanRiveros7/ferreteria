<?php
session_start();

// Incluir la clase Database
require_once "../../database/conexion.php";

// Crear instancia y obtener conexión
$db = new Database();
$pdo = $db->conectar(); // ✅ Aquí ya tienes el objeto PDO

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
    <title>Historial de Ventas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <h1 class="mb-4">Historial de Ventas</h1>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID Venta</th>
                <th>Fecha</th>
                <th>Total</th>
                <th>Usuario</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($ventas)): ?>
                <?php foreach ($ventas as $row): ?>
                    <tr>
                        <td><?= $row['id_venta'] ?></td>
                        <td><?= $row['fecha'] ?></td>
                        <td>$<?= number_format($row['total'], 0, ',', '.') ?></td>
                        <td><?= $row['usuario'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">No hay ventas registradas</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>