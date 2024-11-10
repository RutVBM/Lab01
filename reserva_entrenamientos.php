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
                    <h1>Lista de Reservas</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <a class="btn btn-block btn-primary" href="reserva_entrenamientos_detalle.php?sAccion=new" style="width: 100px;">Nueva</a>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <!-- Aquí puedes añadir un formulario de filtros si lo deseas -->
            </div>
            <div class="card-body">
                <?php
                // Consulta SQL para obtener las reservas
                $sql = "SELECT r.`idreserva`, r.`nombre_cliente`, r.`tipo_entrenamiento`, r.`num_participantes`, r.`lugar_entrenamiento`, r.`fecha_reserva`
                        FROM `reserva_entrenamientos` r
                        ORDER BY r.fecha_reserva";
                $result = dbQuery($sql);
                $total_registros = mysqli_num_rows($result);
                ?>

                <table id="listado" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nombre Cliente</th>
                            <th>Tipo de Entrenamiento</th>
                            <th>Número de Participantes</th>
                            <th>Lugar</th>
                            <th>Fecha de Reserva</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($total_registros > 0) {
                            while ($row = mysqli_fetch_array($result)) {
                                echo "<tr>
                                    <td>{$row['nombre_cliente']}</td>
                                    <td>{$row['tipo_entrenamiento']}</td>
                                    <td>{$row['num_participantes']}</td>
                                    <td>{$row['lugar_entrenamiento']}</td>
                                    <td>{$row['fecha_reserva']}</td>
                                    <td class='text-center'>
                                        <a class='btn btn-info btn-sm' href='reserva_entrenamientos_detalle.php?sAccion=edit&idreserva={$row['idreserva']}'>
                                            <i class='fas fa-pencil-alt'></i> Editar
                                        </a>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No existen registros</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<script>
    // DataTables
    $(function () {
        $("#listado").DataTable({
            responsive: true,
            lengthChange: false,
            autoWidth: false,
            buttons: ["excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#listado_wrapper .col-md-6:eq(0)');
    });
</script>

<?php
// Mensajes de TOASTR
if ($mensaje == '1') { ?>
    <script>toastr.success("La información se registró correctamente.");</script>
<?php } elseif ($mensaje == '2') { ?>
    <script>toastr.info("La información se actualizó correctamente.");</script>
<?php } ?>

<?php
include("footer.php");
?>
