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

    public static function selectPhoto($idChambre){
        try {
            $sql = "SELECT `urlVisuel` FROM `GH_VisuelsChambres` WHERE idChambre=:tag_idChambre";
            $rep = Model::$pdo->prepare($sql);

            $values = array(
                'tag_idChambre' => $idChambre
            );

            $rep->execute($values);
            $result = $rep->fetchAll();

            return $result;
        } catch(PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage();
            } else {
                echo "Une erreur est survenue ! Merci de réessayer plus tard";
            }
            return false;
            die();
        }
    }

    public static function updatePhoto($before_p, $after_p){
        try{
            $sql= "UPDATE `GH_VisuelsChambres` SET urlVisuel = :tag_after_p WHERE idVisuel = :tag_before_p";
            $updateUrl=Model::$pdo->prepare($sql);

            $value=array(
                'tag_before_p' => $before_p,
                'tag_after_p' => $after_p,
            );

            $updateUrl->execute($value);
            return true;
        } catch(PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage();
            }
            return false;
            die();
        }
    }

    public function update_url($url){
        try{
            $sql='UPDATE `'.self::$tableName.'` SET urlVisuel = '.$url.' WHERE idVisuel = :idVisuel';
            $updateUrl=Model::$pdo->prepare($sql);

            $value=array(
                'idVisuel' => $this->idVisuel
            );

            $updateUrl->execute($value);
            return true;
        } catch(PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage();
            }
            return false;
            die();
        }
    }

    public static function delatePhoto($url){
        try{
            $sql= "DELETE FROM `GH_VisuelsChambres` WHERE `urlVisuel`= :tag_url";
            $updateUrl=Model::$pdo->prepare($sql);

            $value=array(
                'tag_url' => $url,
            );

            $updateUrl->execute($value);
            return true;
        } catch(PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage();
            }
            return false;
            die();
        }
    }

    public static function selectDetail($idChambre){
        try {
            $sql = "SELECT d.nomDetail, cd.valeurDetail 
                    FROM `GH_ChambresDetails` cd 
                    INNER JOIN `GH_Details` d ON cd.idDetail = d.idDetail 
                    WHERE cd.idChambre= :tag_idChambre";

            $rep = Model::$pdo->prepare($sql);

            $values = array(
                'tag_idChambre' => $idChambre,
            );

            $rep->execute($values);
            $result = $rep->fetchAll();

            return $result;
        } catch(PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage();
            } else {
                echo "Une erreur est survenue ! Merci de réessayer plus tard";
            }
            return false;
            die();
        }
    }

    public static function selectPrestation($idChambre){
        try {
            $sql = "SELECT p.nomPrestation, p.prix 
                    FROM `GH_ChambresPresta` cp 
                    INNER JOIN `GH_Prestations` p ON cp.idPrestation = p.idPrestation 
                    WHERE cp.idChambre= :tag_idChambre";

            $rep = Model::$pdo->prepare($sql);

            $values = array(
                'tag_idChambre' => $idChambre,
            );

            $rep->execute($values);
            $result = $rep->fetchAll();

            return $result;
        } catch(PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage();
            } else {
                echo "Une erreur est survenue ! Merci de réessayer plus tard";
            }
            return false;
            die();
        }
    }


}