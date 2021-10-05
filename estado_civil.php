<?php include "header.php"; ?>
<script type="text/javascript" src="js/estado_civil.js?n=<?= time() ?>"></script>
<div id="page-wrapper">
  <div class="row">
      <div class="col-lg-12">
          <h1 class="page-header"><i class="fa fa-slideshare fa-fw"></i> Estados Civiles</h1>
      </div>
      <!-- /.col-lg-12 -->
  </div>
  <!-- /.row -->
  <div class="row" id="datos">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <button type="button" class="btn btn-default btn-circle btn-lg nuevaeps" data-toggle="modal" data-target="#modalNuevo"><i class="fa fa-plus"></i></button> Agregar Estado Civil
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
          <div class="dataTable_wrapper table-responsive">
            <table class="table table-striped table-bordered table-hover " id="tabla">
              <thead>
                <tr>
                  <th>Nombre</th>
                  <th class="center">Editar</th>
                  <th class="center">Borrar</th>
                </tr>
              </thead>
              <tbody>
              <?php
                $con = start_connect();
                if( $con )
                {
                  $query = "SELECT * FROM estado_civil ORDER BY nombre ASC";
                  $resultado = mysqli_query($con, $query);
                  while( $row = mysqli_fetch_array($resultado) )
                  {
                  ?>
                    <tr class="<?php echo $class ?> gradeX">
                      <td><?= utf8_encode( $row["nombre"] ) ?></td>
                      <td class="center">
                        <a href="#" class="fa fa-pencil-square-o" aria-hidden="true" onclick="editar('<?= $row["id_estado_civil"] ?>','<?= utf8_encode( $row["nombre"] ) ?>')"></a>
                      </td>
                      <td class="center">
                        <a href="#" class="fa fa-trash-o" aria-hidden="true" onclick="eliminar('<?= $row["id_estado_civil"] ?>','<?= utf8_encode( $row["nombre"] ) ?>')"></a>
                      </td>
                    </tr>
                <?php
                  }
                  if( !close_bd($con) )
                  {
                    echo "Error al cerrar la BDD";
                  }
                }else{
                  echo "Error de conexión a la BDD:". mysqli_connect_error();
                }
              ?>
              </tbody>
            </table>
          </div>
            <!-- /.table-responsive -->
        </div>
          <!-- /.panel-body -->
      </div>
      <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
  </div>
  <!-- /.row -->

  <!-- Modal Nuevo usuario -->
  <div class="modal fade" id="modalNuevo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"> <i class="fa fa-slideshare fa-fw"></i> Estados Civiles</h4>
        </div>
        <div class="modal-body">
            <div class="col">
              <div class="panel panel-primary">
                <div class="panel-heading">
                  Nuevo Estado Civil
                </div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-lg-12">
                      <form id="form_nuevo" role="form">
                        <div class="row form-group">
                          <label class="col-sm-3" for="new_nombre">Nombre:</label>
                          <div class="col-sm-9">
                            <input type="text" required id="new_nombre" name="new_nombre" class="form-control" placeholder="Nombres">
                            <div id="msg_error_nombre" class="alert alert-danger" role="alert">Campo requerido</div>
                          </div>
                        </div>
                        <div class="row form-group text-center">
                          <button id="btn_guardar_nuevo" type="button" onclick="guardarNuevo()"  class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-pulse fa-fw'></i> Guardando...">Guardar</button>
                        </div>
                      </form>
                    </div>
                    <!-- /.col-lg-12 (nested) -->
                  </div>
                  <!-- /.row (nested) -->
                </div>
                  <!-- /.panel-body -->
              </div>
              <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- / Modal Nuevo usuario -->
  <!-- Modal Editar usuario -->
  <div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"> <i class="fa fa-slideshare fa-fw"></i> Estados Civiles</h4>
        </div>
        <div class="modal-body">
            <div class="col">
              <div class="panel panel-primary">
                <div class="panel-heading">
                  Editar Estado Civil
                </div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-lg-12">
                      <form id="form_editar" role="form">
                        <input type="hidden" id="edit_id_estado_civil" name="edit_id_estado_civil">
                        <div class="row form-group">
                          <label class="col-sm-3" for="edit_nombre">Nombre:</label>
                          <div class="col-sm-9">
                            <input type="text" id="edit_nombre" name="edit_nombre" class="form-control" placeholder="Nombres">
                            <div id="msg_error_nombre" class="alert alert-danger" role="alert">Campo requerido</div>
                          </div>
                        </div>
                        <div class="row form-group text-center">
                          <button id="btn_guardar_edit" type="button" onclick="guardarEdicion()"  class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-pulse fa-fw'></i> Actualizando...">Actualizar</button>
                        </div>
                      </form>
                    </div>
                    <!-- /.col-lg-12 (nested) -->
                  </div>
                  <!-- /.row (nested) -->
                </div>
                  <!-- /.panel-body -->
              </div>
              <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- / Modal Editar usuario -->

<?php include "footer.php";?>
