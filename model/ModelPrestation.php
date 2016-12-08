<?php
require_once 'Model.php';

class ModelPrestation extends Model {
    
    protected $idPrestation;
    protected $nomPrestation;
    protected $prix;

    protected static $tableName = 'GH_Prestations'; // Correspond au nom de la table SQL (pratique si différent du nom de l'objet)
    protected static $object = 'prestation'; // Correspond au nom de l'objet à créer
    protected static $primary = 'idPrestation'; // Correspond à la clé primaire de la table (pratique pour faire un read())

    public function __construct($idPrestation=null, $nomPrestation=null, $prix=null){
        if(!is_null($idPrestation) && !is_null($nomPrestation) && !is_null($prix)){
            $this->idPrestation = $idPrestation;
            $this->nomPrestation = $nomPrestation;
            $this->prix = $prix;
        }
    }

    public static function selectAllByChambre($idChambre){
        try {
            $sql = "SELECT p.idPrestation, p.nomPrestation, p.prix 
                    FROM `GH_ChambresPresta` cp 
                    INNER JOIN `GH_Prestations` p ON cp.idPrestation = p.idPrestation 
                    WHERE cp.idChambre= :tag_idChambre";

            $req_prep = Model::$pdo->prepare($sql);

            $values = array(
                'tag_idChambre' => $idChambre,
            );

            $req_prep->execute($values);
            $req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelPrestation');
            $result = $req_prep->fetchAll();

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

    public static function deleteAllByChambre($idChambre){
        try {
            $sql = "DELETE FROM GH_ChambresPresta
                    WHERE idChambre = :tag_idChambre";

            $req_prep = Model::$pdo->prepare($sql);

            $values = array(
                'tag_idChambre' => $idChambre,
            );

            $req_prep->execute($values);

            return true;

        } catch (Exception $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage();
            } else {
                echo "Une erreur est survenue ! Merci de réessayer plus tard";
            }
            return false;
            die();
        }
    }

    public static function saveByChambre($idChambre, $idPrestation){
        try {
            $sql = "INSERT INTO GH_ChambresPresta (idChambre, idPrestation)
                    VALUES (:tag_idChambre, :tag_idPrestation)";

            $req_prep = Model::$pdo->prepare($sql);

            $values = array(
                'tag_idChambre' => $idChambre,
                'tag_idPrestation' => $idPrestation,
            );

            $req_prep->execute($values);

            return true;

        } catch (Exception $e) {
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

?>