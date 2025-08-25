<?php
session_start();
require_once("../../database/conexion.php");
$db = new Database;
$con = $db->conectar();

//obtiene las categorías para el select
$sql = $con->prepare("SELECT * FROM categorias");
$sql->execute();
$categorias = $sql->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['guardar'])) {
    $nombre_producto = trim($_POST['nombre_producto']);
    $descripcion = trim($_POST['descripcion']);
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $categoria_existente = $_POST['id_categoria'];
    $nueva_categoria = trim($_POST['nueva_categoria']);

    //determina la categoría por la id_categoria
    if (!empty($nueva_categoria)) {
        $sqlCheck = $con->prepare("SELECT id_categoria FROM categorias WHERE nombre_categoria = ?");
        $sqlCheck->execute([$nueva_categoria]);
        $cat = $sqlCheck->fetch(PDO::FETCH_ASSOC);

        if ($cat) {
            $id_categoria = $cat['id_categoria'];
        } else {
            //inserta nueva categoría
            $insert_cat = $con->prepare("INSERT INTO categorias (nombre_categoria) VALUES (?)");
            $insert_cat->execute([$nueva_categoria]);
            $id_categoria = $con->lastInsertId();
        }
    } else {
        $id_categoria = $categoria_existente;
    }

    if (empty($id_categoria)) {
        echo '<script>alert("Debe seleccionar o crear una categoría."); window.history.back();</script>';
        exit;
    }

    //inserta producto
    $insert_prod = $con->prepare("INSERT INTO productos (nombre_producto, descripcion, precio, stock, id_categoria) VALUES (?, ?, ?, ?, ?)");
    $insert_prod->execute([$nombre_producto, $descripcion, $precio, $stock, $id_categoria]);

    echo '<script>alert("Herramienta registrada con éxito"); window.location="lista_productos.php";</script>';
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Herramienta</title>
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
                <a href="indexadmin.php" class="btn btn-outline-light text-decoration-none text-white">
                    <i class="bi bi-box-arrow-right"></i> Regresar
                </a>
            </div>
        </header>
    </div>

    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Agregar Nueva Herramienta / Material</h4>
            </div>
            <div class="card-body">
                <form method="POST" autocomplete="off">
                    <div class="mb-3">
                        <label class="form-label">Nombre de la Herramienta / Material</label>
                        <input type="text" name="nombre_producto" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Precio</label>
                        <input type="number" step="0.01" name="precio" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stock</label>
                        <input type="number" name="stock" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Categoría Existente</label>
                        <select name="id_categoria" class="form-select">
                            <option value="">Seleccione una categoría</option>
                            <?php foreach ($categorias as $cat): ?>
                                <option value="<?= $cat['id_categoria'] ?>"><?= htmlspecialchars($cat['nombre_categoria']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">O Crear Nueva Categoría</label>
                        <input type="text" name="nueva_categoria" class="form-control" placeholder="Ingrese nueva categoría">
                    </div>
                    <div class="text-end">
                        <button type="submit" name="guardar" class="btn btn-success">Guardar</button>
                        <a href="indexadmin.php" class="btn btn-secondary">Regresar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>