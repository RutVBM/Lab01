<?php
include("header.php");
include_once("conexion/database.php");

$sAccion = $_GET["sAccion"] ?? $_POST["sAccion"] ?? "";

// Configurar valores predeterminados
if ($sAccion == "new") {
    $sTitulo = "Registrar un nuevo contrato de local";
    $sSubTitulo = "Por favor, ingrese la información del contrato [(*) campos obligatorios]:";
    $sCambioAccion = "insert";
    $id_contratacion_local = "";
    $id_local = "";
    $id_dia = [];
    $hora_inicio = "";
    $hora_fin = "";
    $estado = "Activo";
} elseif ($sAccion == "edit" && isset($_GET["id_contratacion_local"])) {
    $sTitulo = "Editar contrato de local";
    $sSubTitulo = "Actualice la información del contrato:";
    $sCambioAccion = "update";
    $id_contratacion_local = $_GET["id_contratacion_local"];
    
    // Cargar datos existentes
    $sql = "SELECT * FROM contratos_locales WHERE id_contratacion_local = ?";
    $stmt = dbQuery($sql, [$id_contratacion_local]);
    if ($row = $stmt->fetch_assoc()) {
        $id_local = $row["id_local"];
        $id_dia = explode(",", $row["id_dia"]); // Convertir los días a un array
        $hora_inicio = $row["hora_inicio"];
        $hora_fin = $row["hora_fin"];
        $estado = $row["estado"];
    }
} elseif ($sAccion == "insert") {
    $id_local = $_POST["id_local"];
    $id_dia = implode(",", $_POST["id_dia"]); // Convertir el array de días en una cadena separada por comas
    $hora_inicio = $_POST["hora_inicio"];
    $hora_fin = $_POST["hora_fin"];
    $estado = $_POST["estado"];
    
    $sql = "INSERT INTO contratos_locales (id_local, id_dia, hora_inicio, hora_fin, estado) VALUES (?, ?, ?, ?, ?)";
    dbQuery($sql, [$id_local, $id_dia, $hora_inicio, $hora_fin, $estado]);
    header("Location: contratos_locales.php?mensaje=1");
    exit();
} elseif ($sAccion == "update") {
    $id_contratacion_local = $_POST["id_contratacion_local"];
    $id_local = $_POST["id_local"];
    $id_dia = implode(",", $_POST["id_dia"]); // Convertir los días seleccionados en una cadena separada por comas
    $hora_inicio = $_POST["hora_inicio"];
    $hora_fin = $_POST["hora_fin"];
    $estado = $_POST["estado"];
    
    $sql = "UPDATE contratos_locales 
            SET id_local = ?, id_dia = ?, hora_inicio = ?, hora_fin = ?, estado = ? 
            WHERE id_contratacion_local = ?";
    dbQuery($sql, [$id_local, $id_dia, $hora_inicio, $hora_fin, $estado, $id_contratacion_local]);
    header("Location: contratos_locales.php?mensaje=2");
    exit();
}

include("sidebar.php");
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= $sTitulo; ?></h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?= $sSubTitulo; ?></h3>
            </div>
            <div class="card-body">
                <form action="contratos_locales_detalle.php" method="post">
                    <input type="hidden" name="sAccion" value="<?= $sCambioAccion; ?>">
                    <input type="hidden" name="id_contratacion_local" value="<?= $id_contratacion_local; ?>">

                    <div class="form-group">
                        <label for="id_local">Seleccionar Local (*):</label>
                        <select name="id_local" class="form-control" required>
                            <option value="">Seleccione un local</option>
                            <?php
                            $sql_locales = "SELECT id_local, nombre_parque FROM locales";
                            $result_locales = dbQuery($sql_locales);
                            while ($local = mysqli_fetch_assoc($result_locales)): ?>
                                <option value="<?= $local['id_local']; ?>" <?= $local['id_local'] == $id_local ? 'selected' : ''; ?>>
                                    <?= $local['nombre_parque']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="id_dia">Días Disponibles (*):</label>
                        <select name="id_dia[]" class="form-control" multiple required>
                            <?php
                            $sql_dias = "SELECT id_dia, dia FROM dias_disponibles";
                            $result_dias = dbQuery($sql_dias);
                            while ($dia = mysqli_fetch_assoc($result_dias)): ?>
                                <option value="<?= $dia['id_dia']; ?>" <?= in_array($dia['id_dia'], $id_dia) ? 'selected' : ''; ?>>
                                    <?= $dia['dia']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="hora_inicio">Hora Inicio (*):</label>
                        <input type="time" name="hora_inicio" class="form-control" value="<?= $hora_inicio; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="hora_fin">Hora Fin (*):</label>
                        <input type="time" name="hora_fin" class="form-control" value="<?= $hora_fin; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="estado">Estado (*):</label>
                        <select name="estado" class="form-control" required>
                            <option value="Activo" <?= $estado == "Activo" ? 'selected' : ''; ?>>Activo</option>
                            <option value="Inactivo" <?= $estado == "Inactivo" ? 'selected' : ''; ?>>Inactivo</option>
                        </select>
                    </div>

                    <a href="contratos_locales.php" class="btn btn-primary" style="background-color: orange;">Regresar</a>
                    <button type="submit" class="btn btn-success" style="background-color: orange;">Guardar</button>
                </form>
            </div>
        </div>
    </section>
</div>

<?php include("footer.php"); ?>
