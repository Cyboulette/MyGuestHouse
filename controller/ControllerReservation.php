<?php
/* Make sure in production mode that $powerNeeded is not true auto */

    class ControllerReservation {
        protected static $object = 'reservation';

        public static function read($message = null){
            if(ControllerUtilisateur::isConnected()) {
                if(isset($_GET['idReservation'])) {
                    $idReservation = htmlspecialchars($_GET['idReservation']);
                    $reservation = ModelReservation::select($idReservation);
                    if($reservation != false) {
                        if($reservation->get('idUtilisateur') === $_SESSION['idUser']) {
                            $currentUser = ModelUtilisateur::selectCustom('idUtilisateur', $reservation->get('idUtilisateur'))[0];
                            $powerNeeded = true; // C'est le bon user dans tous les cas
                            $view = 'recapReservation';
                            $pagetitle = 'Récaputulatif d\'une reservation';

                            //informations client
                            $nomClient = htmlspecialchars($currentUser->get('nomUtilisateur'));
                            $prenomClient = htmlspecialchars($currentUser->get('prenomUtilisateur'));

                            //informations reservation
                            $reservation = ModelReservation::select($idReservation);
                            $dateDebut = $reservation->get('dateDebut');
                            $dateFin = $reservation->get('dateFin');
                            $prixTotal = $reservation->getPrixTotal();
                            $nomChambre = ModelChambre::select($reservation->get('idChambre'))->get('nomChambre');
                            $nombreNuits = $reservation->getNombreNuits();
                            $prixReservation = ModelChambre::select($reservation->get('idChambre'))->get('prixChambre')*$nombreNuits;

                            //informations prestations
                            $prestations = ModelPrestation::selectAllByReservation($idReservation);

                            require File::build_path(array('view', 'main_view.php'));
                        } else {
                            $message = '<div class="alert alert-danger">Vous essayer d\'afficher une reservation qui n\'est pas la vôtre.</div>';
                        }
                    } else {
                        $message = '<div class="alert alert-danger">Vous essayer d\'afficher une reservation qui n\'existe pas.</div>';
                    }
                } else {
                    $message = '<div class="alert alert-danger">Vous devez renseigner l\'id de la réservation pour la lire.</div>';
                }
                self::reservations($message);
            } else {
                ControllerDefault::error('Vous devez être connecté pour accéder à cette page !');
            }
        }

        public static function reservations($message = null){
            if(ControllerUtilisateur::isConnected()) {
                $currentUser = ModelUtilisateur::selectCustom('idUtilisateur', $_SESSION['idUser'])[0];
                $powerNeeded = true;
                $view = 'reservations';
                $pagetitle = 'Vos réservations';

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
            } else {
                ControllerDefault::error('Vous devez être connecté pour accéder à cette page !');
            }
        }

        public static function reservationChambre($message = null){
            if(ControllerUtilisateur::isConnected()) {
                $powerNeeded = true;
                $view = 'reservationChambre';
                $pagetitle = 'Faire une réservation';

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
            } else {
                ControllerDefault::error('Vous devez être connecté pour accéder à cette page !');
            }

        }

        public static function addReservation($message = null){
            if(ControllerUtilisateur::isConnected()) {
                $powerNeeded = true;

                if (isset($_POST['dateDebut'], $_POST['dateFin'], $_POST['idChambre'])) {
                    if(ControllerDefault::getDiffJours($_POST['dateDebut'], $_POST['dateFin']) > 0) {
                        if(ControllerDefault::verifToDatesDisabled($_POST['dateDebut'], $_POST['dateFin'], $_POST['idChambre'])) {
                            $idUtilisateur = $_SESSION['idUser'];
                            $dateDebut = htmlspecialchars($_POST['dateDebut']);
                            $dateFin = htmlspecialchars($_POST['dateFin']);

                            // Chargement des dates au bon format pour l'insertion dans la BD
                            $dates = ControllerDefault::getDateForBdFormat($dateDebut, $dateFin);

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
                                $message = '<div class="alert alert-success">Réservation ajoutée avec succès !</div>';
                                self::reservations($message);
                                exit();
                            } else {
                                $message = '<div class="alert alert-danger">Echec de l\'ajout de la reservation !</div>';
                            }
                        } else {
                            $message = '<div class="alert alert-danger">Vous devez effectuer 2 reservations distinctes s\'il y a déjà eu des réservations entre la date de début.</div>';
                        }
                    } else {
                        $message = '<div class="alert alert-danger">Vous ne pouvez pas réserver avec une date de fin anterieure à la date de début. Veuillez réessayer.</div>';
                    }
                } else {
                    $message = '<div class="alert alert-danger">Vous ne pouvez pas laisser un champ vide !</div>';
                }
                self::reservationChambre($message);
            } else {
                ControllerDefault::error('Vous devez être connecté pour accéder à cette page !');
            }
        }

        public static function managePrestationForReservation(){
            if(ControllerUtilisateur::isConnected()) {
                $powerNeeded = true;
                if (isset($_GET['idReservation']) && $_GET['idReservation'] != NULL) {
                    $idReservation = htmlspecialchars($_GET['idReservation']);
                    $reservation = ModelReservation::select($idReservation);

                    if ($reservation != null) {
                        if($reservation->get('idUtilisateur') === $_SESSION['idUser']){
                            $view = 'prestationFor';
                            $pagetitle = 'Prestations pour votre réservation';
                            $idReservation = $_GET['idReservation'];
                            $tab_prestation = ModelPrestation::selectAllByReservation($_GET['idReservation']);
                            $tab_allPrestation = ModelPrestation::selectAll();

                            require_once File::build_path(array("view", "main_view.php"));
                        } else {
                            $message = '<div class="alert alert-danger">Vous ne pouvez pas modifier la reservation de quelqu\'un d\'autre !</div>';
                            self::reservations($message);
                        }
                    } else {
                        $message = '<div class="alert alert-danger">Cette reservation n\'existe plus !</div>';
                        self::reservations($message);
                    }
                } else {
                    $message = '<div class="alert alert-danger">Vous ne pouvez modifier les prestations d\'une reservation sans connaître son ID !</div>';
                    self::reservations($message);
                }
            } else {
                ControllerDefault::error('Vous devez être connecté pour accéder à cette page !');
            }
        }

        public static function managedPrestationForReservation(){
            // Vérifier qu'on modifie bien une réservation qu'on possède.
            if(ControllerUtilisateur::isConnected()) {
                $powerNeeded = true;

                if (isset($_POST['idReservation']) && $_POST['idReservation'] != null) {
                    $idReservation = htmlspecialchars($_POST['idReservation']);
                    $reservation = ModelReservation::select($idReservation);

                    if($reservation->get('idUtilisateur') === $_SESSION['idUser']) {
                        $prestation = htmlspecialchars($_POST['prestations']);
                        $update = true;
                        $update = ModelPrestation::deleteAllByReservation($idReservation); //TODO vérifier si true
                        if ($prestation != null) {

                            foreach ($prestation as $key => $value) {
                                $update = ModelPrestation::saveByReservation($idReservation, $prestation[$key]);
                            }
                        }
                        if ($update != false) {
                            $message = '<div class="alert alert-success">Prestations modifiées avec succès !</div>';
                        } else {
                            $message = '<div class="alert alert-danger">Echec de la modification des prestations !</div>';
                        }
                    } else {
                        $message = '<div class="alert alert-danger">Vous ne pouvez pas modifier la reservation de quelqu\'un d\'autre !!</div>';
                    }
                } else {
                    $message = '<div class="alert alert-danger">Vous ne pouvez modifier les prestations d\'une resrvation sans connaître son ID !</div>';
                }
                self::reservations($message);
            } else {
                ControllerDefault::error('Vous devez être connecté pour accéder à cette page !');
            }
        }

        public static function annulerReservationForm(){
            if(ControllerUtilisateur::isConnected()) {
                $currentUser = ModelUtilisateur::selectCustom('idUtilisateur', $_SESSION['idUser'])[0];
                $powerNeeded = ($currentUser->getPower() == Conf::$power['user']);
                $powerNeeded = true; // pour les besoins du dév, à retirer

                $retour = array(); //Tableau de retour
                if(isset($_POST['idReservation'])) {
                    $idReservation = htmlspecialchars($_POST['idReservation']);
                    $Reservation = ModelReservation::select($idReservation);
                    if($Reservation != false) {
                        $form = '<form method="POST" role="form" action="index.php?controller=Reservation&action=annulerReservation">
						<div class="alert alert-info text-center">
							Confirmez vous l\'annulation de la reservation <b>'.htmlspecialchars($Reservation->get('idReservation')).'</b> ?
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
            } else {
                ControllerDefault::error('Vous devez être connecté pour accéder à cette page !');
            }
        }

        public static function annulerReservation(){
            if(ControllerUtilisateur::isConnected()) {
                if(isset($_POST['idReservation'], $_POST['confirm'])) {
                    $idReservation = htmlspecialchars($_POST['idReservation']);
                    $confirm = htmlspecialchars($_POST['confirm']);
                    $reservation = ModelReservation::select($idReservation);
                    if($reservation != false) {
                        if($confirm == true) {
                            $chekUpdate = ModelReservation::annulerReservation($idReservation);
                            if($chekUpdate) {
                                $message = '<div class="alert alert-success">La réservation a bien été annulée !</div>';
                            } else {
                                $message = '<div class="alert alert-danger">Impossible d\'annuler cette réservation !</div>';
                            }
                        } else {
                            $message = '<div class="alert alert-danger">Vous devez confirmer l\'annulation !</div>';
                        }
                    } else {
                        $message = '<div class="alert alert-danger">Cette réservation n\'existe pas</div>';
                    }
                } else {
                    $message = '<div class="alert alert-danger">Merci de remplir correctement le formulaire d\'annulation !</div>';
                }
            } else {
                ControllerDefault::error('Vous devez être connecté pour accéder à cette page !');
            }
            self::reservations($message);
        }

    }