<?php
session_start();
include("header.php");
include_once("conexion/database.php");

// Capturar el idusuario del usuario desde la sesión
$idUsuario = $_SESSION["IDUSUARIO"] ?? null;

// Si no hay idusuario en la sesión, mostrar un error
if (!$idUsuario) {
    die("Error: No se encontró el ID del usuario en la sesión.");
}

$sAccion = $_GET["sAccion"] ?? "new";
$sTitulo = $sAccion == "new" ? "Registrar un Nuevo Pago" : "Modificar Pago";

// Procesar el formulario al enviarlo
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $idplan = $_POST["idplan"];
    $metodo_pago = $_POST["metodo_pago"];

    if ($idplan && $metodo_pago) {
        // Obtener los detalles del plan seleccionado
        $sqlPlan = "SELECT tipo_plan, nombre_plan, duracion, precio FROM planes_entrenamiento WHERE idplan = ?";
        $resultPlan = dbQuery($sqlPlan, [$idplan]);

        if ($resultPlan && $plan = $resultPlan->fetch_assoc()) {
            $tipo_plan = $plan["tipo_plan"];
            $nombre_plan = $plan["nombre_plan"];
            $duracion = $plan["duracion"];
            $precio = $plan["precio"];

            // Insertar el pago en la base de datos con el idusuario
            $sqlInsert = "INSERT INTO pago_clientes (idusuario, tipo_plan, nombre_plan, duracion, precio, metodo_pago, fecha_pago) 
                          VALUES (?, ?, ?, ?, ?, ?, CURDATE())";
            dbQuery($sqlInsert, [$idUsuario, $tipo_plan, $nombre_plan, $duracion, $precio, $metodo_pago]);

            // Redirigir a la lista de pagos
            header("Location: pagos_clientes.php?mensaje=success");
            exit();
        } else {
            $error = "No se pudo obtener la información del plan seleccionado.";
        }
    } else {
        $error = "Por favor, complete todos los campos.";
    }
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
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>

                <form method="post">
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
                        <label>Duración:</label>
                        <input type="text" id="duracion" class="form-control" readonly placeholder="Duración en meses">
                    </div>

                    <div class="form-group">
                        <label>Precio:</label>
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
