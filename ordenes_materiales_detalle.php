<?php
include("header.php");
include_once("conexion/database.php");
include("sidebar.php");

$sAccion = $_GET["sAccion"] ?? $_POST["sAccion"] ?? "";

// Inicializar variables
if ($sAccion == "new") {
    $sTitulo = "Nueva Orden de Material";
    $id_orden = "";
    $id_inventario = "";
    $cantidad = "";
    $subtotal = "";
    $estado = "Pendiente"; // Estado predeterminado
    $fecha = date("Y-m-d");
} elseif ($sAccion == "edit" && isset($_GET["id_orden"])) {
    $sTitulo = "Editar Orden de Material";
    $id_orden = $_GET["id_orden"];

    $sql = "SELECT * FROM ordenes_materiales WHERE id_orden = ?";
    $stmt = dbQuery($sql, [$id_orden]);
    if ($row = $stmt->fetch_assoc()) {
        $id_inventario = $row["id_inventario"];
        $cantidad = $row["cantidad"];
        $subtotal = $row["subtotal"];
        $estado = $row["estado"];
        $fecha = $row["fecha"];
    }
} elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_orden = $_POST["id_orden"] ?? null;
    $id_inventario = $_POST["id_inventario"];
    $cantidad = $_POST["cantidad"];
    $fecha = $_POST["fecha"];

    // Obtener el precio unitario del inventario
    $sql_precio = "SELECT precio_unitario FROM inventario WHERE id_inventario = ?";
    $stmt_precio = dbQuery($sql_precio, [$id_inventario]);
    $precio_unitario = $stmt_precio->fetch_assoc()["precio_unitario"];
    $subtotal = $cantidad * $precio_unitario;

    if ($sAccion == "insert") {
        $sql = "INSERT INTO ordenes_materiales (id_inventario, cantidad, subtotal, estado, fecha)
                VALUES (?, ?, ?, 'Pendiente', ?)";
        dbQuery($sql, [$id_inventario, $cantidad, $subtotal, $fecha]);
    } elseif ($sAccion == "update") {
        $sql = "UPDATE ordenes_materiales 
                SET id_inventario = ?, cantidad = ?, subtotal = ?, fecha = ?
                WHERE id_orden = ?";
        dbQuery($sql, [$id_inventario, $cantidad, $subtotal, $fecha, $id_orden]);
    }

    header("Location: ordenes_materiales.php");
    exit();
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1><?= $sTitulo ?></h1>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-body">
                <form action="ordenes_materiales_detalle.php" method="post">
                    <input type="hidden" name="sAccion" value="<?= $sAccion ?>">
                    <input type="hidden" name="id_orden" value="<?= $id_orden ?>">

                    <div class="form-group">
                        <label for="id_inventario">Seleccionar Material:</label>
                        <select name="id_inventario" class="form-control" required>
                            <option value="">Seleccione un material</option>
                            <?php
                            $sql_inventario = "SELECT id_inventario, nombre_material_producto FROM inventario";
                            $result_inventario = dbQuery($sql_inventario);
                            while ($inventario = mysqli_fetch_assoc($result_inventario)): ?>
                                <option value="<?= $inventario['id_inventario'] ?>" <?= $inventario['id_inventario'] == $id_inventario ? 'selected' : '' ?>>
                                    <?= $inventario['nombre_material_producto'] ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="cantidad">Cantidad:</label>
                        <input type="number" name="cantidad" class="form-control" value="<?= $cantidad ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="fecha">Fecha:</label>
                        <input type="date" name="fecha" class="form-control" value="<?= $fecha ?>" required>
                    </div>

                    <button type="submit" class="btn btn-success">Guardar</button>
                    <a href="ordenes_materiales.php" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </section>
</div>

<?php include("footer.php"); ?>
