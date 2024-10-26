<?php
ob_start(); // Inicia el buffer de salida

include("header.php");

// Filtrar por tipo de cliente si es necesario
$tipo_cliente = isset($_POST["tipo_cliente"]) ? $_POST["tipo_cliente"] : "";

include("sidebar.php");

// Eliminar captación si se recibe la acción delete
if (isset($_GET['sAccion']) && $_GET['sAccion'] == 'delete' && isset($_GET['idcliente'])) {
    $idcliente = $_GET['idcliente'];
    $sql = "DELETE FROM captacion_clientes WHERE idcliente = $idcliente";
    dbQuery($sql);
    header("Location: captacion_clientes.php?mensaje=deleted");
    exit();
}
?>

<script type="text/javascript">
// Redireccionar para crear una nueva captación
function NewCaptacion() {
    window.location.href = "captacion_clientes_detalle.php?sAccion=new";
}

// Redireccionar para editar una captación existente
function EditCaptacion(idcliente) {
    window.location.href = "captacion_clientes_detalle.php?sAccion=edit&idcliente=" + idcliente;
}

// Confirmar y eliminar captación
function DeleteCaptacion(idcliente) {
    if (confirm("¿Estás seguro de que deseas eliminar esta captación? Esta acción no se puede deshacer.")) {
        window.location.href = "captacion_clientes.php?sAccion=delete&idcliente=" + idcliente;
    }
}
</script>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Lista de Captaciones de Clientes</h1>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="card">
      <div class="card-header">
        <form action="captacion_clientes.php" method="post">
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label>Tipo de Cliente:</label>
                <select class="form-control" name="tipo_cliente">
                  <option value="">TODOS</option>
                  <option value="individual" <?= $tipo_cliente == "individual" ? "selected" : "" ?>>Individual</option>
                  <option value="corporativo" <?= $tipo_cliente == "corporativo" ? "selected" : "" ?>>Corporativo</option>
                  <option value="vip" <?= $tipo_cliente == "vip" ? "selected" : "" ?>>VIP</option>
                  <option value="familiar" <?= $tipo_cliente == "familiar" ? "selected" : "" ?>>Familiar</option>
                  <option value="estudiantil" <?= $tipo_cliente == "estudiantil" ? "selected" : "" ?>>Estudiantil</option>
                </select>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <button id="submit" class="btn btn-primary">Consultar</button>
                <button type="button" class="btn btn-success" onclick="NewCaptacion();">Nueva Captación</button>
              </div>
            </div>
          </div>
        </form>
      </div>

      <?php
      $sql = "SELECT idcliente, idcaptacion, tipo_cliente, nombre_cliente, contacto, estado, fecha_captacion 
              FROM captacion_clientes WHERE idcliente > 0";
      if ($tipo_cliente != "") $sql .= " AND tipo_cliente = '$tipo_cliente'";
      $sql .= " ORDER BY nombre_cliente";

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
            <?php if ($total_registros > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    $estado = $row["estado"] == "A" ? "Activo" : "Inactivo";
                    $tipo_cliente = ucfirst($row["tipo_cliente"]);
            ?>
              <tr>
                <td><?= $row["nombre_cliente"]; ?></td>
                <td><?= $tipo_cliente; ?></td>
                <td><?= $row["contacto"]; ?></td>
                <td><?= $estado; ?></td>
                <td><?= $row["fecha_captacion"]; ?></td>
                <td>
                  <button class="btn btn-info" onclick="EditCaptacion(<?= $row['idcliente']; ?>);">Editar</button>
                  <button class="btn btn-danger" onclick="DeleteCaptacion(<?= $row['idcliente']; ?>);">Eliminar</button>
                </td>
              </tr>
            <?php } } else { ?>
              <tr><td colspan="6">No existen registros</td></tr>
            <?php } ?>
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
