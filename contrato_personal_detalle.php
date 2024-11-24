<?php
include("header.php");
include_once("conexion/database.php");

$sAccion = $_GET["sAccion"] ?? $_POST["sAccion"] ?? "";

// Configurar título y valores por defecto para la creación de un nuevo registro
if ($sAccion == "new") {
    $sTitulo = "Registrar un nuevo contrato de entrenador";
    $sSubTitulo = "Por favor, ingresar la información del contrato [(*) datos obligatorios]:";
    $sCambioAccion = "insert";
    $id_contrato = "";
    $nombre_entrenador = "";
    $telefono = "";
    $salario = "";
    $dias_disponibles = "";
    $hora_inicio = "";
    $hora_fin = "";
    $tipo_entrenamiento = "";
    $capacidad = "";
    $estado = "Activo"; // Valor predeterminado
} elseif ($sAccion == "edit" && isset($_GET["id_contrato"])) {
    $sTitulo = "Modificar contrato del entrenador";
    $sSubTitulo = "Por favor, actualizar la información del contrato [(*) datos obligatorios]:";
    $sCambioAccion = "update";
    $id_contrato = $_GET["id_contrato"];
    
    // Cargar los datos del contrato para editar
    $sql = "SELECT * FROM contrato_personal WHERE id_contrato = ?";
    $stmt = dbQuery($sql, [$id_contrato]);
    if ($row = $stmt->fetch_assoc()) {
        $nombre_entrenador = $row["nombre_entrenador"];
        $telefono = $row["telefono"];
        $salario = $row["salario"];
        $dias_disponibles = $row["dias_disponibles"];
        $hora_inicio = $row["hora_inicio"];
        $hora_fin = $row["hora_fin"];
        $tipo_entrenamiento = $row["tipo_entrenamiento"];
        $capacidad = $row["capacidad"];
        $estado = $row["estado"];
    }
} elseif ($sAccion == "insert") {
    // Insertar un nuevo registro
    $nombre_entrenador = $_POST["nombre_entrenador"];
    $telefono = $_POST["telefono"];
    $salario = $_POST["salario"];
    $dias_disponibles = implode(",", $_POST["dias_disponibles"]);
    $hora_inicio = $_POST["hora_inicio"];
    $hora_fin = $_POST["hora_fin"];
    $tipo_entrenamiento = $_POST["tipo_entrenamiento"];
    $capacidad = $_POST["capacidad"];
    $estado = $_POST["estado"];
    
    $sql = "INSERT INTO contrato_personal (nombre_entrenador, telefono, salario, dias_disponibles, hora_inicio, hora_fin, tipo_entrenamiento, capacidad, estado)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    dbQuery($sql, [$nombre_entrenador, $telefono, $salario, $dias_disponibles, $hora_inicio, $hora_fin, $tipo_entrenamiento, $capacidad, $estado]);
    header("Location: contrato_personal.php?mensaje=1");
    exit();
} elseif ($sAccion == "update") {
    // Actualizar el registro existente
    $id_contrato = $_POST["id_contrato"];
    $nombre_entrenador = $_POST["nombre_entrenador"];
    $telefono = $_POST["telefono"];
    $salario = $_POST["salario"];
    $dias_disponibles = implode(",", $_POST["dias_disponibles"]);
    $hora_inicio = $_POST["hora_inicio"];
    $hora_fin = $_POST["hora_fin"];
    $tipo_entrenamiento = $_POST["tipo_entrenamiento"];
    $capacidad = $_POST["capacidad"];
    $estado = $_POST["estado"];
    
    $sql = "UPDATE contrato_personal 
            SET nombre_entrenador = ?, telefono = ?, salario = ?, dias_disponibles = ?, hora_inicio = ?, hora_fin = ?, tipo_entrenamiento = ?, capacidad = ?, estado = ?
            WHERE id_contrato = ?";
    dbQuery($sql, [$nombre_entrenador, $telefono, $salario, $dias_disponibles, $hora_inicio, $hora_fin, $tipo_entrenamiento, $capacidad, $estado, $id_contrato]);
    header("Location: contrato_personal.php?mensaje=2");
    exit();
}

include("sidebar.php");
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?php echo $sTitulo; ?></h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?php echo $sSubTitulo; ?></h3>
            </div>

            <div class="card-body">
                <form action="contrato_personal_detalle.php" method="post">
                    <input type="hidden" name="sAccion" value="<?php echo $sCambioAccion; ?>">
                    <input type="hidden" name="id_contrato" value="<?php echo $id_contrato; ?>">

                    <div class="form-group">
                        <label for="nombre_entrenador">Nombre del Entrenador (*):</label>
                        <input type="text" name="nombre_entrenador" class="form-control" value="<?php echo $nombre_entrenador; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="telefono">Teléfono (*):</label>
                        <input type="text" name="telefono" class="form-control" value="<?php echo $telefono; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="dias_disponibles">Días Disponibles (*):</label>
                        <select name="dias_disponibles[]" class="form-control" multiple required>
                            <?php
                            $dias = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"];
                            $dias_seleccionados = explode(",", $dias_disponibles);
                            foreach ($dias as $dia) {
                                $selected = in_array($dia, $dias_seleccionados) ? "selected" : "";
                                echo "<option value='$dia' $selected>$dia</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="hora_inicio">Hora de Inicio (*):</label>
                        <input type="time" name="hora_inicio" class="form-control" value="<?php echo $hora_inicio; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="hora_fin">Hora de Fin (*):</label>
                        <input type="time" name="hora_fin" class="form-control" value="<?php echo $hora_fin; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="tipo_entrenamiento">Tipo de Entrenamiento (*):</label>
                        <select name="tipo_entrenamiento" id="tipo_entrenamiento" class="form-control" required onchange="toggleCapacidad()">
                            <option value="Grupal" <?php if ($tipo_entrenamiento == "Grupal") echo "selected"; ?>>Grupal</option>
                            <option value="Individual" <?php if ($tipo_entrenamiento == "Individual") echo "selected"; ?>>Individual</option>
                        </select>
                    </div>

                    <div class="form-group" id="capacidad_group" style="display: <?php echo ($tipo_entrenamiento == "Individual") ? 'none' : 'block'; ?>;">
                        <label for="capacidad">Capacidad (*):</label>
                        <input type="number" name="capacidad" id="capacidad" class="form-control" value="<?php echo $capacidad; ?>" <?php echo ($tipo_entrenamiento == "Individual") ? 'readonly value="1"' : ''; ?>>
                    </div>

                    <div class="form-group">
                        <label for="salario">Salario (*):</label>
                        <input type="number" name="salario" class="form-control" value="<?php echo $salario; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="estado">Estado (*):</label>
                        <select name="estado" class="form-control" required>
                            <option value="Activo" <?php if ($estado == "Activo") echo "selected"; ?>>Activo</option>
                            <option value="Inactivo" <?php if ($estado == "Inactivo") echo "selected"; ?>>Inactivo</option>
                        </select>
                    </div>

                    <div class="form-group-buttons text-center">
                        <button type="submit" class="btn btn-success" style="background-color: orange;">Guardar</button>
                        <a href="contrato_personal.php" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<script>
    // Mostrar/ocultar campo capacidad según el tipo de entrenamiento
    function toggleCapacidad() {
        const tipoEntrenamiento = document.getElementById('tipo_entrenamiento').value;
        const capacidadGroup = document.getElementById('capacidad_group');
        const capacidadInput = document.getElementById('capacidad');

        if (tipoEntrenamiento === 'Individual') {
            capacidadGroup.style.display = 'none';
            capacidadInput.value = 1;
            capacidadInput.setAttribute('readonly', true);
        } else {
            capacidadGroup.style.display = 'block';
            capacidadInput.value = '';
            capacidadInput.removeAttribute('readonly');
        }
    }

    // Ejecutar al cargar la página
    toggleCapacidad();
</script>

<?php include("footer.php"); ?>
