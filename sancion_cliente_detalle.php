<?php
ob_start();
include("header.php");
include_once("conexion/database.php");

// Configura la zona horaria a Perú
date_default_timezone_set('America/Lima');

$sAccion = $_GET["sAccion"] ?? $_POST["sAccion"] ?? "";
$sTitulo = $sAccion == "new" ? "Registrar una nueva sanción" : "Modificar Sanción";
$id_sancion = $_POST["id_sancion"] ?? "";
$idcliente = $nombre_cliente = $faltas = $estado = $fecha_sancion = "";

// Verificar la acción y cargar datos si es necesario
if ($sAccion == "edit" && isset($_GET["id_sancion"])) {
    $id_sancion = $_GET["id_sancion"];

    // Cargar datos de la sanción a editar
    $stmt = dbQuery("SELECT idcliente, nombre_cliente, faltas, estado, fecha_sancion FROM gestion_sanciones WHERE id_sancion = ?", [$id_sancion]);
    if ($stmt && $row = $stmt->fetch_assoc()) {
        $idcliente = $row["idcliente"];
        $nombre_cliente = $row["nombre_cliente"];
        $faltas = $row["faltas"];
        $estado = $row["estado"];
        $fecha_sancion = $row["fecha_sancion"];
    } else {
        echo "Error: Sanción no encontrada.";
        exit();
    }
}

// Procesar actualización de datos
if ($_SERVER["REQUEST_METHOD"] === "POST" && $sAccion == "update") {
    $estado = $_POST["estado"];
    $faltas = $_POST["faltas"];
    $id_sancion = $_POST["id_sancion"];

    // Actualizar sanción existente
    $sql = "UPDATE gestion_sanciones 
            SET estado = ?, faltas = ? 
            WHERE id_sancion = ?";
    dbQuery($sql, [$estado, $faltas, $id_sancion]);

    header("Location: sancion_cliente.php?mensaje=success");
    exit();
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
            <div class="card-body">
                <form action="sancion_cliente_detalle.php" method="post">
                    <input type="hidden" name="sAccion" value="update">
                    <input type="hidden" name="id_sancion" value="<?= $id_sancion ?>">

                    <!-- Campos de solo lectura -->
                    <div class="form-group">
                        <label for="idcliente">ID Cliente:</label>
                        <input type="text" name="idcliente" class="form-control-plaintext" value="<?= $idcliente ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="nombre_cliente">Nombre del Cliente:</label>
                        <input type="text" name="nombre_cliente" class="form-control-plaintext" value="<?= $nombre_cliente ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="fecha_sancion">Fecha de Sanción:</label>
                        <input type="text" name="fecha_sancion" class="form-control-plaintext" value="<?= $fecha_sancion ?>" readonly>
                    </div>

                    <!-- Campos editables -->
                    <div class="form-group">
                        <label for="faltas">Faltas:</label>
                        <input type="number" name="faltas" class="form-control" value="<?= $faltas ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="estado">Estado:</label>
                        <select name="estado" class="form-control" required>
                            <option value="A" <?= $estado == 'A' ? 'selected' : '' ?>>Activo</option>
                            <option value="B" <?= $estado == 'B' ? 'selected' : '' ?>>Bloqueado</option>
                            <option value="I" <?= $estado == 'I' ? 'selected' : '' ?>>Inactivo</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">Guardar</button>
                </form>
            </div>
        </div>
    </section>
</div>

<?php include("footer.php"); ?>
<?php ob_end_flush(); ?>
