<?php
// Configuración de la conexión a la base de datos
$DBHost = "localhost";
$DBname = "fitness center";  // Asegúrate de que el nombre de la base de datos no tenga espacios.
$DBUser = "root";
$DBPass = "";

// Crear la conexión
$connDB = new mysqli($DBHost, $DBUser, $DBPass, $DBname);

// Verificar si la conexión fue exitosa
if ($connDB->connect_error) {
    die("Error de conexión: " . $connDB->connect_error);
}

// Función para ejecutar consultas SQL preparadas
function dbQuery($query, $params = []) {
    global $connDB;

    // Preparar la consulta
    $stmt = $connDB->prepare($query);
    if (!$stmt) {
        die("Error al preparar la consulta: " . $connDB->error);
    }

    // Enlazar los parámetros si se pasan
    if ($params) {
        // Crear una cadena con los tipos de los parámetros (por defecto, todos 's' para string)
        $types = str_repeat('s', count($params));
        $stmt->bind_param($types, ...$params);
    }

    // Ejecutar la consulta
    if (!$stmt->execute()) {
        die("Error en la ejecución de la consulta: " . $stmt->error);
    }

    // Obtener el resultado si la consulta es de tipo SELECT
    $result = $stmt->get_result();

    // Cerrar la sentencia
    $stmt->close();

    // Retornar el resultado para consultas SELECT, o true para INSERT/UPDATE/DELETE
    return $result ? $result : true;
}

// FUNCIONES ADICIONALES
if (!function_exists('quitar_acentos')) {
    function quitar_acentos($cadena) {
        $search = explode(",", "á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ");
        $replace = explode(",", "a,e,i,o,u,n,A,E,I,O,U,N");
        $cadena = str_replace($search, $replace, $cadena);
        return $cadena;
    }
}

if (!function_exists('extraer_valor')) {
    function extraer_valor($sql) {
        $resFuncion = dbQuery($sql);
        if ($rowFuncion = mysqli_fetch_array($resFuncion)) {
            return $rowFuncion["valor"];
        } else {
            return "";
        }
    }
}

if (!function_exists('numero_documento')) {
    function numero_documento($tipo) {
        $numero = 1;
        $sql = "SELECT (max(numero_documento) + 1) AS numero FROM venta WHERE tipo_documento = '$tipo'";
        $resFuncion = dbQuery($sql);
        if ($rowFuncion = mysqli_fetch_array($resFuncion)) {
            if ($rowFuncion["numero"]) {
                $numero = $rowFuncion["numero"];
            }
        }
        return $numero;
    }
}

?>
