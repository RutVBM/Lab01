<?php
include("header.php");
include_once("conexion/database.php");

$sAccion = $_GET["sAccion"] ?? $_POST["sAccion"] ?? "";
$id_reserva = $_GET["id_reserva"] ?? "";

// Configuración de la acción
if ($sAccion == "edit" && !empty($id_reserva)) {
    $sTitulo = "Editar Reserva de Entrenamiento";
    $sCambioAccion = "update";

    // Obtener los datos de la reserva
    $sql_reserva = "SELECT id_programacion, tipo_reserva, cantidad FROM reserva WHERE id_reserva = ?";
    $stmt_reserva = dbQuery($sql_reserva, [$id_reserva]);
    $row_reserva = $stmt_reserva->fetch_assoc();
    $id_programacion = $row_reserva['id_programacion'];
    $tipo_reserva = $row_reserva['tipo_reserva'];
    $cantidad = $row_reserva['cantidad'];
} else {
    $sTitulo = "Nueva Reserva de Entrenamiento";
    $sCambioAccion = "insert";
    $id_programacion = "";
    $tipo_reserva = "Individual"; // Valor predeterminado
    $cantidad = 1; // Valor predeterminado para 'Individual'
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
    $id_usuario = 1;  // Reemplaza con el ID del usuario actual
    $fecha_reserva = date("Y-m-d H:i:s");
    $tipo_reserva = $_POST["tipo_reserva"];
    $cantidad = ($tipo_reserva == "Grupal") ? $_POST["cantidad"] : 1; // Si es "Individual", cantidad es 1

    if ($sAccion == "insert") {
        $sql_insert = "INSERT INTO reserva (id_programacion, id_usuario, fecha_reserva, tipo_reserva, cantidad) VALUES (?, ?, ?, ?, ?)";
        dbQuery($sql_insert, [$id_programacion, $id_usuario, $fecha_reserva, $tipo_reserva, $cantidad]);
    } elseif ($sAccion == "update") {
        $sql_update = "UPDATE reserva SET id_programacion = ?, tipo_reserva = ?, cantidad = ? WHERE id_reserva = ?";
        dbQuery($sql_update, [$id_programacion, $tipo_reserva, $cantidad, $id_reserva]);
    }

    header("Location: reserva_entrenamientos.php");
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
                <form action="reserva_entrenamientos_detalle.php" method="post">
                    <input type="hidden" name="sAccion" value="<?= $sCambioAccion ?>">
                    <input type="hidden" name="id_reserva" value="<?= $id_reserva ?>">

                    <!-- Selección de programación -->
                    <div class="form-group">
                        <label for="id_programacion">Programación:</label>
                        <select name="id_programacion" id="id_programacion" class="form-control" required>
                            <option value="">Seleccione una programación</option>
                            <?php while ($programacion = $programaciones->fetch_assoc()): ?>
                                <option value="<?= $programacion['id_programacion'] ?>" <?= $id_programacion == $programacion['id_programacion'] ? 'selected' : '' ?>>
                                    <?= $programacion['nombre_entrenador'] ?> - <?= $programacion['dia'] ?> - <?= $programacion['hora_inicio'] ?> - <?= $programacion['nombre_parque'] ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <!-- Tipo de Reserva -->
                    <div class="form-group">
                        <label for="tipo_reserva">Tipo de Reserva:</label>
                        <select name="tipo_reserva" id="tipo_reserva" class="form-control" required>
                            <option value="Individual" <?= $tipo_reserva == "Individual" ? 'selected' : '' ?>>Individual</option>
                            <option value="Grupal" <?= $tipo_reserva == "Grupal" ? 'selected' : '' ?>>Grupal</option>
                        </select>
                    </div>

                    <!-- Cantidad -->
                    <div class="form-group" id="cantidadDiv" style="display: <?= $tipo_reserva == 'Grupal' ? 'block' : 'none' ?>;">
                        <label for="cantidad">Cantidad:</label>
                        <input type="number" name="cantidad" id="cantidad" class="form-control" value="<?= $cantidad ?>" <?= $tipo_reserva == 'Individual' ? 'readonly' : '' ?>>
                    </div>

                    <button type="submit" class="btn btn-primary"><?= $sAccion == "new" ? "Guardar Reserva" : "Actualizar Reserva" ?></button>
                </form>
            </div>
        </div>
    </section>
</div>

<?php include("footer.php"); ?>
