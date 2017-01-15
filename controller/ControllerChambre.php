<?php
/* Make sure in production mode that $powerNeeded is not true auto */

class ControllerChambre {
    private static $object = 'chambre';

    public static function readAll() {
        if(ControllerUtilisateur::isConnected()) {
            $currentUser = ModelUtilisateur::selectCustom('idUtilisateur', $_SESSION['idUser'])[0];
            $powerNeeded = ($currentUser->getPower() == Conf::$power['user']);
            $powerNeeded = true;
            $tab_v = ModelChambre::selectAll();
            $view = 'displayAllChambre';
            $pagetitle = 'Nos Chambres';

            require_once File::build_path(array("view","main_view.php"));
        } else {
            ControllerDefault::error('Vous devez être connecté pour accéder à cette page !');
        }
    }

    public static function read($message=null) {
        if(ControllerUtilisateur::isConnected()) {
            $currentUser = ModelUtilisateur::selectCustom('idUtilisateur', $_SESSION['idUser'])[0];
            $powerNeeded = ($currentUser->getPower() == Conf::$power['user']);
            $powerNeeded = true;
            $view = 'displayChambre';
            $pagetitle = 'detail de la chambre';

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
        } else {
            ControllerDefault::error('Vous devez être connecté pour accéder à cette page !');
        }
    }
}
?>