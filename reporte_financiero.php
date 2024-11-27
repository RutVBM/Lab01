<?php
include("header.php");
include_once("conexion/database.php");

// Obtener ingresos detallados
$sql_ingresos_detalle = "SELECT id_pago, tipo_plan, nombre_plan, precio, metodo_pago, fecha_pago FROM pago_clientes";
$result_ingresos_detalle = $connDB->query($sql_ingresos_detalle);
$ingresos_detalle = $result_ingresos_detalle->fetch_all(MYSQLI_ASSOC);

$sql_ingresos_totales = "SELECT SUM(precio) AS total_ingresos FROM pago_clientes";
$result_ingresos_totales = $connDB->query($sql_ingresos_totales);
$ingresos_totales = $result_ingresos_totales->fetch_assoc()['total_ingresos'] ?? 0;

// Obtener egresos detallados (contratos de personal)
$sql_egresos_contratos = "SELECT id_contrato, nombre_entrenador, salario, tipo_entrenamiento, especialidad FROM contrato_personal";
$result_egresos_contratos = $connDB->query($sql_egresos_contratos);
$egresos_contratos_detalle = $result_egresos_contratos->fetch_all(MYSQLI_ASSOC);

$sql_egresos_contratos_totales = "SELECT SUM(salario) AS total_contratos FROM contrato_personal";
$result_egresos_contratos_totales = $connDB->query($sql_egresos_contratos_totales);
$egresos_contratos = $result_egresos_contratos_totales->fetch_assoc()['total_contratos'] ?? 0;

// Obtener egresos detallados (compras de insumos)
$sql_egresos_compras = "SELECT id_compra, nombre_insumo, cantidad, precio_unitario, fecha_pedido FROM compra_insumos";
$result_egresos_compras = $connDB->query($sql_egresos_compras);
$egresos_compras_detalle = $result_egresos_compras->fetch_all(MYSQLI_ASSOC);

$sql_egresos_compras_totales = "SELECT SUM(cantidad * precio_unitario) AS total_compras FROM compra_insumos";
$result_egresos_compras_totales = $connDB->query($sql_egresos_compras_totales);
$egresos_compras = $result_egresos_compras_totales->fetch_assoc()['total_compras'] ?? 0;

// Calcular egresos totales y balance
$egresos_totales = $egresos_contratos + $egresos_compras;
$balance_financiero = $ingresos_totales - $egresos_totales;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Financiero</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow-y: auto;
        }

        .container {
            margin-top: 20px;
            max-width: 100%; /* Permite que el contenido ocupe todo el ancho */
            padding: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="text-center">Dashboard Financiero</h1>
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card text-bg-success">
                <div class="card-body">
                    <h5>Ingresos Totales</h5>
                    <h3>S/ <?= number_format($ingresos_totales, 2) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-bg-danger">
                <div class="card-body">
                    <h5>Egresos Totales</h5>
                    <h3>S/ <?= number_format($egresos_totales, 2) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-bg-warning">
                <div class="card-body">
                    <h5>Balance</h5>
                    <h3>S/ <?= number_format($balance_financiero, 2) ?></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Detalle de ingresos -->
    <h2 class="mt-5">Detalle de Ingresos</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Ticket</th>
                <th>Tipo de Plan</th>
                <th>Nombre del Plan</th>
                <th>Precio (S/)</th>
                <th>Método de Pago</th>
                <th>Fecha de Pago</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ingresos_detalle as $ingreso): ?>
            <tr>
                <td><?= $ingreso['id_pago'] ?></td>
                <td><?= $ingreso['tipo_plan'] ?></td>
                <td><?= $ingreso['nombre_plan'] ?></td>
                <td><?= number_format($ingreso['precio'], 2) ?></td>
                <td><?= $ingreso['metodo_pago'] ?></td>
                <td><?= $ingreso['fecha_pago'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Detalle de egresos (contratos) -->
    <h2 class="mt-5">Detalle de Egresos - Contratos de Personal</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Ticket</th>
                <th>Nombre del Entrenador</th>
                <th>Salario (S/)</th>
                <th>Tipo de Entrenamiento</th>
                <th>Especialidad</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($egresos_contratos_detalle as $contrato): ?>
            <tr>
                <td><?= $contrato['id_contrato'] ?></td>
                <td><?= $contrato['nombre_entrenador'] ?></td>
                <td><?= number_format($contrato['salario'], 2) ?></td>
                <td><?= $contrato['tipo_entrenamiento'] ?></td>
                <td><?= $contrato['especialidad'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Detalle de egresos (compras) -->
    <h2 class="mt-5">Detalle de Egresos - Compras de Insumos</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Ticket</th>
                <th>Nombre del Insumo</th>
                <th>Cantidad</th>
                <th>Precio Unitario (S/)</th>
                <th>Fecha del Pedido</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($egresos_compras_detalle as $compra): ?>
            <tr>
                <td><?= $compra['id_compra'] ?></td>
                <td><?= $compra['nombre_insumo'] ?></td>
                <td><?= $compra['cantidad'] ?></td>
                <td><?= number_format($compra['precio_unitario'], 2) ?></td>
                <td><?= $compra['fecha_pedido'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
