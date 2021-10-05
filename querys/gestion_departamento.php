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
          case 1://Abrir y consultar 
              $query = "SELECT * FROM pais ORDER BY nombre ASC";
              $result = mysqli_query($con,$query);
              $paises = array( array( "id" => $row["id_pais"], "nombre" => "--Pais--" ) );
              while( $row = mysqli_fetch_array($result) )
              {
                $paises[] = array( "id" => $row["id_pais"], "nombre" => utf8_encode($row["nombre"]) );
              }
              $retorno["paises"] = $paises;
              $retorno["status"] = "OK";
            break;
          case 2: //guardar nuevo 
              //Verificar que  no está registrado
              $query = "SELECT COUNT(*) FROM departamento WHERE nombre='". $_POST["departamento"] ."'";
              $result = mysqli_query($con,$query);
              $row = mysqli_fetch_array($result);

              if( $row[0] > 0 ) //El departamento ya se encuentra registrado
              {
                $retorno["status"] = "EXIST";
                $retorno["msg"] = "Departamento registrado";
              }else
              {
                $query = "INSERT INTO departamento (nombre,pais_id_pais)
                          VALUES('". utf8_decode($_POST["departamento"]) ."','". $_POST["pais"] ."')";
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
          case 3: //Editar 
              //Verificar que el correo no está registrado
              $query = "SELECT COUNT(*) FROM departamento WHERE nombre='". utf8_decode($_POST["nombre"]) ."' AND id_departamento!='". $_POST["id_departamento"] ."'";
              $result = mysqli_query($con,$query);
              $row = mysqli_fetch_array($result);

              if( $row[0] > 0 ) //El correo ya se encuentra registrado
              {
                $retorno["status"] = "EXIST";
                $retorno["msg"] = "Departamento registrado";
              }else
              {
                $query = "UPDATE departamento SET nombre='". utf8_decode($_POST["nombre"]) ."', pais_id_pais='". $_POST["pais"] ."' WHERE id_departamento='". $_POST["id_departamento"] ."'";
                if( mysqli_query($con,$query) )
                {
                  $retorno["status"] = "OK";
                }else{
                  $retorno["status"] = "ERROR";
                  $retorno["msg"] = "Error al realizar el Insert en la BDD: ". mysqli_error($con);
                }
              }
            break;
          case 4: //recargar datos
              $query = "SELECT * FROM qr_departamento_pais ORDER BY id_departamento ASC";
              $result = mysqli_query($con,$query);
              $departamento = array();
              while( $row = mysqli_fetch_array($result) )
              {
                $departamento[] = array(
                                    "id" => $row["id_departamento"],
                                    "nombre" => utf8_encode( $row["nombre"] ),
                                    "pais" => $row["pais_id_pais"]
                                  );
              }
              $retorno["status"] = "OK";
              $retorno["departamento"] = $departamento;
            break;
          case 5://Eliminar usuario
              $query = "DELETE FROM departamento WHERE id_departamento='". $_POST["id_departamento"] ."'";
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
