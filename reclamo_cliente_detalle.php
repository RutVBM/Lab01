<?php
ob_start(); // Inicia el buffer de salida

include("header.php");

$sAccion = $_GET["sAccion"] ?? $_POST["sAccion"] ?? "";
$sTitulo = $sAccion == "new" ? "Registrar un nuevo reclamo" : "Modificar los datos del reclamo";
$sCambioAccion = $sAccion == "new" ? "insert" : "update";

if ($sAccion == "edit" && isset($_GET["id_reclamo"])) {
    $id_reclamo = $_GET["id_reclamo"];
    $sql = "SELECT * FROM reclamos WHERE id_reclamo = $id_reclamo";
    $result = dbQuery($sql);
    $row = mysqli_fetch_array($result);
    $id_cliente = $row["id_cliente"];
    $tipo = $row["tipo"];
    $detalle = $row["detalle"];
    $fecha_reclamo = $row["fecha_reclamo"];
} else {
    $id_reclamo = $id_cliente = $tipo = $detalle = "";
    $fecha_reclamo = date("Y-m-d"); // Fecha actual por defecto
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_reclamo = $_POST["id_reclamo"];
    $id_cliente = $_POST["id_cliente"];
    $tipo = $_POST["tipo"];
    $detalle = $_POST["detalle"];
    $fecha_reclamo = $_POST["fecha_reclamo"];

    if ($sCambioAccion == "insert") {
        $sql = "INSERT INTO reclamos (id_cliente, tipo, detalle, fecha_reclamo) 
                VALUES ('$id_cliente', '$tipo', '$detalle', '$fecha_reclamo')";
    } else {
        $sql = "UPDATE reclamos 
                SET id_cliente = '$id_cliente', tipo = '$tipo', detalle = '$detalle', fecha_reclamo = '$fecha_reclamo' 
                WHERE id_reclamo = $id_reclamo";
    }

    dbQuery($sql);
    header("Location: reclamo_cliente_detalle.php?mensaje=success");
    exit(); // Asegura que no se siga ejecutando código después de la redirección
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
                <form method="post">
                    <input type="hidden" name="sAccion" value="<?= $sCambioAccion ?>">
                    <input type="hidden" name="id_reclamo" value="<?= $id_reclamo ?>">

                    <div class="form-group">
                        <label>ID Cliente (*):</label>
                        <input type="number" name="id_cliente" class="form-control" value="<?= $id_cliente ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Tipo de Reclamo (*):</label>
                        <select name="tipo" class="form-control" required>
                            <option value="Consulta" <?= $tipo == 'Consulta' ? 'selected' : '' ?>>Consulta</option>
                            <option value="Reclamo" <?= $tipo == 'Reclamo' ? 'selected' : '' ?>>Reclamo</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Detalle (*):</label>
                        <textarea name="detalle" class="form-control" required><?= $detalle ?></textarea>
                    </div>

                    <div class="form-group">
                        <label>Fecha de Reclamo (*):</label>
                        <input type="date" name="fecha_reclamo" class="form-control" value="<?= $fecha_reclamo ?>" required>
                    </div>

                    <button type="submit" class="btn btn-success">Guardar</button>
                </form>
            </div>
        </div>
    </section>
</div>

<?php include("footer.php"); ?>
