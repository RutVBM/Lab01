<?php
include("header.php"); // Header de la aplicación
include("sidebar.php"); // Menú lateral

$mensaje = "";
if (isset($_POST["mensaje"])) $mensaje = $_POST["mensaje"];
if (isset($_GET["mensaje"])) $mensaje = $_GET["mensaje"];
$idregistro = "";
if (isset($_POST["idregistro"])) $idregistro = $_POST["idregistro"];

// Proceso de eliminación si se recibe un ID de registro
if ($idregistro) {
  $sql = "DELETE FROM compra_insumos WHERE id_compra = '$idregistro'";
  dbQuery($sql);
  $mensaje = "3"; // Mensaje para indicar que la eliminación fue exitosa
}

?>

<!-- Contenido de la lista de compra de insumos -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Lista de compras de insumos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <a class="btn btn-block btn-primary" href="compra_insumos_detalle.php?sAccion=new" style="width: 100px;">Nuevo</a>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Lista de compras de insumos realizadas</h3>
            </div>

            <?php
            $sql = "SELECT c.id_compra, c.nombre_insumo, c.cantidad, c.precio_unitario, p.nombre_proveedor, c.fecha_pedido, c.fecha_recepcion, c.estado ";
            $sql .= "FROM compra_insumos c INNER JOIN proveedor p ON c.id_proveedor = p.id_proveedor ";
            $sql .= "ORDER BY c.fecha_pedido DESC";
            $result = dbQuery($sql);
            $total_registros = mysqli_num_rows($result);
            ?>

            <div class="card-body">
                <table id="listado" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Insumo</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Proveedor</th>
                            <th>Fecha de Pedido</th>
                            <th>Fecha de Recepción</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($total_registros > 0) {
                            while ($row = mysqli_fetch_array($result)) {
                        ?>
                                <tr>
                                    <td><?php echo $row["nombre_insumo"]; ?></td>
                                    <td><?php echo $row["cantidad"]; ?></td>
                                    <td><?php echo number_format($row["precio_unitario"], 2); ?></td>
                                    <td><?php echo $row["nombre_proveedor"]; ?></td>
                                    <td><?php echo $row["fecha_pedido"]; ?></td>
                                    <td><?php echo $row["fecha_recepcion"] ? $row["fecha_recepcion"] : 'Pendiente'; ?></td>
                                    <td><?php echo $row["estado"]; ?></td>
                                    <td class="text-center">
                                        <a class="btn btn-info btn-sm" href="compra_insumos_detalle.php?sAccion=edit&id_compra=<?php echo $row["id_compra"]; ?>">
                                            <i class="fas fa-pencil-alt"></i> Editar
                                        </a>
                                        <a class="btn btn-danger btn-sm delete_btn" data-toggle="modal" data-target="#modal-delete" data-idregistro="<?php echo $row['id_compra']; ?>">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </a>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='8'>No existen registros</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<!-- Modal para confirmar eliminación -->
<div class="modal fade" id="modal-delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="compra_insumos.php" method="post">
                <div class="modal-header">
                    <h4 class="modal-title">Advertencia</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="idregistro" id="idregistro">
                    <p>¿Está seguro de que desea eliminar el registro seleccionado?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" name="eliminar_registro" class="btn bg-danger btn-ok">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>

<!-- Scripts -->
<script>
    $(function () {
        $("#listado").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#listado_wrapper .col-md-6:eq(0)');
    });

    // Modal para eliminar
    $('#modal-delete').on('show.bs.modal', function (e) {
        var button = $(e.relatedTarget);
        var idregistro = button.data('idregistro');
        var modal = $(this);
        modal.find('.modal-body #idregistro').val(idregistro);
    });
</script>

<!-- Toastr para mensajes -->
<?php if ($mensaje == '1') { ?>
    <script>toastr.success("La información se registró correctamente..!");</script>
<?php } elseif ($mensaje == '2') { ?>
    <script>toastr.info("La información se actualizó correctamente..!");</script>
<?php } elseif ($mensaje == '3') { ?>
    <script>toastr.warning("La información se eliminó correctamente..!");</script>
<?php } elseif ($mensaje == '4') { ?>
    <script>toastr.error("Se ha producido un error..!");</script>
<?php } ?>
