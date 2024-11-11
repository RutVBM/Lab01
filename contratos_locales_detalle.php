<?php
include("header.php");
include_once("conexion/database.php");

$sAccion = $_GET["sAccion"] ?? $_POST["sAccion"] ?? "";

// Configurar título y valores por defecto para la creación de un nuevo registro
if ($sAccion == "new") {
    $sTitulo = "Registrar un nuevo contrato de local";
    $sSubTitulo = "Por favor, ingresar la información del contrato de local [(*) datos obligatorios]:";
    $sCambioAccion = "insert";
    $idContratos_locales = "";
    $nombre_local = "";
    $direccion = "";
    $telefono_contacto = "";
    $Finicio_contrato_local = "";
    $Ffin_contrato_local = "";
} elseif ($sAccion == "edit" && isset($_GET["idContratos_locales"])) {
    $sTitulo = "Modificar datos del contrato de local";
    $sSubTitulo = "Por favor, actualizar la información del contrato de local [(*) datos obligatorios]:";
    $sCambioAccion = "update";
    $idContratos_locales = $_GET["idContratos_locales"];
    
    // Cargar los datos del contrato para editar
    $sql = "SELECT * FROM contratos_locales WHERE idContratos_locales = ?";
    $stmt = dbQuery($sql, [$idContratos_locales]);
    if ($row = $stmt->fetch_assoc()) {
        $nombre_local = $row["nombre_local"];
        $direccion = $row["direccion"];
        $telefono_contacto = $row["telefono_contacto"];
        $Finicio_contrato_local = $row["Finicio_contrato_local"];
        $Ffin_contrato_local = $row["Ffin_contrato_local"];
    }
} elseif ($sAccion == "insert") {
    // Insertar un nuevo registro
    $nombre_local = $_POST["nombre_local"];
    $direccion = $_POST["direccion"];
    $telefono_contacto = $_POST["telefono_contacto"];
    $Finicio_contrato_local = $_POST["Finicio_contrato_local"];
    $Ffin_contrato_local = $_POST["Ffin_contrato_local"];
    
    $sql = "INSERT INTO contrato_locales (nombre_local, direccion, telefono_contacto, Finicio_contrato_local, Ffin_contrato_local)
            VALUES (?, ?, ?, ?, ?)";
    dbQuery($sql, [$nombre_local, $direccion, $telefono_contacto, $Finicio_contrato_local, $Ffin_contrato_local]);
    header("Location: contratos_locales.php?mensaje=1");
    exit();
} elseif ($sAccion == "update") {
    // Actualizar el registro existente
    $idContratos_locales = $_POST["idContratos_locales"];
    $nombre_local = $_POST["nombre_local"];
    $direccion = $_POST["direccion"];
    $telefono_contacto = $_POST["telefono_contacto"];
    $Finicio_contrato_local = $_POST["Finicio_contrato_local"];
    $Ffin_contrato_local = $_POST["Ffin_contrato_local"];
    
    $sql = "UPDATE contrato_locales 
            SET nombre_local = ?, direccion = ?, telefono_contacto = ?, Finicio_contrato_local = ?, Ffin_contrato_local = ?
            WHERE idContratos_locales = ?";
    dbQuery($sql, [$nombre_local, $direccion, $telefono_contacto, $Finicio_contrato_local, $Ffin_contrato_local, $idContratos_locales]);
    header("Location: contratos_locales.php?mensaje=2");
    exit();
}

include("sidebar.php");
?>

<!-- Content Wrapper. Contains page content -->
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
                <form action="contratos_locales_detalle.php" method="post">
                    <input type="hidden" name="sAccion" value="<?php echo $sCambioAccion; ?>">
                    <input type="hidden" name="idContratos_locales" value="<?php echo $idContratos_locales; ?>">

                    <div class="form-group">
                        <label for="nombre_local">Nombre del Local (*):</label>
                        <input type="text" name="nombre_local" class="form-control" value="<?php echo $nombre_local; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="direccion">Dirección (*):</label>
                        <input type="text" name="direccion" class="form-control" value="<?php echo $direccion; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="telefono_contacto">Teléfono de Contacto (*):</label>
                        <input type="text" name="telefono_contacto" class="form-control" value="<?php echo $telefono_contacto; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="Finicio_contrato_local">Fecha de Inicio (*):</label>
                        <input type="date" name="Finicio_contrato_local" class="form-control" value="<?php echo $Finicio_contrato_local; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="Ffin_contrato_local">Fecha de Fin (*):</label>
                        <input type="date" name="Ffin_contrato_local" class="form-control" value="<?php echo $Ffin_contrato_local; ?>" required>
                    </div>

                    <a href="contratos_locales.php" class="btn btn-primary" style="background-color: orange;">Regresar</a>
                    <button type="submit" class="btn btn-success" style="background-color: orange;">Guardar</button>
                </form>
            </div>
        </div>
    </section>
</div>

<?php
include("footer.php");
?>
