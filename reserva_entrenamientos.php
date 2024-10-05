<?php
include("header.php");

// Variable mensaje para manejar las notificaciones
$mensaje = "";
if (isset($_POST["mensaje"])) $mensaje = $_POST["mensaje"];
if (isset($_GET["mensaje"])) $mensaje = $_GET["mensaje"];

// Variable idregistro para manejar el ID del cliente
$idregistro = "";
if (isset($_POST["idregistro"])) $idregistro = $_POST["idregistro"];
if ($idregistro) {
    // Consulta SQL para eliminar una reserva
    $sql = "DELETE FROM reserva_entrenamientos WHERE idcliente = '$idregistro'";
    dbQuery($sql);
    $mensaje = "3";
}

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
                $sql = "SELECT r.`idcliente`, r.`tipo_entrenamiento`, r.`num_participantes`, r.`lugar`, r.`fecha`, r.`hora`
                        FROM `reserva_entrenamientos` r
                        ORDER BY r.fecha";
                $result = dbQuery($sql);
                $total_registros = mysqli_num_rows($result);
                ?>

                <table id="listado" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID Cliente</th>
                            <th>Tipo de Entrenamiento</th>
                            <th>Número de Participantes</th>
                            <th>Lugar</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($total_registros > 0) {
                            while ($row = mysqli_fetch_array($result)) {
                                echo "<tr>
                                    <td>{$row['idcliente']}</td>
                                    <td>{$row['tipo_entrenamiento']}</td>
                                    <td>{$row['num_participantes']}</td>
                                    <td>{$row['lugar']}</td>
                                    <td>{$row['fecha']}</td>
                                    <td>{$row['hora']}</td>
                                    <td class='text-center'>
                                        <a class='btn btn-info btn-sm' href='reserva_entrenamientos_detalle.php?sAccion=edit&idcliente={$row['idcliente']}'>
                                            <i class='fas fa-pencil-alt'></i> Editar
                                        </a>
                                        <a class='btn btn-danger btn-sm delete_btn' data-toggle='modal' data-target='#modal-delete' data-idregistro='{$row['idcliente']}'>
                                            <i class='fas fa-trash'></i> Eliminar
                                        </a>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No existen registros</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal para eliminar -->
        <div class="modal fade" id="modal-delete">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="reserva_entrenamientos.php" method="post">
                        <div class="modal-header">
                            <h4 class="modal-title">Advertencia</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="idregistro" id="idregistro">
                            <p>¿Está seguro de que desea eliminar el registro seleccionado?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </div>
                    </form>
                </div>
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

    // Modal delete
    $('#modal-delete').on('show.bs.modal', function (e) {
        var button = $(e.relatedTarget);
        var idregistro = button.data('idregistro');
        var modal = $(this);
        modal.find('.modal-body #idregistro').val(idregistro);
    });
</script>

<?php
// Mensajes de TOASTR
if ($mensaje == '1') { ?>
    <script>toastr.success("La información se registró correctamente.");</script>
<?php } elseif ($mensaje == '2') { ?>
    <script>toastr.info("La información se actualizó correctamente.");</script>
<?php } elseif ($mensaje == '3') { ?>
    <script>toastr.warning("La información se eliminó correctamente.");</script>
<?php } else { ?>
    <script>toastr.error("Lo sentimos, ocurrió un error.");</script>
<?php } ?>

<?php
include("footer.php");
?>
