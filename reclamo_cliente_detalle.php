<?php
ob_start(); // Inicia el buffer de salida para evitar errores de header
include("header.php"); 
include_once("conexion/database.php"); 

// Inicialización de variables
$sAccion = $_GET["sAccion"] ?? $_POST["sAccion"] ?? "";
$sTitulo = $sAccion == "new" ? "Registrar un nuevo reclamo" : "Modificar Reclamo";
$id_reclamo = $_POST["id_reclamo"] ?? "";
$id_cliente = $tipo = $detalle = $fecha_reclamo = "";

// Verificar la acción y cargar datos si es necesario
if ($sAccion == "edit" && isset($_GET["id_reclamo"])) {
    $id_reclamo = $_GET["id_reclamo"];

    // Cargar datos del reclamo a editar
    $stmt = dbQuery("SELECT id_cliente, tipo, detalle, fecha_reclamo FROM reclamos WHERE id_reclamo = ?", [$id_reclamo]);
    if ($stmt && $row = $stmt->fetch_assoc()) {
        $id_cliente = $row["id_cliente"];
        $tipo = $row["tipo"];
        $detalle = $row["detalle"];
        $fecha_reclamo = $row["fecha_reclamo"];
    } else {
        echo "Error: Reclamo no encontrado.";
        exit();
    }
}

// Procesar inserción o actualización de datos
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_cliente = $_POST["id_cliente"];
    $tipo = $_POST["tipo"];
    $detalle = $_POST["detalle"];
    $fecha_reclamo = $_POST["fecha_reclamo"];

    if ($sAccion == "insert") {
        // Insertar nuevo reclamo
        $sql = "INSERT INTO reclamos (id_cliente, tipo, detalle, fecha_reclamo) 
                VALUES (?, ?, ?, ?)";
        dbQuery($sql, [$id_cliente, $tipo, $detalle, $fecha_reclamo]);

        header("Location: reclamo_cliente.php?mensaje=success");
        exit(); // Detener ejecución después de redirigir
    } elseif ($sAccion == "update") {
        // Actualizar reclamo existente
        $sql = "UPDATE reclamos 
                SET id_cliente = ?, tipo = ?, detalle = ?, fecha_reclamo = ? 
                WHERE id_reclamo = ?";
        dbQuery($sql, [$id_cliente, $tipo, $detalle, $fecha_reclamo, $id_reclamo]);

        header("Location: reclamo_cliente.php?mensaje=success");
        exit(); // Detener ejecución después de redirigir
    }
}
?>

<?php include("sidebar.php"); ?>

<!-- Contenido Principal -->
<div class="content-wrapper">
    <section class="content-header">
        <h1><?= $sTitulo ?></h1>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Por favor, complete los datos del reclamo:</h3>
            </div>

            <div class="card-body">
                <form action="reclamo_cliente_detalle.php" method="post">
                    <input type="hidden" name="sAccion" value="<?= $sAccion == 'new' ? 'insert' : 'update' ?>">
                    <input type="hidden" name="id_reclamo" value="<?= $id_reclamo ?>">

                    <div class="form-group">
                        <label for="id_cliente">ID Cliente:</label>
                        <input type="text" name="id_cliente" class="form-control" value="<?= $id_cliente ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="tipo">Tipo de Reclamo:</label>
                        <select name="tipo" class="form-control" required>
                            <option value="Consulta" <?= $tipo == 'Consulta' ? 'selected' : '' ?>>Consulta</option>
                            <option value="Reclamo" <?= $tipo == 'Reclamo' ? 'selected' : '' ?>>Reclamo</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="detalle">Descripción del Reclamo:</label>
                        <textarea name="detalle" class="form-control" required><?= $detalle ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="fecha_reclamo">Fecha de Reclamo:</label>
                        <input type="date" name="fecha_reclamo" class="form-control" value="<?= $fecha_reclamo ?>" required>
                    </div>

                    <button type="submit" class="btn btn-success">Guardar</button>
                </form>
            </div>
        </div>
    </section>
</div>

<?php include("footer.php"); ?>
<?php ob_end_flush(); // Enviar el contenido del buffer ?>
