<?php

@session_start(); // On démarre la session

// Autoloader permettant d'inclure directement un controller lorsqu'il est instancié

spl_autoload_register(function($controller_name){
    require_once File::build_path(array('controller', $controller_name.'.php')); // On inclut les fichiers par auto_load
});

if(isset($_GET['controller']) && !empty(($_GET['controller']))) {
    $controller = $_GET['controller'];
    $controller_class = 'Controller'.ucfirst($controller);
    if(file_exists(File::build_path(array('controller', $controller_class.'.php')))) {
        require_once File::build_path(array('controller', $controller_class.'.php'));
        if(class_exists($controller_class)) {
            if(isset($_GET['action']) && !empty($_GET['action'])) {
                $actionsExiste = get_class_methods($controller_class);
                $action = $_GET['action'];    // recupère l'action passée dans l'URL
                if(in_array($action, $actionsExiste)) {
                    $controller_class::$action(); // Appel de la méthode statique $action de ControllerDefault
                } else {
                    ControllerDefault::error("L'action demandée est impossible");
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
} else {
    ControllerDefault::index();
}
?>