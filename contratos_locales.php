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
                    <!-- Botón para agregar un nuevo contrato, abre contratos_locales_detalle.php en una página separada -->
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
                // Consulta para obtener los contratos de locales
                $sql = "SELECT idContratos_locales, nombre_local, direccion, telefono_contacto, Finicio_contrato_local, Ffin_contrato_local 
                        FROM contratos_locales";
                $result = dbQuery($sql);
                $total_registros = mysqli_num_rows($result);
                ?>

                <table id="listado" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nombre del Local</th>
                            <th>Dirección</th>
                            <th>Teléfono de Contacto</th>
                            <th>Fecha de Inicio</th>
                            <th>Fecha de Fin</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($total_registros > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td><?php echo $row["nombre_local"]; ?></td>
                                    <td><?php echo $row["direccion"]; ?></td>
                                    <td><?php echo $row["telefono_contacto"]; ?></td>
                                    <td><?php echo $row["Finicio_contrato_local"]; ?></td>
                                    <td><?php echo $row["Ffin_contrato_local"]; ?></td>
                                    <td>
                                        <a href="contratos_locales_detalle.php?sAccion=edit&idContratos_locales=<?php echo $row['idContratos_locales']; ?>" class="btn btn-info">Editar</a>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='6'>No existen contratos de locales registrados</td></tr>";
                        }
                        ?>
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
