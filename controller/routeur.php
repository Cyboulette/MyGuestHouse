<?php

@session_start(); // On démarre la session

// Autoloader permettant d'inclure directement un controller lorsqu'il est instancié
spl_autoload_register(function($name){
    $checkChars = substr(strtoupper($name), 0, 10);
    if($checkChars == "CONTROLLER") {
        // On essaye de charger un controller
        require_once File::build_path(array('controller', $name.'.php')); // On inclut le fichier par auto_load
    } else {
        // On essaye de charger un model
        require_once File::build_path(array('model', $name.'.php')); // On inclut le fichier par auto_load
    }
});

if(isset($_GET['controller']) && !empty(($_GET['controller']))) {
    $controller = $_GET['controller'];
    $controller_class = 'Controller'.ucfirst($controller);

    /*
        Si le controller de la classe existe on l'appel
     */
    if(file_exists(File::build_path(array('controller', $controller_class.'.php')))) {
        require_once File::build_path(array('controller', $controller_class.'.php'));

        /*
            Si la class existe, et l'action et l'action est donné ...
         */
        if(class_exists($controller_class)) {
            if(isset($_GET['action']) && !empty($_GET['action'])) {
                $actionsExiste = get_class_methods($controller_class);
                $action = $_GET['action'];    // recupère l'action passée dans l'URL

                /*
                    .. on l'appel si elle existe
                 */
                if(in_array($action, $actionsExiste)) {
                    $controller_class::$action(); // Appel de la méthode statique $action de ControllerDefault
                } else {
                    if($controller == 'admin') {
                        $template = 'admin';
                    }
                    ControllerDefault::error("L'action demandée est impossible", $template);
                }
            } else {
                ControllerDefault::index();
            }
        } else {
            ControllerDefault::error("Cette page n'existe pas");
        }
    } else {
        ControllerDefault::error("Cette fonctionnalité n'est pas encore implémentée");
    }
}else{
    ControllerDefault::index();
}
?>