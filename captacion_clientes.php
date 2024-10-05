<?php
include ("header.php");

// Filtrar por tipo de cliente si es necesario
$tipo_cliente = "";
if (isset($_POST["tipo_cliente"])) $tipo_cliente = $_POST["tipo_cliente"];
?>

<?php
include ("sidebar.php");
?>
<script type="text/javascript">
// Funcion para registrar una nueva captación de cliente
function NewCaptacion() {
    window.location.href = "captacion_clientes_detalle.php?sAccion=new"; // Redirigir para crear una nueva captación
}

function EditCaptacion(idcliente) {
    window.location.href = "captacion_clientes_detalle.php?sAccion=edit&idcliente=" + idcliente; // Redirigir para editar una captación existente
}
</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Lista de Captaciones de Clientes</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <form action="captacion_clientes.php" method="post">
          <div class="row">
            <div class="col-6">
              <!-- Select para filtrar por tipo de cliente -->
              <div class="form-group">
                <label>Tipo de Cliente:</label>
                <select class="form-control" name="tipo_cliente">
                  <option value="">TODOS</option>
                  <option value="individual" <?php if ($tipo_cliente == "individual") echo "selected"; ?>>Individual</option>
                  <option value="corporativo" <?php if ($tipo_cliente == "corporativo") echo "selected"; ?>>Corporativo</option>
                  <option value="vip" <?php if ($tipo_cliente == "vip") echo "selected"; ?>>VIP</option>
                  <option value="familiar" <?php if ($tipo_cliente == "familiar") echo "selected"; ?>>Familiar</option>
                  <option value="estudiantil" <?php if ($tipo_cliente == "estudiantil") echo "selected"; ?>>Estudiantil</option>
                </select>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <button id="submit" name="button" value="submit" class="btn btn-primary">Consultar</button>
                <button type="button" name="button" value="Nuevo" class="btn btn-success" onclick="javascript:NewCaptacion();">Nueva Captación</button>
              </div>
            </div>
          </div>
        </form>
      </div>
      <!-- /.card-header -->

      <?php
      // Consulta para obtener las captaciones de clientes
      $sql = "SELECT `idcliente`,`idcaptacion`  , `tipo_cliente`, `nombre_cliente`, `contacto`, `estado`, `fecha_captacion` FROM `captacion_clientes` ";
      $sql .= "WHERE idcliente > 0 ";
      if ($tipo_cliente != "") $sql .= "AND tipo_cliente = '$tipo_cliente' ";
      $sql .= "ORDER BY nombre_cliente ";
      $result = dbQuery($sql);
      $total_registros = mysqli_num_rows($result);
      ?>

      <div class="card-body">
        <table id="listado" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>Nombre del Cliente</th>
            <th>Tipo de Cliente</th>
            <th>Contacto</th>
            <th>Estado</th>
            <th>Fecha de Captación</th>
            <th>Acciones</th>
          </tr>
          </thead>
          <tbody>
          <?php 
          if ($total_registros > 0) { // Existen datos
            while ($row = mysqli_fetch_array($result)) {
              $estado = $row["estado"] == "A" ? "Activo" : "Inactivo";
              $tipo_cliente = ucfirst($row["tipo_cliente"]); // Capitalizar la primera letra
              ?>
              <tr>
                <td><?php echo $row["nombre_cliente"]; ?></td>
                <td><?php echo $tipo_cliente; ?></td>
                <td><?php echo $row["contacto"]; ?></td>
                <td><?php echo $estado; ?></td>
                <td><?php echo $row["fecha_captacion"]; ?></td>
                <td>
                  <button type="button" class="btn btn-info" onclick="EditCaptacion(<?php echo $row['idcliente']; ?>);">Editar</button>
                </td>
              </tr>
              <?php
            } 
          } else { // No existen datos
            echo "<tr><td colspan=6>No existen registros</td></tr>";
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

