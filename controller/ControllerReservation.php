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

            require File::build_path(array('view', 'main_view.php'));
        }
    }