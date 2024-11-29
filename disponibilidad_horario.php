<?php 
include("header.php");
include_once("conexion/database.php");
include("sidebar.php");

// Obtener la lista de días disponibles
$sql_dias = "SELECT id_dia, dia FROM dias_disponibles ORDER BY id_dia";
$dias_result = dbQuery($sql_dias);
$dias = [];
while ($row = $dias_result->fetch_assoc()) {
    $dias[] = $row;
}

// Obtener la lista de horas
$sql_horas = "SELECT * FROM horas ORDER BY hora_inicio";
$horas_result = dbQuery($sql_horas);
$horas = [];
while ($row = $horas_result->fetch_assoc()) {
    $horas[] = $row;
}

// Consultar la disponibilidad de horarios ocupados (ahora sin el comentario en la consulta SQL)
$sql_disponibilidad = "
    SELECT h.id_dia, h.id_hora
    FROM horario_treno h
    WHERE h.estado = 'Activo'
";
$disponibilidad_result = dbQuery($sql_disponibilidad);

// Crear un arreglo para almacenar la disponibilidad por días y horas
$disponibilidad = [];
while ($row = $disponibilidad_result->fetch_assoc()) {
    $disponibilidad[$row['id_dia']][$row['id_hora']] = true;  // Marcamos como activo
}

?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Programación de Horarios</h1>
    </section>

    <section class="content">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Horas</th>
                    <?php foreach ($dias as $dia): ?>
                        <th><?= htmlspecialchars($dia['dia']) ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($horas as $hora): ?>
                    <tr>
                        <td><?= htmlspecialchars($hora['hora_inicio']) . " - " . htmlspecialchars($hora['hora_fin']) ?></td>
                        <?php foreach ($dias as $dia): ?>
                            <td style="background-color: <?= isset($disponibilidad[$dia['id_dia']][$hora['id_hora']]) ? '#ffcccc' : '#ccffcc'; ?>;">
                                <?php if (isset($disponibilidad[$dia['id_dia']][$hora['id_hora']])): ?>
                                    <span>Ocupado</span>  <!-- Cambié 'Ocupado' por 'Activo' -->
                                <?php else: ?>
                                    Disponible
                                <?php endif; ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</div>

<?php include("footer.php"); ?>
