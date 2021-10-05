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

              $query2 = "SELECT * FROM departamento ORDER BY nombre ASC";
              $result2 = mysqli_query($con,$query2);
              $departamentos = array( array( "id" => $row2["id_departamento"], "nombre" => "--Departamento--" ) );
              while( $row2 = mysqli_fetch_array($result2) )
              {
                $departamentos[] = array( "id" => $row2["id_departamento"], "nombre" => utf8_encode($row2["nombre"]) );
              }
              $retorno["departamentos"] = $departamentos;

              $retorno["status"] = "OK";
            break;
          case 2: //guardar nuevo 
              //Verificar que  no está registrado
              $query = "SELECT COUNT(*) FROM ciudad WHERE nombre='". $_POST["ciudad"] ."'";
              $result = mysqli_query($con,$query);
              $row = mysqli_fetch_array($result);

              if( $row[0] > 0 ) //El correo ya se encuentra registrado
              {
                $retorno["status"] = "EXIST";
                $retorno["msg"] = "Ciudad registrada";
              }else
              {
                $query = "INSERT INTO ciudad(nombre, departamento_id_departamento)
                          VALUES('". utf8_decode($_POST["ciudad"]) ."','". $_POST["departamento"] ."')";
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
              $query = "UPDATE ciudad SET nombre='". utf8_decode($_POST["nombre"]) ."', pais_id_pais='". $_POST["pais"] ."' WHERE id_ciudad='". $_POST["id_ciudad"] ."'";
                if( mysqli_query($con,$query) )
                {
                  $retorno["status"] = "OK";
                }else{
                  $retorno["status"] = "ERROR";
                  $retorno["msg"] = "Error al realizar el Insert en la BDD: ". mysqli_error($con);
                }
            break;
          case 4: //recargar datos
              $query = "SELECT * FROM qr_pais_ciudad ORDER BY id_ciudad ASC";
              $result = mysqli_query($con,$query);
              $ciudad = array();
              while( $row = mysqli_fetch_array($result) )
              {
                $ciudad[] = array(
                                    "id" => $row["id_ciudad"],
                                    "nCiudad" => utf8_encode( $row["nombre_ciudad"] ),
                                    "departamento" => $row["id_departamento"],
                                    "nDepartamento" => $row["nombre_departamento"],
                                    "pais" => $row["id_pais"],
                                    "nPais" => $row["nombre"]
                                  );
              }
              $retorno["status"] = "OK";
              $retorno["ciudad"] = $ciudad;
            break;
          case 5://Eliminar usuario
              $query = "DELETE FROM ciudad WHERE id_ciudad='". $_POST["id_ciudad"] ."'";
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
