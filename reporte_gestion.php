<?php
include("header.php");

$sAccion = isset($_GET["sAccion"]) ? $_GET["sAccion"] : (isset($_POST["sAccion"]) ? $_POST["sAccion"] : "");

// Variables por defecto
$id_reporte_gestion = "";
$tipo_reporte = "";
$cantidad_reclamos = 0;
$cantidad_sanciones = 0;
$tiempo_promedio_resolucion = 0;
$satisfaccion_cliente = 0;
$observaciones = "";

if ($sAccion == "new") {
    $sTitulo = "Registrar un nuevo reporte de gestión";
    $sCambioAccion = "insert";
    $fecha_generacion = date("Y-m-d H:i:s");
} elseif ($sAccion == "edit" && isset($_GET["id_reporte_gestion"])) {
    $sTitulo = "Modificar los datos del reporte de gestión";
    $sCambioAccion = "update";
    $id_reporte_gestion = $_GET["id_reporte_gestion"];

    $sql = "SELECT * FROM reporte_gestion WHERE id_reporte_gestion = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_reporte_gestion);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $tipo_reporte = $row["tipo_reporte"];
        $cantidad_reclamos = $row["cantidad_reclamos"];
        $cantidad_sanciones = $row["cantidad_sanciones"];
        $tiempo_promedio_resolucion = $row["tiempo_promedio_resolucion"];
        $satisfaccion_cliente = $row["satisfaccion_cliente"];
        $observaciones = $row["observaciones"];
        $fecha_generacion = $row["fecha_generacion"];
    }
}
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
      <div class="card-body">
        <form action="reporte_gestion_detalle.php" method="post">
          <input type="hidden" name="sAccion" value="<?php echo $sCambioAccion; ?>">
          <input type="hidden" name="id_reporte_gestion" value="<?php echo $id_reporte_gestion; ?>">

          <div class="form-group">
            <label>Tipo de Reporte (*)</label>
            <select class="form-control" name="tipo_reporte" required>
              <option value="reclamos" <?php if ($tipo_reporte == "reclamos") echo "selected"; ?>>Reclamos</option>
              <option value="sanciones" <?php if ($tipo_reporte == "sanciones") echo "selected"; ?>>Sanciones</option>
              <option value="captacion" <?php if ($tipo_reporte == "captacion") echo "selected"; ?>>Captación de Clientes</option>
            </select>
          </div>

          <button type="submit" class="btn btn-primary">Guardar</button>
          <a href="reporte_gestion.php" class="btn btn-secondary">Cancelar</a>
        </form>
      </div>
    </div>
  </section>
</div>

<?php include("footer.php"); ?>
