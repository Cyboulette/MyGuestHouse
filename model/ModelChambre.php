<?php
require_once 'Model.php';

class ModelChambre extends Model {
    
    protected $idChambre;
    protected $nomChambre;
    protected $descriptionChambre;
    protected $prixChambre;
    protected $superficieChambre;

    protected static $tableName = 'GH_Chambres'; // Correspond au nom de la table SQL (pratique si différent du nom de l'objet)
    protected static $object = 'chambre'; // Correspond au nom de l'objet à créer
    protected static $primary = 'idChambre'; // Correspond à la clé primaire de la table (pratique pour faire un read())

    public function __construct($idChambre=null, $nomChambre=null, $descriptionChambre=null, $prixChambre=null, $superficieChambre=null){
        if(!is_null($idChambre) && !is_null($nomChambre) && !is_null($descriptionChambre) && !is_null($prixChambre) && !is_null($superficieChambre)){
            $this->idChambre = $idChambre;
            $this->nomChambre = $nomChambre;
            $this->descriptionChambre = $descriptionChambre;
            $this->prixChambre = $prixChambre;
            $this->superficieChambre = $superficieChambre;
        }
    }

    public function selectPhoto($latest = false){
        try {
            $sql = "SELECT * FROM `GH_VisuelsChambres` WHERE `idChambre` = :tag_idChambre";
            $rep = Model::$pdo->prepare($sql);

            $values = array(
                'tag_idChambre' => $this->idChambre
            );

            $rep->execute($values);
            if($latest) {
                $result = $rep->fetch();
            } else {
                $result = $rep->fetchAll();
            }

            return $result;
        } catch(PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage();
            }
            return false;
            die();
        }
    }

    public static function getImage($idChambre, $idVisuel) {
        try {
            $sql = "SELECT * FROM `GH_VisuelsChambres` WHERE `idChambre` = :idChambre AND `idVisuel` = :idVisuel";
            $rep = Model::$pdo->prepare($sql);

            $values = array(
                'idChambre' => $idChambre,
                'idVisuel' => $idVisuel
            );

            $rep->execute($values);
            $result = $rep->fetch();

            return $result;
        } catch(PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage();
            }
            return false;
            die();
        }
    }

    public function addPhoto($urlVisuel){
        try {
            $sql = "INSERT INTO `GH_VisuelsChambres` VALUES(:idVisuel, :idChambre, :urlVisuel)";
            $rep = Model::$pdo->prepare($sql);

            $values = array(
                'idVisuel' => NULL,
                'idChambre' => $this->idChambre,
                'urlVisuel' => $urlVisuel
            );

            $rep->execute($values);
            return true;
        } catch(PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage();
            }
            return false;
            die();
        }
    }


    public static function deleteImage($idVisuel){
        try{
            $sql = "DELETE FROM `GH_VisuelsChambres` WHERE `idVisuel` = :idVisuel";
            $delete = Model::$pdo->prepare($sql);

            $values = array(
                'idVisuel' => $idVisuel,
            );

            $delete->execute($values);
            return true;
        } catch(PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage();
            }
            return false;
            die();
        }
    }
}
?>