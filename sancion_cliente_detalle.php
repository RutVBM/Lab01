<?php
include("header.php");
include_once("conexion/database.php");
include("sidebar.php");

$sAccion = $_GET["sAccion"] ?? $_POST["sAccion"] ?? "";
$id_sancion = $_GET["id_sancion"] ?? "";

// Si la acción es editar, obtenemos los datos de la sanción
if ($sAccion == "edit" && !empty($id_sancion)) {
    $sTitulo = "Editar Sanción de Cliente";
    $sCambioAccion = "update";

    // Obtener los datos de la sanción
    $sql_sancion = "SELECT id_sancion, id_reserva, hay_sancion, cant_sancion, fecha_sancion FROM sancion WHERE id_sancion = ?";
    $stmt_sancion = dbQuery($sql_sancion, [$id_sancion]);
    $sancion = $stmt_sancion->fetch_assoc();
} else {
    $sTitulo = "Nueva Sanción";
    $sCambioAccion = "insert";
    $sancion = ['hay_sancion' => '', 'cant_sancion' => '', 'fecha_sancion' => ''];
}

// Procesar el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_reserva = $_POST["id_reserva"];
    $hay_sancion = $_POST["hay_sancion"];
    $cant_sancion = $_POST["cant_sancion"];
    $fecha_sancion = $_POST["fecha_sancion"];

    if ($sAccion == "insert") {
        // Insertar nueva sanción
        $sql_insert = "INSERT INTO sancion (id_reserva, hay_sancion, cant_sancion, fecha_sancion) VALUES (?, ?, ?, ?)";
        dbQuery($sql_insert, [$id_reserva, $hay_sancion, $cant_sancion, $fecha_sancion]);
    } elseif ($sAccion == "update") {
        // Actualizar sanción existente
        $sql_update = "UPDATE sancion SET hay_sancion = ?, cant_sancion = ?, fecha_sancion = ? WHERE id_sancion = ?";
        dbQuery($sql_update, [$hay_sancion, $cant_sancion, $fecha_sancion, $id_sancion]);
    }

    // Redirigir a la lista de sanciones
    header("Location: sancion_cliente.php");
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
                <form action="sancion_cliente_detalle.php" method="post">
                    <input type="hidden" name="sAccion" value="<?= $sCambioAccion ?>">
                    <input type="hidden" name="id_sancion" value="<?= $id_sancion ?>">

                    <!-- ID Reserva (solo lectura) -->
                    <div class="form-group">
                        <label for="id_reserva">ID Reserva:</label>
                        <input type="text" name="id_reserva" id="id_reserva" class="form-control" value="<?= htmlspecialchars($sancion['id_reserva']) ?>" readonly>
                    </div>

                    <!-- Hay Sanción -->
                    <div class="form-group">
                        <label for="hay_sancion">¿Hay Sanción?</label>
                        <select name="hay_sancion" id="hay_sancion" class="form-control" required>
                            <option value="1" <?= $sancion['hay_sancion'] == 1 ? 'selected' : '' ?>>Sí</option>
                            <option value="0" <?= $sancion['hay_sancion'] == 0 ? 'selected' : '' ?>>No</option>
                        </select>
                    </div>

                    <!-- Cantidad de Sanción -->
                    <div class="form-group">
                        <label for="cant_sancion">Cantidad de Sanción:</label>
                        <input type="number" name="cant_sancion" id="cant_sancion" class="form-control" value="<?= htmlspecialchars($sancion['cant_sancion']) ?>" required>
                    </div>

                    <!-- Fecha de Sanción -->
                    <div class="form-group">
                        <label for="fecha_sancion">Fecha de Sanción:</label>
                        <input type="date" name="fecha_sancion" id="fecha_sancion" class="form-control" value="<?= htmlspecialchars($sancion['fecha_sancion']) ?>" required>
                    </div>

                    <button type="submit" class="btn btn-primary"><?= $sAccion == "insert" ? "Guardar Sanción" : "Actualizar Sanción" ?></button>
                </form>
            </div>
        </div>
    </section>
</div>

<?php include("footer.php"); ?>
