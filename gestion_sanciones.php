<?php
include("header.php");

// Consultar si existe un filtro por estado de sanción
$estado = "";
if (isset($_POST["estado"])) $estado = $_POST["estado"];
?>

<?php
include("sidebar.php");
?>
<script type="text/javascript">
// Función para crear una nueva sanción
function NewSancion() {
    window.location.href = "gestion_sanciones_detalle.php?sAccion=new"; // Redireccionar para crear una nueva sanción
}

function EditSancion(idsancion) {
    window.location.href = "gestion_sanciones_detalle.php?sAccion=edit&idsancion=" + idsancion; // Redireccionar para editar una sanción existente
}
</script>

<!-- Contenido principal -->
<div class="content-wrapper">
  <!-- Encabezado de la página -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Gestión de Sanciones</h1>
        </div>
      </div>
    </div>
  </section>

  <!-- Contenido principal -->
  <section class="content">
    <div class="card">
      <div class="card-header">
        <form action="gestion_sanciones.php" method="post">
          <div class="row">
            <div class="col-6">
              <!-- Filtro por estado de la sanción -->
              <div class="form-group">
                <label>Estado de Sanción:</label>
                <select class="form-control" name="estado">
                  <option value="">TODOS</option>
                  <option value="activa" <?php if ($estado == "activa") echo "selected"; ?>>Activa</option>
                  <option value="inactiva" <?php if ($estado == "inactiva") echo "selected"; ?>>Inactiva</option>
                </select>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <button id="submit" name="button" value="submit" class="btn btn-primary">Consultar</button>
                <button type="button" name="button" value="Nuevo" class="btn btn-success" onclick="javascript:NewSancion();">Nueva Sanción</button>
              </div>
            </div>
          </div>
        </form>
      </div>

      <!-- Consulta para obtener las sanciones -->
      <?php
      $sql = "SELECT `id_sancion`, `idcliente`, `nombre_cliente`, `faltas`, `estado`, `fecha_sancion` FROM `gestion_sanciones` ";
      $sql .= "WHERE id_sancion > 0 ";
      if ($estado != "") $sql .= "AND estado = '$estado' ";
      $sql .= "ORDER BY fecha_sancion DESC";
      $result = dbQuery($sql);
      $total_registros = mysqli_num_rows($result);
      ?>

      <div class="card-body">
        <table id="listado" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>Nombre del Cliente</th>
            <th>Faltas</th>
            <th>Estado</th>
            <th>Fecha de Sanción</th>
            <th>Acciones</th>
          </tr>
          </thead>
          <tbody>
          <?php 
          if ($total_registros > 0) { 
            while ($row = mysqli_fetch_array($result)) {
              $estado_sancion = $row["estado"] == "activa" ? "Activa" : "Inactiva";
              ?>
              <tr>
                <td><?php echo $row["nombre_cliente"]; ?></td>
                <td><?php echo $row["faltas"]; ?></td>
                <td><?php echo $estado_sancion; ?></td>
                <td><?php echo $row["fecha_sancion"]; ?></td>
                <td>
                  <button type="button" class="btn btn-info" onclick="EditSancion(<?php echo $row['id_sancion']; ?>);">Editar</button>
                </td>
              </tr>
              <?php
            } 
          } else {
            echo "<tr><td colspan=5>No existen sanciones registradas</td></tr>";
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

<script>
  $(function () {
    $("#listado").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#listado_wrapper .col-md-6:eq(0)');
  });
</script>
