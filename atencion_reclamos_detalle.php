<?php
ob_start(); // Inicia el buffer de salida para evitar errores de header
include("header.php"); 
include_once("conexion/database.php"); 

// Inicialización de variables
$sAccion = $_GET["sAccion"] ?? $_POST["sAccion"] ?? "";
$sTitulo = $sAccion == "new" ? "Registrar un nuevo reclamo" : "Modificar Reclamo";
$idreclamo = $_POST["idreclamo"] ?? "";
$idcliente = $descripcion = $estado = "";

// Verificar la acción y cargar datos si es necesario
if ($sAccion == "edit" && isset($_GET["idreclamo"])) {
    $idreclamo = $_GET["idreclamo"];

    // Cargar datos del reclamo a editar
    $stmt = dbQuery("SELECT * FROM atencion_reclamos WHERE idreclamo = ?", [$idreclamo]);
    if ($stmt && $row = $stmt->fetch_assoc()) {
        $idcliente = $row["idcliente"];
        $descripcion = $row["descripcion"];
        $estado = $row["estado"];
    } else {
        echo "Error: Reclamo no encontrado.";
        exit();
    }
}

// Procesar inserción o actualización de datos
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $idcliente = $_POST["idcliente"];
    $descripcion = $_POST["descripcion"];
    $estado = $_POST["estado"];

    if ($sAccion == "insert") {
        // Validar si el cliente existe
        $cliente = dbQuery("SELECT * FROM cliente WHERE idcliente = ?", [$idcliente]);
        if ($cliente->num_rows == 0) {
            die("Error: El cliente seleccionado no existe.");
        }

        // Insertar nuevo reclamo
        $sql = "INSERT INTO atencion_reclamos (idcliente, descripcion, estado, fecha_reclamo) 
                VALUES (?, ?, ?, NOW())";
        dbQuery($sql, [$idcliente, $descripcion, $estado]);

        header("Location: atencion_reclamos.php");
        exit(); // Detener ejecución después de redirigir
    } elseif ($sAccion == "update") {
        $idreclamo = $_POST["idreclamo"];

        // Actualizar reclamo existente
        $sql = "UPDATE atencion_reclamos 
                SET idcliente = ?, descripcion = ?, estado = ? 
                WHERE idreclamo = ?";
        dbQuery($sql, [$idcliente, $descripcion, $estado, $idreclamo]);

        header("Location: atencion_reclamos.php");
        exit(); // Detener ejecución después de redirigir
    }
}
?>

<?php include("sidebar.php"); ?>

<!-- Contenido Principal -->
<div class="content-wrapper">
    <section class="content-header">
        <h1><?= $sTitulo ?></h1>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Por favor, complete los datos del reclamo:</h3>
            </div>

            <div class="card-body">
                <form action="atencion_reclamos_detalle.php" method="post">
                    <input type="hidden" name="sAccion" value="<?= $sAccion == 'new' ? 'insert' : 'update' ?>">
                    <input type="hidden" name="idreclamo" value="<?= $idreclamo ?>">

                    <div class="form-group">
                        <label for="idcliente">Seleccionar Cliente (*):</label>
                        <select name="idcliente" id="idcliente" class="form-control" required>
                            <?php
                            $clientes = dbQuery("SELECT idcliente, nombre FROM cliente");
                            while ($cliente = $clientes->fetch_assoc()) {
                                $selected = ($cliente['idcliente'] == $idcliente) ? 'selected' : '';
                                echo "<option value='{$cliente['idcliente']}' $selected>{$cliente['nombre']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Descripción del Reclamo (*):</label>
                        <textarea name="descripcion" id="descripcion" class="form-control" required><?= $descripcion ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="estado">Estado:</label>
                        <select name="estado" id="estado" class="form-control">
                            <option value="pendiente" <?= $estado == 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
                            <option value="resuelto" <?= $estado == 'resuelto' ? 'selected' : '' ?>>Resuelto</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">Guardar</button>
                </form>
            </div>
        </div>
    </section>
</div>

<?php include("footer.php"); ?>
<?php ob_end_flush(); // Enviar el contenido del buffer ?>
