<?php
class ControllerChambre {
    private static $object = 'chambre';

    public static function readAll() {
        $tab_v = ModelChambre::selectAll();
        $view = 'displayAllChambre';
        $pagetitle = 'Nos Chambres';
        $powerNeeded = true;
        require_once File::build_path(array("view","main_view.php"));
    }

    public static function read($message=null){
    	$view = 'displayChambre';
    	$pagetitle = 'detail de la chambre';
    	$powerNeeded = true;



    	if (isset($_GET["idChambre"]) || isset($_GET["forChambre"])){

            if (isset($_GET['idChambre'])) {
               $idChambre = htmlspecialchars($_GET['idChambre']);
            }elseif(isset($_GET['forChambre'])){
               $idChambre = htmlspecialchars($_GET['forChambre']);
            }

	        $chambre = ModelChambre::select($idChambre);
            if ($chambre!=false) {
                $tab_photo = ModelChambre::selectPhoto($idChambre);
                $tab_detail = ModelDetail::selectForChambre($idChambre);
                $tab_prestation = ModelPrestation::selectAllByChambre($idChambre);

                $compteur = true;
                foreach ($tab_photo as $key => $value) {
                  $photo = $tab_photo[$key][0];
                  if (!file_exists(File::build_path(array($photo)))) {
                    ModelChambre::delatePhoto($photo);// suppression de la photo de la bdd si elle nexiste pas physiquement
                    $compteur = false;
                  }
                }
                if (!$compteur) {
                    $tab_photo = ModelChambre::selectPhoto($idChambre);
                }
                
                require_once File::build_path(array("view","main_view.php"));
            }else{
                self::readAll();
            }
    	}else{
    		self::readAll();
    	}  	
    }
}
?>