<?php
session_start();
require_once("database/connection.php");
$db = new Database;
$con = $db->conectar();


if (!isset($_SESSION['doc'])) {
    echo '<script>alert("Acceso no autorizado.");</script>';
    echo '<script>window.location="recordarcontra.php";</script>';
    exit();
}

$doc = $_SESSION['doc'];


if (isset($_POST['validar'])) {
    $contrasena = $_POST["password1"];
    $confirmar_contrasena = $_POST["password2"];


    if (empty($contrasena) || empty($confirmar_contrasena)) {
        echo '<script>alert ("llena Los Campos");</script>';
    } elseif ($contrasena !== $confirmar_contrasena) {
        echo '<script>alert ("Las contraseñas no coinciden");</script>';
        echo '<script>window.location="nueva_contraseña.php";</script>';
        exit();
    } else {
        $pass_cifrado = password_hash($contrasena, PASSWORD_DEFAULT);

        $sql = $con->prepare("UPDATE usuarios SET contrasena = ? WHERE documento = ?");
        $sql->execute([$pass_cifrado, $doc]);

        unset($_SESSION['doc']);
        echo '<script>alert("Contraseña actualizada con éxito.");</script>';
        echo '<script>window.location="index.html";</script>';
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Formulario Inicio Sesion | CAEC</title>
    <link rel="stylesheet" href="controller/css/style.css">
</head>

<body onload="form1.usuario.focus()" class="instructor">
    <div class="login-box">
        <img src="controller/image/logo.png" class="avatar" alt="Avatar Image">
        <h1>RECUPERAR CONTRASEÑA</h1>
        <form method="POST" name="select" id="select" autocomplete="off">
            <label for="usuario">NUEVA CONTRASEÑA</label>
            <input type="password" name="password1" id="password" placeholder="Digite Tu Nueva Contraseña">

            <label for="usuario">CONFIRMAR CONTRASEÑA</label>
            <input type="password" name="password2" id="password" placeholder="Digite Tu Nueva Contraseña">

            <input type="submit" name="validar" value="Validar">
        </form>
    </div>
</body>

</html>