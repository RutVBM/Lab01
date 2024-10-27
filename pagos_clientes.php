<?php
ob_start(); // Inicia el buffer de salida

include("header.php");
include_once("conexion/database.php");

// Filtrar por tipo de plan y nombre de plan si es necesario
$tipo_plan = isset($_POST["tipo_plan"]) ? $_POST["tipo_plan"] : "";
$nombre_plan = isset($_POST["nombre_plan"]) ? $_POST["nombre_plan"] : "";

include("sidebar.php");

// Eliminar plan si se recibe la acción delete
if (isset($_GET['sAccion']) && $_GET['sAccion'] == 'delete' && isset($_GET['idplan'])) {
    $idplan = $_GET['idplan'];
    $sql = "DELETE FROM planes_entrenamiento WHERE idplan = $idplan";
    dbQuery($sql);
    header("Location: pagos_clientes.php?mensaje=deleted");
    exit();
}
?>

<script type="text/javascript">
// Redireccionar para crear un nuevo plan
function NewPlan() {
    window.location.href = "pagos_clientes_detalle.php?sAccion=new";
}

// Redireccionar para editar un plan existente
function EditPlan(idplan) {
    window.location.href = "pagos_clientes_detalle.php?sAccion=edit&idplan=" + idplan;
}

// Confirmar y eliminar un plan
function DeletePlan(idplan) {
    if (confirm("¿Estás seguro de que deseas eliminar este plan? Esta acción no se puede deshacer.")) {
        window.location.href = "pagos_clientes.php?sAccion=delete&idplan=" + idplan;
    }
}
</script>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Lista de Planes de Entrenamiento</h1>
                </div>
                <div class="col-sm-6">
                    <button type="button" class="btn btn-success float-sm-right" onclick="NewPlan();">Nuevo Plan</button>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <form action="pagos_clientes.php" method="post">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label>Tipo de Plan:</label>
                                <select class="form-control" name="tipo_plan">
                                    <option value="">TODOS</option>
                                    <option value="individual" <?= $tipo_plan == "individual" ? "selected" : "" ?>>Individual</option>
                                    <option value="grupal" <?= $tipo_plan == "grupal" ? "selected" : "" ?>>Grupal</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label>Nombre del Plan:</label>
                                <select class="form-control" name="nombre_plan">
                                    <option value="">TODOS</option>
                                    <?php
                                    $query = "SELECT DISTINCT nombre_plan FROM planes_entrenamiento ORDER BY nombre_plan";
                                    $result = dbQuery($query);
                                    while ($plan = mysqli_fetch_assoc($result)) {
                                        $selected = ($plan['nombre_plan'] == $nombre_plan) ? "selected" : "";
                                        echo "<option value='{$plan['nombre_plan']}' $selected>{$plan['nombre_plan']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Consultar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <?php
            // Construir la consulta SQL para mostrar los planes de acuerdo a los filtros
            $sql = "SELECT idplan, tipo_plan, nombre_plan, duracion, precio, estado, fecharegistro 
                    FROM planes_entrenamiento WHERE idplan > 0";

            if ($tipo_plan != "") $sql .= " AND tipo_plan = '$tipo_plan'";
            if ($nombre_plan != "") $sql .= " AND nombre_plan = '$nombre_plan'";

            $sql .= " ORDER BY nombre_plan";
            $result = dbQuery($sql);
            $total_registros = mysqli_num_rows($result);
            ?>

            <div class="card-body">
                <table id="listado" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nombre del Plan</th>
                            <th>Tipo de Plan</th>
                            <th>Duración</th>
                            <th>Precio</th>
                            <th>Estado</th>
                            <th>Fecha de Registro</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($total_registros > 0) {
                            while ($row = mysqli_fetch_array($result)) {
                                $estado = $row["estado"] == "A" ? "Activo" : "Inactivo";
                                $tipo_plan = ucfirst($row["tipo_plan"]); ?>
                                <tr>
                                    <td><?= $row["nombre_plan"] ?></td>
                                    <td><?= $tipo_plan ?></td>
                                    <td><?= $row["duracion"] ?> meses</td>
                                    <td>S/ <?= $row["precio"] ?></td>
                                    <td><?= $estado ?></td>
                                    <td><?= $row["fecharegistro"] ?></td>
                                    <td>
                                        <button type="button" class="btn btn-info" onclick="EditPlan(<?= $row['idplan'] ?>);">Editar</button>
                                        <button type="button" class="btn btn-danger" onclick="DeletePlan(<?= $row['idplan'] ?>);">Eliminar</button>
                                    </td>
                                </tr>
                            <?php }
                        } else { ?>
                            <tr><td colspan="7">No existen registros</td></tr>
                        <?php } ?>
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
