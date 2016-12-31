<?php
	class ControllerAdminReservations extends ControllerAdmin
	{
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

		public static function addReservation()
		{ // IN PROGRESS
			self::isAdmin();
			if (isset($_POST['idUtilisateur'], $_POST['dateDebut'], $_POST['dateFin'], $_POST['idChambre'])) {
				$idUtilisateur = htmlspecialchars($_POST['idUtilisateur']);
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

		// Edition de : idReservation, idChambre, dateDébut, DateFin
		public static function editReservation()
		{
			self::isAdmin();
			if (isset($_POST['idReservation'], $_POST['idUtilisateur'], $_POST['dateDebut'], $_POST['dateFin'], $_POST['idChambre'])) {
				$idReservation = htmlspecialchars($_POST['idReservation']);
				$idUtilisateur = htmlspecialchars($_POST['idUtilisateur']);
				$dateDebut = htmlspecialchars($_POST['dateDebut']);
				$dateFin = htmlspecialchars($_POST['dateFin']);
				$idChambre = htmlspecialchars($_POST['idChambre']);
				$checkReservation = ModelReservation::select($idReservation);
				//var_dump($checkReservation);
				if ($checkReservation) {
					if (!empty($idUtilisateur) && !ctype_space($idUtilisateur)) {
						if (!empty($idChambre) && !ctype_space($idChambre)) {
							if (!empty($dateDebut) && !ctype_space($dateDebut)) {
								if (!empty($dateFin) && !ctype_space($dateFin)) {
									if (DateTime::createFromFormat('Y-m-d', $dateDebut) !== false && DateTime::createFromFormat('Y-m-d', $dateFin) !== false) {
										$data = array(
											'idReservation' => $idReservation,
											'idUtilisateur' => $idUtilisateur,
											'idChambre' => $idChambre,
											'dateDebut' => $dateDebut,
											'dateFin' => $dateFin,
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
				$reservation = ModelReservation::select($_GET['idReservation']);
				if ($reservation != null) {
					$view = 'prestationFor';
					$pagetitle = 'Administration - Editeur de chambre';
					$template = 'admin';
					$idReservation = $_GET['idReservation'];
					$tab_prestation = ModelPrestation::selectAllByReservation($_GET['idReservation']);
					$tab_allPrestation = ModelPrestation::selectAll();
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

		public static function deleteReservationForm(){
			self::isAdmin();
			$retour = array(); //Tableau de retour
			if(isset($_POST['idReservation'])) {
				$idReservation = htmlspecialchars($_POST['idReservation']);
				$Reservation = ModelReservation::select($idReservation);
				if($Reservation != false) {
					$form = '<form method="POST" role="form" action="index.php?controller=adminReservations&action=deleteReservation">
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
			self::isAdmin();
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
?>