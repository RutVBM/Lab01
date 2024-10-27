<?php
ob_start();
include("header.php");
include_once("conexion/database.php");

$sAccion = $_GET["sAccion"] ?? $_POST["sAccion"] ?? "";
$sTitulo = "Renovación de Plan";

include("sidebar.php");
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1><?= $sTitulo ?></h1>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-body">
                <form method="post" action="procesar_renovacion.php">
                    <!-- Campo desplegable para seleccionar el nombre del plan -->
                    <div class="form-group">
                        <label>Nombre del Plan (*):</label>
                        <select name="nombre_plan" id="nombre_plan" class="form-control" required onchange="cargarDetallesPlan()">
                            <option value="">Seleccione un plan</option>
                            <?php
                            $query = "SELECT idplan, nombre_plan FROM planes_entrenamiento WHERE estado = 'A'";
                            $result = dbQuery($query);
                            while ($plan = mysqli_fetch_assoc($result)) {
                                echo "<option value='{$plan['idplan']}'>{$plan['nombre_plan']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Campos para mostrar la duración y el precio -->
                    <div class="form-group">
                        <label>Duración (*):</label>
                        <input type="text" id="duracion" name="duracion" class="form-control" readonly placeholder="Duración en meses">
                    </div>

                    <div class="form-group">
                        <label>Precio (*):</label>
                        <input type="text" id="precio" name="precio" class="form-control" readonly placeholder="Precio en soles">
                    </div>

                    <!-- Campo para seleccionar el método de pago -->
                    <div class="form-group">
                        <label>Método de Pago (*):</label>
                        <select name="metodo_pago" class="form-control" required>
                            <option value="efectivo">Efectivo</option>
                            <option value="tarjeta">Tarjeta</option>
                            <option value="transferencia">Transferencia</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">Renovar</button>
                </form>
            </div>
        </div>
    </section>
</div>

<?php include("footer.php"); ?>

<script>
// Función para cargar la duración y el precio del plan seleccionado
function cargarDetallesPlan() {
    var idplan = document.getElementById("nombre_plan").value;
    if (idplan) {
        // Llamada AJAX a obtener_detalles_plan.php
        fetch(`obtener_detalles_plan.php?idplan=${idplan}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById("duracion").value = data.duracion + " meses";
                document.getElementById("precio").value = "S/ " + data.precio;
            })
            .catch(error => console.error("Error:", error));
    } else {
        // Limpiar los campos si no se selecciona un plan
        document.getElementById("duracion").value = "";
        document.getElementById("precio").value = "";
    }
}
</script>
