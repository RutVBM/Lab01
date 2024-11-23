<?php
session_start();
include("header.php");
include_once("conexion/database.php");

$sAccion = $_GET["sAccion"] ?? null;
$idPago = $_GET["idpago"] ?? null;

// Si no hay un ID de pago, redirigir a facturacion.php
if (!$idPago) {
    header("Location: facturacion.php");
    exit();
}

// Obtener los detalles del pago
$sql = "SELECT * FROM pago_clientes WHERE id_pago = ?";
$result = dbQuery($sql, [$idPago]);

if ($row = mysqli_fetch_assoc($result)) {
    $tipo_plan = ucfirst($row['tipo_plan']);
    $nombre_plan = $row['nombre_plan'];
    $duracion = $row['duracion'];
    $precio = $row['precio'];
    $metodo_pago = $row['metodo_pago'];
    $fecha_pago = $row['fecha_pago'];
} else {
    die("Error: No se encontró el pago con ID $idPago.");
}

include("sidebar.php");
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Detalles del Pago</h1>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-body">
                <h4>Información del Pago</h4>
                <p><strong>ID Pago:</strong> <?= $idPago ?></p>
                <p><strong>Tipo de Plan:</strong> <?= $tipo_plan ?></p>
                <p><strong>Nombre del Plan:</strong> <?= $nombre_plan ?></p>
                <p><strong>Duración:</strong> <?= $duracion ?> meses</p>
                <p><strong>Precio:</strong> S/ <?= $precio ?></p>
                <p><strong>Método de Pago:</strong> <?= $metodo_pago ?></p>
                <p><strong>Fecha de Pago:</strong> <?= $fecha_pago ?></p>

                <a href="generar_factura.php?idpago=<?= $idPago ?>" class="btn btn-primary">Generar Factura</a>
                <a href="facturacion.php" class="btn btn-secondary">Regresar</a>
            </div>
        </div>
    </section>
</div>

<?php include("footer.php"); ?>
