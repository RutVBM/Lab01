<?php
include("header.php");
include_once("conexion/database.php");
include("sidebar.php");

// Obtener todos los proveedores que tienen compras registradas
$sql_proveedores = "SELECT DISTINCT p.id_proveedor, p.nombre_proveedor, p.ruc, p.direccion, p.telefono 
                    FROM proveedor p
                    INNER JOIN compra_insumos c ON p.id_proveedor = c.id_proveedor";
$stmt_proveedores = dbQuery($sql_proveedores);

if ($stmt_proveedores->num_rows === 0) {
    die("No se encontraron proveedores con compras.");
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Pago de Proveedores</h1>
    </section>

    <section class="content">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Proveedor</th>
                    <th>RUC</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($proveedor = $stmt_proveedores->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($proveedor['nombre_proveedor']) ?></td>
                        <td><?= htmlspecialchars($proveedor['ruc']) ?></td>
                        <td><?= htmlspecialchars($proveedor['direccion']) ?></td>
                        <td><?= htmlspecialchars($proveedor['telefono']) ?></td>
                        <td>
                            <button class="btn btn-primary" onclick="GenerateInvoice(<?= $proveedor['id_proveedor'] ?>);">Emitir Comproabante</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </section>
</div>

<script type="text/javascript">
    // Redireccionar para generar una factura por proveedor
    function GenerateInvoice(id_proveedor) {
        window.location.href = "factura_detalle.php?id_proveedor=" + id_proveedor;
    }
</script>

<?php include("footer.php"); ?>
