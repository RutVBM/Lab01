<?php
include("header.php");
include_once("conexion/database.php"); // Asegúrate de usar include_once para evitar múltiples inclusiones

$estado = isset($_POST["estado"]) ? $_POST["estado"] : "";

include("sidebar.php");
?>

<script type="text/javascript">
// Función para crear una nueva atención de reclamo
function NewReclamo() {
    window.location.href = "reclamo_cliente_detalle.php?sAccion=new";
}

function EditReclamo(id_reclamo) {
    window.location.href = "reclamo_cliente_detalle.php?sAccion=edit&id_reclamo=" + id_reclamo;
}
</script>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Atención de Consultas y Reclamos</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <form action="atencion_reclamos.php" method="post">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Estado de Reclamo:</label>
                                <select class="form-control" name="estado">
                                    <option value="">TODOS</option>
                                    <option value="pendiente" <?= $estado == "pendiente" ? "selected" : "" ?>>Pendiente</option>
                                    <option value="resuelto" <?= $estado == "resuelto" ? "selected" : "" ?>>Resuelto</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <button id="submit" name="button" value="submit" class="btn btn-primary">Consultar</button>
                                <button type="button" name="button" value="Nuevo" class="btn btn-success" onclick="NewReclamo();">Nuevo Reclamo</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <?php
            // Consulta SQL para obtener solo los campos necesarios
            $sql = "SELECT r.id_cliente, r.id_reclamo, r.tipo, r.detalle, r.fecha_reclamo
                    FROM reclamos r
                    WHERE r.id_reclamo > 0";

            if ($estado != "") {
                $sql .= " AND r.estado_reclamo = ?";
                $stmt = dbQuery($sql, [$estado]); // Consulta preparada con parámetro
            } else {
                $stmt = dbQuery($sql); // Sin parámetros
            }

            $total_registros = $stmt->num_rows;
            ?>

            <div class="card-body">
                <table id="listado" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID Cliente</th>
                            <th>Tipo</th>
                            <th>ID Reclamo</th>
                            <th>Detalle</th>
                            <th>Fecha de Reclamo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($total_registros > 0) {
                            while ($row = $stmt->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $row["id_cliente"] ?></td>
                                    <td><?= $row["tipo"] ?></td>
                                    <td><?= $row["id_reclamo"] ?></td>
                                    <td><?= $row["detalle"] ?></td>
                                    <td><?= $row["fecha_reclamo"] ?></td>
                                    <td>
                                        <button type="button" class="btn btn-info" onclick="EditReclamo(<?= $row['id_reclamo'] ?>);">Editar</button>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='6'>No existen reclamos registrados</td></tr>";
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
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#listado_wrapper .col-md-6:eq(0)');
});
</script>
