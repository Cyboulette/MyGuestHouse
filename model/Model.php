<?php

require_once File::build_path(array('config', 'Conf.php'));

/**
 * Model provides data management and interactions to the database
 */
class Model
{
    /**
     * PDO Object provides the query management
     */
    public static $pdo;

    public function get($nom_attribut) {
        if (property_exists($this, $nom_attribut))
            return $this->$nom_attribut;
        return false;
    }

    public function set($nom_attribut, $valeur) {
        if (property_exists($this, $nom_attribut))
            $this->$nom_attribut = $valeur;
        return false;
    }

    public static function selectAll(){
        $table_name = static::$object;
        $class_name = 'Model'.ucfirst($table_name);

        try
        {
            $rep=Model::$pdo->query("SELECT * FROM gh_" .$table_name);
            $rep->setFetchMode(PDO::FETCH_CLASS,$class_name);
            $tab = $rep->FetchAll();
            return $tab;
        }
        catch(PDOException $e)
        {
            if (Conf::getDebug())   echo $e->getMessage();
            else                    echo 'Exception reçue : ',  $e->getMessage(), "\n";
            die();
        }
    }

    public static function delete($data) {
        $table_name = static::$tableName;
        $primary_key = static::$primary;
        try {
            $sql = "DELETE FROM `".$table_name."` WHERE `".$primary_key."` = :".$primary_key."";
            $rep = Model::$pdo->prepare($sql);
            $values = array(
                $primary_key => htmlspecialchars($data)
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

    public static function select($primary_value){
        $table_name = static::$object;
        $class_name = 'Model'.ucfirst(static::$object);
        $primary_key = static::$primary;

        try
        {
            $sql = "SELECT * from $table_name WHERE $primary_key=:primary_val";
            $req_prep = Model::$pdo->prepare($sql);

            $values = array("primary_val" => $primary_value,);
            $req_prep->execute($values);
            $req_prep->setFetchMode(PDO::FETCH_CLASS, $class_name);
            $tab = $req_prep->fetchAll();

            if(empty($tab)){
                return false;
            } else {
                return $tab[0];
            }
        }
        catch(PDOException $e)
        {
            if (Conf::getDebug())   echo $e->getMessage();
            else                    echo 'Exception reçue : ',  $e->getMessage(), "\n";
            die();
        }
    }

    public static function error($error){
        $displayError = $error;
        $view = 'error';
        $pagetitle= 'MyGuestHouse - Erreur';
        $powerNeeded = true;
        require File::build_path(array('view', 'view.php'));
    }

    public static function Init(){
        $hostname = Conf::getHostname();
        $database_name = Conf::getDatabase();
        $login = Conf::getLogin();
        $password = Conf::getPassword();

        try {
            self::$pdo = new PDO("mysql:host=$hostname;dbname=$database_name",$login,$password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            if (Conf::getDebug())   echo $e->getMessage();
            else                    echo "Une erreur est survenue ! Merci de réessayer plus tard";
            die();
        }

    }
}
Model::Init();
