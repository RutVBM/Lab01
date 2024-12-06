<?php
include("header.php");
include_once("conexion/database.php");
include("sidebar.php");

// Obtener todas las reservas con información de programación
$sql = "SELECT r.id_reserva, r.fecha_reserva, r.tipo_reserva, r.cantidad, ht.id_programacion, cp.nombre_entrenador, d.dia, h.hora_inicio, h.hora_fin, lp.nombre_parque
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
        <h1>Reservas de Entrenamiento</h1>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-body">
                <table id="listado" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Entrenador</th>
                            <th>Día</th>
                            <th>Hora</th>
                            <th>Local</th>
                            <th>Tipo de Reserva</th>
                            <th>Cantidad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($reservas)): ?>
                            <tr>
                                <td><?= htmlspecialchars($row["nombre_entrenador"]) ?></td>
                                <td><?= htmlspecialchars($row["dia"]) ?></td>
                                <td><?= htmlspecialchars($row["hora_inicio"]) ?> - <?= htmlspecialchars($row["hora_fin"]) ?></td>
                                <td><?= htmlspecialchars($row["nombre_parque"]) ?></td>
                                <td><?= htmlspecialchars($row["tipo_reserva"]) ?></td>
                                <td><?= $row["tipo_reserva"] == "Grupal" ? $row["cantidad"] : "1" ?></td>
                                <td>
                                    <a href="reserva_entrenamientos_detalle.php?sAccion=edit&id_reserva=<?= $row['id_reserva'] ?>" class="btn btn-info btn-sm">Editar</a>
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
