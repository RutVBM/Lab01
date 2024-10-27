<?php
include("header.php");

$sAccion = "";
$sTitulo = "";
$sSubTitulo = "";

if (isset($_GET["sAccion"])) {
    $sAccion = $_GET["sAccion"];
} elseif (isset($_POST["sAccion"])) {
    $sAccion = $_POST["sAccion"];
}

// Variables por defecto
$id_reporte_gestion = "";
$tipo_reporte = "";
$cantidad_reclamos = 0;
$cantidad_sanciones = 0;
$tiempo_promedio_resolucion = 0;
$satisfaccion_cliente = 0;
$observaciones = "";

// Lógica para "Nuevo" o "Editar"
if ($sAccion == "new") {
    $sTitulo = "Registrar un nuevo reporte de gestión";
    $sSubTitulo = "Por favor, ingresa la información del reporte [(*) campos obligatorios]:";
    $sCambioAccion = "insert";
    $fecha_generacion = date("Y-m-d H:i:s");
} elseif ($sAccion == "edit") {
    $sTitulo = "Modificar los datos del reporte de gestión";
    $sSubTitulo = "Actualiza la información del reporte:";
    $sCambioAccion = "update";

    if (isset($_GET["id_reporte_gestion"])) {
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
}
?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><?php echo $sTitulo; ?></h1>
          <p><?php echo $sSubTitulo; ?></p>
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
            <label for="tipo_reporte">Tipo de Reporte (*)</label>
            <select class="form-control" name="tipo_reporte" required>
              <option value="reclamos" <?php if ($tipo_reporte == "reclamos") echo "selected"; ?>>Reclamos</option>
              <option value="sanciones" <?php if ($tipo_reporte == "sanciones") echo "selected"; ?>>Sanciones</option>
              <option value="captacion" <?php if ($tipo_reporte == "captacion") echo "selected"; ?>>Captación de Clientes</option>
            </select>
          </div>

          <div class="form-group">
            <label for="cantidad_reclamos">Cantidad de Reclamos</label>
            <input type="number" class="form-control" name="cantidad_reclamos" value="<?php echo $cantidad_reclamos; ?>">
          </div>

          <div class="form-group">
            <label for="cantidad_sanciones">Cantidad de Sanciones</label>
            <input type="number" class="form-control" name="cantidad_sanciones" value="<?php echo $cantidad_sanciones; ?>">
          </div>

          <div class="form-group">
            <label for="tiempo_promedio_resolucion">Tiempo Promedio de Resolución (horas)</label>
            <input type="number" class="form-control" name="tiempo_promedio_resolucion" value="<?php echo $tiempo_promedio_resolucion; ?>">
          </div>

          <div class="form-group">
            <label for="satisfaccion_cliente">Satisfacción del Cliente (1-5)</label>
            <input type="number" class="form-control" name="satisfaccion_cliente" value="<?php echo $satisfaccion_cliente; ?>" min="1" max="5">
          </div>

          <div class="form-group">
            <label for="observaciones">Observaciones</label>
            <textarea class="form-control" name="observaciones"><?php echo $observaciones; ?></textarea>
          </div>

          <button type="submit" class="btn btn-primary">Guardar</button>
          <a href="reporte_gestion.php" class="btn btn-secondary">Cancelar</a>
        </form>
      </div>
    </div>
  </section>
</div>

<?php include("footer.php"); ?>

<?php
// Lógica para insertar o actualizar datos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo_reporte = $_POST["tipo_reporte"];
    $cantidad_reclamos = $_POST["cantidad_reclamos"];
    $cantidad_sanciones = $_POST["cantidad_sanciones"];
    $tiempo_promedio_resolucion = $_POST["tiempo_promedio_resolucion"];
    $satisfaccion_cliente = $_POST["satisfaccion_cliente"];
    $observaciones = $_POST["observaciones"];

    if ($sAccion == "insert") {
        $sql = "INSERT INTO reporte_gestion (tipo_reporte, cantidad_reclamos, cantidad_sanciones, tiempo_promedio_resolucion, satisfaccion_cliente, observaciones, fecha_generacion) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("siiiiss", $tipo_reporte, $cantidad_reclamos, $cantidad_sanciones, $tiempo_promedio_resolucion, $satisfaccion_cliente, $observaciones, $fecha_generacion);
    } elseif ($sAccion == "update") {
        $sql = "UPDATE reporte_gestion SET tipo_reporte=?, cantidad_reclamos=?, cantidad_sanciones=?, tiempo_promedio_resolucion=?, satisfaccion_cliente=?, observaciones=? WHERE id_reporte_gestion=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("siiiisi", $tipo_reporte, $cantidad_reclamos, $cantidad_sanciones, $tiempo_promedio_resolucion, $satisfaccion_cliente, $observaciones, $id_reporte_gestion);
    }
    
    $stmt->execute();
    header("Location: reporte_gestion.php");
    exit();
}
?>
