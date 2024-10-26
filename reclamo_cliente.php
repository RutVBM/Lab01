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
                    <h1>Lista de Reclamos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <a class="btn btn-block btn-primary" href="reclamo_cliente_detalle.php?sAccion=new" style="width: 100px;">Nuevo Reclamo</a>
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
                // Consulta SQL para obtener los reclamos de la tabla reclamos
                $sql = "SELECT r.`id_cliente`, r.`tipo`, r.`id_reclamo`, r.`detalle`, r.`fecha_reclamo`
                        FROM `reclamos` r
                        ORDER BY r.fecha_reclamo";
                $result = dbQuery($sql);
                $total_registros = mysqli_num_rows($result);
                ?>

                <table id="listado" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID Cliente</th>
                            <th>Tipo</th>
                            <th>ID Reclamo</th>
                            <th>Detalle</th>
                            <th>Fecha de Reclamo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($total_registros > 0) {
                            while ($row = mysqli_fetch_array($result)) {
                                echo "<tr>
                                    <td>{$row['id_cliente']}</td>
                                    <td>{$row['tipo']}</td>
                                    <td>{$row['id_reclamo']}</td>
                                    <td>{$row['detalle']}</td>
                                    <td>{$row['fecha_reclamo']}</td>
                                    <td class='text-center'>
                                        <a class='btn btn-info btn-sm' href='reclamo_cliente_detalle.php?sAccion=edit&id_reclamo={$row['id_reclamo']}'>
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
