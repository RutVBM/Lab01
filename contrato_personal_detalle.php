<?php
include("header.php");
include("sidebar.php");
include_once("conexion/database.php");

$sAccion = $_GET["sAccion"] ?? $_POST["sAccion"] ?? "";

if ($sAccion == "new") {
    $sTitulo = "Registrar un nuevo contrato de personal";
    $sCambioAccion = "insert";
    $id_contrato = "";
    $nombre_entrenador = "";
    $telefono = "";
    $salario = "";
    $estado = "Activo";
    $dias_disponibles = "";
    $hora_inicio = "";
    $hora_fin = "";
    $tipo_entrenamiento = "";
    $capacidad = "";
    $especialidad = "";
} elseif ($sAccion == "edit" && isset($_GET["id_contrato"])) {
    $sTitulo = "Modificar datos del contrato de personal";
    $sCambioAccion = "update";
    $id_contrato = $_GET["id_contrato"];

    $sql = "SELECT * FROM contrato_personal WHERE id_contrato = ?";
    $stmt = dbQuery($sql, [$id_contrato]);
    if ($row = $stmt->fetch_assoc()) {
        $nombre_entrenador = $row["nombre_entrenador"];
        $telefono = $row["telefono"];
        $salario = $row["salario"];
        $estado = $row["estado"];
        $dias_disponibles = $row["dias_disponibles"];
        $hora_inicio = $row["hora_inicio"];
        $hora_fin = $row["hora_fin"];
        $tipo_entrenamiento = $row["tipo_entrenamiento"];
        $capacidad = $row["capacidad"];
        $especialidad = $row["especialidad"];
    }
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= $sTitulo ?></h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-body">
                <form action="contrato_personal_detalle.php" method="post">
                    <input type="hidden" name="sAccion" value="<?= $sCambioAccion ?>">
                    <input type="hidden" name="id_contrato" value="<?= $id_contrato ?>">

                    <div class="form-group">
                        <label>Nombre del Entrenador:</label>
                        <input type="text" name="nombre_entrenador" class="form-control" value="<?= $nombre_entrenador ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Teléfono:</label>
                        <input type="text" name="telefono" class="form-control" value="<?= $telefono ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Salario (S/):</label>
                        <input type="number" name="salario" class="form-control" value="<?= $salario ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Días Disponibles:</label>
                        <input type="text" name="dias_disponibles" class="form-control" value="<?= $dias_disponibles ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Hora de Inicio:</label>
                        <input type="time" name="hora_inicio" class="form-control" value="<?= $hora_inicio ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Hora de Fin:</label>
                        <input type="time" name="hora_fin" class="form-control" value="<?= $hora_fin ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Tipo de Entrenamiento:</label>
                        <select name="tipo_entrenamiento" class="form-control" onchange="toggleCapacidad(this.value)">
                            <option value="Individual" <?= $tipo_entrenamiento == "Individual" ? "selected" : "" ?>>Individual</option>
                            <option value="Grupal" <?= $tipo_entrenamiento == "Grupal" ? "selected" : "" ?>>Grupal</option>
                        </select>
                    </div>

                    <div class="form-group" id="capacidad-group" <?= $tipo_entrenamiento == "Individual" ? "style='display:none;'" : "" ?>>
                        <label>Capacidad:</label>
                        <input type="number" name="capacidad" class="form-control" value="<?= $capacidad ?>">
                    </div>

                    <div class="form-group">
                        <label>Especialidad:</label>
                        <input type="text" name="especialidad" class="form-control" value="<?= $especialidad ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Estado:</label>
                        <select name="estado" class="form-control">
                            <option value="Activo" <?= $estado == "Activo" ? "selected" : "" ?>>Activo</option>
                            <option value="Inactivo" <?= $estado == "Inactivo" ? "selected" : "" ?>>Inactivo</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success" style="background-color: orange;">Guardar</button>
                    <a href="contrato_personal.php" class="btn btn-primary" style="background-color: orange;">Regresar</a>
                </form>
            </div>
        </div>
    </section>
</div>

<script>
function toggleCapacidad(tipo) {
    if (tipo === "Individual") {
        document.querySelector('#capacidad-group').style.display = "none";
    } else {
        document.querySelector('#capacidad-group').style.display = "block";
    }
}
</script>

<?php include("footer.php"); ?>
