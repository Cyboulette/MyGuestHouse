<?php
require_once 'Model.php';

class ModelNews extends Model {
    
    protected $idNews;
    protected $titreNews;
    protected $contenuNews;
    protected $dateNews;
    protected $publie;

    protected static $tableName = 'GH_News'; // Correspond au nom de la table SQL (pratique si différent du nom de l'objet)
    protected static $object = 'news'; // Correspond au nom de l'objet à créer
    protected static $primary = 'idNews'; // Correspond à la clé primaire de la table (pratique pour faire un read())

    public function __construct($idNews=null, $titreNews=null, $contenuNews=null, $dateNews=null, $publie=null){
        if(!is_null($idNews) && !is_null($titreNews) && !is_null($titreNews) && !is_null($contenuNews) && !is_null($dateNews) && !is_null($publie)){
            $this->idNews = $idNews;
            $this->titreNews = $titreNews;
            $this->contenuNews = $contenuNews;
            $this->dateNews = $dateNews;
            $this->publie = $publie;
        }
    }

    public static function getNews($nombreMax) {
        $class_name = 'Model'.ucfirst(static::$object);
        try {
            $sql = "SELECT * FROM `".static::$tableName."` ORDER BY dateNews DESC LIMIT 0, ".$nombreMax."";
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
}

?>