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
            $result = $rep->fetch();

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
            $result = $rep->fetch();

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
            $result = $rep->fetch();

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