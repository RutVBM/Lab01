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

// Acción 1: Creación de una plantilla vacía de valores para un nuevo cliente
if ($sAccion == "new") {
    $sTitulo = "Registrar un nuevo cliente";
    $sSubTitulo = "Por favor, ingresar la información del cliente [(*) datos obligatorio]:";  // Subtítulo definido
    $sCambioAccion = "insert";
    // Valores por defecto
    $idcliente = "";
    $tipopersona = "";
    $nombre = "";
    $tipodocumento = "";
    $numdocumento = "";
    $direccion = "";
    $telefono = "";
    $correo = "";
    $estado = "A"; // Activo por defecto
}
// Acción 2: Editar datos existentes del cliente
elseif ($sAccion == "edit") {
    $sTitulo = "Modificar los datos del cliente";
    $sSubTitulo = "Por favor, actualizar la información del cliente [(*) datos obligatorio]:";  // Subtítulo definido
    $sCambioAccion = "update";
    if (isset($_GET["idcliente"])) $idcliente = $_GET["idcliente"];
    
    // Buscando los últimos datos registrados
    $sql = "SELECT * FROM cliente WHERE idcliente = $idcliente";
    $result = dbQuery($sql);
    if ($row = mysqli_fetch_array($result)) {
        $tipopersona = $row["tipopersona"];
        $nombre = $row["nombre"];
        $tipodocumento = $row["tipodocumento"];
        $numdocumento = $row["numdocumento"];
        $direccion = $row["direccion"];
        $telefono = $row["telefono"];
        $correo = $row["correo"];
        $estado = $row["estado"];
    }
}
// Acción 3: Insertar un nuevo cliente en la base de datos
elseif ($sAccion == "insert") {
    $tipopersona = $_POST["tipopersona"];
    $nombre = $_POST["nombre"];
    $tipodocumento = $_POST["tipodocumento"];
    $numdocumento = $_POST["numdocumento"];
    $direccion = $_POST["direccion"];
    $telefono = $_POST["telefono"];
    $correo = $_POST["correo"];
    $estado = $_POST["estado"];
    
    // SQL para insertar nuevo cliente
    $sql = "INSERT INTO cliente (tipopersona, nombre, tipodocumento, numdocumento, direccion, telefono, correo, estado) 
            VALUES ('$tipopersona', '$nombre', '$tipodocumento', '$numdocumento', '$direccion', '$telefono', '$correo', '$estado')";
    dbQuery($sql);
    
    // Redirigir después de insertar
    $mensaje = "1";
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $pagina = 'cliente.php?mensaje=' . $mensaje;
    header("Location: http://$host$uri/$pagina");
}
// Acción 4: Actualizar datos de un cliente existente
elseif ($sAccion == "update") {
    $idcliente = $_POST["idcliente"];
    $tipopersona = $_POST["tipopersona"];
    $nombre = $_POST["nombre"];
    $tipodocumento = $_POST["tipodocumento"];
    $numdocumento = $_POST["numdocumento"];
    $direccion = $_POST["direccion"];
    $telefono = $_POST["telefono"];
    $correo = $_POST["correo"];
    $estado = $_POST["estado"];
    
    // SQL para actualizar cliente
    $sql = "UPDATE cliente SET tipopersona = '$tipopersona', nombre = '$nombre', tipodocumento = '$tipodocumento', 
            numdocumento = '$numdocumento', direccion = '$direccion', telefono = '$telefono', correo = '$correo', 
            estado = '$estado' WHERE idcliente = $idcliente";
    dbQuery($sql);
    
    // Redirigir después de actualizar
    $mensaje = "2";
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $pagina = 'cliente.php?mensaje=' . $mensaje;
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
                <form name="frmDatos" action="cliente_detalle.php" method="post">
                    <input type="text" name="sAccion" value="<?php echo $sCambioAccion; ?>" hidden>
                    <input type="text" name="idcliente" value="<?php echo $idcliente; ?>" hidden>
                    
                    <div class="form-group">
                        <label for="tipopersona">Tipo de Persona:</label>
                        <input type="text" name="tipopersona" id="tipopersona" class="form-control" value="<?php echo $tipopersona; ?>" required />
                    </div>

                    <div class="form-group">
                        <label for="nombre">Nombre (*):</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo $nombre; ?>" required />
                    </div>

                    <div class="form-group">
                        <label for="tipodocumento">Tipo de Documento:</label>
                        <input type="text" name="tipodocumento" id="tipodocumento" class="form-control" value="<?php echo $tipodocumento; ?>" required />
                    </div>

                    <div class="form-group">
                        <label for="numdocumento">Número de Documento:</label>
                        <input type="text" name="numdocumento" id="numdocumento" class="form-control" value="<?php echo $numdocumento; ?>" required />
                    </div>

                    <div class="form-group">
                        <label for="direccion">Dirección:</label>
                        <input type="text" name="direccion" id="direccion" class="form-control" value="<?php echo $direccion; ?>" />
                    </div>

                    <div class="form-group">
                        <label for="telefono">Teléfono:</label>
                        <input type="text" name="telefono" id="telefono" class="form-control" value="<?php echo $telefono; ?>" />
                    </div>

                    <div class="form-group">
                        <label for="correo">Correo Electrónico:</label>
                        <input type="email" name="correo" id="correo" class="form-control" value="<?php echo $correo; ?>" required />
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
