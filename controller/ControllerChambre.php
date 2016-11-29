<?php
require_once File::build_path(array('model', 'ModelChambre.php'));

class ControllerChambre {
    private static $object = 'chambre';

    public static function readAll() {
        $tab_v = ModelChambre::selectAll();
        $view = 'displayAllChambre';
        $pagetitle = 'Nos Chambres';
        $powerNeeded = true;
        require_once File::build_path(array("view","main_view.php"));
    }

    public static function read(){
    	$view = 'displayChambre';
    	$pagetitle = 'detail de la chambre';
    	$powerNeeded = true;

    	if (isset($_GET["idChambre"])) {
	        $chambre = ModelChambre::select($_GET["idChambre"]);
	        require_once File::build_path(array("view","main_view.php"));
    	}else{
    		self::readAll();
    	}  	
    }
}