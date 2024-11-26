<?php
include("header.php");
include_once("conexion/database.php");
include("sidebar.php");
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Órdenes de Materiales</h1>
                </div>
                <div class="col-sm-6">
                    <a href="ordenes_materiales_detalle.php?sAccion=new" class="btn btn-primary float-sm-right">Nueva Orden</a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-body">
                <?php
                $sql = "SELECT om.id_orden, om.fecha, om.subtotal, om.estado, i.nombre_material_producto 
                        FROM ordenes_materiales om
                        INNER JOIN inventario i ON om.id_inventario = i.id_inventario";
                $result = dbQuery($sql);
                ?>

                <table id="listado" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID Orden</th>
                            <th>Material</th>
                            <th>Fecha</th>
                            <th>Subtotal</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= $row["id_orden"] ?></td>
                                <td><?= htmlspecialchars($row["nombre_material_producto"]) ?></td>
                                <td><?= htmlspecialchars($row["fecha"]) ?></td>
                                <td>S/ <?= number_format($row["subtotal"], 2) ?></td>
                                <td><?= htmlspecialchars($row["estado"]) ?></td>
                                <td>
                                    <a href="ordenes_materiales_detalle.php?sAccion=edit&id_orden=<?= $row['id_orden'] ?>" class="btn btn-info btn-sm">Editar</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
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
