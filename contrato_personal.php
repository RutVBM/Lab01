<?php
include("header.php");
include_once("conexion/database.php");

// Procesar la inserción de un nuevo contrato si se envía el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_personal = $_POST["nombre_personal"];
    $DNI_personal = $_POST["DNI_personal"];
    $telefono = $_POST["telefono"];
    $email = $_POST["email"];
    $Finicio_contrato_per = $_POST["Finicio_contrato_per"];
    $Ffin_contrato_per = $_POST["Ffin_contrato_per"];

    // Insertar el nuevo contrato en la base de datos
    $sql = "INSERT INTO contrato_personal (nombre_personal, DNI_personal, telefono, email, Finicio_contrato_per, Ffin_contrato_per)
            VALUES (?, ?, ?, ?, ?, ?)";
    dbQuery($sql, [$nombre_personal, $DNI_personal, $telefono, $email, $Finicio_contrato_per, $Ffin_contrato_per]);

    // Redirigir después de la inserción
    header("Location: contrato_personal.php?mensaje=success");
    exit();
}

include("sidebar.php");
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Lista de Contratos de Personal</h1>
                </div>
                <div class="col-sm-6">
                    <button type="button" class="btn btn-primary float-sm-right" onclick="document.getElementById('addContractForm').style.display='block';" style="background-color: orange;">Agregar Nuevo Contrato</button>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-body">
                <?php
                // Consultar todos los contratos de la tabla `contrato_personal`
                $sql = "SELECT idContratos_personal, nombre_personal, DNI_personal, telefono, email, Finicio_contrato_per, Ffin_contrato_per
                        FROM contrato_personal
                        ORDER BY nombre_personal";
                $result = dbQuery($sql);
                ?>

                <table id="listado" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>DNI</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                    <td>{$row['nombre_personal']}</td>
                                    <td>{$row['DNI_personal']}</td>
                                    <td>{$row['telefono']}</td>
                                    <td>{$row['email']}</td>
                                    <td>{$row['Finicio_contrato_per']}</td>
                                    <td>{$row['Ffin_contrato_per']}</td>
                                    <td><button class='btn btn-info' onclick=\"location.href='contrato_personal_detalle.php?id={$row['idContratos_personal']}'\">Ver / Editar</button></td>
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
    </section>
</div>

<!-- Formulario para agregar un nuevo contrato -->
<div id="addContractForm" style="display:none;" class="content-wrapper">
    <section class="content">
        <div class="card">
            <div class="card-body">
                <h3>Agregar Nuevo Contrato</h3>
                <form action="contrato_personal.php" method="post">
                    <div class="form-group">
                        <label for="nombre_personal">Nombre del Personal:</label>
                        <input type="text" name="nombre_personal" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="DNI_personal">DNI:</label>
                        <input type="text" name="DNI_personal" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono:</label>
                        <input type="text" name="telefono" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="Finicio_contrato_per">Fecha de Inicio:</label>
                        <input type="date" name="Finicio_contrato_per" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="Ffin_contrato_per">Fecha de Fin:</label>
                        <input type="date" name="Ffin_contrato_per" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success" style="background-color: orange;">Guardar</button>
                    <button type="button" class="btn btn-secondary" onclick="document.getElementById('addContractForm').style.display='none';">Cancelar</button>
                </form>
            </div>
        </div>
    </section>
</div>

<?php include("footer.php"); ?>

<!-- Script para DataTables -->
<script>
$(function () {
    $("#listado").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#listado_wrapper .col-md-6:eq(0)');
});
</script>
<script src="../Lab01/plugins/jquery/jquery.min.js"></script>
<script src="../Lab01/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../Lab01/dist/js/adminlte.min.js"></script>
