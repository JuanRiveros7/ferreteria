<?php
session_start();
require_once("database/conexion.php");
$db = new Database;
$con = $db->conectar();

if (isset($_POST['inicio'])) {
    $usuario    = $_POST["usuario"] ?? '';
    $contrasena = $_POST["contrasena"] ?? '';

    if ($usuario === "" || $contrasena === "") {
        echo '<script>alert("Por favor ingrese usuario y contraseña");</script>';
        echo '<script>window.location="index.php"</script>';
        exit();
    }

    // Buscar el usuario en la base de datos
    $sql = $con->prepare("
    SELECT u.*, r.nombre_rol
    FROM usuarios u
    INNER JOIN roles r ON u.id_rol = r.id_rol
    WHERE u.usuario = ?
    ");

    $sql->execute([$usuario]);
    $fila = $sql->fetch(PDO::FETCH_ASSOC);

    // Validar si existe y si la contraseña coincide
    if ($fila && password_verify($contrasena, $fila['contrasena'])) {
        $_SESSION['usuario'] = $fila['usuario'];
        $_SESSION['nombre'] = $fila['nombre'];
        $_SESSION['doc'] = $fila['documento'];
        $_SESSION['rol'] = $fila['nombre_rol'];
        header("Location: panel.php");
        exit();
    } else {
        echo '<script>alert("Usuario o contraseña incorrectos");</script>';
        echo '<script>window.location="index.php"</script>';
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Formulario Inicio Sesión | CAEC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style_index.php.css">
</head>

<body onload="form1.usuario.focus()" class="Administrador d-flex align-items-center justify-content-center vh-100 bg-light">

    <div class="login-box card shadow-lg p-4 border-0 rounded-4" style="max-width: 400px; width: 100%;">
        <div class="text-center mb-3">
            <img src="img/Logo_ferreteria.png" class="avatar rounded-circle mb-3" alt="Avatar Image" style="width: 100px; height: 100px; object-fit: cover;">
            <h1 class="h4 fw-bold text-primary"><i class="bi bi-box-arrow-in-right me-2"></i>Inicio de Sesión</h1>
        </div>

        <form method="POST" name="form1" id="form1" action="controller/inicio.php" autocomplete="off">

            <div class="mb-3">
                <label for="usuario" class="form-label fw-semibold"><i class="bi bi-person-fill me-1"></i> Usuario</label>
                <input type="text" name="usuario" id="usuario" placeholder="Digite Usuario" class="form-control rounded-pill">
            </div>

            <div class="mb-3">
                <label for="contrasena" class="form-label fw-semibold"><i class="bi bi-lock-fill me-1"></i> Contraseña</label>
                <input type="password" name="contrasena" id="contrasena" placeholder="Ingrese Contraseña" class="form-control rounded-pill">
            </div>

            <div class="d-grid gap-2 mb-3">
                <button type="submit" name="inicio" id="inicio" class="btn btn-primary rounded-pill">
                    <i class="bi bi-check-circle-fill me-1"></i> Confirmar
                </button>
            </div>

            <div class="text-center">
                <a href="recordarcontra.php" class="d-block text-decoration-none mb-1"><i class="bi bi-key-fill me-1"></i> Recordar Contraseña?</a>
                <a href="registrarme.php" class="d-block text-decoration-none"><i class="bi bi-person-plus-fill me-1"></i> Registrarme?</a>
            </div>

        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>   