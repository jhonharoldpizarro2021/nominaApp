<?php include "header.php"; ?>
<script type="text/javascript" src="js/tipos_novedades.js?n=<?= time() ?>"></script>
<div id="page-wrapper">
  <div class="row">
      <div class="col-lg-12">
          <h1 class="page-header"><i class="fa fa-bullhorn fa-fw"></i> Tipos de novedades</h1>
      </div>
      <!-- /.col-lg-12 -->
  </div>
  <!-- /.row -->
  <div class="row" id="datos">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <button type="button" class="btn btn-default btn-circle btn-lg" onclick="abrirNuevoTipoNovedad()">
            <i class="fa fa-plus"></i>
          </button> Agregar nuevo tipo de novedad
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
          <div class="dataTable_wrapper table-responsive">
            <table class="table table-striped table-bordered table-hover " id="tabla_novedades">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nombre</th>
                  <th>Descripción</th>
                  <th class="center">Editar</th>
                  <th class="center">Borrar</th>
                </tr>
              </thead>
              <tbody>
              <?php
                $con = start_connect();
                if( $con )
                {
                  $query = "SELECT * FROM tipo_novedad ORDER BY id_tipo_novedad ASC";
                  $resultado = mysqli_query($con, $query);
                  while( $row = mysqli_fetch_array($resultado) )
                  {
                  ?>
                    <tr class="<?php echo $class ?> gradeX">
                      <td><?= $row["id_tipo_novedad"] ?></td>
                      <td><?= utf8_encode( $row["nombre"] ) ?></td>
                      <td><?= utf8_encode( $row["descripcion"] ) ?></td>
                      <td class="center">
                        <a href="#" class="fa fa-pencil-square-o" aria-hidden="true" onclick="modificarTipoNovedad('<?= $row["id_tipo_novedad"] ?>','<?= utf8_encode( $row["nombre"] ) ?>',
                          '<?= utf8_encode( $row["descripcion"] ) ?>')"></a>
                      </td>
                      <td class="center">
                        <a href="#" class="fa fa-trash-o" aria-hidden="true" onclick="elimnarTipoNovedad('<?= $row["id_tipo_novedad"] ?>')"></a>
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

  <!-- Modal Nuevo Tipo de novedad -->
  <div class="modal fade" id="modalNuevoTipoNovedad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"> <i class="fa fa-bullhorn fa-fw"></i> Tipos de novedades</h4>
        </div>
        <div class="modal-body">
            <div class="col">
              <div class="panel panel-primary">
                <div class="panel-heading">
                  Nuevo tipo de novedad
                </div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-lg-12">
                      <form id="form_nuevo_tipo_novedad" role="form">
                        <div class="row form-group">
                          <label class="col-sm-3" for="new_nombre">Nombre:</label>
                          <div class="col-sm-9">
                            <input type="text" id="new_nombre" name="new_nombre" class="form-control" placeholder="Nombre">
                            <div id="msg_error_nombre" class="alert alert-danger" role="alert">Campo requerido</div>
                          </div>
                        </div>
                        <div class="row form-group">
                          <label class="col-sm-3" for="new_descripcion">Descripción:</label>
                          <div class="col-sm-9">
                            <textarea id="new_descripcion" name="new_descripcion" class="form-control" placeholder="Descripcón del tipo de novedad" rows="8" cols="40"></textarea>
                            <div id="msg_error_descripcion" class="alert alert-danger" role="alert">Campo requerido</div>
                          </div>
                        </div>
                        <div class="row form-group text-center">
                          <button id="btn_guardar_nuevo" type="button" onclick="guardarNuevo()"  class="btn btn-primary"
                            data-loading-text="<i class='fa fa-spinner fa-pulse fa-fw'></i> Guardando...">Guardar</button>
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
  <div class="modal fade" id="modalEditarTipoNovedad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"> <i class="fa fa-bullhorn fa-fw"></i> Tipos de novedades</h4>
        </div>
        <div class="modal-body">
            <div class="col">
              <div class="panel panel-primary">
                <div class="panel-heading">
                  Editar tipo de novedad
                </div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-lg-12">
                      <form id="form_editar_tipo_novedad" role="form">
                        <input type="hidden" id="edit_id_tipo_novedad" name="edit_id_tipo_novedad">
                        <div class="row form-group">
                          <label class="col-sm-3" for="edit_nombre">Nombre:</label>
                          <div class="col-sm-9">
                            <input type="text" id="edit_nombre" name="edit_nombre" class="form-control" placeholder="Nombre">
                            <div id="msg_error_nombre" class="alert alert-danger" role="alert">Campo requerido</div>
                          </div>
                        </div>
                        <div class="row form-group">
                          <label class="col-sm-3" for="edit_descripcion">Descripción:</label>
                          <div class="col-sm-9">
                            <textarea id="edit_descripcion" name="edit_descripcion" class="form-control" placeholder="Descripción del tipo de novedad" name="name" rows="8" cols="40">
                            </textarea>
                            <div id="msg_error_descripcion" class="alert alert-danger" role="alert">Campo requerido</div>
                          </div>
                        </div>

                        <div class="row form-group text-center">
                          <button id="btn_guardar_edit" type="button" onclick="guardarModificacion()"  class="btn btn-primary"
                            data-loading-text="<i class='fa fa-spinner fa-pulse fa-fw'></i> Actualizando...">Actualizar</button>
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
