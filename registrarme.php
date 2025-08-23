<?php
session_start();
require_once("database/conexion.php");
$db = new Database;
$con = $db->conectar();

if (isset($_POST['registrar'])) {
    $doc   = $_POST["documento"] ?? '';
    $name_user     = $_POST["nombre"] ?? '';
    $usuario     = $_POST["usuario"] ?? '';
    $correo      = $_POST["correo"] ?? '';
    $contrasena  = $_POST["contrasena"] ?? '';
    $id_rol      = $_POST["id_rol"] ?? '';

    if ($doc === "" || $name_user === "" || $usuario === "" || $correo === "" || $contrasena === "" || $id_rol === "") {
        echo '<script>alert("DATOS VACÍOS, POR FAVOR DILIGENCIE TODOS LOS CAMPOS");</script>';
        echo '<script>window.location="index.html"</script>';
        exit();
    }

    $sql = $con->prepare("SELECT * FROM usuarios WHERE usuario = ? OR documento = ?");
    $sql->execute([$usuario, $doc]);
    $fila = $sql->fetchAll(PDO::FETCH_ASSOC);

    if ($fila) {
        echo '<script>alert("El usuario o documento ya existe");</script>';
        echo '<script>window.location="index.html"</script>';
        exit();
    }

    $pass_cifrado = password_hash($contrasena, PASSWORD_DEFAULT, array("pass" => 12));

    $insertSQL = $con->prepare("INSERT INTO usuarios(documento, nombre, usuario, email, contrasena, id_rol)
                                VALUES (?, ?, ?, ?, ?, ?)");
    $insertSQL->execute([$doc, $name_user, $usuario, $correo, $pass_cifrado, $id_rol]);

    echo '<script>alert("Registro exitoso");</script>';
    echo '<script>window.location="login.php"</script>';
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Registro de Usuario | CAEC</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6">
                <div class="card shadow-lg border-0 rounded-4 p-4">
                    <div class="text-center mb-3">
                        <img src="img/logo_registrarme_ferreteria.png" class="rounded-circle mb-3 img-fluid" alt="Logo" style="width: 100px; height: 100px; object-fit: cover;">
                        <h1 class="h5 fw-bold text-primary"><i class="bi bi-person-plus-fill me-2"></i>Registro de Usuario</h1>
                    </div>

                    <form method="POST" autocomplete="off">
                        <div class="mb-3">
                            <label for="usuario" class="form-label fw-semibold"><i class="bi bi-person-fill me-1"></i> Usuario</label>
                            <input type="text" name="usuario" id="usuario" class="form-control rounded-pill" placeholder="Digite Usuario">
                        </div>

                        <div class="mb-3">
                            <label for="nombre" class="form-label fw-semibold"><i class="bi bi-person-badge-fill me-1"></i> Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control rounded-pill" placeholder="Digite Nombre Completo">
                        </div>

                        <div class="mb-3">
                            <label for="documento" class="form-label fw-semibold"><i class="bi bi-file-earmark-text-fill me-1"></i> Documento</label>
                            <input type="number" name="documento" id="documento" class="form-control rounded-pill" placeholder="Ingrese Documento">
                        </div>

                        <div class="mb-3">
                            <label for="correo" class="form-label fw-semibold"><i class="bi bi-envelope-fill me-1"></i> Correo</label>
                            <input type="email" name="correo" id="correo" class="form-control rounded-pill" placeholder="Ingrese Correo">
                        </div>

                        <div class="mb-3">
                            <label for="contrasena" class="form-label fw-semibold"><i class="bi bi-lock-fill me-1"></i> Contraseña</label>
                            <input type="password" name="contrasena" id="contrasena" class="form-control rounded-pill" placeholder="Digite Contraseña">
                        </div>

                        <div class="mb-3">
                            <label for="id_rol" class="form-label fw-semibold"><i class="bi bi-person-fill me-1"></i> Rol</label>
                            <select name="id_rol" id="id_rol" class="form-select rounded-pill">
                                <option value="">Seleccione Rol</option>
                                <?php
                                $control = $con->prepare("SELECT * FROM roles WHERE id_rol = 2");
                                $control->execute();
                                while ($tp = $control->fetch(PDO::FETCH_ASSOC)) {
                                    echo '<option value="' . $tp['id_rol'] . '">' . $tp['nombre_rol'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="d-grid gap-2 mb-3">
                            <button type="submit" name="registrar" id="registrar" class="btn btn-primary rounded-pill">
                                <i class="bi bi-check-circle-fill me-1"></i> Confirmar
                            </button>
                        </div>

                        <div class="text-center">
                            <a href="login.php" class="d-block text-decoration-none"><i class="bi bi-person-plus-fill me-1"></i> ¿Logearme?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>