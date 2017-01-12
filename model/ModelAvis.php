<?php
require_once 'Model.php';

class ModelAvis{
    
    protected $idChambre;
    protected $idUtilisateur;
    protected $note;
    protected $commentaire;

    protected static $tableName = 'GH_Avis'; // Correspond au nom de la table SQL (pratique si différent du nom de l'objet)
    protected static $object = 'avis'; // Correspond au nom de l'objet à créer
    protected static $primary = 'idUtilisateur'; // Correspond à la clé primaire de la table (pratique pour faire un read())

    public function __construct($idChambre=null, $idUtilisateur=null, $note=null, $commentaire=null){
        if(!is_null($idChambre) && !is_null($idUtilisateur) && !is_null($note) && !is_null($commentaire)){
            $this->idChambre = $idChambre;
            $this->idUtilisateur = $idUtilisateur;
            $this->note = $note;
            $this->commentaire = $commentaire;
            
        }
    }

    public function get($nom_attribut) {
        if (property_exists($this, $nom_attribut)) {
            return $this->$nom_attribut;
        }
        return false;
    }

    public function set($nom_attribut, $valeur) {
        if (property_exists($this, $nom_attribut)) {
            $this->$nom_attribut = $valeur;
        }
        return false;
    }

    public static function select($idUtilisateur, $idChambre){
        try {
            $sql = "SELECT * 
                    FROM `GH_Avis` 
                    WHERE idUtilisateur = :idUtilisateur 
                    AND idChambre = :idChambre";
            $req_prep = Model::$pdo->prepare($sql);

            $values = array(
                'idUtilisateur' => $idUtilisateur,
                'idChambre' => $idChambre
            );

            $req_prep->execute($values);
            $req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelAvis');
            $tab = $req_prep->fetchAll();

            if(empty($tab)){
                return false;
            } else {
                return $tab[0];
            }
        } catch(PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage();
            }
            return false;
            die();
        }
    }

    public static function selectCustomAvis($selecteur, $valeur){
        try {
            $sql = "SELECT * 
                    FROM `GH_Avis` 
                    WHERE ".$selecteur." = :valeur";
            $req_prep = Model::$pdo->prepare($sql);

            $values = array(
                'valeur' => $valeur
            );

            $req_prep->execute($values);
            $req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelAvis');
            $tab = $req_prep->fetchAll();

            if(empty($tab)){
                return false;
            }else{
                return $tab;
            }
        } catch(PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage();
            }
            return false;
            die();
        }    
    }

    public static function countCustomAvis($selecteur, $valeur){
        try {
            $sql = "SELECT COUNT(*) 
                    FROM `GH_Avis` 
                    WHERE ".$selecteur." = :valeur";
            $req_prep = Model::$pdo->prepare($sql);

            $values = array(
                'valeur' => $valeur
            );

            $req_prep->execute($values);
            $req_prep->setFetchMode(PDO::FETCH_NUM);
            $tab = $req_prep->fetch();

            if(empty($tab)){
                return false;
            } else {
                return $tab[0];
            }
        } catch(PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage();
            }
            return false;
            die();
        }    
    }

    public static function listeChambresPourAvis($idUtilisateur){
        try {
            $sql = "SELECT DISTINCT(r.idChambre) 
                    FROM GH_Reservations r 
                    WHERE idUtilisateur = :idUtilisateur 
                        AND NOT EXISTS( 
                            SELECT * FROM GH_Avis a 
                            WHERE idUtilisateur = :idUtilisateur 
                                AND r.idChambre=a.idChambre 
                        )
                    ";
            $req_prep = Model::$pdo->prepare($sql);

            $values = array(
                'idUtilisateur' => $idUtilisateur
            );

            $req_prep->execute($values);
            $req_prep->setFetchMode(PDO::FETCH_NUM);
            $tab = $req_prep->fetchAll();

            if(empty($tab)){
                return false;
            } else {
                return $tab;
            }
        } catch(PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage();
            }
            return false;
            die();
        } 
    }

    public static function canPosteReviews($idUtilisateur, $idChambre){
        if(self::haveReservedRoom($idUtilisateur, $idChambre) && self::haventPostedReviews($idUtilisateur, $idChambre)){
            return true;
        }else{
            return false;
        }
    }

    public static function haveReservedRoom($idUtilisateur, $idChambre){
        try {
            $sql = "SELECT COUNT(*) 
                    FROM `GH_Reservations` 
                    WHERE `idUtilisateur` = :idUtilisateur
                        AND `idChambre` = :idChambre";
            $req_prep = Model::$pdo->prepare($sql);

            $values = array(
                'idUtilisateur' => $idUtilisateur,
                'idChambre' => $idChambre
            );

            $req_prep->execute($values);
            $req_prep->setFetchMode(PDO::FETCH_NUM);
            $tab = $req_prep->fetch();

            if($tab[0]==0){
                return false;
            } else {
                return true;
            }
        } catch(PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage();
            }
            return false;
            die();
        }    
    }

    public static function haventPostedReviews($idUtilisateur, $idChambre){
        try {
            $sql = "SELECT COUNT(*) 
                    FROM `GH_Avis` 
                    WHERE `idUtilisateur` = :idUtilisateur
                        AND `idChambre` = :idChambre";
            $req_prep = Model::$pdo->prepare($sql);

            $values = array(
                'idUtilisateur' => $idUtilisateur,
                'idChambre' => $idChambre
            );

            $req_prep->execute($values);
            $req_prep->setFetchMode(PDO::FETCH_NUM);
            $tab = $req_prep->fetch();

            if($tab[0]==0){
                return true;
            } else {
                return false;
            }
        } catch(PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage();
            }
            return false;
            die();
        }    
    }

    // public static function selectByUser(){
    // }

    // public static function selectByChambre(){
    // }

    public static function delete($idUtilisateur, $idChambre){
        try {
            $sql = "DELETE FROM `GH_Avis` 
                    WHERE `idUtilisateur` = :idUtilisateur
                    AND `idChambre` = :idChambre";
            $rep = Model::$pdo->prepare($sql);
            $values = array(
                'idUtilisateur' => $idUtilisateur,
                'idChambre' => $idChambre
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

    public static function update($data){
        try {
            $sql = 'UPDATE `GH_Avis` SET ';

            foreach ($data as $key => $value) {
                $sql .= $key.' = :'.$key.', ';
            }
            $sql = substr($sql, 0, -2);
            $sql .= ' WHERE `idUtilisateur` = :idUtilisateur
                        AND `idChambre` = :idChambre ';
            
            $update = Model::$pdo->prepare($sql);
            $update->execute($data);
            return true;
        } catch(PDOException $e) {
            if(Conf::getDebug()) {
                echo $e->getMessage();
            }
            return false;
            die();
        }
    }

    public static function save($data) {
        try {
            $sql = 'INSERT INTO `GH_Avis` VALUES (';


            foreach ($data as $key => $value) {
                $sql .= ':'.$key.',';
            }

            $sql = substr($sql, 0, -1);
            $sql .= ')';

            $add = Model::$pdo->prepare($sql);
            $add->execute($data);
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