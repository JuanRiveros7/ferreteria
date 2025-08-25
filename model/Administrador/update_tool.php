<?php
session_start();
require_once("../../database/conexion.php");
$db = new Database;
$con = $db->conectar();

// Verificar si tiene un ID
if (!isset($_GET['id'])) {
    header("Location: edit_tool.php");
    exit;
}

$id = $_GET['id'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre_producto'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $id_categoria = $_POST['id_categoria'];

    $sql = "UPDATE productos 
            SET nombre_producto = ?, descripcion = ?, precio = ?, stock = ?, id_categoria = ? 
            WHERE id_producto = ?";
    $stmt = $con->prepare($sql);
    $stmt->execute([$nombre, $descripcion, $precio, $stock, $id_categoria, $id]);

    header("Location: edit_tool.php");
    exit;
}

$sql = "SELECT * FROM productos WHERE id_producto = ?";
$stmt = $con->prepare($sql);
$stmt->execute([$id]);
$producto = $stmt->fetch(PDO::FETCH_ASSOC);

$sqlCat = "SELECT * FROM categorias ORDER BY nombre_categoria ASC";
$stmtCat = $con->prepare($sqlCat);
$stmtCat->execute();
$categorias = $stmtCat->fetchAll(PDO::FETCH_ASSOC);

if (!$producto) {
    echo "Producto no encontrado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div>
        <header class="bg-primary text-white py-3 shadow">
            <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <img src="../../img/Logo_ferreteria.png" alt="logo" class="me-3" style="width:60px; height:60px;">
                    <h4 class="mb-0">
                        Bienvenido
                    </h4>
                </div>
            </div>
        </header>
    </div>
    <div class="container mt-5">
        <h2>Editar Herramienta</h2>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre_producto" class="form-control" value="<?= $producto['nombre_producto'] ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control" required><?= $producto['descripcion'] ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Precio</label>
                <input type="number" step="0.01" name="precio" class="form-control" value="<?= $producto['precio'] ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Stock</label>
                <input type="number" name="stock" class="form-control" value="<?= $producto['stock'] ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Categoría</label>
                <select name="id_categoria" class="form-select" required>
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?= $categoria['id_categoria'] ?>" 
                            <?= $producto['id_categoria'] == $categoria['id_categoria'] ? 'selected' : '' ?>>
                            <?= $categoria['nombre_categoria'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Guardar Cambios</button>
            <a href="edit_tool.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>

</html>