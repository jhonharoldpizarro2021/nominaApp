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
          case 1: //Agregar nuevo usuarios
              //Verificar que el correo no está registrado
              $query = "SELECT COUNT(*) FROM parentesco WHERE nombre='". $_POST["nombre"] ."'";
              $result = mysqli_query($con,$query);
              $row = mysqli_fetch_array($result);

              if( $row[0] > 0 ) //El correo ya se encuentra registrado
              {
                $retorno["status"] = "EXIST";
                $retorno["msg"] = "Parentesco ya Existe";
              }else
              {
                $query = "INSERT INTO parentesco (nombre,descripcion)
                          VALUES('". utf8_decode($_POST["nombre"]) ."','". utf8_decode($_POST["descripcion"]) ."')";
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
          case 2: //Consultar 
              $query = "SELECT * FROM parentesco ORDER BY nombre ASC";
              $result = mysqli_query($con,$query);
              $parentesco = array();
              while( $row = mysqli_fetch_array($result) )
              {
                $parentesco[] = array(
                                "id" => $row["id_parentesco"],
                                "nombre" => utf8_encode( $row["nombre"] ),
                                "descripcion" => utf8_encode( $row["descripcion"] )
                              );
              }
              $retorno["status"] = "OK";
              $retorno["parentesco"] = $parentesco;
            break;
          case 3: //Actualizar usuario
              //Verificar que el correo no está registrado
              $query = "SELECT COUNT(*) FROM parentesco WHERE nombre='". $_POST["nombre"] ."' AND id_parentesco!='". $_POST["id_parentesco"] ."'";
              $result = mysqli_query($con,$query);
              $row = mysqli_fetch_array($result);

              if( $row[0] > 0 ) //El correo ya se encuentra registrado
              {
                $retorno["status"] = "EXIST";
                $retorno["msg"] = "Estrato registrado";
              }else
              {
                $query = "UPDATE parentesco SET nombre='". utf8_decode($_POST["nombre"]) ."' , descripcion='". utf8_decode($_POST["descripcion"]) ."' WHERE id_parentesco='". $_POST["id_parentesco"] ."'";
                if( mysqli_query($con,$query) )
                {
                  $retorno["status"] = "OK";
                }else{
                  $retorno["status"] = "ERROR";
                  $retorno["msg"] = "Error al realizar el Insert en la BDD: ". mysqli_error($con);
                }
              }
            break; 
          case 4://Eliminar Tipo de Documento
              $query = "DELETE FROM parentesco WHERE id_parentesco='". $_POST["id_parentesco"] ."'";
              if( mysqli_query($con,$query) )
              {
                $retorno["status"] = "OK";
              }else{
                $retorno["status"] = "ERROR";
                $retorno["msg"] = "Error al borrar el Estrato: ". mysqli_error($con);
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
