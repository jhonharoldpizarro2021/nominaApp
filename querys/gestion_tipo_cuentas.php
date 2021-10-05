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
              $query = "SELECT COUNT(*) FROM tipo_cuenta WHERE nombre='". $_POST["nombre"] ."'";
              $result = mysqli_query($con,$query);
              $row = mysqli_fetch_array($result);

              if( $row[0] > 0 ) //El correo ya se encuentra registrado
              {
                $retorno["status"] = "EXIST";
                $retorno["msg"] = "Parentesco ya Existe";
              }
              else
              {
                $query = "INSERT INTO tipo_cuenta (nombre,descripcion)
                          VALUES('". utf8_decode($_POST["nombre"]) ."','". utf8_decode($_POST["descripcion"]) ."')";
                if( mysqli_query($con,$query) ) {
                  $retorno["status"] = "OK";
                  $retorno["id"] = mysqli_insert_id($con);
                }
                else{
                  $retorno["status"] = "ERROR";
                  $retorno["msg"] = "Error al realizar el Insert en la BDD: ". mysqli_error($con);
                }
              }
            break;
          case 2: //Consultar 
              $query = "SELECT * FROM tipo_cuenta ORDER BY nombre ASC";
              $result = mysqli_query($con,$query);
              $tipo_cuenta = array();
              while( $row = mysqli_fetch_array($result) )
              {
                $tipo_cuenta[] = array(
                                "id" => $row["id_tipo_cuenta"],
                                "nombre" => utf8_encode( $row["nombre"] ),
                                "descripcion" => utf8_encode( $row["descripcion"] )
                              );
              }
              $retorno["status"] = "OK";
              $retorno["tipo_cuenta"] = $tipo_cuenta;
            break;
          case 3: //Actualizar tipo de cuenta
              //Verificar que el correo no está registrado
              $query = "SELECT COUNT(*) FROM tipo_cuenta WHERE nombre='". $_POST["nombre"] ."' AND id_tipo_cuenta!='". $_POST["id"] ."'";
              $result = mysqli_query($con,$query);
              $row = mysqli_fetch_array($result);

              if( $row[0] > 0 ) //El correo ya se encuentra registrado
              {
                $retorno["status"] = "EXIST";
                $retorno["msg"] = "Tipo Cuenta registrada";
              }
              else
              {
                $query = "UPDATE tipo_cuenta SET nombre='". utf8_decode($_POST["nombre"]) ."' , descripcion='". utf8_decode($_POST["descripcion"]) ."' WHERE id_tipo_cuenta='". $_POST["id"] ."'";
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
          case 4://Eliminar Tipo de Documento
              $query = "DELETE FROM tipo_cuenta WHERE id_tipo_cuenta='". $_POST["id"] ."'";
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
