<?php
session_start();
include("header.php");
include_once("conexion/database.php");

$sAccion = $_GET["sAccion"] ?? $_POST["sAccion"] ?? "";

// Configuración inicial
if ($sAccion == "new") {
    $sTitulo = "Registrar Contrato de Entrenador";
    $sSubTitulo = "Ingrese los datos del contrato.";
    $sCambioAccion = "insert";
    $id_contrato = "";
    $nombre_entrenador = "";
    $telefono = "";
    $especialidad = "";
    $dias_disponibles = [];
    $hora_inicio = "";
    $hora_fin = "";
    $tipo_entrenamiento = "Individual";
    $capacidad = 1; // Capacidad predeterminada para Individual
    $salario = "";
    $estado = "Activo";
} elseif ($sAccion == "edit" && isset($_GET["id_contrato"])) {
    $sTitulo = "Editar Contrato de Entrenador";
    $sSubTitulo = "Actualice los datos del contrato.";
    $sCambioAccion = "update";
    $id_contrato = $_GET["id_contrato"];

    // Cargar datos del contrato existente
    $sql = "SELECT * FROM contrato_personal WHERE id_contrato = ?";
    $stmt = dbQuery($sql, [$id_contrato]);
    if ($row = $stmt->fetch_assoc()) {
        $nombre_entrenador = $row["nombre_entrenador"];
        $telefono = $row["telefono"];
        $especialidad = $row["especialidad"];
        $dias_disponibles = explode(",", $row["dias_disponibles"]); // Convertir días a array
        $hora_inicio = $row["hora_inicio"];
        $hora_fin = $row["hora_fin"];
        $tipo_entrenamiento = $row["tipo_entrenamiento"];
        $capacidad = $row["capacidad"];
        $salario = $row["salario"];
        $estado = $row["estado"];
    }
}

// Obtener los días disponibles desde la tabla
$sql_dias = "SELECT id_dia, dia FROM dias_disponibles";
$dias_result = dbQuery($sql_dias);

// Insertar o actualizar datos
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre_entrenador = $_POST["nombre_entrenador"];
    $telefono = $_POST["telefono"];
    $especialidad = $_POST["especialidad"];
    $dias_disponibles = implode(",", $_POST["dias_disponibles"] ?? []); // Convertir días a cadena
    $hora_inicio = $_POST["hora_inicio"];
    $hora_fin = $_POST["hora_fin"];
    $tipo_entrenamiento = $_POST["tipo_entrenamiento"];
    $capacidad = $tipo_entrenamiento === "Individual" ? 1 : $_POST["capacidad"];
    $salario = $_POST["salario"];
    $estado = $_POST["estado"];

    if ($sAccion == "insert") {
        $sql = "INSERT INTO contrato_personal (nombre_entrenador, telefono, especialidad, dias_disponibles, hora_inicio, hora_fin, tipo_entrenamiento, capacidad, salario, estado)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        dbQuery($sql, [$nombre_entrenador, $telefono, $especialidad, $dias_disponibles, $hora_inicio, $hora_fin, $tipo_entrenamiento, $capacidad, $salario, $estado]);
    } elseif ($sAccion == "update") {
        $id_contrato = $_POST["id_contrato"];
        $sql = "UPDATE contrato_personal
                SET nombre_entrenador = ?, telefono = ?, especialidad = ?, dias_disponibles = ?, hora_inicio = ?, hora_fin = ?, tipo_entrenamiento = ?, capacidad = ?, salario = ?, estado = ?
                WHERE id_contrato = ?";
        dbQuery($sql, [$nombre_entrenador, $telefono, $especialidad, $dias_disponibles, $hora_inicio, $hora_fin, $tipo_entrenamiento, $capacidad, $salario, $estado, $id_contrato]);
    }

    header("Location: contrato_personal.php?mensaje=success");
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
                <form action="contrato_personal_detalle.php" method="post">
                    <input type="hidden" name="sAccion" value="<?= $sCambioAccion ?>">
                    <input type="hidden" name="id_contrato" value="<?= $id_contrato ?>">

                    <div class="form-group">
                        <label for="nombre_entrenador">Nombre del Entrenador:</label>
                        <input type="text" name="nombre_entrenador" class="form-control" value="<?= $nombre_entrenador ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="telefono">Teléfono:</label>
                        <input type="text" name="telefono" class="form-control" value="<?= $telefono ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="especialidad">Especialidad:</label>
                        <input type="text" name="especialidad" class="form-control" value="<?= $especialidad ?>">
                    </div>

                    <div class="form-group">
                        <label for="dias_disponibles">Días Disponibles:</label>
                        <select name="dias_disponibles[]" id="dias_disponibles" class="form-control" multiple>
                            <?php while ($dia = $dias_result->fetch_assoc()): ?>
                                <option value="<?= $dia['id_dia'] ?>" <?= in_array($dia['id_dia'], $dias_disponibles) ? 'selected' : '' ?>>
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
                        <label for="tipo_entrenamiento">Tipo de Entrenamiento:</label>
                        <select name="tipo_entrenamiento" id="tipo_entrenamiento" class="form-control" onchange="toggleCapacidad()" required>
                            <option value="Grupal" <?= $tipo_entrenamiento == "Grupal" ? 'selected' : '' ?>>Grupal</option>
                            <option value="Individual" <?= $tipo_entrenamiento == "Individual" ? 'selected' : '' ?>>Individual</option>
                        </select>
                    </div>

                    <div class="form-group" id="capacidad_group" <?= $tipo_entrenamiento === "Individual" ? 'style="display:none;"' : '' ?>>
                        <label for="capacidad">Capacidad:</label>
                        <input type="number" name="capacidad" id="capacidad" class="form-control" value="<?= $capacidad ?>">
                    </div>

                    <div class="form-group">
                        <label for="salario">Salario (S/):</label>
                        <input type="number" name="salario" class="form-control" value="<?= $salario ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="estado">Estado:</label>
                        <select name="estado" class="form-control" required>
                            <option value="Activo" <?= $estado == "Activo" ? 'selected' : '' ?>>Activo</option>
                            <option value="Inactivo" <?= $estado == "Inactivo" ? 'selected' : '' ?>>Inactivo</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">Guardar</button>
                    <a href="contrato_personal.php" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </section>
</div>

<script>
    function toggleCapacidad() {
        var tipo = document.getElementById('tipo_entrenamiento').value;
        var capacidadGroup = document.getElementById('capacidad_group');
        if (tipo === 'Individual') {
            capacidadGroup.style.display = 'none';
        } else {
            capacidadGroup.style.display = 'block';
        }
    }
</script>

<?php include("footer.php"); ?>
