<?php
session_start();
require_once("database/conexion.php");
$db = new Database;
$con = $db->conectar();

if (isset($_POST['validar'])) {
    $usuario = $_POST["usuario"];
    $doc = $_POST["documento"];

    if (empty($usuario) || empty($doc)) {
        echo '<script>alert("Llena los campos");</script>';
    } else {
        $sql = $con->prepare("SELECT * FROM usuarios WHERE usuario = ? AND documento = ?");
        $sql->execute([$usuario, $doc]);
        $fila = $sql->fetch(PDO::FETCH_ASSOC);

        if ($fila) {
            $token = bin2hex(random_bytes(16)); // Token aleatorio seguro
            $expira = date("Y-m-d H:i:s", strtotime("+1 hour")); // expira en 1 hora

            // Guardar token en la BD
            $update = $con->prepare("UPDATE usuarios SET token_recuperacion=?, token_expira=? WHERE documento=?");
            $update->execute([$token, $expira, $fila['documento']]);

            // Enviar correo con link
            $to = $fila['email'];
            $subject = "Recuperar contraseña";
            $headers = "From: no-reply@tusitio.com\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
            $link = "http://localhost/ferreteria/nuevacontrasena.php?token=$token";
            $message = "<p>Hola <b>{$fila['usuario']}</b>,</p>";
            $message .= "<p>Haz clic en el siguiente enlace para restablecer tu contraseña:</p>";
            $message .= "<p><a href='$link'>$link</a></p>";
            $message .= "<p>Este enlace expira en 1 hora.</p>";

            if (mail($to, $subject, $message, $headers)) {
                echo "<script>alert('Se ha enviado un correo con instrucciones para recuperar la contraseña');</script>";
            } else {
                echo "<script>alert('Error al enviar el correo');</script>";
            }
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