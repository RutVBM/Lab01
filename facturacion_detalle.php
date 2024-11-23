<?php
session_start();
include("header.php");
include_once("conexion/database.php");

// Verificar si se ha pasado el ID del pago
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Error: ID de pago no especificado.");
}

// Obtener el ID del pago
$id_pago = $_GET['id'];

// Consultar los detalles del pago
$sql = "SELECT tipo_plan, nombre_plan, duracion, precio, metodo_pago, fecha_pago 
        FROM pago_clientes WHERE id_pago = ?";
$result = dbQuery($sql, [$id_pago]);

// Verificar si se encontró el pago
if (!$result || $result->num_rows == 0) {
    die("Error: No se encontró el pago con el ID proporcionado.");
}

$pago = $result->fetch_assoc();

include("sidebar.php");
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Factura de Pago</h1>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center; margin-bottom: 20px;">
                    <img src="../Lab01/logo.jpg" alt="Logo Fitness Center" width="100">
                    <h3>Factura de Pago</h3>
                    <p>Número de Ticket: <strong><?= $id_pago ?></strong></p>
                </div>

                <table class="table table-bordered">
                    <tr>
                        <th>Fecha de Pago:</th>
                        <td><?= $pago['fecha_pago'] ?></td>
                    </tr>
                    <tr>
                        <th>Tipo de Plan:</th>
                        <td><?= $pago['tipo_plan'] ?></td>
                    </tr>
                    <tr>
                        <th>Nombre del Plan:</th>
                        <td><?= $pago['nombre_plan'] ?></td>
                    </tr>
                    <tr>
                        <th>Duración:</th>
                        <td><?= $pago['duracion'] ?> meses</td>
                    </tr>
                    <tr>
                        <th>Precio:</th>
                        <td>S/ <?= $pago['precio'] ?></td>
                    </tr>
                    <tr>
                        <th>Método de Pago:</th>
                        <td><?= $pago['metodo_pago'] ?></td>
                    </tr>
                </table>

                <h4 style="text-align: right; margin-top: 20px;">Total Pagado: <strong>S/ <?= $pago['precio'] ?></strong></h4>

                <div style="text-align: center; margin-top: 30px;">
                    <button class="btn btn-success" onclick="window.print();">Imprimir Factura</button>
                </div>
  
