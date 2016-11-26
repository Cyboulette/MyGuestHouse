<?php
require_once File::build_path(array('model', 'ModelChambre.php'));

class ControllerChambre {
    private static $object = 'chambre';

    public static function readAll() {
        $tab_v = ModelChambre::selectAll();
        $view = 'displayAllChambre';
        $pagetitle = 'Nos Chambre';
        require_once File::build_path(array("view","main_view.php"));
    }
}