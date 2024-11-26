<?php
include("header.php");
include_once("conexion/database.php");

$sAccion = $_GET["sAccion"] ?? $_POST["sAccion"] ?? "";

// Configuración inicial
if ($sAccion == "new") {
    $sTitulo = "Nueva Programación de Horario";
    $sSubTitulo = "Ingrese los datos de la programación.";
    $sCambioAccion = "insert";
    $id_programacion = "";
    $id_contrato = "";
    $id_dia = "";
    $hora_inicio = "";
    $hora_fin = "";
    $estado = "Activo";
} elseif ($sAccion == "edit" && isset($_GET["id_programacion"])) {
    $sTitulo = "Editar Programación de Horario";
    $sSubTitulo = "Actualice los datos de la programación.";
    $sCambioAccion = "update";
    $id_programacion = $_GET["id_programacion"];

    $sql = "SELECT * FROM horario_treno WHERE id_programacion = ?";
    $stmt = dbQuery($sql, [$id_programacion]);
    if ($row = $stmt->fetch_assoc()) {
        $id_contrato = $row["id_contrato"];
        $id_dia = $row["id_dia"];
        $hora_inicio = $row["hora_inicio"];
        $hora_fin = $row["hora_fin"];
        $estado = $row["estado"];
    }
}

// Obtener datos de entrenadores y días disponibles
$sql_entrenadores = "SELECT id_contrato, nombre_entrenador FROM contrato_personal WHERE estado = 'Activo'";
$entrenadores_result = dbQuery($sql_entrenadores);

$sql_dias = "SELECT id_dia, dia FROM dias_disponibles";
$dias_result = dbQuery($sql_dias);

// Procesar el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_contrato = $_POST["id_contrato"];
    $id_dia = $_POST["id_dia"];
    $hora_inicio = $_POST["hora_inicio"];
    $hora_fin = $_POST["hora_fin"];
    $estado = $_POST["estado"];

    if ($sAccion == "insert") {
        $sql = "INSERT INTO horario_treno (id_contrato, id_dia, hora_inicio, hora_fin, estado) VALUES (?, ?, ?, ?, ?)";
        dbQuery($sql, [$id_contrato, $id_dia, $hora_inicio, $hora_fin, $estado]);
    } elseif ($sAccion == "update") {
        $id_programacion = $_POST["id_programacion"];
        $sql = "UPDATE horario_treno 
                SET id_contrato = ?, id_dia = ?, hora_inicio = ?, hora_fin = ?, estado = ? 
                WHERE id_programacion = ?";
        dbQuery($sql, [$id_contrato, $id_dia, $hora_inicio, $hora_fin, $estado, $id_programacion]);
    }

    header("Location: programacion_horarios.php?mensaje=success");
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
                <form action="programacion_horarios_detalle.php" method="post">
                    <input type="hidden" name="sAccion" value="<?= $sCambioAccion ?>">
                    <input type="hidden" name="id_programacion" value="<?= $id_programacion ?>">

                    <div class="form-group">
                        <label for="id_contrato">Entrenador:</label>
                        <select name="id_contrato" class="form-control" required>
                            <option value="">Seleccione un entrenador</option>
                            <?php while ($entrenador = $entrenadores_result->fetch_assoc()): ?>
                                <option value="<?= $entrenador['id_contrato'] ?>" <?= $entrenador['id_contrato'] == $id_contrato ? 'selected' : '' ?>>
                                    <?= $entrenador['nombre_entrenador'] ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="id_dia">Día:</label>
                        <select name="id_dia" class="form-control" required>
                            <option value="">Seleccione un día</option>
                            <?php while ($dia = $dias_result->fetch_assoc()): ?>
                                <option value="<?= $dia['id_dia'] ?>" <?= $dia['id_dia'] == $id_dia ? 'selected' : '' ?>>
                                    <?= $dia['dia'] ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="hora_inicio">Hora de Inicio:</label>
                        <input type="time" name="hora_inicio" class="form-control" value="<?= $hora_inicio ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="hora_fin">Hora de Fin:</label>
                        <input type="time" name="hora_fin" class="form-control" value="<?= $hora_fin ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="estado">Estado:</label>
                        <select name="estado" class="form-control" required>
                            <option value="Activo" <?= $estado == "Activo" ? 'selected' : '' ?>>Activo</option>
                            <option value="Inactivo" <?= $estado == "Inactivo" ? 'selected' : '' ?>>Inactivo</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">Guardar</button>
                    <a href="programacion_horarios.php" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </section>
</div>

<?php include("footer.php"); ?>
