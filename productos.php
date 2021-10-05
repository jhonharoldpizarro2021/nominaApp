<?php include "header.php"; ?>
<script type="text/javascript" src="js/productos.js?n=<?= time() ?>"></script>
<script type="text/javascript" src="extensions/jquery_form/jquery.form.min.js?n=<?= time() ?>"></script>
<div id="page-wrapper">
  <div class="row">
      <div class="col-lg-12">
          <h1 class="page-header"><i class="fa fa-cart-plus fa-fw"></i> Productos</h1>
      </div>
      <!-- /.col-lg-12 -->
  </div>
  <!-- /.row -->
  <div class="row" id="datos">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <button type="button" class="btn btn-default btn-circle btn-lg" onclick="abrirNuevoProducto()">
            <i class="fa fa-plus"></i>
          </button> Agregar nuevo producto
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
          <div class="dataTable_wrapper table-responsive">
            <table class="table table-striped table-bordered table-hover " id="tabla_productos">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Titulo</th>
                  <th>Precio</th>
                  <th>Imagen</th>
                  <th class="center">Editar</th>
                  <th class="center">Borrar</th>
                </tr>
              </thead>
              <tbody>
              <?php
                $con = start_connect();
                if( $con )
                {
                  $query = "SELECT * FROM productos ORDER BY id_productos ASC";
                  $resultado = mysqli_query($con, $query);
                  while( $row = mysqli_fetch_array($resultado) )
                  {
                  ?>
                    <tr class="<?php echo $class ?> gradeX">
                      <td><?= $row["id_productos"] ?></td>
                      <td><?= utf8_encode( $row["titulo"] ) ?></td>
                      <td><?= $row["precio"] ?></td>
                      <td><?= $row["imagen"] != null ? '<img class="img_producto" src="data:image/*;base64,'. $row["imagen"] .'" />' : '' ?></td>
                      <td class="center">
                        <a href="#" class="fa fa-pencil-square-o" aria-hidden="true" onclick="modificarProducto('<?= $row["id_productos"] ?>','<?= utf8_encode( $row["titulo"] ) ?>',
                          '<?= utf8_encode( $row["descripcion"] ) ?>','<?= $row["precio"] ?>','<?= $row["imagen"] ?>')"></a>
                      </td>
                      <td class="center">
                        <a href="#" class="fa fa-trash-o" aria-hidden="true" onclick="elimnarProducto('<?= $row["id_productos"] ?>')"></a>
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

  <!-- Modal Nuevo producto -->
  <div class="modal fade" id="modalNuevoProducto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"> <i class="fa fa-cart-plus fa-fw"></i> Productos</h4>
        </div>
        <div class="modal-body">
            <div class="col">
              <div class="panel panel-primary">
                <div class="panel-heading">
                  Nuevo Producto
                </div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-lg-12">
                      <form id="form_nuevo_producto" role="form" action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="opcion" value="2">
                        <div class="row form-group">
                          <label class="col-sm-3" for="new_nombre">Titulo:</label>
                          <div class="col-sm-9">
                            <input type="text" id="new_titulo" name="new_titulo" class="form-control" placeholder="Titulo">
                            <div id="msg_error_titulo" class="alert alert-danger" role="alert">Campo requerido</div>
                          </div>
                        </div>
                        <div class="row form-group">
                          <label class="col-sm-3" for="new_descripcion">Descripción:</label>
                          <div class="col-sm-9">
                            <textarea id="new_descripcion" name="new_descripcion" class="form-control" placeholder="Descripción" name="name" rows="8" cols="40"></textarea>
                            <div id="msg_error_descripcion" class="alert alert-danger" role="alert">Campo requerido</div>
                          </div>
                        </div>
                        <div class="row form-group">
                          <label class="col-sm-3" for="new_precio">Precio:</label>
                          <div class="col-sm-9">
                            <input id="new_precio" name="new_precio" class="form-control" placeholder="Precio">
                            <div id="msg_error_precio" class="alert alert-danger" role="alert">Campo requerido</div>
                          </div>
                        </div>
                        <div class="row form-group">
                          <label class="col-sm-3" for="new_imagen">Imagen:</label>
                          <div class="col-sm-9">
                              <input type="file" id="new_imagen" name="new_imagen" class="form-control" placeholder="Imagen">
                            <div id="msg_error_imagen" class="alert alert-danger" role="alert">Campo requerido</div>
                            <img id="preview_new_image" src="" />
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
  <!-- / Modal Nuevo Producto -->
  <!-- Modal Editar usuario -->
  <div class="modal fade" id="modalEditarUsuario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"> <i class="fa fa-cart-plus fa-fw"></i> Usuarios</h4>
        </div>
        <div class="modal-body">
            <div class="col">
              <div class="panel panel-primary">
                <div class="panel-heading">
                  Editar Usuario
                </div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-lg-12">
                      <form id="form_editar_usuario" role="form">
                        <input type="hidden" id="edit_id_usuario" name="edit_id_usuario">
                        <div class="row form-group">
                          <label class="col-sm-3" for="edit_nombre">Nombres:</label>
                          <div class="col-sm-9">
                            <input type="text" id="edit_nombre" name="edit_nombre" class="form-control" placeholder="Nombres">
                            <div id="msg_error_nombre" class="alert alert-danger" role="alert">Campo requerido</div>
                          </div>
                        </div>
                        <div class="row form-group">
                          <label class="col-sm-3" for="edit_apellidos">Apellidos:</label>
                          <div class="col-sm-9">
                            <input type="text" id="edit_apellidos" name="edit_apellidos" class="form-control" placeholder="Apellidos">
                            <div id="msg_error_apellido" class="alert alert-danger" role="alert">Campo requerido</div>
                          </div>
                        </div>
                        <div class="row form-group">
                          <label class="col-sm-3" for="edit_telefono">Teléfono:</label>
                          <div class="col-sm-9">
                            <input id="edit_telefono" name="edit_telefono" class="form-control" placeholder="Teléfono">
                            <div id="msg_error_telefono" class="alert alert-danger" role="alert">Campo requerido</div>
                          </div>
                        </div>
                        <div class="row form-group">
                          <label class="col-sm-3" for="edit_email">E-Mail:</label>
                          <div class="col-sm-9">
                            <input id="edit_email" name="edit_email" class="form-control" placeholder="E-Mail">
                            <div id="msg_error_email" class="alert alert-danger" role="alert">Campo requerido</div>
                          </div>
                        </div>
                        <div class="row form-group">
                          <label class="col-sm-3" for="edit_ciudad">Ciudad:</label>
                          <div class="col-sm-9">
                            <input id="edit_ciudad" name="edit_ciudad" class="form-control" placeholder="Ciudad">
                            <div id="msg_error_ciudad" class="alert alert-danger" role="alert">Campo requerido</div>
                          </div>
                        </div>
                        <div class="row form-group">
                          <label class="col-sm-3" for="edit_pass">Contraseña:</label>
                          <div class="col-sm-9">
                            <input type="password" id="edit_pass" name="edit_pass" class="form-control" placeholder="Contraseña" data-toggle="password">
                            <div id="msg_error_password" class="alert alert-danger" role="alert">Campo requerido</div>
                          </div>
                        </div>
                        <div class="row form-group">
                          <label class="col-sm-3" for="edit_perfil">Perfil:</label>
                          <div class="col-sm-9">
                            <select id="edit_perfil" name="edit_perfil">
                              <option value="null">--Perfil--</option>
                            </select>
                            <div id="msg_error_perfil" class="alert alert-danger" role="alert">Campo requerido</div>
                          </div>
                        </div>
                        <div class="row form-group">
                          <label class="col-sm-3" for="edit_fecha">Fecha de nacimiento:</label>
                          <div class="col-sm-9">
                            <div class="input-group date">
                              <input id="edit_fecha" name="edit_fecha" class="form-control" placeholder="AAAA-MM-DD">
                                <div class="input-group-addon">
                                    <span id="edit_fecha_icon" class="fa fa-calendar cursor"></span>
                                </div>
                            </div>
                            <div id="msg_error_fecha" class="alert alert-danger" role="alert">Campo requerido</div>
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
