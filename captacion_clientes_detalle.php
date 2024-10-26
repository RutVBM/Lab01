<?php
ob_start();
include_once("header.php");
include_once("conexion/database.php");

$sAccion = $_GET["sAccion"] ?? $_POST["sAccion"] ?? "";
$sTitulo = $sAccion == "new" ? "Registrar Captación de Cliente" : "Editar Captación";
$sCambioAccion = $sAccion == "new" ? "insert" : "update";

if ($sAccion == "edit" && isset($_GET["idcaptacion"])) {
    $idcaptacion = $_GET["idcaptacion"];
    $stmt = dbQuery("SELECT * FROM captacion_clientes WHERE idcaptacion = ?", [$idcaptacion]);
    $row = $stmt->fetch_assoc();
    $tipo_cliente = $row["tipo_cliente"];
    $nombre_cliente = $row["nombre_cliente"];
    $contacto = $row["contacto"];
    $estado = $row["estado"];
} else {
    $idcaptacion = $tipo_cliente = $nombre_cliente = $contacto = "";
    $estado = "A";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $idcaptacion = $_POST["idcaptacion"];
    $tipo_cliente = $_POST["tipo_cliente"];
    $nombre_cliente = $_POST["nombre_cliente"];
    $contacto = $_POST["contacto"];
    $estado = $_POST["estado"];

    if ($sCambioAccion == "insert") {
        $sql = "INSERT INTO captacion_clientes (tipo_cliente, nombre_cliente, contacto, estado, fecha_captacion) 
                VALUES (?, ?, ?, ?, NOW())";
        dbQuery($sql, [$tipo_cliente, $nombre_cliente, $contacto, $estado]);
    } else {
        $sql = "UPDATE captacion_clientes 
                SET tipo_cliente = ?, nombre_cliente = ?, contacto = ?, estado = ? 
                WHERE idcaptacion = ?";
        dbQuery($sql, [$tipo_cliente, $nombre_cliente, $contacto, $estado, $idcaptacion]);
    }

    header("Location: captacion_clientes.php?mensaje=success");
    exit();
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1><?= $sTitulo ?></h1>
    </section>

    <section class="content">
        <form method="post">
            <input type="hidden" name="idcaptacion" value="<?= $idcaptacion ?>">

            <div class="form-group">
                <label>Tipo de Cliente:</label>
                <select name="tipo_cliente" class="form-control" required>
                    <option value="Individual" <?= $tipo_cliente == 'Individual' ? 'selected' : '' ?>>Individual</option>
                    <option value="Corporativo" <?= $tipo_cliente == 'Corporativo' ? 'selected' : '' ?>>Corporativo</option>
                    <option value="VIP" <?= $tipo_cliente == 'VIP' ? 'selected' : '' ?>>VIP</option>
                    <option value="Familiar" <?= $tipo_cliente == 'Familiar' ? 'selected' : '' ?>>Familiar</option>
                </select>
            </div>

            <div class="form-group">
                <label>Nombre del Cliente:</label>
                <input type="text" name="nombre_cliente" class="form-control" value="<?= $nombre_cliente ?>" required>
            </div>

            <div class="form-group">
                <label>Contacto:</label>
                <input type="text" name="contacto" class="form-control" value="<?= $contacto ?>" required>
            </div>

            <div class="form-group">
                <label>Estado:</label>
                <select name="estado" class="form-control">
                    <option value="A" <?= $estado == 'A' ? 'selected' : '' ?>>Activo</option>
                    <option value="I" <?= $estado == 'I' ? 'selected' : '' ?>>Inactivo</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Guardar</button>
        </form>
    </section>
</div>

<?php include_once("footer.php"); ?>
