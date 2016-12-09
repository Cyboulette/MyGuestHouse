<?php
require_once 'Model.php';

class ModelReservation extends Model{

    protected $idReservation;
    protected $idChambre;
    protected $idUtilisateur;
    protected $dateDebut;
    protected $dateFin;

    protected static $tableName = 'GH_Reservations'; // Correspond au nom de la table SQL (pratique si différent du nom de l'objet)
    protected static $object = 'reservation'; // Correspond au nom de l'objet à créer
    protected static $primary = 'idReservation'; // Correspond à la clé primaire de la table (pratique pour faire un read())



    public function __construct( $idReservation=NULL, $idChambre=NULL, $idUtilisateur=NULL, $dateDebut=NULL, $dateFin=NULL ){
        $this->idReservation = $idReservation;
        $this->idChambre = $idChambre ;
        $this->idUtilisateur = $idUtilisateur ;
        $this->dateDebut = $dateDebut ;
        $this->dateFin = $dateFin ;

    }


    /**
     * Return the name of the user
     */
    public function getNomUtilisateur(){
        try{
            $sql="SELECT u.nomUtilisateur FROM GH_Utilisateurs u, ".self::$tableName." r WHERE r.idUtilisateur=u.idUtilisateur AND r.idReservation= :idReservation";

            $getNombre = Model::$pdo->prepare($sql);

            $value = array(
                'idReservation' => $this->idReservation
            );

            $getNombre->execute($value);
            return true;
        } catch(PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage();
            }
            return false;
            die();
        }
    }

    /**
     * Return the first name of the user
     */
    public function getPrenomUtilisateur(){
        try{
            $sql="SELECT u.prenomUtilisateur FROM GH_Utilisateurs u, ".self::$tableName." r WHERE r.idUtilisateur=u.idUtilisateur AND r.idReservation= :idReservation";

            $getNombre = Model::$pdo->prepare($sql);

            $value = array(
                'idReservation' => $this->idReservation
            );

            $getNombre->execute($value);
            return true;
        } catch(PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage();
            }
            return false;
            die();
        }
    }

    public function getNomChambre(){
        try{
            $sql="SELECT c.nomChambre FROM GH_Chambres c, ".self::$tableName." r WHERE r.idChambre=c.idChambre AND r.idReservation= :idReservation";

            $getNombre = Model::$pdo->prepare($sql);

            $value = array(
                'idReservation' => $this->idReservation
            );

            $getNombre->execute($value);
            return true;
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
    public static function getNombreJours(){

    }

    /**
     * Return the total price of the reservation
     */
    public static function getPrixTotal(){

    }






/* IN PROGRESS */

    /**
     * Return the number of all currents reservations
     * Gérer les formats des dates
     */
    public static function getNombreReservationEnCours(){
        try{
            $dateLocal = new DateTime();

            $sql = 'SELECT COUNT(*) FROM GH_Reservations WHERE dateDebut < :date AND dateFin > :date ';
            $getNombre = Model::$pdo->prepare($sql);

            $values = array(
                'date' => $dateLocal->format('Y-m-d')
            );

            $getNombre->execute($values);

            $getNombre->setFetchMode(PDO::FETCH_NUM);
            $tab = $getNombre->Fetch();

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

    /**
     * Return the number of all reservations in wait
     */
    public static function getNombreReservationEnAttente(){
        try{
            $dateLocal = new DateTime();

            $sql = 'SELECT COUNT(*) FROM GH_Reservations WHERE dateDebut > :date';
            $getNombre = Model::$pdo->prepare($sql);

            $values = array(
                'date' => $dateLocal->format('Y-m-d')
            );

            $getNombre->execute($values);

            $getNombre->setFetchMode(PDO::FETCH_NUM);
            $tab = $getNombre->Fetch();

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

    /**
     * Return the number of all finished reservations
     */
    public static function getNombreReservationFinis(){
        try{
            $dateLocal = new DateTime();

            $sql = 'SELECT COUNT(*) FROM GH_Reservations WHERE dateDebut < :date ';
            $getNombre = Model::$pdo->prepare($sql);

            $values = array(
                'date' => $dateLocal->format('Y-m-d')
            );

            $getNombre->execute($values);

            $getNombre->setFetchMode(PDO::FETCH_NUM);
            $tab = $getNombre->Fetch();

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

    /**
     * I don't know want whe can return x)
     */
    public static function getNombreReservationProbleme(){

    }
}