<?php
include("header.php");

$sAccion = "";
$sSubTitulo = "";  
$sTitulo = "";  

if (isset($_GET["sAccion"])) {
    $sAccion = $_GET["sAccion"]; // new / edit / sancionar
} elseif (isset($_POST["sAccion"])) {
    $sAccion = $_POST["sAccion"]; // insert / update / aplicar sanción
}

// Acción 1: Creación de un nuevo registro de sanción para un cliente
if ($sAccion == "new") {
    $sTitulo = "Registrar una nueva sanción";
    $sSubTitulo = "Por favor, ingresar la información de la sanción [(*) datos obligatorios]:";
    $sCambioAccion = "insert";
    // Valores por defecto
    $idcliente = ""; // ID del cliente debe ser ingresado
    $faltas = 0;
    $estado = "A"; // Activo por defecto
    $fecha_sancion = date("Y-m-d"); // Fecha actual por defecto
}
// Acción 2: Editar los datos de una sanción existente
elseif ($sAccion == "edit") {
    $sTitulo = "Modificar los datos de la sanción";
    $sSubTitulo = "Por favor, actualizar la información de la sanción [(*) datos obligatorios]:";
    $sCambioAccion = "update";
    if (isset($_GET["id_sancion"])) $id_sancion = $_GET["id_sancion"];
    
    // Buscando los datos registrados
    $sql = "SELECT * FROM gestion_sanciones WHERE id_sancion = $id_sancion";
    $result = dbQuery($sql);
    if ($row = mysqli_fetch_array($result)) {
        $faltas = $row["faltas"];
        $estado = $row["estado"];
        $fecha_sancion = $row["fecha_sancion"];
        $idcliente = $row["idcliente"];
    }
}
// Acción 3: Insertar una nueva sanción en la base de datos
elseif ($sAccion == "insert") {
    $idcliente = $_POST["idcliente"];
    $faltas = $_POST["faltas"];
    $estado = $_POST["estado"];
    $fecha_sancion = date("Y-m-d");
    
    // SQL para insertar una nueva sanción
    $sql = "INSERT INTO gestion_sanciones (idcliente, faltas, estado, fecha_sancion) 
            VALUES ('$idcliente', '$faltas', '$estado', '$fecha_sancion')";
    dbQuery($sql);
    
    // Redirigir después de insertar
    $mensaje = "1";
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $pagina = 'gestion_sancion.php?mensaje=' . $mensaje;
    header("Location: http://$host$uri/$pagina");
    exit();
}
// Acción 4: Actualizar datos de una sanción existente
elseif ($sAccion == "update") {
    $id_sancion = $_POST["id_sancion"];
    $faltas = $_POST["faltas"];
    $estado = $_POST["estado"];
    
    // SQL para actualizar el registro de la sanción
    $sql = "UPDATE gestion_sanciones SET faltas = '$faltas', estado = '$estado' WHERE id_sancion = $id_sancion";
    dbQuery($sql);
    
    // Redirigir después de actualizar
    $mensaje = "2";
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $pagina = 'gestion_sancion.php?mensaje=' . $mensaje;
    header("Location: http://$host$uri/$pagina");
    exit();
}
// Acción 5: Aplicar sanción a un cliente que ha alcanzado el límite de faltas
elseif ($sAccion == "sancionar") {
    if (isset($_GET["id_sancion"])) $id_sancion = $_GET["id_sancion"];
    
    // Bloquear al cliente y aplicar la sanción
    $sql = "UPDATE gestion_sanciones SET estado = 'B', fecha_sancion = NOW() WHERE id_sancion = $id_sancion";
    dbQuery($sql);

    // Enviar notificación por correo al cliente
    $sql_cliente = "SELECT email FROM cliente WHERE idcliente = (SELECT idcliente FROM gestion_sanciones WHERE id_sancion = $id_sancion)";
    $result_cliente = dbQuery($sql_cliente);
    if ($row_cliente = mysqli_fetch_array($result_cliente)) {
        $email = $row_cliente['email'];
        $asunto = "Notificación de Sanción";
        $mensaje = "Estimado cliente, ha alcanzado el límite de faltas permitidas y se le ha aplicado una sanción temporal. No podrá realizar reservas hasta que su estado sea revisado.";
        mail($email, $asunto, $mensaje);
    }

    // Redirigir después de aplicar la sanción
    $mensaje = "3";
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $pagina = 'gestion_sancion.php?mensaje=' . $mensaje;
    header("Location: http://$host$uri/$pagina");
    exit();
}
?>

<?php
include("sidebar.php");
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

            <!-- Formulario de sanción -->
            <div class="card-body">
                <form name="frmDatos" action="gestion_sancion_detalle.php" method="post">
                    <input type="hidden" name="sAccion" value="<?php echo $sCambioAccion; ?>">
                    <input type="hidden" name="id_sancion" value="<?php echo isset($id_sancion) ? $id_sancion : ''; ?>">

                    <div class="form-group">
                        <label for="idcliente">ID del Cliente (*):</label>
                        <input type="text" name="idcliente" id="idcliente" class="form-control" value="<?php echo isset($idcliente) ? $idcliente : ''; ?>" required />
                    </div>

                    <div class="form-group">
                        <label for="faltas">Número de Faltas (*):</label>
                        <input type="number" name="faltas" id="faltas" class="form-control" value="<?php echo isset($faltas) ? $faltas : 0; ?>" required />
                    </div>

                    <div class="form-group">
                        <label for="estado">Estado:</label>
                        <select name="estado" id="estado" class="form-control">
                            <option value="A" <?php if($estado == 'A') echo 'selected'; ?>>Activo</option>
                            <option value="B" <?php if($estado == 'B') echo 'selected'; ?>>Bloqueado</option>
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
include("footer.php");
?>
