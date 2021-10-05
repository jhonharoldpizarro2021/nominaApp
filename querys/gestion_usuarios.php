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
          case 1://Consultar perfiles
              $query = "SELECT * FROM perfil_usuarios ORDER BY nombre ASC";
              $result = mysqli_query($con,$query);
              $perfiles = array( array( "id" => $row["id_perfil_usuarios"], "nombre" => "--Perfil--" ) );
              while( $row = mysqli_fetch_array($result) )
              {
                $perfiles[] = array( "id" => $row["id_perfil_usuarios"], "nombre" => utf8_encode($row["nombre"]) );
              }
              $retorno["status"] = "OK";
              $retorno["perfiles"] = $perfiles;
            break;
          case 2: //Agregar nuevo usuario
              //Verificar que el correo no está registrado
              $query = "SELECT COUNT(*) FROM usuarios WHERE correo='". $_POST["correo"] ."'";
              $result = mysqli_query($con,$query);
              $row = mysqli_fetch_array($result);

              if( $row[0] > 0 ) //El correo ya se encuentra registrado
              {
                $retorno["status"] = "EXIST";
                $retorno["msg"] = "Correo electrónico registrado";
              }else
              {
                $query = "INSERT INTO usuarios(nombre, apellidos, telefono, correo, ciudad, password, perfil, fecha_nacimiento)
                          VALUES('". utf8_decode($_POST["nombre"]) ."','". utf8_decode($_POST["apellidos"]) ."','". $_POST["telefono"] ."','". $_POST["correo"] ."',
                          '". utf8_decode($_POST["ciudad"]) ."',AES_ENCRYPT('". $_POST["password"] ."','". $GLOBALS["KEY_ENCRYPT_PASS"] ."'),'". $_POST["perfil"] ."',
                          '". $_POST["fecha"] ."')";
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
          case 3: //Actualizar usuario
              //Verificar que el correo no está registrado
              $query = "SELECT COUNT(*) FROM usuarios WHERE correo='". $_POST["correo"] ."' AND id_usuarios!='". $_POST["id_user"] ."'";
              $result = mysqli_query($con,$query);
              $row = mysqli_fetch_array($result);

              if( $row[0] > 0 ) //El correo ya se encuentra registrado
              {
                $retorno["status"] = "EXIST";
                $retorno["msg"] = "Correo electrónico registrado";
              }else
              {
                $query = "UPDATE usuarios SET nombre='". utf8_decode($_POST["nombre"]) ."', apellidos='". utf8_decode($_POST["apellidos"]) ."', telefono='". $_POST["telefono"] ."',
                          correo='". $_POST["correo"] ."', ciudad='". utf8_decode($_POST["ciudad"]) ."', password=AES_ENCRYPT('". $_POST["password"] ."','". $GLOBALS["KEY_ENCRYPT_PASS"] ."'),
                           perfil='". $_POST["perfil"] ."', fecha_nacimiento='". $_POST["fecha"] ."' WHERE id_usuarios='". $_POST["id_user"] ."'";
                if( mysqli_query($con,$query) )
                {
                  $retorno["status"] = "OK";
                }else{
                  $retorno["status"] = "ERROR";
                  $retorno["msg"] = "Error al realizar el Insert en la BDD: ". mysqli_error($con);
                }
              }
            break;
          case 4: //Consultar usuarios
              $query = "SELECT id_usuarios,nombre,apellidos,correo,telefono,id_perfil,perfil,ciudad,fecha_nacimiento,
                        AES_DECRYPT(password,'". $GLOBALS["KEY_ENCRYPT_PASS"] ."') AS password FROM qr_usuarios_perfiles ORDER BY id_usuarios ASC";
              $result = mysqli_query($con,$query);
              $usuarios = array();
              while( $row = mysqli_fetch_array($result) )
              {
                $usuarios[] = array(
                                      "id" => $row["id_usuarios"],
                                      "nombres" => utf8_encode( $row["nombre"] ),
                                      "apellidos" => utf8_encode( $row["apellidos"] ),
                                      "telefono" => $row["telefono"],
                                      "correo" => $row["correo"],
                                      "ciudad" => utf8_encode( $row["ciudad"] ),
                                      "id_perfil" => $row["id_perfil"],
                                      "perfil" => utf8_encode( $row["perfil"] ),
                                      "fecha" => $row["fecha_nacimiento"],
                                      "password" => $row["password"]
                                    );
              }
              $retorno["status"] = "OK";
              $retorno["usuarios"] = $usuarios;
            break;
          case 5://Eliminar usuario
              $query = "DELETE FROM usuarios WHERE id_usuarios='". $_POST["id_user"] ."'";
              if( mysqli_query($con,$query) )
              {
                $retorno["status"] = "OK";
              }else{
                $retorno["status"] = "ERROR";
                $retorno["msg"] = "Error al borrar el usuario: ". mysqli_error($con);
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
