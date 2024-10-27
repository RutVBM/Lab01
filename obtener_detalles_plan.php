<?php
include_once("conexion/database.php");

if (isset($_GET['idplan'])) {
    $idplan = $_GET['idplan'];
    $sql = "SELECT duracion, precio FROM planes_entrenamiento WHERE idplan = ?";
    $stmt = dbQuery($sql, [$idplan]);
    $row = $stmt->fetch_assoc();

    // Devolver la duración y precio en formato JSON
    echo json_encode([
        'duracion' => $row['duracion'],
        'precio' => $row['precio']
    ]);
} else {
    echo json_encode(['error' => 'No se proporcionó idplan']);
}
?>
