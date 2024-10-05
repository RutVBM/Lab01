<?php
include ("header.php");

$sAccion = "";
$sSubTitulo = "";  // Definir $sSubTitulo para evitar el error de variable no definida
$sTitulo = "";  // Definir $sTitulo para evitar el error de variable no definida

if (isset($_GET["sAccion"])) {
    $sAccion = $_GET["sAccion"]; // new / edit
} elseif (isset($_POST["sAccion"])) {
    $sAccion = $_POST["sAccion"]; // insert / update
}

// Acción 1: Creación de un nuevo plan de entrenamiento
if ($sAccion == "new") {
    $sTitulo = "Registrar un nuevo plan de entrenamiento";
    $sSubTitulo = "Por favor, ingresar la información del plan [(*) datos obligatorios]:";
    $sCambioAccion = "insert";
    // Valores por defecto
    $idplan = "";
    $tipo_plan = "";
    $nombre_plan = "";
    $duracion = "";
    $precio = "";
    $estado = "A"; // Activo por defecto
    $fecharegistro = date("Y-m-d"); // Fecha actual por defecto
}
// Acción 2: Editar datos existentes del plan
elseif ($sAccion == "edit") {
    $sTitulo = "Modificar los datos del plan de entrenamiento";
    $sSubTitulo = "Por favor, actualizar la información del plan [(*) datos obligatorios]:";
    $sCambioAccion = "update";
    if (isset($_GET["idplan"])) $idplan = $_GET["idplan"];
    
    // Buscando los últimos datos registrados
    $sql = "SELECT * FROM planes_entrenamiento WHERE idplan = $idplan";
    $result = dbQuery($sql);
    if ($row = mysqli_fetch_array($result)) {
        $tipo_plan = $row["tipo_plan"];
        $nombre_plan = $row["nombre_plan"];
        $duracion = $row["duracion"];
        $precio = $row["precio"];
        $estado = $row["estado"];
        $fecharegistro = $row["fecharegistro"];
    }
}
// Acción 3: Insertar un nuevo plan en la base de datos
elseif ($sAccion == "insert") {
    $tipo_plan = $_POST["tipo_plan"];
    $nombre_plan = $_POST["nombre_plan"];
    $duracion = $_POST["duracion"];
    $precio = $_POST["precio"];
    $estado = $_POST["estado"];
    $fecharegistro = date("Y-m-d"); // Se registra la fecha actual
    
    // SQL para insertar un nuevo plan
    $sql = "INSERT INTO planes_entrenamiento (tipo_plan, nombre_plan, duracion, precio, estado, fecharegistro) 
            VALUES ('$tipo_plan', '$nombre_plan', '$duracion', '$precio', '$estado', '$fecharegistro')";
    dbQuery($sql);
    
    // Redirigir después de insertar
    $mensaje = "1";
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $pagina = 'planes_entrenamiento.php?mensaje=' . $mensaje;
    header("Location: http://$host$uri/$pagina");
}
// Acción 4: Actualizar datos de un plan existente
elseif ($sAccion == "update") {
    $idplan = $_POST["idplan"];
    $tipo_plan = $_POST["tipo_plan"];
    $nombre_plan = $_POST["nombre_plan"];
    $duracion = $_POST["duracion"];
    $precio = $_POST["precio"];
    $estado = $_POST["estado"];
    
    // SQL para actualizar el plan
    $sql = "UPDATE planes_entrenamiento SET tipo_plan = '$tipo_plan', nombre_plan = '$nombre_plan', duracion = '$duracion', 
            precio = '$precio', estado = '$estado' WHERE idplan = $idplan";
    dbQuery($sql);
    
    // Redirigir después de actualizar
    $mensaje = "2";
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $pagina = 'planes_entrenamiento.php?mensaje=' . $mensaje;
    header("Location: http://$host$uri/$pagina");
}
?>

<?php
include ("sidebar.php");
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?php echo $sTitulo; ?></h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?php echo $sSubTitulo; ?></h3>
            </div>
            <!-- /.card-header -->

            <!-- Este formulario llenará los datos que nosotros vamos a ingresar -->
            <div class="card-body">
                <form name="frmDatos" action="planes_entrenamiento_detalle.php" method="post">
                    <input type="text" name="sAccion" value="<?php echo $sCambioAccion; ?>" hidden>
                    <input type="text" name="idplan" value="<?php echo $idplan; ?>" hidden>
                    
                    <div class="form-group">
                        <label for="tipo_plan">Tipo de Plan (*):</label>
                        <input type="text" name="tipo_plan" id="tipo_plan" class="form-control" value="<?php echo $tipo_plan; ?>" required />
                    </div>

                    <div class="form-group">
                        <label for="nombre_plan">Nombre del Plan (*):</label>
                        <input type="text" name="nombre_plan" id="nombre_plan" class="form-control" value="<?php echo $nombre_plan; ?>" required />
                    </div>

                    <div class="form-group">
                        <label for="duracion">Duración (*):</label>
                        <input type="text" name="duracion" id="duracion" class="form-control" value="<?php echo $duracion; ?>" required />
                    </div>

                    <div class="form-group">
                        <label for="precio">Precio (*):</label>
                        <input type="text" name="precio" id="precio" class="form-control" value="<?php echo $precio; ?>" required />
                    </div>

                    <div class="form-group">
                        <label for="estado">Estado:</label>
                        <select name="estado" id="estado" class="form-control">
                            <option value="A" <?php if($estado == 'A') echo 'selected'; ?>>Activo</option>
                            <option value="I" <?php if($estado == 'I') echo 'selected'; ?>>Inactivo</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">Guardar</button>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
include ("footer.php");
?>

