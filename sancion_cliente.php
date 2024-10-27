<?php
include("header.php");
include_once("conexion/database.php");

// Configura la zona horaria a Perú
date_default_timezone_set('America/Lima');

$estado = isset($_POST["estado"]) ? $_POST["estado"] : "";

include("sidebar.php");
?>

<script type="text/javascript">
// Función para ver detalles de la sanción
function EditSancion(id_sancion) {
    window.location.href = "sancion_cliente_detalle.php?sAccion=edit&id_sancion=" + id_sancion;
}
</script>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Registro de Sanciones</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-body">
                <?php
                // Consulta SQL para obtener los registros de la tabla "gestion_sanciones"
                $sql = "SELECT idcliente, id_sancion, nombre_cliente, faltas, estado, fecha_sancion FROM gestion_sanciones";

                $stmt = dbQuery($sql);
                $total_registros = $stmt->num_rows;
                ?>

                <table id="listado" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID Cliente</th>
                            <th>ID Sanción</th>
                            <th>Nombre Cliente</th>
                            <th>Faltas</th>
                            <th>Estado</th>
                            <th>Fecha de Sanción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($total_registros > 0) {
                            while ($row = $stmt->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $row["idcliente"] ?></td>
                                    <td><?= $row["id_sancion"] ?></td>
                                    <td><?= $row["nombre_cliente"] ?></td>
                                    <td><?= $row["faltas"] ?></td>
                                    <td><?= $row["estado"] ?></td>
                                    <td><?= $row["fecha_sancion"] ?></td>
                                    <td>
                                        <button type="button" class="btn btn-info" onclick="EditSancion(<?= $row['id_sancion'] ?>);">Ver Detalle</button>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='7'>No existen sanciones registradas</td></tr>";
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
