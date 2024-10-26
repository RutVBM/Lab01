<?php
ob_start(); // Inicia el buffer de salida para evitar errores de header
include("header.php"); 
include_once("conexion/database.php"); 

// Inicialización de variables
$sAccion = $_GET["sAccion"] ?? $_POST["sAccion"] ?? "";
$sTitulo = $sAccion == "new" ? "Registrar un nuevo reclamo" : "Modificar Reclamo";
$id_reclamo = $_POST["id_reclamo"] ?? "";
$id_cliente = $tipo = $detalle = $fecha_reclamo = $estado_reclamo = $fecha_solucion = "";

// Verificar la acción y cargar datos si es necesario
if ($sAccion == "edit" && isset($_GET["id_reclamo"])) {
    $id_reclamo = $_GET["id_reclamo"];

    // Cargar datos del reclamo a editar
    $stmt = dbQuery("SELECT * FROM reclamos WHERE id_reclamo = ?", [$id_reclamo]);
    if ($stmt && $row = $stmt->fetch_assoc()) {
        $id_cliente = $row["id_cliente"];
        $tipo = $row["tipo"];
        $detalle = $row["detalle"];
        $fecha_reclamo = $row["fecha_reclamo"];
        $estado_reclamo = $row["estado_reclamo"];
        $fecha_solucion = $row["fecha_solucion"];
    } else {
        echo "Error: Reclamo no encontrado.";
        exit();
    }
}

// Procesar inserción o actualización de datos
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $estado_reclamo = $_POST["estado_reclamo"];
    $fecha_solucion = $_POST["fecha_solucion"];
    $id_reclamo = $_POST["id_reclamo"];

    if ($sAccion == "insert") {
        // Insertar nuevo reclamo
        $sql = "INSERT INTO reclamos (id_cliente, tipo, detalle, fecha_reclamo, estado_reclamo, fecha_solucion) 
                VALUES (?, ?, ?, NOW(), ?, ?)";
        dbQuery($sql, [$id_cliente, $tipo, $detalle, $estado_reclamo, $fecha_solucion]);

        header("Location: reclamo_cliente.php");
        exit(); // Detener ejecución después de redirigir
    } elseif ($sAccion == "update") {
        // Actualizar reclamo existente
        $sql = "UPDATE reclamos 
                SET estado_reclamo = ?, fecha_solucion = ? 
                WHERE id_reclamo = ?";
        dbQuery($sql, [$estado_reclamo, $fecha_solucion, $id_reclamo]);

        header("Location: reclamo_cliente.php");
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
                        <input type="text" name="id_cliente" class="form-control" value="<?= $id_cliente ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="tipo">Tipo de Reclamo:</label>
                        <input type="text" name="tipo" class="form-control" value="<?= $tipo ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="detalle">Descripción del Reclamo:</label>
                        <textarea name="detalle" class="form-control" readonly><?= $detalle ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="fecha_reclamo">Fecha de Reclamo:</label>
                        <input type="text" name="fecha_reclamo" class="form-control" value="<?= $fecha_reclamo ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="estado_reclamo">Estado:</label>
                        <select name="estado_reclamo" class="form-control">
                            <option value="pendiente" <?= $estado_reclamo == 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
                            <option value="resuelto" <?= $estado_reclamo == 'resuelto' ? 'selected' : '' ?>>Resuelto</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="fecha_solucion">Fecha de Solución:</label>
                        <input type="date" name="fecha_solucion" class="form-control" value="<?= $fecha_solucion ?>">
                    </div>

                    <button type="submit" class="btn btn-success">Guardar</button>
                </form>
            </div>
        </div>
    </section>
</div>

<?php include("footer.php"); ?>
<?php ob_end_flush(); // Enviar el contenido del buffer ?>
