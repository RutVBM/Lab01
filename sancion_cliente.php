<?php
session_start(); // Aseguramos que la sesión esté iniciada
include("header.php");
include_once("conexion/database.php");
include("sidebar.php");

// Consulta para obtener la cantidad de sanciones por cliente
$sql_sanciones_cliente = "SELECT u.idusuario, u.nombre, u.apellidos, COUNT(r.id_reserva) AS total_sanciones
                          FROM reserva r
                          INNER JOIN usuario u ON r.id_usuario = u.idusuario
                          WHERE r.sancion = 'Sí'
                          GROUP BY u.idusuario";
$sanciones_cliente = dbQuery($sql_sanciones_cliente);
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Reporte de Sanciones por Cliente</h1>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Total de Sanciones</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($sancion = $sanciones_cliente->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($sancion['nombre'] . ' ' . $sancion['apellidos']) ?></td>
                                <td><?= htmlspecialchars($sancion['total_sanciones']) ?></td>
                                <td>
                                    <a href="sancion_cliente_detalle.php?id_usuario=<?= $sancion['idusuario'] ?>" class="btn btn-info btn-sm">Ver Detalles</a>
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
