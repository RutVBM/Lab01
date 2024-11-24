<?php
include("header.php");
include_once("conexion/database.php");

include("sidebar.php");

// Variable para manejar mensajes de confirmación
$mensaje = "";
if (isset($_GET["mensaje"])) $mensaje = $_GET["mensaje"];
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Lista de Contratos de Entrenadores</h1>
                </div>
                <div class="col-sm-6">
                    <a href="contrato_personal_detalle.php?sAccion=new" class="btn btn-primary float-sm-right" style="background-color: orange;">
                        Agregar Nuevo Contrato
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-body">
                <?php
                // Consulta SQL para obtener todos los contratos
                $sql = "SELECT id_contrato, nombre_entrenador, telefono, salario, estado, dias_disponibles, hora_inicio, hora_fin, tipo_entrenamiento, capacidad 
                        FROM contrato_personal";
                $result = dbQuery($sql);
                $total_registros = mysqli_num_rows($result);
                ?>

                <table id="listado" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID Contrato</th>
                            <th>Nombre Entrenador</th>
                            <th>Teléfono</th>
                            <th>Salario</th>
                            <th>Estado</th>
                            <th>Días Disponibles</th>
                            <th>Hora Inicio</th>
                            <th>Hora Fin</th>
                            <th>Tipo Entrenamiento</th>
                            <th>Capacidad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($total_registros > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td><?php echo $row["id_contrato"]; ?></td>
                                    <td><?php echo $row["nombre_entrenador"]; ?></td>
                                    <td><?php echo $row["telefono"]; ?></td>
                                    <td>S/ <?php echo number_format($row["salario"], 2); ?></td>
                                    <td><?php echo $row["estado"]; ?></td>
                                    <td><?php echo $row["dias_disponibles"]; ?></td>
                                    <td><?php echo $row["hora_inicio"]; ?></td>
                                    <td><?php echo $row["hora_fin"]; ?></td>
                                    <td><?php echo $row["tipo_entrenamiento"]; ?></td>
                                    <td><?php echo $row["capacidad"]; ?></td>
                                    <td>
                                        <a href="contrato_personal_detalle.php?sAccion=edit&id_contrato=<?php echo $row['id_contrato']; ?>" class="btn btn-info btn-sm">Editar</a>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='11'>No existen contratos registrados</td></tr>";
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
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#listado_wrapper .col-md-6:eq(0)');
});
</script>

<?php
// Mostrar mensajes TOASTR
if ($mensaje == '1') { ?>
    <script>toastr.success("El contrato se registró correctamente.");</script>
<?php } elseif ($mensaje == '2') { ?>
    <script>toastr.info("El contrato se actualizó correctamente.");</script>
<?php } ?>
