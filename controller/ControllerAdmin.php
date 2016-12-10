<?php
require_once File::build_path(array('model', 'ModelUtilisateur.php'));
require_once File::build_path(array('model', 'ModelChambre.php'));
require_once File::build_path(array('model', 'ModelOption.php'));
require_once File::build_path(array('model', 'ModelReservation.php'));
require_once File::build_path(array('model', 'ModelPrestation.php'));
require_once File::build_path(array('model', 'ModelNews.php'));

class ControllerAdmin {
	protected static $object = 'admin';

	public static function isAdmin() {
		if(ControllerUtilisateur::isConnected()) {
			$currentUser = ModelUtilisateur::selectCustom('idUtilisateur', $_SESSION['idUser'])[0];
			if($currentUser->getPower() != Conf::$power['admin']) {
				ControllerDefault::error('Vous ne possédez pas les droits pour accéder à cette page !');
				exit();
			} else {
				return true;
			}
		} else {
			ControllerDefault::error('Vous devez être connecté pour accéder à l\'administration');
			exit();
		}
	}

	// Charge l'index de l'administration
	public static function index() {
		$powerNeeded = self::isAdmin();
		$view = 'index';
		$pagetitle = 'Administration';
		$template = 'admin';
		require File::build_path(array('view', 'main_view.php'));
	}


	// Gestion des utilisateurs : view/admin/viewAllUtilisateur.php
	public static function displayAllUtilisateur(){
		$powerNeeded = self::isAdmin();
		$view = 'viewAllUtilisateur';
		$pagetitle = 'Administration - Gestion des utilisateurs';
		$template = 'admin';
		$tab_v = ModelUtilisateur::selectAll();
		require_once File::build_path(array("view", "main_view.php"));
	}

	// Gestion des réservations : view/amin/viewAllReservation.php
	public static function reservations(){
		$powerNeeded = self::isAdmin();
		$view = 'viewAllReservation';
		$pagetitle = 'Administration - Gestion des réservations';
		$template = 'admin';

		// appel des methodes de selection
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

	// Modifie l'url de la photo d'une chambre
	public static function update_url(){
		$powerNeeded = self::isAdmin();
		$view = 'displayChambre';
		$pagetitle = 'detail de la chambre';
		$template = 'admin';
		require_once File::build_path(array("view", "main_view.php"));
	}

	// OPTIONS -----------------------------------------------

	public static function options($message = NULL) {
		$powerNeeded = self::isAdmin();
		$view = 'listOptions';
		$pagetitle = 'Administration - Options du site';
		$template = 'admin';
		$tab_options = ModelOption::selectAll();
		require_once File::build_path(array("view","main_view.php"));
	}

	public static function updateOptions() {
		$powerNeeded = self::isAdmin();
		if(isset($_POST['name_site'],$_POST['display_news'],$_POST['theme'])) {
			$name_site = strip_tags($_POST['name_site']);
			$display_news = strip_tags($_POST['display_news']);
			$theme = strip_tags($_POST['theme']);
			$vars = array(
				'nom_site' => $name_site,
				'display_news' => $display_news,
				'theme' => $theme
			);
			foreach ($vars as $var => $value) {
				$data = array(
					'valueOption' => $value,
					'nameOption' => $var
				);
				$update = ModelOption::update_gen($data, 'nameOption');
			}
			if($update != false) {
				$message = '<div class="alert alert-success">Options modifiées avec succès !</div>';
			} else {
				$message = '<div class="alert alert-danger">Impossible de modifier l\'option !</div>';
			}
		} else {
			$message = '<div class="alert alert-danger">Merci d\'envoyer toutes les données du formulaire !</div>';
		}
		self::options($message);
	}


	
	// UTILISATEURS -----------------------------------------------

	// Gestion des utilisateurs : view/admin/viewAllUtilisateur.php
	public static function utilisateur(){// il faut mettre utilisateurs ... avec un s /!\
		if(ControllerUtilisateur::isConnected()) {
			$currentUser = ModelUtilisateur::selectCustom('idUtilisateur', $_SESSION['idUser'])[0];
			$powerNeeded = ($currentUser->getPower() == Conf::$power['admin']);

			$view = 'utilisateur';
			$pagetitle = 'Administration - Gestion des utilisateurs';
			$template = 'admin';

			$tab_v = ModelUtilisateur::selectAll();

			require_once File::build_path(array("view", "main_view.php"));

		} else {
			ControllerDefault::error('Vous ne pouvez pas accéder à cette page sans être connecté !');
		}
	}

	

	// CHAMBRES -----------------------------------------------

	// Affiche la liste des chambres : view/amin/listChambres.php
	public static function chambres($message = null) {
		$powerNeeded = self::isAdmin();
		//----------
		$view = 'listChambres';
		$pagetitle = 'Administration - Liste des chambres';
		$template = 'admin';
		$tab_chambres = ModelChambre::selectAll();
		require_once File::build_path(array("view","main_view.php"));
	}

	public static function deleteChambre() {
		// Attend un $_GET['idChambre']
	}

	public static function editChambre() {
		// Attend un $_GET['idChambre']
		if(ControllerUtilisateur::isConnected()) {
			if(isset($_GET['idChambre'])){
				$chambre = ModelChambre::select($_GET['idChambre']);
				if ($chambre!=false) {
					$currentUser = ModelUtilisateur::selectCustom('idUtilisateur', $_SESSION['idUser'])[0];
					$powerNeeded = ($currentUser->getPower() == Conf::$power['admin']);

					// $powerNeeded = true;
					$view = 'editChambre';
					$pagetitle = 'Administration - Editeur de chambre';
					$template = 'admin';
					require_once File::build_path(array("view", "main_view.php"));	
				}else{
					ControllerDefault::error(" ! ");// je ne sais pas quel error utiliser
				}
			}else{
				ControllerDefault::error("La chambre a modifier n'est pas specifiée ! ");
			}
		} else {
			ControllerDefault::error('Vous ne pouvez pas accéder à cette page sans être connecté !');
		}
	}

	

	// PRESTATIONS -----------------------------------------------	

	public static function prestations($message = null){
		$powerNeeded = self::isAdmin();
		//----------
		$view = 'listPrestations';
		$pagetitle = 'Administration - Options du site';
		$template = 'admin';

		$tab_allPrestation = ModelPrestation::selectAll();

		require_once File::build_path(array("view","main_view.php"));
	}

	public static function addPrestation(){
		$powerNeeded = self::isAdmin(); 
		//----------
		$view = 'addPrestation';
		$pagetitle = 'Administration - Ajout prestation';
		$template = 'admin';
		require_once File::build_path(array("view","main_view.php"));
	}

	public static function addedPrestation(){
		$powerNeeded = self::isAdmin();
		//----------
		if(isset($_POST['nomPrestation']) && isset($_POST['prix'])){
			if($_POST['nomPrestation']!=null && $_POST['prix']!=null){
				if($_POST['prix']>= 0){
					$laPrestation = array(
						'idPrestation' => null,
						'nomPrestation' => $_POST['nomPrestation'], 
						'prix' => $_POST['prix'],
					);

					$save = ModelPrestation::save($laPrestation);
					if($save != false) {
						$message = '<div class="alert alert-success">Prestation ajoutée avec succès !</div>';
					}else{
						$message = '<div class="alert alert-danger">Echec de l\'ajout de la prestation !</div>';
					}
				}else{
					$message = '<div class="alert alert-danger">Vous ne pouvez pas proposer un prix negatif !</div>';
				}	
			}else{
				$message = '<div class="alert alert-danger">vous ne pouvez pas laisser un champ vide !</div>';
			}
		}else{
			$message = '<div class="alert alert-danger">Nous navons pas pu recuperer vos choix !</div>';
		}
		self::prestations($message);
	}


	public static function editPrestation(){
		$powerNeeded = self::isAdmin();
		//----------
		if(isset($_GET['idPrestation']) && $_GET['idPrestation']!=null){
			$prestation = ModelPrestation::select($_GET['idPrestation']);
			if($prestation!=false){
				$view = 'editPrestation';
				$pagetitle = 'Administration - modifier ue prestation';
				$template = 'admin';

				require_once File::build_path(array("view", "main_view.php"));
			}else{
				$message = '<div class="alert alert-danger">cette prestation n\'existe plus !</div>';
				self::prestations($message);
			}
		}else{
			$message = '<div class="alert alert-danger">vous ne pouvez pas modifier une prestation sans connaitre son ID !</div>';
			self::prestations($message);
		}
	}

	public static function editedPrestation(){
		$powerNeeded = self::isAdmin();
		//----------
		if(isset($_POST['idPrestation']) && $_POST['idPrestation']!=null) {
			$prestation = ModelPrestation::select($_POST['idPrestation']);
			if($prestation!=false){
				if(isset($_POST['nomPrestation']) && isset($_POST['prix'])
					&& $_POST['nomPrestation']!=null && $_POST['prix']!=null){
					if($_POST['prix']>= 0){
						$id = $_POST['idPrestation'];
						$nom = $_POST['nomPrestation'];
						$prix = $_POST['prix'];

						$dataPrestation = array(
							'nomPrestation' => $nom,
							'prix' => $prix,
							'idPrestation' => $id,
						);

						$update = ModelPrestation::update_gen($dataPrestation, 'idPrestation');
						if($update != false) {
							$message = '<div class="alert alert-success">Prestation modifiée avec succès !</div>';
						} else {
							$message = '<div class="alert alert-danger">Echec de la modification de la prestation !</div>';
						}
					}else{
						$message = '<div class="alert alert-danger">Vous ne pouvez pas proposer un prix negatif !</div>';
					}
				}else{
					$message = '<div class="alert alert-danger">vous ne pouvez pas laisser un champ vide !</div>';
				}
			}else{
				$message = '<div class="alert alert-danger">cette prestation n\'existe plus !</div>';
			}
		}else{
			$message = '<div class="alert alert-danger">vous ne pouvez pas modifier une prestation sans connaître son ID !</div>';
		}
		self::prestations($message);
	}

	public static function managePrestations() {
		$powerNeeded = self::isAdmin();
		//----------
		if(isset($_GET['idChambre']) && $_GET['idChambre']!=NULL){
			$chambre = ModelChambre::select($_GET['idChambre']);
			if($chambre!=null){
				$view = 'prestationFor';
				$pagetitle = 'Administration - Editeur de chambre';
				$template = 'admin';

				$idChambre = $_GET['idChambre'];
				$tab_prestation = ModelPrestation::selectAllByChambre($_GET['idChambre']);
				$tab_allPrestation = ModelPrestation::selectAll();

				require_once File::build_path(array("view", "main_view.php"));
			}else{
				$message = '<div class="alert alert-danger">Cette chambre n\'existe plus !</div>';
				self::chambres($message);
			}
		}else{
			$message = '<div class="alert alert-danger">Vous ne pouvez modifier les prestations d\'une chambre sans connaître son ID !</div>';
			self::chambres($message);		
		}
	}

	public static function managedPrestation(){
		$powerNeeded = self::isAdmin();
		//----------
		if(isset($_POST['idChambre']) && $_POST['idChambre']!=null){
			$idChambre = $_POST['idChambre'];
			$prestation = $_POST['prestations'];
			$update = true;
			$update = ModelPrestation::deleteAllByChambre($idChambre); //TODO vérifier si true
			if ($prestation!=null) {
				foreach ($prestation as $key => $value) {
					$update = ModelPrestation::saveByChambre($idChambre, $prestation[$key]);
				}
			}

			if($update != false) {
				$message = '<div class="alert alert-success">Prestation modifiée avec succès !</div>';
			} else {
				$message = '<div class="alert alert-danger">Echec de la modification de la prestation !</div>';
			}	
		}else{
			$message = '<div class="alert alert-danger">Vous ne pouvez modifier les prestations d\'une chambre sans connaître son ID !</div>';		
		}
		self::chambres($message);
	}

	// DETAILS -----------------------------------------------	

	public static function manageDetails() {
		// Attend un $_GET['idChambre']
	}



	// NEWS -------------------------------------------------- 

	// Fonction qui permet de lister les news
	public static function news($message = NULL) {
		$powerNeeded = self::isAdmin();
		$view = 'listNews';
		$pagetitle = 'Administration - Gestion des news';
		$template = 'admin';
		$tab_news = ModelNews::selectAll();
		require_once File::build_path(array("view", "main_view.php"));
	}

	// Fonction qui permet de gérer les news (ajout ou modification)
	public static function manageNews($message = NULL) {
		if(isset($_GET['type'])) {
			$type = $_GET['type'];
			if($type == "add" || $type == "edit") {
				if($type == "add") {
					$titreAction = 'Ajouter une actualité';
				} elseif($type == "edit") {
					$titreAction = 'Modifier une actualité';
					if(isset($_GET['idNews']) && !empty($_GET['idNews'])) {
						$idNews = htmlspecialchars($_GET['idNews']);
						$readNews = ModelNews::select($idNews);
						if(!$readNews) {
							self::news('<div class="alert alert-danger">Impossible de modifier cette actualité, elle n\'existe pas !</div>');
						}
					} else {
						self::news('<div class="alert alert-danger">Pour pouvoir modifier une actualité il faut son ID</div>');
					}
				}
				$powerNeeded = self::isAdmin();
				$view = 'manageNews';
				$template = 'admin';
				$tab_news = ModelNews::selectAll();
				$pagetitle = 'Administration - '.$titreAction;
				require_once File::build_path(array("view", "main_view.php"));
			} else {
				ControllerDefault::error('Vous devez préciser si vous souhaitez modifier ou ajouter une news !', 'admin');
			}
		} else {
			ControllerDefault::error('Il faut préciser un paramètre de type de gestion de news !', 'admin');
		}
	}

	// Fonction qui permet de générer le formulaire final de suppression d'une news
	public static function deleteNewsForm() {
		self::isAdmin();
		$retour = array(); //Tableau de retour
		if(isset($_POST['idNews'])) {
			$idNews = htmlspecialchars($_POST['idNews']);
			$news = ModelNews::select($idNews);

			if($news != false) {
				$form = '<form method="POST" role="form" action="index.php?controller=admin&action=deleteNews">
					<div class="alert alert-info text-center">
						Confirmez vous la suppression de l\'actualité <b>'.htmlspecialchars($news->get('titreNews')).'</b> ?
					</div>

					<input type="hidden" name="idNews" value="'.$news->get('idNews').'">
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
				$retour['message'] = '<div class="alert alert-danger">L\'actualité demandée n\'existe pas !</div>';
			}
		} else {
			$retour['result'] = false;
			$retour['message'] = '<div class="alert alert-danger">Vous n\'avez pas envoyé correctement les données !</div>';
		}
		echo json_encode($retour);
	}

	// Fonction qui supprime une news
	public static function deleteNews() {
		self::isAdmin();
		if(isset($_POST['idNews'], $_POST['confirm'])) {
			$idNews = htmlspecialchars($_POST['idNews']);
			$confirm = htmlspecialchars($_POST['confirm']);
			$news = ModelNews::select($idNews);
			if($news) {
				if($confirm == true) {
					$checkDeleteNews = ModelNews::delete($news->get('idNews'));
					if($checkDeleteNews) {
						$message = '<div class="alert alert-success">L\'actualité a bien été supprimé !</div>';
					} else {
						$message = '<div class="alert alert-danger">Impossible de supprimer cette actualité !</div>';
					}
				} else {
					$message = '<div class="alert alert-danger">Vous devez confirmer la suppression !</div>';
				}
			} else {
				$message = '<div class="alert alert-danger">Cette actualité n\'existe pas</div>';
			}
		} else {
			$message = '<div class="alert alert-danger">Merci de remplir correctement le formulaire de suppression !</div>';
		}
		self::news($message);
	}

	// Fonction qui ajoute une news
	public static function addNews() {
		self::isAdmin();
		if(isset($_POST['titreNews'],$_POST['contenuNews'],$_POST['dateNews'],$_POST['etatNews'])) {
			$titreNews = htmlspecialchars($_POST['titreNews']);
			$contenuNews = nl2br(htmlspecialchars($_POST['contenuNews']));
			$dateNews = htmlspecialchars($_POST['dateNews']);
			$etatNews = htmlspecialchars($_POST['etatNews']);
			if(!empty($titreNews) && !ctype_space($titreNews)) {
				if(!empty($contenuNews) && !ctype_space($contenuNews)) {
					if(!empty($dateNews) && !ctype_space($dateNews)) {
						if(DateTime::createFromFormat('Y-m-d', $dateNews) !== false) {
							if($etatNews != 0 && $etatNews != 1) {
								$etatNews = 0; // On force la non-publication.
							}
							$data = array(
								'idNews' => NULL,
								'titreNews' => $titreNews,
								'contenuNews' => $contenuNews,
								'dateNews' => $dateNews,
								'etatNews' => $etatNews
							);
							$testSaveNews = ModelNews::save($data);
							if($testSaveNews) {
								$message = '<div class="alert alert-success">L\'actualité a bien été ajoutée !</div>';
								self::news($message);
								exit(); // On ne veut pas que le code self::manageNews s'exécute :)
							} else {
								$message = '<div class="alert alert-danger">Merci de contacter le support de MyGuestHouse !</div>';
							}
						} else {
							$message = '<div class="alert alert-danger">Vous devez saisir un date d\'actualité au format jj/mm/aaaa</div>';
						}
					} else {
						$message = '<div class="alert alert-danger">Vous devez saisir une date d\'actualité non vide</div>';
					}
				} else {
					$message = '<div class="alert alert-danger">Vous devez saisir un contenu d\'actualité non vide</div>';
				}
			} else {
				$message = '<div class="alert alert-danger">Vous devez saisir un titre d\'actualité non vide</div>';
			}
		}
		self::manageNews($message);
	}

	public static function editNews() {
		self::isAdmin();
		if(isset($_POST['idNews'], $_POST['titreNews'],$_POST['contenuNews'],$_POST['dateNews'],$_POST['etatNews'])) {
			$idNews = htmlspecialchars($_POST['idNews']);
			$titreNews = htmlspecialchars($_POST['titreNews']);
			$contenuNews = nl2br(htmlspecialchars($_POST['contenuNews']));
			$dateNews = htmlspecialchars($_POST['dateNews']);
			$etatNews = htmlspecialchars($_POST['etatNews']);
			$checkNews = ModelNews::select($idNews);
			if($checkNews) {
				if(!empty($titreNews) && !ctype_space($titreNews)) {
					if(!empty($contenuNews) && !ctype_space($contenuNews)) {
						if(!empty($dateNews) && !ctype_space($dateNews)) {
							if(DateTime::createFromFormat('Y-m-d', $dateNews) !== false) {
								$etatNews = intval($etatNews);
								if($etatNews != 0 && $etatNews != 1) {
									$etatNews = 0; // On force la non-publication.
								}
								$data = array(
									'idNews' => $idNews,
									'titreNews' => $titreNews,
									'contenuNews' => $contenuNews,
									'dateNews' => $dateNews,
									'publie' => $etatNews
								);
								$testSaveNews = ModelNews::update_gen($data, 'idNews');
								if($testSaveNews) {
									$message = '<div class="alert alert-success">L\'actualité a bien été modifiée !</div>';
									self::news($message);
									exit(); // On ne veut pas que le code self::manageNews s'exécute :)
								} else {
									$message = '<div class="alert alert-danger">Merci de contacter le support de MyGuestHouse !</div>';
								}
							} else {
								$message = '<div class="alert alert-danger">Vous devez saisir un date d\'actualité au format jj/mm/aaaa</div>';
							}
						} else {
							$message = '<div class="alert alert-danger">Vous devez saisir une date d\'actualité non vide</div>';
						}
					} else {
						$message = '<div class="alert alert-danger">Vous devez saisir un contenu d\'actualité non vide</div>';
					}
				} else {
					$message = '<div class="alert alert-danger">Vous devez saisir un titre d\'actualité non vide</div>';
				}
			} else {
				$message = '<div class="alert alert-danger">L\'actualité que vous tentez de modifier n\'existe pas</div>';
			}
		}
		self::manageNews($message);
	}
}
?>