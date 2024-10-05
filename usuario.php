<?php
include ("header.php");
?>

<?php
include ("sidebar.php");
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Lista de usuarios</h1>
          </div><!--
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div>-->
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <!--
        <div class="card-header">
          <h3 class="card-title"></h3>
        </div>
        -->
        <!-- /.card-header -->
        <?php
        $sql = "SELECT `idusuario`, `nombre`, `apellidos`, `fechnac`, `correo`, `clave`, `estado`, `fechregistro` FROM `usuario` ";
        $sql.= "Order by apellidos, nombre, fechnac";
        $result=dbQuery($sql);
        $total_registros = mysqli_num_rows($result);
        ?>
        <div class="card-body">
          <table id="listado" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>Nombre</th>
              <th>Apellido</th>
              <th>Fecha de nacimiento</th>
              <th>Correo</th>
              <th>Clave</th>
              <th>Estado</th>
              <th>Registro</th>
            </tr>
            </thead>
            <tbody>
            <?php 
              if($total_registros > 0)
              { //Existen datos
                while ($row = mysqli_fetch_array($result)) {
                  $estado = "Inativo";
                  if($row["estado"] == "A"){
                    $estado = "Activo";
                  }
                  ?>
                  <tr>
                    <td><?php echo $row["nombre"];?></td>
                    <td><?php echo $row["apellidos"];?></td>
                    <td><?php echo $row["fechnac"];?></td>
                    <td><?php echo $row["correo"];?></td>
                    <td><?php echo $row["clave"];?></td>
                    <td><?php echo $estado;?></td>
                    <td><?php echo $row["fechregistro"];?></td>
                  </tr>
                  <?php
                } 
              }
              else
              { //No existen datos
                echo "<tr><td colspan=7>No existen registros</td></tr>";
              }
            ?>
            </tbody><!--
            <tfoot>
              <tr>
                <th>Apellido</th>
                <th>Nombre</th>
                <th>Fecha de nacimiento</th>
                <th>Correo</th>
                <th>Clave</th>
                <th>Estado</th>
                <th>Registro</th>
              </tr>
            </tfoot>-->
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php
include ("footer.php");
?>
<!-- Page specific script -->
<script>
  $(function () {
    $("#listado").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#listado_wrapper .col-md-6:eq(0)');
  });
</script>
<script src="../Lab01/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../Lab01/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../Lab01/dist/js/adminlte.min.js"></script>