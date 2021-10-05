<?php include "header.php"; ?>
<script type="text/javascript" src="js/usuarios.js?n=<?= time() ?>"></script>
<div id="page-wrapper">
  <div class="row">
      <div class="col-lg-12">
          <h1 class="page-header"><i class="fa fa-key fa-fw"></i> Usuarios</h1>
      </div>
      <!-- /.col-lg-12 -->
  </div>
  <!-- /.row -->
  <div class="row" id="datos">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <button type="button" class="btn btn-default btn-circle btn-lg" onclick="abrirNuevoUsuario()">
            <i class="fa fa-plus"></i>
          </button> Agregar Nuevo Usuario
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
          <div class="dataTable_wrapper table-responsive">
            <table class="table table-striped table-bordered table-hover " id="tabla_usuarios">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nombre</th>
                  <th>Correo</th>
                  <th>Teléfono</th>
                  <th>Perfil</th>
                  <th class="center">Editar</th>
                  <th class="center">Borrar</th>
                </tr>
              </thead>
              <tbody>
              <?php
                $con = start_connect();
                if( $con )
                {
                  $query = "SELECT id_usuarios,nombre,apellidos,correo,telefono,id_perfil,perfil,ciudad,fecha_nacimiento,
                            AES_DECRYPT(password,'". $GLOBALS["KEY_ENCRYPT_PASS"] ."') AS password FROM qr_usuarios_perfiles ORDER BY id_usuarios ASC";
                  $resultado = mysqli_query($con, $query);
                  while( $row = mysqli_fetch_array($resultado) )
                  {
                  ?>
                    <tr class="<?php echo $class ?> gradeX">
                      <td><?= $row["id_usuarios"] ?></td>
                      <td><?= utf8_encode( $row["nombre"] ." ". $row["apellidos"]) ?></td>
                      <td><?= $row["correo"] ?></td>
                      <td><?= $row["telefono"] ?></td>
                      <td><?= utf8_encode( $row["perfil"] ) ?></td>
                      <td class="center">
                        <a href="#" class="fa fa-pencil-square-o" aria-hidden="true" onclick="modificarUsuario('<?= $row["id_usuarios"] ?>','<?= utf8_encode( $row["nombre"] ) ?>',
                          '<?= utf8_encode( $row["apellidos"] ) ?>','<?= $row["correo"] ?>','<?= $row["telefono"] ?>','<?= utf8_encode( $row["ciudad"] ) ?>',
                          '<?= $row["password"] ?>','<?= utf8_encode( $row["id_perfil"] ) ?>','<?= $row["fecha_nacimiento"] ?>')"></a>
                      </td>
                      <td class="center">
                        <a href="#" class="fa fa-trash-o" aria-hidden="true" onclick="elimnarUsuario('<?= $row["id_usuarios"] ?>')"></a>
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
  <div class="modal fade" id="modalNuevoUsuario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"> <i class="fa fa-key fa-fw"></i> Usuarios</h4>
        </div>
        <div class="modal-body">
            <div class="col">
              <div class="panel panel-primary">
                <div class="panel-heading">
                  Nuevo Usuario
                </div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-lg-12">
                      <form id="form_nuevo_usuario" role="form">
                        <div class="row form-group">
                          <label class="col-sm-3" for="new_nombre">Nombres:</label>
                          <div class="col-sm-9">
                            <input type="text" id="new_nombre" name="new_nombre" class="form-control" placeholder="Nombres">
                            <div id="msg_error_nombre" class="alert alert-danger" role="alert">Campo requerido</div>
                          </div>
                        </div>
                        <div class="row form-group">
                          <label class="col-sm-3" for="new_apellidos">Apellidos:</label>
                          <div class="col-sm-9">
                            <input type="text" id="new_apellidos" name="new_apellidos" class="form-control" placeholder="Apellidos">
                            <div id="msg_error_apellido" class="alert alert-danger" role="alert">Campo requerido</div>
                          </div>
                        </div>
                        <div class="row form-group">
                          <label class="col-sm-3" for="new_telefono">Teléfono:</label>
                          <div class="col-sm-9">
                            <input id="new_telefono" name="new_telefono" class="form-control" placeholder="Teléfono">
                            <div id="msg_error_telefono" class="alert alert-danger" role="alert">Campo requerido</div>
                          </div>
                        </div>
                        <div class="row form-group">
                          <label class="col-sm-3" for="new_email">E-Mail:</label>
                          <div class="col-sm-9">
                            <input id="new_email" name="new_email" class="form-control" placeholder="E-Mail">
                            <div id="msg_error_email" class="alert alert-danger" role="alert">Campo requerido</div>
                          </div>
                        </div>
                        <div class="row form-group">
                          <label class="col-sm-3" for="new_ciudad">Ciudad:</label>
                          <div class="col-sm-9">
                            <input id="new_ciudad" name="new_ciudad" class="form-control" placeholder="Ciudad">
                            <div id="msg_error_ciudad" class="alert alert-danger" role="alert">Campo requerido</div>
                          </div>
                        </div>
                        <div class="row form-group">
                          <label class="col-sm-3" for="new_pass">Contraseña:</label>
                          <div class="col-sm-9">
                            <input type="password" id="new_pass" name="new_pass" class="form-control" placeholder="Contraseña" data-toggle="password">
                            <div id="msg_error_password" class="alert alert-danger" role="alert">Campo requerido</div>
                          </div>
                        </div>
                        <div class="row form-group">
                          <label class="col-sm-3" for="new_perfil">Perfil:</label>
                          <div class="col-sm-9">
                            <select id="new_perfil" name="new_perfil" class="form-control">
                              <option value="null">--Perfil--</option>
                            </select>
                            <div id="msg_error_perfil" class="alert alert-danger" role="alert">Campo requerido</div>
                          </div>
                        </div>
                        <div class="row form-group">
                          <label class="col-sm-3" for="new_fecha">Fecha de nacimiento:</label>
                          <div class="col-sm-9">
                            <div class="input-group date" >
                              <input id="new_fecha" name="new_fecha" class="form-control" placeholder="AAAA-MM-DD">
                                <div class="input-group-addon">
                                    <span id="new_fecha_icon" class="fa fa-calendar cursor"></span>
                                </div>
                            </div>
                            <div id="msg_error_fecha" class="alert alert-danger" role="alert">Campo requerido</div>
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
  <div class="modal fade" id="modalEditarUsuario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"> <i class="fa fa-key fa-fw"></i> Usuarios</h4>
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
                            <select id="edit_perfil" name="edit_perfil" class="form-control">
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
