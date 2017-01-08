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

    public static function selecCustomAvis($selecteur, $valeur){
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

    public static function update(){
        try {
            $sql = 'UPDATE `GH_Avis` SET ';

            foreach ($data as $key => $value) {
                $sql .= $key.' = :'.$key.', ';
            }
            $sql = substr($sql, 0, -2);
            $sql .= "WHERE `idUtilisateur` = :idUtilisateur
                    AND `idChambre` = :idChambre";
            
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

    //save on Model.php

}
?>