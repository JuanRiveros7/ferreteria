<?php
session_start();
require_once("../database/conexion.php");
$db = new Database;
$con = $db->conectar();

if (isset($_POST['inicio'])) {
    $usuario    = $_POST["usuario"] ?? '';
    $contrasena = $_POST["contrasena"] ?? '';

    if ($usuario === "" || $contrasena === "") {
        echo '<script>alert("Por favor ingrese usuario y contraseña");</script>';
        echo '<script>window.location="../login.php"</script>';
        exit();
    }

    $sql = $con->prepare("SELECT u.*, r.nombre_rol
    FROM usuarios u
    INNER JOIN roles r ON u.id_rol = r.id_rol
    WHERE u.usuario = ?
");
    $sql->execute([$usuario]);
    $fila = $sql->fetch(PDO::FETCH_ASSOC);

    if ($fila && password_verify($contrasena, $fila['contrasena'])) {
        $_SESSION['usuario'] = $fila['usuario'];
        $_SESSION['name_user'] = $fila['nombre'];
        $_SESSION['rol'] = $fila['id_rol'];
        $_SESSION['rol'] = $fila['nombre_rol'];


        switch ($fila['id_rol']) {
            case 1: // Administrador
                header("Location: ../model/Administrador/indexadmin.php");
                break;
            case 2: // Empleado
                header("Location: ../model/Vendedor/indexvendedor.php");
                break;
            case 3: // Usuario
                header("location: ../index.php");
                break;
            default:
                header("Location: ../index.php"); // Vista general o error
                break;
        }
        exit();
    } else {
        echo '<script>alert("Usuario o contraseña incorrectos");</script>';
        echo '<script>window.location="../login.php"</script>';
        exit();
    }
}
?>