<?php
session_start(); // Iniciar sesión para acceder a las variables de sesión
include("header.php");

$sAccion = $_GET["sAccion"] ?? $_POST["sAccion"] ?? "";
$sTitulo = $sAccion == "new" ? "Crear una Reserva" : "Modificar los datos de la reserva";
$sSubTitulo = $sAccion == "new" ? "Por favor, ingresar la información de la reserva:" : "Por favor, actualizar la información de la reserva:";

// Acción 1: Creación de una plantilla vacía de valores para una nueva reserva
if ($sAccion == "new") {
    $sCambioAccion = "insert";
    $idreserva = "";
    $idcliente = $_SESSION["CORREO"]; // Usar el correo del usuario logueado como ID del cliente
    $nombre_cliente = $_SESSION["USUARIO"]; // Nombre completo del usuario logueado
    $tipo_entrenamiento = "";
    $lugar_entrenamiento = "";
    $fecha_reserva = "";
    $num_participantes = "";
}
// Acción 2: Editar datos existentes de una reserva
elseif ($sAccion == "edit") {
    $sCambioAccion = "update";

    // Obtener el ID de la reserva desde GET
    if (isset($_GET["idreserva"])) {
        $idreserva = $_GET["idreserva"];
        
        // Buscar los últimos datos registrados
        $sql = "SELECT * FROM reserva_entrenamientos WHERE idreserva = $idreserva";
        $result = dbQuery($sql);
        if ($row = mysqli_fetch_array($result)) {
            $idcliente = $row["idcliente"];
            $nombre_cliente = $row["nombre_cliente"];
            $tipo_entrenamiento = $row["tipo_entrenamiento"];
            $lugar_entrenamiento = $row["lugar_entrenamiento"];
            $fecha_reserva = $row["fecha_reserva"];
            $num_participantes = $row["num_participantes"];
        }
    }
}

// Acción 3: Insertar una nueva reserva en la base de datos
elseif ($sAccion == "insert") {
    $idcliente = $_POST["idcliente"];
    $nombre_cliente = $_POST["nombre_cliente"];
    $tipo_entrenamiento = $_POST["tipo_entrenamiento"];
    $lugar_entrenamiento = $_POST["lugar_entrenamiento"];
    $fecha_reserva = $_POST["fecha_reserva"];
    $num_participantes = $_POST["num_participantes"];
    
    // SQL para insertar una nueva reserva
    $sql = "INSERT INTO reserva_entrenamientos (idcliente, nombre_cliente, tipo_entrenamiento, lugar_entrenamiento, fecha_reserva, num_participantes) 
            VALUES ('$idcliente', '$nombre_cliente', '$tipo_entrenamiento', '$lugar_entrenamiento', '$fecha_reserva', '$num_participantes')";
    dbQuery($sql);
    
    // Redirigir después de insertar
    $mensaje = "1";
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $pagina = 'reserva_entrenamientos.php?mensaje=' . $mensaje;
    header("Location: http://$host$uri/$pagina");
    exit();
}

// Acción 4: Actualizar datos de una reserva existente
elseif ($sAccion == "update") {
    $idreserva = $_POST["idreserva"];
    $idcliente = $_POST["idcliente"];
    $nombre_cliente = $_POST["nombre_cliente"];
    $tipo_entrenamiento = $_POST["tipo_entrenamiento"];
    $lugar_entrenamiento = $_POST["lugar_entrenamiento"];
    $fecha_reserva = $_POST["fecha_reserva"];
    $num_participantes = $_POST["num_participantes"];
    
    // SQL para actualizar reserva
    $sql = "UPDATE reserva_entrenamientos SET idcliente = '$idcliente', nombre_cliente = '$nombre_cliente', tipo_entrenamiento = '$tipo_entrenamiento', lugar_entrenamiento = '$lugar_entrenamiento', fecha_reserva = '$fecha_reserva', 
            num_participantes = '$num_participantes' WHERE idreserva = $idreserva";
    dbQuery($sql);
    
    // Redirigir después de actualizar
    $mensaje = "2";
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $pagina = 'reserva_entrenamientos.php?mensaje=' . $mensaje;
    header("Location: http://$host$uri/$pagina");
    exit();
}

include("sidebar.php");
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?php echo $sTitulo; ?></h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?php echo $sSubTitulo; ?></h3>
            </div>
            <div class="card-body">
                <form name="frmDatos" action="reserva_entrenamientos_detalle.php" method="post">
                    <input type="hidden" name="sAccion" value="<?php echo $sCambioAccion; ?>">
                    <input type="hidden" name="idreserva" value="<?php echo $idreserva; ?>">
                    <input type="hidden" name="idcliente" value="<?php echo $idcliente; ?>">

                    <!-- Campo Nombre del Cliente (No editable) -->
                    <div class="form-group">
                        <label for="nombre_cliente">Nombre del Cliente:</label>
                        <input type="text" name="nombre_cliente" id="nombre_cliente" class="form-control" value="<?php echo $nombre_cliente; ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="tipo_entrenamiento">Tipo de Entrenamiento:</label>
                        <select name="tipo_entrenamiento" id="tipo_entrenamiento" class="form-control" required onchange="toggleNumParticipantes()">
                            <option value="Grupal" <?php if($tipo_entrenamiento == 'Grupal') echo 'selected'; ?>>Grupal</option>
                            <option value="Individual" <?php if($tipo_entrenamiento == 'Individual') echo 'selected'; ?>>Individual</option>
                        </select>
                    </div>

                    <!-- Campo Número de Participantes -->
                    <div class="form-group" id="num_participantes_group">
                        <label for="num_participantes">Número de Participantes:</label>
                        <input type="number" name="num_participantes" id="num_participantes" class="form-control" value="<?php echo $num_participantes; ?>" min="1">
                    </div>

                    <div class="form-group">
                        <label for="lugar_entrenamiento">Lugar:</label>
                        <select name="lugar_entrenamiento" id="lugar_entrenamiento" class="form-control" required>
                            <option value="Aire Libre" <?php if($lugar_entrenamiento == 'Aire Libre') echo 'selected'; ?>>Aire Libre</option>
                            <option value="Instalaciones" <?php if($lugar_entrenamiento == 'Instalaciones') echo 'selected'; ?>>Instalaciones</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="fecha_reserva">Fecha:</label>
                        <input type="date" name="fecha_reserva" id="fecha_reserva" class="form-control" value="<?php echo $fecha_reserva; ?>" required>
                    </div>

                    <div class="form-group-buttons text-center">
                        <button type="submit" class="btn btn-orange" style="background-color: orange;">Reservar</button>
                        <a href="reserva_entrenamientos.php" class="btn btn-cancel" style="color: black; border: 1px solid black;">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<!-- Script para mostrar/ocultar número de participantes y asignar 1 para Individual -->
<script>
    function toggleNumParticipantes() {
        var tipoEntrenamiento = document.getElementById('tipo_entrenamiento').value;
        var numParticipantes = document.getElementById('num_participantes');
        
        if (tipoEntrenamiento === 'Individual') {
            numParticipantes.value = 1; // Asigna automáticamente 1 si es Individual
            numParticipantes.readOnly = true; // Desactiva la edición del campo
        } else {
            numParticipantes.readOnly = false; // Permite la edición para Grupal
            numParticipantes.value = ""; // Limpia el valor si se selecciona Grupal
        }
    }

    // Ejecutar la función al cargar la página para verificar el valor actual
    toggleNumParticipantes();
</script>

<?php include("footer.php"); ?>
