<?php
include("header.php");

$sAccion = "";
$sTitulo = "";

if (isset($_GET["sAccion"])) {
    $sAccion = $_GET["sAccion"]; // new / edit
} elseif (isset($_POST["sAccion"])) {
    $sAccion = $_POST["sAccion"]; // insert / update
}

if ($sAccion == "new") {
    $sTitulo = "Registrar un nuevo reclamo";
    $sCambioAccion = "insert";
    $idcliente = "";
    $nombre_cliente = "";
    $descripcion = "";
    $estado = "pendiente"; // Por defecto pendiente
    $fecha_reclamo = date("Y-m-d"); // Fecha actual
} elseif ($sAccion == "edit") {
    $sTitulo = "Modificar reclamo";
    $sCambioAccion = "update";
    if (isset($_GET["idreclamo"])) $idreclamo = $_GET["idreclamo"];
    
    // Obtener datos del reclamo a editar
    $sql = "SELECT * FROM atencion_reclamos WHERE idreclamo = $idreclamo";
    $result = dbQuery($sql);
    if ($row = mysqli_fetch_array($result)) {
        $idcliente = $row["idcliente"];
        $nombre_cliente = $row["nombre_cliente"];
        $descripcion = $row["descripcion"];
        $estado = $row["estado"];
        $fecha_reclamo = $row["fecha_reclamo"];
    }
} elseif ($sAccion == "insert") {
    $idcliente = $_POST["idcliente"];
    $nombre_cliente = $_POST["nombre_cliente"];
    $descripcion = $_POST["descripcion"];
    $estado = $_POST["estado"];
    $fecha_reclamo = date("Y-m-d");

    // Insertar un nuevo reclamo
    $sql = "INSERT INTO atencion_reclamos (idcliente, nombre_cliente, descripcion, estado, fecha_reclamo) 
            VALUES ('$idcliente', '$nombre_cliente', '$descripcion', '$estado', '$fecha_reclamo')";
    dbQuery($sql);
    
    // Redirigir después de insertar
    header("Location: atencion_reclamos.php");
} elseif ($sAccion == "update") {
    $idreclamo = $_POST["idreclamo"];
    $idcliente = $_POST["idcliente"];
    $nombre_cliente = $_POST["nombre_cliente"];
    $descripcion = $_POST["descripcion"];
    $estado = $_POST["estado"];
    
    // Actualizar reclamo existente
    $sql = "UPDATE atencion_reclamos SET idcliente = '$idcliente', nombre_cliente = '$nombre_cliente', 
            descripcion = '$descripcion', estado = '$estado' WHERE idreclamo = $idreclamo";
    dbQuery($sql);
    
    // Redirigir después de actualizar
    header("Location: atencion_reclamos.php");
}
?>

<?php
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
                <h3 class="card-title">Por favor, complete los datos del reclamo:</h3>
            </div>

            <div class="card-body">
                <form name="frmDatos" action="atencion_reclamos_detalle.php" method="post">
                    <input type="text" name="sAccion" value="<?php echo $sCambioAccion; ?>" hidden>
                    <input type="text" name="idreclamo" value="<?php echo $idreclamo; ?>" hidden>

                    <div class="form-group">
                        <label for="idcliente">ID Cliente (*):</label>
                        <input type="text" name="idcliente" id="idcliente" class="form-control" value="<?php echo $idcliente; ?>" required />
                    </div>

                    <div class="form-group">
                        <label for="nombre_cliente">Nombre del Cliente (*):</label>
                        <input type="text" name="nombre_cliente" id="nombre_cliente" class="form-control" value="<?php echo $nombre_cliente; ?>" required />
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Descripción del Reclamo (*):</label>
                        <textarea name="descripcion" id="descripcion" class="form-control" required><?php echo $descripcion; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="estado">Estado:</label>
                        <select name="estado" id="estado" class="form-control">
                            <option value="pendiente" <?php if($estado == 'pendiente') echo 'selected'; ?>>Pendiente</option>
                            <option value="resuelto" <?php if($estado == 'resuelto') echo 'selected'; ?>>Resuelto</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">Guardar</button>
                </form>
            </div>
        </div>
    </section>
</div>

<?php
include("footer.php");
?>
