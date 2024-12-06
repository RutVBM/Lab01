<?php
session_start();
include("header.php");
include_once("conexion/database.php");
include("sidebar.php");

// Obtener todas las reservas con la información de programación
$sql = "SELECT r.id_reserva, r.fecha_reserva, r.tipo_reserva, r.cantidad, r.sancion, r.cant_sancion,
               ht.id_programacion, cp.nombre_entrenador, d.dia, h.hora_inicio, h.hora_fin, lp.nombre_parque
        FROM reserva r
        INNER JOIN horario_treno ht ON r.id_programacion = ht.id_programacion
        INNER JOIN contrato_personal cp ON ht.id_contrato = cp.id_contrato
        INNER JOIN dias_disponibles d ON ht.id_dia = d.id_dia
        INNER JOIN horas h ON ht.id_hora = h.id_hora
        INNER JOIN locales lp ON ht.id_local = lp.id_local";
$reservas = dbQuery($sql);
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Lista de Reservas</h1>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-body">
                <!-- Eliminado el botón "Nueva Reserva" -->
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
                            <th>Acciones</th>
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
                                <td><?= date("d-m-Y H:i", strtotime($reserva['fecha_reserva'])) ?></td> <!-- Formato de fecha -->
                                <td><?= htmlspecialchars($reserva['tipo_reserva']) ?></td>
                                <td><?= htmlspecialchars($reserva['cantidad']) ?></td>
                                <td><?= htmlspecialchars($reserva['sancion']) ?></td>
                                <td><?= htmlspecialchars($reserva['cant_sancion']) ?></td>
                                <td>
                                    <a href="gestion_sanciones_detalle.php?sAccion=edit&id_reserva=<?= $reserva['id_reserva'] ?>" class="btn btn-info btn-sm">Editar</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<?php include("footer.php"); ?>
