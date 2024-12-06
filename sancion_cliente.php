<?php
include("header.php");
include_once("conexion/database.php");
include("sidebar.php");

// Obtener las sanciones de los clientes
$sql = "SELECT s.id_sancion, s.id_reserva, s.hay_sancion, s.cant_sancion, s.fecha_sancion, r.id_usuario, r.fecha_reserva, r.tipo_reserva
        FROM sancion s
        INNER JOIN reserva r ON s.id_reserva = r.id_reserva";
$sanciones = dbQuery($sql);
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Lista de Sanciones de Clientes</h1>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-body">
                <a href="sancion_cliente_detalle.php?sAccion=new" class="btn btn-primary mb-3">Nueva Sanción</a>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th># Sanción</th>
                            <th>ID Reserva</th>
                            <th>Cliente</th>
                            <th>Fecha Reserva</th>
                            <th>Tipo de Reserva</th>
                            <th>Hay Sanción</th>
                            <th>Cant. Sanción</th>
                            <th>Fecha de Sanción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($sancion = $sanciones->fetch_assoc()): ?>
                            <tr>
                                <td><?= $sancion['id_sancion'] ?></td>
                                <td><?= $sancion['id_reserva'] ?></td>
                                <td><?= htmlspecialchars($sancion['id_usuario']) ?></td>
                                <td><?= htmlspecialchars($sancion['fecha_reserva']) ?></td>
                                <td><?= htmlspecialchars($sancion['tipo_reserva']) ?></td>
                                <td><?= $sancion['hay_sancion'] ? 'Sí' : 'No' ?></td>
                                <td><?= $sancion['cant_sancion'] ?></td>
                                <td><?= htmlspecialchars($sancion['fecha_sancion']) ?></td>
                                <td>
                                    <a href="sancion_cliente_detalle.php?sAccion=edit&id_sancion=<?= $sancion['id_sancion'] ?>" class="btn btn-info btn-sm">Editar</a>
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
