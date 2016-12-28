<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Installation de votre CMS</title>
        <!-- Bootstrap -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/font-awesome.min.css" rel="stylesheet">
        <link href="assets/css/style_tablesorter.css" rel="stylesheet">
        <!-- THEME CUSTOM -->
        <link href="view/themes/default/css/style.css" rel="stylesheet">
    </head>

    <body>
        <nav class="navbar navbar-inverse menuHaut">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand visible-xs colorCustom" href="index.php">Installation</a>
            </div>

            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="logoBrand "><a href="index.php" class="colorCustom">Installation du CMS</a></li>
                </ul>
            </div>
        </nav>


        <?php
			echo '<div class="container page">';

			if(file_exists(File::build_path(array('view', 'default', $view.'.php')))) {
				$filepath = File::build_path(array('view', 'default', $view.'.php'));
				require $filepath;
			}

			echo '</div>';
        ?>

        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/jquery.matchHeight.js"></script>
        <script src="assets/js/jquery.tablesorter.min.js"></script>
        <script src="assets/js/jquery.metadata.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="view/themes/default/js/script.js"></script>

        <!-- SCRIPTS CUSTOM -->

        <footer class="footer" >
                <div class="container">
                    <p class="text-muted text-center">MyGuestHouse &copy;</p>
                </div>
        </footer>
    </body>
</html>