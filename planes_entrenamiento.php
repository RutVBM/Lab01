<?php
include ("header.php");

// Filtrar por tipo de plan si es necesario
$tipo_plan = "";
if (isset($_POST["tipo_plan"])) $tipo_plan = $_POST["tipo_plan"];
?>

<?php
include ("sidebar.php");
?>
<script type="text/javascript">
// Funcion Nuevo registro de plan de entrenamiento
function NewPlan() {
    window.location.href = "planes_entrenamiento_detalle.php?sAccion=new"; // Redireccionar para crear un nuevo plan
}

function EditPlan(idplan) {
    window.location.href = "planes_entrenamiento_detalle.php?sAccion=edit&idplan=" + idplan; // Redireccionar para editar un plan existente
}
</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Lista de Planes de Entrenamiento</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <form action="planes_entrenamiento.php" method="post">
          <div class="row">
            <div class="col-6">
              <!-- Select para tipo de plan -->
              <div class="form-group">
                <label>Tipo de Plan:</label>
                <select class="form-control" name="tipo_plan">
                  <option value="">TODOS</option>
                  <option value="individual" <?php if ($tipo_plan == "individual") echo "selected"; ?>>Individual</option>
                  <option value="grupal" <?php if ($tipo_plan == "grupal") echo "selected"; ?>>Grupal</option>
                </select>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <button id="submit" name="button" value="submit" class="btn btn-primary">Consultar</button>
                <button type="button" name="button" value="Nuevo" class="btn btn-success" onclick="javascript:NewPlan();">Nuevo Plan</button>
              </div>
            </div>
          </div>
        </form>
      </div>
      <!-- /.card-header -->

      <?php
      // Consulta para obtener los planes de entrenamiento
      $sql = "SELECT `idplan`, `tipo_plan`, `nombre_plan`, `duracion`, `precio`, `estado`, `fecharegistro` FROM `planes_entrenamiento` ";
      $sql .= "WHERE idplan > 0 ";
      if ($tipo_plan != "") $sql .= "AND tipo_plan = '$tipo_plan' ";
      $sql .= "ORDER BY nombre_plan ";
      $result = dbQuery($sql);
      $total_registros = mysqli_num_rows($result);
      ?>

      <div class="card-body">
        <table id="listado" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>Nombre del Plan</th>
            <th>Tipo de Plan</th>
            <th>Duración</th>
            <th>Precio</th>
            <th>Estado</th>
            <th>Fecha de Registro</th>
            <th>Acciones</th>
          </tr>
          </thead>
          <tbody>
          <?php 
          if ($total_registros > 0) { // Existen datos
            while ($row = mysqli_fetch_array($result)) {
              $estado = $row["estado"] == "A" ? "Activo" : "Inactivo";
              $tipo_plan = $row["tipo_plan"] == "individual" ? "Individual" : "Grupal";
              ?>
              <tr>
                <td><?php echo $row["nombre_plan"]; ?></td>
                <td><?php echo $tipo_plan; ?></td>
                <td><?php echo $row["duracion"]; ?> meses</td>
                <td>S/ <?php echo $row["precio"]; ?></td>
                <td><?php echo $estado; ?></td>
                <td><?php echo $row["fecharegistro"]; ?></td>
                <td>
                  <button type="button" class="btn btn-info" onclick="EditPlan(<?php echo $row['idplan']; ?>);">Editar</button>
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
