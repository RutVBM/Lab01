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
                    <h1>Programación de Horarios</h1>
                </div>
                <div class="col-sm-6">
                    <a href="programacion_horarios_detalle.php?sAccion=new" class="btn btn-primary float-sm-right">Nueva Programación</a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-body">
                <?php
                $sql = "SELECT ht.id_programacion, cp.nombre_entrenador, d.dia, ht.hora_inicio, ht.hora_fin, ht.estado
                        FROM horario_treno ht
                        INNER JOIN contrato_personal cp ON ht.id_contrato = cp.id_contrato
                        INNER JOIN dias_disponibles d ON ht.id_dia = d.id_dia";
                $result = dbQuery($sql);
                ?>

                <table id="listado" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Entrenador</th>
                            <th>Día</th>
                            <th>Hora Inicio</th>
                            <th>Hora Fin</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= htmlspecialchars($row["nombre_entrenador"]) ?></td>
                                <td><?= htmlspecialchars($row["dia"]) ?></td>
                                <td><?= htmlspecialchars($row["hora_inicio"]) ?></td>
                                <td><?= htmlspecialchars($row["hora_fin"]) ?></td>
                                <td><?= htmlspecialchars($row["estado"]) ?></td>
                                <td>
                                    <a href="programacion_horarios_detalle.php?sAccion=edit&id_programacion=<?= $row['id_programacion'] ?>" class="btn btn-info btn-sm">Editar</a>
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
