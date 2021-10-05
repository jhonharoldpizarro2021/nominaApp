<?php
  $KEY_ENCRYPT_PASS = 'cO!3v7$s5@2'; //Key de encryptación para contraseñas
  /**
  * Función encargada de iniciar la conexión a la BDD,
  * Para evaluar errores se puede utilizar isErrorConexionBDD( $con )
  * @return Objecto conexión msqli
  */
  function start_connect()
  {
    $host = "contrat.db.8336710.hostedresource.com";
  	$user = "contrat";
  	$pass = "x4221526Z#";
  	$bd = "contrat";

  	return mysqli_connect($host,$user,$pass,$bd);
  }

  /**
  * Función encargada de cerrar la conexión a la BDD,
  * Para evaluar errores se puede utilizar isErrorConexionBDD( $con )
  * @return Objecto conexión msqli
  */
  function close_bd($con)
  {
    return mysqli_close($con);
  }

  /**
  * Función encargada de enviar correo electrónico utilizando PHPMailer
  * @param $to Array correos electrónicos destino, requerido
  * @param $cc Array correos electrónicos copia, ingresar null si no se desa usar
  * @param $subject Asunto del correo
  * @param $msg Contenido del mensaje, puede ser HTML
  * @return array
  */
  function enviar_correo($to,$cc,$msg,$subject)
  {
    $retorno = array();
    if( file_exists("phpmailer/PHPMailerAutoload.php") )
    {
      require_once("phpmailer/PHPMailerAutoload.php");
      $mail = new PHPMailer();
      $mail->IsSMTP();
      $mail->SMTPAuth = true;
      $mail->Host = "mail.intuitiva.com.co"; // Servidor saliente SMTP
      $mail->Username = "webmaster@intuitiva.com.co";
      $mail->Password = "qG7#TPfujNgZFDKh";
      $mail->Port = 2525;
      $mail->CharSet = "UTF­-8";
      $mail->AddReplyTo("webmaster@cooleventsgroup.com", "Cool Events Group");
      //Agregar destinatarios
      foreach ($to as $i => $value)
      {
        $mail->AddAddress( $to[$i] );
      }
      //Agregar copias (CC)
      if( $cc != null )
      {
        foreach ($cc as $i => $value)
        {
          $mail->AddCC( $cc[$i] );
        }
      }
      $mail->setFrom("webmaster@intuitiva.com.co", "Cool Events Group");
      $mail->IsHTML(true);
      $mail->Subject = utf8_encode("=?UTF-8?B?". base64_encode( $subject ) ."?="); //Codificado en UTF-8
      $mensaje = $msg;
      $mail->Body= $mensaje;

      if( $mail->Send() )
      {
        $retorno["status"] = "OK";
      }else{
        $retorno["status"] = "ERROR";
        $retorno["msg"] = "". $mail->ErrorInfo;
      }
    }else{
      $retorno["status"] = "ERROR";
      $retorno["msg"] = "Libreria PhpMailer no existe";
    }
    return $retorno;
  }

  /**
  * Función encargada de enviar correo electrónico utilizando PHPMailer,
  * $from y $from_name será utilizados tambien como reply
  * @param $from correo electrónico origen, requerido
  * @param $from_name nombre origen, requerido
  * @param $to Array correos electrónicos destino, requerido
  * @param $cc Array correos electrónicos copia, ingresar null si no se desa usar
  * @param $subject Asunto del correo
  * @param $msg Contenido del mensaje, puede ser HTML
  * @return array
  */
  function enviar_correo_desde($from,$from_name,$to,$cc,$msg,$subject)
  {
    $retorno = array();
    if( file_exists("phpmailer/PHPMailerAutoload.php") )
    {
      require_once("phpmailer/PHPMailerAutoload.php");
      $mail = new PHPMailer();
      $mail->IsSMTP();
      $mail->SMTPAuth = true;
      $mail->Host = "mail.cooleventsgroup.com"; // Servidor saliente SMTP
      $mail->Username = "webmaster@cooleventsgroup.com";
      $mail->Password = "qG7#TPfujNgZFDKh";
      $mail->Port = 2525;
      $mail->CharSet = "UTF­-8";
      $mail->AddReplyTo($from, $from_name);
      //Agregar destinatarios
      foreach ($to as $i => $value)
      {
        $mail->AddAddress( $to[$i] );
      }
      //Agregar copias (CC)
      if( $cc != null )
      {
        foreach ($cc as $i => $value)
        {
          $mail->AddCC( $cc[$i] );
        }
      }
      $mail->setFrom($from, $from_name);
      $mail->IsHTML(true);
      $mail->Subject = utf8_encode("=?UTF-8?B?". base64_encode( $subject ) ."?="); //Codificado en UTF-8
      $mensaje = $msg;
      $mail->Body= $mensaje;

      if( $mail->Send() )
      {
        $retorno["status"] = "OK";
      }else{
        $retorno["status"] = "ERROR";
        $retorno["msg"] = "". $mail->ErrorInfo;
      }
    }else{
      $retorno["status"] = "ERROR";
      $retorno["msg"] = "Libreria PhpMailer no existe";
    }
    return $retorno;
  }

  /**
  * Funcion encargada de validar inactividad de session y expirar o actualizar
  * @return true | false
  */
	function session_valida()
	{
    $retorno = false;
		$t_minimo = 60 * 60; //Tiempo válido de inactividad 60 minutos
		if( isset( $_SESSION["tiempo_activo"] ) )
		{
			$t_transcurrido = time() - $_SESSION["tiempo_activo"];
			if( $t_transcurrido > $t_minimo )
			{
        $retorno = false;
				// header("Location:". get_site_url() ."/cerrar_sesion.php");
			}else{
				$_SESSION["tiempo_activo"] = time();
        $retorno = true;
			}
		}
    return $retorno;
	}
?>
