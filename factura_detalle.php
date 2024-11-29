<?php
session_start();
include("header.php");
include_once("conexion/database.php");
include("sidebar.php");

// Verificar si se ha pasado el ID del proveedor
if (!isset($_GET['id_proveedor']) || empty($_GET['id_proveedor'])) {
    die("Error: ID de proveedor no especificado.");
}

$id_proveedor = $_GET['id_proveedor'];

// Consultar los detalles del proveedor
$sql_proveedor = "SELECT nombre_proveedor, ruc, direccion, telefono FROM proveedor WHERE id_proveedor = ?";
$stmt_proveedor = dbQuery($sql_proveedor, [$id_proveedor]);

if (!$stmt_proveedor || $stmt_proveedor->num_rows === 0) {
    die("Error: No se encontró el proveedor.");
}

$proveedor = $stmt_proveedor->fetch_assoc();

// Consultar los detalles de las compras del proveedor
$sql_compras = "SELECT nombre_insumo, cantidad, precio_unitario, (cantidad * precio_unitario) AS total
                FROM compra_insumos
                WHERE id_proveedor = ?";
$stmt_compras = dbQuery($sql_compras, [$id_proveedor]);

$total_general = 0;
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Factura de Compras</h1>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-body">
                <div style="margin-bottom: 20px;">
                    <img src="logo.jpg" alt="Logo Empresa" width="150" style="display: block; margin: 0 auto;">
                    <h2 style="text-align: center; color: orange;">Factura de Compras</h2>
                </div>

                <!-- Detalles del Proveedor alineados a la izquierda -->
                <div style="margin-bottom: 20px;">
                    <h4>Datos del Proveedor</h4>
                    <p><strong>Nombre:</strong> <?= htmlspecialchars($proveedor['nombre_proveedor']) ?></p>
                    <p><strong>RUC:</strong> <?= htmlspecialchars($proveedor['ruc']) ?></p>
                    <p><strong>Dirección:</strong> <?= htmlspecialchars($proveedor['direccion']) ?></p>
                    <p><strong>Teléfono:</strong> <?= htmlspecialchars($proveedor['telefono']) ?></p>
                </div>

                <!-- Detalle de insumos comprados -->
                <h4>Detalle de Insumos Comprados</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Insumo</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($compra = $stmt_compras->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($compra['nombre_insumo']) ?></td>
                                <td><?= htmlspecialchars($compra['cantidad']) ?></td>
                                <td>S/ <?= number_format($compra['precio_unitario'], 2) ?></td>
                                <td>S/ <?= number_format($compra['total'], 2) ?></td>
                            </tr>
                            <?php $total_general += $compra['total']; ?>
                        <?php endwhile; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3">Total General</th>
                            <th>S/ <?= number_format($total_general, 2) ?></th>
                        </tr>
                    </tfoot>
                </table>

                <!-- Botón para imprimir la factura -->
                <div style="text-align: center; margin-top: 30px;">
                    <button class="btn btn-success" onclick="window.print();">Imprimir Factura</button>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include("footer.php"); ?>
