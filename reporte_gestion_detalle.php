<?php
include ("header.php");

$sAccion = "";
$sSubTitulo = "";  
$sTitulo = "";  

if (isset($_GET["sAccion"])) {
    $sAccion = $_GET["sAccion"]; 
} elseif (isset($_POST["sAccion"])) {
    $sAccion = $_POST["sAccion"]; 
}

// Acción 1: Creación de un nuevo reporte de gestión
if ($sAccion == "new") {
    $sTitulo = "Registrar un nuevo reporte de gestión";
    $sSubTitulo = "Por favor, ingresar la información del reporte [(*) datos obligatorios]:";
    $sCambioAccion = "insert";
    // Valores por defecto
    $id_reporte_gestion = "";
    $tipo_reporte = "";
    $cantidad_reclamos = "";
    $cantidad_sanciones = "";
    $tiempo_promedio_resolucion = "";
    $satisfaccion_cliente = "";
    $fecharegistro = date("Y-m-d"); 
}
// Acción 2: Editar datos existentes del reporte
elseif ($sAccion == "edit") {
    $sTitulo = "Modificar los datos del reporte de gestión";
    $sSubTitulo = "Por favor, actualizar la información del reporte [(*) datos obligatorios]:";
    $sCambioAccion = "update";
    if (isset($_GET["id_reporte_gestion"])) $id_reporte_gestion = $_GET["id_reporte_gestion"];
    
    // Buscando los últimos datos registrados
    $sql = "SELECT * FROM reporte_gestion WHERE id_reporte_gestion = $id_reporte_gestion";
    $result = dbQuery($sql);
    if ($row = mysqli_fetch_array($result)) {
        $tipo_reporte = $row["tipo_reporte"];
        $cantidad_reclamos = $row["cantidad_reclamos"];
        $cantidad_sanciones = $row["cantidad_sanciones"];
        $tiempo_promedio_resolucion = $row["tiempo_promedio_resolucion"];
        $satisfaccion_cliente = $row["satisfaccion_cliente"];
        $fecharegistro = $row["fecha_generacion"];
    }
}
// Acción 3: Insertar un nuevo reporte en la base de datos
elseif ($sAccion == "insert") {
    $tipo_reporte = $_POST["tipo_reporte"];
    $cantidad_reclamos = $_POST["cantidad_reclamos"];
    $cantidad_sanciones = $_POST["cantidad_sanciones"];
    $tiempo_promedio_resolucion = $_POST["tiempo_promedio_resolucion"];
    $satisfaccion_cliente = $_POST["satisfaccion_cliente"];
    $fecharegistro = date("Y-m-d"); 
    
    // SQL para insertar un nuevo reporte
    $sql = "INSERT INTO reporte_gestion (tipo_reporte, cantidad_reclamos, cantidad_sanciones, tiempo_promedio_resolucion, satisfaccion_cliente, fecha_generacion, idusuario, idreclamo, id_sancion) 
            VALUES ('$tipo_reporte', '$cantidad_reclamos', '$cantidad_sanciones', '$tiempo_promedio_resolucion', '$satisfaccion_cliente', '$fecharegistro', '$idusuario', '$idreclamo', '$idsancion')";
    dbQuery($sql);
    
    // Redirigir después de insertar
    $mensaje = "1";
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $pagina = 'reporte_gestion.php?mensaje=' . $mensaje;
    header("Location: http://$host$uri/$pagina");
}
// Acción 4: Actualizar datos de un reporte existente
elseif ($sAccion == "update") {
    $id_reporte_gestion = $_POST["id_reporte_gestion"];
    $tipo_reporte = $_POST["tipo_reporte"];
    $cantidad_reclamos = $_POST["cantidad_reclamos"];
    $cantidad_sanciones = $_POST["cantidad_sanciones"];
    $tiempo_promedio_resolucion = $_POST["tiempo_promedio_resolucion"];
    $satisfaccion_cliente = $_POST["satisfaccion_cliente"];
    
    // SQL para actualizar datos del reporte
    $sql = "UPDATE reporte_gestion SET tipo_reporte = '$tipo_reporte', cantidad_reclamos = '$cantidad_reclamos', cantidad_sanciones = '$cantidad_sanciones', 
            tiempo_promedio_resolucion = '$tiempo_promedio_resolucion', satisfaccion_cliente = '$satisfaccion_cliente', idusuario = '$idusuario', idreclamo = '$idreclamo', id_sancion = '$idsancion' 
            WHERE id_reporte_gestion = $id_reporte_gestion";
    dbQuery($sql);
    
    // Redirigir después de actualizar
    $mensaje = "2";
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $pagina = 'reporte_gestion.php?mensaje=' . $mensaje;
    header("Location: http://$host$uri/$pagina");
}
?>
