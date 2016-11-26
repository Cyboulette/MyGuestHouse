<?php
require_once 'Model.php';

class ModelChambre extends Model
{


    protected $idChambre;
    protected $nomChambre;
    protected $descriptionChambre;
    protected $prixChambre;
    protected $superficieChambre;

    protected static $tableName = 'chambres'; // Correspond au nom de la table SQL (pratique si différent du nom de l'objet)
    protected static $object = 'chambres'; // Correspond au nom de l'objet à créer (ici produit)
    protected static $primary = '$idChambre';

    public function __construct($idChambre=null, $nomChambre=null, $descriptionChambre=null, $prixChambre=null,$superficieChambre=null ){
        if(!is_null($idChambre) && !is_null($nomChambre) && !is_null($descriptionChambre) && !is_null($prixChambre) && !is_null($superficieChambre))
        {
            $this->idChambre            =$idChambre;
            $this->nomChambre           =$nomChambre;
            $this->descriptionChambre   =$descriptionChambre;
            $this->prixChambre          =$prixChambre;
            $this->superficieChambre    =$superficieChambre;
        }
    }


    // Do an INSERT INTO
    public function save(){
        try
        {
            $sql = 'INSERT INTO `'.self::$tableName.'` (idUtilisateur, nomChambre, descriptionChambre, prixChambre, , superficieChambre) VALUES (NULL, :nomChambre, :descriptionChambre, :prixChambre, :superficieChambre)';
            $addUser = Model::$pdo->prepare($sql);

            $values = array(
                'nomChambre' => strip_tags($this->get('nomChambre')),
                'descriptionChambre' => strip_tags($this->get('descriptionChambre')),
                'prixChambre' => strip_tags($this->get('prixChambre')),
                'superficieChambre' => strip_tags($this->get('superficieChambre'))
            );

            $addUser->execute($values);
            return true;
        }
        catch(PDOException $e)
        {
            if (Conf::getDebug())   echo $e->getMessage();
            else                    echo 'Exception reçue : ',  $e->getMessage(), "\n";
            die();
        }
    }

}