<?php
require_once 'Model.php';

class ModelVisuelChambre extends Model {

    protected $idVisuel;
    protected $idChambre;
    protected $urlVisuel;

    protected static $tableName = 'GH_VisuelsChambres'; // Correspond au nom de la table SQL (pratique si différent du nom de l'objet)
    protected static $object = 'VisuelChambre'; // Correspond au nom de l'objet à créer
    protected static $primary = 'idVisuel'; // Correspond à la clé primaire de la table (pratique pour faire un read())

    public function __construct($idVisuel=null, $idChambre=null, $urlVisuel=null){
        if(!is_null($idVisuel) && !is_null($idChambre) && !is_null($urlVisuel)){
            $this->idVisuel = $idVisuel;
            $this->idChambre = $idChambre;
            $this->urlVisuel = $urlVisuel;
        }
    }

    public function update_url($url){
        try{
            $sql='UPDATE `'.self::$tableName.'` SET urlVisuel = '.$url.' WHERE idVisuel = :idVisuel';
            $updateUrl=Model::$pdo->prepare($sql);

            $value=array(
                'idVisuel' => $this->idVisuel
            );

            $updateUrl->execute($value);
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