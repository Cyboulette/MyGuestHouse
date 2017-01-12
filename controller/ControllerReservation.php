<?php

    class ControllerReservation {
        protected static $object = 'reservation';

        public static function reservations($message = null){
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
        public static function reservationChambre($message = null){
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
            $chambre = ModelChambre::select($idChambre);
            if($chambre == false) {
                $idChambre = null;
            }

            // Gestion des dates réservées
            $datesEncode = ModelReservation::encodeDatesForChambre($idChambre);
            $sriptDatesExclues = " <script> var date = ".$datesEncode."; </script> ";

            require File::build_path(array('view', 'main_view.php'));
        }

        /**
         *
         */
        public static function addReservation($message = null){
            if (isset($_POST['dateDebut'], $_POST['dateFin'], $_POST['idChambre'])) {
                $idUtilisateur = $_SESSION['idUser'];
                $dateDebut = htmlspecialchars($_POST['dateDebut']);
                $dateFin = htmlspecialchars($_POST['dateFin']);

                // Chargement des dates au bon format pour l'insertion dans la BD
                $dates = ControllerDefault::getDateForBdFormat($dateDebut, $dateFin);
                var_dump($dates['dateDebut']);
                var_dump($dates['dateFin']);

                $idChambre = htmlspecialchars($_POST['idChambre']);
                $data = array(
                    'idReservation' => NULL,
                    'idChambre' => $idChambre,
                    'idUtilisateur' => $idUtilisateur,
                    'dateDebut' => $dates['dateDebut'],
                    'dateFin' => $dates['dateFin'],
                    'annulee' => NULL
                );
                $save = ModelReservation::save($data);
                if ($save) {
                    $message = '<div class="alert alert-success">Reservation ajoutée avec succès !</div>';

                    //self::reservations($message);
                } else {
                    $message = '<div class="alert alert-danger">Echec de l\'ajout de la reservation !</div>';
                }
            } else {
                $message = '<div class="alert alert-danger">Vous ne pouvez pas laisser un champ vide !</div>';
            }
            self::reservationChambre($message);
        }

        /**
         *
         */
        public static function deleteReservationForm(){
            $retour = array(); //Tableau de retour
            if(isset($_POST['idReservation'])) {
                $idReservation = htmlspecialchars($_POST['idReservation']);
                $Reservation = ModelReservation::select($idReservation);
                if($Reservation != false) {
                    $form = '<form method="POST" role="form" action="index.php?controller=Reservation&action=deleteReservation">
						<div class="alert alert-info text-center">
							Confirmez vous la suppression de la reservation <b>'.htmlspecialchars($Reservation->get('idReservation')).'</b> ?
						</div>
						<input type="hidden" name="idReservation" value="'.$Reservation->get('idReservation').'">
						<input type="hidden" name="confirm" value="true">
						<div class="form-group">
							<button type="submit" class="btn btn-success">Confirmer</button>
							<button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Annuler">Annuler</button>
						</div>
					</form>';
                    $retour['result'] = true;
                    $retour['message'] = $form;
                } else {
                    $retour['result'] = false;
                    $retour['message'] = '<div class="alert alert-danger">La reservation demandée n\'existe pas !</div>';
                }
            } else {
                $retour['result'] = false;
                $retour['message'] = '<div class="alert alert-danger">Vous n\'avez pas envoyé correctement les données !</div>';
            }
            echo json_encode($retour);
        }

        public static function deleteReservation(){
            if (isset($_POST['idReservation'], $_POST['confirm'])) {
                $idReservation = htmlspecialchars($_POST['idReservation']);
                $confirm = htmlspecialchars($_POST['confirm']);
                $reservation = ModelReservation::select($idReservation);
                if ($reservation != false) {
                    if ($confirm == true) {
                        $chek = ModelReservation::delete($reservation->get('idReservation'));
                        $chekeleteReservation = ModelReservation::delete($reservation->get('idReservation'));
                        if ($chek) {
                            if ($chekeleteReservation) {
                                $message = '<div class="alert alert-success">La réservation a bien été supprimée !</div>';
                            } else {
                                $message = '<div class="alert alert-danger">Impossible de supprimer cette réservation !</div>';
                            }
                        } else {
                            $message = '<div class="alert alert-danger">Vous devez confirmer la suppression !</div>';
                        }
                    } else {
                        $message = '<div class="alert alert-danger">Cette réservation n\'existe pas</div>';
                    }
                } else {
                    $message = '<div class="alert alert-danger">Merci de remplir correctement le formulaire de suppression !</div>';
                }
                self::reservations($message);
            }
        }
    }