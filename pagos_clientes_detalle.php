<?php
ob_start();
include("header.php");
include_once("conexion/database.php");

$sAccion = $_GET["sAccion"] ?? $_POST["sAccion"] ?? "";
$sTitulo = $sAccion == "new" ? "Registrar un nuevo plan de entrenamiento" : "Modificar los datos del plan de entrenamiento";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $idplan = $_POST["idplan"];
    $metodo_pago = $_POST["metodo_pago"];

    // Aquí puedes guardar el método de pago y otros detalles necesarios en la base de datos
    header("Location: pagos_clientes.php?mensaje=success");
    exit();
}

include("sidebar.php");
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1><?= $sTitulo ?></h1>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-body">
                <form method="post" action="pagos_clientes_detalle.php">
                    <div class="form-group">
                        <label>Nombre del Plan (*):</label>
                        <select name="idplan" id="idplan" class="form-control" required onchange="updatePlanDetails()">
                            <option value="">Seleccione un plan</option>
                            <?php
                            $sql = "SELECT idplan, nombre_plan FROM planes_entrenamiento";
                            $result = dbQuery($sql);
                            while ($plan = mysqli_fetch_assoc($result)) {
                                echo "<option value='{$plan['idplan']}'>{$plan['nombre_plan']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Duración (*):</label>
                        <input type="text" id="duracion" class="form-control" readonly placeholder="Duración en meses">
                    </div>

                    <div class="form-group">
                        <label>Precio (*):</label>
                        <input type="text" id="precio" class="form-control" readonly placeholder="Precio en soles">
                    </div>

                    <div class="form-group">
                        <label>Método de Pago (*):</label>
                        <select name="metodo_pago" class="form-control" required>
                            <option value="Efectivo">Efectivo</option>
                            <option value="Tarjeta">Tarjeta</option>
                            <option value="Transferencia">Transferencia</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">Guardar</button>
                </form>
            </div>
        </div>
    </section>
</div>

<?php include("footer.php"); ?>

<script>
// Función para actualizar los detalles del plan al seleccionar un nombre
function updatePlanDetails() {
    var idPlan = document.getElementById('idplan').value;

    if (idPlan) {
        fetch('obtener_detalles_plan.php?idplan=' + idPlan)
            .then(response => response.json())
            .then(data => {
                document.getElementById('duracion').value = data.duracion + " meses";
                document.getElementById('precio').value = "S/ " + data.precio;
            })
            .catch(error => console.error('Error:', error));
    } else {
        document.getElementById('duracion').value = '';
        document.getElementById('precio').value = '';
    }
}
</script>
