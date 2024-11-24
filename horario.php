<?php
include("header.php");

// Variable mensaje para manejar las notificaciones
$mensaje = "";
if (isset($_POST["mensaje"])) $mensaje = $_POST["mensaje"];
if (isset($_GET["mensaje"])) $mensaje = $_GET["mensaje"];

include("sidebar.php");
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Lista de Horarios</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-block btn-primary" href="horario_detalle.php?sAccion=new" style="width: 150px;">Nuevo Horario</a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-body">
                <?php
                // Consulta SQL para obtener los horarios junto con el nombre del plan
                $sql = "SELECT h.idhorario, h.hora_inicio, h.hora_fin, p.nombre_plan 
                        FROM horario_treno h
                        LEFT JOIN planes_entrenamiento p ON h.idplan = p.idplan
                        ORDER BY h.hora_inicio";
                $result = dbQuery($sql);
                ?>

                <table id="listado" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nombre del Plan</th>
                            <th>Hora Inicio</th>
                            <th>Hora Fin</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= $row["nombre_plan"] ?></td>
                                <td><?= $row["hora_inicio"] ?></td>
                                <td><?= $row["hora_fin"] ?></td>
                                <td class="text-center">
                                    <a class="btn btn-info btn-sm" href="horario_detalle.php?sAccion=edit&idhorario=<?= $row['idhorario'] ?>">
                                        <i class="fas fa-pencil-alt"></i> Editar
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<script>
    $(function () {
        $("#listado").DataTable({
            responsive: true,
            lengthChange: false,
            autoWidth: false,
            buttons: ["excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#listado_wrapper .col-md-6:eq(0)');
    });
</script>

<?php include("footer.php"); ?>
