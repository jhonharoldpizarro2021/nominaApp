<?php include "header.php"; ?>
<script type="text/javascript" src="js/ciudad.js?n=<?= time() ?>"></script>
<div id="page-wrapper">
  <div class="row">
      <div class="col-lg-12">
          <h1 class="page-header"><i class="fa fa-location-arrow fa-fw"></i> Ciudades</h1>
      </div>
      <!-- /.col-lg-12 -->
  </div>
  <!-- /.row -->
  <div class="row" id="datos">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <button type="button" class="btn btn-default btn-circle btn-lg" onclick="abrirNuevo()">
            <i class="fa fa-plus"></i>
          </button> Agregar Ciudad
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
          <div class="dataTable_wrapper table-responsive">
            <table class="table table-striped table-bordered table-hover " id="tabla">
              <thead>
                <tr>
                  <th>Ciudad</th>
                  <th>Departamento</th>
                  <th>Pais</th>
                  <th class="center">Editar</th>
                  <th class="center">Borrar</th>
                </tr>
              </thead>
              <tbody>
              <?php
                $con = start_connect();
                if( $con )
                {
                  $query = "SELECT * FROM qr_pais_ciudad ORDER BY nombre ASC";
                  $resultado = mysqli_query($con, $query);
                  while( $row = mysqli_fetch_array($resultado) )
                  {
                  ?>
                    <tr class="<?php echo $class ?> gradeX">
                      <td><?= utf8_encode( $row["nombre_ciudad"] ) ?></td>
                      <td><?= utf8_encode( $row["nombre_departamento"] ) ?></td>
                      <td><?= utf8_encode( $row["nombre"] ) ?></td>
                      <td class="center">
                        <a class="fa fa-pencil-square-o" aria-hidden="true" onclick="editar('<?= $row["id_ciudad"] ?>','<?= utf8_encode( $row["nombre_ciudad"] ) ?>', '<?= $row["id_departamento"] ?>', '<?= $row["id_pais"] ?>')"></a>
                      </td>
                      <td class="center">
                        <a class="fa fa-trash-o" aria-hidden="true" onclick="eliminar('<?= $row["id_ciudad"] ?>','<?= utf8_encode( $row["nombre_ciudad"] ) ?>')"></a>
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

  <!-- Modal Nueva Ciudad  -->
  <div class="modal fade" id="modalNuevo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"> <i class="fa fa-location-arrow fa-fw"></i> Ciudades</h4>
        </div>
        <div class="modal-body">
            <div class="col">
              <div class="panel panel-primary">
                <div class="panel-heading">
                  Nueva Ciudad
                </div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-lg-12">
                      <form id="form_nuevo" role="form">
                        <div class="row form-group">
                          <label class="col-sm-3" for="new_ciudad">Nombre:</label>
                          <div class="col-sm-9">
                            <input type="text" required id="new_ciudad" name="new_ciudad" class="form-control" placeholder="Nombres">
                            <div id="msg_error_nombre" class="alert alert-danger" role="alert">Campo requerido</div>
                          </div>
                        </div>
                        <div class="row form-group">
                          <label class="col-sm-3" for="new_pais">Pais:</label>
                          <div class="col-sm-9">
                            <select id="new_pais" name="new_pais" class="form-control">
                              <option value="null">--Pais--</option>
                            </select>
                            <div class="input-group-addon add">
                                <span id="new_tipo_icon" class="fa fa-plus cursor" onclick="temporal()"></span>
                            </div>
                            <div id="msg_error_pais" class="alert alert-danger" role="alert">Campo requerido</div>
                          </div>
                        </div>
                        <div class="row form-group depto">
                          <label class="col-sm-3" for="new_departamento">Departamento:</label>
                          <div class="col-sm-9">
                            <select id="new_departamento" name="new_departamento" class="form-control">
                              <option value="null">--Departamento--</option>
                            </select>
                            <div class="input-group-addon add">
                                <span id="new_tipo_icon" class="fa fa-plus cursor" onclick="temporal()"></span>
                            </div>
                            <div id="msg_error_departamento" class="alert alert-danger" role="alert">Campo requerido</div>
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
  <!-- / Modal Nuevoa Ciudad  -->
  <!-- Modal Editar  -->
  <div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"> <i class="fa fa-location-arrow fa-fw"></i> Ciudades</h4>
        </div>
        <div class="modal-body">
            <div class="col">
              <div class="panel panel-primary">
                <div class="panel-heading">
                  Editar Ciudad
                </div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-lg-12">
                      <form id="form_editar" role="form">
                        <input type="hidden" id="edit_id_ciudades" name="edit_id_ciudades">
                        <div class="row form-group">
                          <label class="col-sm-3" for="edit_nombre">Nombre:</label>
                          <div class="col-sm-9">
                            <input type="text" id="edit_nombre" name="edit_nombre" class="form-control" placeholder="Nombres">
                            <div id="msg_error_nombre" class="alert alert-danger" role="alert">Campo requerido</div>
                          </div>
                        </div>
                        <div class="row form-group">
                          <label class="col-sm-3" for="edit_pais">Pais:</label>
                          <div class="col-sm-9">
                            <select id="edit_pais" name="edit_pais" class="form-control">
                              <option value="null">--Pais--</option>
                            </select>
                            <div class="input-group-addon add">
                                <span id="new_tipo_icon" class="fa fa-plus cursor" onclick="temporal()"></span>
                            </div>
                            <div id="msg_error_pais" class="alert alert-danger" role="alert">Campo requerido</div>
                          </div>
                        </div>
                        <div class="row form-group depto">
                          <label class="col-sm-3" for="edit_departamento">Departamento:</label>
                          <div class="col-sm-9">
                            <select id="edit_departamento" name="edit_departamento" class="form-control">
                              <option value="null">--Pais--</option>
                            </select>
                            <div class="input-group-addon add">
                                <span id="edit_tipo_icon" class="fa fa-plus cursor" onclick="temporal()"></span>
                            </div>
                            <div id="msg_error_departamento" class="alert alert-danger" role="alert">Campo requerido</div>
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
  <!-- Modal Sppinner -->
  <div class="modal fade" id="modalSpinner" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="demo">
      <svg class="loader">
        <filter id="blur">
          <fegaussianblur in="SourceGraphic" stddeviation="2"></fegaussianblur>
        </filter>
        <circle cx="75" cy="75" r="60" fill="transparent" stroke="#F4F519" stroke-width="6" stroke-linecap="round" stroke-dasharray="385" stroke-dashoffset="385" filter="url(#blur)"></circle>
      </svg>
      <svg class="loader loader-2">
        <circle cx="75" cy="75" r="60" fill="transparent" stroke="#DE2FFF" stroke-width="6" stroke-linecap="round" stroke-dasharray="385" stroke-dashoffset="385" filter="url(#blur)"></circle>
      </svg>
      <svg class="loader loader-3">
        <circle cx="75" cy="75" r="60" fill="transparent" stroke="#FF5932" stroke-width="6" stroke-linecap="round" stroke-dasharray="385" stroke-dashoffset="385" filter="url(#blur)"></circle>
      </svg>
      <svg class="loader loader-4">
        <circle cx="75" cy="75" r="60" fill="transparent" stroke="#E97E42" stroke-width="6" stroke-linecap="round" stroke-dasharray="385" stroke-dashoffset="385" filter="url(#blur)"></circle>
      </svg>
      <svg class="loader loader-5">
        <circle cx="75" cy="75" r="60" fill="transparent" stroke="white" stroke-width="6" stroke-linecap="round" filter="url(#blur)"></circle>
      </svg>
      <svg class="loader loader-6">
        <circle cx="75" cy="75" r="60" fill="transparent" stroke="#00DCA3" stroke-width="6" stroke-linecap="round" stroke-dasharray="385" stroke-dashoffset="385" filter="url(#blur)"></circle>
      </svg>
      <svg class="loader loader-7">
        <circle cx="75" cy="75" r="60" fill="transparent" stroke="purple" stroke-width="6" stroke-linecap="round" stroke-dasharray="385" stroke-dashoffset="385" filter="url(#blur)"></circle>
      </svg>
      <svg class="loader loader-8">
        <circle cx="75" cy="75" r="60" fill="transparent" stroke="#AAEA33" stroke-width="6" stroke-linecap="round" stroke-dasharray="385" stroke-dashoffset="385" filter="url(#blur)"></circle>
      </svg>
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- / Modal Spinner -->

<?php include "footer.php";?>
