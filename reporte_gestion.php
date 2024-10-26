<?php
include ("header.php");

// Filtrar por tipo de reporte si es necesario
$tipo_reporte = "";
if (isset($_POST["tipo_reporte"])) $tipo_reporte = $_POST["tipo_reporte"];
?>

<?php
include ("sidebar.php");
?>
<script type="text/javascript">
// Función para crear un nuevo reporte de gestión
function NewReporte() {
    window.location.href = "reporte_gestion_detalle.php?sAccion=new"; // Redireccionar para crear un nuevo reporte
}

function EditReporte(id_reporte_gestion) {
    window.location.href = "reporte_gestion_detalle.php?sAccion=edit&id_reporte_gestion=" + id_reporte_gestion; // Redireccionar para editar un reporte existente
}
</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Lista de Reportes de Gestión</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <form action="reporte_gestion.php" method="post">
          <div class="row">
            <div class="col-6">
              <!-- Select para tipo de reporte -->
              <div class="form-group">
                <label>Tipo de Reporte:</label>
                <select class="form-control" name="tipo_reporte">
                  <option value="">TODOS</option>
                  <option value="reclamos" <?php if ($tipo_reporte == "reclamos") echo "selected"; ?>>Reclamos Atendidos</option>
                  <option value="sanciones" <?php if ($tipo_reporte == "sanciones") echo "selected"; ?>>Sanciones Aplicadas</option>
                </select>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <button id="submit" name="button" value="submit" class="btn btn-primary">Consultar</button>
                <button type="button" name="button" value="Nuevo" class="btn btn-success" onclick="javascript:NewReporte();">Nuevo Reporte</button>
              </div>
            </div>
          </div>
        </form>
      </div>
      <!-- /.card-header -->

      <?php
      // Consulta para obtener los reportes de gestión
      $sql = "SELECT `id_reporte_gestion`, `tipo_reporte`, `cantidad_reclamos`, `cantidad_sanciones`, `tiempo_promedio_resolucion`, `satisfaccion_cliente`, `fecha_generacion` FROM `reporte_gestion` ";
      $sql .= "WHERE id_reporte_gestion > 0 ";
      if ($tipo_reporte != "") $sql .= "AND tipo_reporte = '$tipo_reporte' ";
      $sql .= "ORDER BY fecha_generacion DESC ";
      $result = dbQuery($sql);
      $total_registros = mysqli_num_rows($result);
      ?>

      <div class="card-body">
        <table id="listado" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>Tipo de Reporte</th>
            <th>Cantidad de Reclamos</th>
            <th>Cantidad de Sanciones</th>
            <th>Tiempo Promedio Resolución</th>
            <th>Satisfacción del Cliente</th>
            <th>Fecha de Generación</th>
            <th>Acciones</th>
          </tr>
          </thead>
          <tbody>
          <?php 
          if ($total_registros > 0) { // Existen datos
            while ($row = mysqli_fetch_array($result)) {
              ?>
              <tr>
                <td><?php echo ucfirst($row["tipo_reporte"]); ?></td>
                <td><?php echo $row["cantidad_reclamos"]; ?></td>
                <td><?php echo $row["cantidad_sanciones"]; ?></td>
                <td><?php echo $row["tiempo_promedio_resolucion"]; ?> horas</td>
                <td><?php echo $row["satisfaccion_cliente"]; ?> / 5</td>
                <td><?php echo $row["fecha_generacion"]; ?></td>
                <td>
                  <button type="button" class="btn btn-info" onclick="EditReporte(<?php echo $row['id_reporte_gestion']; ?>);">Editar</button>
                </td>
              </tr>
              <?php
            } 
          } else { // No existen datos
            echo "<tr><td colspan=7>No existen registros</td></tr>";
          }
          ?>
          </tbody>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
include ("footer.php");
?>

<!-- Page specific script -->
<script>
  $(function () {
    $("#listado").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#listado_wrapper .col-md-6:eq(0)');
  });
</script>
