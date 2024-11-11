<?php
include("header.php");
include_once("conexion/database.php");

$sAccion = $_GET["sAccion"] ?? $_POST["sAccion"] ?? "";

// Configurar título y valores por defecto para la creación de un nuevo registro
if ($sAccion == "new") {
    $sTitulo = "Registrar un nuevo contrato de personal";
    $sSubTitulo = "Por favor, ingresar la información del contrato de personal [(*) datos obligatorios]:";
    $sCambioAccion = "insert";
    $idContratos_personal = "";
    $nombre_personal = "";
    $DNI_personal = "";
    $telefono = "";
    $email = "";
    $Finicio_contrato_per = "";
    $Ffin_contrato_per = "";
} elseif ($sAccion == "edit" && isset($_GET["idContratos_personal"])) {
    $sTitulo = "Modificar datos del contrato de personal";
    $sSubTitulo = "Por favor, actualizar la información del contrato de personal [(*) datos obligatorios]:";
    $sCambioAccion = "update";
    $idContratos_personal = $_GET["idContratos_personal"];
    
    // Cargar los datos del contrato para editar
    $sql = "SELECT * FROM contrato_personal WHERE idContratos_personal = ?";
    $stmt = dbQuery($sql, [$idContratos_personal]);
    if ($row = $stmt->fetch_assoc()) {
        $nombre_personal = $row["nombre_personal"];
        $DNI_personal = $row["DNI_personal"];
        $telefono = $row["telefono"];
        $email = $row["email"];
        $Finicio_contrato_per = $row["Finicio_contrato_per"];
        $Ffin_contrato_per = $row["Ffin_contrato_per"];
    }
} elseif ($sAccion == "insert") {
    // Insertar un nuevo registro
    $nombre_personal = $_POST["nombre_personal"];
    $DNI_personal = $_POST["DNI_personal"];
    $telefono = $_POST["telefono"];
    $email = $_POST["email"];
    $Finicio_contrato_per = $_POST["Finicio_contrato_per"];
    $Ffin_contrato_per = $_POST["Ffin_contrato_per"];
    
    $sql = "INSERT INTO contrato_personal (nombre_personal, DNI_personal, telefono, email, Finicio_contrato_per, Ffin_contrato_per)
            VALUES (?, ?, ?, ?, ?, ?)";
    dbQuery($sql, [$nombre_personal, $DNI_personal, $telefono, $email, $Finicio_contrato_per, $Ffin_contrato_per]);
    header("Location: contrato_personal.php?mensaje=1");
    exit();
} elseif ($sAccion == "update") {
    // Actualizar el registro existente
    $idContratos_personal = $_POST["idContratos_personal"];
    $nombre_personal = $_POST["nombre_personal"];
    $DNI_personal = $_POST["DNI_personal"];
    $telefono = $_POST["telefono"];
    $email = $_POST["email"];
    $Finicio_contrato_per = $_POST["Finicio_contrato_per"];
    $Ffin_contrato_per = $_POST["Ffin_contrato_per"];
    
    $sql = "UPDATE contrato_personal 
            SET nombre_personal = ?, DNI_personal = ?, telefono = ?, email = ?, Finicio_contrato_per = ?, Ffin_contrato_per = ?
            WHERE idContratos_personal = ?";
    dbQuery($sql, [$nombre_personal, $DNI_personal, $telefono, $email, $Finicio_contrato_per, $Ffin_contrato_per, $idContratos_personal]);
    header("Location: contrato_personal.php?mensaje=2");
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
                <form action="contrato_personal_detalle.php" method="post">
                    <input type="hidden" name="sAccion" value="<?php echo $sCambioAccion; ?>">
                    <input type="hidden" name="idContratos_personal" value="<?php echo $idContratos_personal; ?>">

                    <div class="form-group">
                        <label for="nombre_personal">Nombre del Personal (*):</label>
                        <input type="text" name="nombre_personal" class="form-control" value="<?php echo $nombre_personal; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="DNI_personal">DNI (*):</label>
                        <input type="text" name="DNI_personal" class="form-control" value="<?php echo $DNI_personal; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="telefono">Teléfono (*):</label>
                        <input type="text" name="telefono" class="form-control" value="<?php echo $telefono; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email (*):</label>
                        <input type="email" name="email" class="form-control" value="<?php echo $email; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="Finicio_contrato_per">Fecha de Inicio (*):</label>
                        <input type="date" name="Finicio_contrato_per" class="form-control" value="<?php echo $Finicio_contrato_per; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="Ffin_contrato_per">Fecha de Fin (*):</label>
                        <input type="date" name="Ffin_contrato_per" class="form-control" value="<?php echo $Ffin_contrato_per; ?>" required>
                    </div>

                    <a href="contrato_personal.php" class="btn btn-primary" style="background-color: orange;">Regresar</a>
                    <button type="submit" class="btn btn-success" style="background-color: orange;">Guardar</button>
                </form>
            </div>
        </div>
    </section>
</div>

<?php
include("footer.php");
?>
