<?php
include ("header.php");

$mensaje = "";
if(isset($_POST["mensaje"])) $mensaje = $_POST["mensaje"];
if(isset($_GET["mensaje"])) $mensaje = $_GET["mensaje"];
$idregistro = "";
if(isset($_POST["idregistro"])) $idregistro = $_POST["idregistro"];
if ($idregistro) {
  // Eliminar un cliente
  $sql = "DELETE FROM cliente WHERE idcliente = '$idregistro' ";
  dbQuery($sql);
  $mensaje = "3";
}

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
            <h1>Lista de clientes</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <a class="btn btn-block btn-primary" href="cliente_detalle.php?sAccion=new" style="width: 100px;">  Nuevo  </a>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
      <div class="card-header">
          <!-- Formulario de filtros (si deseas añadir filtros) -->
        </div>
        <!-- /.card-header -->
        <?php
        // Consulta para obtener los clientes
        $sql = "SELECT c.`idcliente`, c.`tipopersona`, c.`nombre`, c.`tipodocumento`, c.`numdocumento`, 
                c.`direccion`, c.`telefono`, c.`correo`, c.`estado`, c.`fecharegistro` "; 
        $sql.= "FROM `cliente` c ";
        $sql.= "ORDER BY c.nombre";
        $result = dbQuery($sql);
        $total_registros = mysqli_num_rows($result);
        ?>
        <div class="card-body">
          <table id="listado" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>Nombre</th>
              <th>Tipo Persona</th>
              <th>Tipo Documento</th>
              <th>Número Documento</th>
              <th>Dirección</th>
              <th>Teléfono</th>
              <th>Correo</th>
              <th>Estado</th>
              <th>Fecha Registro</th>
              <th style="width: 150px;"></th>
            </tr>
            </thead>
            <tbody>
            <?php 
              if($total_registros > 0)
              { // Existen datos
                while ($row = mysqli_fetch_array($result)) {
                  $estado = "Inactivo";
                  if($row["estado"] == "A"){
                    $estado = "Activo";
                  }
                  ?>
                  <tr>
                    <td><?php echo $row["nombre"];?></td>
                    <td><?php echo $row["tipopersona"];?></td>
                    <td><?php echo $row["tipodocumento"];?></td>
                    <td><?php echo $row["numdocumento"];?></td>
                    <td><?php echo $row["direccion"];?></td>
                    <td><?php echo $row["telefono"];?></td>
                    <td><?php echo $row["correo"];?></td>
                    <td><?php echo $estado;?></td>
                    <td><?php echo $row["fecharegistro"];?></td>
                    <td class="text-center">
                        <a class="btn btn-info btn-sm" href="cliente_detalle.php?sAccion=edit&idcliente=<?php echo $row["idcliente"]?>">
                            <i class="fas fa-pencil-alt">
                            </i>
                            Editar
                        </a>
                        <a class="btn btn-danger btn-sm delete_btn" data-toggle="modal" data-target="#modal-delete" data-idregistro="<?php echo $row['idcliente']; ?>" >
                            <i class="fas fa-trash">
                            </i>
                            Eliminar
                        </a>
                    </td>
                  </tr>
                  <?php
                } 
              }
              else
              { // No existen datos
                echo "<tr><td colspan=10>No existen registros</td></tr>";
              }
            ?>
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
            
      <!-- MODAL: Eliminar -->
      <div class="modal fade" id="modal-delete">
        <div class="modal-dialog">
          <div class="modal-content">
            <form action="cliente.php" method="post">
              <div class="modal-header">
                <h4 class="modal-title">Advertencia</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                  <input type="text" name="idregistro" id="idregistro"> <!-- hidden -->
                  <p>¿Esta seguro que desea eliminar el registro seleccionado?</p>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                <button type="submit" name="eliminar_registro" class="btn bg-danger btn-ok">Eliminar</button>
              </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

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

<!-- MODAL DELETE -->
<script>
  $('#modal-delete').on('show.bs.modal', function(e){
      var button = $(e.relatedTarget)
      var idregistro = button.data('idregistro')
      var modal = $(this)
      modal.find('.modal-body #idregistro').val(idregistro);
    }
  )
</script>

<?php 
//Mensajes - TOASTR
if ($mensaje == '1') { ?>
    <script>
        toastr.success("La información se registró correctamente..!");
    </script>
<?php } else if ($mensaje == '2') { ?>
    <script>
        toastr.info("La información se actualizó correctamente..!");
    </script>
<?php } else if ($mensaje == '3') { ?>
    <script>
        toastr.warning("La información se eliminó correctamente..!");
    </script>
<?php } else if ($mensaje == '4') { ?>
    <script>
        toastr.error("Lo sentimos, se ha producido un error..!");
    </script>
<?php } ?> 
