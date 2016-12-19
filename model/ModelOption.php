<?php
require_once 'Model.php';

class ModelOption extends Model {
    
    protected $idOption;
    protected $nomOption;
    protected $valueOption;

    protected static $tableName = 'GH_Options'; // Correspond au nom de la table SQL (pratique si différent du nom de l'objet)
    protected static $object = 'option'; // Correspond au nom de l'objet à créer
    protected static $primary = 'idOption'; // Correspond à la clé primaire de la table (pratique pour faire un read())

    public function __construct($idOption=null, $nomOption=null, $valueOption=null){
        if(!is_null($idOption) && !is_null($nomOption) && !is_null($valueOption)){
            $this->idOption = $idOption;
            $this->nomOption = $nomOption;
            $this->valueOption = $valueOption;
        }
    }
}

?>