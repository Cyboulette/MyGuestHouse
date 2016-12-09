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

	// Gestion des chambres : view/admin/viewAllChambre.php
	public static function displayAllChambre(){
		$powerNeeded = self::isAdmin();
		$view = 'viewAllChambre';
		$pagetitle = 'Administration - Gestion des chambres';
		$template = 'admin';
		$tab_v = ModelChambre::selectAll();
		require_once File::build_path(array("view", "main_view.php"));
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
		if(ControllerUtilisateur::isConnected()) {
			$currentUser = ModelUtilisateur::selectCustom('idUtilisateur', $_SESSION['idUser'])[0];
			$powerNeeded = ($currentUser->getPower() == Conf::$power['admin']);

			$view = 'listPrestations';
			$pagetitle = 'Administration - Options du site';
			$template = 'admin';

			$tab_allPrestation = ModelPrestation::selectAll();

			require_once File::build_path(array("view","main_view.php"));
		} else {
			ControllerDefault::error('Vous ne pouvez pas accéder à cette page sans être connecté !');
		}
	}

	public static function addPrestation(){
		if(ControllerUtilisateur::isConnected()) {
			$currentUser = ModelUtilisateur::selectCustom('idUtilisateur', $_SESSION['idUser'])[0];
			$powerNeeded = ($currentUser->getPower() == Conf::$power['admin']);

			$view = 'addPrestation';
			$pagetitle = 'Administration - Ajout prestation';
			$template = 'admin';

			require_once File::build_path(array("view","main_view.php"));
		} else {
			ControllerDefault::error('Vous ne pouvez pas accéder à cette page sans être connecté !');
		}
	}

	public static function addedPrestation(){
		if(ControllerUtilisateur::isConnected()) {
			$currentUser = ModelUtilisateur::selectCustom('idUtilisateur', $_SESSION['idUser'])[0];
			$powerNeeded = ($currentUser->getPower() == Conf::$power['admin']);

			

		} else {
			ControllerDefault::error('Vous ne pouvez pas accéder à cette page sans être connecté !');
		}
	}

	public static function editPrestation(){
		// Attend un $_GET['idPrestation']
		if(ControllerUtilisateur::isConnected()) {
			if(isset($_GET['idPrestation'])){
				$prestation = ModelPrestation::select($_GET['idPrestation']);
				if ($prestation!=false) {
					$currentUser = ModelUtilisateur::selectCustom('idUtilisateur', $_SESSION['idUser'])[0];
					$powerNeeded = ($currentUser->getPower() == Conf::$power['admin']);

					$view = 'editPrestation';
					$pagetitle = 'Administration - modifier ue prestation';
					$template = 'admin';

					require_once File::build_path(array("view", "main_view.php"));	
				}else{
					ControllerDefault::error(" ! ");// je ne sais pas quel error utiliser
				}
			}else{
				ControllerDefault::error("La prestation a modifier n'est pas specifiée ! ");
			}
		} else {
			ControllerDefault::error('Vous ne pouvez pas accéder à cette page sans être connecté !');
		}
	}

	public static function editedPrestation(){
		// Attend un $_GET['idPrestation']
		if(ControllerUtilisateur::isConnected()) {
			if(isset($_POST['idPrestation']) && isset($_POST['nomPrestation']) && $_POST['prix']
				&& $_POST['idPrestation']!=null && $_POST['nomPrestation'] && $_POST['prix']){

				$prestation = ModelPrestation::select($_POST['idPrestation']);

				if ($prestation!=false) {
					$currentUser = ModelUtilisateur::selectCustom('idUtilisateur', $_SESSION['idUser'])[0];
					$powerNeeded = ($currentUser->getPower() == Conf::$power['admin']);

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
					self::prestations($message);
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

	public static function managePrestations() {
		// Attend un $_GET['idChambre']
		if(ControllerUtilisateur::isConnected()) {
			if(isset($_GET['idChambre']) && $_GET['idChambre']!=NULL){
				$chambre = ModelChambre::select($_GET['idChambre']);
				if ($chambre!=false) {
					$currentUser = ModelUtilisateur::selectCustom('idUtilisateur', $_SESSION['idUser'])[0];
					$powerNeeded = ($currentUser->getPower() == Conf::$power['admin']);

					$view = 'prestationFor';
					$pagetitle = 'Administration - Editeur de chambre';
					$template = 'admin';

					$idChambre = $_GET['idChambre'];
					$tab_prestation = ModelPrestation::selectAllByChambre($_GET['idChambre']);
					$tab_allPrestation = ModelPrestation::selectAll();

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

	public static function managedPrestation(){
		// Attend un $_GET['idChambre'] && $_GET['checkbox'] = array()
		// DO supprimer toutes les prestations de la chambre
		// TODO ajouter l'array() à la chambre (avec foreach)
		if(ControllerUtilisateur::isConnected()) {
			if(isset($_POST['idChambre'])){
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
				self::chambres($message);
			}else{
				ControllerDefault::error("La chambre a modifier n'est pas specifiée ! ");
			}
		}else{
			ControllerDefault::error('Vous ne pouvez pas accéder à cette page sans être connecté !');
		}
	}

	// DETAILS -----------------------------------------------	

	public static function manageDetails() {
		// Attend un $_GET['idChambre']
	}

	// NEWS 

	public static function news() {
		$powerNeeded = self::isAdmin();
		$view = 'listNews';
		$pagetitle = 'Administration - Gestion des news';
		$template = 'admin';
		$tab_news = ModelNews::selectAll();
		require_once File::build_path(array("view", "main_view.php"));
	}

	public static function addNews() {
		$powerNeeded = self::isAdmin();
		$view = 'addNews';
		$pagetitle = 'Administration - Ajouter une news';
		$template = 'admin';
		$tab_news = ModelNews::selectAll();
		require_once File::build_path(array("view", "main_view.php"));
	}
}
?>