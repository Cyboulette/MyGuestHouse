<?php

    class ControllerReservation {
        protected static $object = 'reservation';

        public static function reservations(){
            $view = 'reservations';
            $pagetitle = 'Vos reservations';
            $powerNeeded = true;

            $currentUser = ModelUtilisateur::selectCustom('idUtilisateur', $_SESSION['idUser'])[0];
            $idUtilisateur = $currentUser->get('idUtilisateur');
            if (!isset($_GET['mode'])) {
                $_GET['mode'] = 'enattentes';
            }
            switch($_GET['mode']){
                case 'enattentes' :
                    $tab_reservations = ModelReservation::getReservationsEnAttente($idUtilisateur);
                    break;
                case 'encours' :
                    $tab_reservations = ModelReservation::getReservationsEnCours($idUtilisateur);
                    break;
                case 'annulees' :
                    $tab_reservations = ModelReservation::getReservationsAnnulee($idUtilisateur);
                    break;
                case 'finis' :
                    $tab_reservations = ModelReservation::getReservationsFinis($idUtilisateur);
                    break;
            }

            require File::build_path(array('view', 'main_view.php'));
        }

        /**
         * Provide to the user to choose a room with and the date to reserve it
         **/
        public static function reservationChambre(){
            $view = 'reservationChambre';
            $pagetitle = 'Faire une reservation';
            $powerNeeded = true;
            $idChambre = null;
            if(isset($_GET['idChambre'])) {
                $idChambre = htmlspecialchars($_GET['idChambre']);
            } else if(isset($_POST['idChambre'])) {
                $idChambre = htmlspecialchars($_POST['idChambre']);
            } else {
                $idChambre = null;
            }

            require File::build_path(array('view', 'main_view.php'));
        }

        /**
         *
         */
        public static function addReservation(){
            if (isset($_POST['dateDebut'], $_POST['dateFin'], $_POST['idChambre'])) {
                $idUtilisateur = $_SESSION['idUser'];
                $dateDebut = htmlspecialchars($_POST['dateDebut']);
                $dateFin = htmlspecialchars($_POST['dateFin']);
                $idChambre = htmlspecialchars($_POST['idChambre']);
                $data = array(
                    'idReservation' => NULL,
                    'idChambre' => $idChambre,
                    'idUtilisateur' => $idUtilisateur,
                    'dateDebut' => $dateDebut,
                    'dateFin' => $dateFin,
                    'annulee' => NULL
                );
                $save = ModelReservation::save($data);
                if ($save) {
                    $message = '<div class="alert alert-success">Reservation ajoutée avec succès !</div>';
                    self::reservations($message);
                } else {
                    $message = '<div class="alert alert-danger">Echec de l\'ajout de la reservation !</div>';
                }
            } else {
                $message = '<div class="alert alert-danger">Vous ne pouvez pas laisser un champ vide !</div>';
            }
            self::manageReservation($message);
        }
    }