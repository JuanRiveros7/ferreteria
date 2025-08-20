<?php
session_start();
require_once("database/conexion.php");
$db = new Database;
$con = $db->conectar();

if (isset($_POST['validar'])) {

    $usuario = $_POST["usuario"];
    $doc = $_POST["documento"];

    if (empty($usuario) || empty($doc)) {
        echo '<script>alert ("Llena los campos");</script>';
    } else {
        $sql = $con->prepare("SELECT * FROM user WHERE user = ? AND documento = ?");
        $sql->execute([$usuario, $doc]);
        $fila = $sql->fetchAll(mode: PDO::FETCH_ASSOC);

        if ($fila) {
            $_SESSION['documento'] = $documento;
            header("location:nueva_contraseña.php");
            exit();
        } else {
            echo '<script>alert ("Usuario o Documento Incorrecto");</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Formulario Recuperar Contraseña | CAEC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center justify-content-center vh-100">

    <div class="card shadow-lg border-0 rounded-4 p-4" style="max-width: 400px; width: 100%;">
        <div class="text-center mb-3">
            <img src="img/logo_recuperar_ferreteria.png" class="rounded-circle mb-3" alt="Logo" style="width: 100px; height: 100px; object-fit: cover;">
            <h1 class="h5 fw-bold text-primary"><i class="bi bi-shield-lock-fill me-2"></i>Recuperar Contraseña</h1>
        </div>

        <form method="POST" autocomplete="off">
            <div class="mb-3">
                <label for="usuario" class="form-label fw-semibold"><i class="bi bi-person-fill me-1"></i> Usuario</label>
                <input type="text" name="usuario" id="usuario" class="form-control rounded-pill" placeholder="Digite Usuario">
            </div>

            <div class="mb-3">
                <label for="documento" class="form-label fw-semibold"><i class="bi bi-file-earmark-text-fill me-1"></i> Documento</label>
                <input type="number" name="documento" id="documento" class="form-control rounded-pill" placeholder="Ingrese Documento">
            </div>

            <div class="d-grid">
                <button type="submit" name="validar" class="btn btn-primary rounded-pill">
                    <i class="bi bi-check-circle-fill me-1"></i> Validar
                </button>
            </div>

            <div class="text-center">
                <a href="login.php" class="d-block text-decoration-none"><i class="bi bi-person-plus-fill me-1"></i> logearme?</a>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>