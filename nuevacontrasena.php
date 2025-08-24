<?php
session_start();
require_once("database/conexion.php");
$db = new Database;
$con = $db->conectar();

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Verificar token
    $sql = $con->prepare("SELECT * FROM usuarios WHERE token_recuperacion=? AND token_expira > NOW()");
    $sql->execute([$token]);
    $user = $sql->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("Token inválido o expirado.");
    }
} else {
    die("Falta el token.");
}

// Procesar nueva contraseña
if (isset($_POST['cambiar'])) {
    $nueva = $_POST['contrasena'] ?? '';

    if ($nueva === "") {
        echo "<script>alert('Ingrese la nueva contraseña');</script>";
    } else {
        $pass_cifrado = password_hash($nueva, PASSWORD_DEFAULT);

        $update = $con->prepare("UPDATE usuarios SET contrasena=?, token_recuperacion=NULL, token_expira=NULL WHERE documento=?");
        $update->execute([$pass_cifrado, $user['documento']]);

        echo "<script>alert('Contraseña actualizada correctamente'); window.location='login.php';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Nueva Contraseña</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">
  <div class="card shadow-lg border-0 rounded-4 p-4" style="max-width:400px;width:100%;">
    <h1 class="h5 fw-bold text-primary mb-3">Restablecer Contraseña</h1>
    <form method="POST">
      <div class="mb-3">
        <label for="contrasena" class="form-label">Nueva Contraseña</label>
        <input type="password" name="contrasena" id="contrasena" class="form-control rounded-pill" placeholder="Ingrese nueva contraseña">
      </div>
      <div class="d-grid">
        <button type="submit" name="cambiar" class="btn btn-primary rounded-pill">Cambiar Contraseña</button>
      </div>
    </form>
  </div>
</body>
</html>