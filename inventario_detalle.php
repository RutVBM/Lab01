<?php
include("header.php");

$sAccion = "";
if (isset($_GET["sAccion"])) {
    $sAccion = $_GET["sAccion"]; // new / edit
} elseif (isset($_POST["sAccion"])) {
    $sAccion = $_POST["sAccion"]; // insert / update
}

// Definir valores por defecto para la creación de un nuevo registro
if ($sAccion == "new") {
    $sTitulo = "Registrar un nuevo material o producto";
    $sSubTitulo = "Por favor, ingresar la información del material o producto [(*) datos obligatorio]:";
    $sCambioAccion = "insert";
    $id_inventario = "";
    $nombre_material_producto = "";
    $tipo = "Producto";
    $descripcion = "";
    $cantidad = 0;
    $stock_minimo = 0;
    $precio_unitario = 0;
    $id_proveedor = "";
    $estado = "Activo";
} elseif ($sAccion == "edit" && isset($_GET["id_inventario"])) {
    $sTitulo = "Modificar los datos del material o producto";
    $sSubTitulo = "Por favor, actualizar la información del material o producto [(*) datos obligatorio]:";
    $sCambioAccion = "update";
    $id_inventario = $_GET["id_inventario"];
    
    // Cargar los datos del inventario para editar
    $sql = "SELECT * FROM inventario WHERE id_inventario = $id_inventario";
    $result = dbQuery($sql);
    if ($row = mysqli_fetch_array($result)) {
        $nombre_material_producto = $row["nombre_material_producto"];
        $tipo = $row["tipo"];
        $descripcion = $row["descripcion"];
        $cantidad = $row["cantidad"];
        $stock_minimo = $row["stock_minimo"];
        $precio_unitario = $row["precio_unitario"];
        $id_proveedor = $row["id_proveedor"];
        $estado = $row["estado"];
    }
} elseif ($sAccion == "insert") {
    // Insertar un nuevo registro
    $nombre_material_producto = $_POST["nombre_material_producto"];
    $tipo = $_POST["tipo"];
    $descripcion = $_POST["descripcion"];
    $cantidad = $_POST["cantidad"];
    $stock_minimo = $_POST["stock_minimo"];
    $precio_unitario = $_POST["precio_unitario"];
    $id_proveedor = $_POST["id_proveedor"];
    $estado = $_POST["estado"];
    
    $sql = "INSERT INTO inventario (nombre_material_producto, tipo, descripcion, cantidad, stock_minimo, precio_unitario, id_proveedor, estado, fecha_registro)
            VALUES ('$nombre_material_producto', '$tipo', '$descripcion', $cantidad, $stock_minimo, $precio_unitario, $id_proveedor, '$estado', NOW())";
    dbQuery($sql);
    header("Location: inventario.php?mensaje=1");
} elseif ($sAccion == "update") {
    // Actualizar el registro existente
    $id_inventario = $_POST["id_inventario"];
    $nombre_material_producto = $_POST["nombre_material_producto"];
    $tipo = $_POST["tipo"];
    $descripcion = $_POST["descripcion"];
    $cantidad = $_POST["cantidad"];
    $stock_minimo = $_POST["stock_minimo"];
    $precio_unitario = $_POST["precio_unitario"];
    $id_proveedor = $_POST["id_proveedor"];
    $estado = $_POST["estado"];
    
    $sql = "UPDATE inventario SET nombre_material_producto = '$nombre_material_producto', tipo = '$tipo', descripcion = '$descripcion', 
            cantidad = $cantidad, stock_minimo = $stock_minimo, precio_unitario = $precio_unitario, id_proveedor = $id_proveedor, 
            estado = '$estado' WHERE id_inventario = $id_inventario";
    dbQuery($sql);
    header("Location: inventario.php?mensaje=2");
}

include("sidebar.php");
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?php echo $sTitulo; ?></h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?php echo $sSubTitulo; ?></h3>
            </div>

            <div class="card-body">
                <form action="inventario_detalle.php" method="post">
                    <input type="hidden" name="sAccion" value="<?php echo $sCambioAccion; ?>">
                    <input type="hidden" name="id_inventario" value="<?php echo $id_inventario; ?>">

                    <div class="form-group">
                        <label for="nombre_material_producto">Nombre del Material o Producto (*):</label>
                        <input type="text" name="nombre_material_producto" class="form-control" value="<?php echo $nombre_material_producto; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="tipo">Tipo:</label>
                        <select name="tipo" class="form-control">
                            <option value="Producto" <?php if ($tipo == "Producto") echo "selected"; ?>>Producto</option>
                            <option value="Material" <?php if ($tipo == "Material") echo "selected"; ?>>Material</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Descripción:</label>
                        <textarea name="descripcion" class="form-control"><?php echo $descripcion; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="cantidad">Cantidad (*):</label>
                        <input type="number" name="cantidad" class="form-control" value="<?php echo $cantidad; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="stock_minimo">Stock Mínimo (*):</label>
                        <input type="number" name="stock_minimo" class="form-control" value="<?php echo $stock_minimo; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="precio_unitario">Precio Unitario (*):</label>
                        <input type="number" step="0.01" name="precio_unitario" class="form-control" value="<?php echo $precio_unitario; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="id_proveedor">Proveedor:</label>
                        <select name="id_proveedor" class="form-control">
                            <?php
                            $sqlProveedor = "SELECT id_proveedor, nombre_proveedor FROM proveedor WHERE estado = 'A'";
                            $resultProveedor = dbQuery($sqlProveedor);
                            while ($rowProveedor = mysqli_fetch_array($resultProveedor)) {
                                $selected = ($id_proveedor == $rowProveedor['id_proveedor']) ? "selected" : "";
                                echo "<option value='" . $rowProveedor['id_proveedor'] . "' $selected>" . $rowProveedor['nombre_proveedor'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="estado">Estado:</label>
                        <select name="estado" class="form-control">
                            <option value="Activo" <?php if ($estado == "Activo") echo "selected"; ?>>Activo</option>
                            <option value="Inactivo" <?php if ($estado == "Inactivo") echo "selected"; ?>>Inactivo</option>
                        </select>
                    </div>
                    <a href="compra_insumos.php" class="btn btn-primary">Regresar</a>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </form>
            </div>
        </div>
    </section>
</div>

<?php
include("footer.php");
?>
