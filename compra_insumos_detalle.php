<?php
include ("header.php");

$sAccion = "";
$sSubTitulo = "";
$sTitulo = "";

if (isset($_GET["sAccion"])) {
    $sAccion = $_GET["sAccion"]; // new / edit
} elseif (isset($_POST["sAccion"])) {
    $sAccion = $_POST["sAccion"]; // insert / update
}

// Acción 1: Creación de una nueva compra de insumos
if ($sAccion == "new") {
    $sTitulo = "Registrar nueva compra de insumos";
    $sSubTitulo = "Por favor, ingresar la información de la compra [(*) datos obligatorio]:";
    $sCambioAccion = "insert";
    // Valores por defecto
    $id_proveedor = "";
    $nombre_insumo = "";
    $cantidad = "";
    $precio_unitario = "";
    $fecha_pedido = "";
    $fecha_recepcion = "";
    $estado = "Pendiente";
}
// Acción 2: Editar datos de una compra de insumos existente
elseif ($sAccion == "edit") {
    $sTitulo = "Modificar datos de la compra de insumos";
    $sSubTitulo = "Por favor, actualizar la información de la compra [(*) datos obligatorio]:";
    $sCambioAccion = "update";
    if (isset($_GET["id_compra"])) $id_compra = $_GET["id_compra"];
    
    // Buscando los últimos datos registrados
    $sql = "SELECT * FROM compra_insumos WHERE id_compra = $id_compra";
    $result = dbQuery($sql);
    if ($row = mysqli_fetch_array($result)) {
        $id_proveedor = $row["id_proveedor"];
        $nombre_insumo = $row["nombre_insumo"];
        $cantidad = $row["cantidad"];
        $precio_unitario = $row["precio_unitario"];
        $fecha_pedido = $row["fecha_pedido"];
        $fecha_recepcion = $row["fecha_recepcion"];
        $estado = $row["estado"];
    }
}
// Acción 3: Insertar una nueva compra en la base de datos
elseif ($sAccion == "insert") {
    $id_proveedor = $_POST["id_proveedor"];
    $nombre_insumo = $_POST["nombre_insumo"];
    $cantidad = $_POST["cantidad"];
    $precio_unitario = $_POST["precio_unitario"];
    $fecha_pedido = $_POST["fecha_pedido"];
    $fecha_recepcion = $_POST["fecha_recepcion"];
    $estado = $_POST["estado"];
    
    // SQL para insertar una nueva compra
    $sql = "INSERT INTO compra_insumos (id_proveedor, nombre_insumo, cantidad, precio_unitario, fecha_pedido, fecha_recepcion, estado) 
            VALUES ('$id_proveedor', '$nombre_insumo', '$cantidad', '$precio_unitario', '$fecha_pedido', '$fecha_recepcion', '$estado')";
    dbQuery($sql);
    
    // Redirigir después de insertar
    $mensaje = "1";
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $pagina = 'compra_insumos.php?mensaje=' . $mensaje;
    header("Location: http://$host$uri/$pagina");
}
// Acción 4: Actualizar una compra de insumos existente
elseif ($sAccion == "update") {
    $id_compra = $_POST["id_compra"];
    $id_proveedor = $_POST["id_proveedor"];
    $nombre_insumo = $_POST["nombre_insumo"];
    $cantidad = $_POST["cantidad"];
    $precio_unitario = $_POST["precio_unitario"];
    $fecha_pedido = $_POST["fecha_pedido"];
    $fecha_recepcion = $_POST["fecha_recepcion"];
    $estado = $_POST["estado"];
    
    // SQL para actualizar una compra
    $sql = "UPDATE compra_insumos SET id_proveedor = '$id_proveedor', nombre_insumo = '$nombre_insumo', cantidad = '$cantidad', 
            precio_unitario = '$precio_unitario', fecha_pedido = '$fecha_pedido', fecha_recepcion = '$fecha_recepcion', 
            estado = '$estado' WHERE id_compra = $id_compra";
    dbQuery($sql);
    
    // Redirigir después de actualizar
    $mensaje = "2";
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $pagina = 'compra_insumos.php?mensaje=' . $mensaje;
    header("Location: http://$host$uri/$pagina");
}
?>

<?php
include ("sidebar.php");
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?php echo $sTitulo; ?></h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?php echo $sSubTitulo; ?></h3>
            </div>
            <!-- /.card-header -->

            <!-- Formulario de datos -->
            <div class="card-body">
                <form name="frmDatos" action="compra_insumos_detalle.php" method="post">
                    <input type="hidden" name="sAccion" value="<?php echo $sCambioAccion; ?>">
                    <input type="hidden" name="id_compra" value="<?php echo $id_compra; ?>">

                    <div class="form-group">
                        <label for="id_proveedor">Proveedor:</label>
                        <select name="id_proveedor" id="id_proveedor" class="form-control">
                            <?php
                            // Consulta para obtener los proveedores
                            $sql = "SELECT id_proveedor, nombre_proveedor FROM proveedor";
                            $resProveedor = dbQuery($sql);
                            while ($rowProveedor = mysqli_fetch_array($resProveedor)) {
                                $selected = ($id_proveedor == $rowProveedor["id_proveedor"]) ? "selected" : "";
                                echo "<option value='" . $rowProveedor["id_proveedor"] . "' $selected>" . $rowProveedor["nombre_proveedor"] . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="nombre_insumo">Nombre del insumo:</label>
                        <input type="text" name="nombre_insumo" id="nombre_insumo" class="form-control" value="<?php echo $nombre_insumo; ?>" required />
                    </div>

                    <div class="form-group">
                        <label for="cantidad">Cantidad (*):</label>
                        <input type="number" name="cantidad" id="cantidad" class="form-control" value="<?php echo $cantidad; ?>" required />
                    </div>

                    <div class="form-group">
                        <label for="precio_unitario">Precio unitario (*):</label>
                        <input type="number" name="precio_unitario" id="precio_unitario" class="form-control" value="<?php echo $precio_unitario; ?>" step="0.01" required />
                    </div>

                    <div class="form-group">
                        <label for="fecha_pedido">Fecha de pedido (*):</label>
                        <input type="date" name="fecha_pedido" id="fecha_pedido" class="form-control" value="<?php echo $fecha_pedido; ?>" required />
                    </div>

                    <div class="form-group">
                        <label for="fecha_recepcion">Fecha de recepción:</label>
                        <input type="date" name="fecha_recepcion" id="fecha_recepcion" class="form-control" value="<?php echo $fecha_recepcion; ?>" />
                    </div>

                    <div class="form-group">
                        <label for="estado">Estado:</label>
                        <select name="estado" id="estado" class="form-control">
                            <option value="Pendiente" <?php if ($estado == 'Pendiente') echo 'selected'; ?>>Pendiente</option>
                            <option value="Recibido" <?php if ($estado == 'Recibido') echo 'selected'; ?>>Recibido</option>
                            <option value="Cancelado" <?php if ($estado == 'Cancelado') echo 'selected'; ?>>Cancelado</option>
                        </select>
                    </div>
                    <a href="compra_insumos.php" class="btn btn-primary">Regresar</a>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
include ("footer.php");
?>
