<?php
ob_start(); // Inicia el buffer de salida

include("header.php");

$sAccion = $_GET["sAccion"] ?? $_POST["sAccion"] ?? "";
$sTitulo = $sAccion == "new" ? "Registrar una nueva captación de cliente" : "Modificar los datos de captación de cliente";
$sCambioAccion = $sAccion == "new" ? "insert" : "update";

if ($sAccion == "edit" && isset($_GET["idcliente"])) {
    $idcliente = $_GET["idcliente"];

    // Consulta preparada para obtener los datos del cliente
    $sql = "SELECT * FROM captacion_clientes WHERE idcliente = ?";
    $result = dbQuery($sql, [$idcliente]);
    $row = $result->fetch_assoc();

    $tipo_cliente = $row["tipo_cliente"];
    $nombre_cliente = $row["nombre_cliente"];
    $contacto = $row["contacto"];
    $estado = $row["estado"];
} else {
    $idcliente = $tipo_cliente = $nombre_cliente = $contacto = "";
    $estado = "A";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $idcliente = $_POST["idcliente"];
    $tipo_cliente = $_POST["tipo_cliente"];
    $nombre_cliente = $_POST["nombre_cliente"];
    $contacto = $_POST["contacto"];
    $estado = $_POST["estado"];

    if ($sCambioAccion == "insert") {
        // Consulta para insertar nueva captación
        $sql = "INSERT INTO captacion_clientes (idcliente, tipo_cliente, nombre_cliente, contacto, estado, fecha_captacion) 
                VALUES (?, ?, ?, ?, ?, CURDATE())";
        dbQuery($sql, [$idcliente, $tipo_cliente, $nombre_cliente, $contacto, $estado]);
    } else {
        // Consulta para actualizar una captación existente
        $sql = "UPDATE captacion_clientes 
                SET tipo_cliente = ?, nombre_cliente = ?, contacto = ?, estado = ? 
                WHERE idcliente = ?";
        dbQuery($sql, [$tipo_cliente, $nombre_cliente, $contacto, $estado, $idcliente]);
    }

    header("Location: captacion_clientes.php?mensaje=success");
    exit();
}

include("sidebar.php");
?>



<!-- Content Wrapper. Contains page content -->
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
                <h3 class="card-title"><?php echo $sAccion == "new" ? "Ingrese los datos del nuevo cliente" : "Modifique los datos del cliente"; ?></h3>
            </div>

            <div class="card-body">
                <form name="frmDatos" action="captacion_clientes_detalle.php" method="post">
                    <input type="hidden" name="sAccion" value="<?php echo $sCambioAccion; ?>">
                    <input type="hidden" name="idcliente" value="<?php echo $idcliente; ?>">

                    <div class="form-group">
                        <label for="tipo_cliente">Tipo de Cliente (*):</label>
                        <select name="tipo_cliente" id="tipo_cliente" class="form-control" required>
                            <option value="individual" <?php if ($tipo_cliente == 'individual') echo 'selected'; ?>>Individual</option>
                            <option value="corporativo" <?php if ($tipo_cliente == 'corporativo') echo 'selected'; ?>>Corporativo</option>
                            <option value="vip" <?php if ($tipo_cliente == 'vip') echo 'selected'; ?>>VIP</option>
                            <option value="familiar" <?php if ($tipo_cliente == 'familiar') echo 'selected'; ?>>Familiar</option>
                            <option value="estudiantil" <?php if ($tipo_cliente == 'estudiantil') echo 'selected'; ?>>Estudiantil</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="nombre_cliente">Nombre del Cliente (*):</label>
                        <input type="text" name="nombre_cliente" id="nombre_cliente" class="form-control" 
                               value="<?php echo $nombre_cliente; ?>" required />
                    </div>

                    <div class="form-group">
                        <label for="contacto">Contacto (*):</label>
                        <input type="text" name="contacto" id="contacto" class="form-control" 
                               value="<?php echo $contacto; ?>" required />
                    </div>

                    <div class="form-group">
                        <label for="estado">Estado:</label>
                        <select name="estado" id="estado" class="form-control">
                            <option value="A" <?php if ($estado == 'A') echo 'selected'; ?>>Activo</option>
                            <option value="I" <?php if ($estado == 'I') echo 'selected'; ?>>Inactivo</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">Guardar</button>
                </form>
            </div>
        </div>
    </section>
</div>

<?php include("footer.php"); ?>
