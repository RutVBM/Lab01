<?php
ob_start(); // Inicia el buffer de salida
include("header.php");
include_once("conexion/database.php");

// Inicialización de variables
$sAccion = $_GET["sAccion"] ?? $_POST["sAccion"] ?? "new";
$sTitulo = $sAccion == "new" ? "Registrar un nuevo pago" : "Modificar datos del pago";
$sCambioAccion = $sAccion == "new" ? "insert" : "update";

$tipo_plan = $nombre_plan = $duracion = $precio = $metodo_pago = "";

// Cargar planes en el desplegable
$planesQuery = "SELECT idplan, tipo_plan, nombre_plan, duracion, precio FROM planes_entrenamiento WHERE estado = 'A'";
$planesResult = dbQuery($planesQuery);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $tipo_plan = $_POST["tipo_plan"];
    $nombre_plan = $_POST["nombre_plan"];
    $duracion = $_POST["duracion"];
    $precio = $_POST["precio"];
    $metodo_pago = $_POST["metodo_pago"];

    if ($sCambioAccion == "insert") {
        $sql = "INSERT INTO pago_clientes (tipo_plan, nombre_plan, duracion, precio, metodo_pago, fecha_pago) 
                VALUES ('$tipo_plan', '$nombre_plan', '$duracion', '$precio', '$metodo_pago', CURDATE())";
    } else {
        // Para actualización de pago
        $id_pago = $_POST["id_pago"];
        $sql = "UPDATE pago_clientes 
                SET tipo_plan = '$tipo_plan', nombre_plan = '$nombre_plan', duracion = '$duracion', 
                    precio = '$precio', metodo_pago = '$metodo_pago' WHERE id_pago = $id_pago";
    }
    dbQuery($sql);
    header("Location: pagos_clientes.php?mensaje=success");
    exit(); // Detener ejecución después de la redirección
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
                <form method="post">
                    <input type="hidden" name="sAccion" value="<?= $sCambioAccion ?>">

                    <div class="form-group">
                        <label>Tipo de Plan (*):</label>
                        <select name="tipo_plan" class="form-control" required>
                            <option value="individual" <?= $tipo_plan == 'individual' ? 'selected' : '' ?>>Individual</option>
                            <option value="grupal" <?= $tipo_plan == 'grupal' ? 'selected' : '' ?>>Grupal</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Nombre del Plan (*):</label>
                        <select name="nombre_plan" class="form-control" id="nombre_plan" onchange="actualizarDatosPlan()" required>
                            <option value="">Seleccione un plan</option>
                            <?php while ($plan = mysqli_fetch_assoc($planesResult)): ?>
                                <option value="<?= $plan['idplan'] ?>" data-duracion="<?= $plan['duracion'] ?>" data-precio="<?= $plan['precio'] ?>"
                                    <?= $nombre_plan == $plan['nombre_plan'] ? 'selected' : '' ?>>
                                    <?= $plan['nombre_plan'] ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Duración (*):</label>
                        <input type="text" name="duracion" class="form-control" id="duracion" placeholder="Duración en meses" value="<?= $duracion ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label>Precio (*):</label>
                        <input type="text" name="precio" class="form-control" id="precio" placeholder="Precio en soles" value="<?= $precio ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label>Método de Pago (*):</label>
                        <select name="metodo_pago" class="form-control" required>
                            <option value="efectivo" <?= $metodo_pago == 'efectivo' ? 'selected' : '' ?>>Efectivo</option>
                            <option value="tarjeta" <?= $metodo_pago == 'tarjeta' ? 'selected' : '' ?>>Tarjeta</option>
                            <option value="transferencia" <?= $metodo_pago == 'transferencia' ? 'selected' : '' ?>>Transferencia</option>
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
    // Función para actualizar la duración y el precio del plan seleccionado
    function actualizarDatosPlan() {
        const select = document.getElementById("nombre_plan");
        const duracionInput = document.getElementById("duracion");
        const precioInput = document.getElementById("precio");

        const selectedOption = select.options[select.selectedIndex];
        const duracion = selectedOption.getAttribute("data-duracion");
        const precio = selectedOption.getAttribute("data-precio");

        duracionInput.value = duracion || "";  // Asigna la duración si existe
        precioInput.value = precio || "";      // Asigna el precio si existe
    }
</script>

