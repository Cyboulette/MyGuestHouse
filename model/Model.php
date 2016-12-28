<?php

require_once File::build_path(array('config', 'Conf.php'));

/*
 * Model provides data management and interactions to the database
 */
class Model
{
    /*
     * PDO Object provides the query management
     */
    public static $pdo;

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

    public static function selectAll(){
        $table_name = static::$tableName;
        $class_name = 'Model'.ucfirst(static::$object);

        try {
            $sql = "SELECT * FROM `".$table_name."`";
            $rep = Model::$pdo->query($sql);

            $rep->setFetchMode(PDO::FETCH_CLASS, $class_name);
            $tab = $rep->FetchAll();
            return $tab;
        } catch(PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage();
            }
            return false;
            die();
        }
    }

    public static function select($primary_value){
        $table_name = static::$tableName;
        $class_name = 'Model'.ucfirst(static::$object);
        $primary_key = static::$primary;

        try {
            $sql = "SELECT * FROM `".$table_name."` WHERE ".$primary_key." = :primary_val";
            $req_prep = Model::$pdo->prepare($sql);

            $values = array("primary_val" => $primary_value);
            $req_prep->execute($values);
            $req_prep->setFetchMode(PDO::FETCH_CLASS, $class_name);
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

    public static function count(){
        $table_name = static::$tableName;
        $class_name = 'Model'.ucfirst(static::$object);

        try {
            $sql = "SELECT COUNT(*) FROM `".$table_name."`";
            $rep = Model::$pdo->query($sql);

            $rep->setFetchMode(PDO::FETCH_NUM);
            $tab = $rep->Fetch();

            if(empty($tab)) {
                return 0;
            }
    
            return $tab[0];
        } catch(PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage();
            }
            return false;
            die();
        }
    }

    /*
     *   Fonction générique qui permet d'insérer dans une table
     *   $data = les colonnes de la table avec les valeurs associées
     *   $typeReturn = NULL par défaut, ou id, si id, retourne le dernier id ajouté
     */
    public static function save($data, $typeReturn = NULL) {
        try {
            $sql = 'INSERT INTO `'.static::$tableName.'` VALUES (';


            foreach ($data as $key => $value) {
                $sql .= ':'.$key.',';
            }

            $sql = substr($sql, 0, -1);
            $sql .= ')';

            $add = Model::$pdo->prepare($sql);
            $add->execute($data);
            if($typeReturn == 'id') {
                $lastId = Model::$pdo->lastInsertId();
                return $lastId;
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

    /*
     *  Fonction générique qui permet de supprimer de la table du model courant la valeur de la clé primaire
     *  $data = valeur de la clé primaire
     */
    public static function delete($data) {
        $table_name = static::$tableName;
        $primary_key = static::$primary;
        try {
          $sql = "DELETE FROM `".$table_name."` WHERE `".$primary_key."` = :".$primary_key."";
          $rep = Model::$pdo->prepare($sql);
          $values = array(
            $primary_key => $data
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

    /*
     *   Fonction générique qui permet de sélectionner tous résultats pour une clé particulière et sa valeur ($data) associée
     *   $cle = le nom de la colonne à vérifier
     *   $data = la valeur
     */
    public static function selectCustom($cle, $data) {
        $table_name = static::$tableName;
        $class_name = 'Model'.ucfirst(static::$object);
        try {
            $sql = "SELECT * from `".$table_name."` WHERE `".$cle."` = :".$cle."";
            $req_generique = Model::$pdo->prepare($sql);

            $values = array(
                $cle => $data
            );

            $req_generique->execute($values);
            $req_generique->setFetchMode(PDO::FETCH_CLASS, $class_name);
            $tab_gen = $req_generique->fetchAll();
            return $tab_gen;
        } catch(PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage();
            }
            return false;
            die();
        }
    }

    public static function update_gen($data, $whereCle) {
        try {
            $sql = 'UPDATE `'.static::$tableName.'` SET ';

            foreach ($data as $key => $value) {
                $sql .= $key.' = :'.$key.', ';
            }
            $sql = substr($sql, 0, -2);
            $sql .= ' WHERE '.$whereCle.' = :'.$whereCle;
            
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

    /* This part is good */
    public static function Init(){
        $hostname = Conf::getHostname();
        $database_name = Conf::getDatabase();
        $login = Conf::getLogin();
        $password = Conf::getPassword();

        try {
            self::$pdo = new PDO("mysql:host=$hostname;dbname=$database_name",$login,$password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
Model::Init();
?>