<?php
include("header.php");
include_once("conexion/database.php");
include("sidebar.php");

// Obtener datos de ingresos
$sql_ingresos = "SELECT SUM(precio) AS total_ingresos FROM pago_clientes";
$result_ingresos = $connDB->query($sql_ingresos);
$ingresos_totales = $result_ingresos->fetch_assoc()['total_ingresos'] ?? 0;

// Obtener datos de egresos (contratos de personal y compras de insumos)
$sql_egresos_contratos = "SELECT SUM(salario) AS total_contratos FROM contrato_personal";
$result_egresos_contratos = $connDB->query($sql_egresos_contratos);
$egresos_contratos = $result_egresos_contratos->fetch_assoc()['total_contratos'] ?? 0;

$sql_egresos_compras = "SELECT SUM(cantidad * precio_unitario) AS total_compras FROM compra_insumos";
$result_egresos_compras = $connDB->query($sql_egresos_compras);
$egresos_compras = $result_egresos_compras->fetch_assoc()['total_compras'] ?? 0;

$egresos_totales = $egresos_contratos + $egresos_compras;

// Calcular el balance
$balance_financiero = $ingresos_totales - $egresos_totales;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Financiero</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- jsPDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .stat-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px;
            border-radius: 8px;
            color: #fff;
        }
        .bg-ingresos {
            background-color: rgba(50, 205, 50, 0.8); /* Verde loro */
        }
        .bg-egresos {
            background-color: rgba(255, 0, 0, 0.8); /* Rojo */
        }
        .bg-balance {
            background-color: rgba(255, 165, 0, 0.8); /* Naranja */
        }
        .chart-container {
            margin-top: 30px;
        }
        .chart {
            width: 100%;
            height: 400px;
        }
        .table-container {
            margin-top: 50px;
        }

        /* Eliminar líneas y bordes no deseados */
        .main-sidebar {
            border: none !important;
            box-shadow: none !important;
        }
        .brand-link {
            border-bottom: none !important;
        }
        .user-panel {
            border-bottom: none !important;
            margin-bottom: 0 !important;
            padding-bottom: 0 !important;
        }
    </style>
</head>
<body>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1 class="text-center mb-4">Dashboard Financiero</h1>
        </div>
    </section>

    <section class="content">
        <div class="container mt-4">
            <!-- Resumen Financiero -->
            <div class="row">
                <div class="col-md-4">
                    <div class="stat-card bg-ingresos">
                        <div>
                            <h4>Ingresos Totales</h4>
                            <h2>S/ <span id="ingresosTotales"><?= number_format($ingresos_totales, 2) ?></span></h2>
                        </div>
                        <i class="fas fa-wallet fa-3x"></i>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card bg-egresos">
                        <div>
                            <h4>Egresos Totales</h4>
                            <h2>S/ <span id="egresosTotales"><?= number_format($egresos_totales, 2) ?></span></h2>
                        </div>
                        <i class="fas fa-money-bill-wave fa-3x"></i>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card bg-balance">
                        <div>
                            <h4>Balance</h4>
                            <h2>S/ <span id="balanceFinanciero"><?= number_format($balance_financiero, 2) ?></span></h2>
                        </div>
                        <i class="fas fa-chart-line fa-3x"></i>
                    </div>
                </div>
            </div>

            <!-- Gráficos -->
            <div class="chart-container row mt-4">
                <div class="col-md-6">
                    <canvas id="barChart" class="chart"></canvas>
                </div>
                <div class="col-md-6">
                    <canvas id="pieChart" class="chart"></canvas>
                </div>
            </div>

            <!-- Descarga de Reporte -->
            <div class="text-center mt-5">
                <button class="btn btn-primary" id="descargarReporte">Descargar Reporte PDF</button>
            </div>
        </div>
    </section>
</div>

<?php include("footer.php"); ?>

<script>
    const ingresosTotales = <?= $ingresos_totales ?>;
    const egresosTotales = <?= $egresos_totales ?>;
    const balanceFinanciero = <?= $balance_financiero ?>;

    // Gráfico de barras
    const barChartCtx = document.getElementById("barChart").getContext("2d");
    new Chart(barChartCtx, {
        type: "bar",
        data: {
            labels: ["Ingresos", "Egresos"],
            datasets: [
                {
                    label: "Totales (S/) ",
                    data: [ingresosTotales, egresosTotales],
                    backgroundColor: ["rgba(50, 205, 50, 0.5)", "rgba(255, 0, 0, 0.5)"],
                    borderColor: ["#32CD32", "#FF0000"],
                    borderWidth: 1,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
        },
    });

    // Gráfico de pastel
    const pieChartCtx = document.getElementById("pieChart").getContext("2d");
    new Chart(pieChartCtx, {
        type: "pie",
        data: {
            labels: ["Ingresos", "Egresos"],
            datasets: [
                {
                    data: [ingresosTotales, egresosTotales],
                    backgroundColor: ["rgba(50, 205, 50, 0.5)", "rgba(255, 0, 0, 0.5)"],
                    borderColor: ["#32CD32", "#FF0000"],
                    borderWidth: 1,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
        },
    });

    // Descargar Reporte PDF
    document.getElementById("descargarReporte").addEventListener("click", () => {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        doc.setFontSize(18);
        doc.text("Reporte Financiero", 10, 10);
        doc.setFontSize(12);
        doc.text(`Ingresos Totales: S/ ${ingresosTotales.toFixed(2)}`, 10, 30);
        doc.text(`Egresos Totales: S/ ${egresosTotales.toFixed(2)}`, 10, 40);
        doc.text(`Balance Financiero: S/ ${balanceFinanciero.toFixed(2)}`, 10, 50);

        doc.autoTable({
            startY: 60,
            head: [["Tipo", "Detalle", "Monto (S/)"]],
            body: [
                ["Ingreso", "Ingresos Totales", ingresosTotales.toFixed(2)],
                ["Egreso", "Egresos Totales", egresosTotales.toFixed(2)],
            ],
        });

        doc.save("Reporte_Financiero.pdf");
    });
</script>
</body>
</html>
