<?php
session_start(); // Inicia la sesión para acceder a las variables
include("header.php");

// Verificar que el usuario esté autenticado y que su correo esté en la sesión
if (!isset($_SESSION["CORREO"])) {
    die("Error: No se encontró el correo en la sesión. Por favor, inicie sesión nuevamente.");
}

// Obtener el correo del usuario logueado desde la sesión
$idcliente = $_SESSION["CORREO"];

// Determinar la acción (insertar o editar)
$sAccion = $_GET["sAccion"] ?? $_POST["sAccion"] ?? "";
$sTitulo = $sAccion == "new" ? "Registrar un nuevo plan de entrenamiento" : "Modificar los datos del plan de entrenamiento";
$sCambioAccion = $sAccion == "new" ? "insert" : "update";

// Si es edición, obtener los datos del plan
if ($sAccion == "edit" && isset($_GET["idplan"])) {
    $idplan = $_GET["idplan"];
    $sql = "SELECT * FROM planes_entrenamiento WHERE idplan = $idplan";
    $result = dbQuery($sql);
    $row = mysqli_fetch_array($result);
    $tipo_plan = $row["tipo_plan"];
    $nombre_plan = $row["nombre_plan"];
    $duracion = $row["duracion"];
    $precio = $row["precio"];
    $estado = $row["estado"];
} else {
    $idplan = $tipo_plan = $nombre_plan = $duracion = $precio = "";
    $estado = "A";
}

// Procesar el formulario al enviarlo
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $idplan = $_POST["idplan"];
    $tipo_plan = $_POST["tipo_plan"];
    $nombre_plan = $_POST["nombre_plan"];
    $duracion = $_POST["duracion"];
    $precio = $_POST["precio"];
    $estado = $_POST["estado"];

    if ($sCambioAccion == "insert") {
        // Insertar un nuevo plan asociado al correo del usuario logueado
        $sql = "INSERT INTO planes_entrenamiento (tipo_plan, nombre_plan, duracion, precio, estado, fecharegistro, idcliente) 
                VALUES ('$tipo_plan', '$nombre_plan', '$duracion', '$precio', '$estado', CURDATE(), '$idcliente')";
    } else {
        // Actualizar el plan existente
        $sql = "UPDATE planes_entrenamiento 
                SET tipo_plan = '$tipo_plan', nombre_plan = '$nombre_plan', duracion = '$duracion', 
                    precio = '$precio', estado = '$estado' WHERE idplan = $idplan";
    }

    // Ejecutar la consulta
    dbQuery($sql);

    // Redireccionar al listado de planes
    header("Location: planes_entrenamiento.php?mensaje=success");
    exit(); // Detener la ejecución del código después de redirigir
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
                    <input type="hidden" name="idplan" value="<?= $idplan ?>">

                    <div class="form-group">
                        <label>Tipo de Plan (*):</label>
                        <input type="text" name="tipo_plan" class="form-control" value="<?= $tipo_plan ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Nombre del Plan (*):</label>
                        <input type="text" name="nombre_plan" class="form-control" value="<?= $nombre_plan ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Duración (*):</label>
                        <input type="number" name="duracion" class="form-control" value="<?= $duracion ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Precio (*):</label>
                        <input type="number" step="0.01" name="precio" class="form-control" value="<?= $precio ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Estado:</label>
                        <select name="estado" class="form-control">
                            <option value="A" <?= $estado == 'A' ? 'selected' : '' ?>>Activo</option>
                            <option value="I" <?= $estado == 'I' ? 'selected' : '' ?>>Inactivo</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">Guardar</button>
                </form>
            </div>
        </div>
    </section>
</div>

<?php include("footer.php"); ?>
