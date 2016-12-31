<?php
    // sebastien.gagne41@orange.fr trello, git hub, google drive
    // sebastien.gagne@umontpellier.fr
    ini_set('display_errors', 1);
    error_reporting(E_ALL ^ E_NOTICE); 
    $DS = DIRECTORY_SEPARATOR;
    $ROOT_FOLDER = __DIR__.$DS;
    require_once $ROOT_FOLDER.'lib/File.php';
    require_once File::build_path(array('controller', 'routeur.php'));
?>


