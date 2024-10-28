<?php
include("header.php");

$mensaje = "";
if (isset($_POST["mensaje"])) $mensaje = $_POST["mensaje"];
if (isset($_GET["mensaje"])) $mensaje = $_GET["mensaje"];

$idregistro = "";
if (isset($_POST["idregistro"])) $idregistro = $_POST["idregistro"];
if ($idregistro) {
    $sql = "DELETE FROM inventario WHERE id_inventario = '$idregistro'";
    dbQuery($sql);
    $mensaje = "3";
}

include("sidebar.php");
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Inventario de Materiales y Productos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <a class="btn btn-block btn-primary" href="inventario_detalle.php?sAccion=new" style="width: 150px;">Nuevo</a>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Listado de Materiales y Productos</h3>
            </div>
            <?php
            $sql = "SELECT i.id_inventario, i.nombre_material_producto, i.tipo, i.cantidad, i.stock_minimo, i.precio_unitario, p.nombre_proveedor, i.estado 
                    FROM inventario i 
                    LEFT JOIN proveedor p ON i.id_proveedor = p.id_proveedor 
                    ORDER BY i.nombre_material_producto";
            $result = dbQuery($sql);
            $total_registros = mysqli_num_rows($result);
            ?>
            <div class="card-body">
                <table id="listado" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Cantidad</th>
                            <th>Stock Mínimo</th>
                            <th>Precio Unitario</th>
                            <th>Proveedor</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($total_registros > 0) {
                            while ($row = mysqli_fetch_array($result)) {
                                $estado = ($row["estado"] == "Activo") ? "Activo" : "Inactivo";
                                ?>
                                <tr>
                                    <td><?php echo $row["nombre_material_producto"]; ?></td>
                                    <td><?php echo $row["tipo"]; ?></td>
                                    <td><?php echo $row["cantidad"]; ?></td>
                                    <td><?php echo $row["stock_minimo"]; ?></td>
                                    <td><?php echo $row["precio_unitario"]; ?></td>
                                    <td><?php echo $row["nombre_proveedor"]; ?></td>
                                    <td><?php echo $estado; ?></td>
                                    <td class="text-center">
                                        <a class="btn btn-info btn-sm" href="inventario_detalle.php?sAccion=edit&id_inventario=<?php echo $row["id_inventario"]; ?>">
                                            <i class="fas fa-pencil-alt"></i> Editar
                                        </a>
                                        <a class="btn btn-danger btn-sm delete_btn" data-toggle="modal" data-target="#modal-delete" data-idregistro="<?php echo $row['id_inventario']; ?>">
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

<!-- Modal para eliminar -->
<div class="modal fade" id="modal-delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="inventario.php" method="post">
                <div class="modal-header">
                    <h4 class="modal-title">Advertencia</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="idregistro" id="idregistro">
                    <p>¿Está seguro que desea eliminar el registro seleccionado?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" name="eliminar_registro" class="btn bg-danger btn-ok">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts para eliminar -->
<script>
    $('#modal-delete').on('show.bs.modal', function(e) {
        var button = $(e.relatedTarget);
        var idregistro = button.data('idregistro');
        var modal = $(this);
        modal.find('.modal-body #idregistro').val(idregistro);
    });
</script>

<!-- Mostrar mensajes con Toastr -->
<?php if ($mensaje == '1') { ?>
    <script>toastr.success("La información se registró correctamente..!");</script>
<?php } elseif ($mensaje == '2') { ?>
    <script>toastr.info("La información se actualizó correctamente..!");</script>
<?php } elseif ($mensaje == '3') { ?>
    <script>toastr.warning("La información se eliminó correctamente..!");</script>
<?php } else if ($mensaje == '4') { ?>
    <script>toastr.error("Lo sentimos, se ha producido un error..!");</script>
<?php } ?>

<?php
include("footer.php");
?>
