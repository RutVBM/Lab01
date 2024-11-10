<?php
include("header.php");
include_once("conexion/database.php");

// Configura la zona horaria a Perú
date_default_timezone_set('America/Lima');

$estado = isset($_POST["estado"]) ? $_POST["estado"] : "";

include("sidebar.php");
?>

<script type="text/javascript">
// Función para crear una nueva atención de reclamo o consulta
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
                    <h1>Registro de Consultas y Reclamos</h1>
                </div>
                <div class="col-sm-6">
                    <button type="button" class="btn btn-primary float-sm-right" onclick="NewReclamo();">Nuevo Reclamo o Consulta</button>
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
                            <button type="submit" class="btn btn-primary">Consultar</button>
                        </div>
                    </div>
                </form>
            </div>

            <?php
            // Consulta SQL para obtener solo los campos necesarios
            $sql = "SELECT r.id_cliente, r.nombre, r.id_reclamo, r.tipo, r.detalle, r.fecha_reclamo
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

            <div class="card-body">
                <table id="listado" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <!-- Ocultar las columnas de ID Cliente e ID Reclamo -->
                            <th>Nombre</th>
                            <th>Tipo</th>
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
                                    <!-- Ocultar las columnas de ID Cliente e ID Reclamo en el cuerpo de la tabla -->
                                    <td><?= $row["nombre"] ?></td>
                                    <td><?= $row["tipo"] ?></td>
                                    <td><?= $row["detalle"] ?></td>
                                    <td><?= $row["fecha_reclamo"] ?></td>
                                    <td>
                                        <button type="button" class="btn btn-info" onclick="EditReclamo(<?= $row['id_reclamo'] ?>);">Editar</button>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='5'>No existen reclamos registrados</td></tr>";
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
