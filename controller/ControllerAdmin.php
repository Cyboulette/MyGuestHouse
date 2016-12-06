<?php
require_once File::build_path(array('model', 'ModelUtilisateur.php'));
require_once File::build_path(array('model', 'ModelChambre.php'));


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

	// Gestion des réservations : view/amin/viewAllReservation.php
	public static function displayAllReservation(){
		if(ControllerUtilisateur::isConnected()) {
			$currentUser = ModelUtilisateur::selectCustom('idUtilisateur', $_SESSION['idUser'])[0];
			$powerNeeded = ($currentUser->getPower() == Conf::$power['admin']);

			$powerNeeded = true;
			$view = 'viewAllReservation';
			$pagetitle = 'Administration - Gestion des réservation';
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

	// Affiche la liste des chambres : view/amin/listChambres.php
	public static function chambres() {
		if(ControllerUtilisateur::isConnected()) {
			$currentUser = ModelUtilisateur::selectCustom('idUtilisateur', $_SESSION['idUser'])[0];
			$powerNeeded = ($currentUser->getPower() == Conf::$power['admin']);

			$powerNeeded = true;
			$view = 'listChambres';
			$pagetitle = 'Administration - Liste des chambres';
			$template = 'admin';
			$tab_chambres = ModelChambre::selectAll();
			require_once File::build_path(array("view","main_view.php"));
		} else {
			ControllerDefault::error('Vous ne pouvez pas accéder à cette page sans être connecté !');
		}
	}

	public static function editChambre() {
		// Attend un $_GET['idChambre']
		if(ControllerUtilisateur::isConnected()) {
			if(isset($_GET['idChambre'])){
				$chambre = ModelChambre::select($_GET['idChambre']);
				if ($chambre!=false) {
					$currentUser = ModelUtilisateur::selectCustom('idUtilisateur', $_SESSION['idUser'])[0];
					$powerNeeded = ($currentUser->getPower() == Conf::$power['admin']);



					$powerNeeded = true;
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

	public static function deleteChambre() {
		// Attend un $_GET['idChambre']
	}

	public static function managePrestations() {
		// Attend un $_GET['idChambre']
	}

	public static function manageDetails() {
		// Attend un $_GET['idChambre']
	}

	// Gestion des utilisateurs : view/admin/viewAllUtilisateur.php
	public static function utilisateur(){
		if(ControllerUtilisateur::isConnected()) {
			$currentUser = ModelUtilisateur::selectCustom('idUtilisateur', $_SESSION['idUser'])[0];
			$powerNeeded = ($currentUser->getPower() == Conf::$power['admin']);

			$powerNeeded = true;
			$view = 'utilisateur';
			$pagetitle = 'Administration - Gestion des utilisateurs';
			$template = 'admin';

			$tab_v = ModelUtilisateur::selectAll();

			require_once File::build_path(array("view", "main_view.php"));

		} else {
			ControllerDefault::error('Vous ne pouvez pas accéder à cette page sans être connecté !');
		}
	}
}
?>