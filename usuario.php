<?php
include("header.php");
include_once("conexion/database.php");

// Procesar la inserción de un nuevo usuario si se envía el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $apellidos = $_POST["apellidos"];
    $fechnac = $_POST["fechnac"];
    $correo = $_POST["correo"];
    $clave = $_POST["clave"];
    $estado = $_POST["estado"];
    $fechregistro = date("Y-m-d");

    // Insertar el nuevo usuario en la base de datos
    $sql = "INSERT INTO usuario (nombre, apellidos, fechnac, correo, clave, estado, fechregistro) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    dbQuery($sql, [$nombre, $apellidos, $fechnac, $correo, $clave, $estado, $fechregistro]);

    // Redirigir para evitar reenvío de formulario
    header("Location: usuario.php?mensaje=success");
    exit();
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
                    <h1>Lista de usuarios</h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Formulario para agregar un nuevo usuario -->
        <div class="card card-primary">
            <div class="card-header" style="background-color: orange; color: white;">
                <h3 class="card-title">Agregar Nuevo Usuario</h3>
            </div>
            <div class="card-body">
                <form action="usuario.php" method="post">
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="apellidos">Apellidos:</label>
                        <input type="text" name="apellidos" id="apellidos" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="fechnac">Fecha de Nacimiento:</label>
                        <input type="date" name="fechnac" id="fechnac" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo:</label>
                        <input type="email" name="correo" id="correo" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="clave">Clave:</label>
                        <input type="password" name="clave" id="clave" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="estado">Estado:</label>
                        <select name="estado" id="estado" class="form-control" required>
                            <option value="A">Activo</option>
                            <option value="I">Inactivo</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success" style="background-color: orange; color: white;">Guardar</button>
                </form>
            </div>
        </div>

        <!-- Tabla de usuarios -->
        <div class="card">
            <div class="card-body">
                <?php
                $sql = "SELECT idusuario, nombre, apellidos, fechnac, correo, clave, estado, fechregistro FROM usuario ORDER BY apellidos, nombre, fechnac";
                $result = dbQuery($sql);
                $total_registros = mysqli_num_rows($result);
                ?>
                <table id="listado" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Fecha de nacimiento</th>
                        <th>Correo</th>
                        <th>Clave</th>
                        <th>Estado</th>
                        <th>Registro</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                    if ($total_registros > 0) {
                        while ($row = mysqli_fetch_array($result)) {
                            $estado = $row["estado"] == "A" ? "Activo" : "Inactivo";
                            ?>
                            <tr>
                                <td><?= $row["nombre"]; ?></td>
                                <td><?= $row["apellidos"]; ?></td>
                                <td><?= $row["fechnac"]; ?></td>
                                <td><?= $row["correo"]; ?></td>
                                <td><?= $row["clave"]; ?></td>
                                <td><?= $estado; ?></td>
                                <td><?= $row["fechregistro"]; ?></td>
                            </tr>
                            <?php
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

<?php include("footer.php"); ?>

<!-- Page specific script -->
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

