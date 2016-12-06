<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $pagetitle; ?></title>
        <!-- Bootstrap -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/font-awesome.min.css" rel="stylesheet">
        <link href="assets/css/style_tablesorter.css" rel="stylesheet">
        <!-- THEME CUSTOM -->
        <link href="view/themes/default/css/style.css" rel="stylesheet">
    </head>

    <body>
        <nav class="navbar navbar-inverse  menuHaut">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand visible-xs" href="index.php"><?=$websiteName?></a>
            </div>

            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="logoBrand"><a href="index.php"><?=$websiteName?></a></li>
                    <li <?php ControllerDefault::active('index', ''); ?>><a href="index.php">Accueil</a></li>
                    <li <?php ControllerDefault::active('chambre', 'readAll'); ?>><a href="index.php?controller=chambre&action=readAll">Chambres</a></li>
                    <li <?php ControllerDefault::active('default', 'aboutus'); ?>><a href="index.php?controller=default&action=aboutus">À propos de nous</a></li>

                    <?php
                    if(!ControllerUtilisateur::isConnected()) {
                    ?>
                        <li <?php ControllerDefault::active('utilisateur', 'connect'); ?> ><a href="index.php?controller=utilisateur&action=connect">Connexion</a></li>
                        <li <?php ControllerDefault::active('utilisateur', 'register'); ?> ><a href="index.php?controller=utilisateur&action=register">Inscription</a></li>
                    <?php
                    } else {
                        $currentUser = ModelUtilisateur::selectCustom('idUtilisateur', $_SESSION['idUser'])[0];
                    ?>
                        <li <?php ControllerDefault::active('commande', ''); ?> ><a href="index.php?controller=commande&action=readAll">Réservations</a></li>
                        <li <?php ControllerDefault::active('utilisateur', 'profil'); ?> ><a href="index.php?controller=utilisateur&action=profil">Profil</a></li>
                        <li <?php ControllerDefault::active('utilisateur', 'disconnect'); ?> ><a href="index.php?controller=utilisateur&action=disconnect">Déconnexion</a></li>
                        <?php if($currentUser->getPower() == Conf::$power['admin']) { ?>
                            <div class="goAdmin"><a href="index.php?controller=admin&action=index" class="btn btn-red"><i class="fa fa-lock" aria-hidden="true"></i> Administration</a></div>
                        <?php } ?>
                    <?php
                        }
                    ?>

                </ul>
            </div>

        </nav>


        <?php
        if(isset($powerNeeded) && $powerNeeded == true) {
            if ($view != 'index') {
                echo '<div class="container page">';
            }

            $filepath = File::build_path(array("view" , static::$object, $view.".php"));
            require $filepath;

            if($view != 'index') {
                echo '</div>';
            }
        } else {
            echo '<div class="container page"><div class="alert alert-danger">Vous ne possédez pas les droits pour accéder à cette page</div></div>';
        }
        ?>

        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/jquery.matchHeight.js"></script>
        <script src="assets/js/jquery.tablesorter.min.js"></script>
        <script src="assets/js/jquery.metadata.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>

        <!-- SCRIPTS CUSTOM -->

        <footer class="footer" >
                <div class="container">
                    <p class="text-muted text-center"><?=$websiteName?> &copy;</p>
                </div>
        </footer>
    </body>
</html>





