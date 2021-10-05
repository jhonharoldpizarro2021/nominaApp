<?php
  session_start();
  ob_start();
  $retorno = array();
  if( $_POST )
  {
    include "../functions.php";
    //validar session
    if( session_valida() )
    {
      $con = start_connect();
      if( $con ) //Conexion establecida
      {
        switch ( $_POST["opcion"] )
        {
          case 1://crear listas
              $query = "SELECT * FROM tipos_documento_identidad ORDER BY nombre ASC";
              $result = mysqli_query($con,$query);
              $tipos = array( array( "id" => $row["id_tipos"], "nombre" => "--Tipo Documento--" ) );
              while( $row = mysqli_fetch_array($result) )
              {
                $tipos[] = array( "id" => $row["id_tipos"], "nombre" => utf8_encode($row["nombre"]) );
              }
              $retorno["tipos"] = $tipos;

              $query2 = "SELECT * FROM genero ORDER BY nombre ASC";
              $result2 = mysqli_query($con,$query2);
              $generos = array( array( "id" => $row2["id_genero"], "nombre" => "--Genero--" ) );
              while( $row2 = mysqli_fetch_array($result2) )
              {
                $generos[] = array( "id" => $row2["id_genero"], "nombre" => utf8_encode($row2["nombre"]) );
              }
              $retorno["generos"] = $generos;

              $query3 = "SELECT * FROM estado_civil ORDER BY nombre ASC";
              $result3 = mysqli_query($con,$query3);
              $estados = array( array( "id" => $row3["id_estado_civil"], "nombre" => "--Estado Civil--" ) );
              while( $row3 = mysqli_fetch_array($result3) )
              {
                $estados[] = array( "id" => $row3["id_estado_civil"], "nombre" => utf8_encode($row3["nombre"]) );
              }
              $retorno["estados"] = $estados;

              $query4 = "SELECT * FROM nivel_estudio ORDER BY nombre ASC";
              $result4 = mysqli_query($con,$query4);
              $niveles = array( array( "id" => $row4["id_nivel_estudio"], "nombre" => "--Nivel Estudio--" ) );
              while( $row4 = mysqli_fetch_array($result4) )
              {
                $niveles[] = array( "id" => $row4["id_nivel_estudio"], "nombre" => utf8_encode($row4["nombre"]) );
              }
              $retorno["niveles"] = $niveles;

              $query5 = "SELECT * FROM estratos ORDER BY nombre ASC";
              $result5 = mysqli_query($con,$query5);
              $estratos = array( array( "id" => $row5["id_estratos"], "nombre" => "--Estrato--" ) );
              while( $row5 = mysqli_fetch_array($result5) )
              {
                $estratos[] = array( "id" => $row5["id_estratos"], "nombre" => utf8_encode($row5["nombre"]) );
              }
              $retorno["estratos"] = $estratos;
              
              $query6 = "SELECT * FROM etnias ORDER BY nombre ASC";
              $result6 = mysqli_query($con,$query6);
              $etnias = array( array( "id" => $row6["id_etnias"], "nombre" => "--Etnia--" ) );
              while( $row6 = mysqli_fetch_array($result6) )
              {
                $etnias[] = array( "id" => $row6["id_etnias"], "nombre" => utf8_encode($row6["nombre"]) );
              }
              $retorno["etnias"] = $etnias;

              $query7 = "SELECT * FROM ciudad ORDER BY nombre ASC";
              $result7 = mysqli_query($con,$query7);
              $ciudades = array( array( "id" => $row7["id_ciudad"], "nombre" => "--Ciudad--" ) );
              while( $row7 = mysqli_fetch_array($result7) )
              {
                $ciudades[] = array( "id" => $row7["id_ciudad"], "nombre" => utf8_encode($row7["nombre"]) );
              }
              $retorno["ciudades"] = $ciudades;

              $query8 = "SELECT * FROM pais ORDER BY nombre ASC";
              $result8 = mysqli_query($con,$query8);
              $paises = array( array( "id" => $row8["id_pais"], "nombre" => "--Pais--" ) );
              while( $row8 = mysqli_fetch_array($result8) )
              {
                $paises[] = array( "id" => $row8["id_pais"], "nombre" => utf8_encode($row8["nombre"]) );
              }
              $retorno["paises"] = $paises;

              $query9 = "SELECT * FROM empresas ORDER BY nombre ASC";
              $result9 = mysqli_query($con,$query9);
              $empresas = array( array( "id" => $row9["id_empresas"], "nombre" => "--Empresa--" ) );
              while( $row9 = mysqli_fetch_array($result9) )
              {
                $empresas[] = array( "id" => $row9["id_empresas"], "nombre" => utf8_encode($row9["nombre"]) );
              }
              $retorno["empresas"] = $empresas;

              $query10 = "SELECT * FROM bancos ORDER BY nombre ASC";
              $result10 = mysqli_query($con,$query10);
              $bancos = array( array( "id" => $row10["id_bancos"], "nombre" => "--Banco--" ) );
              while( $row10 = mysqli_fetch_array($result10) )
              {
                $bancos[] = array( "id" => $row10["id_bancos"], "nombre" => utf8_encode($row10["nombre"]) );
              }
              $retorno["bancos"] = $bancos;

              $query11 = "SELECT * FROM tipo_cuenta ORDER BY nombre ASC";
              $result11 = mysqli_query($con,$query11);
              $tipoCuentas = array( array( "id" => $row11["id_tipo_cuenta"], "nombre" => "--Tipo de Cuenta--" ) );
              while( $row11 = mysqli_fetch_array($result11) )
              {
                $tipoCuentas[] = array( "id" => $row11["id_tipo_cuenta"], "nombre" => utf8_encode($row11["nombre"]) );
              }
              $retorno["tipoCuentas"] = $tipoCuentas;



  
              $retorno["status"] = "OK";
            break;
          case 2: //Agregar nuevo 
              //Verificar que no está registrado
              $query = "SELECT COUNT(*) FROM empleados WHERE nroDocEmpleado='". $_POST["documento"] ."'";
              $result = mysqli_query($con,$query);
              $row = mysqli_fetch_array($result);

              if( $row[0] > 0 ) //El correo ya se encuentra registrado
              {
                $retorno["status"] = "EXIST";
                $retorno["msg"] = "Documento registrado";
              }else
              {
                $query = "INSERT INTO empleados (
                                                  tipoDocEmpleado, 
                                                  nroDocEmpleado, 
                                                  primerNombreEmpleado, 
                                                  segundoNombreEmpleado, 
                                                  primerApellidoEmpleado, 
                                                  segundoApellidoEmpleado, 
                                                  lugarExpedicionDocEmpleado, 
                                                  fechaExpedicionDocEmpleado, 
                                                  fechaNacimientoEmpleado, 
                                                  ciudadNacimientoEmpleado, 
                                                  paisNacimientoEmpleado, 
                                                  generoEmpleado, 
                                                  estadoCivilEmpleado, 
                                                  nivelEstudioEmpleado, 
                                                  tituloEmpleado, 
                                                  direccionEmpleado, 
                                                  barrioEmpleado, 
                                                  ciudadResidenciaEmpleado, 
                                                  estratoEmpleado, 
                                                  telefonoEmpleado, 
                                                  celularEmpleado, 
                                                  emailEmpleado, 
                                                  etniaEmpleado, 
                                                  comentariosEmpleado
                                                )
                          VALUES(
                                  '". $_POST["tipo"] ."',
                                  '". $_POST["documento"] ."',
                                  '". utf8_decode($_POST["nombre"]) ."',
                                  '". utf8_decode($_POST["nombre2"]) ."',
                                  '". utf8_decode($_POST["apellido"]) ."',
                                  '". utf8_decode($_POST["apellido2"]) ."',
                                  '". $_POST["ciudadExp"] ."',
                                  '". $_POST["fecha_exp"] ."',
                                  '". $_POST["fecha_nac"] ."',
                                  '". $_POST["ciudadNac"] ."',
                                  '". $_POST["paisNac"] ."',
                                  '". $_POST["genero"] ."',
                                  '". $_POST["estado"] ."',
                                  '". $_POST["nivel"] ."',
                                  '". utf8_decode($_POST["titulo"]) ."',
                                  '". utf8_decode($_POST["direccion"]) ."',
                                  '". utf8_decode($_POST["barrio"]) ."',
                                  '". $_POST["ciudad"] ."',
                                  '". $_POST["estrato"] ."',
                                  '". $_POST["telefono"] ."',
                                  '". $_POST["celular"] ."',
                                  '". $_POST["email"] ."',
                                  '". $_POST["etnia"] ."',
                                  '". utf8_decode($_POST["comentario"]) ."'
                                )
                        ";
                if( mysqli_query($con,$query) )
                {
                  $retorno["status"] = "OK";
                  $retorno["id"] = mysqli_insert_id($con);
                }else{
                  $retorno["status"] = "ERROR";
                  $retorno["msg"] = "Error al realizar el Insert en la BDD: ". mysqli_error($con);
                  $retorno["sql"] = $query;
                }
              }
            break;
          case 3: //Actualizar               
                $query = "UPDATE empleados SET 
                                              tipoDocEmpleado='". $_POST["tipo"] ."', 
                                              primerNombreEmpleado='". utf8_decode($_POST["nombre"]) ."', 
                                              segundoNombreEmpleado='". utf8_decode($_POST["nombre2"]) ."', 
                                              primerApellidoEmpleado='". utf8_decode($_POST["apellido"]) ."', 
                                              segundoApellidoEmpleado='". utf8_decode($_POST["apellido2"]) ."', 
                                              lugarExpedicionDocEmpleado='". $_POST["ciudadExp"] ."', 
                                              fechaExpedicionDocEmpleado='". $_POST["fechaExp"] ."', 
                                              fechaNacimientoEmpleado='". $_POST["fechaNac"] ."', 
                                              ciudadNacimientoEmpleado='". $_POST["ciudadNac"] ."', 
                                              paisNacimientoEmpleado='". $_POST["paisNac"] ."', 
                                              generoEmpleado='". $_POST["genero"] ."', 
                                              estadoCivilEmpleado='". $_POST["estado"] ."', 
                                              nivelEstudioEmpleado='". $_POST["nivel"] ."', 
                                              tituloEmpleado='". utf8_decode($_POST["titulo"]) ."', 
                                              direccionEmpleado='". utf8_decode($_POST["direccion"]) ."', 
                                              barrioEmpleado='". utf8_decode($_POST["barrio"]) ."', 
                                              ciudadResidenciaEmpleado='". $_POST["ciudad"] ."', 
                                              estratoEmpleado='". $_POST["estrato"] ."', 
                                              telefonoEmpleado='". $_POST["telefono"] ."', 
                                              celularEmpleado='". $_POST["celular"] ."', 
                                              emailEmpleado='". $_POST["email"] ."', 
                                              etniaEmpleado='". $_POST["etnia"] ."', 
                                              comentariosEmpleado='". utf8_decode($_POST["comentario"]) ."' 
                      WHERE IDEmpleado='". $_POST["id"] ."' ";
                if( mysqli_query($con,$query) )
                {
                  $retorno["status"] = "OK";
                }else{
                  $retorno["status"] = "ERROR";
                  $retorno["msg"] = "Error al realizar el Insert en la BDD: ". mysqli_error($con);
                }
            break;
          case 4: //Consultar empleados
              $query = "SELECT * FROM qr_empleado ORDER BY IDEmpleado ASC";
              $result = mysqli_query($con,$query);
              $empleados = array();
              while( $row = mysqli_fetch_array($result) )
              {
                $empleados[] = array(
                                      "id" => $row["IDEmpleado"],
                                      "nombre" => utf8_encode( $row["primerNombreEmpleado"] ),
                                      "nombre2" => utf8_encode( $row["segundoNombreEmpleado"] ),
                                      "apellido" => utf8_encode( $row["primerApellidoEmpleado"] ),
                                      "apellido2" => utf8_encode( $row["segundoApellidoEmpleado"] ),
                                      "IDtipo" => $row["IDtipoDocEmpleado"],
                                      "tipo" => utf8_encode( $row["tipo_documento"] ),
                                      "documento" => $row["nroDocEmpleado"],
                                      "fechaExp" => $row["fechaExpedicionDocEmpleado"],
                                      "IDciudadExp" => $row["IDlugarExpedicionDocEmpleado"],
                                      "ciudadExp" => utf8_encode( $row["lugarExpedicionDocEmpleado"] ),
                                      "fechaNac" => $row["fechaNacimientoEmpleado"],
                                      "IDciudadNac" => $row["IDciudadNacimientoEmpleado"],
                                      "ciudadNac" => utf8_encode( $row["ciudadNacimientoEmpleado"] ),
                                      "IDpaisNac" => $row["IDpaisNacimientoEmpleado"],
                                      "paisNac" => utf8_encode( $row["paisNacimientoEmpleado"] ),
                                      "IDgenero" => $row["IDgeneroEmpleado"],
                                      "genero" => utf8_encode( $row["generoEmpleado"] ),
                                      "IDestado" => $row["IDestadoCivilEmpleado"],
                                      "estado" => utf8_encode( $row["estadoCivilEmpleado"] ),
                                      "IDnivel" => $row["IDnivelEstudioEmpleado"],
                                      "nivel" => $row["nivelEstudioEmpleado"],
                                      "titulo" =>utf8_encode(  $row["tituloEmpleado"] ),
                                      "direccion" => $row["direccionEmpleado"],
                                      "barrio" => utf8_encode( $row["barrioEmpleado"] ),
                                      "IDestrato" => $row["IDestratoEmpleado"],
                                      "estrato" => $row["estratoEmpleado"],
                                      "IDciudad" => $row["IDciudadResidenciaEmpleado"],
                                      "ciudad" => utf8_encode( $row["ciudadResidenciaEmpleado"] ),
                                      "telefono" => $row["telefonoEmpleado"],
                                      "celular" => $row["celularEmpleado"],
                                      "email" => $row["emailEmpleado"],
                                      "IDetnia" => $row["IDetniaEmpleado"],
                                      "etnia" => utf8_encode( $row["etniaEmpleado"] ),
                                      "comentario" => utf8_encode( $row["comentariosEmpleado"] ),
                                      "eps" => $row["estado_afiliacion_salud_empleado"],
                                      "arl" => $row["estado_afiliacion_arl_empleado"],
                                      "pension" => $row["estado_afiliacion_pension_emplado"],
                                      "caja" => $row["estado_afiliacion_caja_empleado"]
                                    );
              }
              $retorno["status"] = "OK";
              $retorno["empleados"] = $empleados;
            break;
          case 5:  //Eliminar usuario
              
              $query1 = "DELETE FROM afiliacion_empleado_salud WHERE empleados_IDEmpleado='". $_POST["idEmpleado"] ."'";
              $query2 = "DELETE FROM afiliacion_empleado_arl WHERE empleados_IDEmpleado='". $_POST["idEmpleado"] ."'";
              $query3 = "DELETE FROM afiliacion_empleado_caja WHERE empleados_IDEmpleado='". $_POST["idEmpleado"] ."'";
              $query4 = "DELETE FROM afiliacion_empleado_pension WHERE empleados_IDEmpleado='". $_POST["idEmpleado"] ."'";
              $query5 = "DELETE FROM referencias_personales WHERE empleados_IDEmpleado='". $_POST["idEmpleado"] ."'";
              $query = "DELETE FROM empleados WHERE nroDocEmpleado='". $_POST["id"] ."'";
              if( mysqli_query($con,$query1) && mysqli_query($con,$query2) && mysqli_query($con,$query3) && mysqli_query($con,$query4) && mysqli_query($con,$query5) && mysqli_query($con,$query)    )
              {
                $retorno["status"] = "OK";
              }
              else if( mysqli_query($con,$query)    )
              {
                $retorno["status"] = "OK";
              }
              else{
                $retorno["status"] = "ERROR";
                $retorno["msg"] = "Error al borrar el usuario: ". mysqli_error($con);
              }
            break;
          case 6:  //Verificar que no está registrado
              $query = "SELECT COUNT(*) FROM empleados WHERE nroDocEmpleado='". $_POST["documento"] ."'";
              $result = mysqli_query($con,$query);
              $row = mysqli_fetch_array($result);

              if( $row[0] > 0 ) //El documento ya se encuentra registrado
              {
                $retorno["status"] = "EXIST";
                $retorno["msg"] = "Documento registrado";
              }
              else //El documento NO se encuentra registrado
              {
                $retorno["status"] = "EMPTY";
                $retorno["msg"] = "Documento registrado";
              }
            break;
          case 7:  //traer datos del usuario existente
              $query = "SELECT * FROM qr_empleado WHERE nroDocEmpleado='". $_POST["documento"] ."'";
              $result = mysqli_query($con,$query);
              while( $row = mysqli_fetch_array($result) )
              {
                $empleados[] = array(
                                      "id" => $row["IDEmpleado"],
                                      "nombre" => utf8_encode( $row["primerNombreEmpleado"] ),
                                      "nombre2" => utf8_encode( $row["segundoNombreEmpleado"] ),
                                      "apellido" => utf8_encode( $row["primerApellidoEmpleado"] ),
                                      "apellido2" => utf8_encode( $row["segundoApellidoEmpleado"] ),
                                      "IDtipo" => $row["IDtipoDocEmpleado"],
                                      "tipo" => utf8_encode( $row["tipo_documento"] ),
                                      "documento" => $row["nroDocEmpleado"],
                                      "fechaExp" => $row["fechaExpedicionDocEmpleado"],
                                      "IDciudadExp" => $row["IDlugarExpedicionDocEmpleado"],
                                      "ciudadExp" => utf8_encode( $row["lugarExpedicionDocEmpleado"] ),
                                      "fechaNac" => $row["fechaNacimientoEmpleado"],
                                      "IDciudadNac" => $row["IDciudadNacimientoEmpleado"],
                                      "ciudadNac" => utf8_encode( $row["ciudadNacimientoEmpleado"] ),
                                      "IDpaisNac" => $row["IDpaisNacimientoEmpleado"],
                                      "paisNac" => utf8_encode( $row["paisNacimientoEmpleado"] ),
                                      "IDgenero" => $row["IDgeneroEmpleado"],
                                      "genero" => utf8_encode( $row["generoEmpleado"] ),
                                      "IDestado" => $row["IDestadoCivilEmpleado"],
                                      "estado" => utf8_encode( $row["estadoCivilEmpleado"] ),
                                      "IDnivel" => $row["IDnivelEstudioEmpleado"],
                                      "nivel" => $row["nivelEstudioEmpleado"],
                                      "titulo" =>utf8_encode(  $row["tituloEmpleado"] ),
                                      "direccion" => $row["direccionEmpleado"],
                                      "barrio" => utf8_encode( $row["barrioEmpleado"] ),
                                      "IDestrato" => $row["IDestratoEmpleado"],
                                      "estrato" => $row["estratoEmpleado"],
                                      "IDciudad" => $row["IDciudadResidenciaEmpleado"],
                                      "ciudad" => utf8_encode( $row["ciudadResidenciaEmpleado"] ),
                                      "telefono" => $row["telefonoEmpleado"],
                                      "celular" => $row["celularEmpleado"],
                                      "email" => $row["emailEmpleado"],
                                      "IDetnia" => $row["IDetniaEmpleado"],
                                      "etnia" => utf8_encode( $row["etniaEmpleado"] ),
                                      "comentario" => utf8_encode( $row["comentariosEmpleado"] )
                                    );
              }
              $retorno["status"] = "OK";
              $retorno["empleados"] = $empleados;
            break;
          case 8:  // listas seguridad social
              $queryEps = "SELECT * FROM salud ORDER BY nombre ASC";
              $resultEps = mysqli_query($con,$queryEps);
              $eps = array( array( "id" => $rowEps["id_salud"], "nombre" => "--E.P.S.--" ) );
              while( $rowEps = mysqli_fetch_array($resultEps) )
              {
                $eps[] = array( "id" => $rowEps["id_salud"], "nombre" => utf8_encode($rowEps["nombre"]) );
              }
              $retorno["eps"] = $eps;

              $queryArl= "SELECT * FROM arl ORDER BY nombre ASC";
              $resultArl = mysqli_query($con,$queryArl);
              $arl = array( array( "id" => $rowArl["id_arl"], "nombre" => "--A.R.L.--" ) );
              while( $rowArl = mysqli_fetch_array($resultArl) )
              {
                $arl[] = array( "id" => $rowArl["id_arl"], "nombre" => utf8_encode($rowArl["nombre"]) );
              }
              $retorno["arl"] = $arl;

              $queryPension = "SELECT * FROM pension ORDER BY nombre ASC";
              $resultPension = mysqli_query($con,$queryPension);
              $pension = array( array( "id" => $rowPension["id_pension"], "nombre" => "--Fondo Pension--" ) );
              while( $rowPension = mysqli_fetch_array($resultPension) )
              {
                $pension[] = array( "id" => $rowPension["id_pension"], "nombre" => utf8_encode($rowPension["nombre"]) );
              }
              $retorno["pension"] = $pension;

              $queryCaja = "SELECT * FROM caja_compensacion_familiar ORDER BY nombre ASC";
              $resultCaja = mysqli_query($con,$queryCaja);
              $caja = array( array( "id" => $rowCaja["id_caja_compensacion"], "nombre" => "--Caja Compensación--" ) );
              while( $rowCaja = mysqli_fetch_array($resultCaja) )
              {
                $caja[] = array( "id" => $rowCaja["id_caja_compensacion"], "nombre" => utf8_encode($rowCaja["nombre"]) );
              }
              $retorno["caja"] = $caja;

              $queryTramite = "SELECT * FROM tipo_tramite ORDER BY nombre ASC";
              $resultTramite = mysqli_query($con,$queryTramite);
              $tramite = array( array( "id" => $rowTramite["id_tipo_tramite"], "nombre" => "--Tipo Tramite--" ) );
              while( $rowTramite = mysqli_fetch_array($resultTramite) )
              {
                $tramite[] = array( "id" => $rowTramite["id_tipo_tramite"], "nombre" => utf8_encode($rowTramite["nombre"]) );
              }
              $retorno["tramite"] = $tramite;

              $queryAfiliacion = "SELECT * FROM tipo_afiliacion ORDER BY nombre ASC";
              $resultAfiliacion = mysqli_query($con,$queryAfiliacion);
              $afiliacion = array( array( "id" => $rowAfiliacion["id_tipo_afiliacion"], "nombre" => "--Tipo Tramite--" ) );
              while( $rowAfiliacion = mysqli_fetch_array($resultAfiliacion) )
              {
                $afiliacion[] = array( "id" => $rowAfiliacion["id_tipo_afiliacion"], "nombre" => utf8_encode($rowAfiliacion["nombre"]) );
              }
              $retorno["afiliacion"] = $afiliacion;

              $queryAfiliado = "SELECT * FROM tipo_afiliado ORDER BY nombre ASC";
              $resultAfiliado = mysqli_query($con,$queryAfiliado);
              $afiliado = array( array( "id" => $rowAfiliado["id_tipo_afiliado"], "nombre" => "--Tipo Tramite--" ) );
              while( $rowAfiliado = mysqli_fetch_array($resultAfiliado) )
              {
                $afiliado[] = array( "id" => $rowAfiliado["id_tipo_afiliado"], "nombre" => utf8_encode($rowAfiliado["nombre"]) );
              }
              $retorno["afiliado"] = $afiliado;

              $queryCotizante = "SELECT * FROM tipo_cotizante ORDER BY nombre ASC";
              $resultCotizante = mysqli_query($con,$queryCotizante);
              $cotizante = array( array( "id" => $rowCotizante["id_tipo_cotizante"], "nombre" => "--Tipo Tramite--" ) );
              while( $rowCotizante = mysqli_fetch_array($resultCotizante) )
              {
                $cotizante[] = array( "id" => $rowCotizante["id_tipo_cotizante"], "nombre" => utf8_encode($rowCotizante["nombre"]) );
              }
              $retorno["cotizante"] = $cotizante;

              $queryParentesco = "SELECT * FROM parentesco ORDER BY nombre ASC";
              $resultParentesco = mysqli_query($con,$queryParentesco);
              $parentesco = array( array( "id" => $rowParentesco["id_parentesco"], "nombre" => "--Parentesco--" ) );
              while( $rowParentesco = mysqli_fetch_array($resultParentesco) )
              {
                $parentesco[] = array( "id" => $rowParentesco["id_parentesco"], "nombre" => utf8_encode($rowParentesco["nombre"]) );
              }
              $retorno["parentesco"] = $parentesco;

              $retorno["status"] = "OK";
            break;
          case 9:  //Agregar eps empleado
                $query = "INSERT INTO afiliacion_empleado_salud ( empleados_IDEmpleado,
                                                                  salud_id_salud,
                                                                  fecha_radicacion,
                                                                  tipo_tramite_id_tipo_tramite,
                                                                  tipo_afiliacion_id_tipo_afiliacion,
                                                                  tipo_afiliado_id_tipo_afiliado,
                                                                  tipo_cotizante_id_tipo_cotizante,
                                                                  regimen,
                                                                  convicencia,
                                                                  nombre_conyugue
                                                                )
                          VALUES( '". $_POST["id"] ."',
                                  '". $_POST["idEps"] ."',
                                  '". $_POST["fecha_rad"] ."',
                                  '". $_POST["tipoTramite"] ."',
                                  '". $_POST["tipoAfiliacion"] ."',
                                  '". $_POST["tipoAfiliado"] ."',
                                  '". $_POST["tipoCotizante"] ."',
                                  '". $_POST["regimen"] ."',
                                  '". $_POST["convivencia"] ."',
                                  '". $_POST["beneficiario"] ."'
                                )";
                if( mysqli_query($con,$query) )
                {
                  $retorno["status"] = "OK";
                  $retorno["id"] = mysqli_insert_id($con);
                }else{
                  $retorno["status"] = "ERROR";
                  $retorno["msg"] = "Error al realizar el Insert en la BDD: ". mysqli_error($con);
                  $retorno["sql"] = $query;
                }
            break;
          case 10: //consultar eps empleado
              $query = "SELECT * FROM qr_afiliacion_empleado_salud WHERE empleados_IDEmpleado = '". $_POST["id"] ."' "; 
              $result = mysqli_query($con,$query);
              $epsEmpleado = array();
              while( $rowEps = mysqli_fetch_array($result) )
              {
                $epsEmpleado[] = array( 
                                "idEmpleado" => $rowEps["empleados_IDEmpleado"],
                                "IdEps" => $rowEps["id_salud"],
                                "eps" => utf8_encode($rowEps["nombre_salud"]),
                                "fecha" => $rowEps["fecha_radicacion"],
                                "IdTramite" => $rowEps["id_tipo_tramite"],
                                "tramite" => utf8_encode($rowEps["tramite"]),
                                "IdAfiliacion" => $rowEps["id_tipo_afiliacion"],
                                "afiliacion" => utf8_encode($rowEps["tipo_afiliacion"]),
                                "IdAfiliado" => $rowEps["id_tipo_afiliado"],
                                "afiliado" => utf8_encode($rowEps["tipo_afiliado"]),
                                "IdCotizante" => $rowEps["id_tipo_cotizante"],
                                "cotizante" => utf8_encode($rowEps["tipo_cotizante"]),
                                "regimen" => $rowEps["regimen"]
                              );
              }
              $retorno["status"] = "OK";
              $retorno["epsEmpleado"] = $epsEmpleado;
            break;
          case 11: //Actualizar eps               
                  //Verificar q no está registrado
                  $query = "SELECT COUNT(*) FROM afiliacion_empleado_salud WHERE empleados_IDEmpleado='". $_POST["idEmpleado"] ."'";
                  $result = mysqli_query($con,$query);
                  $row = mysqli_fetch_array($result);
                  if( $row[0] > 0 ) //actualiza registrado
                  {
                    $query = "UPDATE afiliacion_empleado_salud SET 
                                                  salud_id_salud= '". $_POST["idEps"] ."', 
                                                  fecha_radicacion= '". $_POST["fecha_rad"] ."', 
                                                  tipo_tramite_id_tipo_tramite= '". $_POST["tipoTramite"] ."', 
                                                  tipo_afiliacion_id_tipo_afiliacion= '". $_POST["tipoAfiliacion"] ."', 
                                                  tipo_afiliado_id_tipo_afiliado= '". $_POST["tipoAfiliado"] ."', 
                                                  tipo_cotizante_id_tipo_cotizante= '". $_POST["tipoCotizante"] ."', 
                                                  regimen= '". $_POST["regimen"] ."'
                          WHERE empleados_IDEmpleado='". $_POST["idEmpleado"] ."' ";
                    if( mysqli_query($con,$query) ){
                      $retorno["status"] = "OK";
                    }
                    else{
                      $retorno["status"] = "ERROR";
                      $retorno["msg"] = "Error al realizar el Insert en la BDD: ". mysqli_error($con);
                    }
                  }
                  else{ //crea nuevo registrado
                    $query = "INSERT INTO afiliacion_empleado_salud (
                                                                    empleados_IDEmpleado,
                                                                    salud_id_salud,
                                                                    fecha_radicacion,
                                                                    tipo_tramite_id_tipo_tramite,
                                                                    tipo_afiliacion_id_tipo_afiliacion,
                                                                    tipo_afiliado_id_tipo_afiliado,
                                                                    tipo_cotizante_id_tipo_cotizante,
                                                                    regimen
                                                                    )
                              VALUES(
                                      '". utf8_decode($_POST["idEmpleado"]) ."',
                                      '". utf8_decode($_POST["idEps"]) ."',
                                      '". utf8_decode($_POST["fecha_rad"]) ."',
                                      '". utf8_decode($_POST["tipoTramite"]) ."',
                                      '". utf8_decode($_POST["tipoAfiliacion"]) ."',
                                      '". utf8_decode($_POST["tipoAfiliado"]) ."',
                                      '". utf8_decode($_POST["tipoCotizante"]) ."',
                                      '". utf8_decode($_POST["regimen"]) ."'
                                    )";
                    if( mysqli_query($con,$query) )
                    {
                      $retorno["status"] = "OK";
                      $retorno["id"] = mysqli_insert_id($con);
                    }
                    else{
                      $retorno["status"] = "ERROR";
                      $retorno["msg"] = "Error al realizar el Insert en la BDD: ". mysqli_error($con);
                    }
                  }
            break;
          case 12: //Agregar arl empleado
                $query = "INSERT INTO afiliacion_empleado_arl ( 
                                                                  empleados_IDEmpleado,
                                                                  arl_id_arl,
                                                                  fecha_afiliacion,
                                                                  codigo_transaccion
                                                                )
                          VALUES(
                                  '". $_POST["id"] ."',
                                  '". $_POST["idArl"] ."',
                                  '". $_POST["fecha_afi"] ."',
                                  '". $_POST["codigoTransaccion"] ."'
                                )";
                if( mysqli_query($con,$query) )
                {
                  $retorno["status"] = "OK";
                  $retorno["id"] = mysqli_insert_id($con);
                }else{
                  $retorno["status"] = "ERROR";
                  $retorno["msg"] = "Error al realizar el Insert en la BDD: ". mysqli_error($con);
                  $retorno["sql"] = $query;
                }
            break;
          case 13: //consultar arl empleado
              $query = "SELECT * FROM qr_afiliacion_empleado_arl WHERE empleados_IDEmpleado = '". $_POST["id"] ."' "; 
              $result = mysqli_query($con,$query);
              $arlEmpleado = array();
              while( $rowArl = mysqli_fetch_array($result) )
              {
                $arlEmpleado[] = array( 
                                "idEmpleado" => $rowArl["empleados_IDEmpleado"],
                                "idArl" => utf8_encode($rowArl["id_arl"]),
                                "arl" => utf8_encode($rowArl["arl"]),
                                "fecha" => $rowArl["fecha_afiliacion"],
                                "codigo" => $rowArl["codigo_transaccion"]
                              );
              }
              $retorno["status"] = "OK";
              $retorno["arlEmpleado"] = $arlEmpleado;
            break;
          case 14: //Actualizar  arl              
                  //Verificar que el correo no está registrado
                  $query = "SELECT COUNT(*) FROM afiliacion_empleado_arl WHERE empleados_IDEmpleado='". $_POST["idEmpleado"] ."'";
                  $result = mysqli_query($con,$query);
                  $row = mysqli_fetch_array($result);
                  if( $row[0] > 0 ) //actualiza registrado
                  {
                    $query = "UPDATE afiliacion_empleado_arl SET 
                                                                arl_id_arl = '". $_POST["idArl"] ."', 
                                                                fecha_afiliacion = '". $_POST["fecha_afi"] ."',
                                                                codigo_transaccion = '". $_POST["codigo"] ."'
                          WHERE empleados_IDEmpleado='". $_POST["idEmpleado"] ."' ";
                    if( mysqli_query($con,$query) )
                    {
                      $retorno["status"] = "OK";
                    }else{
                      $retorno["status"] = "ERROR";
                      $retorno["msg"] = "Error al realizar el Insert en la BDD: ". mysqli_error($con);
                    }
                  }
                  else{ //crea nuevo registrado
                    $query = "INSERT INTO afiliacion_empleado_arl (
                                                                    empleados_IDEmpleado,
                                                                    arl_id_arl,
                                                                    fecha_afiliacion,
                                                                    codigo_transaccion
                                                                    )
                              VALUES(
                                      '". utf8_decode($_POST["idEmpleado"]) ."',
                                      '". utf8_decode($_POST["idArl"]) ."',
                                      '". utf8_decode($_POST["fecha_afi"]) ."',
                                      '". utf8_decode($_POST["codigo"]) ."'
                                    )";
                    if( mysqli_query($con,$query) )
                    {
                      $retorno["status"] = "OK";
                      $retorno["id"] = mysqli_insert_id($con);
                    }else{
                      $retorno["status"] = "ERROR";
                      $retorno["msg"] = "Error al realizar el Insert en la BDD: ". mysqli_error($con);
                    }
                  }
            break;
          case 15: //Agregar pension empleado
                $query = "INSERT INTO afiliacion_empleado_pension ( 
                                                                    empleados_IDEmpleado,
                                                                    pension_id_pension,
                                                                    fecha_afiliacion
                                                                  )
                          VALUES(
                                  '". $_POST["id"] ."',
                                  '". $_POST["idPension"] ."',
                                  '". $_POST["fecha_afi"] ."'
                                )";
                if( mysqli_query($con,$query) )
                {
                  $retorno["status"] = "OK";
                  $retorno["id"] = mysqli_insert_id($con);
                }else{
                  $retorno["status"] = "ERROR";
                  $retorno["msg"] = "Error al realizar el Insert en la BDD: ". mysqli_error($con);
                  $retorno["sql"] = $query;
                }
            break;
          case 16: //consultar pension empleado
              $query = "SELECT * FROM qr_afiliacion_empleado_pension WHERE id_empleado = '". $_POST["id"] ."' "; 
              $result = mysqli_query($con,$query);
              $pensionEmpleado = array();
              while( $rowPension = mysqli_fetch_array($result) )
              {
                $pensionEmpleado[] = array( 
                                            "idEmpleado" => $rowPension["id_empleado"],
                                            "idPension" => utf8_encode($rowPension["id_pension"]),
                                            "pension" => utf8_encode($rowPension["pension"]),
                                            "fecha" => $rowPension["fecha_afiliacion"]
                                          );
              }
              $retorno["status"] = "OK";
              $retorno["pensionEmpleado"] = $pensionEmpleado;
            break;
          case 17: //Actualizar  pension              
                  //Verificar que el correo no está registrado
                  $query = "SELECT COUNT(*) FROM afiliacion_empleado_pension WHERE empleados_IDEmpleado='". $_POST["idEmpleado"] ."'";
                  $result = mysqli_query($con,$query);
                  $row = mysqli_fetch_array($result);
                  if( $row[0] > 0 ) //actualiza registrado
                  {
                    $query = "UPDATE afiliacion_empleado_pension SET 
                                                                      pension_id_pension= '". $_POST["idPension"] ."', 
                                                                      fecha_afiliacion= '". $_POST["fecha_afi"] ."'
                          WHERE empleados_IDEmpleado='". $_POST["idEmpleado"] ."' ";
                    if( mysqli_query($con,$query) )
                    {
                      $retorno["status"] = "OK";
                    }else{
                      $retorno["status"] = "ERROR";
                      $retorno["msg"] = "Error al realizar el Insert en la BDD: ". mysqli_error($con);
                    }
                  }
                  else{ //crea nuevo registrado
                    $query = "INSERT INTO afiliacion_empleado_pension (
                                                                    empleados_IDEmpleado,
                                                                    pension_id_pension,
                                                                    fecha_afiliacion
                                                                    )
                              VALUES(
                                      '". utf8_decode($_POST["idEmpleado"]) ."',
                                      '". utf8_decode($_POST["idPension"]) ."',
                                      '". utf8_decode($_POST["fecha_afi"]) ."'
                                    )";
                    if( mysqli_query($con,$query) )
                    {
                      $retorno["status"] = "OK";
                      $retorno["id"] = mysqli_insert_id($con);
                    }else{
                      $retorno["status"] = "ERROR";
                      $retorno["msg"] = "Error al realizar el Insert en la BDD: ". mysqli_error($con);
                    }
                  }
            break;
          case 18: //Agregar caja empleado
                $query = "INSERT INTO afiliacion_empleado_caja ( 
                                                                    empleados_IDEmpleado,
                                                                    caja_compensacion_familiar_id_caja_compensacion
                                                                  )
                          VALUES(
                                  '". $_POST["id"] ."',
                                  '". $_POST["idCaja"] ."'
                                )";
                if( mysqli_query($con,$query) )
                {
                  $retorno["status"] = "OK";
                  $retorno["id"] = mysqli_insert_id($con);
                }else{
                  $retorno["status"] = "ERROR";
                  $retorno["msg"] = "Error al realizar el Insert en la BDD: ". mysqli_error($con);
                  $retorno["sql"] = $query;
                }
            break;
          case 19: //consultar caja empleado
              $query = "SELECT * FROM qr_afiliacion_empleado_caja WHERE id_empleado = '". $_POST["id"] ."' "; 
              $result = mysqli_query($con,$query);
              $cajaEmpleado = array();
              while( $rowCaja = mysqli_fetch_array($result) )
              {
                $cajaEmpleado[] = array( 
                                        "idEmpleado" => $rowCaja["id_empleado"],
                                        "idCaja" => utf8_encode($rowCaja["id_caja_compensacion"]),
                                        "caja" => utf8_encode($rowCaja["caja_compensacion"])
                                      );
              }
              $retorno["status"] = "OK";
              $retorno["cajaEmpleado"] = $cajaEmpleado;
            break;
          case 20: //Actualizar  caja 
              //Verificar que el correo no está registrado
              $query = "SELECT COUNT(*) FROM afiliacion_empleado_caja WHERE empleados_IDEmpleado='". $_POST["idEmpleado"] ."'";
              $result = mysqli_query($con,$query);
              $row = mysqli_fetch_array($result);
              if( $row[0] > 0 ) //actualiza registrado
              {
                $query = "UPDATE afiliacion_empleado_caja SET caja_compensacion_familiar_id_caja_compensacion= '". $_POST["idCaja"] ."'
                          WHERE empleados_IDEmpleado='". $_POST["idEmpleado"] ."' ";
                if( mysqli_query($con,$query) ){
                  $retorno["status"] = "OK";
                }
                else{
                  $retorno["status"] = "ERROR";
                  $retorno["msg"] = "Error al realizar el Insert en la BDD: ". mysqli_error($con);
                }
              }
              else{ //crea nuevo registrado
                $query = "INSERT INTO afiliacion_empleado_caja (
                                                                empleados_IDEmpleado,
                                                                caja_compensacion_familiar_id_caja_compensacion
                                                                )
                          VALUES(
                                  '". utf8_decode($_POST["idEmpleado"]) ."',
                                  '". utf8_decode($_POST["idCaja"]) ."'
                                )";
                if( mysqli_query($con,$query) )
                {
                  $retorno["status"] = "OK";
                  $retorno["id"] = mysqli_insert_id($con);
                }else{
                  $retorno["status"] = "ERROR";
                  $retorno["msg"] = "Error al realizar el Insert en la BDD: ". mysqli_error($con);
                }
              }
            break;
          case 21: //Agregar referencias_personales
                $query = "INSERT INTO referencias_personales ( 
                                                                empleados_IDEmpleado,
                                                                nombres,
                                                                apellidos,
                                                                telefono,
                                                                parentesco_id_parentesco
                                                              )
                          VALUES(
                                  '". $_POST["id"] ."',
                                  '". $_POST["nombre1"] ."',
                                  '". $_POST["apellido1"] ."',
                                  '". $_POST["telefono1"] ."',
                                  '". $_POST["parentesco1"] ."'
                                ),
                                (
                                  '". $_POST["id"] ."',
                                  '". $_POST["nombre2"] ."',
                                  '". $_POST["apellido2"] ."',
                                  '". $_POST["telefono2"] ."',
                                  '". $_POST["parentesco2"] ."'
                                )";
                if( mysqli_query($con,$query) )
                {
                  $retorno["status"] = "OK";
                  $retorno["id"] = mysqli_insert_id($con);
                }else{
                  $retorno["status"] = "ERROR";
                  $retorno["msg"] = "Error al realizar el Insert en la BDD: ". mysqli_error($con);
                  $retorno["sql"] = $query;
                }
            break;
          case 22: //consultar referencias_personales
              $query = "SELECT * FROM referencias_personales WHERE empleados_IDEmpleado = '". $_POST["id"] ."' "; 
              $result = mysqli_query($con,$query);
              $referenciasEmpleado = array();
              while( $rowContrato = mysqli_fetch_array($result) )
              {
                $query_paren = "SELECT * FROM parentesco ORDER BY nombre ASC";
                $resultParentesco = mysqli_query($con,$query_paren);
                $lista_parentesco = ' ';
                while( $rowParentesco = mysqli_fetch_array($resultParentesco) )
                {
                  $select = $rowContrato["parentesco_id_parentesco"] == $rowParentesco["id_parentesco"] ? 'selected' : '';
                  $lista_parentesco = '<option value="'. $rowParentesco["id_parentesco"] .'" '. $select .'>'. 
                                          utf8_encode($rowParentesco["nombre"]) 
                                          .'</option>';
                }
                $referenciasEmpleado[] = array( 
                                        "idReferencia" => $rowContrato["id_referencias_personales"],
                                        "idEmpleado" => $rowContrato["empleados_IDEmpleado"],
                                        "nombres" => utf8_encode($rowContrato["nombres"]),
                                        "apellidos" => utf8_encode($rowContrato["apellidos"]),
                                        "telefono" => $rowContrato["telefono"],
                                        "parentesco" => $rowContrato["parentesco_id_parentesco"],
                                        "lista_parentesco" => $lista_parentesco 
                                      );
              }
              if ($referenciasEmpleado[0] > 0 )
              {
                $retorno["status"] = "OK";
                $retorno["referenciasEmpleado"] = $referenciasEmpleado;

              }
              else {
                $retorno["status"] = "EMPTY";
                $retorno["msg"] = "Sin Contrato";
              }
            break;
          case 23: //Actualizar  referencias_personales 
              $referencias = $_POST["referencias"];
              for ( $i=0; $i<count($referencias); $i++ )
              {
                $query = "UPDATE referencias_personales SET 
                                                            nombres= '". $referencias[$i]["nombres"] ."',
                                                            apellidos= '". $referencias[$i]["apellidos"] ."',
                                                            telefono= '". $referencias[$i]["telefono"] ."',
                                                            parentesco_id_parentesco= '". $referencias[$i]["parentesco"] ."'
                          WHERE id_referencias_personales='". $referencias[$i]["idReferencia"] ."' ";
                if( mysqli_query($con,$query) )
                {
                  $retorno["status"] = "OK";
                }
                else
                {
                  $retorno["status"] = "ERROR";
                  $retorno["msg"] = "Error al realizar el Insert en la BDD: ". mysqli_error($con);
                }
              }
            break;
          case 24: //Agregar contrato_empleado
                $query = "INSERT INTO contrato_empleado ( 
                                                          empresas_id_empresas,
                                                          cargo,
                                                          salario,
                                                          jornada,
                                                          servicio_funerario,
                                                          bancos_id_bancos,
                                                          nro_cuenta,
                                                          tipo_cuenta_id_tipo_cuenta,
                                                          empleados_IDEmpleado
                                                        )
                          VALUES(
                                  '". $_POST["empresa"] ."',
                                  '". $_POST["cargo"] ."',
                                  '". $_POST["salario"] ."',
                                  '". $_POST["jornada"] ."',
                                  '". $_POST["servicioFunerario"] ."',
                                  '". $_POST["banco"] ."',
                                  '". $_POST["cuenta"] ."',
                                  '". $_POST["tipoCuenta"] ."',
                                  '". $_POST["id"] ."'
                                )";
                if( mysqli_query($con,$query) ){
                  $retorno["status"] = "OK";
                  $retorno["id"] = mysqli_insert_id($con);
                }
                else{
                  $retorno["status"] = "ERROR";
                  $retorno["msg"] = "Error al realizar el Insert en la BDD: ". mysqli_error($con);
                  $retorno["sql"] = $query;
                }
            break;
          case 25: //consultar contrato_empleado
              $query = "SELECT * FROM contrato_empleado WHERE empleados_IDEmpleado = '". $_POST["id"] ."' "; 
              $result = mysqli_query($con,$query);
              $contratoEmpleado = array();
              while( $rowContrato = mysqli_fetch_array($result) ){
                $contratoEmpleado[] = array( 
                                            "empresa" => $rowContrato["empresas_id_empresas"],
                                            "cargo" => $rowContrato["cargo"],
                                            "salario" => utf8_encode($rowContrato["salario"]),
                                            "jornada" => utf8_encode($rowContrato["jornada"]),
                                            "servicioFunerario" => $rowContrato["servicio_funerario"],
                                            "banco" => $rowContrato["bancos_id_bancos"],
                                            "cuenta" => $rowContrato["nro_cuenta"],
                                            "tipoCuenta" => $rowContrato["tipo_cuenta_id_tipo_cuenta"],
                                            "idEmpleado" => $rowContrato["empleados_IDEmpleado"]
                                          );
              }
              $retorno["status"] = "OK";
              $retorno["contratoEmpleado"] = $contratoEmpleado;
            break;
          case 26: //Actualizar  Contrato 
              $query = " UPDATE contrato_empleado SET  empresas_id_empresas = '". $_POST["empresa"] ."',
                                                      cargo = '". $_POST["cargo"] ."',
                                                      salario = '". $_POST["salario"] ."',
                                                      jornada = '". $_POST["jornada"] ."',
                                                      servicio_funerario = '". $_POST["servicioFunerario"] ."',
                                                      bancos_id_bancos = '". $_POST["banco"] ."',
                                                      nro_cuenta = '". $_POST["cuenta"] ."',
                                                      tipo_cuenta_id_tipo_cuenta = '". $_POST["tipoCuenta"] ."'
                        WHERE empleados_IDEmpleado='". $_POST["idEmpleado"] ."' ";
                if( mysqli_query($con,$query) )
                {
                  $retorno["status"] = "OK";
                }
                else
                {
                  $retorno["status"] = "ERROR";
                  $retorno["msg"] = "Error al realizar el Insert en la BDD: ". mysqli_error($con);
                }
            break;
        }
        //Close BD Connection
        if( !close_bd($con) )
        {
          $retorno["msg"] = "WARNING: Fallo al cerrar la conexión BDD";
        }
      }else //Error en conexion
      {
        $retorno["status"] = "ERROR";
        $retorno["msg"] = "Error en la conexión a la BDD:". mysqli_connect_error();
      }
    }else{
      $retorno["status"] = "EXPIRED";
      $retorno["msg"] = "La sesión exipiró:";
    }
  }
  else
  {
    $retorno["status"] = "ERROR";
    $retorno["msg"] = "No se encontraron parámetros POST";
  }
  header('Content-Type: application/json; charset=utf-8');
  echo json_encode( $retorno );
?>
