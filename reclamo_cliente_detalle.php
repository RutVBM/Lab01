<?php
ob_start();
session_start(); // Iniciar sesión para acceder a las variables de sesión
include("header.php");
include_once("conexion/database.php");

// Configura la zona horaria a Perú
date_default_timezone_set('America/Lima');

$sAccion = $_GET["sAccion"] ?? $_POST["sAccion"] ?? "";
$sTitulo = $sAccion == "new" ? "Registrar un nuevo reclamo o consulta" : "Modificar Reclamo";
$id_reclamo = $_POST["id_reclamo"] ?? "";
$id_cliente = $sAccion == "new" ? $_SESSION["CORREO"] : ""; // Usar el correo del usuario logueado si es una nueva entrada
$tipo = $detalle = "";

// Verificar la acción y cargar datos si es necesario
if ($sAccion == "edit" && isset($_GET["id_reclamo"])) {
    $id_reclamo = $_GET["id_reclamo"];

    // Cargar datos del reclamo a editar
    $stmt = dbQuery("SELECT id_cliente, tipo, detalle FROM reclamos WHERE id_reclamo = ?", [$id_reclamo]);
    if ($stmt && $row = $stmt->fetch_assoc()) {
        $id_cliente = $row["id_cliente"];
        $tipo = $row["tipo"];
        $detalle = $row["detalle"];
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
    $fecha_reclamo = date("Y-m-d H:i:s"); // Captura la fecha y hora actual de Perú

    if ($sAccion == "insert") {
        // Insertar nuevo reclamo con fecha y hora automáticas
        $sql = "INSERT INTO reclamos (id_cliente, tipo, detalle, fecha_reclamo) 
                VALUES (?, ?, ?, ?)";
        dbQuery($sql, [$id_cliente, $tipo, $detalle, $fecha_reclamo]);

        header("Location: reclamo_cliente.php?mensaje=success");
        exit();
    } elseif ($sAccion == "update") {
        $sql = "UPDATE reclamos 
                SET tipo = ?, detalle = ? 
                WHERE id_reclamo = ?";
        dbQuery($sql, [$tipo, $detalle, $id_reclamo]);

        header("Location: reclamo_cliente.php?mensaje=success");
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
                <form action="reclamo_cliente_detalle.php" method="post">
                    <input type="hidden" name="sAccion" value="<?= $sAccion == 'new' ? 'insert' : 'update' ?>">
                    <input type="hidden" name="id_reclamo" value="<?= $id_reclamo ?>">
                    <!-- Campo oculto para ID Cliente -->
                    <input type="hidden" name="id_cliente" value="<?= $id_cliente ?>">

                    <!-- Campo para Tipo de Solicitud -->
                    <div class="form-group">
                        <label for="tipo">Tipo de solicitud:</label>
                        <select name="tipo" class="form-control" required>
                            <option value="Consulta" <?= $tipo == 'Consulta' ? 'selected' : '' ?>>Consulta</option>
                            <option value="Reclamo" <?= $tipo == 'Reclamo' ? 'selected' : '' ?>>Reclamo</option>
                        </select>
                    </div>

                    <!-- Campo para Detalle -->
                    <div class="form-group">
                        <label for="detalle">Detalle:</label>
                        <textarea name="detalle" class="form-control" required><?= $detalle ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-success">Guardar</button>
                </form>
            </div>
        </div>
    </section>
</div>

<?php include("footer.php"); ?>
<?php ob_end_flush(); ?>

