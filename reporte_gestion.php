<?php 
include("header.php");
include("sidebar.php");

// Filtrar por tipo de reporte si es necesario
$tipo_reporte = isset($_POST["tipo_reporte"]) ? $_POST["tipo_reporte"] : "";

// Consulta SQL para obtener los datos necesarios para el gráfico
$sqlCaptacion = "SELECT COUNT(idcaptacion) AS total, DATE(fecha_captacion) AS fecha FROM captacion_clientes GROUP BY DATE(fecha_captacion) ORDER BY fecha";
$resultCaptacion = dbQuery($sqlCaptacion);

$fechas = [];
$captaciones = [];
while ($row = mysqli_fetch_assoc($resultCaptacion)) {
    $fechas[] = $row['fecha'];
    $captaciones[] = $row['total'];
}

// Consulta para los reclamos resueltos
$sqlReclamos = "SELECT COUNT(idreclamo) AS total, DATE(fecha_reclamo) AS fecha FROM atencion_reclamos WHERE estado = 'Resuelto' GROUP BY DATE(fecha_reclamo) ORDER BY fecha";
$resultReclamos = dbQuery($sqlReclamos);

$reclamosResueltos = [];
while ($row = mysqli_fetch_assoc($resultReclamos)) {
    $reclamosResueltos[] = $row['total'];
}
?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Lista de Reportes de Gestión</h1>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Gráficos de Gestión</h3>
      </div>
      <div class="card-body">
        <canvas id="captacionChart" width="400" height="200"></canvas>
        <canvas id="reclamosChart" width="400" height="200" style="margin-top: 50px;"></canvas>
      </div>
    </div>
  </section>
</div>

<?php include("footer.php"); ?>

<!-- Incluir Chart.js desde CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Datos de captación de clientes
var ctxCaptacion = document.getElementById('captacionChart').getContext('2d');
var captacionChart = new Chart(ctxCaptacion, {
    type: 'line', // Tipo de gráfico
    data: {
        labels: <?php echo json_encode($fechas); ?>, // Fechas obtenidas de la base de datos
        datasets: [{
            label: 'Clientes Captados',
            data: <?php echo json_encode($captaciones); ?>, // Totales de captación
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            x: { title: { display: true, text: 'Fecha' }},
            y: { title: { display: true, text: 'Cantidad' }}
        }
    }
});

// Datos de reclamos resueltos
var ctxReclamos = document.getElementById('reclamosChart').getContext('2d');
var reclamosChart = new Chart(ctxReclamos, {
    type: 'bar', // Tipo de gráfico
    data: {
        labels: <?php echo json_encode($fechas); ?>, // Fechas obtenidas de la base de datos
        datasets: [{
            label: 'Reclamos Resueltos',
            data: <?php echo json_encode($reclamosResueltos); ?>, // Totales de reclamos resueltos
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            x: { title: { display: true, text: 'Fecha' }},
            y: { title: { display: true, text: 'Cantidad' }}
        }
    }
});
</script>

