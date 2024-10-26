<?php
include("header.php");

$sAccion = "";
$sTitulo = "";

if (isset($_GET["sAccion"])) {
    $sAccion = $_GET["sAccion"]; 
} elseif (isset($_POST["sAccion"])) {
    $sAccion = $_POST["sAccion"];
}

if ($sAccion == "new") {
    $sTitulo = "Registrar una nueva sanción";
    $sCambioAccion = "insert";
    $idcliente = "";
    $nombre_cliente = "";
    $faltas = "";
    $estado = "activa";
    $fecha_sancion = date("Y-m-d");
}
elseif ($sAccion == "edit") {
    $sTitulo = "Modificar sanción";
    $sCambioAccion = "update";
    if (isset($_GET["idsancion"])) $idsancion = $_GET["idsancion"];
    
    $sql = "SELECT * FROM gestion_sanciones WHERE id_sancion = $idsancion";
    $result = dbQuery($sql);
    if ($row = mysqli_fetch_array($result)) {
        $idcliente = $row["idcliente"];
        $nombre_cliente = $row["nombre_cliente"];
        $faltas = $row["faltas"];
        $estado = $row["estado"];
        $fecha_sancion = $row["fecha_sancion"];
    }
}
elseif ($sAccion == "insert") {
    $idcliente = $_POST["idcliente"];
    $nombre_cliente = $_POST["nombre_cliente"];
    $faltas = $_POST["faltas"];
    $estado = $_POST["estado"];
    $fecha_sancion = date("Y-m-d");
    
    $sql = "INSERT INTO gestion_sanciones (idcliente, nombre_cliente, faltas, estado, fecha_sancion) 
            VALUES ('$idcliente', '$nombre_cliente', '$faltas', '$estado', '$fecha_sancion')";
    dbQuery($sql);
    
    header("Location: gestion_sanciones.php");
}
elseif ($sAccion == "update") {
    $idsancion = $_POST["idsancion"];
    $idcliente = $_POST["idcliente"];
    $nombre_cliente = $_POST["nombre_cliente"];
    $faltas = $_POST["faltas"];
    $estado = $_POST["estado"];
    
    $sql = "UPDATE gestion_sanciones SET idcliente = '$idcliente', nombre_cliente = '$nombre_cliente', faltas = '$faltas', estado = '$estado' 
            WHERE id_sancion = $idsancion";
    dbQuery($sql);
    
    header("Location: gestion_sanciones.php");
}
?>

<?php
include("sidebar.php");
?>

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
                <h3 class="card-title">Complete los datos de la sanción:</h3>
            </div>

            <div class="card-body">
                <form name="frmDatos" action="gestion_sanciones_detalle.php" method="post">
                    <input type="text" name="sAccion" value="<?php echo $sCambioAccion; ?>" hidden>
                    <input type="text" name="idsancion" value="<?php echo $idsancion; ?>" hidden>

                    <div class="form-group">
                        <label for="idcliente">ID Cliente (*):</label>
                        <input type="text" name="idcliente" id="idcliente" class="form-control" value="<?php echo $idcliente; ?>" required />
                    </div>

                    <div class="form-group">
                        <label for="nombre_cliente">Nombre del Cliente (*):</label>
                        <input type="text" name="nombre_cliente" id="nombre_cliente" class="form-control" value="<?php echo $nombre_cliente; ?>" required />
                    </div>

                    <div class="form-group">
                        <label for="faltas">Faltas (*):</label>
                        <input type="number" name="faltas" id="faltas" class="form-control" value="<?php echo $faltas; ?>" required />
                    </div>

                    <div class="form-group">
                        <label for="estado">Estado:</label>
                        <select name="estado" id="estado" class="form-control">
                            <option value="activa" <?php if($estado == 'activa') echo 'selected'; ?>>Activa</option>
                            <option value="inactiva" <?php if($estado == 'inactiva') echo 'selected'; ?>>Inactiva</option>
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
