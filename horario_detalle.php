<?php
session_start();
include("header.php");

$sAccion = $_GET["sAccion"] ?? "new";
$idhorario = $_GET["idhorario"] ?? null;

// Determinar si es una acción de nuevo horario o edición
if ($sAccion == "new") {
    $idplan = "";
    $hora_inicio = "";
    $hora_fin = "";
} elseif ($sAccion == "edit" && $idhorario) {
    // Obtener los datos del horario a editar
    $sql = "SELECT * FROM horario_treno WHERE idhorario = ?";
    $result = dbQuery($sql, [$idhorario]);
    $horario = $result->fetch_assoc();
    $idplan = $horario["idplan"];
    $hora_inicio = $horario["hora_inicio"];
    $hora_fin = $horario["hora_fin"];
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idplan = $_POST["idplan"];
    $hora_inicio = $_POST["hora_inicio"];
    $hora_fin = $_POST["hora_fin"];

    if ($sAccion == "insert") {
        $sql = "INSERT INTO horario_treno (idplan, hora_inicio, hora_fin) VALUES (?, ?, ?)";
        dbQuery($sql, [$idplan, $hora_inicio, $hora_fin]);
        header("Location: horario.php?mensaje=1");
        exit();
    } elseif ($sAccion == "update" && $idhorario) {
        $sql = "UPDATE horario_treno SET idplan = ?, hora_inicio = ?, hora_fin = ? WHERE idhorario = ?";
        dbQuery($sql, [$idplan, $hora_inicio, $hora_fin, $idhorario]);
        header("Location: horario.php?mensaje=2");
        exit();
    }
}

include("sidebar.php");
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1><?= $sAccion == "new" ? "Agregar Horario" : "Editar Horario" ?></h1>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-body">
                <form method="post" action="horario_detalle.php?sAccion=<?= $sAccion == "new" ? "insert" : "update&idhorario=$idhorario" ?>">
                    <div class="form-group">
                        <label for="idplan">Plan:</label>
                        <select name="idplan" id="idplan" class="form-control" required>
                            <option value="">Seleccione un plan</option>
                            <?php
                            // Consultar los planes disponibles
                            $planes = dbQuery("SELECT idplan, nombre_plan FROM planes_entrenamiento WHERE estado = 'A'");
                            while ($plan = $planes->fetch_assoc()): ?>
                                <option value="<?= $plan['idplan'] ?>" <?= $idplan == $plan['idplan'] ? "selected" : "" ?>>
                                    <?= $plan['nombre_plan'] ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="hora_inicio">Hora Inicio:</label>
                        <input type="time" name="hora_inicio" id="hora_inicio" class="form-control" value="<?= $hora_inicio ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="hora_fin">Hora Fin:</label>
                        <input type="time" name="hora_fin" id="hora_fin" class="form-control" value="<?= $hora_fin ?>" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a href="horario.php" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </section>
</div>

<?php include("footer.php"); ?>
