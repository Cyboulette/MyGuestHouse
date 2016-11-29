<?php
require_once 'Model.php';

class ModelChambre extends Model {
    
    protected $idChambre;
    protected $nomChambre;
    protected $descriptionChambre;
    protected $prixChambre;
    protected $superficieChambre;

    protected static $tableName = 'GH_Chambres'; // Correspond au nom de la table SQL (pratique si différent du nom de l'objet)
    protected static $object = 'chambre'; // Correspond au nom de l'objet à créer
    protected static $primary = 'idChambre'; // Correspond à la clé primaire de la table (pratique pour faire un read())

    public function __construct($idChambre=null, $nomChambre=null, $descriptionChambre=null, $prixChambre=null, $superficieChambre=null){
        if(!is_null($idChambre) && !is_null($nomChambre) && !is_null($descriptionChambre) && !is_null($prixChambre) && !is_null($superficieChambre)){
            $this->idChambre = $idChambre;
            $this->nomChambre = $nomChambre;
            $this->descriptionChambre = $descriptionChambre;
            $this->prixChambre = $prixChambre;
            $this->superficieChambre = $superficieChambre;
        }
    }

}