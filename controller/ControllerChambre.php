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
            } elseif(isset($_GET['forChambre'])) {
                $idChambre = htmlspecialchars($_GET['forChambre']);
            }

            $chambre = ModelChambre::select($idChambre);
            if ($chambre!=false) {
                $tab_photo = $chambre->selectPhoto();
                $tab_detail = ModelDetail::selectForChambre($idChambre);
                $tab_prestation = ModelPrestation::selectAllByChambre($idChambre);

                foreach ($tab_photo as $photo) {
                    $image = $photo['urlVisuel'];
                    if (!file_exists(File::build_path(array($image)))) {
                        ModelChambre::deleteImage($photo['idVisuel']);
                        $pbPhoto = true;
                    }
                    if($pbPhoto=true){
                        $tab_photo = $chambre->selectPhoto();
                    }
                }

                require_once File::build_path(array("view","main_view.php"));
            } else {
                self::readAll();
            }
        } else {
            self::readAll();
        }  	
    }
}
?>