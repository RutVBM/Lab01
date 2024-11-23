<?php
include_once("conexion/database.php");

$idPago = $_GET["idpago"] ?? null;

// Verificar que se pase un ID de pago
if (!$idPago) {
    die("Error: No se especificó el ID del pago.");
}

// Obtener los detalles del pago
$sql = "SELECT * FROM pago_clientes WHERE id_pago = ?";
$result = dbQuery($sql, [$idPago]);

if ($row = mysqli_fetch_assoc($result)) {
    $tipo_plan = ucfirst($row['tipo_plan']);
    $nombre_plan = $row['nombre_plan'];
    $duracion = $row['duracion'];
    $precio = $row['precio'];
    $metodo_pago = $row['metodo_pago'];
    $fecha_pago = $row['fecha_pago'];
} else {
    die("Error: No se encontró el pago con ID $idPago.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura de Pago</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .factura-container {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #ccc;
            padding: 20px;
        }
        h1, h2, h3 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .btn-imprimir {
            margin-top: 20px;
            display: block;
            width: 100%;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="factura-container">
        <h1>Fitness Center</h1>
        <h2>Factura de Pago</h2>
        <h3>Número de Ticket: <?= $idPago ?></h3>

        <p><strong>Fecha de Pago:</strong> <?= $fecha_pago ?></p>
        <table>
            <tr>
                <th>Detalle</th>
                <th>Información</th>
            </tr>
            <tr>
                <td>Tipo de Plan</td>
                <td><?= $tipo_plan ?></td>
            </tr>
            <tr>
                <td>Nombre del Plan</td>
                <td><?= $nombre_plan ?></td>
            </tr>
            <tr>
                <td>Duración</td>
                <td><?= $duracion ?> meses</td>
            </tr>
            <tr>
                <td>Precio</td>
                <td>S/ <?= $precio ?></td>
            </tr>
            <tr>
                <td>Método de Pago</td>
                <td><?= $metodo_pago ?></td>
            </tr>
        </table>

        <p><strong>Total Pagado:</strong> S/ <?= $precio ?></p>

        <button class="btn-imprimir" onclick="window.print()">Imprimir Factura</button>
    </div>
</body>
</html>
