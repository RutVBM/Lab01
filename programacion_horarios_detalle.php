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
    $lugar = "Instalaciones"; // Predeterminado
    $id_local = null;
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
        $lugar = $row["id_local"] ? "Aire libre" : "Instalaciones";
        $id_local = $row["id_local"];
    }
}

// Obtener datos de entrenadores, días y locales
$sql_entrenadores = "SELECT id_contrato, nombre_entrenador FROM contrato_personal WHERE estado = 'Activo'";
$entrenadores_result = dbQuery($sql_entrenadores);

$sql_dias = "SELECT id_dia, dia FROM dias_disponibles";
$dias_result = dbQuery($sql_dias);

$sql_locales = "SELECT id_local, nombre_parque FROM locales";
$locales_result = dbQuery($sql_locales);

// Procesar el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_contrato = $_POST["id_contrato"];
    $id_dia = $_POST["id_dia"];
    $hora_inicio = $_POST["hora_inicio"];
    $hora_fin = $_POST["hora_fin"];
    $estado = $_POST["estado"];
    $lugar = $_POST["lugar"];
    $id_local = $lugar === "Aire libre" ? $_POST["id_local"] : null;

    if ($sAccion == "insert") {
        $sql = "INSERT INTO horario_treno (id_contrato, id_dia, hora_inicio, hora_fin, estado, id_local) VALUES (?, ?, ?, ?, ?, ?)";
        dbQuery($sql, [$id_contrato, $id_dia, $hora_inicio, $hora_fin, $estado, $id_local]);
    } elseif ($sAccion == "update") {
        $id_programacion = $_POST["id_programacion"];
        $sql = "UPDATE horario_treno 
                SET id_contrato = ?, id_dia = ?, hora_inicio = ?, hora_fin = ?, estado = ?, id_local = ? 
                WHERE id_programacion = ?";
        dbQuery($sql, [$id_contrato, $id_dia, $hora_inicio, $hora_fin, $estado, $id_local, $id_programacion]);
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
                        <label for="lugar">Lugar:</label>
                        <select name="lugar" id="lugar" class="form-control" onchange="toggleLocal()" required>
                            <option value="Instalaciones" <?= $lugar === "Instalaciones" ? 'selected' : '' ?>>Instalaciones</option>
                            <option value="Aire libre" <?= $lugar === "Aire libre" ? 'selected' : '' ?>>Aire libre</option>
                        </select>
                    </div>

                    <div class="form-group" id="local_group" <?= $lugar === "Instalaciones" ? 'style="display:none;"' : '' ?>>
                        <label for="id_local">Seleccione Local:</label>
                        <select name="id_local" class="form-control">
                            <option value="">Seleccione un local</option>
                            <?php while ($local = $locales_result->fetch_assoc()): ?>
                                <option value="<?= $local['id_local'] ?>" <?= $local['id_local'] == $id_local ? 'selected' : '' ?>>
                                    <?= $local['nombre_parque'] ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
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

<script>
    function toggleLocal() {
        var lugar = document.getElementById('lugar').value;
        var localGroup = document.getElementById('local_group');
        if (lugar === 'Aire libre') {
            localGroup.style.display = 'block';
        } else {
            localGroup.style.display = 'none';
        }
    }
</script>

<?php include("footer.php"); ?>