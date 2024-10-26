<?php
include("header.php");

// Filtrar por estado de reclamo si es necesario
$estado = "";
if (isset($_POST["estado"])) $estado = $_POST["estado"];
?>

<?php
include("sidebar.php");
?>
<script type="text/javascript">
// Función para crear una nueva atención de reclamo
function NewReclamo() {
    window.location.href = "atencion_reclamos_detalle.php?sAccion=new"; // Redireccionar para crear una nueva atención de reclamo
}

function EditReclamo(idreclamo) {
    window.location.href = "atencion_reclamos_detalle.php?sAccion=edit&idreclamo=" + idreclamo; // Redireccionar para editar un reclamo existente
}
</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Atención de Consultas y Reclamos</h1>
        </div>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="card">
      <div class="card-header">
        <form action="atencion_reclamos.php" method="post">
          <div class="row">
            <div class="col-6">
              <!-- Select para estado de reclamo -->
              <div class="form-group">
                <label>Estado de Reclamo:</label>
                <select class="form-control" name="estado">
                  <option value="">TODOS</option>
                  <option value="pendiente" <?php if ($estado == "pendiente") echo "selected"; ?>>Pendiente</option>
                  <option value="resuelto" <?php if ($estado == "resuelto") echo "selected"; ?>>Resuelto</option>
                </select>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <button id="submit" name="button" value="submit" class="btn btn-primary">Consultar</button>
                <button type="button" name="button" value="Nuevo" class="btn btn-success" onclick="javascript:NewReclamo();">Nuevo Reclamo</button>
              </div>
            </div>
          </div>
        </form>
      </div>

      <?php
      // Consulta para obtener los reclamos
      $sql = "SELECT `idreclamo`, `idcliente`, `nombre_cliente`, `descripcion`, `estado`, `fecha_reclamo` FROM `atencion_reclamos` ";
      $sql .= "WHERE idreclamo > 0 ";
      if ($estado != "") $sql .= "AND estado = '$estado' ";
      $sql .= "ORDER BY fecha_reclamo DESC";
      $result = dbQuery($sql);
      $total_registros = mysqli_num_rows($result);
      ?>

      <div class="card-body">
        <table id="listado" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>Nombre del Cliente</th>
            <th>Descripción</th>
            <th>Estado</th>
            <th>Fecha de Reclamo</th>
            <th>Acciones</th>
          </tr>
          </thead>
          <tbody>
          <?php 
          if ($total_registros > 0) { // Existen datos
            while ($row = mysqli_fetch_array($result)) {
              $estado_reclamo = $row["estado"] == "pendiente" ? "Pendiente" : "Resuelto";
              ?>
              <tr>
                <td><?php echo $row["nombre_cliente"]; ?></td>
                <td><?php echo $row["descripcion"]; ?></td>
                <td><?php echo $estado_reclamo; ?></td>
                <td><?php echo $row["fecha_reclamo"]; ?></td>
                <td>
                  <button type="button" class="btn btn-info" onclick="EditReclamo(<?php echo $row['idreclamo']; ?>);">Editar</button>
                </td>
              </tr>
              <?php
            } 
          } else { // No existen datos
            echo "<tr><td colspan=5>No existen reclamos registrados</td></tr>";
          }
          ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>

<?php
include("footer.php");
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
