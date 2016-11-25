<?php
    /** 25/11
     * - Faire les prototypes des page admin
     *      - creer une chambre
     *      - modifier
     *      - supprimmer
     *      - afficher une chambre
     *
     * - Implémenter les prototypes
     *
     * L'admin doit purivr modifier des textes, modifier une photo
    */

    // sebastien.gagne41@orange.fr trello, git hub, google drive
    // sebastien.gagne@umontpellier.fr

    $DS = DIRECTORY_SEPARATOR;
    $ROOT_FOLDER = __DIR__.$DS;
    require_once $ROOT_FOLDER.'lib/File.php';
    require_once File::build_path(array('controller', 'routeur.php'));
?>


