<?php
session_start();
require_once("../../database/conexion.php");
$db = new Database;
$con = $db->conectar();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['doc'])) {
    echo "Cliente no especificado.";
    exit();
}

$doc = $_GET['doc'];

$sql = $con->prepare("SELECT * FROM clientes WHERE documento = ?");
$sql->execute([$doc]);
$cliente = $sql->fetch(PDO::FETCH_ASSOC);

if (!$cliente) {
    echo "Cliente no encontrado.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Detalle del Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div>
        <header class="bg-primary text-white py-3 shadow">
            <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <img src="../../img/Logo_ferreteria.png" alt="logo" class="me-3" style="width:60px; height:60px;">
                    <h4 class="mb-0">
                        Bienvenido a la informacion de tu cliente
                    </h4>
                </div>
            </div>
        </header>
    </div>

    <div class="container mt-4">
        <div class="card shadow p-4">
            <h3 class="mb-3 text-primary">Información del Cliente</h3>
            <ul class="list-group">
                <li class="list-group-item"><strong>Documento:</strong> <?= $cliente['documento'] ?></li>
                <li class="list-group-item"><strong>Nombre:</strong> <?= $cliente['nombre_completo'] ?></li>
                <li class="list-group-item"><strong>Teléfono:</strong> <?= $cliente['telefono'] ?></li>
                <li class="list-group-item"><strong>Email:</strong> <?= $cliente['email'] ?></li>
                <li class="list-group-item"><strong>Dirección:</strong> <?= $cliente['direccion'] ?></li>
                <li class="list-group-item"><strong>Fecha Registro:</strong> <?= $cliente['fecha_registro'] ?></li>
            </ul>
            <div class="mt-3">
                <a href="ventas.php" class="btn btn-secondary">Regresar</a>
            </div>
        </div>
    </div>
</body>

</html>