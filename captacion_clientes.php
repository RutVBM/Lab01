<?php
ob_start(); // Inicia el buffer de salida
include_once("header.php");
include_once("conexion/database.php"); // Usa include_once para evitar múltiples inclusiones

$tipo_cliente = isset($_POST["tipo_cliente"]) ? $_POST["tipo_cliente"] : "";

include_once("sidebar.php");

// Eliminar una captación si se recibe la acción 'delete'
if (isset($_GET['sAccion']) && $_GET['sAccion'] == 'delete' && isset($_GET['idcaptacion'])) {
    $idcaptacion = $_GET['idcaptacion'];
    $sql = "DELETE FROM captacion_clientes WHERE idcaptacion = ?";
    dbQuery($sql, [$idcaptacion]);
    header("Location: captacion_clientes.php?mensaje=deleted");
    exit();
}
?>

<script type="text/javascript">
function NewCaptacion() {
    window.location.href = "captacion_clientes_detalle.php?sAccion=new";
}

function EditCaptacion(idcaptacion) {
    window.location.href = "captacion_clientes_detalle.php?sAccion=edit&idcaptacion=" + idcaptacion;
}

function DeleteCaptacion(idcaptacion) {
    if (confirm("¿Estás seguro de que deseas eliminar esta captación? Esta acción no se puede deshacer.")) {
        window.location.href = "captacion_clientes.php?sAccion=delete&idcaptacion=" + idcaptacion;
    }
}
</script>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Lista de Captación de Clientes</h1>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <form action="captacion_clientes.php" method="post">
                    <div class="row">
                        <div class="col-6">
                            <label>Tipo de Cliente:</label>
                            <select class="form-control" name="tipo_cliente">
                                <option value="">TODOS</option>
                                <option value="Individual" <?= $tipo_cliente == "Individual" ? "selected" : "" ?>>Individual</option>
                                <option value="Corporativo" <?= $tipo_cliente == "Corporativo" ? "selected" : "" ?>>Corporativo</option>
                                <option value="VIP" <?= $tipo_cliente == "VIP" ? "selected" : "" ?>>VIP</option>
                                <option value="Familiar" <?= $tipo_cliente == "Familiar" ? "selected" : "" ?>>Familiar</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <button type="submit" class="btn btn-primary">Consultar</button>
                            <button type="button" class="btn btn-success" onclick="NewCaptacion();">Nueva Captación</button>
                        </div>
                    </div>
                </form>
            </div>

            <?php
            $sql = "SELECT * FROM captacion_clientes WHERE idcaptacion > 0";
            if ($tipo_cliente != "") {
                $sql .= " AND tipo_cliente = ?";
                $stmt = dbQuery($sql, [$tipo_cliente]);
            } else {
                $stmt = dbQuery($sql);
            }
            $total_registros = $stmt->num_rows;
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
                            while ($row = $stmt->fetch_assoc()) {
                                $estado = $row["estado"] == "A" ? "Activo" : "Inactivo"; ?>
                                <tr>
                                    <td><?= $row["nombre_cliente"] ?></td>
                                    <td><?= $row["tipo_cliente"] ?></td>
                                    <td><?= $row["contacto"] ?></td>
                                    <td><?= $estado ?></td>
                                    <td><?= $row["fecha_captacion"] ?></td>
                                    <td>
                                        <button class="btn btn-info" onclick="EditCaptacion(<?= $row['idcaptacion'] ?>);">Editar</button>
                                        <button class="btn btn-danger" onclick="DeleteCaptacion(<?= $row['idcaptacion'] ?>);">Eliminar</button>
                                    </td>
                                </tr>
                            <?php }
                        } else { ?>
                            <tr><td colspan="6">No existen registros</td></tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<?php include_once("footer.php"); ?>

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
