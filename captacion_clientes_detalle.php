<?php
include ("header.php");

$sAccion = "";
$sSubTitulo = "";  
$sTitulo = "";  

if (isset($_GET["sAccion"])) {
    $sAccion = $_GET["sAccion"]; // new / edit
} elseif (isset($_POST["sAccion"])) {
    $sAccion = $_POST["sAccion"]; // insert / update
}

// Acción 1: Creación de un nuevo registro de captación de cliente
if ($sAccion == "new") {
    $sTitulo = "Registrar una nueva captación de cliente";
    $sSubTitulo = "Por favor, ingresar la información del cliente captado [(*) datos obligatorios]:";
    $sCambioAccion = "insert";
    // Valores por defecto
    $idcliente = ""; // ID del cliente debe ser ingresado
    $tipo_cliente = "";
    $nombre_cliente = "";
    $contacto = "";
    $estado = "A"; // Activo por defecto
    $fecha_captacion = date("Y-m-d"); // Fecha actual por defecto
}
// Acción 2: Editar datos existentes de captación de cliente
elseif ($sAccion == "edit") {
    $sTitulo = "Modificar los datos de captación de cliente";
    $sSubTitulo = "Por favor, actualizar la información del cliente captado [(*) datos obligatorios]:";
    $sCambioAccion = "update";
    if (isset($_GET["idcliente"])) $idcliente = $_GET["idcliente"];
    
    // Buscando los últimos datos registrados
    $sql = "SELECT * FROM captacion_clientes WHERE idcliente = $idcliente";
    $result = dbQuery($sql);
    if ($row = mysqli_fetch_array($result)) {
        $tipo_cliente = $row["tipo_cliente"];
        $nombre_cliente = $row["nombre_cliente"];
        $contacto = $row["contacto"];
        $estado = $row["estado"];
        $fecha_captacion = $row["fecha_captacion"];
    }
}
// Acción 3: Insertar una nueva captación en la base de datos
elseif ($sAccion == "insert") {
    $idcliente = $_POST["idcliente"]; // ID del cliente ya existente
    $tipo_cliente = $_POST["tipo_cliente"];
    $nombre_cliente = $_POST["nombre_cliente"];
    $contacto = $_POST["contacto"];
    $estado = $_POST["estado"];
    $fecha_captacion = date("Y-m-d"); // Fecha actual
    
    // SQL para insertar una nueva captación
    $sql = "INSERT INTO captacion_clientes (idcliente, tipo_cliente, nombre_cliente, contacto, estado, fecha_captacion) 
            VALUES ('$idcliente', '$tipo_cliente', '$nombre_cliente', '$contacto', '$estado', '$fecha_captacion')";
    dbQuery($sql);
    
    // Redirigir después de insertar
    $mensaje = "1";
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $pagina = 'captacion_clientes.php?mensaje=' . $mensaje;
    header("Location: http://$host$uri/$pagina");
    exit();
}
// Acción 4: Actualizar datos de una captación existente
elseif ($sAccion == "update") {
    $idcliente = $_POST["idcliente"];
    $tipo_cliente = $_POST["tipo_cliente"];
    $nombre_cliente = $_POST["nombre_cliente"];
    $contacto = $_POST["contacto"];
    $estado = $_POST["estado"];
    
    // SQL para actualizar un registro existente
    $sql = "UPDATE captacion_clientes SET tipo_cliente = '$tipo_cliente', nombre_cliente = '$nombre_cliente', 
            contacto = '$contacto', estado = '$estado' WHERE idcliente = $idcliente";
    dbQuery($sql);
    
    // Redirigir después de actualizar
    $mensaje = "2";
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $pagina = 'captacion_clientes.php?mensaje=' . $mensaje;
    header("Location: http://$host$uri/$pagina");
    exit();
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

            <!-- Formulario de captación -->
            <div class="card-body">
                <form name="frmDatos" action="captacion_clientes_detalle.php" method="post">
                    <input type="text" name="sAccion" value="<?php echo $sCambioAccion; ?>" hidden>
                    <input type="text" name="idcliente" value="<?php echo $idcliente; ?>" hidden>

                    <div class="form-group">
                        <label for="tipo_cliente">Tipo de Cliente (*):</label>
                        <select name="tipo_cliente" id="tipo_cliente" class="form-control" required>
                            <option value="individual" <?php if($tipo_cliente == 'individual') echo 'selected'; ?>>Individual</option>
                            <option value="corporativo" <?php if($tipo_cliente == 'corporativo') echo 'selected'; ?>>Corporativo</option>
                            <option value="vip" <?php if($tipo_cliente == 'vip') echo 'selected'; ?>>VIP</option>
                            <option value="familiar" <?php if($tipo_cliente == 'familiar') echo 'selected'; ?>>Familiar</option>
                            <option value="estudiantil" <?php if($tipo_cliente == 'estudiantil') echo 'selected'; ?>>Estudiantil</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="nombre_cliente">Nombre del Cliente (*):</label>
                        <input type="text" name="nombre_cliente" id="nombre_cliente" class="form-control" value="<?php echo $nombre_cliente; ?>" required />
                    </div>

                    <div class="form-group">
                        <label for="contacto">Contacto (*):</label>
                        <input type="text" name="contacto" id="contacto" class="form-control" value="<?php echo $contacto; ?>" required />
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
