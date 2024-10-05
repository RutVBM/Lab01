<?php
include("header.php");

$limite_faltas = 5;  // Límite de faltas antes de sancionar
?>

<?php
include("sidebar.php");
?>

<script type="text/javascript">
// Funcion para sancionar a un cliente
function SancionarCliente(id_sancion) {
    window.location.href = "gestion_sancion_detalle.php?sAccion=sancionar&id_sancion=" + id_sancion; // Redirigir para sancionar
}
</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Gestión de Sanciones</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <form action="gestion_sancion.php" method="post">
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label>Tipo de Cliente:</label>
                <select class="form-control" name="tipo_cliente">
                  <option value="">TODOS</option>
                  <option value="individual">Individual</option>
                  <option value="corporativo">Corporativo</option>
                  <option value="vip">VIP</option>
                  <option value="familiar">Familiar</option>
                  <option value="estudiantil">Estudiantil</option>
                </select>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <button id="submit" name="button" value="submit" class="btn btn-primary">Consultar</button>
              </div>
            </div>
          </div>
        </form>
      </div>

      <?php
      // Consulta para obtener la lista de sanciones registradas
      $sql = "SELECT s.id_sancion, s.idcliente, c.nombre_cliente, s.faltas, s.estado FROM gestion_sanciones s
              JOIN cliente c ON s.idcliente = c.idcliente";
      if (isset($_POST['tipo_cliente']) && $_POST['tipo_cliente'] != "") {
          $sql .= " AND c.tipo_cliente = '" . $_POST['tipo_cliente'] . "'";
      }
      $sql .= " ORDER BY c.nombre_cliente";
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
            <th>Acciones</th>
          </tr>
          </thead>
          <tbody>
          <?php 
          if ($total_registros > 0) { // Existen datos
            while ($row = mysqli_fetch_array($result)) {
              $estado = $row["estado"] == "A" ? "Activo" : ($row["estado"] == "B" ? "Bloqueado" : "Inactivo");
              ?>
              <tr>
                <td><?php echo $row["nombre_cliente"]; ?></td>
                <td><?php echo $row["faltas"]; ?></td>
                <td><?php echo $estado; ?></td>
                <td>
                  <?php if ($row["faltas"] >= $limite_faltas) { ?>
                    <button type="button" class="btn btn-danger" onclick="SancionarCliente(<?php echo $row['id_sancion']; ?>);">Sancionar</button>
                  <?php } ?>
                </td>
              </tr>
              <?php
            } 
          } else { // No existen datos
            echo "<tr><td colspan=4>No existen registros</td></tr>";
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
