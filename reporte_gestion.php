<?php
include("header.php");

// Filtrar por tipo de reporte si es necesario
$tipo_reporte = "";
if (isset($_POST["tipo_reporte"])) $tipo_reporte = $_POST["tipo_reporte"];

include("sidebar.php");
?>

<script type="text/javascript">
function NewReporte() {
    window.location.href = "reporte_gestion_detalle.php?sAccion=new";
}

function EditReporte(id_reporte_gestion) {
    window.location.href = "reporte_gestion_detalle.php?sAccion=edit&id_reporte_gestion=" + id_reporte_gestion;
}
</script>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Lista de Reportes de Gestión</h1>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="card">
      <div class="card-header">
        <form action="reporte_gestion.php" method="post">
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label>Tipo de Reporte:</label>
                <select class="form-control" name="tipo_reporte">
                  <option value="">TODOS</option>
                  <option value="reclamos" <?php if ($tipo_reporte == "reclamos") echo "selected"; ?>>Reclamos Atendidos</option>
                  <option value="sanciones" <?php if ($tipo_reporte == "sanciones") echo "selected"; ?>>Sanciones Aplicadas</option>
                  <option value="captacion" <?php if ($tipo_reporte == "captacion") echo "selected"; ?>>Captación de Clientes</option>
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

      <?php
      // Consulta SQL corregida para obtener los reportes combinados
      $sql = "
        SELECT rg.id_reporte_gestion, rg.tipo_reporte, rg.cantidad_reclamos, rg.cantidad_sanciones, 
               rg.tiempo_promedio_resolucion, rg.satisfaccion_cliente, rg.fecha_generacion,
               COUNT(r.id_reclamo) AS reclamos_resueltos, 
               COUNT(s.id_sancion) AS sanciones_aplicadas, 
               COUNT(c.idcaptacion) AS captacion_total
        FROM reporte_gestion rg
        LEFT JOIN reclamos r ON r.estado_reclamo = 'E' AND r.id_reclamo = rg.idreclamo
        LEFT JOIN gestion_sanciones s ON s.id_sancion = rg.id_sancion
        LEFT JOIN captacion_clientes c ON c.idcliente = rg.idusuario
        WHERE rg.id_reporte_gestion > 0 ";

      if ($tipo_reporte != "") {
        $sql .= "AND rg.tipo_reporte = '$tipo_reporte' ";
      }

      $sql .= "GROUP BY rg.id_reporte_gestion ORDER BY rg.fecha_generacion DESC";
      $result = dbQuery($sql);
      $total_registros = mysqli_num_rows($result);
      ?>

      <div class="card-body">
        <table id="listado" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Tipo de Reporte</th>
              <th>Reclamos Resueltos</th>
              <th>Sanciones Aplicadas</th>
              <th>Clientes Captados</th>
              <th>Tiempo Promedio Resolución</th>
              <th>Satisfacción del Cliente</th>
              <th>Fecha de Generación</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
          <?php 
          if ($total_registros > 0) {
            while ($row = mysqli_fetch_array($result)) {
              ?>
              <tr>
                <td><?php echo ucfirst($row["tipo_reporte"]); ?></td>
                <td><?php echo $row["reclamos_resueltos"]; ?></td>
                <td><?php echo $row["sanciones_aplicadas"]; ?></td>
                <td><?php echo $row["captacion_total"]; ?></td>
                <td><?php echo $row["tiempo_promedio_resolucion"]; ?> horas</td>
                <td><?php echo $row["satisfaccion_cliente"]; ?> / 5</td>
                <td><?php echo $row["fecha_generacion"]; ?></td>
                <td>
                  <button type="button" class="btn btn-info" onclick="EditReporte(<?php echo $row['id_reporte_gestion']; ?>);">Editar</button>
                </td>
              </tr>
              <?php
            }
          } else {
            echo "<tr><td colspan=8>No existen registros</td></tr>";
          }
          ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>

<?php include("footer.php"); ?>

<script>
  $(function () {
    $("#listado").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "buttons": ["excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#listado_wrapper .col-md-6:eq(0)');
  });
</script>
