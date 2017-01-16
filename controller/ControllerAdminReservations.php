<?php
	class ControllerAdminReservations extends ControllerAdmin
	{

		public static function read($message = null){
			self::isAdmin();
			if(ControllerUtilisateur::isConnected()) {
				if(isset($_GET['idReservation'])) {
					$idReservation = htmlspecialchars($_GET['idReservation']);
					$reservation = ModelReservation::select($idReservation);
					if($reservation != false) {
						$currentUser = ModelUtilisateur::selectCustom('idUtilisateur', $reservation->get('idUtilisateur'))[0];
						$powerNeeded = true; // C'est le bon user dans tous les cas
						$view = 'recapReservation';
						$pagetitle = 'Récaputulatif d\'une reservation';
						$template = 'admin';


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

		// Gestion des réservations : view/amin/viewAllReservation.php
		public static function reservations($message = null)
		{
			$powerNeeded = self::isAdmin();
			$view = 'viewAllReservation';
			$pagetitle = 'Administration - Gestion des réservations';
			$template = 'admin';
			// appel des methodes de selection
			if (!isset($_GET['mode'])) {
				$_GET['mode'] = 'enattentes';
			}
			switch ($_GET['mode']) {
				case 'encours':
					$tab_reservations = ModelReservation::getReservationsEnCours();
					break;
				case 'enattentes':
					$tab_reservations = ModelReservation::getReservationsEnAttente();
					break;
				case 'finis':
					$tab_reservations = ModelReservation::getReservationsFinis();
					break;
				case 'annulees':
					$tab_reservations = ModelReservation::getReservationsAnnulee();
					break;
			}
			require_once File::build_path(array("view", "main_view.php"));
		}

		public static function addReservation() {
			self::isAdmin();
			if (isset($_POST['idUtilisateur'], $_POST['dateDebut'], $_POST['dateFin'], $_POST['idChambre'])) {
				if(ControllerDefault::getDiffJours($_POST['dateDebut'], $_POST['dateFin']) > 0){
					if(ControllerDefault::verifToDatesDisabled($_POST['dateDebut'], $_POST['dateFin'], $_POST['idChambre'])) {

						$idUtilisateur = htmlspecialchars($_POST['idUtilisateur']);
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
							$message = '<div class="alert alert-success">Reservation ajoutée avec succès !</div>';
							self::reservations($message);
						} else {
							$message = '<div class="alert alert-danger">Echec de l\'ajout de la reservation !</div>';
						}
					} else {
						$message = '<div class="alert alert-danger">Vous devez effectuer 2 reservations distincts s\'il y a deja eu des reservations entre la date de début. </div>';
					}
				} else {
					$message = '<div class="alert alert-danger">Vous ne pouvez pas réserver avec une date de fin antèrieur à la date de début. Veuillez réessayer</div>';
				}
			} else {
				$message = '<div class="alert alert-danger">Vous ne pouvez pas laisser un champ vide !</div>';
			}
			self::manageReservation($message);
		}

		// Edition de : idReservation, idChambre, dateDébut, DateFin
		public static function editReservation()
		{
			self::isAdmin();
			if (isset($_POST['idReservation'], $_POST['idUtilisateur'], $_POST['dateDebut'], $_POST['dateFin'], $_POST['idChambre'])) {
				if(ControllerDefault::getDiffJours($_POST['dateDebut'], $_POST['dateFin']) > 0) {
					if(ControllerDefault::verifToDatesDisabled($_POST['dateDebut'], $_POST['dateFin'], $_POST['idChambre'])) {
						$idReservation = htmlspecialchars($_POST['idReservation']);
						$idUtilisateur = htmlspecialchars($_POST['idUtilisateur']);
						$dateDebut = htmlspecialchars($_POST['dateDebut']);
						$dateFin = htmlspecialchars($_POST['dateFin']);
						$idChambre = htmlspecialchars($_POST['idChambre']);
						$checkReservation = ModelReservation::select($idReservation);
						if ($checkReservation) {
							if (!empty($idUtilisateur) && !ctype_space($idUtilisateur)) {
								if (!empty($idChambre) && !ctype_space($idChambre)) {
									if (!empty($dateDebut) && !ctype_space($dateDebut)) {
										if (!empty($dateFin) && !ctype_space($dateFin)) {
											$dates = ControllerDefault::getDateForBdFormat($dateDebut, $dateFin);
											if (DateTime::createFromFormat('Y-m-d', $dates['dateDebut']) !== false && DateTime::createFromFormat('Y-m-d', $dates['dateFin']) !== false) {
												$data = array(
													'idReservation' => $idReservation,
													'idUtilisateur' => $idUtilisateur,
													'idChambre' => $idChambre,
													'dateDebut' => $dates['dateDebut'],
													'dateFin' => $dates['dateFin'],
													'annulee' => null
												);
												$testSaveReservation = ModelReservation::update_gen($data, 'idReservation');
												if ($testSaveReservation) {
													$message = '<div class="alert alert-success">La réservation a bien été modifiée !</div>';
													self::reservations($message);
													exit(); // On ne veut pas que le code self::manageReservation s'exécute :)
												} else {
													$message = '<div class="alert alert-danger">Merci de contacter le support de MyGuestHouse !</div>';
												}
											} else {
												$message = '<div class="alert alert-danger">Vous devez saisir des dates au format jj/mm/aaaa</div>';
											}
										} else {
											$message = '<div class="alert alert-danger">Vous devez saisir une date de fin non vide</div>';
										}
									} else {
										$message = '<div class="alert alert-danger">Vous devez saisir une date de début non vide</div>';
									}
								} else {
									$message = '<div class="alert alert-danger">Vous devez saisir identifiant de chambre non vide</div>';
								}
							} else {
								$message = '<div class="alert alert-danger">Vous devez saisir identifiant client non vide</div>';
							}
						} else {
							$message = '<div class="alert alert-danger">La réservation que vous tentez de modifier n\'existe pas</div>';
						}
					} else {
						$message = '<div class="alert alert-danger">Vous devez effectuer 2 reservations distincts s\'il y a deja eu des reservations entre la date de début. </div>';
					}
				} else {
					$message = '<div class="alert alert-danger">Vous ne pouvez pas réserver avec une date de fin antèrieur à la date de début. Veuillez réessayer</div>';
				}


			}
			self::manageReservation($message);
		}

		public static function manageReservation($message = NULL)
		{ // IN PROGRESS
			if (isset($_GET['type'])) {
				$type = $_GET['type'];
				if ($type == "add" || $type == "edit") {
					if ($type == "add") {
						$titreAction = 'Ajouter une reservation';
					} elseif ($type == "edit") {
						$titreAction = 'Modifier une reservation';
						if (isset($_GET['idReservation']) && !empty($_GET['idReservation'])) {
							$idReservation = htmlspecialchars($_GET['idReservation']);
							$readReservation = ModelReservation::select($idReservation);

							if (!$readReservation) {
								self::reservations('<div class="alert alert-danger">Impossible de modifier cette reservation, elle n\'existe pas !</div>');
							}
						} else {
							self::reservations('<div class="alert alert-danger">Pour pouvoir modifier une reservation il faut son ID</div>');
						}
					}
					$powerNeeded = self::isAdmin();
					$view = 'manageReservation';
					$template = 'admin';
					$tab_reservations = ModelReservation::selectAll();
					$pagetitle = 'Administration - ' . $titreAction;


					// Gestion des dates réservées
					if(isset($_GET['idReservation'])){
						$idChambre = ModelReservation::select($_GET['idReservation'])->get('idChambre');

					} else {
						$idChambre = $_POST['idChambre'];
					}
					$datesEncode = modelReservation::encodeDatesForChambre($idChambre);
					$sriptDatesExclues = " <script> var date = ".$datesEncode."; </script> ";

					require_once File::build_path(array("view", "main_view.php"));
				} else {
					ControllerDefault::error('Vous devez préciser si vous souhaitez modifier ou ajouter une reservation !', 'admin');
				}
			} else {
				ControllerDefault::error('Il faut préciser un paramètre de type de gestion de reservations !', 'admin');
			}
		}

		// Gestion des prestations pour les reservations
		public static function managePrestationForReservation()
		{
			$powerNeeded = self::isAdmin();
			if (isset($_GET['idReservation']) && $_GET['idReservation'] != NULL) {
				$idReservation = htmlspecialchars($_GET['idReservation']);
				$reservation = ModelReservation::select($idReservation);
				if ($reservation != null) {
					$view = 'prestationFor';
					$pagetitle = 'Administration';
					$template = 'admin';
					$idChambre = $reservation->get('idChambre');
					$tab_prestations = ModelPrestation::selectAllByChambre($idChambre);
					$tab_prestationsReservation = ModelPrestation::selectAllByReservation($idReservation);

					require_once File::build_path(array("view", "main_view.php"));
				} else {
					$message = '<div class="alert alert-danger">Cette reservation n\'existe plus !</div>';
					ControllerAdminReservations::reservations($message);
				}
			} else {
				$message = '<div class="alert alert-danger">Vous ne pouvez modifier les prestations d\'une reservation sans connaître son ID !</div>';
				ControllerAdminReservations::reservations($message);
			}
		}

		public static function managedPrestationForReservation()
		{
			$powerNeeded = self::isAdmin();
			if (isset($_POST['idReservation']) && $_POST['idReservation'] != null) {
				$idReservation = $_POST['idReservation'];
				$prestation = $_POST['prestations'];
				$update = true;
				$update = ModelPrestation::deleteAllByReservation($idReservation); //TODO vérifier si true
				if ($prestation != null) {
					foreach ($prestation as $key => $value) {
						$update = ModelPrestation::saveByReservation($idReservation, $prestation[$key]);
					}
				}
				if ($update != false) {
					$message = '<div class="alert alert-success">Prestation modifiée avec succès !</div>';
				} else {
					$message = '<div class="alert alert-danger">Echec de la modification de la prestation !</div>';
				}
			} else {
				$message = '<div class="alert alert-danger">Vous ne pouvez modifier les prestations d\'une resrvation sans connaître son ID !</div>';
			}
			ControllerAdminReservations::reservations($message);
		}

		public static function preDeleteItem() {
			self::deleteItemForm("adminReservations", "ModelReservation", "de la réservation n°", "idReservation", 'idReservation');
		}

		public static function deleteItem() {
			self::isAdmin();
			if(isset($_POST['idItem'], $_POST['confirm'])) {
				$idItem = htmlspecialchars($_POST['idItem']);
				$confirm = htmlspecialchars($_POST['confirm']);
				$item = ModelReservation::select($idItem);
				if($item != false) {
					if($confirm == true) {
						$checkDeleteItem = ModelReservation::delete($item->get('idReservation'));
						if($checkDeleteItem) {
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
?>