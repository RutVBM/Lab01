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
                    <h1>Lista de Contratos de Entrenadores</h1>
                </div>
                <div class="col-sm-6">
                    <a href="contrato_personal_detalle.php?sAccion=new" class="btn btn-primary float-sm-right">Nuevo Contrato</a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-body">
                <?php
                $sql = "SELECT id_contrato, nombre_entrenador, telefono, salario, especialidad, estado 
                        FROM contrato_personal";
                $result = dbQuery($sql);
                ?>

                <table id="listado" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th>Salario</th>
                            <th>Especialidad</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= htmlspecialchars($row["nombre_entrenador"]) ?></td>
                                <td><?= htmlspecialchars($row["telefono"]) ?></td>
                                <td>S/ <?= number_format($row["salario"], 2) ?></td>
                                <td><?= htmlspecialchars($row["especialidad"]) ?></td>
                                <td><?= htmlspecialchars($row["estado"]) ?></td>
                                <td>
                                    <a href="contrato_personal_detalle.php?sAccion=edit&id_contrato=<?= $row['id_contrato'] ?>" class="btn btn-info btn-sm">Editar</a>
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
