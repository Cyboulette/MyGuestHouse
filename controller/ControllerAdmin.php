<?php
require_once File::build_path(array('model', 'ModelUtilisateur.php'));
require_once File::build_path(array('model', 'ModelChambre.php'));
require_once File::build_path(array('model', 'ModelOption.php'));
require_once File::build_path(array('model', 'ModelReservation.php'));
require_once File::build_path(array('model', 'ModelPrestation.php'));

class ControllerAdmin {
	protected static $object = 'admin';

	// Charge l'index de l'administration
	public static function index() {
		if(ControllerUtilisateur::isConnected()) {
			$currentUser = ModelUtilisateur::selectCustom('idUtilisateur', $_SESSION['idUser'])[0];
			$powerNeeded = ($currentUser->getPower() == Conf::$power['admin']);
			$view = 'index';
			$pagetitle = 'Administration';
			$template = 'admin';
			require File::build_path(array('view', 'main_view.php'));
		} else {
			ControllerDefault::error('Vous ne pouvez pas accéder à cette page sans être connecté !');
		}
	}

	// Gestion des chambres : view/admin/viewAllChambre.php
	public static function displayAllChambre(){
		if(ControllerUtilisateur::isConnected()) {
			$currentUser = ModelUtilisateur::selectCustom('idUtilisateur', $_SESSION['idUser'])[0];
			$powerNeeded = ($currentUser->getPower() == Conf::$power['admin']);

			$powerNeeded = true;
			$view = 'viewAllChambre';
			$pagetitle = 'Administration - Gestion des chambres';
			$template = 'admin';
			$tab_v = ModelChambre::selectAll();
			require_once File::build_path(array("view", "main_view.php"));

		} else {
			ControllerDefault::error('Vous ne pouvez pas accéder à cette page sans être connecté !');
		}
	}

	// Gestion des utilisateurs : view/admin/viewAllUtilisateur.php
	public static function displayAllUtilisateur(){
		if(ControllerUtilisateur::isConnected()) {
			$currentUser = ModelUtilisateur::selectCustom('idUtilisateur', $_SESSION['idUser'])[0];
			$powerNeeded = ($currentUser->getPower() == Conf::$power['admin']);

			$powerNeeded = true;
			$view = 'viewAllUtilisateur';
			$pagetitle = 'Administration - Gestion des utilisateurs';
			$template = 'admin';
			$tab_v = ModelUtilisateur::selectAll();
			require_once File::build_path(array("view", "main_view.php"));

		} else {
			ControllerDefault::error('Vous ne pouvez pas accéder à cette page sans être connecté !');
		}
	}

	// Gestion des réservations : view/amin/viewAllReservation.php
	public static function reservations(){
		if(ControllerUtilisateur::isConnected()) {
			$currentUser = ModelUtilisateur::selectCustom('idUtilisateur', $_SESSION['idUser'])[0];
			$powerNeeded = ($currentUser->getPower() == Conf::$power['admin']);

			$view = 'viewAllReservation';
			$pagetitle = 'Administration - Gestion des réservations';
			$template = 'admin';
			require_once File::build_path(array("view", "main_view.php"));

		} else {
			ControllerDefault::error('Vous ne pouvez pas accéder à cette page sans être connecté !');
		}
	}

	// Modifie l'url de la photo d'une chambre
	public static function update_url(){
		if(ControllerUtilisateur::isConnected()) {
			$currentUser = ModelUtilisateur::selectCustom('idUtilisateur', $_SESSION['idUser'])[0];
			$powerNeeded = ($currentUser->getPower() == Conf::$power['admin']);

			$view = 'displayChambre';
			$pagetitle = 'detail de la chambre';
			$template = 'admin';
			require_once File::build_path(array("view", "main_view.php"));

		} else {
			ControllerDefault::error('Vous ne pouvez pas accéder à cette page sans être connecté !');
		}
	}

	

	

	// OPTIONS -----------------------------------------------

	public static function options($message = NULL) {
		if(ControllerUtilisateur::isConnected()) {
			$currentUser = ModelUtilisateur::selectCustom('idUtilisateur', $_SESSION['idUser'])[0];
			$powerNeeded = ($currentUser->getPower() == Conf::$power['admin']);

			$view = 'listOptions';
			$pagetitle = 'Administration - Options du site';
			$template = 'admin';
			$tab_options = ModelOption::selectAll();
			require_once File::build_path(array("view","main_view.php"));
		} else {
			ControllerDefault::error('Vous nde pouvez pas accéder à cette page sans être connecté !');
		}
	}

	public static function updateOptions() {
		if(ControllerUtilisateur::isConnected()) {
			$currentUser = ModelUtilisateur::selectCustom('idUtilisateur', $_SESSION['idUser'])[0];
			$powerNeeded = ($currentUser->getPower() == Conf::$power['admin']);
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
		} else {
			ControllerDefault::error('Vous nde pouvez pas accéder à cette page sans être connecté !');
		}
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
	public static function chambres() {
		if(ControllerUtilisateur::isConnected()) {
			$currentUser = ModelUtilisateur::selectCustom('idUtilisateur', $_SESSION['idUser'])[0];
			$powerNeeded = ($currentUser->getPower() == Conf::$power['admin']);

			$view = 'listChambres';
			$pagetitle = 'Administration - Liste des chambres';
			$template = 'admin';
			$tab_chambres = ModelChambre::selectAll();
			require_once File::build_path(array("view","main_view.php"));
		} else {
			ControllerDefault::error('Vous ne pouvez pas accéder à cette page sans être connecté !');
		}
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

	public static function prestations(){
		if(ControllerUtilisateur::isConnected()) {
			$currentUser = ModelUtilisateur::selectCustom('idUtilisateur', $_SESSION['idUser'])[0];
			$powerNeeded = ($currentUser->getPower() == Conf::$power['admin']);

			$view = 'listPrestations';
			$pagetitle = 'Administration - Options du site';
			$template = 'admin';
			$tab_options = ModelOption::selectAll();

			$tab_allPrestation = ModelPrestation::selectAll();

			require_once File::build_path(array("view","main_view.php"));
		} else {
			ControllerDefault::error('Vous nde pouvez pas accéder à cette page sans être connecté !');
		}
	}

	public static function addPrestation(){
		
	}

	public static function editPrestation(){
		// Attend un $_GET['idPrestation']
	}

	public static function managePrestations() {
		// Attend un $_GET['idChambre']
		if(ControllerUtilisateur::isConnected()) {
			if(isset($_GET['idChambre'])){
				$chambre = ModelChambre::select($_GET['idChambre']);
				if ($chambre!=false) {
					$currentUser = ModelUtilisateur::selectCustom('idUtilisateur', $_SESSION['idUser'])[0];
					$powerNeeded = ($currentUser->getPower() == Conf::$power['admin']);

					$view = 'prestationFor';
					$pagetitle = 'Administration - Editeur de chambre';
					$template = 'admin';

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



	// DETAILS -----------------------------------------------	

	public static function manageDetails() {
		// Attend un $_GET['idChambre']
	}
}
?>