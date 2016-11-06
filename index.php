<?php
    /**
     * - Initial commit
     *
     *      Implementation of the elements non relative to the database
     *      Implementation of the database
     *      Implementation of the router.php file
     *      Implementation of the File.php file
     *      Implementation of the main view (basics)
     *      Implementation of the generic model
     *      Implementation of the Default controller
     *
     * */

    $DS = DIRECTORY_SEPARATOR;
    $ROOT_FOLDER = __DIR__.$DS;
    require_once $ROOT_FOLDER.'lib/File.php';
    require_once File::build_path(array('controller', 'routeur.php'));
?>