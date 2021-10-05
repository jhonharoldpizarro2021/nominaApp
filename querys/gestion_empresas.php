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
          case 1:
              //Consultar paises
              $queryPaises = "SELECT * FROM pais ORDER BY nombre ASC";
              $resultPaises = mysqli_query($con,$queryPaises);
              $paises = array( array( "id" => $rowPaises["id_pais"], "nombre" => "--Pais--" ) );
              while( $rowPaises = mysqli_fetch_array($resultPaises) )
              {
                $paises[] = array( "id" => $rowPaises["id_pais"], "nombre" => utf8_encode($rowPaises["nombre"]) );
              }
              $retorno["paises"] = $paises;
              // Consultar deptos
              $queryDepto = "SELECT * FROM departamento ORDER BY nombre ASC";
              $resultDepto = mysqli_query($con,$queryDepto);
              $departamentos = array( array( "id" => $rowDepto["id_departamento"], "nombre" => "--Departamento--" ) );
              while( $rowDepto = mysqli_fetch_array($resultDepto) )
              {
                $departamentos[] = array( "id" => $rowDepto["id_departamento"], "nombre" => utf8_encode($rowDepto["nombre"]) );
              }
              $retorno["departamentos"] = $departamentos;
              //Consultar ciudades
              $queryCiudades = "SELECT * FROM ciudad ORDER BY nombre ASC";
              $resultCiudades = mysqli_query($con,$queryCiudades);
              $ciudades = array( array( "id" => $rowCiudades["id_ciudad"], "nombre" => "--Ciudad--" ) );
              while( $rowCiudades = mysqli_fetch_array($resultCiudades) )
              {
                $ciudades[] = array( "id" => $rowCiudades["id_ciudad"], "nombre" => utf8_encode($rowCiudades["nombre"]) );
              }
              $retorno["ciudades"] = $ciudades;

              $retorno["status"] = "OK";
              
            break;
          case 2: //Agregar nuevo empresa
              //Verificar  no está registrada
              $query = "SELECT COUNT(*) FROM empresas WHERE nit='". $_POST["nit"] ."'";
              $result = mysqli_query($con,$query);
              $row = mysqli_fetch_array($result);

              if( $row[0] > 0 ) //ya esta registrada
              {
                $retorno["status"] = "EXIST";
                $retorno["msg"] = "Empresa Registrada";
              }else
              {
                $query = "INSERT INTO empresas(
                                                nit,
                                                nombre,
                                                direccion,
                                                telefono,
                                                email,
                                                ciudad_id_ciudad
                                              )
                          VALUES(
                                  '". $_POST["nit"] ."',
                                  '". utf8_decode($_POST["nombre"]) ."',
                                  '". utf8_decode($_POST["direccion"]) ."',
                                  '". $_POST["telefono"] ."',
                                  '". $_POST["email"] ."',
                                  '". $_POST["ciudad"] ."'
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
          case 3: //Actualizar empresa
              //Verificar que el correo no está registrado
              $query = "UPDATE empresas SET    
                                                nit               =   '". $_POST["nit"] ."',
                                                nombre            =   '". utf8_decode($_POST["nombre"]) ."', 
                                                direccion         =   '". utf8_decode($_POST["direccion"]) ."', 
                                                telefono          =   '". $_POST["telefono"] ."',
                                                email             =   '". $_POST["correo"] ."', 
                                                ciudad_id_ciudad  =   '". utf8_decode($_POST["ciudad"]) ."'
                          WHERE id_empresas = '". $_POST["id"] ."'";
                if( mysqli_query($con,$query) )
                {
                  $retorno["status"] = "OK";
                }else{
                  $retorno["status"] = "ERROR";
                  $retorno["msg"] = "Error al realizar el Insert en la BDD: ". mysqli_error($con);
                }
            break;
          case 4: //Consultar empresas
              $query = "SELECT * FROM qr_empresas_ciudad ORDER BY nombre ASC";
              $result = mysqli_query($con,$query);
              $empresas = array();
              while( $row = mysqli_fetch_array($result) )
              {
                $empresas[] = array(
                                      "id" => $row["id_empresas"],
                                      "nit" => $row["nit"],
                                      "nombre" => utf8_encode( $row["nombre"] ),
                                      "direccion" => utf8_encode( $row["direccion"] ),
                                      "telefono" => $row["telefono"],
                                      "email" => $row["email"],
                                      "ciudad" => $row["id_ciudad"],
                                      "nCiudad" => $row["ciudad"]
                                    );
              }
              $retorno["status"] = "OK";
              $retorno["empresas"] = $empresas;
            break;
          case 5://Eliminar empresa
              $query = "DELETE FROM empresas WHERE id_empresas='". $_POST["id"] ."'";
              if( mysqli_query($con,$query) )
              {
                $retorno["status"] = "OK";
              }else{
                $retorno["status"] = "ERROR";
                $retorno["msg"] = "Error al borrar el empresa: ". mysqli_error($con);
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
  }else
  {
    $retorno["status"] = "ERROR";
    $retorno["msg"] = "No se encontraron parámetros POST";
  }
  header('Content-Type: application/json; charset=utf-8');
  echo json_encode( $retorno );
?>
