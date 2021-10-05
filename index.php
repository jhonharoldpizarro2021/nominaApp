<?php
  session_start();
  ob_start();
  include "functions.php";
  if( session_valida() )
  {
    header("Location: home.php");
  }
?>
<!DOCTYPE html>
<html lang="es">
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>TEMPORALES ESPECIALIZADOS S.A.</title>
    <!-- Icono -->
    <!-- <link rel="icon" type="image/png" href="images/favicon.png" /> -->
    <link rel="apple-touch-icon" sizes="57x57" href="images/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="images/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="images/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="images/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="images/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="images/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="images/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="images/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon/favicon-16x16.png">
    <link rel="manifest" href="images/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="images/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!-- jQuery -->
    <script type="text/javascript" src="extensions/jquery/jquery-1.12.4.min.js"></script>

    <!-- bootstrap -->
    <link rel="stylesheet" href="extensions/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="extensions/bootstrap/css/bootstrap-theme.min.css">
    <script src="extensions/bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">

    <!-- Estilo -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/responsive.css" rel="stylesheet">
    <link href="css/timeline.css" rel="stylesheet">

    <script type="text/javascript" src="js/login.js"></script>
  </head>
  <body>
    <div id="login" class="row">
      <div class="col-sm-4"></div>
      <div class="col-sm-4 panel panel-primary">
        <h1 class="text-center"><img class="logo" src="images/logotemporales-alta.png"></h1>
        <form class="">
          <div class="form-group">
            <label for="usuario">Usuario</label>
            <input type="email" class="form-control" id="usuario" name="usuario">
            <div id="msg_error_usuario" class="alert alert-danger" role="alert">Campo requerido</div>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password">
            <div id="msg_error_password" class="alert alert-danger" role="alert">Campo requerido</div>
          </div>
          <div id="msg_error_session" class="alert alert-danger text-center" role="alert"></div>
          <div class="form-group text-center">
            <button type="button" class="btn btn-primary" onclick="iniciarSesion()">Aceptar</button>
          </div>
        </form>
      </div>
    </div>
  </body>
</html>
