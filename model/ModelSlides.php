<?php
require_once 'Model.php';

class ModelSlides extends Model {
    
    protected $idNews;
    protected $titreNews;
    protected $contenuNews;
    protected $dateNews;
    protected $publie;

    protected static $tableName = 'GH_Slides'; // Correspond au nom de la table SQL (pratique si différent du nom de l'objet)
    protected static $object = 'slides'; // Correspond au nom de l'objet à créer
    protected static $primary = 'idSlide'; // Correspond à la clé primaire de la table (pratique pour faire un read())

    public function __construct($idSlide=null, $urlSlide=null, $textSlide=null){
        if(!is_null($idSlide) && !is_null($urlSlide)){
            $this->idSlide = $idSlide;
            $this->urlSlide = $urlSlide;
            $this->textSlide = $textSlide;
        }
    }

    public static function getSlides($nombreMax) {
        $class_name = 'Model'.ucfirst(static::$object);
        try {
            $sql = "SELECT * FROM `".static::$tableName."` ORDER BY idSlide LIMIT 0, ".$nombreMax."";
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