<?php
include_once("conexion/database.php");

// Verificar si se enviaron los datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_local = $_POST['id_local'];   // Local seleccionado
    $id_dia = $_POST['id_dia'];       // Día seleccionado
    $id_hora = $_POST['id_hora'];     // Hora seleccionada
    $estado = 'Ocupado';              // Estado del horario

    // Verificar si el horario ya está reservado
    $sql_check = "SELECT * FROM horario_treno WHERE id_local = ? AND id_dia = ? AND id_hora = ?";
    $stmt_check = dbQuery($sql_check, [$id_local, $id_dia, $id_hora]);
    
    if ($stmt_check->num_rows > 0) {
        echo "Este horario ya está ocupado. Por favor seleccione otro.";
    } else {
        // Insertar el horario en la base de datos
        $sql_insert = "INSERT INTO horario_treno (id_local, id_dia, id_hora, estado) VALUES (?, ?, ?, ?)";
        $stmt_insert = dbQuery($sql_insert, [$id_local, $id_dia, $id_hora, $estado]);

        if ($stmt_insert) {
            echo "Horario registrado exitosamente.";
        } else {
            echo "Error al registrar el horario.";
        }
    }
}
?>
