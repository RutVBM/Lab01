<?php
include_once("conexion/database.php");

$idplan = $_GET['idplan'] ?? null;

if ($idplan) {
    $sql = "SELECT duracion, precio FROM planes_entrenamiento WHERE idplan = ?";
    $stmt = dbQuery($sql, [$idplan]);
    $plan = $stmt->fetch_assoc();

    echo json_encode($plan);
} else {
    echo json_encode(["duracion" => "", "precio" => ""]);
}
?>
