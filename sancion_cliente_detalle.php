<?php
ob_start();
include("header.php");
include_once("conexion/database.php");

// Configura la zona horaria a Perú
date_default_timezone_set('America/Lima');

// Inicialización de variables
$sAccion = "view";  // Forzamos el modo de solo lectura
$sTitulo = "Ver Detalle de Sanción";
$id_sancion = $_GET["id_sancion"] ?? "";

$idcliente = $nombre_cliente = $faltas = $estado = $fecha_sancion = "";

// Verificar la acción y cargar datos si se proporciona un `id_sancion`
if ($id_sancion) {
    // Cargar datos de la sanción
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
                <!-- Campos de solo lectura -->
                <div class="form-group">
                    <label for="idcliente">ID Cliente:</label>
                    <input type="text" class="form-control-plaintext" value="<?= $idcliente ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="nombre_cliente">Nombre del Cliente:</label>
                    <input type="text" class="form-control-plaintext" value="<?= $nombre_cliente ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="fecha_sancion">Fecha de Sanción:</label>
                    <input type="text" class="form-control-plaintext" value="<?= $fecha_sancion ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="faltas">Faltas:</label>
                    <input type="text" class="form-control-plaintext" value="<?= $faltas ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="estado">Estado:</label>
                    <input type="text" class="form-control-plaintext" value="<?= $estado ?>" readonly>
                </div>

                <a href="sancion_cliente.php" class="btn btn-secondary">Regresar</a>
            </div>
        </div>
    </section>
</div>

<?php include("footer.php"); ?>
<?php ob_end_flush(); ?>
