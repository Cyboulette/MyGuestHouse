
<?php
require_once 'Model.php';

class ModelReservation extends Model{

    protected $idReservation;
    protected $idChambre;
    protected $idUtilisateur;
    protected $dateDebut;
    protected $dateFin;

    protected static $tableName = 'GH_Reservations'; // Correspond au nom de la table SQL (pratique si différent du nom de l'objet)
    protected static $object = 'Reservation'; // Correspond au nom de l'objet à créer
    protected static $primary = 'idReservation'; // Correspond à la clé primaire de la table (pratique pour faire un read())


    public function __construct( $idReservation=NULL, $idChambre=NULL, $idUtilisateur=NULL, $dateDebut=NULL, $dateFin=NULL ){
        if(!is_null($idReservation) && !is_null($idChambre) && !is_null($idUtilisateur) && !is_null($dateDebut) && !is_null($dateFin)){
            $this->idReservation = $idReservation;
            $this->idChambre = $idChambre ;
            $this->idUtilisateur = $idUtilisateur ;
            $this->dateDebut = $dateDebut ;
            $this->dateFin = $dateFin ;

        }

    }


    /* SOME GETTERS WITH DATE */

    public static function getReservationsEnCours(){
        try{
            $dateLocal = new DateTime();

            $sql = 'SELECT * FROM '.self::$tableName.' WHERE dateDebut < :date AND dateFin >= :date ';
            $rep = Model::$pdo->prepare($sql);

            $values = array(
                'date' => $dateLocal->format('Y-m-d')
            );

            $rep->execute($values);

            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelReservation');
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

    public static function getReservationsEnAttente(){
        try{
            $dateLocal = new DateTime();

            $sql = 'SELECT * FROM GH_Reservations WHERE dateDebut > :date';
            $rep = Model::$pdo->prepare($sql);

            $values = array(
                'date' => $dateLocal->format('Y-m-d')
            );

            $rep->execute($values);

            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelReservation');
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

    public static function getReservationsFinis(){
        try{
            $dateLocal = new DateTime();

            $sql = 'SELECT * FROM GH_Reservations WHERE dateFin < :date ';
            $rep = Model::$pdo->prepare($sql);

            $values = array(
                'date' => $dateLocal->format('Y-m-d')
            );

            $rep->execute($values);

            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelReservation');
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

    public static function getReservationsAnnulee(){
        try{
            $sql = 'SELECT * FROM GH_Reservations WHERE annulee = 1 ';
            $rep = Model::$pdo->prepare($sql);

            $rep->execute();

            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelReservation');
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



    /* IN PROGRESS */

    /**
     * Return the number of day of the reservation
     */
    public  function getNombreJours(){
        try{
            $sql = "SELECT DATEDIFF('".$this->dateFin."','".$this->dateDebut."')";

            $rep = Model::$pdo->prepare($sql);

            $rep->setFetchMode(PDO::FETCH_UNIQUE);
            $rep->execute();

            $tab = $rep->Fetch();

            return $tab;
        } catch(PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage();
            }
            return false;
            die();
        }

    }

    /**
     * Return the total price of the reservation
     */
    public static function getPrixTotal(){

    }
}
?>