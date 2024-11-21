<?php
ob_start(); // Inicia el buffer de salida
include("header.php");

// Filtrar por tipo de plan si es necesario
$tipo_plan = isset($_POST["tipo_plan"]) ? $_POST["tipo_plan"] : "";

include("sidebar.php");

// Eliminar plan si se recibió la acción delete
if (isset($_GET['sAccion']) && $_GET['sAccion'] == 'delete' && isset($_GET['idplan'])) {
    $idplan = $_GET['idplan'];
    $sql = "DELETE FROM planes_entrenamiento WHERE idplan = $idplan";
    dbQuery($sql);
    header("Location: planes_entrenamiento.php?mensaje=deleted");
    exit();
}
?>

<script type="text/javascript">
// Funciones para gestionar planes
function NewPlan() {
    window.location.href = "planes_entrenamiento_detalle.php?sAccion=new";
}

function EditPlan(idplan) {
    window.location.href = "planes_entrenamiento_detalle.php?sAccion=edit&idplan=" + idplan;
}

function DeletePlan(idplan) {
    if (confirm("¿Estás seguro de que deseas eliminar este plan? Esta acción no se puede deshacer.")) {
        window.location.href = "planes_entrenamiento.php?sAccion=delete&idplan=" + idplan;
    }
}
</script>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Lista de Planes de Entrenamiento</h1>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <form action="planes_entrenamiento.php" method="post">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Tipo de Plan:</label>
                                <select class="form-control" name="tipo_plan">
                                    <option value="">TODOS</option>
                                    <option value="individual" <?= $tipo_plan == "individual" ? "selected" : "" ?>>Individual</option>
                                    <option value="grupal" <?= $tipo_plan == "grupal" ? "selected" : "" ?>>Grupal</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Consultar</button>
                                <button type="button" class="btn btn-success" onclick="NewPlan();">Nuevo Plan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <?php
            $sql = "SELECT idplan, tipo_plan, nombre_plan, duracion, precio, estado, fecharegistro 
                    FROM planes_entrenamiento WHERE idplan > 0";
            if ($tipo_plan != "") $sql .= " AND tipo_plan = '$tipo_plan'";
            $sql .= " ORDER BY nombre_plan";

            $result = dbQuery($sql);
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
                        <?php if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_array($result)) {
                                $estado = $row["estado"] == "A" ? "Activo" : "Inactivo";
                                ?>
                                <tr>
                                    <td><?= $row["nombre_plan"] ?></td>
                                    <td><?= ucfirst($row["tipo_plan"]) ?></td>
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
