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
          case 1://Consultar productos
              $query = "SELECT * FROM productos ORDER BY id_productos ASC";
              $result = mysqli_query($con,$query);
              $productos = array();
              while( $row = mysqli_fetch_array($result) )
              {
                $productos[] = array(
                                      "id" => $row["id_productos"],
                                      "titulo" => utf8_encode( $row["titulo"] ),
                                      "descripcion" => empty( $row["descripcion"] ) ? "" : utf8_encode( $row["descripcion"] ),
                                      "precio" => $row["precio"],
                                      "imagen" => empty( $row["imagen"] ) ? "null" : $row["imagen"]
                                    );
              }
              $retorno["status"] = "OK";
              $retorno["productos"] = $productos;
            break;
          case 2://Insertar nuevo producto
              if( empty($_FILES["new_imagen"]) )
              {
                $retorno["status"] = "ERROR";
                $retorno["msg"] = "Parámetro new_imagen no presnete o vacío";
              }else
              {
                $img_64 = base64_encode(file_get_contents($_FILES['new_imagen']['tmp_name']));
                if( $img_64 )
                {
                  $query = "INSERT INTO productos (titulo,descripcion,precio,imagen)
                            VALUES('". utf8_decode($_POST["new_titulo"]) ."','". utf8_decode($_POST["new_titulo"]) ."','". $_POST["new_precio"] ."'
                            ,'". $img_64 ."')";
                  if( mysqli_query($con,$query) )
                  {
                    $retorno["status"] = "OK";
                    $retorno["id"] = mysqli_insert_id($con);
                  }else{
                    $retorno["status"] = "ERROR";
                    $retorno["msg"] = "Error al realizar el Insert en la BDD: ". mysqli_error($con);
                  }
                }else{
                  $retorno["status"] = "ERROR";
                  $retorno["msg"] = "Error al codificar la imagen a String64";
                }
              }
            break;
          case 3://Actualizar producto
              $query = "UPDATE productos SET titulo=?,descripcion=?,precio=?,imagen=? WHERE id_productos=?";
              $id = $_POST["id"];
              $titulo = utf8_decode( $_POST["titulo"] );
              $desc = empty( $_POST["descripcion"] ) ? null : utf8_decode( $_POST["descripcion"] );
              $precio = utf8_decode( $_POST["precio"] );
              $imagen = empty( $_POST["imagen"] ) ? null : utf8_decode( $_POST["imagen"] );
              $st = $con->prepare($query); //Statement
              if( $st )
              {
                $param = $st->bind_param("ssssi", $titulo, $desc, $precio, $imagen, $id );
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
          case 4://Eliminar producto
              $query = "DELETE FROM productos WHERE id_productos='". $_POST["id"] ."'";
              if( mysqli_query($con,$query) )
              {
                $retorno["status"] = "OK";
              }else{
                $retorno["status"] = "ERROR";
                $retorno["msg"] = "Error al borrar el producto: ". mysqli_error($con);
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
