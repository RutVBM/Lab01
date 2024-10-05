<?php

function dbQuery($sql) {
  // Reemplaza las variables con la información requerida para conectarse a la base de datos
  $DBHost = "localhost";
  // Cambia el nombre de la base de datos eliminando el espacio o asegúrate de que el nombre no tenga espacios.
  $DBname = "fitness center";  // Asegúrate de que el nombre sea correcto y sin espacios.
  $DBUser = "root";
  $DBPass = "";

  // Establecer la conexión a la base de datos
  $connDB = mysqli_connect($DBHost, $DBUser, $DBPass, $DBname);

  // Verificar si la conexión ha sido exitosa
  if (mysqli_connect_errno()) { 
    echo "Error: No se pudo conectar a MySQL. " . mysqli_connect_error();
    exit;
  }

  // Ejecutar la consulta SQL
  $result = mysqli_query($connDB, $sql);

  // Verificar si la consulta fue exitosa
  if (!$result) { 
    echo "Error: No se pudo ejecutar la sentencia SQL: " . $sql . "<br>" . mysqli_error($connDB);
    exit;
  }

  // Cerrar la conexión
  mysqli_close($connDB);

  // Devolver el resultado de la consulta
  return $result;
}

// FUNCIONES ADICIONALES
function quitar_acentos($cadena) {
  // Arregla caracteres extraños
  $search = explode(",", "á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ");
  $replace = explode(",", "a,e,i,o,u,n,A,E,I,O,U,N");
  $cadena = str_replace($search, $replace, $cadena);
  return $cadena;
}

function extraer_valor($sql) {
  // Retorna el valor de la sentencia SQL
  $resFuncion = dbQuery($sql);
  if ($rowFuncion = mysqli_fetch_array($resFuncion)) {
    return $rowFuncion["valor"];
  } else {
    return "";
  }
}

function numero_documento($tipo) {
  // Nos brinda el número siguiente de la Factura/Boleta
  $numero = 1; // Valor por defecto
  $sql = "SELECT (max(numero_documento) + 1) AS numero FROM venta WHERE tipo_documento = '$tipo'";
  // Ejecutar la consulta SQL
  $resFuncion = dbQuery($sql);
  if ($rowFuncion = mysqli_fetch_array($resFuncion)) {
    if ($rowFuncion["numero"]) {
      $numero = $rowFuncion["numero"];
    }
  }
  return $numero;
}

?>
