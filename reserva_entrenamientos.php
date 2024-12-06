<?php
include("header.php");
include_once("conexion/database.php");
include("sidebar.php");

// Obtener todas las reservas junto con la información de la programación
$sql = "SELECT r.id_reserva, r.fecha_reserva, ht.id_programacion, cp.nombre_entrenador, d.dia, h.hora_inicio, h.hora_fin, lp.nombre_parque
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
                <a href="reserva_entrenamientos_detalle.php?sAccion=new" class="btn btn-primary mb-3">Nueva Reserva</a>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th># Reserva</th>
                            <th>Entrenador</th>
                            <th>Día</th>
                            <th>Hora</th>
                            <th>Local</th>
                            <th>Fecha de Reserva</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($reserva = $reservas->fetch_assoc()): ?>
                            <tr>
                                <td><?= $reserva['id_reserva'] ?></td>
                                <td><?= htmlspecialchars($reserva['nombre_entrenador']) ?></td>
                                <td><?= htmlspecialchars($reserva['dia']) ?></td>
                                <td><?= htmlspecialchars($reserva['hora_inicio']) ?> - <?= htmlspecialchars($reserva['hora_fin']) ?></td>
                                <td><?= htmlspecialchars($reserva['nombre_parque']) ?></td>
                                <td><?= htmlspecialchars($reserva['fecha_reserva']) ?></td>
                                <td>
                                    <a href="reserva_entrenamientos_detalle.php?sAccion=edit&id_reserva=<?= $reserva['id_reserva'] ?>" class="btn btn-info btn-sm">Editar</a>
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
