<?php
  session_start();
  ob_start();
  $retorno = array();
  if( $_POST )
  {
    include "../functions.php";
    $con = start_connect();
    if( $con ) //Conexion establecida
    {
      $query = "SELECT * FROM usuarios WHERE password=AES_ENCRYPT('". $_REQUEST["pass"] ."','". $GLOBALS["KEY_ENCRYPT_PASS"] ."') AND correo='". $_REQUEST["user"] ."'";
  		$result = mysqli_query($con,$query);
  		$row = mysqli_fetch_array($result);
  		if( $row )
  		{
        //Iniciar variables de session
        $_SESSION["tiempo_activo"] = time();
        $_SESSION["id_usuario"] = $row["id_usuarios"];
        $retorno["status"] = "OK";
  		}else{
        $retorno["status"] = "INVALID";
        $retorno["msg"] = "Usuario/Contraseña incorrectos";
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
  }else
  {
    $retorno["status"] = "ERROR";
    $retorno["msg"] = "No se encontraron parámetros POST";
  }
  header('Content-Type: application/json; charset=utf-8');
  echo json_encode( $retorno );
?>
