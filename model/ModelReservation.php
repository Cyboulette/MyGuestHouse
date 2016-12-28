
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

            $sql = 'SELECT * FROM '.self::$tableName.' WHERE dateDebut <= :date AND dateFin >= :date ';
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

    /**
     * Return the number of day of the reservation
     */
    public  function getNombreJours(){
        try{
            $sql = "SELECT DATEDIFF(:dateFin,:dateDebut)";

            $rep = Model::$pdo->prepare($sql);


            $values = array(
                'dateDebut' => $this->dateDebut,
                'dateFin' => $this->dateFin
            );
            $rep->setFetchMode(PDO::FETCH_UNIQUE);
            $rep->execute($values);

            $tab = $rep->Fetch();

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
     * Return the total price of the reservation
     */
    public function getPrixTotal(){
        try{
            $sql = "
                SELECT c.prixChambre*:tag_nombreJour+IFNULL(SUM(p.prix),0) FROM GH_Chambres c, GH_ReservationsPrestation rp, GH_Prestations p WHERE rp.idPrestation = p.idPrestation AND rp.idReservation = :tag_idReservation AND c.idChambre = :tag_idChambre

            ";

            $rep = Model::$pdo->prepare($sql);

            $values = array(
                'tag_idChambre' => $this->idChambre,
                'tag_idReservation' => $this->idReservation,
                'tag_nombreJour' => $this->getNombreJours()
            );
            $rep->execute($values);

            $tab = $rep->Fetch();

            return $tab[0];
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
