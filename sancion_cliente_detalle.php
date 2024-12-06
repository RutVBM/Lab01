<?php
session_start(); // Aseguramos que la sesión esté iniciada
include("header.php");
include_once("conexion/database.php");
include("sidebar.php");

$id_usuario = $_GET["id_usuario"] ?? "";

if (empty($id_usuario)) {
    echo '<script>alert("ID de usuario no proporcionado."); window.location.href = "sancion_cliente.php";</script>';
    exit();
}

// Obtener los detalles de las sanciones de un cliente específico
$sql_detalle_sanciones = "SELECT r.id_reserva, r.fecha_reserva, r.tipo_reserva, r.cantidad, r.sancion, r.cant_sancion
                          FROM reserva r
                          WHERE r.id_usuario = ? AND r.sancion = 'Sí'";
$stmt_detalle_sanciones = dbQuery($sql_detalle_sanciones, [$id_usuario]);
$usuario = dbQuery("SELECT nombre, apellidos FROM usuario WHERE idusuario = ?", [$id_usuario])->fetch_assoc();

if (!$usuario) {
    echo '<script>alert("Cliente no encontrado."); window.location.href = "sancion_cliente.php";</script>';
    exit();
}

?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Detalles de Sanciones de <?= htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellidos']) ?></h1>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th># Reserva</th>
                            <th>Fecha de Reserva</th>
                            <th>Tipo de Reserva</th>
                            <th>Cantidad</th>
                            <th>Sanción</th>
                            <th>Cant. Sanción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($detalle = $stmt_detalle_sanciones->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($detalle['id_reserva']) ?></td>
                                <td><?= htmlspecialchars($detalle['fecha_reserva']) ?></td>
                                <td><?= htmlspecialchars($detalle['tipo_reserva']) ?></td>
                                <td><?= htmlspecialchars($detalle['cantidad']) ?></td>
                                <td><?= htmlspecialchars($detalle['sancion']) ?></td>
                                <td><?= htmlspecialchars($detalle['cant_sancion']) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<?php include("footer.php"); ?>
