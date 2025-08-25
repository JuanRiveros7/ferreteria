<?php
session_start();
require_once("../../database/conexion.php");

$db = new Database();
$con = $db->conectar();

$mensaje = "";

// --- CREAR USUARIO ---
if (isset($_POST['crear'])) {
    $documento = trim($_POST['documento']);
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $usuario = trim($_POST['usuario']);
    $contrasena = $_POST['contrasena'];
    $id_rol = $_POST['id_rol'];

    // Validaciones
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensaje = "<div class='alert alert-danger'>El email no es válido.</div>";
    } else {
        $check = $con->prepare("SELECT COUNT(*) FROM usuarios WHERE documento = ? OR usuario = ?");
        $check->execute([$documento, $usuario]);
        $existe = $check->fetchColumn();

        if ($existe > 0) {
            $mensaje = "<div class='alert alert-warning'>El documento o usuario ya existen.</div>";
        } else {
            $contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);

            try {
                $insert = $con->prepare("INSERT INTO usuarios 
                    (documento, nombre, email, usuario, contrasena, id_rol) 
                    VALUES (?, ?, ?, ?, ?, ?)");
                $insert->execute([$documento, $nombre, $email, $usuario, $contrasenaHash, $id_rol]);

                header("Location: usuarios.php?ok=1");
                exit();
            } catch (PDOException $e) {
                $mensaje = "<div class='alert alert-danger'>Error al insertar: " . htmlspecialchars($e->getMessage()) . "</div>";
            }
        }
    }
}

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <header class="bg-primary text-white py-3 shadow">
        <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <img src="../../img/Logo_ferreteria.png" alt="logo" class="me-3" style="width:60px; height:60px;">
                <h4 class="mb-0">Gestión de Usuarios</h4>
            </div>
            <a href="indexadmin.php" class="btn btn-outline-light text-decoration-none text-white">
                <i class="bi bi-box-arrow-right"></i> Regresar
            </a>
        </div>
    </header>

    <div class="container mt-5">
        <?= $mensaje ?>
        <?php if (isset($_GET['ok'])): ?>
            <div class="alert alert-success">Usuario creado exitosamente.</div>
        <?php endif; ?>

        <!-- Card formulario -->
        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Agregar Usuario</h4>
            </div>
            <div class="card-body">
                <form method="POST" autocomplete="off" class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Documento</label>
                        <input type="text" name="documento" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Usuario</label>
                        <input type="text" name="usuario" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="contrasena" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Rol</label>
                        <select name="id_rol" class="form-select" required>
                            <option value="">Seleccionar Rol</option>
                            <?php
                            $roles = $con->query("SELECT id_rol, nombre_rol FROM roles")->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($roles as $rol) {
                                echo "<option value='{$rol['id_rol']}'>{$rol['nombre_rol']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="text-end mt-3">
                        <button type="submit" name="crear" class="btn btn-success">Añadir Usuario</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Card lista usuarios -->
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Lista de Usuarios</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
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
                                    <a href="usuarios.php?documento=<?= urlencode($user['documento']) ?>" class="btn btn-info btn-sm">Ver Detalles</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Card detalle usuario -->
        <?php
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
                <div class="card shadow mt-4">
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>