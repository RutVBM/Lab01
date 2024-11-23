<?php
// Conexión a la base de datos y configuración
include("conexion/database.php");

// Obtener el ID del pago desde la URL
$idPago = $_GET['id'] ?? null;

// Verificar que el ID del pago esté presente
if (!$idPago) {
    die("Error: ID de pago no especificado.");
}

// Obtener los detalles del pago desde la base de datos junto con el nombre y apellidos del usuario
$sql = "SELECT pc.tipo_plan, pc.nombre_plan, pc.duracion, pc.precio, pc.metodo_pago, pc.fecha_pago, 
               u.nombre, u.apellidos
        FROM pago_clientes pc 
        LEFT JOIN usuario u ON pc.idusuario = u.idusuario 
        WHERE pc.id_pago = ?";
$result = dbQuery($sql, [$idPago]);

// Verificar si se obtuvo el resultado
if ($result->num_rows == 0) {
    die("Error: No se encontró el pago especificado.");
}

$pago = $result->fetch_assoc();
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
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }

        .factura-container {
            max-width: 700px;
            margin: 0 auto;
            background: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .factura-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .factura-header img {
            width: 120px;
            margin-bottom: 10px;
        }

        .factura-header h1 {
            margin: 0;
            font-size: 24px;
            color: #ff7300;
        }

        .factura-header h2 {
            margin: 5px 0;
            font-size: 18px;
            color: #333;
        }

        .factura-header p {
            margin: 0;
            font-size: 14px;
            color: #666;
        }

        .factura-detalle {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .factura-detalle th, .factura-detalle td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .factura-detalle th {
            background-color: #ff7300;
            color: #ffffff;
        }

        .factura-total {
            text-align: right;
            margin-top: 20px;
            font-size: 16px;
            color: #333;
        }

        .btn-imprimir {
            display: block;
            width: 100%;
            margin-top: 20px;
            padding: 10px;
            text-align: center;
            font-size: 16px;
            background-color: #ff7300;
            color: #ffffff;
            text-decoration: none;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-imprimir:hover {
            background-color: #e56300;
        }
    </style>
</head>
<body>
    <div class="factura-container">
        <div class="factura-header">
            <img src="logo.jpg" alt="Logo de Fitness Center">
            <h1>Fitness Center</h1>
            <h2>Factura de Pago</h2>
            <p>Número de Ticket: <?= htmlspecialchars($idPago) ?></p>
            <p>Fecha de Pago: <?= htmlspecialchars($pago['fecha_pago']) ?></p>
            <p>Cliente: <?= htmlspecialchars($pago['nombre'] . ' ' . $pago['apellidos']) ?></p>
        </div>

        <table class="factura-detalle">
            <tr>
                <th>Detalle</th>
                <th>Información</th>
            </tr>
            <tr>
                <td>Tipo de Plan</td>
                <td><?= htmlspecialchars($pago['tipo_plan']) ?></td>
            </tr>
            <tr>
                <td>Nombre del Plan</td>
                <td><?= htmlspecialchars($pago['nombre_plan']) ?></td>
            </tr>
            <tr>
                <td>Duración</td>
                <td><?= htmlspecialchars($pago['duracion']) ?> meses</td>
            </tr>
            <tr>
                <td>Precio</td>
                <td>S/ <?= htmlspecialchars($pago['precio']) ?></td>
            </tr>
            <tr>
                <td>Método de Pago</td>
                <td><?= htmlspecialchars($pago['metodo_pago']) ?></td>
            </tr>
        </table>

        <div class="factura-total">
            <strong>Total Pagado: S/ <?= htmlspecialchars($pago['precio']) ?></strong>
        </div>

        <button class="btn-imprimir" onclick="window.print()">Imprimir Factura</button>
    </div>
</body>
</html>
