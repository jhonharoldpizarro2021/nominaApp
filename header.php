<?php
  session_start();
  ob_start();
 ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Temporales Especializados | Contrataci&oacute;n</title>
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
    <link rel="stylesheet" href="extensions/font-awesome-4.6.3/css/font-awesome.min.css">
    <!-- bootstrap show password -->
    <script src="extensions/bootstrap-show-password/bootstrap-show-password.min.js"></script>
    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="extensions/datatables/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="extensions/datatables/js/jquery.dataTables.js"></script>
    <!-- <link href="extensions/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">
    <link href="extensions/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet"> -->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- datepicker  -->
    <script type="text/javascript" src="extensions/datepicker/js/bootstrap-datepicker.min.js" charset="UTF-8"></script>
    <link href="extensions/datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" media="screen">
    <script type="text/javascript" src="extensions/datepicker/locales/bootstrap-datepicker.es.min.js" charset="UTF-8"></script>
    <!-- Funciones JS Generales -->
    <script type="text/javascript" src="js/functions.js?n=<?= time() ?>"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="extensions/metisMenu/dist/metisMenu.min.js"></script>
    <link href="extensions/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
    <!-- Estilo -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/responsive.css" rel="stylesheet">
    <link href="css/timeline.css" rel="stylesheet">
    <!-- jAlert JavaScript -->
    <script src="extensions/jAlert/js/jquery.ui.draggable.js"></script>
    <script src="extensions/jAlert/js/jquery.alerts.js"></script>
    <link href="extensions/jAlert/css/jquery.alerts.css" rel="stylesheet" media="screen">
    <!-- Mask -->
    <script src="extensions/mask/jquery.mask.min.js"></script>

    <script>
        
    </script>
</head>
<body>
<?php
  include "functions.php";
  if( !session_valida() )
  {
    header("Location: cerrar_sesion.php");
  }
?>
    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0;">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/home.php">
                    <h1 class="titulo"><img class="logo" src="images/logotemporales-alta.png"></h1>
                </a>
            </div>
            <!-- /.navbar-header -->
            <ul class="nav navbar-top-links navbar-right" id="nav">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <!-- <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>Read All Messages</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul> -->
                    <!-- /.dropdown-messages -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-tasks fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <!-- <ul class="dropdown-menu dropdown-tasks">
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 1</strong>
                                        <span class="pull-right text-muted">40% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                            <span class="sr-only">40% Complete (success)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 2</strong>
                                        <span class="pull-right text-muted">20% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                            <span class="sr-only">20% Complete</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 3</strong>
                                        <span class="pull-right text-muted">60% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                            <span class="sr-only">60% Complete (warning)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 4</strong>
                                        <span class="pull-right text-muted">80% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                            <span class="sr-only">80% Complete (danger)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Tasks</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul> -->
                    <!-- /.dropdown-tasks -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <!-- <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-comment fa-fw"></i> New Comment
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                    <span class="pull-right text-muted small">12 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> Message Sent
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-tasks fa-fw"></i> New Task
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Alerts</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul> -->
                    <!-- /.dropdown-alerts -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="cerrar_sesion.php"><i class="fa fa-sign-out fa-fw"></i> Cerrar sesión</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <!-- Menú lateral -->
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Buscar...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-cogs fa-fw"></i> Par&aacute;metros Basicos<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level" id="sub-side-menu">
                                <li>
                                    <a href="usuarios.php"><i class="fa fa-key fa-fw"></i> Usuarios</a>
                                </li>
                                <li>
                                    <a href="tipo_documentos.php"><i class="fa fa-credit-card-alt fa-fw"></i> Tipos Documentos de Identidad</a>
                                </li>
                                <li>
                                    <a href="estado_civil.php"><i class="fa fa-slideshare fa-fw"></i> Estado civil</a>
                                </li>
                                <li>
                                    <a href="generos.php"><i class="fa fa-venus-mars fa-fw"></i> Genero</a>
                                </li>
                                <li>
                                    <a href="nivel_estudio.php"><i class="fa fa-graduation-cap fa-fw"></i> Nivel de estudios</a>
                                </li>
                                <li>
                                    <a href="estratos.php"><i class="fa fa-cc-diners-club fa-fw"></i> Estratos</a>
                                </li>
                                <li>
                                    <a href="parentesco.php"><i class="fa fa-child fa-fw"></i> Parentescos</a>
                                </li>
                                <li>
                                    <a href="etnias.php"><i class="fa fa-flag fa-fw"></i> Etnias</a>
                                </li>
                                <li>
                                    <a href="pais.php"><i class="fa fa-globe fa-fw"></i> Paises</a>
                                </li>
                                <li>
                                    <a href="departamento.php"><i class="fa fa-map-signs fa-fw"></i> Departamentos</a>
                                </li>
                                <li>
                                    <a href="ciudad.php"><i class="fa fa-location-arrow fa-fw"></i> Ciudades</a>
                                </li>
                                <li>
                                    <a href="salud.php"><i class="fa fa-ambulance fa-fw"></i> E.P.S.</a>
                                </li>
                                <li>
                                    <a href="arl.php"><i class="fa fa-medkit fa-fw"></i> A.R.L.</a>
                                </li>
                                <li>
                                    <a href="pension.php"><i class="fa fa-wheelchair fa-fw"></i> Fondos de Pensiones</a>
                                </li>
                                <li>
                                    <a href="ccf.php"><i class="fa fa-heartbeat fa-fw"></i> Cajas de Compensaci&oacute;n</a>
                                </li>
                                <li>
                                    <a href="empresas.php"><i class="fa fa-industry fa-fw"></i> Empresas</a>
                                </li>
                                <li>
                                    <a href="bancos.php"><i class="fa fa-university fa-fw"></i> Bancos</a>
                                </li>
                                <li>
                                    <a href="tipo_cuentas.php"><i class="fa fa-barcode fa-fw"></i> Tipo de Cuentas</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                          <a href="#"><i class="fa fa-users fa-fw"></i> Empleados-datos básicos<span class="fa arrow"></span></a>
                          <ul class="nav nav-second-level" id="sub-side-menu">
                              <li>
                                  <a href="empleados.php"><i class="fa fa-users fa-fw"></i> Crear/Modificar</a>
                              </li>
                              <!-- <li>
                                  <a href="#"><i class="fa fa-bullhorn fa-fw"></i> Novedades</a>
                              </li>
                              <li>
                                  <a href="#"><i class="fa fa-money fa-fw"></i> Cotizaciones</a>
                              </li> -->
                          </ul>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
