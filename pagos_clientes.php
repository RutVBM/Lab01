<?php
ob_start(); // Inicia el buffer de salida

include("header.php");
include_once("conexion/database.php");

include("sidebar.php");
?>

<script type="text/javascript">
// Redireccionar para crear un nuevo plan
function NewPlan() {
    window.location.href = "pagos_clientes_detalle.php?sAccion=new";
}
</script>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Lista de Planes de Entrenamiento</h1>
                </div>
                <div class="col-sm-6">
                    <button type="button" class="btn btn-success float-sm-right" onclick="NewPlan();">Nuevo Plan</button>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-body">
                <?php
                $sql = "SELECT idplan, nombre_plan, tipo_plan, duracion, precio FROM planes_entrenamiento";
                $result = dbQuery($sql);
                ?>

                <table id="listado" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nombre del Plan</th>
                            <th>Tipo de Plan</th>
                            <th>Duración</th>
                            <th>Precio</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= $row["nombre_plan"] ?></td>
                                <td><?= ucfirst($row["tipo_plan"]) ?></td>
                                <td><?= $row["duracion"] ?> meses</td>
                                <td>S/ <?= $row["precio"] ?></td>
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
