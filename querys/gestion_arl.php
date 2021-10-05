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
              $query = "SELECT COUNT(*) FROM arl WHERE nombre='". $_POST["arl"] ."'";
              $result = mysqli_query($con,$query);
              $row = mysqli_fetch_array($result);

              if( $row[0] > 0 ) //El correo ya se encuentra registrado
              {
                $retorno["status"] = "EXIST";
                $retorno["msg"] = "Etnia ya Existe";
              }else
              {
                $query = "INSERT INTO arl (nombre)
                          VALUES('". utf8_decode($_POST["arl"]) ."')";
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
          case 2: //Consultar tipos documento
              $query = "SELECT * FROM arl ORDER BY nombre ASC";
              $result = mysqli_query($con,$query);
              $arl = array();
              while( $row = mysqli_fetch_array($result) )
              {
                $arl[] = array(
                                "id" => $row["id_arl"],
                                "nombre" => utf8_encode( $row["nombre"] )
                              );
              }
              $retorno["status"] = "OK";
              $retorno["arl"] = $arl;
            break;
          case 3: //Actualizar usuario
              //Verificar que el correo no está registrado
              $query = "SELECT COUNT(*) FROM arl WHERE nombre='". $_POST["nombre"] ."' AND id_arl!='". $_POST["id_arl"] ."'";
              $result = mysqli_query($con,$query);
              $row = mysqli_fetch_array($result);

              if( $row[0] > 0 ) //El correo ya se encuentra registrado
              {
                $retorno["status"] = "EXIST";
                $retorno["msg"] = "Banco registrado";
              }else
              {
                $query = "UPDATE arl SET nombre='". utf8_decode($_POST["nombre"]) ."' WHERE id_arl='". $_POST["id_arl"] ."'";
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
              $query = "DELETE FROM arl WHERE id_arl='". $_POST["id_arl"] ."'";
              if( mysqli_query($con,$query) )
              {
                $retorno["status"] = "OK";
              }else{
                $retorno["status"] = "ERROR";
                $retorno["msg"] = "Error al borrar el Banco: ". mysqli_error($con);
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
