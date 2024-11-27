<?php
include("header.php");
include_once("conexion/database.php");

// Consulta: Cantidad de clientes por tipo de persona
$sqlClientes = "SELECT tipopersona, COUNT(*) AS total FROM cliente GROUP BY tipopersona";
$resultClientes = $connDB->query($sqlClientes);

$tiposPersona = [];
$cantidadClientes = [];
$totalClientes = 0; // Variable para la cantidad total de clientes
while ($row = $resultClientes->fetch_assoc()) {
    $tiposPersona[] = $row['tipopersona'] == 'N' ? 'Natural' : 'Jurídica'; // Asignar 'Natural' o 'Jurídica'
    $cantidadClientes[] = $row['total'];
    $totalClientes += $row['total']; // Contar el total de clientes
}

// Consulta: Cantidad de reclamos por estado
$sqlReclamos = "SELECT estado_reclamo, COUNT(*) AS total FROM reclamos GROUP BY estado_reclamo";
$resultReclamos = $connDB->query($sqlReclamos);

$estadosReclamos = [];
$cantidadReclamos = [];
$totalReclamos = 0; // Variable para la cantidad total de reclamos
while ($row = $resultReclamos->fetch_assoc()) {
    $estadosReclamos[] = $row['estado_reclamo'];
    $cantidadReclamos[] = $row['total'];
    $totalReclamos += $row['total']; // Contar el total de reclamos
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Clientes y Reclamos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .dashboard-header {
            background-color: #ff7f50; /* Naranja claro */
            color: white;
            padding: 20px;
            text-align: center;
        }
        .chart-container {
            margin: 20px auto;
            max-width: 800px;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .card-primary {
            background-color: #ffcc00; /* Naranja más oscuro */
        }
        .card-success {
            background-color: #ffa500; /* Naranja */
        }
        .card-info {
            background-color: #ff8c00; /* Naranja más oscuro */
        }
        /* Establecer altura fija para los gráficos */
        #clientesChart, #reclamosChart {
            height: 400px !important; /* Ajusta esta altura según lo que necesites */
        }
    </style>
</head>
<body>

<div class="dashboard-header">
    <h1>Dashboard de Clientes y Reclamos</h1>
    <p>Visualización de clientes y reclamos según estado</p>
</div>

<div class="container mt-4">
    <!-- Tarjetas con la cantidad de clientes y reclamos -->
    <div class="row">
        <div class="col-md-4">
            <div class="card card-primary">
                <div class="card-body">
                    <h5 class="text-center">Total de Clientes</h5>
                    <h3 class="text-center"><?= $totalClientes ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-primary">
                <div class="card-body">
                    <h5 class="text-center">Total de Reclamos</h5>
                    <h3 class="text-center"><?= $totalReclamos ?></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráfico de barras: Clientes por tipo de persona -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <h5 class="text-center">Clientes por Tipo de Persona</h5>
                <canvas id="clientesChart"></canvas>
            </div>
        </div>

        <!-- Gráfico de pastel: Estados de reclamos -->
        <div class="col-md-6">
            <div class="card">
                <h5 class="text-center">Estados de Reclamos</h5>
                <canvas id="reclamosChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
// Gráfico de barras: Clientes por tipo de persona
var ctxClientes = document.getElementById('clientesChart').getContext('2d');
var clientesChart = new Chart(ctxClientes, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($tiposPersona); ?>, // Tipos de persona (Natural, Jurídica)
        datasets: [{
            label: 'Cantidad de Clientes',
            data: <?php echo json_encode($cantidadClientes); ?>, // Cantidad de clientes
            backgroundColor: ['rgba(255, 165, 0, 0.7)', 'rgba(255, 140, 0, 0.7)'], // Naranja
            borderColor: ['rgba(255, 165, 0, 1)', 'rgba(255, 140, 0, 1)'], // Naranja
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            x: { title: { display: true, text: 'Tipo de Persona' } },
            y: { title: { display: true, text: 'Cantidad' }, beginAtZero: true }
        }
    }
});

// Gráfico de pastel: Estados de reclamos
var ctxReclamos = document.getElementById('reclamosChart').getContext('2d');
var reclamosChart = new Chart(ctxReclamos, {
    type: 'pie',
    data: {
        labels: <?php echo json_encode($estadosReclamos); ?>,
        datasets: [{
            data: <?php echo json_encode($cantidadReclamos); ?>,
            backgroundColor: [
                'rgba(255, 99, 132, 0.7)',
                'rgba(54, 162, 235, 0.7)',
                'rgba(255, 206, 86, 0.7)',
                'rgba(255, 159, 64, 0.7)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'top' } }
    }
});
</script>

</body>
</html>
