<?php
	class ControllerAdminReservations extends ControllerAdmin {
		// Gestion des réservations : view/amin/viewAllReservation.php
		public static function reservations($message = null){
			$powerNeeded = self::isAdmin();
			$view = 'viewAllReservation';
			$pagetitle = 'Administration - Gestion des réservations';
			$template = 'admin';
			// appel des methodes de selection
			if(!isset($_GET['mode'])){ $_GET['mode'] = 'enAttente'; }
			switch ($_GET['mode']){
				case 'encours':
					$tab_reservations=ModelReservation::getReservationsEnCours();
					break;
				case 'enattentes':
					$tab_reservations=ModelReservation::getReservationsEnAttente();
					break;
				case 'finis':
					$tab_reservations=ModelReservation::getReservationsFinis();
					break;
				case 'annulees':
					$tab_reservations=ModelReservation::getReservationsAnnulee();
					break;
			}
			require_once File::build_path(array("view", "main_view.php"));
		}
		
		public static function addReservation(){ // IN PROGRESS
			self::isAdmin();
			if(isset($_POST['idReservation'])){
				if($_POST['idUtilisateur']!=null && $_POST['dateDebut']!=null && $_POST['dateFin']!=null && $_POST['idChambre']!=null ){
					$idUtilisateur = htmlspecialchars($_POST['idUtilisateur']);
					$dateDebut = htmlspecialchars($_POST['dateDebut']);
					$dateFin = htmlspecialchars($_POST['dateFin']);
					$idChambre = htmlspecialchars($_POST['idChambre']);
					$data = array(
						'idReservation' => null,
						'idUtilisateur' => $idUtilisateur,
						'dateDebut' => $dateDebut,
						'dateFin' => $dateFin,
						'idChambre' => $idChambre,
						'annulee' => null
					);
					$save = ModelPrestation::save($data);
					if($save) {
						$message = '<div class="alert alert-success">Reservation ajoutée avec succès !</div>';
						self::news($message);
					} else {
						$message = '<div class="alert alert-danger">Echec de l\'ajout de la reservation !</div>';
					}
				} else {
					$message = '<div class="alert alert-danger">Vous ne pouvez pas laisser un champ vide !</div>';
				}
			} else {
				$message = '<div class="alert alert-danger">Nous navons pas pu recuperer vos choix !</div>';
			}
			self::manageReservation($message);
		}

		public static function editReservation(){
			self::isAdmin();
			if(isset($_POST['idReservation']) && isset($_POST['idUtilisateur']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['dateDebut']) && isset($_POSTT['dateFin']) && isset($_POST['idChambre'])) {
				$idReservation = htmlspecialchars($_POST['idReservation']);
				$idUtilisateur = htmlspecialchars($_POST['idUtilisateur']);
				$dateDebut = htmlspecialchars($_POST['dateNews']);
				$dateFin = htmlspecialchars($_POST['etatNews']);
				$idChambre = htmlspecialchars($_POST['idChambre']);
				$checkReservation = ModelReservation::select($idReservation);
				if ($checkReservation) {
					if (!empty($idUtilisateur) && !ctype_space($idUtilisateur)) {
						if (!empty($idChambre) && !ctype_space($idChambre)) {
							if (!empty($dateDebut) && !ctype_space($dateDebut)) {
								if(!empty($dateFin) && !ctype_space($dateFin)){
									if (DateTime::createFromFormat('Y-m-d', $dateDebut) !== false && DateTime::createFromFormat('Y-m-d', $dateFin) !== false) {
										$data = array(
											'idReservation' => $idReservation,
											'idUtilisateur' => $idUtilisateur,
											'idChambre'     => $idChambre,
											'dateDebut'     => $dateDebut,
											'dateFin'       => $dateFin,
											'annulee'       => null
										);
										$testSaveReservation= ModelReservation::update_gen($data, 'idReservation');
										if ($testSaveReservation) {
											$message = '<div class="alert alert-success">La réservation a bien été modifiée !</div>';
											self::news($message);
											exit(); // On ne veut pas que le code self::manageReservation s'exécute :)
										} else {
											$message = '<div class="alert alert-danger">Merci de contacter le support de MyGuestHouse !</div>';
										}
									} else {
										$message = '<div class="alert alert-danger">Vous devez saisir un date d\'actualité au format jj/mm/aaaa</div>';
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

		public static function manageReservation($message = NULL){ // IN PROGRESS
			if(isset($_GET['type'])) {
				$type = $_GET['type'];
				if($type == "add" || $type == "edit") {
					if($type == "add") {
						$titreAction = 'Ajouter une reservation';
					} elseif($type == "edit") {
						$titreAction = 'Modifier une reservation';
						if(isset($_GET['idReservation']) && !empty($_GET['idReservation'])) {
							$idReservation = htmlspecialchars($_GET['idReservation']);
							$readReservation = ModelReservation::select($idReservation);
							if(!$readReservation) {
								self::reservations('<div class="alert alert-danger">Impossible de modifier cette reservation, elle n\'existe pas !</div>');
							}
						} else {
							self::reservations('<div class="alert alert-danger">Pour pouvoir modifier une reservation il faut son ID</div>');
						}
					}
					$powerNeeded = self::isAdmin();
					$view = 'manageReservation';
					$template = 'admin';
					$tab_news = ModelReservation::selectAll();
					$pagetitle = 'Administration - '.$titreAction;
					require_once File::build_path(array("view", "main_view.php"));
				} else {
					ControllerDefault::error('Vous devez préciser si vous souhaitez modifier ou ajouter une reservation !', 'admin');
				}
			} else {
				ControllerDefault::error('Il faut préciser un paramètre de type de gestion de reservations !', 'admin');
			}
		}
	}
?>