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

// Obtener los datos de la reserva y del usuario
$sql_reserva = "SELECT r.id_reserva, r.fecha_reserva, r.tipo_reserva, r.cantidad, r.sancion, r.cant_sancion,
                u.nombre, u.apellidos
                FROM reserva r
                INNER JOIN usuario u ON r.id_usuario = u.idusuario
                WHERE r.id_reserva = ?";
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

    // Si la sanción es "No", se pone la cantidad_sancion en 0
    if ($sancion == "No") {
        $cant_sancion = 0;
    }

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
                    <!-- Mostrar el nombre y apellidos del usuario -->
                    <div class="form-group">
                        <label for="usuario">Cliente:</label>
                        <input type="text" class="form-control" id="usuario" value="<?= htmlspecialchars($reserva['nombre'] . ' ' . $reserva['apellidos']) ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="id_reserva">Número de Reserva:</label>
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

                    <!-- Campo de selección de Sanción -->
                    <div class="form-group">
                        <label for="sancion">¿Aplicar Sanción?</label>
                        <select class="form-control" id="sancion" name="sancion" onchange="toggleCantidadSancion()" required>
                            <option value="Sí" <?= $reserva['sancion'] == 'Sí' ? 'selected' : '' ?>>Sí</option>
                            <option value="No" <?= $reserva['sancion'] == 'No' ? 'selected' : '' ?>>No</option>
                        </select>
                    </div>

                    <!-- Campo de cantidad de sanción, solo visible si la sanción es "Sí" -->
                    <div class="form-group" id="cantidad_sancion_field" style="<?= $reserva['sancion'] == 'Sí' ? '' : 'display:none;' ?>">
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

<script>
// Función para mostrar/ocultar el campo de cantidad de sanción
function toggleCantidadSancion() {
    const sancion = document.getElementById('sancion').value;
    const cantidadSancionField = document.getElementById('cantidad_sancion_field');
    if (sancion === 'Sí') {
        cantidadSancionField.style.display = 'block'; // Muestra el campo
    } else {
        cantidadSancionField.style.display = 'none'; // Oculta el campo
        document.getElementById('cant_sancion').value = 0; // Restaura la cantidad de sanción a 0 si no se aplica sanción
    }
}

// Llamamos a la función al cargar la página para inicializar el estado del campo
document.addEventListener("DOMContentLoaded", toggleCantidadSancion);
</script>
