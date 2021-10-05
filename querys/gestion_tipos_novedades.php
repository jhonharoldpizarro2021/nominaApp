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
          case 1://Consultar tipo de novedades
              $query = "SELECT * FROM tipo_novedad ORDER BY id_tipo_novedad ASC";
              $result = mysqli_query($con,$query);
              $novedades = array();
              while( $row = mysqli_fetch_array($result) )
              {
                $novedades[] = array(
                                      "id" => $row["id_tipo_novedad"],
                                      "nombre" => utf8_encode( $row["nombre"] ),
                                      "descripcion" => empty( $row["descripcion"] ) ? "" : utf8_encode( $row["descripcion"] )
                                    );
              }
              $retorno["status"] = "OK";
              $retorno["novedades"] = $novedades;
            break;
          case 2://Insertar nuevo tipo de novedad
              $query = "INSERT INTO tipo_novedad (nombre,descripcion) VALUES(?,?)";
              $nombre = utf8_decode( $_POST["nombre"] );
              $desc = empty( $_POST["descripcion"] ) ? null : utf8_decode( $_POST["descripcion"] );
              $st = $con->prepare($query); //Statement
              if( $st )
              {
                $param = $st->bind_param("ss", $nombre, $desc );
                if( $param )
                {
                  if( $st->execute() )
                  {
                    $retorno["status"] = "OK";
                    $retorno["id"] = $st->insert_id;
                  }else{
                    $retorno["status"] = "ERROR";
                    $retorno["msg"] = "Error al ejecutar la sentencia:". $st->errno .":". $st->error;
                  }
                }else{
                  $retorno["status"] = "ERROR";
                  $retorno["msg"] = "Error al vincular los parametros:". $st->errno .":". $st->error;
                }
              }else
              {
                $retorno["status"] = "ERROR";
                $retorno["msg"] = "Error al preparar la sentencia:". mysqli_connect_error();
              }
            break;
          case 3://Actualizar tipo de novedad
              $query = "UPDATE tipo_novedad SET nombre=?,descripcion=? WHERE id_tipo_novedad=?";
              $id = $_POST["id"];
              $nombre = utf8_decode( $_POST["nombre"]) ;
              $desc = empty( $_POST["descripcion"] ) ? null : utf8_decode( $_POST["descripcion"] );
              $st = $con->prepare($query); //Statement
              if( $st )
              {
                $param = $st->bind_param("ssi", $nombre, $desc, $id );
                if( $param )
                {
                  if( $st->execute() )
                  {
                    $retorno["status"] = "OK";
                  }else{
                    $retorno["status"] = "ERROR";
                    $retorno["msg"] = "Error al ejecutar la sentencia:". $st->errno .":". $st->error;
                  }
                }else{
                  $retorno["status"] = "ERROR";
                  $retorno["msg"] = "Error al vincular los parametros:". $st->errno .":". $st->error;
                }
              }else
              {
                $retorno["status"] = "ERROR";
                $retorno["msg"] = "Error al preparar la sentencia:". mysqli_connect_error();
              }
            break;
          case 4://Eliminar tipo de novedad
              $query = "DELETE FROM tipo_novedad WHERE id_tipo_novedad='". $_POST["id"] ."'";
              if( mysqli_query($con,$query) )
              {
                $retorno["status"] = "OK";
              }else{
                $retorno["status"] = "ERROR";
                $retorno["msg"] = "Error al borrar el tipo de novedad: ". mysqli_error($con);
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
