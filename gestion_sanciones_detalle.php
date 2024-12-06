<?php
session_start(); // Aseguramos que la sesión esté iniciada
include("header.php");
include_once("conexion/database.php");
include("sidebar.php");

$id_reserva = $_GET["id_reserva"] ?? "";

if (empty($id_reserva)) {
    echo '<script>alert("ID de reserva no proporcionado."); window.location.href = "gestion_sanciones.php";</script>';
    exit();
}

// Obtener los datos de la reserva y sanción correspondiente
$sql_reserva = "SELECT id_reserva, fecha_reserva, tipo_reserva, cantidad, sancion, cant_sancion 
                FROM reserva WHERE id_reserva = ?";
$stmt_reserva = dbQuery($sql_reserva, [$id_reserva]);
$reserva = $stmt_reserva->fetch_assoc();

if (!$reserva) {
    echo '<script>alert("Reserva no encontrada."); window.location.href = "gestion_sanciones.php";</script>';
    exit();
}

// Procesar el formulario de edición
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $sancion = $_POST["sancion"];
    $cant_sancion = $_POST["cant_sancion"];

    // Actualizar la sanción en la base de datos
    $sql_update = "UPDATE reserva SET sancion = ?, cant_sancion = ? WHERE id_reserva = ?";
    dbQuery($sql_update, [$sancion, $cant_sancion, $id_reserva]);

    echo '<script>alert("Sanción actualizada con éxito."); window.location.href = "gestion_sanciones.php";</script>';
    exit();
}

?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Detalles de Sanción</h1>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-body">
                <form action="gestion_sanciones_detalle.php?id_reserva=<?= $id_reserva ?>" method="post">
                    <div class="form-group">
                        <label for="id_reserva">ID Reserva:</label>
                        <input type="text" class="form-control" id="id_reserva" value="<?= htmlspecialchars($reserva['id_reserva']) ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="fecha_reserva">Fecha de Reserva:</label>
                        <input type="text" class="form-control" id="fecha_reserva" value="<?= htmlspecialchars($reserva['fecha_reserva']) ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="tipo_reserva">Tipo de Reserva:</label>
                        <input type="text" class="form-control" id="tipo_reserva" value="<?= htmlspecialchars($reserva['tipo_reserva']) ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="cantidad">Cantidad:</label>
                        <input type="number" class="form-control" id="cantidad" value="<?= htmlspecialchars($reserva['cantidad']) ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="sancion">Sanción:</label>
                        <input type="text" class="form-control" id="sancion" name="sancion" value="<?= htmlspecialchars($reserva['sancion'] ?? '') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="cant_sancion">Cantidad de Sanción:</label>
                        <input type="number" class="form-control" id="cant_sancion" name="cant_sancion" value="<?= htmlspecialchars($reserva['cant_sancion'] ?? '0') ?>" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Actualizar Sanción</button>
                </form>
            </div>
        </div>
    </section>
</div>

<?php include("footer.php"); ?>
