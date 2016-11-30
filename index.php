<?php
    /** 25/11
     * - Faire les prototypes des page admin
     *      - creer une chambre
     *      - modifier
     *      - supprimmer
     *      - afficher une chambre
     *
     * - Implémenter les prototypes
     * - L'admin doit pouvoir modifier des textes, modifier une photo
     */

    // sebastien.gagne41@orange.fr trello, git hub, google drive
    // sebastien.gagne@umontpellier.fr
    ini_set('display_errors', 1);
    error_reporting(E_ALL ^ E_NOTICE); 
    $DS = DIRECTORY_SEPARATOR;
    $ROOT_FOLDER = __DIR__.$DS;
    require_once $ROOT_FOLDER.'lib/File.php';
    require_once File::build_path(array('controller', 'routeur.php'));
?>


