<?php
session_start();
require_once("../../database/conexion.php");

$db = new Database();
$con = $db->conectar();

// --- Mostrar la lista de usuarios ---
$sql = $con->prepare("
    SELECT u.documento, u.nombre, u.email, u.usuario, r.nombre_rol
    FROM usuarios u
    INNER JOIN roles r ON u.id_rol = r.id_rol
");
$sql->execute();
$usuarios = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-4">

    <h2 class="mb-4">Lista de Usuarios</h2>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Documento</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Usuario</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['documento']) ?></td>
                    <td><?= htmlspecialchars($user['nombre']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['usuario']) ?></td>
                    <td><?= htmlspecialchars($user['nombre_rol']) ?></td>
                    <td>
                        <a href="usuarios.php?documento=<?= urlencode($user['documento']) ?>"
                            class="btn btn-info btn-sm">Ver Detalles</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php
    // --- Si se pasa un documento por GET, mostrar detalle ---
    if (isset($_GET['documento'])) {
        $doc = $_GET['documento'];
        $sqlDetalle = $con->prepare("
            SELECT u.documento, u.nombre, u.usuario, u.email, r.nombre_rol
            FROM usuarios u
            INNER JOIN roles r ON u.id_rol = r.id_rol
            WHERE u.documento = ?
        ");

        $sqlDetalle->execute([$doc]);
        $detalle = $sqlDetalle->fetch(PDO::FETCH_ASSOC);

        if ($detalle):
    ?>
            <div class="card mt-4">
                <div class="card-header bg-primary text-white">Detalles del Usuario</div>
                <div class="card-body">
                    <p><strong>Documento:</strong> <?= htmlspecialchars($detalle['documento']) ?></p>
                    <p><strong>Nombre:</strong> <?= htmlspecialchars($detalle['nombre']) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($detalle['email']) ?></p>
                    <p><strong>Usuario:</strong> <?= htmlspecialchars($detalle['usuario']) ?></p>
                    <p><strong>Rol:</strong> <?= htmlspecialchars($detalle['nombre_rol']) ?></p>
                    <a href="usuarios.php" class="btn btn-secondary">Volver a la lista</a>
                </div>
            </div>
    <?php
        else:
            echo "<div class='alert alert-danger mt-4'>No se encontraron detalles del usuario.</div>";
        endif;
    }
    ?>
</body>

</html>