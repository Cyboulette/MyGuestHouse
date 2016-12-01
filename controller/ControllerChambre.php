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
            $idChambre = $_GET["idChambre"];
	        $chambre = ModelChambre::select($idChambre);
            if ($chambre!=false) {
                $tab_photo = ModelChambre::selectPhoto($idChambre);
                $tab_detail = ModelChambre::selectDetail($idChambre);
                $tab_prestation = ModelChambre::selectPrestation($idChambre);
                require_once File::build_path(array("view","main_view.php"));
            }else{
                self::readAll();
            }
    	}else{
    		self::readAll();
    	}  	
    }

    
}