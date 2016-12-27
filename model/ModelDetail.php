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
            $sql = "SELECT p.idDetail, p.nomDetail
                    FROM `GH_ChambresDetails` cp 
                    INNER JOIN `GH_Details` p ON cp.idDetail = p.idDetail
                    WHERE cp.idChambre= :tag_idChambre";

            $req_prep = Model::$pdo->prepare($sql);

            $values = array(
                'tag_idChambre' => $idChambre,
            );

            $req_prep->execute($values);
            $req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelDetail');
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

    public static function selectForChambre($idChambre){ 
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

    public static function selectValeur($idChambre, $idDetail){
        try {
            $sql = "SELECT valeurDetail
                    FROM `GH_ChambresDetails`
                    WHERE idChambre = :tag_idChambre 
                        AND idDetail = :tag_idDetail";

            $req_prep = Model::$pdo->prepare($sql);

            $values = array(
                'tag_idChambre' => $idChambre,
                'tag_idDetail' => $idDetail,
            );

            $req_prep->execute($values);
            $result = $req_prep->fetch();

            if(!empty($result)){
                return $result[0];
            }else{
                return false;
            }
            
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
            $sql = "DELETE FROM GH_ChambresDetails
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

    public static function saveByChambre($idChambre, $idDetail, $valeurDetail){
        try {
            $sql = "INSERT INTO GH_ChambresDetails (idChambre, idDetail, valeurDetail)
                    VALUES (:tag_idChambre, :tag_idPrestation, :tag_valeurDetail)";

            $req_prep = Model::$pdo->prepare($sql);

            $values = array(
                'tag_idChambre' => $idChambre,
                'tag_idPrestation' => $idDetail,
                'tag_valeurDetail' => $valeurDetail,
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