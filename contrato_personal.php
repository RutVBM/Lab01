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
                    <h1>Lista de Contratos de Personal</h1>
                </div>
                <div class="col-sm-6">
                    <a href="contrato_personal_detalle.php?sAccion=new" class="btn btn-primary float-sm-right" style="background-color: orange;">
                        Agregar nuevo contrato
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-body">
                <?php
                // Consulta para obtener los contratos de personal
                $sql = "SELECT id_contrato, nombre_entrenador, telefono, salario, estado, dias_disponibles, hora_inicio, hora_fin, tipo_entrenamiento, capacidad, especialidad 
                        FROM contrato_personal";
                $result = dbQuery($sql);
                ?>

                <table id="listado" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th>Salario</th>
                            <th>Días Disponibles</th>
                            <th>Hora Inicio</th>
                            <th>Hora Fin</th>
                            <th>Tipo de Entrenamiento</th>
                            <th>Capacidad</th>
                            <th>Especialidad</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= $row["nombre_entrenador"] ?></td>
                                <td><?= $row["telefono"] ?></td>
                                <td>S/ <?= $row["salario"] ?></td>
                                <td><?= $row["dias_disponibles"] ?></td>
                                <td><?= $row["hora_inicio"] ?></td>
                                <td><?= $row["hora_fin"] ?></td>
                                <td><?= $row["tipo_entrenamiento"] ?></td>
                                <td><?= $row["capacidad"] ?></td>
                                <td><?= $row["especialidad"] ?></td>
                                <td><?= $row["estado"] ?></td>
                                <td>
                                    <a href="contrato_personal_detalle.php?sAccion=edit&id_contrato=<?= $row['id_contrato'] ?>" class="btn btn-info">Editar</a>
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
