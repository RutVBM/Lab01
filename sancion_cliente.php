<?php
session_start();
include("header.php");
include_once("conexion/database.php");
include("sidebar.php");

// Obtener todas las reservas con la información de sanciones
$sql = "SELECT r.id_reserva, r.fecha_reserva, r.tipo_reserva, r.cantidad, r.sancion, r.cant_sancion,
               ht.id_programacion, cp.nombre_entrenador, d.dia, h.hora_inicio, h.hora_fin, lp.nombre_parque
        FROM reserva r
        INNER JOIN horario_treno ht ON r.id_programacion = ht.id_programacion
        INNER JOIN contrato_personal cp ON ht.id_contrato = cp.id_contrato
        INNER JOIN dias_disponibles d ON ht.id_dia = d.id_dia
        INNER JOIN horas h ON ht.id_hora = h.id_hora
        INNER JOIN locales lp ON ht.id_local = lp.id_local";

$reservas = dbQuery($sql);

// Calcular las sanciones totales (sólo si la sanción es 'Sí')
$sql_sanciones_totales = "SELECT SUM(cant_sancion) AS total_sanciones FROM reserva WHERE sancion = 'Sí'";
$sanciones_totales = dbQuery($sql_sanciones_totales);

// Usar fetch_assoc() para obtener el resultado como un array asociativo
$total_sanciones_row = $sanciones_totales->fetch_assoc();
$total_sanciones = $total_sanciones_row['total_sanciones'] ?? 0;

?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Dashboard de Sanciones</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <!-- Muestra la cantidad total de sanciones -->
                <div class="card">
                    <div class="card-body">
                        <h4>Total de Sanciones: <?= $total_sanciones ?></h4>
                    </div>
                </div>
            </div>

            <!-- Mostrar la tabla de reservas con sanciones -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th># Reserva</th>
                                    <th>Entrenador</th>
                                    <th>Día</th>
                                    <th>Hora</th>
                                    <th>Local</th>
                                    <th>Fecha de Reserva</th>
                                    <th>Tipo de Reserva</th>
                                    <th>Cantidad</th>
                                    <th>Sanción</th>
                                    <th>Cant. Sanción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($reserva = $reservas->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($reserva['id_reserva']) ?></td>
                                        <td><?= htmlspecialchars($reserva['nombre_entrenador']) ?></td>
                                        <td><?= htmlspecialchars($reserva['dia']) ?></td>
                                        <td><?= htmlspecialchars($reserva['hora_inicio']) ?> - <?= htmlspecialchars($reserva['hora_fin']) ?></td>
                                        <td><?= htmlspecialchars($reserva['nombre_parque']) ?></td>
                                        <td><?= htmlspecialchars($reserva['fecha_reserva']) ?></td>
                                        <td><?= htmlspecialchars($reserva['tipo_reserva']) ?></td>
                                        <td><?= htmlspecialchars($reserva['cantidad']) ?></td>
                                        <td><?= htmlspecialchars($reserva['sancion']) ?></td>
                                        <td><?= htmlspecialchars($reserva['cant_sancion']) ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include("footer.php"); ?>
