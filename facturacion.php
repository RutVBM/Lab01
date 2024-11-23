<?php
ob_start(); // Inicia el buffer de salida
include("header.php");
include_once("conexion/database.php");
include("sidebar.php");
?>

<script type="text/javascript">
// Redireccionar para generar una factura
function GenerateInvoice(id) {
    window.location.href = "facturacion_detalle.php?id=" + id;
}
</script>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Lista de Pagos Registrados</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-body">
                <?php
                $sql = "SELECT id_pago, tipo_plan, nombre_plan, duracion, precio, metodo_pago, fecha_pago 
                        FROM pago_clientes";
                $result = dbQuery($sql);
                ?>

                <table id="listado" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Tipo de Plan</th>
                            <th>Nombre del Plan</th>
                            <th>Duración</th>
                            <th>Precio</th>
                            <th>Método de Pago</th>
                            <th>Fecha de Pago</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= ucfirst($row["tipo_plan"]) ?></td>
                                <td><?= $row["nombre_plan"] ?></td>
                                <td><?= $row["duracion"] ?> meses</td>
                                <td>S/ <?= $row["precio"] ?></td>
                                <td><?= $row["metodo_pago"] ?></td>
                                <td><?= $row["fecha_pago"] ?></td>
                                <td>
                                    <button class="btn btn-primary" onclick="GenerateInvoice(<?= $row['id_pago'] ?>);">Generar Factura</button>
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
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#listado_wrapper .col-md-6:eq(0)');
});
</script>
