<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Administration de votre site</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">

    <!-- THEME CUSTOM -->
    <link href="view/themes/admin/css/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript" src="assets/js/GETurl.js"></script>
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Afficher la navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php"><?=$websiteName?></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li <?php ControllerDefault::active('admin', 'administration'); ?>><a href="#">Administration</a></li>
            <li <?php ControllerDefault::active('admin', 'parametre'); ?>><a href="#">Vos paramètres</a></li>
            <li <?php ControllerDefault::active('admin', 'profil'); ?>><a href="#">Votre profil</a></li>
            <li <?php ControllerDefault::active('admin', 'aide'); ?>><a href="#">Aide</a></li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li <?php ControllerDefault::active('admin', 'index'); ?>><a href="index.php?controller=admin&action=index"><i class="fa fa-home" aria-hidden="true"></i> Résumé</a></li>
            <li <?php ControllerDefault::active('admin', 'utilisateurs'); ?>><a href="index.php?controller=admin&action=utilisateurs"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Utilisateurs</a></li>
            <li <?php ControllerDefault::active('admin', 'chambres'); ?>><a href="index.php?controller=admin&action=chambres"><span class="glyphicon glyphicon-lamp" aria-hidden="true"></span> Chambres</a></li>
            <li <?php ControllerDefault::active('admin', 'prestations'); ?>><a href="index.php?controller=admin&action=prestations"><i class="fa fa-glass" aria-hidden="true"></i> Prestations</a></li>  
            <li <?php ControllerDefault::active('admin', 'reservations'); ?>><a href="index.php?controller=admin&action=reservations"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span> Réservations</a></li>
            <li <?php ControllerDefault::active('admin', 'news'); ?>><a href="index.php?controller=admin&action=news"><i class="fa fa-newspaper-o" aria-hidden="true"></i> Actualités</a></li>
            <li <?php ControllerDefault::active('admin', 'options'); ControllerDefault::active('admin', 'updateOptions');?>><a href="index.php?controller=admin&action=options"><i class="fa fa-cogs" aria-hidden="true"></i> Options</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <?php
          if(isset($powerNeeded) && $powerNeeded == true) {
              $filepath = File::build_path(array("view" , static::$object, $view.".php"));
              require $filepath;
          } else {
              echo '<div class="alert alert-danger">Vous ne possédez pas les droits pour accéder à cette page</div>';

          }
          ?>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
  </body>
</html>
