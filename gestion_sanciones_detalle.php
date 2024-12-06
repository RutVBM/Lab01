<?php
session_start(); // Aseguramos que la sesión esté iniciada
include("header.php");
include_once("conexion/database.php");

$sAccion = $_GET["sAccion"] ?? $_POST["sAccion"] ?? "";
$id_reserva = $_GET["id_reserva"] ?? "";

// Verificamos si el usuario está logueado y obtenemos su id
$id_usuario = $_SESSION["IDUSUARIO"] ?? 0; // Obtener el ID del usuario desde la sesión

if ($id_usuario == 0) {
    echo '<script>alert("Debes iniciar sesión para realizar una reserva.");</script>';
    header("Location: login.php"); // Redirigir al login si el usuario no está logueado
    exit();
}

// Configuración de la acción
if ($sAccion == "edit" && !empty($id_reserva)) {
    $sTitulo = "Editar Reserva de Entrenamiento con Sanciones";
    $sCambioAccion = "update";

    // Obtener los datos de la reserva
    $sql_reserva = "SELECT id_programacion, tipo_reserva, cantidad, sancion, cant_sancion FROM reserva WHERE id_reserva = ?";
    $stmt_reserva = dbQuery($sql_reserva, [$id_reserva]);
    $row_reserva = $stmt_reserva->fetch_assoc();
    $id_programacion = $row_reserva['id_programacion'];
    $tipo_reserva = $row_reserva['tipo_reserva'];
    $cantidad = $row_reserva['cantidad'];
    $sancion = $row_reserva['sancion'];
    $cant_sancion = $row_reserva['cant_sancion'];
} else {
    // Redirigimos si no existe un ID de reserva
    header("Location: gestion_sanciones.php");
    exit();
}

// Obtener datos de todas las programaciones
$sql_programaciones = "SELECT ht.id_programacion, cp.nombre_entrenador, d.dia, h.hora_inicio, h.hora_fin, lp.nombre_parque
                       FROM horario_treno ht
                       INNER JOIN contrato_personal cp ON ht.id_contrato = cp.id_contrato
                       INNER JOIN dias_disponibles d ON ht.id_dia = d.id_dia
                       INNER JOIN horas h ON ht.id_hora = h.id_hora
                       INNER JOIN locales lp ON ht.id_local = lp.id_local";
$programaciones = dbQuery($sql_programaciones);

// Procesar el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_programacion = $_POST["id_programacion"];
    $fecha_reserva = date("Y-m-d H:i:s");
    $tipo_reserva = $_POST["tipo_reserva"];
    $cantidad = $_POST["cantidad"];
    $sancion = $_POST["sancion"];
    $cant_sancion = $_POST["cant_sancion"];

    if ($sAccion == "insert") {
        // Insertar nueva reserva con el id_usuario y sanción
        $sql_insert = "INSERT INTO reserva (id_programacion, id_usuario, fecha_reserva, tipo_reserva, cantidad, sancion, cant_sancion) 
                       VALUES (?, ?, ?, ?, ?, ?, ?)";
        dbQuery($sql_insert, [$id_programacion, $id_usuario, $fecha_reserva, $tipo_reserva, $cantidad, $sancion, $cant_sancion]);
    } elseif ($sAccion == "update") {
        // Actualizar reserva existente con sanción
        $sql_update = "UPDATE reserva SET id_programacion = ?, tipo_reserva = ?, cantidad = ?, sancion = ?, cant_sancion = ? WHERE id_reserva = ?";
        dbQuery($sql_update, [$id_programacion, $tipo_reserva, $cantidad, $sancion, $cant_sancion, $id_reserva]);
    }

    header("Location: gestion_sanciones.php");
    exit();
}

include("sidebar.php");
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1><?= $sTitulo ?></h1>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-body">
                <form action="gestion_sanciones_detalle.php" method="post">
                    <input type="hidden" name="sAccion" value="<?= $sCambioAccion ?>">
                    <input type="hidden" name="id_reserva" value="<?= $id_reserva ?>">

                    <!-- Selección de programación -->
                    <div class="form-group">
                        <label for="id_programacion">Programación:</label>
                        <select name="id_programacion" id="id_programacion" class="form-control" disabled>
                            <option value="">Seleccione una programación</option>
                            <?php while ($programacion = $programaciones->fetch_assoc()): ?>
                                <option value="<?= $programacion['id_programacion'] ?>" <?= $id_programacion == $programacion['id_programacion'] ? 'selected' : '' ?>>
                                    <?= $programacion['nombre_entrenador'] ?> - <?= $programacion['dia'] ?> - <?= $programacion['hora_inicio'] ?> - <?= $programacion['nombre_parque'] ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <!-- Tipo de Reserva (Individual o Grupal) -->
                    <div class="form-group">
                        <label for="tipo_reserva">Tipo de Reserva:</label>
                        <select name="tipo_reserva" id="tipo_reserva" class="form-control" disabled>
                            <option value="Individual" <?= $tipo_reserva == 'Individual' ? 'selected' : '' ?>>Individual</option>
                            <option value="Grupal" <?= $tipo_reserva == 'Grupal' ? 'selected' : '' ?>>Grupal</option>
                        </select>
                    </div>

                    <!-- Cantidad (solo visible si es Grupal) -->
                    <div class="form-group" id="cantidad_field" style="<?= $tipo_reserva == 'Grupal' ? '' : 'display:none;' ?>">
                        <label for="cantidad">Cantidad:</label>
                        <input type="number" name="cantidad" id="cantidad" class="form-control" value="<?= $cantidad ?>" readonly>
                    </div>

                    <!-- Sanción (Sí o No) -->
                    <div class="form-group">
                        <label for="sancion">¿Sanción?</label>
                        <select name="sancion" id="sancion" class="form-control" onchange="toggleSancionField()" required>
                            <option value="Sí" <?= $sancion == 'Sí' ? 'selected' : '' ?>>Sí</option>
                            <option value="No" <?= $sancion == 'No' ? 'selected' : '' ?>>No</option>
                        </select>
                    </div>

                    <!-- Cantidad de Sanción (solo visible si la sanción es "Sí") -->
                    <div class="form-group" id="cantidad_sancion_field" style="<?= $sancion == 'Sí' ? '' : 'display:none;' ?>">
                        <label for="cant_sancion">Cantidad de Sanción:</label>
                        <input type="number" name="cant_sancion" id="cant_sancion" class="form-control" value="<?= $cant_sancion ?>" <?= $sancion == 'No' ? 'readonly' : '' ?>>
                    </div>

                    <button type="submit" class="btn btn-primary"><?= $sAccion == "insert" ? "Guardar Reserva" : "Aplicar Sanción" ?></button>
                </form>
            </div>
        </div>
    </section>
</div>

<?php include("footer.php"); ?>

<script>
    // Función para ocultar/mostrar el campo de cantidad de sanción dependiendo de la opción seleccionada
    function toggleSancionField() {
        const sancion = document.getElementById('sancion').value;
        const cantidadSancionField = document.getElementById('cantidad_sancion_field');
        if (sancion === 'Sí') {
            cantidadSancionField.style.display = 'block';
            document.getElementById('cant_sancion').removeAttribute('readonly');
        } else {
            cantidadSancionField.style.display = 'none';
            document.getElementById('cant_sancion').setAttribute('readonly', true);
            document.getElementById('cant_sancion').value = '';  // Si no tiene sanción, el campo se limpia
        }
    }

    // Llamamos a la función para inicializar el estado del campo al cargar la página
    document.addEventListener("DOMContentLoaded", toggleSancionField);
</script>
