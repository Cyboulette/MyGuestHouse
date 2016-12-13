
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
        if(!is_null($idReservation) && !is_null($idChambre) && !is_null($idUtilisateur) && !is_null($dateDebut) && !is_null($dateFin)){
            $this->idReservation = $idReservation;
            $this->idChambre = $idChambre ;
            $this->idUtilisateur = $idUtilisateur ;
            $this->dateDebut = $dateDebut ;
            $this->dateFin = $dateFin ;

        }

    }


    /* GETTERS */

    public static function getReservationsEnCours(){
        try{
            $dateLocal = new DateTime();

            $sql = 'SELECT * FROM GH_Reservations WHERE dateDebut < :date AND dateFin > :date ';
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

    // TODO
    public static function getReservationsAnnulee(){}

    /**
     * Return the name of the user
     */
    public function getNomUtilisateur(){
        try{
            $sql="SELECT nomUtilisateur FROM GH_Utilisateurs WHERE idUtilisateur= :idUtilisateur";

            $rep = Model::$pdo->prepare($sql);

            $value = array(
                'idUtilisateur' => $this->idUtilisateur
            );

            $rep->execute($value);

            $rep->setFetchMode();
            $nom = $rep->fetch();

            return $nom;
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
            $sql="SELECT prenomUtilisateur FROM GH_Utilisateurs WHERE idUtilisateur= :idUtilisateur";

            $rep = Model::$pdo->prepare($sql);

            $value = array(
                'idUtilisateur' => $this->idUtilisateur
            );

            $rep->execute($value);

            $rep->setFetchMode();
            $prenom = $rep->fetch();

            return $prenom;
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


    /* COUNT */

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
     * Return the number of all canceled reservations
     */
    public static function getNombreReservationAnnule(){

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
}