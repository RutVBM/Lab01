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
                    <!-- Botón para agregar un nuevo contrato, abre contrato_personal_detalle.php en una página separada -->
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
                $sql = "SELECT idContratos_personal, nombre_personal, DNI_personal, telefono, email, Finicio_contrato_per, Ffin_contrato_per 
                        FROM contrato_personal";
                $result = dbQuery($sql);
                $total_registros = mysqli_num_rows($result);
                ?>

                <table id="listado" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>DNI</th>
                            <th>Teléfono</th>
                            <th>Email</th>
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
                                    <td><?php echo $row["nombre_personal"]; ?></td>
                                    <td><?php echo $row["DNI_personal"]; ?></td>
                                    <td><?php echo $row["telefono"]; ?></td>
                                    <td><?php echo $row["email"]; ?></td>
                                    <td><?php echo $row["Finicio_contrato_per"]; ?></td>
                                    <td><?php echo $row["Ffin_contrato_per"]; ?></td>
                                    <td>
                                        <a href="contrato_personal_detalle.php?sAccion=edit&idContratos_personal=<?php echo $row['idContratos_personal']; ?>" class="btn btn-info">Editar</a>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='7'>No existen contratos registrados</td></tr>";
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

