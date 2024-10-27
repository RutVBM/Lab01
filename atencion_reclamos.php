<?php
include("header.php");
include_once("conexion/database.php");

$estado = isset($_POST["estado"]) ? $_POST["estado"] : "";

include("sidebar.php");
?>

<script type="text/javascript">
function EditReclamo(id_reclamo) {
    window.location.href = "atencion_reclamos_detalle.php?sAccion=edit&id_reclamo=" + id_reclamo;
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
            <div class="card-body">
                <?php
                // Consulta SQL para obtener todos los campos de la tabla "reclamos"
                $sql = "SELECT r.id_cliente, r.id_reclamo, r.tipo, r.detalle, r.fecha_reclamo, r.estado_reclamo, r.fecha_solucion, r.detalle_solucion
                        FROM reclamos r
                        WHERE r.id_reclamo > 0";

                if ($estado != "") {
                    $sql .= " AND r.estado_reclamo = ?";
                    $stmt = dbQuery($sql, [$estado]);
                } else {
                    $stmt = dbQuery($sql);
                }

                $total_registros = $stmt->num_rows;
                ?>

                <table id="listado" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID Cliente</th>
                            <th>ID Reclamo</th>
                            <th>Tipo</th>
                            <th>Detalle</th>
                            <th>Fecha de Reclamo</th>
                            <th>Estado</th>
                            <th>Fecha de Solución</th>
                            <th>Detalle de Solución</th>
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
                                    <td><?= $row["id_reclamo"] ?></td>
                                    <td><?= $row["tipo"] ?></td>
                                    <td><?= $row["detalle"] ?></td>
                                    <td><?= $row["fecha_reclamo"] ?></td>
                                    <td><?= $row["estado_reclamo"] == "pendiente" ? "Pendiente" : "Resuelto" ?></td>
                                    <td><?= $row["fecha_solucion"] ?></td>
                                    <td><?= $row["detalle_solucion"] ?></td>
                                    <td>
                                        <button type="button" class="btn btn-info" onclick="EditReclamo(<?= $row['id_reclamo'] ?>);">Atender</button>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='9'>No existen reclamos registrados</td></tr>";
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
