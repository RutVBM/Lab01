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
                    <h1>Lista de Contratos de Locales</h1>
                </div>
                <div class="col-sm-6">
                    <!-- Botón para agregar un nuevo contrato -->
                    <a href="contratos_locales_detalle.php?sAccion=new" class="btn btn-primary float-sm-right" style="background-color: orange;">
                        Agregar nuevo contrato de local
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-body">
                <?php
                // Consulta para obtener los contratos con detalles del local
                $sql = "SELECT cl.id_contratacion_local, l.nombre_parque AS nombre_local, l.direccion, l.capacidad, cl.hora_inicio, cl.hora_fin, cl.estado
                        FROM contratos_locales cl
                        INNER JOIN locales l ON cl.id_local = l.id_local";
                $result = dbQuery($sql);
                ?>

                <table id="listado" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nombre del Local</th>
                            <th>Dirección</th>
                            <th>Capacidad</th>
                            <th>Hora Inicio</th>
                            <th>Hora Fin</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= $row["nombre_local"] ?></td>
                                <td><?= $row["direccion"] ?></td>
                                <td><?= $row["capacidad"] ?></td>
                                <td><?= $row["hora_inicio"] ?></td>
                                <td><?= $row["hora_fin"] ?></td>
                                <td><?= ucfirst($row["estado"]) ?></td>
                                <td>
                                    <a href="contratos_locales_detalle.php?sAccion=edit&id_contratacion_local=<?= $row['id_contratacion_local']; ?>" class="btn btn-info">Editar</a>
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
