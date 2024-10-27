<?php
ob_start(); // Inicia el buffer de salida para evitar errores de header
include("header.php");
include_once("conexion/database.php");

$sAccion = $_GET["sAccion"] ?? $_POST["sAccion"] ?? "edit";
$sTitulo = "Modificar Reclamo";
$id_reclamo = $_POST["id_reclamo"] ?? "";
$id_cliente = $tipo = $detalle = $fecha_reclamo = $estado_reclamo = $fecha_solucion = $detalle_solucion = "";

// Cargar datos del reclamo a editar si se proporciona un `id_reclamo`
if (isset($_GET["id_reclamo"])) {
    $id_reclamo = $_GET["id_reclamo"];

    // Cargar datos del reclamo a editar
    $stmt = dbQuery("SELECT * FROM reclamos WHERE id_reclamo = ?", [$id_reclamo]);
    if ($stmt && $row = $stmt->fetch_assoc()) {
        $id_cliente = $row["id_cliente"];
        $tipo = $row["tipo"];
        $detalle = $row["detalle"];
        $fecha_reclamo = $row["fecha_reclamo"];
        $estado_reclamo = $row["estado_reclamo"];
        $fecha_solucion = $row["fecha_solucion"];
        $detalle_solucion = $row["detalle_solucion"]; // Nuevo campo
    } else {
        echo "Error: Reclamo no encontrado.";
        exit();
    }
}

// Procesar actualización de datos
if ($_SERVER["REQUEST_METHOD"] === "POST" && $sAccion == "update") {
    $estado_reclamo = $_POST["estado_reclamo"];
    $fecha_solucion = $_POST["fecha_solucion"];
    $detalle_solucion = $_POST["detalle_solucion"]; // Capturar detalle de solución
    $id_reclamo = $_POST["id_reclamo"];

    // Actualizar reclamo existente
    $sql = "UPDATE reclamos 
            SET estado_reclamo = ?, fecha_solucion = ?, detalle_solucion = ?
            WHERE id_reclamo = ?";
    dbQuery($sql, [$estado_reclamo, $fecha_solucion, $detalle_solucion, $id_reclamo]);

    header("Location: atencion_reclamos.php?mensaje=success");
    exit();
}
?>

<?php include("sidebar.php"); ?>

<!-- Contenido Principal -->
<div class="content-wrapper">
    <section class="content-header">
        <h1><?= $sTitulo ?></h1>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-body">
                <form action="atencion_reclamos_detalle.php" method="post">
                    <input type="hidden" name="sAccion" value="update">
                    <input type="hidden" name="id_reclamo" value="<?= $id_reclamo ?>">

                    <!-- Campos de solo lectura -->
                    <div class="form-group">
                        <label for="id_cliente">ID Cliente:</label>
                        <input type="text" name="id_cliente" class="form-control-plaintext" value="<?= $id_cliente ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="tipo">Tipo de Reclamo:</label>
                        <input type="text" name="tipo" class="form-control-plaintext" value="<?= $tipo ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="detalle">Descripción del Reclamo:</label>
                        <textarea name="detalle" class="form-control-plaintext" rows="3" readonly><?= $detalle ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="fecha_reclamo">Fecha de Reclamo:</label>
                        <input type="text" name="fecha_reclamo" class="form-control-plaintext" value="<?= $fecha_reclamo ?>" readonly>
                    </div>

                    <!-- Campos editables -->
                    <div class="form-group">
                        <label for="estado_reclamo">Estado:</label>
                        <select name="estado_reclamo" class="form-control" required>
                            <option value="pendiente" <?= $estado_reclamo == 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
                            <option value="resuelto" <?= $estado_reclamo == 'resuelto' ? 'selected' : '' ?>>Resuelto</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="fecha_solucion">Fecha de Solución:</label>
                        <input type="date" name="fecha_solucion" class="form-control" value="<?= $fecha_solucion ?>">
                    </div>

                    <div class="form-group">
                        <label for="detalle_solucion">Detalle de la Solución:</label>
                        <textarea name="detalle_solucion" class="form-control" rows="3"><?= $detalle_solucion ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-success">Guardar</button>
                </form>
            </div>
        </div>
    </section>
</div>

<?php include("footer.php"); ?>
<?php ob_end_flush(); ?>
