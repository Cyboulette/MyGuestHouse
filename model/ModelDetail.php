<?php
require_once 'Model.php';

class ModelDetail extends Model {
    
    protected $idDetail;
    protected $nomDetail;

    protected static $tableName = 'GH_Details'; // Correspond au nom de la table SQL (pratique si différent du nom de l'objet)
    protected static $object = 'detail'; // Correspond au nom de l'objet à créer
    protected static $primary = 'idDetail'; // Correspond à la clé primaire de la table (pratique pour faire un read())

    public function __construct($idDetail=null, $nomDetail=null){
        if(!is_null($idDetail) && !is_null($nomDetail)){
            $this->idDetail = $idDetail;
            $this->nomDetail = $nomDetail;
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