<?php include "header.php"; ?>
<script type="text/javascript" src="js/empleados.js?n=<?= time() ?>"></script>
<script type="text/javascript" src="js/parametros.js?n=<?= time() ?>"></script>
<div id="page-wrapper">
  <div class="row">
      <div class="col-lg-12">
          <h1 class="page-header"><i class="fa fa-users fa-fw"></i> Empleados</h1>
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
          </button> Agregar Nuevo empleado
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
          <div class="dataTable_wrapper table-responsive">
            <table class="table table-striped table-bordered table-hover " id="tabla">
              <thead>
                <tr>
                  <th class="center" id="">Ver</th>
                  <th>Nombres y Apellidos</th>
                  <th>Documento</th>
                  <th>Tel&eacute;fono</th>
                  <th>Celular</th>
                  <th>Email</th>
                  <th class="center">Seg.Soc.</th>
                  <th class="center">Editar</th>
                  <th class="center">Borrar</th>
                </tr>
              </thead>
              <tbody>
              <?php
                $con = start_connect();
                if( $con )
                {
                  $query = "SELECT * FROM qr_empleado ORDER BY primerNombreEmpleado ASC";
                  $resultado = mysqli_query($con, $query);
                  while( $row = mysqli_fetch_array($resultado) )
                  {
                    /*
                    // SI LA EPS ARL PENSION CAJA ESTA REGISTRADA NO MUESTRA EL ICONO, 
                    // SI FALTA MUESTRA EL ICONO CORRESPONDIENTE EN COLOR NARANJA O ROJO
                    // AL DAR CLIC PERMITE AGREGARLA
                    // SI ESTAN TODAS QUE MUESTRE UN ICONO DE VERIFICACION
                    */
                    $link_segSoc = '';
                    $link_segSoc .= $row["estado_afiliacion_salud_empleado"] == 1 ? "" : '<i class="fa fa-ambulance fa-fw" data-toggle="tooltip" data-placement="top" title="E.P.S. Pendiente"></i>';
                    $link_segSoc .= $row["estado_afiliacion_arl_empleado"] == 1 ? "" : '</i> <i class="fa fa-medkit fa-fw" data-toggle="tooltip" data-placement="top" title="A.R.L. Pendiente"></i>';
                    $link_segSoc .= $row["estado_afiliacion_pension_emplado"] == 1 ? "" : '<i class="fa fa-wheelchair fa-fw" data-toggle="tooltip" data-placement="top" title="Fondo Pensiones Pendiente"></i>';
                    $link_segSoc .= $row["estado_afiliacion_caja_empleado"] == 1 ? "" : '<i class="fa fa-heartbeat fa-fw" data-toggle="tooltip" data-placement="top" title="Caja Compensación Pendiente"></i>';
                    if( $link_segSoc == '' )
                    {
                     $link_segSoc = '<i class="fa fa-check" aria-hidden="true"></i>';
                    }
                  ?>
                    <tr class="<?php echo $class ?> gradeX">
                      <td class="center">
                        <a  class="fa fa-eye" aria-hidden="true" onclick="ver('<?= $row["IDEmpleado"] ?>','<?= utf8_encode( $row["primerNombreEmpleado"] ) ?>','<?= utf8_encode( $row["segundoNombreEmpleado"] ) ?>','<?= utf8_encode( $row["primerApellidoEmpleado"] ) ?>','<?= utf8_encode( $row["segundoApellidoEmpleado"] ) ?>','<?= utf8_encode( $row["tipo_documento"] ) ?>','<?= $row["nroDocEmpleado"] ?>','<?= $row["fechaExpedicionDocEmpleado"] ?>','<?= utf8_encode( $row["lugarExpedicionDocEmpleado"] )?>','<?= $row["fechaNacimientoEmpleado"] ?>','<?= utf8_encode( $row["ciudadNacimientoEmpleado"] )?>','<?= utf8_encode( $row["paisNacimientoEmpleado"] )?>','<?= utf8_encode( $row["generoEmpleado"] ) ?>','<?= utf8_encode( $row["estadoCivilEmpleado"] ) ?>','<?= utf8_encode( $row["nivelEstudioEmpleado"] )?>','<?= utf8_encode( $row["tituloEmpleado"] ) ?>','<?= utf8_encode( $row["direccionEmpleado"] ) ?>','<?= utf8_encode( $row["barrioEmpleado"] ) ?>','<?= $row["IDestratoEmpleado"] ?>','<?= utf8_encode( $row["ciudadResidenciaEmpleado"] )?>','<?= $row["telefonoEmpleado"] ?>','<?= $row["celularEmpleado"] ?>','<?= $row["emailEmpleado"] ?>','<?= utf8_encode( $row["etniaEmpleado"] ) ?>','<?= utf8_encode( $row["comentariosEmpleado"] ) ?>')"></a>
                      </td>
                      <td><?= utf8_encode( $row["primerNombreEmpleado"] ) ." ".  utf8_encode( $row["segundoNombreEmpleado"] ) ." ".  utf8_encode( $row["primerApellidoEmpleado"] ) ." ".  utf8_encode( $row["segundoApellidoEmpleado"] ) ?></td>
                      <td><?= $row["nroDocEmpleado"] ?></td>
                      <td><?= $row["telefonoEmpleado"] ?></td>
                      <td><?= $row["celularEmpleado"] ?></td>
                      <td><?= $row["emailEmpleado"] ?></td>
                      <td class="center"><?= $link_segSoc ?></td>
                      <td class="center">
                        <a  class="fa fa-pencil-square-o" aria-hidden="true" onclick="editar('<?= $row["IDEmpleado"] ?>','<?= utf8_encode( $row["primerNombreEmpleado"] ) ?>','<?= utf8_encode( $row["segundoNombreEmpleado"] ) ?>','<?= utf8_encode( $row["primerApellidoEmpleado"] ) ?>','<?= utf8_encode( $row["segundoApellidoEmpleado"] ) ?>','<?= $row["IDtipoDocEmpleado"] ?>','<?= $row["nroDocEmpleado"] ?>','<?= $row["fechaExpedicionDocEmpleado"] ?>','<?= $row["IDlugarExpedicionDocEmpleado"] ?>','<?= $row["fechaNacimientoEmpleado"] ?>','<?= $row["IDciudadNacimientoEmpleado"] ?>','<?= $row["IDpaisNacimientoEmpleado"] ?>','<?= $row["IDgeneroEmpleado"] ?>','<?= $row["IDestadoCivilEmpleado"] ?>','<?= $row["IDnivelEstudioEmpleado"] ?>','<?= utf8_encode( $row["tituloEmpleado"] ) ?>','<?= utf8_encode( $row["direccionEmpleado"] ) ?>','<?= utf8_encode( $row["barrioEmpleado"] ) ?>','<?= $row["IDestratoEmpleado"] ?>','<?= $row["IDciudadResidenciaEmpleado"] ?>','<?= $row["telefonoEmpleado"] ?>','<?= $row["celularEmpleado"] ?>','<?= $row["emailEmpleado"] ?>','<?= $row["IDetniaEmpleado"] ?>','<?= utf8_encode( $row["comentariosEmpleado"] ) ?>')"></a>
                      </td>
                      <td class="center">
                        <a  class="fa fa-trash-o" aria-hidden="true" onclick="eliminar('<?= $row["IDEmpleado"] ?>','<?= $row["nroDocEmpleado"] ?>','<?= utf8_encode( $row["primerNombreEmpleado"] ) ?>','<?= utf8_encode( $row["primerApellidoEmpleado"] ) ?>')"></a>
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
  <!-- Modal Nuevo empleado -->
  <div class="modal fade" id="modalNuevo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"> <i class="fa fa-users fa-fw"></i> Empleados</h4>
        </div>
        <div class="modal-body" id="">
          <!-- Nav tabs -->
          <ul class="nav nav-tabs" id="mytabs">
              <li class="active">
                  <a href="#datosBasicos" data-toggle="tab" aria-expanded="true">Datos Basicos</a>
              </li>
              <li class="disable disabledTab">
                  <a href="#datosEps" data-toggle="tab">E.P.S.</a>
              </li>
              <li class="disable disabledTab">
                  <a href="#datosArl" data-toggle="tab">A.R.L</a>
              </li>
              <li class="disable disabledTab">
                  <a href="#datosPension" data-toggle="tab">Fondo Pensión</a>
              </li>
              <li class="disable disabledTab">
                  <a href="#datosCaja" data-toggle="tab">Caja Compensación</a>
              </li>
              <li class="disable disabledTab">
                  <a href="#datosReferencias" data-toggle="tab">Referencias Personales</a>
              </li>
              <li class="disable disabledTab">
                  <a href="#datosEmpresa" data-toggle="tab">Contrato Trabajo</a>
              </li>
          </ul>
          <!-- Tab panes -->
          <div class="tab-content">
            <div class="tab-pane fade active in" id="datosBasicos">
                <div class="col">
                  <div class="panel panel-primary">
                    <div class="panel-heading">
                      Nuevo empleado
                    </div>
                    <div class="panel-body">
                      <div class="row">
                        <div class="col-lg-12">
                          <form id="form_nuevo" role="form">
                            <!-- row -->
                            <div class="row form-group">
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 margen">
                                <label for="new_documento">Doc. Identidad:</label>
                                <input type="password" id="new_documento" name="new_documento" class="form-control"  placeholder="Documento de Identidad" autocomplete="off">
                                <div id="msg_error_documento" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                                <div id="msg_validacion" class="alert alert-info" role="alert"><i class="fa fa-refresh fa-spin"></i> Validando Documento</div>
                                <div id="msg_error_validacion" class="alert alert-danger" role="alert"><i class="fa fa-close" aria-hidden="true"></i> Documento Registrado</div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 margen">
                                <label for="new_documento_v">Verifique Doc.:</label>
                                <input type="text" id="new_documento_v" name="new_documento_v" class="form-control" placeholder="Verifique # Documento" autocomplete="off">
                                <div id="msg_error_documento_r" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                                <div id="msg_validacion_v" class="alert alert-info" role="alert"><i class="fa fa-refresh fa-spin"></i> Verificando Documento</div>
                                <div id="msg_ok_documento_v" class="alert alert-success" role="alert"><i class="fa fa-check" aria-hidden="true"></i> El Documento Coincide</div>
                                <div id="msg_error_documento_v" class="alert alert-danger" role="alert"><i class="fa fa-close" aria-hidden="true"></i> El Documento No Coincide</div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 margen">
                                <label for="new_tipo">Tipo de Doc.</label>
                                <div class="input-group">
                                  <select id="new_tipo" name="new_tipo" class="form-control">
                                    <option value="null">--Tipo Documento--</option>
                                  </select>
                                  <div class="input-group-addon add">
                                      <span id="new_tipo_icon" class="fa fa-plus cursor" onclick="addTipo()"></span>
                                  </div>
                                </div>  
                                <div id="msg_error_tipo" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 margen">
                                <label for="new_fechaExp">Fecha de Exp.:</label>
                                <div class="input-group date exp" >
                                  <input id="new_fechaExp" name="new_fechaExp" class="form-control fecha" placeholder="DD-MM-AAAA" autocomplete="off">
                                    <div class="input-group-addon">
                                        <span id="new_fechaExp_icon" class="fa fa-calendar cursor"></span>
                                    </div>
                                </div>
                                <div id="msg_error_fechaExp" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                                <div id="msg_validacion_fechaExp" class="alert alert-info" role="alert"><i class="fa fa-refresh fa-spin"></i> Verificando Fecha</div>
                                <div id="msg_ok_fechaExp" class="alert alert-success" role="alert"><i class="fa fa-check" aria-hidden="true"></i> Fecha Valida</div>
                                <div id="msg_error_fechaExp_v" class="alert alert-danger" role="alert"><i class="fa fa-close" aria-hidden="true"></i> Fecha Invalida</div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 ">
                                <label for="new_ciudadExp">Ciudad de Exp.:</label>
                                <div class="input-group">
                                  <select id="new_ciudadExp" name="new_ciudadExp" class="form-control">
                                    <option value="null">--Ciudad Expedici&oacute;n--</option>
                                  </select>
                                  <div class="input-group-addon add">
                                      <span id="new_ciudad_icon" class="fa fa-plus cursor" onclick="addCiudad()"></span>
                                  </div>
                                </div>
                                <div id="msg_error_ciudadExp" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                            </div>
                            <!-- /row -->
                            <!-- row -->
                            <div class="row form-group">
                              <div class="col-xs-12 col-sm-6 col-md-3 margen">
                                <label for="new_nombre">Primer Nombre:</label>
                                <input type="text" id="new_nombre" name="new_nombre" class="form-control" placeholder="Primer Nombre">
                                <div id="msg_error_nombre" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-3 margen">
                                <label for="new_nombre2">Segundo Nombre:</label>
                                <input type="text" id="new_nombre2" name="new_nombre2" class="form-control" placeholder="Segundo Nombre">
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-3 margen">
                                <label for="new_apellido">Primer Apellido:</label>
                                <input type="text" id="new_apellido" name="new_apellido" class="form-control" placeholder="Primer Apellido">
                                <div id="msg_error_apellido" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-3 ">
                                <label for="new_apellido2">Segundo Apellido:</label>
                                <input type="text" id="new_apellido2" name="new_apellido2" class="form-control" placeholder="Segundo Apellido">
                              </div>
                            </div>
                            <!-- /row -->
                            <!-- row -->                   
                            <div class="row form-group">
                              <div class="col-xs-12 col-sm-6 col-md-3 margen">
                                <label for="new_fechaNac">Fecha Nac.:</label>
                                <div class="input-group date nac">
                                  <input id="new_fechaNac" name="new_fechaNac" class="form-control fecha" placeholder="DD-MM-AAAA" autocomplete="off">
                                    <div class="input-group-addon">
                                        <span id="new_fechaNac_icon" class="fa fa-calendar cursor"></span>
                                    </div>
                                </div>
                                <div id="msg_error_fechaExp" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                                <div id="msg_validacion_fechaNac" class="alert alert-info" role="alert"><i class="fa fa-refresh fa-spin"></i> Verificando Fecha</div>
                                <div id="msg_ok_fechaNac" class="alert alert-success" role="alert"><i class="fa fa-check" aria-hidden="true"></i> Fecha Valida</div>
                                <div id="msg_error_fechaNac_v" class="alert alert-danger" role="alert"><i class="fa fa-close" aria-hidden="true"></i> Fecha Invalida</div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-3 margen">
                                <label for="new_ciudadNac">Ciudad de Nac.:</label>
                                <div class="input-group">
                                  <select id="new_ciudadNac" name="new_ciudadNac" class="form-control">
                                    <option value="null">--Ciudad Nac.--</option>
                                  </select>
                                  <div class="input-group-addon add">
                                      <span id="new_ciudad_icon" class="fa fa-plus cursor" onclick="addCiudad()"></span>
                                  </div>
                                </div>
                                <div id="msg_error_ciudadNac" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-3 margen">
                                <label for="new_paisNac">Pais de Nacimiento:</label>
                                <div class="input-group">
                                  <select id="new_paisNac" name="new_paisNac" class="form-control">
                                    <option value="null">--Pais Nacimiento--</option>
                                  </select>
                                  <div class="input-group-addon add">
                                      <span id="new_pais_icon" class="fa fa-plus cursor" onclick="addPais()"></span>
                                  </div>
                                </div>
                                <div id="msg_error_paisNac" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-3 ">
                                <label for="new_genero">Genero:</label>
                                <div class="input-group">
                                  <select id="new_genero" name="new_genero" class="form-control">
                                    <option value="null">--Genero--</option>
                                  </select>
                                  <div class="input-group-addon add">
                                      <span id="new_genero_icon" class="fa fa-plus cursor" onclick="addGenero()"></span>
                                  </div>
                                </div>
                                <div id="msg_error_genero" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                            </div>
                            <!-- /row -->
                            <!-- row -->
                            <div class="row form-group">
                              <div class="col-xs-12 col-sm-6 col-md-3 ">
                                <label for="new_estado">Estado Civil:</label>
                                <div class="input-group">
                                  <select id="new_estado" name="new_estado" class="form-control">
                                    <option value="null">--Estado Civil--</option>
                                  </select>
                                  <div class="input-group-addon add">
                                      <span id="new_estado_icon" class="fa fa-plus cursor" onclick="addEstado()"></span>
                                  </div>
                                </div>
                                <div id="msg_error_estado" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-3 ">
                                <label for="new_etnia">Etnia:</label>
                                <div class="input-group">
                                  <select id="new_etnia" name="new_etnia" class="form-control">
                                    <option value="null">--Etnia--</option>
                                  </select>
                                  <div class="input-group-addon add">
                                      <span id="new_etnia_icon" class="fa fa-plus cursor" onclick="addEtnia()"></span>
                                  </div>
                                </div>
                                <div id="msg_error_etnia" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-3 ">
                                <label for="new_nivel">Nivel de Estudios:</label>
                                <div class="input-group">
                                  <select id="new_nivel" name="new_nivel" class="form-control">
                                    <option value="null">--Nivel Estudios--</option>
                                  </select>
                                  <div class="input-group-addon add">
                                      <span id="new_nivel_icon" class="fa fa-plus cursor" onclick="addNivel()"></span>
                                  </div>
                                </div>
                                <div id="msg_error_nivel" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-3 ">
                                <label for="new_titulo">Titulo Universitario:</label>
                                <input id="new_titulo" name="new_titulo" class="form-control" placeholder="Titulo Univesitario">
                              </div>
                            </div>
                            <!-- /row -->
                            <!-- row -->                   
                            <div class="row form-group">
                              <div class="col-xs-12 col-sm-6 col-md-3 ">
                                <label for="new_direccion">Direcci&oacute;n:</label>
                                <input id="new_direccion" name="new_direccion" class="form-control" placeholder="Direcci&oacute;n">
                                <div id="msg_error_direccion" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-3 ">
                                <label for="new_barrio">Barrio:</label>
                                <input id="new_barrio" name="new_barrio" class="form-control" placeholder="Barrio">
                                <div id="msg_error_barrio" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-3 ">
                                <label for="new_estrato">Estrato:</label>
                                <div class="input-group">
                                  <select id="new_estrato" name="new_estrato" class="form-control">
                                    <option value="null">--Estrato--</option>
                                  </select>
                                  <div class="input-group-addon add">
                                      <span id="new_estrato_icon" class="fa fa-plus cursor" onclick="addEstrato()"></span>
                                  </div>
                                </div>
                                <div id="msg_error_estrato" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-3 ">
                                <label for="new_ciudad">Ciudad:</label>
                                <div class="input-group">
                                  <select id="new_ciudad" name="new_ciudad" class="form-control">
                                    <option value="null">--Ciudad--</option>
                                  </select>
                                  <div class="input-group-addon add">
                                      <span id="new_ciudad_icon" class="fa fa-plus cursor" onclick="addCiudad()"></span>
                                  </div>
                                </div>
                                <div id="msg_error_ciudad" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                            </div>
                            <!-- /row -->
                            <!-- row -->
                            <div class="row form-group">
                              <div class="ccol-xs-12 col-sm-6 col-md-3 ">
                                <label for="new_telefono">Teléfono:</label>
                                <input id="new_telefono" name="new_telefono" class="form-control" placeholder="Teléfono">
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-3 ">
                                <label for="new_celular">Celular:</label>
                                <input id="new_celular" name="new_celular" class="form-control" placeholder="Celular">
                                <div id="msg_error_celular" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                              <div class="ccol-xs-12 col-sm-6 col-md-3 ">
                                <label for="new_email">E-Mail:</label>
                                <input id="new_email" name="new_email" class="form-control" placeholder="E-Mail">
                                <div id="msg_error_email" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-3 ">
                                <label for="new_comentario">Comentarios:</label>
                                <textarea id="new_comentario" name="new_comentario" class="form-control" placeholder="Comentarios"></textarea>
                              </div>
                            </div>
                            <!-- /row -->
                            <!-- boton guardar  -->
                            <div class="row form-group text-center">
                            <!-- <button id="btn_guardar_nuevo" type="button" onclick="guardarNuevo()"  class="btn btn-primary btn-lg" data-loading-text="<i class='fa fa-spinner fa-pulse fa-fw'></i> Guardando...">Siguiente</button>  -->
                            <button  type="button" id="sgt_eps" class="btn btn-primary btn-lg" data-loading-text="<i class='fa fa-spinner fa-pulse fa-fw'></i> Guardando..." onclick="guardarNuevo()">Siguiente</button>
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
            </div>
            <div class="tab-pane fade  in" id="datosEps">
                <div class="col">
                  <div class="panel panel-primary">
                    <div class="panel-heading">
                      Nombre: <span id="new_nombreEps">$nombre</span> <span id="new_apellidoEps">$apellido</span> /  Documento: <span id="new_documentoEps">$documento</span><span id="new_id_empleadoEps" style="display: none"></span> : Agregar EPS
                    </div>
                    <div class="panel-body">
                      <div class="row">
                        <div class="col-lg-12">
                          <form id="form_nuevo" role="form">
                          	<div class="row form-group">
                          		<div class="col-md-6">
                          			<!-- row -->
		                            <div class="row form-group">
		                              <div class="col-xs-12 col-sm-6 col-md-6 margen">
		                                <label for="new_eps">E.P.S:</label>
		                                <div class="input-group">
		                                  <select id="new_eps" name="new_eps" class="form-control">
		                                    <option value="null">--E.P.S.--</option>
		                                  </select>
		                                  <div class="input-group-addon add">
		                                      <span id="new_eps_icon" class="fa fa-plus cursor" onclick="addEps()"></span>
		                                  </div>
		                                </div>
		                                <div id="msg_error_eps" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
		                              </div>
		                              <div class="col-xs-12 col-sm-6 col-md-6 margen">
		                                <label for="new_fecha_radicacion_eps">Fecha de Radicación:</label>
		                                <div class="input-group date radEps" >
		                                  <input id="new_fecha_radicacion_eps" name="new_fecha_radicacion_eps" class="form-control fecha" placeholder="DD-MM-AAAA" autocomplete="off">
		                                    <div class="input-group-addon">
		                                        <span id="new_fecha_radicacion_eps_icon" class="fa fa-calendar cursor"></span>
		                                    </div>
		                                </div>
		                                <div id="msg_error_fechaRad_eps" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
		                              </div>   
		                            </div>
		                            <!-- /row -->
		                            <!-- row -->
		                            <div class="row form-group">                       
		                              <div class="col-xs-12 col-sm-6 col-md-6 margen">
		                                <label for="new_tipo_tramite">Tipo Tramite</label>
		                                <div class="input-group">
		                                  <select id="new_tipo_tramite_eps" name="new_tipo_tramite_eps" class="form-control">
		                                    <option value="null">--Tipo Tramite--</option>
		                                  </select>
		                                  <div class="input-group-addon add">
		                                      <span id="new_tipo_tramite_icon" class="fa fa-plus cursor" onclick="addTramite()"></span>
		                                  </div>                              
		                                </div>
		                                <div id="msg_error_tramite_eps" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
		                              </div>
		                              <div class="col-xs-12 col-sm-6 col-md-6 margen">
		                                <label for="new_tipo_afiliacion_eps">Tipo Afiliacion</label>
		                                <div class="input-group">
		                                  <select id="new_tipo_afiliacion_eps" name="new_tipo_afiliacion_eps" class="form-control">
		                                    <option value="null">--Tipo Afiliacion--</option>
		                                  </select>
		                                  <div class="input-group-addon add">
		                                      <span id="new_tipo_afiliacion_icon" class="fa fa-plus cursor" onclick="addAfiliacion()"></span>
		                                  </div>
		                                </div>
		                                <div id="msg_error_afiliacion_eps" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
		                              </div>
		                            </div>
		                            <!-- /row -->
		                            <!-- row -->
		                            <div class="row form-group">
		                              <div class="col-xs-12 col-sm-6 col-md-6 margen">
		                                <label for="new_tipo_afiliado_eps">Tipo Afiliado</label>
		                                <div class="input-group">
		                                  <select id="new_tipo_afiliado_eps" name="new_tipo_afiliado_eps" class="form-control">
		                                    <option value="null">--Tipo Afiliado--</option>
		                                  </select>
		                                  <div class="input-group-addon add">
		                                      <span id="new_tipo_afiliado_icon" class="fa fa-plus cursor" onclick="addAfiliado()"></span>
		                                  </div>
		                                </div>
		                                <div id="msg_error_afiliado_eps" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
		                              </div>
		                              <div class="col-xs-12 col-sm-6 col-md-6 margen">
		                                <label for="new_tipo_cotizante_eps">Tipo Cotizante</label>
		                                <div class="input-group">
		                                  <select id="new_tipo_cotizante_eps" name="new_tipo_cotizante_eps" class="form-control">
		                                    <option value="null">--Tipo Cotizante--</option>
		                                  </select>
		                                  <div class="input-group-addon add">
		                                      <span id="nnew_tipo_cotizante_icon" class="fa fa-plus cursor" onclick="addCotizante()"></span>
		                                  </div>
		                                </div>
		                                <div id="msg_error_cotizante_eps" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
		                              </div>
		                            </div>
		                            <!-- /row -->
		                            <!-- row -->
		                            <div class="row form-group">
		                              <div class="col-xs-12 col-sm-6 col-md-6 margen">
		                                <label for="new_regimen_eps">Regimen</label>
		                                <div class="input-group">
		                                  <select id="new_regimen_eps" name="new_regimen_eps" class="form-control">
		                                    <option value="null">--Regimen--</option>
		                                    <option value="c">--C--</option>
		                                    <option value="s">--S--</option>
		                                  </select>
		                                  <div class="input-group-addon add">
		                                      <span id="nnew_tipo_cotizante_icon" class="fa fa-plus cursor" onclick="addCotizante()"></span>
		                                  </div>
		                                </div>
		                                <div id="msg_error_regimen_eps" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
		                              </div>
		                              <div class="col-xs-12 col-sm-6 col-md-6 margen">
		                              	  <div class="col-md-12 ">
		                              	  	<label for="new_convivencia_eps">Declaraci&oacute;n Convivencia:</label>
		                              	  	<div class="input-group">
				                                <div class="has-success" id="si" style="float:left; margin-right:40px;">
				                                  <div class="checkbox ">
				                                    <label><input type="checkbox" class="si" value="1">SI</label>
				                                  </div>
				                                </div>
				                                <div class="has-warning" id="no" style="float:left; margin-right:40px;">
				                                  <div class="checkbox">
				                                    <label><input type="checkbox" class="no" value="0">NO</label>
				                                  </div>
				                                </div>
				                            </div>
			                              </div>
		                              </div>
		                            </div>
		                            <!-- /row -->
                          		</div>
                          		<div class="col-md-6" id="convivencia" style="display: none;">
		                           <!-- row -->
		                            <div class="row form-group">
		                              <div class="col-md-12 margen"><h2>Datos Conyugue</h2></div>
		                            </div>
		                            <!-- /row -->
		                            <!-- row -->
		                            <div class="row form-group">
		                              <div class="col-xs-12 col-sm-6 col-md-6 margen">
		                                <label for="new_convivencia_nombre">Nombre:</label>
		                                <input type="text" id="new_convivencia_nombre" name="new_convivencia_nombre" class="form-control" placeholder="Primer Nombre">
		                                <div id="msg_error_convivencia_nombre" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
		                              </div>
		                              <div class="col-xs-12 col-sm-6 col-md-6 margen">
		                                <label for="new_convivencia_apellido">Apellido:</label>
		                                <input type="text" id="new_convivencia_apellido" name="new_convivencia_apellido" class="form-control" placeholder="Primer Apellido">
		                                <div id="msg_error_convivencia_apellido" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
		                              </div>
		                            </div>
		                            <!-- /row -->
                          		</div>
                          	</div>

                            
                            <!-- boton guardar  -->
                            <div class="row form-group text-center">
                              <button  type="button" class="btn btn-primary btn-lg btn_guardar_nuevo" data-loading-text="<i class='fa fa-spinner fa-pulse fa-fw'></i> Guardando..." onclick="guardarEps()">Siguiente</button>
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
                <!-- /.col -->
            </div>
            <div class="tab-pane fade  in" id="datosArl">
                <div class="col">
                  <div class="panel panel-primary">
                    <div class="panel-heading">
                      Nombre: <span id="new_nombreArl">$nombre</span> <span id="new_apellidoArl">$apellido</span> /  Documento: <span id="new_documentoArl">$documento</span> : Agregar ARL
                    </div>
                    <div class="panel-body">
                      <div class="row">
                        <div class="col-lg-12">
                          <form id="form_nuevo" role="form">
                            <!-- row -->
                            <div class="row form-group">
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 ">
                                <label for="new_arl">A.R.L:</label>
                                <div class="input-group">
                                  <select id="new_arl" name="new_arl" class="form-control">
                                    <option value="null">--A.R.L.--</option>
                                  </select>
                                  <div class="input-group-addon add">
                                      <span id="new_arl_icon" class="fa fa-plus cursor" onclick="addArl()"></span>
                                  </div>
                                </div>
                                <div id="msg_error_arl" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 margen">
                                <label for="new_fecha_afiliacion_arl">Fecha de Afiliación:</label>
                                <div class="input-group date radArl" >
                                  <input id="new_fecha_afiliacion_arl" name="new_fecha_afiliacion_arl" class="form-control fecha" placeholder="DD-MM-AAAA" autocomplete="off">
                                    <div class="input-group-addon">
                                        <span id="new_fecha_afiliacion_arl_icon" class="fa fa-calendar cursor"></span>
                                    </div>
                                </div>
                                <div id="msg_error_fechaAfi_arl" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>   
                            </div>
                            <!-- /row -->
                            <!-- row -->
                            <div class="row form-group">                       
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 ">
                                <label for="new_tipo_afiliacion_arl">Codigo Transacción</label>
                                <input id="new_codigo_transaccion_arl" name="new_tipo_afiliacion_arl" class="form-control fecha" placeholder="Codigo Transacción" autocomplete="off">
                                
                                <div id="msg_error_codigo_transaccion_arl" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                            </div>
                            <!-- /row -->

                            <!-- boton guardar  -->
                            <div class="row form-group text-center">
                              <button  type="button" class="btn btn-primary btn-lg btn_guardar_nuevo" data-loading-text="<i class='fa fa-spinner fa-pulse fa-fw'></i> Guardando..." onclick="guardarArl()">Siguiente</button>
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
                <!-- /.col -->
            </div>
            <div class="tab-pane fade  in" id="datosPension">
                <div class="col">
                  <div class="panel panel-primary">
                    <div class="panel-heading">
                      Nombre: <span id="new_nombrePension">$nombre</span> <span id="new_apellidoPension">$apellido</span> /  Documento: <span id="new_documentoPension">$documento</span> : Agregar Pensión
                    </div>
                    <div class="panel-body">
                      <div class="row">
                        <div class="col-lg-12">
                          <form id="form_nuevo" role="form">
                            <!-- row -->
                            <div class="row form-group">
                              <div class="col-md-12 ">
                                <div class="has-success" id="afiliado">
                                  <div class="checkbox ">
                                    <label><input type="checkbox" class="afiliado" value="afiliado">Afiliado</label>
                                  </div>
                                </div>
                                <div class="has-warning" id="noAfiliado">
                                  <div class="checkbox">
                                    <label><input type="checkbox" class="noAfiliado" value="noAfiliado">No Afiliado</label>
                                  </div>
                                </div>
                              </div>

                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 " id="nFondo">
                                <label for="new_arl">Fondo Pensión:</label>
                                <div class="input-group">
                                  <select id="new_pension" name="new_arl" class="form-control">
                                    <option value="null">--PENSION--</option>
                                  </select>
                                  <div class="input-group-addon add">
                                      <span id="new_pension_icon" class="fa fa-plus cursor" onclick="addPension()"></span>
                                  </div>
                                </div>
                                <div id="msg_error_pension" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 margen " id="fechaAfi">
                                <label for="new_fecha_afiliacion_pension">Fecha de Afiliación:</label>
                                <div class="input-group date radPension" >
                                  <input id="new_fecha_afiliacion_pension" name="new_fecha_afiliacion_arl" class="form-control fecha" placeholder="DD-MM-AAAA" autocomplete="off">
                                    <div class="input-group-addon">
                                        <span id="new_fecha_afiliacion_pension_icon" class="fa fa-calendar cursor"></span>
                                    </div>
                                </div>
                                <div id="msg_error_fechaAfi_pension" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>

                            </div>
                            <!-- /row -->

                            <!-- boton guardar  -->
                            <div class="row form-group text-center">
                              <button  type="button" class="btn btn-primary btn-lg btn_guardar_nuevo" data-loading-text="<i class='fa fa-spinner fa-pulse fa-fw'></i> Guardando..." onclick="guardarPension()">Siguiente</button>
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
                <!-- /.col -->
            </div>
            <div class="tab-pane fade  in" id="datosCaja">
                <div class="col">
                  <div class="panel panel-primary">
                    <div class="panel-heading">
                      Nombre: <span id="new_nombreCaja">$nombre</span> <span id="new_apellidoCaja">$apellido</span> /  Documento: <span id="new_documentoCaja">$documento</span> : Agregar Caja Compensación
                    </div>
                    <div class="panel-body">
                      <div class="row">
                        <div class="col-lg-12">
                          <form id="form_nuevo" role="form">
                          	
                          		<!-- row -->
	                            <div class="row form-group">
	                            	<div class="col-md-4">
		                              <div class="col-md-12 margen ">
		                                <label for="new_caja">Caja Compensación:</label>
		                                <div class="input-group">
		                                  <select id="new_caja" name="new_caja" class="form-control">
		                                    <option value="null">--Caja Compensación--</option>
		                                  </select>
		                                  <div class="input-group-addon add">
		                                      <span id="new_caja_icon" class="fa fa-plus cursor" onclick="addCaja()"></span>
		                                  </div>
		                                </div>
		                                <div id="msg_error_caja" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
		                              </div>
		                            </div>
		                            <div class="col-md-8" id="beneficiarios" class="idBeneficiario" style="display: ;">
			                           <!-- row -->
			                            <div class="row form-group">
			                              <div class="col-md-12 margen"><h2>Datos Beneficiario # <span id="idBeneficiario">$idBeneficiario</span></h2></div>
			                              <div class="col-xs-12 col-sm-6 col-md-4 margen">
			                                <label for="new_beneficiario_documento">Doc. Identidad:</label>
			                                <input type="password" id="new_beneficiario_documento" name="new_beneficiario_documento" class="form-control"  placeholder="Documento de Identidad" autocomplete="off">
			                                <div id="msg_error_documento" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
			                                <div id="msg_validacion" class="alert alert-info" role="alert"><i class="fa fa-refresh fa-spin"></i> Validando Documento</div>
			                                <div id="msg_error_validacion" class="alert alert-danger" role="alert"><i class="fa fa-close" aria-hidden="true"></i> Documento Registrado</div>
			                              </div>
			                              <div class="col-xs-12 col-sm-6 col-md-4 margen">
			                                <label for="new_beneficiario_documento_v">Verifique Doc.:</label>
			                                <input type="text" id="new_beneficiario_documento_v" name="new_beneficiario_documento_v" class="form-control" placeholder="Verifique # Documento" autocomplete="off">
			                                <div id="msg_error_documento_r" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
			                                <div id="msg_validacion_v" class="alert alert-info" role="alert"><i class="fa fa-refresh fa-spin"></i> Verificando Documento</div>
			                                <div id="msg_ok_documento_v" class="alert alert-success" role="alert"><i class="fa fa-check" aria-hidden="true"></i> El Documento Coincide</div>
			                                <div id="msg_error_documento_v" class="alert alert-danger" role="alert"><i class="fa fa-close" aria-hidden="true"></i> El Documento No Coincide</div>
			                              </div>
			                              <div class="col-xs-12 col-sm-6 col-md-4  margen">
			                                <label for="new_beneficiario_tipo">Tipo de Doc.</label>
			                                <div class="input-group">
			                                  <select id="new_beneficiario_tipo" name="new_beneficiario_tipo" class="form-control">
			                                    <option value="null">--Tipo Documento--</option>
			                                  </select>
			                                  <div class="input-group-addon add">
			                                      <span id="new_beneficiario_tipo_icon" class="fa fa-plus cursor" onclick="addTipo()"></span>
			                                  </div>
			                                </div>  
			                                <div id="msg_error_tipo" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
			                              </div>
			                            </div>
			                            <!-- /row -->
			                            <!-- row -->
			                            <div class="row form-group">			                              
			                              <div class="col-xs-12 col-sm-6 col-md-4 margen">
			                                <label for="new_beneficiario_nombre">Nombre:</label>
			                                <input type="text" id="new_beneficiario_nombre" name="new_beneficiario_nombre" class="form-control" placeholder="Primer Nombre">
			                                <div id="msg_error_nombre" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
			                              </div>
			                              <div class="col-xs-12 col-sm-6 col-md-4 margen">
			                                <label for="new_beneficiario_apellido">Apellido:</label>
			                                <input type="text" id="new_beneficiario_apellido" name="new_beneficiario_apellido" class="form-control" placeholder="Primer Apellido">
			                                <div id="msg_error_apellido" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
			                              </div>

			                              <div class="col-xs-12 col-sm-6 col-md-4 margen">
			                                <label for="new_beneficiario_fechaNac">Fecha Nac.:</label>
			                                <div class="input-group date nac">
			                                  <input id="new_beneficiario_fechaNac" name="new_beneficiario_fechaNac" class="form-control fecha" placeholder="DD-MM-AAAA" autocomplete="off">
			                                    <div class="input-group-addon">
			                                        <span id="new_beneficiario_fechaNac_icon" class="fa fa-calendar cursor"></span>
			                                    </div>
			                                </div>
			                                <div id="msg_error_fechaExp" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
			                                <div id="msg_validacion_fechaNac" class="alert alert-info" role="alert"><i class="fa fa-refresh fa-spin"></i> Verificando Fecha</div>
			                                <div id="msg_ok_fechaNac" class="alert alert-success" role="alert"><i class="fa fa-check" aria-hidden="true"></i> Fecha Valida</div>
			                                <div id="msg_error_fechaNac_v" class="alert alert-danger" role="alert"><i class="fa fa-close" aria-hidden="true"></i> Fecha Invalida</div>
			                              </div>
			                            </div>
			                            <!-- /row -->
			                            <!-- row -->
			                            <div class="row form-group">
			                              <div class="col-xs-12 col-sm-6 col-md-4 margen">
			                                <label for="new_beneficiario_genero">Genero:</label>
			                                <div class="input-group">
			                                  <select id="new_beneficiario_genero" name="new_beneficiario_genero" class="form-control">
			                                    <option value="null">--Genero--</option>
			                                  </select>
			                                  <div class="input-group-addon add">
			                                      <span id="new_beneficiario_genero_icon" class="fa fa-plus cursor" onclick="addGenero()"></span>
			                                  </div>
			                                </div>
			                                <div id="msg_error_genero" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
			                              </div>

			                              <div class="col-xs-12 col-sm-6 col-md-4 margen">
			                                <label for="new_parentesco">Parentesco:</label>
			                                <div class="input-group">
			                                  <select id="new_parentesco" name="new_parentesco" class="form-control">
			                                    <option value="null">--Parentesco--</option>
			                                  </select>
			                                  <div class="input-group-addon add">
			                                      <span id="new_parentesco_icon" class="fa fa-plus cursor" onclick="addParentesco()"></span>
			                                  </div>
			                                </div>
			                                <div id="msg_error_etnia" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
			                              </div>
			                              <div class="col-xs-12 col-sm-6 col-md-4 margen">
			                                <label for="new_etnia">Etnia:</label>
			                                <div class="input-group">
			                                  <select id="new_etnia" name="new_etnia" class="form-control">
			                                    <option value="null">--Etnia--</option>
			                                  </select>
			                                  <div class="input-group-addon add">
			                                      <span id="new_etnia_icon" class="fa fa-plus cursor" onclick="addEtnia()"></span>
			                                  </div>
			                                </div>
			                                <div id="msg_error_etnia" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
			                              </div>
			                            </div>
			                            <!-- /row -->
		                      		</div> 
	                            </div>
	                            <!-- /row -->
	                            <!-- boton guardar  -->
	                            <div class="row form-group text-center">
	                              <button  type="button" class="btn btn-primary btn-lg btn_guardar_nuevo" data-loading-text="<i class='fa fa-spinner fa-pulse fa-fw'></i> Guardando..." onclick="guardarCaja()">Siguiente</button>
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
                <!-- /.col -->
            </div>
            <div class="tab-pane fade  in" id="datosReferencias">
                <div class="col">
                  <div class="panel panel-primary">
                    <div class="panel-heading">
                      Nombre: <span id="new_nombreRef">$nombre</span> <span id="new_apellidoRef">$apellido</span> /  Documento: <span id="new_documentoRef">$documento</span>
                    </div>
                    <div class="panel-body">
          						<div class="panel panel-default">
                          <div class="panel-heading">
                              <strong>Referencia # 1</strong>
                          </div>
                          <div class="panel-body">
                              <div class="row">
                              <div class="col-lg-12">
                                <form id="form_nuevo" role="form">
                                  <!-- row -->
                                  <div class="row form-group">
                                    <div class="col-xs-12 col-sm-6 col-md-3 margen">
                                      <label for="new_nombre_ref1">Nombre:</label>
                                      <input type="text" id="new_nombre_ref1" name="new_nombre_ref1" class="form-control" placeholder="Nombre">
                                      <div id="msg_error_nombre_ref1" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-3 margen">
                                      <label for="new_apellido_ref1">Apellido:</label>
                                      <input type="text" id="new_apellido_ref1" name="new_apellido_ref1" class="form-control" placeholder="Apellido">
                                      <div id="msg_error_apellido_ref1" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-3 margen">
                                      <label for="new_parentesco">Parentesco:</label>
                                      <div class="input-group">
                                        <select id="new_parentesco_ref1" name="new_parentesco" class="form-control">
                                          <option value="null">--Parentesco--</option>
                                        </select>
                                        <div class="input-group-addon add">
                                            <span id="new_estrato_icon" class="fa fa-plus cursor" onclick="addParentezco()"></span>
                                        </div>
                                      </div>
                                      <div id="msg_error_parentesco_ref1" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-3 margen">
                                      <label for="new_telefono_ref1">Teléfono:</label>
                                      <input type="text" id="new_telefono_ref1" name="new_telefono_ref1" class="form-control" placeholder="Teléfono">
                                      <div id="msg_error_telefono_ref1" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                                    </div>
                                  </div>
                                  <!-- /row -->
                                </form>
                              </div>
                              <!-- /.col-lg-12 (nested) -->
                            </div>
                            <!-- /.row (nested) -->
                          </div>
                      </div>
                      <div class="panel panel-default">
                          <div class="panel-heading">
                              <strong>Referencia # 2</strong>
                          </div>
                          <div class="panel-body">
                            <div class="row">
                              <div class="col-lg-12">
                                <form id="form_nuevo" role="form">
                                  <!-- row -->
                                  <div class="row form-group">
                                    <div class="col-xs-12 col-sm-6 col-md-3 margen">
                                      <label for="new_nombre_ref1">Nombre:</label>
                                      <input type="text" id="new_nombre_ref2" name="new_nombre_ref2" class="form-control" placeholder="Nombre">
                                      <div id="msg_error_nombre_ref2" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-3 margen">
                                      <label for="new_apellido_ref2">Apellido:</label>
                                      <input type="text" id="new_apellido_ref2" name="new_apellido_ref2" class="form-control" placeholder="Apellido">
                                      <div id="msg_error_apellido_ref2" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-3 margen">
                                      <label for="new_parentesco">Parentesco:</label>
                                      <div class="input-group">
                                        <select id="new_parentesco_ref2" name="new_parentesco" class="form-control">
                                          <option value="null">--Parentesco--</option>
                                        </select>
                                        <div class="input-group-addon add">
                                            <span id="new_estrato_icon" class="fa fa-plus cursor" onclick="addParentezco()"></span>
                                        </div>
                                      </div>
                                      <div id="msg_error_parentesco_ref2" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-3 margen">
                                      <label for="new_telefono_ref2">Teléfono:</label>
                                      <input type="text" id="new_telefono_ref2" name="new_telefono_ref2" class="form-control" placeholder="Teléfono">
                                      <div id="msg_error_telefono_ref2" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                                    </div>
                                  </div>
                                  <!-- /row -->
                                </form>
                              </div>
                              <!-- /.col-lg-12 (nested) -->
                            </div>
                            <!-- /.row (nested) -->
                          </div>
                      </div>
                      <form>
                        <!-- boton guardar  -->
                        <div class="row form-group text-center">
                          <button  type="button" class="btn btn-primary btn-lg btn_guardar_nuevo" data-loading-text="<i class='fa fa-spinner fa-pulse fa-fw'></i> Guardando..." onclick="guardarReferencia()">Siguiente</button>
                        </div>
                      </form>
                    </div>
                      <!-- /.panel-body -->
                  </div>
                  <!-- /.panel -->
                </div>
                <!-- /.col -->
            </div>
            <div class="tab-pane fade  in" id="datosEmpresa">
                <div class="col">
                  <div class="panel panel-primary">
                    <div class="panel-heading">
                      Nombre: <span id="new_nombreEmpresa">$nombre</span> <span id="new_apellidoEmpresa">$apellido</span> /  Documento: <span id="new_documentoEmpresa">$documento</span>
                    </div>
                    <div class="panel-body">
                      <div class="row">
                        <div class="col-lg-12">
                          <form id="form_nuevo" role="form">
                            <!-- row -->
                            <div class="row form-group ">
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 margen">
                                <label for="new_empresa">Empresa Contratante:</label>
                                <div class="input-group">
                                  <select id="new_empresa" name="new_empresa" class="form-control">
                                    <option value="null">--Empresa--</option>
                                  </select>
                                  <div class="input-group-addon add">
                                      <span id="new_empresa_icon" class="fa fa-plus cursor" onclick="addEmpresa()"></span>
                                  </div>
                                </div>
                                <div id="msg_error_empresa" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 margen">
                                <label for="new_cargo">Cargo:</label>
                                <input type="text" id="new_cargo" name="new_cargo" class="form-control" placeholder="Cargo">
                                <div id="msg_error_cargo" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>   
                            </div>
                            <!-- /row -->
                            <!-- row -->
                            <div class="row form-group ">                     
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 margen">
                                <label for="new_salario">Salario:</label>
                                <input type="text" id="new_salario" name="new_salario" class="form-control" placeholder="Salario">
                                <div id="msg_error_salario" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 margen">
                                <label for="new_jornada">Jornada:</label>
                                <input type="text" id="new_jornada" name="new_jornada" class="form-control" placeholder="Jornada">
                                <div id="msg_error_jornada" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                            </div>
                            <!-- /row -->
                            <!-- row -->
                            <div class="row form-group">
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 margen">
                                <label for="new_servicio_funerario">Servicio Funerario</label>
                                <div class="input-group">
                                  <select id="new_servicio_funerario" name="new_servicio_funerario" class="form-control">
                                    <option value="null">--Servicio Funerario--</option>
                                    <option value="1"> Si </option>
                                    <option value="0"> No </option>
                                  </select>
                                   <div class="input-group-addon add">
                                      <span id="new_empresa_icon" class="fa fa-plus cursor" onclick="addEmpresa()"></span>
                                  </div>
                                </div>
                                <div id="msg_error_servicio_funerario" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 margen">
                                <label for="new_banco">Banco Pago Nomina</label>
                                <div class="input-group">
                                  <select id="new_banco" name="new_banco" class="form-control">
                                    <option value="null">--Banco--</option>
                                  </select>
                                  <div class="input-group-addon add">
                                      <span id="new_banco_icon" class="fa fa-plus cursor" onclick="addBanco()"></span>
                                  </div>
                                </div>
                                <div id="msg_error_banco" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                            </div>
                            <!-- /row -->
                            <!-- row -->
                            <div class="row form-group">
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 margen">
                                <label for="new_cuenta">Cuenta #:</label>
                                <input type="text" id="new_cuenta" name="new_cuenta" class="form-control" placeholder="Cuenta #">
                                <div id="msg_error_cuenta" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 margen">
                                <label for="new_tipo_cuenta">Tipo de Cuenta</label>
                                <div class="input-group">
                                  <select id="new_tipo_cuenta" name="new_tipo_cuenta" class="form-control">
                                    <option value="null">--Tipo de Cuenta--</option>
                                  </select>
                                  <div class="input-group-addon add">
                                      <span id="new_tipo_cuenta_icon" class="fa fa-plus cursor" onclick="addTipoCuenta()"></span>
                                  </div>
                                </div>
                                <div id="msg_error_tipo_cuenta" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                            </div>
                            <!-- /row -->
                            <!-- boton guardar  -->
                            <div class="row form-group text-center">
                              <button  type="button" class="btn btn-primary btn-lg btn_guardar_nuevo" data-loading-text="<i class='fa fa-spinner fa-pulse fa-fw'></i> Guardando..." onclick="guardarEmpresa()">Siguiente</button>
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
                <!-- /.col -->
            </div>           
          </div>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- / Modal Nuevo empleado -->
  <!-- Modal Editar empleado -->
  <div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"> <i class="fa fa-users fa-fw"></i>Editar Datos del Empleado</h4>
        </div>
        <div class="modal-body" id="">
          <!-- Nav tabs -->
          <ul class="nav nav-tabs" id="mytabsEdit">
              <li class="active">
                  <a href="#datosBasicosEdit" data-toggle="tab" aria-expanded="true">Editar Datos Basicos</a>
              </li>
              <li class="">
                  <a href="#datosEpsEdit" data-toggle="tab">Editar E.P.S.</a>
              </li>
              <li class="">
                  <a href="#datosArlEdit" data-toggle="tab">Editar A.R.L</a>
              </li>
              <li class="">
                  <a href="#datosPensionEdit" data-toggle="tab">Editar Fondo Pensión</a>
              </li>
              <li class="">
                  <a href="#datosCajaEdit" data-toggle="tab">Editar Caja Compensación</a>
              </li>
              <li class="">
                  <a href="#referenciasEdit" data-toggle="tab">Editar Referencias Personales</a>
              </li>
              <li class="">
                  <a href="#datosContratoEdit" data-toggle="tab">Editar Contrato Trabajo</a>
              </li>
          </ul>
          <!-- Tab panes -->
          <div class="tab-content">
            <div class="tab-pane fade active in" id="datosBasicosEdit">
                <div class="col">
                  <div class="panel panel-primary">
                    <div class="panel-heading">
                      Nombre: <span id="edit_nombreEmpleado">$nombre</span> <span id="edit_apellidoEmpleado">$apellido</span> /  Documento: <span id="edit_documentoEmpleado">$documento</span>
                    </div>
                    <div class="panel-body">
                      <div class="row">
                        <div class="col-lg-12">
                          <form id="form_editar" role="form">
                            <input type="hidden" id="edit_id_empleado" name="edit_id_empleado">
                            <!-- row -->
                            <div class="row form-group">
                              <div class="col-xs-12 col-sm-6 col-md-4 margen">
                                <label for="edit_foto">Foto:</label>
                                <center><div id="edit_foto"></div></center>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 margen">
                                <label for="edit_documento">Doc. Identidad:</label>
                                <input type="text" id="edit_documento" name="edit_documento" class="form-control"  placeholder="Documento de Identidad" readonly>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 margen">
                                <label for="edit_tipo">Tipo de Doc.</label>
                                <div class="input-group">
                                  <select id="edit_tipo" name="edit_tipo" class="form-control">
                                    <option value="null" >--Tipo Documento--</option>
                                  </select>
                                  <div class="input-group-addon add">
                                      <span id="edit_tipo_icon" class="fa fa-plus cursor" onclick="addTipo()"></span>
                                  </div>
                                </div>  
                                <div id="msg_error_tipo" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 margen">
                                <label for="edit_fechaExp">Fecha de Exp.:</label>
                                <div class="input-group date exp" >
                                  <input id="edit_fechaExp" name="edit_fechaExp" class="form-control fecha" placeholder="DD-MM-AAAA" autocomplete="off">
                                    <div class="input-group-addon">
                                        <span id="edit_fechaExp_icon" class="fa fa-calendar cursor"></span>
                                    </div>
                                </div>
                                <div id="msg_error_fechaExp" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                                <div id="msg_validacion_fechaExp" class="alert alert-info" role="alert"><i class="fa fa-refresh fa-spin"></i> Verificando Fecha</div>
                                <div id="msg_ok_fechaExp" class="alert alert-success" role="alert"><i class="fa fa-check" aria-hidden="true"></i> Fecha Valida</div>
                                <div id="msg_error_fechaExp_v" class="alert alert-danger" role="alert"><i class="fa fa-close" aria-hidden="true"></i> Fecha Invalida</div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 margen ">
                                <label for="edit_ciudadExp">Ciudad de Exp.:</label>
                                <div class="input-group">
                                  <select id="edit_ciudadExp" name="edit_ciudadExp" class="form-control">
                                    <option value="null">--Ciudad Expedici&oacute;n--</option>
                                  </select>
                                  <div class="input-group-addon add">
                                      <span id="edit_ciudad_icon" class="fa fa-plus cursor" onclick="addCiudad()"></span>
                                  </div>
                                </div>
                                <div id="msg_error_ciudadExp" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>

                              <div class="col-xs-12 col-sm-6 col-md-4 margen">
                                <label for="edit_nombre">Primer Nombre:</label>
                                <input type="text" id="edit_nombre" name="edit_nombre" class="form-control" placeholder="Primer Nombre">
                                <div id="msg_error_nombre" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-4 margen">
                                <label for="edit_nombre2">Segundo Nombre:</label>
                                <input type="text" id="edit_nombre2" name="edit_nombre2" class="form-control" placeholder="Segundo Nombre">
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-4 margen">
                                <label for="edit_apellido">Primer Apellido:</label>
                                <input type="text" id="edit_apellido" name="edit_apellido" class="form-control" placeholder="Primer Apellido">
                                <div id="msg_error_apellido" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-4 ">
                                <label for="edit_apellido2">Segundo Apellido:</label>
                                <input type="text" id="edit_apellido2" name="edit_apellido2" class="form-control" placeholder="Segundo Apellido">
                              </div>
                            </div>
                            <!-- /row -->
                            <!-- row -->                   
                            <div class="row form-group">
                              <div class="col-xs-12 col-sm-6 col-md-3 margen">
                                <label for="edit_fechaNac">Fecha Nac.:</label>
                                <div class="input-group date nac">
                                  <input id="edit_fechaNac" name="edit_fechaNac" class="form-control fecha" placeholder="DD-MM-AAAA" autocomplete="off">
                                    <div class="input-group-addon">
                                        <span id="edit_fechaNac_icon" class="fa fa-calendar cursor"></span>
                                    </div>
                                </div>
                                <div id="msg_error_fechaExp" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                                <div id="msg_validacion_fechaNac" class="alert alert-info" role="alert"><i class="fa fa-refresh fa-spin"></i> Verificando Fecha</div>
                                <div id="msg_ok_fechaNac" class="alert alert-success" role="alert"><i class="fa fa-check" aria-hidden="true"></i> Fecha Valida</div>
                                <div id="msg_error_fechaNac_v" class="alert alert-danger" role="alert"><i class="fa fa-close" aria-hidden="true"></i> Fecha Invalida</div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-3 margen">
                                <label for="edit_ciudadNac">Ciudad de Nac.:</label>
                                <div class="input-group">
                                  <select id="edit_ciudadNac" name="edit_ciudadNac" class="form-control">
                                    <option value="null">--Ciudad Nac.--</option>
                                  </select>
                                  <div class="input-group-addon add">
                                      <span id="edit_ciudad_icon" class="fa fa-plus cursor" onclick="addCiudad()"></span>
                                  </div>
                                </div>
                                <div id="msg_error_ciudadNac" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-3 margen">
                                <label for="edit_paisNac">Pais de Nacimiento:</label>
                                <div class="input-group">
                                  <select id="edit_paisNac" name="edit_paisNac" class="form-control">
                                    <option value="null">--Pais Nacimiento--</option>
                                  </select>
                                  <div class="input-group-addon add">
                                      <span id="edit_pais_icon" class="fa fa-plus cursor" onclick="addPais()"></span>
                                  </div>
                                </div>
                                <div id="msg_error_paisNac" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-3 ">
                                <label for="edit_genero">Genero:</label>
                                <div class="input-group">
                                  <select id="edit_genero" name="edit_genero" class="form-control">
                                    <option value="null">--Genero--</option>
                                  </select>
                                  <div class="input-group-addon add">
                                      <span id="edit_genero_icon" class="fa fa-plus cursor" onclick="addGenero()"></span>
                                  </div>
                                </div>
                                <div id="msg_error_genero" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                            </div>
                            <!-- /row -->
                            <!-- row -->
                            <div class="row form-group">
                              <div class="col-xs-12 col-sm-6 col-md-3 ">
                                <label for="edit_estado">Estado Civil:</label>
                                <div class="input-group">
                                  <select id="edit_estado" name="edit_estado" class="form-control">
                                    <option value="null">--Estado Civil--</option>
                                  </select>
                                  <div class="input-group-addon add">
                                      <span id="edit_estado_icon" class="fa fa-plus cursor" onclick="addEstado()"></span>
                                  </div>
                                </div>
                                <div id="msg_error_estado" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-3 ">
                                <label for="edit_etnia">Etnia:</label>
                                <div class="input-group">
                                  <select id="edit_etnia" name="edit_etnia" class="form-control">
                                    <option value="null">--Etnia--</option>
                                  </select>
                                  <div class="input-group-addon add">
                                      <span id="edit_etnia_icon" class="fa fa-plus cursor" onclick="addEtnia()"></span>
                                  </div>
                                </div>
                                <div id="msg_error_etnia" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-3 ">
                                <label for="edit_nivel">Nivel de Estudios:</label>
                                <div class="input-group">
                                  <select id="edit_nivel" name="edit_nivel" class="form-control">
                                    <option value="null">--Nivel Estudios--</option>
                                  </select>
                                  <div class="input-group-addon add">
                                      <span id="edit_nivel_icon" class="fa fa-plus cursor" onclick="addNivel()"></span>
                                  </div>
                                </div>
                                <div id="msg_error_nivel" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-3 ">
                                <label for="edit_titulo">Titulo Universitario:</label>
                                <input id="edit_titulo" name="edit_titulo" class="form-control" placeholder="Titulo Univesitario">
                              </div>
                            </div>
                            <!-- /row -->
                            <!-- row -->                   
                            <div class="row form-group">
                              <div class="col-xs-12 col-sm-6 col-md-3 ">
                                <label for="edit_direccion">Direcci&oacute;n:</label>
                                <input id="edit_direccion" name="edit_direccion" class="form-control" placeholder="Direcci&oacute;n">
                                <div id="msg_error_direccion" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-3 ">
                                <label for="edit_barrio">Barrio:</label>
                                <input id="edit_barrio" name="edit_barrio" class="form-control" placeholder="Barrio">
                                <div id="msg_error_barrio" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-3 ">
                                <label for="edit_estrato">Estrato:</label>
                                <div class="input-group">
                                  <select id="edit_estrato" name="edit_estrato" class="form-control">
                                    <option value="null">--Estrato--</option>
                                  </select>
                                  <div class="input-group-addon add">
                                      <span id="edit_estrato_icon" class="fa fa-plus cursor" onclick="addEstrato()"></span>
                                  </div>
                                </div>
                                <div id="msg_error_estrato" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-3 ">
                                <label for="edit_ciudad">Ciudad:</label>
                                <div class="input-group">
                                  <select id="edit_ciudad" name="edit_ciudad" class="form-control">
                                    <option value="null">--Ciudad--</option>
                                  </select>
                                  <div class="input-group-addon add">
                                      <span id="edit_ciudad_icon" class="fa fa-plus cursor" onclick="addCiudad()"></span>
                                  </div>
                                </div>
                                <div id="msg_error_ciudad" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                            </div>
                            <!-- /row -->
                            <!-- row -->
                            <div class="row form-group">
                              <div class="ccol-xs-12 col-sm-6 col-md-3 ">
                                <label for="edit_telefono">Teléfono:</label>
                                <input id="edit_telefono" name="edit_telefono" class="form-control" placeholder="Teléfono">
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-3 ">
                                <label for="edit_celular">Celular:</label>
                                <input id="edit_celular" name="edit_celular" class="form-control" placeholder="Celular">
                                <div id="msg_error_celular" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                              <div class="ccol-xs-12 col-sm-6 col-md-3 ">
                                <label for="edit_email">E-Mail:</label>
                                <input id="edit_email" name="edit_email" class="form-control" placeholder="E-Mail">
                                <div id="msg_error_email" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-3 ">
                                <label for="edit_comentario">Comentarios:</label>
                                <textarea id="edit_comentario" name="edit_comentario" class="form-control" placeholder="Comentarios"></textarea>
                              </div>
                            </div>
                            <!-- /row -->
                            <!-- boton guardar  -->
                            <div class="row form-group text-center">
                            <!-- <button id="btn_guardar_nuevo" type="button" onclick="guardarNuevo()"  class="btn btn-primary btn-lg" data-loading-text="<i class='fa fa-spinner fa-pulse fa-fw'></i> Guardando...">Siguiente</button>  -->
                            <button  type="button" id="btn_guardar_editar" class="btn btn-primary btn-lg " data-loading-text="<i class='fa fa-spinner fa-pulse fa-fw'></i> Guardando..." onclick="guardarEdicion()">Guardar</button>
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
            </div>
            <div class="tab-pane fade  in" id="datosEpsEdit">
                <div class="col">
                  <div class="panel panel-primary">
                    <div class="panel-heading">
                      Nombre: <span id="edit_NombreEps">$nombre</span> <span id="edit_ApellidoEps">$apellido</span> /  Documento:<span id="edit_DocumentoEps">$documento</span>
                    </div>
                    <div class="panel-body">
                      <div class="row">
                        <div class="col-lg-12">
                          <form id="eps" role="form">
                            <input type="hidden" class="edit_id_empleado_eps" name="edit_id_empleado_eps">
                            <!-- row -->
                            <div class="row form-group">
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 ">
                                <label for="edit_eps">E.P.S:</label>
                                <div class="input-group">
                                  <select id="edit_eps" name="edit_eps" class="form-control">
                                    <option value="null">--E.P.S.--</option>
                                  </select>
                                  <div class="input-group-addon add">
                                      <span id="edit_eps_icon" class="fa fa-plus cursor" onclick="addEps()"></span>
                                  </div>
                                </div>
                                <div id="msg_error_eps" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 margen">
                                <label for="edit_fecha_radicacion_eps">Fecha de Radicación:</label>
                                <div class="input-group date radEps" >
                                  <input id="edit_fecha_radicacion_eps" name="edit_fecha_radicacion_eps" class="form-control fecha" placeholder="DD-MM-AAAA" autocomplete="off">
                                    <div class="input-group-addon">
                                        <span id="edit_fecha_radicacion_eps_icon" class="fa fa-calendar cursor"></span>
                                    </div>
                                </div>
                                <div id="msg_error_fechaRad_eps" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>   
                            </div>
                            <!-- /row -->
                            <!-- row -->
                            <div class="row form-group">                       
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 ">
                                <label for="edit_tipo_tramite">Tipo Tramite</label>
                                <div class="input-group">
                                  <select id="edit_tipo_tramite_eps" name="edit_tipo_tramite_eps" class="form-control">
                                    <option value="null">--Tipo Tramite--</option>
                                  </select>
                                  <!-- <div class="input-group-addon add">
                                      <span id="edit_tipo_tramite_icon" class="fa fa-plus cursor" onclick="addCiudad()"></span>
                                  </div>  -->                             
                                </div>
                                <div id="msg_error_tramite_eps" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 ">
                                <label for="edit_tipo_afiliacion_eps">Tipo Afiliacion</label>
                                <div class="input-group">
                                  <select id="edit_tipo_afiliacion_eps" name="edit_tipo_afiliacion_eps" class="form-control">
                                    <option value="null">--Tipo Afiliacion--</option>
                                  </select>
                                  <!-- <div class="input-group-addon add">
                                      <span id="edit_tipo_afiliacion_icon" class="fa fa-plus cursor" onclick="addCiudad()"></span>
                                  </div> -->
                                </div>
                                <div id="msg_error_afiliacion_eps" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                            </div>
                            <!-- /row -->
                            <!-- row -->
                            <div class="row form-group">
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 ">
                                <label for="edit_tipo_afiliado_eps">Tipo Afiliado</label>
                                <div class="input-group">
                                  <select id="edit_tipo_afiliado_eps" name="edit_tipo_afiliado_eps" class="form-control">
                                    <option value="null">--Tipo Afiliado--</option>
                                  </select>
                                  <!-- <div class="input-group-addon add">
                                      <span id="edit_tipo_afiliado_icon" class="fa fa-plus cursor" onclick="addCiudad()"></span>
                                  </div> -->
                                </div>
                                <div id="msg_error_afiliado_eps" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 ">
                                <label for="edit_tipo_cotizante_eps">Tipo Cotizante</label>
                                <div class="input-group">
                                  <select id="edit_tipo_cotizante_eps" name="edit_tipo_cotizante_eps" class="form-control">
                                    <option value="null">--Tipo Cotizante--</option>
                                  </select>
                                  <!-- <div class="input-group-addon add">
                                      <span id="nedit_tipo_cotizante_icon" class="fa fa-plus cursor" onclick="addCiudad()"></span>
                                  </div> -->
                                </div>
                                <div id="msg_error_cotizante_eps" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                            </div>
                            <!-- /row -->
                            <!-- row -->
                            <div class="row form-group">
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 ">
                                <label for="edit_regimen_eps">Regimen</label>
                                <div class="input-group">
                                  <select id="edit_regimen_eps" name="edit_regimen_eps" class="form-control">
                                    <option value="null">--Regimen--</option>
                                    <option value="c">--C--</option>
                                    <option value="s">--S--</option>
                                  </select>
                                </div>
                                <div id="msg_error_regimen_eps" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                            </div>
                            <!-- /row -->
                            <!-- boton guardar  -->
                            <div class="row form-group text-center">
                              <button  type="button" id="btn_guardar_editar" class="btn btn-primary btn-lg editarPension" data-loading-text="<i class='fa fa-spinner fa-pulse fa-fw'></i> Guardando..." onclick="guardarEdicionEps()">Guardar</button>
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
                <!-- /.col -->
            </div>
            <div class="tab-pane fade  in" id="datosArlEdit">
                <div class="col">
                  <div class="panel panel-primary">
                    <div class="panel-heading">
                      Nombre: <span id="edit_NombreArl">$nombre</span> <span id="edit_ApellidoArl">Apellido</span> /  Documento:<span id="edit_DocumentoArl">$documento</span>
                    </div>
                    <div class="panel-body">
                      <div class="row">
                        <div class="col-lg-12">
                          <form id="form_editar" role="form">
                            <input type="hidden" class="edit_id_empleado_arl" name="edit_id_empleado_arl">
                            <!-- row -->
                            <div class="row form-group">
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 ">
                                <label for="edit_arl">A.R.L:</label>
                                <div class="input-group">
                                  <select id="edit_arl" name="edit_arl" class="form-control">
                                    <option value="null">--A.R.L.--</option>
                                  </select>
                                  <div class="input-group-addon add">
                                      <span id="edit_arl_icon" class="fa fa-plus cursor" onclick="addArl()"></span>
                                  </div>
                                </div>
                                <div id="msg_error_arl" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 margen">
                                <label for="edit_fecha_afiliacion_arl">Fecha de Afiliación:</label>
                                <div class="input-group date radArl" >
                                  <input id="edit_fecha_afiliacion_arl" name="edit_fecha_afiliacion_arl" class="form-control fecha" placeholder="DD-MM-AAAA" autocomplete="off">
                                    <div class="input-group-addon">
                                        <span id="edit_fecha_afiliacion_arl_icon" class="fa fa-calendar cursor"></span>
                                    </div>
                                </div>
                                <div id="msg_error_fechaAfi_arl" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>   
                            </div>
                            <!-- /row -->
                            <!-- row -->
                            <div class="row form-group">                       
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 ">
                                <label for="edit_tipo_afiliacion_arl">Codigo Transacción</label>
                                <div class="input-group">
                                  <input id="edit_codigo_transaccion_arl" name="edit_tipo_afiliacion_arl" class="form-control fecha" placeholder="Codigo Transacción" autocomplete="off">
                                </div>
                                <div id="msg_error_codigo_transaccion_arl" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                            </div>
                            <!-- /row -->

                            <!-- boton guardar  -->
                            <div class="row form-group text-center">
                              <button  type="button" id="btn_guardar_editar" class="btn btn-primary btn-lg" data-loading-text="<i class='fa fa-spinner fa-pulse fa-fw'></i> Guardando..." onclick="guardarEdicionArl()">Guardar</button>
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
                <!-- /.col -->
            </div>
            <div class="tab-pane fade  in" id="datosPensionEdit">
                <div class="col">
                  <div class="panel panel-primary">
                    <div class="panel-heading">
                      <span id="edit_NombrePension">Nombre</span> <span id="edit_ApellidoPension">Apellido</span> <span id="edit_DocumentoPension">Documento</span>
                    </div>
                    <div class="panel-body">
                      <div class="row">
                        <div class="col-lg-12">
                          <form id="form_editar" role="form">
                            <input type="hidden" class="edit_id_empleado_pension" name="edit_id_empleado_pension">
                            <!-- row -->
                            <div class="row form-group">
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 ">
                                <label for="edit_pension">Fondo Pensión:</label>
                                <div class="input-group">
                                  <select id="edit_pension" name="edit_pension" class="form-control">
                                    <option value="null">--Fondo Pensión--</option>
                                  </select>
                                  <div class="input-group-addon add">
                                      <span id="edit_pension_icon" class="fa fa-plus cursor" onclick="addPension()"></span>
                                  </div>
                                </div>
                                <div id="msg_error_pension" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 margen">
                                <label for="edit_fecha_afiliacion_pension">Fecha de Afiliación:</label>
                                <div class="input-group date radPension" >
                                  <input id="edit_fecha_afiliacion_pension" name="edit_fecha_afiliacion_pension" class="form-control fecha" placeholder="DD-MM-AAAA" autocomplete="off">
                                    <div class="input-group-addon">
                                        <span id="edit_fecha_afiliacion_pension_icon" class="fa fa-calendar cursor"></span>
                                    </div>
                                </div>
                                <div id="msg_error_fechaAfi_pension" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>   
                            </div>
                            <!-- /row -->

                            <!-- boton guardar  -->
                            <div class="row form-group text-center">
                              <button  type="button" id="btn_guardar_editar" class="btn btn-primary btn-lg" data-loading-text="<i class='fa fa-spinner fa-pulse fa-fw'></i> Guardando..." onclick="guardarEdicionPension()">Guardar</button>
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
                <!-- /.col -->
            </div>
            <div class="tab-pane fade  in" id="datosCajaEdit">
                <div class="col">
                  <div class="panel panel-primary">
                    <div class="panel-heading">
                      <span id="edit_NombreCaja">Nombre</span> <span id="edit_ApellidoCaja">Apellido</span> <span id="edit_DocumentoCaja">Documento</span>
                    </div>
                    <div class="panel-body">
                      <div class="row">
                        <div class="col-lg-12">
                          <form id="form_editar" role="form" class="form-caja">
                            <input type="hidden" class="edit_id_empleado_caja" name="edit_id_empleado_caja">
                            <!-- row -->
                            <div class="row form-group">
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 ">
                                <label for="edit_caja">Caja Compensación:</label>
                                <div class="input-group">
                                  <select id="edit_caja" name="edit_caja" class="form-control select-caja">
                                    <option value="null">--Caja Compensación--</option>
                                  </select>
                                  <div class="input-group-addon add">
                                      <span id="edit_caja_icon" class="fa fa-plus cursor" onclick="addCaja()"></span>
                                  </div>
                                </div>
                                <div id="msg_error_caja" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 margen">
                                <!-- <label for="edit_fecha_afiliacion_caja">Fecha de Afiliación:</label>
                                <div class="input-group date radCaja" >
                                  <input id="edit_fecha_afiliacion_caja" name="edit_fecha_afiliacion_caja" class="form-control fecha" placeholder="DD-MM-AAAA" autocomplete="off">
                                    <div class="input-group-addon">
                                        <span id="edit_fecha_afiliacion_caja_icon" class="fa fa-calendar cursor"></span>
                                    </div>
                                </div>
                                <div id="msg_error_fechaAfi_caja" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div> -->
                              </div>   
                            </div>
                            <!-- /row -->

                            <!-- boton guardar  -->
                            <div class="row form-group text-center">
                              <button  type="button" id="btn_guardar_editar" class="btn btn-primary btn-lg btn-caja" data-loading-text="<i class='fa fa-spinner fa-pulse fa-fw'></i> Guardando..." onclick="guardarEdicionCaja()">Guardar</button>
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
                <!-- /.col -->
            </div>
            <div class="tab-pane fade  in" id="referenciasEdit">
                <div class="col">
                  <div class="panel panel-primary">
                    <div class="panel-heading">
                      Nombre: <span id="edit_nombreRef">$nombre</span> <span id="edit_apellidoRef">$apellido</span> /  Documento: <span id="edit_documentoRef">$documento</span><input type="hidden" class="edit_id_empleado_referencias" name="edit_id_empleado_referencias"><input type="hidden" id="contador_referencias" name="contador_referencias">
                    </div>
                    <div class="panel-body">
						<div id="edit_DatosReferencias">
	                    </div>
	                    <form>
                            <!-- boton guardar edicion ref  -->
                            <div class="row form-group text-center" id="editReferencia">
                              <button  type="button" class="btn btn-primary btn-lg btn_guardar_nuevo" data-loading-text="<i class='fa fa-spinner fa-pulse fa-fw'></i> Guardando..." onclick="guardarEdicionReferencias()">Siguiente</button>
                            </div>
                            <!-- boton guardar  -->
                            <div class="row form-group text-center" id="newReferencia">
                              <button  type="button" class="btn btn-primary btn-lg btn_guardar_nuevo" data-loading-text="<i class='fa fa-spinner fa-pulse fa-fw'></i> Guardando..." onclick="guardarReferencia2()">Siguiente</button>
                            </div>
	                    </form>
                    </div>
                      <!-- /.panel-body -->
                  </div>
                  <!-- /.panel -->
                </div>
                <!-- /.col -->
            </div>
            <div class="tab-pane fade  in" id="datosContratoEdit">
                <div class="col">
                  <div class="panel panel-primary">
                    <div class="panel-heading">
                      Nombre: <span id="edit_nombreContrato">$nombre</span> <span id="edit_apellidoContrato">$apellido</span> /  Documento: <span id="edit_documentoContrato">$documento</span>
                    </div>
                    <div class="panel-body">
                      <div class="row">
                        <div class="col-lg-12">
                          <form id="form_editar" role="form">
                            <input type="hidden" class="edit_id_empleado_contrato" name="edit_id_empleado_contrato">
                            <!-- row -->
                            <div class="row form-group ">
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 margen">
                                <label for="edit_empresa">Empresa Contratante:</label>
                                <div class="input-group">
                                  <select id="edit_empresa" name="edit_empresa" class="form-control">
                                    <option value="null">--Empresa--</option>
                                  </select>
                                  <div class="input-group-addon add">
                                      <span id="edit_empresa_icon" class="fa fa-plus cursor" onclick="addContrato()"></span>
                                  </div>
                                </div>
                                <div id="msg_error_empresa" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 margen">
                                <label for="edit_cargo">Cargo:</label>
                                <input type="text" id="edit_cargo" name="edit_cargo" class="form-control" placeholder="Cargo">
                                <div id="msg_error_cargo" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>   
                            </div>
                            <!-- /row -->
                            <!-- row -->
                            <div class="row form-group ">                     
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 margen">
                                <label for="edit_salario">Salario:</label>
                                <input type="text" id="edit_salario" name="edit_salario" class="form-control" placeholder="Salario">
                                <div id="msg_error_salario" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 margen">
                                <label for="edit_jornada">Jornada:</label>
                                <input type="text" id="edit_jornada" name="edit_jornada" class="form-control" placeholder="Jornada">
                                <div id="msg_error_jornada" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                            </div>
                            <!-- /row -->
                            <!-- row -->
                            <div class="row form-group">
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 margen">
                                <label for="edit_servicio_funerario">Servicio Funerario:</label>
                                <div class="input-group">
                                  <select id="edit_servicio_funerario" name="edit_servicio_funerario" class="form-control">
                                    <option value="null">--Servicio Funerario--</option>
                                    <option value="1"> Si </option>
                                    <option value="0"> No </option>
                                  </select>
                                   <div class="input-group-addon add">
                                      <span id="edit_servicio_funerario_icon" class="fa fa-plus cursor" onclick="addContrato()"></span>
                                  </div>
                                </div>
                                <div id="msg_error_servicio_funerario" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 margen">
                                <label for="edit_banco">Banco Pago Nomina:</label>
                                <div class="input-group">
                                  <select id="edit_banco" name="edit_banco" class="form-control">
                                    <option value="null">--Banco--</option>
                                  </select>
                                  <div class="input-group-addon add">
                                      <span id="edit_banco_icon" class="fa fa-plus cursor" onclick="addBanco()"></span>
                                  </div>
                                </div>
                                <div id="msg_error_banco" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                            </div>
                            <!-- /row -->
                            <!-- row -->
                            <div class="row form-group">
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 margen">
                                <label for="edit_cuenta">Cuenta #:</label>
                                <input type="text" id="edit_cuenta" name="edit_cuenta" class="form-control" placeholder="Cuenta #">
                                <div id="msg_error_cuenta" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 margen">
                                <label for="edit_tipo_cuenta">Tipo de Cuenta:</label>
                                <div class="input-group">
                                  <select id="edit_tipo_cuenta" name="edit_tipo_cuenta" class="form-control">
                                    <option value="null">--Tipo de Cuenta--</option>
                                  </select>
                                  <div class="input-group-addon add">
                                      <span id="edit_tipo_cuenta_icon" class="fa fa-plus cursor" onclick="addTipoCuenta()"></span>
                                  </div>
                                </div>
                                <div id="msg_error_tipo_cuenta" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                              </div>
                            </div>
                            <!-- /row -->
                            <!-- boton guardar  -->
                            <div class="row form-group text-center">
                              <button  type="button" class="btn btn-primary btn-lg btn_guardar_editar" data-loading-text="<i class='fa fa-spinner fa-pulse fa-fw'></i> Guardando..." onclick="guardarEdicionContrato()">Siguiente</button>
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
                <!-- /.col -->
            </div>
          </div>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- / Modal Editar empleado -->
  <!-- Modal ver empleado -->
  <div class="modal fade" id="modalVer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"> <i class="fa fa-users fa-fw"></i> Ver Datos del Empleado</h4>
        </div>
        <div class="modal-body" id="">
          <!-- Nav tabs -->
          <ul class="nav nav-tabs" id="mytabsVer">
              <li class="active">
                  <a href="#datosBasicosVer" data-toggle="tab" aria-expanded="true">Datos Basicos</a>
              </li>
              <li class="">
                  <a href="#datosEpsVer" data-toggle="tab">E.P.S.</a>
              </li>
              <li class="">
                  <a href="#datosArlVer" data-toggle="tab">A.R.L</a>
              </li>
              <li class="">
                  <a href="#datosPensionVer" data-toggle="tab">Fondo Pensión</a>
              </li>
              <li class="">
                  <a href="#datosCajaVer" data-toggle="tab">Caja Compensación</a>
              </li>
              <li class="">
                  <a href="#datosReferenciasVer" data-toggle="tab">Ver Referencias Personales</a>
              </li>
              <li class="">
                  <a href="#datosContratoVer" data-toggle="tab">Ver Contrato Empleado</a>
              </li>
          </ul>
          <!-- Tab panes -->
          <div class="tab-content">
            <div class="tab-pane fade active in" id="datosBasicosVer">
                <div class="col">
                  <div class="panel panel-primary">
                    <div class="panel-heading">
                      Nombre: <span id="ver_nombreEmpleado">$nombre</span> <span id="ver_apellidoEmpleado">$apellido</span> /  Documento: <span id="ver_documentoEmpleado">$documento</span>  
                    </div>
                    <div class="panel-body">
                      <div class="row">
                        <div class="col-lg-12">
                          <form id="form_editar" role="form">
                            <input type="hidden" id="ver_id_empleado" name="ver_id_empleado">
                            <!-- row -->
                            <div class="row form-group">
                              <div class="col-xs-12 col-sm-6 col-md-4 margen">
                                <label for="foto">Foto:</label>
                                <center><div id="ver_foto"></div></center>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 margen">
                                <label for="ver_documento">Doc. Identidad:</label>
                                <input type="text" id="ver_documento" name="ver_documento" class="form-control" readonly>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 margen">
                                <label for="ver_tipo">Tipo de Doc.</label>
                                <input type="text" id="ver_tipo" name="ver_tipo" class="form-control" readonly> 
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 margen">
                                <label for="ver_fechaExp">Fecha de Exp.:</label>
                                <input id="ver_fechaExp" name="ver_fechaExp" class="form-control fecha" readonly>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 margen">
                                <label for="ver_ciudadExp">Ciudad de Exp.:</label>
                                <input type="text" id="ver_ciudadExp" name="ver_ciudadExp" class="form-control" readonly>
                              </div>

                              <div class="col-xs-12 col-sm-6 col-md-4 margen">
                                <label for="ver_nombre">Primer Nombre:</label>
                                <input type="text" id="ver_nombre" name="ver_nombre" class="form-control" readonly>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-4 margen">
                                <label for="ver_nombre2">Segundo Nombre:</label>
                                <input type="text" id="ver_nombre2" name="ver_nombre2" class="form-control" readonly>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-4 margen">
                                <label for="ver_apellido">Primer Apellido:</label>
                                <input type="text" id="ver_apellido" name="ver_apellido" class="form-control" readonly>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-4 ">
                                <label for="ver_apellido2">Segundo Apellido:</label>
                                <input type="text" id="ver_apellido2" name="ver_apellido2" class="form-control" readonly>
                              </div>
                            </div>
                            <!-- /row -->
                            <!-- row -->                   
                            <div class="row form-group">
                              <div class="col-xs-12 col-sm-6 col-md-3 margen">
                                <label for="ver_fechaNac">Fecha Nac.:</label>
                                <input id="ver_fechaNac" name="ver_fechaNac" class="form-control fecha" readonly>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-3 margen">
                                <label for="ver_ciudadNac">Ciudad de Nac.:</label>
                                <input type="text" id="ver_ciudadNac" name="ver_ciudadNac" class="form-control" readonly> 
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-3 margen">
                                <label for="ver_paisNac">Pais de Nacimiento:</label>
                                <input type="text" id="ver_paisNac" name="ver_paisNac" class="form-control" readonly>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-3 ">
                                <label for="ver_genero">Genero:</label>
                                <input type="text" id="ver_genero" name="ver_genero" class="form-control" readonly>
                              </div>
                            </div>
                            <!-- /row -->
                            <!-- row -->
                            <div class="row form-group">
                              <div class="col-xs-12 col-sm-6 col-md-3 ">
                                <label for="ver_estado">Estado Civil:</label>
                                <input type="text" id="ver_estado" name="ver_estado" class="form-control" readonly>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-3 ">
                                <label for="ver_etnia">Etnia:</label>
                                <input type="text" id="ver_etnia" name="ver_etnia" class="form-control" readonly>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-3 ">
                                <label for="ver_nivel">Nivel de Estudios:</label>
                                <input type="text" id="ver_nivel" name="ver_nivel" class="form-control" readonly>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-3 ">
                                <label for="ver_titulo">Titulo Universitario:</label>
                                <input id="ver_titulo" name="ver_titulo" class="form-control" readonly>
                              </div>
                            </div>
                            <!-- /row -->
                            <!-- row -->                   
                            <div class="row form-group">
                              <div class="col-xs-12 col-sm-6 col-md-3 ">
                                <label for="ver_direccion">Direcci&oacute;n:</label>
                                <input id="ver_direccion" name="ver_direccion" class="form-control" readonly>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-3 ">
                                <label for="ver_barrio">Barrio:</label>
                                <input id="ver_barrio" name="ver_barrio" class="form-control" readonly>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-3 ">
                                <label for="ver_estrato">Estrato:</label>
                                <input type="text" id="ver_estrato" name="ver_estrato" class="form-control" readonly>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-3 ">
                                <label for="ver_ciudad">Ciudad:</label>
                                <input type="text" id="ver_ciudad" name="ver_ciudad" class="form-control" readonly>
                              </div>
                            </div>
                            <!-- /row -->
                            <!-- row -->
                            <div class="row form-group">
                              <div class="ccol-xs-12 col-sm-6 col-md-3 ">
                                <label for="ver_telefono">Teléfono:</label>
                                <input id="ver_telefono" name="ver_telefono" class="form-control" readonly>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-3 ">
                                <label for="ver_celular">Celular:</label>
                                <input id="ver_celular" name="ver_celular" class="form-control" readonly>
                              </div>
                              <div class="ccol-xs-12 col-sm-6 col-md-3 ">
                                <label for="ver_email">E-Mail:</label>
                                <input id="ver_email" name="ver_email" class="form-control" readonly>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-3 ">
                                <label for="ver_comentario">Comentarios:</label>
                                <textarea id="ver_comentario" name="ver_comentario" class="form-control" readonly></textarea>
                              </div>
                            </div>
                            <!-- /row -->
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
            </div>
            <div class="tab-pane fade  in" id="datosEpsVer">
                <div class="col">
                  <div class="panel panel-primary">
                    <div class="panel-heading">
                      Nombre: <span id="ver_NombreEps">$nombre</span> <span id="ver_ApellidoEps">$apellido</span> /  Documento:<span id="ver_DocumentoEps">$documento</span>
                    </div>
                    <div class="panel-body">
                      <div class="row">
                        <div class="col-lg-12">
                          <form id="form_" role="form">
                            <input type="hidden" class="ver_id_empleado_eps" name="ver_id_empleado_eps">
                            <span id="pint">
                              <button type="button" class="btn btn-default btn-circle btn-lg" onclick="imprimir()">
                                <i class="fa fa-print" aria-hidden="true"></i>
                              </button> Imprimir Formulario
                            </span>
                            <!-- row -->
                            <div id="alertaVacio" class="col-md-12">
                              <div class="alert alert-danger " role="alert">
                                <strong>No se ha agregado E.P.S.</strong>
                              </div>
                            </div>
                            <div id="ocultarCaja">
                              <div class="row form-group">
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 ">
                                  <label for="ver_eps">E.P.S:</label>
                                  <input id="ver_eps" name="ver_eps" class="form-control" readonly>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 margen">
                                  <label for="ver_fecha_radicacion_eps">Fecha de Radicación:</label>
                                  <input id="ver_fecha_radicacion_eps" name="ver_fecha_radicacion_eps" class="form-control" readonly>
                                </div>   
                              </div>
                              <!-- /row -->
                              <!-- row -->
                              <div class="row form-group">                       
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 ">
                                  <label for="ver_tipo_tramite_eps">Tipo Tramite</label>
                                  <input id="ver_tipo_tramite_eps" name="ver_tipo_tramite_eps" class="form-control" readonly>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 ">
                                  <label for="ver_tipo_afiliacion_eps">Tipo Afiliacion</label>
                                  <input id="ver_tipo_afiliacion_eps" name="ver_tipo_afiliacion_eps" class="form-control" readonly>
                                </div>
                              </div>
                              <!-- /row -->
                              <!-- row -->
                              <div class="row form-group">
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 ">
                                  <label for="ver_tipo_afiliado_eps">Tipo Afiliado</label>
                                  <input id="ver_tipo_afiliado_eps" name="ver_tipo_afiliado_eps" class="form-control" readonly>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 ">
                                  <label for="ver_tipo_cotizante_eps">Tipo Cotizante</label>
                                  <input id="ver_tipo_cotizante_eps" name="ver_tipo_cotizante_eps" class="form-control" readonly>
                                </div>
                              </div>
                              <!-- /row -->
                              <!-- row -->
                              <div class="row form-group">
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 ">
                                  <label for="ver_regimen_eps">Regimen</label>
                                  <input id="ver_regimen_eps" name="ver_regimen_eps" class="form-control" readonly>
                                </div>
                              </div>
                              <!-- /row -->
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
                <!-- /.col -->
            </div>
            <div class="tab-pane fade  in" id="datosArlVer">
              <div class="col">
                <div class="panel panel-primary">
                  <div class="panel-heading">
                    Nombre: <span id="ver_NombreArl">$nombre</span> <span id="ver_ApellidoArl">$Apellido</span> /  Documento:<span id="ver_DocumentoArl">$documento</span>
                  </div>
                  <div class="panel-body">
                    <div class="row">
                      <div class="col-lg-12">
                        <form id="form_ver" role="form">
                          <input type="hidden" class="ver_id_empleado_arl" name="ver_id_empleado_arl">
                          <span id="pint">
                            <button type="button" class="btn btn-default btn-circle btn-lg" onclick="abrirNuevo()">
                              <i class="fa fa-print" aria-hidden="true"></i>
                            </button> Imprimir Formulario
                          </span>
                          <!-- row -->
                          <div class="row form-group">
                            <div id="alertaVacio" class="col-md-12">
                              <div class="alert alert-danger " role="alert">
                                <strong>No se ha agregado A.R.L</strong>
                              </div>
                            </div>
                            <div id="ocultarCaja">
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 ">
                                <label for="ver_arl">A.R.L:</label>
                                <input id="ver_arl" name="ver_arl" class="form-control" readonly>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 margen">
                                <label for="ver_fecha_afiliacion_arl">Fecha de Afiliación:</label>
                                <input id="ver_fecha_afiliacion_arl" name="ver_fecha_afiliacion_arl" class="form-control" readonly>
                              </div>   
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 ">
                                <label for="ver_codigo_transaccion_arl">Codigo Transacción</label>
                                <input id="ver_codigo_transaccion_arl" name="ver_codigo_transaccion_arl" class="form-control" readonly>
                              </div>
                            </div>
                          </div>
                          <!-- /row -->
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
              <!-- /.col -->
            </div>
            <div class="tab-pane fade  in" id="datosPensionVer">
                <div class="col">
                  <div class="panel panel-primary">
                    <div class="panel-heading">
                    Nombre: <span id="ver_NombrePension">$nombre</span> <span id="ver_ApellidoPension">$Apellido</span> /  Documento:<span id="ver_DocumentoPension">$documento</span>
                  	</div>
                    <div class="panel-body">
                      <div class="row">
                        <div class="col-lg-12">
                          <form id="form_ver" role="form">
                            <input type="hidden" class="ver_id_empleado_pension" name="ver_id_empleado_pension">
                            <span id="pint">
                              <button type="button" class="btn btn-default btn-circle btn-lg" onclick="imprimir()">
                                <i class="fa fa-print" aria-hidden="true"></i>
                              </button> Imprimir Formulario
                            </span>
                            <!-- row -->
                            <div class="row form-group">
                              <div id="alertaVacio" class="col-md-12">
                                <div class="alert alert-danger " role="alert">
                                  <strong>No se ha agregado Fondo de Pensi&oacute;n</strong>
                                </div>
                              </div>
                              <div id="ocultarCaja">
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 ">
                                  <label for="ver_pension">Fondo Pensión:</label>
                                  <input id="ver_pension" name="ver_pension" class="form-control" readonly>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 margen">
                                  <label for="ver_fecha_afiliacion_pension">Fecha de Afiliación:</label>
                                  <input id="ver_fecha_afiliacion_pension" name="ver_fecha_afiliacion_pension" class="form-control" readonly>
                                </div>
                              </div>
                            </div>
                            <!-- /row -->
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
                <!-- /.col -->
            </div>
            <div class="tab-pane fade  in" id="datosCajaVer">
                <div class="col">
                  <div class="panel panel-primary">
                    <div class="panel-heading">
                    Nombre: <span id="ver_NombreCaja">$nombre</span> <span id="ver_ApellidoCaja">$Apellido</span> /  Documento:<span id="ver_DocumentoCaja">$documento</span>
                  	</div>
                    <div class="panel-body">
                      <div class="row">
                        <div class="col-lg-12">
                          <form id="form_ver" role="form" class="form-caja">
                            <input type="hidden" class="ver_id_empleado_caja" name="ver_id_empleado_caja">
                            <span id="pint">
                              <button type="button" class="btn btn-default btn-circle btn-lg" onclick="imprimir()">
                                <i class="fa fa-print" aria-hidden="true"></i>
                              </button> Imprimir Formulario
                            </span>
                            <!-- row -->
                            <div class="row form-group">
                              <div id="alertaVacio" class="col-md-12">
                                <div class="alert alert-danger " role="alert">
                                  <strong>No se ha agregado Caja de Compensaci&oacute;n</strong>
                                </div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 " id="ocultarCaja">
                                <label for="ver_caja">Caja Compensación:</label>
                                <input id="ver_caja" name="ver_caja" class="form-control" readonly>
                              </div>
                                
                            </div>
                            <!-- /row -->
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
                <!-- /.col -->
            </div>
            <div class="tab-pane fade  in" id="datosReferenciasVer">
                <div class="col">
                  <div class="panel panel-primary">
                    <div class="panel-heading">
                      Nombre: <span id="ver_nombreRef">$nombre</span> <span id="ver_apellidoRef">$apellido</span> /  Documento: <span id="ver_documentoRef">$documento</span><input type="hidden" class="ver_id_empleado_referencias" name="ver_id_empleado_referencias"><input type="hidden" id="ver_contador_referencias" name="ver_contador_referencias">
                    </div>
                    <div class="panel-body">
                      <span id="pint"><button type="button" class="btn btn-default btn-circle btn-lg" onclick="abrirNuevo()"><i class="fa fa-print" aria-hidden="true"></i></button> Imprimir Formulario</span>
                      <div id="verDatosReferencias">
                      </div>
                    </div>
                      <!-- /.panel-body -->
                  </div>
                  <!-- /.panel -->
                </div>
                <!-- /.col -->
            </div>
            <div class="tab-pane fade  in" id="datosContratoVer">
                <div class="col">
                  <div class="panel panel-primary">
                    <div class="panel-heading">
                      Nombre: <span id="ver_nombreContrato">$nombre</span> <span id="ver_apellidoContrato">$apellido</span> /  Documento: <span id="ver_documentoContrato">$documento</span>
                    </div>
                    <div class="panel-body">
                      <div class="row">
                        <div class="col-lg-12">
                          <form id="form_ver" role="form">
                            <input type="hidden" class="ver_id_empleado_contrato" name="ver_id_empleado_contrato">
                            <span id="pint">
                              <button type="button" class="btn btn-default btn-circle btn-lg" onclick="imprimirContrato()">
                                <i class="fa fa-print" aria-hidden="true"></i>
                              </button> Imprimir Formulario
                            </span>
                            <!-- row -->
                            <div class="row form-group ">
                              <div id="alertaVacio" class="col-md-12">
                                <div class="alert alert-danger " role="alert">
                                  <strong>No se ha agregado Contrato de Trabajo</strong>
                                </div>
                              </div>
                              <div class="col-md-12" id="ocultarContrato">
                                <!-- row -->
                                <div class="row form-group ">
                                  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 margen">
                                    <label for="ver_empresa">Empresa Contratante:</label>
                                    <input id="ver_empresa" name="ver_empresa" class="form-control" readonly>
                                  </div>
                                  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 margen">
                                    <label for="ver_cargo">Cargo:</label>
                                    <input id="ver_cargo" name="ver_cargo" class="form-control" readonly>
                                  </div>   
                                </div>
                                <!-- /row -->
                                <!-- row -->
                                <div class="row form-group ">
                                  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 margen">
                                    <label for="ver_salario">Salario:</label>
                                    <input id="ver_salario" name="ver_salario" class="form-control" readonly>
                                  </div>
                                  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 margen">
                                    <label for="ver_jornada">Jornada:</label>
                                    <input id="ver_jornada" name="ver_jornada" class="form-control" readonly>
                                  </div>
                                </div>
                                <!-- /row -->
                                <!-- row -->
                                <div class="row form-group">
                                  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 margen">
                                    <label for="ver_servicio_funerario">Servicio Funerario:</label>
                                    <input id="ver_servicio_funerario" name="ver_servicio_funerario" class="form-control" readonly>
                                  </div>
                                  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 margen">
                                    <label for="ver_banco">Banco Pago Nomina:</label>
                                    <input id="ver_banco" name="ver_banco" class="form-control" readonly>
                                  </div>
                                </div>
                                <!-- /row -->
                                <!-- row -->
                                <div class="row form-group">
                                  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 margen">
                                    <label for="ver_cuenta">Cuenta #:</label>
                                    <input id="ver_cuenta" name="ver_cuenta" class="form-control" readonly>
                                  </div>
                                  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 margen">
                                    <label for="ver_tipo_cuenta">Tipo de Cuenta:</label>
                                    <input id="ver_tipo_cuenta" name="ver_tipo_cuenta" class="form-control" readonly>
                                  </div>
                                </div>
                                <!-- /row -->                              
                              </div>
                            </div>
                            <!-- /row -->
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
                <!-- /.col -->
            </div>
          </div>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- / Modal Editar empleado -->
  <!-- Modal Nueva Ciudad  -->
  <div class="modal fade" id="modalNuevaCiudad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"> <i class="fa fa-map-signs fa-fw"></i> Ciudades</h4>
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
                            <input type="text" required id="new_ciudad" name="new_ciudad" class="form-control" placeholder="Nombre">
                            <div id="msg_error_nombre" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                          </div>
                        </div>
                        <div class="row form-group">
                          <label class="col-sm-3" for="new_pais">Pais:</label>
                          <div class="col-sm-9">
                            <select id="new_pais" name="new_pais" class="form-control">
                              <option value="null">--Pais--</option>
                            </select>
                            <div class="input-group-addon add">
                                <span id="new_tipo_icon" class="fa fa-plus cursor" onclick="addPais()"></span>
                            </div>
                            <div id="msg_error_pais" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                          </div>
                        </div>
                        <div class="row form-group text-center">
                          <button id="btn_guardar_nueva_ciudad" type="button" onclick="guardarNuevaCiudad()"  class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-pulse fa-fw'></i> Guardando...">Guardar</button>
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
  <!-- / Modal Nueva Ciudad  -->
  <!-- Modal Nuevo Tipo de Documento  -->
  <div class="modal fade" id="modalNuevoTipo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"> <i class="fa fa-map-signs fa-fw"></i> Tipos de Documento</h4>
        </div>
        <div class="modal-body">
            <div class="col">
              <div class="panel panel-primary">
                <div class="panel-heading">
                  Nuevo Tipo de Documento
                </div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-lg-12">
                      <form id="form_nuevo" role="form">
                        <div class="row form-group">
                          <label class="col-sm-3" for="new_tipo">Nombre:</label>
                          <div class="col-sm-9">
                            <input type="text" required id="new_tipo" name="new_tipo" class="form-control" placeholder="Nombre">
                            <div id="msg_error_tipo" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                          </div>
                        </div>
                        <div class="row form-group text-center">
                          <button id="btn_guardar_nuevo_tipo" type="button" onclick="guardarNuevoTipo()"  class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-pulse fa-fw'></i> Guardando...">Guardar</button>
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
  <!-- / Modal Nuevo Tipo  -->
  <!-- Modal Nuevo Pais  -->
  <div class="modal fade" id="modalNuevoPais" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"> <i class="fa fa-map-signs fa-fw"></i> Paises</h4>
        </div>
        <div class="modal-body">
            <div class="col">
              <div class="panel panel-primary">
                <div class="panel-heading">
                  Nuevo Pais
                </div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-lg-12">
                      <form id="form_nuevo" role="form">
                        <div class="row form-group">
                          <label class="col-sm-3" for="new_pais">Nombre:</label>
                          <div class="col-sm-9">
                            <input type="text" required id="new_pais" name="new_pais" class="form-control" placeholder="Nombre">
                            <div id="msg_error_tipo" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                          </div>
                        </div>
                        <div class="row form-group text-center">
                          <button id="btn_guardar_nuevo_pais" type="button" onclick="guardarNuevoPais()"  class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-pulse fa-fw'></i> Guardando...">Guardar</button>
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
  <!-- / Modal Nuevo Pais  -->
  <!-- Modal Nuevo Genero  -->
  <div class="modal fade" id="modalNuevoGenero" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"> <i class="fa fa-map-signs fa-fw"></i> Generos</h4>
        </div>
        <div class="modal-body">
            <div class="col">
              <div class="panel panel-primary">
                <div class="panel-heading">
                  Nuevo Genero
                </div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-lg-12">
                      <form id="form_nuevo" role="form">
                        <div class="row form-group">
                          <label class="col-sm-3" for="new_genero">Nombre:</label>
                          <div class="col-sm-9">
                            <input type="text" required id="new_genero" name="new_genero" class="form-control" placeholder="Nombre">
                            <div id="msg_error_genero" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                          </div>
                        </div>
                        <div class="row form-group text-center">
                          <button id="btn_guardar_nuevo_genero" type="button" onclick="guardarNuevoGenero()"  class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-pulse fa-fw'></i> Guardando...">Guardar</button>
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
  <!-- / Modal Nuevo Genero  -->
  <!-- Modal Nuevo Estado Civil  -->
  <div class="modal fade" id="modalNuevoEstado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"> <i class="fa fa-map-signs fa-fw"></i> Estados Civiles</h4>
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
                          <label class="col-sm-3" for="new_estado">Nombre:</label>
                          <div class="col-sm-9">
                            <input type="text" required id="new_estado" name="new_estado" class="form-control" placeholder="Nombre">
                            <div id="msg_error_estado" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                          </div>
                        </div>
                        <div class="row form-group text-center">
                          <button id="btn_guardar_nuevo_estado" type="button" onclick="guardarNuevoEstado()"  class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-pulse fa-fw'></i> Guardando...">Guardar</button>
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
  <!-- / Modal Nuevo Estado  -->
  <!-- Modal Nuevo Nivel de Estudio -->
  <div class="modal fade" id="modalNuevoNivel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"> <i class="fa fa-map-signs fa-fw"></i> Niveles de Estudio</h4>
        </div>
        <div class="modal-body">
            <div class="col">
              <div class="panel panel-primary">
                <div class="panel-heading">
                  Nuevo Nivel de Estudio
                </div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-lg-12">
                      <form id="form_nuevo" role="form">
                        <div class="row form-group">
                          <label class="col-sm-3" for="new_nivel">Nombre:</label>
                          <div class="col-sm-9">
                            <input type="text" required id="new_nivel" name="new_nivel" class="form-control" placeholder="Nombre">
                            <div id="msg_error_nivel" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                          </div>
                        </div>
                        <div class="row form-group text-center">
                          <button id="btn_guardar_nuevo_nivel" type="button" onclick="guardarNuevoNivel()"  class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-pulse fa-fw'></i> Guardando...">Guardar</button>
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
  <!-- / Modal Nuevo Nivel  -->
  <!-- Modal Nuevo Estrato -->
  <div class="modal fade" id="modalNuevoEstrato" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"> <i class="fa fa-map-signs fa-fw"></i> Estratos</h4>
        </div>
        <div class="modal-body">
            <div class="col">
              <div class="panel panel-primary">
                <div class="panel-heading">
                  Nuevo Estrato
                </div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-lg-12">
                      <form id="form_nuevo" role="form">
                        <div class="row form-group">
                          <label class="col-sm-3" for="new_estrato">Nombre:</label>
                          <div class="col-sm-9">
                            <input type="text" required id="new_estrato" name="new_estrato" class="form-control" placeholder="Nombre">
                            <div id="msg_error_nivel" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                          </div>
                        </div>
                        <div class="row form-group text-center">
                          <button id="btn_guardar_nuevo_estrato" type="button" onclick="guardarNuevoEstrato()"  class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-pulse fa-fw'></i> Guardando...">Guardar</button>
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
  <!-- / Modal Nuevo Estrato  -->
  <!-- Modal Nueva Etnia -->
  <div class="modal fade" id="modalNuevaEtnia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"> <i class="fa fa-map-signs fa-fw"></i> Etnias</h4>
        </div>
        <div class="modal-body">
            <div class="col">
              <div class="panel panel-primary">
                <div class="panel-heading">
                  Nueva Etnia
                </div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-lg-12">
                      <form id="form_nuevo" role="form">
                        <div class="row form-group">
                          <label class="col-sm-3" for="new_etnia">Nombre:</label>
                          <div class="col-sm-9">
                            <input type="text" required id="new_etnia" name="new_etnia" class="form-control" placeholder="Nombre">
                            <div id="msg_error_nivel" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                          </div>
                        </div>
                        <div class="row form-group text-center">
                          <button id="btn_guardar_nueva_etnia" type="button" onclick="guardarNuevaEtnia()"  class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-pulse fa-fw'></i> Guardando...">Guardar</button>
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
  <!-- / Modal Nueva Etnia  -->
  <!-- Modal Nueva Eps -->
  <div class="modal fade" id="modalNuevaEps" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"> <i class="fa fa-map-signs fa-fw"></i> EPS</h4>
        </div>
        <div class="modal-body">
            <div class="col">
              <div class="panel panel-primary">
                <div class="panel-heading">
                  Nueva EPS
                </div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-lg-12">
                      <form id="form_nuevo" role="form">
                        <div class="row form-group">
                          <label class="col-sm-3" for="new_eps">Nombre:</label>
                          <div class="col-sm-9">
                            <input type="text" required id="new_eps" name="new_eps" class="form-control" placeholder="Nombre">
                            <div id="msg_error_nivel" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                          </div>
                        </div>
                        <div class="row form-group text-center">
                          <button id="btn_guardar_nueva_eps" type="button" onclick="guardarNuevaEps()"  class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-pulse fa-fw'></i> Guardando...">Guardar</button>
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
  <!-- / Modal Nueva Eps  -->
  <!-- Modal Nueva Arl -->
  <div class="modal fade" id="modalNuevaArl" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"> <i class="fa fa-map-signs fa-fw"></i> ARL</h4>
        </div>
        <div class="modal-body">
            <div class="col">
              <div class="panel panel-primary">
                <div class="panel-heading">
                  Nueva ARL
                </div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-lg-12">
                      <form id="form_nuevo" role="form">
                        <div class="row form-group">
                          <label class="col-sm-3" for="new_arl">Nombre:</label>
                          <div class="col-sm-9">
                            <input type="text" required id="new_arl" name="new_arl" class="form-control" placeholder="Nombre">
                            <div id="msg_error_nivel" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>
                          </div>
                        </div>
                        <div class="row form-group text-center">
                          <button id="btn_guardar_nueva_arl" type="button" onclick="guardarNuevaArl()"  class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-pulse fa-fw'></i> Guardando...">Guardar</button>
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
  </div>
    <!-- Modal Nueva ARl  -->

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
